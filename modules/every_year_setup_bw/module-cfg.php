<?php

// $Id: module-cfg.php 7733 2013-10-29 11:38:25Z smallduh $

//---------------------------------------------------
//
// 1.�o�̩w�q�G�Ҳո�ƪ�W�� (�� "�Ҳ��v���]�w" �{���ϥ�)
//   �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//-----------------------------------------------
//
// �Y���@�ӥH�W�A�б���  �}�C�өw�q
//
// �]�i�H�ΥH�U�o�س]�k�G
//
// $MODULE_TABLE_NAME=array(0=>"lunchtb", 1=>"xxxx");
// 
// $MODULE_TABLE_NAME[0] = "lunchtb";
// $MODULE_TABLE_NAME[1]="xxxx";
//
// �Ъ`�N�n�M module.sql ���� table �W�٤@�P!!!
//---------------------------------------------------

// ��ƪ�W�٩w�q

$MODULE_TABLE_NAME[0] = "";

//---------------------------------------------------
//
// 2.�o�̩w�q�G�Ҳդ���W�١A�к�²�R�W (�� "�Ҳ��v���]�w" �{���ϥ�)
//
// ���|��ܵ��ϥΪ�
//-----------------------------------------------


$MODULE_PRO_KIND_NAME = "�Ǵ���]�w_�ִ�����";


//---------------------------------------------------
//
// 3. �o�̩w�q�G�Ҳժ���������T (�� "�۰ʧ�s�{��" ����)
//    �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//
//---------------------------------------------------

// �Ҳճ̫��s����
$MODULE_UPDATE_VER="";

// �Ҳճ̫��s���
$MODULE_UPDATE="";

// �O�_���t�μҲ�? �Y�]�� 1 �h�ӼҲդ��i�R��
$SYS_MODULE=1;

//---------------------------------------------------
//
// 4. �o�̽Щw�q�G�z�o��{���ݭn�Ψ쪺�G�ܼƩα`��
//---------------------------------^^^^^^^^^^
//
// (���Q�Q "�ҲհѼƺ޲z" ���ު̡A�иm���)
//
// ��ĳ�G�о��q�έ^��j�g�өw�q�A�̦n�n��Ѧr���ݥX��N���N�q�C
//
// �o�Ϫ� "�ܼƦW��" �i�H�ۥѧ���!!!
//
//---------------------------------------------------

//�ؿ����{��
$dts=($IS_JHORES==6)?"�]�w�ɮv":"�]�w�ť��Ѯv";
$school_menu_p = array(
"setup_schoolday.php"=>"�}�Ǥ�]�w");
$school_menu_p["class_year_setup.php"]="�Z�ų]�w";
$school_menu_p["seme_date.php"]="�W�Ҥ�]�w";
$school_menu_p["score_setup.php"]="���Z�]�w";
$school_menu_p["ss_setup.php"]="�ҵ{�]�w";
//$school_menu_p["section_setup.php"]="�`�Ƴ]�w";
//$school_menu_p["auto_course_setup.php"]="�۰ʱƽ�";
$school_menu_p["classroom_setup.php"]="�M��Ыǳ]�w";
$school_menu_p["course_setup3.php"]="�Ҫ�]�w";
$school_menu_p["chc_teacher.v2.php"]=$dts;
$school_menu_p["section_time.php"]="�U�`�ɶ��]�w";

//�_�l�~��
$school_kind_start=1;

//�����~��
$school_kind_end=9;

//�~�ŭӼ�
$school_kind_name_n=($school_kind_end-$school_kind_start)+1;


//---------------------------------------------------
//
// 5. �o�̩w�q�G�w�]�ȭn�� "�ҲհѼƺ޲z" �{���ӱ��ު̡A
//    �Y���Q�A�i�����]�w�C
//
// �榡�G var �N���ܼƦW��
//       msg �N����ܰT��
//       value �N���ܼƳ]�w��
//
// �Y�z�M�w�N�o���ܼƥ�� "�ҲհѼƺ޲z" �ӱ��ޡA����z���Ҳյ{��
// �N�n��o���ܼƦ��P���A�]�N�O���G�Y�o���ܼƭȦb�ҲհѼƺ޲z�����ܡA
// �z���ҲմN�n�w��o���ܼƦ����P���ʧ@�ϬM�C
//
// �Ҧp�G�Y�d���O�ҲաA���ѨC����ܵ��ƪ�����A�p�U�G
// $SFS_MODULE_SETUP[1] =
// array('var'=>"PAGENUM", 'msg'=>"�C����ܵ���", 'value'=>10);
//
// �W�z���N��O���G�z�w�q�F�@���ܼ� PAGENUM�A�o���ܼƪ��w�]�Ȭ� 10
// PAGENUM ������W�٬� "�C����ܵ���"�A�o���ܼƦb�w�˼Ҳծɷ|�g�J
// pro_module �o�� table ��
//
// �ڭ̦����Ѥ@�Ө禡 get_module_setup
// �ѱz���Υثe�o���ܼƪ��̷s���p�ȡA
//
// �Ա��аѦ� include/sfs_core_module.php ���������C
//
// �o�Ϫ� "�ܼƦW�� $SFS_MODULE_SETUP" �Фŧ���!!!
//---------------------------------------------------

// =
//	array('var'=>"IS_STANDALONE", 'msg'=>"�O�_���W�ߪ��ɭ�(1�O,0�_)", 'value'=>0);


// ��2,3,4....�ӡA�̦������G 

$SFS_MODULE_SETUP[1] = array('var'=>"debug", 'msg'=>"�Ҫ�]�w����ܽҵ{�N�X", 'value'=>array(1=>"�O",0=>"�_"));
$SFS_MODULE_SETUP[2] = array('var'=>"FIN_SCORE_RATE_MODE", 'msg'=>"�p��Ǵ��U����`�����[�v�Ҧ�", 'value'=>array(0=>"�ǲ߻���ƥ���",1=>"�Ǥ����[�v����"));
$SFS_MODULE_SETUP[3] = array('var'=>"IS_CLASS_SUBJECT", 'msg'=>"���\�]�w�Z�Žҵ{?", 'value'=>array(0=>"�_",1=>"�O"));
$SFS_MODULE_SETUP[4] = array('var'=>"show_nor_items", 'msg'=>"��ܥ��ɦ��Z���ظ��?",'value'=>array(0=>"�_",1=>"�O"));
?>
