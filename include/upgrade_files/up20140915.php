<?php

//$Id:$

if (!$CONN) {
    echo "go away !!";
    exit;
}
global $UPLOAD_PATH;
//�R���s�ͶפJ��ƼȦs��
$tempFile = $UPLOAD_PATH . 'temp/newstud/newstud.csv';

if (is_file($tempFile))
    unlink($tempFile);

?>