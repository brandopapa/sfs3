<?php
//$Id: editor.php 7766 2013-11-15 06:16:35Z smallduh $
  include_once( "config.php") ;
  include "../../include/sfs_case_PLlib.php" ;
  

  
// --�{�� session 
sfs_check();
  
// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

  if (!$paper_id)  header("location:paper_list.php") ;

  $class_year_p = class_base($curr_year_seme); //�Z��
  
  $savepath = $basepath .$book_path . "/" .$chap_path . "/" ;       
//-----------------------------------------------------------------      
  if ($Submit=="�R���o�g�Z��") {  
     //�R������
     if ($old_pic_name) {
        @unlink ($savepath . $old_pic_name) ;
        @unlink($savepath. "___" . $old_pic_name);
     }    
     
     $sqlstr =  "delete  from  magazine_paper " ;
     $sqlstr .=  " where id = $paper_id  " ;      
     
     $CONN->Execute($sqlstr);    
     header("location:paper_list.php?book_num=$book_num&chap_num=$chap_num") ;         
  }    
//-----------------------------------------------------------------      
  if ($Submit=="�T�w���") {
     
    //���o���`�������O
    $sqlstr =  "select * from magazine_chap  where  id = '$tchap_num' " ;   
    $result = $CONN->Execute($sqlstr);
    while ($row=$result->FetchRow()) {
        $cmode  = $row["cmode"] ;
    }       
      
    $nday = date("mdhi-") ;
    
     //����
     if (is_uploaded_file($_FILES['pic_file']['tmp_name'])) {
        //�W���ɮ�
        if (!eregi("(.jpg|.jpeg|.png|.gif)$",  $_FILES['pic_file']['name']) ) {
          echo "�����W�ǹ��ɡA�u�䴩 .jpg .gif .png �榡" ;
          echo "<a href=\"javascript:history.go(-1)\" > �^�W�� </a> " ;
          exit ;
        }      
        
        if ($old_pic_name){   //���¹�
            unlink($savepath . $old_pic_name); 
            @unlink($savepath. "___" . $old_pic_name);
        }
                
        $pic_fn =   $nday . $_FILES['pic_file']['name'] ;
        move_uploaded_file($_FILES['pic_file']['tmp_name'], $savepath . $pic_fn);
        dosmalljpg($savepath , $pic_fn) ;        
            
     }
      
     else {
      if ($old_pic_name) $pic_fn = $old_pic_name ;  //�O�d�¹���
     }    
     
     if ($chk_del_pic) {
        //�R������
        unlink ($savepath . $old_pic_name) ;
        @unlink($savepath. "___" . $old_pic_name);
        $pic_fn = "" ;
     }


     $sqlstr =  "update magazine_paper 
                 set title='$txt_title ',author='$txt_author ',type_name='$txt_type',
                 teacher ='$txt_teacher ' ,parent ='$txt_parent ', chap_num='$tchap_num' , tmode='$cmode' ,
                 classnum ='$classnum', class_name ='$class_year_p[$classnum]' , pic_name ='$pic_fn' ,doc = '$txt_doc' ,judge='$txt_judge',
                 isDel='$chkDel' , editId = '$_SESSION[session_tea_name]' , editDate = now()  " ;
     
     $sqlstr .=  " where id = $paper_id  " ; 
     
         
     //$sqlstr = stripslashes($sqlstr); 

     
     $CONN->Execute($sqlstr);    
     header("location:paper_list.php?book_num=$book_num&chap_num=$chap_num") ;    
  }    
  
//-----------------------------------------------------------------    
  $sqlstr =  "select p.* , c.chap_name , c.chap_path ,c.book_num, p.pwd ,
              m.book_path , m.num ,m.admin ,m.is_fin 
              from magazine_paper p, magazine_chap c ,magazine m  
              where  p.id =$paper_id and p.chap_num= c.id   and c.book_num= m.id " ;   
  $result = $CONN->Execute($sqlstr);
  while ($row=$result->FetchRow()) {
    $chap_name = $row["chap_name"] ;
    $chap_path = $row["chap_path"] ;
    $book_path = $row["book_path"] ;
    $num = $row["num"] ;
    $book_num = $row["book_num"] ;
    $is_fin = $row["is_fin"] ;
    
    $editors =  $row["admin"] ;         //�s��s
    $chap_num = $row["chap_num"] ;
    $cmode = $row["tmode"] ;
    $title = $row["title"] ;
    $author = $row["author"] ;
    $type_name = $row["type_name"] ;
    $teacher = $row["teacher"] ;
    $parent = $row["parent"] ;
    $doc = $row["doc"] ;        
    $judge = $row["judge"] ;
    $classnum = $row["classnum"] ;       
    $pic_name = $row["pic_name"] ;
    $pwd = $row["pwd"] ;
    $chkDel = $row["isDel"] ;  
  }

  if (!check_is_man2($editors)) {
     echo "�A�D�����s��s�����A�L�v���榹�\��I" ;
     redir("paper_list.php?book_num=$book_num&chap_num=$chap_num" ,2) ;
     exit ;
  }  
    
  $sqlstr =  "select * from magazine_chap  where  book_num = '$book_num'  order by chap_sort " ;   
  $result = $CONN->Execute($sqlstr);
  while ($row=$result->FetchRow()) {
    $nid = $row["id"] ;
    $nchap= $row["chap_name"] ;
    $chapt_arr[$nid] = $nchap ;
  }    
     
  head() ;
