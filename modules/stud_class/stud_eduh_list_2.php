<?php 

// $Id: stud_eduh_list.php 6460 2011-06-13 02:43:57Z infodaes $

// ���J�]�w��
include "stud_reg_config.php";
include_once "../../include/sfs_case_subjectscore.php";
// �{���ˬd
sfs_check();

//�L�X���Y
head();

//����T
$field_data = get_field_info("stud_seme_eduh");
//���s���r��
$linkstr = "stud_id=$stud_id&c_curr_class=$c_curr_class&c_curr_seme=$c_curr_seme";
//�Ҳտ��
print_menu($menu_p,$linkstr);

//�Юv�N��
$teacher_sn = $_SESSION[session_tea_sn];
//���o���Ǵ��Z�Ű}�C
$class_name_arr = class_base();

$class_num=$_POST['class_num'];

$counter=0;  
//���o���ЯZ�ťN��
$my_class_id = get_teach_class();
$class_name=$class_name_arr[$my_class_id];
$class_list=$my_class_id?"<option value='$my_class_id' selected>$class_name(�ɮv)</option>":"";
if($class_list) { $class_num=$class_num?$class_num:$my_class_id; $counter++; }

//���o���ɽҥ��ЯZ��
$teach_subject=$teach_subject?$teach_subject:'����,���ɬ���,��X����';
$teach_subject=' ,'.$teach_subject.',';
$sel_year=curr_year();
$sel_seme=curr_seme();
$sql="SELECT * FROM score_course WHERE year=$sel_year AND semester=$sel_seme AND teacher_sn=$teacher_sn ORDER BY class_id";
$rs=$CONN->Execute($sql) or trigger_error($sql,E_USER_ERROR);
while (!$rs->EOF) {
	$ss_id= $rs->fields["ss_id"];
	if($ss_id) {
		$course_id[$i] = $rs->fields["course_id"];
		$class_year = $rs->fields["class_year"];
		$class_name = $rs->fields["class_name"];
		$class_id = sprintf('%d%02d',$class_year,$class_name);
		$class_name=$class_name_arr[$class_id];
		$subject_name=ss_id_to_subject_name($ss_id);
		if($my_class_id<>$class_id)
		if(strpos($teach_subject,','.$subject_name.',')){
			$subject_name=$class_name.'('.$subject_name.')';
			$selected=($class_id==$class_num)?'selected':'';
			$class_list.="<option value='$class_id' $selected>$subject_name</option>";
			$counter++;
		}
	}
	$rs->MoveNext();
}

if(!$counter) {
	head("�v�����~");
	$teach_subject=substr($teach_subject,2,-1);
	echo "<center><h3>�����@�~���ť��ɮv��[{$teach_subject}]���ұЮv�v��</h3></center>";
	foot();
	exit;
} else $class_list="<select name='class_num' onchange=\"this.form.submit()\"><option>�п�Z��</option>$class_list</select>";


$stud_id = $_GET[stud_id];
if ($stud_id == '')
	$stud_id = $_POST[stud_id];

switch($_POST[do_key]) {
	case $editBtn:
        	for ($i=1;$i<=11;$i++) {
				$data_arr=array();
        		$sse= "sse_s".$i;
        		//����
				$data_arr=explode(',',$_POST[$sse]);
				sort($data_arr);
				$sse_data='';
				foreach($data_arr as $key=>$value){
					if($value) $sse_data.="$value,";				
				}
				$_POST[$sse]=",$sse_data";
				
				//if (substr($_POST[$sse],0,1) !=',') $_POST[$sse]=','.$_POST[$sse];
				//if (substr($_POST[$sse],-1) !=',') $_POST[$sse].=',';
        	}
			$sql_insert = "replace into stud_seme_eduh (seme_year_seme,stud_id,sse_relation,sse_family_kind,sse_family_air,sse_farther,sse_mother,sse_live_state,sse_rich_state,sse_s1,sse_s2,sse_s3,sse_s4,sse_s5,sse_s6,sse_s7,sse_s8,sse_s9,sse_s10,sse_s11) values ('$_POST[sel_seme_year_seme]','$stud_id','$_POST[sse_relation]','$_POST[sse_family_kind]','$_POST[sse_family_air]','$_POST[sse_farther]','$_POST[sse_mother]','$_POST[sse_live_state]','$_POST[sse_rich_state]','$_POST[sse_s1]','$_POST[sse_s2]','$_POST[sse_s3]','$_POST[sse_s4]','$_POST[sse_s5]','$_POST[sse_s6]','$_POST[sse_s7]','$_POST[sse_s8]','$_POST[sse_s9]','$_POST[sse_s10]','$_POST[sse_s11]')";
        	$CONN->Execute($sql_insert) or die ($sql_insert);
        	break;

        case "�ߧY�ƻs"://�W�[<�ߧY�ƻs> by misser
       		$sse_s1=$_POST[old_sse_s1];
       		$sse_s2=$_POST[old_sse_s2];
       		$sse_s3=$_POST[old_sse_s3];
       		$sse_s4=$_POST[old_sse_s4];
       		$sse_s5=$_POST[old_sse_s5];
       		$sse_s6=$_POST[old_sse_s6];
       		$sse_s7=$_POST[old_sse_s7];
       		$sse_s8=$_POST[old_sse_s8];
       		$sse_s9=$_POST[old_sse_s9];
       		$sse_s10=$_POST[old_sse_s10];
       		$sse_s11=$_POST[old_sse_s11];
        	$sql_insert = "replace into stud_seme_eduh (seme_year_seme,stud_id,sse_relation,sse_family_kind,sse_family_air,sse_farther,sse_mother,sse_live_state,sse_rich_state,sse_s1,sse_s2,sse_s3,sse_s4,sse_s5,sse_s6,sse_s7,sse_s8,sse_s9,sse_s10,sse_s11) values ('$_POST[new_seme_year_seme]','$stud_id','$_POST[old_sse_relation]','$_POST[old_sse_family_kind]','$_POST[old_sse_family_air]','$_POST[old_sse_farther]','$_POST[old_sse_mother]','$_POST[old_sse_live_state]','$_POST[old_sse_rich_state]','$sse_s1','$sse_s2','$sse_s3','$sse_s4','$sse_s5','$sse_s6','$sse_s7','$sse_s8','$sse_s9','$sse_s10','$sse_s11')";
        	$CONN->Execute($sql_insert) or die ($sql_insert);
        	break;

	break;
}

