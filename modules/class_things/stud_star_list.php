<?php

include "config.php";

//���o�P�y�O
$star_type=$_POST[type];

//�w�q�P�y�}�C
if($star_type<>'�Q�T�P�y')
{     //���w�O12�P�y
      $type_select="<select size='1' name='type' onchange='this.form.submit()'><option selected>�Q�G�P�y</option><option>�Q�T�P�y</option></select>";
      $star_name=array("���~<br>12/23-01/20","���~<br>01/21-02/19","����<br>02/20-03/20","�d��<br>03/21-04/20",
           "����<br>04/21-05/21","���l<br>05/22-06/21","����<br>06/22-07/23","��l<br>07/24-08/23",
           "�B�k<br>08/24-09/23","�ѯ�<br>09/24-10/23","����<br>10/24-11/22","�g��<br>11/23-12/22",
           "�Z��<br>�H��");
           $star_date=array(120,219,320,420,521,621,723,823,923,1023,1122,1222,1231);
      } else {
            $type_select="<select size='1' name='type' onchange='this.form.submit()'><option>�Q�G�P�y</option><option selected>�Q�T�P�y</option></select>";
      $star_name=array("�g��<br>12/18-01/19","�s��<br>01/20-02/17","���~<br>02/18-03/12","����<br>03/13-04/18",
           "�զ�<br>04/19-05/13","����<br>05/14-06/22","���l<br>06/23-07/21","����<br>07/22-08/10",
           "��l<br>08/11-09/16","�B�k<br>09/17-10/31","�ѯ�<br>11/01-11/23","���<br>11/24-11/29",
           "�D��<br>11/30-12/17","�Z��<br>�H��");
           $star_date=array(119,217,312,418,513,622,721,810,916,1031,1123,1129,1217,1231);
              }

$star_arr=array();
$star_total=array();
$star_len=count($star_name)-1;

$teacher_sn=$_SESSION['session_tea_sn'];//���o�n�J�Ѯv��id
//��X���ЯZ��
$class_name=teacher_sn_to_class_name($teacher_sn);

//���o�ǥͥͤ���
$sql="select stud_name,DATE_FORMAT(stud_birthday,'%m%d') as md
      from stud_base where stud_study_cond=0 and curr_class_num like '".$class_name[0]."%' order by md";

$recordSet=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);

head("�ǥͥͤ�P�y�C��");
print_menu($menu_p);


//��J$star_arr�}�C
while ($rd=$recordSet->FetchRow()) {
       for($i=0;$i<=$star_len;$i++)
       {
       if($rd[md]<=$star_date[$i]) { $star_arr[$i].="$rd[stud_name]($rd[md])�A"; $star_total[$i]+=1; break; }
       }
       //�̫�P�̪�ۥ[
       if($i=$star_len)
       {
       $star_arr[0].=$star_arr[$i];
       $star_total[0]+=$star_total[$i];
       }
}

//���o���Y
$data="<table border=1 width=100% bordercolor=#008000 cellspacing=0 cellpadding=3>
        <form name=\"year_form\" method=\"post\" action=\"$_SERVER[PHP_SELF]\">
        <tr bgcolor=#ccffcc>
        <td align=center width=120>�P�y�W��</td><td align=center width=70>�H�Ʋέp</td><td align=center>$class_name[1]�ǥͥͤ� $type_select �C��</td>
        </tr>";

//�N��ƦC��
for($i=0;$i<$star_len;$i++)
{
       $data.="<tr><td align=center>$star_name[$i]</td><td align=center>".($star_total[$i]?$star_total[$i]:0)."</td><td>".($star_arr[$i]?substr($star_arr[$i],0,-2):'�@')."</td></tr>";
}

echo "$data</form></table>";
foot();

?>
