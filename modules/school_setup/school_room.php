<?php

// $Id: school_room.php 5310 2009-01-10 07:57:56Z hami $

// ���J�]�w��
include "school_base_config.php";

// �{���ˬd
sfs_check();

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

if ($act == "�ק�T�w") {
	update_all_room($room_name,$room_tel,$room_fax);
	header("location: {$_SERVER['PHP_SELF']}");
}elseif ($act=="�s�W�T�w") {
	add_room($room_name,$room_tel,$room_fax);
	header("location: {$_SERVER['PHP_SELF']}");
}elseif ($act=="delete") {
	del_room($room_id);
	header("location: {$_SERVER['PHP_SELF']}");
}elseif ($act=="�ק�Ҧ�") {
	$main=&room_setup_form("edit");
}elseif ($act=="�s�W�B��") {
	$main=&room_setup_form("add");
}else{
	$main=&room_setup_form();
}

//�q�X����
head("�B�ǳ]�w");
echo $main;
foot();

//�[�ݦU�B�Ǫ��
function &room_setup_form($mode=""){
	global $CONN,$school_menu_p;
	
	$view_button="<input type=submit name='act' value='�s���Ҧ�'>";
	$add_button="<input type=submit name='act' value='�s�W�B��'>";
	$modify_button="<input type=submit name='act' value='�ק�Ҧ�'>";
	$modify_submit_button="<input type='submit' name='act' value='�ק�T�w'>";


	if ($mode=="edit"){
		$b0="$view_button $add_button $modify_submit_button";
		$b1="$modify_submit_button";
	}elseif($mode=="add"){
		$b0="$view_button $modify_button";
		$function_name="<td align='center'>�ʧ@</td>";
		$add_form="<tr class='title_mbody'>
		<td></td>
		<td><input type='text' size='20' maxlength='30' name='room_name'></td>
		<td align='center' ><input type='text' size='20' maxlength='15' name='room_tel'></td>
		<td align='center' ><input type='text' size='15'  name='room_fax'></td>
		<td><input type='submit' name='act' value='�s�W�T�w'></td>
		</tr>";
	}else{
		$b0="$view_button $add_button $modify_button";
		$function_name="<td align='center'>�ʧ@</td>";
	}
	
	$button0="<tr  class='title_sbody2'><td colspan='5'>$b0</td></tr>";
	$button1=(!empty($b1))?"<tr  class='title_sbody2'><td colspan='5'>$b1</td></tr>":$button0;

	//Ū�����
	$sql_select = "select room_id,room_name,room_tel,room_fax from school_room where enable='1'";
	$result = $CONN->Execute ($sql_select) or die($sql_select) ;
	while (!$result->EOF) {
		$room_id = $result->fields["room_id"];
		$room_name = $result->fields["room_name"];
		$room_tel = $result->fields["room_tel"];
		$room_fax = $result->fields["room_fax"];
		$ti = ($i++%2)+1;


		$room=($mode=="edit")?
		"<td><input type='text' size='30' maxlength='30' name='room_name[$room_id]' value='$room_name'></td>
		<td align='center'><input type='text' size='15' maxlength='20' name='room_tel[$room_id]' value='$room_tel'></td>
		<td align='center'><input type='text' size='15' maxlength='20' name='room_fax[$room_id]' value='$room_fax'></td>
		":"
		<td>$room_name</td>
		<td align='center'>$room_tel</td>
		<td align='center'>$room_fax</td>
		<td align='center'>
		<a href='{$_SERVER['PHP_SELF']}?act=delete&room_id=$room_id' onClick=\"return confirm('�T�w�R�� $room_name �O���H');\">�R��</a>
		</td>
		";

		$room_data.="
		<tr class=nom_$ti><td align='center'>$room_id</td>
		$room
		</tr>";

		$result->MoveNext();
	}


	//�����\���
	$tool_bar=&make_menu($school_menu_p);

	$main="
	$tool_bar
	<table cellspacing='1' cellpadding='4' class='main_body'>
	<form name ='myform' action='{$_SERVER['PHP_SELF']}' method='post'>
	$button0
	<tr class='title_mbody'>
	<td  nowrap>�s��</td>
	<td  nowrap>�B�ǦW��</td>
	<td >�q��</td>
	<td >�ǯu</td>
	$function_name
	</tr>
	$add_form
	$room_data
	$button1
	</table>
	</form>
	";

	return $main;
}


//�R���@�ӽҫ�
function real_del_room($room_id){
	global $CONN;
	$query = "delete from school_room where room_id ='$room_id'";
	$CONN->Execute($query);
	return ;
}

//���ä@�ӽҫ�
function del_room($room_id){
	global $CONN;
	$sql_update = "update school_room set enable='0' where room_id='$room_id'";
	$CONN->Execute ($sql_update);
	return ;
}

//�s�W�@�ӽҫ�
function add_room($room_name,$room_tel,$room_fax){
	global $CONN;
	$sql_insert = "insert into school_room(room_name,room_tel,room_fax) values ('$room_name','$room_tel','$room_fax')";
	$CONN->Execute($sql_insert);
	return ;
}

//�ק�@�ӽҫ�
function update_room($room_id,$room_name,$room_tel,$room_fax){
	global $CONN;
	$sql_update = "update school_room set room_name='$room_name',room_tel='$room_tel',room_fax='$room_fax' where room_id=$room_id";
	$CONN->Execute($sql_update);
	return ;
}

//�ק�Ҧ��ҫ�
function update_all_room($room_name,$room_tel,$room_fax){
	global $CONN;
	while(list($room_id,$name)=each($room_name)){
		update_room($room_id,$name,$room_tel[$room_id],$room_fax[$room_id]);
	}
	return ;
}
?>


