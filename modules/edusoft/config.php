<?php

// $Id: config.php 5310 2009-01-10 07:57:56Z hami $

require_once "./module-cfg.php";

include_once "../../include/config.php";

include_once ("../../include/sfs_case_PLlib.php");

//���o�Ҳճ]�w
$m_arr = get_sfs_module_set();
extract($m_arr, EXTR_OVERWRITE);

// ���O��Ʈw�W��
$mastertable = "softm" ;

// �n���Ʈw�W��
$subtable = "soft";

//�ؿ����{��
$menu_p = array("index.php"=>$ap_name."��C", "tapem_list.php"=>"*���O�޲z","tape_list.php"=>"*".$ap_name."�޲z",sfs_check_stu()=>"*".$ap_name."���v�޲z","tapem_showall.php"=>"*�C�X����".$ap_name);
?>
