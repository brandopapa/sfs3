<?php

// $Id: $

/*�ޤJ�ǰȨt�γ]�w��*/
include "config.php";

//�ϥΪ̻{��
sfs_check();

if($_POST['go']=='�s�W')
{
	//�קKsql injection
	$_POST['field_selected']=str_replace(';','',$_POST['field_selected']);
	$_POST['field_selected']=str_replace('delete','',$_POST['field_selected']);
	$_POST['field_selected']=str_replace('DELETE','',$_POST['field_selected']);
	$_POST['field_selected']=str_replace('drop','',$_POST['field_selected']);
	$_POST['field_selected']=str_replace('DROP','',$_POST['field_selected']);
	
	$_POST['new_format_name']=str_replace(';','',$_POST['new_format_name']);
	$_POST['new_format_name']=str_replace('delete','',$_POST['new_format_name']);
	$_POST['new_format_name']=str_replace('DELETE','',$_POST['new_format_name']);
	$_POST['new_format_name']=str_replace('drop','',$_POST['new_format_name']);
	$_POST['new_format_name']=str_replace('DROP','',$_POST['new_format_name']);
	
	$_POST['columns']=trim($_POST['columns']);
	$sql="INSERT INTO address_book SET nature='{$_POST['nature']}',room='{$_POST['room']}',title='{$_POST['new_format_name']}',fields='{$_POST['field_selected']}',header='{$_POST['header']}',footer='{$_POST['footer']}',columns='{$_POST['columns']}',creater='$my_name',update_time=now();";
	$rs=$CONN->Execute($sql) or die("�L�k�s�W�s���榡<br>$sql");
}

if($_POST['go']=='�T�w�ק�')
{
	//�קKsql injection
	$_POST['field_selected']=str_replace(';','',$_POST['field_selected']);
	$_POST['field_selected']=str_replace('delete','',$_POST['field_selected']);
	$_POST['field_selected']=str_replace('DELETE','',$_POST['field_selected']);
	$_POST['field_selected']=str_replace('drop','',$_POST['field_selected']);
	$_POST['field_selected']=str_replace('DROP','',$_POST['field_selected']);
	
	$_POST['new_format_name']=str_replace(';','',$_POST['new_format_name']);
	$_POST['new_format_name']=str_replace('delete','',$_POST['new_format_name']);
	$_POST['new_format_name']=str_replace('DELETE','',$_POST['new_format_name']);
	$_POST['new_format_name']=str_replace('drop','',$_POST['new_format_name']);
	$_POST['new_format_name']=str_replace('DROP','',$_POST['new_format_name']);
	
	$sql="UPDATE address_book SET nature='{$_POST['nature']}',room='{$_POST['room']}',title='{$_POST['new_format_name']}',fields='{$_POST['field_selected']}',header='{$_POST['header']}',footer='{$_POST['footer']}',columns='{$_POST['columns']}',creater='$my_name',update_time=now() WHERE sn={$_POST['target_sn']};";
	$rs=$CONN->Execute($sql) or die("�L�k�ק�쪺�榡<br>$sql");
}

if($_POST['target_sn'] and $_POST['act']=='del')
{
	//echo "�i�J�@�R���@�B�z�{��!!   {$_POST['target_sn']}";
	$sql="DELETE FROM address_book WHERE sn={$_POST['target_sn']};";
	$rs=$CONN->Execute($sql) or die("�L�k�R�����w���˦�!<br>$sql");
}

//�q�X����
head("�q�T���˦��޲z");
print_menu($menu_p);

