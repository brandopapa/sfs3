<?php

//$Id: sfs_upgrade_list.php 8551 2015-10-07 02:19:09Z qfon $

if(!$CONN){
        echo "go away !!";
        exit;
}

// ���ɮ׬��t�έ��n��s�ɮ�,��s�O���N�۰ʼg�J �W���ɮץؿ� $UPLOAD_PATH/upgrade/include �U
// �w�]�ɯŵ{���ؿ��b sfs3/include/upgrade_files/

// ��s�O���ɸ��|
$upgrade_path = "upgrade/include/";
$upgrade_str = set_upload_path("$upgrade_path");

$temp_str ="2003-06-24 ��s�ǥ;Ǵ��O���� stud_seme , �[�J student_sn ���,�� stud_base�Pstud_seme ��Ӫ�P�B,��K��Ƭd�� - by hami \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20030624.php";
$up_file_name =$upgrade_str."2003-06-24.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20030624.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�p���վ� pro_check_new ��,�վ�
$temp_str ="2003-06-27 �վ� pro_check_new �ݩ� by hami \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20030627.php";
$up_file_name =$upgrade_str."2003-06-27.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20030627.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//��sreward,
$temp_str ="2003-11-28 ��s reward �� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20031128.php";
$up_file_name =$upgrade_str."2003-11-28.txt";
if ($CONN->Execute("select * from reward where 1=0")) {
	if (!is_file($up_file_name)){
		require dirname(__FILE__)."/upgrade_files/up20031128.php";
		$fp = fopen ($up_file_name, "w");
		fwrite($fp,$temp_str);
		fclose ($fp);
	}
}

//��s���� @2006-10-11
$temp_str ="2003-12-05 �] course_table ��|�A����, �G����s���� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20031205.php";
$up_file_name =$upgrade_str."2003-12-05.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20031205.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//����course_table, �ë�time_table���s�Ҫ�]�w���w��
$temp_str ="2003-12-06 ���� course_table ��, �ë� time_table by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20031206.php";
$up_file_name =$upgrade_str."2003-12-06.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20031206.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�إߥ��Ǵ�name_list
$temp_str ="2003-12-30 �إ� name_list �� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20031230.php";
$up_file_name =$upgrade_str."2003-12-30.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20031230.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�bstud_absent���W�[month���A�H�K�p�����
$temp_str ="2004-01-02 �b stud_absent ���W�[ month ��� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20040102.php";
$up_file_name =$upgrade_str."2004-01-02.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20040102.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�bcourse_table���W�[���A�H�K�ΨӰt��
$temp_str ="2004-01-30 �b course_table ���W�[sections, test_times, ratio_chg, times_chg, year, semester��� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20040102.php";
$up_file_name =$upgrade_str."2004-01-30.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20040130.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�ק��`��{�����檺�ݩ�
$temp_str ="2004-04-19 �ק� seme_score_nor �� score1~score7 ���ݩ� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20040419.php";
$up_file_name =$upgrade_str."2004-04-19.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20040419.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�W�[�l���ϸ���
$temp_str ="2004-04-29 �b stud_base ���W�[ addr_zip �� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20040429.php";
$up_file_name =$upgrade_str."2004-04-29.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20040429.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�b�ǥͲ��ʪ��W�[ student_sn ��
$temp_str ="2004-05-13 �b stud_move ���W�[ student_sn �� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20040513.php";
$up_file_name =$upgrade_str."2004-05-13.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20040513.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�ץ��������Z����class_id���~
$temp_str ="2004-07-14 �ץ��������Z����class_id���~ by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20040714.php";
$up_file_name =$upgrade_str."2004-07-14.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20040714.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�N�ǥͬ�����ƪ�[�J student_sn
/*
$temp_str ="2004-07-25 �N�ǥͬ�����ƪ�[�J student_sn by hami \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20040725.php";

$up_file_name =$upgrade_str."2004-07-25.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20040725.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fd);
}
*/

//�ץ��Ǧ����ʪ���student_sn���g�J���T��
$temp_str ="2004-08-14 �ץ��Ǧ����ʪ���student_sn�����T�� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20040814.php";
$up_file_name =$upgrade_str."2004-08-14.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20040814.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�bscore_course���W�[c_kind���, �O���Ӹ`�O0:���`�ɼ�, 1:�ݽ�, 2:�N��
$temp_str ="2004-09-01 �bscore_course���W�[c_kind��� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20040901.php";
$up_file_name =$upgrade_str."2004-09-01.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20040901.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

