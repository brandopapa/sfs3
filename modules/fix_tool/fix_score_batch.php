<?php

//$Id: fix_score_batch.php 6798 2012-06-21 04:52:15Z infodaes $

require_once("config.php");

//�ϥΪ̻{��

sfs_check();



head("�ҵ{���Z�ॿ");

print_menu($school_menu_p);



$year_seme=$_POST[year_seme];

$study_grade=$_POST[study_grade];

$items_0=$_POST[items_0];

$items_1=$_POST[items_1];



if($year_seme==''){

	$study_year = curr_year(); //�ثe�Ǧ~

	$study_seme = curr_seme(); //�ثe�Ǵ�

	$year_seme = sprintf("%03d%d",$study_year,$study_seme);

} else {

	$study_year=substr($year_seme,0,3);

	$study_seme=substr($year_seme,-1);

}



$table_name="score_semester_".($study_year+0)."_$study_seme";



if($_POST['GoBTN']=='�T�w') {

	if($items_0 and $items_1){

		//���i�����ˬd

		//�������q���Z��إN��

		$sql="UPDATE $table_name SET ss_id=$items_1 WHERE ss_id=$items_0";

		$res=$CONN->Execute($sql) or user_error("�౵�ҵ{�� ���q ���Z��ƥ��ѡI<br>$sql",256);

		

		//�����Ǵ����Z

		$sql="UPDATE stud_seme_score SET ss_id=$items_1 WHERE ss_id=$items_0 and seme_year_seme='$year_seme'";

		$res=$CONN->Execute($sql) or user_error("�౵�ҵ{�� �Ǵ� ���Z��ƥ��ѡI<br>$sql",256);



		//�����V�O�{��

		$sql="UPDATE stud_seme_score_oth SET ss_id=$items_1 WHERE ss_id=$items_0 and seme_year_seme='$year_seme'";

		$res=$CONN->Execute($sql) or user_error("�౵�ҵ{���V�O�{�צ��Z��ƥ��ѡI<br>$sql",256);

				

		//�����Ҫ�

		$sql="UPDATE score_course SET ss_id=$items_1 WHERE ss_id=$items_0 and year='".intval($study_year)."' and semester='$study_seme'";

		$res=$CONN->Execute($sql) or user_error("�౵�ҵ{�� �Ǵ� �Ҫ��ƥ��ѡI<br>$sql",256);

		

	} else {

		echo "<script language=\"Javascript\"> alert (\"����w�n�ӷ��P�ت��ҵ{, �L�k�i���౵�I\")</script>";

	}

}

//�Z�Žҵ{�אּ�~�Žҵ{
$release_ssid=$_POST['release_ssid'];
if($release_ssid) {
	$sql="UPDATE score_ss SET class_id='' WHERE ss_id='$release_ssid'";
	$res=$CONN->Execute($sql) or user_error("�Z�Žҵ{�אּ�~�Žҵ{���ѡI<br>$sql",256);
}

if($_POST['GoBTN']=='�R�����') {

	if($_POST[kill_id]){

		foreach($_POST[kill_id] as $ss_id) $ss_id_list.="$ss_id,";

		$ss_id_list=substr($ss_id_list,0,-1);

		$sql="DELETE FROM score_ss WHERE ss_id IN ($ss_id_list)";

		$res=$CONN->Execute($sql) or user_error("�R���ҵ{��ƥ��ѡI => $ss_id_list<br>$sql",256);

	}

}



//echo "$year_seme<BR>$study_year<BR>$study_seme<BR>$study_grade<BR>";



