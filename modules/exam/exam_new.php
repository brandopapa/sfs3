<?php
                                                                                                                             
// $Id: exam_new.php 5310 2009-01-10 07:57:56Z hami $

// --�t�γ]�w��
include "exam_config.php";
if(!checkid(substr($_SERVER[PHP_SELF],1))){
	$go_back=1; //�^��ۤw���{�ҵe��  
	include "header.php";
	include "$rlogin";
	include "footer.php"; 
	exit;
}
$curr_class_id = sprintf("%03s%d",curr_year(),curr_seme());
$session_tea_name = addslashes($_SESSION['session_tea_name']);
if($_POST[key] =='�s�W'){
	$temp_arr = $_POST[e_kind_id];
	for ($i=0 ;$i<count($temp_arr);$i++) {
		$sql_insert = "insert into exam (exam_id,exam_name,exam_memo,exam_isopen,exam_isupload,e_kind_id,teach_id,teach_name)values ('','$_POST[exam_name]','$_POST[exam_memo]','$_POST[exam_isopen]','$_POST[exam_isupload]','$temp_arr[$i]','$_SESSION[session_log_id]','$session_tea_name')";
 		$CONN->Execute($sql_insert) or die($sql_insert);
//		echo $sql_insert;
 	}
header("Location: exam.php");
  
}
//���o�Z�ŦW�ٰ}�C
$class_name = class_base();
  
//�ثe���@�~���Z��
$query = "select class_id,e_kind_id from exam_kind where class_id like '$curr_class_id%' group by class_id order by class_id ";
$result = $CONN->Execute($query);
$class_select = "<select name=e_kind_id[] size=6 multiple>"; //�Z�ſﶵ
while (!$result->EOF) {
	$temp_class = substr($result->fields[class_id],-3);
	$class_select .= "<option value=\"".$result->fields[1]."\">$class_name[$temp_class]";
	$result->MoveNext();

}
$class_select .= "</select>";
include "header.php";
?>
<h3>�s�W�@�~</h3>
<script language="JavaScript">
function checkok()
{
	var OK=true
	if(document.eform.exam_name.value == "")
	{
		OK=false;
		str = '�@�~�W�٤��i�ť�';
	}
	
	if (OK == false)
	{
		alert(str)
	}	
	return OK
}

//-->
</script>

<form name=eform action="<?php echo $_SERVER[PHP_SELF] ?>" method="post" onSubmit="return checkok()">
<table border=1>
<tr>
	<td>�Z��(�i�h��)</td><td>
		<?php echo $class_select; ?>
	</td>
</tr>



<tr>
	<td>�@�~�W��</td><td>
		<input type="text" size="60" maxlength="60" name="exam_name" value="<?php echo $exam_name ?>">
	</td>
</tr>



<tr>
	<td>����</td><td>
		<textarea name="exam_memo" cols=40 rows=5 wrap=virtual><?php echo $exam_memo ?></textarea>
	</td>
</tr>



<tr>
	<td>
		�}�l�i��</td><td>
		<input type="checkbox" name="exam_isopen" value="1"> �O
	</td>
</tr>

<tr>
	<td>
		�}�l�W�ǧ@�~</td><td>
		<input type="checkbox" name="exam_isupload" value="1"> �O
	</td>
</tr>


<tr>
	<td colspan=2 align=center>
		<input type="submit" name="key" value="�s�W">
		&nbsp;&nbsp;<input type="button"  value= "�^�W��" onclick="history.back()">
	</td>
</tr>



</table>
</form>
<? include "footer.php"; ?>


