<?php
// $Id: module-upgrade.php 7728 2013-10-28 09:02:05Z smallduh $

if(!$CONN){
        echo "go away !!";
        exit;
}

//
// �ˬd��s�_
// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");
$up_file_name =$upgrade_str."2004-02-26.txt";
//echo get_store_path();
if (!is_file($up_file_name)){
	$query =" ALTER TABLE `book` DROP PRIMARY KEY , ADD PRIMARY KEY ( `book_id` ,`bookch1_id`)";
        if ($CONN->Execute($query)) {
                $temp_query = "�ק� book �ߤ@��쬰book_id,bookch1_id -- by jrh (2004-02-26)\n$query";
                $fp = fopen ($up_file_name, "w");
                fwrite($fp,$temp_query);
                fclose ($fd);
        }
}

$up_file_name =$upgrade_str."2005-12-02.txt";
if (!is_file($up_file_name)){
	$qy[0] ="ALTER TABLE `book` CHANGE `book_name` `book_name` varchar(100) DEFAULT NULL;";
	$file_str[0] = "�ק� book_name �����׬�100�Ӧr��";
	$qy[1] ="ALTER TABLE `book` CHANGE `book_author` `book_author` varchar(50) DEFAULT NULL;";
	$file_str[1] = "�ק� book_author �����׬�50�Ӧr��";
	$qy[2] ="ALTER TABLE `book` CHANGE `book_maker` `book_maker` varchar(50) DEFAULT NULL;";
	$file_str[2] = "�ק� book_maker �����׬�50�Ӧr��";
	$qy[3] ="ALTER TABLE `book` CHANGE `book_myear` `book_myear` varchar(10) DEFAULT NULL;";
	$file_str[3] = "�ק� book_myear �����׬�10�Ӧr��";
	$qy[4] ="ALTER TABLE `book` CHANGE `book_isbn` `book_isbn` varchar(13) DEFAULT NULL;";
	$file_str[4] = "�ק� book_isbn �����׬�13�Ӧr��";
	reset($qy);
	while(list($k,$v)=each($qy)) {
		$temp_str.=$file_str[$k]." -- by brucelyc (2005-12-02)\n$v \n";
		if ($CONN->Execute($v))
			$temp_str.="��s���\ \n";
		else
			$temp_str.="��s���� \n";
	}
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

$up_file_name =$upgrade_str."2005-12-12.txt";
if (!is_file($up_file_name)){
	$qy[0] ="ALTER TABLE `book` CHANGE `bookch1_id` `bookch1_id` varchar(3) DEFAULT NULL;";
	$file_str[0] = "�ק� bookch1_id �����׬�3�Ӧr��";
	$qy[1] ="ALTER TABLE `book` ADD `ISBN` varchar(17) DEFAULT NULL;";
	$file_str[1] = "�W�[ ISBN ���׬�17�Ӧr��";
	$qy[2] ="ALTER TABLE `book` ADD `book_sprice` varchar(10) DEFAULT NULL;";
	$file_str[2] = "�W�[ book_sprice ���׬�10�Ӧr��";
	$qy[3] ="ALTER TABLE `book` DROP `book_no`;";
	$file_str[3] = "�R�� book_no ���";
	$qy[4] ="ALTER TABLE `book` CHANGE `book_dollar` `book_dollar` varchar(8) DEFAULT NULL;";
	$file_str[4] = "�ק� book_dollar �����׬�8�Ӧr��";
	$qy[5] ="ALTER TABLE `book` CHANGE `book_price` `book_price` int(11) DEFAULT NULL;";
	$file_str[5] = "�ק� book_price �����׬�11�Ӧ��";
	reset($qy);
	while(list($k,$v)=each($qy)) {
		$temp_str.=$file_str[$k]." -- by brucelyc (2005-12-12)\n$v \n";
		if ($CONN->Execute($v))
			$temp_str.="��s���\ \n";
		else
			$temp_str.="��s���� \n";
	}
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

$up_file_name =$upgrade_str."2005-12-15.txt";
if (!is_file($up_file_name)){
	$qy[0] ="ALTER TABLE `book` ADD `create_time` datetime not NULL DEFAULT '0000-00-00 00:00:00';";
	$file_str[0] = "�W�[ create_time ";
	$qy[1] ="ALTER TABLE `book` ADD `update_time` datetime not NULL DEFAULT '0000-00-00 00:00:00';";
	$file_str[1] = "�W�[ update_time ";
	reset($qy);
	while(list($k,$v)=each($qy)) {
		$temp_str.=$file_str[$k]." -- by brucelyc (2005-12-15)\n$v \n";
		if ($CONN->Execute($v))
			$temp_str.="��s���\ \n";
		else
			$temp_str.="��s���� \n";
	}
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}
?>