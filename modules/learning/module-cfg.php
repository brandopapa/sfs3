<?php

//---------------------------------------------------
//
// 1.�o�̩w�q�G�t���ܼ� (�� "�Ҳզw�˺޲z" �{���ϥ�)
//------------------------------------------
//
// "�Ҳզw�˺޲z" �{���|�g�J�Q�ժ� SFS/pro_kind ��
//
// ��ĳ�G�о��q�έ^��j�g�өw�q�A�̦n��Ѧr���ݥX��N���N�q�C
//---------------------------------------------------
//

// �z�o�ӼҲժ��W�١A�N�O�z�o�ӼҲթ�m�b SFS �����ؿ��W��

$MODULE_NAME = "learning";


//���Ҳն��Ϥ��޲z�v
$MODULE_MAN = 1 ;
//�޲z�v����
$MODULE_MAN_DESCRIPTION = "�㦳�޲z�v�H��,�i�R�ר�L�H���G�i";



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

$MODULE_TABLE_NAME[0] = "unit_c";
$MODULE_TABLE_NAME[1] = "unit_tome";
$MODULE_TABLE_NAME[2] = "unit_u";
$MODULE_TABLE_NAME[3] = "test_badge";
$MODULE_TABLE_NAME[4] = "test_data";
$MODULE_TABLE_NAME[5] = "test_online";
$MODULE_TABLE_NAME[6] = "test_paper";
$MODULE_TABLE_NAME[7] = "test_score";
$MODULE_TABLE_NAME[8] = "test_setup";
$MODULE_TABLE_NAME[9] = "poke_base";
//
// 3.�o�̩w�q�G�Ҳդ���W�١A�к�²�R�W (�� "�Ҳզw�˺޲z" �{���ϥ�)
//
// ���|��ܵ��ϥΪ�
//-----------------------------------------------


$MODULE_PRO_KIND_NAME = "�оǸ귽";


//---------------------------------------------------
//
// 4. �o�̩w�q�G�Ҳժ���������T (�� "�����t�ε{��" ����)
//
//---------------------------------------------------

// �Ҳժ���
$MODULE_VER="1.0.0";
// �Ҳյ{���@��
$MODULE_AUTHOR="log7";

// �Ҳժ��v����
$MODULE_LICENSE="";

// �Ҳե~��W��(�� "�Ҳճ]�w" �{���ϥ�)
$MODULE_DISPLAY_NAME="�оǸ귽";

// �Ҳ����ݸs��
$MODULE_GROUP_NAME="�հȦ�F";

// �Ҳն}�l���
$MODULE_CREATE_DATE="2006-05-10";

// �Ҳճ̫��s���
$MODULE_UPDATE="2005-05-10 08:30:00";

// �Ҳէ�s��
$MODULE_UPDATE_MAN="log7";


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
	array('var'=>"page_count", 'msg'=>"�C����ܵ���", 'value'=>15);
$SFS_MODULE_SETUP[] =
	array('var'=>"is_standalone", 'msg'=>"�O�_���W�ߪ��ɭ�(1 �O,0 �_", 'value'=>0);
// ��2,3,4....�ӡA�̦������G 

// $SFS_MODULE_SETUP[1] =
//	array('var'=>"xxxx", 'msg'=>"yyyy", 'value'=>0);

// $SFS_MODULE_SETUP[2] =
//	array('var'=>"ssss", 'msg'=>"tttt", 'value'=>1);

?>
