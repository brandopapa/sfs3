<?php

// $Id: stu_list.php 6410 2011-04-19 03:44:27Z infodaes $

//���J�]�w��
require("config.php") ;
require("../../include/sfs_case_dataarray.php") ;

//�{���ˬd
sfs_check();

if(checkid($_SERVER['SCRIPT_FILENAME'],1)) {

//�w�]�Ǵ�
if (!isset($curr_seme))	$curr_seme = curr_seme();

$student_sn =$_GET['student_sn'];

//Ū���J�Ǥβ��~�֭�r��
$query="select * from stud_move where move_kind in ('5','13') and student_sn='$student_sn'";
$res =$CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);
while(!$res->EOF) {
	$cword[$res->fields['move_kind']]=$res->fields['move_c_date'].$res->fields['move_c_word']."�r��".$res->fields['move_c_num']."��";
	$res->MoveNext();
}
$smarty->assign("cword",$cword);

//���P�_�O�_�w���~
$sqlstr = "select stud_id,stud_study_cond,stud_study_year from stud_base where student_sn='$student_sn'";
$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
if ($result->fields[stud_study_cond]==5) {
	$stud_grad_year=$result->fields[stud_study_year]+intval(($IS_JHORES==0)?5:2);
	$sqlstr = "select * from grad_stud where stud_id='".$result->fields[stud_id]."' and stud_grad_year='$stud_grad_year'";
	$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
	$smarty->assign("grad_kind",$result->fields[grad_kind]);
	$smarty->assign("grad_arr",array("1"=>"���~","2"=>"�׷~"));
	$smarty->assign("grad_word_str",$result->fields[grad_date]." ".$result->fields[grad_word]."��".$result->fields[grad_num]."��");
}

//	�ӤH���
$sqlstr = "select *,left(curr_class_num,length(curr_class_num)-2) as class_num,right(curr_class_num,2) as site_num from stud_base where student_sn='$student_sn'";
$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
$smarty->assign("data",$result->FetchRow()); 

 //��f���
$sqlstr = "select * from stud_domicile where student_sn='$student_sn'";
$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
$smarty->assign("data_d",$result->FetchRow()); 

$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("module_name","�j�M");
$smarty->assign("SFS_MENU",$menu_p);
$smarty->assign("sex_arr",array("1"=>"�k","2"=>"�k"));
$smarty->assign("study_cond",study_cond());
$smarty->assign("class_arr",class_base());
$smarty->assign("is_jhores",$IS_JHORES);
$smarty->display("stud_search_list.tpl");

} else header("Location:stud_search2.php");
?>
