<?php
//�ɯ� sfs_text ��ƪ�
include "../include/config.php";
include "../include/sfs_case_PLlib.php";
include "update_function.php";
if(!check_field($mysql_db,$conID,'sfs_text','t_order_id')){
	$CONN->Execute("ALTER TABLE `sfs_text` CHANGE `d_id` `d_id` VARCHAR( 20 ) NOT NULL ") or trigger_error("��s���~",E_USER_ERROR);
	$CONN->Execute("ALTER TABLE `sfs_text` ADD `t_order_id` INT NOT NULL AFTER `t_id`");
	$CONN->Execute("UPDATE `sfs_text` SET t_order_id = d_id");
	header("Location: ".$_SERVER['HTTP_REFERER']);
}
else {
	trigger_error("sfs_text �w�ɯŹL�F�A�ˬd�@�U�O�_�٦���L��]!",E_USER_ERROR);
}
