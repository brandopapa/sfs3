<?php
//$Id: fix_tool.php 5310 2009-01-10 07:57:56Z hami $

include_once "config.php";

include "../../include/sfs_case_dataarray.php";
include_once "../../include/sfs_case_PLlib.php";


//�ϥΪ̻{��
sfs_check();
##################��s  ���y���###########################
if($_POST[act]=='write_base'){
	$SQL="update stud_base set stud_id='$_POST[stud_id]', stud_name='$_POST[stud_name]', stud_sex='$_POST[stud_sex]', stud_study_year='$_POST[stud_study_year]' , curr_class_num='$_POST[curr_class_num]' , stud_study_cond='$_POST[stud_study_cond]'  where student_sn='$_POST[student_sn]' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$url=$_SERVER[PHP_SELF]."?student_sn=".$_POST[student_sn];
	header("Location:$url");
}
##################��s  �Ǵ����###########################
if($_POST[act]=='write_seme'){
	$SQL="update stud_seme set stud_id='$_POST[stud_id]', seme_year_seme='$_POST[seme_year_seme]', seme_class='$_POST[seme_class]', seme_num='$_POST[seme_num]' where student_sn='$_POST[student_sn]' and seme_year_seme='$_POST[old_seme_year_seme]' and seme_class='$_POST[old_seme_class]' and seme_num='$_POST[old_seme_num]'  and stud_id='$_POST[old_stud_id]'";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$url=$_SERVER[PHP_SELF]."?student_sn=".$_POST[student_sn];
	header("Location:$url");
}
##################�R�����###########################
if($_POST[act]=='del_base'){
	$SQL="delete from  stud_base   where student_sn='$_POST[student_sn]' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$url=$_SERVER[PHP_SELF]."?student_sn=".$_POST[student_sn];
	header("Location:$url");
}
##################�R���Ǵ����###########################
if($_POST[act]=='del_seme'){
	$SQL="delete from stud_seme where student_sn='$_POST[student_sn]' and stud_id='$_POST[stud_id]'  and seme_year_seme='$_POST[seme_year_seme]' and seme_class='$_POST[seme_class]' and seme_num='$_POST[seme_num]' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$url=$_SERVER[PHP_SELF]."?student_sn=".$_POST[student_sn];
	header("Location:$url");
}
##################�R���Ǵ����###########################
if($_POST[act]=='del_seme_all'){
	$SQL="delete from stud_seme where student_sn='$_POST[student_sn]' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$url=$_SERVER[PHP_SELF]."?student_sn=".$_POST[student_sn];
	header("Location:$url");
}

head("���D�u��c");
print_menu($school_menu_p);

if( $_GET[student_sn]!=''){
	$SQL="select * from stud_base where student_sn='$_GET[student_sn]' ";
	$arr_a=get_order2($SQL);
	$SQL="select * from  stud_seme where student_sn='$_GET[student_sn]' order by seme_year_seme ";
	$arr_b=get_order2($SQL);
///////////////// ���Z�������//////////////////////////
	$SQL="select subject_id, subject_name from score_subject order by  subject_id ";
	$subj=initArray("id,sname",$SQL);//������W�ٸ��
	$SQL="select ss_id,scope_id ,subject_id from score_ss where  enable='1'  ";
	$ss_3=initArray3("SS,Sa,Sb",$SQL);//��SS_ID���
	$SQL="select * from  stud_seme_score where student_sn='$_GET[student_sn]' and ss_score !='NULL' order by seme_year_seme ";
	$arr_seme_score=get_order2($SQL);//���ӥͩҦ��Ǵ����Z���
/////////////////�[�J�����ئW��/////////////////
	for($i=0;$i<count($arr_seme_score);$i++){
		$SS=$arr_seme_score[$i][ss_id];
		$arr_seme_score[$i][cname]=$subj[$ss_3[$SS][Sa]].":".$subj[$ss_3[$SS][Sb]];
		}
	}

if($_POST[stud_id]!='') {
	$SQL="select * from stud_base where stud_id='$_POST[stud_id]' ";
	$arr_a=get_order2($SQL);
	$SQL="select * from  stud_seme where stud_id='$_POST[stud_id]'  order by seme_year_seme ";
	$arr_b=get_order2($SQL);
	}



$stud_coud=study_cond();//���y��ƥN�X
$now_seme=sprintf("%03d",curr_year()).curr_seme();//�ثe�Ǵ�//�ثe�Ǧ~
// smarty template ���|
$template_dir = $SFS_PATH."/".get_store_path()."/templates";
// �ϥ� smarty tag
$smarty->left_delimiter="{{";
$smarty->right_delimiter="}}";
//�Ǯե���
$smarty->assign("PHP_SELF",$_SERVER[PHP_SELF]);
$smarty->assign("school_long_name",$school_long_name);
$smarty->assign("now_seme",$now_seme);
$smarty->assign("arr_a",$arr_a);
$smarty->assign("arr_b",$arr_b);
$smarty->assign("arr_seme_score",$arr_seme_score);



$smarty->assign("stud_coud",$stud_coud);
$smarty->assign("template_dir",$template_dir);

$smarty->display("$template_dir/fix_tool.htm");


foot();

##################����ƨ禡###########################
function get_order2($SQL) {
	global $CONN ;
$rs=$CONN->Execute($SQL) or die($SQL);
$arr = $rs->GetArray();
return $arr ;
}
function initArray3($F1,$SQL){
	global $CONN ;
//	global $db;
// ��|����F �O���� $rs ��������m(EOF�GEnd Of File)�ɡA(�Y�G�٦��O���|�����X��)
	$col=split(",",$F1);
	$rs = $CONN->Execute($SQL) or die($SQL);
	$col[0] = array();
	if (!$rs) {
    Return $CONN->ErrorMsg(); 
	} else {
		while (!$rs->EOF) {
		$col[0][$rs->fields[0]][$col[1]]=$rs->fields[1];
		$col[0][$rs->fields[0]][$col[2]]=$rs->fields[2];
	$rs->MoveNext(); // ���ܤU�@���O��
	}
	}
	Return $col[0];
}

##################���o���ظ�T�禡###########################
function initArray($F1,$SQL){
	global $CONN ;
//	global $db;
// ��|����F �O���� $rs ��������m(EOF�GEnd Of File)�ɡA(�Y�G�٦��O���|�����X��)
	$col=split(",",$F1);
	$rs = $CONN->Execute($SQL) or die($SQL);
	$sch_all = array();
	if (!$rs) {
    Return $CONN->ErrorMsg(); 
	} else {
		while (!$rs->EOF) {
		$sch_all[$rs->fields[0]]=$rs->fields[1]; 
	$rs->MoveNext(); // ���ܤU�@���O��
	}
	}
	Return $sch_all;
}

?>
