<?php

// $Id: section_setup.php 5310 2009-01-10 07:57:56Z hami $

/* ���o�򥻳]�w�� */
include "config.php";

sfs_check();

//�Y����ܾǦ~�Ǵ��A�i����Ψ��o�Ǧ~�ξǴ�
if(!empty($_REQUEST[year_seme])){
	$ys=explode("-",$year_seme);
	$sel_year=$ys[0];
	$sel_seme=$ys[1];
}

$sel_year=(empty($_REQUEST[sel_year]))?curr_year():$_REQUEST[sel_year]; //�ثe�Ǧ~
$sel_seme=(empty($_REQUEST[sel_seme]))?curr_seme():$_REQUEST[sel_seme]; //�ثe�Ǵ�
$class_id=$_REQUEST[class_id];
$act=$_REQUEST[act];
$ss_id=$_REQUEST[ss_id];
$input_course_name=$_POST[input_course_name];
$input_sections=$_POST[input_sections];
$input_test_times=$_POST[input_test_times];
$input_score_mode=$_POST[input_score_mode];
$input_display_mode=$_POST[input_display_mode];
$rs=$_POST[rs];
$rn=$_POST[rn];
$cls=$_POST[cls];

//���~�]�w
if($error==1){
	$act="error";
	$error_title="�L�~�ų]�w";
	$error_main="�䤣�� $sel_year �Ǧ~�סA�� $sel_seme �Ǵ����~�ų]�w�A�G�z�L�k�ϥΦ��\��C<ol><li>�Х���y<a href='".$SFS_PATH_HTML."school_affairs/every_year_setup/class_year_setup.php'>�Z�ų]�w</a>�z�]�w�~�ťH�ίZ�Ÿ�ơC<li>�H��O�o�C�@�Ǵ����Ǵ��X���n�]�w�@����I</ol>";
}

//����ʧ@�P�_
if($act=="error"){
	$main=&error_tbl($error_title,$error_main);
}elseif($act=="�x�s�]�w"){
	update_section_set($ss_id,$sel_year,$sel_seme,$class_id);
	header("location: {$_SERVER['PHP_SELF']}?sel_year=$sel_year&sel_seme=$sel_seme&act=set_ss&class_id=$class_id");
}elseif($act=="copy_name"){
	update_course_name($ss_id,$sel_year,$sel_seme,$class_id,$_GET[course_name]);
	header("location: {$_SERVER['PHP_SELF']}?sel_year=$sel_year&sel_seme=$sel_seme&act=set_ss&class_id=$class_id");
}elseif($act=="add"){
	add_sn($ss_id,$sel_year,$sel_seme,$class_id);
	header("location: {$_SERVER['PHP_SELF']}?sel_year=$sel_year&sel_seme=$sel_seme&act=set_ss&class_id=$class_id");
}elseif($act=="del"){
	del_sn($class_id,$ss_id);
	header("location: {$_SERVER['PHP_SELF']}?sel_year=$sel_year&sel_seme=$sel_seme&act=set_ss&class_id=$class_id");
}elseif($act=="view" or ($act=="�}�l�]�w" && $class_id) or $act=="set_ss" or $act=="modify_exam"){
	if($act=="�}�l�]�w")$act="set_ss";
	$main=&list_sn($sel_year,$sel_seme,$class_id,"",$ss_id,$act);
}elseif($act=="�[�ݸ`�ƳW����" && $class_id){
	$main=&list_sn($sel_year,$sel_seme,$class_id,"view",$ss_id,$act);
}elseif($act=="fast_copy"){
	fast_copy($sel_year,$sel_seme,$class_id);
	header("location: {$_SERVER['PHP_SELF']}?sel_year=$sel_year&sel_seme=$sel_seme&act=set_ss&class_id=$class_id");
}else{
	$main=&sn_form($sel_year,$sel_seme,$class_id);
}


//�q�X����
head("�`�Ƴ]�w");
echo $main;
foot();

//�禡��

