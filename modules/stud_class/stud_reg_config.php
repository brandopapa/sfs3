<?php

	// $Id: stud_reg_config.php 7025 2012-12-03 03:50:16Z infodaes $

	//�t�γ]�w��
	include_once "../../include/config.php";
	include_once "../../include/sfs_case_PLlib.php";
	include_once "../../include/sfs_case_dataarray.php";

	//���o�Ҳճ]�w
	$m_arr = get_sfs_module_set("stud_eduh");
	extract($m_arr, EXTR_OVERWRITE);
	$m_arr = get_sfs_module_set();
	extract($m_arr, EXTR_OVERWRITE);
	
	$talk_length=$talk_length?$talk_length:50;

	//�ˬd�O�_������ IP
	if ($home_ip && !check_home_ip())	{
		header("Location: ".$SFS_PATH_HTML."err_home_ip.php");
	}

	// �ǥͷӤ��s�񪺥D�n�ؿ�
	$img_path="photo/student";
	$img_width = 120;
	
	//�ﶵ��ܦ��
	$chk_cols = 5;
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
	//�s�W���s�W��
	$sameBtn = "�P ���y�a�}";
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

	$eduh_input_method=$eduh_input_method?'stud_eduh_list.php':'stud_eduh_list_2.php';

	//�ؿ����{��
	$menu_p = array("stud_list.php"=>"�򥻸��","chi_edit2.php"=>"�t�s","stud_dom1.php"=>"��f���","stud_ext_data.php"=>"�ɥR���","stud_bs.php"=>"�S�̩j�f","stud_kinfolk.php"=>"��L����","basisdata_check.php"=>"�򥻸���ˬd","$eduh_input_method"=>"�Ǵ�����","stud_seme_talk2.php"=>"���ɳX��","stud_seme_spe2.php"=>"�S���{","stud_psy_test.php"=>"�ߴ��O��","stud_report1.php"=>"���y�O����","index2_html.php"=>"���ɰO����","chc_940531.php"=>"�������Z");

	function stud_class_err() {
		
		echo "<center><h2>�����@�~����ɮv���</h2>";
		echo "<h3>�Y���ðݽЬ� �t�κ޲z��</h3></center>";
	}	

?>
