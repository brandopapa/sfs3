<?php

// $Id: stud_seme_spe2.php 6492 2011-08-29 06:42:30Z infodaes $

// ���J�]�w��
include "config.php";
// �{���ˬd
sfs_check();

$this_year = sprintf("%03d",curr_year());
//�ثe�Ǧ~�Ǵ�
$this_seme_year_seme = sprintf("%03d%d",curr_year(),curr_seme());

$sel_seme_year_seme = $_POST[sel_seme_year_seme];
if ($sel_seme_year_seme=='')
	$sel_seme_year_seme = $this_seme_year_seme;

$stud_id = $_GET[stud_id];
if ($stud_id == '')
	$stud_id = $_POST[stud_id];
$c_curr_class=$_GET[c_curr_class];
if($c_curr_class=='')
	$c_curr_class = $_POST[c_curr_class];
$c_curr_seme = $_GET[c_curr_seme];
if($c_curr_seme=='')
	$c_curr_seme = $_POST[c_curr_seme];

$do_key = $_GET[do_key];
if ($do_key == '')
	$do_key = $_POST[do_key];
	
	
//�g�J�e�w���i�� < > ' " &�r������  �קKHTML�S��r���y����ܩ�sxw������~
$char_replace=array("<"=>"��",">"=>"��","'"=>"��","\""=>"��","&"=>"��");
foreach($char_replace as $key=>$value){
	$_POST[sp_memo]=str_replace($key,$value,$_POST[sp_memo]);
}	

switch($do_key) {
	case $newBtn:
	$seme_year_seme = $_POST[sel_seme_year_seme];
	if ($seme_year_seme =='')
		$seme_year_seme = $this_seme_year_seme;
	$sql_insert = "insert into stud_seme_spe (seme_year_seme,stud_id,sp_date,sp_memo,teach_id) values ('$seme_year_seme','$_POST[stud_id]','$_POST[sp_date]','$_POST[sp_memo]','{$_SESSION['session_tea_sn']}')";
	$CONN->Execute($sql_insert) or die($sql_insert);
	$sp_date = '';
	$sp_memo= '';
	
	//�^��ثe�Ǧ~
	$sel_this_year = $this_year;		
	break;

	//�R��
	case "delete":
	$query = "delete  from stud_seme_spe where ss_id='$_GET[ss_id]' and teach_id='$_SESSION[session_tea_sn]'";
	$CONN->Execute($query);
	break;
	
	// �˵�/�ק�
	case "edit" :
	$sql_select = "select ss_id,seme_year_seme,stud_id,teach_id,sp_date,sp_memo,teach_id,update_time from stud_seme_spe where ss_id='$_GET[ss_id]'";
	$recordSet = $CONN->Execute($sql_select) or die($sql_select);
	while (!$recordSet->EOF) {

	    $ss_id = $recordSet->fields["ss_id"];
	    $seme_year_seme = $recordSet->fields["seme_year_seme"];
	    $stud_id = $recordSet->fields["stud_id"];
	    $sp_date = $recordSet->fields["sp_date"];
	    $sp_memo = $recordSet->fields["sp_memo"];
	    $teach_id = $recordSet->fields["teach_id"];


	    $recordSet->MoveNext();
	};

	break;

	//�T�w�ק�
	case $editBtn:
	$sql_update = "update stud_seme_spe set sp_date='$_POST[sp_date]',sp_memo='$_POST[sp_memo]',teach_id='{$_SESSION['session_tea_sn']}' where ss_id='$_POST[ss_id]'";
	$CONN->Execute($sql_update) or die($sql_update);
	break;

}


//�L�X���Y
head();

if ($stud_id=='')
	$stud_id= $_GET[stud_id];
if ($stud_id=='')
	$stud_id= $_POST[stud_id];

//����T
$field_data = get_field_info("stud_seme_spe");
///���s���r��
$linkstr = "stud_id=$stud_id&c_curr_class=$c_curr_class&c_curr_seme=$c_curr_seme";

//�Ҳտ��
print_menu($menu_p,$linkstr);

//���Z��
if ($c_curr_class=="")
	// �Q�� $IS_JHORES �� �Ϲj �ꤤ�B��p�B���� ���w�]��
	$c_curr_class = sprintf("%03s_%s_%02s_%02s",curr_year(),curr_seme(),$default_begin_class + round($IS_JHORES/2),1);
