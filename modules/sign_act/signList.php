<?php

// $Id: signList.php 6813 2012-06-22 08:23:15Z smallduh $

include "config.php";

//sfs_check();
  //�n�J�{��
  
  //session_start(); 
  //session_register("schoolname"); 
  $schoolname = $_SESSION['schoolname'] ;
  
   
  head("�ջڳ��W��") ;
  print_menu($menu_p);
  

  $now_day = date("Y-m-d") ; 
  
  if ($_GET[id]) 
     $sqlstr = " select * from  sign_act_kind where id = '$_GET[id]' " ;
  else    
     $sqlstr = " select * from  sign_act_kind where beg_date <= '$now_day' and end_date>='$now_day' order by  id DESC " ;
  $result = $CONN->Execute($sqlstr) ; 

  while ($row = $result->FetchRow() ) {
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
      $manager = $row["manager"] ;  
      $school_list = $row["school_list"] ;  
      
      $main .=  "<tr><td><a href='signList.php?id=$id'>$title</a></td><td><a href='signView_open.php?id=$id'>�d�ݳ��W���p</a></td></tr>\n" ;
      $num ++ ;
      
  }
  switch ($num) {
    case 0:
      echo "�ثe�L���W����" ;
      break ;
    case 1:
      echo  disp_Show($id)   ;
      break;
    default:
      if ($_GET[id]) {
         if (( $now_day >= $beg_date) and ($now_day <= $end_date))  {
            echo  disp_Show($id)   ;
         } else 
           echo "�ثe�L���W����" ;        
      }else {
         echo "<table border=1 width=80% align=center border=1 bordercolor='#33CCFF' bgcolor='#CCFFFF' >
           <tr bgcolor='#66CCFF'><td colspan=2>��ܥi���W����</td></tr>  \n $main </table>" ;
      }     
      
  }       



  foot();              
  
//=================================================================
function disp_Show($id) {
  global $title ,$doc ,$schoolname ,$manager ,$school_list;      
 
  //���o�����զW
  $selstr = get_school_name($schoolname , $school_list) ;
  
  $main = "<form name='form1' method='post' action='signin.php'>
  <table cellSpacing=0 cellPadding=4 width='70%' align=center border=1 bordercolor='#CCFFFF' bgcolor='#99CCFF'>
    <tr> 
      <td colspan='2' align='center'>
        <h2>$title ���W</h2>
        <a href='signView_open.php?id=$id'>�d�ݥثe�w���W���</a>
      </td>
    </tr>
    <tr> 
      <td>�զW�G</td>
      <td> 
        <select name='school_name'>
          $selstr
        </select>
      </td>
    </tr>
    <tr> 
      <td>�K�X </td>
      <td> 
        <input type='password' name='dd_passwd' >
        <input type='hidden' name='pid' value='$id'>
      </td>
    </tr>
    <tr> 
      <td colspan='2'> 
        <div align='center'> 
          <input type='submit' name='Submit' value='�n�J'>
        </div>
      </td>
    </tr>
  </table>
  
  <table align=center width='40%' border='1' cellspacing=0   bgcolor='#CCCCCC' >
  <tr>
  <td>����:</td>
  <td>�Ĥ@������K�X�A�Ьd�ݤ��夤�����C<br>�A���i�J�A�h�ϥΦۤv�]�w���K�X�C<br>$doc</td>
  </tr>
  <tr>
  <td>�t�d�H:</td>
  <td>$manager</td>
  </tr>  
  </table>
  </form>" ;
   
  
  return $main ;


}
?>
