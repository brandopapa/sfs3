<?php
require "../../include/config.php";
// �ˬd php ����


if (!phpMinV('5.2.*')) {
	die('���{���Ȥ䴩 PHP 5.2 �H�W����, �ثe����:'. PHP_VERSION);
}


$menu_p = array('list.php' => '�C��', 'sign.php'=>'��Z', 'manager.php'=>'�޲z','parameter.php'=>'�]�w');
$fileExt = array('jpg','png','jpeg','gif');
$imageArr = array('0'=>'�a��','1'=>'�a�k');


//�޲z�ܼ�
$query = "SELECT * FROM artical_paramter";
$res = $CONN->Execute($query);
if ($res->fields['paramter'])
$PARAMSTER = unserialize($res->fields['paramter']);
else {
	// �C������
	$PARAMSTER['items_per_page'] = 10;
	$PARAMSTER['title'] = $school_sshort_name.'�ൣ';
	$PARAMSTER['image_width'] = 450;
}
$res = array();
/* �W���ɮץت��ؿ� */
$path_str = "school/artical/";
$uploadPath = set_upload_path($path_str);
$photo_path_str = "school/artical/photo/";
$photoUploadPath = set_upload_path($photo_path_str);

function phpMinV($v)
{
    $phpV = PHP_VERSION;

    if ($phpV[0] >= $v[0]) {
        if (empty($v[2]) || $v[2] == '*') {
            return true;
        } elseif ($phpV[2] >= $v[2]) {
            if (empty($v[4]) || $v[4] == '*' || $phpV[4] >= $v[4]) {
                return true;
            }
        }
    }

    return false;
}