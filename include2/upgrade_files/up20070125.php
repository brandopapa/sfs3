<?php

//$Id: up20070125.php 5310 2009-01-10 07:57:56Z hami $

if(!$CONN){
        echo "go away !!";
        exit;
}

//�[�J�]�w�g�O��ƪ�
$sql="CREATE TABLE if not exists `week_setup` (
  year smallint(5) unsigned NOT NULL default '0',
  semester enum('1','2') NOT NULL default '1',
  week_no smallint(5) unsigned NOT NULL default '0',
  start_date date NOT NULL default '0000-00-00',
	PRIMARY KEY (year,semester,week_no)
)";

$res=$CONN->Execute($sql);
?>
