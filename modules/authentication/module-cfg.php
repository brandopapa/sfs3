<?php
//$Id: module-cfg.php 6064 2010-08-31 12:26:33Z infodaes $

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

$MODULE_TABLE_NAME[0] = "authentication_item";
$MODULE_TABLE_NAME[1] = "authentication_subitem";
$MODULE_TABLE_NAME[2] = "authentication_record";

//---------------------------------------------------
//
// 2.�o�̩w�q�G�Ҳդ���W�١A�к�²�R�W (�� "�Ҳ��v���]�w" �{���ϥ�)
//
// ���|��ܵ��ϥΪ�
//-----------------------------------------------


$MODULE_PRO_KIND_NAME = "�ǲ߻{��";


//---------------------------------------------------
//
// 3. �o�̩w�q�G�Ҳժ���������T (�� "�۰ʧ�s�{��" ����)
//    �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//
//---------------------------------------------------

// �Ҳճ̫��s����
$MODULE_UPDATE_VER="1.0.0";

// �Ҳճ̫��s���
$MODULE_UPDATE="2010-12-06";


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
"item.php"=>"���س]�w","subitem.php"=>"�ӥس]�w","authentication_list.php"=>"�{�ҥd","barcode_auth.php"=>"���X���˵n��","authentication.php"=>"���اO�{�ҵn�� ","authentication2.php"=>"�ǥͧO�{�ҵn��","seme_report.php"=>"�Ǵ��έp","class_report.php"=>"�Z�Ųέp","student_report.php"=>"�ӤH�{�Ҭ���","student_rank.php"=>"�Ʀ�]","new_authentication.php"=>"�̷s�{��");

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

$IS_MODULE_ARR = array("Y"=>"�O","N"=>"�_");

$SFS_MODULE_SETUP[0]=array('var'=>"types", 'msg'=>"�{�����O(�ХH�^��r��(\",\")���j)", 'value'=>"�y��,��|,�~��,��L");
$SFS_MODULE_SETUP[1]=array('var'=>"new_day_limit", 'msg'=>"�̷s�{�ҤѼƭ��w", 'value'=>7);
$SFS_MODULE_SETUP[2]=array('var'=>"zero_display", 'msg'=>"���Ƭ��s����ܤ�r", 'value'=>'�q�L');
$SFS_MODULE_SETUP[3]=array('var'=>"over_100_display", 'msg'=>"���ƶW�L100����ܤ�r", 'value'=>'�u��');
$SFS_MODULE_SETUP[4]=array('var'=>"header", 'msg'=>"�{�ҥd����", 'value'=>'�˷R���p�B�͡G<br>�@�@�o�O�z���Ǵ����ǲ߻{�Ҷ��ءA�Ʊ�z��M�P�Ǥ��۫j�y�A�@�_���@�ۤv����O��I');
$SFS_MODULE_SETUP[5]=array('var'=>"footer", 'msg'=>"�{�ҥd���}", 'value'=>'�ɮv�G�@�@�@�@�@�@�@�@�@�@�@�@�@�@�a��ñ���G');
$SFS_MODULE_SETUP[6]=array('var'=>"title_font_size", 'msg'=>"���Y�r��j�p", 'value'=>'24px');
$SFS_MODULE_SETUP[7]=array('var'=>"person_font_size", 'msg'=>"�ǥ͸�Ʀr��j�p", 'value'=>'12px');
$SFS_MODULE_SETUP[8]=array('var'=>"text_font_size", 'msg'=>"����r��j�p", 'value'=>'12px');
$SFS_MODULE_SETUP[9] =array('var'=>"Barcode_height", 'msg'=>"���X����?", 'value'=>'24');
?>
