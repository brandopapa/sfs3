<?php
// $Id$
include "config.php";
include "../../include/sfs_case_studclass.php";

sfs_check();

//�Ǵ��O
$work_year_seme=$_REQUEST['work_year_seme'];
if($work_year_seme=='') $work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());
$academic_year=substr($curr_year_seme,0,-1);
$work_year=substr($work_year_seme,0,-1);
$session_tea_sn=$_SESSION['session_tea_sn'];
$stud_class=$_REQUEST['stud_class'];
$selected_stud=$_POST['selected_stud'];		//���o��ܶ}�C���Z�ҩ���ǥͽs���}�C

//��X�n���f�d��
if($selected_stud && $_POST['act']=='��X�n���f�d��') {
	$data="";
	foreach($selected_stud as $student_key=>$student_sn) {
		//�d�ߦU�����Z�ҩ����
		$student_data=get_student_data($work_year);		//���o�ǥͰ򥻸��
		$domicile_data=get_domicile_data($work_year);		//���o���@�H���
		$final_data=get_final_data($work_year);		//���o12basic_ylc�������
		$reward_data=count_student_reward($student_sn);		//���o�ǥ;��~�Ǵ����g����
		$absence_data=count_student_seme_abs($student_data[$student_sn]['stud_id']);		//���o�ǥ;��~�Ǵ��X�ʮu����
		$balance=get_student_score_balance($student_sn);		//�ǥ;��~�Ǵ����žǲߤ���-����health,����art,��Xcomplex
		$fitness=get_student_score_fitness($student_sn);		//�ǥ;��~�Ǵ���A�����
		$competetion=get_student_score_competetion($student_sn);		//�ǥ;��~�Ǵ��v�ɬ���
		$reward_list=get_student_reward_list($student_sn);		//�ǥͼ��g����
		//���Y
		if(next($selected_stud)==true) $p_break="page-break-after:always;"; else $p_break="";
		$data.="<div align='center' style='{$p_break}'><div align='left' style='width:1000px;line-height:30px;letter-spacing:1px;'>";
		$data.="<div align='right' style='font-size:14pt;'>�s���G<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></div>";
		$data.="<div align='center' style='padding:30px 0 40px 0; font-size:20pt;'>".(date('Y')-1911)."�~���L�ϰ��Ť����ǮէK�դJ�ǶW�B��ǿn���f�d��</div>";
		//�ǥͰ򥻸��
		$stud_school_name=$SCHOOL_BASE['sch_cname_s'];		//�զW
		$stud_seme_class="�T�~<u>&nbsp;&nbsp;&nbsp;".class_id_to_c_name(student_sn_to_class_id($student_sn,$work_year))."&nbsp;&nbsp;&nbsp;</u>�Z";		//�Z��
		$stud_seme_num=student_sn_to_site_num($student_sn);		//�y��
		$stud_name=str_replace(' ','',$student_data[$student_sn]['stud_name']);		//�m�W
		$data.="<div align='center' style='font-size:14pt;'>�զW�G<u>&nbsp;&nbsp;&nbsp;".$stud_school_name."&nbsp;&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$stud_seme_class."<u>&nbsp;&nbsp;&nbsp;".$stud_seme_num."&nbsp;&nbsp;&nbsp;</u>��&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�ǥͩm�W�G<u>&nbsp;&nbsp;&nbsp;".$stud_name."&nbsp;&nbsp;&nbsp;</u></div>";
		//�f�d����(�����D)
		$data.="<table border='2' cellpadding='3' cellspacing='0' style='width:100%; font-size:14pt; line-height:30px; letter-spacing:1px; border-collapse:collapse;' bordercolor='#111111'>";
		$data.="<tr align='center' style='font-size:14pt;'><th width='8%' style='padding:5px 5px;'>�f�d����</th><th width='46%' style='padding:5px 5px;'>�Ǯժ�f</th><th width='46%' style='padding:5px 5px;' colspan='2'>�e���|�Ƽf�N��</th></tr>";
		//�����p��
		$stud_school_remote=$final_data[$student_sn]['score_remote'];		//�����p�տn��
		$stud_move_date_y='';
		$stud_move_date_m='';
		$stud_move_date_d='';
		if($school_remote>0){		//��ǥ�
			$sql_move="SELECT move_date FROM stud_move WHERE student_sn=$student_sn AND move_kind=2";
			$res_move=$CONN->Execute($sql_move) or user_error("Ū�����ѡI<br>$sql_move",256);
			if($res_move->recordcount()>0){
				$move_date=explode("-",$res_move->fields['move_date']);
				$stud_move_date_y=$move_date[0]-1911;
				$stud_move_date_m=$move_date[1];
				$stud_move_date_d=$move_date[2];
			}
		}
		$data.="<th width='8%' align='center' style='padding:20px 10px;'>����<br>�p��</th>";
		$data.="<td width='46%' style='padding:20px 10px;'>
					<p>".(($school_remote>0)?'��':'��')."�ŦX�����p�ո��G<u>&nbsp;&nbsp;&nbsp;".(($school_remote>0)?$stud_school_remote:'')."&nbsp;&nbsp;&nbsp;</u>��<br>&nbsp;&nbsp;".(($school_remote==2)?'��':'��')."7�Z�H�U<br>&nbsp;&nbsp;".(($school_remote==1)?'��':'��')."8-12�Z<br>&nbsp;&nbsp;".((($school_remote>0)&&($res_move->recordcount()>0))?'��':'��')."��ǥ͡G<u>&nbsp;&nbsp;".$stud_move_date_y."&nbsp;&nbsp;</u>�~<u>&nbsp;&nbsp;".$stud_move_date_m."&nbsp;&nbsp;</u>��<u>&nbsp;&nbsp;".$stud_move_date_d."&nbsp;&nbsp;</u>����J<br>&nbsp;&nbsp;".((($school_remote>0)&&($res_move->recordcount()==0))?'��':'��')."�D��ǥ�</p>
					<p>".(($school_remote>0)?'��':'��')."���ŦX�����p�ո��</p>
				</td>";
		$data.="<td width='46%' valign='top' style='padding:20px 10px;' colspan='2'>
					<p>���ŦX�G<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>��</p>
					<p>�����ŦX�G<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>��</p>
				</td>";
		$data.="</tr>";
		
		//���y����
                  $f = explode(",",$reward_semester);
                  $grade71=substr($f[0],1,-1);
                  $grade72=substr($f[1],1,-1);
                  $grade81=substr($f[2],1,-1);
                  $grade82=substr($f[3],1,-1);
                  $grade91=substr($f[4],1,-1);
                  if($absence_data[$grade71]=='') $absence_data[$grade71]=0;
                  if($absence_data[$grade72]=='') $absence_data[$grade72]=0;
                  if($absence_data[$grade81]=='') $absence_data[$grade81]=0;
                  if($absence_data[$grade82]=='') $absence_data[$grade82]=0;
                  if($absence_data[$grade91]=='') $absence_data[$grade91]=0;

		$data.="<tr align='left' ;><th width='8%' align='center' style='padding:20px 10px;'>���y<br>����</th>";
	$data.="<th width='46%' >�j�\<u>&nbsp;&nbsp;&nbsp;&nbsp;".($reward_data[$grade71][9]+$reward_data[$grade72][9]+$reward_data[$grade81][9]+$reward_data[$grade82][9]+$reward_data[$grade91][9])."&nbsp;&nbsp;&nbsp;&nbsp;</u>��B�p�\<u>&nbsp;&nbsp;&nbsp;&nbsp;".($reward_data[$grade71][3]+$reward_data[$grade72][3]+$reward_data[$grade81][3]+$reward_data[$grade82][3]+$reward_data[$grade91][3])."&nbsp;&nbsp;&nbsp;&nbsp;</u>��B�ż�<u>&nbsp;&nbsp;&nbsp;&nbsp;".($reward_data[$grade71][1]+$reward_data[$grade72][1]+$reward_data[$grade81][1]+$reward_data[$grade82][1]+$reward_data[$grade91][1])."&nbsp;&nbsp;&nbsp;&nbsp;</u>��<p>�o��<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$final_data[$student_sn]['score_reward']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>��</th><th width='46%' colspan='2'>�j�\<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>��B�p�\<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>��B�ż�<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>��<p>�o��<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>��</th></tr>";

		//�v�ɦ��Z
		$data.="<tr align='left'>";
		$data.="<th rowspan='4' width='8%' align='center' style='padding:5px 5px;'>�v��<br>���Z</th>";
		$data.="<td width='46%'>
					<p>�����<br>&nbsp;&nbsp;���w�ǤJ���y����<br>&nbsp;&nbsp;�����ǤJ���y����<br>&nbsp;&nbsp;���ŦX�ĭp���ءG<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>��<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>��</p>
				</td>";
		$data.="<td width='46%' colspan='2'>
					<p>�����<br>&nbsp;&nbsp;�����Ʊĭp<br>&nbsp;&nbsp;�������Ʊĭp<br>&nbsp;&nbsp;���ŦX�ĭp���ءG<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>��<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>��</p>
				</td>";
		$data.="</tr>";
		$data.="<tr>";
		$data.="<td width='46%'>
					<p>������<br>&nbsp;&nbsp;���w�ǤJ���y����<br>&nbsp;&nbsp;�����ǤJ���y����<br>&nbsp;&nbsp;���ŦX�ĭp���ءG<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>��<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>��</p>
				</td>
				<td colspan='2' width='46%'>
					<p>������<br>&nbsp;&nbsp;�����Ʊĭp<br>&nbsp;&nbsp;�������Ʊĭp<br>&nbsp;&nbsp;���ŦX�ĭp���ءG<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>��<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>��</p>
				</td>";
		$data.="</tr>";
		$data.="<tr>";
		$data.="<td width='46%'>
					<p>����<br>&nbsp;&nbsp;���w�ǤJ���y����<br>&nbsp;&nbsp;�����ǤJ���y����<br>&nbsp;&nbsp;���ŦX�ĭp���ءG<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>��<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>��</p>
				</td>
				<td colspan='2' width='46%'>
					<p>����<br>&nbsp;&nbsp;�����Ʊĭp<br>&nbsp;&nbsp;�������Ʊĭp<br>&nbsp;&nbsp;���ŦX�ĭp���ءG<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>��<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>��</p>
				</td>";
		$data.="</tr>";
		$data.="<tr>";
		$data.="<td width='46%'>
					<p style='margin-top:15px;'>�v�ɦ��Z�o���G<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>��</p>
				</td>
				<td colspan='2' width='46%'>
					<p style='margin-top:15px;'>�v�ɦ��Z�o���G<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>��</p>
				</td>";
		$data.="</tr>";
		//�n��
		$reward_competetion_fitness_score=$final_data[$student_sn]['score_reward']+$final_data[$student_sn]['score_competetion']+$final_data[$student_sn]['score_fitness'];		//���y+�v��+��A�����
		if ($reward_competetion_fitness_score < $reward_competetion_fitness_score_max)
		$reward_competetion_fitness_score=$reward_competetion_fitness_score; 
		else 
		$reward_competetion_fitness_score=$reward_competetion_fitness_score_max;
				//�P�_���y+�v��+��A����ƬO�_�W�L25��
		
		$stud_score=$final_data[$student_sn]['score_disadvantage']+$final_data[$student_sn]['score_remote']+$final_data[$student_sn]['score_nearby']+$final_data[$student_sn]['score_absence']+$final_data[$student_sn]['score_fault']+$final_data[$student_sn]['score_balance_health']+$final_data[$student_sn]['score_balance_art']+$final_data[$student_sn]['score_balance_complex']+$reward_competetion_fitness_score;    		//105�~�n����k
		//$stud_score=$final_data[$student_sn]['score_disadvantage']+$final_data[$student_sn]['score_remote']+$final_data[$student_sn]['score_nearby']+$final_data[$student_sn]['score_reward']+$final_data[$student_sn]['score_absence']+$final_data[$student_sn]['score_fault']+$final_data[$student_sn]['score_balance_health']+$final_data[$student_sn]['score_balance_art']+$final_data[$student_sn]['score_balance_complex']+$final_data[$student_sn]['score_competetion']+$final_data[$student_sn]['score_fitness'];		//104�~�e�n����k
		$data.="<tr align='left'><th width='8%' align='center' style='padding:30px 10px;'>�n��</th><td width='46%' style='padding:20px 10px;'>���t�|�ҤΧ��@�ǿn���G<u>&nbsp;&nbsp;&nbsp;".$stud_score."&nbsp;&nbsp;&nbsp;</u>��</td><td width='46%' style='padding:20px 10px;' colspan='2'>���t�|�ҤΧ��@�ǿn���G<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>��</td></tr>";
		//�f�d�H���ֳ�
		$data.="<tr align='left'>";
		$data.="<th rowspan='5' width='8%' align='center' style='padding:30px 10px;'>�f�d<br>�H��<br>�ֳ�</th>
				<td width='46%' align='center'>�ꤤ��</td>
				<td width='46%' align='center' colspan='2'>�K�թe���|�f�d�p��</td>";
		$data.="</tr>";
		$data.="<tr>";
		$data.="<td rowspan='4' align='center' valign='bottom' width='46%'>
				�]�ֳ��H���U�զۭq�^
				</td>
				<td width='6%' align='center'>��</td><td width='40%'>&nbsp;</td>";
		$data.="</tr>";
		$data.="<tr>";
		$data.="<td width='6%' align='center'>��</td><td width='40%'>&nbsp;</td>";
		$data.="</tr>";
		$data.="<tr>";
		$data.="<td align='center' colspan='2' width='46%'>�Ƽf���G</td>";
		$data.="</tr>";
		$data.="<tr>";
		$data.="<td colspan='2' width='46%' valign='top' style='height:180px;'>
					<p style='padding-left:10px;'>���q�L<br>�����q�L<br>�@��]�G<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>&nbsp;<br>�@�@�@�@<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></p>
				</td>";
		$data.="</tr>";
		//���
		$data.="</table>";
		$data.="</div></div>";
	}
	echo $data;
	exit;
}

