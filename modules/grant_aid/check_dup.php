<?php
// $Id: check_dup.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";
sfs_check();

//���U���O
$type=($_REQUEST[type]);

//�Ǵ��O
$work_year_seme= ($_REQUEST[work_year_seme]);
if($work_year_seme=='')        $work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());

//�q�X����
head("���U�Ǫ�");
echo $menu;

// ���X�Z�Ű}�C
$class_base = class_base($work_year_seme);
//print_r($class_base );

//���o�Ǧ~�Ǵ��}�C
$year_seme_arr = get_class_seme();

//���o�������
$sql_select="select a.student_sn,left(a.class_num,length(a.class_num)-2) as class_id,b.stud_id,b.stud_name,count(*) as count,sum(dollar) as dollar from grant_aid a,stud_base b where a.type='$type' and a.year_seme='$work_year_seme' and a.student_sn=b.student_sn group by student_sn,class_id,stud_id,b.stud_name having count>1";

$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
//print_r($recordSet->FetchRow());

while (list($student_sn,$class_id,$stud_id,$stud_name,$count,$dollar)=$recordSet->FetchRow()) {
$data.="<tr bgcolor='#FFFFFF'><td>$student_sn</td><td>$class_base[$class_id]</td><td>$stud_id</td><td>$stud_name</td><td>$count</td><td>$dollar</td></tr>";
}
        $main="<table width='96%' cellspacing='1' cellpadding='3' bgcolor='$hint_color'>
        <tr><td colspan=5><center><img border='0' src='images/pin.gif'>�ˬd���Ǧ~(��)�O�G$year_seme_arr[$work_year_seme]�@�@�@�@�@�@�@�@�@�@<a href='index.php?type=$type&work_year_seme=$work_year_seme'><img border='0' src='images/back.gif'>�^�W�@��</a></center></td></tr>
        <tr bgcolor='#CCCCFF'><td>���y�y����</td><td>�Z��</td><td>�Ǹ�</td><td>�m�W</td><td>���Ʋέp</td><td>���B�έp</td></tr>
        $data
        </table>";
echo $main;
foot();
?>