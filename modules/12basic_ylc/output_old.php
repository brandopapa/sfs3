<?php

include "config.php";

sfs_check();

//�Ǵ��O
$work_year_seme=$_REQUEST['work_year_seme'];
if($work_year_seme=='') $work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());
$academic_year=substr($curr_year_seme,0,-1);
$work_year=substr($work_year_seme,0,-1);
$session_tea_sn=$_SESSION['session_tea_sn'];


if($_POST['act']){
	//���o���w�Ǧ~�w�g�}�C���ǥͲM��
	$student_list_array=get_student_list($work_year);

	//���o�ǥͰ򥻸��
	$student_data=get_student_data($work_year);

	//���o���@�H���
	$domicile_data=get_domicile_data($work_year);

	//���o12basic_ylc�������
	$final_data=get_final_data($work_year);
	
	if($_POST['act']=='EXCEL'){
		require_once "../../include/sfs_case_excel.php";
		$x=new sfs_xls();
		$x->setUTF8();
		$x->filename=$SCHOOL_BASE['sch_id'].'_'.$school_long_name.'_Student�����.xls';
		$x->setBorderStyle(1);
		$x->addSheet('Student');
		$x->items[0]=array('1.�Z��','2.�y��','3.�ǥͩm�W','4.�����Ҹ�','5.�ʧO','6.�X�ͦ~','7.�X�ͤ�','8.�X�ͤ�','9.���~�Ǧ~��','10.�ǥͨ���','11.�C�����~','12.���@�H','13.�q��','14.�l���ϸ�','15.�q�T�B','16.���',
					'17.�g�ٮz��','18.�����p��','19.�N��J��','20.���y�O��','21.�X�ʮu�O��','22.�L�O�L�O��','23.���žǲ�','24.�v�ɦ��Z','25.��A��','26.������','27.�ƾǤ���','28.�^�y����','29.���|����','30.�۵M����');
	} else $main="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1'>
	<tr bgcolor='#ffcccc'><td>1.�Z��</td><td>2.�y��</td><td>3.�ǥͩm�W</td><td>4.�����Ҹ�</td><td>5.�ʧO</td><td>6.�X�ͦ~</td><td>7.�X�ͤ�</td><td>8.�X�ͤ�</td><td>9.���~�Ǧ~��</td><td>10.�ǥͨ���</td>
	<td>11.�C�����~</td><td>12.���@�H</td><td>13.�q��</td><td>14.�l���ϸ�</td><td>15.�q�T�B</td><td>16.���</td><td>17.�g�ٮz��</td><td>18.�����p��</td><td>19.�N��J��</td><td>20.���y�O��</td><td>21.�X�ʮu�O��</td><td>22.�L�O�L�O��</td>
	<td>23.���žǲ�</td><td>24.�v�ɦ��Z</td><td>25.��A��</td><td>26.������</td><td>27.�ƾǤ���</td><td>28.�^�y����</td><td>29.���|����</td><td>30.�۵M����</td>";
	
	//���o���w�Ǧ~�w�g�}�C���ǥͲM��
	$sql_select="SELECT a.student_sn,b.seme_class,b.seme_class_name,b.seme_num FROM 12basic_ylc a INNER JOIN stud_seme b ON a.student_sn=b.student_sn WHERE b.seme_year_seme='$work_year_seme' ORDER BY seme_class,seme_num";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while(!$recordSet->EOF){
		$student_sn=$recordSet->fields['student_sn'];
		$seme_class=substr($recordSet->fields['seme_class'],-2);
		$seme_class_name=$recordSet->fields['seme_class_name'];
		$seme_num=sprintf('%02d',$recordSet->fields['seme_num']);

		$birth_year=sprintf('%02d',$student_data[$student_sn]['birth_year']);
		$birth_month=sprintf('%02d',$student_data[$student_sn]['birth_month']);
		$birth_day=sprintf('%02d',$student_data[$student_sn]['birth_day']);
		$stud_name=str_replace(' ','',$student_data[$student_sn]['stud_name']);
		$stud_person_id=$student_data[$student_sn]['stud_person_id'];
		$stud_sex=$student_data[$student_sn]['stud_sex'];
		$stud_tel_2=$student_data[$student_sn]['stud_tel_2']?$student_data[$student_sn]['stud_tel_2']:$student_data[$student_sn]['stud_tel_1'];
		$stud_tel_3=$student_data[$student_sn]['stud_tel_3'];
		$addr_zip=$student_data[$student_sn]['addr_zip'];
		$stud_addr_2=$student_data[$student_sn]['stud_addr_2']?$student_data[$student_sn]['stud_addr_2']:$student_data[$student_sn]['stud_addr_1'];
		
		$guardian_name=$domicile_data[$student_sn]['guardian_name'];
		$guardian_phone=$domicile_data[$student_sn]['guardian_phone'];
		$guardian_hand_phone=$domicile_data[$student_sn]['guardian_hand_phone'];
		
		//$stud_tel_2=$guardian_phone?$guardian_phone:$stud_tel_2;
		//$stud_addr_2=$domicile_data[$student_sn]['guardian_address']?$domicile_data[$student_sn]['guardian_address']:$stud_addr_2;
		
		if(!strpos($guardian_hand_phone,'-')) $guardian_hand_phone=$guardian_hand_phone?substr_replace($guardian_hand_phone,'-',4,0):'';
		
		//�Ӹ�B�n
		if(!$full_personal_profile){
			$birth_day='00';
			$stud_name=substr($stud_name,0,-2).'��';
			//$stud_person_id=substr($stud_person_id,0,-4).'0000';
			$stud_tel_2=substr($stud_tel_2,0,-3).'888';
			$stud_addr_2=substr($stud_addr_2,0,18).'����������';
			$guardian_name=substr($guardian_name,0,-2).'��';
			$guardian_hand_phone=$guardian_hand_phone?substr($guardian_hand_phone,0,-3).'777':'';
		}
		
		//�p��12basic_ylc�������
		$kind_id=$final_data[$student_sn]['kind_id'];	
		$free_id=$final_data[$student_sn]['free_id'];
		//'17.�g�ٮz��','18.�����p��','19.�N��J��','20.���y�O��','21.�X�ʮu�O��','22.�L�O�L�O��','23.���žǲ�','24.�v�ɦ��Z','25.��A��','26.������','27.�ƾǤ���','28.�^�y����','29.���|����','30.�۵M����');		
		$score_disadvantage=$final_data[$student_sn]['score_disadvantage'];
		$score_remote=$final_data[$student_sn]['score_remote'];
		
		$score_reward=$final_data[$student_sn]['score_reward'];	 
		$score_absence=$final_data[$student_sn]['score_absence'];
		$score_fault=$final_data[$student_sn]['score_fault'];
		
		$score_balance=$final_data[$student_sn]['score_balance_health']+$final_data[$student_sn]['score_balance_art']+$final_data[$student_sn]['score_balance_complex'];	

		$score_competetion=$final_data[$student_sn]['score_competetion'];
		$score_fitness=$final_data[$student_sn]['score_fitness'];		
		
		$chinese=round($final_data[$student_sn]['score_exam_c']);
		$math=round($final_data[$student_sn]['score_exam_m']);
		$english=round($final_data[$student_sn]['score_exam_e']);
		$social=round($final_data[$student_sn]['score_exam_s']);
		$nature=round($final_data[$student_sn]['score_exam_n']); 		
		$write=$final_data[$student_sn]['score_exam_w'];
		
		if($_POST['act']=='EXCEL') $x->items[]=array($seme_class,$seme_num,$stud_name,$stud_person_id,$stud_sex,$birth_year,$birth_month,$birth_day,$work_year,$kind_id,$free_id,$guardian_name,$stud_tel_2,$addr_zip,$stud_addr_2,$stud_tel_3,$score_disadvantage,$score_remote,$school_nature,
			$score_reward,$score_absence,$score_fault,$score_balance,$score_competetion,$score_fitness,$chinese,$math,$english,$social,$nature);
		else $main.="<tr align='center'><td>$seme_class</td><td>$seme_num</td><td>$stud_name</td><td>$stud_person_id</td><td>$stud_sex</td><td>$birth_year</td><td>$birth_month</td><td>$birth_day</td><td>$work_year</td><td>$kind_id</td>
		<td>$free_id</td><td>$guardian_name</td><td>$stud_tel_2</td><td>$addr_zip</td><td>$stud_addr_2</td><td>$stud_tel_3</td><td>$score_disadvantage</td><td>$score_remote</td><td>$school_nature</td><td>$score_reward</td><td>$score_absence</td><td>$score_fault</td><td>$score_balance</td>
		<td>$score_competetion</td><td>$score_fitness</td><td>$chinese</td><td>$math</td><td>$english</td><td>$social</td><td>$nature</td></tr>";
		
		$recordSet->MoveNext();
	}
	
	if($_POST['act']=='EXCEL') {
		$x->writeSheet();
		$x->process();
	} else echo $main."</table>";
	exit;
}

//�q�X����
head("��ƶץX");
echo print_menu($MENU_P,$linkstr);
//���o�������~�ת��Ǵ����U�Կ��
$sql="SELECT DISTINCT academic_year FROM 12basic_ylc ORDER BY academic_year";
$rs=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
$radio_year_seme="";
while(!$rs->EOF)
{
	$academic_year=$rs->fields['academic_year'];
	$checked=($work_year==$academic_year)?'checked':'';
	$radio_year_seme.="<input type='radio' name='edit_remote' value=$academic_year $checked>$academic_year ";
	$rs->MoveNext();
}

echo "<form name='myform' method='post' action='$_SERVER[SCRIPT_NAME]'><br>���n��X���Ǧ~�G$radio_year_seme <br><br>���n��X���榡�G<input type='submit' name='act' value='HTML' onclick=\"document.myform.target='$academic_year'\"><input type='submit' name='act' value='EXCEL' onclick=\"document.myform.target=''\"></form>";

foot();
?>