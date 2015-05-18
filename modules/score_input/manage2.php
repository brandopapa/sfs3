<?php
// $Id: manage2.php 8420 2015-05-13 07:32:22Z smallduh $


/*�ޤJ�ǰȨt�γ]�w��*/
include "config.php";
include_once "../../include/sfs_case_PLlib.php";
include_once "../../include/sfs_case_score.php";
include_once "../../include/sfs_case_subjectscore.php";
include_once "../../include/sfs_case_studclass.php";
include_once "myfun2.php";
//�ϥΪ̻{��
sfs_check();
//���o���Ǧ~
$sel_year = curr_year();
//���o���Ǵ�
$sel_seme = curr_seme();
//�Ǵ���ƪ�W��
$score_semester="score_semester_".$sel_year."_".$sel_seme;

//���o�ư��W��
$student_out=get_manage_out($sel_year,$sel_seme);

//�C�L�\��
$is_print=$_GET['is_print'];
//�t�}����
$is_openWin=$_GET['is_openWin'];

if ($_POST[dokey]=='�x�s')
	save_semester_score($sel_year,$sel_seme);

else if ($_POST[dokey]=='�ר�аȳB')
	seme_score_input($sel_year,$sel_seme);

else if ($_POST[file_out]<>'')
	download_score($sel_year,$sel_seme);

else if ($_POST[file_in]<>'')
	import_score($sel_year,$sel_seme);

elseif($_POST['file_date']=="���Z�ɮ׶פJ")
	save_import_score();

//���ݭק�
if($_POST[need_allow]<>'' && $is_allow=='y'){
	if ($_POST[need_allow] =='����')
		$need_allow=0;
	else
		$need_allow=1;
	$query = "select teacher_sn,class_id,ss_id from score_course where course_id='$_POST[teacher_course]'";
	$update_rs=$CONN->Execute($query);
	$teacher_sn=$update_rs->fields['teacher_sn'];
	$class_id=$update_rs->fields['class_id'];
	$ss_id=$update_rs->fields['ss_id'];
	$query = "UPDATE score_course SET allow='$need_allow' WHERE teacher_sn='$teacher_sn' and class_id='$class_id' and ss_id='$ss_id'";
	$CONN->Execute($query);
	//echo $query;
}

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
		  test_kind varchar(12) NOT NULL default '�w�����q',
		  test_sort tinyint(3) unsigned NOT NULL default '0',
		  update_time datetime NOT NULL default '0000-00-00 00:00:00',
		  sendmit enum('0','1') NOT NULL default '1',
 		  teacher_sn smallint(6) NOT NULL default '0',
		  PRIMARY KEY  (student_sn,ss_id,test_kind,test_sort),
		  UNIQUE KEY score_id (score_id)  
                  )";
$CONN->Execute($creat_table_sql);

//��ؤU�Կ�� -------------
$sel= new drop_select();
$sel->s_name = "teacher_course";
$sel->id = $teacher_course;
$sel->is_submit = true;
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
$top_str = "<form action=\"$_SERVER[SCRIPT_NAME]\" name=\"myform\" method=\"post\">$course_sel &nbsp; $select_stage_bar &nbsp;$check_allow </form>";

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

