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
//�ק��ƪ�A�d��Ƥ��ɼW�[�O�������Ѯv�\��
$up_file_name =$upgrade_str."2013-03-08.txt";
if (!is_file($up_file_name)){
	$query = array();
	$query[0] = "ALTER TABLE `contest_record1` ADD `teacher_sn` int(10) NULL" ; //
	$temp_str = '';
	for($i=0;$i<count($query);$i++) {	
		if ($CONN->Execute($query[$i]))
			$temp_str .= "$query[$i]\n ��s���\ ! \n";
		else
			$temp_str .= "$query[$i]\n ��s���� ! \n";
	}
	$temp_query = "�d��Ƥ��ɼW�[�O�������Ѯv�\�� -- by smallduh (2013-03-08)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);
}

//�ק��ƪ�A�W�[�v�ɱK�X�]�p
$up_file_name =$upgrade_str."2013-03-04.txt";
if (!is_file($up_file_name)){
	$query = array();
	$query[0] = "ALTER TABLE `contest_setup` CHANGE `qtext` `qtext` text not NULL" ; //
	$temp_str = '';
	for($i=0;$i<count($query);$i++) {	
		if ($CONN->Execute($query[$i]))
			$temp_str .= "$query[$i]\n ��s���\ ! \n";
		else
			$temp_str .= "$query[$i]\n ��s���� ! \n";
	}
	$temp_query = "�ק��D�����榡����r text -- by smallduh (2013-03-04)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);
}

$up_file_name =$upgrade_str."2013-03-03.txt";
if (!is_file($up_file_name)){
	$query = array();
	$query[0] = "ALTER TABLE `contest_setup` ADD `delete_enable` tinyint(1) not NULL default '0'" ; //���\�R��
	$temp_str = '';
	for($i=0;$i<count($query);$i++) {	
		if ($CONN->Execute($query[$i]))
			$temp_str .= "$query[$i]\n ��s���\ ! \n";
		else
			$temp_str .= "$query[$i]\n ��s���� ! \n";
	}
	$temp_query = "�s�W���, �O�_���\�R��-- by smallduh (2013-03-03)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);
}

$up_file_name =$upgrade_str."2013-03-02.txt";
if (!is_file($up_file_name)){
	$query = array();
	$query[0] = "ALTER TABLE `contest_setup` ADD `password` varchar(4) NULL" ; //�v�ɱK�X�]�p
	$temp_str = '';
	for($i=0;$i<count($query);$i++) {	
		if ($CONN->Execute($query[$i]))
			$temp_str .= "$query[$i]\n ��s���\ ! \n";
		else
			$temp_str .= "$query[$i]\n ��s���� ! \n";
	}
	$temp_query = "�s�W���, �v�ɮɥi�]�p�K�X�~��i�J-- by smallduh (2013-03-02)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);
}


?>