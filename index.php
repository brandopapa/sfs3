<?php

// $Id: index.php 8627 2015-12-07 15:52:49Z qfon $

//�Ұ� session
//session_start();

/* ���o�ǰȨt�γ]�w�� */
// 1. �ޤJ include/config.php
// 2. config.php �ޤJ sfs_API.php (�D�n�\��禡��)
// 3. sfs_API.php �A�ޤJ $THEME_FILE_function.php
if (is_file('./include/config.php'))
	require "include/config.php";
if (empty($SFS_PATH)){
	if(is_readable('./install.php'))
		header("Location: install.php");
	else {
		check_text_table("�w�˵{�����~!","�Х��N ".dirname(__FILE__)."/install.php �]���iŪ��");
		exit;
	}

}

//  --�{�����Y
head("����","",1);

//�C�X�Ҳ�
// print_module �o�Ө禡�O�b�U�� THEME �� $THEME_FILE_function.php ���өw�q
sys_check();

print_module($_REQUEST['_Msn'],"",$nocols);

//��X�޲z�̩m�W
$str=get_admin_name();
$ax=get_module_setup("chang_root");
if ($ax["root_homeview"]==1)$str="";


//�h�����ƿ���ܺ��ީm�W
if ($SCHOOL_BASE['sch_sheng']=='���ƿ�') $str='';

//  --�{���ɧ�
foot($str);


function sys_check(){
	global $SFS_PATH;
	$text = '';
	if(is_writable ($SFS_PATH."/include/config.php")){
		$text = "<li>�z�� $SFS_PATH"."/include/config.php �ɥثe�O�i�H�g�J���A�бN���ݩʧאּ��Ū�C</li>";
	}
//	if(is_readable('./install.php'))
//		$text .= "<li>�в��� $SFS_PATH"."/install.php �o��w�˵{��,<BR /> �Χאּ���iŪ�� chmod 600 $SFS_PATH"."/install.php </li>";
	if ($text<>''){
		check_text_table("�t�Φw��ĵ�i",$text);
		foot();
		exit;
	}

}

function check_text_table($title,$msg){
	echo "
	<table style='background-gcolor:#ED4112;margin:auto' cellspacing=1 cellpadding=4>
	<tr bgcolor='#FDD235'>
	<td>$title</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
	<td>
	$msg
	</td></tr>
	</table>
	";
}
?>
