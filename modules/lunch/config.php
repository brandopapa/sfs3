<?php
require_once "./module-cfg.php";

// 引入 SFS 設定檔，它會幫您載入 SFS 的核心函式庫
include_once "../../include/config.php";
include_once "./module-upgrade.php";

// 引入林朝敏師的函式庫 (這支午餐食譜需要用到)
include_once "../../include/sfs_case_PLlib.php" ;

//取得模組參數設定
$m_arr = &get_sfs_module_set("lunch");
extract($m_arr, EXTR_OVERWRITE);

$DESIGN = explode(",",$DESIGN_NAME);
$font_size=$font_size?$font_size:'9pt';
$column_bgcolor_w='#FFDDDD';
$column_bgcolor_m='#DDDDFF';

?>