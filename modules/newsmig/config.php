<?php
// $Id: config.php 5310 2009-01-10 07:57:56Z hami $

require_once "./module-cfg.php";
include_once "../../include/config.php";
//include_once "../../include/sfs_case_PLlib.php";


  //============================================================ 
  $path_str = "school/newsmig/";
  set_upload_path($path_str);  
  //�x�s���[�ɮ׵����m�A�ؿ��v���]��777(�̫ᦳ / )
  $savepath = $UPLOAD_PATH.$path_str;

  /*�M�����ڥؿ��۹��m �U�����| */
  $htmlsavepath = $UPLOAD_URL.$path_str;  
  //=========================================================


//���o�ҲհѼƳ]�w
$m_arr =&get_module_setup("newsmig");
extract($m_arr, EXTR_OVERWRITE);

$PHP_SELF = $_SERVER["PHP_SELF"] ;


function userdata($userid) 
  {
     //���o���W�B���Bemail 	 
     global $CONN , $user_name, $group_name , $user_eamil,  $class_year, $class_name;

     $sqlstr = " SELECT n.name ,a.class_num , b.email , c.title_name 
		FROM teacher_post a 
		LEFT JOIN teacher_base as n ON a. teacher_sn = n. teacher_sn
		LEFT JOIN teacher_title as c ON a.teach_title_id = c.teach_title_id
		LEFT JOIN teacher_connect as b ON a.teacher_sn = b.teacher_sn 
        where  n.teach_id =  '$userid'  " ;
	
   // echo $sqlstr ;	

     $result = $CONN->Execute($sqlstr);
     if ($result) {     
     	$nb = $result->FetchRow()  ;	
     	$user_name = $nb[name];
     	//���
     	$group_name = $nb[title_name] ;

        if ($nb[class_num]) {//�ť� 
          $temp_year = $class_year[substr($nb[class_num],0,1)] ;
          $temp_class =$class_name[substr($nb[class_num],1)] ;
          $group_name = $temp_year . $temp_class ."�Z";
        }       	
 
     	$user_eamil = $nb[email];
     }	   
  }


?>
