<?php

// $Id: index.php 5310 2009-01-10 07:57:56Z hami $

//���J�Z�ų]�w
include_once "../../include/config.php";
include_once "../../include/sfs_case_dataarray.php";

sfs_check();

$act=$_POST[act];
$name=$_POST[name];

//����ʧ@�P�_
if($act=="�C�X���ո��"){
	$result=find_data("","all");
}elseif($act=="�d��"){
	$result=find_data($name);
}
if ($_POST[sel]){
	$result=chg_form($_POST[sel]);
}
$main=pre_form();

//�q�X����
head("�Юv�K�X�d��");
echo $main;
echo $result;
foot();

//�j�M����
function pre_form(){
	$main="
	<script>
	<!--
	function sort_kind(a){
		document.pass_form.sort.value=a;
		document.pass_form.act.value='�C�X���ո��';
		document.pass_form.submit();
	}
	function act_kind(a){
		document.pass_form.act.value=a;
		document.pass_form.submit();
	}
	function sel_act(a){
		document.repass_form.act.value=a;
		document.repass_form.submit();
	}
	//-->
	</script>
	<table>
	<form name='pass_form' action='{$_SERVER['PHP_SELF']}' method='post'>
	<tr><td><input type='button' value='�C�X���ո��' OnClick=\"act_kind('�C�X���ո��')\"></td></tr>
	<tr><td>
	��J�Юv�m�W�G
	<input type='text' name='name' size='10'><input type='button' value='�d��' OnClick=\"act_kind('�d��')\"><input type='hidden' name='sort' value=''><input type='hidden' name='act' value=''></td></tr>
	</form>
	</table>";
	return $main;
}

//�j�M���
function find_data($name="",$mode=""){
	global $CONN,$sort;
	$post_office_p = room_kind();
	$class_name = class_base();
	if ($mode=="all") {
		$wherestr = " order by";
		switch($sort) {
			case "post" :
				$wherestr .= " b.post_office, b.post_kind,";
			break;
			case "title" :
				$wherestr .= " d.teach_title_id,";
			break;
			case "name" :
				$wherestr .= " a.name,";
			break;
			default :
			break;
		}
		$wherestr .= " b.teach_title_id, b.class_num";
	} else {
		$wherestr = " and a.name='$name'";
	}
	$query="
	SELECT a.teacher_sn,a.teach_id,a.name,a.login_pass, b.post_kind, b.post_office, d.title_name ,b.class_num 
	FROM teacher_base a , teacher_post b, teacher_title d 
	where a.teacher_sn = b.teacher_sn  
	and b.teach_title_id = d.teach_title_id  
	and a.teach_condition = 0 " . $wherestr ;
	
	$recordSet = $CONN->Execute($query) or user_error($query,256);
	while (list($teacher_sn,$teach_id,$name,$login_pass,$post_kind,$s_unit,$title_name,$class_num)=$recordSet->FetchRow()){
		if (strpos($post_office_p[$s_unit],'���')){
			$post="&nbsp" ;
		}elseif($class_num) {//�ť� 
			$post =$class_name[$class_num] ;
        	}else{
			$post=$post_office_p[$s_unit] ;
		}
		
		$data.="<tr bgcolor='#FFFFFF'>
		<td>$post</td>
		<td>$title_name</td>
		<td>$name</td>
		<td>$teach_id</td>
		<td><input type='submit' name='sel[$teacher_sn]' value='�^�_���w�]�K�X'></td>
		</tr>";
	}
	if ($mode=="all") $mode="�C�X���ո��";
	$main="
	<table cellspacing='1' cellpadding='4' bgcolor='#000000'>
	<form name='repass_form' action='{$_SERVER['PHP_SELF']}' method='post'>
	<tr bgcolor='#E1E1FF'><td><a href=\"#\" OnClick=\"sort_kind('post')\">�B��</a></td><td><a href=\"#\" OnClick=\"sort_kind('title')\">¾��</a></td><td><a href=\"#\" OnClick=\"sort_kind('name')\">�Юv�m�W</a></td><td>�Юv�N��</td><td>�ʧ@</td></tr>
	$data
	</form>
	</table>";
	return $main;
}

//�^�_�K�X���w�]��
function chg_form($sel=array()){
	global $CONN,$DEFAULT_LOG_PASS;
	while(list($k,$v)=each($sel)){
		$CONN->Execute("update teacher_base set login_pass='".pass_operate($DEFAULT_LOG_PASS)."' where teacher_sn='$k'");
		$res=$CONN->Execute("select * from teacher_base where teacher_sn='$k'");
		return $res->fields[name]."���K�X�w�^�_���t�ιw�]�ȡu".$DEFAULT_LOG_PASS."�v";
	}
}