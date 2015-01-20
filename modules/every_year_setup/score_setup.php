<?php

// $Id: score_setup.php 7147 2013-02-25 07:11:21Z infodaes $

/* ���o�򥻳]�w�� */
include "config.php";

sfs_check();

if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

//�Y����ܾǦ~�Ǵ��A�i����Ψ��o�Ǧ~�ξǴ�
if(!empty($year_seme)){
	$ys=explode("-",$year_seme);
	$sel_year=$ys[0];
	$sel_seme=$ys[1];
}

if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
if(empty($act))$act="";


//����ʧ@�P�_
if($act=="�x�s�]�w"){
	$setup_id=save_setup($setup_id,$sel_year,$sel_seme,$main_data,$Cyear,$all_same,$pt_times,$allow_modify);
	header("location: {$_SERVER['PHP_SELF']}?act=view&setup_id=$setup_id");
}elseif($act=="view" or $act=="�[�ݳ]�w"){
	$main=&exam_form($sel_year,$sel_seme,"view",$Cyear,$setup_id);
}elseif($act=="�}�l�]�w" or $act=="�ק�]�w" or $act=="setup"){
	$main=&exam_form($sel_year,$sel_seme,"edit",$Cyear,$setup_id);
}else{
	$main=&exam_form_1($sel_year,$sel_seme);
}


//�q�X����
head("�Ҹճ]�w");
echo $main;
foot();

/*
�禡��
*/
//�򥻳]�w���
function &exam_form_1($sel_year,$sel_seme){
	global $school_menu_p;
	//�����\���
	$tool_bar=&make_menu($school_menu_p);

	//����
	$help_text="
	�п�ܤ@�ӾǦ~�B�Ǵ��H���]�w�C||
	<span class='like_button'>�}�l�]�w</span> �|�}�l�i��ӾǦ~�Ǵ��Ҹճ]�w�C||
	<span class='like_button'>�[�ݳ]�w</span>�|�C�X�ӾǦ~�Ǵ����Ҹճ]�w�C
	";
	$help=&help($help_text);

	//���o�~�׻P�Ǵ����U�Կ��
	$date_select=&class_ok_setup_year($sel_year,$sel_seme,"year_seme","jumpMenu");
	
	//���o�~�ſ��
	$class_year_list=&get_class_year_select($sel_year,$sel_seme,$Cyear);

	$main="
	<script language='JavaScript'>
	function jumpMenu(){
		if(document.myform.year_seme.options[document.myform.year_seme.selectedIndex].value!=''){
			location=\"{$_SERVER['PHP_SELF']}?act=$act&year_seme=\" + document.myform.year_seme.options[document.myform.year_seme.selectedIndex].value;
		}
	}
	</script>
	$tool_bar
	<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4>
	<tr bgcolor='#FFFFFF'><td>
		<table>
		<form action='{$_SERVER['PHP_SELF']}' method='post' name='myform'>
  		<tr><td>�п�ܱ��]�w���Ǧ~�סG</td><td>$date_select</td></tr>
		<tr><td>�п�ܱ��]�w���~�šG</td><td>$class_year_list</td></tr>
		<tr><td colspan='2'><input type='submit' name='act' value='�}�l�]�w' class='b1'>
		<input type='submit' name='act' value='�[�ݳ]�w' class='b1'>
		</td></tr>
		</form>
		</table>
	</td></tr>
	</table>
	<br>
	$help
	";
	return $main;
}



