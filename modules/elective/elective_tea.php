<?php
// $Id: elective_tea.php 8509 2015-09-01 15:06:47Z smallduh $

// �ޤJ�z�ۤv�� config.php ��
require "config.php";

// �{��
sfs_check();

//�ഫ�������ܼ�
$act=($_POST['act'])?"{$_POST['act']}":"{$_GET['act']}";
$c_year=($_POST['c_year'])?"{$_POST['c_year']}":"{$_GET['c_year']}";
$ss_id=($_POST['ss_id'])?"{$_POST['ss_id']}":"{$_GET['ss_id']}";
$teacher_sn=($_POST['teacher_sn'])?"{$_POST['teacher_sn']}":"{$_GET['teacher_sn']}";
$course_id=$_REQUEST['course_id'];
$group_name=($_POST['group_name'])?"{$_POST['group_name']}":"{$_GET['group_name']}";
$e_group_name=($_POST['e_group_name'])?"{$_POST['e_group_name']}":"{$_GET['e_group_name']}";
$e_group_id=($_POST['e_group_id'])?"{$_POST['e_group_id']}":"{$_GET['e_group_id']}";
$member=($_POST['member'])?"{$_POST['member']}":"{$_GET['member']}";
$open=($_POST['open'])?"{$_POST['open']}":"{$_GET['open']}";
$TL=($_POST['TL'])?"{$_POST['TL']}":"{$_GET['TL']}";
// �s�� SFS3 �����Y
head("���սҵ{�]�w");

// �z���{���X�Ѧ��}�l
print_menu($menu_p);
$curr_year = curr_year();
$curr_seme = curr_seme();
//�~�ſ��
$sql="select c_year from school_class where year='$curr_year' and semester='$curr_seme' and enable='1' order by c_year ";
$rs=$CONN->Execute($sql) or trigger_error($sql,256);
$i=0;
$ctrl_A=array();
while(!$rs->EOF){
	$c_y[$i]=$rs->fields['c_year'];
	if(!in_array($c_y[$i],$ctrl_A)) array_push($ctrl_A,$c_y[$i]);
	$i++;
	$rs->MoveNext();
}

foreach($ctrl_A as $v){
	if($c_year==$v) $selected=" selected";
	else $selected="";
	$option_c_year.="<option value='$v'$selected>$v �~��</option>\n";
}

$class_selecter="<form action='{$_SERVER[PHP_SELF]}' method='POST'><select name='c_year' onchange='this.form.submit()'>$option_c_year</select></form>\n";

if($c_year=="") { $c_year=$IS_JHORES+1; }

//�~�Ŭ�ؿ��
$class=array($curr_year,$curr_seme,"",$c_year);
$ss_name_arr=&get_ss_name_arr($class,$mode="��");

foreach($ss_name_arr as $kk => $vv){
	$selected=($ss_id==$kk)?"selected":"";
	$option_ss_id.="<option value='$kk' $selected>$vv</option>\n";
}
if($option_ss_id=="") $ss_selecter="���Ǵ����ҵ{�|���]�w";
else $ss_selecter="<form action='{$_SERVER[PHP_SELF]}' method='POST'><input type='hidden' name='c_year' value='$c_year'><select name='ss_id' onchange='this.form.submit()'><option value='0'>��ܽҵ{</option>\n$option_ss_id</select>";
if($ss_id) $ss_selecter.="<a href='elective_stu.php?c_year=$c_year&ss_id=$ss_id'><img src='images/forward.png' border='0'></a>";
$ss_selecter.="</form>\n";
//����ئW��
$subject_arr = get_subject_name_arr();
//���o���Ǵ��Z�Ű}�C
$class_name_arr = class_base();

