<?php

// $Id: index.php 5310 2009-01-10 07:57:56Z hami $

/* ���o�]�w�� */
include_once "config.php";
sfs_check();
$sfs3_module_title=get_module_title();

//����ʧ@�P�_
if($_POST[act]=="settbl"){
	$main=&settbl($_POST[table]);
}else{
	$main=&mainForm();
}


//�q�X����
head($sfs3_module_title);
echo $main;
foot();

function &mainForm(){
	global $conID,$mysql_db,$school_menu_p;
	//�����\���
	$tool_bar=&make_menu($school_menu_p);
	
	$result = mysql_listtables($mysql_db);
	$i = 0;
	while ($i < mysql_num_rows ($result)) {
		$tb_names[$i] = mysql_tablename ($result, $i);
		$tbl.="<option value='$tb_names[$i]'>$tb_names[$i]</option>";
		$i++;
	}
	$main="
	$tool_bar
	<form method='post' action='$_SERVER[PHP_SELF]'>
	�п�ܤ@�Ӫ�G
	<select name='table'>
	$tbl
	</select>
	<input type='hidden' name='act' value='settbl'>
	<input type='submit' value='�T�w'>
	</form>
	";
	return $main;
}


function &settbl($table){
	global $conID,$mysql_db,$CONN;

	$i = 0;
	
	$query = "select * from $table";
	$res = mysql_db_query($mysql_db,$query,$conID);	
	while ($i < mysql_num_fields($res)) {
		$name  = mysql_field_name  ($res, $i);
		$len[$name]   = mysql_field_len   ($res, $i);
		$flags[$name] = mysql_field_flags ($res, $i);
		$i++;
	}
	
	$i = 0;
	$sql="SHOW FIELDS FROM $table";
	$result = mysql_db_query($mysql_db,$sql,$conID);	

	while ($all_row = mysql_fetch_array($result)) {
		//�ѪR��Ʈw���A
		$t1=explode(" ",$all_row[Type]);
		$t2=explode("(",$t1[0]);
		$type  = trim($t2[0]);
		
		if($type=="set" or $type=="enum"){
			$default=str_replace(",",";",substr($t2[1],0,-1));
			$default=str_replace("'","",$default);
		}else{
			$default="";
		}
		
		$name = $all_row[Field];
		$row.=form_row($i,$name,$type,$len[$name],$default);
		$i++;
	}
	
	$form_head=form_head();
	$form_foot=form_foot($table);
	$main="
	$form_head
	$row
	<input type='hidden' name='table' value='$table'>
	$form_foot
	";
	return $main;
}


function form_head(){
	global $school_menu_p;
	//�����\���
	$tool_bar=&make_menu($school_menu_p);
	$main="
	$tool_bar
	<form action='generate.php' method='post'>
	<table border='0' cellpadding='3' cellspacing='0' bgcolor='#B3DDE3' class='small'>
	<tr bgcolor='#F3FDC3'>
	<td align='right'>�ϥ�</td>
	<td>���W��</td>
	<td>��줤��W��</td>
	<td>��ƫ��A</td>
	<td>������</td>
	<td>�w�]</td>
	<td>�j�p</td>
	<td>�̤j��</td>
	</tr>
	";
	return $main;
}

function form_foot($table){
	global $conID,$mysql_db,$CONN;
	$option="";
	$query = "select * from $table";
	$res = mysql_db_query($mysql_db,$query,$conID);
	$i = 0;
	while ($i < mysql_num_fields($res)) {
		$type  = strtolower(mysql_field_type  ($res, $i));
		$name  = mysql_field_name  ($res, $i);
		$len   = mysql_field_len   ($res, $i);
		$flags = mysql_field_flags ($res, $i);
		$index_option.="<option value='$name'>$name</option>";
		$i++;
	}
	
	$index_col="<select name='sn_col' size=1>$index_option</select>";
	$main="
	<tr><td bgcolor='#F3FDC3' colspan='8'>��s�B�R�����D�n���ޭȬO�G $index_col</td></tr>
	<tr><td bgcolor='#F3FDC3' colspan='8'>
	�ɦW�G<input type='text' name='module_file_name' value='index.php'>
	<input type='Submit' value='�إߵ{��'>
	</td>
	</tr>
	</table>
	";
	return $main;
}

