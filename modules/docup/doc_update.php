<?php

//$Id: doc_update.php 5310 2009-01-10 07:57:56Z hami $

//�]�w�ɸ��J�ˬd
include "docup_config.php";
// --�{�� session 
sfs_check();

$docup_id = $_POST[docup_id];
if ($docup_id =='');
	$docup_id = $_GET[docup_id];

//���o�n�J�H���Ҧb�B��
$post_office = "";
if($_SESSION[session_tea_sn] !=""){
	$query = "select post_office from teacher_post where teach_id='$_SESSION[session_tea_sn]' ";
	$result = $CONN->Execute($query);
	$post_office = $result->fields[0];
}

//------------------------
if (!checkid($_SERVER[SCRIPT_FILENAME],1)) { //�D�޲z��

	//�ˬd�ק��v
	$log_flag = false;
	$docup_id = $_POST[docup_id];
	if ($docup_id=='')
		$docup_id = $_GET[docup_id];
	$query = "select a.teacher_sn,a.docup_share,b.doc_kind_id from docup a, docup_p b where a.docup_p_id = b.docup_p_id and a.docup_id='$docup_id'";
	$result = $CONN->Execute($query) or trigger_error("�t�ο��~",E_USER_ERROR);
	$teacher_sn = $result->fields[teacher_sn];
	$docup_share = $result->fields[docup_share];
	$doc_kind_id = $result->fields[doc_kind_id];
	//�ɮשҦ��H
	if ($_SESSION[session_tea_sn] == $teacher_sn)
		$log_flag = true;
	//�Ҧb�B�ǤH��
	else if ($_SESSION[session_tea_sn] !="" && $post_office == $doc_kind_id)
		if (getperr($docup_share,1,2)) //�ק��v
			$log_flag = true;
	//���դH��
	else if ($_SESSION[session_tea_sn] !="")
		if (getperr($docup_share,2,2)) //�ק��v
			$log_flag = true;
	if ($log_flag == false){
		echo "�S���v���ק糧���";
		exit;
	}
}

if ($_POST[key] == "�ק�"){
	$subname = substr( strrchr( $_FILES[docup_store][name], "." ), 1 );
	$docup_share = "";
	for ($j = 1;$j < 4 ;$j++){
		$vtemp = 0;
		for ($i = 0;$i < 3; $i++){					
			$temp = "docup_share_".$j."_".($i+1);
			$vtemp += $_POST[$temp]*(1 << $i);
		}
		$docup_share .= $vtemp;
	}
	
	$docup_store = $_FILES[docup_store][name];
	$docup_file_size = $_FILES[docup_store][size];
	$sql_update = "update docup set docup_name='$_POST[docup_name]',docup_date='$now' \n";
	$sql_update .= ",docup_owner='$_SESSION[session_tea_name]' \n";
		
	if (is_file($_FILES[docup_store][tmp_name]))
		$sql_update .= ",docup_store='$docup_store' ,docup_file_size='$docup_file_size'\n";
	$sql_update .= ",docup_share='$docup_share' , url = '$_POST[txturl]' where docup_id='$_POST[docup_id]' ";
	$result = $CONN->Execute($sql_update)or die($sql_update);
	if (is_file($_FILES[docup_store][tmp_name])) {
		if (!check_is_php_file($_FILES[docup_store][name])) {					
			$alias = $filePath."/".$_SESSION[session_log_id]."_".$_POST[docup_id]."_".$_POST[docup_store2];
			if (file_exists($alias)) {
				unlink($alias);
			}
			$alias = $_SESSION[session_log_id]."_".$_POST[docup_id]."_".$_FILES[docup_store][name];			
			if (copy($_FILES[docup_store][tmp_name],$filePath."/".$alias) == false) {
				echo "�ɮפW�ǥ���!�Э��s�e�X!<br>";
				foot();
				exit;
			}
		}
		else {
			echo "ĵ�i�G�ФŤW��php�ɡI<br>";
			foot();
			exit;
		}
	}
header ("Location: doc_list.php?docup_p_id=$_POST[docup_p_id]&doc_kind_id=$_POST[doc_kind_id]");
}

if ($is_standalone!="1") head("����Ʈw");

$sql_select = "select docup.*,docup_p.doc_kind_id , docup.url from docup,docup_p \n ";
$sql_select .= "where docup.docup_p_id= docup_p.docup_p_id and docup.docup_id ='$docup_id' ";
$result = $CONN->Execute($sql_select) or die($sql_select);