else {
	$temp_curr_class_arr = explode("_",$c_curr_class); //091_1_02_03
	$c_curr_class = sprintf("%03s_%s_%02s_%02s",substr($c_curr_seme,0,3),substr($c_curr_seme,-1),$temp_curr_class_arr[2],$temp_curr_class_arr[3]);
}
	
if($c_curr_seme =='')
	$c_curr_seme = sprintf ("%03s%s",curr_year(),curr_seme()); //�{�b�Ǧ~�Ǵ�

//���Ǵ�
if ($c_curr_seme != "")
	$curr_seme = $c_curr_seme;
	$c_curr_class_arr = explode("_",$c_curr_class);
	$seme_class = intval($c_curr_class_arr[2]).$c_curr_class_arr[3];
if($c_curr_seme =='')
	$c_curr_seme = sprintf ("%03s%s",curr_year(),curr_seme()); //�{�b�Ǧ~�Ǵ�

$c_curr_class_arr = explode("_",$c_curr_class);
$seme_class = intval($c_curr_class_arr[2]).$c_curr_class_arr[3];


//�x�s���U�@��
if ($_POST[chknext])
	$stud_id = $_POST[nav_next];	
$query = "select a.stud_id,a.stud_name from stud_base a,stud_seme b where a.student_sn=b.student_sn and a.stud_id='$stud_id' and (a.stud_study_cond=0 or a.stud_study_cond=5) and b.seme_year_seme='$c_curr_seme' and b.seme_class='$seme_class'";
$res = $CONN->Execute($query) or die($res->ErrorMsg());
//���]�w�Χ��ܦb¾���p�ΧR���O���� ��Ĥ@��
if ($stud_id =="" || $res->RecordCount()==0) {
	$temp_sql = "select a.stud_id,a.stud_name from stud_base a,stud_seme b where a.student_sn=b.student_sn and (a.stud_study_cond=0 or a.stud_study_cond=5) and b.seme_year_seme='$c_curr_seme' and b.seme_class='$seme_class' order by b.seme_num";
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
<body onload="setfocus(document.myform.sp_memo)">
<table border="0" width="100%" cellspacing="0" cellpadding="0" CLASS="tableBg" >
<tr>
<td valign=top align="right">

<?php
	//�إߥ�����   
	$class_seme_p = get_class_seme(); //�Ǧ~��	
	$upstr = "<select name=\"c_curr_seme\" onchange=\"this.form.submit()\">\n";
	while (list($tid,$tname)=each($class_seme_p)){
		if ($curr_seme== $tid)
      			$upstr .= "<option value=\"$tid\" selected>$tname</option>\n";
      		else
      			$upstr .= "<option value=\"$tid\">$tname</option>\n";
	}
	$upstr .= "</select><br>"; 
	
	$s_y = substr($c_curr_seme,0,3);
	$s_s = substr($c_curr_seme,-1);

	$tmp=&get_class_select($s_y,$s_s,"","c_curr_class","this.form.submit",$c_curr_class);
	$upstr .= $tmp;

	$temparr = class_base();   
	$grid1 = new ado_grid_menu($_SERVER['PHP_SELF'],$URI,$CONN);  //�إ߿��	   
	$grid1->bgcolor = $gridBgcolor;  // �C��   
	$grid1->row = $gridRow_num ;	     //��ܵ���   
	$grid1->key_item = "stud_id";  // ������W  	
	$grid1->display_item = array("sit_num","stud_name");  // �����W   
	$grid1->display_color = array("1"=>"$gridBoy_color","2"=>"$gridGirl_color"); //�k�k�ͧO
	$grid1->color_index_item ="stud_sex" ; //�C��P�_��
	$grid1->class_ccs = " class=leftmenu";  // �C�����
	$grid1->sql_str = "select a.stud_id,a.stud_name,a.stud_sex,b.seme_num as sit_num from stud_base a,stud_seme b where a.student_sn=b.student_sn and (a.stud_study_cond=0 or a.stud_study_cond=5) and  b.seme_year_seme='$c_curr_seme' and b.seme_class='$seme_class' order by b.seme_num";   //SQL �R�O   

	$grid1->do_query(); //����R�O   
	
	$downstr = "<input type=\"hidden\" name=\"sel_seme_year_seme\" value=\"$_POST[sel_seme_year_seme]\">";
	$grid1->print_grid($stud_id,$upstr,$downstr); // ��ܵe��   
  

?>
     </td>
     
    <td width="100%" valign=top bgcolor="#CCCCCC">
<form name ="myform" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="checkok()" <?php
	//��mnu���Ƭ�0�� �� form �� disabled
	if ($grid1->count_row==0 && !($do_key == $newBtn || $do_key == $postBtn))  
		echo " disabled ";

	?> > 
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
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
    			echo "<input type=checkbox name=chknext value=1 >";
    			
    		echo "�۰ʸ��U�@�� &nbsp;";
				echo ($do_key == 'edit')?"<input type=\"submit\" name=\"do_key\" value=\"$editBtn\"> <input type=\"hidden\" name=\"ss_id\" value=\"$ss_id\">":"<input type=\"submit\" name=\"do_key\" value=\"$newBtn\">";
	}
