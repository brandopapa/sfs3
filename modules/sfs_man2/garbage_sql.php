<?php

// $Id: garbage_sql.php 5310 2009-01-10 07:57:56Z hami $

//�]�w�ɸ��J�ˬd
require "config.php";
// �{���ˬd
sfs_check();

//����ʧ@�P�_
if ($_POST[act]=="�٭�") {
	garbage2normall($_POST[tbl_name],$_POST[have_dbname]);
	header("location: $_SERVER[PHP_SELF]");
}elseif($_POST[act]=="�M��"){
	clear_garbage($_POST[tbl_name]);
	header("location: $_SERVER[PHP_SELF]");
}else{
	$main=&main_form();
}


//�q�X����
head("��Ʀ^����");
echo $main;
foot();

//��X�ثe���U�����
function &main_form(){
	global $school_menu_p,$mysql_db,$CONN;
	//�����\���
	$tool_bar=&make_menu($school_menu_p);

	//���o�Ҧ����W��
	$result = mysql_list_tables($mysql_db);

	if (!$result) {
		user_error("�L�k���o��ƪ��ơC",256);
	}
	
	//���o��Ʈw���Ҧ����
	while ($row=mysql_fetch_row($result)) {
		$all_db_tbl[]=$row[0];
	}

	$i=0;
	foreach($all_db_tbl as $db_table_name){
		
		//���Ϊ��W��
		$tbl=explode("_",$db_table_name);
		
		if($tbl[0]=="garbage"){
			
			$tblname=substr($db_table_name,19);
			
			//�O�_��椤�w���Ӫ�s��
			$have_dbname[$db_table_name]=(in_array($tblname,$all_db_tbl))?"��":"�L";
			
			
			$del_time=date("Y-m-d H:i:s�]�P�� w�^",$tbl[1]);
			
			$color=($_GET[vDBname]==$db_table_name)?"#FFFF10":"white";
			
			$recordSet=$CONN->Execute("SELECT count(*) FROM $db_table_name");
			list($num_rows) =$recordSet->FetchRow();

			$option.="<tr bgcolor='$color'><td>
			<input type='checkbox' name='tbl_name[]' id='d$i' value='$db_table_name'>
			<a href='$_SERVER[PHP_SELF]?vDBname=$db_table_name'>$tblname</a></td><td>$num_rows</td><td>$del_time
			</td><td>$have_dbname[$db_table_name]</td></tr>";
			$i++;
		}

	}

	mysql_free_result($result);
	
	if(!empty($_GET[vDBname])){
		$sql_select="select * from $_GET[vDBname]";
		$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
		while($datan=$recordSet->FetchRow()){
		$DBdata="";
			foreach($datan as $k=>$v){
				if(is_int($k))continue;
				$DBdata.="$v ";
			}
			$allDB.="$DBdata\n";
		}
		$DBall="<tr>
		<td valign='top' colspan=4>
		<textarea  cols='30' rows='6' class='small' style='width: 100%'>$allDB</textarea>
		</td></tr>";
	}
	
	if(empty($option))return "$tool_bar<table  width=350 cellspacing='1' cellpadding='4' bgcolor='#2653A7'>
	<tr bgcolor='#ffffff'><td>
	�ثe�^�����L������
	</td></tr></table>";
	
	$main="
	<script>
	<!--
	function sel_all() {
		var i =0;

		while (i < document.dbform.elements.length)  {
			a=document.dbform.elements[i].id.substr(0,1);
			if (a=='d') {
				document.dbform.elements[i].checked=true;
			}
			i++;
		}
	}
	-->
	</script>
	$tool_bar
	<table cellspacing='1' cellpadding='4' bgcolor='#2653A7'>
	<form action='$_SERVER[PHP_SELF]' method='POST' name='dbform'>   
	<tr bgcolor='#C4DCF8'><td>��ƪ�W��</td><td>��Ƽ�</td><td>�����ɶ�</td><td>�s��</td></tr>
	$option
	$DBall
	</table>
	<br>
	<input type='hidden' name='have_dbname' value='$have_dbname'>
	<input type='button' value='����' OnClick='sel_all();'>
	<input type='submit' name='act' value='�٭�'>
	<input type='submit' name='act' value='�M��'>
 	</form>
	";
	return $main;
}

//�٭�
function garbage2normall($tbl_array=array(),$have_dbname=array()){
	global $school_menu_p,$mysql_db,$CONN;
	
	foreach($tbl_array as $tbl_name){
		//��Ӫ��W��
		$new_dbname=substr($tbl_name,19);
		
		//�ݬݲ{�b��Ʈw�ѵL�P�W��ƪ�
		if($have_dbname[$tbl_name]=="��"){
			user_error("��Ʈw���w���ۦP�W�٪���ƪ� $new_dbname �A�ݲ������~���٭�C",256);
		}else{
			chang_dbname($tbl_name,$new_dbname);
		}
	}
}

//�M��
function clear_garbage($tbl_array=array()){
	global $CONN;
	foreach($tbl_array as $tbl_name){
		$str="DROP TABLE IF EXISTS $tbl_name";
		$CONN->Execute($str) or user_error($str, 256);
	}
}
?>
