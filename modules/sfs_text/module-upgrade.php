<?php
// $Id: module-upgrade.php 5310 2009-01-10 07:57:56Z hami $

if(!$CONN){
        echo "go away !!";
        exit;
}

// �N�w�]�����Z����y�����]���۰ʨ��o���y

// �ˬd��s�_
// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");
$up_file_name =$upgrade_str."2003-06-17.txt";

if (!is_file($up_file_name)){
	$query = "delete from sfs_text where t_kind='course9' or t_kind='subject_kind'";
	$CONN->Execute($query);
	$query2 = "update sfs_text set g_id=4 where t_kind='non_display'";
	if ($CONN->Execute($query2)) {
		$temp_query = "�R���ǲ߻��ά�ئW��(�w�b�s���Z�t�Τ��]�w),��藍��ܥؿ���{���Ҳտﶵ -- by hami (2003-06-17)\n$query \n$query2";
		$fp = fopen ($up_file_name, "w");
		fwrite($fp,$temp_query);
		fclose ($fd);
	}
}

?>