//�򥻳]�w���
function &sn_form($sel_year,$sel_seme,$class_id=""){
	global $school_menu_p;
	//�����\���
	$tool_bar=&make_menu($school_menu_p);

	//����
	$help_text="
	�п�ܱ��]�w���y�Ǧ~�סz�B�y�Ǵ��z�B�y�Z�šz�C||
	<span class='like_button'>�}�l�]�w</span> �N�O�}�l�]�w�ӯZ�Ū��`�ƳW����C||
	<span class='like_button'>�[�ݸ`�ƳW����</span> �|�C�X�ӯZ�ŸӾǴ����`�ƳW����C
	";
	$help=&help($help_text);

	//���o�~�׻P�Ǵ����U�Կ��
	$date_select=&class_ok_setup_year($sel_year,$sel_seme,"year_seme","jumpMenu");
	
	//�~�ŻP�Z�ſ��
	$class_select=&get_class_select($sel_year,$sel_seme,"","class_id","",$class_id,"","�п�ܯZ��");
	
	$main="
	<script language='JavaScript'>
	function jumpMenu(){
		if(document.myform.year_seme.options[document.myform.year_seme.selectedIndex].value!=''){
			location=\"{$_SERVER['PHP_SELF']}?act=$act&year_seme=\" + document.myform.year_seme.options[document.myform.year_seme.selectedIndex].value;
		}
	}
	
	</script>
	$tool_bar
	<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4>
	<tr bgcolor='#FFFFFF'><td>
		<table>
		<form action='{$_SERVER['PHP_SELF']}' method='post' name='myform'>
  		<tr><td>�п�ܱ��]�w���Ǧ~�סG</td><td>$date_select</td></tr>
		<tr><td>�п�ܱ��]�w���Z�šG</td><td>$class_select</td></tr>
		<tr><td colspan='2'><input type='submit' name='act' value='�}�l�]�w' class='b1'>
		<input type='submit' name='act' value='�[�ݸ`�ƳW����' class='b1'>
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


