<?php
// $Id: nor_upd.php 6148 2010-09-14 03:48:23Z brucelyc $
include "../../include2/config.php";
include "my_fun.php";

//�ϥΪ̻{��
sfs_check();

$teach_id=$_SESSION['session_log_id'];
$teacher_sn = $_SESSION['session_tea_sn'];
$nor_score="nor_score_".curr_year()."_".curr_seme();
$teacher_course=$_POST[teacher_course];
$act=$_POST['act'];
$stage=($_POST[curr_sort])?$_POST[curr_sort]:$_POST[stage];
if ($stage==254) {
	$stage_str="���Ǵ�";
} elseif ($stage==255) {
	$stage_str="�������q";
} else {
	$stage_str="��".$stage."���q";
}

//���o���T���нҵ{
$course_arr_all=get_teacher_course(curr_year(),curr_seme(),$teacher_sn,$is_allow);
$course_arr = $course_arr_all['course'];

// �ˬd�ҵ{�v���O�_���T
$cc_arr=array_keys($course_arr);
$err=(in_array($teacher_course,$cc_arr))?0:1;


if ($err==0) {
	//���Z�ɮ׶פJ
	if($act=="file_in"){
		$main="
			<table bgcolor=#FDE442 border=0 cellpadding=2 cellspacing=1 align='center'>
			<tr><td colspan=2 height=50 align='center'><font size='+2'>���Z�ɮ׶פJ</font></td></tr>
			<form action ='{$_SERVER['PHP_SELF']}' enctype='multipart/form-data' method=post>
			<tr><td  nowrap valign='top' bgcolor='#E1ECFF' width=40%>
			<p>�Ы��y�s���z��ܶפJ�ɮרӷ��G</p>
			<input type=file name='scoredata'>
			<input type=hidden name='act' value='file_in'>
			<input type=hidden name='teacher_course' value='$teacher_course'>
			<input type=hidden name='class_subj' value='{$_POST['class_subj']}'>
			<input type=hidden name='stage' value='$stage'>
			<input type=hidden name='freq' value='{$_POST['freq']}'>
			<input type=hidden name='err_msg' value='�ɮ׮榡���~<a href=./normal.php?teacher_course={$_POST['teacher_course']}&stage={$_POST['stage']}> <<�W�@��>></a>'>
			<p><input type=submit name='file_date' value='���Z�ɮ׶פJ'></p>
			<b>".$_POST['err_msg']."</b></td>
			<td valign='top' bgcolor='#FFFFFF'>
			�����G<br>
			<ol>
			<li>���Zcsv�ɡA�Фżg�W���Z�A�{���|�ѲĤG��}�lŪ��</li>
			<li>���Zcsv�ɪ��Ĥ@��key�W���D�A��K�N�Ӧۤv���d��</li>
			<li>�ɮפ��e�榡�p�U�G(�ѲĤG��}�l���Ĥ@�欰�y���A�ĤG�欰����)</li>
			</ol>
	    <pre>
	    #".curr_year()."�Ǧ~��".curr_seme()."�Ǵ�".$course_arr[$teacher_course].$stage_str."����".$_POST[freq]."�����ɦ��Z
	    1,56
	    2,76
	    3,56
	    4,22
	    5,45
	    6,65
	    7,87
	    8,85
	    9,23
	    10,55
	    11,45
	    12,78
	    </pre>
			</td>
			</tr>
			</table>
			</form>";
		if($_POST['file_date']=="���Z�ɮ׶פJ"){
			$path_str = "temp/score/";
			set_upload_path($path_str);
			$temp_path = $UPLOAD_PATH.$path_str;
			$temp_file= $temp_path."score_$teacher_course.csv";
			if ($_FILES['scoredata']['size']>0 && $_FILES['scoredata']['name']!=""){
				copy($_FILES['scoredata']['tmp_name'] , $temp_file);
				$fd = fopen ($temp_file,"r");
				$i =0;
				while ($tt = sfs_fgetcsv ($fd, 2000, ",")) {
					if ($i++ == 0) {//�Ĥ@�������Y                        
						$msg.="�Ĥ@�������Y�A���nkeyin���Z<br>";
						continue ;
					}//�Ĥ@�������Y
					$stud_site_num= trim($tt[0]);
					$stud_score= trim($tt[1]);

					if((strlen($stud_site_num)>3) || (strlen($stud_score)>3) ){
						echo $main;
						exit;
					}

					//��Xstudent_sn
					$class_subj_array=explode("_",$_POST['class_subj']);
					$seme_year_seme=$class_subj_array[0].$class_subj_array[1];
					$seme_class=intval($class_subj_array[2]).$class_subj_array[3];
					$seme_num=$stud_site_num;
					$rs_stid=$CONN->Execute("select stud_id from stud_seme where seme_year_seme='$seme_year_seme' and seme_class='$seme_class' and seme_num='$seme_num'");
					$stud_id=$rs_stid->fields['stud_id'];
					$rs_stsn=$CONN->Execute("select student_sn from stud_base where stud_id='$stud_id' and stud_study_cond=0 ");
					$student_sn=$rs_stsn->fields['student_sn'];
					if($student_sn){
						if($stud_score=="") $stud_score="-100";
						$bobo=$CONN->Execute("update $nor_score SET test_score='$stud_score' where stud_sn='$student_sn' and class_subj='{$_POST['class_subj']}' and stage='{$_POST['stage']}' and freq='{$_POST['freq']}' and teach_id='$teach_id'") or trigger_error("�פJ����",256);

						if($bobo) $msg.="--num ".$stud_site_num." --���\<br>";
						else $msg.="--num ".$stud_site_num." --����<br>";
					} else {
						$msg.="--num ".$stud_site_num." --���s�b<br>";
					}
				}
				header("Location:./normal.php?teacher_course={$_POST['teacher_course']}&stage={$_POST['stage']}&msg=$msg");
			} else {
				echo $main;
				exit;
			}
		}
		echo $main;
	}

	//���Z�ɮ׶ץX
	elseif($act=="file_out"){
		$filename="norscore_".$_POST['class_subj']."_".$_POST['stage']."_".$_POST['freq'].".csv";
		header("Content-disposition: filename=$filename");
		header("Content-type: application/octetstream ; Charset=Big5");
		header("Pragma: no-cache");
		header("Expires: 0");
		$class_subj_name=explode("_",$_POST['class_subj']);
		$class_id=$class_subj_name[0]."_".$class_subj_name[1]."_".$class_subj_name[2]."_".$class_subj_name[3];
		$class_year_name=class_id_to_full_class_name($class_id);
		$subject_name=subject_id_to_subject_name($class_subj_name[4]);
		$dl_time=date("Y m d H:i:s");
		$file_info="#".curr_year()."�Ǧ~��".curr_seme()."�Ǵ�".$course_arr[$teacher_course].$stage_str."����".$_POST[freq]."�����ɦ��Z�A�ҸզW�١G�y".$_POST['test_name']."�z�A(".$dl_time.")\n";
		echo $file_info;
		$rs=&$CONN->Execute("select a.stud_sn,a.test_score,b.curr_class_num from $nor_score a,stud_base b where a.stud_sn=b.student_sn and a.class_subj='{$_POST['class_subj']}' and a.stage='$stage' and a.freq='{$_POST['freq']}' and a.enable=1 order by b.curr_class_num");
		$i=0;
		while(!$rs->EOF){
			$student_sn[$i]=$rs->fields['stud_sn'];
			$test_score[$i]=$rs->fields['test_score'];
			$student_info[$i]= substr($rs->fields[curr_class_num],-2);
			if($test_score[$i]=="-100") $test_score[$i]=" ";
			echo "\"".$student_info[$i]."\",\"".$test_score[$i]."\"\n";
			$i++;
			$rs->MoveNext();
		}
	}
} else
	header("Location:./normal.php?teacher_course={$_POST['teacher_course']}&stage=$stage");
?>
