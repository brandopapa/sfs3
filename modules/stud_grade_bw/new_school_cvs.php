<?php
//$Id: new_school_cvs.php 7711 2013-10-23 13:07:37Z smallduh $
//���J�]�w��
require ("config.php");

// �{���ˬd
sfs_check();

$english_name=$_POST["english_name"]?"checked":"";
$move_in=$_POST["move_in"]?"checked":"";

//echo $english_name."---".$move_in;

($IS_JHORES==0) ? $UP_YEAR=6:$UP_YEAR=9;//�P�_�ꤤ�p

$postBtn = "�s�ͤJ�Ǹ����Xcsv��";
$class_name = class_base();
if ($_POST[do_key]==$postBtn){
	$curr_year =curr_year()+1;
	$new_school_str=($_POST[curr_grade_school])?"and g.new_school= '$_POST[curr_grade_school]'":"";
	//$str ="�J�Ǧ~,�®զW,�����Ҧr��,�m�W".($english_name)?",�^��m�W":"".",�ʧO(�k��:1�A�k��:2),�q��,�ͤ�]�褸�^,�a���m�W,��},��Z��".($move_in)?",���y�E�J���":""."\n";
	$str ="�J�Ǧ~,�®զW,�����Ҧr��,�m�W,";
	$str.=($english_name)?"�^��m�W,":"";
	$str.="�ʧO(�k��:1�A�k��:2),�q��,�ͤ�]�褸�^,�a���m�W,���y��},��Z��";
	$str.=($move_in)?",���y�E�J���":"";
	$str.=($_POST[curr_grade_school])?"":",�ɾǾǮ�";
	$str.=($_POST[stud_addr_2])?",�p����}":"";
	$str.=($_POST[stud_tel_3])?",�p�����":"";
	$str.="\r\n";
	//$sqlstr = "select s.stud_id, s.stud_person_id, s.stud_addr_1, s.stud_addr_2,stud_tel_3, s.stud_name, s.stud_sex, s.stud_birthday, s.stud_tel_1, s.curr_class_num, g.grad_sn, g.new_school, d.guardian_name, s.stud_name_eng, s.addr_move_in from stud_base as s, stud_domicile d, grad_stud g where s.stud_id=g.stud_id AND s.stud_id=d.stud_id and s.stud_study_cond='0' $new_school_str and s.curr_class_num like '$UP_YEAR%' order by g.new_school,s.curr_class_num";
	$sqlstr = "select s.stud_id, s.stud_person_id, s.stud_addr_1, s.stud_addr_2,stud_tel_3, s.stud_name, s.stud_sex, s.stud_birthday, s.stud_tel_1, s.curr_class_num, g.grad_sn, g.new_school, d.guardian_name, s.stud_name_eng, s.addr_move_in from stud_base as s left join stud_domicile d on s.stud_id=d.stud_id, grad_stud g where s.stud_id=g.stud_id and s.stud_study_cond='0' $new_school_str and s.curr_class_num like '$UP_YEAR%' order by g.new_school,s.curr_class_num";
	$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;    	
	
	while(!$result->EOF){
		//�Z��
		$c_name = $class_name[substr($result->fields[curr_class_num],0,-2)];
		$str.="\"".$curr_year."\",";
		$str.="\"".$SCHOOL_BASE[sch_cname_ss]."\",";
		$str.="\"".$result->fields[stud_person_id]."\",";
		$str.="\"".$result->fields[stud_name]."\",";
		$str.=($english_name)?"\"".($result->fields[stud_name_eng])."\",":"";
		$str.="\"".$result->fields[stud_sex]."\",";
		$str.="\"".$result->fields[stud_tel_1]."\",";
		$str.="\"".$result->fields[stud_birthday]."\",";
		$str.="\"".$result->fields[guardian_name]."\",";
		$str.="\"".$result->fields[stud_addr_1]."\",";
		$str.="\"".$c_name;
		$str.=($move_in)?"\",\"".($result->fields[addr_move_in]):"";
		$str.=($_POST[curr_grade_school])?"":"\",\"".$result->fields[new_school];
		$str.=($_POST[stud_addr_2])?"\",\"".$result->fields[stud_addr_2]:"";
		$str.=($_POST[stud_tel_3])?"\",\"".$result->fields[stud_tel_3]:"";
		$str.="\"\r\n";

		$result->MoveNext();
	}
	
	header("Content-disposition: attachment; filename=".$SCHOOL_BASE[sch_cname_ss].curr_year()."�Ǧ~�פɤJ".$_POST[curr_grade_school]."�ǥͦW�U.csv");
	header("Content-type: text/x-csv");
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
  <tr><td valign=top bgcolor="#CCCCCC" align=center >
<table width="80%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td>  
  <form name ="myform" action="<?php echo $PHP_SELF ?>" method="post" >
   <table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"   class=main_body >	
   <tr>
	
	<td class=title_mbody colspan=4 align=center >
	<?php 
		$curr_grade_school=stripslashes($_REQUEST[curr_grade_school]);
		$def_grade_school = get_grade_school();	
		$sel1 = new drop_select();
		$sel1->s_name="curr_grade_school";
		$sel1->is_submit = true;
		$sel1->use_val_as_key = true;
		$sel1->top_option = "�����X�Ǯ�(����h���C)";
		$sel1->id = $curr_grade_school;
		$sel1->arr = $def_grade_school;
		$sel1->do_select();
		
//		echo sprintf("%d�Ǧ~��%d�Ǵ� ",$curr_year,$curr_seme);
		

	?>  <BR>
  <input type="checkbox" name="english_name" <?php echo $english_name; ?> onclick='this.form.submit()'>�^��m�W�@
  <input type="checkbox" name="move_in" <?php echo $move_in; ?> onclick='this.form.submit()'>���y�E�J���
  <input type="checkbox" name="stud_addr_2" <?php if ($_POST[stud_addr_2]) echo "checked" ?> onclick='this.form.submit()'>�p����}
  <input type="checkbox" name="stud_tel_3" <?php if ($_POST[stud_tel_3]) echo "checked" ?> onclick='this.form.submit()'>�p�����
  <BR><input type="submit" name="do_key" value="<?php echo $postBtn ?>">
