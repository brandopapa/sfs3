<?php
//$Id: booksay_edit.php 8753 2016-01-13 12:40:19Z qfon $
include "book_config.php";
if (!checkid($_SERVER[SCRIPT_FILENAME],1)){
	include "header.php";
	echo "<h3>�D�޲z�̤Ŷi�J</h3>";
	include "footer.php";
	exit;
}



if ($_GET[do_key]=='delete'){
    $_GET[bs_id]=intval($_GET[bs_id]);
	$query="delete from book_say where bs_id='$_GET[bs_id]'";
	$CONN->Execute($query);

	
}

include "header.php";
$query = "select bs_id,bs_title from book_say order by bs_id";
$res = $CONN->Execute($query);
echo "<center><a href=\"book_say_up.php\">�s�W�ﶵ</a></center>";
echo "<table border='0' cellpadding='2' cellspacing='0' width='96%' align='center'>";

echo "<tr bgcolor=#CCCCCC><td>���D</td><td>�s��</td></tr>";
while(!$res->EOF){
	$bs_id=$res->fields[bs_id];
	$bs_title=$res->fields[bs_title];
	echo ($ii++%2==0)?"<tr bgcolor=#FFFFFF>":"<tr bgcolor=#EEEEDD>";
	echo "<td>$bs_title</td><td><a href=\"book_say_up.php?do_key=edit&bs_id=$bs_id\">�ק�</a>&nbsp;&nbsp;";
	echo "<a href=\"$_SERVER[PHP_SELF]?do_key=delete&bs_id=$bs_id\" onClick=\"return confirm('�T�w�R�� $bs_title �ﶵ�H');\" >�R��</a></td></tr>";
	$res->MoveNext();
}
echo "</table>";

include "footer.php";
?>
