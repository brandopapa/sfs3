<?php

// $Id: signAdmin.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";

sfs_check();

$SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'] ;
if ( !checkid($SCRIPT_FILENAME,1)){
    head("���W���]�p") ;
    print_menu($school_menu_p);
    echo "�L�޲z���v���I<br>�жi�J �t�κ޲z / �Ҳ��v���޲z �ק� stud_sign �Ҳձ��v�C" ;
    foot();
    exit ;
    
    //Header("Location: signList.php"); 
}

$id = $_GET['id'] ;
$sid = $_GET['sid'] ;
$do = $_GET['do'] ;

$Submit = $_POST['Submit'] ;

//========================================================================
//�s�ش��O
if ($Submit=="�s�W���O") {
   $sqlstr = " insert into stud_team_kind 
            (id ,class_kind,doc,beg_date,end_date ) 
             values (0,'$_POST[item]','$_POST[doc]','$_POST[begDate]','$_POST[endDate]') " ;
  //echo  $sqlstr ;
  $result =  $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;	
  
  //���o�{�b�ҥ[�J���O
  $sqlstr = " select id  from stud_team_kind where class_kind = '$_POST[item]' 
                                                   and beg_date='$_POST[begDate]' 
                                                   and end_date = '$_POST[endDate]' " ;
  $result =  $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;            
  
  $row = $result->FetchRow() ;
  $id = $row["id"] ;  	      
  //echo $_POST["data_id"] ;
  
  if ($_POST["data_id"]==0) {
     //�۫� 	 
     $item_num = $_POST[item_num] ;                                   
     $do ="add_item" ;	
  }else {
     $sqlstr = " select *  from stud_team_kind where mid = '$_POST[data_id]' " ;
     //echo $sqlstr ;
     $result =  $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;          	
     while (  $row = $result->FetchRow() ) {

       $class_kind = $row["class_kind"] ;
       $teach = $row["teach"] ;
       $stud_max = $row["stud_max"] ;
       $stud_ps = $row["stud_back"] ;
       $class_max = $row["class_max"] ;
       $week_set = $row["week_set"] ;
       $year_set = $row["year_set"] ;      
       $doc = $row["doc"] ;
       $cost = $row["cost"] ;

      
       $sqlstr2 = " insert into stud_team_kind 
            (id ,mid , class_kind, teach ,  stud_max , stud_back , class_max , week_set , year_set , doc,cost ) 
             values (0,'$id', '$class_kind', '$teach' ,  '$stud_max' , '$stud_back' , '$class_max' , '$week_set' , '$year_set' , '$doc','$cost' ) " ;
       echo   "$sqlstr2 <br>" ;  
       $result2 =  $CONN->Execute($sqlstr2) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
     }
     $do = "edit" ; 
     
  }	   
  
}	


//�ק���O
if ($Submit=="�ק���O���e") {
   $sqlstr = " update   stud_team_kind set class_kind='$_POST[item]' ,doc='$_POST[doc]',beg_date='$_POST[begDate]',end_date='$_POST[endDate]' 
               where id= '$_POST[id]'  ";
  //echo  $sqlstr ;
  $result =  $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;	
  //���o�{�b�ҥ[�J���O

  $id = $_POST[id] ;  	
  $do ="edit" ;	    
}


