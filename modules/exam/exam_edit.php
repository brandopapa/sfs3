<?php                                                                                                                             
// $Id: exam_edit.php 8673 2015-12-25 02:23:33Z qfon $

// --�t�γ]�w��
include "exam_config.php";

if(!checkid(substr($_SERVER[PHP_SELF],1))){
	$go_back=1; //�^��ۤw���{�ҵe��  
	include "header.php";
	include "$rlogin";
	include "footer.php"; 
	exit;
}

$exam_id=$_GET[exam_id];
if($exam_id=='')
	$exam_id = $_POST[exam_id];
//�ˬd�O�_���@��
$exam_id=intval($exam_id);
$query = "select exam_id from exam where exam_id='$exam_id' and teach_id = '$_SESSION[session_log_id]'";
$result = $CONN->Execute($query);
if ($result->RecordCount() == 0 ) {
	echo "�A�D�@�̡A�L�v�ק�ΧR��!!" ;
	redir("exam.php",3) ;
	exit;
}


if ($_GET[sel] =="delete"){
	include "header.php";
	echo "<form action=\"$_SERVER[PHP_SELF]\" method=\"post\">\n"; 
	echo "�T�w�R�� <font color=red>".stripslashes ($_GET[exam_name])."</font> �H<br>";
	echo "<input type=\"hidden\" name=\"exam_id\" value=\"$_GET[exam_id]\">\n";
	echo "<input type=\"submit\" name=\"key\" value=\"�T�w�R��\" >\n";
	echo "&nbsp;&nbsp;<input type=button  value= \"�^�W��\" onclick=\"history.back()\">";
	echo "</form>";
	include "footer.php";
	exit;
}
if ($_POST[key] =="�T�w�R��") {
	//�R���ӧ@�~�ؿ��Ҧ����
	$e_path = $upload_path."/e_".$exam_id; 
	if (is_dir($e_path))
		exec( "rm -rf $e_path", $val );
	//�R���@�~	
	$sql_update = " delete from exam ";
	$sql_update .= " where exam_id='$exam_id' ";
	$CONN->Execute($sql_update)  or die ($sql_update);
	
	//�R���ǥͤW�ǰO��
	$sql_update = " delete from exam_stud ";	
	$sql_update .= " where exam_id='$exam_id' ";
	$CONN->Execute($sql_update)  or die ($sql_update);
	header ("Location: exam.php");
	exit;
}
if ($_POST[key] =="�ק�"){
	$sql_update = "update exam set exam_id='$_POST[exam_id]',exam_name='$_POST[exam_name]',exam_memo='$_POST[exam_memo]',exam_isopen='$_POST[exam_isopen]',e_kind_id='$_POST[e_kind_id]' ,teach_id='$_SESSION[session_log_id]',teach_name='$_SESSION[session_tea_name]' ";
	$sql_update .= " where exam_id='$_POST[exam_id]' ";	
	$CONN->Execute($sql_update)  or die ($sql_update);  
	header ("Location: exam.php");
	exit;
}
$_GET[exam_id]=intval($_GET[exam_id]);
$sql_select = "select exam.*  from exam,exam_kind ";
$sql_select .=" where exam.e_kind_id=exam_kind.e_kind_id and exam.exam_id='$_GET[exam_id]' ";  
$result = $CONN->Execute($sql_select);

while (!$result->EOF) {
	$exam_id = $result->fields["exam_id"];
	$exam_name = $result->fields["exam_name"];
	$exam_memo = $result->fields["exam_memo"];
	$exam_isopen = $result->fields["exam_isopen"];
	//$exam_source_isopen = $result->fields["exam_source_isopen"];
	$e_kind_id = $result->fields["e_kind_id"];
	if ($result->fields["exam_isopen"]=='1')
		$exam_isopen = " checked ";
	else
		$exam_isopen = " ";
	$result->MoveNext();	
};

$temp_year = substr($_GET[class_id],4,1); //���o�~��	
$temp_class = sprintf("%02d",substr($class_id,5)); //���o�Z��
include "header.php";

?>
�ק�@�~���e
<form action ="<?php echo $_SERVER[PHP_SELF] ?>" method="post" >
<input type=hidden name=exam_id value="<?php echo $exam_id ?>">
<table>
<tr>
	<td>�Z�šG<?php echo "$class_year[$temp_year]$class_name[$temp_class]�Z" ?>
	</td>
</tr>


<tr>
	<td>�@�~�W��<br>
		<input type="text" size="60" maxlength="60" name="exam_name" value="<?php echo $exam_name ?>">
	</td>
</tr>



<tr>
	<td>����<br>
		<textarea name="exam_memo" cols=40 rows=5 wrap=virtual><?php echo $exam_memo ?></textarea>
	</td>
</tr>



<tr>
	<td>
		�}�l�i��<br>
		<input type="checkbox" name="exam_isopen" value="1" <? echo $exam_isopen ?>>
	</td>
</tr>


<tr>
	<td>
		<input type= "hidden" name = "e_kind_id" value="<?php echo $e_kind_id ?>">
		<input type="submit" name="key" value="�ק�">
		&nbsp;&nbsp;<input type="button"  value= "�^�W��" onclick="history.back()">
	</td>
</tr>



</table>
</form>

<? include "footer.php"; ?>
