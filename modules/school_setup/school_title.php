<?php

// $Id: school_title.php 7444 2013-08-29 06:15:34Z hami $

// ���J�]�w��
include "school_base_config.php";


// �B�ǥN���W��
$school_room_p = room_kind();

//¾�����O
$title_kind_p = post_kind();

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
	update_all_title($title_name,$title_kind,$title_short_name,$room_id,$title_memo,$rank);
	header("Location: $_SERVER[PHP_SELF]");
}elseif ($act=="�s�W�T�w") {
	add_title($teach_title_id,$title_name,$title_kind,$title_short_name,$room_id,$title_memo,$rank);
	header("Location: {$_SERVER['PHP_SELF']}");
}elseif ($act=="delete") {
	del_title($teach_title_id);
	header("Location: {$_SERVER['PHP_SELF']}");
}elseif ($act=="�ק�Ҧ�") {
	$main=title_setup_form("edit");
}elseif ($act=="�s�W¾��") {
	$main=title_setup_form("add");
}elseif ($act=='del_img') {
	unlink($UPLOAD_PATH."school/title_img/title_".$_GET['teach_title_id']);
	header("Location: {$_SERVER['PHP_SELF']}");
}else{
	$main=title_setup_form();
}

//�q�X����
head("¾�ٸ��");

