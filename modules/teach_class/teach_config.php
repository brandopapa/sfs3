<?php
	// $Id: teach_config.php 7521 2013-09-14 08:57:38Z smallduh $
	//�t�γ]�w��
	include_once "../../include/config.php";
	//�禡�w
	include_once "../../include/sfs_case_PLlib.php";
	
	include_once "../../include/sfs_case_dataarray.php";
	//�s�W���s�W��
	$newBtn = " �s�W��� ";
	//�ק���s�W��
	$editBtn = " �T�w�ק� ";
	//�R�����s�W��
	$delBtn = " �T�w�R�� ";
	//�T�w�s�W���s�W��
	$postBtn = " �T�w�s�W ";
	//�s�W�ɱҥάy�����\��
	$is_IDauto = 1 ; // 0 ������	
	
	//�����]�w��ܵ���
	$gridRow_num = 16;
	//����橳��]�w
	$gridBgcolor="#DDDDDC";
	//�����k������C��
	$gridBoy_color = "blue";
	//�����k������C��
	$gridGirl_color = "#FF6633";
	//�Ӥ��e��
	$img_width = 120;	
	
	//�ؿ����{��
	$teach_menu_p = array("teach_list.php"=>"�򥻸��","teach_post.php"=>"��¾���","teach_connect.php"=>"�������","mteacher.php"=>"�פJ�Юv���","teach_list_photo.php"=>"�b¾�Юv�@����");
	
	//�]�w�W�ǹϤ����|
	$img_path = "photo/teacher";
	
	/* �W���ɮ׼Ȧs�ؿ� */
	$path_str = "temp/teacher";
	set_upload_path($path_str);
	$temp_path = $UPLOAD_PATH.$path_str;

	//���o�y����
	function get_sfs_id() {
		global $DEFAULT_TEA_ID_TITLE, $DEFAULT_TEA_ID_NUMS,$CONN;
		$sqlstr = "select max(teach_id) as mm from teacher_base ";
		if ($DEFAULT_TEA_ID_TITLE)
			$sqlstr .= " where teach_id like '$DEFAULT_TEA_ID_TITLE%'";
		$result = $CONN->Execute($sqlstr) or die ($sqlstr);
		
		$num = 1;
		for ($i=0;$i<strlen($DEFAULT_TEA_ID_NUMS);$i++)
			$num *= 10;
		
		if ($result->fields[0] == '' ) {//�Ĥ@��			
			$temp = $num+ intval($DEFAULT_TEA_ID_NUMS);
		}
		else {
			$temp = substr($result->fields[0],strlen($DEFAULT_TEA_ID_TITLE));
			$temp = $num + intval($temp)+1;		
		}
		$temp =  $DEFAULT_TEA_ID_TITLE.substr($temp,1);	
		return $temp;	
	}


	
?>
