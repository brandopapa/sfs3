<?php
// $Id: config.php 5310 2009-01-10 07:57:56Z hami $

// �ޤJ SFS �]�w�ɡA���|���z���J SFS ���֤ߨ禡�w
include_once "../../include/config.php";
include_once "../../include/sfs_case_score.php";
//require_once "../../include/sfs_core_globals.php";
include_once "../../include/sfs_case_studclass.php";
include_once "../../include/sfs_case_subjectscore.php";
include_once "./module-cfg.php";
include_once "function.php";
//���o�Ҳճ]
$m_arr = &get_sfs_module_set('course_paper');
extract($m_arr, EXTR_OVERWRITE);
$m_arr = &get_sfs_module_set();
extract($m_arr, EXTR_OVERWRITE);
if ($midnoon=='') $midnoon=5;
?>
