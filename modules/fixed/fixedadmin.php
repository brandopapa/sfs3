<?php
  // $Id: fixedadmin.php 7968 2014-03-28 07:36:51Z smallduh $
  //  ���׳q���t�� 
  //  �L�±Ӫ��b�I�ߤu�@�{
  //  http://sy3es.tnc.edu.tw/~prolin

  require "config.php" ;


  // �{���ˬd
  sfs_check();

  head("���׳q��") ;
  print_menu($menu_p);
  //$debug = 1;
  
  $unit_Email =  get_Unit_Email_list() ;
  
  $id=($_GET['id']) ? $_GET['id'] : $_POST['id'];

  $Submit = $_POST['Submit'];    
  $session_tea_name = $_SESSION['session_tea_name'] ;
  $session_log_id = $_SESSION['session_log_id'] ;
  $do = $_GET['do'] ;
  
  if ($Submit) {       //��J��ơA�H�����r�P�_
      
      $I_selUnit = $_POST['I_selUnit'];    
      $I_even_title = $_POST['I_even_title'];    
      $I_even_doc = $_POST['I_even_doc'];    
      $I_selMode = $_POST['I_selMode'];    
      $I_rep_doc = $_POST['I_rep_doc'];  
      $I_rep_mode = $_POST['I_rep_mode'];  
      $tea_name = addslashes($session_tea_name) ;

      
      switch ($Submit) {
     	case "�s�W" :
          //���Ƽg�J
          $sqlstr = "insert into $tbname (ID,even_T,even_doc,unitId,user,userid,even_date,even_mode)
              values ( '0','$I_even_title','$I_even_doc','$I_selUnit', '$tea_name' ,'$session_log_id' ,now(),'$I_selMode') " ;      
              
          $message = " ���׳q�i���e�G\n\n $I_even_doc \n\n���פH�G$session_tea_name \n\n �B�z�G$path_html" 
                 . get_store_path() ." \n\n ���H�O�۰ʥѺ��רt�εo�e�A�Ū����^�СI " ;
                 
          if ($unit_Email[$I_selUnit] )  {
          	 $mail_list = $unit_Email[$I_selUnit] ;
             @mail($mail_list, "���׳q�i�G".$I_even_title, $message );      
          }
          break ; 
     	case "�ק�" :
          //���Ƨ�s
          $sqlstr = "update $tbname set even_T='$I_even_title', even_doc='$I_even_doc' , unitId= '$I_selUnit', even_mode ='$I_selMode' WHERE   id= $id " ;
          break ; 
     	case "�^��" :
          //���Ƨ�s
          $sqlstr = "update $tbname set rep_date=now() ,rep_user='$tea_name', rep_doc='$I_rep_doc' , rep_mode= '$I_rep_mode' WHERE   id= $id " ;
          break ;                     
     	case "�R��" :
          $sqlstr = "delete FROM  $tbname WHERE   id= $id " ; 
          break ; 
     }
     if ($debug) echo "sqlstr = $sqlstr" ;
     $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
     
     //�Y���^�СA�ˬd�Юv�O�_���]�w E-mail , �H�K�^��
     if ($Submit=="�^��") { 
       $sql="select * from $tbname where id=$id";
       
       $res = $CONN->Execute($sql);
       $row=$res->FetchRow();
       $teach_id=$row['userid'];
       $I_even_title=$row['even_T'];
       $I_even_doc=$row['even_doc'];
       $user=$row['user'];
       
       $Teacher_Email=get_teacher_email_by_id($teach_id);
       if ($Teacher_Email!="") {
          $message = " ���׳q�i���e�G\n\n $I_even_doc \n\n���פH�G$user \n\n �^�Ф��e�G$I_rep_doc \n\n �B�z���p�G".$checkmode[$I_rep_mode]." \n\n �^�Ъ̡G$tea_name"." \n\n ���H�O�۰ʥѺ��רt�εo�e�A�Ū����^�СI ";
          @mail($Teacher_Email, "�^�к��׳q�i�G".$I_even_title, $message );
          $if_email="�w���ճz�L E-mail �^�гq���Юv.<br>";
          
       } // end if	     
	   }// end if
       
     echo $if_email."�����A����A��^�D�e���I" ;
     redir("fixed.php",1) ;
      
     exit;                
   }  
   


   if (isset($id)) {
     //Ū�����
     $sqlstr = "SELECT * FROM $tbname  WHERE   ID= $id " ;
     $result =  $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
     if ($result){
  	   $nb=$result->FetchRow() ;
  	   $even_T = $nb[even_T];		//���D
  	   $even_doc = $nb[even_doc];		//�ƥ�
           $unitId = $nb[unitId];		//�q�����N�X
           $unitname = $unitstr[$unitId] ;	//�q����줤��W

           $user = $nb[user];			//�����
           $userid = $nb[userid];			//�����
           $even_date = $nb[even_date];		//������
           $even_mode = $nb[even_mode] ;	//�Ʊ��Y����-�Ʀr
           $even_modestr = $evenmode[$even_mode] ; //�Y����-��r
           $rep_doc = $nb[rep_doc];		//�^�Ф��e
           $rep_mode = $nb[rep_mode];		//�״_����
     }      
     else {
       echo "�d�L����ơI" ;
       redir("fixed.php",1) ;
       exit ;
     }  
  }


  if ($do=="edit") { //�n�P�@�H�~�i�H
    //if ($userid != "$session_log_id") {
    if (strnatcasecmp ($userid, $session_log_id) ) {
       echo "�D����H�A�L�v�ק�I" ;
       redir("fixed.php",1) ;
       exit ;
    }      	
  }  
  if ($do=="reply") { //�n���Ӳը���
    if(!board_checkid($unitId)){
       echo "�D�ӳ�즨���A�L�v�^�СI" ;
       redir("fixed.php",1) ;
       exit ;
    }   
  }   
  if ($rep_mode == 2) { //�w�״_�]�ơA���i�R��
        echo "�]�Ƥw�״_�A���i���" ;
       redir("fixed.php",1) ;
       exit ;       
  }   
  
  
  
