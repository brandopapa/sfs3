<?php

// $Id: barcode_crash.php 7708 2013-10-23 12:19:00Z smallduh $

include "config.php";
sfs_check();

$barcode=$_POST['barcode'];
$crash_date=$_POST['crash_date'];
$crashed_reason=$_POST['crashed_reason'];


if($_POST['act']=='���~���oCSV�M�U'){
	$sql="SELECT * FROM equ_equipments WHERE manager_sn=$session_tea_sn AND NOT ISNULL(crash_date) ORDER BY crash_date,nature";
	$res=$CONN->Execute($sql) or user_error("������~�������ѡI<br>$sql",256);
	$CSV='"���~�s��","��ڱ��X��","���~�W��","�]���s��","����","��m","�s�y��","����","����","�~��","�ɴ�","�ʶR���","�ʶR���B","�g�P��","�O�T����","���I����","�ϥΦ~��","���o���","���o��]"'."\r\n";
	while(!$res->EOF) {
		$CSV.='"'.$res->fields['serial'].'",';
		$CSV.='"'.$res->fields['barcode'].'",';
		$CSV.='"'.$res->fields['item'].'",';
		$CSV.='"'.$res->fields['asset_no'].'",';
		$CSV.='"'.$res->fields['nature'].'",';
		$CSV.='"'.$res->fields['position'].'",';
		$CSV.='"'.$res->fields['maker'].'",';
		$CSV.='"'.$res->fields['model'].'",';
		$CSV.='"'.$res->fields['healthy'].'",';
		$CSV.='"'.$res->fields['opened'].'",';
		$CSV.='"'.$res->fields['days_limit'].'",';
		$CSV.='"'.$res->fields['sign_date'].'",';
		$CSV.='"'.$res->fields['cost'].'",';
		$CSV.='"'.$res->fields['saler'].'",';
		$CSV.='"'.$res->fields['warranty'].'",';
		$CSV.='"'.$res->fields['importance'].'",';
		$CSV.='"'.$res->fields['usage_years'].'",';
		$CSV.='"'.$res->fields['crash_date'].'",';
		$CSV.='"'.$res->fields['crashed_reason'].'"';
		$CSV.="\r\n";
		$res->MoveNext();
	}
	$filename=$teacher_array[$session_tea_sn]['title']."-".$teacher_array[$session_tea_sn]['name']."�g�ު��~���o�M�U.CSV";
	header("Content-disposition: filename=$filename");
	header("Content-type: application/octetstream ; Charset=Big5");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");
	echo $CSV;
	exit;
}

if($_POST['act']=='�ӥ�'){
	$sql="SELECT *,DATE_ADD(sign_date,INTERVAL usage_years YEAR)as suggest_date FROM equ_equipments WHERE manager_sn=$session_tea_sn AND ISNULL(crash_date) AND DATE_ADD(sign_date,INTERVAL usage_years YEAR)<'$crash_date' ORDER BY nature,sign_date";
	$res=$CONN->Execute($sql) or user_error("������~�������ѡI<br>$sql",256);
	$CSV='"���~�s��","��ڱ��X��","���~�W��","�]���s��","����","��m","�s�y��","����","����","�~��","�ɴ�","�ʶR���","�ʶR���B","�g�P��","�O�T����","���I����","�ϥΦ~��","�����i���o���","���o���","���o��]"'."\r\n";
	while(!$res->EOF) {
		$CSV.='"'.$res->fields['serial'].'",';
		$CSV.='"'.$res->fields['barcode'].'",';
		$CSV.='"'.$res->fields['item'].'",';
		$CSV.='"'.$res->fields['asset_no'].'",';
		$CSV.='"'.$res->fields['nature'].'",';
		$CSV.='"'.$res->fields['position'].'",';
		$CSV.='"'.$res->fields['maker'].'",';
		$CSV.='"'.$res->fields['model'].'",';
		$CSV.='"'.$res->fields['healthy'].'",';
		$CSV.='"'.$res->fields['opened'].'",';
		$CSV.='"'.$res->fields['days_limit'].'",';
		$CSV.='"'.$res->fields['sign_date'].'",';
		$CSV.='"'.$res->fields['cost'].'",';
		$CSV.='"'.$res->fields['saler'].'",';
		$CSV.='"'.$res->fields['warranty'].'",';
		$CSV.='"'.$res->fields['importance'].'",';
		$CSV.='"'.$res->fields['usage_years'].'",';
		$CSV.='"'.$res->fields['suggest_date'].'",';
		$CSV.='"'.$res->fields['crash_date'].'",';
		$CSV.='"'.$res->fields['crashed_reason'].'"';
		$CSV.="\r\n";
		$res->MoveNext();
	}
	$filename=$teacher_array[$session_tea_sn]['title']."-".$teacher_array[$session_tea_sn]['name']."�g�ު��~��ĳ���o�ӥ�.CSV";
	header("Content-disposition: filename=$filename");
	header("Content-type: application/octetstream ; Charset=Big5");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");
	echo $CSV;
	exit;
}

if($_POST['act']=='��ĳ�M��'){
	$sql="SELECT serial FROM equ_equipments WHERE manager_sn=$session_tea_sn AND ISNULL(crash_date) AND DATE_ADD(sign_date,INTERVAL usage_years YEAR)<'$crash_date' ORDER BY nature,sign_date";
	$res=$CONN->Execute($sql) or user_error("������~�������ѡI<br>$sql",256);
	$suggestion='';
	while(!$res->EOF) {
		$suggestion.=$res->fields['serial']."\r\n";
		$res->MoveNext();
	}
}

//�q�X����
if(!$remove_sfs3head) head("���~���o���X�n��");
if($_GET['menu']<>'off') echo print_menu($MENU_P,$linkstr);
if($barcode AND $_POST['act']=='�ѪR�B�z'){
	$barcode=explode("\r\n",$barcode);
	$executed="<BR>�� �e�����X�ѪR�����G�p�U��<BR><BR>";
	$ask_items='';
	foreach($barcode as $value){
		if($value) { $ask_items.="$value,"; }
	}  
	$ask_items=SUBSTR($ask_items,0,-1);
	$sql="UPDATE equ_equipments SET opened='N',crash_date='$crash_date',crashed_reason='$crashed_reason',crash_teacher_sn=$session_tea_sn";
	$sql.=" WHERE manager_sn=$session_tea_sn AND serial IN ('$ask_items') AND ISNULL(crash_date)";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
	$executed.='�� '.date('Y/m/d h:i:s')." �w�N�U�C�s�����~���o[ $ask_items ]";
}
if(!$crash_date) $crash_date=date('Y-m-d',time());
$main="<table><form name='my_form' method='post' action='$_SERVER[PHP_SELF]'>
	<tr><td>�����o����G<input type='text' size=12 value='$crash_date' name='crash_date'><input type='submit' value='��ĳ�M��' name='act'><input type='submit' value='�ӥ�' name='act'>
	<BR>�����o�̾ڡG<input type='text' size=29 value='$crashed_reason' name='crashed_reason'>
	<BR>���б��y���o���~�s�����X�G<BR><textarea rows='20' name='barcode' cols=42>$suggestion</textarea>
	<BR><input type='submit' value='�ѪR�B�z' name='act'><input type='reset' value='�M�ŭ���'><input type='submit' value='���~���oCSV�M�U' name='act'></td>
	<td valign='top'>$executed</td></tr></form></table><br>";
echo $main;
if(!$remove_sfs3head) foot();
?>