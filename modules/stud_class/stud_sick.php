<?php 

// $Id: stud_sick.php 6055 2010-08-31 02:08:48Z brucelyc $

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
$tea1 = new stud_sick_p_class();

//����B�z 
switch ($key){	
	case $editBtn: //�ק�
	$tea1->edit("stud_id",$stud_id);
	break;	
}

//----------------------------------------

//�x�s���U�@��
if ($chknext)
	$stud_id = $nav_next;	
		
$tea1->query("select stud_sick_p.* ,stud_base.stud_id,stud_base.stud_name,stud_base.curr_class_num from stud_base left join  stud_sick_p on stud_sick_p.stud_id=stud_base.stud_id where stud_base.stud_id='$stud_id' and stud_base.curr_class_num like '$class_num%'"); 
//���]�w�Χ��ܦb¾���p�ΧR���O���� ��Ĥ@��
if ($stud_id =="" || $stud_id != $tea1->Record[stud_id]) {
	$result= mysql_query("select stud_base.stud_id from stud_base where  stud_base.curr_class_num like '$class_num%' order by curr_class_num limit 0,1");
	$row = mysql_fetch_row($result);	
	$tea1->query("select stud_sick_p.* ,stud_base.stud_id,stud_base.stud_name,stud_base.curr_class_num from stud_base left join stud_sick_p on stud_sick_p.stud_id=stud_base.stud_id where stud_base.stud_id='$row[0]' and  stud_base.curr_class_num like '$class_num%' "); 	
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
	$grid1->sql_str = "select stud_id,stud_name,stud_sex,substring(curr_class_num,4,2)as sit_num from stud_base where   curr_class_num like '$class_num%' and stud_study_cond=0 order by curr_class_num";   //SQL �R�O 
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
	
	<td class=title_mbody align=center colspan=2>
	<?php 
		echo sprintf("%2d �� -- %s (%s)",substr($tea1->Record[curr_class_num],-2),$tea1->Record[stud_name],$tea1->Record[stud_id]);
	?>
	</td>	
</tr>

<tr>
<td class=title_sbody1 nowrap >���j�e�f</td>
<td>
<?php echo $tea1->get_sick_p($stud_id,$mode="checkbox") ; ?>
</td>
</tr>

<?php	
	echo "<tr><td colspan=2 align=center>";
	if ($chknext)
    		echo "<input type=checkbox name=chknext value=1 checked >";			
    	else
    		echo "<input type=checkbox name=chknext value=1 >";
    			
    	echo "�۰ʸ��U�@�� &nbsp;&nbsp;";
	echo "<input type=\"submit\" name=\"key\" value=\"$editBtn\" onClick=\"return checkok();\">";
	echo "</td></tr>";		
	
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
