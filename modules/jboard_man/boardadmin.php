<?php

// $Id: boardadmin.php 5310 2009-01-10 07:57:56Z hami $

//�]�w�ɸ��J�ˬd
include "board_man_config.php";

// --�{�� 
sfs_check();

if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
	foreach ( $_POST as $keyinit => $valueinit) {
		$$keyinit = $valueinit;
	}
	foreach ( $_GET as $keyinit => $valueinit) {
		$$keyinit = $valueinit;
	}
}

switch($key) {
	case "�T�w�s�W" :
	$sql_insert = "insert into jboard_kind (bk_id,board_name,board_date,board_k_id,board_last_date,board_is_upload,board_is_public,board_admin,bk_order,board_is_sort,position,board_is_coop_edit) values ('$bk_id','$board_name','$board_date','$board_k_id','$board_last_date','$board_is_upload','$board_is_public','$board_admin','$bk_order','$board_is_sort','$position','$board_is_coop_edit')";
	mysql_query($sql_insert,$conID) or die($sql_insert);
	break;
	case "�T�w�ק�" :
	$sql_update = "update jboard_kind set board_name='$board_name ',board_date='$board_date',board_k_id='$board_k_id',board_last_date='$board_last_date',board_is_upload='$board_is_upload',board_is_public='$board_is_public',board_admin='$board_admin',bk_order='$bk_order',board_is_sort='$board_is_sort',position='$position',board_is_coop_edit='$board_is_coop_edit' where bk_id='$bk_id' ";
	mysql_query($sql_update,$conID) or die ($sql_update);
	break;
	case "�T�w�R��" :
	$sql_update = "delete from jboard_kind  where bk_id='$bk_id'";	
	mysql_query($sql_update,$conID) or die ($sql_update);
	break;
}

if ($key != "�s�W������"){
//  --�ثe���
	$query = "select * from jboard_kind where bk_id ='$bk_id' ";
	$result = mysql_query ($query,$conID) or die ($query); 
	$row = mysql_fetch_array($result);
	
	if ($_POST['continue_insert']) $key='�s�W������';
}
else
$query = "select bk_id,board_name from jboard_kind order by bk_order,bk_id limit 0,1 ";
	
$bk_id = $row["bk_id"];
$board_name = $row["board_name"];
$board_date = $row["board_date"];
$board_k_id = $row["board_k_id"];
$board_last_date = $row["board_last_date"];
$board_is_upload = $row["board_is_upload"];
$board_is_sort = $row["board_is_sort"];
$board_is_public = $row["board_is_public"];
$board_is_coop_edit = $row["board_is_coop_edit"];
$board_admin = $row["board_admin"];
$position = $row["position"];
$bk_order = ($row["bk_order"]>0)?$row["bk_order"]:100;

if($board_date ==0)
	$board_date = date("Y-m-j");
if ($board_is_upload == "1"){
	$board_is_upload_c1 = " checked ";
	$board_is_upload_c2 = "";
}
else{
	$board_is_upload_c2 = " checked ";
	$board_is_upload_c1 = "";
}
if ($board_is_public == "1"){
	$board_is_public_c1 = " checked ";
	$board_is_public_c2 = "";
}
else{
	$board_is_public_c2 = " checked ";
	$board_is_public_c1 = "";
}

if ($board_is_sort == "1"){
	$board_is_sort_c1 = " checked ";
	$board_is_sort_c2 = "";
}
else{
	$board_is_sort_c2 = " checked ";
	$board_is_sort_c1 = "";
}

if ($board_is_coop_edit == "1"){
	$board_is_coop_edit_c1 = " checked ";
	$board_is_coop_edit_c2 = "";
}
else{
	$board_is_coop_edit_c2 = " checked ";
	$board_is_coop_edit_c1 = "";
}


$board_k_id_p = array("�B�ǳ�쪩","�Z�Ū���");

//  --�{�����Y
head();
//���s���r��
$linkstr = "bk_id=$bk_id";
print_menu($menu_p,$linkstr); 

?>
<body  onload="setfocus()">
<script language="JavaScript"><!--
function setfocus() {
<?php
	if ($key == "�s�W������" or $bk_id =="")
		echo "document.eform.elements[0].focus();";
	else
		echo "document.eform.elements[1].focus();";
?>
return;
}

