<?php

// $Id: doc_edit.php 6805 2012-06-22 08:00:32Z smallduh $

//���J�]�w��
include "docword_config.php";
// session �{��
//session_start();
//session_register("session_log_id");

if(!checkid($PHP_SELF)){
	$go_back=1; //�^��ۤw���{�ҵe��
	include "header.php";
	include $SFS_PATH."/rlogin.php";
	include "footer.php";
	exit;
}
else
	$ischecked = true;
//-----------------------------------
include "header.php";
//�S���]�w�ɦ^�즬���C
if ($doc1_id == "") {
	header ("Location: doc1_list.php");
	exit;
}

if ($key =="�ק�"){
	$query = "update sch_doc1 set doc1_year_limit='$doc1_year_limit',doc1_kind='$doc1_kind',doc1_date='$doc1_date',doc1_date_sign='$doc1_date_sign',doc1_unit='$doc1_unit',doc1_word='$doc1_word',doc1_main='$doc1_main',doc1_unit_num1='$doc1_unit_num1',doc1_infile_date='$doc1_infile_date',doc_stat='$doc_stat',doc1_end_date='$doc1_end_date',teach_id='$session_log_id' where doc1_id='$doc1_id'";	
	mysql_query($query)or die ($query);
	echo "<h1><center>�s�� : $doc1_id �ק令�\!!</center></h1></body></html>";		
	redir( "$PHP_SELF?doc1_id=$doc1_id" , 1);
	exit;			
}
if ($key == "�R��"){
	$query = "delete from sch_doc1 where doc1_id = '$doc1_id' ";
	mysql_query($query)or die ($query);
	echo "<h1><center>�s�� : $doc1_id �w�R��!!</center></h1></body></html>";		
	redir( "doc1_list.php" , 1);
	exit;			
}
$sql_select = "select * from sch_doc1 where doc1_id='$doc1_id'";
$result = mysql_query ($sql_select,$conID);

while ($row = mysql_fetch_array($result)) {

	$doc1_id = $row["doc1_id"];
	$doc1_year_limit = $row["doc1_year_limit"];
	$doc1_kind = $row["doc1_kind"];
	$doc1_date = $row["doc1_date"];
	$doc1_date_sign = $row["doc1_date_sign"];
	$doc1_unit = $row["doc1_unit"];
	$doc1_word = $row["doc1_word"];
	$doc1_main = $row["doc1_main"];
	$doc1_unit_num1 = $row["doc1_unit_num1"];
	$doc1_unit_num2 = $row["doc1_unit_num2"];
	$teach_id = $row["teach_id"];
	$doc_stat = $row["doc_stat"];
	$doc1_infile_date = $row["doc1_infile_date"]; 
	$doc1_end_date = $row["doc1_end_date"];

};


prog(1); //�W��menu (�b docword_config.php ���]�w)
?>
<form action="<?php echo $PHP_SELF ?>" method = post >
<table border=1 cellpadding=0 cellspacing=0 align=center  >
<tr><td>
<table border=0 cellpadding=3 cellspacing=1  align=center bgcolor=yellow>
<tr><td bgcolor=CCCCCC colspan=2 align=center>����ק�@�~</td></tr>

<tr>
	<td align="right" valign="middle">���o�帹</td>
	<td>
	<?php
	echo $doc1_id;
	echo "<input type=hidden name=doc1_id value=\"$doc1_id\">";
	?>
	 </td>
</tr>

<tr>
	<td align="right" valign="middle">�Ӥ���</td>
	<td><input type="text" size="10" maxlength="10" name="doc1_date" value="<?php echo $doc1_date ?>">
	&nbsp;&nbsp;����ɶ� <input type="text" size="16" maxlength="19" name="doc1_date_sign" value="<?php echo $doc1_date_sign ?>"></td>
</tr>

<tr>
	<td align="right" valign="middle">�Ӥ���</td>
	<td><input type="text" size="40" maxlength="60" name="doc1_unit" value="<?php echo $doc1_unit ?>"></td>
</tr>


<tr>
	<td align="right" valign="middle">�������O</td>
	<td><select  name="doc1_kind" >