// �P�B�ǥͲ����� (stud_move) �P���y�O���� (stud_base) ���
$temp_str ="2004-09-27 �B�ǥͲ����� (stud_move) �P���y�O���� (stud_base) ��� ".dirname(__FILE__)."/upgrade_files/up20040927.php";
$up_file_name =$upgrade_str."2004-09-27.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20040927.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�s�W�}�Ǥ�ε��~��
$temp_str ="2004-10-01 �s�W�}�Ǥ�ε��~�� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20041001.php";
$up_file_name =$upgrade_str."2004-10-01.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20041001.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�ץ��M��ЫǷs�W����`���楼�إߪ����~
$temp_str ="2004-12-01 �ץ��M��ЫǷs�W����`���楼�إߪ����~ by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20041201.php";
$up_file_name =$upgrade_str."2004-12-01.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20041201.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�ץ��t�νվ����榡
$temp_str ="2005-04-06  �ץ��t�νվ����榡 by hami \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20050406.php";
$up_file_name =$upgrade_str."2005-04-06.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20050406.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//��s���� @2006-10-11
$temp_str ="2005-09-04 ��s����up20051014 by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20050904.php";
$up_file_name =$upgrade_str."2005-09-04.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20050904.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�N�X�ͦa�[�J�t�οﶵ�M��
$temp_str ="2005-10-06 �N�X�ͦa�[�J�t�οﶵ�M�� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20051006.php";
$up_file_name =$upgrade_str."2005-10-06.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20051006.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�b���y��Ƥ��[�Jstudent_sn
$temp_str ="2005-10-14 �b���y��Ƥ��[�Jstudent_sn by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20051014.php";
$up_file_name =$upgrade_str."2005-10-14.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20051014.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�b�S�̩j�f��Ƥ��[�Jstudent_sn
$temp_str ="2005-10-17 �b�S�̩j�f��Ƥ��[�Jstudent_sn by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20051017.php";
$up_file_name =$upgrade_str."2005-10-17.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20051017.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�b��L���ݸ�Ƥ��[�Jstudent_sn
$temp_str ="2005-10-18 �b��L���ݸ�Ƥ��[�Jstudent_sn by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20051018.php";
$up_file_name =$upgrade_str."2005-10-18.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20051018.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�Nteacher_base����login_pass�אּ�Hmd5����B��
$temp_str ="2005-12-28 �Nteacher_base����login_pass�אּ�Hmd5����B�� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20051228.php";
$up_file_name =$upgrade_str."2005-12-28.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20051228.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�Nstud_seme_score_oth,stud_seme_rew,stud_seme_score_nor�T��ƪ�s�W�I��academic_record���ܨt��
$temp_str ="2006-09-19 �Nstud_seme_score_oth,stud_seme_rew,stud_seme_score_nor�T��ƪ�s�W�I��academic_record���ܨt�� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20060919.php";
$up_file_name =$upgrade_str."2006-09-19.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20060919.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�bstud_move���s�W��X�J�������
$temp_str ="2006-10-12 �bstud_move���s�W��X�J������� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20061012.php";
$up_file_name =$upgrade_str."2006-10-12.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20061012.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�bstud_base���W�[�^��m�W�B���y�E�J������
$temp_str ="2006-10-24 �bstud_base���W�[�^��m�W�B���y�E�J������ by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20061024.php";
$up_file_name =$upgrade_str."2006-10-24.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20061024.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�b stud_domicile ��s student_sn ���
$temp_str ="2006-10-28 �bstud_domicile ���� student_sn ��� by hami \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20061028.php";
$up_file_name =$upgrade_str."2006-10-28.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20061028.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�[�J�ˮ֪��ƪ�
$temp_str ="2006-11-26 �[�J�ˮ֪��ƪ� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20061126.php";
$up_file_name =$upgrade_str."2006-11-26.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20061126.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�[�J�۰ʭץ��ˮ֪��ƪ�
$temp_str ="2007-01-05 �[�J�۰ʭץ��ˮ֪��ƪ� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20070105.php";
$up_file_name =$upgrade_str."2007-01-05.txt";
if (!is_file($up_file_name)){
        require dirname(__FILE__)."/upgrade_files/up20070105.php";
        $fp = fopen ($up_file_name, "w");
        fwrite($fp,$temp_str);
        fclose ($fp);
}

