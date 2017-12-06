<?php

if(!$CONN){
        echo "go away !!";
        exit;
}
$SQL="ALTER TABLE `seme_course_date` ADD `school_days` text NOT NULL;";
$rs=$CONN->Execute($SQL);
