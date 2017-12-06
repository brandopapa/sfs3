<?php
// $Id: module-upgrade.php 6534 2011-09-22 09:46:05Z infodaes $

if(!$CONN){
        echo "go away !!";
        exit;
}

// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");

$up_file_name =$upgrade_str."2008-09-01.txt";
if (!is_file($up_file_name)){
	$query = "ALTER TABLE `health_checks_record` DROP PRIMARY KEY,ADD PRIMARY KEY (year,semester,student_sn,subject,no)";
	if ($CONN->Execute($query)) {
		$temp_query = "��s�w�����˰O�����D�n�� -- by brucelyc (2008-09-01)\n$query";
		$fd = fopen ($up_file_name, "w");
		fwrite($fd,$temp_query);
		fclose ($fd);
	}
}

$up_file_name =$upgrade_str."2008-09-02.txt";
if (!is_file($up_file_name)){
	$creat_table_sql="CREATE TABLE if not exists health_fday (
		year smallint(5) unsigned NOT NULL default '0',
		semester enum('1','2') NOT NULL default '1',
		week_no smallint(5) unsigned NOT NULL default '0',
		do_date date NOT NULL default '0000-00-00',
		PRIMARY KEY (year,semester,week_no)
		)";
	if ($CONN->Execute($creat_table_sql)) {
		$temp_query = "�إߧt�t���f����I����� -- by brucelyc (2008-09-02)";
		$fd = fopen ($up_file_name, "w");
		fwrite($fd,$temp_query);
		fclose ($fd);
	}
}

$up_file_name =$upgrade_str."2008-09-03.txt";
if (!is_file($up_file_name)){
	$creat_table_sql="CREATE TABLE if not exists health_frecord (
		year smallint(5) unsigned NOT NULL default '0',
		semester enum('1','2') NOT NULL default '1',
		student_sn int(10) unsigned NOT NULL default '0',
		agree char(1) NOT NULL default '',
		w1 char(1) NOT NULL default '',
		w2 char(1) NOT NULL default '',
		w3 char(1) NOT NULL default '',
		w4 char(1) NOT NULL default '',
		w5 char(1) NOT NULL default '',
		w6 char(1) NOT NULL default '',
		w7 char(1) NOT NULL default '',
		w8 char(1) NOT NULL default '',
		w9 char(1) NOT NULL default '',
		w10 char(1) NOT NULL default '',
		w11 char(1) NOT NULL default '',
		w12 char(1) NOT NULL default '',
		w13 char(1) NOT NULL default '',
		w14 char(1) NOT NULL default '',
		w15 char(1) NOT NULL default '',
		w16 char(1) NOT NULL default '',
		w17 char(1) NOT NULL default '',
		w18 char(1) NOT NULL default '',
		w19 char(1) NOT NULL default '',
		w20 char(1) NOT NULL default '',
		w21 char(1) NOT NULL default '',
		w22 char(1) NOT NULL default '',
		w23 char(1) NOT NULL default '',
		w24 char(1) NOT NULL default '',
		w25 char(1) NOT NULL default '',
		update_date timestamp,
		teacher_sn int(11) NOT NULL default '0',
		PRIMARY KEY (year,semester,student_sn)
		)";
	if ($CONN->Execute($creat_table_sql)) $ok=" ���\ ";
	else $ok="����";
	$temp_query = "�إߧt�t���f����I�O���� $ok -- by brucelyc (2008-09-02)";
	$fd = fopen ($up_file_name, "w");
	fwrite($fd,$temp_query);
	fclose ($fd);
}

