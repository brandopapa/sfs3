<?php
//$Id: a_list_author2.php 7708 2013-10-23 12:19:00Z smallduh $
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
    
    $class_year_p = class_base($curr_year_seme); //�Z��    

    //���O��w===================================================
    if ($book_id) 
      $sqlstr =  "select * from magazine  where id='$id'  " ;  
    else 
      $sqlstr =  "select * from magazine  order by num DESC " ;   
    //�ثe�̪�@��
    if ($result) {
        $result = $CONN->Execute($sqlstr); 
        if ($result) {
              $row=$result->FetchRow();
              $book_num = $row["num"] ; //���o���O    
              $book_id = $row["id"] ;
              $publish_date = $row["publish_date"] ;
              $is_fin = $row["is_fin"] ;    
              $bdate = $row["ed_begin"] ;
              $edate = $row["ed_end"] ;
              $editors =  $row["admin"] ;         //�s��s

              if (date("Y-m-d")<$bdate or date("Y-m-d")>$edate) $is_timeout = 1 ;

        }
        else $empty_fg = TRUE ;
    }
    else {
      //�䤣�����@�����  
      $empty_fg = TRUE ;

    }  

  if (!check_is_man2($editors)) {
     echo "�A�D�����s��s�����A�L�v���榹�\��I" ;
     redir("paper_list.php?book_num=$book_id&chap_num=$chap_num" ,2) ;
     exit ;
  }    
    

//-----------------------------------------------------------------    

    if ($empty_fg) {
       echo "��Ʈw�O�Ū��A�Х��i�J<���O�޲z>�ﶵ�A�إ߷s�@���q�l�եZ���e�I" ;   
       exit ;
    }        
    
//----------------------------------------------    
      
    $sqlstr =  "select p.title, p.tmode ,p.author ,p.class_name, c.book_num ,c.chap_name ,c.id from magazine_paper p,magazine_chap c
                where p.chap_num  = c.id and c.book_num = '$id'
                and p.tmode <=1  order by  p.classnum ,p.tmode  " ;   
    //���
    $result = $CONN->Execute($sqlstr); 
    while ($row=$result->FetchRow()) {
   	 $d[chap_name]= "\"" . $row["chap_name"]  ."\"" ;
   	 $d[title]= "\"" . trim($row["title"])  ."\"" ;

   	 $d[classnum]= "\"" . $row["class_name"] ."\"" ;
   	 $d[author]= "\"" . $row["author"]  ."\"" ;
   	 
   	 reset($d) ;
         $data[]=implode(",",$d);
    }   
    $main=implode("\n",$data);
    

    $filename="author.csv";

	//�H��y�覡�e�X ooo.csv
	header("Content-disposition: attachment; filename=$filename");
	header("Content-type: text/x-csv");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");

	echo "���O,�@�~�W��,�Z��,�m�W\n" . $main;
 ?>
