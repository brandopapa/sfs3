<?php
                                                                                                                             
// $Id: ekind.php 8673 2015-12-25 02:23:33Z qfon $

/***********************
 �C�Ǵ��Z�Ÿ�ƦC��
 
 �C�Ǵ��ݼW�[�Z�Ŷi�ӡA
 ���½ҦѮv�i�H��Z�ū��w�@�~�C
 
 ���{���v�����t�κ޲z�� 
 �b �t�κ޲z > �ǰȵ{���]�w > ���v�޲z���{��
 ***********************/

// --�t�γ]�w��
include "exam_config.php";

//�P�O�O�_���t�κ޲z��
$man_flag = checkid($_SERVER[SCRIPT_FILENAME],1) ;

if (!$man_flag) {	
	$str = "�A���Q���v�ϥΥ��\��A�ѦҨt�λ�����" ;
	redir_str("exam.php",$str,3) ;
	exit;
}

if(!checkid(substr($_SERVER[PHP_SELF],1))){
	$go_back=1; //�^��ۤw���{�ҵe��  
	include "header.php";
	include "$rlogin";
	include "footer.php"; 
	exit;
}

$class_seme_p = get_class_seme(); //�Ǧ~��

if($_POST[curr_year_seme]=='')	//�w�]���Ǵ�
	$curr_year_seme = sprintf("%03s%d",curr_year(),curr_seme());
else
	$curr_year_seme = $_POST[curr_year_seme];

$e_kind_id = $_GET[e_kind_id];

//�����i�ܳB�z
if ($_GET[sel_open] !="") {
	//�ثe�Ǧ~�Ǵ�	
	$query = "update exam_kind ";
	if ($_GET[sel_open] == "allyes") 
		$query .= "set e_kind_open=1 ";
	else if ($_GET[sel_open] == "allno") 
		$query .= "set e_kind_open=0 ";
	$query .= "where class_id like '$curr_year_seme%' ";
	$CONN->Execute($query);
}
//�����W�ǳB�z
if ($_GET[sel_upload] !="") {	
	
	$query = "update exam_kind ";
	if ($_GET[sel_upload] == "allyes") 
		$query .= "set e_upload_ok=1 ";
	else if ($_GET[sel_upload] == "allno") 
		$query .= "set e_upload_ok=0 ";
	$query .= "where class_id like '$curr_year_seme%' ";
	//echo $query;
	$CONN->Execute($query);
}
//���i�ܳ]�w
if ($_GET[sel_o] !="") {
	$query= "update exam_kind set ";
	if ($_GET[sel_o] == "yes")
		$query .= "e_kind_open = 1 ";
	else if ($_GET[sel_o]=="no")
		$query .= "e_kind_open = 0 ";
	$query  .= "where e_kind_id='$e_kind_id' ";	
	$CONN->Execute($query);
}

//���W�ǳ]�w
if ($_GET[sel_u] !="") {
	$query= "update exam_kind set ";
	if ($_GET[sel_u] == "yes")
		$query .= "e_upload_ok = 1 ";
	else if ($_GET[sel_u]=="no")
		$query .= "e_upload_ok = 0 ";
	$query  .= "where e_kind_id='$e_kind_id' ";	
	$CONN->Execute($query);
}
include "header.php";
include "menu.php";

//�L�X�Ǵ�
echo "<form name=myform action=\"$_SERVER[PHP_SELF]\" method=post>";
echo "<h3>";//<select name=\"curr_year_seme\" onchange=\"this.form.submit()\">\n";
$sel1 = new drop_select();
$sel1->s_name = "curr_year_seme";
$sel1->id = $curr_year_seme;
$sel1->has_empty = false;
$sel1->is_submit = true;
$sel1->arr = $class_seme_p;
$sel1->do_select();

echo "-- �Z�ź޲z</form></h3>";
?>
<table border=1 >
  <tbody>
    <tr>
      <td bgColor="#80ffff">�Z��</td>      
      <td bgColor="#80ffff">����</td>
      <td bgColor="#80ffff">���}�i��<br><a href="<?php echo "$_SERVER[PHP_SELF]?sel_open=allyes" ?>">�����ҬO</a><br><a href="<?php echo "$_SERVER[PHP_SELF]?sel_open=allno" ?>">�����ҧ_</a></td>
      <td bgColor="#80ffff">�}��W��<br><a href="<?php echo "$_SERVER[PHP_SELF]?sel_upload=allyes" ?>">�����ҬO</a><br><a href="<?php echo "$_SERVER[PHP_SELF]?sel_upload=allno" ?>">�����ҧ_</a></td>
      <td colspan=2 bgColor="#80ffff">�s�װʧ@</td>
    </tr>
 
