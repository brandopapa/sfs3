<?php

// $Id: eduh_count.php 7858 2014-01-14 02:25:24Z hsiao $

include "config.php";

sfs_check();

head("����--��Ƭd��");
$year = curr_year(); //�w�]�����~��
$semester = curr_seme(); //�w�]�����Ǵ�
//���o���ЯZ�ťN��
$class_num = get_teach_class();
if ($class_num == '') {
    head("�v�����~");
    stud_class_err();
    foot();
    exit;
}
head("�d_���ɤγX�ͬ���");

//�C�X�έp

$main = list_eduh($year, $semester, $class_num);
echo $main;

foot();

//�C�X�Ҧ��Z�Ū����
function list_eduh($year, $semester, $class_num) {
    global $menu_p, $CONN;
    $toolbar = &make_menu($menu_p);

    //$show.="<table border='1'><tr bgcolor='#00ffff'><td>�Z��</td><td>�H��</td><td>������</td><td>�L����</td><td>�ݬ������ǥ�</td><td>�ɮv</td></tr>";
    $show.="<table border='1' width='100%'><tr bgcolor='#00ffff'><td width='40'>�y��</td><td width='60'>�ǥ�</td><td width='60'>���A</td><td>���ɬ���</td><td width='150'>�X�ͬ���</td></tr>";

    //�̯Z�ŴM��ŦX���ǥ�
    $sel_year_seme = sprintf("%03d%d", $year, $semester); //�榡�ƾǴ���4��ơA�p0911
    $sql_select = "select a.stud_study_cond ,b.stud_id ,b.seme_num ,a.stud_name from stud_base a, stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$sel_year_seme' and b.seme_class='$class_num' order by b.seme_num";
    $record_stud = $CONN->Execute($sql_select) or die($sql_select);

    /*
      $num_yes=0;//�Z�Ťw��J���H�ư_�l
      $num_no=0;//�Z�ť���J���H�ư_�l
      $name_no="-";//�ݿ�J���ǥͩm�W
      $name_teacher=$array_class[teacher_1];//�Z�žɮv
     */
    while ($array_stud = $record_stud->FetchRow()) {
        //�M��stud_seme_eduh���A�Ǧ~�פξǸ��۲Ū����
        $show.="<tr><td>" . $array_stud[seme_num] . "</td>";
        $show.="<td>" . $array_stud[stud_name] . "</td>";
        if ($array_stud["stud_study_cond"] > 0) {
            $move_kind_arr = study_cond();
            $show.= "<td><font color=red>" . $move_kind_arr[$array_stud["stud_study_cond"]] . "</font></td>";
        }//�W�[ } �O�� by misser 93.10.20
        else
            $show.= "<td><font color='blue'>�@��</font></td>";

        $sql_select = "select * from stud_seme_eduh where seme_year_seme='$sel_year_seme' and stud_id='$array_stud[stud_id]'";
        $record_num = $CONN->Execute($sql_select) or die($sql_select);
        if ($record_num->RecordCount() > 0) {
            $nothing = "";
            if ($record_num->fields["sse_relation"] == 0)
                $nothing.="*�������Y";
            if ($record_num->fields["sse_family_kind"] == 0)
                $nothing.="*�a�x����";
            if ($record_num->fields["sse_family_air"] == 0)
                $nothing.="*�a�x��^";
            if ($record_num->fields["sse_farther"] == 0)
                $nothing.="*���ޱФ覡";
            if ($record_num->fields["sse_mother"] == 0)
                $nothing.="*���ޱФ覡";
            if ($record_num->fields["sse_live_state"] == 0)
                $nothing.="*�~����";
            if ($record_num->fields["sse_rich_state"] == 0)
                $nothing.="*�g�٪��p";
            if ($record_num->fields["sse_s1"] == "")
                $nothing.="*�̳߷R���";
            if ($record_num->fields["sse_s2"] == "")
                $nothing.="*�̧x�����";
            if ($record_num->fields["sse_s3"] == "")
                $nothing.="*�S��~��";
            if ($record_num->fields["sse_s4"] == "")
                $nothing.="*����";
            if ($record_num->fields["sse_s5"] == "")
                $nothing.="*�ͬ��ߺD";
            if ($record_num->fields["sse_s6"] == "")
                $nothing.="*�H�����Y";
            if ($record_num->fields["sse_s7"] == "")
                $nothing.="*�~�V�欰";
            if ($record_num->fields["sse_s8"] == "")
                $nothing.="*���V�欰";
            if ($record_num->fields["sse_s9"] == "")
                $nothing.="*�ǲߦ欰";
            if ($record_num->fields["sse_s10"] == "")
                $nothing.="*���}�ߺD";
            if ($record_num->fields["sse_s11"] == "")
                $nothing.="*�J�{�欰";
            if ($nothing == "")
                $show.="<td>�����</td>"; //��즳���
            else
                $show.="<td bgcolor='yellow'><font color='red'>����J�G" . $nothing . "*</font></td>";
        }
        //�Y�䤣��A�����Ӿǥͮy���Ωm�W
        else {
            if ($move_kind_arr[$array_stud["stud_study_cond"]] == '�ծ�')
                $show.="<td bgcolor='yellow'><font color='red'>�w�ծաA�Y�n�ɵn�O���A�i�е��U�ե��N���y�Ȥ��C</font></td>";
            else
                $show.="<td bgcolor='yellow'><font color='red'>�|���إߡA�иɤW�C</font></td>";
        }
        //�M��stud_seme_talk���A�Ǧ~�פξǸ��۲Ū����
        $sql_select = "select stud_id from stud_seme_talk where seme_year_seme='$sel_year_seme' and stud_id='$array_stud[stud_id]'";
        $record_num = $CONN->Execute($sql_select) or die($sql_select);

        if ($record_num->RecordCount() > 0) {
            $show.="<td>" . $record_num->RecordCount() . "��</td>"; //��즳���
        }
//�Y�䤣��
        else {
            if ($move_kind_arr[$array_stud["stud_study_cond"]] == '�ծ�')
                $show.="<td bgcolor='yellow'><font color='red'>�w�ծաA��<a href=\"" . $SFS_PATH_HTML . "stud_seme_talk2.php\">����</a>�ɵn�O���C</font></td>";
            else
                $show.="<td bgcolor='yellow'><font color='red'>�|���إߡA�иɤW�C</font></td>";
        }

        $show.="</tr>";
    }
    /*
      //�h���ݿ�J�ǥͤ��h�l�r��(�}�Y-�ε���,)
      $name_no=(strlen($name_no)>1)?substr($name_no,1,strlen($name_no)-2):$name_no;
      //�p�⥼��J���H��
      $num_no=$num_all-$num_yes;
      //��X��C��T
      $show.=($num_no>0)?"<tr bgcolor='#ffccff'><td>":"<tr><td>";
      $show.=($temp[2]>6)?$temp[2]-6:$temp[2];//�ꤤ�p�P�_
      $show.=$temp[3]."</td>";
      $show.="<td>$num_all �H</td><td>$num_yes �H</td><td>$num_no �H</td><td width='350'>$name_no</td><td>$name_teacher</td></tr>";
     */
    $show.="</table>";
    return $toolbar . $select_yearseme_form . $show;
}

?>
