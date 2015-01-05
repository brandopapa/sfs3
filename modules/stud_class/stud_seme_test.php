<?php 

// $Id: stud_seme_test.php 6185 2010-09-21 08:30:06Z brucelyc $

// ���J�]�w��
include "stud_reg_config.php";

// �{���ˬd
sfs_check();

//�ɯ��ˬd 
require "../stud_eduh/module-upgrade.php";

//���o���ЯZ�ťN��
$seme_class = get_teach_class();
if ($seme_class == '') {
	head("�v�����~");
	stud_class_err();
	foot();
	exit;
}

 
$this_year = sprintf("%03d",curr_year());


//�ثe�Ǧ~�Ǵ�
$c_curr_seme = sprintf("%03d%d",curr_year(),curr_seme());

if ($_POST['sel_seme_year_seme'] == '') {
	$sel_seme_year_seme = $c_curr_seme; 
}
else {
	$sel_seme_year_seme = $_POST['sel_seme_year_seme'];
}

$do_key = $_GET[do_key];
if ($do_key == '')
	$do_key = $_POST[do_key];

if ($do_key ==  $newBtn) {
	$seme_year_seme = $_POST[sel_seme_year_seme];
	if ($seme_year_seme =='')
		$seme_year_seme = $this_seme_year_seme;
		
		if ($_POST['all_class']) { //�ƻs����Z
		$query  = "SELECT  a.stud_id  FROM  stud_base a,stud_seme b where a.student_sn=b.student_sn  and (a.stud_study_cond=0 or a.stud_study_cond=5) and  b.seme_year_seme='$c_curr_seme' and b.seme_class='$seme_class'   ";   //SQL �R�O		
		$res= $CONN->Execute($query);
		while($row = $res->fetchrow()) {
				$stud_temp_id= $row['stud_id'];
				$sql_insert = "insert into stud_seme_test (seme_year_seme,stud_id,st_numb,st_name,st_score_numb,st_data_from,st_chang_numb,st_name_long,teacher_sn) values ('$seme_year_seme','$stud_temp_id','$_POST[st_numb]','$_POST[st_name]','$_POST[st_score_numb]','$_POST[st_data_from]','$_POST[st_chang_numb]','$_POST[st_name_long]','$_SESSION[session_tea_sn]')";
				$CONN->Execute($sql_insert) or die($sql_insert);
		}
	}
	else {
		$sql_insert = "insert into stud_seme_test (seme_year_seme,stud_id,st_numb,st_name,st_score_numb,st_data_from,st_chang_numb,st_name_long,teacher_sn) values ('$seme_year_seme','$_POST[stud_id]','$_POST[st_numb]','$_POST[st_name]','$_POST[st_score_numb]','$_POST[st_data_from]','$_POST[st_chang_numb]','$_POST[st_name_long]','$_SESSION[session_tea_sn]')";
		$CONN->Execute($sql_insert) or die($sql_insert);
	}
	$st_numb = ""; 
	$st_name = ""; 
	$st_score_numb = "";
	$st_data_from = "";
	$st_chang_numb = "";
	$st_name_long = "";

	//�^��ثe�Ǧ~
	//$sel_this_year = $this_year;		
}
elseif ($do_key ==$editBtn ) {
	$sql_update = "update stud_seme_test set st_numb='$_POST[st_numb]',st_name='$_POST[st_name]',st_score_numb='$_POST[st_score_numb]',st_data_from='$_POST[st_data_from]',st_chang_numb='$_POST[st_chang_numb]',st_name_long='$_POST[st_name_long]' where st_id=$_POST[st_id]";
	$CONN->Execute($sql_update) or die($sql_update);	
}
elseif ($_POST['act'] == 'delete') {
	$query = "delete  from stud_seme_test where st_id='$_POST[st_id]' and teacher_sn='$_SESSION[session_tea_sn]'";
	$CONN->Execute($query);
}
elseif ($_POST['act'] == 'edit') {
	$sql_select = "select st_id,seme_year_seme,stud_id,st_numb,st_name,st_score_numb,st_data_from,st_chang_numb,st_name_long,teacher_sn from stud_seme_test where st_id='$_POST[st_id]'";

	$recordSet = $CONN->Execute($sql_select) or die ($sql_select);

	while (!$recordSet->EOF) {

		$st_id = $recordSet->fields["st_id"];
		$seme_year_seme = $recordSet->fields["seme_year_seme"];
		$stud_id = $recordSet->fields["stud_id"];
		$st_numb = $recordSet->fields["st_numb"];
		$st_name = $recordSet->fields["st_name"];
		$st_score_numb = $recordSet->fields["st_score_numb"];
		$st_data_from = $recordSet->fields["st_data_from"];
		$st_chang_numb = $recordSet->fields["st_chang_numb"];
		$st_name_long = $recordSet->fields["st_name_long"];
		$teacher_sn = $recordSet->fields["teacher_sn"];

		$recordSet->MoveNext();
	};	
}

	

