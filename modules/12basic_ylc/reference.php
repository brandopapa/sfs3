<?php

include "config.php";
sfs_check();

//�B�z�W�Ǧۭq���榡
if($_POST['do_key']=='�W��') {
	//�Τ@�W�ǥؿ�
	$upath=$UPLOAD_PATH."12basic_ylc";
	if (!is_dir($upath))  { mkdir($upath) or die($upath."�إߥ��ѡI"); }

	//�W�ǥت��a
	$the_file=$upath.'/aspiration.csv';
	copy($_FILES['aspiration']['tmp_name'],$the_file);
	unlink($_FILES['aspiration']['tmp_name']);
}


//�q�X����
head("�ϥλ���");

//��V������
$linkstr="item_id=$item_id";
echo print_menu($MENU_P,$linkstr);

$aspiration_array=get_csv_reference();
foreach($aspiration_array as $key=>$value) {
	$aspiration_data.="<tr><td align='center'>{$value[0]}</td><td>{$value[1]}</td><td>{$value[2]}</td></tr>";
}

$main="<form name='myform' enctype='multipart/form-data' method='post' action='$_SERVER[PHP_SELF]'>";
$aspiration_upload="��<a href='aspiration_example.csv'>���@�ǰѷ��ɤW��</a>�G<input type=\"file\" name=\"aspiration\"><input type=\"submit\" name=\"do_key\" value=\"�W��\" onclick=\"if(this.form.aspiration.value) { return confirm(\'�W�ǫ�|�N��W���ɮ״����A�z�T�w�n�o�˰���?\'); } else return false;\">";
$main.="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1' width='50%'>
		<tr align='center' bgcolor='#ffcccc'><td>�N�X</td><td>�Ǯլ�O</td><td>�Ƶ�</td></tr>
		$aspiration_data</table>$aspiration_upload</form>";



echo $main;

foot();

?>