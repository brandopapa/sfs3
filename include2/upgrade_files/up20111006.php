<?php

//$Id:$

if(!$CONN){
        echo "go away !!";
        exit;
}
	//�W�[���ɦ��Z���ذѷ�
	$SQL="ALTER TABLE `score_ss` ADD `nor_item_kind` VARCHAR( 20 ) NULL;";
	$rs=$CONN->Execute($SQL);

		$SQL="ALTER TABLE `sfs_text` CHANGE `t_name` `t_name` VARCHAR( 100 ) NULL;";
	$rs=$CONN->Execute($SQL);

		$SQL="INSERT INTO sfs_text(`t_order_id`, `t_kind`, `g_id`, `d_id`, `t_name`, `t_parent`, `p_id`, `p_dot`) VALUES ( 0, '���ɦ��Z�ﶵ', 5, '0', '���ɦ��Z�ﶵ', '', 0, '');";
	$rs=$CONN->Execute($SQL);

?>