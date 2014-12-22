<?php
// $Id: module-upgrade.php 8101 2014-08-31 14:51:15Z infodaes $
if(!$CONN){
        echo "go away !!";
        exit;
}

// �s�W�W�Ҥ��table seme_course_date

// �ˬd��s�_
// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");

$up_file_name =$upgrade_str."2003-08-22.txt";
if (!is_file($up_file_name)){
	$query = "CREATE TABLE seme_course_date (seme_year_seme varchar(6) NOT NULL default '', days tinyint(3) unsigned NOT NULL default '0', UNIQUE KEY seme_year_seme (seme_year_seme))  COMMENT='�Ǵ��W�Ҥ��'";

	if ($CONN->Execute($query)) 
		$temp_query = "�[�J�Ǵ��W�Ҥ�Ƹ�ƪ� seme_course_date -- by hami (2003-06-08)\n$query";
	else
		$temp_query = "�[�J�Ǵ��W�Ҥ�Ƹ�ƪ� seme_course_date ���� !!,�Ф�ʧ�s�U�C�y�k\n$query";
		
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

$up_file_name =$upgrade_str."2003-09-26.txt";
if (!is_file($up_file_name)){
	$query = "ALTER TABLE `seme_course_date` ADD `class_year` VARCHAR( 3 ) NOT NULL AFTER `seme_year_seme` ;";
	$CONN->Execute($query);
	$CONN->Execute("ALTER TABLE `seme_course_date` DROP INDEX `seme_year_seme` ");
	$query = "ALTER TABLE `seme_course_date` DROP PRIMARY KEY ,ADD PRIMARY KEY ( seme_year_seme, `class_year` ) ";
	
	if ($CONN->Execute($query)) 
		$temp_query = "�s�W�Ǵ��W�Ҥ�Ƹ�ƪ�~�����  -- by hami (2003-09-26)\n$query";
	else
		$temp_query = "�s�W�Ǵ��W�Ҥ�Ƹ�ƪ�~����쥢��! \n$query";
		
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

// �W�[�ɮv�m�W��� 
$up_file_name =$upgrade_str."2003-10-20.txt";
if (!is_file($up_file_name)){
	$query = array();
	$query[0] = "ALTER TABLE `school_class` ADD `teacher_1` VARCHAR(20) NOT NULL DEFAULT '';";
	$query[1] = "ALTER TABLE `school_class` ADD `teacher_2` VARCHAR(20) NOT NULL DEFAULT '';";
	$temp_str = '';
	for($i=0;$i<count($query);$i++) {	
		if ($CONN->Execute($query[$i]))
			$temp_str .= "$query[$i]\n ��s���\ ! \n";
		else
			$temp_str .= "$query[$i]\n ��s���� ! \n";
	}
	$temp_query = "�W�[�ɮv�m�W��� -- by brucelyc (2003-10-20)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

//���X�M��ЫǦW
$up_file_name =$upgrade_str."2004-9-25.txt";
if (!is_file($up_file_name)){
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
	$temp_query = "���X�M��ЫǦW -- by brucelyc (2004-9-25)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

//�M��Ыǥ[�J���}��`��
$up_file_name =$upgrade_str."2004-10-22.txt";
if (!is_file($up_file_name)){
	$query=" ALTER TABLE spec_classroom ADD notfree_time  VARCHAR( 250 ) ; ";
	if ($CONN->Execute($query))
		$temp_str = "$query\n �M��ЫǷs�W����`����إߦ��\ ! \n";
	else
		$temp_str = "$query\n �M��ЫǷs�W����`����إߥ��� ! \n";

	$temp_query = "�M��Ы����s�W -- by prolin (2004-10-22)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

//�s�ئU�`�W�Үɶ���
$up_file_name =$upgrade_str."2005-05-10.txt";
if (!is_file($up_file_name)){
	$query="CREATE TABLE if not exists section_time (
		year smallint(5) unsigned NOT NULL default '0',
		semester enum('1','2') NOT NULL default '1',
		sector tinyint(2) unsigned NOT NULL default '0',
		stime varchar(11) NOT NULL default '00:00-00:01',
		PRIMARY KEY (year,semester,sector))";
	if ($CONN->Execute($query))
		$temp_str = "$query\n �U�`�W�Үɶ���إߦ��\ ! \n";
	else
		$temp_str = "$query\n �U�`�W�Үɶ���إߥ��� ! \n";

	$temp_query = "�U�`�W�Үɶ���s�� -- by brucelyc (2005-05-10)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}


//�s�W�Юv�N�X���
$up_file_name =$upgrade_str."2005-07-29.txt";
if (!is_file($up_file_name)){
	$query=" ALTER TABLE `school_class` ADD `tea_sn_1` VARCHAR( 20 ) NOT NULL ,ADD `tea_sn_2` VARCHAR( 20 ) NOT NULL ; ";
//	ALTER TABLE `school_class` CHANGE `year` `year` VARCHAR( 5 ) NOT NULL 
	if ($CONN->Execute($query))
		$temp_str = "$query\n �s�W�Юv�N�X���إߦ��\ ! \n";
	else
		$temp_str = "$query\n �s�W�Юv�N�X���إߥ��� ! \n";

	$temp_query = "�s�W�Юv�N�X��� -- by chi (2005-07-29)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

//�ץ����Z�]�w���~
$up_file_name =$upgrade_str."2008-06-12.txt";
if (!is_file($up_file_name)){
        $query="update score_setup set rule='�u_>=_90\n��_>=_80\n�A_>=_70\n��_>=_60\n�B_<_60' where rule like '�u_>=90%'";
        if ($CONN->Execute($query))
                $temp_str = "$query\n �ץ����Z�]�w���~���\ ! \n";
        else
                $temp_str = "$query\n �ץ����Z�]�w���~���� ! \n";

        $temp_query = "�ץ����Z�]�w���~ -- by brucelyc (2008-06-12)\n\n$temp_str";
        $fp = fopen ($up_file_name, "w");
        fwrite($fp,$temp_query);
        fclose ($fp);
}

//�ץ���ƪ�primary key
$up_file_name =$upgrade_str."2008-10-17.txt";
if (!is_file($up_file_name)){
        $query="ALTER TABLE `seme_course_date` DROP primary key";
		$CONN->Execute($query);
		$query="ALTER TABLE `seme_course_date` ADD primary key (seme_year_seme,class_year)";
        if ($CONN->Execute($query))
                $temp_str = "$query\n �ץ�primary key���\ ! \n";
        else
                $temp_str = "$query\n �ץ�primary key���� ! \n";

        $temp_query = "�ץ�primary key -- by brucelyc (2008-10-17)\n\n$temp_str";
        $fp = fopen ($up_file_name, "w");
        fwrite($fp,$temp_query);
        fclose ($fp);
}

$up_file_name =$upgrade_str."2012-09-10.txt";
if (!is_file($up_file_name)){
        $query="ALTER TABLE `score_course` CHANGE `room` `room` VARCHAR(20);";
        if ($CONN->Execute($query))
                $temp_str = "$query\n �ץ� �M��ЫǦW�٪��׬�20 ���\ ! \n";
        else
                $temp_str = "$query\n �ץ� �M��ЫǦW�٪��׬�20 ���� ! \n";

        $temp_query = "�ץ� �M��ЫǦW�٪��׬�20  -- by infodaes (2012-09-10)\n\n$temp_str";
        $fp = fopen ($up_file_name, "w");
        fwrite($fp,$temp_query);
        fclose ($fp);
}

//�s�W��P�оǱЮv�N�X���
$up_file_name =$upgrade_str."2014-08-31.txt";
if (!is_file($up_file_name)){
	$query="ALTER TABLE `score_course` ADD `cooperate_sn` INT NULL AFTER `teacher_sn`; ";
	if ($CONN->Execute($query))
		$temp_str = "$query\n �s�W��P�оǱЮv�N�X���إߦ��\ ! \n";
	else
		$temp_str = "$query\n �s�W��P�оǱЮv�N�X���إߥ��� ! \n";

	$temp_query = "�s�W��P�оǱЮv�N�X��� -- by chi (2014-08-31)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

?>
