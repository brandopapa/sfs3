<?php
// $Id: module-upgrade.php 5310 2009-01-10 07:57:56Z hami $
if(!$CONN){
        echo "go away !!";
        exit;
}

// �ˬd��s�_
// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");
$up_file_name =$upgrade_str."2008-05-17.txt";

//���ܻ�����쬰text���A
if (!is_file($up_file_name)){
	
	$SQL = "ALTER TABLE `actiontb` CHANGE `act_info` `act_info` TEXT NOT NULL ";
	$rs=$CONN->Execute($SQL);
	if ($rs) {$temp_query = "���� actiontb  ������쬰text���A by hami (2007-03-21)\n $SQL";}
	else {$temp_query = "���ܤW���ɮ׬�text���A actiontb  ���� !!,�Ф�ʧ�s�U�C�y�k\n $SQL";}

	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query.$str);
	fclose ($fp);
	unset($temp_query);unset($str);
}

?>