<?php
                                                                                                                             
// $Id: module-cfg.php 7794 2013-12-03 03:39:50Z infodaes $

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

$MODULE_NAME = "book";


// �Ҳոm��D�n�ؿ��G
// �i��ܪ��� school �� module

$MODULE_MAIN_DIR="school";

//���Ҳն��Ϥ��޲z�v
$MODULE_MAN = 1 ;

//�޲z�v����
$MODULE_MAN_DESCRIPTION = "�㦳�޲z�v�H��,�i���v�ǥ;ާ@�ϮѨt��";


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

$MODULE_TABLE_NAME[0] = "book";
$MODULE_TABLE_NAME[1] = "borrow";
$MODULE_TABLE_NAME[2] = "bookch1";

//---------------------------------------------------
//
// 3.�o�̩w�q�G�Ҳդ���W�١A�к�²�R�W (�� "�Ҳզw�˺޲z" �{���ϥ�)
//
// ���|��ܵ��ϥΪ�
//-----------------------------------------------


$MODULE_PRO_KIND_NAME = "�ϮѺ޲z�t��";


//---------------------------------------------------
//
// 4. �o�̩w�q�G�Ҳժ���������T (�� "�����t�ε{��" ����)
//
//---------------------------------------------------

// �Ҳժ���
$MODULE_VER="2.0.1";

// �Ҳյ{���@��
$MODULE_AUTHOR="hami";

// �Ҳժ��v����
$MODULE_LICENSE="";

// �Ҳե~��W��(�� "�Ҳճ]�w" �{���ϥ�)
$MODULE_DISPLAY_NAME="�ϮѺ޲z";

// �Ҳ����ݸs��
$MODULE_GROUP_NAME="�հȦ�F";

// �Ҳն}�l���
$MODULE_CREATE_DATE="2002-12-15";

// �Ҳճ̫��s���
$MODULE_UPDATE="2003-03-19 08:30:00";

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
	array('var'=>"lib_name", 'msg'=>"�ϮѫǱ��X��ܳ���", 'value'=>"�~�H�Ϯѫ�");
$SFS_MODULE_SETUP[] =
	array('var'=>"barcore_cols", 'msg'=>"�ϮѫǱ��X��ܦ��", 'value'=>4);
$SFS_MODULE_SETUP[] =
	array('var'=>"barcare_type", 'msg'=>"�ϮѫǱ��X�ϫ��榡(Png or Gif)", 'value'=>'Png');
$SFS_MODULE_SETUP[] =
	array('var'=>"man_name", 'msg'=>"�t�κ޲z���m�W", 'value'=>"�t�κ޲z��");
$SFS_MODULE_SETUP[] =
	array('var'=>"man_mail", 'msg'=>"�޲z�� email", 'value'=>"");
$SFS_MODULE_SETUP[] =
	array('var'=>"data_mail", 'msg'=>"��ƺ޲z��", 'value'=>"��ƺ޲z��");
$SFS_MODULE_SETUP[] =
	array('var'=>"man_ip1", 'msg'=>"���ٮѭ��wIP 1", 'value'=>"163.17.169");
$SFS_MODULE_SETUP[] =
	array('var'=>"man_ip2", 'msg'=>"���ٮѭ��wIP 2", 'value'=>"163.17.169.10");
$SFS_MODULE_SETUP[] =
	array('var'=>"man_ip3", 'msg'=>"���ٮѭ��wIP 3", 'value'=>"163.17.169.11");
$SFS_MODULE_SETUP[] =
	array('var'=>"yetdate", 'msg'=>"�ǥͭɾ\���", 'value'=>14);
$SFS_MODULE_SETUP[] =
	array('var'=>"tea_yetdate", 'msg'=>"�Юv�ɾ\���", 'value'=>28);
$SFS_MODULE_SETUP[] =
	array('var'=>"sort_num", 'msg'=>"�Ʀ�]��ܦW��", 'value'=>40);

$SFS_MODULE_SETUP[] =
	array('var'=>"un_limit_ip", 'msg'=>"��������IP �\��", 'value'=>array(0=>"�_",1=>"�O"));

$SFS_MODULE_SETUP[] =
	array('var'=>"amount_limit_s", 'msg'=>"�ǥͭɾ\���ƭ���", 'value'=>7);
$SFS_MODULE_SETUP[] =
	array('var'=>"pic_width", 'msg'=>"�ǥͤj�Y����ܼe��", 'value'=>64);	
	
// ��2,3,4....�ӡA�̦������G 

// $SFS_MODULE_SETUP[1] =
//	array('var'=>"xxxx", 'msg'=>"yyyy", 'value'=>0);

// $SFS_MODULE_SETUP[2] =
//	array('var'=>"ssss", 'msg'=>"tttt", 'value'=>1);

?>
