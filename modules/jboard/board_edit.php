<?php

// $Id: board_edit.php 7779 2013-11-20 16:09:00Z smallduh $

// --�t�γ]�w��
include "board_config.php";

// session �{��
//session_start();
//session_register("session_log_id");
$bk_id = $_REQUEST['bk_id'];
$b_id = $_REQUEST['b_id'];
if(!board_checkid($bk_id) and !checkid($_SERVER['SCRIPT_FILENAME'],1)){

	$go_back=1; //�^��ۤw���{�ҵe��
	if ($is_standalone)
		include "header.php";
	else
		head("Joomla!�峹�s��");

	include $SFS_PATH."/rlogin.php";
	if ($is_standalone)
		include "footer.php";
	else
		foot();
	exit;
}

//�ˬd�ק��v
//$query = "select b_id from board_p where b_id ='$b_id' and b_own_id='$session_log_id'";
$query = "select b_id from jboard_p where b_id ='$b_id'";
$result = $CONN->Execute($query) or die($query);
if ($result->EOF && !checkid($_SERVER['SCRIPT_FILENAME'],1)){
	echo "�S���v���ק糧���i";
	exit;
}

// �R���ɮ�
if ($_GET['act'] == 'del_file'){
	$fArr = board_getFileArray($_GET['b_id']);
	//$sFile = $USR_DESTINATION.'/'.$_GET['b_id'].'/'.$fArr[$_GET['id']]['new_filename'];
	//if (is_file($sFile)) {
	//	unlink($sFile);
	 $query= "delete from jboard_files where b_id = '$b_id' and new_filename='".$fArr[$_GET['id']]['new_filename']."'";
	 $CONN->Execute($query);
	 
	 $sFile=$Download_Path.$fArr[$_GET['id']]['new_filename'];
	 unlink($sFile);
		header("Content-type: text/html; charset=big5");
		echo $fArr[$_GET['id']]['new_filename'];
	//}
	exit;
}


//-----------------------------------

$query = "select  a.post_office , b.teach_title_id , b.title_name ,b.room_id,c.name from teacher_post a ,teacher_title b ,teacher_base c  where a.teacher_sn = c.teacher_sn and  a.teach_title_id =b.teach_title_id  and a.teacher_sn='{$_SESSION['session_tea_sn']}' ";

$result = $CONN->Execute($query) or die ($query);

$row = $result->fetchRow();

$b_name = $row["name"]; //�i�K�H�m�W
//�o��̥ثe�Ҧb�B�� , Ū�� teacher_title �̪�room_id , �M���ഫ���o��B�ǦW��
//$b_unit = $_POST['board_name']; //�Ҧb�B��

$b_unit=$row['room_id'];		//�o��̩Ҧb�B��

//$b_title = addslashes($row["title_name"]); //¾��  2014.04.23 ��H teach_title_id ���N
$b_title=$row['teach_title_id'];

$query = "select * from jboard_kind where bk_id ='$bk_id' ";
$result= $CONN->execute($query) or die ($query);
$row = $result->fetchRow();
$b_is_sign = $row['b_is_sign']; // �O�_ñ��
$bk_id = $row["bk_id"];
$board_name = $row["board_name"];
$board_date = $row["board_date"];
$board_k_id = $row["board_k_id"];
$board_last_date = $row["board_last_date"];
$board_is_upload = $row["board_is_upload"];
$board_is_public = $row["board_is_public"];

