<?php
// $Id: module-upgrade.php 7453 2013-08-30 00:56:09Z hami $

if(!$CONN){
        echo "go away !!";
        exit;
}

// �ˬd��s�_
// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path();
$upgrade_str = set_upload_path("$upgrade_path");
$up_file_name =$upgrade_str."2005-04-06.txt";

if (!is_file($up_file_name)){
	$query = "ALTER TABLE `school_base` change `sch_ename` `sch_ename` varchar(60) NOT NULL default ''";
	if ($CONN->Execute($query))
		$temp_str = "$query\n ��s���\ ! \n";
	else
		$temp_str = "$query\n ��s���� ! \n";
	$temp_query = "���Ǯխ^��W���� -- by brucelyc (2005-04-06)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

$upgrade_path = "upgrade/".get_store_path();
$upgrade_str = set_upload_path("$upgrade_path");
$up_file_name =$upgrade_str."2013-08-30.txt";

if (!is_file($up_file_name)){
	// ���N teach_title_id =0 �R���A�H�K��s����
	$query = "DELETE FROM  `teacher_title` WHERE teach_title_id=0";
	$CONN->Execute($query);
	$query = "ALTER TABLE `teacher_title` CHANGE `teach_title_id` `teach_title_id` int UNSIGNED NOT NULL AUTO_INCREMENT";
	if ($CONN->Execute($query))
		$temp_str = "$query\n ��s���\ ! \n";
	else
		$temp_str = "$query\n ��s���� ! \n";
	$temp_query = "��� teacher_title_id �� AUTO_INCREMENT -- by hami (2013-08-29)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

?>
