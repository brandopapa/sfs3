<?php

//$Id: up20040419.php 5310 2009-01-10 07:57:56Z hami $

if(!$CONN){
        echo "go away !!";
        exit;
}

//�N��`��{���ƪ��ݩʧ令�r��
$query="select * from seme_score_nor where 1=0";
$res=$CONN->Execute($query);
if ($res) {
	for ($i=1;$i<8;$i++) {
		$query="alter table seme_score_nor change score".$i." score".$i." varchar(3)";
		$CONN->Execute($query);
	}
}
?>