<?php
//$Id: config.php 6064 2010-08-31 12:26:33Z infodaes $
//�w�]���ޤJ�ɡA���i�����C
include_once "../../include/config.php";
require_once "./module-cfg.php";
require_once "./module-upgrade.php";
include "my_fun.php";
include "../../include/sfs_case_score.php";

//�Ш|�|�Ҧa�ϥN�X
$area_code='07';

//�ǮեN�X
$school_id=$SCHOOL_BASE['sch_id'];

//���~�~��
$graduate_year=$IS_JHORES?9:6;

//���~���Ť�  0.�׷~ 1.���~
$graduate_score=array(0=>0,1=>2,2=>0);

//���@�ǯŤ�
$rank_score='0,30,29,28,27,26,25,24,23,22,21,20,19,18,17,16,15,14,13,12,11,10,9,8,7,6,5,4,3,2,1';
$rank_score_array=explode(',',$rank_score);

//�ꤤ�T�~�NŪ�����a�ϾǮժ̯Ť��[��
$remote_level=array(0=>'���Ű����a�ϥ[������',1=>'�ꤤ�T�~�NŪ�����a�ϾǮ�');
	
//�C���J�B���C���J��Ť��[��
$disadvantage_level=array(0=>'�L ',1=>'���C���J��',2=>'�C���J��');

//���žǲ߳�@���ή�Ť��o��
$balance_score=4;
$balance_score_max=12;
//$balance_semester=array('1011','1012');  //�ձ��t��
$balance_semester=array('1011','1012','1021');  //��ڳ��W

$balance_area=array('health','art','complex');

//���ίŤ��o��
$association_semester_count=1;
$association_semester_score_qualtified=0; //0�N���ѥ[�N�ή�
$association_semester_score=1;
$association_score_max=2;

//�A�Ⱦǲ߯Ť��o��
$service_semester_minutes=360;
$service_semester_score=1;
$service_score_max=3;

//�L�O�L����
$fault_semester=array('1011','1012','1021');
$fault_none=6;
$fault_warning=3;
$fault_peccadillo=3;

//���y����
$reward_semester=array('1001','1002','1011','1012','1021');
$reward_score[1]=0.5;
$reward_score[3]=1;
$reward_score[9]=3;
$reward_score_max=4;

//�Ш|�|��
$exam_subject=array('w'=>'�g�@����','c'=>'���','m'=>'�ƾ�','e'=>'�^�y','s'=>'���|','n'=>'�۵M');
$exam_score_well=6;
$exam_score_ok=4;
$exam_score_no=2;
$exam_score_max=30;

$score_write_max=6;

//�`��
$max_score=100;

//���o�ҲհѼƪ����O�]�w
$m_arr = &get_module_setup("12basic_tcntc");
extract($m_arr,EXTR_OVERWRITE);

//�������O�N�X��ӻP�v��
//$stud_kind_arr=array('0'=>'�@���','1'=>'����','2'=>'����(�y���{��)','3'=>'���߻�ê','4'=>'��L','5'=>'�ҥ~�u�q��ޤH�~�l�k','6'=>'�F�����u��~�u�@�H���l�k','7'=>'����','8'=>'�X�å�');  //�줤���
$stud_kind_arr=array('0'=>'�@���','1'=>'����','2'=>'���~�H���l�k','3'=>'�X�å�','4'=>'�^�깴��','5'=>'��D��','6'=>'�h��x�H','7'=>'�ҥ~�u�q��ǧ޳N�H�~�l�k','8'=>'�����ϥ�');

//���߻�ê
//$stud_disability_arr=array('0'=>'�D���߻�ê�ҥ�','1'=>'�����ê','2'=>'��ı��ê','3'=>'ťı��ê','4'=>'�y����ê','5'=>'�����ê','6'=>'����f�z','7'=>'�����欰��ê','8'=>'�ǲ߻�ê','9'=>'�h����ê','A'=>'�۳��g','B'=>'��L��ê');
$stud_disability_arr=array('0'=>'�D���߻�ê�ҥ�','1'=>'�����ê','2'=>'��ı��ê','3'=>'ťı��ê','4'=>'�y����ê','5'=>'�����ê','6'=>'���ʳ·�','7'=>'����f�z','8'=>'�����欰��ê','9'=>'�ǲ߻�ê','A'=>'�h����ê','B'=>'�۳��g','C'=>'�o�i��w','D'=>'��L��ê');

//�������O�C�����~���
$stud_free_arr=array('0'=>'�@���','1'=>'�C���J��','2'=>'���C���J��','3'=>'���~�Ҥu');
$stud_free_rate=array(0=>0,1=>2,2=>1,3=>0);

//$stud_kind_rate=array('0'=>'0','1'=>'10','2'=>'20','3'=>'30','4'=>'40','5'=>'50','6'=>'60','7'=>'70','8'=>'80');
$stud_kind_rate=explode(',',$kind_evaluate);

//�ݩ���춶�ǦW�ٹ��
$kind_field_mirror=array(1=>'clan',2=>'area',3=>'memo',4=>'note');

?>
