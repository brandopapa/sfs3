<?php

// $Id: trans_san.php 6534 2011-09-22 09:46:05Z infodaes $

//���J�]�w��
include "config.php";
include "../../include/sfs_case_PLlib.php";
include "../../include/sfs_case_subjectscore.php";
include "my_fun.php";

//�{���ˬd
sfs_check();

//�]�w�W�ǥؿ�
$path_str = "temp/teacher/san/";
set_upload_path($path_str);
$temp_path = $UPLOAD_PATH.$path_str;

$_FILES['upload_setup_file']['name']=trim($_FILES['upload_setup_file']['name']);
//�B�z�ɮפW��
if ($_POST['doup_key']) {
	$file_name=strtoupper($_FILES['upload_setup_file']['name']);
	if ($_FILES['upload_setup_file']['name']!="") {
		$dd=explode(".",$_FILES['upload_setup_file']['name']);
		$s_str="/";
		if (substr(strtoupper($_ENV['OS']),0,3)=="WIN") {
			$ff_arr=explode("\\",$_FILES['upload_setup_file']['tmp_name']);
			$ff_str=$ff_arr[0];
			for($i=1;$i<(count($ff_arr)-1);$i++) $ff_str.="\\".$ff_arr[$i];
			if (strtoupper($ff_str)==strtoupper($tmp_path)) $tmp_path=$ff_str;
			$s_str="\\";
		}
	}
	if (is_uploaded_file($_FILES['upload_setup_file']['tmp_name']) && !$_FILES['upload_setup_file']['error'] && $_FILES['upload_setup_file']['size'] >0 && $file_name != "" && (strstr($file_name,"Y91S9") || strstr($file_name,"YSUBJ")) && substr($file_name,-3,3) == "CSV"){
		move_uploaded_file($tmp_path.$s_str.basename($_FILES['upload_setup_file']['tmp_name']),$temp_path.$_FILES['upload_setup_file']['name']);
	}
	if (is_uploaded_file($_FILES['upload_file']['tmp_name']) && !$_FILES['upload_file']['error'] && $_FILES['upload_file']['size'] >0 && $file_name != "" && strstr($file_name,"Y91G9") && substr($file_name,-3,3) == "CSV"){
		move_uploaded_file($tmp_path.$s_str.basename($_FILES['upload_file']['tmp_name']),$temp_path.$_FILES['upload_file']['name']);
	}
}

//���o���A���ɮ׿��
if (strlen($_POST['file_name1'])>5) {
	$sel_year=substr($_POST['file_name1'],4,2);
	$sel_seme=substr($_POST['file_name1'],6,1);
	$sel_cyear=substr($_POST['file_name1'],7,1);
	$chk_file1="(".$sel_year."�Ǧ~�ײ�".$sel_seme."�Ǵ�".$sel_cyear."�~��)";
	$chk_file2=substr($_POST['file_name1'],0,3)."G".substr($_POST['file_name1'],4,3);
	$smarty->assign("chk_file1",$chk_file1);
	$smarty->assign("file_menu2",file_menu($temp_path,$_POST['file_name2'],"file_name2",$chk_file2,"CSV"));
	if (strlen($_POST['file_name2'])>5) {
		$chk_file2="(".substr($_POST['file_name2'],4,2)."�Ǧ~�ײ�".substr($_POST['file_name2'],6,1)."�Ǵ�".substr($_POST['file_name2'],7,1)."�~��)";
		$smarty->assign("chk_file2",$chk_file2);
	}
}

//��ƶפJ
if ($_POST['import']) {

	$subj_no_arr=array();
	$subj_no_str="";
	while(list($k,$v)=each($_POST['sel_subj'])) {
		if ($v!="") {
			$subj_no_arr[$k]=$v;
			$subj_no_str.="'$k',";
		}
	}
	if (count($subj_no_arr)>0) {
		//���o�ǥ͸��
		$query="select * from stud_base where stud_study_year='".$_POST['stud_study_year']."'";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			$stud_sn_arr[$res->fields['stud_id']]=$res->fields['student_sn'];
			$res->MoveNext();
		}

		//���J���
		$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
		$subj_no_str=substr($subj_no_str,0,-1);
		$in_err=0;	//�פJ���~����
		$sn_err=0;	//�Ǹ����~����
		$ok=0;	//�פJ���T����
		$err=0;
		$query="select * from temp_san where subj_no in ($subj_no_str) order by stud_id,subj_no";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			$score=$res->fields['score'];
			if ($score=="999") $score=0;	//���Ƥ�999���u�L��ơv
			if ($stud_sn_arr[$res->fields['stud_id']]!="") {
				$query="insert into stud_seme_score (seme_year_seme,student_sn,ss_id,ss_score,teacher_sn) values ('$seme_year_seme','".$stud_sn_arr[$res->fields['stud_id']]."','".$subj_no_arr[$res->fields['subj_no']]."','$score','".$_SESSION['session_tea_sn']."')";
				$CONN->Execute($query) or $err=1;
				if ($err==1)
					$in_err++;
				else
					$ok++;
				$err=0;
			} else {
				$sn_err++;
			}
			$res->MoveNext();
		}
		$_POST['file_name1']="";
		$smarty->assign("in_err",$in_err);
		$smarty->assign("sn_err",$sn_err);
		$smarty->assign("ok",$ok);
	}
