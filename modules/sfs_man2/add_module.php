<?php

// $Id: add_module.php 5310 2009-01-10 07:57:56Z hami $

//�]�w�ɸ��J�ˬd
require "config.php";
// �{���ˬd
sfs_check();

//����ʧ@�P�_
if($_POST[act]=="�w��"){
	add_prob();
	header("location: $_SERVER[PHP_SELF]");
}else{
	$main=&main_form();
}


//�q�X����
head("�ǰȵ{���]�w");
echo $main;
foot();

//�D�n���
function &main_form(){
	global $CONN,$SFS_PATH,$school_menu_p,$MODULE_DIR;
	$tool_bar=&make_menu($school_menu_p);
	$select_dir=$_REQUEST['dir'];
	$realdir=$SFS_PATH."/modules/";

	//�u����|�U���Ҳ�
	$real_dir=real_dir_array($realdir);

	$sql_select="select dirname from sfs_module where kind='�Ҳ�'";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while(list($dirname)=$recordSet->FetchRow()){
		$db_dir[]=$dirname;
	}


	if(empty($db_dir))$db_dir=array();

	//�N��Ʈw�����ؿ��M��ڸ��|�Ӥ��@�U
	$diff_dir=array_diff($real_dir,$db_dir);

	sort($diff_dir);

	foreach($diff_dir as $d){
		$color=($select_dir==$d)?"#FFFB8A":"white";

		$is_stand_module=is_stand_module($MODULE_DIR,$d);
		$MODULE_PRO_KIND_NAME ='';
		if ($is_stand_module) 
			include_once $MODULE_DIR.$d."/module-cfg.php";
	
		
		$stand_txt=($is_stand_module)?"<font color='#358E1F' class='small'>�C</font>":"<font color='red' class='small'>�C</font>";


		$diff_dir_txt.="<div style='background:$color'>
		$stand_txt
		<a href='$_SERVER[PHP_SELF]?mode=add&dir=$d'>$d"." [".$MODULE_PRO_KIND_NAME."]</a></div>";
	}

	if(empty($diff_dir_txt)){
		$diff_dir_txt="
		<tr bgcolor='#FFFFFF'>
		<td colspan='4'>�Ҧ��Ҳէ��w�w�ˡA�L�s�Ҳեi�Ѧw�ˡC</td>
		</tr>";
	}
	
	if($_REQUEST[mode]=="add" and !empty($select_dir)){
		$addForm=&addForm($select_dir,$_REQUEST[id_kind]);
	}

	$main="
	$tool_bar
	<table cellspacing='0' cellpadding='0' >
		<tr><td valign='top'>
			<table width='100%'  cellspacing='1' cellpadding='4' bgcolor='#9C4569'>
			<tr bgcolor='#800000'>
			<td><font color='#FFFFFF'>�|���]�w���Ҳ�</font></td></tr>
			<tr bgcolor='#FFFFFF'><td style='font-size:16px;font-family:Arial;line-height:150%'>$diff_dir_txt</td></tr>
			</table>

		</td><td width='10'></td><td valign='top'>
		$addForm
		</td></tr>
		</table>
	";

	return $main;
}

//�s�W��ܦJ
function &addForm($dir,$id_kind){
	global $MODULE_DIR;
	//���o�¼Ҳջ�����
	$log=get_auth_txt($dir);
	
	//��X�������
	$get_of_group=get_of_group($_REQUEST[of_group],"of_group",$_POST[of_group],$id_kind,"1");

	//�v���]�w���
	$power_set=power_set($id_kind,"id_kind","id_sn","is_admin");

	$is_stand_module=is_stand_module($MODULE_DIR,$dir);
	$stand_txt=($is_stand_module)?"<font color='#358E1F'>�зǼҲ�</font>":"<font color='red'>�D�зǼҲ�</font>";

	if($is_stand_module){
		include $MODULE_DIR.$dir."/module-cfg.php";
		$hidden="
		<input type='hidden' name='ver' value='$MODULE_UPDATE_VER'>
		<input type='hidden' name='author' value='$MODULE_UPDATE_MAN'>
		<input type='hidden' name='creat_date' value='$MODULE_UPDATE'>";
		$log2="
		�y�зǼҲթҧt��T�z<br>
		�̫��s�����G
		$MODULE_UPDATE_VER<br>
		�̫��s����G
		$MODULE_UPDATE<br>
		";
	}

	$showname=(empty($_REQUEST[showname]))?$MODULE_PRO_KIND_NAME:$_REQUEST[showname];

	$islive_checked=($_REQUEST[islive]=="1" and  $_POST[islive]!='')?"checked":"";
	$isopen_checked=($_REQUEST[isopen]=="1" and  $_POST[isopen]!='')?"checked":"";


	$main="
	<table cellspacing='1' cellpadding='4' bgcolor='#C0C0C0'><tr bgcolor='#FFFFFF'><td>
		<form action='$_SERVER[PHP_SELF]' method='post'>
		<input type='hidden' name='dir' value='$dir'>
		<input type='hidden' name='dirname' value='$dir'>
		<input type='hidden' name='mode' value='$_REQUEST[mode]'>
		$hidden
		<table cellspacing='0' cellpadding='4' bgcolor='#FFFFFF' class='small'>
		<tr><td bgcolor='#F1F2E6'>$stand_txt</td><td>
		$dir $author</td></tr>
		<tr><td bgcolor='#F1F2E6'>����W��</td><td>
		<input type='text' name='showname' value='$showname'>
		</td></tr>
		<tr><td bgcolor='#F1F2E6'>�w�˥ؿ�</td><td>
		$get_of_group</td></tr>
		<tr><td bgcolor='#F1F2E6'>�O�_�}��i�J</td><td>
		<input type='checkbox' name='isopen' value='1' $isopen_checked>
		���\�@����Ͷi�J�s��</td></tr>
		<tr><td bgcolor='#F1F2E6'>�w�˫�ߧY�ҥ�</td><td>
		<input type='checkbox' name='islive' value='1' $islive_checked>
		�ߧY�ҥ�</td></tr>
		<tr bgcolor='#FFDFDF'><td>�Ҳձ��v</td>

		<td>$power_set<input type='submit' name='act' value='�w��'></td></tr>
		<tr bgcolor='#DFEFD8'><td colspan='2'>
		$log
		</td></tr>
		<tr bgcolor='#FFFB8A'><td colspan='2'>
		$log2
		</td></tr>
		</table></form>
	</td></tr></table>
	";
	return $main;
}

