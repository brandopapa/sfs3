<?php

include "config.php";
sfs_check();

//�q�X����
head("�ϥλ���");

//��V������
$linkstr="item_id=$item_id";
echo print_menu($MENU_P,$linkstr);

$help_doc="<br><br>
<li>�Ш|���Q�G�~����򥻱Ш|��T���G<a href='http://12basic.edu.tw/' target='_BLANK'>http://12basic.edu.tw/</a></li>
		<li>�̪F�ϰ���¾�K�դJ�ǧ@�~�n�I�G<a href='http://12basic.tchcvs.tc.edu.tw/File/Levelimg_35/11.pdf' target='_BLANK'>http://12basic.tchcvs.tc.edu.tw/File/Levelimg_35/11.pdf</a></li>
		<li>�̪F��103�K�դJ�ǶW�B��Ǹ�ƶץX�Ҳվާ@�����G<a href='./103_ptc_preview.pdf' target='_BLANK'><img src='./images/on.png' border=0>�w����</a> <a href='./103_ptc_1.0.pdf' target='_BLANK'><img src='./images/on.png' border=0>1.0��</a></li>
";

echo $help_doc;
foot();
?>