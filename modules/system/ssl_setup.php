<?php
//$Id:$
include "config.php";

//�{��
sfs_check();

$temp_file=$temp_path."/ssl_setup";

//Ū�]�w
if ($_POST[ssl]<>"0" && is_file($temp_file)) {
	$fp=fopen($temp_file,"r");
	$k=fgets($fp,1024);
	$k_arr=explode("HTTPS=",$k);
	if(count($k_arr)==2) {
		$HTTPS_NAME=trim($k_arr[1]);
	}
	if ($HTTPS_NAME=="") $_POST[ssl]=0;
	else {
		$_POST[ssl]=1;
		if ($_POST[https_name]=="") $_POST[https_name]=$HTTPS_NAME;
	}
	fclose($fp);
	unlink($temp_file);
}

//�g�]�w
if ($_POST[ssl] && $_POST[https_name]) {
	$fp=fopen($temp_file,"w");
	fputs($fp,"HTTPS=".$_POST[https_name]);
	fclose($fp);
} else $_POST[ssl]=0;

if ($_POST[ssl]==0) {
	$_POST[https_name]="";
	unlink($temp_file);
}

$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("module_name","�t��HTTPS�ҥγ]�w");
$smarty->assign("SFS_MENU",$school_menu_p);
$smarty->assign("HTTPS_NAME",$_POST[https_name]);
$smarty->display("system_ssl_setup.tpl");
?>
