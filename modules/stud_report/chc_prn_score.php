<?php
//$Id: chc_prn_score.php 6988 2012-10-31 08:01:39Z infodaes $
require_once( "./chc_config.php");
include_once "../../include/sfs_case_dataarray.php";

//�C�L���y�O����
//�{��
sfs_check();
// 1.smarty����
//$template_dir = $_SERVER[DOCUMENT_ROOT].dirname($_SERVER[PHP_SELF])."/templates/";
$template_dir = $SFS_PATH."/".get_store_path()."/templates/";
$prn_move_tpl=$template_dir."prn_move.tpl";

// $smarty->config_dir = $template_dir;
$smarty->left_delimiter="{{";
$smarty->right_delimiter="}}";
//	�N�򥻪��ܼƤΰ}�C�ǤJ smarty


function get_stsn($class_id){
		global $CONN;
	$st_sn=array();
	foreach($class_id as $key=>$data){
	$class_ids=split("_",$key);
	$seme=$class_ids[0].$class_ids[1];
	$the_class=($class_ids[2]+0).$class_ids[3];
	$SQL="select student_sn from stud_seme where  seme_year_seme ='$seme' and seme_class='$the_class' order by seme_num ";
	$rs = $CONN->Execute($SQL);
	$the_sn=$rs->GetArray();
	for ($i=0;$i<$rs->RecordCount();$i++){
		array_push($st_sn,$the_sn[$i][student_sn]);
		}
	}
	return $st_sn;
}
///�H�Z�Ű}�C���X�ǥ�
if ($_POST[act]=='OK' && is_array($_POST[class_id]) ){
	$sn_ary=get_stsn($_POST[class_id]);
//			print_r($sn_ary);die();
	}

///�H�Ǹ����X�ǥ�
if (($_POST[act]=='OK' && $_POST[list_stud_id]) || $_GET[list_stud_id]){
($_POST[list_stud_id]!='') ? $list_stud_id=$_POST[list_stud_id]:$list_stud_id=$_GET[list_stud_id];
	if (ereg('-',$list_stud_id)==true){
		$aa=split('-',$list_stud_id);//���}�r��
		$SQL="select stud_id,student_sn from stud_base where stud_id between '".$aa[0]."' and '".$aa[1]."' order by stud_id ";
		$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		$All_ss=$rs->GetArray();
		foreach($All_ss as $ss){$sn_ary[]=$ss[student_sn];	}
	}else{
		$SQL="select stud_id,student_sn from stud_base where stud_id ='$list_stud_id' order by stud_id ";
		$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		$All_ss=$rs->GetArray();
		foreach($All_ss as $ss){$sn_ary[]=$ss[student_sn];	}
		}
		//echo "<pre>";
		//print_r($sn_ary);die();
		
	}

//���o�׷~�ǥͲM��
foreach($sn_ary as $value) $student_sn_list.="$value,";
$student_sn_list=substr($student_sn_list,0,-1);
$graduate_kind=array();
$sql="select student_sn,grad_kind from grad_stud where student_sn in ($student_sn_list) order by student_sn";
$res=$CONN->Execute($sql) or user_error("Ū��grad_stud��ƥ��ѡI<br>$sql",256);
while(!$res->EOF) {
	$student_sn=$res->fields['student_sn'];
	$graduate_kind[$student_sn]=$res->fields['grad_kind'];
	$res->MoveNext();
}

//echo "<pre>";
//print_r($graduate_kind);
//echo "</pre>";

$break_page="<P STYLE='page-break-before: always;'>";
//	$pk_detail	���~�Ū��t�Ҹ��
//�q�X�����������Y
//�D�n���e

//���X�U�Z�`��
$query="select a.class_id,b.link_ss,count(a.course_id) as num from score_course a left join score_ss b on a.ss_id=b.ss_id where b.enable='1' group by a.class_id,b.link_ss";
$res=$CONN->Execute($query);
while (!$res->EOF) {
	$section_num[$res->fields[class_id]][$res->fields[link_ss]]=$res->fields[num];
	$res->MoveNext();
}

