<?php

// $Id: doc_out.php 8746 2016-01-08 15:41:01Z qfon $

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

///mysqli	
$mysqliconn = get_mysqli_conn();

if ($key =="�n������"){
	//$query = "insert into sch_doc1 (doc1_id,doc1_year_limit,doc1_kind,doc1_date,doc1_date_sign,doc1_unit,doc1_word,doc1_main,doc1_unit_num1,teach_id,doc1_k_id) values ('$doc1_id','$doc1_year_limit','$doc1_kind','$doc1_date','$doc1_date_sign','$doc1_unit','$doc1_word','$doc1_main','$doc1_unit_num1','$session_log_id','1')";
	//mysql_query($query)or die($query);

///mysqli
$query = "insert into sch_doc1 (doc1_id,doc1_year_limit,doc1_kind,doc1_date,doc1_date_sign,doc1_unit,doc1_word,doc1_main,doc1_unit_num1,teach_id,doc1_k_id) values (?,?,?,?,?,?,?,?,?,?,'1')";
$stmt = "";
$stmt = $mysqliconn->prepare($query);
$stmt->bind_param('ssssssssss',$doc1_id,$doc1_year_limit,$doc1_kind,$doc1_date,$doc1_date_sign,$doc1_unit,$doc1_word,$doc1_main,$doc1_unit_num1,$session_log_id);
$stmt->execute();
$stmt->close();

///mysqli	
	
}

include "header.php";
//�w�]�o����
if ($doc1_date == "")
	$doc1_date = date("Y-m-j") ;
//�w�]�o��ɶ�
$doc1_date_sign = mysql_date();
//�w�]�o����
if ($doc1_unit == "")
	$doc1_unit = $default_out_unit;

$year = date("Y")-1911;

$query = "select max(doc1_id)+1 mm from sch_doc1 where doc1_id like '$year%'";
$result = mysql_query ($query) or die ($query);
$row = mysql_fetch_row($result);
$mm = $row[0];

if ($mm =="" )
	$mm = $year."00001";

//�w�]�o��帹
if ($doc1_word == ""){
	$temp_mm = intval (substr($mm,strlen($year)));
	$doc1_word = $year.$default_out_word."��".$temp_mm."��";
}


	
prog(2); //�Dmenu (�b docword_config.php ���]�w)

?>

<form action="<?php echo $PHP_SELF ?>" method = post >
<table border=1 cellpadding=0 cellspacing=0 align=center  >
<tr><td>
<table border=0 cellpadding=3 cellspacing=1  align=center >
<tr><td bgcolor=CCCCCC colspan=2 align=center>�o��n���@�~</td></tr>

<tr>
	<td align="right" valign="middle">���o�帹</td>
	<td><input type="text" size="10" maxlength="10" name="doc1_id" value="<?php echo $mm ?>"></td>
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
	<input type="submit" name="key" value="�n������"></td>
</tr>

</table>
</form>
</td>
</tr>
</table>
<?php
include "footer.php";
?>
