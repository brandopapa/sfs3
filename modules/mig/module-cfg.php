<?php
                                                                                                                             
// $Id: module-cfg.php 5310 2009-01-10 07:57:56Z hami $

// ��ƪ�W�٩w�q
$MODULE_NAME ="mig";

$MODULE_TABLE_NAME[0] = "";

$MODULE_PRO_KIND_NAME = "�Ʀ�ۥ�";

// �Ҳժ���
$MODULE_UPDATE_VER="2.0.1";

// �Ҳճ̫��s���
$MODULE_UPDATE="2003-03-19 08:30:00";



$SFS_MODULE_SETUP[] =
	array('var'=>"P_TITLE", 'msg'=>"�{�����D", 'value'=>"�Ʀ�ۥ�");

$SFS_MODULE_SETUP[] =
	array('var'=>"is_standalone", 'msg'=>"�_���W�ߪ��ɭ�(1�O,0�_)", 'value'=>0);

$SFS_MODULE_SETUP[] =
	array('var'=>"convert_path", 'msg'=>"���Y�{�����|(�Q�� whereis convert ���O�d��)", 'value'=>"/usr/bin/X11/");

$SFS_MODULE_SETUP[] =
	array('var'=>"indexImgWidth", 'msg'=>"�޹ϼe��(pix)", 'value'=>96);

$SFS_MODULE_SETUP[] =
	array('var'=>"ImgWidth", 'msg'=>"���޹ϼe��(pix)", 'value'=>500);

$SFS_MODULE_SETUP[] =
	array('var'=>"maxColumns", 'msg'=>"������", 'value'=>4);

?>
