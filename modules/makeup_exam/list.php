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
	$query="select student_sn from stud_seme where seme_year_seme='".$_POST['year_seme']."' and seme_class like '".$_POST['class_year']."%'";
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
}

//�ǻ�����Ѽ�
$smarty->assign("year",date("Y")-1911);
$smarty->assign("month",date("m"));
$smarty->assign("day",date("d"));

//�C�L�h�Ǵ��q����
if ($_POST['class_year']>0 && $_POST['notin']) {
	if (count($_POST['chart_seme'])>0) {
		$i = 0;
		foreach($_POST['chart_seme'] as $k=>$v) {
			$chart_seme[] = $k;
			if ($i==0) $s = "";
			elseif ($i==1) $s = " �� ";
			else $s = " �B ";
			$cstr = "<B>".$all_sm_arr[$k]."</B>".$s.$cstr;
			$i++;
		}
		if (mb_strlen($cstr,"big5")>40) $cstr = mb_substr($cstr,0,38,"big5")."<BR>�@�@".mb_substr($cstr,38,(mb_strlen($cstr,"big5")-38),"big5");
		$cs_str = "'".implode("','",$chart_seme)."'";
		$query="select * from makeup_exam_scope where student_sn in ($sn_str) and seme_year_seme in ($cs_str) order by student_sn, seme_year_seme, scope_ename";
		$res=$CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);
		$sn_arr = array();
		while($rr=$res->FetchRow()) {
			$all_arr[$rr['student_sn']][$rr['seme_year_seme']][$rr['scope_ename']]=$rr['oscore'];
			$sn_arr[]=$rr['student_sn'];
		}
		$sn_str="'".implode("','",$sn_arr)."'";
		$query="select a.student_sn,a.stud_id,a.stud_name,a.stud_sex,a.stud_study_cond,b.seme_class,b.seme_num from stud_base a left join stud_seme b on a.student_sn=b.student_sn where a.student_sn in ($sn_str) and b.seme_year_seme='".$_POST['year_seme']."' order by b.seme_class,b.seme_num";
		$res=$CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);
		$base_arr = array();
		while($rr=$res->FetchRow()) {
			$base_arr[$rr['student_sn']]=array('stud_id'=>$rr['stud_id'], 'class_year'=>substr($rr['seme_class'],0,-2), 'seme_class'=>intval(substr($rr['seme_class'],-2,2)), 'seme_num'=>$rr['seme_num'], 'stud_name'=>$rr['stud_name'], 'stud_sex'=>$rr['stud_sex'], 'stud_study_cond'=>$rr['stud_study_cond']);
		}
		$smarty->assign("data_arr",$all_arr);
		$smarty->assign("base_arr",$base_arr);
		$smarty->assign("sel_year",$sel_year);
		$smarty->assign("sel_seme",$sel_seme);
		$smarty->assign("seme_arr",$all_sm_arr);
		$smarty->assign("seme_str",$cstr);
		$smarty->assign("school_data",get_school_name());
		$smarty->display("noti.html");
		exit;
	} else
		$smarty->assign("msg","����C�L�Ǵ�");
}

//���X�ҵ{�]�w
if ($_POST['class_year']>0 && $_POST['act_year_seme']) {
	//���X��ؤ���W
	$query="select * from score_subject order by subject_id";
	$res=$CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);
	while($rr=$res->FetchRow()) {
		$subj_arr[$rr['subject_id']] = $rr['subject_name'];
	}

	//���X�ҵ{�]�w
	$query="select * from score_ss where year='$act_year' and semester='$act_seme' and class_year='".$_POST['class_year']."' and link_ss<>'' and enable='1'";
	$res=$CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);
	while($rr=$res->FetchRow()) {
		if(mb_substr($rr['link_ss'],0,2,"big5")=="�y��") $rr['link_ss'] = "�y��";
		if($rr['subject_id']==0) $rr['subject_id'] = $rr['scope_id'];
		if($rr['class_id']=="") $rr['class_id'] = "���~��";
		$sname = $subj_arr[$rr['subject_id']];
		$setup_arr[]=array($rr['class_id'], $rr['link_ss'], $sname, $rr['ss_id'], $rr['rate']);
	}
	$smarty->assign("sel_class_year",$_POST['class_year']);
	$smarty->assign("setup_arr",$setup_arr);
}

