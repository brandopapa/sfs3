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

$back_name = "m_modify.php";// �e�@��php���ɦW

// �ϥΪ̿�J�ܼ�
$sender = $_SESSION['session_tea_sn'];
$receiver = $_REQUEST['receiver'];
$title = $_REQUEST['title'];
$message = $_REQUEST['message'];
$r_id = $_REQUEST['r_id'];

//echo $receiver[0]."|<BR>\n";
//echo $receiver[1]."|<BR>\n";
//echo $receiver[2]."|<BR>\n";
$receiver_all = implode(",",$receiver);
//echo $receiver_all."|<BR>\n";
//exit;

// �T�{��ƬO�_��J���T
if (count($receiver) == 0){
  $err_message = "����̥���J!!";
  header("location: ./".$back_name."?err_message=".$err_message);
  exit;
}

// �T�{���i��J����ƬO�_���T
if ($title == ''){
  $err_message = "�T�����D����J!!";
  header("location: ./".$back_name."?err_message=".$err_message);
  exit;
}

if ($message == ''){
  $err_message = "�T�����e����J!!";
  header("location: ./".$back_name."?err_message=".$err_message);
  exit;
}

if ($r_id == ''){
  $err_message = "�T���s�����~!!";
  header("location: ./".$back_name."?err_message=".$err_message);
  exit;
}

//echo "<center>�޲z�̱z�n!!<BR>\n";
// �s�W�@�ӰT���O��
$sql = "update ".$user_t2;
$sql .= " set `title`='".$title."'";
$sql .= ", `content`='".$message."'";
$sql .= ", `sender`='".$sender."'";
$sql .= ", `receiver`='".$receiver_all."'";
$sql .= ", `m_date`=now()";
$sql .= " where `r_id` = '".$r_id."';";
$sql_result = mysql_query($sql) or die($sql."<BR>\nsql�y�k���~!!");

// �ק��ƪ������
$sql = "DELETE FROM `".$user_t1."`";
$sql.= " WHERE `r_id` = '".$r_id."'";
$sql_result = mysql_query($sql) or die("delete error!!<BR>\n".$sql);
//echo $sql;

// �s�W�C�ӱ����̤��T�����e
$sql = "insert into ".$user_t1;
$sql .= " ( `rece_id`,`send_id`, `r_id`) values";
for($i=0;$i<count($receiver);$i++){
  $sql .= " ( '".$receiver[$i]."','".$sender."','".$r_id."')";
  if (($i+1)==count($receiver)){
    $sql .= ";";
  }else{
    $sql .= ", ";
  }
}
//echo  $sql."<BR>\n";
$sql_result = mysql_query($sql) or die($sql."<BR>\nsql�y�k���~!!");

//echo $sql."<BR>\n";
$main_function.= "�ק�ġu".$r_id."�v�h�T������!!<BR>\n";
$main_function.= "[ <A HREF='index.php'>�^�T���`��</A> ]&nbsp;";
$main_function.= "[ <A HREF='m_list.php'>�^�޲z�ǰe�T��</A> ]\n";

echo $main_function;
foot();
?>