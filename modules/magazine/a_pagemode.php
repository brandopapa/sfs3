<?php
//$Id: a_pagemode.php 5310 2009-01-10 07:57:56Z hami $
  include_once( "config.php") ;
  include_once( "../../include/sfs_case_PLlib.php") ;
  // --�{�� session 
  sfs_check();
  
// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}
    
//�D�޲z�� 
$SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'] ;
if ( !checkid($SCRIPT_FILENAME,1)){
      Header("Location: index.php"); 
}   
       
//-----------------------------------------------------------------          
  if ($_GET["do"]=="build") {
  	
    //���ӤW���椸�]�w
    //���o�W�@�����O
      $sqlstr =  "select id from magazine  where id < '$_GET[book_num]' order by num DESC " ;   
      $result = $CONN->Execute($sqlstr) or die ($sqlstr);
      if ($result) {
        $row=$result->FetchRow() ;
        $prev_id = $row["id"] ;
      }
    
      //���o�W�@���椸
      if ($prev_id) {
          $sqlstr =  "select * from magazine_chap  where  book_num = '$prev_id' order by chap_sort " ;   
          $result = $CONN->Execute($sqlstr)  or die ($sqlstr);
          $dirstr = "1" ;
          while ($row=$result->FetchRow() ) {

            $a_chap_name =  $row["chap_name"] ;
            $a_cmode = $row["cmode"] ;
            $a_chap_sort  = $row["chap_sort" ];
            $a_small_pic = $row["small_pic" ];
            $a_new_win = $row["new_win" ];
            $a_stud_upload = $row["stud_upload" ];
            
            //�W�[�ؿ�
            chdir($basepath . $_GET[book_path] ."/" ) ; 	
            
            while (is_dir($dirstr)) {
           	  $dirstr ++ ;
            }	
            mkdir($dirstr , 0700) ; 
            
            $sqlstr_add =  "insert into magazine_chap (id ,book_num, chap_name ,cmode ,chap_sort ,chap_path , small_pic , new_win ,stud_upload)
                      values ( '0','$_GET[book_num]' , '$a_chap_name' ,'$a_cmode' , '$a_chap_sort','$dirstr' , '$a_small_pic' , '$a_new_win', '$a_stud_upload' ) " ;   
                      
            //$sqlstr_add = stripslashes($sqlstr_add);           
            //echo $sqlstr_add . "<br>" ;
            $result2 = $CONN->Execute($sqlstr_add) or die ($sqlstr_add);               
            $dirstr ++ ;
          }  
       }
    $do = "" ;
  }         
       
//-----------------------------------------------------------------  
  if ($_POST[Submit] == "�T�w�s�W") {
     
     //�W�[�U���ت��ؿ�
      chdir($basepath . $_POST[book_path] ."/" ) ; 	
      $dirstr = "1" ;
      while (is_dir($dirstr)) {
     	   $dirstr ++ ;
      }	
      mkdir($dirstr , 0700) ;          
      
 
      if (is_uploaded_file($_FILES['templ_file']['tmp_name'])) {
          //�W���ɮ�
          $save_path = $basepath . $_POST[book_path] . "/" .$dirstr . "/" ; 
          $fname =   $_FILES['templ_file']['name'] ;
          move_uploaded_file($_FILES['templ_file']['tmp_name'], $save_path . $fname);
          //dounzip( $save_path , $fname ) ; 
          p_unzip($save_path . $fname , $save_path) ;
          unlink($save_path . $fname);     
      }
      
      $sqlstr =  "insert into magazine_chap (id ,book_num, chap_name ,cmode ,chap_sort ,chap_path , small_pic , new_win ,stud_upload , include_mode)
                values ( '0','$_POST[book_num]' , '$_POST[txt_name]' ,'$_POST[sel_mode]' , '$_POST[txt_sort]','$dirstr' , '$_POST[chk_small]' , '$_POST[chk_new_win]', '$_POST[chk_stud_upload]' ,'$_POST[chk_include]' ) " ;   

      $CONN->Execute($sqlstr) ;       

  }
  
