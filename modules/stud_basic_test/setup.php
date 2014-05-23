<?php

// $Id: setup.php 7219 2013-03-12 07:02:20Z brucelyc $

include "select_data_config.php";

sfs_check();

//�P�_���������O
$type9="";
$query="select * from stud_subkind_ref where type_id='9'";
$res=$CONN->Execute($query);
$smarty->assign("clan",$res->fields['clan_title']); 
$smarty->assign("area",$res->fields['area_title']);
$temp_str=$res->fields['memo_title'];
if ($temp_str=="�ڻy�{��") $type9="memo";
$smarty->assign("memo",$temp_str); 
$temp_str=$res->fields['note_title'];
if ($temp_str=="�ڻy�{��") $type9="note";
$smarty->assign("note",$res->fields['note_title']); 

//�P�_�ҥ~��ޤH�~�l�k
$type71="";
$have71=0;
$query="select * from sfs_text where t_kind='stud_kind' and t_name='�ҥ~��ޤH�~�l�k'";
$res=$CONN->Execute($query);
if ($res->fields['d_id']=="") {
	$query="select * from sfs_text where t_kind='stud_kind' and (d_id/1)>'70' order by d_id";
	$res=$CONN->Execute($query);
	if ($res->fields['d_id']>71 || $res->fields['d_id']=="") $type71=71;
	else {
		$oid=70;
		while(!$res->EOF) {
			if ($res->fields['d_id']!=($oid+1)) break;
			$oid=$res->fields['d_id'];
			$type71=$oid+2;
			$res->MoveNext();
		}
	}
} else {
	$type71=$res->fields['d_id'];
	$have71=1;
}

//�P�_�ҥ~��ޤH�~�l�k��s�W
if ($have71) {
	$query="select * from stud_subkind_ref where type_id='$type71'";
	$res=$CONN->Execute($query);
	if ($res->RecordCount()>0) {
		$query="select * from stud_subkind_ref where type_id='$type71' and clan_title='�ӻO�NŪ���p'";
		$res=$CONN->Execute($query);
		if ($res->RecordCount()==0) {
			$query="update stud_subkind_ref set clan_title='�ӻO�NŪ���p',clan='�����@�Ǵ�\r\n�����@�Ǧ~\r\n�����G�Ǧ~\r\n�����T�Ǧ~' where type_id='$type71'";
			$res=$CONN->Execute($query);
		}
	} else {
		$query="insert into stud_subkind_ref (type_id,clan_title,clan) values ('$type71','�ӻO�NŪ���p','�����@�Ǵ�\r\n�����@�Ǧ~\r\n�����G�Ǧ~\r\n�����T�Ǧ~')";
		$res=$CONN->Execute($query);
	}
}

//���~�l�k�s�W�l��
$query="select * from stud_subkind_ref where type_id='12'";
$res=$CONN->Execute($query);
if ($res->RecordCount()>0) {
	$query="select * from stud_subkind_ref where type_id='12' and clan_title='���NŪ���p'";
	$res=$CONN->Execute($query);
	if ($res->RecordCount()==0) {
		$query="update stud_subkind_ref set clan_title='���NŪ���p',clan='�����@�Ǵ�\r\n�����@�Ǧ~\r\n�����G�Ǧ~\r\n�����T�Ǧ~' where type_id='12'";
		$res=$CONN->Execute($query);
		echo "qqq";
	}
} else {
	$query="insert into stud_subkind_ref (type_id,clan_title,clan) values ('12','���NŪ���p','�����@�Ǵ�\r\n�����@�Ǧ~\r\n�����G�Ǧ~\r\n�����T�Ǧ~')";
	$res=$CONN->Execute($query);
}

//�T�w$_POST['spec']��
if ($_POST['spec']!="memo" && $_POST['spec']!="note") $_POST['spec']="";

