<?php
//$Id: query.php 7847 2014-01-09 05:51:44Z hami $
include "config.php";
include "../../include/sfs_case_dataarray.php";

//�{��
sfs_check();

//�q�X�����������Y
head("�ǥͱK�X�޲z");

//�D�n���e
print_menu($school_menu_p);
$stud_id=$_POST[stud_id];
$mode=$_POST[mode];
$passwd=$_POST[email_pass];
$stud_study_cond=study_cond();
$change="�ק�K�X";
$finish="�ק粒��";
if (count($passwd)>0 && $mode==$finish) {
	while(list($student_sn,$email_pass)=each($passwd)) {
		$ldap_password = createLdapPassword($email_pass);
		$query="update stud_base set email_pass='$email_pass' , ldap_password='$ldap_password'  where student_sn='$student_sn'";
		
		$CONN->Execute($query) or die($query);
	}
	$mode="";
}

//��ܿﶵ
$edit_content=($mode)?$finish:$change;
$edit_submit=($stud_id)?"<input type='submit' name='mode' value='$edit_content'>":"";
$main="	<table border=0 cellspacing=1 cellpadding=2 width=100% bgcolor=#cccccc class=small>\n
	<form method='post' action='{$_SERVER['PHP_SELF']}'>\n
	<tr><td bgcolor='#FFFFFF'>&nbsp;�ǥ;Ǹ�<input type='text' maxlength='10' size='10' name='stud_id' value='$stud_id'><input type='submit' name='set' value='�}�l�d��'>$edit_submit<br>\n";
if ($stud_id) {
	$query="select * from stud_base where stud_id='$stud_id' order by student_sn";
	$res=$CONN->Execute($query) or die($query);
	$data_str="";
	while(!$res->EOF) {
		$email_pass=$res->fields[email_pass];
		$student_sn=$res->fields[student_sn];
		$pass=($mode)?"<input type=text name='email_pass[$student_sn]' value='$email_pass' size='10' maxlength='10'>":$email_pass; 
		$data_str.="<tr bgcolor=#FFFFFF><td align='center'>".$res->fields[stud_id]."</td><td align='center'>".$res->fields[stud_name]."</td><td align='center'>".$pass."</td><td align='center'><font color=#000088>".$stud_study_cond[$res->fields[stud_study_cond]]."</font></td></tr>\n";
		$res->MoveNext();
	}
	$main.="<table border=0 cellspacing=1 cellpadding=2 bgcolor=#9ebcdd class=small>\n
		<tr bgcolor=#c4d9ff><td align='center'>�Ǹ�</td><td align='center'>�m�W</td><td align='center'>�K�X</td><td align='center'>�N�Ǫ��A</td></tr>\n";
	if ($data_str) {
		$main.=$data_str."</table>";
	} else {
		$main.="<tr bgcolor=#FFFFFF><td align='center' colspan='4'>�d�L���ǥ�</td></tr></table><input type='hidden' name='error' value='1'>\n";
	}
}
$main.="</tr></form></table>\n";
echo $main;

//�G������
foot();
?>
