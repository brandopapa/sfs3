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
//�ק��ƪ�A�O�_�@�ӾǥͦP�ɥi�ѥ[�h�Ӫ���
$up_file_name =$upgrade_str."2013-09-10.txt";
if (!is_file($up_file_name)){
	$query = array();
	$query[0] = "ALTER TABLE `stud_club_setup` ADD `multi_join` tinyint(1) not NULL default '0'" ; //�O�_�@�ӾǥͦP�ɥi�ѥ[�h�Ӫ���
	$temp_str = '';
	for($i=0;$i<count($query);$i++) {	
		if ($CONN->Execute($query[$i]))
			$temp_str .= "$query[$i]\n ��s���\ ! \n";
		else
			$temp_str .= "$query[$i]\n ��s���� ! \n";
	}
	$temp_query = "�s�W���, �O�_���\�@�ӾǥͦP�ɿ�צh�Ӫ���-- by smallduh (2013-09-10)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);
}

//�ק��ƪ�A�W�[�����ʧO�s�Z�ﶵ
$up_file_name =$upgrade_str."2013-02-08.txt";
if (!is_file($up_file_name)){
	$query = array();
	$query[0] = "ALTER TABLE `stud_club_base` ADD `ignore_sex` tinyint(1) not NULL default '0'" ; //���ɮv�ݨ�ǥͤ���
	$temp_str = '';
	for($i=0;$i<count($query);$i++) {	
		if ($CONN->Execute($query[$i]))
			$temp_str .= "$query[$i]\n ��s���\ ! \n";
		else
			$temp_str .= "$query[$i]\n ��s���� ! \n";
	}
	$temp_query = "�s�W���, �s�Z�ɥi�����ʧO�s�Z-- by smallduh (2013-02-08)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);
}



//�ק��ƪ�A�N�w�p�}�Z�H��, ���אּ�i��W�]�w�k�ͤk�ͤH��, �üW�[�q�L�зǤ��ƻP�s�Z�O��
$up_file_name =$upgrade_str."2013-01-04.txt";

if (!is_file($up_file_name)){
	$query = array();
	$query[0] = "ALTER TABLE `stud_club_base` ADD `stud_boy_num` int(3) not NULL" ; //�}�Z�k�ͼ�
	$query[1] = "ALTER TABLE `stud_club_base` ADD `stud_girl_num` int(3) not NULL" ; //�}�Z�k�ͼ�
	$query[2] = "ALTER TABLE `stud_club_base` ADD `pass_score` int(3) not NULL default '60'" ; //�q�L����
  $query[3] = "ALTER TABLE `stud_club_setup` ADD `arrange_record` text NULL" ; //�s�Z�O��
  $query[4] = "ALTER TABLE `stud_club_setup` ADD `teacher_double` tinyint(1) not NULL default '0'" ; //�O�_���\�@�ӦѮv���ɦh�Ӫ���

	$temp_str = '';
	for($i=0;$i<count($query);$i++) {	
		if ($CONN->Execute($query[$i]))
			$temp_str .= "$query[$i]\n ��s���\ ! \n";
		else
			$temp_str .= "$query[$i]\n ��s���� ! \n";
	}
	
	$query="select club_sn,club_student_num from stud_club_base";
	$res=mysql_query($query);
	if (mysql_num_rows($res)) {
	  while ($row=mysql_fetch_array($res)) {
	    
	    $stud_boy_num=round($row['club_student_num']/2);
	    $stud_girl_num=$row['club_student_num']-$stud_boy_num;
	    
	    $query="update stud_club_base set stud_boy_num='$stud_boy_num',stud_girl_num='$stud_girl_num' where club_sn='".$row['club_sn']."'";
	    mysql_query($query);
	    
	  } // end while
	 
	} // end if
	
	$temp_query = "�վ����, �}�Z�H�ƪ��]�w�אּ���O�]�w�k�ͩM�k�ͤH�� \n�s�W���, �]�w�ǥͤ��ƥ����F���зǤ~����o���λ{��\n�s�W�O���,�i�O���s�Z�O��\n-- by smallduh (2013-01-04)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);
}


//�ק��ƪ�
$up_file_name =$upgrade_str."2012-11-28.txt";

if (!is_file($up_file_name)){
	$query = array();
	$query[0] = "ALTER TABLE `stud_club_setup` ADD `show_score` tinyint(1) not NULL" ; //���ɮv�ݨ�ǥͤ���
	$query[1] = "ALTER TABLE `stud_club_setup` ADD `show_feedback` tinyint(1) not NULL" ; //���ɮv�ݨ�ǥͦۧڬ٫�
	$query[2] = "ALTER TABLE `stud_club_setup` ADD `show_teacher_feedback` tinyint(1) not NULL" ; //�����ΦѮv�ݨ�ǥͦۧڬ٫�
	$temp_str = '';
	for($i=0;$i<count($query);$i++) {	
		if ($CONN->Execute($query[$i]))
			$temp_str .= "$query[$i]\n ��s���\ ! \n";
		else
			$temp_str .= "$query[$i]\n ��s���� ! \n";
	}
	$temp_query = "�s�W���, �i�վ�ɮv�Ϊ��Ϋ��ɦѮv��_�ݨ�ǥͦ��Z�Φۧڬ٫�-- by smallduh (2012-11-28)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);
}

 
//�ק��ƪ�
$up_file_name =$upgrade_str."2012-11-23.txt";

if (!is_file($up_file_name)){
	$query = array();
	$query[0] = "ALTER TABLE `association` ADD `stud_post` varchar(20) NULL" ; //�ǥ;��¾��
	$query[1] = "ALTER TABLE `association` ADD `stud_feedback` text NULL" ; //�ǥͦۧڬ٫�
	$temp_str = '';
	for($i=0;$i<count($query);$i++) {	
		if ($CONN->Execute($query[$i]))
			$temp_str .= "$query[$i]\n ��s���\ ! \n";
		else
			$temp_str .= "$query[$i]\n ��s���� ! \n";
	}
	$temp_query = "�s�W���, �]���ǥͦۧڬ٫�P���¾��-- by smallduh (2012-11-23)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);
}


//�ק��ƪ� , �W�Ҧa�I�]�w
$up_file_name =$upgrade_str."2012-10-12.txt";

if (!is_file($up_file_name)){
	$query = array();
	$query[0] = "ALTER TABLE `stud_club_base` ADD `club_location` VARCHAR( 20 ) NOT NULL AFTER `club_memo`" ;
	$temp_str = '';
	for($i=0;$i<count($query);$i++) {	
		if ($CONN->Execute($query[$i]))
			$temp_str .= "$query[$i]\n ��s���\ ! \n";
		else
			$temp_str .= "$query[$i]\n ��s���� ! \n";
	}
	$temp_query = "�s�W��� club_location  -- by smallduh (2012-10-12)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);
}

?>