<?php
//$Id:  $
include "config.php";
include "../../include/sfs_case_score.php";

//�{��
sfs_check();

//$percision=$_POST['percision'];
$year_name=$_POST[year_name];

if($year_name>2){
	$ss_link=array("�y��-����y��"=>"chinese","�y��-�m�g�y��"=>"local","�y��-�^�y"=>"english","�ƾ�"=>"math","�۵M�P�ͬ����"=>"nature","���|"=>"social","���d�P��|"=>"health","���N�P�H��"=>"art","��X����"=>"complex");
	$link_ss=array("chinese"=>"�y��-����y��","local"=>"�y��-�m�g�y��","english"=>"�y��-�^�y","math"=>"�ƾ�","nature"=>"�۵M�P�ͬ����","social"=>"���|","health"=>"���d�P��|","art"=>"���N�P�H��","complex"=>"��X����");
	$area_rowspan=9;
} else {
	$ss_link=array("�y��-����y��"=>"chinese","�y��-�m�g�y��"=>"local","�y��-�^�y"=>"english","�ƾ�"=>"math","���d�P��|"=>"health","�ͬ�"=>"life","��X����"=>"complex");
	$link_ss=array("chinese"=>"�y��-����y��","local"=>"�y��-�m�g�y��","english"=>"�y��-�^�y","math"=>"�ƾ�","health"=>"���d�P��|","life"=>"�ͬ�","complex"=>"��X����");
	$area_rowspan=7;
}

if (empty($_POST[year_seme])) {
	$sel_year = curr_year(); //�ثe�Ǧ~
	$sel_seme = curr_seme(); //�ثe�Ǵ�
	$year_seme=$sel_year."_".$sel_seme;
} else {
	$ys=explode("_",$_POST[year_seme]);
	$sel_year=$ys[0];
	$sel_seme=$ys[1];
}
/*
if($year_name){
	$percision_radio="<font size=2 color='red'> �����Z��ܪ���סG";
	$percision_array=array('1'=>'���','2'=>'�p��1��','3'=>'�p��2��');
	foreach($percision_array as $key=>$value){
		if($percision==$key) $checked='checked'; else $checked='';
		$percision_radio.="<input type='radio' value='$key' name='percision' $checked onclick='this.form.submit();'>$value";	
	}
}
*/

if($year_name) {
	$percision--;
	$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
	//����Z�ų]�w�̪��Z�ŦW��
	$class_base= class_base($seme_year_seme);
	$seme_class=$year_name.sprintf("%02d",$_POST[me]);
	$query="select a.*,b.stud_name,b.stud_person_id from stud_seme a left join stud_base b on a.student_sn=b.student_sn where a.seme_year_seme='$seme_year_seme' and a.seme_class like '$year_name%' and b.stud_study_cond in ('0','15') order by a.seme_class,a.seme_num";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		$student_sn=$res->fields['student_sn'];
		$sn[]=$student_sn;
		$student_data[$student_sn]['seme_num']=$res->fields['seme_num'];
		$student_data[$student_sn]['stud_person_id']=$res->fields['stud_person_id'];
		$student_data[$student_sn]['stud_name']=$res->fields['stud_name'];
		$student_data[$student_sn]['stud_id']=$res->fields['stud_id'];
		$seme_class=$res->fields['seme_class'];
		$student_data[$student_sn]['class_name']=$class_base[$seme_class];

		$res->MoveNext();
	}
	$semes[]=sprintf("%03d",$sel_year).$sel_seme;
	$show_year[]=$sel_year;
	$show_seme[]=$sel_seme;
	//�����즨�Z
	$fin_score=cal_fin_score($sn,$semes,"",array($sel_year,$sel_seme,$year_name),$percision);

	//�����`�ͬ���{�O��
	foreach($sn as $key=>$value){
		$sql="select * from stud_seme_score_nor where seme_year_seme='$seme_year_seme' and student_sn=$value";
		$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
		while(!$res->EOF) {
			$student_sn=$res->fields['student_sn'];
			$ss_id=$res->fields['ss_id'];
			$student_data[$student_sn]['nor'][$ss_id]=$res->fields['ss_score_memo'];
			$res->MoveNext();
		}
	}

	/* �o�O���ħP�w
	$sm=&get_all_setup("",$sel_year,$sel_seme,$year_name);
	$rule=explode("\n",$sm[rule]);
	while(list($s,$v)=each($fin_score)) {
		$fin_score[$s][avg][str]=score2str($fin_score[$s][avg][score],"",$rule);
	}
	*/
}
//$fin_score.$sn.avg.score
if($_POST['print_csv']){
	$filename=$seme_year_seme.'_'.$school_id.$school_long_name.$year_name."�~�žǴ���쥭��.csv";
	$csv_data="�Z��,�y��,�Ǹ�,�����Ҧr��,�m�W,��쥭��\r\n";
	foreach($student_data as $student_sn=>$data) $csv_data.="{$data['class_name']},{$data['seme_num']},{$data['stud_id']},{$data['stud_person_id']},{$data['stud_name']},{$fin_score[$student_sn][avg][score]}\r\n";
	header("Content-disposition: attachment; filename=$filename");
	header("Content-type: text/x-csv");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");
	echo $csv_data;
	exit;
}


$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE); 
$smarty->assign("SFS_MENU",$menu_p); 
$smarty->assign("module_name","�ǲ߻��Ǵ����Z�`��"); 
$smarty->assign("year_seme_menu",year_seme_menu($sel_year,$sel_seme,"this.form.target='';")); 
$smarty->assign("class_year_menu",class_year_menu($sel_year,$sel_seme,$year_name,"this.form.target='';")); 
$smarty->assign("show_year",$show_year);
$smarty->assign("show_seme",$show_seme);
$smarty->assign("semes",$semes);
$smarty->assign("curr_seme",$semes[0]);
$smarty->assign("fin_score",$fin_score);
$smarty->assign("student_data_nor",$student_data_nor);
$smarty->assign("ss_link",$ss_link);
$smarty->assign("link_ss",$link_ss);
$smarty->assign("rule",$rule_all);
$smarty->assign("year_name",$year_name);
$smarty->assign("percision_radio",$percision_radio);
$smarty->assign("student_data",$student_data);
$smarty->assign("m_arr",$m_arr);
$smarty->assign("school_long_name",$school_long_name);

if ($_POST['print_all']) {
	$smarty->display("score_report_scope_print.tpl");
} else {
	$smarty->display("score_report_scope.tpl");
}
?>
