<?php
session_start();

include "commonclass.php";
$obj = new TC_OID_BASE();
$obj->setFinishFile("../../login.php");

if(empty($_GET['openid_identifier'])) { $obj->displayError("請輸入公務帳號"); }
$openid= "http://" . $_GET['openid_identifier'] .".openid.tc.edu.tw";
$obj->beginAuth($openid);

?>
