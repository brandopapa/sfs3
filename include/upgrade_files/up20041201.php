<?php

//$Id: up20041201.php 5310 2009-01-10 07:57:56Z hami $

if(!$CONN){
        echo "go away !!";
        exit;
}

//�ץ��M��ЫǷs�W����`���楼�إߪ����~
$query="ALTER TABLE `spec_classroom` ADD `notfree_time` VARCHAR(250)";
$CONN->Execute($query);
?>