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



$up_file_name = $upgrade_str . "2013-12-16.txt";
if (!is_file($up_file_name)) {
    //�W�[
    $query = "ALTER TABLE `jboard_kind` ADD board_is_sort tinyint NOT NULL";
    $CONN->Execute($query);
    $fp = fopen($up_file_name, "w");
    $temp_query = "�峹�����]�w�A�[�J�u�O�_���\�ۭq�Ƨǡv���	-- by smallduh (2013-12-16)";
    fwrite($fp, $temp_query);
    $query = "ALTER TABLE `jboard_kind` CHANGE `bk_order` `bk_order` INT(5) NOT NULL ";
    $CONN->Execute($query);
    $temp_query = "�ק� bk_order �����Ƨ����	-- by smallduh (2013-12-16)";
    fwrite($fp, $temp_query);    
    fclose($fp);
}


$up_file_name = $upgrade_str . "2013-12-17.txt";
if (!is_file($up_file_name)) {
	//�W�[
	$query = "ALTER TABLE `jboard_kind` ADD position tinyint(1) NOT NULL";
	$CONN->Execute($query);
	$fp = fopen($up_file_name, "w");
	$temp_query = "�����C��[�J�u�h�šv���	-- by smallduh (2013-12-17)";
	fwrite($fp, $temp_query);
	fclose($fp);
}

$up_file_name = $upgrade_str . "2014-04-16.txt";
if (!is_file($up_file_name)) {
	//�W�[
	$query = "ALTER TABLE `jboard_kind` ADD board_is_coop_edit tinyint(1) NOT NULL";
	$CONN->Execute($query);
	$fp = fopen($up_file_name, "w");
	$temp_query = "�W�[���ﶵ�u�O�_���\�@�s���v	-- by smallduh (2014-04-16)";
	fwrite($fp, $temp_query);
	fclose($fp);
}

//�ץ��o��̪��B�� 2014-04-22
$up_file_name = $upgrade_str . "2014-04-22.txt";
if (!is_file($up_file_name)) {
	//���X�Ҧ��峹
	$sql="select * from jboard_p";
	$res=$CONN->Execute($sql);
	while ($row=$res->fetchRow()) {
	  $teacher_sn=$row['teacher_sn'];
	  $b_id=$row['b_id'];
		//���o�o��H���B��
		$query = "select  a.post_office , b.title_name ,b.room_id,c.name from teacher_post a ,teacher_title b ,teacher_base c  where a.teacher_sn = c.teacher_sn and  a.teach_title_id =b.teach_title_id  and a.teacher_sn='$teacher_sn' ";
		$result = $CONN->Execute($query) or die ($query);
		$row_room = $result->fetchRow();
		$b_unit=$row_room['room_id'];		//�o��̩Ҧb�B��
		//update�g�J
	 	$sql_update = "update jboard_p set b_unit='$b_unit' where b_id='$b_id' ";
		$CONN->Execute($sql_update) or die ($sql_update);
	}
	
	$fp = fopen($up_file_name, "w");
	$temp_query = "�ץ��o��̪��B�Ǹ�� -- by smallduh (2014-04-22)";
	fwrite($fp, $temp_query);
	fclose($fp);
}

//�ץ�¾��, �H�N�X���N 2014-04-23
$up_file_name = $upgrade_str . "2014-04-23.txt";
if (!is_file($up_file_name)) {
	//���X�Ҧ��峹
	$sql="select * from jboard_p";
	$res=$CONN->Execute($sql);
	while ($row=$res->fetchRow()) {
	  $teacher_sn=$row['teacher_sn'];
	  $b_id=$row['b_id'];
	  $b_title=$row['b_title'];
		//���o��¾�٪�id
		$query = "select teach_title_id from teacher_title where title_name='".$b_title."'";
		$result = $CONN->Execute($query) or die ($query);
		if ($result->RecordCount()>0) {
			$row_title = $result->fetchRow();
			$b_title=$row_title['teach_title_id'];		//�o���¾��
	  } else {
	    $b_title="";
	  }
		//update�g�J
	 	$sql_update = "update jboard_p set b_title='$b_title' where b_id='$b_id' ";
		$CONN->Execute($sql_update) or die ($sql_update);
	}
	
	$fp = fopen($up_file_name, "w");
	$temp_query = "�N�o��̪�¾�٥H�N�X���N -- by smallduh (2014-04-23)";
	fwrite($fp, $temp_query);
	fclose($fp);
}


