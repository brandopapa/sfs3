<?php
//���o�]�w��
include_once "config.php";


sfs_check();

//�s�@��� ( $school_menu_p�}�C�]�w�� module-cfg.php )
$tool_bar=&make_menu($school_menu_p);

//Ū���ثe�ާ@���Ѯv���S���޲z�v
$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);

$R_select=explode(',',$rank_select);
$N_select=explode(',',$nature_select);

//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();

//�ثe��w�Ǵ� , �Y����w�h�H��w���Ǵ��@�����ǥͯZ�Ůy�����̾�, �_�h�H�̷s�Ǵ����Ӹꬰ��
$c_curr_seme=sprintf('%03d%1d',$curr_year,$curr_seme);

//���o�ثe�Ҧ��Z��
$class_array=class_base();

//�w�]�å���w�ǥ�
$start=0;

/** submit �᪺�ʧ@ **************************************************/
//�x�s�@��
if ($_POST['act']=='save') {
	
 	//$student_sn=$_POST['student_sn'];
	$level=$_POST['level'];
	$squad=$_POST['squad'];
	$name=$_POST['r_name'];
	$rank=$_POST['rank'];
  $certificate_date=$_POST['certificate_date'];
	$sponsor=$_POST['sponsor'];
	$memo=$_POST['memo'];
	$word=strip_tags(trim($_POST['word']));
	$weight=$_POST['weight'];
	$weight_tech=$_POST['weight_tech'];
	$year=$_POST['year'];
	$nature=$_POST['nature'];
	$i=0;
	foreach ($_POST['selected_students'] as $student_sn) {
		$query="insert into career_race set student_sn='$student_sn',level='$level',squad='$squad',name='$name',
		rank='$rank',certificate_date='$certificate_date',sponsor='$sponsor',memo='$memo',
		word='{$word}', weight='{$weight}', weight_tech='{$weight_tech}',year='$year',nature='$nature' ,	update_sn='".$_SESSION['session_tea_sn']."'";
   		if (!mysql_query($query)) {
   		 $MSG="�x�s��ƥ���!";
   		  echo $query;die($MSG);
			} 
		$i++;
	} // end foreach
		
	$INFO="�w��".date("Y-m-d H:i:s")."�x�s".$i."���O��.";
	
}
//

/**************** �}�l�q�X���� ******************/
//�q�X SFS3 ���D
head();

//�C�X���
echo $tool_bar;

//print_r($class_array);

?>
<form name="myform" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<input type="hidden" name="act" value="">
	<input type="hidden" name="option1" value="<?php echo $_POST['option1'];?>">

<table border="0" width="100%" cellspacing="1" cellpadding="2" bgcolor="#CCCCCC">
<tr>
  <td>
	<!-- �n�����  -->
	<table border="0" bgcolor="#ffffff" style="border-collapse:collapse" bordercolor="#800000">
		<tr>
			<td style="color:#800000">
				<fieldset style="line-height: 150%; margin-top: 0; margin-bottom: 0">
				<legend><font size=2 color=#0000dd>�п�J�v�ɲӥ�</font></legend>
				<?php
					 	//�w�]��
					 	$race_record['year']=date("Y")-1911;
						$race_record['level']=5;	
						$race_record['squad']=1;
						$race_record['weight']=1;
						$race_record['weight_tech']=1;
						$race_record['certificate_date']=date("Y-m-d");
						form_race_record($race_record);
					?>
			<input type="button" value="�x�s�O��" onclick="check_save()">
			</fieldset>
			</td>
		</tr>
	</table>
	</td>	
</tr>
<tr>
   <td>���w��ǥͦW��(�жi��̫�Ŀ�A���U�u�x�s�O���v)</td>
 </tr>
 <tr>
   <td>
   	<table border="2" style="border-collapse:collapse" bordercolor="#111111" bgcolor="#FFDDDD" width="100%">
   		<tr>
   			<td><span id="show_selected_students">�ثe�L�w��W��</span></td>
   		</tr>
   	</table>   
   </td>
 </tr>
 <tr>
  <td style="color:#FF0000;font-size:10pt"><?php echo $INFO;?></td>
 </tr>
</table>
</form>

