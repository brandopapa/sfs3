<?php

// $Id: signin.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";

sfs_check();
$session_tea_sn =  $_SESSION['session_tea_sn'] ;


$Submit = $_POST['Submit'] ;
$class_num = $_POST['class_num']?$_POST['class_num']:$_GET['class_num'] ;
$id = $_GET["id"]?$_GET['id']:$_POST['id'] ;
$show_inp = $_POST["show_inp"] ;

if ($Submit=="���W") {

    $txt_stud = $_POST['txt_stud'] ;
    $class_num = $_POST['class_num'] ;
    $kid = $_POST['kid'] ;

    //���o�w���W�H�ƧP�_
    $sqlstr = " select count(*) as cc from stud_team_sign where kid= '$kid' " ;
    $result =  $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;            
  
    $row = $result->FetchRow() ;
    $cc = $row["cc"] ;  
    
    if ($cc < ($_POST['stud_max'] +  $_POST['stud_ps'] ) ){ //�|�i���W
       if ( $cc >= $_POST['stud_max'])  //���ƨ�
          $bk_fg =1 ;         
    
        $stud_data = Get_stud_data ($class_num ,  $txt_stud ) ; //���o�m�W�ζפJ���   
        
        $stud_name = addslashes($stud_data[0]) ; 	
        $stud_id = $stud_data[1] ; 		
        if ($stud_name ) {
           $sqlstr = " insert into stud_team_sign 
                (sid  ,kid,class_id ,stud_name,stud_id ,bk_fg   ) 
                 values (0,'$kid','$class_num','$stud_name','$stud_id', '$bk_fg') " ;       
           //echo  $sqlstr ;     
           $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;       
        }
              
    }
}


      
//===================================================================



$class_base_p = class_base();

$SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'] ;

if ( checkid($SCRIPT_FILENAME,1)){
   if (!isset($class_num) ) 
      $class_num = "601" ;	 

 //�޲z�̥i�H������
    $class_num_temp .= "<form><p align=center>�Z�� :<select name=\"class_num\" onchange=\"this.form.submit()\">\n";
		foreach ($class_base_p as $key => $value) {
			if ($key == $class_num)
				$class_num_temp .= "<option value=\"$key\" selected>$value</option>\n";
			else
				$class_num_temp .= "<option value=\"$key\">$value</option>\n";							
		}
    $class_num_temp .= "</select></p>
                        <input type='hidden' name='id' value='$id'> 
                       </form>" ;
    $is_admin = true ; 
}
else {
	//���o�Юv�ҤW�~�šB�Z��
	$query =" select class_num  from teacher_post  where teacher_sn  ='$session_tea_sn'  ";
	$result =  $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256) ; 

	$row = $result->FetchRow();
	$class_num = $row["class_num"];
	 
	if ($class_num <= 0)    {
	   Header("Location: index.php");
	   exit ;
	}	
	$class_num_temp = "<p align=center>" . $class_base_p[$class_num] ."</p>";
	$is_admin = false ; 
}

if ($_GET["do"]=="del") {
   if (($class_num == $_GET[class_num]) or $is_admin) {
   	$sqlstr = " delete from stud_team_sign where sid ='$_GET[sid]' " ;
   
        //echo  $sqlstr ;     
        $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;     
        //�O�_���ƨ��H���A�אּ����
           
   }	
        
}  

//=======================================================================

  head("�Z�ų����") ;
  echo '<link href="style.css" rel="stylesheet" type="text/css">' ;
  

	
  print_menu($school_menu_p);
  
  $main = Input($id) ;
  echo $class_num_temp ;
  echo $main ;
   foot() ;
   
   
//----------------------------------------------------------------------------

