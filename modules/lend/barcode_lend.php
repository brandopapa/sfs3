<?php

// $Id: barcode_lend.php 6731 2012-03-28 01:50:11Z infodaes $
include "config.php";
sfs_check();

//�q�X����
if(!$remove_sfs3head) head("����n��");

$teacher_sn=$_REQUEST['teacher_sn'];
if($_GET['menu']<>'off') echo print_menu($MENU_P,$linkstr);

$curr_year_seme = sprintf("%03d%d",curr_year(),curr_seme());

$barcode=$_POST['barcode'];
$lend_date=$_POST['lend_date'];
$refund_limit=$_POST['refund_limit'];
$memo=$_POST['memo'];

if($barcode AND $_POST['act']=='�ѪR�B�z'){
	$barcode=explode("\r\n",$barcode);
	$excuted="<BR>�� �e�����X�ѪR�����G�p�U��<BR><BR>";
	$ask_items='';
	foreach($barcode as $value){
		if($value) { $ask_items.="'$value',"; }
	}  
	$ask_items=SUBSTR($ask_items,0,-1);
	
	$sql="SELECT a.*,b.item,DATE_ADD(curdate(),INTERVAL b.days_limit DAY) AS refund_limit FROM equ_request a,equ_equipments b WHERE (a.equ_serial=b.serial) AND (a.equ_serial IN ($ask_items))";
	$res=$CONN->Execute($sql) or user_error("���X�ѪR���ѡI<br>$sql",256);
	
	//�ǳƲ��Ӫ�sql
	$ask_items='';  //���s�ǳ�,�@���᭱�R���Ϊ�
	$sql="INSERT INTO equ_record(year_seme,teacher_sn,ask_date,allowed_date,lend_date,equ_serial,refund_limit,memo,manager_sn) VALUES ";
	while(!$res->EOF) {
		$excuted.='NO.'.($res->CurrentRow( )+1).'�@'.$teacher_array[$res->fields['teacher_sn']]['title']."-".$teacher_array[$res->fields['teacher_sn']]['name'].' '.$res->fields['equ_serial'].' '.$res->fields['item'].' ======> ';
		if($res->fields['manager_sn']==$session_tea_sn)
		{
			$sql.="('$curr_year_seme',".$res->fields['teacher_sn'].",'".$res->fields['ask_date']."','".$res->fields['allowed_date']."','$lend_date','".$res->fields['equ_serial']."','".($refund_limit?$refund_limit:$res->fields['refund_limit'])."','".($memo?$memo:$res->fields['memo'])."',$session_tea_sn),";
			$excuted.='���\<BR>';
			$ask_items.=$res->fields['sn'].',';
		} else {
			$excuted.='�D�޲z�̸g�ު��~,���楢��!!<BR>';			
		}
		$res->MoveNext();
	}
	if($ask_items){   //���Ϧ����\�����@�@�A����sql
		$sql=substr($sql,0,-1);
		$res=$CONN->Execute($sql) or user_error("�g�J�ӽЬ������ѡI<br>$sql",256);

		//�R��request�̭�������
		$ask_items=SUBSTR($ask_items,0,-1);
		$sql="DELETE FROM equ_request WHERE sn IN ($ask_items)";
		$res=$CONN->Execute($sql) or user_error("�w�g�Ыحɥά���,�ߧR���ӽЬ������ѡI<br>$sql",256);
	} else { $excuted="<BR><BR><font color='red'>�� �z�ұ��y�����~~~[�D�z�Ҹg��޲z]�Ϊ�[�w�g����ɥ�] ��</font>"; }

}

$main="<table><form name='my_form' method='post' action='$_SERVER[PHP_SELF]'>
	<tr><td>���ɥΤ���G<input type='text' size=15 value='".date('Y-m-d',time())."' name='lend_date'>
	<BR>���k�ٴ����G<input type='text' size=15 value='$refund_limit' name='refund_limit'><BR><font size=2>(���B�d�ūh�H�U���~��]�w�зǭɴ��m�J)</font>
	<BR>�����O�����G<input type='text' size=20 value='$memo' name='memo'>
	<BR>���б��y���~���X�G<BR><textarea rows='15' name='barcode' cols=33></textarea>
<BR><input type='submit' value='�ѪR�B�z' name='act'><input type='reset' value='�M�ŭ���'></td><td valign='top'>$excuted</td></tr></form></table>";
echo $main;
if(!$remove_sfs3head) foot();

?>