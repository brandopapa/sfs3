<?php



// $Id: module-cfg.php 5310 2009-01-10 07:57:56Z hami $



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



$MODULE_TABLE_NAME[0] = "lunch_feedback";



//---------------------------------------------------

//

// 2.�o�̩w�q�G�Ҳդ���W�١A�к�²�R�W (�� "�Ҳ��v���]�w" �{���ϥ�)

//

// ���|��ܵ��ϥΪ�

//-----------------------------------------------





$MODULE_PRO_KIND_NAME = "���\�N���լd";



// �ݭn�ϥκ޲z���v��
$MODULE_MAN=true;


//---------------------------------------------------

//

// 3. �o�̩w�q�G�Ҳժ���������T (�� "�۰ʧ�s�{��" ����)

//    �o�Ϫ� "�ܼƦW��" �Фŧ���!!!

//

//---------------------------------------------------



// �Ҳճ̫��s����

$MODULE_UPDATE_VER="1.0";



// �Ҳճ̫��s���

$MODULE_UPDATE="2006-09-17";



//�ؿ����{��
$MENU_P = array(
"feedback.php"=>"�N�����","class_list.php"=>"���G�C��","memo_summary.php"=>"��r�N���׾�","analysis.php"=>"���N�ײέp���R");


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



//---------------------------------------------------



$SFS_MODULE_SETUP[0] =
	array('var'=>"quantity_ref", 'msg'=>"�ƶq���N�׽լd�ﶵ(�Х�,���j)", 'value'=>"�Ӧh,�Ӥ�,�A�q");

$SFS_MODULE_SETUP[1] =
	array('var'=>"taste_ref", 'msg'=>"�⭻�����N�׽լd�ﶵ(�Х�,���j)", 'value'=>"���N,�|�i,����i");

$SFS_MODULE_SETUP[2] =
	array('var'=>"hygiene_ref", 'msg'=>"�åͦw�����N�׽լd�ﶵ(�Х�,���j)", 'value'=>"���N,�|�i,����i");

$SFS_MODULE_SETUP[3] =
	array('var'=>"period", 'msg'=>"�i�������Ѽ�", 'value'=>7);
	
$SFS_MODULE_SETUP[4] =
	array('var'=>"list_period", 'msg'=>"�C���[������Ѽ�", 'value'=>30);
	
$IS_MODULE_ARR = array("Y"=>"�O","N"=>"�_");
$SFS_MODULE_SETUP[5] =
	array('var'=>"warning", 'msg'=>"��ܩ|������Z��?( �O/�_ )", 'value'=>$IS_MODULE_ARR);


// ��2,3,4....�ӡA�̦������G 



// $SFS_MODULE_SETUP[1] =

//	array('var'=>"xxxx", 'msg'=>"yyyy", 'value'=>0);



// $SFS_MODULE_SETUP[2] =

//	array('var'=>"ssss", 'msg'=>"tttt", 'value'=>1);



?>