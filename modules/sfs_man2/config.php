<?php
// $Id: config.php 6104 2010-09-08 03:44:46Z infodaes $

// �ޤJ SFS �]�w�ɡA���|���z���J SFS ���֤ߨ禡�w
include_once "../../include/config.php";

include_once "../../include/sfs_case_PLlib.php";
include_once "../../include/sfs_case_dataarray.php";
include_once "../../include/sfs_case_sql.php";
include_once "../../include/sfs_case_studclass.php";
include_once "./module-cfg.php";
include_once "./module-upgrade.php";
include_once "function.php";

$m_arr = &get_module_setup("sfs_man2");
extract($m_arr,EXTR_OVERWRITE);

?>
