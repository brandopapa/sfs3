<?php

//$Id: request.php 6732 2012-03-28 01:54:06Z infodaes $
include "config.php";
sfs_check();
//�q�X����
head("���~�ɥΥӽ�");

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

$manager_sn=$_REQUEST['manager_sn'];
$linkstr="manager_sn=$manager_sn";
echo print_menu($MENU_P,$linkstr);

if($_POST['BtnSubmit']=='�M���X�ɴ���'){
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



	$main="<table><form name='myform' method='post' action='$_SERVER[PHP_SELF]'>���ЭɥβM����ܭ��w�G<select name='manager_sn' onchange='this.form.submit()'><option></option>";

	//���o�w�ӽж��ؤ��޲z�H
	$sql_select="SELECT manager_sn,count(*) as amount FROM equ_request WHERE teacher_sn=$session_tea_sn GROUP BY manager_sn";
	$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while(!$res->EOF) {
		$main.="<option ".($manager_sn==$res->fields['manager_sn']?"selected":"")." value=".$res->fields['manager_sn'].">".$teacher_array[$res->fields['manager_sn']]['title']."-".$teacher_array[$res->fields['manager_sn']]['name']."(".$res->fields['amount'].")</option>";
		$res->MoveNext();
	}
	$main.="</select>";
	
$showdata.="<table align=center width=".$m_arr['Table_width']."% border='2' cellpadding='5' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1'>
	<tr bgcolor='$Tr_BGColor'>
		<td align='center'>�ӽФ��</td>
		<td align='center'>�ӽй�H</td>
		<td align='center'>���~�s��</td>
		<td align='center'><input type='checkbox' name='tag' onclick='javascript:tagall(this.checked);'>���~�W��</td>
		<td align='center'>���A</td>
		<td align='center'>�֥ܤ��</td>
		<td align='center'>���֥i��]</td>
	</tr>";	

//���o�ӽЬ���
$sql_select="SELECT a.*,b.serial,b.item,b.barcode FROM equ_request a inner join equ_equipments b ON a.equ_serial=b.sn WHERE a.manager_sn=a.manager_sn";
if($manager_sn) $sql_select.=" AND a.manager_sn=$manager_sn";
$sql_select.=" ORDER BY ask_date";
$result=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
if($result->recordcount()){
	while(!$result->EOF)
	{
		$lend_pic="../../data/lend/pics/".$result->fields['barcode'].".jpg";
		$pic_show=$result->fields['barcode']?"onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#fccfaa';\" onMouseOut=\"this.style.backgroundColor='$BGColor';\" Onclick='receiver=window.open(\"$lend_pic\",\"���~�Ϥ�\",\"status=no,toolbar=no,location=no,menubar=no,width=$Pic_Width,height=$Pic_Height\");'":"";
		
		$showdata.="<tr><td align='center'>".$result->fields['ask_date']."</td>
			<td align='center'>".$teacher_array[$result->fields['manager_sn']]['title']."-".$teacher_array[$result->fields['manager_sn']]['name']."</td>
			<td align='center' $pic_show>".$result->fields['serial']."</td>
			<td><input type='checkbox' name='item_selected[]' value=".$result->fields['sn'].">".$result->fields['item']."</td>
			<td align='center'>".$result->fields['status']."</td>
			<td align='center'>".$result->fields['allowed_date']."</td>
			<td align='center'>".$result->fields['memo']."</td></tr>";
		$result->MoveNext();
	}
	$showdata.="<tr><td colspan=7 align=center bgcolor='$Tr_BGColor'><input type='submit' value='�M���X�ɴ���' name='BtnSubmit' onclick='return confirm(\"�u���n�M��?\")'".($m_arr['User_Removable']?'':' disabled')."></td></tr>";
}

$showdata.="</form></table>";
echo $main.$showdata;
foot();
?>