echo "<script language=\"JavaScript\">
<!-- Begin
function openwindow(url_str){
window.open (url_str,\"�W��ñ�W��\",\"toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no,copyhistory=no,width=600,height=420\");
}


//  End -->
</script>
";
echo $main;
foot();

//�[�ݦU�B�Ǫ��
function title_setup_form($mode=""){
	global $CONN,$school_menu_p,$school_room_p,$title_kind_p,$ol,$SFS_PATH_HTML,$UPLOAD_URL,$filePath;
	
	$ol  = new overlib($SFS_PATH_HTML."include");
	$ol->ol_capicon=$SFS_PATH_HTML."images/componi.gif";
	$view_button="<input type=submit name='act' value='�s���Ҧ�'>";
	$add_button="<input type=submit name='act' value='�s�W¾��'>";
	$modify_button="<input type=submit name='act' value='�ק�Ҧ�'>";
	$modify_submit_button="<input type='submit' name='act' value='�ק�T�w'>";


	if ($mode=="edit"){
		$b0="$view_button $add_button $modify_submit_button";
		$b1="$modify_submit_button";
	}elseif($mode=="add"){
		$b0="$view_button $modify_button";
		$function_name="<td align='center'>�W��ñ�W��</td><td align='center'>�ʧ@</td>";

		//¾�٤U�Կ��
		$title_kind_option=get_title_kind_option();

		//�B�ǤU�Կ��
		$room_name_option=get_room_name_option();

		$add_form="<tr class='title_mbody'>
		<td><input type='text' size='5' name='rank' value='$rank'></td>		
		<td><input type='text' size='15' name='title_name' value='$title_name'></td>
		<td><input type='text' size='10' name='title_short_name' value='$title_short_name'></td>
		<td><select name='title_kind'>$title_kind_option</select></td>
		<td><select name='room_id'>$room_name_option</select></td>
		<td><input type='text' size='20' name='title_memo' value='$title_memo'></td>
		<td colspan='2'><input type='submit' name='act' value='�s�W�T�w'></td>
		</tr>";
	}else{
		$b0="$view_button $add_button $modify_button";
		$overss = $ol->over("�W��ñ�W��,�����������w�]ñ��,�Ҧ��Z��ñ�W��","�W��ñ�W����");
		$function_name="<td align='center'><a $overss >�W��ñ����</a></td><td align='center'>�ʧ@</td>";
	}
	
	$button0="<tr  class='title_sbody2'><td colspan='8'>$b0</td></tr>";
	$button1=(!empty($b1))?"<tr  class='title_sbody2'><td colspan='8'>$b1</td></tr>":$button0;
	



	//Ū�����
	$sql_select = "select teacher_title.*, school_room.room_name from teacher_title LEFT JOIN  school_room  ON teacher_title.room_id = school_room.room_id where teacher_title.enable='1' order by teacher_title.rank";
	$result = $CONN->Execute ($sql_select) or die ($sql_select);
	while (!$result->EOF) {
		$teach_title_id = $result->fields["teach_title_id"];
		$title_name = $result->fields["title_name"];
		$title_kind = $result->fields["title_kind"];
		$title_short_name = $result->fields["title_short_name"];
		$room_name = $result->fields["room_name"];
		$room_id = $result->fields["room_id"];
		$title_memo = $result->fields["title_memo"];
		$rank = $result->fields["rank"];

		if($mode=="edit"){
		
			//¾�٤U�Կ��
			$title_kind_option=get_title_kind_option($title_kind);

			//�B�ǤU�Կ��
			$room_name_option=get_room_name_option($room_id);

			$title="
			<td><input type='text' size='5' name='rank[$teach_title_id]' value='$rank'></td>
			<td><input type='text' size='15' name='title_name[$teach_title_id]' value='$title_name'></td>
			<td><input type='text' size='10' name='title_short_name[$teach_title_id]' value='$title_short_name'></td>
			<td><select name='title_kind[$teach_title_id]'>$title_kind_option</select></td>
			<td><select name='room_id[$teach_title_id]'>$room_name_option</select></td>
			<td><input type='text' size='20' name='title_memo[$teach_title_id]' value='$title_memo'></td>	";
		}else{
			$title_img = '';
			if (is_file($filePath."/title_".$teach_title_id))
				$title_img = "<img src=\"$UPLOAD_URL"."school/title_img/title_"."$teach_title_id\"> <a href=\"$_SERVER[PHP_SELF]?act=del_img&teach_title_id=$teach_title_id\" onClick=\"return confirm('�T�w�R��ñ����')\">�R��ñ����</a>";
			$url_str = $SFS_PATH_HTML.get_store_path()."/school_sign.php?teach_title_id=$teach_title_id";
			$open_window = "<A onclick=\"openwindow('$url_str')\" alt=\"�W��ñ�W��\" style=\"cursor: pointer;\">�W��</a>";
			$title="
			<td align='center'>$rank</td>
			<td align='center'>$title_name</td>
			<td align='center'>$title_short_name</td>
			<td align='center'>$title_kind_p[$title_kind]</td>
			<td align='center'>$room_name</td>
			<td align='center'>$title_memo</td>
			<td align='center'>
			
			$open_window $title_img
			</td>
			<td align='center'>			
			<a href='{$_SERVER['PHP_SELF']}?act=delete&teach_title_id=$teach_title_id' onClick=\"return confirm('�T�w�R�� $title_name �O���H');\">�R��</a>
			</td>";
		}

		$title_data.="<tr bgcolor='white'>$title</tr>\n";

		$result->MoveNext();
	}


	//�����\���
	$tool_bar=&make_menu($school_menu_p);

	$main="
	$tool_bar
	<table cellspacing='1' cellpadding='4' class='main_body'>
	<form name ='myform' action='{$_SERVER['PHP_SELF']}' method='post'>
	$button0
	<tr class=title_mbody>
	<td nowrap>�Ƨ�</td>
	<td nowrap>¾��W��</td>
	<td>²��</td>
	<td>¾�����O</td>
	<td>�Ҧb�B��</td>
	<td>�u�@¾�x</td>
	
	$function_name
	</tr>
	$add_form
	$title_data
	$button1
	</table>
	</form>
	";

	return $main;
}


//�R���@��¾��
function real_del_title($teach_title_id){
	global $CONN;
	$query = "delete from teacher_title where teach_title_id ='$teach_title_id'";
	$CONN->Execute($query);
	return ;
}

//���ä@��¾��
function del_title($teach_title_id){
	global $CONN,$UPLOAD_PATH;
	$sql_update = "update teacher_title set enable='0' where teach_title_id='$teach_title_id'";
	$CONN->Execute ($sql_update);
	//���K��W�ǹ��ɤ]������
	 $path=$UPLOAD_PATH."/school/title_img/title_".$teach_title_id;
	 unlink ($path);
	return ;
}

//�s�W�@��¾��
function add_title($teach_title_id,$title_name,$title_kind,$title_short_name,$room_id,$title_memo,$rank){
	global $CONN;
	$sql_insert = "insert into teacher_title (title_name,title_kind,title_short_name,room_id,title_memo,rank) values ('$title_name',$title_kind,'$title_short_name','$room_id','$title_memo','$rank')";
	$CONN->Execute($sql_insert)or die($sql_insert);
	return ;
}

//�ק�@��¾��
function update_title($teach_title_id,$title_name,$title_kind,$title_short_name,$room_id,$title_memo,$rank){
	global $CONN;
	$sql_update = "update teacher_title set title_name='$title_name',title_kind='$title_kind',title_short_name='$title_short_name',room_id='$room_id',title_memo='$title_memo', rank='$rank' where teach_title_id='$teach_title_id'";
	$CONN->Execute ($sql_update);
	return ;
}

//�ק�Ҧ�¾��
function update_all_title($title_name,$title_kind,$title_short_name,$room_id,$title_memo,$rank){
	global $CONN;
	while(list($id,$name)=each($title_name)){
		update_title($id,$name,$title_kind[$id],$title_short_name[$id],$room_id[$id],$title_memo[$id],$rank[$id]);
	}
	return ;
}

//¾�٤U�Կ��
function get_title_kind_option($title_kind=""){
	global $title_kind_p;

	reset($title_kind_p);
	while(list($tid,$tname) = each($title_kind_p)) {
		$selected=($title_kind==$tid)?"selected":"";
		$option.="<option value='$tid' $selected>$tname</option>\n";
	}

	$main="
	<option value=''>
	$option
	";
	return $main;
}

//�B�ǤU�Կ��
function get_room_name_option($room_id=""){
	global $school_room_p;

	reset($school_room_p);
	while(list($tid,$tname) = each($school_room_p)) {
		$selected=($room_id==$tid)?"selected":"";
		$option.="<option value='$tid' $selected>$tname</option>\n";
	}

	$main="
	<option value=''>
	$option
	";
	return $main;
}
?>


