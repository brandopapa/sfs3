<?php
//$Id: tapem_delete.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";

//�n�J�ˬd
sfs_check();

if ($_POST[do_delete]=='�T�w�R��'){//����R��
	$dbquery = "delete from $mastertable "; 
	$dbquery.= " where tapem_id='$_POST[tapem_id]'";
	$result = mysql_query($dbquery) or die("<br>TAPE: �R�����~.<br>\n $dbquery");
	header("Location: tapem_list.php");
}
else{ //�߰ݬO�_�R��
	$dbquery = "select * from $mastertable where tapem_id='$_GET[tapem_id]' ";
	$result = mysql_query($dbquery) or die("<br>TAPE: �R�����~.<br>\n $dbquery");
	$row = mysql_fetch_array($result);
	include "header.php";
	echo("<center>\n");
	echo("<b>�O�_�R��?</b>");
	echo("<form name=\"tapeform\" action=\"tapem_delete.php\"   method=\"post\" > \n");
	echo("<input type=\"hidden\" name=\"tapem_id\" value=\"$_GET[tapem_id]\">\n");
	echo("<table border=\"0\" width=\"400\" cellspacing=\"0\" cellpadding=\"0\">\n");
	echo("<tr>\n");
	echo("<td width=\"100%\">\n");
	echo("<hr>\n");
	echo("<p>���O�N�X�G$_GET[tapem_id]<br>\n");
	echo("���O�W�١G$row[tapem_name]</p>\n");
	echo("<hr>\n");
	echo("<p align=\"center\"><input type=\"submit\" value=\"�T�w�R��\" name=\"do_delete\">&nbsp;&nbsp;&nbsp;\n");
	echo("<input type=\"button\" value=\"�^�W�@��\" onClick=\"history.back()\"></td>\n");
	echo("</tr></table>\n");
	echo("</form>\n");
	echo("</center>\n");
}
include("footer.php");
?>
