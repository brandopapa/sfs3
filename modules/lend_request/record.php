<?php

//$Id: record.php 6732 2012-03-28 01:54:06Z infodaes $
include "config.php";
sfs_check();
//�q�X����
head("���~�ɥά���");

$manager_sn=$_REQUEST['manager_sn'];
$status=$_POST['status'];


//��V������
$linkstr="manager_sn=$manager_sn";
echo print_menu($MENU_P,$linkstr);

	$main="<table>
<form name='form_item' method='post' action='$_SERVER[PHP_SELF]'>�ɥΨӷ���ܭ��w�G<select name='manager_sn' onchange='this.form.submit()'><option></option>";

	//���o�w�ɥζ��ؤ��޲z�H
	$sql_select="SELECT manager_sn,count(*) as amount FROM equ_record WHERE teacher_sn=$session_tea_sn GROUP BY manager_sn";
	$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while(!$res->EOF) {
		$main.="<option ".($manager_sn==$res->fields['manager_sn']?"selected":"")." value=".$res->fields['manager_sn'].">".$teacher_array[$res->fields['manager_sn']]['title']."-".$teacher_array[$res->fields['manager_sn']]['name']."(".$res->fields['amount'].")</option>";
		$res->MoveNext();
	}
	$main.="</select>�@�@ ���A�G";
	
//�������w
$status_arr=array(0=>'����',1=>'�w�k��',2=>'���k��',3=>'�O�����k');
foreach($status_arr as $key=>$value){
	$main.="<input type='radio' value='$key' name='status' onclick='this.form.submit()'".($status==$key?' checked':'').">$value ";
}
	
$showdata.="<table align=center width=".$m_arr['Table_width']."% border='2' cellpadding='5' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1'>
	<tr bgcolor='$Tr_BGColor'>
		<td align='center'>�ӽФ��</td>
		<td align='center'>�ӽй�H</td>
		<td align='center'>���~�s��</td>
		<td align='center'>���~�W��</td>
		<td align='center'>�֥ܤ��</td>
		<td align='center'>�ɥX���</td>
		<td align='center'>�ɥδ���</td>
		<td align='center'>�k�٤��</td>
		<td align='center'>�k�ٵn��</td>
		<td align='center'>���O����</td>
	</tr>";

//���o�ӽЬ���
$sql_select="SELECT a.*,TO_DAYS(CURDATE())-TO_DAYS(a.refund_limit) as leftdays,b.item,b.barcode FROM equ_record a,equ_equipments b WHERE a.teacher_sn=$session_tea_sn AND a.equ_serial=b.serial";
if($manager_sn) $sql_select.=" AND a.manager_sn=$manager_sn";

switch ($status) {
case 1:
    $sql_select.=" AND NOT ISNULL(a.refund_date)";
    break;
case 2:
    $sql_select.=" AND ISNULL(a.refund_date)";
    break;
case 3:
    $sql_select.=" AND ISNULL(a.refund_date) AND a.refund_limit<CURDATE()";
    break;
}
//$sql_select.=" ORDER BY ask_date";
$result=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
if($result->recordcount()){
	while(!$result->EOF)
	{
		if($result->fields['refund_date']) { $BGColor=$m_arr['Returned_BGColor']; }
		else {
			if($result->fields['leftdays']>0)  { $BGColor=$m_arr['OverTime_BGColor']; }
				else { $BGColor='#FFFFFF'; }
		} 
		$lend_pic="../../data/lend/pics/".$result->fields['barcode'].".jpg";
		$pic_show=$result->fields['barcode']?"onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#fccfaa';\" onMouseOut=\"this.style.backgroundColor='$BGColor';\" Onclick='receiver=window.open(\"$lend_pic\",\"���~�Ϥ�\",\"status=no,toolbar=no,location=no,menubar=no,width=$Pic_Width,height=$Pic_Height\");'":"";
		
		$showdata.="<tr bgcolor='$BGColor'><td align='center'>".$result->fields['ask_date']."</td>
			<td>".$teacher_array[$result->fields['manager_sn']]['title']."-".$teacher_array[$result->fields['manager_sn']]['name']."</td>
			<td align='center' $pic_show>".$result->fields['equ_serial']."</td>
			<td $pic_show>".$result->fields['item']."</td>
			<td align='center'>".$result->fields['allowed_date']."</td>
			<td align='center'>".$result->fields['lend_date']."</td>
			<td align='center'>".$result->fields['refund_limit']."</td>
			<td align='center'>".$result->fields['refund_date']."</td>
			<td align='center'>".$teacher_array[$result->fields['receiver']]['name']."</td>
			<td>".$result->fields['memo']."</td></tr>";
		$result->MoveNext();
	}
}
$showdata.="</form></table>";
echo $main.$showdata;
foot();
?>