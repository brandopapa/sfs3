<?php
// $Id: teach_cpass.php 5310 2009-01-10 07:57:56Z hami $
include_once('config.php');

//���J ldap �Ҳը禡
include_once('../ldap/my_functions.php');
$LDAP=get_ldap_setup();

// --�{�� session 
sfs_check();

// ���O�d�d��
switch ($ha_checkary){
        case 2:
                ha_check();
                break;
        case 1:
                if (!check_home_ip()){
                        ha_check();
                }
                break;
}


head("���ӤH�K�X");
print_menu($menu_p); 


if ($LDAP['enable1']) {
	echo "�t�Τw�ҥ� LDAP �{�ҡA�Ъ����n�J LDAP ���A���i��K�X�ܧ�C<br>";
	if ($LDAP['chpass_url']!="") {
	 echo "�A�i�H�g�ѥH�U�s���e���ܧ�K�X�G<a href=\"".$LDAP['chpass_url']."\">�e���ܧ�K�X</a>";
	}
	exit();
}

?>

<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  class=main_body >
<form method="post" name=cform>
<?php
if ($_POST[key]=="���K�X") {
	if ($_POST[login_pass]==$_POST[login_pass2]) {
		$err=stud_pass_check(trim($_POST[login_pass]),$_SESSION['session_log_id']);
		if ($err) {
			echo "<tr><td class=title_mbody>$err</td></tr><tr><td align=\"center\" valign=\"top\"><input type=\"submit\" value=\"���s���\"></td></tr>";
		} else {
			$ldap_password = createLdapPassword($_POST['login_pass']);
			$query = "update stud_base set email_pass ='".$_POST[login_pass]."' , ldap_password='$ldap_password' where student_sn ='{$_SESSION['session_tea_sn']}' ";
			mysql_query($query,$conID);
			echo "<tr><td class=title_mbody >�K�X��令�\</td></tr>";
			$_SESSION['session_login_chk']=stud_pass_check(trim($_POST[login_pass]),$_SESSION['session_log_id']);;
		}
	} else {
		echo "<tr><td class=title_mbody>�⦸�K�X��J���P�A�K�X��異�ѡI</td></tr><tr><td align=\"center\" valign=\"top\"><input type=\"submit\" value=\"���s���\"></td></tr>";
	}
}

if($password_changed)
	$main='<tr>
	<td align="center" valign="top">��J�s�K�X:
	<input type="password" size="32" maxlength="32" name="login_pass" ></td>
</tr>
<tr>
	<td align="center" valign="top">�A��J�@��:
	<input type="password" size="32" maxlength="32" name="login_pass2" ></td>
</tr>
<tr>
	<td align="center" valign="top"><input type="submit" name="key" value="���K�X"></td>
</tr>
</form></table>���T�O��Ʀw���A�аȥ���u�H�U�ƶ��G<br>
			1.�K�X�ܤ֬��|�ӼƦr�B�r���βŸ��զ��C<br>
			2.�K�X���i���t�ιw�]�K�X�A�̦n�]���O�ۤv�������Ҧr���C<br>
			3.�K�X���i�M�b���ۦP�C';
else $main="</table><br><br><center>�t�κ޲z�������\�ǥͥi�H�ۦ�ק�K�X�I</center>";
echo $main;
foot();
?>