<?php
// $Id: teacher_checkid.php 6807 2012-06-22 08:08:30Z smallduh $

// --�t�γ]�w��
include "exam_config.php";
// --�{�� session
//session_start();
//session_register("session_log_id");
$exename = strip_tags($_GET['exename']);
$exename = htmlentities($exename);
if(!checkid(substr($exename,1))){
        $go_back=1; //�^��ۤw���{�ҵe��  
        include "header.php";
        include "$rlogin";
        include "footer.php";
        exit;
}
else {
        $exam = "http://".$_SERVER[HTTP_HOST].$exename;
        header("Location: $exam");
}
?>
