<?php
// $Id: list.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";

sfs_check();

//�q�X����
head("�Z�žǥͼ��g����");
print_menu($menu_p);

if($is_rewrad) {
	$teacher_sn=$_SESSION['session_tea_sn']; //���o�n�J�Ѯv��id
	//��X���ЯZ��
	$class_name=teacher_sn_to_class_name($teacher_sn);
	$class_id=$class_name[0];
	
	//�Ǵ��O
	$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());
	if($class_id)
	{
		$studentdata='';
		//���ostud_base���Z�žǥͦC��þڥH�P�esql��ӫ����
		$sql="SELECT a.student_sn,a.seme_num,b.stud_name,b.stud_sex FROM stud_seme a LEFT JOIN stud_base b on a.student_sn=b.student_sn WHERE a.seme_class='$class_id' AND a.seme_year_seme='$curr_year_seme' AND b.stud_study_cond=0 ORDER BY a.seme_num";
		$rs=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);		
		//�Hradio�e�{
		while(list($student_sn,$seme_num,$stud_name,$stud_sex)=$rs->FetchRow()) {
			$_POST['student_sn']=$_POST['student_sn']?$_POST['student_sn']:$student_sn;
			$sex_color=($stud_sex==1)?'#0000ff':'#ff0000';
			$checked=($student_sn==$_POST['student_sn'])?'checked':'';
			$seme_num=sprintf('%02d',$seme_num);
			$studentdata.="<input type='radio' name='student_sn' value='$student_sn' onclick=\"this.form.submit();\" $checked><font color='$sex_color'>($seme_num) $stud_name</font><br>";
		}
		$class_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size:9pt;' bordercolor='#111111' id='AutoNumber1'><tr><td bgcolor='#ccffff' align='center'>��{$class_name[1]}��</td></tr><tr><td>$studentdata</td></tr></table>";
		
		$reward_data="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size:9pt;' bordercolor='#111111'><tr align='center' bgcolor='#ccccff'><td>NO.</td><td>�Ǵ��O</td><td>���g���</td><td>���g���O</td><td>���g�ƥ�</td><td>���g�̾�</td><td>�P�L���</td></tr>";
		
		$reward_arr=array("1"=>"�ż��@��","2"=>"�ż��G��","3"=>"�p�\�@��","4"=>"�p�\�G��","5"=>"�j�\�@��","6"=>"�j�\�G��","7"=>"�j�\�T��","-1"=>"ĵ�i�@��","-2"=>"ĵ�i�G��","-3"=>"�p�L�@��","-4"=>"�p�L�G��","-5"=>"�j�L�@��","-6"=>"�j�L�G��","-7"=>"�j�L�T��");
		//������w�ǥͪ����g����
		$sql="SELECT * FROM reward WHERE student_sn={$_POST['student_sn']} ORDER BY reward_year_seme,reward_date";
		$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
		while(!$res->EOF)
		{
			$reward_kind=$res->fields['reward_kind'];
			$reward_cancel_date=$res->fields['reward_cancel_date'];
			$reward_year_seme=substr($res->fields['reward_year_seme'],0,-1).'-'.substr($res->fields['reward_year_seme'],-1);
			$recno++;
			$bgcolor=($reward_kind>0)?'#ccffcc':'#ffcccc';
			if($reward_cancel_date=='0000-00-00') $reward_cancel_date=''; else $bgcolor='#cccccc';
			$reward_data.="<tr bgcolor='$bgcolor' align='center'><td>$recno</td><td>$reward_year_seme</td><td>{$res->fields['reward_date']}</td><td>{$reward_arr[$res->fields['reward_kind']]}</td><td align='left'>{$res->fields['reward_reason']}</td><td align='left'>{$res->fields['reward_base']}</td><td>$reward_cancel_date</td></tr>";
			$res->MoveNext();
		}
		$reward_data.="</table>";
		
		$main="<form name='myform' method='post' action='$_SERVER[SCRIPT_NAME]'><table><tr valign='top'><td>$class_list</td><td>$reward_data</td></tr></table></form>";
		echo $main; 
	} else echo "�z�ëD�Z�žɮv�I";	
} else echo "�t�κ޲z�̥��]�w�Z�žɮv�i�[���ǥͼ��g�O���I";	
foot();

?>