<?php

//$Id: up20080322.php 5310 2009-01-10 07:57:56Z hami $

if(!$CONN){
        echo "go away !!";
        exit;
}

$query = "select * from stud_addr_zip where 1=0";
if ($CONN->Execute($query)) {
	$CONN->Execute("update stud_addr_zip set town='�_�ٰ�' where country='�x����' and town='�_��'");
	$CONN->Execute("update stud_addr_zip set town='��ٰ�' where country='�x����' and town='���'");
	$CONN->Execute("update stud_addr_zip set town='�n�ٰ�' where country='�x����' and town='�n��'");
}
?>
