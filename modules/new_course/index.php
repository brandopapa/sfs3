<?php
// $Id: index.php 5310 2009-01-10 07:57:56Z hami $

/* ���o�򥻳]�w�� */
include "config.php";

//sfs_check();
$teacher_sn=$_SESSION['session_tea_sn'];
$year_seme = $_REQUEST['year_seme'];
$class_id = $_REQUEST['class_id'];

//�Y����ܾǦ~�Ǵ��A�i����Ψ��o�Ǧ~�ξǴ�
if(!empty($year_seme)){
	$ys=explode("-",$year_seme);
	$sel_year=$ys[0];
	$sel_seme=$ys[1];
}

if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�

//���~�]�w
if($error==1){
	$act="error";
	$error_title="�L�~�ũM�Z�ų]�w";
	$error_main="�䤣�� $sel_year �Ǧ~�ײ� $sel_seme �Ǵ����~�ų]�w�A�G�z�L�k�ϥΦ��\��C<ol><li>�Х���y<a href='".$SFS_PATH_HTML."school_affairs/every_year_setup/class_year_setup.php'>�Z�ų]�w</a>�z�]�w�~�ťH�ίZ�Ÿ�ơC<li>�H��O�o�C�@�Ǵ����Ǵ��X���n�]�w�@����I</ol>";
}

//����ʧ@�P�_
if($act=="error"){
	$main=error_tbl($error_title,$error_main);
}else{
	$main=class_form_search($sel_year,$sel_seme);
}


//�q�X����
if (!$IS_STANDALONE) head("�Z�ŽҪ�d��");

echo $main;
if (!$IS_STANDALONE) foot();

/*
�禡��
*/

//�򥻳]�w���
function class_form_search($sel_year,$sel_seme){
	global $school_menu_p,$PHP_SELF,$view_tsn,$teacher_sn,$class_id,$act,$IS_STANDALONE;
	if(empty($view_tsn))$view_tsn=$teacher_sn;

	//�~�ŻP�Z�ſ��
	$class_select=get_class_select($sel_year,$sel_seme,"","class_id","jumpMenu",$class_id);

	if(empty($class_select))	header("location:$PHP_SELF?sel_year&sel_seme=$sel_seme&error=1");


	//���o�~�׻P�Ǵ����U�Կ��
	$date_select=class_ok_setup_year($sel_year,$sel_seme,"year_seme","jumpMenu_seme");

	$tool_bar=(!$IS_STANDALONE)?make_menu($school_menu_p):"";

	$list_class_table=search_class_table($sel_year,$sel_seme,$class_id,"view");

	$main="
	<script language='JavaScript'>
	function jumpMenu(){
		location=\"$PHP_SELF?act=$act&&year_seme=\" + document.myform.year_seme.options[document.myform.year_seme.selectedIndex].value + \"&class_id=\" + document.myform.class_id.options[document.myform.class_id.selectedIndex].value;
	}
	function jumpMenu_seme(){
		if(document.myform.year_seme.options[document.myform.year_seme.selectedIndex].value!=''){
			location=\"$PHP_SELF?act=$act&year_seme=\" + document.myform.year_seme.options[document.myform.year_seme.selectedIndex].value;
		}
	}
	</script>
	$tool_bar
	<table cellspacing='1' cellpadding='4'  bgcolor=#9EBCDD>
	<form action='$PHP_SELF' method='post' name='myform'>
	<tr bgcolor='#F7F7F7'>
	<td>$date_select</td>
	<td>�Z�šG $class_select</td>
	</tr>
	</form>
	</table>
	$list_class_table
	";
	return $main;
}

?>