$up_file_name =$upgrade_str."accident.txt";
if (!is_file($up_file_name)){
	include_once "../../include/sfs_case_sql.php";
	$query="select * from health_accident_place where 1=0";
	if (!$CONN->Execute($query)) {
		$creat_table_sql="CREATE TABLE health_accident_place (
		id int(6) unsigned NOT NULL default '1',
		name varchar(100) NOT NULL default '',
		enable varchar(1) NOT NULL default '1',
		PRIMARY KEY (id)
		) ;
		INSERT INTO health_accident_place VALUES ( 1,'�޳�',1);
		INSERT INTO health_accident_place VALUES ( 2,'�C���B�ʾ���',1);
		INSERT INTO health_accident_place VALUES ( 3,'���q�Ы�',1);
		INSERT INTO health_accident_place VALUES ( 4,'�M��Ы�',1);
		INSERT INTO health_accident_place VALUES ( 5,'���Y',1);
		INSERT INTO health_accident_place VALUES ( 6,'�ӱ�',1);
		INSERT INTO health_accident_place VALUES ( 7,'�a�U��',1);
		INSERT INTO health_accident_place VALUES ( 8,'��|�]���ʤ���',1);
		INSERT INTO health_accident_place VALUES ( 9,'�Z��',1);
		INSERT INTO health_accident_place VALUES ( 10,'�ե~',1);
		INSERT INTO health_accident_place VALUES ( 999,'��L',1);";
		run_sql($creat_table_sql, $mysql_db);
	}

	$query="select * from health_accident_reason where 1=0";
	if (!$CONN->Execute($query)) {
		$creat_table_sql="CREATE TABLE health_accident_reason (
		id int(6) unsigned NOT NULL default '1',
		name varchar(100) NOT NULL default '',
		enable varchar(1) NOT NULL default '1',
		PRIMARY KEY (id)
		) ;
		INSERT INTO health_accident_reason VALUES ( 1,'�U�ҹC��',1);
		INSERT INTO health_accident_reason VALUES ( 2,'�W�U�ҳ~��',1);
		INSERT INTO health_accident_reason VALUES ( 3,'�ɺX',1);
		INSERT INTO health_accident_reason VALUES ( 4,'���}����',1);
		INSERT INTO health_accident_reason VALUES ( 5,'����',1);
		INSERT INTO health_accident_reason VALUES ( 6,'�W�U�ӱ�',1);
		INSERT INTO health_accident_reason VALUES ( 7,'�����',1);
		INSERT INTO health_accident_reason VALUES ( 8,'��|��',1);
		INSERT INTO health_accident_reason VALUES ( 999,'��L',1);";
		run_sql($creat_table_sql, $mysql_db);
	}

	$query="select * from health_accident_part where 1=0";
	if (!$CONN->Execute($query)) {
		$creat_table_sql="CREATE TABLE health_accident_part (
		id int(6) unsigned NOT NULL default '1',
		name varchar(100) NOT NULL default '',
		enable varchar(1) NOT NULL default '1',
		PRIMARY KEY (id)
		) ;
		INSERT INTO health_accident_part VALUES ( 1,'�Y',1);
		INSERT INTO health_accident_part VALUES ( 2,'�V',1);
		INSERT INTO health_accident_part VALUES ( 3,'��',1);
		INSERT INTO health_accident_part VALUES ( 4,'��',1);
		INSERT INTO health_accident_part VALUES ( 5,'��',1);
		INSERT INTO health_accident_part VALUES ( 6,'�I',1);
		INSERT INTO health_accident_part VALUES ( 7,'��',1);
		INSERT INTO health_accident_part VALUES ( 8,'�C��',1);
		INSERT INTO health_accident_part VALUES ( 9,'�f��',1);
		INSERT INTO health_accident_part VALUES ( 10,'�ջ��',1);
		INSERT INTO health_accident_part VALUES ( 11,'�W��',1);
		INSERT INTO health_accident_part VALUES ( 12,'�y',1);
		INSERT INTO health_accident_part VALUES ( 13,'�U��',1);
		INSERT INTO health_accident_part VALUES ( 14,'�v��',1);
		INSERT INTO health_accident_part VALUES ( 15,'�|����',1);";
		run_sql($creat_table_sql, $mysql_db);
	}
	$query="select * from health_accident_status where 1=0";
	if (!$CONN->Execute($query)) {
		$creat_table_sql="CREATE TABLE health_accident_status (
		id int(6) unsigned NOT NULL default'1',
		name varchar(100) NOT NULL default '',
		enable varchar(1) NOT NULL default '1',
		PRIMARY KEY (id)
		) ;
		INSERT INTO health_accident_status VALUES ( 1,'����',1);
		INSERT INTO health_accident_status VALUES ( 2,'���Ψ��',1);
		INSERT INTO health_accident_status VALUES ( 3,'������',1);
		INSERT INTO health_accident_status VALUES ( 4,'������',1);
		INSERT INTO health_accident_status VALUES ( 5,'���',1);
		INSERT INTO health_accident_status VALUES ( 6,'�`�S��',1);
		INSERT INTO health_accident_status VALUES ( 7,'�m�r��',1);
		INSERT INTO health_accident_status VALUES ( 8,'����',1);
		INSERT INTO health_accident_status VALUES ( 9,'�¶�',1);
		INSERT INTO health_accident_status VALUES ( 10,'�~���L',1);
		INSERT INTO health_accident_status VALUES ( 11,'�o�N',1);
		INSERT INTO health_accident_status VALUES ( 12,'�w�t',1);
		INSERT INTO health_accident_status VALUES ( 13,'���߹æR',1);
		INSERT INTO health_accident_status VALUES ( 14,'�Y�h',1);
		INSERT INTO health_accident_status VALUES ( 15,'���h',1);
		INSERT INTO health_accident_status VALUES ( 16,'�G�h',1);
		INSERT INTO health_accident_status VALUES ( 17,'���h',1);
		INSERT INTO health_accident_status VALUES ( 18,'���m',1);
		INSERT INTO health_accident_status VALUES ( 19,'�g�h',1);
		INSERT INTO health_accident_status VALUES ( 20,'���',1);
		INSERT INTO health_accident_status VALUES ( 21,'�y���',1);
		INSERT INTO health_accident_status VALUES ( 22,'�l�o',1);
		INSERT INTO health_accident_status VALUES ( 23,'���e',1);
		INSERT INTO health_accident_status VALUES ( 24,'�����L',1);";
		run_sql($creat_table_sql, $mysql_db);
	}

	$query="select * from health_accident_attend where 1=0";
	if (!$CONN->Execute($query)) {
		$creat_table_sql="CREATE TABLE health_accident_attend (
		id int(6) unsigned NOT NULL default'1',
		name varchar(100) NOT NULL default '',
		enable varchar(1) NOT NULL default '1',
		PRIMARY KEY (id)
		) ;
		INSERT INTO health_accident_attend VALUES ( 1,'�ˤf�B�z',1);
		INSERT INTO health_accident_attend VALUES ( 2,'�B��',1);
		INSERT INTO health_accident_attend VALUES ( 3,'����',1);
		INSERT INTO health_accident_attend VALUES ( 4,'���[��',1);
		INSERT INTO health_accident_attend VALUES ( 5,'�q���a��',1);
		INSERT INTO health_accident_attend VALUES ( 6,'�a���a�^',1);
		INSERT INTO health_accident_attend VALUES ( 7,'�դ�e��',1);
		INSERT INTO health_accident_attend VALUES ( 8,'�åͱШ|',1);
		INSERT INTO health_accident_attend VALUES ( 999,'��L�B�z',1);";
		run_sql($creat_table_sql, $mysql_db);
	}

	$creat_table_sql="CREATE TABLE if not exists health_accident_record (
	id int(10) unsigned NOT NULL auto_increment,
	year smallint(5) unsigned NOT NULL default '0',
	semester enum('0','1','2') NOT NULL default '0',
	student_sn int(10) unsigned NOT NULL default '0',
	sign_time datetime NOT NULL default '0000-00-00 00:00:00',
	obs_min int(6) unsigned NOT NULL default '0',
	temp decimal(3,1) NOT NULL default '0.0',
	place_id int(6) unsigned NOT NULL default '0',
	reason_id int(6) unsigned NOT NULL default '0',
	memo text NOT NULL default '',
	update_date timestamp,
	teacher_sn int(11) NOT NULL default '0',
	PRIMARY KEY (id)
	) ;";
	run_sql($creat_table_sql, $mysql_db);

	$creat_table_sql="CREATE TABLE if not exists health_accident_part_record (
	pid int(10) unsigned NOT NULL auto_increment,
	id int(10) unsigned NOT NULL default '0',
	part_id int(6) unsigned NOT NULL default '0',
	PRIMARY KEY (pid)
	) ;";
	run_sql($creat_table_sql, $mysql_db);

	$creat_table_sql="CREATE TABLE if not exists health_accident_status_record (
	sid int(10) unsigned NOT NULL auto_increment,
	id int(10) unsigned NOT NULL default '0',
	status_id int(6) unsigned NOT NULL default '0',
	PRIMARY KEY (sid)
	) ;";
	run_sql($creat_table_sql, $mysql_db);

	$creat_table_sql="CREATE TABLE if not exists health_accident_attend_record (
	aid int(10) unsigned NOT NULL auto_increment,
	id int(10) unsigned NOT NULL default '0',
	attend_id int(6) unsigned NOT NULL default '0',
	PRIMARY KEY (aid)
	) ;";
	run_sql($creat_table_sql, $mysql_db);

	$msg = "�ɫض˯f��ƪ� -- by brucelyc (2008-09-12)";
	$fd = fopen ($up_file_name, "w");
	fwrite($fd,$temp_query);
	fclose ($fd);
}

