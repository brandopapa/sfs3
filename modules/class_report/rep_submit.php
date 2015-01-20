<?php
include_once('config.php');

include_once "../../include/sfs_case_PLlib.php";
include_once "../../include/sfs_case_score.php";
include_once "../modules/score_input/myfun2.php";

sfs_check();

//�s�@��� ( $school_menu_p�}�C�]�w�� module-cfg.php )
$tool_bar=&make_menu($school_menu_p);

//Ū���ثe�ާ@���Ѯv���S���޲z�v
$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);

//�ϥΪ̻{��
sfs_check();
//���o���Ǧ~
$sel_year = curr_year();
//���o���Ǵ�
$sel_seme = curr_seme();
//�ثe�Ǵ�
$c_curr_seme=sprintf("%03d%d",$sel_year ,$sel_seme);

//�Ǵ���ƪ�W��
$score_semester="score_semester_".$sel_year."_".$sel_seme;
$nor_score="nor_score_".$sel_year."_".$sel_seme;

//POST�᪺�ʧ@****************************************/
if ($_POST['act']=='SUBMIT_IT') {
	//
	$query = "select teacher_sn,class_id,ss_id from score_course where course_id='$_POST[teacher_course]'";
	$update_rs=$CONN->Execute($query);
	$teacher_sn=$update_rs->fields['teacher_sn'];
	$class_id=$update_rs->fields['class_id'];
	$ss_id=$update_rs->fields['ss_id'];
	
	$test_kind="���ɦ��Z";
	$now=date("Y-m-d H:i:s");
	
	$test_sort=$_POST['curr_sort'];
	
	
		$REP_SETUP=get_report_setup($_POST['the_report']);
		//���o�Ҧ��ǥ�
	  $STUD=get_seme_class_students($REP_SETUP['seme_year_seme'],$REP_SETUP['seme_class']);
	  //���o�Ҧ����Z
	  $SCORES=get_report_score_all($REP_SETUP['sn'],1);	  
		
		foreach ($STUD as $V) {
	  	$score=number_format($SCORES[$V['student_sn']]['avg'],2);
	  	$student_sn=$V['student_sn'];
			$sql = "REPLACE INTO $score_semester(class_id,student_sn,ss_id,score,test_name,test_kind,test_sort,update_time,teacher_sn) values('$class_id','$student_sn','$ss_id','$score','$test_kind','$test_kind','$test_sort','$now','$_SESSION[session_tea_sn]')";
			$res=$CONN->Execute($sql) or die("SQL���~, query=".$sql);
		}
		
		$sql="update class_report_setup set locked=1 where sn='".$REP_SETUP['sn']."'";
	  $res=$CONN->Execute($sql) or die("SQL���~, query=".$sql);

		$INFO="�w��".date("Y-m-d H:i:s")."�ץX�ܡu�Ǵ����Z�v������".$test_sort."���q���`���Z, �аO�o�z�L�u���Z�޲z�v�ҲսT�{!!";
}

if ($_POST['act']=="SUBMIT_NORMAL") {
	 	//�ҵ{�����]�w
	 	$teacher_course=$_POST['teacher_course'];
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

		//�p�Ҧ��Z�檺���Z
		$REP_SETUP=get_report_setup($_POST['the_report']);
		//���o�Ҧ��ǥ�
	  $STUD=get_seme_class_students($REP_SETUP['seme_year_seme'],$REP_SETUP['seme_class']);
	  //���o�Ҧ����Z
	  $SCORES=get_report_score_all($REP_SETUP['sn'],1);	  
		
		//���`���Z���]�w��
		$teach_id=$_SESSION['session_log_id'];
		$class_subj=(strstr($teacher_course,'g'))? $teacher_course:$class_id."_".$subject_id;

		$test_name=$_SESSION['session_tea_name'].date("is"); 	//�H�Юv����m�W+����
		$curr_sort=$_POST['curr_sort'];

		$query="select max(freq) from $nor_score where class_subj='$class_subj' and stage='$curr_sort' and enable='1'";
		$res=$CONN->Execute($query);
		$next_freq=$res->fields[0]+1;						//�ĴX��
		$weighted=1;														//�[�v
		foreach ($STUD as $V) {
			$student_sn=$V['student_sn'];	
	  	$score=number_format($SCORES[$V['student_sn']]['avg'],2);
	  	$score=($score==0)?"-100":$score;
			$sql="replace into $nor_score (teach_id,stud_sn,class_subj,stage,test_name,test_score,weighted,enable,freq) values ('$teach_id','$student_sn','$class_subj','$curr_sort','$test_name','$score','$weighted','1','$next_freq')";
			$CONN->Execute($sql);
	  }
	  
	  $sql="update class_report_setup set locked=1 where sn='".$REP_SETUP['sn']."'";
	  $res=$CONN->Execute($sql) or die("SQL���~, query=".$sql);
	  
	  $INFO="�w��".date("Y-m-d H:i:s")."�s�W�@����".$curr_sort."���q�����ɦ��Z�m�W��:".$test_name."[�[�v1]�n,�аȥ��z�L�u���Z�޲z�v�Ҳսվ��ئW�٤Υ[�v�C";
}

