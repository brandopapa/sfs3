<?php
// $Id: index.php 7132 2013-02-21 07:56:52Z infodaes $

include "config.php";
include "../../include/sfs_case_score.php";

sfs_check();
//�q�X����
head("���U�Ǫ�");
echo $menu;

//�Ǵ��O
$work_year_seme= ($_POST[work_year_seme])?$_POST[work_year_seme]:$_GET[work_year_seme];
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());
$work_year_seme=$work_year_seme?$work_year_seme:$curr_year_seme;

//���o�e�@�Ǵ����N��
$seme_list=get_class_seme();
$seme_key_list=array_keys($seme_list);
$pre_seme=$seme_key_list[(array_search($work_year_seme,$seme_key_list))+1];
$seme_array=array($pre_seme);
$sn_array=array();

// ���X�Z�Ű}�C
$class_base = class_base($work_year_seme);

//���o�Ǧ~�Ǵ��}�C
$year_seme_arr = get_class_seme();

//���o�~�׸��
$year_select="select distinct year_seme from grant_aid where type='$type'";
$recordSetYear=$CONN->Execute($year_select) or user_error("Ū�����ѡI<br>$year_select",256);
while (list($year_seme)=$recordSetYear->FetchRow()) {
        if ($work_year_seme==$year_seme)
                $yeardata.="<option value='$year_seme' selected >$year_seme_arr[$year_seme]</option>";
        else
                $yeardata.="<option value='$year_seme'>$year_seme_arr[$year_seme]</option>";
}

//���o�ŦX�����
$subkind_array=array();
$sql="SELECT * FROM stud_subkind WHERE type_id=$type_id ORDER BY student_sn";
$rs=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>���Ҳջݭn���w��[�ǥͨ����l���O]�Ҳ�,�Цw�˫�A��!<br><br>$sql",256);
while(!$rs->EOF){
	$student_sn=$rs->fields['student_sn'];
	$subkind_array[$student_sn]['clan']=$rs->fields['clan'];
	$subkind_array[$student_sn]['area']=$rs->fields['area'];
	$subkind_array[$student_sn]['memo']=$rs->fields['memo'];
	$subkind_array[$student_sn]['note']=$rs->fields['note'];
	$rs->MoveNext();
}

//���o�������
//$sql_select="SELECT a.sn,a.year_seme,left(a.class_num,length(a.class_num)-2) as class_id,a.student_sn,a.class_num,b.stud_id,b.stud_name,a.dollar,b.stud_birthday,b.stud_person_id,c.clan,c.area FROM grant_aid a,stud_base b,stud_subkind c WHERE a.student_sn=c.student_sn AND a.year_seme='$work_year_seme' AND a.type='$type' AND a.student_sn=b.student_sn AND c.type_id=$type_id ORDER BY class_num";
$sql_select="SELECT a.sn,a.year_seme,left(a.class_num,length(a.class_num)-2) as class_id,a.student_sn,a.class_num,b.stud_id,b.stud_name,a.dollar,b.stud_birthday,b.stud_person_id FROM grant_aid a LEFT JOIN stud_base b ON a.student_sn=b.student_sn WHERE a.year_seme='$work_year_seme' AND a.type='$type' ORDER BY class_num";
$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);

