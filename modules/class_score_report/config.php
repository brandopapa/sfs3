<?php
// $Id: config.php 6401 2011-03-30 05:50:15Z infodaes $

/*�J�ǰȨt�γ]�w��*/
include "../../include/config.php";
include "../../include/sfs_case_PLlib.php";

//�ޤJ���
include "./my_fun.php";

//���
$menu_p = array("scope_tol.php"=>"����`��");
//���o�Ҳճ]�w
$m_arr = get_sfs_module_set();
extract($m_arr, EXTR_OVERWRITE);

//���o�Юv�ҤW�~�šB�Z��
$session_tea_sn = $_SESSION['session_tea_sn'] ;
$query =" select class_num  from teacher_post  where teacher_sn  ='$session_tea_sn'";
$result =  $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256) ;
$row = $result->FetchRow() ;
$class_id=$row["class_num"];

?>