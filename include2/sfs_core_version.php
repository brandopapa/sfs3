<?php

// $Id: sfs_core_version.php 5310 2009-01-10 07:57:56Z hami $

// ��������

	$SFS_VERSION = "3.0";
	$SFS_DATE = "2002-10-1";

// SFS patch ���A
//	$SFS_PATCH_LEVEL �w�q�b sfs-release.php ��

	if (file_exists("$SFS_PATH/sfs-release.php")) 
			 include_once "$SFS_PATH/sfs-release.php";

// �Ȯɩ� TEMPLATE �ؿ�

	$SFS_TEMPLATE = $SFS_PATH . "/templates/new";
?>
