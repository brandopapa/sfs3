<?php
// $Id: help.php 6032 2010-08-25 09:33:51Z infodaes $

include "config.php";
sfs_check();

//�q�X����
head("�ϥλ���");

//��V������
$linkstr="item_id=$item_id";
echo print_menu($MENU_P,$linkstr);

$help_doc="<p class='MsoNormal' style='text-indent: -17.85pt; line-height: 20.0pt; margin-left: 35.7pt'>
<span lang='EN-US' style='font-size: 10.0pt; font-family: Symbol'>�P<span style='font:7.0pt &quot;Times New Roman&quot;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span style='font-size: 14.0pt; font-family: �з���'>�Ш|���Q�G�~����򥻱Ш|��T���G<span lang='EN-US'><a style='color: blue; text-decoration: underline; text-underline: single' href='http://12basic.edu.tw/' target='_BLANK'><span style='color: #0000CC; text-decoration: none'>http://12basic.edu.tw/</span></a></span></span><span lang='EN-US' style='font-size: 14.0pt; font-family: �s�ө���,serif'>
</span></p>
<p class='MsoNormal' style='text-indent: -17.85pt; line-height: 20.0pt; margin-left: 35.7pt'>
<span lang='EN-US' style='font-size: 10.0pt; font-family: Symbol'>�P<span style='font:7.0pt &quot;Times New Roman&quot;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span style='font-size: 14.0pt; font-family: �з���'>����ϰ���¾�K�դJ�ǧ@�~�n�I�G<span lang='EN-US'><a style='color: blue; text-decoration: underline; text-underline: single' href='http://docs.google.com/a/tc.edu.tw/viewer?a=v&pid=sites&srcid=dGMuZWR1LnR3fHRjMTJleHBsYWlufGd4Ojg3MjRhZmQxYTI2MmVmMQ' target='_BLANK'><span style='color: #0000CC; text-decoration: none'>http://docs.google.com/a/tc.edu.tw/viewer?a=v&pid=sites&srcid=dGMuZWR1LnR3fHRjMTJleHBsYWlufGd4Ojg3MjRhZmQxYTI2MmVmMQ</span></a></span></span><span lang='EN-US' style='font-size: 14.0pt; font-family: �s�ө���,serif'>
</span></p>
<p class='MsoNormal' style='text-indent: -17.85pt; line-height: 20.0pt; margin-left: 35.7pt'>
<span lang='EN-US' style='font-size: 10.0pt; font-family: Symbol'>�P<span style='font:7.0pt &quot;Times New Roman&quot;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span style='font-size: 14.0pt; font-family: �з���'>�����103�K�դJ�ǶW�B��ǼҲվާ@�����G<span lang='EN-US'> <a href='./103_tcntc_1.0.pdf' target='_BLANK'><img src='./images/on.png' border=0>1.0��</a></span></span><span lang='EN-US' style='font-size: 14.0pt; font-family: �s�ө���,serif'>
</span></p>
<hr>
<p class='MsoNormal' style='text-indent: -17.85pt; line-height: 20.0pt; margin-left: 35.7pt'>
<span lang='EN-US' style='font-size: 10.0pt; font-family: Symbol'>�P<span style='font:7.0pt &quot;Times New Roman&quot;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span style='font-size: 14.0pt; font-family: �з���'>2/27�s�W103����ϧK�դJ�ǩۥ��ɶץX�榡�\��A�L�k���T��X�Х��վ�php.ini max_execution_time�]�w�C</span><span lang='EN-US' style='font-size: 14.0pt; font-family: �s�ө���,serif'>
</span></p>
<p class='MsoNormal' style='text-indent: -17.85pt; line-height: 20.0pt; margin-left: 35.7pt'>
<span lang='EN-US' style='font-size: 10.0pt; font-family: Symbol'>�P<span style='font:7.0pt &quot;Times New Roman&quot;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span style='font-size: 14.0pt; font-family: �з���'>3/3 �W�[�۰ʧP�_�����O�_�q�L�ڻy�{�ҥ\��A�ϥΫe�������^�Ҳ��ܼƹw�]�Ȩó]�w�nnative_id(�����N��)�Bnative_language_sort(�ڻy�{���ݩʰO������)�Bnative_language_text(�q�L�ڻy�{�ҼаO��r)</span><span lang='EN-US' style='font-size: 14.0pt; font-family: �s�ө���,serif'>
</span></p>
<p class='MsoNormal' style='text-indent: -17.85pt; line-height: 20.0pt; margin-left: 35.7pt'>
<span lang='EN-US' style='font-size: 10.0pt; font-family: Symbol'>�P<span style='font:7.0pt &quot;Times New Roman&quot;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span style='font-size: 14.0pt; font-family: �з���'>3/4 �W�[�Ҳ��ܼ����Ǯը̷ӾǮի��w�p����ƿ�X�ӷ� (�����w�Υ����^�Ҳ��ܼƫh�̾ڭ���W�h�ѵ{���P�w)</span><span lang='EN-US' style='font-size: 14.0pt; font-family: �s�ө���,serif'>
</span></p>
";
echo $help_doc;
foot();
?>