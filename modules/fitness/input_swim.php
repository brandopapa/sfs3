<?php
// $Id: input.php 7839 2014-01-07 02:20:29Z infodaes $
// ���o�]�w��
include "config.php";

sfs_check();

if($_POST['year_seme']=="") $_POST['year_seme']=sprintf("%03d",curr_year()).curr_seme();
$sel_year=intval(substr($_POST['year_seme'],0,-1));
$sel_seme=intval(substr($_POST['year_seme'],-1,1));
$seme_year_seme = sprintf("%03d%d",$sel_year,$sel_seme);
$curr_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
$class_arr=class_base($seme_year_seme);

//if($seme_year_seme==$curr_year_seme) $import=1;


//�x�s�����B�z
/*
if($_POST['go']=='�פJ'){
	if($_POST['content']){
		
		//$organization=$_POST['organization'];
		$content=explode("\r\n",$_POST['content']);
		foreach($content as $key=>$value){
			$student_data=explode("\t",$value);
			//���student_sn
			$stud_id=$student_data[4];
			$seme_class=$student_data[3];
			if($stud_id and $seme_class){
				//��Xstudent_sn
				$query="select student_sn,seme_class from stud_seme where stud_id='$stud_id' and seme_year_seme='$seme_year_seme'";
				$res=$CONN->Execute($query) or die("SQL���~:$query");
				if($res->recordcount()){
					$target_sn=$res->fields[0];
					$target_class=$res->fields[1];
					if($target_class==$seme_class){
						//�R���¬���
						$query="delete from fitness_data where student_sn='$target_sn' and c_curr_seme='$seme_year_seme'";
						$CONN->Execute($query) or die("SQL���~:$query");
						$dd=explode('-',$student_data[0]);
						if(count($dd)<2) $dd=explode('/',$student_data[0]);
						$test_y=($dd[0]>=1911)?$dd[0]-1911:$dd[0];
						$test_m=$dd[1];
						$batch_values.="('$seme_year_seme','$test_y','$test_m','$target_sn','{$_SESSION[session_tea_sn]}',now(),'{$student_data[10]}','{$student_data[12]}','{$student_data[11]}','{$student_data[13]}','{$student_data[8]}','{$student_data[9]}','{$student_data[14]}'),";
					} else $msg.="�Z�šG$seme_class �y���G$seme_num �Ǹ��G$stud_id �A���ͪ��N�ǯZ�ŻP $seme_year_seme �Ǵ����������šA���פJ�I<br>";
				} else $msg.="�Z�šG$seme_class �y���G$seme_num �Ǹ��G$stud_id �A�L���ͩ� $seme_year_seme �Ǵ����N�Ǭ����A�L�k�פJ�I<br>";
			} else $msg.="�Z�šG$seme_class �y���G$seme_num �Ǹ��G$stud_id �A�L���ͪ� �Ǹ� �� �Z�šA�L�k�פJ�I<br>";
		}
		if($batch_values) {
			$batch_values=substr($batch_values,0,-1);
			$batch_values="INSERT INTO fitness_data(c_curr_seme,test_y,test_m,student_sn,teacher_sn,up_date,test1,test2,test3,test4,tall,weigh,organization) VALUES $batch_values ;";
			$res=$CONN->Execute($batch_values) or die("SQL���~:$batch_values");
		}
	}
}
*/

