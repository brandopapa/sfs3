<?php
// $Id: module-upgrade.php 7517 2013-09-12 21:51:42Z hami $
if(!$CONN){
        echo "go away !!";
        exit;
}

// �ˬd��s�_
// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");

//���X�M��ЫǦW
$up_file_name =$upgrade_str."2004-9-25.txt";
if (!is_file($up_file_name)){
	$query="select * from spec_classroom where 1=0";
	if ($CONN->Execute($query))
		$temp_str = "�M��ЫǪ�w�s�b, �L�ݤɯšC";
	else {
		$query="CREATE TABLE if not exists spec_classroom (
			room_id smallint(5) unsigned NOT NULL auto_increment,
			room_name varchar(20) NOT NULL default '',
			enable enum('0','1') NOT NULL default '1',
			PRIMARY KEY (room_id))";
		if ($CONN->Execute($query))
			$temp_str = "$query\n �M��ЫǪ�إߦ��\ ! \n";
		else
			$temp_str = "$query\n �M��ЫǪ�إߥ��� ! \n";
		$query="select distinct room from score_course order by room";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			if (addslashes($res->fields[room])) {
				$query_insert="insert into spec_classroom (room_name) values ('".addslashes($res->fields[room])."')";
				$CONN->Execute($query_insert);
			}
			$res->MoveNext();
		}
	}
	$temp_query = "���X�M��ЫǦW -- by brucelyc (2004-9-25)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

//�M��Ыǥ[�J���}��`��
$up_file_name =$upgrade_str."2004-10-22.txt";
if (!is_file($up_file_name)){
	$query="ALTER TABLE `spec_classroom` ADD `notfree_time` VARCHAR(250)";
	if ($CONN->Execute($query))
		$temp_str = "$query\n �M��ЫǷs�W����`����إߦ��\ ! \n";
	else
		$temp_str = "$query\n �M��ЫǷs�W����`����إߥ��� ! \n";

	$temp_query = "�M��Ы����s�W -- by prolin (2004-10-22)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

//�M��Ыǥ[�J�w���Z��
$up_file_name =$upgrade_str."2005-10-13.txt";
if (!is_file($up_file_name)){
	$query="ALTER TABLE `course_room` ADD `seme_class` VARCHAR(10) NOT NULL default ''";
	if ($CONN->Execute($query))
		$temp_str = "$query\n �M��ЫǷs�W�w���Z����إߦ��\ ! \n";
	else
		$temp_str = "$query\n �M��ЫǷs�W�w���Z����إߥ��� ! \n";

	$temp_query = "�M��Ы����s�W -- by brucelyc (2005-10-13)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

//�[�J�h���ߤ@����

$up_file_name =$upgrade_str."2013-9-13.txt";
if (!is_file($up_file_name)){
	$query ="ALTER TABLE `course_room` drop index conflict;";
	$CONN->Execute($query);
	$query="ALTER TABLE `course_room` ADD UNIQUE `conflict` ( `date` , `sector` , `room` );";
	if ($CONN->Execute($query))
		$temp_str = "$query\n �M��ЫǷs�W�ߤ@������إߦ��\ ! \n";
	else
		$temp_str = "$query\n �M��ЫǷs�W�ߤ@������إߥ��� ! \n";

	$temp_query = "�M��Ыǰߤ@������s�W -- by infodaes (2006-3-16) \n\n ���R�����ަA�إ�(hami 2013-09-13) $temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}
?>
