<?php

// $Id: general.php 5310 2009-01-10 07:57:56Z hami $

// ���o�]�w��
include "config.php";

sfs_check();

if ($_POST['df_item']=="") $_POST['df_item']="default_jh";
if ($_POST['year_seme']=="") $_POST['year_seme']=sprintf("%03d",curr_year()).curr_seme();
$sel_year=intval(substr($_POST['year_seme'],0,-1));
$sel_seme=intval(substr($_POST['year_seme'],-1,1));

switch ($_POST[sub_menu_id]) {
	case "1":
		if ($_POST[class_name]) {
			
		}
		break;
}

$sub_menu_arr=array("�п�ܧ@�~����","�Y��","�H����","���G");
$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("module_name","�ǥͤ@��`�W���d�ˬd�@�~");
$smarty->assign("SFS_MENU",$school_menu_p);
$smarty->assign("sub_menu",sub_menu($sub_menu_arr,$_POST[sub_menu_id]));
$smarty->assign("year_seme_menu",year_seme_menu($sel_year,$sel_seme));
$smarty->assign("class_menu",class_menu($sel_year,$sel_seme,$_POST[class_name]));
$smarty->display("health_general.tpl");
?>