<?php
//$Id: edu_txt.php 5310 2009-01-10 07:57:56Z hami $
//���J�]�w��
require ("config.php");

// �{���ˬd
sfs_check();

$sel_year=$_POST[stud_grad_year]?$_POST[stud_grad_year]:curr_year();
$s=get_school_base();
$sch_id=$s[sch_id];

$postBtn = "�ץXCSV";
if ($_POST[do_key]==$postBtn){
	$str="�ǮեN�X,����m�W,�����Ҧr��,�ʧO\r\n";
	$query = "select a.grad_num,a.grad_kind,b.stud_id,b.stud_name,b.stud_person_id,b.stud_sex FROM grad_stud a LEFT JOIN stud_base b ON a.student_sn=b.student_sn WHERE stud_grad_year=$sel_year AND a.grad_num<>'' ORDER BY grad_num";
	$result =$CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);
	while ($row = $result->FetchRow()) {
		$stud_id=$row['stud_id'];
		$grad_num=$row['grad_num'];
		$grade_kind=$row['grade_kind'];
		$stud_name=$row['stud_name'];
		$stud_person_id=$row['stud_person_id'];
		$stud_sex=$row['stud_sex'];
		$str.="\"$sch_id\",$stud_name,$stud_person_id,$stud_sex\r\n";
	}
	$filename ="$sch_id $school_long_name $sel_year �Ǧ~�׫�������Ш|��Ʈw.csv";
	header("Content-disposition: filename=$filename");
	header("Content-type: application/octetstream");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");

	echo $str;	
	exit;
}

//������~�~��
$stud_grad_year="�����~�~�סG<select name='stud_grad_year' onchange='this.form.submit();'>";
$query = "SELECT DISTINCT stud_grad_year FROM grad_stud ORDER BY stud_grad_year DESC";
$result =$CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256); 
while ($row = $result->FetchRow()) {
	$grad_year=$row[stud_grad_year];
	$select=($grad_year==$sel_year)?' selected':'';
	$stud_grad_year.="<option value='$grad_year'$select>$grad_year</option>";
}
$stud_grad_year.="</select>";

head();
print_menu($menu_p);
?>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr><td valign="top" bgcolor="#CCCCCC" align="center">
<table width="80%" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top">  
  <form name ="myform" action="<?php echo $PHP_SELF ?>" method="post" >
   <table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"   class=main_body >	
   <tr>
	
	<td class=title_mbody colspan=4 align=center >
	<?php 
	echo $stud_grad_year;
	?> <input type="submit" name="do_key" value="<?php echo $postBtn ?>">
</td>
   </tr>
</table>
</form>
   <table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"   class=main_body >	
   <tr class=title_sbody1 ><td align=center>�Ǹ�</td><td align=center>���׷~�ҮѸ�</td><td align=center>����m�W</td><td align=center>�����Ҧr��</td><td align=center>�ʧO</td></tr>
<?php
	//�C�X�Q�����
	$query = "select a.grad_num,a.grad_kind,b.stud_id,b.stud_name,b.stud_person_id,b.stud_sex FROM grad_stud a LEFT JOIN stud_base b ON a.student_sn=b.student_sn WHERE stud_grad_year=$sel_year AND a.grad_num<>'' ORDER BY grad_num";
	$result =$CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256) ;    	
	while ($row = $result->FetchRow()) {
		$stud_id = $row['stud_id'];
		$grad_num = $row['grad_num'];
		$grade_kind=$row['grade_kind'];
		$stud_name = $row['stud_name'];
		$stud_person_id = $row['stud_person_id'];
		$stud_sex=$row['stud_sex'];
		echo "<tr><td>$stud_id</td><td>$grad_num</td><td>$stud_name</td><td>$stud_person_id</td><td>$stud_sex</td><td></td></tr>\n";
	}

?>
</table>
</td>
<td valign="top" width=300>

</td>
</tr>
</table> 
</td>
</tr>
</table> 
<?php
foot();
?>
