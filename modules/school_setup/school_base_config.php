<?php
// $Id: school_base_config.php 5310 2009-01-10 07:57:56Z hami $

// ���J�]�w��
include_once "../../include/config.php" ;
// ���Ψ禡
include_once "../../include/sfs_case_PLlib.php";
include_once "../../include/sfs_case_dataarray.php";
include_once "../../include/sfs_oo_overlib.php";
//�ˬd��s���O
include_once "module-upgrade.php";

//�]�wñ���ɤW�Ǹ��|
$filePath = set_upload_path("school/title_img");
//�ؿ����{��
$school_menu_p = array("index.php"=>"�򥻸��","school_room.php"=>"�B�Ǹ��","school_title.php"=>"¾�ٸ��");
?>
