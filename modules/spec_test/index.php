<?php
//$Id: index.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";

//�{��
sfs_check();

//�q�X�����������Y
head("�S�����");
print_menu($school_menu_p);

//�D�n���e
if ($_POST[year_seme]) {
	$ys=explode("_",$_POST[year_seme]);
	$sel_year=$ys[0];
	$sel_seme=$ys[1];
} else {
	if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
	if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
}

$main="<table border=0 cellspacing=1 cellpadding=2 width=100% bgcolor=#cccccc><tr><td bgcolor='#FFFFFF'>\n";
$year_seme_menu=year_seme_menu($sel_year,$sel_seme);
$main.="<form name=\"menu_form\" method=\"post\" action=\"$_SERVER[PHP_SELF]\">
	<table>
	<tr>
	<td>$year_seme_menu</td>
	</tr>
	</table></form>\n";

//�s�W����ά��
if ($_POST[add] || $_POST[add_subject]) {
	$mode=($_POST[add])?"add":$_POST[mode];
	$compare_id=($mode=="edit")?$_POST[id]:$_POST[compare_id];
	$main.=edit_form($sel_year,$sel_seme,$_POST[c_year],$_POST[title],$compare_id,$mode,$_POST[subjects],$_POST[add_subject],$_POST[subject],$_POST[ratio]);
}

//�T�w�s�W
if ($_POST[sure_add]) {
	$c_year=$_POST[c_year];
	$title=addslashes($_POST[title]);
	$rt=$_POST[ratio];
	while(list($k,$v)=each($_POST[subject])) {
		if ($v) {
			$subject_str.=addslashes($v)."@@";
			$ratio_str.=$rt[$k].":";
		}
	}
	if ($subject_str) $subject_str=substr($subject_str,0,-2);
	if ($ratio_str) $ratio_str=substr($ratio_str,0,-1);
	if ($_POST[id]) {
		$query="update test_manage set title='$title',subject_str='$subject_str',ratio_str='$ratio_str',compare_id='$compare_id' where id='".$_POST[id]."'";
	} else {
		$query="insert into test_manage (year,semester,c_year,title,subject_str,ratio_str,compare_id) values ('$sel_year','$sel_seme','$c_year','$title','$subject_str','$ratio_str','$compare_id')";
	}
	$res=$CONN->Execute($query) or die($query);
}

//�ק�
if ($_POST[edit]) {
	while(list($k,$v)=each($_POST[edit])) {
		$query="select * from test_manage where id='$k'";
		$res=$CONN->Execute($query) or die($query);
	}
	$main.=edit_form($res->fields[year],$res->fields[semester],$res->fields[c_year],"",$res->fields[id],"edit");
}

//�R��
if ($_POST[del]) {
	while(list($k,$v)=each($_POST[del])) {
		$query="delete from test_manage where id='$k'";
		$CONN->Execute($query);
	}
}

