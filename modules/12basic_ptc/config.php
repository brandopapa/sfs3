<?php

//�w�]���ޤJ�ɡA���i�����C
include_once "../../include/config.php";
require_once "./module-cfg.php";
require_once "./module-upgrade.php";
include_once "my_fun.php";
include_once "../../include/sfs_case_score.php";
include_once "../../include/sfs_case_dataarray.php";

//�Ш|�|�Ҧa�ϥN�X
$area_code='12';

//�ǮեN�X
$school_id=$SCHOOL_BASE['sch_id'];

//���~�~��
$graduate_year=$IS_JHORES?9:6;

//���~���n��  0.�׷~ 1.���~
$graduate_score=array(0=>0,1=>2,2=>0);  //2014-11-23�չ�  ���ק�

//���@�ǿn��
$rank_score='0,7,7,7,5,5,5,3,3,3,2,2,2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1';   //2014-11-23�չ�ק�
$rank_score_array=explode(',',$rank_score);


//���žǲ߳�@���ή�n���o��
$balance_score=3;
$balance_score_max=9;
$balance_semester=array('1011','1012','1021','1022','1031');   //2014-11-23�չ�ק�
$balance_area=array('health','art','complex');


//�A�Ȫ�{�n���o��
//�Z�ŷF�� & �S��A�Ȫ�{
$leader_allowed=array(1=>'�Z��',2=>'�ƯZ��',3=>'�����Ѫ�',4=>'�����Ѫ�',5=>'�åͪѪ�',6=>'�A�ȪѪ�',7=>'�`�ȪѪ�',8=>'�ưȪѪ�',9=>'�d�֪Ѫ�',10=>'��|�Ѫ�',11=>'���ɪѪ�',12=>'�S��A�Ȫ�{');
$class_leader=3;    //2014-11-23�չ�ק�
$leader_semester=array('7-1','7-2','8-1','8-2','9-1');

//���Ϊ���
$association_leader=2;    //2014-11-23�չ�ק�
$association_semester="'1011','1012','1021','1022','1031'";

$service_score_max=10;  //2014-11-23�չ�ק�

$diversification_score_max=28;  //2014-12-10 �s�W

//�L�O�L����
$fault_none=10;    //2014-11-23�չ�ק�
$fault_warning=7;    //2014-11-23�չ�ק�
$fault_peccadillo=4;
$fault_score_max=10;    //2014-11-23�չ�ק�
$reward_date_limit='2015-04-30';    //2014-11-23�չ�s�W

//���y����  �̪F�����ϥ�       //2014-11-23�չ良�ק�
/*
$reward_score[1]=0.5;
$reward_score[3]=1;
$reward_score[9]=3;
$reward_score_max=4;
*/




//��A��
/*
$fitness_score_one=1;
$fitness_score_one_max=4;
$fitness_addon=array('gold'=>2,'silver'=>1,'copper'=>0.5);
$fitness_semester="'1001','1002','1011','1012','1021','1022'";
$fitness_score_disability=4;
$fitness_score_max=6;
$fitness_medal=array('gold'=>'��','silver'=>'��','copper'=>'��','no'=>'--');
*/
$fitness_score_test_all=2;  //2014-11-23�չ�s�W
$fitness_score_one=2;
//$fitness_semester="'1011','1012','1021','1022','1031','1032'";  �אּ�Τ���P�w
$fitness_score_disability=8;
$fitness_score_max=10;
//$fitness_date_limit='2015-04-30';    //2014-11-23�չ�s�W
$fitness_date_limit='104-04';    //2015-5-5 �ץ�

//�A�ʵo�i
$my_aspiration=2;
$domicile_suggestion=2;
$guidance_suggestion=2;


//�C���J�B���C���J��n���[��
$disadvantage_level=array(0=>'�L ',2=>'�C���J��',1=>'���C���J��');

//�g�ٮz�ճ̰���
$disadvantage_score_max=2;

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
$race_score[1]=array('�Ĥ@�W'=>10,'�a�x'=>10,'���P'=>10,'�S�u'=>10,'�ժ���'=>10,'�ĤG�W'=>9,'�ȭx'=>9,'�ȵP'=>9,'�u��'=>9,'����'=>9,'�ĤT�W'=>8,'�u�x'=>8,'�ɵP'=>8,'�ҵ�'=>8,'�ȼ�'=>8,'�ĥ|�W'=>7,'���x'=>7,'�Χ@'=>7,'�Ĥ��W'=>6,'�Ĥ��W'=>5,'�ĤC�W'=>4,'�ĤK�W'=>3);
$race_score[2]=array('�Ĥ@�W'=>8,'�a�x'=>8,'���P'=>8,'�S�u'=>8,'����'=>8,'�ĤG�W'=>7,'�ȭx'=>7,'�ȵP'=>7,'�u��'=>7,'�ȼ�'=>7,'�ĤT�W'=>6,'�u�x'=>6,'�ɵP'=>6,'�ҵ�'=>6,'�ɼ�'=>6,'�ĥ|�W'=>5,'���x'=>5,'�Χ@'=>5,'�Ĥ��W'=>4,'�J��'=>4,'�Ĥ��W'=>3,'�ĤC�W'=>2,'�ĤK�W'=>1,'�S�O��'=>5,'�̨ζm�g�Ч���'=>5,'�̨ιζ��X�@��'=>5,'�̨γзN��'=>5);
$race_score[4]=array('�Ĥ@�W'=>5,'�a�x'=>5,'���P'=>5,'�S�u'=>5,'�ĤG�W'=>4,'�ȭx'=>4,'�ȵP'=>4,'�u��'=>4,'�ĤT�W'=>3,'�u�x'=>3,'�ɵP'=>3,'�ҵ�'=>3,'�ĥ|�W'=>2,'���x'=>2,'�Ĥ��W'=>1,'�Ĥ��W'=>0.5,'�Χ@'=>0.5,'�S�O��'=>0.5,'�̨ζm�g�Ч���'=>0.5,'�̨ιζ��X�@��'=>0.5,'�̨γзN��'=>0.5);  //,'�J��'=>1
$race_score_max=10;


//�ݩ���춶�ǦW�ٹ��
$kind_field_mirror=array(1=>'clan',2=>'area',3=>'memo',4=>'note');

//�]���o�T�ӼҲ��ܼƬ��᭱����  �ȾǮդw�w�˥����^  �ҥH�]�ӹw�]��
$native_id=intval($native_id)?$native_id:9;
$native_language_sort=intval($native_language_sort)?$native_language_sort:3;
$native_language_text=$native_language_text?$native_language_text:'�O';




?>
