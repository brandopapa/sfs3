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

$MODULE_TABLE_NAME[0] = "contest_itembank";  			//�d��Ƥ����D�w
$MODULE_TABLE_NAME[1] = "contest_ibgroup";   			//�C���v�ɱq�D�w��X���D�ز�
$MODULE_TABLE_NAME[2] = "contest_record1";   			//�d��Ƨ@���O��
$MODULE_TABLE_NAME[3] = "contest_record2";   			//ø�ϻP²�����ɧ@���O��
$MODULE_TABLE_NAME[4] = "contest_setup";      		//�C���v�ɳ]�w
$MODULE_TABLE_NAME[5] = "contest_score_setup";		//ø�ϻP²�����ɲӶ������]�w
$MODULE_TABLE_NAME[6] = "contest_score_user"; 		//ø�ϻP²�����ɦU�Ӷ��������Z
$MODULE_TABLE_NAME[7] = "contest_score_record2"; 	//ø�ϻP²�������`���Z�M���y
$MODULE_TABLE_NAME[8] = "contest_user";      			//�C���v�ɳ��W���
$MODULE_TABLE_NAME[9] = "contest_judge_user";			//���f�Ѯv
$MODULE_TABLE_NAME[10] = "contest_news";					//�̷s����
$MODULE_TABLE_NAME[11] = "contest_files";					//�ɮפU���ɮ׳]�w

//---------------------------------------------------
//
// 2.�o�̩w�q�G�Ҳդ���W�١A�к�²�R�W (�� "�Ҳ��v���]�w" �{���ϥ�)
//
// ���|��ܵ��ϥΪ�
//-----------------------------------------------

$MODULE_PRO_KIND_NAME = "�������v-�Юv�Ҳ�";

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
$MODULE_UPDATE="2013-02-21";


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
$school_menu_p = array(
"ct_news.php"=>"�̷s����",
"ct_review.php"=>"���Z�P�@�~",
"ct_judge.php"=>"���f�u�@",
"ct_manage.php"=>"�v�ɺ޲z",
"ct_itembank.php"=>"�d��Ƥ����D�w"
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

// ��2,3,4....�ӡA�̦������G 

// $SFS_MODULE_SETUP[1] =
//	array('var'=>"xxxx", 'msg'=>"yyyy", 'value'=>0);

// $SFS_MODULE_SETUP[2] =
//	array('var'=>"ssss", 'msg'=>"tttt", 'value'=>1);

 $SFS_MODULE_SETUP[1] =
	array('var'=>"page", 'msg'=>"�C����ܵ���", 'value'=>"10");

 $SFS_MODULE_SETUP[2] =
	array('var'=>"upload_file_attr", 'msg'=>"���\�W�Ǫ��ɮ��ݩ�", 'value'=>"jpeg;jpg;gif;png;doc;ppt;xls;docx;xlsx;pptx;odp;otp;odt;pdf;swf");


?>