<?php
// $Id: normal.php 7977 2014-04-10 07:34:47Z infodaes $
/*�ޤJ�ǰȨt�γ]�w��*/
include "config.php";
include "./module-upgrade.php";
require_once "../../include/sfs_case_score.php";
//�ޤJ���
include "./my_fun.php";

//�ϥΪ̻{��
sfs_check();

//���o�Ҳճ]�w
$m_arr = get_sfs_module_set();
extract($m_arr, EXTR_OVERWRITE);

//�ܼƳ]�w
$edit=$_GET['edit'];
$is_print=$_GET['print'];
$yorn=findyorn();
$teacher_course = $_REQUEST[teacher_course];
$curr_sort = $_REQUEST[curr_sort];
if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�

//�Юv�N��
$teacher_sn = $_SESSION[session_tea_sn];

//���Z��W��
$nor_score="nor_score_".curr_year()."_".curr_seme();
$score_semester="score_semester_".curr_year()."_".curr_seme();

 //�Y�O�ӾǴ������ɦ��Z��ƪ��s�b�N�̷өR�W�W�h�۰ʫإߤ@�� 	 
$creat_table_sql="
	CREATE TABLE if not exists $nor_score ( 	 
	sn int(11) NOT NULL auto_increment, 	 
	teach_id varchar(20) NOT NULL default '', 	 
	stud_sn int(10) unsigned NOT NULL default '0', 	 
	class_subj varchar(40) NOT NULL default '', 
	elective_id varchar(10) NOT NULL default '', 	
	stage tinyint(1) unsigned NOT NULL default '0', 	 
	test_name varchar(40) NOT NULL default '', 	 
	test_score float default '-100', 	 
	weighted int(2) NOT NULL default '1', 	 
	enable tinyint(1) unsigned NOT NULL default '1', 	 
	freq int(10) unsigned NOT NULL default '0', 	 
	PRIMARY KEY  (`sn`),
	KEY `teach_id` (`teach_id`,`stud_sn`)
	KEY `elective_id` (`elective_id`))"; 	 
$rs=$CONN->Execute($creat_table_sql);

//���o���T���нҵ{
$course_arr_all=get_teacher_course(curr_year(),curr_seme(),$teacher_sn,$is_allow);
$course_arr = $course_arr_all['course'];
// �ˬd�ҵ{�v���O�_���T
$cc_arr=array_keys($course_arr);
$err=(in_array($teacher_course,$cc_arr) || $teacher_course=="")?0:1;