function Input($id) {
    global $CONN ,$PHP_SELF ,$class_base_p ,$class_num   ;
    
    $y = substr($class_num,0,1) ;

   //�U�~���Z�w���W�H��
   $sqlstr =" select kid , count(*) as cc   from stud_team_sign   group by kid order by kid DESC " ;
   $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
   while (  $row = $result->FetchRow() ) {
      $kid = $row["kid"] ;  
      $studs[$kid] =  $row["cc"] ;  
   }     
   
   //�C�X�U�~���Z��� 
    $sqlstr =" select *  from stud_team_kind   where mid = '$id' and ((year_set like '%$y%') or (year_set='0') ) " ;
	//echo $sqlstr ;
    $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
    $i = 1 ;
    while (  $row = $result->FetchRow() ) {
      $kid = $row["id"] ;
      $mid = $row["mid"] ;
      $class_kind = $row["class_kind"] ;
      $teach = $row["teach"] ;
      $stud_max = $row["stud_max"] ;
      $stud_ps = $row["stud_back"] ;
      $class_max = $row["class_max"] ;
      $week_set = $row["week_set"] ;
      $year_set = $row["year_set"] ;      
      $doc = $row["doc"] ;
      $cost = $row["cost"] ;
      if (!isset($studs[$kid]))
         $studs[$kid] =0 ;  
         
      //�i�_���W   
      if ($studs[$kid]>=($stud_max+$stud_ps)) {
      	 $form_input ="�w�B��" ;
      }	elseif ($studs[$kid]>=$stud_max) {
      	$form_input = "<input name='txt_stud' type='text' id='txt_stud' size='8' maxlength='8'> 
        <input type='submit' name='Submit' value='�ƨ����W'> 
        <input type='hidden' name='kid' value='$kid'>
        <input type='hidden' name='stud_max' value='$stud_max'>
        <input type='hidden' name='stud_ps' value='$stud_ps'>
        <input type='hidden' name='class_num' value='$class_num'>" ;
      }	else {
        $form_input = "<input name='txt_stud' type='text' id='txt_stud' size='8' maxlength='8'> 
        <input type='submit' name='Submit' value='���W'> 
        <input type='hidden' name='kid' value='$kid'>
        <input type='hidden' name='stud_max' value='$stud_max'>
        <input type='hidden' name='stud_ps' value='$stud_ps'>
        <input type='hidden' name='class_num' value='$class_num'>" ;
      }
   $main .= "      
<form name='form1' method='post' action=''>
  <h3 align='center'>�Z�O�G$class_kind </h3>
  <table width='95%' border='1' align='center' cellspacing='0'>
    <tr class='tr-t'> 
      <td width='8%'>�v��</td>
      <td width='17%'>����</td>
      <td width='10%'>�H�ƤW��(�ƨ�)</td>
      <td width='12%'>�W�Ҥ�O</td>
      <td width='12%'>�w���W</td>
      <td width='26%'>���W�y���Ωm�W:</td>
    </tr>
    <tr> 
      <td>$teach</td>
      <td>$doc</td>
      <td>$stud_max ($stud_ps)</td>
      <td>$week_set</td>
      <td>$studs[$kid]�H<a href='view.php?kid=$kid&stud_max=$stud_max&stud_ps=$stud_ps&class_kind=$class_kind' target='new'>�d��</a></td>
      <td>$form_input </td>
    </tr>
  </table>" ;
  

      
      
//---------------------------------------------------------
    $stud_list ="" ;
    //�Z�W���W���
    $sqlstr =" select *  from stud_team_sign where kid  = '$kid' and class_id ='$class_num'  " ;
	//echo $query ;
    $result2 = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
    while ($row2 = $result2->FetchRow() ) {
        $sid = $row2["sid"] ;	
        $stud_name = $row2["stud_name"] ;
        $bk_fg  = $row2["bk_fg "] ;
        
        if ($bk_fg) {
           $stud_list .=    "$stud_name(��) <a href=$PHP_SELF?sid=$sid&do=del&id=$id&kid=$kid&class_num=$class_num>�R</a> , " ;  
        } else {
           $stud_list .=    "$stud_name<a href=$PHP_SELF?sid=$sid&do=del&id=$id&kid=$kid&class_num=$class_num><img src='images/button_drop.png' border =0 alt='�R��'></a> , " ;     
        }                  

    }
  
  
  $main .= " 
  &nbsp;&nbsp;&nbsp;&nbsp;�Z�W�w���W: $stud_list 
</form><hr> " ;      
  } //while

  return  $main ;
}
