<?php

// $Id: chk.php 7340 2013-07-11 06:02:08Z hami $

// ���o�]�w��
include "config.php";
if (empty($chk_menu_arr)) header("location:index.php");

sfs_check();

$w_arr=array("====","�ȱo�g��","��{�}�n","��{�|�i","���A�[�o","���ݧ�i");		
if(checkid($_SERVER['SCRIPT_FILENAME'],1)){ $selectable=1; }

$semester_reset=$_POST['semester_reset'];
if($semester_reset) { $_POST['class_id']=''; $_POST['student_sn']=''; }

$class_reset=$_POST['class_reset'];
if($class_reset) { $_POST['student_sn']=''; }

$student_sn=$_POST['nav_next']?$_POST['nav_next']:$_POST['student_sn'];
$class_id=$_POST['class_id'];

//�ɮv������ЯZ��
if(!$selectable) {
$class_num=get_teach_class();
$class_id=sprintf("%03d_%d_%02d_%02d",curr_year(),curr_seme(),substr($class_num,-3,strlen($class_num)-2),substr($class_num,-2));
}

$smarty->assign("class_id",$class_id);

if(!class_id) $student_sn=0;
$smarty->assign("student_sn",$student_sn);


if($_POST['year_seme']=="") $_POST['year_seme']=sprintf("%03d",curr_year()).curr_seme();
$sel_year=intval(substr($_POST['year_seme'],0,-1));
$sel_seme=intval(substr($_POST['year_seme'],-1,1));
$seme_year_seme = sprintf("%03d%d",$sel_year,$sel_seme);

//���o�~�׻P�Ǵ����U�Կ��
$sql="select DISTINCT year,semester from school_class where enable='1' order by year DESC,semester";
$res=$CONN->Execute($sql) or user_error("���o�~�׻P�Ǵ����ѡI<br>$sql",256);
$date_select="<select name='year_seme' onchange='this.form.semester_reset.value=\"Y\"; this.form.submit();'".($selectable?'':' disabled').">";
while(!$res->EOF) {
	$curr_semester=sprintf("%03d",$res->fields['year']).$res->fields['semester'];
	if($curr_semester==$_POST['year_seme']) $selected_seme='selected'; else $selected_seme='';
	$semester_name=$res->fields['year'].'�Ǧ~�ײ�'.$res->fields['semester'].'�Ǵ�';
	$date_select.="<option value='$curr_semester' $selected_seme>$semester_name</option>";
	$res->MoveNext();
}
$date_select.="</select>";

//$date_select=&class_ok_setup_year($sel_year,$sel_seme,"year_seme","this.form.semester_reset.value=\"Y\"; this.form.submit");
$smarty->assign("date_select",$date_select);

//�~�ŻP�Z�ſ��
$sql="select class_id,c_year,c_name from school_class where year='$sel_year' and semester = '$sel_seme' and enable='1' order by c_year,c_sort";
$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
$class_select="<select name='class_id' onchange='this.form.class_reset.value=\"Y\"; this.form.submit();'".($selectable?'':' disabled').">";
while(!$res->EOF) {
	if(! $class_id) $class_id=$res->fields['class_id'];  //�Y�����w�Z��  �h�H�Ĥ@�Z�N��
	if($class_id==$res->fields['class_id']) $curr_class='selected'; else $curr_class='';
	$class_name=$school_kind_name[$res->fields['c_year']].$res->fields['c_name'].'�Z';
	$class_select.="<option $curr_class value='".$res->fields['class_id']."'>$class_name</option>";
	$res->MoveNext();
}
$class_select.="</select>";
$smarty->assign("class_select",$class_select);

//�Nclass_id�ରclass_num
$class_id_arr=explode('_',$class_id);
$class_num=($class_id_arr[2]+0).$class_id_arr[3];

$smarty->assign("selectable",$selectable);
$smarty->assign("class_id",$class_id);
$smarty->assign("class_num",$class_num);

