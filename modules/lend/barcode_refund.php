<?php

// $Id: barcode_refund.php 6207 2010-10-05 04:46:46Z infodaes $

include "config.php";
sfs_check();
//�q�X����
if(!$remove_sfs3head) head("�k�ٵn��");
$teacher_sn=$_REQUEST['teacher_sn'];
if($_GET['menu']<>'off') echo print_menu($MENU_P,$linkstr);

$barcode=$_POST['barcode'];
$return_date=$_POST['return_date'];
$memo=$_POST['memo'];

if($barcode AND $_POST['act']=='�ѪR�B�z'){
	$barcode=explode("\r\n",$barcode);
	$excuted="<BR>�� �e�����X�ѪR�����G�p�U��<BR><BR>";
	//�ˬd�ɥΪ̬O�_�b¾
	if($barcode[0])
	
	$ask_items='';
	foreach($barcode as $value){
		if($value){
			//���ˬd�O�_�ܬ��X�y�����@(�ɥΪ̥N���P���~�O�_�|���k��?)
			$sql="SELECT a.sn,a.equ_serial,a.manager_sn,b.item,b.manager_sn AS new_manager_sn FROM equ_record a,equ_equipments b";
			$sql.=" WHERE a.equ_serial='$value' AND ISNULL(a.refund_date) AND a.equ_serial=b.serial";
			$res=$CONN->Execute($sql);
			$excuted.="�@�� ($value) ===>";
			if($res->recordcount()) {
				if($res->fields['manager_sn']==$session_tea_sn or $res->fields['new_manager_sn']==$session_tea_sn) {
					$ask_items.=$res->fields['sn'].',';
					$excuted.="<font color='blue'>".$res->fields['item']."===> ���\!</font><BR>";
				} else { $excuted.=$res->fields['item']."===> �z�ëD�����~�޲z��, ����!!<BR>"; }
			} else { $excuted.="[�L�����~]�Ϊ�[�w�g�k�٤F]~~ ����!!<BR>"; }
		}
	}
	if($ask_items) {
		$ask_items=SUBSTR($ask_items,0,-1);
		$sql="UPDATE equ_record SET refund_date='$return_date',receiver_sn=$session_tea_sn WHERE sn IN ($ask_items)";
		//echo $sql."<BR><BR><BR>";
		$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$excuted",256);
	}
}

$main="<table><form name='my_form' method='post' action='$_SERVER[PHP_SELF]'>
	<tr><td>���k�٤���G<input type='text' size=10 value='".date('Y-m-d',time())."' name='return_date'>
	<BR>�����O�����G<input type='text' size=10 value='$memo' name='memo'>
	<BR>���б��y���~���X�G<BR><textarea rows='20' name='barcode' cols=30></textarea>
<BR><input type='submit' value='�ѪR�B�z' name='act'><input type='reset' value='�M�ŭ���'></td><td valign='top'>$excuted</td></tr></form></table>";
echo $main;
if(!$remove_sfs3head) foot();

?>