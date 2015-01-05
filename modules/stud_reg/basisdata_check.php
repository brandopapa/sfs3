<?php

include "stud_reg_config.php";

sfs_check();


$class_name_arr=class_base();

$check_array=array(stud_name=>"�m�W",stud_name_eng=>"�^��m�W",stud_sex=>"�ʧO",stud_birthday=>"�X�ͦ~���",stud_blood_type=>"�嫬",stud_birth_place=>"�X�ͦa",stud_kind=>"�ǥͨ����O",stud_country=>"���y",stud_country_kind=>"�ҷӺ���",stud_person_id=>"�����Ҹ��X",stud_country_name=>"���~�a",stud_addr_1=>"���y�a�}",stud_addr_2=>"�s���a�}",stud_tel_1=>"���y�q��",stud_tel_2=>"�s���q��",stud_tel_3=>"��ʹq��",stud_mail=>"�q�l�l��",stud_class_kind=>"�Z�ũʽ�",stud_spe_kind=>"�S��Z���O",stud_spe_class_kind=>"�S��Z�Z�O",stud_spe_class_id=>"�S��Z�W�ҩʽ�",stud_preschool_status=>"�J�ǫe���X��",stud_preschool_id=>"���X��ǮեN��",stud_preschool_name=>"���X��W��",stud_Mschool_status=>"�J�Ǹ��",stud_mschool_id=>"��p�ǮեN��",stud_mschool_name=>"��p�W��",stud_study_year=>"�J�Ǧ~",enroll_school=>"�J�ǾǮ�"
,fath_name=>"���˩m�W",fath_birthyear=>"���˥X�ͦ~��",fath_alive=>"���˦s�\\",fath_relation=>"�P�����Y",fath_p_id=>"���˨������ҷ�",fath_education=>"���˱Ш|�{��",fath_grad_kind=>"���˱Ш|�{�����O",fath_occupation=>"����¾�~",fath_unit=>"���˪A�ȳ��",fath_work_name=>"����¾��",fath_phone=>"���˹q��(��)",fath_home_phone=>"���˹q��(�v)",fath_hand_phone=>"���˦�ʹq��",fath_email=>"���˹q�l�l��"
,moth_name=>"���˩m�W",moth_birthyear=>"���˥X�ͦ~��",moth_alive=>"���˦s�\\",moth_relation=>"�P�����Y",moth_p_id=>"���˨������ҷ�",moth_education=>"���˱Ш|�{��",moth_grad_kind=>"���˱Ш|�{�����O",moth_occupation=>"����¾�~",moth_unit=>"���˪A�ȳ��",moth_work_name=>"����¾��",moth_phone=>"���˹q��(��)",moth_home_phone=>"���˹q��(�v)",moth_hand_phone=>"���˦�ʹq��",moth_email=>"���˹q�l�l��"
,guardian_name=>"���@�H�m�W",guardian_phone=>"���@�H�s���q��",guardian_address=>"���@�H�s���a�}",guardian_relation=>"�P���@�H���Y",guardian_p_id=>"���@�H�������ҷ�",guardian_unit=>"���@�H�A�ȳ��",guardian_work_name=>"���@�H¾��",guardian_hand_phone=>"���@�H��ʹq��",guardian_email=>"���@�H�q�l�l��",grandfath_name=>"�����m�W",grandfath_alive=>"�����s�\\",grandmoth_name=>"�����m�W",grandmoth_alive=>"�����s�\\");
$default_check_item=array(stud_name=>"1",stud_name_eng=>"1",stud_sex=>"1",stud_birthday=>"1",stud_blood_type=>"",stud_birth_place=>"1",stud_kind=>"1",stud_country=>"1",stud_country_kind=>"1",stud_person_id=>"1",stud_country_name=>"",stud_addr_1=>"1",stud_addr_2=>"1",stud_tel_1=>"1",stud_tel_2=>"1",stud_tel_3=>"",stud_mail=>"",stud_class_kind=>"1",stud_spe_kind=>"",stud_spe_class_kind=>"",stud_spe_class_id=>"",stud_preschool_status=>"",stud_preschool_id=>"",stud_preschool_name=>"",stud_Mschool_status=>"1",stud_mschool_id=>"",stud_mschool_name=>"",stud_study_year=>"1",enroll_school=>"1",fath_name=>"1",fath_birthyear=>"1",fath_alive=>"1",fath_relation=>"1",fath_p_id=>"",fath_education=>"",fath_grad_kind=>"",fath_occupation=>"1",fath_unit=>"1",fath_work_name=>"",fath_phone=>"",fath_home_phone=>"",fath_hand_phone=>"1",fath_email=>"",moth_name=>"1",moth_birthyear=>"1",moth_alive=>"1",moth_relation=>"1",moth_p_id=>"",moth_education=>"",moth_grad_kind=>"",moth_occupation=>"1",moth_unit=>"1",moth_work_name=>"",moth_phone=>"",moth_home_phone=>"",moth_hand_phone=>"1",moth_email=>"",guardian_name=>"1",guardian_phone=>"1",guardian_address=>"",guardian_relation=>"1",guardian_p_id=>"",guardian_unit=>"1",guardian_work_name=>"1",guardian_hand_phone=>"1",guardian_email=>"",grandfath_name=>"",grandfath_alive=>"",grandmoth_name=>"",grandmoth_alive=>"");
$error_array=array();