//�C�@���ƪ��ﶵ
function form_row($i,$name,$type,$len,$default){
	//�ˬd�ӫ��A�O�_�O�n�ϥ� textarea
	$use_textarea=array("tinytext","text","mediumtext","longtext","tinyblob","blob","mediumblob","longblob");
	
	//���o�ۦP��檺���W�٥H�ιw�]��
	$db_data=get_module_maker_col_data($_POST[table],$name);

	//�ھڸ�ƫ��A�ӹw�]���ﶵ����
	$textarea_selected=(in_array($type,$use_textarea))?"selected":"";
	$select_selected=($type=='set')?"selected":"";
	$radio_selected=($type=='enum')?"selected":"";
	
	//�D enum �H�� set ����줣���C�X���e
	if(in_array($type,$use_textarea)){
		// �]�w textarea ��檺���e
		$lencol="<input type='text' size='3' name='size[$name]' value='40' class='small'> �e";
	    $maxlencol="<input type='text' size='3' name='maxlen[$name]' value='5' class='small'> ��";
	}elseif($type=='set'){
		//�p�G�O set ���A��ơA�]�w���i�ƿ�
		$lencol="<input type='hidden' name='is_multiple[$name]' value=1>";
	}elseif($type!='enum' and  $type!='set') {
		
		$llen=($len>50)?50:$len;
	
	    $lencol="<input type='text' size='3' name='size[$name]' value='$llen' class='small'>";
	    $maxlencol="<input type='text' size='3' value='$len' name='maxlen[$name]' class='small'>";
	}
	
	//�B�z��J���H�ιw�]��
	
	//�Y��Ʈw���ȡA���ϥθ�Ʈw���ȧ@���w�]��
	$default_txt=(!empty($db_data[default_txt]))?$db_data[default_txt]:$default;
	
	$input_col="";
	
	//��r�ϰ�
	if(in_array($type,$use_textarea)){
		$input_col="<textarea name='default[$name]' class='small' cols='16' rows='2'>$default_txt</textarea>";	
	}elseif($type=='enum'){
		$input_col="<input type='hidden' name='default[$name]' value='$default_txt'>";
		$df=explode(";",$default_txt);
		foreach($df as $k => $v){
			$input_col.="<input type='radio' name='use_default[$name]' value='$v'>$v";
		}
	}elseif($type=='set'){
		$input_col="<input type='hidden' name='default[$name]' value='$default_txt'>";
		$df=explode(";",$default_txt);
		foreach($df as $k => $v){
			$input_col.="<input type='checkbox' name='use_default[$name][]' value='$v'>$v";
		}
	}else{
		$input_col="<input type='text' size='20' name='default[$name]' value='$default_txt' class='small'>
		<input type='checkbox' name='isfun[$name]' value='1'>���";
	}
	
	//�U�ت��ﶵ
	$op_text="<option value='text'>text ��r��J";
	$op_textarea="<option value='textarea' $textarea_selected>textarea ��r���";
	$op_select="<option value='select' $select_selected>selectbox �U�Կ��";
	$op_radio="<option value='radio' $radio_selected>radio ���s";
	$op_checkbox="<option value='checkbox'>checkbox �ƿ�s";
	$op_password="<option value='password'>password �K�X���";
	$op_file="<option value='file'>file �ɮ����";
	//$op_image="<option value='image'>image �v�����";
	//$op_button="<option value='button'>button �@����s";
	
	
	$op_hidden="<option value='hidden'>hidden �������";
	$op_display="<option value='display'>��ܭ�+�������";
	
	
	//�ھڸ�ƫ��A�w�]�U�ت��ﶵ
	if(in_array($type,$use_textarea)){
		$select_option="$op_textarea";
	}elseif($type=='set'){
		$select_option="
		$op_checkbox
		";
	}elseif($type=='enum'){
		$select_option="
		$op_radio
		$op_checkbox
		";
	}else{
		$select_option="
		$op_text
		$op_password
		$op_file
		";
	}
	
	$main="
	<tr bgcolor='#FFFFFF'>
	<td valign='top' align='center'>
	<input type='Checkbox' name='use[$name]' value='1' checked>
	</td>
	<td valign='top' align='right'>	   
	$name
	<input type='hidden' name='field_name[$name]' value='$name'>
	<input type='hidden' name='field_type[$name]' value='$type'>
	</td>
	<td valign='top'>
	<input type='text' size='10' name='Cname[$name]' value='$db_data[cname]'  class='small'>
	</td>
	<td valign='top'>
	$type
	</td>
	<td valign='top'>
	<select name='input_type[$name]' class='small'>
	$select_option
	$op_select
	$op_hidden
	$op_display
	</select>
	</td>
	<td valign='top'>
	$input_col
	</td>
	<td valign='top'>
	$lencol
	</td>
	<td valign='top'>
	$maxlencol
	</td>
	</tr>";
	return $main;
}


//���o�Y�@�����
function get_module_maker_col_data($table,$name){
	global $CONN;
	$sql_select="select cname,default_txt from module_maker_col where table_name='$table' and ename='$name'";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while(list($cname,$default)=$recordSet->FetchRow()){
		$theData[cname]=$cname;
		$theData[default_txt]=$default;
	}
	return $theData;
}
?>