//�ثe�Ǧ~�Ǵ�
$this_seme_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
$sel_seme_year_seme = $_POST[sel_seme_year_seme];
if ($sel_seme_year_seme=='')
	$sel_seme_year_seme = $this_seme_year_seme;


$c_curr_seme = sprintf ("%03d%d",curr_year(),curr_seme()); //�{�b�Ǧ~�Ǵ�
if ($_POST[chknext])
	$stud_id = $_POST[nav_next];
	$query = "select a.stud_id,a.stud_name,a.student_sn from stud_base a,stud_seme b where a.student_sn=b.student_sn and a.stud_id='$stud_id' and a.stud_study_cond=0 and b.seme_year_seme='$c_curr_seme' and b.seme_class='$class_num'";	
	$res = $CONN->Execute($query) or die($res->ErrorMsg());
	//���]�w�Χ��ܦb¾���p�ΧR���O���� ��Ĥ@��
	if ($stud_id =="" || $res->RecordCount()==0) {	
		$temp_sql = "select a.stud_id,a.stud_name,a.student_sn from stud_base a,stud_seme b where a.student_sn=b.student_sn and a.stud_study_cond=0 and b.seme_year_seme='$c_curr_seme' and b.seme_class='$class_num' order by b.seme_num";
		$res2 = $CONN->Execute($temp_sql) or die($temp_sql);
		$stud_id = $res2->fields[0];
	}

$stud_name = $res->fields[1];
$student_sn = $res->fields[2]; //by smallduh 2012/10/05
	

$sql_select = "select seme_year_seme,stud_id,sse_relation,sse_family_kind,sse_family_air,sse_farther,sse_mother,sse_live_state,sse_rich_state,sse_s1,sse_s2,sse_s3,sse_s4,sse_s5,sse_s6,sse_s7,sse_s8,sse_s9,sse_s10,sse_s11 from stud_seme_eduh where stud_id='$stud_id' and seme_year_seme='$sel_seme_year_seme'";
$recordSet = $CONN->Execute($sql_select) or die ($sql_select);

if (!$recordSet->EOF) {

	$seme_year_seme = $recordSet->fields["seme_year_seme"];
	$stud_id = $recordSet->fields["stud_id"];
	$sse_relation = $recordSet->fields["sse_relation"];
	$sse_family_kind = $recordSet->fields["sse_family_kind"];
	$sse_family_air = $recordSet->fields["sse_family_air"];
	$sse_farther = $recordSet->fields["sse_farther"];
	$sse_mother = $recordSet->fields["sse_mother"];
	$sse_live_state = $recordSet->fields["sse_live_state"];
	$sse_rich_state = $recordSet->fields["sse_rich_state"];
	$sse_s1 = $recordSet->fields["sse_s1"];
	$sse_s2 = $recordSet->fields["sse_s2"];
	$sse_s3 = $recordSet->fields["sse_s3"];
	$sse_s4 = $recordSet->fields["sse_s4"];
	$sse_s5 = $recordSet->fields["sse_s5"];
	$sse_s6 = $recordSet->fields["sse_s6"];
	$sse_s7 = $recordSet->fields["sse_s7"];
	$sse_s8 = $recordSet->fields["sse_s8"];
	$sse_s9 = $recordSet->fields["sse_s9"];
	$sse_s10 = $recordSet->fields["sse_s10"];
	$sse_s11 = $recordSet->fields["sse_s11"];

}
else {

	unset($sse_relation);
	unset($sse_family_kind);
	unset($sse_family_air);
	unset($sse_farther);
	unset($sse_mother);
	unset($sse_live_state);
	unset($sse_rich_state);
	unset($sse_s1);
	unset($sse_s2);
	unset($sse_s3);
	unset($sse_s4);
	unset($sse_s5);
	unset($sse_s6);
	unset($sse_s7);
	unset($sse_s8);
	unset($sse_s9);
	unset($sse_s10);
	unset($sse_s11);

}

		

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

function add_value(objname,objvalue) {
  var i =0;
  while (i<document.myform.elements.length)  {
    if(document.myform.elements[i].name==objname) {
		var s=document.myform.elements[i].value;
		var j=s.indexOf(','+objvalue+',');
		if(j<0) {
			if(document.myform.elements[i].value=="") document.myform.elements[i].value+=",";
			document.myform.elements[i].value+=objvalue+',';
			document.myform.elements[i].style.background='#FFCCCC';
		} else {
			document.myform.elements[i].value=s.replace(','+objvalue+',',',');			
		}
    }
    i++;
  }
}

