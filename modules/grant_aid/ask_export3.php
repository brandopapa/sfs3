<?php
// $Id: ask_export3.php 7780 2013-11-21 05:13:36Z infodaes $

include "config.php";
include "../../include/sfs_case_score.php";
sfs_check();

//�Ǯո�T
$school_id=$SCHOOL_BASE["sch_id"];
$school_tel=$SCHOOL_BASE["sch_phone"];
$school_fax=$SCHOOL_BASE["sch_fax"];

//�̱Ш|���N�X�P�w�~��O
$school_yg=$SCHOOL_BASE["sch_id"][3];
switch ($school_yg) {
  case 0: $school_yg='�|'; break;
  case 1: $school_yg='�|'; break;
  case 2: $school_yg='�G'; break;
  case 3: $school_yg='�T'; break;
  case 4: $school_yg='�T'; break;
  case 5: $school_yg='�T'; break;
  case 6: $school_yg='��'; break;
  case 7: $school_yg='��'; break;
  case 8: $school_yg='��'; break;
  default: $school_yg='';
}

//$school_area=$SCHOOL_BASE["sch_sheng"]."�F��";

//���Ѫ����
$today=(date("Y")-1911).date("�~m��d��");

//�Ǵ��O
$work_year_seme= ($_POST[work_year_seme])?$_POST[work_year_seme]:$_GET[work_year_seme];
if($work_year_seme=='')        $work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
$work_year=substr($work_year_seme,0,3)+0;

//���o�e�@�Ǵ����N��
$seme_list=get_class_seme();
$seme_key_list=array_keys($seme_list);
$pre_seme=$seme_key_list[(array_search($work_year_seme,$seme_key_list))+1];
$seme_array=array($pre_seme);
$sn_array=array();

//�C���P�C��
$height= ($_POST[height])?$_POST[height]:$_GET[height];
if($height=="") $height=33;

$rows= ($_POST[rows])?$_POST[rows]:$_GET[rows];
if($rows=="") $rows=20;

//����html�X
$newpage="<P STYLE='page-break-before: always;'>";


//ñ���C
$sign="�ӿ�H�G�@�@�@�@�@�X�ǡG �@�@�@�@�@�|�p�G �@�@�@�@�D���G�@�@�@�@�@�@�ժ��G";

// ���X�Z�Ű}�C
$class_base = class_base($work_year_seme);
//$class_teacher=get_class_teacher();

//���o�Ǧ~�Ǵ��}�C
$year_seme_arr = get_class_seme();

//���o�ǥͰ򥻸��
$sql_select="select a.student_sn,left(a.class_num,length(a.class_num)-2) as class_id,a.dollar,b.stud_id,b.stud_name,b.stud_person_id,b.stud_sex,b.stud_tel_1,b.stud_addr_1,b.stud_birthday,c.guardian_name,c.fath_education,c.moth_education,c.fath_occupation,c.moth_occupation,c.guardian_p_id,c.guardian_address from grant_aid a,stud_base b,stud_domicile c where a.year_seme='$work_year_seme' AND a.type='$type' AND a.student_sn=b.student_sn AND a.student_sn = c.student_sn order by class_num";
$res=$CONN->Execute($sql_select) or user_error("�����O����Ū�����ѡI<br>$sql_select",256);
$student_arr=array();
while(!$res->EOF) {
	$student_sn=$res->fields['student_sn'];
	
	$student_arr[$student_sn]['class_id']=$res->fields['class_id'];
	$student_arr[$student_sn]['stud_id']=$res->fields['stud_id'];
	$student_arr[$student_sn]['stud_name']=$res->fields['stud_name'];
	$student_arr[$student_sn]['stud_person_id']=$res->fields['stud_person_id'];
	$student_arr[$student_sn]['dollar']=$res->fields['dollar'];
	$student_arr[$student_sn]['stud_sex']=$res->fields['stud_sex'];
	$student_arr[$student_sn]['stud_tel_1']=$res->fields['stud_tel_1'];
	$student_arr[$student_sn]['stud_addr_1']=$res->fields['stud_addr_1'];
	$student_arr[$student_sn]['fath_education']=$res->fields['fath_education'];
	$student_arr[$student_sn]['moth_education']=$res->fields['moth_education'];
	$student_arr[$student_sn]['fath_occupation']=$res->fields['fath_occupation'];
	$student_arr[$student_sn]['moth_occupation']=$res->fields['moth_occupation'];
	$student_arr[$student_sn]['stud_birthday']=$res->fields['stud_birthday'];
	$student_arr[$student_sn]['guardian_name']=$res->fields['guardian_name'];
	$student_arr[$student_sn]['guardian_p_id']=$res->fields['guardian_p_id'];
	$student_arr[$student_sn]['guardian_address']=$res->fields['guardian_address'];


	$res->MoveNext();
}

