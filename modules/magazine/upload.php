<?php
//$Id: upload.php 7766 2013-11-15 06:16:35Z smallduh $
  include_once( "config.php") ;
  include_once( "../../include/PLlib.php") ;
  
// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}
  
  if (!$chap_num)  header("location:paper_list.php") ;
  
  $nday = date("mdhi-") ;
  $savepath = $basepath .$book_path . "/" .$chap_path . "/" ;
  //session_start();
  //session_register("magazine_upload_pwd");     
      
  $class_year_p = class_base($curr_year_seme); //�Z��


//�K�X��J
  if (( $_POST[txt_up_pwd]) or ($_POST[pwd_Submit] == "�e�X" )) {
    $magazine_upload_pwd  = $_POST[txt_up_pwd] ;  
  }    
  
//-----------------------------------------------------------------  
  if ($Submit=="�T�w�W��") {

     //������
     if (is_uploaded_file($_FILES['pic_file']['tmp_name'])) {
        //�W���ɮ�
        if (!eregi("(.jpg|.jpeg|.png|.gif|.swf)$",  $_FILES['pic_file']['name']) ) {
          echo "�����W�ǹ��ɡA�u�䴩 .jpg .gif .png .swf �榡" ;
          echo "<a href=\"javascript:history.go(-1)\" > �^�W�� </a> " ;
          exit ;
        }           
        $pic_fn =   $nday . $_FILES['pic_file']['name'] ;
        move_uploaded_file($_FILES['pic_file']['tmp_name'], $savepath . $pic_fn);
        dosmalljpg($savepath ,  $pic_fn) ;
     }

     $sqlstr =  "insert into  magazine_paper (id,chap_num,tmode,title,author,type_name,
                 teacher,parent,doc,classnum,class_name , pwd,pic_name) 
                 values ('0','$chap_num','$cmode','$txt_title' , '$txt_author', '$txt_type' ,
                 '$txt_teacher', '$txt_parent' ,'$txt_doc' ,'$classnum' , '$class_year_p[$classnum]' ,'$txt_pwd' ,'$pic_fn') " ;   
     //$sqlstr = stripslashes($sqlstr);             
     $CONN->Execute($sqlstr) ;   
     header("location:paper_list.php?book_num=$book_num&chap_num=$chap_num") ;

}

//-----------------------------------------------------------------      
  if ($Submit=="�T�w���") {
  	
 
     //������
     if (is_uploaded_file($_FILES['pic_file']['tmp_name'])) {
        //�W���ɮ�
        if (!eregi("(.jpg|.jpeg|.png|.gif|.swf)$",  $_FILES['pic_file']['name']) ) {
          echo "�����W�ǹ��ɡA�u�䴩 .jpg .gif .png .swf �榡" ;
          echo "<a href=\"javascript:history.go(-1)\" > �^�W�� </a> " ;
          exit ;
        }           
        
        if ($old_pic_name){   //���¹�
            @unlink($savepath. "___" . $old_pic_name );
            @unlink($savepath . $old_pic_name); 
        }
        
        $pic_fn =   $nday . $_FILES['pic_file']['name'] ;
        move_uploaded_file($_FILES['pic_file']['tmp_name'], $savepath . $pic_fn);
        dosmalljpg($savepath , $pic_fn) ;
     }else {
      if ($old_pic_name) $pic_fn = $old_pic_name ;  //�O�d�¹��ɦW
     }
          
 
     $sqlstr =  "update magazine_paper set chap_num='$chap_num', tmode ='$cmode',
                 title='$txt_title',author='$txt_author',type_name='$txt_type',
                 teacher ='$txt_teacher' ,parent ='$txt_parent',
                 classnum ='$classnum', class_name ='$class_year_p[$classnum]' , pic_name ='$pic_fn' ,doc = '$txt_doc' " ;   

     if ($txt_pwd) $sqlstr .=  " ,pwd='$txt_pwd' " ;           
     $sqlstr .=  " where id = $paper_id  " ;      
     //$sqlstr = stripslashes($sqlstr); 
     //echo $sqlstr ;
                 
     $CONN->Execute($sqlstr) ;     
     header("location:paper_list.php?book_num=$book_num&chap_num=$chap_num") ;    
    
  }    
  
