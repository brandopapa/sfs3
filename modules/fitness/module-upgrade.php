<?php
// $Id: module-upgrade.php 7825 2013-12-24 06:45:54Z smallduh $
if(!$CONN){
        echo "go away !!";
        exit;
}

// �ˬd��s�_
// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");

$up_file_name =$upgrade_str."2013-12-24.txt";

if (!is_file($up_file_name)){
	include_once "../../include/sfs_case_sql.php";
	$MODULE_SQL_FILE=dirname(__FILE__)."/module-new.sql";
	$query = fread(fopen($MODULE_SQL_FILE, 'r'), filesize($MODULE_SQL_FILE));
	run_sql($query, $mysql_db);
	$query="select * from fitness_mod where 1=0 limit 0,1";
	if ($CONN->Execute($query))
		$temp_str = "��s���\!\n";
	else
		$temp_str = "��s���� ! \n";
	$temp_query = "��s��A��`�� -- by smallduh (2013-12-24)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

$up_file_name =$upgrade_str."2013-12-24.txt";
if (!is_file($up_file_name)){
	include_once "../../include/sfs_case_sql.php";
	$MODULE_SQL_FILE=dirname(__FILE__)."/module-new.sql";
	$query = fread(fopen($MODULE_SQL_FILE, 'r'), filesize($MODULE_SQL_FILE));
	run_sql($query, $mysql_db);
	$query="select * from fitness_mod where 1=0 limit 0,1";
	if ($CONN->Execute($query))
		$temp_str = "��s���\!\n";
	else
		$temp_str = "��s���� ! \n";
	$temp_query = "��s��A��`�� -- by smallduh (2013-12-10)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}


$up_file_name =$upgrade_str."2012-12-26.txt";
if (!is_file($up_file_name)){
	include_once "../../include/sfs_case_sql.php";
	$MODULE_SQL_FILE=dirname(__FILE__)."/module-new.sql";
	$query = fread(fopen($MODULE_SQL_FILE, 'r'), filesize($MODULE_SQL_FILE));
	run_sql($query, $mysql_db);
	$query="select * from fitness_mod where 1=0 limit 0,1";
	if ($CONN->Execute($query))
		$temp_str = "��s���\!\n";
	else
		$temp_str = "��s���� ! \n";
	$temp_query = "�̱Ш|����A�����,��s��A��`�� -- by smallduh (2012-12-26)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

$up_file_name =$upgrade_str."2012-10-26.txt";
if (!is_file($up_file_name)){
	include_once "../../include/sfs_case_sql.php";
	$MODULE_SQL_FILE=dirname(__FILE__)."/module-new.sql";
	$query = fread(fopen($MODULE_SQL_FILE, 'r'), filesize($MODULE_SQL_FILE));
	run_sql($query, $mysql_db);
	$query="select * from fitness_mod where 1=0 limit 0,1";
	if ($CONN->Execute($query))
		$temp_str = "��s���\!\n";
	else
		$temp_str = "��s���� ! \n";
	$temp_query = "��s��A��`�� -- by smallduh (2012-10-26)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}
$up_file_name =$upgrade_str."2006-12-29.txt";
if (!is_file($up_file_name)){
	include_once "../../include/sfs_case_sql.php";
	$MODULE_SQL_FILE=dirname(__FILE__)."/module-new.sql";
	$query = fread(fopen($MODULE_SQL_FILE, 'r'), filesize($MODULE_SQL_FILE));
	run_sql($query, $mysql_db);
	$query="select * from fitness_mod where 1=0 limit 0,1";
	if ($CONN->Execute($query))
		$temp_str = "��s���\!\n";
	else
		$temp_str = "��s���� ! \n";
	$temp_query = "��s��A��`�� -- by brucelyc (2006-12-29)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

$up_file_name =$upgrade_str."2006-12-30.txt";
if (!is_file($up_file_name)){
	$query = "ALTER TABLE `fitness_data` ADD `student_sn` INT(10) DEFAULT '0'";
	if ($CONN->Execute($query)) {
		$temp_str = "��s���\!\n";
		$query="select student_sn,stud_id from stud_base";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			$CONN->Execute("update fitness_data set student_sn='".$res->fields[student_sn]."' where stud_id='".$res->fields[stud_id]."'");
			$res->MoveNext();
		}
		$CONN->Execute("ALTER TABLE `fitness_data` DROP `stud_id`");
		$CONN->Execute("ALTER TABLE `fitness_data` DROP PRIMARY KEY, ADD PRIMARY KEY (c_curr_seme,student_sn)");
	} else
		$temp_str = "��s���� ! \n";
	$temp_query = "�[�Jstudent_sn��� -- by brucelyc (2006-12-30)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

$up_file_name =$upgrade_str."2013-04-01.txt";
if (!is_file($up_file_name)){
	$query = "ALTER TABLE `fitness_data` ADD `organization` VARCHAR(100) NULL";
	if ($CONN->Execute($query)) {
		$temp_str = "��s���\!\n";
	} else	$temp_str = "��s���� ! \n";
	$temp_query = "�[�J �˴����organization ��� -- by Infodaes (2013-04-01)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}
?>
