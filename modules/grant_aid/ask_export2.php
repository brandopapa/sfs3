<?php
// $Id: ask_export2.php 7132 2013-02-21 07:56:52Z infodaes $

include "config.php";
include "../../include/sfs_case_score.php";
//include "../../include/sfs_case_dataarray.php";

sfs_check();

//�Ǯո�T
$school_id=$SCHOOL_BASE["sch_id"];
$school_tel=$SCHOOL_BASE["sch_phone"];
$school_fax=$SCHOOL_BASE["sch_fax"];

//���o�Ǿ��ѷӪ�
$edu_list=edu_kind();

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
$sql_select="select a.student_sn,left(a.class_num,length(a.class_num)-2) as class_id,a.dollar,b.stud_id,b.stud_name,b.stud_person_id,b.stud_sex,b.stud_tel_1,b.stud_addr_1,c.fath_education,c.moth_education,c.fath_occupation,c.moth_occupation from grant_aid a,stud_base b,stud_domicile c where a.year_seme='$work_year_seme' AND a.type='$type' AND a.student_sn=b.student_sn AND a.student_sn = c.student_sn order by class_num";
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


$data="<center><p align='center'><font face='�з���' size='5'>$school_long_name".$year_seme_arr[$work_year_seme]."�����ǥͼ��Ǫ��ӽоǥͦW�U</font></p>
  <p>�ǮեN�X�G[ $school_id ] �@�@�ǮզW�١G[ $school_long_name ] �@�@�@�ӽЦ~�סG[ $work_year ]