if ($err==0) {

	//��ؤU�Կ�� -------------
	$sel= new drop_select();
	$sel->s_name = "teacher_course";
	$sel->id = $teacher_course;
	$sel->is_submit = true;
	$sel->arr = $course_arr;
	$sel->top_option = "��ܯZ�Ŭ��";
	$sel->font_style="";
	$sel->font_color = "#F75500";
	$sel->is_bgcolor_list = true;
	$course_sel = $sel->get_select();
	//------------- ��ؤU�Կ�� ����
	$smarty->assign("course_sel",$course_sel);

	if(strstr ($teacher_course, 'g')){

		//���սҵ{�����q�U�Կ�� ------------
		$teacher_course_arr=explode("g",$teacher_course);
		$group_id=$teacher_course_arr[0];
		$ss_id=$teacher_course_arr[1];

		//�ˬd�O�_�O���㪺�ҵ{�A�N�O�n��Ҫ��աI
		$query = "select scope_id,subject_id,print from score_ss where ss_id='$ss_id' ";
		$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		$print = $res->fields['print'];

	}else{
		//���q�U�Կ�� ------------
		$query = "select a.ss_id,a.class_id,b.scope_id,b.subject_id,b.print from score_course a, score_ss b where a.ss_id=b.ss_id and a.course_id='$teacher_course' and b.enable='1'";
		$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		$class_id = $res->fields['class_id'];
		$ss_id = $res->fields['ss_id'];
		$print = $res->fields['print'];
	}
	//���o��إN�X
	$subject_id=$res->fields[subject_id];
	if ($subject_id==0) {
		$subject_id=$res->fields[scope_id];
	}

	//���o�Ҧ��ǥ͸��
	$all_sn="";
	$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
	if(strstr($teacher_course, 'g')){
		$query = "select class_year from score_ss where ss_id='$ss_id'";
		$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		$class_year= $res->fields['class_year'];
		$teacher_course_arr=explode("g",$teacher_course);
		$query="select a.*,b.stud_name,b.curr_class_num,b.stud_id,b.stud_study_year from elective_stu a,stud_base b where a.student_sn=b.student_sn and a.group_id='$teacher_course_arr[0]' and b.stud_study_cond in ($in_study) order by b.curr_class_num";
	}else{
		if ($class_id) $class_arr=class_id_2_old($class_id);
		$class_year=$class_arr[3];
		$query="select a.*,b.stud_name,b.curr_class_num,b.stud_id,b.stud_study_year from stud_seme a,stud_base b where a.student_sn=b.student_sn and a.seme_year_seme='$seme_year_seme' and a.seme_class='$class_arr[2]' and b.stud_study_cond in ($in_study) order by a.seme_num";
	}
	$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
	if ($res)
		while (!$res->EOF) {
			$student_sn=$res->fields['student_sn'];
			$stud_list[$student_sn][site_num]=(strstr($teacher_course,'g'))? substr($res->fields[curr_class_num],-4,2)."_".substr($res->fields[curr_class_num],-2,2):$res->fields[seme_num];
			$stud_list[$student_sn][name]=$res->fields[stud_name];
			$stud_list[$student_sn][stud_id]=$res->fields[stud_id];
			$stud_list[$student_sn][class_id]=sprintf("%03d_%d_%02d_%02d",$sel_year,$sel_seme,substr($res->fields[curr_class_num],0,-4),substr($res->fields[curr_class_num],-4,2));
			$stud_study_year=$res->fields[stud_study_year];
			$stud_list[$student_sn][stud_study_year]=$stud_study_year;
			$img=$UPLOAD_PATH."photo/student/".$stud_study_year."/".$res->fields[stud_id];
			if (file_exists($img)) $stud_list[$student_sn][pic]="1";			
			$all_sn.="'".$student_sn."',";
			$res->MoveNext();
		}
	if ($all_sn) $all_sn=substr($all_sn,0,-1);
	$smarty->assign("stud_list",$stud_list);

	// ��ا����(�t���q�ξǴ����Z),�~�X�{���q�U�Կ��
	if ($print=="1") {
		$query = "select performance_test_times,score_mode,test_ratio from score_setup where  class_year='$class_year' and year=$sel_year and semester='$sel_seme' and enable='1'";
		$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);

		//���禸��
		$performance_test_times = $res->fields[performance_test_times];

		if ($curr_sort <254 && $curr_sort> $performance_test_times)	$curr_sort='';
		//�p�G����ܶ��q�ɦ۰ʨ��o�U�Ӷ��q
		if ($curr_sort=='' || ($_POST[curr_sort_hidden] <>'' and $curr_sort<>$_POST[curr_sort_hidden]) and $curr_sort<254) {
			//�p��ثe���b�ĴX���q (sendmit = 0 ��ܤw�e�ܱаȳB���Z)
			$query ="select max(test_sort) as mm from $score_semester where student_sn in ($all_sn) and ss_id='$ss_id' and sendmit='0' and test_sort<254";
			$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
			$mm = $res->fields[0]+1;
			if ($curr_sort =='')	$curr_sort = $mm;
			if ($curr_sort>$performance_test_times)	$curr_sort = $performance_test_times;
		}

		//�p�G���O�C�@���q�������ɦ��Z��,�X�{�Ǵ����ɦ��Z�ﶵ
		if ($yorn=='n') {
			$test_times_arr[254] = "���ɦ��Z";
			$curr_sort=254;
		} else {
			//���ͤU�Կ�涵�ذ}�C
			for($i=1;$i<= $performance_test_times;$i++)
				$test_times_arr[$i] = "�� $i ���q";
		}

	} else  {
		//���Ǵ��u��J�@�����Z
		$curr_sort = 255;
		$test_times_arr[255] = "�������q";
	}
	
	//���ͤU�Կ��
	$sel= new drop_select();
	$sel->s_name = "curr_sort";
	$sel->id = $curr_sort;
	$sel->is_submit = true;
	$sel->arr = $test_times_arr;
	$sel->font_style="";
	$sel->has_empty=false;
	$select_stage_bar = $sel->get_select();	
	//�O��W�� curr_sort ��,���P�O��
	$select_stage_bar .= "<input type=\"hidden\" name=\"curr_sort_hidden\" value=\"$curr_sort\">";

	//--------------���q�U�Կ�� ����
	$smarty->assign("curr_sort",$curr_sort);
	$smarty->assign("stage_sel",$select_stage_bar);

	//���o�Z�Ťά�ئW��
	$full_class_name = $course_arr[$teacher_course];

	//���o����N�X
	$class_subj=(strstr($teacher_course,'g'))? $teacher_course:$class_id."_".$subject_id;
	$smarty->assign("class_subj",$class_subj);

	//�p�G�O�s�W�@�����ɦ��Z
	if ($_POST[add]) {
		if(strstr($teacher_course, 'g'))
			$test_name=ss_id_to_subject_name($ss_id)."���ե�".date("is");
		else
			$test_name=ss_id_to_subject_name($ss_id)."��".date("is");
		$query="select max(freq) from $nor_score where class_subj='$class_subj' and stage='$curr_sort' and enable='1'";
		$res=$CONN->Execute($query);
		$next_freq=$res->fields[0]+1;
		reset($stud_list);
		//while(list($student_sn,$v)=each($stud_list)) {
		foreach( $stud_list as $student_sn=>$v) {
			$CONN->Execute("insert into $nor_score (teach_id,stud_sn,class_subj,stage,test_name,test_score,weighted,enable,freq) values ('$_SESSION[session_log_id]','$student_sn','$class_subj','$curr_sort','$test_name','-100','1','1','$next_freq')");
		}
		header("Location: normal.php?teacher_course={$_REQUEST['teacher_course']}&curr_sort=$curr_sort");
		exit;
	}

	//�p�G�O�x�s���Z
	if ($_POST[save]) {
		//while(list($student_sn,$score)=each($_POST[nor_score])) {
		foreach($_POST['nor_score'] as $student_sn=>$score) {			
			if ($score=="") $score="-100";
			if (substr($student_sn,0,1)=='n'){
				$student_sn = substr($student_sn,1);
				//��ǥ�
				$query = "insert into $nor_score (teach_id,stud_sn,class_subj,stage,test_name,test_score,weighted,enable,freq) values ('$_SESSION[session_log_id]','$student_sn','$class_subj','$curr_sort','$_POST[test_name]','$score','$_POST[weighted]','1','$_POST[freq]')";
				//echo $query;
			}
			else {
				$query="update $nor_score set test_name='$_POST[test_name]',test_score='$score',weighted='$_POST[weighted]' where teach_id='$_SESSION[session_log_id]' and stud_sn='$student_sn' and stage='$curr_sort' and class_subj='$class_subj' and freq='$_POST[freq]'";
			}
			$res=$CONN->Execute($query);
		}
		if ($_POST['quick']){
			echo "<html><body><script LANGUAGE=\"JavaScript\">javascript:window.opener.location.reload(); window.close();</script></body></html>";
			exit;
		}
	}

	//�ˬd�O�_ú�ܱаȳB
	if($yorn=='n' && $curr_sort != 255 ){
		if($curr_sort == 254){
			$query = "select count(*) from $score_semester where student_sn in ($all_sn) and ss_id='$ss_id' and test_kind='���ɦ��Z' and sendmit='0'";
		}else{
			$query = "select count(*) from $score_semester where student_sn in ($all_sn) and ss_id='$ss_id' and test_sort='$curr_sort' and test_kind='�w�����q' and sendmit='0'";
		}
	}else{
		$query = "select count(*) from $score_semester where student_sn in ($all_sn) and ss_id='$ss_id' and test_sort='$curr_sort' and sendmit='0'";
	}
	$res= $CONN->Execute($query);
	$is_send = $res->fields[0];
	$smarty->assign("is_send",$is_send);

	//���o���Z
	$data_arr=get_nor_score($sel_year,$sel_seme,$curr_sort,$class_subj,$teacher_sn,2);  //2�O�p���p�ƲĤG��
	
	//�F�Ѥw�}�]�����ؼ�
	$nor_item_already_count=$data_arr[status];
	if($ss_id and !$nor_item_already_count){
		//������ɦ��Z�w�w����
		$query = "select nor_item_kind from score_ss where ss_id=$ss_id";
		$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		$nor_item=$res->fields[0];
		if($nor_item){
			//����]�w������
			$nor_item_array=sfs_text('���ɦ��Z�ﶵ');
			$nor_item_data=$nor_item_array[$nor_item];
			$nor_item_data_detail=explode(',',$nor_item_data);
			$nor_item_data_detail_count=count($nor_item_data_detail);
			//�۰ʷs�W�ܶ��ت�
			foreach($nor_item_data_detail as $nor_item_key=>$nor_item_value){
				//���o���ةM�[�v
				$item_array=explode('*',$nor_item_value);
				$test_name=$item_array[0];
				$weighted=$item_array[1]?$item_array[1]:1;
				$next_freq=$nor_item_key+1;
				foreach($stud_list as $stud_sn=>$v){
					$CONN->Execute("insert into $nor_score(teach_id,stud_sn,class_subj,stage,test_name,test_score,weighted,enable,freq) values ('$_SESSION[session_log_id]','$stud_sn','$class_subj','$curr_sort','$test_name','-100','$weighted','1','$next_freq')");
				}			
			}
			//���s������Z
			header("Location: normal.php?teacher_course={$_REQUEST['teacher_course']}&curr_sort=$curr_sort");
		}
	}
