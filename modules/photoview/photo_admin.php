<?php
// $Id: photo_admin.php 5310 2009-01-10 07:57:56Z hami $

  require "config.php";
  

  
  //$debug = 1;
  // �{���ˬd
  sfs_check();






  function dosmalljpg($updir) {
     //��ӥؿ����������ର 0.15 ���p�� 	
     
     global $chkfile ;
     
     if (WIN_PHP_OS()) {  
        //Windows �����Y��
        return ;
     }   
     chdir($updir) ;
     $dirs = dir($updir) ;
     $dirs ->rewind() ;
     while ( $filelist = $dirs->read()) {
     	 if (($filelist!=".") && ($filelist!="..")){
     	   if (!strstr($filelist,'!!!_')) {  	//�D�Y�p��	
     	     for ($j=0;$j<count($chkfile);$j++){  
     	       if (strstr(strtolower($filelist),$chkfile[$j])){  //�� jpg����
     	         if ($debug) echo "���ɭn�Y��: $filelist" ;
     	         
     	         //�ϳ̤j�e��
     	         ImageResized($filelist , $filelist ,$BIG_PIC_X ,$BIG_PIC_Y) ; 
     	         
     	         //�Y��
     	         $smail_jpg = "!!!_" . $filelist ;
     	         ImageResized($filelist , $smail_jpg ,160 ,120) ; 
     	         //system("djpeg -pnm \"$filelist\" | pnmscale -xscale 0.2 -yscale 0.2 | cjpeg > \"$smail_jpg\" ");
     	       }
     	     }    
           }  
         }
     }
     $dirs->close() ;  	
  }  	  
  
  $Submit = $_POST['Submit'] ;
  $do = $_GET['do'] ;
  $id = $_GET['id'] ;
  $session_log_id = $_SESSION['session_log_id'] ;
  $session_tea_name = $_SESSION['session_tea_name'] ;

    
  if ($do=="exit") {
    header("Location:photo.php" ) ; 
    exit ;
  }  
  
  
  
    
  $nday = date("Y-m-d") ;
  
//�s�W---------------------------------------------------------  
  if ($Submit == "�s�W" ) {
     $nday = date("Y-m-d") ;
     
     $Iact_date = $_POST['Iact_date'] ;
     $Iact_name = $_POST['Iact_name'] ;
     $Iact_info = $_POST['Iact_info'] ;
     $Iuser = $_POST['Iuser'] ;
     
     
     //�إߥؿ�(�H�إߤ��)
     chdir($savepath) ; 	
     $dirstr = "$nday" ;
     $count = 0 ;
     while (is_dir($dirstr)) {
     	$count ++ ;
     	$dirstr = "$nday-" . $count;
     }	
     mkdir($dirstr , 0700) ;
     
     $updir = $savepath. $dirstr . '/' ;

     
     //���Y�ɤW�ǭn�������Y     
     if (is_uploaded_file($_FILES['Iact_zip']['tmp_name'])) {

        $filename=  $_FILES['Iact_zip']['name']  ;        
        move_uploaded_file($_FILES['Iact_zip']['tmp_name'],  $updir . $filename);
        $tmpfilename = $updir . $filename ;
        
        
        // for linux
        //chdir($updir) ; 
        //exec(escapeshellcmd("unzip $tmpfilename ")) ;
        
        //for windows 
        p_unzip($tmpfilename , $updir) ;
        
        unlink($tmpfilename);        
        //
     }     
          
     //���ƭӤW�ǰʧ@  
     $upfile = $_FILES['Iupload'] ;
     for ($i = 0 ; $i < count($upfile) ; $i++) {
         if (is_uploaded_file($upfile['tmp_name'][$i])) {
             move_uploaded_file($upfile['tmp_name'][$i] ,  $updir .$upfile['name'][$i]);
         }
     }   

     
     //�s�@�p��
     dosmalljpg($updir) ;


     $sqlstr = "insert into $tbname (act_ID,act_date,act_name,act_info,act_dir,act_postdate,act_auth,act_view)
        values ( '0', '$Iact_date', '$Iact_name' ,'$Iact_info',  '$dirstr',  '$nday' , '$Iuser','0') " ;
     if($debug) echo "$sqlstr <br>" ;
     $result = $CONN->Execute( $sqlstr) ;      

     redir("photo.php" ,3) ; 
     echo "�s�W�@�������I" ;
     
     exit ; 
  }
  	
