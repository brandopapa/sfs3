<?php

// $Id: module-cfg.php 6662 2012-01-09 08:42:43Z infodaes $

// ��ƪ�W�٩w�q
$MODULE_TABLE_NAME[0] = "";
//$MODULE_TABLE_NAME[1] = "pro_check_new";

//�Ҳդ���W��
$MODULE_PRO_KIND_NAME = "�ǮսҪ�d�ߨt��";

// �Ҳճ̫��s����
$MODULE_UPDATE_VER="1.0";

// �Ҳճ̫��s���
$MODULE_UPDATE="2003-01-01";


// �ݭn�ϥκ޲z���v��
$MODULE_MAN=true;

//---------------------------------------------------
//
// 5. �o�̽Щw�q�G�z�o��{���ݭn�Ψ쪺�G�ܼƩα`��
//------------------------------^^^^^^^^^^
//
// (���Q�Q "�Ҳճ]�w" �{�����ު̡A�иm���)
//
// ��ĳ�G�о��q�έ^��j�g�өw�q�A�̦n�n��Ѧr���ݥX��N���N�q�C
//---------------------------------------------------


//�ؿ����{��
$school_menu_p = array(
"index.php"=>"�Z�ŽҪ�d��",
"teacher_class.php"=>"�Юv�Ҫ�d��",
"room_class.php"=>"�M��ЫǽҪ�d��" ,
"blank_class.php"=>"�Ű�d��"
);


//---------------------------------------------------
//
// 6. �o�̩w�q�G�w�]�ȭn�� "�Ҳճ]�w" �{���ӱ��ު̡A
//    �Y���Q�A�i�����]�w�C
//
// �榡�G var �N���ܼƦW��
//       msg �N����ܰT��
//       value �N���ܼƳ]�w��
//---------------------------------------------------

$SFS_MODULE_SETUP[0] =	array('var'=>"IS_STANDALONE", 'msg'=>"�O�_���W�ߪ��ɭ�", 'value'=>array("0"=>"�_","1"=>"�O"));

//$SFS_MODULE_SETUP[0] =
//	array('var'=>"IS_STANDALONE", 'msg'=>"�O�_���W�ߪ��ɭ�(1�O,0�_)", 'value'=>0);


// ��2,3,4....�ӡA�̦������G 

// $SFS_MODULE_SETUP[1] =
//	array('var'=>"xxxx", 'msg'=>"yyyy", 'value'=>0);

// $SFS_MODULE_SETUP[2] =
//	array('var'=>"ssss", 'msg'=>"tttt", 'value'=>1);

?>
