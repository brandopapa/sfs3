<?php
// $Id $

include "config.php";
sfs_check();


//�Ǯո�T
$school_id=$SCHOOL_BASE["sch_id"];
$school_tel=$SCHOOL_BASE["sch_phone"];
$school_fax=$SCHOOL_BASE["sch_fax"];
$school_area=$SCHOOL_BASE["sch_sheng"];

//���Ѫ����
$today=(date("Y")-1911).date("�~m��d��");

//�Ǵ��O
$work_year_seme= ($_POST[work_year_seme])?$_POST[work_year_seme]:$_GET[work_year_seme];
if($work_year_seme=='')        $work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
$work_year=substr($work_year_seme,0,3)+0;

//�C���P�C��
$height= ($_POST[height])?$_POST[height]:$_GET[height];
if($height=="") $height=35;

$rows= ($_POST[rows])?$_POST[rows]:$_GET[rows];
if($rows=="") $rows=10;

//����html�X
$newpage="<P STYLE='page-break-before: always;'>";


//ñ���C
$sign="�ӿ�H�G�@�@�@�@�@�@�@�@�X�ǡG�@�@�@�@ �@�@�@�@�|�p�G�@�@�@ �@�@�@�@�D���G�@�@�@�@�@�@�@�@�@�ժ��G�@�@�@�@�@";

// ���X�Z�Ű}�C
$class_base = class_base($work_year_seme);

//���o�Ǧ~�Ǵ��}�C
$year_seme_arr = get_class_seme();

//���o���վǥͤH��
$year_select="select count(*) from stud_base where stud_study_cond=0";
$recordSet=$CONN->Execute($year_select) or user_error("Ū�����ѡI<br>$year_select",256);
$student_total=$recordSet->FetchRow();

//���o�����ǥͤH��    d_id=9
$type_select="SELECT count(*) FROM stud_base WHERE stud_study_cond=0 and stud_kind like '%,$type_id,%'";
$recordSet=$CONN->Execute($type_select) or user_error("Ū�����ѡI<br>$type_select",256);
$yuanzhumin_total=$recordSet->FetchRow();



//���o�������
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
        <td align='center'>$stud_name</td>
        <td align='center'>$stud_person_id</td>
        <td align='center'>$clan</td>
        <td align='center'>$area</td>
        <td align='center'></td>
        <td align='center'>��</td>
        <td align='center'></td>
        <td align='right'>$dollar &nbsp;</td>
        <td></td></tr>";

        //������X  $num_count==20  �N��C���L20�H
        if(($num_count % $rows==0) or $no==$student_arr_len) {
                $page=$page+1;
                $alldollar=$alldollar+$total;
                $allnum=$allnum+$num_count;
//                 <td>���վǥͤH�ơG_____<br>���խ����ǥͤH�ơG___________<br>���տ�e�H�ơG___________</td>
//                <td>�q�ܡG$school_tel <br>�ǯu�G$school_fax </td>
                $main.="<font face='�з���'><CENTER><H2>$school_area".$year_seme_arr[$work_year_seme]."�ӽа�����p�ǭ����ǥͼ��Ǫ�����ҩ��[�L��M�U</H2>[ �Х[�\�����A�H��㦳�k�ߪ��ĤO ]<BR><BR><BR>
                �ǮզW�١G[ $school_short_name ]�@�@�ǮեN���G[ $school_id ]�@�@�������G[ $today ]
                <font face='�s�ө���'><table border='1' style='border-collapse: collapse' bordercolor='#006600' width='96%' cellspacing='1' cellpadding='3'>
  <tr bgcolor=$hint_color>
    <td width='3%'  align='center' rowspan='2'>NO</td>
    <td width='10%'  align='center' rowspan='2'>�Z��</td>
    <td width='9%'  align='center' rowspan='2'>�m�W</td>
    <td width='12%'  align='center' rowspan='2'>�����Ҧr��</td>
    <td width='10%'  align='center' rowspan='2'>���y</td>
    <td width='8%'  align='center' rowspan='2'>�a��O</font></td>
    <td width='24%' height='15' colspan='3' align='center'><font size='2'>�ӽШ̾� (�Цb�A�X�ﶵ������)</font></td>
    <td width='6%'  align='center' rowspan='2'>���B</td>
    <td width='10%'  align='center' rowspan='2'>�ǥ�ñ��</td>
  </tr>
  <tr bgcolor=$hint_color>
    <td width='8%' height='16' align='center'><font size='1'>�S���u�}��{</font></td>
    <td width='7%' height='16' align='center'><font size='1'>�e�Ǵ����Z</font></td>
    <td width='6%' height='16' align='center'><font size='1'>�Ǯտ���</font></td>
  </tr>
                $data
                <tr bgcolor=$hint_color>
    <td align='left' colspan='11'>
      <font size='2'>&nbsp;���g�d�W��ҦC�ǥͽT��㦳�������y�A��e�Ǵ��NŪ������{�u���A�ìҥ��⦳��L�F�������Τ���Ʒ~��줧���Ǫ��A�S���ҩ��C</font>
    </td>
  </tr>
                </CENTER><tr><td colspan=11>�� �����p�p�G�H�ơG $num_count �H�A���B�G $total ����C�@�@�@�� �֭p�����ǥͼơG $allnum �H�A�ӽиɧU���B�G�s�x�� $alldollar ����C</td></tr></table><font face='�з���'><BR>$sign ";
                if($no<>$student_arr_len) $main.=$newpage;

                $num_count=0;
                $total=0;
                $data="";
	}
}


$main="<font face='�з���'><CENTER><BR><BR><H1>$school_area".$year_seme_arr[$work_year_seme]."������p��<BR><BR>�m�����ǥͼ��Ǫ��n<BR><BR>����ҩ��[�L��M�U�ʭ�</H1><BR>
        <table border='1' width='60%' cellspacing='0' cellpadding='0' bordercolordark='#008000' bordercolorlight='#008000'>
        <tr><td align=center height=30 width=30% bgcolor=$hint_color>�ǮեN��</td><td align=center>$school_id</tr>
        <tr><td  align=center height=30 bgcolor=$hint_color>�ǮզW��</td><td align=center>$school_long_name</tr>
        <tr><td  align=center height=30 bgcolor=$hint_color>�p���q��</td><td align=center>$school_tel</tr>
        <tr><td  align=center height=30 bgcolor=$hint_color>�ǯu���X</td><td align=center>$school_fax</tr>
        <tr><td  align=center height=30 bgcolor=$hint_color>�Ǯ�����</td><td align=center>���������I�ꤤ�p�@���@��ꤤ�p</td></tr>
        <tr><td  align=center height=30 bgcolor=$hint_color>���վǥͤH��</td><td align=center>$student_total[0]</tr>
        <tr><td  align=center height=30 bgcolor=$hint_color>�����ǥͼ�</td><td align=center>$yuanzhumin_total[0]</tr>
        <tr><td align=center height=30 bgcolor=$hint_color>���տ�e�H��</td><td align=center>$allnum</tr>
        <tr><td align=center height=30 bgcolor=$hint_color>�ӽЪ��B�`�p</td><td align=center>$alldollar</tr>
        <tr><td align=center height=30 bgcolor=$hint_color>������</td><td align=center>$today</table><BR><BR>$sign".$newpage.$main;
        echo $main;


echo "<script language=\"Javascript\"> alert (\"������w�]�L��榡��A4��L�A�L��e�аO�o�]�w��I\")</script>";




?>