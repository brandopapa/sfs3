<?php

// $Id: module-cfg.php 6104 2010-09-08 03:44:46Z infodaes $

// ��ƪ�W�٩w�q
$MODULE_TABLE_NAME[0] = "sfs_module";
//$MODULE_TABLE_NAME[1] = "pro_check_new";

//�Ҳդ���W��
$MODULE_PRO_KIND_NAME = "�Ҳպ޲z";

// �Ҳճ̫��s����
$MODULE_UPDATE_VER="1.2";

// �Ҳճ̫��s���
$MODULE_UPDATE="2009-06-01";

//�t�έ��n�Ҳ�
$SYS_MODULE=1;

//---------------------------------------------------
//
// 5. �o�̽Щw�q�G�z�o��{���ݭn�Ψ쪺�G�ܼƩα`��
//------------------------------^^^^^^^^^^
//
// (���Q�Q "�Ҳճ]�w" �{�����ު̡A�иm���)
//
// ��ĳ�G�о��q�έ^��j�g�өw�q�A�̦n�n��Ѧr���ݥX��N���N�q�C
//---------------------------------------------------

$MODULE_DIR=$SFS_PATH."/modules/";

//�ؿ����{��
$school_menu_p = array(
"index.php"=>"�Ҳպ޲z",
"add_kind.php"=>"�s�W����",
"add_module.php"=>"�s�W�Ҳ�",
"del_module.php"=>"�����Ҳ�",
"garbage_sql.php"=>"�^����",
"limit_adm.php"=>"�v���C��",
"up_list.php"=>"�ҲդɯŰT��",
"up_list2.php"=>"�Ҳէ�s���A"
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
	
	
$SFS_MODULE_SETUP[0] =
        array('var'=>"IS_REUPGRADE",'msg'=>"�O�_��ܭ��s�ɯųs��( �O/�_ )?",'value'=>array(''=>'�_','Y'=>'�O'));
		
// ��2,3,4....�ӡA�̦������G 

// $SFS_MODULE_SETUP[1] =
//	array('var'=>"xxxx", 'msg'=>"yyyy", 'value'=>0);

// $SFS_MODULE_SETUP[2] =
//	array('var'=>"ssss", 'msg'=>"tttt", 'value'=>1);

?>
