<?php

// $Id:  $

//���o�]�w��
include_once "config.php";

sfs_check();

//�q�X����
head("���ǥ͵n�J�K�X");

//�Ҳտ��
print_menu($menu_p,$linkstr);

if($student_sn){
	//�x�s�����B�z
	if($_POST['go']=='���K�X'){
		$login_pass=$_POST[login_pass];
		if(strlen($login_pass)>=6){
			$login_pass2=$_POST[login_pass2];
			if($login_pass and $login_pass==$login_pass2){
				$query="update stud_base set email_pass ='$login_pass' where student_sn=$student_sn";
				$res=$CONN->Execute($query) or die("SQL���~:$query");
				$msg='�K�X��令�\�I';
			} else $msg='�s�K�X�B�T�{�s�K�X���P�A��異�ѡI';
		} else $msg='�s�K�X���פӵu�A��異�ѡI  �Цܤֿ�J6�Ӧr��';
	}

	$mydata="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
		<tr align='center'><td bgcolor='#ccccff'>��J�s�K�X</td><td><input type='password' size='32' maxlength='32' name='login_pass'></td></tr>
		<tr align='center'><td bgcolor='#ccccff'>�T�{�s�K�X</td><td><input type='password' size='32' maxlength='32' name='login_pass2'></td></tr>
		<tr bgcolor='#ccccff' align='center'>
			<td colspan=2>
				<input type='submit' value='���K�X' name='go' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")' style='border-width:1px; cursor:hand; color:white; background:#ff5555; font-size:16px; height=42'>
			</td>
		</tr></table>";
}

$main="<font size=2><form method='post' action='$_SERVER[SCRIPT_NAME]' name='myform'>
	<table style='border-collapse: collapse; font-size=12px;'><tr><td valign='top'>$class_select<br>$student_select</td><td valign='top'>$mydata<br>$msg</td></tr></table><font>";

echo $main;

foot();

?>