//$sn_ary = array(1105,1107,1109);
$prn_page = 0;
$smarty->display($template_dir."prn_head.tpl");

$smarty->assign('prn_move_tpl',$prn_move_tpl);
$smarty->assign('guar_kind',guardian_relation());

foreach($sn_ary as $student_sn) {
	$student_data=new data_student($student_sn,$seme);
	$prn_page++;
	if ($IS_JHORES==0) 
		$seme_width=7;
	else
		$seme_width=15;
	$smarty->assign('break_page',($prn_page>1?$break_page:''));
	$smarty->assign('school_name',$school_long_name);
	$smarty->assign('seme_width',$seme_width);
	$smarty->assign('base',$student_data->base);//�򥻸��
	$student_data->all_score=ch_nor($student_data->seme_ary,$student_data->all_score);
	
	$smarty->assign('graduate_kind',$graduate_kind[$student_sn]);
	//�s�W��95�Ǧ~�׫ᤣ��ܤ�`�ͬ����Ħ��Z���\��
	$smarty->assign('seme_ary',$student_data->seme_ary);		//�C�ӾǴ�..�t���Z�y���P���D
	$smarty->assign('all_score',$student_data->all_score);		//�Ҧ��Ǵ����Z
	//echo "<pre>";print_r($student_data->all_score);;
	$smarty->assign('move_data',$student_data->move);			//�Ҧ����ʰO��
//	print_r($student_data->move);
//print "<pre>";print_r($student_data->seme_ary);
	if ($_POST[type]==1) {
		$ss_link=array("�y��-����y��"=>"chinese","�y��-�m�g�y��"=>"local","�y��-�^�y"=>"english","�ƾ�"=>"math","�۵M�P�ͬ����"=>"nature","���|"=>"social","���d�P��|"=>"health","���N�P�H��"=>"art","��X����"=>"complex");
		$link_ss=array("chinese"=>"�y��-<br>����y��","local"=>"�y��-<br>�m�g�y��","english"=>"�y��-<br>�^�y","math"=>"�ƾ�","nature"=>"�۵M�P<br>�ͬ����","social"=>"���|","health"=>"���d�P<br>��|","art"=>"���N�P<br>�H��","complex"=>"��X����");
		$smarty->assign('sn',$student_sn);
		$smarty->assign('semes',$semes);
		
		$smarty->assign('cid',$cid);
		$smarty->assign('ss_link',$ss_link);
		$smarty->assign('link_ss',$link_ss);
		$smarty->assign('s_num',$section_num);
		$smarty->assign('seme_num',count($student_data->seme_ary));
		$smarty->assign('nor_score',$student_data->nor_score);		//�Ҧ���`�ͬ���{���Z
		$template_file="prn_all_score2.tpl";
	} else
		$template_file="prn_all_score.tpl";
	$smarty->display($template_dir.$template_file);
	unset($student_data);
}
//$smarty->display($template_dir."prn_foot.tpl");


function ch_nor($data,$all_Sco){
	global $IS_JHORES;
	foreach ($data as $key => $ary){
		$tmp=split("_",$ary[class_id]);
		$tmp2=$tmp[0]-($tmp[2]-$IS_JHORES);
		if ($tmp2>=94){
			$ary[scope_score]["��`�ͬ���{"][item_detail][nor][score]="--"; 
			$ary[scope_score]["��`�ͬ���{"][item_detail][nor][level]="--";
			$ary[seme_score][nor][score]="--";
			$ary[seme_score][nor][level]="--";
			$all_Sco["��`�ͬ���{"][sub_arys]["��`�ͬ���{"][$key][score]="--";
			$all_Sco["��`�ͬ���{"][sub_arys]["��`�ͬ���{"][$key][level]="--";
			$data[$key]=$ary; 
		}

	}
	return $all_Sco;
}

?>