//�s�W�ĭp�����Ǵ����Z�@���
if ($_POST['add'] && $_POST['stud_id']) {
	$query="select * from stud_base where stud_id='".$_POST['stud_id']."' and stud_study_cond='0'";
	$res=$CONN->Execute($query);
	$student_sn=$res->fields['student_sn'];
	if ($student_sn) {
		$query="select * from stud_seme_dis where seme_year_seme='".sprintf("%03d",curr_year()).curr_seme()."' and sp_kind='0' and student_sn='$student_sn'";
		$res=$CONN->Execute($query);
		$student_sn=$res->fields['student_sn'];
		if ($student_sn) {
			$query="update stud_seme_dis set sp_cal='1' where seme_year_seme='".sprintf("%03d",curr_year()).curr_seme()."' and student_sn='$student_sn'";
			$res=$CONN->Execute($query);
		}
	}
}

//�s�W�ĭp�����Ǵ����Z�S���
if ($_POST['sp'] && $_POST['stud_id']) {
	$query="select * from stud_base where stud_id='".$_POST['stud_id']."' and stud_study_cond='0'";
	$res=$CONN->Execute($query);
	$student_sn=$res->fields['student_sn'];
	if ($student_sn) {
		$query="select * from stud_seme_dis where seme_year_seme='".sprintf("%03d",curr_year()).curr_seme()."' and sp_kind<>'0' and student_sn='$student_sn'";
		$res=$CONN->Execute($query);
		$student_sn=$res->fields['student_sn'];
		if ($student_sn) {
			$query="update stud_seme_dis set sp_cal='1' where seme_year_seme='".sprintf("%03d",curr_year()).curr_seme()."' and student_sn='$student_sn'";
			$res=$CONN->Execute($query);
		}
	}
}

//�s�W���ѻP�ƧǾǥ�
if ($_POST['del'] && $_POST['stud_id']) {
	$query="select * from stud_base where stud_id='".$_POST['stud_id']."' and stud_study_cond='0'";
	$res=$CONN->Execute($query);
	$student_sn=$res->fields['student_sn'];
	if ($student_sn) {
		$query="select * from stud_seme_dis where seme_year_seme='".sprintf("%03d",curr_year()).curr_seme()."' and student_sn='$student_sn'";
		$res=$CONN->Execute($query);
		$student_sn=$res->fields['student_sn'];
		if ($student_sn) {
			$query="update stud_seme_dis set cal='0' where seme_year_seme='".sprintf("%03d",curr_year()).curr_seme()."' and student_sn='$student_sn'";
			$res=$CONN->Execute($query);
		}
	}
}

//�x�s
if ($type9=="" && $_POST['sure9'] && ($_POST['spec']=="memo" || $_POST['spec']=="note")) {
	$query="update stud_subkind_ref set ".$_POST['spec']."_title='�ڻy�{��',".$_POST['spec']."='�L\r\n��' where type_id=9";
	$res=$CONN->Execute($query);
} elseif ($have71==0) {
	$smarty->assign("type71",$type71);
	$_POST['tech']=intval($_POST['tech']);
	if ($_POST['sure71'] && $_POST['tech']) {
		$query="select * from sfs_text where t_kind='stud_kind' and d_id='".$_POST['tech']."'";
		$res=$CONN->Execute($query);
		if ($res->fields['t_name']=="") {
			$query="select * from sfs_text where t_kind='stud_kind' and t_parent=''";
			$res=$CONN->Execute($query);
			$p_id=$res->fields['t_id'];
			$query="insert into sfs_text (t_order_id,t_kind,g_id,d_id,t_name,t_parent,p_id,p_dot) values ('".$_POST['tech']."','stud_kind','1','".$_POST['tech']."','�ҥ~��ޤH�~�l�k','$p_id,','$p_id','.')";
			$res=$CONN->Execute($query) or die("�s�W�u�ҥ~��ޤH�~�l�k�v���ؿ��~");
			header("location: setup.php");
		}
	}
}

if ($type9=="")
	$smarty->assign("stage",1);
