<?php

// $Id: stud_birth.php 5310 2009-01-10 07:57:56Z hami $

/*�ޤJ�ǰȨt�γ]�w��*/
include "config.php";

//�ϥΪ̻{��

sfs_check();
if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
$teacher_sn=$_SESSION['session_tea_sn'];//���o�n�J�Ѯv��id
//��X���ЯZ��
$class_name=teacher_sn_to_class_name($teacher_sn);

$stud_study_year = curr_year() - substr($class_name[0],0,1) +1;

head("�ͤ����W��") ;
print_menu($menu_p);

    $sqlstr = " select   month(stud_birthday) as TM , count(*) as TC
               from stud_base
               where stud_study_cond  = 0
               and  curr_class_num  like '$class_name[0]%'
               group by  TM " ;
    //echo $sqlstr ;
    $recordSet=$CONN->Execute($sqlstr);

    while (!$recordSet->EOF) {
         $monthN = $recordSet->fields["TM"] ;                        //���
         $studN         = $recordSet->fields["TC"] ;                //�H��
         $birth_array[$monthN] = $studN ;                //��b [���]�}�C��
         $recordSet->MoveNext();
     }

     /*
     ���o�m�W�B�ͤ����B�ͤ�(��)�A������ӱƦC
     select month(stud_birthday) as TM , stud_name , , DAYOFMONTH(stud_birthday) as TD
     from stud_base
     where condition= 0
     and class_num_8 like '407%'
     order by TM

     */
    $sqlstr = " select   month(stud_birthday) as TM , stud_name  , DAYOFMONTH(stud_birthday) as TD
               from stud_base
               where stud_study_cond  = 0
               and  curr_class_num  like '$class_name[0]%'
               order by  TM ,TD " ;
    //echo $sqlstr ;
    $recordSet=$CONN->Execute($sqlstr);

    while (!$recordSet->EOF) {
            $tm= $recordSet->fields["TM"] ;
            $s_name = $recordSet->fields["stud_name"] ;
            $s_birthday = $recordSet->fields["TD"] ;
            $tmem[$tm] .=  $s_name . "(" . $s_birthday ."��)�B " ;
            $recordSet->MoveNext();
    }

    echo "<h2 align=\"center\">$class_name[1]-�ͤ����H�Ʋέp </hr><br>"  ;
    echo ' <table width="96%" border="1" cellspacing="0" BGCOLOR="#FDDDAB" align="center" cellpadding=2  bordercolor=#008080  bordercolorlight=#666666 bordercolordark=#FFFFFF> ' ;
    echo '<tr align="center"><td>���</td><td>�H��</td><td>�ǥͩm�W</td> ' ;

    for ($m= 1 ; $m<=12 ; $m++) {                //�U����H��

        if ($birth_array[$m] >0) {
           $all_stud += $birth_array[$m] ;
           echo "<tr align=\"center\">" ;
           echo "<td> $m ��</td><td>". $birth_array[$m]." �H</td><td align=\"left\">" . $tmem[$m]. "</td>" ;
           echo "</tr>" ;
        }
        else {
           echo "<tr align=\"center\">" ;
           echo "<td> $m ��</td><td> 0 �H</td><td align=\"left\">&nbsp;</td>" ;
           echo "</tr>" ;
        }
    }

    echo "</table><br>" ;
    echo "�@ $all_stud �H" ;


foot() ;

?>