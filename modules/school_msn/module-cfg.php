<?php
//$Id$

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

$MODULE_TABLE_NAME[0] = "sc_msn_data";
$MODULE_TABLE_NAME[1] = "sc_msn_online";
$MODULE_TABLE_NAME[2] = "sc_msn_file";
$MODULE_TABLE_NAME[3] = "sc_msn_folder";
$MODULE_TABLE_NAME[4] = "sc_msn_board_pic";


//---------------------------------------------------
//
// 2.�o�̩w�q�G�Ҳդ���W�١A�к�²�R�W (�� "�Ҳ��v���]�w" �{���ϥ�)
//
// ���|��ܵ��ϥΪ�
//-----------------------------------------------


$MODULE_PRO_KIND_NAME = "�ն�MSN";

//$MODULE_MAN=True;
//---------------------------------------------------
//
// 3. �o�̩w�q�G�Ҳժ���������T (�� "�۰ʧ�s�{��" ����)
//    �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//
//---------------------------------------------------

// �Ҳճ̫��s����
$MODULE_UPDATE_VER="1.0.0";

// �Ҳճ̫��s���
$MODULE_UPDATE="2014-01-14";


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
$MODULE_MENU=array("index.php"=>"�ϥλ���","msn_folder.php"=>"�ɮק��]�w","msn_file.php"=>"�ɮײM�z","msn_users.php"=>"�ϥΪ̪��A�Υ\��]�w");


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

$SFS_MODULE_SETUP[] = array('var'=>"SOURCE", 'msg'=>"�������i�T���ӷ�", 'value'=>array("board"=>"board�Ҳ�","jboard"=>"jboard�Ҳ�"));
$SFS_MODULE_SETUP[] = array('var'=>"LAST_DAYS", 'msg'=>"�������i��ܴX�餺���T��", 'value'=>15);
$SFS_MODULE_SETUP[] = array('var'=>"PRESERVE_DAYS", 'msg'=>"�p�H�T���O�d�Ѽ�", 'value'=>15);
$SFS_MODULE_SETUP[] = array('var'=>"CLEAN_MODE", 'msg'=>"�p�H�L���T���M�z�Ҧ�", 'value'=>array(0=>"�����R��",1=>"�O�d�|��Ū����"));
$SFS_MODULE_SETUP[] = array('var'=>"POSITION", 'msg'=>"�u�X�����w�]��m", 'value'=>array(0=>"�k�W��",1=>"���W��",2=>"������",3=>"�k�U��",4=>"���U��"));
$SFS_MODULE_SETUP[] =	array('var'=>"insite_ip", 'msg'=>"�]�w����IP�d��,�d�ŮɨϥΨt�ιw�]��,��163.17.43 �� 163.17.43.1-163.17.43.128 ", 'value'=>'');

$SFS_MODULE_SETUP[] = array('var'=>"SMPTHost", 'msg'=>"SMPT���A�����}", 'value'=>'');
$SFS_MODULE_SETUP[] = array('var'=>"SMPTAuth", 'msg'=>"SMPT���A���{��", 'value'=>array(0=>"���ݭn",1=>"�ݭn"));
$SFS_MODULE_SETUP[] = array('var'=>"SMPTPort", 'msg'=>"SMPT���A��Port", 'value'=>'25');
$SFS_MODULE_SETUP[] = array('var'=>"SMPTusername", 'msg'=>"SMPT���ϥΪ̱b��", 'value'=>'username@smpt_url.com');
$SFS_MODULE_SETUP[] = array('var'=>"SMPTpassword", 'msg'=>"SMPT���ϥΪ̱b��", 'value'=>'yourpassword');

$SFS_MODULE_SETUP[] = array('var'=>"portfolio", 'msg'=>"�Юv�����s���C��", 'value'=>array(0=>"���ҥ�",1=>"�ҥ�"));

$SFS_MODULE_SETUP[] = array('var'=>"IS_UTF8", 'msg'=>"sfs3���s�X�覡(�q�`��Big5)", 'value'=>array(0=>"Big5",1=>"UTF8"));

?>
