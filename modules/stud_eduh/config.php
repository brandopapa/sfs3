<?php

// $Id: config.php 7024 2012-12-03 03:11:06Z infodaes $

require_once "./module-cfg.php";

include_once "../../include/config.php";
include_once "../../include/sfs_case_PLlib.php";
//�ɯ��ˬd 
require "module-upgrade.php";

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
//$menu_p = array("stud_eduh_personal.php"=>"�ӤH���ɰO���C��","stud_eduh_list.php"=>"�ǥͻ��ɰO��","stud_seme_talk2.php"=>"�ǥͳX�ͰO��","stud_seme_spe2.php"=>"�S���{�O��","stud_seme_test.php"=>"�߲z����O��","stud_psy_tran.php"=>">>���>>","stud_psy_test.php"=>"�߲z����O��(XML3.0�s)","index2.php"=>"���ɰO����","stud_eduh_report.php"=>"�a�x���p�έp");
$menu_p = array("stud_eduh_personal.php"=>"�ӤH���ɰO���C��",
"stud_eduh_list.php"=>"�ǥͻ��ɰO��","stud_seme_talk2.php"=>"�ǥͳX�ͰO��",
"chc_talk_all.php"=>"�X�ͰO��(��)","stud_seme_spe2.php"=>"�S���{�O��",
"stud_psy_tran.php"=>"XML3.0���","stud_psy_test.php"=>"�߲z����O��",
"index2.php"=>"���ɰO����","index2_html.php"=>"���������ɰO����","index2_add.php"=>"���ɳX�ͰO���K�� ","stud_eduh_report.php"=>"�a�x���p�έp","stud_psy_test_list.php"=>"�߲z����O���K��");

