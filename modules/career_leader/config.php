<?php

// $Id: config.php 5310 2009-01-10 07:57:56Z smallduh $

	//�t�γ]�w��
	include_once "./module-cfg.php";
	include_once "../../include/config.php";

	//�ͲP���ɤ�U�Ҳը禡
  include_once "../12basic_career/my_fun.php";


	//�Ҳէ�s�{��
	require_once "./module-upgrade.php";
	  

//���J���Ҳժ��M�Ψ禡�w
include_once ('my_functions.php');


//���o�ҲհѼƪ����O�]�w
$m_arr = &get_module_setup("career_leader");
extract($m_arr,EXTR_OVERWRITE);

$name_list_arr=explode(',',$name_list);
$name_list2_arr=explode(',',$name_list2);

if ($max_leader1=='') $max_leader1=8;	
if ($max_leader2=='') $max_leader2=8;	
	
?>


