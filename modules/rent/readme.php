<?php
// $Id: readme.php 6545 2011-09-23 07:00:14Z infodaes $
include "config.php";
sfs_check();
//�q�X����
head("���a�X���޲z��k");
//��V������
$linkstr="item_id=$item_id";
echo print_menu($MENU_P,$linkstr);
$help_doc="<iframe src='$doc' border='0' width='100%' height='400'></iframe>";
echo $help_doc;
foot();
?>