//������
} elseif ($_POST['file_name1'] && $_POST['file_name2']) {
	$file1=$temp_path."/".$_POST['file_name1'];
	$fp1=fopen($file1,"r");

	//���س]�w�����W�ˬd
	$cols=array();
	$cols=sfs_fgetcsv($fp1,2000,",");
	while(list($i,$v)=each($cols)) {
		if ($v=="SUBJ_NO") $subj_no=$i;
		if ($v=="SUBJ_NAME") $subj_name=$i;
		if ($v=="SHORT") $short=$i;
	}

	//�T�w��쥿�T�~�i��B�z
	if (!is_null($subj_no) && $subj_name!="" && $short!="") {
		while($k=sfs_fgetcsv($fp1, 2000, ",")) {
			$subj_arr[$k[$subj_no]]['subj_name']=$k[$subj_name];
			$subj_arr[$k[$subj_no]]['short_name']=$k[$short];
		}
		$smarty->assign("subj_arr",$subj_arr);

		//�إ߼Ȧs��Ʈw
		$CONN->Execute("DROP TABLE if exists temp_san;");
		$query="
			CREATE TABLE if not exists temp_san (
			stud_id varchar(10) NOT NULL default '',
			subj_no smallint(5) unsigned NOT NULL default '0',
			score float  NOT NULL default '0',
		  PRIMARY KEY  (stud_id,subj_no)
		  ) ;";
		$CONN->Execute($query);		
		$file2=$temp_path."/".$_POST['file_name2'];
		$fp2=fopen($file2,"r");

		//�즨�Z�����W�ˬd
		$cols=array();
		$cols=sfs_fgetcsv($fp2,2000,",");
		while(list($i,$v)=each($cols)) {
			if ($v=="STUD_NO") $stud_no=$i;
			if ($v=="SUBJ_NO") $subj_no=$i;
			if ($v=="HDTMSCORE") $score=$i;
		}

		//�T�w��쥿�T�~�i��B�z
		if (!is_null($stud_no) && $subj_no!="" && $score!="") {

			//�N���Z�ɼg�J�Ȧs��Ʈw
			while($k=sfs_fgetcsv($fp2, 2000, ",")) {
				$CONN->Execute("insert into temp_san (stud_id,subj_no,score) values ('".$k[$stud_no]."','".$k[$subj_no]."','".$k[$score]."')");
			}
			$query="select * from temp_san order by stud_id,subj_no";
			$res=$CONN->Execute($query);
			while(!$res->EOF) {
				if ($sno=="") $sno=$res->fields[stud_id];
				if ($sno!=$res->fields[stud_id]) break;
				$rowdata[$res->fields[subj_no]]=$res->fields[score];
				$res->MoveNext();
			}
			$smarty->assign("rowdata",$rowdata);

			//���X�ǥ͸��
			$query="select * from stud_base where stud_id='$sno' order by stud_study_year desc";
			$res=$CONN->Execute($query);
			while(!$res->EOF) {
				$stud_data[]=$res->FetchRow();
				$res->MoveNext();
			}
			$smarty->assign("stud_data",$stud_data);

			//���o�ǰȨt�Ϊ���ؿ��
			$class=array("0"=>$sel_year,"1"=>$sel_seme,"3"=>$sel_cyear,"4"=>"0");
			$r=&get_ss_name_arr($class);
			$smarty->assign("subj_menu",subj_menu($r));
		}
	}
	fclose($fp1);
}

//��ƾɥX��˪���
$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE); 
$smarty->assign("module_name","�פJ�T�p��T�t�Φ��Z���"); 
$smarty->assign("SFS_MENU",$MENU_P);
$smarty->assign("file_menu1",file_menu($temp_path,$_POST['file_name1'],"file_name1","Y91S9","CSV"));
$smarty->display("seme_score_input_trans_san.tpl");
?>
