<?php

// $Id: module-cfg.php 7859 2014-01-17 13:03:38Z infodaes $

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

//���Ҳն��Ϥ��޲z�v
$MODULE_MAN = 1 ;

//�޲z�v����
$MODULE_MAN_DESCRIPTION = "�㦳�޲z�v�H��,�����y�w������\��,�@��ϥΪ̶ȥi�s�W���y";


//---------------------------------------------------
//
// 2.�o�̩w�q�G�Ҳդ���W�١A�к�²�R�W (�� "�Ҳ��v���]�w" �{���ϥ�)
//
// ���|��ܵ��ϥΪ�
//-----------------------------------------------


$MODULE_PRO_KIND_NAME = "�s�@���Z��";


//---------------------------------------------------
//
// 3. �o�̩w�q�G�Ҳժ���������T (�� "�۰ʧ�s�{��" ����)
//    �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//
//---------------------------------------------------

// �Ҳճ̫��s����
$MODULE_UPDATE_VER="1.1";

// �Ҳճ̫��s���
$MODULE_UPDATE="2003-09-04";

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
//���o�Ҳճ]�w
$m_arr = get_sfs_module_set();
extract($m_arr, EXTR_OVERWRITE);

if ($IS_JHORES=="6") {
$school_menu_p = array(
"chart_j.php"=>"�ꤤ���Z���@",
"chc_9401.php"=>"���������Z��",
"chc_seme.php"=>"��Ҧ��Z�ˬd",
"chc_seme_rank.php"=>"��Ҷi�h�B�d��",
"chc_check.php"=>"�U�Z���Z�ˬd"
);

} else {
$school_menu_p = array(
"chart_e.php"=>"��p���Z���@",
"chc_9401.php"=>"���������Z��",
"chc_seme.php"=>"��Ҧ��Z�ˬd",
"chc_seme_rank.php"=>"��Ҷi�h�B�d��",
"chc_check.php"=>"�U�Z���Z�ˬd"
);
}
$school_menu_p["chc_score_memo.php"]="�y�z��r�s��";

//�ؿ����{��

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
//	array('var'=>"IS_STANDALONE", 'msg'=>"�O�_���W�ߪ��ɭ�(1�O,0�_)", 'value'=>0);

$IS_MODULE_ARR = array("y"=>"�O","n"=>"�_");
$SFS_MODULE_SETUP[0] =array('var'=>"is_modify", 'msg'=>"���\�ϥΪ̽s����y���w", 'value'=>$IS_MODULE_ARR);

$LINE_WIDTH_ARR = array("0.01cm"=>"0.01cm","0.015cm"=>"0.015cm","0.02cm"=>"0.02cm","0.025cm"=>"0.025cm");
$SFS_MODULE_SETUP[1] =array('var'=>"line_width", 'msg'=>"���Z���u�e��", 'value'=>$LINE_WIDTH_ARR);

$LINE_COLOR_ARR = array("#000000"=>"�¦�","#FF0000"=>"����","#00008B"=>"�Ŧ�","#228B22"=>"���");
$SFS_MODULE_SETUP[2] =array('var'=>"line_color", 'msg'=>"���Z���u�C��", 'value'=>$LINE_COLOR_ARR);

$IMG_ARR= array("1.27cm"=>"1.27cm","1.5cm"=>"1.5cm","1.8cm"=>"1.8cm","2cm"=>"2cm","2.5cm"=>"2.5cm","3cm"=>"3cm","3.5cm"=>"3.5cm","4cm"=>"4cm");
$SFS_MODULE_SETUP[3] =array('var'=>"draw_img_width", 'msg'=>"ñ���e��", 'value'=>$IMG_ARR);
$SFS_MODULE_SETUP[4] =array('var'=>"draw_img_height", 'msg'=>"ñ������", 'value'=>$IMG_ARR);

$SIGN_ARR= array("0"=>"�ť�","1"=>"���ñ����","2"=>"��ܤ�r");
$SFS_MODULE_SETUP[5] =array('var'=>"sign_1_form", 'msg'=>"�ժ�ñ������ܤ覡", 'value'=>$SIGN_ARR);
$SFS_MODULE_SETUP[6] =array('var'=>"sign_2_form", 'msg'=>"�аȥD��ñ������ܤ覡", 'value'=>$SIGN_ARR);
$SFS_MODULE_SETUP[7] =array('var'=>"sign_3_form", 'msg'=>"�ǰȥD��ñ������ܤ覡", 'value'=>$SIGN_ARR);
$SFS_MODULE_SETUP[8] =array('var'=>"sign_1_name", 'msg'=>"�ժ��m�W", 'value'=>'');
$SFS_MODULE_SETUP[9] =array('var'=>"sign_2_name", 'msg'=>"�аȥD���m�W", 'value'=>'');
$SFS_MODULE_SETUP[10] =array('var'=>"sign_3_name", 'msg'=>"�ǰȥD���m�W", 'value'=>'');

$SIGN_3_TITLE_ARR=array("0"=>"�ǰȥD��","1"=>"�V�ɥD��","2"=>"�оɥD��");
$SFS_MODULE_SETUP[11] =array('var'=>"sign_3_title", 'msg'=>"�ǰȥD��¾��", 'value'=>$SIGN_3_TITLE_ARR);
$SFS_MODULE_SETUP[12] =array('var'=>"none_text", 'msg'=>"�������Z�������ǲߤ�r�ԭz", 'value'=>array("0"=>"�_","1"=>"�O"));
$SFS_MODULE_SETUP[13] =array('var'=>"text_title", 'msg'=>"�ǲߤ�r�ԭz���W(�ťծ���ܭ�W��)", 'value'=>'');

$DISABLE_SUBJECT_MEMO_TITLE_ARR=array("0"=>"�����","1"=>"���");
$SFS_MODULE_SETUP[14] =array('var'=>"disable_subject_memo_title", 'msg'=>"�ǲߤ�r�ԭz�O�_�V�ܤ���W��", 'value'=>$DISABLE_SUBJECT_MEMO_TITLE_ARR);

// �t�οﶵ
$SFS_TEXT_SETUP[] = array(
"g_id"=>3,
"var"=>"��`�欰��{",
"s_arr"=>array(1=>"��{�u��",2=>"��{�}�n",3=>"��{�|�i",4=>"�ݦA�[�o",5=>"���ݧ�i")
);
$SFS_TEXT_SETUP[] = array(
"g_id"=>3,
"var"=>"���鬡�ʪ�{",
"s_arr"=>array(1=>"��{�u��",2=>"��{�}�n",3=>"��{�|�i",4=>"�ݦA�[�o",5=>"���ݧ�i")
);
$SFS_TEXT_SETUP[] = array(
"g_id"=>3,
"var"=>"���@�A�Ȫ�{",
"s_arr"=>array(1=>"��{�u��",2=>"��{�}�n",3=>"��{�|�i",4=>"�ݦA�[�o",5=>"���ݧ�i")
);

$SFS_TEXT_SETUP[] = array(
"g_id"=>3,
"var"=>"�ե~�S���{",
"s_arr"=>array(1=>"��{�u��",2=>"��{�}�n",3=>"��{�|�i",4=>"�ݦA�[�o",5=>"���ݧ�i")
);
$SFS_TEXT_SETUP[] = array(
"g_id"=>3,
"var"=>"�V�O�{��",
"s_arr"=>array(1=>"��{�u��",2=>"��{�}�n",3=>"��{�|�i",4=>"�ݦA�[�o",5=>"���ݧ�i")
);


?>
