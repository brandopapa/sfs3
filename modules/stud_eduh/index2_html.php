<?php

// $Id: index2.php 6890 2012-09-14 08:43:51Z smallduh $

include "config.php";
include "../stud_report/report_config.php";
include_once "../../include/sfs_case_dataarray.php";
//�{���ˬd
sfs_check();

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

$postBtn = "������X";
$template=$_POST[template];
$sel_stud=$_POST[sel_stud];

//�Ӹ�O��
//�Z�Ű}�C
$class_arr = class_base();
//�ϥΪ̿�����ǥ�
$stud_id_list=implode(',',$sel_stud);

if ($_REQUEST[year_seme]=='')
  	         $_REQUEST[year_seme] = sprintf("%03d%d",curr_year(),curr_seme());

if (count($sel_stud) >0 )
//�Ӹ�O��
//�Ǵ�
$year_seme=$_POST['year_seme'];
//�Z��(�����oSFS3�������w�Z�ťN�X�Ҧp101,�A�ഫ���Ǯզۭq�W�٨Ҥ@�~�үZ)
$class_id=$_POST['class_id'];
$class_name=$class_arr[$class_id];

//����J�Ǵ�������� ==2012.09.14 by smallduh==================================
// �Y�Ǹ�ƪ�S�� student_sn �o�����, ���� seme_year_seme ���Ǧ~������, �G���J�Ǧ~�������
if ($class_id>700) {
 $STUD_STUDY_YEAR=sprintf("%d",substr($year_seme,0,3))-(sprintf("%d",substr($class_id,0,1))-7);
 $min_year_seme=sprintf("%03d",$STUD_STUDY_YEAR)."1";
 $max_year_seme=sprintf("%03d",$STUD_STUDY_YEAR+2)."2"; //�ꤤ
} else {
 $STUD_STUDY_YEAR=sprintf("%d",substr($year_seme,0,3))-(sprintf("%d",substr($class_id,0,1))-1);
 $min_year_seme=sprintf("%03d",$STUD_STUDY_YEAR)."1";
 $max_year_seme=sprintf("%03d",$STUD_STUDY_YEAR+5)."2"; //��p
}
//============================================================================

