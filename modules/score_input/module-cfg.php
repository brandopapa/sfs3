<?php

// $Id: module-cfg.php 6819 2012-06-22 08:57:13Z infodaes $

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


$MODULE_PRO_KIND_NAME = "���Z�޲z";
//���Ҳն��Ϥ��޲z�v
$MODULE_MAN = 1 ;

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

//���n�ҲաA�K�Q�ŧR
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

// $SFS_MODULE_SETUP[1] =
//	array('var'=>"xxxx", 'msg'=>"yyyy", 'value'=>0);

// $SFS_MODULE_SETUP[2] =
//	array('var'=>"ssss", 'msg'=>"tttt", 'value'=>1);

$IS_MODULE_ARR = array("n"=>"�_","y"=>"�O");
$IS_MODULE_ARR2 = array("y"=>"�O","n"=>"�_");
$SFS_MODULE_SETUP[0] =array('var'=>"yorn", 'msg'=>"�O�_�C����Ұt�X�@�����ɦ��Z", 'value'=>$IS_MODULE_ARR2);
$SFS_MODULE_SETUP[1] =array('var'=>"is_allow", 'msg'=>"�O�_�}���(�M)���Ѯv���v���ť��Ѯv(�ɮv)��令�Z", 'value'=>$IS_MODULE_ARR);
$SFS_MODULE_SETUP[2] =array('var'=>"is_print", 'msg'=>"�O�_�}���(�M)���Ѯv�[�ݦU�Z���Z��", 'value'=>$IS_MODULE_ARR);
$SFS_MODULE_SETUP[3] =array('var'=>"is_new_nor", 'msg'=>"���\���Ҫ̦ۦ�W�[�ΧR�����ɦ��Z����", 'value'=>$IS_MODULE_ARR2);
$SFS_MODULE_SETUP[4] =array('var'=>"is_mod_nor", 'msg'=>"���\���Ҫ̦ۦ�ק省�ɦ��Z���ئW�٩Υ[�v", 'value'=>$IS_MODULE_ARR2);
$SFS_MODULE_SETUP[5] =array('var'=>"pic_checked", 'msg'=>"�n�����Z����ܤj�Y��", 'value'=>array("0"=>"�_","1"=>"�O"));
$SFS_MODULE_SETUP[6] =array('var'=>"pic_width", 'msg'=>"�j�Y����ܪ��e��", 'value'=>'60');
?>