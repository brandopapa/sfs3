<?php 
//$Id: tape_edit.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";  //�n��]�w
//�n�J�ˬd
sfs_check();

//******�s�J���//
if ($_POST[dopost]=="�T�w�ק�"){
	$tape_memo = $_POST[tape_memo];
	$tape_name = $_POST[tape_name];
	$dbquery = "update $subtable ";
	$dbquery .= " set tape_name='$tape_name',";
	$dbquery .= " tape_grade='$_POST[tape_grade]',";
	$dbquery .= " tape_memo='$tape_memo'";
	$dbquery .= " where tapem_id='$_POST[tapem_id]' and tape_id=$_POST[tape_id]";
	$result_tapem = mysql_query($dbquery)or die("�s�J���~") ;
	header ("Location: tape_list.php"); 
}
$dbquery = "select * from $subtable ";
$dbquery .= "where tapem_id='$_GET[tapem_id]' and tape_id=$_GET[tape_id] ";
$result_tapem = mysql_query($dbquery) or die("������~");
$row = mysql_fetch_array($result_tapem);
include "header.php"; 
?>

<center><img src="eye.gif">
   <b>�ק� <?php echo $ap_name ?></b>
   <form method="post" name="tapeform" action="tape_edit.php"> 
   <input type="hidden" name="tapem_id" value="<? echo("$row[tapem_id]") ?>">
   <input type="hidden" name="tape_id" value="<? echo("$row[tape_id]") ?>">   
   <table border="1" width="80%">
   <tr ><td>���O�s��</td><td><? echo("$row[tapem_id]") ?><? echo("$row[tape_id]") ?>     
   </td></tr>
   <tr><td>�W��</td><td><input type="text" name="tape_name" size="60" value="<? echo("$row[tape_name]") ?>"></td></tr>
   <tr><td>�A�Φ~��</td><td><input type="text" name="tape_grade" size="30"value="<? echo("$row[tape_grade]") ?>"></td></tr>
   <tr><td>����<br></td><td><textarea name="tape_memo"rows=6 cols="62"><? echo("$row[tape_memo]") ?></textarea></td></tr>   
   <tr><td colspan=2 align=center><input type="submit" name="dopost" value="�T�w�ק�">&nbsp;&nbsp;<input type="button" value="�^�W�@��" onClick="history.back()"></td></tr>   
   </table>
   </form>

<?php
include("footer.php");
?>