//-----------------------------------------------------------------  
  if ($_POST[Submit] == "�T�w�ק�") {
 
     
     if (is_uploaded_file($_FILES['templ_file']['tmp_name'])) {
          //�W���ɮ�
          $save_path = $basepath . $_POST[book_path] . "/" .$_POST[chap_path] . "/"  ; 
          $fname =   $_FILES['templ_file']['name'] ;
          move_uploaded_file($_FILES['templ_file']['tmp_name'], $save_path . $fname);
          p_unzip($save_path . $fname , $save_path) ;
          unlink($save_path . $fname);  
     }
           
     $sqlstr =  "update magazine_chap set chap_name= '$_POST[txt_name]' ,cmode ='$_POST[sel_mode]' , small_pic='$_POST[chk_small]' ,
                chap_sort = '$_POST[txt_sort]' ,new_win='$_POST[chk_new_win]' , stud_upload='$_POST[chk_stud_upload]' ,include_mode = '$_POST[chk_include]' 
                 where  id  = '$_POST[id]' " ;   
     $sqlstr = stripslashes($sqlstr);             
     $CONN->Execute($sqlstr) ;   

     $do = "" ;
  }  
  
//-----------------------------------------------------------------          
  if ($_GET["do"]=="del") {
    //�R��
    $updir = $basepath . $_GET[book_path] ."/" . $_GET[chap_path] ;
 
    do_rmdir($updir);     //�R�������ؿ�
     
    $sqlstr =  "delete  from magazine_chap  where  id  = '$_GET[id]' " ;   
    $CONN->Execute($sqlstr) ;   
    $do = "" ;
  }  
  
//=======================================================================    
  $book_num = $_GET[book_num]? $_GET[book_num] :  $_POST[book_num] ;
  if (!$book_num) header("location:a_main.php") ;

  $sqlstr =  "select * from magazine  where  id='$book_num' " ;   

  $result = $CONN->Execute($sqlstr);
  while ( $row = $result->FetchRow()) {
  
    $book_path = $row["book_path"] ;    //�ؿ�
    $is_fin = $row["is_fin"] ;
    $num = $row["num"] ;
  }
  if ($is_fin) header("location:a_main.php") ;

