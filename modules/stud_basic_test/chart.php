<?php

// $Id: chart.php 6390 2011-03-13 17:04:30Z brucelyc $

// --�t�γ]�w��
include "select_data_config.php";
include "../../include/sfs_case_score.php";

//�{��
sfs_check();

if (empty($_POST[year_seme])) {
	$sel_year = curr_year(); //�ثe�Ǧ~
	$sel_seme = curr_seme(); //�ثe�Ǵ�
	$year_seme=$sel_year."_".$sel_seme;
	$_POST[year_seme]=$year_seme;
} else {
	$ys=explode("_",$_POST[year_seme]);
	$sel_year=$ys[0];
	$sel_seme=$ys[1];
}
$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
$_POST['year_name']=intval($_POST['year_name']);
if ($_POST['year_name']<1 || $_POST['year_name']>9) $_POST['year_name']=9;

//���X�J�Ǧ~
$stud_study_year=get_stud_study_year($seme_year_seme,$_POST['year_name']);

//���X�ˬd�ξǴ����
for ($i=1;$i<=2;$i++) {
	for ($j=1;$j<=2;$j++) {
		$semes[]=($stud_study_year+$i).$j;
	}
}
array_pop($semes);

//�Ѱ��ʦs���A
if (count($_POST['del'])>0) {
	if ($_POST['del'][2]) {
		$CONN->Execute("delete from dis_score_fin where year='$sel_year'");
	}
	if ($_POST['del'][3]) {
		$CONN->Execute("delete from dis_stage_fin");
	}
}

//�ˬd�ʦs���A
$smarty->assign("chk_arr",chk_dis($sel_year,$semes));

//�̰ϰ�]�w�ĭp�Ǵ�
if ($_POST['cy']==2 || $_POST['cy']==3 || $_POST['cy']==4 || $_POST['cy']==5) {
	$starty=0;
	$y_arr=array(1=>"�@�W",2=>"�@�U",3=>"�G�W",4=>"�G�U",5=>"�T�W");
} else {
	$starty=1;
	$y_arr=array(1=>"�G�W",2=>"�G�U",3=>"�T�W");
}

//�Ϥ��ӽлP�˰e
if ($_POST['send']) {
	$s_arr=array(1=>"��",2=>"�^",3=>"��",4=>"��",5=>"��");
	$ss_map=array("chinese"=>1,"english"=>2,"math"=>3,"nature"=>4,"social"=>5,"avg"=>6);
} else 
	$s_arr=array(1=>"��",2=>"�^",3=>"�y",4=>"��",5=>"��",6=>"��",7=>"��",8=>"��",9=>"��",10=>"�`");

$num_arr=array();
//���~�Ť@��ͦ��Z�ҩ�
if ($_POST['n_all']) {
	$query="select * from stud_seme_dis where seme_year_seme='$seme_year_seme' and seme_class like '".$_POST['year_name']."%' order by seme_class,seme_num";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		$num_arr[]=substr($res->fields['seme_class'],-2,2).sprintf("%02d",$res->fields['seme_num']);
		$res->MoveNext();
	}
	if (count($num_arr)>0) {
		$_POST['stud_str']=implode("\n",$num_arr);
		$_POST['default']=1;
	}
}

//���~�ůS�ب����ͦ��Z�ҩ�
if ($_POST['sp_all']) {
	$query="select * from stud_seme_dis where seme_year_seme='$seme_year_seme' and seme_class like '".$_POST['year_name']."%' and sp_kind>'0' order by seme_class,seme_num";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		$num_arr[]=substr($res->fields['seme_class'],-2,2).sprintf("%02d",$res->fields['seme_num']);
		$res->MoveNext();
	}
	if (count($num_arr)>0) {
		$_POST['stud_str']=implode("\n",$num_arr);
		$_POST['default_sp']=1;
	}
}

$temp_arr=array();
//�p�G�[�J�F�D�������~��
if ($_POST['add'] && $_POST['stud_id']) {
	$query="select * from stud_base where stud_id='".$_POST['stud_id']."'";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		$s=$res->fields['student_sn'];
		$temp_arr[$s]['stud_name']=$res->fields['stud_name'];
		$temp_arr[$s]['stud_sex']=$res->fields['stud_sex'];
		$temp_arr[$s]['stud_id']=$res->fields['stud_id'];
		$temp_arr[$s]['stud_study_year']=$res->fields['stud_study_year'];
		$res->MoveNext();
	}
	$smarty->assign("rowdata",$temp_arr);
}

