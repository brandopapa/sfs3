<?php

// $Id: config.php 5310 2009-01-10 07:57:56Z smallduh $

	//�t�γ]�w��
	include_once "./module-cfg.php";
	include_once "../../include/config.php";


	//�Ҳէ�s�{��
	require_once "./module-upgrade.php";
	  

//���J���Ҳժ��M�Ψ禡�w
include_once ('my_functions.php');

$level_array=array(1=>'���',2=>'����B�O�W��',3=>'�ϰ�ʡ]�󿤥��^',4=>'�١B���ҥ��B��',5=>'�����ϡ]�m��^',6=>'�դ�');
$squad_array=array(1=>'�ӤH��',2=>'������');

//���o�Ҳ��ܼ�, �ñN�}�C�� key �@���ܼƪ��W��
//�w�]�w $rank_select ������� 
$m_arr = &get_module_setup("career_race");
extract($m_arr,EXTR_OVERWRITE);

if ($rank_select=='') $rank_select="�Ĥ@�W,�a�x,���P,�S�u,�ĤG�W,�ȭx,�ȵP,�u��,�ĤT�W,�u�x,�ɵP,�ҵ�,�ĥ|�W,���x,�Χ@,�Ĥ��W,�J��,�Ĥ��W"; 
if ($nature_select=='') $nature_select='��|��,�����,�y����,������,���N��,�R����,������';
	
?>

