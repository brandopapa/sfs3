<?php

//$Id: doc_p_delete.php 5310 2009-01-10 07:57:56Z hami $

//�]�w�ɸ��J�ˬd
include "docup_config.php";
// --�{�� session 
sfs_check();
//------------------------
if ($key == "�T�w�R��"){
	$sql_delete = "delete from  docup_p where docup_p_id = '$docup_p_id'";
	$result = $CONN->Execute($sql_delete);
	$sql_delete = "delete from  docup where docup_p_id = '$docup_p_id'";
	$result = $CONN->Execute($sql_delete);
	$alias = $filePath."/".$session_tea_sn."_".$docup_p_id."_*";
	if (file_exists($alias))
		unlink($alias)or die($alias);
	if ($doc_kind_id != "")	
		header ("Location: doc_kind_list.php?doc_kind_id=$doc_kind_id");
	else
		header ("Location: doc_p_list.php");
}
if ($is_standalone!="1") head("����Ʈw");
	echo "<b>$docup_p_name"."�N�Q�R��</b>\n";
	echo "<form active=\"$SCRIPT_NAME\" method=post>\n";
	echo "<input type=hidden name=docup_p_id value=$docup_p_id>\n";
	echo "<input type=submit name=key value=\"�T�w�R��\">\n";
	echo "</form></center>";
if ($is_standalone!="1") foot();
?>