elseif ($have71==0)
	$smarty->assign("stage",2);
else {
	$smarty->assign("stage",3);
	//���T�{��ƪ�O�_�s�b
	$query="select * from stud_seme_dis where 1=1";
	$res=$CONN->Execute($query);
	if ($res) {
		//�p�G���F�u�x�s�ĭp�Ǵ��v
		if ($_POST['save']) {
			foreach($_POST['sel'] as $sn=>$v) {
				$query="update stud_seme_dis set enable0='".($_POST['cal'][$sn][0]?1:"")."',enable1='".($_POST['cal'][$sn][1]?1:"")."',enable2='".($_POST['cal'][$sn][2]?1:"")."' where seme_year_seme='".sprintf("%03d",curr_year()).curr_seme()."' and student_sn='$sn'";
				$res=$CONN->Execute($query);
			}
		}
		$query="select a.*,b.stud_name,b.stud_sex from stud_seme_dis a left join stud_base b on a.student_sn=b.student_sn where a.seme_year_seme='".sprintf("%03d",curr_year()).curr_seme()."' and (sp_kind>'0' or sp_cal='1') and a.seme_class like '9%' order by a.sp_kind,a.seme_class,a.seme_num";
		$res=$CONN->Execute($query);
		$rowdata=array();
		$stud_data=array();
		while(!$res->EOF) {
			$sn=$res->fields['student_sn'];
			$sp_kind=$res->fields['sp_kind'];
			$query2="select stud_id from stud_base where student_sn='$sn'";
			$res2=$CONN->Execute($query2);
			$rowdata[$sp_kind][$sn]['stud_id']=$res2->fields['stud_id'];
			$rowdata[$sp_kind][$sn]['seme_class']=$res->fields['seme_class'];
			$rowdata[$sp_kind][$sn]['seme_num']=$res->fields['seme_num'];
			$rowdata[$sp_kind][$sn]['name']=$res->fields['stud_name'];
			$rowdata[$sp_kind][$sn]['sex']=$res->fields['stud_sex'];
			$rowdata[$sp_kind][$sn]['sp_cal']=$res->fields['sp_cal'];
			$stud_data[$sn]['enable0']=$res->fields['enable0'];
			$stud_data[$sn]['enable1']=$res->fields['enable1'];
			$stud_data[$sn]['enable2']=$res->fields['enable2'];
			$stud_data[$sn]['sp_cal']=$res->fields['sp_cal'];
			$stud_data[$sn]['kind']=$res->fields['stud_kind'];
			$stud_data[$sn]['sp_kind']=$sp_kind;
			$stud_data[$sn]['plus']=$plus_arr[$sp_kind];
			$res->MoveNext();
		}
	}
	$smarty->assign("rowdata",$rowdata);
	$smarty->assign("spc_arr",array(0=>"�@���",1=>"����",2=>"����",3=>"�ҥ~��ޤH�~�l�k",4=>"�ҥ~��ޤH�~�l�k",5=>"�ҥ~��ޤH�~�l�k",6=>"�ҥ~��ޤH�~�l�k",7=>"���~�H���l�k",8=>"���~�H���l�k",9=>"���~�H���l�k",'A'=>"���~�H���l�k",'B'=>"�X�å�",'C'=>"���٥�"));
	$smarty->assign("spo_arr",array(1=>"�L�ڻy�{��",2=>"���ڻy�{��",3=>"�����@�Ǵ�",4=>"�����@�Ǧ~",5=>"�����G�Ǧ~",6=>"�����T�Ǧ~",7=>"�����@�Ǵ�",8=>"�����@�Ǧ~",9=>"�����G�Ǧ~",'A'=>"�����T�Ǧ~",'B'=>"",'C'=>""));
	$smarty->assign("chk_arr",array(0=>"1",3=>"1",4=>"1",5=>"1",6=>"1",7=>"1",8=>"1",9=>"1",'A'=>"1"));
	$smarty->assign("plus_arr",$plus_arr);
	$smarty->assign("stud_data",$stud_data);

	if (count($_POST['sel'])>0 && $_POST['print']) {
		$allprint="";
		foreach($_POST['sel'] as $sn=>$v) $allprint.="'$sn',";
		$allprint=substr($allprint,0,-1);
		$query="select * from stud_seme_dis where seme_year_seme='".sprintf("%03d",curr_year()).curr_seme()."' and student_sn in ($allprint) order by sp_kind,seme_class,seme_num";
		$res=$CONN->Execute($query);
		$show_sn=array();
		while(!$res->EOF) {
			$seme_class=$res->fields[seme_class];
			$show_sn[$seme_class][$res->fields[seme_num]]=$res->fields[student_sn];
			$res->MoveNext();
		}
		$query="select * from stud_base where student_sn in ($allprint)";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			$sn=$res->fields['student_sn'];
			$stud_data[$sn][stud_name]=$res->fields['stud_name'];
			$stud_data[$sn][stud_id]=$res->fields['stud_id'];
			$stud_data[$sn][stud_person_id]=$res->fields['stud_person_id'];
			$stud_data[$sn][stud_sex]=$res->fields['stud_sex'];
			$stud_data[$sn][stud_addr_1]=$res->fields['stud_addr_1'];
			$stud_data[$sn][stud_tel_1]=$res->fields['stud_tel_1'];
			$stud_data[$sn][addr_zip]=$res->fields['addr_zip'];
			$res->MoveNext();
		}
		$s_arr=array(1=>"����y��",2=>"�^�y",3=>"�y�奭��",4=>"�ƾ�",5=>"���|",6=>"�۵M�P�ͬ����",7=>"���N�P�H��",8=>"���d�P��|",9=>"��X����",10=>"�Ǵ����Z����");
		$query="select * from temp_tcc_score where student_sn in ($allprint)";
		$res=$CONN->Execute($query);
		$rowdata=array();
		while(!$res->EOF) {
			$rowdata[$res->fields['student_sn']][$res->fields['seme']][$res->fields['ss_no']][score]=$res->fields['score'];
			$rowdata[$res->fields['student_sn']][$res->fields['seme']][$res->fields['ss_no']][pr]=$res->fields['pr'];
			$res->MoveNext();
		}

		foreach($rowdata as $sn=>$d) {
			reset($s_arr);
			foreach($s_arr as $ss_no=>$dd) {
				$plus=1+$stud_data[$sn][plus]/100;
				$sc=$rowdata[$sn][3][$ss_no][score]*$plus;
				$rowdata[$sn][3][$ss_no][pscore]=$sc;
				$query="select * from temp_tcc_score where seme='3' and ss_no='$ss_no' and score>='$sc' order by pr desc limit 0,1";
				$res=$CONN->Execute($query);
				$upr=$res->fields['pr'];
				$mypr=(intval($upr)==0)?1:$upr;
				$rowdata[$sn][3][$ss_no][ppr]=$mypr;
			}
			$rowdata[$sn][3][$ss_no][pscore]=$sc;
			for($i=0;$i<3;$i++) $rowdata[$sn][$i][$ss_no][pscore]=$rowdata[$sn][$i][$ss_no][score]*$plus;
		}
		$smarty->assign("student_sn",$show_sn);
		$smarty->assign("rowdata",$rowdata);
		$smarty->assign("stud_data",$stud_data);
		$smarty->assign("sch_arr",get_school_base());
		$smarty->assign("s_arr",$s_arr);
		$smarty->display("stud_basic_test_setup_print.tpl");
		exit;
	}
}
$smarty->assign("SFS_PATH_HTML",$SFS_PATH_HTML);
$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE); 
$smarty->assign("module_name","�K�դJ�ǯS�ب����ǥͳ]�w"); 
$smarty->assign("SFS_MENU",$menu_p); 
$smarty->display("stud_basic_test_setup.tpl");
?>