//���]�C�J�έp�����Z
if ($_POST['act']=='check_real_sum') {
	$the_report=$_POST['the_report'];
	$sql="update class_report_test set real_sum='0' where report_sn='$the_report'";
	$res=$CONN->Execute($sql) or die("SQL���~, query=".$sql);
	
	foreach ($_POST['real_sum'] as $sn=>$v) {
		$sql="update class_report_test set real_sum='1' where sn='$sn'";
		$res=$CONN->Execute($sql) or die("SQL���~, query=".$sql);
	}
}
/*****************************************************/
//���o�ɮv�ίť��Z��
$class_num = get_teach_class();

//�Юv�N��
$teacher_sn = $_SESSION[session_tea_sn];

//����ئW��
$subject_arr = get_subject_name_arr();

//���o���Ǵ��Z�Ű}�C
$class_name_arr = class_base();

//�U�Կ���ܼ��ഫ
$teacher_course = $_REQUEST[teacher_course];
/*
if (!empty($teacher_course)) {
	if (!check_course($teacher_sn,$teacher_course)) echo "get_out!";
}
*/
$curr_sort = $_REQUEST[curr_sort];

//���q�W�ٰ}�C
$test_sort_name=array("","�Ĥ@���q","�ĤG���q","�ĤT���q","�ĥ|���q","�Ĥ����q","�Ĥ����q","�ĤC���q","�ĤK���q","�ĤE���q","�ĤQ���q",255 => "���Ǵ�");

//2003-12-25�s�W�A�����X���սҵ{�����
$query="select * from score_ss where year='$sel_year' and semester='$sel_seme' and enable='1'";
$res=$CONN->Execute($query);
while(!$res->EOF) {
	$all_ss_id.="'".$res->fields[ss_id]."',";
	$res->MoveNext();
}
if ($all_ss_id) $all_ss_id=substr($all_ss_id,0,-1);
$sql_sub="select * from elective_tea where teacher_sn='$teacher_sn' and ss_id in ($all_ss_id)";
$rs_sub=$CONN->Execute($sql_sub) or creat_elective();
if($rs_sub){
	$sub=0;
	while(!$rs_sub->EOF){
		//�@�˭n��X��ئW
		$group_id=$rs_sub->fields['group_id'];
		$group_name=$rs_sub->fields['group_name'];
		$ss_id=$rs_sub->fields['ss_id'];
		$cid=$rs_sub->fields['course_id'];

		//�o�Ӭ�ػݭn�ҸնܡH
		$query = "select need_exam from score_ss where ss_id='$ss_id' ";
		$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		$need_exam = $res->fields['need_exam'];
		if($need_exam){
			$class_subj=ss_id_to_class_subject_name($ss_id);
			$class_subj_group=$class_subj."-".$group_name;
			$gs_id=$group_id."g".$ss_id;
			$e_arr[$cid]=$gs_id;
			$course_arr[$gs_id]=$class_subj_group;
			$sub++;
		}
		$rs_sub->MoveNext();
	}
}

//���o���T���нҵ{
$course_arr_all=get_teacher_course(curr_year(),curr_seme(),$teacher_sn,$is_allow);

$allow_arr = $course_arr_all['allow'];
$course_arr = $course_arr_all['course'];

// �ˬd�ҵ{�v���O�_���T
$cc_arr=array_keys($course_arr);
$err=(in_array($teacher_course,$cc_arr) || $teacher_course=="")?0:1;

