<?php

//$Id: config.php 6732 2012-03-28 01:54:06Z infodaes $

include_once "../../include/config.php";
require_once "./module-cfg.php";
require_once "./module-upgrade.php";

 //���o�ҲհѼƪ����O�]�w
$m_arr = get_module_setup("lend_request");
extract($m_arr,EXTR_OVERWRITE);

//���o�Юv�����Ҧr��
$session_tea_sn = $_SESSION['session_tea_sn'];

//���o�ЮvEMAIL
$query ="select * from teacher_connect where teacher_sn=$session_tea_sn";
$result = $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);
$teacher_email=$result->fields['email'];

//���o��¾��¾�٦C��
$title_array=array();
$query =" select * from teacher_title";
$result =  $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);
while(!$result->EOF)
{
	$title_array[$result->fields[teach_title_id]]=$result->fields[title_name];
	$result->MoveNext();
}

//���o��¾���m�W�P�s��
$teacher_array=array();
$query =" select a.teacher_sn,a.name,a.teach_condition,b.teach_title_id from teacher_base a,teacher_post b where a.teacher_sn=b.teacher_sn";
$result =  $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256) ;
while(!$result->EOF)
{
	$teacher_array[$result->fields[teacher_sn]]['name']=$result->fields[name];
	$teacher_array[$result->fields[teacher_sn]]['condition']=$result->fields[teach_condition];
	$teacher_array[$result->fields[teacher_sn]]['title']=$title_array[$result->fields[teach_title_id]];
	$result->MoveNext();
}


//echo "<PRE>";
//print_r($teacher_array);
//echo "</PRE>";
//exit;

?>
