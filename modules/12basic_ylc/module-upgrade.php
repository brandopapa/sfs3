<?php
//$Id: $

if(!$CONN){
	echo "go away !!";
	exit;
}

//��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");

//�W�[���߻�ê���
$up_file_name = $upgrade_str."2013-09-30.txt";
if (!is_file($up_file_name)) {
	$temp_str = $query." �W�[���߻�ê����s���� -- by ���L���ǰȨt�Τp�� (2013-10-01) !\n";
	$query = "ALTER TABLE `12basic_ylc` ADD `disability_id` tinyint(3) unsigned DEFAULT NULL";
	if ($CONN->Execute($query)) {
		$query = "ALTER TABLE `12basic_kind_ylc` ADD `disability_data` text NOT NULL";
		if ($CONN->Execute($query)) {
			$temp_str = $query." �W�[���߻�ê��� disability_id �P disability_data ��Ʀ��\ -- by ���L���ǰȨt�Τp�� (2013-09-30) !\n";
		}
	}
	$fp = fopen ($up_file_name, "w");
	fwrite($fp, $temp_str);
	fclose ($fp);
}

//�ק鶴�߻�ê��쫬�AALTER TABLE  `12basic_ylc` CHANGE  `disability_id`  `disability_id` VARCHAR( 3 ) NOT NULL COMMENT  '���߻�ê'
$up_file_name = $upgrade_str."2014-02-27.txt";
if (!is_file($up_file_name)) {
	$temp_str = $query." �ק鶴�߻�ê��쫬�A���� -- by ���L���ǰȨt�Τp�� (2014-02-27) !\n";
	$query = "ALTER TABLE `12basic_ylc` CHANGE `disability_id` `disability_id` VARCHAR(3) NOT NULL";
	if ($CONN->Execute($query)) {
		$temp_str = $query." �ק鶴�߻�ê��쫬�A disability_id ���\ -- by ���L���ǰȨt�Τp�� (2014-02-27) !\n";
	}
	$fp = fopen ($up_file_name, "w");
	fwrite($fp, $temp_str);
	fclose ($fp);
}

//�W�[��ƫʦs���
$up_file_name = $upgrade_str."2017-11-20.txt";
if (!is_file($up_file_name)) {
	$temp_str = $query." �W�[��ƫʦs����s���� -- by ���L���ǰȨt�Τp�� (2017-11-20) !\n";
	$query = "ALTER TABLE `12basic_ylc` ADD `editable` tinyint(3) unsigned DEFAULT 1";
	if ($CONN->Execute($query)) {
		$temp_str = $query." �W�[��ƫʦs��� editable ��Ʀ��\ -- by ���L���ǰȨt�Τp�� (2017-11-20) !\n";
	}
	$fp = fopen ($up_file_name, "w");
	fwrite($fp, $temp_str);
	fclose ($fp);
}

?>