// �إ߾Ǵ����Z��ƪ�
//--------------------
$creat_table_sql="CREATE TABLE  if not exists $score_semester (
		  score_id bigint(10) unsigned NOT NULL auto_increment,
		  class_id varchar(11) NOT NULL default '',
		  student_sn int(10) unsigned NOT NULL default '0',
		  ss_id smallint(5) unsigned NOT NULL default '0',
		  score float  NOT NULL default '0',
		  test_name varchar(20) NOT NULL default '',
		  test_kind varchar(10) NOT NULL default '�w�����q',
		  test_sort tinyint(3) unsigned NOT NULL default '0',
		  update_time datetime NOT NULL default '0000-00-00 00:00:00',
		  sendmit enum('0','1') NOT NULL default '1',
 		  teacher_sn smallint(6) NOT NULL default '0',
		  PRIMARY KEY  (student_sn,ss_id,test_kind,test_sort),
		  UNIQUE KEY score_id (score_id)  
                  )";
$CONN->Execute($creat_table_sql);

// �إߥ��`���Z��ƪ�
//�Y�O�ӾǴ������ɦ��Z��ƪ��s�b�N�̷өR�W�W�h�۰ʫإߤ@�� 	 
$creat_table_sql="
	CREATE TABLE if not exists $nor_score ( 	 
	sn int(11) NOT NULL auto_increment, 	 
	teach_id varchar(20) NOT NULL default '', 	 
	stud_sn int(10) unsigned NOT NULL default '0', 	 
	class_subj varchar(40) NOT NULL default '', 	 
	stage tinyint(1) unsigned NOT NULL default '0', 	 
	test_name varchar(40) NOT NULL default '', 	 
	test_score float default '-100', 	 
	weighted int(2) NOT NULL default '1', 	 
	enable tinyint(1) unsigned NOT NULL default '1', 	 
	freq int(10) unsigned NOT NULL default '0', 	 
	PRIMARY KEY  (`sn`),
	KEY `teach_id` (`teach_id`,`stud_sn`))"; 	 
$rs=$CONN->Execute($creat_table_sql);

//��ؤU�Կ�� -------------
$sel= new drop_select();
$sel->s_name = "teacher_course";
$sel->id = $teacher_course;
$sel->is_submit = true;
//$sel->other_script = "document.myform.the_report.value=''";
$sel->arr = $course_arr;
$sel->top_option = "��ܯZ�Ŭ��";
$sel->font_style="";
$sel->font_color = "#F71CFF";
$sel->is_bgcolor_list = true;
$course_sel = $sel->get_select();
//------------- ��ؤU�Կ�� ����

if(strstr ($teacher_course, 'g')){

	//���սҵ{�����q�U�Կ�� ------------
	$teacher_course_arr=explode("g",$teacher_course);
	$group_id=$teacher_course_arr[0];
	$ss_id=$teacher_course_arr[1];

	//�ˬd�O�_�O���㪺�ҵ{�A�N�O�n��Ҫ��աI
	$query = "select print from score_ss where ss_id='$ss_id' ";
	$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
	$print = $res->fields['print'];

}else{
	//���q�U�Կ�� ------------
	$query = "select a.ss_id,a.class_id,b.print from score_course a, score_ss b where a.ss_id=b.ss_id and a.course_id='$teacher_course' and b.enable='1'";
	$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
	$class_id = $res->fields['class_id'];
	$ss_id = $res->fields['ss_id'];
	$print = $res->fields['print'];
}

//���o�Ҧ��ǥ͸��
$all_sn="";
$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
if(strstr ($teacher_course, 'g')){
	$query = "select class_year from score_ss where ss_id='$ss_id'";
	$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
	$class_year= $res->fields['class_year'];
	$teacher_course_arr=explode("g",$teacher_course);
	$query="select a.* from elective_stu a,stud_base b where a.student_sn=b.student_sn and a.group_id='$teacher_course_arr[0]' and b.stud_study_cond in ($in_study) order by b.curr_class_num";
}else{
	if ($class_id) $class_arr=class_id_2_old($class_id);
	$class_year=$class_arr[3];
	$query="select a.* from stud_seme a,stud_base b where a.student_sn=b.student_sn and a.seme_year_seme='$seme_year_seme' and a.seme_class='$class_arr[2]' and b.stud_study_cond in ($in_study) order by a.seme_num";
}
$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
if ($res)
	while (!$res->EOF) {
		$student_sn=$res->fields['student_sn'];
		$all_sn.="'".$student_sn."',";
		$res->MoveNext();
	}
