<?php

// $Id: signList.php 6999 2012-11-13 03:09:01Z infodaes $

include "config.php";

//sfs_check();
//�W�[���
$rs01=$CONN->Execute("select is_hide from sign_kind where 1");
if(!$rs01) $CONN->Execute(" ALTER TABLE sign_kind ADD is_hide TINYINT DEFAULT '0' NOT NULL  " );

   
  head("�Z�ų��W��") ;
  print_menu($menu_p);
?>

<table width="100%" border='1' cellspacing='0' cellpadding='4' bgcolor='#CCFFFF' bordercolor='#33CCFF'>
   
  <tr bgcolor="#66CCFF"> 
    <td >���A</td>
    <td >���W��W��</td>
    <td >����</td>
    <td >�޲z</td>
  </tr>
<?php

  //���ƭp��
  $showpage = ($_GET[showpage]) ? $_GET[showpage] : $_POST[showpage] ;
  $sqlstr = " SELECT * FROM sign_kind order by id DESC " ;
  
  $result = $CONN->Execute( $sqlstr) ;
  if ($result) {
    $totalnum = $result->RecordCount() ;
    $totalpage =ceil( $totalnum / $page_num) ;
    
    if (!$showpage)  $showpage = 1 ;  
  } 
  if (!$totalpage) $totalpage= 1 ;  
  if ($showpage > $totalpage) $showpage= $totalpage ;  
  
  
  //�C�X���

    //$sqlstr =" select *  from sign_kind  order by id DESC LIMIT $b , 10   ";
    $result = $CONN->PageExecute($sqlstr, $page_num , $showpage );

    //$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
    while ($row = $result->FetchRow() ) {
      $id = $row["id"] ;	
      $beg_date = $row["beg_date"] ;	
      $end_date = $row["end_date"] ;	
      $doc = $row["doc"] ;	
      $title = $row[title] ;
	  
	  $admin = $row['admin'] ;
	
      echo "<tr>\n" ;
	  
	  //�޲z�ˬd
		if($admin=='' or $admin==$_SESSION['session_tea_sn']) $admin_link=" | &nbsp;<a href=\"signAdmin.php?id=$id&do=edit\"><img src=\"images/medit.gif\" border=\"0\" alt=\"�ק���W��\" title=\"�ק���W��\"></a>
		&nbsp; | &nbsp;
		<a href=\"javascript:if(confirm('�T�w�n�R��?\\n�w���W��Ʒ|�@�֧R���I'))location='signAdmin.php?id=$id&do=delete'\"><img src=\"images/delete.gif\" border=\"0\" alt=\"�R��\" title=\"�R��\"></a>"; else $admin_link='';
      
      //�����ˬd    
      if (date("Y-m-d")>=$beg_date and date("Y-m-d")<=$end_date) 
         echo " <td nowrap><a href=\"signin.php?id=$id\"><img src=\"images/edit.gif\" border=\"0\" alt=\"�����\">�����</a></td>" ;
      else 
         echo " <td nowrap><img src=\"images/stop.gif\" border=\"0\" alt=\"�������\">����</td>" ; 
      echo "  
          <td >$title</td>
    <td >" . nl2br($doc) ."</td>
    <td nowrap>
      <div align=\"center\"  ><a href=\"signView.php?id=$id\"><img src=\"images/view.gif\" border=\"0\" alt=\"�d�ݳ��W���\" title=\"�d�ݳ��W���\"></a>
      &nbsp; $admin_link
      </div>
    </td>
  </tr>" ;
  }
?>  

</table>
<?

echo show_page_point($showpage, $totalpage) ;    
foot();
?>
