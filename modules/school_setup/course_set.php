<?php

// $Id: course_set.php 5310 2009-01-10 07:57:56Z hami $

// ���J�]�w��
include "school_base_config.php";
// �{���ˬd
sfs_check();

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

if ($c_seme_year_seme != "")
	$seme_year_seme = $c_seme_year_seme;
else if (!$seme_year_seme)
	$seme_year_seme = sprintf("%03d%d",curr_year(),curr_seme()); //�w�]���Ǵ�

if ($c_sub_year != "")
	$sub_year = $c_sub_year;	
else if (!$sub_year)
	$sub_year = 1 ; //�w�]�@�~��

$sub1 = new school_subject_class();
$course9 = course9(); // �ǲ߻��W��
$subject_kind = subject_kind();// ��ئW��
switch ($key) { 
	case $editBtn:
		$query = "select sub_id from school_subject where seme_year_seme='$seme_year_seme' and sub_year='$sub_year'";
		$result =mysql_query($query) or die($query);
		while ($row= mysql_fetch_row($result)) {
			$sub_id = $row[0];
			$sub_name = "sub_name_$row[0]";
			$sub_num = "sub_num_$row[0]";
			$sub_percent = "sub_percent_$row[0]";
			$sub_course = "sub_course_$row[0]";
			$is_exam = "is_exam_$row[0]";
			$sql_update = "update school_subject set sub_name='".$$sub_name."',sub_course='".$$sub_course."',is_exam='".$$is_exam."',sub_num='".$$sub_num."',sub_percent='".$$sub_percent."',update_id='$update_id' where sub_id=$sub_id and seme_year_seme='$seme_year_seme' and sub_year='$sub_year'";
			mysql_query($sql_update) or die ($sql_update);
		}
	break;
	
	case delete :
		$sub1->delete("sub_id",$sub_id);
	break;
	
	case $postBtn :
		$sub1->post();		
		$ckey = $newBtn ;
	break;
}

$sub1->query("select * from school_subject where seme_year_seme='$seme_year_seme' and sub_year='$sub_year' ");

head();
//�L�X���
print_menu($school_menu_p);

?>

<center>
<table border=0 cellpadding=0 cellspacing=0 width=100% bgcolor=#cccccc>
<tr><td align=center>
<form method="post" action="<?php echo {$_SERVER['PHP_SELF']} ?>"  >

<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="660" class=main_body >
<tr class=title_sbody2 >
	<td align=center colspan="7" >
<?php
	//��ܾǦ~
	$sel1 = new drop_select();
	$sel1->s_name = "c_seme_year_seme"; //���W��
	$sel1->id = $seme_year_seme;	//����ID
	$sel1->arr = get_class_seme(); //���e�}�C
	$sel1->has_empty = false; //���C�X�ť�	
	$sel1->is_submit = true; //��ʮɰe�X�d��
	$sel1->do_select();
	//��ܦ~��	
	$sel1 = new drop_select();
	$sel1->s_name = "c_sub_year"; //���W��
	$sel1->id = $sub_year;	//����ID
	$sel1->arr = $class_year; //���e�}�C
	$sel1->has_empty = false; //���C�X�ť�	
	$sel1->is_submit = true; //��ʮɰe�X�d��
	$sel1->do_select();
	
	//drop_select("sub_year",$sub_year,$class_year,0); 
	echo "&nbsp;&nbsp;";
	echo ($sub1->num_rows && ($ckey == "$editModeBtn" || isset($editkey)) )? "<input type=submit name=\"ckey\" value=\"$browseModeBtn\">": "<input type=submit name=\"ckey\" value=\"$editModeBtn\">";
	echo "&nbsp;&nbsp;<input type=\"submit\" name=\"ckey\" value=\"$newBtn\">";
	if ($ckey=="$editModeBtn") 
		echo "&nbsp;&nbsp;<input type=\"submit\" name=\"key\" value=\"$editBtn\">";

?>
</td>
</tr>
<tr class=title_sbody1>      
    <td align=center><?php echo $sub1->Record_cname[sub_name] ?></td>
    <td align=center><?php echo $sub1->Record_cname[sub_course] ?></td>
    <td align=center><?php echo $sub1->Record_cname[sub_num] ?></td>
    <td align=center><?php echo $sub1->Record_cname[sub_percent] ?></td>
    <td align=center><?php echo $sub1->Record_cname[is_exam] ?></td>
    <?php
    //if ($ckey !="$editModeBtn")
    	echo "<td align=center  >�ʧ@</td>\n";
    //�s�W�Ҧ�
