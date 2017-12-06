<?php
//$Id: index.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";

//認證
sfs_check();

//秀出網頁布景標頭
head("彰化縣報表");


$tpl=dirname(__file__)."/templates/chc_index.htm";
//$smarty->assign("this",$this);
$smarty->display($tpl);
//主要內容


//佈景結尾
foot();
