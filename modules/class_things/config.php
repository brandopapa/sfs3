<?php

// $Id: config.php 8087 2014-08-11 04:07:52Z infodaes $

include "../../include/config.php";
include "../../include/sfs_case_PLlib.php";
include "../../include/sfs_case_studclass.php";
include "../../include/sfs_case_calendar.php";
include "../../include/sfs_case_dataarray.php";
include "../../include/sfs_case_module.php";
include "../../include/sfs_oo_zip2.php";
//���o�Ҳճ]�w

$MSETUP = &get_module_setup('class_things') ;
$is_absent =$MSETUP['is_absent'] ;
$course_input =$MSETUP['course_input'];
$influenza =$MSETUP['influenza'];
$is_sms =$MSETUP['is_sms'];
$is_rewrad =$MSETUP['is_rewrad'];
$is_pwd =$MSETUP['is_pwd'];


//---------------------------------------------------
// �o�̽ФޤJ�z�ۤv���禡�w
//---------------------------------------------------
include "my_fun.php";
include "absent_function.php";
include "module-cfg.php";
?>
