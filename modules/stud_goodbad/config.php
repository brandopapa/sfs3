<?php
// $Id: config.php 5310 2009-01-10 07:57:56Z hami $
	//�t�γ]�w��
	require_once "../../include/config.php";
	//�禡�w
	require_once "../../include/sfs_case_PLlib.php";    
	//�s�W���s�W��
	$newBtn = " �s�W��� ";
	//�ק���s�W��
	$editBtn = " �T�w�ק� ";
	//�R�����s�W��
	$delBtn = " �T�w�R�� ";
	//�T�w�s�W���s�W��
	$postMoveBtn = " �T�w���� ";
	$postInBtn = " �T�w��J ";
	$postOutBtn = " �T�w ";
	$postReinBtn = " �T�w�_�� ";
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
	//�w�]�Ĥ@�Ӷ}�үZ�� 
	$default_begin_class = "601";	
	//���O
	$gb_which_arr= array("���y"=>"���y","�g��"=>"�g��");
	//���g���O
	//$gb_kind_arr_g= array("3"=>"�j�\�@��","6"=>"�j�\�G��","9"=>"�j�\�T��","2"=>"�p�\�@��","5"=>"�p�\�G��","8"=>"�p�\�T��","1"=>"�ż��@��","4"=>"�ż��G��","7"=>"�ż��T��");
	//$gb_kind_arr_b= array("-3"=>"�j�L�@��","-6"=>"�j�L�G��","-9"=>"�j�L�T��","-2"=>"�p�L�@��","-5"=>"�p�L�G��","-8"=>"�p�L�T��","-1"=>"ĵ�i�@��","-4"=>"ĵ�i�G��","-7"=>"ĵ�i�T��");
	//$gb_kind_arr= array("3"=>"�j�\�@��","6"=>"�j�\�G��","9"=>"�j�\�T��","2"=>"�p�\�@��","5"=>"�p�\�G��","8"=>"�p�\�T��","1"=>"�ż��@��","4"=>"�ż��G��","7"=>"�ż��T��","-3"=>"�j�L�@��","-6"=>"�j�L�G��","-9"=>"�j�L�T��","-2"=>"�p�L�@��","-5"=>"�p�L�G��","-8"=>"�p�L�T��","-1"=>"ĵ�i�@��","-4"=>"ĵ�i�G��","-7"=>"ĵ�i�T��");
	$gb_kind_arr_g= array("big_good1"=>"�j�\�@��","big_good2"=>"�j�\�G��","big_good3"=>"�j�\�T��","s_good1"=>"�p�\�@��","s_good2"=>"�p�\�G��","s_good3"=>"�p�\�T��","ss_good1"=>"�ż��@��","ss_good2"=>"�ż��G��","ss_good3"=>"�ż��T��");
	$gb_kind_arr_b= array("big_bad1"=>"�j�L�@��","big_bad2"=>"�j�L�G��","big_bad3"=>"�j�L�T��","s_bad1"=>"�p�L�@��","s_bad2"=>"�p�L�G��","s_badd3"=>"�p�L�T��","ss_bad1"=>"ĵ�i�@��","ss_bad2"=>"ĵ�i�G��","ss_bad3"=>"ĵ�i�T��");
	$gb_kind_arr= array("big_good1"=>"�j�\�@��","big_good2"=>"�j�\�G��","big_good3"=>"�j�\�T��","s_good1"=>"�p�\�@��","s_good2"=>"�p�\�G��","s_good3"=>"�p�\�T��","ss_good1"=>"�ż��@��","ss_good2"=>"�ż��G��","ss_good3"=>"�ż��T��","big_bad1"=>"�j�L�@��","big_bad2"=>"�j�L�G��","big_bad3"=>"�j�L�T��","s_bad1"=>"�p�L�@��","s_bad2"=>"�p�L�G��","s_badd3"=>"�p�L�T��","ss_bad1"=>"ĵ�i�@��","ss_bad2"=>"ĵ�i�G��","ss_bad3"=>"ĵ�i�T��");
	//���Ŀn��
	$gb_score_arr = array("1"=>"���P�L","0"=>"�w�P�L");
	//�ɭ���
	$demote_arr = array("9"=>"�ɯ�","10"=>"����");
	//�_�����O
	$rein_arr= array("3"=>"�����_��","4"=>"��Ǵ_��");
	//�ؿ����{��
	$student_menu_p = array("stud_move.php"=>"��J","stud_move_out.php"=>"�եX","stud_move_rein.php"=>"�_��","stud_demote.php"=>"�ɭ���","stud_move_gradu.php"=>"���~��X","../stud_reg/"=>"���y�޲z");
	// �Ҳտ��
	$menu_p = array("addgood_gb.php"=>"���y�@�~","addbad_gb.php"=>"�g�٧@�~","gb_score_tools.php"=>"�P�L�B�z","print_gb_list.php"=>"�C�L�q����");	
?>