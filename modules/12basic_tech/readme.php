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
	<li>���M�K�դJ�ǧ@�~�n�I�G<a href='http://me.moe.edu.tw/junior/index.php' target='_BLANK'>http://12basic.edu.tw/Detail.php?LevelNo=480</a></li>
	<li>���M�ۥ͸�T���G<a href='http://me.moe.edu.tw/junior/index.php' target='_BLANK'>http://me.moe.edu.tw/junior/index.php</a></li>
<p class='MsoNormal' style='text-indent: -17.85pt; line-height: 20.0pt; margin-left: 35.7pt'>
<span lang='EN-US' style='font-size: 10.0pt; font-family: Symbol'>�P<span style='font:7.0pt &quot;Times New Roman&quot;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span style='font-size: 14.0pt; font-family: �з���'>���M103�K�դJ�ǶW�B��ǼҲըϥλ����G<span lang='EN-US'> <a href='./103_tech_1.0.pdf' target='_BLANK'><img src='./images/on.png' border=0>1.0��</a></span></span><span lang='EN-US' style='font-size: 14.0pt; font-family: �s�ө���,serif'>
</span></p>
";

echo $help_doc;
foot();
?>