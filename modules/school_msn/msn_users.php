<?php
//$Id$
include "config.php";
include_once ('my_functions.php');
//�{��
sfs_check();

//�q�X�����������Y
head("�ϥΪ̪��A");
//�D���]�w
$tool_bar=&make_menu($MODULE_MENU);

//�x�s�]�w
if ($_POST['act']=='save') {
  $sql="update sc_msn_online set is_upload='0',is_email='0',is_showpic='0'";
  $res=$CONN->Execute($sql) or die("Error! sql=".$sql);
  foreach ($_POST['teach_setup'] as $teach_id=>$S) {
    $is_upload=$S['is_upload'];
    $is_email=$S['is_email'];
    $is_showpic=$S['is_showpic'];
    
    $sql="update sc_msn_online set is_upload='$is_upload',is_email='$is_email',is_showpic='$is_showpic' where teach_id='$teach_id'";
    $res=$CONN->Execute($sql) or die("Error! sql=".$sql);
    
  }
  
  $INFO="�w�� ".date("Y-m-d H:i:s")."�i���x�s...";
  
} // end if 

//�C�X���
  echo $tool_bar;

$CONN->Execute("SET NAMES 'utf8'");

$O[1]="<font color=red>�b�u�W</font>";
$O[0]="���u";
 //���o��Ƨ�

$sql="select * from sc_msn_online order by teach_id";
//$sql="select * from sc_msn_folder order by idnumber";
$res=$CONN->Execute($sql);
$USERS=$res->GetRows();
 
 $CONN->Execute("SET NAMES 'latin1'");

?>
<form method="post" name="myform" action="<?php echo $_SERVER['php_self'];?>">
<input type="hidden" name="act" value="">
<input type="hidden" name="option1" value="<?php echo $_POST['option1'];?>">

�ն�MSN�ϥΪ̵n���O���Υ\��]�w -- 
<input type="button" value="�x�s�]�w" onclick="document.myform.act.value='save';document.myform.submit()"><br>
<font color="red">
<?php
echo $INFO;
?>
</font>
<table border="1" style="border-collapse:collapse" color="#800000" cellpadding="2">
 <tr bgcolor="#CCCCFF">
 	<td align="center">�b��</td>
 	<td align="center">�m�W</td>
 	<td align="center">�ϥΦ���</td>
 	<td align="center">�̫�ɶ�</td>
 	<td align="center">�n�JIP</td>
 	<td align="center">�ثe���A</td>
 	<td align="center">�i�Υ\��</td>
 </tr>
 <?php
 foreach ($USERS as $user) {
 	$bgcolor=($user['ifonline']==1)?"#FFEFEF":"#FFFFFF";
 	$sql="select name from teacher_base where teach_id='".$user['teach_id']."' and teach_condition=0";
 	$res=$CONN->Execute($sql);
 	if ($res->RecordCount()==0) continue;
 	$name=$res->fields[0];
 ?>
 <tr bgcolor="<?php echo $bgcolor;?>" style="font-size:10pt">
 	<td align="center"><?php echo $user['teach_id'];?></td>
 	<td align="center"><?php echo $name;?></td>
 	<td align="center"><?php echo $user['hits'];?></td>
 	<td align="center"><?php echo $user['lasttime'];?></td>
 	<td align="center"><?php echo $user['from_ip'];?></td>
 	<td align="center"><?php echo $O[$user['ifonline']];?></td>
 	<td>
 	 <input type="checkbox"	value='1' name="teach_setup[<?php echo $user['teach_id'];?>][is_upload]" <?php if ($user['is_upload']==1) echo "checked";?>>�ɮפ���
 	 <input type="checkbox"	value='1' name="teach_setup[<?php echo $user['teach_id'];?>][is_email]" <?php if ($user['is_email']==1) echo "checked";?>>�oE-mail
 	 <input type="checkbox"	value='1' name="teach_setup[<?php echo $user['teach_id'];?>][is_showpic]" <?php if ($user['is_showpic']==1) echo "checked";?>>�q�l�ݪO(��)
 	</td>
 </tr>
 <?php
 }  // end foreach
 ?>

</table>
</form>