//�D�n���]�w���
function &exam_form($sel_year,$sel_seme,$mode="edit",$sel_Cyear="",$setup_id=""){
	global $act,$CONN,$school_kind_name,$school_kind_end,$school_kind_name_n,$ptt,$school_menu_p,$main_data;
 	
	$sm=&get_all_setup($setup_id,$sel_year,$sel_seme,$sel_Cyear);
	$setup_id=$sm[setup_id];
	$Cyear=(is_null($sel_Cyear))?$sm[class_year]:$sel_Cyear;
	$year=(empty($sm[year]))?$sel_year:$sm[year];
	$seme=(empty($sm[semester]))?$sel_seme:$sm[semester];

	//���o�~�ſ��
	$class_year_list=&get_class_year_select($year,$seme,$Cyear,"jumpMenu");
	
	
	if($mode=="edit" and empty($setup_id)){
		//���إߤ@�ӳ]�w�ɡ]���צ��L��ơ^
		$setup_id=save_setup($setup_id,$year,$seme,$main_data,$Cyear);
	}	

	
	//�ݸӦ~�ŬO�_�w�g�����
	$have_data=($mode=="view" and empty($sm[rule]) and empty($sm[sections]) and empty($sm[interface_sn]))?false:true;
	
	//�w�]�Ҹզ���
	$pttn=(!empty($ptt))?$ptt:$sm[performance_test_times];
	$pf_stand=(empty($pttn))?2:$pttn;

	if($mode=="edit"){
		//�w�����q���ƿ��
		for($i=0;$i<=10;$i++){
			$selected=($i==$pf_stand)?"selected":"";
			$pf_options.="<option $selected>$i</option>";
		}
		$performance_test_options="<select name='pt_times' onChange='jumpMenu2()'>$pf_options</select>";

	}else{
		$performance_test_options="<font color='#FF0000'><b>$pf_stand</b></font>";
	}

	//���p���e���Z��ҼҦ��O�ӧO���A�i����Φr��ʧ@
	if($sm[score_mode]=="severally"){
		$test_ratio=explode(",",$sm[test_ratio]);
		for($i=0;$i<sizeof($test_ratio);$i++){
			$tr=explode("-",$test_ratio[$i]);
			$n=$i+1;
			$pf_index="pf_ratio_".$n;
			$pt_index="pt_ratio_".$n;
			$severally_ratio[$pf_index]=$tr[0];
			$severally_ratio[$pt_index]=$tr[1];
		}
	}else{
		$test_ratio=explode("-",$sm[test_ratio]);
		$all_ratio[pf]=$test_ratio[0]?$test_ratio[0]:50;
		$all_ratio[pt]=$test_ratio[1]?$test_ratio[1]:50;
	}

	//�w�����q��ҳ]�w�A�ĭӧO��ҫh�p�⤣�P������Ҭ���
	for($i=1;$i<=$pf_stand;$i++){
		$pf_index="pf_ratio_".$i;
		$pt_index="pt_ratio_".$i;
		$severally_exam_ratio.=($mode=="edit")?"
		�� $i ���w���Ҭd�� <input type='text' name='main_data[pf_ratio][$i]' value='$severally_ratio[$pf_index]' size=2>%�A
		���ɦ��Z�� <input type='text' name='main_data[pt_ratio][$i]' value='$severally_ratio[$pt_index]' size=2>%<br>
		":"
		�� $i ���w���Ҭd�� <font color='#0000FF'>$severally_ratio[$pf_index]</font> %�A
		���ɦ��Z�� <font color='#0000FF'>$severally_ratio[$pt_index]</font> %<br>
		";
	}
	
	
	$checked_severally=($sm[score_mode]=="severally")?"checked":"";
	$checked_all=($sm[score_mode]=="all")?"checked":"";
	if(! $checked_severally) $checked_all='checked';

	//�C�����q���ĬۦP��ҼҦ�
	$all_mode=($mode=="edit")?"
	<tr bgcolor='#FFFFFF'><td valign='top' nowrap>
	<input type='radio' name='main_data[score_mode]' value='all' $checked_all>�C�����q���ĬۦP��ҡG</td>
	<td valign='top' class='small'>
	�w���Ҭd�p����ҡG<input type='text' name='main_data[performance_test_ratio]' value='$all_ratio[pf]' size=3>%<br>
	���ɦ��Z�p����ҡG<input type='text' name='main_data[practice_test_ratio]' value='$all_ratio[pt]' size=3>%
	</td></tr>":"
	<tr bgcolor='#FFFFFF'><td valign='top' nowrap>
	�C�����q���ĬۦP��ҡG</td>
	<td valign='top'>
	�w���Ҭd�p����ҡG <font color='#0000FF'>$all_ratio[pf]</font> %<br>
	���ɦ��Z�p����ҡG <font color='#0000FF'>$all_ratio[pt]</font> %
	</td></tr>
	";


	//�C�����q�Ĥ��P��ҼҦ�
	$severally_mode=($mode=="edit")?"
	<tr bgcolor='#FFFFFF'><td valign='top' nowrap>
	<input type='radio' name='main_data[score_mode]' value='severally' $checked_severally>�C�����q�Ĥ��P��ҡG</td>
	<td valign='top' class='small'>
	$severally_exam_ratio
	</td></tr>":"
	<tr bgcolor='#FFFFFF'><td valign='top' nowrap>
	�C�����q�Ĥ��P��ҡG</td>
	<td valign='top' class='small'>
	$severally_exam_ratio
	</td></tr>
	";
	
	//���ĳ]�w
	//�Y�O��1���]�w
	$rule_setup=((empty($setup_id) and $mode=="edit") or empty($sm[rule]))?"�u_>=_90\n��_>=_80\n�A_>=_70\n��_>=_60\n�B_<_60":$sm[rule];
	
	$rule_now="<textarea cols='10' rows='6' name='main_data[rule]'>$rule_setup</textarea>";
	$tmp=&say_rule($sm[rule]);
	$rule_set=($mode=="edit")?$rule_now:$tmp;
	
	//�p�G�O�[�ݼҦ��A�ܤ@�q�X�Y�i�C
	if($mode=="view"){
		$test_ratio_set=($sm[score_mode]=="all")?$all_mode:$severally_mode;
		$submit="�ק�]�w";
	}else{
		$test_ratio_set=$all_mode."\n".$severally_mode;
		$submit="�x�s�]�w";
	}
	
	$semester_name=($seme=='2')?"�U":"�W";

	$date_text="<font color='#607387'>
	<font color='#000000'>$year</font> �Ǧ~
	<font color='#000000'>$semester_name</font>�Ǵ�
	</font>";

	$all_exam_date=($mode=="view")?get_exam_year($year,$seme,$act,"Cyear=$Cyear"):"";

	
	$all_same_b=($mode=="view")?"":"<input type='checkbox' name='all_same' value=1><font color='blue'>�Ҧ��~�űĥάۦP�]�w�]�i�ӧO�A�ק�^</font>";
	
	$allow_modify_checked=($sm[allow_modify]=="true")?"checked":"";
	$allow_modify_txt=(($mode=="view" and $sm[allow_modify]=="true") or $mode=="edit")?"���\�Ӧ~�Ť��Z�ťi�H�ۦ�վ�Ҹճ]�w":"";
	$allow_modify_b=($mode=="view")?$allow_modify_txt:"<input type='checkbox' name='allow_modify' value='true' $allow_modify_checked><font color='red'>$allow_modify_txt</font>";

	//�`�Ƴ]�w
	$sections_n=(empty($setup_id) or empty($sm[sections]))?7:$sm[sections];
	$sections_form=($mode=="view")?$sm[sections]:"<input type='text' name='main_data[sections]' value='$sections_n' size=3> �`";
	
	//���Z��˦��]�w
	//$tmp=&get_sc_list("option",$sm[interface_sn],"main_data[interface_sn]");
	//$ar_set=($mode=="view")?"���Ǵ��ϥΪ����Z��˦����G�y".get_interface_name($sm[interface_sn])."�z":"�п�ܤ@�Ӧ��Z��˦��G".$tmp;

	//�����\���
	$tool_bar=&make_menu($school_menu_p);


	//����
	$help_text="
	�Y�O��ܡu�C�����q���ĬۦP��ҡv�A����k�p�U�G<br>
	<font color='blue'>�Ӭ�Ǵ����Z=(
	<font color='black'>�w���Ҭd�����`����</font>
	 *
	<font color='red'>�w���Ҭd�p�����</font>
	)+(
	<font color='black'>���ɤ����`����</font>
	 *
	<font color='red'>���ɦ��Z�p�����</font>
	)</font>||
	�Y�O��ܡu�C�����q�Ĥ��P��ҡv�A���]�w���Ҭd 2 ���A�u�w���Ҭd�v�M�u���ɦҡv���Z��Ҩ̧Ǭ��G30:10�A40:20�A����k�p�U�G<br>
	<font color='blue'>�Ӭ�Ǵ����Z=(
	<font color='black'>�� 1 ���w���Ҭd����</font>
	 *
	<font color='red'>30%</font>
	)+(
	<font color='black'>�� 1 �����ɤ��ƥ���</font>
	 *
	<font color='red'>10%</font>
	)+(
	<font color='black'>�� 2 ���w���Ҭd����</font>
	 *
	<font color='red'>40%</font>
	)+(
	<font color='black'>�� 2�����ɤ��ƥ���</font>
	 *
	<font color='red'>20%</font>
	)</font>
	";
	$help=&help($help_text);
	
	if(is_null($Cyear)){
		$all_data="";
	}else{
	$all_data=($have_data)?"
	<tr bgcolor='#E1ECFF'><td valign='top' colspan=2 class='col_style'>���Zú������]�w</td></tr>
	<tr bgcolor='#FFFFFF'><td valign='top' nowrap colspan=2>
	���Ǵ��w���Ҭd���ơG $performance_test_options ��
	</td></tr>
	<tr bgcolor='#E1ECFF'><td valign='top' colspan=2 class='col_style'>���Z�t����Ҭ����]�w</td></tr>
	$test_ratio_set
	<tr bgcolor='#E1ECFF'><td valign='top' class='col_style'>���ĳ]�w</td></tr>
	<tr><td valign='top' rowspan=4>$rule_set</td></tr>
	<tr bgcolor='#E1ECFF'><td valign='top' colspan=2 class='col_style'>�C��`�Ƴ]�w</td></tr>
	<tr bgcolor='#FFFFFF'><td valign='top' nowrap colspan=2 class='small'>
	�C��W�Ҹ`�Ʀ��X�`�H $sections_form
	</td></tr>
	<input type='hidden' name='sel_year' value='$sel_year'>
	<input type='hidden' name='sel_seme' value='$sel_seme'>
	<input type='hidden' name='setup_id' value='$sm[setup_id]'>
	$hidden
	<tr bgcolor='#def7ce'><td valign='top' class='small'>
	$allow_modify_b<br>
	$all_same_b
	<p align='right'>
	<input type='submit' name='act' value='$submit' onclick='if(this.value==\"�x�s�]�w\") { return confirm(\"���T�w��A�|�N�Ҫ�]�w���h�l�`�����ƽҧR���A�ӥB���i�^�_�C\\n\\n�u���n�o�˰���?\") }' class='b1'>
	</p></td></tr>
	</form>
	<tr bgcolor='#E1ECFF'><td valign='top' colspan=2>��L�����]�w</td></tr>
	<tr bgcolor='#FFFFFF'><td colspan=2><a href='subject_setup.php?subject_kind=scope'>��ؿ�ܲM��]�w</a>�]���ݯS�O�h�]�w�^&nbsp;</td></tr>
	<tr bgcolor='#FFFFFF'><td colspan=2><a href='subject_setup.php?subject_kind=subject'>�����ܲM��]�w</a>�]���ݯS�O�h�]�w�^&nbsp;</td></tr>
	":"
	<tr bgcolor='#E1ECFF'><td valign='top' colspan=2>�Ӧ~�ũ|���]�w��ơA<a href='{$_SERVER['PHP_SELF']}?act=setup&sel_year=$sel_year&sel_seme=$sel_seme&Cyear=$Cyear'>�{�b�ߧY�]�w</a></td></tr>
	";
	}
	
	$main="
	<style type='text/css'>
	.col_style{
		background : #E1ECFF;
		color : #778899;
	}
	</style>
	<script language='JavaScript'>
	function jumpMenu(){
		if(document.myform.Cyear.options[document.myform.Cyear.selectedIndex].value!=''){
			location=\"{$_SERVER['PHP_SELF']}?act=$act&sel_year=$sel_year&sel_seme=$sel_seme&Cyear=\" + document.myform.Cyear.options[document.myform.Cyear.selectedIndex].value;
		}
	}
	function jumpMenu2(){
		if(document.myform.pt_times.options[document.myform.pt_times.selectedIndex].value!=''){
			location=\"{$_SERVER['PHP_SELF']}?act=$act&setup_id=$setup_id&main_data=$main_data&ptt=\" + document.myform.pt_times.options[document.myform.pt_times.selectedIndex].value;
		}
	}
	</script>
	$tool_bar
	<table cellspacing=0 cellpadding=0><tr><td>
		<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4>
		<tr bgcolor='#FFFFFF'><td>
			<form action='{$_SERVER['PHP_SELF']}' method='post' name='myform'>
			<table cellpadding=4 width=500>
			<tr bgcolor='#ffffcc'>
			<td colspan=2>���]�w���Ǧ~�סG".$date_text.$class_year_list."</td></tr>
			$all_data
			</table>
		</td></tr></table>
	</td><td valign='top'>$all_exam_date</td></tr></table>
	<p>
	$help
	</p>
	";
	return $main;
}

