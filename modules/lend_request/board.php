<?php

//$Id: board.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";
sfs_check();
//�q�X����
head("���~�ɥά���");


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


$manager_sn=$_REQUEST['manager_sn'];
$status=$_POST['status'];


if($_POST['BtnSubmit']=='ñ��'){
	$item_selected=$_POST[item_selected];
	if($item_selected)
	{
		$ask_items='';
		foreach($item_selected as $value)
		{
			$ask_items.="$value,";
		}
		$ask_items=SUBSTR($ask_items,0,-1);
		$sql="UPDATE equ_board SET received_sn=CONCAT(if(isnull(received_sn),'',received_sn),'[$session_tea_sn]') WHERE sn IN ($ask_items)";
		$res=$CONN->Execute($sql) or user_error("���iñ�����ѡI<br>$sql",256);
	}
}


//��V������
$linkstr="manager_sn=$manager_sn";
echo print_menu($MENU_P,$linkstr);

	$main="<table>
<form name='myform' method='post' action='$_SERVER[PHP_SELF]'>�T���o����ܭ��w�G<select name='manager_sn' onchange='this.form.submit()'><option></option>";

	//���o�w�ɥζ��ؤ��޲z�H
	$sql_select="SELECT manager_sn,count(*) as amount FROM equ_board WHERE (CURDATE() BETWEEN announce_date AND announce_limit) AND (INSTR(receiver_sn,'[".$session_tea_sn."]')) GROUP BY manager_sn";
	$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while(!$res->EOF) {
		$main.="<option ".($manager_sn==$res->fields['manager_sn']?"selected":"")." value=".$res->fields['manager_sn'].">".$teacher_array[$res->fields['manager_sn']]['title']."-".$teacher_array[$res->fields['manager_sn']]['name']."(".$res->fields['amount'].")</option>";
		$res->MoveNext();
	}
	$main.="</select>�@�@ ���A�G";
	
//�������w
$status_arr=array(0=>'��ñ��',1=>'�wñ��',2=>'����');
foreach($status_arr as $key=>$value){
	$main.="<input type='radio' value='$key' name='status' onclick='this.form.submit()'".($status==$key?' checked':'').">$value ";
}

$showdata.="<table align=center width=".$m_arr['Table_width']."% border='2' cellpadding='5' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1'>
	<tr bgcolor='$Tr_BGColor'>
	<td align='center'><input type='checkbox' name='tag' onclick='javascript:tagall(this.checked);'></td>	
	<td align='center'>�D��</td>
	<td align='center'>���e</td>
	<td align='center'>���i��</td>
	<td align='center'>���i���</td>
	<td align='center'>�ק�</td>	
	</tr>";

//���o�ӽЬ���
$sql_select="SELECT *,IF(INSTR(received_sn,'[".$session_tea_sn."]'),1,0) as received FROM equ_board WHERE (CURDATE() BETWEEN announce_date AND announce_limit) AND (INSTR(receiver_sn,'[".$session_tea_sn."]'))";
if($manager_sn) $sql_select.=" AND manager_sn=$manager_sn";

switch ($status) {
case 0:
    $sql_select.=" AND IF(INSTR(received_sn,'[".$session_tea_sn."]'),1,0)=0";
    break;
case 1:
    $sql_select.=" AND INSTR(received_sn,'[".$session_tea_sn."]')";
    break;
}
$sql_select.=" ORDER BY announce_date";
//echo $sql_select;

$result=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
if($result->recordcount()){
	while(!$result->EOF)
	{
		if($result->fields['received']) { $BGColor=$m_arr['Read_BGColor']; }
		else { $BGColor='#FFFFFF'; }

		$showdata.="<tr bgcolor='$BGColor'>
		<td align='center'>".($result->fields['received']?"":"<input type='checkbox' name='item_selected[]' value=".$result->fields['sn'].">")."</td>	
		<td>".$result->fields['title']."</td>
		<td align='center'><img src='images/detail.gif' alt='".$result->fields['detail']."'></td>
		<td>".$teacher_array[$result->fields['manager_sn']]['title']."-".$teacher_array[$result->fields['manager_sn']]['name']."</td>
		<td align='center'>".$result->fields['announce_date']."</td>
		<td align='center'>".$result->fields['modified']."</td>
		</tr>";
		$result->MoveNext();
	}
}
$showdata.="<tr><td align='center' colspan=6><input type='submit' value='ñ��' name='BtnSubmit'></td></tr></form></table>";
echo $main.$showdata;
foot();
?>