//�X���ˮ֪��r
$temp_str ="2007-01-14 �X���ˮ֪��r by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up20070114.php";
$up_file_name =$upgrade_str."2007-01-14.txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up20070114.php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�[�J���~�n�J��ƪ�
$dstr="2007-01-15";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr." �[�J���~�n�J��ƪ� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�[�J�]�w�g�O��ƪ�
$dstr="2007-01-25";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr." �[�J�]�w�g�O��ƪ� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�b�ǥ;Ǵ����g�������[�Jstudent_sn���
//�o�O�@�ӯS����s, �]����ƶq�L�h, �ҥH�C���u�B�z10�ӤH, �@���n�쵥�짹���B�z��, �������t�פ~�|��_
$dstr="2007-04-03";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr." �b�ǥ;Ǵ����g�������[�Jstudent_sn��� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$query="select count(student_sn) from stud_seme_rew where student_sn=0";
	$res=$CONN->Execute($query);
	if ($res->fields[0]==0) {
		$fp = fopen ($up_file_name, "w");
		fwrite($fp,$temp_str);
		fclose ($fp);
	}
}

//���stud_base��primary key
$dstr="2007-04-12";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr." ���stud_base��primary key by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�إ�class_comment_admin��
$dstr="2007-06-27";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr." �إ�class_comment_admin�� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�ץ�stud_addr_zip���T�����
$dstr="2008-03-22";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr." �ץ�stud_addr_zip���T�����, ���O�N�_��, ���, �n�٧令�_�ٰ�, ��ٰϤΫn�ٰ� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
        require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
        $fp = fopen ($up_file_name, "w");
        fwrite($fp,$temp_str);
        fclose ($fp);
}

//�R�����p�����
$dstr="secure";
$temp_str ="�R�����p����� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/".$dstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/".$dstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�R�� Module_Path.php ��
$dstr="secure_path";
$temp_str ="�R�� data �U Module_Path.php by hami \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/".$dstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/".$dstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}


//�W�[ stud_absent_move ��ƪ�
$dstr="stud_absent_move";
$temp_str ="�W�[ stud_absent_move ��ƪ� (��ǥʹ����ʮu��) by infodaes \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/".$dstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/".$dstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}


//�W�[ association ��ƪ�(XML�洫  �������ΰO���Ȧs��)
$dstr="association";
$temp_str ="�W�[ association ��ƪ� (���ΰѥ[������) by infodaes \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/".$dstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/".$dstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�W�[ reward_exchange ��ƪ�(XML�洫   �������g�Ȧs��)
$dstr="reward_exchange";
$temp_str ="�W�[ reward_exchange ��ƪ�(XML�洫 �������g�Ȧs��) by infodaes \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/".$dstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/".$dstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�ץ�sfs_text ��ƪ�   �ݻ�==>���� (XML3.0�w�q)
$dstr="sfs_text_correction_1";
$temp_str ="�ץ�sfs_text ��ƪ�   �ݻ�==>���� (XML3.0�w�q) by infodaes \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/".$dstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/".$dstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�إ�login_log_new��
$dstr="2009-09-21";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr." �إ�login_log_new�� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�blogin_log_new��s�Wip���
$dstr="2009-09-22";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr." �blogin_log_new��s�Wip��� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//����login_log_new��
$dstr="2009-10-21";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr." ����login_log_new�� by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//��stud_base��addr_zip�����קאּ5
$dstr="2009-12-15";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr." ��stud_base��addr_zip�����קאּ5 by brucelyc \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//��� �t�οﶵ�� �ۺq->�q��
$dstr="2010-08-02";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr." ��sfs_text �� �t�οﶵ�� �ۺq->�q�� \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//��stud_domicile���D��אּstudent_sn
$dstr="2010-08-15";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr." ��stud_domicile���D��אּstudent_sn \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//��data�ؿ�����php�ɧR��
$dstr="2010-09-01";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr." ��data�ؿ�����php�ɧR�� \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�W�[ stud_move_import�Bstud_seme_import�Bstud_seme_final_score��ƪ�
$dstr="2010-09-02";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr." �W�[ stud_move_import�Bstud_seme_import�Bstud_seme_final_score��ƪ� \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�ˬd�ǰȨt�Ϊ���
$dstr="2010-09-14";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr." �ˬd�ǰȨt�Ϊ��� \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	//$fp = fopen ($up_file_name, "w");
	//fwrite($fp,$temp_str);
	//fclose ($fp);
}

//�W�[�ǥͳX�ͰO����student_sn�Binterview���  �íץ����
$dstr="2011-05-03";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr." ���teach_id��teacher_sn \n �W�[�ǥͳX�ͰO����student_sn�Binterview��� \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�ץ������X�֫�l�F�ϸ��a�}�ѷӪ�
$dstr="2011-08-11";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr." �ץ������X�֫�l�F�ϸ��a�}�ѷӪ� \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�W�[���ɦ��Z���ذѷӥ\��
$dstr="2011-10-06";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr." �W�[���ɦ��Z���ذѷӥ\�� \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}


