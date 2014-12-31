<?php

// $Id: write_memo.php 7727 2013-10-28 08:26:17Z smallduh $
include "config.php";
include_once "../../include2/sfs_case_PLlib.php";
sfs_check();

if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�

//���o���ЯZ�ťN��
$class_num=get_teach_class();
$class_all=class_num_2_all($class_num);
//���o���Ь��
$query = "select ss_id,class_id from score_course where year='$sel_year' and semester='$sel_seme' and teacher_sn='$_SESSION[session_tea_sn]'";
$res=$CONN->Execute($query) or trigger_error("Ū�����Ǵ����Ь�ؿ��~",E_USER_ERROR);
$ss_id_array=array();
while(! $res->EOF) {
	$ss_id=$res->fields[ss_id];
	$ss_id_array[$ss_id]=$res->fields[class_id];
	$res->MoveNext();
}

if(empty($class_num)){
	$act="error";
	$error_title="�L�Z�Žs��";
	$error_main="�䤣��z���Z�Žs���A�G�z�L�k�ϥΦ��\��C<ol>
	<li>�нT�{�z�����ЯZ�šC
	<li>�нT�{�аȳB�w�g�N�z�����и�ƿ�J�t�Τ��C
	</ol>";
}elseif($error==1){
	$act="error";
	$error_title="�ӯZ�ŵL�ǥ͸��";
	$error_main="�䤣��z���Z�žǥ͡A�G�z�L�k�ϥΦ��\��C<ol>
	<li>�нT�{�z�����ЯZ�šC
	<li>�нT�{�аȳB�w�g�N�z���ǥ͸�ƿ�J�t�Τ��C
	<li>�פJ�ǥ͸�ơG�y�ǰȨt�έ���>�а�>���U��>�פJ��ơz(<a href='".$SFS_PATH_HTML."school_affairs/student_reg/create_data/mstudent2.php'>".$SFS_PATH_HTML."school_affairs/student_reg/create_data/mstudent2.php</a>)</ol>";
}

if($_POST[act]=="�s��"){
	//�g�J�e�w���i�� < > ' " &�r������  �קKHTML�S��r���y����ܩ�sxw������~
	$char_replace=array("<"=>"��",">"=>"��","'"=>"��","\""=>"��","&"=>"��");
	
	$sss_id_arr = explode(",",$_POST[temp_sss_id]);
	$ss_id_arr = explode(",",$_POST[temp_ss_id]);
	$seme_year_seme = sprintf("%03d%d",$_POST[sel_year],$_POST[sel_seme]);
	reset($sss_id_arr);
	while(list($id,$val) = each($sss_id_arr)){
		if($ss_id_array[$ss_id_arr[$id]])
		if ($val<>''){
			$temp_val ="C_$val";
			$ss_score_memo_val = $_POST[$temp_val];
			foreach($char_replace as $key=>$value)	$ss_score_memo_val=str_replace($key,$value,$ss_score_memo_val);
			$query = "update stud_seme_score set ss_score_memo = '$ss_score_memo_val',teacher_sn='$_SESSION[session_tea_sn]'  where sss_id='$val'";
			$CONN->Execute($query) or trigger_error("SQL ���~",E_USER_ERROR);
		}
	}

	reset($ss_id_arr);
	while(list($id,$val) = each($ss_id_arr)){
		if($ss_id_array[$ss_id_arr[$id]])
		if ($val<>''){
			$query = "replace into stud_seme_score_oth (seme_year_seme,stud_id,ss_kind,ss_id,ss_val)values('$seme_year_seme','$_POST[stud_id]','�V�O�{��','$val','".$_POST["aa_$val"]."')";
			$CONN->Execute($query) or trigger_error("sql ���~ $query",E_USER_ERROR);
		}
	}
}



$class_id=old_class_2_new_id($class_num,$sel_year,$sel_seme);
//�ഫ�Z�ťN�X
 $class=class_id_2_old($class_id);


//���p�S�����w�ǥ͡A���o�Ĥ@��ǥ�
if(empty($_POST[stud_id]))$stud_id=get_no1($class_id);else $stud_id = $_POST[stud_id];

//�Y���O�S��$stud_id�A�h�q�X���~�T��
if(empty($stud_id))header("location:{$_SERVER['PHP_SELF']}?error=1");
	
if ($_POST[chknext] && $_POST[nav_next]<>'')	$stud_id = $_POST[nav_next];

//�ǥͿ��
//$stud_select=get_stud_select($class_id,$stud_id,"stud_id","jumpMenu");
$gridBgcolor="#DDDDDC";

$grid1 = new ado_grid_menu($_SERVER['PHP_SELF'],$URI,$CONN);  //�إ߿��	   	
$grid1->key_item = "stud_id";  // ������W  	
$grid1->display_item = array("sit_num","stud_name");  // �����W   
$grid1->bgcolor = $gridBgcolor;
$grid1->display_color = array("1"=>"blue","2"=>"red");
$grid1->color_index_item ="stud_sex" ; //�C��P�_��
$grid1->class_ccs = " class=leftmenu";  // �C�����
$grid1->sql_str = "select stud_id,stud_name,stud_sex,substring(curr_class_num,4,2)as sit_num  from stud_base where curr_class_num like '$class[2]%' and stud_study_cond=0 order by curr_class_num";   //SQL �R�O
	$grid1->do_query(); //����R�O 
//	echo $grid1->sql_str;exit;

//�D�o�ǥ�ID	
$student_sn=stud_id2student_sn($stud_id);

//���o���w�ǥ͸��
$stu=get_stud_base("",$stud_id);

//�y��
$stu_class_num=curr_class_num2_data($stu['curr_class_num']);
	
//���o�Ǯո��
$s=get_school_base();


$tool_bar=&make_menu($school_menu_p);


//�� Grid 
$stud_select = $grid1->get_grid_str($stud_id,$upstr,$downstr); // ��ܵe��

//����ئW��
$query = "select subject_id,subject_name,subject_kind from score_subject ";
$res = $CONN->Execute($query);
while(!$res->EOF) {
	if ($res->fields[2] == 'scope')
		$score_arr[$res->fields[0]] = $res->fields[1];
	else
		$subject_arr[$res->fields[0]] = $res->fields[1];
		
	$res->MoveNext();
}

$class_year = substr($class_num,0,-2);
$query = "select ss_id,scope_id,subject_id from score_ss where enable='1' and year='$sel_year' and semester='$sel_seme' and class_year='$class_year' and need_exam=1 and enable=1 order by scope_id,subject_id";

$res = $CONN->Execute($query) or trigger_error("SQL ���O���~",E_USER_ERROR);
while(!$res->EOF) {
	$temp_score_name = $score_arr[$res->fields[scope_id]];
	if ($res->fields[subject_id]>0)
		$temp_score_name .="-".$temp_subject_name = $subject_arr[$res->fields[subject_id]];
	
	$curr_score_ss_arr[$res->fields[ss_id]] = $temp_score_name;
	$res->MoveNext();
}

$seme_year_seme = sprintf("%03d%d",$sel_year,$sel_seme);
//�P�O�O�_�����Z�ҵ{
$query = "select ss_id from score_ss where class_id='$class_id'";
$res = &$CONN->Execute($query);
if ($res->EOF)
	$query = "select  a.sss_id , a.student_sn, a.ss_id , a.ss_score,a.ss_score_memo from stud_seme_score a,score_ss b where a.ss_id=b.ss_id and b.class_id='' and a.student_sn='$student_sn' and a.seme_year_seme='$seme_year_seme' order by b.scope_id,b.subject_id";
else
	$query = "select  a.sss_id , a.student_sn, a.ss_id , a.ss_score,a.ss_score_memo from stud_seme_score a,score_ss b where a.ss_id=b.ss_id and b.class_id='$class_id' and a.student_sn='$student_sn' and a.seme_year_seme='$seme_year_seme' order by b.scope_id,b.subject_id";

$res = $CONN->Execute($query) or trigger_error("SQL ���O���~", E_USER_ERROR);

$html ="<table bgcolor=\"#9ebcdd\" cellspacing=\"1\" cellpadding=\"4\" width=\"100%\">
	<tr bgcolor=\"#c4d9ff\">
	<td>���</td>
	<td>�Ǵ�����</td>
	<td>�V�O�{��</td>
	<td>�ǲߴy�z��r</td>
	</tr>
";
$temp_sss_id = '';
// ���o�V�O�{�פ�r�ԭz
$arr_1 = sfs_text("�V�O�{��");
// ���o�ǥͧV�O�{�׭�
$oth_data=&get_oth_value($stud_id,$sel_year,$sel_seme,"�V�O�{��");

$sel1 = new drop_select();
$sel1->use_val_as_key = true;
while(!$res->EOF) {
	$sss_id = $res->fields[sss_id];
	$ss_score_memo = $res->fields[ss_score_memo];
	$ss_score= intval($res->fields[ss_score]);
	$ss_id = $res->fields[ss_id];
	$sel1->s_name = "aa_$ss_id";
	$sel1->id = $oth_data["$ss_id"];
	$sel1->arr= $arr_1;
	$temp_sel = $sel1->get_select();

	$C = "C".$sss_id;
	$Cs = "C".$sss_id."s";
	if (in_array($ss_id,array_keys($curr_score_ss_arr))) {
		//�p�G�O���нҵ{ �h�i�H�ק�  �_�h�ȶi�����
		if($ss_id_array[$ss_id])
			$html .= "<tr bgcolor='#FFDDDD'><td>$curr_score_ss_arr[$ss_id]</td><td align=center>$ss_score</td><td>$temp_sel</td><td><img src='$SFS_PATH_HTML"."images/comment.png' width=16 height=16 border=0 align='left' name='$Cs' value='$Cs' onClick=\"return OpenWindow('$C')\"><textarea name='C_$sss_id' id='$C' style='width: 100%;height: 100%'>$ss_score_memo</textarea></td></tr>\n";
		else $html .= "<tr bgcolor='white'><td>$curr_score_ss_arr[$ss_id]</td><td align=center>$ss_score</td><td>{$oth_data[$ss_id]}</td><td>$ss_score_memo</td></tr>\n";
		$temp_ss_id .= $ss_id.",";
		$temp_sss_id .= $sss_id.",";
	}
	$res->MoveNext();
}
$html .="<input type='hidden' name='temp_sss_id' value='$temp_sss_id'>";
$html .="<input type='hidden' name='temp_ss_id' value='$temp_ss_id'>";
$html .="</table>\n";

$checked=($_POST[chknext])?"checked":"";
$main="
	<script language=\"JavaScript\">
	var remote=null;
	function OpenWindow(p,x){
	strFeatures =\"top=10,left=20,width=500,height=200,toolbar=0,resizable=yes,scrollbars=yes,status=0\";
	remote = window.open(\"comment.php?cq=\"+p,\"MyNew\", strFeatures);
	if (remote != null) {
	if (remote.opener == null)
	remote.opener = self;
	}
	if (x == 1) { return remote; }
	}
	function checkok() {
	document.col1.nav_next.value = document.gridform.nav_next.value;	
	return true;	
	}
	
	</script>
	$tool_bar
	<table bgcolor='#DFDFDF' cellspacing=1 cellpadding=4>
	<tr class='small'><td valign='top'>$stud_select
	
	<form action='{$_SERVER['PHP_SELF']}' method='post' name='col1'>
	<input type='checkbox' name='chknext' value='1' $checked>�۰ʸ��U�@��
	</td><td bgcolor='#FFFFFF' valign='top'>
	<p align='center'>
	<font size=3>".$s[sch_cname]." ".$sel_year."�Ǧ~�ײ�".$sel_seme."�Ǵ�</p>
	<table align=center cellspacing=4>
	<tr>
	<td>�Z�šG<font color='blue'>$class[5]</font></td><td width=40></td>
	<td>�y���G<font color='green'>$stu_class_num[num]</font></td><td width=40></td>
	<td>�m�W�G<font color='red'>$stu[stud_name]</font></td>
	</tr></table></font>
	$html
	<input type='hidden' name='sc_sn' value='$sc_sn'>
	<input type='hidden' name='stud_id' value='$stud_id'>
	<input type='hidden' name='sel_year' value='$sel_year'>
	<input type='hidden' name='sel_seme' value='$sel_seme'>
	<input type='hidden' name='class_id' value='$class_id'>
	<input type='hidden' name='nav_next' ><br><div align='center'>
	<input type='submit' name='act' value='�s��' onClick='return checkok();'>
	</div>
	</form>
	</td></tr></table>
	";

head("�ǲߴy�z��r�s��");
echo $main;
foot();	

?>
