<?php

//---------------------------------------------------
//
// 1.�o�̩w�q�G�t���ܼ� (�� "�Ҳզw�˺޲z" �{���ϥ�)
//------------------------------------------
//
// "�Ҳզw�˺޲z" �{���|�g�J�Q�ժ� SFS/pro_kind ��
//
// ��ĳ�G�о��q�έ^��j�g�өw�q�A�̦n��Ѧr���ݥX��N���N�q�C
//---------------------------------------------------
// �z����⦹�@�Ҳթ�b���@�Өt�ΰ϶����O?
//
// �ثe�Ȧ��G�Ϩѱz���
//
// "�հȦ�F" �Ҳհ϶��N�X�G28
// "�u��c"  �Ҳհ϶��N�X�G161
//---------------------------------------------------

// �z�o�ӼҲժ��W�١A�N�O�z�o�ӼҲթ�m�b SFS �����ؿ��W��

$MODULE_NAME = "board";

//���Ҳն��Ϥ��޲z�v
$MODULE_MAN = 1 ;

//�޲z�v����
$MODULE_MAN_DESCRIPTION = "�㦳�޲z�v�H��,�i�R�ר�L�H���G�i";

//---------------------------------------------------
//
// 2.�o�̩w�q�G�Ҳո�ƪ�W�� (�� "�Ҳզw�˺޲z" �{���ϥ�)
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

$MODULE_TABLE_NAME[0] = "board_kind";
$MODULE_TABLE_NAME[1] = "board_p";
$MODULE_TABLE_NAME[2] = "board_check";

//
// 3.�o�̩w�q�G�Ҳդ���W�١A�к�²�R�W (�� "�Ҳզw�˺޲z" �{���ϥ�)
//
// ���|��ܵ��ϥΪ�
//-----------------------------------------------


$MODULE_PRO_KIND_NAME = "�հȧG�i��";


//---------------------------------------------------
//
// 4. �o�̩w�q�G�Ҳժ���������T (�� "�����t�ε{��" ����)
//
//---------------------------------------------------

// �Ҳժ���
$MODULE_VER="2.0.1";

// �Ҳյ{���@��
$MODULE_AUTHOR="hami";

// �Ҳժ��v����
$MODULE_LICENSE="";

// �Ҳե~��W��(�� "�Ҳճ]�w" �{���ϥ�)
$MODULE_DISPLAY_NAME="�հȧG�i��";

// �Ҳ����ݸs��
$MODULE_GROUP_NAME="�հȦ�F";

// �Ҳն}�l���
$MODULE_CREATE_DATE="2002-12-15";

// �Ҳճ̫��s���
$MODULE_UPDATE="2007-02-07 11:00:00";

// �Ҳէ�s��
$MODULE_UPDATE_MAN="brucelyc";


//---------------------------------------------------
//
// 5. �o�̽Щw�q�G�z�o��{���ݭn�Ψ쪺�G�ܼƩα`��
//------------------------------^^^^^^^^^^
//
// (���Q�Q "�Ҳճ]�w" �{�����ު̡A�иm���)
//
// ��ĳ�G�о��q�έ^��j�g�өw�q�A�̦n�n��Ѧr���ݥX��N���N�q�C
//---------------------------------------------------



//---------------------------------------------------
//
// 6. �o�̩w�q�G�w�]�ȭn�� "�Ҳճ]�w" �{���ӱ��ު̡A
//    �Y���Q�A�i�����]�w�C
//
// �榡�G var �N���ܼƦW��
//       msg �N����ܰT��
//       value �N���ܼƳ]�w��
//---------------------------------------------------

$SFS_MODULE_SETUP[] =
	array('var'=>"display_limit", 'msg'=>"���i������w", 'value'=>array("0"=>"�_","1"=>"�O"));
$SFS_MODULE_SETUP[] =
	array('var'=>"page_count", 'msg'=>"�C����ܵ���", 'value'=>15);
$SFS_MODULE_SETUP[] =
	array('var'=>"is_standalone", 'msg'=>"�O�_���W�ߪ��ɭ�", 'value'=>array("0"=>"�_","1"=>"�O"));
$SFS_MODULE_SETUP[] =
        array('var'=>"no_footer", 'msg'=>"�W�߬ɭ��O�_�h��������", 'value'=>array("0"=>"�_","1"=>"�O"));
$SFS_MODULE_SETUP[] =
	array('var'=>"insite_ip", 'msg'=>"�]�w����IP�d��,�d�ŮɨϥΨt�ιw�]��,��163.17.40 �� 163.17.40.1-163.17.40.128 ", 'value'=>'');
$SFS_MODULE_SETUP[] =
	array('var'=>"title_img", 'msg'=>"���D�ϳs��", 'value'=>"images/title.gif");
