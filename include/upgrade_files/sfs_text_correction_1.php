<?php

//$Id:  $
if(!$CONN){
        echo "go away !!";
        exit;
}
$query = "update sfs_text set t_name='���H����' where t_name='���H�ݻ�';";
$CONN->Execute($query);
$query = "update sfs_text set t_name='�a������' where t_name='�a���ݻ�';";
$CONN->Execute($query);
?>
