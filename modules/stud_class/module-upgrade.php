<?php

//$Id: module-upgrade.php 6534 2011-09-22 09:46:05Z infodaes $

if(!$CONN){
	echo "go away !!";
	exit;
}

//��� ����ݩ�
//�[�J teacher_sn
//
// �ˬd��s�_
// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
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

$up_file_name =$upgrade_str."2004-11-29.txt";

if (!is_file($up_file_name)){
	$query="select * from stud_ext_data_menu where 1=0";
	if ($CONN->Execute($query))
		$temp_str = "�ǥ͸ɥR��ƿﶵ��w�s�b, �L�ݤɯšC";
	else {
			
		$query=" CREATE TABLE if not exists  `stud_ext_data_menu` (
			`id` INT NOT NULL AUTO_INCREMENT ,
			`ext_data_name` VARCHAR( 50 ) NOT NULL ,
			`doc` TEXT,
			PRIMARY KEY ( `id` )
			) COMMENT = '�ǥ͸ɥR��ƿﶵ' " ;	
		if ($CONN->Execute($query))
			$temp_str = "$query\n �ǥ͸ɥR��ƪ�إߦ��\ ! \n";
		else
			$temp_str = "$query\n �ǥ͸ɥR��ƪ�إߥ��� ! \n";

	}
	$query="select * from stud_ext_data where 1=0";
	if ($CONN->Execute($query))
		$temp_str = "�ǥ͸ɥR��ƿﶵ��w�s�b, �L�ݤɯšC";
	else {
		
		$query=" CREATE TABLE if not exists stud_ext_data (
  			stud_id varchar(8) NOT NULL default '',
  			mid int(11) NOT NULL default '0',
  			ext_data text NOT NULL,
  			teach_id varchar(10) NOT NULL default '',
  			ed_date date NOT NULL default '0000-00-00',
  			update_time timestamp(14) NOT NULL,
  			PRIMARY KEY  (stud_id,mid)
			);" ;	
			
		if ($CONN->Execute($query))
			$temp_str = "$query\n �ǥ͸ɥR�ӤH��ƪ�إߦ��\ ! \n";
		else
			$temp_str = "$query\n �ǥ͸ɥR�ӤH��ƪ�إߥ��� ! \n";

	}
	$temp_query = "�ǥ͸ɥR��ƪ��إ� -- by prolin (2004-9-25)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

$up_file_name =$upgrade_str."2009-02-02.txt";
if (!is_file($up_file_name)){
	$query ="ALTER TABLE `stud_domicile` ADD `fath_grad_kind` TINYINT( 4 ) DEFAULT '1' AFTER `fath_education` , ADD `moth_grad_kind` TINYINT( 4 ) DEFAULT '1' AFTER `moth_education` ;";
	if ($CONN->Execute($query))
		$str="�s�W���׷~�O��즨�\\";
	else
		$str="�s�W���׷~�O��쥢��";
	$temp_query = "�� stud_domicile ��ƪ�s�W�������׷~�O���H�ŦXXML 3.0".$str." -- by infodaes 2009-02-02 \n$query";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

?>
