<?php

// $Id: board_delete.php 7779 2013-11-20 16:09:00Z smallduh $

// --�t�γ]�w��
include	"board_config.php";
// session �{��
//session_start();
//session_register("session_log_id");

$bk_id = $_REQUEST['bk_id'];
$b_id = $_REQUEST['b_id'];

if(!board_checkid($bk_id) && !checkid($_SERVER[SCRIPT_FILENAME],1)){

	$go_back=1; //�^��ۤw���{�ҵe��
	if ($is_standalone)
		include "header.php";
	else
		head("joomla!�峹�s��");

	include $SFS_PATH."/rlogin.php";
	if ($is_standalone)
		include "footer.php";
	else
		foot();
	exit;
}


//�ˬd�ק��v
//$query = "select b_id from board_p where b_id ='$b_id' and b_own_id='$session_log_id'";
$b_id=intval($b_id);
$query = "select b_id from jboard_p where b_id ='$b_id' and teacher_sn ='$_SESSION[session_tea_sn]'";
$result = $CONN->Execute($query) or die($query);
if ($result->EOF && !checkid($_SERVER[SCRIPT_FILENAME],1)){
	echo "�S���v���ק糧���i";
	exit;
}

//-----------------------------------

if ($_POST['key']=="�T�w�R��"){
	$b_id=intval($b_id);
	$query= "delete from jboard_p where b_id = '$b_id'";
	$CONN->Execute($query);
	$query= "delete from jboard_images where b_id = '$b_id'";
	$CONN->Execute($query);
	
	//��Ҧ����ɧR��
	$query="select * from jboard_files where b_id='$b_id'";
	$res=$CONN->Execute($query);
	if ($res->RecordCount()>0) {
	  while ($row=$res->FetchRow()) {
	    $sFile=$row['new_filename'];
	    unlink($Download_Path.$sFile);
	  }
	}
	$query= "delete from jboard_files where b_id = '$b_id'";
	$CONN->Execute($query);
	
	Header ("Location: board_view.php?bk_id=$bk_id");
}
//�O�_���W�ߪ��ɭ�
if ($is_standalone)
	include "header.php";
else
	head("joomla!�峹�s��");
$b_id=intval($b_id);
$query = "select b_sub from jboard_p where b_id='$b_id'";
$result = $CONN->Execute($query);
$row= $result->fetchRow();

?>

<table align="center" border="0" cellPadding="3" cellSpacing="0" width="411">
<tr bgColor="#dae085">
	<td align="middle" height="30" width="60%"><b>�T�w�R�� �s���G<?php echo "$b_id �G". $row["b_sub"];
?>�H</b><br>
	<form action="<?php echo $PHP_SELF ?>" method="post">
	<input type=hidden name=b_id value="<?php echo $b_id ?>">
	<input type=hidden name=bk_id value="<?php echo $bk_id ?>">
	<input type=submit name="key" value="�T�w�R��">
	<INPUT TYPE="button" VALUE="�^�W�@��" onClick="history.back()">
	</form>
	</td>
</tr>
</table>
<?php
if($is_standalone)
	include	"footer.php";
else
	foot();
?>
