<?php
//$Id: bad_login.php 7712 2013-10-23 13:31:11Z smallduh $
include "config.php";

//�{��
sfs_check();

$temp_file=$temp_path."/bad_login_protect";
if ($_POST[clean]) {
	$CONN->Execute("delete from bad_login");
}

$query="select * from bad_login order by log_time desc,log_ip,log_id";
$res=$CONN->Execute($query);
$smarty->assign("rowdata",$res->GetRows());

if ($_POST[export]) {
	header("Content-type: application/csv; Charset=Big5");
	header("Content-Disposition: attachment; filename=bad_login.csv");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");
	$smarty->display("system_bad_login_csv.tpl");
	exit;
}

//Ū�]�w
if (is_file($temp_file)) {
	$fp=fopen($temp_file,"r");
	$k=fgets($fp,10);
	fclose($fp);
	unlink($temp_file);
	if ($_POST[lock]=="") $_POST[lock]=1;
}

if (intval($_POST[err_times])<1) {
	$_POST[err_times]=($k)?$k:3;
}

//�g�]�w
if ($_POST[lock]) {
	$fp=fopen($temp_file,"w");
	fputs($fp,$_POST[err_times]);
	fclose($fp);
}

$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("module_name","�n�J���ѰO��");
$smarty->assign("SFS_MENU",$school_menu_p);
$smarty->display("system_bad_login.tpl");
?>
