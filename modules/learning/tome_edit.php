<?php

// $Id: tome_edit.php 5310 2009-01-10 07:57:56Z hami $

// ���J�]�w��
include "config.php";
$unit_m=$m;
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
	update_all_room($room_name,$room_tel,$room_fax,$room_t);
	header("location:index.php?m=$m ");
}elseif ($act=="�^�W��") {
	header("location: index.php?m=$m");
}elseif ($act=="�s�W�T�w") {
	add_room($room_name,$room_tel,$room_fax,$room_t);
	header("location: index.php?m=$m");
}elseif ($act=="delete") {
	del_room($room_id);
	header("location: {index.php?m=$m");
}elseif ($act=="�ק�") {
	$main=&room_setup_form("edit");
}elseif ($act=="�s�W") {
	$main=&room_setup_form("add");
}else{
	$main=&room_setup_form();
}

//�q�X����
include "header_u.php";
echo $main;


//�[�ݦU�B�Ǫ��
function &room_setup_form($mode=""){
	global $CONN,$unit_m;
	
	$view_button="<input type=submit name='act' value='�^�W��'><input type=submit name='act' value='�s���Ҧ�'>";
	$add_button="<input type=submit name='act' value='�s�W'>";
	$modify_button="<input type=submit name='act' value='�ק�'>";
	$modify_submit_button="<input type='submit' name='act' value='�ק�T�w'>";


	if ($mode=="edit"){
		$b0="$view_button $add_button $modify_submit_button";
		$b1="$modify_submit_button";
	}elseif($mode=="add"){
		$b0="$view_button $modify_button";
		$function_name="<td align='center'>�ʧ@</td>";
		$add_form="<tr class='title_mbody'>
		<td><input type='text' size='10' maxlength='10' name='room_t'></td>
		<td><input type='text' size='20' maxlength='30' name='room_name'></td>
		<td align='center' ><input type='text' size='20' maxlength='15' name='room_tel'></td>
		<td align='center' ><input type='text' size='15'  name='room_fax'></td>

		<td><input type='submit' name='act' value='�s�W�T�w'></td>
		
		</tr>";
	}else{
		$b0="$view_button $add_button $modify_button";
		
	}
	
	$button0="<tr  class='title_sbody2'><td colspan='5'>$b0</td></tr>";
	$button1=(!empty($b1))?"<tr  class='title_sbody2'><td colspan='5'>$b1</td></tr>":$button0;

	//Ū�����
	$sql_select = "select * from unit_tome where unit_m='$unit_m' order by seme,unit_t";
	$result = $CONN->Execute ($sql_select) or die($sql_select) ;
	while (!$result->EOF) {
		$room_id = $result->fields["ut_id"];
		$room_t = $result->fields["unit_t"];
		$room_name = $result->fields["unit_tome"];
		$room_tel = $result->fields["tome_ver"];
		$room_fax = $result->fields["seme"];
		$ti = ($i++%2)+1;


		$room=($mode=="edit")?
		"<td><input type='text' size='30' maxlength='30' name='room_t[$room_id]' value='$room_t'></td>
		<td><input type='text' size='30' maxlength='30' name='room_name[$room_id]' value='$room_name'></td>
		<td align='center'><input type='text' size='15' maxlength='20' name='room_tel[$room_id]' value='$room_tel'></td>
		<td align='center'><input type='text' size='15' maxlength='20' name='room_fax[$room_id]' value='$room_fax'></td>
		":"
		<td>$room_t</td>
		<td>$room_name</td>
		<td align='center'>$room_tel</td>
		<td align='center'>$room_fax</td>
		
		";

		$room_data.="
		<tr class=nom_$ti>
		$room
		</tr>";

		$result->MoveNext();
	}


	//�����\���
	

	$main="
	
	<table border='1' cellPadding='3' cellSpacing='0' class='main_body'>
	<form name ='myform' action='{$_SERVER['PHP_SELF']}' method='post'>
	$button0
	<tr class='title_mbody'>
	<td  nowrap>�N��</td>
	<td  nowrap>�Ǵ�(�U�O)</td>
	<td >����(�Y�n���áA�бN�����M�ŧY�i)</td>
	<td >�Ǵ��Ƨ�</td>
	
	</tr>
	$add_form
	$room_data
	$button1
	</table>
	<input type='hidden' name='m' value= $unit_m >
	</form>
	";

	return $main;
}


//�R���@�ӽҫ�
function real_del_room($room_id){
	global $CONN;
	$query = "delete from unit_tome where ut_id ='$ut_id'";
	$CONN->Execute($query);
	return ;
}

//���ä@�ӽҫ�
function del_room($room_id){
	global $CONN;
	$sql_update = "update unit_tome set enable='0' where ut_id ='$ut_id'";
	$CONN->Execute ($sql_update);
	return ;
}

//�s�W�@�ӽҫ�
function add_room($room_name,$room_tel,$room_fax,$room_t){
	global $CONN,$unit_m;
	$sql_insert = "insert into unit_tome (unit_t,unit_tome,tome_ver,seme,unit_m) values ('$room_t','$room_name','$room_tel','$room_fax','$unit_m')";
	
	$CONN->Execute($sql_insert);
	return ;
}

//�ק�@�ӽҫ�
function update_room($room_id,$room_name,$room_tel,$room_fax,$room_t){
	global $CONN,$unit_m;
	$sql_update = "update unit_tome set unit_t='$room_t',unit_tome='$room_name',tome_ver='$room_tel',seme='$room_fax' where ut_id=$room_id";
	
	 $CONN->Execute($sql_update);
	return ;
}

//�ק�Ҧ��ҫ�
function update_all_room($room_name,$room_tel,$room_fax,$room_t){
	global $CONN,$unit_m;
	while(list($room_id,$name)=each($room_name)){
		update_room($room_id,$name,$room_tel[$room_id],$room_fax[$room_id],$room_t[$room_id]);
	}
	return ;
}
?>


