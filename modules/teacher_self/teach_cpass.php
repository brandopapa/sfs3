<?php

// $Id: teach_cpass.php 5310 2009-01-10 07:57:56Z hami $

// --�t�γ]�w��
include "teach_config.php";
// --�{�� session 
sfs_check();

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

head();
print_menu($teach_menu_p);
?>
<TABLE BORDER=0 CELLPADDING=10 CELLSPACING=0 CLASS="tableBg" WIDTH="100%" ALIGN="CENTER"> 
<TR>

<td  valign="top" width="100%" >   

<form method="post" name=cform>
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  class=main_body >
<?php
if ($key =="���K�X") {
	$query = "update teacher_base set login_pass ='$login_pass' where teacher_sn ='{$_SESSION['session_tea_sn']}' ";
	mysql_query($query,$conID);
	echo "<tr><td class=title_mbody >�K�X��令�\</td></tr>";
	echo "<tr><td>�z���s�K�X: <font color=red>$login_pass</font></td></tr>";
}
else
{
?>
<form method="post" name=cform>
<tr>
	<td align="center" valign="top">��J�s�K�X:
	<input type="text" size="12" maxlength="12" name="login_pass" ></td>
</tr>
<tr>
	<td  align="center" valign="top"><input type="submit"  name="key" value="���K�X"></td>
</tr>
</form>
<?php
}
echo "</table>";
echo "</td></tr></table>";
foot();
?>
