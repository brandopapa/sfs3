<?php

// $Id: stud_site_num.php 6046 2010-08-27 17:45:05Z brucelyc $

// ���J�]�w��
include "stud_year_config.php";
include "../../include/sfs_case_dataarray.php";

// �{���ˬd
sfs_check();

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

//�L�X���Y
head("�ǥͮy���޲z");

$tool_bar=&make_menu($menu_p);
$cond=study_cond();

if ($_POST['student_sn']) {
	$sql="select stud_id,stud_name,stud_study_year,stud_study_cond from stud_base where student_sn='".$_POST['student_sn']."'";
	$rs=$CONN->Execute($sql);
	$stud_study_year=$rs->fields['stud_study_year'];
	$stud_name=$rs->fields['stud_name'];
	$stud_id=$rs->fields['stud_id'];
	$stud_study_cond=$rs->fields['stud_study_cond'];
}

if ($act=='�x�s') {
	for ($i=0;$i<$all_seme;$i++) 
		for ($j=1;$j<=2;$j++) {
			$seme_year_seme= sprintf("%03d%d",$stud_study_year+$i,$j);
			$sql="select * from stud_seme where seme_year_seme='$seme_year_seme' and seme_class='$class[$seme_year_seme]' and seme_num='$num[$seme_year_seme]'";
			$rs=$CONN->Execute($sql);
			if ($class[$seme_year_seme]!="") {
				if (!$rs->recordcount()) {
					$cyear=substr($class[$seme_year_seme],0,-2);
					$class_num=intval(substr($class[$seme_year_seme],1,2));
					$y=$stud_study_year+$i;
					$sql="select c_name from school_class where year='$y' and semester='$j' and c_year='$cyear' and c_sort='$class_num'";
					$rs=$CONN->Execute($sql);
					$seme_class_name=$rs->fields['c_name'];
					if ($seme_class_name!="") {
						$sql="select * from stud_seme where seme_year_seme='$seme_year_seme' and student_sn='".$_POST['student_sn']."'";
						$rs=$CONN->Execute($sql);
						if (!$rs->recordcount()) {
							$sql="insert into stud_seme (seme_year_seme, stud_id, seme_class, seme_class_name, seme_num, seme_class_year_s, seme_class_s, seme_num_s, student_sn) values ('$seme_year_seme', '$stud_id', '$class[$seme_year_seme]', '$seme_class_name', '$num[$seme_year_seme]', '0', '0', '0', '".$_POST['student_sn']."')"; 
							$rs=$CONN->Execute($sql);
						} else {
							$sql="update stud_seme set seme_class='$class[$seme_year_seme]',seme_num='$num[$seme_year_seme]' where seme_year_seme='$seme_year_seme' and student_sn='".$_POST['student_sn']."'";
							$rs=$CONN->Execute($sql);
						}
						//�P�B�ץ� stud_base ���y��
						$sql="UPDATE stud_base SET curr_class_num='".sprintf("%3d%02d",$class[$seme_year_seme],$num[$seme_year_seme])."' WHERE student_sn=$student_sn"; 
						$rs=$CONN->Execute($sql);
					} else 	echo "�d�L�ӯZ�I";
				} else	if ($rs->fields['stud_id']!=$stud_id) echo "�y���w���H�ϥ�";
			}
		}
}

$main="
	$tool_bar
	<table cellspacing=0 cellpadding=0><tr><td>
	<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4><tr  class='title_sbody1'>
	<form name ='form0' action='{$_SERVER['SCRIPT_NAME']}' method='post' >
	<td class='title_sbody2'>�ǥ;Ǹ�<td colspan='3' align='left'><input type='text' size='10' name='stud_id' value='$stud_id'><input type='submit' value='�󴫾ǥ�'></td></form></tr>";
