<?php
// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";

sfs_check();

$teacher_arr = teacher_array();
$post_office_p = room_kind();
$post_office_p[99] = "�Ҧ��Юv";
$title_p = array();
$query = "SELECT *  FROM teacher_title ";
$query .= " where title_kind >= '$titl_kind' and enable=1 order by title_kind,teach_title_id ";
$result = mysql_query($query,$conID) or die ($query);          
while ($row= mysql_fetch_array($result))
	$title_p[$row["teach_title_id"]] = $row["title_name"];

//�e�X�᪺�ʧ@
//�s�W���v
if ($_POST['act']=='insert') {
	  $kind_id=$_POST['kind_id'];
	  $post_office=$_POST['post_office'];
	  $teach_title_id=$_POST['teach_title_id'];
	  $teacher_sn=$_POST['teacher_sn'];
	  	
		$sql_insert = "insert into jshow_check (kind_id,post_office,teacher_sn,teach_title_id,is_admin) values ('$kind_id','$post_office','$teacher_sn','$teach_title_id','$is_admin')";
		$res=$CONN->Execute($sql_insert);

		$_POST['act']='edit';

} 
//�R��
if ($_POST['act']=='delete') {
  	$sql="delete from jshow_check where id='".$_POST['opt1']."'";
  	$res=$CONN->Execute($sql) or die("SQL Error! sql=".$sql);
		$_POST['act']='edit';
}

//�s��
if ($_POST['act']=='edit') {
   	$sql="select * from jshow_setup where kind_id='".$_POST['kind_id']."'";
   	$res=$CONN->Execute($sql) or die ("SQL Error! query=".$sql);
   	$id_name=$res->fields['id_name'];

   	$sql="select * from jshow_check where kind_id='".$_POST['kind_id']."'";
   	$res=$CONN->Execute($sql) or die ("SQL Error! query=".$sql);
   	$row_rights=$res->GetRows();
} 




//�q�X����
head("�����ϱ��v");

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
						if ($row["kind_id"] == $_POST['kind_id'] ){
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
 		<!--- �k����� ---->
		<td width="100%" valign="top" bgcolor="#CCCCCC">
			<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
			  <tr id="LIST_INFO_insert" style="display:block">
					<td align="center" valign="middle" bgcolor="#c0c0c0">
					  �бq��������I������� 
					</td>
			  </tr>
			  <tr id="LIST_rights_choice" style="display:none">
			  	<td>
						<table>
						  <tr>
						    <td>�����ϦW��</td>
						    <td><font color="red"><?php echo $id_name;?></font> -- ���v���U�C�s�թέӤH(�i�ƿ��J)</td>
						  </tr>
						  <tr>
						    <td>�B�Ǹs��</td>
						    <td>
								<?php  
									$sel1 = new drop_select(); //������O	
									$sel1->s_name = "post_office"; //���W��		
									$sel1->arr = $post_office_p; //���e�}�C		
									$sel1->do_select();	  
	 							?>	
						    </td>
						  </tr>
						  <tr>
						    <td>¾�ٱЮv</td>
						    <td>
						    	<?php  
									$sel1 = new drop_select(); //������O	
									$sel1->s_name = "teach_title_id"; //���W��		
									$sel1->arr = $title_p; //���e�}�C		
									$sel1->do_select();	  
	 								?>	
						    </td>
						  </tr>
						  <tr>
						    <td>�ӧO�Юv</td>
						    <td>
						    	<?php
										$sel = new drop_select();
										$sel->s_name = "teacher_sn";
										$sel->arr = $teacher_arr;
										$sel->do_select();
									?>
						    </td>
						  </tr>
						</table>				  	
			  	</td>
			  </tr>
			  <tr id="LIST_BTN_insert_submit" style="display:none">
			  	<td>
			  		<input type="button" value="�s�W���v" id="BTN_insert_submit"> 
			  	</td>
			  </tr>
			</table>
			<table border="0" id="LIST_user_right" style="display:none">
			 <tr>
			   <td><font color=red><?php echo $id_name;?></font> -���v����</td>
			 </tr>
			 <tr>
			  <td>
				  	<table width=600 border=1>
							<tr>
								<td>�B�Ǹs��</td>
								<td>¾�ٸs��</td>
								<td>�ӧO�Юv</td>
								<td>�R�����v</td>
							</tr>

 			  <!-- ���U�����v���� -->
			  <?php
			   foreach ($row_rights as $R) {
					$id = $R["id"];
					$kind_id = $R["kind_id"];
					$post_office = $R["post_office"];
					$teacher_name = $teacher_arr[$R["teacher_sn"]];
					$teach_title_id = $R["teach_title_id"];
					?>
							<tr>
								<td><?php echo $post_office_p[$post_office];?></td>
								<td><?php echo $title_p[$teach_title_id];?></td>
								<td><?php echo $teacher_name;?></td>
								<td><input type="button" value="�R�����v" class="BTN_delete_submit" id="<?php echo $id;?>"></td>
							</tr>
				 	<?php
				 }
					?>
						</table>
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
</table>

<?php
	foot();
?>
<Script>
	
$(document).ready(function(){
	var act='<?php echo $_POST['act'];?>';
   //�s��Ҧ�
   if (act=='update' || act=='edit') {
      $("#LIST_INFO_insert").hide();
      $("#LIST_BTN_insert_submit").show();
  	 	$("#LIST_user_right").show();
  		$("#LIST_rights_choice").show();
   }  
}); 

	
//���U�T�w�s�W
$("#BTN_insert_submit").click(function(){
	var post_office=document.myform.post_office.value;
	var teach_title_id=document.myform.teach_title_id.value;
	var teacher_sn=document.myform.teacher_sn.value;
	if (post_office!='' || teach_title_id!='' || teacher_sn!='') {
  	document.myform.act.value="insert";
  	document.myform.submit();
  }
});

//���U�T�w�R��
$(".BTN_delete_submit").click(function(){
   var sn=$(this).attr("id");
   document.myform.act.value="delete";
   document.myform.opt1.value=sn;
   document.myform.submit();
});

//��ܤ����Ϯ�
$("#SELECT_kind_id").change(function(){
 document.myform.act.value="edit";
 document.myform.submit();
});

</Script>