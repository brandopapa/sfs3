<?php
// $Id: config.php 6401 2011-03-30 05:50:15Z infodaes $

/*�J�ǰȨt�γ]�w��*/
include "../../include/config.php";
include "../../include/sfs_case_PLlib.php";

//�ޤJ���
include "./my_fun.php";
include "module-upgrade.php";

//���
$menu_p = array("score_query.php"=>"���Z�d��",
		"top.php"=>"���q���Z(�w��)�u���ƦW",
		"avg.php"=>"�w�����q�U�Z����",
		"manage.php"=>"���Zú�檬�p",
		"manage_ele.php"=>"���կZú�檬�p",
		"tol.php"=>"�����`��",
		"scope_tol.php"=>"����`��",
		"check.php"=>"�ťզ��Z�ˬd",
		"check100.php"=>"�ʤ����Z�ˬd",
		"check_score_under.php"=>"�S�w���Z�z��d��",
		"check_score_notify.php"=>"���Z�wĵ���R",
		"out.php"=>"�ư��W��");
//���o�Ҳճ]�w
$m_arr = get_sfs_module_set();
extract($m_arr, EXTR_OVERWRITE);
?>