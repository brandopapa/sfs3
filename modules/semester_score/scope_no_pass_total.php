<?php
//$Id:
include "config.php";
include "../../include/sfs_case_score.php";

//�{��
sfs_check();

//���զ��X�Ӧ~��
$all_years=($IS_JHORES==0)?6:3;
$curr_year=curr_year();

//���o�Ҧ��Ǵ����, �C�~����ӾǴ�
$class_seme_p = get_class_seme(); //�Ǧ~��	
$class_seme_p=array_reverse($class_seme_p,1);
$tool_bar=&make_menu($menu_p);

//�ثe��w�Ǵ�
if (isset($_POST['c_curr_seme'])) {
	$seme_year_seme=$_POST['c_curr_seme'];
	$sel_year=substr($seme_year_seme,0,3);
	$sel_seme=substr($seme_year_seme,-1);

//���o�Ǯդ���]�w
$db_date=curr_year_seme_day($sel_year,$sel_seme);  //$db_date['start'] , $db_date['end'] , $db_date['st_start'] , $db_date['st_end']
$st_end_line=date("U",mktime(0,0,0,substr($db_date['st_end'],5,2),substr($db_date['st_end'],8,2),substr($db_date['st_end'],0,4)));
$now=date("U",mktime(0,0,0,substr(date("Y-m-d"),5,2),substr(date("Y-m-d"),8,2),substr(date("Y-m-d"),0,4)));

//�p��U�~�ŭn�έp���Ǵ� �H 1001;1002;1011;1012.... ���Φ��ǤJ
$Year_scan=array();
for($i=1;$i<=$all_years;$i++) {
 $Y=$i+$IS_JHORES;
  switch ($IS_JHORES) {
  	case '0':
  	    if ($Y>1) {
  	     for ($j=$Y-1;$j>=1;$j--) {
  	      $chk_year=$sel_year-$j;
  	      $Year_scan[$Y].=",".$chk_year."1";
  	      $Year_scan[$Y].=",".$chk_year."2";
  	     }
  	    }
  	break;
  	case '6':
  	    if ($Y>7) {
  	     for ($j=$Y-1;$j>=7;$j--) {
  	      $chk_year=$sel_year-$j+6;
  	      $Year_scan[$Y].=",".$chk_year."1";
  	      $Year_scan[$Y].=",".$chk_year."2";
  	     }
  	    }
  	 
  	break;  
  }
  //�p�G�O�U�Ǵ��A�[1
 				if ($sel_seme==2) $Year_scan[$Y].=",".$sel_year."1";
 	//�p�G�w�L���~���A�[1
				if ($now>$st_end_line) $Year_scan[$Y].=",".$sel_year.$sel_seme;
	$Year_scan[$Y]=substr($Year_scan[$Y],1);
}  				



//============================================================================================================================
$Start_Year_Class=($IS_JHORES==0)?1:7;
$End_Year_Class=($IS_JHORES==0)?6:9;

//����Z�ų]�w�̪��Z�ŦW��
$class_base= class_base($seme_year_seme);
/*
echo "<pre>";
echo $Start_Year_Class."=>".$End_Year_Class;

exit();
*/

//�̦~�ťh���R ��p 1-6 , �ꤤ 7-9
for ($year_name=$Start_Year_Class;$year_name<=$End_Year_Class;$year_name++) {

//$year_name=8;

//�U�~�ŭn�ˬd���Ǵ��O $Year_scan[1]~$Year_scan[9]

//�~�ŧO, ��p�@,�G�~�ťu�����ӻ��
 		if($year_name>3 or ($year_name==3 and ($sel_seme==2 or $now>$st_end_line))){
			//$ss_link=array("�y��-����y��"=>"chinese","�y��-�m�g�y��"=>"local","�y��-�^�y"=>"english","�ƾ�"=>"math","�۵M�P�ͬ����"=>"nature","���|"=>"social","���d�P��|"=>"health","���N�P�H��"=>"art","��X����"=>"complex");
			//$link_ss=array("chinese"=>"�y��-����y��","local"=>"�y��-�m�g�y��","english"=>"�y��-�^�y","math"=>"�ƾ�","nature"=>"�۵M�P�ͬ����","social"=>"���|","health"=>"���d�P��|","art"=>"���N�P�H��","complex"=>"��X����");
			//$area_rowspan=9;
		  $ALL_areas=8;  //�n��@�B�G�~�Ůɥͬ�����i�h, �ҥH�O8 ��
		} else {
			//$ss_link=array("�y��-����y��"=>"chinese","�y��-�m�g�y��"=>"local","�y��-�^�y"=>"english","�ƾ�"=>"math","���d�P��|"=>"health","�ͬ�"=>"life","��X����"=>"complex");
			//$link_ss=array("chinese"=>"�y��-����y��","local"=>"�y��-�m�g�y��","english"=>"�y��-�^�y","math"=>"�ƾ�","health"=>"���d�P��|","life"=>"�ͬ�","complex"=>"��X����");
			//$area_rowspan=7;
		  $ALL_areas=5;
		} 	

  //�T�{���~�Ŧ��X�ӻ��
   if ($IS_JHORES==6) $ALL_areas=7;
  //$ALL_areas=$area_rowspan-2;

	//���ή���ƪ��H�Ʋέp
			$NO_PASS[$year_name][1]=0;
			$NO_PASS[$year_name][2]=0;
			$NO_PASS[$year_name][3]=0;
			$NO_PASS[$year_name][4]=0;
			$NO_PASS[$year_name][5]=0;
			$NO_PASS[$year_name][6]=0;
			$NO_PASS[$year_name][7]=0;

	//�U��줣�ή�H��
			$NO_PASS[$year_name][language]=0;
			$NO_PASS[$year_name][math]=0;
			$NO_PASS[$year_name][health]=0;
			$NO_PASS[$year_name][nature]=0;
			$NO_PASS[$year_name][art]=0;
			$NO_PASS[$year_name][social]=0;
			$NO_PASS[$year_name][life]=0;
			$NO_PASS[$year_name][complex]=0;


  //���X�W��
  $query="select a.*,b.stud_name,b.stud_person_id,c.guardian_name from stud_seme a,stud_base b,stud_domicile c where a.student_sn=b.student_sn and b.student_sn=c.student_sn and a.seme_year_seme='$seme_year_seme' and a.seme_class like '$year_name%' and b.stud_study_cond in ('0','5','15') order by a.seme_class,a.seme_num";
	$res=$CONN->Execute($query);
	
	//�ǥͤH��
	$Student_Num[$year_name]=$res->RecordCount();		
	
	if ($Year_scan[$year_name]!="") {
	
	$ALL_PASS[$year_name]=array(); //�ιL���ƪ��H�Ʋ֭p
	$sn=array();
	$student_data=array();
	$fin_score=array();
	while(!$res->EOF) {
		$student_sn=$res->fields['student_sn'];
		$sn[]=$student_sn;
		$student_data[$student_sn]['seme_num']=$res->fields['seme_num'];
		$student_data[$student_sn]['stud_person_id']=$res->fields['stud_person_id'];
		$student_data[$student_sn]['stud_name']=$res->fields['stud_name'];
		$student_data[$student_sn]['stud_id']=$res->fields['stud_id'];
		$seme_class=$res->fields['seme_class'];
		$student_data[$student_sn]['class_name']=$class_base[$seme_class];
		$res->MoveNext();
	}

	$semes=explode(',',$Year_scan[$year_name]);
  
	//�����즨�Z
	$fin_score=cal_fin_score($sn,$semes,"","",2);  //2015.12.09��
  

  //�ˬd�Ҧ��ǥͪ��C�즨�Z
   foreach ($student_data as $student_sn=>$chk_score) {
			
			
			//1�ӻ�줣�ή� , �Y�q�L���`��� -1 ,2�ӻ�줣�ή� , �Y�q�L���`��� -2 ....
			if ($fin_score[$student_sn][succ]==$ALL_areas-1) $NO_PASS[$year_name][1]++; 
			if ($fin_score[$student_sn][succ]==$ALL_areas-2) $NO_PASS[$year_name][2]++; 
			if ($fin_score[$student_sn][succ]==$ALL_areas-3) $NO_PASS[$year_name][3]++; 
			if ($fin_score[$student_sn][succ]==$ALL_areas-4) $NO_PASS[$year_name][4]++; 
			if ($fin_score[$student_sn][succ]==$ALL_areas-5) $NO_PASS[$year_name][5]++; 
		  if ($fin_score[$student_sn][succ]==$ALL_areas-6) $NO_PASS[$year_name][6]++; 
		  if ($fin_score[$student_sn][succ]==$ALL_areas-7) $NO_PASS[$year_name][7]++; 
		  if ($fin_score[$student_sn][succ]==$ALL_areas-8) $NO_PASS[$year_name][8]++;
		  
		  $SUCC=$fin_score[$student_sn][succ];
		  $ALL_PASS[$year_name][$SUCC]++;
		  
			//�y�夣�ή�
			if ($fin_score[$student_sn][language][avg][score]<60 and $fin_score[$student_sn][language][avg][score]>0) $NO_PASS[$year_name][language]++;
			//�ƾǤ��ή�
			if ($fin_score[$student_sn][math][avg][score]<60 and $fin_score[$student_sn][math][avg][score]>0) $NO_PASS[$year_name][math]++;
			//����
			if ($fin_score[$student_sn][health][avg][score]<60 and $fin_score[$student_sn][health][avg][score]>0) $NO_PASS[$year_name][health]++;
			
			//�T�~�ťH�W
      //if ($year_name>3) {
				//�۵M
				if ($fin_score[$student_sn][nature][avg][score]<60 and $fin_score[$student_sn][nature][avg][score]>0) $NO_PASS[$year_name][nature]++;
				//����
				if ($fin_score[$student_sn][art][avg][score]<60 and $fin_score[$student_sn][art][avg][score]>0) $NO_PASS[$year_name][art]++;
				//���|
				if ($fin_score[$student_sn][social][avg][score]<60 and $fin_score[$student_sn][social][avg][score]>0) $NO_PASS[$year_name][social]++;
      //} else { 
				//�ͬ� ��p�@�G�~��
				if ($fin_score[$student_sn][life][avg][score]<60 and $fin_score[$student_sn][life][avg][score]>0) $NO_PASS[$year_name][life]++;
			//}

			//��X
			if ($fin_score[$student_sn][complex][avg][score]<60 and $fin_score[$student_sn][complex][avg][score]>0) $NO_PASS[$year_name][complex]++;

   } //end foreach $fin_score
   
   } // end if $Year_scan

} // end for year_name
} // end if (isset($_POST['c_curr_seme']))
//=======================================================================================================
//�q�X����
head("�U��즨�Z���ή�H�Ʋέp��");

