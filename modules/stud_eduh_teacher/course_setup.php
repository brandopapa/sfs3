<?php

// $Id: stud_eduh_list.php 6461 2011-06-13 02:44:10Z infodaes $

// �ޤJ�z�ۤv�� config.php ��
require "config.php";

// �{���ˬd
sfs_check();
//�ثe�Ǧ~�Ǵ�
$seme_year_seme = sprintf("%03d%d",curr_year(),curr_seme());

//�L�X���Y
head();

//�C�X���
$tool_bar=&make_menu($menu_p);
echo $tool_bar;

//�ˬd�޲z�v��
$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);
if ($module_manager!=1) {
 echo "��p , �z�S���޲z�v��!";
 exit();
}
//submit�᪺�ʧ@ ========================================================================
if ($_POST['mode']=='save') {
	$query="delete from `score_eduh_teacher` where year_seme='$seme_year_seme'";
	mysql_query($query);
  //�̧Ǧs�J checkbox �����
	foreach ($_POST['ss_id'] as $ss_id) {
    $query="insert into `score_eduh_teacher` (year_seme,ss_id,update_sn) values ('$seme_year_seme','$ss_id','".$_SESSION['session_tea_sn']."')";
    mysql_query($query);	
	}
	$MESSAGE="�w��".date("Y-m-d h:i:s")."�s�J�]�w���!";
}
//===<<�D�{���}�l>>=======================================================================
//�����o�@���X�Ӧ~�Ū��ҵ{
$query="SELECT DISTINCT class_year FROM `score_ss` WHERE year ='".curr_year()."' AND semester ='".curr_seme()."' order by class_year";
//echo $query;
$res_class_year=mysql_query($query);
?>
<table border="0">
	<tr>
	<td>�ФĿ沈���t�d��J�ǥͻ��ɸ�ƪ���إ��ЦѮv</td>	
	</tr>
</table>

<table border="0" >
	<form method="post" name="form_select" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<input type="hidden" name="mode" value="save">
 <tr valign="top">	

<?php
while ($row_class_year=mysql_fetch_array($res_class_year)) {
	$query="select a.subject_name,b.ss_id from score_subject a, score_ss b where b.year='".curr_year()."' and b.semester='".curr_seme()."' and b.scope_id=a.subject_id and b.class_year='".$row_class_year['class_year']."'";
	$res_subject=mysql_query($query);
	?>
	<td>
	<table border="1" style="border-collapse:collapse" bordercolor="#800000" width="150" cellpadding="3">
   <tr>
     <td colspan="3"><?php echo $school_kind_name[$row_class_year['class_year']];?>��</td>
   </tr>
   <tr bgcolor="#FFCCFF">
     <td width="30" style="font-size:9pt">��w</td>
     <td width="30" style="font-size:9pt">�N�X</td>
		 <td width="90" style="font-size:9pt">�ҵ{�W��</td>
   </tr>
   		
	<?php
	while ($row_subject=mysql_fetch_array($res_subject)) {
		$query="select ss_id from score_eduh_teacher where year_seme='$seme_year_seme' and ss_id='".$row_subject['ss_id']."'";  
		$CHECKED=(mysql_num_rows(mysql_query($query)))?"checked":"";		
   ?>
   <tr>
     <td width="30" style="font-size:9pt"><input type="checkbox" name="ss_id[]" value="<?php echo $row_subject['ss_id'];?>" <?php echo $CHECKED;?>></td>
     <td width="30" style="font-size:9pt"><?php echo $row_subject['ss_id'];?></td>
		 <td width="90" style="font-size:9pt"><?php echo $row_subject['subject_name'];?></td>
   </tr>
   <?php	 	
	} // end while
	?>
	</table>
</td>
	<?php
} // end while
 ?>
  </tr>
 
</form>	
</table>
<table border="0">
	 <tr>
   <td style="color:#FF0000;font-size:10pt">
   	<input type="button" value="�x�s�]�w" onclick="document.form_select.submit()">
   	<?php echo $MESSAGE;?>
   </td>
  </tr>
</table>

 <?php 
//�L�X���Y
foot();
?> 