//�[�J���O�ݩʸ��
$sql_select="select student_sn,clan,area from stud_subkind where type_id='".$target_id[$type]."'";
$res=$CONN->Execute($sql_select) or user_error("�����ݩ�Ū�����ѡI<br>$sql_select",256);
while(!$res->EOF) {
	$student_sn=$res->fields['student_sn'];
	if(array_key_exists($student_sn,$student_arr)){	
		$student_arr[$student_sn]['clan']=$res->fields['clan'];
		$student_arr[$student_sn]['area']=$res->fields['area'];
	}
	$res->MoveNext();
}

//echo '<PRE>';
//print_r($student_arr);
//echo '</PRE>';

$student_arr_len=count($student_arr);

$data="<center><font size='5' face='�з���'>[��G]    �]�Ϊk�H�O�W�ǲ�����|�]�m�M�H�ǥͧU�Ǫ��ǥͦW�U</font><BR><BR>
  <p>�ǮեN�X�G[ $school_id ] �@�@�ǮզW�١G[ $school_long_name ] �@�@�@�ӽЦ~�סG[ $work_year ]
<table border='1' width='90%' cellspacing='0' cellpadding='0' bordercolordark='#008000' bordercolorlight='#008000'>
<tr><td align=center bgcolor=$hint_color>�s��</td>
        <td align=center bgcolor=$hint_color>�m�W</td>
        <td align=center bgcolor=$hint_color>�����ҲΤ@�s��</td>
        <td align=center bgcolor=$hint_color>�~��</td>
        <td align=center bgcolor=$hint_color>�Z��</td>
        <td align=center bgcolor=$hint_color>�ǲ߻��</td>
        <td align=center bgcolor=$hint_color>�ơ@�@�@�@�@�@�@��</td></tr>";

