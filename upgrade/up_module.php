<?php
include "../include/config.php";
include "../include/sfs_case_PLlib.php";
include "update_function.php";
set_time_limit(600) ;
$oth_arr = array("book"=>"�ϮѺ޲z�t��","compclass"=>"�Ű�w���t��","docup"=>"����Ʈw","board"=>"�հȧG�i��");
if ($_POST[do_key]=='����ɯ�') {
	switch ($_POST[sel_key]){
		case "book":

		if(check_field($mysql_db,$conID,'borrow','student_sn')){
			trigger_error("�ϮѺ޲z�t�� �w�g�ɯ�!",E_USER_ERROR);
			break;
		} else {
			up_teacher_sn("borrow","stud_id","student_sn");
		//	up_student_sn("borrow");
		}
		break;
	
		case "compclass":
		if(check_field($mysql_db,$conID,'compclass','teacher_sn')){
			trigger_error("�Ű�w���t�� �w�g�ɯ�!",E_USER_ERROR);
			break;
		} else 
			up_teacher_sn("compclass");
		break;

		case "docup":
		if(check_field($mysql_db,$conID,'docup_owerid','teacher_sn')){
			trigger_error("�Ű�w���t�� �w�g�ɯ�!",E_USER_ERROR);
			break;
		} else  {
			up_teacher_sn("docup","docup_owerid");
			up_teacher_sn("docup_p","docup_p_ownerid");
		}
		
		break;
		case "board":
		if(check_field($mysql_db,$conID,'board_check','teacher_sn')){
			trigger_error("�հȧG�i��{�� �w�g�ɯ�!",E_USER_ERROR);
			break;
		} else  {
			up_teacher_sn("board_check");
			up_teacher_sn("board_p","b_own_id");
		}
		
		break;

	}
	$is_upgrade = true;
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>�Ҳդɯ�</title>
</head>
<body>
<?php
if($is_upgrade) {
	echo "<script>\n
	confirm('�z�w�g�����t�� ".$oth_arr[$_POST[sel_key]]." �ɯŰʧ@ \\n���T�w��i���L�Ҳդɯ�');\n
	</script>\n";
}

?>

<h3>SFS3 �ҲդɯŻ���</h3>
<form action="up_module.php" method="POST">
<table cellpadding="0" bgcolor="#BEE0EE" width="600">
<tr><td>
�z�w�g�����F�t�ΰ򥻪��ɯŰʧ@�A�b�U���A��ܱz�n�ɯŪ��ҲաC 
</td></tr>
<tr>
<td>

<?php
while(list($id,$val) = each($oth_arr))  {
	echo "<input name='sel_key' type='radio' value='$id'> $val ( $id )<br>";

}

?>
<input type="submit" name="do_key" value="����ɯ�">
</td></tr>

</table>
</form>
</body>
</html>
