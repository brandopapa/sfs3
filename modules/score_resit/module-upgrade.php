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
/* �H�U���d��
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
*/

$up_file_name =$upgrade_str."2015-03-10.txt";
if (!is_file($up_file_name)){
	$query = array();
	//�b resit_paper_setup �̼W�[�@�ӥX�D�Ҧ���� 0��üƥX�D , 1��̤��ή����
	$query[0] = "ALTER TABLE `resit_paper_setup` ADD `item_mode` tinyint(1) not NULL" ; 
	//�b resit_exam_items �̼W�[�@�����O�����D�ݩ󨺤@�Ӥ��� 
	$query[1] = "ALTER TABLE `resit_exam_items` ADD `subject` varchar(30) not NULL" ; 
	//�b resit_exam_score �̼W�[�@�����O���ǥͤ��ή���� 
	$query[2] = "ALTER TABLE `resit_exam_score` ADD `subjects` varchar(50) not NULL" ; 

	//�s�W��ƪ� resit_scope_subject �C�Ǵ��Y�~�ŬY���]�t�������D��
	$query[3] = "
	CREATE TABLE IF NOT EXISTS `resit_scope_subject` (
   `sn` int(10) unsigned NOT NULL auto_increment,
   `seme_year_seme` varchar(4) NOT NULL,
   `cyear` tinyint(1) not null,
   `scope` varchar(30) not null,
   `subject_id` int(3) not null,
	 `subject` varchar(50) not null,
	 `items` int(3) not null,
   PRIMARY KEY  (`sn`)
	) ENGINE=MyISAM;	 
	";
	
	$temp_str = '';
	for($i=0;$i<count($query);$i++) {	
		if ($CONN->Execute($query[$i]))
			$temp_str .= "$query[$i]\n ��s���\ ! \n";
		else
			$temp_str .= "$query[$i]\n ��s���� ! \n";
	}
	$temp_query = "�W�[�U���̤���R�D�����\�� -- by smallduh (2015-03-10)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);
}


?>