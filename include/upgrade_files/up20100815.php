<?php

//$Id: up20100815.php 6099 2010-09-07 07:03:19Z infodaes $

if(!$CONN){
        echo "go away !!";
        exit;
}

//�p�G stud_domicile ���S�� student_sn ��쪺�ܫh�[�J�����
$query="show columns from stud_domicile where Field='student_sn'";
$res=$CONN->Execute($query);
if ($res->RecordCount()==0) {
	$query="ALTER TABLE `stud_domicile` add `student_sn` INT(10) unsigned not NULL default '0'";
	$CONN->Execute($query);
}

//��X student_sn=0 ���Ҧ��Ǹ�
$query="select * from stud_domicile where student_sn='0'";
$res=$CONN->Execute($query);
$temp_arr=array();
while(!$res->EOF) {
	if ($res->fields['stud_id']>0) $temp_arr[]=$res->fields['stud_id'];
	$res->MoveNext();
}

//�p�G�� student_sn=0 ������, �h��s student_sn
if (count($temp_arr)>0) {
	$stud_str="'".implode("','",$temp_arr)."'";
	$query="select * from stud_base where stud_id in ($stud_str) order by stud_study_year";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		$student_sn=$res->fields['student_sn'];
		$stud_id=$res->fields['stud_id'];
		if ($student_sn>0) $CONN->Execute("update stud_domicile set student_sn='$student_sn' where student_sn='0' and stud_id='$stud_id'");
		$res->MoveNext();
	}
	//���F�� student_sn ���ܬ� primary key, �ҥH�R�� student_sn=0 ���Ҧ�����
	$CONN->Execute("delete from stud_domicile where student_sn=0");
	//�� primary key �令 student_sn
	$CONN->Execute("ALTER TABLE `stud_domicile` DROP PRIMARY KEY,ADD PRIMARY KEY (`student_sn`)");
}

$temp_arr=array();
?>
