<?php

// $Id: talk_count.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";

//���o��ܾǦ~�פξǴ��A�p:0921
$select_year_seme=$_POST["select_year_seme"];

$year=get_curr_year($select_year_seme);//���o��ܤ��Ǧ~�A�p92
$semester=get_curr_seme($select_year_seme);//���o��ܤ��Ǵ��A�p1

if(empty($year))$year=curr_year();//�w�]�����~��
if(empty($semester))$semester=curr_seme();//�w�]�����Ǵ�

head("�ǥͳX�ͬ�����g����");

//�C�X�έp

$main=list_talk($year,$semester);
echo $main  ;

foot();
//�C�X�Ҧ��Z�Ū����
function list_talk($year,$semester,$count_num){
	global $menu_p,$CONN ;
	$toolbar=&make_menu($menu_p);

        //���U�ϥ�select_yearseme_form ��ܾǦ~�׾Ǵ��U�Կ��
        $select_yearseme_form="<form method='post' action='".basename($_SERVER["PHP_SELF"])."'>";
        $class_seme_p = get_class_seme(); //�Ǧ~��
        $upstr = "<select name='select_year_seme' onchange='this.form.submit()'>";
        while (list($tid,$tname)=each($class_seme_p)){
        	if ($tid=="0".$year.$semester)
              		$upstr .= "<option value='".$tid."' selected>".$tname."</option>";//$tid�p"0921"
              	else
              		$upstr .= "<option value='".$tid."'>".$tname."</option>";
        }
        $upstr .= "</select>";
        $select_yearseme_form.= $upstr."</form>";
        //select_yearseme_form ����


        //��X�Ǵ��]�w���Z��
        $sql_select = "select class_id ,teacher_1 from school_class where year='$year' and semester='$semester' order by c_year,c_sort";
       	$record_class=$CONN->Execute($sql_select) or die($sql_select);
        $num_class=$record_class->RecordCount();//�Z�Ťp�p
        if ($num_class<1){
           echo "���~�A�䤣���ݩ�Ӧ~�ת��Z�ų]�w�I";
           exit;
        }
        $show.="<table border='1'><tr bgcolor='#00ffff'><td>�Z��</td><td>�H��</td><td>������</td><td>�L����</td><td>�ݬ������ǥ�</td><td>�ɮv</td></tr>";
        //�v�Z�����
        while ($array_class = $record_class->FetchRow()) {
              $temp = explode("_",$array_class[class_id]); //091_1_07_01$array_class
              $temp[2]=(substr($temp[2],0,1)=='0')?substr($temp[2],1,strlen($temp[2]-1)):$temp[2];
              $temp_class=$temp[2].$temp[3];//$class_temp���Z�šA�p701

              //�̯Z�ŴM��ŦX���ǥ�
              $sel_year_seme=sprintf("%03d%d",$year,$semester);//�榡�ƾǴ���4��ơA�p0911
              $sql_select = "select b.stud_id ,b.seme_num ,a.stud_name from stud_base a, stud_seme b where a.student_sn=b.student_sn and (a.stud_study_cond=0 or a.stud_study_cond=5) and b.seme_year_seme='$sel_year_seme' and b.seme_class='$temp_class' order by b.seme_num";
              $record_stud=$CONN->Execute($sql_select) or die($sql_select);

              $num_all=$record_stud->RecordCount();//�Z�ŤH��
              $num_yes=0;//�Z�Ťw��J���H�ư_�l
              $num_no=0;//�Z�ť���J���H�ư_�l
              $name_no="-";//�ݿ�J���ǥͩm�W
              $name_teacher=$array_class[teacher_1];//�Z�žɮv
              while ($array_stud = $record_stud->FetchRow()) {
                      //�M��stud_seme_talk���A�Ǧ~�פξǸ��۲Ū����
                      $sql_select = "select stud_id from stud_seme_talk where seme_year_seme='$sel_year_seme' and stud_id='$array_stud[stud_id]'";
                      $record_num=$CONN->Execute($sql_select) or die($sql_select);

                      if ($record_num->RecordCount()>0) $num_yes++;//��즳���
                      //�Y�䤣��A�����Ӿǥͮy���Ωm�W
                      else $name_no.="(".$array_stud[seme_num].")".$array_stud[stud_name].",";
              }
              //�h���ݿ�J�ǥͤ��h�l�r��(�}�Y-�ε���,)
              $name_no=(strlen($name_no)>1)?substr($name_no,1,strlen($name_no)-2):$name_no;
              //�p�⥼��J���H��
              $num_no=$num_all-$num_yes;
              //��X��C��T
              $show.=($num_no>0)?"<tr bgcolor='#ffccff'><td>":"<tr><td>";
              $show.=($temp[2]>6)?$temp[2]-6:$temp[2];//�ꤤ�p�P�_
              $show.=$temp[3]."</td>";
              $show.="<td>$num_all �H</td><td>$num_yes �H</td><td>$num_no �H</td><td width='350'>$name_no</td><td>$name_teacher</td></tr>";
        }
        $show.="</table>";

	$help_text="
	���{���D�n���ˬd�C�Ǵ��U�Z�ǥͤ�[���ɳX��]�O�_���L���������ΡC||�C���������Ǵ��P�_�H��J��ɬ��ǡA�P����������L���C";
	$help=&help($help_text);

        return $toolbar.$help.$select_yearseme_form.$show;
}
?>