//�W�[�ҵ{
if ($Submit=="�s�W�Z�O") {
   for ($i= 0 ; $i <count($_POST[item]) ; $i++) { 	
       if ($_POST[item][$i]<>"") {
         $sqlstr = " insert into stud_team_kind 
            (id ,mid , class_kind, teach ,  stud_max , stud_back , class_max , week_set , year_set , doc,cost ) 
             values (0,'$_POST[mid]','". $_POST[item][$i]. "','" . $_POST[teach][$i]. "','" . $_POST[max_stud][$i] ."' ,'". 
                       $_POST[backup][$i]. "','" . $_POST[class_max][$i] ."','". $_POST[day][$i] ."' ,'" .$_POST[txtYear][$i]. "', '" . $_POST[doc][$i].  "', '" . $_POST[cost][$i]."') " ;
         //echo   "$sqlstr <br>" ;  
         $result =  $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
       }
      
  }           
             
  	
  //���o�{�b�ҥ[�J���O

  $id = $_POST[mid] ;  	
  $do ="edit" ;	    
}

//�ק�ҵ{
if ($Submit=="�ק�Z�O���") {

   $sqlstr = " update   stud_team_kind set class_kind='$_POST[item]' ,
               teach = '$_POST[teach]' , 
               stud_max = '$_POST[max_stud]' ,
               stud_back ='$_POST[backup]', 
               class_max ='$_POST[class_max]', 
               week_set ='$_POST[day]', 
               year_set ='$_POST[txtYear]' ,
               doc='$_POST[doc]',
               cost='$_POST[cost]' 
               where id= '$_POST[id]'  ";
  //echo  $sqlstr ;
  $result =  $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;	
  
  //���o�{�b�ҥ[�J���O
  	
  $id = $_POST[mid] ;  	
  $do ="edit" ;	    
  	
}
	


//�W�[�ҵ{
if ($Submit=="�s�W�Z�O����") {
	
  $id = $_POST["mid"] ;  	      
  $item_num = $_POST["class_add"] ;                                   
  $do ="add_item" ;	
  	
}
	



//========================================================================
//�D�{���}�l

switch  ($do) {
    case "edit" :
    	$main = Edit($id,$do) ;
        break; 
   
    case "add_item" :
        $main = Add_item($id,$item_num ,$do) ;  
        break; 
        
    case "edit_item" :
        $main = Edit_item($sid,$do) ;  
        break; 
        
    case "del_item" :
        $sqlstr = "delete  from stud_team_kind where id= '$_GET[sid]' ";
        $result =  $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
        $do ="edit" ;
        $main = Edit($id,$do) ;  
        break; 
        
    default:
        $main = AddNew() ;   
        break;      
     
}     





  head("���W���]�p") ;
  echo '<link href="style.css" rel="stylesheet" type="text/css">' ;
  print_menu($school_menu_p);
  echo $main ;

//=================================================================================
function AddNew() {
  global $CONN , $PHP_SELF , $DEF_SIGN_DAYS ,$DEF_BEG_TIME ,$DEF_END_TIME;
  
  $beg_date = date("Y-m-d") ;
  
  $end_date = GetdayAdd($beg_date ,$DEF_SIGN_DAYS)  ;
  $beg_date .= " $DEF_BEG_TIME" ;
  $end_date .= " $DEF_END_TIME" ;
  
  $sel = "<select name='data_id'>\n<option value='0' selected>�۩w���e</option>\n" ;
  $sqlstr =" select *  from stud_team_kind  where mid = '0'  order by id DESC " ;
  $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
  while (  $row = $result->FetchRow() ) {  
     $id = $row["id"] ;
     $class_kind = $row["class_kind"] ;   
     $sel .= "<option value='$id' >$class_kind</option>\n" ;   
  }      
  $sel .="</select>\n" ;
  
  $main = "

<form name='form1' method='post' action='$PHP_SELF'>
  <h1 align='center'>�s�W���W���O</h1>
  <table width='80%' border='1' align='center' cellspacing='0'>
    <tr > 
      <td class='tr-t' >���W���O�W��</td>
      <td><input name='item' type='text' id='item' size='20' maxlength='20'></td>
    </tr > 
    
    <tr >  
      <td class='tr-t' >����</td>
      <td><input name='doc' type='text' id='doc' size='30' maxlength='30'></td>
    </tr > 
    <tr >  
      <td class='tr-t'  >�}�l���</td>
      <td><input name='begDate' type='text' value='$beg_date' size='20' maxlength='20'></td>
    </tr> 
    <tr >      
      <td class='tr-t' >�������</td>
      <td><input name='endDate' type='text' value='$end_date'  size='20' maxlength='20'></td>
    </tr> 
    <tr >      
      <td class='tr-t'  >�����´��O</td>
      <td>$sel</td>
    </tr>    
    <tr >      
      <td class='tr-t'  >�Z��</td>
      <td><input name='item_num' type='text' value='5' id='item_num' size='3' maxlength='3'>(�Y�]�w�����´��O�A����줣�@��)
      </td>
    </tr>

  </table>
  <p align='center'> 
    <input type='submit' name='Submit' value='�s�W���O'>
  </p>  
</form>" ;

  return $main ;

}

