<?php

// $Id: sfs_core_log.php 6864 2012-08-27 05:32:39Z hsiao $

function sfs_log($log_table,$update_kind,$chang_id='') {
	global $CONN,$REMOTE_ADDR;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	if ($_SESSION['session_log_id'] !='' and  $log_table!='') {
		$sql_insert = "insert into sfs_log (log_user,log_table,log_ip,update_kind,chang_id) values ('{$_SESSION['session_log_id']}','$log_table','$REMOTE_ADDR','$update_kind','$chang_id')";
		//echo $sql_insert;
		$CONN->Execute($sql_insert) or trigger_error("log�s�J���ѡG $sql_insert", E_USER_ERROR);
	}
	return;
}


//���²���A�åi�x�s�j�q���廡����log����
function add_log($log,$mark) {
	global $CONN;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	if ($_SESSION['session_log_id'] !='') {
		$log=addslashes($log);
		$sql_insert = "insert into sfs3_log (log,mark,id,time) values ('$log','$mark','{$_SESSION['session_log_id']}',now())";
		$CONN->Execute($sql_insert) or trigger_error("log�s�J���ѡG $sql_insert", E_USER_ERROR);
	}
	$n=mysql_insert_id();
	return $n;
}

//�[��sfs3_log���������
function &view_log($mark="",$log_sn="",$show_back=true) {
	global $CONN;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	if ($_SESSION['session_log_id'] !='') {
		$log=addslashes($log);
		$where=(empty($log_sn))?"mark='$mark'":"log_sn='$log_sn'";

		$sql_select = "select log,id,time from sfs3_log where $where";
		 $recordSet=$CONN->Execute($sql_select) or trigger_error("log�s�J���ѡG $sql_select", E_USER_ERROR);
		while(list($log,$id,$time) = $recordSet->FetchRow()){
			$main.="<table  cellspacing='1' cellpadding='8' align='center' bgcolor='#8080FF'>
			<tr bgcolor='#D9CEF9'><td class='small' >
			�� $time �� $id �s�J�������p�U�G
			</td></tr>
			<tr bgcolor='#FFFFFF'><td class='small' style='line-height: 160%;'>$log</td></tr></table>";
		}
		if($show_back){
			$main.="<div align='right'><a href='javascript:history.back(-1);'>�^�W�@��</a></div>";
		}
	}
	return $main;;
}

//�g�J�Ӹ�s���O��
function pipa_log($comment) {
	global $CONN;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	if ($_SESSION['session_tea_sn'] !='') {
		$remote_ip=getip();
		$teacher_name=addslashes($_SESSION['session_tea_name']);
		$sql="INSERT INTO pipa SET teacher_sn={$_SESSION['session_tea_sn']},teacher_name='$teacher_name',ip='$remote_ip',script_name='{$_SERVER['SCRIPT_NAME']}',comment='$comment';";
		$rs=$CONN->Execute($sql) or trigger_error("�s�Jpipa_log���ѡG $sql", E_USER_ERROR);		
	}
	return $rs;
}

?>
