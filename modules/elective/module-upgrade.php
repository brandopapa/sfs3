<?php
// $Id: module-upgrade.php 5310 2009-01-10 07:57:56Z hami $

if(!$CONN){
        echo "go away !!";
        exit;
}

// �ˬd��s�_
// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path();
$upgrade_str = set_upload_path("$upgrade_path");
$up_file_name =$upgrade_str."2004-05-27.txt";

if (!is_file($up_file_name)){
	$query = "ALTER TABLE `elective_tea` ADD `course_id` mediumint(8) unsigned NOT NULL default '0';";
	if ($CONN->Execute($query))
		$temp_str = "$query\n ��s���\ ! \n";
	else
		$temp_str = "$query\n ��s���� ! \n";
	$temp_query = "�s�W���N�ҵ{�N�X��� -- by brucelyc (2004-05-27)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}
?>