//=================================================================================
function Edit($id, $do) {
	global $CONN , $PHP_SELF ,$class_year , $STUD_FIELD ,$MAX_ITEM , $MAX_INPUT_FIELD,$school_kind_name;
	
    //�C�X���O	
    $sqlstr =" select *  from stud_team_kind  where id = '$id'   " ;
	//echo $query ;
    $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
    $row = $result->FetchRow() ;
    
    $class_kind = $row["class_kind"] ;
    $doc = $row["doc"] ;
    $beg_date = $row["beg_date"] ;
    $end_date = $row["end_date"] ;
    
  //�ק���W���O    
  $main = "

<form name='form1' method='post' action='$PHP_SELF'>
  <h1 align='center'>���W���O��ƭק�</h1>
  <table width='80%' border='1' align='center' cellspacing='0'>
    <tr class='tr-t'> 
      <td width='21%' >���W���O�W��</td>
      <td width='31%' >����</td>
      <td width='21%' >�}�l���</td>
      <td width='16%' >�������</td>

      
    </tr>
    <tr > 
      <td><input name='item' type='text' value='$class_kind' size='20' maxlength='20'></td>
      <td><input name='doc' type='text' value='$doc' id='doc' size='30' maxlength='30'></td>
      <td><input name='begDate' type='text' value='$beg_date' size='20' maxlength='20'></td>
      <td><input name='endDate' type='text' value='$end_date'  size='20' maxlength='20'></td>
    </tr>
  </table>
  <p align='center'> 
    <input type='submit' name='Submit' value='�ק���O���e'>
    <input name='id' type='hidden' id='mid' value='$id'>
  </p>    
</form>" ;      


   //�C�X�U�Z�O
    $sqlstr =" select *  from stud_team_kind  where mid = '$id' order by id  " ;
    //	echo $sqlstr ;
    $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
    $i = 1 ;
    while (  $row = $result->FetchRow() ) {
      $sid = $row["id"] ;
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
      $beg_date = $row["beg_date"] ;
      $end_date = $row["end_date"] ;      
      
      $tab_cont .="<tr><td>$i</td><td>$class_kind</td><td>$teach</td><td>$stud_max</td><td>$stud_ps</td><td>$class_max</td><td>$week_set</td>
      		<td>$year_set</td><td>$doc</td><td>$cost</td><td nowrap><a href='signAdmin.php?id=$id&sid=$sid&do=edit_item'><img src='images/button_edit.png' border=0></a> | <a href='signAdmin.php?id=$id&sid=$sid&do=del_item'><img src='images/button_drop.png' border=0></a> </td>\n " ;
      
      $i++ ; 
      
    }   

  //�U�Z�O���Y
  $tab_top .="
  <table width='95%' border='1' align='center' cellspacing='0'>
    <tr  class='tr-t'> 
      <td width='2%' rowspan='2' class='tr-t'>�s��</td>
      <td width='17%' rowspan='2' class='tr-t'>�Z�O</td>
      <td width='17%' rowspan='2' class='tr-t'>�v��</td>
      <td colspan='3' class='tr-t'>�H�Ƴ]�w</td>
      <td width='16%' rowspan='2' class='tr-t'>�C�P<br>�W�Ҥ�</td>
      <td width='21%' rowspan='2' class='tr-t'>�~�ŭ���<br>
        (0:����)</td>
      <td width='26%' rowspan='2' class='tr-t'>�������e</td>
      <td width='7%' rowspan='2' class='tr-t'>�O��</td>
      <td width='6%' rowspan='2' nowrap  class='tr-t'>�s��</td>
    </tr>
    <tr> 
      <td width='3%' nowrap  class='tr-t'>����</td>
      <td width='2%' nowrap  class='tr-t'>�ƨ�</td>
      <td width='6%' nowrap  class='tr-t'>�C�Z�W��</td>
      
    </tr>\n
  " ;
  
  $main .=" $tab_top $tab_cont </table>
  <form name='form1' method='post' action='$PHP_SELF'>
     <p align='left'> 
    <input type='submit' name='Submit' value='�s�W�Z�O����'>
    <input name='class_add' type='text' value='1' id='class_add' size='4' maxlength='2' >
    <input name='mid' type='hidden' id='mid' value='$mid'>
    �� </p>
  </form>
  " ;
    

  return   $main ;
}	
	
	
//=================================================================================
function Add_item($id,$item_num , $do) {
  global $CONN , $PHP_SELF , $DEF_STUD_MAX ,$DEF_STUD_BACK ,$DEF_CLASS_MAX ,$DEF_COST ;
  
  $beg_date = date("Y-m-d") ;
  $end_date = date("Y-m-") ;
  
  $main = "

<form name='form1' method='post' action=''>
  <h1 align='center'>���O�G$_POST[item] </h1>
  <table width='95%' border='1' align='center' cellspacing='0'>
    <tr  class='tr-t'> 
      <td width='2%' rowspan='2' class='tr-t'>�s��</td>
      <td width='17%' rowspan='2' class='tr-t'>�Z�O</td>
      <td width='17%' rowspan='2' class='tr-t'>�v��</td>
      <td colspan='3' class='tr-t'>�H�Ƴ]�w</td>
      <td width='16%' rowspan='2' class='tr-t'>�C�P<br>�W�Ҥ�</td>
      <td width='21%' rowspan='2' class='tr-t'>�~�ŭ���<br>
        (0:����)</td>
      <td width='26%' rowspan='2' class='tr-t'>�������e</td>
      <td width='7%' rowspan='2' class='tr-t'>�O��</td>
    </tr>
    <tr> 
      <td width='3%' nowrap  class='tr-t'>����</td>
      <td width='2%' nowrap  class='tr-t'>�ƨ�</td>
      <td width='6%' nowrap  class='tr-t'>�C�Z�W��</td>
    </tr>\n" ;
    
   for ($i= 1 ; $i <=$item_num ; $i++) {
   
     $main .= "	
    <tr> 
      <td>$i</td>
      <td><input name='item[]' type='text' id='item[]' size='16' maxlength='20'></td>
      <td><input name='teach[]' type='text' id='teach[]' size='10' maxlength='20'></td>
      <td><input name='max_stud[]' type='text' id='max_stud[]' value='$DEF_STUD_MAX' size='3' maxlength='3'></td>
      <td><input name='backup[]' type='text' id='backup[]' value='$DEF_STUD_BACK' size='3' maxlength='2'></td>
      <td><input name='class_max[]' type='text' id='class_max[]' value='$DEF_CLASS_MAX' size='3' maxlength='2'></td>
      <td><input name='day[]' type='text' id='day[]' size='10' maxlength='10'></td>
      <td><input name='txtYear[]' type='text' id='txtYear[]' value='0' size='10' maxlength='10'></td>
      <td><input name='doc[]' type='text' id='doc[]' size='30' maxlength='30'></td>
      <td><input name='cost[]' type='text' id='cost[]' value='$DEF_COST' size='4' maxlength='4'></td>
    </tr>\n" ;
  }
  
  $main .= "  
  </table>
  <p align='center'> 
    <input type='submit' name='Submit' value='�s�W�Z�O'>
    <input name='mid' type='hidden' id='mid' value='$id'>
  </p>

