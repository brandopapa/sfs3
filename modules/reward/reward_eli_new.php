<?php

// $Id: reward_eli_new.php 5927 2010-04-08 05:40:46Z brucelyc $

/* ���o�]�w�� */
include "config.php";

sfs_check();

//���o�ǻ����
$year_seme=$_REQUEST['year_seme'];
$year_name=$_REQUEST['year_name'];
$class_name=$_POST['class_name'];
$class_num=$_POST['class_num'];
$me=$_REQUEST['me'];
$One=$_POST['One'];
$stud_id=$_REQUEST['stud_id'];
$past_stud_id=$_POST['past_stud_id'];
$class_id=$_POST['class_id'];
$past_class_id=$_POST['past_class_id'];
$reward_sub=$_REQUEST['reward_sub'];
$act=$_POST['act'];
$cancel=$_POST['cancel'];
$ndate=$_POST['ndate'];
if (!$reward_sub) $reward_sub='1';

//�Y����ܾǦ~�Ǵ��A�i����Ψ��o�Ǧ~�ξǴ�
if(!empty($year_seme)){
	$ys=explode("_",$year_seme);
	$sel_year=$ys[0];
	$sel_seme=$ys[1];
} else {
	$sel_year = curr_year(); //�ثe�Ǧ~
	$sel_seme = curr_seme(); //�ثe�Ǵ�
	$year_seme=$sel_year."_".$sel_seme;
}
$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;

if ($past_class_id==$class_id) {
	if ($past_stud_id!=$One && $One!="") $stud_id=$One;
	if ($stud_id!="") {
		if ($past_stud_id==$stud_id) {
			$seme_class=(intval($year_name)+$IS_JHORES).sprintf("%02d",$class_name);
			$seme_num=intval($class_num);
			$query="select * from stud_seme where seme_year_seme='$seme_year_seme' and seme_class='$seme_class' and seme_num='$seme_num'";
			$res=$CONN->Execute($query);
			$stud_id=$res->fields[stud_id];
			$class_id=sprintf("%03d_%d_%02d_%02d",$sel_year,$sel_seme,$year_name+$IS_JHORES,$class_name);
		} else {
			$query="select a.* from stud_seme a,stud_base b where a.seme_year_seme='$seme_year_seme' and a.student_sn=b.student_sn and b.stud_study_cond in ($in_study) and a.stud_id='$stud_id'";
			$res=$CONN->Execute($query);
			$seme_class=$res->fields[seme_class];
			$year_name=intval(substr($seme_class,0,-2))-$IS_JHORES;
			$class_name=intval(substr($seme_class,-2,2));
			$class_num=intval($res->fields[seme_num]);
			$class_id=sprintf("%03d_%d_%02d_%02d",$sel_year,$sel_seme,$year_name+$IS_JHORES,$class_name);
		}
	}
} else {
	$c=explode("_",$class_id);
	$year_name=intval($c[2]);
	$seme_class=$year_name.$c[3];
	$query="select a.* from stud_seme a,stud_base b where a.seme_year_seme='$seme_year_seme' and a.student_sn=b.student_sn and b.stud_study_cond in ($in_study) and seme_class='$seme_class'";
	$res=$CONN->Execute($query);
	$stud_id=$res->fields['stud_id'];
	$seme_class=$res->fields['seme_class'];
	$class_num=intval($res->fields['seme_num']);
	$class_name=intval(substr($seme_class,-2,2));
	$class_num=intval($res->fields[seme_num]);
	$year_name-=$IS_JHORES;
}

//�q�X����
head("�ǥͼ��g�޲z");
print_menu($student_menu_p);

echo "<table border=0 cellspacing=1 cellpadding=2 width=100% bgcolor=#cccccc><tr><td bgcolor='#FFFFFF'>";

switch($act) {
	//�B�z�P�L
	case "cancel":
		while (list($k,$v)=each($cancel))
			if ($v) {
				$sql="update reward set reward_cancel_date='$ndate[$k]',reward_sub='$reward_sub' where stud_id='$stud_id' and reward_id='$k'";
				$rs=$CONN->Execute($sql);
			}
		break;

	//�B�z�P�L���P
	case "recancel":
		while (list($k,$v)=each($cancel))
			if ($v) {
				$sql="update reward set reward_cancel_date='NULL',reward_sub='$reward_sub' where stud_id='$stud_id' and reward_id='$k'";
				$rs=$CONN->Execute($sql);
			}
		break;
}

