<?php


//---------------------------------------------------
// �o�̽Щ�W�{�����ѧO Id�A�g�k�G $ + Id + $
// SFS �}�o�p�����z��J SFS �� CVS Server ��
// �|�۰ʺ��@���@�ܼơA�`�N! �Щ�b���ѽd�򤤡A�p�U�ҥܡG
//
//---------------------------------------------------

// $Id: config.php 6561 2011-09-27 03:59:20Z infodaes $

//---------------------------------------------------
//
// �Ҳըt�ά������]�w�ɡA�@�w�n�ޤJ�A�ҥH�ϥ� require !!!
//
//---------------------------------------------------
// �ޤJ SFS �]�w�ɡA���|���z���J SFS ���֤ߨ禡�w
include_once "../../include/config.php";
include_once "../../include/sfs_case_studclass.php";
require_once "./module-cfg.php";
require_once "./module-upgrade.php";


 //���o�ҲհѼƳ]�w
$m_arr =& get_module_setup("cita");
extract($m_arr, EXTR_OVERWRITE);

$bonus_max=$bonus_max?$bonus_max:12;
$MAX_ITEM=$MAX_ITEM?$MAX_ITEM:12;

if($my_grada) $grada=explode(',',$my_grada);

$PHP_SELF = $_SERVER["PHP_SELF"] ;


//---------------------------------------------------
// �o�̽ФޤJ SFS �ǰȨt�Ϊ������禡�w�C
//
// �ܩ�n�ޤJ���ǩO�H
//
// 1. sfs3/include/config.php �g�`�O�ݭn���C
//
// 2. �䥦�A�N���z���{���ت��өw�C
// �Ъ`�N!!!!! �o�̥u��ϥ� include_once �� include
//---------------------------------------------------



//---------------------------------------------------
// �o�̽ФޤJ�z�ۤv���禡�w
//
// �S�����ܡA�i�H���L�C
// �Ъ`�N!!!!! �o�̥u��ϥ� include_once �� include
//---------------------------------------------------

// �ݱz��J





//---------------------------------------------------
// 
// �ܼƩw�q�A�ЦܡGmodule-cfg.php
// 
//
//---------------------------------------------------


?>