function checkok()
{
    var OK=true
    if      (document.eform.bk_id.value == "" )
     {
             OK=false;
       str= "�����ϥN�����i�d�šI�ЦA�Զ�I";
     }
     if      (document.eform.board_name.value == "")
     {
             OK=false;
       str= "�����ϦW�٤��i�d�šI�ЦA�Զ�I";
     }
    if (OK == false)        {
     alert(str)
    }
       return OK
}
// -->
</script>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
 <tr><td valign=top bgcolor="#CCCCCC">
 <table border="0" width="100%" cellspacing="0" cellpadding="0" >
    <tr>
<?php
if ($key == "�R��"){
	echo "<td align=center>";
	echo "<form action=\"$_SERVER[PHP_SELF]\" name=eform method=\"post\">";
	echo "  <input type=hidden name=\"bk_id\" value=\"$bk_id\">";	
	echo sprintf ("<br>�T�w�R�� <B><font color=red>%s</font></B>",$board_name);
	echo "<br><br><input type=\"submit\" name=\"key\" value=\"�T�w�R��\">";
	echo "</td></tr></form></table>";
	echo "</td></tr></table>";
	foot();
	exit;
}
?>
      <td  valign="top" >    
	<?php      
	
	//�إߥ�����	
	/*
	$grid1 = new sfs_grid_menu;  //�إ߿��	   
	//$grid1->bgcolor = $gridBgcolor;  // �C��   
	//$grid1->row = $gri ;	     //��ܵ���
	$grid1->key_item = "bk_id";  // ������W  	
	$grid1->display_item = array("bk_order","bk_id","board_name");  // �����W   	
	$grid1->class_ccs = " class=leftmenu";  // �C�����
	$grid1->sql_str = "select bk_id,board_name,bk_order from jboard_kind order by bk_order,bk_id";   //SQL �R�O   
	$grid1->do_query(); //����R�O   
	
	$grid1->print_grid($bk_id); // ��ܵe��   
  */

?>
<form method="post" name="myform" action="<?php echo $_SERVER['PHP_SELF'];?>">
<select name="bk_id" onchange="this.form.submit()" size="20">
	<option value="">�w�w�w�w�w</option>

<?php
	$query = "select * from jboard_kind order by bk_order,bk_id ";
	$result= $CONN->Execute($query) or die ($query);
	while( $row = $result->fetchRow()){
		$P=($row['position']>0)?"|".str_repeat("--",$row['position']):"";
		
		if ($row["bk_id"] == $bk_id  ){
			echo sprintf(" <option style='color:%s' value=\"%s\" selected>[%05d] %s%s%s</option>",$position_color[$row['position']],$row["bk_id"],$row['bk_order'],$P,$row['bk_order'],$row["board_name"]);
			$board_name = $row["board_name"];
		}
		else
			echo sprintf(" <option style='color:%s' value=\"%s\">[%05d] %s%s%s</option>",$position_color[$row['position']],$row["bk_id"],$row['bk_order'],$P,$row['bk_order'],$row["board_name"]);
	}
	echo "</select>";

	?>
</form>
     </td></tr></table>
  </td>
 <!--- �k���� ---->
<td width="100%" valign=top bgcolor="#CCCCCC">

<form action="<?php echo $PHP_SELF ?>" name=eform method="post" onsubmit="return checkok()"> 
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
<?php
if ($key == "�s�W������" or $key == "�T�w�s�W" or $bk_id == ""){
?>
  <td align="right"  nowrap>�����ϥN��</td>
	<td><input type="text" size="12" maxlength="12" name="bk_id" value="<?php echo $bk_id ?>"></td>
  <?php	
  }
 else
{
?> 
   <input type="hidden" name="bk_id" value="<?php echo $bk_id ?>">
   <td align="right"  nowrap>�����ϥN��</td>
	<td><?php echo $bk_id ?></td>
	
  <?php	
 }
	
 ?> 
</tr> 
	<td align="right"  nowrap>�����ϦW��</td>
	<td><input type="text" size="20" maxlength="20" name="board_name" value="<?php echo $board_name ?>"></td>
</tr>


<tr>
	<td align="right" >�}�����</td>
	<td><input type="text" size="10" maxlength="10" name="board_date" value="<?php echo $board_date ?>">(�榡�G2000-08-01)</td>
</tr>


<tr>
	<td align="right" >���O</td>
	<td align="left" >
	<select name=board_k_id>