//�z��ǥ�
if ($_POST['cal'] || $_POST['export'] || $_POST['insert'] || $_POST['noti1']  || $_POST['list']) {
	$query="select a.student_sn,a.stud_id,a.seme_class,a.seme_num,b.stud_name,b.stud_sex from stud_seme a left join stud_base b on a.student_sn=b.student_sn where a.seme_year_seme='".$_POST['year_seme']."' and mid(a.seme_class,1,LENGTH(a.seme_class)-2)='".$_POST['class_year']."' and b.stud_study_cond in ('0','15') order by a.seme_class,a.seme_num";
	$res=$CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);
	while($rr=$res->FetchRow()) {
		$sn_arr[] = $rr['student_sn'];
		$base_arr[$rr['student_sn']]=array('stud_id'=>$rr['stud_id'], 'seme_class'=>$rr['seme_class'], 'seme_num'=>$rr['seme_num'], 'stud_name'=>$rr['stud_name'], 'stud_sex'=>$rr['stud_sex'], 'class_year'=>substr($rr['seme_class'],0,-2), 'class_num'=>substr($rr['seme_class'],-2,2));
	}
	$seme_arr = array($_POST['act_year_seme']);
	$all_arr = cal_fin_score($sn_arr,$seme_arr);
	$smarty->assign("data_arr",$all_arr);
	$smarty->assign("base_arr",$base_arr);
	$m_arr = array(
		'lang'=>array('e'=>'language', 'c'=>'�y��'),
		'math'=>array('e'=>'math', 'c'=>'�ƾ�'),
		'natu'=>array('e'=>'nature', 'c'=>'�۵M'),
		'soci'=>array('e'=>'social', 'c'=>'���|'),
		'heal'=>array('e'=>'health', 'c'=>'����'),
		'art'=>array('e'=>'art', 'c'=>'����'),
		'comp'=>array('e'=>'complex', 'c'=>'��X'),
	);
	if ($_POST['export'] && $m_arr[$_POST['subj']]['e']<>"") {
			$filename=$sel_year."-".$sel_seme."-".$_POST['class_year']."�~��-�ɴ�".$m_arr[$_POST['subj']]['c'].".csv";
			if(preg_match("/MSIE/i",$_SERVER['HTTP_USER_AGENT'])) {
				$filename=urlencode($filename);
			}
			header("Content-disposition: attachment; filename=$filename");
			header("Content-type: application/octetstream; Charset=Big5");
			header("Cache-Control: max-age=0");
			header("Pragma: public");
			header("Expires: 0");
			$smarty->assign("ename",$m_arr[$_POST['subj']]['e']);
			$smarty->assign("cname",$m_arr[$_POST['subj']]['c']);
			$smarty->display("list_csv.html");
			exit;
	}
	if ($_POST['insert']) {
		$i=0;
		foreach($base_arr as $sn=>$d) {
			foreach($m_arr as $dd) {
				$score=$all_arr[$sn][$dd['e']]['avg']['score'];
				if ($score<60) {
					$query="insert into makeup_exam_scope (seme_year_seme,student_sn,scope_ename,class_year,oscore) values ('".$_POST['act_year_seme']."','$sn','".$dd['e']."','".($_POST['class_year']-($sel_year-$act_year))."','$score')";
					$res=$CONN->Execute($query) or user_error("�g�J���ѡI<br>$query",256);
					$i++;
				}
			}
		}
		$smarty->assign("msg","�w���� ".$i." ����Ƽg�J");
	}
	if ($_POST['list']) {
		$smarty->assign("sel_year",$act_year);
		$smarty->assign("sel_seme",$act_seme);
		$smarty->display("count.html");
		exit;
	}
	//print_r($all_arr);
}

//�C�L��Ǵ��q����
if ($_POST['class_year']>0 && $_POST['noti1']) {
	$cstr = $all_sm_arr[$_POST['act_year_seme']];
	$smarty->assign("sel_year",$sel_year);
	$smarty->assign("sel_seme",$sel_seme);
	$smarty->assign("seme_arr",$all_sm_arr);
	$smarty->assign("seme_str",$cstr);
	$smarty->assign("school_data",get_school_name());
	$smarty->display("noti2.html");
	exit;
}

//�q�X�����������Y
$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("module_name","��Ǵ��ǲ߻����Z���ή�ǥͿz��@�~");
$smarty->assign("SFS_MENU",$school_menu_p);
$smarty->assign("year_seme_menu",$year_seme_menu);
$smarty->assign("year_seme_menu2",$year_seme_menu2);
$smarty->assign("class_year_menu",$class_year_menu);
$smarty->assign("seme_arr",$sm_arr);
$smarty->display("list.html");
?>