//��s---------------------------------------------------------    	
  if ($Submit == "��s" ) {
     $Iact_date = $_POST['Iact_date'] ;
     $Iact_name = $_POST['Iact_name'] ;
     $Iact_info = $_POST['Iact_info'] ;
     $Iact_ID = $_POST['Iact_ID'] ;
     $Ioldicon = $_POST['Ioldicon'] ;
     $Ipath = $_POST['Ipath'] ;
     $chkdelfile = $_POST['chkdelfile'] ;
     
     $updir = $savepath . $Ipath . '/' ;     
     

     //�n���ɮקR��
     $numi = count($chkdelfile);
     if ($numi) {
       for ($i=0 ; $i<$numi ;$i++) {
     	 $delfile =$chkdelfile[$i] ;
         unlink($updir.$delfile);
       } 
     }       
     

     //���Y�ɤW�ǭn�������Y     
     if (is_uploaded_file($_FILES['Iact_zip']['tmp_name'])) {

        $filename=  $_FILES['Iact_zip']['name']  ;        
        move_uploaded_file($_FILES['Iact_zip']['tmp_name'],  $updir . $filename);
        $tmpfilename = $updir . $filename ;
        //chdir($updir) ; 
        //exec(escapeshellcmd("unzip $tmpfilename ")) ;
        p_unzip($tmpfilename , $updir) ;
        
        unlink($tmpfilename);        
     }     
          
     //���ƭӤW�ǰʧ@  
     $upfile = $_FILES['Iupload'] ;
     for ($i = 0 ; $i < count($upfile) ; $i++) {
         if (is_uploaded_file($upfile['tmp_name'][$i])) {
             move_uploaded_file($upfile['tmp_name'][$i] ,  $updir .$upfile['name'][$i]);
         }
     }   
          
    

     
     //�s�@�p��
     dosmalljpg($updir) ;     
     
     $sqlstr = "update  $tbname set act_name='$Iact_name' ,act_date='$Iact_date', act_info='$Iact_info' where act_ID = '$Iact_ID' " ;
     if($debug) echo "$sqlstr <br>" ;
     $result = $CONN->Execute( $sqlstr) ;      
 

     redir("photo.php" ,3) ; 
     echo "��s�@�������I" ;
     exit ; 
  }
  
//�T�w�R��---------------------------------------------------------      
  if ($do == "del2" ) {
     $dpath = $_GET['dpath'] ;
     $updir = $savepath .  $dpath . '/' ;
     chdir($updir) ;
     $dirs = dir($updir) ;
     $dirs ->rewind() ;
     while ( $filelist = $dirs->read()) {
     	 if (($filelist!=".") && ($filelist!="..")){
     	   if ($debug) echo "del $updir $filelist" ;
           unlink($updir.$filelist);      	
         }
     }
     $dirs->close() ;
     rmdir($updir); 

     $sqlstr = "delete  from $tbname  where act_ID = $id " ;
 
     if($debug) echo "$sqlstr <br>" ;
     $result = $CONN->Execute( $sqlstr) ;      
     redir("photo.php" ,1) ; 
     echo "�R���ʧ@�����I" ;
     exit ; 
  }  
  
  head("�ۤ��i�޲z") ;
?>

<script language="JavaScript">

function chk_empty(item) {
   if (item.value=="") { return true; } 
}

