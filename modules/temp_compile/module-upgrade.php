<?php
// $Id: module-upgrade.php 6755 2012-05-04 08:06:15Z smallduh $

if(!$CONN){
        echo "go away !!";
        exit;
}

//
// �ˬd��s�_
// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");
$up_file_name =$upgrade_str."2005-06-23.txt";
if (!is_file($up_file_name)){
	$query="ALTER TABLE new_stud ADD stud_kind VARCHAR(10) NOT NULL  default '' ";
	$CONN->Execute($query);
	$query="ALTER TABLE new_stud ADD bao_id VARCHAR(10) NOT NULL  default '' AFTER stud_kind ";
	$CONN->Execute($query);
	$temp_query = "�b�s�͸�ƪ��s�W�ǥ����O���P���M�L��� -- by chi (2005-06-23)\n$query";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

$up_file_name =$upgrade_str."2005-07-04.txt";
if (!is_file($up_file_name)){
	$query="ALTER TABLE new_stud change sure_study sure_study enum('0','1','2')";
	$CONN->Execute($query);
	$temp_query = "���s�͸�ƪ����NŪ�аO���� -- by brucelyc (2005-07-04)\n$query";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

$up_file_name =$upgrade_str."2005-07-12.txt";
if (!is_file($up_file_name)){
	$query="ALTER TABLE new_stud change sure_study sure_study enum('0','1','2') NOT NULL default '0'";
	$CONN->Execute($query);
	$temp_query = "���s�͸�ƪ����NŪ�аO���� -- by brucelyc (2005-07-12)\n$query";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

$up_file_name =$upgrade_str."2004-07-20.txt";
if (!is_file($up_file_name)){
	$query="alter table new_stud add oth_class varchar(3) NOT NULL default '0'";
	$CONN->Execute($query);
	$query="alter table new_stud add oth_site smallint(5) NOT NULL default '0'";
	$CONN->Execute($query);
	$query="alter table new_stud add sure_oth enum('0','1') NOT NULL default '0'";
	$CONN->Execute($query);
	$temp_query = "�b�s�͸�ƪ��s�W�������ʯZ��, �������ʮy���� -- by brucelyc (2004-05-20)\n$query";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

$up_file_name =$upgrade_str."2012-05-04.txt";
if (!is_file($up_file_name)){
	$query="ALTER TABLE `new_stud` ADD `stud_name_eng` VARCHAR(30) NULL DEFAULT NULL , ADD `addr_move_in` DATE NULL DEFAULT NULL , ADD `stud_addr_2` VARCHAR(200) NULL DEFAULT NULL , ADD `stud_tel_3` VARCHAR(20) NULL DEFAULT NULL ";
	$CONN->Execute($query);
	$temp_query = "�b�s�͸�ƪ��s�W�^��m�W�B���y�E�J����B�p����}�B�p������� -- by smallduh (2012-05-04)\n$query";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

?>