$SFS_MODULE_SETUP[] =
	array('var'=>"bg_img", 'msg'=>"�I���ϳs��", 'value'=>"images/backg.gif");
$SFS_MODULE_SETUP[] =
	array('var'=>"table_bg_color", 'msg'=>"��橳��", 'value'=>"#D0FFB9");
$SFS_MODULE_SETUP[] =
	array('var'=>"table_width", 'msg'=>"�����Ϊ�����j�p", 'value'=>"95%");
$SFS_MODULE_SETUP[] =
	array('var'=>"table_border_width", 'msg'=>"���ؽu�j�p", 'value'=>"1");
$SFS_MODULE_SETUP[] =
	array('var'=>"table_border_color", 'msg'=>"���ؽu�C��", 'value'=>"#BBDD89");
$SFS_MODULE_SETUP[] =
	array('var'=>"header_height", 'msg'=>"�����Y�C����(pt)", 'value'=>"25");
$SFS_MODULE_SETUP[] =
	array('var'=>"header_bg_color", 'msg'=>"�����Y����", 'value'=>"#CCCCFF");
$SFS_MODULE_SETUP[] =
	array('var'=>"header_text_size", 'msg'=>"�����Y��r�j�p(pt)", 'value'=>"12");
$SFS_MODULE_SETUP[] =
	array('var'=>"header_text_color", 'msg'=>"�����Y��r�C��", 'value'=>"#000099");
$SFS_MODULE_SETUP[] =
	array('var'=>"record_height", 'msg'=>"�����C��ܰ���(pt)", 'value'=>"25");
$SFS_MODULE_SETUP[] =
	array('var'=>"record_bg_color", 'msg'=>"�ƹ����L�����C����", 'value'=>"#AAFFCC");
$SFS_MODULE_SETUP[] =
	array('var'=>"offset_color", 'msg'=>"�_�����������C����t�Z", 'value'=>"20");
$SFS_MODULE_SETUP[] =
	array('var'=>"record_text_color", 'msg'=>"�����C��r�C��", 'value'=>"#000000");
$SFS_MODULE_SETUP[] =
	array('var'=>"font_size", 'msg'=>"�����C��r�j�p(pt)", 'value'=>"12");
$SFS_MODULE_SETUP[] =
	array('var'=>"enable_title", 'msg'=>"���¾����", 'value'=>array("1"=>"�O","0"=>"�_"));
$SFS_MODULE_SETUP[] =
	array('var'=>"enable_days", 'msg'=>"��ܤ��i�Ѽ���", 'value'=>array("1"=>"�O","0"=>"�_"));
$SFS_MODULE_SETUP[] =
	array('var'=>"enable_point", 'msg'=>"����I�\����", 'value'=>array("1"=>"�O","0"=>"�_"));
$SFS_MODULE_SETUP[] =
	array('var'=>"enable_is_sign", 'msg'=>"�ҥΦ^ñ�\��", 'value'=>array("1"=>"�O","0"=>"�_"));
$SFS_MODULE_SETUP[] =
	array('var'=>"enable_is_html", 'msg'=>"HTML�s�边", 'value'=>array(""=>"���ҥ�","Basic"=>"��","Default"=>"����"));
$SFS_MODULE_SETUP[] =
        array('var'=>"top_item", 'msg'=>"������椧�޾ɿﶵ", 'value'=>"�հȧG�i��");
$SFS_MODULE_SETUP[] =
        array('var'=>"bg_color", 'msg'=>"��������", 'value'=>"#CCFFCC");
$SFS_MODULE_SETUP[] =
        array('var'=>"login_force", 'msg'=>"�j��n�J�~���˵����i���e", 'value'=>array("0"=>"�_","1"=>"�O"));

$SFS_MODULE_SETUP[] =
        array('var'=>"marquee_backcolor", 'msg'=>"(���i�]���O)--�I����", 'value'=>"yellow");
$SFS_MODULE_SETUP[] =
       array('var'=>"marquee_fontcolor", 'msg'=>"(���i�]���O)--�r���C��", 'value'=>"blue");
$SFS_MODULE_SETUP[] =
       array('var'=>"marquee_height", 'msg'=>"(���i�]���O)--����", 'value'=>"");
$SFS_MODULE_SETUP[] =
        array('var'=>"marquee_behavior", 'msg'=>"(���i�]���O)--���e���ʤ覡", 'value'=>"scroll");
$SFS_MODULE_SETUP[] =
        array('var'=>"marquee_direction", 'msg'=>"(���i�]���O)--���e���ʤ�V", 'value'=>"left");
$SFS_MODULE_SETUP[] =
        array('var'=>"marquee_scrollamount", 'msg'=>"(���i�]���O)--�C�����e���ʶZ��", 'value'=>"5");
?>
