<?php

// $Id: citaList.php 8138 2014-09-23 08:13:03Z smallduh $

include "config.php";

sfs_check();
//�W�[���
$rs01=$CONN->Execute("select is_hide from cita_kind where 1");
if(!$rs01) $CONN->Execute(" ALTER TABLE cita_kind ADD is_hide TINYINT DEFAULT '0' NOT NULL  " );

   
head("�Ǯպa�A�]") ;
print_menu($menu_p);
?>

<table width="100%" border='1' cellspacing='0' cellpadding='4' bgcolor='#CCFFFF' bordercolor='#5555ff'>
  <tr bgcolor="#66CCFF" align="center"> 
    <td >���</td>
   <td >���A</td>
   <td >�ݩ�</td>
    <td >�a�A�]�W��</td>  
    <td >�޲z</td>
  </tr>
<?php
// �p�⦳�h�֫h���i
$user_t1 = "cita_kind";
$page_unit = "20";// �C���e�{�h�ֵ����
$page = $_REQUEST['page'];

if ($page==""){
  $page=1;
}
$page_num=($page-1)*$page_unit;

$sql_1 = "SELECT count(*) FROM ".$user_t1;
$sql_r1 = mysql_query($sql_1);
$board_num = mysql_fetch_array($sql_r1);
$page_total=ceil($board_num[0]/$page_unit);// �N���i�ư��H�C���e�{���ƫ�L����i��

$web_page_list = "";
for ($j=1;$j<=$page_total;$j++){
  if ($j==$page){
    $web_page_list.= "[<a href='".$PHP_SELF."?page=".$j."'>";
    $web_page_list.= "<FONT SIZE='4' COLOR='#FF0000'>".$j."</FONT></a>] ";
  }else{
    $web_page_list.= "[<a href='".$PHP_SELF."?page=".$j."'>";
    $web_page_list.= "<FONT SIZE='2' COLOR='#00CCFF'>".$j."</FONT></a>] ";
  }
}

    $sqlstr ="SELECT * FROM ".$user_t1." order by beg_date DESC limit ".$page_num.", ".$page_unit.";";
    $result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
    while ($row = $result->FetchRow() ) {
      $id = $row["id"] ;	
      $beg_date = $row["beg_date"] ;	
      $end_date = $row["end_date"] ;	
      $doc = $row["doc"] ;	
      $helper = $row[helper] ;
	  $external = $row['external']?'�ե~':'�դ�';
	  $bgcolor = $row['external']?'#ffcccc':'#ccffcc';
	  
      echo "<tr align='center' bgcolor='$bgcolor'><td>$beg_date</td>" ;
      
      //�����ˬd    
      if (date("Y-m-d")>=$beg_date and date("Y-m-d")<=$end_date){ 
         echo " <td ><a href=\"citain.php?id=$id\"><img src=\"images/edit.gif\" border=\"0\" alt=\"�����\">�����</a></td>" ;
		$do="�B�z�C�L";
      }else {
        echo " <td ><img src=\"images/stop.gif\" border=\"0\" alt=\"�������\">�������</td>" ; 
		$do="�d�ݦW��";
		}
      echo "<td>$external</td>       
		<td  align='left'>" . nl2br($doc) ."</td> 

		<td  align='center'>
		  <a href='citaView.php?id=$id'>$do</a>&nbsp;&nbsp; | &nbsp;&nbsp;<a href='csvout.php?id=$id'>CSV��X</a>&nbsp;&nbsp; | &nbsp;&nbsp;<a href='citaAdmin.php?id=$id&do=edit'>�ק�]�w</a>&nbsp;&nbsp; | &nbsp;&nbsp;<a href='citaAdmin.php?id=$id&do=del'>�R��</a>
		</td>
	  </tr>" ;
  }
  echo "<tr bgcolor='#ffffcc' align='center'>";
  echo "<td colspan=5>".$web_page_list."</td>";
  echo "</tr>";
?>  

</table>
<?php
foot();
?>
