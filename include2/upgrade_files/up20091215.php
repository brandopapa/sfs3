<?php

//$Id: up20091215.php 5792 2009-12-15 08:33:04Z brucelyc $

if(!$CONN){
        echo "go away !!";
        exit;
}

$query="alter table stud_base change addr_zip addr_zip varchar(5)";
mysql_query($query);
?>
