<?php
// $Id: list.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";

sfs_check();

//�q�X����
head("�h���ǲ�");
print_menu($menu_p);

//�Ǵ��O
$work_year_seme=$_REQUEST['work_year_seme'];
if($work_year_seme=='') $work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());
$academic_year=substr($curr_year_seme,0,-1);
$work_year=substr($work_year_seme,0,-1);
$session_tea_sn=$_SESSION['session_tea_sn'];

$stud_class=$_REQUEST['stud_class'];
$selected_stud=$_POST['selected_stud'];
$edit_sn=$_POST['edit_sn'];

if($_POST['act']=='�έp���~�שҦ��}�C�ǥͦh���ǲߪ��Ť�'){
	//�쥻�~�שҦ��}�C�ǥͪ�student_sn
	$sn_array=get_student_list($work_year);
	//���žǲ�
	$score_balance_array=get_student_score_balance($sn_array);	
	//�w���{-����
	$association_array=get_student_association();
	//�w���{-�A�Ⱦǲ�
	$service_array=get_student_service();
	
	//�L�O�L�O��&���y�O��
	$fault_array=get_student_fault($sn_array);
	$reward_array=get_student_reward($sn_array);	
	
	//��s�Ť�
	foreach($sn_array as $key=>$student_sn){
		$sql="update 12basic_tcntc set score_balance_health='{$score_balance_array[$student_sn]['health']['bonus']}',score_balance_art='{$score_balance_array[$student_sn]['art']['bonus']}',score_balance_complex='{$score_balance_array[$student_sn]['complex']['bonus']}',
			score_association='{$association_array[$student_sn]['bonus']}',score_service='{$service_array[$student_sn]['bonus']}',
			score_fault='{$fault_array[$student_sn]}',score_reward='{$reward_array[$student_sn]}'
			where academic_year=$work_year AND student_sn=$student_sn AND editable='1'";
		/*
		//�H�U���t�X�����@�~SQL ( ����ΡB�A�Ⱦǲ߱��g�J��2�B3�� )
		$sql="update 12basic_tcntc set score_balance_health='{$score_balance_array[$student_sn]['health']}',score_balance_art='{$score_balance_array[$student_sn]['art']}',score_balance_complex='{$score_balance_array[$student_sn]['complex']}',
			score_association='2',score_service='3',
			score_fault='{$reward_array[$student_sn]['bonus'][1]}',score_reward='{$reward_array[$student_sn]['bonus'][2]}'
			where academic_year=$work_year AND student_sn=$student_sn AND editable='1'";
		*/
		$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
	}	
};

if($_POST['act']=='�M���Ҧ��}�C�ǥͦh���ǲߪ��Ť�'){
	$sql="update 12basic_tcntc set score_balance_health=NULL,score_balance_art=NULL,score_balance_complex=NULL,score_association=NULL,score_service=NULL,score_fault=NULL,score_reward=NULL
		where academic_year=$work_year AND editable='1'";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
};

if($_POST['act']=='�T�w�ק�'){
	//�M�w����
	$_POST['score_balance_health']=min($_POST['score_balance_health'],$balance_score);
	$_POST['score_balance_art']=min($_POST['score_balance_art'],$balance_score);
	$_POST['score_balance_complex']=min($_POST['score_balance_complex'],$balance_score);
	$_POST['score_association']=min($_POST['score_association'],$association_score_max);
	$_POST['score_service']=min($_POST['score_service'],$service_score_max);
	$_POST['score_fault']=min($_POST['score_fault'],$fault_none);
	$_POST['score_reward']=min($_POST['score_reward'],$reward_score_max);
	
	//��s
	$sql="update 12basic_tcntc set score_balance_health={$_POST['score_balance_health']},score_balance_art={$_POST['score_balance_art']},score_balance_complex={$_POST['score_balance_complex']},
		score_association={$_POST['score_association']},score_service={$_POST['score_service']},score_fault={$_POST['score_fault']},score_reward={$_POST['score_reward']}
		where academic_year=$work_year AND student_sn=$edit_sn AND editable='1'";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
	$edit_sn=0;
};

