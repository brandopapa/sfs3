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

$r_id = $_REQUEST['r_id'];
$s_id = $_REQUEST['s_id'];

$main_function.= "<center><FONT SIZE='5' COLOR='#66CCFF'>�ӤH�T���\��!!</FONT><BR><BR>\n";

// �ק��ƪ������r_check   	  r_date 
$sql = "update ".$user_t1;
$sql .= " set `r_check`='1'";
$sql .= ", `r_date`=now()";
$sql .= " where `r_id` = '".$r_id."'";
$sql .= " and `rece_id` = '".$_SESSION['session_tea_sn']."'";
$sql_result = mysql_query($sql) or die($sql."sql�y�k���~!!");

// ���X��ƪ��Y�@�h�����
$sql = "select * from ".$user_t2;
$sql .= " where `r_id` = '".$r_id."' ";
$sql_result = mysql_query($sql) or die($sql."sql�y�k���~!!");

// ���i�Ӷ����e
$row = mysql_fetch_array($sql_result);

$main_function.= "<table>\n";
$main_function.= "<tr>\n";
$main_function.= "<td bgcolor='#FFFFCC'>\n";
$main_function.= "�Ǹ�";
$main_function.= "</td>\n";
$main_function.= "<td bgcolor='#CCFFFF'>\n";
$main_function.= $s_id;
$main_function.= "</td>\n";
$main_function.= "</tr>\n";

$main_function.= "<tr>\n";
$main_function.= "<td bgcolor='#FFFFCC'>\n";
$main_function.= "�T�����D";
$main_function.= "</td>\n";
$main_function.= "<td bgcolor='#CCFFFF'>\n";
$main_function.= $row['title'];
$main_function.= "</td>\n";
$main_function.= "</tr>\n";

$main_function.= "<tr>\n";
$main_function.= "<td bgcolor='#FFFFCC'>\n";
$main_function.= "�T�����e";
$main_function.= "</td>\n";
$main_function.= "<td bgcolor='#CCFFFF'>\n";
$main_function.= nl2br($row['content']);
$main_function.= "</td>\n";
$main_function.= "</tr>\n";

$main_function.= "<tr>\n";
$main_function.= "<td bgcolor='#FFFFCC'>\n";
$main_function.= "�T���o�e��";
$main_function.= "</td>\n";
$main_function.= "<td bgcolor='#CCFFFF'>\n";
$user_name = new user_info;//��Xuser id�������m�W
$user_name -> receiver_name($row['sender']);
$main_function.= $user_name->uname;
$main_function.= "</td>\n";
$main_function.= "</tr>\n";

$main_function.= "<tr>\n";
$main_function.= "<td bgcolor='#FFFFCC'>\n";
$main_function.= "�T�����";
$main_function.= "</td>\n";
$main_function.= "<td bgcolor='#CCFFFF'>\n";
$main_function.= $row['m_date'];
$main_function.= "</td>\n";
$main_function.= "</tr>\n";

$main_function.= "</table>\n";
$main_function.= "[ <A HREF='index.php'>�^�T���`��</A> ]\n";

echo $main_function;
foot();
?>