if(($teacher_course)&&($curr_sort)){
	if ($is_openWin && $_GET[edit]=='s1')
		$url_str_1 = "a href=\"".$SFS_PATH_HTML.get_store_path()."/quick_input_m.php?edit=s1&class_id=$class_id&teacher_course=$teacher_course&ss_id=$ss_id&curr_sort=$curr_sort&KeepThis=true&TB_iframe=true&height=400&width=700\" class=\"thickbox\" id=\"openWin\"";
	else
		$url_str_1 = "a href=\"".$_SERVER['SCRIPT_NAME']."?edit=s1&teacher_course=$teacher_course&curr_sort=$curr_sort&is_openWin=1\"";
	if ($is_openWin && $_GET[edit]=='s2')
		$url_str_2 = "a href=\"".$SFS_PATH_HTML.get_store_path()."/quick_input_m.php?edit=s2&class_id=$class_id&teacher_course=$teacher_course&ss_id=$ss_id&curr_sort=$curr_sort&KeepThis=true&TB_iframe=true&height=400&width=700\" class=\"thickbox\" id=\"openWin\"";
	else
		$url_str_2 = "a href=\"".$_SERVER['SCRIPT_NAME']."?edit=s2&teacher_course=$teacher_course&curr_sort=$curr_sort&is_openWin=1\"";
	$main="	<small><a href='$_SERVER[SCRIPT_NAME]?teacher_course=$teacher_course&class_id=$class_id&ss_id=$ss_id&curr_sort=$curr_sort&is_print=1' target='new'>�͵��C�L</a></small>
		<table bgcolor=#000000 border=0 cellpadding=2 cellspacing=1>
		<tr bgcolor=#ffffff align=center>
		<td>�Ǹ�</td>
		<td>�y��</td>
		<td>�m�W</td>".($pic_checked?'<td>�j�Y��</td>':'');
	//�Z�ťN��
	$curr_class_temp = sprintf("%d%02d",$class_arr[3],$class_arr[4]);
	//�ǥ�ID hidden ��
	$temp_hidden = "";
	//�������Z hidden ��
	$avg_temp_hidden = "";

	//���q���Z
	if ($curr_sort<254){
		//��e�X���������C�X��  by smallduh 2015.01.23 ================================
		if ($curr_sort>1) {
				$pre_text="";
       for ($PRE_SORT=1;$PRE_SORT<$curr_sort;$PRE_SORT++) {
       	$main.="<td>".$test_sort_name[$PRE_SORT]."����</td>";
			 } // end for
    } // end if		
		//=================================================

		if ($yorn=='n'){
			$main .="<td>�w�����q*".$test_ratio[0]."%";
			if ($is_send==0) $main.="<br><$url_str_1 title=\"".$full_class_name.$test_sort_name[$curr_sort]."�w�����q\"><img src='./images/wedit.png' border='0'></a><a href=\"{$_SERVER['SCRIPT_NAME']}?edit=s1&teacher_course=$teacher_course&curr_sort=$curr_sort\"><img src='./images/pen.png' border='0'></a><a href=\"{$_SERVER['SCRIPT_NAME']}?del=ds1&edit=s1&teacher_course=$teacher_course&curr_sort=$curr_sort\" onClick=\"return confirm('�T�w�R���o�����Z ?');\"><img src='./images/del.png' border='0'></a></td>";
		}
		else {
			if($test_ratio[0]!=0) {
				$main.="<td>�w�����q*".$test_ratio[0]."%";
				if ($is_send==0) $main.="<br><$url_str_1 title=\"".$full_class_name.$test_sort_name[$curr_sort]."�w�����q\"><img src='./images/wedit.png' border='0'></a><a href=\"{$_SERVER['SCRIPT_NAME']}?edit=s1&teacher_course=$teacher_course&curr_sort=$curr_sort\"><img src='./images/pen.png' border='0'></a><a href=\"{$_SERVER['SCRIPT_NAME']}?del=ds1&edit=s1&teacher_course=$teacher_course&curr_sort=$curr_sort\" onClick=\"return confirm('�T�w�R���o�����Z ?');\"><img src='./images/del.png' border='0'></a></td>";
			}
                        if($test_ratio[1]!=0) {
                        	$main.="<td>���ɦ��Z*".$test_ratio[1]."%";
                        	if ($is_send==0) $main.="<br><$url_str_2 title=\"".$full_class_name.$test_sort_name[$curr_sort]."���ɦ��Z\"><img src='./images/wedit.png' border='0'></a><a href=\"{$_SERVER['SCRIPT_NAME']}?edit=s2&teacher_course=$teacher_course&curr_sort=$curr_sort\"><img src='./images/pen.png' border='0'></a><a href=\"{$_SERVER['SCRIPT_NAME']}?del=ds2&edit=s2&teacher_course=$teacher_course&curr_sort=$curr_sort\" onClick=\"return confirm('�T�w�R���o�����Z ?');\"><img src='./images/del.png' border='0'></a></td>";
                        }
		}
		$main .="<td>��������</td>";
		
		$main .="<tr>\n";
		//���q���Z
		if ($yorn=='n'){
			if(strstr ($teacher_course, 'g')) {
				$teacher_course_arr=explode("g",$teacher_course);
				$group_id=$teacher_course_arr[0];
				$query = "select student_sn,test_kind,score from $score_semester where ss_id='$ss_id' and test_sort='$curr_sort' and test_kind='�w�����q' and student_sn in ($all_sn)";
			}
			else $query = "select student_sn,test_kind,score from $score_semester where  ss_id='$ss_id' and test_sort='$curr_sort' and test_kind='�w�����q' and student_sn in ($all_sn)";
		} else {
			if(strstr ($teacher_course, 'g')) {
				$teacher_course_arr=explode("g",$teacher_course);
				$group_id=$teacher_course_arr[0];
				$query = "select student_sn,test_kind,score from $score_semester where ss_id='$ss_id' and test_sort='$curr_sort' and student_sn in ($all_sn)";
			}
			else $query = "select student_sn,test_kind,score from $score_semester where ss_id='$ss_id' and test_sort='$curr_sort' and student_sn in ($all_sn)";
		}
		$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		while(!$res->EOF){
			$tt =1;
			if ($res->fields[test_kind] =="�w�����q")
				$tt = 0;
			$score_arr[$tt][$res->fields[student_sn]] = $res->fields[score];
			$res->MoveNext();
		}
		//���J�e�X�����q���Z 2015.01.23 by smallduh.=======================================
		$score_arr_pre=array();
		if ($curr_sort>1) {
		 for ($PRE_SORT=1;$PRE_SORT<$curr_sort;$PRE_SORT++) {
		  $query_pre = "select student_sn,test_kind,score from $score_semester where ss_id='$ss_id' and test_sort='$PRE_SORT' and student_sn in ($all_sn)";
			//echo  $query_pre."<br>";
			$res_pre = $CONN->Execute($query_pre) or trigger_error($query_pre,E_USER_ERROR);
			while(!$res_pre->EOF){
				$tt =1;
				if ($res_pre->fields[test_kind] =="�w�����q")
				$tt = 0;
				$student_sn=$res_pre->fields[student_sn];
				$score_arr_pre[$PRE_SORT][$tt][$student_sn] = $res_pre->fields[score];
				//echo $res_pre->fields[test_kind]."$student_sn ($PRE_SORT , $tt) =>".$score_arr_pre[$PRE_SORT][$tt][$student_sn]."<br>";
				$res_pre->MoveNext();
		  } //end while
		 } // end for
		} // end if ($curr_sort>1)
		//=================================================================================
	
		//��ܾǥͦ��Z
		if(strstr ($teacher_course, 'g')){
			//���սҵ{�����q�U�Կ�� ------------
			$teacher_course_arr=explode("g",$teacher_course);
			$group_id=$teacher_course_arr[0];
			$ss_id=$teacher_course_arr[1];
			$query="select stud_name,curr_class_num,student_sn,stud_id,stud_study_year from stud_base where student_sn in ($all_sn) order by curr_class_num ";
		}else{
			$query = "select stud_name,curr_class_num,student_sn,stud_id,stud_study_year from stud_base where student_sn in ($all_sn) order by curr_class_num";
		}
		$res = $CONN->Execute($query) or triger_error($query,E_USER_ERROR);
		$i=1;
		while(!$res->EOF){
			if(strstr ($teacher_course, 'g')) $stud_num = intval(substr($res->fields[curr_class_num],-4,-2))."-".intval(substr($res->fields[curr_class_num],-2));
			else $stud_num = intval(substr($res->fields[curr_class_num],-2));
			$student_sn = $res->fields[student_sn];
			$stud_name  = addslashes($res->fields[stud_name]);
			//�ư��W��[��*
      $stud_name.=($student_out[$student_sn])?"<font color=red>*</font>":"";
			$stud_id  = addslashes($res->fields[stud_id]);
			$stud_study_year=$res->fields[stud_study_year];
			
			if($pic_checked) {
				//�L�X�Ӥ�
				$img=$UPLOAD_PATH."photo/student/".$stud_study_year."/".$stud_id; 
				$img_link=$UPLOAD_URL."photo/student/".$stud_study_year."/".$stud_id;			
				if (file_exists($img)) $pic_data="<td><img src='$img_link' width=$pic_width></td>"; else $pic_data="<td></td>";
			} else $pic_data="";
			
			
			if ($_GET[del]=='ds1')
				$score_1=-100;
			else
				$score_1 = $score_arr[0][$student_sn];			
			if ($score_1 == -100 || $score_1=="" )
				$score_1_s='';
			else $score_1_s=$score_1;
			if ($_GET[del]=='ds2')
				$score_2 = -100;
			else
				$score_2 = $score_arr[1][$student_sn];
			if ($score_2 == -100 || $score_2=="")
				$score_2_s='';
			else $score_2_s=$score_2;
			$red_1 = ($score_1>=60)?"#000000":"#ff0000";
			$red_2 = ($score_2>=60)?"#000000":"#ff0000";
			$bred_1 = ($score_1<60 && $score_1<>'')?"#ffaabb":"#FFFFFF";
			$bred_2 = ($score_2<60 && $score_2<>'')?"#ffaabb":"#FFFFFF";
			if ($_GET[edit]=='s1')
				$score1_text = "<td align=center ><input type=\"text\" size=6 name=\"s_$student_sn\" id=\"s_$student_sn\" value=\"$score_1_s\" style='background-color: $bred_1;' onBlur=\"unset_ower(this)\"></td>";
			else
				$score1_text = "<td align=center ><font color=$red_1>$score_1_s</font></td>";
			if ($_GET[edit]=='s2')
				$score2_text = "<td align=center ><input type=\"text\" size=6 name=\"s_$student_sn\" id=\"s_$student_sn\" value=\"$score_2_s\" style='background-color: $bred_2;' onBlur=\"unset_ower(this)\"></td>";
			else
				$score2_text = "<td align=center ><font color=$red_2>$score_2_s</font></td>";

			if ($score_1==-100 || $score_2==-100 || $score_1=="" || $score_2=="") {
				if ($score_1>0)
					$avg_score= $score_1_s;
				else
					$avg_score= $score_2_s;
			} else {
				$ratio_sum = $test_ratio[0]+$test_ratio[1];
				$avg_score = sprintf("%01.2f",($score_1*$test_ratio[0]+$score_2*$test_ratio[1])/$ratio_sum);
			}
			
		
			//�C�X�e�X���q���������Z by smallduh. 2015.01.23 =======================
			//echo "<pre>";
			//print_r($score_arr_pre);
			//exit();

			if ($curr_sort>1) {
				$pre_text="";
       for ($PRE_SORT=1;$PRE_SORT<$curr_sort;$PRE_SORT++) {
     				
								$score_1 = $score_arr_pre[$PRE_SORT][0][$student_sn];			
								$score_2 = $score_arr_pre[$PRE_SORT][1][$student_sn];

							if ($score_1==-100 || $score_2==-100 || $score_1=="" || $score_2=="") {
								if ($score_1>0) {
									$avg_pre_score= $score_1;
								}elseif ($score_2>0) {
									$avg_pre_score= $score_2;
								} else {
									$avg_pre_score= "";
							  }
							} else {
								$ratio_sum = $test_ratio[0]+$test_ratio[1];
								$avg_pre_score = sprintf("%01.2f",($score_1*$test_ratio[0]+$score_2*$test_ratio[1])/$ratio_sum);
							}
       	 $red_3 = ($avg_pre_score>=60)?"#000000":"#ff0000";
				$pre_text.="<td><font color=$red_3>$avg_pre_score</font></td>"; 
       	
       } // end for			
		  } //end if
		  //======================================================================
			$red_3 = ($avg_score>=60)?"#000000":"#ff0000";
			$stud_num_arr[$i]=$stud_num;
			$stud_name_arr[$stud_num]=$stud_name;
			$stud_score_s_arr[$stud_num]=$score_1_s;
			$stud_score_n_arr[$stud_num]=$score_2_s;
			$stud_id_arr[$stud_num]=$stud_id;
			if ($yorn == 'n')
				$main .="<tr bgcolor=#FFFFFF align='center'><td>$stud_id</td><td>$stud_num</td><td>".stripslashes($stud_name)."</td>$pic_data $pre_text $score1_text <td><font color=$red_3>$avg_score</font></td></tr>\n";
			else
				$main .="<tr bgcolor=#FFFFFF align='center'><td>$stud_id</td><td>$stud_num</td><td>".stripslashes($stud_name)."</td>$pic_data $pre_text $score1_text $score2_text <td><font color=$red_3>$avg_score</font></td></tr>\n";
			$avg_temp_hidden .= "<input type=\"hidden\" name=\"avg_hidden_$student_sn\" value=\"$avg_score\">";
			$temp_hidden .="$student_sn,";
			$i++;
			$res->MoveNext();
		}
	}

	//�Ǵ����Z
	elseif($curr_sort == 255){
		$main .="<td>�Ǵ����Z";
		if ($is_send==0) $main.="<br><$url_str_2 title=\"".$full_class_name."���Ǵ����Z\"><img src='./images/wedit.png' border='0'></a><a href=\"{$_SERVER['SCRIPT_NAME']}?edit=s2&teacher_course=$teacher_course&curr_sort=$curr_sort\"><img src='./images/pen.png' border='0'></a><a href=\"{$_SERVER['SCRIPT_NAME']}?del=ds2&edit=s2&teacher_course=$teacher_course&curr_sort=$curr_sort\" onClick=\"return confirm('�T�w�R���o�����Z ?');\"><img src='./images/del.png' border='0'></a></td>";
		$main.="<td>����</td></tr>\n";
		if(strstr ($teacher_course, 'g')) {
			$teacher_course_arr=explode("g",$teacher_course);
			$group_id=$teacher_course_arr[0];
			$query = "select student_sn,score from $score_semester where ss_id='$ss_id' and test_sort='255' and test_kind='���Ǵ�' and student_sn in ($all_sn)";
		}
		else $query = "select student_sn,score from $score_semester where ss_id='$ss_id' and test_sort='255' and test_kind='���Ǵ�' and student_sn in ($all_sn)";
		$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		while(!$res->EOF){
			$score_arr[$res->fields[student_sn]] = $res->fields[score];
			$res->MoveNext();
		}
		if(strstr ($teacher_course, 'g')){
			//���սҵ{�����q�U�Կ�� ------------
			$teacher_course_arr=explode("g",$teacher_course);
			$group_id=$teacher_course_arr[0];
			$ss_id=$teacher_course_arr[1];
			$query="select stud_name,curr_class_num,student_sn,stud_id,stud_study_year from stud_base where student_sn in ($all_sn) order by curr_class_num";
		}else{
			//�N�Z�Ŧr���ର�}�C
			$class_arr=class_id_2_old($class_id);
			$curr_class_temp = sprintf("%d%02d",$class_arr[3],$class_arr[4]);
			//��ܾǥͦ��Z
			$query = "select stud_name,curr_class_num,student_sn,stud_id,stud_study_year from stud_base where student_sn in ($all_sn) order by curr_class_num";
		}
		$res = $CONN->Execute($query) or triger_error($query,E_USER_ERROR);
		$i=1;
		while(!$res->EOF){
			if(strstr ($teacher_course, 'g')) $stud_num = intval(substr($res->fields[curr_class_num],-4,-2))."-".intval(substr($res->fields[curr_class_num],-2));
			else $stud_num = intval(substr($res->fields[curr_class_num],-2));
			$stud_name  = addslashes($res->fields[stud_name]);
			$student_sn = $res->fields[student_sn];
			$stud_id  = $res->fields[stud_id];
			$stud_study_year= $res->fields[stud_study_year];
			
			if($pic_checked) {
				//�L�X�Ӥ�
				$img=$UPLOAD_PATH."photo/student/".$stud_study_year."/".$stud_id; 
				$img_link=$UPLOAD_URL."photo/student/".$stud_study_year."/".$stud_id;			
				if (file_exists($img)) $pic_data="<td><img src='$img_link' width=$pic_width></td>"; else $pic_data="<td></td>";
			} else $pic_data="";
			
			if ($_GET[del]=='ds2')
				$score_2 = -100;
			else
				$score_2 = $score_arr[$student_sn];
			if ($score_2 == -100)
				$score_2='';
			$red_2 = ($score_2>=60)?"#000000":"#ff0000";
			$bred_2 = ($score_2<60 && $score_2<>'')?"#ffaabb":"#FFFFFF";
			if ($_GET[edit]=='s2')
				$score2_text = "<td align=center ><input type=\"text\" size=6 name=\"s_$student_sn\" id=\"s_$student_sn\" value=\"$score_2\" style='background-color: $bred_2;' onBlur=\"unset_ower(this)\"></td>";
			else
				$score2_text = "<td align=center ><font color=$red_2>$score_2</font></td>";

				$avg_score= $score_2;
			$red_3 = ($avg_score>=60)?"#000000":"#ff0000";
			$stud_num_arr[$i]=$stud_num;
			$stud_name_arr[$stud_num]=$stud_name;
			$stud_score_s_arr[$stud_num]=$score_2;
			$stud_id_arr[$stud_num]=$stud_id;
			
			$main .="<tr bgcolor=#FFFFFF align='center'><td>$stud_id</td><td>$stud_num</td><td>".stripslashes($stud_name)."</td>$pic_data $score2_text <td><font color=$red_3>$avg_score</font></td></tr>\n";
			$avg_temp_hidden .= "<input type=\"hidden\" name=\"avg_hidden_$student_sn\" value=\"$avg_score\">";
			$temp_hidden .="$student_sn,";
			$i++;
			$res->MoveNext();
		}
	}

	//���ɦ��Z
	elseif($curr_sort == 254) {
		$main .="<td>���Ǵ����ɦ��Z";

		if ($is_send==0) $main.="<br><$url_str_2 title=\"".$full_class_name."���Ǵ����ɦ��Z\"><img src='./images/wedit.png' border='0'></a><a href=\"{$_SERVER['SCRIPT_NAME']}?edit=s2&teacher_course=$teacher_course&curr_sort=$curr_sort\"><img src='./images/pen.png' border='0'></a><a href=\"{$_SERVER['SCRIPT_NAME']}?del=ds2&edit=s2&teacher_course=$teacher_course&curr_sort=$curr_sort\" onClick=\"return confirm('�T�w�R���o�����Z ?');\"><img src='./images/del.png' border='0'></a></td>";
		$main.="<td>����</td> </tr>\n";

		
		$query = "select student_sn,score from $score_semester where  ss_id='$ss_id' and test_sort='1' and student_sn in ($all_sn) and test_kind='���ɦ��Z'";
		$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		while(!$res->EOF){
			$score_arr[$res->fields[student_sn]] = $res->fields[score];
			$res->MoveNext();
		}
			
		//�N�Z�Ŧr���ର�}�C
		$class_arr=class_id_2_old($class_id);
		$curr_class_temp = sprintf("%d%02d",$class_arr[3],$class_arr[4]);
		//��ܾǥͦ��Z
		$query = "select stud_name,curr_class_num,student_sn,stud_id,stud_study_year from stud_base where student_sn in ($all_sn) order by curr_class_num";
		$res = $CONN->Execute($query) or triger_error($query,E_USER_ERROR);
		$i=1;
		while(!$res->EOF){
			$stud_num = intval(substr($res->fields[curr_class_num],-2));
			$stud_name  = addslashes($res->fields[stud_name]);
			$student_sn = $res->fields[student_sn];
			$stud_id = $res->fields[stud_id];
			$stud_study_year= $res->fields[stud_study_year];
			
			if($pic_checked) {
				//�L�X�Ӥ�
				$img=$UPLOAD_PATH."photo/student/".$stud_study_year."/".$stud_id; 
				$img_link=$UPLOAD_URL."photo/student/".$stud_study_year."/".$stud_id;			
				if (file_exists($img)) $pic_data="<td><img src='$img_link' width=$pic_width></td>"; else $pic_data="<td></td>";
			} else $pic_data="";
			
			
			if ($_GET[del]=='ds2')
				$score_2 = -100;
			else
				$score_2 = $score_arr[$student_sn];
			if ($score_2 == -100)
				$score_2='';
			$red_2 = ($score_2>=60)?"#000000":"#ff0000";
			$bred_2 = ($score_2<60 && $score_2<>'')?"#ffaabb":"#FFFFFF";
			if ($_GET[edit]=='s2')
				$score2_text = "<td align=center ><input type=\"text\" size=6 name=\"s_$student_sn\" id=\"s_$student_sn\" value=\"$score_2\" style='background-color: $bred_2;' onBlur=\"unset_ower(this)\"></td>";
			else
				$score2_text = "<td align=center ><font color=$red_2>$score_2</font></td>";
			$avg_score= $score_2;
			$red_3 = ($avg_score>=60)?"#000000":"#ff0000";
			$stud_num_arr[$i]=$stud_num;
			$stud_name_arr[$stud_num]=$stud_name;
			$stud_score_s_arr[$stud_num]=$score_2;
			$stud_id_arr[$stud_num]=$stud_id;
			$main .="<tr bgcolor=#FFFFFF align='center'><td>$stud_id</td><td>$stud_num</td><td>".stripslashes($stud_name)."</td>$pic_data $score2_text <td><font color=$red_3>$avg_score</font></td></tr>\n";
			$avg_temp_hidden .= "<input type=\"hidden\" name=\"avg_hidden_$student_sn\" value=\"$avg_score\">";
			$temp_hidden .="$student_sn,";
			$i++;
			$res->MoveNext();
		}
	}
	$main .="</tr>";
	$main .="</table>";
}

