<?php
                                                                                                                             
// $Id: exam.php 6807 2012-06-22 08:08:30Z smallduh $


// --�t�γ]�w��
include "exam_config.php";
// --�{�� session
//session_start();
//session_register("session_e_kind_id"); //�ثe�Z�� session


//�P�O�O�_���t�κ޲z��
$man_flag = checkid($_SERVER[SCRIPT_FILENAME],1) ;

//���Z��
if ($_SESSION[session_e_kind_id] == $_POST[c_e_kind_id] or  $_POST[c_e_kind_id]=='')
	$e_kind_id = $_SESSION[session_e_kind_id];
else {
	$e_kind_id = $_POST[c_e_kind_id];
	$_SESSION[session_e_kind_id] = $_POST[c_e_kind_id];
}


if(!checkid($_SERVER[PHP_SELF])){
	$go_back=1; //�^��ۤw���{�ҵe��  
	include "header.php";
	include "$rlogin";
	include "footer.php"; 
	exit;
}

//���i�ܳ]�w
if ($_GET[sel_open] !="") {
	$query= "update exam set ";
	if ($_GET[sel_open]=="yes")
		$query .= "exam_isopen = 1 ";
	else if ($_GET[sel_open]=="no")
		$query .= "exam_isopen = 0 ";
	$query  .= "where exam_id='$_GET[exam_id]' ";
	$CONN->Execute($query);
}

//���W�ǧ@�~�]�w
if ($_GET[sel_upload] !="") {
	$query= "update exam set ";
	if ($_GET[sel_upload]=="yes")
		$query .= "exam_isupload = 1 ";
	else if ($_GET[sel_upload]=="no")
		$query .= "exam_isupload = 0 ";
	$query  .= "where exam_id='$_GET[exam_id]' ";
	$CONN->Execute($query) or die($query);
}

include "header.php";
//
include "menu.php";
//�ثe�Ǧ~
/*
if ( $curr_year =="")
	$curr_year = sprintf("%03s",curr_year());

$curr_year_seme = sprintf("%03s%d",curr_year(),curr_seme());
*/
$class_seme_p = get_class_seme(); //�Ǧ~��

if($_REQUEST[curr_year_seme]=='')	//�w�]���Ǵ�
	$curr_year_seme = sprintf("%03s%d",curr_year(),curr_seme());
else
	$curr_year_seme = $_REQUEST[curr_year_seme];


//���o�ثe�Z�Ű}�C
$class_name = class_base();
  
//�ثe���@�~���Z��
$sql_select = "select exam_kind.class_id,exam_kind.e_kind_id  from exam,exam_kind ";
$sql_select .=" where exam.e_kind_id=exam_kind.e_kind_id and exam.teach_id ='$_SESSION[session_log_id]' and exam_kind.class_id like '$curr_year_seme%' group by exam_kind.class_id order by exam_kind.class_id  ";

$result = $CONN->Execute($sql_select) or trigger_error("SQL ���~",E_USER_ERROR);

$class_select_arr[-1]="�Ҧ��Z��";
while(!$result->EOF){
	$temp_class = substr($result->fields[class_id],-3);
	$class_select_arr[$result->fields[e_kind_id]] = $class_name[$temp_class];
	$result->MoveNext();
}
$sel = new drop_select();
$sel->s_name="c_e_kind_id";
$sel->id=$e_kind_id;
$sel->has_empty = false;
$sel->is_submit = true;
$sel->arr= $class_select_arr;
$class_select= $sel->get_select();

