<?php

// $Id: stud_drop.php 7429 2013-08-22 03:21:35Z infodaes $

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



//�L�X���Y
head();

if (!$modify_flag){
	trigger_error('������v�ާ@',256);
}
//����T
$field_data = get_field_info("stud_base");
//���s���r��
$linkstr = "stud_id=$stud_id&c_curr_class=$c_curr_class&c_curr_seme=$c_curr_seme";
//�Ҳտ��
print_menu($menu_p,$linkstr);
if($sure_del=="yes"){
	foreach($choice as $del_student_sn){		
		//��X�Ǹ�
		$stud_id=student_sn2stud_id($del_student_sn);
		
		//�R���e�ˬd�ӥͪ����Z��ƬO�_���s�b�A���h����R��
		$sql_score="select count(*) from stud_seme_score where student_sn='$del_student_sn' ";
		$rs_score=$CONN->Execute($sql_score) or trigger_error($sql,256);
		$count_score=$rs_score->fields[0];
		if($count_score==0){  				

			//�N�ӥ�stud_base���R����		
			$del_msg.="---�������G".date("l dS of F Y h:i:s A")."---����H�G".$_SESSION['session_tea_name'] ."(".$_SESSION['session_log_id'] .")\n";
			$sql_del="delete from stud_base where student_sn='$del_student_sn' ";
			$rs_del=$CONN->Execute($sql_del) or trigger_error($sql_del,256);
			if($rs_del) {			
				$del_msg.="�R�� �y�y�����G$del_student_sn �z�A�y�Ǹ��G$stud_id �z ���ǥ͸�ƪ�\n";
			}

			//�N�ӥ�stud_seme���R����
			//$seme_year_seme=sprintf("%03d%d",$curr_year,$curr_seme);
			$sql_del2="delete from stud_seme where student_sn='$del_student_sn' ";
			$rs_del2=$CONN->Execute($sql_del2) or trigger_error($sql_del2,256);
			if($rs_del2) {			
				$del_msg.="�R�� �y�y�����G$del_student_sn �z�A�y�Ǹ��G$stud_id �z ���Ǵ���ƪ�\n";
			}

			//�N�ӥ�stud_domicile���R����
			$sql_del3="delete from stud_domicile where stud_id='$stud_id' and student_sn='$del_student_sn' ";
			$rs_del3=$CONN->Execute($sql_del3) or trigger_error($sql_del3,256);
			if($rs_del3) {			
				$del_msg.="�R�� �y�y�����G$del_student_sn �z�A�y�Ǹ��G$stud_id �z �����y��ƪ�\n";
			}

			$del_msg.="\n\n";


			//���K�g�J������YouKill.log
			$dir_name= $UPLOAD_PATH."/log";	
			if(!is_dir ($dir_name)) mkdir ("$dir_name", 0777);	
			$file_name= $dir_name."/YouKill.log..";	
			$FD=fopen ($file_name, "a");
			fwrite ($FD, $del_msg);	
			fclose ($FD);
			
			//���Ѹӥͥi�H�٭쪺sql�ɮ�
		}
		else $main.="�Ǹ� $stud_id �����Z��Ʀs�b�A����R���I<br>";
	}
}

//�إ߾Ǵ��A�Z�ſ��
/*
$class_seme_array=get_class_seme();
$class_seme_select.="<form action='{$_SERVER['PHP_SELF']}' method='POST' name='form1'>\n<select  name='class_seme' onchange='this.form.submit()'>\n";
$i=0;
foreach($class_seme_array as $k => $v){
	if(!$class_seme) $class_seme=sprintf("%03d%d",curr_year(),curr_seme());
	$selected[$i]=($class_seme==$k)?" selected":" ";	
	$class_seme_select.="<option value='$k'$selected[$i] >$v</option> \n";
	$i++;
}
$class_seme_select.="</select></form>\n";
*/

$class_base_array=class_base($class_seme);
$class_base_select.="<form action='{$_SERVER['PHP_SELF']}' method='POST' name='form2'>\n<select  name='class_base' onchange='this.form.submit()'>\n";
$j=0;
foreach($class_base_array as $k2 => $v2){
	if(!$class_base) $class_base=$k2;
	$selected2[$j]=($class_base==$k2)?" selected":" ";	
	$class_base_select.="<option value='$k2'$selected2[$j] >$v2</option> \n";
	$j++;
}
$class_base_select.="</select><input type='hidden' name='class_seme' value='$class_seme'></form>\n";
$menu="<td nowrap width='1%'>$class_seme_select</td><td nowrap>�Z�šG$class_base_select </td>";

//�C�X�򥻸�ƥH�ѧR��

//1.��X�y�����M�Ǹ�
$class_id=sprintf("%03d_%d_%02d_%02d",substr($class_seme,0,-1),substr($class_seme,-1),substr($class_base,0,-2),substr($class_base,-2));
$student_sn_array=class_id_to_student_sn($class_id);
$total=count($student_sn_array);
$main.="<table cellspacing=1 cellpadding=6 border=0  bgcolor='#00AB00' >
<form action='{$_SERVER['PHP_SELF']}' method='POST' name='D1'>
<tr bgcolor='#C4FAAE'><td><a href='{$_SERVER['PHP_SELF']}?choice_all=1&class_seme=$class_seme&class_base=$class_base'><font class='button'>����</font></a></td><td>�Ǹ�</td><td>�m�W</td><td>�y��</td></tr>
";
$checked=($_GET['choice_all']==1)?" checked":"";
$i=1;
foreach($student_sn_array as $sn_val){
	//��X�m�W�M�Ǹ��A�y��
	$st_data=student_sn_to_name_num($sn_val);		
	$main.="<tr bgcolor='#FFFFFF'><td><input type='checkbox' name='choice[$i]' value='$sn_val'$checked></td><td>".$st_data[0]."</td><td>".$st_data[1]."</td><td>".$st_data[2]."</td></tr>";
	$i++;
}
$main.="<tr bgcolor='#C4FAAE'><td colspan='4'>
<input type='hidden' name='sure_del' value='yes'>
<input type='hidden' name='class_seme' value='$class_seme'>
<input type='hidden' name='class_base' value='$class_base'>
<input type='button' value='�R��' onclick=\"if(confirm('�z�T�w�n�R���H')) this.form.submit()\">
</td></tr></form></table>";
//�]�w�D������ܰϪ��I���C��
$back_ground="
	<table cellspacing=1 cellpadding=0 border=0  bgcolor='#BBBBBB' width='100%'><tr><td>
	<table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFFFFF' width='100%'>
		<tr>
			$menu
		</tr>
		<tr>
			<td colspan='2'>
				$main
			</td>
		</tr>		
	</table></td></tr></table>";
echo $back_ground;

//�L�X���Y
foot();
?> 
