<?php

//$Id:$

if(!$CONN){
        echo "go away !!";
        exit;
}
$SQL="UPDATE stud_addr_zip SET town='�_�ٰ�' WHERE zip='406'";
$rs=$CONN->Execute($SQL);
$SQL="UPDATE stud_addr_zip SET town='��ٰ�' WHERE zip='407'";
$rs=$CONN->Execute($SQL);
$SQL="UPDATE stud_addr_zip SET town='�n�ٰ�' WHERE zip='408'";
$rs=$CONN->Execute($SQL);

?>