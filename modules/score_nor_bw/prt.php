<?php
//$Id: prt.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";

//�{��
sfs_check();
//�z�i�H�ۤv�[�J�ޤJ��
require_once("chc_class2.php");

//�{�����Y
head("���`���Z�޲z");
print_menu($menu_p);

// smarty���˪����|�]�w  -----------------------------------
//$template_dir = $SFS_PATH."/".get_store_path()."/templates";

//  �w�]���˥���  --(�R�W�Gprt�C�L_ps��p_head���Y.htm)
//$tpl_defult=$template_dir."/chc_prn_week.html";

$smarty->left_delimiter="{{";
$smarty->right_delimiter="}}";

$year_seme_ary=year_seme_ary();
$grade_ary=array("7"=>"�@�~��","8"=>"�G�~��","9"=>"�T�~��");
if ($IS_JHORES < 6) $grade_ary=array("1"=>"�@�~��","2"=>"�G�~��","3"=>"�T�~��","4"=>"�|�~��","5"=>"���~��","6"=>"���~��");

$sort_ary=array('1'=>'�Ĥ@��','2'=>'�ĤG��','3'=>'�ĤT��');


$year_seme = $_POST[year_seme];
$grade = $_POST[grade];
$class_id = $_POST[class_id];
$test_sort=$_POST[test_sort];
if (empty($test_sort)) $test_sort=1;
if (empty($year_seme)) $year_seme = sprintf("%03d%d",curr_year(),curr_seme());
if (empty($grade)) $grade = $IS_JHORES+1;
if (!empty($year_seme)) {
	$year=substr($year_seme,0,3);
	$seme=substr($year_seme,-1);
}
if (empty($class_id)) $class_id=sprintf("%03d_%d_%02d_%02d",$year,$seme,$grade,1);

$class_ary = sch_class_name($year,$seme,$grade);
if (!empty($class_id) and empty($class_ary[$class_id])) $class_id=sprintf("%03d_%d_%02d_%02d",$year,$seme,$grade,1);



//�D�n���e
$class_id = sprintf("%03d_%d_%02d_01",$year,$seme,$grade);
$sub_ary = get_subj($class_id,'stage');
$prn_ary=array('prn_stud_seme_score.php'=>'�Ǵ����Z�q����'
	,'prn_class_seme_score.php'=>'�Ǵ����Z�Z���`��'
	,'prn_class_seme_score_nor.php'=>'���`���Z�Z���`��'
	,'test.php'=>'test');

//-- 94/01/14 �ץ� 
//---- �N $class_ary �ƶq�ɨ��� 10 ������ �Ϫ������
while (count($class_ary) % 10 != 0) $class_ary[count($class_ary)]='';
//--- 94/01/14 �ץ� ���� -------------------------------------------
$smarty->assign('year_seme_ary',$year_seme_ary);
$smarty->assign('year_seme',$year_seme);
$smarty->assign('grade_ary',$grade_ary);
$smarty->assign('grade',$grade);
$smarty->assign('class_ary',$class_ary);
$smarty->assign('class_id',$class_id);
$smarty->assign('prn_ary',$prn_ary);
$smarty->display("sel_class.tpl");
//unset($class_data);

//print "<pre>";
//print_r(score_add($class_id,$test_sort));
//print_r($sub_ary);
/*
print_r($year_seme_ary);
print_r($class_ary);
print "<br> $year--$seme--$grade--$year_seme ";
print_r($_POST);
*/
//print "</pre>";

//�G������
foot();


?>
