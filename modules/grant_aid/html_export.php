<?php
// $Id: html_export.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";
sfs_check();

//�Ǯո�T
$school_id=$SCHOOL_BASE["sch_id"];
$school_tel=$SCHOOL_BASE["sch_phone"];
$school_fax=$SCHOOL_BASE["sch_fax"];
$school_area=$SCHOOL_BASE["sch_sheng"]."�F��";

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
        <td align='center'>$clan($area)</td>
        <td align='center'>$dollar </td>
        <td align='center'></td>
	</tr>";

        //������X  $num_count==20 �N��C���L20�H
        if(($num_count % $rows==0) or $no==$student_arr_len) {
                $page=$page+1;
                $alldollar=$alldollar+$total;
                $allnum=$allnum+$num_count;
                
                $main.="<font face='�з���'><CENTER><H2>".$school_area.$work_year."�Ǧ~�׵o��NŪ�������߰�����p��<BR>�����ھǥ;ǥζO�L��M�U</H2>[ �Х[�\�����A�_�h�L�� ]<BR><BR><BR>�ǮզW�١G$school_short_name �@�@�@�ǮեN���G$school_id �@�@�@�@�@�������G$today<BR>
                <font face='�s�ө���'><table border='1' style='border-collapse: collapse' bordercolor='#006600' width='96%' cellspacing='1' cellpadding='3'>
                <tr bgcolor=$hint_color height=20><td align='center'>�s��</td><td align='center'>�Z��</td><td align='center'>�Ǹ�</td><td align='center'>�m�W</td><td align='center'>�����Ҧr��</td><td align='center'>�����ڧO</td><td align='center'>���B(��)</td><td align='center'>�ǥ�ñ��</td></tr>
                $data
                </CENTER><tr><td colspan=8>�� �����p�p�G�H�ơG $num_count �H�A���B�G $total ����C<BR>�� �֭p�����ǥͼơG $allnum �H�A�ӽиɧU���B�G�s�x�� $alldollar ����C</td></tr></table><font face='�з���'><BR>$sign ";
                if($no<>$student_arr_len) $main.=$newpage;

                $num_count=0;
                $total=0;
                $data="";
        }

}

$main="<font face='�з���'><CENTER><BR><BR><BR><BR><BR><BR><H1>".$school_area.$work_year."�Ǧ~��<BR>�o��NŪ�������߰�����p��<BR><BR><BR>�m�����ھǥ;ǥζO�n<BR><BR>�L��M�U�ʭ�</H1><BR><BR><BR>
        <table border='1' width='50%' cellspacing='0' cellpadding='0' bordercolordark='#008000' bordercolorlight='#008000'>
        <tr><td align=center height=45 bgcolor=$hint_color>�ǮեN��</td><td align=center>$school_id</tr>
        <tr><td  align=center height=45 bgcolor=$hint_color>�ǮզW��</td><td align=center>$school_short_name</tr>
        <tr><td  align=center height=45 bgcolor=$hint_color>�p���q��</td><td align=center>$school_tel</tr>
        <tr><td  align=center height=45 bgcolor=$hint_color>�ǯu���X</td><td align=center>$school_fax</tr>
        <tr><td align=center height=45 bgcolor=$hint_color>�H�Ʋέp</td><td align=center>$allnum</tr>
        <tr><td align=center height=45 bgcolor=$hint_color>���B�`�p</td><td align=center>$alldollar</tr>
        <tr><td align=center height=45 bgcolor=$hint_color>������</td><td align=center>$today
        </table><BR><BR><BR><BR><BR><BR><BR>$sign".$newpage.$main;

echo $main;

?>