<?php
//$Id: list.php 7448 2013-08-29 14:16:21Z hami $
include "config.php";
include "../../include/sfs_class_absent.php";

//�{��
sfs_check();

$a=new absent("teacher");

if ($_POST[edit]) {	
	foreach($_POST['edit'] as $id=>$v)
	header("Location: record.php?act=edit&id=$id");
} elseif ($_POST[del]) {
	foreach($_POST['del'] as $id=>$v)
	$act="del";
	$a->set_id($id);
	$a->del_absent();
	$query = "delete from teacher_absent_course where a_id ='$id'";
	$CONN->Execute($query);

}
if ($_POST[class_t]) {
	foreach($_POST['class_t'] as $id=>$v)
	header("Location: class.php?id=$id");
}
if ($_POST[outlay]) {
	foreach($_POST['outlay'] as $id=>$v)
	header("Location: outlay.php?id=$id");
}


$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE); 
$smarty->assign("module_name","����B�z"); 
$smarty->assign("SFS_MENU",$school_menu_p); 




//��ܾǴ�
$smarty->assign("year_seme_menu",year_seme_menu($sel_year,$sel_seme));
//��ܰ��O
$smarty->assign("abs_kind",tea_abs($_POST[abs_kind],$a->absent_kind_arr)); 
//��ܤ��
$smarty->assign("month",month_menu($_POST[month])); 
//��ܬO�_�T�w
$smarty->assign("d_check4_menu",d_make_menu("�O�_�T�w",$_POST[d_check4] , $check_arr,"d_check4",1)); 


$smarty->assign("tea_arr",my_teacher_array());
$smarty->assign("abs_kind_arr",$a->absent_kind_arr);
$smarty->assign("course_kind_arr",$course_kind);
$smarty->assign("status_kind_arr",$status_kind);
$smarty->assign("check1",$check1);
$smarty->assign("check2",$check2);
$smarty->assign("check3",$check3);
$smarty->assign("check4",$check4);

//����
$query1.=" year='$sel_year' and semester='$sel_seme' ";


$query1 .=" and teacher_sn='$_SESSION[session_tea_sn]'";

if ($_POST[abs_kind]) {
$query1 .=" and abs_kind='$_POST[abs_kind]'";
}
if ( $_POST[month] ) {
$query1 .=" and month='$_POST[month]'";
}


if ($_POST[d_check4]==1) {
	$query1 .=" and check4_sn >0 ";
}else{
	$query1 .=" and check4_sn =0 ";

}

//�p��X�p

$aa="select sum(day)from teacher_absent where ".$query1;
$m_day=mysql_result(mysql_query($aa),0);

$aa="select sum(hour)from teacher_absent where ".$query1;
$m_hour=mysql_result(mysql_query($aa),0);

$m_day=$m_day+intval($m_hour/8);
$m_hour=($m_hour % 8);
$day_s=($m_day==0)?"":$m_day ."��";
$hour_s=($m_hour==0)?"":$m_hour ."��";

$sum_day= "�X�p�G".$day_s.$hour_s;
$smarty->assign("sum_day",$sum_day); 
//���o���H�а����
$query="select * from teacher_absent where " .$query1 ;


$query .=" order by start_date  desc ";



$res=$CONN->Execute($query);
$smarty->assign("absent",$res->GetRows());

$smarty->display('list.tpl'); 



?>