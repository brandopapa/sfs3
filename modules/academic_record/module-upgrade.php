<?php
// $Id: module-upgrade.php 7198 2013-03-06 07:09:51Z smallduh $

if(!$CONN){
        echo "go away !!";
        exit;
}

// �N�w�]�����Z����y�����]���۰ʨ��o���y

// �ˬd��s�_
// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");

//�R�� seme_year_seme �~�� 991,992���T�X���ת����
$up_file_name =$upgrade_str."2013-03-06.txt";

if (!is_file($up_file_name)){
	$query = "delete FROM `stud_seme_rew` WHERE length( seme_year_seme ) =3;";
	if ($CONN->Execute($query)) {
		$temp_query = "�R�� seme_year_seme �~�� 991,992���T�X���ת���� -- by smallduh (2013-03-06)\n$query";
		$fp = fopen ($up_file_name, "w");
		fwrite($fp,$temp_query);
		fclose ($fd);
	}
}


//��s�ǲߴy�z���O,���t�Υi�H�۰ʨ��o�U��y�z���
$up_file_name =$upgrade_str."2003-06-08.txt";

if (!is_file($up_file_name)){
	$query = "update score_input_col set interface_sn=1,col_text='�ǲߴy�z��r����',col_value='',col_type='text',col_fn='get_ss_score_memo',col_ss='y',col_comment='n',col_check='0',col_date=now() where col_sn = '27'";
	if ($CONN->Execute($query)) {
		$temp_query = "��s�ǲߴy�z���O,���t�Υi�H�۰ʨ��o�U��y�z��� -- by hami (2003-06-08)\n$query";
		$fp = fopen ($up_file_name, "w");
		fwrite($fp,$temp_query);
		fclose ($fd);
	}
}

// �إߩM�洫��ƵL�������Z�ﶵ
// �b stud_seme_abs �[�J�@�� abs_kind �� primary key 
$up_file_name =$upgrade_str."2003-06-22.txt";

if (!is_file($up_file_name)){
	$query = array();
	$query[0] = "ALTER TABLE `stud_seme_abs` CHANGE `abs_kind` `abs_kind`TINYINT( 3 ) UNSIGNED NOT NULL ;";
	$query[1] = "ALTER TABLE `stud_seme_abs` DROP PRIMARY KEY,ADD PRIMARY KEY ( seme_year_seme, stud_id, `abs_kind` )";
	$temp_str = '';
	for($i=0;$i<count($query);$i++) {	
		if ($CONN->Execute($query[$i]))
			$temp_str .= "$query[$i]\n ��s���\ ! \n";
		else
			$temp_str .= "$query[$i]\n ��s���� ! \n";
	}
	$temp_query = "�ץ��ǥ;Ǵ��X�ʮu�`���D�n�� -- by hami (2003-06-22)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);
	
}

// �®榡�ഫ
$up_file_name =$upgrade_str."2003-06-20.txt";

if (!is_file($up_file_name)){
	$temp_str = "���� up_acad.php";
	require "up_acad.php";
	$temp_query = "�®榡�ഫ -- by hami (2003-06-20)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);
}

//���y��ƪ�teacher_id���A�ץ�
$up_file_name =$upgrade_str."2003-09-25.txt";

if (!is_file($up_file_name)){
	$query = array();
	$query[0] = "ALTER TABLE `comment_kind` CHANGE `kind_teacher_id` `kind_teacher_id` VARCHAR( 20 ) DEFAULT NULL";
	$query[1] = "ALTER TABLE `comment_level` CHANGE `level_teacher_id` `level_teacher_id` VARCHAR( 20 ) DEFAULT NULL";
	$query[2] = "ALTER TABLE `comment` CHANGE `teacher_id` `teacher_id` VARCHAR( 20 ) DEFAULT NULL ";
	$temp_str = '';
	for($i=0;$i<count($query);$i++) {	
		if ($CONN->Execute($query[$i]))
			$temp_str .= "$query[$i]\n ��s���\ ! \n";
		else
			$temp_str .= "$query[$i]\n ��s���� ! \n";
	}
	$temp_query = "���y������ƪ�comment,comment_kind,comment_level��쫬�A��s -- by jrh (2003-09-25)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);
}	
?>
