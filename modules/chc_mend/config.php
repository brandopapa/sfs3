<?php
//$Id$
//�w�]���ޤJ�ɡA���i�����C
require_once "./module-cfg.php";
include_once "../../include/config.php";
include_once "chi_fun.php";
//�z�i�H�ۤv�[�J�ޤJ��
function gVar($N){
	if (isset($_POST[$N])) return strip_tags(trim($_POST[$N]));
	if (isset($_GET[$N])) return strip_tags(trim($_GET[$N]));	
}
	


