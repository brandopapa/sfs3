<?php

// $Id: signAdmin.php 6999 2012-11-13 03:09:01Z infodaes $

include "config.php";

sfs_check();

$SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'] ;
if ( !checkid($SCRIPT_FILENAME,1)){
    head("���W���]�p") ;
    print_menu($menu_p);
    echo "�L�޲z���v���I<br>�жi�J �t�κ޲z / �Ҳ��v���޲z �ק� stud_sign �Ҳձ��v�C" ;
    foot();
    exit ;
    
    //Header("Location: signList.php"); 
}

$id = $_GET['id'] ;
$do = $_GET['do'] ;

$Submit = $_POST['Submit'] ;
$txtPaper = $_POST['txtPaper'] ;
$txtDoc = $_POST['txtDoc'] ;
$txtBeg = $_POST['txtBeg'] ;
$txtEnd = $_POST['txtEnd'] ;
$chkClass = $_POST['chkClass'] ;
$chkData = $_POST['chkData'] ;

$txtItem = $_POST['txtItem'] ;
$txtItemName = $_POST['txtItemName'] ;
$txtGet = $_POST['txtGet'] ;
$txtGetMore = $_POST['txtGetMore'] ;    
$txtItemDoc = $_POST['txtItemDoc'] ;

$txtI_Item = $_POST['txtI_Item'] ;
$txtI_ItemName = $_POST['txtI_ItemName'] ;
$selI_Mode = $_POST['selI_Mode'] ;    
$txtI_Width = $_POST['txtI_Width'] ;    
$txtI_def = $_POST['txtI_def'] ;    


if ($Submit=="�M��") {
  $history_id = $_POST['history_id'] ;
  $sqlstr = " select *   from  sign_kind where id = '$_POST[history_id]' " ;
  //echo  $sqlstr ;
  $beg_date = $_POST['beg_date'] ;  
  $end_data = $_POST['end_data'] ;
  $recordSet =  $CONN->Execute($sqlstr) ;     
  while ( ($recordSet) and ( !$recordSet->EOF) ){         
      	$doc = $recordSet->fields["doc"];
      	$input_classY = $recordSet->fields["input_classY"];
      	$kind_set = $recordSet->fields["kind_set"];
      	$data_item = $recordSet->fields["data_item"];
      	$input_data_item = $recordSet->fields["input_data_item"];
      	$is_hide = $recordSet->fields["is_hide"];
     	    	
      	$recordSet->MoveNext();    
      	
        $sqlstr2 = " insert into  sign_kind 
             (title ,doc ,beg_date ,end_date ,input_classY ,kind_set ,data_item ,input_data_item , is_hide,admin) 
             values ( '$txtPaper','$doc' ,'$txtBeg' ,'$txtEnd' ,'$input_classY','$kind_set','$data_item' ,'$input_data_item','$is_hide','{$_SESSION['session_tea_sn']}') " ;
       //echo $sqlstr2 ;
       $CONN->Execute($sqlstr2) ;     
  }
    
  //�̪�o�@��
  $sqlstr = " select *   from  sign_kind  order by id DESC " ;
  $recordSet =  $CONN->Execute($sqlstr) ;    
  if ( $recordSet ) {
    $_GET['id'] = $recordSet->fields["id"] ;
    $_GET['do'] = "edit" ;
    $id = $_GET['id'] ;
    $do = $_GET['do'] ;    
  }  
}   


