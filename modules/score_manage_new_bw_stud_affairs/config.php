<?php
// $Id: config.php 6401 2011-03-30 05:50:15Z infodaes $

/*�J�ǰȨt�γ]�w��*/
include "../../include/config.php";
include "../../include/sfs_case_PLlib.php";

//�ޤJ���
include "./my_fun.php";
include "module-upgrade.php";

//���
$menu_p = array("score_query.php"=>"���Z�d��");
//���o�Ҳճ]�w
$m_arr = get_sfs_module_set();
extract($m_arr, EXTR_OVERWRITE);
?>