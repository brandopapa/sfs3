<?php

// $Id: doc_out_edit.php 6805 2012-06-22 08:00:32Z smallduh $

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

if ($key =="�ק�"){
	$query = "update sch_doc1 set doc1_year_limit='$doc1_year_limit',doc1_kind='$doc1_kind',doc1_date='$doc1_date',doc1_date_sign='$doc1_date_sign',doc1_unit='$doc1_unit',doc1_word='$doc1_word',doc1_main='$doc1_main',doc1_unit_num1='$doc1_unit_num1',doc1_unit_num2='$doc1_unit_num2',teach_id='$session_log_id' where doc1_id='$doc1_id'";

	mysql_query($query)or die ($query);
	header ("Location: doc_out_list.php");
}
if ($key == "�R��"){
	$query = "delete from sch_doc1 where doc1_id = '$doc1_id' ";
	mysql_query($query)or die ($query);
	header ("Location: doc_out_list.php");
}
$sql_select = "select doc1_id,doc1_year_limit,doc1_kind,doc1_date,doc1_date_sign,doc1_unit,doc1_word,doc1_main,doc1_unit_num1,doc1_unit_num2,teach_id from sch_doc1 where doc1_id='$doc1_id'";
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

};

include "header.php";
prog(2); //�W��menu (�b docword_config.php ���]�w)
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
	<td align="right" valign="middle">�o����</td>
	<td><input type="text" size="10" maxlength="10" name="doc1_date" value="<?php echo $doc1_date ?>">
	&nbsp;&nbsp;����ɶ� <input type="text" size="16" maxlength="19" name="doc1_date_sign" value="<?php echo $doc1_date_sign ?>"></td>
</tr>

<tr>
	<td align="right" valign="middle">�����</td>
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
	<td align="right" valign="middle">�o��r��</td>
	<td><input type="text" size="60" maxlength="60" name="doc1_word" value="<?php echo $doc1_word ?>"></td>
</tr>


<tr>
	<td align="right" valign="top">�o��K�n</td>
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
</td>
</tr>
<tr>
	<td  colspan=2>
	<input type="submit" name="key" value="�ק�">&nbsp;&nbsp;
	<input type="submit" name="key" value="�R��" onClick="return confirm('�帹:<?php echo $doc1_id ?>\n�T�w�R���o���O��?')">
	</td>
</tr>

</table>
</form>
</td>
</tr>
</table>

<?php include "footer.php";
?>