?>
<html>
<head>
<title>�Z��W��</title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
</head>

<body bgcolor="#FFFFFF">
<form method="post" action="" enctype="multipart/form-data">
  <div align="center"> 
    <p><font size="5"><? echo "�� $num �� $chap_name �f�Z" ?> </font>
<font color ='red'>�f�Z������n���U�T�w�����A�~�|�X�w�f�Z�ϥܡI</font>
    <table width="90%" border="1" cellspacing="0" cellpadding="4" bgcolor="#FFCC99" bordercolorlight="#333333" bordercolordark="#FFFFFF">
      <tr> 
        <td width="14%">�ק����O�G</td>
        <td width="86%"> 
        <select name="tchap_num">
<?         
	foreach ($chapt_arr as $key => $value) {
          if ($key == $chap_num)	  
             echo  sprintf ("<option value=\"%s\" selected>%s</option>\n",$key,$value);
           else
             echo  sprintf ("<option value=\"%s\">%s</option>\n",$key,$value);
	}  
?>      
        </select> 
        </td>
      </tr>    
      <tr> 
        <td width="14%">���D�G</td>
        <td width="86%"> 
          <input type="text" name="txt_title" size="40" value="<?  echo $title ?>">
        </td>
      </tr>
      <tr> 
        <td width="14%">�Z�šG</td>
        <td width="86%"> 
          <select name="classnum">
	<?php
	reset($class_year_p);
	 while(list($tkey,$tvalue)= each($class_year_p))
	 {
          if ($tkey == $classnum)	  
             echo  sprintf ("<option value=\"%s\" selected>%s</option>\n",$tkey,$tvalue);
           else
             echo  sprintf ("<option value=\"%s\">%s</option>\n",$tkey,$tvalue);
          }             	 
 	?>          
          </select>
           </td>
      </tr>
      <tr> 
        <td width="14%">�@�̡G</td>
        <td width="86%"> 
          <input type="text" name="txt_author" value="<?echo $author ?>">
        </td>
      </tr>
      
      <?

      if ($cmode<2) {    //�Z�ŰT��
      ?>        
      <tr> 
        <td width="14%">���ɱЮv�G</td>
        <td width="86%"> 
          <input type="text" name="txt_teacher" value="<?echo $teacher ?>">
        </td>
      </tr>
      <tr> 
        <td width="14%">�a���G</td>
        <td width="86%"> 
          <input type="text" name="txt_parent" value="<? echo $parent ?>">
        </td>
      </tr>
      <tr> 
        <td width="14%">�K�X�G</td>
        <td width="86%"> 
          <? echo $pwd ?>
        </td>
      </tr>
      <? }    //�Z�ŰT��
      
      if ($cmode==1) {// �W�ǹϫ�
      ?>        
      <tr> 
        <td width="14%">���s�W�ǡG</td>
        <td width="86%"> ���ɡG<input type="file" name="pic_file" size="40">
            <br>
            <font color="#FF0066" size="2">(��JPG�BPNG�BGIF �榡��)</font><br> 
    
          <textarea name="txt_doc" wrap="OFF" cols="60" rows="4"><? echo $doc ?></textarea>
          <br>
          <? if ( ($pic_name))   
               echo '<input type="checkbox" name="chk_del_pic" value="1"   > �R�������ɡG' .$pic_name ; 
            ?>
        </td>
      </tr>
      <? 
      }
      else {
      ?>
      <tr> 
        <td width="14%">�峹�G</td>
        <td width="86%"> 
          <textarea name="txt_doc"  cols="74" rows="20"><? echo $doc ?></textarea>
        </td>
      </tr>      
      <?
      }
      ?>
    </table>
    <p> 
      <input type="checkbox" name="chkDel" value="1" <? if ($chkDel) echo "checked" ?> >���g�R��
      <input type="submit" name="Submit" value="�T�w���">
      <input type="reset" name="Submit2" value="���]">
      <input type="hidden" name="book_path" value="<? echo $book_path ?>">
      <input type="hidden" name="chap_path" value="<? echo $chap_path ?>">
      <input type="hidden" name="paper_id" value="<? echo $paper_id ?>">
      <input type="hidden" name="old_pic_name" value="<? echo $pic_name ?>">
      <input type="hidden" name="chap_num" value="<? echo $chap_num ?>">
      <input type="hidden" name="book_num" value="<? echo $book_num ?>">
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
      <font color ='red'>�f�Z������n���U�T�w�����A�~�|�X�w�f�Z�ϥܡI</font>
  </div>
  
</form>
<? foot(); ?>