<?php

//$Id:$
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
$MODULE_TABLE_NAME[0] = "salary";
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

$MODULE_PRO_KIND_NAME = "�~�z�d��";

//---------------------------------------------------
//
// 3. �o�̩w�q�G�Ҳժ���������T (�� "�۰ʧ�s�{��" ����)
//    �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//
//---------------------------------------------------

// �Ҳճ̫��s����
$MODULE_UPDATE_VER="1.0.0";

// �Ҳճ̫��s���
$MODULE_UPDATE="2007-09-15";

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
//���Ҳն��Ϥ��޲z�v
$MODULE_MAN = 1 ;

//�ؿ����{��
//$MENU_P = array(
//"list.php"=>"�C��");

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

$SFS_MODULE_SETUP[] =array('var'=>"No", 'msg'=>"No�����ܼ��D", 'value'=>'�����s��');
$SFS_MODULE_SETUP[] =array('var'=>"InType", 'msg'=>"InType�����ܼ��D", 'value'=>'�J�b���O');
$SFS_MODULE_SETUP[] =array('var'=>"AnnounceDate", 'msg'=>"AnnounceDate�����ܼ��D", 'value'=>'�o�����');
$SFS_MODULE_SETUP[] =array('var'=>"ID", 'msg'=>"ID�����ܼ��D", 'value'=>'�����Ҧr��');
$SFS_MODULE_SETUP[] =array('var'=>"Name", 'msg'=>"Name�����ܼ��D", 'value'=>'�m�W');
$SFS_MODULE_SETUP[] =array('var'=>"DutyType", 'msg'=>"DutyType�����ܼ��D", 'value'=>'¾���ξǾ�');
$SFS_MODULE_SETUP[] =array('var'=>"JobType", 'msg'=>"JobType�����ܼ��D", 'value'=>'¾�O');
$SFS_MODULE_SETUP[] =array('var'=>"JobTitle", 'msg'=>"JobTitle�����ܼ��D", 'value'=>'¾��');
$SFS_MODULE_SETUP[] =array('var'=>"MaxPoint", 'msg'=>"MaxPoint�����ܼ��D", 'value'=>'�̰����~');
$SFS_MODULE_SETUP[] =array('var'=>"MaxExtPoint", 'msg'=>"MaxExtPoint�����ܼ��D", 'value'=>'�̰��~�\�~');
$SFS_MODULE_SETUP[] =array('var'=>"Point", 'msg'=>"Point�����ܼ��D", 'value'=>'�~�B');
$SFS_MODULE_SETUP[] =array('var'=>"Thirty", 'msg'=>"Thirty�����ܼ��D", 'value'=>'�A�Ⱥ�30�~');
$SFS_MODULE_SETUP[] =array('var'=>"ClassTMFactor", 'msg'=>"ClassTMFactor�����ܼ��D", 'value'=>'�ɮv�O�Y��');
$SFS_MODULE_SETUP[] =array('var'=>"Insurance1Factor", 'msg'=>"Insurance1Factor�����ܼ��D", 'value'=>'���O�Y��');
$SFS_MODULE_SETUP[] =array('var'=>"Insurance2Factor", 'msg'=>"Insurance2Factor�����ܼ��D", 'value'=>'�ҫO�Y��');
$SFS_MODULE_SETUP[] =array('var'=>"Insurance3Factor", 'msg'=>"Insurance3Factor�����ܼ��D", 'value'=>'���O�Y��');
$SFS_MODULE_SETUP[] =array('var'=>"InsureAmount", 'msg'=>"InsureAmount�����ܼ��D", 'value'=>'��O�B');
$SFS_MODULE_SETUP[] =array('var'=>"InsuranceLevel", 'msg'=>"InsuranceLevel�����ܼ��D", 'value'=>'��O�ż�');
$SFS_MODULE_SETUP[] =array('var'=>"Family", 'msg'=>"Family�����ܼ��D", 'value'=>'���O�Y��');
$SFS_MODULE_SETUP[] =array('var'=>"Memo", 'msg'=>"Memo�����ܼ��D", 'value'=>'�Ƶ�');
$SFS_MODULE_SETUP[] =array('var'=>"BankName1", 'msg'=>"BankName1�����ܼ��D", 'value'=>'�~�z�J�b���ľ��c');
$SFS_MODULE_SETUP[] =array('var'=>"AccountID1", 'msg'=>"AccountID1�����ܼ��D", 'value'=>'�~�z�J�b�b�ḹ�X');
$SFS_MODULE_SETUP[] =array('var'=>"BankName2", 'msg'=>"BankName2�����ܼ��D", 'value'=>'�u�s�J�b���ľ��c');
$SFS_MODULE_SETUP[] =array('var'=>"AccountID2", 'msg'=>"AccountID2�����ܼ��D", 'value'=>'�u�s�J�b�b�ḹ�X');
$SFS_MODULE_SETUP[] =array('var'=>"BankName3", 'msg'=>"BankName3�����ܼ��D", 'value'=>'�u�s�J�b���ľ��c');
$SFS_MODULE_SETUP[] =array('var'=>"AccountID3", 'msg'=>"AccountID3�����ܼ��D", 'value'=>'�u�s�J�b�b�ḹ�X');

