<html>
	<head>
		<title>�C�L���Z�A�Ⱦǲߩ���</title>
	</head>
<body>
<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";

sfs_check();


//�ثe��w�Ǵ�
//$c_curr_seme=$_GET['c_curr_seme'];
//�ثe��w�Z��
//$c_curr_class=$_GET['c_curr_class'];

//�ثe��w�Ǵ�
$c_curr_seme=$_POST['c_curr_seme'];
//�ثe��w�Z��
$c_curr_class=$_POST['c_curr_class'];

	$classid=class_id_2_old($c_curr_class);
	
// if ($_GET['list_class_all']!="") {
// 	list_class_all($_GET['list_class_all'],$c_curr_seme,$classid[5]);
//  }	

  //�C�X�Ŀ� 	  
  foreach ($_POST['STUD'] as $student_sn=>$seme_num) {
     		list_service($student_sn,$c_curr_seme,$classid[5]);
  }

?>
</body>
</html>