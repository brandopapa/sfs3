<?php

// $Id: config.php 5310 2009-01-10 07:57:56Z hami $

//�t�γ]�w��
include_once "../../include/config.php";
//�禡�w
include_once "../../include/sfs_case_PLlib.php";
include_once "../../include/sfs_case_dataarray.php";
include_once "../../include/sfs_case_studclass.php";
require_once "./module-cfg.php";

$menu_p = array("stud_pass_list.php"=>"���վǥͱK�X�@��");

//�ثe�Ǧ~�Ǵ�
$this_seme_year_seme = sprintf("%03d%d",curr_year(),curr_seme());

?>
