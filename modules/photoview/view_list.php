<?php 
// $Id: view_list.php 5310 2009-01-10 07:57:56Z hami $
  // �ݤ@�����Ϥ�
  require "config.php" ;

  function get_big_list($updir){
     //���o�j�ϦC��

   if ( is_dir($updir) ) {
 
     $dirs = dir($updir) ;
     $dirs ->rewind() ;
     while ( ($filelist = $dirs->read()) and !$stop_m) {
     	 if (($filelist!=".") && ($filelist!="..")){
     	       if ( (eregi("(.jpg|.jpeg|.png|.gif|.bmp)$", $filelist))  and !(strstr($filelist,'!!!_')) )
         	 $filelist_arr[] = $filelist ;

         }
     }
     $dirs->close() ;  	
     sort ($filelist_arr) ;
     return $filelist_arr ;
   }
  }
  
//=====================================================  
  $act_dir = $_GET[act_dir] ;
  $id = $_GET[id] ;
  $now_pic_id = intval($_GET[now_pic_id]) ;


  $picdir=$htmpath . "/" .$act_dir ;
  $updir=$savepath . "/" .$act_dir ;
  
  $pic_list = get_big_list($updir) ;   
  
     //chdir($updir) ;
     
  $picnum = count($pic_list)  ;
  
  if ($now_pic_id > $picnum )
     $now_pic_id = $picnum-1 ;
  if ($now_pic_id < 0 )
     $now_pic_id = 0 ;     
  
  $now_pic =  $picdir ."/" . $pic_list[$now_pic_id] ;
   
   if ($now_pic_id>0 )
      $prev_str = "<a href=\"view_list.php?act_dir=$act_dir&id=$id&now_pic_id=" .($now_pic_id -1) ."\">&lt;&lt;�e�@�i</a>" ;
   else 
      $prev_str = "&lt;&lt;�e�@�i" ;
      
   if ($now_pic_id < $picnum-1 )   
      $next_str = "<a href=\"view_list.php?act_dir=$act_dir&id=$id&now_pic_id=" .($now_pic_id +1) ."\">��@�i&gt;&gt;</a>" ;
   else    
     $next_str = "��@�i&gt;&gt;" ;
     
   $index_str = "<a href=\"view.php?id=$id\">�D����</a> (" . ($now_pic_id+1) ."/$picnum)" ;
   
   
?>  
<html>
<head>
<title><?php $nb[act_name] ?>�ۤ�</title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">

</head>
<body bgcolor="#EEEEEE"  style="scrollbar-3d-light-color:white;
scrollbar-arrow-color:royalblue;
scrollbar-base-color:#0066ff;
scrollbar-dark-shadow-color:#00ff00;
scrollbar-face-color:#66ccff;
scrollbar-highlight-color:blueviolet;
scrollbar-shadow-color:black ;
">
<table width="40%" border="0" cellspacing="0" cellpadding="4" align="center">
  <tr>
    <td><? echo $prev_str ?></td>
    <td><? echo $index_str ?></td>
    <td><? echo $next_str ?></td>
  </tr>
</table>



<?
 echo "<div align=\"center\"><img src=\"$now_pic\"  border=\"1\"></div>" ;
?>
</html>