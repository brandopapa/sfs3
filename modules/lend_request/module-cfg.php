<?php

//$Id: module-cfg.php 5680 2009-10-06 16:10:42Z infodaes $
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
//$MODULE_TABLE_NAME[1]="xxxx";
//
// �Ъ`�N�n�M module.sql ���� table �W�٤@�P!!!
//---------------------------------------------------
// ��ƪ�W�٩w�q
//---------------------------------------------------
//
// 2.�o�̩w�q�G�Ҳդ���W�١A�к�²�R�W (�� "�Ҳ��v���]�w" �{���ϥ�)
//
// ���|��ܵ��ϥΪ�
//-----------------------------------------------

$MODULE_PRO_KIND_NAME = "���~�ɥΥӽ�";

//---------------------------------------------------
//
// 3. �o�̩w�q�G�Ҳժ���������T (�� "�۰ʧ�s�{��" ����)
//    �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//
//---------------------------------------------------

// �Ҳճ̫��s����
$MODULE_UPDATE_VER="1.0.0";

// �Ҳճ̫��s���
$MODULE_UPDATE="2007-09-23";

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
$MENU_P = array("board.php"=>"���i�T��","query.php"=>"�d�߭ɥ�","request.php"=>"�ӽЬ���","record.php"=>"�ɥά���");

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
// �ϥΪk�G
//
// $ret_array =& get_module_setup("module_makeer")
//
//
// �Ա��аѦ� include/sfs_core_module.php ���������C
//
// �o�Ϫ� "�ܼƦW�� $SFS_MODULE_SETUP" �Фŧ���!!!
//---------------------------------------------------
$IS_MODULE_ARR = array("Y"=>"�O",""=>"�_");
$SFS_MODULE_SETUP[] =array('var'=>"User_Email", 'msg'=>"��¾�����]�w�l��H�c��i���X�ӽ�?", 'value'=>$IS_MODULE_ARR);
$SFS_MODULE_SETUP[] =array('var'=>"User_Removable", 'msg'=>"�ɥΪ̥i�M���ӽ�?", 'value'=>$IS_MODULE_ARR);
$SFS_MODULE_SETUP[] =array('var'=>"Delay_Refused", 'msg'=>"�O�����k�ڵ��A�ɥ�?", 'value'=>$IS_MODULE_ARR);
$SFS_MODULE_SETUP[] =array('var'=>"Delay_Refused_announce", 'msg'=>"�ڵ��A�ɥΤ�r����?", 'value'=>'�U�������~,�z�|���k��,���k�٫�A��z�s���ɥ�~~~');

$SFS_MODULE_SETUP[] =array('var'=>"Table_width", 'msg'=>"�M������ڵe���e�פ��(%)", 'value'=>'100');
$SFS_MODULE_SETUP[] =array('var'=>"Tr_BGColor", 'msg'=>"���D�C����", 'value'=>'#C8FFAA');
$SFS_MODULE_SETUP[] =array('var'=>"Lendable_BGColor", 'msg'=>"�i�ɥΪ��~����", 'value'=>'#FFFFFF');
$SFS_MODULE_SETUP[] =array('var'=>"Requested_BGColor", 'msg'=>"�w�w�ɪ��~����", 'value'=>'#CCFFCC');
$SFS_MODULE_SETUP[] =array('var'=>"NotReturned_BGColor", 'msg'=>"�w�ɥX���~����", 'value'=>'#AAAAAA');
$SFS_MODULE_SETUP[] =array('var'=>"OverTime_BGColor", 'msg'=>"�O�����k�٪��~����", 'value'=>'#FFAAAA');
$SFS_MODULE_SETUP[] =array('var'=>"Returned_BGColor", 'msg'=>"�w�k�٪��~����", 'value'=>'#AAAAAA');

$SFS_MODULE_SETUP[] =array('var'=>"Read_BGColor", 'msg'=>"�w�g�\Ū�L�����i����", 'value'=>'#CCCCCC');
$SFS_MODULE_SETUP[] =array('var'=>"Pic_Width", 'msg'=>"�Ϥ���ܵ����e��", 'value'=>'320');
$SFS_MODULE_SETUP[] =array('var'=>"Pic_Height", 'msg'=>"�Ϥ���ܵ�������", 'value'=>'240');
//$SFS_MODULE_SETUP[] =array('var'=>"Refused_Reason", 'msg'=>"�~�ɥӽЪ��A�ﶵ", 'value'=>'#CCCCCC');

?>