if($_POST[go]){
	//����s�Z�O���̪��ǥͦC��(�u��ثe�b�Ǿǥ�)
	$sql="select a.*,b.* from stud_base a left join stud_domicile b on a.student_sn=b.student_sn where stud_study_cond in (0,15) order by curr_class_num";
	$res=$CONN->Execute($sql) or trigger_error("SQL�y�k���~�G$sql", E_USER_ERROR);
	while(!$res->EOF){
		$stud_id=$res->fields[stud_id];
		$student_sn=$res->fields[student_sn];
		$stud_name=$res->fields[stud_name];
		$grade=substr($res->fields[curr_class_num],0,-4);
		$curr_class_num=$res->fields[curr_class_num];
		$class_id=substr($curr_class_num,0,-2);
		$class_name=$class_name_arr[$class_id];
		
		foreach($default_check_item as $key=>$value){
			if($_POST[$key])
			if(! strlen($res->fields[$key])){
				$error_array[$class_id][$curr_class_num][stud_name]=$stud_name;
				$error_array[$class_id][$curr_class_num][class_name]=$class_name;			
				$error_array[$class_id][$curr_class_num][error].=$check_array[$key].',';	
			}
		}
		$res->MoveNext();
	}


	//�}�l�C��
	$showdata="<table border=1 cellpadding=3 cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
				<tr align='center' bgcolor='#ffcccc'><td>�ثe�Z��</td><td>�y��</td><td>�m�W</td><td>����g����</td></tr>";
	$class_info='���Z�ŤH�Ʋέp�G';			
	foreach($error_array as $class_id=>$students){
		$class_count=count($students);
		$class_info.="{$class_name_arr[$class_id]}($class_count);";
		foreach($students as $curr_class_num=>$value){
			$class_no=substr($curr_class_num,-2);
			$showdata.="<tr align='center'><td width=70>{$value[class_name]}</td><td width=30>$class_no</td><td width=70>{$value[stud_name]}</td><td align='left'>{$value[error]}</td></tr>";
		}
	}
	$showdata.="</table>";
	echo "$showdata<br><font color='red' size=2>$class_info</font>";
	exit;
}

$year_seme=$_POST[year_seme]?$_POST[year_seme]:sprintf("%03d%d",curr_year(),curr_seme());

head("���y�򥻸�Ƨ�����ˬd");
print_menu($menu_p);


//�]�w�n�ˬd�����
$check_item_list="<table border=1 cellpadding=3 cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
	<tr align='center' bgcolor='#ffcccc'><td>�n�ˬd�����</td></tr>";
$item_list='';
foreach($check_array as $key=>$value){
	$checked=$default_check_item[$key]?' checked':'';
	$color=$default_check_item[$key]?'red':'grey';
	$item_list.="<input type='checkbox' name='$key'$checked onclick=''><font color='$color'>$value</font> ";
}
$check_item_list.="<tr><td>$item_list</td></tr><tr align='center'><td><input type='submit' name='go' style='border-width:2px; cursor:hand; font-size=16px; color:black; width:150; background:#aaffaa;' value='���ڶ}�l�ˬd'></td></tr></table>";

echo "<form name='myform' method='post' target='_BLANK'>$check_item_list</form>";
foot();

?>
