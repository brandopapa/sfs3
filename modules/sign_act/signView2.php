<?php

// $Id: signView2.php 7710 2013-10-23 12:40:27Z smallduh $

include "config.php";

sfs_check();

$SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'] ;
$Submit = $_POST['Submit'] ;


if ( !checkid($SCRIPT_FILENAME,1)){
    Header('Location: index.php'); 
}

if ($Submit == "�ץXexcel�榡��") {
   $id = $_POST['id'] ;
   $empt_list= $_POST['empt_list'] ;
   dl_csv($id ,$empt_list) ;

}   

$PHP_SELF = $_SERVER["PHP_SELF"] ;   
$id = $_GET['id'] ;

if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
}
   
head("���W���") ;
print_menu($menu_p);
if ($id)
   $main = ShowView($id) ;
else 
   $main = DoList() ;   
   
   
echo $main ;
foot() ;

function DoList() {
  global $PHP_SELF ,$CONN ;	
  //��ܦU�����	
  $sqlstr = " select * from  sign_act_kind   " ;
  $result =  $CONN->Execute($sqlstr) ;  
  
  $main = "<table cellSpacing=0 cellPadding=4 width='80%' align=center border=1 bordercolor='#33CCFF' bgcolor='#CCFFFF'>
          <tr bgcolor='#66CCFF'><td>����</td><td>�޲z</td></tr>\n" ;

  if($result) {
	while ($row=$result->FetchRow()) {        
  	  $title = $row["act_name"] ;
  	  $id = $row["id"] ;
  	  $main .= "<tr><td>$title</td><td><a href='$PHP_SELF?id=$id'>���W���</a> - 
  	  <a href='sign_act_Admin.php?id=$id&do=edit'>�ק���W��</a></td>
  	  </tr>" ;
  	}  
  	
  }	
  $main .= "</table> \n" ;
  return $main ;
}	

function ShowView($id) {
  global $PHP_SELF ,$member_set_arr , $member_set ,$CONN;	
  
  //���W����
  $sqlstr = " select * from  sign_act_kind where id = '$id'  " ;
  $result =  $CONN->Execute($sqlstr) ;  
  $row = $result->FetchRow() ;
      //$id = $row["id"] ;	
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
   

  //���� (�H��)   
  $tmparr = split (",", $member_set) ;      //����*1,�a��*2,����*1,����*4
  for ($i= 1 ; $i <= count($tmparr) ; $i++) {
    if ($tmparr[$i-1]<>"") {
      	$ni = $i ;	  
  	$tmp_arr1 = split ("\*",$tmparr[$i-1]) ;    
  	$member_set_arr[] = $tmp_arr1 ;
    } 	  
  }  
  
  //��� (�ۦ��J)   
  $tmparr = split (",", $fields_set) ;      //�������r��|10|�w�]��|����,�ͤ�|6|�w�]��|����
  $fields_count = count($tmparr) ;
  for ($i= 1 ; $i <= count($tmparr) ; $i++) {
    if ($tmparr[$i-1]<>"") {
      	$ni = $i ;	  
  	$tmp_arr1 = split ("##",$tmparr[$i-1]) ;    
  	$fields_set_arr[] = $tmp_arr1 ;
    } 	  
  }    
  
  $main .=  "<form name='form1'  method='post' >
    <input type='hidden' name='id' value='$id'>
    <div align='center'>
    <input type='checkbox' name='empt_list' value='1' checked>���������W���
    <input type='submit' name='Submit' value='�ץXexcel�榡��'>
    </div>
   </form>\n" ;
  
  //���D�C
  $main .= "<table cellSpacing=0 cellPadding=4 width='100%' align=center border=1 bordercolor='#33CCFF' bgcolor='#CCFFFF'>
          <tr bgcolor='#66CCFF'>
          <td>�զW</td><td>�էO</td><td>�m�W</td>" ;
  //���        
     for($i=1 ; $i < $fields_count ; $i++) {
           $main .= "<td>" . $fields_set_arr[$i-1][0] ."</td>\n" ; 
     }  
  $main .="</tr>\n" ;
  
  //��ܳ��W����U�����	
  $sqlstr = " select * from  sign_act_data where pid='$id' order by school_name ,team_id   " ;
  $result =  $CONN->Execute($sqlstr) ;  

  while ($row = $result->FetchRow() ) {
      $did_arr = $row["did"] ;	
      $team_id = $row["team_id"] ;	
      $set_passwd = $row["set_passwd"] ;	

      $school_name = $row["school_name"] ;
      $data = $row["data"] ;	
	

      //���    
      $member_data_arr="" ;
      $tmparr = split (",", $data) ;      //(�m�W|���1|���2,�m�W|���1|���2)
      for ($i= 1 ; $i <= count($tmparr) ; $i++) {
            //if ($tmparr[$i-1]) { //����Ƥ~�X�{
          	    $tmp_arr1 = @split ("##",$tmparr[$i-1]) ;    
          	    $member_data_arr[] = $tmp_arr1 ;
          	    if ($member_data_arr[$i-1][0]) {  //���m�W
                  	    $main .= "<tr><td>$school_name<br>$set_passwd</td><td>$team_id</td> \n" ;
                  	    $main .="<td>" .$member_data_arr[$i-1][0] ."</td>\n" ;
                  	    for ($j =1 ; $j < $fields_count ; $j++) {
                  	       $main .= "<td>" . $member_data_arr[$i-1][$j] ."</td>\n"; 
                  	    }    
                  	    
                  	     $main .= "</tr>\n" ;
          	    }
      	    //} 
      }    
      //$main .="</tr>\n" ;
  }	
  return $main ;
}

