<?php

// $Id: config.php 5310 2009-01-10 07:57:56Z smallduh $

	//�t�γ]�w��
	include_once "./module-cfg.php";
	include_once "../../include/config.php";
	//�禡�w
	include "../../include/sfs_case_PLlib.php"; 
	
	require_once "./module-upgrade.php";
	  
  require_once "./my_functions.php";
  
  //���o�Ҳճ]�w
$m_arr = get_sfs_module_set("stud_eduh");
extract($m_arr, EXTR_OVERWRITE);
$m_arr = get_sfs_module_set("stud_class");
extract($m_arr, EXTR_OVERWRITE);

//�w�]�Ĥ@�Ӷ}�Ҧ~��
//$default_begin_class = 6;
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
?>