$warning="<font size=2><li>���{�����b��U�ϥΪ̯�妸�N�Y�ҵ{���Z�ഫ���t�@�ӽҵ{���Z�C
<li>�ϥΪ��ɾ��Y�b�����]\"�~�R\"�F�w�g��J���Z���ҵ{�A���N�����J�����Z�ֳt�α��ܷs�]�w���ҵ{�A�H�קK�o���s�j�q��J�αo�i�J�t�θ�ƮwDEBUG���x�Z!!
<li>���{���]�p���ηN�A���b�ѨM\"�g�`��\"���ҵ{�]�w���~�C�C�Ǵ�������ҵ{�]�w�e�A�Я�Աx�Ǯսҵ{�W���PSFS���S�ʦA�i��]�w!!
<li>���{������������~��O�A�ϥΫe���ü{�A�Х����n��Ʈw�ƥ�!
<li><font color='red'>2012/6/21 �s�WDBLCLICK�Z�Žҵ{�N���i�M���Z�Žҵ{�]�w���~�Žҵ{�\��(���i�^�_�A���ԷV�ϥΡI)</font></li>
<li>�{���@�̡G<a href='mailto:infodaes@seed.net.tw'>�x����infodaes</a></font>";


//���o����᪺�Ǵ��C��}�C

$semesters=get_class_seme();


//�s�@�Ǧ~�U�Կ��

$semesters_menu="<select name='year_seme' onchange='this.form.submit();'>";

foreach($semesters as $key=>$value){

	$selected=($key==$year_seme)?'selected':'';

	$semesters_menu.="<option value='$key' $selected>$value</option>";

}

$semesters_menu.="</select>";



//���o�w�]�w�ҵ{���~��

$sql="SELECT DISTINCT class_year FROM score_ss WHERE year=$study_year AND semester=$study_seme ORDER BY class_year";

$res=$CONN->Execute($sql) or user_error("Ū���w�]�w�ҵ{���~�ŦC���ѡI<br>$sql",256);



$study_grade_menu="<select name='study_grade' onchange='this.form.submit();'><option></option>";

while(!$res->EOF) {

	

	$selected=($study_grade==$res->fields['class_year'])?'selected':'';

	$study_grade_menu.="<option value='".$res->fields['class_year']."' $selected>".$res->fields['class_year']."�~��</option>";

	$res->MoveNext();

	}

$study_grade_menu.="</select>";



if($study_grade){

	//���o�ҵ{����W�ٹ��

	$sql="SELECT subject_id,subject_name FROM score_subject";

	$res=$CONN->Execute($sql) or user_error("Ū���ҵ{�W�٥��ѡI<br>$sql",256);

	$ss_name=array();

	while(!$res->EOF) {

		$subject_id=$res->fields['subject_id'];

		$ss_name[$subject_id]=$res->fields['subject_name'];

		$res->MoveNext();

	}

	

	//���o�~�Žҵ{�P�w��J�����Z����

	$sql="SELECT ss_id,subject_id,enable,need_exam,class_id,rate,link_ss FROM score_ss WHERE year='$study_year' AND semester='$study_seme' AND class_year='$study_grade' ORDER BY class_id,sort,sub_sort";

	$res=$CONN->Execute($sql) or user_error("Ū���ҵ{�]�w��ƥ��ѡI<br>$sql",256);

	$ss=array();

	while(!$res->EOF) {

		$ss_id=$res->fields['ss_id'];

		$subject_id=$res->fields['subject_id'];

		$enabled=$res->fields['enable'];



		$ss[$enabled][$ss_id]['subject_id']=$subject_id;

		$ss[$enabled][$ss_id]['ss_name']=$ss_name[$subject_id];

		$ss[$enabled][$ss_id]['enable']=$res->fields['enable'];

		$ss[$enabled][$ss_id]['need_exam']=$res->fields['need_exam'];

		$ss[$enabled][$ss_id]['class_id']=$res->fields['class_id'];

		$ss[$enabled][$ss_id]['rate']=$res->fields['rate'];

		$ss[$enabled][$ss_id]['link_ss']=$res->fields['link_ss'];

		

		$res->MoveNext();

	}

//echo "$sql<BR>";

	//���o�w��J���Z����Ƶ���  ��ƪ�榡�� score_semester_94_1  ������class_id�榡��094_1_01_X

	

	$sql="SELECT ss_id,count(*) as records FROM $table_name WHERE class_id like '".$study_year."_".$study_seme."_".sprintf("%02d",$study_grade)."_%' GROUP BY ss_id";

	$res=$CONN->Execute($sql) or user_error("Ū�����Z�έp��ƥ��ѡI<br>$sql",256);

	$ss_records=array();

	while(!$res->EOF) {

		$ss_id=$res->fields['ss_id'];

		$ss_records[$ss_id]=$res->fields['records'];

		$res->MoveNext();

	}



//echo "$sql<BR>";

	//�N�ҵ{����ഫ���n��ܪ����

	foreach($ss as $key=>$value){

		$target=sprintf("items_%01d",$key);

		$$target="<table width='100%' style='font-size:10pt;' align='left' border='1' cellpadding='1' cellspacing='0' style='border-collapse: collapse' bordercolor='#CCCCCC' id='".($key+2)."'>";

		$$target.="<tr align='center' bgcolor='#CCCCCC'><td>�s��</td><td>�W��</td><td>�E�~�@�e����</td><td>�p��</td><td>�[�v</td><td>���Z��</td><td>�Z��</td></tr>";

		foreach($value as $ss_id=>$data){

			//�P�_�O�_�i�H���

			$kill_id='';

			switch($key) {

			case 0:

				if(!$ss_records[$ss_id]) {

					$enabled='disabled';

					$kill_id="<input type='checkbox' name='kill_id[]' value='$ss_id'>";

				} else $enabled='';

				break;

			case 1:

				$enabled=$ss_records[$ss_id]?'disabled':'';

				if($multi_connectable) $enabled='';

				break;

			}

			if(!$data['need_exam']) $enabled='disabled';



			//���ձM��

			//$enabled='';
			$ss_radio="<input type='radio' name='".$target."' value='$ss_id' onclick='this.form.selection_$key.value=$ss_id' $enabled>";
			$release=$data['class_id']?'onMouseOver="this.style.cursor=\'hand\';" ondblclick="if(confirm(\'�u���n�M�� #'.$ss_id.'-'.$data['ss_name'].' ���Z�Žҵ{�]�w('.$data['class_id'].')�A�ର�~�Žҵ{�H\')) { document.myform.release_ssid.value=\''.$ss_id.'\'; document.myform.submit(); }"':'';
			$$target.="<tr align='center'>
				<td>$ss_radio".$ss_id."</td>
				<td>".$data['ss_name']."</td>
				<td>".$data['link_ss']."</td>
				<td>".$data['need_exam']."</td>
				<td>".$data['rate']."</td>
				<td>".$ss_records[$ss_id]."$kill_id</td>
				<td $release>".$data['class_id']."</td>
				</tr>";
		}
		$$target.="</tr></table>";
	}
	//echo "<PRE>";
	//print_r($items_0);
	//print_r($items_1);
	//echo "</PRE>";
}

$main="<table align=left border='2' cellpadding='5' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1'>";
$main.="<form name='myform' method='post' action='$_SERVER[PHP_SELF]'><input type='hidden' name='release_ssid' value=''>$semesters_menu $study_grade_menu";
$main.="<TR BGCOLOR='#FFCCCC'><TD align='center'>���Ϊ��ҵ{</TD><TD align='center'>�ҥΪ��ҵ{</TD><TD align='center'>! �`�N !</TD></TR>";
$main.="<TR><TD valign='top'>$items_0</TD><TD valign='top'>$items_1</TD><TD width='200' valign='top'>$warning</TD></TR>";
echo $main."<tr align='center'><td><input type='submit' name='GoBTN' value='�R�����' onclick='return confirm(\"�u���n�۸�Ʈw�R���H\")'></td><td colspan=2>�z����ܡG���νҵ{id:<input type='text' name='selection_0' size='5' disabled>�����Z�౵��id:<input type='text' name='selection_1' size='5' disabled><input type='submit' name='GoBTN' value='�T�w' onclick='return confirm(\"�u���n�i���ഫ�H\")'></td></table></form>";

foot();
?>