function check_data(completeness) {
  var i =0; ok=true;
  if(! completeness){ 
  while (i<document.myform.elements.length)  {
	if(document.myform.elements[i].type=='text'){
		var s=document.myform.elements[i].value;
		s=s.replace(",","");
		s=s.replace("0","");
		if(s==""){
			document.myform.elements[i].style.background='#FF0000';
			ok=false;
		}
	}
	i++;
  }
  }
  if(ok) document.myform.nav_next.value = document.gridform.nav_next.value; else alert('�Ҳ��ܼƳ]�w�z���N��ƶ������A\n\r\n\r ���⩳�ⶵ�ثY���ͩ|����J�����A���ˬd�I');
  return ok;
}

//-->

</script>
 
<table BORDER=0 CELLPADDING=0 CELLSPACING=0 CLASS="tableBg" WIDTH="100%" > 
<tr>
<td valign=top align="right">
<?php
//�إߥ�����   
	//$temparr = class_base();   
	$upstr = $class_list; 	
	$grid1 = new ado_grid_menu($_SERVER['SCRIPT_NAME'],$URI,$CONN);  //�إ߿��	   
	$grid1->bgcolor = $gridBgcolor;  // �C��   
	$grid1->row = $gridRow_num ;	     //��ܵ���   
	$grid1->key_item = "stud_id";  // ������W  	
	$grid1->display_item = array("sit_num","stud_name");  // �����W   
	$grid1->display_color = array("1"=>"$gridBoy_color","2"=>"$gridGirl_color"); //�k�k�ͧO
	$grid1->color_index_item ="stud_sex" ; //�C��P�_��
	$grid1->class_ccs = " class=leftmenu";  // �C�����

	$grid1->sql_str = "select a.stud_id,a.stud_name,a.stud_sex,b.seme_num as sit_num from stud_base a,stud_seme b where a.student_sn=b.student_sn and a.stud_study_cond=0 and b.seme_year_seme='$c_curr_seme' and b.seme_class='$class_num' order by b.seme_num";   //SQL �R�O   
	$grid1->down_str = "<input type=\"hidden\" name=\"sel_seme_year_seme\" value=\"$_POST[sel_seme_year_seme]\">";
	$grid1->do_query(); //����R�O   
	$downstr = "<br><font size=2><a href=\"stud_eduh_class.php\" target=\"showclass\">��ܥ��Ǵ��O��</a></font>";
	$grid1->print_grid($stud_id,$upstr,$downstr); // ��ܵe��   
?>
    </td>
    <td width="100%" valign=top bgcolor="#CCCCCC">
    <form name ="myform" action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post"  <?php
	//��mnu���Ƭ�0�� �� form �� disabled
	if ($grid1->count_row==0 && !($key == $newBtn || $key == $postBtn))  
		echo " disabled "; 
	?> > 


<! -- ��J���}�l --!>

<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class="main_body" >
<tr>
<td class=title_mbody colspan=5 align=center background="images/tablebg.gif" >
	<?php
		$sel = new drop_select();
		$sel->s_name ="sel_seme_year_seme";
		$sel->id = $sel_seme_year_seme;
		$sel->is_submit = true;
		$sel->has_empty = false;
		$sel->arr = get_class_seme();
		$sel->do_select();
		// by smallduh 2012/10/05
		//echo sprintf(" --%s (%s) <a href=\"stud_eduh_detail.php?stud_id=%s\" target=_blank>���%s �O��</a>",$stud_name,$stud_id,$stud_id,$stud_name);
    echo sprintf(" --%s (%s) <a href=\"stud_eduh_detail.php?student_sn=%s\" target=_blank>���%s �O��</a>",$stud_name,$stud_id,$student_sn,$stud_name);
		if ($sel_seme_year_seme == $this_seme_year_seme || $old_year_is_edit)
		    	echo "&nbsp;&nbsp;<input type=submit name=do_key value =\"$editBtn\" onClick=\"return check_data($completeness);\">&nbsp;&nbsp;";
    		if ($_POST[chknext])
    			echo "<input type=checkbox name=chknext value=1 checked >";			
    		else
    			echo "<input type=checkbox name=chknext value=1 >";
    			
    		echo "�۰ʸ��U�@��";
    
    ?>
	</td>	
</tr>
<?php
     //�ˬd�O�_�i�H�ƻs�W�Ǵ����--2004/1/22 by misser
     echo check_old_data($seme_year_seme,$sel_seme_year_seme,$stud_id);
