<?php


//---------------------------------------------------
// �o�̽Щ�W�{�����ѧO Id�A�g�k�G $ + Id + $
// SFS �}�o�p�����z��J SFS �� CVS Server ��
// �|�۰ʺ��@���@�ܼơA�`�N! �Щ�b���ѽd�򤤡A�p�U�ҥܡG
//
//---------------------------------------------------

// $Id: config.php 7210 2013-03-11 07:44:25Z infodaes $

//---------------------------------------------------
//
// �Ҳըt�ά������]�w�ɡA�@�w�n�ޤJ�A�ҥH�ϥ� require !!!
//
//---------------------------------------------------

require_once "./module-cfg.php";
include_once "../../include/config.php";
include_once "../../include/sfs_case_PLlib.php";
include_once "module-upgrade.php";

 //���o�ҲհѼƳ]�w
$m_arr =& get_module_setup("stud_sign");
extract($m_arr, EXTR_OVERWRITE);

$PHP_SELF = $_SERVER["PHP_SELF"] ;


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


//---------------------------------------------------
// �o�̽ФޤJ�z�ۤv���禡�w
//
// �S�����ܡA�i�H���L�C
// �Ъ`�N!!!!! �o�̥u��ϥ� include_once �� include
//---------------------------------------------------

// �ݱz��J


function Get_teach_name($class_id) {
	global $CONN ;
	//���o�Z�Ū��ť��W�A<50 �N����o�ť��A�D��ߦѮv 
	$sql =" select name  from teacher_base b ,teacher_post p 
	          where b.teacher_sn  = p.teacher_sn  and b.teach_condition =0 
	          and class_num ='$class_id' and p.teach_title_id < 50  ";
	$result =  $CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256) ;
	//echo $query ;
	$row = $result->FetchRow() ;
	$name = $row["name"];	
	return $name ;

}	 

function Get_stud_data($class_num  , $now_class_id , $get_arr) {
     //�ѯZ��+�y���� $get_arr �}�C�����o�G�m�W....
     global $CONN ;
    //�w�]�Ǧ~
    $curr_year =  curr_year();
    //�w�]�Ǵ�
    $curr_seme = curr_seme();

     $curr_class_year= substr($now_class_id,0,1) ;
     
    //�⥻�Z�m�W��J�}�C��

    $class_num_id = $class_num . sprintf("%02d" ,$now_class_id) ;

    $sql="select * from  stud_base  
           where  curr_class_num = '$class_num_id'    and stud_study_cond = 0   ";

    //�y���B�m�W�B�ͤ�B�a�}�B�q�ܡB�a���B�a���u�@�B�u�@�q��

    $result = $CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256) ;
    
    
    $row = $result->FetchRow() ;
        $have_stud_data_fg = TRUE ;
	$s_addres = $row["stud_addr_1"]  ;
	$s_home_phone = $row["stud_tel_1"]  ;	//�a���q��
	$s_offical_phone =stud_tel_2  ;	//�u�@�a�q��
	$stud_id = $row["stud_id"];		//�Ǹ�
	$stud_name = $row["stud_name"];		//�m�W
	$stud_person_id = $row["stud_person_id"]; //������
	$stud_sex = $row["stud_sex"];		//�ʧO
	
	$s_birthday = $row["stud_birthday"]  ;
	/*
	//�ഫ������
	if ( substr($s_birthday,0,4)>1911) 
	  $s_birthday = (substr($s_birthday,0,4) - 1911). substr($s_birthday,4) ;
	else 
	  $s_birthday = " " ; 
	*/
    if ($have_stud_data_fg) {	
        $sql="select *    from stud_domicile   where stud_id = '$stud_id'   ";
        $result = $CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256) ;
    
        $row = $result->FetchRow() ;           

	//�a��

         $d_guardian_name = $row["guardian_name"] ;	  
         $fath_name =$row["fath_name"] ;	  
         $moth_name =$row["moth_name"] ;
         

        $stud_class_id = $now_class_id ;
        $teacher_name= Get_teach_name($class_num) ;
    	
        //�i�ץX���ﶵ
        //$STUD_FIELD = array("�Ǹ�","�ͤ�","�������r��","�y��","�ʧO","�q��","�a�}","���@�H","����","����","�ť�") ;	
        $dd[] = $stud_id ;
        $dd[] = $s_birthday ;
        $dd[] = $stud_person_id ;
        $dd[] = $stud_class_id ;
        $dd[] = $stud_sex ;
        $dd[] = $s_home_phone ;
        $dd[] = $s_addres ;
        $dd[] = $d_guardian_name ;
        $dd[] = $fath_name ;
        $dd[] = $moth_name ;
        $dd[] = $teacher_name ;

    
        //�@�ֶץX
        $data_item_arr = split (",", $get_arr);   

        $max_get = count($data_item_arr) ;
        //$data_arr[] = $stud_name ;
        for ($i = 0 ; $i < $max_get ; $i++) {
    	  $tii = $data_item_arr[$i] ;
   	  $data_arr[] = $dd[$tii] ;
       }	
       if ($max_get ) 
         $data_arr_str  = @implode("##" , $data_arr) ;
      $data[0] = $stud_name ;
      $data[1] = $data_arr_str ;
      //echo $data_arr_str ;
    }
    return $data ;
      	
}	

function show_page_point($showpage, $totalpage) {
  $PHP_SELF = $_SERVER["PHP_SELF"] ;
              if ($showpage >1) 
                   $main =  "<a href=\"$PHP_SELF?showpage=" . ($showpage-1) . "\"><img src=\"images/prev.gif\"  alt=\"�e�@��\" border=\"0\"></a> \n " ;
                 else 
                   $main =  "<img src=\"images/prev.gif\"  alt=\"�w�O�̫e��\" border=\"0\" class=\"hide\">\n " ;
                 $main .= " | �� $showpage �� | \n" ;
                 if ($showpage < $totalpage) 
                   $main .= "<a href=\"$PHP_SELF?showpage=" . ($showpage+1). "\"><img src=\"images/next.gif\"  alt=\"�U�@��\" border=\"0\"></a> \n" ;
                 else   
                   $main .= "<img src=\"images/next.gif\"  alt=\"�w�O�̫᭶\" border=\"0\" class=\"hide\">\n " ;

                 
   
     $main = 
        "<table width='98%' border='0' cellspacing='0' cellpadding='0' align='center'>
          <tr>
            <td width='70%'>&nbsp;</td>
            <td width='30%'>   
              $main
            </td>\n
          </tr>
        </table>" ;
    return $main ;    
                 
}  


//���o�³��W���
function get_history() {
  global $PHP_SELF ,$CONN ;
  
  $sqlstr = " select id , title  from  sign_kind  order by id DESC " ;
  $recordSet =  $CONN->Execute($sqlstr) ;  
  while ( ($recordSet) and ( !$recordSet->EOF) ){         
      	$id = $recordSet->fields["id"];
      	$act_name = nl2br($recordSet->fields["title"]);     
      	$select_str  .= "<option value='$id' >$act_name</option>\n" ;
 	$recordSet->MoveNext();    
  }      
  $select_str = "<select name='history_id' >
                 <option value='0' selected>------</option>    
                 $select_str
                 </select>" ;    
  return $select_str ;
}  
//---------------------------------------------------
// 
// �ܼƩw�q�A�ЦܡGmodule-cfg.php
// 
//
//---------------------------------------------------


?>
