<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $
header('Content-type: text/html; charset=big5');
ini_set ('display_errors', 'Off');

//���o�]�w��
include_once "config.php";

if ($_SESSION['session_who'] != "�Юv") {
	echo "�ܩ�p�I���\��Ҳլ��Юv�M�ΡI";
	exit();
}

//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();

//�ثe��w�Ǵ�
$c_curr_seme=$_GET['year_seme'];

//�ثe��w�~�šA100�������w
$club_sn=$_GET['club_sn'];
	 print_name_list($c_curr_seme,$club_sn);
	 
?>
