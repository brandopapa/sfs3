<?php
//$Id: config.php 5908 2010-03-16 23:47:21Z hami $
$dirPath = dirname(__FILE__);
require_once $dirPath."/module-cfg.php";

include_once  realpath("$dirPath/../../include/config.php");
include_once realpath("$dirPath/../../include/sfs_case_dataarray.php");
include_once realpath("$dirPath/../../include/sfs_case_PLlib.php");
include_once realpath("$dirPath/../../open_flash_chart/open_flash_chart_object.php");
require_once $dirPath."/my_fun.php";

require_once $dirPath."/module-upgrade.php";

require_once $dirPath."/class.health.php";

//�]�w�W�ǼȦs�ؿ�
$path_str = "temp/health/";
$temp_path = $UPLOAD_PATH.$path_str;

//�ƭȷ���
$minh=70; //�����C��
$maxh=226; //��������
$minw=10; //�魫�C��
$maxw=150; //�魫����

$Bid_arr=array("0"=>"�魫�L��", "1"=>"�魫�A��", "2"=>"�魫�L��", "3"=>"�魫�W��");
?>
