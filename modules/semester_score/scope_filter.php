
<?php
//$Id:  $
include "config.php";
include "../../include/sfs_case_score.php";

//�{��
sfs_check();

//���զ��X�Ӧ~��
$all_years=($IS_JHORES==0)?6:3;


if (empty($_POST['year_seme'])) {
	$sel_year = curr_year(); //�ثe�Ǧ~
	$sel_seme = curr_seme(); //�ثe�Ǵ�
	$seme_year_seme=sprintf('%03d',$sel_year).$sel_seme;
} else {
	$seme_year_seme=$_POST['year_seme'];
	$sel_year=substr($_POST['year_seme'],0,3);
	$sel_seme=substr($_POST['year_seme'],3,1);
}

$class_seme_p = get_class_seme(); //�Ǧ~��

//�~�ŧO, ��p�@,�G�~�ťu�����ӻ��
$year_name=$_POST['year_name'];

 		if($year_name>2){
			$ss_link=array("�y��-����y��"=>"chinese","�y��-�m�g�y��"=>"local","�y��-�^�y"=>"english","�ƾ�"=>"math","�۵M�P�ͬ����"=>"nature","���|"=>"social","���d�P��|"=>"health","���N�P�H��"=>"art","��X����"=>"complex");
			$link_ss=array("chinese"=>"�y��-����y��","local"=>"�y��-�m�g�y��","english"=>"�y��-�^�y","math"=>"�ƾ�","nature"=>"�۵M�P�ͬ����","social"=>"���|","health"=>"���d�P��|","art"=>"���N�P�H��","complex"=>"��X����");
			$area_rowspan=9;
		} else {
			$ss_link=array("�y��-����y��"=>"chinese","�y��-�m�g�y��"=>"local","�y��-�^�y"=>"english","�ƾ�"=>"math","���d�P��|"=>"health","�ͬ�"=>"life","��X����"=>"complex");
			$link_ss=array("chinese"=>"�y��-����y��","local"=>"�y��-�m�g�y��","english"=>"�y��-�^�y","math"=>"�ƾ�","health"=>"���d�P��|","life"=>"�ͬ�","complex"=>"��X����");
			$area_rowspan=7;
		} 	



//POST��}�l�z�� �Ĥ@��
if ($_POST['search_mode']==1) {	
	//�wPOST�� subject ��� ======================================
	foreach ($_POST['year_name'] as $k=>$v) {
  	$YEAR_NAME[$k]=$v;
	}
	//�wPOST�� subject ��� ======================================
	foreach ($_POST['subject'] as $k=>$v) {
  	$subject[$k]=$v;
	}
	//���覡
	foreach ($_POST['comp'] as $k=>$v) {
  	$comp[$k]=($v>0)?$v:0;
	}
	//���ƭ���
	foreach ($_POST['score'] as $k=>$v) {
  	$score[$k]=($v>0)?$v:0;
	}
	$_POST['filter_mode']=($_POST['filter_mode']=="")?"and":$_POST['filter_mode'];
}
  //============================================================
if ($_POST['act']=="Start1") {
//�̤Ŀ諸�~�� , ��Ū���W��
//����Z�ų]�w�̪��Z�ŦW��
	$class_base= class_base($seme_year_seme);
//foreach ($_POST['year_name'] as $year_name) {
  $query="select a.*,b.stud_name,b.stud_person_id,b.curr_class_num from stud_seme a left join stud_base b on a.student_sn=b.student_sn where a.seme_year_seme='$seme_year_seme' and a.seme_class like '$year_name%' and b.stud_study_cond in ('0','15') order by a.seme_class,a.seme_num";
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
		$student_data[$student_sn]['curr_class_num']=$res->fields['curr_class_num'];

		$res->MoveNext();
	}
