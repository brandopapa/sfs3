<?php
                                                                                                                             
// $Id: stud_chg.php 6807 2012-06-22 08:08:30Z smallduh $

//���J�]�w��
include "exam_config.php";
//session_start();
if ($_SESSION[session_stud_id] == "" ){	
	$exename = $_SERVER[REQUEST_URI];
	include "checkid.php";
	exit;
}

if ($_POST[key] == "�ק�") {
	$stud_sit_num = sprintf("%X-%X",$_POST[seat_col],$_POST[seat_row]);
	$stud_pass = chop ($_POST[stud_pass]); //�h���ť�
	//�ˬd�K�X�禡 (�]�w�b PLib.php)
	if (!chk_pass($stud_pass ,3,10)) {
		$str ="<B><font color=red size=4 >$stud_pass</font>  �����X�k�K�X�A�Э��s��J";
		echo $str;
		redir( $_SERVER[PHP_SELF] ,3);
		exit;
	}
	
	$sql_update = "update exam_stud_data set stud_pass='$stud_pass',stud_sit_num='$stud_sit_num',stud_num='$_POST[stud_num]',stud_memo='$_POST[stud_memo]', stud_c_time='$stud_c_time' where stud_id ='$_SESSION[session_stud_id]' ";
	$result_ok = $CONN->Execute($sql_update) or die($sql_update);
	if ($result_ok) {
		$str ="�A���s�K�X��&nbsp;<B><font color=red size=4 >$stud_pass</font></b>";
		$str .=" , �T������^�쭺��";
		echo $str;
		redir( "exam_list.php" ,3);
		exit;	
	}
	
	
}

include "header.php";
echo "<h3>$exam_title</h3>\n";
echo "<b>��� $session_stud_name �ӤH��� </b>";
echo "&nbsp;�U&nbsp;<a href=\"exam_list.php\">�^����</a>";
	
		
$sql_select = "select stud_pass,stud_sit_num,stud_num,stud_memo from exam_stud_data where stud_id ='$_SESSION[session_stud_id]' ";
$result = $CONN->Execute($sql_select);
$stud_pass = $result->fields["stud_pass"];
$stud_sit_num = $result->fields["stud_sit_num"];
$stud_num = $result->fields["stud_num"];
$stud_memo = $result->fields["stud_memo"];
if ($stud_sit_num != ""){	
	$temp_s = explode ("-", $stud_sit_num);
	$s_col = hexdec($temp_s[0]); //��
	$s_row = hexdec($temp_s[1]); //�C	
}

?>
<hr>
<form action="<?php echo $_SERVER[PHP_SELF] ?>" method=post >
<table border =1>

<tr>
	<td align="right" valign="top">�y��</td>
	<td><input type="text" size="6" maxlength="6" name="stud_num" value="<?php echo $stud_num ?>"></td>
</tr>

<tr>
	<td align="right" valign="top">�K�X<BR>(�ϥέ^��μƦr�A�b 3 �� 10 �Ӧr��)</td>
	<td><input type="text" size="10" maxlength="10" name="stud_pass" value="<?php echo $stud_pass ?>"></td>
</tr>

<tr>
	<td align="right" valign="top">�ЫǮy��</td>
	<td>
	<?php
	echo "��<select name=seat_col>";
	for ($i=1;$i<=$class_cols ;$i++) {		
		if ($s_col == $i )
			echo "<option value=\"$i\" selected >$i</option>\n";
		else
			echo "<option value=\"$i\" >$i</option>\n";
	}
	echo "</select>��&nbsp;";
	echo "<select name=seat_row>";
	for ($i=1;$i<= $class_rows ;$i++) {		
		if ($s_row == $i )
			echo "<option value=\"$i\" selected >$i</option>\n";
		else
			echo "<option value=\"$i\">$i</option>\n";
	}
	echo "</select>�C";
	?>
	</td>
</tr>
<tr>
	<td align="right" valign="top">�ۧ�²��</td>
	<td><input type="text" size="60" maxlength="80" name="stud_memo" value="<?php echo $stud_memo ?>"></td>

</tr>

<tr>
	<td colspan=2 align=center>
	<input type="submit"  name="key" value="�ק�">&nbsp;&nbsp;<input type="reset" ></td>

</tr>

</table>
</form>
	
<?php include "footer.php"; ?>