//�q�X����
head("�n���f�d��");
print_menu($menu_p);
echo <<<HERE
<script>
function tagall(status) {
  var i =0;
  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].name=='selected_stud[]') {
      document.myform.elements[i].checked=status;
    }
    i++;
  }
}
</script>
HERE;

//��V������
$linkstr="work_year_seme=$work_year_seme&stud_class=$stud_class";
echo print_menu($MENU_P,$linkstr);

//���o�~�׻P�Ǵ����U�Կ��
$recent_semester=get_recent_semester_select('work_year_seme',$work_year_seme);

//��ܯZ��
$class_list=get_semester_graduate_select('stud_class',$work_year_seme,$graduate_year,$stud_class);

//�\����
if($stud_class && $work_year_seme==$curr_year_seme) {
	$tool_icon="<input type='button' name='all_stud' value='����' onClick='javascript:tagall(1);'><input type='button' name='clear_stud'  value='������' onClick='javascript:tagall(0);'>�@";
	$tool_icon.="<font size=2>�@���G���ѻP�K�վǥ͡@�@</font>";
	$tool_icon.="<input type='submit' name='act' value='��X�n���f�d��' onclick=\"document.myform.target='ts{$academic_year}'\">";
}

$main="<form name='myform' method='post' action='$_SERVER[SCRIPT_NAME]'>$recent_semester $class_list $tool_icon";

