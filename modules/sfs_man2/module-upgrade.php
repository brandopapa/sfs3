<?php
// $Id: module-upgrade.php 5310 2009-01-10 07:57:56Z hami $

if(!$CONN){
        echo "go away !!";
        exit;
}

// �ˬd�����P�s�խ��� 

// �ˬd��s�_
// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");
$up_file_name =$upgrade_str."2003-10-16.txt";

if (!is_file($up_file_name)){
	$query = " select msn from sfs_module where msn=of_group and  kind='����'";
	$res = $CONN->Execute($query);
	while(!$res->EOF){
		$msn = $res->fields[msn];
		if ($msn==16 or $msn==17) //�оǲ� ���U�� �k��а�
			$CONN->Execute("update sfs_module set of_group=12 where msn=$msn");
		else
			$CONN->Execute("update sfs_module set of_group=0 where msn=$msn");
		$res->MoveNext();
	}
	
	$temp_query = "�����{�����~�ץ� -- by hami (2003-10-15)\n";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);

}

/**
* ��� �ܼƻ�������
*/

$up_file_name =$upgrade_str."2006-2-10.txt";

if (!is_file($up_file_name)){
	$query = "ALTER TABLE `pro_module` CHANGE `pm_memo` `pm_memo` VARCHAR( 200 ) NOT NULL ";
	$res = $CONN->Execute($query);
	
	$temp_query = "��� �ܼƻ�������-- by hami (2006-2-10)\n";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fd);

}


?>
