<?php
if(!$CONN){
        echo "go away !!";
        exit;
}

$upgrade_path = "upgrade/".get_store_path();
$upgrade_str = set_upload_path("$upgrade_path");

//�H�W�O�d--------------------------------------------------------

//�ק��ƪ�A�W�[�ӿ���
$up_file_name =$upgrade_str."2014-09-01.txt";

if (!is_file($up_file_name)){
	
	$query = "ALTER TABLE teacher_absent add note_file varchar(100) " ; //�W�Ǥ���ɦW
	$temp_str = '';
		if ($CONN->Execute($query))
			$temp_str .= "$query\n ��s���\ ! \n";
		else
			$temp_str .= "$query\n ��s���� ! \n";
	

	$temp_query = "�ק��ƪ� teacher_absent (�Юv�а��O��)-- by hami (2014-09-01)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);

}

?>