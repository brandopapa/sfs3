<?php

// $Id: module-upgrade.php 7779 2013-11-20 16:09:00Z smallduh $
if (!$CONN) {
    echo "go away !!";
    exit;
}

// �ˬd��s�_
// ��s�O���ɸ��|
$upgrade_path = "upgrade/" . get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");

$up_file_name = $upgrade_str . "2013-11-20.txt";
//���ܤW���ɮװO���x�s�覡
if (!is_file($up_file_name)) {
$SQL="
create table board_files (
id int(5) not null auto_increment,
b_id int(5) not null,
org_filename text not null,
new_filename text not null,
primary key (id)
) ENGINE=MyISAM;";
    $rs = $CONN->Execute($SQL);
    if ($rs) {
        $temp_query = "���ܤW���ɮװO���x�s�覡�A�W�[ table: board_files  ���\-- by smallduh (2013-11-20)\n $SQL";
    } else {
        $temp_query = "���ܤW���ɮװO���x�s�覡�A�W�[ table: board_files ���� !!,�Ф�ʧ�s�U�C�y�k\n $SQL";
    }

    $fp = fopen($up_file_name, "w");
    fwrite($fp, $temp_query . $str);
    fclose($fp);
    unset($temp_query);
    unset($str);
}



$up_file_name = $upgrade_str . "2007-03-21.txt";
//���ܤW���ɮ׬�text���A�H�K�i�H�h�ɪ���
if (!is_file($up_file_name)) {
    $SQL = "ALTER TABLE `board_p` CHANGE `b_upload` `b_upload` TEXT NOT NULL ";
    $rs = $CONN->Execute($SQL);
    if ($rs) {
        $temp_query = "���ܤW���ɮ׬�text���A board_p ���\-- by infodaes (2007-03-21)\n $SQL";
    } else {
        $temp_query = "���ܤW���ɮ׬�text���A board_p ���� !!,�Ф�ʧ�s�U�C�y�k\n $SQL";
    }

    $fp = fopen($up_file_name, "w");
    fwrite($fp, $temp_query . $str);
    fclose($fp);
    unset($temp_query);
    unset($str);
}

$up_file_name = $upgrade_str . "2007-03-20.txt";

// �[�J ñ�����

if (!is_file($up_file_name)) {
    //�W�[ ñ�����
    $query = "ALTER TABLE `board_p` ADD `b_is_sign` CHAR( 1 ) NOT NULL DEFAULT '0'";
    $CONN->Execute($query);
    $query = "ALTER TABLE `board_p` ADD `b_signs` TEXT NOT NULL";
    $CONN->Execute($query);
    $query = "ALTER TABLE `board_p` CHANGE `b_title` `b_title` VARCHAR( 60 ) NOT NULL DEFAULT ''";
    $CONN->Execute($query);
    //�W�[�Ƨ����
    $query = "ALTER TABLE `board_kind` ADD bk_order tinyint NOT NULL";
    $CONN->Execute($query);
    $fp = fopen($up_file_name, "w");
    $temp_query = "�G�i��[�Jñ�����	-- by hami (2006-6-27)";
    fwrite($fp, $temp_query);
    fclose($fp);
}

//  ���  b_con �����
$up_file_name = $upgrade_str . "2007-03-23.txt";

if (!is_file($up_file_name)) {

    $query = "ALTER TABLE `board_p` CHANGE `b_con` `b_con` MEDIUMTEXT NOT NULL ";
    $CONN->Execute($query);
    $fp = fopen($up_file_name, "w");
    $temp_query = " ���  b_con �����	-- by hami (2007-3-23)";
    fwrite($fp, $temp_query);
    fclose($fp);
}


$up_file_name = $upgrade_str . "2007-10-15.txt";
//�վ� ���i���D
if (!is_file($up_file_name)) {
    //
    $query = "ALTER TABLE `board_p` CHANGE `b_sub`  `b_sub` CHAR( 100 ) NOT NULL DEFAULT ''";
    $CONN->Execute($query);
    $fp = fopen($up_file_name, "w");
    $temp_query = " ���  b_sub �����	-- by hami (2007-10-15)";
    fwrite($fp, $temp_query);
    fclose($fp);
}

//�[�J�O�_�m��]���O���
$up_file_name = $upgrade_str . "2013-04-03.txt";
if (!is_file($up_file_name)) {
    //�W�[ �]���O���
    $query = "ALTER TABLE `board_p` ADD `b_is_marquee` CHAR( 1 ) DEFAULT NULL";
    $CONN->Execute($query);
    $fp = fopen($up_file_name, "w");
    $temp_query = "�G�i��[�J�O�_��ܦb�]���O���	-- by shengche (2013-04-03)";
    fwrite($fp, $temp_query);
    fclose($fp);
}