//�ɥ��W�[���ɦ��Z���ذѷӥ\��
$dstr="2011-10-11";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr." �ɥ��W�[���ɦ��Z���ذѷӥ\��SQL�h�F`�r���H�P�L�k���T��s���D! \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�W�[�ҵ{�]�wscore_ss�C�g�`���O�����
$dstr="2011-10-18";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr."�W�[�ҵ{�]�wscore_ss�C�g�`���O�����! \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�W�[�۵M�H���ҧǸ����
$dstr="2012-06-01";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr."�W�[�۵M�H���ҧǸ����! \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�W�[�Ҳջ{�ұj�����
$dstr="2012-06-02";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr."�W�[�Ҳջ{�ұj�����! \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�W�[�Ӹ�O����
$dstr="2012-07-10";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr."�W�[�Ӹ�O����pipa! \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}
//�ץ��Ӹ�O����pipa����
$dstr="2012-07-11";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr."�ץ��Ӹ�O����pipa���� \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�W�[�Ӹ�O����
$dstr="2012-07-12";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr."�W�[�Ӹ�O����pipa! \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�ץ��O����406-408 �ϰ�W
$dstr="2012-08-25";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr."�ץ��O����406-408 �ϰ�W! \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�ץ��O����406-408 �ϰ�W
$dstr="2012-09-23";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr."�s�W�{�ҼҦ���� \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//sfs_text�W�[�ͲP���ɬ���101�Ǧ~���ﶵ
$dstr="2013-01-29";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr."�s�W�{�ҼҦ���� \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�ǥͱK�X���קאּ32�Ӧr��
$dstr="2013-02-20";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr."�s�W�{�ҼҦ���� \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�h��`stud_base`.stud_study_year��쪺UNSIGNED�ݩ�
$dstr="2013-02-25";
$dsstr=str_replace("-","",$dstr);
$temp_str =$dstr."�h��`stud_base`.stud_study_year��쪺UNSIGNED�ݩ� \n ��s�ɦ�m: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

//�h��`stud_base`.stud_study_year��쪺UNSIGNED�ݩ�
$dstr="2013-08-22";
$dsstr=str_replace("-","",$dstr);
$temp_str = "teacher_title �[�W rank �Ƨ����: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}


// �[�J�Юv�ǥ� sha 256 ���
$dstr="2013-09-18";
$dsstr=str_replace("-","",$dstr);
$temp_str = "teacher_base stud_base �[�W edu_key ���: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

// �[�J�Юv�ǥ� md5 �K�X
$dstr="2013-09-20";
$dsstr=str_replace("-","",$dstr);
$temp_str = "���s�ɯ� teacher_base stud_base �[�W ldap_password ���: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

// �إ߮v�ͱb����� view
$dstr="2013-10-11";
$dsstr=str_replace("-","",$dstr);
$temp_str = "�إ߮v�ͱb����� view ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

// �إ߾ǮդW�Ҥ����
$dstr="2013-10-29";
$dsstr=str_replace("-","",$dstr);
$temp_str = "�إ߾ǮդW�Ҥ���� ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}


// �ˬd���ɳX�ͰO����interview���O�_�����
$dstr="2014-08-03";
$dsstr=str_replace("-","",$dstr);
$temp_str = "�ˬd���ɳX�ͰO����interview���O�_����� ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}

// �R���s�ͶפJ��ƼȦs��
$dstr="2014-09-15";
$dsstr=str_replace("-","",$dstr);
$temp_str = "�R���s�ͶפJ��ƼȦs�� ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
    require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
    $fp = fopen ($up_file_name, "w");
    fwrite($fp,$temp_str);
    fclose ($fp);
}


// �ǥͰ򥻸�ƥ[�J ���y���o��]�B�Ӯ׫O�@���O ���

$dstr="2014-10-08";
$dsstr=str_replace("-","",$dstr);
$temp_str = "�ǥͰ򥻸�ƥ[�J ���y���o��]�B�Ӯ׫O�@���O ���: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}


$dstr="2015-10-04";
$dsstr=str_replace("-","",$dstr);
$temp_str = "�ե����~�ͬy�����קK�Ǹ��Q�~���ư��D: ".dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
$up_file_name =$upgrade_str.$dstr.".txt";
if (!is_file($up_file_name)){
	require dirname(__FILE__)."/upgrade_files/up".$dsstr.".php";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_str);
	fclose ($fp);
}




?>
