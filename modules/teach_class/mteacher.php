<?php

// $Id: mteacher.php 7552 2013-09-19 03:38:47Z hami $

// --�t�γ]�w��
include "teach_config.php";

//--�{�� session
sfs_check();

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}


if ($act=="�妸�إ߸��"){
	$msg=import($_FILES['userdata']['tmp_name'],$_FILES['userdata']['name'],$_FILES['userdata']['size']);
	//header("location: {$_SERVER['PHP_SELF']}?act=result&main=$msg");
}else{
	$main=&main_form();
}

//�L�X���Y
head("�妸�إ߱Юv���");
if($msg) echo "<table cellspacing='1' cellpadding='10' class=main_body>
	<tr bgcolor='#E1ECFF'><td>".$msg."</td></tr></table>";
else echo $main;
foot();
	

//�D�n���
function &main_form(){
	global $teach_menu_p;
	$toolbar=&make_menu($teach_menu_p);

	$main="
	$toolbar
	<table border='0' cellspacing='0' cellpadding='0' >
	<tr><td valign=top>
		<table cellspacing='1' cellpadding='10' class=main_body >
		<form action ='{$_SERVER['PHP_SELF']}' enctype='multipart/form-data' method=post>
		<tr><td  nowrap valign='top' bgcolor='#E1ECFF'>
		<p>�Ы��y�s���z��ܶפJ�ɮרӷ��G</p>
		<input type=file name='userdata'>
		<p><input type=submit name='act' value='�妸�إ߸��'></p>
		</td>
		<td valign='top' bgcolor='#FFFFFF'>
		<p><b><font size='4'>�Юv��Ƨ妸���ɻ���</font></b></p>
		<ol>
		<li>���{���u��إ߱Юv�򥻸�ơA��L��ơA�ݦܱ�¾����ƺ޲z�{���إߡC</li>
		<li>��ĳ�Q�� OpenOffice.org �� Calc ��J�Юv��ơA�s�� csv �ɡ]�ݤĿ�u�z��]�w�v�^�A�ëO�d�Ĥ@�C���D�ɡA�p
		<a href=teacherdemo.csv target=new>�d����</a></li>
		<li>�X�ͤ���H�褸���ǡC</li>
		<li>�K�X�ݧt�^��μƦr�A�B���צܤ֬����Ӧr�C</li>
		</ol>
		</td>
		</tr>
		</table>
	</form>
	</td></tr></table>
	";
	return $main;
}


//�פJ���
function import($userdata,$userdata_name,$userdata_size){
	global $temp_path,$CONN;
	$temp_file= $temp_path."/tea.csv";
	if ($userdata_size>0 && $userdata_name!=""){
		copy($userdata , $temp_file);
		$fd = fopen ($temp_file,"r");
		//while ($tt = fgetcsv ($fd, 2000, ",")) {
		$contents = fread($fd, filesize($temp_file));
		$temp_arr = explode ("\n",$contents);
		foreach ($temp_arr as $tt_temp){
			$tt = explode (",",$tt_temp);
			if ($i++ == 0 or empty($tt_temp)) //�Ĥ@�������Y
				continue ;
			$teach_id = trim ($tt[0]);
			$login_pass = pass_operate(trim($tt[1]));
			$teach_person_id = trim ($tt[2]);
			if ($teach_person_id) {
				$teach_person_id = strtoupper($teach_person_id) ;
				$edu_key =  hash('sha256', strtoupper($teach_person_id));
			}
			$name = trim (addslashes($tt[3]));
			$sex = trim ($tt[4]);
			$birthday = trim ($tt[5]);
			$marriage = trim ($tt[6]);
			$address = trim (addslashes($tt[7]));
			$home_phone = trim ($tt[8]);
			$cell_phone = trim ($tt[9]);
			$sql_insert = "insert into teacher_base (teach_id,teach_person_id,name,sex,birthday,marriage,address,home_phone,
			cell_phone,login_pass,edu_key) values ('$teach_id','$teach_person_id','$name','$sex','$birthday','$marriage',
			'$address','$home_phone','$cell_phone','$login_pass','$edu_key')";
			$result=$CONN->Execute($sql_insert);
			$name=stripslashes($name);
			if($result){
				$msg.="$teach_id -- $name �s�W���\�I<br>";
				}
			else
				$msg.="$teach_id -- $name ��Ʒs�W���ѡI<br>";
			$i++;
		}
	}
	else{
		$msg.="�ɮ׮榡���~";
	}
	unlink($temp_file);
	return $msg;
}
?>
