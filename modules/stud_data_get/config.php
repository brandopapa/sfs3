<?php
//$Id: config.php 5310 2009-01-10 07:57:56Z hami $
//�w�]���ޤJ�ɡA���i�����C
require_once "./module-cfg.php";
include_once "../../include/config.php";
//�z�i�H�ۤv�[�J�ޤJ��

function get_str_to_array($put_data) {


   $LineWord = preg_split ("/\n/", $put_data);     //������
   $all_stud= count( $LineWord) ;

   for ($i=0 ; $i < $all_stud ; $i++) {
     $keywords = "" ;
     $keywords = preg_split ("/[\s,]+/", $LineWord[$i]);     //���j
     $ngroup   = count( $keywords) ;
     if ($ngroup >1) {  
       for ($j=0 ; $j < ($ngroup-1)  ; $j++) {
          $doarr[$i][$j] = $keywords[$j] ;//��J�}�C��
       }
       $nall_stud ++ ;
     }
   }

   return $doarr ;

}
?>
