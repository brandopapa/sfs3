<?php
// $Id: photo_admin2.php 5310 2009-01-10 07:57:56Z hami $

  require "config.php";

  //$debug = 1;
  // �{���ˬd
  sfs_check();
  
  /*
  function microtime_float()
  {
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
  }
  */
  
  function dosmalljpg($updir) {
     global $chkfile ;
     
     if (WIN_PHP_OS()) {  
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
  
  if ($_GET['step']==3) {
    @unlink("/tmp/photoview-".$session_log_id );        
    header("Location:photo.php" ) ; 
    exit ;    
  }  
  
    
  $nday = date("Y-m-d") ;
  $step = 0 ;
  
  
//�s�W---------------------------------------------------------  
  if ($Submit == "�U�@�B" ) {
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
     mkdir($dirstr , 0755) ;
     
     //$updir = $savepath. $dirstr . '/' ;
     //�n���{�Ҫ���r�ɮ�
     $session_name =  session_name() ; // �w�]�Ȭ� PHPSESSID
     /*
     $time_end = (microtime_float()+600);
     saveFile ("/tmp/photoview-".$session_log_id  ,$_REQUEST[$session_name].'--'.$time_end ) ;
     */
     saveFile ("/tmp/photoview-".$session_log_id  ,$_REQUEST[$session_name]) ;
     
     $sqlstr = "insert into $tbname (act_ID,act_date,act_name,act_info,act_dir,act_postdate,act_auth,act_view)
        values ( '0', '$Iact_date', '$Iact_name' ,'$Iact_info',  '$dirstr',  '$nday' , '$Iuser','0') " ;
     $result = $CONN->Execute( $sqlstr) ;      
          
     $step = 2 ;
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
  
$template_dir = $SFS_PATH."/".get_store_path()."/templates";
$smarty->template_dir = $template_dir;
$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("module_name","�ۤ��i�޲z");

$smarty->assign("now_date",date("Y-m-d"));

$smarty->assign("dir",$dirstr);
$smarty->assign("PHP_SELF",basename($PHP_SELF));
$smarty->assign("Iact_name",$Iact_name);
$smarty->assign("session_tea_name",$session_tea_name);
$smarty->assign("login_id",$_SESSION['session_log_id']);
$smarty->assign("session_id",$_REQUEST["PHPSESSID"]);


if ($step == 2) 
   $smarty->display("admin_add2.htm");
else    
   $smarty->display("admin_add1.htm");
  
?>
