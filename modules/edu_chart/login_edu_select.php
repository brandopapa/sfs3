<?php
//$Id: login_edu_select.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";

//�{��
sfs_check();

//���X�ǮեN�X
$smarty->assign("sch_id",$SCHOOL_BASE[sch_id]);

$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("SFS_PATH_HTML",$SFS_PATH_HTML);
$smarty->assign("module_name","�y�w�����ȳ���z��������@�~�n�J");
$smarty->assign("SFS_MENU",$school_menu_p);
$smarty->display("edu_chart_login_edu_select.tpl");
?>