$up_file_name =$upgrade_str."2008-10-08.txt";
if (!is_file($up_file_name)){
	$creat_table_sql="CREATE TABLE if not exists health_checks_doctor (
		year smallint(5) unsigned NOT NULL default '0',
		semester enum('1','2') NOT NULL default '1',
		student_sn int(10) unsigned NOT NULL default '0',
		subject varchar(50) NOT NULL default'',
		hospital varchar(100) NOT NULL default'',
		doctor varchar(50) NOT NULL default'',
		update_date timestamp,
		teacher_sn int(11) NOT NULL default '0',
		PRIMARY KEY (year,semester,student_sn,subject)
		)";
	if ($CONN->Execute($creat_table_sql)) $ok=" ���\ ";
	else $ok="����";
	$temp_query = "�إ߰�����|��v�O���� $ok -- by brucelyc (2008-10-08)";
	$fd = fopen ($up_file_name, "w");
	fwrite($fd,$temp_query);
	fclose ($fd);
}

$up_file_name =$upgrade_str."2008-10-14.txt";
if (!is_file($up_file_name)){
	$query = "ALTER TABLE `health_checks_doctor` add cyear tinyint(4) not NULL default '0'";
	if ($CONN->Execute($query)) {
		$temp_query = "������|��v�O�����[�J�~�� -- by brucelyc (2008-10-14)\n$query";
		$fd = fopen ($up_file_name, "w");
		fwrite($fd,$temp_query);
		fclose ($fd);
	}
}

