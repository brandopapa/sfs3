<?php
// $Id: module-upgrade.php 5310 2009-01-10 07:57:56Z hami $
                                                                                                               
if(!$CONN){
        echo "go away !!";
        exit;
}

//
// �ˬd��s�_
// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");
$up_file_name =$upgrade_str."2003-09-08.txt";
//echo get_store_path();
if (!is_file($up_file_name)){
	$query =" ALTER TABLE `docup` ADD `url` VARCHAR( 80 ) NOT NULL";
        if ($CONN->Execute($query)) {
                $temp_query = "docup �[�J url ��� -- by hami (2003-06-08)\n$query";
                $fp = fopen ($up_file_name, "w");
                fwrite($fp,$temp_query);
                fclose ($fd);
        }
}
$up_file_name =$upgrade_str."2003-10-01.txt";

if (!is_file($up_file_name)){
	$query =" ALTER TABLE `docup_p` ADD `teacher_sn` smallint(5) unsigned NOT NULL";
	$CONN->Execute($query);
	$query =" ALTER TABLE `docup` ADD `teacher_sn` smallint(5) unsigned NOT NULL";
        if ($CONN->Execute($query)) {
                $temp_query = "docup docup_p �[�J teacher_sn ��� -- by hami (2003-10-1)\n$query";
                $fp = fopen ($up_file_name, "w");
                fwrite($fp,$temp_query);
                fclose ($fd);
        }
}

$up_file_name =$upgrade_str."2003-10-08.txt";

if (!is_file($up_file_name)){
	$query =" ALTER TABLE `docup` CHANGE `docup_owerid` `docup_owerid` VARCHAR( 20 ) NOT NULL";
        if ($CONN->Execute($query)) {
                $temp_query = "docup �� docup_owerid ���j�p����� 6 �קאּ 20 �A�H�ѨM session_log_id �W�L 6 �Ӧr���ɵL�k�U���ɮת����D-- by jrh (2003-10-08)\n$query";
                $fp = fopen ($up_file_name, "w");
                fwrite($fp,$temp_query);
                fclose ($fd);
        }
}


?>
