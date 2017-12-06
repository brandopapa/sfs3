<?php
// $Id: file.php 8678 2015-12-25 02:55:43Z qfon $
include "config.php";
$_GET['FSN']=intval($_GET['FSN']);
$str="SELECT main_data, type FROM file_db WHERE FSN={$_GET['FSN']}";
$recordSet=$CONN->Execute($str);
if ($recordSet) {
	$image = $recordSet->FetchRow();
	header("Content-Type: $image[type]");
	echo stripslashes(Base64_Decode($image[main_data])); 
}
?> 
