<?php

//$Id: up20050406.php 5310 2009-01-10 07:57:56Z hami $

if(!$CONN){
        echo "go away !!";
        exit;
}

//�ץ��վ�ﶵ��
$query="ALTER TABLE `pro_module` CHANGE `pm_value` `pm_value` TEXT";
$CONN->Execute($query);
?>