<?php
//$Id: index.php 7478 2013-09-05 05:12:02Z infodaes $
include "config.php";

//�{��
sfs_check();

$act=$_REQUEST[act];
$err=$_GET[err];
$sel_year=(empty($_REQUEST[sel_year]))?curr_year():$_REQUEST[sel_year]; //�ثe�Ǧ~
$sel_seme=(empty($_REQUEST[sel_seme]))?curr_seme():$_REQUEST[sel_seme]; //�ثe�Ǵ�

//�D�n���e
if ($_POST[copy]) {
	if($act=="go_class_setup"){
		go_class_setup($_POST[ys],$sel_year,$sel_seme);
		header("location: {$_SERVER[PHP_SELF]}?y=$sel_year&s=$sel_seme&act=go_class_setup");
	}elseif($act=="go_score_setup"){
		go_score_setup($_POST[ys],$sel_year,$sel_seme);
		header("location: $_SERVER[PHP_SELF]?y=$sel_year&s=$sel_seme&act=go_score_setup");
	}elseif($act=="go_ss_setup"){
		go_ss_setup($_POST[ys],$sel_year,$sel_seme);
		header("location: $_SERVER[PHP_SELF]?y=$sel_year&s=$sel_seme&act=go_ss_setup");
	}elseif($act=="go_course_setup"){
		go_course_setup($_POST[ys],$sel_year,$sel_seme);
		header("location: $_SERVER[PHP_SELF]?y=$sel_year&s=$sel_seme&act=go_course_setup");
	}
}elseif($_POST[del]){
	$err=del_setup();
	header("location: $_SERVER[PHP_SELF]?err=$err");
}else{
	$main=main_form($sel_year,$sel_seme);
}


//�q�X�����������Y
head("�]�w�ƻs");
echo $main;
//�G������
foot();


