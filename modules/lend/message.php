<?php

//$Id: message.php 6207 2010-10-05 04:46:46Z infodaes $
include "config.php";
sfs_check();
//�q�X����
if(!$remove_sfs3head) head("���~�ɥκ޲z�T�����i");


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


if($_POST['BtnSubmit']=='�R��' and $_POST[item_selected]) {
	$item_selected=$_POST[item_selected];
	$ask_items='';
	foreach($item_selected as $value)
	{
		$ask_items.="$value,";
	}
	$ask_items=SUBSTR($ask_items,0,-1);
	$sql="DELETE FROM equ_board WHERE sn IN ($ask_items)";
	$res=$CONN->Execute($sql) or user_error("�R�����i���ѡI<br>$sql",256);
}

if($_POST['BtnSubmit']=='�s�W') {
	$is_add=1;
	//���ͰT���H��
	foreach($teacher_array as $key=>$value){
		if(! $value['condition']) $teacher.="<input type='checkbox' name='item_selected[]' value='$key'>".$value['title']."-".$value['name']."<BR>";
	}
	$add_data.="<table align=center width=".$m_arr['Table_width']."% border='2' cellpadding='5' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1'>
	<tr bgcolor='$Tr_BGColor'>
		<td align='center'><input type='checkbox' name='tag' onclick='javascript:tagall(this.checked);'>��H</td>
		<td align='center'>�T�����e</td>
	</tr>
	<tr>
		<td valign='top'>$teacher</td>
		<td valign='top'>
			�D���G<input type='text' name='title' size=52><BR>
			���e�G<textarea rows='15' name='content' cols='50'></textarea><BR>
			�_�l����G<input type='text' name='start' size=12 value='".date('Y-m-d',time())."'>
			�@�@���i��ơG<input type='text' name='days' size=2 value='".$m_arr['Over_Days']."'><BR><BR>
			<input type='submit' value='�o���T�����i' name='BtnSubmit' onclick='return confirm(\"�u���n�o���T��?\")'>
	</td>
	</tr>";
}

if($_POST['BtnSubmit']=='�o���T�����i' and $_POST[item_selected]){
	$title=$_POST['title'];
	$content=$_POST['content'];
	$start=$_POST['start'];
	$days=$_POST['days'];
	
	if($title){
		//���$ask_teachers
		$item_selected=$_POST[item_selected];
		foreach($item_selected as $value)
		{
			$ask_teachers.="[$value]";
		}
		$sql="INSERT INTO equ_board SET announce_date='$start',announce_limit=DATE_ADD('$start',INTERVAL $days DAY),manager_sn=$session_tea_sn,title='$title',detail='$content',receiver_sn='$ask_teachers'";
//echo $sql;
//exit;

		$res=$CONN->Execute($sql) or user_error("�o�e���i���ѡI<br>$sql",256);
		$executed='�� '.date('Y/m/d h:i:s')." �w�o�e���i-- $title";
	} else $executed="<font color='red'>�� ".date('Y/m/d h:i:s')." ���]�w���i�D��,�L�k�o�e!!</font>";
}




//��V������
//$linkstr="manager_sn=$manager_sn";
if($_GET['menu']<>'off') echo print_menu($MENU_P);

	$main="<table><form name='myform' method='post' action='$_SERVER[PHP_SELF]'>";
	
//�������w
$showdata="��ܭ��w�G";
$status_arr=array(0=>'�ثe��ܪ�',1=>'�w�p��',2=>'����');
foreach($status_arr as $key=>$value){
	$showdata.="<input type='radio' value='$key' name='status' onclick='this.form.submit()'".($status==$key?' checked':'').">$value ";
}

$showdata.="<table align=center width=".$m_arr['Table_width']."% border='2' cellpadding='5' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1'>
	<tr bgcolor='$Tr_BGColor'>
	<td align='center'><input type='checkbox' name='tag' onclick='javascript:tagall(this.checked);'></td>	
	<td align='center'>�D��</td>
	<td align='center'>���e</td>
	<td align='center'>���i���</td>
	<td align='center'>���i����</td>
	<td align='center'>��H</td>
	<td align='center'>�wñ��</td>
	<td align='center'>��ñ��</td>
	</tr>";

