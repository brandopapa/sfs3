<?php
//$Id: paper_list.php 8670 2015-12-24 06:39:10Z qfon $
  include_once( "config.php" );
  //session_start();
  //session_register("session_log_id");

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

    $sqlstr =  "select * from magazine  order by num DESC " ;   
    //�ثe�̪�@��
    $result = $CONN->Execute( $sqlstr) ;
    if ( $result ) {
              $row=$result->FetchRow()  ;
              $book_num = $row["num"] ; //���o���O    
              $id = $row["id"] ;
              $publish_date = $row["publish_date"] ;
              $is_fin = $row["is_fin"] ;    
              $bdate = $row["ed_begin"] ;
              $edate = $row["ed_end"] ;
              $editors =  $row["admin"] ;         //�s��s

              if (date("Y-m-d")<$bdate or date("Y-m-d")>$edate) $is_timeout = 1 ;

    }

    if (check_is_man2($editors)) {
       //�֥μf�Z�v 
       $is_editor = 1 ;	
    }  
    
    head("�W�ǧ@�~");
?>
<style type="text/css">
<!--
.td_s {  background-color: #FFCC99; text-align: center}
.tr_m {  background-color: #CCCCCC; text-align: center}
-->
</style>
</head>
<body bgcolor="#FFFFFF">

<form method="post" action="">
<? print_menu($m_menu_p); ?>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr><td valign=top bgcolor="#CCCCCC"  align="center">
        <h3 >��<? echo $book_num ?>���q�l�եZ</h3>
        �ǥͤW�Ǵ���:<? echo "$bdate �� $edate" ; ?>

<?php
    if (!$id) {
       echo "��Ʈw�O�Ū��A�Х��i�J<���O�޲z>�ﶵ�A�إ߷s�@���q�l�եZ���e�I" ;   
       exit ;
    }      
    
	$id=intval($id);
    if ($is_editor) 
       $sqlstr =  "select * from magazine_chap where book_num=$id  and cmode<=5  order by chap_sort " ;   
    else 
       $sqlstr =  "select * from magazine_chap where book_num=$id  and cmode<=5  and stud_upload = 1 order by chap_sort " ;   
       
    //���B�U���`�n�W��
    $result = $CONN->Execute($sqlstr);
    if ($result) {
       while ($row=$result->FetchRow()) {
       	      $tname = $row["chap_name"] ;
              $tid = $row["id"] ;
              if (!$chap_num) $chap_num=$tid ;
              
              $chap_array[$tid] = $tname ;
              
       }
       //��� ;
       $tchap_name = print_chap_item($book_num, $chap_num , $chap_array ) ;
    }       

  echo "<p>$tchap_name" ;
  if (!$is_fin) {
     if (!$is_timeout)    
        echo "<a href='upload.php?book_num=$book_num&chap_num=$chap_num'>�ǥͲĤ@���W��</a> &nbsp;|&nbsp; " ;
     echo "<a href='ed_upload.php?book_num=$book_num&chap_num=$chap_num'>�s��s�W��</a>" ;
  }

  ?>
  </p>
  <table width="95%" border="1" cellspacing="0" cellpadding="4" bgcolor="#FFCC99" bordercolorlight="#333333" bordercolordark="#FFFFFF" align="center">
    <tr> 
      <td width="14%">�Z��</td>
      <td width="42%">���D(�d��)</td>
      <td width="16%">�@��</td>
      <td width="13%">�s��</td>
      <td width="15%" bgcolor="#CCCCFF"> �s��s </td>
    </tr>
    <?php
    
    //�����`�w�W�Ǫ��峹
    $sqlstr =  "select * from magazine_paper where chap_num=$chap_num order by classnum" ;   
 
    $result = $CONN->Execute($sqlstr);
    if ($result) 
       while ($row=$result->FetchRow()) {
          $paper_id = $row["id"] ;     
          $title = $row["title"] ;   
          $author = $row["author"] ; 

          $classnum = $row["class_name"] ;
          $isDel = $row["isDel"] ; 
          $editor = $row["editId"] ; 

          echo "<tr>" ;
          echo "<td>$classnum </td>" ;
          echo "<td>" ;
          if ($isDel) echo "<img src='images/trash.gif' border='0' alt='�n�R��' >" ;
          echo "<a href=\"showpaper.php?paper_id=$paper_id\">$title </a></td>" ;
          echo "<td>$author</td>" ; 
          
          if ($is_fin or $is_timeout)
              echo "<td>�D�W�Ǵ���</td>" ;
          else 
              echo "<td><a href=\"upload.php?book_num=$book_num&chap_num=$chap_num&paper_id=$paper_id\">���s�W��</a></td>" ;   
          
          if ($is_fin)
            echo "<td bgcolor=\"#CCCCFF\">�����w����</td>" ;
          else {    
            echo "<td bgcolor=\"#CCCCFF\"><a href=\"editor.php?paper_id=$paper_id\">�f�Z</a> " ; 
            if ($editor) echo "<img src='images/ok.gif' border='0' alt='�w�f�Z($editor)' title='�w�f�Z($editor)' />" ;
            echo "</td> " ;
          }     
          echo "</tr>\n" ;
       }
?> 
  </table><br>
</td></tr></table>
</form>
<? foot(); ?>
