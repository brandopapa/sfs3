<?php

// $Id: config.php 7207 2013-03-10 14:33:59Z smallduh $

	//�t�γ]�w��
	include "../../include/config.php";
	//�禡�w
	include "../../include/sfs_case_PLlib.php"; 
	include  "../../include/sfs_oo_date.php";
	include_once "../../include/sfs_case_calendar.php";
	include_once "../../include/sfs_case_studclass.php";
	include "./my_fun.php";
	require_once "./module-upgrade.php";
	  
	//�s�W���s�W��
	$newBtn = " �s�W��� ";
	//�ק���s�W��
	$editBtn = " �T�w�ק� ";
	//�R�����s�W��
	$delBtn = " �T�w�R�� ";
	//�T�w�s�W���s�W��
	$postMoveBtn = " �T�w���� ";
	$postInBtn = " �T�w��J ";
	$postOutBtn = " �T�w���y ";
	$postOutBtn2 = " �T�w�g�� ";
	$postOutBtn3 = "�P�L";
	$postReinBtn = " �T�w�_�� ";
	$editModeBtn = " �ק�Ҧ� ";
	$browseModeBtn = " �s���Ҧ� ";
	$postcancel = "�P�L";	
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
	//�w�]�Ĥ@�Ӷ}�үZ�� 
	$default_begin_class = 1+$IS_JHORES."01";	
	//���y���O
	$reward_good_arr=array("1"=>"�ż��@��","2"=>"�ż��G��","3"=>"�p�\�@��","4"=>"�p�\�G��","5"=>"�j�\�@��","6"=>"�j�\�G��","7"=>"�j�\�T��");
	$reward_bad_arr=array("-1"=>"ĵ�i�@��","-2"=>"ĵ�i�G��","-3"=>"�p�L�@��","-4"=>"�p�L�G��","-5"=>"�j�L�@��","-6"=>"�j�L�G��","-7"=>"�j�L�T��");
	$reward_arr=array("1"=>"�ż��@��","2"=>"�ż��G��","3"=>"�p�\�@��","4"=>"�p�\�G��","5"=>"�j�\�@��","6"=>"�j�\�G��","7"=>"�j�\�T��","-1"=>"ĵ�i�@��","-2"=>"ĵ�i�G��","-3"=>"�p�L�@��","-4"=>"�p�L�G��","-5"=>"�j�L�@��","-6"=>"�j�L�G��","-7"=>"�j�L�T��");
	//�ؿ����{��
	$student_menu_p = array("reward_one.php"=>"�b�y�ͭӤH���g�n�O","reward_entrance.php"=>"��ǥͭӤH���g�ɵn","reward_group.php"=>"������g�n�O","reward_eli_new.php"=>"�P�L","reward_stud_all.php"=>"�ӤH���g����","add_record.php"=>"�Ǵ����g�ɵn","add_record_person.php"=>"�ӤH�Ǵ����g�ɵn","reward_list.php"=>"�g�٦C��","reward_total.php"=>"�ǥͼ��g�έp","report.php"=>"�C�L���g���i","reward_exchange.php"=>"��ǥʹ������g�פJ�O��");
	$student_menu_p2 = array("reward_eli.php"=>"���P�L�ǥ�","reward_eli2.php"=>"�w�P�L�ǥ�");
	
	$in_study="'0','15'";
?>
