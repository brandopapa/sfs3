<?php

//$Id:$

if(!$CONN){
        echo "go away !!";
        exit;
}
	//�W�[�ǥͳX�ͰO����student_sn�Bteacher_sn�Binterview���
	$SQL="ALTER TABLE `stud_seme_talk` ADD `interview` VARCHAR( 20 ) NULL AFTER `teach_id`";
	$rs=$CONN->Execute($SQL);
	
	//���o�ЮvID�PSN�Bname���
	$teacher_array=teacher_base();
	
	//�Ninterview �����ƸɤW
	$SQL="SELECT DISTINCT teach_id FROM `stud_seme_talk`";
	$res=$CONN->Execute($SQL);
	while(!$res->EOF) {
		$teach_id=$res->fields[teach_id];
		$interview=$teacher_array[$teach_id];

		$update_sql="UPDATE `stud_seme_talk` SET interview='$interview' WHERE teach_id=$teach_id";
		$CONN->Execute($update_sql);
		$res->MoveNext();
	}
?>