//�޲z��
if ($admin==1){
	//��ƶץX
	if ($_POST['act']=='export') {
	  // $seme_year_seme
	  $sql="select a.*,b.stud_id,b.stud_name,b.stud_sex,b.stud_person_id,b.stud_birthday,b.curr_class_num from fitness_data_swim a,stud_base b where a.c_curr_seme='$seme_year_seme' and a.student_sn=b.student_sn order by b.curr_class_num";
    $res=$CONN->Execute($sql);
  	$class_name_arr=class_base($seme_year_seme);  //�Z�ŦW�ٰ}�C(������W)
	  
	  $school_kind=($IS_JHORES=="0")?"��p":"�ꤤ";
	  
	  $DATA="<table border=\"0\">";
	  $DATA.="<tr>";
	  $DATA.="<td>������</td>";
	  $DATA.="<td>�Ǯ����O</td>";
	  $DATA.="<td>�~��</td>";
	  $DATA.="<td>�Z�ŦW��</td>";
	  $DATA.="<td>�Ǹ�/�y��</td>";
	  $DATA.="<td>�ʧO</td>";
	  $DATA.="<td>�����Ҧr��</td>";
	  $DATA.="<td>�ͤ�</td>";
	  $DATA.="<td>��I��a�о�</td>";
	  $DATA.="<td>�ŧO</td>";
	  $DATA.="<td>���Z</td>";
	  $DATA.="</tr>";
	  
	  while ($row=$res->fetchRow()) {
	    //������
	    $test_date=(substr($row['test_date'],0,4)=="0000")?"":(substr($row['test_date'],0,4)-1911).".".substr($row['test_date'],5,2).".".substr($row['test_date'],8,2);
	    //�Ǯ����O
	    //�~��
	    $class_year=substr($row['curr_class_num'],0,1);
	    //�Z�ŦW��
	    $class_name=$class_name_arr[substr($row['curr_class_num'],0,3)];
	    //�Ǹ�/�y��
	    $stud_id=$row['stud_id'];
	    //�ʧO
	    $sex=$row['stud_sex'];
	    //�����Ҧr��
	    $stud_person_id=$row['stud_person_id'];
	    //�ͤ�
	    $stud_birthday=(substr($row['stud_birthday'],0,4)-1911).substr($row['stud_birthday'],5,2).substr($row['stud_birthday'],8,2);
	    //��I��a�о�
	    $teach_swim=$row['teach_swim'];
	    //�ŧO
	    $swim_class=$row['swim_class'];
	    //���Z
	    $swim_score=$row['swim_score'];
	    
	    $DATA.="<tr>";
	  	$DATA.="<td>$test_date</td>";
	  	$DATA.="<td>$school_kind</td>";
	  	$DATA.="<td>$class_year</td>";
	  	$DATA.="<td>$class_name</td>";
	  	$DATA.="<td>$stud_id</td>";
	  	$DATA.="<td>$sex</td>";
	  	$DATA.="<td>$stud_person_id</td>";
	  	$DATA.="<td>$stud_birthday</td>";
	  	$DATA.="<td>$teach_swim</td>";
	  	$DATA.="<td>$swim_class</td>";
	  	$DATA.="<td>$swim_score</td>";
	    $DATA.="</tr>";

	  } // end while
		
		$DATA.="</table>";	
		
		$filename="swim_".date("Y-m-d").".xls";
		
			//�H��y�覡�e�X 
	header("Content-disposition: attachment; filename=$filename");
	header("Content-type: application/vnd.sun.xml.writer");

  //header("Pragma: no-cache");
  //�]�� IE 6,7,8 �b SSL �Ҧ��U�L�k�U���A���� no-cache �אּ�H�U
	header("Cache-Control: max-age=0");
	header("Pragma: public");
	header("Expires: 0");

	echo $DATA;
	
	exit;
 
	
	} // end if 

	if ($_POST[me]) {
		$class_num=$_POST[me];
	} else {
		$class_num=($IS_JHORES=="0")?"101":"701";
	}
	$smarty->assign("seme_menu",year_seme_menu($sel_year,$sel_seme));
	$smarty->assign("class_menu",class_name_menu($sel_year,$sel_seme,$class_num));
} else {
	$query="select distinct a.class_id from score_course a,score_ss b where a.ss_id=b.ss_id and a.year='$sel_year' and a.semester='$sel_seme' and a.teacher_sn='".$_SESSION[session_tea_sn]."' and b.link_ss='���d�P��|' order by class_id";
	$res=$CONN->Execute($query);
	//���Юv
	if ($res->RecordCount()>0) {
		while(!$res->EOF) {
			$m=$res->FetchRow();
			$n=explode("_",$m[class_id]);
			$nn=intval($n[2].$n[3]);
			$c_arr[$nn]=$class_arr[$nn];
		}
		if ($_POST[me]) {
			$class_num=$_POST[me];
		} else {
			$class_num=$nn;
		}
		$smarty->assign("class_menu",class_menu($sel_year,$sel_seme,$class_num,$c_arr));
	} else {
		//���o���ЯZ�ťN��
		$class_num=get_teach_class();
		$smarty->assign("class_menu",class_menu($sel_year,$sel_seme,$class_num));
	}
	$smarty->assign("admin",$admin);
}

if ($class_num) {
	$query="select a.student_sn,a.stud_name,a.stud_id,a.stud_sex,a.stud_birthday,b.seme_num from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$seme_year_seme' and b.seme_class='$class_num' and a.stud_study_cond in ($in_study) order by curr_class_num";
	$res=$CONN->Execute($query);
	$r=$res->GetRows();
	//�p�G���U[�x�s]
	if ($_POST['act']=='save') {
	  foreach ($r as $v) {
	    $student_sn=$v['student_sn'];
	    $test_date=$_POST['test_date'][$student_sn];
	    $teach_swim=($_POST['teach_swim'][$student_sn])?1:2;
	    $swim_class=($_POST['swim_class'][$student_sn]=="")?"null":$_POST['swim_class'][$student_sn];
	    $swim_score=$_POST['swim_score'][$student_sn];
	    $sql="update fitness_data_swim set test_date='$test_date',teach_swim='$teach_swim',swim_class=$swim_class,swim_score='$swim_score',teacher_sn='".$_SESSION[session_tea_sn]."' where student_sn='$student_sn' and c_curr_seme='$seme_year_seme'";
	    $res=$CONN->Execute($sql) or die ("Error! sql=".$sql);
	  }
	  $INFO="�w��".date("Y-m-d H:i:s")."�i���x�s!";
	  $smarty->assign("INFO",$INFO);
	}
	
	//���s���J���
	$smarty->assign("rowdata",$r);
	reset($r);
	while(list($k,$v)=each($r)) {
		$stud_arr[]=$v[student_sn];
		$query="select count(student_sn) from fitness_data_swim where student_sn='".$v[student_sn]."' and c_curr_seme='$seme_year_seme'";
		$res=$CONN->Execute($query);
		if ($res->fields[0]==0) {
			$CONN->Execute("insert into fitness_data_swim (c_curr_seme,student_sn,teach_swim) values ('$seme_year_seme','".$v[student_sn]."','2')");
		}
	}

	$stud_str="'".implode("','",$stud_arr)."'";
	$query="select * from fitness_data_swim where student_sn in ($stud_str) and c_curr_seme='$seme_year_seme'";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		$f=array();
		$f=$res->FetchRow();
		$fd[$f[student_sn]]=$f;
	}
	$smarty->assign("fd",$fd);
	$smarty->assign("class_num",$class_num);
} else {
	head("�v�����~");
	stud_class_err();
	exit;
}

$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("module_name","��a��O��ƿ�J");
$smarty->assign("SFS_MENU",$menu_p);
$smarty->assign("admin",$admin);  
$smarty->assign("msg",$msg);
$smarty->assign("import",$import);
$smarty->assign("sel_year",$sel_year);
$smarty->assign("sel_seme",$sel_seme);
$smarty->display("fitness_input_swim.tpl");
?>