//�ק���ɦs��覡, ���s�J��Ʈw, �ӬO���X�H�ɮפ覡�B�z 2014-08-08
$up_file_name = $upgrade_str . "2014-08-08.txt";
if (!is_file($up_file_name)) {
	//���X�Ҧ��峹
	$path_str = "school/jboard/files/";
  set_upload_path($path_str);
  $download_file_path = $UPLOAD_PATH.$path_str;

	$sql="select * from jboard_files";
	$res=$CONN->Execute($sql);
	while ($row=$res->fetchRow()) {
   $filename=$row['new_filename'];
	 $fp = fopen($download_file_path.$filename, "w");
   //���e decode �^�� 
   $content=stripslashes(base64_decode($row['content']));
   fwrite($fp,$content);
   fclose($fp);
	}
	$sql="update jboard_files set content=''";
	$res=$CONN->Execute($sql);
	$fp = fopen($up_file_name, "w");
	$temp_query = "�N���ɧאּ�H�ɮפ覡�B�z -- by smallduh (2014-08-08)\n�ɮצs���m".$download_file_path;
	fwrite($fp, $temp_query);
	fclose($fp);
}

//�[�������ϦW�٤ΥN�X������
$up_file_name = $upgrade_str . "2014-10-13.txt";
if (!is_file($up_file_name)) {
	//$sql="ALTER TABLE `jboard_kind` CHANGE `bk_id` `bk_id` VARCHAR(36) NOT NULL DEFAULT '0'";
	$SQL[0]="ALTER TABLE `jboard_kind` CHANGE `bk_id` `bk_id` VARCHAR( 36 ) NOT NULL DEFAULT '0';";
	$SQL[1]="ALTER TABLE `jboard_kind` CHANGE `board_name` `board_name` VARCHAR( 72 ) NOT NULL DEFAULT '';";
  $SQL[2]="ALTER TABLE `jboard_p` CHANGE `bk_id` `bk_id` VARCHAR( 36 ) NOT NULL DEFAULT '0';";
  $SQL[3]="ALTER TABLE `jboard_check` CHANGE `pro_kind_id` `pro_kind_id` VARCHAR( 36 ) NOT NULL DEFAULT '0';";
  $temp_query="";
 
  foreach ($SQL as $sql) {
		$res=$CONN->Execute($sql) or die($sql);
		$temp_query=$temp_query.$sql."\n";
  }
	$fp = fopen($up_file_name, "w");
	$temp_query=$temp_query."�[�������ϥN�Xbk_id�ΦW��bk_name�������� -- by smallduh (2014-10-13)\n";
	fwrite($fp, $temp_query);
	fclose($fp);
}


//�W�[�����ϦP�B��ܳ]�w
$up_file_name = $upgrade_str . "2015-11-20.txt";
if (!is_file($up_file_name)) {
	$SQL[0]="ALTER TABLE `jboard_kind` add `synchronize` VARCHAR(36) NOT NULL DEFAULT '';";
	$SQL[1]="ALTER TABLE `jboard_kind` add `synchronize_days` int(2) NOT NULL DEFAULT '30';";

  $temp_query="";
 
  foreach ($SQL as $sql) {
		$res=$CONN->Execute($sql) or die($sql);
		$temp_query=$temp_query.$sql."\n";
  }
	$fp = fopen($up_file_name, "w");
	$temp_query=$temp_query."�W�[�����ϦP�B��ܩ�t�@�O�Ϫ��]�w -- by smallduh (2015-11-20)\n";
	fwrite($fp, $temp_query);
	fclose($fp);
}

//�W�[�m���]�w
$up_file_name = $upgrade_str . "2015-11-24.txt";
if (!is_file($up_file_name)) {
	$SQL[0]="ALTER TABLE `jboard_p` add `top_days` tinyint(2) NOT NULL DEFAULT '0';";
  $temp_query="";
  foreach ($SQL as $sql) {
		$res=$CONN->Execute($sql);
		$temp_query=$temp_query.$sql."\n";
  }
	$fp = fopen($up_file_name, "w");
	$temp_query=$temp_query."�W�[�峹�m���]�w -- by smallduh (2015-11-24)\n";
	fwrite($fp, $temp_query);
	fclose($fp);
}