//�s�W�x�s�Ҳճ]�w��T
function add_prob(){
	global $CONN,$MODULE_DIR,$UPLOAD_PATH;
	//���o�Ӥ����U�̫�@�ӱƧǼƦr
	$sort=get_sort($_POST[of_group]);
	if (!$_POST['isopen']) $_POST['isopen'] =0 ;
	$sql_insert = "insert into sfs_module (showname,dirname,sort,isopen,islive,of_group,ver,author,creat_date,kind) values ('$_POST[showname]','$_POST[dirname]','$sort','$_POST[isopen]','$_POST[islive]','$_POST[of_group]','$_POST[ver]','$_POST[author]','$_POST[creat_date]','�Ҳ�')";
	$CONN->Execute($sql_insert) or user_error("�s�W���ѡI<br>$sql_insert",256);
	$msn=mysql_insert_id();

	//�x�s�v������
	if(!empty($_POST[id_kind])){
		if (!$_POST['is_admin'])  $_POST['is_admin'] = 0 ;
		$str="INSERT INTO pro_check_new (pro_kind_id,id_kind,id_sn,is_admin) VALUES ('$msn','$_POST[id_kind]','$_POST[id_sn]','$_POST[is_admin]')";
		$CONN->Execute($str) or user_error($str, 256);
	}

	//�P�_�O�_���зǼҲ�
	$is_stand_module=is_stand_module($MODULE_DIR,$_POST['dirname']);

	if($is_stand_module){
		// �s�W�Ҳտﶵ�]�w
		get_sfs_module_set($_POST['dirname']);

		// �s�W sfs_text �O��($SFS_TEXT_SETUP�]�O�bmodule-cfg���]�w)
		if(isset($SFS_TEXT_SETUP) and is_array($SFS_TEXT_SETUP)){
			for ($i=1; $i<=count($SFS_TEXT_SETUP); $i++) {
				$arr=$SFS_TEXT_SETUP[$i-1];
				$pm_g_id = trim($arr['g_id']);
				$pm_item = trim($arr['var']);
				$pm_arr = $arr['s_arr'];
				join_sfs_text($pm_g_id,$pm_item,$pm_arr) or trigger_error("$pm_item, �L�k�[�J�ﶵ�M�� !", E_USER_ERROR);
			}
		}
	}

	// �Y sql �ɦs�b�A�~�s�W��ƪ�
	$MODULE_SQL_FILE=$MODULE_DIR.$_POST['dirname']."/module.sql";
	if (file_exists($MODULE_SQL_FILE)) install_module_tb ($MODULE_SQL_FILE);

	//���s���͸��|��
	unlink($UPLOAD_PATH."Module_Path.txt");
	Creat_Module_Path();
	
	//���]�ϥΪ̪��A
	reset_user_state();
	return $msn;
}

// �۰ʦw�˼Ҳո�ƪ��禡
function install_module_tb($MODULE_SQL_FILE="") {
    global $SFS_PATH, $mysql_db;

	//�ˬd�O�_�w�˹L�F
	if(check_installed($_POST['module_store_path'])){
		user_error("$module_name �Ҳդw�g�w�ˡA�z�i�H�������A�w�ˡI", 256);
	}

	$sql_query = fread(fopen($MODULE_SQL_FILE, 'r'), filesize($MODULE_SQL_FILE));

	run_sql($sql_query, $mysql_db);

}

//�ˬd�O�_�w�˹L�F
function check_installed($module_name) {
	global $CONN;

	if ($module_path) {
		$sql="SELECT msn FROM sfs_module WHERE diename='$module_name'";
		$res=$CONN->Execute($sql) or user_error("���~�T���G �d�߼Ҳո�Ʈɦ����D!", 256);

		list($id)=$res->FetchRow();
		if ($id)			return true;
	}
	return false;
}
?>
