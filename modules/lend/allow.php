<?php

//$Id: allow.php 6731 2012-03-28 01:50:11Z infodaes $
include "config.php";
sfs_check();

//echo "<PRE>";
//print_r($teacher_array[1]);
//echo "</PRE>";

$teacher_sn=$_REQUEST['teacher_sn'];

if($_POST['BtnSubmit']=='�L�ɥγ�' and $_POST[item_selected]){
	
	$item_selected=$_POST[item_selected];
	$ask_items='';
	foreach($item_selected as $value)
	{
		$ask_items.="$value,";
	}
	$ask_items=SUBSTR($ask_items,0,-1);
	$sql="SELECT a.*,b.item,b.serial FROM equ_request a,equ_equipments b WHERE (a.equ_serial=b.sn) AND (a.sn IN ($ask_items))";
	$res=$CONN->Execute($sql) or user_error("�M���ӽЬ������ѡI<br>$sql",256);
	
	$showdata="<font face='�з���'><CENTER><H2>$school_area".$school_short_name."���~�ɥγ�</H2>";
	
	$showdata.=$teacher_sn?"�ɥΪ̡G".$teacher_array[$teacher_sn]['title']."-".$teacher_array[$teacher_sn]['name']:"";
	$showdata.="�@�@�ɥΤ���G".date("Y/m/d D")."�@�@�޲z�̡G".$teacher_array[$session_tea_sn]['title']."-".$teacher_array[$session_tea_sn]['name'];
	$showdata.="<font face='�s�ө���'><table align=center width=".$m_arr['Table_width']."% border='2' cellpadding='5' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1'>
		<tr bgcolor='$Tr_BGColor'>
		<td align='center'>NO.</td>
		<td align='center'>�ɥΪ��~</td>".($teacher_sn?"":"<td align='center'>�ɥXñ�W</td>")."
		<td align='center'>�k�٤��</td>
		<td align='center'>�k�ٸg��</td>
		<td align='center'>�@�~���X</td>
		</tr>";	
	while(!$res->EOF)
	{
		$showdata.="<tr><td align='center'>".($res->CurrentRow()+1)."</td>
		<td align='center'>".$res->fields['serial']."<BR>".$res->fields['item']."</td>
		".($teacher_sn?"":"<td></td>")."
		<td align='center'>�@�~�@��@��</td>
		<td></td><td align='center'><font face='".$m_arr['Barcode_Font']."'>*".$res->fields['equ_serial']."*</font></td></tr>";			
		$res->MoveNext();
	}
	$showdata.="</td></tr></table><BR><BR>".$m_arr['Footer'];
	
	//$filename=$teacher_array[$teacher_sn]['title']."-".$teacher_array[$teacher_sn]['name']."���~�ɥγ�.CSV";
	//header("Content-disposition: filename=$filename");
	//header("Content-type: application/octetstream ; Charset=Big5");
	//header("Pragma: no-cache");
	//header("Expires: 0");

	$go="<HTML><HEAD><TITLE>�C�L�ɥγ�</TITLE></HEAD>
		<BODY onLoad='printPage()' onclick='window.location.href=\"$_SERVER[PHP_SELF]\"'>

		<SCRIPT LANGUAGE='JavaScript'>
		function printPage() {
		window.print();
		}
		</SCRIPT>
		$showdata;
		</BODY>
		</HTML>";
	echo $go;
	exit;
}

//�q�X����
if(!$remove_sfs3head) head("�ɥΥӽЮּ�");

echo <<<HERE
<script>
function tagall(status) {
  var i =0;

  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].name=='item_selected[]') {
      document.myform.elements[i].checked=status;
    }
    i++;
  }
}
</script>
HERE;

//��V������
$linkstr="teacher_sn=$teacher_sn";
if($_GET['menu']<>'off') echo print_menu($MENU_P,$linkstr);
$memo=$_POST['memo'];


if($_POST['BtnSubmit']=='����ǳ�' and $_POST[item_selected]){
	$item_selected=$_POST[item_selected];
	if($item_selected)
	{
		//print_r($item_selected);
		//�֥i�i�{����
		$ask_items='';
		foreach($item_selected as $value)
		{
			$ask_items.="$value,";
		}
		
		$ask_items=SUBSTR($ask_items,0,-1);
		$sql="UPDATE equ_request SET status='".$_POST['BtnSubmit']."',memo='$memo',allowed_date=NOW() where sn IN ($ask_items)";
		$res=$CONN->Execute($sql) or user_error("�g�J�ӽЬ������ѡI<br>$sql",256);
	}
}

if($_POST['BtnSubmit']=='�L�k�X��' and $_POST[item_selected]){
	$item_selected=$_POST[item_selected];
	if($item_selected)
	{
		//print_r($item_selected);
		//�i��ڵ��~�ɭ�]�ά���
		$ask_items='';
		foreach($item_selected as $value)
		{
			$ask_items.="$value,";
		}
		
		$ask_items=SUBSTR($ask_items,0,-1);
		$sql="UPDATE equ_request SET status='".$_POST['BtnSubmit']."',memo='$memo' where sn IN ($ask_items)";
		$res=$CONN->Execute($sql) or user_error("�g�J�ӽЬ������ѡI<br>$sql",256);
	}
}

if($_POST['BtnSubmit']=='�M������' and $_POST[item_selected]){
	$item_selected=$_POST[item_selected];
	if($item_selected)
	{
		//print_r($item_selected);
		//�i��d�߬�����ӽЬ���
		$ask_items='';
		foreach($item_selected as $value)
		{
			$ask_items.="$value,";
		}
		$ask_items=SUBSTR($ask_items,0,-1);
		$sql="DELETE FROM equ_request WHERE sn IN ($ask_items)";
	
		$res=$CONN->Execute($sql) or user_error("�M���ӽЬ������ѡI<br>$sql",256);
	}
}

