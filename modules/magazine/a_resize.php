<?php
//$Id: a_resize.php 5310 2009-01-10 07:57:56Z hami $
  include_once( "config.php") ;

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
  function dosmalljpg_dir($updir) {
     //��ӥؿ����������ର 1/10 ���p�� 	
     //global $chkfile ;
     $chkfile=array(".jpg",".jpeg");	//�u�i�H�W��jpg�榡����
     
     chdir($updir) ;
     $dirs = dir($updir) ;
     $dirs ->rewind() ;
     while ( $filelist = $dirs->read()) {
     	 if (($filelist!=".") && ($filelist!="..")){
     	   if (!strstr($filelist,'___')) {  	//�D�Y�p��	
     	     for ($j=0;$j<count($chkfile);$j++){  
     	       if (strstr(strtolower($filelist),$chkfile[$j])){  //�� jpg����
     	         if ($debug) echo "���ɭn�Y��: $filelist" ;
     	         $smail_jpg = "___" . $filelist ;
     	         system("djpeg -pnm \"$filelist\" | pnmscale -xscale 0.15 -yscale 0.15 | cjpeg > \"$smail_jpg\" ");
     	       }
     	     }    
           }  
         }
     }
     $dirs->close() ;  	
  }  
  
  dosmalljpg_dir($basepath . $dopath) ;	 
  
  header("location:a_pagemode.php") ;
  foot();
?>