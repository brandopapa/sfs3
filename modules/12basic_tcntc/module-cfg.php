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

$MODULE_TABLE_NAME[0] = "12basic_tcntc";
$MODULE_TABLE_NAME[1] = "12basic_kind";


//---------------------------------------------------
//
// 2.�o�̩w�q�G�Ҳդ���W�١A�к�²�R�W (�� "�Ҳ��v���]�w" �{���ϥ�)
//
// ���|��ܵ��ϥΪ�
//-----------------------------------------------


$MODULE_PRO_KIND_NAME = "12�~��Ф���ϧK�դJ��";


//---------------------------------------------------
//
// 3. �o�̩w�q�G�Ҳժ���������T (�� "�۰ʧ�s�{��" ����)
//    �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//
//---------------------------------------------------

// �Ҳճ̫��s����
$MODULE_UPDATE_VER="1.0.0";

// �Ҳճ̫��s���
$MODULE_UPDATE="2012-10-03";


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
//$MENU_P = array("readme.php"=>"�ϥλ���","reference.php"=>"���@�ѷ�","student_list.php"=>"�ѻP�K�վǥ�","aspiration.php"=>"�ǥͧ��@��","nearby.php"=>"�N��J��","disadvantage.php"=>"�ߧU�z��","diversification.php"=>"�h���ǲ�","exam.php"=>"�Ш|�|��","output.php"=>"�ۥͳ��W�q�l�ɿ�X");
$MENU_P = array("readme.php"=>"�ϥλ���","student_list.php"=>"�ѻP�K�վǥ�","kind_mirror.php"=>"���������]�w","student_kind.php"=>"���W����","basic_data.php"=>"�򥻸��","aspiration.php"=>"1.���@��*","nearby.php"=>"2.�N��J��","disadvantage.php"=>"3.�ߧU�z��","diversification.php"=>"4.�h���ǲ�","exam.php"=>"5.�Ш|�|��*","sealed.php"=>"��ƫʦs","output_tmd.php"=>"�ձ��t�ιq�l�ɿ�X","output_103.php"=>"�ۥͨt�ιq�l�ɿ�X");
//,"output.php"=>"�ۥͳ��W�q�l�ɿ�X"

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

$school_nature_array = array("10"=>"�K�վǰϾǮ�","10"=>"�@�P�ǰϾǮ�","0"=>"�D�K�ե�D�@�P�ǰϾǮ�");

$SFS_MODULE_SETUP[]=array('var'=>"school_nature", 'msg'=>"����ϧK�դJ�ǾǮհѥ[���O", 'value'=>$school_nature_array);	
//$SFS_MODULE_SETUP[]=array('var'=>"aspiration_separateor", 'msg'=>"���@�C��覡", 'value'=>array("<br>"=>"�������C"," "=>"�H�ťդ��j"));
//$SFS_MODULE_SETUP[]=array('var'=>"kind_evaluate", 'msg'=>"�������O�v��<br>�@���,����,����(�y���{��),���߻�ê,��L,�ҥ~�u�q��ޤH�~�l�k,�F�����u��~�u�@�H���l�k,����,�X�å�", 'value'=>'0,10,20,30,40,50,60,70,80');
$SFS_MODULE_SETUP[]=array('var'=>"native_id", 'msg'=>"�����N��", 'value'=>9);
$SFS_MODULE_SETUP[]=array('var'=>"native_language_sort", 'msg'=>"�ڻy�{���ݩʰO������", 'value'=>3);
$SFS_MODULE_SETUP[]=array('var'=>"native_language_text", 'msg'=>"�q�L�ڻy�{�ҼаO��r", 'value'=>'�O');

$SFS_MODULE_SETUP[] =array('var'=>"remove_alarm", 'msg'=>"�M���ѻP����������", 'value'=>array("1"=>"�O","0"=>"�_"));
$SFS_MODULE_SETUP[] =array('var'=>"pic_checked", 'msg'=>"��ܾǥͤj�Y��", 'value'=>array("0"=>"�_","1"=>"�O"));
$SFS_MODULE_SETUP[] =array('var'=>"pic_width", 'msg'=>"�j�Y����ܪ��e��", 'value'=>'60');
$SFS_MODULE_SETUP[]=array('var'=>"comm_editable", 'msg'=>"�i�����ק�ǥͪ��p�����", 'value'=>array(0=>"�_",1=>"�O"));
$SFS_MODULE_SETUP[]=array('var'=>"kind_editable", 'msg'=>"�i�����ק鶴���O���", 'value'=>array(0=>"�_",1=>"�O"));
$SFS_MODULE_SETUP[]=array('var'=>"disadvantage_editable", 'msg'=>"�i�����ק�ߧU�z�կŤ�", 'value'=>array(0=>"�_",1=>"�O"));
$SFS_MODULE_SETUP[]=array('var'=>"diversification_editable", 'msg'=>"�i�����ק�h���ǲ߯Ť�", 'value'=>array(0=>"�_",1=>"�O"));
//$SFS_MODULE_SETUP[]=array('var'=>"personality_editable", 'msg'=>"�i�����ק�A�ʵo�i�Ť�", 'value'=>array(0=>"�_",1=>"�O"));
//$SFS_MODULE_SETUP[]=array('var'=>"fitness_keyword", 'msg'=>"���Ī���A���˴��������r", 'value'=>'�˴���');
$SFS_MODULE_SETUP[]=array('var'=>"uneditable_bgcolor", 'msg'=>"�w�ʦs�O���C�C��", 'value'=>'#ffffcc');
$SFS_MODULE_SETUP[]=array('var'=>"full_sealed_check", 'msg'=>"���ƫʦs�~���\��X", 'value'=>array(1=>"�O",0=>"�_"));
$SFS_MODULE_SETUP[]=array('var'=>"full_personal_profile", 'msg'=>"���W�ɿ�X����Ӹ�", 'value'=>array(1=>"�O",0=>"�_"));

$SFS_MODULE_SETUP[]=array('var'=>"data_source", 'msg'=>"�p����ƨӷ�", 'value'=>array(0=>"�³W�h�P�_",1=>"�̷ӧڪ����w"));
$SFS_MODULE_SETUP[]=array('var'=>"tel_family", 'msg'=>"�����q�ܸ�ƨӷ�", 'value'=>array(''=>"����X",'stud_tel_2'=>"�s���q��",'stud_tel_1'=>"���y�q��",'stud_tel_3'=>"��ʹq��"));
$SFS_MODULE_SETUP[]=array('var'=>"tel_mobile", 'msg'=>"��ʹq�ܸ�ƨӷ�", 'value'=>array(''=>"����X",'stud_tel_3'=>"��ʹq��",'stud_tel_1'=>"���y�q��",'stud_tel_2'=>"�s���q��"));
$SFS_MODULE_SETUP[]=array('var'=>"address_family", 'msg'=>"�q�T�a�}��ƨӷ�", 'value'=>array(''=>"����X",'stud_addr_2'=>"�s���a�}",'stud_addr_1'=>"���y�a�}"));



?>
