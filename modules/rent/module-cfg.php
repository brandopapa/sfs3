<?php
//$Id: module-cfg.php 5310 2009-01-10 07:57:56Z hami $
// ��ƪ�W�٩w�q
$MODULE_TABLE_NAME[0] = "rent_place";
$MODULE_TABLE_NAME[1] = "rent_record";
$MODULE_PRO_KIND_NAME = "���a�X���޲z";
//---------------------------------------------------
//
// 3. �o�̩w�q�G�Ҳժ���������T (�� "�۰ʧ�s�{��" ����)
//    �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//
//---------------------------------------------------
// �Ҳճ̫��s����
$MODULE_UPDATE_VER="1.0.0";
// �Ҳճ̫��s���
$MODULE_UPDATE="2006-08-9";
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
"readme.php"=>"�޲z��k","place.php"=>"�����]�w","rent.php"=>"���ɬ���","rent_summary.php"=>"���R�έp");
//---------------------------------------------------
// �o�Ϫ� "�ܼƦW�� $SFS_MODULE_SETUP" �Фŧ���!!!
//---------------------------------------------------
//$IS_MODULE_ARR = array("Y"=>"�O","N"=>"�_");
$SFS_MODULE_SETUP[0]=
	array('var'=>"past", 'msg'=>"�w������������", 'value'=>"#CCCCCC");
$SFS_MODULE_SETUP[1] =
        array('var'=>"recent", 'msg'=>"�@�g����������", 'value'=>"#FFFFFF");
		
$SFS_MODULE_SETUP[2] =
        array('var'=>"far", 'msg'=>"�@�g�~��������", 'value'=>"#FFAAAA");
$SFS_MODULE_SETUP[3] =
        array('var'=>"days", 'msg'=>"�¬�����ܤѼ�", 'value'=>"30");
$SFS_MODULE_SETUP[4] =
        array('var'=>"doc", 'msg'=>"��k�s�����}", 'value'=>"readme.htm");
?>