echo "</tr>";

if ($ckey == "$newBtn") {
		echo "<tr >";		
  		echo "<td align=center>";
  		//��ܬ��
		$sel1 = new drop_select();
		$sel1->s_name = "sub_name"; //���W��		
		$sel1->arr = $subject_kind; //���e�}�C		
		$sel1->do_select();
  		echo"</td>\n";
  		echo "<td align=center>";
  		//��ܻ��
		$sel1 = new drop_select();
		$sel1->s_name = "sub_course"; //���W��
		$sel1->arr = $course9; //���e�}�C		
		$sel1->do_select();
  		echo "</td>";
		echo "<td align=center><input type=\"text\" size=\"2\" maxlength=\"2\" name=\"sub_num\" ></td>\n";
		echo "<td align=center><input type=\"text\" size=\"3\" maxlength=\"3\" name=\"sub_percent\" >%</td>\n";
		echo "<td align=center><input type=\"checkbox\" name=\"is_exam\" value=\"1\"></td>";		
		echo "<td align=center><input type=\"submit\" name=\"key\" value=\"$postBtn\"></td>";
		echo "</tr>";
}
    ?>
    
<?php

for ($j=0;$j<$sub1->num_rows;$j++) {
	$sub_id = $sub1->Record["sub_id"];
	$seme_year_seme = $sub1->Record["seme_year_seme"];
	$sub_name =  $sub1->Record["sub_name"];
	$sub_course = $sub1->Record["sub_course"];
	$sub_year = $sub1->Record["sub_year"];
	$is_exam = $sub1->Record["is_exam"];
	$sub_num = $sub1->Record["sub_num"];
	$sub_percent = $sub1->Record["sub_percent"];
	$sub_num_total +=$sub_num;
	$sub_percent_total += $sub_percent;
	$ti = ($i++%2)+1;
	echo "<tr class=nom_$ti >";
	if ($ckey=="$editModeBtn" && $sub1->num_rows) {
		
  		echo "<td align=center>";
  		//��ܬ��
		$sel1 = new drop_select();
		$sel1->s_name = "sub_name_$sub_id"; //���W��
		$sel1->id = $sub_name;
		$sel1->arr = $subject_kind; //���e�}�C
		$sel1->has_empty = false; //���C�X�ť�
		$sel1->do_select();
  		
  		echo"</td>\n";
  		echo "<td align=center>";
  		//��ܻ��
		$sel1 = new drop_select();
		$sel1->s_name = "sub_course_$sub_id"; //���W��
		$sel1->id = $sub_course;
		$sel1->arr = $course9; //���e�}�C
		$sel1->has_empty = false; //���C�X�ť�
		$sel1->do_select();  		
  		echo "</td>";
		echo "<td align=center><input type=\"text\" size=\"2\" maxlength=\"2\" name=\"sub_num_$sub_id\" value=\"$sub_num\"></td>\n";
		echo "<td align=center><input type=\"text\" size=\"3\" maxlength=\"3\" name=\"sub_percent_$sub_id\" value=\"$sub_percent\">%</td>\n";
		echo "<td align=center><input type=\"checkbox\" name=\"is_exam_$sub_id\" value=\"1\"";
		echo ($is_exam)?" checked ></td>":" ></td>";				
		
	}
	else {
		echo "<td align=center>$subject_kind[$sub_name]&nbsp;</td>";
  		echo "<td align=center>$course9[$sub_course]&nbsp;</td>";
		echo "<td align=center>$sub_num&nbsp;</td>";	
		echo "<td align=center>$sub_percent%&nbsp;</td>";	
		echo "<td align=center>";
		echo ($is_exam)?"��":"X";
		echo "</td>";		
	}
	echo "<td align=center ><a href=\"{$_SERVER['PHP_SELF']}?key=delete&sub_id=$sub_id\" onClick=\"return confirm('�T�w�R�� $sub_name �O��?');\">�R��</a>&nbsp;</td>";
	echo "</tr>";
	$sub1->next_record();
}
?>
<? if($sub1->num_rows) {
?>
<tr class=title_sbody2>      
    <td align=center colspan=2>�X�p&nbsp;</td>    
    <td align=center><?php echo $sub_num_total ?>&nbsp;</td>
    <td align=center><?php echo $sub_percent_total ?>%&nbsp;</td>
    <td align=center colspan=2>&nbsp;</td>    
</tr>
<?php
}
?>
</table>
<input type="hidden" name="update_id" value="<?php echo $_SESSION['session_log_id'] ?>">
</form>
</td></tr></table>
</center>

<?php
	foot();
?>