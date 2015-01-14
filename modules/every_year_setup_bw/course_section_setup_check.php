<?php

// $Id: auto_course_setup.php 5310 2009-01-10 07:57:56Z hami $

/* ���o�򥻳]�w�� */
include "config.php";

sfs_check();

//���o�Ҳճ]
$m_arr = &get_sfs_module_set('course_paper');
extract($m_arr, EXTR_OVERWRITE);
if ($midnoon=='') $midnoon=5;

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}


//�Y����ܾǦ~�Ǵ��A�i����Ψ��o�Ǧ~�ξǴ�
if(!empty($year_seme)){
	$ys=explode("-",$year_seme);
	$sel_year=$ys[0];
	$sel_seme=$ys[1];
}

if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�

//log�Х�
$mark="fix".$sel_year."_".$sel_seme;

//���~�]�w
if($error==1){
	$act="error";
	$error_title="�L�~�ũM�Z�ų]�w";
	$error_main="�䤣��� ".$sel_year." �Ǧ~�סA�� ".$sel_seme." �Ǵ����~�šB�Z�ų]�w�A�G�z�L�k�ϥΦ��\��C<ol><li>�Х���y<a href='".$SFS_PATH_HTML."school_affairs/every_year_setup/class_year_setup.php'>�Z�ų]�w</a>�z�]�w�~�ťH�ίZ�Ÿ�ơC<li>�H��O�o�C�@�Ǵ����Ǵ��X���n�]�w�@����I</ol>";
}
//����ʧ@�P�_
if($act=="error"){
	$main=&error_tbl($error_title,$error_main);
}elseif($act=="save_teacher_class_num"){
	save_teacher_class_num($sel_year,$sel_seme,$t_class_num,$teach_year);
	header("location: {$_SERVER['PHP_SELF']}?act=start&mode=teacher_class_num&sel_year=$sel_year&sel_seme=$sel_seme");
}elseif($act=="save_ss_class_num"){
	save_ss_class_num($sel_year,$sel_seme,$ss_class_num);
	header("location: {$_SERVER['PHP_SELF']}?act=start&mode=ss_class_num&sel_year=$sel_year&sel_seme=$sel_seme");
}elseif($act=="save_teacher_ss_num"){
	save_teacher_ss_num($sel_year,$sel_seme,$teacher_sn,$class_id,$ss_id,$all_2_teacher,$teacher_class_ss_num);
	header("location: {$_SERVER['PHP_SELF']}?act=start&mode=teacher_class_ss&class_id=$class_id&sel_year=$sel_year&sel_seme=$sel_seme");
}elseif($act=="save_set_class_time"){
	save_set_class_time($sel_year,$sel_seme,$class_id,$class_time,$all_same);
	header("location: {$_SERVER['PHP_SELF']}?act=start&mode=set_class_time&class_id=$class_id&sel_year=$sel_year&sel_seme=$sel_seme");
}elseif($act=="del_al_ss"){
	del_al_ss($ctsn);
	header("location: {$_SERVER['PHP_SELF']}?act=start&mode=$mode&class_id=$class_id&sel_year=$sel_year&sel_seme=$sel_seme");
}elseif($act=="save_same_course"){
	$ctmp_sn=save_same_course($sel_year,$sel_seme,$set_class_id,$set_ctsn);
	$ctmp=implode(",",$ctmp_sn);
	header("location: {$_SERVER['PHP_SELF']}?act=start&mode=same_course_day_set&ctmp=$ctmp&sel_year=$sel_year&sel_seme=$sel_seme");
}elseif($act=="update_same_course"){
	update_same_course($sel_year,$sel_seme,$class_time,$ctmp);
	header("location: {$_SERVER['PHP_SELF']}?act=start&mode=same_course&sel_year=$sel_year&sel_seme=$sel_seme");
}elseif($act=="del_same_course"){
	del_same_course($sel_year,$sel_seme,$class_time,$ctmp_sn);
	header("location: {$_SERVER['PHP_SELF']}?act=start&mode=$mode&sel_year=$sel_year&sel_seme=$sel_seme");
}elseif($act=="save_all"){
	$main=save_all($sel_year,$sel_seme,$mode);
	if($main=="ok")header("location: course_setup.php?sel_year=$sel_year&sel_seme=$sel_seme");
}elseif($act=="fix_class"){
	fix_class($sel_year,$sel_seme);
	header("location: {$_SERVER['PHP_SELF']}?act=start&mode=view_tmp&sel_year=$sel_year&sel_seme=$sel_seme");
}elseif($act=="add_room"){
	add_room($sel_year,$sel_seme,$sel_class,$ss_id,$room);
	header("location: {$_SERVER['PHP_SELF']}?act=start&mode=setup_class&sel_year=$sel_year&sel_seme=$sel_seme");
}elseif($act=="re_start_go"){
	$mode=re_start_go($sel_year,$sel_seme,$del_null,$del_room,$del_auto_fix,$re_start);
	header("location: {$_SERVER['PHP_SELF']}?act=start&mode=$mode&sel_year=$sel_year&sel_seme=$sel_seme");
}elseif($act=="start"){	
	$main=&start_table($sel_year,$sel_seme,$mode);
}elseif($act=="view_log"){
	$main=&view_log($mark);
}else{
	$main=&class_form($sel_year,$sel_seme);
}


//�q�X����
head("��رƽ��ˬd");
echo $main;
foot();


/*
�禡��
*/

//�򥻳]�w���
function &class_form($sel_year,$sel_seme){
	global $school_menu_p,$act;
	
	//���o�~�׻P�Ǵ����U�Կ��
	$date_select=&class_ok_setup_year($sel_year,$sel_seme,"year_seme","jumpMenu_seme");

	//����
	$help_text="
	�п�ܤ@�ӾǦ~�Ǵ��H���ˬd�C||
	<span class='like_button'>�}�l�ˬd</span> �|�}�l�i����ժ��ƽ��ˬd�C
	";
	$help=&help($help_text);

	$tool_bar=&make_menu($school_menu_p);

	$main="
	<script language='JavaScript'>
	function jumpMenu_seme(){
		if(document.myform.year_seme.options[document.myform.year_seme.selectedIndex].value!=''){
			location=\"{$_SERVER['PHP_SELF']}?act=$act&mode='ss_class_num'&year_seme=\" + document.myform.year_seme.options[document.myform.year_seme.selectedIndex].value;
		}
	}
	</script>
	$tool_bar
	<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4>
	<tr bgcolor='#FFFFFF'><td>
		<table>
		<form action='{$_SERVER['PHP_SELF']}' method='post' name='myform'>
  		<tr><td>�п�ܱ��]�w���Ǧ~�סG</td><td>$date_select</td></tr>
		<input type='hidden' name='act' value='start'>
		<input type='hidden' name='mode' value='ss_class_num'>
		<tr><td colspan='2'><input type='submit' value='�}�l�ˬd'>
		</td></tr>
		</form>
		</table>
	</td></tr>
	</table>
	<br>
	$help
	";
	return $main;
}

//�۰ʱƽҰ򥻳]�w
function &start_table($sel_year,$sel_seme,$mode=""){
	global $CONN,$weekN,$school_menu_p,$act,$class_id,$ctmp,$sel_class;
  
	//���o�Ǧ~
	$semester_name=($sel_seme=='2')?"�U":"�W";
	$date_text="<font color='#607387'>
	<font color='#000000'>$sel_year</font> �Ǧ~
	<font color='#000000'>$semester_name</font>�Ǵ�
	</font>";

	if($mode=="teacher_class_num"){
		$fmain=&teacher_class_num($sel_year,$sel_seme);
	}elseif($mode=="ss_class_num"){
		$fmain=&ss_class_num($sel_year,$sel_seme);
	}elseif($mode=="teacher_class_ss"){
		$fmain=&teacher_class_ss($sel_year,$sel_seme);
	}elseif($mode=="set_class_time"){
		$fmain=&set_class_time($sel_year,$sel_seme,$class_id);
	}elseif($mode=="same_course"){
		$fmain=&same_course($sel_year,$sel_seme);
	}elseif($mode=="same_course_day_set"){
		$fmain=&same_course_day_set($sel_year,$sel_seme,$ctmp);
	}elseif($mode=="start_class"){
		$fmain=start_class($sel_year,$sel_seme);
	}elseif($mode=="setup_class"){
		$fmain=&setup_class($sel_year,$sel_seme,$sel_class);
	}elseif($mode=="view_tmp"){
		$fmain=&view_tmp($sel_year,$sel_seme,$class_id);
	}elseif($mode=="re_start"){
		$fmain=&re_start($sel_year,$sel_seme);
	}

	$tool_bar=&make_menu($school_menu_p);	
	$main="
	$tool_bar
	$fmain
	";
	return $main;
}

//�Юv�½Ҹ`�Ƴ]�w
function &teacher_class_num($sel_year,$sel_seme){
	global $CONN,$school_kind_name;
	
	//�����o�w�����
	$sql_select = "select teacher_sn,num,teach_year from course_teach_num where year='$sel_year' and seme='$sel_seme'";
	$recordSet=$CONN->Execute($sql_select);
	while (list($teacher_sn,$num,$teach_year) = $recordSet->FetchRow()) {
		$data[$teacher_sn]=$num;
		$teach_data[$teacher_sn]=$teach_year;
	}
	
	$sql_select = "select a.name,a.teacher_sn,b.post_kind,b.class_num from teacher_base as a,teacher_post as b where a.teacher_sn=b.teacher_sn and a.teach_condition='0'";
	$recordSet=$CONN->Execute($sql_select);
	while (list($name,$teacher_sn,$post_kind,$class_num) = $recordSet->FetchRow()) {
		//���o�~�Ű}�C
		$cyear_chk="";
		$cyear=get_class_year_array($sel_year,$sel_seme);
		while(list($k,$v)=each($cyear)){
			$all_v=explode(",",$teach_data[$teacher_sn]);
			$checked=(in_array($v,$all_v))?"checked":"";
			$cyear_chk.="<input type='checkbox' name='teach_year[$teacher_sn][]' value='$v' $checked>$school_kind_name[$v]&nbsp;&nbsp;";
		}
		
		$post_kind_name=post_kind();
		$job=(empty($class_num))?$post_kind_name[$post_kind]:class_id2big5($class_num,$sel_year,$sel_seme)."�ɮv";
		
		//�Юv�b�Ӱ󪺱½Ҧ��ơA�Y>2��ܽİ�C
		$tr.="<tr bgcolor='#FFFFFF'>
		<td>$name <font size='2' color='green'>$job</font></td>
		<td>
		<input type='text' name='t_class_num[$teacher_sn]' value='$data[$teacher_sn]' size='2'>
		</td><td class='small'>
		$cyear_chk
		</td></tr>";
	}

	$main="
	<table cellspacing='1' cellpadding='3' bgcolor='#9EBCDD'>
	<tr bgcolor='#E3F2FB'><td>�Юv�m�W</td><td>�`��</td><td>�Ӯv�оǦ~�ų]�w�q�Y�S�Ŀ��ܦU�~�ų��i�H�r</td></tr>
	<form action='{$_SERVER['PHP_SELF']}' method='post'>
	$tr
	<tr><td colspan='3' align='center'>
	<input type='hidden' name='sel_year' value='$sel_year'>
	<input type='hidden' name='sel_seme' value='$sel_seme'>
	<input type='hidden' name='act' value='save_teacher_class_num'>
	<input type='submit' value='�x�s'></td></tr>
	</form>
	</table>";
	return $main;
}

//�s�W�Юv�½Ҹ`�Ƴ]�w
function save_teacher_class_num($sel_year,$sel_seme,$t_class_num=array(),$teach_year=array()){
	global $CONN;
	
	$sql_delete="delete from course_teach_num where year=$sel_year and seme='$sel_seme'";
	$CONN->Execute($sql_delete)	or trigger_error("SQL�y�k������~�G $sql_delete", E_USER_ERROR);
	
	if(is_array($t_class_num) and sizeof($t_class_num)>0){
		while(list($tsn,$num)=each($t_class_num)){
			//���B�z�ӱЮv���~�ŭ���
			$cyear=implode(",",$teach_year[$tsn]);
			$sql_insert = "insert into course_teach_num (year,seme,teacher_sn,num,teach_year) values ($sel_year,'$sel_seme','$tsn','$num','$cyear')";
			$CONN->Execute($sql_insert)	or trigger_error("SQL�y�k������~�G $sql_insert", E_USER_ERROR);
		}
	}
	return true;
}