if ($stud_id=='')
	$stud_id= $_GET[stud_id];
if ($stud_id=='')
	$stud_id= $_POST[stud_id];



// �L�X���Y
head();
// ����T
$field_data = get_field_info("stud_seme_test");
//���s���r��
$linkstr = "stud_id=$stud_id&c_curr_class=$c_curr_class&c_curr_seme=$c_curr_seme";
//�Ҳտ��
print_menu($menu_p,$linkstr);


//�x�s���U�@��
if ($_POST[chknext])
	$stud_id = $_POST[nav_next];	
$query = "select a.stud_id,a.stud_name from stud_base a,stud_seme b where a.student_sn=b.student_sn and a.stud_id='$stud_id' and (a.stud_study_cond=0 or a.stud_study_cond=5)  and  b.seme_year_seme='$c_curr_seme' and b.seme_class='$seme_class'";
$res = $CONN->Execute($query) or die($res->ErrorMsg());
//���]�w�Χ��ܦb¾���p�ΧR���O���� ��Ĥ@��
if ($stud_id =="" || $res->RecordCount()==0) {
	$temp_sql = "select a.stud_id,a.stud_name from stud_base a,stud_seme b where a.student_sn=b.student_sn  and  (a.stud_study_cond=0 or a.stud_study_cond=5) and  b.seme_year_seme='$c_curr_seme' and b.seme_class='$seme_class' order by b.seme_num ";
		$res = $CONN->Execute($temp_sql) or die($temp_sql);
		$stud_id = $res->fields[0];
}
                                                                                                                    
$stud_name = $res->fields[1];



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

<body onload="setfocus(document.myform.st_numb)">

<table BORDER=0 CELLPADDING=0 CELLSPACING=0 CLASS="tableBg" WIDTH="100%" > 
<tr>
<td valign=top align="right">

<?php
	
	$temparr = class_base();   
	$upstr = $temparr[$seme_class]; 
	$grid1 = new ado_grid_menu($_SERVER['SCRIPT_NAME'],$URI,$CONN);  //�إ߿��	   
	$grid1->bgcolor = $gridBgcolor;  // �C��   
	$grid1->row = $gridRow_num ;	     //��ܵ���   
	$grid1->key_item = "stud_id";  // ������W  	
	$grid1->display_item = array("sit_num","stud_name");  // �����W   
	$grid1->display_color = array("1"=>"$gridBoy_color","2"=>"$gridGirl_color"); //�k�k�ͧO
	$grid1->color_index_item ="stud_sex" ; //�C��P�_��
	$grid1->class_ccs = " class=leftmenu";  // �C�����
	$grid1->sql_str = "select a.stud_id,a.stud_name,a.stud_sex,b.seme_num as sit_num from stud_base a,stud_seme b where a.student_sn=b.student_sn  and (a.stud_study_cond=0 or a.stud_study_cond=5) and  b.seme_year_seme='$c_curr_seme' and b.seme_class='$seme_class' order by b.seme_num ";   //SQL �R�O   

	$grid1->do_query(); //����R�O   
	$downstr = "<input type='hidden' name='sel_seme_year_seme' value='{$_POST['sel_seme_year_seme']}'>''";
	$grid1->print_grid($stud_id,$upstr,$downstr); // ��ܵe��   
 

