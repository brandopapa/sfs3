<?php

// $Id: config2.php 5310 2009-01-10 07:57:56Z hami $

require_once "./module-cfg.php";

include_once "../../include/config.php";
include_once "../../include/sfs_case_PLlib.php";
//���o�Ҳճ]�w
$m_arr = get_sfs_module_set("stud_eduh");
extract($m_arr, EXTR_OVERWRITE);		
	
 //�w�]�Ĥ@�Ӷ}�Ҧ~��
 $default_begin_class = 6;
 //�����]�w��ܵ���
 $gridRow_num = 16;
 //����橳��]�w
 $gridBgcolor="#DDDDDC";
//�����k������C��
 $gridBoy_color = "blue";
 //�����k������C��
 $gridGirl_color = "#FF6633";
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
$menu_p = array("stud_eduh_list.php"=>"�ǥͻ��ɰO��","stud_seme_talk2.php"=>"�ǥͳX�ͰO��","stud_seme_spe2.php"=>"�S���{�O��","stud_seme_test.php"=>"�߲z����O��","index2.php"=>"���ɰO����");
?>
