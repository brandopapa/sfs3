<?php

include "config.php";
require_once "../../include/sfs_case_excel.php";

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
	
	//���o���~���
	$graduate_data=get_graduate_data($work_year);

	//���o12basic_ylc�������
	$final_data=get_final_data($work_year);
	
	//�s�@���Y
	switch($_POST['act']){
		case 'EXCEL':
			$x=new sfs_xls();
			$x->setUTF8();
			$x->filename=$SCHOOL_BASE['sch_id'].'_'.$school_long_name.'_�ձ��t�ξǥ͸����.xls';
			$x->setBorderStyle(1);
			$x->addSheet($school_id);
			$x->items[0]=array('�a�ϥN�X','�������N�X','�Ǹ�','�Ǹ�','�Z��','�y��','�ǥͩm�W','�����ҲΤ@�s��','�ʧO','�X�ͦ~(����~)','�X�ͤ�','�X�ͤ�','���~�ǮեN�X','���~�~(����~)','���w�~','�ǥͨ���','���߻�ê','�N�ǰ�','�C���J��','���C���J��','���~�Ҥu','��Ʊ��v','�a���m�W','�����q��','��ʹq��','�l���ϸ�','�a�}');
			break;
		case 'HTML':
			$main="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1'>
				<tr bgcolor='#ffcccc' align='center'><td>�a�ϥN�X</td><td>�������N�X</td><td>�Ǹ�</td><td>�Ǹ�</td><td>�Z��</td><td>�y��</td><td>�ǥͩm�W</td><td>�����ҲΤ@�s��</td><td>�ʧO</td><td>�X�ͦ~(����~)</td><td>�X�ͤ�</td><td>�X�ͤ�</td><td>���~�ǮեN�X</td><td>���~�~(����~)</td><td>���w�~</td><td>�ǥͨ���</td><td>���߻�ê</td><td>�N�ǰ�</td><td>�C���J��</td><td>���C���J��</td><td>���~�Ҥu</td><td>��Ʊ��v</td><td>�a���m�W</td><td>�����q��</td><td>��ʹq��</td><td>�l���ϸ�</td><td>�a�}</td>";
			break;
			
		case 'EXCEL_SCORE':
			$x=new sfs_xls();
			$x->setUTF8();
			$x->filename=$SCHOOL_BASE['sch_id'].'_'.$school_long_name.'_�ձ��t�ζ��ؿn�������.xls';
			$x->setBorderStyle(1);
			$x->addSheet($school_id);
			$x->items[0]=array('�ǥͩm�W','�����Ҹ�','�X�ͦ~','�X�ͤ�','�X�ͤ�','�g�ٮz��','�����p��','�N��J��','���y�O��','�X�ʮu�O��','�L�O�L�O��','���žǲ�','�v�ɦ��Z','��A��');
			break;	
		case 'HTML_SCORE':
			$main="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1'>
				<tr bgcolor='#ffcccc'><td>�ǥͩm�W</td><td>�����Ҹ�</td><td>�X�ͦ~</td><td>�X�ͤ�</td><td>�X�ͤ�</td><td>�g�ٮz��</td><td>�����p��</td><td>�N��J��</td><td>���y�O��</td><td>�X�ʮu�O��</td><td>�L�O�L�O��</td><td>���žǲ�</td><td>�v�ɦ��Z</td><td>��A��</td>";
			break;	
	}

	//���o���w�Ǧ~�w�g�}�C���ǥͲM��
	$sql_select="SELECT a.student_sn,b.stud_id,b.seme_class,b.seme_class_name,b.seme_num FROM 12basic_ylc a INNER JOIN stud_seme b ON a.student_sn=b.student_sn WHERE b.seme_year_seme='$work_year_seme' ORDER BY seme_class,seme_num";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while(!$recordSet->EOF){
		$no++;
		$student_sn=$recordSet->fields['student_sn'];
		$stud_id=$recordSet->fields['stud_id'];
		$seme_class=$recordSet->fields['seme_class'];
		$seme_class=substr($seme_class, -2);
		$seme_class_name=$recordSet->fields['seme_class_name'];
		$seme_num=sprintf('%02d',$recordSet->fields['seme_num']);

		$birth_year=sprintf('%02d',$student_data[$student_sn]['birth_year']);
		$birth_month=sprintf('%02d',$student_data[$student_sn]['birth_month']);
		$birth_day=sprintf('%02d',$student_data[$student_sn]['birth_day']);
		$stud_name=str_replace(' ','',$student_data[$student_sn]['stud_name']);
		$stud_person_id=$student_data[$student_sn]['stud_person_id'];
		//$stud_sex=$student_data[$student_sn]['stud_sex']==1?'�k':'�k';
		$stud_sex=$student_data[$student_sn]['stud_sex'];
		//���׷~�Ť�
		//$graduate=$graduate_score[$graduate_data[$student_sn]];
		$graduate=1;
		
		//�ǥ��p����ƳB�z		
		$stud_tel_2=$student_data[$student_sn]['stud_tel_2']?$student_data[$student_sn]['stud_tel_2']:$student_data[$student_sn]['stud_tel_1'];
		$addr_zip=$student_data[$student_sn]['addr_zip'];
		$stud_addr_2=$student_data[$student_sn]['stud_addr_2']?$student_data[$student_sn]['stud_addr_2']:$student_data[$student_sn]['stud_addr_1'];
		
		$guardian_name=$domicile_data[$student_sn]['guardian_name'];
		$guardian_phone=$domicile_data[$student_sn]['guardian_phone'];
		$guardian_hand_phone=$domicile_data[$student_sn]['guardian_hand_phone']?$domicile_data[$student_sn]['guardian_hand_phone']:$student_data[$student_sn]['stud_tel_3'];

		$guardian_phone=$guardian_phone?$guardian_phone:$stud_tel_2;
		$guardian_address=$domicile_data[$student_sn]['guardian_address']?$domicile_data[$student_sn]['guardian_address']:$stud_addr_2;
		
	
		//if(!strpos($guardian_hand_phone,'-')) $guardian_hand_phone=$guardian_hand_phone?substr_replace($guardian_hand_phone,'-',4,0):''; 
		
		//�̾ڼҲճ]�w�i��Ӹ�B�n
		if(!$full_personal_profile){
			$birth_day='00';
			$stud_name=substr($stud_name,0,-2).'��';
			$stud_person_id=substr($stud_person_id,0,-4).'0000';
			$stud_tel_2=substr($stud_tel_2,0,-3).'888';
			$stud_addr_2=substr($stud_addr_2,0,18).'����������';
			$guardian_name=substr($guardian_name,0,-2).'��';
			$guardian_hand_phone=$guardian_hand_phone?substr($guardian_hand_phone,0,-3).'777':'';
		}
		
		//�۰ʥh�� - ( ) �r��
		$search  = array('-', '(', ')',' ');
		$replace = array('', '', '','');
		$guardian_phone=str_replace($search, $replace,$guardian_phone);
		$guardian_hand_phone=str_replace($search, $replace,$guardian_hand_phone);	
		
		//�p��12basic_ylc�������
		$kind_id=$final_data[$student_sn]['kind_id'];
		$disability_id=$final_data[$student_sn]['disability_id'];	
		$free_id=$final_data[$student_sn]['free_id'];
		
		//�C�����~		
		switch($free_id){
			case 0: $free_1=0; $free_2=0; $free_3=0; break;
			case 1: $free_1=1; $free_2=0; $free_3=0; break;
			case 2: $free_1=0; $free_2=1; $free_3=0; break;
			case 3: $free_1=0; $free_2=0; $free_3=1; break;		
		}
		
		//��Ʊ��v
		$authorize = 1;

		$score_disadvantage=$final_data[$student_sn]['score_disadvantage'];
		$score_remote=$final_data[$student_sn]['score_remote'];
		$score_balance=$final_data[$student_sn]['score_balance_health']+$final_data[$student_sn]['score_balance_art']+$final_data[$student_sn]['score_balance_complex'];	
		$score_service=$final_data[$student_sn]['score_service'];
		$score_reward=$final_data[$student_sn]['score_reward'];
		$score_absence=$final_data[$student_sn]['score_absence'];
		$score_fault=$final_data[$student_sn]['score_fault'];
		$score_competetion=$final_data[$student_sn]['score_competetion'];
		$score_fitness=$final_data[$student_sn]['score_fitness'];
		$score_personality=$final_data[$student_sn]['score_my_aspiration']+$final_data[$student_sn]['score_domicile_suggestion']+$final_data[$student_sn]['score_guidance_suggestion'];
		/*
		$chinese=$final_data[$student_sn]['score_exam_c'];
		$english=$final_data[$student_sn]['score_exam_e'];
		$math=$final_data[$student_sn]['score_exam_m'];
		$social=$final_data[$student_sn]['score_exam_s'];
		$nature=$final_data[$student_sn]['score_exam_n'];
		*/
		
		$card_no=$final_data[$student_sn]['card_no'];

		//'�a�ϥN�X','�������N�X','�Ǹ�','�Ǹ�','�Z��','�y��','�ǥͩm�W','�����ҲΤ@�s��','�ʧO','�X�ͦ~(����~)','�X�ͤ�','�X�ͤ�','���~�ǮեN�X','���~�~(����~)','���w�~','�ǥͨ���','���߻�ê','�N�ǰ�','�C���J��','���C���J��','���~�Ҥu','��Ʊ��v','�a���m�W','�����q��','��ʹq��','�l���ϸ�','�a�}'
		
		//��X���
		switch($_POST['act']){
			case 'EXCEL':
				$x->items[]=array($area_code,$school_id,$no,$stud_id,$seme_class,$seme_num,$stud_name,$stud_person_id,$stud_sex,$birth_year,$birth_month,$birth_day,$school_id,$work_year,$graduate,$kind_id,$disability_id,'',$free_1,$free_2,$free_3,$authorize,$guardian_name,$guardian_phone,$guardian_hand_phone,$addr_zip,$stud_addr_2);
				break;
			case 'HTML':
				$main.="<tr align='center'><td>$area_code</td><td>$school_id</td><td>$no</td><td>$stud_id</td><td>$seme_class</td><td>$seme_num</td><td>$stud_name</td><td>$stud_person_id</td><td>$stud_sex</td><td>$birth_year</td><td>$birth_month</td><td>$birth_day</td><td>$school_id</td><td>$work_year</td><td>$graduate</td><td>$kind_id</td><td>$disability_id</td><td></td><td>$free_1</td><td>$free_2</td><td>$free_3</td><td>$authorize</td><td>$guardian_name</td><td>$guardian_phone</td><td>$guardian_hand_phone</td><td>$addr_zip</td><td>$stud_addr_2</td></tr>";
				break;
			case 'EXCEL_SCORE':
				$x->items[]=array($stud_name,$stud_person_id,$birth_year,$birth_month,$birth_day,$score_disadvantage,$score_remote,$school_nature,$score_reward,$score_absence,$score_fault,$score_balance,$score_competetion,$score_fitness);
				break;
			case 'HTML_SCORE':
				$main.="<tr align='center'><td>$stud_name</td><td>$stud_person_id</td><td>$birth_year</td><td>$birth_month</td><td>$birth_day</td><td>$score_disadvantage</td><td>$score_remote</td><td>$school_nature</td><td>$score_reward</td><td>$score_absence</td><td>$score_fault</td><td>$score_balance</td><td>$score_competetion</td><td>$score_fitness</td></tr>";
				break;
		}
		$recordSet->MoveNext();
	}
	
	
	if(substr($_POST['act'],0,5)=='EXCEL') {
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

$data="���ǥͰ򥻸���ɡG<input type='submit' name='act' value='HTML' onclick=\"document.myform.target='$academic_year'\"> <input type='submit' name='act' value='EXCEL' onclick=\"document.myform.target=''\">
	<br><br>����Ƕ��ؿn������ɡG<input type='submit' name='act' value='HTML_SCORE' onclick=\"document.myform.target='$academic_year'\"> <input type='submit' name='act' value='EXCEL_SCORE' onclick=\"document.myform.target=''\">";

if($full_sealed_check) {
	//�ˬd�O�_���i�ק�������ѻP�K�վǥ�
	$editable_sn_array=get_editable_sn($work_year);
	if($editable_sn_array) $data="<font size=5 color='red'><br><br><center>���ǥ͸�Ʃ|���ʦs�I<br>�Ҳ��ܼƳ]�w�z�������ʦs�Ҧ���Ƥ~�i�H�i���X�C</center></font>";
}
	
echo "<form name='myform' method='post' action='$_SERVER[SCRIPT_NAME]'><br>���n��X���Ǧ~�G$radio_year_seme	<br><br>$data</form>";

foot();
?>