<?php
//$Id: module-cfg.php 6414 2011-04-21 08:23:58Z infodaes $

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

$MODULE_TABLE_NAME[0] = "charge_item";
$MODULE_TABLE_NAME[1] = "charge_detail";
$MODULE_TABLE_NAME[2] = "charge_decrease";
$MODULE_TABLE_NAME[3] = "charge_record";


//---------------------------------------------------
//
// 2.�o�̩w�q�G�Ҳդ���W�١A�к�²�R�W (�� "�Ҳ��v���]�w" �{���ϥ�)
//
// ���|��ܵ��ϥΪ�
//-----------------------------------------------


$MODULE_PRO_KIND_NAME = "���O�޲z";


//---------------------------------------------------
//
// 3. �o�̩w�q�G�Ҳժ���������T (�� "�۰ʧ�s�{��" ����)
//    �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//
//---------------------------------------------------

// �Ҳճ̫��s����
$MODULE_UPDATE_VER="1.0.0";

// �Ҳճ̫��s���
$MODULE_UPDATE="2006-07-10";


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
"item.php"=>"���س]�w","detail.php"=>"�ӥس]�w","list.php"=>"���O�W��","decrease.php"=>"��K�]�w","decrease_class.php"=>"�Z�Ŵ�K","csv.php"=>"CSV��X","announce.php"=>"���O�q��","received.php"=>"ú�ڵn��","barcode.php"=>"���X���ڵn��","paid_summary.php"=>"���ڲέp","paid_list.php"=>"ú�ڲM�U","hie.php"=>"��ú�M�U","record.php"=>"�������@","class_summary.php"=>"�Z�Ųέp","detail_summary.php"=>"�ӥزέp");

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

$SFS_MODULE_SETUP[0]=
	array('var'=>"types", 'msg'=>"���O���O(�ХH�^��r��(\",\")���j)", 'value'=>"���U�O,�ҫᦫ�|,�ǲ߻���,�~�����");
$SFS_MODULE_SETUP[1] =
        array('var'=>"is_sort", 'msg'=>"���ثe�ɱƧǥN��? ( �O/�_ )", 'value'=>$IS_MODULE_ARR);
$SFS_MODULE_SETUP[2]=
	array('var'=>"authority", 'msg'=>"�̾ڰѷ�(�ХH�^��r��(\",\")���j)", 'value'=>"�x�����F���а�r��XXXXXX����,�x�����F���оǦr��XXXXXX����,����XX�Ǧ~��X�Ǵ�XXX��I�p�e,");
$SFS_MODULE_SETUP[3]=
	array('var'=>"paid_method", 'msg'=>"ú�ڤ覡�ѷ�(�ХH�^��r��(\",\")���j)", 'value'=>"��ú��ܯZ�žɮv,XX�l���N���@�b���Gxx-xxx-xxxx-x,XX�Ȧ�XX����N���@�b���Gxx-xxx-xxxx-x,��ú��ܣA�A�B�A�A��,");
$SFS_MODULE_SETUP[4]=
	array('var'=>"footer", 'msg'=>"���O��ڵ��}", 'value'=>"�g��H�G�@�@�@�@�@�@�@�@�X�ǡG�������@�@�@�@�@�@�@�|�p�G�}�����@�@�@�@�@�@�@�ժ��G������");
$SFS_MODULE_SETUP[5]=
	array('var'=>"detail_types", 'msg'=>"�ӥئ��k�b��ѷ�(�ХH�^��r��(\",\")���j)", 'value'=>"�Ǯդ��w,�X�@��");
$SFS_MODULE_SETUP[6]=
	array('var'=>"detail_lists", 'msg'=>"�ӥئ��k�b��ѷӦC������(�ХH�^��r��(\",\")���j)", 'value'=>"10,10");
?>
