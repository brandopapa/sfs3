<?php

// $Id: docup_config.php 5310 2009-01-10 07:57:56Z hami $

include "../../include/config.php";
include "../../include/sfs_case_dataarray.php";
include "../../include/sfs_case_PLlib.php";
include "./module-upgrade.php";

//�]�w�W�Ǹ��|
$filePath = set_upload_path("/school/docup");

//�]�w�W�Ǹ��|�Ȧs�ɮ�
$temp_filePath = set_upload_path("/tmp/docup");

//���o�Ҳճ]�w
$m_arr = get_sfs_module_set("docup");
extract($m_arr, EXTR_OVERWRITE);


/*	�v����O�禡
 *	@param $perr - string - �ǤJ�T�Ӧr���Ĥ@�r�����s�ճB��,�ĤG�r�����դ��H��,�ĤT�r���������ӻ�
 *	@param $ki - integer - 	�����O(1-�s�ճB��,2-�դ��H��,3-�����ӻ�)
 *	@param $pi - integer - 	�s�קO(1-�s��,2-�ק�,3-�R��)
 *	@return true or flase
 */
 
function getperr($perr,$ki,$pi){
	$vtemp = substr($perr,$ki-1,1);
	$vtemp = $vtemp >> ($pi-1);
	if ($vtemp % 2 == 1)
		return true;
	else
		return false;	
}

?>
