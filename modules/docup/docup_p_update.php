<?php

//$Id: docup_p_update.php 5310 2009-01-10 07:57:56Z hami $

//�]�w�ɸ��J�ˬd
include "docup_config.php";
// --�{�� session 
sfs_check();

$docup_p_id = $_POST[docup_p_id];
if (empty($docup_p_id))
	$docup_p_id = $_GET[docup_p_id];

//�ˬd�ק��v
$query = "select docup_p_owner from docup_p where docup_p_id='$docup_p_id' and teacher_sn='$_SESSION[session_tea_sn]'";
$result = $CONN->Execute($query) or trigger_error("�y�k���~ !",E_USER_ERROR);
if ($result->RecordCount() == 0 && !  checkid($_SERVER[SCRIPT_FILENAME],1)){
	echo "�S���v���ק糧�M��";
	exit;
}

if ($_POST[key] == "�ק�"){
	$sql_update = "update docup_p set doc_kind_id='$_POST[doc_kind_id]',docup_p_id='$_POST[docup_p_id]',docup_p_date='$now',docup_p_name='$_POST[docup_p_name]',docup_p_memo='$_POST[docup_p_memo]',docup_p_owner='$_SESSION[session_tea_name]' where docup_p_id = '$_POST[docup_p_id]'";
	$CONN->Execute($sql_update) or trigger_error("�y�k���~ !",E_USER_ERROR);

	if ($_POST[doc_kind_id] != "")	
		header ("Location: doc_kind_list.php?doc_kind_id=$_POST[doc_kind_id]");
	else
		header ("Location: doc_p_list.php");
}

else if ($_POST[key] == "�R��"){
	head();
	echo "<center><b>$_POST[docup_p_name]"."�N�Q�R��</b>\n";
	echo "<form active=\"$_SERVER[PHP_SELF]\" method=post>\n";
	echo "<input type=hidden name=docup_p_id value=$_POST[docup_p_id]>\n";
	echo "<input type=submit name=key value=\"�T�w�R��\">\n";
	echo "</form></center>";
	foot();
	exit;
}
else if ($_POST[key] == "�T�w�R��"){
	$sql_delete = "delete from  docup_p where docup_p_id = '$_POST[docup_p_id]'";
	$CONN->Execute($sql_delete) or trigger_error("�y�k���~ !",E_USER_ERROR);
	
	$query = "select * from  docup where docup_p_id = '$_POST[docup_p_id]'";	
	$result = $CONN->Execute ($query);
	while (!$result->EOF){
		$alias = $filePath."/".$result->fields[teacher_sn]."_".$result->fields[docup_id]."_".$result->fields[docup_store];
		if (file_exists($alias))
			unlink($alias)or die($alias);
		$result->MoveNext();
	}
	$sql_delete = "delete from  docup where docup_p_id = '$_POST[docup_p_id]'";
	$CONN->Execute($sql_delete) or trigger_error("�y�k���~!",E_USER_ERROR);
	if ($_POST[doc_kind_id] != "")	
		header ("Location: doc_kind_list.php?doc_kind_id=$_POST[doc_kind_id]");
	else
		header ("Location: docup_p_list.php");		
}

//------------------------
if ($is_standalone!="1") head("����Ʈw");

$sql_select = "select doc_kind_id,docup_p_id,docup_p_date,docup_p_name,docup_p_memo,docup_p_owner from docup_p where docup_p_id ='$_GET[docup_p_id]' ";

$result = $CONN->Execute($sql_select);
$doc_kind_id = $result->fields["doc_kind_id"];
$docup_p_id = $result->fields["docup_p_id"];
$docup_p_date = $result->fields["docup_p_date"];
$docup_p_name = $result->fields["docup_p_name"];
$docup_p_memo = $result->fields["docup_p_memo"];
$docup_p_owner = $result->fields["docup_p_owner"];
	
$post_office_p = room_kind();
$state = "<select name=doc_kind_id >";
while (list($tid, $tname) = each($post_office_p)){
	if ($tid == $doc_kind_id)
		$state .= "<option value=\"$tid\" selected>$tname</option>";
	else
		$state .= "<option value=\"$tid\">$tname</option>";
}
$state .= "</select>";

?>

<form method="post" action="<?php echo $_SERVER[PHP_SELF] ?>">
<input type=hidden name="docup_p_id" value="<? echo $docup_p_id ?>">
<input type=hidden name="doc_kind_id" value="<? echo $doc_kind_id ?>">
<table  class=module_body align=center>
<caption><b>�ק���M��</b></caption>
<tr> 
	<td align="right" valign="top">�B�ǧO</td>
	<td><?php echo $state ?></td>
</tr>
<tr> 
	<td align="right" valign="top">�M�צW��</td>
	<td><input type="text" size="40" maxlength="60" name="docup_p_name" value="<?php echo $docup_p_name ?>"></td>
</tr>


<tr>
	<td align="right" valign="top">����</td>
	<td><textarea name="docup_p_memo" cols=40 rows=5 wrap=virtual><?php echo $docup_p_memo ?></textarea></td>
</tr>

<tr>
	<td colspan=2 align=center ><input type="submit" name="key" value="�ק�">&nbsp;&nbsp;<input type="submit" name="key" value="�R��">
	</td>
</tr>
<tr>
      <td colspan=2 align=center>
       <hr size=1>
<?php
	if ($doc_kind_id != "")
       		echo"<a href=\"doc_kind_list.php?doc_kind_id=$doc_kind_id\">�^�M�צC��</a>";
       else
       		echo"<a href=\"docup_p_list.php\">�^�M�צC��</a>";
?>
      </td>
</tr>
</table>
</form>
<?
if ($is_standalone!="1") foot();
?>
