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
	$sql_insert = "insert into board_kind (bk_id,board_name,board_date,board_k_id,board_last_date,board_is_upload,board_is_public,board_admin) values ('$bk_id','$board_name','$board_date','$board_k_id','$board_last_date','$board_is_upload','$board_is_public','$board_admin')";
	mysql_query($sql_insert,$conID) or die($sql_insert);
	break;
	case "�T�w�ק�" :
	$sql_update = "update board_kind set board_name='$board_name ',board_date='$board_date',board_k_id='$board_k_id',board_last_date='$board_last_date',board_is_upload='$board_is_upload',board_is_public='$board_is_public',board_admin='$board_admin'where bk_id='$bk_id' ";
	mysql_query($sql_update,$conID) or die ($sql_update);
	break;
	case "�T�w�R��" :
	$sql_update = "delete  from board_kind  where bk_id='$bk_id'";	
	mysql_query($sql_update,$conID) or die ($sql_update);
	break;
}

if ($key != "�s�W����"){
//  --�ثe���
	$query = "select * from board_kind where bk_id ='$bk_id' ";
	$result = mysql_query ($query,$conID) or die ($query); 
	$row = mysql_fetch_array($result);
}
else
$query = "select bk_id,board_name from board_kind order by bk_id limit 0,1 ";
	
$bk_id = $row["bk_id"];
$board_name = $row["board_name"];
$board_date = $row["board_date"];
$board_k_id = $row["board_k_id"];
$board_last_date = $row["board_last_date"];
$board_is_upload = $row["board_is_upload"];
$board_is_public = $row["board_is_public"];
$board_admin = $row["board_admin"];

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
	if ($key == "�s�W����" or $bk_id =="")
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
       str= "���ϥN�����i�d�šI�ЦA�Զ�I";
     }
     if      (document.eform.board_name.value == "")
     {
             OK=false;
       str= "���ϦW�٤��i�d�šI�ЦA�Զ�I";
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
	$grid1 = new sfs_grid_menu;  //�إ߿��	   
	//$grid1->bgcolor = $gridBgcolor;  // �C��   
	//$grid1->row = $gri ;	     //��ܵ���
	$grid1->key_item = "bk_id";  // ������W  	
	$grid1->display_item = array("bk_id","board_name");  // �����W   	
	$grid1->class_ccs = " class=leftmenu";  // �C�����
	$grid1->sql_str = "select bk_id,board_name from board_kind order by bk_id";   //SQL �R�O   
	$grid1->do_query(); //����R�O   
	
	$grid1->print_grid($bk_id); // ��ܵe��   

	?>
     </td></tr></table>
  </td>
 <!--- �k���� ---->
<td width="100%" valign=top bgcolor="#CCCCCC">

<form action="<?php echo $PHP_SELF ?>" name=eform method="post" onsubmit="return checkok()"> 
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
<?php
if ($key == "�s�W����" or $key == "�T�w�s�W" or $bk_id == ""){
?>
  <td align="right"  nowrap>���ϥN��</td>
	<td><input type="text" size="12" maxlength="12" name="bk_id" value="<?php echo $bk_id ?>"></td>
  <?php	
  }
 else
{
?> 
   <input type="hidden" name="bk_id" value="<?php echo $bk_id ?>">
   <td align="right"  nowrap>���ϥN��</td>
	<td><?php echo $bk_id ?></td>
	
  <?php	
 }
	
 ?> 
</tr>
 
	<td align="right"  nowrap>���ϦW��</td>
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
	<td align="right" >�ϥδ���</td>
	<td><input type="text" size="10" maxlength="10" name="board_last_date" value="<?php echo $board_last_date ?>">(�榡�G2000-08-01)</td>
</tr>


<tr>
	<td align="right" >�}��W���ɮ�</td>
	<td align="left" >
	<input type="radio" name="board_is_upload" value="1" <?php echo $board_is_upload_c1 ?>>�O&nbsp;&nbsp;
	<input type="radio" name="board_is_upload" value="0" <?php echo $board_is_upload_c2 ?>>�_
	</td>
</tr>


<tr>
	<td align="right" >�C�b�հȪ�</td>
	<td align="left" ><input type="radio" name="board_is_public" value="1" <?php echo $board_is_public_c1 ?>>�O&nbsp;&nbsp;
	 <input type="radio" name="board_is_public" value="0" <?php echo $board_is_public_c2 ?>>�_
	</td>
</tr>

<tr>
	<td align="center" valign="middle" bgcolor="#c0c0c0" colspan =2 BGCOLOR=#cbcbcb >
<?php	
	if ($bk_id == "")
		echo "<input type=submit name=key value=\"�T�w�s�W\">  ";
	else if ($key != "�s�W����" ){
		echo "<input type=submit name=key value=\"�T�w�ק�\">  ";
		echo "<input type=submit name=key value=\"�R��\">  ";
		echo "<input type=submit name=key value=\"�s�W����\">  ";
	}
	else{
		echo "<input type=submit name=key value=\"�T�w�s�W\">";
	}

?>
	</td>
</tr>

</table>
</TD></TR>
</TABLE>
<?php
	foot();
?>
