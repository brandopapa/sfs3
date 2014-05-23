<?php

// $Id: teacher_setup.php 5310 2009-01-10 07:57:56Z hami $

/* ���o�򥻳]�w�� */
include "config.php";

sfs_check();

if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}


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
	$error_title="�L�~�ų]�w";
	$error_main="�䤣�� $sel_year �Ǧ~�סA�� $sel_seme �Ǵ����~�ų]�w�A�G�z�L�k�ϥΦ��\��C<ol><li>�Х���y<a href='".$SFS_PATH_HTML."school_affairs/every_year_setup/class_year_setup.php'>�Z�ų]�w</a>�z�]�w�~�ťH�ίZ�Ÿ�ơC<li>�H��O�o�C�@�Ǵ����Ǵ��X���n�]�w�@����I</ol>";
}

//����ʧ@�P�_
if($act=="error"){
	$main=&error_tbl($error_title,$error_main);
}elseif($act=="�x�s"){
	update_teacher($sel_year,$sel_seme,$seme_class,$teacher_sn);
	header("location: {$_SERVER['PHP_SELF']}?sel_year=$sel_year&sel_seme=$sel_seme&act=set_teacher&Cyear=$Cyear");
}elseif($act=="�}�l�]�w" or $act=="set_teacher" or $act=="modify_teacher"){
	if($act=="�}�l�]�w")$act="set_teacher";
	$main=&list_class($sel_year,$sel_seme,$Cyear,"",$act,$seme_class);
}elseif($act=="view" or $act=="�[�ݳ]�w"){
	$main=&list_class($sel_year,$sel_seme,$Cyear,"view",$act,$seme_class);
}elseif($act=="�C�X�Ҧ��~��" or $act=="viewall"){
	$main=&list_all_class($sel_year,$sel_seme);
}elseif($act=="setup_view"){
	$main=&setup_view();
}else{
	$main=&class_form($sel_year,$sel_seme);
}


//�q�X����
head("�ɮv�]�w");
echo $main;
foot();

/*
�禡��
*/

//�򥻳]�w���
function &class_form($sel_year,$sel_seme){
	global $school_menu_p,$IS_JHORES;
	//�����\���
	$tool_bar=&make_menu($school_menu_p);

	$dts=($IS_JHORES==6)?"�ɮv":"�ť��Ѯv";

	//����
	$help_text="
	�п�ܤ@�ӾǦ~�B�Ǵ��H���]�w�C||
	<span class='like_button'>�}�l�]�w</span> �|�}�l�i��ӾǦ~�Ǵ���".$dts."�]�w�C||
	<span class='like_button'>�[�ݳ]�w</span> �|�C�X�ӾǦ~�Ǵ���".$dts."�]�w�C||
	<span class='like_button'>�C�X�Ҧ��~��</span> �|�C�X�ӾǦ~�Ǵ��Ҧ��~�Ū�".$dts."�]�w�C
	";
	$help=&help($help_text);

	//���o�~�׻P�Ǵ����U�Կ��
	$date_select=&class_ok_setup_year($sel_year,$sel_seme,"year_seme","jumpMenu");
	
	//���o�~�ſ��
	$class_year_list=&get_class_year_select($sel_year,$sel_seme,$Cyear);
	
	$main="
	<script language='JavaScript'>
	function jumpMenu(){
		if(document.myform.year_seme.options[document.myform.year_seme.selectedIndex].value!=''){
			location=\"{$_SERVER['PHP_SELF']}?act=$act&year_seme=\" + document.myform.year_seme.options[document.myform.year_seme.selectedIndex].value;
		}
	}
	</script>
	$tool_bar
	<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4>
	<tr bgcolor='#FFFFFF'><td>
		<table>
		<form action='{$_SERVER['PHP_SELF']}' method='post' name='myform'>
  		<tr><td>�п�ܱ��]�w���Ǧ~�סG</td><td>$date_select</td></tr>
		<tr><td>�п�ܱ��]�w���~�šG</td><td>$class_year_list</td></tr>
		<tr><td colspan='2'><input type='submit' name='act' value='�}�l�]�w'>
		<input type='submit' name='act' value='�[�ݳ]�w'>
		<input type='submit' name='act' value='�C�X�Ҧ��~��'>
		<INPUT TYPE='button' Value='�ֳt�s��' onclick=\"location.href='chc_teacher.v2.php'\">
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


