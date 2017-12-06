<?php
//$Id: config.php 6911 2012-09-23 14:19:26Z hami $
include_once "../../include/config.php";
require_once "./module-cfg.php";
$path_str="/system";
set_upload_path($path_str);
$temp_path=$UPLOAD_PATH.$path_str;

?>