if ($all_sn) $all_sn=substr($all_sn,0,-1);

// ��ا����(�t���q�ξǴ����Z),�~�X�{���q�U�Կ��
if ($print=="1") {
	$query = "select performance_test_times,score_mode,test_ratio from score_setup where  class_year='$class_year' and year=$sel_year and semester='$sel_seme' and enable='1'";
	$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
	//���禸��
	$performance_test_times = $res->fields[performance_test_times];
	//���Z�t����Ҭ����]�w
	$score_mode = $res->fields[score_mode];
	//��v
	$test_ratios = $res->fields[test_ratio];

	if ($curr_sort <254 && $curr_sort> $performance_test_times)	$curr_sort='';
	//�p�G����ܶ��q�ɦ۰ʨ��o�U�Ӷ��q
	//�����ɦ��Z�~,���q���Z���v���ר�аȳB
	$temp_script = '';
	if ($curr_sort=='' || ($_POST[curr_sort_hidden] <>'' and $curr_sort<>$_POST[curr_sort_hidden]) and $curr_sort<254) {
		//�p��ثe���b�ĴX���q (sendmit = 0 ��ܤw�e�ܱаȳB���Z)
		$query ="select max(test_sort) as mm from $score_semester where student_sn in ($all_sn) and ss_id='$ss_id' and sendmit='0' and test_sort<254";
		$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		$mm = $res->fields[0]+1;
		if ($curr_sort =='')	$curr_sort = $mm;
		if ($curr_sort>$performance_test_times)	$curr_sort = $performance_test_times;
			
	}
	//��v����
	if($score_mode=="all"){
		$test_ratio=explode("-",$test_ratios);
	}
	elseif($score_mode=="severally"){
		$temp_arr=explode(",",$test_ratios);
		$i=$curr_sort-1;
		$test_ratio=explode("-",$temp_arr[$i]);
	}
	else{
		$test_ratio[0]=60;
		$test_ratio[1]=40;
	}


	//���ͤU�Կ�涵�ذ}�C
	for($i=1;$i<= $performance_test_times;$i++)
		$test_times_arr[$i] = "�� $i ���q";

	//�p�G���O�C�@���q�������ɦ��Z��,�X�{�Ǵ����ɦ��Z�ﶵ
	if ($yorn=='n')
		$test_times_arr[254] = "���ɦ��Z";
	
	//���ͤU�Կ��
	$sel= new drop_select();
	$sel->s_name = "curr_sort";
	$sel->id = $curr_sort;
	$sel->is_submit = true;
	$sel->arr = $test_times_arr;
	$sel->font_style="";
	$sel->top_option = "��ܶ��q";
	$select_stage_bar = $sel->get_select();	
	//�O��W�� curr_sort ��,���P�O��
	$select_stage_bar .= "<input type=\"hidden\" name=\"curr_sort_hidden\" value=\"$curr_sort\">";

}
//���Ǵ��u��J�@�����Z
else
	$curr_sort = 255;

//--------------���q�U�Կ�� ����
$check_allow = "";

//�P�O�O�_��ܤ��\�ɮv�ק�\��
if($class_num) $class_num_temp=sprintf("%03d_%d_%02d_%02d",$sel_year,$sel_seme,substr($class_num,0,-2),substr($class_num,-2));
if ($is_allow=='y')
	
	if(($teacher_course) && ($class_id!=$class_num_temp)) {
	        if ($allow_arr[$teacher_course]=='1') {
			$check_allow = "<input type=\"submit\" name=\"need_allow\" value=\"����\" style=\"border-style:solid; border-width:1px; font-size: 10pt; padding-top: 0; padding-bottom: 0; background-color:#EFDEC8\" >&nbsp<span style=\"font-size: 10pt; background-color:#FFF6C6\">�ť��ɮv���i�ק糧�즨�Z(�ثe�]�w�G�ɮv���i�ק�)</span>";
	        }
	        else {
			$check_allow = "<input type=\"submit\" name=\"need_allow\" value=\"�}��\" style=\"border-style:solid; border-width:1px; font-size: 10pt; padding-top: 0; padding-bottom: 0; background-color:#C5CDEF\" >&nbsp<span style=\"font-size: 10pt; background-color:#FFF6C6\">�ť��ɮv���i�ק糧�즨�Z(�ثe�]�w�G�ɮv�i�ק�)</span>";
		}
	}

