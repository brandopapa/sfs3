<?php
//$Id$
//�w�]���ޤJ�ɡA���i�����C
require_once "./module-cfg.php";
include_once "../../include/config.php";
//�z�i�H�ۤv�[�J�ޤJ��

##################�^�W���禡1#####################
function backe($value= "BACK"){
	echo  "<head><meta http-equiv='Content-Type' content='text/html; charset=big5'></head><br><br><br><br><CENTER><form><input type=button value='".$value."' onclick=\"history.back()\" style='font-size:16pt;color:red;'></form><BR></CENTER>";
	exit;
}

include "my_fun.php";
