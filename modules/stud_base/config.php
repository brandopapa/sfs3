<?php

// $Id: config.php 6674 2012-01-18 03:40:07Z infodaes $

	//�t�γ]�w��
	include_once "../../include/config.php";
	//�禡�w
	include_once "../../include/sfs_case_PLlib.php";
	include_once "../../include/sfs_case_dataarray.php";
	include_once "../../include/sfs_case_studclass.php";
	
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
	//�w�]�Ĥ@�Ӷ}�Ҧ~�� 
	$default_begin_class = 6;
	//�Ӥ��e��
	$img_width = 120;
	
	//�ؿ����{��
	$menu_p = array("stud_base.php"=>"�򥻸��","stud_dom1.php"=>"��f���","stud_bs.php"=>"�S�̩j�f","stud_kinfolk.php"=>"��L����","basisdata_check.php"=>"���y�򥻸�Ƨ�����ˬd");
	
	//�]�w�W���ɮ׸��|
	$img_path = "photo/student";
	$upload_str = set_upload_path("$img_path");
	
?>