?>
	</td>	
</tr>

<tr>
    <td align="right" CLASS="title_sbody1"><?php echo $field_data[sp_date][d_field_cname] ?></td>

    <?php if ($sp_date=='') $sp_date = date("Y-m-d"); ?>
    <td CLASS="gendata"><input type="text" size="10" maxlength="10" name="sp_date" value="<?php echo $sp_date ?>"></td>
</tr>


<tr>
    <td align="right" CLASS="title_sbody1"><?php echo $field_data[sp_memo][d_field_cname] ?></td>
    <td><textarea name="sp_memo" cols=40 rows=5 wrap=virtual><?php echo $sp_memo ?></textarea></td>
</tr>

</table>
<input type="hidden" name=nav_next>
<input type="hidden" name=c_curr_seme value='<?php echo $c_curr_seme ?>'>
<input type="hidden" name=c_curr_class value='<?php echo $c_curr_class ?>'>

<br>��� 
<?php
	$sel_this_year = $_POST[sel_this_year]; 
	if ($sel_this_year == '')
		$sel_this_year = $this_year;
	$sel = new drop_select();
	$sel->arr =  get_class_year(1,0,'d');
	$sel->s_name = "sel_this_year";
	$sel->id = $sel_this_year;
	$sel->has_empty=false;
	$sel->is_submit = true;
	$sel->do_select();
	echo " <b>$stud_name</b> ";
?> �u�}��{ 


</FORM>
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
<tr><td>�Ǵ�</td><td>�O�����</td><td>�u�}��{�ƥ�</td><td>���ɪ�</td><td>�ʧ@</td></tr>
<?php
$sql_select = "select a.ss_id,a.seme_year_seme,a.stud_id,a.sp_date,a.teach_id,a.sp_memo from stud_seme_spe a where a.stud_id='$stud_id' and a.seme_year_seme like '$sel_this_year%' order by a.seme_year_seme desc ,a.ss_id desc  ";
$recordSet = $CONN->Execute($sql_select);
while (!$recordSet->EOF) {

    $ss_id = $recordSet->fields["ss_id"];
    $seme_year_seme = $recordSet->fields["seme_year_seme"];
    $stud_id = $recordSet->fields["stud_id"];
    $sp_date = $recordSet->fields["sp_date"];
    $sp_memo = $recordSet->fields["sp_memo"];
    $teach_id = $recordSet->fields["teach_id"];
    $name = get_teacher_name($teach_id);
    $seme_str = substr($seme_year_seme,0,3)."�Ǧ~��".substr($seme_year_seme,-1)."�Ǵ�";
	if($ii++ % 2 ==0)
		echo "<tr class=\"nom_1\">";
	else
		echo "<tr class=\"nom_2\">";
		
	echo "<td>$seme_str</td><td>$sp_date</td><td>$sp_memo</td><td>$name</td><td >&nbsp;";
	if($sel_this_year == $this_year || $old_year_is_edit) {
		echo " <a href=\"{$_SERVER['PHP_SELF']}?do_key=edit&ss_id=$ss_id\"";
		if ($teach_id == $_SESSION[session_tea_sn])
			echo ">�˵� / �ק�</a>&nbsp;|&nbsp;<a href=\"{$_SERVER['PHP_SELF']}?do_key=delete&ss_id=$ss_id&stud_id=$stud_id\" onClick=\"return confirm('�T�w�R��?');\">�R��</a>";
		else
			echo ">�˵�</a> ";
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