?>
<h3>
<?php 
echo "<form name=myform action=\"$_SERVER[PHP_SELF]\" method=post>";
echo "<h3>";//<select name=\"curr_year_seme\" onchange=\"this.form.submit()\">\n";
$sel1 = new drop_select();
$sel1->s_name = "curr_year_seme";
$sel1->id = $curr_year_seme;
$sel1->has_empty = false;
$sel1->is_submit = true;
$sel1->arr = $class_seme_p;
$sel1->do_select();
?>
�@�~�C��A���ұЮv�G<?php echo $_SESSION[session_tea_name] ?></h3>
<?php echo $class_select ?>&nbsp;�U&nbsp;<a href="exam_new.php">�s�W�@�~</a></form>
<table border=1 >
  <tbody>
    <tr>
      <td bgColor="#80ffff">�Z��</td>
      <td bgColor="#80ffff">�@�~�W��</td>
      <td bgColor="#80ffff">�}�l�i��?</td>      
      <td bgColor="#80ffff">�}�l�W�ǧ@�~?</td>
      <td colspan=2 bgColor="#80ffff">�s�װʧ@</td>
    </tr>
  <tbody>

<?php
$sql_select = "select exam.*,exam_kind.class_id  from exam,exam_kind ";
$sql_select .=" where exam.e_kind_id=exam_kind.e_kind_id and exam.teach_id ='$_SESSION[session_log_id]' and exam_kind.class_id like '$curr_year_seme%' ";
if ($e_kind_id !="-1")
	$sql_select .= " and exam.e_kind_id='$e_kind_id' ";
$sql_select .=" order by exam_kind.class_id ";
$result = $CONN->Execute($sql_select)or die ($sql_select);
$i=0;
while (!$result->EOF) {
	$exam_id = $result->fields["exam_id"];
	$exam_name = $result->fields["exam_name"];
	if ($result->fields["exam_isopen"]=='1') 
		$exam_isopen = "<font color=red><b>�O</b></font>&nbsp;�U&nbsp;<a href=\"$_SERVER[PHP_SELF]?exam_id=$exam_id&sel_open=no&c_e_kind_id=$e_kind_id&curr_year_seme=$curr_year_seme\">�_</a>";
	else 
		$exam_isopen = "<a href=\"$_SERVER[PHP_SELF]?exam_id=$exam_id&&sel_open=yes&c_e_kind_id=$e_kind_id&curr_year_seme=$curr_year_seme\">�O</a>&nbsp;�U&nbsp;<font color=red><b>�_</b></font>";
	
	if ($result->fields["exam_isupload"]=='1') 
		$exam_isupload = "<font color=red><b>�O</b></font>&nbsp;�U&nbsp;<a href=\"$_SERVER[PHP_SELF]?exam_id=$exam_id&sel_upload=no&c_e_kind_id=$e_kind_id&curr_year_seme=$curr_year_seme\">�_</a>";
	else 
		$exam_isupload = "<a href=\"$_SERVER[PHP_SELF]?exam_id=$exam_id&sel_upload=yes&c_e_kind_id=$e_kind_id&curr_year_seme=$curr_year_seme\">�O</a>&nbsp;�U&nbsp;<font color=red><b>�_</b></font>";		
	 
	$class_id = $result->fields["class_id"];
	// $class_id 0-3 ->�Ǧ~ 4->�Ǵ� 5->�~�� 6- �Z�� 	
	$c_temp = intval(substr($class_id,0,3))."�Ǧ~��";
	if (substr($class_id,3,1) == 1 )
		$c_temp .= "�W�Ǵ�";
	else
		$c_temp .= "�U�Ǵ�";
	
	$temp_class_name = $class_name[substr($class_id,-3)]; //���o�Z��
	

      if ($i % 2 == 0) 
	$bg = "bgColor=\"#ffffcc\"";
	else
	$bg = "";
      print "<tr $bg >
      <td>$temp_class_name</td>
      <td>$exam_name</td>      
      <td align=center>$exam_isopen</td>      
      <td align=center>$exam_isupload</td>            
      <td align=center><a href=\"exam_edit.php?exam_id=$exam_id&class_id=$class_id\">�ק�</a></td>      
      <td align=center><a href=\"exam_edit.php?sel=delete&exam_id=$exam_id&exam_name=$exam_name\">�R��</a></td>
     </tr>";
    $i++;
      $result->MoveNext();
}
  
?>
</tbody>
</table>
<hr size=1 width=80%>
<a href="exam_new.php">�s�W�@�~</a>
 
<? include "footer.php"; 
