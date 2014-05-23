<?php

// $Id: sfs_case_menu.php 5310 2009-01-10 07:57:56Z hami $
include_once $INCLUDE_PATH."sfs_case_PLlib.php";

function year_seme_menu($sel_year,$sel_seme) {
	global $CONN;

	$sql="select year,semester from school_class where enable='1' order by year,semester";
	$rs=$CONN->Execute($sql);
	while (!$rs->EOF) {
		$year=$rs->fields["year"];
		$semester=$rs->fields["semester"];
		if ($year!=$oy || $semester!=$os)
			$show_year_seme[$year."_".$semester]=$year."�Ǧ~�ײ�".$semester."�Ǵ�";
		$oy=$year;
		$os=$semester;
		$rs->MoveNext();
	}
	$menu = new drop_select();
	$menu->s_name ="year_seme";
	$menu->top_option = "��ܾǴ�";
	$menu->id = $sel_year."_".$sel_seme;
	$menu->arr = $show_year_seme;
	$menu->is_submit = true;
	return $menu->get_select();
}

function class_year_menu($sel_year,$sel_seme,$id) {
	global $school_kind_name,$CONN;

	$sql="select distinct c_year from school_class where year='$sel_year' and semester='$sel_seme' and enable='1' order by c_year";
	$rs=$CONN->Execute($sql);
	while (!$rs->EOF) {
		$show_year_name[$rs->fields["c_year"]]=$school_kind_name[$rs->fields["c_year"]]."��";
		$rs->MoveNext();
	}
	$menu = new drop_select();
	$menu->s_name ="year_name";
	$menu->top_option = "��ܦ~��";
	$menu->id = $id;
	$menu->arr = $show_year_name;
	$menu->is_submit = true;
	return $menu->get_select();
}

function class_name_menu($sel_year,$sel_seme,$sel_class,$id) {
	global $CONN;

	$sql="select distinct c_name,c_sort from school_class where year='$sel_year' and semester='$sel_seme' and c_year='$sel_class' and enable='1' order by c_sort";
	$rs=$CONN->Execute($sql);
	while (!$rs->EOF) {
		$show_class_year[$rs->fields["c_sort"]]=$rs->fields["c_name"]."�Z";
		$rs->MoveNext();
	}
	$menu = new drop_select();
	$menu->s_name ="me";
	$menu->top_option = "��ܯZ��";
	$menu->id = $id;
	$menu->arr = $show_class_year;
	$menu->is_submit = true;
	return $menu->get_select();
}

?>
