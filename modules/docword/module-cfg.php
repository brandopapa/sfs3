<?php

// $Id: module-cfg.php 5310 2009-01-10 07:57:56Z hami $


//---------------------------------------------------
//
// 1.�o�̩w�q�G�t���ܼ� (�� "�Ҳզw�˺޲z" �{���ϥ�)
//------------------------------------------
//
// "�Ҳզw�˺޲z" �{���|�g�J�Q�ժ� SFS/pro_kind ��
//
// ��ĳ�G�о��q�έ^��j�g�өw�q�A�̦n��Ѧr���ݥX��N���N�q�C
//---------------------------------------------------
// �z����⦹�@�Ҳթ�b���@�Өt�ΰ϶����O?
//
// �ثe�Ȧ��G�Ϩѱz���
//
// "�հȦ�F" �Ҳհ϶��N�X�G28
// "�u��c"  �Ҳհ϶��N�X�G161
//---------------------------------------------------


// �z�o�ӼҲժ��W�١A�N�O�z�o�ӼҲթ�m�b SFS �����ؿ��W��

$MODULE_NAME = "docword";


// �Ҳոm��D�n�ؿ��G
// �i��ܪ��� school �� module

$MODULE_MAIN_DIR="school";


// �Ҳոm����|�G
// �о��q�ϥ��ܼƥN���A�ŭק�!

$MODULE_STORE_PATH  = "$MODULE_MAIN_DIR/$MODULE_NAME";

// �w�]�O�_�}�Ҩϥ�?
$MODULE_PRO_ISLIVE = 1;

//---------------------------------------------------
//
// 2.�o�̩w�q�G�Ҳո�ƪ�W�� (�� "�Ҳզw�˺޲z" �{���ϥ�)
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

$MODULE_TABLE_NAME[0] = "sch_doc1";
$MODULE_TABLE_NAME[1] = "sch_doc1_unit";

//---------------------------------------------------
//
// 3.�o�̩w�q�G�Ҳդ���W�١A�к�²�R�W (�� "�Ҳզw�˺޲z" �{���ϥ�)
//
// ���|��ܵ��ϥΪ�
//-----------------------------------------------


$MODULE_PRO_KIND_NAME = "����޲z�t��";


//---------------------------------------------------
//
// 4. �o�̩w�q�G�Ҳժ���������T (�� "�����t�ε{��" ����)
//
//---------------------------------------------------

// �Ҳժ���
$MODULE_VER="2.0";

// �Ҳյ{���@��
$MODULE_AUTHOR="hami";

// �Ҳժ��v����
$MODULE_LICENSE="GPL";

// �Ҳե~��W��(�� "�Ҳճ]�w" �{���ϥ�)
$MODULE_DISPLAY_NAME="����޲z";

// �Ҳ����ݸs��
$MODULE_GROUP_NAME="�հȦ�F";

// �Ҳն}�l���
$MODULE_CREATE_DATE="2002-12-15";

// �Ҳճ̫��s���
$MODULE_UPDATE="2003-04-7 20:30:00";

// �Ҳէ�s��
$MODULE_UPDATE_MAN="hami";


//---------------------------------------------------
//
// 5. �o�̽Щw�q�G�z�o��{���ݭn�Ψ쪺�G�ܼƩα`��
//------------------------------^^^^^^^^^^
//
// (���Q�Q "�Ҳճ]�w" �{�����ު̡A�иm���)
//
// ��ĳ�G�о��q�έ^��j�g�өw�q�A�̦n�n��Ѧr���ݥX��N���N�q�C
//---------------------------------------------------



//---------------------------------------------------
//
// 6. �o�̩w�q�G�w�]�ȭn�� "�Ҳճ]�w" �{���ӱ��ު̡A
//    �Y���Q�A�i�����]�w�C
//
// �榡�G var �N���ܼƦW��
//       msg �N����ܰT��
//       value �N���ܼƳ]�w��
//---------------------------------------------------

$SFS_MODULE_SETUP[] =
	array('var'=>"max_doc", 'msg'=>"�~�פ���q(���)��4��9999��,5��99999��", 'value'=>4);
$SFS_MODULE_SETUP[] =
	array('var'=>"default_unit", 'msg'=>"�w�]�Ӥ���", 'value'=>"�x�����F��");
$SFS_MODULE_SETUP[] =
	array('var'=>"default_word", 'msg'=>"�w�]�Ӥ帹", 'value'=>'���Цr�ĸ�');
$SFS_MODULE_SETUP[] =
	array('var'=>"default_out_unit", 'msg'=>"�w�]������", 'value'=>"�x�����F��");
$SFS_MODULE_SETUP[] =
	array('var'=>"default_out_word", 'msg'=>"�w�]�o�帹", 'value'=>"�~�H�p�r");
$SFS_MODULE_SETUP[] =
	array('var'=>"page_count", 'msg'=>"�C����ܤ����", 'value'=>20);
$SFS_MODULE_SETUP[] =
	array('var'=>"is_standalone", 'msg'=>"�O�_���W�ߪ��ɭ�(1�O,0�_)", 'value'=>1);

// ��2,3,4....�ӡA�̦������G 

// $SFS_MODULE_SETUP[1] =
//	array('var'=>"xxxx", 'msg'=>"yyyy", 'value'=>0);

// $SFS_MODULE_SETUP[2] =
//	array('var'=>"ssss", 'msg'=>"tttt", 'value'=>1);

?>
