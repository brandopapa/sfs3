<?php

// $Id: stud_dom1.php 6878 2012-09-07 05:01:27Z hsiao $

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


//����B�z
switch ($do_key){
	case $editBtn: //�ק�
	$query="select * from stud_base where student_sn='$student_sn'";
	$res=$CONN->Execute($query);
	$stud_id=$res->fields['stud_id'];

	$sql = "select * from stud_domicile where student_sn='$student_sn'";
	$recordSet = $CONN->Execute($sql) or die($sql);

    if  ($recordSet->RecordCount() == 0 )
        //$sql_update = "update stud_domicile set  fath_name='$fath_name',fath_birthyear='$fath_birthyear',fath_alive='$fath_alive',fath_relation='$fath_relation',fath_p_id='$fath_p_id',fath_education='$fath_education',fath_occupation='$fath_occupation',fath_unit='$fath_unit',fath_work_name='$fath_work_name',fath_phone='$fath_phone',fath_home_phone='$fath_home_phone',fath_hand_phone='$fath_hand_phone',fath_email='$fath_email',moth_name='$moth_name',moth_birthyear='$moth_birthyear',moth_alive='$moth_alive',moth_relation='$moth_relation',moth_p_id='$moth_p_id',moth_education='$moth_education',moth_occupation='$moth_occupation',moth_unit='$moth_unit',moth_work_name='$moth_work_name',moth_phone='$moth_phone',moth_home_phone='$moth_home_phone',moth_hand_phone='$moth_hand_phone',moth_email='$moth_email',guardian_name='$guardian_name',guardian_phone='$guardian_phone',guardian_address='$guardian_address',guardian_relation='$guardian_relation',guardian_p_id='$guardian_p_id',guardian_unit='$guardian_unit',guardian_work_name='$guardian_work_name',guardian_hand_phone='$guardian_hand_phone',guardian_email='$guardian_email',grandfath_name='$grandfath_name',grandfath_alive='$grandfath_alive',grandmoth_name='$grandmoth_name',grandmoth_alive='$grandmoth_alive',update_time='$update_time',update_id='$update_id' where stud_id='$stud_id'";
        $sql_update = " INSERT INTO stud_domicile (stud_id , fath_name , fath_birthyear , fath_alive , fath_relation , fath_p_id , fath_education ,fath_grad_kind , fath_occupation , fath_unit , fath_work_name , fath_phone , fath_home_phone , fath_hand_phone , fath_email , moth_name , moth_birthyear , moth_alive , moth_relation , moth_p_id , moth_education ,moth_grad_kind , moth_occupation , moth_unit , moth_work_name , moth_phone , moth_home_phone , moth_hand_phone , moth_email , guardian_name , guardian_phone , guardian_address , guardian_relation , guardian_p_id , guardian_unit , guardian_work_name , guardian_hand_phone , guardian_email , grandfath_name , grandfath_alive , grandmoth_name , grandmoth_alive , update_time , update_id,student_sn)
           VALUES ('$stud_id', '$fath_name' , '$fath_birthyear' , '$fath_alive' ,
            '$fath_relation' , '$fath_p_id' , '$fath_education' ,'$fath_grad_kind' , '$fath_occupation' ,
             '$fath_unit' , '$fath_work_name' , '$fath_phone' , '$fath_home_phone' ,
             '$fath_hand_phone' , '$fath_email' , '$moth_name' , '$moth_birthyear' ,
             '$moth_alive' , '$moth_relation' , '$moth_p_id' , '$moth_education' ,'$moth_grad_kind' ,
              '$moth_occupation' , '$moth_unit' , '$moth_work_name' , '$moth_phone' ,
              '$moth_home_phone' , '$moth_hand_phone' , '$moth_email' , '$guardian_name' ,
              '$guardian_phone' , '$guardian_address' , '$guardian_relation' ,
              '$guardian_p_id' , '$guardian_unit' , '$guardian_work_name' ,
              '$guardian_hand_phone' , '$guardian_email' , '$grandfath_name' ,
              '$grandfath_alive' , '$grandmoth_name' , '$grandmoth_alive' , '$update_time' ,
              '".$_SESSION['session_log_id']."','$student_sn') ";
    else
	   $sql_update = "update stud_domicile set  stud_id='$stud_id', fath_name='$fath_name',fath_birthyear='$fath_birthyear',fath_alive='$fath_alive',fath_relation='$fath_relation',fath_p_id='$fath_p_id',fath_education='$fath_education',fath_grad_kind='$fath_grad_kind',fath_occupation='$fath_occupation',fath_unit='$fath_unit',fath_work_name='$fath_work_name',fath_phone='$fath_phone',fath_home_phone='$fath_home_phone',fath_hand_phone='$fath_hand_phone',fath_email='$fath_email',moth_name='$moth_name',moth_birthyear='$moth_birthyear',moth_alive='$moth_alive',moth_relation='$moth_relation',moth_p_id='$moth_p_id',moth_education='$moth_education',moth_grad_kind='$moth_grad_kind',moth_occupation='$moth_occupation',moth_unit='$moth_unit',moth_work_name='$moth_work_name',moth_phone='$moth_phone',moth_home_phone='$moth_home_phone',moth_hand_phone='$moth_hand_phone',moth_email='$moth_email',guardian_name='$guardian_name',guardian_phone='$guardian_phone',guardian_address='$guardian_address',guardian_relation='$guardian_relation',guardian_p_id='$guardian_p_id',guardian_unit='$guardian_unit',guardian_work_name='$guardian_work_name',guardian_hand_phone='$guardian_hand_phone',guardian_email='$guardian_email',grandfath_name='$grandfath_name',grandfath_alive='$grandfath_alive',grandmoth_name='$grandmoth_name',grandmoth_alive='$grandmoth_alive',update_time='$update_time',update_id='".$_SESSION['session_log_id']."' where student_sn='$student_sn'";

	$CONN->Execute($sql_update) or die($sql_update);
	//�O�� log
	sfs_log("stud_domicile","update","$stud_id");
	break;
}

