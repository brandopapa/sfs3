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
	$_POST['selected_stud']=get_student_list($academic_year);

	//���o12basic_tech�������
	$final_data=get_final_data($work_year);
	
	//���o�ǥͰ򥻸��
	$student_data=get_student_data($work_year);

	//���o���@�H���
	$domicile_data=get_domicile_data($work_year);
	
	//����v�ɬ���
	$competetion_score=count_student_score_competetion($_POST['selected_stud']);
	//echo '<pre>';
	//print_r($competetion_score);
	//echo '</pre>';
	
	$service_score=count_student_score_service($_POST['selected_stud']);
	//echo '<pre>';
	//print_r($service_score);
	//echo '</pre>';
	
	$fault_score=count_student_score_fault($_POST['selected_stud']);
	//echo '<pre>';
	//print_r($fault_score);
	//echo '</pre>';
	
	$fitness_score=count_student_score_fitness($_POST['selected_stud']);
	//echo '<pre>';
	//print_r($fitness_score);
	//echo '</pre>';
	
	//�p��h���ǲߤW��
    foreach($_POST['selected_stud'] as $student_sn) {
        $diversification_score[$student_sn]=min($diversification_score_max,$competetion_score[$student_sn]['score']+$service_score[$student_sn]['bonus']+$fault_score[$student_sn]['bonus']+$fitness_score[$student_sn]['bonus']);
		$diversification_score[$student_sn]=sprintf("%2.1f",$diversification_score[$student_sn]);
	}

	
	$particular_score=get_student_particular($work_year);
	//echo '<pre>';
	//print_r($particular_score);
	//echo '</pre>';
	
	$disadvantage_score=get_student_disadvantage($work_year);
	//echo '<pre>';
	//print_r($disadvantage_score);
	//echo '</pre>';
	
	//���o���w�Ǧ~�w�g�}�C���ǥͦh���ǲߪ�����
	$balance_score_t=get_student_balance($work_year);
	//echo '<pre>';
	//print_r($balance_score_t);
	//echo '</pre>';
	
	$balance_area_score=get_student_score_balance($_POST['selected_stud']);
	//echo '<pre>';
	//print_r($balance_area_score);
	//echo '</pre>';

	//���o���w�Ǧ~�w�g�}�C���A�ʻ��ɤ���
	$personality_score=get_student_personality($work_year);	
	//echo '<pre>';
	//print_r($personality_score);
	//echo '</pre>';
	
	//���o���w�Ǧ~�w�g�}�C���Ш|�|�Ҥ���
	$exam_score=get_exam_data($work_year);
	//echo '<pre>';
	//print_r($exam_score);
	//echo '</pre>';
	
	//���o���w�Ǧ~�w�g�}�C����L����
	$others_score=get_student_others($work_year);
	//echo '<pre>';
	//print_r($others_score);
	//echo '</pre>';
	
	//���o���w�Ǧ~�w�g�}�C�����W�Ǯ�
	$student_signup=get_student_signup($work_year);
	//echo '<pre>';
	//print_r($student_signup);
	//echo '</pre>';
	

	//�s�@���Y
	switch($_POST['act']){
		case 'EXCEL':
			$x=new sfs_xls();
			$x->setUTF8();
			$x->filename=$SCHOOL_BASE['sch_id'].'_'.$school_long_name.'_���M�K�թۥͨt�ξǥ͸����.xls';
			$x->setBorderStyle(1);
			$x->addSheet($school_id);
			$x->items[0]=array('�����ҲΤ@�s��','�ǥͩm�W','�X�ͦ~(����~)','�X�ͤ�','�X�ͤ�','�~��','�Z��','�y��','���W���','�l���ϸ�','�a�}','�����q��','��ʹq��','�S�إͥ[�����O','���W�O��K����','�v��','����F��','�A�Ȯɼ�','�A�Ⱦǲ�','�֭p�ż�','�֭p�p�\ ','�֭p�j�\ ','�֭pĵ�i','�֭p�p�L','�֭p�j�L','��`�ͬ���{���q','�٭@�O','�X�n��','���o�O','�ߪͭ@�O','��A��','�h���ǲߪ�{','�����Ш|���Z','�����u�}','�z�ը���','�z�տn��','���d�P��|','���N�P�H��','��X����','���žǲ�','�a���N��','�ɮv�N��','���ɱЮv�N��','�A�ʻ���','��L��Ƕ���(�����^��)','�X�p','���W�u�_�ϡv���M�ǮեN�X','���W�u���ϡv���M �ǮեN�X','���W�u�n�ϡv���M�ǮեN�X','�v�ɦW��','��L��Ƕ���(�h�q����)'); 
			break;
		case 'HTML':
			$main="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1' width='200%'>
				<tr bgcolor='#ffcccc' align='center'><td>�����ҲΤ@�s��</td><td>�ǥͩm�W</td><td>�X�ͦ~(����~)</td><td>�X�ͤ�</td><td>�X�ͤ�</td><td>�~��</td><td>�Z��</td><td>�y��</td><td>���W���</td><td>�l���ϸ�</td><td>�a�}</td><td>�����q��</td><td>��ʹq��</td><td>�S�إͥ[�����O</td><td>���W�O��K����</td><td>�v��</td><td>����F��</td><td>�A�Ȯɼ�</td><td>�A�Ⱦǲ�</td><td>�֭p�ż�</td><td>�֭p�p�\ </td><td>�֭p�j�\ </td><td>�֭pĵ�i</td><td>�֭p�p�L</td><td>�֭p�j�L</td><td>��`�ͬ���{���q</td><td>�٭@�O</td><td>�X�n��</td><td>���o�O</td><td>�ߪͭ@�O</td><td>��A��</td><td>�h���ǲߪ�{</td><td>�����Ш|���Z</td><td>�����u�}</td><td>�z�ը���</td><td>�z�տn��</td><td>���d�P��|</td><td>���N�P�H��</td><td>��X����</td><td>���žǲ�</td><td>�a���N��</td><td>�ɮv�N��</td><td>���ɱЮv�N��</td><td>�A�ʻ���</td><td>��L��Ƕ���(�����^��)</td><td>�X�p</td><td>���W�u�_�ϡv���M�ǮեN�X</td><td>���W�u���ϡv���M �ǮեN�X</td><td>���W�u�n�ϡv���M�ǮեN�X</td><td>�v�ɦW��</td><td>��L��Ƕ���(�h�q����)</td>";
			break;
	}
	
	//���o���w�Ǧ~�w�g�}�C���ǥͲM��
	$sql_select="SELECT a.student_sn,b.stud_id,b.seme_class,b.seme_class_name,b.seme_num FROM 12basic_tech a INNER JOIN stud_seme b ON a.student_sn=b.student_sn WHERE b.seme_year_seme='$work_year_seme' ORDER BY seme_class,seme_num";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while(!$recordSet->EOF){
		$student_sn=$recordSet->fields['student_sn'];
		$stud_study_cond=$student_data[$student_sn]['stud_study_cond'];
		if($stud_study_cond==0 or $stud_study_cond==15) {
			$no++;
			$stud_id=$recordSet->fields['stud_id'];
			$seme_grade=substr($recordSet->fields['seme_class'],0,1);
			$seme_class=substr($recordSet->fields['seme_class'],-2);
			$seme_class_name=$recordSet->fields['seme_class_name'];
			$seme_num=sprintf('%02d',$recordSet->fields['seme_num']);

			$birth_year=sprintf('%02d',$student_data[$student_sn]['birth_year']);
			$birth_month=sprintf('%02d',$student_data[$student_sn]['birth_month']);
			$birth_day=sprintf('%02d',$student_data[$student_sn]['birth_day']);
			$stud_name=str_replace(' ','',$student_data[$student_sn]['stud_name']);
			$stud_person_id=$student_data[$student_sn]['stud_person_id'];
			//$stud_sex=$student_data[$student_sn]['stud_sex'];
			
			//���׷~
			//$graduate=($graduate_data[$student_sn]==1)?1:0;
			
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
			
			
			//�p��12basic_tech�������
			$kind_id=$final_data[$student_sn]['kind_id'];
			$disability_id=$final_data[$student_sn]['disability_id'];	
			$free_id=$final_data[$student_sn]['free_id'];
			
			//���ϧ��@
			$signup_north=$student_signup[$student_sn]['item']['north'];
			$signup_central=$student_signup[$student_sn]['item']['central'];
			$signup_south=$student_signup[$student_sn]['item']['south'];
			
			//��L��Ƕ���
			$others_item=unserialize($others_score[$student_sn]['item']);
			$GEPT=$others_item['GEPT']?$others_item['GEPT']:0;
			$TOEIC=$others_item['TOEIC']?$others_item['TOEIC']:0;
			
			
			//����v�ɬ�������   {$level_array[$data.level]}}-{{$squad_array[$data.squad]}}){{$data.name}}�G{{$data.rank}
			$competetion_list='';
			foreach($competetion_score[$student_sn]['detail'] as $key=>$data){
				$competetion_list.=$level_array[$data['level']].'-'.$squad_array[$data['squad']].' '.$data['name'].'�G'.$data['rank'].'�F';			
			}
			
			//�X�p����
			$bonus_total=$diversification_score[$student_sn]+$particular_score[$student_sn]['bonus']+$disadvantage_score[$student_sn]['score']+$balance_score_t[$student_sn]['score']+$personality_score[$student_sn]['bonus'];
			$bonus_total=sprintf("%2.1f",$bonus_total);
			
			//�S��Ʊj���X0
			$competetion_score[$student_sn][score]=$competetion_score[$student_sn][score]?sprintf("%1.1f",$competetion_score[$student_sn][score]):'0.0';
			
			$service_score[$student_sn]['leader']=$service_score[$student_sn]['leader']?$service_score[$student_sn]['leader']:0;
			$service_score[$student_sn]['hours']=$service_score[$student_sn]['hours']?$service_score[$student_sn]['hours']:0;
			$service_score[$student_sn]['bonus']=$service_score[$student_sn]['bonus']?$service_score[$student_sn]['bonus']:0;
			
			$fault_score[$student_sn][1]=$fault_score[$student_sn][1]?$fault_score[$student_sn][1]:0;
			$fault_score[$student_sn][3]=$fault_score[$student_sn][3]?$fault_score[$student_sn][3]:0;
			$fault_score[$student_sn][9]=$fault_score[$student_sn][9]?$fault_score[$student_sn][9]:0;
			$fault_score[$student_sn]['a']=$fault_score[$student_sn]['a']?$fault_score[$student_sn]['a']:0;
			$fault_score[$student_sn]['b']=$fault_score[$student_sn]['b']?$fault_score[$student_sn]['b']:0;
			$fault_score[$student_sn]['c']=$fault_score[$student_sn]['c']?$fault_score[$student_sn]['c']:0;
			$fault_score[$student_sn]['bonus']=$fault_score[$student_sn]['bonus']?$fault_score[$student_sn]['bonus']:0;
			
			
			//��X���
			switch($_POST['act']){
				case 'EXCEL':
					$x->items[]=array($stud_person_id,$stud_name,$birth_year,$birth_month,$birth_day,$seme_grade,$seme_class,$seme_num,1,$addr_zip,$guardian_address,$guardian_phone,$guardian_hand_phone,$kind_id,$disability_id,$competetion_score[$student_sn][score],$service_score[$student_sn][leader],$service_score[$student_sn][hours],$service_score[$student_sn][bonus],$fault_score[$student_sn][1],$fault_score[$student_sn][3],$fault_score[$student_sn][9],$fault_score[$student_sn][a],$fault_score[$student_sn][b],$fault_score[$student_sn][c],$fault_score[$student_sn][bonus],$fitness_score[$student_sn][2],$fitness_score[$student_sn][1],$fitness_score[$student_sn][3],$fitness_score[$student_sn][4],$fitness_score[$student_sn][bonus],$diversification_score[$student_sn],$particular_score[$student_sn][score],$particular_score[$student_sn][bonus],$disadvantage_score[$student_sn][disadvantage],$disadvantage_score[$student_sn][score],$balance_area_score[$student_sn][health][avg],$balance_area_score[$student_sn][art][avg],$balance_area_score[$student_sn][complex][avg],$balance_score_t[$student_sn][score],$personality_score[$student_sn][score_adaptive_domicile],$personality_score[$student_sn][score_adaptive_tutor],$personality_score[$student_sn][score_adaptive_guidance],$personality_score[$student_sn][bonus],$GEPT,$bonus_total,$signup_north,$signup_central,$signup_south,$competetion_list,$TOEIC);
					break;
				case 'HTML':
					$main.="<tr align='center'><td>{$stud_person_id}</td><td>{$stud_name}</td><td>{$birth_year}</td><td>{$birth_month}</td><td>{$birth_day}</td><td>{$seme_grade}</td><td>{$seme_class}</td><td>{$seme_num}</td><td>1</td><td>{$addr_zip}</td><td align='left'>{$guardian_address}</td><td>{$guardian_phone}</td><td>{$guardian_hand_phone}</td><td>{$kind_id}</td><td>{$disability_id}</td><td>{$competetion_score[$student_sn][score]}</td><td>{$service_score[$student_sn][leader]}</td><td>{$service_score[$student_sn][hours]}</td><td>{$service_score[$student_sn][bonus]}</td><td>{$fault_score[$student_sn][1]}</td><td>{$fault_score[$student_sn][3]}</td><td>{$fault_score[$student_sn][9]}</td><td>{$fault_score[$student_sn][a]}</td><td>{$fault_score[$student_sn][b]}</td><td>{$fault_score[$student_sn][c]}</td><td>{$fault_score[$student_sn][bonus]}</td><td>{$fitness_score[$student_sn][2]}</td><td>{$fitness_score[$student_sn][1]}</td><td>{$fitness_score[$student_sn][3]}</td><td>{$fitness_score[$student_sn][4]}</td><td>{$fitness_score[$student_sn][bonus]}</td><td>{$diversification_score[$student_sn]}</td><td>{$particular_score[$student_sn][score]}</td><td>{$particular_score[$student_sn][bonus]}</td><td>{$disadvantage_score[$student_sn][disadvantage]}</td><td>{$disadvantage_score[$student_sn][score]}</td><td>{$balance_area_score[$student_sn][health][avg]}</td><td>{$balance_area_score[$student_sn][art][avg]}</td><td>{$balance_area_score[$student_sn][complex][avg]}</td><td>{$balance_score_t[$student_sn][score]}</td><td>{$personality_score[$student_sn][score_adaptive_domicile]}</td><td>{$personality_score[$student_sn][score_adaptive_tutor]}</td><td>{$personality_score[$student_sn][score_adaptive_guidance]}</td><td>{$personality_score[$student_sn][bonus]}</td><td>$GEPT</td><td>{$bonus_total}</td><td>{$signup_north}</td><td>{$signup_central}</td><td>{$signup_south}</td><td align='left'>{$competetion_list}</td><td>$TOEIC</td></tr>";
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
$sql="SELECT DISTINCT academic_year FROM 12basic_tech ORDER BY academic_year";
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