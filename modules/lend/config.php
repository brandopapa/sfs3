<?php

//$Id: config.php 5679 2009-10-06 15:52:32Z infodaes $

include_once "../../include/config.php";
require_once "./module-cfg.php";

 //���o�ҲհѼƪ����O�]�w
$m_arr = get_module_setup("lend");
extract($m_arr,EXTR_OVERWRITE);

$split_str='{*}';  //post��mail function�n�զX�Τ��Ѫ��P�_�̾�

//���o�Юv�����Ҧr��
$session_tea_sn = $_SESSION['session_tea_sn'];

//���o��¾��¾�٦C��
$title_array=array();
$query ="select * from teacher_title";
$result =  $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256) ;
while(!$result->EOF)
{
	$title_array[$result->fields[teach_title_id]]=$result->fields[title_name];
	$result->MoveNext();
}

//���o��¾���m�W�P�s��
$teacher_array=array();
$teach_id_array=array();
$query =" select a.teacher_sn,a.teach_id,a.name,a.teach_condition,b.teach_title_id from teacher_base a,teacher_post b where a.teacher_sn=b.teacher_sn ORDER BY b.teach_title_id";
$result =  $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256) ;
while(!$result->EOF)
{
	
	$teacher_array[$result->fields[teacher_sn]]['name']=$result->fields[name];
	$teacher_array[$result->fields[teacher_sn]]['condition']=$result->fields[teach_condition];
	$teacher_array[$result->fields[teacher_sn]]['title']=$title_array[$result->fields[teach_title_id]];
	
	if(!$result->fields[teach_condition]) $teach_id_array[$result->fields['teach_id']]=$result->fields[teacher_sn];
	
	$result->MoveNext();
}

//���o��¾��email �[�J$teacher_array��
$query =" select * from teacher_connect";
$result =  $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256) ;
while(!$result->EOF)
{
	$teacher_array[$result->fields[teacher_sn]]['email']=$result->fields[email];
	$result->MoveNext();
}


?>