//exit;	
	$smarty->assign("data_arr",$data_arr);
	

	//���o�Юv�}�C
	$query="select teach_id,name from teacher_base order by name";
	$res= $CONN->Execute($query);
	while(!$res->EOF) {
		$t_arr[$res->fields[teach_id]]=$res->fields[name];
		$res->MoveNext();
	}
	$smarty->assign("teacher_arr",$t_arr);

	//�p�G�O�ר�аȳB
	if ($_POST[trans]) {
		$update_time=date("Y-m-d H:i:s");
		if ($yorn=="y" || $curr_sort=="255") {
			$test_kind=($curr_sort=="255")?"���Ǵ�":"���ɦ��Z";
			$query="select * from $score_semester where student_sn in ($all_sn) and ss_id='$ss_id' and test_sort='$curr_sort' and test_kind='$test_kind'";
		} else {
			//���Ǵ��u���@�����ɦ��Z
			$test_kind="���ɦ��Z";
			$query="select * from $score_semester where student_sn in ($all_sn) and ss_id='$ss_id' and test_kind='$test_kind'";
		}
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			$data_arr[value][$res->fields[test_sort]][$res->fields[student_sn]]="1";
			$res->MoveNext();
		}

		if ($yorn=="y" || $curr_sort=="255") {
			//while(list($student_sn,$score)=each($data_arr[score][$curr_sort][avg])) {
			foreach($data_arr[score][$curr_sort][avg] as $student_sn=>$score) {
				$cid=$stud_list[$student_sn][class_id];
				if ($data_arr[value][$curr_sort][$student_sn]==1) {
					$query="update $score_semester set score='$score',update_time='$update_time',teacher_sn='$teacher_sn',test_kind='$test_kind' where student_sn='$student_sn' and ss_id='$ss_id' and test_sort='$curr_sort' and  test_kind='$test_kind' ";
					$CONN->Execute($query);
				} else {
					$query="insert into $score_semester (class_id,student_sn,ss_id,score,test_name,test_kind,test_sort,update_time,teacher_sn) values ('$cid','$student_sn','$ss_id','$score','$test_kind','$test_kind','$curr_sort','$update_time','$teacher_sn')";
					$CONN->Execute($query);
				}
			}
		} else {
			//���Ǵ��u���@�����ɦ��Z
			for ($i=1;$i<=$performance_test_times;$i++) {
				reset($data_arr[score][$curr_sort][avg]);
				//while(list($student_sn,$score)=each($data_arr[score][$curr_sort][avg])) {
				foreach( $data_arr[score][$curr_sort][avg] as  $student_sn=>$score) {
					$cid=$stud_list[$student_sn][class_id];
					if ($data_arr[value][$i][$student_sn]==1) {
						$query="update $score_semester set score='$score',update_time='$update_time',teacher_sn='$teacher_sn',test_kind='$test_kind' where student_sn='$student_sn' and ss_id='$ss_id' and test_sort='$i'";
						$CONN->Execute($query);
					} else {
						$query="insert into $score_semester (class_id,student_sn,ss_id,score,test_name,test_kind,test_sort,update_time,teacher_sn) values ('$cid','$student_sn','$ss_id','$score','$test_kind','$test_kind','$i','$update_time','$teacher_sn')";
						$CONN->Execute($query);
					}
				}
			}
		}
		header("Location:manage2.php?is_ok=1&teacher_course=$_POST[teacher_course]&curr_sort=$curr_sort");
	}
	//�M�J�˪�
	$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
	$smarty->assign("module_name","��`���Z�޲z");
	$smarty->assign("SFS_MENU",$menu_p);
	$smarty->assign("SFS_MENU_LINK","teacher_course=".$teacher_course);
	$smarty->assign("is_new_nor",$is_new_nor);
	$smarty->assign("is_mod_nor",$is_mod_nor);
	$smarty->assign("pic_checked",$pic_checked);
	$smarty->assign("pic_width",$pic_width);
	$smarty->assign("UPLOAD_URL",$UPLOAD_URL);

	
				if($pic_checked) {
				//�L�X�Ӥ�
				$img=$UPLOAD_PATH."photo/student/".$stud_study_year."/".$stud_id; 
				$img_link=$UPLOAD_URL."photo/student/".$stud_study_year."/".$stud_id;			
				if (file_exists($img)) $stud_list[$student_sn][pic_data]="<td><img src='$img_link' width=$pic_width></td>"; else $stud_list[$student_sn][pic_data]="<td></td>";
			} else $pic_data="";
	
	if ($_REQUEST[quick]) {
		$smarty->assign("sel_year",$sel_year);
		$smarty->assign("sel_seme",$sel_seme);
		$smarty->assign("full_class_name",$full_class_name);
		$smarty->display("score_input_normal_quick.tpl");
	} else
		$smarty->display("score_input_normal.tpl");

} else {
	$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
	$smarty->assign("module_name","��`���Z�޲z");
	$smarty->assign("SFS_MENU",$menu_p);
	$smarty->display("score_input_err.tpl");
}
?>