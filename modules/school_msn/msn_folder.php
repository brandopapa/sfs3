<?php
//$Id$
include "config.php";
include_once ('my_functions.php');
//�{��
sfs_check();


//�q�X�����������Y
head("�ɮק��]�w");
//�D���]�w
$tool_bar=&make_menu($MODULE_MENU);

//�C�X���
  echo $tool_bar;

$CONN->Execute("SET NAMES 'utf8'");

//�s�W
if ($_POST['act']=='insert') {
 $foldername=trim(big52utf8($_POST['foldername']));
 if ($foldername!='') {
 	$idnumber="F".date("y").date("m").date("d").date("H").date("i").date("s");
 //���եN�X�O�_����
	do {
	 $a=floor(rand(0,9));
	 $idnumber_test=$idnumber.$a;
	 $query="select id from sc_msn_folder where idnumber='".$idnumber_test."'";
	 $result=$CONN->Execute($query);
	 $exist=$result->RecordCount();
	} while ($exist>0);

 $idnumber=$idnumber_test;
  $sql="insert into sc_msn_folder (idnumber,foldername,open_upload) values ('$idnumber','$foldername','1')";
  $res=$CONN->Execute($sql) or die ('SQL Error! query='.$sql);
 }	

} // end if ($_POST['act']=='insert')

//�ק�
if ($_POST['act']=='update') {
 $foldername=trim(big52utf8($_POST['update_name']));
	$idnumber=$_POST['option1'];
  $sql="update sc_msn_folder set foldername='$foldername' where idnumber='$idnumber'";
  $res=$CONN->Execute($sql) or die ('SQL Error! query='.$sql);

} // end if ($_POST['act']=='insert')

//�R��
if ($_POST['act']=='delete') {
 
	$idnumber=$_POST['option1'];
  $sql="delete from sc_msn_folder where idnumber='$idnumber'";
  $res=$CONN->Execute($sql) or die ('SQL Error! query='.$sql);

} // end if ($_POST['act']=='insert')


 //���o��Ƨ�

$sql="select * from sc_msn_folder where open_upload='1' order by idnumber";
//$sql="select * from sc_msn_folder order by idnumber";
$res=$CONN->Execute($sql);
$folders=$res->GetRows();

?>
<form method="post" name="myform" action="<?php echo $_SERVER['php_self'];?>">
<input type="hidden" name="act" value="">
<input type="hidden" name="option1" value="<?php echo $_POST['option1'];?>">
�s�W�u�ɮפ��ɡv�\�઺�ɮק����O�G<input type="text" size="20" value="" name="foldername">
<input type="button" value="�T�w�s�W" onclick="if (document.myform.foldername.value!='') { document.myform.act.value='insert';document.myform.submit(); } ">
<br><br>
<table border="0" width="100%">
	<tr>
		<td align="left" style="font-size:10pt" style="color:#FF0000">���t�Τ��w�إߪ��ɮק�</td>
 </tr>
</table>
<table border="1" style="border-collapse:collapse" color="#800000" cellpadding="2">
 <tr bgcolor="#CCCCFF">
 	<td align="center">�s��</td>
 	<td align="center">�ɮק��W��</td>
 	<td align="center">��Ƶ���</td>
 	<td align="center">�s��</td>
 </tr>
 <?php
	$i=0;
 foreach ($folders as $FOLDER) {
   $sql="select count(*) from sc_msn_data where folder='".$FOLDER['idnumber']."'";
   $res=$CONN->Execute($sql);
   $num=$res->fields[0];
   $i++;
   if ($_POST['act']=='edit' and $_POST['option1']==$FOLDER['idnumber']) {
 		?>
 		<tr bgcolor="#FFCCCC">
 			<td align="center"><?php echo $i;?></td>
 			<td><input type="text" name="update_name" value="<?php echo iconv("UTF-8","big5",$FOLDER['foldername']);?>"></td>
 			<td align="center"><?php echo $num;?></td>
 			<td>
 			 <input type="button" value="�x�s" onclick="if (document.myform.update_name.value!='') { document.myform.option1.value='<?php echo $FOLDER['idnumber'];?>';document.myform.act.value='update';document.myform.submit(); } ">
 			</td>
 		</tr>
 
	<?php   	
   } else {
 	?>
 <tr>
 	<td align="center"><?php echo $i;?></td>
 	<td><?php echo iconv("UTF-8","big5",$FOLDER['foldername']);?></td>
 	<td align="center"><?php echo $num;?></td>
 	<td>
 	  <input type="button" value="�ק�" onclick="document.myform.option1.value='<?php echo $FOLDER['idnumber'];?>';document.myform.act.value='edit';document.myform.submit(); ">
 	  <?php 
 	   if ($num==0) {
 	  ?>
 	  <input type="button" value="�R��" onclick="if (confirm('�z�T�w�n�R���G\n<?php echo $FOLDER['foldername'];?>?')) { document.myform.option1.value='<?php echo $FOLDER['idnumber'];?>';document.myform.act.value='delete';document.myform.submit(); } ">
 	  <?php
 	   }
 	  ?>
 	</td>
 </tr>
 <?php
   } // end if
 } // end foreach

 ?>
</table>
</form>