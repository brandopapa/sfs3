<?php

//$Id: config.php 5310 2009-01-10 07:57:56Z hami $

include_once "../../include/config.php";
require_once "./module-cfg.php";

 //���o�ҲհѼƪ����O�]�w

$m_arr = &get_module_setup("charge_class");
extract($m_arr,EXTR_OVERWRITE);

//���o�Юv�ҤW�~�šB�Z��
$session_tea_sn = $_SESSION['session_tea_sn'] ;
$query =" select class_num  from teacher_post  where teacher_sn  ='$session_tea_sn'";
$result =  $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256) ;
$row = $result->FetchRow() ;
$class_id=$row["class_num"];

$not_allowed="<CENTER><BR><BR><H2>�z�ëD�Z�žɮv<BR>�Ϊ�<BR>�t�κ޲z���|���}��ɮv�ާ@���\��!</H2></CENTER>";

?>
