<?php
/*
* $Id: list.php 7752 2013-11-08 10:31:02Z hami $
* �����ϥΪ�
*/

// ���J�t�γ]�w��
require_once "config.php";

// �����{��
sfs_check();

// ���J����{��
require_once "simu_class.php";

// �إߪ���
$obj = new simu_class();

// ����{�ǳB�z
$obj->process();


?>
