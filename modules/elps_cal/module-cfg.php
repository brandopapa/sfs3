<?php
//$Id: module-cfg.php 5619 2009-09-01 16:09:29Z infodaes $

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

$MODULE_TABLE_NAME[0] = "cal_elps";
$MODULE_TABLE_NAME[1] = "cal_elps_set";

//---------------------------------------------------
//
// 2.�o�̩w�q�G�Ҳդ���W�١A�к�²�R�W (�� "�Ҳ��v���]�w" �{���ϥ�)
//
// ���|��ܵ��ϥΪ�
//-----------------------------------------------


$MODULE_PRO_KIND_NAME = "�հȦ�ƾ�";


//---------------------------------------------------
//
// 3. �o�̩w�q�G�Ҳժ���������T (�� "�۰ʧ�s�{��" ����)
//    �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//
//---------------------------------------------------

// �Ҳճ̫��s����
$MODULE_UPDATE_VER="1.0.0";

// �Ҳճ̫��s���
$MODULE_UPDATE="2004-07-31";


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
"index.php"=>"���s�����",
"cal_email.php"=>"���l��ǰe",
"cal_edit.php"=>"���s�צ��",
"mgr_cal.php"=>"���]�w�޲z",
"index2.php"=>"���W�߬ɭ�",
"important.php"=>"���Ǯդj�ƦC��");

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

$IS_MODULE_ARR = array(""=>"�_","Y"=>"�O");

$SFS_MODULE_SETUP[] =array('var'=>"Tr_BGColor", 'msg'=>"�����D����", 'value'=>'#FFCCCC');
$SFS_MODULE_SETUP[] =array('var'=>"SMTP_Server", 'msg'=>"�H�H�D��", 'value'=>'localhost');
$SFS_MODULE_SETUP[] =array('var'=>"SMTP_Port", 'msg'=>"�H�H�D���q�T��", 'value'=>'25');
$SFS_MODULE_SETUP[] =array('var'=>"Title", 'msg'=>"�w�]�D��", 'value'=>'�Ӧ۾Ǯ�SFS3�ǰȨt�Ϊ��հȦ�ưT��....');
$SFS_MODULE_SETUP[] =array('var'=>"Content_Head", 'msg'=>"������Y�q����", 'value'=>'�˷R�� {{teacher}} �g�G');
$SFS_MODULE_SETUP[] =array('var'=>"Content_Body", 'msg'=>"�w�]�D��",'value'=>'�U���O�Ǯե��Ǵ� {{week}} ����Ƹ�T,�q�бz�Ѹ�!{{content}}');
$SFS_MODULE_SETUP[] =array('var'=>"Content_Foot", 'msg'=>"���嵲���q����", 'value'=>'{{sender}} �Ա�');
$SFS_MODULE_SETUP[] =array('var'=>"Note", 'msg'=>"�Ƶ��ƶ�", 'value'=>'PS.�v�d���i��|���s����ƥ��i�A�̷s��T�H�ǰȨt�Τ��i���ǡI');
$SFS_MODULE_SETUP[] =array('var'=>"Reply", 'msg'=>"�n�D�^��", 'value'=>$IS_MODULE_ARR);
$SFS_MODULE_SETUP[] =array('var'=>"Cc_Send", 'msg'=>"�H�e�ƥ����޲z��", 'value'=>$IS_MODULE_ARR);
$SFS_MODULE_SETUP[] =array('var'=>"Show_Event", 'msg'=>"����C����Ƹ�T", 'value'=>$IS_MODULE_ARR);

?>
