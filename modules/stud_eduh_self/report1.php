<?php

// $Id: report1.php qfon $

/* ���o�]�w�� */

include "config.php";

// �{���ˬd
sfs_check();

// ���O�d�d��
switch ($ha_checkary){
        case 2:
                ha_check();
                break;
        case 1:
                if (!check_home_ip()){
                        ha_check();
                }
                break;
}



//�L�X���Y
head("���m�Ҭd��");

//�u����Ǵ�
$seme_year_seme=sprintf("%03d",curr_year()).curr_seme();

$stud_id=$_SESSION['session_log_id'];


//���o�n�J�ǥͪ��Ǹ��M�y����
$query="select * from stud_seme where seme_year_seme='$seme_year_seme' and stud_id='".$stud_id."'";
$res=$CONN->Execute($query);
$student_sn=$res->fields['student_sn'];
if ($student_sn) {
	$query="select * from stud_base where student_sn='$student_sn'";
	$res=$CONN->Execute($query);
	if ($res->fields['stud_study_cond']!="0") {
		$student_sn="";
	} else {
		$stud_study_year=$res->fields['stud_study_year'];
	}
}



$main=&mainForm();

//�q�X����
head("���m�Ҭd��");

if($stud_view_self_absent)echo $main;
foot();

//�D�n��J�e��
function &mainForm(){
	global $CONN,$stud_id,$student_sn,$stud_study_year;

	$sql = "select year,semester,class_id,date,absent_kind,section from stud_absent where stud_id='$stud_id' and year>='$stud_study_year'";
	$rs=$CONN->Execute($sql) or trigger_error("SQL�y�k���~�G $sql", E_USER_ERROR);

		
    $main0.="<center>";
	$main0.="<table width=80% cellspacing='1' cellpadding='3' bgcolor='#C6D7F2'>";
	$main0.="<tr><td bgcolor='#C6D7F2'>�Ǧ~�׾Ǵ�</td><td bgcolor='#C6D7F2'>���</td><td bgcolor='#C6D7F2'>���m�Һ���</td><td bgcolor='#C6D7F2'>�~�ůZ��</td></tr>";

	while (!$rs->EOF) {
		$absent_kind=$rs->fields['absent_kind'];
		$class_id = $rs->fields['class_id'];
		$date = $rs->fields['date'];
		$section = $rs->fields['section'];
		
		
		if ($section=="allday")$sectionx="1��";
		else if ($section=="uf")$sectionx="�ɺX";
		else if ($section=="df")$sectionx="���X";
		else $sectionx="��".$section."�`";
		$cx=explode("_",$class_id);
		
		if ($cx[2]=="07" || $cx[2]=="01")$cx[2]="1";
		if ($cx[2]=="08" || $cx[2]=="02")$cx[2]="2";
		if ($cx[2]=="09" || $cx[2]=="03")$cx[2]="3";
		if ($cx[2]=="04")$cx[2]="4";
		if ($cx[2]=="05")$cx[2]="5";
		if ($cx[2]=="06")$cx[2]="6";
		
		$cx[3]=get_class_name($class_id);
		$colorz="white";
		if ($absent_kind=="�ư�")$colorz="#FEFED7";
		if ($absent_kind=="�f��")$colorz="#FEFEC4";
		if ($absent_kind=="�m��")$colorz="#FEFEB1";
		if ($absent_kind=="��L")$colorz="#FEFE8B";
		$main0.="<tr><td bgcolor='$colorz'>$cx[0]�Ǧ~�ײ� $cx[1] �Ǵ�</td><td bgcolor='$colorz'>$date</td><td bgcolor='$colorz'>$absent_kind $sectionx</td><td bgcolor='$colorz'>$cx[2]�~$cx[3]�Z</td></tr>";
		$rs->MoveNext();
		
		
	}
     $main0.="</table>";
	return $main0;
}

//���o�Z�ŦW��
function get_class_name($class_id){
	global $CONN;

	$sql_select = "select c_name from school_class where class_id='$class_id' and enable='1'";
	$recordSet=$CONN->Execute($sql_select)  or trigger_error($sql_select, E_USER_ERROR);
    while (!$recordSet->EOF) {
		$c_name=$recordSet->fields['c_name'];
		$recordSet->MoveNext();
	}
	return $c_name;
}



?>