head("�q�l�եZ���O�޲z");  
print_menu($m_menu_p);
?>  
<style type="text/css">
<!--
.tr_s {  background-color: #FFFF66}
-->
</style>
<form method="post" action="<? echo $self_php ?>" enctype="multipart/form-data">
  <table width="95%" border="0" cellspacing="0" cellpadding="4" align="center">
    <tr> 
      <td width="73%"> 
        <h1 align="center">��<? echo $num ?>���q�l�եZ���O</h1>
      </td>
      <td width="14%"> 
        <div align="center"><a href="a_main.php" >�޲z�D�e��</a></div>
      </td>
    </tr>
  </table>
  <table width="95%" border="1" cellspacing="0" cellpadding="4" align="center" bgcolor="#99CCCC" bordercolorlight="#333333" bordercolordark="#FFFFFF">
    <tr> 
      <td width="32%">���D</td>
      <td width="20%">���O</td>
      <td width="10%">����</td>
      <td width="16%">�s��</td>
      <td width="21%">�ؿ�</td>
    </tr>
<?
  $sqlstr =  "select * from magazine_chap  where  book_num = '$book_num' order by chap_sort " ;   
  $result = $CONN->Execute($sqlstr) or die ($sqlstr);
  while ($row = $result->FetchRow()) {
    $nid = $row["id"] ;
    $chap_path = $row["chap_path"] ;
    if ($nid == $id and $do == "edit") echo '<tr><td><font color=red> ��' . $row["chap_name"] ."</font></td>";
    else echo "<tr><td>" . $row["chap_name"] ."</td>";

    echo "<td>".$chap_mode[$row["cmode"]] ."</td>" ;
    echo "<td>".$row["chap_sort"] ."</td>" ;
    echo "<td> <a href=a_pagemode.php?book_num=$book_num&id=$nid&do=edit>�ק�</a> | <a href=a_pagemode.php?book_num=$book_num&id=$nid&do=del&chap_path=$chap_path&book_path=$book_path>�R��</a></td>" ;
    
    if ( $row["cmode"]==1)  //����
    	echo "<td>$chap_path &nbsp;- <a href='a_resize.php?dopath=$book_path/$chap_path'>���s�Y��</a> </td>" ;
    else 
      echo "<td>$chap_path &nbsp; </td>\n" ;
    echo "</tr>\n" ;
  }  
  
  //�|���إ߳椸
  if (!isset($nid)) 
    echo "<tr><td colspan='5' >
      <div align='center'>
      <a href=\"$self_php?book_num=$book_num&do=build&book_path=$book_path\">�̷ӤW���椸�]�w</a>
      </div>
    </td></tr>\n" 
  	
?>    

  </table>
  <hr noshade align="center" width="75%">
<?
//�s��=======================================================================
if ($_GET["do"] == "edit" ) {
    $sqlstr =  "select * from magazine_chap  where  id  = '$_GET[id]' " ;   
    $result = $CONN->Execute($sqlstr) or die ($sqlstr);      
    $row= $result->FetchRow()  ;
    $name = $row["chap_name"]  ;
    $cmode= $row["cmode"] ;
    $chap_sort = $row["chap_sort"]  ;
    $chap_path = $row["chap_path"] ;
    $small_pic = $row["small_pic"] ;
    $new_win = $row["new_win"] ;
    $stud_upload = $row["stud_upload"] ;
    $include_mode = $row["include_mode"] ;
    
    echo "<p align=\"center\">�ק����O-$name 
    &nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"$self_php?book_num=$book_num\">�s�W���O</a></p> " ;

?>      
  
  <table width="95%" border="1" cellspacing="0" cellpadding="4" align="center" bgcolor="#99CCFF" bordercolorlight="#333333" bordercolordark="#FFFFFF">
    <tr> 
      <td width="25%">���D�G</td>
      <td > 
        <input type="text" name="txt_name" value="<? echo $name ?>">
      </td>
      <td>
      <input type="checkbox" name="chk_stud_upload" value="1" <? if ($stud_upload) echo "checked" ?> >
        ���\�ǥͤW��</td>      
    </tr>
    <tr> 
      <td width="25%">���O�G</td>
      <td width="14%"> 
        <select name="sel_mode">
          <?php
           $n = count($chap_mode) ;
           for ($i = 0 ; $i<$n;$i++)  {
             echo  "<option value=\"$i\" " ;
             if ($i==$cmode)echo " selected " ;
             echo " >" .$chap_mode[$i] ."</option>" ;
           }
        ?>
        </select>
      </td>
      <td width="61%"> 
        <input type="checkbox" name="chk_small" value="1" <? if ($small_pic) echo "checked" ?> >
        �Y�Ϲw�� <font size="2" color="#CC0000">(�ȹ������������)</font></td>
    </tr>
    <tr> 
      <td width="25%">�ƧǡG</td>
      <td width="14%"> 
        <input type="text" name="txt_sort" size="5" maxlength="3" value="<? echo  $chap_sort ?>">
      </td>
      <td width="61%"> 
        <input type="checkbox" name="chk_new_win" value="1" <? if ($new_win) echo "checked" ?> >
        �b�s�����e�{</td>
    </tr>
    <tr> 
      <td width="25%">�W�Ǻ����G<br>
        <font color="#CC0000" size="-1">(�ȹ�������O���@��)</font></td>
      <td colspan="2"> 
        <input type="file" name="templ_file"><input type="checkbox" name="chk_include" value="1" <? if ($include_mode) echo "checked" ?>>�������J�����C
        <br>
        <font size="2" color="#CC0000">(�D���޺����ݬ�index.htm�A�i�W��zip���Y��)</font> 
      </td>
    </tr>
    <tr> 
      <td colspan="3"> 
        <input type="submit" name="Submit" value="�T�w�ק�">
        <input type="reset" name="Submit3" value="���]">
        <input type="hidden" name="book_num" value="<? echo $book_num ?>">
        <input type="hidden" name="id" value="<? echo $_GET[id] ?>">
        <input type="hidden" name="book_path" value="<? echo $book_path ?>">
        <input type="hidden" name="chap_path" value="<? echo $chap_path ?>">
      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
<?
}
else
//�s�W=======================================================================
{
?>      
  <p align="center">�s�W���O</p>
  <table width="95%" border="1" cellspacing="0" cellpadding="4" align="center" bgcolor="#99CCFF" bordercolorlight="#333333" bordercolordark="#FFFFFF">
    <tr> 
      <td width="25%">���D�G</td>
      <td > 
        <input type="text" name="txt_name">
      </td>
      <td>
      <input type="checkbox" name="chk_stud_upload" value="1"  >
        ���\�ǥͤW��</td>
        
    </tr>
    <tr> 
      <td width="25%">���O�G</td>
      <td width="14%"> 
        <select name="sel_mode">
          <?php
           $n = count($chap_mode) ;
           for ($i = 0 ; $i<$n;$i++)  {
             echo  "<option value=\"$i\" >" .$chap_mode[$i] ."</option>" ;
           }
        ?>
        </select>
      </td>
      <td width="61%"> 
        <input type="checkbox" name="chk_small" value="1" checked >
        �Y�Ϲw�� <font size="2" color="#CC0000">(�ȹ������������)</font></td>
    </tr>
    <tr> 
      <td width="25%">�ƧǡG</td>
      <td width="14%"> 
        <input type="text" name="txt_sort" size="5" maxlength="3">
      </td>
      <td width="61%"> 
        <input type="checkbox" name="chk_new_win" value="1" <? if ($new_win) echo "checked" ?> >
        �b�s�����e�{</td>
    </tr>
    <tr> 
      <td width="25%">�W�Ǻ����G</td>
      <td colspan="2"> 
        <input type="file" name="templ_file"><input type="checkbox" name="chk_include" value="1" >�������J�����C
        <br>
        <font size="2" color="#660000">(<font color="#CC0000">�D�����ݬ�index.htm�A�i�W��zip���Y��)</font></font> 
      </td>
    </tr>
    <tr> 
      <td colspan="3"> 
        <input type="submit" name="Submit" value="�T�w�s�W">
        <input type="reset" name="Submit3" value="���]">
        <input type="hidden" name="book_num" value="<? echo $book_num ?>">
        <input type="hidden" name="book_path" value="<? echo $book_path ?>">
      </td>
    </tr>
  </table>
  </form>
<table width="80%" border="1" align="center" cellspacing="0" bgcolor="#eeeeee">
  <tr>
    <td width="19%">�����Ҧ�</td>
    <td width="81%"><p>�n�Hindex.htm���D���ޡA�i�H�h�ɮסA�H���t�����覡���e�{�C�p�G�ȥH��@��r�ɡA�i�H�Ŀ諾�����J�����A�h��H��椺�e�e�{�C</p>
      <p>�b���e�������ɮפW�ǡC</p></td>
  </tr>
  <tr>
    <td>���\�ǥͤW��</td>
    <td><p>�i�ର�@��ίZ���I�w���C</p>
      <p>�����w�A�h���s��Юv�~��W�ǡA�Ҧp�W�ǰ��n�������B���ҧ@�~��v�ϵ��C</p></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>  
<?
}  
foot();
?>  



</body>
</html>
