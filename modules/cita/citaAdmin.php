<?php

// $Id: citaAdmin.php 7084 2013-01-18 11:20:11Z infodaes $

include "config.php";
sfs_check();

$SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'] ;
if ( !checkid($SCRIPT_FILENAME,1)){
    head("���W���]�p") ;
    print_menu($menu_p);
    echo "�L�޲z���v���I<br>�жi�J �t�κ޲z / �Ҳ��v���޲z �ק� cita_sign �Ҳձ��v�C" ;
    foot();
    exit ;
    
    //Header("Location: signList.php"); 
}
// $MAX_ITEM=18;
$id = $_GET['id'] ;
$do = $_GET['do'] ;

$Submit = $_POST['Submit'] ;
$txtPaper = $_POST['txtPaper'] ;
$txtDoc = $_POST['txtDoc'] ;
$txtBeg = $_POST['txtBeg'] ;
$txtEnd = $_POST['txtEnd'] ;
$chkClass = $_POST['chkClass'] ;
$chkData = $_POST['chkData'] ;

$txtItemName = $_POST['txtItemName'] ;
$ItemBonus = $_POST['ItemBonus'] ;

$txtGet = $_POST['txtGet'] ;
  
$chk_hide = $_POST['chk_hide'] ;  
$foot = $_POST['foot'] ;  
$helper = $_POST['helper'] ;   
$max = $_POST['max'] ; 
$gra = $_POST['gra'] ; 
$external= $_POST['external'] ;

 

if ($Submit=="�s�W") {

   $input_classY = implode(",", $chkClass);
   $data_item = implode(",", $chkData);
    $max = $_POST['max'] ; 

   for ($i = 0 ; $i< count($txtItemName) ; $i++) {
   	if (!$txtItemName[$i]) break ;
       //$kind_set .= "$txtItemName[$i]##$txtGet[$i]," ;
	$kind_set.= "$txtItemName[$i]," ;
	$bonus_set.="$ItemBonus[$i]," ;

   }
 

   $sqlstr = " insert into cita_kind 
            (id ,title,doc,beg_date,end_date , input_classY ,kind_set,bonus_set ,foot ,helper , is_hide,max,grada,external ) 
             values (0,'$txtPaper','$txtDoc','$txtBeg','$txtEnd','$input_classY','$kind_set','$bonus_set','$foot','$helper','$chk_hide','$max','$gra','$external') " ;
 

  $result =  $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
  header("Location:index.php") ;
}	
if ($Submit=="�ק�") {
   $now_id = $_POST['now_id'] ; 

   
   $input_classY = implode(",", $chkClass);
   $data_item = implode(",", $chkData);
   
   for ($i = 0 ; $i< count($txtItemName) ; $i++) {
   	if (!$txtItemName[$i]) break ;      
	$kind_set .= "$txtItemName[$i]," ;
	$bonus_set.="$ItemBonus[$i]," ;

   }

   $sqlstr = " update  cita_kind   set title ='$txtPaper' ,doc = '$txtDoc' ,beg_date ='$txtBeg',end_date ='$txtEnd' , input_classY='$input_classY' ,
              kind_set ='$kind_set',bonus_set='$bonus_set' ,foot = '$foot',helper = '$helper',is_hide='$chk_hide' ,max='$max',grada='$gra',external='$external'  where id= '$now_id'" ;

  $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
  
  header("Location:index.php") ;
}	


switch($do){
    case "edit":
        $main = Edit($id,$do) ;
        break;
    case "del":
        $main = DelItem($id,$do) ;
        break;
    default:
        $main = AddNew() ;
        break;
}

/*

if ($do=="edit" and ($id)) 
   $main = Edit($id,$do) ;
else 
    $main = AddNew() ;   
*/

  head("���W���]�p") ;
  print_menu($menu_p);
  echo $main ;

//���Ϳn���̤j��SELECT
function BonusSelect($max,$value) {
	$bonus_select="<SELECT NAME='ItemBonus[]'>";
	for($i=0;$i<=$max;$i++){
		$selected=($i==$value)?'selected':'';
		$bonus_select.="<option value='$i' $selected>$i</option>";
	}
	$bonus_select.="</SELECT>";
	return $bonus_select;
} 

