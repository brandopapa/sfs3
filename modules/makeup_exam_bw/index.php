<?php
//$Id:$
include "config.php";

//�{��
sfs_check();

//�q�X�����������Y
$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("module_name","�Ҳջ���");
$smarty->assign("SFS_MENU",$school_menu_p);
$smarty->display("index.html");
?>