<?php
//$Id: edu_txt.php 7711 2013-10-23 13:07:37Z smallduh $
//���J�]�w��
require ("config.php");

// �{���ˬd
sfs_check();

$curr_seme=$_POST[curr_seme];
if (!$curr_seme) $curr_seme = sprintf("%03d%d",curr_year(),curr_seme());
$sel_year=intval(substr($curr_seme,0,-1));
$sel_seme=substr($curr_seme,-1,1);
$stud_study_year=($IS_JHORES==0)?6:3;
$stud_study_year=$sel_year-$stud_study_year+1;
$s=get_school_base();
$sch_id=$s[sch_id];
$edu_id_arr=($IS_JHORES==0)?array("1"=>"01","2"=>"02"):array("1"=>"81","2"=>"81");

$postBtn = "�Ш|�{�׸���ɶץX";
if ($_POST[do_key]==$postBtn){
	$query = "select a.*,b.grad_kind from stud_base a left join grad_stud b on a.student_sn=b.student_sn and b.stud_grad_year='$sel_year' where stud_study_year='$stud_study_year' and (stud_study_cond='0' or stud_study_cond='5') order by stud_id";
	$result =$CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);
	while ($row = $result->FetchRow()) {
		$stud_id = $row['stud_id'];
		$stud_name = mb_substr($row['stud_name']."�@�@�@�@�@�@",0,6);
		$stud_person_id = $row['stud_person_id'];
		$dd=explode("-",$row['stud_birthday']);
		$dd[0]=$dd[0]-1911;
		$stud_birthday = sprintf("%07d",implode("",$dd));
		$edu_id = $edu_id_arr[$row['grad_kind']];
		$cname = $class_name[substr($curr_class_num,0,-2)];
		$str.=$stud_name.strtoupper(sprintf("% 10s",$stud_person_id)).$stud_birthday.$edu_id.sprintf("%06d",$sch_id)."\r\n";
	}
	
	$filename = "edu.txt";
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
	//�C�X�~�קO���
		$class_seme_p = get_class_seme(); //�Ǧ~��
		$sel1 = new drop_select();
		$sel1->s_name="curr_seme";
		$sel1->is_submit = true;
		$sel1->top_option = "��ܾǴ�";
		$sel1->id = $curr_seme;
		$sel1->arr = $class_seme_p;
		$sel1->do_select();
		
	?><input type="submit" name="do_key" value="<?php echo $postBtn ?>">
</td>
   </tr>
</table>
</form>
   <table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"   class=main_body >	
   <tr class=title_sbody1 ><td align=center>�m�@�@�@�@�W</td><td align=center>���������<br>�Τ@�s��</td><td align=center>�X�ͤ��</td><td align=center>�Ш|�{�ץN�X</td><td align=center>�ǮեN�X</td></tr>
<?php
	//�C�X�Q�����
	$query = "select a.*,b.grad_kind from stud_base a left join grad_stud b on a.student_sn=b.student_sn and b.stud_grad_year='$sel_year' where stud_study_year='$stud_study_year' and (stud_study_cond='0' or stud_study_cond='5') order by stud_id limit 0,10";
	$result =$CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256) ;    	
	while ($row = $result->FetchRow()) {
		$stud_id = $row['stud_id'];
		$stud_name = substr($row['stud_name']."�@�@�@�@�@�@",0,12);
		$stud_person_id = $row['stud_person_id'];
		$dd=explode("-",$row['stud_birthday']);
		$dd[0]=$dd[0]-1911;
		$stud_birthday = sprintf("%07d",implode("",$dd));
		$edu_id = $edu_id_arr[$row['grad_kind']];
		$cname = $class_name[substr($curr_class_num,0,-2)];
		echo "<tr><td>$stud_name</td><td>$stud_person_id</td><td>$stud_birthday</td><td>$edu_id</td><td>$sch_id</td></tr>\n";
	}

?>
</table>
</td>
<td valign="top" width=300>
<!-- ���� -->
<table
style="width: 100%; text-align: left; background-color: rgb(255, 255, 204);"
border="1" cellpadding="1" cellspacing="1">
<tbody>
<tr>
<td style="vertical-align: top;">
�`�N�ƶ��G
<ol>
<li>���]���^�~�ͤηs�ͱШ|�{�׸�������x�s���¤�r�ɡC</li>
<li style="color: red;">�p�G�z�����H�s�����}�Ҥ�r�ɮɡA�ЦA�u���ƹ��k����˵���l�X�v��A�t�s�s�ɡA�Y�i�ݨ쥿�`�榡�C</li>
<li>�ɮפ��e���]�A�ǥͩm�W�B��������ҲΤ@�s���B�X�ͤ���B�Ш|�{�ץN�X�ξǮեN�X��������ơA����ɤ����n�����Y�ΦC�����u�C</li>
<li>�m�W�����ӥ��Τ���r�A��r�a���̧Ǳƻ��A�������ӥ��Τ���r�������d���ΪťաA�W�L���ӥ��Τ���r�����h������J�ABig5�X�ҵL����r�h�d���ΪťաC</li>
<li>��������ҲΤ@�s�����Q��b�έ^�Ʀr�A�䤤�^��r���j�g�C</li>
<li>�X�ͤ�����C��b�μƦr�A�䤤�X�ͦ~���T��Ʀr�a�k�A�p�G�u���G��h�e����0�F�ܩ�X�ͤ�ΥX�ͤ駡���G��Ʀr�a�k�A�p�u���@��h�e����0�C</li>
<li>�Ш|�{�ץN�X���G��b�μƦr�A�s�ͻP�w�~���Ш|�{�ץN�X�ۦP�A��N�X�Ԩ��N�X��C</li>
<li>�ǮեN�X������b�μƦr�A��N�X���̾ڱШ|���έp�B�J�s���u�U�žǮզW���v�C�j�M�|�դέxĵ�Ǯդ��ǮեN�X�u�ĥΫ�|�X�A�e����X��99�C</li>
<li>�n�����@���ǥ͸�ƫ�����������A�n���ĤG���ǥ͸�ơC</li>
<li>�ع��λ⦳�~�d�Ҫ��ǥ͡A�]���㦳���y�n�O���{�����إ����������A�������e�Ш|�{�׸�ơC</li>
</ol>
</td>
</tr>
</tbody>
</table>
<!-- �������� -->
</td>
</tr>
</table> 
</td>
</tr>
</table> 
<?php
foot();
?>
