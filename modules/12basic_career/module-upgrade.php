<?php
// $Id: module-upgrade.php 5419 2009-03-06 02:38:26Z brucelyc $
if(!$CONN){
        echo "go away !!";
        exit;
}

// �ˬd��s�_
// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");
$up_file_name =$upgrade_str."2013-04-18.txt";
//���ܤW���ɮ׬�text���A�H�K�i�H�h�ɪ���
if (!is_file($up_file_name)){
	$SQL = "ALTER TABLE career_self_ponder DROP INDEX `student_sn`,ADD UNIQUE `student_sn` (`student_sn` ,`id`)";
	$rs=$CONN->Execute($SQL);
	if ($rs) {$temp_query = "�����ޫ��A���\-- by infodaes (2013-04-18)\n $SQL";}
	else {$temp_query = "�����ޫ��A���� !!,�Ф�ʧ�s�U�C�y�k\n $SQL";}

	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query.$str);
	fclose ($fp);
	unset($temp_query);unset($str);
}

$up_file_name =$upgrade_str."2013-08-02.txt";
if (!is_file($up_file_name)){
	$SQL = "ALTER TABLE `career_race` ADD `race_bonus` FLOAT NOT NULL DEFAULT '1';";
	$rs=$CONN->Execute($SQL);
	if ($rs) {$temp_query = "�W�[ �v�ɿn���v����� ���\-- by infodaes (2013-04-18)\n $SQL";}
	else {$temp_query = "�W�[ �v�ɿn���v����� ���� !,�Ф�ʧ�s�U�C�y�k\n $SQL";}

	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query.$str);
	fclose ($fp);
	unset($temp_query);unset($str);
}