//���Ϳﶵ
foreach($fields_array as $key=>$value)
{
	$field_radio.="<input type='radio' value='$key' name='field_radio' onclick='this.form.field_selected.value=this.form.field_selected.value+\"$value,\";'>$value ";
}
if($_POST['target_sn'] and $_POST['act']=='modify')
{
	$sql="SELECT * FROM address_book WHERE sn={$_POST['target_sn']}";
	$rs=$CONN->Execute($sql) or die("�L�k���o�w�g�}�C���˦����!<br>$sql");

	$new_format="<table STYLE='font-size: x-small' border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%'>
			<tr><td bgcolor='#88FFFF' rowspan=3><font size=4> �� <br> �� <br> �� <br> �� <br> �� </font></td><td bgcolor='#CCFCCF'>$field_radio</td></tr>
			<tr><td bgcolor='#FFFFCC'>			
			���z�ҿ�������G<input type='text' size=100 maxlength=200 name='field_selected' value='{$rs->fields['fields']}'>
			<input type='button' name='clear' value='�M�����]' onclick=\"document.myform.field_selected.value='';\" >
			<br>�������ŧi�G<input type='text' size=117 maxlength=200 name='header' value='{$rs->fields['header']}'>
			<br>�����������G<input type='text' size=117 maxlength=200 name='footer' value='{$rs->fields['footer']}'>
			<br>���A�γB�ǡG<font color='blue'>$my_room</font><input type='hidden'name='room' value='$my_room'>�@�@
			����ơG<input type='text' name='columns' size=1 maxlength=1 value='{$rs->fields['columns']}'>�@�@
			���N�W�C�����C���x�s���G<input type='text' size=50 name='new_format_name' value='{$rs->fields['title']}'>
			<input type='submit' name='go' value='�T�w�ק�' onclick='return confirm(\"�u���n�ק�?\")'></td></tr>
			</table>";
} else {
	$new_format="<table STYLE='font-size: x-small' border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%'>
			<tr><td bgcolor='#FFCCCC' rowspan=3> �� <br> �� <br> �s <br> �� <br> �� </td><td bgcolor='#CCFCCF'>$field_radio</td></tr>
			<tr><td bgcolor='#FFFFCC'>
			���z�ҿ�������G<input type='text' size=100 maxlength=200 name='field_selected' value=''>
			<input type='button' name='clear' value='�M�����]' onclick=\"document.myform.field_selected.value='';\" >
			<br>�������ŧi�G<input type='text' size=117 maxlength=200 name='header' value='{$rs->fields['header']}'>
			<br>�����������G<input type='text' size=117 maxlength=200 name='footer' value='{$rs->fields['footer']}'>
			<br>���A�γB�ǡG<font color='blue'>$my_room</font><input type='hidden'name='room' value='$my_room'>�@�@
			���N�W�C�����C���x�s���G<input type='text' size=50 name='new_format_name' value=''>
			<input type='submit' name='go' value='�s�W' onclick='return confirm(\"�u���n�s�W?\")'></td></tr></table>";
}  //����ơG<input type='text' name='columns' size=1 maxlength=1 value='1'>�@�@
			
//����w�g�}�C���˦����
$saved_format="<table STYLE='font-size: x-small' border='1' cellpadding=5 cellspacing=0 style='border-collapse: collapse' bordercolor='#111111' width='100%'><tr bgcolor='#CCFCCF'><td align='center'>���D</td><td align='center' width='40%'>���C��</td><td align='center'>���</td><td align='center'>�]�w��</td><td align='center'>��s���</td><td align='center'>���@<input type='hidden' name='target_sn' value='{$_POST['target_sn']}'><input type='hidden' name='act' value=''></td></tr>";
$sql="select * from address_book where room='$my_room' and nature='$nature' order by update_time desc;";
$rs=$CONN->Execute($sql) or die("�L�k���o�w�g�}�C���˦����!<br>$sql");
while(!$rs->EOF) {
	$target_sn=$rs->fields['sn'];
	$saved_format.="<tr><td align='center'>{$rs->fields['title']}</td><td>{$rs->fields['fields']}</td><td align='center'>{$rs->fields['columns']}</td><td align='center'>{$rs->fields['creater']}</td><td align='center'>{$rs->fields['update_time']}</td><td align='center'>
					<input type='button' value='�ק�' onclick='this.form.target_sn.value=\"$target_sn\"; this.form.act.value=\"modify\"; this.form.submit();'>
					<input type='button' value='�R��' onclick='if(confirm(\"�u���n�R��?\")) { this.form.target_sn.value=\"$target_sn\"; this.form.act.value=\"del\"; this.form.submit(); }'></td></tr>";
	$rs->MoveNext();
}
$saved_format.='</table>';

			
echo "<form name='myform' method='post' action='$_SERVER[PHP_SELF]'>$nature_radio<br>$new_format<br>$saved_format</form>";
foot();
?>
