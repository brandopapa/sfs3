<?php
//$Id: disgrad.php 6400 2011-03-25 13:42:09Z brucelyc $
include "config.php";
include "../../include/sfs_case_score.php";

//�{��
sfs_check();

//�L�X���Y
head();
print_menu($menu_p);

$stud_grad_year=$_POST['stud_grad_year']?$_POST['stud_grad_year']:curr_year();

if($_POST['write']=='�g�J�׷~�W��'){
	//�g�J���~
	$query="UPDATE grad_stud SET grad_kind=1 WHERE stud_grad_year=$stud_grad_year";
	$res=$CONN->Execute($query) or die("�L�k��s�A�y�k: $query");
	//�g�J�׷~
	$query="UPDATE grad_stud SET grad_kind=2 WHERE stud_grad_year=$stud_grad_year AND student_sn IN (".$_POST['digrad_sn'].")";
	$res=$CONN->Execute($query) or die("�L�k��s�A�y�k: $query");	
	
	echo "<script language='JavaScript'> alert(\"�w�g�g�J�����I\")</script>";
	
	//���ΦA�έp
	$_POST['abs_base_days']=0;
}


//��ܻ���
$description="<font size=2 color='blue'>
<ol>
<li>�]�p�̾ڡG�Ш|��101�~6��13��O��(�G)�r��1010109284����</li>
<li>���~����G
<ul>
<li>�ǲ߻�첦�~���Z���|���ǲ߻�쥭���F�����H�W�C<font size=2 color='red'>(�|���H�W���Z���F60���̡A����׷~�Ү�)</font></li>
<li>���g��P��A�����T�j�L(�t���֭p�G�T��ĵ�i���@���p�L�A�T���p�L���@���j�L)�C<font size=2 color='red'>(�o����-27���H�U�̡A����׷~�Ү�)</font></li>
<li>�ǲߴ��������Ǯծ֥i����(��B�f)���A�W���`�X�u�v�ܤֹF�T�����G�H�W�C<font size=2 color='red'>(�ư��B�m�ҡB���|�ʮu��Ʋέp�W�L��J����Ǥ�ơA����׷~�Ү�)</font></li>
</ul>
</li>
</ol>
<hr></font>";

//���;Ǵ����
$grad_year_radio="���� �~ �� �~ �סG";
$query="select distinct stud_grad_year from grad_stud order by stud_grad_year desc limit 5";
$res=$CONN->Execute($query);
while(!$res->EOF) {
	$checked=($stud_grad_year==$res->fields['stud_grad_year'])?'checked':'';
	$grad_year_radio.="<input type='radio' name='stud_grad_year' value='{$res->fields[0]}' $checked>{$res->fields[0]} ";
	$res->MoveNext();
}

//�ǥ͹L�o�ﶵ
$stud_filter=$_POST['stud_filter'];
$stud_filter_radio="���ǥͦC�ܿﶵ�G<input type='radio' name='stud_filter' value=1".($stud_filter==1?' checked':'').">�Ҧ����~�� <input type='radio' name='stud_filter' value=0".(!$stud_filter?' checked':'').">���F���~����ǥ�";

//���L�o�ﶵ
$area_base_count=$_POST['area_base_count']?$_POST['area_base_count']:4;
$area_base_count_text="���F�������Ʋ��~�P�w��ǡG<input type='text' name='area_base_count' size=4 value=$area_base_count>";

//���g�L�o�ﶵ
$reward_base_score=$_POST['reward_base_score']?$_POST['reward_base_score']:-26;
$reward_base_score_text="�����g���Ʋ��~�P�w��ǡG<input type='text' name='reward_base_score' size=4 value=$reward_base_score>�H�W";

//���m���ʮu���
$abs_base_days=$_POST['abs_base_days']?$_POST['abs_base_days']:0;
$abs_base_days_text="���ư��B�m�ҡB���|�ʮu��ƭ׷~�P�w��ǡG<input type='text' name='abs_base_days' size=4 value=$abs_base_days>";

if($abs_base_days){

	//�����w�Ǧ~�P�B�ƫ᪺�ǥ�sn�B�򥻸�ơB�P�_�J�Ǧ~
	$grad_year_sn=array();
	$student_data_arr=array();
	$stud_id_list='';
	$stud_study_year=99999;
	$query="select a.student_sn,b.curr_class_num,b.stud_name,b.stud_study_year,b.stud_id from grad_stud a inner join stud_base b on a.student_sn=b.student_sn where a.stud_grad_year='$stud_grad_year' order by b.curr_class_num";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		$student_sn=$res->fields['student_sn'];
		$stud_id=$res->fields['stud_id'];
		$stud_id_list.="'$stud_id',";
		$grad_year_sn[]=$student_sn;
		$grad_year_id[]=$stud_id;
		$student_data_arr[$student_sn]['curr_class']=substr($res->fields['curr_class_num'],0,3);
		$student_data_arr[$student_sn]['curr_no']=substr($res->fields['curr_class_num'],-2);
		$student_data_arr[$student_sn]['stud_name']=$res->fields['stud_name'];
		$student_data_arr[$student_sn]['stud_id']=$stud_id;
		$stud_study_year=min($stud_study_year,$res->fields['stud_study_year']);
		$res->MoveNext();
	}
	$stud_id_list=substr($stud_id_list,0,-1);

	$year_semester_list="<br>�����Z�p��Ǧ~�G [ $stud_study_year ] ~ [ $stud_grad_year ]";
	$semes=array();
	$semes_list='';
	for($i=$stud_study_year;$i<=$stud_grad_year;$i++)
		for($j=1;$j<=2;$j++) { $semes[]=sprintf("%03d%d",$i,$j); $semes_list.="'".sprintf("%03d%d",$i,$j)."',"; }

	$semes_list=substr($semes_list,0,-1);

	/*
	echo "<pre>";
	print_r($fin_score);
	echo "</pre>";
	exit;
	*/


	//�P�w�P�L����g
	$reward=array();
	foreach($grad_year_sn as $student_sn){
		//����ǥͥ��P�L�����g����
		$sql="SELECT reward_year_seme,reward_kind FROM reward WHERE student_sn='$student_sn' AND reward_cancel_date='0000-00-00' ORDER BY student_sn,reward_year_seme";
		$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
		while(!$res->EOF)
		{
			$reward_kind=$res->fields['reward_kind'];
			switch ($reward_kind) {   //�\�L�۩�B�ഫ���򥻤�
				case 1:			$reward[$student_sn]++; break;
				case 2:			$reward[$student_sn]+=2; break;
				case 3:			$reward[$student_sn]+=3; break;
				case 4:			$reward[$student_sn]+=6; break;
				case 5:			$reward[$student_sn]+=9; break;
				case 6:			$reward[$student_sn]+=18; break;
				case 7:			$reward[$student_sn][9]+=27; break;
				case -1:		$reward[$student_sn]--;	break;
				case -2:		$reward[$student_sn]-=2; break;
				case -3:		$reward[$student_sn]-=3; break;
				case -4:		$reward[$student_sn]-=6; break;
				case -5:		$reward[$student_sn]-=9; break;
				case -6:		$reward[$student_sn]-=18; break;
				case -7:		$reward[$student_sn]-=27; break;
			}
			$res->MoveNext();
		}
	}

	//�P�w�X�u�v  "1"=>"�ư�","2"=>"�f��","3"=>"�m��","4"=>"���|","5"=>"����","6"=>"��L"
	//�Ȩ� "1"=>"�ư�"�B"3"=>"�m��"�B"4"=>"���|"
	$abs_data_arr=array();
	$sql="SELECT stud_id,sum(abs_days) FROM stud_seme_abs WHERE seme_year_seme IN ($semes_list) AND abs_kind IN (1,3,4) AND stud_id IN ($stud_id_list) GROUP BY stud_id";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
	while(!$res->EOF)
	{
		$stud_id=$res->fields['stud_id'];
		$abs_data_arr[$stud_id]=$res->fields[1];
		$res->MoveNext();
	}

	/*
	echo "<pre>";
	print_r($abs_data);
	echo "</pre>";
	exit;
	*/

	//������Z
	$fin_score=cal_fin_score($grad_year_sn,$semes);

	$show_ss=array("language"=>"�y��","math"=>"�ƾ�","nature"=>"�۵M�P�ͬ����","social"=>"���|","health"=>"���d�P��|","art"=>"���N�P�H��","complex"=>"��X����");
	$student_data="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1' width='100%'><tr align='center' bgcolor='#ccffcc'><td>�Z��</td><td>�y��</td><td>�Ǹ�</td><td>�m�W</td>";
	foreach($show_ss as $key=>$value) $student_data.="<td bgcolor='#ccccff'>$value</td>";
	$student_data.="<td>�����H�W</td><td>���g</td><td>���m���ʮu�`��</td></tr>";

	
	$succ_count=array(7=>0,6=>0,5=>0,4=>0,3=>0,2=>0,1=>0,0=>0);
	foreach($student_data_arr as $student_sn=>$data){
		$succ=$fin_score[$student_sn]['succ'];
		$stud_id=$data['stud_id'];
		$abs_data=$abs_data_arr[$stud_id];
		if($fin_score[$student_sn]['life']['avg']['score']>=60) $succ--;
		$reward_score=$reward[$student_sn]?$reward[$student_sn]:0;
		$this_one="<tr align='center'><td>{$data['curr_class']}</td><td>{$data['curr_no']}</td><td>$stud_id</td><td>{$data['stud_name']}</td>";
		foreach($show_ss as $key=>$value){
			$bgcolor=$fin_score[$student_sn][$key]['avg']['score']<60?"bgcolor='#ffcccc'":"";
			$this_one.="<td $bgcolor>{$fin_score[$student_sn][$key]['avg']['score']}</td>";
		}		
		$bgcolor=($succ>=$area_base_count)?"":"bgcolor='#ffcccc'";
		$bgcolor_reward=$reward[$student_sn]<=$reward_base_score?"":"bgcolor='#ffcccc'";
		$bgcolor_abs=$abs_data_arr[$stud_id]<$abs_base_days?"":"bgcolor='#ffcccc'";
		$this_one.="<td $bgcolor>$succ</td><td $bgcolor_reward>{$reward[$student_sn]}</td><td $bgcolor_abs>$abs_data</td></tr>";

		$succ_count[$succ]++;
		if($stud_filter) $student_data.=$this_one; else if($succ<$area_base_count or $reward_score<$reward_base_score or $abs_data_arr[$stud_id]>=$abs_base_days) { $student_data.=$this_one; $digrad_sn_list.="$student_sn,"; }
	}
	$digrad_sn_list=substr($digrad_sn_list,0,-1);
	$student_data.="</table>";
	
	$area_count="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1' width='100%'><tr bgcolor='#CCFFCC' align='center'><td>�����H�W�ǲ߻��F����</td><td>�H�Ʋέp</td></tr>";
	foreach($succ_count as $key=>$value) {
		$area_count.="<tr align='center'><td>$key</td><td>$value</td></tr>";	
	}
	$area_count.="</table><br>";
	
	
} else $err_msg="<hr><center><font color='red'>���Ф��n�ѰO��J�ư��B�m�ҡB���|�ʮu��ƭ׷~�P�w��Ǽƭ��o�I</font></center><hr>";
if($digrad_sn_list and !$stud_filter) $enable_disgrad="<input type='hidden' name='digrad_sn' value='$digrad_sn_list'><input type='submit' name='write' value='�g�J�׷~�W��' onclick='return confirm(\"�T�w�n�g�J�H �g�J�e�|���N���~�׭�]�w�M�šI\")'>";
echo "<form name='myform' method='post'>$description $grad_year_radio $year_semester_list<br>$stud_filter_radio<br>$area_base_count_text<br>$reward_base_score_text<br>$abs_base_days_text <input type='submit' name='act' value='�έp���'>$enable_disgrad $area_count $student_data</form>$err_msg";

foot();
?>