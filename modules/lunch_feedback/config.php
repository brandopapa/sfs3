<?php



//---------------------------------------------------

// �o�̽Щ�W�{�����ѧO Id�A�g�k�G $ + Id + $

// SFS �}�o�p�����z��J SFS �� CVS Server ��

// �|�۰ʺ��@���@�ܼơA�`�N! �Щ�b���ѽd�򤤡A�p�U�ҥܡG

//

//---------------------------------------------------



// $Id: config.php 5310 2009-01-10 07:57:56Z hami $



//---------------------------------------------------

//

// �Ҳըt�ά������]�w�ɡA�@�w�n�ޤJ�A�ҥH�ϥ� require !!!

//

//---------------------------------------------------



require_once "./module-cfg.php";



//---------------------------------------------------

// �o�̽ФޤJ SFS �ǰȨt�Ϊ������禡�w�C

//

// �ܩ�n�ޤJ���ǩO�H

//

// 1. sfs3/include/config.php �g�`�O�ݭn���C

//

// 2. �䥦�A�N���z���{���ت��өw�C

// �Ъ`�N!!!!! �o�̥u��ϥ� include_once �� include

//---------------------------------------------------





// �ޤJ SFS �]�w�ɡA���|���z���J SFS ���֤ߨ禡�w

include_once "../../include/config.php";




//���o�ҲհѼƳ]�w

$m_arr = &get_sfs_module_set("lunch_feedback");

extract($m_arr, EXTR_OVERWRITE);



//---------------------------------------------------

// �o�̽ФޤJ�z�ۤv���禡�w

$c_day=array('','�@','�G','�T','�|','��','��','��');


//���o�Юv�ҤW�~�šB�Z��
$session_tea_sn = $_SESSION['session_tea_sn'] ;
$session_tea_name = $_SESSION['session_tea_name'] ;
$query =" select class_num  from teacher_post  where teacher_sn  ='$session_tea_sn'";
$result =  $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256) ;
$row = $result->FetchRow() ;
$class_id=$row["class_num"];

if (checkid($_SERVER['SCRIPT_FILENAME'],1)) {
	$class_id_arr=class_base();
	$class_id=($_POST[class_id])?$_POST[class_id]:key($class_id_arr);
	$is_admin=1;
}

$not_allowed="<CENTER><BR><BR><H2>�z�ëD�Z�žɮv<BR>�Ϊ�<BR>�t�κ޲z���|���}��ɮv�ާ@���\��!</H2></CENTER>";


?>
