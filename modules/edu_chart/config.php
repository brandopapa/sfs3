<?php
//$Id: config.php 5310 2009-01-10 07:57:56Z hami $
//�w�]���ޤJ�ɡA���i�����C
require_once "./module-cfg.php";
include_once "../../include/config.php";
include_once "../../include/sfs_case_PLlib.php";
require_once "./my_fun.php";

//�W���ɮ׼Ȧs�ؿ� 
$path_str = "temp/edu_chart/";
set_upload_path($path_str);
$temp_path = $UPLOAD_PATH.$path_str;
?>
