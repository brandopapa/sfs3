<?php
//$Id: config.php 6064 2010-08-31 12:26:33Z infodaes $
//�w�]���ޤJ�ɡA���i�����C
include_once "../../include/config.php";
require_once "./module-cfg.php";
include "my_fun.php";
include "../../include/sfs_case_score.php";
require_once "./module-upgrade.php";

//�Ш|�|�Ҧa�ϥN�X
$area_code='09';

//�ǮեN�X
$school_id=$SCHOOL_BASE['sch_id'];

//���~�~��
$graduate_year=$IS_JHORES?9:6;

//���~���Ť�  0.�׷~ 1.���~ 2.�w�~
$graduate_score=array(0=>0,1=>1,2=>0);

//���@�ǿn��
$rank_score='0,9,9,9,9,7,7,7,7,5,5,5,5,3,3,3,3';
$rank_score_array=explode(',',$rank_score);

//�ߧU�z�տn��	
//�g�ٮz��(�C���J�B���C���J��n���[��)
//$disadvantage_level=array(0=>'�L ',1=>'���C���J��',2=>'�C���J��');(����)
$disadvantage_level=array(0=>'���ŦX',1=>'�ŦX');

//�ꤤ�T�~�����a�ϾǮժ̿n���[��
$remote_level=array(0=>'���Ű����p�ե[������',2=>'7�Z�H�U',1=>'8-12�Z');
//��ۼҲ��ܼ� remote_school ����� 

//�N��J�ǿn��
$nearby_level=array(1=>'�ŦX',0=>'���ŦX');

//�~�w�A�ȿn��
//���y����
$reward_kind=array(1=>'�ż��@��',2=>'�ż��G��',3=>'�p�\\�@��',4=>'�p�\\�G��',5=>'�j�\\�@��',6=>'�j�\\�G��',7=>'�j�\\�T��',-1=>'ĵ�i�@��',-2=>'ĵ�i�G��',-3=>'�p�L�@��',-4=>'�p�L�G��',-5=>'�j�L�@��',-6=>'�j�L�G��',-7=>'�j�L�T��');		//���g���O
$reward_semester="'1031','1032','1041','1042','1051'";		//���g�������ξǴ�(����1~��3�W)
$reward_score[1]=0.5;
$reward_score[3]=1.5;
$reward_score[9]=4.5;
$reward_score_max=15;
//�L�O�L����
$fault_start_semester=1031;		//�}�l�ĭp�Ǵ�
$fault_none=5;
$fault_warning=1;
//$fault_peccadillo=0;
$fault_score_max=5;
//�X�ʮu����
$absence_score='5,3,3,3,3,3,1,1,1,1,1';
$absence_score_array=explode(',',$absence_score);
$absence_semester="'1031','1032','1041','1042','1051'";		//����1~��3�W
//$absence_semester="'1011','1012','1021'";		//����2~��3�W
$absence_score_max=5;

//�h���ǲߪ�{�n��
//���žǲ߳�@���ή�n���o��
$balance_score=3;
$balance_score_max=9;
$balance_semester=array('1031','1032','1041','1042','1051');     //����1~��3�W
$balance_area=array('health','art','complex');
/*
//���οn���o��(����)
$association_semester_count=1;
$association_semester_score_qualtified=0; //0�з���ѥ[�з���
$association_semester_score=1;
$association_score_max=2;
//�A�Ⱦǲ߿n���o��(����)
$service_semester_minutes=360;
$service_semester_score=1;
$service_score_max=3;
//�A�ʵo�i (�̪F)
$my_aspiration=2;
$domicile_suggestion=2;
$guidance_suggestion=2;
*/
//�v�ɦ��Z ( �f�t career_race ��ƪ� )  ( �o�n�q�i�Ǯ�  ���Ī��W���ﶵ )
//$level_array=array(1=>'���',2=>'����B�O�W��',3=>'�ϰ�ʡ]�󿤥��^',4=>'�١B���ҥ�',5=>'�����ϡ]�m��^',6=>'�դ�');
$level_array=array(1=>'���',2=>'����',3=>'����',4=>'����');
$squad_array=array(1=>'�ӤH��',2=>'������');
$squad_team=array('0.5'=>'4�H','0.25'=>'20�H');
$race_score[1]=array('�Ĥ@�W'=>7,'�S�u'=>7,'���P'=>7,'�a�x'=>7,'�ĤG�W'=>7,'�u��'=>7,'�ȵP'=>7,'�ȭx'=>7,'�ĤT�W'=>7,'�ҵ�'=>7,'�ɵP'=>7,'�u�x'=>7,'�ĥ|�W'=>7,'�Χ@'=>7,'�J��'=>7,'���x'=>7);
$race_score[2]=array('�Ĥ@�W'=>7,'�S�u'=>7,'���P'=>7,'�a�x'=>7,'�ĤG�W'=>6,'�u��'=>6,'�ȵP'=>6,'�ȭx'=>6,'�ĤT�W'=>5,'�ҵ�'=>5,'�ɵP'=>5,'�u�x'=>5,'�ĥ|�W'=>4,'�Χ@'=>4,'�J��'=>4,'���x'=>4,'�Ĥ��W'=>4,'�Ĥ��W'=>4);
$race_score[3]=array('�Ĥ@�W'=>3,'�S�u'=>3,'���P'=>3,'�a�x'=>3,'�ĤG�W'=>2,'�u��'=>2,'�ȵP'=>2,'�ȭx'=>2,'�ĤT�W'=>1,'�ҵ�'=>1,'�ɵP'=>1,'�u�x'=>1,'�ĥ|�W'=>0.5,'�Χ@'=>0.5,'�J��'=>0.5,'���x'=>0.5,'�Ĥ��W'=>0.5,'�Ĥ��W'=>0.5);
$race_score[4]=array('�Ĥ@�W'=>3,'�S�u'=>3,'���P'=>3,'�a�x'=>3,'�ĤG�W'=>2,'�u��'=>2,'�ȵP'=>2,'�ȭx'=>2,'�ĤT�W'=>1,'�ҵ�'=>1,'�ɵP'=>1,'�u�x'=>1,'�ĥ|�W'=>0.5,'�Χ@'=>0.5,'�J��'=>0.5,'���x'=>0.5,'�Ĥ��W'=>0.5,'�Ĥ��W'=>0.5);
$race_score_max=9;