//�U���з�csv��
    
function dl_csv($id ,$empt_list){
  global $PHP_SELF ,$member_set_arr , $member_set ,$CONN;	
  
  //���W����
  $sqlstr = " select * from  sign_act_kind where id = '$id'  " ;
  $result =  $CONN->Execute($sqlstr) ;  
  $row = $result->FetchRow() ;
      //$id = $row["id"] ;	
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
   

  //���� (�H��)   
  $tmparr = split (",", $member_set) ;      //����*1,�a��*2,����*1,����*4
  for ($i= 1 ; $i <= count($tmparr) ; $i++) {
    if ($tmparr[$i-1]<>"") {
      	$ni = $i ;	  
  	$tmp_arr1 = split ("\*",$tmparr[$i-1]) ;    
  	$member_set_arr[] = $tmp_arr1 ;
    } 	  
  }  
  
  //��� (�ۦ��J)   
  $tmparr = split (",", $fields_set) ;      //�������r��|10|�w�]��|����,�ͤ�|6|�w�]��|����
  $fields_count = count($tmparr) ;
  for ($i= 1 ; $i <= count($tmparr) ; $i++) {
    if ($tmparr[$i-1]<>"") {
      	$ni = $i ;	  
  	$tmp_arr1 = split ("##",$tmparr[$i-1]) ;    
  	$fields_set_arr[] = $tmp_arr1 ;
    } 	  
  }    

  
  //���D�C
  $main .= "<table   border=1 >
          <tr >
          <td>�զW</td><td>�էO</td><td>�m�W</td>" ;
  //���        
     for($i=1 ; $i < $fields_count ; $i++) {
           $main .= "<td>" . $fields_set_arr[$i-1][0] ."</td>\n" ; 
     }  
  $main .="</tr>\n" ;
  
  //��ܳ��W����U�����	
  $sqlstr = " select * from  sign_act_data where pid='$id' order by school_name ,team_id   " ;
  $result =  $CONN->Execute($sqlstr) ;  

  while ($row = $result->FetchRow() ) {
      $did_arr = $row["did"] ;	
      $team_id = $row["team_id"] ;	
      $set_passwd = $row["set_passwd"] ;	

      $school_name = $row["school_name"] ;
      $data = $row["data"] ;	
	

      //���    
      $member_data_arr="" ;
      $tmparr = split (",", $data) ;      //(�m�W|���1|���2,�m�W|���1|���2)
      for ($i= 1 ; $i <= count($tmparr) ; $i++) {
            //if ($tmparr[$i-1]) { //����Ƥ~�X�{
          	    $tmp_arr1 = @split ("##",$tmparr[$i-1]) ;    
          	    $member_data_arr[] = $tmp_arr1 ;
          	    if ($member_data_arr[$i-1][0]) {  //���m�W
                  	    $main .= "<tr><td>$school_name</td><td>$team_id</td> \n" ;
                  	    $main .="<td>" .$member_data_arr[$i-1][0] ."</td>\n" ;
                  	    for ($j =1 ; $j < $fields_count ; $j++) {
                  	       $main .= "<td>" . $member_data_arr[$i-1][$j] ."</td>\n"; 
                  	    }    
                  	    
                  	     $main .= "</tr>\n" ;
          	    }
      	    //} 
      }    
      //$main .="</tr>\n" ;
  }	

	$filename ="sign_data.xls" ;
	
	//�H��y�覡�e�X ooo.csv

	header("Content-disposition: filename=$filename");
	header("Content-type: application/octetstream");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");

	
	header("Expires: 0");
	echo "<html>$main </html>";
	exit;
	return;  
}              
?>