//���X�ǥͦW��
$data="";
if($stud_class)
{
	//���o���w�Ǧ~�w�g�}�C���ǥͲM��
	$listed=get_student_list($work_year);
	//���ostud_base���Z�žǥͦC��þڥH�P�esql��ӫ����
	$data.="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1' width='100%'>";
	//$sql="SELECT a.student_sn,b.stud_id,b.stud_name,b.stud_sex,c.seme_num FROM 12basic_ylc AS a ,stud_base AS b, stud_seme AS c WHERE a.student_sn=b.student_sn AND a.student_sn=c.student_sn AND a.academic_year='{$academic_year}' AND c.seme_year_seme='{$work_year_seme}' AND c.seme_class='{$stud_class}' ORDER BY c.seme_num";
	$stud_select="SELECT a.student_sn,a.seme_num,b.stud_name,b.stud_sex,b.stud_id,b.stud_study_year FROM stud_seme a inner join stud_base b on a.student_sn=b.student_sn WHERE a.seme_year_seme='$work_year_seme' AND a.seme_class='$stud_class' AND b.stud_study_cond in (0,5) ORDER BY a.seme_num";
	$recordSet=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);
	$col=7; //�]�w�C�@�C��ܴX�H
	while(list($student_sn,$seme_num,$stud_name,$stud_sex,$stud_id,$stud_study_year)=$recordSet->FetchRow()) {
		if($pic_checked) $my_pic=get_pic($stud_study_year,$stud_id);		//�j�Y��
		if($recordSet->currentrow() % $col==1) $data.="<tr align='center'>";
		$stud_bgcolor=($stud_sex==1)?"#EEFFEE":"#FFEEEE";
		if(array_key_exists($student_sn,$listed)) {
			$checkable="<input type='checkbox' name='selected_stud[]' value='{$student_sn}'>";
		} else {
			$checkable="��";
			$stud_bgcolor="#FFFFDD";
		}
		$data.="<td bgcolor='{$stud_bgcolor}'>{$my_pic} {$checkable} (".sprintf('%02d',$seme_num)."){$stud_name}</td>";
		if($recordSet->currentrow() % $col==0  or $res->EOF) $data.="</tr>";
	}
	$data.="</table>";
}

$main.=$data."</form>";
echo $main;

foot();
?>
