<?php
//$Id: query.php 7847 2014-01-09 05:51:44Z hami $
include "config.php";
include "../../include/sfs_case_dataarray.php";

//�{��
sfs_check();

//�q�X�����������Y
head("�̯Z�Ůy���d��");

//�D�n���e
print_menu($school_menu_p);

$passwd=$_POST[email_pass];

if (count($passwd)>0 && $_POST['opt']=='update') {
	while(list($student_sn,$email_pass)=each($passwd)) {
		$ldap_password = createLdapPassword($email_pass);
		$query="update stud_base set email_pass='$email_pass' , ldap_password='$ldap_password'  where student_sn='$student_sn'";
		$CONN->Execute($query) or die($query);
		
		$sql="select stud_id,curr_class_num,stud_name from stud_base where student_sn='$student_sn'";
		$res=$CONN->Execute($sql);
		
		$rec="<tr><td>".$res->fields[stud_id]."</td><td>".$res->fields[stud_name]."</td><td>".$res->fields[curr_class_num]."</td></tr>";
				
	}
	$INFO="<br><font color=red>�w�ק�H�U�ǥͪ��K�X</font><br>
	 	<table border=0 cellspacing=1 cellpadding=2 bgcolor=#9ebcdd class=small>
		<tr bgcolor=#c4d9ff>
			<td align='center'>�Ǹ�</td>
			<td align='center'>�Z�Ůy��</td>
			<td align='center'>�m�W</td>
		</tr>
	".$rec."</table>";
}

//��ܿﶵ
?>
<form method="post" name="myform" action="<?php echo $_SERVER['PHP_SELF'];?>">
<input type="hidden" name="opt" value="">
���̲{���Z�Ůy���d�߱K�X�G
<input type="text" name="class" value="<?php echo $_POST['class'];?>" size="5">�Z
<input type="text" name="num" value="<?php echo $_POST['num'];?>" size="5">��
<input type="button" value="�d��" onclick="document.myform.opt.value='search';document.myform.submit()">
<br>
�������G<br>
1.�Ȭd�ߥثe�b�y�ǥ͡C<br>
2.��p�~�Ŭ� 1-6�A�Ҧp�G�T�~���Z�A�п�J 306�C<br>
3.�ꤤ�~�Ŭ� 7-9�A�Ҧp�G�T�~���Z�A�п�J 906�C<br>

<?php
echo $INFO;
if ($_POST['opt']=='search') {

 $class_num=$_POST['class'].sprintf('%02d',$_POST['num']);
  
 echo "<br>���d�߱���G".$class_num."<br>";
 
 $sql="select * from stud_base where curr_class_num='$class_num' and stud_study_cond='0'";
 $res=$CONN->Execute($sql) or die("Error! SQL=".$sql);
 if ($res->RecordCount()>0) {
 ?>
 	<table border=0 cellspacing=1 cellpadding=2 bgcolor=#9ebcdd class=small>
		<tr bgcolor=#c4d9ff>
			<td align='center'>�Ǹ�</td>
			<td align='center'>�Z�Ůy��</td>
			<td align='center'>�m�W</td>
			<td align='center'>�K�X</td>
		</tr>
 <?php
	while(!$res->EOF) {
		$email_pass=$res->fields[email_pass];
		$student_sn=$res->fields[student_sn];
		$stud_id=$res->fields[stud_id];
		$curr_class_num=$res->fields[curr_class_num];
		$stud_name=$res->fields[stud_name];
		?>
		<tr bgcolor=#ffffff>
			<td align='center'><?php echo $stud_id;?></td>
			<td align='center'><?php echo $curr_class_num;?></td>
			<td align='center'><?php echo $stud_name;?></td>
			<td align='center'><input type="text" name="email_pass[<?php echo $student_sn;?>]" value="<?php echo $email_pass;?>"></td>
		</tr>		
		<?php
		$res->MoveNext();
	}
	?>
	 </table>
	 <input type="button" value="�ק�K�X" onclick="document.myform.opt.value='update';document.myform.submit()">
	 <?php
 } else {
  echo "<font color=red>�d�L���ǥ�!<font>";
 }
}
?>
</form>
<?php
//�G������
foot();
?>