//��V������
$linkstr="work_year_seme=$work_year_seme&stud_class=$stud_class";
echo print_menu($MENU_P,$linkstr);

//���o�~�׻P�Ǵ����U�Կ��
$recent_semester=get_recent_semester_select('work_year_seme',$work_year_seme);

//��ܯZ��
$class_list=get_semester_graduate_select('stud_class',$work_year_seme,$graduate_year,$stud_class);

if($work_year==$academic_year) $tool_icon.=" <input type='submit' value='�έp���~�שҦ��}�C�ǥͦh���ǲߪ��Ť�' name='act' onclick='return confirm(\"���n���p��|�����[���ɶ��A�ݭ@�ߵ��ԡC�T�w�n���s\"+this.value+\"?\")'> 
											<input type='submit' value='�M���Ҧ��}�C�ǥͦh���ǲߪ��Ť�' name='act' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")'>";

$main="<form name='myform' method='post' action='$_SERVER[PHP_SELF]'><input type='hidden' name='edit_sn' value='$edit_sn'>$recent_semester $class_list $tool_icon <table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1' width='100%'>";
if($stud_class)
{
	//���o���w�Ǧ~�w�g�}�C���ǥͲM��
	$listed=get_student_list($work_year);
	
	//�ˬd�O�_���i�ק�������ѻP�K�վǥ�
	$editable_sn_array=get_editable_sn($work_year);
	//���o���w�Ǧ~�w�g�}�C���ǥͦh���ǲߪ�����
	$diversification_array=get_student_diversification($work_year);
	//���o�Z�žǥ�student_sn
	$stud_select="SELECT student_sn FROM stud_seme WHERE seme_year_seme='$work_year_seme' AND seme_class='$stud_class'";
	$recordSet=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);
	while(!$recordSet->EOF)
	{
		$sn=$recordSet->fields['student_sn'];
		$class_sn_arr[]=$sn;
		$recordSet->MoveNext();
	}
	$score_balance_array=get_student_score_balance($class_sn_arr);

	//���o�L�O�L�P���y����
	$reward_array=get_student_reward();
	
	//���ostud_base���Z�žǥͦC��þڥH�P�esql��ӫ����
	$stud_select="SELECT a.student_sn,a.seme_num,b.stud_name,b.stud_sex,b.stud_id,b.stud_study_year FROM stud_seme a INNER JOIN stud_base b ON a.student_sn=b.student_sn WHERE a.seme_year_seme='$work_year_seme' AND a.seme_class='$stud_class' AND b.stud_study_cond in (0,5) ORDER BY a.seme_num";
	$recordSet=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);
	$studentdata="<tr align='center' bgcolor='#ff8888'><td width=80 rowspan=2>�Ǹ�</td><td width=50 rowspan=2>�y��</td><td width=120 rowspan=2>�m�W</td><td width=$pic_width rowspan=2>�j�Y��</td><td colspan=3>���žǲ�</td><td colspan=2>�w���{</td><td rowspan=2>�L�O�L�O��</td><td rowspan=2>���y�O��</td><td rowspan=2>�Ť��έp</td><td rowspan=2>�Ƶ�</td>";
	$studentdata.="<tr align='center' bgcolor='#ff8888'><td width=50>����</td><td width=50>����</td><td width=50>��X</td><td width=50>����</td><td width=70>�A�Ⱦǲ�</td>";
	while(list($student_sn,$seme_num,$stud_name,$stud_sex,$stud_id,$stud_study_year)=$recordSet->FetchRow()) {
		$seme_num=sprintf('%02d',$seme_num);
		$stud_sex_color=($stud_sex==1)?"#CCFFCC":"#FFCCCC";
		
		$score_balance_health=$diversification_array[$student_sn]['score_balance_health'];
		$color_health=($score_balance_health==$score_balance_array[$student_sn]['health']['avg'])?'#ff0000':'#000000';
		
		
		$score_balance_art=$diversification_array[$student_sn]['score_balance_art'];
		$color_art=($score_balance_art==$score_balance_array[$student_sn]['art']['avg'])?'#ff0000':'#000000';
		
		$score_balance_complex=$diversification_array[$student_sn]['score_balance_complex'];
		$color_complex=($score_balance_complex==$score_balance_array[$student_sn]['complex']['avg'])?'#ff0000':'#000000';
		
		$score_association=$diversification_array[$student_sn]['score_association'];		
		$score_service=$diversification_array[$student_sn]['score_service'];
		$score_fault=$diversification_array[$student_sn]['score_fault'];
		$score_reward=$diversification_array[$student_sn]['score_reward'];
		$score=$diversification_array[$student_sn]['score'];
		$memo=$diversification_array['diversification_memo'];
	
		$java_script="";
		$action='';
		
		$my_pic=$pic_checked?get_pic($stud_study_year,$stud_id):'';

		
		if($student_sn==$edit_sn){
			$score_balance_health="<input type='text' name='score_balance_health' value='$score_balance_health' size=5>";
			$score_balance_art="<input type='text' name='score_balance_art' value='$score_balance_art' size=5>";
			$score_balance_complex="<input type='text' name='score_balance_complex' value='$score_balance_complex' size=5>";
			
			$score_association="<input type='text' name='score_association' value='$score_association' size=5>";
			$score_service="<input type='text' name='score_service' value='$score_service' size=5>";
			$score_fault="<input type='text' name='score_fault' value='$score_fault' size=5>";
			$score_reward="<input type='text' name='score_reward' value='$score_reward' size=5>";

			$memo="<input type='text' name='memo' value='$memo'>";
			//�ʧ@���s
			$action="<input type='submit' name='act' value='�T�w�ק�' onclick='return confirm(\"�T�w�n�ק� $stud_name ���h���ǲ߯Ť����?\")'> <input type='submit' name='act' value='����' onclick='document.myform.edit_sn.value=0;'>";		
			$stud_sex_color='#ffffaa';
		} else {
			if(array_key_exists($student_sn,$listed)){
				$editable=array_key_exists($student_sn,$editable_sn_array)?1:0;
				$stud_sex_color=$editable?$stud_sex_color:$uneditable_bgcolor;
				$java_script=($work_year==$academic_year and $editable and $diversification_editable)?"onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#aaaaff';\" onMouseOut=\"this.style.backgroundColor='$stud_sex_color';\" ondblclick='document.myform.edit_sn.value=\"$student_sn\"; document.myform.submit();'":'';
			} else { $stud_sex_color='#aaaaaa'; }
		}
		$bg_color_health=$score_balance_health?$stud_sex_color:'#cccccc';
		$bg_color_art=$score_balance_art?$stud_sex_color:'#cccccc';
		$bg_color_complex=$score_balance_complex?$stud_sex_color:'#cccccc';
		$bg_color_fault=$score_fault?$stud_sex_color:'#cccccc';
		$bg_color_reward=$score_reward?$stud_sex_color:'#cccccc';
		$bg_color_association=$score_association?$stud_sex_color:'#cccccc';
		$bg_color_service=$score_service?$stud_sex_color:'#cccccc';
		$studentdata.="<tr align='center' bgcolor='$stud_sex_color' $java_script><td>$stud_id</td><td>$seme_num</td><td>$stud_name</td><td>$my_pic</td>
					<td bgcolor='$bg_color_health'><b><font color='$color_health'>$score_balance_health</font></b><br>({$score_balance_array[$student_sn]['health']['avg']})</td>
					<td bgcolor='$bg_color_art'><b><font color='$color_art'>$score_balance_art</font></b><br>({$score_balance_array[$student_sn]['art']['avg']})</td>
					<td bgcolor='$bg_color_complex'><b><font color='$color_complex'>$score_balance_complex</font></b><br>({$score_balance_array[$student_sn]['complex']['avg']})</td>
					<td bgcolor='$bg_color_association'>$score_association</td><td bgcolor='$bg_color_service'>$score_service</td><td bgcolor='$bg_color_fault'>$score_fault</td><td bgcolor='$bg_color_reward'>$score_reward</td>
					<td><B>$score</B></td><td>$memo<br>$action</td></tr>";
	}
}

//��ܫʦs���A��T
echo get_sealed_status($work_year).'<br>';

echo $main.$studentdata."</form></table>";
foot();
?>