if($_POST['BtnSubmit']=='�C�U����' and $_POST[item_selected]){
	//
	$curr_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
	$refund_limit=$_POST['refund_limit'];
	$item_selected=$_POST[item_selected];
	$ask_items='';
	foreach($item_selected as $value)
	{
		$ask_items.="$value,";
	}
	$ask_items=SUBSTR($ask_items,0,-1);
	$sql="SELECT a.*,b.item,b.serial,DATE_ADD(curdate(),INTERVAL b.days_limit DAY) AS refund_limit FROM equ_request a,equ_equipments b WHERE (a.equ_serial=b.sn) AND (a.sn IN ($ask_items))";
	$res=$CONN->Execute($sql) or user_error("'�C�U���楢�ѡI<br>$sql",256);
	
	//�ǳƲ��Ӫ�sql
	$sql="INSERT INTO equ_record(year_seme,teacher_sn,ask_date,allowed_date,lend_date,equ_serial,refund_limit,memo,manager_sn) VALUES ";
	while(!$res->EOF) {
		$sql.="('$curr_year_seme',".$res->fields['teacher_sn'].",'".$res->fields['ask_date']."','".$res->fields['allowed_date']."',NOW(),'".$res->fields['serial']."','".$res->fields['refund_limit']."','".$res->fields['memo']."',$session_tea_sn),";
		$res->MoveNext();
	}
	$sql=substr($sql,0,-1);
	$res=$CONN->Execute($sql) or user_error("�g�J�ӽЬ������ѡI<br>$sql",256);

	//�R��request�̭�������
	$sql="DELETE FROM equ_request WHERE sn IN ($ask_items)";
	$res=$CONN->Execute($sql) or user_error("�w�g�Ыحɥά���,�ߧR���ӽЬ������ѡI<br>$sql",256);
}


	$main="<table>
<form name='myform' method='post' action='$_SERVER[PHP_SELF]'>���Ъ��ɥΪ���ܭ��w�G<select name='teacher_sn' onchange='this.form.submit()'><option></option>";

	//���o�w�ӽж��ؤ��޲z�H
	$sql_select="SELECT teacher_sn,count(*) as amount FROM equ_request WHERE manager_sn=$session_tea_sn GROUP BY teacher_sn";
	$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while(!$res->EOF) {
		$main.="<option ".($teacher_sn==$res->fields['teacher_sn']?"selected":"")." value=".$res->fields['teacher_sn'].">".$teacher_array[$res->fields['teacher_sn']]['title']."-".$teacher_array[$res->fields['teacher_sn']]['name']."(".$res->fields['amount'].")</option>";
		$res->MoveNext();
	}
	$main.="</select>";
	
$showdata.="<table align=center width=".$m_arr['Table_width']."% border='2' cellpadding='5' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1'>
	<tr bgcolor='$Tr_BGColor'>
		<td align='center'>�ӽФ��</td>
		<td align='center'>�ӽЪ�</td>
		<td align='center'>���~�s��</td>
		<td align='center'><input type='checkbox' name='tag' onclick='javascript:tagall(this.checked);'>���~�W��</td>
		<td align='center'>��m</td>
		<td align='center'>���A</td>
		<td align='center'>���O����</td>
		<td align='center'>�֥ܤ��</td>
		
	</tr>";	

//���o�ӽЬ���
$sql_select="SELECT a.*,b.item,b.position,b.serial FROM equ_request a,equ_equipments b WHERE a.equ_serial=b.sn AND a.manager_sn=$session_tea_sn";
if($manager_sn) $sql_select.=" AND a.teacher_sn=$teacher_sn";
$sql_select.=" ORDER BY teacher_sn,ask_date";

$result=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
if($result->recordcount()){
	while(!$result->EOF)
	{
		$showdata.="<tr align='center'><td>".$result->fields['ask_date']."</td>
			<td>".$teacher_array[$result->fields['teacher_sn']]['title']."-".$teacher_array[$result->fields['teacher_sn']]['name']."</td>
			<td>".$result->fields['serial']."</td>
			<td><input type='checkbox' name='item_selected[]' value=".$result->fields['sn'].">".$result->fields['item']."</td>
			<td>".$result->fields['position']."</td>
			<td>".$result->fields['status']."</td>
			<td>".$result->fields['memo']."</td>
			<td>".$result->fields['allowed_date']."</td></tr>";
		$result->MoveNext();
	}
	$showdata.="<tr bgcolor='$Tr_BGColor'><td align=center><input type='submit' value='�M������' name='BtnSubmit' onclick='return confirm(\"�u���n�M��?\")'".($m_arr['User_Removable']?'':' disabled')."></td>";
	$showdata.="<td colspan=4 align='center'>���O�G<input type='text' name='memo' size='10' value='$memo'>
		 <input type='submit' value='����ǳ�' name='BtnSubmit' onclick='return confirm(\"�u���n�֥i?\")'> <input type='submit' value='�L�k�X��' name='BtnSubmit' onclick='return confirm(\"�T�w�����X��?\")'></td>";
	$showdata.="<td align='center'>
		<input type='submit' name='BtnSubmit' value='�L�ɥγ�' this.form.submit();\"></td>
		<td colspan=2>�k���G<input type='text' size=10 value='' name='refund_limit'><input type='submit' value='�C�U����' name='BtnSubmit' onclick='return confirm(\"�u���n�C�U����(���ͭɥά�����R���ӽЬ���)?\")'></td>";
	$showdata.="</tr>";
}

$showdata.="</form></table>";
echo $main.$showdata;
if(!$remove_sfs3head) foot();
?>