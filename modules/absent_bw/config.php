<?php

// $Id: config.php 7726 2013-10-28 08:15:30Z smallduh $

include_once "../../include/config.php";
include_once "../../include/sfs_case_PLlib.php";
include_once "../../include/sfs_case_studclass.php";
include_once "../../include/sfs_case_calendar.php";
include_once "../../include/sfs_case_dataarray.php";
include "../../include/sfs_oo_zip2.php";
include_once "module-cfg.php";

//---------------------------------------------------
// �o�̽ФޤJ�z�ۤv���禡�w
//---------------------------------------------------
include_once "function.php";

$abskind=array("�ư�"=>"1","�f��"=>"2","�m��"=>"3","����"=>"5");

//���s�w�q�P��
//$weekN=array('�@','�G','�T','�|','��','��','��');

//���o�Ҳճ]�w
$m_arr = get_sfs_module_set();
extract($m_arr, EXTR_OVERWRITE);
$ranks=$ranks?$ranks:50;

?>