</form>
" ;
  return $main ;
  
}  	

function Edit_Item($id,$do) {
    global $CONN , $PHP_SELF ;
    $sqlstr =" select *  from stud_team_kind  where id = '$id' " ;
    //	echo $sqlstr ;
    $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;

    while (  $row = $result->FetchRow() ) {
      $sid = $row["id"] ;
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

    }  	
  //�U�Z�O���Y
  $main .=" 
  <form name='form1' method='post' action=''>
  <h1>�ק�Z�O���</h1>
  <table width='95%' border='1' align='center' cellspacing='0'>
    <tr  class='tr-t'> 
      <td rowspan='2' class='tr-t'>�Z�O����</td>
      <td rowspan='2' class='tr-t'>�v��</td>
      <td colspan='3' class='tr-t'>�H�Ƴ]�w</td>
      <td width='16%' rowspan='2' class='tr-t'>�C�P<br>�W�Ҥ�</td>
      <td width='21%' rowspan='2' class='tr-t'>�~�ŭ���<br>
        (0:����)</td>
      <td width='26%' rowspan='2' class='tr-t'>�������e</td>
      <td width='7%' rowspan='2' class='tr-t'>�O��</td>
    </tr>
    <tr> 
      <td width='3%' nowrap  class='tr-t'>����</td>
      <td width='2%' nowrap  class='tr-t'>�ƨ�</td>
      <td width='6%' nowrap  class='tr-t'>�C�Z�W��</td>
    </tr>
    <tr> 
      <td><input name='item' type='text' id='item' value='$class_kind' size='16' maxlength='20'></td>
      <td><input name='teach' type='text' id='teach' value='$teach' size='10' maxlength='20'></td>
      <td><input name='max_stud' type='text' id='max_stud' value='$stud_max' size='3'  maxlength='3'></td>
      <td><input name='backup' type='text' id='backup' value='$stud_ps' size='3' maxlength='2'></td>
      <td><input name='class_max' type='text' id='class_max' value='$class_max' size='3' maxlength='2'></td>
      <td><input name='day' type='text' id='day' size='10' value='$week_set' maxlength='10'></td>
      <td><input name='txtYear' type='text' id='txtYear' value='$year_set' value='0' size='10' maxlength='10'></td>
      <td><input name='doc' type='text' id='doc' value='$doc' size='30' maxlength='30'></td>
      <td><input name='cost' type='text' id='cost' value='$cost' size='4' maxlength='4'></td>
    </tr>
  </table>    
  <p align='center'> 
    <input type='submit' name='Submit' value='�ק�Z�O���'>
    <input name='mid' type='hidden' id='mid' value='$mid'>
    <input name='id' type='hidden' id='id' value='$id'>
  </p>

</form>  
  " ;	
  return $main ;	
}
	
foot();
?>