$SFS_MODULE_SETUP[] =array('var'=>"Mg1", 'msg'=>"Mg1�����ܼ��D", 'value'=>'�~��');
$SFS_MODULE_SETUP[] =array('var'=>"Mg2", 'msg'=>"Mg2�����ܼ��D", 'value'=>'��s�O');
$SFS_MODULE_SETUP[] =array('var'=>"Mg3", 'msg'=>"Mg3�����ܼ��D", 'value'=>'¾�ȥ[��');
$SFS_MODULE_SETUP[] =array('var'=>"Mg4", 'msg'=>"Mg4�����ܼ��D", 'value'=>'�M�~�[��');
$SFS_MODULE_SETUP[] =array('var'=>"Mg5", 'msg'=>"Mg5�����ܼ��D", 'value'=>'�S�Ьz�K');
$SFS_MODULE_SETUP[] =array('var'=>"Mg6", 'msg'=>"Mg6�����ܼ��D", 'value'=>'�ɮv�O');
$SFS_MODULE_SETUP[] =array('var'=>"Mg7", 'msg'=>"Mg7�����ܼ��D", 'value'=>'�~�ȤJ�b');
$SFS_MODULE_SETUP[] =array('var'=>"Mg8", 'msg'=>"Mg8�����ܼ��D", 'value'=>'�h�ɦ�');
$SFS_MODULE_SETUP[] =array('var'=>"Mg9", 'msg'=>"Mg9�����ܼ��D", 'value'=>'');

$SFS_MODULE_SETUP[] =array('var'=>"Mh1", 'msg'=>"Mh1�����ܼ��D", 'value'=>'�h���ۥI');
$SFS_MODULE_SETUP[] =array('var'=>"Mh2", 'msg'=>"Mh2�����ܼ��D", 'value'=>'���O�ۥI');
$SFS_MODULE_SETUP[] =array('var'=>"Mh3", 'msg'=>"Mh3�����ܼ��D", 'value'=>'�ҫO�ۥI');
$SFS_MODULE_SETUP[] =array('var'=>"Mh4", 'msg'=>"Mh4�����ܼ��D", 'value'=>'���O�ۥI');
$SFS_MODULE_SETUP[] =array('var'=>"Mh5", 'msg'=>"Mh5�����ܼ��D", 'value'=>'�ұo��ú');
$SFS_MODULE_SETUP[] =array('var'=>"Mh6", 'msg'=>"Mh6�����ܼ��D", 'value'=>'');
$SFS_MODULE_SETUP[] =array('var'=>"Mh7", 'msg'=>"Mh7�����ܼ��D", 'value'=>'');
$SFS_MODULE_SETUP[] =array('var'=>"Mh8", 'msg'=>"Mh8�����ܼ��D", 'value'=>'');
$SFS_MODULE_SETUP[] =array('var'=>"Mh9", 'msg'=>"Mh9�����ܼ��D", 'value'=>'');

