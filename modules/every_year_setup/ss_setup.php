<?php

// $Id: ss_setup.php 6872 2012-09-03 14:57:09Z infodaes $

/* ���o�򥻳]�w�� */
include "config.php";

sfs_check();
$m_arr = &get_module_setup("every_year_setup");
extract($m_arr);

//�Y����ܾǦ~�Ǵ��A�i����Ψ��o�Ǧ~�ξǴ�
if(!empty($_REQUEST[year_seme])){
	$ys=explode("-",$_REQUEST[year_seme]);
	$sel_year=$ys[0];
	$sel_seme=$ys[1];
}
else {
	// �קK cookie ���~
	if ($_GET[sel_year]) $_POST[sel_year] = $_GET[sel_year];
        if ($_GET[sel_seme]) $_POST[sel_seme] = $_GET[sel_seme];
        $sel_year=(empty($_POST[sel_year]))?curr_year():$_POST[sel_year]; //�ثe�Ǧ~
        $sel_seme=(empty($_POST[sel_seme]))?curr_seme():$_POST[sel_seme]; //�ثe�Ǵ�
}

$Cyear=$_REQUEST[Cyear];
$Cyear=$Cyear?$Cyear:($IS_JHORES+1);
$class_id=$_REQUEST[class_id];
$act=$_REQUEST[act];
$ss_id=$_REQUEST[ss_id];
$scope_id=$_REQUEST[scope_id];
$subject_id=$_REQUEST[subject_id];
$copy_set = $_REQUEST[copy_set];
//���~�]�w
if($error==1){
	$act="error";
	$error_title="�L�~�ų]�w";
	$error_main="�䤣�� $sel_year �Ǧ~�סA�� $sel_seme �Ǵ����~�ų]�w�A�G�z�L�k�ϥΦ��\��C<ol><li>�Х���y<a href='".$SFS_PATH_HTML."school_affairs/every_year_setup/class_year_setup.php'>�Z�ų]�w</a>�z�]�w�~�ťH�ίZ�Ÿ�ơC<li>�H��O�o�C�@�Ǵ����Ǵ��X���n�]�w�@����I</ol>";
}

//����ʧ@�P�_
if($act=="error"){
	$main=&error_tbl($error_title,$error_main);
}elseif($act=="�s�W" or $act=="�[�J����"){
	add_ss($_REQUEST[subject_id],$_REQUEST[subject_name],$_REQUEST[subject_kind],$sel_year,$sel_seme,$_REQUEST[scope_id],$_REQUEST[need_exam],$_REQUEST[rate],$Cyear,$class_id,$_REQUEST['print'],$_REQUEST['sort'],$_REQUEST[sub_sort]);
	header("location: {$_SERVER['PHP_SELF']}?sel_year=$sel_year&sel_seme=$sel_seme&act=set_ss&Cyear=$Cyear&class_id=$class_id");
}elseif($act=="�x�s"){
	update_ss($ss_id,$scope_id,$subject_id,$sel_year,$sel_seme);
	header("location: {$_SERVER['PHP_SELF']}?sel_year=$sel_year&sel_seme=$sel_seme&act=set_ss&Cyear=$Cyear&class_id=$class_id");
}elseif($act=="del"){
	$have_course=&have_course($sel_year,$sel_seme,$ss_id,$Cyear,$class_id);
	if($have_course){
		$main=&show_ss_id_course($sel_year,$sel_seme,$ss_id,$Cyear,$class_id);
	}else{
		header("location: {$_SERVER['PHP_SELF']}?sel_year=$sel_year&sel_seme=$sel_seme&act=do_del&ss_id=$ss_id&Cyear=$Cyear&class_id=$class_id");
	}
}elseif($act=="do_del"){
	del_ss($ss_id);
	header("location: {$_SERVER['PHP_SELF']}?sel_year=$sel_year&sel_seme=$sel_seme&act=set_ss&Cyear=$Cyear&class_id=$class_id");
}elseif($act=="del_all_ss"){
	del_all_ss($sel_year,$sel_seme,$Cyear,$class_id);
	header("location: {$_SERVER['PHP_SELF']}?sel_year=$sel_year&sel_seme=$sel_seme&act=set_ss&Cyear=$Cyear&class_id=$class_id");
}elseif($act=="�x�s�]�w"){
	update_exam_rate_set($ss_id,$scope_id,$subject_id,$_REQUEST[need_exam],$_REQUEST[rate],$_REQUEST['print'],$_REQUEST[link_ss],$_REQUEST['sort'],$_REQUEST[sub_sort],$_REQUEST[pre_scope_sort],$sel_year,$sel_seme,$_REQUEST[nor_item_kind],$_REQUEST[sections]);
	header("location: {$_SERVER['PHP_SELF']}?sel_year=$sel_year&sel_seme=$sel_seme&act=set_ss&Cyear=$Cyear&class_id=$class_id");
}elseif($act=="add_ss" or $act=="view" or $act=="�}�l�]�w" or $act=="set_ss" or $act=="modify_exam" or $act=="add_subject"){
	if($act=="�}�l�]�w")$act="set_ss";
	$main=&list_ss($sel_year,$sel_seme,$Cyear,$class_id,"",$ss_id,$scope_id,$subject_id,$act);
}elseif($act=="�[�ݽҵ{�W����"){
	$main=&list_ss($sel_year,$sel_seme,$Cyear,$class_id,"view",$ss_id,$scope_id,$subject_id,$act);
}elseif($act=="�C�X�Ҧ��~�Žҵ{�W����" or $act=="viewall"){
	$main=&list_all_ss($sel_year,$sel_seme);
}elseif($act=="fast_copy"){
	$main=&fast_copy($sel_year,$sel_seme,$Cyear,$show_Cyear);
}elseif($act=="copy"){
	copy_ss($copy_set,$sel_year,$sel_seme,$Cyear);
	header("location: {$_SERVER['PHP_SELF']}?act=view&sel_year=$sel_year&sel_seme=$sel_seme&Cyear=$Cyear&class_id=$class_id");
}elseif($act=="auto9"){
	auto_copy($sel_year,$sel_seme,$Cyear,$class_id,"�E�~�@�e");
	header("location: {$_SERVER['PHP_SELF']}?act=view&sel_year=$sel_year&sel_seme=$sel_seme&Cyear=$Cyear&class_id=$class_id");
}elseif($act=="setup_view"){
	$main=&setup_view();
}else{
	$main=&ss_form($sel_year,$sel_seme,$Cyear,$class_id);
}


//�q�X����
head("�ҵ{�]�w");
echo $main;
foot();

/*
�禡��
*/