<form method="post" name="myform2" action="<?php echo $_SERVER['php_self'];?>">
<table border="0">
 <tr>
  <td>����ܯZ��
  	<select name="the_class" size="1" id="the_class">
  	 <option value="">�п�ܯZ��</option>
					<?php
					 foreach ($class_array as $k=>$v) {
					 ?>
					 <option value="<?php echo $k;?>" ><?php echo $v;?></option>
					 <?php
					 }
					?>  	 
  	</select> <input type="button" id="chk_all" value="����"><input type="button" id="chk_all_clear" value="������">
  	</td>	
 </tr>
 <tr>
 	<td>
 	
 		<span id="the_students"></span>
 	</td>
 </tr>
 <tr>
   <td><input type="button" value="�w��o�Ǿǥ�" id="btn_select_students"></td>
 </tr>
	<tr>
	<td style="font-size:10pt;color:blue">���ϥλ����G</td>
	</tr>
	<tr>
	<td style="font-size:10pt;color:blue">1.���{���ȾA�Ω�n������O���A���i��ӧO�O�����W�R�έק�A�ЧQ��<a href='cr_input.php'>�ӧO�n���\��</a>�C</td>
	</tr>
	<tr>
	<td style="font-size:10pt;color:blue">2.�ϥήɽХ���J�v�ɲӥءA���ۧQ�Ρu����ܯZ�š��Ŀ�ǥ͡v�\��A��ܭn�n�������O�����ǥ͡C</td>
	</tr>
	<tr>
	<td style="font-size:10pt;color:blue">3.���U�u�w��o�Ǿǥ͡v�A�Q�Ŀ諸�W��|��J�u�w��W��v�����C</td>
	</tr>
	<tr>
	<td style="font-size:10pt;color:blue">4.�T�{�n�n�����ǥͦW�泣�b�u�w��W��v�������A�Y�i���U�u�x�s�O���v�A���o�Ǿǥͫإߦ����O���C</td>
	</tr>

</table>

</form>
<?php
//�Y���̪F
if (substr($sch_id,0,2)=='13') {
?>
<script type='text/javascript' src='select_race_option.js'></script>
<?php
 }
?>
<Script>
 //�˴���ƬO�_����
 function check_save() {
 	var ok=1;
 	if (document.myform.r_name.value=='') {
 		ok=0;
 		alert('�п�J�v�ɦW��');
 		document.myform.r_name.focus();
 		return false;
 	}
 	if (document.myform.rank.value=='') {
 		ok=0;
 		alert('�п�J�o���W��, �p�u��1�W�v�B�u�u���v....���C');
 		document.myform.rank.focus();
 		return false;
 	}
 	if (document.myform.certificate_date.value=='') {
 		ok=0;
 		alert('�п�J�ҮѤ��');
 		document.myform.certificate_date.focus();
 		return false;
 	}
 	if (document.myform.sponsor.value=='') {
 		ok=0;
 		alert('�п�J�|����');
 		document.myform.sponsor.focus();
 		return false;
 	}
 	
 	if (ok==1) {
 		document.myform.act.value='save';
 		document.myform.submit();
 	}
 	
 }

 $("#the_class").change(function(){
    $.ajax({
   	type: "post",
    url: 'ajax_return_students.php',
    data: { the_class: $('#the_class').val() , pre_selected:$('#pre_selected').val() },
    error: function(xhr) {
      alert('ajax request �o�Ϳ��~, �L�k���o�ǥͦW��!');
    },
    success: function(response) {
    	$('#the_students').html(response);
      $('#the_students').fadeIn();      
    }
   });   // end $.ajax
 }); // end #the_class

 $("#btn_select_students").click(function(){
 	//�B�z�Ŀ諸�W��, �����}�C
 	var selectedItems = new Array();
 		$("input[name*='chk_student[]']:checked").each(function() {
 					selectedItems.push($(this).val());
 		});

 if (selectedItems .length == 0)
     alert("�ФĿ�ǥ�");
 else
 	
 	�@//�ǰe�Q�Ŀ諸�W��(�ন�H;�j�}���r��)�Τw�w��(pre_selected)�� hidden ��
    $.ajax({
   	type: "post",
    url: 'ajax_select_students.php',
    data: { items:selectedItems.join(';') , pre_selected:$('#pre_selected').val() },
    dataType: "text",
    error: function(xhr) {
      alert('ajax request �o�Ϳ��~, �L�k���o�ǥͦW��!');
    },
    success: function(response) {
    	$('#show_selected_students').html(response);
      $('#show_selected_students').fadeIn(); 
      //�̫�Ǧ^�W�檺 table  �� <input type="hidden" name="pre_selected">
    }
   });   // end $.ajax
 }); // end #the_class

//����
$("#chk_all").click(function(){
  $(".chk_student").attr("checked","true");
});

//������
$("#chk_all_clear").click(function(){
  $(".chk_student").attr("checked","");
});


</Script>
