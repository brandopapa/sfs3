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
$main_function = "<center>";
$main_function1 = "";
$main_function2 = "";

$err_message = $_GET['err_message'];
$check_button = $_POST['check_button'];
if ($err_message <> ''){
  $main_function.= "<FONT SIZE='7' COLOR='#FF0000'>".$err_message."</FONT>";
}

$php_name = "m_modify.php";
$submit_name1 = "�T�w�e�X";
$submit_name2 = "�s�W";
$submit_name3 = "�R��";
$submit_name4 = "�j�M";


if($check_button == $submit_name1){
	// �ϥΪ̿�J�ܼ�
	$sender = $_SESSION['session_tea_sn'];
	$selected_u = $_REQUEST['selected_u'];
	$receiver = explode("|",$selected_u);
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
	  header("location: ./".$php_name."?err_message=".$err_message);
	  exit;
	}

	// �T�{���i��J����ƬO�_���T
	if ($title == ''){
	  $err_message = "�T�����D����J!!";
	  header("location: ./".$php_name."?err_message=".$err_message);
	  exit;
	}

	if ($message == ''){
	  $err_message = "�T�����e����J!!";
	  header("location: ./".$php_name."?err_message=".$err_message);
	  exit;
	}

	if ($r_id == ''){
	  $err_message = "�T���s�����~!!";
	  header("location: ./".$php_name."?err_message=".$err_message);
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
}else{
	//web url parameter
	$r_id = $_REQUEST['r_id'];
	$s_id = $_REQUEST['s_id'];

	$removeselect = $_REQUEST['removeselect'];
	$addselect = $_REQUEST['addselect'];
	$select_user = $_REQUEST['select_user'];
	$searchtext = $_REQUEST['searchtext'];
	$selected_u = $_REQUEST['selected_u'];
	$title = $_REQUEST['title'];
	$message = $_REQUEST['message'];
	$check_user_list = array();
    
	if($_GET['r_id'] > 0 and $_GET['s_id'] > 0 ){
	  // ���X��ƪ��Y�@�h�����
	  $sql = "select * from ".$user_t2;
	  $sql .= " where `r_id` = '".$r_id."' ";
	  $sql_result5 = mysql_query($sql) or die($sql."sql�y�k���~!!");
	  //echo $sql."|<BR>\n";
	  // ���i�Ӷ����e
	  $row5 = mysql_fetch_array($sql_result5);
	  $addselect = explode(",",$row5['receiver']);
	  $title = $row5['title'];
	  $message = $row5['content'];
    }
	//echo $selected_u."|<BR><BR>\n";

	//�N�����諸�M���e�諸user�㦨�@�Ӱ}�C
    if(strlen($selected_u)>0){
	  $selected_user = explode("|",$selected_u);
	  for($i=0;$i<count($selected_user);$i++){	    
		if(count($removeselect)>0 and $check_button == $submit_name3){
		  if(!in_array($selected_user[$i],$removeselect)){
		    $addselect[]=$selected_user[$i];
		  }
		}else{
		  $addselect[]=$selected_user[$i];
		}
	  }
	}

	$main_function.= "�T���ק�e��<BR>";
	$main_function.= "<FORM METHOD='post' id='assignform' ACTION='".$php_name."'>\n";


	// ���X��ƪ��Ҧ��ϥΪ̤����
	$sql = "select a.name, a.teacher_sn, c.title_name ";
	$sql .= " from ".$user_t3." as a, ".$user_t4." as b, ".$user_t5." as c ";
	$sql .= " where a.teacher_sn = b.teacher_sn";
	$sql .= " and b.teach_title_id = c.teach_title_id";
	$sql .= " and a.teach_condition = 0"; 
	if($check_button == $submit_name4){
	  $sql .= " and (a.name like '%".$searchtext."%'";
	  $sql .= " or c.title_name like '%".$searchtext."%')";
	}
	$sql .= " order by c.teach_title_id asc, a.name asc";
	//echo $sql."|<BR>\n";
	$sql_result = mysql_query($sql) or die($sql."<BR>\nsql�y�k���~!!");
    
	$user_total = mysql_num_rows($sql_result);

	if ($user_total==0){
	  echo "<center><FONT SIZE=\"4\" COLOR=\"#FF0000\">�ثe�����¾���s�b�A���p���޲z��!!</FONT><br>\n";
	  exit;
	}

	//�N�Ҧ�user�নuser�}�C
	while ($row = mysql_fetch_array($sql_result)){
	  $all_user[$row[1]] = $row[0];
	  $all_user_kind[$row[1]] = $row[2];
	}

	$main_function.= "��ܦ���̡G(����Ctrl�i�H��ܦh�H)<BR>\n";

	$main_function.= "<table>\n";
	$main_function.= "<tr>\n";
	$main_function.= "<td  colspan=3 bgcolor='#FFFFCC'>\n";
	$main_function.= "<center>�Ǹ��G";
	$main_function.= $s_id;
	$main_function.= "</td>\n";
    $main_function.= "</tr>\n";
	$main_function.= "<tr bgcolor='#CCFFFF'>\n";
	//�C�X�n�e�T���������
	$main_function.= "<td>\n";
    $main_function.= "���<font color='#0000CC'><B>".count($addselect)."</B></font>�즬���<br>\n";
	$main_function.= "<font size=2 color='#FF0000'>�̥[�J����</font><br>\n";
	$main_function.= "<select name='removeselect[]' size='".$page_count."' multiple='multiple'>";
	if (count($addselect)>0){
	  $s_user = new user_info;
	  //sort($addselect);
	  foreach($addselect as $k1=>$v1){
		$s_user -> receiver_name($v1);//��Xteacher_sn���������
	    $main_function.= "<option value='".$v1."'>".$s_user->uname." ".$s_user->utitle."</option>\n";
		$check_user_list[$v1] = 1;
	  }	  
	  $all_user_str = implode("|",$addselect);    
	}
	$main_function.= "</select>\n";
    $main_function.= "<input type=hidden name=selected_u value='".$all_user_str."'>";
	$main_function.= "</td>\n";
	//�s�W�άO�R�������
	$main_function.= "<td>\n";
    $main_function.= "<<<INPUT TYPE='submit' name='check_button' value='".$submit_name2."'><br>\n";
	$main_function.= "<INPUT TYPE='submit' name='check_button' value='".$submit_name3."'>>><br>\n";
	$main_function.= "</td>\n";
    //�C�X�i�H��ܪ������
	$main_function.= "<td>\n";

	$main_function2.= "<font size=2 color='#FF0000'>��¾�ٱƧ�</font><br>\n";
	$main_function2.= "<SELECT NAME='addselect[]' size='".$page_count."' multiple='multiple'>\n";
	$i1 =0;
	foreach($all_user as $k2=>$v2){
	  if ($check_user_list[$k2] <> 1){
	    $main_function2.= "<option value='".$k2."'>".$v2." ".$all_user_kind[$k2]."</option>\n";
		$i1++;
	  }
	}
	$main_function1.= "��<font color='#0000CC'><B>".$i1."</B></font>��i�蠟�����<br>\n";
	$main_function2.= "</SELECT>\n<BR>";
	$main_function2.= "</td>\n";
	$main_function2.= "</tr>\n";
	$main_function2.= "<tr bgcolor='#FFCCFF'>\n";
	$main_function2.= "<td colspan=3>\n";
	$main_function2.= "<center><input type='text' name='searchtext' size='30' value=''>";
    $main_function2.= "<INPUT TYPE='submit' name='check_button' value='".$submit_name4."'>\n";
	$main_function2.= "</td>\n";
	$main_function2.= "</tr>\n";
	$main_function2.= "<tr bgcolor='#CCFFFF'>\n";
	$main_function2.= "<td colspan=3>\n";
	$main_function2.= "<center>\n";
	$main_function2.= "�T�����D<BR><INPUT TYPE='text' NAME='title' size='20' value='".$title."'><BR>";
	$main_function2.= "�T�����e<BR><TEXTAREA NAME='message' ROWS='10' COLS='20'>".$message."</TEXTAREA><BR>";
	$main_function2.= "<INPUT TYPE='hidden' NAME='r_id' value='".$r_id."'>\n";
	$main_function2.= "<INPUT TYPE='hidden' NAME='s_id' value='".$s_id."'>\n";
	$main_function2.= "<INPUT TYPE='submit' name='check_button' value='".$submit_name1."'>";
	$main_function2.= "</td>\n";
	$main_function2.= "</tr>\n";
	$main_function2.= "</table>\n";
	$main_function2.= "</form>";
	$main_function2.= "[<A HREF=\"index.php\">�^".$MODULE_PRO_KIND_NAME."�D��</A>]<BR>\n";
	//echo "<BR>\n".$_SESSION['session_log_id']."|";
	//echo "<BR>\n".$_SESSION['session_tea_sn']."|";

	echo $main_function.$main_function1.$main_function2;
}
foot();
?>