$main.="<form name=\"form1\" method=\"post\" action=\"$_SERVER[PHP_SELF]\">\n
	<table border=0 cellspacing=1 cellpadding=2 width=100% bgcolor=#cccccc class=main_body>\n
	<tr bgcolor='#E1ECFF' align='center'><td>�y����</td><td>�Ǧ~��</td><td>�Ǵ�</td><td>�~��</td><td>����W��</td><td>������</td><td>��إ[�v</td><td>�������</td><td>�\��ﶵ</td></tr>\n";
$query="select * from test_manage where year='$sel_year' and semester='$sel_seme' order by id desc";
$res=$CONN->Execute($query) or die($query);
$i=0;
while (!$res->EOF) {
	$subject_str=str_replace("@@","|",stripslashes($res->fields[subject_str]));
	$c_year=$res->fields[c_year];
	$c_year=(empty($c_year))?"�L�S�w�~��":$class_year[$c_year]."��";
	$t_id=$res->fields[id];
	$main.="<tr bgcolor='#ffffff' align='center'>
		<td>$t_id</td>
		<td>".$res->fields[year]."</td>
		<td>".$res->fields[semester]."</td>
		<td>".$c_year."</td>
		<td><a href=./score_input.php?id=$t_id>".stripslashes($res->fields[title])."</a></td>
		<td>".$subject_str."</td>
		<td>".$res->fields[ratio_str]."</td>
		<td>".$res->fields[compare_id]."</td>
		<td><input type='image' src='./images/edit.png' name='edit[".$res->fields[id]."]' alt='�ק�' align='middle'>/<input type='image' src='./images/del.png' name='del[".$res->fields[id]."]' alt='�R��' align='middle'></td>
		</tr>\n";
	$i++;
	$res->MoveNext();
}
if ($i==0) {
	$main.="<tr bgcolor='#E1ECFF' align='center'><td bgcolor='#ffffff' colspan='9'>�|�L���</tr>\n";
}
$main.="</table>";
if (!$_POST[add] && !$_POST[add_subject]) $main.="<input type='submit' name='add' value='�s�W�@������'>";
$main.="</form></tr></table>";
echo $main;

//�G������
foot();

function edit_form($sel_year,$sel_seme,$c_year,$title,$compare_id,$mode,$subjects=0,$add_subject="",$subject=array(),$ratio=array()) {
	global $CONN,$class_year;

	$query="select distinct c_year from school_class where year='$sel_year' and semester='$sel_seme' order by c_year";
	$res=$CONN->Execute($query) or die($query);
	$sel_class="";
	while (!$res->EOF) {
		$selected=($c_year==$res->fields[c_year])?"selected":"";
		$sel_class.="<option value='".$res->fields[c_year]."' $selected>".$class_year[$res->fields[c_year]]."��</option>\n";
		$res->MoveNext();
	}
	if (empty($sel_class)) {
		$sel_class="�L�~�Ÿ��";
	} else {
		$sel_class="<select name='c_year' size='1'>\n<option value=''>�L�S�w�~��</option>\n".$sel_class."</select>\n";
	}

	$subject_str="";
	$ratio_str="";
	$button_str="�T�w�s�W";
	if ($mode=="edit") {
		$query="select * from test_manage where id='$compare_id'";
		$res=$CONN->Execute($query) or die($query);
		$id=$res->fields['id'];
		$compare_id=$res->fields['compare_id'];
		$button_str="�T�w�ק�";
	}
	if ($mode=="add" || $add_subject) {
		//��ؼ�
		if ($add_subject) $subjects++;
		$subjects=($subjects<1)?5:$subjects;
		for ($i=1;$i<=$subjects;$i++) {
			$subject_str.="<input type='text' name='subject[".$i."]' value='".$subject[$i]."' size='6'> ";
			$ratio_str.="<input type='text' name='ratio[".$i."]' value='".$ratio[$i]."' size='6'> ";
		}
	} else {
		$title=stripslashes($res->fields['title']);
		$subject=explode("@@",stripslashes($res->fields['subject_str']));
		$ratio=explode(":",$res->fields['ratio_str']);
		while(list($k,$v)=each($subject)) {
			$subject_str.="<input type='text' name='subject[".($k+1)."]' value='$v' size='6'> ";
			$ratio_str.="<input type='text' name='ratio[".($k+1)."]' value='".$ratio[$k]."' size='6'> ";
		}
		$subjects=count($subject);
	}
	$form_str.="<form name=\"form2\" method=\"post\" action=\"$_SERVER[PHP_SELF]\">\n
		<table border=0 cellspacing=1 cellpadding=2 bgcolor=#cccccc class=main_body>\n
		<tr bgcolor='#E1ECFF' align='center'><td>�~��</td><td bgcolor='#ffffff' align='left'>$sel_class</td></tr>\n
		<tr bgcolor='#E1ECFF' align='center'><td>����W��</td><td bgcolor='#ffffff' align='left'><input type='text' name='title' value='".$title."' size='40'></td></tr>\n
		<tr bgcolor='#E1ECFF' align='center'><td>������</td><td bgcolor='#ffffff' align='left'>$subject_str</td></tr>\n
		<tr bgcolor='#E1ECFF' align='center'><td>��إ[�v</td><td bgcolor='#ffffff' align='left'>$ratio_str</td></tr>\n
		<tr bgcolor='#E1ECFF' align='center'><td>�������</td><td bgcolor='#ffffff' align='left'><input type='text' name='compare_id' value='$compare_id'></td></tr>\n
		</table><input type='submit' name='sure_add' value='$button_str'> <input type='submit' name='add_subject' value='�W�[���'> <input type='submit' value='����'><input type='hidden' name='subjects' value='$subjects'><input type='hidden' name='id' value='$id'><input type='hidden' name='mode' value='$mode'></form>\n";
	return $form_str;
}
?>
