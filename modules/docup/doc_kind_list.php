<?php

//$Id: doc_kind_list.php 8754 2016-01-13 12:44:14Z qfon $

include "docup_config.php";
if ($is_standalone!="1") head("����Ʈw");

$doc_kind_id = (int)$_POST[doc_kind_id];
if ($doc_kind_id=='')
	$doc_kind_id = (int)$_GET[doc_kind_id];
/*
if ($_POST[key] == "�ק�"){
	$sql_update = "update docup_p set doc_kind_id='$_POST[doc_kind_id]',docup_p_id='$_POST[docup_p_id]',docup_p_date='$now',docup_p_name='$_POST[docup_p_name]',docup_p_memo='$_POST[docup_p_memo]',docup_p_owner='$_SESSION[session_tea_name]' where docup_p_id = '$_POST[docup_p_id]'";
	$CONN->Execute($sql_update) or trigger_error ("�y�k���~",E_USER_ERROR);
}

else if ($_POST[key] == "�R��"){
	echo "<b>$docup_p_name"."�N�Q�R��</b>\n";
	echo "<form active=\"$_SERVER[PHP_SELF]\" method=post>\n";
	echo "<input type=hidden name=docup_p_id value=$_POST[docup_p_id]>\n";
	echo "<input type=submit name=key value=\"�T�w�R��\">\n";
	echo "</form></center>";
	include ($foot);
	exit;
}
else if ($_POST[key] == "�T�w�R��"){
	$sql_delete = "delete from  docup_p where docup_p_id = '$docup_p_id'";
	$CONN->Execute($sql_delete) or trigger_error ("�y�k���~",E_USER_ERROR);
}
else if (isset($_POST[newkey])){
	$sql_insert = "insert into docup_p (doc_kind_id,docup_p_id,docup_p_date,docup_p_name,docup_p_memo,docup_p_owner,teacher_sn) values ('$_POST[doc_kind_id]','$_POST[docup_p_id]','$now','$_POST[docup_p_name]','$_POST[docup_p_memo]','$_SESSION[session_tea_name]','$_SESSION[session_tea_sn]')";
	$CONN->Execute($sql_insert) or trigger_error ("�y�k���~",E_USER_ERROR);
}*/

$state_kind = "<select name=\"doc_kind_id\"  size=1 onchange=\"document.kindform.submit()\"> ";
$post_office_p = room_kind();
while (list($tid, $tname) = each($post_office_p)){
	$tid=intval($tid);
	$sql_select = "select count(docup_p_id) as cc from docup_p where doc_kind_id ='$tid'";
	$result = $CONN->Execute($sql_select) or die ($sql_select);
	$cc =$result->fields[0];	
	if ($cc>0) {
		if($doc_kind_id == $tid)
			$state_kind .= "<option value=\"$tid\" selected >$tname</option> \n";
		else
			$state_kind .= "<option value=\"$tid\" >$tname</option> \n";
	}
};

$state_kind .= "</select>";
?>
<table align=center class=module_body width=100%>
<tr><td align=center><form action="<?php echo $_SERVER[PHP_SELF] ?>" method=get name="kindform"><a href="docup_list.php">����`��</a>&nbsp;&nbsp;<?php echo $state_kind; ?>&nbsp;&nbsp;<a href="docup_p_add.php?doc_kind_id=<?php echo $_GET[doc_kind_id] ?>">�s�W���M��</a> | <a href="<?php echo "doc_search.php?doc_kind_id=$doc_kind_id" ?>">�j�M</a></td></tr></table>
<table border="1" class=module_body cellspacing="0" cellpadding="0" width=100% >
  <tr>    
    <td  bgcolor="#008000" align="center" width=60%><font color="#FFFFFF">�M�צW��</font></td>
    <td  bgcolor="#008000" align="center" nowrap colspan=2><font color="#FFFFFF">�ʧ@</font></td>    
    <td  bgcolor="#008000" align="center" nowrap><font color="#FFFFFF">�ظm�H</font></td>
    <td  bgcolor="#008000" align="center"><font color="#FFFFFF">�ظm�ɶ�</font></td>
    <td  bgcolor="#008000" align="center"><font color="#FFFFFF">����</font></td>
  </tr> 
<?php
$doc_kind_id=intval($doc_kind_id);
$sql_select = "select * from docup_p  where doc_kind_id=$doc_kind_id order by docup_p_name ";
$result = $CONN->Execute($sql_select);
if ($result->RecordCount() >0){
	while (!$result->EOF){
		$doc_kind_id = $result->fields["doc_kind_id"];
		$state_name = $result->fields["state_name"];
		$docup_p_id = $result->fields["docup_p_id"];
		$docup_p_date = substr($result->fields["docup_p_date"],0,10);
		$docup_p_name = $result->fields["docup_p_name"];
		$docup_p_memo = $result->fields["docup_p_memo"];
		$docup_p_owner = $result->fields["docup_p_owner"];
		$teacher_sn = $result->fields["teacher_sn"];
		$docup_p_count = $result->fields["docup_p_count"];
		echo ($i++ % 2 == 0)?"<TR class=nom_1>":"<TR class=nom_2>";
		echo "<TD  >$docup_p_name</TD>";
		echo "<TD  align=center><a href=\"doc_list.php?docup_p_id=$docup_p_id&doc_kind_id=$doc_kind_id\">�s��</a></TD>";
		if ($_SESSION[session_tea_sn] == $teacher_sn ||  checkid($_SERVER[SCRIPT_FILENAME],1)){
			echo "<TD  align=center><a href=\"docup_p_update.php?docup_p_id=$docup_p_id&doc_kind_id=$doc_kind_id\">�ק�</a></TD>";
			echo "<TD  align=center><a href=\"docup_p_list.php\">$docup_p_owner</a></TD>";
		}
		else{
			echo "<TD   align=center>--</TD>";
			echo "<TD   align=center>$docup_p_owner</TD>";
		}
		echo "<TD  noWrap align=center >$docup_p_date</TD>";
		echo "<TD   align=center>$docup_p_count</TD></TR>";
		$result->MoveNext();
	}
}
echo "</TABLE></form>";
if ($is_standalone!="1") foot();
?>