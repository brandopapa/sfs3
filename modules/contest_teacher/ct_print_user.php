<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";
?>
<link type="text/css" rel="stylesheet" href="../contest_teacher/include/my.css">

<?php

sfs_check();


//�ثe��w�Ǵ�
  $c_curr_seme=($_POST['c_curr_seme']!="")?$_POST['c_curr_seme']:sprintf('%03d%1d',$curr_year,$curr_seme);
//�ثe��w�Ǵ�
//$c_curr_seme=sprintf('%03d%1d',$curr_year,$curr_seme);

//�ثe����ɶ�, �Ω���������Ĵ���
$Now=date("Y-m-d H:i:s");

if (!$MANAGER) {
 echo "<font color=red>��p! �A�S���޲z�v��, �t�θT��A�~��ާ@���\��!!!</font>";
 exit();
}

$TEST=get_test_setup($_POST['option1']);


  list_user_print($_POST['option1'],$_POST['act']);



?>