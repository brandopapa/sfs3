<?php

// $Id: board_r.php 5310 2009-01-10 07:57:56Z hami $

// --�t�γ]�w��
include	"config.php"; 
// session �{��
session_start();


if($_SESSION[session_log_id]=='' ){
	
	$go_back=1; //�^��ۤw���{�ҵe��  
		include "header.php";
	include $SFS_PATH."/rlogin.php";  
	exit;
}
//-----------------------------------





$b_name=$_SESSION[session_tea_name]; //�i�K�H�m�W
$b_title = $_SESSION[session_who]; //¾��

$b_name= addslashes($b_name);  //�ˬd�S��r


if ($key == "�T�w"){
	$b_days=1;
	$b_post_time = mysql_date();
	$b_open_date = mysql_date();

	$b_upload_name = $_FILES[b_upload][name];
	$sql_insert = "insert into unit_c(bk_id,b_open_date,b_days,b_unit,b_title,b_name,b_sub,b_con,b_upload,b_url,b_own_id,b_post_time,b_is_intranet,teacher_sn,update_ip,act)values ('$bk_id','$b_open_date','$b_days','$board_name ','$b_title ','$b_name ','$b_sub','$b_con ','$b_upload_name ','$b_url','$_SESSION[session_log_id]','$b_post_time','$b_is_intranet','$_SESSION[session_tea_sn]','{$_SERVER['REMOTE_ADDR']}','$a_b_id')";

	mysql_query($sql_insert) or die ($sql_insert); 
	$query = "select max(b_id) as mm from unit_c ";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	$mm = $row["mm"] ;
	$b_upload_name = $mm."_".$_FILES[b_upload][name];
	if($_FILES[b_upload][name] !="" ) {
		//�ˬd�O�_�W�� php �{����
		if  (check_is_php_file($_FILES[b_upload][name]))
			$error_flag = true;
		else
			copy($_FILES[b_upload][tmp_name] , ($USR_DESTINATION.$b_upload_name));
	}
	if (!$error_flag)
		if($c_is_in=="")
			Header ("Location: etoe.php?unit=$unit&entry=$entry&m_id=$bk_id");
		else 
			Header ("Location: etoe.php?unit=$unit&entry=$entry&m_id=$bk_id");

}
$u_id = $_POST['u_id'] ;
if( $u_id=="")   
 	exit();
//�קK������J�Ѽ�

include "header_u.php";

$b_open_date = date("Y-m-j");
?>

<script language="JavaScript">
function checkok()
{
	var OK=true
	if(document.eform.b_sub.value == "")
	{
		OK=false;
	}
	if (OK == false)
	{
		alert("���D���i�ť�")
	}
	return OK
}

//-->
</script>



<form enctype="multipart/form-data" name=eform method="post" action="<?php echo $PHP_SELF ?>" 
onSubmit="return checkok()">
<center>
<?php  echo "<b> �s�W $s_title </b>"; ?>
<?php
//��ܿ��~�T��
if ($error_flag)
	echo "<h3><font color=red>���~ !! ���i�W�� php �{����!!</font></h3>";
?>
<table	border="1" bgcolor="#CCFFFF" bordercolor="#9999FF">   
<tr>
	<td align="right" valign="top"></td>
	<td><?php echo " $b_name "; ?>�@�@�@�@ (�Ů�μ��I�ХΥ��Φr)<br><font color=blue>�A�C�B�I�H�F�G�u�v�K �w�y�z</font>�@�@�]�i�ϥνd�ҽƻs�ζK�W�^

</td>
</tr>
<tr>
	<td align="right" valign="top">���D</td>
	<td><input type="text" size="70" maxlength="70" name="b_sub" value="<?php echo $c_sub  ?>"></td>
</tr>
<tr>
	<td align="right" valign="top">���e</td>
	<td><textarea name="b_con" cols=70 rows=10 wrap=virtual><?php echo $b_con ?></textarea></td>
</tr>
<tr>
	<td align="right" valign="top">�������}�G</td>
	<td><input type="text" name="b_url" size=50 value="<?php echo $b_url ?>"></td>
</tr>

<?php
//if ($board_is_upload){
?>
<tr>
	<td align="right" valign="top">����(�Ϥ�)</td>
	
	<td><input type="file" size="50" maxlength="50" name="b_upload" value="<?php echo $b_upload ?>"></td>
</tr>
<?php
//}
?>
<input type="hidden" name="bk_id" value="<?php echo $u_id ?>">
<input type="hidden" name="unit" value="<?php echo $unit ?>">
<input type="hidden" name="entry" value="<?php echo $entry ?>">
<input type="hidden" name="board_name" value="<?php echo $board_name ?>">
<input type="hidden" name="a_b_id" value="<?php echo $a_b_id ?>">
<input type="hidden" name="ins" value="<?php echo $ins ?>">
<input type="hidden" name="c_is_in" value="<?php echo $c_is_in ?>">
<tr>
	<td  align=center colspan=2 ><input type="submit" name="key" value="�T�w">
	<INPUT TYPE="button" VALUE="�^�W�@��" onClick="history.back()"></td>
</td>
</tr>
</table>
</form>
</center>


