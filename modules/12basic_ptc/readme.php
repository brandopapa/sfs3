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
		<li>�̪F�ϰ���¾�K�դJ�ǧ@�~�n�I�G<a href='https://sites.google.com/site/aasd123twcaq/home/jiansongxiuzhenghouzhipingdongqugaojizhongdengxuexiaomianshiruxuezuoyeyaodianqingguixiaojiaqiangxuandao' target='_BLANK'>https://sites.google.com/site/aasd123twcaq/home/jiansongxiuzhenghouzhipingdongqugaojizhongdengxuexiaomianshiruxuezuoyeyaodianqingguixiaojiaqiangxuandao</a></li>
		<li>�̪F��103�K�դJ�ǶW�B��Ǹ�ƶץX�Ҳվާ@�����G<a href='./103_ptc_preview.pdf' target='_BLANK'><img src='./images/on.png' border=0>�w����</a> <a href='./103_ptc_1.0.pdf' target='_BLANK'><img src='./images/on.png' border=0>1.0��</a></li>
		<p>
		<li>�̪F��104�K�դJ�ǶW�B��Ǹ�ƶץX�Ҳվާ@�����G<a href='./104_ptc_1.0.pdf' target='_BLANK'><img src='./images/on.png' border=0>1.0��</a> <a href='./104_ptc_1.1.pdf' target='_BLANK'><img src='./images/on.png' border=0>1.1��(2015/01/03)</a></li>
		</p>
		<p>
		<li>�̪F��105�K�դJ�ǶW�B��Ǹ�ƶץX�Ҳվާ@�����G<a href='./ptc_105_1.0.pdf' target='_BLANK'><img src='./images/on.png' border=0>1.0��</a> <a href='./ptc_105_appendix.pdf' target='_BLANK'><img src='./images/on.png' border=0>�ǰȤ�`�Ҳվާ@����</a></li>
		</p>
";

echo $help_doc;
foot();
?>