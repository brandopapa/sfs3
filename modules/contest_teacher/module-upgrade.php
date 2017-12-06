<?php
//$Id: module-upgrade.php 6737 2012-04-06 12:25:56Z hami $

if(!$CONN){
        echo "go away !!";
        exit;
}
// reward_reason和reward_base 欄位屬性為text

$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");

//以上保留--------------------------------------------------------
//修改資料表，查資料比賽增加記錄評分老師功能
$up_file_name =$upgrade_str."2013-03-08.txt";
if (!is_file($up_file_name)){
	$query = array();
	$query[0] = "ALTER TABLE `contest_record1` ADD `teacher_sn` int(10) NULL" ; //
	$temp_str = '';
	for($i=0;$i<count($query);$i++) {	
		if ($CONN->Execute($query[$i]))
			$temp_str .= "$query[$i]\n 更新成功 ! \n";
		else
			$temp_str .= "$query[$i]\n 更新失敗 ! \n";
	}
	$temp_query = "查資料比賽增加記錄評分老師功能 -- by smallduh (2013-03-08)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);
}

//修改資料表，增加競賽密碼設計
$up_file_name =$upgrade_str."2013-03-04.txt";
if (!is_file($up_file_name)){
	$query = array();
	$query[0] = "ALTER TABLE `contest_setup` CHANGE `qtext` `qtext` text not NULL" ; //
	$temp_str = '';
	for($i=0;$i<count($query);$i++) {	
		if ($CONN->Execute($query[$i]))
			$temp_str .= "$query[$i]\n 更新成功 ! \n";
		else
			$temp_str .= "$query[$i]\n 更新失敗 ! \n";
	}
	$temp_query = "修改題目欄位格式為文字 text -- by smallduh (2013-03-04)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);
}

$up_file_name =$upgrade_str."2013-03-03.txt";
if (!is_file($up_file_name)){
	$query = array();
	$query[0] = "ALTER TABLE `contest_setup` ADD `delete_enable` tinyint(1) not NULL default '0'" ; //允許刪除
	$temp_str = '';
	for($i=0;$i<count($query);$i++) {	
		if ($CONN->Execute($query[$i]))
			$temp_str .= "$query[$i]\n 更新成功 ! \n";
		else
			$temp_str .= "$query[$i]\n 更新失敗 ! \n";
	}
	$temp_query = "新增欄位, 是否允許刪除-- by smallduh (2013-03-03)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);
}

$up_file_name =$upgrade_str."2013-03-02.txt";
if (!is_file($up_file_name)){
	$query = array();
	$query[0] = "ALTER TABLE `contest_setup` ADD `password` varchar(4) NULL" ; //競賽密碼設計
	$temp_str = '';
	for($i=0;$i<count($query);$i++) {	
		if ($CONN->Execute($query[$i]))
			$temp_str .= "$query[$i]\n 更新成功 ! \n";
		else
			$temp_str .= "$query[$i]\n 更新失敗 ! \n";
	}
	$temp_query = "新增欄位, 競賽時可設計密碼才能進入-- by smallduh (2013-03-02)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);
}


?>