<?php 
// ���J�]�w��
include "database_info_config.php";
// �{���ˬd
sfs_check();
// �إ����O
//$tea1 = new m_unit_class();
//�L�X���Y
head();
//�{����m
print_location();
?> 
<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=0 class="main_body" WIDTH="100%" ALIGN="CENTER"> 
<tr>
<td>
<table>


<tr>
	<td align="right" valign="top">��ƪ�W��</td>
	<td><input type="text" size="30" maxlength="30" name="d_table_name" value="<?php echo $d_table_name ?>"></td>
</tr>


<tr>
	<td align="right" valign="top">���W��</td>
	<td><input type="text" size="30" maxlength="30" name="d_field_name" value="<?php echo $d_field_name ?>"></td>
</tr>


<tr>
	<td align="right" valign="top">��줤��W��</td>
	<td><input type="text" size="30" maxlength="30" name="d_field_cname" value="<?php echo $d_field_cname ?>"></td>
</tr>


<tr>
	<td align="right" valign="top">��쫬�A</td>
	<td><input type="text" size="30" maxlength="30" name="d_field_type" value="<?php echo $d_field_type ?>"></td>
</tr>


<tr>
	<td align="right" valign="top">�Ƨ�</td>
	<td><input type="text" size="2" maxlength="2" name="d_field_orfer" value="<?php echo $d_field_orfer ?>"></td>
</tr>
</table>
</td></tr></table>
<pre>

This can be used at the top of the form. It will fill the form:

$sql_select = "select d_table_name,d_field_name,d_field_cname,d_field_type,d_field_orfer from database_prop";
$sql_insert = "insert into database_prop (d_table_name,d_field_name,d_field_cname,d_field_type,d_field_orfer) values ('$d_table_name','$d_field_name','$d_field_cname','$d_field_type','$d_field_orfer')";
$sql_update = "update database_prop set d_table_name='$d_table_name',d_field_name='$d_field_name',d_field_cname='$d_field_cname',d_field_type='$d_field_type',d_field_orfer='$d_field_orfer'";


while ($row = mysql_fetch_array($result)) {

	$d_table_name = $row["d_table_name"];
	$d_field_name = $row["d_field_name"];
	$d_field_cname = $row["d_field_cname"];
	$d_field_type = $row["d_field_type"];
	$d_field_orfer = $row["d_field_orfer"];

};
// Update: 
$result = mysql_query ($sql_update,$conID);

// Insert: 
$result = mysql_query ($sql_insert,$conID);

<?php 
//�L�X���Y
foot();
?> 
