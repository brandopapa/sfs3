<?php
// $Id: index2.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";
sfs_check();

//�D���]�w
$school_menu_p=(empty($school_menu_p))?array():$school_menu_p;

//�w�]�ȳ]�w
$index_page=(!empty($_GET[index_page]))?$_GET[index_page]:index.php;
$default=array("author"=>"$_SESSION[session_tea_name]","lable"=>"1.0.0","index_page"=>"$index_page","install"=>"* �w�ˤ�k�G
�Хѡu�Ҳ��v���޲z�v�i�J
���G�o�̱ĥ� outline ���Ҧ��C
���� outline�A�аѦ� ","news"=>"*�����׭q�����G","readme"=>"*Ū���ɮסG
�����ŧi�GGPL");


$act=$_REQUEST[act];

//����ʧ@�P�_
if($act=="insert"){
	module_maker_add($_POST[data]);
	get_zip($_POST[data]);
}elseif($act=="update"){
	module_maker_update($_POST[data],$_POST[mms]);
	header("location: $_SERVER[PHP_SELF]?act=listAll");
}elseif($act=="del"){
	module_maker_del($_GET[mms]);
	header("location: $_SERVER[PHP_SELF]?act=listAll");
}elseif($act=="listAll"){
	$main=&module_maker_listAll();
}elseif($act=="modify"){
	$main=&module_maker_mainForm($_GET[mms],"modify");
}else{
	$main=&module_maker_mainForm($_POST[mms]);
}


//�q�X����
head("�s�Ҳ�");
echo $main;
foot();

//�D�n��J�e��
function &module_maker_mainForm($mms="",$mode){
	global $school_menu_p,$default;
	
	$index_mode=(empty($_GET[index_page]))?"":"sql";
	
	if($mode=="modify" and !empty($mms)){
		$dbData=get_module_maker_data($mms);
	}
	
	if(is_array($dbData) and sizeof($dbData)>0){
		foreach($dbData as $a=>$b){
			$DBV[$a]=(!is_null($b))?$b:$default[$a];
		}
	}else{
		$DBV=$default;
	}
	
	$submit=($mode=="modify")?"update":"insert";
	
	//�����\���
	$tool_bar=&make_menu($school_menu_p);
	
	$main="
	$tool_bar
	
	<table cellspacing='1' cellpadding='3' bgcolor='#C0C0C0' class='small'>
	<form action='$_SERVER[PHP_SELF]' method='post'>
	<tr bgcolor='#FFFFFF'>
	<td>�@��</td>
	<td><input type='text' name='data[author]' value='$DBV[author]' size='50' maxlength='50'></td>
	</tr>
	
	<tr bgcolor='#FFFFFF'>
	<td>Email</td>
	<td><input type='text' name='data[email]' value='$DBV[email]' size='50' maxlength='100'></td>
	</tr>
	
	<tr bgcolor='#FFFFFF'>
	<td>�إߤ��</td>
	<td><input type='text' name='data[creat_date]' value='".date("Y-m-d")."' size='19' maxlength='19'></td>
	</tr>
	
	<tr bgcolor='#FFFFFF'>
	<td>����</td>
	<td><input type='text' name='data[lable]' value='$DBV[lable]' size='50' maxlength='50'></td>
	</tr>
	
	<tr bgcolor='#FFFFFF'>
	<td>�Ҳդ���W��</td>
	<td><input type='text' name='data[showname]' value='$DBV[showname]' size='50' maxlength='100'></td>
	</tr>
	
	<tr bgcolor='#FFFFFF'>
	<td>�Ҳեؿ��W��</td>
	<td><input type='text' name='data[dirname]' value='$DBV[dirname]' size='50' maxlength='100'></td>
	</tr>
	
	<tr bgcolor='#FFFFFF'>
	<td>�����ɦW</td>
	<td><input type='text' name='data[index_page]' value='$DBV[index_page]' size='50' maxlength='100'></td>
	</tr>
	
	<tr bgcolor='#FFFFFF'>
	<td>�Ҳե\\��y�z</td>
	<td><textarea name='data[description]' cols='40' rows='5' class='small'>$DBV[description]</textarea>
	</td>
	</tr>
	
	<tr bgcolor='#FFFFFF'>
	<td>�w�˻���</td>
	<td><textarea name='data[install]' cols='40' rows='5' class='small'>$DBV[install]</textarea>
	</td>
	</tr>
	
	<tr bgcolor='#FFFFFF'>
	<td>�\\��W�׬���</td>
	<td><textarea name='data[news]' cols='40' rows='5' class='small'>$DBV[news]</textarea>
	</td>
	</tr>
	
	<tr bgcolor='#FFFFFF'>
	<td>Ū���ɮ�</td>
	<td><textarea name='data[readme]' cols='40' rows='5' class='small'>$DBV[readme]</textarea>
	</td>
	</tr>
	
	</table>
	<input type='hidden' name='data[table_name]' value='$_GET[table]'>
	<input type='hidden' name='data[index_mode]' value='$index_mode'>
	<input type='hidden' name='mms' value='$mms'>
	<input type='hidden' name='act' value='$submit'>
	<input type='submit' value='�e�X'>
	</form>

	<a href='$_SERVER[PHP_SELF]?act=listAll'>�C�X����</a>
	";
	return $main;
}

//�s�W
function module_maker_add($data){
	global $CONN;
	if(empty($data[showname]))$data[showname]="�s�Ҳ�";
	if(empty($data[dirname]))$data[dirname]="new_module";
	
	$sql_insert = "insert into module_maker (mms,author,email,creat_date,lable,showname,dirname,index_page,description,install,news,readme) values ('$data[mms]','$data[author]','$data[email]','$data[creat_date]','$data[lable]','$data[showname]','$data[dirname]','$data[index_page]','$data[description]','$data[install]','$data[news]','$data[readme]')";
	$CONN->Execute($sql_insert) or user_error("�s�W���ѡI<br>$sql_insert",256);
	$mms=mysql_insert_id();
	return $mms;
}

//��s
function module_maker_update($data,$mms){
	global $CONN;
	
	if(empty($data[showname]))$data[showname]="�s�Ҳ�";
	if(empty($data[dirname]))$data[dirname]="new_module";
	
	$sql_update = "update module_maker set mms='$data[mms]',author='$data[author]',email='$data[email]',creat_date='$data[creat_date]',lable='$data[lable]',showname='$data[showname]',dirname='$data[dirname]',index_page='$data[index_page]',description='$data[description]',install='$data[install]',news='$data[news]',readme='$data[readme]'  where mms='$mms'";
	$CONN->Execute($sql_update) or user_error("��s���ѡI<br>$sql_update",256);
	return $mms;
}

//�R��
function module_maker_del($mms=""){
	global $CONN;
	$sql_delete = "delete from module_maker where mms='$mms'";
	$CONN->Execute($sql_delete) or user_error("�R�����ѡI<br>$sql_delete",256);
	return true;
}

//�C�X�Ҧ�
function &module_maker_listAll(){
	global $CONN;
	$sql_select="select mms,author,email,creat_date,lable,showname,dirname,index_page,description,install,news,readme from module_maker";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while (list($mms,$author,$email,$creat_date,$lable,$showname,$dirname,$index_page,$description,$install,$news,$readme)=$recordSet->FetchRow()) {
		$data.="<tr bgcolor='#FFFFFF'><td>$mms</td><td>$author</td><td>$email</td><td>$creat_date</td><td>$lable</td><td>$showname</td><td>$dirname</td><td>$index_page</td><td>$description</td><td>$install</td><td>$news</td><td>$readme</td><td nowrap><a href='$_SERVER[PHP_SELF]?act=modify&mms=$mms'>�ק�</a> | <a href='$_SERVER[PHP_SELF]?act=del&mms=$mms'>�R��</a></td></tr>";
	}
	$main="
	<table width='96%' cellspacing='1' cellpadding='3' bgcolor='#C0C0C0' class='small'>
	<tr bgcolor='#E6E9F9'><td>�Ҳսs��</td><td>�@��</td><td>Email</td><td>�إߤ��</td><td>����</td><td>�Ҳդ���W��</td><td>�Ҳեؿ��W��</td><td>�����ɦW</td><td>�Ҳե\\��y�z</td><td>�w�˻���</td><td>�\\��W�׬���</td><td>Ū���ɮ�</td><td>�\��</td></tr>
	$data
	</table>";
	return $main;
}

//���o�Y�@�����
function get_module_maker_data($mms){
	global $CONN;
	$sql_select="select mms,author,email,creat_date,lable,showname,dirname,index_page,description,install,news,readme from module_maker where mms='$mms'";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	$theData=$recordSet->FetchRow();
	return $theData;
}
?>
