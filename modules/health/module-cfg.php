<?php
//$Id: module-cfg.php 5628 2009-09-07 00:24:46Z brucelyc $

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

$MODULE_TABLE_NAME[0] = "BMI";
$MODULE_TABLE_NAME[1] = "GHD";
$MODULE_TABLE_NAME[2] = "health_WH";
$MODULE_TABLE_NAME[3] = "health_sight";
$MODULE_TABLE_NAME[4] = "health_sight_ntu";
$MODULE_TABLE_NAME[5] = "health_disease";
$MODULE_TABLE_NAME[6] = "health_diseaseserious";
$MODULE_TABLE_NAME[7] = "health_bodymind";
$MODULE_TABLE_NAME[8] = "health_inherit";
$MODULE_TABLE_NAME[9] = "health_checks_item";
$MODULE_TABLE_NAME[10] = "health_checks_record";
$MODULE_TABLE_NAME[11] = "health_worm";
$MODULE_TABLE_NAME[12] = "health_uri";
$MODULE_TABLE_NAME[13] = "health_teeth";
$MODULE_TABLE_NAME[14] = "health_insurance";
$MODULE_TABLE_NAME[15] = "health_insurance_record";
$MODULE_TABLE_NAME[16] = "health_hospital";
$MODULE_TABLE_NAME[17] = "health_hospital_record";
$MODULE_TABLE_NAME[18] = "health_exam_item";
$MODULE_TABLE_NAME[19] = "health_exam_record";
$MODULE_TABLE_NAME[20] = "health_mapping";
$MODULE_TABLE_NAME[21] = "health_inject_item";
$MODULE_TABLE_NAME[22] = "health_inject_record";
$MODULE_TABLE_NAME[23] = "health_other";
$MODULE_TABLE_NAME[24] = "health_accident_place";
$MODULE_TABLE_NAME[25] = "health_accident_reason";
$MODULE_TABLE_NAME[26] = "health_accident_part";
$MODULE_TABLE_NAME[27] = "health_accident_status";
$MODULE_TABLE_NAME[28] = "health_accident_attend";
$MODULE_TABLE_NAME[29] = "health_accident_record";
$MODULE_TABLE_NAME[30] = "health_accident_part_record";
$MODULE_TABLE_NAME[31] = "health_accident_status_record";
$MODULE_TABLE_NAME[32] = "health_accident_attend_record";

//---------------------------------------------------
//
// 2.�o�̩w�q�G�Ҳդ���W�١A�к�²�R�W (�� "�Ҳ��v���]�w" �{���ϥ�)
//
// ���|��ܵ��ϥΪ�
//-----------------------------------------------


$MODULE_PRO_KIND_NAME = "�ǥͰ��d��T";


//---------------------------------------------------
//
// 3. �o�̩w�q�G�Ҳժ���������T (�� "�۰ʧ�s�{��" ����)
//    �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//
//---------------------------------------------------

// �Ҳճ̫��s����
$MODULE_UPDATE_VER="1.0.0";

// �Ҳճ̫��s���
$MODULE_UPDATE="2006-12-24";


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
"base.php"=>"�ǥ͸��",
"input.php"=>"��Ƶn��",
"sight.php"=>"���O",
"wh.php"=>"�����魫",
"teesem.php"=>"�f��",
"inflection.php"=>"�ǬV�f",
"inject.php"=>"�w������",
"accident.php"=>"�˯f",
"check.php"=>"���d�ˬd",
"analyze.php"=>"�έp���R",
"other.php"=>"��L",
"setup.php"=>"�t�οﶵ�]�w",
"CSV_OUT.php"=>"��ƪ�DUMP"
);

$study_str="'0','5','15'";

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


//$SFS_MODULE_SETUP[0] =
//	array('var'=>"xxxx", 'msg'=>"yyyy", 'value'=>1);

// ��2,3,4....�ӡA�̦������G 

// $SFS_MODULE_SETUP[1] =
//	array('var'=>"xxxx", 'msg'=>"yyyy", 'value'=>0);

// $SFS_MODULE_SETUP[2] =
//	array('var'=>"ssss", 'msg'=>"tttt", 'value'=>1);

?>