</td>
   </tr>
</table>
</form>
   <table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"   class=main_body >	
   <tr class=title_sbody1 ><td align=center>�Z��</td><td align=center>
   �y��</td><td align=center>�Ǹ�</td><td align=center>�m�W</td><?php echo ($english_name)?"<td>�^��m�W</td>":""; ?><td align=center>�ɾǾǮ�</td><td>��Z��</td><?php echo ($move_in)?"<td>���y�E�J���</td>":""; ?><?php echo ($_POST[stud_addr_2])?"<td>�p����}</td>":""; ?><?php echo ($_POST[stud_tel_3])?"<td>�p�����</td>":""; ?></tr>
<?php
	//�Ǹ��B�m�W�B�ɾ�
          $sqlstr = "select s.stud_id , s.stud_name ,s.curr_class_num , 
             g.grad_sn , g.new_school  from stud_base as s  LEFT JOIN grad_stud as g ON s.stud_id=g.stud_id 
             where s.stud_study_cond = '0' and new_school= '$_POST[curr_grade_school]' and s.curr_class_num like '$UP_YEAR%' order by s.curr_class_num ";  
	$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;    	
	 while ($row = $result->FetchRow() ) {
	        $stud_id = $row['stud_id'] ;
	        $stud_name = $row['stud_name'] ;
	        $stud_name_eng= $row['stud_name_eng'] ;
	        $addr_move_in=$row['addr_move_in'] ;
			$stud_addr_2=$row['stud_addr_2'] ;
			$stud_tel_3=$row['stud_tel_3'] ;
	        
	        $curr_class_num = $row['curr_class_num'] ;
	        $grad_sn = $row['grad_sn'] ;
	        $new_school = $row['new_school'] ;
		$cname = $class_name[substr($curr_class_num,0,-2)];
			$sel1->s_name = "change_class_$stud_id"; //���W��
			echo ($i++ % 2 ==0)? "<tr class=nom_1>":"<tr class=nom_2>";
   			echo "<td align=center>".substr($curr_class_num,0,3)."</td>"; 
   			echo "<td align=center>".substr($curr_class_num,-2)."</td>"; 
   			echo "<td align=center>$stud_id</td>"; 
   			echo "<td align=center>$stud_name</td>";
   			echo $english_name?"<td align=center>$stud_name_eng</td>":"";
   			echo "<td align=center>"; 
   			echo $new_school ;
   			echo "</td>";
			echo "<td>$cname</td>";	
			echo $move_in?"<td align=center>$addr_move_in</td>":"";
			echo $_POST[stud_addr_2]?"<td align=center>$stud_addr_2</td>":"";
			echo $move_in?"<td align=center>$stud_tel_3</td>":"";
   			echo "</tr>\n";
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
<ul>
<li>���{���i�̤��P���ꤤ��X�s�ͦW�U�A��K�ǰϤ��ꤤ�s�ͽs�Z�ާ@�A����s�ͽs�Z�Ѧ� <a
href="../temp_compile/">&lt;&lt; �s�ͽs�Z�Ҳ� &gt;&gt;</a></li>
</ul>
<ul>
<li>�i��ǥ͸���ಾ�ɡA�Ш̭ӤH��ƫO�@�k�����W�w�A��
�K�ǥ͸�ƥ~���C</li>
</ul>
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
