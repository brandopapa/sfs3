<?php
//$Id: config.php 5310 2009-01-10 07:57:56Z hami $
//�w�]���ޤJ�ɡA���i�����C
require_once "./module-cfg.php";
include_once "../../include/config.php";
include_once "../../include/sfs_case_PLlib.php";
//�z�i�H�ۤv�[�J�ޤJ��

 //���o�ҲհѼƳ]�w
$m_arr =& get_module_setup("team_sign_up");
extract($m_arr, EXTR_OVERWRITE);

$PHP_SELF = $_SERVER["PHP_SELF"] ;

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

function Get_stud_data($class_num  , $stud ) {
     //�ѯZ��+�y���� $get_arr �}�C�����o�G�m�W....
     global $CONN ;

   
     
    //�Ѯy��
    if (is_numeric($stud) ) {
       $class_num_id = $class_num . sprintf("%02d" ,$stud) ;
   
       $sql="select * from  stud_base  
           where  curr_class_num = '$class_num_id'    and stud_study_cond = 0   ";
    }else {
    	$sql="select * from  stud_base  
           where  stud_name = '$stud'  and stud_study_cond = 0   ";
    	
    }	
    //�y���B�m�W�B�ͤ�B�a�}�B�q�ܡB�a���B�a���u�@�B�u�@�q��

    $result = $CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256) ;
    
    
    $row = $result->FetchRow() ;
        $have_stud_data_fg = TRUE ;
	$s_addres = $row["stud_addr_1"]  ;
	$s_home_phone = $row["stud_tel_1"]  ;	//�a���q��
	$s_offical_phone =stud_tel_2  ;		//�u�@�a�q��
	$stud_id = $row["stud_id"];		//�Ǹ�
	$stud_name = $row["stud_name"];		//�m�W
	$stud_person_id = $row["stud_person_id"]; //������
	$stud_sex = $row["stud_sex"];		//�ʧO
	
	$s_birthday = $row["stud_birthday"]  ;
	
        $dd[] = $stud_name ;
        $dd[] = $stud_id ;	

    

    return $dd  ;
      	
}


function Get_stud_data2($class_num  , $now_class_id ) {
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
	$s_offical_phone =stud_tel_2  ;		//�u�@�a�q��
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

    	
        //�i�ץX���ﶵ
        //$STUD_FIELD = array("�Ǹ�","�ͤ�","�������r��","�y��","�ʧO","�q��","�a�}","���@�H","����","����") ;	
        $dd[] = $stud_name ;
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


    
        //�@�ֶץX
	$data_str  = @implode("," , $dd) ;

    }
    return $data_str  ;
      	
}
?>