//} // end foreach

	$semes[]=sprintf("%03d",$sel_year).$sel_seme;
	$show_year[]=$sel_year;
	$show_seme[]=$sel_seme;
	//�����즨�Z
	$fin_score=cal_fin_score($sn,$semes,"",array($sel_year,$sel_seme,$year_name),$percision);
  
  //�������]�����
  foreach ($student_data as $student_sn=>$chk_score) {
    $student_data[$student_sn]['chk']=0;
  }
  
  //AND �Ҧ�
  $STUD_COUNT=0;
  if ($_POST['filter_mode']=="and") {
   //�ˬd�Ҧ��ǥͪ��C�즨�Z   
   foreach ($student_data as $student_sn=>$chk_score) {
    $total_subject=0;  //�F���󪺬�ؼ�
    //�̤Ŀ����ˬd�ǥͪ����Z
   	foreach($_POST['subject'] as $k) {
   		//�j��Τp��
   	 	switch ($comp[$k]) {
    		case 1: //�j��ε����
          if ($fin_score[$student_sn][$k][$seme_year_seme]['score']>=$score[$k]) $total_subject++; 	  
    		break;
     		case 0: //�p��
     	    if ($fin_score[$student_sn][$k][$seme_year_seme]['score']<$score[$k]) $total_subject++;
    		break; 
    	} // end switch
   	} // end foreach $_POST['subject']
     if ($total_subject==count($_POST['subject'])) { $student_data[$student_sn]['chk']=1; $STUD_COUNT++; } //�n�����ͲŦX����
   } //end foreach $fin_score
  } // end if and
  
  //OR �Ҧ�
  if ($_POST['filter_mode']=="or") {
   //�ˬd�Ҧ��ǥͪ��C�즨�Z   
   foreach ($student_data as $student_sn=>$chk_score) {
    //�̤Ŀ����ˬd�ǥͪ����Z
   	foreach($_POST['subject'] as $k) {
   		//�j��Τp��
   	 	switch ($comp[$k]) {
    		case 1: //�j��ε����
          if ($fin_score[$student_sn][$k][$seme_year_seme]['score']>=$score[$k]) { $student_data[$student_sn]['chk']=1; $STUD_COUNT++;} 	  
    		break;
     		case 0: //�p��
     	    if ($fin_score[$student_sn][$k][$seme_year_seme]['score']<$score[$k]) { $student_data[$student_sn]['chk']=1; $STUD_COUNT++;}
    		break; 
    	} // end switch
   	} // end foreach $_POST['subject']
   } //end foreach $fin_score
  } // end if and
  
} // end if ($_POST['act']=="Start1")

//============================================================================================================================
if ($_POST['act']=="Start2") {
//�̤Ŀ諸�~�� , ��Ū���W��
//����Z�ų]�w�̪��Z�ŦW��
	$class_base= class_base($seme_year_seme);
//foreach ($_POST['year_name'] as $year_name) {
  //$query="select a.*,b.stud_name,b.stud_person_id,b.stud_addr_2,b.addr_zip from stud_seme a left join stud_base b on a.student_sn=b.student_sn where a.seme_year_seme='$seme_year_seme' and a.seme_class like '$year_name%' and b.stud_study_cond in ('0','15') order by a.seme_class,a.seme_num";
  $query="select a.*,b.stud_name,b.stud_person_id,b.curr_class_num,b.stud_addr_2,b.addr_zip,c.guardian_name from stud_seme a,stud_base b,stud_domicile c where a.student_sn=b.student_sn and b.student_sn=c.student_sn and a.seme_year_seme='$seme_year_seme' and a.seme_class like '$year_name%' and b.stud_study_cond in ('0','15') order by a.seme_class,a.seme_num";

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
		$student_data[$student_sn]['curr_class_num']=$res->fields['curr_class_num'];
		
		$student_data[$student_sn]['stud_addr_2']=$res->fields['stud_addr_2'];
		$student_data[$student_sn]['addr_zip']=$res->fields['addr_zip'];
		$student_data[$student_sn]['guardian_name']=$res->fields['guardian_name'];

		$res->MoveNext();
	}
