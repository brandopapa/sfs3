<?php
include ('config.php');

sfs_check();
//�q�X����
head("�ץ����g�έp�� student_sn���");

$tool_bar=&make_menu($school_menu_p);

//�C�X���
echo $tool_bar;

?>
<form method="post" name="myform" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
	<input type="hidden" name="mode" value="">
<table border="0" style="border-collapse:collapse" bordercolor="#800000">
 <tr>
 	<td><br><font color=red>���ץ�10�~�Ǹ�����, �ɭP���g�έp�O�����m�����D��</font><br>
 		<br><font color=blue>�����G</font><br>
 		��ɮv�ˬd�ǥͼ��g�έp�ɡA�o�{�ǥͪ����g�`�ƿ��~�A<br>
 		��o�ͭ�]�ثe�����A�H101�~�J�Ǿǥͬ��ҡG<br>
 		�b�Y�ǩ|���d�������p�U�A�t�λ~
 		<br> �u�b91�~�J�ǦP�Ǹ��ǥͪ����g�O������J 101�Ǧ~�P�Ǹ��ǥͪ��y�����v
 		<br>�A�ɦܦb�d��101�Ǧ~�ӥ͸�ƮɡA���Ʋέp�ƿ��~(�]����91�~��Ƥ]�έp�i��)�C<br>
 		<br><font color=blue>�ץ���z�G</font>
 		<br>�� 91 �~�ǥͪ����g�έp��ơA���T��J�ݩ� 91 �~�ǥͪ��y�����Y�i�C<br>
 	</td>
</tr>
  <tr>
  	<td><br><input type="checkbox" name="confirm_save" value="1">�i��ץ�(�T�w�n�ץ��A���ġA�_�h�ȶi���[��)<br></td>
 </tr>	
 
 <tr>
  <td colspan="2"><br><input type="button" value="�}�l" onclick="document.myform.mode.value='start';document.myform.submit();"> </td>
 </tr>

</table>
 
</form>

<?php
if ($_POST['mode']=="start") {
$query="SELECT a.seme_year_seme,a.stud_id,a.student_sn from stud_seme_rew a,stud_seme b where a.seme_year_seme=b.seme_year_seme and a.stud_id=b.stud_id and a.student_sn!=b.student_sn";
$result=mysql_query($query);
//���X��� stud_seme_rew���, ��� seme_year_seme, stud_id, student_sn
$i=0;
 while ($row=mysql_fetch_array($result)) {
 	$i++;
 	$seme_year_seme=$row['seme_year_seme'];
 	$stud_id=$row['stud_id'];
 	$old_student_sn=$row['student_sn'];
 	
 	$query="select a.student_sn,b.stud_name from stud_seme a,stud_base b where a.student_sn=b.student_sn and a.seme_year_seme='$seme_year_seme' and a.stud_id='$stud_id'";
  $res=mysql_query($query);
  list($student_sn,$stud_name)=mysql_fetch_row($res);
  echo "(�O�� $i )".$seme_year_seme."�Ǵ� , �ǥ�:".$stud_name."($stud_id) �� student_sn=".$old_student_sn." ==>���ץ���".$student_sn;
  
  if ($_POST['confirm_save']==1) {
  	$query="update stud_seme_rew set student_sn='".$student_sn."' where seme_year_seme='$seme_year_seme' and stud_id='$stud_id' and student_sn='$old_student_sn'";
    if (mysql_query($query)) {
     echo "�w�ץ�!";
    } else {
     echo "<font color=red>�ץ�����!!!</font>";
    }
  }
  
  echo "<br>";
  
 }
  echo "<br><font color='red'>���槹��!</font>";
  if ($i==0) echo " �S�o�{���~�C";
} // end if post

?>


