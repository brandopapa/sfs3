<?php
if(!$CONN){
        echo "go away !!";
        exit;
}

$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");

//�H�W�O�d--------------------------------------------------------

//�ק��ƪ�A�W�[�ӿ���
$up_file_name =$upgrade_str."2013-03-13.txt";

if (!is_file($up_file_name)){
	
	$query = "ALTER TABLE stud_service add sponsor varchar(64) " ; //�D����
	$temp_str = '';
		if ($CONN->Execute($query))
			$temp_str .= "$query\n ��s���\ ! \n";
		else
			$temp_str .= "$query\n ��s���� ! \n";
	

	$temp_query = "�ק��ƪ� stud_service (�O���D����)-- by smallduh (2013-03-13)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);
	
	//�N�즳��ƪ����D����Ҽg�ӿ���W��
	$sql="select sn,department from stud_service";
	$res=mysql_query($sql);
	while ($row=mysql_fetch_array($res,1)) {
	  $department=$row['department'];
	  $sql_select = "select room_name from school_room where room_id='$department'";
    $result=$CONN->Execute($sql_select);
    $room_name=$result->fields['room_name'];	
	  $sql_update="update stud_service set sponsor='$room_name' where sn='".$row['sn']."'";
	  mysql_query($sql_update);
	}	
	
}

//�ק��ƪ�A�W�[��g�ۧڬ٫�\��
$up_file_name =$upgrade_str."2012-11-30.txt";

if (!is_file($up_file_name)){
	$query = array();
	$query[0] = "ALTER TABLE `stud_service_detail` add `feedback` text " ; //�ۧڬ٫�
	$temp_str = '';
	for($i=0;$i<count($query);$i++) {	
		if ($CONN->Execute($query[$i]))
			$temp_str .= "$query[$i]\n ��s���\ ! \n";
		else
			$temp_str .= "$query[$i]\n ��s���� ! \n";
	}
	$temp_query = "�ק��ƪ� stud_service_detail (�ǥͶ�g�ۧڬ٫�\��)-- by smallduh (2012-11-30)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);
}


//�ק��ƪ�A�W�[�{�ҥ\��
$up_file_name =$upgrade_str."2012-11-14.txt";
if (!is_file($up_file_name)){
	$query = array();
	$query[0] = "ALTER TABLE `stud_service` add `confirm` tinyint(1) UNSIGNED NOT NULL default '0' " ; //�O�_�w�֥i
	$query[1] = "ALTER TABLE `stud_service` add `confirm_sn` int(10) NULL" ; //�O�֥֮i
	$query[2] = "ALTER TABLE `stud_service` add `input_sn` int(10) NOT NULL"; //�ӽФH�O��
	$query[3] = "ALTER TABLE `stud_service` add `input_time` datetime NOT NULL"; //�ӽеn������ɶ�
	$temp_str = '';
	for($i=0;$i<count($query);$i++) {	
		if ($CONN->Execute($query[$i]))
			$temp_str .= "$query[$i]\n ��s���\ ! \n";
		else
			$temp_str .= "$query[$i]\n ��s���� ! \n";
	}
	$temp_query = "�ק��ƪ� stud_service -- by smallduh (2012-11-14)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);
}

//�ק��ƪ�A�N minutes ���� tinyint �אּ int
$up_file_name =$upgrade_str."2012-09-27.txt";

if (!is_file($up_file_name)){
	$query = array();
	$query[0] = "ALTER TABLE `stud_service_detail` CHANGE `minutes` `minutes` INT(3) UNSIGNED NOT NULL " ;
	$temp_str = '';
	for($i=0;$i<count($query);$i++) {	
		if ($CONN->Execute($query[$i]))
			$temp_str .= "$query[$i]\n ��s���\ ! \n";
		else
			$temp_str .= "$query[$i]\n ��s���� ! \n";
	}
	$temp_query = "�ק��ƪ� stud_service -- by smallduh (2012-09-27)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);
}
?>