<?php

// $Id: school_list.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";

sfs_check();

if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
}

//�W���ɮ�
$submit=$_POST[submit];
$file = $_FILES['file']['tmp_name'];
$file_name = $_FILES['file']['name'];
if($submit){
    $temp_path = $UPLOAD_PATH."sign_act/";
	$upload_dir = chdir($temp_path);
	if($upload_dir==false)mkdir($temp_path);
	copy($file,$temp_path.$file_name);// �ƻs�ɮ�
}
//�P�_�W�ǥؿ����ɮ׬O�_�s�b
if(file_exists($UPLOAD_PATH."sign_act/".$SCHOOL_LIST)){
	$file_url= $UPLOAD_URL."./sign_act/";
}else{
	$file_url="./";
}

head("�W�ǾǮժ�C") ;
print_menu($menu_p);

$main = "<table border=1 cellpadding='7' cellspacing='0' bgcolor='#BED2FF' bordercolordark='white' bordercolorlight='black'>
			<tr><form action='$_SERVER[PHP_SELF]'  enctype='multipart/form-data' method='POST'>
				<td valign='top'>�ɮרӷ��G<input type='file' name='file'><p>
				<input type='submit' name='submit' value='�T�w�W��'>
				</td>
				<td valign='top'>�ɮפW�ǻ����G<p>
				<li>�ק�i <a href=".$file_url.$SCHOOL_LIST.">�d�� </a>�j�ɮסA����ɦW�H��W��(����]�i)�C</li>
				<li>�W�ǧ����H��A�Ц� �u/ �t�κ޲z / �Ҳ��v���޲z�v���^�w�]�ȡA<br>&nbsp;&nbsp;&nbsp;&nbsp;�ק令�z���ɮצW�١C</li>
				</td>
			</tr></table>";

echo $main ;

foot();

?>