//���o���i����
$sql_select="SELECT *,if(CURDATE() BETWEEN announce_date AND announce_limit,0,if(CURDATE()<announce_date,1,2)) AS status FROM equ_board WHERE manager_sn=$session_tea_sn";

switch ($status) {
case 0:
    $sql_select.=" AND (CURDATE() BETWEEN announce_date AND announce_limit)";
    break;
case 1:
    $sql_select.=" AND CURDATE()<announce_date";
    break;
}
$sql_select.=" ORDER BY announce_date";
//echo $sql_select;

$result=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
if($result->recordcount()){
	while(!$result->EOF)
	{
		switch ($result->fields['status']) {
		case 0:
			$BGColor=$m_arr['Cur_BGColor'];
			break;
		case 1:
			$BGColor=$m_arr['Pre_BGColor'];
			break;
		case 1:
			$BGColor=$m_arr['Aft_BGColor'];
			break;
		}
		//�N�wñ���H���N���ର�m�W
		$received=str_replace('[','',$result->fields['received_sn']);
		$received_sn=explode("]",$received);
		$received='';
		foreach($received_sn as $value){
			if($value) $received.=$teacher_array[$value]['title']."-".$teacher_array[$value]['name']."<BR>";
		}

		//�N��ñ���H���N���ର�m�W
		$receiver=str_replace('[','',$result->fields['receiver_sn']);
		$receiver_sn=explode("]",$receiver);
		$receiver='';
		foreach($receiver_sn as $value){
			if($value) $receiver.=$teacher_array[$value]['title']."-".$teacher_array[$value]['name']."<BR>";
		}

		//�p�⥼ñ���H��
		$not_received_sn=array_diff($receiver_sn,$received_sn);
		$not_received='';
		$receiver=$receiver?$receiver:'����H��';
		foreach($not_received_sn as $value){
			if($value) $not_received.=$teacher_array[$value]['title']."-".$teacher_array[$value]['name']."<BR>";
		}
		
		
		$showdata.="<tr bgcolor='$BGColor'>
		<td align='center'><input type='checkbox' name='item_selected[]' value='".$result->fields['sn']."'></td>	
		<td>".$result->fields['title']."</td>
		<td>".str_replace("\r\n","<BR>",$result->fields['detail'])."</td>
		<td align='center'>".$result->fields['announce_date']."</td>
		<td align='center'>".$result->fields['announce_limit']."</td>
		<td align='center' OnMouseOver='this.style.cursor=\"images/link.cur\"'><img src='images/receiver.gif' Onclick='receiver=window.open(\"\",\"���T��\",\"status=no,toolbar=no,location=no,menubar=no,width=200,height=300\");receiver.document.write(\"$receiver\")'></td>
		<td align='center' OnMouseOver='this.style.cursor=\"images/wii.ani\"'><img src='images/received.gif' Onclick='received=window.open(\"\",\"�wñ���H��\",\"status=no,toolbar=no,location=no,menubar=no,width=200,height=300\");received.document.write(\"$received\")'></td>
		<td align='center' OnMouseOver='this.style.cursor=\"images/red.ani\"'><img src='images/not_received.gif' Onclick='not_received=window.open(\"\",\"���T��\",\"status=no,toolbar=no,location=no,menubar=no,width=200,height=300\"); not_received.document.write(\"$not_received\")'></td>
		</tr>";
		$result->MoveNext();
		
		
		/*
		
		<td align='center'>".$receiver."</td>
		<td align='center'>".$received."</td>
		<td align='center'>".$not_received."</td>
		
		
		*/
		
	}
}
$showdata.="<tr><td align='center' colspan=8><input type='submit' value='�s�W' name='BtnSubmit'><input type='submit' value='�R��' name='BtnSubmit' onclick='return confirm(\"�u���n�R��?\")'></td></tr>";

echo $main.($is_add?$add_data:$showdata)."</form></table><BR>$executed";
if(!$remove_sfs3head) foot();
?>