//�~�ŻP�Z�ſ��
if (empty($class_id)) $class_id=sprintf("%03d_%d_%02d_%02d",$sel_year,$sel_seme,$IS_JHORES+1,1);
if (empty($stud_id)) {
	$query="select a.* from stud_seme a,stud_base b where a.seme_year_seme='$seme_year_seme' and a.student_sn=b.student_sn and b.stud_study_cond in ($in_study) order by a.seme_class,a.seme_num";
	$res=$CONN->Execute($query);
	$stud_id=$res->fields[stud_id];
}
$class_select=&classSelect($sel_year,$sel_seme,"","class_id",$class_id,true);
$stud_select=get_stud_select($class_id,$stud_id,"stud_id","this.form.submit",1);

$main="	$tool_bar
	<table cellspacing='1' cellpadding='3' bgcolor='#C6D7F2'>
	<form action='$_SERVER[PHP_SELF]' method='post'>
	<tr class='title_sbody2'>
	<td>�п�Z�ũM�m�W<td align='left' bgcolor='white' colspan='2'>$class_select $stud_select<input type='hidden' name='past_class_id' value='$class_id'>
	</tr>
	<tr class='title_sbody2'>
	<td>�Ϊ�����J�Ǹ�<td align='left' bgcolor='white' colspan='2'><input type='text' size='10' maxsize='10' name='One' value='$stud_id'><input type='hidden' name='past_stud_id' value='$stud_id'>
	</tr>
	<tr class='title_sbody2'>
	<td>�Ϊ�����J�Z�Ůy��<td align='left' bgcolor='white' colspan='2'><input type='text' size='2' maxsize='2' name='year_name' value='$year_name'> �~�� <input type='text' size='2' maxsize='2' name='class_name' value='$class_name'> �Z <input type='text' size='2' maxsize='2' name='class_num' value='$class_num'> �� <input type='submit' value='�T�w'>
	</tr>
	</form>
	</table>";

