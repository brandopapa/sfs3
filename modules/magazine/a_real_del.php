<?php
//$Id: a_real_del.php 5310 2009-01-10 07:57:56Z hami $
    include_once( "config.php") ;
  
    
    // --�{�� session 
    sfs_check();
    

    
//�D�޲z�� 
$SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'] ;
if ( !checkid($SCRIPT_FILENAME,1)){
      Header("Location: index.php"); 
}        
       
    $sqlstr =  " delete from magazine_paper where isDel='1' " ;   
    $CONN->Execute($sqlstr) ;
    header("location:a_main.php") ;
?>    