//-----------------------------------------------------------------    
//���o���O�B�椸    
  $sqlstr =  "select a.* ,b.book_path ,b.ed_begin,b.ed_end  ,b.setpasswd , b.is_fin
              from magazine_chap a ,magazine b  
              where  a.id = $chap_num  and a.book_num= b.id " ;   
  $result = $CONN->Execute($sqlstr) ;
  while ($row= $result->FetchRow()) {
    $chap_name = $row["chap_name"] ;
    $chap_path = $row["chap_path"] ;
    $book_path = $row["book_path"] ;
    $cmode = $row["cmode"] ;
    $bdate = $row["ed_begin"] ;
    $enddate = $row["ed_end"] ;
    $setpasswd = $row["setpasswd"] ; //�w�]�K�X
    $is_fin = $row["is_fin"] ;    
  }

  if (( $is_fin ) or (date("Y-m-d")<$bdate or date("Y-m-d")>$enddate)) {
     echo "���b�W�w�ɶ���( $bdate ~ $enddate)�W�ǽZ��I" ;
     redir ("paper_list.php" ,2) ;
     exit ;
  } 
?>
<html>
<head>
<title>�Z��W��</title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<script language="JavaScript">

function chk_empty(item) {
   if (item.value=="") { return true; } 
}

function check() { 
   var errors='' ;
   <? 
    //�s�׼Ҧ�
    if ($paper_id) echo "var editmode = 1 ;\n" ;
    else echo "var editmode= false ; \n" ;
    
    //���A
    echo "var cmode = $cmode ; \n" ;
    
   ?>
   
   if (chk_empty(document.myform.txt_title) )  {
      errors = '�D���椣�i���ťաI \n' ; }
   if (chk_empty(document.myform.txt_author)) {	
       errors += '�@���椣�i�H�ťաI\n' ;
   }
   
   
   if (cmode ==1) { //�W�ǹϫ�
     // if (chk_empty(document.myform.txt_doc)) {	
     //   errors += '�@�~�����椣�i�H�ťաI\n' ;
     // }    
     
     if (!editmode && chk_empty(document.myform.pic_file))	{
       errors += '�W�ǹ��ɤ��i�H�ťաI\n' ;
     }          
   }else {
     if (chk_empty(document.myform.txt_doc))	{
       errors += '�峹���e���i�ťաI\n' ;
     }
  
   }  
  
  
   
   if (cmode != 2) { //�D�Z�ŰT��
     if (chk_empty(document.myform.txt_teacher)){	
       errors += '���ɱЮv�椣�i�H�ťաI\n' ;
     }   
     if (chk_empty(document.myform.txt_parent))	{
       errors += '�a���m�W�椣�i�H�ťաI\n' ;
     }       
     
   }
   
   if (!editmode && chk_empty(document.myform.txt_pwd))	{
       errors += '�Ĥ@���W�ǡA�K�X�椣�i�H�ťաI\n' ;
   }   
   if (errors) alert (errors) ;
   document.returnValue = (errors == '');
 
}

</script>
</head>

<body bgcolor="#FFFFFF">


