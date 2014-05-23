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

//��X���Z�ҩ���
if($selected_stud && $_POST['act']=='��X���Z�ҩ���') {
	$data="";
	foreach($selected_stud as $student_key=>$student_sn) {
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
		$data.="<div align='center' style='page-break-after:always;'><div align='left' style='width:1000px;line-height:30px;'>";
		$data.="<div align='center' style='padding:20px 0 0px 0; font-size:20pt;'>���L���u�Q�G�~����򥻱Ш|�K�դJ�ǶW�B��Ƕ��ءv���Z�ҩ���</div>";
		//��@�G�ǥͰ򥻸��
		$stud_name=str_replace(' ','',$student_data[$student_sn]['stud_name']);		//�m�W
		$stud_school_name=$SCHOOL_BASE['sch_cname_s'];		//���~�Ǯ�
		$stud_school_remote=$final_data[$student_sn]['score_remote'];		//�����p��
		$stud_person_id=$student_data[$student_sn]['stud_person_id'];		//�����Ҹ�
		$stud_seme_class="�T�~".class_id_to_c_name(student_sn_to_class_id($student_sn,$work_year))."�Z";		//�NŪ�Z��
		$stud_school_nature=$final_data[$student_sn]['score_nearby'];		//�N��J��
		$stud_birth=sprintf('%02d',$student_data[$student_sn]['birth_year'])."�~".sprintf('%02d',$student_data[$student_sn]['birth_month'])."��".sprintf('%02d',$student_data[$student_sn]['birth_day'])."��";		//�X�ͦ~���
		$stud_graduation_year=$work_year;		//���~�~
		$stud_sex=($student_data[$student_sn]['stud_sex']==1)?"�k":"�k";		//�ʧO
		$stud_disadvantage=$final_data[$student_sn]['score_disadvantage'];		//�g�ٮz��
		$guardian_name=$domicile_data[$student_sn]['guardian_name'];		//���@�H
		if($student_data[$student_sn]['stud_tel_2']!='') $stud_telphone=$student_data[$student_sn]['stud_tel_2']; elseif($student_data[$student_sn]['stud_tel_3']!='') $stud_telphone=$student_data[$student_sn]['stud_tel_3']; else $stud_telphone=$student_data[$student_sn]['stud_tel_1'];		//�p���q��
		$stud_score=$final_data[$student_sn]['score_disadvantage']+$final_data[$student_sn]['score_remote']+$final_data[$student_sn]['score_nearby']+$final_data[$student_sn]['score_reward']+$final_data[$student_sn]['score_absence']+$final_data[$student_sn]['score_fault']+$final_data[$student_sn]['score_balance_health']+$final_data[$student_sn]['score_balance_art']+$final_data[$student_sn]['score_balance_complex']+$final_data[$student_sn]['score_competetion']+$final_data[$student_sn]['score_fitness'];		//�i�o����
		$addr_zip=$student_data[$student_sn]['addr_zip']?'('.$student_data[$student_sn]['addr_zip'].')':'';
		$stud_address=$student_data[$student_sn]['stud_addr_2']?$student_data[$student_sn]['stud_addr_2']:$student_data[$student_sn]['stud_addr_1'];		//�q�T�B
		$data.="<div style='margin:20px 0;'>";
		$data.="<span style='font-size:18pt;'>�@�B�ǥͰ򥻸�ơG</span>";
		$data.="<table border='2' cellpadding='3' cellspacing='0' style='width:100%; font-size:15pt; border-collapse:collapse;' bordercolor='#111111'>";
		$data.="<tr align='center'><th>�m�W</th><th>�X�ͦ~���</th><th>�ʧO</th><th>�����Ҹ�</th><th>���@�H</th><th>�p���q��</th><th>�Ƶ�</th></tr>";
		$data.="<tr align='center'><td>{$stud_name}</td><td>{$stud_birth}</td><td>{$stud_sex}</td><td>{$stud_person_id}</td><td>{$guardian_name}</td><td>{$stud_telphone}</td><td></td></tr>";
		$data.="<tr align='center'><th>��(�w)�~�Ǯ�</th><th>�NŪ�Z��</th><th>���~�Ǧ~��</th><th>�N��J��</th><th>�����p��</th><th>�g�ٮz��</th><th>�o��</th></tr>";
		$data.="<tr align='center'><td>{$stud_school_name}</td><td>{$stud_seme_class}</td><td>{$stud_graduation_year}</td><td>{$stud_school_nature}</td><td>{$stud_school_remote}</td><td>{$stud_disadvantage}</td><td>{$stud_score}</td></tr>";
		$data.="<tr align='center'><th>�q�T�B</th><td align='left' colspan='6'>{$addr_zip}{$stud_address}</td></tr>";
		$data.="</table></div>";
		//��G�G�~�w�A��
		$f = explode(",",$reward_semester);
		$grade71=substr($f[0],1,-1);
		$grade72=substr($f[1],1,-1);
		$grade81=substr($f[2],1,-1);
		$grade82=substr($f[3],1,-1);
		$grade91=substr($f[4],1,-1);
		$data.="<div style='margin:20px 0;'>";
		$data.="<span style='font-size:18pt;'>�G�B�~�w�A�ȡG</span><br><span style='font-size:15pt;'>1.���y�����G�j�\\3���B�p�\\1���B�ż�0.3���A�̰�10���C<br>2.�X�ʮu�����G�L�m�Ҫ�5���B�m��1��5�`��3���B�m��6��10�`��1���C<br>3.�L�O�L�����G�Lĵ�i�H�W������(�t�P�L��)5���B�P�L��L�ֿn�ܤp�L(�t)�H�W��1���C</span>";
		$data.="<table border='2' cellpadding='3' cellspacing='0' style='width:100%; font-size:14pt; border-collapse:collapse;' bordercolor='#111111'>";
		$data.="<tr align='center'><th rowspan='2'>�~��</th><th rowspan='2'>�Ǵ�</th><th colspan='3'>���y����</th><th>�X�ʮu</th><th colspan='3'>�g�B����</th></tr>";
		$data.="<tr align='center'><th>�j�\\</th><th>�p�\\</th><th>�ż�</th><th>�`��</th><th>ĵ�i</th><th>�p�L</th><th>�j�L</th></tr>";
		$data.="<tr align='center'><td>7-1</td><td>{$grade71}</td><td>{$reward_data[$grade71][9]}</td><td>{$reward_data[$grade71][3]}</td><td>{$reward_data[$grade71][1]}</td><td bgcolor='#D6D3D6'></td><td bgcolor='#D6D3D6'></td><td bgcolor='#D6D3D6'></td><td bgcolor='#D6D3D6'></td></tr>";
		$data.="<tr align='center'><td>7-2</td><td>{$grade72}</td><td>{$reward_data[$grade72][9]}</td><td>{$reward_data[$grade72][3]}</td><td>{$reward_data[$grade72][1]}</td><td bgcolor='#D6D3D6'></td><td bgcolor='#D6D3D6'></td><td bgcolor='#D6D3D6'></td><td bgcolor='#D6D3D6'></td></tr>";
		$data.="<tr align='center'><td>8-1</td><td>{$grade81}</td><td>{$reward_data[$grade81][9]}</td><td>{$reward_data[$grade81][3]}</td><td>{$reward_data[$grade81][1]}</td><td>{$absence_data[$grade81]}</td><td>{$reward_data[$grade81][-1]}</td><td>{$reward_data[$grade81][-3]}</td><td>{$reward_data[$grade81][-9]}</td></tr>";
		$data.="<tr align='center'><td>8-2</td><td>{$grade82}</td><td>{$reward_data[$grade82][9]}</td><td>{$reward_data[$grade82][3]}</td><td>{$reward_data[$grade82][1]}</td><td>{$absence_data[$grade82]}</td><td>{$reward_data[$grade82][-1]}</td><td>{$reward_data[$grade82][-3]}</td><td>{$reward_data[$grade82][-9]}</td></tr>";
		$data.="<tr align='center'><td>9-1</td><td>{$grade91}</td><td>{$reward_data[$grade91][9]}</td><td>{$reward_data[$grade91][3]}</td><td>{$reward_data[$grade91][1]}</td><td>{$absence_data[$grade91]}</td><td>{$reward_data[$grade91][-1]}</td><td>{$reward_data[$grade91][-3]}</td><td>{$reward_data[$grade91][-9]}</td></tr>";
		$data.="<tr align='center'><th colspan='2'>��L�P�L����</th><td bgcolor='#D6D3D6'></td><td bgcolor='#D6D3D6'></td><td bgcolor='#D6D3D6'></td><td bgcolor='#D6D3D6'></td><td>{$reward_data['fault_cancel'][-1]}</td><td>{$reward_data['fault_cancel'][-3]}</td><td>{$reward_data['fault_cancel'][-9]}</td></tr>";
		$data.="<tr align='center'><th colspan='2'>�X�p</th><td>".($reward_data[$grade71][9]+$reward_data[$grade72][9]+$reward_data[$grade81][9]+$reward_data[$grade82][9]+$reward_data[$grade91][9])."</td><td>".($reward_data[$grade71][3]+$reward_data[$grade72][3]+$reward_data[$grade81][3]+$reward_data[$grade82][3]+$reward_data[$grade91][3])."</td><td>".($reward_data[$grade71][1]+$reward_data[$grade72][1]+$reward_data[$grade81][1]+$reward_data[$grade82][1]+$reward_data[$grade91][1])."</td><td>".($absence_data[$grade81]+$absence_data[$grade82]+$absence_data[$grade91])."</td><td>".($reward_data[$grade81][-1]+$reward_data[$grade82][-1]+$reward_data[$grade91][-1]-$reward_data['fault_cancel'][-1])."</td><td>".($reward_data[$grade81][-3]+$reward_data[$grade82][-3]+$reward_data[$grade91][-3]-$reward_data['fault_cancel'][-3])."</td><td>".($reward_data[$grade81][-9]+$reward_data[$grade82][-9]+$reward_data[$grade91][-9]-$reward_data['fault_cancel'][-9])."</td></tr>";
		$data.="<tr align='center'><th colspan='2'>�o��</th><td colspan='3'>{$final_data[$student_sn]['score_reward']}</td><td>{$final_data[$student_sn]['score_absence']}</td><td colspan='3'>{$final_data[$student_sn]['score_fault']}</td></tr>";
		$data.="</table></div>";
		//��T�G�h���ǲ�
		$data.="<div style='margin:20px 0;'>";
		$data.="<span style='font-size:18pt;'>�T�B�h���ǲߡG</span><br><span style='font-size:15pt;'>1.�ʿžǲߡG���N�P�H��B���d�P��|�B��X���ʾǴ��`�������Z�ή�̡A�C�@��쵹3���C<br>2.��A��G���賹7���B�Ƚ賹6���B�ɽ賹5���B2-4���F25%��4���B1���F25%��2���C<br>3.�v�ɪ�{�G�̰�7���C</span>";
		$data.="<table border='2' cellpadding='3' cellspacing='0' style='width:100%; font-size:14pt; border-collapse:collapse;' bordercolor='#111111'>";
		$data.="<tr align='center'><th rowspan='2'>�~��</th><th rowspan='2'>�Ǵ�</th><th colspan='3'>���žǲ�</th><th colspan='5'>��A��</th></tr>";
		$data.="<tr align='center'><th>���N�P�H��</th><th>���d�P��|</th><th>��X����</th><th>�����e�s<br>(cm)[%]</th><th>�ߩw����<br>(cm)[%]</th><th>���װ_��<br>(��)[%]</th><th>�ߪ;A��<br>(��)[%]</th><th>����</th></tr>";
		$data.="<tr align='center'><td>7-1</td><td>{$grade71}</td><td>{$balance['art'][$grade71]}</td><td>{$balance['health'][$grade71]}</td><td>{$balance['complex'][$grade71]}</td><td>{$fitness[$grade71]['test1']}[{$fitness[$grade71]['prec1']}]</td><td>{$fitness[$grade71]['test3']}[{$fitness[$grade71]['prec3']}]</td><td>{$fitness[$grade71]['test2']}[{$fitness[$grade71]['prec2']}]</td><td>{$fitness[$grade71]['test4']}[{$fitness[$grade71]['prec4']}]</td><td>{$fitness_medal[$fitness[$grade71]['medal']]}</td></tr>";
		$data.="<tr align='center'><td>7-2</td><td>{$grade72}</td><td>{$balance['art'][$grade72]}</td><td>{$balance['health'][$grade72]}</td><td>{$balance['complex'][$grade72]}</td><td>{$fitness[$grade72]['test1']}[{$fitness[$grade72]['prec1']}]</td><td>{$fitness[$grade72]['test3']}[{$fitness[$grade72]['prec3']}]</td><td>{$fitness[$grade72]['test2']}[{$fitness[$grade72]['prec2']}]</td><td>{$fitness[$grade72]['test4']}[{$fitness[$grade72]['prec4']}]</td><td>{$fitness_medal[$fitness[$grade72]['medal']]}</td></tr>";
		$data.="<tr align='center'><td>8-1</td><td>{$grade81}</td><td>{$balance['art'][$grade81]}</td><td>{$balance['health'][$grade81]}</td><td>{$balance['complex'][$grade81]}</td><td>{$fitness[$grade81]['test1']}[{$fitness[$grade81]['prec1']}]</td><td>{$fitness[$grade81]['test3']}[{$fitness[$grade81]['prec3']}]</td><td>{$fitness[$grade81]['test2']}[{$fitness[$grade81]['prec2']}]</td><td>{$fitness[$grade81]['test4']}[{$fitness[$grade81]['prec4']}]</td><td>{$fitness_medal[$fitness[$grade81]['medal']]}</td></tr>";
		$data.="<tr align='center'><td>8-2</td><td>{$grade82}</td><td>{$balance['art'][$grade82]}</td><td>{$balance['health'][$grade82]}</td><td>{$balance['complex'][$grade82]}</td><td>{$fitness[$grade82]['test1']}[{$fitness[$grade82]['prec1']}]</td><td>{$fitness[$grade82]['test3']}[{$fitness[$grade82]['prec3']}]</td><td>{$fitness[$grade82]['test2']}[{$fitness[$grade82]['prec2']}]</td><td>{$fitness[$grade82]['test4']}[{$fitness[$grade82]['prec4']}]</td><td>{$fitness_medal[$fitness[$grade82]['medal']]}</td></tr>";
		$data.="<tr align='center'><td>9-1</td><td>{$grade91}</td><td>{$balance['art'][$grade91]}</td><td>{$balance['health'][$grade91]}</td><td>{$balance['complex'][$grade91]}</td><td>{$fitness[$grade91]['test1']}[{$fitness[$grade91]['prec1']}]</td><td>{$fitness[$grade91]['test3']}[{$fitness[$grade91]['prec3']}]</td><td>{$fitness[$grade91]['test2']}[{$fitness[$grade91]['prec2']}]</td><td>{$fitness[$grade91]['test4']}[{$fitness[$grade91]['prec4']}]</td><td>{$fitness_medal[$fitness[$grade91]['medal']]}</td></tr>";
		$data.="<tr align='center'><th colspan='2'>����</th><td>{$balance['art']['avg']}</td><td>{$balance['health']['avg']}</td><td>{$balance['complex']['avg']}</td><td bgcolor='#D6D3D6'></td><td bgcolor='#D6D3D6'></td><td bgcolor='#D6D3D6'></td><td bgcolor='#D6D3D6'></td><td>{$fitness_medal[$fitness['avg']['medal']]}</td></tr>";
		$data.="<tr align='center'><th colspan='2'>�o��</th><td>{$final_data[$student_sn]['score_balance_art']}</td><td>{$final_data[$student_sn]['score_balance_health']}</td><td>{$final_data[$student_sn]['score_balance_complex']}</td><td bgcolor='#D6D3D6'></td><td bgcolor='#D6D3D6'></td><td bgcolor='#D6D3D6'></td><td bgcolor='#D6D3D6'></td><td>{$final_data[$student_sn]['score_fitness']}</td></tr>";
		$data.="</table><br>";
		$data.="<table border='2' cellpadding='3' cellspacing='0' style='width:100%; font-size:14pt; border-collapse:collapse;' bordercolor='#111111'>";
		$data.="<tr align='center'><th>NO</th><th>�d��</th><th>�ʽ�</th><th>�v�ɦW��</th><th>�ҮѤ��</th><th>�D����</th><th>�ҮѦr��</th><th>�W��</th><th>�o��</th><th>�İO</th></tr>";
		for($i=1; $i<=count($competetion); $i++) {
			if($competetion[$i]['squad']==2 && $competetion[$i]['mark']=='V') $team="(".$squad_team[$competetion[$i]['weight']].")"; else $team="";
			$data.="<tr align='center'><td>{$i}</td><td>{$level_array[$competetion[$i]['level']]}</td><td>{$squad_array[$competetion[$i]['squad']]}{$team}</td><td>{$competetion[$i]['name']}</td><td>{$competetion[$i]['certificate_date']}</td><td>{$competetion[$i]['sponsor']}</td><td>{$competetion[$i]['word']}</td><td>{$competetion[$i]['rank']}</td><td>{$competetion[$i]['score']}</td><td>{$competetion[$i]['mark']}</td></tr>";
		}
		$data.="<tr align='center'><th colspan='8'>�X�p</th><td>{$final_data[$student_sn]['score_competetion']}</td><td bgcolor='#D6D3D6'></td></tr>";
		$data.="</table>";
		$data.="</div>";
		//�|�Gñ�W�B�ֳ�
		$data.="<div style='margin:20px 0 0 0;'><span style='font-size:18pt;'>�ǥ�ñ�W�G�@�@�@�@�@�@�@�@�@�a��ñ�W�G�@�@�@�@�@�@�@�@�@�Ǯծֳ��G</span></div>";
		$data.="</div></div>";
		//����B���g����
		$data.="<div align='center' style='{$p_break}'><div style='text-align:left;width:1000px;line-height:30px;'>";
		$data.="<span style='font-size:16pt;'>����B���g���ӡG</span>";
		$data.="<table border='2' cellpadding='3' cellspacing='0' style='width:100%; font-size:13pt; border-collapse:collapse;' bordercolor='#111111'>";
		$data.="<tr align='center'><th>NO</th><th>�~��</th><th>�Ǵ��O</th><th>���g���</th><th>���g���O</th><th>���g�ƥ�</th><th>���g�̾�</th><th>�P�L���</th><th>�İO</th></tr>";
		$n=1;
		for($i=1; $i<=count($reward_list); $i++) {
			if(($reward_list[$i]['reward_kind']<=-1)&&($reward_list[$i]['reward_year_seme']<$fault_start_semester)) continue;
			$data.="<tr align='center'><td>{$n}</td><td>{$reward_list[$i]['reward_grade']}</td><td>{$reward_list[$i]['reward_year_seme']}</td><td>{$reward_list[$i]['reward_date']}</td><td>{$reward_kind[$reward_list[$i]['reward_kind']]}</td><td align='left'>{$reward_list[$i]['reward_reason']}</td><td>{$reward_list[$i]['reward_base']}</td><td>{$reward_list[$i]['reward_cancel_date']}</td><td>{$reward_list[$i]['mark']}</td></tr>";
			$n++;
		}
		$data.="</table>";
		$data.="</div></div>";
	}
	echo $data;
	exit;
}

//�q�X����
head("���Z�ҩ���");
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
	$tool_icon.="<input type='submit' name='act' value='��X���Z�ҩ���' onclick=\"document.myform.target='ts{$academic_year}'\">";
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