<?php
//$Id$
ini_set ('display_errors', 'off');
//�w�]���ޤJ�ɡA���i�����C
require_once "./module-cfg.php";
include_once "../../include/config.php";
//�z�i�H�ۤv�[�J�ޤJ��
// 
//���X�ǰȨt��, �D�����u�� UTF8 , �|�ܶýX
//mysql_query("SET NAMES 'utf8'");

//�ɮפU�����| �r�꥽�n�O�d / �Ÿ�
$path_str = "school_msn/";
set_upload_path($path_str);

$download_path=$UPLOAD_PATH."school_msn/"; 

//�q�l���ɤW�Ǧa�I
$UPLOAD_PIC=$UPLOAD_PATH."school_msn/pic/";
$UPLOAD_PIC_URL =$UPLOAD_URL."school_msn/pic/";
if (!is_dir($UPLOAD_PIC))	mkdir($UPLOAD_PIC,0700);

$PHP_FILE_ATTR="jpg;jpeg;png;gif;swf;wmv";

//Ū���Ҳ��ܼ� $MAX_MB , $PRESERVE_DAYS , $CLEAN_MODE
$m_arr = &get_sfs_module_set();
extract($m_arr, EXTR_OVERWRITE); 

//����O�_������IP
$insite_arr = explode(",",$insite_ip);
$is_home_ip = check_home_ip($insite_arr);

//Ū���i�W�Ǫ���j�p���� '' 
	$M1=ini_get('post_max_size');
	$M1=substr($M1,0,strlen($M1)-1);
	
	$M2=ini_get('upload_max_filesize');
	$M2=substr($M2,0,strlen($M2)-1);
	
	$MAX_MB=round(min($M1,$M2),2);  //��� MB

//�ܼ�
$ONLINE[0]="���u";
$ONLINE[1]="�W�u";

?>
