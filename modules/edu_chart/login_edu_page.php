<?php
//$Id: login_edu_page.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";

//�{��
sfs_check();

//if ($_POST[chart_no]=="") $_POST[chart_no]=2;
if ($_POST[chart_no]!="") {
	if (file_exists($temp_path."url.txt")) {
		$fp=fopen($temp_path."url.txt","r");
		$i=1;
		while(!feof($fp)) {
			$urls[$i]=fgets($fp,1024);
			$i++;
		}
	}
	$smarty->assign("replace_url",trim($urls[$_POST[chart_no]]));
}

//��O���
$sel1 = new drop_select();
$sel1->s_name="chart_no";
$sel1->id= $_POST[chart_no];
$sel1->arr = array("2"=>"��G: �ǥͦ~�֧O","3"=>"��T: �Z�ż�","4"=>"��|: �ǥͻr�����O","5"=>"��: �����ǥͲέp","6"=>"��: ���Ͳέp");
$sel1->has_empty = true;
$sel1->is_submit = true;
$smarty->assign("chart_sel",$sel1->get_select());

$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("SFS_PATH_HTML",$SFS_PATH_HTML);
$smarty->assign("module_name","�y�w�����ȳ���z��������@�~�n�J");
$smarty->display("edu_chart_login_edu_page.tpl");
?>
