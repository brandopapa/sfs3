<?php

// $Id: module-cfg.php 7742 2013-10-31 06:37:05Z smallduh $

// ��ƪ�W�٩w�q

$MODULE_TABLE_NAME[0] = "stud_absent";
$MODULE_PRO_KIND_NAME = "�ǥͥX�ʶԺ޲z";

// �Ҳճ̫��s����
$MODULE_UPDATE_VER="1.0";

// �Ҳճ̫��s���
$MODULE_UPDATE="2003-04-24";

// �O�_���t�μҲ�? �Y�]�� 1 �h�ӼҲդ��i�R��
$SYS_MODULE=1;

//---------------------------------------------------
// 4. �o�̽Щw�q�G�z�o��{���ݭn�Ψ쪺�G�ܼƩα`��
//---------------------------------------------------

$today=date("Y-m-d");

//�ؿ����{��
$school_menu_p = array(
"index.php"=>"���m�ҵn�O",
"index_group.php"=>"����n�O",
"stat.php"=>"���m�ҩ���",
"stat_all.php"=>"���m�Ҳέp",
"add_record.php"=>"�Ǵ����m�ҵn�O",
"add_record_person.php"=>"�ӤH�Ǵ����m�Ҹɵn",
"report.php"=>"���m�ҳ���",
"chc_prn_week.php"=>"�������ʽҶg����",
"week_abs_tol.php"=>"���g���p",
"semester_rank.php"=>"�����I�ǥ�"
);

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


$SFS_TEXT_SETUP[] = array(
"g_id"=>1,
"var"=>"���m�����O",
"s_arr"=>array("�m��","�ư�","�f��","�ల","����","���i�ܤO")
);
$SFS_MODULE_SETUP[0] = array("var"=>"report_line","msg"=>"�C�L�g����ɨC������","value"=>"13");
$SFS_MODULE_SETUP[1] = array("var"=>"default_uf","msg"=>"�w�]��ѧt�ɺX","value"=>array("1"=>"�O","0"=>"�_"));
$SFS_MODULE_SETUP[2] = array("var"=>"default_df","msg"=>"�w�]��ѧt���X","value"=>array("1"=>"�O","0"=>"�_"));
$SFS_MODULE_SETUP[3] = array("var"=>"ranks","msg"=>"�ƦW�C��H��","value"=>50);
?>
