<?php
// $Id:  $

if(!$CONN){
	echo "go away !!";
	exit;
}

// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");
$up_file_name =$upgrade_str."2013-10-04.txt";
if (!is_file($up_file_name)){
	$query ="ALTER TABLE `12basic_ptc` CHANGE `disability_id` `disability_id` VARCHAR( 1 ) NULL DEFAULT NULL ;";
	if ($CONN->Execute($query))
		$str="���\\ ";
	else
		$str="����";
	$temp_query = "���߻�ê�N�X���אּ��r���A ".$str." -- by infodaes (2013-10-04)\n$query";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}


// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");
$up_file_name =$upgrade_str."2014-11-23.txt";
if (!is_file($up_file_name)){
	$query ="ALTER TABLE `12basic_ptc` CHANGE `score_competetion` `score_competetion` FLOAT UNSIGNED NULL DEFAULT NULL; ;";
	if ($CONN->Execute($query))
		$str="���\\ ";
	else
		$str="����";
	$temp_query = "�v�ɿn�����אּ�B�I�� ".$str." -- by infodaes (2014-11-23)\n$query";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}


// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");
$up_file_name =$upgrade_str."2014-12-05.txt";
if (!is_file($up_file_name)){
	$query ="ALTER TABLE `12basic_ptc` ADD `score_fitness_assign` float NULL AFTER `score_fitness`; ";
	if ($CONN->Execute($query))
		$str="���\\ ";
	else
		$str="����";
	$temp_query = "�W�[��ʫ��w��A��n����� ".$str." -- by infodaes (2014-12-05)\n$query";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}



?>