//�p����x�s�D�����ǥ͸��
$s=intval($_POST[sn]);
if ($s) {
	$query="select * from stud_base where student_sn='$s'";
	$res=$CONN->Execute($query);
	//���X�J�Ǧ~
	$stud_study_year=$res->fields['stud_study_year'];
	$f_year=2;
	$semes=array();
	//�p��Ǵ�
	for ($i=$starty;$i<=$f_year;$i++) {
		for ($j=1;$j<=2;$j++) {
			$semes[]=sprintf("%03d",$stud_study_year+$i).$j;
		}
	}
	array_pop($semes);

	//�]�w�y�����}�C
	$sn=array();
	$sn[]=$s;

	//�M�w���(�Ǭ�)�X�{����
	$ss_link=array(1=>"chinese",2=>"english",3=>"language",4=>"math",5=>"social",6=>"nature",7=>"art",8=>"health",9=>"complex");

	//�p�⤧�p�Ʀ��
	$nnum=2;
	$fin_score=cal_fin_score($sn,$semes,"","");
	$s_num=count($semes);//�Ǵ���
	foreach($sn as $i) {
		reset($ss_link);
		foreach($ss_link as $jj => $j) {
			if ($j=="language") continue;
			reset($semes);
			$score=0;
			foreach($semes as $kk => $k) {
				//���ƭp��ĥ|�ˤ��J
				$sc=round($fin_score[$i][$j][$k]['score'],$nnum);
				$score+=$sc;
				//�g�J����
				$CONN->Execute("insert into dis_score_grad (student_sn,year,seme,ss_no,score) values ('$i','$sel_year','$kk','$jj','$sc')");
			}
			$CONN->Execute("insert into dis_score_grad (student_sn,year,seme,ss_no,score) values ('$i','$sel_year','$s_num','$jj','".round($score/$s_num,$nnum)."')");
		}
	}

	//�p��y���줣�[�v����
	$query="select student_sn,seme,sum(score) as sc from dis_score_grad where ss_no in ('1','2') and year='$sel_year' group by student_sn,seme order by student_sn,seme";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		//�g�J����
		$sc=$res->fields['sc'];
		$CONN->Execute("insert into dis_score_grad (student_sn,year,seme,ss_no,score) values ('".$res->fields['student_sn']."','$sel_year','".$res->fields['seme']."','3','".round(($sc/2),$nnum)."')");
		$res->MoveNext();
	}

	//�p��U�줣�[�v����
	$ss_num=count($ss_link);//��ؼ�
	$query="select student_sn,ss_no,sum(score) as sc from dis_score_grad where year='$sel_year' group by student_sn,ss_no order by student_sn,ss_no";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		//�g�J����
		$sc=$res->fields['sc'];
		$CONN->Execute("insert into dis_score_grad (student_sn,year,seme,ss_no,score) values ('".$res->fields['student_sn']."','$sel_year','$s_num','".$res->fields['ss_no']."','".round($sc/$s_num,$nnum)."')");
		$res->MoveNext();
	}

	//�p��U�Ǵ����[�v����(�Ǵ��`��/8)
	$query="select student_sn,seme,sum(score) as sc from dis_score_grad where ss_no not in ('3') and year='$sel_year' group by student_sn,seme order by student_sn,seme";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		//�g�J����
		$sc=$res->fields['sc'];
		$CONN->Execute("insert into dis_score_grad (student_sn,year,seme,ss_no,score) values ('".$res->fields['student_sn']."','$sel_year','".$res->fields['seme']."','".($ss_num+1)."','".round($sc/($ss_num-1),$nnum)."')");
		$res->MoveNext();
	}

	//�̫᪺�`�����A�H�U�Ǵ���������
	$query="select student_sn,sum(score) as sc from dis_score_grad where ss_no='".($ss_num+1)."' and seme<'$s_num' and year='$sel_year' group by student_sn order by student_sn";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		//�g�J����
		$sc=$res->fields['sc'];
		$CONN->Execute("update dis_score_grad set score='".round(($sc/$s_num),$nnum)."' where student_sn='".$res->fields['student_sn']."' and year='$sel_year' and seme='$s_num' and ss_no='".($ss_num+1)."'");
		$res->MoveNext();
	}
}

