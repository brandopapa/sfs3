<?php
//$Id:$
include "config.php";

//�{��
sfs_check();

$temp_file=$temp_path."/cdc";

//Ū�]�w
if (is_file($temp_file) && empty($_POST['cdc'])) {
	$fp=fopen($temp_file,"r");
	while(!feof($fp)) {
		$temp_str=fgets($fp,50);
	}
	if (trim($temp_str)=="ON") $_POST['cdc']="ON";
	fclose($fp);
	unlink($temp_file);
}

//���ը禡
$cdc_arr['fn']=(function_exists('openssl_pkey_get_public')?1:0);
//���յ{��
$temp_str=shell_exec('openssl verify -CAfile '.$SFS_PATH.'/GRCA.crt '.$SFS_PATH.'/MOICA.crt');
$temp_str=trim($temp_str);
$cdc_arr['pg']=(substr($temp_str,-2)=="OK")?1:0;


//�g�]�w
$fp=fopen($temp_file,"w");
fputs($fp,$_POST['cdc']);
fclose($fp);

$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("module_name","�۵M�H���ҵn�J�]�w");
$smarty->assign("SFS_MENU",$school_menu_p);
$smarty->assign("cdc_arr",$cdc_arr);
$smarty->display("system_cdc_setup.tpl");
?>
