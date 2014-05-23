<?php

// $Id: list_teach_sum.php 5671 2009-09-25 06:18:03Z infodaes $

/* ���o�򥻳]�w�� */
include "config.php";
include "../../include/sfs_case_dataarray.php";

sfs_check();

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

$year_seme=$_GET['year_seme'];

//�Y����ܾǦ~�Ǵ��A�i����Ψ��o�Ǧ~�ξǴ�
if(!empty($year_seme)){
	$ys=explode("-",$year_seme);
	$sel_year=$ys[0];
	$sel_seme=$ys[1];
}

if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�


$filename=$sel_year."�Ǧ~�ײ�".$sel_seme."�Ǵ��Юv�t���`��.csv";
header("Content-disposition: attachment;filename=$filename");
header("Content-type: text/x-csv ; Charset=Big5");
//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");

header("Expires: 0");


//�I���Юv�m�W�ѷ�
$teacher_name=teacher_array();

// ���X�Z�ŦW�ٰ}�C
$class_name= class_base($year_seme);

//�I���Ҫ�W��
$sql= "select a.ss_id,a.link_ss,b.subject_name from score_ss a left join score_subject b on a.subject_id=b.subject_id where a.enable=1 and a.year=$sel_year and a.semester=$sel_seme";
$res=$CONN->Execute($sql) or trigger_error("���~�T���G $sql", E_USER_ERROR);
$subject_array=array();
while(!$res->EOF) {
	$ss_id=$res->fields['ss_id'];
	$subject_array[$ss_id]=$res->fields['subject_name']?$res->fields['subject_name']:$res->fields['link_ss'];
	$res->MoveNext();
}


//����̤j�P����ƻP�̤j�`��
$sql="select max(day) as day,max(sector) as sector from score_course where year=$sel_year and semester=$sel_seme";
$res=$CONN->Execute($sql) or trigger_error("���~�T���G $sql", E_USER_ERROR);
$max_day=$res->fields['day'];
$max_sector=$res->fields['sector'];

//�����w�Ǵ����Ҫ���
$sql="select course_id,teacher_sn,day,sector,ss_id,room,class_id,c_kind
	      from score_course where teacher_sn=teacher_sn
          and year='$sel_year' and semester='$sel_seme' order by teacher_sn,day,sector";
$res=$CONN->Execute($sql) or trigger_error("���~�T���G $sql", E_USER_ERROR);
$course_data=array();	  
while(!$res->EOF) {
	$teacher_sn=$res->fields['teacher_sn'];
	$day=$res->fields['day'];
	$sector=$res->fields['sector'];
	$class_data=explode('_',substr($res->fields['class_id'],-5));
	$course_data[$teacher_sn][$day][$sector]['ss_id']=$subject_array[$res->fields['ss_id']];
	$course_data[$teacher_sn][$day][$sector]['room']=$res->fields['room'];
	$course_data[$teacher_sn][$day][$sector]['c_kind']=$res->fields['c_kind']?'��':'';
	$course_data[$teacher_sn][$day][$sector]['ss_id']=$course_data[$teacher_sn][$day][$sector]['c_kind'].$course_data[$teacher_sn][$day][$sector]['ss_id'];
	$course_data[$teacher_sn][$day][$sector]['class_name']=$class_name[sprintf('%d%02d',$class_data[0],$class_data[1])];
	$res->MoveNext();
}

//��Ƥw�g�ǳƦn  �i�w�}�l��X�F
$dow_array=array('1'=>'�@','2'=>'�G','3'=>'�T','4'=>'�|','5'=>'��','6'=>'��','7'=>'��');

$title1=",";
$title2="�m�W,";
for($i=1;$i<=$max_day;$i++) {	
	$title1.='�P��'.$dow_array[$i].',';
	for($j=1;$j<=$max_sector;$j++) {
		$title1.=',';
		$title2.=$i.'_'.$j.',';
	}
	$title1=substr($title1,0,-1);
}
echo substr($title1,0,-1)."\n";
echo substr($title2,0,-1)."\n";

foreach($course_data as $teacher_sn=>$data) {
	$teacher_data=$teacher_name[$teacher_sn].',';
	for($i=1;$i<=$max_day;$i++) {
		for($j=1;$j<=$max_sector;$j++) {
			$ss_id=$data[$i][$j]['ss_id'];
			$room=$data[$i][$j]['room'];
			$class_name=$data[$i][$j]['class_name'];
			$teacher_data.=$ss_id?"$ss_id($class_name)$room,":',';
		}
	}
	echo substr($teacher_data,0,-1)."\n";	
}

?>
