<?php

// $Id: module-upgrade.php 7779 2013-11-20 16:09:00Z smallduh $
if (!$CONN) {
    echo "go away !!";
    exit;
}

// �ˬd��s�_
// ��s�O���ɸ��|
$upgrade_path = "upgrade/" . get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");

$up_file_name = $upgrade_str . "2014-05-22.txt";
if (!is_file($up_file_name)) {
	//�W�[
	$query = "ALTER TABLE `jshow_pic` ADD url_click int(6) NOT NULL";
	$CONN->Execute($query);
	$fp = fopen($up_file_name, "w");
	$temp_query = "�[�J�s�����ưO�����	-- by smallduh (2014-05-22)";
	fwrite($fp, $temp_query);
	fclose($fp);
}

$up_file_name = $upgrade_str . "2014-05-19.txt";
if (!is_file($up_file_name)) {
	//�W�[
	$query = "ALTER TABLE `jshow_pic` ADD url text NOT NULL";
	$CONN->Execute($query);
	$fp = fopen($up_file_name, "w");
	$temp_query = "�[�J�u�W�s���v���	-- by smallduh (2014-05-19)";
	fwrite($fp, $temp_query);
	fclose($fp);
}

/* �w�d�d��
$up_file_name = $upgrade_str . "2014-03-20.txt";
if (!is_file($up_file_name)) {
	//�W�[
	$query = "ALTER TABLE `jboard_kind` ADD position tinyint(1) NOT NULL";
	$CONN->Execute($query);
	$fp = fopen($up_file_name, "w");
	$temp_query = "�����C��[�J�u�h�šv���	-- by smallduh (2013-12-17)";
	fwrite($fp, $temp_query);
	fclose($fp);
}
*/

