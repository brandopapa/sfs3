<?php

// $Id: config.php 5310 2009-01-10 07:57:56Z smallduh $

	//�t�γ]�w��
	include_once "./module-cfg.php";
	include_once "../../include/config.php";


	//�Ҳէ�s�{��
	require_once "./module-upgrade.php";
	  

//���J���Ҳժ��M�Ψ禡�w
include_once ('my_functions.php');

//���o�ǮեN�X
$sql="select sch_id from school_base limit 1";
$res=$CONN->Execute($sql);
$sch_id=$res->fields['sch_id'];


$level_array=array(1=>'���',2=>'����B�O�W��',3=>'�ϰ�ʡ]�󿤥��^',4=>'�١B���ҥ��B��',5=>'�����ϡ]�m��^',6=>'�դ�');

$squad_array=array(1=>'�ӤH��',2=>'������');

//���o�Ҳ��ܼ�, �ñN�}�C�� key �@���ܼƪ��W��
//�w�]�w $rank_select ������� 
$m_arr = &get_module_setup("career_race");
extract($m_arr,EXTR_OVERWRITE);

if ($rank_select=='') $rank_select="�Ĥ@�W,�a�x,���P,�S�u,�ĤG�W,�ȭx,�ȵP,�u��,�ĤT�W,�u�x,�ɵP,�ҵ�,�ĥ|�W,���x,�Χ@,�Ĥ��W,�J��,�Ĥ��W,�ĤC�W,�ĤK�W"; 
if ($nature_select=='') $nature_select='��|��,�����,�y����,������,���N��,�R����,������,��X��';


//�D�̪F�a�ϴ��ծɡA��H�U���Ѩ���
//$sch_id="130001";

//�̪F�ϱM��
if (substr($sch_id,0,2)=='13') {
 $level_array=array(1=>'��ک�',2=>'�����',3=>'������');
 $nature_select='��|��,�����,�y����,������,���N��,�R����,�����Ш|��,��X��,��L��';
 $school_menu_p['cr_input.php']="�n��/�ק�ӧO�v�ɰO��(�̪F��)";
}

	
?>