//��A��
$fitness_score_one=3;
$fitness_score_one_max=6;
$fitness_addon=array('gold'=>0,'silver'=>0,'copper'=>0);
$fitness_semester="'1031','1032','1041','1042','1051'";		//����1~��3�W
$fitness_score_max=6;
$fitness_medal=array('gold'=>'��','silver'=>'��','copper'=>'��','no'=>'--');

//���y+�v��+��A����ƤW��
$reward_competetion_fitness_score_max=25;

//�Ш|�|�ҿn��
$exam_subject=array('c'=>'���','m'=>'�ƾ�','e'=>'�^�y','s'=>'���|','n'=>'�۵M');
$exam_score_well=6;
$exam_score_ok=4;
$exam_score_no=2;
$exam_score_max=30;

//�`��
$max_score=90;
$editable_hint=" <font size=1 color='brown'>���X�{��������ЮɡA�i�֫���U�i�i��ק</font>";


//���o�ҲհѼƪ����O�]�w
$m_arr = &get_module_setup("12basic_ylc");
extract($m_arr,EXTR_OVERWRITE);

//�������O�N�X��ӻP�v��
$stud_kind_arr_12ylc=array('0'=>'�@���','1'=>'����','2'=>'���~�H���l�k','3'=>'�X�å�','4'=>'�^�깴��','5'=>'��D��','6'=>'�h��x�H','7'=>'�ҥ~�u�q��ǧ޳N�H�~�l�k');
//$stud_kind_rate=array('0'=>'0','1'=>'10','2'=>'20','3'=>'30','4'=>'40','5'=>'50','6'=>'60','7'=>'70','8'=>'80');
$stud_kind_rate=explode(',',$kind_evaluate);

/*
echo '<pre>';
print_r($stud_kind_rate);
echo '</pre>';
*/

//�ݩ���춶�ǦW�ٹ��
$kind_field_mirror=array(1=>'clan',2=>'area',3=>'memo',4=>'note');

//�]���o�T�ӼҲ��ܼƬ��᭱����  �ȾǮդw�w�˥����^  �ҥH�]�ӹw�]��
$native_id=intval($native_id)?$native_id:9;
$native_language_sort=intval($native_language_sort)?$native_language_sort:3;
$native_language_text=$native_language_text?$native_language_text:'�O';

//���߻�ê
$stud_disability_arr_12ylc=array('0'=>'�D���߻�ê�ҥ�','1'=>'�����ê','2'=>'��ı��ê','3'=>'ťı��ê','4'=>'�y����ê','5'=>'�����ê','6'=>'���ʳ·�','7'=>'����f�z','8'=>'�����欰��ê','9'=>'�ǲ߻�ê','A'=>'�h����ê','B'=>'�۳��g','C'=>'�o�i��w','D'=>'��L��ê');

//�������O�C�����~���
$stud_free_arr_12ylc=array('0'=>'�@���','1'=>'�C���J��','2'=>'���C���J��','3'=>'���~�Ҥu�l�k');
$stud_free_rate=array(0=>0,1=>2,2=>1,3=>0.5);


//�O�_��ܤj�Y��
//$pic_checked=$_POST[pic_checked];


?>
