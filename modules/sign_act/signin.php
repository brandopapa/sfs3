<?php
// $Id: signin.php 8681 2015-12-25 02:59:43Z qfon $

include "config.php";

  //�n�J�{��
  //session_start(); 
  //session_register("School_passwd"); 
  //session_register("schoolname"); 
  
$passwd = $_SESSION['School_passwd'] ;
$school_name = $_SESSION['schoolname'] ;
$PHP_SELF = $_SERVER['PHP_SELF'] ;  
$did = $_GET['did'] ;  
$Submit = $_POST['Submit'] ;
$do = $_GET['do'] ;

if ($did > 0) {
  
  $pid = $_GET['id'] ;     
  $school_name = $_GET['school_name'] ;    
} 

if ($Submit == "�n�J") {  
   $dd_passwd = $_POST['dd_passwd'] ; 
   $school_name = $_POST['school_name'] ;     
   $pid = $_POST['pid'] ; 
   $_SESSION['School_passwd'] = $dd_passwd ; 
   $_SESSION['schoolname'] = $school_name ; 
   $passwd =  strval($dd_passwd) ; 
}
  
if ($Submit=="�s�W") {

   $txtname = $_POST['txtname'] ;
   $team_name = $_POST['team_name'] ;
   $data = $_POST['data'] ;
   $max_fields = $_POST['max_fields'] ;
   $id = $_POST['id'] ;
   $school_name = $_POST['school_name'] ;
   $op = $_POST['op'] ;
   $my_passwd = $_POST['my_passwd'] ;
   
   //�ӤH���     
   for ($i = 0 ; $i < count($txtname); $i++) {
        $group_row[$i] .= $txtname[$i] ;
        for ($f = 0 ; $f < $max_fields ; $f++) 
           $group_row[$i] .= "##" .  $data[$i][$f] ;
   }     
   $groupdata = implode("," , $group_row ) ;
      
   $sqlstr = " insert into sign_act_data  
            (did ,pid,school_name,team_id,set_passwd,data ) 
             values (0,'$id','$school_name', '$team_name','$op', '$groupdata' ) " ;
             

   $result =  $CONN->Execute($sqlstr) ;  
  
  //�]�w�K�X
  if ($my_passwd) { 
      $sqlstr = " update sign_act_data  set set_passwd ='$my_passwd' where school_name ='$school_name' and pid ='$id' " ;
      $result =  $CONN->Execute($sqlstr) ;     
      $_SESSION['School_passwd'] = $my_passwd ; 
      $passwd =  $my_passwd ; 
  }
  $pid = $id ;
}

if ($Submit=="�ק�") {
   $txtname = $_POST['txtname'] ;
   $team_name = $_POST['team_name'] ;
   $data = $_POST['data'] ;
   $max_fields = $_POST['max_fields'] ;
   $id = $_POST['id'] ;
   $school_name = $_POST['school_name'] ;
   $op = $_POST['op'] ;
   $my_passwd = $_POST['my_passwd'] ;
   $did = $_POST['did'] ;
      
   //�ӤH���     
   for ($i = 0 ; $i < count($txtname); $i++) {

        $group_row[$i] .= $txtname[$i] ;
        for ($f = 0 ; $f < $max_fields ; $f++) 
           $group_row[$i] .= "##" .  $data[$i][$f] ;

   }     
   $groupdata = implode("," , $group_row ) ;
      
   $sqlstr = " update sign_act_data set team_id ='$team_name' ,data ='$groupdata',set_passwd ='$op'  where did = '$did' " ;
   $result = $CONN->Execute($sqlstr) ;  
   
  //�]�w�K�X
  if ($my_passwd) { 
      $sqlstr = " update sign_act_data  set set_passwd ='$my_passwd' where school_name ='$school_name' and pid ='$id' " ;
      $result =  $CONN->Execute($sqlstr) ;      
      $_SESSION['School_passwd'] = $my_passwd ; 
      $passwd =  $my_passwd ; 
  }  
  $do ="" ;
  $pid = $id ;
}

if ($do=="del") {
   $sqlstr = "delete  from sign_act_data  where did = $did " ;
   $result =  $CONN->Execute($sqlstr) ;  
}	
if ($do=="add") {
  $pid = $_GET['id'] ;     
  $school_name = $_GET['school_name'] ;  
}	





if ($pid)
  $main1 =  showdata($pid , $school_name) ;
  
if ($passwd === $def_passwd)  //�w�]�K�X
         $must_passwd = TRUE ; 	//���ݭn���K�X	