<?php
  // �s��-----------------------------------------------------------
  if ($paper_id) {
    $sqlstr =  "select * from magazine_paper  where  id = $paper_id  " ;   
    $result = $CONN->Execute($sqlstr);
    while ($row= $result->FetchRow()) {
      $title = $row["title"] ;
      $author = $row["author"] ;
      $type_name = $row["type_name"] ;
      $teacher = $row["teacher"] ;
      $parent = $row["parent"] ;
      $doc = $row["doc"] ;      
      $classnum = $row["classnum"] ;
      $pwd = $row["pwd"] ;      
      $pic_name = $row["pic_name"] ;     
      $pwd = $row["pwd"] ;
    }    

    if (  $magazine_upload_pwd <> $pwd) {
      echo "  <form method='post'  >
        <p>���e�۩w���K�X�G 
        <input type='text' name='txt_up_pwd'>
        <input type='submit' name='pwd_Submit' value='�e�X'>
        <input type='hidden' name='paper_id' value='$paper_id'> </p>
        <input type='hidden' name='book_num' value='$book_num'>
        <input type='hidden' name='chap_num' value='$chap_num'> 
        <a href='paper_list.php'>���I�^�Z��C��<a>
        </form >" ;
      exit ;        
    }
            
?>      
<form method="post" action="<? echo $self_php ?>" enctype="multipart/form-data" name="myform" onSubmit="check();return document.returnValue">
  <div align="center">
    <h2>��<? echo " $book_num �� $chap_name �s��" ?> </h2>
    <table width="80%" border="1" cellspacing="0" cellpadding="4" bgcolor="#FFCC99" bordercolorlight="#333333" bordercolordark="#FFFFFF">
      <tr> 
        <td width="15%">���D�G</td>
        <td colspan="3"> 
          <input type="text" name="txt_title" value="<? echo $title ?>" size="40">
        </td>
      </tr>
      <tr> 
        <td width="15%">�Z�šG</td>
        <td width="34%"> 
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
        <td width="10%">�@�̡G</td>
        <td width="41%"> 
          <input type="text" name="txt_author" value="<? echo $author ?>">
        </td>
      </tr>
<?php
if ($cmode < 2) { // �峹�B���ɦ�
?>
      <tr> 
        <td width="15%">���ɱЮv�G</td>
        <td width="34%"> 
          <input type="text" name="txt_teacher" value="<? echo $teacher ?>">
        </td>
        <td width="10%">�a���G</td>
        <td width="41%"> 
          <input type="text" name="txt_parent" value="<? echo $parent ?>">
        </td>
      </tr>
<?
}
?>      
      <tr> 
        <td width="15%">�]�w�K�X�G</td>
        <td colspan="3"> 
          <p> 
            <input type="text" name="txt_pwd">
            <br>
            <font color="#FF0000" size="2">(�U���s�׻ݭn�H���K�X�i�J) </font></p>
        </td>
      </tr>
 <?php
  if ($cmode ==1) {
      //�W�ǹ���������  
?>
      <tr> 
        <td width="15%">�ϫ��ɮסG</td>
        <td colspan="3"> 
          <p>�W�ǹ��ɡG 
            <input type="file" name="pic_file" size="40">
            <font color="#FF0000" size="2">(jpg�Bpng�榡)</font></p>
          <p>���ɻ����G<br>
            <textarea name="txt_doc" cols="60" rows="4"><? echo $doc ?></textarea>
          </p>
        </td>
      </tr>
<?php
} elseif($cmode ==4) {  //�W��SWF������  
?>
      <tr> 
        <td width="23%">�W��SWF�ʵe�G</td>
        <td width="77%"> 
          <p> �W��SWF�ʵe�ɡG 
            <input type="file" name="pic_file" size="40">
            <br>
            <font color="#FF0066" size="2">(��SWF�榡��)</font> </p>
          <p> 
            <textarea name="txt_doc" cols="60" rows="15"></textarea>
          </p>
        </td>
      </tr>
<?php
}
else 
//�W�Ǥ峹�B�Z�ŰT���� ---beg
{
?>
      <tr> 
        <td width="15%">�W�Ǥ峹�G</td>
        <td colspan="3"> 
          <p> �W�ǹ��ɡG 
            <input type="file" name="pic_file" size="40">
            <br>
            <font color="#FF0000" size="2">(100*100�H�����p�ϡA�i�ٲ�)</font> </p>
          <p>�峹�ק�G<br>

            <textarea name="txt_doc" cols="60" rows="15"><? echo $doc ?></textarea>
          </p>
        </td>
      </tr>
<?
}
?>      
    </table>
    <p> 
      <input type="submit" name="Submit" value="�T�w���">
      <input type="reset" name="Submit2" value="���]">
      <input type="hidden" name="chap_num" value="<? echo $chap_num ?>">
      <input type="hidden" name="cmode" value="<? echo $cmode ?>">
      <input type="hidden" name="book_path" value="<? echo $book_path ?>">
      <input type="hidden" name="chap_path" value="<? echo $chap_path ?>">
      <input type="hidden" name="old_pic_name" value="<? echo $pic_name ?>">
      <input type="hidden" name="paper_id" value="<? echo $paper_id ?>">
    </p>
  </div>
