<?php
//$Id: check.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";

//�{��
sfs_check();

if (empty($_POST[year_seme])) {
	$sel_year = curr_year(); //�ثe�Ǧ~
	$sel_seme = curr_seme(); //�ثe�Ǵ�
	$year_seme=$sel_year."_".$sel_seme;
} else {
	$ys=explode("_",$_POST[year_seme]);
	$sel_year=$ys[0];
	$sel_seme=$ys[1];
}

if ($_POST['year_name']) {
	$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
	$score_semester="score_semester_".$sel_year."_".$sel_seme;
	$query="select * from $score_semester where 1=0";
	$res=$CONN->Execute($query);
	if ($res) {
		//���Ǵ��ǥ͸��
		$all_sn="";
		$query="select * from stud_seme where seme_year_seme='$seme_year_seme' and seme_class like '".$_POST['year_name']."%'";
		$res=$CONN->Execute($query);
		while (!$res->EOF) {
			$all_sn.="'".$res->fields['student_sn']."',";
			$seme_data[$res->fields['student_sn']]['seme_class']=$res->fields['seme_class'];
			$seme_data[$res->fields['student_sn']]['seme_num']=$res->fields['seme_num'];
			$res->MoveNext();
		}
		if ($all_sn) $all_sn=substr($all_sn,0,-1);
		//���X�ťզ��Z��ƦC
		//$query="select a.*,b.stud_name from $score_semester a left join stud_base b on a.student_sn=b.student_sn where a.score='-100' and a.student_sn in ($all_sn) order by a.student_sn,a.ss_id,a.test_sort,a.test_kind";
		$query="select a.*,b.stud_name from $score_semester a left join stud_base b on a.student_sn=b.student_sn where a.score='-100' and a.student_sn in ($all_sn) and b.stud_study_cond in(0,15) order by a.student_sn,a.ss_id,a.test_sort,a.test_kind";
		$res=$CONN->Execute($query);
		$score_data=$res->GetRows();
		//����ؤ���W
		$query="select subject_id,subject_name from score_subject";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			$subject_data[$res->fields['subject_id']]=$res->fields['subject_name'];
			$res->MoveNext();
		}
		//���ҵ{�]�w���
		$query="select ss_id,scope_id,subject_id from score_ss where year='$sel_year' and semester='$sel_seme' and class_year='".$_POST['year_name']."' and enable=1 and print=1";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			$scope_id=$res->fields['scope_id'];
			$subject_id=$res->fields['subject_id'];
			$subject_id=($subject_id=='0')?$scope_id:$subject_id;
			$ss_data[$res->fields['ss_id']]=$subject_id;
			$res->MoveNext();
		}
		$smarty->assign("seme_data",$seme_data); 
		$smarty->assign("score_data",$score_data); 
		$smarty->assign("subject_data",$subject_data); 
		$smarty->assign("ss_data",$ss_data); 
	} else {
		$smarty->assign("err_msg","�ӾǴ��L�������Z��I"); 
	}
}

$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE); 
$smarty->assign("module_name","�ťզ��Z�ˬd"); 
$smarty->assign("SFS_MENU",$menu_p); 
$smarty->assign("year_seme_menu",year_seme_menu($sel_year,$sel_seme)); 
$smarty->assign("class_year_menu",class_year_menu($sel_year,$sel_seme,$_POST[year_name])); 
$smarty->display("score_manage_new_check.tpl");
?>