foreach($student_arr as $key=>$value){
	$class_id=$value['class_id'];
	$stud_name=$value['stud_name'];
	$stud_id=$value['stud_id'];
	$stud_person_id=$value['stud_person_id'];
	$stud_sex=$value['stud_sex'];
	$stud_tel_1=$value['stud_tel_1'];
	$stud_addr_1=$value['stud_addr_1'];
	$fath_education=$value['fath_education'];
	$moth_education=$value['moth_education'];
	$fath_occupation=$value['fath_occupation'];
	$moth_occupation=$value['moth_occupation'];
	//$stud_birthday=$value['stud_birthday'];
	$stud_birthday=$value['stud_birthday'];
	//.'�~'.date('m',$value['stud_birthday']).'��'.date('d',$value['stud_birthday']).'��';
	$guardian_name=$value['guardian_name'];
	$guardian_p_id=$value['guardian_p_id'];
	$guardian_address=$value['guardian_address'];

	$clan=$value['clan'];
	$area=$value['area'];
	$dollar=$value['dollar'];
	$student_sn=$key;
	$no=$no+1;
	$num_count++;
        $total=$total+$dollar;
        //���o�W�Ǵ����Z
        $sn_array[0]=$student_sn;
        $sub_score=cal_fin_score($sn_array,$seme_array);
        $nor_score=cal_fin_nor_score($sn_array,$seme_array);
        //�ǳƦW�U
        $data.="<tr>
        <td align=center>$num_count</td>
        <td align=center>$stud_name</td>
        <td align=center>$stud_person_id</td>
        <td align=center>$school_yg</td>
        <td align=center>$class_base[$class_id]</td>
        <td align=center>{$sub_score[$student_sn][avg][score]}</td>
        <td>[ A ]</td>
        </tr>";
$main.="<style>
<!--
 table.MsoNormalTable
	{mso-style-parent:'';
	font-size:10.0pt;
	font-family:'Times New Roman';
	}
 p.MsoNormal
	{mso-style-parent:'';
	margin-bottom:.0001pt;
	font-size:12.0pt;
	font-family:'Times New Roman';
	margin-left:0cm; margin-right:0cm; margin-top:0cm}
-->
</style>
<table class='MsoNormalTable' border='1' cellspacing='0' cellpadding='0' style='border-collapse: collapse; border: medium none' id='table1'>
	<tr style='page-break-inside: avoid; height: 1.0cm'>
		<td width='611' colspan='9' style='width: 457.95pt; height: 1.0cm; border-left: 1.0pt solid windowtext; border-right: medium none; border-top: 1.0pt solid windowtext; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' style='text-align: justify; text-justify: inter-ideograph; line-height: 16.0pt; layout-grid-mode: char'>
		<span lang='EN-US' style='font-size: 14.0pt; font-family: �ө���'>[</span><span style='font-size: 14.0pt; font-family: �ө���'>��@</span><span lang='EN-US' style='font-size: 14.0pt'>]&nbsp;&nbsp;&nbsp;
		</span><span style='font-size: 14.0pt; font-family: �s�ө���'>�Ш|���ǲ����</span><span style='font-size: 14.0pt; font-family: �ө���'>�C���J</span><span style='font-size: 14.0pt; font-family: �s�ө���'>��ǥͧU�Ǫ�</span><span style='font-size: 14.0pt; font-family: �ө���'>�ӽЮ�</span></td>
		<td width='324' colspan='4' style='width: 242.85pt; height: 1.0cm; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: 1.0pt solid windowtext; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span style='font-family: �ө���'>���ӽФ���G</span>$today</td>
	</tr>
	<tr style='page-break-inside: avoid; height: 14.25pt'>
		<td width='34' rowspan='2' style='width: 25.4pt; height: 14.25pt; border-left: 1.0pt solid windowtext; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>�N</span></p>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>Ū</span></p>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>��</span></p>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>��</span></td>
		<td width='278' colspan='3' style='width: 208.15pt; height: 14.25pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align: center; margin-left: 36.0pt; margin-right: 36.0pt; margin-top: 0cm; margin-bottom: .0001pt'>
		<span lang='EN-US' style='font-size: 10.0pt; font-family: �ө���'>(</span><span style='font-size: 10.0pt; font-family: �ө���'>�Ǯե���<span lang='EN-US'>)</span></span></td>
		<td width='58' style='width: 43.85pt; height: 14.25pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span style='font-size: 10.0pt; font-family: �ө���'>�~��O</span></td>
		<td style='width: 136px; height: 14.25pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' colspan='2'>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span style='font-size: 10.0pt; font-family: �ө���'>�~��/��t</span></td>
		<td width='24' rowspan='4' style='width: 18.15pt; height: 14.25pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span style='font-size: 10.0pt; font-family: �ө���'>�e</span></p>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span style='font-size: 10.0pt; font-family: �ө���'>��</span></p>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span style='font-size: 10.0pt; font-family: �ө���'>��</span></p>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span style='font-size: 10.0pt; font-family: �ө���'>��</span></p>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span style='font-size: 10.0pt; font-family: �ө���'>�Z</span></td>
		<td width='210' colspan='2' rowspan='2' style='width: 157.5pt; height: 14.25pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>�Ƿ~</span></p>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span lang='EN-US' style='font-size: 8.0pt; font-family: �ө���'>(</span><span style='font-size: 8.0pt; font-family: �ө���'>�ǲ߻��<span lang='EN-US'>)</span></span></td>
		<td width='30' rowspan='2' style='width: 22.35pt; height: 14.25pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>��</span></p>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>��</span></td>
		<td width='147' rowspan='2' style='width: 109.9pt; height: 14.25pt; border-left: medium none; border-right: medium none; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' style='text-align: justify; text-justify: inter-ideograph'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='18' rowspan='2' style='width: 13.5pt; height: 14.25pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='right' style='text-align: right'>
		<span style='font-size: 8.0pt; font-family: �ө���'>ñ��</span></td>
	</tr>
	<tr style='page-break-inside: avoid; height: 36.4pt'>
		<td width='278' colspan='3' style='width: 208.15pt; height: 36.4pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span lang='en-us'>{$school_long_name}</span></td>
		<td width='58' style='width: 43.85pt; height: 36.4pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center'>
		<span lang='EN-US'>{$school_yg}</span></td>
		<td style='width: 136px; height: 36.4pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' colspan='2'>
		<p align='center' class='MsoNormal'>{$class_base[$class_id]}</td>
	</tr>
	<tr style='page-break-inside: avoid; height: 16.9pt'>
		<td width='34' rowspan='2' style='width: 25.4pt; height: 16.9pt; border-left: 1.0pt solid windowtext; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>��</span></p>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>��</span></p>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>�H</span></td>
		<td width='88' style='width: 66.0pt; height: 16.9pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span style='font-size: 10.0pt; font-family: �ө���'>�m�W</span></td>
		<td width='96' style='width: 72.0pt; height: 16.9pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span style='font-size: 9.0pt; font-family: �ө���; color: red'>�����ҲΤ@�s��</span></td>
		<td width='94' style='width: 70.15pt; height: 16.9pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span style='font-size: 10.0pt; font-family: �ө���'>�X�ͦ~���</span></td>
		<td width='98' colspan='2' style='width: 73.85pt; height: 16.9pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span style='font-size: 10.0pt; font-family: �ө���'>�q��</span></td>
		<td width='96' style='width: 72.0pt; height: 16.9pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span style='font-size: 10.0pt; font-family: �ө���'>�ǥ�ñ��</span></td>
		<td width='210' colspan='2' rowspan='2' style='width: 157.5pt; height: 16.9pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span lang='EN-US'>{$sub_score[$student_sn][avg][score]}</span></td>
		<td width='30' rowspan='2' style='width: 22.35pt; height: 16.9pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>�ӿ���</span></p>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>�D��</span></td>
		<td width='147' rowspan='2' style='width: 109.9pt; height: 16.9pt; border-left: medium none; border-right: medium none; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' style='text-align: justify; text-justify: inter-ideograph'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='18' rowspan='2' style='width: 13.5pt; height: 16.9pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='right' style='text-align: right'>
		<span style='font-size: 8.0pt; font-family: �ө���'>ñ��</span></td>
	</tr>
	<tr style='page-break-inside: avoid; height: 42.15pt'>
		<td width='88' style='width: 66.0pt; height: 42.15pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span lang='EN-US'>{$stud_name}</span></td>
		<td width='96' style='width: 72.0pt; height: 42.15pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span lang='EN-US'>{$stud_person_id}</span></td>
		<td width='94' style='width: 70.15pt; height: 42.15pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span lang='EN-US'>{$stud_birthday}</span></td>
		<td width='98' colspan='2' style='width: 73.85pt; height: 42.15pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span lang='EN-US'>{$stud_tel_1}</span></td>
		<td width='96' style='width: 72.0pt; height: 42.15pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align: center'>
		<span lang='EN-US'>&nbsp;</span></td>
	</tr>
</table>
<p class='MsoNormal' align='center'>�@</p>
<table class='MsoNormalTable' border='0' cellspacing='0' cellpadding='0' style='border-collapse: collapse' id='table2' height='401'>
	<tr style='page-break-inside: avoid; height: 16.5pt'>
		<td width='58' colspan='2' style='width: 43.4pt; height: 16.5pt; border: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>�C���J</span></p>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>����m�W</span></td>
		<td width='160' colspan='3' style='width: 120.0pt; height: 16.5pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: 1.0pt solid windowtext; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>{$guardian_name}</span></td>
		<td width='72' colspan='2' style='width: 54.0pt; height: 16.5pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: 1.0pt solid windowtext; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' style='text-align:justify;text-justify:inter-ideograph'>
		<span style='font-size: 8.0pt; font-family: �ө���; color: red'>��������ҲΤ@�s��</span></td>
		<td width='120' colspan='2' style='width: 90.0pt; height: 16.5pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: 1.0pt solid windowtext; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>{$guardian_p_id}</span></td>
		<td width='32' colspan='2' rowspan='2' style='width: 24.0pt; height: 16.5pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: 1.0pt solid windowtext; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>�~��</span></p>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>�{�p</span></td>
		<td width='64' rowspan='2' style='width: 48.0pt; height: 16.5pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: 1.0pt solid windowtext; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' style='text-align:justify;text-justify:inter-ideograph'>
		<span style='font-size: 8.0pt; font-family: �ө���'>������</span></p>
		<p class='MsoNormal' style='text-align:justify;text-justify:inter-ideograph'>
		<span style='font-size: 8.0pt; font-family: �ө���'>���ۦ��Ы�</span></td>
		<td width='24' rowspan='10' style='width: 18.15pt; height: 16.5pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: 1.0pt solid windowtext; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>�Ǯռf�d�N��</span></td>
		<td width='210' rowspan='10' valign='top' style='width: 157.5pt; height: 16.5pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: 1.0pt solid windowtext; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' style='text-align:justify;text-justify:inter-ideograph'>
		<span style='font-size: 8.0pt; font-family: �ө���'>�@�B�M�H����G</span></p>
		<p class='MsoNormal' style='text-align: justify; text-justify: inter-ideograph; text-indent: -36.0pt; margin-left: 60.0pt'>
		<span lang='EN-US' style='font-size: 8.0pt'>�]A�^<span style='font:7.0pt &quot;Times New Roman&quot;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</span></span><span style='font-size: 8.0pt; font-family: �ө���'>
		�����C���J���ҩ��̡C</span></p>
		<p class='MsoNormal' style='margin-left:30.05pt;text-align:justify;text-justify:
  inter-ideograph;text-indent:-.15pt'>
		<span lang='EN-US' style='font-size: 8.0pt; font-family: �ө���'>[</span><span style='font-size: 8.0pt; font-family: �ө���'>���ҩ���󶷻P���ӽЮѤ@�P�H�e��ӿ�Ǯ�<span lang='EN-US'>]</span></span></p>
		<p class='MsoNormal' style='text-align: justify; text-justify: inter-ideograph; text-indent: -36.0pt; margin-left: 60.0pt'>
		<span lang='EN-US' style='font-size: 8.0pt'>�]B�^<span style='font:7.0pt &quot;Times New Roman&quot;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</span></span><span style='font-size: 8.0pt; font-family: �ө���'>
		���P�ɨ㦳���������C</span></p>
		<p class='MsoNormal' style='text-align:justify;text-justify:inter-ideograph'>
		<span lang='EN-US' style='font-size: 8.0pt; font-family: �ө���'>&nbsp;</span></p>
		<p class='MsoNormal' style='text-align:justify;text-justify:inter-ideograph'>
		<span style='font-size: 8.0pt; font-family: �ө���'>�G�B</span><b><u><span style='font-size:10.0pt;font-family:�з���;color:red'>���ӽЬF���o�����䥦���U�Ǫ��ξ����O��K�A���]�t�F���o�����C���J�ǥ;����O��K�A�Y�����y���걡�ơA�@�t�k�߳d����ú�^�U�Ǫ��C</span></u></b></p>
		<p class='MsoNormal' style='text-align:justify;text-justify:inter-ideograph'>
		<span lang='EN-US' style='font-size: 8.0pt'>&nbsp;</span></p>
		<p class='MsoNormal' style='text-align:justify;text-justify:inter-ideograph'>
		<span lang='EN-US' style='font-size: 8.0pt'>&nbsp;</span></p>
		<p class='MsoNormal' style='text-align:justify;text-justify:inter-ideograph'>
		<span style='font-size: 8.0pt; font-family: �ө���'>�T�B�Ǯժ�f�p�ռf�d�Mĳ�G</span></p>
		<p class='MsoNormal' style='text-align:justify;text-justify:inter-ideograph'>
		<span lang='EN-US' style='font-size: 8.0pt'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
		<span style='font-size: 8.0pt; font-family: �ө���'>���X��</span></p>
		<p class='MsoNormal' style='text-align:justify;text-justify:inter-ideograph'>
		<span lang='EN-US' style='font-size: 8.0pt'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
		<span style='font-size: 8.0pt; font-family: �ө���'>�����X��</span></td>
		<td width='15' rowspan='10' style='width: 11.15pt; height: 16.5pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: 1.0pt solid windowtext; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>��</span></p>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US' style='font-size: 8.0pt; font-family: �ө���'>&nbsp;</span></p>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US' style='font-size: 8.0pt; font-family: �ө���'>&nbsp;</span></p>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US' style='font-size: 8.0pt; font-family: �ө���'>&nbsp;</span></p>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US' style='font-size: 8.0pt; font-family: �ө���'>&nbsp;</span></p>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>��</span></td>
		<td width='15' rowspan='3' style='width: 11.2pt; height: 16.5pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: 1.0pt solid windowtext; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' align='center'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>��</span></p>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>��</span></td>
		<td width='147' rowspan='3' style='width: 109.9pt; height: 16.5pt; border-left: medium none; border-right: medium none; border-top: 1.0pt solid windowtext; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='18' rowspan='3' style='width: 13.5pt; height: 16.5pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: 1.0pt solid windowtext; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='right' style='text-align:right'>
		<span style='font-size: 8.0pt; font-family: �ө���'>�B��</span></td>
	</tr>
	<tr style='page-break-inside: avoid; height: 26.25pt'>
		<td width='58' colspan='2' style='width: 43.4pt; height: 26.25pt; border-left: 1.0pt solid windowtext; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>�p���a�}</span></td>
		<td width='352' colspan='7' style='width: 264.0pt; height: 26.25pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>{$guardian_address}</span></td>
	</tr>
	<tr style='page-break-inside: avoid; height: 17.75pt'>
		<td width='34' rowspan='8' style='width: 25.45pt; height: 17.75pt; border-left: 1.0pt solid windowtext; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: medium none; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>�a</span></p>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>�x</span></p>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>��</span></p>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>�p</span></td>
		<td width='40' colspan='2' rowspan='2' style='width: 29.95pt; height: 17.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>����</span></p>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>�ٿ�</span></td>
		<td width='96' rowspan='2' style='width: 72.0pt; height: 17.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>�m�W</span></td>
		<td width='48' rowspan='2' style='width: 36.0pt; height: 17.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>�s�\</span></td>
		<td width='40' rowspan='2' style='width: 30.0pt; height: 17.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>�~��</span></td>
		<td width='248' colspan='6' style='width: 186.0pt; height: 17.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>���d���p</span></td>
	</tr>
	<tr style='page-break-inside: avoid; height: 17.3pt'>
		<td width='80' colspan='2' style='width: 60.0pt; height: 17.3pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>���`</span></td>
		<td width='80' colspan='2' style='width: 60.0pt; height: 17.3pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>�e�f</span></td>
		<td width='88' colspan='2' style='width: 66.0pt; height: 17.3pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���; color: red'>���߻�ê</span></td>
		<td width='15' rowspan='4' style='width: 11.2pt; height: 17.3pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: medium none; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' align='center'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>�H</span></p>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>��</span></td>
		<td width='147' rowspan='4' style='width: 109.9pt; height: 17.3pt; border: medium none; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='18' rowspan='4' style='width: 13.5pt; height: 17.3pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: medium none; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>ñ��</span></td>
	</tr>
	<tr style='page-break-inside: avoid; height: 23.05pt'>
		<td width='40' colspan='2' style='width: 29.95pt; height: 23.05pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='96' style='width: 72.0pt; height: 23.05pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='48' style='width: 36.0pt; height: 23.05pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='40' style='width: 30.0pt; height: 23.05pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='80' colspan='2' style='width: 60.0pt; height: 23.05pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='80' colspan='2' style='width: 60.0pt; height: 23.05pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='88' colspan='2' style='width: 66.0pt; height: 23.05pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
	</tr>
	<tr style='page-break-inside: avoid; height: 25.95pt'>
		<td width='40' colspan='2' style='width: 29.95pt; height: 25.95pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='96' style='width: 72.0pt; height: 25.95pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='48' style='width: 36.0pt; height: 25.95pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='40' style='width: 30.0pt; height: 25.95pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='80' colspan='2' style='width: 60.0pt; height: 25.95pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='80' colspan='2' style='width: 60.0pt; height: 25.95pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='88' colspan='2' style='width: 66.0pt; height: 25.95pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
	</tr>
	<tr style='page-break-inside: avoid; height: 21.75pt'>
		<td width='40' colspan='2' style='width: 29.95pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='96' style='width: 72.0pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='48' style='width: 36.0pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='40' style='width: 30.0pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='80' colspan='2' style='width: 60.0pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='80' colspan='2' style='width: 60.0pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='88' colspan='2' style='width: 66.0pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
	</tr>
	<tr style='page-break-inside: avoid; height: 21.75pt'>
		<td width='40' colspan='2' style='width: 29.95pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='96' style='width: 72.0pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='48' style='width: 36.0pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='40' style='width: 30.0pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='80' colspan='2' style='width: 60.0pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='80' colspan='2' style='width: 60.0pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='88' colspan='2' style='width: 66.0pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='15' rowspan='3' style='width: 11.2pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: 1.0pt solid windowtext; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' align='center'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>�p</span></p>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>��</span></p>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 8.0pt; font-family: �ө���'>�q��</span></td>
		<td width='165' colspan='2' rowspan='3' style='width: 123.4pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: 1.0pt solid windowtext; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
	</tr>
	<tr style='page-break-inside: avoid; height: 21.75pt'>
		<td width='40' colspan='2' style='width: 29.95pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='96' style='width: 72.0pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='48' style='width: 36.0pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='40' style='width: 30.0pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='80' colspan='2' style='width: 60.0pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='80' colspan='2' style='width: 60.0pt; height: 21.75pt; border-left: medium none; border-right: medium none; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='88' colspan='2' style='width: 66.0pt; height: 21.75pt; border-left: 1.0pt solid windowtext; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
	</tr>
	<tr style='page-break-inside: avoid; height: 21.75pt'>
		<td width='40' colspan='2' style='width: 29.95pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='96' style='width: 72.0pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='48' style='width: 36.0pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='40' style='width: 30.0pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='80' colspan='2' style='width: 60.0pt; height: 21.75pt; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='80' colspan='2' style='width: 60.0pt; height: 21.75pt; border-left: medium none; border-right: medium none; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
		<td width='88' colspan='2' style='width: 66.0pt; height: 21.75pt; border-left: 1.0pt solid windowtext; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span lang='EN-US'>&nbsp;</span></td>
	</tr>
	<tr style='page-break-inside: avoid; height: 94.45pt'>
		<td width='34' style='width: 25.45pt; height: 114px; border: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm; background: silver'>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 10.0pt; font-family: �ө���'>�`</span></p>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 10.0pt; font-family: �ө���'>�N</span></p>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 10.0pt; font-family: �ө���'>��</span></p>
		<p class='MsoNormal' align='center' style='text-align:center'>
		<span style='font-size: 10.0pt; font-family: �ө���'>��</span></td>
		<td width='900' colspan='17' style='width: 675.35pt; height: 113px; border-left: medium none; border-right: 1.0pt solid windowtext; border-top: medium none; border-bottom: 1.0pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
		<p class='MsoNormal' style='margin-top:0cm;margin-right:3.0pt;margin-bottom:
  0cm;margin-left:24.95pt;margin-bottom:.0001pt;text-align:justify;text-justify:
  inter-ideograph;text-indent:-20.5pt'>
		<span style='font-size: 10.0pt; font-family: �ө���'>�@�B�W��U��A��z���򤣧��ƪ̷������z�A<span style='color:red'>�ӽЪ̤��o��ĳ</span>�A�a�x���p�����ݦp��������i�[�B�ҡC</span></p>
		<p class='MsoNormal' style='margin-top:0cm;margin-right:3.0pt;margin-bottom:
  0cm;margin-left:24.95pt;margin-bottom:.0001pt;text-align:justify;text-justify:
  inter-ideograph;text-indent:-20.5pt'>
		<span style='font-size: 10.0pt; font-family: �ө���'>�G�B�ӽб���G��</span><span lang='EN-US' style='font-size: 10.0pt; color: blue'>({$work_year}</span><span lang='EN-US' style='font-size: 10.0pt'>)</span><span style='font-size: 10.0pt; font-family: �ө���'>�Ǧ~�ײ�</span><span lang='EN-US' style='font-size: 10.0pt'>1</span><span style='font-size: 10.0pt; font-family: �ө���'>�Ǵ��A<span style='color:red'>��</span>���C���J��</span><span lang='EN-US' style='font-size: 10.0pt'>(</span><span style='font-size: 10.0pt; font-family: �ө���'>���]�A���C���J��</span><span lang='EN-US' style='font-size: 10.0pt'>)</span><span style='font-size: 10.0pt; font-family: �ө���'>�����A�B�e�Ǵ����Z����¾�H�W�Ƿ~���Z<span style='color:red'>�`�������Q��</span>�H�W�]�B�w����q�L�p�L�H�W���B���^�C������ǡG�ǲ߻����q���Z�`�p�������Q���H�W�A�B��`�ͬ���{���q�L�p�L�H�W���B���C����p�ǡG�ǲ߻����q���Z�`�p�������Q���H�W�C�@�~�ŷs�ͤW�Ǵ��K�f�֦��Z�C</span></p>
		<p class='MsoNormal' style='margin-top:0cm;margin-right:3.0pt;margin-bottom:
  0cm;margin-left:24.95pt;margin-bottom:.0001pt;text-align:justify;text-justify:
  inter-ideograph;text-indent:-20.5pt'>
		<span style='font-size: 10.0pt; font-family: �ө���'>�T�B�ӽФ覡�G�C�Ǵ��}�Ǫ�A�̴NŪ�Ǯդ�<span style='color:red'>���ӽ�</span>�����A�Զ�ӽЮѨ��˪����Ĥ����J���ҩ��A�V�Ǯմ��X�ӽСC</span></p>
		<p class='MsoNormal' style='margin-top:0cm;margin-right:3.0pt;margin-bottom:
  0cm;margin-left:24.95pt;margin-bottom:.0001pt;text-align:justify;text-justify:
  inter-ideograph;text-indent:-20.5pt'>
		<span style='font-size: 10.0pt; font-family: �ө���'>
		�|�B�C���J���ҩ��]�Y���v���Х[�\�Ǯթӿ�H���L���^���Y���C�X�ӽоǥ͸�ƮɡA�д��Ѥ�f�Wï�Τ��y�å��C</span></p>
		<p class='MsoNormal' style='margin-top:0cm;margin-right:3.0pt;margin-bottom:
  0cm;margin-left:24.95pt;margin-bottom:.0001pt;text-align:justify;text-justify:
  inter-ideograph;text-indent:-20.5pt'>
		<span style='font-size: 10.0pt; font-family: �ө���'>
		���B�f�d���G�g�֩w�o���U�Ǫ��̡A�p��Ǵ������e�|���Q�q������A�Ь��U�թӿ�H���d�ߡC</span></td>
	</tr>
</table>
";

       if($no<>$student_arr_len) $main.=$newpage;
}
//���վǥͼ�
$sql_select="select count(*) from stud_base where stud_study_cond in (0,15)";
$res=$CONN->Execute($sql_select) or user_error("���վǥͼ�Ū�����ѡI<br>$sql_select",256);
$total=$res->fields[0];
$data.="</table><BR>���վǥͼơG[$total]�H�C��e�H��  �C���J��G[ $num_count ]�H�C�@�@�@�@�@�ӽФ���G[ $today ]</CENTER>";
$main.=$newpage.$data."";

echo $main;
echo "\n<script language=\"Javascript\"> alert (\"������w�]�L��榡��A4��L�A�L��e�аO�o�]�w��I\")</script>";
?>