$up_file_name =$upgrade_str."2008-10-15.txt";
if (!is_file($up_file_name)){
	$query = "ALTER TABLE `health_checks_doctor` add measure_date date NOT NULL default '0000-00-00'";
	if ($CONN->Execute($query)) {
		$temp_query = "������|��v�O�����[�J�ˬd�ɶ� -- by brucelyc (2008-10-15)\n$query";
		$fd = fopen ($up_file_name, "w");
		fwrite($fd,$temp_query);
		fclose ($fd);
	}
}

$up_file_name =$upgrade_str."2008-10-30.txt";
if (!is_file($up_file_name)){
	$query = "ALTER TABLE `health_inject_record` add kid tinyint(4) unsigned NOT NULL default 0";
	if ($CONN->Execute($query)) {
		$temp_query = "��w���`�g�O�����[�Jkid -- by brucelyc (2008-10-30)\n$query";
		$CONN->Execute("ALTER TABLE `health_inject_record` drop primary key");
		$CONN->Execute("ALTER TABLE `health_inject_record` add primary key (student_sn,kid,id)");
		$fd = fopen ($up_file_name, "w");
		fwrite($fd,$temp_query);
		fclose ($fd);
	}
}

$up_file_name =$upgrade_str."2009-04-15.txt";
if (!is_file($up_file_name)){
	$creat_table_sql="CREATE TABLE if not exists health_manage_record (
		year smallint(5) unsigned NOT NULL default '0',
		semester enum('1','2') NOT NULL default '1',
		student_sn int(10) unsigned NOT NULL default '0',
		tbl varchar(50) NOT NULL default '',
		item varchar(20) NOT NULL default '',
		id int(10) unsigned NOT NULL default '0',
		memo text NOT NULL default '',
		update_date timestamp,
		teacher_sn int(11) NOT NULL default '0',
		PRIMARY KEY (year,semester,student_sn,tbl,item,id)
		)";
	if ($CONN->Execute($creat_table_sql)) $ok=" ���\ ";
	else $ok="����";
	$temp_query = "�إ߳B�m�O���� $ok -- by brucelyc (2009-04-15)";
	$fd = fopen ($up_file_name, "w");
	fwrite($fd,$temp_query);
	fclose ($fd);
}

