<?php
//$Id: index.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";

//�{��
sfs_check();

//�q�X�����������Y
head("���ƿ�����");


$tpl=dirname(__file__)."/templates/chc_index.htm";
//$smarty->assign("this",$this);
$smarty->display($tpl);
//�D�n���e


//�G������
foot();