//�q�X�Ҧ��Z�šA$mode=view�]�u���@�Ӫ�A�L�s�W�έק�u��^�Bclear_view�]�u�����Ӫ�A�s�s���u�㳣���n�^
function &list_class($sel_year,$sel_seme,$Cyear="",$mode="",$act="",$seme_class=""){
	global $CONN,$school_kind_name,$school_menu_p,$IS_JHORES;

	$dts=($IS_JHORES==6)?"�ɮv":"�ť��Ѯv";
	
	//���o�~�ſ��
	$class_year_list=&get_class_year_select($sel_year,$sel_seme,$Cyear,"jumpMenu");
	
	//��X�Ӫ��Ҧ����~�׻P�Ǵ��A�n���ӧ@���
	$other_link="act=$act&Cyear=$Cyear";
	$tmp=&get_ss_year($sel_year,$sel_seme,$other_link);
	$other_class_text=($mode=="clear_view")?"":$tmp;

	//���X�Ӧ~�šB�ӾǦ~�B�ӾǴ����Z�ŦC��
	$class_list="";
	$query = "select c_year,c_sort,c_name,teacher_1,teacher_2 from school_class where enable=1 and year=$sel_year and semester=$sel_seme order by c_year,c_sort";
	$res = $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);
	$class_name=array();
	$teacher=array();
	$sel_year_arr = array_keys ($school_kind_name);
	while(!$res->EOF) {
		if (in_array ($res->fields[c_year], $sel_year_arr)) { //�b��ܪ��~�Ť�
			$class_name_id = sprintf("%d%02d",$res->fields[c_year],$res->fields[c_sort]);
			$class_name[$class_name_id]=$school_kind_name[$res->fields[c_year]].$res->fields[c_name]."�Z";
			$teacher[$class_name_id][1]=addslashes($res->fields[teacher_1]);
			$teacher[$class_name_id][2]=addslashes($res->fields[teacher_2]);
		}
		$res->MoveNext();
	}
	while (list($k,$v)=each($class_name)) {
		if (empty($Cyear) || ($Cyear==substr($k,0,-2))) {
			if ($teacher[$k][1]=="" && $sel_year==curr_year() && $sel_seme==curr_seme()) {
				$sql_select = "select a.class_num,b.name from teacher_post a,teacher_base b where a.teacher_sn=b.teacher_sn and a.class_num='$k'";
				$recordSet=$CONN->Execute($sql_select) or trigger_error("���~�T���G $sql_select", E_USER_ERROR);
				$name=addslashes($recordSet->fields[name]);
				$teacher[$k][1]=$name;
				$class_year=substr($k,0,-2);
				$class_sort=substr($k,-2,2);
				$sql_update="update school_class set teacher_1='$name' where enable=1 and year='$sel_year' and semester='$sel_seme' and c_year='$class_year' and c_sort='$class_sort'";
				$recordSet=$CONN->Execute($sql_update);
			}
			//�\���]�Y�O�[�ݪ��A�A�h���q�X���^
			$modify_tool=($mode=="view" or $mode=="clear_view")?"":"<td class='small' nowrap>
			<a href='{$_SERVER['PHP_SELF']}?act=modify_teacher&sel_year=$sel_year&sel_seme=$sel_seme&Cyear=$Cyear&seme_class=$k'>
			<img src='images/edit.png' border=0 hspace=3>�ק�</a></td>";
			$teacher_list=get_teacher_list($sel_year,$sel_seme,stripslashes($teacher[$k][1]));
			$class_list.=($act=="modify_teacher" && $seme_class==$k)?"<tr bgcolor='white'><form method='post' action='{$_SERVER['PHP_SELF']}'><td align='center'>".$class_name[$k]."</td>
				<td align='center'><select name=teacher_sn>".$teacher_list."</select></td>
				<td><input type='submit' name='act' value='�x�s'></td>
				<input type='hidden' name='sel_year' value='$sel_year'>
				<input type='hidden' name='sel_seme' value='$sel_seme'>
				<input type='hidden' name='Cyear' value='$Cyear'>
				<input type='hidden' name='seme_class' value='$k'>
				</form></tr>":"<tr bgcolor='white'><td align='center'>".$class_name[$k]."</td><td align='center'>".stripslashes($teacher[$k][1])."</td>$modify_tool</tr>";
		}
	}
	
	//�s����s
	$edit_button=($mode=="")?"":"<tr><td>
	<a href='{$_SERVER['PHP_SELF']}?act=set_teacher&sel_year=$sel_year&sel_seme=$sel_seme&Cyear=$Cyear'>
	<img src='images/edit_ss.png' alt='�i��s��' width='84' height='24' border='0'></a>
	</td></tr>";
	
	//���s��
	$button="<table cellspacing=1 cellpadding=0 border='0' align='center'>
	$fast_copy_button
	$add_button
	$del_button
	$edit_button
	$auto_button
	</table>";

	//�\���]�Y�O�[�ݪ��A�A�h���q�X���^
	$modify_tool_title=($mode=="view" or $mode=="clear_view")?"":"<td align='center'>�\��</td>";

	//�����\���
	$tool_bar = ($mode=="clear_view")?"":make_menu($school_menu_p);

	$class_table="
	<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4 class='small'>
	<form action='{$_SERVER['PHP_SELF']}' method='post' name='myform'>
	<tr><td colspan='7' align='center' bgcolor='#E1ECFF'>
	<font color='#607387'>
	<font color='#000000'>$sel_year</font> �Ǧ~
	<font color='#000000'>$semester_name</font>�Ǵ�
	$class_year_list ".$dts."�C��
	</font>
	</td></tr>
	</form>
	<tbody>
	<tr bgcolor='#E1ECFF'>
		<td align='center' nowrap>�Z��</td>
		<td align='center' nowrap>".$dts."�m�W</td>
		$modify_tool_title
	</tr>
	$class_list
	</tbody>
	</table>";

	//�D�n�q�X�e��
	$main="
	<script language='JavaScript'>
	function func(ss_id){
		var sure = window.confirm('�T�w�n�R���H');
		if (!sure) {
			return;
		}
		location.href=\"{$_SERVER['PHP_SELF']}?act=del&sel_year=$sel_year&sel_seme=$sel_seme&Cyear=$Cyear&ss_id=\" + ss_id;
	}

	function jumpMenu(){
		var dd, classstr ;
		if ((document.myform.Cyear.options[document.myform.Cyear.selectedIndex].value!='')) {
			location=\"{$_SERVER['PHP_SELF']}?act=view&sel_year=$sel_year&sel_seme=$sel_seme&Cyear=\" + document.myform.Cyear.options[document.myform.Cyear.selectedIndex].value;
		}
	}

	</script>

	$tool_bar

	<table cellspacing=0 cellpadding=0 border='0'>
	<tr>
	<td valign='top'>$class_table</td>
	<td width='5'></td>
	<td valign='top'>
	$add_form
	$button
	</td>
	<td width='5'></td>
	<td valign='top'>$other_class_text</td>
	</tr>
	</table>
	$help
	";
	return $main;
}

