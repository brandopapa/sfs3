<?php
//$Id: secure_path.php 5310 2009-01-10 07:57:56Z hami $

if(!$CONN){
        echo "go away !!";
        exit;
}
global $UPLOAD_PATH ;
@unlink($UPLOAD_PATH.'/Module_Path.php');

//�Q��  .htaccess ���w data �U ���ɮפ��i���� php�{��
	$fp = fopen ($UPLOAD_PATH.".htaccess", "aw") or user_error("�L�k�}�� $UPLOAD_PATH �ؿ�",256);
	fputs($fp, "php_flag engine off"); 
	fclose($fp); 
?>