if ($Submit=="�s�W") {


   $input_classY = implode(",", $chkClass);
   $data_item = implode(",", $chkData);
   
   for ($i = 0 ; $i< count($txtItemName) ; $i++) {
   	if (!$txtItemName[$i]) break ;
       $kind_set .= "$txtItem[$i]##$txtItemName[$i]##$txtGet[$i]##$txtGetMore[$i]##$txtItemDoc[$i]," ;
   }
   
   for ($i = 0 ; $i< count($txtI_ItemName) ; $i++) {
   	if (!$txtI_ItemName[$i]) break ;
       $input_data_item .= "$txtI_Item[$i]##$txtI_ItemName[$i]##$selI_Mode[$i]##$txtI_Width[$i]##$txtI_def[$i]," ;
   }   

   $sqlstr = " insert into sign_kind 
            (id ,title,doc,beg_date,end_date , input_classY ,kind_set ,data_item ,input_data_item , is_hide,admin ) 
             values (0,'$txtPaper','$txtDoc','$txtBeg', '$txtEnd', '$input_classY' ,'$kind_set', '$data_item', '$input_data_item' ,'$chk_hide','{$_SESSION['session_tea_sn']}') " ;
  //echo  $sqlstr ;

  $result =  $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
  header("Location:index.php") ;
}	
if ($Submit=="�ק�") {
   $now_id = $_POST['now_id'] ; 
   
   $input_classY = implode(",", $chkClass);
   $data_item = implode(",", $chkData);
   
   for ($i = 0 ; $i< count($txtItemName) ; $i++) {
   	if (!$txtItemName[$i]) break ;
       $kind_set .= "$txtItem[$i]##$txtItemName[$i]##$txtGet[$i]##$txtGetMore[$i]##$txtItemDoc[$i]," ;
   }
   
   for ($i = 0 ; $i< count($txtI_ItemName) ; $i++) {
   	if (!$txtI_ItemName[$i]) break ;
       $input_data_item .= "$txtI_Item[$i]##$txtI_ItemName[$i]##$selI_Mode[$i]##$txtI_Width[$i]##$txtI_def[$i]," ;
   }   

   $sqlstr = " update  sign_kind   set title ='$txtPaper' ,doc = '$txtDoc' ,beg_date ='$txtBeg',end_date ='$txtEnd' , input_classY='$input_classY' ,
              kind_set ='$kind_set' ,data_item = '$data_item',input_data_item ='$input_data_item' ,is_hide='$chk_hide' ,admin='{$_SESSION['session_tea_sn']}' where id= '$now_id'" ;

  //echo  $sqlstr ;

  $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
  
  header("Location:index.php") ;
}	


//�R�����i���W��
if ($do =="delete" and ($id))  {
   $sqlstr = " delete from sign_kind   where id='$id' " ;
   
   $result = $CONN->Execute($sqlstr)	;
   $sqlstr = " delete from sign_data   where kind='$id' " ;
   $result = $CONN->Execute($sqlstr)	;
  header("Location:index.php") ;	
}	

if ($do=="edit" and ($id)) 
   $main = Edit($id,$do) ;
else 

    $main = AddNew() ;   




  head("���W���]�p") ;
  print_menu($menu_p);
  echo $main ;

