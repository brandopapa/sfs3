<?php
//$Id$
include_once "config.php";

//�{��
sfs_check();

//�q�X�����������Y
head("�ն�MSN");
//�D���]�w
//$school_menu_p=(empty($school_menu_p))?array():$school_menu_p;

//if ($SFS_IS_CENTER_VER) {
//	$MSN_WINDOW="modules/school_msn/main_index.php?sch_id=".substr($PREFIX_PATH,0,strlen($PREFIX_PATH)-1);
//} else {
  $MSN_WINDOW="modules/school_msn/main_index.php";
//}

//�D�n���e
 $smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE); //sfs���| 
 $smarty->assign("SFS_PATH_HTML",$SFS_PATH_HTML); //sfs HTML
 $smarty->assign("SFS_MENU",$MODULE_MENU); //����ܼ�
 $smarty->assign("MSN_WINDOW",$MSN_WINDOW); //�s����URL

 $smarty->display('msn_index.tpl'); 


//�G������
foot();
?>
