<?php
//$Id: mig_config.php 5310 2009-01-10 07:57:56Z hami $

//���J sfs �]�w��	
include_once "../../include/config.php";

include_once "../../include/sfs_core_globals.php";
include_once "../../include/sfs_case_PLlib.php";

//���o�Ҳճ]
$m_arr = get_sfs_module_set("mig");
extract($m_arr, EXTR_OVERWRITE);

$homeLink = "http://$SCHOOL_BASE[sch_url]/";

$homeLabel = $SCHOOL_BASE[sch_cname_ss]."���y��T��";

// �[�W addslashes�A�H�K�X�{ �\�\�\ �����D
$pageTitle = addslashes($SCHOOL_BASE[sch_cname_ss].$P_TITLE);

$markerType = "suffix";

$markerLabel = "th";

$jumpMap["example"] = "currDir=./Example_Gallery";

$version = "0.98";
$baseURL = $PHP_SELF;		/* self-referential URL */
$baseadminURL = "admin.php" ;	/*�޲z�{��*/
$baseDir = updir($_SERVER[SCRIPT_FILENAME]);	/* base directory of installation */

/* �W���ɮץت��ؿ� */
$path_str = "school/school_albums";
set_upload_path($path_str);
$albumDir = $UPLOAD_PATH.$path_str;  /*  ���ɩ�m�ؿ� Where albums live */

$configFile  = $baseDir . "/mig_config.php";	/* �]�w�� Configuration file */
$defaultConfigFile = $configFile . ".default";	/* Default config file */
/* (used if $configFile does not exist) */

//$albumDir    = $alumb . "/albums";	/*  ���ɩ�m�ؿ� Where albums live */
/* If you change the directory here also make sure to change $albumURLroot */

$templateDir = $baseDir . "/templates";	/* HTML �]�w�ɥؿ� Where templates live */

/* Location of image library (for instance, where icons are kept) */
$imageDir    = ereg_replace("/[^/]+$", "", $baseURL) . "/images";

/* Root where album images are living */
//$albumURLroot = ereg_replace("/[^/]+$", "", $baseURL) . "/albums";
$albumURLroot = $UPLOAD_URL.$path_str;

$distURL = "http://tangledhelix.com/software/mig/";
$maintAddr = "rray@mail.wpes.tcc.edu.tw";

?>
