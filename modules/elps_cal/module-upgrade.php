<?php
// $Id: module-upgrade.php 5619 2009-09-01 16:09:29Z infodaes $
if(!$CONN){echo "go away !!"; exit;}

// �ˬd��s�_
// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");
$up_file_name =$upgrade_str."2007-03-04.txt";

if (!is_file($up_file_name)){
	$query = "ALTER TABLE `cal_elps_set` ADD `week_mode` TINYINT( 1 ) DEFAULT '0' NOT NULL ";
	if ($CONN->Execute($query))
		$temp_str = "$query\n ��s���\ ! \n";
	else
		$temp_str = "$query\n ��s���� ! \n";
	$temp_query = "�s�W�g���p��Ҧ�  by chi (2007-03-04)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

$up_file_name =$upgrade_str."2009-09-01.txt";
if (!is_file($up_file_name)){
	$query = "ALTER TABLE `cal_elps` ADD `important` TINYINT DEFAULT '0' NOT NULL ;";
	if ($CONN->Execute($query))
		$temp_str = "$query\n ��s���\ ! \n";
	else
		$temp_str = "$query\n ��s���� ! \n";
	$temp_query = "�s�W�Ǯդj�ưO�����(important)  by infodaes (2009-09-01)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}
?>