//=================================================================================
function AddNew() {
  global $PHP_SELF ,$class_year , $STUD_FIELD ,$MAX_ITEM , $MAX_INPUT_FIELD ,$school_kind_name;
  
  $beg_date = date("Y-m-d") ;
  
  $end_date = GetdayAdd(date("Y-m-d"),14) ;
  $sel_str = get_history() ;
   
  $main = "<form name='form1' method='post' action='$PHP_SELF'>

  <table width='95%' border='0' cellspacing='0' cellpadding='0' bgcolor='#CCFFFF' bordercolor='#33CCFF' >
    <tr> 
      <td colspan='2' > 
        <table width='100%' border='1' cellspacing='0' cellpadding='4' bgcolor='#CCFFFF' bordercolor='#33CCFF'>
          <tr> 
            <td width='6%' >�W��</td>
            <td width='36%'> 
              <input type='text' name='txtPaper'><br>
              <input type='checkbox' name='chk_hide' value='1' checked>
  �w�]���æW����    <br>
  
        �M��:$sel_str 
        <input type='submit' name='Submit' value='�M��'>  
            </td>
            <td width='10%' >���</td>
            <td width='10%'> 
              �}�l:<input type='text' name='txtBeg' size='10' value='$beg_date'>
              ����:<input type='text' name='txtEnd' size='10' value='$end_date'>
            </td>
          </tr>
          <tr> 
            <td width='6%' >����</td>
            <td width='36%'> 
              <textarea name='txtDoc' cols='40' rows='4'></textarea>
            </td>
            <td width='10%' >�~�ŭ���</td>
            <td > 
              <p> \n" ;
                $i = 0 ;
                $class_year = get_class_year_array() ;
             
		foreach ($class_year as $key => $value) {
		  $i++ ;	
    		  $main .= " <input type='checkbox' name='chkClass[]' value='$key' checked> " .$school_kind_name[$key] ." |\n" ;
    		  if ($i%3==0) $main .= "<br>\n" ;
		}              	

		$main .= "</p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td colspan='2' bgcolor='#33CCCC'> 
        <p>���W�涵��</p>
        <table width='100%' border='1' cellspacing='0' cellpadding='4' bgcolor='#CCFFFF' bordercolor='#33CCFF'>
          <tr bgcolor='#66CCFF' > 
            <td width='4%'>��</td>
            <td width='11%'>�N��</td>
            <td width='25%'>�W��(�ťիh�������ϥ�)</td>
            <td width='6%'>����</td>
            <td width='7%'>�ƨ�</td>
            <td width='47%'>�ɥR���� </td>
          </tr>\n" ;

            for($i=1 ; $i <= $MAX_ITEM ; $i++ ){
              $main .= "<tr><td >$i</td>
            <td > 
              <input type='text' name='txtItem[]' size='5' maxlength='5' value='$i'>
            </td>
            <td > 
              <input type='text' name='txtItemName[]'>
            </td>
            <td > 
              <input type='text' name='txtGet[]' size='3' maxlength='3'>
            </td>
            <td > 
              <input type='text' name='txtGetMore[]' maxlength='3' size='3' value='0' >
            </td>
            <td > 
              <input type='text' name='txtItemDoc[]'>
            </td>
          </tr>\n" ;
          }

        $main .= "</table>
      </td>
    </tr>
    <tr> 
      <td colspan='2'> 
        <table width='100%' border='1' cellspacing='0' cellpadding='0' bgcolor='#CCFFFF' bordercolor='#33CCFF'>
          <tr bgcolor='#33CCCC'> 
            <td  >�@�ֶץX�����</td>
          </tr>
          <tr> 
            <td >\n" ;

              for ($i= 0 ; $i < count($STUD_FIELD) ; $i++) 
                $main .= " <input type='checkbox' name='chkData[]' value='$i'>$STUD_FIELD[$i] | \n" ;

            $main .= "</td> 
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan='2' >
        <table width='100%' border='1' cellspacing='0' cellpadding='0' bgcolor='#CCFFFF' bordercolor='#33CCFF'>
          <tr> 
            <td colspan='6' bgcolor='#33CCCC'>��ʿ�J</td>
          </tr>
          <tr bgcolor='#66CCFF'> 
            <td width='3%'>��</td>
            <td width='5%'>�N��</td>
            <td width='22%'>��W(�ťիh�������ϥ�)</td>
            <td width='5%'>�榡</td>
            <td width='4%'>�e��</td>
            <td width='61%'>�w�]��</td>
          </tr>\n" ;

            for ($i= 1 ; $i <= $MAX_INPUT_FIELD ; $i++) {
             $main .= "<tr> 
            <td >$i</td>
            <td > 
              <input type='text' name='txtI_Item[]' size='4' value='$i'>
            </td>
            <td > 
              <input type='text' name='txtI_ItemName[]'>
            </td>
            <td > 
              <select name='selI_Mode[]'>
                <option value='s'>�r��</option>
                <option value='n'>�Ʀr</option>
                <option value='d'>���</option>
              </select>
            </td>
            <td > 
              <input type='text' name='txtI_Width[]' size='3' maxlength='3' value='6'>
            </td>
            <td > 
              <input type='text' name='txtI_def[]'>
            </td>
          </tr>\n" ;
          }

        $main .="</table>
      </td>
    </tr>
  </table>

  <p> 

    <input type='submit' name='Submit' value='�s�W'>

    <input type='reset' name='Submit2' value='���]'>

  </p>

</form>" ;

  return $main ;

}