//��ظ`�Ƴ]�w
function &ss_class_num($sel_year,$sel_seme){
	global $CONN,$SFS_PATH_HTML,$school_kind_name;
	
	//�����o�w�����
	$sql_select = "select ss_id,num from course_ss_num where year='$sel_year' and seme='$sel_seme'";
	$recordSet=$CONN->Execute($sql_select);
	while (list($ss_id,$num) = $recordSet->FetchRow()) {
		$data[$ss_id]=$num;
	}
	
	//$class_year_array=get_class_year_array($sel_year,$sel_seme);
	//�C�X�ҵ{�]�w�����]�w�~�ŻP�Z��
	$yc_array=get_ss_yc_bw($sel_year,$sel_seme);
	$ss_yc_array=get_ss_yc_sector_bw($sel_year,$sel_seme);
	if(sizeof($yc_array)==0){
		$msg="��Ʈw���䤣�� $sel_year �Ǧ~�A�� $sel_seme �Ǵ����Z�Ÿ�ơC<p>
		�Х��i�� $sel_year �Ǧ~�A�� $sel_seme �Ǵ���
		<a href='".$SFS_PATH_HTML."/school_affairs/every_year_setup/class_year_setup.php?act=setup&sel_year=$sel_year&sel_seme=$sel_seme'>
		�Z�ų]�w</a>�A�~���~��i��C</p>";
		trigger_error("�L�k���o�Ӧ~�Ū��Z�ų]�w�A $msg", E_USER_ERROR);
	}
	$i = 0;	
	$idx = 0;	
	$temp = '';
	foreach($yc_array as $yc){
		if ($temp != $yc[Cyear]){
		  $c_year_array[$i][Cyear]=$yc[Cyear];
		  $temp = $yc[Cyear];
		  $i++;
		  $c_year_class[$temp] = 0;
		  $idx = 0;
	  }
	  $c_year_class[$temp]+=1;
	  $class_id_array[$temp][$idx]=$yc[class_id];
	  $idx++;
	}
	if(sizeof($c_year_array)==0){
		trigger_error("c_year_array", E_USER_ERROR);
	}
	foreach($c_year_array as $yc){
		$td="";
		$all="";
		$Cyear=$yc[Cyear];
		$cy_name=$school_kind_name[$Cyear];
		
		//$class=&get_all_ss($sel_year,$sel_seme,$yc[Cyear],$yc[class_id]);
		$class=&get_all_ss($sel_year,$sel_seme,$yc[Cyear]);
		$n=sizeof($class);
		if(sizeof($n)==0){
			trigger_error("n", E_USER_ERROR);
		}
		$tr2.="<tr><td colspan='2' align='center'>��ظ`�Ƴ]�w</td>";
		for($i=0;$i < sizeof($class_id_array[$Cyear]) ;$i++){
			$class_id = $class_id_array[$Cyear][$i];
			$class_data=get_class_stud($class_id);
			$class_name=$cy_name."".$class_data[c_name]."�Z";			
			$tr2.="<td align='center'>$class_name</td>";
		}
    $tr2.="</tr>";
		for($j=0;$j < $n;$j++){
			$ss_id=$class[$j][ss_id];
			$ss_name=&get_ss_name("","","��",$ss_id);
			
			$td.="<tr bgcolor='#FFFFF0'><td class='small'>$ss_name</td>";
			for($k=0;$k < $c_year_class[$Cyear];$k++){
				$sector=$ss_yc_array[$ss_id][$class_id];
				if ($sector != ''){
			    $td.="<td>$sector</td>";
			  }
			  else{
			  	$td.="<td bgcolor='yellow'></td>";
			  }
		  }
			$td.="</tr>";			
			//$all+=$data[$ss_id];
		}
		//$td.="</table>";
		$n = $n + 1 ;		
		//$tr2.="<tr bgcolor='#FFFFFF'><td align='center' rowspan=$n><b>$cy_name</b><p>�@ <font color='#008000'>$n</font> ����<p>�w�� <font color='#FF0000'>$all</font> �`</td></tr>$td";
		$tr2.="<tr bgcolor='#FFFFFF'><td align='center' rowspan=$n><b>$cy_name</b><p>�@ <font color='#008000'>$n</font> ����</td></tr>$td";
	}
	
	$main="
	<table cellspacing='1' cellpadding='3' bgcolor='#9EBCDD' class='small'>	
	<form action='{$_SERVER['PHP_SELF']}' method='post'>
	$tr2
	<tr><td colspan='20' align='center'>
	<input type='hidden' name='act' value='save_ss_class_num'>
	<input type='hidden' name='sel_year' value='$sel_year'>
	<input type='hidden' name='sel_seme' value='$sel_seme'>
	</tr>
	</form>
	</table>";

	return $main;
}

//�s�W��ظ`�Ƴ]�w
function save_ss_class_num($sel_year,$sel_seme,$ss_class_num=""){
	global $CONN;
	$sql_delete="delete from course_ss_num where year=$sel_year and seme='$sel_seme'";
	$CONN->Execute($sql_delete)	or trigger_error("SQL�y�k������~�G $sql_delete", E_USER_ERROR);
	
	while(list($ss_id,$num)=each($ss_class_num)){
		$sql_insert = "insert into course_ss_num (year,seme,ss_id,num) values ($sel_year,'$sel_seme','$ss_id','$num')";
		$CONN->Execute($sql_insert)	or trigger_error("SQL�y�k������~�G $sql_insert", E_USER_ERROR);
	}
	return true;
}

//�Юv���Ь�س]�w
function &teacher_class_ss($sel_year,$sel_seme){
	global $CONN,$act,$mode,$class_id;

	$no_data=false;
	if(!empty($class_id)){
		$c=class_id_2_old($class_id);
	}else{
		$no_data=true;
	}
	
	//���o�ӯZ�ɮv�m�W�G
	$the_teacher_name=get_class_teacher($c[2]);
	
	//�s�@�Юv���
	$sql_select = "select name,teacher_sn from teacher_base where teach_condition='0'";
	$recordSet=$CONN->Execute($sql_select);
	$option="<option value=''>�п�ܱЮv</option>";
	if(!empty($the_teacher_name[sn])){
		$option.="<option value='$the_teacher_name[sn]'>�ӯZ�ɮv</option>";
	}
	while (list($name,$teacher_sn) = $recordSet->FetchRow()) {
		//�����o�Юv�w�]���½ҮɼƸ��
		$tn=get_teacher_num_all($sel_year,$sel_seme,$teacher_sn);
		//���R�ӱЮv�O�_�b�Ӧ~�Ū��Юv��椤�A�Y$tn[cyear]�O�ťժ�ܸӱЮv�A�ΩҦ��~��
		$cy=explode(",",$tn[cyear]);
		if(!empty($tn[cyear]) and !in_array($c[3],$cy))continue;
		if($tn[can] < 1)continue;
		$option.="<option value='$teacher_sn'>$name ".$tn[can]."(".$tn[ok]."/".$tn[all].")</option>\n";
	}

	$select_teacher="
	<select name='teacher_sn'>
	$option
	</select>";

	
	//�����o��ت��]�w�`��
	$sql_select = "select ss_id,num from course_ss_num where year='$sel_year' and seme='$sel_seme'";
	$recordSet=$CONN->Execute($sql_select);
	
	while (list($ss_id,$num) = $recordSet->FetchRow()) {
		//�A���o�ӯZ���Ӭ�ؤw�g�]�w���½Үɼ�
		$already_class_ss_num=get_already_class_ss_num($sel_year,$sel_seme,$class_id,$ss_id);
		
		//�ݬݸӱЮv�٦��X�`�ҥi�H��
		if(empty($already_class_ss_num))$already_class_ss_num=0;
		$ss_already_setup_n[$ss_id]=$already_class_ss_num;
		$ss_setup_n[$ss_id]=$num;
		$ss_can_setup_n[$ss_id]=$num-$already_class_ss_num;
		$all_sid_n[$ss_id]=$num;
	}
	
	$cyear_setup_n="";
	$select_ss="";
	//���o�ӯZ�Ū����
	$sql_select = "select ss_id from score_ss where class_id='$class_id' and year='$sel_year' and semester='$sel_seme' and enable='1'";
	$recordSet=$CONN->Execute($sql_select);
	
	while (list($ss_id) = $recordSet->FetchRow()) {
		$cyear_setup_n+=$ss_setup_n[$ss_id];
		$subject_name=&get_ss_name("","","��",$ss_id);
		$chkbox=(empty($ss_can_setup_n[$ss_id]))?"":"<input type='checkbox' name='ss_id[]' value='$ss_id'>";
		$fcolor=($ss_can_setup_n[$ss_id] > 0)?"#0000FF":"black";
		$select_ss.="<tr bgcolor='#FFFFFF' class='small'><td>
		$chkbox
		$subject_name </td>
		<td align='center'><font face='Verdana' color='$fcolor'>".$ss_can_setup_n[$ss_id]."</font></td>
		<td align='center'><font face='Verdana'>".$ss_already_setup_n[$ss_id]."</font></td>
		<td align='center'><font face='Verdana'>".$ss_setup_n[$ss_id]."</font>
		</td></tr>";
		
	}
	
	//�Y�S����ƨ��o�Ӧ~�Ū����
	if(empty($select_ss)){
		$sql_select = "select ss_id from score_ss where class_year='$c[3]' and class_id='' and year='$sel_year' and semester='$sel_seme' and enable='1'";
		$recordSet=$CONN->Execute($sql_select);
		while (list($ss_id) = $recordSet->FetchRow()) {
			$cyear_setup_n+=$ss_setup_n[$ss_id];
			$subject_name=&get_ss_name("","","��",$ss_id);
			$chkbox=(empty($ss_can_setup_n[$ss_id]))?"":"<input type='checkbox' name='ss_id[]' value='$ss_id'>";
			$fcolor=($ss_can_setup_n[$ss_id] > 0)?"#0000FF":"black";
			$select_ss.="<tr bgcolor='#FFFFFF' class='small'><td>
			$chkbox
			$subject_name </td>
			<td align='center'><font face='Verdana' color='$fcolor'>".$ss_can_setup_n[$ss_id]."</font></td>
			<td align='center'><font face='Verdana'>".$ss_already_setup_n[$ss_id]."</font></td>
			<td align='center'><font face='Verdana'>".$ss_setup_n[$ss_id]."</font>
			</td></tr>";
			
		}
	}
	
	$select_ss="<table width='100%' cellspacing='1' cellpadding='2' align='center' bgcolor='#E6E6E6'>
	<tr bgcolor='#E1EAFD' class='small'><td align='center'>���</td>
	<td align='center'>�Ѿl<br>�ɼ�</td>
	<td align='center'>�w�]<br>�`��</td>
	<td align='center'>���W<br>�`��</td></tr>
	$select_ss
	</table>";
	
	//���o�ӯZ�w�g�]�w�n�����
	$sql_select = "select ctsn,teacher_sn,ss_id,num from course_teacher_ss_num where class_id='$class_id' and year='$sel_year' and seme='$sel_seme'";
	$recordSet=$CONN->Execute($sql_select);
	while(list($ctsn,$tsn,$sid,$n)=$recordSet->FetchRow()){
		$subject_name=&get_ss_name("","","�u",$sid);
		$teacher_name=get_teacher_name($tsn);
		$color=($all_sid_n[$sid]!=$n)?"red":"white";
		$data.="<tr bgcolor='$color' class='small'>
		<td>$subject_name</td>
		<td align='center'>$teacher_name</td>
		<td align='center'>$n</td>
		<td>
		<a href='{$_SERVER['PHP_SELF']}?ctsn=$ctsn&act=del_al_ss&mode=$mode&class_id=$class_id&sel_year=$sel_year&sel_seme=$sel_seme'>
		�R��</a>
		</td>		
		</tr>";
		$ss_n++;
		$all_ss_n+=$n;
	}
	
	//�p�G�w�ƪ��ɼƤw�g�W�L�w�]�ɼơA��ܬ���
	$color=($cyear_setup_n < $all_ss_n)?"red":"#CEEECA";
	
	$data="
	<font size='2' color='#800000'>".$c[5]."�w�]�w���</font>
	<table cellspacing='1' cellpadding='3' bgcolor='#008000'>
	<tr bgcolor='#CEEECA' class='small'><td>���</td><td>�½ұЮv</td><td>�`��</td><td>�\��</td></tr>
	$data
	<tr bgcolor='$color' class='small'><td>�@ $ss_n ��</td><td colspan='3'>���W $cyear_setup_n �`�A�w�� $all_ss_n �`</td></tr>
	</table>";
	
	//�~�ŻP�Z�ſ��
	$class_select=&get_class_select($sel_year,$sel_seme,"","class_id","jumpMenu",$class_id);
	
	$other_data=($no_data)?"":"
	<tr bgcolor='#FFFFFF'>
	<td>�� $select_teacher �W
	<font color='#0000FF'>".$c[5]."</font>�� <input type='button' value='�Ҧ����' onClick='javascript:selectall();'><br>$select_ss 
	<p align='center'><input type='checkbox' name='all_2_teacher' value='1' checked>���]�A�ζȤW
	<input type='text' name='teacher_class_ss_num' value='' size='1'>�`</p></td>
	</tr>
	<tr><td align='center'>
	<input type='hidden' name='act' value='save_teacher_ss_num'>
	<input type='hidden' name='sel_year' value='$sel_year'>
	<input type='hidden' name='sel_seme' value='$sel_seme'>
	<input type='submit' value='�x�s'></td></tr>
	";
	
	$main="
	<script language=\"JavaScript\">
	function jumpMenu(){
		location=\"{$_SERVER['PHP_SELF']}?act=$act&mode=$mode&sel_year=$sel_year&sel_seme=$sel_seme&class_id=\" + document.myform.class_id.options[document.myform.class_id.selectedIndex].value;
	}

	function selectall() {
	  for (i=0;i<document.myform.elements.length;i++) {
	    document.myform.elements[i].checked=true;
	  }
	}
	</script>
	<table cellspacing='0' cellpadding='0'><tr><td valign='top'>
		<table cellspacing='1' cellpadding='3' bgcolor='#9EBCDD'>
		<tr><td align='center'>�Юv���Ь�س]�w</td></tr>
		<form action='{$_SERVER['PHP_SELF']}' method='post' name='myform'>
		<tr bgcolor='#FFFFFF'>
		<td>���]�w���Z�šG $class_select  �ɮv�G <font color='#cc0000'>$the_teacher_name[name]</font></td>
		</tr>
		$other_data
		</form>
		</table>
	</td><td width='5'></td><td valign='top'>$data</td></tr></table>
	";
	return $main;
}