?>
<html>
<head>
<title>���׳q���޲z�e��</title>
<script language="JavaScript">

function chk_empty(item) {
   if (item.value=="") { return true; } 
}

function check( mode ) { 
   var errors='' ;
   
   if (mode==1) {
     if (chk_empty(document.myform.I_even_title) || chk_empty(document.myform.I_even_doc) )  
        errors = '�D���B�ԲӴy�z�������i�H�ťաI' ; 
   }     
   else 
     if (chk_empty(document.myform.I_rep_doc))  
        errors = '�^�Ф��e�������i�H�ťաI' ;    
   
   if (errors) alert (errors) ;
   document.returnValue = (errors == '');
 
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
</head>

<body bgcolor="#FFFFFF">


<?php
//----------------------------------------------------------------------------
//�s�W�@��
if (!isset($id)) {
   // �����{��	
?>  	
 <form name="myform" method="post" action="<? echo basename($PHP_SELF)?>" onSubmit="check(1);return document.returnValue">  
  <h1>���װO��-�s�W</h1>
  <table width="95%" border="1" cellspacing="0" cellpadding="4" bordercolorlight="#333333" bordercolordark="#FFFFFF">
    <tr> 
      <td width="21%" bgcolor="#CCCCFF">�q�����G</td>
      <td width="79%" bgcolor="#FFFFCC"> 
        <select name="I_selUnit">
          <?php 
            //��ܳ��

            foreach( $unitstr as $key => $value) {
               echo "<option value='$key'>$value</option> \n"  ;
            }          
           ?> 
        </select>
      </td>
    </tr>
    <tr> 
      <td width="21%" bgcolor="#CCCCFF">�ƥѥD���G</td>
      <td width="79%" height="26" bgcolor="#FFFFCC"> 
        <input type="text" name="I_even_title" size="60" maxlength="255">
      </td>
    </tr>
    <tr> 
      <td width="21%" height="26" bgcolor="#CCCCFF">�ԲӴy�z�G</td>
      <td width="79%" bgcolor="#FFFFCC"> ���e�y�z�ж�g�ԲӡI 
        <textarea name="I_even_doc" rows="5" cols="60">�a�I�G
        	
�Բӱ��ΡG</textarea>
      </td>
    </tr>
    <tr> 
      <td width="21%" bgcolor="#CCCCFF">�Y���{�סG</td>
      <td width="79%" bgcolor="#FFFFCC"> 
        <select name="I_selMode">
          <?php 
            foreach( $evenmode as $key => $value) {
                 echo "<option value='$key'>$value</option>" ; 
            }  
          ?>         
        </select>
      </td>
    </tr>
  </table>
  <p> 
    <input type="submit" name="Submit" value="�s�W">
    <input type="reset" name="Submit2" value="���]">
  </p>
 </form>  
<?php 
}
//-------------------------------------------------------------------------  
//�s��
if ($do=="edit") {
?>
 <form name="myform" method="post" action="<? echo basename($PHP_SELF)?>" onSubmit="check(1);return document.returnValue">  
  <h1>���װO��-�ק�</h1>
  <table width="95%" border="1" cellspacing="0" cellpadding="4" bordercolorlight="#666666" bordercolordark="#FFFFFF">
    <tr> 
      <td width="21%" bgcolor="#CCCCFF">�q�����G</td>
      <td width="79%" bgcolor="#FFFFCC"> 
        <select name="I_selUnit">
          <?php 
            foreach( $unitstr as $key => $value) {
               $chkstr = ($key==$unitId) ? "selected" : "" ;

               echo "<option value='$key' $chkstr>$value</option> \n"  ;
            }           

           ?>         
        </select>
      </td>
    </tr>
    <tr> 
      <td width="21%" bgcolor="#CCCCFF">�ƥѥD���G</td>
      <td width="79%" height="26" bgcolor="#FFFFCC"> 
        <input type="text" name="I_even_title" size="60" value="<?php echo $even_T ; ?>">
      </td>
    </tr>
    <tr> 
      <td width="21%" height="26" bgcolor="#CCCCFF">�ԲӴy�z�G</td>
      <td width="79%" bgcolor="#FFFFCC"> 
        <textarea name="I_even_doc" rows="5" cols="60"><?php echo $even_doc ; ?></textarea>
      </td>
    </tr>
    <tr> 
      <td width="21%" bgcolor="#CCCCFF">�Y���{�סG</td>
      <td width="79%" bgcolor="#FFFFCC"> 
        <select name="I_selMode">
          <?php 

            foreach( $evenmode as $key => $value) {
                $chkstr = ($key==$even_mode) ? "selected" : "" ;
                 echo "<option value='$key' $chkstr >$value</option>" ; 
            }              
          ?>         
        </select>
        <input type="hidden" name="id" value="<?php echo $id ?>">
      </td>
    </tr>
  </table>
  <p> 
    <input type="submit" name="Submit" value="�ק�">
    <input type="submit" name="Submit" value="�R��">
  </p>
 </form>  


<?php  
}

//-------------------------------------------------------------------------------
//�^��
if ($do=="reply"){
?>  
<form name="myform" method="post" action="<? echo basename($PHP_SELF)?>" onSubmit="check(2);return document.returnValue">  
  <h1>���װO��-���׳��^��</h1>
  <table width="95%" border="1" cellspacing="0" cellpadding="4" bordercolorlight="#333333" bordercolordark="#FFFFFF">
    <tr>
      <td width="21%" bgcolor="#CCCCFF">�ƥѥD���G</td>
      <td width="79%" bgcolor="#FFFFCC"> 
        <?php echo $even_T ; ?>
      </td>
    </tr>
    <tr>
      <td width="21%" height="26" bgcolor="#CCCCFF">�ԲӴy�z�G</td>
      <td width="79%" height="26" bgcolor="#FFFFCC">
        <?php echo nl2br($even_doc) ; ?>
      </td>
    </tr>
    <tr>
      <td width="21%" bgcolor="#CCCCFF">�Y���{�סG</td>
      <td width="79%" bgcolor="#FFFFCC">
        <?php echo $even_modestr ; ?>
      </td>
    </tr>
    <tr> 
      <td width="21%" bgcolor="#CCCCFF">�^�Ф��e�G</td>
      <td width="79%" bgcolor="#FFFFCC"> 
        <textarea name="I_rep_doc" rows="5" cols="60"><?php echo $rep_doc ;  ?></textarea>
      </td>
    </tr>
    <tr> 
      <td width="21%" bgcolor="#CCCCFF">�B�z���p�G</td>
      <td width="79%" bgcolor="#FFFFCC"> 
        <select name="I_rep_mode">
          <?php 
            $ni = count($checkmode) ; 
            for ($i=0 ;$i<$ni;$i++) {
              if ($i == $rep_mode) echo '<option value="' . $i. '" selected>' . $checkmode[$i] . '</option>' ;
              else echo '<option value="' . $i. '">' . $checkmode[$i] . '</option>' ; 
            }  
          ?> 
        </select>
        <input type="hidden" name="id" value="<?php echo $id ?>">
      </td>
    </tr>
  </table>
  <p> 
    <input type="submit" name="Submit" value="�^��">
  </p>
 </form>
<?php 
}  
foot();
?> 

</body>
</html>