//�C�X���
echo $tool_bar;

?>
<form method="post" action="<?php $_SERVER['PHP_SELF'];?>" name="myform" id="myform" target="">
	<select id="select_year" name="c_curr_seme">
	<option style="color:#FF00FF">�п�ܾǴ�</option>
	<?php
	while (list($tid,$tname)=each($class_seme_p)){
	  if (substr($tid,0,3)>$curr_year-3) {
    ?>
      		<option value="<?php echo $tid;?>" <?php if ($tid==$_POST['c_curr_seme']) echo "selected";?>><?php echo $tname;?></option>
   <?php
      }
    } // end while
    ?>
</select>
</form>

<?php
if ($_POST['c_curr_seme']) {
?>
 
<br>
<table border='2' cellpadding='3' cellspacing='0' style='border-collapse:collapse; font-size:<?php echo $m_arr['text_size'];?>;' bordercolor='#111111' width='100%'>
	<tr>
		<td rowspan="2" align="center">�~��</td>
		<td colspan="9" align="center">�U�ǲ߻��ǥͦ��Z���q����</td>
		<td colspan="<?php echo (($IS_JHORES==6)?7:8);?>" align="center">�ǥͦ��Z���q���ή���Ʊ���</td>
		<td rowspan="2" align="center">�έp�Ǵ�</td>
	</tr>
	  <td>�Ӧ~���`�ǥͤH��</td>
	  <td>�y���줣�ή�H��</td>
	  <td>�ƾǻ�줣�ή�H��</td>
	  <td>���|��줣�ή�H��</td>
	  <td>�۵M�P�ͬ���޻�줣�ή�H��</td>
	  <td>���N�P�H���줣�ή�H��</td>
	  <td>���d�P��|��줣�ή�H��</td>
	  <td>��X���ʻ�줣�ή�H��</td>
	  <td>�ͬ���줣�ή�H��</td>
	  <td>1�Ӿǲ߻�줣�ή�H��</td>
	  <td>2�Ӿǲ߻�줣�ή�H��</td>
	  <td>3�Ӿǲ߻�줣�ή�H��</td>
	  <td>4�Ӿǲ߻�줣�ή�H��</td>
	  <td>5�Ӿǲ߻�줣�ή�H��</td>
	  <td>6�Ӿǲ߻�줣�ή�H��</td>
	  <td>7�Ӿǲ߻�줣�ή�H��</td>
	  <?php
	  if ($IS_JHORES==0) echo "<td>8�Ӿǲ߻�줣�ή�H��</td>";
	  ?>
	<tr>
 <?php
 //�̦~�ŦC�X�H��
 for ($year_name=$Start_Year_Class;$year_name<=$End_Year_Class;$year_name++) {
 ?>
 <tr>
 	<td align="center"><?php echo $year_name;?></td>
 	<td align="center"><?php echo $Student_Num[$year_name];?></td>
  <td align="center"><?php echo $NO_PASS[$year_name][language];?></td>
  <td align="center"><?php echo $NO_PASS[$year_name][math];?></td>
  <td align="center"><?php echo $NO_PASS[$year_name][social];?></td>
  <td align="center"><?php echo $NO_PASS[$year_name][nature];?></td>
  <td align="center"><?php echo $NO_PASS[$year_name][art];?></td>
  <td align="center"><?php echo $NO_PASS[$year_name][health];?></td>
  <td align="center"><?php echo $NO_PASS[$year_name][complex];?></td>
  <td align="center"><?php echo $NO_PASS[$year_name][life];?></td>
  <td align="center"><?php echo $NO_PASS[$year_name][1];?></td>
  <td align="center"><?php echo $NO_PASS[$year_name][2];?></td>
  <td align="center"><?php echo $NO_PASS[$year_name][3];?></td>
  <td align="center"><?php echo $NO_PASS[$year_name][4];?></td>
  <td align="center"><?php echo $NO_PASS[$year_name][5];?></td>
  <td align="center"><?php echo $NO_PASS[$year_name][6];?></td>
  <td align="center"><?php echo $NO_PASS[$year_name][7];?></td>
  <?php
	  if ($IS_JHORES==0) echo "<td align=\"center\">".$NO_PASS[$year_name][8]."</td>";
	  ?>
  <td><?php echo $Year_scan[$year_name];?></td>
 </tr>
 <?php 
 } // end for
 ?>	
</table>
<?php
} // end if
?>
<table border="0">
 <tr>
 	<td>�����G</td>
 </tr>
 <tr>
  <td>
�̾�103�~4��25��ץ��o���u����p�Ǥΰ�����Ǿǥͦ��Z���q�ǫh�v��9���W�w�A���ҥ��B�� (��)�F������C�Ǵ�������@�Ӥ뤺�˵����Ұ�����p�Ǿǥͤ����q���G�A�@����Ш|�F�����q�α��ʤ��ѾڡA�é�C�Ǧ~������G�Ӥ뤺�s�P�ɱϱоǹ�I���ĳ��Ш|���Ƭd�C
</td>
 </tr>
</table>
<div id="wait" style="display:none">
<p style="color:#FF0000">��ƳB�z���A�еy��....</p>	
</div>
<script>
	$("#select_year").change(function(){
		  
		  wait.style.display="block";
		  
		  document.myform.submit();
		  
		})
	

</script>