//} // end foreach

	$semes[]=sprintf("%03d",$sel_year).$sel_seme;
	$show_year[]=$sel_year;
	$show_seme[]=$sel_seme;
	//�����즨�Z
	$fin_score=cal_fin_score($sn,$semes,"",array($sel_year,$sel_seme,$year_name),$percision);
  
  //�������]�����
  foreach ($student_data as $student_sn=>$chk_score) {
    $student_data[$student_sn]['chk']=0;
  }
  
  //�T�{���~�Ŧ��X�ӻ��
  $ALL_areas=$area_rowspan-2;
  $no_succ=$_POST['no_succ']; 
  $STUD_COUNT=0;  //�ŦX���ǥͼ�
  
   //�ˬd�Ҧ��ǥͪ��C�즨�Z   
   foreach ($student_data as $student_sn=>$chk_score) {
   	
       if ($no_succ<=$ALL_areas-$fin_score[$student_sn][succ]) { $student_data[$student_sn]['chk']=1; $STUD_COUNT++; } //�n�����ͲŦX����

   } //end foreach $fin_score
  
  
} // end if ($_POST['act']=="Start2")
//=================================================================================================================================
if($_POST['option1']=='CSV'){
	$filename=$seme_year_seme.'_'.$school_id.$school_long_name."�~�žǴ����Z�z��.csv";
	if ($year_name>2) {
	$csv_data="�Z��,�y��,�Ǹ�,�����Ҧr��,�m�W,�ثe�Z�Ůy��,����y��,�^��,���g�y��,�y�奭��,�ƾ�,�۵M�P�ͬ����,���|,���d�P��|,���N�P�H��,��X����,��쥭��,���@�H,�p���a�}\r\n";
		foreach($student_data as $student_sn=>$data) { 
			if ($data['chk']==1) {
		 	$csv_data.="{$data['class_name']},{$data['seme_num']},{$data['stud_id']},{$data['stud_person_id']},{$data['stud_name']},{$data['curr_class_num']},{$fin_score[$student_sn][chinese][$seme_year_seme][score]},{$fin_score[$student_sn][english][$seme_year_seme][score]},{$fin_score[$student_sn][local][$seme_year_seme][score]},{$fin_score[$student_sn][language][$seme_year_seme][score]},";
		 	$csv_data.="{$fin_score[$student_sn][math][$seme_year_seme][score]},{$fin_score[$student_sn][nature][$seme_year_seme][score]},{$fin_score[$student_sn][social][$seme_year_seme][score]},{$fin_score[$student_sn][health][$seme_year_seme][score]},{$fin_score[$student_sn][art][$seme_year_seme][score]},{$fin_score[$student_sn][complex][$seme_year_seme][score]},{$fin_score[$student_sn][avg][score]},";
		 	$csv_data.="{$data['guardian_name']},{$data['addr_zip']}{$data['stud_addr_2']}\r\n";
	  	}
		}
  } else {
   	$csv_data="�Z��,�y��,�Ǹ�,�����Ҧr��,�m�W,�ثe�Z�Ůy��,����y��,�^��,���g�y��,�y�奭��,�ƾ�,���d�P��|,�ͬ�,��X����,��쥭��,���@�H,�p���a�}\r\n";
		foreach($student_data as $student_sn=>$data) { 
			if ($data['chk']==1) {
		 	$csv_data.="{$data['class_name']},{$data['seme_num']},{$data['stud_id']},{$data['stud_person_id']},{$data['stud_name']},{$data['curr_class_num']},{$fin_score[$student_sn][chinese][$seme_year_seme][score]},{$fin_score[$student_sn][english][$seme_year_seme][score]},{$fin_score[$student_sn][local][$seme_year_seme][score]},{$fin_score[$student_sn][language][$seme_year_seme][score]},";
		 	$csv_data.="{$fin_score[$student_sn][math][$seme_year_seme][score]},{$fin_score[$student_sn][health][$seme_year_seme][score]},{$fin_score[$student_sn][life][$seme_year_seme][score]},{$fin_score[$student_sn][complex][$seme_year_seme][score]},{$fin_score[$student_sn][avg][score]},";
		 	$csv_data.="{$data['guardian_name']},{$data['addr_zip']}{$data['stud_addr_2']}\r\n";
	  	}
		}
  
  }
	header("Content-disposition: attachment; filename=$filename");
	header("Content-type: text/x-csv");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");
	echo $csv_data;
	exit;
}


//�]���n��X CSV ��, �ҥH���Y��Ƥ�����e�X , ��ƳB�z���A�B�z�e��
//�q�X����
head("�Ǵ����Z�W�U - �W��z��");

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
	<font color=blue>���п�ܾǴ��G</font>
  <select size="1" name="year_seme" onchange="document.myform.option1.value='';document.myform.submit()">
    <?php
    foreach ($class_seme_p as $k=>$v) {
    ?>
     <option value="<?php echo $k;?>"<?php if ($k==$seme_year_seme) echo " selected";?>><?php echo $v;?></option>
    <?php
    }
    ?>
  </select><br>
  <font color=blue>���п�ܿz�諸����G</font>
  <input type="radio" name="search_mode" value="1" onclick="document.myform.option1.value='';document.myform.submit();" <?php if ($_POST['search_mode']=="1") echo " checked";?>>��즨�Z 
  <input type="radio" name="search_mode" value="2" onclick="document.myform.option1.value='';document.myform.submit();" <?php if ($_POST['search_mode']=="2") echo " checked";?>>���F�зǪ��u����`�ơv
<?php	



if ($_POST['search_mode']==1) {	

?>
<br>
<font color=blue>���ФĿ�n�z��~�Ťλ��G</font>
<?php
  			for($i=1;$i<=$all_years;$i++) {
  				$Y=$i+$IS_JHORES;
  			 ?>
  			  <input type="radio" name="year_name" value="<?php echo $Y;?>"<?php if ($_POST['year_name']==$Y) echo " checked";?> onclick="document.myform.option1.value='';document.myform.submit();"><?php echo $school_kind_name[$Y]."��"; ?>
  			  <?php
  		  } // end for

 if (!$year_name)  exit();

if ($IS_JHORES==0) echo "<br>(���`�N! �z���p�C�~�Ů�, �ФŤĿ�u���|�v�M�u���N�P�H��v���)";

