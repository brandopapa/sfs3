<?php
// $Id: create_data_config.php 7547 2013-09-19 03:35:30Z hami $
include_once "../../include/config.php";
include_once "../../include/sfs_case_PLlib.php";
include_once "create_data_function.php";

/* �W���ɮ׼Ȧs�ؿ� */
$path_str = "temp/student/";
set_upload_path($path_str);
$temp_path = $UPLOAD_PATH.$path_str;
$menu_p = array("mstudent2.php"=>"�פJ�ǥ͸��","trans_dos.php"=>"�פJ�Ш|�U���ǥ͸��","explode_stu.php"=>"��X�U�ת����","old_seme.php"=>"�ɥH�e���Ǵ����");

//���o�����m��}�C
function get_zip_arr() {
	global $CONN;
	$query = "select zip,country,town from stud_addr_zip order by zip";
	$res= $CONN->Execute($query) or trigger_error("�y�k���~!",E_USER_ERROR);
	while(!$res->EOF){
		$zip_arr[$res->fields[0]] = $res->fields[1].$res->fields[2];
		$res->MoveNext();
	}
	return $zip_arr;
}

//���o�����m���� zip �}�C
function get_addr_zip_arr() {
	global $CONN;
	$query = "select zip,country,town from stud_addr_zip order by zip";
	$res= $CONN->Execute($query) or trigger_error("�y�k���~!",E_USER_ERROR);
	while(!$res->EOF){
		$addr =   $res->fields[1].$res->fields[2];
		$zip_arr[$addr]=$res->fields[0] ;
		//$zip_arr[$res->fields[0]] = $res->fields[1].$res->fields[2];
		$res->MoveNext();
	}
	return $zip_arr;
}
?>
