<?php
//$Id: $

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

$MODULE_TABLE_NAME[0] = "12basic_ylc";
$MODULE_TABLE_NAME[1] = "12basic_kind_ylc";

//---------------------------------------------------
//
// 2.�o�̩w�q�G�Ҳդ���W�١A�к�²�R�W (�� "�Ҳ��v���]�w" �{���ϥ�)
//
// ���|��ܵ��ϥΪ�
//-----------------------------------------------


$MODULE_PRO_KIND_NAME = "12�~��ж��L�ϧK�դJ��";


//---------------------------------------------------
//
// 3. �o�̩w�q�G�Ҳժ���������T (�� "�۰ʧ�s�{��" ����)
//    �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//
//---------------------------------------------------

// �Ҳճ̫��s����
$MODULE_UPDATE_VER="1.2.1";

// �Ҳճ̫��s���
$MODULE_UPDATE="2017-11-20";


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
//$MENU_P = array("readme.php"=>"�ϥλ���","student_list.php"=>"�ѻP�K�վǥ�","kind_mirror.php"=>"���������]�w","student_kind.php"=>"���W���","aspiration.php"=>"���@��","disadvantage.php"=>"�ߧU�z��","nearby.php"=>"�N��J��","morality.php"=>"�~�w�A��","diversification.php"=>"�h���ǲ�","exam.php"=>"�Ш|�|��",'transcript.php'=>'���Z�ҩ���',"output.php"=>"�ۥͳ��W�q�l�ɿ�X");
//$MENU_P = array("readme.php"=>"�ϥλ���","student_list.php"=>"�ѻP�K�վǥ�","kind_mirror.php"=>"���������]�w","student_kind.php"=>"���W���","disadvantage.php"=>"�ߧU�z��","nearby.php"=>"�N��J��","morality.php"=>"�~�w�A��","diversification.php"=>"�h���ǲ�",'sealed.php'=>"��ƫʦs",'transcript.php'=>'���Z�ҩ���','transcript_chk.php'=>'�n���f�d��',"output.php"=>"�ۥͳ��W�q�l�ɿ�X","output_tmd.php"=>"�ձ��t�ιq�l�ɿ�X");

$MENU_P = array("readme.php"=>"�ϥλ���","student_list.php"=>"�ѻP�K�վǥ�","kind_mirror.php"=>"���������]�w","student_kind.php"=>"���W���","disadvantage.php"=>"�ߧU�z��","nearby.php"=>"�N��J��","morality.php"=>"�~�w�A��","diversification.php"=>"�h���ǲ�",'sealed.php'=>"��ƫʦs",'transcript.php'=>'���Z�ҩ���',"output.php"=>"�ۥͳ��W�q�l�ɿ�X","output_tmd.php"=>"�ձ��t�ιq�l�ɿ�X");


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

//�{�w�����B�ثe�Ľu�W�ק�  $SFS_MODULE_SETUP[]=array('var'=>"remote_school", 'msg'=>"�ŦX�����p��", 'value'=>array(0=>"����",2=>"9�Z�H�U",1=>"13�Z�H�U"));
$school_nature_array = array("5"=>"�ŦX�N��J�ǾǮ�","0"=>"���ŴN��J�ǾǮ�");
$SFS_MODULE_SETUP[0]=array('var'=>"school_nature", 'msg'=>"���ղŦX�N��J��", 'value'=>$school_nature_array);
$school_remote_array = array("0"=>"���ŦX�����p��","2"=>"�ŦX�����p��(7�Z�H�U)","1"=>"�ŦX�����p��(8-12�Z)");
$SFS_MODULE_SETUP[1]=array('var'=>"school_remote", 'msg'=>"���ղŦX�����p��", 'value'=>$school_remote_array);
$SFS_MODULE_SETUP[2]=array('var'=>"moral_editable", 'msg'=>"���\�����ק�~�w�A�ȯŤ�", 'value'=>array(1=>"�O",0=>"�_"));
$SFS_MODULE_SETUP[3]=array('var'=>"diversification_editable", 'msg'=>"���\�����ק�h���ǲ߯Ť�", 'value'=>array(1=>"�O",0=>"�_"));
$SFS_MODULE_SETUP[4]=array('var'=>"exam_editable", 'msg'=>"���\�����ק�Ш|�|�үŤ�", 'value'=>array(1=>"�O",0=>"�_"));
$SFS_MODULE_SETUP[5] =array('var'=>"pic_checked", 'msg'=>"��ܾǥͤj�Y��", 'value'=>array("0"=>"�_","1"=>"�O"));
$SFS_MODULE_SETUP[6] =array('var'=>"pic_width", 'msg'=>"�j�Y����ܪ��e��", 'value'=>'60');
//$SFS_MODULE_SETUP[]=array('var'=>"aspiration_separateor", 'msg'=>"���@�C��覡", 'value'=>array("<br>"=>"�������C"," "=>"�H�ťդ��j"));
$SFS_MODULE_SETUP[]=array('var'=>"kind_evaluate", 'msg'=>"�������O�v��<br>�@���,����,����(�y���{��),���߻�ê,��L,�ҥ~�u�q��ޤH�~�l�k,�F�����u��~�u�@�H���l�k,����,�X�å�", 'value'=>'0,10,20,30,40,50,60,70,80');
$SFS_MODULE_SETUP[]=array('var'=>"native_id", 'msg'=>"�����N��", 'value'=>9);
$SFS_MODULE_SETUP[]=array('var'=>"native_language_sort", 'msg'=>"�ڻy�{���ݩʰO������", 'value'=>3);
$SFS_MODULE_SETUP[]=array('var'=>"native_language_text", 'msg'=>"�q�L�ڻy�{�ҼаO��r", 'value'=>'�O');
$SFS_MODULE_SETUP[]=array('var'=>"full_personal_profile", 'msg'=>"���W�ɿ�X����Ӹ�", 'value'=>array(1=>"�O",0=>"�_"));
$SFS_MODULE_SETUP[]=array('var'=>"uneditable_bgcolor", 'msg'=>"�w�ʦs�O���C�C��", 'value'=>'#ffffcc');
$SFS_MODULE_SETUP[]=array('var'=>"full_sealed_check", 'msg'=>"���ƫʦs�~���\��X", 'value'=>array(0=>"�_",1=>"�O"));

?>