function main_form($sel_year,$sel_seme){
	global $school_menu_p,$err,$act;

	//�ﶵ
	if ($act=="") $act="go_class_setup";
	switch($act) {
		case "go_class_setup":
			//�Z�ų]�w
			$array=get_class_setup_ys($sel_year,$sel_seme);
			$to_class_setup=to_ys("to_y","to_s",$array);
			$g=0;
			break;
		case "go_score_setup":
			//���Z�]�w
			$array=get_score_setup_ys($sel_year,$sel_seme);
			$to_score_setup=to_ys("to_y","to_s",$array);
			$g=1;
			break;
		case "go_ss_setup":
			//�ҵ{�]�w
			$array=get_ss_setup_ys($sel_year,$sel_seme);
			$to_ss_setup=to_ys("to_y","to_s",$array);
			$g=2;
			break;
		case "go_course_setup":
			//�Ҫ�]�w
			$array=get_course_setup_ys($sel_year,$sel_seme);
			$to_course_setup=to_ys("to_y","to_s",$array);
			$g=3;
			break;
	}
	if ($g=="") $g=0;
	$checked[$g]="checked";
	$setup[$g]=make_option($array,"ys");

	//�ˬd�{�����
	$chk[0]=(chk_have_ys("school_class",$sel_year,$sel_seme))?"true":"false";
	$chk[1]=(chk_have_ys("score_setup",$sel_year,$sel_seme))?"true":"false";
	$chk[2]=(chk_have_ys("score_ss",$sel_year,$sel_seme))?"true":"false";
	$chk[3]=(chk_have_ys("score_course",$sel_year,$sel_seme))?"true":"false";
	for($i=0;$i<=3;$i++) {
		$err_msg[$i]=($chk[$i]=="true")?"<br><font color='red'>(���Ǵ��w�����)</font>":"";
	}

	//�����\���
	$tool_bar=&make_menu($school_menu_p);
	$main="$tool_bar
	<table cellspacing='1' cellpadding='6' bgcolor='#C0C0C0' class='small'>
	<input type='hidden' name='data[sp_sn]' value='$DBV[sp_sn]'>
	<tr class='title_mbody' align='center'><td>
	����
	</td><td>
	�q���@�Ǵ��]��Ƶ��ơ^
	</td><td>
	�ƻs����@�Ǵ�
	</td><td>
	����
	</td><td>
	�R��
	</td></tr>
	<form name='setform' action='$_SERVER[PHP_SELF]' method='post'>
	<tr bgcolor='#FFFFFF'><td>
        <input type='radio' name='act' value='go_class_setup' $checked[0] OnChange='this.form.submit();'>�Z�ų]�w $err_msg[0]
	</td><td rowspan='4' align='center'>".
	$setup[$g]."
	</td><td rowspan='4' align='center'>
	$sel_year �Ǧ~�ײ� $sel_seme �Ǵ�
	</td><td rowspan='4' align='center'>
	<input type=\"submit\" value=\"�}�l�ƻs\" class=\"b1\" name=\"copy\">
	</td><td rowspan='4' align=\"center\">
	<input type='submit' value='�R�����Ǵ��w�s�b���' class='b1' name=\"del\" OnClick=\"return confirm('�T�w�R��".$sel_year."�Ǧ~�ײ�".$sel_seme."�Ǵ��u�Z�ų]�w�v�B�u���Z�]�w�v�B�u�ҵ{�]�w�v�B�u�Ҫ�]�w�v�����?');\"";
	if ($err==1)
		$main.=" disabled=\"true\"><br><font color=\"red\">(���Ǵ��w�����Z�����\�R���]�w)</font>";
	else
		$main.=">";
	$main.="
	</td></tr>
	<tr bgcolor='#FFFFFF'><td>
	<input type='radio' name='act' value='go_score_setup' $checked[1] OnChange='this.form.submit();'>���Z�]�w $err_msg[1]
	</td></tr>
	<tr bgcolor='#FFFFFF'><td>
	<input type='radio' name='act' value='go_ss_setup' $checked[2] OnChange='this.form.submit();'>�ҵ{�]�w $err_msg[2]
	</td></tr>
	<tr bgcolor='#FFFFFF'><td>
	<input type='radio' name='act' value='go_course_setup' $checked[3] OnChange='this.form.submit();'>�Ҫ�]�w $err_msg[3]
	</td></tr>
	</form>
	</table>
	<p>
	<table cellspacing='1' cellpadding='6' bgcolor='#C0C0C0' class='small'>
	<tr bgcolor='#FFFFFF'><td style='line-height:2'>
	���u��¤O�j�j�A�i�H�b�u�������z�ƻs�U�ؾǴ���]�w�C���O�A�۹諸�A�Y�~�Ϊ��ܡA�y�����l�`�]�j�A�]���Ш̷ӥH�U��k�Ӷi��ƫe�ǳơA�H�קK�y���L�i���Ϫ����p�G
	<ol>
	<li>�b�ϥΤ��e�A�гƥ� copy_log�Bschool_class�Bscore_setup�Bscore_ss�Bscore_course ����ƪ�A�H�קK�X���D�C
	<li>�Хѡu�W�v�ӡu�U�v�A�̷Ӷ��ǽƻs�A�ɶq�Ÿ��۽ƻs�A�]�����Ǹ�ƬO���̩ۨʪ��C
	<p style='color:blue'>�ҡG�Y���ƻs�Ҫ�A�u�ҵ{�]�w�v�ȥ����ƻs�A�]���u�ҵ{�]�w�v����Ʒ|�Q�u�Ҫ�]�w�v�ҨϥΡC</p>
	<li>�Y���ק�䤤���󶵥ءA�Щ�Ҧ��ƻs�ʧ@�����A�i��A�H���w���C
	<p style='color:blue'>�ҡG�Y���ƻs�Ҫ�A�����ƻs���u�ҵ{�]�w�v��A�򱵵۶i��u�Ҫ�]�w�v���ƻs�C�d�U���n�ƻs���u�ҵ{�]�w�v��A�N�h�վ�u�ҵ{�]�w�v�A�M��S�Ӷi��u�Ҫ�]�w�v���ƻs�A�o�˱N���i��X���D�C</p>
	<li>���u���ĳ�Φb�W�U�Ǵ����]�w�ƻs�A������ĳ�Φb�s�Ǧ~�פW�A�]���Ǧ~�׶����t������j�C
	<p style='color:blue'>�ҡG�H�@�~�ůZ�żƨӻ��A92�~�U�Ǵ����@�~�ůZ�żơA���o���|�M 93 �~�W�Ǵ����Z�żƤ@�ˡA�ҥH����ĳ�νƻs���覡�C</p>
	</ol>
	</td></tr>
	</table>
	";
	return $main;
}

//���o�{���Z�ų]�w���Ǧ~�׾Ǵ�
function get_class_setup_ys($sel_year,$sel_seme){
	global $CONN;
	$sql_select="select count(*), year , semester FROM school_class WHERE enable='1' group by year , semester order by year desc,semester desc";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while (list($count,$year,$semester)=$recordSet->FetchRow()) {
		$k=sprintf("%03d%01d", $year, $semester);
		$main[$k]=$count;
	}
	return $main;
}

//���o�{�����Z�]�w���Ǧ~�׾Ǵ�
function get_score_setup_ys($sel_year,$sel_seme){
	global $CONN;
	$sql_select="select count(*), year , semester FROM score_setup WHERE enable='1' group by year , semester order by year desc,semester desc";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while (list($count,$year,$semester)=$recordSet->FetchRow()) {
		$k=sprintf("%03d%01d", $year, $semester);
		$main[$k]=$count;
	}
	return $main;
}

//���o�{����س]�w���Ǧ~�׾Ǵ�
function get_ss_setup_ys($sel_year,$sel_seme){
	global $CONN;
	$sql_select="select count(*), year , semester FROM score_ss WHERE enable='1' group by year , semester order by year desc,semester desc";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while (list($count,$year,$semester)=$recordSet->FetchRow()) {
		$k=sprintf("%03d%01d", $year, $semester);
		$main[$k]=$count;
	}
	return $main;
}

//���o�{���Ҫ�]�w���Ǧ~�׾Ǵ�
function get_course_setup_ys($sel_year,$sel_seme){
	global $CONN;
	$sql_select="select count(*), year , semester FROM score_course group by year , semester order by year desc,semester desc";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while (list($count,$year,$semester)=$recordSet->FetchRow()) {
		$k=sprintf("%03d%01d", $year, $semester);
		$main[$k]=$count;
	}
	return $main;
}

//�s�@�U�Կ�檺�ﶵ
function make_option($array=array(),$name){
	$main="<select name='$name'>";
	foreach($array as $k=>$v){
		$y=substr($k,0,3)*1;
		$s=substr($k,-1)*1;
		$show=$y." �Ǧ~�ײ� ".$s."�Ǵ�";
		$main.="<option value='$k'>".$show."�]".$v."�^</option>";
	}
	$main.="</select>";
	return $main;
}

//�s�@���ƻs��Ǧ~�����
function to_ys($y_name,$s_name,$array=array()){
	global $sel_year,$sel_seme;

	foreach($array as $k=>$v){
		$y=substr($k,0,3)*1;
		$s=substr($k,-1)*1;
		break;
	}

	if($s=='1'){
		$yy=$y;
		$ss=2;
	}elseif($s=='2'){
		$yy=$y+1;
		$ss=1;
	}

	$selected1=($ss==1)?"selected":"";
	$selected2=($ss==2)?"selected":"";
	$main="<input value='$yy' size='3' name='$y_name' type='text'> �Ǧ~�ײ�	<select name='$s_name'><option value='1' $selected1>1</option><option value='2' $selected2>2</option></select>�Ǵ�";
	return $main;
}


//�ƻs��log
function cp_log($log=array(),$tbl_name="",$record=array(),$year="",$semester=""){
	global $CONN;

	foreach($log as $sn){
		$in[]="('$sn','$tbl_name',now(),'$record[$sn]','$year','$semester')";
	}
	$all_in=implode(",",$in);

	$sql_insert = "insert into copy_log (sn,tbl_name,date,record,year,semester) values $all_in";
	$CONN->Execute($sql_insert);
}

//���olog��������������
function get_cp_log($tbl_name=""){
	global $CONN;
	$sql_select = "select sn,record FROM copy_log where tbl_name='$tbl_name'";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while(list($sn,$record)=$recordSet->FetchRow()){
		$main[$record]=$sn;
	}
	return $main;
}

//�ˬd�O�Ӹ�ƪ��Ǧ~�Ǵ����p
function chk_have_ys($tbl="",$year="",$semester=""){
	global $CONN;
	$sql_select="select count(*)  FROM $tbl WHERE year='$year' and semester='$semester'";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	list($count)=$recordSet->FetchRow();
	return $count;
}

//�}�l�ƻs�Z�ų]�w
function go_class_setup($ys="",$to_y="",$to_s=""){
	global $CONN;
	if(empty($ys) or empty($to_y) or empty($to_s))return;

	$y=substr($ys,0,3)*1;
	$s=substr($ys,-1)*1;

	//�ˬd�O�_�w�����
	$count=chk_have_ys("school_class",$to_y,$to_s);
	if($count)user_error("�w����".$to_y."�Ǧ~�ײ�".$to_s."�Ǵ����Z�Ÿ�ơA�ƻs����C",256);

	$sql_select="select class_id,c_year,c_name,c_kind,c_sort,teacher_1,teacher_2 FROM school_class WHERE enable='1' and year='$y' and semester='$s'";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while (list($class_id,$c_year,$c_name,$c_kind,$c_sort,$teacher_1,$teacher_2)=$recordSet->FetchRow()) {
		$new_class_id=sprintf("%03d_%01d", $to_y, $to_s).substr($class_id,-6);
		$teacher_1 = addslashes($teacher_1);
		$teacher_2 = addslashes($teacher_2);
		$sql_insert = "insert into school_class (class_id,year,semester,c_year,c_name,c_kind,c_sort,enable,teacher_1,teacher_2) values ('$new_class_id','$to_y','$to_s','$c_year','$c_name','$c_kind','$c_sort','1','$teacher_1','$teacher_2')";
		$CONN->Execute($sql_insert) or user_error("�Z�Žƻs���ѡI<br>$sql_insert",256);
		$sn=mysql_insert_id();
		$log[]=$sn;
		$record[$sn]=$class_id;
	}
	cp_log($log,"school_class",$record,$to_y,$to_s);
	return ;
}

//�}�l�ƻs���Z�]�w
function go_score_setup($ys="",$to_y="",$to_s=""){
	global $CONN;
	if(empty($ys) or empty($to_y) or empty($to_s))return;

	$y=substr($ys,0,3)*1;
	$s=substr($ys,-1)*1;


	//�ˬd�O�_�w�����
	$count=chk_have_ys("score_setup",$to_y,$to_s);
	if($count)user_error("�w����".$to_y."�Ǧ~�ײ�".$to_s."�Ǵ������Z�]�w��ơA�ƻs����C",256);

	//�ˬd�O�_�w���Z�Ÿ��
	$count=chk_have_ys("school_class",$to_y,$to_s);
	if(empty($count))user_error("�S����".$to_y."�Ǧ~�ײ�".$to_s."�Ǵ����Z�ų]�w��ơA�]���L�k�i��ҵ{�ƻs�C",256);

	$sql_select="select setup_id,class_year,allow_modify,performance_test_times,practice_test_times,test_ratio,rule,score_mode,sections,interface_sn FROM score_setup WHERE enable='1' and year='$y' and semester='$s'";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while (list($setup_id,$class_year,$allow_modify,$performance_test_times,$practice_test_times,$test_ratio,$rule,$score_mode,$sections,$interface_sn)=$recordSet->FetchRow()) {
		$sql_insert = "insert into score_setup (year,semester,class_year,allow_modify,performance_test_times,practice_test_times,test_ratio,rule,score_mode,sections,interface_sn,update_date,enable) values ('$to_y','$to_s','$class_year','$allow_modify','$performance_test_times','$practice_test_times','$test_ratio','$rule','$score_mode','$sections','$interface_sn',now(),'1')";
		$CONN->Execute($sql_insert) or user_error("���Z�]�w�ƻs���ѡI<br>$sql_insert",256);
		$sn=mysql_insert_id();
		$log[]=$sn;
		$record[$sn]=$setup_id;
	}
	cp_log($log,"score_setup",$record,$to_y,$to_s);
	return;
}

//�}�l�ƻs�ҵ{�]�w
function go_ss_setup($ys="",$to_y="",$to_s=""){
	global $CONN;
	if(empty($ys) or empty($to_y) or empty($to_s))return;

	$y=substr($ys,0,3)*1;
	$s=substr($ys,-1)*1;

	//�ˬd�O�_�w�����
	$count=chk_have_ys("score_ss",$to_y,$to_s);
	if($count)user_error("�w����".$to_y."�Ǧ~�ײ�".$to_s."�Ǵ����ҵ{��ơA�ƻs����C",256);

	//�ˬd�O�_�w���Z�Ÿ��
	$count=chk_have_ys("school_class",$to_y,$to_s);
	if(empty($count))user_error("�S����".$to_y."�Ǧ~�ײ�".$to_s."�Ǵ����Z�ų]�w��ơA�]���L�k�i��ҵ{�ƻs�C",256);
	// �ƻs�Ҧ��ҵ{(�t�Z�Žҵ{ )by hami  2012-2-24
	$sql_select="select ss_id,scope_id,subject_id,class_id,class_year,need_exam,rate,sort,sub_sort,print,link_ss,nor_item_kind FROM score_ss WHERE  enable='1' and year='$y' and semester='$s'";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while (list($ss_id,$scope_id,$subject_id,$class_id,$class_year,$need_exam,$rate,$sort,$sub_sort,$print,$link_ss,$nor_item_kind)=$recordSet->FetchRow()) {
		if ($class_id) {
			$new_class_id= sprintf("%03d_%01d", $to_y, $to_s).substr($class_id,-6);
			$sql_insert = "insert into score_ss (scope_id,subject_id,year,semester,class_year,enable,need_exam,rate,sort,sub_sort,print,link_ss,nor_item_kind,class_id) values ('$scope_id','$subject_id','$to_y','$to_s','$class_year','1','$need_exam','$rate','$sort','$sub_sort','$print','$link_ss','$nor_item_kind','$new_class_id')";
		}
		else
			$sql_insert = "insert into score_ss (scope_id,subject_id,year,semester,class_year,enable,need_exam,rate,sort,sub_sort,print,link_ss,nor_item_kind) values ('$scope_id','$subject_id','$to_y','$to_s','$class_year','1','$need_exam','$rate','$sort','$sub_sort','$print','$link_ss','$nor_item_kind')";

		$CONN->Execute($sql_insert) or user_error("�ҵ{�]�w�ƻs���ѡI<br>$sql_insert",256);
		$sn=mysql_insert_id();
		$log[]=$sn;
		$record[$sn]=$ss_id;
	}
	cp_log($log,"score_ss",$record,$to_y,$to_s);
	return;
}


//�}�l�ƻs�Ҫ�]�w
function go_course_setup($ys="",$to_y="",$to_s=""){
	global $CONN;
	if(empty($ys) or empty($to_y) or empty($to_s))return;

	$y=substr($ys,0,3)*1;
	$s=substr($ys,-1)*1;

	//�ˬd�O�_�w�����
	$count=chk_have_ys("score_course",$to_y,$to_s);
	if($count)user_error("�w����".$to_y."�Ǧ~�ײ�".$to_s."�Ǵ����Ҫ�]�w��ơA�ƻs����C",256);

	//�ˬd�O�_�w�ҵ{���
	$count=chk_have_ys("copy_log",$to_y,$to_s);
	if(empty($count))user_error("�z�S���i���".$to_y."�Ǧ~�ײ�".$to_s."�Ǵ����ҵ{�]�w��ƽƻs�A�]���L�k�i��Ҫ�ƻs�C",256);

	$new_ss_id=get_cp_log("score_ss");

	$sql_select="select course_id,class_id,teacher_sn,class_year,class_name,day,sector,ss_id,room,allow,c_kind FROM score_course WHERE year='$y' and semester='$s'";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while (list($course_id,$class_id,$teacher_sn,$class_year,$class_name,$day,$sector,$ss_id,$room,$allow,$c_kind)=$recordSet->FetchRow()) {
		$new_class_id=sprintf("%03d_%01d", $to_y, $to_s).substr($class_id,-6);
		$sql_insert = "insert into score_course (year,semester,class_id,teacher_sn,class_year,class_name,day,sector,ss_id,room,allow,c_kind) values ('$to_y','$to_s','$new_class_id','$teacher_sn','$class_year','$class_name','$day','$sector','$new_ss_id[$ss_id]','$room','$allow','$c_kind')";
		$CONN->Execute($sql_insert) or user_error("�Ҫ�]�w�ƻs���ѡI<br>$sql_insert",256);
		$sn=mysql_insert_id();
		$log[]=$sn;
		$record[$sn]=$course_id;
	}
	cp_log($log,"score_course",$record,$to_y,$to_s);
	return;
}

//�R���]�w
function del_setup(){
	global $CONN,$sel_year,$sel_seme;

	$score_semester="score_semester_".$sel_year."_".$sel_seme;
	$query="select * from $score_semester where 1=0";
	if (!$CONN->Execute($query)) {
		$query="select count(score) from $score_semester where score>'0'";
		$res=$CONN->Execute($query);
		if ($res->fields[0]>0) return 1;
	}
	$CONN->Execute("delete from school_class where year='$sel_year' and semester='$sel_seme'");
	$CONN->Execute("delete from score_setup where year='$sel_year' and semester='$sel_seme'");
	$CONN->Execute("delete from score_ss where year='$sel_year' and semester='$sel_seme'");
	$CONN->Execute("delete from score_course where year='$sel_year' and semester='$sel_seme'");
	$CONN->Execute("delete from copy_log where year='$sel_year' and semester='$sel_seme'");
	return 0;
}
?>