?>
    </td>
    <td width="100%" valign=top bgcolor="#CCCCCC">
    <form name ="myform" action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post"  <?php
	//��mnu���Ƭ�0�� �� form �� disabled
	if ($grid1->count_row==0 && !($key == $newBtn || $key == $postBtn))  
		echo " disabled "; 
	?> onsubmit="checkok()"  > 


<!- ------------------ ��J���}�l ------------------------------ !>
  <table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class="main_body" >
<tr>
<td class=title_mbody colspan=5 align=center  background="images/tablebg.gif" >
<?php 
	echo "<input type=\"hidden\" name=\"stud_id\" value=\"$stud_id\">"; 
	//���\�ק�W�Ǵ����
	if ($old_year_is_edit) {
		$sel = new drop_select();
		$sel->s_name ="sel_seme_year_seme";
		$sel->id = $sel_seme_year_seme;
		$sel->is_submit = true;
		$sel->has_empty = false;
		$sel->arr = get_class_seme();
		$sel->do_select();
		echo sprintf(" --%s (%s)",$stud_name,$stud_id);
	}
	else   	
		echo sprintf("%d�Ǧ~��%d�Ǵ� %s--%s (%s)",substr($c_curr_seme,1,2),substr($c_curr_seme,-1),$class_list_p[$c_curr_seme],$stud_name,$stud_id);

	//�P�_�O�_���ӤH�O��	
	if ($teach_id == $_SESSION[session_tea_sn] || $teach_id=='') {
			
			if ($_POST[chknext])
    			echo "<input type=checkbox name=chknext value=1 checked >";			
    		else
    			echo "<input id='chknext'  type=checkbox name=chknext value=1 >";
    			
    		echo "<label for='chknext'>�۰ʸ��U�@��</label> &nbsp;";
    		
    		    		
    		if ($_POST['act'] == 'edit'){
    			echo "<input type=\"submit\" name=\"do_key\" value=\"$editBtn\"> <input type=\"hidden\" name=\"ss_id\" value=\"$ss_id\">";
    		}
    		else {
    			echo "<input id='all_class' type=checkbox  name='all_class' value=1 >";    			
    			echo "<label for='all_class'>�ƻs����Z</label> &nbsp;";
    			echo"<input type=\"submit\" name=\"do_key\" value=\"$newBtn\">";
    		}
	}
?>
	</td>	
</tr>
<tr>

	<td align="right" CLASS="title_sbody1"><?php echo $field_data[st_numb][d_field_cname] ?></td>
	<td CLASS="gendata"><input type="text" size="20" maxlength="20" name="st_numb" value="<?php echo $st_numb ?>"></td>
</tr>


<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[st_name][d_field_cname] ?></td>
	<td CLASS="gendata"><input type="text" size="20" maxlength="20" name="st_name" value="<?php echo $st_name ?>"></td>
</tr>


<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[st_score_numb][d_field_cname] ?></td>

	<td CLASS="gendata"><input type="text" size="20" maxlength="20" name="st_score_numb" value="<?php echo $st_score_numb ?>"></td>
</tr>


<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[st_data_from][d_field_cname] ?></td>
	<td CLASS="gendata"><input type="text" size="40" maxlength="40" name="st_data_from" value="<?php echo $st_data_from ?>"></td>
</tr>


<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[st_chang_numb][d_field_cname] ?></td>
	<td CLASS="gendata"><input type="text" size="20" maxlength="20" name="st_chang_numb" value="<?php echo $st_chang_numb ?>"></td>

