<?php
// $Id: chc_prn_week.php 5310 2009-01-10 07:57:56Z hami $
/* ���o�]�w�� */
include_once "config.php";
require_once("chc_class_obj.php");
sfs_check();
// smarty���˪����|�]�w  -----------------------------------
$template_dir = $SFS_PATH."/".get_store_path()."/templates";

//  �w�]���˥���  --(�R�W�Gprt�C�L_ps��p_head���Y.htm)
$tpl_defult=$template_dir."/chc_prn_week.html";

$smarty->left_delimiter="{{";
$smarty->right_delimiter="}}";

$edate = date("Y-m-d");
//-- 94/01/07 �ץ�
$week_arr = get_week_arr("","",$edate);
foreach ($week_arr as $week_no=>$data) {
	if ($week_no==0) continue;
	$week_ary[$week_no]="��{$week_no}�g ({$data} ~ ".date("Y-m-d",strtotime("+6 days",strtotime($data))).")";
}
$smarty->assign('week_ary',$week_ary);
head('�ʽҶg����');
print_menu($school_menu_p);
$smarty->display($tpl_defult); 
foot();
?>