?>
<tr>
	<td colspan=2>
	<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sse_relation][d_field_cname] ?></td>
	<td CLASS="gendata">
	
	<?php 
	//�C��}�C
	$color_array=array('0'=>'#ffffff','1'=>'#ffcc8c','2'=>'#00ffcc','3'=>'#ffffcc','4'=>'#c99cff','5'=>'#ffccff','6'=>'#ccffaa','7'=>'#aa8f8f','8'=>'#ff88aa','9'=>'#88ff55','10'=>'#88aa5f');

	//�]�w�C�C�ﶵ��
	$cols=5;
	$sizes=30;
	
	$sel = new drop_select();
	$chk->s_name = "sse_relation";
	$chk->arr = sfs_text("�������Y");
	$chk->id = $sse_relation;
	$count=0;
	$data_list="<input type='button' style='border-width:1px; cursor:hand; color:white; background:#ff5555; font-size:9pt;' value='�����O' onclick=\"this.form.{$chk->s_name}.value='-'; this.form.{$chk->s_name}.style.background='#000000';\">";
	foreach($chk->arr as $key=>$value){
		$count++;
		$click_color=$color_array[$key];
		if($chk->id==$key) $bg_color='background:#AAFFFF;'; else $bg_color='background:#CCCCCC;';
		$data_list.="<input type='button' style='border-width:1px; cursor:hand; $bg_color font-size:9pt;' value='$key.$value' onclick=\"this.form.{$chk->s_name}.value=$key; this.form.{$chk->s_name}.style.background='$click_color'; this.style.background='$click_color';\">";
		if($count % $cols ==0)	$data_list.="<br>";
	}
	echo $data_list;
	echo "</td><td><input type='text' size=2 name='{$chk->s_name}' value='$sse_relation'></td>";
	
	?>
	</td></tr><tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sse_family_kind][d_field_cname] ?></td>
	<td CLASS="gendata">

	<?php 
	$chk->s_name = "sse_family_kind";
	$chk->arr = sfs_text("�a�x����");
	$chk->id = $sse_family_kind;
	$count=0;
	$data_list="<input type='button' style='border-width:1px; cursor:hand; color:white; background:#ff5555; font-size:9pt;' value='�����O' onclick=\"this.form.{$chk->s_name}.value='-'; this.form.{$chk->s_name}.style.background='#000000';\">";
	foreach($chk->arr as $key=>$value){
		$count++;
		$click_color=$color_array[$key];
		if($chk->id==$key) $bg_color='background:#AAFFFF;'; else $bg_color='background:#CCCCCC;';
		$data_list.="<input type='button' style='border-width:1px; cursor:hand; $bg_color font-size:9pt;' value='$key.$value' onclick=\"this.form.{$chk->s_name}.value=$key; this.form.{$chk->s_name}.style.background='$click_color'; this.style.background='$click_color';\">";
		if($count % $cols ==0)	$data_list.="<br>";
	}
	echo $data_list;
	echo "<td><input type='text' size=2 name='{$chk->s_name}' value='$sse_family_kind'></td>";
	
	?>
	</td></tr><tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sse_family_air][d_field_cname] ?></td>
	<td CLASS="gendata">
	<?php 
	$chk->s_name = "sse_family_air";
	$chk->arr = sfs_text("�a�x��^");
	$chk->id = $sse_family_air;
	$count=0;
	$data_list="<input type='button' style='border-width:1px; cursor:hand; color:white; background:#ff5555; font-size:9pt;' value='�����O' onclick=\"this.form.{$chk->s_name}.value='-'; this.form.{$chk->s_name}.style.background='#000000';\">";
	foreach($chk->arr as $key=>$value){
		$count++;
		$click_color=$color_array[$key];
		if($chk->id==$key) $bg_color='background:#AAFFFF;'; else $bg_color='background:#CCCCCC;';
		$data_list.="<input type='button' style='border-width:1px; cursor:hand; $bg_color font-size:9pt;' value='$key.$value' onclick=\"this.form.{$chk->s_name}.value=$key; this.form.{$chk->s_name}.style.background='$click_color'; this.style.background='$click_color';\">";
		if($count % $cols ==0)	$data_list.="<br>";
	}
	echo $data_list;
	echo "<td><input type='text' size=2 name='{$chk->s_name}' value='$sse_family_air'></td>";
	
	?>

	</td>
	</tr>
	</td>
