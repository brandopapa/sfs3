<?php
include "config.php";
//�n�J�ˬd
sfs_check();

if ($_POST[tapem_edit]=='�T�w�ק�'){
	$tapem_name = stripslashes($_POST[tapem_name]);
	$dbquery = "update $mastertable "; 
	$dbquery.= "set tapem_id='$_POST[tapem_id]', tapem_name='$tapem_name' "; 
	$dbquery.= " where tapem_id='$_POST[old_id]'";
	
	$result = mysql_query($dbquery) or die("<br>�ק���~�G�d�ݥN���O�_����<br>\n $dbquery");
	header ("Location: tapem_list.php");   
}
else{
	$dbquery = "select * from $mastertable where tapem_id='$_REQUEST[tapem_id]' ";    
	$result = mysql_query($dbquery) or die("<br>DJ-PIM ERROR: ������~.<br>\n $dbquery");    
	$row = mysql_fetch_array($result);
	include ("header.php"); 
	echo("<p align=\"center\"><img src=\"eye.gif\"><b>�ק� $ap_name ���O</b></p>");
	echo("<div align=\"center\">");
	echo("<form name=\"tapeform\" action=\"$_SERVER[PHP_SELF]\"   method=\"post\" > ");
	echo("<input type=\"hidden\" name=\"old_id\" value=\"$_REQUEST[tapem_id]\"> ");
	echo("<table border=\"0\" width=\"400\" cellspacing=\"0\" cellpadding=\"0\">");
	echo("<tr>");
	echo("<td width=\"100%\">");
	echo("<hr>");
	echo("<p>���O�N�X�G");
	echo("<input type=\"text\" name=\"tapem_id\" value=\"$_REQUEST[tapem_id]\" size=\"4\" maxlength=\"2\"><br>");
	echo("���O�W�١G<!--webbot bot=\"Validation\" B-Value-Required=\"TRUE\"");
	echo("I-Maximum-Length=\"30\" --><input type=\"text\" name=\"tapem_name\" value=\"$row[tapem_name]\" size=\"30\"  maxlength=\"30\"></p>");
	echo("<p align=\"center\"><input type=\"submit\" value=\"�T�w�ק�\" name=\"tapem_edit\">&nbsp;&nbsp;");
	echo("<input type=\"button\" value=\"�^�W�@��\" onClick=\"history.back()\"></td>\n");
	echo("</tr></table>");
	echo("</form><hr width=400>");
}
?>

</div>
<?php
	include("footer.php")
?>
