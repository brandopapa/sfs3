<?php
// $Id: function.php 5310 2009-01-10 07:57:56Z hami $
//�P�_�O�_���n���Ǯ�
function is_tnc_school(){
	$ip=explode(",",$_SERVER["SERVER_ADDR"]);
	if($ip[0]=="163" and $ip[1]=="26" and $ip[2]>=83 and $ip[2]<=206){
		return true;
	}
	return false;
}
?>
