<?php

//$Id: module-upgrade.php 5310 2009-01-10 07:57:56Z hami $

if(!$CONN){
	echo "go away !!";
	exit;
}

//��� ����ݩ�
//�[�J teacher_sn
// �ˬd��s�_
// ��s�O���ɸ��|
//$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_path = "upgrade/modules/stud_eduh/";
$upgrade_str = set_upload_path("$upgrade_path");
$up_file_name =$upgrade_str."2003-06-01.txt";
//echo get_store_path();
if (!is_file($up_file_name)){

	//SQL �y�k
	$query = "ALTER TABLE `stud_seme_test` ADD `teacher_sn` INT UNSIGNED NOT NULL";
	// ��ƪ�W��
	$arr[0][table_name]='stud_seme_test';

	// �ˬd���
	$arr[0][field_name]='teacher_sn';

	// ����줣�s�b��ƪ�
	$arr[0][check_in_table] = 0;

	// ��� stud_seme_test �� st_id �ݩ�
	if (upgrade_table ($query,$arr))
		//��� st_id �ݩʬ� AUTO_INCREMENT
		upgrade_table("ALTER TABLE `stud_seme_test` CHANGE `st_id` `st_id` BIGINT( 20 ) UNSIGNED DEFAULT '0' NOT NULL AUTO_INCREMENT");

		$temp_query = "��� ����ݩʥ[�J teacher_sn -- by hami (2003-06-01)";
        $fp = fopen ($up_file_name, "w");
        fwrite($fp,$temp_query);
        fclose ($fd);

}

//�s�W�ŦX XML 3.0�榡���߲z�����ƪ�
$up_file_name =$upgrade_str."2007-01-07.txt";
if (!is_file($up_file_name)){

	//SQL �y�k
	$query = "CREATE TABLE `stud_psy_test` (
  `sn` int(10) unsigned NOT NULL auto_increment,
  `year` tinyint(4) unsigned NOT NULL default '0',
  `semester` tinyint(4) unsigned NOT NULL default '0',
  `student_sn` int(10) unsigned NOT NULL default '0',
  `item` varchar(60) NOT NULL default '',
  `score` varchar(10) default NULL,
  `model` varchar(30) NOT NULL default '',
  `standard` varchar(10) NOT NULL default '',
  `pr` varchar(10) NOT NULL default '',
  `explanation` varchar(60) NOT NULL default '',
  `teacher_sn` int(10) unsigned NOT NULL default '0',
  `update_time` datetime default NULL,
  PRIMARY KEY  (`sn`)
);";
  if ($CONN->Execute($query)) 
		$temp_query = "�s�W�ŦX XML 3.0�榡���߲z�����ƪ� -- by infodaes (2007-01-07)\n$query";
	else
		$temp_query = "�s�W�ŦX XML 3.0�榡���߲z�����ƪ� stud_psy_tes ���� !!,�Ф�ʧ�s�U�C�y�k\n $query";

        $fp = fopen ($up_file_name, "w");
        fwrite($fp,$temp_query);
        fclose ($fd);
}

//XML 3.0�榡���߲z�����ƪ� -- �[���@������
$up_file_name =$upgrade_str."2007-01-10.txt";
if (!is_file($up_file_name)){

	//SQL �y�k
	$query = "ALTER TABLE `stud_psy_test` ADD `test_date` DATE AFTER `semester`";

  if ($CONN->Execute($query)) 
		$temp_query = "�s�WXML 3.0�榡���߲z�����ƪ� -- ������ ���-- by infodaes (2007-01-07)\n$query";
	else
		$temp_query = "�s�WXML 3.0�榡���߲z�����ƪ� -- ������ ��� ���� !!,�Ф�ʧ�s�U�C�y�k\n $query";

        $fp = fopen ($up_file_name, "w");
        fwrite($fp,$temp_query);
        fclose ($fd);
}

//�W�[3.0�榡���߲z�����ƪ����e��
$up_file_name =$upgrade_str."2008-01-10.txt";
if (!is_file($up_file_name)){

	//SQL �y�k
	$query = "ALTER TABLE `stud_psy_test` CHANGE `item` `item` VARCHAR( 60 ) ,
CHANGE `score` `score` VARCHAR( 40 ) DEFAULT NULL ,
CHANGE `model` `model` VARCHAR( 40 ) ,
CHANGE `standard` `standard` VARCHAR( 40 ) ,
CHANGE `pr` `pr` VARCHAR( 40 ) ,
CHANGE `explanation` `explanation` VARCHAR( 100 )";

  if ($CONN->Execute($query)) 
		$temp_query = "���������e��-- by infodaes (2008-01-10)\n$query";
	else
		$temp_query = "���������e�ץ��� !!,�Ф�ʧ�s�U�C�y�k\n $query";

        $fp = fopen ($up_file_name, "w");
        fwrite($fp,$temp_query);
        fclose ($fd);
}

?>