while (!$result->EOF) {
	$docup_p_id = $result->fields["docup_p_id"];
	$docup_id = $result->fields["docup_id"];
	$doc_kind_id = $result->fields["doc_kind_id"];
	$docup_name = $result->fields["docup_name"];
	$docup_date = $result->fields["docup_date"];
	$docup_owner = $result->fields["docup_owner"];
	$docup_store = $result->fields["docup_store"];
	$docup_share = $result->fields["docup_share"];
	$teacher_sn = $result->fields["teacher_sn"];
	$docup_url  = $result->fields["url"];
	
	$result->MoveNext();
}
?>

<form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER[PHP_SELF] ?>">
<input type="hidden" name="docup_p_id" value="<?php echo $docup_p_id ?>">
<input type="hidden" name="doc_kind_id" value="<?php echo $doc_kind_id ?>">
<input type=hidden name=docup_store2 value="<?php echo $docup_store ?>">
  <table class=module_body align=center>
    <caption>�ק� <font color=blue><b> 
    <? echo "$docup_name"; ?>
    </b></font></caption>
    <tr> 
      <td align="right" valign="top" width="70">�M�׽s��</td>
      <td width="490"> 
        <?php echo "$_SESSION[session_tea_sn]-$docup_id" ?>
        <input type="hidden" name="docup_id" value="<?php echo $docup_id ?>">
      </td>
    </tr>
    <tr> 
      <td align="right" valign="top" width="70">���W��</td>
      <td width="490"> 
        <input type="text" size="80" maxlength="80" name="docup_name" value="<?php echo $docup_name ?>">
      </td>
    </tr>
    <? if ($docup_url) { ?>
    <tr> 
      <td align="right" valign="top" width="70">�쵲���}:</td>
      <td width="490">
        <input type="text" name="txturl" size="80" value="<? echo $docup_url ; ?>">
      </td>
    </tr>
    <? } else { ?> 
    <tr> 
      <td align="right" valign="top" width="70">����ɮ�:</td>
      <td width="490"> 
        <input type="FILE" size="40" name="docup_store" >
        ������ɮפ������s�s��</td>
    </tr>
    <? }  ?>
    
    <tr> 
      <td align="right" valign="top" width="70">���ɳ]�w</td>
      <td width="490"> 
        <?php
//���ɳB�z�A�ȥ���J�}�C��
$share = array();
for ($j=0;$j<3;$j++){
	$vtemp = substr($docup_share,$j,1);	
	for($i=0;$i<3;$i++){
		if ($vtemp % 2 == 1)
			$share[]=" checked ";
		else
			$share[]=" ";
		//�k���@��
		$vtemp = $vtemp >> 1;
	}
}	
?>
        �Ҧb�B�ǡG 
        <input type="checkbox" name="docup_share_1_1" value="1" <?php echo $share[0] ?> >
        �s��&nbsp;&nbsp;&nbsp; 
        <input type="checkbox" name="docup_share_1_2" value="1" <?php echo $share[1] ?> >
        �ק�&nbsp;&nbsp;&nbsp; 
        <input type="checkbox" name="docup_share_1_3" value="1" <?php echo $share[2] ?> >
        �R��<br>
        ���դH���G 
        <input type="checkbox" name="docup_share_2_1" value="1" <?php echo $share[3] ?> >
        �s��&nbsp;&nbsp;&nbsp; 
        <input type="checkbox" name="docup_share_2_2" value="1" <?php echo $share[4] ?> >
        �ק�&nbsp;&nbsp;&nbsp; 
        <input type="checkbox" name="docup_share_2_3" value="1" <?php echo $share[5] ?> >
        �R��<br>
        �����ӻ��G 
        <input type="checkbox" name="docup_share_3_1" value="1" <?php echo $share[6] ?> >
        �s��&nbsp;&nbsp;&nbsp;</td>
    </tr>
    <tr> 
      <td colspan=2 align=center > 
        <input type="submit" name="key" value="�ק�">
      </td>
    </tr>
    <tr> 
      <td colspan=2 align=center> 
        <hr size=1>
        <? echo "<a href=\"doc_list.php?doc_kind_id=$doc_kind_id&docup_p_id=$docup_p_id\">"; ?>
        �^���C��</a> </td>
    </tr>
  </table>
</form>

<?php
if ($is_standalone!="1") foot();
?>
