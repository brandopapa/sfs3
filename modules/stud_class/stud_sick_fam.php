<?php 

// $Id: stud_sick_fam.php 6055 2010-08-31 02:08:48Z brucelyc $

// ���J�]�w��
include "stud_reg_config.php";
// �{���ˬd
sfs_check();

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

//�Юv���ЯZ��
$class_num = get_teach_class();

if ($class_num=='') {
	head("�v�����~");	
	stud_class_err();
	foot();
	exit;
}

// �إ����O
$tea1 = new stud_sick_f_class();

$fam_sick_kind_p =fam_sick_kind(); //���o�f�v���		
//����B�z 
switch ($key){	
	case $postBtn: //�s�W	
		$chk_str = $tea1->chk_str;
		reset($fam_sick_kind_p);
		$temp_value ="";
		while(list($tid,$tname)=each($fam_sick_kind_p)) {
			$temp =$chk_str."_$tid";
			if ($GLOBALS[$temp])
				$temp_value .= "$tid,";
		}
		if ($temp_value) {
		 	$sql_insert = "insert into stud_sick_f (stud_id,s_calling,sick) values ('$stud_id','$s_calling','$temp_value')";
		 	mysql_query($sql_insert) or die ($sql_insert);
		 }
		 
	break;
	case "delete": //�s�W
		$tea1->delete("sick_id",$sick_id);
	break;
	case $editBtn: //�ק�		
		$query = " select sick_id from stud_sick_f where stud_id='$stud_id' order by sick_id";
		$result = mysql_query($query);
		while($row = mysql_fetch_row($result)) {
			$chk_str = "fam_$row[0]"; // ��O��
			reset($fam_sick_kind_p);
			$temp_value ="";
			while(list($tid,$tname)=each($fam_sick_kind_p)) {
				$temp =$chk_str."_$tid";				
				if ($GLOBALS[$temp])
					$temp_value .= "$tid,";
			}
			if($temp_value) {				
				//$sick_id = "$chk_str"."sick_id_$row[0]";
				$s_calling = "s_calling_$row[0]";				
				$sql_update = "update stud_sick_f set s_calling='".$$s_calling."',sick='$temp_value' where sick_id=$row[0]";
				mysql_query ($sql_update) or die ($sql_update);
			}
			else
				mysql_query("delete from stud_sick_f  where sick_id=$row[0]");
		}
	$ckey = $editModeBtn ;//�]���ק�Ҧ�
	break;	
}

//----------------------------------------

//�x�s���U�@��
if ($chknext)
	$stud_id = $nav_next;	
		
$tea1->query("select stud_sick_f.* ,stud_base.stud_id,stud_base.stud_name,stud_base.curr_class_num from stud_base left join stud_sick_f on stud_sick_f.stud_id=stud_base.stud_id where stud_base.stud_id='$stud_id' and   stud_base.curr_class_num like '$class_num%'  order by stud_sick_f.sick_id "); 
//$tea1->debug();
//���]�w�Χ��ܦb¾���p�ΧR���O���� ��Ĥ@��
if ($stud_id =="" || $stud_id != $tea1->Record[stud_id]) {
	$result= mysql_query("select stud_base.stud_id from stud_base where  stud_base.curr_class_num like '$class_num%' order by curr_class_num limit 0,1");
	$row = mysql_fetch_row($result);	
	$tea1->query("select stud_sick_f.* ,stud_base.stud_id,stud_base.stud_name,stud_base.curr_class_num from stud_base left join stud_sick_f on stud_sick_f.stud_id=stud_base.stud_id where stud_base.stud_id='$row[0]' and  stud_base.curr_class_num like '$class_num%'  order by stud_sick_f.sick_id "); 	
}

$stud_id = $tea1->Record[stud_id];

//�L�X���Y

head();

//���s���r��
$linkstr = "stud_id=$stud_id&sel=$sel&curr_seme=$curr_seme";
print_menu($student_menu_p,$linkstr);

?> 
<script language="JavaScript">

function checkok()
{
	var OK=true;	
	document.myform.nav_next.value = document.gridform.nav_next.value;	
	return OK
}

function setfocus(element) {
	element.focus();
 return;
}
//-->
</script>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr><td valign=top bgcolor="#CCCCCC">
 <table border="0" width="100%" cellspacing="0" cellpadding="0" >
    <tr>
      <td  valign="top" >    
	<?php       
	//�إߥ�����	
	$temparr = class_base();   
	$upstr = $temparr[$class_num]; 
	
	// source in include/PLlib.php    
	$grid1 = new sfs_grid_menu;  //�إ߿��	   
	$grid1->bgcolor = $gridBgcolor;  // �C��   
	$grid1->row = $gridRow_num ;	     //��ܵ���   
	$grid1->key_item = "stud_id";  // ������W  	
	$grid1->display_item = array("sit_num","stud_name");  // �����W   
	$grid1->display_color = array("1"=>"$gridBoy_color","2"=>"$gridGirl_color"); //�k�k�ͧO
	$grid1->color_index_item ="stud_sex" ; //�C��P�_��
	$grid1->class_ccs = " class=leftmenu";  // �C�����
	$grid1->sql_str = "select stud_id,stud_name,stud_sex,substring(curr_class_num,4,2)as sit_num from stud_base where  curr_class_num like '$class_num%' and stud_study_cond=0 order by curr_class_num";   //SQL �R�O 
	$grid1->do_query(); //����R�O
	if ($key == $newBtn || $key == $postBtn)    
		$grid1->disabled=1;
	$downstr = "<input type=hidden name=ckey value=\"$ckey\">";
	$grid1->print_grid($stud_id,$upstr,$downstr); // ��ܵe��    