$up_file_name =$upgrade_str."2009-04-16.txt";
if (!is_file($up_file_name)){
	$creat_table_sql="CREATE TABLE if not exists health_diag_record (
		year smallint(5) unsigned NOT NULL default '0',
		semester enum('1','2') NOT NULL default '1',
		student_sn int(10) unsigned NOT NULL default '0',
		tbl varchar(50) NOT NULL default '',
		item varchar(20) NOT NULL default '',
		id int(10) unsigned NOT NULL default '0',
		memo text NOT NULL default '',
		update_date timestamp,
		teacher_sn int(11) NOT NULL default '0',
		PRIMARY KEY (year,semester,student_sn,tbl,item,id)
		)";
	if ($CONN->Execute($creat_table_sql)) $ok=" ���\ ";
	else $ok="����";
	$temp_query = "�إ߶E�_�O���� $ok -- by brucelyc (2009-04-16)";
	$fd = fopen ($up_file_name, "w");
	fwrite($fd,$temp_query);
	fclose ($fd);
}

$up_file_name =$upgrade_str."yellow_card.txt";
if (!is_file($up_file_name)){
	$creat_table_sql="CREATE TABLE health_yellowcard (
		student_sn int(10) unsigned NOT NULL default '0',
		value tinyint(1) unsigned NOT NULL default '0',
		PRIMARY KEY (student_sn)
		)";
	$query="select * from health_yellowcard where 1=0";
	$res=$CONN->Execute($query);
	if ($res) $ok="��ƪ�w�s�b";
	elseif ($CONN->Execute($creat_table_sql)) $ok=" ���\ ";
	else $ok="����";
	$temp_query = "�إߧt�t���f����I�O���� -- $ok -- by brucelyc (2009-06-18)";
	$fd = fopen ($up_file_name, "w");
	fwrite($fd,$temp_query);
	fclose ($fd);
}

$up_file_name =$upgrade_str."2009-09-01.txt";
if (!is_file($up_file_name)){
	$creat_table_sql="CREATE TABLE if not exists health_disease_report (
		id int(10) unsigned NOT NULL auto_increment,
		student_sn int(10) unsigned NOT NULL default '0',
		dis_date date NOT NULL default '0000-00-00',
		dis_kind int(6) unsigned NOT NULL default '0',
		sym_str text NOT NULL default '',
		status varchar(2) NOT NULL default '',
		diag_date date NOT NULL default '0000-00-00',
		diag_hos varchar(50) NOT NULL default '',
		diag_name varchar(50) NOT NULL default '',
		chk_date date NOT NULL default '0000-00-00',
		chk_report varchar(50) NOT NULL default '',
		update_date timestamp,
		oth_chk text NOT NULL default '',
		oth_txt text NOT NULL default '',
		teacher_sn int(10) unsigned NOT NULL default '0',
		PRIMARY KEY (student_sn,dis_date),
		KEY `id` (`id`)
		)";
	if ($CONN->Execute($creat_table_sql)) $ok=" ���\ ";
	else $ok="����";
	$temp_query = "�إ߬y�P�q���� $ok -- by brucelyc (2009-09-01)";
	$fd = fopen ($up_file_name, "w");
	fwrite($fd,$temp_query);
	fclose ($fd);
}

