<?php
// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";

sfs_check();

//�e�X�᪺�ʧ@
//�s�W������
if ($_POST['act']=='insert') {
   $id_name=$_POST['id_name'];
   $memo=$_POST['memo'];
   $max_width=$_POST['max_width'];
   $max_height=$_POST['max_height'];
 	 $display_mode=$_POST['display_mode'];
   if ($id_name!="" and $memo!="" and $max_width>0 and $max_height>0) {
     $sql="insert into jshow_setup (id_name,memo,max_width,max_height,display_mode) values ('$id_name','$memo','$max_width','$max_height','$display_mode')";
     $res=$CONN->Execute($sql) or die ("SQL Error! query=".$sql);
   }
	$INFO="�w�� ".date("Y-m-d H:i:s")." �s�W�����ϡy".$id_name."�z!";
	
} 
 
//�T�w�ק�
if($_POST['act']=="update") {
   	$kind_id=$_POST['kind_id'];
   	$id_name=$_POST['id_name'];
		$memo=$_POST['memo'];
		$max_width=$_POST['max_width'];
		$max_height=$_POST['max_height'];
		$display_mode=$_POST['display_mode'];
   	$sql="update jshow_setup set id_name='$id_name',memo='$memo',max_width='$max_width',max_height='$max_height',display_mode='$display_mode' where kind_id='".$_POST['kind_id']."'";
   	$res=$CONN->Execute($sql) or die ("SQL Error! query=".$sql);
   	$INFO="�w�� ".date("Y-m-d H:i:s")." �i���x�s!";
   	$_POST['act']="edit";
} // end if


//�R��
if ($_POST['act']=='delete') {
   	$sql="select * from jshow_setup where kind_id='".$_POST['kind_id']."'";
   	$res=$CONN->Execute($sql) or die ("SQL Error! query=".$sql);
   	$id_name=$res->fields['id_name'];
  	$sql="delete from jshow_setup where kind_id='".$_POST['kind_id']."'";
  	$res=$CONN->Execute($sql) or die("SQL Error! sql=".$sql);
  	$_POST['kind_id']="";
  	$_POST['act']="";
  	$INFO="�w�� ".date("Y-m-d H:i:s")." �R�������ϡu".$id_name."�v!";
  	
}

//�s��
if($_POST['act']=="edit") {
	/*
   	$sql="select * from jshow_setup where kind_id='".$_POST['kind_id']."'";
   	$res=$CONN->Execute($sql) or die ("SQL Error! query=".$sql);
   	$kind_id=$res->fields['kind_id'];
   	$id_name=$res->fields['id_name'];
		$memo=$res->fields['memo'];
		$max_width=$res->fields['max_width'];
		$max_height=$res->fields['max_height'];
		$display_mode=$res->fields['display_mode'];
		//�έp���������X�i��
		$sql="select count(*) from jshow_pic where kind_id='".$_POST['kind_id']."'";
   	$res=$CONN->Execute($sql) or die ("SQL Error! query=".$sql);
		$Number_pic=$res->fields[0];
		*/
		$row=get_setup($_POST['kind_id']);
		
		if (count($row)>0) {
		  foreach ($row as $k=>$v) { ${$k}=$v; }
		}		
		
} // end if


//�q�X����
head("�����Ϻ޲z");

$tool_bar=&make_menu($menu_p);

//�C�X���
echo $tool_bar;


$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);
if ($module_manager!=1) {
  echo "��p�I���\��ݺ޲z�v�~��ާ@�I";
  exit();
}

