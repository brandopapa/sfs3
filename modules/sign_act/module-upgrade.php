<?php
// $Id: module-upgrade.php 5310 2009-01-10 07:57:56Z hami $


// �ˬd��s�_
// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");


//�H�W�O�d--------------------------------------------------------


//�ק��ƪ�A�[�J school_list ���

$up_file_name =$upgrade_str."2004-10-22.txt";
if (!is_file($up_file_name)){
	$query=" ALTER TABLE sign_act_kind ADD school_list  TEXT NOT NULL  ; ";
	if ($CONN->Execute($query))
		$temp_str = "$query\n �ջڳ��W�s�W school_list ��إߦ��\ ! \n";
	else
		$temp_str = "$query\n �ջڳ��W�s�W school_list ��إߥ��� ! \n";

	$temp_query = "�ջڳ��W�s�W���s�W -- by prolin (2004-10-22)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

?>
