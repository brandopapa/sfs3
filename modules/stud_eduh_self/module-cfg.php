<?php

// $Id: module-cfg.php 7745 2013-11-01 04:18:10Z infodaes $

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

$MODULE_TABLE_NAME[0] = "";

//---------------------------------------------------
//
// 2.�o�̩w�q�G�Ҳդ���W�١A�к�²�R�W (�� "�Ҳ��v���]�w" �{���ϥ�)
//
// ���|��ܵ��ϥΪ�
//-----------------------------------------------


$MODULE_PRO_KIND_NAME = "�ǥ͸�Ʀ۫�";


//---------------------------------------------------
//
// 3. �o�̩w�q�G�Ҳժ���������T (�� "�۰ʧ�s�{��" ����)
//    �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//
//---------------------------------------------------

// �Ҳճ̫��s����
$MODULE_UPDATE_VER="1.0.0";

// �Ҳճ̫��s���
$MODULE_UPDATE="2013/01/14";


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


// �ݶ�


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
// $ret_array =& get_module_setup("stud_eduh")
//
//
// �Ա��аѦ� include/sfs_core_module.php ���������C
//
// �o�Ϫ� "�ܼƦW�� $SFS_MODULE_SETUP" �Фŧ���!!!
//---------------------------------------------------

//$SFS_MODULE_SETUP[] =	array('var'=>'ha_checkary', 'msg'=>'�ҥΰ��O�d���ҥ\��', 'value'=>array('1'=>'�O','0'=>'�_'));
$SFS_MODULE_SETUP[] =   array('var'=>'ha_checkary', 'msg'=>'���O�d���ҥ\��', 'value'=>array('1'=>'�ե~�ϥλݭn','2'=>'�դ��~�ϥΧ��ݭn','0'=>'���ҥ�'));
$SFS_MODULE_SETUP[] =	array('var'=>'base_edit', 'msg'=>'�}��򥻸�����ǥͦۦ�s��', 'value'=>array('0'=>'�L�k���','-1'=>'�ȥi�s��','1'=>'���\�ק�'));
$SFS_MODULE_SETUP[] =	array('var'=>'dom_edit', 'msg'=>'�}����y������ǥͦۦ�s��', 'value'=>array('0'=>'�_','1'=>'�O'));
$SFS_MODULE_SETUP[] =	array('var'=>'club_enable', 'msg'=>'�ҥΪ��ά��ʾǥͼҲ�', 'value'=>array('0'=>'�_','1'=>'�O'));
$SFS_MODULE_SETUP[] =	array('var'=>'service_enable', 'msg'=>'�ҥΪA�Ⱦǲ߾ǥͼҲ�', 'value'=>array('0'=>'�_','1'=>'�O'));
$SFS_MODULE_SETUP[] =	array('var'=>"feedback_deadline", 'msg'=>"��g�A�Ⱦǲߦۧڬ٫����?�]�X�餺������g�����^", 'value'=>"60");
$SFS_MODULE_SETUP[] =	array('var'=>'career_contact', 'msg'=>'�ҥΥͲP����-�ɮv�λ��ɱЮv��g�\��', 'value'=>array('0'=>'�_','1'=>'�O'));
	$SFS_MODULE_SETUP[] =	array('var'=>'contact_months', 'msg'=>'�ɮv�λ��ɱЮv��g���', 'value'=>'09,10,02,03');
$SFS_MODULE_SETUP[] =	array('var'=>'mystory', 'msg'=>'�ҥΥͲP����-�ڪ������G�ƶ�g�\��', 'value'=>array('0'=>'�_','1'=>'�O'));
	$SFS_MODULE_SETUP[] =	array('var'=>'mystory_months', 'msg'=>'�ڪ������G�ƶ�g���', 'value'=>'09');
$SFS_MODULE_SETUP[] =	array('var'=>'psy_test', 'msg'=>'�ҥ��˵��ͲP����-�U���߲z����\��', 'value'=>array('0'=>'�_','1'=>'�O'));
	$SFS_MODULE_SETUP[] =	array('var'=>'psy_test_months', 'msg'=>'�U���߲z�����g���', 'value'=>'');
