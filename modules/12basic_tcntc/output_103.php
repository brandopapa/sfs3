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

//echo '<pre>';	
//print_r($graduate_data);
//echo '<pre>';
	
	//���o12basic_tcntc�������
	$final_data=get_final_data($work_year);
	
	//�s�@���Y
	switch($_POST['act']){
		case 'EXCEL':
			$x=new sfs_xls();
			$x->setUTF8();
			$x->filename=$SCHOOL_BASE['sch_id'].'_'.$school_long_name.'_�ۥͨt�ξǥ͸����.xls';
			$x->setBorderStyle(1);
			$x->addSheet($school_id);
			$x->items[0]=array('�ҰϥN�X','�������N�X','�Ǹ�','�Ǹ�','�Z��','�y��','�ǥͩm�W','�����ҲΤ@�s��','�ʧO','�X�ͦ~(����~)','�X�ͤ�','�X�ͤ�','���~�ǮեN�X','���~�~(����~)','���w�~','�ǥͨ���','���߻�ê','�N�ǰ�','�C���J��','���C���J��','���~�Ҥu�l�k','��Ʊ��v','�a���m�W','�����q��','��ʹq��','�l���ϸ�','�q�T�a�}','�����O�_�t���y�{��','�N��J��','�����a��','���d�P��|','���N�P�H��','��X����','�O�L����','�j�\���','�p�\���','�ż����','�A�Ⱦǲ߱o��','���αo��');  //'�ߧU�z��','���žǲ�','�w���{','�L�O�L����','���y����'
			break;
		case 'HTML':
			$main="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1' width='200%'>
				<tr bgcolor='#ffcccc' align='center'><td>�ҰϥN�X</td><td>�������N�X</td><td>�Ǹ�</td><td>�Ǹ�</td><td>�Z��</td><td>�y��</td><td>�ǥͩm�W</td><td>�����ҲΤ@�s��</td><td>�ʧO</td><td>�X�ͦ~(����~)</td><td>�X�ͤ�</td><td>�X�ͤ�</td><td>���~�ǮեN�X</td><td>���~�~(����~)</td><td>���w�~</td><td>�ǥͨ���</td><td>���߻�ê</td><td>�N�ǰ�</td><td>�C���J��</td><td>���C���J��</td><td>���~�Ҥu�l�k</td><td>��Ʊ��v</td><td>�a���m�W</td><td>�����q��</td><td>��ʹq��</td><td>�l���ϸ�</td><td>�q�T�a�}</td><td>�����O�_�t���y�{��</td><td>�N��J��</td><td>�����a��</td><td>���d�P��|</td><td>���N�P�H��</td><td>��X����</td><td>�O�L����</td><td>�j�\���</td><td>�p�\���</td><td>�ż����</td><td>�A�Ⱦǲ߱o��</td><td>���αo��</td>";
			break;
	}

	//���o���w�Ǧ~�w�g�}�C���ǥͲM��
	$sql_select="SELECT a.student_sn,b.stud_id,b.seme_class,b.seme_class_name,b.seme_num FROM 12basic_tcntc a INNER JOIN stud_seme b ON a.student_sn=b.student_sn WHERE b.seme_year_seme='$work_year_seme' ORDER BY seme_class,seme_num";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while(!$recordSet->EOF){
		$student_sn=$recordSet->fields['student_sn'];
		$stud_study_cond=$student_data[$student_sn]['stud_study_cond'];
		if($stud_study_cond==0 or $stud_study_cond==15) {
			$no++;
			$stud_id=$recordSet->fields['stud_id'];
			$seme_class=substr($recordSet->fields['seme_class'],-2);
			$seme_class_name=$recordSet->fields['seme_class_name'];
			$seme_num=sprintf('%02d',$recordSet->fields['seme_num']);

			$birth_year=sprintf('%02d',$student_data[$student_sn]['birth_year']);
			$birth_month=sprintf('%02d',$student_data[$student_sn]['birth_month']);
			$birth_day=sprintf('%02d',$student_data[$student_sn]['birth_day']);
			$stud_name=str_replace(' ','',$student_data[$student_sn]['stud_name']);
			$stud_person_id=$student_data[$student_sn]['stud_person_id'];
			$stud_sex=$student_data[$student_sn]['stud_sex'];
			
			//���׷~
			$graduate=($graduate_data[$student_sn]==1)?1:0;
			
			//�ǥ��p����ƳB�z
			$addr_zip=$student_data[$student_sn]['addr_zip'];
			if($data_source) { 
				$guardian_phone=$student_data[$student_sn][$tel_family];
				$guardian_hand_phone=$student_data[$student_sn][$tel_mobile];
				$guardian_address=$student_data[$student_sn][$address_family];		
			} else {	//���]�w�h�̷ӭ�����P�_����
				$stud_tel_2=$student_data[$student_sn]['stud_tel_2']?$student_data[$student_sn]['stud_tel_2']:$student_data[$student_sn]['stud_tel_1'];
				$stud_addr_2=$student_data[$student_sn]['stud_addr_2']?$student_data[$student_sn]['stud_addr_2']:$student_data[$student_sn]['stud_addr_1'];
				
				$guardian_name=$domicile_data[$student_sn]['guardian_name'];
				$guardian_phone=$domicile_data[$student_sn]['guardian_phone'];
				$guardian_hand_phone=$domicile_data[$student_sn]['guardian_hand_phone']?$domicile_data[$student_sn]['guardian_hand_phone']:$student_data[$student_sn]['stud_tel_3'];

				$guardian_phone=$guardian_phone?$guardian_phone:$stud_tel_2;
				$guardian_address=$domicile_data[$student_sn]['guardian_address']?$domicile_data[$student_sn]['guardian_address']:$stud_addr_2;
			}

			
			//if(!strpos($guardian_hand_phone,'-')) $guardian_hand_phone=$guardian_hand_phone?substr_replace($guardian_hand_phone,'-',4,0):''; 
			
			//�̾ڼҲճ]�w�i��Ӹ�B�n
			if(!$full_personal_profile){
				$birth_day='00';
				$stud_name=substr($stud_name,0,-2).'��';
				$stud_person_id=substr($stud_person_id,0,-4).'0000';
				$guardian_phone=substr($stud_tel_2,0,-3).'888';
				$guardian_address=substr($guardian_address,0,18).'����������';
				$guardian_name=substr($guardian_name,0,-2).'��';
				$guardian_hand_phone=$guardian_hand_phone?substr($guardian_hand_phone,0,-3).'777':'';
			}
			
			//�۰ʥh�� - ( ) �r��
			$search  = array('-', '(', ')',' ');
			$replace = array('', '', '','');
			$guardian_phone=str_replace($search, $replace,$guardian_phone);
			$guardian_hand_phone=str_replace($search,$replace,$guardian_hand_phone);	
			
			//�p��12basic_tcntc�������
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

			$score_disadvantage=$final_data[$student_sn]['score_remote']+$final_data[$student_sn]['score_disadvantage'];
			$score_balance=$final_data[$student_sn]['score_balance_health']+$final_data[$student_sn]['score_balance_art']+$final_data[$student_sn]['score_balance_complex'];
			$score_morality=$final_data[$student_sn]['score_association']+$final_data[$student_sn]['score_service'];
			$score_fault=$final_data[$student_sn]['score_fault'];
			$score_reward=$final_data[$student_sn]['score_reward'];
			
			//�t�X�ۥͲο�X�ݭn��
			$score_remote=$final_data[$student_sn]['score_remote'];
			$score_balance_health=$final_data[$student_sn]['score_balance_health'];
			$score_balance_art=$final_data[$student_sn]['score_balance_art'];
			$score_balance_complex=$final_data[$student_sn]['score_balance_complex'];
			$score_association=$final_data[$student_sn]['score_association'];
			$score_service=$final_data[$student_sn]['score_service'];
			$language_certified=$final_data[$student_sn]['language_certified'];
			//������y���
			$reward_list=get_student_reward_list($work_year);
			$reward_1=$reward_list[$student_sn][1]?$reward_list[$student_sn][1]:0;
			$reward_3=$reward_list[$student_sn][3]?$reward_list[$student_sn][3]:0;
			$reward_9=$reward_list[$student_sn][9]?$reward_list[$student_sn][9]:0;
	/*		
	echo '<pre>';
	print_r($final_data);
	echo '</pre>';
	exit;
	*/		
			//��X���
			$graduate_year=$work_year+1;
			switch($_POST['act']){
				case 'EXCEL':
					$x->items[]=array($area_code,$school_id,$no,$stud_id,$seme_class,$seme_num,$stud_name,$stud_person_id,$stud_sex,$birth_year,$birth_month,$birth_day,$school_id,$graduate_year,$graduate,$kind_id,$disability_id,'',$free_1,$free_2,$free_3,0,$guardian_name,$guardian_phone,$guardian_hand_phone,$addr_zip,$guardian_address,$language_certified,$school_nature,$score_remote,$score_balance_health,$score_balance_art,$score_balance_complex,$score_fault,$reward_9,$reward_3,$reward_1,$score_service,$score_association); //,$score_fault,$score_reward
					break;
				case 'HTML':
					$main.="<tr align='center'><td>$area_code</td><td>$school_id</td><td>$no</td><td>$stud_id</td><td>$seme_class</td><td>$seme_num</td><td>$stud_name</td><td>$stud_person_id</td><td>$stud_sex</td><td>$birth_year</td><td>$birth_month</td><td>$birth_day</td><td>$school_id</td><td>$graduate_year</td><td>$graduate</td><td>$kind_id</td><td>$disability_id</td><td></td><td>$free_1</td><td>$free_2</td><td>$free_3</td><td>0</td><td>$guardian_name</td><td>$guardian_phone</td><td>$guardian_hand_phone</td><td>$addr_zip</td><td align='left'>$guardian_address</td>
						<td>$language_certified</td><td>$school_nature</td><td>$score_remote</td><td>$score_balance_health</td><td>$score_balance_art</td><td>$score_balance_complex</td><td>$score_fault</td><td>$reward_9</td><td>$reward_3</td><td>$reward_1</td><td>$score_service</td><td>$score_association</td></tr>";  //<td>$score_fault</td><td>$score_reward</td>
					break;
			}
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
head("�ۥͨt�θ�ƶץX");
echo print_menu($MENU_P,$linkstr);
//���o�������~�ת��Ǵ����U�Կ��
$sql="SELECT DISTINCT academic_year FROM 12basic_tcntc ORDER BY academic_year";
$rs=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
$radio_year_seme="";
while(!$rs->EOF)
{
	$academic_year=$rs->fields['academic_year'];
	$checked=($work_year==$academic_year)?'checked':'';
	$radio_year_seme.="<input type='radio' name='edit_remote' value=$academic_year $checked>$academic_year ";
	$rs->MoveNext();
}

$data="����X�榡�G<input type='submit' name='act' value='HTML' onclick=\"document.myform.target='$academic_year'\"> <input type='submit' name='act' value='EXCEL' onclick=\"document.myform.target=''\">";

if($full_sealed_check) {
	//�ˬd�O�_���i�ק�������ѻP�K�վǥ�
	$editable_sn_array=get_editable_sn($work_year);
	if($editable_sn_array) $data="<font size=5 color='red'><br><br><center>���ǥ͸�Ʃ|���ʦs�I<br>�Ҳ��ܼƳ]�w�z�������ʦs�Ҧ���Ƥ~�i�H�i���X�C</center></font>";
}
	
echo "<form name='myform' method='post' action='$_SERVER[SCRIPT_NAME]'><br>���n��X���Ǧ~�G$radio_year_seme	<br><br>$data</form>";

foot();
?>