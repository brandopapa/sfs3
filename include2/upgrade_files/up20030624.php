<?php

//$Id: up20030624.php 5310 2009-01-10 07:57:56Z hami $

if(!$CONN){
        echo "go away !!";
        exit;
}
//�[�J���
$query = "ALTER TABLE `stud_seme` ADD `student_sn` INT UNSIGNED NOT NULL";
$res = $CONN->Execute($query);
//if ($res) {
	//�N student_sn �[�J stud_seme ��
	$query = "select stud_id,student_sn from stud_base ";
	$res = $CONN->Execute($query);
	while(!$res->EOF){
		$query = "update stud_seme set student_sn='".$res->fields[1]."' where stud_id='".$res->fields[0]."'";
		$CONN->Execute($query);
		$res->MoveNext();
	}
//}

?>
