<?php

// $Id: readme.php 5588 2009-08-16 17:13:02Z infodaes $

// �ޤJ SFS3 ���禡�w
include "../../include/config.php";

// �ޤJ�z�ۤv�� config.php ��
require "config.php";

// ���o�ʧ@
$act=$_GET['act'];

// �ʧ@�B�z
if ($act=='stu_dtd') { 
	header("Content-type: text/html; Charset=utf8");
	header("Location: {$SFS_PATH_HTML}include/xml/student_call-2_0.dtd"); 
	exit;
} elseif ($act=='stu_xml') {
	header("Content-type: text/html; Charset=utf8");
	header("Location: {$SFS_PATH_HTML}include/xml/student_call-2_0.xml"); 
	exit;
}

// �s�� SFS3 �����Y
head("XML�洫�@�~");

// �{��
//sfs_check();

//
// �z���{���X�Ѧ��}�l

// ���
$tool_bar=make_menu($toxml_menu);
echo $tool_bar;

// �q�X����
echo <<<HERE
		<form method="post" action="reload.php" name="login_form">
		<input type="hidden" name="login_attempt" value="1">
		<input type="hidden" name="CustomerID" value="">
		
		<table cellspacing="2" cellpadding="2" align="right">

		<tr>
			<td	align="right" class="global-login-text" colspan="2" style="font-size:10px">
				<span style="color:red;font-face:verdana"></span>
			</td>
		</tr>
		
		<tr>
			<td rowspan="10" valign="top" align="left" width="80%">
			
			
			
			
			</td>
			<td	align="right" class="global-login-text" style="font-size:10px" nowrap>�����N�X: </td>
			<td width="1%"><input class="global-sub-nav-input" type="text" name="CompanyName"	value="" size="23"></td>
		</tr>
		
		<tr>
			<td	align="right" class="global-login-text" style="font-size:10px">�b�@�@��: </td>
			<td><input class="global-sub-nav-input" type="text" name="name" id="name" value="" size="23"></td>
		</tr>
		
		<tr>
			<td	align="right" class="global-login-text" style="font-size:10px">�K�@�@�X: </td>
			<td><input class="global-sub-nav-input" type="password" name="password" value=""	size="23"></td>
		</tr>
		
			
		<tr>
			<td colspan="2"	align="right">
				<input class="boldbutton" type="submit" value="Logon" name="Logon">
				<input class="boldbutton" type="reset" value="Reset" name="Reset">
			</td>
		</tr>
		<tr>
			<td align="right" colspan=2 class="global-login-text" style="font-size:10px">
			<br><br><Br><br><br>
			
			</td>
		</tr>
		</table>
		</form>

HERE;


// SFS3 ������
foot();

?>
