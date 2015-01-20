<?php

// $Id: class_site_num.php 6045 2010-08-27 06:50:50Z brucelyc $

// ���J�]�w��
include "stud_year_config.php";
require "../../include/sfs_case_score.php";
include_once "../../include/sfs_core_module.php";
include "../../include/sfs_case_dataarray.php";

// �{���ˬd
sfs_check();

$m_arr = get_sfs_module_set();
extract($m_arr, EXTR_OVERWRITE);

$year_seme=($_POST['year_seme'])?$_POST['year_seme']:$_GET['year_seme'];
$year_name=($_POST['year_name'])?$_POST['year_name']:$_GET['year_name'];
$me=($_POST['me'])?$_POST['me']:$_GET['me'];
$act=($_POST['act'])?$_POST['act']:$_GET['act'];
$studid=$_GET['studid'];
$submit=($_POST['submit'])?$_POST['submit']:$_GET['submit'];
$stud_id=$_POST['stud_id'];
$num=$_POST['num'];
$move_out=$_POST['move_out'];

//���o�Ǵ�
if (empty($year_seme)) {
	$sel_year = curr_year(); //�ثe�Ǧ~
	$sel_seme = curr_seme(); //�ثe�Ǵ�
} else {
	$year_seme_A=explode("_",$year_seme);
	$sel_year=$year_seme_A[0];
	$sel_seme=$year_seme_A[1];
}
$seme_year_seme=sprintf ("%03d%1d", $sel_year,$sel_seme);

if (($act=="del")&&($year_seme)&&($year_name)&&($me)&&($studid)) {
	$sql="delete from stud_seme where seme_year_seme='$seme_year_seme' and stud_id='$studid'";
	$rs=$CONN->Execute($sql);
}

//�L�X���Y
head("�Z�Ůy���޲z");

//�Ҳտ��
print_menu($menu_p,$linkstr);

//�ץ���ƪ�
$Alter_db="ALTER TABLE stud_seme ADD (student_sn int(10) unsigned NOT NULL default '0')";
mysql_query($Alter_db);  


//�]�w�D������ܰϪ��I���C��
echo "<table border=0 cellspacing=1 cellpadding=2 width=100% bgcolor=#cccccc><tr><td bgcolor=#FFFFFF>";

//�Ǵ����
$col_name="year_seme";
$id=$year_seme;    
$show_year_seme=select_year_seme($id,$col_name);
$year_seme_menu="
	<form name='form0' method='post' action='{$_SERVER['SCRIPT_NAME']}'>
	<select name='$col_name' onChange='jumpMenu0()'>
	$show_year_seme
	</select>
	</form>";
//�~�ſ��
if($year_seme){
	$col_name="year_name";
	$id=$year_name;
	$show_class_year=select_school_class($id,$col_name,$sel_year,$sel_seme);
	$class_year_menu="
		<form name='form1' method='post' action='{$_SERVER['SCRIPT_NAME']}'>
		<select name='$col_name' onChange='jumpMenu1()'>
		$show_class_year
		</select>
		<input type='hidden' name='year_seme' value='$year_seme'>
		</form>";
}
//�Z�ſ��
if($year_seme && $year_name){
	$col_name="me";
	$id=$me;
	$show_class_year_name=select_school_class_name($year_name,$id,$col_name,$sel_year,$sel_seme);
	$class_year_name_menu="
		<form name='form2' method='post' action='{$_SERVER['SCRIPT_NAME']}'>
		<select name='$col_name' onChange='jumpMenu2()'>
		$show_class_year_name
		</select>
		<input type='hidden' name='year_name' value='$year_name'>
		<input type='hidden' name='year_seme' value='$year_seme'>
		</form>";
}

$menu="
	<table cellspacing=0 cellpadding=0>
	<tr>
	<td>$year_seme_menu</td><td>$class_year_menu</td><td>$class_year_name_menu</td>
	</tr>
	</table>";

echo $menu;

