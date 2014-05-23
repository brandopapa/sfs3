<?php
require "config.php";
require "imging.class.php";
sfs_check();



switch ($_POST['act']) {
	// �s��
	case 'edit':
		$id = (int) $_POST['id'];
		$teacher_sn = (int)$_SESSION['session_tea_sn'];
		$query = "SELECT * FROM artical_detail WHERE id=$id";
		$res = $CONN->Execute($query);

		$editRow = $res->fetchRow();
		$man = checkid($_SERVER[SCRIPT_FILENAME],1);
		if (!($editRow['teacher_sn']==$teacher_sn or $man)) {
			echo '<h1>�L�v�ק�</h1>';
			exit;
		}
	break;
	//�R�ǥͷӤ�
	case 'delete-photo' :
		$student_sn = (int) $_POST['studentSn'];
		$file_name = $photoUploadPath.$student_sn.'.jpg';
		if (is_file($file_name)) {
			unlink($file_name);
			echo 1;
		}
		exit;

		break;
	// �W�ǾǥͷӤ�
	case 'uploadStudentPhoto':
	//�W�ǷӤ�
		$student_sn = (int) $_POST['studentSn'];
		if (is_file($_FILES['student_photo']['tmp_name'])) {
			$ext = end(explode(".",$_FILES['student_photo']['name']));
			if (in_array(strtolower($ext),array('jpg','jpeg'))){
				$file_name = $photoUploadPath.$student_sn.'.jpg';
				copy($_FILES['student_photo']['tmp_name'], $file_name);
				$img = new imaging;
				$img->set_img($file_name);
				$img->set_quality(90);
				// Small thumbnail
				$img->set_size($PARAMSTER['image_width']);
				$img->save_img($file_name);
					echo $UPLOAD_URL.$photo_path_str.$student_sn.'.jpg?'.time();
			}
			exit;
		}
		break;

	//�ˬd�Ӥ���
	case 'getStudentPhoto':
		$studentSn = (int)$_POST['studentSn'];
		if (is_file($photoUploadPath.$studentSn.'.jpg'))
		echo $UPLOAD_URL.$photo_path_str.$studentSn.'jpg?time='.time();
		else 	echo '';
		exit;
		break;

	// �s�W�峹
	case 'append' :

		$teacher_sn = (int)$_SESSION['session_tea_sn'];
		$artical_id =  filter_input(INPUT_POST, 'artical_id' ,FILTER_SANITIZE_NUMBER_INT);
		$title = $_POST['title'];//filter_input(INPUT_POST, 'title',FILTER_SANITIZE_STRIPPED);
		$student_sn = filter_input(INPUT_POST, 'student_sn' ,FILTER_SANITIZE_NUMBER_INT);
		$class_number = filter_input(INPUT_POST, 'classNum' ,FILTER_SANITIZE_NUMBER_INT);
		$content = $_POST['content'];//filter_input(INPUT_POST, 'content');
		$id = filter_input(INPUT_POST, 'id');
		$image_align = filter_input(INPUT_POST, 'image_align' ,FILTER_SANITIZE_NUMBER_INT);
		$mode = '';
		if ($id) {
			// �ק�
			$query = "UPDATE artical_detail SET title='$title' , content='$content'
			 ,class_number='$class_number' ,image_align='$image_align'
			 ,student_sn=$student_sn WHERE id=$id ";
			$CONN->Execute($query) or die($query);
			$mode='edit';
		}
		else{
			// �s�W
			$query = "INSERT INTO artical_detail(artical_id, title, content, student_sn, class_number, teacher_sn, image_align)
			VALUES($artical_id, '$title', '$content', $student_sn, $class_number, $teacher_sn, $image_align)";
			$res = $CONN->Execute($query) or die($query);
			$id = $CONN->Insert_ID();
		}



		// �W�ǹϤ�
		if (is_file($_FILES['photo']['tmp_name'])) {
			$ext = end(explode(".",$_FILES['photo']['name']));
			if (in_array(strtolower($ext),$fileExt)){
				$photo_ext = strtolower($ext);
			 	$file_name = $uploadPath.$id.'.'.$photo_ext;
				copy($_FILES['photo']['tmp_name'], $file_name);
				$img = new imaging;
				$img->set_img($file_name);
				$img->set_quality(90);
				// Small thumbnail
				$img->set_size($PARAMSTER['image_width']);
				$img->save_img($file_name);
				$photo_memo = filter_input(INPUT_POST, 'photo_memo');
				$query = "UPDATE artical_detail SET photo_ext='$photo_ext', photo_memo='$photo_memo' WHERE id=$id";
				$CONN->Execute($query) or die($query);
			}
		}
		if ($mode == 'edit')
		header("Location: show.php?id=$id");
		else
		header("Location: list.php");
		exit;
	break;

	// �d�߾ǥ�
	case 'getStudent':

		$classNum = (int)$_POST['classNum'];
		$query = "SELECT stud_name,student_sn FROM stud_base WHERE curr_class_num='$classNum' AND stud_study_cond=0";
		$res = $CONN->Execute($query) or die('SQL ���~');

		$result = '';
		if ($res->recordCount() > 0) {
			$class_base = class_base();
			$tempClass = substr($classNum,0,3);
			$tempNumber = substr($classNum,-2);
			$result = $res->fields['student_sn'].'-'. $class_base[$tempClass].' '.$tempNumber.'�� '.$res->fields['stud_name'];
		}

		header('Content-type:text/html; charset=big5');
		echo $result;
		exit;
		break;
}


