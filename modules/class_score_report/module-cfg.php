<?php
// $Id: $

//---------------------------------------------------
//
// 1.�o�̩w�q�G�Ҳո�ƪ�W�� (�� "�Ҳ��v���]�w" �{���ϥ�)
//   �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//-----------------------------------------------
//
// �Y���@�ӥH�W�A�б���  �}�C�өw�q
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

$MODULE_TABLE_NAME[0] = "";

//---------------------------------------------------
//
// 2.�o�̩w�q�G�Ҳդ���W�١A�к�²�R�W (�� "�Ҳ��v���]�w" �{���ϥ�)
//
// ���|��ܵ��ϥΪ�
//-----------------------------------------------


$MODULE_PRO_KIND_NAME = "�Z�žǴ���즨�Z�U";


//---------------------------------------------------
//
// 3. �o�̩w�q�G�Ҳժ���������T (�� "�۰ʧ�s�{��" ����)
//    �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//
//---------------------------------------------------

// �Ҳճ̫��s����
$MODULE_UPDATE_VER="1.0";

// �Ҳճ̫��s���
$MODULE_UPDATE="2012/1/13";

//���n�ҲաA�K�Q�ŧR
$SYS_MODULE=0;
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
// �Ա��аѦ� include/sfs_core_module.php ���������C
//
// �o�Ϫ� "�ܼƦW�� $SFS_MODULE_SETUP" �Фŧ���!!!
//---------------------------------------------------
$SFS_MODULE_SETUP[]=array('var'=>"behavior_script", 'msg'=>"�͵��C�L����ܤ�`�ͬ���{", 'value'=>array(1=>'�O',0=>'�_'));
$SFS_MODULE_SETUP[]=array('var'=>"style", 'msg'=>"����˦�", 'value'=>array(1=>'���Z�P��`�ͬ���{�X�C',0=>'���Z�P��`�ͬ���{���C'));
$SFS_MODULE_SETUP[]=array('var'=>"title", 'msg'=>"����W��", 'value'=>'�Ǵ����Z�U');
$SFS_MODULE_SETUP[]=array('var'=>"title_font_name", 'msg'=>"������Y�r��W��", 'value'=>'�з���');
$SFS_MODULE_SETUP[]=array('var'=>"title_font_size", 'msg'=>"������Y�r��j�p", 'value'=>'22px');
$SFS_MODULE_SETUP[]=array('var'=>"text_size", 'msg'=>"����r��j�p", 'value'=>'12px');
$SFS_MODULE_SETUP[]=array('var'=>"percision", 'msg'=>"���Z��ܪ����", 'value'=>array(1=>'���',2=>'�p��1��',3=>'�p��2��'));
$SFS_MODULE_SETUP[]=array('var'=>"class_width", 'msg'=>"�Z������ܼe��", 'value'=>60);
$SFS_MODULE_SETUP[]=array('var'=>"num_width", 'msg'=>"�y������ܼe��", 'value'=>25);
$SFS_MODULE_SETUP[]=array('var'=>"id_width", 'msg'=>"�Ǹ�����ܼe��", 'value'=>40);
$SFS_MODULE_SETUP[]=array('var'=>"name_width", 'msg'=>"�m�W����ܼe��", 'value'=>60);
$SFS_MODULE_SETUP[]=array('var'=>"area_width", 'msg'=>"���Z����ܼe��", 'value'=>30);
$SFS_MODULE_SETUP[]=array('var'=>"avg_width", 'msg'=>"�������Z����ܼe��", 'value'=>40);
$SFS_MODULE_SETUP[]=array('var'=>"header_bgcolor", 'msg'=>"���W��ܩ���", 'value'=>'#ccffcc');
$SFS_MODULE_SETUP[]=array('var'=>"area_avg_bgcolor", 'msg'=>"��쥭�����Z����ܩ���", 'value'=>'#ffffcc');
$SFS_MODULE_SETUP[]=array('var'=>"print_sign_row", 'msg'=>"ñ���C", 'value'=>array('Y'=>'�O','N'=>'�_'));
$SFS_MODULE_SETUP[]=array('var'=>"sign_row", 'msg'=>"ñ���C", 'value'=>'�ɮv�G�@�@�@�@�@�@�@�@�@�@�@�@�@�аȥD���G�@�@�@�@�@�@�@�@�@�@�@�@�@�ժ��G');

?>
