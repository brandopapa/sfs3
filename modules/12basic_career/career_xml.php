<?php

// $Id:  $

//���o�]�w��
include_once "config.php";

sfs_check();

//�q�X����
head("�ͲP���ɸ��XML�洫");

//�Ҳտ��
print_menu($menu_p,$linkstr);

if(checkid($_SERVER['SCRIPT_FILENAME'],1)) {
 echo "<center><font size=5 color='#ff0000'><br><br>���\��}�o���A�q�Я�@�ߵ��ԡI<br><br></font></center>";
} else echo "<center><font size=5 color='#ff0000'><br><br>�z���㦳�Ҳպ޲z�v�A�t�θT��z�ϥΡI<br><br></font></center>";

foot();

?>
