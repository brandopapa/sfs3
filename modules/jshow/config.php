<?php
// $Id: board_config.php 7779 2013-11-20 16:09:00Z smallduh $

	//�t�γ]�w��
	include_once "./module-cfg.php";
	include_once "../../include/config.php";
	require_once "../../include/sfs_case_PLlib.php";
	require_once "../../include/sfs_case_dataarray.php";

  //�Ҳէ�s��
  include "module-upgrade.php";
	
	//���J�ۤv���禡
	include_once "my_functions.php";

//���o�Ҳճ]�w
$m_arr = &get_sfs_module_set();
extract($m_arr, EXTR_OVERWRITE);

/* �W���ɮץت��ؿ� */
$path_str = "school/jshow/";
set_upload_path($path_str);

$USR_DESTINATION = $UPLOAD_PATH.$path_str;
$USR_DESTINATION_URL =$UPLOAD_URL.$path_str;
/*�U�����| */
$download_path = $UPLOAD_URL.$path_str;

//Ū���i�W�Ǫ���j�p���� '' 
	$query="SELECT @@global.max_allowed_packet";
	$res=$CONN->Execute($query);
	$M1=$res->fields(0);  //MySQL
	$M1=floor($M1/(1024*1024));
	
	$M2=ini_get('post_max_size');
	$M2=substr($M2,0,strlen($M2)-1);
	
	$M3=ini_get('upload_max_filesize');
	$M3=substr($M3,0,strlen($M3)-1);
	
	$Max_upload=round(min($M1,$M2,$M3)/1.34,2);
	

$DISPLAY_M[0]="�������Ϥ��̧Ǩq�X";
$DISPLAY_M[1]="�������Ϥ��̶üƨq�X";
$DISPLAY_M[2]="�̫��w����q�X�������S�w�Ϥ�";

$MON=array(1=>31,2=>29,3=>31,4=>30,5=>31,6=>30,7=>31,8=>31,9=>30,10=>31,11=>30,12=>31);

?>