if($ss_id){//�C�X�Ӭ�ءA���Ѥ��ջP���w���զѮv
	if($TL=="all") $TL_checked=" checked";
	$group_area="<table cellspacing=1 cellpadding=6 border=0 bgcolor='#211BC7' width='100%' align='center'>";
	$group_area.="<tr bgcolor='#FFFFFF'><td>";
	$group_area.="
	<table><tr><td>
	<form action='{$_SERVER[PHP_SELF]}' method='POST' onsubmit='this.form.submit()'>
	<input type='hidden' name='act' value='add_group'>
	<input type='hidden' name='c_year' value='$c_year'>
	<input type='hidden' name='ss_id' value='$ss_id'>
	<input type='hidden' name='TL' value='$TL'>
	<input type='submit' name='new_group' value='�W�[�@�Ӥ���'></form>
	</td>
	<td>
	<form action='{$_SERVER[PHP_SELF]}' method='POST' onsubmit='this.form.submit()'>
	<input type='hidden' name='c_year' value='$c_year'>
	<input type='hidden' name='ss_id' value='$ss_id'>
	<input type='checkbox' name='TL' value='all'$TL_checked onclick='this.form.submit()'>�C�X���զѮv<font size='-1' color='#ff0000'>�i�Y�S�Ŀ�h�u�C�X���Ǧ~�ɮv(�ť��Юv)�αM(��)���Юv�j</font></form>
	</td></tr></table>";
	$new_c_year=($TL=="all")?"":"$c_year";
	if($act=="add_group"){
		//�Ѯv���A�u�C�X�ӾǦ~�Ѯv�P����Ѯv
		$teacher_arr=teacher_fun($new_c_year,$guest="0");
		$teacher_selecter.="<select name='teacher_sn'>";
		$teacher_selecter.="<option value=''>��ܦѮv</option>";
		foreach($teacher_arr as $v){
			$teacher_name_a=get_teacher_name($v);
			$teacher_selecter.="<option value='$v'>$teacher_name_a</option>";
		}
		$teacher_selecter.="</select>";
		$group_area.="<form action='{$_SERVER[PHP_SELF]}' method='POST' onsubmit='this.form.submit()'>
		<input type='hidden' name='act' value='add_group2'>
		<input type='hidden' name='c_year' value='$c_year'>
		<input type='hidden' name='ss_id' value='$ss_id'>
		���զW��<input type='text' name='group_name' size='20'>
		$teacher_selecter
		�̦h�H��<input type='text' name='member' size='6'>
		�}��ۿ�<input type='radio' name='open' value='�O'>�O <input type='radio' checked name='open' value='�_'>�_
		<input type='submit' name='new_group' value='�T�w'></form>";

	}elseif($act=="add_group2"){
		$group_name=trim($group_name);
		$member=trim($member);
		$member=intval($member);
		if($member=="") $member=0;
		//if($open=="") $open=0;
		if($group_name && $teacher_sn){
			//�ˬd�O�_���ƤF
			if(!check_dob($ss_id,$group_name,$teacher_sn)){
				$sql3="insert into elective_tea(group_name,ss_id,teacher_sn,member,open) values('$group_name','$ss_id','$teacher_sn','$member','$open')";
				$CONN->Execute($sql3) or trigger_error($sql3,256);
				//header("Location:{$_SERVER['PHP_SELF']}?c_year=$c_year&ss_id=$ss_id");
			}else{
				$msg="�s�W���ѡA�z�ҳ]�w�����սҵ{�Υ��ұЮv���ФF�I<br>";
			}
		}else{
			$msg="�z�S����J���զW�٩ο�ܥ��ҦѮv<br>";
		}
	}elseif($act=="edit_group2"){
		if($e_group_name && $teacher_sn){
			$e_group_name=trim($e_group_name);
			$member=trim($member);
			$member=intval($member);
			if($member=="") $member=0;
			//�ˬd�O�_���ƤF
			if(!check_dob_upd($e_group_id,$ss_id,$e_group_name,$teacher_sn)){
				$sql4="update elective_tea set group_name='$e_group_name',teacher_sn='$teacher_sn',course_id='$course_id',member='$member', open='$open' where group_id='$e_group_id' and ss_id='$ss_id' ";
				$CONN->Execute($sql4) or trigger_error($sql4,256);
				//header("Location:{$_SERVER['PHP_SELF']}?c_year=$c_year&ss_id=$ss_id");
			}else{
				$msg="�ק異�ѡA�z�ҳ]�w�����սҵ{�Υ��ұЮv���ФF�I<br>";
			}
		}else{
			$msg="�z�S����J���զW�٩ο�ܥ��ҦѮv�I<br>";
		}
	}elseif($act=="del_group"){
		$sql5="delete from elective_tea where group_id='$e_group_id'";
		$CONN->Execute($sql5) or trigger_error($sql5,256);
	}
	$sql2="select * from elective_tea where ss_id='$ss_id' ";
	$rs2=$CONN->Execute($sql2) or trigger_error($sql,256);
	if($rs2->RecordCount( )>=1){//�ܤ֦��@�����սҵ{�~��ܥX��
		$i=0;
		$group_name=array();
		$teacher_sn=array();
		$member=array();
		$open=array();
		$cond.="<table  cellspacing=1 cellpadding=6 border=0 bgcolor='#211BC7'><tr bgcolor='#B6BFFB'><td>���զW��</td><td>���ұЮv</td><td>���N�ҵ{</td><td>�ثe�H�� / �̦h�H��</td><td>�}��ۿ�</td><td colspan='3'>�\����</td></tr>";
		while(!$rs2->EOF){
			$group_id[$i]=$rs2->fields['group_id'];
			$group_name[$i]=$rs2->fields['group_name'];
			$teacher_sn[$i]=$rs2->fields['teacher_sn'];
			$cid=$rs2->fields['course_id'];
			$query_cs="select a.*,b.scope_id,b.subject_id from score_course a,score_ss b where a.ss_id=b.ss_id and a.course_id='$cid'";
			$res_cs=$CONN->Execute($query_cs);
			$sid=$res_cs->fields['subject_id'];
			if ($sid=="0") $sid=$res_cs->fields['scope_id'];
			$course_name[$i]=$class_name_arr[sprintf("%d%02d",$res_cs->fields['class_year'],$res_cs->fields['class_name'])].$subject_arr[$sid][subject_name];
			$member[$i]=$rs2->fields['member'];
			if($member[$i]==0) $member[$i]="����";
			$open[$i]=$rs2->fields['open'];
			if($open[$i]=="�_") $open_ck_0[$i]=" checked";
			elseif($open[$i]=="�O") $open_ck_1[$i]=" checked";
			$teacher_name[$i]=get_teacher_name($teacher_sn[$i]);
			if(($e_group_id==$group_id[$i]) && $act=="edit_group"){
				//�Ѯv���A�u�C�X�ӾǦ~�Ѯv�P����Ѯv
				$teacher_arr=teacher_fun($new_c_year,$guest="0");
				$teacher_selecter.="<select name='teacher_sn'>";
				$teacher_selecter.="<option value=''>��ܦѮv</option>";
				foreach($teacher_arr as $k => $v){
					$teacher_name_a=get_teacher_name($v);
					if($v==$teacher_sn[$i]) {
						$selected2[$k]=" selected";
						$ci=$i;
					}
					$teacher_selecter.="<option value='$v'$selected2[$k]>$teacher_name_a</option>";
				}
				$teacher_selecter.="</select>";
				$course_selecter="<select name='course_id'><option value=''>����ҵ{</option>";
				$query = "select a.course_id,a.class_id,b.scope_id,b.subject_id from score_course a,score_ss b where a.day<>'' and a.ss_id=b.ss_id and b.need_exam=1 and a.year=".curr_year()." and a.semester=".curr_seme()." and a.teacher_sn='$teacher_sn[$ci]' group by a.class_id,b.scope_id,b.subject_id";
				$res = $CONN->Execute($query)or trigger_error($query,E_USER_ERROR);
				while(!$res->EOF){
					$temp_arr = explode("_",$res->fields[class_id]);
					$temp_id = sprintf("%d%02d",$temp_arr[2],$temp_arr[3]);
					$temp_ss_id = $res->fields[subject_id];
					$cs_id = $res->fields[course_id];
					$selected=($cid==$cs_id)?"selected":"";
					if ($res->fields[subject_id]==0)  $temp_ss_id = $res->fields[scope_id];
					$course_selecter.="<option value='".$cs_id."' $selected >".$class_name_arr[$temp_id].$subject_arr[$temp_ss_id][subject_name]."</option>\n";
					$res->MoveNext();
				}
				$course_selecter.="</select>";
				$cond.="<tr bgcolor='#E1E5F5'><td>
				<form action='{$_SERVER['PHP_SELF']}' method='POST' onsubmit='this.form.submit()'>
				<input type='text' name='e_group_name' value='{$group_name[$i]}'></td><td>".$teacher_selecter."</td><td>".$course_selecter."</td><td><input type='text' name='member' value='{$member[$i]}'></td><td nowrap><input type='radio' name='open'$open_ck_1[$i] value='�O'>�O <input type='radio' name='open'$open_ck_0[$i] value='�_'>�_</td>
				<td colspan='3'>
					<input type='hidden' name='act' value='edit_group2'>
					<input type='hidden' name='c_year' value='$c_year'>
					<input type='hidden' name='ss_id' value='$ss_id'>
					<input type='hidden' name='e_group_id' value='$e_group_id'>
					<input type='submit' name='submit' value='�x�s'>
					</form>
				</td></tr>";
			}else{
				//��X�Ӥ��եثe���h�־ǥ�
				$now_mem[$i]=now_mem($group_id[$i]);
				$cond.="<tr bgcolor='#E1E5F5'><td>".$group_name[$i]."</td><td>".$teacher_name[$i]."</td><td>".$course_name[$i]."</td><td align='center'>".$now_mem[$i]." / ".$member[$i]."</td><td>$open[$i]</td>
				<td>
					<form action='{$_SERVER['PHP_SELF']}' method='POST' onsubmit='this.form.submit()'>
					<input type='hidden' name='act' value='edit_group'>
					<input type='hidden' name='c_year' value='$c_year'>
					<input type='hidden' name='ss_id' value='$ss_id'>
					<input type='hidden' name='e_group_id' value='$group_id[$i]'>
					<input type='hidden' name='TL' value='$TL'>
					<input type='submit' name='submit' value='�ק�'>
					</form>
				</td>
				<td>
					<form action='{$_SERVER['PHP_SELF']}' method='POST' onsubmit='this.form.submit()'>
					<input type='hidden' name='act' value='del_group'>
					<input type='hidden' name='c_year' value='$c_year'>
					<input type='hidden' name='ss_id' value='$ss_id'>
					<input type='hidden' name='e_group_id' value='$group_id[$i]'>
					<input type='hidden' name='TL' value='$TL'>
					<input type='submit' name='submit' value='�R��'>
					</form>
				</td>
				<td>
					<form action='elective_stu.php' method='POST' onsubmit='this.form.submit()'>
					<input type='hidden' name='act' value='mag_student'>
					<input type='hidden' name='c_year' value='$c_year'>
					<input type='hidden' name='ss_id' value='$ss_id'>
					<input type='hidden' name='group_id' value='$group_id[$i]'>
					<input type='hidden' name='TL' value='$TL'>
					<input type='submit' name='submit' value='�ǥͳ]�w'>
					</form>
				</td></tr>";
			}
			$i++;
			$rs2->MoveNext();
		}
		$cond.="</table>";
		//$cond.="<br><font color='#FF0000'>�̦h�H�Ƶ��� 0 ��ܤ�����H��</font>";
	}
	$group_area.=$msg.$cond;
	$group_area.="";
	$group_area.="</td></tr></table>";

}

$main="<table align='center' width='99%'><tr><td width='1%' nowrap> $class_selecter</td><td>$ss_selecter</td></tr><tr><td colspan='2'>$group_area</td></tr></table>";
//�]�w�D������ܰϪ��I���C��
$back_ground="
	<table cellspacing=1 cellpadding=6 border=0 bgcolor='#B0C0F8' width='100%'>
		<tr bgcolor='#FFF6BA'>
			<td>
				$main
			</td>
		</tr>
	</table>";
echo $back_ground;

// SFS3 ������
foot();



?>
