<?php

// $Id: doc_unit.php 6805 2012-06-22 08:00:32Z smallduh $

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
if ($key =="�s�W") {
	$sql_insert = "insert into sch_doc1_unit (doc1_unit_name) values ('$doc1_unit_name')";	
	if (mysql_query ($sql_insert)) {
		echo "<h1><center>�s�W�@�ӳ��: $doc1_unit_name</center></h1></body></html>";
		
		redir( "$PHP_SELF" , 1);
		exit;
	}
}

else if ($key =="�ק�") {
	$sql_update = "update sch_doc1_unit set doc1_unit_num1='$doc1_unit_num1',doc1_unit_name='$doc1_unit_name' where doc1_unit_num1='$doc1_unit_num1_old'";
	if (mysql_query ($sql_update)) {
		echo "<h1><center>$doc1_unit_num1 : $doc1_unit_name �ק令�\!!</center></h1></body></html>";
		
		redir( "$PHP_SELF" , 1);
		exit;
	}
}

else if ($key =="�R��") {
	$sql_update = "delete from sch_doc1_unit where doc1_unit_num1='$doc1_unit_num1_old'";
	if (mysql_query ($sql_update)) {
		echo "<h1><center>$doc1_unit_num1 : $doc1_unit_name �w�R��!!</center></h1></body></html>";
		
		redir( "$PHP_SELF" , 1);
		exit;
	}
}
prog(3); //�Dmenu (�b docword_config.php ���]�w)

?>
<center>
<form action="<?php echo $PHP_SELF ?>" method="post"> 
<table cellSpacing="0" cellPadding="0"  align="center" bgColor="#000000" border="0">
  <tbody>
    <tr>
      <td>
        <table cellSpacing="1" cellPadding="3" width="100%" border="0">
          <tbody>
<?php
	$doc1_unit_name ="";
	if ($sel == "edit") {
		$sql_select = "select doc1_unit_num1,doc1_unit_name from sch_doc1_unit where doc1_unit_num1='$doc1_unit_num1'";
		$result = mysql_query ($sql_select);
		while ($row = mysql_fetch_array($result)) {
			$doc1_unit_num1 = $row["doc1_unit_num1"];
			$doc1_unit_name = $row["doc1_unit_name"];
		}
	?>
	<tr>
	<td align="right" valign="middle" bgColor="#ffffff">�s��</td>
	<td bgColor="#ffffff"><input type="text" size="20" maxlength="20" name="doc1_unit_num1" value="<?php echo $doc1_unit_num1 ?>"></td>
	<input type="hidden" name="doc1_unit_num1_old" value="<?php echo $doc1_unit_num1 ?>">
	</tr>	
<?php	
	}
?>

<tr>
	<td align="right" valign="middle" bgColor="#ffffff">���W��</td>
	<td bgColor="#ffffff"><input type="text" size="20" maxlength="20" name="doc1_unit_name" value="<?php echo $doc1_unit_name ?>"></td>
</tr>
<tr>
	<td align="center" valign="middle" colspan=2 bgColor="#ffffff" >
<?php
	if ($sel == "edit") 
		echo "<input type=submit name=key value = \"�ק�\" >&nbsp;&nbsp;<input type=submit name=key value = \"�R��\" onClick=\"return confirm('$doc1_unit_name \\n�T�w�R���o���O��?')\">";
	else
		echo "<input type=submit name=key value = \"�s�W\" >";
	
?>
	</td>
</tr>
<tr>
	<td colspan=2>
	<! -- �w�����C�� --- !>
	<table border="1" bgColor="#cccccc" cellSpacing="1" cellPadding="3" width="100%">
	<tr>
	<td align="center">�s��</td><td align="center">���W��</td><td align="center">�s��</td>
	</tr>
	
<?php 

$sql_select = "select doc1_unit_num1,doc1_unit_name from sch_doc1_unit order by doc1_unit_num1";
$result = mysql_query ($sql_select);
while ($row = mysql_fetch_array($result)) {
	$doc1_unit_num1 = $row["doc1_unit_num1"];
	$doc1_unit_name = $row["doc1_unit_name"];
	echo "<tr><td align=\"center\">$doc1_unit_num1</td><td align=\"center\">$doc1_unit_name</td><td align=\"center\"><a href=\"$PHP_SELF?sel=edit&doc1_unit_num1=$doc1_unit_num1\">�ק�</a></td></tr>";
}
?>
	</td>
	</tr>
	</table>
</td>
</tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>
</form>	

</center>
<?php
include "footer.php";
?>
