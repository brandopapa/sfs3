<?php

// $Id: config.php 5310 2009-01-10 07:57:56Z hami $

include_once "../../include/config.php";
include_once "../../include/sfs_case_PLlib.php"; 
include_once "../../include/sfs_case_dataarray.php";
include_once "../../include/sfs_case_studclass.php";
include_once "module-cfg.php";
//include_once "../../include/sfs_case_subjectscore.php";

/* �W���ɮ׼Ȧs�ؿ� */
$path_str = "temp/student/";
set_upload_path($path_str);
$temp_path = $UPLOAD_PATH.$path_str;

//�]�w���
$sec=array("�ɡ@�X","�Ĥ@�`","�ĤG�`","�ĤT�`","�ĥ|�`","�Ĥ��`","�Ĥ��`","�ĤC�`","���@�X");
$sec_id=array("0"=>"uf","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"df");
$abs_kind=array("C"=>"�m��","V"=>"�ư�","S"=>"�f��","M"=>"�ల","B"=>"����");
$reward_kind=array("1"=>"ĵ�i","2"=>"�p�L","3"=>"�j�L","4"=>"�ż�","5"=>"�p","6"=>"�j");
$c_times=array("1"=>"�@","2"=>"�G","3"=>"�T","4"=>"�|","5"=>"��","6"=>"��","7"=>"�C","8"=>"�K","9"=>"�E","10"=>"�Q");
?>
