<?php

//$Id: up20040901.php 5310 2009-01-10 07:57:56Z hami $

if(!$CONN){
        echo "go away !!";
        exit;
}

//�bscore_course���W�[c_kind���, �O���Ӹ`�O0:���`�ɼ�, 1:�ݽ�, 2:�N��
$query="ALTER TABLE `score_course` ADD `c_kind` TINYINT(2) UNSIGNED NOT NULL default '0'";
$res=$CONN->Execute($query);
?>