//�x�s�Ҹճ]�w
function save_setup($setup_id="",$sel_year="",$sel_seme="",$main_data="",$Cyear="",$all_same="",$pt_times="",$allow_modify=""){
	global $CONN;
	$main_data[performance_test_times]=$pt_times;
	$main_data[allow_modify]=$allow_modify;
	
	//���p�Ҧ��~�űĬۦP�]�w
	if($all_same=="1"){
		$class_year_array=get_class_year_array($sel_year,$sel_seme);
		if(!is_array($class_year_array))$class_year_array=array();

		//���o�~�Ű}�C
		while(list($i,$v)=each($class_year_array)){
			$setup_id=save_one("",$sel_year,$sel_seme,$main_data,$v);
			if($v==$Cyear)$curr_setup_id=$setup_id;
		}
		return $curr_setup_id;
	}else{
		$setup_id=save_one($setup_id,$sel_year,$sel_seme,$main_data,$Cyear);
		return $setup_id;
	}

	return false;
}

//�x�s�Y�@�Ӧ~�Ū����Z�]�w
function save_one($setup_id="",$sel_year="",$sel_seme="",$main_data="",$Cyear=""){
	global $CONN;
	//���p�L�Ҹճ]�wid�A�h���o
	$sm=&get_all_setup($setup_id,$sel_year,$sel_seme,$Cyear);
	$setup_id=$sm[setup_id];

	//�p�G���S���A��ܸӾǴ��٥�����ơA����N�s�W�@����ơC
	if(empty($setup_id)){
		$setup_id=add_setup($main_data,$sel_year,$sel_seme,$Cyear);

		//�R���h�l�`�ƪ��Ҫ���
		$sql = "delete from score_course where year='$sel_year' and semester='$sel_seme' and class_year='$Cyear' and sector>{$main_data[sections]}";
		$CONN->Execute($sql) or trigger_error("SQL�y�k���~�G $sql", E_USER_ERROR);

		if(!empty($setup_id))	return $setup_id;
	}elseif(is_array($main_data)){
		if(update_setup($setup_id,$main_data,$sel_year,$sel_seme,$Cyear))
		
		//�R���h�l�`�ƪ��Ҫ���
		$sql = "delete from score_course where year='$sel_year' and semester='$sel_seme' and class_year='$Cyear' and sector>{$main_data[sections]}";
		$CONN->Execute($sql) or trigger_error("SQL�y�k���~�G $sql", E_USER_ERROR);

		return $setup_id;
	}

	return false;
}


