<?php
// $Id: module-upgrade.php 6065 2010-08-31 13:09:26Z infodaes $

if(!$CONN){
	echo "go away !!";
	exit;
}

// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");
$up_file_name =$upgrade_str."2007-03-18.txt";
if (!is_file($up_file_name)){
	$query ="ALTER TABLE `charge_item` ADD `cooperate` TINYINT(4)";
	if ($CONN->Execute($query))
		$str="���\\ ";
	else
		$str="����";
	$temp_query = "�� charge_item ��ƪ�ɤJ cooperate ���".$str." -- by brucelyc (2007-03-18)\n$query";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");
$up_file_name =$upgrade_str."2010-02-13.txt";
if (!is_file($up_file_name)){
	$query ="ALTER TABLE `charge_decrease` CHANGE `percent` `percent` FLOAT DEFAULT '0'";
	if ($CONN->Execute($query))
		$str="���\\ ";
	else
		$str="����";
	$temp_query = "����charge_decrease��K�O�����percvent���B�I��".$str." -- by infodaes(2010-02-13)\n$query";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}


// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");
$up_file_name =$upgrade_str."2010-08-27.txt";
if (!is_file($up_file_name)){
	$query ="ALTER TABLE `charge_detail` ADD `detail_type` TINYINT UNSIGNED DEFAULT '0' NOT NULL AFTER `item_id`;";
	if ($CONN->Execute($query)){
		$str="���\\ ";
		$CONN->Execute("UPDATE `charge_detail` SET `detail_type`='0' WHERE `detail_type`=NULL;");
		}
	else $str="����";
	$temp_query = "�W�[�ӥئ��k�b�����A�H�Q���ӻ�CSV�ץX".$str." -- by infodaes(2010-08-27)\n$query";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

?>