<table border='1' width='100%' cellspacing='0' cellpadding='0' bordercolordark='#008000' bordercolorlight='#008000'>
<tr bgcolor=$hint_color><td align=center>�s��</td>
        <td align=center>�m�W</td>
        <td align=center>�����Ҹ��X</td>
        <td align=center>�Z��</td>
    <td align='center'>�y��(��)</td>
    <td align='center'>�y��(�^)</td>
    <td align='center'>�ƾ�</td>
    <td align='center'>���d��|</td>
    <td align='center'>���N�H��</td>
    <td align='center'>�۵M�ͬ�</td>
    <td align='center'>���|</td>
    <td align='center'>��X����</td>
    <td align='center'>��`��{</td>
    <td align='center'>�������Z</td>
        <td align=center>�ơ@�@��</td></tr>";
$sex=array("-","�k","�k");
        
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

	$clan=$value['clan'];
	$area=$value['area'];
	$dollar=$value['dollar'];
	
	$no=$no+1;
	$num_count++;
        $total=$total+$dollar;
        //���o�W�Ǵ����Z
        $sn_array[0]=$student_sn;
        $sub_score=cal_fin_score($sn_array,$seme_array);
        $nor_score=cal_fin_nor_score($sn_array,$seme_array);
        //�ǳƦW�U

//print_r($sub_score);
        //���[�v���������Z�u�������Z�v�@�檺����覡���U��즨�Z���`�M���H�`���ơA�Y�ꤤ���H9�A��p���H8�A�Ф��n�H�[�v�覡�p�⤧�C
        $division=($sub_score[$student_sn][succ]==5)?6:9;
        $avg=round(($sub_score[$student_sn][chinese][avg][score]+$sub_score[$student_sn][english][avg][score]+
             $sub_score[$student_sn][math][avg][score]+$sub_score[$student_sn][health][avg][score]+
             $sub_score[$student_sn][art][avg][score]+$sub_score[$student_sn][nature][avg][score]+
             $sub_score[$student_sn][social][avg][score]+$sub_score[$student_sn][complex][avg][score]+
             $sub_score[$student_sn][life][avg][score]+ $nor_score[$student_sn][avg][score])/$division,2);
        $data.="<tr>
        <td align=center>$num_count</td>
        <td align=center>$stud_name</td>
        <td align=center>$stud_person_id</td>
        <td align=center>$class_base[$class_id]</td>
    <td align='center'>".$sub_score[$student_sn][chinese][avg][score]."</td>
    <td align='center'>".$sub_score[$student_sn][english][avg][score]."</td>
    <td align='center'>".$sub_score[$student_sn][math][avg][score]."</td>
    <td align='center'>".$sub_score[$student_sn][health][avg][score]."</td>";

    if($sub_score[$student_sn][succ]==5){ $data.="<td align='center' colspan='3'>".$sub_score[$student_sn][life][avg][score]."</td>";}
        else {
              $data.="<td align='center'>".$sub_score[$student_sn][social][avg][score]."</td>
                  <td align='center'>".$sub_score[$student_sn][art][avg][score]."</td>
                  <td align='center'>".$sub_score[$student_sn][nature][avg][score]."</td>";
                    }
    $data.="
    <td align='center'>".$sub_score[$student_sn][complex][avg][score]."</td>
    <td align='center'>".$nor_score[$student_sn][avg][score]."</td>
    <td align='center'>$avg</td>
        <td>�@</td></tr>";
        $main.="
<p align='center'><font face='�з���' size='5'>$school_long_name
�����ǥ�".$year_seme_arr[$work_year_seme]."���Ǫ��ӽЮ�</font></p>
<p align='right'><font face='�з���'>�ӽФ��</font>�G[<font face='�з���'>
$today ]&nbsp;&nbsp;&nbsp; #$num_count</font></p>
<table border='1' width='100%' height='240' cellpadding='4' bordercolordark='#008000' bordercolorlight='#008000' cellspacing='0'>
  <tr>
    <td width='6%' rowspan='2' height='60' align='center' bgcolor=$hint_color>�ӽФH</td>
    <td width='14%' height='16' align='center' bgcolor=$hint_color>�m�W</td>
    <td width='20%' height='16' align='center' bgcolor=$hint_color>�����Ҹ��X</td>
    <td width='10%' height='16' align='center' colspan='2' bgcolor=$hint_color>�ʧO</td>
    <td width='15%' height='16' align='center' colspan='3' bgcolor=$hint_color>�Z��</td>
    <td width='17%' height='16' align='center' colspan='3' bgcolor=$hint_color>���y</td>
    <td width='18%' height='54' align='center' colspan='3' rowspan='2'>[$area]����</td>
  </tr>
  <tr>
    <td width='14%' height='38' align='center'>$stud_name</td>
    <td width='20%' height='38' align='center'>$stud_person_id</td>
    <td width='10%' height='38' align='center' colspan='2'>$sex[$stud_sex]</td>
    <td width='15%' height='38' align='center' colspan='3'>$class_base[$class_id]</td>
    <td width='17%' height='38' align='center' colspan='3'>$clan</td>
  </tr>
  <tr>
    <td width='6%' height='55' align='center' bgcolor=$hint_color>��}</td>
    <td width='44%' height='55' align='center' colspan='4'>$stud_addr_1</td>
    <td width='5%' height='55' align='center' bgcolor=$hint_color>�q��</td>
    <td width='15%' height='55' align='center' colspan='3'>$stud_tel_1</td>
    <td width='12%' height='55' align='center' colspan='2' bgcolor=$hint_color>�ǥ�ñ��</td>
    <td width='18%' height='55' align='center' colspan='3'>�@</td>
  </tr>
  <tr>
    <td width='20%' height='16' align='left' colspan='2'>����¾�~�G$fath_occupation</td>
    <td width='20%' height='16' align='left'>���˾Ǿ��G$edu_list[$fath_education]</td>
    <td width='48%' height='16' align='left' colspan='9'>�a�x���p(�i�ƿ�)�G���C���J��@����ˡ@���j�N�оi</td>
    <td width='12%' height='32' align='center' colspan='2' rowspan='2' bgcolor=#FFCCCC>
      <p align='left'><font size='2'>���v�T����P�_�����G�A�оڹ�^���C</font></td>
  </tr>
  <tr>
    <td width='20%' height='16' align='left' colspan='2'>����¾�~�G$moth_occupation</td>
    <td width='20%' height='16' align='left'>���˾Ǿ��G$edu_list[$moth_education]</td>
    <td width='48%' height='16' align='left' colspan='9'>�a�x�g��(���)�G���x�W�@�����q�@���p�d�@������</td>
  </tr>
  <tr>
    <td width='40%' height='51' align='center' colspan='3'>
      <p align='left' style='line-height: 100%; margin-top: 0; margin-bottom: 0'><font size='3'>�O�_�⦳�䥦�F�������Τ���Ʒ~��줧���Ǫ��H</font><p align='center' style='line-height: 100%; margin-top: 0; margin-bottom: 0'><font size='3'>���O�@���_</font></td>
    <td width='4%' height='77' align='center' rowspan='2' bgcolor=$hint_color>�e�Ǵ����Z</td>
    <td width='6%' height='51' align='center' bgcolor=$hint_color>�y��(��)</td>
    <td width='5%' height='51' align='center' bgcolor=$hint_color>�y��(�^)</td>
    <td width='5%' height='51' align='center' bgcolor=$hint_color>�ƾ�</td>
    <td width='5%' height='51' align='center' bgcolor=$hint_color>���d��|</td>
    <td width='5%' height='51' align='center' bgcolor=$hint_color>���N�H��</td>
    <td width='6%' height='51' align='center' bgcolor=$hint_color>�۵M�ͬ�</td>
    <td width='6%' height='51' align='center' bgcolor=$hint_color>���|</td>
    <td width='6%' height='51' align='center' bgcolor=$hint_color>��X����</td>
    <td width='6%' height='51' align='center' bgcolor=$hint_color>��`��{</td>
    <td width='6%' height='51' align='center' bgcolor=$hint_color>�������Z</td>
  </tr>
  <tr>
    <td width='6%' height='26' align='center' bgcolor=$hint_color>�ӽи�����̾�</td>
    <td width='34%' height='26' align='center' colspan='2'>
          <p align='left' style='line-height: 100%; margin-top: 0; margin-bottom: 0'><font size='3'>���H����έӤH�覡�ѥ[����ʤ��ɫe�T�W���S���u�}��{���ӽШ̾�(�Ъ��ҩ�)</font>
          <p align='left' style='line-height: 100%; margin-top: 0; margin-bottom: 0'><font size='3'>���H�e�@�Ǵ��`���Z�b70��(�t)�H�W���ӽШ̾�(�ж��Z����)�C</font>
          <p align='left' style='line-height: 100%; margin-top: 0; margin-bottom: 0'><font size='3'>���L���Z�̾ڡA�ѾǮտ��ˤ�(�@�~�ŷs�ͲĤ@�Ǵ��~�A��)�C</font>
    </td>
    <td width='6%' height='26' align='center'>".$sub_score[$student_sn][chinese][avg][score]."</td>
    <td width='5%' height='26' align='center'>".$sub_score[$student_sn][english][avg][score]."</td>
    <td width='5%' height='26' align='center'>".$sub_score[$student_sn][math][avg][score]."</td>
    <td width='5%' height='26' align='center'>".$sub_score[$student_sn][health][avg][score]."</td>";

    if($sub_score[$student_sn][succ]==5){ $main.="<td align='center' colspan='3'>".$sub_score[$student_sn][life][avg][score]."</td>";}
        else {
              $main.="<td align='center'>".$sub_score[$student_sn][social][avg][score]."</td>
                  <td align='center'>".$sub_score[$student_sn][art][avg][score]."</td>
                  <td align='center'>".$sub_score[$student_sn][nature][avg][score]."</td>";
                    }
    $main.="
    <td width='6%' height='26' align='center'>".$sub_score[$student_sn][complex][avg][score]."</td>
    <td width='6%' height='26' align='center'>".$nor_score[$student_sn][avg][score]."</td>
    <td width='6%' height='26' align='center'>$avg</td>
  </tr>
  <tr>
    <td width='100%' height='1' align='center' colspan='14' bgcolor='#FFCCCC'>
      <p align='left'><font size='2'>���G�@�B�u�������Z�v�@�檺����覡���U��즨�Z���`�M���H�`���ơA�Y�ꤤ���H9�A��p���H8�A�Ф��n�H�[�v�覡�p�⤧�C<br>
     �G�B�O�_�⦳�䥦�F�������Τ���Ʒ~��줧���Ǫ��Υӽи�����̾ڨt�ӽХ������A�����Ŀ�C</font></td>
  </tr>
</table>
<table border='1' width='100%' height='81' bordercolordark='#008000' bordercolorlight='#008000'>
  <tr>
    <td width='6%' rowspan='3' align='center' valign='middle' height='75' bgcolor=$hint_color>�H��
      <p>���</p>
    </td>
    <td width='26%' align='center' valign='middle' height='19' bgcolor=$hint_color>����W��</td>
    <td width='14%' align='center' valign='middle' height='19' bgcolor=$hint_color>�f�d���G</td>
    <td width='9%' rowspan='3' align='center' valign='middle' height='75' bgcolor=$hint_color>�f��
      <p>���G</p>
    </td>
    <td width='45%' rowspan='3' align='center' valign='middle' height='75'>�@</td>
  </tr>
  <tr>
    <td width='26%' align='center' valign='middle' height='30' bgcolor='#D9ECFF'>���������ҩ����v��</td>
    <td width='14%' align='center' valign='middle' height='30'>�����@���L</td>
  </tr>
  <tr>
    <td width='26%' align='center' valign='middle' height='32' bgcolor='#D9ECFF'>�䥦���v��</td>
    <td width='14%' align='center' valign='middle' height='32'>�����@���L</td>
  </tr>
</table><br>
<p>�ť��ɮv�\���G�@�@�@�@�@�@�ӿ�H�\���G�@�@�@�@�@�@�q�ܡG[$school_tel]�@�@�@�@�аȥD���\���G�@�@�@�@                �ժ��\���G</p>
";

      if($no<>$student_arr_len) $main.=$newpage;
}
$data.="</table><BR>�� �ӽФH�ƦX�p�G[$num_count]�A���B�X�p�G�s�x��[ $total ]����C�@�@�@�@�@�ӽФ���G[ $today ]</CENTER>";
$main=$data.$newpage.$main;

echo $main;
echo "\n<script language=\"Javascript\"> alert (\"������w�]�L��榡��A4��L�A�L��e�аO�o�]�w��I\")</script>";
?>