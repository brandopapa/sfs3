<?php
// $Id: stud_search2.php 5310 2009-01-10 07:57:56Z hami $

  //���J�]�w��
  require("config.php") ;
 
  // �{���ˬd
  sfs_check();
 

  head("�j�M");
  //���
  print_menu($menu_p);

  //�y���B�m�W�B�ͤ�B�a�}�B�q�ܡB�a���B�a���u�@�B�u�@�q��
  
  $Submit =$_POST['Submit'];
  $searchname =$_POST['searchname'];
  $search_id =$_POST['search_id'];
  $search_f_name =$_POST['search_f_name'];
  $search_phon =$_POST['search_phon'];
  $search_town =$_POST['search_town'];
  $search_village =$_POST['search_village'];

  
  $sql_select = "select s.stud_id, s.stud_name, s.stud_person_id , s.stud_birthday ,s.stud_tel_1 ,
                  s.stud_study_cond , s.curr_class_num ,
                  d.guardian_name ,d.fath_name ,d.moth_name 
                  from stud_base as s  LEFT JOIN stud_domicile as d ON s.stud_id=d.stud_id";  

                   
  if ($Submit =="�e�X") {
	
    if (trim($searchname)<>""){	
        //�ǥͩm�W
   	    $searchname= trim($searchname) ;
   	    //echo $searchname ;
        $searchname = addslashes($searchname);

        $sqlstr = " and s.stud_name like '%".($searchname)."%'"  ;

        //echo $sql_select ;
    }     
    elseif (trim($search_id)<>""){	
        //�Ǹ�
   	    $search_id= trim($search_id) ;
        $sqlstr = " and   s.stud_id like '%$search_id%' "  ;

    }   
    elseif (trim($search_f_name)<>"") {
        //�a���m�W
   	    $search_f_name= trim($search_f_name) ;
        $search_f_name = addslashes($search_f_name);

   	    $sqlstr = " and ( d.guardian_name  like '%" .$search_f_name."%' 
   	                 or  d.fath_name   like '%" .$search_f_name."%' 
   	                or  d.moth_name    like '%" .$search_f_name."%' ) "  ;

        
    }	 
    elseif (trim($search_phon)<>"") {
        //�a���q��
      
   	    $search_phon= trim($search_phon) ;
   	    $sqlstr = " and ( s.stud_tel_1   ='$search_phon' 
   	            or  s.stud_tel_2   ='$search_phon'  
   	            or  s.stud_tel_3  ='$search_phon' ) "  ;

    }	     
    elseif ($search_town) {
        //�a�}
        $search_town = trim($search_town) ;
        $search_town = addslashes($search_town);
        if ($search_town)  
           $sqlstr =  " and  ( s.stud_addr_1   like '%$search_town%' or s.stud_addr_2   like '%$search_town%' ) " ;

    }
    

  }	
   if ($sqlstr) {

   	$sqlstr = substr($sqlstr ,4) ; //�h�� and
   	//�b�ǥ�===================================================
    $sql_select_in = " $sql_select  where $sqlstr  and  stud_study_cond = 0   order by  s.curr_class_num ";

    $data_array_in = get_stud_data($sql_select_in) ;
    $have_in = 1 ;

    //�D�b�ǥ�===================================================  
    if ($chk_view_old == 1) {
    	 $sql_select_out = " $sql_select  where $sqlstr  and  stud_study_cond <> 0   order by s.stud_id DESC ";
    	 $data_array_out = get_stud_data($sql_select_out) ;
    	 $have_out = 1 ;
    }	
        	
   }     




//�ϥμ˪�
$template_dir = $SFS_PATH."/".get_store_path()."/templates";
// �ϥ� smarty tag
$smarty->left_delimiter="{{";
$smarty->right_delimiter="}}";
//$smarty->debugging = true;


$smarty->assign("data_array_in",$data_array_in); 
$smarty->assign("data_array_out",$data_array_out); 
//�O�_�����
$smarty->assign("have_in",$have_in);
$smarty->assign("have_out",$have_out); 

$smarty->assign("template_dir",$template_dir);

$smarty->display("$template_dir/search.htm");

foot();





function get_stud_data($sql_select)  {
	global $CONN ; 
	$class_year_p = class_base(); //�Z��
       $result = $CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256) ; 

       while ($row =  $result->FetchRow() ) {
       	  unset($tmp_row) ;
       	  $stud_id = $row["stud_id"]; 
        	$tmp_row[stud_id] = "<a href=\"stu_list.php?stud_id=$stud_id\">$stud_id</a>" ;
        	$tmp_row[stud_name] = $row["stud_name"];
        	$tmp_row[stud_person_id] = $row["stud_person_id"];
        	$tmp_row[stud_study_cond]  = $row["stud_study_cond"] ;
        	$tmp_row[s_birthday] = DtoCh($row["stud_birthday"]) ; 
        	$tmp_row[s_home_phone]=$row["stud_tel_1"];	  //�a���q��
        	$class_num_curr = $row["curr_class_num"];		//�ثe�Z�šB�y��

        	$classid = intval(substr($class_num_curr,0,3));	//���o�Z��	
        	$tmp_row[s_classname] = $class_year_p[$classid] ;
        	$tmp_row[s_num] = intval (substr($class_num_curr,-2));	//�y��
        	if ($tmp_row[stud_study_cond] == 0) {
             $c_curr_class = sprintf("%03s_%s_%02s_%02s",curr_year(),curr_seme(),substr($class_num_curr,0,1),substr($class_num_curr,1,2));
             $tmp_row[link] = "<a href=\"../stud_base/stud_base.php?stud_id=$stud_id&c_curr_class=$c_curr_class&c_curr_seme=$c_curr_seme\">�򥻸��</a>" ;
          }else 
             $tmp_row[link] ="(�D�b��)" ;
                  	  	
       	
        	$tmp_row[d_guardian_name] =$row["guardian_name"]  ;
        	$tmp_row[fath_name] =$row["fath_name"]  ;
        	$tmp_row[moth_name] =$row["moth_name"]  ;
          $data_array[] =  $tmp_row ;
          	
       }   	
  return $data_array ;       
       
}	
?>