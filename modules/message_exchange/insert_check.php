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

$back_name = "insert.php";// �e�@��s�W���iphp���ɦW

// �ϥΪ̿�J�ܼ�
$sender = $_SESSION['session_tea_sn'];
$receiver = $_REQUEST['receiver'];
$title = $_REQUEST['title'];
$message = $_REQUEST['message'];

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

//echo "<center>�޲z�̱z�n!!<BR>\n";
// �s�W�@�ӰT���O��
$sql = "insert into ".$user_t2;
$sql .= " set `title`='".$title."'";
$sql .= ", `content`='".$message."'";
$sql .= ", `sender`='".$sender."'";
$sql .= ", `receiver`='".$receiver_all."'";
$sql .= ", `m_date`=now()";
$sql_result = mysql_query($sql) or die($sql."<BR>\nsql�y�k���~!!");

// ���X��ƪ��Ҧ����i�����
$sql = "select r_id from `".$user_t2."`";
$sql .= " where `sender`='".$sender."'";
$sql .= " and `receiver`='".$receiver_all."'";
$sql .= " order by m_date desc";
//echo $sql."|<BR>\n";
$sql_result = mysql_query($sql) or die($sql."<BR>\nsql�y�k���~!!");
$row_id = mysql_fetch_array($sql_result);
$new_r_id = $row_id[0];


// �s�W�C�ӱ����̤��T�����e
$sql = "insert into ".$user_t1;
$sql .= " ( `rece_id`,`send_id`, `r_id`) values";
for($i=0;$i<count($receiver);$i++){
  $sql .= " ( '".$receiver[$i]."','".$sender."','".$new_r_id."')";
  if (($i+1)==count($receiver)){
    $sql .= ";";
  }else{
    $sql .= ", ";
  }
}
//echo  $sql."<BR>\n";
$sql_result = mysql_query($sql) or die($sql."<BR>\nsql�y�k���~!!");

//echo $sql."<BR>\n";
$main_function.= "�s�W�u".count($receiver)."�ӡv����̤��T������!!<BR>\n";
$main_function.= "[<A HREF=\"index.php\">�T���`��</A>]<BR>\n";

echo $main_function;
foot();
?>
