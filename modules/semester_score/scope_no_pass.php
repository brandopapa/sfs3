
<?php
//$Id:
include "config.php";
include "../../include/sfs_case_score.php";

//�{��
sfs_check();

//���զ��X�Ӧ~��
$all_years=($IS_JHORES==0)?6:3;

	$sel_year = curr_year(); //�ثe�Ǧ~
	$sel_seme = curr_seme(); //�ثe�Ǵ�
	$seme_year_seme=sprintf('%03d',$sel_year).$sel_seme;

//���o�Ǯդ���]�w
$db_date=curr_year_seme_day($sel_year,$sel_seme);  //$db_date['start'] , $db_date['end'] , $db_date['st_start'] , $db_date['st_end']
$st_end_line=date("U",mktime(0,0,0,substr($db_date['st_end'],5,2),substr($db_date['st_end'],8,2),substr($db_date['st_end'],0,4)));
$now=date("U",mktime(0,0,0,substr(date("Y-m-d"),5,2),substr(date("Y-m-d"),8,2),substr(date("Y-m-d"),0,4)));

//�p��U�~�ŭn�έp���Ǵ�
$Year_scan=array();
for($i=1;$i<=$all_years;$i++) {
 $Y=$i+$IS_JHORES;
  switch ($IS_JHORES) {
  	case '0':
  	    if ($Y>1) {
  	     for ($j=$Y-1;$j>=1;$j--) {
  	      $chk_year=curr_year()-$j;
  	      $Year_scan[$Y].=",".$chk_year."1";
  	      $Year_scan[$Y].=",".$chk_year."2";
  	     }
  	    }
  	break;
  	case '6':
  	    if ($Y>7) {
  	     for ($j=$Y-1;$j>=7;$j--) {
  	      $chk_year=curr_year()-$j+6;
  	      $Year_scan[$Y].=",".$chk_year."1";
  	      $Year_scan[$Y].=",".$chk_year."2";
  	     }
  	    }
  	 
  	break;  
  }
  //�p�G�O�U�Ǵ��A�[1
 				if (curr_seme()==2) $Year_scan[$Y].=",".curr_year()."1";
 	//�p�G�w�L���~���A�[1
				if ($now>$st_end_line) $Year_scan[$Y].=",".curr_year().curr_seme();
	$Year_scan[$Y]=substr($Year_scan[$Y],1);
}  				


//�~�ŧO, ��p�@,�G�~�ťu�����ӻ��
$year_name=$_POST['year_name'];

 		if($year_name>2 and (curr_seme()==2 or $now>$st_end_line)){
			$ss_link=array("�y��-����y��"=>"chinese","�y��-�m�g�y��"=>"local","�y��-�^�y"=>"english","�ƾ�"=>"math","�۵M�P�ͬ����"=>"nature","���|"=>"social","���d�P��|"=>"health","���N�P�H��"=>"art","��X����"=>"complex");
			$link_ss=array("chinese"=>"�y��-����y��","local"=>"�y��-�m�g�y��","english"=>"�y��-�^�y","math"=>"�ƾ�","nature"=>"�۵M�P�ͬ����","social"=>"���|","health"=>"���d�P��|","art"=>"���N�P�H��","complex"=>"��X����");
			$area_rowspan=9;
		} else {
			$ss_link=array("�y��-����y��"=>"chinese","�y��-�m�g�y��"=>"local","�y��-�^�y"=>"english","�ƾ�"=>"math","���d�P��|"=>"health","�ͬ�"=>"life","��X����"=>"complex");
			$link_ss=array("chinese"=>"�y��-����y��","local"=>"�y��-�m�g�y��","english"=>"�y��-�^�y","math"=>"�ƾ�","health"=>"���d�P��|","life"=>"�ͬ�","complex"=>"��X����");
			$area_rowspan=7;
		} 	



//============================================================================================================================
if ($_POST['act']=="start") {
//�̤Ŀ諸�~�� , ��Ū���W��
//����Z�ų]�w�̪��Z�ŦW��
	$class_base= class_base($seme_year_seme);
//foreach ($_POST['year_name'] as $year_name) {
  //$query="select a.*,b.stud_name,b.stud_person_id,b.stud_addr_2,b.addr_zip from stud_seme a left join stud_base b on a.student_sn=b.student_sn where a.seme_year_seme='$seme_year_seme' and a.seme_class like '$year_name%' and b.stud_study_cond in ('0','15') order by a.seme_class,a.seme_num";
  $query="select a.*,b.stud_name,b.stud_person_id,c.guardian_name from stud_seme a,stud_base b,stud_domicile c where a.student_sn=b.student_sn and b.student_sn=c.student_sn and a.seme_year_seme='$seme_year_seme' and a.seme_class like '$year_name%' and b.stud_study_cond in ('0','15') order by a.seme_class,a.seme_num";

	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		$student_sn=$res->fields['student_sn'];
		$sn[]=$student_sn;
		$student_data[$student_sn]['seme_num']=$res->fields['seme_num'];
		$student_data[$student_sn]['stud_person_id']=$res->fields['stud_person_id'];
		$student_data[$student_sn]['stud_name']=$res->fields['stud_name'];
		$student_data[$student_sn]['stud_id']=$res->fields['stud_id'];
		$seme_class=$res->fields['seme_class'];
		$student_data[$student_sn]['class_name']=$class_base[$seme_class];
		
		//$student_data[$student_sn]['stud_addr_2']=$res->fields['stud_addr_2'];
		//$student_data[$student_sn]['addr_zip']=$res->fields['addr_zip'];
		//$student_data[$student_sn]['guardian_name']=$res->fields['guardian_name'];

		$res->MoveNext();
	}
