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

//���}�C���
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

if ($_POST['class_year']>0) {
	//�g�J�Ǵ����Z
	if (count($_POST['write'])>0) {
		write_makeup($_POST['act_year_seme'], $m_arr[$_POST['subj']]['e'], $_POST['write'], "write");
	}

	//�٭�Ǵ����Z
	if (count($_POST['undo'])>0) {
		write_makeup($_POST['act_year_seme'], $m_arr[$_POST['subj']]['e'], $_POST['undo'], "undo");
	}

	//�����g�J���٭�
	if ($_POST['writeAll'] || $_POST['undoAll']) {
		if ($_POST['writeAll']) $wact = "write";
		else $wact = "undo";
		$query="select * from makeup_exam_score where seme_year_seme='".$_POST['act_year_seme']."' and class_year='".($_POST['class_year']-($sel_year-$act_year))."'";
		if ($_POST['subj']) $query .= " and scope_ename='".$m_arr[$_POST['subj']]['e']."'";
		$query .= " order by scope_ename, student_sn";
		$res=$CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);
		$temp_sn = array();
		$old_scope_ename = "";
		while($rr=$res->FetchRow()) {
			if ($rr['scope_ename']<>$old_scope_ename && $old_scope_ename<>"") {
				write_makeup($_POST['act_year_seme'], $old_scope_ename, $temp_sn, $wact);
				$temp_sn = array();
			}
			$temp_sn[$rr['student_sn']] = $rr['student_sn'];
			$old_scope_ename = $rr['scope_ename'];
		}
		if ($old_scope_ename<>"" && count($temp_sn)>0) write_makeup($_POST['act_year_seme'], $old_scope_ename, $temp_sn, $wact);
	}
	
	//���ɵ����
	$query="select * from makeup_exam_scope where seme_year_seme='".$_POST['act_year_seme']."' and class_year='".($_POST['class_year']-($sel_year-$act_year))."'";
	if ($_POST['subj']) $query .= " and scope_ename='".$m_arr[$_POST['subj']]['e']."'";
	$query .= " order by student_sn, scope_ename";
	$res=$CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);
	$scope_arr = array();
	while($rr=$res->FetchRow()) {
		//�p�G����u��ܾ��u, �N�u��ܸɵ����ư������ƪ�
		if ($_POST['simple']<>1 || $rr['nscore']>$rr['oscore']) {
			$scope_arr[$rr['student_sn']][$rr['scope_ename']] = array('oscore'=>$rr['oscore'], 'nscore'=>$rr['nscore'], 'chg'=>'0');
		}
	}
	//���ɵ�����
	$query="select a.*,b.ss_score from makeup_exam_score a left join stud_seme_score b on a.seme_year_seme=b.seme_year_seme and a.student_sn=b.student_sn and a.ss_id=b.ss_id where a.seme_year_seme='".$_POST['act_year_seme']."' and a.class_year='".($_POST['class_year']-($sel_year-$act_year))."'";
	if ($_POST['subj']) $query .= " and a.scope_ename='".$m_arr[$_POST['subj']]['e']."'";
	$query .= " order by a.student_sn, a.scope_ename, a.ss_id";
	$res=$CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);
	$score_arr = array();
	$all_sn = array();
	$all_ss_id = array();
	$col_arr = array();
	while($rr=$res->FetchRow()) {
		//�p�G����u��ܾ��u, �N�u��ܸɵ����ư������ƪ�
		if ($_POST['simple']<>1 || count($scope_arr[$rr['student_sn']])>0) {
			$score_arr[$rr['student_sn']][$rr['scope_ename']][$rr['ss_id']] = array('oscore'=>$rr['oscore'], 'nscore'=>$rr['nscore'], 'rscore'=>$rr['ss_score'], 'rate'=>$rr['rate']);
			if ($rr['chg']==1) $scope_arr[$rr['student_sn']][$rr['scope_ename']]['chg'] = 1;
			$all_sn[$rr['student_sn']] = $rr['student_sn'];
			$all_ss_id[$rr['ss_id']] = $rr['ss_id'];
			$col_arr[$rr['student_sn']]++;
		}
	}
	//����إN�X
	$ss_str = "'".implode("','",$all_ss_id)."'";
	$query="select * from score_ss where ss_id in ($ss_str)";
	$res=$CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);
	while($rr=$res->FetchRow()) {
		$all_ss_id[$rr['ss_id']] = ($rr['subject_id']==0)?$rr['scope_id']:$rr['subject_id'];
	}
	//����ؤ���W
	$ss_str = "'".implode("','",$all_ss_id)."'";
	$query="select * from score_subject where subject_id in ($ss_str)";
	$res=$CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);
	$temp_arr = array();
	while($rr=$res->FetchRow()) {
		$temp_arr[$rr['subject_id']] = $rr['subject_name'];
	}
	foreach($all_ss_id as $ss_id=>$subject_id) {
		$all_ss_id[$ss_id] = $temp_arr[$subject_id];
	}
	//���s�Z���
	$sn_str="'".implode("','",$all_sn)."'";
	$query="select * from stud_seme where student_sn in ($sn_str) and seme_year_seme='".$_POST['year_seme']."' order by seme_class,seme_num";
	$res=$CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);
	$seme_arr = array();
	while($rr=$res->FetchRow()) {
		$seme_arr[$rr['student_sn']] = array('seme_class'=>$rr['seme_class'], 'seme_num'=>$rr['seme_num']);
		$all_sn[$rr['student_sn']] = 0; //�N$all_sn�}�C��ΨӧP�_��Ǵ��S���s�Z��ƪ���ǥ�
	}
	//����Ǵ����s��Z�����
	$spe_arr = array();
	foreach($all_sn as $student_sn=>$v) if ($v<>0) $spe_arr[$student_sn]=$student_sn;
	//���򥻸��
	$query="select * from stud_base where student_sn in ($sn_str)";
	$res=$CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);
	$base_arr = array();
	while($rr=$res->FetchRow()) {
		$base_arr[$rr['student_sn']] = array('stud_id'=>$rr['stud_id'], 'stud_name'=>$rr['stud_name'], 'stud_sex'=>$rr['stud_sex'], 'stud_study_cond'=>$rr['stud_study_cond']);
	}
	$smarty->assign("col_arr",$col_arr);
	$smarty->assign("score_arr",$score_arr);
	$smarty->assign("scope_arr",$scope_arr);
	$smarty->assign("ss_arr",$all_ss_id);
	$smarty->assign("seme_arr",$seme_arr);
	$smarty->assign("spe_arr",$spe_arr);
	$smarty->assign("base_arr",$base_arr);
	$smarty->assign("cscope_arr",get_scope_ename());
}



//��s���Z
if ($_POST['edit']) {
	$i=0;
	$now=date("Y-m-d H:i:s");
	foreach($_POST['nscore'] as $sn=>$d) {
		if($d<>$_POST['old_nscore'][$sn] && floatval($d)>=0 && floatval($d)<=100 && $d<>"") {
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

//���X�ҵ{�]�w
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
$smarty->assign("module_name","�ɦ���q���Z���u�O��");
$smarty->assign("SFS_MENU",$school_menu_p);
$smarty->assign("year_seme_menu",$year_seme_menu);
$smarty->assign("year_seme_menu2",$year_seme_menu2);
$smarty->assign("class_year_menu",$class_year_menu);
$smarty->display("record.html");
?>