$SFS_MODULE_SETUP[] =array('var'=>"Mi1", 'msg'=>"Mi1�����ܼ��D", 'value'=>'�u�f�s��');
$SFS_MODULE_SETUP[] =array('var'=>"Mi2", 'msg'=>"Mi2�����ܼ��D", 'value'=>'�\�O');
$SFS_MODULE_SETUP[] =array('var'=>"Mi3", 'msg'=>"Mi3�����ܼ��D", 'value'=>'����');
$SFS_MODULE_SETUP[] =array('var'=>"Mi4", 'msg'=>"Mi4�����ܼ��D", 'value'=>'����');
$SFS_MODULE_SETUP[] =array('var'=>"Mi5", 'msg'=>"Mi5�����ܼ��D", 'value'=>'����');
$SFS_MODULE_SETUP[] =array('var'=>"Mi6", 'msg'=>"Mi6�����ܼ��D", 'value'=>'����');
$SFS_MODULE_SETUP[] =array('var'=>"Mi7", 'msg'=>"Mi7�����ܼ��D", 'value'=>'����');
$SFS_MODULE_SETUP[] =array('var'=>"Mi8", 'msg'=>"Mi8�����ܼ��D", 'value'=>'����');
$SFS_MODULE_SETUP[] =array('var'=>"Mi9", 'msg'=>"Mi9�����ܼ��D", 'value'=>'����');

$SFS_MODULE_SETUP[] =array('var'=>"BasisData1", 'msg'=>"�����򥻸����ܶ���", 'value'=>'ID,Name,DutyType,JobType,JobTitle,MaxPoint,MaxExtPoint,Point,Thirty,ClassTMFactor');
$SFS_MODULE_SETUP[] =array('var'=>"BasisData2", 'msg'=>"�k���򥻸����ܶ���", 'value'=>'Insurance1Factor,Insurance2Factor,Insurance3Factor,InsureAmount,InsuranceLevel,Family,BankName1,AccountID1,BankName2,AccountID2');
$SFS_MODULE_SETUP[] =array('var'=>"Mg", 'msg'=>"������ܶ���", 'value'=>'1,2,3,4,5,6,7,8');
$SFS_MODULE_SETUP[] =array('var'=>"Mh", 'msg'=>"�N����ܶ���", 'value'=>'1,2,3,4,5');
$SFS_MODULE_SETUP[] =array('var'=>"Mi", 'msg'=>"�N�I��ܶ���", 'value'=>'1,2,3,4,5');

$SFS_MODULE_SETUP[] =array('var'=>"Title", 'msg'=>"��ܩ��Y", 'value'=>'�~�z�L��ӥزM��');
$SFS_MODULE_SETUP[] =array('var'=>"BasisData_caption", 'msg'=>"�򥻸�Ƽ��D", 'value'=>'�ӤH�򥻸��');
$SFS_MODULE_SETUP[] =array('var'=>"Mg_caption", 'msg'=>"�������ؼ��D", 'value'=>'��������');
$SFS_MODULE_SETUP[] =array('var'=>"Mh_caption", 'msg'=>"�N�����ؼ��D", 'value'=>'�N������');
$SFS_MODULE_SETUP[] =array('var'=>"Mi_caption", 'msg'=>"�N�I���ؼ��D", 'value'=>'�N�I����');

$SFS_MODULE_SETUP[] =array('var'=>"Table_width", 'msg'=>"�M������ڵe���e�פ��(%)", 'value'=>'80');
$SFS_MODULE_SETUP[] =array('var'=>"Tr_BGColor", 'msg'=>"���D�C����", 'value'=>'#FFC8AA');

?>