?>
     </td></tr></table>
     </td>
    <td width="100%" valign=top bgcolor="#CCCCCC">
<form name ="myform" action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post"  <?php
	//��mnu���Ƭ�0�� �� form �� disabled
	if ($grid1->count_row==0 && !($key == $newBtn || $key == $postBtn))  
		echo " disabled "; 
	?> > 
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
<tr>
	
	<td class=title_mbody colspan=6 align=center>
	<?php 
		echo sprintf("%2d �� -- %s (%s)",substr($tea1->Record[curr_class_num],-2),$tea1->Record[stud_name],$tea1->Record[stud_id]);
	?>
	</td>	
</tr>
<tr><td colspan=6 align=center>
<?php
	echo ($ckey == "$editModeBtn" )? "<input type=submit name=\"ckey\" value=\"$browseModeBtn\">": "<input type=submit name=\"ckey\" value=\"$editModeBtn\">";
	echo "&nbsp;&nbsp;<input type=\"submit\" name=\"ckey\" value=\"$newBtn\">";
	if ($ckey==$editModeBtn && $sick_id) 
	echo "&nbsp;&nbsp;<input type=\"submit\" name=\"key\" value=\"$editBtn\" onClick=\"return checkok();\" >";
?>	
</td></tr>
<tr>	<td><?php echo $tea1->Record_cname[s_calling] ?></td>
	<td><?php echo $tea1->Record_cname[sick] ?></td>	
	<td>�ʧ@</td>
</tr>
<?php
	//�s�W�Ҧ�
	if ($ckey==$newBtn||$key == $postBtn){
			echo "<tr>";			
			echo "<td><input name=s_calling size=6 maxlength=6></td>";
			echo "<td>";
			$tea1->get_sick_p($tea1->Record[sick_id],"checkbox",0);
			echo "</td>";
			echo "<td><input type=submit name=key value=\"$postBtn\"></td>";
			echo "</tr>";
	}
?>
<?php	 
	
	for ($i=0;$i<$tea1->num_rows;$i++) {
		$sick_id = $tea1->Record[sick_id];
		$ti = ($i%2)+1;	
		if ($sick_id) {
			echo "<tr class=nom_$ti >";
			if ($ckey==$editModeBtn  && $sick_id) { //�ק�Ҧ�				
				echo "<td><input name=s_calling_$sick_id size=6 maxlength=6 value=\"".$tea1->Record[s_calling]."\"></td>";
				echo "<td>";
				$tea1->chk_str = "fam_$sick_id"; //�[�Jid �ȿ�O�� 
				$tea1->get_sick_p($tea1->Record[sick_id]);
				echo "</td>";
				echo "<td> <a href=\"{$_SERVER['SCRIPT_NAME']}?key=delete&sick_id=$sick_id&ckey=$ckey&$linkstr\" onClick=\"return confirm('�T�w�R�� ".$tea1->Record[s_calling]." �O��?');\">�R��</a></td>";
			}
			else {
				
				echo "<td>".$tea1->Record[s_calling]."</td>";				
				echo "<td>";
				$tea1->get_sick_p($tea1->Record[sick_id],"normal");
				echo "</td>";
				echo "<td> <a href=\"{$_SERVER['SCRIPT_NAME']}?key=delete&sick_id=$sick_id&ckey=$ckey&$linkstr\" onClick=\"return confirm('�T�w�R�� ".$tea1->Record[s_calling]." �O��?');\">�R��</a></td>";				
			}
			echo "</tr>";
		}		
		$tea1->next_record();
	}
	if ($ckey == $editModeBtn && $sick_id) {		
		echo "<tr><td colspan=6 align=center>";
		if ($chknext)
    			echo "<input type=checkbox name=chknext value=1 checked >";			
    		else
    			echo "<input type=checkbox name=chknext value=1 >";
    			
    		echo "�۰ʸ��U�@�� &nbsp;&nbsp;";
		echo "<input type=\"submit\" name=\"key\" value=\"$editBtn\" onClick=\"return checkok();\">";
		echo "</td></tr>";		
	}
?>
</table>
    �@</td>
  </tr>
</table>
<input type=hidden name=stud_id value="<?php echo $stud_id ?>">
<input type=hidden name=sel value="<?php echo $sel ?>">
<input type="hidden" name="curr_seme" value="<?php echo $curr_seme ?>">
<input type=hidden name=nav_next >
</form>
<?php
foot();
?>
