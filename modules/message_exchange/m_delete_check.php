<?php

// $Id: index.php 5310 2009-01-10 07:57:56Z hami $

/* ���o�]�w�� */
include "config.php";

sfs_check();
$use_school=$_REQUEST['use_school'];

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
$main_function = "<center>";

$back_name = "delete.php";// �e�@��php���ɦW

// �ϥΪ̿�J�ܼ�
$user = $_SESSION['session_tea_sn'];
$r_id = $_POST['r_id'];

// �T�{��ƬO�_��J���T
if ($user == ''){
  $err_message = "�ϥΪ̱b������J!!";
  header("location: ./".$back_name."?err_message=".$err_message."&r_id=".$r_id."&s_id=".$r_id);
  exit;
}

if ($r_id == ''){
  $err_message = "�T���s�������~!!";
  header("location: ./".$back_name."?err_message=".$err_message."&r_id=".$r_id."&s_id=".$r_id);
  exit;
}

// �ק��ƪ������
$sql = "DELETE FROM `".$user_t2."`";
$sql.= " WHERE `r_id` = '".$r_id."'";
$sql_result = mysql_query($sql) or die("delete error!!<BR>\n".$sql);

// �ק��ƪ������
$sql = "DELETE FROM `".$user_t1."`";
$sql.= " WHERE `r_id` = '".$r_id."'";
$sql_result = mysql_query($sql) or die("delete error!!<BR>\n".$sql);
//echo $sql;
$main_function.= "�R����".$r_id."�h�o�G���T��!!<BR>\n";
$main_function.= "[ <A HREF=\"index.php\">�^�T���`��</A>]&nbsp;";
$main_function.= "[ <A HREF='m_list.php'>�^�޲z�ǰe�T��</A> ]\n";
echo $main_function;
foot();
?>