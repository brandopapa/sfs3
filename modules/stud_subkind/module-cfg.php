<?php
//$Id: module-cfg.php 6816 2012-06-22 08:27:16Z smallduh $

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

$MODULE_TABLE_NAME[0] = "stud_subkind";

//---------------------------------------------------
//
// 2.�o�̩w�q�G�Ҳդ���W�١A�к�²�R�W (�� "�Ҳ��v���]�w" �{���ϥ�)
//
// ���|��ܵ��ϥΪ�
//-----------------------------------------------


$MODULE_PRO_KIND_NAME = "�ǥͨ������O�P�ݩ�";

// �ݭn�ϥκ޲z���v��
$MODULE_MAN=true;


//---------------------------------------------------
//
// 3. �o�̩w�q�G�Ҳժ���������T (�� "�۰ʧ�s�{��" ����)
//    �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//
//---------------------------------------------------

// �Ҳճ̫��s����
$MODULE_UPDATE_VER="1.0.0";

// �Ҳճ̫��s���
$MODULE_UPDATE="2006-02-09";


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
$MENU_P = array(
"setkind.php"=>"�������O�]�w","setsubkind.php"=>"���O�ݩʳ]�w"
,"setreference.php"=>"���ѷӳ]�w","statistics.php"=>"�H�Ƥ��R�έp"
,"grouping.php"=>"�����O�s�ճ]�w","filtering.php"=>"�s�զW��z��"

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
// �ϥΪk�G
//
// $ret_array =& get_module_setup("module_makeer")
//
//
// �Ա��аѦ� include/sfs_core_module.php ���������C
//
// �o�Ϫ� "�ܼƦW�� $SFS_MODULE_SETUP" �Фŧ���!!!
//---------------------------------------------------

$IS_MODULE_ARR = array("N"=>"�_","Y"=>"�O");
$FAMILY_KIND_ARR = array("0"=>"","1"=>"����","2"=>"���","3"=>"����");


$SFS_MODULE_SETUP[0] =
        array('var'=>"set_ref", 'msg'=>"�}��ɮv�i�H�]�w���ѷ�? ( �O/�_ )", 'value'=>$IS_MODULE_ARR);
$SFS_MODULE_SETUP[1] =
        array('var'=>"free_input", 'msg'=>"�}��ɮv�i�H�ۥѿ�J? ( �O/�_ )", 'value'=>$IS_MODULE_ARR);
$SFS_MODULE_SETUP[2] =
        array('var'=>"foreign_id", 'msg'=>"�~�y�ΰt���l�k�������O�N��:", 'value'=>100);
$SFS_MODULE_SETUP[3] =
        array('var'=>"yuanzhumin_id", 'msg'=>"�����������O�N��:", 'value'=>9);
$SFS_MODULE_SETUP[4] =
        array('var'=>"default_family_kind", 'msg'=>"�w�]�������Y?", 'value'=>$FAMILY_KIND_ARR);




//$SFS_MODULE_SETUP[0] =
//        array('var'=>"xxxx", 'msg'=>"yyyy", 'value'=>1);

// ��2,3,4....�ӡA�̦������G

// $SFS_MODULE_SETUP[1] =
//        array('var'=>"xxxx", 'msg'=>"yyyy", 'value'=>0);

// $SFS_MODULE_SETUP[2] =
//        array('var'=>"ssss", 'msg'=>"tttt", 'value'=>1);

?>