//�W�h�f�y��
function &say_rule($rule=""){
	$r=explode("\n",$rule);
	while(list($k,$v)=each($r)){
		$str=explode("_",$v);
		$main.="�Ǵ�����
		<font color='#FF0000'>$str[1]</font>
		<font color='#0000FF'>$str[2]</font>
		�ɡA���Ĭ��y<font color='#008000'>$str[0]</font>�z<br>";
	}
	return $main;
}

//�s�W�Ҹճ]�w
function add_setup($main_data="",$sel_year="",$sel_seme="",$Cyear=""){
	global $CONN;

	if(empty($main_data[score_mode]))$main_data[score_mode] = all;
	//$rule=make_rule($main_data);
	$rule=$main_data[rule];
	if($main_data[score_mode]=="all"){
		$test_ratio=$main_data[performance_test_ratio]."-".$main_data[practice_test_ratio];
	}elseif($main_data[score_mode]=="severally"){
		$test_ratio=&ratio_2_string($main_data[pf_ratio],$main_data[pt_ratio]);
	}

	$sql_insert = "insert into score_setup (year,semester,class_year,allow_modify,performance_test_times,practice_test_times,test_ratio,rule,score_mode,sections,interface_sn,update_date,enable) values ($sel_year,'$sel_seme','$Cyear','$main_data[allow_modify]','$main_data[performance_test_times]','1','$test_ratio','$rule','$main_data[score_mode]','$main_data[sections]','$main_data[interface_sn]',now(),'1')";
	$CONN->Execute($sql_insert) or trigger_error("SQL�y�k���~�G $sql_insert", E_USER_ERROR);

	return mysql_insert_id();
}