//�ק�ɮv
function update_teacher($sel_year,$sel_seme,$seme_class,$teacher_sn){
	global $CONN;
	$sql="select name from teacher_base where teacher_sn='$teacher_sn'";
	$rs=$CONN->Execute($sql);
	$name=addslashes($rs->fields['name']);
	if ($sel_year==curr_year() && $sel_seme==curr_seme()) {
		$sql="update teacher_post set class_num='' where class_num='$seme_class'";
		$rs=$CONN->Execute($sql);
		$sql="update teacher_post set class_num='$seme_class' where teacher_sn='$teacher_sn'";
		$rs=$CONN->Execute($sql);
	}
	$c_year=substr($seme_class,0,-2);
	$c_sort=substr($seme_class,-2,2);
	$sql_update = "update school_class set teacher_1='$name' where year='$sel_year' and semester='$sel_seme' and c_year='$c_year' and c_sort='$c_sort' and enable=1";
	if($CONN->Execute($sql_update))		return true;
	return  false;
}

//�C�X�Ҧ��~�Ū��Z�žɮv�C��
function &list_all_class($sel_year,$sel_seme){
	global $school_menu_p,$SFS_PATH_HTML;
	$all_class=get_class_year_array($sel_year,$sel_seme);
	if(empty($all_class)){
		trigger_error("�S���~�ų]�w�L�k�i��A�z�������i��Z�ų]�w�A�~��ϥΦ��\��C<br>
		<a href='".$SFS_PATH_HTML."school_affairs/every_year_setup/class_year_setup.php'>�}�l�Z�ų]�w</a>", E_USER_ERROR);
	}

	//�����\���
	$tool_bar = ($mode=="clear_view")?"":make_menu($school_menu_p);

	while(list($class_year_val,$class_year_name)=each($all_class)){
		$main.=list_class($sel_year,$sel_seme,$class_year_val,"clear_view");
	}
	return $tool_bar.$main;
}

//�C�X�Ҧ��~�Ū��Z�žɮv�C��
function get_teacher_list($sel_year,$sel_seme,$teacher_name){
	global $CONN;

	//���k������C��
	$fcolor[1] = "blue";
	//���k������C��
	$fcolor[2] = "#FF6633";
	$teacher_list="";
	if ($sel_year==curr_year() && $sel_seme==curr_seme()) $w="where teach_condition='0'";
	$sql="select name,sex,teacher_sn from teacher_base $w order by name";
	$rs=$CONN->Execute($sql);
	while (!$rs->EOF) {
		$name=addslashes($rs->fields['name']);
		$selected=($teacher_name==$name)?"selected":"";
		$teacher_list.="<option value='".$rs->fields['teacher_sn']."' $selected><font color='".$fcolor[$rs->fields['sex']]."'>".stripslashes($name)."</option>\n";
		$rs->MoveNext();
	}
	return $teacher_list;
}
?>
