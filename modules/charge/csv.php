<?php

include "config.php";
sfs_check();

if($_POST[item_selected]) header("Location:".$_POST[item_selected]);


//�q�X����
head("���O�޲zCSV��X");

//��V������
$linkstr="item_id=$item_id";
echo print_menu($MENU_P,$linkstr);

$suported_item=array('pay_csv.php'=>'�x�W�Ȧ�','pay_csv_2.php'=>'����H�U�ӷ~�Ȧ�','pay_csv_3.php'=>'�x���ӷ~�Ȧ�','pay_csv_4.php'=>'�ɤs�Ȧ�');

$item_select="<BR><BR><center><form name='myform' method='post' action='$_SERVER[SCRIPT_NAME]'><B>����ܥN�����ľ��c��</B><BR><BR>";
foreach($suported_item as $key=>$value)
{
	$item_select.="<input type='radio' value='$key' name='item_selected' onclick='this.form.submit();'>$value<BR><BR>";
}
$item_select.="</form></center>";
echo $item_select;

foot();
?>