$up_file_name =$upgrade_str."2009-09-02.txt";
if (!is_file($up_file_name)){
	$creat_table_sql="CREATE TABLE if not exists health_inflection_item (
		iid int(10) unsigned NOT NULL default '0',
		name varchar(50) NOT NULL default '',
		memo text NOT NULL default '',
		enable varchar(1) NOT NULL default '1',
		PRIMARY KEY (iid)
		)";
	if ($CONN->Execute($creat_table_sql)) $ok=" ���\ ";
	else $ok="����";
	$CONN->Execute("INSERT INTO health_inflection_item VALUES (1,'���y�P','��ʩI�l�D�P�V�B�㦳�U�C�g���G1.��M�o�f���o�N�]�շš�38�J�^�ΩI�l�D�P�V 2.�B���٦׻ĵh���Y�h�η��׹��·P',1)");
	$CONN->Execute("INSERT INTO health_inflection_item VALUES (2,'�⨬�f�f��&#30129;�l�ʫ|�l��','�⨬�f�f�G�f�B��x�B�}�x�Ων��\�B�v���X�{�p���w�ά��l�F�l�ʫ|�l���G�o�N�B�|���X�{�p���w�μ��',1)");
	$CONN->Execute("INSERT INTO health_inflection_item VALUES (3,'���m','�C�鸡�m�T���H�W�A�B�X�֤U�C����@���H�W�G1.�æR 2.�o�N 3.�H�G�G���Φ嵷 4.���m',1)");
	$CONN->Execute("INSERT INTO health_inflection_item VALUES (4,'�o�N','�o�N�]�շš�38�J�^�B�����e�z�e�f�ίg��',1)");
	$CONN->Execute("INSERT INTO health_inflection_item VALUES (5,'�����g','������h�B�`���B�ȥ��B���y�\�B�����F�������e�A����A���ɷ|�������U�X��F�������ͤj�q�H�ʤ��c���F���ɦիe�O�ڵ��~�j�B���h',1)");
	$CONN->Execute("INSERT INTO health_inflection_item VALUES (99,'��L','�e�C���إ~���S��ǬV�f',1)");
	$temp_query = "�إߺæ��ǬV�f���ت� $ok -- by brucelyc (2009-09-02)";
	$fd = fopen ($up_file_name, "w");
	fwrite($fd,$temp_query);
	fclose ($fd);
}

$up_file_name =$upgrade_str."2009-09-03.txt";
if (!is_file($up_file_name)){
	$creat_table_sql="CREATE TABLE if not exists health_inflection_record (
		id int(10) unsigned NOT NULL auto_increment,
		student_sn int(10) unsigned NOT NULL default '0',
		iid int(10) unsigned NOT NULL default '0',
		dis_date date NOT NULL default '0000-00-00',
		weekday int(4) unsigned NOT NULL default '0',
		status varchar(2) NOT NULL default '',
		rmemo text NOT NULL default '',
		update_date timestamp,
		teacher_sn int(10) unsigned NOT NULL default '0',
		PRIMARY KEY (student_sn,dis_date),
		KEY `id` (`id`)
		)";
	if ($CONN->Execute($creat_table_sql)) $ok=" ���\ ";
	else $ok="����";
	$temp_query = "�إߺæ��ǬV�f�O���� $ok -- by brucelyc (2009-09-03)";
	$fd = fopen ($up_file_name, "w");
	fwrite($fd,$temp_query);
	fclose ($fd);
}

$up_file_name =$upgrade_str."2009-09-07.txt";
if (!is_file($up_file_name)){
	$creat_table_sql="CREATE TABLE if not exists health_status_record (
		year smallint(5) unsigned NOT NULL default '0',
		semester enum('1','2') NOT NULL default '1',
		student_sn int(10) unsigned NOT NULL default '0',
		tbl varchar(50) NOT NULL default '',
		item varchar(20) NOT NULL default '',
		id int(10) unsigned NOT NULL default '0',
		memo text NOT NULL default '',
		update_date timestamp,
		teacher_sn int(11) NOT NULL default '0',
		PRIMARY KEY (year,semester,student_sn,tbl,item,id)
		)";
	if ($CONN->Execute($creat_table_sql)) $ok=" ���\ ";
	else $ok="����";
	$temp_query = "�إ߳��z�O���� $ok -- by brucelyc (2009-09-07)";
	$fd = fopen ($up_file_name, "w");
	fwrite($fd,$temp_query);
	fclose ($fd);
}