//�L�X���Y
head();
//����T
$field_data = get_field_info("stud_domicile");
//���s���r��
$linkstr = "student_sn=$student_sn&c_curr_class=$c_curr_class&c_curr_seme=$c_curr_seme";
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

	//�x�s���U�@��
if ($chknext)
	$student_sn = $nav_next;
	$query = "select a.student_sn,a.stud_id,a.stud_name from stud_base a,stud_seme b where a.student_sn=b.student_sn and a.student_sn='$student_sn' and (a.stud_study_cond=0 or a.stud_study_cond=5) and  b.seme_year_seme='$c_curr_seme' and b.seme_class='$seme_class'";
	$res = $CONN->Execute($query) or die($res->ErrorMsg());
	//���]�w�Χ��ܦb¾���p�ΧR���O���� ��Ĥ@��
	if ($student_sn =="" || $res->RecordCount()==0) {
		$temp_sql = "select a.student_sn,a.stud_id,a.stud_name from stud_base a,stud_seme b where a.student_sn=b.student_sn and (a.stud_study_cond=0 or a.stud_study_cond=5) and b.seme_year_seme='$c_curr_seme' and b.seme_class='$seme_class' order by b.seme_num";
		$res2 = $CONN->Execute($temp_sql) or die($temp_sql);
		$student_sn = $res->fields[0];
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

function same_father() {
	document.myform.guardian_name.value=document.myform.fath_name.value;
	document.myform.guardian_hand_phone.value=document.myform.fath_hand_phone.value;
	document.myform.guardian_phone.value=document.myform.fath_home_phone.value;
	document.myform.guardian_p_id.value=document.myform.fath_p_id.value;
	document.myform.guardian_unit.value=document.myform.fath_unit.value;
	document.myform.guardian_work_name.value=document.myform.fath_work_name.value;
	document.myform.guardian_email.value=document.myform.fath_email.value;
	document.myform.guardian_relation.value=document.myform.sex_f_hide.value;

}
function same_mother() {
	document.myform.guardian_name.value=document.myform.moth_name.value;
	document.myform.guardian_hand_phone.value=document.myform.moth_hand_phone.value;
	document.myform.guardian_phone.value=document.myform.moth_home_phone.value;
	document.myform.guardian_p_id.value=document.myform.moth_p_id.value;
	document.myform.guardian_unit.value=document.myform.moth_unit.value;
	document.myform.guardian_work_name.value=document.myform.moth_work_name.value;
	document.myform.guardian_email.value=document.myform.moth_email.value;
	document.myform.guardian_relation.value=document.myform.sex_m_hide.value ;
}

//-->
</script>

<table border="0" width="100%" cellspacing="0" cellpadding="0" CLASS="tableBg" >
<tr>
<td valign=top align="right">
<?php
//�إߥ�����
//��ܾǴ�
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

//��ܯZ��
	$tmp=&get_class_select($s_y,$s_s,"","c_curr_class","this.form.submit",$c_curr_class);
	$upstr .= $tmp;

	$grid1 = new ado_grid_menu($_SERVER['SCRIPT_NAME'],$URI,$CONN);  //�إ߿��
	$grid1->bgcolor = $gridBgcolor;  // �C��
	$grid1->row = $gridRow_num ;	     //��ܵ���
	$grid1->key_item = "student_sn";  // ������W
	$grid1->display_item = array("sit_num","stud_name");  // �����W
	$grid1->display_color = array("1"=>"$gridBoy_color","2"=>"$gridGirl_color"); //�k�k�ͧO
	$grid1->color_index_item ="stud_sex" ; //�C��P�_��
	$grid1->class_ccs = " class=leftmenu";  // �C�����
	$grid1->sql_str = "select a.stud_id,a.student_sn,a.stud_name,a.stud_sex,b.seme_num as sit_num from stud_base a,stud_seme b where a.student_sn=b.student_sn and (a.stud_study_cond=0 or a.stud_study_cond=5) and  b.seme_year_seme='$c_curr_seme' and b.seme_class='$seme_class' order by b.seme_num ";   //SQL �R�O
	//echo $grid1->sql_str;
	$grid1->do_query(); //����R�O

	$grid1->print_grid($student_sn,$upstr,$downstr); // ��ܵe��

	//��ܸ��
	$sql_select = "select a.*, b.stud_name, b.stud_sex  from stud_domicile a,stud_base b where a.student_sn=b.student_sn and a.student_sn='$student_sn'";
	$recordSet = $CONN->Execute($sql_select);
while (!$recordSet->EOF) {

	$stud_id = $recordSet->fields["stud_id"];
	$stud_name = $recordSet->fields["stud_name"];
	$stud_sex = $recordSet->fields["stud_sex"];
	$fath_name = $recordSet->fields["fath_name"];
	$fath_birthyear = $recordSet->fields["fath_birthyear"];
	$fath_alive = $recordSet->fields["fath_alive"];
	$fath_relation = $recordSet->fields["fath_relation"];
	$fath_p_id = $recordSet->fields["fath_p_id"];
	$fath_education = $recordSet->fields["fath_education"];
	$fath_grad_kind = $recordSet->fields["fath_grad_kind"];
	$fath_occupation = $recordSet->fields["fath_occupation"];
	$fath_unit = $recordSet->fields["fath_unit"];
	$fath_work_name = $recordSet->fields["fath_work_name"];
	$fath_phone = $recordSet->fields["fath_phone"];
	$fath_home_phone = $recordSet->fields["fath_home_phone"];
	$fath_hand_phone = $recordSet->fields["fath_hand_phone"];
	$fath_email = $recordSet->fields["fath_email"];
	$moth_name = $recordSet->fields["moth_name"];
	$moth_birthyear = $recordSet->fields["moth_birthyear"];
	$moth_alive = $recordSet->fields["moth_alive"];
	$moth_relation = $recordSet->fields["moth_relation"];
	$moth_p_id = $recordSet->fields["moth_p_id"];
	$moth_education = $recordSet->fields["moth_education"];
	$moth_grad_kind = $recordSet->fields["moth_grad_kind"];
	$moth_occupation = $recordSet->fields["moth_occupation"];
	$moth_unit = $recordSet->fields["moth_unit"];
	$moth_work_name = $recordSet->fields["moth_work_name"];
	$moth_phone = $recordSet->fields["moth_phone"];
	$moth_home_phone = $recordSet->fields["moth_home_phone"];
	$moth_hand_phone = $recordSet->fields["moth_hand_phone"];
	$moth_email = $recordSet->fields["moth_email"];
	$guardian_name = $recordSet->fields["guardian_name"];
	$guardian_phone = $recordSet->fields["guardian_phone"];
	$guardian_address = $recordSet->fields["guardian_address"];
	$guardian_relation = $recordSet->fields["guardian_relation"];
	$guardian_p_id = $recordSet->fields["guardian_p_id"];
	$guardian_unit = $recordSet->fields["guardian_unit"];
	$guardian_work_name = $recordSet->fields["guardian_work_name"];
	$guardian_hand_phone = $recordSet->fields["guardian_hand_phone"];
	$guardian_email = $recordSet->fields["guardian_email"];
	$grandfath_name = $recordSet->fields["grandfath_name"];
	$grandfath_alive = $recordSet->fields["grandfath_alive"];
	$grandmoth_name = $recordSet->fields["grandmoth_name"];
	$grandmoth_alive = $recordSet->fields["grandmoth_alive"];
	$update_time = $recordSet->fields["update_time"];
	$update_id = $recordSet->fields["update_id"];
	$student_sn = $recordSet->fields["student_sn"];

	$recordSet->MoveNext();
};
?>
     </td>
    <td width="100%" valign=top bgcolor="#CCCCCC">
    <form name ="myform" action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post"  <?php
	//��mnu���Ƭ�0�� �� form �� disabled
	if ($grid1->count_row==0 && !($key == $newBtn || $key == $postBtn))
		echo " disabled ";
	?> >
  <table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
<tr>
<td class=title_mbody colspan=5 align=center >
	<?php
		echo sprintf("%d�Ǧ~��%d�Ǵ� %s--%s (%s)",substr($c_curr_seme,0,-1),substr($c_curr_seme,-1),$class_list_p[$c_curr_seme],$stud_name,$stud_id);
		if($modify_flag) {
	    	echo "<input type=submit name=do_key value =\"$editBtn\" onClick=\"return checkok();\">&nbsp;&nbsp;";
    		if ($chknext)
    			echo "<input type=checkbox name=chknext value=1 checked >";
    		else
    			echo "<input type=checkbox name=chknext value=1 >";

    		echo "�۰ʸ��U�@��";
		    echo "<input name='sex_f_hide' type='hidden' value='$stud_sex'>\n" ;
        echo "<input name='sex_m_hide' type='hidden' value='" .($stud_sex +2) ."'>\n" ;
		}
    ?>

	</td>
</tr>


<tr>
	<td class=title_sbody1 nowrap ><?php echo $field_data[fath_name][d_field_cname] ?></td>
	<td><input type="text" size="20" maxlength="20" name="fath_name" value="<?php echo $fath_name ?>"></td>
	<td class=title_sbody1 nowrap><?php echo $field_data[fath_alive][d_field_cname] ?></td>
	<td><?php
		//�s�\
		$sel1 = new drop_select(); //���
		$sel1->s_name = "fath_alive"; //���W��
		$sel1->id = intval($fath_alive);
		$sel1->arr = is_live(); //���e�}�C
		$sel1->do_select();
    	?> </td>
</tr>

<tr>
	<td class=title_sbody1 nowrap><?php echo $field_data[fath_p_id][d_field_cname] ?></td>
	<td><input type="text" size="20" maxlength="20" name="fath_p_id" value="<?php echo $fath_p_id ?>"></td>
	<td class=title_sbody1 nowrap><?php echo $field_data[fath_birthyear][d_field_cname] ?></td>
	<td><input type="text" size="10" maxlength="10" name="fath_birthyear" value="<?php echo $fath_birthyear ?>"></td>
</tr>

<tr>
	<td class=title_sbody1 nowrap><?php echo $field_data[fath_relation][d_field_cname] ?></td>
	<td><?php
		//�P�����Y
		$sel1 = new drop_select(); //���
		$sel1->s_name = "fath_relation"; //���W��
		$sel1->id = intval($fath_relation);
		$sel1->arr = fath_relation(); //���e�}�C
		$sel1->do_select();
    	?> </td>
	<td class=title_sbody1 nowrap><?php echo $field_data[fath_education][d_field_cname] ?></td>
	<td><?php
		//�Ǿ�
		$sel1 = new drop_select(); //���
		$sel1->s_name = "fath_education"; //���W��
		$sel1->id = intval($fath_education);
		$sel1->arr = edu_kind(); //���e�}�C
		$sel1->do_select();

		//���w�~�O
		$sel1 = new drop_select(); //���
		$sel1->s_name = "fath_grad_kind"; //���W��
		$sel1->id = intval($fath_grad_kind);
		$sel1->arr = grad_kind(); //���e�}�C
		$sel1->do_select();

    	?> </td>
</tr>

<tr>
	<td class=title_sbody1 nowrap><?php echo $field_data[fath_occupation][d_field_cname] ?></td>
	<td><input type="text" size="20" maxlength="20" name="fath_occupation" value="<?php echo $fath_occupation ?>"></td>
	<td class=title_sbody1 nowrap><?php echo $field_data[fath_unit][d_field_cname] ?></td>
	<td><input type="text" size="20" maxlength="20" name="fath_unit" value="<?php echo $fath_unit ?>"></td>
</tr>

<tr>
	<td class=title_sbody1 nowrap><?php echo $field_data[fath_work_name][d_field_cname] ?></td>
	<td><input type="text" size="20" maxlength="20" name="fath_work_name" value="<?php echo $fath_work_name ?>"></td>
	<td class=title_sbody1 nowrap><?php echo $field_data[fath_hand_phone][d_field_cname] ?></td>
	<td><input type="text" size="20" maxlength="20" name="fath_hand_phone" value="<?php echo $fath_hand_phone ?>"></td>
</tr>

<tr>
	<td class=title_sbody1 nowrap> <?php echo $field_data[fath_home_phone][d_field_cname] ?></td>
	<td><input type="text" size="20" maxlength="20" name="fath_home_phone" value="<?php echo $fath_home_phone ?>"></td>
	<td class=title_sbody1 nowrap><?php echo $field_data[fath_phone][d_field_cname] ?></td>
	<td><input type="text" size="20" maxlength="20" name="fath_phone" value="<?php echo $fath_phone ?>"></td>
</tr>

<tr>
	<td class=title_sbody1 nowrap><?php echo $field_data[fath_email][d_field_cname] ?></td>
	<td colspan="3"><input type="text" size="20" maxlength="60" name="fath_email" value="<?php echo $fath_email ?>"></td>

</tr>

<tr>
	<td class=title_sbody2 nowrap><?php echo $field_data[moth_name][d_field_cname] ?></td>
	<td><input type="text" size="20" maxlength="20" name="moth_name" value="<?php echo $moth_name ?>"></td>
	<td class=title_sbody2 nowrap><?php echo $field_data[moth_alive][d_field_cname] ?></td>
	<td><?php

		//�s�\
		$sel1 = new drop_select(); //���
		$sel1->s_name = "moth_alive"; //���W��
		$sel1->id = intval($moth_alive);
		$sel1->arr = is_live(); //���e�}�C
		$sel1->do_select();
    	?> </td>
</tr>

<tr>
	<td class=title_sbody2  nowrap><?php echo $field_data[moth_p_id][d_field_cname] ?></td>
	<td><input type="text" size="20" maxlength="20" name="moth_p_id" value="<?php echo $moth_p_id ?>"></td>
	<td class=title_sbody2 nowrap><?php echo $field_data[moth_birthyear][d_field_cname] ?></td>
	<td><input type="text" size="10" maxlength="10" name="moth_birthyear" value="<?php echo $moth_birthyear ?>"></td>
</tr>

<tr>
	<td class=title_sbody2  nowrap><?php echo $field_data[moth_relation][d_field_cname] ?></td>
	<td><?php
		//�P�����Y
		$sel1 = new drop_select(); //���
		$sel1->s_name = "moth_relation"; //���W��
		$sel1->id = intval($moth_relation);
		$sel1->arr = moth_relation(); //���e�}�C
		$sel1->do_select();
    	?> </td>
	<td class=title_sbody2  nowrap><?php echo $field_data[moth_education][d_field_cname] ?></td>
	<td><?php
		//�Ǿ�
		$sel1 = new drop_select(); //���
		$sel1->s_name = "moth_education"; //���W��
		$sel1->id = intval($moth_education);
		$sel1->arr = edu_kind(); //���e�}�C
		$sel1->do_select();

		//���w�~�O
		$sel1 = new drop_select(); //���
		$sel1->s_name = "moth_grad_kind"; //���W��
		$sel1->id = intval($moth_grad_kind);
		$sel1->arr = grad_kind(); //���e�}�C
		$sel1->do_select();
    	?> </td>
</tr>



<tr>
	<td class=title_sbody2 nowrap><?php echo $field_data[moth_occupation][d_field_cname] ?></td>
	<td><input type="text" size="20" maxlength="20" name="moth_occupation" value="<?php echo $moth_occupation ?>"></td>
	<td class=title_sbody2 nowrap><?php echo $field_data[moth_unit][d_field_cname] ?></td>
	<td><input type="text" size="20" maxlength="20" name="moth_unit" value="<?php echo $moth_unit ?>"></td>
</tr>

<tr>
	<td class=title_sbody2 nowrap><?php echo $field_data[moth_work_name][d_field_cname] ?></td>
	<td><input type="text" size="20" maxlength="20" name="moth_work_name" value="<?php echo $moth_work_name ?>"></td>
	<td class=title_sbody2 nowrap><?php echo $field_data[moth_hand_phone][d_field_cname] ?></td>
	<td><input type="text" size="20" maxlength="20" name="moth_hand_phone" value="<?php echo $moth_hand_phone ?>"></td>
</tr>

<tr>
	<td class=title_sbody2 nowrap><?php echo $field_data[moth_home_phone][d_field_cname] ?></td>
	<td><input type="text" size="20" maxlength="20" name="moth_home_phone" value="<?php echo $moth_home_phone ?>"></td>
	<td class=title_sbody2 nowrap><?php echo $field_data[moth_phone][d_field_cname] ?></td>
	<td><input type="text" size="20" maxlength="20" name="moth_phone" value="<?php echo $moth_phone ?>"></td>
</tr>

<tr>
	<td class=title_sbody2 nowrap><?php echo $field_data[moth_email][d_field_cname] ?></td>
	<td  colspan="3" ><input type="text" size="20" maxlength="60" name="moth_email" value="<?php echo $moth_email ?>"></td>

</tr>


<tr>
	<td class=title_sbody1 nowrap><?php echo $field_data[guardian_name][d_field_cname] ?></td>
	<td colspan="3" ><input type="text" size="20" maxlength="20" name="guardian_name" value="<?php echo $guardian_name ?>">
	<input type="button" name="same_key" value="�P�ͤ��P" onclick="same_father()" >&nbsp;<input type="button" name="same_key" value="�P�ͥ��P"  onclick="same_mother()" >
	</td>

</tr>

<tr>
	<td class=title_sbody1 nowrap><?php echo $field_data[guardian_p_id][d_field_cname] ?></td>
	<td><input type="text" size="20" maxlength="20" name="guardian_p_id" value="<?php echo $guardian_p_id ?>"></td>
	<td class=title_sbody1 nowrap><?php echo $field_data[guardian_relation][d_field_cname] ?></td>
	<td><?php
		//�P���@�H���Y
		$sel1 = new drop_select(); //���
		$sel1->s_name = "guardian_relation"; //���W��
		$sel1->id = intval($guardian_relation);
		$sel1->arr = guardian_relation(); //���e�}�C
		$sel1->do_select();
    	?>

	</td>
</tr>

<tr>
	<td class=title_sbody1 nowrap><?php echo $field_data[guardian_unit][d_field_cname] ?></td>
	<td><input type="text" size="20" maxlength="30" name="guardian_unit" value="<?php echo $guardian_unit ?>"></td>
	<td class=title_sbody1 nowrap><?php echo $field_data[guardian_work_name][d_field_cname] ?></td>
	<td><input type="text" size="20" maxlength="20" name="guardian_work_name" value="<?php echo $guardian_work_name ?>"></td>
</tr>

<tr>
	<td class=title_sbody1 nowrap><?php echo $field_data[guardian_phone][d_field_cname] ?></td>
	<td><input type="text" size="20" maxlength="20" name="guardian_phone" value="<?php echo $guardian_phone ?>"></td>
	<td class=title_sbody1 nowrap><?php echo $field_data[guardian_hand_phone][d_field_cname] ?></td>
	<td><input type="text" size="20" maxlength="20" name="guardian_hand_phone" value="<?php echo $guardian_hand_phone ?>"></td>
</tr>

<tr>
	<td class=title_sbody1 nowrap><?php echo $field_data[guardian_address][d_field_cname] ?></td>
	<td><input type="text" size="30" maxlength="60" name="guardian_address" value="<?php echo $guardian_address ?>"></td>
	<td class=title_sbody1 nowrap><?php echo $field_data[guardian_email][d_field_cname] ?></td>
	<td><input type="text" size="20" maxlength="60" name="guardian_email" value="<?php echo $guardian_email ?>"></td>
</tr>


<tr>
	<td class=title_sbody2  nowrap><?php echo $field_data[grandfath_name][d_field_cname] ?></td>
	<td><input type="text" size="20" maxlength="20" name="grandfath_name" value="<?php echo $grandfath_name ?>"></td>
	<td class=title_sbody2  nowrap><?php echo $field_data[grandfath_alive][d_field_cname] ?></td>
	<td><?php
		//�s�\
		$sel1 = new drop_select(); //���
		$sel1->s_name = "grandfath_alive"; //���W��
		$sel1->id = intval($grandfath_alive);
		$sel1->arr = is_live(); //���e�}�C
		$sel1->do_select();
    	?></td>
</tr>

<tr>
	<td class=title_sbody2  nowrap><?php echo $field_data[grandmoth_name][d_field_cname] ?></td>
	<td><input type="text" size="20" maxlength="20" name="grandmoth_name" value="<?php echo $grandmoth_name ?>"></td>
	<td class=title_sbody2  nowrap><?php echo $field_data[grandmoth_alive][d_field_cname] ?></td>
	<td><?php
		//�s�\
		$sel1 = new drop_select(); //���
		$sel1->s_name = "grandmoth_alive"; //���W��
		$sel1->id = intval($grandmoth_alive);
		$sel1->arr = is_live(); //���e�}�C
		$sel1->do_select();
    	?></td>
</tr>
<input type="hidden" name="student_sn" value="<?php echo $student_sn ?>">
<input type="hidden" name="c_curr_seme" value="<?php echo $c_curr_seme ?>">
<input type="hidden" name="c_curr_class" value="<?php echo $c_curr_class ?>">
<input type=hidden name=nav_next >

</table>
</form>
    </td>
  </tr>
</table>
<?php
//�L�X���Y
foot();
?>
