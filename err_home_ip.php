<?php

// $Id: err_home_ip.php 5310 2009-01-10 07:57:56Z hami $

// ���o�]�w��
include "include/config.php";

sfs_check();

$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("module_name","ĵ�i�T��");
$smarty->display("err_home_ip.tpl");
?>
