<?php
//$Id: chc_seme_rank.php 8576 2015-10-27 11:13:27Z qfon $
include "chc_config.php";
//�{��
sfs_check();

//�ޤJ��������(�ǰȨt�ΥΪk)
include_once "dropmenu.php";
include_once "chc_seme_advance.php";
//�{���ϥΪ�Smarty�˥���
$template_file = dirname (__file__)."/templates/chc_seme_rank.htm";
//�إߪ���
$obj= new chc_seme_advance($CONN,$smarty);
//��l��
$obj->init();
//�B�z�{��,���ɵ{�Ǥ���header���O,�G���{�ǩy��head("score_semester_91_2�Ҳ�");���e
$obj->process();

//�q�X�����������Y
head("���q���Z�i�h�B�d��");

//���SFS�s�����(���ϥνЮ��}����)
echo make_menu($school_menu_p);

//��ܤ��e
$obj->display($template_file);
//�G������
foot();



?>
