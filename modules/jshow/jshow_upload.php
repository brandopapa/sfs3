<?php
// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";

sfs_check();

//�e�X�᪺�ʧ@
if ($_POST['act']=='upload') {
 //�T�꦳�ɮ�
    if ($_FILES['thefile']['name']!="") {
     //�ɮ׳B�z
     $FILENAME=process_upload_file($_POST['kind_id']);
     
     if ($FILENAME[0]) {
 
            //�}�l�s�J
            $kind_id=$_POST['kind_id'];
            $sub=$_POST['sub'];
            $memo=$_POST['memo'];
            $sort=$_POST['sort'];
            $url=$_POST['url'];
            $upload_day=date("Y-m-d H:i:s");
            $teacher_sn=$_SESSION['session_tea_sn'];
            $filename=$FILENAME[0];
             
            $sql="insert into jshow_pic (kind_id,sub,memo,filename,display,display_sub,display_memo,upload_day,teacher_sn,sort,url) values ('$kind_id','$sub','$memo','$filename','1','0','0','$upload_day','$teacher_sn','$sort','$url')";
						$CONN->Execute($sql) or die ("SQL Error! sql=".$sql);            
						
						$INFO="�W�Ǧ��\!";
						            
     } else {
       $INFO=$FILENAME[1];
     }     
		} else {
		  $INFO="�W���ɮץ���!";
		}
		$_POST['act']="";
} // end if

//��s
if ($_POST['act']=='update') {
 $id=$_POST['opt1'];
   $kind_id=$_POST['kind_id'];
   $sub=$_POST['sub'];
   $memo=$_POST['memo'];
   $sort=$_POST['sort'];
   $url=$_POST['url'];
   $upload_day=date("Y-m-d H:i:s");
   $teacher_sn=$_SESSION['session_tea_sn'];
   if ($_FILES['thefile']['name']!="") {
     $FILENAME=process_upload_file($_POST['kind_id']);
   } else {
     $FILENAME="";
   }
 if ($sub!="" and $memo!="") {
  //�S��s����
  if ($FILENAME[0]=="") {
   //�x�s
    $sql="update jshow_pic set sub='$sub',memo='$memo',sort='$sort',url='$url' where id='$id'";
    $res=$CONN->Execute($sql) or die ("SQL Error! sql=".$sql);
    $INFO=$FILENAME[1]." �ȶi���r��s!";
  } else {
 	//����s�ɮ�, �R������
 	 $sql="select filename from jshow_pic where id='$id'";
   $res=$CONN->Execute($sql) or die("SQL Error! sql=".$sql);
   $filename=$res->fields['filename'];
   $a=explode(".",$filename);
 	 $filename_s=$a[0]."_s.".$a[1];
 	 $filename_a=$a[0]."_a.".$a[1];
   unlink($USR_DESTINATION.$filename);
   unlink($USR_DESTINATION.$filename_s);
   unlink($USR_DESTINATION.$filename_a);
 	
   $filename=$FILENAME[0];
 	
  //�x�s
    $sql="update jshow_pic set sub='$sub',memo='$memo',sort='$sort',filename='$filename',url='$url' where id='$id'";
    $res=$CONN->Execute($sql) or die ("SQL Error! sql=".$sql);
    $INFO="�w�x�s��s!";
  } // end if else 
 } // end if ($sub!="" and $memo!="") 
  $_POST['act']="";
} //if ($_POST['act']=='update')


//�R��
if ($_POST['act']=='delete') {
  $sql="select * from jshow_pic where id='".$_POST['opt1']."'";
  $res=$CONN->Execute($sql) or die("SQL Error! sql=".$sql);
  $filename=$res->fields['filename'];
  $a=explode(".",$filename);
 	$filename_s=$a[0]."_s.".$a[1];
 	$filename_a=$a[0]."_a.".$a[1];
  unlink($USR_DESTINATION.$filename);
  unlink($USR_DESTINATION.$filename_s);
  unlink($USR_DESTINATION.$filename_a);
  $sql="delete from jshow_pic where id='".$_POST['opt1']."'";
  $res=$CONN->Execute($sql) or die("SQL Error! sql=".$sql);
  $_POST['act']='';
}

