<?php

// $Id: log.php 6805 2012-06-22 08:00:32Z smallduh $

//���J�]�w��
include "docword_config.php";
// session �{��

//session_register("session_log_id");
//session_register("session_tea_name");
if ($sel == "out") {//�n�X
	$session_log_id="";
	$session_tea_name="";
}
else if ($sel == "in") { //�n�J
	if(!checkid($PHP_SELF)){
		$go_back=1; //�^��ۤw���{�ҵe��
		include "header.php";
		include $SFS_PATH."/rlogin.php";
		include "footer.php";
		exit;
	}
}
header ("Location: index.php");
?>
