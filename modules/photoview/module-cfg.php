<?php

// $Id: module-cfg.php 6336 2011-02-22 09:01:01Z infodaes $

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

$MODULE_TABLE_NAME[0] = "photoviewtb";

//---------------------------------------------------
//
// 2.�o�̩w�q�G�Ҳդ���W�١A�к�²�R�W (�� "�Ҳ��v���]�w" �{���ϥ�)
//
// ���|��ܵ��ϥΪ�
//-----------------------------------------------


$MODULE_PRO_KIND_NAME = "�ۤ��]";


//---------------------------------------------------
//
// 3. �o�̩w�q�G�Ҳժ���������T (�� "�۰ʧ�s�{��" ����)
//    �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//
//---------------------------------------------------

// �Ҳճ̫��s����
$MODULE_UPDATE_VER="1.0.0";

// �Ҳճ̫��s���
$MODULE_UPDATE="2003-05-03 ";


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
  $chkfile=array(".jpg",".jpeg");	//�u�i�H�W��jpg�榡����
  $tbname = "photoviewtb" ;	//��ƪ�W


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



$SFS_MODULE_SETUP[0] =
	array('var'=>"pagesites", 'msg'=>"�C����ܵ���", 'value'=>5);
$SFS_MODULE_SETUP[1] =
	array('var'=>"upfilenum", 'msg'=>"�w�]�W���ɮ׼�", 'value'=>10);
$SFS_MODULE_SETUP[2] =
	array('var'=>"BIG_PIC_X", 'msg'=>"�̤j�ϼe��", 'value'=>800);
$SFS_MODULE_SETUP[3] =
	array('var'=>"BIG_PIC_Y", 'msg'=>"�̤j�ϰ���", 'value'=>600);	
$SFS_MODULE_SETUP[4] =
	array('var'=>"show_col", 'msg'=>"��ܤ����", 'value'=>2);		
$SFS_MODULE_SETUP[5] =
	array('var'=>"stand_alone", 'msg'=>"�W�ߤ������", 'value'=>array(0=>'�_',1=>'�O'));
$SFS_MODULE_SETUP[6] =
	array('var'=>"view_title", 'msg'=>"��ܼ��D", 'value'=>'�ۤ��i');
$SFS_MODULE_SETUP[7] =
	array('var'=>"memo_pos", 'msg'=>"������ܦ�m", 'value'=>array(0=>'�k',1=>'�U'));
$SFS_MODULE_SETUP[8] =
	array('var'=>"font_size", 'msg'=>"��r�j�p", 'value'=>'12px');
$SFS_MODULE_SETUP[9] =
	array('var'=>"font_color", 'msg'=>"��r�C��", 'value'=>'#FF0000');
$SFS_MODULE_SETUP[10] =
	array('var'=>"show_title", 'msg'=>"��ܬۤ��W��", 'value'=>array(0=>'�_',1=>'�O'));
$SFS_MODULE_SETUP[11] =
	array('var'=>"show_date", 'msg'=>"��ܫظm���", 'value'=>array(0=>'�_',1=>'�O'));	
$SFS_MODULE_SETUP[12] =
	array('var'=>"show_intro", 'msg'=>"���²��", 'value'=>array(0=>'�_',1=>'�O'));	
$SFS_MODULE_SETUP[13] =
	array('var'=>"show_auth", 'msg'=>"��ܱi�K��", 'value'=>array(0=>'�_',1=>'�O'));	
$SFS_MODULE_SETUP[14] =
	array('var'=>"show_op", 'msg'=>"��ܾާ@�϶s", 'value'=>array(0=>'�_',1=>'�O'));		
	

// ��2,3,4....�ӡA�̦������G 

// $SFS_MODULE_SETUP[1] =
//	array('var'=>"xxxx", 'msg'=>"yyyy", 'value'=>0);

// $SFS_MODULE_SETUP[2] =
//	array('var'=>"ssss", 'msg'=>"tttt", 'value'=>1);

?>
