<?php

// $Id: sign_act_Admin.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";

sfs_check();

  $SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'] ;
  //echo $SCRIPT_FILENAME ;
  if ( !checkid($SCRIPT_FILENAME,1)){
      Header("Location: index.php"); 
  }  
  
//$SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'] ;
$PHP_SELF = $_SERVER["PHP_SELF"] ;

  //�����ǮզW��
  $nowdir =dirname( $_SERVER[SCRIPT_FILENAME] );             //�Ҧb�ؿ��A�H�ڥؿ�����
  //  $school_data = file($nowdir ."/school_name.txt") ;   
  if (is_file($nowdir ."/$SCHOOL_NAME_LIST")) 
       $school_data = file($nowdir ."/$SCHOOL_NAME_LIST") ;     
  else 
       $school_name = "�������w�ǮզC���ɮ� $SCHOOL_NAME_LIST �A���ˬd�ҲհѼƳ]�w�C" ;
  for ($i = 0 ; $i < count($school_data) ; $i++) { 
    $school_name .= $school_data[$i] ;
  }  

$Submit = $_POST['Submit'] ;



if ($Submit=="�M��") {
  $history_id = $_POST['history_id'] ;
  $sqlstr = " select *   from  sign_act_kind where id = '$_POST[history_id]' " ;
  //echo  $sqlstr ;
  $beg_date = $_POST['beg_date'] ;  
  $end_data = $_POST['end_data'] ;
  $recordSet =  $CONN->Execute($sqlstr) ;     
  while ( ($recordSet) and ( !$recordSet->EOF) ){         
      	//$act_name = $recordSet->fields["act_name"];
      	$act_doc = $recordSet->fields["act_doc"];
      	$act_passwd = $recordSet->fields["act_passwd"];
      	//$beg_date = $recordSet->fields["beg_date"];
      	//$begday = date("Y-m-d") ;
      	//$end_date = $recordSet->fields["end_date"];
      	$team_set = $recordSet->fields["team_set"];
      	$max_each = $recordSet->fields["max_each"];
      	$member_set = $recordSet->fields["member_set"];
      	$fields_set = $recordSet->fields["fields_set"];
      	$manager = $recordSet->fields["manager"];
      	$school_list = $recordSet->fields["school_list"];      	  
      	    	
      	$recordSet->MoveNext();    
      	
        $sqlstr2 = " insert into  sign_act_kind 
             (act_name,act_doc,act_passwd,beg_date, end_date ,team_set,max_team,max_each,member_set,fields_set,admin,manager,school_list) 
             values ( '$_POST[act_name]','$act_doc','$act_passwd','$beg_date','$end_data' ,'$team_set','$max_team','$max_each','$member_set','$fields_set','$admin','$manager','$school_list' ) " ;
       //echo $sqlstr2 ;
       $CONN->Execute($sqlstr2) ;     
 	
  }     
    
  $sqlstr = " select *   from  sign_act_kind  order by id DESC " ;
  $recordSet =  $CONN->Execute($sqlstr) ;    
  if ( $recordSet ) {
    $_GET['id'] = $recordSet->fields["id"] ;
    $_GET['do'] = "edit" ;
  }  
}   


