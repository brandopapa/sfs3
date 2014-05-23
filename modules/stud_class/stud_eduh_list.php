<?php 

// $Id: stud_eduh_list.php 6986 2012-10-31 06:39:15Z infodaes $

// ���J�]�w��
include "stud_reg_config.php";
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

//���o���ЯZ�ťN��
$class_num = get_teach_class();
if ($class_num == '') {
	head("�v�����~");
	echo "<center><h3>�����@�~���ť��ɮv�v��</h3></center>";
	foot();
	exit;
}
$stud_id = $_GET[stud_id];
if ($stud_id == '')
	$stud_id = $_POST[stud_id];

switch($_POST[do_key]) {
	case $editBtn:
        	for ($i=1;$i<=11;$i++) {
        		$sse_temp =",";
        		$sse_arr = "sse_s".$i;
        		if (count($_POST["sse_s".$i])>0) {
        			while(list($tid,$tname)=each($_POST["sse_s".$i]))
        				$sse_temp .= $tname.",";

        			$$sse_arr = $sse_temp;
        		}
        	}
        	$sql_insert = "replace into stud_seme_eduh (seme_year_seme,stud_id,sse_relation,sse_family_kind,sse_family_air,sse_farther,sse_mother,sse_live_state,sse_rich_state,sse_s1,sse_s2,sse_s3,sse_s4,sse_s5,sse_s6,sse_s7,sse_s8,sse_s9,sse_s10,sse_s11) values ('$_POST[sel_seme_year_seme]','$stud_id','$_POST[sse_relation]','$_POST[sse_family_kind]','$_POST[sse_family_air]','$_POST[sse_farther]','$_POST[sse_mother]','$_POST[sse_live_state]','$_POST[sse_rich_state]','$sse_s1','$sse_s2','$sse_s3','$sse_s4','$sse_s5','$sse_s6','$sse_s7','$sse_s8','$sse_s9','$sse_s10','$sse_s11')";
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
	$query = "select a.stud_id,a.stud_name from stud_base a,stud_seme b where a.student_sn=b.student_sn and a.stud_id='$stud_id' and a.stud_study_cond=0 and b.seme_year_seme='$c_curr_seme' and b.seme_class='$class_num'";	
	$res = $CONN->Execute($query) or die($res->ErrorMsg());
	//���]�w�Χ��ܦb¾���p�ΧR���O���� ��Ĥ@��
	if ($stud_id =="" || $res->RecordCount()==0) {	
		$temp_sql = "select a.stud_id,a.stud_name from stud_base a,stud_seme b where a.student_sn=b.student_sn and a.stud_study_cond=0 and b.seme_year_seme='$c_curr_seme' and b.seme_class='$class_num' order by b.seme_num";
		$res2 = $CONN->Execute($temp_sql) or die($temp_sql);
		$stud_id = $res2->fields[0];
	}

$stud_name = $res->fields[1];

	

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
//-->

</script>
 
<table BORDER=0 CELLPADDING=0 CELLSPACING=0 CLASS="tableBg" WIDTH="100%" > 
<tr>
<td valign=top align="right">
<?php
//�إߥ�����   
	$temparr = class_base();   
	$upstr = $temparr[$class_num]; 	
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
		echo sprintf(" --%s (%s) <a href=\"stud_eduh_detail.php?stud_id=%s\" target=_blank>���%s �O��</a>",$stud_name,$stud_id,$stud_id,$stud_name);

		if ($sel_seme_year_seme == $this_seme_year_seme || $old_year_is_edit)
		    	echo "&nbsp;&nbsp;<input type=submit name=do_key value =\"$editBtn\" onClick=\"return checkok();\">&nbsp;&nbsp;";
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
	<table  cellspacing="5" cellpadding="0" >
	<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sse_relation][d_field_cname] ?></td>
	<td CLASS="gendata">
	<?php 
	$sel = new drop_select();
	$sel->s_name = "sse_relation";
	$sel->arr = sfs_text("�������Y");
	$sel->id = $sse_relation;
	$sel->do_select();
	?>
	</td>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sse_family_kind][d_field_cname] ?></td>
	<td CLASS="gendata">

	<?php 
	$sel->s_name = "sse_family_kind";
	$sel->arr = sfs_text("�a�x����");
	$sel->id = $sse_family_kind;
	$sel->do_select();
	?>
	</td>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sse_family_air][d_field_cname] ?></td>
	<td CLASS="gendata">
	<?php 
	$sel->s_name = "sse_family_air";
	$sel->arr = sfs_text("�a�x��^");
	$sel->id = $sse_family_air;
	$sel->do_select();
	?>

	</td>
	</tr>
	</table>


	</td>
</tr>
<tr>
	<td colspan=2>
	<table  cellspacing="5" cellpadding="0" >

	<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sse_farther][d_field_cname] ?></td>
	<td CLASS="gendata">
	<?php 
	$sel->s_name = "sse_farther";
	$sel->arr = sfs_text("�ޱФ覡");
	$sel->id = $sse_farther;
	$sel->do_select();
	?>

	</td>

	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sse_mother][d_field_cname] ?></td>
	<td CLASS="gendata">
	<?php 
	$sel->s_name = "sse_mother";
	$sel->arr = sfs_text("�ޱФ覡");
	$sel->id = $sse_mother;
	$sel->do_select();
	?>

	</td>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sse_live_state][d_field_cname] ?></td>
	<td CLASS="gendata">
	<?php 
	$sel->s_name = "sse_live_state";
	$sel->arr = sfs_text("�~����");
	$sel->id = $sse_live_state;
	$sel->do_select();
	?>
	</td>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sse_rich_state][d_field_cname] ?></td>

	<td CLASS="gendata">
	<?php 
	$sel->s_name = "sse_rich_state";
	$sel->arr = sfs_text("�g�٪��p");
	$sel->id = $sse_rich_state;
	$sel->do_select();
	?>

	</td>
	</tr>
	</table>

	</td>
</tr>	


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
	$chk->cols=$chk_cols;
	$chk->do_select();
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
	$chk->cols=$chk_cols;
	$chk->do_select();
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
	$chk->cols=$chk_cols;
	$chk->do_select();
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
	$chk->cols=$chk_cols;
	$chk->do_select();
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
	$chk->cols=$chk_cols;
	$chk->do_select();
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
	$chk->cols=$chk_cols;
	$chk->do_select();
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
	$chk->cols=$chk_cols;
	$chk->do_select();
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
	$chk->cols=$chk_cols;
	$chk->do_select();
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
	$chk->cols=$chk_cols;
	$chk->do_select();
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
	$chk->cols=$chk_cols;
	$chk->do_select();
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
	$chk->cols=$chk_cols;
	$chk->do_select();
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
