<?php
                                                                                                                             
// $Id: board_delete_c.php 5310 2009-01-10 07:57:56Z hami $

// --�t�γ]�w��
include	"config.php"; 

// session �{��
session_start();

if ($key=="�T�w�R��"){
	$b_post_time = mysql_date();

	$b_edit_id=$_SESSION[session_log_id];

	$b_store = $b_id."_".$b_upload;
	if(file_exists ($USR_DESTINATION.$b_store))
		unlink($USR_DESTINATION.$b_store);
	// $query= "delete from board_c where b_id = '$b_id'";
	$query= "UPDATE unit_c SET b_days = '0' ,b_edit_time='$b_post_time' ,update_ip='{$_SERVER['REMOTE_ADDR']}',b_edit_id='$b_edit_id'  where b_id = '$b_id'";  //�R��

	mysql_query($query);
		Header ("Location: etoe.php?unit=$unit&entry=$entry");
}

	include "header_u.php";

$query = "select b_sub,b_con,b_upload,teacher_sn from unit_c where b_id='$b_id'";
$result = mysql_query($query);
$row= mysql_fetch_array($result);

if($row["teacher_sn"] ==$_SESSION[session_tea_sn] || checkid($_SERVER[SCRIPT_FILENAME],1)){   //�ۤv�i�R��

?>

<table align="center" border="0" cellPadding="3" cellSpacing="0" width="411">
<tr bgColor="#dae085">
	<td align="middle" height="30" width="60%"><b>�T�w�R�� �s���G<?php echo "$b_id �G". $row["b_sub"]  . "�G" . $row["b_con"]; 
?>�H</b><br>
	<form action="<?php echo $PHP_SELF ?>" method="post">
	<input type=hidden name=b_id value="<?php echo $b_id ?>">
	<input type=hidden name=bk_id value="<?php echo $bk_id ?>">
	<input type=hidden name=sel value="<?php echo $self ?>">
	<input type="hidden" name="unit" value="<?php echo $unit ?>">
	<input type="hidden" name="entry" value="<?php echo $entry ?>">

	<input type=hidden name=b_upload value="<?php echo $row["b_upload"] ?>">
	<input type=submit name="key" value="�T�w�R��">  
	<INPUT TYPE="button" VALUE="�^�W�@��" onClick="history.back()">
	</form>
	</td>
</tr>
</table>
<?php
}
?>
