<?php
//$Id: a_main.php 5438 2009-03-18 08:55:57Z wkb $
    include_once( "config.php") ;
    
    // --�{�� session 
    sfs_check();

//�D�޲z�� 
$SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'] ;
if ( !checkid($SCRIPT_FILENAME,1)){
      Header("Location: index.php"); 
}               
 
 head("���O�޲z");
 print_menu($m_menu_p);
?>
 
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr><td valign=top bgcolor="#CCCCCC">

<table width="85%" border="0" cellspacing="0" cellpadding="4" align="center">
  <tr> 
    <td width="20%" > 

    </td>
    <td width="60%" > 
      <h1 align="center">�q�l�եZ�޲z</h1>
    </td>
    <td width="20%"> 
      <p align="center"><a href="a_main_admin.php">�s�W�@��</a></p>
    </td>
  </tr>
  <tr> </tr>
</table>
<table width="85%" border="1" cellspacing="0" cellpadding="4" align="center" bordercolorlight="#6666FF" bordercolordark="#FFFFFF" bgcolor="#99CCFF">
  <tr>
    <td width="27%">���</td>
    <td width="41%">���O</td>
    <td width="32%">�椸�s��</td>
  </tr>
<?
    $sqlstr =  "select * from magazine  order by num DESC " ;   
    $result = $CONN->Execute($sqlstr) or die ($sqlstr); 
    if ($result) 
        while ( $row=$result->FetchRow() ) {
          $book_num = $row["num"] ; //���o���O    
          $id = $row["id"] ;
          $publish_date = $row["publish_date"] ;
          $is_fin = $row["is_fin"] ;
          echo "<tr><td>$publish_date</td>";
          echo "<td>\n";
		  echo "<a href=\"a_main_admin.php?id=$id\">�� $book_num ���ק�</a>";
		  if (!$is_fin) {
		    echo "|<a href=\"a_main_admin.php?id=$id&del=1\">�R��</a>";
		  }
		  echo "|<a href=\"a_list_author2.php?id=$id\">�C�X�@�~�ǥͦW��</a>";
		  echo "</td>\n";
          if ($is_fin) echo "<td>�����w����</td> ";
          else echo "<td><a href=\"a_pagemode.php?book_num=$id\">�]�w�椸</a> | <a href='a_real_del.php'>�M�z�U���U</a></td>" ;
          echo "</tr>" ;
        }   
?>  

</table>
<br>
</td></tr></table>
<? foot(); ?>
