<?php

// $Id: module-cfg.php 7881 2014-02-20 07:01:42Z infodaes $

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


$MODULE_PRO_KIND_NAME = "�ŰȺ޲z";


//---------------------------------------------------
//
// 3. �o�̩w�q�G�Ҳժ���������T (�� "�۰ʧ�s�{��" ����)
//    �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//
//---------------------------------------------------

// �Ҳճ̫��s����
$MODULE_UPDATE_VER="1.0.1";

// �Ҳճ̫��s���
$MODULE_UPDATE="2003-4-8 13:45:00";

//���n�ҲաA�K�Q�ŧR
$SYS_MODULE=1;
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

//�P��
$week_array=array("��", "�@", "�G", "�T", "�|", "��", "��");
$monthNames = array("1"=>"�@��", "�G��", "�T��", "�|��", "����", "����","�C��", "�K��", "�E��", "�Q��", "�Q�@��", "�Q�G��");

$button["Excel"]="MS Office Excel ��";
$button["Word"]="MS Office Word ��";
$button["sxw"]="OpenOffice.org Writer ��";
while(list($k,$v)=each($button)){
                $import_option.="<option value='$k'>$v</option>\n";
}
$import_option = "<select name='print_key' size='1'>$import_option</select>";

$today=date("Y-m-d");
//�C�X��V���s�����Ҳ�

$menu_p = array(
"name_form.php"=>"�Z�ŦW��",
"address_book_th.php"=>"�Юv��U�W��",
"address_book.php"=>"�Z�ųq�T��",
"address_book2.php"=>"�q�T��2",
"stud_birth.php"=>"����έp",
"stud_star_list.php"=>"�P�y�έp",
"stud_kind2.php"=>"�S�����O",
"select_behalf2.php"=>"�Z�N�����",
"parent_manage.php"=>"�a���b���޲z",
"link_parent.php"=>"�p��ï�޲z",
"absent_list.php"=>"�ǥͯʮu�O��",
"service_class_list.php"=>"�A�Ⱦǲ߰O��");
if ($is_absent=='y') $menu_p["absent_class.php"]="���m�Ҭ���";
if ($course_input) $menu_p["course_setup3.php"]="�]�w�\�Ҫ�";
$menu_p["score_query.php"]="���q���Z�C��";
if ($is_sms) {
	$menu_p["sms_guardian.php"]="�o�e²�T";
	$menu_p["sms_record.php"]="²�T�o�e�O��";
}
if($is_rewrad) $menu_p["reward_list.php"]="�ǥͼ��g�O��";

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

// =
//        array('var'=>"IS_STANDALONE", 'msg'=>"�O�_���W�ߪ��ɭ�(1�O,0�_)", 'value'=>0);


// ��2,3,4....�ӡA�̦������G

$SFS_MODULE_SETUP[0] = array('var'=>"is_absent", 'msg'=>"�O�_�}�����ť��Ѯv�n���ǥͥX�ʮu�O��", 'value'=>array("n"=>"�_","y"=>"�O"));
$SFS_MODULE_SETUP[1] = array('var'=>"course_input", 'msg'=>"�O�_�i�H�ק�Ҫ�", 'value'=>array("0"=>"�_","1"=>"�O"));
$SFS_MODULE_SETUP[2] = array('var'=>"influenza", 'msg'=>"�O�_�ҥάy�P�n��", 'value'=>array("0"=>"�_","1"=>"�O"));
$SFS_MODULE_SETUP[3] = array('var'=>"is_sms", 'msg'=>"�O�_�ҥ�²�T�\��", 'value'=>array("0"=>"�_","1"=>"�O"));
$SFS_MODULE_SETUP[4] = array('var'=>"is_rewrad", 'msg'=>"�O�_�ҥΦC�����g�\��", 'value'=>array("0"=>"�_","1"=>"�O"));

// $SFS_MODULE_SETUP[2] =
//        array('var'=>"ssss", 'msg'=>"tttt", 'value'=>1);

?>