else 
  $must_passwd = FALSE ;       


  $main2 = input_data($pid , $school_name ,$did , $do ) ;
    if  ($set_passwd) {  		//�w���K�X
        $must_passwd = FALSE ; 	//���ݭn���K�X	
       if ($passwd !== $set_passwd)    	//�K�X�����T
         Header('Location: index.php'); 
         
    } else { 
      if ($passwd === $def_passwd)  //�w�]�K�X
         $must_passwd = TRUE ; 	//���ݭn���K�X	

//      else 
  //       Header('Location: index.php'); 	
    }  

  head("���W��") ;
  print_menu($menu_p);
  
  echo $main1 ;
  echo $main2 ;
   foot() ;
  //----------------------------------------------------------------------------


function showdata($pid , $school_name) {
  	
  global $CONN, $team_set_arr ,$member_set_arr ,$fields_set_arr ,$PHP_SELF , $max_team ,$have_team ,$def_passwd , $set_passwd ,$max_each;      
  $pid=intval($pid);
  //���W���`�� ===============================
  $sqlstr = " select * from  sign_act_kind where  id ='$pid' " ;

  $result =  $CONN->Execute($sqlstr) ; 
  $row = $result->FetchRow() ;
      $id = $row["id"] ;	
      $beg_date = $row["beg_date"] ;	
      $end_date = $row["end_date"] ;	
      $doc = $row["act_doc"] ;	
      $title = $row["act_name"] ;
      $act_passwd = $row["act_passwd"] ;
      $team_set = $row["team_set"] ;
      $max_team = $row["max_team"] ;
      $max_each = $row["max_each"] ;
      $member_set = $row["member_set"] ;
      $fields_set = $row["fields_set"] ;     
      $def_passwd = $row["act_passwd"] ;     
      

        
  //�էO    
  $tmparr = split (",", $team_set) ;  
  for ($i= 1 ; $i <= count($tmparr) ; $i++) {
    if ($tmparr[$i-1]<>"") {
      	$ni = $i ;	  
  	$tmp_arr1 = split ("##",$tmparr[$i-1]) ;  //�ҲզW|�k�m����,�A��|�k��  
  	$team_set_arr[] = $tmp_arr1 ;
    } 	  
  }

  //����    
  $tmparr = split (",", $member_set) ;      //����*1,�a��*2,����*1,����*4
  for ($i= 1 ; $i <= count($tmparr) ; $i++) {
    if ($tmparr[$i-1]<>"") {

      	$ni = $i ;	  
  	$tmp_arr1 = split ("\*",$tmparr[$i-1]) ;    
  	$member_set_arr[] = $tmp_arr1 ;

  	$group_man += $member_set_arr[$i-1][1] ;
    } 	  
  }  
  
  //���    
  $tmparr = split (",", $fields_set) ;      //�������r��|10|�w�]��|����,�ͤ�|6|�w�]��|����
  for ($i= 1 ; $i <= count($tmparr) ; $i++) {
    if ($tmparr[$i-1]<>"") {
      	$ni = $i ;	  
  	$tmp_arr1 = split ("##",$tmparr[$i-1]) ;    
  	$fields_set_arr[] = $tmp_arr1 ;
    } 	  
  }    

  //�Ӯժ����W���======================================================================
  $sqlstr = " select * from  sign_act_data where  pid ='$id'   and school_name ='$school_name' order by did " ;
  $result = $CONN->Execute($sqlstr);  
  

  $mi=0 ;
  while($row =$result->FetchRow()) {
      $did_arr[] = $row["did"] ;	
      $team_id[] = $row["team_id"] ;	
      $set_passwd = $row["set_passwd"] ;	
      $data = $row["data"] ;	

      //���    
      $tmparr = split (",", $data) ;      //(�m�W|���1|���2,�m�W|���1|���2)
      for ($i= 1 ; $i <= count($tmparr) ; $i++) {
      	    $tmp_arr1 = @split ("##",$tmparr[$i-1]) ;    
      	    $member_data_arr[$mi][] = $tmp_arr1 ;
 
      }    
      $mi++ ;
      $have_team ++ ;
  }
  
  $add_link = "$PHP_SELF?id=$id&school_name=$school_name&do=add" ; 
  
  $main = "<h2 align='center'>$school_name �w���W�էO���</h2><a href='$add_link'>�s�W�@��</a>
  <table width='100%' border='1' cellspacing='0' cellpadding='4' bgcolor='#CCFFFF' bordercolor='#33CCFF'>
  <tr bgcolor='#66CCFF'> 
     <td>�B�z</td><td>�s��</td><td>�էO</td>\n " ;
     //����

     $main .="</tr>\n" ;
     $edit_img = "<image src = 'images/medit.gif' border='0' alt='�ק�'>�ק�" ;
     $del_img = "<image src = 'images/delete.gif' border='0'  alt='�R��'>�R��" ;
     //��ƦC��
     for ($r = 0 ; $r < count($team_id) ; $r++ ) {
         $link = "$PHP_SELF?id=$id&school_name=$school_name&did=$did_arr[$r]" ; 
         $main .= "<tr><td><a href='$link&do=edit'>$edit_img<a> | <a href='$link&do=del'>$del_img<a></td><td>$did_arr[$r]</td><td>$team_id[$r]</td>\n" ;
         $main .="</tr>\n" ;   
    }
/*     
     //����
     for($i=0 ; $i < count($member_set_arr) ; $i ++) {
        for ($m = 0 ; $m < $member_set_arr[$i][1] ; $m ++) {
            $main .= "<td>" . $member_set_arr[$i][0] ."</td>\n" ; 
        }
     }   
     $main .="</tr>\n" ;
     $edit_img = "<image src = 'images/medit.gif' border='0' alt='�ק�'>�ק�" ;
     $del_img = "<image src = 'images/delete.gif' border='0'  alt='�R��'>�R��" ;
     //��ƦC��
     for ($r = 0 ; $r < count($team_id) ; $r++ ) {
         $link = "$PHP_SELF?id=$id&school_name=$school_name&did=$did_arr[$r]" ; 
         $main .= "<tr><td><a href='$link&do=edit'>$edit_img<a> | <a href='$link&do=del'>$del_img<a></td><td>$did_arr[$r]</td><td>$team_id[$r]</td>\n" ;
         for($i=0 ; $i < count($member_data_arr[$r]) ; $i ++) {

                $main .= "<td>" . $member_data_arr[$r][$i][0] ."</td>\n" ; 

        }    
        $main .="</tr>\n" ;   
    }
    $main .="</table>
*/  
    
    $main .="</table>     
  
    <p ><a href='sign_paper.php?pid=$pid' target='paper'>�C�L���W�`��</a></p>

    <hr>\n" ;
    
    return $main ;
}    



//==========================================================================================
function input_data($pid , $school_name , $did = 0 , $do="") {
   global $CONN, $team_set_arr ,$member_set_arr ,$fields_set_arr ,$PHP_SELF , $max_team ,$have_team ,$must_passwd , $set_passwd ,$max_each;     
   
   
  //�Ӯժ����W���======================================================================
  if ($did>0  and $do =="edit" ){
	  $did=intval($did);
      $sqlstr = " select * from  sign_act_data where  did ='$did' " ;

      $result = $CONN->Execute($sqlstr)  ;  
      while($row = $result->FetchRow()) {
          $did = $row["did"] ;	
          $pid = $row["pid"] ;
          $team_id = $row["team_id"] ;	
          $set_passwd = $row["set_passwd"] ;	
          $data = $row["data"] ;	
          
          $edit_fg = TRUE ;
          
          //���    
          $tmparr = split (",", $data) ;      //(�m�W|���1|���2,�m�W|���1|���2)
          for ($i= 1 ; $i <= count($tmparr) ; $i++) {
              	$tmp_arr1 = split ("##",$tmparr[$i-1]) ;    
              	$member_data_arr[] = $tmp_arr1 ;
      
          } 

      }   
  }
  
  $max_fields = count($fields_set_arr) ; //�B�~����
  
  if ($team_id) {
     $title ="�ק�էO(��J����n���U'�ק�'��)" ;
     $button_name ="�ק�" ;
  }else{ 
     $title ="�s�W�@��(��J����n���U'�s�W'��)" ;
     $button_name ="�s�W" ;
  }   
  
  
$main ="<script language='JavaScript'>

function chk_empty(item) {
   if (item.value=='') { return true; } 
}

function check() { 
   var errors='' ;
   
   if (chk_empty(document.myform.my_passwd))  {
      errors = '�Ĥ@���@�w�n�]�w�s�K�X�I' ; }

   if (errors) alert (errors) ;
   document.returnValue = (errors == '');
 
}

</script>" ;

if ($must_passwd)  
   $onSubmit = " onSubmit='check();return document.returnValue' " ;
 
if ($do=='edit' or $do =='add')   {
//���P�_�O�_���W�L�U�եi���ռ� 
$sqlstr = " select team_id ,count(*) as cc  from  sign_act_data where  school_name ='$school_name' and pid ='$pid'  group by  team_id " ;
//echo $sqlstr ;


$result = $CONN->Execute($sqlstr)  ;  
while($row = $result->FetchRow()) {
   $team_id_have[] = $row["team_id"] ;	 
   $team_id_cc[$row["team_id"]] =$row["cc"] ;	 
   //echo $team_id_cc[$row["team_id"]] 
   
}          
$main .= "<form name='myform' method='post' action='$PHP_SELF'  $onSubmit >
  <h2 align='center'>$title</h2>
  <table width='98%' border='1' cellspacing='0' cellpadding='0' align='center' bgcolor='#99CCFF' bordercolor='#CCFFFF'>
    <tr> 

      <td width='84%'> �ѥ[�էO :

       <select name='team_name'>\n" ;
       for ($i = 0 ; $i < count($team_set_arr) ; $i++ ) {
       	   if ($team_id == $team_set_arr[$i][0] ) 
       	     $main .= " <option value='" . $team_set_arr[$i][0] . "' selected>" .$team_set_arr[$i][0] ."</option>\n" ;
       	   else {
       	     $tt =  $team_set_arr[$i][0] ;
       	     //echo $tt ;
       	     if (($team_id_cc[$tt] < $max_each  )and  ( !in_array($team_set_arr[$i][0] ,$team_id_have)) ) 
                $main .= " <option value='" . $team_set_arr[$i][0] . "' >" .$team_set_arr[$i][0] ."</option>\n" ;       	    
       	     /*
       	     if ( !in_array($team_set_arr[$i][0] ,$team_id_have) ) 
                $main .= " <option value='" . $team_set_arr[$i][0] . "' >" .$team_set_arr[$i][0] ."</option>\n" ;
             */
           }     
       }
       
       $main .=" </select> 
        �]�w�K�X:<input type='text' name='my_passwd' size ='10' >" ;
       if ($must_passwd) 
          $main .=" <font color='#FF0000'>(�����n�]�s�K�X)</font>" ;
      $main .= "</td>
    </tr>
    <tr> 
      <td width='84%'> 
        <table width='100%' border='1' cellspacing='0' cellpadding='0' bgcolor='#CCFFFF' bordercolor='#33CCFF'>
          <tr bgcolor='#66CCFF'> 
            <td width='21%'>�W��</td>
            <td >�m�W</td>" ;
             for ($f = 0 ; $f< count($fields_set_arr) ; $f++ ) 
                $main .="<td>" . $fields_set_arr[$f][0] ."</td>\n" ; //�U�����
                       
          $main .="</tr>\n" ;
       $mj = 0 ;   
       for($m =0 ; $m < count($member_set_arr) ; $m++ ) 
          for($mi = 0 ; $mi < $member_set_arr[$m][1] ; $mi++) {
            if ($member_set_arr[$m][1]  > 1 )  //�H�Ƥj��@
               $strNum = $mi+1 ;
            else 
               $strNum = "" ;      
            $main .="<tr><td>" . $member_set_arr[$m][0] ."$strNum</td>\n" ;
            $main .="<td> <input type='text' name='txtname[]' value='" . $member_data_arr[$mj][0] ."'> </td>\n" ; //�m�W
            for ($f = 0 ; $f< count($fields_set_arr) ; $f++ ) 
                $main .="<td> <input type='text' name='data[$mj][$f]' value='" . $member_data_arr[$mj][$f+1] ."'> </td>\n" ; //�U�����
            
            $main .="</tr>\n" ;
            $mj ++ ;
          }                

        $main .= "</table>

      </td>

    </tr>

    <tr> 

      <td width='84%'> 

        <div align='center'>

          <input type='submit' name='Submit' value='$button_name'>
          <input type='hidden' name='did' value='$did'>
          <input type='hidden' name='must_passwd' value='$must_passwd'>
          <input type='hidden' name='id' value='$pid'>
          <input type='hidden' name='op' value='$set_passwd'>
          <input type='hidden' name='max_fields' value='$max_fields'>
          <input type='hidden' name='school_name' value='$school_name'>

        </div>

      </td>

    </tr>

  </table>

</form>" ;
}
  if (($have_team >= $max_team)  and ($button_name == "�s�W"))
     $main = "" ;
     
  return $main ;
}