?>
<table border="1" style="border-collapse:collapse" bordercolor="#800000">
  <tr bgcolor="#FFCCFF">
  <td align="center">�Ŀ�</td>
  <td align="center">���O</td>
  <td align="center">���z�����</td>
	<td align="center">����</td>
 </tr>
 <?php
  foreach ($link_ss as $k=>$v) {
    $score[$k]=($score[$k]=="")?60:$score[$k];
    $v=str_replace("�m�g�y��","���g�y��",$v);
 ?>
  <tr id="<?php echo $k;?>" class="bg_noselect">
  <td align="center"><input type="checkbox" name="subject[<?php echo $k;?>]" value="<?php echo $k;?>"<?php if ($subject[$k]==$k) echo " checked";?> onclick="check_select_bg()"></td>
  <td><?php echo $v;?></td>
  <td><input type="radio" name="comp[<?php echo $k;?>]" value="1"<?php if ($comp[$k]==1) echo " checked";?>>�֡� <input type="radio" name="comp[<?php echo $k;?>]" value="0" <?php if ($comp[$k]==0) echo " checked";?>>��</td>
	<td><input type="text" name="score[<?php echo $k;?>]" value="<?php echo $score[$k];?>" size="5"></td>
 </tr>
 <?php
 } // end foreach
 ?> 
</table>
==> ��ض�������G<input type="radio" name="filter_mode" value="and"<?php if ($_POST['filter_mode']=="and") echo " checked";?>>AND<input type="radio" name="filter_mode" value="or"<?php if ($_POST['filter_mode']=="or") echo " checked";?>>OR
<input type="button" value="�}�l�z��" name="btn" onclick="document.myform.option1.value='';check_select()">
<?php 
  if ($STUD_COUNT>0) {
    ?>
    <input type="button" value="CSV��X" onclick="document.myform.act.value='Start1';document.myform.option1.value='CSV';document.myform.submit()">
    <?php
  }
} // end if search_mode==1


if ($_POST['search_mode']==2) {
	$no_succ=(isset($_POST['no_succ']))?$_POST['no_succ']:0;
	?>
	<br>
<font color=blue>���ФĿ�~�šG</font>
<?php 
  			for($i=1;$i<=$all_years;$i++) {
  				$Y=$i+$IS_JHORES;
  			 ?>
  			  <input type="radio" name="year_name" value="<?php echo $Y;?>"<?php if ($_POST['year_name']==$Y) echo " checked";?> onclick="document.myform.option1.value='';document.myform.submit();"><?php echo $school_kind_name[$Y]."��"; ?>
  			  <?php
  		  } // end for
  		?>
<?php
 if (!$year_name)  exit();
?>
<br><br>
 ����G�z��Ǵ����Z�� <input type="text" name="no_succ" value="<?php echo $_POST['no_succ'];?>" size="3">�ӻ��(�t)�H�W���F�ή�з�(60��)���ǥ͡C<br><br>
 
<input type="button" value="�}�l�z��" name="btn" onclick=" if (document.myform.no_succ.value>0) { document.myform.option1.value='';document.myform.act.value='Start2';document.myform.submit(); }">
<?php 
  if ($STUD_COUNT>0) {
    ?>
    <input type="button" value="CSV��X" onclick="document.myform.act.value='Start2';document.myform.option1.value='CSV';document.myform.submit()">
    <?php
  }


}	 // end if search_mode==2

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
$smarty->display("score_report_filter.tpl");
}

?>


<Script Language="JavaScript">
	
	check_select_bg();
	
   function check_select() {
     var start=0;
     var year_name=0;
     var i=0;
     while (i < document.myform.elements.length) {
       if (document.myform.elements[i].name.substr(0,7)=='subject') {
         if (document.myform.elements[i].checked==true) {
           start=1;
         }
       }
       if (document.myform.elements[i].name.substr(0,9)=='year_name') {
         if (document.myform.elements[i].checked==true) {
           year_name=1;
         }
       }
       i++;
     } // end while
     if (start==1 && year_name==1) {
     	document.myform.act.value="Start1";
     	document.myform.submit();
     } else {
     	if (year_name==0) alert ('���Ŀ�~��!');
      if (start==0) alert ('���Ŀ���!');
     }
   }
   
   function check_select_bg() {
   	var i=0;
     while (i < document.myform.elements.length) {
       if (document.myform.elements[i].name.substr(0,7)=='subject') {
       	   wl=document.myform.elements[i].name.length-9;
         	 w=document.myform.elements[i].name.substr(8,wl);
         if (document.myform.elements[i].checked==true) {
         	 document.getElementById(w).className = 'bg_select';           
         } else {
         	 document.getElementById(w).className = 'bg_noselect';           
         }
       }
       i++;
     } // end while
   }
 </Script>