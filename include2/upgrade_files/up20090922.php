<?php

//$Id: up20090922.php 5652 2009-09-21 15:29:06Z brucelyc $

if(!$CONN){
        echo "go away !!";
        exit;
}

$query="alter table `login_log_new` add `ip` varchar(15) NOT NULL default ''";
mysql_query($query);
?>