</form>    
<?php
}
else
{
// �s�W��-----------------------------------------------------------
    if (  $magazine_upload_pwd <> $setpasswd) {
     
      echo "  <form  method=\"post\" >" ;  
      echo '<p>�W�ǱK�X(�̷s�����������G)�G 
        <input type="text" name="txt_up_pwd">
        <input type="submit" name="pwd_Submit" value="�e�X">
        <input type="hidden" name="paper_id" value="0">
      </p>' ;
      echo "<input type=\"hidden\" name=\"book_num\" value=\"$book_num\"> \n" ;
      echo "<input type=\"hidden\" name=\"chap_num\" value=\"$chap_num\"> \n" ;
      echo '<a href="paper_list.php">���I�^�Z��C��<a>' ;      
      echo "  </form >" ;
      exit ;        
    }    
?>
<form method="post" action="<? echo $self_php ?>" enctype="multipart/form-data" name="myform" onSubmit="check();return document.returnValue">
  <div align="center">
    <h2>��<? echo " $book_num �� $chap_name �W��" ?> </h2>
    <table width="80%" border="1" cellspacing="0" cellpadding="4" bgcolor="#FFCC99" bordercolorlight="#333333" bordercolordark="#FFFFFF">
      <tr> 
        <td width="17%">���D�G</td>
        <td colspan="3"> 
          <input type="text" name="txt_title" size="40">
        </td>
      </tr>
      <tr> 
        <td width="17%">�Z�šG</td>
        <td width="32%"> 
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
        <td width="11%">�@�̡G</td>
        <td width="40%"> 
          <input type="text" name="txt_author">
        </td>
      </tr>
<?php
if ($cmode < 2) {
?>
      <tr> 
        <td width="17%">���ɱЮv�G</td>
        <td width="32%"> 
          <input type="text" name="txt_teacher">
        </td>
        <td width="11%">�a���G</td>
        <td width="40%"> 
          <input type="text" name="txt_parent">
        </td>
      </tr>
<?
}
?>      
      <tr> 
        <td width="17%">�]�w�K�X�G</td>
        <td colspan="3"> 
          <input type="text" name="txt_pwd">
          <br>
          <font color="#FF0000" size="2">(�U���s�׻ݭn�H���K�X�i�J) </font> </td>
      </tr>
<?php

  if ($cmode ==1) {
  //�W�ǹ���������  
?>
      <tr> 
        <td width="17%">�W�ǹ��ɡG</td>
        <td colspan="3"> 
          <p>���ɡG 
            <input type="file" name="pic_file" size="40">
            <font color="#FF0000" size="2">(�ФW��JPG�榡)</font> </p>
          <p>���ɻ����G<br>
            <textarea name="txt_doc" cols="60" rows="4"></textarea>
          </p>
        </td>
      </tr>
<?php
} elseif($cmode ==4) {  //�W��SWF������  
?>
      <tr> 
        <td width="23%">�W��SWF�ʵe�G</td>
        <td width="77%"> 
          <p> �W��SWF�ʵe�ɡG 
            <input type="file" name="pic_file" size="40">
            <br>
            <font color="#FF0066" size="2">(��SWF�榡��)</font> </p>
          <p> 
            <textarea name="txt_doc" cols="60" rows="15"></textarea>
          </p>
        </td>
      </tr>
<?php
}
else{
  //�W�Ǥ峹�B�Z�ŰT����
?>
      <tr> 
        <td width="17%">�W�Ǥ峹�G</td>
        <td colspan="3"> 
          <p>�W�ǹ��ɡG 
            <input type="file" name="pic_file" size="40">
            <br>
            <font color="#FF0000" size="2">(100*100�H�����p�ϡA�i�ٲ�)</font> </p>
          <p>�峹���e�G<font color="#FF0000" size="2">(�������r�K��U���r�����C)</font> <br>
            <textarea name="txt_doc" cols="60" rows="15"></textarea>
          </p>
          </td>
      </tr>
<?php
}
?>
    </table>
    <p> 
      <input type="submit" name="Submit" value="�T�w�W��">
      <input type="reset" name="Submit2" value="���]">
      <input type="hidden" name="chap_num" value="<? echo $chap_num ?>">
      <input type="hidden" name="cmode" value="<? echo $cmode ?>">
      <input type="hidden" name="book_path" value="<? echo $book_path ?>">
      <input type="hidden" name="chap_path" value="<? echo $chap_path ?>">
    </p>
  </div>
</form>  
<?php
}
?>        

</body>
</html>
