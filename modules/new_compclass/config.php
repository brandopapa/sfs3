<?php
// $Id: config.php 8581 2015-11-02 15:06:52Z chiming $

/* 取得學務系統設定檔 */
require_once "./module-cfg.php";
include_once "../../include/config.php";
require_once "./module-upgrade.php";
include_once "../../include/sfs_case_studclass.php";
include_once "../../include/sfs_case_subjectscore.php";
include_once "../../include/sfs_case_PLlib.php";

//取得模組參數設定
$m_arr = &get_sfs_module_set("");
extract($m_arr, EXTR_OVERWRITE);

$PHP_SELF = basename($_SERVER["PHP_SELF"]) ;

//sfs_check();

$teacher_sn=$_SESSION['session_tea_sn'];

$weekN7=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");

$today=date("Y-m-d");
//目錄內程式
$school_menu_p = array(
"index.php"=>"空堂預約",
"query.php"=>"查詢舊記錄",
"query_today.php"=>"今日各節次所有專科教室使用列表"
);
?>
