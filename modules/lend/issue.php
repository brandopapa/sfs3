<?php

// $Id: issue.php 6207 2010-10-05 04:46:46Z infodaes $
include "config.php";
sfs_check();

//�q�X����
if(!$remove_sfs3head) head("�t�o�@�~");

if($_GET['menu']<>'off') echo print_menu($MENU_P,$linkstr);

$curr_year_seme = sprintf("%03d%d",curr_year(),curr_seme());

$barcode=$_POST['barcode'];
$lend_date=$_POST['lend_date'];
$ask_date=$_POST['lend_date'];
$allowed_date=$_POST['lend_date'];
$refund_limit=$_POST['refund_limit'];
$memo=$_POST['memo'];

if($barcode and $_POST['act']=='�ѪR�B�z'){
	$barcode=explode("\r\n",$barcode);
	$excuted="<BR>�� �e���t�o�ɥΪ��~���G�p�U��<BR><BR>";
	//�ˬd�O�_�b¾
	$teach_id=array_shift($barcode);
	if($teach_id and array_key_exists($teach_id,$teach_id_array)){
		$ask_items='';
		$teacher_sn=$teach_id_array[$teach_id];
		$teach_name=$teacher_array[$teacher_sn]['title'].'-'.$teacher_array[$teacher_sn]['name'];
		$excuted.="���ɥΪ̡G$teach_id $teach_name<BR><BR>";
		$excuted.='�����~�s���M��G<BR>';
		$sql="INSERT INTO equ_record(year_seme,teacher_sn,ask_date,allowed_date,lend_date,equ_serial,refund_limit,memo,manager_sn) VALUES ";
		foreach($barcode as $value){
			if($value) {
				//�ˬd�޲z���~�O�_�s�b
				$check_sql="SELECT item,days_limit FROM equ_equipments WHERE manager_sn=$session_tea_sn AND serial='$value'";
				$res=$CONN->Execute($check_sql) or user_error("�ˬd�޲z���~�O�_�s�b���ѡI<br>$check_sql",256);
				if($res->recordcount()){
					$ask_items.="'$value',";
					$excuted.="�@[$value]".$res->fields['item']."~~���\!!<BR>";
					$refund_date="CURDATE()+".$res->fields['days_limit'];
					$sql.="('$curr_year_seme',$teacher_sn,'$ask_date','$allowed_date','$lend_date','$value',".($refund_limit?"'".$refund_limit."'":$refund_date).",'$memo',$session_tea_sn),";
				} else { $excuted.="�@<font color='red'>$value ->[�L�����~]��[�D�g�ު��~]~~����</font><BR>"; }
			}
		}
		
		if($ask_items){   //���Ϧ����\�����@�@�A����sql
			$sql=substr($sql,0,-1);
			$res=$CONN->Execute($sql) or user_error("�g�J�ɥά������ѡI<br>$sql",256);

			//�R��request�̭�������
			$ask_items=SUBSTR($ask_items,0,-1);
			$sql="DELETE FROM equ_request WHERE equ_serial IN ($ask_items)";
			$res=$CONN->Execute($sql) or user_error("�w�g�Ыحɥά���,�ߧR���ӽЬ������ѡI<br>$sql",256);
		} 
		//else { $excuted.="<BR><BR><font color='red'>������J�ɥΪ��~�s��</font>"; }
	} else { $excuted.="<font color='red'>���䤣��ɥΪ̸��~~�ӭ��i��[���b¾]�Ϊ�[���ǰȨt�εn�J�b���F]</font>"; }
}

$main="<table><form name='my_form' method='post' action='$_SERVER[PHP_SELF]'>
	<tr>
	<td>�����~�s��<font size=2 color='red'> (�Ĥ@�C���ɥΪ̥N��)</font>�G<BR><textarea rows='15' name='barcode' cols=33></textarea>
	<BR>���t�o����G<input type='text' size=10 value='".date('Y-m-d',time())."' name='lend_date'>
	<BR>���k�ٴ����G<input type='text' size=10 value='$refund_limit' name='refund_limit'><BR><font size=2>(���B�d�ūh�H�U���~��]�w�зǭɴ��m�J)</font>
	<BR>�����O�����G<input type='text' size=20 value='$memo' name='memo'>
	<BR><BR><input type='submit' value='�ѪR�B�z' name='act'> <input type='reset' value='�M�ŭ���'></td>
	<td valign='top'>$excuted</td>
	</tr>
	</form></table>";
echo $main;
if(!$remove_sfs3head) foot();

?>