<?php

// $Id: validate_xml.php 5921 2010-03-25 14:59:04Z hami $

// �ޤJ SFS3 ���禡�w
include "../../include/config.php";

// �ޤJ�z�ۤv�� config.php ��
require "config.php";

// �{��
sfs_check();

// �ˬd php.ini �O�_���} file_uploads ?
check_phpini_upload();

// ���o�ʧ@
$act=$_POST['act'];

// �ʧ@�B�z
if ($act=='yes_do_it') {
  if ($_FILES['xmlfile']['size'] >0 && $_FILES['xmlfile']['name'] != "") {
	$dom = new domDocument;
	//$dom->validateOnParse = true;
	$dom->load($_FILES['xmlfile']['tmp_name']);
	if ($dom->validate()){
	   $error_message="���ߧA(�p)~~~XML�ɮ����Ҧ��\!!";

	} else {

	   $error_message="<font color=red>���~~XML�ɮ����ҥ���!!</font>";
	}
  }
}

// �s�� SFS3 �����Y
head("XML�洫�@�~");

$tool_bar=make_menu($toxml_menu);
echo $tool_bar;

echo "
<form action =\"{$_SERVER['PHP_SELF']}\" enctype=\"multipart/form-data\" method=post>
<table border='1' cellpadding='4' cellspacing='0' bgcolor='#0000FF'><tr>
<td nowrap bgcolor='#FFFFFF' class='small'>
<p>�ФW�Ǳz�����Ҫ�XML�ɡC</p>
�ɮסG<input type=file name=\"xmlfile\" size=60>
<input type=\"submit\" name=\"submit\" value=\"����\">
<input type=\"hidden\" name=\"act\" value=\"yes_do_it\">
</td>
</tr></table>
</form><BR>$error_message";

// SFS3 ������
foot();

?>
