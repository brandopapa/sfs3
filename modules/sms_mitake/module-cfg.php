<?php

// $Id: $

$MODULE_PRO_KIND_NAME = "MITAKE²�T�N�o";


// �ݭn�ϥκ޲z���v��
$MODULE_MAN=true;

// ��ƪ�W�٩w�q

$MODULE_TABLE_NAME[0] = "sms_mitake_record";


//---------------------------------------------------
//
// 3. �o�̩w�q�G�Ҳժ���������T (�� "�۰ʧ�s�{��" ����)
//    �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//
//---------------------------------------------------

// �Ҳճ̫��s����
$MODULE_UPDATE_VER="1.0";

// �Ҳճ̫��s���
$MODULE_UPDATE="2012-7-1";

//���n�ҲաA�K�Q�ŧR
$SYS_MODULE=0;


$yes_or_no = array("1"=>"�O","0"=>"�_");
 $SFS_MODULE_SETUP[1] =	array('var'=>"usr", 'msg'=>"�b��", 'value'=>'');
 $SFS_MODULE_SETUP[2] =	array('var'=>"pwd", 'msg'=>"�K�X", 'value'=>'');
 $SFS_MODULE_SETUP[3] =	array('var'=>"sign_name", 'msg'=>"²�T���e�j��W�[�o�e�̩m�W", 'value'=>$yes_or_no);
 $SFS_MODULE_SETUP[4] =	array('var'=>"room_select", 'msg'=>"�B�ǿ���覡", 'value'=>array('0'=>'�ﶵ��','1'=>'�U�Ԧ�'));
 $SFS_MODULE_SETUP[5] =	array('var'=>"class_select", 'msg'=>"�Z�ſ���覡", 'value'=>array('0'=>'�ﶵ��','1'=>'�U�Ԧ�'));


?>