<?php
///mysqli	
$mysqliconn = get_mysqli_conn();
$stmt = "";
$s_str = "$curr_year_seme%";
$stmt = $mysqliconn->prepare("select e_kind_id,e_kind_memo,e_kind_open,e_upload_ok,class_id  from exam_kind where class_id like ? order by class_id");
$stmt->bind_param('s', $s_str);
$stmt->execute();
$stmt->bind_result($e_kind_id,$e_kind_memo,$e_kind_openx,$e_upload_okx,$class_id);
$i=0;
while ($stmt->fetch()) {
	$temp_class_name = get_class_name($class_id); //���o�Z��	
	if ($e_kind_openx=='1') 
		$e_kind_open = "<font color=red><b>�O</b></font>&nbsp;�U&nbsp;<a href=\"$_SERVER[PHP_SELF]?e_kind_id=$e_kind_id&sel_o=no\">�_</a>";
	else 
		$e_kind_open = "<a href=\"$_SERVER[PHP_SELF]?e_kind_id=$e_kind_id&sel_o=yes\">�O</a>&nbsp;�U&nbsp;<font color=red><b>�_</b></font>";
		
	if ($e_upload_okx=='1') 
		$e_upload_ok = "<font color=red><b>�O</b></font>&nbsp;�U&nbsp;<a href=\"$_SERVER[PHP_SELF]?e_kind_id=$e_kind_id&sel_u=no\">�_</a>";
	else 
		$e_upload_ok = "<a href=\"$_SERVER[PHP_SELF]?e_kind_id=$e_kind_id&sel_u=yes\">�O</a>&nbsp;�U&nbsp;<font color=red><b>�_</b></font>";

	if ($i % 2 == 0) 
		$bg = "bgColor=\"#ffff80\"";
	else
		$bg = "";
	echo "<tr $bg > <td>$temp_class_name</td> <td>$e_kind_memo</td> <td>$e_kind_open</td> <td>$e_upload_ok</td> <td><a href=\"ekind_edit.php?e_kind_id=$e_kind_id&class_id=$class_id\">�ק�</a></td> <td><a href=\"ekind_edit.php?sel=delete&e_kind_id=$e_kind_id&class_id=$class_id\">�R��</a></td> </tr>";
	$i++; 

}

///mysqli

/*
$sql_select = "select e_kind_id,e_kind_memo,e_kind_open , e_upload_ok ,class_id  from exam_kind where  class_id like '$curr_year_seme%' order by class_id ";
$result = mysql_query ($sql_select)or die ($sql_select);
$i=0;
while ($row = mysql_fetch_array($result)) {

	$e_kind_id = $row["e_kind_id"];	
	$e_kind_memo = $row["e_kind_memo"];
	$class_id = $row["class_id"];

	$temp_class_name = get_class_name($class_id); //���o�Z��
	
	
	if ($row["e_kind_open"]=='1') 
		$e_kind_open = "<font color=red><b>�O</b></font>&nbsp;�U&nbsp;<a href=\"$_SERVER[PHP_SELF]?e_kind_id=$e_kind_id&sel_o=no\">�_</a>";
	else 
		$e_kind_open = "<a href=\"$_SERVER[PHP_SELF]?e_kind_id=$e_kind_id&sel_o=yes\">�O</a>&nbsp;�U&nbsp;<font color=red><b>�_</b></font>";
		
	if ($row["e_upload_ok"]=='1') 
		$e_upload_ok = "<font color=red><b>�O</b></font>&nbsp;�U&nbsp;<a href=\"$_SERVER[PHP_SELF]?e_kind_id=$e_kind_id&sel_u=no\">�_</a>";
	else 
		$e_upload_ok = "<a href=\"$_SERVER[PHP_SELF]?e_kind_id=$e_kind_id&sel_u=yes\">�O</a>&nbsp;�U&nbsp;<font color=red><b>�_</b></font>";

	if ($i % 2 == 0) 
		$bg = "bgColor=\"#ffff80\"";
	else
		$bg = "";
	echo "<tr $bg > <td>$temp_class_name</td> <td>$e_kind_memo</td> <td>$e_kind_open</td> <td>$e_upload_ok</td> <td><a href=\"ekind_edit.php?e_kind_id=$e_kind_id&class_id=$class_id\">�ק�</a></td> <td><a href=\"ekind_edit.php?sel=delete&e_kind_id=$e_kind_id&class_id=$class_id\">�R��</a></td> </tr>";
	$i++;
}
*/


?>
</tbody>
</table>
<hr size=1 width=80%>
<a href="ekind_new.php">�s�W�Z��</a>
 
<? include "footer.php"; ?>