if(!$selectable){
	//���o���ЯZ�ťN��
	$class_num=get_teach_class();
	$class_all=class_num_2_all($class_num);

	if(empty($class_num)){
		$act="error";
		$error_title="�L�Z�Žs��";
		$error_main="�䤣��z���Z�Žs���A�G�z�L�k�ϥΦ��\��C<ol>
		<li>�нT�{�z�ݥ��ɮv�C
		<li>�нT�{�аȳB�w�g�N�z�����и�ƿ�J�t�Τ��C
		</ol>";
	} elseif ($_GET[error]==1){
		$act="error";
		$error_title="�ӯZ�ŵL�ǥ͸��";
		$error_main="�䤣��z���Z�žǥ͡A�G�z�L�k�ϥΦ��\��C<ol>
		<li>�нT�{�z�ݥ��ɮv�C
		<li>�нT�{�аȳB�w�g�N�z���ǥ͸�ƿ�J�t�Τ��C
		<li>�פJ�ǥ͸�ơG�y�ǰȨt�έ���>�а�>���U��>�פJ��ơz(<a href='".$SFS_PATH_HTML."modules/create_data/mstudent2.php'>".$SFS_PATH_HTML."modules/create_data/mstudent2.php</a>)</ol>";
	}
}

if ($_POST[save]) {	
	  $stud_id = $_POST['stud_id'];
	  $student_sn = $_POST['current_student_sn'];
		//�B�z���`��r�y�z
		$nor_memo=str_replace("'","",trim($_POST['nor_memo']));
		$query="select student_sn from stud_seme_score_nor where seme_year_seme='$seme_year_seme' and student_sn='$student_sn' and ss_id='0'";
		$res=$CONN->Execute($query);
		if ($res->fields['student_sn']) {
			//$query="update stud_seme_score_nor set ss_score='$score_nor',ss_score_memo='$memo_nor' where seme_year_seme='$seme_year_seme' and student_sn='$student_sn' and ss_id='0'";
			$query="update stud_seme_score_nor set ss_score_memo='$nor_memo' where seme_year_seme='$seme_year_seme' and student_sn='$student_sn' and ss_id='0'";
			$res=$CONN->Execute($query);
		} else {
			$query="insert into stud_seme_score_nor (seme_year_seme,student_sn,ss_id,ss_score,ss_score_memo) values ('$seme_year_seme','$student_sn','0','','$nor_memo')";
			$res=$CONN->Execute($query);
		}
	
		//�B�z���`�V�O�{��				
		for ($i=1;$i<=4;$i++) {
			$query="select stud_id from stud_seme_score_oth where seme_year_seme='$seme_year_seme' and stud_id='$stud_id' and ss_id='$i' and ss_kind='�ͬ���{���q'";
			$res=$CONN->Execute($query);
			$val_nor=$_POST['nor_val'][$i];
			if (!in_array($val_nor,$w_arr)) $val_nor="";
			if ($res->fields['stud_id']) {
				$query="update stud_seme_score_oth set ss_val='$val_nor' where seme_year_seme='$seme_year_seme' and stud_id='$stud_id' and ss_id='$i' and ss_kind='�ͬ���{���q'";
				$res=$CONN->Execute($query);
			} else {
				$query="insert into stud_seme_score_oth (seme_year_seme,stud_id,ss_kind,ss_id,ss_val) values ('$seme_year_seme','$stud_id','�ͬ���{���q','$i','$val_nor')";
				$res=$CONN->Execute($query);
			}
		}	
}

//�ֶK���Z���ӰO��===========================================================
if ($_POST['mode']=="pastALL" and $_POST['stud_data']) {
	//�g�J�e�w���i�� < > ' " &�r������  �קKHTML�S��r���y����ܩ�sxw������~
	$char_replace=array("<"=>"��",">"=>"��","'"=>"��","\""=>"��","&"=>"��");
	$seme_class_num=substr($_POST['class_id'],7,1).substr($_POST['class_id'],9,2);
	$data_arr=explode("\n",$_POST['stud_data']);
 //�}�l�B�z
 	for ($i = 0 ; $i < count($data_arr); $i++ ) {
		//�h���e��ť�
	 //$data_arr[$i] = trim($data_arr[$i]);
	 //�h�����H�O�����b�@�����ť�
   //$data_arr[$i] = preg_replace('/\s(?=\s)/','', $data_arr[$i]);
   //$data_arr[$i] = preg_replace('/[\n\r\t]/', ' ', $data_arr[$i]);
   //echo $data_arr[$i]."<br>";
   //�ܦ��G���}�C
   $student=explode("\t",$data_arr[$i]);  //�Y���ǥͪ����
   if (count($student)==7) { //7����쳣����ƦA�B�z,�̧� : �y��,�m�W,����O��1,�դ��A��2,���ϪA��3,�դ��S��4,�ե~�S��5
   	foreach ($student as $k=>$v) {
   	 $student[$k]=trim($v);  //�h���e��ť�
   	}   	 

   	 //���o�ǥͪ� student_sn
   	 $query="select a.student_sn from stud_seme a,stud_base b where a.student_sn=b.student_sn and a.seme_class='".$seme_class_num."' and a.seme_num='".$student[0]."' and b.stud_name='".$student[1]."'";
   	 $res_sn=mysql_query($query);
   	 if (mysql_num_rows($res_sn)>0) {   								  	 
   	 	 list($student_sn)=mysql_fetch_row($res_sn);
   				for ($j=2;$j<=6;$j++) {
   					$ss_id=$j-1;
   					$memo=($student[$j]=="*")?"":$student[$j];
   					foreach($char_replace as $key=>$value)	$memo=str_replace($key,$value,$memo);
   					$CONN->Execute("replace into stud_seme_score_oth (seme_year_seme,student_sn,ss_id,ss_score_memo) values ('$seme_year_seme','$student_sn','$ss_id','$memo')");   				  
   				}
     }
   }
	} // end for	
}
//=================================================================================

if ($act) {
	head("��g���`�ͬ���{���q");
	echo error_tbl($error_title,$error_main);
	foot();
	exit;
}

$s=get_school_base();

//if($class_num) {
	//��ܯZ�žǥ͸��
	$style_color[1]="#5555FF";
	$style_color[2]="#FF5555";
	$sql="select a.student_sn,a.stud_name,a.stud_sex,b.seme_num as sit_num from stud_base a,stud_seme b where a.student_sn=b.student_sn and (a.stud_study_cond=0 or a.stud_study_cond=5) and  b.seme_year_seme='$seme_year_seme' and b.seme_class='$class_num' order by b.seme_num ";   //SQL �R�O   
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
	$student_count=$res->recordcount();
	$stud_select="<select size='$student_count' name='student_sn' onchange='this.form.submit();'>";
	while(!$res->EOF) {
		if(! $student_sn) $student_sn=$res->fields['student_sn'];  //�Y�����w�ǥ�  �h�H�Ĥ@��N��
		$stud_sex_arr[$res->fields['stud_sex']]++;
		//echo "<BR>".$res->fields['student_sn'];
		if($curr_student) $next_student_sn=$res->fields['student_sn'];
		if($student_sn==$res->fields['student_sn']) {
			$curr_student='selected';
			$stu_class_num=$res->fields['sit_num'];
		} else $curr_student='';
		$stud_select.="<option $curr_student STYLE=\"color:".$style_color[$res->fields['stud_sex']]."\" value='".$res->fields['student_sn']."'>(".$res->fields['sit_num'].")".$res->fields['stud_name']."</option>";
	$res->MoveNext();
	}
	$stud_select.="</select>";
	$stud_select.="<BR>�ǥͼơG $student_count";
	$stud_select.="<BR>�k�G".$stud_sex_arr[1];
	$stud_select.="<BR>�k�G".$stud_sex_arr[2];
	$stud_select.="<BR>��L�G".($student_count-$stud_sex_arr[1]-$stud_sex_arr[2]);
	$smarty->assign("stud_select",$stud_select);
	if ($_POST['chknext']) $smarty->assign("next_student_sn",$next_student_sn);
	
	//���o���w�ǥ͸��
	$stu=get_stud_base($student_sn,"");
	$stud_id=$stu['stud_id'];
	
	//�ഫ�Z�ťN�X
	//if(!$class_id) $class_id=sprintf("%03d_%d_%02d_%02d",$sel_year,$sel_seme,substr($class_num,0,2),substr($class_num,0,2),substr($class_num,3));
	$class=class_id_2_old($class_id);
	
	//print_r($class);
	
	$smarty->assign("stu",$stu);
	$smarty->assign("class_name",$class[5]);

	//�y��
	$smarty->assign("stu_class_num",$stu_class_num);

	//�ˮ֪���
	//$smarty->assign("itemdata",get_chk_item($sel_year,$sel_seme));

	//�ˮ֪��
	//$chk_item=chk_kind();
	//$chk_value=get_chk_value($student_sn,$sel_year,$sel_seme,$chk_item,"input");
	//$nor_memo = $_POST['nor_memo'][$student_sn][0];
	//if ($_POST[save]) merge_chk_text($sel_year,$sel_seme,$student_sn,$chk_value);

	$query="select ss_score,ss_score_memo from stud_seme_score_nor where seme_year_seme='$seme_year_seme' and student_sn='$student_sn' and ss_id='0'";
	$res=$CONN->Execute($query) or trigger_error("���~�T���G $query", E_USER_ERROR);
	//$score_nor_str=score2str($res->fields['ss_score'],"",$rule_arr);//����
	$memo_nor=$res->fields['ss_score_memo'];//���`��r�y�z
  $rowdata['nor']['memo']=$memo_nor;
  
	$query="select ss_id,ss_val from stud_seme_score_oth where seme_year_seme='$seme_year_seme' and stud_id='$stud_id' and ss_kind='�ͬ���{���q' order by ss_id";
	$res=$CONN->Execute($query) or trigger_error("���~�T���G $query", E_USER_ERROR);	
	$nor_val[$i]="";
	while (!$res->EOF) {
		$i=$res->fields['ss_id'];//���`����
		$ssval=$res->fields['ss_val'];//���`�V�O�{��
		for ($j=0;$j<count($w_arr);$j++){
			$selected=($ssval==$w_arr[$j])?"selected":""; 
			$nor_val[$i].="<option $selected>".$w_arr[$j]."</option>";
		}
		$res->MoveNext();
	}
	for ($i=1;$i<5;$i++){
		if ($nor_val[$i] == "") {
			for ($j=0;$j<count($w_arr);$j++){
				$selected=($i != 4 && $j == 2)?"selected":""; 
				$nor_val[$i].="<option $selected>".$w_arr[$j]."</option>";
			}			
	  }	
	}	
	$rowdata['nor']['ss_item']=array(1=>"���`�欰��{",2=>"���鬡�ʪ�{",3=>"���@�A��",4=>"�ե~�S���{");
	$rowdata['nor']['ss_val']=$nor_val;
	$smarty->assign("rowdata",$rowdata);

	
	if($_POST[auto_spe]){
		$sql="SELECT * FROM stud_seme_spe WHERE seme_year_seme='$seme_year_seme' AND stud_id='$stud_id'";
		$res=$CONN->Execute($sql) or user_error("Ū�����ɯS���{���ѡI<br>$sql",256);
		$spe_data=array();
		while(!$res->EOF) {
			$outside=$res->fields['outside'];
			$spe_data[$outside].='['.$res->fields['sp_date']."]".$res->fields['sp_memo']."\r\n";
			$res->MoveNext();
		}
		
		//echo "<PRE>";
		//print_r($spe_data);
		//echo "</PRE>";
		
	}
	
	
	$smarty->assign("spe_data_0",$spe_data[0]);
	$smarty->assign("spe_data_1",$spe_data[1]);
	$smarty->assign("spe_data_2",$spe_data[2]);

//}

$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("module_name","��g���`�ͬ���{���q");
$smarty->assign("SFS_MENU",$school_menu_p);
$smarty->assign("sel_year",$sel_year);
$smarty->assign("sel_seme",$sel_seme);
$smarty->assign("stud_id",$stud_id);
$smarty->assign("student_sn",$student_sn);
$smarty->assign("sch_cname",$s[sch_cname]);
$smarty->assign("chk_value",$chk_value);
$smarty->assign("chk_item",$chk_item);
$smarty->display("academic_record_chk_new.tpl");
?>