while (list($sn,$year_seme,$class_id,$student_sn,$class_num,$stud_id,$stud_name,$dollar,$stud_birthday,$stud_person_id)=$recordSet->FetchRow()) {
$no++;
//���o�Ǵ����Z
$sn_array[0]=$student_sn;
$sub_score=cal_fin_score($sn_array,$seme_array);
$nor_score=cal_fin_nor_score($sn_array,$seme_array);

//�C�� 60�H�U����   60-70 �L����
switch (substr($sub_score[$student_sn][avg][score],0,1)) {
case 0:
    $row_color="#777777";
    break;
case 1:
    $row_color="#888888";
    break;
case 2:
    $row_color="#999999";
    break;
case 3:
    $row_color="#AAAAAA";
    break;
case 4:
    $row_color="#BBBBBB";
    break;
case 5:
    $row_color="#CCCCCC";
    break;
case 6:
    $row_color="#DDDDDD";
    break;
case 7:
    $row_color="#EEEEEE";
    break;
default:
    $row_color="#FFFFFF";
    break;
}

	
$clan=$subkind_array[$student_sn]['clan']?$subkind_array[$student_sn]['clan']:"<center><a href='../stud_subkind/setsubkind.php?type_id=$type_id'><img border=0 src='./images/set.gif'></a></center>";

$data.="<tr bgcolor='$row_color'>
         <td>$no</td>
         <td>$class_base[$class_id]</td>
         <td>$stud_id</td>
         <td>$stud_name</td>
         <td>$dollar</td>
         <td>$clan</td>
         <td>{$subkind_array[$student_sn]['area']}</td>
         <td><a href='modify.php?act=modify&sn=$sn'><img border='0' src='images/modify.png' alt='�ק�'></a> | <a href='modify.php?act=del&sn=$sn&type=$type' onclick='return confirm(\"�u���n�R�� $stud_name ?\")'><img border='0' src='images/delete.png' alt='�R��[ $stud_name ]'></a></td>
         <td>".$sub_score[$sn_array[0]][language][$seme_array[0]][score]."</td>
         <td>".$sub_score[$sn_array[0]][math][$seme_array[0]][score]."</td>
         <td>".$sub_score[$sn_array[0]][health][$seme_array[0]][score]."</td>";

    if($sub_score[$student_sn][succ]==5){ $data.="<td align='center' colspan='3'>".$sub_score[$student_sn][life][avg][score]."</td>";}
        else {
              $data.="<td align='center'>".$sub_score[$student_sn][social][avg][score]."</td>
                  <td align='center'>".$sub_score[$student_sn][art][avg][score]."</td>
                  <td align='center'>".$sub_score[$student_sn][nature][avg][score]."</td>";
                    }
    $data.="<td>".$sub_score[$sn_array[0]][complex][$seme_array[0]][score]."</td>
         <td align='center'>".$sub_score[$student_sn][avg][score]."</td>
         <td>".$nor_score[$sn_array[0]][$seme_array[0]][score]."</td></tr>";
}
        $main="
        <table width='100%' cellspacing='1' cellpadding='3' bgcolor='$hint_color'><tr><td><form name=\"year_form\" method=\"post\" action=\"$_SERVER[PHP_SELF]\"><img border='0' src='images/pin.gif'>�Ǧ~(��)�O�G<select name='work_year_seme' onchange='this.form.submit()'><option value=''></option>$yeardata</select></td>
                <td><input type='hidden' name='type' value='$type'>
        �@<a href='batchadd.php?type=$type'><img border='0' src='images/batchadd.gif' alt='($curr_year_seme)'>�������O���</a>
        �@<a href='add.php?type=$type'><img border='0' src='images/add.gif' alt='($curr_year_seme)'>�ӤH���</a>
        �@<a href='check_dup.php?type=$type&work_year_seme=$work_year_seme'><img border='0' src='images/check.png' alt='($work_year_seme)'>�ˬd���ƦW��</a>
        �@<a href='deleteall.php?type=$type'><img border='0' src='images/trash.gif' alt='($curr_year_seme)'>�M�ť��Ǵ��W��</a>
        �@<a href='statistics.php?type=$type'><img border='0' src='images/sigma.gif'>�έp</a></form></td></tr></table>
        <table cellspacing='1' cellpadding='3' bgcolor='#C0C0C0'>
        <tr bgcolor='#E6E9F9'>
        <td>�s��</td>
        <td>�Z��</td>
        <td>�Ǹ�</td>
        <td>�m�W</td>
        <td>���B</td>
        <td><a href='../stud_subkind/setsubkind.php?type_id=$type_id'>$clan_title</a></td>
        <td>$area_title</td>
        <td>�s|�R</td>
        <td>�y��</td>
        <td>�ƾ�</td>
        <td>����</td>
        <td>���N</td>
        <td>�۵M</td>
        <td>���|</td>
        <td>��X</td>
        <td>��쥭��</td>
        <td>��`��{</td>
        </tr>
        $data
        </table><P align='center'>
        <a href='".$menudata[$menu_id][2]."?type=$type&work_year_seme=$work_year_seme&rows=&height=' target='_blank'><img border='0' src='images/htm.gif?type=$type'> HTML�L��M�U</a>�@�@
        <a href='".$menudata[$menu_id][3]."?type=$type&work_year_seme=$work_year_seme&rows=&height=' target='_blank'><img border='0' src='images/htm.gif?type=$type'> HTML�ӽЪ�</a>�@�@
        <a href='".$menudata[$menu_id][4]."?type=$type&work_year_seme=$work_year_seme'><img border='0' src='images/csv.png'> CSV�ɿ�X</a>
        �@�@�@�@�@�@ PS.���Z�C�ܾǴ��G$seme_list[$pre_seme]</P>";

echo $main;

foot();
?>