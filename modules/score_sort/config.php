<?php
// $Id: config.php 2015-10-17 22:11:15Z qfon $

/*�J�ǰȨt�γ]�w��*/
include "../../include/config.php";
include "../../include/sfs_case_PLlib.php";

//�ޤJ���
include "./my_fun.php";
//include "module-upgrade.php";


//���
$menu_p = array("score_sort.php"=>"�ɱϱоǦW��",
	);
//���o�Ҳճ]�w
$m_arr = get_sfs_module_set();
extract($m_arr, EXTR_OVERWRITE);
?>