if ($_POST['student_sn']=="" && $_POST['stud_id']) {
	$main.="<form name ='form1' action='{$_SERVER['SCRIPT_NAME']}' method='post'><tr class=\"title_sbody2\"><td align=\"center\">�ǥͦC��</td><td style=\"text-align:left;background-color:white;\">";
	$query="select * from stud_base where stud_id='".$_POST['stud_id']."' order by stud_study_year";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		$main.="<input type=\"radio\" name=\"student_sn\" value=\"".$res->fields['student_sn']."\" OnClick=\"this.form.submit();\"><span style=\"color:red;\">".$res->fields['stud_name']."</span>(".$res->fields['stud_study_year']."�~�J��)(".$cond[$res->fields['stud_study_cond']].")<br>";
		$res->MoveNext();
	}
	$main.="</td></tr>";
} elseif ($stud_id) $main.="
		<tr  class='title_sbody1'>
		<td class='title_sbody2'>�ǥͩm�W
		<td align='left' colspan='3'>$stud_name
		</tr>
		<tr  class='title_sbody1'>
		<td class='title_sbody2'>�N�Ǫ��A
		<td align='left' colspan='3'>".$cond[$stud_study_cond]."
		</tr>";
$main.="</form>";
if ($stud_study_year) {
	$main.="	
		<form name ='form2' action='{$_SERVER['SCRIPT_NAME']}' method='post' >";
	$all_seme=($IS_JHORES)?'3':'6';
	$have_data="";
	$main.="	<tr class='title_sbody2'><td align='center'>�Ǧ~��<td align='center'>�Ǵ�<td align='center'>�Z��<td align='center'>�y��</tr>";
	for ($i=0;$i<$all_seme;$i++) {
		for ($j=1;$j<=2;$j++) {
			$c_year=$IS_JHORES+$i+1;
			$seme_year_seme=sprintf("%03d%d",$stud_study_year+$i,$j);
			$sql="select seme_class,seme_num from stud_seme where student_sn='".$_POST['student_sn']."' and seme_year_seme='$seme_year_seme'";
			$rs=$CONN->Execute($sql);
			$sclass=$rs->fields['seme_class'];
			$seme_num=$rs->fields['seme_num'];
			if ($sclass=="") $sclass=$c_year."00";
			$class_menu=class_sel($stud_study_year+$i,$j,$sclass);
			$num_block=($class_menu=="")?"<font color='#ff0000'>�L�k�]�w</font>":"<input type='text' name='num[".$seme_year_seme."]' size='3' value='$seme_num'>";
			if ($class_menu=="") $class_menu="<font color='#ff0000'>�|���]�w�Z��</font>";
			$main.="	
				<tr class='title_sbody1'>
				<td align='center'>".($i+$stud_study_year)."
				<td align='center'>$j
				<td align='center'>$class_menu
				<td align='center'>$num_block
				</tr>";
		}
	}
	$submits="
		<input type='hidden' name='all_seme' value='$all_seme'>
		<input type='hidden' name='student_sn' value='".$_POST['student_sn']."'>
		<input type='submit' name='act' value='�x�s'>
		<input type='submit' name='act' value='�٭�'>";
}
$main.="</table>$submits</tr></table>";

echo $main;
foot();

function class_sel($year,$seme,$sclass) {
	global $CONN,$class_year;
	$year_seme= sprintf("%03d%d",$year,$seme);
	$c_year=substr($sclass,0,1);
	$sql_class_sel="select * from school_class where year='$year' and semester='$seme' and c_year='$c_year' order by c_sort";
	$rs_class_sel=$CONN->Execute($sql_class_sel);
	$temp="";
	while (!$rs_class_sel->EOF) {
		$class_name=substr($rs_class_sel->fields['class_id'],-2,2);
		$class_y=$c_year.$class_name;
		$selected=($class_y==$sclass)?"selected":"";
		$temp.="<option value='".$class_y."' $selected>".$class_year[$c_year].$rs_class_sel->fields['c_name']."�Z"."</option>\n";
		$rs_class_sel->MoveNext();
	}
	$temp=($temp=="")?"":"<select name='class[".$year_seme."]'>\n<option value=''>�|�����</option>\n".$temp."</select>\n";
	return $temp;
}
?>