</tr>


<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[st_name_long][d_field_cname] ?></td>
	<td CLASS="gendata"><input type="text" size="40" maxlength="40" name="st_name_long" value="<?php echo $st_name_long ?>"></td>
</tr>

</table>
<input type="hidden" name="stud_id" value="<?php echo $stud_id ?>">
<input type="hidden" name="st_id" value="<?php echo $st_id ?>">
<input type="hidden" name="seme_year_seme" value="<?php echo $sel_seme_year_seme ?>">
<input type="hidden" name="c_curr_seme" value="<?php echo $c_curr_seme ?>">
<input type="hidden" name="act" >
<input type=hidden name=nav_next >
</FORM>
<center><b>�߲z����O��</b></center> 

<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
<tr><td>�Ǵ�</td><td>����s��</td><td>����²��</td><td>���Z�s��</td><td>�ഫ��s��</td><td>���ɪ�</td><td>�ʧ@</td></tr>
<?php

$sql_select = "select st_id,seme_year_seme,stud_id,st_numb,st_name,st_score_numb,st_data_from,st_chang_numb,st_name_long,teacher_sn from stud_seme_test where stud_id='$stud_id' order by seme_year_seme ,st_id desc";
$recordSet = $CONN->Execute($sql_select) or die($sql_select);
while (!$recordSet->EOF) {
	$st_id = $recordSet->fields["st_id"];
	$seme_year_seme = $recordSet->fields["seme_year_seme"];
	$stud_id = $recordSet->fields["stud_id"];
	$st_numb = $recordSet->fields["st_numb"];
	$st_name = $recordSet->fields["st_name"];
	$st_score_numb = $recordSet->fields["st_score_numb"];
	$st_data_from = $recordSet->fields["st_data_from"];
	$st_chang_numb = $recordSet->fields["st_chang_numb"];
	$st_name_long = $recordSet->fields["st_name_long"];
	$teacher_sn = $recordSet->fields["teacher_sn"];
	$name = get_teacher_name($teacher_sn);
	$seme_str = substr($seme_year_seme,0,3)."�Ǧ~��".substr($seme_year_seme,-1)."�Ǵ�";
	if($ii++ % 2 ==0)
		echo "<tr class=\"nom_1\">";
	else
		echo "<tr class=\"nom_2\">";
		
	echo "<td>$seme_str</td><td>$st_numb</td><td>$st_name</td><td>$st_score_numb</td><td>$st_chang_numb</td><td>$name</td><td >&nbsp;";

	if($seme_year_seme == $sel_seme_year_seme) {
	
		if ($teacher_sn == $_SESSION[session_tea_sn]) {
			echo  "<input type=\"button\"  onclick=\"sel_st($st_id)\"  value=\"�˵�/�ק�\" >";
			echo  " <input type=\"button\"  onclick=\"del_st($st_id)\"  value=\"�R��\" >";
			//echo "ey=delete&st_id=$st_id&stud_id=$stud_id\" onClick=\"return confirm('�T�w�R��?');\">�R��</a>";			
		}
		else {
				echo " <a href=\"{$_SERVER['SCRIPT_NAME']}?do_key=edit&st_id=$st_id\"   >�˵�</a> "  ;
		}
			
	}
	echo "</td></tr>";
	
    $recordSet->MoveNext();
};

?>
</table>
</TD>
</TR>
</TABLE>
<?php
//�L�X����
foot();
?>
<script type="text/javascript">
function  sel_st(st) {
	var form = document.myform;
	form.act.value = 'edit';	
	form.st_id.value = st;
	form.submit();
}

function  del_st(st) {
	if (confirm('�T�w�R��?')) {
		var form = document.myform;
		form.act.value = 'delete';	
		form.st_id.value = st;
		form.submit();
	}
}
</script>