//�q�X�Ҧ��ҵ{�A$mode=view�]�u���@�Ӫ�A�L�s�W�έק�u��^�Bclear_view�]�u�����Ӫ�A�s�s���u�㳣���n�^
function &list_sn($sel_year,$sel_seme,$class_id="",$mode="",$id=0,$act=""){
	global $CONN,$school_kind_name,$school_menu_p;

	//�~�ŻP�Z�ſ��
	$class_select=&get_class_select($sel_year,$sel_seme,$Cyear,"class_id","jumpMenu1",$class_id,"","�п�ܯZ��");
	$class_name_arr = class_base();
	$c=explode("_",$class_id);
	$class_num=intval($c[2]).$c[3];
	$class_name=$class_name_arr[$class_num];
	
	//��X�Ӫ��Ҧ����~�׻P�Ǵ��A�n���ӧ@���
	$other_link="act=$act&class_id=$class_id";
	$tmp=&get_ss_year($sel_year,$sel_seme,$other_link);
	$other_ss_text=($mode=="clear_view")?"":$tmp;

	//���o�~��
	$Cyear=intval(substr($class_id,6,2));

	//���X�Ӧ~�ũίZ�šB�ӾǦ~�B�ӾǴ��������þǬ�A$ssid[$i][ss_id]�A$ssid[$i][scope_id]�A$ssid[$i][subject_id]
	$ssid=&get_all_ss($sel_year,$sel_seme,"",$class_id);
	if (count($ssid)==0) {
		$ssid=&get_all_ss($sel_year,$sel_seme,$Cyear,"");
	}
	$cy=($Cyear=="")?$cy:$Cyear;
	if (count($ssid)>0) {
		$query = "select performance_test_times,test_ratio,score_mode from score_setup where year='$sel_year' and semester='$sel_seme' and class_year='$cy' and enable='1'";
		$res = $CONN->Execute($query);
		$performance_test_times=$res->fields['performance_test_times'];
		$test_ratio=$res->fields['test_ratio'];
		$score_mode=$res->fields['score_mode'];
		$query = "select * from course_table where year='$sel_year' and semester='$sel_seme' and class_id='$class_id'";
		$res = $CONN->Execute($query);
		if ($res)
			while (!$res->EOF) {
				$ss_id=$res->fields['ss_id'];
				$course_name[$ss_id]=$res->fields['course_name'];
				$sections[$ss_id]=$res->fields['sections'];
				$test_times[$ss_id]=$res->fields['test_times'];
				$ratio[$ss_id]=$res->fields['test_ratio'];
				$smode[$ss_id]=$res->fields['score_mode'];
				$dmode[$ss_id]=$res->fields['display_mode'];
				$have_data[$ss_id]=1;
				$res->MoveNext();
			}
		$query = "select ss_id,count(ss_id) from score_course where year='$sel_year' and semester='$sel_seme' and class_id='$class_id' group by ss_id";
		$res = $CONN->Execute($query);
		while (!$res->EOF) {
			$ss_id=$res->fields['ss_id'];
			if ($sections[$ss_id]==0) $sections[$ss_id]=$res->fields[1];
			$res->MoveNext();
		}
	}
	
	//�Ҧ���ت��ƶq
	$ss_id_n=sizeof($ssid);
	
	//�s����s
	$edit_button=($mode=="")?"":"<tr><td><input type='button' value='�i��s��' onclick=\"window.location.href='{$_SERVER['PHP_SELF']}?act=set_ss&sel_year=$sel_year&sel_seme=$sel_seme&class_id=$class_id'\" class='b1'></td></tr>";

	//�ֳt�ƻs�Z�ſ��
	$query = "select class_id,c_name from school_class where year='$sel_year' and semester='$sel_seme' and c_year='$Cyear'";
	$res = $CONN->Execute($query);
	$copy_menu="
		<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=1 class='small'>
		<tbody bgcolor='#E1ECFF'><tr><td align='center'>�N�]�w�ƻs��</td></tr>";
	while (!$res->EOF) {
		$cid=$res->fields['class_id'];
		$cname=$res->fields['c_name'];
		if ($class_id != $cid) {
			$checked=($cls[$cid])?"checked":"";
			$copy_menu.="<tr bgcolor='white'><td><input type='checkbox' name='cls[".$cid."]' $checked>".$school_kind_name[$Cyear].$cname."�Z</td></tr>";
		}
		$res->MoveNext();
	}
	$copy_menu.="</tbody></table>";

	//�ֳt�ƻs���s
	$fast_copy_button=($mode=="")?"
	<tr><td align='center'><form action='{$_SERVER['PHP_SELF']}' method='post'>
	<input type='button' value='�ֳt�ƻs' onclick=\"this.form.submit();\" class='b1'><br>$copy_menu
	<input type='hidden' name='sel_year' value='$sel_year'>
	<input type='hidden' name='sel_seme' value='$sel_seme'>
	<input type='hidden' name='class_id' value='$class_id'>
	<input type='hidden' name='act' value='fast_copy'>
	</form></td></tr>
	":"";

	//���s��
	$button="<table cellspacing=1 cellpadding=0 border='0' align='center'>
	$edit_button
	$fast_copy_button
	</table>";

	//�Ҧ���ت��ƶq
	$ss_id_n=sizeof($ssid);
	for($i=0;$i<$ss_id_n;$i++){
		$ss_id=$ssid[$i][ss_id];
		$scope_id=$ssid[$i][scope_id];
		$subject_id=$ssid[$i][subject_id];
		$need_exam=$ssid[$i][need_exam];
		$subject_name=(empty($subject_id))?get_subject_name($scope_id):get_subject_name($subject_id);
		$subject_print=$ssid[$i]['print'];
		if ($test_times[$ss_id]=="") $test_times[$ss_id]=0;
		
		$td="<td align='left' nowrap><font color='#000088'>$subject_name</font></td>";
		
		//�\���]�Y�O�[�ݪ��A�A�h���q�X���^
		if ($mode=="view" or $mode=="clear_view") {
			$modify_tool="";
		} elseif ($have_data[$ss_id]==1) {
			$modify_tool="<td class='small' rowspan='2' nowrap>
			<a href='{$_SERVER['PHP_SELF']}?act=modify_exam&sel_year=$sel_year&sel_seme=$sel_seme&ss_id=$ss_id&class_id=$class_id'>
			<img src='images/edit.png' border=0 hspace=3>�ק�</a>
			<a href=\"javascript:func($ss_id);\">
			<img src='images/del.png' border=0 hspace=3>�R��</a>";
			if ($course_name[$ss_id]=="") $modify_tool.="<a href='{$_SERVER['PHP_SELF']}?act=copy_name&sel_year=$sel_year&sel_seme=$sel_seme&ss_id=$ss_id&class_id=$class_id&course_name=$subject_name'>
			<img src='images/paste.png' border=0 hspace=3>�ƻs�ҵ{�W��</a>";
		} else {
			$modify_tool="<td class='small' nowrap>
			<a href='{$_SERVER['PHP_SELF']}?act=add&sel_year=$sel_year&sel_seme=$sel_seme&ss_id=$ss_id&class_id=$class_id'>
			<img src='images/edit.png' border=0 hspace=3>�[�J���ҵ{</a></td>";
		}

		//�ݭn�p�������p
		if($need_exam=='1'){
			$checked="checked";
			$exam_pic="<img src='images/ok.png' width=16 height=14 border=0>";
		}else{
			$checked="";
			$exam_pic="";
			$rate="";
		}
		
		//�ݭn�����J���Z�����p
		if($subject_print=='1'){
			$print_checked="checked";
			$print_pic="<img src='images/ok.png' width=16 height=14 border=0>";
		}else{
			$print_checked="";
			$print_pic="";
		}

		//���X�Ҹդ��
		$ratio_menu="";
		$all_ratio=0;
		if ($subject_print=='1') {
			if ($ratio[$ss_id]!="") {
				$t=explode(",",$ratio[$ss_id]);
				$m=($smode[$ss_id]=="all")?1:$test_times[$ss_id];
				for ($j=0;$j<$m;$j++) if ($t[$j]=="") $t[$j]="0-0";
				$ratio[$ss_id]="";
				while (list($k,$v)=each($t)){
					if ($k<$test_times[$ss_id]) {
						$ratio[$ss_id].=($smode[$ss_id]=="severally")?"(".($k+1).")".$v."<br>":$v;
						$vv=explode("-",$v);
						$ratio_menu.="<input type='text' name='rs[".($k+1)."]' value='".$vv[0]."' size='3'>-<input type='text' name='rn[".($k+1)."]' value='".$vv[1]."' size='3'><br>\n";
						$all_ratio+=intval($vv[0])+intval($vv[1]);
					}
				}
			}
		} else {
			$test_times[$ss_id]="";
			$ratio[$ss_id]="";
		}
		$rocolor=($all_ratio!=100 && $ratio_menu)?"bgcolor='#ff0000'":"";

		//��ҼҦ�
		$score_msg="";
		$sd_1="";
		$sd_2="";
		$mode_menu="";
		if ($subject_print=='1') {
			if ($smode[$ss_id]=="all") {
				$score_msg="�C���q�ۦP";
				$sd_1="selected";
			} else {
				$score_msg="�C���q���P";
				$sd_2="selected";
			}
			$mode_menu="<select name='input_score_mode'><option value='all' $sd_1>�C���q�ۦP</option><option value='severally' $sd_2>�C���q���P</option></select>";
		}

		//��ܼҦ�
		$dd_1="";
		$dd_2="";
		if ($dmode[$ss_id]==0) {
			if ($course_name[$ss_id]!="") {
				$display_msg=$class_name.$course_name[$ss_id];
			} else {
				$display_msg="�|���]�w�ҵ{�W";
			}
			$dd_1="selected";
		} else {
			$display_msg=$course_name[$ss_id];
			$dd_2="selected";
		}
		$display_menu="<select name='input_display_mode'><option value='0' $dd_1>�Z��+�ҵ{�W</option><option value='1' $dd_2>�ҵ{�W</option></select>";

		//��إD�n���e
		$r=($have_data[$ss_id]==1)?"rowspan='2'":"";
		$sss=($have_data[$ss_id]==1)?"
			<td align='left' class='small' $r nowrap>$display_msg
			<td align='center' $r>$exam_pic</td>
			<td align='center' $r>$print_pic</td>
			<td nowrap align='center' $r>
			<font color='#A23B32' face='arial'>".$sections[$ss_id]."</font></td>
			<td nowrap align='center' $r>
			<font color='#A7C0EF' face='arial'>".$test_times[$ss_id]."</font></td>
			<td align='center' class='small' $r nowrap>$score_msg
			<td align='center' class='small' $r nowrap $rocolor>".$ratio[$ss_id]."
			</td>
		":"
			<td align='center' colspan='7'><font color='#A23B32' face='arial'>���ҵ{�i�����]�w���|���]�w</font></td>
		";

		//��ܽҵ{�W
		if ($course_name[$ss_id]=="") {
			$print_course_name="�|���]�w";
		} else {
			$print_course_name=$course_name[$ss_id];
		}
		if ($have_data[$ss_id]==1) {
			$td2=($act=="modify_exam" && $ss_id==$id)?"<td align='left'><input type='text' name='input_course_name' value='$course_name[$ss_id]' size='14'></td></form>":"<td align='left'>$print_course_name</td>";
		} else {
			$td2="";
		}

		//���㤺�e
		$ss.=($act=="modify_exam" && $ss_id==$id)?"
		<tr bgcolor='white'>
		<form action='{$_SERVER['PHP_SELF']}' method='post'>
			$td
			<td align='center' $r>$display_menu</td>
			<td align='center' $r>$exam_pic</td>
			<td align='center' $r>$print_pic</td>
			<td align='center' $r><input type='text' name='input_sections' value='$sections[$ss_id]' size='1'></td>
			<td align='center' $r><input type='text' name='input_test_times' value='$test_times[$ss_id]' size='1'></td>
			<td align='center' $r>$mode_menu</td>
			<td align='center' $r $rocolor>$ratio_menu</td>
			<td class='small' $r>
			<input type='hidden' name='ss_id' value='$ss_id'>
			<input type='hidden' name='sel_year' value='$sel_year'>
			<input type='hidden' name='sel_seme' value='$sel_seme'>
			<input type='hidden' name='class_id' value='$class_id'>
			<input type='submit' name='act' value='�x�s�]�w' class='b1'>
			</td>
		</tr>
		":"
		<tr bgcolor='white'>
			$td
			$sss
			$modify_tool
		</tr>
		";
		if (!empty($td2)) $ss.="<tr bgcolor='white'>$td2</tr>";
	}

	$semester_name=($sel_seme=='2')?"�U":"�W";
	
	//�\���]�Y�O�[�ݪ��A�A�h���q�X���^
	$modify_tool_title=($mode=="view" or $mode=="clear_view")?"":"<td align='center' rowspan='2'>�\��</td>";

	$ss_table="
	<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4 class='small'>
	<form action='{$_SERVER['PHP_SELF']}' method='post' name='myform'>
	<tr><td colspan='9' align='center' bgcolor='#E1ECFF'>
	<font color='#607387'>
	<font color='#000000'>$sel_year</font> �Ǧ~
	<font color='#000000'>$semester_name</font>�Ǵ�
	$class_select �`�Ƴ]�w��
	</font>
	</td></tr>
	</form>
	<tbody>
	<tr bgcolor='#E1ECFF'>
		<td align='center' nowrap>���</td>
		<td align='center' rowspan='2' nowrap>������</td>
		<td align='center' rowspan='2' nowrap>�p��</td>
		<td align='center' rowspan='2' nowrap>����</td>
		<td align='center' rowspan='2' nowrap>�C�g<br>�`��</td>
		<td align='center' rowspan='2' nowrap>�w��<br>����</td>
		<td align='center' rowspan='2' nowrap>�t���Ҧ�</td>
		<td align='center' rowspan='2' nowrap>�t�����<br>(�w��-����)</td>
		$modify_tool_title
	</tr>
	<tr bgcolor='#E1ECFF'>
		<td align='center' nowrap>�ҵ{�W��</td>
	</tr>
	$ss
	</tbody>
	</table>";

	//�����\���
	$tool_bar = ($mode=="clear_view")?"":make_menu($school_menu_p);

	if($Cyear=="" and $class_id="")$button="";

	//�D�n�q�X�e��
	$main="
	<script language='JavaScript'>
	function func(ss_id){
		var sure = window.confirm('�T�w�n�R���H');
		if (!sure) {
			return;
		}
		location.href=\"{$_SERVER['PHP_SELF']}?act=del&sel_year=$sel_year&sel_seme=$sel_seme&Cyear=$Cyear&class_id=$class_id&ss_id=\" + ss_id;
	}

	function jumpMenu(){
		var dd, classstr ;
		location=\"{$_SERVER['PHP_SELF']}?act=set_ss&sel_year=$sel_year&sel_seme=$sel_seme&Cyear=\" + document.myform.Cyear.options[document.myform.Cyear.selectedIndex].value;
	}
	
	function jumpMenu1(){
		var dd, classstr ;
		if ((document.myform.class_id.options[document.myform.class_id.selectedIndex].value!='')) {
			location=\"{$_SERVER['PHP_SELF']}?act=set_ss&sel_year=$sel_year&sel_seme=$sel_seme&Cyear=$Cyear&class_id=\" + document.myform.class_id.options[document.myform.class_id.selectedIndex].value;
		}
	}
	</script>
	$tool_bar
	<table cellspacing=0 cellpadding=0 border='0'>
	<tr>
	<td valign='top'>$ss_table</td>
	<td width='5'></td>
	<td valign='top'>
	$add_form
	$button
	</td>
	<td width='5'></td>
	<td valign='top'>$other_ss_text</td>
	</tr>
	</table>
	";
	return $main;
}


//�ֳt�ƻs����
function fast_copy($sel_year,$sel_seme,$class_id){
	global $CONN,$cls;
	//�����\���
	$query = "select * from course_table where year='$sel_year' and semester='$sel_seme' and class_id='$class_id'";
	$res = $CONN->Execute($query) or trigger_error("SQL�y�k���楢�ѡASQL�y�k�p�U�G $query", E_USER_ERROR);
	while (!$res->EOF) {
		$ss_id[]=$res->fields['ss_id'];
		$course_name[]=$res->fields['course_name'];
		$test_ratio[]=$res->fields['test_ratio'];
		$sections[]=$res->fields['sections'];
		$test_times[]=$res->fields['test_times'];
		$score_mode[]=$res->fields['score_mode'];
		$display_mode[]=$res->fields['display_mode'];
		$res->MoveNext();
	}
	$query = "select class_id,ss_id from course_table where year='$sel_year' and semester='$sel_seme'";
	$res = $CONN->Execute($query) or trigger_error("SQL�y�k���楢�ѡASQL�y�k�p�U�G $query", E_USER_ERROR);
	while (!$res->EOF) {
		$chk_data[$res->fields['class_id']][$res->fields['ss_id']]=1;
		$res->MoveNext();
	}
	$ci=explode("_",$class_id);
	$Cyear=intval($ci[2]);
	$query = "select class_id from school_class where year='$sel_year' and semester='$sel_seme' and c_year='$Cyear'";
	$res = $CONN->Execute($query) or trigger_error("SQL�y�k���楢�ѡASQL�y�k�p�U�G $query", E_USER_ERROR);
	while (!$res->EOF) {
		$cs=$res->fields['class_id'];
		if ($cls[$cs]) $cid[]=$cs;
		$res->MoveNext();
	}
	while (list($k,$v)=each($ss_id)) {
		reset($cid);
		while (list($i,$c)=each($cid)) {
			if ($chk_data[$c][$v]==1) {
				$query = "update course_table set course_name='$course_name[$k]',test_ratio='$test_ratio[$k]',sections='$sections[$k]',test_times='$test_times[$k]',score_mode='$score_mode[$k]',display_mode='$display_mode[$k]' where class_id='$c' and ss_id='$v'";
			} else {
				$query = "insert into course_table (class_id,ss_id,course_name,test_ratio,sections,test_times,score_mode,display_mode,year,semester) values ('$c','$v','$course_name[$k]','$test_ratio[$k]','$sections[$k]','$test_times[$k]','$score_mode[$k]','$display_mode[$k]','$sel_year','$sel_seme')";
			}
			$CONN->Execute($query) or trigger_error("SQL�y�k���楢�ѡASQL�y�k�p�U�G $query", E_USER_ERROR);
		}
	}
	return;
}

//�[�J�@���`�Ƴ]�w
function add_sn($ss_id,$sel_year,$sel_seme,$class_id){
	global $CONN;
	$query = "select * from score_ss where ss_id='$ss_id'";
	$res = $CONN->Execute($query);
	$print=$res->fields['print'];
	if ($print==1) {
		$c=explode("_",$class_id);
		$class_year=intval($c[2]);
		$query = "select * from score_setup where year='$sel_year' and semester='$sel_seme' and class_year='$class_year' and enable='1'";
		$res = $CONN->Execute($query);
		$score_mode=$res->fields['score_mode'];
		$test_ratio=$res->fields['test_ratio'];
		$test_times=$res->fields['performance_test_times'];
	}
	$sql_insert = "insert into course_table (class_id,ss_id,course_name,test_ratio,sections,test_times,year,semester,score_mode) values ('$class_id','$ss_id','$course_name','$test_ratio','0','$test_times','$sel_year','$sel_seme','$score_mode')";
	if($CONN->Execute($sql_insert))		return true;
	return  false;
}

//��s�ҵ{�W��
function update_course_name($ss_id,$sel_year,$sel_seme,$class_id,$course_name){
	global $CONN;
	$sql_update = "update course_table set course_name='$course_name' where class_id='$class_id' and ss_id = '$ss_id'";
	if($CONN->Execute($sql_update))		return true;
	return  false;
}

//��s�@���`�Ƴ]�w
function update_section_set($ss_id="",$sel_year="",$sel_seme="",$class_id=""){
	global $CONN,$input_course_name,$input_sections,$input_test_times,$rs,$rn,$input_score_mode,$input_display_mode;

	if ($input_score_mode=="severally") {
		while (list($k,$v)=each($rs)) {
			$test_ratio.=$rs[$k]."-".$rn[$k].",";
		}
	} else {
		$test_ratio=$rs[1]."-".$rn[1].",";
	}
	$test_ratio=substr($test_ratio,0,-1);
	$query = "select * from course_table where year='$sel_year' and semester='$sel_seme' and ss_id='$ss_id' and class_id='$class_id'";
	$res = $CONN->Execute($query) or trigger_error("SQL�y�k���楢�ѡASQL�y�k�p�U�G $query", E_USER_ERROR);
	$course_id=$res->fields['course_id'];
	if (!empty($course_id))
		$query = "update course_table set course_name='$input_course_name',test_ratio='$test_ratio',sections='$input_sections',test_times='$input_test_times',score_mode='$input_score_mode',display_mode='$input_display_mode' where course_id='$course_id'";
	else
		$query = "insert into course_table (class_id,ss_id,course_name,test_ratio,sections,test_times,year,semester,score_mode,display_mode) values ('$class_id','$ss_id','$input_course_name','$test_ratio','$input_sections','$input_test_times','$sel_year','$sel_seme','$input_score_mode','$input_display_mode')";
	$CONN->Execute($query) or trigger_error("SQL�y�k���楢�ѡASQL�y�k�p�U�G $query", E_USER_ERROR);

	return false;
}

//�R���ҵ{
function del_sn($class_id,$ss_id){
	global $CONN,$sel_year,$sel_seme;
	$sql_update = "delete from course_table where year='$sel_year' and semester='$sel_seme' and class_id='$class_id' and ss_id = '$ss_id'";
	if($CONN->Execute($sql_update))		return true;
	return  false;
}
?>