//�p�G����J�ǥ͸��
if ($_POST['stud_str']) {
	$stud_arr=explode("\n",$_POST['stud_str']);
	foreach($stud_arr as $k=>$v) $stud_arr[$k]=trim($v);

	//���X�ǥ͸��
	$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
	$seme_class=$_POST[year_name]."%";
	$query="select a.*,b.stud_name,b.stud_person_id,b.stud_sex,b.stud_birthday from stud_seme_dis a left join stud_base b on a.student_sn=b.student_sn where a.seme_year_seme='$seme_year_seme' and a.seme_class like '$seme_class' order by a.seme_class,a.seme_num";
	$res=$CONN->Execute($query);
	$sn=array();
	$show_sn=array();
	$stud_data=array();
	while(!$res->EOF) {
		$seme_class=$res->fields[seme_class];
		//�u��������ǥͤ~�B�z
		if (in_array(substr($seme_class,-2,2).sprintf("%02d",$res->fields[seme_num]),$stud_arr)) {
			$s=$res->fields[student_sn];
			$sn[]=$s;
			$sp_kind=$res->fields['sp_kind'];
			$show_sn[$seme_class][$res->fields[seme_num]]=$s;
			$stud_data[$s][stud_name]=$res->fields[stud_name];
			$stud_data[$s][stud_id]=$res->fields[stud_id];
			$stud_data[$s][stud_person_id]=$res->fields[stud_person_id];
			$stud_data[$s][stud_sex]=$res->fields[stud_sex];
			$stud_data[$s][enable0]=$res->fields[enable0];
			$stud_data[$s][enable1]=$res->fields[enable1];
			$stud_data[$s][enable2]=$res->fields[enable2];
			$stud_data[$s]['sp_cal']=$res->fields['sp_cal'];
			$stud_data[$s]['kind']=$res->fields['stud_kind'];
			$stud_data[$s]['sp_kind']=$sp_kind;
			$stud_data[$s]['plus']=$plus_arr[$sp_kind];
			$d_arr=explode("-",$res->fields[stud_birthday]);
			$dd=$d_arr[0]-1911;
			$stud_data[$res->fields[student_sn]][stud_birthday]=$dd." �~ ".sprintf("%02d",$d_arr[1])." �� ".sprintf("%02d",$d_arr[2])." ��";
		}
		$res->MoveNext();
	}
	$stud_num=$res->RecordCount();

	if (count($sn)>0) {
		$sn_str="'".implode("','",$sn)."'";
		$temp_arr=array();
		//����¾�˰e�Ҧ��չ��P�ҩ���
		if ($_POST['CHK'] || $_POST['CHC'] || $_POST['TCC']) {
			//�έp�k�k�ͤH��
			$query="select count(b.student_sn) as num,b.stud_sex from stud_seme a left join stud_base b on a.student_sn=b.student_sn where a.seme_year_seme='$seme_year_seme' and a.seme_class like '".$_POST[year_name]."%' and b.stud_study_cond in ('0','15') group by b.stud_sex order by b.stud_sex";
			$res=$CONN->Execute($query);
			while(!$res->EOF) {
				$s="stud_num_".$res->fields['stud_sex'];
				$$s=$res->fields['num'];
				$smarty->assign("sex".$res->fields['stud_sex'],$res->fields['num']);
				$res->MoveNext();
			}
			for ($i=1;$i<=2;$i++) {
				for ($j=1;$j<=2;$j++) {
					$temp_arr[sprintf("%03d",$stud_study_year+$i).$j]=($stud_study_year+$i)."�Ǧ~�ײ�".$j."�Ǵ�";
				}
			}
			array_pop($temp_arr);
			$temp_arr2=array();
			$query="select distinct concat(year,semester,stage),year,semester,stage from dis_stage_fin";
			$res=$CONN->Execute($query);
			while(!$res->EOF) {
				for($i=1;$i<=$res->fields['stage'];$i++) $temp_arr2[(sprintf("%03d",$res->fields['year']).$res->fields['semester'])][$i]=$i;
				$res->MoveNext();
			}
			//���X���Z
			$query="select * from dis_stage_fin where student_sn in ($sn_str)";
			$res=$CONN->Execute($query);
			$rowdata=array();
			while(!$res->EOF) {
				$sc=($res->fields['score']=="-100")?0:$res->fields['score'];
				if ($res->fields['stage']=="pr")
					$rowdata[$res->fields['student_sn']][(sprintf("%03d",$res->fields['year']).$res->fields['semester'])]['avg'][$res->fields['subject']][pr]=$sc;
				else
					$rowdata[$res->fields['student_sn']][(sprintf("%03d",$res->fields['year']).$res->fields['semester'])][$res->fields['stage']][$res->fields['subject']][score]=$sc;
				$res->MoveNext();
			}
			$smarty->assign("sch_arr",get_school_base());
			$smarty->assign("student_sn",$show_sn);
			$smarty->assign("stud_data",$stud_data);
			$smarty->assign("s_arr",array("chinese"=>"����y��","english"=>"�^�y","math"=>"�ƾ�","nature"=>"�۵M�P���","social"=>"���|"));
			$smarty->assign("seme_arr",$temp_arr);
			$smarty->assign("stage_arr",$temp_arr2);
			$smarty->assign("rowdata",$rowdata);
			$smarty->assign("sex0",$stud_num);
			if ($_POST['CHC'])
				$smarty->display("stud_basic_test_distest4_print_chc.tpl");
			elseif ($_POST['TCC'])
				$smarty->display("stud_basic_test_distest4_print_tcc.tpl");
			else
				$smarty->display("stud_basic_test_distest4_print.tpl");
			exit;
		}

		//����¾�ӽмҦ��w�]��{�ҩ���
		if ($_POST['default'] || $_POST['default_sp']) {
			//���X�ĭp�Ǵ�
			for ($i=$starty;$i<=$f_year;$i++) {
				for ($j=1;$j<=2;$j++) {
					$semes[]=sprintf("%03d",$stud_study_year+$i).$j;
				}
			}
			array_pop($semes);
			for($i=1;$i<=count($y_arr);$i++) {
				for($j=1;$j<=count($s_arr);$j++) {
					$temp_arr[$i.$j]=$y_arr[$i].$s_arr[$j];
				}
				$temp2_arr[$i]=$semes[$i-1];
			}
			$s_num=count($semes);
			$smarty->assign("sex0",$stud_num);

			//���X���Z
			$rowdata=array();
			$query="select * from dis_score_fin where student_sn in ($sn_str) order by student_sn,seme,ss_no";
			$res=$CONN->Execute($query);
			while(!$res->EOF) {
				$rowdata[$res->fields['student_sn']][$res->fields['seme']][$res->fields['ss_no']][score]=$res->fields['score'];
				if ($res->fields['pr']!=0) $rowdata[$res->fields['student_sn']][$res->fields['seme']][$res->fields['ss_no']][pr]=$res->fields['pr'];
				$rowdata[$res->fields['student_sn']][$res->fields['seme']][$res->fields['ss_no']][pscore]=$res->fields['sp_score'];
				if ($res->fields['sp_pr']!=0) $rowdata[$res->fields['student_sn']][$res->fields['seme']][$res->fields['ss_no']][ppr]=$res->fields['sp_pr'];
				if ($_POST['default_sp']) {
					for($i=0;$i<3;$i++) $rowdata[$res->fields['student_sn']][$i][$res->fields['ss_no']][pscore]=$rowdata[$res->fields['student_sn']][$i][$res->fields['ss_no']][score]*(1+$stud_data[$res->fields['student_sn']]['plus']/100);
				}
				$res->MoveNext();
			}
			$semes[$s_num]="avg";
			$smarty->assign("sch_arr",get_school_base());
			$smarty->assign("student_sn",$show_sn);
			$smarty->assign("stud_data",$stud_data);
			$smarty->assign("pry",$s_num);
			$smarty->assign("rowdata",$rowdata);
			$smarty->assign("s_arr",array(1=>"����y��",2=>"�^�y",3=>"�y�奭��",4=>"�ƾǻ��",5=>"���|���",6=>"�۵M�P�ͬ���޻��",7=>"���N�P�H����",8=>"���d�P��|���",9=>"��X���ʻ��",10=>"�Ǵ��`���Z"));
			if ($_POST['default_sp'])
				$smarty->display("stud_basic_test_setup_print.tpl");
			else
				$smarty->display("stud_basic_test_distest5_print.tpl");
			exit;
		}
	}
} elseif (count($_POST['sel_sn'])>0 && $_POST['print']) {
	//�D�������Z
	$pre_str="";
	foreach($_POST['sel_sn'] as $s=>$d) $pre_str.="'".intval($s)."',";
	$pre_str=substr($pre_str,0,-1);
	$_POST['default']=1;
	$query="select * from stud_base where student_sn in ($pre_str)";
	$res=$CONN->Execute($query);
	$sn=array();
	$show_sn=array();
	$stud_data=array();
	while(!$res->EOF) {
		$seme_class=substr($res->fields['curr_class_num'],0,3);
		$s=$res->fields[student_sn];
		$sn[]=$s;
		$show_sn[$seme_class][$res->fields[seme_num]]=$s;
		$stud_data[$s][stud_name]=$res->fields[stud_name];
		$stud_data[$s][stud_id]=$res->fields[stud_id];
		$stud_data[$s][stud_person_id]=$res->fields[stud_person_id];
		$stud_data[$s][stud_sex]=$res->fields[stud_sex];
		$d_arr=explode("-",$res->fields[stud_birthday]);
		$dd=$d_arr[0]-1911;
		$stud_data[$res->fields[student_sn]][stud_birthday]=$dd." �~ ".sprintf("%02d",$d_arr[1])." �� ".sprintf("%02d",$d_arr[2])." ��";
		$res->MoveNext();
	}
	$stud_num=$res->RecordCount();
	if (count($sn)>0) {
		$sn_str="'".implode("','",$sn)."'";
		$temp_arr=array();
		//���X���Z
		$rowdata=array();
		$query="select * from dis_score_grad where student_sn in ($sn_str) and year='$sel_year'";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			$rowdata[$res->fields['student_sn']][$res->fields['seme']][$res->fields['ss_no']][score]=$res->fields['score'];
			$res->MoveNext();
		}
		//��ӱƧ�
		$s_arr=array(1=>"����y��",2=>"�^�y",3=>"�y�奭��",4=>"�ƾǻ��",5=>"���|���",6=>"�۵M�P�ͬ���޻��",7=>"���N�P�H����",8=>"���d�P��|���",9=>"��X���ʻ��",10=>"�Ǵ��`���Z");
		foreach($rowdata as $sn=>$d) {
			reset($s_arr);
			foreach($s_arr as $ss_no=>$dd) {
				$sc=$rowdata[$sn][3][$ss_no][score];
				$query="select * from temp_tcc_score where seme='3' and ss_no='$ss_no' and score>='$sc' order by pr desc limit 0,1";
				$res=$CONN->Execute($query);
				$upr=$res->fields['pr'];
				$mypr=($upr=="")?1:$upr;
				$rowdata[$sn][3][$ss_no]['pr']=$mypr;
			}
		}
		$semes[$s_num]="avg";
		$smarty->assign("sch_arr",get_school_base());
		$smarty->assign("student_sn",$show_sn);
		$smarty->assign("stud_data",$stud_data);
		$smarty->assign("pry",$s_num);
		$smarty->assign("rowdata",$rowdata);
		$smarty->assign("s_arr",$s_arr);
		if ($_POST['default_sp'])
			$smarty->display("stud_basic_test_setup_print.tpl");
		else
			$smarty->display("stud_basic_test_distest5_print.tpl");
		exit;
	}
}

