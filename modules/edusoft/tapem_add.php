<?php
include "config.php";

//�n�J�ˬd
sfs_check();

include "header.php";
if ($_POST[tapem_add]=='�T�w�s�W'){
	$dbquery = "select tapem_id from $mastertable where tapem_id='$_POST[tapem_id]' "; 
	$result = mysql_query($dbquery);
	if (mysql_num_rows($result)==0){
		$tapem_name = stripslashes($_POST[tapem_name]);
		$dbquery = "insert into $mastertable (tapem_id,tapem_name) values ('$_POST[tapem_id]','$tapem_name')";
		$result = mysql_query($dbquery)or die("<br>�s�W���~�G�d�ݥN���O�_����.<br>\n$dbquery");
	}
}
echo("<p align=\"center\"><img src=\"eye.gif\"><b>�s�W ".$ap_name."���O</b></p>");
echo("<div align=\"center\">");
echo("<form action=\"tapem_add.php\" name= \"tapeform\" method=\"post\" > ");
echo("<table border=\"0\" width=\"400\" cellspacing=\"0\" cellpadding=\"0\">");
echo("<tr>");
echo("<td width=\"100%\">");
echo("<hr>");
echo("<p>���O�N�X�G<!--webbot bot=\"Validation\" B-Value-Required=\"TRUE\"");
echo("I-Maximum-Length=\"2\" --><input type=\"text\" name=\"tapem_id\" size=\"4\" maxlength=\"2\"><br>");
echo("���O�W�١G<!--webbot bot=\"Validation\" B-Value-Required=\"TRUE\"");
echo("I-Maximum-Length=\"30\" --><input type=\"text\" name=\"tapem_name\" size=\"30\"  maxlength=\"30\"></p>");
echo("<p align=\"center\"><input type=\"submit\" value=\"�T�w�s�W\" name=\"tapem_add\">&nbsp;&nbsp;&nbsp;<input type=\"reset\" value=\"���s�]�w\" name=\"B2\"></td>");
echo("</tr></table>");
echo("</form><hr width=400>");
?>
<center>

<table border="1" width="300">
  <tr>
    <td width="20%" bgcolor="#8080FF" align="center">�s�X</td>
    <td width="50%" bgcolor="#8080FF" align="center">���O�W��</td>
    <td width="30%" bgcolor="#8080FF" align="center" colspan=2>�s�װʧ@</td>
  </tr>

<?php
$dbquery = "select * from $mastertable order by tapem_id";
$result = mysql_query($dbquery);
while($row = mysql_fetch_array($result)) {
	echo ($i++ %2)?"<tr bgcolor=\"$school_kind_color[3]\">":"<tr bgcolor=\"$school_kind_color[5]\">";
	echo("<td align=center>$row[tapem_id]</td><td>$row[tapem_name]</td>");
	echo("<td><a href=\"tapem_edit.php?edit_tapem&tapem_id=$row[tapem_id]\">�ק�</a></td>");
	echo("<td><a href=\"tapem_delete.php?delete_tapem&tapem_id=$row[tapem_id]\">�R��</a></td></tr>");    
}
?>
</table>
<?php
	include("footer.php")
?>
