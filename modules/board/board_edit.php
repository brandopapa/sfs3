<?php

// $Id: board_edit.php 8752 2016-01-13 12:38:48Z qfon $

// --�t�γ]�w��
include "board_config.php";
// session �{��
//session_start();
//session_register("session_log_id");
$bk_id = $_REQUEST['bk_id'];
$b_id = $_REQUEST['b_id'];
/*
if(!board_checkid($bk_id)){

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

//�ˬd�ק��v
//$query = "select b_id from board_p where b_id ='$b_id' and b_own_id='$session_log_id'";
$b_id=intval($b_id);
$query = "select b_id from board_p where b_id ='$b_id' and teacher_sn ='$_SESSION[session_tea_sn]'";
$result = $CONN->Execute($query) or die($query);
if ($result->EOF && !checkid($_SERVER['SCRIPT_FILENAME'],1)){
	echo "�S���v���ק糧���i";
	exit;
}
*/

// �R���ɮ�
if ($_GET['act'] == 'del_file'){
	$fArr = board_getFileArray($_GET['b_id']);
	$sFile = $USR_DESTINATION.'/'.$_GET['b_id'].'/'.$fArr[$_GET['id']]['new_filename'];
	if (is_file($sFile)) {
		unlink($sFile);
	 $query= "delete from board_files where b_id = '$b_id' and id='".$fArr[$_GET['id']]['id']."'";
	 $CONN->Execute($query);

		header("Content-type: text/html; charset=big5");
		echo $fArr[$_GET['id']]['new_filename'];
	}
	exit;
}


//-----------------------------------

$query = "select  a.post_office , b.title_name ,c.name from teacher_post a ,teacher_title b ,teacher_base c  where a.teacher_sn = c.teacher_sn and  a.teach_title_id =b.teach_title_id  and a.teacher_sn='{$_SESSION['session_tea_sn']}' ";

$result = $CONN->Execute($query) or die ($query);

$row = $result->fetchRow();

$b_name = $row["name"]; //�i�K�H�m�W
$b_unit = $_POST['board_name']; //�Ҧb�B��
$b_title = $row["title_name"]; //¾��

///mysqli         	
$query = "select bk_id,board_name,board_date,board_k_id,board_last_date,board_is_upload,board_is_public from board_kind where bk_id =? ";
$mysqliconn = get_mysqli_conn();
$stmt = "";
$stmt = $mysqliconn->prepare($query);
$stmt->bind_param('s', $bk_id);
$stmt->execute();
$stmt->bind_result($bk_id,$board_name,$board_date,$board_k_id,$board_last_date,$board_is_upload,$board_is_public);
$stmt->fetch();
$stmt->close();

/*
$query = "select * from board_kind ";
$query .= "where bk_id ='$bk_id' ";
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
*/
if ($_POST['key'] == "�T�w�ק�"){

	$b_post_time = mysql_date();
	
	/*
	$sql_update = "update board_p set b_open_date='{$_POST['b_open_date']}', " .
			"b_days='{$_POST['b_days']}',b_unit='$b_unit', b_sub='{$_POST['b_sub']}'," .
			"b_con='{$_POST['b_con']}', b_url='{$_POST['b_url']}' ,b_post_time='$b_post_time'," .
			"b_is_intranet='{$_POST['b_is_intranet']}',b_is_sign='{$_POST['b_is_sign']}',b_is_marquee='{$_POST['b_is_marquee']}' ";
	*/
	
	//mysqli
	$sql_update = "update board_p set b_open_date=?, " .
			"b_days=?,b_unit='$b_unit', b_sub=?," .
			"b_con=?, b_url=? ,b_post_time='$b_post_time'," .
			"b_is_intranet=?,b_is_sign=?,b_is_marquee=? ";
	//mysqli
	
	$b_store = $bk_id."_".$b_id."_".$_FILES[b_upload][name];
	$b_old_store = $bk_id."_".$b_id."_".$b_old_upload;
	
	if ($_POST['del_sign']=='1'){
		$sql_update .= ",b_signs='' ";
	}
	$b_id=intval($b_id);
	$sql_update .= " where b_id='$b_id' " ;

	//$CONN->Execute($sql_update) or die ($sql_update);
	
//mysqli	
$stmt = "";
$stmt = $mysqliconn->prepare($sql_update);
$stmt->bind_param('ssssssss',check_mysqli_param($_POST['b_open_date']),check_mysqli_param($_POST['b_days']),check_mysqli_param($_POST['b_sub']),check_mysqli_param($_POST['b_con']),check_mysqli_param($_POST['b_url']),check_mysqli_param($_POST['b_is_intranet']),check_mysqli_param($_POST['b_is_sign']),check_mysqli_param($_POST['b_is_marquee']));
$stmt->execute();
$stmt->close();
///mysqli		

		$fileCount = count($_FILES);
		if ($fileCount > 0){
			//�W���ɮ�
			$file_path = "$USR_DESTINATION/$b_id";
				$tt = time();
			for($i=1 ; $i<=$fileCount; $i++){
				if ($_FILES["resourceFile_$i"]['name']=='')
					continue;
				if (!check_is_php_file($_FILES["resourceFile_$i"]['name'])){
					if (!is_dir($file_path))	mkdir($file_path,0700);
					//copy($_FILES["resourceFile_$i"]['tmp_name'],$file_path."/".$tt.'_'.$i.'-'.$_FILES["resourceFile_$i"]['name']);
					$org_filename=$_FILES["resourceFile_$i"]['name'];
		      //������ɦW
      		$expand_name=explode(".",$org_filename);
      		$nn=count($expand_name)-1;  //���̫�@�ӷ���ɦW
      		$ATTR=strtolower($expand_name[$nn]); //��p�g���ɦW
					$new_filename=$tt."_".$i."-".date("Y_m_d").".".$ATTR;
					//copy($_FILES["resourceFile_$i"]['tmp_name'],$file_path."/".$tt.'_'.$i.'-'.$_FILES["resourceFile_$i"]['name']);
				  copy($_FILES["resourceFile_$i"]['tmp_name'],$file_path."/".$new_filename);
				  //�x�s���ɸ�T
				  $query="insert into board_files (b_id,org_filename,new_filename) values ('$b_id','$org_filename','$new_filename')";
				  $CONN->Execute($query) or die ($query);				  
				}
			}
		}

	if (!$error_flag)
		Header ("Location: board_show.php?bk_id=$bk_id&b_id=$b_id");
}
$b_id=intval($b_id);
$query = "select * from board_p where b_id ='$b_id' ";
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
	head("�հȧG�i��");
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

