<?php
//$Id: module-upgrade.php 6737 2012-04-06 12:25:56Z hami $

if(!$CONN){
        echo "go away !!";
        exit;
}
// reward_reason�Mreward_base ����ݩʬ�text

$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");

//�H�W�O�d--------------------------------------------------------
//��s�O���|�}�Ҥ@�Ӥ�r��, �ХH����@���ɦW, �H�Q��O, �p: 2013-06-24.txt
$up_file_name =$upgrade_str."2013-12-24.txt";
if (!is_file($up_file_name)){
	$query = array();
	$query[0] = "ALTER TABLE `ldap` ADD `enable1` tinyint(1) not NULL default '0'" ; //�ǥ͵n�J�O�_�ҥ�
	$temp_str = '';
	for($i=0;$i<count($query);$i++) {	
		if ($CONN->Execute($query[$i]))
			$temp_str .= "$query[$i]\n ��s���\ ! \n";
		else
			$temp_str .= "$query[$i]\n ��s���� ! \n";
	}
	$temp_query = "�s�W��� enable1 , �ǥ͵n�J�O�_�ҥ� ldap -- by smallduh (2013-12-24)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);
}

$up_file_name =$upgrade_str."2013-10-09.txt";
if (!is_file($up_file_name)){
	$query = array();
	$query[0] = "ALTER TABLE `ldap` ADD `teacher_ou` varchar(20) not NULL" ; //�Юv�� ou
	$query[1] = "ALTER TABLE `ldap` ADD `stud_ou` varchar(20) not NULL" ; //�ǥͪ� ou
	$temp_str = '';
	for($i=0;$i<count($query);$i++) {	
		if ($CONN->Execute($query[$i]))
			$temp_str .= "$query[$i]\n ��s���\ ! \n";
		else
			$temp_str .= "$query[$i]\n ��s���� ! \n";
	}
	$temp_query = "�s�W���, �Юv�� ou �ξǥͪ� ou -- by smallduh (2013-10-09)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);
}

//�W�[ base uid �]�w
$up_file_name =$upgrade_str."2013-09-30.txt";
if (!is_file($up_file_name)){
	$query ="ALTER TABLE `ldap` ADD `base_uid` VARCHAR( 10 ) NOT NULL AFTER `base_dn` ;";
	if ($CONN->Execute($query)) {
		$str="���\\ ";
		$CONN->Execute("UPDATE `ldap` SET `base_uid`='uid'");
	}
	else
		$str="����";
	$temp_query = "ldap ���[�J base_uid ��� ".$str." -- by hami (2013-09-30)\n$query";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