if ($is_print!=1) {
	head("���Z�C��");
	//�C�X��V���s�����Ҳ�
	$Link = "teacher_course=$teacher_course";
	print_menu($menu_p,$Link);
	if ($err==1) {
		$message="<table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%'><tr><td align='center'><h1><img src='../../images/warn.png' align='middle' border=0>�ާ@�v������</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'>�z�õL���ҵ{���ާ@�v���I<br></td></tr><tr><td align=center><br></td></tr></table>";
		echo $message;
	} else {
		echo "<link href=\"../../themes/new/thickbox.css\" media=\"screen\" rel=\"stylesheet\" type=\"text/css\"><script type=\"text/javascript\" src=\"../../javascripts/thickbox.js\"></script><table border=0 cellspacing=1 cellpadding=2 width=100% bgcolor=#cccccc><tr><td bgcolor='#FFFFFF'>";
		echo $top_str;
		echo $temp_script;
		echo "<form name=\"form9\" method=\"post\" action=\"$_SERVER[SCRIPT_NAME]\">";
		echo $main;
		echo "
		<input type=\"hidden\" name=\"class_id\" value=\"$class_id\">
		<input type=\"hidden\" name=\"ss_id\" value=\"$ss_id\">
		<input type=\"hidden\" name=\"test_kind\" value=\"$_GET[edit]\">
		<input type=\"hidden\" name=\"test_sort\" value=\"$curr_sort\">
		<input type=\"hidden\" name=\"curr_sort\" value=\"$curr_sort\">
		<input type=\"hidden\" name=\"teacher_course\" value=\"$teacher_course\">
		<input type=\"hidden\" name=\"student_sn_hidden\" value=\"$temp_hidden\">
		<input type=\"hidden\" name=\"performance_test_times\" value=\"$performance_test_times\">";

		echo $avg_temp_hidden;

		if($_GET[edit]<>''){
			if ($is_send==0) echo "<input type=\"submit\" name=\"dokey\" id=\"save\" value=\"�x�s\">";
			if ($curr_sort ==255)
				$io_test_name="�Ǵ����Z";
			elseif($_GET[edit]=="s1")
				$io_test_name="�w�����q";
			elseif($_GET[edit]=="s2")
				$io_test_name="���ɦ��Z";
			echo "
		        <input type=\"submit\" name=\"file_in\" value=�פJ".$io_test_name.">
		        <input type=\"submit\" name=\"file_out\" value=�ץX".$io_test_name.">";
		}
		if ($teacher_course!='' && $curr_sort!=''){
			if (!$is_send)
				echo "<input type=\"submit\" name=\"dokey\" value=\"�ר�аȳB\" onclick=\"return confirmSubmit()\">";
			else
				echo "<br /><br /><font color=red>** �������Z�w�צܱаȳB,�Y�����~,�гs���аȳB�B�z</font>";
		}
		echo "</td></tr></table>";
		echo "</form>";
	}
	foot();
} else {
	$query="select sch_cname from school_base";
	$res=$CONN->Execute($query);
	$school_name=$res->fields[sch_cname];
	if ($curr_sort<250) {
		$sort_str="�� ".$curr_sort." ���q";
		$sort_kind="�]".$class_name_kind_1[$curr_sort]."�^";
	} elseif ($curr_sort==254) {
		$sort_str="���ɦ��Z";
		$sort_kind="���ɦ��Z";
	} elseif ($curr_sort==255) {
		$sort_str="�Ǵ����Z";
		$sort_kind="�Ǵ����Z";
		
	}
	$endNumber  = end($stud_num_arr);
	if ($endNumber<=40) $endNumber = 40;
	echo "	<html><head><meta content='text/html; charset=big5' http-equiv='Content-Type'><title>���Z��</title></head>
		<style>  
		    p {line-height:12pt}
		</style>
		<SCRIPT LANGUAGE=\"JavaScript\">
		<!--
		function pp() {   
			if (window.confirm('�}�l�C�L�H')){
			self.print();}
		}
		//-->
		</SCRIPT>			
		<body onload=\"pp();return true;\">
		<table width='640' style='border-collapse: collapse;' cellpadding='0' cellspacing='0' border='0'>
		<tbody>
		<tr>
		<td style='padding: 0cm 1.0pt;' valign='middle' width='640'>
		<table width='640' height='600' style='border-collapse: collapse; text-align: center;' cellpadding='0' cellspacing='0' border='0'>
		<tbody>
		<tr style='height: 30pt;'>
		<td colspan='5'><font size='5' face='�з���'>$school_name</font><br><font size='1'><br></font><font face='Dotum'>$sel_year �Ǧ~�ײ� $sel_seme �Ǵ�$sort_str</font>
		<td width='40' rowspan='".($endNumber+4)."'>
		<td colspan='5'><font size='5' face='�з���'>$school_name</font><br><font size='1'><br></font><font face='Dotum'>$sel_year �Ǧ~�ײ� $sel_seme �Ǵ�$sort_str</font></tr>
		<tr style='height: 30pt;'>
		<td align='center' height='40' style='border-style: solid; border-color: windowtext; border-width: 1.5pt 1.5pt 0.75pt 1.5pt; padding: 0cm 1.4pt;' width='300' colspan='5'><font size='2'>".$course_arr[$teacher_course]."�즨�Z�n�O��</font></td>
		<td align='center' height='40' style='border-style: solid; border-color: windowtext; border-width: 1.5pt 1.5pt 0.75pt 1.5pt; padding: 0cm 1.4pt;' width='300' colspan='5'><font size='2'>".$course_arr[$teacher_course]."�즨�Z�n�O��</font></td>
		</tr>
		<tr style='height: 20pt;'>
		<td align='center' height='20' style='border-left:1.5pt solid windowtext; border-right:0.75pt solid windowtext; border-top:0.75pt solid windowtext; border-bottom:0.75pt solid windowtext; padding-left:1.4pt; padding-right:1.4pt; padding-top:0cm; padding-bottom:0cm' width='150' colspan='2' rowspan='2'><p align='right'><font face='Dotum' size='2'>���O</font></p><p><font face='Dotum' size='2'>����</font></p><p align='left'><font face='Dotum' size='2'>�m�W</font></p></td>
		<td align='center' height='20' style='border-top: 0.75pt solid windowtext; border-right: 1.5pt solid windowtext; border-bottom: 0.75pt solid windowtext; text-align: center; padding-left:1.4pt; padding-right:1.4pt; padding-top:0cm; padding-bottom:0cm' width='150' colspan='3'><font size='2'>$sort_kind</td>
		<td align='center' height='20' style='border-left:1.5pt solid windowtext; border-right:0.75pt solid windowtext; border-top:0.75pt solid windowtext; border-bottom:0.75pt solid windowtext; padding-left:1.4pt; padding-right:1.4pt; padding-top:0cm; padding-bottom:0cm' width='150' colspan='2' rowspan='2'><p align='right'><font face='Dotum' size='2'>���O</font></p><p><font face='Dotum' size='2'>����</font></p><p align='left'><font face='Dotum' size='2'>�m�W</font></p></td>
		<td align='center' height='20' style='border-top: 0.75pt solid windowtext; border-right: 1.5pt solid windowtext; border-bottom: 0.75pt solid windowtext; text-align: center; padding-left:1.4pt; padding-right:1.4pt; padding-top:0cm; padding-bottom:0cm' width='150' colspan='3'><font size='2'>$sort_kind</font></td>
		</tr>
		<tr style='height: 20pt;'>
		<td align='center' height='19' style='border-top: 0.75pt solid windowtext; border-right: 0.75pt solid windowtext; border-bottom: 0.75pt solid windowtext; text-align: center; padding-left:1.4pt; padding-right:1.4pt; padding-top:0cm; padding-bottom:0cm' width='50'><font size='2'>�w��</font><p><font size='2'>�Ҭd</font></td>
		<td align='center' height='19' style='border-width: 1.5pt 1px 0.75pt medium; border-top: 0.75pt solid windowtext; border-right: 1px solid windowtext; border-bottom: 0.75pt solid windowtext; padding: 0cm 1.4pt;' width='50'><font size='2'>��`</font><p><font size='2'>�Ҭd</font></td>
		<td align='center' height='19' style='border-style: solid solid solid none; border-width: 1.5pt 1.5pt 0.75pt medium; border-top: 0.75pt solid windowtext; border-right: 1.5pt solid windowtext; border-bottom: 0.75pt solid windowtext; padding: 0cm 1.4pt;' width='50'><font size='2'>��</font><p><font size='2'>��</font></td>
		<td align='center' height='19' style='border-top: 0.75pt solid windowtext; border-right: 0.75pt solid windowtext; border-bottom: 0.75pt solid windowtext; text-align: center; padding-left:1.4pt; padding-right:1.4pt; padding-top:0cm; padding-bottom:0cm' width='50'><font size='2'>�w��</font><p><font size='2'>�Ҭd</font></td>
		<td align='center' height='19' style='border-width: 1.5pt 1px 0.75pt medium; border-top: 0.75pt solid windowtext; border-right: 1px solid windowtext; border-bottom: 0.75pt solid windowtext; padding: 0cm 1.4pt;' width='50'><font size='2'>��`</font><p><font size='2'>�Ҭd</font></td>
		<td align='center' height='19' style='border-style: solid solid solid none; border-width: 1.5pt 1.5pt 0.75pt medium; border-top: 0.75pt solid windowtext; border-right: 1.5pt solid windowtext; border-bottom: 0.75pt solid windowtext; padding: 0cm 1.4pt;' width='50'><font size='2'>��</font><p><font size='2'>��</font></td>
		</tr>
		";
 
		for ($i=1;$i<=$endNumber;$i++) {
			$bm=($i % 5 ==0)?"1.5pt":"0.75pt";
			$j=(strstr($teacher_course,'g'))?$stud_num_arr[$i]:$i;
			echo "	<tr>
				<td align='right' height='15' style='border-left:1.5pt solid windowtext; border-right:0.75pt solid windowtext; border-bottom:$bm solid windowtext; border-top-color:windowtext; padding-left:1.4pt; padding-right:1.4pt; padding-top:0cm; padding-bottom:0cm' width='30' valign='middle'><font face='Dotum' size='2'>$j</font></td>
				<td align='center' height='15' style='border-right: 0.75pt solid windowtext; border-bottom: $bm solid windowtext; border-left-style:none; border-left-width:medium; border-top-color:windowtext; padding-left:1.4pt; padding-right:1.4pt; padding-top:0cm; padding-bottom:0cm' width='44' nowrap='nowrap' valign='middle'><font face='�s�ө���' size='2'>".stripslashes($stud_name_arr[$j])."</font></td>
				<td align='right' height='15' style='border-style: none solid solid none; border-width: medium 0.75pt 0.75pt medium; border-right: 0.75pt solid windowtext; border-bottom: $bm solid windowtext; padding: 0cm 1.4pt;' width='33' valign='middle'><font size='2' face='Dotum'>".$stud_score_s_arr[$j]."�@</font></td>
				<td align='right' height='15' style='border-style: none solid solid none; border-width: medium 0.75pt 0.75pt medium; border-right: 0.75pt solid windowtext; border-bottom: $bm solid windowtext; padding: 0cm 1.4pt;' width='33' valign='middle'><font size='2' face='Dotum'>".$stud_score_n_arr[$j]."�@</font></td>
				<td align='right' height='15' style='border-style: none solid solid none; border-width: medium 1.5pt 0.75pt medium; border-right: 1.5pt solid windowtext; border-bottom: $bm solid windowtext; padding: 0cm 1.4pt;' width='14' valign='middle'></td>
				
				<td align='right' height='15' style='border-left:1.5pt solid windowtext; border-right:0.75pt solid windowtext; border-bottom:$bm solid windowtext; border-top-color:windowtext; padding-left:1.4pt; padding-right:1.4pt; padding-top:0cm; padding-bottom:0cm' width='30'><font face='Dotum' size='2'>$j</font></td>
				<td align='center' height='15' style='border-right: 0.75pt solid windowtext; border-bottom: $bm solid windowtext; border-left-style:none; border-left-width:medium; border-top-color:windowtext; padding-left:1.4pt; padding-right:1.4pt; padding-top:0cm; padding-bottom:0cm' width='44' nowrap='nowrap'><font face='�s�ө���' size='2'>".stripslashes($stud_name_arr[$j])."</font></td>
				<td align='right' height='15' style='border-style: none solid solid none; border-width: medium 0.75pt 0.75pt medium; border-right: 0.75pt solid windowtext; border-bottom: $bm solid windowtext; padding: 0cm 1.4pt;' width='33'><font size='2' face='Dotum'>".$stud_score_s_arr[$j]."�@</font></td>
				<td align='right' height='15' style='border-style: none solid solid none; border-width: medium 0.75pt 0.75pt medium; border-right: 0.75pt solid windowtext; border-bottom: $bm solid windowtext; padding: 0cm 1.4pt;' width='33'><font size='2' face='Dotum'>".$stud_score_n_arr[$j]."�@</font></td>
				<td align='right' height='15' style='border-style: none solid solid none; border-width: medium 1.5pt 0.75pt medium; border-right: 1.5pt solid windowtext; border-bottom: $bm solid windowtext; padding: 0cm 1.4pt;' width='14'></td>
				</tr>";
		}
		echo "	<tr>
			<td align='left' colspan='6'><br><font size='2'>�@�@���ұЮvñ�W<u>&nbsp;�@�@�@�@�@�@�@�@�@�@�@&nbsp;</u><br>�@�@�@�@�@�@�@�@�@�@�@(�Юv�s�d)<br>�@�@�@�@���ЫO�d�ܾǴ����H���H�ɽվ\</font></td>
			<td align='left' colspan='6'><br><font size='2'>�@�@���ұЮvñ�W<u>&nbsp;�@�@�@�@�@�@�@�@�@�@�@&nbsp;</u><br>�@�@�@�@�@�@�@�@�@�@�@(�аȳB�s�d)<br>�@�@�@�@���Щ�q�ҫ�@�g���Y�^�аȳB</font></td>
			</tr>
			</tbody></table></td></tr></tbody></table></body></html>";
}
?> 
<script language="JavaScript1.2">
<!-- Begin
<?php
//�t�}����
if ($is_openWin) echo '
$(function() {
	$("#openWin").trigger("click");
});
';
//�O�_�ѥ��ɦ��Z�פJ
if ($_GET[is_ok]==1) echo "alert ('���ɦ��Z�פJ���\ !! ');\n";
?>

function confirmSubmit(){
	return confirm('�T�w�n�e��аȳB�H�@���e�X����z�N�L�k�b���A�p�ݧ��Ь��аȳB');
}

function closeThickbox(){
	tb_remove();
	$("#save").trigger('click');
}

function unset_ower(thetext) {
	if(thetext.value>100){ thetext.style.background = '#FF0000'; alert("��J���Z����100��");}
	else if(thetext.value<0){ thetext.style.background = '#AA5555'; alert("��J���Z���t��"); }
	else { thetext.style.background = '#FFFFFF'; }
	return true;
}
//  End -->
</script>
