<?php
// $Id: $

if(!$CONN){
	echo "go away !!";
	exit;
}

// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");
$up_file_name =$upgrade_str."2010-09-27.txt";
if (!is_file($up_file_name)){
	$query ="ALTER TABLE `cita_kind` ADD `bonus_set` VARCHAR(40) NULL";
	if ($CONN->Execute($query))
		$str="���\\ ";
	else
		$str="����";
	$temp_query = "�� cita_kind ��ƪ�ɤJ bonus_set ���".$str." -- by infodaes (2010-09-27)\n$query";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");
$up_file_name =$upgrade_str."2010-09-28.txt";
if (!is_file($up_file_name)){
	$query ="ALTER TABLE `cita_data` ADD `bonus` TINYINT UNSIGNED NULL";
	if ($CONN->Execute($query))
		$str="���\\ ";
	else
		$str="����";
	$temp_query = "�� cita_data ��ƪ�ɤJ bonus ���".$str." -- by infodaes (2010-09-28)\n$query";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");
$up_file_name =$upgrade_str."2012-05-09.txt";
if (!is_file($up_file_name)){
	$query ="ALTER TABLE `cita_data` ADD `guidance_name` VARCHAR(20) NULL AFTER `stud_name`";
	if ($CONN->Execute($query))
		$str="���\\ ";
	else
		$str="����";
	$temp_query = "�� cita_data ��ƪ�[�J���ɪ�(guidance_name)���".$str." -- by infodaes (2012-05-09)\n$query";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");
$up_file_name =$upgrade_str."2013-01-18.txt";
if (!is_file($up_file_name)){
	$query ="ALTER TABLE `cita_kind` ADD `external` tinyint(4) NULL AFTER `grada`";
	if ($CONN->Execute($query))
		$str="���\\ ";
	else
		$str="����";
	$temp_query = "�� cita_kind ��ƪ�[�J��~�S���{�P�_(external)���".$str." -- by infodaes (2013-01-18)\n$query";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

?>