</tr>
<tr>
	<td colspan=2>

	<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sse_farther][d_field_cname] ?></td>
	<td CLASS="gendata">
	<?php 
	$chk->s_name = "sse_farther";
	$chk->arr = sfs_text("�ޱФ覡");
	$chk->id = $sse_farther;
	$count=0;
	$data_list="<input type='button' style='border-width:1px; cursor:hand; color:white; background:#ff5555; font-size:9pt;' value='�����O' onclick=\"this.form.{$chk->s_name}.value='-'; this.form.{$chk->s_name}.style.background='#000000';\">";
	foreach($chk->arr as $key=>$value){
		$count++;
		$click_color=$color_array[$key];
		if($chk->id==$key) $bg_color='background:#AAFFFF;'; else $bg_color='background:#CCCCCC;';
		$data_list.="<input type='button' style='border-width:1px; cursor:hand; $bg_color font-size:9pt;' value='$key.$value' onclick=\"this.form.{$chk->s_name}.value=$key; this.form.{$chk->s_name}.style.background='$click_color'; this.style.background='$click_color';\">";
		if($count % $cols ==0)	$data_list.="<br>";
	}
	echo $data_list;
	echo "<td><input type='text' size=2 name='{$chk->s_name}' value='$sse_farther'></td>";
	
	?>

	</td></tr><tr>

	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sse_mother][d_field_cname] ?></td>
	<td CLASS="gendata">
	<?php 
	$chk->s_name = "sse_mother";
	$chk->arr = sfs_text("�ޱФ覡");
	$chk->id = $sse_mother;
	$count=0;
	$data_list="<input type='button' style='border-width:1px; cursor:hand; color:white; background:#ff5555; font-size:9pt;' value='�����O' onclick=\"this.form.{$chk->s_name}.value='-'; this.form.{$chk->s_name}.style.background='#000000';\">";
	foreach($chk->arr as $key=>$value){
		$count++;
		$click_color=$color_array[$key];
		if($chk->id==$key) $bg_color='background:#AAFFFF;'; else $bg_color='background:#CCCCCC;';
		$data_list.="<input type='button' style='border-width:1px; cursor:hand; $bg_color font-size:9pt;' value='$key.$value' onclick=\"this.form.{$chk->s_name}.value=$key; this.form.{$chk->s_name}.style.background='$click_color'; this.style.background='$click_color';\">";
		if($count % $cols ==0)	$data_list.="<br>";
	}
	echo $data_list;
	echo "<td><input type='text' size=2 name='{$chk->s_name}' value='$sse_mother'></td>";
	
	?>

	</td></tr><tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sse_live_state][d_field_cname] ?></td>
	<td CLASS="gendata">
	<?php 
	$chk->s_name="sse_live_state";
	$chk->id = $sse_live_state;
	$chk->arr = sfs_text("�~����");

	$count=0;
	$data_list="<input type='button' style='border-width:1px; cursor:hand; color:white; background:#ff5555; font-size:9pt;' value='�����O' onclick=\"this.form.{$chk->s_name}.value='-'; this.form.{$chk->s_name}.style.background='#000000';\">";
	foreach($chk->arr as $key=>$value){
		$count++;
		$click_color=$color_array[$key];
		if($chk->id==$key) $bg_color='background:#AAFFFF;'; else $bg_color='background:#CCCCCC;';
		$data_list.="<input type='button' style='border-width:1px; cursor:hand; $bg_color font-size:9pt;' value='$key.$value' onclick=\"this.form.{$chk->s_name}.value=$key; this.form.{$chk->s_name}.style.background='$click_color'; this.style.background='$click_color';\">";
		if($count % $cols ==0)	$data_list.="<br>";
	}
	echo $data_list;
	echo "<td><input type='text' size=2 name='{$chk->s_name}' value='$sse_live_state'></td>";
	
	?>
	</td></tr><tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sse_rich_state][d_field_cname] ?></td>

	<td CLASS="gendata">
	<?php 

	$chk->s_name="sse_rich_state";
	$chk->is_color= true;
	$chk->id = $sse_rich_state;
	$chk->arr = sfs_text("�g�٪��p");

	$count=0;
	$data_list="<input type='button' style='border-width:1px; cursor:hand; color:white; background:#ff5555; font-size:9pt;' value='�����O' onclick=\"this.form.{$chk->s_name}.value='-'; this.form.{$chk->s_name}.style.background='#000000';\">";
	foreach($chk->arr as $key=>$value){
		$count++;
		$click_color=$color_array[$key];
		if($chk->id==$key) $bg_color='background:#AAFFFF;'; else $bg_color='background:#CCCCCC;';
		$data_list.="<input type='button' style='border-width:1px; cursor:hand; $bg_color font-size:9pt;' value='$key.$value' onclick=\"this.form.{$chk->s_name}.value=$key; this.form.{$chk->s_name}.style.background='$click_color'; this.style.background='$click_color';\">";
		if($count % $cols ==0)	$data_list.="<br>";
	}
	echo $data_list;
	echo "<td><input type='text' size=2 name='{$chk->s_name}' value='$sse_rich_state'></td>";
	?>

	</td>
	</tr>

	</td>
</tr>	


<tr></tr>	<tr></tr>	


<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sse_s1][d_field_cname] ?></td>
	<td CLASS="gendata">
	<?php

	
	$chk = new checkbox_class();
	$chk->css = "gendata";
	$chk->s_name="sse_s1";
	$chk->is_color= true;
	$chk->id = $sse_s1;
	$chk->arr = sfs_text("�߷R�x�����");
	//$chk->cols=$chk_cols;
	//$chk->do_select();
	$count=0;
	$data_list='';
	foreach($chk->arr as $key=>$value){
		$count++;
		if(strpos($chk->id,",$key,")>-1) $bg_color='background:#AAFFFF;'; else $bg_color='background:#CCCCCC;';
		$data_list.="<input type='button' style='border-width:1px; cursor:hand; $bg_color font-size:9pt;' value='$key.$value' onclick=\"if(this.style.background != '#cccccc') this.style.background='#cccccc'; else this.style.background='#ffcccc'; add_value('{$chk->s_name}',$key);\">";
		if($count % $cols ==0)	$data_list.="<br>";
	}
	echo $data_list;
	echo "<td><input type='text' size=$sizes name='{$chk->s_name}' value='$sse_s1'></td>";
	?>
	</td>
</tr>


<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sse_s2][d_field_cname] ?></td>
	<td CLASS="gendata">
	<?php
	$chk->id = $sse_s2;
	$chk->s_name="sse_s2";
	$chk->css = "gendata";
	$chk->arr = sfs_text("�߷R�x�����");
	//$chk->cols=$chk_cols;
	//$chk->do_select();
	$count=0;
	$data_list='';
	foreach($chk->arr as $key=>$value){
		$count++;
		if(strpos($chk->id,",$key,")>-1) $bg_color='background:#AAFFFF;'; else $bg_color='background:#CCCCCC;';
		$data_list.="<input type='button' style='border-width:1px; cursor:hand; $bg_color font-size:9pt;' value='$key.$value' onclick=\"if(this.style.background != '#cccccc') this.style.background='#cccccc'; else this.style.background='#ffcccc'; add_value('{$chk->s_name}',$key);\">";
		if($count % $cols ==0)	$data_list.="<br>";
	}
	echo $data_list;
	echo "<td><input type='text' size=$sizes name='{$chk->s_name}' value='$sse_s2'></td>";
	?>
	</td>

</tr>


