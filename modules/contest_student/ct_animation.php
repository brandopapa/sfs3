<?php
//���o�]�w��
include_once "config.php";

sfs_check();


//�q�X����
head("���������v�� - �ʵeø��");

$tool_bar=&make_menu($school_menu_p);

//�C�X���
echo $tool_bar;

//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();

//�ثe��w�Ǵ�
$c_curr_seme=sprintf('%03d%1d',$curr_year,$curr_seme);

$ACTIVE=3; //�v�ɺ���

include_once("workupload.inc");

?>