//} // end foreach

	//$semes[]=sprintf("%03d",$sel_year).$sel_seme;
	$semes=explode(',',$Year_scan[$year_name]);
  
	$show_year[]=$sel_year;
	$show_seme[]=$sel_seme;
	//�����즨�Z
	//echo "start<br>";
	$fin_score=cal_fin_score($sn,$semes,"",array($sel_year,$sel_seme,$year_name),$percision);
	//echo "end<br>";
	//echo "<pre>";
//print_r($fin_score);
//print_r($student_data);
//echo "</pre>";
//exit();
  
  //�������]�����
  foreach ($student_data as $student_sn=>$chk_score) {
    $student_data[$student_sn]['chk']=0;
  }
  
  //�T�{���~�Ŧ��X�ӻ��
  $ALL_areas=$area_rowspan-2;
  //$no_succ=$_POST['no_succ']; 
  $STUD_COUNT=0;  //�ŦX���ǥͼ�
  
   //�ˬd�Ҧ��ǥͪ��C�즨�Z   
   foreach ($student_data as $student_sn=>$chk_score) {

       if ($fin_score[$student_sn][succ]<$ALL_areas) { //�Y���ܤ֤@�ӻ�줣�ή�A�h�L�X
			$student_data[$student_sn]['chk']=1; 
			$STUD_COUNT++; 
	   } 

   } //end foreach $fin_score
  
  
} // end if ($_POST['act']=="Start")
//=======================================================================================================
//�q�X����
head("�Ǵ����Z��즨�Z���ή�W��z��");

$tool_bar=&make_menu($menu_p);

//�C�X���
echo $tool_bar;

?>
<style>
 .bg_select { background-color:#FFFF00  }
 .bg_noselect { background-color:#FFFFFF  }
</style>
<form method="post" name="myform" action="<?php echo $_SERVER['php_self'];?>">
	<input type="hidden" name="act" value="">
	<input type="hidden" name="option1" value="">
	<font color=blue>���z��I��<?php echo curr_year();?>�Ǧ~�ײ�<?php echo curr_seme();?>�Ǵ���A�U��즨�Z���ή檺�W��G</font>
�@<br>
	<table border="1" width="600" style="border-collspae:collapse">
  	<tr bgcolor="#FFFFDD" style="color:#800000;font-size:10pt" >
  		<td>
  �ȦC�X�����ή��즨�Z���ǥͦW��C
		 </td>
		</tr>
	</table>
<br>
<font color=blue>���ФĿ�n�z�諸�~�šG</font><br>
<?php
  			for($i=1;$i<=$all_years;$i++) {
  				$Y=$i+$IS_JHORES;
  				if ($Year_scan[$Y]) {
  					
  				//$semes=($i-1)*2+1;
  			 ?>
  			  <input type="radio" name="year_name" value="<?php echo $Y;?>"<?php if ($_POST['year_name']==$Y) echo " checked";?> onclick="document.myform.act.value='';document.myform.option1.value='';document.myform.submit();"><?php echo $school_kind_name[$Y]."��"; ?>
  			  (�έp�N�� <?php echo $Year_scan[$Y];?> �Ǵ�������)
  			  <br>
  			  <?
  			  }
  		  } // end for

 if (!$year_name)  exit();
?>
<br>
<input type="button" value="�}�l�z��" name="btn" onclick="document.myform.act.value='start';check_select()">
<br><br>
<?php
 if ($_POST['act']=='') {
?>
<table border="1" width="500" style="border-collspae:collapse">
  <tr bgcolor="#000000" style="color:#FFFFCC">
  	<td>�`�N�I�ѩ󥻵{���B��ݭn�j�q�O����A�w��j���ǮաA�{�������@�b�i��|�o�ͤ��_���p�]�e���e�{�ťա^�A���ɽк��ޤH���վ� php.ini �� memory_limit ���]�w�ȡA�N�w�]�� 128MB �אּ 256MB �Y�i�C</td>
  </tr>
</table>
<?php 
 }
  if ($STUD_COUNT>0) {

    //echo '<input type="button" value="CSV��X" onclick="document.myform.act.value='start';document.myform.option1.value='CSV';document.myform.submit()">';
    
  }
  if(isset($student_data)){
  	echo '�H�U�C�X���ӻ�즨�Z���ή檺�ǥͦW��Ψ䦨�Z�A�@�p '.$STUD_COUNT.'��ǥ͡C';
  }	

?>
</form>
<?php
//�e���e�{
if ($STUD_COUNT>0) {
$smarty->assign("show_year",$show_year);
$smarty->assign("show_seme",$show_seme);
$smarty->assign("semes",$semes);
$smarty->assign("curr_seme",$semes[0]);
$smarty->assign("fin_score",$fin_score);
$smarty->assign("student_data_nor",$student_data_nor);
$smarty->assign("ss_link",$ss_link);
$smarty->assign("link_ss",$link_ss);
$smarty->assign("rule",$rule_all);
$smarty->assign("year_name",$year_name);
$smarty->assign("percision_radio",$percision_radio);
$smarty->assign("student_data",$student_data);
$smarty->assign("m_arr",$m_arr);
$smarty->assign("school_long_name",$school_long_name);
$smarty->display("score_report_no_pass.tpl");
}

?>


<Script Language="JavaScript">

   function check_select() {
     var year_name=0;
     var i=0;
     while (i < document.myform.elements.length) {
       
       if (document.myform.elements[i].name.substr(0,9)=='year_name') {
         if (document.myform.elements[i].checked==true) {
           year_name=1;
         }
       }
       i++;
     } // end while
     if (year_name==1) {
     	document.myform.submit();
     } else {
     	if (year_name==0) alert ('���Ŀ�~��!');
      
     }
   }
   
 </Script>