//=================================================================================
function Edit($id, $do) {
	global $CONN , $PHP_SELF ,$class_year , $STUD_FIELD ,$MAX_ITEM , $MAX_INPUT_FIELD,$school_kind_name;
	
    $sqlstr =" select *  from sign_kind  where id = $id   " ;
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
      $data_item = $row["data_item"] ;
      $input_data_item = $row["input_data_item"] ;
      $admin = $row["admin"] ;
      $helper = $row["helper"] ;
      $title = $row["title"] ;
      $is_hide = $row["is_hide"] ;
      
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
      for ($i= 1 ; $i <= count($tmparr) ; $i++) {
      	if ($tmparr[$i-1]<>"") {
      	   $ni = $i ;	
      	   $tmp_arr1 = split ("##",$tmparr[$i-1]) ; //�N��|���O�W|����|�ƨ�|��r����
      	   
      	   $kind_set_str .= "<tr><td>$i</td>
      	   <td>
              <input type='text' name='txtItem[]' size='5' maxlength='5' value='$tmp_arr1[0]'>
            </td>
            <td > 
              <input type='text' name='txtItemName[]' value='$tmp_arr1[1]'>
            </td>
            <td > 
              <input type='text' name='txtGet[]' size='3' maxlength='3' value='$tmp_arr1[2]'>
            </td>
            <td > 
              <input type='text' name='txtGetMore[]' maxlength='3' size='3' value='$tmp_arr1[3]'>
            </td>
            <td > 
              <input type='text' name='txtItemDoc[]' value='$tmp_arr1[4]'>
            </td>
          </tr>\n" ;
        }  
      }  

      while ($ni <  $MAX_ITEM) {
      	 $ni++ ;
      	 $kind_set_str .= "<tr><td>$ni</td>
      	    <td>
              <input type='text' name='txtItem[]' size='5' maxlength='5' value='$ni'>
            </td>
            <td > 
              <input type='text' name='txtItemName[]' >
            </td>
            <td > 
              <input type='text' name='txtGet[]' size='3' maxlength='3' >
            </td>
            <td > 
              <input type='text' name='txtGetMore[]' maxlength='3' size='3' >
            </td>
            <td > 
              <input type='text' name='txtItemDoc[]' >
            </td>
          </tr>" ;
      }	     
      
      
      //�@�ֶץX
      $data_item_arr = split (",", $data_item);   
      for ($i= 0 ; $i < count($STUD_FIELD) ; $i++) {
      	   if (in_array ($i,$data_item_arr) )
      	      $ckk_make = "checked"  ;
      	   else 
      	      $ckk_make ="" ;        
           $data_item_chk_str .= "<input type='checkbox' name='chkData[]' value='$i' $ckk_make>$STUD_FIELD[$i] | \n" ;      
      }          
      
      //�B�~���
      //echo $input_data_item ;
      $tmparr="" ;
      $tmparr = split (",", $input_data_item);   
      $ni = 0 ;
      for ($i= 1 ; $i <= count($tmparr) ; $i++) {

      	if ($tmparr[$i-1]<>"") {
      	   $ni = $i ;	
      	   
      	   $tmp_arr1 = split ("##",$tmparr[$i-1]) ; //�N��|��W|����|�榡�N��|�w�]��,
      	   
      	   $sel = "" ;
      	   if ($tmp_arr1[2] == "s")
      	       $sel[0] = "selected" ;
      	   if ($tmp_arr1[2] == "n")
      	       $sel[1] = "selected" ;    
      	   if ($tmp_arr1[2] == "d")
      	       $sel[2] = "selected" ;    
      	   
           $input_data_str .= "<tr><td >$i</td>
            <td > 
              <input type='text' name='txtI_Item[]' size='4' value='$tmp_arr1[0]'>
            </td>
            <td > 
              <input type='text' name='txtI_ItemName[]' value='$tmp_arr1[1]'>
            </td>
            <td > 
              <select name='selI_Mode[]' value='$tmp_arr1[2]'>
                <option value='s' $sel[0]>�r��</option>
                <option value='n' $sel[1]>�Ʀr</option>
                <option value='d' $sel[2]>���</option>
              </select>
            </td>
            <td > 
              <input type='text' name='txtI_Width[]' size='3' maxlength='3' value='$tmp_arr1[3]'>
            </td>
            <td > 
              <input type='text' name='txtI_def[]' value='$tmp_arr1[4]'>
            </td>
          </tr>\n" ;
      	   
        }  
      }  
 
      while ($ni <  $MAX_INPUT_FIELD) {
      	 $ni++ ;
           $input_data_str .= "<tr><td >$ni</td>
            <td > 
              <input type='text' name='txtI_Item[]' size='4' value='$ni'>
            </td>
            <td > 
              <input type='text' name='txtI_ItemName[]' >
            </td>
            <td > 
              <select name='selI_Mode[]'  >
                <option value='s' selected>�r��</option>
                <option value='n'>�Ʀr</option>
                <option value='d'>���</option>
              </select>
            </td>
            <td > 
              <input type='text' name='txtI_Width[]' size='3' maxlength='3' >
            </td>
            <td > 
              <input type='text' name='txtI_def[]' >
            </td>
          </tr>\n" ;
      }	                      

    	
    $main = "	
<form name='form1' method='post' action='$PHP_SELF'>

  <table width='95%' border='0' cellspacing='0' cellpadding='0' bgcolor='#CCFFFF' bordercolor='#33CCFF'>
    <tr> 
      <td colspan='2'> 
        <table width='100%' border='1' cellspacing='0' cellpadding='4' bgcolor='#CCFFFF' bordercolor='#33CCFF'>
          <tr> 
            <td width='6%' >�W��</td>
            <td width='36%'> 
              <input type='text' name='txtPaper' value='$title' ><br>
              <input type='checkbox' name='chk_hide' value='1' $chk_hide_str >
  �w�]���æW����
            </td>
            <td width='10%' >���</td>
            <td width='10%'> 
              �}�l:<input type='text' name='txtBeg' size='10' value='$beg_date'>
              ����:<input type='text' name='txtEnd' size='10' value='$end_date'>
            </td>
          </tr>
          <tr> 
            <td width='6%' >����</td>
            <td width='36%'> 
              <textarea name='txtDoc' cols='40' rows='4'>$doc</textarea>
            </td>
            <td width='10%' >�~�ŭ���</td>
            <td > 
               $class_chk_str
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td colspan='2' bgcolor='#33CCCC'> 
        <p>���W�涵��</p>
        <table width='100%' border='1' cellspacing='0' cellpadding='4' bgcolor='#CCFFFF' bordercolor='#33CCFF'>
          <tr bgcolor='#66CCFF' > 
            <td width='4%'>��</td>
            <td width='11%'>�N��</td>
            <td width='25%'>�W��(�ťիh�������ϥ�)</td>
            <td width='6%'>����</td>
            <td width='7%'>�ƨ�</td>
            <td width='47%'>�ɥR���� </td>
          </tr>
           $kind_set_str

        </table>
      </td>
    </tr>
    <tr> 
      <td colspan='2' > 
        <table width='100%' border='1' cellspacing='0' cellpadding='0'  bgcolor='#CCFFFF' bordercolor='#33CCFF' >
          <tr bgcolor='#33CCCC'> 
            <td  >�@�ֶץX�����</td>
          </tr>
          <tr> 
            <td >
              $data_item_chk_str  
            </td> 

          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan='2' >
        <table width='100%' border='1' cellspacing='0' cellpadding='0'  bgcolor='#CCFFFF' bordercolor='#33CCFF'>
          <tr> 
            <td colspan='6' bgcolor='#33CCCC'>��ʿ�J</td>
          </tr>
          <tr bgcolor='#66CCFF'> 
            <td width='3%'>��</td>
            <td width='5%'>�N��</td>
            <td width='22%'>��W(�ťիh�������ϥ�)</td>
            <td width='5%'>�榡</td>
            <td width='4%'>�e��</td>
            <td width='61%'>�w�]��</td>
          </tr>
          $input_data_str
        </table>
      </td>
    </tr>
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