//���X�Ҧ��g���v��������
$P=get_jshow_checked_id();


//�q�X����
head("Joomla!�����q�Ϻ޲z-�Ϥ��W�Ǻ޲z");

$tool_bar=&make_menu($menu_p);

//�C�X���
echo $tool_bar;

//�C�X�Ĥ@�����Ϥ�
$PAGE=($_GET['page']=='')?1:$_GET['page'];

$doit=($_POST['act']=='')?"�W�Ǥ@�i�s��":"��s�Ϥ�";

?>
<form method="post" name="myform" action="<?php echo $_SERVER['PHP_SELF'];?>"  enctype="multipart/form-data" >
 <input type="hidden" name="act" value="">
 <input type="hidden" name="opt1" value="<?php echo $_POST['opt1'];?>">
 <table border="0">
 	<tr>
 		<td>���ɤW�Ǧ�
 			<select size="1" name="kind_id" id="SELECT_kind_id">
 				<option value="">��ܤ�����</option>
 			<?php
 			foreach ($P as $p) {
 			?>
 			  <option value="<?php echo $p['kind_id'];?>" <?php if ($_POST['kind_id']==$p['kind_id']) { echo "selected";} ?>><?php echo $p['id_name'];?></option>
 			<?php
 			}
 			?> 	
 			</select>
 		</td>
 	</tr>
  </table>
  <?php
 if ($_POST['kind_id']!="") {
 	  //���o�����ϳ]�w
  	$row=get_setup($_POST['kind_id']);
		if (count($row)>0) {
		  foreach ($row as $k=>$v) { ${$k}=$v; }
		}	
 	//�W�Ƿs��
  	if ($_POST['act']=='') {
  		//�w�]��
  		$PIC['sort']=100;
  ?>
  <table border="0">
 	<tr>
 		<td>
 		 <?php form_upload($PIC,$memo); ?>
 		</td>
 	</tr>
 	<tr>
 		<td>
 			<input type="button" value="<?php echo $doit;?>" onclick="check_upload('upload')">
 		</td>
 	</tr>
 	</table>
 <?php
   }  // end if ($_POST['act']=='')
  
  //edit �ק�
  if ($_POST['act']=='edit') {
  	$PIC=get_one_pic($_POST['opt1']);
  ?>
  <table border="0">
 	<tr>
 		<td>
 		 <?php form_upload($PIC,$memo); ?>
 		</td>
 	</tr>
 	<tr>
 		<td>
 			<input type="button" value="<?php echo $doit;?>" onclick="check_upload('update')">
 		</td>
 	</tr>
</table>
  <?php	
  	
   
 }
 ?>
 
 <table border="0">
 	<tr>
 	 <td style="color:#FF0000"><?php echo $INFO;?></td>
 	</tr>
 </table>

	<?php
	//�C�X�W�Ǫ��

	//�C�X�w�W�Ǫ��Ϥ�
	show_upload($_POST['kind_id']);

} // end if ($POST['kind_id']=="")
?>
</form>
<Script>
 function confirm_delete(b_id,info) {
  
  var confirm_del=confirm("�z�n�w�n�G\n�R���u"+info+"�v?");
  
  if (confirm_del) {
    document.myform.act.value="delete";
    document.myform.opt1.value=b_id;
    document.myform.submit();
  } else {
  	return false
  }
 
 }
 
//��ܤ����Ϯ�
$("#SELECT_kind_id").change(function(){
 document.myform.act.value="";
 document.myform.submit();
});


function check_upload(themode) {
 document.myform.act.value=themode;
 //alert(themode);
 
 if (document.myform.sub.value=='') {
   alert('�п�J�D�D!');
   document.myform.sub.focus();
   return false;
 }
 
 if (document.myform.memo.value=='') {
   alert('�п�J����!');
   document.myform.memo.focus();
   return false;
 } 
 
  if (document.myform.thefile.value=='' && themode=='upload') {
   alert('������w�ɮ�!');
   return false;
 }
 
 document.myform.submit();
 
}

</Script>