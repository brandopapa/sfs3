<?php
//$Id:$
include "config.php";

//�{��
sfs_check();

//�P�_�Ǵ�
if ($_POST['year_seme']=="") $_POST['year_seme']=sprintf("%03d",curr_year()).curr_seme();
$sel_year=intval(substr($_POST['year_seme'],0,-1));
$sel_seme=intval(substr($_POST['year_seme'],-1,1));
$all_sm_arr = get_class_seme();
$year_seme_menu=year_seme_menu($sel_year,$sel_seme,"year_seme",$all_sm_arr);
$_POST['class_year'] = intval($_POST['class_year']);
$class_year_menu=class_year_menu($_POST['class_year']);

if ($_POST['class_year']>0) {
	$query="select student_sn from stud_seme where seme_year_seme='".$_POST['year_seme']."' and seme_class like '".$_POST['class_year']."%' limit 0,10";
	$res=$CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);
	$sn_arr = array();
	while($rr=$res->FetchRow()) {
		$sn_arr[] = $rr['student_sn'];
	}
	$sn_str = "'".implode("','", $sn_arr)."'";
	$query="select distinct seme_year_seme from stud_seme where student_sn in ($sn_str) order by seme_year_seme desc";
	$res=$CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);
	$sm_arr = array();
	while($rr=$res->FetchRow()) {
		if ($all_sm_arr[$rr['seme_year_seme']]) {
			$sm_arr[$rr['seme_year_seme']] = $all_sm_arr[$rr['seme_year_seme']];
		}
	}
	if ($_POST['act_year_seme']) {
		$act_year=intval(substr($_POST['act_year_seme'],0,-1));
		$act_seme=intval(substr($_POST['act_year_seme'],-1,1));
		$_POST['act_year_seme']=sprintf("%03d",$act_year).$act_seme;
		if ($_POST['act_year_seme']>$_POST['year_seme']) $_POST['act_year_seme']="";
	}
	$year_seme_menu2=year_seme_menu($act_year,$act_seme,"act_year_seme",$sm_arr);
	$smarty->assign("sel_class_year",$_POST['class_year']);
}

//�}�C���
$m_arr = array(
	'lang'=>array('e'=>'language', 'c'=>'�y��'),
	'math'=>array('e'=>'math', 'c'=>'�ƾ�'),
	'natu'=>array('e'=>'nature', 'c'=>'�۵M'),
	'soci'=>array('e'=>'social', 'c'=>'���|'),
	'heal'=>array('e'=>'health', 'c'=>'����'),
	'art'=>array('e'=>'art', 'c'=>'����'),
	'comp'=>array('e'=>'complex', 'c'=>'��X'),
);
if ($m_arr[$_POST['subj']]['e']=="") $_POST['subj']="";

//��s���Z
if ($_POST['edit']) {
	$i=0;
	$now=date("Y-m-d H:i:s");
	foreach($_POST['nscore'] as $sn=>$d) {
		if($d<>$_POST['old_nscore'][$sn] && floatval($d)>=0 && floatval($d)<=100) {
			if ($d=="")
				$query="update makeup_exam_scope set nscore='', has_score='0', update_time='$now', teacher_sn='".$_SESSION['session_tea_sn']."' where seme_year_seme='".$_POST['act_year_seme']."' and student_sn='$sn' and scope_ename='".$m_arr[$_POST['subj']]['e']."'";
			else
				$query="update makeup_exam_scope set nscore='$d', has_score='1', update_time='$now', teacher_sn='".$_SESSION['session_tea_sn']."' where seme_year_seme='".$_POST['act_year_seme']."' and student_sn='$sn' and scope_ename='".$m_arr[$_POST['subj']]['e']."'";
			$res=$CONN->Execute($query) or user_error("��s���ѡI<br>$query",256);
			$chg_arr[$sn]=1;
			$i++;
		}
	}
	$smarty->assign("chg_arr",$chg_arr);
	$smarty->assign("msg","�z�w���\�ק� ".$i." �����Z");
}

//���u�p��
if ($_POST['act']) {
	cal_better_score($_POST['act_year_seme'], ($_POST['class_year']-($sel_year-$act_year)), $m_arr[$_POST['subj']]['e']);
}

//���X�W�U
if ($_POST['class_year']>0 && $_POST['act_year_seme'] && $_POST['subj']) {
	$query="select * from makeup_exam_scope where seme_year_seme='".$_POST['act_year_seme']."' and scope_ename='".$m_arr[$_POST['subj']]['e']."' and class_year='".($_POST['class_year']-($sel_year-$act_year))."'";
	$res=$CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);
	$sn_arr = array();
	while($rr=$res->FetchRow()) {
		$all_arr[$rr['student_sn']]['oscore']=$rr['oscore'];
		$all_arr[$rr['student_sn']]['nscore']=$rr['nscore'];
		$all_arr[$rr['student_sn']]['has_score']=$rr['has_score'];
		$sn_arr[]=$rr['student_sn'];
	}
	$sn_str="'".implode("','",$sn_arr)."'";
	$query="select a.student_sn,a.stud_id,a.stud_name,a.stud_sex,a.stud_study_cond,b.seme_class,b.seme_num from stud_base a left join stud_seme b on a.student_sn=b.student_sn where a.student_sn in ($sn_str) and b.seme_year_seme='".$_POST['year_seme']."' order by b.seme_class,b.seme_num";
	$res=$CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);
	while($rr=$res->FetchRow()) {
		$base_arr[$rr['student_sn']]=array('stud_id'=>$rr['stud_id'], 'seme_class'=>$rr['seme_class'], 'seme_num'=>$rr['seme_num'], 'stud_name'=>$rr['stud_name'], 'stud_sex'=>$rr['stud_sex'], 'stud_study_cond'=>$rr['stud_study_cond']);
	}
	$smarty->assign("data_arr",$all_arr);
	$smarty->assign("base_arr",$base_arr);
}

//�q�X�����������Y
$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("module_name","�ɦ���q���Z�@�~");
$smarty->assign("SFS_MENU",$school_menu_p);
$smarty->assign("year_seme_menu",$year_seme_menu);
$smarty->assign("year_seme_menu2",$year_seme_menu2);
$smarty->assign("class_year_menu",$class_year_menu);
$smarty->display("score.html");
?>
