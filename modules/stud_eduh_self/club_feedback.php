<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $


if ($_SESSION['session_who'] != "�ǥ�") {
	echo "�ܩ�p�I���\��Ҳլ��ǥͱM�ΡI";
	exit();
}

//�ˬd�O�_�}����μҲ�
if ($m_arr["club_enable"]!="1"){
   echo "�ثe���}����ά��ʼҲաI";
   exit;
}


//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();

//�ثe��w�Ǵ�
$c_curr_seme=sprintf('%03d%1d',$curr_year,$curr_seme);

//���o�ǥ͸��
$STUD=get_student($_SESSION['session_tea_sn'],$c_curr_seme);

//���U�x�s�ɪ��ʧ@
if ($_POST['mode']=='save' and $_POST['student_sn']==$_SESSION['session_tea_sn']) {
 foreach ($_POST['stud_feedback'] as $club_sn=>$stud_fb) {
     $query="update association set stud_feedback='$stud_fb' where club_sn='$club_sn' and student_sn='".$_POST['student_sn']."' and seme_year_seme='$c_curr_seme'"; 
     if (mysql_query($query)) {
			 $INFO="��Ƥv�� ".date('Y-m-d H:i:s')."�x�s����!";
     } else {
       $INFO="Error! query=".$query;
     }
 }
}


//�ˬd�ǥͬO�_�w�ѥ[����
//$my_club=get_student_join_club($STUD['student_sn'],$c_curr_seme);
if ($my_club=get_student_join_club($STUD['student_sn'],$c_curr_seme)) {
	?>
	<form method="post" name="myform" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<input type="hidden" name="club_menu" value="<?php echo $_POST['club_menu'];?>">
		<input type="hidden" name="mode" value="">
		<input type="hidden" name="student_sn" value="<?php echo $STUD['student_sn'];?>">
	���Ǵ��A�ѥ[�F�U�C���ΡA�аw����ά��ʼg�X�A���ۧڬ٫�
	<table border="1" style="border-collapse:collapse" bordercolor="#800000">
	 <tr bgcolor="#FFCCFF">
	   <td width="100" style="font-size:10pt" align="center">�Ǵ�</td>
	   <td width="100" style="font-size:10pt" align="center">���ΦW��</td>
	   <td width="50" style="font-size:10pt" align="center">���Z</td>
	   <td width="80" style="font-size:10pt" align="center">���¾��</td>
	   <td width="200" style="font-size:10pt" align="center">�Ѯv���y</td>
	   <td width="300" style="font-size:10pt" align="center">�ۧڬ٫�</td>
	 </tr>
	
	<?php
	foreach ($my_club as $My) {
		 if ($My['seme_year_seme']==$c_curr_seme) {
		 	$My['score']=($My['score']>0)?$My['score']:"-";
	     ?>
	 <tr>
	   <td width="100" style="font-size:10pt" align="center"><?php echo sprintf("%d",substr($My['seme_year_seme'],0,3));?>�Ǧ~��<br>��<?php echo substr($My['seme_year_seme'],-1);?>�Ǵ�</td>
	   <td width="100" style="font-size:10pt" align="center"><?php echo $My['club_name'];?></td>
	   <td width="50" style="font-size:10pt" align="center"><?php echo $My['score'];?></td>
	   <td width="80" style="font-size:10pt" align="center"><?php echo $My['stud_post'];?></td>
	   <td width="200" style="font-size:10pt"><?php echo $My['description'];?></td>
	   <td width="300" style="font-size:10pt" align="center"><textarea name="stud_feedback[<?php echo $My['club_sn'];?>]" rows="8" cols="36"><?php echo $My['stud_feedback'];?></textarea></td>
	 </tr>
	     <?php	
		 }
	}
	?>
	</table>
	<input type="button" value="�x�s�ۧڬ٫���" style="color:#FF0000" onclick="document.myform.mode.value='save';document.myform.submit()">
	<table width="100%" border="0">
	  <tr><td style="color:#FF0000;font-size:10pt"><?php echo $INFO;?></td></tr>
  </table>
	</form>
	<?php
} else {
 echo "���Ǵ��A�S���ѥ[������ά��ʳ�!";
}
?>
  <table border="0">
   <tr><td style="color:#0000FF">���A���Ҧ����ά��ʰO����</td></tr>
  </table>
	<table border="1" style="border-collapse:collapse" bordercolor="#800000">
	 <tr bgcolor="#FFCCFF">
	   <td width="100" style="font-size:10pt" align="center">�Ǵ�</td>
	   <td width="100" style="font-size:10pt" align="center">���ΦW��</td>
	   <td width="50" style="font-size:10pt" align="center">���Z</td>
	   <td width="80" style="font-size:10pt" align="center">���¾��</td>
	   <td width="200" style="font-size:10pt" align="center">�Ѯv���y</td>
	   <td width="300" style="font-size:10pt" align="center">�ۧڬ٫�</td>
	 </tr>
	
	<?php
	foreach ($my_club as $My) {
		 if ($My['seme_year_seme']==$c_curr_seme) {
		 	$My['score']=($My['score']>0)?$My['score']:"-";
	     ?>
	 <tr>
	   <td width="100" style="font-size:10pt" align="center"><?php echo sprintf("%d",substr($My['seme_year_seme'],0,3));?>�Ǧ~��<br>��<?php echo substr($My['seme_year_seme'],-1);?>�Ǵ�</td>
	   <td width="100" style="font-size:10pt" align="center"><?php echo $My['club_name'];?></td>
	   <td width="50" style="font-size:10pt" align="center"><?php echo $My['score'];?></td>
	   <td width="80" style="font-size:10pt" align="center"><?php echo $My['stud_post'];?></td>
	   <td width="200" style="font-size:10pt"><?php echo $My['description'];?></td>
	   <td width="300" style="font-size:10pt"><?php echo $My['stud_feedback'];?></td>
	 </tr>
	     <?php	
		 }
	}
	?>
	</table>