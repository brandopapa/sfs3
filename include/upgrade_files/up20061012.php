<?php

//$Id: up20061012.php 5310 2009-01-10 07:57:56Z hami $

if(!$CONN){
        echo "go away !!";
        exit;
}

//�bstud_move���s�W��X�J�������
$query = "ALTER TABLE `stud_move` ADD `city` VARCHAR(10) NOT NULL default '';";
$CONN->Execute($query);
$query="select * from stud_move";
$res=$CONN->Execute($query);
while(!$res->EOF) {
	$school=$res->fields[school];
	if ($school!="") {
		$s=array();
		$s=explode("��",$school);
		if (count($s)==1) {
			$s=explode("��",$school);
		}
		$city=$s[0];
		$school=$s[1];
		$CONN->Execute("update stud_move set city='$city',school='$school' where move_id='".$res->fields[move_id]."'");
	}
	$res->MoveNext();
}
?>