//�򥻳]�w���
function &ss_form($sel_year,$sel_seme,$Cyear="",$class_id=""){
	global $school_menu_p,$IS_CLASS_SUBJECT;
	//�����\���
	$tool_bar=&make_menu($school_menu_p);

	//����
	$help_text="
	�п�ܱ��]�w���y�Ǧ~�סz�B�y�Ǵ��z�C||
	�ҵ{�]�w�i�H�y�~�šz�����Ӱ��ҵ{�]�w�C�]�Y���H�u�~�šv�����A<font color=red>�Z�Ťſ�</font>�^||
	��i�H�u�Z�šv�����Ӱ��ҵ{�]�w�C�]������Z�šA�Υ���~�ŦA��Z�ť�i�^||
	<span class='like_button'>�}�l�]�w</span> �N�O�}�l�]�w�Ӧ~�Ū��ҵ{�W����C||
	<span class='like_button'>�[�ݽҵ{�W����</span> �|�C�X�Ӧ~�ŸӾǴ����ҵ{�W����C||
	<span class='like_button'>�C�X�Ҧ��~�Žҵ{�W����</span> �|�C�X�ӾǴ��Ҧ��~�Ū��ҵ{�W����]�i����y�~�šz�^�C||
	<span style='color:red;'>�]�w�Z�Žҵ{�N�ɭP�P�~�Ŧ��Z�L�k�ƧǡC</span>
	";
	$help=&help($help_text);

	//���o�~�׻P�Ǵ����U�Կ��
	//$date_select=&date_select($sel_year,$sel_seme);
	$date_select=&class_ok_setup_year($sel_year,$sel_seme,"year_seme","jumpMenu");
	
	//���o�~�ſ��
	$class_year_list=&get_class_year_select($sel_year,$sel_seme,$Cyear,"jumpMenu1");
	
	//�~�ŻP�Z�ſ��
	if($IS_CLASS_SUBJECT) $class_select=&get_class_select($sel_year,$sel_seme,$Cyear,"class_id","jumpMenu1",$class_id,"","�Ӧ~�ũҦ��Z��(���q�Z)");
		else $class_select="<select name='class_id'><option selected>�Ӧ~�ũҦ��Z��(���q�Z)</option></select> <font size=1 color='red'>*�Ҳ��ܼƥ��]�w�z�i�H�]�w�ӧO���Z��(�S�ЯZ)�ҵ{</font>";
	
	
	$main="
	<script language='JavaScript'>
	function jumpMenu(){
		if(document.myform.year_seme.options[document.myform.year_seme.selectedIndex].value!=''){
			location=\"{$_SERVER['PHP_SELF']}?act=$act&year_seme=\" + document.myform.year_seme.options[document.myform.year_seme.selectedIndex].value;
		}
	}
	
	function jumpMenu1(){
		if(document.myform.Cyear.options[document.myform.Cyear.selectedIndex].value!=''){
			location=\"{$_SERVER['PHP_SELF']}?act=$act&year_seme=\" + document.myform.year_seme.options[document.myform.year_seme.selectedIndex].value + \"&Cyear=\" + document.myform.Cyear.options[document.myform.Cyear.selectedIndex].value;
		}
	}

	</script>
	$tool_bar
	<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4>
	<tr bgcolor='#FFFFFF'><td>
		<table>
		<form action='{$_SERVER['PHP_SELF']}' method='post' name='myform'>
  		<tr><td>�п�ܱ��]�w���Ǧ~�סG</td>
		<td>$date_select
		<inpjut type='hidden' name='Cyear' value=''>
		<inpjut type='hidden' name='class_id' value=''>
		</td>
		</tr>
		<tr><td colspan='2'><input type='submit' name='act' value='�}�l�]�w' class='b1'>
		<input type='submit' name='act' value='�[�ݽҵ{�W����' class='b1'>
		<input type='submit' name='act' value='�C�X�Ҧ��~�Žҵ{�W����' class='b1'>
		</td></tr>
		</form>
		</table>
	</td></tr>
	</table>
	<br>
	$help
	";
	return $main;
}


//�q�X�Ҧ��ҵ{�A$mode=view�]�u���@�Ӫ�A�L�s�W�έק�u��^�Bclear_view�]�u�����Ӫ�A�s�s���u�㳣���n�^
function &list_ss($sel_year,$sel_seme,$Cyear="",$class_id="",$mode="",$id=0,$add_scope_id=0,$subject_id=0,$act=""){
	global $CONN,$school_kind_name,$school_menu_p,$class9,$IS_CLASS_SUBJECT,$show_nor_items;
	// �p�G�O�Z�Žҵ{��,���o�~�ŭ�
	if (!empty($class_id)){
		$temp_arr = & class_id_2_old($class_id)	;
		$Cyear = $temp_arr[3];
	}

	//���o�~�ſ��
	$class_year_list=&get_class_year_select($sel_year,$sel_seme,$Cyear,"jumpMenu");

	//�~�ŻP�Z�ſ��
	if($IS_CLASS_SUBJECT) $class_select=&get_class_select($sel_year,$sel_seme,$Cyear,"class_id","jumpMenu1",$class_id,"","�Ӧ~�ũҦ��Z��(���q�Z)");
		else $class_select="<select name='class_id'><option selected>�Ӧ~�ũҦ��Z��(���q�Z)</option></select> <font size=1 color='red'>*�Ҳ��ܼƥ��]�w�z�i�H�]�w�ӧO���Z��(�S�ЯZ)�ҵ{</font>";
		//$class_select=&get_class_select($sel_year,$sel_seme,$Cyear,"class_id","jumpMenu1",$class_id,"","�Ӧ~�ũҦ��Z��(���q�Z)");

	$nor_item_array=sfs_text('���ɦ��Z�ﶵ');
	
	//��X�Ӫ��Ҧ����~�׻P�Ǵ��A�n���ӧ@���
	$other_link="act=$act&Cyear=$Cyear&class_id=$class_id";
	$tmp=&get_ss_year($sel_year,$sel_seme,$other_link);
	$other_ss_text=($mode=="clear_view")?"":$tmp;

	//���X�Ӧ~�ũίZ�šB�ӾǦ~�B�ӾǴ��������þǬ�A$ssid[$i][ss_id]�A$ssid[$i][scope_id]�A$ssid[$i][subject_id]
	$ssid=&get_all_ss($sel_year,$sel_seme,$Cyear,$class_id);
	
	$scope_have_subject=array();
	
	$no_data=true;
	
	//�Ҧ���ت��ƶq
	$ss_id_n=sizeof($ssid);
		
	//����X�����쪺���
	for($i=0;$i<$ss_id_n;$i++){
		$ss_id=$ssid[$i]['ss_id'];
		$scope_id=$ssid[$i]['scope_id'];
		$subject_id=$ssid[$i]['subject_id'];
		$subject_rate=$ssid[$i]['rate'];
		$subject_need_exam=$ssid[$i]['need_exam'];

		if(!empty($subject_id)){
			//�⦳���쪺���إ[��}�C��
			$scope_have_subject[]=$scope_id;
			if($subject_need_exam=='1')	$s_rate[$scope_id][$i]=$subject_rate;
			//�p��Ӭ�Ҥ�����ت��ƥ�
			$subject_num[$scope_id]++;
		}

		//�Y�w�g����ơA���q�X�ֳt�ƻs��
		$no_data=false;
	}

	
	//�s�W�X����s
	$add_button=($act=="add_ss" or $mode!="")?"":"<tr><td><input type='button' value='�s�W���' onclick=\"window.location.href='{$_SERVER['PHP_SELF']}?act=add_ss&sel_year=$sel_year&sel_seme=$sel_seme&Cyear=$Cyear&class_id=$class_id'\" class='b1'></td></tr>";
	
	//�s����s
	$edit_button=($mode=="")?"":"<tr><td><input type='button' value='�i��s��' onclick=\"window.location.href='{$_SERVER['PHP_SELF']}?act=set_ss&sel_year=$sel_year&sel_seme=$sel_seme&Cyear=$Cyear&class_id=$class_id'\" class='b1'></td></tr>";
	
	
	//�R�����s
	$del_button=($no_data or $mode!="")?"":"<tr><td><input type='button' value='�M�����]' onclick=\"if(confirm('�T�w�n�M�����]�H'))window.location.href='{$_SERVER['PHP_SELF']}?act=del_all_ss&sel_year=$sel_year&sel_seme=$sel_seme&Cyear=$Cyear&class_id=$class_id'\" class='b2'></td></tr>";
	
	//�۰ʥ[�J�E�~�@�e�ҵ{
	$auto_button=($no_data)?"<tr><td><input type='button' value='�۰ʥ[�J' onclick=\"window.location.href='{$_SERVER['PHP_SELF']}?act=auto9&sel_year=$sel_year&sel_seme=$sel_seme&Cyear=$Cyear&class_id=$class_id'\" class='b1'></td></tr>":"";
	
	
	//�ֳt�ƻs���s
	$fast_copy_button=($no_data)?"<tr><td><input type='button' value='�ֳt�ƻs' onclick=\"window.location.href='{$_SERVER['PHP_SELF']}?act=fast_copy&sel_year=$sel_year&sel_seme=$sel_seme&Cyear=$Cyear&class_id=$class_id'\" class='b1'></td></tr>":"";
	
	
	
	//���s��
	$button="<table cellspacing=1 cellpadding=0 border='0' align='center'>
	$fast_copy_button
	$add_button
	$del_button
	$edit_button
	$auto_button
	</table>";


	$scope_id_array=array();
	
	//�Ҧ���ت��ƶq
	$ss_id_n=sizeof($ssid);
	for($i=0;$i<$ss_id_n;$i++){
		$ss_id=$ssid[$i][ss_id];
		$scope_id=$ssid[$i][scope_id];
		$subject_id=$ssid[$i][subject_id];
		$need_exam=$ssid[$i][need_exam];
		$rate=$ssid[$i][rate];
		$subject_name=&get_subject_name($subject_id);
		$subject_print=$ssid[$i]['print'];
		$subject_sort=$ssid[$i]['sort'];
		$subject_sub_sort=$ssid[$i]['sub_sort'];		
		$subject_link_ss=$ssid[$i]['link_ss'];
		$nor_item_kind=$ssid[$i]['nor_item_kind'];
		$sections=$ssid[$i]['sections'];
		
		//�Y�O�L����A����X�֦X���x�s��
		
		if(empty($subject_id)){
			$td2="";
			$colspan="colspan='2'";
		}else{
			$td2="<td>$subject_name</td>";
			$colspan="";
		}

		//�P�_�O�_�Ӭ�w�g�X�{�L
		if(!in_array($scope_id,$scope_id_array)){
			$scope_id_array[]=$scope_id;
			$scope_name=&get_subject_name($scope_id);

			//���p�Ӭ�ئ�����A�h�[�Jrowspan�ݩ�
			$rowspan=(in_array($scope_id,$scope_have_subject))?"rowspan='$subject_num[$scope_id]'":"";

			//�p�����ƧǪ��s��
			$the_sub_sort=$subject_num[$scope_id]+1;
			$add_subject_pic=($mode=="view" or $mode=="clear_view")?"":"<a href='{$_SERVER['PHP_SELF']}?act=add_subject&scope_id=$scope_id&sel_year=$sel_year&sel_seme=$sel_seme&Cyear=$Cyear&class_id=$class_id&ss_sort=$subject_sort&ss_sub_sort=$the_sub_sort'>
			<img src='images/explode.png' alt=\"�b $scope_name ���U�s�W�@����\" border=0>
			</a>";
			
			$td="<td $rowspan $colspan align='right' nowrap>
			$scope_name
			$add_subject_pic
			</td>
			$td2";
   		}else{
			$scope_name="";
			$rowspan="";
			$td=$td2;
		}
		
		//�\���]�Y�O�[�ݪ��A�A�h���q�X���^
		$modify_tool=($mode=="view" or $mode=="clear_view")?"":"<td class='small' nowrap>
		<a href='{$_SERVER['PHP_SELF']}?act=modify_exam&sel_year=$sel_year&sel_seme=$sel_seme&ss_id=$ss_id&Cyear=$Cyear&class_id=$class_id'>
		<img src='images/edit.png' border=0 hspace=3>�ק�</a>
		<a href=\"javascript:func($ss_id);\">
		<img src='images/del.png' border=0 hspace=3>�R��
		</a></td>";

		//�ݭn�p�������p
		if($need_exam=='1'){
			$checked="checked";
			$exam_pic="<img src='images/ok.png' width=16 height=14 border=0>";
		}else{
			$checked="";
			$exam_pic="";
			$rate="";
		}
		
		//�ݭn�����J���Z�����p
		if($subject_print=='1'){
			$print_checked="checked";
			$print_pic="<img src='images/ok.png' width=16 height=14 border=0>";
		}else{
			$print_checked="";
			$print_pic="";
		}
		
		
		//���p�O���쪺�ܡA�Ƨ����]��sub_sort
		if(empty($subject_id)){
			//�X��
			$sort_col_name="sort";
			$sort_col_name_val=$subject_sort;
			$sort_other="sub_sort";
			$sort_other_val=0;
			$show_sort=$subject_sort;
			$sort_col_kind="hidden";
		}else{
			//����
			$sort_col_name="sub_sort";
			$sort_col_name_val=$subject_sub_sort;
			$sort_other="sort";
			$sort_other_val=$subject_sort;
			$show_sort=$subject_sort."-".$subject_sub_sort;
			$sort_col_kind="text";
		}
		
		$array2[]=$subject_link_ss;
		
	
		$c29=compare_ss($sel_year,$sel_seme,$class9[$Cyear],$subject_link_ss);
		
		//���ͥ��ɶ��ت�SELECT
		$nor_item_select="<select name='nor_item_kind'><option value=''>*�����w*</option>";
		foreach($nor_item_array as $key=>$value){
			if($nor_item_kind==$key) $selected='selected'; else $selected='';
			$show_value=$show_nor_items?"$key ($value)":$key;
			$nor_item_select.="<option value='$key' $selected>$show_value</option>";		
		}
		$nor_item_select.="<select>";
		//��إD�n���e
		$ss.=($act=="modify_exam" && $ss_id==$id)?"
		<tr bgcolor='white'>
		<form action='{$_SERVER['PHP_SELF']}' method='post'>
			$td
			<td align='center'>$ss_id</td>
			<td nowrap><input type='text' name='sections' value='$sections' size='1'></td>
			<td align='center'><input type='checkbox' name='need_exam' value=1 $checked></td>
			<td align='center'><input type='checkbox' name='print' value=1 $print_checked></td>
			<td nowrap><input type='text' name='rate' value='$rate' size='1'></td>
			<td align='center'>
			<input type='$sort_col_kind' name='".$sort_other."' value='".$sort_other_val."' size='1'>
			<input type='text' name='".$sort_col_name."' value='".$sort_col_name_val."' size='1'></td>
			<td><select name='link_ss'>".select_class9($class9[$Cyear],$c29)."</select></td>
			<td>$nor_item_select</td>
			<td class='small'>
			<input type='hidden' name='ss_id' value='$ss_id'>
			<input type='hidden' name='scope_id' value='$scope_id'>
			<input type='hidden' name='subject_id' value='$subject_id'>
			<input type='hidden' name='pre_scope_sort' value='$sort_other_val'>
			<input type='hidden' name='sel_year' value='$sel_year'>
			<input type='hidden' name='sel_seme' value='$sel_seme'>
			<input type='hidden' name='Cyear' value='$Cyear'>
			<input type='hidden' name='class_id' value='$class_id'>
			<input type='submit' name='act' value='�x�s�]�w'  class='b1'>
			</td>
		</form>
		</tr>
		":"
		<tr bgcolor='white'>
			$td
			<td align='center'>$ss_id</td>
			<td nowrap align='center'><font color='#A23B32' face='arial'>$sections</font></td>
			<td align='center'>$exam_pic</td>
			<td align='center'>$print_pic</td>			
			<td nowrap align='center'><font color='#A23B32' face='arial'>$rate</font></td>
			<td align='center' class='small'nowrap>
			<font color='#A7C0EF'>$show_sort</font>
			<td>$c29</td>
			<td>$nor_item_kind</td>
			</td>
			$modify_tool
		</tr>
		";
	}

	$semester_name=($sel_seme=='2')?"�U":"�W";
	
	//�\���]�Y�O�[�ݪ��A�A�h���q�X���^
	$modify_tool_title=($mode=="view" or $mode=="clear_view")?"":"<td align='center'>�\��</td>";

	//�Y�w�Ʃw�ҵ{�Φ����Z��,�����\���
	//print_r($_REQUEST);
	$limit_memo ='';
	if ($_REQUEST[sel_year]<>''){
		$query = "select count(*) from score_semester_$_REQUEST[sel_year]_$_REQUEST[sel_seme] where class_id='$_REQUEST[class_id]'";
		$res_con = $CONN->Execute($query);// or trigger_error("�t�ο��~! $query",E_USER_ERROR);
		if ($res_con->fields[0]>0){
			$limit_memo = "<font color='red'>�ӯZ���e�w�]�w���~�Žҵ{,�äw�����Z����,�����\���]���Z�Žҵ{</font>";
			$button='';	
		}
	}
	if ($limit_memo<>'')
		$no_content="<tr bgcolor='white'><td colspan=10>$limit_memo</td></tr>";
	else
		$no_content=($no_data and !empty($class_id))?"<tr bgcolor='white'><td colspan=11>�ثe�S���ӯZ���ҵ{�]�w�A�ӯZ�ҵ{�|�H�Ӧ~�Žҵ{�]�w���ǡC</td></tr>":"";
	
	$ss_table="
	<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4 class='small'>
	<form action='{$_SERVER['PHP_SELF']}' method='post' name='myform'>
	<tr><td colspan='11' align='center' bgcolor='#E1ECFF'>
	<font color='#607387'>
	<font color='#000000'>$sel_year</font> �Ǧ~
	<font color='#000000'>$semester_name</font>�Ǵ�
	$class_year_list $class_select 
	</font>
	</td></tr>
	</form>
	<tbody>
	<tr bgcolor='#E1ECFF'>
		<td align='center' nowrap>���</td>
		<td align='center' nowrap>����</td>
		<td align='center' nowrap>�ҵ{�N�X</td>
		<td align='center' nowrap>�`��</td>		
		<td align='center' nowrap>�p��</td>
		<td align='center' nowrap>����</td>		
		<td align='center' nowrap>�[�v</td>
		<td align='center' nowrap>�Ƨ�</td>
		<td align='center' nowrap>�E�~�@�e����</td>
		<td align='center' nowrap>���ɦ��Z���ث��w</td>
		$modify_tool_title
		
	</tr>
	$ss
	$no_content
	</tbody>
	</table>";


	//�|������ƮɡA�]���@�ӿ��
	if(empty($select_scope)){
		//���o���W��
		$select_scope=&select_subject($scope_id,'1','scope');

		//���o�Ǭ�W��
		$select_subject=&select_subject($subject_id,'1','subject');
	}


	//���o���W��
	$select_scope=&select_subject("",'1','scope');
	$select_subject=&select_subject("",'1','subject');



	//�s�W���]�Y�O�[�ݪ��A�A�h���q�X���^
	if($act=="add_ss"){
		$scope_num=sizeof($scope_id_array)+1;	
		$add_form=&add_form($sel_year,$sel_seme,$Cyear,$class_id,$scope_num);
	}elseif($act=="add_subject"){
		$add_form=&add_subject_form($add_scope_id,$sel_year,$sel_seme,$Cyear,$class_id,$_REQUEST[ss_sort],$_REQUEST[ss_sub_sort]);
	}

	//�����\���
	$tool_bar = ($mode=="clear_view")?"":make_menu($school_menu_p);

	//�����]�Y�O�[�ݪ��A�A�h���q�X���^
	$help_text="
	<span style='color:red;'>�]�w�e�Х��ѦҦU�����ǥͦ��Z�Ҭd�W�w�I</span>
	||<a href='{$_SERVER['SCRIPT_NAME']}?act=setup_view'>�ҵ{�]�w�n�Z</a>�]�Ĥ@���]�w�̡A�j�P��ĳ�[�ݡI�^
	||<img src='images/explode.png' alt='�b $scope_name ���U�s�W�@����' border=0 hspace='5'>�O�s�W���쪺���s�C
	||�ҿסu��ءv�A�N�O�����Z��|�q�X��@���Z����ءC
	||�ҿסu����v�A�O���Y��ة��U���䤤�@��A�ƭӤ�����[�v��ҩҲզ��@�Ӭ�ت����Z�C<br>
	<font color='#8FAAC8'>�Ҧp�G�u�۵M�P�ͬ���ޡv<font color='darkYellow'>�]��ء^</font>
	�i��O�ѡu���z�v�B�u�ƾǡv�B�u�ͪ��v�B�u�a�y��ǡv<font color='darkYellow'>�]�|�Ӥ���^</font>�Ҳզ��C
	�ҸծɡA�i��|�쳣���U�۪����Z�A���C�L���Z��ɡA�o�|�즨�Z�|�̷ӥ[�v��ҡA�p�⦨�u�۵M�P�ͬ���ޡv�����Z�A
	���Z��u�|�q�X�u�۵M�P�ͬ���ޡv�����Z�C</font>
	||<span style='color:brown;'>�u�ҵ{�N�X�v�G�t�ΰO�����Z���̾ڡA���X���۰ʲ��͡A�ϥΪ̵L�k�ק�C�R���ҵ{�᭫�]�P�W�٪��ҵ{�A�t�ε������@�˪��ǲ߬�ءC
	||�u�`�ơv�G���C�g���W�Ҹ`�ơA�Y����K�z�]�w�[�v��ӥΡA�P���Z�p��L���A���]�w�d�ŧY�i�C</span>
	||�u�p���v�G�Юv�n��Ӭ��J���Z�A�ӥB�Ӭ�ط|�L�b���Z��W�C
	||�u����v�G�Юv��J�Ӭ즨�Z�ɡA�q�ҵ����Z�n�̦���J�A�Y�S��A�h�i�H�u��J�`���Z�A�ݨ̦�����J���ɩάq�Ҧ��Z�C
	||�u�[�v�v�G�Ӭ쪺���Z�p��[�v�C
	||�y�ֳt�ƻs�z���s�A�i�H�Ѩ�L�~�Ū��ҵ{�W����ӽƻs�÷s�W���s���ҵ{�W����C�`�N�I�u���b�Ӧ~���٥��]�w�����خɤ~�|�X�{�C
	";

	$helptmp=&help($help_text);
	$help=($mode=="view" or $mode=="clear_view") ? "" : $helptmp;
	
	if($Cyear=="" and $class_id="")$button="";
	
	
	$none_compare_ss=none_compare_ss($sel_year,$sel_seme,$class9[$Cyear],$array2);
	
	
	//�D�n�q�X�e��
	$main="
	<script language='JavaScript'>
	function func(ss_id){
		var sure = window.confirm('�T�w�n�R���H');
		if (!sure) {
			return;
		}
		location.href=\"{$_SERVER['PHP_SELF']}?act=del&sel_year=$sel_year&sel_seme=$sel_seme&Cyear=$Cyear&class_id=$class_id&ss_id=\" + ss_id;
	}

	function jumpMenu(){
		var dd, classstr ;
		location=\"{$_SERVER['PHP_SELF']}?act=set_ss&sel_year=$sel_year&sel_seme=$sel_seme&Cyear=\" + document.myform.Cyear.options[document.myform.Cyear.selectedIndex].value;
		
	}
	
	function jumpMenu1(){
		var dd, classstr ;
		if ((document.myform.class_id.options[document.myform.class_id.selectedIndex].value!='')) {
			location=\"{$_SERVER['PHP_SELF']}?act=set_ss&sel_year=$sel_year&sel_seme=$sel_seme&Cyear=$Cyear&class_id=\" + document.myform.class_id.options[document.myform.class_id.selectedIndex].value;
		}
	}

	</script>

	$tool_bar

	<table cellspacing=0 cellpadding=0 border='0'>
	<tr>
	<td valign='top'>$ss_table</td>
	<td width='5'></td>
	<td valign='top'>
	$add_form
	$button
	</td>
	<td width='5'></td>
	<td valign='top'>$other_ss_text</td>
	</tr>
	</table>
	<p>
	$none_compare_ss
	</p>
	$help
	";
	return $main;
}


//�ֳt�ƻs����
function &fast_copy($sel_year,$sel_seme,$Cyear,$show_Cyear){
	global $school_kind_name,$school_menu_p;
	//�����\���
	$tool_bar=&make_menu($school_menu_p);
	$semester_name=($sel_seme=='2')?"�U":"�W";
	$ss_list=&get_all_year_ss_list($sel_year,$sel_seme,$Cyear,$show_Cyear);

	//����
	$help_text="
	���I��Y�@�Ӥ��e�w�g�]�w�n���ҵ{�]�p��]�i�I���[�ݳs���A�ݸӽҵ{�W�������e�^�C||
	���U�̤U����s�N�����ƻs�F�I
	";
	$help=&help($help_text);

	$main="
	$tool_bar
	<table>
	<tr><td>�п�ܤ@�Ӥ��e�]�w�n���ҵ{�A
	�t�η|�N�ӽҵ{�ƻs�÷s�W���G<br>
	�y".$sel_year." �Ǧ~".$semester_name."�Ǵ�".$school_kind_name[$Cyear]."�z
	���ҵ{�]�w��</td></tr>
	<tr><td>
	$ss_list
	</td></tr>
	</table>
	<br>
	$help
	";

	return $main;
}


//�s�W�~�׬��
function add_ss($id="",$name="",$kind="",$sel_year="",$sel_seme="",$add_scope_id="",$need_exam='1',$rate='1',$Cyear="",$class_id="",$print="",$sort="",$sub_sort=""){
	global $CONN;
	
	if($kind=="scope"){
		$ss_scope_id=$id;
		$ss_scope_name=$name;
		$ss_subject_id="";
		$ss_subject_name="";
	}elseif($kind=="subject"){
		$ss_scope_id=$add_scope_id;
		$ss_scope_name="";
		$ss_subject_id=$id;
		$ss_subject_name=$name;
	}


	//���p�����S����ظ�ƫh�h�X
	if(empty($name) && empty($id)){
		return;
	}elseif(check_in_ss($ss_scope_id,$ss_scope_name,$ss_subject_id,$ss_subject_name,$sel_year,$sel_seme,$Cyear,$class_id)){
		//�ˬd�ݬݬO�_�w�g���Ӭ��
		return;
	}

	
	if($kind=="scope"){
		//�p�G��J���O�W�١A�ݬݦW�٦b���b�M�椤�A�Y���b�h�[�J�C
		if(!empty($name)){
			//�ˬd$subject_name�b���b��زM�椤
			$sid=in_subject($name,$kind);
			$scope_id=(empty($sid))?add_subject($name,$kind):$sid;
		}elseif(!empty($id)){
			$scope_id=$id;
		}
		//���o��ئW��
		$link_ss=(empty($name))?get_subject_name($scope_id):$name;
	}elseif($kind=="subject"){
		if(!empty($name)){
			//�ˬd$subject_name�b���b��زM�椤
			$sid=in_subject($name,$kind);
			$subject_id=(empty($sid))?add_subject($name,$kind):$sid;
		}elseif(!empty($id)){
			$subject_id=$id;
		}
		$scope_id=$add_scope_id;
		//���o��ئW��
		$link_ss=(empty($name))?get_subject_name($scope_id)."-".get_subject_name($subject_id):get_subject_name($scope_id)."-".$name;
	}

	//�[�J�@�ҵ{���
	$sql_insert = "insert into score_ss (scope_id,subject_id,year,semester,class_year,class_id,enable,need_exam,rate,print,sort,sub_sort,link_ss) values ('$scope_id','$subject_id','$sel_year','$sel_seme','$Cyear','$class_id','1','$need_exam','$rate','$print','$sort','$sub_sort','$link_ss')";
	$CONN->Execute($sql_insert) or user_error($sql_insert,256);
	
	//�Y�O���쪺�ܡA���ҵ{���ð_��
	if($add_scope_id){
		if(hidden_ss($scope_id,$sel_year,$sel_seme,$Cyear,$class_id))	return true;
	}

	return ;
}

//�ק���
function update_ss($ss_id,$scope_id,$subject_id,$sel_year,$sel_seme){
	global $CONN;
	$sql_update = "update score_ss set scope_id='$scope_id',subject_id='$subject_id',year='$sel_year',semester ='$sel_seme',nor_item_kind='$nor_item_kind',sections='$sections' where ss_id = '$ss_id'";
	if($CONN->Execute($sql_update))		return true;
	return  false;
}

//��s�@���Ҹճ]�w
function update_exam_rate_set($ss_id="",$scope_id="",$subject_id="",$need_exam="",$rate="",$print="",$link_ss="",$sort="",$sub_sort="",$pre_scope_sort="",$sel_year="",$sel_seme="",$nor_item_kind="",$sections=""){
	global $CONN;
	
	$sql_update = "update score_ss set need_exam='$need_exam',rate='$rate',print='$print',sort='$sort',sub_sort='$sub_sort',link_ss='$link_ss',nor_item_kind='$nor_item_kind',sections='$sections' where ss_id =$ss_id";
	$CONN->Execute($sql_update) or trigger_error("SQL�y�k���楢�ѡASQL�y�k�p�U�G $sql_update", E_USER_ERROR);
	
	//���p���쪺���ƧǦ����ܡA�@����쪺�Ƨ��ܧ�A�����L�P��쪺���쪺���ƧǤ]�n�@�_�ܤ�
	if($pre_scope_sort!=$sort){
		$sql_update = "update score_ss set sort='$sort' where scope_id =$scope_id and subject_id!=0 and year='$sel_year' and semester='$sel_seme' and enable='1'";
		if($CONN->Execute($sql_update)) return true;
	}
	
	return false;
}

//�R�����
function del_ss($ss_id){
	global $CONN,$sel_year,$sel_seme;
	$sql_update = "update score_ss set enable='0' where ss_id = '$ss_id'";
	if($CONN->Execute($sql_update))		return true;
	return  false;
}


//�R���Ӧ~�šA�ӾǴ��Ҧ����
function del_all_ss($sel_year,$sel_seme,$Cyear,$class_id=""){
	global $CONN;
	if(!empty($class_id)){
		$cls="and class_id='$class_id'";
	}
	$sql_update = "update score_ss set enable='0' where year='$sel_year' and semester ='$sel_seme' and class_year='$Cyear' $cls";
	//echo $sql_update ;
	//$sql_update = "delete  from score_ss  where year='$sel_year' and semester ='$sel_seme' and class_year='$Cyear' $cls";
	
	if($CONN->Execute($sql_update))		return true;
	return  false;
}

//�R�����(�ݧP�_��즳�A������S���A�q�`�Φb�����A���Ӫ����ð_��)
function hidden_ss($scope_id,$sel_year,$sel_seme,$Cyear,$class_id=""){
	global $CONN;
	if(!empty($class_id)){
		$cls="and class_id='$class_id'";
	}
	$sql_update = "update score_ss set enable='0' where scope_id = '$scope_id' and subject_id='0' and year='$sel_year' and semester='$sel_seme' and class_year='$Cyear' $cls";
	if($CONN->Execute($sql_update))		return true;
	return  false;
}

//�ݬ�ئb���b��زM�椤
function in_subject($subject_name,$subject_kind){
	global $CONN,$sel_year,$sel_seme;
	$sql_select = "select subject_id from score_subject where subject_name = '$subject_name' and subject_kind='$subject_kind'";
	$recordSet=$CONN->Execute($sql_select);

	while (!$recordSet->EOF) {
		$subject_id = $recordSet->fields["subject_id"];
		$recordSet->MoveNext();
	}
	return $subject_id;
}



//�s�W�X�쪺���
function &add_form($sel_year,$sel_seme,$Cyear,$class_id="",$sort=""){

	$select_scope=&select_subject($scope_id,'1','scope');
	//�۰ʿ�ܾǴ�
	$selected1=($sel_seme=='1')?"selected":"";
	$selected2=($sel_seme=='2')?"selected":"";
	$ss_form="
	<table cellspacing='4' cellpadding='2' bgcolor='#AFD378'>
	<form action='{$_SERVER['PHP_SELF']}' method='post'>
	<tr bgcolor='#1D6718'><td align='center'><font color='#FFFFFF'>�s�W���</font></td></tr>
	<tr><td class='small' align='center'>
	<p>�п�ܬ�ئW�١G</p>
	$select_scope
	<p>��i�ۦ��J�G</p>
	<input type='text' name='subject_name' size='14'>
	<p>
	<input type='checkbox' name='need_exam' value='1' checked>�p��
	<input type='checkbox' name='print' value='1' checked>����
	</p>
	<input type='hidden' name='sel_year' value='$sel_year'>
	<input type='hidden' name='sel_seme' value='$sel_seme'>
	<input type='hidden' name='rate' value='1'>
	<input type='hidden' name='subject_kind' value='scope'>
	<input type='hidden' name='Cyear' value='$Cyear'>
	<input type='hidden' name='class_id' value='$class_id'>
	<input type='hidden' name='sort' value='$sort'>
	<input type='hidden' name='sub_sort' value='0'>
	<input type='submit' name='act' value='�s�W' class='b1'></td></tr>
	</form>
	</table>";
	return $ss_form;
}

//�s�W���쪺���
function &add_subject_form($scope_id,$sel_year,$sel_seme,$Cyear,$class_id="",$ss_sort="",$ss_sub_sort=""){

	$scope_name=&get_subject_name($scope_id);
	$select_subject=&select_subject('','1','subject');
	$ss_form="
	<table cellspacing='4' cellpadding='2' bgcolor='#FFE0C1'>
	<form action='{$_SERVER['PHP_SELF']}' method='post'>
	<tr><td class='small' align='center'>
	�b<font color='#0000FF'>$scope_name</font>��<br>�U�s�W����G
	<p>$select_subject</p>
	��i�ۦ��J�G
	<p><input type='text' name='subject_name' size='10'></p>
	
	<input type='checkbox' name='need_exam' value='1' checked>�p��
	<input type='checkbox' name='print' value='1' checked>����
	
	<input type='hidden' name='subject_kind' value='subject'>
	<input type='hidden' name='scope_id' value='$scope_id'>
	<input type='hidden' name='sel_year' value='$sel_year'>
	<input type='hidden' name='sel_seme' value='$sel_seme'>
	<input type='hidden' name='Cyear' value='$Cyear'>
	<input type='hidden' name='class_id' value='$class_id'>
	<input type='hidden' name='need_exam' value='1'>
	<input type='hidden' name='rate' value='1'>
	<input type='hidden' name='sort' value='".$ss_sort."'>
	<input type='hidden' name='sub_sort' value='".$ss_sub_sort."'>
	
	<p><input type='submit' name='act' value='�[�J����' class='b1'></p>
	</td></tr>
	</form>
	</table>";
	return $ss_form;
}

//�d�ݭn�s�W���X��Τ���W�٬O�_�w�g���b�̭�
function check_in_ss($scope_id="",$scope_name="",$subject_id="",$subject_name="",$sel_year="",$sel_seme="",$Cyear="",$class_id=""){
	global $CONN;

	if(!empty($scope_id) && !empty($subject_name)){
		$subject_id=get_subject_id($subject_name,'1');
		if(empty($subject_id))return false;
		$and="and scope_id=$scope_id and subject_id=$subject_id";
	}elseif(!empty($scope_id) && !empty($subject_id)){
		$and="and scope_id=$scope_id and subject_id=$subject_id";
	}elseif(!empty($scope_name)){
		$scope_id=get_subject_id($scope_name,'1');
		if(empty($scope_id))return false;
		$and="and scope_id=$scope_id";
	}elseif(!empty($scope_id)){
		$and="and scope_id=$scope_id";
	}else{
		return false;
	}
	
	if(!empty($class_id)){
		$cls="and class_id='$class_id'";
	} else {
		$cls="and class_id=''";
	}

	$sql_select = "select ss_id  from score_ss where enable='1' and year='$sel_year' and semester='$sel_seme' and class_year='$Cyear' $cls $and";

	$recordSet=$CONN->Execute($sql_select);
	$i=0;
	while (!$recordSet->EOF) {
		$id=$recordSet->fields["ss_id"];
		if(!empty($id))return true;
		$recordSet->MoveNext();
	}
	return false;
}


//���o�ҵ{���Ҧ��~�פΦ~��
function &get_all_year_ss_list($sel_year,$sel_seme,$nowCyear,$show_Cyear=""){
	global $CONN,$school_kind_name;

	//��X�Ӫ��Ҧ����~�׻P�Ǵ��A�n���ӧ@���
	$sql_select = "select year,semester,class_year from score_ss where enable='1' order by year,semester,class_year";
	$recordSet=$CONN->Execute($sql_select);
	$other_ss=array();
	while (!$recordSet->EOF) {
		$year = $recordSet->fields["year"];
		$semester = $recordSet->fields["semester"];
		$Cyear = $recordSet->fields["class_year"];

		$semester_name=($semester=='2')?"�U":"�W";
		$other_ss_name="
		&nbsp;".$year."".$semester_name."�A".$school_kind_name[$Cyear]." �ҵ{�]�w��
		<a href='{$_SERVER['PHP_SELF']}?act=fast_copy&show_Cyear=$Cyear&sel_year=$year&sel_seme=$semester&Cyear=$nowCyear'>�y�[�ݡz</a><br>";

		//�s�@��L�Ǧ~�Ǵ������
		if(!in_array($other_ss_name,$other_ss)){
			$other_ss[$i]=$other_ss_name;
			$other_ss_text.="<tr>
			<td><input type='radio' name='copy_set' value='".$year."-".$semester."-".$Cyear."'></td>
			<td>$other_ss_name</td></tr>";
			$i++;
		}

		$recordSet->MoveNext();
	}

	//�Y�O�����w�[�ݡA�h�q�X�d�\���e
	if(!empty($show_Cyear)){
		$show_other_class=&list_ss($sel_year,$sel_seme,$show_Cyear,$class_id,"clear_view");
	}
	$semester_name=($sel_seme=='2')?"�U":"�W";

	$main="
	<table><tr><td valign='top'>
		<table>
		<form action='{$_SERVER['PHP_SELF']}'>
		$other_ss_text
		<input type='hidden' name='act' value='copy'>
		<input type='hidden' name='Cyear' value='$nowCyear'>
		<input type='hidden' name='sel_year' value='$sel_year'>
		<input type='hidden' name='sel_seme' value='$sel_seme'>
		<tr><td colspan='2'>
		<input type='submit' value='�ƻs���u".$sel_year."".$semester_name."�A".$school_kind_name[$nowCyear]."�v�ҵ{�]�w��' class='b1'></td></tr>
		</form>
		</table>
	</td><td valign='top'>$show_other_class</td></tr></table>
	";
	return $main;
}

//�ƻs�Y�@�Ǧ~�Ǵ��~�Ū��ҵ{�w�Ƶ��t�@��
function copy_ss($copy_set,$sel_year,$sel_seme,$Cyear){
	global $CONN;
	
	$c=explode("-",$copy_set);

	$sql_select = "select * from score_ss where enable='1' and year='$c[0]' and semester='$c[1]' and class_year='$c[2]' order by sort,sub_sort";
	$recordSet=$CONN->Execute($sql_select);
	while (!$recordSet->EOF) {
		$scope_id=$recordSet->fields["scope_id"];
		$subject_id=$recordSet->fields["subject_id"];
		$need_exam=$recordSet->fields["need_exam"];
		$rate=$recordSet->fields["rate"];
		$print=$recordSet->fields["print"];
		$sort=$recordSet->fields["sort"];
		$sub_sort=$recordSet->fields["sub_sort"];
		$link_ss=$recordSet->fields["link_ss"];
		$nor_item_kind=$recordSet->fields["nor_item_kind"];
		$sections=$recordSet->fields["sections"];
		

		//�[�J�@�ҵ{���
		$sql_insert = "insert into score_ss (scope_id,subject_id,year,semester,class_year,enable,need_exam,rate,print,sort,sub_sort,link_ss,nor_item_kind,sections) values ('$scope_id','$subject_id','$sel_year','$sel_seme','$Cyear','1','$need_exam',$rate,'$print','$sort','$sub_sort','$link_ss','$nor_item_kind','$sections')";
		$CONN->Execute($sql_insert);

		$recordSet->MoveNext();
	}
	return;
}

//�C�X�Ҧ��~�Ū��ҵ{�W����
function &list_all_ss($sel_year,$sel_seme){
	global $CONN,$school_menu_p,$SFS_PATH_HTML;
	//�C�X�ҵ{�]�w�����]�w�~�ŻP�Z��
	$yc_array=get_ss_yc($sel_year,$sel_seme);
	
	foreach($yc_array as $yc){
		$main.=list_ss($sel_year,$sel_seme,$yc[Cyear],$yc[class_id],"clear_view");
	}
	
	//�����\���
	$tool_bar = ($mode=="clear_view")?"":make_menu($school_menu_p);

	return $tool_bar.$main;
}


//�]�w�n�Z
function &setup_view(){
	global $school_menu_p,$SFS_PATH_HTML;
	//�����\���
	$tool_bar=&make_menu($school_menu_p);
	$main="
	$tool_bar
	<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4>
	<tr bgcolor='#FFFFFF'><td style='line-height: 1.6; '>
	�]�w�ҵ{�M���U�o��̮��������G<p>�y�Ҫ�z�P�y���Z��z</p>

	<p>
	�H��p�@�~�Ŭ��ҡA���]���Z��W�n�X�{�G�y��B���d�P��|�B�ͬ��B�ƾǡB��X����...�����A
	����z���y��ءz�A�ܤִN�n���y�y��B���d�P��|�B�ͬ��B�ƾǡB��X���ʡz�o�X��C�Ҧp�G</p>
	<p><img src='images/help1.png' width=300 height=189 border=0></p>
	<p>
	�i�O�Ҫ�W�A���i��u�λ��h�w�ƽҪ�ڡH�S���I���ǻ��O�Ѧn�X��զ����A�]���A�����Ψ�y����z���\��C
	</p>
	<p>�Ҧp�G�y����A��ڤW�ҥi��O���y��y�B�m�g�y��B�^�y�z����ةҲզ��C����A�i�H�Ρy����z�\��A��o�Ǭ�����إ[�i�h�G	</p>
	<p><img src='images/help2.png' width=330 height=243 border=0></p>

	<p>����O�y�p���z�O�H�y�[�v�z�S�O����H</p>
	<p>�y�p���z=�Ӭ�حn�C�J�Ǵ��`���A�������A�Ѯv������J�Ӭ즨�Z�C</p>
	<p>�y�[�v�z=�ѩ�Ǵ����Z�y�y��z���i��u���@�ӾǴ��`���A�M�ӡA�y��i��S�O�ѡy��y�B�m�g�y��B�^�y�z����ةҲզ��A
	�]���A�������ӡy�[�v�z�ӭp��o�T�Ӭ�ئb�y�y��z��줤�A���Ǵ��`�����p���ҡC</p>
	
	<p>�U�@�ƽҮɡA�ݭn�[�J�p�G�y ���ɬ��ʡz�B�y�ɱϱоǡz�B�y�ɮv�ɶ��z...���������p�����ҵ{�A�B���Ʊ�X�{�b���Z��W�A������H</p>
	
	<p>��²��A��L�̷�@��إ[�i�h�]��@�����i�^�A�çQ�Ρy�ק�z�\���y�p���z�����Y�i�C�o�˴N�i�H�ƤJ�\�Ҫ�A�����Z�椣�X�{�C</p>

	<p><img src='images/help3.png' width=332 height=326 border=0></p>
	<p>�S���]�Ҫ��Q�n���G�y�ͬ��z�B�y���|�z�B�y���ҡz�B�y§���z�o�X��A���O�o�X�쳣�ݩ�y�ͬ��z���]�ܦ��Y�@����M��ت��W�٬ۦP�^�A�B�y§���z���Q�p���A����A�i�H�o�򰵡G</p>
	<p><img src='images/help4.png' width=334 height=404 border=0></p>
	<p>�w�Ʀܦ��A�w�g�i�H�j�P�F�ѡy�\�Ҫ�z���H�U��إi�H�ƶi�h�G</p>
	<ul>
	<li><font color='blue'>��y�B�m�g�y��B�^�y�B���d�P��|�B���|�B�ͬ��B���ҡB<font color='Red'>§��</font>�B�ƾǡB��X���ʡB<font color='Red'>���ɬ���</font>�B<font color='Red'>�ɱϱо�</font>�B<font color='Red'>�ɮv�ɶ�</font></font>
	</ul>
	<p>�ӻݭn�Юv��J���Z�H�K�p�⪺��ئ��]���p������ئ۵M�N���ݭn�աI�^�G</p>
	<ul>
	<li><font color='blue'>��y�B�m�g�y��B�^�y�B���d�P��|�B���|�B�ͬ��B���ҡB�ƾǡB��X����</font>
	</ul>

	�b���Z��W�|�X�{����ئ��]�N�O�Ҧ��y��ءz���W�ٰաI�^�G</p>
	<ul>
	<li><font color='Green'>�y��</font>�]��<font color='blue'>��y�B�m�g�y��B�^�y</font>�p��X�@�Ӧ��Z�^�B<br>
	<li><font color='Green'>���d�P��|</font>�B<br>
	<li><font color='Green'>�ͬ�</font>�]��<font color='blue'>���|�B�ͬ��B����</font>�p��X�@�Ӧ��Z�^�B<br>
	<li><font color='Green'>�ƾ�</font>�B<br>
	<li><font color='Green'>��X����</font></ul>

	��z�@�U�G

	<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4>
	<tr bgcolor='#CDD5FF'><td>���Z��W�|�X�{�����</td><td>�\�Ҫ�i�ƽҪ����</td><td>�Юv�ݿ�J���Z���</td></tr>

	<tr bgcolor='#FFFFFF'><td valign='top'>�y��</td><td valign='top'>��y<br>�m�g�y��<br>�^�y</td><td valign='top'>��y<br>�m�g�y��<br>�^�y</td></tr>
	<tr bgcolor='#FFFFFF'><td>���d�P��|</td><td>���d�P��|</td><td>���d�P��|</td></tr>
	<tr bgcolor='#FFFFFF'><td>�ͬ�</td><td>���|<br>�ͬ�<br>����<br>§��</td><td>���|<br>�ͬ�<br>����</td></tr>
	<tr bgcolor='#FFFFFF'><td>�ƾ�</td><td>�ƾ�</td><td>�ƾ�</td></tr>
	<tr bgcolor='#FFFFFF'><td>��X����</td><td>��X����</td><td>��X����</td></tr>
	<tr bgcolor='#FFFFFF'><td></td><td>���ɬ���<br>�ɱϱо�<br>�ɮv�ɶ�</td><td></td></tr>
	</table>
	
	<p>�̫�A�`�N�I�Х��T�{�n�ҵ{�A�A�ӳ]�w�\�Ҫ�C�Y�O�]�w���\�Ҫ�A�M��S�h��ʽҵ{�]�w�]�Ҧp�G�s�W�B�R����ةΤ���^�i��|�ɭP�\�Ҫ�W�즳���ҵ{�����]���]�Y�i�^�C</p>
	
	</td></tr>
	</table>
	";
return $main;
}


//�ӽҵ{�O�_�w�g���w�ƤF�ҵ{
function &have_course($sel_year,$sel_seme,$ss_id,$Cyear,$class_id=""){
	global $CONN;
	if(!empty($class_id)){
		$cls="and class_id='$class_id'";
	}
	//��X�Y�Z�Ҧ��ҵ{
	$sql_select = "select count(*) from score_course where ss_id='$ss_id' and  year=$sel_year and semester='$sel_seme' $cls";
	$recordSet=$CONN->Execute($sql_select) or trigger_error("���~�T���G $sql_select", E_USER_ERROR);
	list($count)= $recordSet->FetchRow();
	return $count;
}

//�ӽҵ{�Ҽv�T�쪺�ҵ{
function &show_ss_id_course($sel_year,$sel_seme,$ss_id,$Cyear,$class_id=""){
	global $CONN,$SFS_PATH_HTML;
	if(!empty($class_id)){
		$cls="and class_id='$class_id'";
	}
	$ss_name=&get_ss_name("","","��",$ss_id);
	$C_day=array("1"=>"�P���@","�P���G","�P���T","�P���|","�P����","�P����","�P����");
	//��X�Y�Z�Ҧ��ҵ{
	$sql_select = "select class_id,teacher_sn,day,sector,room from score_course where ss_id='$ss_id' and  year=$sel_year and semester='$sel_seme' $cls order by day,sector";
	$recordSet=$CONN->Execute($sql_select) or trigger_error("���~�T���G $sql_select", E_USER_ERROR);
	while (list($class_id,$teacher_sn,$day,$sector,$room)= $recordSet->FetchRow()) {
		$man=get_teacher_name($teacher_sn);
		$class_name=class_id_2_old($class_id);

		$main.="<tr bgcolor='white'><td>$class_name[5]</td><td>$C_day[$day]</td><td>�� $sector �`</td><td><a href='".$SFS_PATH_HTML."school/new_course/teacher_class.php?sel_year=$sel_year&sel_seme=$sel_seme&view_tsn=$teacher_sn'>$man</a></td></tr>";
	}
	$main="
	$error_msg
	<table cellspacing=1 cellpadding=4 bgcolor='#9EBCDD'>
	<tr bgcolor='#E1E6FF'><td>�Z��</td><td>���</td><td>�`��</td><td>�Юv</td></tr>$main</table>";

	$error_msg=&error_tbl("�Ъ`�N�I�I","�z�n�R���Χ��ܪ��y".$ss_name."�z�ҵ{�A�|�v�T�쩳�U�Ҫ����]�w�G<br>$main<br><form action='{$_SERVER['PHP_SELF']}'>���R���Χ��ܨä��|�Y���v�T��t�ιB�@�A���O�бz�ȥ��b�ק��A�]�����ק�Юv���t�ҳ]�w�A���M�|�ɭP�w�Ʀn���Ҫ�䤣��Q�R�����ҵ{�A�p���A�|�s�a�v�T�즨�Z�p��C<p>�T�w�n�R�����ܧ�y".$ss_name."�z�H
	<input type='hidden' name='ss_id' value='$ss_id'><input type='hidden' name='Cyear' value='$Cyear'>
	<input type='hidden' name='act' value='do_del'><input type='submit' value='�T�w' class='b1'></form>");
	return $error_msg;
}


//�۰ʥ[�J�E�~�@�e�ҵ{
function auto_copy($sel_year,$sel_seme,$Cyear,$class_id,$kind=""){
	global $class9;
  			  $need_exam='1';
  			  $rate='1';
  			  $print='1';	
	if($kind=="�E�~�@�e"){
		if(!empty($class_id)){
			$class=get_class_all($class_id);
			$Cyear=$class[year];			
		}
		$The_Class=$class9[$Cyear];
		
		if(sizeof($The_Class)>0){
			$i=1;

			foreach($The_Class as $scope_name => $subject_name){
				
				//�ˬd��ئW�٬O�_�w�g�b��Ʈw��
				$scope_id=chk_subject_id($scope_name,"scope",1);
				
    
				   
				if(is_array($subject_name)){
					
					$j=1;
					foreach($subject_name as $sub_subject_s){				

    				//��جO�_���]�w�n��J���Z
    				$need_exam ='1' ;
    				$print = '1' ;    				
    				list($sub_subject, $need_exam_t , $print_t) = split ('-', $sub_subject_s) ;

    			    if ($need_exam_t =='0' ) { 
    			        $need_exam='' ;
    			        $print = '' ;
    			    }  
    			    if ($print_t =='0') {  
    			       $print = '' ;
    			    }
			
    			  //echo "$sub_subject_s , $sub_subject, $need_exam , $print <br>" ;				
						$subject_id=chk_subject_id($sub_subject,"subject",1);
						$sid=autoadd_ss($sel_year,$sel_seme,$scope_id,$subject_id,$need_exam,$rate,$print,$Cyear,$class_id,"1",$i,$j,$scope_name."-".$sub_subject);
						$j++;
						$ss_id[]=$sid;
					}
				}else{	
    				$need_exam ='1' ;
    				$print = '1' ;   				
					$sid=autoadd_ss($sel_year,$sel_seme,$scope_id,"0",$need_exam,$rate,$print,$Cyear,$class_id,"1",$i,"",$scope_name);
					$ss_id[]=$sid;
				}
				
				$i++;
			}
			
		}
	}
	return $ss_id;
}

//��X��ؽs���A�Ѭ�ئW�٧�X $subject_id
function chk_subject_id($subject_name,$kind,$enable='1'){
	global $CONN;

	if (!$subject_name)  user_error("�S���ǤJ��ئW�١I���ˬd�I",256);

	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	$where_enable=($enable)?"and enable='1'":"";
	$sql_select = "select subject_id from score_subject where subject_name='$subject_name' and subject_kind='$kind' $where_enable";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);

	while (list($subject_id)=$recordSet->FetchRow()) {
		return  $subject_id;
	}
	
	if(empty($subject_id)){
		$subject_id=add_subject($subject_name,$kind);
	}
	return  $subject_id;
}

//�s�W�~�׬��
function autoadd_ss($sel_year,$sel_seme,$scope_id,$subject_id,$need_exam,$rate,$print,$Cyear="",$class_id="",$enable,$sort,$sub_sort,$link_ss){
	global $CONN;
	//���p�����S����ظ�ƫh�h�X
	if(empty($scope_id)){
		return;
	}
	//�[�J�@�ҵ{���
	$sql_insert = "insert into score_ss (scope_id,subject_id,year,semester,class_year,class_id,enable,need_exam,rate,print,sort,sub_sort,link_ss) values ('$scope_id','$subject_id','$sel_year','$sel_seme','$Cyear','$class_id','1','$need_exam','$rate','$print','$sort','$sub_sort','$link_ss')";
	
	$CONN->Execute($sql_insert) or user_error($sql_insert,256);	

	return mysql_insert_id();
}

//�E�~�@�e��ع���
function compare_ss($sel_year,$sel_seme,$The_Class,$subject_link_ss){
	global $CONN,$school_kind_name;
	foreach($The_Class as $scope_name => $subject_name){
		if(is_array($subject_name)){
			foreach($subject_name as $sub_subject){
			  list($sub_subject, $need_exam_t , $print_t) = split ('-', $sub_subject) ;
				$subject=$scope_name."-".$sub_subject;			
				if($subject==$subject_link_ss){
					return $subject;
				}
			}
		}else{	
			if($subject_name==$subject_link_ss){
				return $subject_link_ss;
			}
		}
	}
	return "�D�w�]�����";
}

//�|���������E�~�@�e���
function none_compare_ss($sel_year,$sel_seme,$The_Class,$array2){
	global $CONN,$school_kind_name;
	foreach($The_Class as $scope_name => $subject_name){
		if(is_array($subject_name)){
			foreach($subject_name as $sub_subject){
				list($sub_subject, $need_exam_t , $print_t) = split ('-', $sub_subject) ;
				$subject=$scope_name."-".$sub_subject;
			}
		}else{	
			$subject=$subject_name;
		}			
		$array1[]=$subject;
	}
	
	$diff=array_diff($array1, $array2);
	$all="";
	foreach($diff as $d){
		$all.="<td>".$d."</td>";
	}
	
	if(empty($all))return "";
	
	$main="<table cellspacing=1 cellpadding=4 bgcolor='red' class='small'><tr bgcolor='#FFFFFF'><td bgcolor='#FF0000'><font color='white'>�|���������������</font></td>$all</tr></table>";
	
	return $main;
}


//�E�~�@�e��ؿ��
function select_class9($The_Class=array(),$link_ss=""){
	$subject="<option value=''>�D�w�]�����</option>";
	foreach($The_Class as $scope_name => $subject_name){
		if(is_array($subject_name)){
			foreach($subject_name as $sub_subject){
				$selected=(!empty($link_ss) and $link_ss==$scope_name."-".$sub_subject)?"selected":"";
				$subject.="<option value='".$scope_name."-".$sub_subject."' $selected>".$scope_name."-".$sub_subject."</option>";
			}
		}else{	
			$selected=(!empty($link_ss) and $link_ss==$subject_name)?"selected":"";
			$subject.= "<option value='".$subject_name."' $selected>".$subject_name."</option>";
		}
	}
	return $subject;
}
	
?>
