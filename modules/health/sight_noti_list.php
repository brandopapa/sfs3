<?php
/**
 * �C�L���O���}�M��
 */
require "config.php";

$year = (int) substr($_POST['year_seme'],0,-1);
$semester = (int) substr($_POST['year_seme'], -1);
if ($_POST['class_name'] == 'all')
$class_sql ="";
else
$class_sql = " AND a.curr_class_num LIKE '".(int) $_POST['class_name']."$class%'";

$query = "SELECT a.student_sn, a.stud_name, a.stud_sex, a.curr_class_num, b.* FROM stud_base a, health_sight b
			WHERE a.student_sn=b.student_sn AND b.year=$year AND b.semester=$semester AND a.stud_study_cond=0
			  $class_sql ORDER BY a.curr_class_num ,b.side";
$res = $CONN->Execute($query) or trigger_error($query);

$arr = array();
foreach ($res as $row) {
	$row['grade'] = substr($row['curr_class_num'],0,1);
	$row['class'] = (int)substr($row['curr_class_num'],1,2);
	$row['number'] = (int)substr($row['curr_class_num'],-2);

	$arr[$row['student_sn']][$row['side']] = $row;
}
$manage_item = array(
			"1"=>"���O�O��",
			"2"=>"�I�Īv��",
			"3"=>"�t���B�v",
			"4"=>"�a�����B�z",
			"5"=>"�����",
			"6"=>"�w���ˬd",
			"7"=>"�B���v��",
			"8"=>"�t���v��",
			"9"=>"�t����������",
			"N"=>"�䥦");

$smarty->assign('manage_item', $manage_item);

//print_r(get_school_base());
$smarty->assign("school_data",get_school_base());
$smarty->assign('data', $arr);
$smarty->display('sight_noti_list.tpl');
