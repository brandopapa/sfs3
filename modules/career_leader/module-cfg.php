<?php

// $Id: module-cfg.php 5310 2009-01-10 07:57:56Z smallduh $

//---------------------------------------------------
//
// 1.�o�̩w�q�G�Ҳո�ƪ�W�� (�� "�Ҳ��v���]�w" �{���ϥ�)
//   �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//-----------------------------------------------
//
// �Y���@�ӥH�W�A�б��� $MODULE_TABLE_NAME �}�C�өw�q
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

//$MODULE_TABLE_NAME[0] = "career_self_ponder";  			//��ƪ�1
//$MODULE_TABLE_NAME[1] = "";				//��ƪ�2

//---------------------------------------------------
//
// 2.�o�̩w�q�G�Ҳդ���W�١A�к�²�R�W (�� "�Ҳ��v���]�w" �{���ϥ�)
//
// ���|��ܵ��ϥΪ�
//-----------------------------------------------

$MODULE_PRO_KIND_NAME = "�ͲP���ɯZ�ŷF���޲z";

// �ݭn�ϥκ޲z���v��
$MODULE_MAN=true;


//---------------------------------------------------
//
// 3. �o�̩w�q�G�Ҳժ���������T (�� "�۰ʧ�s�{��" ����)
//    �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//
//---------------------------------------------------

// �Ҳճ̫��s����
$MODULE_UPDATE_VER="1.0";

// �Ҳճ̫��s���
$MODULE_UPDATE="2013-07-24";


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
$school_menu_p["leader_input.php"]="�n��/�ק�F���O��";
$school_menu_p["leader_paste.php"]="�ֶK��Ǵ��F���O��";
//$school_menu_p["leader_list.php"]="�F���O���s��";


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
// ���Τ�k:
//   $M_SETUP=get_module_setup('�ҲզW��(��Ƨ��^��W��)');
//    �i�o�� $M_SETUP['PAGENUM']=10;
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

// ��2,3,4....�ӡA�̦������G 
$SFS_MODULE_SETUP[] = array('var'=>"input_method", 'msg'=>"�F���P�p�Ѯv�W�ٿ�J�覡", 'value'=>array(0=>'�ۥѿ�J',1=>'�ﶵ���w'));
$SFS_MODULE_SETUP[] = array('var'=>"name_list", 'msg'=>"�F���W�ٿﶵ", 'value'=>'�Z��,�ƯZ��,�����Ѫ�,�����Ѫ�,�åͪѪ�,�A�ȪѪ�,�`�ȪѪ�,�ưȪѪ�,�d�֪Ѫ�,��|�Ѫ�,���ɪѪ�,�S��A�Ȫ�{');
$SFS_MODULE_SETUP[] = array('var'=>"name_list2", 'msg'=>"�p�Ѯv�W�ٿﶵ", 'value'=>'���p�Ѯv,�^�y�p�Ѯv,�ƾǤp�Ѯv,�z�Ƥp�Ѯv,���|�p�Ѯv,�۵M�p�Ѯv,��|�p�Ѯv');

$SFS_MODULE_SETUP[] = array('var'=>"max_leader1", 'msg'=>"�C�Z�̦h�F���H��", 'value'=>'8');
$SFS_MODULE_SETUP[] = array('var'=>"max_leader2", 'msg'=>"�C�Z�̦h�p�Ѯv�H��", 'value'=>'8');


// $SFS_spppppppMODULE_SETUP[2] =
//	array('var'=>"ssss", 'msg'=>"tttt", 'value'=>1);

?>