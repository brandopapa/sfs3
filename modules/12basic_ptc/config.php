<?php

//�w�]���ޤJ�ɡA���i�����C
include_once "../../include/config.php";
require_once "./module-cfg.php";
require_once "./module-upgrade.php";
include "my_fun.php";
include "../../include/sfs_case_score.php";

//�Ш|�|�Ҧa�ϥN�X
$area_code='12';

//�ǮեN�X
$school_id=$SCHOOL_BASE['sch_id'];

//���~�~��
$graduate_year=$IS_JHORES?9:6;

//���~���Ť�  0.�׷~ 1.���~
$graduate_score=array(0=>0,1=>2,2=>0);

//���@�ǯŤ�
$rank_score='0,7,5,3,2,1';
$rank_score_array=explode(',',$rank_score);

//�ꤤ�T�~�NŪ�����a�ϾǮժ̯Ť��[��
$remote_level=array(0=>'���Ű����a�ϥ[������',1=>'�ꤤ�T�~�NŪ�����a�ϾǮ�');
	
//�C���J�B���C���J��Ť��[��
$disadvantage_level=array(0=>'�L ',2=>'�C���J��',1=>'���C���J��');

//���žǲ߳�@���ή�Ť��o��
$balance_score=3;
$balance_score_max=9;
$balance_semester=array('1001','1002','1011','1012','1021');
$balance_area=array('health','art','complex');


//�A�Ȫ�{�Ť��o��
//�Z�ŷF�� & �S��A�Ȫ�{
$leader_allowed=array(1=>'�Z��',2=>'�ƯZ��',3=>'�����Ѫ�',4=>'�����Ѫ�',5=>'�åͪѪ�',6=>'�A�ȪѪ�',7=>'�`�ȪѪ�',8=>'�ưȪѪ�',9=>'�d�֪Ѫ�',10=>'��|�Ѫ�',11=>'���ɪѪ�',12=>'�S��A�Ȫ�{');
$class_leader=1;
$leader_semester=array('7-1','7-2','8-1','8-2','9-1');

//���Ϊ���
$association_leader=0.5;
$association_semester="'1001','1002','1011','1012','1021'";

$service_score_max=5;

//�L�O�L����
$fault_none=8;
$fault_warning=6;
$fault_peccadillo=4;
$fault_score_max=8;

//���y����  �̪F�����ϥ�
$reward_score[1]=0.5;
$reward_score[3]=1;
$reward_score[9]=3;
$reward_score_max=4;

//�A�ʵo�i
$my_aspiration=2;
$domicile_suggestion=2;
$guidance_suggestion=2;

//�Ш|�|��
$exam_subject=array('c'=>'���','m'=>'�ƾ�','e'=>'�^�y','s'=>'���|','n'=>'�۵M');
$exam_score_well=5;
$exam_score_ok=3;
$exam_score_no=1;
$exam_score_max=25;

//�`��
$max_score=79;

//���o�ҲհѼƪ����O�]�w
$m_arr = &get_module_setup("12basic_ptc");
extract($m_arr,EXTR_OVERWRITE);

//�������O�N�X
$stud_kind_arr=array('0'=>'�@���','1'=>'����','2'=>'���~�H���l�k','3'=>'�X�å�','4'=>'�^�깴��','5'=>'��D��','6'=>'�h��x�H','7'=>'�ҥ~�u�q��ǧ޳N�H�~�l�k');

//���߻�ê
//$stud_disability_arr=array('0'=>'�D���߻�ê�ҥ�','1'=>'�����ê','2'=>'��ı��ê','3'=>'ťı��ê','4'=>'�y����ê','5'=>'�����ê','6'=>'����f�z','7'=>'�����欰��ê','8'=>'�ǲ߻�ê','9'=>'�h����ê','A'=>'�۳��g','B'=>'��L��ê');
$stud_disability_arr=array('0'=>'�D���߻�ê�ҥ�','1'=>'�����ê','2'=>'��ı��ê','3'=>'ťı��ê','4'=>'�y����ê','5'=>'�����ê','6'=>'���ʳ·�','7'=>'����f�z','8'=>'�����欰��ê','9'=>'�ǲ߻�ê','A'=>'�h����ê','B'=>'�۳��g','C'=>'�o�i��w','D'=>'��L��ê');

//�������O�C�����~���
$stud_free_arr=array('0'=>'�@���','1'=>'�C���J��','2'=>'���C���J��','3'=>'���~�Ҥu');
$stud_free_rate=array(0=>0,1=>2,2=>1,3=>0.5);

//�v�ɦ��Z ( �f�t career_race ��ƪ� )  ( �o�n�q�i�Ǯ�  ���Ī��W���ﶵ )
$level_array=array(1=>'���',2=>'����B�O�W��',3=>'�ϰ�ʡ]�󿤥��^',4=>'�١B���ҥ�',5=>'�����ϡ]�m��^',6=>'�դ�'); 
//$squad_array=array(1=>'�ӤH��',2=>'������');
//$squad_team=array('0.5'=>'4�H','0.25'=>'20�H');
$race_score[1]=array('�Ĥ@�W'=>9,'�a�x'=>9,'���P'=>9,'�S�u'=>9,'�ĤG�W'=>8,'�ȭx'=>8,'�ȵP'=>8,'�u��'=>8,'�ĤT�W'=>7,'�u�x'=>7,'�ɵP'=>7,'�ҵ�'=>7,'�ĥ|�W'=>6,'���x'=>6,'�Χ@'=>6,'�Ĥ��W'=>5,'�Ĥ��W'=>4);
$race_score[2]=array('�Ĥ@�W'=>6,'�a�x'=>6,'���P'=>6,'�S�u'=>6,'�ĤG�W'=>5,'�ȭx'=>5,'�ȵP'=>5,'�u��'=>5,'�ĤT�W'=>4,'�u�x'=>4,'�ɵP'=>4,'�ҵ�'=>4,'�ĥ|�W'=>3,'���x'=>3,'�Χ@'=>3,'�Ĥ��W'=>2,'�J��'=>2,'�Ĥ��W'=>1);
$race_score[4]=array('�Ĥ@�W'=>3,'�a�x'=>3,'���P'=>3,'�S�u'=>3,'�ĤG�W'=>2,'�ȭx'=>2,'�ȵP'=>2,'�u��'=>2,'�ĤT�W'=>1,'�u�x'=>1,'�ɵP'=>1,'�ҵ�'=>1);
$race_score_max=9;


//��A��
$fitness_score_one=1;
$fitness_score_one_max=4;
$fitness_addon=array('gold'=>2,'silver'=>1,'copper'=>0.5);
$fitness_semester="'1001','1002','1011','1012','1021','1022'";
$fitness_score_disability=4;
$fitness_score_max=6;
$fitness_medal=array('gold'=>'��','silver'=>'��','copper'=>'��','no'=>'--');


//�ݩ���춶�ǦW�ٹ��
$kind_field_mirror=array(1=>'clan',2=>'area',3=>'memo',4=>'note');

//�]���o�T�ӼҲ��ܼƬ��᭱����  �ȾǮդw�w�˥����^  �ҥH�]�ӹw�]��
$native_id=intval($native_id)?$native_id:9;
$native_language_sort=intval($native_language_sort)?$native_language_sort:3;
$native_language_text=$native_language_text?$native_language_text:'�O';




?>
