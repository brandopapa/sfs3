<?php

//$Id:  $

if(!$CONN){
	echo "go away !!";
	exit;
}

//�[�J highest ���

$upgrade_path = "upgrade/modules/stud_eduh/";
$upgrade_str = set_upload_path("$upgrade_path");

//�s�W highest ���H�����̰��������綵��
$up_file_name =$upgrade_str."2013-03-26.txt";
if (!is_file($up_file_name)){
	//SQL �y�k
	$query = "ALTER TABLE `career_test` ADD `highest` VARCHAR(100) NULL AFTER `content`;";
	if ($CONN->Execute($query)) 
		$temp_query = "�s�W highest ���H�����̰��������綵�� ���\�I -- by infodaes (2013-03-26)\n$query";
	else
		$temp_query = "�s�W highest ���H�����̰��������綵�� ���ѡI �Ф�ʧ�s�U�C�y�k\n $query";

        $fp = fopen ($up_file_name, "w");
        fwrite($fp,$temp_query);
        fclose ($fd);
}


?>