<?php
//�������O(�b docword_config.php ���]�w)
$doc_kind_p = doc_kind();
while(list($tkey,$tvalue)= each ($doc_kind_p)){
	if ($tkey == $doc1_kind)
		echo  sprintf ("<option value=\"%d\" selected>%s</option>\n",$tkey,$tvalue);
	else
		echo  sprintf ("<option value=\"%d\">%s</option>\n",$tkey,$tvalue);
}
?>
	</select></td>
</tr>



<tr>
	<td align="right" valign="middle">�Ӥ�r��</td>
	<td><input type="text" size="60" maxlength="60" name="doc1_word" value="<?php echo $doc1_word ?>"></td>
</tr>


<tr>
	<td align="right" valign="top">�Ӥ�K�n</td>
	<td><input type="text" name="doc1_main" size="60" value="<?php echo $doc1_main ?>"></td>
</tr>


<tr>
	<td align="right" valign="middle">�ӿ���</td>
	<td><select name=doc1_unit_num1>
<?php
//�ӿ�B��(�b docword_config.php ���]�w)
$doc_unit_p = doc_unit();
while(list($tkey,$tvalue)= each ($doc_unit_p)){
	if ($tkey == $doc1_unit_num1)
		echo  sprintf ("<option value=\"%d\" selected>%s</option>\n",$tkey,$tvalue);
	else
		echo  sprintf ("<option value=\"%d\">%s</option>\n",$tkey,$tvalue);
}

?>
	</select>
&nbsp;&nbsp;�O�s�~�� <select name=doc1_year_limit>
<?php
//�O�s�~��(�b docword_config.php ���]�w)
$doc_life_p = doc_life();
while(list($tkey,$tvalue)= each ($doc_life_p)){
	if ($tkey == $doc1_year_limit)
		echo  sprintf ("<option value=\"%d\" selected>%s</option>\n",$tkey,$tvalue);
	else
		echo  sprintf ("<option value=\"%d\">%s</option>\n",$tkey,$tvalue);
}
?>	
</select>(�~)
</td>
</tr>
<tr>
	<td align="right" valign="middle">���媬�A</td>
<td> 
<select name="doc_stat">
<?php
//(���媬�A $doc_stat_array �b docword_config.php ���]�w)
while(list($tkey,$tvalue)= each ($doc_stat_array)){
	if ($tkey == $doc_stat)
		echo  sprintf ("<option value=\"%d\" selected>%s</option>\n",$tkey,$tvalue);
	else
		echo  sprintf ("<option value=\"%d\">%s</option>\n",$tkey,$tvalue);
}
?>
</select>&nbsp;&nbsp;�k�ɤ��:
<input type="text" name="doc1_infile_date" size="10" value="<?php echo $doc1_infile_date ?>">
&nbsp;&nbsp;�P�����:
<input type="text" name="doc1_end_date" size="10" value="<?php echo $doc1_end_date ?>">

</td>
</tr>
<tr>
	<td  colspan=2 align=center>
	<input type="submit" name="key" value="�ק�">&nbsp;&nbsp;
	<input type="submit" name="key" value="�R��" onClick="return confirm('�帹:<?php echo $doc1_id ?>\n�T�w�R���o���O��?')">
	</td>
</tr>

</table>
</form>
</td>
</tr>
<tr>
<td>
<?php
//��ܤ���n�����

$today  = date("Y-m-d");
$query = "select * from sch_doc1 where doc1_k_id=0 and doc1_date_sign > '$today' ";
$result = mysql_query($query);
echo "<center><b>����Ӥ�</b></center>";
echo "<table width=100% ><tr bgcolor=#C0C0C0><td>�帹</td><td>�Ӥ���</td><td>�K�n</td><td>�ӿ�B��</td></tr>";
while($row = mysql_fetch_array($result)) {
	$unit_temp = $doc_unit_p[$row[doc1_unit_num1]]; //���o�B�ǦW��
	if ($i++ % 2 == 0)
		echo "<tr bgcolor=#AAEEAA>";
	else
		echo "<tr>";
	echo "<td><a href=\"doc_edit.php?doc1_id=$row[doc1_id]\">$row[doc1_id]</a></td><td>$row[doc1_unit]</td><td>$row[doc1_main]</td><td>$unit_temp</td></tr>";
}
echo "</table>";
echo "</td></tr></table>";
include "footer.php";
?>
