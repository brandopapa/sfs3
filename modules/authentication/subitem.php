<?php
// $Id: detail.php 6114 2010-09-09 08:19:54Z infodaes $

include "config.php";

sfs_check();

//�q�X����
head("�ǲ߻{��-�ӥس]�w");

$item_sn=$_POST[item_sn];
$sn=$_POST[sn];

//��V������
echo print_menu($MENU_P);

if($_POST['act']=='�s�W'){
	$sql_select="INSERT INTO authentication_subitem(item_sn,code,title,grades,bonus) values ('$item_sn','$_POST[a_code]','$_POST[a_title]','$_POST[a_grades]','$_POST[a_bonus]')";
	$res=$CONN->Execute($sql_select) or user_error("�s�W���ѡI<br>$sql_select",256);
};

if($_POST['act']=='��s'){
	$sql_select="UPDATE authentication_subitem SET item_sn='{$_POST[item_sn]}',code='{$_POST[code]}',title='{$_POST[title]}',grades='{$_POST[grades]}',bonus='{$_POST[bonus]}' where sn=$sn";
	$res=$CONN->Execute($sql_select) or user_error("��s���ѡI<br>$sql_select",256);
	$_POST[sn]=0;
};

if($_POST['act']=='�R��'){
	$sql_select="delete from authentication_subitem where sn=$sn";
	$res=$CONN->Execute($sql_select) or user_error("�R�����ѡI<br>$sql_select",256);
};



$main="<table><form name='form_item' method='post' action='$_SERVER[PHP_SELF]'><input type='hidden' name='sn' value=$sn>
		�����ݳB�ǻ{�Ҷ��ءG<select name='item_sn' onchange='this.form.submit()'><option></option>";
//���o�{�Ҥ����ت��U�Կ��
$sql_select="select * from authentication_item WHERE room_id=$my_room_id AND (CURDATE() BETWEEN start_date AND end_date) order by code";
$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);

while(!$res->EOF) {
	if($item_sn==$res->fields[sn]) $selected="selected"; else $selected='';
	$main.="<option $selected value={$res->fields[sn]}>{$res->fields[nature]}-{$res->fields[code]}-{$res->fields[title]} ({$res->fields[start_date]}~{$res->fields[end_date]})</option>";
	$res->MoveNext();
}
$main.="</select></table>";

//�ӥظ��
$showdata="<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%'>
	<tr>
	<td align='center' bgcolor='#CCFF99'>NO.</td>
	<td align='center' bgcolor='#CCFF99'>�ӥإN�X</td>
	<td align='center' bgcolor='#CCFF99'>�ӥئW��</td>	
	<td align='center' bgcolor='#CCFF99'>�A�Φ~��<BR>(�ХH,���j)</td>
	<td align='center' bgcolor='#CCFF99'>�{���I��</td>
	<td align='center' bgcolor='#CCFF99'>�\��ާ@</td>
	</tr>";
$sql_select="select * from authentication_subitem WHERE item_sn='$item_sn' order by code";
$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
//$res->MoveFirst();
while(!$res->EOF) {
	if($_POST[sn]==$res->fields[sn]){
		$showdata.="<tr bgcolor='#FFFAAA'><td align='center'>".($res->CurrentRow()+1)."</td>";
		$showdata.="<td align='center'><input type='text' name='code' size=5 value={$res->fields[code]}></td>";		
		$showdata.="<td><input type='text' name='title' size=50 value={$res->fields[title]}></td>";
		$showdata.="<td align='center'><input type='text' name='grades' size=10 value='{$res->fields[grades]}'></td>";
		$showdata.="<td align='center'><input type='text' name='bonus' size=5 value='{$res->fields[bonus]}'></td>";		
		$showdata.="<td align='center' colspan=2>";
		$showdata.="<input type='submit' value='��s' name='act' onclick='return confirm(\"�T�w�n��s[{$res->fields[code]}-{$res->fields[title]}]?\")'><input type='submit' value='�R��' name='act' onclick='return confirm(\"�u���n�R��[{$res->fields[code]}-{$res->fields[title]}]?\")'></td></tr>";
	} else {	
		$sn=$res->fields[sn];
		$showdata.="<tr bgcolor=$item_color><td align='center'>".($res->CurrentRow()+1)."</td>";
		$showdata.="<td align='center'>".$res->fields[code]."</td>";
		$showdata.="<td>".$res->fields[title]."</td>";
		$showdata.="<td align='center'>".$res->fields[grades]."</td>";
		$showdata.="<td align='center'>".$res->fields[bonus]."</td>";
		$showdata.="<td align='center'><input type='button' name='act' value='���@' onclick='this.form.sn.value=\"$sn\"; this.form.submit();'></td>";
		$showdata.="</tr>";
	}
	$res->MoveNext();
}

	//�s�W�ӥ�
	$showdata.="<tr></tr><tr bgcolor='#FFCCCC'><td align='center'><img border=0 src='images/add.gif' alt='�}�C�s����'></td>";
	$showdata.="<td align='center'><input type='text' name='a_code' size=5></td>";
	$showdata.="<td align='center'><input type='text' name='a_title' size=50></td>";
	$showdata.="<td align='center'><input type='text' name='a_grades' size=10></td>";
	$showdata.="<td align='center'><input type='text' name='a_bonus' size=5></td>";
	$showdata.="<td align='center'><input type='submit' value='�s�W' name='act'><input type='reset' value='���s�]�w'></td></tr><tr></tr>";

$showdata.="</form></table>";

echo $main.$showdata;


foot();
?>