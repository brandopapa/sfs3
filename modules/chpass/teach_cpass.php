<?php

// $Id: teach_cpass.php 7587 2013-09-28 03:49:14Z smallduh $

// --系統設定檔
include "teach_config.php";

//載入 ldap 模組函式
include_once('../ldap/my_functions.php');
$LDAP=get_ldap_setup();

// --認證 session 
sfs_check();

head("更改個人密碼");
print_menu($teach_menu_p); 

if ($LDAP['enable']) {
	echo "系統已啟用 LDAP 認證，請直接登入 LDAP 伺服器進行密碼變更。<br>";
	if ($LDAP['chpass_url']!="") {
	 echo "你可以經由以下連結前往變更密碼：<a href=\"".$LDAP['chpass_url']."\">前往變更密碼</a>";
	}
	exit();
}
?>

<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  class=main_body >
<form method="post" name=cform>
<?php
if ($_POST[key]=="更改密碼") {
	if ($_POST[login_pass]==$_POST[login_pass2]) {
		$err=pass_check(trim($_POST[login_pass]),$_SESSION['session_log_id']);
		if ($err) {
			echo "<tr><td class=title_mbody>$err</td></tr><tr><td align=\"center\" valign=\"top\"><input type=\"submit\" value=\"重新更改\"></td></tr>";
		} else {
			$ldap_password = createLdapPassword($_POST['login_pass']);
			$query = "update teacher_base set login_pass ='".pass_operate($_POST[login_pass])."' , ldap_password='$ldap_password' where teacher_sn ='{$_SESSION['session_tea_sn']}' ";
			mysql_query($query,$conID);
			echo "<tr><td class=title_mbody >密碼更改成功</td></tr>";
			$_SESSION['session_login_chk']=pass_check(trim($_POST[login_pass]),$_SESSION['session_log_id']);;
		}
	} else {
		echo "<tr><td class=title_mbody>兩次密碼輸入不同，密碼更改失敗！</td></tr><tr><td align=\"center\" valign=\"top\"><input type=\"submit\" value=\"重新更改\"></td></tr>";
	}
}
else
{
?>
<tr>
	<td align="center" valign="top">輸入新密碼:
	<input type="password" size="32" maxlength="32" name="login_pass" ></td>
</tr>
<tr>
	<td align="center" valign="top">再輸入一次:
	<input type="password" size="32" maxlength="32" name="login_pass2" ></td>
</tr>
<tr>
	<td align="center" valign="top"><input type="submit" name="key" value="更改密碼"></td>
</tr>
<?php
}
echo "</form></table>為確保資料安全，請務必遵守以下事項：<br>
			1.密碼至少為六個數字、字母或符號組成。<br>
			2.密碼內至少要包含一個字母或符號。<br>
			3.密碼不可為系統預設密碼，最好也不是自己的身份證字號。<br>
			4.密碼不可和帳號相同。";
foot();
?>