if ($Submit=="�s�W") {
   $team_name = $_POST['team_name'] ;
   $team_doc = $_POST['team_doc'] ;
   
   $member_name = $_POST['member_name'] ;
   $member_num = $_POST['member_num'] ;
   
   $field_name = $_POST['field_name'] ;
   $field_width = $_POST['field_width'] ;   
   $field_val = $_POST['field_val'] ;
   $field_doc = $_POST['field_doc'] ;   
   
   $act_name = $_POST['act_name'] ;
   $doc = $_POST['doc'] ;   
   $txtpasswd = $_POST['txtpasswd'] ;
   $beg_date = $_POST['beg_date'] ;  
   $end_data = $_POST['end_data'] ;
   
   $all_max = $_POST['all_max'] ;     
   $each_max  = $_POST['each_max'] ;
   $manager = $_POST['manager'] ;             
   if ($_POST['chk_all'])
      $school_list= "" ;
   else 
      $school_list= $_POST['school_list'] ;   
   
   //����
   for ($i = 0 ; $i< count($team_name) ; $i++) {
   	if (!$team_name[$i]) break ;
       $team_set .= "$team_name[$i]##$team_doc[$i]," ;
   }
   
   //����
   for ($i = 0 ; $i< count($member_name) ; $i++) {
   	if (!$member_name[$i]) break ;
       $member_set .= "$member_name[$i]*$member_num[$i]," ;
   }   
   
   //�B�~���
   for ($i = 0 ; $i< count($field_name) ; $i++) {
   	if (!$field_name[$i]) break ;
       $fields_set .= "$field_name[$i]##$field_width[$i]##$field_val[$i]##$field_doc[$i]," ;
   }    

   $sqlstr = " insert into sign_act_kind 
            (id ,act_name,act_doc,act_passwd,beg_date,end_date , team_set ,max_team ,max_each ,member_set ,fields_set ,manager , school_list) 
             values (0,'$act_name','$doc', '$txtpasswd','$beg_date', '$end_data' , '$team_set' , '$all_max','$each_max' ,'$member_set', '$fields_set' ,'$manager' ,'$school_list' ) " ;
   //echo  $sqlstr ;         
   $result = $CONN->Execute($sqlstr) ;    
   
   header('Location:index.php') ;
}	
if ($Submit=='�R��') {
   $id = $_POST['id'] ;   	
   //�ˬd�O�_�w�����W���
	
   $sqlstr = " select * from  sign_act_data where pid='$id'   " ;
   //echo $sqlstr ;
   $result =  $CONN->Execute($sqlstr) ;     
   $totalnum = $result->RecordCount() ;
   if ($totalnum == 0 ) {
     $sqlstr = " delete from sign_act_kind  where id = '$id' " ;

     $result = $CONN->Execute($sqlstr) ;    
     //echo $sqlstr ;
     header('Location:index.php') ;  	
   }  
	
}	

if ($Submit=='�ק�') {
   $team_name = $_POST['team_name'] ;
   $team_doc = $_POST['team_doc'] ;
   
   $member_name = $_POST['member_name'] ;
   $member_num = $_POST['member_num'] ;
   
   $field_name = $_POST['field_name'] ;
   $field_width = $_POST['field_width'] ;   
   $field_val = $_POST['field_val'] ;
   $field_doc = $_POST['field_doc'] ;   
   
   $act_name = $_POST['act_name'] ;
   $doc = $_POST['doc'] ;   
   $txtpasswd = $_POST['txtpasswd'] ;
   $beg_date = $_POST['beg_date'] ;  
   $end_data = $_POST['end_data'] ;
   
   $all_max = $_POST['all_max'] ;     
   $each_max  = $_POST['each_max'] ;
   $manager = $_POST['manager'] ;         
   $id = $_POST['id'] ;   
   
   if ($_POST['chk_all'])
      $school_list= "" ;
   else 
      $school_list= $_POST['school_list'] ;   
                 
   //����
   for ($i = 0 ; $i< count($team_name) ; $i++) {
   	if (!$team_name[$i]) break ;
       $team_set .= "$team_name[$i]##$team_doc[$i]," ;
   }
   
   //����
   for ($i = 0 ; $i< count($member_name) ; $i++) {
   	if (!$member_name[$i]) break ;
       $member_set .= "$member_name[$i]*$member_num[$i]," ;
   }   
   
   //�B�~���
   for ($i = 0 ; $i< count($field_name) ; $i++) {
   	if (!$field_name[$i]) break ;
       $fields_set .= "$field_name[$i]##$field_width[$i]##$field_val[$i]##$field_doc[$i]," ;
   }    

   $sqlstr = " update sign_act_kind  set act_name='$act_name',act_doc='$doc', act_passwd='$txtpasswd',
              beg_date='$beg_date', end_date='$end_data', team_set='$team_set' , manager= '$manager' ,
              max_team= '$all_max', max_each='$each_max' ,member_set='$member_set', fields_set='$fields_set', school_list='$school_list' where id = '$id' " ;

  $result = $CONN->Execute($sqlstr) ;    
  header('Location:index.php') ;  

}	

