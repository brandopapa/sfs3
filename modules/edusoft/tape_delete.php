<?php 
//$Id: tape_delete.php 8146 2014-09-23 08:24:22Z smallduh $

include "config.php";  //�n��]�w
//�n�J�ˬd
sfs_check();

if ($_POST[dopost]=="�T�w�R��"){
	$dbquery = "delete from $subtable ";
	$dbquery .= " where tapem_id='$_POST[tapem_id]' and tape_id=$_POST[tape_id]";
	$result_tapem = mysql_query($dbquery) or die("�R�����~".$dbquery);
	header("Location: tape_list.php"); 
}
$dbquery = "select * from $subtable ";
$dbquery .= "where tapem_id='$_REQUEST[tapem_id]' and tape_id=$_REQUEST[tape_id] ";
$result_tapem = mysql_query($dbquery) or die("������~") ;
$row = mysql_fetch_array($result_tapem);
include "header.php";
?>
   
   <center><img src="eye.gif">
   <b>�R�� <?php echo $ap_name ?></b>
   <form method="post" name="tapeform" action="<?php echo $_SERVER[PHP_SELF] ?>"> 
   <input type="hidden" name="tapem_id" value="<?php echo("$row[tapem_id]") ?>">
   <input type="hidden" name="tape_id" value="<?php echo("$row[tape_id]") ?>">   
   <table border="1" width="80%">
   <tr ><td width=80>���O�s��</td><td><?php echo("$row[tapem_id]") ?><?php echo("$row[tape_id]") ?>     
   </td></tr>
   <tr><td width=80>�W��</td><td><?php echo("$row[tape_name]") ?></td></tr>
   <tr><td colspan=2 align=center><input type="submit" name="dopost" value="�T�w�R��">&nbsp;&nbsp;<input type="button" value="�^�W�@��" onClick="history.back()"></td></tr>   
   </table>
   </form>
<?php
include("footer.php");
?>