///�R���w�g�]�w�n���Z�Ŭ��
function del_al_ss($ctsn){
	global $CONN;
	$sql_delete = "delete from course_teacher_ss_num where ctsn='$ctsn'";
	$CONN->Execute($sql_delete) or diE_USER_ERROR("SQL���楢��","SQL�y�k�p�U�G<br>$sql_delete");
	return true;
}

//�s�W�Юv���Ь�س]�w
function save_teacher_ss_num($sel_year,$sel_seme,$teacher_sn,$class_id,$ss_id,$all_2_teacher,$teacher_class_ss_num){
	global $CONN;
	if(empty($teacher_sn) or empty($ss_id)){
		trigger_error("�Юv�ά�ؤ��i�ťաA���ˬd�ݬݡA�O�_�O�ѤF�I��Юv�A�άO�S����ܽҵ{�A������̳����~���~��ƽҡC", E_USER_ERROR);
	}
	
	for($i=0;$i<sizeof($ss_id);$i++){
		//�Ӭ���]���ܡA��X�Ӭ�ت��ɼ�
		if($all_2_teacher=='1'){
			$num=get_one_class_num($sel_year,$sel_seme,$ss_id[$i]);
				
			//���o�ӯZ�ŬY��ؤw�g�]�w���`��
			$al_n=get_already_class_ss_num($sel_year,$sel_seme,$class_id,$ss_id[$i]);
			$n=$num-$al_n;
		}
		
		//���p�`�ƬO�ťժ��q�S���]�w�r�άO�h������A����H�ӽҵ{�Ҧ��`�ƨӺ�C
		$t_class_ss_num=(empty($teacher_class_ss_num) or sizeof($ss_id) > 1)?$n:$teacher_class_ss_num;
		
		//���p���ɼƤ~��J��Ʈw
		if($t_class_ss_num > 0){
			//�d�ݸӱЮv�ٯ�t�Ҫ��ɼ�
			$tn=get_teacher_num_all($sel_year,$sel_seme,$teacher_sn);
			
			//���p�ӱЮv���ɼƤ�����
			if($tn[can]<$teacher_class_ss_num){
				$subject_name=&get_ss_name("","","�u",$ss_id[$i]);
				$teacher_name=get_teacher_name($teacher_sn);
				trigger_error("�ӱЮv�`�Ƥ����A ".$teacher_name."�Ѯv���i�ƽҸ`�ƥu�� $tn[can] �`�A�L�k�ƨ� $teacher_class_ss_num �`��".$subject_name."�ҵ{�C
	<p>�ӱЮv���½Ҹ`�ƤW���� $tn[all] �`�A�w�g�ƤF $tn[ok] �`</p>
	�z�i�H�w�� $tn[can] �`��".$subject_name."�ҵ�".$teacher_name."�Ѯv�A�άO�w�ƧO���Юv�ӤW".$subject_name."�ҡC
	<p>��M�]�i�H�N�ӱЮv�b�O�Z�ΧO����ت��ҵ{��֤@�I�A���X $teacher_class_ss_num �`�ӤW".$subject_name."�ҡC</p>", E_USER_ERROR);
			}
			
			$sql_insert = "insert into course_teacher_ss_num (year,seme,teacher_sn,class_id,ss_id,num) values ($sel_year,'$sel_seme','$teacher_sn','$class_id','$ss_id[$i]','$t_class_ss_num')";
			$CONN->Execute($sql_insert)	or trigger_error("SQL�y�k������~�G $sql_insert", E_USER_ERROR);
		}
	}
	return true;
}

//���o�Y��Ҫ��w�]�`��
function get_one_class_num($sel_year,$sel_seme,$ss_id){
	global $CONN,$class_id;
	$sql_select = "select num from course_ss_num where ss_id='$ss_id' and year='$sel_year' and seme='$sel_seme'";
	$recordSet=$CONN->Execute($sql_select);
	list($num) = $recordSet->FetchRow();

	return $num;
}

//���o�Y�Юv�w�g�]�w���`��
function get_already_teacher_ss_num($sel_year,$sel_seme,$teacher_sn){
	global $CONN;
	$sql_select = "select sum(num) from course_teacher_ss_num where teacher_sn='$teacher_sn' and year='$sel_year' and seme='$sel_seme'";
	$recordSet=$CONN->Execute($sql_select);
	list($num) = $recordSet->FetchRow();
	return $num;
}

//���o�ӯZ�ŬY��ؤw�g�]�w���`��
function get_already_class_ss_num($sel_year,$sel_seme,$class_id,$ss_id){
	global $CONN;
	$sql_select = "select sum(num) from course_teacher_ss_num where class_id='$class_id'and ss_id='$ss_id' and year='$sel_year' and seme='$sel_seme'";
	$recordSet=$CONN->Execute($sql_select);
	list($num) = $recordSet->FetchRow();
	return $num;
}

//���o�ӯZ�ŬY��ؤw�g�]�w��\�Ҫ����`��
function get_ok_class_ss_num($sel_year,$sel_seme,$class_id,$ss_id){
	global $CONN;
	$sql_select = "select count(*) from course_tmp where class_id='$class_id' and ss_id='$ss_id' and year='$sel_year' and  semester='$sel_seme'";
	$recordSet=$CONN->Execute($sql_select);
	list($num) = $recordSet->FetchRow();
	return $num;
}

//���o�Юv�w�]���½ҮɼƸ�ơA�t�`�ɼơA�w�ƽҮɼơA�i�ήɼơA�A�Φ~��
function get_teacher_num_all($sel_year,$sel_seme,$teacher_sn){
	global $CONN;
	$sql_select = "select num,teach_year from course_teach_num where teacher_sn='$teacher_sn' and year='$sel_year' and seme='$sel_seme'";
	$recordSet=$CONN->Execute($sql_select);
	while (list($num,$teach_year) = $recordSet->FetchRow()) {
		//�A���o�Юv�w�g�]�w���½Үɼ�
		$main[ok]=get_already_teacher_ss_num($sel_year,$sel_seme,$teacher_sn);
		
		//�ݬݸӱЮv�٦��X�`�ҥi�H��
		if(empty($main[ok]))$main[ok]=0;
		$main[all]=$num;
		$main[can]=$num-$main[ok];
		$main[cyear]=$teach_year;
	}
	return $main;
}


//�]�w�Z�ŤW�Үɶ�
function &set_class_time($sel_year,$sel_seme,$class_id){
	global $CONN,$weekN,$midnoon;
	//���o�P�����@�C
	for ($i=1;$i<=count($weekN); $i++) {
		$main_a.="<td align='center'>�P��".$weekN[$i-1]."</td>";
	}
	
	//�C�g�����
	$dayn=sizeof($weekN)+1;
	
	//�~�ŻP�Z�ſ��
	$class_select=&get_class_select($sel_year,$sel_seme,"","class_id","jumpMenu",$class_id);
	
	if(!empty($class_id)){
		$c=class_id_2_old($class_id);
		
		//���o�w�����
		$class_times=get_set_class_time($sel_year,$sel_seme,$class_id);
		
		//���o�ҸթҦ��]�w
		$sm=&get_all_setup("",$sel_year,$sel_seme,$c[3]);
		$sections=$sm[sections];
	
		//���o�Ҫ�
		for ($j=1;$j<=$sections;$j++){

			if ($j==$midnoon){
				$all_class.= "<tr bgcolor='white' class='small'><td colspan='$dayn' align='center'>�ȥ�</td></tr>\n";
			}
			$all_class.="<tr bgcolor='#E1ECFF' class='small'><td align='center'>$j</td>";
			//�C�L�X�U�`
			for ($i=1;$i<=count($weekN); $i++) {
				$k2=$i."_".$j;
				if(!empty($class_times) and is_array($class_times)){
					$checked=(in_array($k2,$class_times))?"checked":"";
				}else{
					$checked="checked";
				}
				//�C�@��
				$all_class.="<td align='center'>
				<input type='checkbox' name='class_time[]' value='$k2' $checked>
				</td>\n";
			}
			$all_class.= "</tr>\n" ;
		}
		//�ӯZ�Ҫ�
		$main_class_list="
		<table cellspacing='1' cellpadding='2' bgcolor='#9EBCDD'>
		<tr class='small' bgcolor='#C1C1FF'><td colspan='$dayn'>$class_select 
		<input type='radio' name='all_same' value='year'><font color='#800080'>�P�~��</font>
		<input type='radio' name='all_same' value='all'><font color='#800080'>����</font> ���ĦP�˳]�w
		</td></tr>
		<tr bgcolor='#E1ECFF' class='small'><td align='center'>�`</td>$main_a</tr>
		$all_class
		<tr bgcolor='#E1ECFF'><td colspan='6' align='center'>
		<input type='hidden' name='sel_year' value='$sel_year'>
		<input type='hidden' name='sel_seme' value='$sel_seme'>
		<input type='hidden' name='act' value='save_set_class_time'>
		<input type='submit' value='�]�w'>
		</td></tr>
		</table>
		";
	}else{
		$main_class_list=$class_select;
	}
	
	$main="
	<script language=\"JavaScript\">
	function jumpMenu(){
		location=\"{$_SERVER['PHP_SELF']}?act=start&mode=set_class_time&sel_year=$sel_year&sel_seme=$sel_seme&class_id=\" + document.myform.class_id.options[document.myform.class_id.selectedIndex].value;
	}
	</script>
	<form action='{$_SERVER['PHP_SELF']}' method='post' name='myform'>
	$main_class_list
	</form>
	";
	return $main;
	
}

//�x�s�ɶ��]�w
function save_set_class_time($sel_year,$sel_seme,$class_id,$class_time,$all_same){
	global $CONN;
	
	$c=class_id_2_old($class_id);
	$Cyear=$c[3];
	
	//�Y�O�����ۦP�h��Ӧ~�Ÿ�ƥ������F�A�_�h�Ȳ����ӯZ
	if($all_same=='all'){
		$kind="";
	}elseif($all_same=='year'){
		$kind="and Cyear='$Cyear'";
	}else{
		$kind="and class_id='$class_id'";
	}

	$sql_delete="delete from course_class_time where year=$sel_year and seme='$sel_seme' $kind";
	$CONN->Execute($sql_delete)	or trigger_error("SQL�y�k������~�G $sql_delete", E_USER_ERROR);
	
	if(!empty($all_same)){
		//�C�X�Ӧ~�ſ��
		$and_where=($all_same=="all")?"":"and c_year='$Cyear'";	
		$sql_select = "select class_id from school_class where year='$sel_year' and semester = '$sel_seme' and enable='1' $and_where";
	
		$recordSet=$CONN->Execute($sql_select)  or trigger_error($sql_select, E_USER_ERROR);
		while(list($classid) = $recordSet->FetchRow()){
			reset($class_time);
			$c="";
			$c=class_id_2_old($classid);
			for($i=0;$i<sizeof($class_time);$i++){
				$sql_insert = "insert into course_class_time (year,seme,class_time,class_id,Cyear) values ($sel_year,'$sel_seme','$class_time[$i]','$classid','$c[3]')";
				$CONN->Execute($sql_insert)	or trigger_error("SQL�y�k������~�G $sql_insert", E_USER_ERROR);
			}
		}
	
	}else{
		for($i=0;$i<sizeof($class_time);$i++){
			$sql_insert = "insert into course_class_time (year,seme,class_time,class_id,Cyear) values ($sel_year,'$sel_seme','$class_time[$i]','$class_id','$Cyear')";
			$CONN->Execute($sql_insert)	or trigger_error("SQL�y�k������~�G $sql_insert", E_USER_ERROR);
		}
	}
	return true;
}

//���o�Y�@�Z���ɶ��]�w
function get_set_class_time($sel_year,$sel_seme,$class_id=""){
	global $CONN;
	$sql_select = "select class_time from course_class_time where year='$sel_year' and seme='$sel_seme' and class_id='$class_id'";
	$recordSet=$CONN->Execute($sql_select)	or trigger_error("SQL�y�k������~�G $sql_select", E_USER_ERROR);
	while(list($class_time) = $recordSet->FetchRow()){
		$main[]=$class_time;
	}
	return $main;
}


//�w�]���
function &same_course($sel_year,$sel_seme){
	global $CONN,$school_kind_name,$weekN;
	//�Z�ſ��
	$sql_select = "select class_id,c_year,c_name from school_class where year='$sel_year' and semester = '$sel_seme' and enable='1' order by c_year,c_sort";
	$recordSet=$CONN->Execute($sql_select)  or trigger_error($sql_select, E_USER_ERROR);
	while(list($class_id,$c_year,$c_name) = $recordSet->FetchRow()){
		//���o�ӯZ�ų]�w�n�����
		$sql_select = "select ctsn,teacher_sn,ss_id,num from course_teacher_ss_num where class_id='$class_id' and year='$sel_year' and seme='$sel_seme'";
		$recordSet2=$CONN->Execute($sql_select);
		$option="<option value=''>�п�ܬ��</option>";
		while (list($ctsn,$teacher_sn,$ss_id,$num) = $recordSet2->FetchRow()) {
			//���o�ӽҵ{�쥻�������`��
			$set_ss_n=get_already_class_ss_num($sel_year,$sel_seme,$class_id,$ss_id);
			
			//�ç�X�w�]�w��Ҫ����`��
			$ok_ss_n=get_ok_class_ss_num($sel_year,$sel_seme,$class_id,$ss_id);
			
			$n=$set_ss_n-$ok_ss_n;
			
			if($n==0)continue;
			
			$subject_name=&get_ss_name("","","�u",$ss_id);
			$teacher_name=get_teacher_name($teacher_sn);
			$option.="<option value='$ctsn'>$n $subject_name (".$teacher_name.")</option>\n";
		}
		//�s�@��ؿ��
		$select_ss="
		<select name='set_ctsn[$class_id]'>
		$option
		</select>";
		
		$class_name_chk.="<input type='checkbox' name='set_class_id[]' value='$class_id'>
		".$school_kind_name[$c_year]."".$c_name."�Z $select_ss
		<br>";
	}
	
	
	//�s�@�Ҫ�
	$main_class_list=&make_preview_tbl($sel_year,$sel_seme);
	
	//set_class_id
	$main="
	<script language=\"JavaScript\">
	function selectall() {
	  for (i=0;i<document.myform.elements.length;i++) {
	    document.myform.elements[i].checked=true;
	  }
	}
	</script>
	<table cellspacing='1' cellpadding='4' bgcolor='#C9DD9F'>
	<tr><td>�w�]��س]�w<input type='button' value='�����Ŀ�' onClick='javascript:selectall();'></td></td></tr>
	<tr bgcolor='#FFFFFF' class='small'>
	<form action='{$_SERVER['PHP_SELF']}' method='post' name='myform'>
	<td>$class_name_chk<br>
		
	<input type='hidden' name='sel_year' value='$sel_year'>
	<input type='hidden' name='sel_seme' value='$sel_seme'>
	<input type='hidden' name='mode' value='same_course_day_set'>
	<input type='hidden' name='act' value='save_same_course'>
	<input type='submit' value='�T�w'></td>
	</form>
	</tr>
	</table>
	
	<p>$main_class_list</p>
	";
	return $main;
}


//��X�����`�Ҫ�
function &make_preview_tbl($sel_year,$sel_seme){
	global $CONN,$school_kind_name,$weekN,$mode,$midnoon;
	//��X���~�רC��Ұ�̦h���`��
	$sections=get_most_class($sel_year,$sel_seme);
	
	//���o�P�����@�C
	for ($i=1;$i<=count($weekN); $i++) {
		$main_a.="<td align='center'>".$weekN[$i-1]."</td>";
	}
	
	//�C�g�����
	$dayn=sizeof($weekN)+1;
	
	//���o�Ҫ�
	for ($j=1;$j<=$sections;$j++){
		if ($j==$midnoon){
			$all_class.= "<tr bgcolor='white' class='small'><td colspan='$dayn' align='center'>�ȥ�</td></tr>\n";
		}
		$all_class.="<tr bgcolor='#E1ECFF' class='small'><td align='center'>$j</td>";
		//�C�L�X�U�`
		for ($i=1;$i<=count($weekN); $i++) {
			$k2=$i."_".$j;
			
			//��X�Ӯɶ��Ҧ����ҵ{
			$have_data=get_ok_class_ss($sel_year,$sel_seme,$i,$j);
			$show="";
			if(!empty($have_data) and is_array($have_data) and sizeof($have_data)!=0){
				
				for($k=0;$k<sizeof($have_data);$k++){
					$d=explode(",",$have_data[$k]);
					//$class_id=$d[0];
					//$teacher_sn=$d[1];
					//$ss_id=$d[2];
					//$ctmp_sn=$d[3];
					$tc=class_id_2_old($d[0]);
					$subject_name=&get_ss_name("","","�u",$d[2]);
					$show.="<br><a href='{$_SERVER['PHP_SELF']}?act=del_same_course&mode=$mode&ctmp_sn=$d[3]&sel_year=$sel_year&sel_seme=$sel_seme'>�R</a>�G".$tc[5]."-".$subject_name;
				}
			}
			$tool=(!empty($show))?"<a href='{$_SERVER['PHP_SELF']}?act=del_same_course&mode=$mode&class_time=$k2&sel_year=$sel_year&sel_seme=$sel_seme'>�R�����`�Ҧ��ҵ{</a>":"";
			//�C�@��
			$all_class.="<td align='center' bgcolor='white'>
			$tool
			$show
			</td>\n";
		}
		$all_class.= "</tr>\n" ;
	}
	
	//�ӯZ�Ҫ�
	$main_class_list="
	<table cellspacing='1' cellpadding='2' bgcolor='#9EBCDD'>
	<tr bgcolor='#E1ECFF' class='small'><td align='center'>�`</td>$main_a</tr>
	$all_class
	</table>
	";
	return $main_class_list;
}


//�x�s�w�]��س]�w
function save_same_course($sel_year,$sel_seme,$set_class_id,$set_ctsn){
	global $CONN,$weekN;
	
	for($i=0;$i<sizeof($set_class_id);$i++){
		$class_id=$set_class_id[$i];
		$c=class_id_2_old($class_id);
		$ctsn=$set_ctsn[$class_id];
		$ctsn_data=get_ctsn_data($ctsn);
		$sql_insert = "insert into course_tmp (year,semester,class_id,teacher_sn,class_year,class_name,ss_id) values 
	($sel_year,'$sel_seme','$class_id','$ctsn_data[teacher_sn]','$c[3]','$c[4]','$ctsn_data[ss_id]')";
		$CONN->Execute($sql_insert)	or trigger_error("SQL�y�k������~�G $sql_insert", E_USER_ERROR);
		$ctmp_sn[]=mysql_insert_id();
	}
	return $ctmp_sn;
}

//�]�w�w�]��ت��ɶ�
function &same_course_day_set($sel_year,$sel_seme,$ctmp){
	global $CONN,$weekN,$midnnon;
	$ctmp_sn=explode(",",$ctmp);
	for($i=0;$i<sizeof($ctmp_sn);$i++){
		//���o�Ȧs���ƽҪ��Y�@�����ԲӸ��
		$ctmp_data=get_ctmp_data($ctmp_sn[$i]);
		$class_id=$ctmp_data[class_id];
		$time=get_set_class_time($sel_year,$sel_seme,$class_id);
		if($i==0){
			//���˥�
			$no1_time=$time;
		}else{
			//���p�O�ĤG���H��A���ݩM���˥������
			for($i=0;$i<sizeof($time);$i++){
				if(in_array($time[$i],$no1_time))$ok_time[]=$time[$i];
			}
			//���ۧ⵲�G��@���˥�
			$no1_time=$ok_time;
		}
	}
	
	//��X���~�רC��Ұ�̦h���`��
	$sections=get_most_class($sel_year,$sel_seme);
	
	//���o�P�����@�C
	for ($i=1;$i<=count($weekN); $i++) {
		$main_a.="<td align='center'>".$weekN[$i-1]."</td>";
	}
	
	//�C�g�����
	$dayn=sizeof($weekN)+1;
	
	//���o�Ҫ�
	for ($j=1;$j<=$sections;$j++){
		if ($j==$midnoon){
			$all_class.= "<tr bgcolor='white' class='small'><td colspan='$dayn' align='center'>�ȥ�</td></tr>\n";
		}
		$all_class.="<tr bgcolor='#E1ECFF' class='small'><td align='center'>$j</td>";
		//�C�L�X�U�`
		for ($i=1;$i<=count($weekN); $i++) {
			$k2=$i."_".$j;
			
			//��X�Ӯɶ��Ҧ����ҵ{
			$have_data=get_ok_class_ss($sel_year,$sel_seme,$i,$j);
			$show="";
			if(!empty($have_data) and is_array($have_data) and sizeof($have_data)!=0){
				
				for($k=0;$k<sizeof($have_data);$k++){
					$d=explode(",",$have_data[$k]);
					//$class_id=$d[0];
					//$teacher_sn=$d[1];
					//$ss_id=$d[2];
					$tc=class_id_2_old($d[0]);
					$subject_name=&get_ss_name("","","�u",$d[2]);
					$teacher_name=get_teacher_name($d[1]);
					$show.="<br>".$tc[5]."-".$subject_name."(".$teacher_name.")";
				}
			}
			$chk_box=(in_array($k2,$no1_time))?"<input type='radio' name='class_time' value='$k2'>":"";
			//�C�@��
			$all_class.="<td align='center' bgcolor='$color'>
			$chk_box
			$show
			</td>\n";
		}
		$all_class.= "</tr>\n" ;
	}
	//�ӯZ�Ҫ�
	$main_class_list="
	<table cellspacing='1' cellpadding='2' bgcolor='#9EBCDD'>
	<form action='{$_SERVER['PHP_SELF']}' method='post'>
	<tr bgcolor='#E1ECFF' class='small'><td align='center'>�`</td>$main_a</tr>
	$all_class
	<tr bgcolor='#E1ECFF'><td colspan='6' align='center'>
	<input type='hidden' name='sel_year' value='$sel_year'>
	<input type='hidden' name='sel_seme' value='$sel_seme'>
	<input type='hidden' name='ctmp' value='$ctmp'>
	<input type='hidden' name='act' value='update_same_course'>
	<input type='submit' value='�]�w'>
	</td></tr>
	</form>
	</table>
	";
	
	
	return $main_class_list;
}


//��s�w�]��س]�w��������]�w
function update_same_course($sel_year,$sel_seme,$class_time,$ctmp){
	global $CONN;
	$t=explode("_",$class_time);
	$ctmp_sn=explode(",",$ctmp);
	for($i=0;$i<sizeof($ctmp_sn);$i++){
		$sql_update = "update course_tmp set day='$t[0]',sector='$t[1]' where ctmp_sn=$ctmp_sn[$i]";
		$CONN->Execute($sql_update)	or trigger_error("SQL�y�k������~�G $sql_update", E_USER_ERROR);
	}
	return true;
}

//�R���w�]��س]�w�����Y�@�`
function del_same_course($sel_year,$sel_seme,$class_time="",$ctmp_sn=""){
	global $CONN;
	if(empty($ctmp_sn)){
		$t=explode("_",$class_time);
		$kind="day='$t[0]' and sector='$t[1]'";
	}else{
		$kind="ctmp_sn='$ctmp_sn'";
	}
	$sql_delete = "delete from course_tmp where $kind and year='$sel_year' and semester='$sel_seme'";
	$CONN->Execute($sql_delete)	or trigger_error("SQL�y�k������~�G $sql_delete", E_USER_ERROR);
	
	return true;
}


//���o�Y�@�]�w�n����ظԲӸ��
function get_ctsn_data($ctsn){
	global $CONN;
	$sql_select = "select * from course_teacher_ss_num where ctsn='$ctsn'";
	$recordSet=$CONN->Execute($sql_select);
	$array=$recordSet->FetchRow();
	return $array;
}

//���o�Ȧs���ƽҪ��Y�@�����ԲӸ��
function get_ctmp_data($ctmp_sn){
	global $CONN;
	$sql_select = "select * from course_tmp where ctmp_sn='$ctmp_sn'";
	$recordSet=$CONN->Execute($sql_select);
	$array=$recordSet->FetchRow();
	return $array;
}


//��X�Y�@�`�\�Ҫ��w�]�w���Ҧ��ҵ{
function get_ok_class_ss($sel_year,$sel_seme,$day,$sector){
	global $CONN;
	$sql_select = "select ctmp_sn,class_id,teacher_sn,ss_id from course_tmp where day='$day' and sector='$sector' and year='$sel_year' and  semester='$sel_seme'";
	$recordSet=$CONN->Execute($sql_select);
	while(list($ctmp_sn,$class_id,$teacher_sn,$ss_id) = $recordSet->FetchRow()){
		$main[]=$class_id.",".$teacher_sn.",".$ss_id.",".$ctmp_sn;
	}
	return $main;
}

//�]�w�M��Ы�
function &setup_class($sel_year,$sel_seme,$sel_class=""){
	global $CONN,$school_kind_name,$weekN,$act,$mode;
	$all_year=array();
	//�Z�ſ��
	$sql_select = "select class_id,c_year,c_name from school_class where year='$sel_year' and semester = '$sel_seme' and enable='1' order by c_year,c_sort";
	$recordSet=$CONN->Execute($sql_select)  or trigger_error($sql_select, E_USER_ERROR);
	while(list($class_id,$c_year,$c_name) = $recordSet->FetchRow()){
		//�s�@�~�Ű}�C
		if(in_array($c_year,$all_year)){
			continue;
		}else{
			$selected=($c_year==$sel_class)?"selected":"";
			$school_sel_1.="<option value='$c_year' $selected>�Ҧ�".$school_kind_name[$c_year]."��</option>\n";
			$all_year[]=$c_year;
		}
		//�s�@�Z�ſ��
		$selected=($class_id==$sel_class)?"selected":"";
		$school_sel_2.="<option value='$class_id' $selected>".$school_kind_name[$c_year]."".$c_name."�Z\n";
	}
	
	//�s�@���ժ��~�ŻP�Z�ŤU�Կ��
	$selected_all=($sel_class=="all")?"selected":"";
	$school_sel="
	<select name='sel_class' size='1' onChange='jumpMenu()'>
	<option value=''>�п�ܳ]�w�d��</option>
	<option value='all' $selected_all>����</option>
	$school_sel_1
	$school_sel_2
	</select>";
	
	
	if(!empty($sel_class)){
		if($sel_class=="all"){
			$what_class="";
		}elseif(strlen($sel_class) <= 3){
			$y=(strlen($sel_year)==2)?"0".$sel_year:$sel_year;
			$cy=(strlen($sel_class)==1)?"0".$sel_class:$sel_class;
			$what_class="and left(class_id,8)='".$y."_".$sel_seme."_".$cy."'";
		}else{
			$what_class="and class_id='$sel_class'";
		}
		//���o�ӯZ�ų]�w�n�����
		$sql_select = "select ss_id from course_teacher_ss_num where year='$sel_year' and seme='$sel_seme' $what_class";
		$recordSet2=$CONN->Execute($sql_select);
		$option="<option value=''>�п�ܬ��</option>";
		$ss_name=array();
		$same_ss_name=array();
		
		while (list($ss_id) = $recordSet2->FetchRow()) {
			
			$subject_name=&get_ss_name("","","�u",$ss_id);

			//�P�_�O�_�n�q�X�ӿﶵ
			if(show_this_subject_name($sel_year,$sel_seme,$sel_class,$ss_id))continue;			
	
			//���קK���ծɡA�����ƪ���ئW�١A�G�p�G�O���ժ��A�B�b$ss_name���X�{�L���A�B�٨S�[�J���Ƭ�ذ}�C$same_ss_name����ءA�N�N���[�J
			if($sel_class=="all" and in_array($subject_name,$ss_name) and !in_array($subject_name,$same_ss_name)){
				//���Ƭ�ذ}�C
				$same_ss_name[]=$subject_name;
			}
			//�Ҧ���ذ}�C
			$ss_name[$ss_id]=$subject_name;
		}

		//�Y�諸�O����
		if($sel_class=="all"){
			while(list($ss_id,$subject_name)=each($ss_name)){
				//�Y�Ӭ�جO���Ƭ�ذ}�C�������
				if(in_array($subject_name,$same_ss_name)){
					//��P�@�ӦW�٪����ޡqss_id�r���X
					$the_ss_id=array_keys ($ss_name, $subject_name);
					$ss_id=implode(",",$the_ss_id);
				}
				$all_ss_name[$ss_id]=$subject_name;
			}
		}else{
			$all_ss_name=$ss_name;
		}
		
		while(list($ss_id,$subject_name)=each($all_ss_name)){
			$option.="<option value='$ss_id'>$subject_name</option>\n";
		}
		
		//�s�@��ؿ��
		$select_ss="
		<select name='ss_id'>
		$option
		</select>";
	}else{
		$select_ss="���Ǭ��";
	}
	
	//$room_setup=now_room_setup($sel_year,$sel_seme);
	$main_class_list=&make_preview_tbl($sel_year,$sel_seme);
	$main="
	<script language='JavaScript'>
	function jumpMenu(){
		if(document.myform.sel_class.options[document.myform.sel_class.selectedIndex].value!=''){
			location=\"{$_SERVER['PHP_SELF']}?act=$act&mode=$mode&sel_year=$sel_year&sel_seme=$sel_seme&sel_class=\" + document.myform.sel_class.options[document.myform.sel_class.selectedIndex].value;
		}
	}
	</script>
	<form action='{$_SERVER['PHP_SELF']}' method='post' name='myform'>
	$school_sel
	��
	$select_ss
	���b
	<input type='text' name='room' size='10'>
	�W��
	<input type='hidden' name='act' value='add_room'>
	<input type='submit' value='�s�W'>
	</form>
	$main_class_list";
	return $main;
}

//�s�W�M��ЫǪ��]�w
function add_room($sel_year,$sel_seme,$sel_class,$ss_id,$room){
	global $CONN;
	
	//���ѬY�@�쪺��إN��
	$ss_id_array=explode(",",$ss_id);
	
	//��X�o�ǽҵ{�Ҧ����`�`��
	$all_num=get_ssid_all_num($sel_year,$sel_seme,$ss_id_array);

	//��X���~�רC��Ұ�̦h���`��
	$max_num=get_most_class($sel_year,$sel_seme);
	
	//���p�A�Ҧ��һݪ��ɶ���(�̤j�`��-1)*5��-�P���T���|�`�ҡA�٤p
	$no=($all_num-(($max_num-1)*5-4)<=0)?"0":array(1);
	
	for($j=0;$j<sizeof($ss_id_array);$j++){
		$sid=$ss_id_array[$j];
		
		//���o���w�ҵ{
		$sql_select = "select ctsn,teacher_sn,class_id,num from course_teacher_ss_num where ss_id=$sid and year='$sel_year' and seme='$sel_seme' order by rand()";
		
		$recordSet=$CONN->Execute($sql_select);
		while(list($ctsn,$teacher_sn,$class_id,$num)=$recordSet->FetchRow()){
			$c=class_id_2_old($class_id);
			
			for($i=0;$i<$num;$i++){
				//��X�Ӭ�ؤw�g�]�w���`��
				$n=get_ok_class_ss_num($sel_year,$sel_seme,$class_id,$sid);
				//���p�Ӭ�ؤw�g��w�]���`���٤j�Τ@�ˤj�A�����L
				if($n >= $num)continue;
			
				//��X�ӱЫǥi�H�ƽҪ��ɶ�
				$time=get_one_class_time($sel_year,$sel_seme,$class_id,$teacher_sn,$room,$no);
				$day=$time[day];
				$sector=$time[sector];
				//�}�l��
				$sql_insert = "insert into course_tmp (year,semester,class_id,teacher_sn,class_year,class_name,day,sector,ss_id,room,other) values 
			($sel_year,'$sel_seme','$class_id','$teacher_sn','$c[3]','$c[4]','$day','$sector','$sid','$room','room')";
				$CONN->Execute($sql_insert)	or trigger_error("SQL�y�k������~�G $sql_insert", E_USER_ERROR);
			}
		}
	}
	return;
}


//��X�M��ЫǪ��o�ǽҵ{�Ҧ����`�`��
function get_ssid_all_num($sel_year,$sel_seme,$ss_id_array){
	global $CONN,$school_kind_name;
	$all_num=0;
	for($j=0;$j<sizeof($ss_id_array);$j++){
		$sid=$ss_id_array[$j];
		
		//���o���w�ҵ{
		$sql_select = "select num from course_teacher_ss_num where ss_id=$sid and year='$sel_year' and seme='$sel_seme'";
		
		$recordSet=$CONN->Execute($sql_select);
		list($num)=$recordSet->FetchRow();
		$all_num+=$num;		
	}
	return $all_num;
}


//�P�_�O�_�n�q�X�ӿﶵ�Atrue=���F�A����A�X�{
function show_this_subject_name($sel_year,$sel_seme,$sel_class,$ss_id){
	global $CONN,$school_kind_name;
	return false;
	if($sel_class=="all"){
		//���ժ����p�A�u�n���X�{�L��ss_id�N��
		$all_ss_id=get_room_setup($sel_year,$sel_seme,$cr_sn,$ss_id,"");
		while(list($cr_sn,$ssid)=each($all_ss_id)){
			if(substr_count($ssid,",")){
				$ss_id_array=explode(",",$ssid);
			}
		}
		
	}elseif(strlen($sel_class)<=3){
		//�~�Ū����p�A�Ӧ~�šA�Ӧ~�ũ��U���Y�Z�A���զ��X�{���N��
	}else{
		//�Z�Ū����p�A�ӯZ�šA�Ӧ~�šA���զ��X�{���N��
	}
}

//�}�l�ƽ�
function start_class($sel_year,$sel_seme,$mode=""){
	global $CONN,$weekN,$act;
	if(have_tmp_course($sel_year,$sel_seme)){
		header("location: {$_SERVER['PHP_SELF']}?act=$act&mode=view_tmp&sel_year=$sel_year&sel_seme=$sel_seme");
	}
	//���o�Ҧ��ҵ{
	$sql_select = "select ctsn,teacher_sn,class_id,ss_id,num from course_teacher_ss_num where year='$sel_year' and seme='$sel_seme' order by rand()";
	$recordSet=$CONN->Execute($sql_select);
	while(list($ctsn,$teacher_sn,$class_id,$ss_id,$num)=$recordSet->FetchRow()){
		
		$c=class_id_2_old($class_id);
		//���o�ӯZ�ɮv�G
		$the_teacher=get_class_teacher($c[2]);
		
		//�Ĥ@���]�ƽҡA���ƾɮv
		if($mode==""){
			if($the_teacher[sn]==$teacher_sn)continue;
		}else{
			if($the_teacher[sn]!=$teacher_sn)continue;
		}
		
		for($i=0;$i<$num;$i++){
			//��X�Ӭ�ؤw�g�]�w���`��
			$n=get_ok_class_ss_num($sel_year,$sel_seme,$class_id,$ss_id);
			//���p�Ӭ�ؤw�g��w�]���`���٤j�Τ@�ˤj�A�����L
			if($n >= $num)continue;
			
			//��X�ӯZ�ťi�H�ƽҪ��ɶ�
			$time=get_one_class_time($sel_year,$sel_seme,$class_id,$teacher_sn);
						
			$day=$time[day];
			$sector=$time[sector];
			
			//�}�l��
			$sql_insert = "insert into course_tmp (year,semester,class_id,teacher_sn,class_year,class_name,day,sector,ss_id,other) values 
		($sel_year,'$sel_seme','$class_id','$teacher_sn','$c[3]','$c[4]','$day','$sector','$ss_id','auto')";
			$CONN->Execute($sql_insert)	or trigger_error("SQL�y�k������~�G $sql_insert", E_USER_ERROR);
			
		}
	}
	
	//�Ĥ@���ƽҫ�A�A�Ƥ@���ɮv����
	if($mode==""){
		start_class($sel_year,$sel_seme,"go");
	}else{
		header("location: {$_SERVER['PHP_SELF']}?act=$act&mode=view_tmp&sel_year=$sel_year&sel_seme=$sel_seme");
	}
	
	return;
}


//��X�Y�@�`�A�i�H�ƽҪ��Z��
function get_ok_class_time($sel_year,$sel_seme,$time){
	global $CONN;
	//��X�ӯZ���W�Ҫ��ɶ�
	$sql_select = "select class_id from course_class_time where year='$sel_year' and seme='$sel_seme' and class_time='$time'";
	$recordSet=$CONN->Execute($sql_select)	or trigger_error("SQL�y�k������~�G $sql_select", E_USER_ERROR);
	while(list($class_id) = $recordSet->FetchRow()){
		$data[]=$class_id;
	}
	return $data;
}

//�]�ĤG���ƽҡA��İ󪺽ҽն}
function fix_class($sel_year,$sel_seme){
	global $CONN,$weekN,$mark;
	//��X���~�רC��Ұ�̦h���`��
	$sections=get_most_class($sel_year,$sel_seme);
	//�C�g�����
	$dayn=sizeof($weekN)+1;
	
	//���o�Ҫ�
	for ($j=1;$j<=$sections;$j++){
		//�U�`
		for ($i=1;$i<=count($weekN); $i++) {
			$k2=$i."_".$j;
			//��X�Ӯɶ��i�H�ƽҪ��Z��
			$class_array=get_ok_class_time($sel_year,$sel_seme,$k2);
			
			for($n=0;$n<sizeof($class_array);$n++){
				$class_id=$class_array[$n];
				if(!is_have_class($sel_year,$sel_seme,$class_id,$i,$j)){
					//�����ƽҫo���ƽҪ��ɶ��@���}�C
					$time_no_class[$class_id][]=$i."_".$j;
				}
			}
		}
	}
	
	
	//���o�ӯZ�|���]�w�n�����
	$sql_select = "select ctmp_sn,class_id,teacher_sn,ss_id from course_tmp where day='' and sector=0 and year='$sel_year' and  semester='$sel_seme'";
	$recordSet=$CONN->Execute($sql_select);
	while(list($ctmp_sn,$class_id,$teacher_sn,$ss_id)=$recordSet->FetchRow()){
		$time=$time_no_class[$class_id][0];
		$t=explode("_",$time);
		
		
		$C=class_id_2_old($class_id);
		$SN=&get_ss_name("","","�u",$ss_id);
		$TN=get_teacher_name($teacher_sn);
		$log.="<strong>$C[5] �� $TN �W�� $SN ��( $ctmp_sn )�|���]�w�n�C�t�αN��ӽҵ{�w�ƨ�P�� $t[0] �� $t[1] �`</strong><br>";
		
		array_shift ($time_no_class[$class_id]);
		
		//�]���İ�ӥ��ƤJ���Юv�٬�A�Юv�A���ƯZ��A�Z�A���Ʈɶ�A�`
		//�İ�Z��B�Z�A�İ�B�`
		//�սҹ�H�ЮvC�Юv�A����Үɶ�C�`
		
		//��XA�Юv�bA�`�AB�Z�O���@�Z�A�H�έ��@�`��
		$other=get_teacher_time($sel_year,$sel_seme,$time,$class_id,$teacher_sn);
		
		$other_class_id=$other[class_id];
		$other_ctmp_sn=$other[ctmp_sn];
		
		$OC=class_id_2_old($other_class_id);
		$log.="<font color='#FF0000'>�İ��]�G $TN �b $OC[5] ���P�� $t[0] �� $t[1] �`���ҡA�ҥH�İ�C</font><br>";
		
		//�սҡA��B�Z��A�v�PC�v���աA$ctmp_sn�����OB�`��
		$logtmp=&chang_class($sel_year,$sel_seme,$time,$class_id,$other_class_id,$teacher_sn,$other_ctmp_sn);
		
		$log.=$logtmp;
		
		$log.="<font color='#0000FF'>�t�Χ�".$C[5].$TN."��".$SN."��( $ctmp_sn ) �w�ƨ�P�� $t[0] �� $t[1] �`�C</font><br>";
		//��A�`�Ƶ�A�Юv
		$sql_update = "update course_tmp set day='$t[0]',sector='$t[1]',other='fix' where ctmp_sn='$ctmp_sn'";
		$CONN->Execute($sql_update) or trigger_error("SQL�y�k���~�G $sql_update", E_USER_ERROR);
	}
	add_log($log,$mark);
	return;
}


//�ս�
function &chang_class($sel_year,$sel_seme,$old_time,$class_id,$other_class_id,$teacher_sn,$other_ctmp_sn){
	global $CONN;
	
	//���o��Z�Ū��Ҧ��ɶ��qA�Z�r
	$class_all_time=get_set_class_time($sel_year,$sel_seme,$class_id);
	
	//A�`
	$ot=explode("_",$old_time);
	
	//��X�ӱЮv�H�~���Юv�AC�Юv
	$sql_select = "select teacher_sn from course_tmp where class_id='$other_class_id' and teacher_sn!='$teacher_sn' and year='$sel_year' and  semester='$sel_seme' group by teacher_sn";
	$recordSet=$CONN->Execute($sql_select) or trigger_error("SQL�y�k���~�G $sql_select", E_USER_ERROR);
	while(list($tsn) = $recordSet->FetchRow()){
		$TN=get_teacher_name($teacher_sn);
		$OC=class_id_2_old($other_class_id);
		$OTN=get_teacher_name($tsn);
		$log="�t�Φb".$OC[5]."���".$OTN."�A�ݸӮv�O�_���ɶ��i�H�սҡC<br>";
		
		//��X�ӱЮv�b�ӯZ���Ъ��Y�@�`�ҡqC�`�r
		$class_time_array=get_teacher_class($sel_year,$sel_seme,$other_class_id,$tsn);
		while(list($time,$ctmp_sn)=each($class_time_array)){
			
			$t=explode("_",$time);
			$log.="�d��".$OTN."�Ѯv�P�� $t[0] �� $t[1] �`�O�_�i�H�աH";
			//���R�C�@�`�A�YA�v�]�S�ҴNOK
			$At=teacher_have_class($sel_year,$sel_seme,$t[0],$t[1],$teacher_sn);
			if($At){
				$ok_at=false;
				$log.="&nbsp;&nbsp;&nbsp;&nbsp;<font color='#808000'>".$TN."����I</font>";
			}else{
				$ok_at=true;
				$log.="&nbsp;&nbsp;&nbsp;&nbsp;<font color='#9900CC'>".$TN."�i�H�I</font>";
			}
			
			//���R�C�@�`�A�YC�v�]�S�ҴNOK
			$Ct=teacher_have_class($sel_year,$sel_seme,$ot[0],$ot[1],$tsn);
			if($Ct){
				$ok_ct=false;
				$log.="&nbsp;&nbsp;&nbsp;&nbsp;<font color='#808000'>��".$OTN."����I</font><br>";
			}else{
				$ok_ct=true;
				$log.="&nbsp;&nbsp;&nbsp;&nbsp;<font color='#9900CC'>".$OTN."�i�H�I</font><br>";
			}
			
			//���R�Ӹ`�O�_���M��ЫǤW���Ĭ�A�Y�S���NOK
			$OCr=room_have_class($sel_year,$sel_seme,$t[0],$t[1],$other_ctmp_sn);
			if($OCr){
				$ok_ocr=false;
				$log.="&nbsp;&nbsp;&nbsp;&nbsp;<font color='#808000'>���]�ЫǽĬ𤣦�I</font><br>";
			}else{
				$ok_ocr=true;
				$log.="&nbsp;&nbsp;&nbsp;&nbsp;<font color='#9900CC'>�ЫǤ]�i�H�I</font><br>";
			}
			
			$Cr=room_have_class($sel_year,$sel_seme,$ot[0],$ot[1],$ctmp_sn);
			if($Cr){
				$ok_cr=false;
				$log.="&nbsp;&nbsp;&nbsp;&nbsp;<font color='#808000'>���]�ЫǽĬ𤣦�I</font><br>";
			}else{
				$ok_cr=true;
				$log.="&nbsp;&nbsp;&nbsp;&nbsp;<font color='#9900CC'>�ЫǤ]�i�H�I</font><br>";
			}
			
			if($ok_ct and $ok_at and $ok_cr and $ok_ocr){
				$log.="<font color='#0000FF'>�t�Χ�".$OC[5]."��".$OTN."�Ѯv��P�� $t[0] �� $t[1] �`�W���ҽը�P�� $ot[0] �� $ot[1] �`�C</font><br>";
				//���쪺C�Юv�W���ҡAC�`����B�`
				$sql_update = "update course_tmp set day='$ot[0]',sector='$ot[1]',other='fix' where ctmp_sn='$ctmp_sn'";
				$CONN->Execute($sql_update) or trigger_error("SQL�y�k���~�G $sql_update");
				
				$log.="<font color='#0000FF'>�t�Χ�".$OC[5]."��".$TN."�Ѯv��P�� $ot[0] �� $ot[1] �`�W���ҽը�P�� $t[0] �� $t[1] �`�C</font><br>";
				//���Ӫťժ������W��ӧ�쪺�ɶ�
				$sql_update = "update course_tmp set day='$t[0]',sector='$t[1]',other='fix' where ctmp_sn='$other_ctmp_sn'";
				$CONN->Execute($sql_update) or trigger_error("SQL�y�k���~�G $sql_update", E_USER_ERROR);
				return $log;
			}
		}
		$log.="�䤣��".$OC[5]."�i�H�սҪ��Юv�ήɶ��C<br>";
	}
	return $log;
}



//��X�Y�ӱЮv�b�Y�Ӯɶ��O�b���@�Z�W��
function get_teacher_time($sel_year,$sel_seme,$time,$class_id,$teacher_sn){
	global $CONN;
	$t=explode("_",$time);
	$day=$t[0];
	$sector=$t[1];
	$sql_select = "select ctmp_sn,class_id from course_tmp where class_id!='$class_id' and day='$day' and sector='$sector' and teacher_sn='$teacher_sn' and year='$sel_year' and  semester='$sel_seme'";
	$recordSet=$CONN->Execute($sql_select);
	while(list($ctmp_sn,$class_id) = $recordSet->FetchRow()){
		$main[ctmp_sn]=$ctmp_sn;
		$main[class_id]=$class_id;
		return $main;
	}
	return;
}

//��X�ӱЮv�b�ӯZ���Ъ���
function get_teacher_class($sel_year,$sel_seme,$class_id,$teacher_sn){
	global $CONN;
	//��X�ӱЮv�H�~���Юv
	$sql_select = "select ctmp_sn,day,sector,ss_id from course_tmp where class_id='$class_id' and teacher_sn='$teacher_sn' and year='$sel_year' and  semester='$sel_seme' order by rand()";
	$recordSet=$CONN->Execute($sql_select);
	while(list($ctmp_sn,$day,$sector,$ss_id) = $recordSet->FetchRow()){
		$time=$day."_".$sector;
		$class[$time]=$ctmp_sn;
	}
	return $class;
}


//�d�ݼȦs�Ҫ�O�_�w�g�ƹL�ҵ{
function have_tmp_course($sel_year,$sel_seme){
	global $CONN;
	$sql_select = "select count(*) from course_tmp where other='auto' and year='$sel_year' and  semester='$sel_seme'";
	$recordSet=$CONN->Execute($sql_select);
	while(list($n) = $recordSet->FetchRow()){
		if($n > 0)return true;
	}
	return false;
}

//�d�ݬY�Z�Y�ҼȦs�Ҫ�O�_�w�g�s�b
function have_class_in_tmp_course($sel_year,$sel_seme,$ss_id,$teacher_sn,$class_id){
	global $CONN;
	$sql_select = "select count(*) from course_tmp where ss_id='$ss_id' and teacher_sn='$teacher_sn' and class_id='$class_id' and year='$sel_year' and  semester='$sel_seme'";
	$recordSet=$CONN->Execute($sql_select);
	while(list($n) = $recordSet->FetchRow()){
		if($n > 0)return true;
	}
	return false;
}

//��X�ӯZ�ťi�H�ƽҪ��ɶ�
function get_one_class_time($sel_year,$sel_seme,$class_id,$teacher_sn,$room="",$no=array(1)){
	global $CONN;
	//��X�ӯZ���W�Ҫ��ɶ�
	$sql_select = "select class_time from course_class_time where year='$sel_year' and seme='$sel_seme' and class_id='$class_id' order by rand()";
	$recordSet=$CONN->Execute($sql_select)	or trigger_error("SQL�y�k������~�G $sql_select", E_USER_ERROR);
	while(list($class_time) = $recordSet->FetchRow()){
		$t=explode("_",$class_time);
		$day=$t[0];
		$sector=$t[1];
		
		if($room!=""){
			//�ư��Ĥ@�`
			if(!empty($no) and is_array($no) and in_array($sector,$no)) continue;
			
			//�P�_�Ӹ`�ӱЫǬO�_�w�g����
			if(is_room_have_class($sel_year,$sel_seme,$room,$day,$sector)) continue;
		}
		//�P�_�Y�@�`�ӯZ�O�_�w�g�Ʀn�ҤF�C
		if(is_have_class($sel_year,$sel_seme,$class_id,$day,$sector)) continue;
		
		//�ݬݸӮɶ��ӦѮv�O�_�w�g���W��
		if(teacher_have_class($sel_year,$sel_seme,$day,$sector,$teacher_sn)) continue;
		
		$time[day]=$day;
		$time[sector]=$sector;
		return $time;	
	}
	return false;
}

//��X�Y�@�`�ҬY�Ѯv�O�_�w�g���ҤF
function teacher_have_class($sel_year,$sel_seme,$day,$sector,$teacher_sn){
	global $CONN;
	$sql_select = "select count(*) from course_tmp where teacher_sn='$teacher_sn' and year='$sel_year' and  semester='$sel_seme' and day='$day' and sector='$sector'";
	$recordSet=$CONN->Execute($sql_select)	or trigger_error("SQL�y�k������~�G $sql_select", E_USER_ERROR);
	list($n) = $recordSet->FetchRow();
	if($n > 0)return true;
	return false;
}


//�P�_�Y�@�`�Y�@�Z�O�_�w�g�Ʀn�ҤF�Ctmp
function is_have_class($sel_year,$sel_seme,$class_id,$day,$sector){
	global $CONN;
	$sql_select = "select ss_id from course_tmp where day='$day' and sector='$sector' and year='$sel_year' and  semester='$sel_seme' and class_id='$class_id'";
	$recordSet=$CONN->Execute($sql_select);
	while(list($ss_id) = $recordSet->FetchRow()){
		if(!empty($ss_id))return true;
	}
	return false;
}

//�P�_�Ӹ`�ӱЫǬO�_�w�g����
function is_room_have_class($sel_year,$sel_seme,$room,$day,$sector){
	global $CONN;
	$sql_select = "select ss_id from course_tmp where day='$day' and sector='$sector' and year='$sel_year' and  semester='$sel_seme' and room='$room'";
	$recordSet=$CONN->Execute($sql_select);
	while(list($ss_id) = $recordSet->FetchRow()){
		if(!empty($ss_id))return true;
	}
	return false;
}

//�P�_�ӽҵ{�ӱЫǬO�_�w�g����
function room_have_class($sel_year,$sel_seme,$day,$sector,$ctmp_sn){
	global $CONN;
	//�����Rctmp_sn�o��ҬO�_�|�Ψ�M��Ы�
	$sql_select = "select room from course_tmp where ctmp_sn='$ctmp_sn'";
	$recordSet=$CONN->Execute($sql_select);
	list($room) = $recordSet->FetchRow();
	if(empty($room))return false;
	
	$sql_select = "select room from course_tmp where day='$day' and sector='$sector' and year='$sel_year' and  semester='$sel_seme'";
	$recordSet=$CONN->Execute($sql_select);
	while(list($have_room) = $recordSet->FetchRow()){
		if(!empty($have_room) and $have_room==$room)return true;
	}
	return false;
}

//�[�ݼȱƽҪ�
function &view_tmp($sel_year,$sel_seme,$class_id){
	global $act,$mode;

	//�~�ŻP�Z�ſ��
	$class_select=&get_class_select($sel_year,$sel_seme,"","class_id","jumpMenu",$class_id);

	//���o�~�׻P�Ǵ����U�Կ��
	$date_select="$sel_year �Ǧ~�� $sel_seme �Ǵ�";

	$list_class_table=&search_class_tmp_table($sel_year,$sel_seme,$class_id,"view");

	$main="
	<script language=\"JavaScript\">
	function jumpMenu(){
		location=\"{$_SERVER['PHP_SELF']}?act=$act&mode=$mode&sel_year=$sel_year&sel_seme=$sel_seme&class_id=\" + document.myform.class_id.options[document.myform.class_id.selectedIndex].value;
	}
	</script>
	<table cellspacing='1' cellpadding='2'  bgcolor=#9EBCDD>
	<form action='{$_SERVER['PHP_SELF']}' method='post' name='myform'>
	<tr bgcolor='#F7F7F7' class='small'>
	<td>$date_select $class_select
	<a href='{$_SERVER['PHP_SELF']}?act=fix_class&sel_year=$sel_year&sel_seme=$sel_seme'>�ץ��İ�</a>�A
	<a href='{$_SERVER['PHP_SELF']}?act=save_all&sel_year=$sel_year&sel_seme=$sel_seme'>�����פJ�����Ҫ�</a>
	</td>
	</tr>
	</form>
	</table>
	$list_class_table
	";
	return $main;
}

//�C�X�Y�ӯZ�Ū��Ȧs�Ҫ�
function &search_class_tmp_table($sel_year="",$sel_seme="",$class_id="",$tsn=""){
	global $CONN,$class_year,$conID,$weekN,$school_menu_p,$midnoon;

	if(empty($class_id)){
		//���o���ЯZ�ťN��
		$class_num=get_teach_class();
		$class_id=old_class_2_new_id($class_num,$sel_year,$sel_seme);
	}

	//���o�Z�Ÿ��
	$the_class=get_class_all($class_id);

	//�C�g�����
	$dayn=sizeof($weekN)+1;
	
	$sql_select = "select teacher_sn,day,sector,ss_id,other from course_tmp where class_id='$class_id' order by day,sector";
	$recordSet=$CONN->Execute($sql_select) or trigger_error("���~�T���G $sql_select", E_USER_ERROR);
	while (list($teacher_sn,$day,$sector,$ss_id,$other)= $recordSet->FetchRow()) {
		$k=$day."_".$sector;
		$a[$k]=$ss_id;
		$b[$k]=$teacher_sn;
		$r[$k]=$other;
	}

	//���o�P�����@�C
	for ($i=1;$i<=count($weekN); $i++) {
		$main_a.="<td align='center' >�P��".$weekN[$i-1]."</td>";
	}

	//���o�ҸթҦ��]�w
	$sm=&get_all_setup("",$sel_year,$sel_seme,$the_class[year]);
	$sections=$sm[sections];

	if(!empty($class_id)){

		//���o�Ҫ�
		for ($j=1;$j<=$sections;$j++){

			if ($j==$midnoon){
				$all_class.= "<tr bgcolor='white' class='small'><td colspan='$dayn' align='center'>�ȥ�</td></tr>\n";
			}

			$all_class.="<tr bgcolor='#E1ECFF' class='small'><td align='center'>$j</td>";

			//�C�L�X�U�`
			for ($i=1;$i<=count($weekN); $i++) {
				$k2=$i."_".$j;
				
				$teacher_search_mode=(!empty($tsn) and $tsn==$b[$k2])?true:false;

				//��ت��U�Կ��
				$subject_sel="".get_ss_name("","","�u",$a[$k2])."";
				
				//�Юv���U�Կ��
				$teacher_sel="<font color='#996699'>".get_teacher_name($b[$k2])."</font>";
				
				$align="align='center'";
				$color=($r[$k2]=="fix")?"#ccffcc":"white";

				//�C�@��
				$all_class.="<td $align bgcolor='$color' width='90'>
				$subject_sel<br>
				$teacher_sel
				</td>\n";
				$sidn=$a[$k2];
				$ss_num[$sidn]++;
			}
			
			$all_class.= "</tr>\n" ;
		}
		
		if(!empty($tsn))$class_name="<tr bgcolor='#B9C5FF' class='small'><td colspan=6>$the_class[name] �ҵ{��</td></tr>";

		//�ӯZ�Ҫ�
		$main_class_list="
		$class_name
		<tr bgcolor='#E1ECFF'><td align='center'>�`</td>$main_a</tr>
		$all_class
		";
	}else{
		$main_class_list="";
	}
	
	//���o�ӯZ�w�g�]�w�n�����
	$sql_select = "select teacher_sn,ss_id,num from course_teacher_ss_num where class_id='$class_id' and year='$sel_year' and seme='$sel_seme'";
	$recordSet=$CONN->Execute($sql_select);
	while(list($tsn,$sid,$n)=$recordSet->FetchRow()){
		$ok_n=$ss_num[$sid];
		$subject_name=&get_ss_name("","","�u",$sid);
		$teacher_name=get_teacher_name($tsn);
		$color=($ok_n!=$n)?"red":"white";
		$data.="<tr bgcolor='$color' class='small'>
		<td>$subject_name</td>
		<td align='center'>$teacher_name</td>
		<td align='center'>$n</td>
		<td align='center'>$ok_n</td>
		</tr>";
	}
	$ss_setup="<table cellspacing='1' cellpadding='2' bgcolor='#008000'>
	<tr align='center' bgcolor='#C7DB9D' class='small'>
	<td>���</td><td>�Юv</td><td>�w�]<br>�`��</td><td>�w��<br>�`��</td></tr>
	$data</table>";

	$main="
	<table cellspacing='0' cellpadding='0'><tr><td valign='top'>
		<table border='0' cellspacing='1' cellpadding='4' bgcolor='#9EBCDD'>
		$main_class_list
		</table>
	</td><td width='10'></td><td valign='top'>$ss_setup</td></tr></table>
	";
	return  $main;
}

//��Ҧ��ƥX���Ҫ�פJ�����Ҫ�
function save_all($sel_year,$sel_seme,$mode=""){
	global $CONN,$act;
	
	if($mode=="replace"){
		$sql_delete="delete from score_course where year='$sel_year' and semester='$sel_seme'";
		$CONN->Execute($sql_delete) or trigger_error("���~�T���G $sql_delete", E_USER_ERROR);
	}elseif($mode=="no"){
		header("location: {$_SERVER['PHP_SELF']}?act=start&mode=view_tmp&sel_year=$sel_year&sel_seme=$sel_seme");
		return ;
	}else{
		$sql_select = "select count(*) from score_course where year='$sel_year' and semester='$sel_seme'";
		$recordSet=$CONN->Execute($sql_select) or trigger_error("���~�T���G $sql_select", E_USER_ERROR);
		list($n)= $recordSet->FetchRow();
		if($n > 0){
			$msg="<form action='{$_SERVER['PHP_SELF']}' method='post'>
			�� $sel_year �Ǧ~�ײ� $sel_seme �Ǵ��w�g���Ҫ��ơA�O�_�n�л\�¸�ơH
			�άO�����ثe���檺�ʧ@�H
			<p><input type='radio' name='mode' value='replace' checked>
			��즳�¸�ƥ����л\���A���W�s���ƽҸ�ơC</p>
			<p><input type='radio' name='mode' value='no'>
			�����ثe���ʧ@�A����즳���Ҫ��Ƨ@������ܡC</p>
			<input type='hidden' name='act' value='$act'>
			<div align='center'><input type='submit' value='����'></div>
			</form>";
			
			$main=&error_tbl("�� $sel_year �Ǧ~�ײ� $sel_seme �Ǵ��w�g���Ҫ���",$msg);
			return $main;
		}
	}
	
	$sql_select = "select year,semester,class_id,teacher_sn,class_year,class_name,day,sector,ss_id,room from course_tmp where year='$sel_year' and  semester='$sel_seme' order by class_id,day,sector";
	$recordSet=$CONN->Execute($sql_select) or trigger_error("���~�T���G $sql_select", E_USER_ERROR);
	while (list($year,$semester,$class_id,$teacher_sn,$class_year,$class_name,$day,$sector,$ss_id,$room)= $recordSet->FetchRow()) {
		save_to_course($year,$semester,$class_id,$teacher_sn,$class_year,$class_name,$day,$sector,$ss_id,$room);
	}
	return "ok";
}

//�s�J�����Ҫ�
function save_to_course($year,$semester,$class_id,$teacher_sn,$class_year,$class_name,$day,$sector,$ss_id,$room){
	global $CONN;
	$sql_insert = "insert into score_course 
	(year,semester,class_id,teacher_sn,class_year,class_name,day,sector,ss_id,room) values 
	('$year','$semester','$class_id','$teacher_sn','$class_year','$class_name','$day','$sector','$ss_id','$room')";
	$CONN->Execute($sql_insert)	or trigger_error("SQL�y�k������~�G $sql_insert", E_USER_ERROR);
	return true;
}

//���s�ƽ�
function &re_start($sel_year,$sel_seme){
	global $CONN;
	$main="
	<table>
	<tr><td>
	<form action='{$_SERVER['PHP_SELF']}' method='post'>
	<input type='checkbox' name='del_null' value=true>�M���u�w�]��ءv���]�w�H�Ωұƪ��ҵ{<br>
	<input type='checkbox' name='del_room' value=true>�M���u�M��Ыǡv�]�w�H�Ωұƪ��ҵ{<br>
	<input type='checkbox' name='del_auto_fix' value=true checked>�M���۰ʱƪ��ҵ{<br>
	<input type='checkbox' name='re_start' value=true checked>���ƽҵ{
	<font size='2' color='#0000FF'>�q�惡���|�j�����u�M���۰ʱƪ��ҵ{�v�r</font><br>
	<input type='hidden' name='act' value='re_start_go'><br>
	<input type='submit' value='����'>
	</form>
	</td></tr>
	</table>
	";
	return $main;
}

//���歫�s�ƽҩR�O
function re_start_go($sel_year,$sel_seme,$del_null,$del_room,$del_auto_fix,$re_start){
	global $CONN;
	
	$mode="re_start";
	
	if($del_null){
		$sql_delete="delete FROM course_tmp WHERE other='' and year=$sel_year and semester='$sel_seme'";
		$CONN->Execute($sql_delete)	or trigger_error("SQL�y�k������~�G $sql_delete", E_USER_ERROR);
		$mode="same_course";
	}
	if($del_room){
		$sql_delete="delete FROM course_tmp WHERE other='room' and year=$sel_year and semester='$sel_seme'";
		$CONN->Execute($sql_delete)	or trigger_error("SQL�y�k������~�G $sql_delete", E_USER_ERROR);
		$mode="setup_class";
	}
	if($del_auto_fix or $re_start){
		$sql_delete="delete FROM course_tmp WHERE (other='auto' or other='fix') and year=$sel_year and semester='$sel_seme'";
		$CONN->Execute($sql_delete)	or trigger_error("SQL�y�k������~�G $sql_delete", E_USER_ERROR);
		$mode="setup_class";
	}
	if($re_start){
		$mode="start_class";
	}
	return $mode;
}

?>