if ($_POST['key'] == "�T�w�ק�"){
	$b_post_time = mysql_date();
	//$b_unit = $board_name;  
  
	$sql_update = "update jboard_p set bk_id='".$_POST['bk_id']."',b_open_date='{$_POST['b_open_date']}', " .
			"b_days='{$_POST['b_days']}',b_unit='$b_unit', b_sub='{$_POST['b_sub']}'," .
			"b_con='{$_POST['b_con']}', b_url='{$_POST['b_url']}' ,b_post_time='$b_post_time'," .
			"b_is_intranet='{$_POST['b_is_intranet']}',b_is_sign='{$_POST['b_is_sign']}',b_is_marquee='{$_POST['b_is_marquee']}' ";
	if ($_POST['del_sign']=='1'){
		$sql_update .= ",b_signs='' ";
	}
	$sql_update .= " where b_id='$b_id' " ;
	$CONN->Execute($sql_update) or die ($sql_update);

  //�B�z�Ϥ����������o  $b_id, $sPath ,$b_con �����ܼ�
  $sPath = $USR_IMG_TMP.'images/';
  $b_con=$_POST['b_con'];
	GetImgFromHTML(); 

	//�B�z�ק��w���ϥΪ���
	DelImgNotInHTML();
	
	//���J�ɮ׳B�z�{��
  include_once("board_files_upload.php");

	if (!$error_flag)
		Header ("Location: board_show.php?bk_id=$bk_id&b_id=$b_id");
}

$query = "select * from jboard_p where b_id ='$b_id' ";
$result = $CONN->Execute($query);

$row = $result->fetchRow();
$b_id = $row["b_id"];
$bk_id = $row["bk_id"];
$b_open_date = $row["b_open_date"];
$b_days = $row["b_days"];
$b_unit = $row["b_unit"];
$b_title = $row["b_title"];
$b_name = $row["b_name"];
$b_sub = $row["b_sub"];
$b_con = $row["b_con"];
$b_hints = $row["b_hints"];
$b_upload = $row["b_upload"];
$b_url = $row["b_url"];
$b_own_id = $row["b_own_id"];
$b_is_intranet = $row["b_is_intranet"];
$b_is_marquee = $row["b_is_marquee"];
$b_is_sign = $row["b_is_sign"];
$b_signs = $row['b_signs'];

//�O�_���W�ߪ��ɭ�
if ($is_standalone)
	include "header.php";
else
	head("Joomla!�峹�s��");
?>
<Script src="../../include/ckeditor/ckeditor.js"></Script>
<script language="JavaScript">
function checkok(){
	var OK=true
	if(document.eform.b_sub.value == ""){
		OK=false;
	}
	if (OK == false){
		alert("���D���i�ť�")
	}
	return OK
}

//-->
</script>
<script type="text/javascript" src="<?php echo $SFS_PATH_HTML ?>javascripts/forms.js"></script>
<script type="text/javascript" src="<?php echo $SFS_PATH_HTML ?>javascripts/prototype.js"></script>
<script type="text/javascript">
function del_file(f_id,id) {
	new Ajax.Request('<?php echo $_SERVER['PHP_SELF'] ?>', {
  method: 'get',
  parameters: {bk_id: '<?php echo $bk_id ?>', b_id: '<?php echo $b_id ?>', act: 'del_file', id: id},
 onSuccess: function(transport){
  			document.getElementById(f_id).style.visibility="hidden";
      var response = transport.responseText || "no response text";
      alert("���\ �R������! \n\n" + response);
    },
    onFailure: function(){ alert('���~!') }
  });
}
</script>

<form enctype="multipart/form-data" name=eform method="post" action="<?php echo $PHP_SELF ?>" onSubmit="return checkok()" >

<?php
//��ܿ��~�T��
if ($error_flag)
	echo "<h3><font color=red>���~ !! ���i�W�� php �{����!!</font></h3>";

//���J���
include_once("board_form.php");
?>



<input type="hidden" name="board_name" value="<?php echo $board_name ?>">
<input type="hidden" name="b_old_upload" value="<?php echo $b_upload ?>">
<input type="hidden" name="b_id" value="<?php echo $b_id ?>">

<input type="submit" name="key" value="�T�w�ק�">&nbsp;&nbsp;&nbsp;
<INPUT TYPE="button" VALUE="�^�W�@��" onClick="history.back()"></td>

</form>
</center>
<?php
//�Y�ҥ� html �s�边
if ($enable_is_html<>'') {  echo "<script>CKEDITOR.replace('b_con',{ language: 'zh'});</script>"; }
//�O�_���W�ߪ��ɭ�
if ($is_standalone)
	include "footer.php";
else
	foot();
?>
