<?php

// $Id: config.php 5310 2009-01-10 07:57:56Z hami $

require_once "./module-cfg.php";
include_once "../../include/config.php";
require_once "../../include/sfs_case_studclass.php";
require_once "../../include/sfs_case_score.php";
require_once "../../include/sfs_case_subjectscore.php";
include "../../include/sfs_case_PLlib.php";
include "my_fun.php";

//���o��ƪ�stud_seme���Ҧ��J�Ǧ~�שM�Ǵ�
function  stud_seme_year_seme(){
    global $CONN;
    $sql="select seme_year_seme  from stud_seme";
	$rs=$CONN->Execute($sql);
    $i=0;
    $AAA = array ();
	while(!$rs->EOF){
        $seme_year_seme[$i]= $rs->fields['seme_year_seme'];		
		//�[�J�}�C����
		if (!in_array($seme_year_seme[$i], $AAA)) $AAA[]=$seme_year_seme[$i];				
		$i++;
        $rs->MoveNext();
    }
return  $AAA;
}

//���o��ƪ�stud_seme�ӾǦ~�ת��Ҧ��Z��
function  stud_seme_class($seme_year_seme=""){
    global $CONN;    
	$sql="select seme_class,seme_class_name  from stud_seme where seme_year_seme='$seme_year_seme'";
	$rs=$CONN->Execute($sql);
    $i=0;
    $AAA = array ();	
	while(!$rs->EOF){
        $seme_class[$i]= $rs->fields['seme_class'];
		$seme_class_name[$i]= $rs->fields['seme_class_name'];
		//�[�J�}�C����
		if (!in_array($seme_class[$i], $AAA[seme_class]) && $seme_class[$i]!="") {
			$AAA[seme_class][]=$seme_class[$i];
			$AAA[seme_class_name][]=$seme_class_name[$i];
		}	
		$i++;
        $rs->MoveNext();
    }	
return  $AAA;
}

//��X�o�ӭȬO�}�C���ĴX�j���Aa�O�@�ӼơAb�O�@�Ӱ}�C
function  how_big($a,$b){
    $sort=1;
    for($i=0;$i<count($b);$i++){
        if($a<$b[$i]) $sort++;
    }
    return  $sort;
}
?>

