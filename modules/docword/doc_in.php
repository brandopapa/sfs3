<?php

// $Id: doc_in.php 6805 2012-06-22 08:00:32Z smallduh $

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
$add_kind = array("0"=>"�۰ʨ��o�̫�@�Ӥ帹", "1"=>"�ѦҤW���֥[","2"=>"������ʿ�J");

if ($key =="�n������"){
	$query = "insert into sch_doc1 (doc1_id,doc1_year_limit,doc1_kind,doc1_date,doc1_date_sign,doc1_unit,doc1_word,doc1_main,doc1_unit_num1,teach_id,doc1_k_id) values ('$doc1_id','$doc1_year_limit','$doc1_kind','$doc1_date','$doc1_date_sign','$doc1_unit','$doc1_word','$doc1_main','$doc1_unit_num1','$session_log_id','0')";
	mysql_query($query);
}

include "header.php";
//�w�]�Ӥ���
if ($doc1_date == "")
	$doc1_date = date("Y-m-j") ;
//�w�]����ɶ�
$doc1_date_sign = mysql_date();
//�w�]�Ӥ���
if ($doc1_unit == "")
	$doc1_unit = $default_unit;

$year = date("Y")-1911;
//�w�]�Ӥ�帹
if ($doc1_word == "")	
	$doc1_word = $year.$default_word;
$query = "select max(doc1_id)+1 mm from sch_doc1 where doc1_id like '$year%'";
$result = mysql_query ($query) or die ($query);
$row = mysql_fetch_row($result);
$mm = $row[0];

//�~�ײĤ@�󤽤�
if ($mm =="" ) 
	$mm =  sprintf ("%d%0$max_doc"."s",$year,1);

if ($add_kind_id == "1" && $doc1_id!="" ) //�ѦҤW��
	$mm = $doc1_id + 1;
else if ($add_kind_id == "2") // ��ʰO��
	$mm = "";
prog(1); //�Dmenu (�b docword_config.php ���]�w)

?>
<body  onload="setfocus()">
<script language="JavaScript"><!--
function setfocus() {
      document.myform.doc1_word.focus();
      return;
 }
 function sel_unit() {
	document.myform.doc1_unit_num1.value = document.myform.doc1_unit_sel.value;	
      return;
 }
 function sel_year() {
	document.myform.doc1_year_limit.value = document.myform.doc1_year_sel.value;
	
      return;
 }
// --></script>
<form action="<?php echo $PHP_SELF ?>" method = post name=myform >
<table border=1 cellpadding=0 cellspacing=0 align=center  >
<tr><td>
<table border=0 cellpadding=3 cellspacing=1  align=center >
<tr><td bgcolor=CCCCCC colspan=2 align=center>�@�뤽��n���@�~</td></tr>
<tr><td>�s���覡</td>
<td>
	<table cellspacing=3 ><tr>
	<?php
	while(list($tkey,$tvalue)= each ($add_kind)){
	if ($tkey == $add_kind_id)
		echo  "<td bgcolor=yellow><a href=\"$PHP_SELF?add_kind_id=$tkey\">$tvalue</td>";
	else
		echo  "<td ><a href=\"$PHP_SELF?add_kind_id=$tkey\">$tvalue</td>";
	}
	echo "<input type=\"hidden\" name=\"add_kind_id\" value=\"$add_kind_id\">";
	?>
	</tr></table>
</td></tr>
<tr>
	<td align="right" valign="middle">���o�帹</td>
	<td><input type="text" size="10" maxlength="10" name="doc1_id" value="<?php echo $mm ?>">	
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
	<td><input type="text" name="doc1_main" size="60" ></td>
</tr>
<tr>
	<td align="right" valign="middle" rowspan=2>�ӿ���</td>
	<td>
	�N��: <input type="text" name="doc1_unit_sel" size="3" onchange="sel_unit()">
	&nbsp;&nbsp;�O�s�~��: <input type="text" name="doc1_year_sel" size="3" onchange="sel_year()">
	</td>
</tr>
	
<tr>
	
	<td>
<select name=doc1_unit_num1 style="BACKGROUND-COLOR: #CCCCCC">
<?php
//�ӿ�B��
$doc_unit_p = doc_unit();

while(list($tkey,$tvalue)= each ($doc_unit_p)){
	if ($tkey == $doc1_unit_num1)
		echo  sprintf ("<option value=\"%d\" selected>%d-%s</option>\n",$tkey,$tkey,$tvalue);
	else
		echo  sprintf ("<option value=\"%d\">%d-%s</option>\n",$tkey,$tkey,$tvalue);
}

?>
	</select>
&nbsp;&nbsp;�O�s�~�� <select name=doc1_year_limit style="BACKGROUND-COLOR: #CCCCCC">
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
</select>(�~)&nbsp;&nbsp;&nbsp; 
<a href="javascript:var aa=window.open('file_save.htm', 'external', 'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0')">�ɮ׫O�s�~����Ǫ�</a>
</td>
</tr>
<tr>
	<td  colspan=2>
	<input type="submit" name="key" value="�n������"></td>
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
$query = "select * from sch_doc1 where doc1_k_id=0 and  doc1_date_sign > '$today' ";
$result = mysql_query($query);
//echo $query;
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
