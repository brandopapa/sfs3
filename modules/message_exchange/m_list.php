<?php

// $Id: index.php 5310 2009-01-10 07:57:56Z hami $

/* ���o�]�w�� */
include "config.php";

sfs_check();
//$use_school=$_REQUEST['use_school'];


//�q�X����
head("�T���ǻ�");
?>
<style type="text/css">
<!--
.calendarTr {font-size:12px; font-weight: bolder; color: #006600}
.calendarHeader {font-size:12px; font-weight: bolder; color: #cc0000}
.calendarToday {font-size:12px; background-color: #ffcc66}
.calendarTheday {font-size:12px; background-color: #ccffcc}
.calendar {font-size:11px;font-family: Arial, Helvetica, sans-serif;}
.dateStyle {font-size:15px;font-family: Arial; color: #cc0066; font-weight: bolder}
-->
</style>
<?php
$main_function = "";
$PHP_SELF = $_SERVER['PHP_SELF'];

$main_function.= "<center><FONT SIZE='5' COLOR='#000099'>�w�ǰe�T���C��</FONT><BR><BR>\n";
//$main_function.= "[<A HREF=\"admin.php\">�޲z����</A>]<BR><BR>\n";

//����
$page = $_GET['page'];
if ($page==""){
  $page=1;
}
$page_num=($page-1)*$page_unit;

// ���X��ƪ��Ҧ����i�����
$sql = "select b.r_id as MID, b.title as title, b.receiver as receiver, b.m_date as board_date ";
$sql .= " from ".$user_t2." as b";
$sql .= " where b.sender = '".$_SESSION['session_tea_sn']."'";
$sql .= " order by MID desc";
$sql .= " limit ".$page_num.", ".$page_unit.";";
//echo $sql."|<BR>\n";
$sql_result = mysql_query($sql) or die($sql."<BR>\nsql�y�k���~!!");

if (mysql_num_rows($sql_result)==0){
  $main_function.= "<center>�ثe�S������T���s�b!!<br>\n";
  $main_function.= "[<A HREF=\"insert.php\">�s�W�T��</A>]&nbsp;&nbsp;\n";
  $main_function.= "[<A HREF=\"m_list.php\">�޲z�ǰe�T��</A>]<BR>\n";
  echo $main_function;
  exit;
}

// �p�⦳�h�֫h�T��
$sql_1 = "select count(*) ";
$sql_1 .= " from `".$user_t2."`";
$sql_1 .= " where `sender` = '".$_SESSION['session_tea_sn']."'";
$sql_result_1 = mysql_query($sql_1);
$board_num = mysql_fetch_array($sql_result_1);
$page_total=ceil($board_num[0]/$page_unit);// �N���i�ư��H�C���e�{���ƫ�L����i��
for ($j=1;$j<=$page_total;$j++){
  if ($j==$page){
    $main_function.= "[<a href='".$PHP_SELF."?page=".$j."'>";
    $main_function.= "<FONT SIZE='4' COLOR='#FF0000'>".$j."</FONT></a>] ";
  }else{
    $main_function.= "[<a href='".$PHP_SELF."?page=".$j."'>";
    $main_function.= "<FONT SIZE='2' COLOR='#00CCFF'>".$j."</FONT></a>] ";
  }
}

$i=$page_num+1;
$main_function.= "<table>\n";
$main_function.= "<tr bgcolor='#CCCCFF'>\n";
$main_function.= "<td><center>�Ǹ�</td>\n";
$main_function.= "<td><center>�ǰe�T�����D</td>\n";
$main_function.= "<td><center>�T��������(�Ŧr�����\Ū�T����)</td>\n";
$main_function.= "<td><center>�ǰe�T�����</td>\n";
$main_function.= "<td><center>�B�z�\��</td>\n";
$main_function.= "</tr>\n";
while ($row = mysql_fetch_array($sql_result)){
  if($i%2){
	$main_function.= "<tr bgcolor='#E1E1E1'>\n";
  }else{
	$main_function.= "<tr bgcolor='#FFFFFF'>\n";  
  }
  $rece_list = receiver_list($row['receiver'],$row['MID']);
  $main_function.= "<td>".$row['MID']."</td>\n";
  $main_function.= "<td>";
  $main_function.= "<A HREF='m_detail.php?r_id=".$row['MID']."&s_id=".$i."'>";
  $main_function.= $row['title']."</A></td>\n";
  $main_function.= "<td>".$rece_list."</td>\n";
  $main_function.= "<td>".$row['board_date']."</td>\n";
  if(strpos($rece_list,"<A HREF")>0){
    $main_function.= "<td>[ �ק� ]\n";
  }else{
    $main_function.= "<td>[ <A HREF='m_modify.php?r_id=".$row['MID']."&s_id=".$i."'>�ק�</A> ]\n";
  }
  $main_function.= "&nbsp;[ <A HREF='m_delete.php?r_id=".$row['MID']."&s_id=".$i."'>�R��</A> ]</td>\n";
  $main_function.= "</tr>\n";
  $i++;
}
$main_function.= "</table>\n";

$main_function.= "<BR>\n\n";
$main_function.= "[<A HREF=\"index.php\">�T���`��</A>]<BR>\n";


echo $main_function;
foot();
?>