// �W����
$top_str = "<form action=\"$_SERVER[SCRIPT_NAME]\" name=\"myform\" method=\"post\">$course_sel &nbsp; $select_stage_bar &nbsp;$check_allow ";

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

//���o�Z�Ťά�ئW��
$full_class_name = $course_arr[$teacher_course];


//�q�X SFS3 ���D
head();

//�C�X���
echo $tool_bar;

//���稭��, �è��X�iŪ�������Z��
if ($_SESSION['session_who']!='�Юv') {
		echo "�����Юv�M�Υ\��!";
		exit();
}

?>

<font color="#0000FF"><b>�п�ܭn�פJ���Z�Ŭ�ؤζ��q:</b></font><br>
<?php
echo $top_str;

if ($_POST['teacher_course']) {
	
//$_POST['curr_sort']�|�۰ʿ�̷ܳs���q
//���o�ثe�Ǵ����Ҧ��iŪ�������Z��

	$query = "select teacher_sn,class_id,ss_id from score_course where course_id='$_POST[teacher_course]'";
	$update_rs=$CONN->Execute($query);
	$teacher_sn=$update_rs->fields['teacher_sn'];
	$class_id=$update_rs->fields['class_id'];
	$ss_id=$update_rs->fields['ss_id'];
	$class_num=sprintf("%d%02d",substr($class_id,6,2),substr($class_id,9,2));
	$select_report=get_report("list",$c_curr_seme,$class_num);
?>
<br><font color="#0000FF"><b>�п�ܱz���p�Ҧ��Z��:</b></font><br>
	<input type="hidden" name="act" value="">
	<select size="1" name="the_report" onchange="document.myform.submit()">
		<option>--�п�ܦ��Z��--</option>
		<?php
		foreach ($select_report as $k=>$v) {
		?>
			<option value="<?php echo $v['sn'];?>"<?php if ($_POST['the_report']==$v['sn']) { echo " selected"; $OK=1; } ?>><?php echo "[".$v['seme_class_cname']."]".$v['title'];?></option>
		<?php
		}
		?>
	</select>	
<?php
	if ($_POST['the_report'] and $OK==1) {
			//�ˬd�O�_�w�פJ�аȳB
			$REP_SETUP=get_report_setup($_POST['the_report']);
			$STUD=get_seme_class_students($REP_SETUP['seme_year_seme'],$REP_SETUP['seme_class']);
			foreach ($STUD as $V) {
				$all_sn.="'".$V['student_sn']."',";
		  }
		  if ($all_sn) $all_sn=substr($all_sn,0,-1);
			$query = "select count(*) from $score_semester where student_sn in ($all_sn) and ss_id='$ss_id' and test_sort='".$_POST['curr_sort']."' and test_kind='�w�����q' and sendmit='0'";
			$res= $CONN->Execute($query) or die("SQL���~, query=".$query);
			$is_send = $res->fields[0];
			
		if ($is_send==0 and $REP_SETUP['locked']==0) {		
		?>
		<input type="button" value="�ץX�������Ʀܡy���`���Z�z�@���@�����Z" style="color:#FF00FF" onclick="document.myform.act.value='SUBMIT_NORMAL';document.myform.submit()">
		<input type="button" value="�����ץX�������Ʀܡy�Ǵ����Z�z�����`���Z" style="color:#FF00FF" onclick="document.myform.act.value='SUBMIT_IT';document.myform.submit()">
		<?php
		} else {
			echo "<font color=red size=2><i>�����q���Z�w�צܱаȳB, �L�k�N�p�Ҧ��Z�A�צܾǴ��Υ��`���Z!!</i></font>";
		} 
		
		// end if is_send
		?>
		<table border="0">
			<tr>
				<td style="color:#FF0000"><?php echo $INFO;?></td>
			</tr>
		</table>
		<?php
		//�C�X���Z
		list_class_score($REP_SETUP,0,1,1,1,1,1);
	
	
	} // end if ($_POST['the_report'])
} // end if ($_POST['teacher_course'] and $_POST['curr_sort'])

?>
</form>