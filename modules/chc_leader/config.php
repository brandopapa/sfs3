<?php
//$Id$
//�w�]���ޤJ�ɡA���i�����C
require_once "./module-cfg.php";
include_once "../../include/config.php";
//�z�i�H�ۤv�[�J�ޤJ��

	//�^�����
function getLeaderKind($K){
	global $UPLOAD_PATH;
	$file=$UPLOAD_PATH.'school/chc_leader/var.txt';
	$kind['A']=array('�Z��','�ƯZ��','�d�֪Ѫ�','�����Ѫ�','�ưȪѪ�','�åͪѪ�','�����Ѫ�','���ɪѪ�','���O�Ѫ�','��T�Ѫ�');
	$kind['B']=array('��֪�','���ֹ�','�޼ֹ�','���ö�','�x�y��');
	$kind['C']=array('����','�ƪ���','����','�ƶ���');
	if ( $K!='A' && $K!='B' && $K!='C' ) return ;
	if (!file_exists($file)) :
		return $kind[$K]; 
	else:
		$str=file_get_contents ($file);
		$data=unserialize($str);
		return $data[$K];
	endif;
		
}

##################�^�W���禡1#####################
function backe($value= "BACK"){
	echo  "<head><meta http-equiv='Content-Type' content='text/html; charset=big5'></head><br><br><br><br><CENTER><form><input type=button value='".$value."' onclick=\"history.back()\" style='font-size:16pt;color:red;'></form><BR></CENTER>";
	exit;
}