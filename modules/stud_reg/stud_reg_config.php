<?php

//$Id: stud_reg_config.php 8529 2015-09-15 06:17:47Z hsiao $
//�t�γ]�w��
include_once "../../include/config.php";
//�禡�w
include_once "../../include/sfs_case_PLlib.php";
include_once "../../include/sfs_case_dataarray.php";
include_once "../../include/sfs_case_studclass.php";

//�ɯ��ˬd 
require "module-upgrade.php";

//�s�W���s�W��
$sameBtn = "�P ���y�a�}";
//�s�W���s�W��
$newBtn = " �s�W��� ";
//�ק���s�W��
$editBtn = " �T�w�ק� ";
//�R�����s�W��
$delBtn = " �T�w�R�� ";
//�T�w�s�W���s�W��
$postBtn = " �T�w�s�W ";
$editModeBtn = " �ק�Ҧ� ";
$browseModeBtn = " �s���Ҧ� ";
//�w�]���y
$default_country = "���إ���";
//�����]�w��ܵ���
$gridRow_num = 16;
//����橳��]�w
$gridBgcolor = "#DDDDDC";
//�����k������C��
$gridBoy_color = "blue";
//�����k������C��
$gridGirl_color = "#FF6633";
//�w�]�Ĥ@�Ӷ}�Ҧ~�� 
$default_begin_class = 6;
//�Ӥ��e��
$img_width = 120;

//�ؿ����{��

$menu_p = array("stud_list.php" => "�򥻸��", "chi_edit.php" => "��Z�s��", "chi_photo.php" => "�ۤ�", "stud_photo.php" => "�ۤ�2", "stud_dom1.php" => "��f���", "stud_ext_data.php" => "�ɥR���", "stud_bs.php" => "�S�̩j�f", "stud_kinfolk.php" => "��L����", "../stud_move/" => "�ǥͲ���", "stud_drop.php" => "���y��ƧR��", "../stud_query/check_error2.php" => "���y����ˬd^", "show_ext_data.php" => "�ɥR��ƺ޲z", "session_upload.php" => "���Ǧ~�צb�y�͸�ƤW�ǻO�����N�Ǻޱ��t��");

//�]�w�W���ɮ׸��|
$img_path = "photo/student";
$upload_str = set_upload_path("$img_path");

$modify_flag = true;
//�ˬd�O�_���޲z�v���H��
$sys_arr = get_sfs_module_set();
if ($sys_arr['edit_kind']) {
    if (!checkid($_SERVER['SCRIPT_FILENAME'], 1))
        $modify_flag = false;
}
//�ؿ����{��
if ($modify_flag) {
    $menu_p = array("stud_list.php" => "�򥻸��", "chi_edit.php" => "��Z�s��", "chi_photo.php" => "�ۤ�", "stud_photo.php" => "�ۤ�2", "stud_dom1.php" => "��f���", "stud_ext_data.php" => "�ɥR���", "stud_bs.php" => "�S�̩j�f", "stud_kinfolk.php" => "��L����", "session_upload.php" => "���Ǧ~�צb�y�͸�ƤW�ǻO�����N�Ǻޱ��t��", "../stud_move/" => "�ǥͲ���", "stud_drop.php" => "���y��ƧR��", "../stud_query/check_error2.php" => "���y����ˬd^", "show_ext_data.php" => "�ɥR��ƺ޲z",);
} else {
    $menu_p = array("stud_list.php" => "�򥻸��", "chi_edit.php" => "��Z�s��", "stud_dom1.php" => "��f���", "stud_ext_data.php" => "�ɥR���", "stud_bs.php" => "�S�̩j�f", "stud_kinfolk.php" => "��L����", "session_upload.php" => "���Ǧ~�צb�y�͸�ƤW�ǻO�����N�Ǻޱ��t��");
}
?>
 