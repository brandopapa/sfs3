<?php
// $Id: my_fun.php 5310 2009-01-10 07:57:56Z hami $

function class_year_menu($sel_year,$sel_seme,$id="") {
	global $CONN;

	$cym = new drop_select();
	$cym->s_name ="c_year";
	$cym->has_empty = false;
	$cym->top_option = "��ܦ~��";
	$cym->id = $id;
	$cym->arr = year_base($sel_year,$sel_seme,"��");
	$cym->is_submit = true;
	return $cym->get_select();
}

function subject_menu($arr=array(),$id="") {
	global $CONN;

	$sm = new drop_select();
	$sm->s_name ="ss_id";
	$sm->has_empty = false;
	$sm->top_option = "��ܽҵ{";
	$sm->id = $id;
	$sm->arr = $arr;
	$sm->is_submit = true;
	return $sm->get_select();
}

function class_menu($arr=array(),$id="") {
	global $CONN;

	$cm = new drop_select();
	$cm->s_name ="group_id";
	$cm->has_empty = false;
	$cm->top_option = "��ܯZ��";
	$cm->id = $id;
	$cm->arr = $arr;
	$cm->is_submit = true;
	return $cm->get_select();
}
?>