//=================================================================================
function DelItem($id) {
	global $CONN , $PHP_SELF;
	$sqlstr ="SELECT COUNT(*) AS counter FROM cita_data WHERE kind=$id and order_pos<>-1" ;
    $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
	$records=$result->fields[counter];
	if($records) $main="<BR><BR>�� $records �������H����ơA�T��R��!!"; else
	{	
		$sqlstr ="delete FROM cita_kind WHERE id=$id";
		$result = $CONN->Execute($sqlstr) or user_error("�R�����ѡI<br>$sqlstr",256) ;
		$main="<BR><BR>�w�g�R�����w���Ŷ���!!";
		}

	return $main ;
}

function AddNew() {
  global $PHP_SELF ,$class_year , $STUD_FIELD ,$MARK , $BODY2 ,$school_kind_name,$MAX_ITEM,$grada,$bonus_max;
  
  $foot=$BODY2 ;
  $title=$MARK ;
     //$MAX_ITEM=18;  
		
  $beg_date = date("Y-m-d");
  $end_date = date("Y-m-d");
      
	  //�~�ŭ���
      $i =0 ;
      $class_year_arr = split (",", $input_classY);      
      $class_year = get_class_year_array();
             
      foreach ($class_year as $key => $value) {      
      	$i ++ ;
      	   if (in_array ($key,$class_year_arr))
      	      $ckk_make = "checked" ;
      	   else 
      	      $ckk_make ="" ;  
    	   $class_chk_str .=" <input type='checkbox' name='chkClass[]' value='$key'  $ckk_make >$school_kind_name[$key] |\n" ;
    	   if ($i % 3 == 0) $class_chk_str .= "<br>\n" ;
      }
   
      //����
      $kind_set_str .="<tr>";
      while ($ni < $MAX_ITEM) {
      	 $ni++ ;
      	 $kind_set_str .= "<td align='center'>$ni</td> 
            <td > 
              <input type='text' name='txtItemName[]'>".BonusSelect($bonus_max,0)."
            </td>";
       if ($ni%3 ==0)
          $kind_set_str .= "</tr><tr>";
      }	     
      

$m=count($grada); 
$sel_grada= "<select size=1 name=gra>";
for($i=0;$i<$m;$i++){
	$sel='';
	 if($i==0) $sel="selected";	
	$sel_grada.="<option value=$i>$grada[$i]</option>";
}
$sel_grada.="</select>";

$main = "	
<form name='form1' method='post' action='$PHP_SELF'>
  <table width='95%' border='0' cellspacing='0' cellpadding='0' bgcolor='#CCFFFF' bordercolor='#33CCFF'>
    <tr> 
      <td colspan='2'> 
        <table width='100%' border='1' cellspacing='0' cellpadding='4' bgcolor='#CCFFFF' bordercolor='#33CCFF'>
          <tr> 
            <td width='6%' >�W��</td>
            <td width='60%'> 
               <textarea name='txtDoc' cols='60' rows='2'>$doc</textarea><br>
			   �S���{�ݩʡG<input type='radio' name='external' value=0 checked>�դ� <input type='radio' name='external' value=1>�ե~
              �@�@�@<input type='checkbox' name='chk_hide' value='1' $chk_hide_str >���޲z����J
			  <br>�a�A�]���O�G$sel_grada <font size=2 color='red'>(�i�ۼҲ��ܼƽվ�)</font>
            </td>
            <td width='9%' >�}�l���</td>
            <td width='10%'> 
              <input type='text' name='txtBeg' size='10' value='$beg_date'>
            </td>
            <td width='9%'>�������</td>
            <td width='10%'> 
              <input type='text' name='txtEnd' size='10' value='$end_date'>
            </td>
          </tr>
          <tr> 
            <td >����</td>		
            <td > 
           	 <textarea name='helper' cols='60' rows='4'>$helper</textarea>
            </td>
            <td >�~�ŭ���</td>
            <td colspan='3'> 
               $class_chk_str
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td colspan='2' bgcolor='#33CCCC'> 
        �a�A�]���ء@�@�`��<input type='text' name='max' size='3' value='$MAX_ITEM'>
        <table width='100%' border='1' cellspacing='0' cellpadding='4' bgcolor='#CCFFFF' bordercolor='#33CCFF'>
          <tr bgcolor='#66CCFF' > 
            <td width='4%' >����</td>        
            <td width='25%'>�W�ٻP�a�A�n��(�ťիh�������ϥ�)</td>
	        <td width='4%' >����</td>
	        <td width='25%'>�W�ٻP�a�A�n��(�ťիh�������ϥ�)</td>
	        <td width='4%' >����</td>
            <td width='25%'>�W�ٻP�a�A�n��(�ťիh�������ϥ�)</td>
          </tr>
           $kind_set_str
        </table>
      </td>
    </tr>
	<tr><td>
	 <table width='100%' border='1' cellspacing='0' cellpadding='4' bgcolor='#CCFFFF' bordercolor='#33CCFF'>
          <tr> 
            <td width='10%' >�������e</td><td width='90%'>           
      		���D�G<input type='text' name='txtPaper' value='$title' size=80 ><br>
		���y�G<input type='text' name='foot' value='$foot' size=80 >
            </td></tr></table></td></tr>
  </table>
  <input type='hidden' name='now_id' value='$id'>
  <p> 

    <input type='submit' name='Submit' value='�s�W'>

    <input type='reset' name='Submit2' value='���]'>

  </p>

</form>" ;

  return $main ;

}

//=================================================================================
function Edit($id, $do) {
	global $CONN , $PHP_SELF ,$class_year , $STUD_FIELD ,$MAX_ITEM , $MAX_INPUT_FIELD,$school_kind_name,$grada,$bonus_max;
	
    $sqlstr =" select *  from cita_kind  where id = $id   " ;
	//echo $query ;
    $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
    $row = $result->FetchRow() ;
      $id = $row["id"] ;	
      $beg_date = $row["beg_date"] ;	
      $end_date = $row["end_date"] ;	
      $doc = $row["doc"] ;	
      $title = $row["title"] ;
      $input_classY = $row["input_classY"] ;
      $kind_set = $row["kind_set"] ;
	  $bonus_set = $row["bonus_set"] ;
           $admin = $row["admin"] ;
      $helper = $row["helper"] ;
      $foot = $row["foot"] ;
      $title = $row["title"] ;
      $is_hide = $row["is_hide"] ;
      $MAX_ITEM = $row["max"] ;
            $gra = $row["grada"] ;
			$external = $row["external"] ;


      if ($is_hide) $chk_hide_str = "checked" ;
      //�~�ŭ���
       $i =0 ;
      $class_year_arr = split (",", $input_classY);      
      $class_year = get_class_year_array() ;
             
      foreach ($class_year as $key => $value) {      

      	$i ++ ;
      	   if (in_array ($key,$class_year_arr) )
      	      $ckk_make = "checked"  ;
      	   else 
      	      $ckk_make ="" ;  
    	   $class_chk_str .=" <input type='checkbox' name='chkClass[]' value='$key'  $ckk_make >$school_kind_name[$key] |\n" ;
    	   if ($i % 3 == 0) $class_chk_str .= "<br>\n" ;
      }
      
      //����
      $tmparr = split (",", $kind_set);  
		$bonusarr = split (",", $bonus_set); 	  
	 $kind_set_str .= "<tr>";

      for ($i= 1 ; $i <= count($tmparr) ; $i++) {
      	if ($tmparr[$i-1]<>"") {
      	   $ni = $i ;	
      	   $tmp_arr1 = split ("##",$tmparr[$i-1]) ; //���O�W|�H��
      	   
		   $bgcolor=$bonusarr[$i-1]?'#ffcccc':'#ffffff';
		   
      	   $kind_set_str .= "<td align='center'>$i</td>      	
            <td > 
              <input type='text' name='txtItemName[]' value='$tmp_arr1[0]' style='background:$bgcolor'>".BonusSelect($bonus_max,$bonusarr[$i-1])."
            </td>";
   		  if ($i%3 ==0)
		          $kind_set_str .= "</tr><tr>";
        }  
      }  

      while ($ni <  $MAX_ITEM) {
      	 $ni++ ;
      	 $kind_set_str .= "<td align='center'>$ni</td> 
            <td > 
              <input type='text' name='txtItemName[]'>".BonusSelect($bonus_max,0)."
            </td>";
		  if ($ni%3 ==0)
		          $kind_set_str .= "</tr><tr>";
      }	     
$m=count($grada); 
$sel_grada= "<select size=1 name=gra>";
for($i=0;$i<$m;$i++){
	$sel='';
	 if($i==($gra)) $sel="selected";	
	$sel_grada.="<option $sel value=$i>$grada[$i]</option>";
}
$sel_grada.="</select>";

$main = "	
<form name='form1' method='post' action='$PHP_SELF'>
  <table width='95%' border='0' cellspacing='0' cellpadding='0' bgcolor='#CCFFFF' bordercolor='#33CCFF'>
    <tr> 
      <td colspan='2'> 
        <table width='100%' border='1' cellspacing='0' cellpadding='4' bgcolor='#CCFFFF' bordercolor='#33CCFF'>
          <tr> 
            <td width='6%' >�W��</td>
            <td width='60%'> 
               <textarea name='txtDoc' cols='60' rows='2'>$doc</textarea><br>
              �S���{�ݩʡG<input type='radio' name='external' value=0 ".(($external==0)?'checked':'').">�դ� <input type='radio' name='external' value=1 ".(($external==1)?'checked':'').">�ե~
              �@�@�@<input type='checkbox' name='chk_hide' value='1' $chk_hide_str >���޲z����J
			  <br>�a�A�]���O�G$sel_grada <font size=2 color='red'>(�i�ۼҲ��ܼƽվ�)</font>
            </td>
            <td width='9%' >�}�l���</td>
            <td width='10%'> 
              <input type='text' name='txtBeg' size='10' value='$beg_date'>
            </td>
            <td width='9%'>�������</td>
            <td width='10%'> 
              <input type='text' name='txtEnd' size='10' value='$end_date'>
            </td>
          </tr>
          <tr> 
            <td >����</td>		
            <td > 
           	 <textarea name='helper' cols='60' rows='4'>$helper</textarea>
            </td>
            <td >�~�ŭ���</td>
            <td colspan='3'> 
               $class_chk_str
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td colspan='2' bgcolor='#33CCCC'> 
        �a�A�]���ء@�@�`��<input type='text' name='max' size='3' value='$MAX_ITEM'>
        <table width='100%' border='1' cellspacing='0' cellpadding='4' bgcolor='#CCFFFF' bordercolor='#33CCFF'>
          <tr bgcolor='#66CCFF' > 
            <td width='4%'>����</td>        
            <td width='25%'>�W�ٻP�a�A�n��(�ťիh�������ϥ�)</td>
            <td width='4%' >����</td>        
	        <td width='25%'>�W�ٻP�a�A�n��(�ťիh�������ϥ�)</td> 
	        <td width='4%' >����</td>        
            <td width='25%'>�W�ٻP�a�A�n��(�ťիh�������ϥ�)</td>    
          </tr>
           $kind_set_str
        </table>
      </td>
    </tr>
	<tr><td>
	 <table width='100%' border='1' cellspacing='0' cellpadding='4' bgcolor='#CCFFFF' bordercolor='#33CCFF'>
          <tr> 
            <td width='10%' >�������e</td><td width='90%'>           
      		���D�G<input type='text' name='txtPaper' value='$title' size=80 ><br>
		���y�G<input type='text' name='foot' value='$foot' size=80 >
            </td></tr></table></td></tr>
  </table>
  <input type='hidden' name='now_id' value='$id'>
  <p> 

    <input type='submit' name='Submit' value='�ק�'>

    <input type='reset' name='Submit2' value='���]'>

  </p>

</form>" ;
  return   $main ;
}	
	
foot();
?>
