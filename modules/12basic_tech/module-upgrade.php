<?php
// $Id:  $

if(!$CONN){
	echo "go away !!";
	exit;
}

// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");

$up_file_name =$upgrade_str."2014-04-01.txt";
if (!is_file($up_file_name)){
	$query ="ALTER TABLE `12basic_tech` ADD `signup_north` varchar( 3 ) NULL DEFAULT '000',ADD `signup_central` varchar( 3 ) NULL DEFAULT '000',ADD `signup_south` varchar( 3 ) NULL DEFAULT '000',ADD `signup_memo` TEXT NULL ;";
	if ($CONN->Execute($query))
		$str="���\\ ";
	else
		$str="����";
	$temp_query = "�W�[���W�Ǯյ��O���".$str." -- by infodaes (2014-04-01)\n$query";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

//�W�[�Ш|�|�ҭ���Ҹ��X
$up_file_name =$upgrade_str."2015-05-05.txt";
if (!is_file($up_file_name)){
	$query ="ALTER TABLE `12basic_tech` ADD `acad_exam_reg_num` varchar( 10 ) NULL DEFAULT '';";
	if ($CONN->Execute($query))
		$str="���\\ ";
	else
		$str="����";
	$temp_query = "�W�[�|�ҭ���Ҹ����".$str." -- by smallduh (2015-05-05)\n$query";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

?>
