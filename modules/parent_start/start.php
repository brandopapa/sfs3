<?php
// $Id: start.php 5310 2009-01-10 07:57:56Z hami $
// �ޤJ SFS3 ���禡�w
include "../../include/config.php";

// �ޤJ�z�ۤv�� config.php ��
require "config.php";

// �s�� SFS3 �����Y
head("�Ұʮa���b��");

// �{��
//sfs_check();

//
// �z���{���X�Ѧ��}�l

//�����ܼ��ഫ��*****************************************************
$submit=($_GET['submit'])?$_GET['submit']:$_POST['submit'];
$parent_id=($_GET['parent_id'])?$_GET['parent_id']:$_POST['parent_id'];
$start_code=($_GET['start_code'])?$_GET['start_code']:$_POST['start_code'];
$email=($_GET['email'])?$_GET['email']:$_POST['email'];


//********************************************************************

//��V������
//echo print_menu($MENU_P);

if($submit=="�T�w"){
	//�ˬd�e�X����ƬO�_���T
	$parent_id=trim($parent_id);
	$start_code-trim($start_code);
	$email=trim($email);
	if(!checkemail($email)) { echo "�z�ҿ�J��email��m�����T�A�Ц^<span class='button'><a href='javascript:history.back(-1);'>�W�@��</a></span>���s��J";  exit;}
	$sql="select count(*) from parent_auth where parent_id='$parent_id' and start_code='$start_code' and enable='1'";
	$rs=$CONN->Execute($sql) or die($sql);
	$CK=$rs->fields[0];
	if($CK=="1"){
		//�g�J��ƪ�A�ñҰʸӱb���M�H�Xmail
		$new_pass=creat_code($level="2",$many_char="8");
		$upd_sql="update parent_auth set enable='2' , login_id='$parent_id' , parent_pass='$new_pass' , email='$email' where parent_id='$parent_id' and start_code='$start_code' ";
		$CONN->Execute($upd_sql) or die($upd_sql);
		//�}�l�H�H
		$user_parent=$email;
		$mail_subject="�Ӧ�".$school_short_name."�ǰȨt�Ϊ��H��";
		$mail_message="�Q�a���G\n�z��".$school_short_name."�ǰȨt�αb���w�g�Ұ�\n
�b���G$parent_id\n�K�X�G$new_pass\n
�ХߧY�ܡy<a href='$SFS_PATH_HTML'>��¾�q�p</a>�z�ק�z���b���K�X�A�ä��w�ɥ[�H�ץ��A�H���b���Q�L�H���o�I\n
".$school_short_name."�ǰȨt�ηq�W";
		
		mail($user_parent, $mail_subject, $mail_message);
		
		//��ܰT�����ϥΪ��[��
		echo "�z���b���w�g�ҥΥB�H�X�A�Хαz��~��J��EMAIL��}���H�A�åߧY��<span class='button'><a href='../parent'>��¾�q�p</a></span>���z���b���K�X";
	}
	else{		
		echo "�z�ҿ�J����Ʀ��~�A�Ц^<span class='button'><a href='javascript:history.back(-1);'>�W�@��</a></span>���s��J";
	}
}
else{
	$form="<table cellspacing='1' cellpadding='6' border='0' bgcolor='#FFCAF8'><form name='start_form' method='post' action='{$_SERVER['PHP_SELF']}'>
				<tr bgcolor='#F2A3FD'><td>���@�H�����Ҧr��</td><td><input type='text' name='parent_id' size=10 maxlength=10></td></tr>
				<tr bgcolor='#F2A3FD'><td>�ҰʽX</td><td><input type='text' name='start_code' size=10 maxlength=10></td></tr>
				<tr bgcolor='#F2A3FD'><td>E-mail</td><td><input type='text' name='email' size=20 maxlength=60></td></tr>
				<tr bgcolor='#F2A3FD'><td colspan=2 align='center'><input type='submit' name='submit' value='�T�w'></td></tr>
			</table></form>";
	echo $form;
}
// SFS3 ������
foot();


function checkemail($email){
   if (eregi("themail.com",$email)) return 0;
   if (!$email) return 0;
   $a=split('@',$email);
   if (stripslashes($a[0])!=$a[0]) return 0;
   if (ereg_replace("[[:alnum:]._-]+","",$a[0])!="") return 0;
   if (!$a[1]) return 0;
   //�Ǧ^hostname��IP��}
   $b=@gethostbyname($a[1]);    
   if ($b!=$a[1]) return 1;
   //�j�MDNS���AMX���O���A�p�G���O���h�Ǧ^true
   if (checkdnsrr($a[1])) return 1;
   return 0;
}
?>