if($_POST['do_key']==$postBtn) {
	//�Ӹ�O��
	$test=pipa_log("�L���������ɰO����\r\n�Ǵ��G$year_seme\r\n�Z�šG$class_id $class_name\r\n �ǥͦC��G$stud_id_list");	
	
	$min=1+$IS_JHORES;
	$max=6+$IS_JHORES;
	//�X�ͦa
	$birth_state_arr = birth_state();
//print_r($birth_state_arr);		
//exit;
	//�ʧO
	$sex_arr = array("1"=>"�k","2"=>"�k");	
	
	//���ͻ��ɰO��A��ﶵ�ѷӰ}�C
	$eduh_item_list_arr=get_eduh_item_list();
	
	//���o��w�ǥͬy�����ǳƸ��
	$data_arr=array();
	$stud_id_list=implode(',',$sel_stud);
	//���ostud_base�򥻸��
	//�W�[����J�Ǧ~�Ө��o��� 2012.09.14 by smallduh
	//$sql="select student_sn,stud_id,stud_name,stud_sex,stud_study_year,stud_person_id,stud_birth_place,stud_addr_1,stud_addr_2,stud_birthday,stud_tel_1,stud_tel_2,enroll_school from stud_base where stud_id in ($stud_id_list) order by curr_class_num";
$sql="select student_sn,stud_id,stud_name,stud_sex,stud_study_year,stud_person_id,stud_birth_place,stud_addr_1,stud_addr_2,stud_birthday,stud_tel_1,stud_tel_2,enroll_school from stud_base where stud_id in ($stud_id_list) and stud_study_year='$STUD_STUDY_YEAR' order by curr_class_num"; 

	$res=$CONN->Execute($sql) or user_error("Ū��stud_base��ƥ��ѡI<br>$sql",256);
	$student_sn_arr=array();
	while(!$res->EOF)
	{
		$stud_id=$res->fields['stud_id'];
		$student_sn=$res->fields['student_sn'];
		$stud_study_year=$res->fields['stud_study_year'];
		$student_sn_list.=$res->fields['student_sn'].',';
		$student_sn_arr[$res->fields['student_sn']]=$stud_id;
		for($i=0;$i<$res->FieldCount();$i++)
		{
			$r=$res->fetchfield($i);
			$data_arr[$stud_id][$r->name]=$res->fields[$i];
		}
		$stud_birthday=$res->fields['stud_birthday'];
		$bir_temp_arr = explode("-",DtoCh($stud_birthday));		
		$data_arr[$stud_id]["stud_birthday"]=sprintf("%d�~%d��%d��",$bir_temp_arr[0],$bir_temp_arr[1],$bir_temp_arr[2]);
		
		//�B�z�J�Ǹ��
		$data_arr[$stud_id]["stud_study_year"]=$stud_study_year;
		$data_arr[$stud_id]["enroll_school"]=$res->fields['enroll_school'];
		$data_arr[$stud_id]["enroll_date"]=$res->fields['stud_study_year'].'�~08��';
		
		//����stud_base�L��� �h�۲��ʬ���(stud_move)->�s�ͤJ�Ǥ��j�M
		if(! $res->fields['enroll_school'])
		{
			$sql_enroll="select year(move_date) as enroll_year,month(move_date) as enroll_month,school from stud_move where move_kind=13 and student_sn=$student_sn;";
			$res_enroll=$CONN->Execute($sql_enroll) or user_error("Ū��stud_move��ƥ��ѡI<br>$sql_enroll",256);
			if($res_enroll->EOF)
			{
				//��stud_move_import->�s�ͤJ�Ǥ��j�M, ���ӬO�Τ���(�]��XML�פJ�|�g��stud_base->enroll_school)
				$sql_enroll_import="select year(move_date) as enroll_year,month(move_date) as enroll_month,school from stud_move_import where move_kind=13 and student_sn=$student_sn;";
				$res_enroll_import=$CONN->Execute($sql_enroll_import) or user_error("Ū��stud_move_import��ƥ��ѡI<br>$sql_enroll_import",256);
				if($res_enroll_import->EOF)
				{
					if(! $data_arr[$stud_id]["enroll_date"]) $data_arr[$stud_id]["enroll_date"]=($res_enroll_import->fields['enroll_year']-1911).'�~'.$res_import->fields['enroll_month'].'��';
					$data_arr[$stud_id]["enroll_school"]=$res_enroll_import->fields['school'];
				}
			} else
			{
				if(! $data_arr[$stud_id]["enroll_date"]) $data_arr[$stud_id]["enroll_date"]=($res_enroll->fields['enroll_year']-1911).'�~'.$res_enroll->fields['enroll_month'].'��';
				$data_arr[$stud_id]["enroll_school"]=$res_enroll->fields['school']?$res_enroll->fields['school']:$school_long_name;
			}
		}
		
		//��Ķ���
		$data_arr[$stud_id]['stud_sex']=$sex_arr[$data_arr[$stud_id]['stud_sex']];
		//$data_arr[$stud_id]['stud_birth_place']=$birth_state_arr[$data_arr[$stud_id]['stud_birth_place']];
		$data_arr[$stud_id]['stud_birth_place']=$birth_state_arr[sprintf('%02d',$res->fields['stud_birth_place'])];

		//�[�J�Ǯթ��Y
		$data_arr[$stud_id]['school_long_name']=$school_long_name;

		//�Ӥ�  http://localhost/sfs3/data/photo/student/90/90002
		$stud_photo_file="$UPLOAD_PATH/photo/student/$stud_study_year/$stud_id";
		if(file_exists($stud_photo_file)){
			$data_arr[$stud_id]['photo']="<img src='$UPLOAD_URL//photo/student/$stud_study_year/$stud_id' width=120>";
		} else {
			$data_arr[$stud_id]['photo']='';
		}
//echo "<textarea rows=50 cols=80>".$data_arr[$stud_id]["photo"]."</textarea>";
		$res->MoveNext();
	}
//print_r($student_sn_arr);
	

	//���o�s�ͤJ�Ǫ�����(�o�ӳ���  �����ǥͥi��|�����D)
	$student_sn_list=substr($student_sn_list,0,-1);
	//����Ǧ~�Z�žɮv�}�C
	$class_teacher_arr=array();
	$sql="select class_id,teacher_1 from school_class";
	$res=$CONN->Execute($sql) or user_error("Ū��school_class��ƥ��ѡI<br>$sql",256);
	while(!$res->EOF) {
		$teacher_class_id=$res->fields['class_id'];
		$class_teacher_arr[$teacher_class_id]=$res->fields['teacher_1'];
		$res->MoveNext();
	}
	
	//���o���~�NŪ�Z�šB�y���P�ɮv
	//�b���ժ��Ǵ��s�Z����
	$sql="select stud_id,seme_year_seme,seme_class,left(seme_class,1) as grade,right(seme_year_seme,1) as semester,seme_num,seme_class_name from stud_seme where stud_id in ($stud_id_list) and seme_year_seme>='$min_year_seme' and seme_year_seme<='$max_year_seme'";
	$res=$CONN->Execute($sql) or user_error("Ū��stud_seme��ƥ��ѡI<br>$sql",256);
	while(!$res->EOF) {
		//�զ�school_class�榡��class_id
		$stud_class_id=sprintf("%03d_%d_%02d_%02d",substr($res->fields['seme_year_seme'],0,3),substr($res->fields['seme_year_seme'],-1),$res->fields['grade'],substr($res->fields['seme_class'],-2));
		$stud_id=$res->fields['stud_id'];
		$grade=$res->fields['grade'];
		$semester=$res->fields['semester'];
		$k=$grade.'-'.$semester;
		
		$data_arr[$stud_id]['class'][$grade][$semester]['semester']=$k;
		$data_arr[$stud_id]['class'][$grade][$semester]['name']=$class_name_kind_1[$grade].'�~'.$res->fields['seme_class_name'].'�Z';
		$data_arr[$stud_id]['class'][$grade][$semester]['seme_num']=$res->fields['seme_num'];
		$data_arr[$stud_id]['class'][$grade][$semester]['teacher']=$class_teacher_arr[$stud_class_id];
		
		//���Ϳ���ǥ;Ǵ��~�Ź�Ӱ}�C �H�K�᭱���ɳX�ͰO���ϥ�
		$stud_grade[$stud_id][$res->fields['seme_year_seme']]=$grade;

		$res->MoveNext();
	}
	
	
	//��J�פJ���Ǵ��s�Z����
	//����J�Ǵ�������� 2012.09.14 by smallduh
	//$sql="select stud_id,seme_year_seme,seme_class_grade,seme_class_grade as grade,seme_num,seme_class_name from stud_seme_import where stud_id in ($stud_id_list)";
	$sql="select stud_id,seme_year_seme,seme_class_grade,seme_class_grade as grade,seme_num,seme_class_name from stud_seme_import where stud_id in ($stud_id_list) and seme_year_seme>='$min_year_seme' and seme_year_seme<='$max_year_seme'";
	$res=$CONN->Execute($sql) or user_error("Ū��stud_seme_import��ƥ��ѡI<br>$sql",256);
	while(!$res->EOF) {
		//�զ�school_class�榡��class_id
		//$stud_class_id=sprintf("%03d_%d_%02d_%02d",substr($res->fields['seme_year_seme'],0,3),substr($res->fields['seme_year_seme'],-1),$res->fields['grade'],substr($res->fields['seme_class'],-2));
		$stud_class_id=sprintf("%03d_%d_%02d_%02d",substr($res->fields['seme_year_seme'],0,3),substr($res->fields['seme_year_seme'],-1),$res->fields['grade'],0);
		$stud_id=$res->fields['stud_id'];
		$grade=$res->fields['grade'];
		$year=substr($res->fields['seme_year_seme'],0,3);
		$semester=substr($res->fields['seme_year_seme'],-1);
		$k=$grade.'_'.$semester;

		$data_arr[$stud_id]['class'][$grade][$semester]['semester']=$k;
		$data_arr[$stud_id]['class'][$grade][$semester]['name']=$class_name_kind_1[$grade].'�~'.$res->fields['seme_class_name'].'�Z';
		$data_arr[$stud_id]['class'][$grade][$semester]['seme_num']=$res->fields['seme_num'];
		
		$sql_teacher_name="SELECT teacher_name FROM stud_seme_import WHERE stud_id='$stud_id' AND seme_class_grade='$grade' AND seme_year_seme='".$res->fields['seme_year_seme']."';";
		$res_teacher_name=$CONN->Execute($sql_teacher_name);
		$data_arr[$stud_id]['class'][$grade][$semester]['teacher']=$res_teacher_name->fields['teacher_name'];

		$stud_semester='grade_'.$grade.'_'.$semester;
		$data_arr[$stud_id][$stud_semester]=$year+0;

		//���Ϳ���ǥ;Ǵ��~�Ź�Ӱ}�C
		$stud_grade[$stud_id][$res->fields['seme_year_seme']]=$grade;
		$stud_grade_semester[$stud_id][$k]=$res->fields['seme_year_seme'];

		$res->MoveNext();
	}
	
	
	//�B�z�߲z����(�s��)

	$sql="select student_sn,item,test_date,score,model,standard,pr,explanation from stud_psy_test where student_sn in ($student_sn_list) order by student_sn,year,semester";
	$res=$CONN->Execute($sql) or user_error("Ū��stud_psy_test��ƥ��ѡI<br>$sql",256);
	$no=0;
	$current_sn=0;
	while(!$res->EOF) {
		if($current_sn<>$res->fields['student_sn']){
			$no=1;
			$current_sn=$res->fields['student_sn'];
		} else $no++;
		
		$stud_id=$student_sn_arr[$current_sn];
		
		$date_temp_arr = explode("-",DtoCh($res->fields['test_date']));
		
		$data_arr[$stud_id]['psy'][$no]['item']=$res->fields['item'];
		if($res->fields['test_date']) $data_arr[$stud_id]['psy'][$no]['date']=sprintf("%d/%02d/%02d",$date_temp_arr[0],$date_temp_arr[1],$date_temp_arr[2]);
		$data_arr[$stud_id]['psy'][$no]['score']=$res->fields['score'];
		$data_arr[$stud_id]['psy'][$no]['model']=$res->fields['model'];
		$data_arr[$stud_id]['psy'][$no]['standard']=$res->fields['standard'];
		$data_arr[$stud_id]['psy'][$no]['pr']=$res->fields['pr'];
		$data_arr[$stud_id]['psy'][$no]['explanation']=$res->fields['explanation'];
		$res->MoveNext();
	}
	//$sql="select a.*,b.name as teacher from stud_seme_talk a LEFT JOIN teacher_base b ON a.teach_id=b.teacher_sn WHERE a.stud_id in ($stud_id_list) order by a.stud_id,a.seme_year_seme,a.sst_date";
	//�אּ����J�Ǵ������P stud_id ����� 2012.09.14 by smallduh
	//$sql="select * from stud_seme_talk where stud_id in ($stud_id_list) order by stud_id,seme_year_seme,sst_date;";
	$sql="select * from stud_seme_talk where stud_id in ($stud_id_list) and seme_year_seme>='$min_year_seme' and seme_year_seme<='$max_year_seme' order by stud_id,seme_year_seme,sst_date;";
	$res=$CONN->Execute($sql) or user_error("Ū��stud_seme_talk��ƥ��ѡI<br>$sql",256);
	$no=0;
	$current_id='';
	while(!$res->EOF) {
		$stud_id=$res->fields['stud_id'];
		if($current_id<>$stud_id){
			$no=1;
			$current_id=$stud_id;
		} else $no++;
		
		$date_temp_arr = explode("-",DtoCh($res->fields['sst_date']));
		
		$data_arr[$stud_id]['guid'][$no]['grade']=$class_name_kind_1[$stud_grade[$stud_id][$res->fields['seme_year_seme']]];
		$data_arr[$stud_id]['guid'][$no]['date']=sprintf("%d/%02d/%02d",$date_temp_arr[0],$date_temp_arr[1],$date_temp_arr[2]);
		$data_arr[$stud_id]['guid'][$no]['sst_name']=$res->fields['sst_name'];
		$data_arr[$stud_id]['guid'][$no]['sst_main']=$res->fields['sst_main'];
		$data_arr[$stud_id]['guid'][$no]['sst_memo']=$res->fields['sst_memo'];
		//$data_arr[$stud_id]["guid_teacher_$no"]=get_teacher_name($res->fields['teach_id']);  //�ª�������ɪ�  20110503��U����~~~�X�ͪ�
		$data_arr[$stud_id]['guid'][$no]['interview']=$res->fields['interview'];
		
		//���ϥ���컲�ɱЮv�A�h����ǶפJ����ƪ�M��
		if(! $data_arr[$stud_id]['guid'][$no]['interview']) {
			$seme_year_seme=$res->fields['seme_year_seme'];
			$sql_teacher="select teacher_name from stud_seme_import WHERE stud_id='$stud_id' and seme_year_seme='$seme_year_seme';";
			$res_teacher=$CONN->Execute($sql_teacher);
			$data_arr[$stud_id]['guid'][$no]['interview']=$res_teacher->fields['teacher_name'];
		}

		$res->MoveNext();
	}
	
	//�B�z�S���{����
	//$sql="select a.*,b.name as teacher from stud_seme_spe a,teacher_base b where a.stud_id in ($stud_id_list) and a.teach_id=b.teacher_sn order by a.stud_id,a.seme_year_seme";
	//�אּ����J�Ǵ������P stud_id ����� 2012.09.14 by smallduh
	$sql="select a.*,b.name as teacher from stud_seme_spe a,teacher_base b where a.stud_id in ($stud_id_list) and a.seme_year_seme>='$min_year_seme' and a.seme_year_seme<='$max_year_seme' and a.teach_id=b.teacher_sn order by a.stud_id,a.seme_year_seme";
	$res=$CONN->Execute($sql) or user_error("Ū��stud_seme_spe��ƥ��ѡI<br>$sql",256);
	$no=0;
	$current_id='';
	while(!$res->EOF) {
		$stud_id=$res->fields['stud_id'];
		if($current_id<>$stud_id){
			$no=1;
			$current_id=$stud_id;
		} else $no++;
		
		$date_temp_arr = explode("-",DtoCh($res->fields['sp_date']));
		
		$data_arr[$stud_id]['sp'][$no]["grade"]=$class_name_kind_1[$stud_grade[$stud_id][$res->fields['seme_year_seme']]];
		$data_arr[$stud_id]['sp'][$no]["sp_semester"]=$res->fields['seme_year_seme'];
		$data_arr[$stud_id]['sp'][$no]["sp_date"]=sprintf("%d/%02d/%02d",$date_temp_arr[0],$date_temp_arr[1],$date_temp_arr[2]);
		$data_arr[$stud_id]['sp'][$no]["sp_memo"]=$res->fields['sp_memo'];
		$data_arr[$stud_id]['sp'][$no]["sp_teacher"]=$res->fields['teacher'];
			
		$res->MoveNext();
	}
	
	
	//���~�~��P�ɤJ�Ǯ�
	//�����ͤ@�ӪŰ}�C  �H�K�|�����~�X�{����
	foreach($sel_stud as $stud_id){
			$data_arr[$stud_id]["stud_grad_year"]='';
			$data_arr[$stud_id]["new_school"]='';
	}
//��H student_sn 2012.09.14 by smallduh
	//$sql="select stud_id,stud_grad_year,new_school,YEAR(grad_date) as grade_year,MONTH(grad_date) as grade_month from grad_stud where stud_id in ($stud_id_list)";
	$sql="select stud_id,stud_grad_year,new_school,YEAR(grad_date) as grade_year,MONTH(grad_date) as grade_month from grad_stud where student_sn in ($student_sn_list)";
	$res=$CONN->Execute($sql) or user_error("Ū��grad_stud��ƥ��ѡI<br>$sql",256);
	while(!$res->EOF) {
		$stud_id=$res->fields['stud_id'];
		$stud_grad_year=$res->fields['stud_grad_year'];
		$grade_month=$res->fields['grade_month'];
		$grade_year=($res->fields['grade_year'])-1911;
			
		$data_arr[$stud_id]["stud_grad_year"]=($grade_year?"$grade_year �~":"").($grade_month?" $grade_month ��":"");
		$data_arr[$stud_id]["new_school"]=$res->fields['new_school'];
			
		$res->MoveNext();
	}
	
	//�B�z����A��
  //�אּ����J�Ǵ�������� 2012.09.14 by smallduh
	//$query = "select * from stud_seme_eduh where stud_id in ($stud_id_list) order by seme_year_seme,stud_id";
$query = "select * from stud_seme_eduh where stud_id in ($stud_id_list) and seme_year_seme>='$min_year_seme' and seme_year_seme<='$max_year_seme' order by seme_year_seme,stud_id";
	$recordSet = $CONN->Execute($query) or user_error("Ū��stud_seme_eduh��ƥ��ѡI<br>$query",256);
	while (!$recordSet->EOF) {
		$seme_year_seme=$recordSet->fields["seme_year_seme"];
		$stud_id = $recordSet->fields["stud_id"];
		$i=$stud_grade[$stud_id][$seme_year_seme];
		$j=substr($seme_year_seme,-1);
		$k=$i."_".$j;
		
		$data_arr[$stud_id]["eduh_relation_item"][$i][$j]=$recordSet->fields["sse_relation"];
		$data_arr[$stud_id]["eduh_kind_item"][$i][$j]=$recordSet->fields["sse_family_kind"];
		$data_arr[$stud_id]["eduh_air_item"][$i][$j]=$recordSet->fields["sse_family_air"];
		$data_arr[$stud_id]["eduh_father_item"][$i][$j]=$recordSet->fields["sse_farther"];
		$data_arr[$stud_id]["eduh_mother_item"][$i][$j]=$recordSet->fields["sse_mother"];
		$data_arr[$stud_id]["eduh_live_item"][$i][$j]=$recordSet->fields["sse_live_state"];
		$data_arr[$stud_id]["eduh_rich_item"][$i][$j]=$recordSet->fields["sse_rich_state"];
		
		$data_arr[$stud_id]["eduh_s1_item"][$i][$j]=substr(substr($recordSet->fields["sse_s1"],0,-1),1);
		$data_arr[$stud_id]["eduh_s2_item"][$i][$j]=substr(substr($recordSet->fields["sse_s2"],0,-1),1);
		$data_arr[$stud_id]["eduh_s3_item"][$i][$j]=substr(substr($recordSet->fields["sse_s3"],0,-1),1);
		$data_arr[$stud_id]["eduh_s4_item"][$i][$j]=substr(substr($recordSet->fields["sse_s4"],0,-1),1);
		$data_arr[$stud_id]["eduh_s5_item"][$i][$j]=substr(substr($recordSet->fields["sse_s5"],0,-1),1);
		$data_arr[$stud_id]["eduh_s6_item"][$i][$j]=substr(substr($recordSet->fields["sse_s6"],0,-1),1);
		$data_arr[$stud_id]["eduh_s7_item"][$i][$j]=substr(substr($recordSet->fields["sse_s7"],0,-1),1);
		$data_arr[$stud_id]["eduh_s8_item"][$i][$j]=substr(substr($recordSet->fields["sse_s8"],0,-1),1);
		$data_arr[$stud_id]["eduh_s9_item"][$i][$j]=substr(substr($recordSet->fields["sse_s9"],0,-1),1);
		$data_arr[$stud_id]["eduh_s10_item"][$i][$j]=substr(substr($recordSet->fields["sse_s10"],0,-1),1);
		$data_arr[$stud_id]["eduh_s11_item"][$i][$j]=substr(substr($recordSet->fields["sse_s11"],0,-1),1);
	
		$recordSet->MoveNext();
	}
		
	$student_data='';
	
	//�}�l���ͺ���
	$year_title='';
	for($i=$min;$i<=$max;$i++){
		$year_title.="<td>{$class_year[$i]}</td>";
	}

	foreach($data_arr as $key=>$data){
		//���Y
		$student_data.="<center><font size='5' face='�з���'>$school_long_name �ǥͻ��ɸ�Ƭ�����</font></center>";
	
		//�򥻸��
		$student_data.="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size:9pt;' bordercolor='#111111' id='AutoNumber1' width=100%>";
		$student_data.="<tr align='center'><td bgcolor='#ffcccc'>�m�@�@�W</td><td>{$data['stud_name']}</td><td bgcolor='#ffcccc'>�ʡ@�@�O</td><td>{$data['stud_sex']}</td><td bgcolor='#ffcccc'>�Ǹ�</td><td>{$data['stud_id']}</td><td width=126 rowspan=6>{$data['photo']}</td></tr>";
		$student_data.="<tr align='center'><td bgcolor='#ffcccc'>�J�Ǧ~��</td><td>{$data['enroll_date']}</td><td bgcolor='#ffcccc'>�J�ǾǮ�</td><td colspan=3>{$data['enroll_school']}</td></tr>";

		$class_data="<table border=1 cellpadding=1 cellspacing='0' style='border-collapse: collapse; font-size:9pt;' bordercolor='#111111' id='AutoNumber1' width=100%>
			<tr align='center' bgcolor='#ddffff'><td>�Ǵ�</td><td>�Z��</td><td>�y��</td><td>�ɮv�m�W</td><td></td><td>�Ǵ�</td><td>�Z��</td><td>�y��</td><td>�ɮv�m�W</td></tr>";
		for($i=$min;$i<=$max;$i++){
			$class_data.="<tr align='center'><td>{$data['class'][$i][1]['semester']}</td><td>{$data['class'][$i][1]['name']}</td><td>{$data['class'][$i][1]['seme_num']}</td><td>{$data['class'][$i][1]['teacher']}</td><td></td><td>{$data['class'][$i][2]['semester']}</td><td>{$data['class'][$i][2]['name']}</td><td>{$data['class'][$i][2]['seme_num']}</td><td>{$data['class'][$i][2]['teacher']}</td></tr>";
		}
		$class_data.="</table>";
		$student_data.="<tr align='center'><td bgcolor='#ffcccc'>�N<br>Ū<br>�Z<br>��</td><td colspan=5>$class_data</td></tr></table>";
		
		//���H���p		
		$student_data.="<font size='3' face='�з���'>�@�B���H���p
			<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size:9pt;' bordercolor='#111111' id='AutoNumber1' width=100%>
			<tr align='center'><td colspan=2 bgcolor='#ffcccc'>�����Ҧr��</td><td colspan=3>{$data['stud_person_id']}</td></tr>
			<tr align='center'><td bgcolor='#ffcccc'>�X��</td><td bgcolor='#ffcccc'>�X�ͦa</td><td>{$data['stud_birth_place']}</td><td bgcolor='#ffcccc'>�ͤ�</td><td>{$data['stud_birthday']}</td></tr>
			<tr align='center'><td rowspan=2 bgcolor='#ffcccc'>�a�}</td><td bgcolor='#ffcccc'>���y�a�}</td><td align='left'>{$data['stud_addr_1']}</td><td rowspan=2 bgcolor='#ffcccc'>�q��</td><td>{$data['stud_tel_1']}</td></tr>
			<tr align='center'><td bgcolor='#ffcccc'>�q�T�a�}</td><td align='left'>{$data['stud_addr_2']}</td><td>{$data['stud_tel_2']}</td></tr>
			</table>";

		//�G�B�a�x���p
		$student_data.="�G�B�a�x���p
			<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size:9pt;' bordercolor='#111111' id='AutoNumber1' width=100%>
			<tr align='center' bgcolor='#ffcccc'><td width=80>���@�@��</td><td>���e�ﶵ</td>$year_title</tr>";
		$family_item_arr=array_slice($eduh_item_list_arr,0,7);
		foreach($family_item_arr as $item=>$value){
			$year_data='';
			for($i=$min;$i<=$max;$i++) $year_data.="<td>{$data[$item][$i][1]}<br>{$data[$item][$i][2]}</td>";
			$student_data.="<tr align='center'><td>{$value['title']}</td><td align='left'>{$value['items']}</td>$year_data</tr>";
		}
		$student_data.="</table>";
		
		//�T�B�ǲߪ��p
		$student_data.="�T�B�ǲߪ��p
		<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size:9pt;' bordercolor='#111111' id='AutoNumber1' width=100%>
		<tr align='center' bgcolor='#ffcccc'><td width=80>���@�@��</td><td>���e�ﶵ</td>$year_title</tr>";
		$study_item_arr=array_slice($eduh_item_list_arr,7,4);
		foreach($study_item_arr as $item=>$value){
			$year_data='';
			for($i=$min;$i<=$max;$i++) $year_data.="<td>{$data[$item][$i][1]}<br>{$data[$item][$i][2]}</td>";
			$student_data.="<tr align='center'><td>{$value['title']}</td><td align='left'>{$value['items']}</td>$year_data</tr>";
		}
		$student_data.="</table>";
		
		
		//�|�B�ͬ��A��
		$student_data.="�|�B�ͬ��A��
		<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size:9pt;' bordercolor='#111111' id='AutoNumber1' width=100%>
		<tr align='center' bgcolor='#ffcccc'><td width=80>���@�@��</td><td>���e�ﶵ</td>$year_title</tr>";
		$livily_item_arr=array_slice($eduh_item_list_arr,11);
		foreach($livily_item_arr as $item=>$value){
			$year_data='';
			for($i=$min;$i<=$max;$i++) $year_data.="<td>{$data[$item][$i][1]}<br>{$data[$item][$i][2]}</td>";
			$student_data.="<tr align='center'><td>{$value['title']}</td><td align='left'>{$value['items']}</td>$year_data</tr>";
		}
		$student_data.="</table>";
		
		
		//���B�߲z����
		$student_data.="���B�߲z����O��
		<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size:9pt;' bordercolor='#111111' id='AutoNumber1' width=100%>
		<tr align='center' bgcolor='#ffcccc'><td>����W��</td><td>������</td><td>��l����</td><td>�`�Ҽ˥�</td><td>�зǤ���</td><td>�ʤ�����</td><td>����</td></tr>";
		foreach($data['psy'] as $item=>$value){
			$student_data.="<tr align='center'><td>{$value['item']}</td><td>{$value['date']}</td><td>{$value['score']}</td><td>{$value['model']}</td><td>{$value['standard']}</td><td>{$value['pr']}</td><td>{$value['explanation']}</td></tr>";
		}
		$student_data.="</table>";
		
		
		//���B���n���ɬ���  
		$student_data.="���B���n���ɰO��
		<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size:9pt;' bordercolor='#111111' id='AutoNumber1' width=100%>
		<tr align='center' bgcolor='#ffcccc'><td width=30>�~��</td><td width=60>���</td><td width=60>�s����H</td><td>�s���ƶ�</td><td>���e�n�I</td><td width=60>���ɪ�</td></tr>";
		foreach($data['guid'] as $item=>$value){
			$student_data.="<tr align='center'><td>{$value['grade']}</td><td>{$value['date']}</td><td>{$value['sst_name']}</td><td>{$value['sst_main']}</td><td align='left'>{$value['sst_memo']}</td><td>{$value['interview']}</td></tr>";
		}
		$student_data.="</table>";
		
		//�C�B�S���{
		$data_arr[$stud_id]['sp'][$no]["grade"]=$class_name_kind_1[$stud_grade[$stud_id][$res->fields['seme_year_seme']]];
		$data_arr[$stud_id]['sp'][$no]["sp_semester"]=$res->fields['seme_year_seme'];
		$data_arr[$stud_id]['sp'][$no]["sp_date"]=sprintf("%d/%02d/%02d",$date_temp_arr[0],$date_temp_arr[1],$date_temp_arr[2]);
		$data_arr[$stud_id]['sp'][$no]["sp_memo"]=$res->fields['sp_memo'];
		$data_arr[$stud_id]['sp'][$no]["sp_teacher"]=$res->fields['teacher'];
		
		$student_data.="�C�B�S���{�O��
		<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size:9pt;' bordercolor='#111111' id='AutoNumber1' width=100%>
		<tr align='center' bgcolor='#ffcccc'><td width=30>�~��</td><td width=60>�Ǵ�</td><td width=60>���</td><td>��{�ƥ�</td><td width=60>�O����</td></tr>";
		foreach($data['sp'] as $item=>$value){
			$student_data.="<tr align='center'><td>{$value['grade']}</td><td>{$value['sp_semester']}</td><td>{$value['sp_date']}</td><td align='left'>{$value['sp_memo']}</td><td>{$value['sp_teacher']}</td></tr>";
		}
		$student_data.="</table>";
		
		//�K�B���~
		$student_data.="�K�B���~
		<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size:9pt;' bordercolor='#111111' id='AutoNumber1' width=100%>
		<tr align='center'><td bgcolor='#ffcccc' width=60>���~�~��</td><td width=160>{$data['stud_grad_year']}</td><td bgcolor='#ffcccc' width=60>�ɤJ�Ǯ�</td><td>{$data['new_school']}</td></tr></table>";
		
		//ñ��
		$student_data.="<br>
		<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size:9pt;' bordercolor='#111111' id='AutoNumber1' width=100%>
		<tr align='center'><td bgcolor='#ffcccc' width=40>�~��<br>�ӿ�</td><td width=120></td><td bgcolor='#ffcccc' width=40>���<br>�ժ�</td><td width=120></td><td bgcolor='#ffcccc' width=40>����<br>�D��</td><td width=120></td><td bgcolor='#ffcccc' width=40>�ժ�</td><td></td></tr></table>";
		
		
		$student_data.="<P style='page-break-after:always'></P>";
	}
/*	
echo "<PRE>";
print_r($data_arr);
echo "</PRE>";
*/
echo $student_data;
exit;		
}

//��ܯZ��

head();

print_menu($menu_p);
echo <<<HERE
<script>
function tagall(status) {
  var i =0;

  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].name=='sel_stud[]') {
      document.myform.elements[i].checked=status;
    }
    i++;
  }
}
</script>
HERE;

echo "<form enctype='multipart/form-data' action=\"{$_SERVER['PHP_SELF']}\" method=\"post\" name=\"myform\">";
$sel1 = new drop_select();
$sel1->top_option =  "��ܾǦ~";
$sel1->s_name = "year_seme";
$sel1->id = $_REQUEST[year_seme];
$sel1->is_submit = true;
$sel1->arr = get_class_seme();
$sel1->other_script="this.form.target='';";
$sel1->do_select();
 	 
echo "&nbsp;&nbsp;";
$sel1 = new drop_select();
$sel1->top_option =  "��ܯZ��";
$sel1->s_name = "class_id";
$sel1->id = $class_id;
$sel1->is_submit = true;
$sel1->arr = class_base($_REQUEST[year_seme]);
$sel1->other_script="this.form.target=''";
$sel1->do_select();

if($class_id<>'') {
 $query = "select a.stud_id,a.stud_name,b.seme_num,a.stud_study_cond from stud_base a , stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$_REQUEST[year_seme]' and seme_class='$_REQUEST[class_id]' order by b.seme_num";
	$result = $CONN->Execute($query) or die ($query);
	if (!$result->EOF) {		
 		echo '&nbsp;<input type="button" value="����" onClick="javascript:tagall(1);">';
 		echo '<input type="button" value="��������" onClick="javascript:tagall(0);">';
		echo "&nbsp;<input type='submit' name='do_key' value='$postBtn' onclick='this.form.target=\"$class_id\"'>";
		echo "<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size:9pt;' bordercolor='#111111' id='AutoNumber1'>";
		$ii=0;
		while (!$result->EOF) {
			$stud_id = $result->fields[stud_id];
			$stud_name = $result->fields[stud_name];
			$curr_class_num = sprintf('%02d',$result->fields[seme_num]);
			$stud_study_cond = $result->fields[stud_study_cond];
			$move_kind ='';
			if ($stud_study_cond >0)
				$move_kind= "<font color=red>(".$move_kind_arr[$stud_study_cond].")</font>";

			if ($ii %2 ==0)
				$tr_class = "class=title_sbody1";
			else
				$tr_class = "class=title_sbody2";
			
			if ($ii % 5 == 0)
				echo "<tr $tr_class >";
			echo "<td ><input id=\"c_$stud_id\" type=\"checkbox\" name=\"sel_stud[]\" value=\"$stud_id\"><label for=\"c_$stud_id\">$curr_class_num. $stud_name $move_kind</label></td>\n";
				
			if ($ii % 5 == 4)
				echo "</tr>";
			$ii++;
			$result->MoveNext();
		}
		echo"</table>";
	}
}

echo "<ul>
<li>
<p style='margin-top: 3; margin-bottom: 0'><font size='2' color='#3333CC'>
�`�N�ƶ��G</font></p>
<p style='margin-top: 3; margin-bottom: 0'><font color='#3333CC'>
<span style='font-family: �s�ө���'><font size='2'>��</font></span><font size='2'>���������ɰO����Y�ѷӦ�95��pA4�榡�C</font></font></p>
<p style='margin-top: 3; margin-bottom: 0'><font color='#3333CC'>
<span style='font-family: �s�ө���'><font size='2'>��</font></span><font size='2'>������������X�ͰO�����ƻP�r�ơC</font></font></p>
<p style='margin-top: 3; margin-bottom: 0'><font color='#3333CC'>
<span style='font-family: �s�ө���'><font size='2'>��</font></span><font size='2'>�������W�[�S���{�O���C</font></font></p>
</li>
</ul>";

foot();



function get_eduh_item_list() {
	$edu_item_arr['eduh_relation_item']='�������Y';
	$edu_item_arr['eduh_kind_item']='�a�x����';
	$edu_item_arr['eduh_air_item']='�a�x��^';
	$edu_item_arr['eduh_father_item']='�ޱФ覡';
	$edu_item_arr['eduh_mother_item']='�ޱФ覡';
	$edu_item_arr['eduh_live_item']='�~����';
	$edu_item_arr['eduh_rich_item']='�g�٪��p';
	$edu_item_arr['eduh_s1_item']='�߷R�x�����';
	$edu_item_arr['eduh_s2_item']='�߷R�x�����';
	$edu_item_arr['eduh_s3_item']='�S��~��';
	$edu_item_arr['eduh_s4_item']='����';
	$edu_item_arr['eduh_s5_item']='�ͬ��ߺD';
	$edu_item_arr['eduh_s6_item']='�H�����Y';
	$edu_item_arr['eduh_s7_item']='�~�V�欰';
	$edu_item_arr['eduh_s8_item']='���V�欰';
	$edu_item_arr['eduh_s9_item']='�ǲߦ欰';
	$edu_item_arr['eduh_s10_item']='���}�ߺD';
	$edu_item_arr['eduh_s11_item']='�J�{�欰';
	
	foreach($edu_item_arr as $key=>$value){
		$result_arr=array();
		$result_arr=sfs_text($value);
		$data_list='';
		foreach($result_arr as $key2=>$value2)	$data_list.="$key2.$value2 ";
		$eduh_item_list[$key]['title']=$value;
		$eduh_item_list[$key]['items']=$data_list;	
	}
	return $eduh_item_list;
}


?>
