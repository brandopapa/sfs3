<?php

// $Id: config.php 7971 2014-04-01 06:50:58Z smallduh $
include_once "../../include/config.php";
include_once "../../include/sfs_case_PLlib.php";
include_once "../../include/sfs_case_dataarray.php";
include_once "../../include/sfs_case_calendar.php";

require_once "./module-cfg.php";

//---------------------------------------------------
// �o�̽ФޤJ�z�ۤv���禡�w
//---------------------------------------------------
//���o�Ҳճ]�w
$m_arr = get_sfs_module_set("calendar");
extract($m_arr, EXTR_OVERWRITE);

?>