?>
<form method="post" name="myform" action="<?php echo $_SERVER['PHP_SELF'];?>">
<input type="hidden" name="act" value="">
<input type="hidden" name="opt1" value="">
<table border="0" width="100%" cellspacing="0" cellpadding="3">
 <tr>
 		<!--- ������ ---->
 		<td valign=top bgcolor="#CCCCCC">
 		<table border="0" width="100%" cellspacing="0" cellpadding="0" >
    	<tr>
    		<td>
				<select id="SELECT_kind_id" name="kind_id" size="20">
					<optgroup style="color:#FF0000" label='�п�ܤ�����'></optgroup>
					<?php
					$query = "select * from jshow_setup ";
					$result= $CONN->Execute($query) or die ($query);
					while( $row = $result->fetchRow()){
						if ($row["kind_id"] == $kind_id ){
							echo sprintf(" <option value=\"%s\" selected>%s</option>",$row["kind_id"],$row["id_name"]);
						}	else {
							echo sprintf(" <option value=\"%s\">%s</option>",$row["kind_id"],$row["id_name"]);
						} // end else if
					}
					?>
				</select>
     		</td>
     	</tr>
    </table>
 		</td> 		
 		<!--- �k���� ---->
		<td width="100%" valign="top" bgcolor="#CCCCCC">
			<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
			  <tr id="LIST_BTN_insert" style="display:block">
					<td align="center" valign="middle" bgcolor="#c0c0c0" >
					  <input type="button" value="�s�W������" class="BTN_insert"> 
					</td>
			  </tr>
			  <tr id="LIST_FORM_edit" style="display:none">
			  	<td>
						<table>
						  <tr>
						    <td>�����ϥN�X(kind_id)</td>
						    <td style="color:red"><b><?php echo $kind_id;?></b></td>
						  </tr>
						  <tr>
						    <td>�����ϦW��</td>
						    <td><input type="text" name="id_name" value="<?php echo $id_name;?>"></td>
						  </tr>
						  <tr>
						    <td>�����ϻ���</td>
						    <td><textarea rows="5" cols="60" name="memo"><?php echo $memo;?></textarea></td>
						  </tr>
						  <tr>
						    <td>�Ϥ�����e��</td>
						    <td><input type="text" name="max_width" value="<?php echo $max_width;?>"></td>
						  </tr>
						  <tr>
						    <td>�Ϥ������</td>
						    <td><input type="text" name="max_height" value="<?php echo $max_height;?>"></td>
						  </tr>
						  <tr>
						    <td>�i�ϼҦ�</td>
						    <td>
						    	<select size="1" name="display_mode">
						    	 <option value="0"<?php if ($display_mode=="0") echo " selected";?>>��Ʈw���������Ϥ��̧Ǩq�X</option> 
						    	 <option value="1"<?php if ($display_mode=="1") echo " selected";?>>��Ʈw���������Ϥ��̶üƨq�X</option>
						    	 <option value="2"<?php if ($display_mode=="2") echo " selected";?>>�̫��w����q�X�������S�w�Ϥ�</option>
						    	</select>
						    	</td>
						  </tr>

						</table>				  	
			  	</td>
			  </tr>
			  <tr id="LIST_BTN_insert_submit" style="display:none">
					<td align="center" valign="middle" bgcolor="#FFFFCC" >
					  <input type="button" value="�T�w�s�W" id="BTN_insert_submit"> 
					</td>
			  </tr>
			  <tr id="LIST_BTN_update_submit" style="display:none">
					<td align="center" valign="middle" bgcolor="#FFCCCC">
					  <input type="button" value="�T�w�ק�" id="BTN_update_submit">
					  <?php
					  if ($Number_pic==0) {
					  ?> 
					    <input type="button" value="�R��������" id="BTN_delete_submit"> 
					  <?php 
					  } // end if 
					  ?>
					</td>
			  </tr>
			</table>
			<table border="0">
			  <tr>
 					<td style="color:#FF0000;font-size:9pt"><?php echo $INFO;?></td>
 				</tr>
			</table>			
	  </td>
 </tr>
 <tr id="LIST_BTN_insert2" style="display:none">
		<td align="middle" valign="middle" bgcolor="#CCCCCC">
			  <input type="button" value="�s�W������" class="BTN_insert"> 
		</td>
		<td align="left" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>

</table>

<?php
	foot();
?>
<Script>
	
$(document).ready(function(){
	var act='<?php echo $_POST['act'];?>';
   //�ק�Ҧ�
   if (act=='update' || act=='edit') {
   		$("#LIST_BTN_insert2").show();
     	$("#LIST_BTN_insert").hide();
  	 	$("#LIST_FORM_edit").show();
  		$("#LIST_BTN_update_submit").show();
   }  
}); 

	
//���U�s�W�s��
$(".BTN_insert").click(function(){
  $("#LIST_BTN_insert").hide();
  $("#LIST_FORM_edit").show();
  $("#LIST_BTN_insert_submit").show();
	$("#LIST_BTN_update_submit").hide();
  document.myform.kind_id.value='';
	document.myform.id_name.value='';
	document.myform.memo.value='';
	document.myform.max_width.value='1024';
	document.myform.max_height.value='768';
	document.myform.id_name.focus();
});

//���U�T�w�s�W
$("#BTN_insert_submit").click(function(){
	if (document.myform.id_name.value=='') {
		alert("�п�J�����ϦW��!");
    document.myform.id_name.focus();
	  return false;
	}
	if (document.myform.memo.value=='') {
		alert("�аw������϶i�满��, �H�K�ϥΪ̯���զ������Ϫ`�N�ƶ�!");
    document.myform.memo.focus();
	  return false;
	}
	if (document.myform.max_width.value=='') {
		alert("�п�J�������ϤW�ǹ��ɪ��̤j�e��!");
    document.myform.max_width.focus();
    return false;
	}
	if (document.myform.max_height.value=='') {
		alert("�п�J�������ϤW�ǹ��ɪ��̤j����!");
    document.myform.max_height.focus();
	  return false;
	}
  document.myform.act.value="insert";
  document.myform.submit();
});

//���U�T�w�ק�
$("#BTN_update_submit").click(function(){
 document.myform.act.value="update";
 document.myform.submit();
});

//���U�T�w�R��
$("#BTN_delete_submit").click(function(){
	if (confirm("�z�T�w�n�R�������ϡG�y<?php echo $id_name;?>�z?")) {
   document.myform.act.value="delete";
   document.myform.submit();
  }
  return false;
});

//��ܤ����Ϯ�
$("#SELECT_kind_id").change(function(){
 document.myform.act.value="edit";
 document.myform.submit();
});

</Script>