head();
print_menu($menu_p);
$date = date("Y-m-d");

// ���O
$query = "SELECT start_date,end_date, title, id  FROM artical WHERE is_publish='1' AND  start_date<='$date' AND end_date>='$date'";
$resYear = $CONN->Execute($query) or trigger_error('SQL ���~');

?>
<script type="text/javascript" src="<?php echo $SFS_PATH_HTML?>javascripts/external/jquery.metadata.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $SFS_PATH_HTML?>javascripts/jquery/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $SFS_PATH_HTML?>javascripts/jquery/messages_tw.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $SFS_PATH_HTML?>javascripts/jquery/ajaxupload.js" type="text/javascript"></script>

<style>
.ui-widget {padding:5px;font-size:14px}
#student_name {background:#ff7}
.error {color:red; font-weight: bold;}
#image_align, #student_photo, #student_photo_image {display: none}
#student_photo_image{width:300px; border:#ccc thin dashed; margin:10px; padding:3px}
#uploadStudentBtn {border:#ccc solid thin;padding:2px;cursor: pointer;margin:auto 5px}
#delete-photo {border:thin #ccc solid; padding:3px}
</style>
<script>
$(function(){
	 var newValue = $('#classNum').val();
     var oldValue;

	//�R���Ӥ�
	$("#delete-photo ").click(function(){
		if (confirm('�T�w�R���ۤ�?')){
				$.post('sign.php',
						{
						act:'delete-photo',
						studentSn: $("#student_sn").attr('value')
						},
						function(data){
							if (data==1){
								$("#student_photo_image").attr('src','').hide();
								$("#delete-photo").hide();
							}

					});
			}
	});

 	// �Ӥ��W��
 	new AjaxUpload('uploadStudentBtn', {
 	 	action: 'sign.php',
 	 	name:  'student_photo',
 		autoSubmit: true,
 		onSubmit : function(file , ext){
            // Allow only images. You should add security check on the server-side.
			if (ext && /^(jpg|jpeg)$/.test(ext.toLowerCase())){
				/* Setting data */
				this.setData({
					act : 'uploadStudentPhoto',
					studentSn: $("#student_sn").val()
				});
				$('#uploadMessage').text('�w�W���ɮ� ' + file);
			} else {
				// extension is not allowed
				$('#uploadMessage').text('���~: �����T���ɮ榡');
				// cancel upload
				return false;
			}
		},
		onComplete : function(file,data){
			$('#uploadMessage').text('�w�W�� ' + file);
			if (data) {
				$("#student_photo_image").attr('src',data).show();
				$("#delete-photo").show();
			}
			else {
				$("#student_photo_image").attr('src','').hide();
				$("#delete-photo").hide();
			}
		}



 	 });


	$.metadata.setType("attr", "validate");
	$("#signForm").validate();

	$("#submitBtn").click(function(){
		if ($("#signForm").valid())
			$(this).attr('disabled','disabled');
		$("#signForm").submit();
	});

	$("#classNum").focusout(function(){
		var classNum = $(this).attr('value');
		newValue = classNum;
		if (classNum=='' || oldValue == newValue ) return false;

		 oldValue = newValue;

		$.post('sign.php',{act:'getStudent',classNum: classNum},function(data){
			if (data){
				var studentData = data.split("-");
				$("#student_name").html(studentData[1]);
				$("#student_sn").attr('value',studentData[0]);
				$("#student_photo").show();
				$("#delete-photo").show();
				$.post('sign.php',{act:'getStudentPhoto', studentSn:studentData[0]},function(data){
					if (data) {
						$("#student_photo_image").attr('src','<?php echo $UPLOAD_URL.$photo_path_str?>'+studentData[0]+'.jpg').show();
						$("#delete-photo").show();
					}
					else {
						$("#student_photo_image").attr('src','').hide();
						$("#delete-photo").hide();
					}

				});
			}
			else {
				$("#student_name").html('');
				$("#student_photo").hide();
				$("#student_photo_image").hide();
				$("#student_sn").attr('value','');
				$("#classNum").attr('value','');
				alert('�䤣��ǥ�');
			}
		});
	});


	$("#photo").change(function(){
		var allow = new Array('gif','png','jpg','jpeg');
		var ext = $('#photo').val().split('.').pop().toLowerCase();
		if(jQuery.inArray(ext, allow) == -1) {
		    alert('�����T���Ϥ��榡!');
		    $(this).val('');
		    $("#image_align").hide();
		}
		else
			$("#image_align").show();
	});

	<?php if ($editRow):?>
	$("#classNum").trigger('focusout');
	<?php endif?>
});
</script>

