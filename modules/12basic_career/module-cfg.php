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

$MODULE_TABLE_NAME[] = "career_consultation";
$MODULE_TABLE_NAME[] = "career_contact";
$MODULE_TABLE_NAME[] = "career_course";
$MODULE_TABLE_NAME[] = "career_exam";
$MODULE_TABLE_NAME[] = "career_explore";
$MODULE_TABLE_NAME[] = "career_guidance";
$MODULE_TABLE_NAME[] = "career_mystory";
$MODULE_TABLE_NAME[] = "career_opinion";
$MODULE_TABLE_NAME[] = "career_parent";
$MODULE_TABLE_NAME[] = "career_race";
$MODULE_TABLE_NAME[] = "career_self_ponder";
$MODULE_TABLE_NAME[] = "career_test";
$MODULE_TABLE_NAME[] = "career_view";

//---------------------------------------------------
//
// 2.�o�̩w�q�G�Ҳդ���W�١A�к�²�R�W (�� "�Ҳ��v���]�w" �{���ϥ�)
//
// ���|��ܵ��ϥΪ�
//-----------------------------------------------


$MODULE_PRO_KIND_NAME = "12�~��ХͲP���ɬ���";


//---------------------------------------------------
//
// 3. �o�̩w�q�G�Ҳժ���������T (�� "�۰ʧ�s�{��" ����)
//    �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//
//---------------------------------------------------

// �Ҳճ̫��s����
$MODULE_UPDATE_VER="1.0.0";

// �Ҳճ̫��s���
$MODULE_UPDATE="2013-01-07";


// �ݭn�ϥκ޲z���v��
$MODULE_MAN=true;

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
$menu_p["career_pwd.php"]="�ǥ͵n�J�K�X";
$menu_p["career_contact.php"]="�ɮv�λ��ɱЮv";
$menu_p["mystory.php"]="�ڪ������G��";
$menu_p["psy_test.php"]="�U���߲z����";
if(checkid($_SERVER['SCRIPT_FILENAME'],1)) $menu_p["psy_test_import.php"]="�߲z�����ƶפJ";
$menu_p["study_spe.php"]="�ǲߦ��G�ίS���{";
$menu_p["career_view.php"]="�ͲP�ξ㭱���[";
$menu_p["career_evaluate.php"]="�ͲP�o�i�W����";
$menu_p["career_guidance.php"]="�ͲP���ɿԸ߫�ĳ";
$menu_p["career_sign.php"]="�f�\ñ�O";
$menu_p["career_statistics.php"]="�έp���R";
$menu_p["career_report.php"]="����(���դ�)";


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

//$SFS_MODULE_SETUP[]=array('var'=>'career_ghostwrite', 'msg'=>'�ҥα�¾���n���ǥ͸�ƥ\��', 'value'=>array(''=>'�_','1'=>'�O'));

$SFS_MODULE_SETUP[]=array('var'=>'career_previous', 'msg'=>'�ҥθɵn�L���Ǵ���ƥ\��', 'value'=>array(''=>'�_','1'=>'�O'));
$SFS_MODULE_SETUP[]=array('var'=>'guidance_title', 'msg'=>'�ʦV����w�]�W��', 'value'=>'');
$SFS_MODULE_SETUP[]=array('var'=>'interest_title', 'msg'=>'�������w�]�W��', 'value'=>'');
$SFS_MODULE_SETUP[]=array('var'=>'other_title', 'msg'=>'��L����w�]�W��', 'value'=>'');
$SFS_MODULE_SETUP[]=array('var'=>'sort_rank', 'msg'=>'�έp�ƧǦW���C�ܼ�', 'value'=>10);

?>
