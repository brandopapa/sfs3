<?php
//$Id: index.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";

//�{��
sfs_check();

//�q�X�����������Y
head("�ǥͦ��Z�d��");

//�D�n���e
if(empty($sel_year))$sel_year=curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme=curr_seme(); //�ثe�Ǵ�

//���o�ǥ͸��
$stud_data=stud_data($_SESSION[session_log_id]);

//���o���Ǵ��W���`���
$c_year=substr($stud_data[curr_class_num],0,-4);
$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
$class_id=sprintf("%03d_%d_%02d_%02d",$sel_year,$sel_seme,$c_year,substr($stud_data[curr_class_num],-4,2));
$query="select days from seme_course_date where seme_year_seme='$seme_year_seme' and class_year='$c_year'";
$res=$CONN->Execute($query) or die($query);
$TOTAL_DAYS=$res->fields[0];

//���o�Ҹռ˪O�s��
$exam_setup=&get_all_setup("",$sel_year,$sel_seme,$c_year);
$interface_sn=$exam_setup[interface_sn];

$main=&main_form($interface_sn,$sel_year,$sel_seme,$class_id,$_SESSION[session_log_id]);

echo $main;


//�G������
foot();

//�[�ݼҪO
function &main_form($interface_sn="",$sel_year="",$sel_seme="",$class_id="",$stud_id=""){
	global $CONN,$school_menu_p,$IS_JHORES;

	//�ഫ�Z�ťN�X
	$class=class_id_2_old($class_id);
	
	//�D�o�ǥ�ID	
	$student_sn=stud_id2student_sn($stud_id);

	//���o�Ӿǥͤ�`�ͬ���{���q��
	$oth_data=&get_oth_value($stud_id,$sel_year,$sel_seme);
	
	//���o�ǥͤ�`�ͬ���{���Ƥξɮv���y��ĳ
	$nor_data=get_nor_value($student_sn,$sel_year,$sel_seme);

	//���o�ǥͯʮu���p
	$abs_data=get_abs_value($stud_id,$sel_year,$sel_seme);
	
	if ($IS_JHORES!=0) {
		//���o�ǥͼ��g���p
		$reward_data = get_reward_value($stud_id,$sel_year,$sel_seme);
	}

	//���o�ǥͦ��Z��
	$score_data = &get_score_value($stud_id,$student_sn,$class_id,$oth_data);

	//���o�ԲӸ��
	$html=&html2code2($class,$sel_year,$sel_seme,$oth_data,$nor_data,$abs_data,$reward_data,$score_data,$student_sn);
	
	//���o���w�ǥ͸��
	$stu=student_sn_to_id_name_num($student_sn,$sel_year,$sel_seme);

	//���o�Ǯո��
	$s=get_school_base();
	$tool_bar=&make_menu($school_menu_p);

	$main="
	$tool_bar
	<table bgcolor='#DFDFDF' cellspacing=1 cellpadding=4>
	<tr class='small'><td bgcolor='#FFFFFF' valign='top'>
	<p align='center'>
	<font size=3>".$s[sch_cname]." ".$sel_year."�Ǧ~�ײ�".$sel_seme."�Ǵ����Z��</p>
	<table align=center cellspacing=4>
	<tr>
	<td>�Z�šG<font color='blue'>$class[5]</font></td><td width=40></td>
	<td>�y���G<font color='green'>".sprintf("%02d",$stu[2])."</font></td><td width=40></td>
	<td>�m�W�G<font color='red'>$stu[1]</font></td>
	</tr></table></font>
	$html
	</td></tr></table>
	";

	return $main;
}
?>
