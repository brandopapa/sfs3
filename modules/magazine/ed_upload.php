<?php
//$Id: ed_upload.php 5456 2009-04-23 08:32:09Z infodaes $
  include_once( "config.php") ;
  include_once( "../../include/PLlib.php") ;
  // --�{�� session 
  sfs_check();
  
// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}
  
  if (!$chap_num)  header("location:paper_list.php") ;
  
  
  $class_year_p = class_base($curr_year_seme); //�Z��

  

  
//-----------------------------------------------------------------  
  if ($Submit=="�T�w�W��") {
     $nday = date("mdhi-") ;
     $savepath = $basepath .$book_path . "/" .$chap_path . "/" ;

     //����
     if (is_uploaded_file($_FILES['pic_file']['tmp_name'])) {
        //�W���ɮ�
        if (!eregi("(.jpg|.jpeg|.png|.gif|.swf)$",  $_FILES['pic_file']['name']) ) {
          echo "�����W�ǹ��ɡA�u�䴩 .jpg .gif .png .swf�榡" ;
          echo "<a href=\"javascript:history.go(-1)\" > �^�W�� </a> " ;
          exit ;
        }      
        
        $pic_fn =   $nday . $_FILES['pic_file']['name'] ;
        move_uploaded_file($_FILES['pic_file']['tmp_name'], $savepath . $pic_fn);
        dosmalljpg($savepath , $pic_fn) ;        
            
     }
     $sqlstr =  "insert into  magazine_paper (id,chap_num,tmode,title,author,type_name,
                 teacher,parent,doc,classnum ,class_name ,pwd,pic_name) 
                 values ('0','$chap_num','$cmode','$txt_title ' , '$txt_author ', '$txt_type' ,
                 '$txt_teacher ', '$txt_parent ' ,'$txt_doc ' ,'$classnum'  , '$class_year_p[$classnum]' ,'uxfd03' ,'$pic_fn') " ;   
     
     $CONN->Execute($sqlstr) ;  

     header("location:paper_list.php?book_num=$book_num&chap_num=$chap_num") ;

}


  
//-----------------------------------------------------------------    
//���o���O�B�椸    
  $sqlstr =  "select a.* ,b.admin ,b.book_path ,b.ed_begin,b.ed_end  ,b.setpasswd , b.is_fin
              from magazine_chap a ,magazine b  
              where  a.id = $chap_num  and a.book_num= b.id " ;   
  $result = $CONN->Execute($sqlstr) ;
  while ($row=$result->FetchRow()) {
    $chap_name = $row["chap_name"] ;
    $chap_path = $row["chap_path"] ;
    $book_path = $row["book_path"] ;
    $cmode = $row["cmode"] ;
    $bdate = $row["ed_begin"] ;
    $enddate = $row["ed_end"] ;
    $setpasswd = $row["setpasswd"] ; //�w�]�K�X
    $is_fin = $row["is_fin"] ;    
    $editors =  $row["admin"] ;         //�s��s
  }

  if (( $is_fin ) ) {
     echo "�w���Z�A�L�k�W�ǽZ��I" ;
     redir ("paper_list.php" ,2) ;
     exit ;
  } 
  
  if (!check_is_man2($editors)) {
     echo "�A�D�����s��s�����A�L�v���榹�\��I" ;
     redir("paper_list.php?book_num=$book_num&chap_num=$chap_num" ,2) ;
     exit ;
  }  
  head() ;   
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
     //if (chk_empty(document.myform.txt_doc)) {	
     //  errors += '�@�~�����椣�i�H�ťաI\n' ;
     //}    
     
     if (!editmode && chk_empty(document.myform.pic_file))	{
       errors += '�W�ǹ��ɤ��i�H�ťաI\n' ;
     }          
   } 
   else {
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
   

   if (errors) alert (errors) ;
   document.returnValue = (errors == '');
 
}

</script>
</head>

<body bgcolor="#FFFFFF">

<form method="post" action="<? echo $self_php ?>" enctype="multipart/form-data" name="myform" onSubmit="check();return document.returnValue">
  <div align="center">
    <h2>��<? echo " $book_num �� $chap_name �W��" ?> </h2>
    <table width="80%" border="1" cellspacing="0" cellpadding="4" bgcolor="#FFCC99" bordercolorlight="#333333" bordercolordark="#FFFFFF">
      <tr> 
        <td width="23%">���D�G</td>
        <td width="77%"> 
          <input type="text" name="txt_title" size="40">
        </td>
      </tr>
      <tr> 
        <td width="23%">�Z�šG</td>
        <td width="77%"> 
          <select name="classnum">
            <?php
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
        <td width="23%">�@�̡G</td>
        <td width="77%"> 
          <input type="text" name="txt_author">
        </td>
      </tr>
      <?php

if ($cmode < 2) {
?>
      <tr> 
        <td width="23%">���ɱЮv�G</td>
        <td width="77%"> 
          <input type="text" name="txt_teacher">
        </td>
      </tr>
      <tr> 
        <td width="23%">�a���G</td>
        <td width="77%"> 
          <input type="text" name="txt_parent">
        </td>
      </tr>
      <?php
}
  if ($cmode ==1) {
  //�W�ǹ���������  
?>
      <tr> 
        <td width="23%">�W�ǹ��ɡG</td>
        <td width="77%"> 
           <p> �W�ǹ��ɡG 
            <input type="file" name="pic_file" size="40">
            <br>
            <font color="#FF0066" size="2">(��JPG�BPNG�BGIF�榡��)</font> </p>
          <p>         
          <textarea name="txt_doc" rows="3" cols="40" ></textarea>
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
{
  //�W�Ǥ峹�B�Z�ŰT����
?>
      <tr> 
        <td width="23%">�W�Ǥ峹�G</td>
        <td width="77%"> 
          <p> �W�Ǥp�����ɡG 
            <input type="file" name="pic_file" size="40">
            <br>
            <font color="#FF0066" size="2">(��JPG�BPNG�BGIF �榡��)</font> </p>
          <p> 
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

foot() ;
?>        

</body>
</html>
