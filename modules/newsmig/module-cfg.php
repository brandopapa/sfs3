<?php
// $Id: module-cfg.php 5310 2009-01-10 07:57:56Z hami $

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

$MODULE_TABLE_NAME[0] = "newsmig";

//---------------------------------------------------
//
// 2.�o�̩w�q�G�Ҳդ���W�١A�к�²�R�W (�� "�Ҳ��v���]�w" �{���ϥ�)
//
// ���|��ܵ��ϥΪ�
//-----------------------------------------------


$MODULE_PRO_KIND_NAME = "�ն�s�D";


//---------------------------------------------------
//
// 3. �o�̩w�q�G�Ҳժ���������T (�� "�۰ʧ�s�{��" ����)
//    �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//
//---------------------------------------------------

// �Ҳճ̫��s����
$MODULE_UPDATE_VER="1.0.0";

// �Ҳճ̫��s���
$MODULE_UPDATE="2004/03/23";

//���n�ҲաA�K�Q�ŧR
$SYS_MODULE=0;
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

$todayis = date("Y-m-d H:s",time());
$timestamp = time();

//�ؿ����{��
$school_menu_p = array(
"index.php"=>"�s�D�@����",
"postnews.php?act=add"=>"�s�W�s�D"
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
// �ڭ̦����Ѥ@�Ө禡 get_module_setup (�Ǧ^�Ȭ��@�� array["�ܼƦW"]=��)
// �ѱz���Υثe�o���ܼƪ��̷s���p�ȡA
//
// �Ա��аѦ� include/sfs_core_module.php ���������C
//
// �o�Ϫ� "�ܼƦW�� $SFS_MODULE_SETUP" �Фŧ���!!!
//---------------------------------------------------

$SFS_MODULE_SETUP[0]=
	array('var'=>"IS_STANDALONE", 'msg'=>"�O�_���W�ߪ��ɭ�(1�O,0�_)", 'value'=>0);


// ��2,3,4....�ӡA�̦������G 

 $SFS_MODULE_SETUP[1]=
 array('var'=>"nums_perpage", 'msg'=>"�C����ܵ���", 'value'=>10);

 //  �Ʀ�ۥ����Y��(Reductive picture)����
 $SFS_MODULE_SETUP[2] =
	array('var'=>"SWidth", 'msg'=>"�ۥ��Y�Ϫ���", 'value'=>200);

 //  �Ʀ�ۥ����Y��(Reductive picture)�e��
 $SFS_MODULE_SETUP[3] =
	array('var'=>"SLength", 'msg'=>"�ۥ��Y�ϼe��", 'value'=>150);
	
// �Ʀ�ۥ����j�Ϫ�����
$SFS_MODULE_SETUP[4] =
	array('var'=>"MWidth", 'msg'=>"�ۥ��j�Ϫ���", 'value'=>640);

// �Ʀ�ۥ����j�Ϫ��e��
$SFS_MODULE_SETUP[5] =
	array('var'=>"MLength", 'msg'=>"�ۥ��j�ϼe��", 'value'=>480);

// headnews �O�_��ܭI��
$SFS_MODULE_SETUP[6] =
	array('var'=>"hn_bgimg", 'msg'=>"headnews�O�_��ܭI��(1�O,0�_)", 'value'=>1);


?>