if ($stud_id) {
	if ($reward_sub=="1") {
		$re_temp="<td class='tab' bgcolor='#c4d9ff'>&nbsp;���P�L�O��&nbsp;</td><td class='tab' bgcolor='#9ebcdd'>&nbsp;<a href=".$_SERVER['PHP_SELF']."?year_seme=".$year_seme."&year_name=".$year_name."&me=".$me."&stud_id=".$stud_id."&reward_sub=2>�w�P�L�O��</a>&nbsp;</td>";
		$act_str="�P�L";
		$print_temp="";
	} else {
		$re_temp="<td class='tab' bgcolor='#9ebcdd'>&nbsp;<a href=".$_SERVER['PHP_SELF']."?year_seme=".$year_seme."&year_name=".$year_name."&me=".$me."&stud_id=".$stud_id."&reward_sub=1>���P�L�O��&nbsp;</a></td><td class='tab' bgcolor='#c4d9ff'>&nbsp;�w�P�L�O��&nbsp;</td>";
		$act_str="���P";
		$print_temp="<td align='center' width='30'>�C�L</td>";
	}
	$main.="<br><table cellspacing=0 cellpadding=3>
		<form name='form4' method='post' action='{$_SERVER['PHP_SELF']}'>
		<tr>
		$re_temp
		</tr>
		</table>
		<table bgcolor=#ffffff border=0 cellpadding=0 cellspacing=0>
		<tr bgcolor='#ffffff'>
		<td>
		<table bgcolor='#9ebcdd' cellspacing='1' cellpadding='4' class='small'>
		<tr bgcolor='#c4d9ff'>
		<td align='center' width='20'>$act_str</td>
		<td align='center' width='20'>�Ǧ~</td>
		<td align='center' width='20'>�Ǵ�</td>
		<td align='center'>�g�٨ƥ�</td>
		<td align='center' width='30'>�g�����O</td>
		<td align='center'>�g�٨̾�</td>
		<td align='center' width='80'>�g�٥ͮĤ��</td>
		<td align='center' width='80'>�P�L���</td>
		$print_temp
		</tr>
		";
	//�ק�����j�M�~��
	$l_year=$sel_year-$year_name-1;
	$u_year=$l_year+6;
	$l_year_seme=$l_year*10+1;
	$u_year_seme=$u_year*10+2;
	$sql="select * from reward where (reward_year_seme >= $l_year_seme) and (reward_year_seme <= $u_year_seme) and stud_id='$stud_id' and reward_kind < '0' and reward_sub='$reward_sub'";
	$rs=$CONN->Execute($sql);
	$i=0;
	while (!$rs->EOF) {
		$reward_year_seme=$rs->fields['reward_year_seme'];
		$reward_id=$rs->fields['reward_id'];
		$reward_kind=$rs->fields['reward_kind'];
		$reward_date=$rs->fields['reward_date'];
		$reward_reason=addslashes($rs->fields['reward_reason']);
		$reward_base=addslashes($rs->fields['reward_base']);
		$reward_year=substr($reward_year_seme,0,strlen($reward_year_seme)-1);
		$reward_seme=substr($reward_year_seme,-1,1);
		if ($reward_sub==1) {
			$ndate[$reward_id]=date("Y-m-d",mktime (date("m"),date("d"),date("Y")));
			$date_temp="<input type='text' name='ndate[".$reward_id."]' value='".$ndate[$reward_id]."' style='width: 100%'>";
		} else {
			$date_temp=$rs->fields['reward_cancel_date'];
			$print_temp="<td align='center'><a href=\"reward_rep.php?stud_id= $stud_id&reward_id=$reward_id&oo_path=eli\" onClick=\"return confirm('�T�w�C�L�P�L�q����?')\">�q����</a></td>";
		}
		$main.="
			<tr bgcolor='#ffffff'>
			<td align='center'><input type='checkbox' name='cancel[".$reward_id."]' value='1'></td>
			<td align='center'>$reward_year</td>
			<td align='center'>$reward_seme</td>
			<td align='left'>".stripslashes($reward_reason)."</td>
			<td align='center' width='30'>".$reward_bad_arr[$reward_kind]."</td>
			<td align='left'>".stripslashes($reward_base)."</td>
			<td align='center'>$reward_date</td>
			<td align='center'>$date_temp</td>
			$print_temp
			</tr>";
		$rs->MoveNext();
		$i++;
	}
	if (!$i) $main.="<tr bgcolor='#ffffff'><td align='center' colspan='".($reward_sub+7)."'>�d�L���</td></tr></table></tr></table>";
	else {
		if ($reward_sub==1) 
			$act_temp="<input type='hidden' name='act' value='cancel'>";
		else
			$act_temp="<input type='hidden' name='act' value='recancel'>";
		$main.="
			</table>
			<input type='hidden' name='year_name' value='$year_name'>
			<input type='hidden' name='year_seme' value='$year_seme'>
			<input type='hidden' name='me' value='$me'>
			<input type='hidden' name='stud_id' value='$stud_id'>
			$act_temp
			<input type='hidden' name='reward_sub' value='".(3-$reward_sub)."'>
			<input type='submit' value='�}�l�B�z'>
			</form>
			</tr>
			</table>
			";
	}
}

echo $main;
echo "</tr></table>";
foot();
?>

<script language="JavaScript">
<!-- Begin
function jumpMenu0(){
	var str, classstr ;
 if (document.form0.year_seme.options[document.form0.year_seme.selectedIndex].value!="") {
	location="<?php echo $_SERVER['PHP_SELF'] ?>?year_seme=" + document.form0.year_seme.options[document.form0.year_seme.selectedIndex].value;
	}
}

function jumpMenu1(){
	var str, classstr ;
 if ((document.form1.year_name.value!="") & (document.form1.year_name.options[document.form1.year_name.selectedIndex].value!="")) {
	location="<?php echo $_SERVER['PHP_SELF'] ?>?year_seme=" + document.form1.year_seme.value + "&year_name=" + document.form1.year_name.options[document.form1.year_name.selectedIndex].value;
	}
}

function jumpMenu2(){
	var str, classstr ;
 if ((document.form2.year_name.value!="") & (document.form2.me.options[document.form2.me.selectedIndex].value!="")) {
	location="<?php echo $_SERVER['PHP_SELF'] ?>?year_seme=" + document.form2.year_seme.value + "&year_name=" + document.form2.year_name.value + "&me=" + document.form2.me.options[document.form2.me.selectedIndex].value;
	}
}

function jumpMenu3(){
	var str, classstr ;
 if ((document.form3.year_name.value!="") & (document.form3.me.value!="") & (document.form3.stud_id.options[document.form3.stud_id.selectedIndex].value!="")) {
	location="<?php echo $_SERVER['PHP_SELF'] ?>?year_seme=" + document.form3.year_seme.value + "&year_name=" + document.form3.year_name.value + "&me=" +document.form3.me.value + "&stud_id=" + document.form3.stud_id.options[document.form3.stud_id.selectedIndex].value;
	}
}
//  End -->
</script>
