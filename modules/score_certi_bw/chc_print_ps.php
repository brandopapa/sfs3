<?php


/* ���o�]�w�� */
include "config.php";

sfs_check();


// smarty���˪����|�]�w  -----------------------------------
$template_dir = $SFS_PATH."/".get_store_path()."/templates";

//  �w�]���˥���  --(�R�W�Gprt�C�L_ps��p_head���Y.htm)
$tpl_defult=array("head"=>"prt_ps_head.htm","body"=>"prt_ps_body.htm","end"=>"prt_ps_end.htm");

//  �ۭq���˥��ɦW  -----------------------------------
$tpl_self=array("head"=>"my_prt_ps_head.htm","body"=>"my_prt_ps_body.htm","end"=>"my_prt_ps_end.htm");

//  �p�G�S���ۭq���˥�,�N�ιw�]��  --------------------
(file_exists($template_dir."/".$tpl_self[head])) ? $tpl=$tpl_self:$tpl=$tpl_defult;

$smarty->left_delimiter="{{";
$smarty->right_delimiter="}}";


//////  �qSFS3���ت��禡���Ǯո�ƨ禡---------------------
$sch_data=get_school_base();
/////    �qSFS3���ت��禡���o���y��ƥN�X  -------------------
$stud_coud=study_cond();

//////  �۶ǤJ���ǥͬy����,�qdata_stud���󲣥;ǥ͸��---------------------
$stud_data=new data_stud($_POST[student_sn]);


//$smarty->assign("stud_data",$stud_data);
$smarty->display($template_dir."/".$tpl[head]);

//	echo "<PRE>$_POST[student_sn]";

$sem_nums=1;//�p��i�ƥ�
$all_page=count($_POST[stu_sn]);
$pr_all_page=ceil($all_page/2);
	$smarty->assign("pr_all_page",$pr_all_page);

foreach($_POST[stu_sn] as $class_id => $null){
	$Class_DETAIL=split("_",$class_id);
    $my_seme_score=$stud_data->seme_score($class_id,$_POST[student_sn]);
    $my_test=seme_score2smarty($my_seme_score,$class_id);
	$Class_DETAIL[0]=Num2CNum($Class_DETAIL[0]+0);//��Ƭ���r,�Ǧ~��
	$Class_DETAIL[1]=Num2CNum($Class_DETAIL[1]+0);//��Ƭ���r,�Ǵ�
	//   �P�_�O�_�ꤤ  ----------
	($IS_JHORES==6) ? $Class_DETAIL[2]=$Class_DETAIL[2]-6:$Class_DETAIL[2]=$Class_DETAIL[2]+0;
	$Class_DETAIL[2]=Num2CNum($Class_DETAIL[2]);//��Ƭ���r,�~��
	$Class_DETAIL[3]=Num2CNum($Class_DETAIL[3]+0);//��Ƭ���r,�Z��

// smarty �����ܼƳB�z  -----------------------------------
	$smarty->assign("stud_coud",$stud_coud[$stud_data->study_cond]);
	$smarty->assign("school_name",$sch_data[sch_cname]);
	$smarty->assign("stud_data",$stud_data);
	$smarty->assign("Class_DETAIL",$Class_DETAIL);
	$smarty->assign("data",$my_test);
	$smarty->assign("all_page",$all_page);
	$smarty->assign("page",$sem_nums);
	$smarty->assign("pr_page",ceil($sem_nums/2));

	(($sem_nums % 2)==0 && $all_page!=$sem_nums) ? $smarty->assign("break_page","<P STYLE='page-break-before: always;'>"):$smarty->assign("break_page","");
	$smarty->display($template_dir."/".$tpl[body]);
	$sem_nums++;
//print_r($my_test);
//	unset($my_test);
}
$smarty->display($template_dir."/".$tpl[end]);
?>