$up_file_name =$upgrade_str."2009-10-19.txt";
if (!is_file($up_file_name)){
	if ($CONN->Execute("INSERT INTO health_inject_item VALUES ( 8,'���k�̭]','',1,0,'','','','','',1,'');"))
		$ok=" ���\ ";
	else
		$ok="����";
	$temp_query = "�s�W���k�̭]���� $ok -- by brucelyc (2009-10-19)";
	$fd = fopen ($up_file_name, "w");
	fwrite($fd,$temp_query);
	fclose ($fd);
}

$up_file_name =$upgrade_str."2009-10-27.txt";
if (!is_file($up_file_name)){
	$creat_table_sql="CREATE TABLE health_sight_co (
		student_sn int(10) unsigned NOT NULL default '0',
		co varchar(1) NOT NULL default '',
		update_date timestamp,
		teacher_sn int(11) NOT NULL default '0',
		PRIMARY KEY (student_sn)
	) ;";
	if ($CONN->Execute($creat_table_sql)) $ok=" ���\ ";
	else $ok="����";
	$temp_query = "�إߦ⪼�O���� $ok -- by brucelyc (2009-10-27)";
	$fd = fopen ($up_file_name, "w");
	fwrite($fd,$temp_query);
	fclose ($fd);
}

$up_file_name =$upgrade_str."2010-03-23.txt";
if (!is_file($up_file_name)){
	$creat_table_sql="ALTER TABLE health_sight ADD hospital varchar(30)";
	if ($CONN->Execute($creat_table_sql)) $ok=" ���\ ";
	else $ok="����";
	$temp_query = "�[�J�N�E�����|�� $ok -- by hami (2010-03-23)";
	$fd = fopen ($up_file_name, "w");
	fwrite($fd,$temp_query);
	fclose ($fd);
}

$up_file_name =$upgrade_str."2010-04-6.txt";
if (!is_file($up_file_name)){
	$creat_table_sql="CREATE TABLE IF NOT EXISTS `health_inject_record` (
  `student_sn` int(10) unsigned NOT NULL DEFAULT '0',
  `id` int(6) unsigned NOT NULL DEFAULT '0',
  `times` int(4) unsigned NOT NULL DEFAULT '0',
  `date0` date NOT NULL DEFAULT '0000-00-00',
  `date1` date NOT NULL DEFAULT '0000-00-00',
  `date2` date NOT NULL DEFAULT '0000-00-00',
  `date3` date NOT NULL DEFAULT '0000-00-00',
  `date4` date NOT NULL DEFAULT '0000-00-00',
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `teacher_sn` int(11) NOT NULL DEFAULT '0',
  `kid` tinyint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`student_sn`,`kid`,`id`)
);";
	if ($CONN->Execute($creat_table_sql)) $ok=" ���\ ";
	else $ok="����";
	$temp_query = "�ɫإ� health_inject_record  $ok -- by hami (2010-03-23)";
	$fd = fopen ($up_file_name, "w");
	fwrite($fd,$temp_query);
	fclose ($fd);
}

$up_file_name =$upgrade_str."2010-10-22.txt";
if (!is_file($up_file_name)){
        $query="show columns from health_inject_item";
        $res=$CONN->Execute($query);
        $OK=0;
        while(!$res->EOF) {
                if ($res->fields['Field']=="code") $OK=1;
                $res->MoveNext();
        }
        if ($OK==0) {
		$query="ALTER TABLE `health_inject_item` add `code` varchar(10) not NULL default ''";
		$CONN->Execute($query);
	}
	$arr=array();
	$arr=array("1"=>"BCG","2"=>"HepB","3"=>"OPV","4"=>"DPT","5"=>"JE","6"=>"MV","7"=>"MMR"); //DPT: �ճ�ʤ�y�}�˭��V�X�̭], Td: �}�˭���q�ճ�V�X�̭]
	foreach($arr as $k=>$v) {
		$query="update health_inject_item set code='$v' where id='$k'";
		$CONN->Execute($query);
	}
	$temp_query = "�ɬ̭]�N�X -- by brucelyc (2010-10-22)";
	$fd = fopen ($up_file_name, "w");
	fwrite($fd,$temp_query);
	fclose ($fd);
}