<?php
	for ($i=0;$i< count($board_k_id_p);$i++)
	if ($i == $board_k_id)
		echo "<option value=\"$i\" selected >".$board_k_id_p[$i];
	else
		echo "<option value=\"$i\">".$board_k_id_p[$i];
?>
	</select>
	</td>
</tr>
<tr>
	<td align="right" >�����ϧǸ�</td>
	<td><input type="text" size="10" maxlength="10" name="bk_order" value="<?php echo $bk_order; ?>">(�榡�G�Ʀr 1-99999)</td>
</tr>
<tr>
	<td align="right" >�����ϼh��</td>
	<td><select size="1" name="position">
	 <?php
	  for($i=0;$i<10;$i++) {
		?>
		<option value="<?php echo $i;?>"<?php if ($i==$position) echo " selected";?>><?php echo $position_array[$i];?></option>		
		<?php
	  }
	 ?>	
		</select>(�榡�G�Ʀr 0-9�A���s��C��i���Y�A��K�\Ū)
	</td>
</tr>

<tr>
	<td align="right" >�ϥδ���</td>
	<td><input type="text" size="10" maxlength="10" name="board_last_date" value="<?php echo $board_last_date; ?>">(�榡�G2000-08-01)</td>
</tr>


<tr>
	<td align="right" >�}��W���ɮ�</td>
	<td align="left" >
	<input type="radio" name="board_is_upload" value="1" <?php echo $board_is_upload_c1 ?>>�O&nbsp;&nbsp;
	<input type="radio" name="board_is_upload" value="0" <?php echo $board_is_upload_c2 ?>>�_
	</td>
</tr>
<tr>
	<td align="right" >�}��վ�峹����</td>
	<td align="left" >
	<input type="radio" name="board_is_sort" value="1" <?php echo $board_is_sort_c1 ?>>�O&nbsp;&nbsp;
	<input type="radio" name="board_is_sort" value="0" <?php echo $board_is_sort_c2 ?>>�_
	</td>
</tr>

<tr>
	<td align="right" >�������O�_���}</td>
	<td align="left" >
		<input type="radio" name="board_is_public" value="1" <?php echo $board_is_public_c1 ?>>�O&nbsp;&nbsp;
	  <input type="radio" name="board_is_public" value="0" <?php echo $board_is_public_c2 ?>>�_
	 (�Y�u�O�v,�h���g���v�ϥΪ̤]���s�����)
	</td>
</tr>

<tr>
	<td align="right" >�������O�_�i�@�s���</td>
	<td align="left" >
		<input type="radio" name="board_is_coop_edit" value="1" <?php echo $board_is_coop_edit_c1 ?>>�O&nbsp;&nbsp;
	  <input type="radio" name="board_is_coop_edit" value="0" <?php echo $board_is_coop_edit_c2 ?>>�_
	(�Y�u�_�v,�h�u��s��ۤv�����)
	</td>
</tr>

<tr>
	<td align="center" valign="middle" bgcolor="#c0c0c0" colspan ="2" BGCOLOR=#cbcbcb >
<?php	
	if ($bk_id == "") {
		echo "<input type=submit name=key value=\"�T�w�s�W\">  ";
			?>
			<font size="2"> 
			<input type="checkbox" name="continue_insert" value="1"<?php if ($_POST['continue_insert']) echo " checked";?>>����}�ҥ��e��</font>
			<?php
	} else if ($key != "�s�W������" ){
		echo "<input type=submit name=key value=\"�T�w�ק�\">  ";
		echo "<input type=submit name=key value=\"�R��\">  ";
		echo "<input type=submit name=key value=\"�s�W������\">  ";
	} else {
		echo "<input type=submit name=key value=\"�T�w�s�W\">";
		?>
		<font size="2"> 
		<input type="checkbox" name="continue_insert" value="1"<?php if ($_POST['continue_insert']) echo " checked";?>>����}�ҥ��e��</font>
		<?php 
	}

?>
	</td>
</tr>
<tr>
	<td style='font-size:9pt' colspan ="2">
	�����G<br>
	1.�m�}��վ�峹���ǡn�峹�C��ɹw�]�O�H�o�G�ɶ������ƧǱ���A�Y�ҥΡA�h�������Ϻ޲z�̥i���N�վ�峹���ǡC<br>
	2.�m�������O�_���}�n�Y��ܡu�_�v�A���g���v���ϥΪ̱N�ݤ��즹�����ϡC<br>
	</td>
</tr>

</table>
</TD></TR>
</TABLE>
<?php
	foot();
?>
