<?php
// $Id: statistics.php 6932 2012-10-08 06:38:53Z infodaes $

include_once "config.php";
//include_once "../../include/sfs_case_dataarray.php";
sfs_check();
//�q�X����
head("�H�Ƥ��R�έp");

//�ؼШ���t_id
$type_id=$_REQUEST[type_id];
if($type_id=='') $type_id='1';

//��V������
$linkstr="type_id=$type_id";
echo print_menu($MENU_P,$linkstr);

$SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'];

//���o�Юv�ҤW�~�šB�Z��
$session_tea_sn = $_SESSION['session_tea_sn'] ;
$query =" select class_num  from teacher_post  where teacher_sn  ='$session_tea_sn'  ";
$result =  $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256) ;
$row = $result->FetchRow() ;
$class_num = $row["class_num"];

if( checkid($SCRIPT_FILENAME,1) OR $class_num) {


$clan_option=($_POST[clan_option]);
$area_option=($_POST[area_option]);
$memo_option=($_POST[memo_option]);
$note_option=($_POST[note_option]);
$sex_option=($_POST[sex_option]);
$grade_option=($_POST[grade_option]);

if($clan_option.$area_option.$memo_option.$note_option=="") $clan_option="on";

//���o�ǥͨ����C��
$type_select="SELECT d_id,t_name FROM sfs_text WHERE t_kind='stud_kind' AND d_id>0 order by t_order_id";

$recordSet=$CONN->Execute($type_select) or user_error("Ū�����ѡI<br>$type_select",256);
while (list($d_id,$t_name)=$recordSet->FetchRow()) {
        if ($type_id==$d_id)
                $typedata.="<option value='$d_id' selected>($d_id)$t_name</option>";
        else
                $typedata.="<option value='$d_id'>($d_id)$t_name</option>";
}

//���o�ǥͤl�������O�M����
$type_select="SELECT * FROM stud_subkind_ref WHERE type_id='$type_id'";
$recordSet=$CONN->Execute($type_select) or user_error("Ū�����ѡI<br>$type_select",256);
$sunkind_data=$recordSet->FetchRow();

$clan_title=$sunkind_data[clan_title];
$area_title=$sunkind_data[area_title];
$memo_title=$sunkind_data[memo_title];
$note_title=$sunkind_data[note_title];
$sex_title='�ʧO';
$grade_title='�~�ŧO';


$group_fields=(($clan_option)?"a.clan,":"").
              (($area_option)?"a.area,":"").
              (($memo_option)?"a.memo,":"").
              (($note_option)?"a.note,":"").
			  (($sex_option)?"if(b.stud_sex='1','�k','�k'),":"").
			  (($grade_option)?"left(b.curr_class_num,1),":"");

$fields_title=(($clan_option)?"<td align='center'>$clan_title</td>":"").
              (($area_option)?"<td align='center'>$area_title</td>":"").
              (($memo_option)?"<td align='center'>$memo_title</td>":"").
              (($note_option)?"<td align='center'>$note_title</td>":"").
			  (($sex_option)?"<td align='center'>$sex_title</td>":"").
			  (($grade_option)?"<td align='center'>$grade_title</td>":"").
              "<td>�H�Ʋέp</td>";

$group_fields=substr($group_fields,0,-1);

$sta_options=(($clan_title<>"")?"<input type='checkbox' name='clan_option' ".(($clan_option)?"checked":"")." onclick='this.form.submit()'>$clan_title ":"").
               (($area_title<>"")?"<input type='checkbox' name='area_option' ".(($area_option)?"checked":"")." onclick='this.form.submit()'>$area_title ":"").
               (($memo_title<>"")?"<input type='checkbox' name='memo_option' ".(($memo_option)?"checked":"")." onclick='this.form.submit()'>$memo_title ":"").
               (($note_title<>"")?"<input type='checkbox' name='note_option' ".(($note_option)?"checked":"")." onclick='this.form.submit()'>$note_title ":"").
			   (($sex_title<>"")?"<input type='checkbox' name='sex_option' ".(($sex_option)?"checked":"")." onclick='this.form.submit()'>$sex_title ":"").
			   (($grade_title<>"")?"<input type='checkbox' name='grade_option' ".(($grade_option)?"checked":"")." onclick='this.form.submit()'>$grade_title ":"");
/*
// ���X�Z�Ű}�C
$class_base = class_base($work_year_seme);
*/
//���o�έp���
$type_select="SELECT $group_fields,count(*) as `�H��` FROM stud_subkind a LEFT JOIN stud_base b ON a.student_sn=b.student_sn WHERE b.stud_study_cond=0 and a.type_id='$type_id'";
$type_select.=(!checkid($SCRIPT_FILENAME,1) AND $class_num<>'')?" AND b.curr_class_num like '$class_num%'":"";
$type_select.=" GROUP BY $group_fields";
$recordSet=$CONN->Execute($type_select) or user_error("Ū�����ѡI<br>$type_select",256);

$listdata.="<table width='100%' cellspacing='1' cellpadding='3' bgcolor='#FFCCCC'>
             <form name=\"stud_subkind\" method=\"post\" action=\"$_SERVER[PHP_SELF]\">
             <tr>
             <td><img border='0' src='images/pin.gif'>�ǥͨ����ﶵ�G<select name='type_id' onchange='this.form.submit()'>
             $typedata</select></td></tr><tr><td>�����ղέp���ءG $sta_options $sex_included $grade_included</td></tr>
             </form></table>";
//<input type='submit' value='�̿�w���زέp�C��' name='replace'>
$data=$recordSet->GetRows();

$listdata.="<table bordercolor=#55AAAA border=1 cellspacing=0 cellpadding=5><tr bgcolor=#AAFFAA>$fields_title</tr>";
$total=0;
for($i=0;$i<count($data);$i++)
{
        $listdata.="<tr>";
        //���͸�ƪ�
        for($j=0;$j<=count($data[$i])/2-1;$j++) $listdata.="<td align='center'>".($data[$i][$j]?$data[$i][$j]:"---")."</td>";
        $listdata.="</tr>";
        $total+=$data[$i][$j-1];
        }
$listdata.="<tr bgcolor='#CCCCFF'><td colspan=".($j-1)." align='center'>�X�@�@�p</td><td align='center'>$total</td></table>";
echo $listdata;


//�ˬd�O�_�����O�ݩʩ|���]�w
$type_select="SELECT count(student_sn) as members FROM stud_base WHERE stud_kind like '%,$type_id,%' AND stud_study_cond=0";
$type_select.=($class_num<>'')?" AND curr_class_num like '$class_num%'":"";
$recordSet=$CONN->Execute($type_select) or user_error("Ū�����ѡI<br>$type_select",256);
$data=$recordSet->FetchRow();
if($total<>$data['members'])
        echo "<BR><font color=#FF5555>PS.�t�εo�{�����O�]�w [ ".$data['members' ]."] �P���O�ݩʳ]�w�έp�ƾ� [ $total ] ���P�A<BR>�@ �z�i��|��[ ".($data['members']-$total)." ]�즹���ǥͪ����O�ݩʩ|���]�w�I<a href='setsubkind.php?type_id=$type_id'>[<img src='./images/set.gif' border=0>�����]�w]</a>";

} else { echo "<h2><center><BR><BR><font color=#FF0000>�z�å��Q���v�ϥΦ��Ҳ�(�D�ɮv�μҲպ޲z��)</font></center></h2>"; } 
        foot();
?>