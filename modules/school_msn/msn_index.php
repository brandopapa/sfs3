<?php
//$Id$
include_once "config.php";

//�{��
sfs_check();

//�q�X�����������Y
head("�ն�MSN");
//�D���]�w
//$school_menu_p=(empty($school_menu_p))?array():$school_menu_p;

//�D�n���e
 $smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE); //sfs���| 
 $smarty->assign("SFS_PATH_HTML",$SFS_PATH_HTML); //sfs HTML
 $smarty->assign("SFS_MENU",$MODULE_MENU); //����ܼ�

 $smarty->display('msn_index.tpl'); 


//�G������
foot();
?>
