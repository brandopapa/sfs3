<?php

// $Id: config.php 7035 2012-12-06 01:15:12Z smallduh $

//�t�γ]�w��
include_once "../../include/config.php";

//�禡�w
include_once "../../include/sfs_case_PLlib.php";
include_once "../../include/sfs_case_dataarray.php";
include_once "../../include/sfs_case_studclass.php";
require_once "./module-cfg.php";
include_once "my_fun.php";
include "module-upgrade.php";


// �ǥͦ۫ظ��
$m_arr = get_sfs_module_set("stud_eduh_self");
extract($m_arr, EXTR_OVERWRITE);

//���o�Ҳճ]�w
$m_arr = get_sfs_module_set("12basic_career");
extract($m_arr, EXTR_OVERWRITE);

//�L�oPOST��
foreach($_POST as $k=>$v) {
	if (!is_array($v)) {
		//���F�n�ѨM��޸����N��B�ͪ����D
		$v=str_replace("'", "@$@", $v);
		//�L�o--
		$_POST[$k]=str_replace(array("\\@$@","@$@","--"),array("","",""),$v);
	}
}

//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();
$curr_year_seme=sprintf('%03d%d',$curr_year,$curr_seme);
$class_array=class_base();


$c_id=$_REQUEST['class_id'];
$student_sn=$_REQUEST['student_sn'];
$seme_year_seme=$curr_year_seme;

$min=$IS_JHORES?7:4;
$max=$IS_JHORES?9:6;

$linkstr = "class_id=$c_id&student_sn=$student_sn";


//������ɯZ�Ų��Ϳ��
$class_select="<select name='class_id' onchange='this.form.target=\"$class_id\"; this.form.submit()'><option value='' selected>-�п�ܯZ��-</option>";
$query="select * from `score_eduh_teacher2` where year_seme='$curr_year_seme' and teacher_sn=".$_SESSION['session_tea_sn'];
$res=$CONN->Execute($query) or die("SQL���~�G<br>$query");
while(!$res->EOF){
	$data=explode('_',$res->fields['class_id']);
	$class_id=sprintf('%d%02d',$data[2],$data[3]);
	$selected=($c_id==$class_id)?'selected':'';
	$class_select.="<option value='$class_id' $selected>{$class_array[$class_id]}</option>";
	$res->MoveNext();
}
$class_select.="</select>";

if($c_id){
	//���;ǥͦW��
	$query="select a.student_sn,a.seme_num,b.stud_name,b.stud_sex from `stud_seme` a inner join stud_base b on a.student_sn=b.student_sn where seme_year_seme='$curr_year_seme' and seme_class='{$c_id}' order by a.seme_num";
	$res=$CONN->Execute($query) or die("SQL���~�G<br>$query");
	$size=$res->RecordCount()+1;
	while(!$res->EOF){
		$checked=($student_sn==$res->fields['student_sn'])?'checked':'';
		$color=($res->fields['stud_sex']==1)?'#0000ff':'#ff0000';
		$color=($student_sn==$res->fields['student_sn'])?'#00ff00':$color;
		$student_select.="<input type='radio' name='student_sn' onclick='this.form.submit()' value='{$res->fields['student_sn']}' $checked><font color='$color'>({$res->fields['seme_num']}) {$res->fields['stud_name']}</font><br>";
		$res->MoveNext();
	}
	$student_select.="</select>";
}

$level_array=array(1=>'���',2=>'����B�O�W��',3=>'�ϰ�ʡ]�󿤥��^',4=>'�١B���ҥ�',5=>'�����ϡ]�m��^',6=>'�դ�');
$squad_array=array(1=>'�ӤH��',2=>'������');

?>