//��s�Ҹճ]�w
function update_setup($setup_id,$main_data,$sel_year,$sel_seme,$Cyear=""){
	global $CONN;
	//$rule=make_rule($main_data);
	$rule=$main_data[rule];
	if($main_data[score_mode]=="all"){
		$test_ratio=$main_data[performance_test_ratio]."-".$main_data[practice_test_ratio];
	}elseif($main_data[score_mode]=="severally"){
		$test_ratio=&ratio_2_string($main_data[pf_ratio],$main_data[pt_ratio]);
	}

	$sql_update = "update score_setup set allow_modify='$main_data[allow_modify]',performance_test_times='$main_data[performance_test_times]',test_ratio='$test_ratio',rule='$rule',score_mode='$main_data[score_mode]',sections='$main_data[sections]',interface_sn='$main_data[interface_sn]',update_date=now() where setup_id = '$setup_id'";
	$CONN->Execute($sql_update) or trigger_error("SQL�y�k���~�G $sql_update", E_USER_ERROR);
	return true;
}


//�R���Ҹճ]�w
function del_setup($setup_id){
	global $CONN,$sel_year,$sel_seme;
	$sql_update = "update score_setup set enable='0' where setup_id = '$setup_id'";
	if($CONN->Execute($sql_update))		return true;
	return  false;
}



//��Ҹդ�Ҫ������H�r�I���r��e�{
function &ratio_2_string($pf_ratio,$pt_ratio){
	for($i=1;$i<=sizeof($pf_ratio);$i++){
		$main.=$pf_ratio[$i]."-".$pt_ratio[$i].",";
	}
	$main=substr($main,0,-1);
	return $main;
}

//���Z�檺�˦��W��
function get_interface_name($interface_sn=1){
	$sc=&get_sc($interface_sn);
	return $sc[title];
}


?>