//=============================================================

$id = $_GET['id'] ;
$do = $_GET['do'] ;

if ($do=="edit" and ($id)) 
   $main = Edit($id,$do) ;
else 
    $main = AddNew() ;   



$begday = date("Y-m-d") ;
$endday = date("Y-m-") ;

  head("���W���]�p") ;
  print_menu($menu_p);
  
  echo $main ;

//=================================================================================
function AddNew() {
  global $CONN, $PHP_SELF ,$class_year , $STUD_FIELD ,$MAX_ITEM , $MAX_INPUT_FIELD ,$MAX_CAP ,$school_name ;
  
  $begday = date("Y-m-d") ;
  $endday = date("Y-m-") ;

  $sel_str = get_history() ;
  
  $main = "<form name='form1' method='post' action='$PHP_SELF'>
  <table cellSpacing=0 cellPadding=4 width='95%' align=center border=1 bordercolor='#CCFFFF' bgcolor='#99CCFF'>
    <tr bgcolor='#9999CC'> 
      <td width='20%'> ���ʦW�� </td>
      <td  colspan=2> 
        <input type='text' name='act_name' size='40'><br>
        �M��:$sel_str 
        <input type='submit' name='Submit' value='�M��'>
      </td>

    </tr>
    <tr bgcolor='#9999CC'>
      <td >���W���</td>
      <td  colspan=2 >�}�l:
        
      <input type='text' name='beg_date' size='10' value='$begday' >
        
        ����:
        
      <input type='text' name='end_data' size='10' value='$endday'>
      </td>    
    </tr>
    <tr> 
      <td width='15%'> ���� </td>
      <td width='42%'> 
      <textarea name='doc' cols='40' rows='4'></textarea>  

      </td>
      <td rowspan='3' valign='top'>
        �i���W�ǮաG
        <input type='checkbox' name='chk_all' value='1' checked>�����Ǯ� <br>
      
        <textarea name='school_list' rows='12' cols='20'>$school_name</textarea>      
      </td>         
    </tr>
    <tr> 
      <td width='15%'> ��l�K�X </td>
      <td width='42%'> 
        
      <input type='text' name='txtpasswd' maxlength='8' size='8'>
      </td>
    </tr>
    <tr> 
      <td width='15%'> �t�d�H��� </td>
      <td width='42%'> 
        
      <input type='text' name='manager' >
      </td>
    </tr>    
    <tr> 
      <td colspan='3'> �էO�W�� �A�C�էO����
        
      <input type='text' name='each_max' size='3' value='1'>
        �աA�C����`���ƭ�
      <input type='text' name='all_max' size='3' value='1'>
        �� 
        
      <table cellSpacing=0 cellPadding=0 width='100%' border=1 bordercolor='#33CCFF' bgcolor='#CCFFFF'>
        <tr bgcolor='#66CCFF'> 
          <td width='47'>����</td>
          <td width='42%'>�էO�W��</td>
          <td width='49%'>���� </td>
        </tr>
        " ;
        
        //����
        for ($i =0 ;$i< $MAX_ITEM ; $i++) {
          $j = $i+1 ;      
          $main .= "<tr><td width='9%'>$j</td>
           <td width='42%'> 
            <input type='text' name='team_name[]' size='20'>
          </td>
          <td width='49%'> 
            <input type='text' name='team_doc[]' size='20'>
          </td>
        </tr>" ;
        } ; 

      $main .= "</table>
      </td>
    </tr>
    <tr> 
      <td colspan='3'>�����զ�(�p�����B����)<br>
        
      <table cellSpacing=0 cellPadding=0 width='100%' border=1 bordercolor='#33CCFF' bgcolor='#CCFFFF'>
        <tr bgcolor='#66CCFF'> 
          <td width='47'>����</td>
          <td width='27%'>¾�����O�W</td>
          <td width='7%'>�H��</td>
        </tr>" ;
        
        
        //����
        for($i=0 ; $i < $MAX_CAP ; $i++) {
          $j = $i+1 ; 
         $main .="<tr> 
          <td width='6%'>$j</td>
          <td width='40%'> 
            <input type='text' name='member_name[]' size='8'>
          </td>
          <td width='54%'> 
            <input type='text' name='member_num[]' size='3' value='1'>
          </td>
        </tr>" ;
        }
      $main .= "</table>
      </td>
    </tr>
    <tr> 
      <td colspan='3'>�B�~�һݿ�J���<br>
        
      <table cellSpacing=0 cellPadding=0 width='100%' border=1 bordercolor='#33CCFF' bgcolor='#CCFFFF'>
        <tr bgcolor='#66CCFF'> 
          <td width='47'>����</td>
          <td width='27%'>���W</td>
          <td width='7%'>�e��</td>
          <td width='12%'>�w�]��</td>
          <td width='48%'>����</td>
        </tr>" ;
        
        //�B�~���
        for($i=0 ; $i < $MAX_INPUT_FIELD ; $i++) {
          $j = $i+1 ; 
         $main .="        <tr> 
          <td width='6%'>$j</td>
          <td width='27%'> 
            <input type='text' name='field_name[]' size='8'>
          </td>
          <td width='7%'> 
            <input type='text' name='field_width[]' maxlength='3' size='3' value='6'>
          </td>
          <td width='12%'> 
            <input type='text' name='field_val[]' size='8'>
          </td>
          <td width='48%'> 
            <input type='text' name='field_doc[]' size='20'>
          </td>
        </tr>" ;
        }
      $main .= "</table>
      </td>
    </tr>
    <tr> 
      <td colspan='2'> 
        <div align='center'> 
          <input type='submit' name='Submit' value='�s�W'>
          <input type='reset' name='Submit2' value='���]'>
        </div>
      </td>
    </tr>
  </table>

</form> " ;
  
  return $main ;

}

//=================================================================================
function Edit($id , $do) {
  global $CONN, $PHP_SELF ,$class_year , $STUD_FIELD ,$MAX_ITEM , $MAX_INPUT_FIELD ,$MAX_CAP ,$school_name;
  
  $sqlstr = " select * from  sign_act_kind where id = '$id'  " ;
  $result =  $CONN->Execute($sqlstr) ;  
  
  $row =  $result->FetchRow() ;
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
      $manager = $row["manager"] ;
      $school_list = $row["school_list"] ;
  
  //�����w�ǮաA�N�����
  if (!$school_list) {
    $school_list = $school_name ;
    $chk_all_str = "checked" ;
  }  
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
  
  $main = "<form name='form1' method='post' action='$PHP_SELF'>
  <table cellSpacing=0 cellPadding=4 width='90%' align=center border=1 bordercolor='#CCFFFF' bgcolor='#99CCFF'>
    <tr> 
      <td width='20%'> ���ʦW�� </td>
      <td width='42%'> 
        
      <input type='text' name='act_name' size='40' value='$title' >
      </td>
      <td rowspan='5' valign='top'>
        �i���W�ǮաG<br>
        <input type='checkbox' name='chk_all' value='1' $chk_all_str>�����Ǯ� <br>
      
        <textarea name='school_list' rows='12' cols='20'>$school_list</textarea>      
      </td>      
    </tr>
    <tr>
      <td width='20%'>���W���</td>
      <td width='42%'>�}�l:
        
      <input type='text' name='beg_date' size='10' value='$beg_date' >
        
        ����:
        
      <input type='text' name='end_data' size='10' value='$end_date'>
      </td>
    </tr>
    <tr> 
      <td width='20%'> ���� </td>
      <td width='42%'> 
      <textarea name='doc' cols='40' rows='2'>$doc</textarea>          

      </td>
    </tr>
    <tr> 
      <td width='20%'> ��l�K�X </td>
      <td width='42%'> 
        
      <input type='text' name='txtpasswd' maxlength='8' size='8' value='$act_passwd' >
      </td>
    </tr>
    <tr> 
      <td width='20%'> �t�d�H��� </td>
      <td width='42%'> 
        
      <input type='text' name='manager'  value='$manager' >
      </td>
    </tr>      
    <tr> 
      <td colspan='3'> �էO�W�� �A�C�էO����
        
      <input type='text' name='each_max' size='3' value='$max_each' >
        �աA�C����`���ƭ�
      <input type='text' name='all_max' size='3' value='$max_team' >
        �� 
        
      <table cellSpacing=0 cellPadding=0 width='100%' border=1 bordercolor='#33CCFF' bgcolor='#CCFFFF'>
        <tr bgcolor='#66CCFF'> 
          <td width='47'>����</td>
          <td width='42%'>�էO�W��</td>
          <td width='49%'>���� </td>
        </tr>
        " ;
        
        //����
        for ($i =0 ;$i< $MAX_ITEM ; $i++) {
          $j = $i+1 ;      
          $main .= "<tr><td width='9%'>$j</td>
           <td width='42%'> 
            <input type='text' name='team_name[]' size='20' value='" . $team_set_arr[$i][0] ."'>
          </td>
          <td width='49%'> 
            <input type='text' name='team_doc[]' size='20' value='". $team_set_arr[$i][1] ."'>
          </td>
        </tr>" ;
        } ; 

      $main .= "</table>
      </td>
    </tr>
    <tr> 
      <td colspan='3'>�����զ�(�p�����B����)<br>
        
      <table cellSpacing=0 cellPadding=0 width='100%' border=1 bordercolor='#33CCFF' bgcolor='#CCFFFF'>
        <tr bgcolor='#66CCFF'> 
          <td width='47'>����</td>
          <td width='27%'>¾�����O�W</td>
          <td width='7%'>�H��</td>
        </tr>" ;
        
        
        //����
        for($i=0 ; $i < $MAX_CAP ; $i++) {
          $j = $i+1 ; 
         $main .="<tr> 
          <td width='6%'>$j</td>
          <td width='40%'> 
            <input type='text' name='member_name[]' size='8' value='" . $member_set_arr[$i][0] . "'>
          </td>
          <td width='54%'> 
            <input type='text' name='member_num[]' size='3'  value='" . $member_set_arr[$i][1] . "' >
          </td>
        </tr>" ;
        }
      $main .= "</table>
      </td>
    </tr>
    <tr> 
      <td colspan='3'>�B�~�һݿ�J���<br>
        
      <table cellSpacing=0 cellPadding=0 width='100%' border=1 bordercolor='#33CCFF' bgcolor='#CCFFFF'>
        <tr bgcolor='#66CCFF'> 
          <td width='47'>����</td>
          <td width='27%'>���W</td>
          <td width='7%'>�e��</td>
          <td width='12%'>�w�]��</td>
          <td width='48%'>����</td>
        </tr>" ;
        
        //�B�~���
        for($i=0 ; $i < $MAX_INPUT_FIELD ; $i++) {
          $j = $i+1 ; 
         $main .="        <tr> 
          <td width='6%'>$j</td>
          <td width='27%'> 
            <input type='text' name='field_name[]' size='8' value='". $fields_set_arr[$i][0] ."' >
          </td>
          <td width='7%'> 
            <input type='text' name='field_width[]' maxlength='3' size='3' value='". $fields_set_arr[$i][1] ."'>
          </td>
          <td width='12%'> 
            <input type='text' name='field_val[]' size='8' value='" . $fields_set_arr[$i][2] ."'>
          </td>
          <td width='48%'> 
            <input type='text' name='field_doc[]' size='20' value='". $fields_set_arr[$i][3] ."'>
          </td>
        </tr>" ;
        }
      $main .= "</table>
      </td>
    </tr>
    <tr> 
      <td colspan='3'> 
        <div align='center'> 
          <input type='submit' name='Submit' value='�ק�'>
          <input type='reset' name='Submit2' value='���]'>
          <input type='submit' name='Submit' value='�R��'>
          <input type='hidden' name='id' value='$id'>
        </div>
      </td>
    </tr>
  </table>

</form> " ;
  
  return $main ;

}