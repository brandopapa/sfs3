<?php
// $Id: config.php 5310 2009-01-10 07:57:56Z hami $
require_once "./module-cfg.php";
require "../../include/config.php";
require "../../include/sfs_case_PLlib.php";
require "../../include/sfs_oo_zip2.php";
require_once "./module-upgrade.php";
//���o�Ҳճ]�w
$m_arr = get_sfs_module_set();
extract($m_arr, EXTR_OVERWRITE);		
	
$menu_p = array(
"newstud_input.php"=>"�פJ�s��", 
"newstud_manage.php"=>"�޲z�s��",
"newstud_compile.php"=>"�{�ɽs�Z",
"newstud_notification.php"=>"�J�ǳq����",
"auto_compile.php"=>"�����s�Z",
"set_id.php"=>"�]�w�Ǹ�",
"real_input.php"=>"�g�J���y��", 
"print_paper.php"=>"����C�L",
"chc_940601.php"=>"��ƶץX�J<br>(������)",
"tcc.php"=>"��ƶץX�J<br>(������)",
"readme.php"=>"�ϥλ���");
?>
