<?php

// $Id: index.php 5310 2009-01-10 07:57:56Z hami $

include_once "config.php";

sfs_check();


if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}


//����ʧ@�P�_
if($act=="���v"){
	chang_root($new_root_sn);
	header("location:".$_SERVER[PHP_SELF]);
}elseif($act=="del"){
	del_root($p_id);
	header("location:".$_SERVER[PHP_SELF]);
}else{
	$main=cr_form();
}


//�q�X����
head("�ǰȨt�θ�Ƴƥ�");
echo $main;
foot();


/*
�禡��
*/

//�򥻳]�w���
function cr_form(){
	global $school_menu_p,$CONN;
	//�����\���
	$tool_bar=&make_menu($school_menu_p);
	
	$the_root=who_is_root();
	$power=array("�@��","�޲z�v");
	
	foreach($the_root as $id_sn => $root){
		$t_array[]=$id_sn;
		
		$id_kind=$root[id_kind];
		$is_admin=$root[is_admin];
		$p_id=$root[p_id];
		
		if($id_kind=="�Юv"){
			$name=get_teacher_name($id_sn);
		}elseif($id_kind=="¾��"){
			$title=title_kind();
			$name=$title[$id_sn];
		}elseif($id_kind=="�B��"){
			$room=room_kind();
			$name=($id_sn==99)?"�Ҧ��Юv":$room[$id_sn];
		}elseif($id_kind=="�Ǹ�"){
			$name=stud_data($id_sn);
		}elseif($id_kind=="��L"){
			$name="��L";
		}
		
		$data.="<tr bgcolor='#FFFFFF'>		
		<td nowrap>$id_kind</td>
		<td nowrap>$name</td>
		<td nowrap>$power[$is_admin]</td>
		<td nowrap><a href='$_SERVER[PHP_SELF]?act=del&p_id=$p_id'>�Ѱ�</a></td>
		</tr>";
	}
	
	$del_old_root="
	�ثe�㦳���������v���̦p�U�G
	<table width='90%' cellspacing='1' cellpadding='3' bgcolor='#FFD2FF' class='small'>
	<tr><td nowrap>���v��H</td>
	<td nowrap>�Q���v��</td>
	<td nowrap>�v������</td>
	<td nowrap>�Ѱ��v��</td></tr>
	$data
	</table>
	";
	
	
	//�s�@�Юv���
	$sql_select = "select name,teacher_sn from teacher_base where teach_condition='0'";
	$recordSet=$CONN->Execute($sql_select);
	$option="<option value=''></option>";
	while (list($name,$teacher_sn) = $recordSet->FetchRow()) {
		$disabled=(in_array($teacher_sn,$t_array))?"disabled":"";
		$option.="<option value='$teacher_sn' $disabled>$name</option>\n";
	}
	
	$main="
	$tool_bar
	<table cellspacing='0' cellpadding='4' class='small'>
	<tr bgcolor='#FFFFFF'><td valign='top'>
	<form method='post' action='$_SERVER[PHP_SELF]'>
	�п�ܤ@��Юv�@�������s���ޡG<br>
	<select name='new_root_sn'>
	$option
	</select>�Ѯv 
	<input type='submit' name='act' value='���v'>
	</td></tr><tr>
	<td valign='top'>$del_old_root</td>
	</tr></table>
	</form>
	";
	return $main;
}

//���v
function chang_root($new_root_sn=""){
	global $CONN;
	$sql_insert = "insert into pro_check_new 
	(pro_kind_id,id_kind,id_sn) values('1','�Юv',$new_root_sn)";
	$CONN->Execute($sql_insert) or user_error("���v���ѡI<br>$sql_insert",256);
	return true;
}

//�����v��
function del_root($p_id=""){
	global $CONN;
	$man=who_is_root();
	if(sizeof($man)<='1')user_error("�ܤ֭n���@�W���ަs�b�A�G�z�L�k�����������v���C",256);
	$sql_delete = "delete from pro_check_new 
	where p_id='$p_id'";
	$CONN->Execute($sql_delete) or user_error("�������v���ѡI<br>$sql_delete",256);
	return true;
}
?>
