<?php
// $Id: nor_del.php 5310 2009-01-10 07:57:56Z hami $
/*�ޤJ�ǰȨt�γ]�w��*/
include "config.php";

//�ϥΪ̻{��
sfs_check();

//���o�Ҳճ]�w
$m_arr = get_sfs_module_set();
extract($m_arr, EXTR_OVERWRITE);

//���o���T���нҵ{
$course_arr_all=get_teacher_course(curr_year(),curr_seme(),$_SESSION[session_tea_sn],$is_allow);
$course_arr = $course_arr_all['course'];
// �ˬd�ҵ{�v���O�_���T
$cc_arr=array_keys($course_arr);
$err=(in_array($_GET[teacher_course],$cc_arr))?0:1;

if ($err==0) {
	$nor_score="nor_score_".curr_year()."_".curr_seme();
	$sql2  ="DELETE from $nor_score WHERE freq='{$_GET['del']}' and class_subj='{$_GET['class_subj']}' and stage='{$_GET['stage']}'";
	//echo $sql2;
	$CONN->Execute($sql2);
}
header("Location:normal.php?teacher_course={$_GET['teacher_course']}&curr_sort={$_GET['stage']}");
?>