function check() { 
   var errors='' ;
   
   if (chk_empty(document.myform.Iact_name) || chk_empty(document.myform.Iact_date) || chk_empty(document.myform.Iact_info))  {
      errors = '���ʦW�١B����B²���������i�H�ťաI' ; }

   if (errors) alert (errors) ;
   document.returnValue = (errors == '');
 
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
</head>

<body bgcolor="#FFFFFF">

<?php 
  //-----------------------------------------�s�� ---------------------- 
  if ($do=="edit") {
    $sqlstr = "select * from $tbname where act_ID='$id' " ;
    $result = $CONN->Execute( $sqlstr) ; 	
    $nb=$result->FetchRow() ;
    if ($nb[act_auth]!=$session_tea_name ) {
      	 echo "�A�D�줽�G�̡A�L�v�ק糧�g�峹�I" ;
      	 redir("photo.php" ,1) ; 
      	 exit ;
    }	     
?>  	
<form enctype="multipart/form-data"  name=myform method="post" action="<?php echo basename($PHP_SELF) ?>">
  <h2>�ۤ��޲z--�ק� </h2>
  <table width="95%" border="1" cellspacing="0" cellpadding="4" bordercolorlight="#FFFFFF" bordercolordark="#3333FF" bgcolor="#CCFFFF" bordercolor="#33CCFF">
    <tr> 
      <td width="21%" bgcolor="#66CCFF">�ۤ��W�١G</td>
      <td width="79%"> 
        <input type="text" name="Iact_name" size="60" value="<?php echo $nb[act_name] ?>">
      </td>
    </tr>
    <tr> 
      <td width="21%" bgcolor="#66CCFF">�ػs����G</td>
      <td width="79%"> 
        <input type="text" name="Iact_date" size="60" value="<?php echo $nb[act_date] ?>">
      </td>
    </tr>
    <tr> 
      <td width="21%" bgcolor="#66CCFF">²���G</td>
      <td width="79%"> 
        <textarea name="Iact_info" cols="60" rows="3"><?php echo $nb[act_info] ?></textarea>
      </td>
    </tr>
    <tr> 
      <td width="21%" bgcolor="#66CCFF">�ɮ׾�z�G</td>
      <td width="79%"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr>
            <td bgcolor="#33CCCC" valign="top" width="41%"> 
              <p>�R���ɮסG</p>
              <p> 
<?php
     $updir = $savepath . $nb[act_dir] . '/' ;
     chdir($updir) ;
     $dirs = dir($updir) ;
     $dirs ->rewind() ;
     while ( $filelist = $dirs->read()) {
     	 if (($filelist!=".") && ($filelist!=".."))
     	 echo "<input type=\"checkbox\" name=\"chkdelfile[]\" value=\"$filelist\"> $filelist <br> ";
     }
     $dirs->close() ;
?>              

              <p>&nbsp;</p>
            </td>
            <td bgcolor="#CCFFCC" valign="top" width="59%"> 
               <p>�A�W���ɮסG</p>
               ZIP���Y�ɡA�̤j2MB�G<br><input name="Iact_zip" type="file" >
               <br>
               <font color="#FF3333" size="-1">�h�ɮ׮ɥ���Ҧ��ɮ����Y�A�@���W�ǡA�|�۰ʸѶ}��b�ӥؿ����C(�D�����ɮסA���n���Y)</font> 
                  
              
              <ol>
<?php        
        for ($i=1 ; $i<= $upfilenum ; $i++) {
          echo "<li> " ;
          echo "  <input type=\"file\" name=\"Iupload[]\" > " ;
          echo "</li>  \n" ;
        }  
?>      

              </ol>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td width="21%" bgcolor="#66CCFF">&nbsp;</td>
      <td width="79%"> 
        <input type="submit" name="Submit" value="��s">
        <input type="reset" name="Submit22" value="���]">
        <input type="hidden" name="Iact_ID" value="<?php echo $nb[act_ID] ?>">
        <input type="hidden" name="Ioldicon" value="<?php echo $nb[act_icon] ?>">
        <input type="hidden" name="Ipath" value="<?php echo $nb[act_dir] ?>">
      </td>
    </tr>
  </table>
</form>  	
  	
  	
<?php 
  }
  //�R��------------------------------------------------------------------
  else if ($do == "delete") {
      $sqlstr = "select * from $tbname where act_ID='$id' " ;  	
      $result = $CONN->Execute( $sqlstr) ; 	
      $nb=$result->FetchRow() ;  	

  	//�D�޲z�� 
  	$SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'] ;
	if ( !checkid($SCRIPT_FILENAME,1)){

          if ($nb[act_auth]!=$session_tea_name ) {
             redir("photo.php" ,1) ; 
          	 echo "�A�D�줽�G�̡A�L�v�R�����g�峹�I" ;
          	 
          	 exit ;
          }	 
	}        
?>  	

<table width="95%" border="1" cellspacing="0" cellpadding="4" bordercolorlight="#FFFFFF" bordercolordark="#3333FF">
  <tr>
    <td> 
      <h2>�ۤ��޲z--�R�� </h2>
      <p>�T�w�R����<?php echo $id. "��: $nb[act_name]"  ?> &nbsp; <a href="<?php echo basename($PHP_SELF) . '?do=del2&id=' .$id .'&dpath=' .$nb[act_dir] ?>">�O</a> 
        &nbsp;&nbsp; <a href="<?php echo basename($PHP_SELF) . '?do=exit' ?>">�_</a> </p>
    </td>
  </tr>
</table>  	

<?  
}	

  else {	
  //---------------------------------------�s�W	
?>  	
  	
  	
<form name=myform enctype="multipart/form-data" method="post" action="<?php echo basename($PHP_SELF) ?>"  onSubmit="check();return document.returnValue">
  <h2>�ۤ��޲z--�s�W </h2>
  <table width="95%" border="1" cellspacing="0" cellpadding="4" bordercolorlight="#FFFFFF" bordercolordark="#3333FF" bgcolor="#CCFFFF" bordercolor="#33CCFF">
     <tr> 
      <td width="21%" bgcolor="#66CCFF">�ϥΫe����</td>
      <td width="79%"> 
        �ϧΪ������j�p��ĳ���n�W�L800*600�A�Х����Y�p�B�z�C<br>
        �W�����Y�ɤ��n�W�L 2 mb�A�i�H�ĥΦh���W�Ǫ��覡�ɨ��n�W�Ǫ��Ϥ��C<br>
        ���n�W�ǹL�h���Ϥ��A20�i���O�������I�I
      </td>
    </tr>
    <tr> 
      <td width="21%" bgcolor="#66CCFF">�ۤ��W�١G</td>
      <td width="79%"> 
        <input type="text" name="Iact_name" size="60">
      </td>
    </tr>
    <tr> 
      <td width="21%" bgcolor="#66CCFF">�ػs����G</td>
      <td width="79%"> 
        <input type="text" name="Iact_date" size="60" value="<?php echo $nday ?>" >
      </td>
    </tr>
    <tr> 
      <td width="21%" bgcolor="#66CCFF">²���G</td>
      <td width="79%"> 
        <textarea name="Iact_info" cols="60" rows="3"></textarea>
      </td>
    </tr>
    <tr> 
      <td width="21%" height="71" bgcolor="#66CCFF">���Y�ɮסG<br>
        <font color="#FF3333">(ZIP�榡�A�̤j2MB)</font></td>
      <td width="79%" height="71"> 
        <input name="Iact_zip" type="file" size="50">
        <br>
        <font color="#FF3333" size="-1">�h�ɮ׮ɥ���Ҧ��ɮ����Y�A�@���W�ǡA�|�۰ʸѶ}��b�ӥؿ����C</font> 
      </td>
    </tr>
    <tr>     
    <tr> 
      <td width="21%" bgcolor="#66CCFF">�Ϥ��ɮסG</td>
      <td width="79%">
        <font color="#FF3333" size="-1">���ɦW�ХH�^�Ʀr�R�W�A�H�K�X�{�ýX�I</font>
        <ol>
<?php        
        for ($i=1 ; $i<= $upfilenum ; $i++) {
          echo "<li> " ;
          echo "  <input type=\"file\" name=\"Iupload[]\" size=\"45\"> " ;
          echo "</li>  \n" ;
        }  
?>          
        </ol>
        </td>
    </tr>
    <tr> 
      <td width="21%" bgcolor="#66CCFF">&nbsp;</td>
      <td width="79%"> 
        <input type="Submit" name="Submit" value="�s�W" >
        <input type="reset" name="Submit2" value="���]">
        <input type="hidden" name="Iuser" value="<?php echo $session_tea_name ?>" >
      </td>
    </tr>
  </table>
</form>
<?
}
?>
</body>
</html>