//���X�D�������~�͸��
$pre_arr=array();
$query="select distinct student_sn from dis_score_grad where year='$sel_year'";
$res=$CONN->Execute($query);
while(!$res->EOF) {
	$pre_arr[]=$res->fields['student_sn'];
	$res->MoveNext();
}
if (count($pre_arr)>0) {
	$pre_str="'".implode("','",$pre_arr)."'";
	$pre_arr=array();
	$query="select * from stud_base where student_sn in ($pre_str)";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		$s=$res->fields['student_sn'];
		$pre_arr[$s]['stud_name']=$res->fields['stud_name'];
		$pre_arr[$s]['stud_sex']=$res->fields['stud_sex'];
		$pre_arr[$s]['stud_id']=$res->fields['stud_id'];
		$pre_arr[$s]['stud_study_year']=$res->fields['stud_study_year'];
		$res->MoveNext();
	}
	$smarty->assign("predata",$pre_arr);
}

$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE); 
$smarty->assign("module_name","�K�դJ�ǳ���-��ƳB�z"); 
$smarty->assign("SFS_MENU",$menu_p); 
$smarty->assign("year_seme_menu",year_seme_menu($sel_year,$sel_seme)); 
$smarty->assign("class_year_menu",class_year_menu($sel_year,$sel_seme,$_POST[year_name]));
$smarty->display("stud_basic_test_chart.tpl");
?>
