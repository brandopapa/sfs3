<?php
//$Id: up_sport_DB.php 5310 2009-01-10 07:57:56Z hami $
include_once "config.php";
//�{��
sfs_check();

$item_kgp=0;$item_kgm=0;$res_kgp=0;//��s����
//�ˬd sport_item��
$SQL="show columns from sport_item ";
$rs=$CONN->Execute($SQL) or die($SQL);
$arr=$rs->GetArray();
for($i=0; $i<$rs->RecordCount(); $i++) {
	($arr[$i][Field]=='kgp') ? $item_kgp=1 :$item_kgp=$item_kgp;
	($arr[$i][Field]=='kgm') ? $item_kgm=1 :$item_kgm=$item_kgm;
}
//�ˬd sport_res ��
$SQL="show columns from sport_res ";
$rs=$CONN->Execute($SQL) or die($SQL);
$arr=$rs->GetArray();
for($i=0; $i<$rs->RecordCount(); $i++) {
	($arr[$i][Field]=='kgp') ? $res_kgp=1 :$res_kgp=$res_kgp;
}

if ($item_kgp==0){
$UP_SQL="ALTER TABLE sport_item ADD kgp TINYINT( 3 ) DEFAULT '0' NOT NULL AFTER passera ";
 $rs=$CONN->Execute($UP_SQL) or die($UP_SQL);
}
if ($item_kgm==0){
$UP_SQL="ALTER TABLE sport_item ADD kgm TINYINT( 3 ) DEFAULT '0' NOT NULL AFTER kgp ";
$rs=$CONN->Execute($UP_SQL) or die($UP_SQL);
}
if ($res_kgp==0 ){
$UP_SQL="ALTER TABLE sport_res ADD kgp TINYINT( 3 ) DEFAULT '0' NOT NULL AFTER kmaster ";
$rs=$CONN->Execute($UP_SQL) or die($UP_SQL);
}
echo "<H2><CENTER>��s�����I</CENTER></H2>";
?>
