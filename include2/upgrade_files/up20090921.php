<?php

//$Id: up20090921.php 5649 2009-09-20 17:08:17Z brucelyc $

if(!$CONN){
        echo "go away !!";
        exit;
}

$query="CREATE TABLE if not exists login_log_new (
	   `teacher_sn` smallint(6) unsigned NOT NULL default 0,
	   `who` varchar(10) NOT NULL default '',
	   `no` smallint(4) unsigned NOT NULL default 0,
	   `login_time` datetime NOT NULL default '0000-00-00 00:00:00',
	   PRIMARY KEY(teacher_sn,who,no))";
mysql_query($query);
?>
