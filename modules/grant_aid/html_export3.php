<?php
// $Id: html_export3.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";
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
$sql_select="select a.student_sn,left(a.class_num,length(a.class_num)-2) as class_id,b.stud_id,b.stud_name,b.stud_person_id,a.dollar from grant_aid a,stud_base b where a.year_seme='$work_year_seme' and a.type='$type' and a.student_sn=b.student_sn order by class_num";
$res=$CONN->Execute($sql_select) or user_error("�����O����Ū�����ѡI<br>$sql_select",256);
$student_arr=array();
while(!$res->EOF) {
	$student_sn=$res->fields['student_sn'];
	
	$student_arr[$student_sn]['class_id']=$res->fields['class_id'];
	$student_arr[$student_sn]['stud_id']=$res->fields['stud_id'];
	$student_arr[$student_sn]['stud_name']=$res->fields['stud_name'];
	$student_arr[$student_sn]['stud_person_id']=$res->fields['stud_person_id'];
	$student_arr[$student_sn]['dollar']=$res->fields['dollar'];
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

foreach($student_arr as $key=>$value){
	$class_id=$class_base[$value['class_id']];
	$stud_name=$value['stud_name'];
	$stud_id=$value['stud_id'];
	$stud_person_id=$value['stud_person_id'];
	$clan=$value['clan'];
	$area=$value['area'];
	$dollar=$value['dollar'];
	
	$no=$no+1;
	$num_count++;
        $total=$total+$dollar;
        $data.="<tr bgcolor='#FFFFFF' height=$height>
        <td align='center'>$num_count</td>
        <td align='center'>$class_id</td>
        <td align='center'>$stud_id</td>
        <td align='center'>$stud_name</td>
        <td align='center'>$stud_person_id</td>
        <td align='center'>$school_yg</td>
        <td align='right'>$dollar &nbsp;</td>
        <td></td></tr>";

        //������X  $num_count==20  �N��C���L20�H
        if(($num_count % $rows==0) or $no==$student_arr_len) {
                $page=$page+1;
                $alldollar=$alldollar+$total;
                $allnum=$allnum+$num_count;

                $main.="<font face='�з���'><CENTER><H2>�]�Ϊk�H�O�W�ǲ�����|<BR>�M�H�U�Ǫ��L��M�U</H2>[ �Х[�\�����A�_�h�L�� ]<BR><BR><BR>�ǮզW�١G$school_short_name �@�@�@�ǮեN���G$school_id �@�@�@�@�@�������G$today<BR>
                <font face='�s�ө���'><table border='1' style='border-collapse: collapse' bordercolor='#006600' width='96%' cellspacing='1' cellpadding='3'>
                <tr bgcolor=$hint_color height=20>
                <td align='center'>�s��</td>
                <td align='center'>�Z��</td>
                <td align='center'>�Ǹ�</td>
                <td align='center'>�m�W</td>
                <td align='center'>�����Ҧr��</td>
                <td align='center'>�~��</td>
                <td align='center'>�U�Ǫ�(��)</td>
                <td align='center'>�ǥ�ñ��</td></tr>
                $data
                </CENTER><tr><td colspan=8>�� �����p�p�G�H�ơG $num_count �H�A���B�G $total ����C<BR>�� �֭p�ӽиɧU�ǥͼơG $allnum �H�A�ӽиɧU���B�G�s�x�� $alldollar ����C</td></tr></table><font face='�з���'><BR>$sign ";
                if($no<>$student_arr_len) $main.=$newpage;

                $num_count=0;
                $total=0;
                $data="";
	}
}
$main="<font face='�з���'><CENTER><BR><BR><BR><BR><BR><BR><H1> $work_year �Ǧ~�װ]�Ϊk�H�O�W�ǲ�����|<BR>�m�M�H�ǥͧU�Ǫ��n<BR><BR>�L��M�U�ʭ�</H1><BR><BR><BR>
        <table border='1' width='50%' cellspacing='0' cellpadding='0' bordercolordark='#008000' bordercolorlight='#008000'>
        <tr><td align=center height=45 bgcolor=$hint_color>�ǮեN��</td><td align=center>$school_id</tr>
        <tr><td align=center height=45 bgcolor=$hint_color>�ǮզW��</td><td align=center>$school_short_name</tr>
        <tr><td align=center height=45 bgcolor=$hint_color>�p���q��</td><td align=center>$school_tel</tr>
        <tr><td align=center height=45 bgcolor=$hint_color>�ǯu���X</td><td align=center>$school_fax</tr>
        <tr><td align=center height=45 bgcolor=$hint_color>�H�Ʋέp</td><td align=center>$allnum</tr>
        <tr><td align=center height=45 bgcolor=$hint_color>���B�`�p</td><td align=center>$alldollar</tr>
        <tr><td align=center height=45 bgcolor=$hint_color>������</td><td align=center>$today
        </table><BR><BR><BR><BR><BR><BR><BR>$sign".$newpage.$main;

$main="<font face='�з���'><CENTER><BR><BR><BR><BR><H1> $work_year �Ǧ~�װ]�Ϊk�H�O�W�ǲ�����|<BR>�m�M�H�ǥͧU�Ǫ���ڦ��ڡn<BR></H1><BR>
<table border='1' width='90%' cellspacing='0' cellpadding='0' bordercolordark='#008000' bordercolorlight='#008000' height='165'>
  <tr bgcolor=$hint_color>
    <td width='15%' colspan='2' align='center' height='24'>
      <p align='center'>�s��</p>
    </td>
    <td width='67%' colspan='5' height='24'>
      <p align='center'>���</td>
    <td width='33%' colspan='6' height='24'>
      <p align='center'>���@�@�@�B</td>
  </tr>
  <tr bgcolor=$hint_color>
    <td width='7%' align='center' height='18'>
      <p align='center'>�r</p>
    </td>
    <td width='6%' align='center' height='18'>
      <p align='center'>��</p>
    </td>
    <td width='67%' colspan='5' rowspan='2' height='48'>
      <p align='center'>�N��g�O�G�ǲ�����U�Ǫ�</p>
    </td>
    <td width='5%' height='18'>
      <p align='center'>�Q�U</p>
    </td>
    <td width='5%' height='18'>
      <p align='center'>�U</p>
    </td>
    <td width='5%' height='18'>
      <p align='center'>�d</p>
    </td>
    <td width='5%' height='18'>
      <p align='center'>��</p>
    </td>
    <td width='5%' height='18'>
      <p align='center'>�Q</p>
    </td>
    <td width='5%' height='18'>
      <p align='center'>��</p>
    </td>
  </tr>
  <tr>
    <td width='7%' height='28'>
      <p align='center'>�@</td>
    <td width='6%' height='28'>
      <p align='center'>�@</td>
    <td width='5%' height='28'>
      <p align='center'>�@</td>
    <td width='5%' height='28'>
      <p align='center'>�@</td>
    <td width='5%' height='28'>
      <p align='center'>�@</td>
    <td width='5%' height='28'>
      <p align='center'>�@</td>
    <td width='5%' height='28'>
      <p align='center'>�@</td>
    <td width='5%' height='28'>
      <p align='center'>�@</td>
  </tr>
  <tr bgcolor=$hint_color>
    <td width='20%' colspan='2' align='center' height='32'>
      <p align='center'>�ժ�</p>
    </td>
    <td width='15%' align='center' height='32'>
      <p align='center'>�|�p�D��</p>
    </td>
    <td width='10%' align='center' height='32'>
      <p align='center'>�f��</p>
    </td>
    <td width='10%' align='center' height='32'>
      <p align='center'>�ӿ�ǥD��</p>
    </td>
    <td width='10%' align='center' height='32'>
      <p align='center'>�ӿ�ղժ�</p>
    </td>
    <td width='10%' align='center' height='32'>
      <p align='center'>�ӿ�H</p>
    </td>
    <td width='30%' colspan='6' align='center' height='32'>
      <p align='center'>�Ʀ�</p>
    </td>
  </tr>
  <tr>
    <td width='20%' colspan='2' height='53'>
      <p align='center'>�@</td>
    <td width='15%' height='53'>
      <p align='center'>�@</td>
    <td width='10%' height='53'>
      <p align='center'>�@</td>
    <td width='10%' height='53'>
      <p align='center'>�@</td>
    <td width='10%' height='53'>
      <p align='center'>�@</td>
    <td width='10%' height='53'>
      <p align='center'>�@</td>
    <td width='30%' colspan='6' height='53'>
      <p align='center'>�@</td>
  </tr>
  </table><BR>[����H�W�ѦU�ϩӿ�ǮթΥD��Ǯծ־P��g�A�U�սФťΦL�ζ�g]<BR>
  <BR><BR><H3>�]�Ϊk�H�x�W�ǲ�����| $work_year �~�ǲ�����M�H�ǥͼ��U��
  <BR><BR>�p�s�x���GNT$ $alldollar ����A�@�p $allnum �H�C</H3>
  <BR><BR><BR><BR>[�զL�[�\�B]<BR><BR><BR><BR>
  <table border='1' width='50%' cellspacing='0' cellpadding='0' bordercolordark='#008000' bordercolorlight='#008000' height=100>
  <tr><td height='30' width='90' bgcolor=$hint_color>�@�ǮեN�X</td><td>�@$school_id</td></tr>
  <tr><td height='30' width='90' bgcolor=$hint_color>�@�ǮզW��</td><td>�@$school_short_name</td></tr>
  <tr><td height='30' width='90' bgcolor=$hint_color>�@�Ȧ�N��</td><td>�@</td></tr>
  <tr><td height='30' width='90' bgcolor=$hint_color>�@�Ȧ�W��</td><td>�@</td></tr>
  <tr><td height='30' width='90' bgcolor=$hint_color>�@�Ȧ�b��</td><td>�@</td></tr>
  <tr><td height='30' width='90' bgcolor=$hint_color>�@�b����W</td><td>�@</td></tr></table>
  <BR><BR>$sign".$newpage.$main;

  echo $main;

?>