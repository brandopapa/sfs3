<?php
//$Id: config.php 6064 2010-08-31 12:26:33Z infodaes $
include_once "../../include/config.php";
include_once "../../include/sfs_case_dataarray.php";
require_once "./module-cfg.php";

//���o�ҲհѼƪ����O�]�w
$m_arr =&get_module_setup("sms_mitake");
$menu_p = array("sms_teacher.php"=>"�o�e����¾��","sms_guardian.php"=>"�o�e���Z�žǥͺ��@�H","sms_sp_guardian.php"=>"�o�e���S�����ǥͺ��@�H","sms_record.php"=>"�o�e�O��","sms_statistics.php"=>"�o�e�έp");

//$StatusFlagArray=array(0=>'�w���ǰe��',1=>'�w�e�F�~��',2=>'�w�e�F�~��',3=>'�w�e�F�~��',4=>'�w�e�F���',5=>'���e�����~',6=>'���������~',7=>'²�T�w����',8=>'�O�ɵL�e�F',9=>'�w���w����');

$statuscodeArray=array(
'*'=>'�� �t�εo�Ϳ��~�A���p���T�˸�T���f�H��',
'a'=>'�� ²�T�o�e�\��Ȯɰ���A�ȡA�еy�ԦA��',
'b'=>'�� ²�T�o�e�\��Ȯɰ���A�ȡA�еy�ԦA��',
'c'=>'�п�J�b��',
'e'=>'�� �b���B�K�X���~',
'f'=>'�� �b���w�L��',
'h'=>'�� �b���w�Q����',
'k'=>'�L�Ī��s�u��}',
'm'=>'�����ܧ�K�X�A�b�ܧ�K�X�e�A�L�k�ϥ�²�T�o�e�A��',
'n'=>'�K�X�w�O���A�b�ܧ�K�X�e�A�N�L�k�ϥ�²�T�o�e�A��',
'p'=>'�S���v���ϥΥ~��Http�{��',
'r'=>'�t�μȰ��A�ȡA�еy��A��',
's'=>'�b�ȳB�z���ѡA�L�k�o�e²�T',
't'=>'²�T�w�L��',
'u'=>'²�T���e���o���ť�',
'v'=>'�� �L�Ī�������X',
'0'=>'�� �w���ǰe��',
'1'=>'�� �w�e�F�~��',
'2'=>'�w�e�F�~��',
'3'=>'�w�e�F�~��',
'4'=>'�� �w�e�F���',
'5'=>'�� ���e�����~',
'6'=>'�� ���������~',
'7'=>'�� ²�T�w����',
'8'=>'�� �O�ɵL�e�F',
'9'=>'�w���w����');

/*
$StatusstrArray=(
'DELIVRD'=>'�w�e�F���',
'EXPIRED'=>'�O�ɵL�k�e�F',
'DELETED'=>'�w���w����',
'UNDELIV'=>'�L�k�e�F(���������~/²�T�w����)',
'ACCEPTD'=>'²�T�B�z��(0=�w�����A1,2,3=�w�e�F�q�H�~��)',
'UNKNOWN'=>'�L�Ī�²�T���A�A�t�Φ����~',
'REJECTD'=>'',
'SYNTAXE'=>'²�T���e�����~');
*/
?>
