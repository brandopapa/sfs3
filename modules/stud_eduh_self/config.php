<?php

// $Id: config.php 8645 2015-12-17 02:22:47Z qfon $

//�t�γ]�w��
include_once "../../include/config.php";

//�禡�w
include_once "../../include/sfs_case_PLlib.php";
include_once "../../include/sfs_case_dataarray.php";
include_once "../../include/sfs_case_studclass.php";
require_once "./module-cfg.php";
require_once "./module-upgrade.php";


//���o�Ҳճ]�w
$m_arr = get_sfs_module_set("stud_eduh_self");
extract($m_arr, EXTR_OVERWRITE);


//�P�_�n�J�̬O�_���ǥ�
if ($_SESSION['session_who']!="�ǥ�") {
	echo "��p�A���Ҳեu���ǥ;ާ@�I";
	exit;
}


if($base_edit) $menu_p["stud_list_self.php"]="�򥻸��";
if($dom_edit) $menu_p["stud_dom1_self.php"]="��f���";
if($dom_edit) $menu_p["stud_bs_self.php"]="�S�̩n�f";
if($stud_eduh_editable) $menu_p["stud_eduh_self.php"]="���ɸ��";
if($club_enable) $menu_p["stud_club.php"]="���ά���";
if($service_enable) $menu_p["service_feedback.php"]="�A�Ⱦǲ�";
if($career_contact) $menu_p["career_contact.php"]="�p���q��";
if($mystory) $menu_p["mystory.php"]="�ڪ������G��";
if($psy_test) $menu_p["psy_test.php"]="�U���߲z����";
if($study_spe) $menu_p["study_spe.php"]="�ǲߦ��G�ίS���{";
if($career_view) $menu_p["career_view.php"]="�ͲP�ξ㭱���[";
if($career_evaluate) $menu_p["career_evaluate.php"]="�ͲP�o�i�W����";
if($career_guidance) $menu_p["career_guidance.php"]="�ͲP���ɿԸ߫�ĳ";
if($stage_score) $menu_p["stage_score.php"]="��춥�q���Z";
if($stud_view_self_absent) $menu_p["report1.php"]="���m�Ҭd��";
$menu_p["stud_cpass.php"]="���n�J�K�X";

$curr_month=','.date('m').',';


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
$gridBgcolor="#DDDDDC";
//�����k������C��
$gridBoy_color = "blue";
//�����k������C��
$gridGirl_color = "#FF6633";

//�]�w�W���ɮ׸��|
$img_path = "photo/student";
$upload_str = set_upload_path("$img_path");

//�L�oPOST��
foreach($_POST as $k=>$v) {
	if (!is_array($v)) {
		//���F�n�ѨM��޸����N��B�ͪ����D
		$v=str_replace("'", "@$@", $v);
		//�L�o--
		$_POST[$k]=str_replace(array("\\@$@","@$@","--"),array("","",""),$v);
	}
}

function ha_check(){
		if (!$_SESSION['stud_hacard_serial']){
			header("Location: readha.php");
		}else{
			return true;
		}
}



?>