if (($submit=="�x�s")&&($year_seme)&&($year_name)&&($me)) {
	$seme_class=sprintf ("%d%02d", $year_name,$me);
	$err=0;
	while(list($k,$v)=each($stud_id)) {
		$chk=array_keys($stud_id,$v);
		if (($v)&&(count($chk)>1)) $err=1;
	}
	if ($err==0) {
		reset($stud_id);
		while(list($k,$v)=each($stud_id)) {
			if ($v>0) {
				$sql="update stud_seme set seme_num='$v' where seme_year_seme='$seme_year_seme' and seme_class='$seme_class' and stud_id='$k'";
				$rs=$CONN->Execute($sql);
				if ($sel_year==curr_year() && $sel_seme=curr_seme()) {
					$curr_class_num=sprintf("%d%02d%02d",$year_name,$me,$v);
					$sql="update stud_base set curr_class_num='$curr_class_num' where stud_id='$k' and ($sel_year - stud_study_year between 0 and 9)";
					$rs=$CONN->Execute($sql);
				}
			}
		}
		while(list($k,$v)=each($num)) {
			if ($v) {
				$sql="select student_sn from stud_base where stud_id='$v' and ($sel_year - stud_study_year between 0 and 9)";
				$rs=$CONN->Execute($sql);
				$student_sn=$rs->fields['student_sn'];
				if ($student_sn) {
					$sql="select stud_id from stud_seme where seme_year_seme='$seme_year_seme' and stud_id='$v'";
					$rs=$CONN->Execute($sql);
					if (! $rs->fields['stud_id']) {
						$sql="select c_name from school_class where year='$sel_year' and semester='$sel_seme' and c_year='$year_name' and c_sort='$me'";
						$rs=$CONN->Execute($sql);
						$seme_class_name=addslashes($rs->fields['c_name']);
						$sql="insert into stud_seme (seme_year_seme,stud_id,seme_class,seme_class_name,seme_num,seme_class_year_s,seme_class_s,seme_num_s,student_sn) values ('$seme_year_seme','$v','$seme_class','$seme_class_name','$k','0','0','0','$student_sn')";
						$rs=$CONN->Execute($sql);
					}
					if ($sel_year==curr_year() && $sel_seme=curr_seme()) {
						$curr_class_num=sprintf("%d%02d%02d",$year_name,$me,$k);
						$sql="update stud_base set curr_class_num='$curr_class_num' where stud_id='$v' and ($sel_year - stud_study_year between 0 and 9)";
						$rs=$CONN->Execute($sql);
					}
				}
			}
		}
		while (list($k,$v)=each($move_out)) {
			$query="select student_sn from stud_seme where seme_year_seme='$seme_year_seme' and stud_id='$k'";
			$res=$CONN->Execute($query);
			$student_sn=$res->fields[student_sn];
			$query="delete from stud_seme where seme_year_seme='$seme_year_seme' and student_sn='$student_sn'";
			$CONN->Execute($query);
			if ($sel_year==curr_year() && $sel_seme=curr_seme()) {
				$CONN->Execute("update stud_base set curr_class_num='00000' where student_sn='$student_sn'");
			}
		}
	}
}

if (($year_seme)&&($year_name)&&($me)) {
	$seme_class=sprintf ("%d%02d", $year_name,$me);
	$sql="select * from stud_seme where seme_year_seme='$seme_year_seme' and seme_class='$seme_class' order by seme_num";
	$rs=$CONN->Execute($sql);
	$i=0;
	if ($rs->recordcount()) {
		while (!$rs->EOF) {
			$stud_id[$i]=$rs->fields["stud_id"];
			$seme_num[$i]=$rs->fields['seme_num'];
			$i++;
			$rs->MoveNext();
		}
	}
	if ($i>0) $max_num=$seme_num[$i-1];
	$mkind=study_cond();
	$main="
		<table bgcolor=#000000 border=0 cellpadding=2 cellspacing=1>
		<form name='form3' action={$_SERVER['SCRIPT_NAME']} method='post' encType='multipart/form-data'>
		<tr bgcolor='#ffffff'><td>�y��<td align='center'>�Ǹ�<td align='center'>�m�W<td>�ʧO<td>�եX���Z<td>�N�Ǫ��A</tr>";
	if ($i!=0) {
		for ($i=0;$i<count($stud_id);$i++) {
			$sql="select stud_name,stud_sex,stud_study_cond from stud_base where stud_id='$stud_id[$i]' and ($sel_year - stud_study_year between 0 and 9)";
			$rs=$CONN->Execute($sql);
			$stud_sex[$i]=$rs->fields['stud_sex'];
			$stud_name[$i]=addslashes($rs->fields['stud_name']);
			$stud_study_cond[$i]=$mkind[$rs->fields['stud_study_cond']];
		}
	}
	if ($act=="�W�[�@�C") $max_num++;
	$j=0;
	for ($i=1;$i<=$max_num;$i++) {
		if ($seme_num[$j]<=$i && $seme_num[$j]!="") {
			if ($stud_sex[$j]==1) {
				$fncolor="blue";
				$sex="�k";
			} elseif ($stud_sex[$j]==2) {
				$fncolor="#FF6633";
				$sex="�k";
			}
			if ($seme_num[$j]<$i) $i--;
			$main.="
				<tr bgcolor='#ffffff'>
				<td><input type=\"text\" name=stud_id[".$stud_id[$j]."] value='".$seme_num[$j]."' size=\"3\" maxlength=\"3\">
				<td>".$stud_id[$j]."
				<td><font color=$fncolor>".stripslashes($stud_name[$j])."</font>
				<td align='center'><font color=$fncolor>$sex</font>
				<td align='center'><input type='checkbox' name='move_out[".$stud_id[$j]."]'>
				<td align='center'><font color='#a0a0a0'>".$stud_study_cond[$j]."</font>
				</tr>\n";
			$j++;
		} else {
			$main.="
				<tr bgcolor='#ffffff'>
				<td>$i
				<td><input type=\"text\" name=num[".$i."] value=\"\" size=\"5\">
				<td>
				<td>
				<td>
				<td>
				</tr>\n";
		}
	}
	$main.="</table>
		<input type='hidden' name='year_seme' value='$year_seme'>
		<input type='hidden' name='year_name' value='$year_name'>
		<input type='hidden' name='me' value='$me'>
		<input type='submit' name='submit' value='�x�s'>
		<input type='submit' name='act' value='�W�[�@�C'>
		</form>";
}