<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sse_s3][d_field_cname] ?></td>
	<td CLASS="gendata">
	<?php
	$chk->id = $sse_s3;
	$chk->s_name="sse_s3";
	$chk->css = "gendata";
	$chk->arr = sfs_text("�S��~��");
	//$chk->cols=$chk_cols;
	//$chk->do_select();
	$count=0;
	$data_list='';
	foreach($chk->arr as $key=>$value){
		$count++;
		if(strpos($chk->id,",$key,")>-1) $bg_color='background:#AAFFFF;'; else $bg_color='background:#CCCCCC;';
		$data_list.="<input type='button' style='border-width:1px; cursor:hand; $bg_color font-size:9pt;' value='$key.$value' onclick=\"if(this.style.background != '#cccccc') this.style.background='#cccccc'; else this.style.background='#ffcccc'; add_value('{$chk->s_name}',$key);\">";
		if($count % $cols ==0)	$data_list.="<br>";
	}
	echo $data_list;
	echo "<td><input type='text' size=$sizes name='{$chk->s_name}' value='$sse_s3'></td>";
	?>
	</td>
</tr>


<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sse_s4][d_field_cname] ?></td>
	<td CLASS="gendata">
	<?php
	$chk->id = $sse_s4;
	$chk->s_name="sse_s4";
	$chk->css = "gendata";
	$chk->arr = sfs_text("����");
	//$chk->cols=$chk_cols;
	//$chk->do_select();
	$count=0;
	$data_list='';
	foreach($chk->arr as $key=>$value){
		$count++;
		if(strpos($chk->id,",$key,")>-1) $bg_color='background:#AAFFFF;'; else $bg_color='background:#CCCCCC;';
		$data_list.="<input type='button' style='border-width:1px; cursor:hand; $bg_color font-size:9pt;' value='$key.$value' onclick=\"if(this.style.background != '#cccccc') this.style.background='#cccccc'; else this.style.background='#ffcccc'; add_value('{$chk->s_name}',$key);\">";
		if($count % $cols ==0)	$data_list.="<br>";
	}
	echo $data_list;
	echo "<td><input type='text'  size=$sizes name='{$chk->s_name}' value='$sse_s4'></td>";
	?>
	</td>

</tr>


<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sse_s5][d_field_cname] ?></td>
	<td CLASS="gendata">
	<?php
	$chk->id = $sse_s5;
	$chk->s_name="sse_s5";
	$chk->css = "gendata";
	$chk->arr = sfs_text("�ͬ��ߺD");
	//$chk->cols=$chk_cols;
	//$chk->do_select();
	$count=0;
	$data_list='';
	foreach($chk->arr as $key=>$value){
		$count++;
		if(strpos($chk->id,",$key,")>-1) $bg_color='background:#AAFFFF;'; else $bg_color='background:#CCCCCC;';
		$data_list.="<input type='button' style='border-width:1px; cursor:hand; $bg_color font-size:9pt;' value='$key.$value' onclick=\"if(this.style.background != '#cccccc') this.style.background='#cccccc'; else this.style.background='#ffcccc'; add_value('{$chk->s_name}',$key);\">";
		if($count % $cols ==0)	$data_list.="<br>";
	}
	echo $data_list;
	echo "<td><input type='text'  size=$sizes name='{$chk->s_name}' value='$sse_s5'></td>";
	?>
	</td>
</tr>


<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sse_s6][d_field_cname] ?></td>
	<td CLASS="gendata">
	<?php
	$chk->id = $sse_s6;
	$chk->s_name="sse_s6";
	$chk->css = "gendata";
	$chk->arr = sfs_text("�H�����Y");
	//$chk->cols=$chk_cols;
	//$chk->do_select();
	$count=0;
	$data_list='';
	foreach($chk->arr as $key=>$value){
		$count++;
		if(strpos($chk->id,",$key,")>-1) $bg_color='background:#AAFFFF;'; else $bg_color='background:#CCCCCC;';
		$data_list.="<input type='button' style='border-width:1px; cursor:hand; $bg_color font-size:9pt;' value='$key.$value' onclick=\"if(this.style.background != '#cccccc') this.style.background='#cccccc'; else this.style.background='#ffcccc'; add_value('{$chk->s_name}',$key);\">";
		if($count % $cols ==0)	$data_list.="<br>";
	}
	echo $data_list;
	echo "<td><input type='text'  size=$sizes name='{$chk->s_name}' value='$sse_s6'></td>";
	?>
	</td>
</tr>

<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sse_s7][d_field_cname] ?></td>
	<td CLASS="gendata">
	<?php
	$chk->id = $sse_s7;
	$chk->s_name="sse_s7";
	$chk->css = "gendata";
	$chk->arr = sfs_text("�~�V�欰");
	//$chk->cols=$chk_cols;
	//$chk->do_select();
	$count=0;
	$data_list='';
	foreach($chk->arr as $key=>$value){
		$count++;
		if(strpos($chk->id,",$key,")>-1) $bg_color='background:#AAFFFF;'; else $bg_color='background:#CCCCCC;';
		$data_list.="<input type='button' style='border-width:1px; cursor:hand; $bg_color font-size:9pt;' value='$key.$value' onclick=\"if(this.style.background != '#cccccc') this.style.background='#cccccc'; else this.style.background='#ffcccc'; add_value('{$chk->s_name}',$key);\">";
		if($count % $cols ==0)	$data_list.="<br>";
	}
	echo $data_list;
	echo "<td><input type='text'  size=$sizes name='{$chk->s_name}' value='$sse_s7'></td>";
	?>
	</td>
