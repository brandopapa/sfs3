<?php
//$Id: update.php 6994 2012-11-02 07:51:35Z smallduh $
include "config.php";

//�{��
sfs_check();

$temp_file=$temp_path."/update";
if (count($_POST['tem'])>0) {
	foreach($_POST['tem'] as $k => $v) {
	$_POST['uptemp']=$k;
	}	
}

//Ū�]�w
$d=array();
if (is_file($temp_file)) {
	$fp=fopen($temp_file,"r");
	while(!feof($fp)) {
		$dd=explode("=",fgets($fp,50));
		if (count($dd)==2) $d[$dd[0]]=substr($dd[1],0,2);
	}
	if (empty($_POST['upsch'])) $_POST['upsch']=$d['SCHEDULE'];
	if (empty($_POST['uptemp'])) $_POST['uptemp']=$d['TEMPORARY'];
	unlink($temp_file);
	fclose($fp);
} else {
	$_POST['upsch']="04";
}
if (file_exists($temp_path."/cron")) {
	$fp=fopen($temp_path."/cron","r");
	$smarty->assign("crontime",fgets($fp,1024));
	fclose($fp);
}

//�g�]�w
$fp=fopen($temp_file,"w");
fputs($fp,"SCHEDULE=".$_POST['upsch']."\n");
if ($_POST['uptemp']) fputs($fp,"TEMPORARY=".sprintf("%02d",$_POST['uptemp'])."\n");
fclose($fp);

for($i=0;$i<12;$i++) $temp_arr[]=sprintf("%02d",$i);
$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("module_name","��s�ɶ��]�w");
$smarty->assign("SFS_MENU",$school_menu_p);
$smarty->assign("rowdata",$temp_arr);
$smarty->display("system_update.tpl");
?>