$SFS_MODULE_SETUP[] =	array('var'=>'study_spe', 'msg'=>'�ҥΥͲP����-�ǲߦ��G�ίS���{��g�\��', 'value'=>array('0'=>'�_','1'=>'�O'));
	$SFS_MODULE_SETUP[] =	array('var'=>'cadre_result', 'msg'=>'�ǥͥi��g�F�����', 'value'=>array('0'=>'�_','1'=>'�O'));
	$SFS_MODULE_SETUP[] =	array('var'=>'race_result', 'msg'=>'�ǥͥi��g�v�ɦ��G���', 'value'=>array('0'=>'�_','1'=>'�O'));
	$SFS_MODULE_SETUP[] =	array('var'=>'study_spe_months', 'msg'=>'�ǲߦ��G�ίS���{��g���', 'value'=>'09,03');
	$SFS_MODULE_SETUP[] =	array('var'=>'explore_exclude', 'msg'=>'�ͲP�ձ����ʬ��������������', 'value'=>array('0'=>'�_','1'=>'�O'));
$SFS_MODULE_SETUP[] =	array('var'=>'career_view', 'msg'=>'�ҥΥͲP����-�ͲP�ξ㭱���[��g�\��', 'value'=>array('0'=>'�_','1'=>'�O'));
	$SFS_MODULE_SETUP[] =	array('var'=>'view_months', 'msg'=>'�ͲP�ξ㭱���[��g���', 'value'=>'03');
$SFS_MODULE_SETUP[] =	array('var'=>'career_evaluate', 'msg'=>'�ҥΥͲP����-�ͲP�o�i�W���Ѷ�g�\��', 'value'=>array('0'=>'�_','1'=>'�O'));
	$SFS_MODULE_SETUP[] =	array('var'=>'evaluate_months', 'msg'=>'�ͲP�o�i�W���Ѷ�g���', 'value'=>'03,04,05');
$SFS_MODULE_SETUP[] =	array('var'=>'career_guidance', 'msg'=>'�ҥΥͲP����-�Ը߬�����g�\��', 'value'=>array('0'=>'�_','1'=>'�O'));
	$SFS_MODULE_SETUP[] =	array('var'=>'guidance_months', 'msg'=>'�Ը߬�����g��g���', 'value'=>'09,03,04,05');
$SFS_MODULE_SETUP[] =	array('var'=>'gmap_location', 'msg'=>'Google�a�ϭq�줤�߸g�n�׮y��', 'value'=>'24.345415,120.587642');
$SFS_MODULE_SETUP[] =	array('var'=>'gmap_zoom', 'msg'=>'Google�a����ܻ���j�p', 'value'=>10);
$SFS_MODULE_SETUP[] =	array('var'=>'career_previous', 'msg'=>'�ҥΥͲP���ɬ�����g�L���Ǵ���ƥ\��', 'value'=>array('0'=>'�_','1'=>'�O'));
$SFS_MODULE_SETUP[] =	array('var'=>'stud_eduh_editable', 'msg'=>'�ҥξǥͶ�g���ɬ�����\��', 'value'=>array('0'=>'�_','1'=>'�O'));
	$SFS_MODULE_SETUP[] =	array('var'=>'eduh_months', 'msg'=>'���ɬ������g���', 'value'=>'09,10,03,04');
$SFS_MODULE_SETUP[] =	array('var'=>'password_changed', 'msg'=>'���\�ǥͦۦ�ק�K�X', 'value'=>array('0'=>'�_','1'=>'�O'));	
$SFS_MODULE_SETUP[] =	array('var'=>'stage_score', 'msg'=>'���\�ǥ��˵����q���Z', 'value'=>array('0'=>'�_','1'=>'�O'));
$SFS_MODULE_SETUP[] =	array('var'=>'stage_teacher', 'msg'=>'���q���Z���µ�����Z�Юv', 'value'=>array('0'=>'�_','1'=>'�O'));



// ��2,3,4....�ӡA�̦������G 

// $SFS_MODULE_SETUP[1] =
//	array('var'=>"xxxx", 'msg'=>"yyyy", 'value'=>0);

// $SFS_MODULE_SETUP[2] =
//	array('var'=>"ssss", 'msg'=>"tttt", 'value'=>1);

?>
