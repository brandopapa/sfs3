<?php

// $Id: sfs_text_config.php 6572 2011-10-07 16:29:49Z infodaes $

//���J�t�γ]�w��
include "../../include/config.php";
include "../../include/sfs_case_PLlib.php";
include "module-upgrade.php";

$postBtn = "�s�W�T�w";
$editBtn = "�ק�T�w";
//�W�h���
$menu_p = array("st1.php"=>"�ǥͿﶵ","st3.php"=>"���Z�ﶵ","st4.php"=>"�{���Ҳտﶵ","st5.php"=>"���ɦ��Z���ذѷ�");

//get parent name
function get_text_parent_name ($t_parent) {
	global $p;
	$res="";
	$temp = explode (",",$t_parent);
	foreach ($temp as $val) {
		if($val){
			$query = "select t_id,t_name from sfs_text where t_id='$val' ";
			$result = mysql_query($query);		
			$row = mysql_fetch_row($result);				
			$res .="<a href={$_SERVER['PHP_SELF']}?this_item=$row[0]&p=$p>$row[1]</a> > ";
		}
	}
	return $res;
}

function delete_item($t_id) {
	$query = "select t_id from sfs_text where p_id='$t_id' ";
	$result = mysql_query($query);
	while($row = mysql_fetch_row($result))
		delete_item ($row[0]);
	mysql_query("delete from sfs_text where t_id='$t_id'");
}
?>