//�����D������ܰ�----------------------------------------------------------------
echo $main."</td></tr></table>";

//���եثe�Ǧ~�P�Ǵ��U�Ԧ����
function select_year_seme($id,$col_name){
    global $CONN;
    $sql="select distinct year,semester from school_class";
    $rs=$CONN->Execute($sql);

    $option="<option value=''>��ܾǦ~��</option>\n";
    $i=0;
    while (!$rs->EOF) {
        $year[$i]=$rs->fields["year"];
        $semester[$i]=$rs->fields['semester'];
        $year_semester[$i]=$year[$i]."_".$semester[$i];
        $i++;
        $rs->MoveNext();
    }
    for($i=0;$i<count($year_semester);$i++){
        $selected=($id==$year_semester[$i])?"selected":"";
        $YS=explode("_",$year_semester[$i]);
        $option.="<option value='$year_semester[$i]' $selected>".$YS[0]."�Ǧ~�ײ�".$YS[1]."�Ǵ�</option>\n";
    }
    $select_school_class="<select name='$col_name'>$option</select>";
	//return $select_school_class;
    return $option;
}
//���եثe�~�ŤU�Ԧ����
function select_school_class($id,$col_name,$sel_year,$sel_seme){
    global $CONN,$school_kind_name;
    $sql="select distinct c_year from school_class where year=$sel_year and semester=$sel_seme order by c_year";
    $rs=$CONN->Execute($sql);
    $option="<option value=''>��ܦ~��</option>\n";
    $i=0;
    while (!$rs->EOF) {
        $c_year[$i]=$rs->fields['c_year'];
        $i++;
        $rs->MoveNext();
    }
    if($i==0) trigger_error("�藍�_�I�z�|���]�w�Z�šI",E_USER_ERROR);
    for($i=0;$i<count($c_year);$i++){
        $selected=($id==$c_year[$i])?"selected":"";
        $option.="<option value='$c_year[$i]' $selected>".$school_kind_name[$c_year[$i]]."��</option>\n";
    }
    $select_school_class="<select name='$col_name'>$option</select>";
	//return $select_school_class;
    return $option;
}
//���եثe�Ӧ~�Ū��Ҧ��Z�ŤU�Ԧ����
function select_school_class_name($c_year,$id,$col_name,$sel_year,$sel_seme){
    global $CONN;
    if(empty($c_year)) $c_year=1;
    $sql="select distinct c_name,c_sort from school_class where year=$sel_year and semester=$sel_seme and c_year=$c_year order by c_sort";
    $rs=$CONN->Execute($sql);
    $option="<option value=''>��ܯZ��</option>\n";
    $i=0;
    while (!$rs->EOF) {
        $c_name[$i]=$rs->fields["c_name"];
        $c_sort[$i]=$rs->fields["c_sort"];
        $i++;
        $rs->MoveNext();
    }
    if($i==0) trigger_error("�藍�_�I�z�|���]�w�Z�šI",E_USER_ERROR);
    for($i=0;$i<count($c_name);$i++){
        $selected=($id==$c_sort[$i])?"selected":"";
        $option.="<option value='$c_sort[$i]' $selected>".$c_name[$i]."�Z</option>\n";
    }
    $select_school_class_name="<select name='$col_name'>$option</select>";
	//return $select_school_class_name;
    return $option;
}

//�L�X�ɧ�
foot();

?>

<script language="JavaScript1.2">
<!-- Begin
function jumpMenu0(){
	var str, classstr ;
 if (document.form0.year_seme.options[document.form0.year_seme.selectedIndex].value!="") {
	location="<?php echo $_SERVER['SCRIPT_NAME'] ?>?year_seme=" + document.form0.year_seme.options[document.form0.year_seme.selectedIndex].value;
	}
}

function jumpMenu1(){
	var str, classstr ;
 if ((document.form1.year_name.value!="") & (document.form1.year_name.options[document.form1.year_name.selectedIndex].value!="")) {
	location="<?php echo $_SERVER['SCRIPT_NAME'] ?>?year_seme=" + document.form1.year_seme.value + "&year_name=" + document.form1.year_name.options[document.form1.year_name.selectedIndex].value;
	}
}

function jumpMenu2(){
	var str, classstr ;
 if ((document.form2.year_name.value!="") & (document.form2.me.options[document.form2.me.selectedIndex].value!="")) {
	location="<?php echo $_SERVER['SCRIPT_NAME'] ?>?year_seme=" + document.form2.year_seme.value + "&year_name=" + document.form2.year_name.value + "&me=" + document.form2.me.options[document.form2.me.selectedIndex].value;
	}
}

//  End -->
</script>
