<?php
//$Id: stud_list.php 7764 2013-11-14 08:07:31Z smallduh $
include "config.php";

//�{��
sfs_check();

//���o���կZ�Ű}�C
$class_array=class_base();

//���o�ɮv�m�W
$curr_year=curr_year();
$curr_seme=curr_seme();
$tutor=array();
$sql="select * from school_class where enable='1' and year=$curr_year and semester=$curr_seme";
$res=$CONN->Execute($sql) or user_error("Ū���Z�Ÿ�ƥ��ѡI<br>$sql",256);
while(!$res->EOF) {
	$class_id=sprintf('%d%02d',$res->fields['c_year'],$res->fields['c_sort']);
	$tutor[$class_id]=$res->fields['teacher_1'];	
	$res->MoveNext();
}

$sex_arr=array("1"=>"�k","2"=>"�k");

if($_POST[csv_out_all]) {
	$seme_year_seme=sprintf("%03d",curr_year()).curr_seme();
	$query="select a.*,b.stud_name,b.stud_sex from stud_seme a left join stud_base b on a.student_sn=b.student_sn where a.seme_year_seme='$seme_year_seme' and b.stud_study_cond in ('0','15') order by seme_class,seme_num";
	$res=$CONN->Execute($query);
	$smarty->assign("class_arr",$res->GetRows());
	$smarty->assign("class_array",$class_array);
	header("Content-disposition: filename=stud_list.csv");
	header("Content-type: application/octetstream ; Charset=Big5");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");
	$smarty->display("stud_list_stud_list_csv_all.tpl");
	exit;
}

if ($_POST[print_out] || $_POST[csv_out]) {
	$seme_year_seme=sprintf("%03d",curr_year()).curr_seme();
	$max_num=0;
	reset($_POST[c_id]);
	while(list($k,$v)=each($_POST[c_id])) {
		$query="select a.*,b.stud_name,b.stud_sex from stud_seme a left join stud_base b on a.student_sn=b.student_sn where a.seme_year_seme='$seme_year_seme' and a.seme_class='$v' and b.stud_study_cond in ('0','15') order by seme_num";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			$seme_num=$res->fields[seme_num];
			$data_arr[$k][$seme_num][stud_name]=$res->fields[stud_name];
			$data_arr[$k][$seme_num][stud_id]=$res->fields[stud_id];
			if ($_POST[sex]) $data_arr[$k][$seme_num][oth]=$sex_arr[$res->fields[stud_sex]];
			$res->MoveNext();
		}
		if ($max_num<intval($seme_num)) $max_num=intval($seme_num);
	}
}
$max_num=(ceil($max_num / 5)+1)*5;

$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("module_name","�ǥͦW��");
$smarty->assign("SFS_MENU",$menu_p);
$smarty->assign("class_arr",$class_array);
$smarty->assign("tutor",$tutor);
$smarty->assign("sex_enable",1);
if ($_POST[csv_out]) {
	header("Content-disposition: filename=stud_list.csv");
	header("Content-type: application/octetstream ; Charset=Big5");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");
}
if ($_POST[print_out] || $_POST[csv_out]) {
	$smarty->assign("sel_year",curr_year());
	$smarty->assign("sel_seme",curr_seme());
	$smarty->assign("max_num",$max_num);
	$smarty->assign("data_arr",$data_arr);
	$smarty->assign("oth_str",($_POST[sex])?"�ʧO":"�Ƶ�");
	if ($_POST[csv_out])
		$smarty->display("stud_list_stud_list_csv.tpl");
	else
		$smarty->display("stud_list_stud_list_print.tpl");
} else {
	$smarty->assign("sex_sel",1);
	$smarty->display("stud_list_stud_list.tpl");
}
?>
