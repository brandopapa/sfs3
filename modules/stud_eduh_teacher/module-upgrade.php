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

//�s�W��ƪ�A

$up_file_name =$upgrade_str."2012-10-30.txt";

if (!is_file($up_file_name)){
	$query = array();
	$query[0] = "CREATE TABLE IF NOT EXISTS `score_eduh_teacher2` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `year_seme` varchar(4) NOT NULL,
  `teacher_sn` int(10) unsigned NOT NULL,
  `class_id` varchar(11) NOT NULL,
  `update_sn` int(10) unsigned NOT NULL,
  `update_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;
	";
	$temp_str = '';
	for($i=0;$i<count($query);$i++) {	
		if ($CONN->Execute($query[$i]))
			$temp_str .= "$query[$i]\n ��s���\ ! \n";
		else
			$temp_str .= "$query[$i]\n ��s���� ! \n";
	}
	$temp_query = "�s�W��ƪ� score_eduh_teacher2  -- by smallduh (2012-10-30)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);
}



$up_file_name =$upgrade_str."2014-08-25.txt";
if (!is_file($up_file_name)){
	$query ="ALTER TABLE `stud_seme_talk` ADD `interview_method` varchar(10) AFTER `interview`;";
	if ($CONN->Execute($query))
		$str="�s�W�X�ͤ覡��즨�\\";
	else
		$str="�s�W�X�ͤ覡��쥢��( ���i��w�g�ۯŰȺ޲z���ɯŧ����F! )";
	$temp_query = "�� stud_seme_talk ��ƪ�s�W�X�ͤ覡 -- by infodaes 2014-08-25 \n$query";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

?>