</tr>


<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sse_s8][d_field_cname] ?></td>

	<td CLASS="gendata">
	<?php
	$chk->id = $sse_s8;
	$chk->s_name="sse_s8";
	$chk->css = "gendata";
	$chk->arr = sfs_text("���V�欰");
	//$chk->cols=$chk_cols;
	//$chk->do_select();
	$count=0;
	$data_list='';
	foreach($chk->arr as $key=>$value){
		$count++;
		if(strpos($chk->id,",$key,")>-1) $bg_color='background:#AAFFFF;'; else $bg_color='background:#CCCCCC;';
		$data_list.="<input type='button' style='border-width:1px; cursor:hand; $bg_color font-size:9pt;' value='$key.$value' onclick=\"if(this.style.background != '#cccccc') this.style.background='#cccccc'; else this.style.background='#ffcccc'; add_value('{$chk->s_name}',$key);\">";
		if($count % $cols ==0)	$data_list.="<br>";
	}
	echo $data_list;
	echo "<td><input type='text'  size=$sizes name='{$chk->s_name}' value='$sse_s8'></td>";
	?>
	</td>
</tr>


<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sse_s9][d_field_cname] ?></td>
	<td CLASS="gendata">

	<?php
	$chk->id = $sse_s9;
	$chk->s_name="sse_s9";
	$chk->css = "gendata";
	$chk->arr = sfs_text("�ǲߦ欰");
	//$chk->cols=$chk_cols;
	//$chk->do_select();
	$count=0;
	$data_list='';
	foreach($chk->arr as $key=>$value){
		$count++;
		if(strpos($chk->id,",$key,")>-1) $bg_color='background:#AAFFFF;'; else $bg_color='background:#CCCCCC;';
		$data_list.="<input type='button' style='border-width:1px; cursor:hand; $bg_color font-size:9pt;' value='$key.$value' onclick=\"if(this.style.background != '#cccccc') this.style.background='#cccccc'; else this.style.background='#ffcccc'; add_value('{$chk->s_name}',$key);\">";
		if($count % $cols ==0)	$data_list.="<br>";
	}
	echo $data_list;
	echo "<td><input type='text'  size=$sizes name='{$chk->s_name}' value='$sse_s9'></td>";
	?>
	</td>
</tr>


<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sse_s10][d_field_cname] ?></td>
	<td CLASS="gendata">

	<?php
	$chk->id = $sse_s10;
	$chk->s_name="sse_s10";
	$chk->css = "gendata";
	$chk->arr = sfs_text("���}�ߺD");
	//$chk->cols=$chk_cols;
	//$chk->do_select();
	$count=0;
	$data_list='';
	foreach($chk->arr as $key=>$value){
		$count++;
		if(strpos($chk->id,",$key,")>-1) $bg_color='background:#AAFFFF;'; else $bg_color='background:#CCCCCC;';
		$data_list.="<input type='button' style='border-width:1px; cursor:hand; $bg_color font-size:9pt;' value='$key.$value' onclick=\"if(this.style.background != '#cccccc') this.style.background='#cccccc'; else this.style.background='#ffcccc'; add_value('{$chk->s_name}',$key);\">";
		if($count % $cols ==0)	$data_list.="<br>";
	}
	echo $data_list;
	echo "<td><input type='text'  size=$sizes name='{$chk->s_name}' value='$sse_s10'></td>";
	?>
	</td>
</tr>


<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sse_s11][d_field_cname] ?></td>
	<td CLASS="gendata">

	<?php
	$chk->id = $sse_s11;
	$chk->s_name="sse_s11";
	$chk->css = "gendata";
	$chk->arr = sfs_text("�J�{�欰");
	//$chk->cols=$chk_cols;
	//$chk->do_select();
	$count=0;
	$data_list='';
	foreach($chk->arr as $key=>$value){
		$count++;
		if(strpos($chk->id,",$key,")>-1) $bg_color='background:#AAFFFF;'; else $bg_color='background:#CCCCCC;';
		$data_list.="<input type='button' style='border-width:1px; cursor:hand; $bg_color font-size:9pt;' value='$key.$value' onclick=\"if(this.style.background != '#cccccc') this.style.background='#cccccc'; else this.style.background='#ffcccc'; add_value('{$chk->s_name}',$key);\">";
		if($count % $cols ==0)	$data_list.="<br>";
	}
	echo $data_list;
	echo "<td><input type='text'  size=$sizes name='{$chk->s_name}' value='$sse_s11'></td>";
	?>
	</td>
</tr>
<input type="hidden" name="stud_id" value="<?php echo $stud_id ?>">
<input type="hidden" name="seme_year_seme" value="<?php echo $seme_year_seme ?>">
<input type=hidden name=nav_next >

</table>
</form>

<!------------------- ��J��浲�� ------------------------------ !>

</td>
</tr>
</table>
<?php 
//�L�X���Y
foot();

