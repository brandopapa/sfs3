<?

function Get_teach_name($class_id) {
	global $CONN ;
	//���o�Z�Ū��ť��W�A<50 �N����o�ť��A�D��ߦѮv 
	$sql =" select name  from teacher_base b ,teacher_post p 
	          where b.teacher_sn  = p.teacher_sn  and b.teach_condition =0 
	          and class_num ='$class_id' and p.teach_title_id < 50  ";
	$result =  $CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256) ;

	$row = $result->FetchRow() ;
	$name = $row["name"];	
	return $name ;

}	 


function Get_stud_name($name) {
    //�m�W....
    global $CONN ;


    $sql="select stud_id , stud_name  from  stud_base  
           where  (stud_name = '$name' or stud_id = '$name' or curr_class_num = '$name')  and stud_study_cond = 0   ";

    $rs = $CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256) ;
    while(!$rs->EOF){   
       $data[] = $rs->fields["stud_id"];	
       $rs->MoveNext();
       $m++ ;
    }	
    return $data ;           
}           


function Get_parent_name2($name) {
     //�m�W....
     global $CONN ;


    $sql=" select d.stud_id , b.stud_name  from  stud_base b , stud_domicile d
           where d.stud_id= b.stud_id and  (d.fath_name = '$name' or d.guardian_name = '$name' or d.moth_name = '$name') and b.stud_study_cond in (0,15)   ";

    $rs = $CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256) ;
    while(!$rs->EOF){   
       $data[] = $rs->fields["stud_id"];	
       $rs->MoveNext();
       $m++ ;
    }	
    return $data ;           
}           



function Get_stud_data($stud_id) {
     //�ѯZ��+�y���� $get_arr �}�C�����o�G�m�W....
     global $CONN ,$class_name_arr  ;



    $sql="select * from  stud_base  
           where  stud_id  = '$stud_id'   and stud_study_cond = 0   ";

    //�y���B�m�W�B�ͤ�B�a�}�B�q�ܡB�a���B�a���u�@�B�u�@�q��

    $result = $CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256) ;
    
    
    $row = $result->FetchRow() ;
        $have_stud_data_fg = TRUE ;
	$s_addres = $row["stud_addr_1"]  ;
	$s_home_phone = $row["stud_tel_1"]  ;	//�a���q��
	$stud_tel_2 =$row["stud_tel_2"]  ;	//���q��
	$s_cell_phone =$row["stud_tel_3"]  ;	//�u�@�a�q��
	$stud_id = $row["stud_id"];		//�Ǹ�
	$stud_name = $row["stud_name"];		//�m�W
	$stud_person_id = $row["stud_person_id"]; //������
	$stud_sex = $row["stud_sex"];		//�ʧO
	
	$stud_sex = ($stud_sex ==1 ) ? "�k" : "�k" ;
	
	$class_num_curr = $row["curr_class_num"];		//�ثe�Z�šB�y��
 
        $classid = intval(substr($class_num_curr,0,3));	//���o�Z��	
        $stud_class_id = intval(substr($class_num_curr,-2));	//�y��	

	
	$s_birthday = $row["stud_birthday"]  ;
	/*
	//�ഫ������
	if ( substr($s_birthday,0,4)>1911) 
	  $s_birthday = (substr($s_birthday,0,4) - 1911). substr($s_birthday,4) ;
	else 
	  $s_birthday = " " ; 
	*/
    unset( $dd );	
    if ($have_stud_data_fg) {	
        $sql="select *    from stud_domicile   where stud_id = '$stud_id'   ";
        $result = $CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256) ;
    
        $row = $result->FetchRow() ;           

	//�a��

         $d_guardian_name = $row["guardian_name"] ;	  
         $fath_name =$row["fath_name"] ;	
         $fath_hand_phone =$row["fath_hand_phone"] ;  
         $moth_name =$row["moth_name"] ;
         


    	
        //�i�ץX���ﶵ
        //$STUD_FIELD = array(�m�W�A"�Ǹ�","�ͤ�","�������r��","�Z��","�y��","�ʧO","�q��","�a�}","���@�H","����","����","�ť�") ;	
        $dd[] = $stud_name ;
        $dd[] = $stud_id ;
        $dd[] = $s_birthday ;
        $dd[] = $stud_person_id ;
        $dd[] = $class_name_arr[$classid] ;
        $dd[] = $stud_class_id ;
        $dd[] = $stud_sex ;
        $dd[] = "=T(\"$s_home_phone\")" ;
        $dd[] = "=T(\"$stud_tel_2\")" ;
        $dd[] = $s_addres ;
        $dd[] = $d_guardian_name ;
        $dd[] = $fath_name ;
        $dd[] = "=T(\"$fath_hand_phone\")";
        $dd[] = $moth_name ;
        //$dd[] = $teacher_name ;

    
        //�@�ֶץX
        $data_str  = @implode("</td><td>" , $dd) ;
      

    }
    $data_str  ="<tr><td>$data_str</td></tr>" ;
    return $data_str  ;
      	
}	


?>