<?php

// $Id: board.php 7779 2013-11-20 16:09:00Z smallduh $

// --�t�γ]�w��
include	"board_config.php";
// session �{��
session_start();

$teach_id=$_SESSION[session_log_id];

$bk_id = $_REQUEST['bk_id'];

if(!board_checkid($bk_id) and !checkid($_SERVER[SCRIPT_FILENAME],1)){

	$go_back=1; //�^��ۤw���{�ҵe��
	if ($is_standalone)
		include "header.php";
	else
		head("�հȧG�i��");

	include $SFS_PATH."/rlogin.php";
	if ($is_standalone)
		include "footer.php";
	else
		foot();
	exit;
}
//-----------------------------------

//$query = "select  a.post_office ,b.teach_title_id, b.title_name ,c.name from teacher_post a ,teacher_title b ,teacher_base c where a.teacher_sn = c.teacher_sn and  a.teach_title_id =b.teach_title_id  and a.teacher_sn='$_SESSION[session_tea_sn]' ";
$query = "select  a.post_office , b.teach_title_id ,b.title_name ,b.room_id,c.name from teacher_post a ,teacher_title b ,teacher_base c  where a.teacher_sn = c.teacher_sn and  a.teach_title_id =b.teach_title_id  and a.teacher_sn='{$_SESSION['session_tea_sn']}' ";
$result	= $CONN->Execute($query) or die ($query);

$row = $result->fetchRow();
$b_name	= addslashes($row["name"]); //�i�K�H�m�W
//$b_unit	= addslashes($_POST['board_name']); //�Ҧb�B��
$b_unit=$row['room_id'];		//�o��̩Ҧb�B��

//$b_title = addslashes($row["title_name"]); //¾��  2014.04.23 ��H teach_title_id ���N
$b_title=$row['teach_title_id'];

///mysqli
$query = "select board_name,board_date,board_k_id,board_last_date,board_is_upload,board_is_public,board_admin from jboard_kind ";
$query .= "where bk_id =? ";

$mysqliconn = get_mysqli_conn();
$stmt = "";
$stmt = $mysqliconn->prepare($query);
$stmt->bind_param('s', $bk_id);
$stmt->execute();
$stmt->bind_result($board_name,$board_date,$board_k_id,$board_last_date,$board_is_upload,$board_is_public,$board_admin);
$stmt->fetch();
$stmt->close();
///mysqli

/*
$query = "select * from jboard_kind ";
$query .= "where bk_id ='$bk_id' ";
$result= $CONN->Execute($query) or die ($query);
$row = $result->fetchRow();
	$board_name = $row["board_name"];
	$board_date = $row["board_date"];
	$board_k_id = $row["board_k_id"];
	$board_last_date = $row["board_last_date"];
	$board_is_upload = $row["board_is_upload"];
	$board_is_public = $row["board_is_public"];
	$board_admin = $row["board_admin"];
*/	
	
if ($_POST['key'] == "�T�w�x�s"){
	$b_post_time = mysql_date();
	$b_sort=($_POST['top_days']==0)?"100":"99";
		
$sql_insert = "insert into jboard_p(bk_id,b_open_date,b_days,b_unit,b_title,b_name," .
			"b_sub,b_con,b_url,b_own_id,b_post_time,b_is_intranet,teacher_sn,b_is_sign,b_is_marquee,b_sort,top_days) values " .
			"('{$_POST['bk_id']}','{$_POST['b_open_date']}','{$_POST['b_days']}'," .
			"'$b_unit','$b_title','$b_name','{$_POST['b_sub']}','{$_POST['b_con']}'," .
			"'{$_POST['b_url']}','{$_SESSION['session_log_id']}',now()," .
			"'{$_POST['b_is_intranet']}','{$_SESSION['session_tea_sn']}','{$_POST['b_is_sign']}','{$_POST['b_is_marquee']}','$b_sort','{$_POST['top_days']}')";

	$CONN->Execute($sql_insert) or die ($sql_insert);
	//echo $sql_insert;
	$b_id = $CONN->Insert_ID();

	//�B�z�Ϥ�
  $sPath = $USR_IMG_TMP.'images/';

  //�� $b_con �� <img src""> �T�꦳�ɮצs�b���@�B�z, ���ɦs�J��Ʈw��R��
  //���������o  $b_id, $sPath ,$b_con �����ܼ�
  $b_con=$_POST['b_con'];
	GetImgFromHTML(); 
	
	//���J�ɮ׳B�z�{��	
  include_once("board_files_upload.php");

	if (!$error_flag)
		Header ("Location: board_view.php?bk_id=$bk_id");
}

//�O�_���W�ߪ��ɭ�
if ($is_standalone)
	include "header.php";
else
	head("Joomla!�s�W�峹");

$b_open_date = date("Y-m-j");
// <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></Script>

?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></Script>

<Script type="text/javascript" src="../../include/ckeditor/ckeditor.js"></Script>

<script language="JavaScript">
	//$(document).ready(function() {
	//	CKEDITOR.replace('b_con',{ filebrowserImageUploadUrl: '<?php echo $USR_IMG_TMP;?>' });
  //});
	
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

<script type="text/javascript" src="<?php echo $SFS_PATH_HTML ?>javascripts/forms.js"></script>

<form enctype="multipart/form-data" name=eform method="post" action="<?php echo $PHP_SELF ?>" onSubmit="return checkok()">

<?php
//��ܿ��~�T��
if ($error_flag)
	echo "<h3><font color=red>���~ !! ���i�W�� php �{����!!</font></h3>";

include_once("board_form.php");
?>


<input type="hidden" name="board_name" value="<?php echo $board_name ?>">
<input type="submit" name="key" value="�T�w�x�s">
<input TYPE="button" VALUE="�^�W�@��" onclick="window.location='board_view.php'">

</form>


<?php
//�Y�ҥ� html �s�边
if ($enable_is_html<>'') {  
	?>
	<script>
		CKEDITOR.replace('b_con',{ language: 'zh'},{ filebrowserImageUploadUrl: '<?php echo $USR_IMG_TMP;?>' });
		</script>
	<?php
	}

if($is_standalone)
	include	"footer.php";
else
	foot();
?>