//�ˬd�O�_�i�H�ƻs�W�Ǵ����--2004/1/22 by misser
function check_old_data($seme_year_seme,$sel_seme_year_seme,$stud_id){
      	global $CONN;

        //�M��ӾǸ����ǥ͡A�ثe��ܾǴ��O�_�w������x�s��stud_seme_eduh��
	$sql_select = "select stud_id from stud_seme_eduh where stud_id='$stud_id' and seme_year_seme='$sel_seme_year_seme' and (sse_relation or sse_family_kind or sse_family_air or sse_farther or sse_mother or sse_live_state or sse_rich_state or sse_s1 or sse_s2 or sse_s3 or sse_s4 or sse_s5 or sse_s6 or sse_s7 or sse_s8 or sse_s9 or sse_s10 or sse_s11)";
        $recordSet = $CONN->Execute($sql_select) or die ($sql_select);
        if ($recordSet->RecordCount()>0) return;//�p�G�w����ơA�h���i�H�A�ƻs�W�Ǵ���ơA���}�C
        
        //���D�o�W�Ǵ����Ǧ~�Ǵ��A�s�J$sel_old_year_seme
        if (substr($sel_seme_year_seme,3)=='2')
           $sel_old_year_seme=substr($sel_seme_year_seme,0,3).'1';
         else{
           $sel_old_year_seme=sprintf("%03d",intval(substr($sel_seme_year_seme,0,3))-1)."2";
        }
        
        //�M��ӾǸ����ǥ͡A�e�Ǵ��O�_�w����Ʀs��stud_seme_eduh��
        $sql_select = "select seme_year_seme,stud_id,sse_relation,sse_family_kind,sse_family_air,sse_farther,sse_mother,sse_live_state,sse_rich_state,sse_s1,sse_s2,sse_s3,sse_s4,sse_s5,sse_s6,sse_s7,sse_s8,sse_s9,sse_s10,sse_s11 from stud_seme_eduh where stud_id='$stud_id' and seme_year_seme='$sel_old_year_seme'";
        $recordSet = $CONN->Execute($sql_select) or die ($sql_select);

        if (!$recordSet->EOF) {
                //�N�e�Ǵ�����ƷǳơA�H�K�ƻs
        	$stud_id = $recordSet->fields["stud_id"];
        	$sse_relation = $recordSet->fields["sse_relation"];
        	$sse_family_kind = $recordSet->fields["sse_family_kind"];
        	$sse_family_air = $recordSet->fields["sse_family_air"];
        	$sse_farther = $recordSet->fields["sse_farther"];
        	$sse_mother = $recordSet->fields["sse_mother"];
        	$sse_live_state = $recordSet->fields["sse_live_state"];
        	$sse_rich_state = $recordSet->fields["sse_rich_state"];
        	$sse_s1 = $recordSet->fields["sse_s1"];
        	$sse_s2 = $recordSet->fields["sse_s2"];
        	$sse_s3 = $recordSet->fields["sse_s3"];
        	$sse_s4 = $recordSet->fields["sse_s4"];
        	$sse_s5 = $recordSet->fields["sse_s5"];
        	$sse_s6 = $recordSet->fields["sse_s6"];
        	$sse_s7 = $recordSet->fields["sse_s7"];
        	$sse_s8 = $recordSet->fields["sse_s8"];
        	$sse_s9 = $recordSet->fields["sse_s9"];
        	$sse_s10 = $recordSet->fields["sse_s10"];
        	$sse_s11 = $recordSet->fields["sse_s11"];
        	//�C�X���
                $show.= "<tr><td colspan='5' bgcolor='#44aa55' width='100%'><table width='100%' border='0'><tr><td width='100%'>";
                $show.= "<input type='hidden' name='new_seme_year_seme' value='$sel_seme_year_seme'>";
                $show.= "<input type='hidden' name='stud_id' value='$stud_id'>";
                $show.= "<input type='hidden' name='old_sse_relation' value='$sse_relation'>";
                $show.= "<input type='hidden' name='old_sse_family_kind' value='$sse_family_kind'>";
                $show.= "<input type='hidden' name='old_sse_family_air' value='$sse_family_air'>";
                $show.= "<input type='hidden' name='old_sse_farther' value='$sse_farther'>";
                $show.= "<input type='hidden' name='old_sse_mother' value='$sse_mother'>";
                $show.= "<input type='hidden' name='old_sse_live_state' value='$sse_live_state'>";
                $show.= "<input type='hidden' name='old_sse_rich_state' value='$sse_rich_state'>";
                $show.= "<input type='hidden' name='old_sse_s1' value='$sse_s1'>";
                $show.= "<input type='hidden' name='old_sse_s2' value='$sse_s2'>";
                $show.= "<input type='hidden' name='old_sse_s3' value='$sse_s3'>";
                $show.= "<input type='hidden' name='old_sse_s4' value='$sse_s4'>";
                $show.= "<input type='hidden' name='old_sse_s5' value='$sse_s5'>";
                $show.= "<input type='hidden' name='old_sse_s6' value='$sse_s6'>";
                $show.= "<input type='hidden' name='old_sse_s7' value='$sse_s7'>";
                $show.= "<input type='hidden' name='old_sse_s8' value='$sse_s8'>";
                $show.= "<input type='hidden' name='old_sse_s9' value='$sse_s9'>";
                $show.= "<input type='hidden' name='old_sse_s10' value='$sse_s10'>";
                $show.= "<input type='hidden' name='old_sse_s11' value='$sse_s11'>";
                $show.= "&nbsp;&nbsp;<font size='2' color='#ffffff'>** �{���w�j�M��ӥͤW�Ǵ�����ơA�z�i�H�����ƻs�쥻�Ǵ��A�A�t�[�ק�</font><input type='submit' name='do_key' value ='�ߧY�ƻs' onClick=\"return checkok();\">&nbsp;&nbsp;";
                $show.= "</td></tr></table></td></tr>";
                return $show;
        }
}
?> 
