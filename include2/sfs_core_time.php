<?php

// $Id: sfs_core_time.php 5310 2009-01-10 07:57:56Z hami $

//�ɶ��]�w�Ψ��
function set_now_niceDate() {
  global $zone, $now, $niceDate;
  if(empty($zone))$zone=0;
  $now = date("Y-m-j H:i:s");
  $niceDate = date("D, M j Y,h:ia") . $zone; 
}


//�p��ɶ�  
function get_page_time() {
	global $SFS_BIGIN_TIME;
	$beg = explode (" ", $SFS_BIGIN_TIME);
	$end = explode (" ",microtime());
	return ($end[1] - $beg[1])+($end[0] - $beg[0]);
}


?>