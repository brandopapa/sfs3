<?php

//$Id:$

include_once "../../include/config.php";
//require_once "./module-cfg.php";

 //���o�ҲհѼƪ����O�]�w
$m_arr = get_module_setup("salary");

$Tr_BGColor=$m_arr['Tr_BGColor'];

//���o�򥻸�ƶ��ب��ഫ���}�C
$BasisData1_arr=split(',',$m_arr['BasisData1']);
$BasisData2_arr=split(',',$m_arr['BasisData2']);
//���o�������ب��ഫ���}�C
$Mg_arr=split(',',$m_arr['Mg']);
//���o�N�����ب��ഫ���}�C
$Mh_arr=split(',',$m_arr['Mh']);
//���o�N�����ب��ഫ���}�C
$Mi_arr=split(',',$m_arr['Mi']);

//���o�Юv�����Ҧr��
$session_tea_sn = $_SESSION['session_tea_sn'] ;

$query =" select teach_person_id from teacher_base where teacher_sn='$session_tea_sn'";
$result =  $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256) ;
$row = $result->FetchRow() ;
$person_id=$row["teach_person_id"];

$empty_person_id="<CENTER><BR><BR><H2>�z�������Ҧr���|���]�w��ǰȨt��-�Юv�޲z��, �ЦV�t�κ޲z���d��!</H2></CENTER>";

$is_admin = checkid($_SERVER[SCRIPT_FILENAME],1);
if ($is_admin)
	$menu_p = array('list.php'=>'�~��d��','man.php'=>'��Ƴ]�w�P�W��');
else
	$menu_p = array('list.php'=>'�~��d��');

