<?php
// $Id: module-upgrade.php 5310 2009-01-10 07:57:56Z hami $

if(!$CONN){
        echo "go away !!";
        exit;
}

// �ˬd��s�_
// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");

// �[�J
$up_file_name =$upgrade_str."2005-10-21.txt";
if (!is_file($up_file_name)){
	$query = "ALTER TABLE `school_board` ADD `poster_name` VARCHAR(20) NOT NULL default '';";
	if ($CONN->Execute($query))
		$temp_str = "$query\n ��s���\ ! \n";
	else
		$temp_str = "$query\n ��s���� ! \n";
	$query = "ALTER TABLE `school_board` ADD `poster_job` VARCHAR(20) NOT NULL default '';";
	if ($CONN->Execute($query))
		$temp_str .= "$query\n ��s���\ ! \n";
	else
		$temp_str .= "$query\n ��s���� ! \n";
	$temp_query = "�s�W�o�G�̸����� -- by prolin (2005-10-21)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}
?>