<form enctype="multipart/form-data" name=eform method="post" action="<?php echo $PHP_SELF ?>"
onSubmit="return checkok()" >
<center>
<?php  echo "<b>$board_name ���i��</b>"; ?>

<?php
//��ܿ��~�T��
if ($error_flag)
	echo "<h3><font color=red>���~ !! ���i�W�� php �{����!!</font></h3>";
?>

<table border="1" bgcolor="#CCFFFF" bordercolor="#9999FF">
<tr>
	<td align="right" valign="top">���i�H</td>
	<td><?php echo "$b_unit $b_name"; ?></td>
</tr>
<tr>
	<td align="right" valign="top">���i���</td>
	<td><input type="text" size="12" maxlength="12" name="b_open_date" value="<?php echo $b_open_date
?>"></td>
</tr>

<tr>
	<td align="right" valign="top">�������</td>
	<td><input type="checkbox"  name="b_is_intranet" value="1" <?php if ($b_is_intranet=='1') echo "checked"; ?> > ���T���u�糧�դ���</td>
</tr>
<?php
if ($enable_is_sign == '1') {
	?>
<tr>
	<td align="right" valign="top">�ҥ�ñ��</td>
	<td><input type="checkbox"  name="b_is_sign" value="1" <?php if ($b_is_sign=='1') echo "checked"; ?> > ���ձ�¾����ñ�����i</td>
</tr>
<?php
}
?>
<tr>
	<td align="right" valign="top">�]���O</td>
	<td><input type="checkbox"  name="b_is_marquee" value="1" <?php if ($b_is_marquee=='1') echo "checked"; ?>> �N�����i�m��]���O</td>
</tr>
<tr>
	<td align="right" valign="top">���i�Ѽ�</td>
	<td><select name="b_days">

<?php
	while (list ($key, $val) = each ($days)){
		if ($b_days == $key )
			echo "<option value=\"$key\" selected >$val";
		else
			echo "<option value=\"$key\" >$val";
	}
?>
</select>
	</td>
</tr>
<tr>
	<td align="right" valign="top">���D</td>
	<td><input type="text" size="80" maxlength="100" name="b_sub" value="<?php echo $b_sub ?>"></td>
</tr>


<tr>
<td align="right" valign="top" nowrap="true">�������e</td>
	<?php
	/*
	if ($enable_is_html<>''){
		echo '<td width="95%" >';
		require "../../include/fckeditor.php";
		$oFCKeditor = new FCKeditor('b_con') ;
		$oFCKeditor->Height = 300;
		$oFCKeditor->ToolbarSet = $enable_is_html;
		$oFCKeditor->Value=$b_con;
		$oFCKeditor->Create();
	}
	*/
	//else{
	?>
		<td width="95%"><textarea name="b_con" cols=52 rows=5 wrap=virtual><?php echo $b_con ?></textarea>
	<?php
	//}
	?>
		</td>
</tr>

<tr>
	<td align="right" valign="top">�������}</td>
	<td><input type="text" name="b_url" size=50 value="<?php echo $b_url ?>"></td>
</tr>

<tr>
	<TD vAlign=top align=right><p>����</p>
      <a href="javascript:addElementToForm('fileFields','file','resourceFile','')" class='b1'>�W�[����</a>
	</td>
	<td>
	<div class="field" id="fileFields">
		<input type="file" id="resourceFile_1" name="resourceFile_1" />
		<br />
		 <div id="marker" style="clear:none;"></div>
	</div>
	<?php
		if ($fArr = board_getFileArray($b_id)){
			echo "<ul>";
			foreach ($fArr as $id => $fName){
				$Org=($fName['org_filename']!="")?"(���ɦW�G".$fName['org_filename'].")":"";
				echo "<li id='f_$id'><input type='button' value='�R��'   class='b1' onClick=\"del_file('f_$id','$id')\"> ".$fName['new_filename'].$Org."</li>";
			}
			echo "</ul>";
		}
	?>
		<input type='hidden' name='file_name'>
		</td>
</tr>

<tr>
	<td colspan=2 align=center>
	<?php
	if ($b_signs<>''){
		echo "<input type='checkbox' name='del_sign' value='1'> �����s�^ñ���i &nbsp;";
	}
	?>
	<input type="submit" name="key" value="�T�w�ק�">&nbsp;&nbsp;&nbsp;
	<INPUT TYPE="button" VALUE="�^�W�@��" onClick="history.back()"></td>
</tr>
</table>
<input type="hidden" name="bk_id" value="<?php echo $bk_id ?>">
<input type="hidden" name="board_name" value="<?php echo $board_name ?>">
<input type="hidden" name="b_old_upload" value="<?php echo $b_upload ?>">
<input type="hidden" name="b_id" value="<?php echo $b_id ?>">
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