<div class="ui-widget ui-widget-header ui-corner-top"><span style="font-size:20px">��Z</span></div>
<div class="ui-widget ui-widget-content ui-corner-bottom">
<div style="float:right">
<img id="student_photo_image"  src="" />
<a href="#" id="delete-photo" style="display: none">�R���Ӥ�</a>
</div>
<form action="" method="post" id="signForm" enctype="multipart/form-data">
<dl>
<dt>���O</dt>
<dd><select name="artical_id">
<?php foreach ($resYear as $row):?>
<option value="<?php echo $row['id']?>"><?php echo $row['title']?> [<?php echo $row['start_date'].' �� '.$row['end_date']?>] </option>
<?php endforeach?>
</select></dd>
<dt>�@��</dt>
<dd><input type="text" size="6" name="classNum" id="classNum"  value="<?php echo $editRow['class_number']?>" validate="required:true"  />
�п�J�Z�Ůy��(�� 60101,�N�� ���~�@�Z1��)</dd>
<dd id="student_photo">
<span id="student_name"></span>
<span id="uploadStudentBtn" class="ui-widget ui-state-default ui-corner-all">�W�ǾǥͷӤ�</span>
<span id="uploadMessage" style="background: #ff0"></span>
</dd>

<dt>�D�D</dt>
<dd><input type="text" name="title" id="title" size="40" validate="required:true"  value="<?php echo $editRow['title']?>"/></dd>
<dt>���e</dt>
<dd><textarea name="content" id="content" rows="5" cols="40" validate="required:true" ><?php echo $editRow['content']?></textarea></dd>
<dt>�W�Ǵ���(�u���� jpg png gif �榡�ɮ�)</dt>
<dd><input type="file" name="photo" size="20" id="photo" />
<span id="image_align">
�Ϥ���m : <select name="image_align">
<?php foreach ($imageArr as $id=>$val):?>
<option value="<?php echo $id?>"><?php echo $val?></option>
<?php endforeach?>
</select>
�Ϥ����� : <input type="text" name="photo_memo"  size="16"/>
</span>
</dl>
<input type="hidden" name="student_sn" id="student_sn" />
<input type="hidden" name="act" value="append" />
<?php if ($editRow):?>
<input type="button" id="submitBtn" value="�s�׽Z��" />
<input type="hidden" name="id" value="<?php echo $editRow['id']?>" />
<?php else:?>
<input type="button" id="submitBtn" value="��Z" />
<?php endif?>
</form>
<div style="clear:both"></div>
</div>
