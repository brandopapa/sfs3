<?php
include "config_calendar.php";


//�B�z�ǻ����Ѽ�
while(list($mode,$val)=each($_POST)){
        if ($mode=="year") $year=$val;//���o��~
        if ($mode=="month") $month=$val;//���o���
        if ($mode=="day") $day=$val;//���o���
        if (substr($mode,0,3)=="act"){
                $id=substr($mode,3);
                $kind=$val;
        }
}


//�d��
if ($kind=="<<�e�@�~"){
        $year=$year-1;
}
if ($kind=="��@�~>>"){
        $year=$year+1;
}
if ($kind=="<�e�@��"){
        $month=$month-1;
        if ($month==0){
                $month=12;
                $year=$year-1;
        }
}
if ($kind=="��@��>"){
        $month=$month+1;
        if ($month==13){
                $month=1;
                $year=$year+1;
        }
}
if ($kind=="���^�{���~��"){
        $year=date("Y");
        $month=date("m");
        $day=date("d");
}
if ($kind=="�e�X�d��"){
        $year=$_POST["new_year"];
        $month=$_POST["new_month"];
}

if ($year=="") $year=date("Y");
if ($month=="") $month=date("m");
if ($day=="") $day=date("d");

$year=sprintf ("%04d", $year);//�N�~�令�|���(��0)
$month=sprintf ("%02d", $month);//�N��令�G���(��0)

echo "<head><title>�~�H�ꤤ���ɫǤ�x</title></head>";
echo "<body bgcolor='#d7d7d7'>";

//���D
echo "<p align='center'><b><font size='4' face='�з���'> �~�H�ꤤ���ɫǤ�x";
echo "</font></b><hr>";

//��ܬd�߸���
echo "<form method='POST' action='".basename($_SERVER["PHP_SELF"])."'>";
echo "<table width='100%'><tr>";
echo "<input type='hidden' value='".$year."' name='year'>";
echo "<input type='hidden' value='".$month."' name='month'>";

echo "<td><input type='submit' name='act' value='<<�e�@�~'></td>";
echo "<td><input type='submit' name='act' value='<�e�@��'></td>";
echo "<td><input type='submit' name='act' value='���^�{���~��'></td>";
echo "<td><input type='submit' name='act' value='��@��>'></td>";
echo "<td><input type='submit' name='act' value='��@�~>>'></td>";

echo "<td align='center'>";
echo "<input type='text' name='new_year' size='4'  maxlength='4' value='".$year."'>�~�@";
echo "<select name='new_month'>";
for ($i=1;$i<13;$i++){
     if (strlen($i)<2) $i="0".$i;
     if ($i==$month){
              echo "<option selected>".$i."</option>";
     }
          else{
              echo "<option>".$i."</option>";
     }
}

echo "</select>��@";

echo "<input type='submit' name='act' name='�d��'>";
echo "</td></tr></table>";
echo "</form>";

//��x���}�l
echo "<table width='100%'><tr><td width='100%' valign='top'>";

echo "<font size='2'>����G".date(Y)."/".date(m)."/".date(d)."</font>�@";
echo "<font color='blue' size='2'>�g".get_week(date(Ymd))."</font>�@�@";

//�q�X��Ƭ���
echo "<font size='2'>�{�b�˵��~��G</font>";
echo "<font color='red' size='2'>".$year."</font><font color='blue' size='2'> �~ </font>";
echo "<font color='red' size='2'>".$month."</font><font color='blue' size='2'> �� </font>";
//�D���}�l
echo "<table width='100%' border='1' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111'>";
echo "<tr bgcolor='#000080'><td width='20'><font size='2' color='white'>��</font></td>";
echo "<td width='20'><font size='2' color='white'>��</font></td>";
echo "<td width='20'><font size='2' color='white'>�g</font></td>";
echo "<td width='30%' align='center'><font size='2' color='white'>���ɥD��</font></td>";
echo "<td width='30%' align='center'><font size='2' color='white'>���ɲժ�</font></td>";
echo "<td width='30%' align='center'><font size='2' color='white'>��Ʋժ�</font></td>";
echo "</tr>";

$d="01";
while(checkdate($month,$d,$year)){
        if (strlen($d)<2) $d="0".$d;//�N$d �]��2��Ƥ����

        if (substr($d,0,1)=="0")//�N$temp�]�� 1~�멳�����
             $temp=substr($d,1);
         else
             $temp=$d;

        if (get_c_week($year.$month.$d)=="��"||get_c_week($year.$month.$d)=="��")
                echo "<tr bgcolor='#ffccff' height='38'>";
           else
                echo "<tr bgcolor='#ffffff' height='38'>";

        if (date("Ymd")==$year.$month.$d){//�ˬd�O�_���v����
                echo "<td bgcolor='red'><font size='2'><b>".$month."</b></font></td>";
                echo "<td bgcolor='red'><font size='2'><b>".$d."</b></font></td>";
                echo "<td bgcolor='red'><font size='2'><b>".get_c_week($year.$month.$d)."</b></font></td>";
        }
        else{
                echo "<td><font size='2'>".$month."</font></td>";
                echo "<td><font size='2'>".$d."</font></td>";
                echo "<td><font size='2'>".get_c_week($year.$month.$d)."</font></td>";
        }
        $test_day=$year.$month.$d;//�]�w�����
        $work_array=array("���ɫǥD��","���ɲժ�","��Ʋժ�");

        while (list($val,$work_name)=each($work_array)){
                echo "<td>";
                //��X¾��id
                $sql_select="select a.teacher_sn from teacher_post a ,teacher_title b where a.teach_title_id=b.teach_title_id and b.title_name='$work_name'";
                $record_teacher = $CONN->Execute($sql_select) or die($sql_select);
                $array = $record_teacher->FetchRow();
                $teacher_sn=$array[teacher_sn];
                $post="";

                $sql_select="select * from calendar where from_teacher_sn='$teacher_sn' and (kind='3' or kind='0') and from_cal_sn='0' order by post_time";
                $recordSet = $CONN->Execute($sql_select) or die($sql_select);
                while ($c=$recordSet->FetchRow()) {
                    if (check_date($c[restart_day],$c[restart_end],$c[year],$c[month],$c[day],$c[week],$test_day,$c[restart])){
                       $import=($c[import]>6)?"<font color='red' size='2'> **���** </font>":"";
                       $post.= "<li><font size='2' color='blue'>";
                       $post.=$c[thing];
                       $post.="</font>";
                       $post.= "�@".$import."<br>";
                    }
                }
                echo $post."</td>";
         }

        echo "</tr>";
        $d=$d+1;
}
echo "</table>";
echo "</td></tr></table>";

//��ܬd�߸���
echo "<form method='POST' action='".basename($_SERVER["PHP_SELF"])."'>";
echo "<table width='100%'><tr>";
echo "<input type='hidden' value='".$year."' name='year'>";
echo "<input type='hidden' value='".$month."' name='month'>";

echo "<td><input type='submit' name='act' value='<<�e�@�~'></td>";
echo "<td><input type='submit' name='act' value='<�e�@��'></td>";
echo "<td><input type='submit' name='act' value='���^�{���~��'></td>";
echo "<td><input type='submit' name='act' value='��@��>'></td>";
echo "<td><input type='submit' name='act' value='��@�~>>'></td>";

echo "<td align='center'>";
echo "<input type='text' name='new_year' size='4'  maxlength='4' value='".$year."'>�~�@";
echo "<select name='new_month'>";
for ($i=1;$i<13;$i++){
     if (strlen($i)<2) $i="0".$i;
     if ($i==$month){
              echo "<option selected>".$i."</option>";
     }
          else{
              echo "<option>".$i."</option>";
     }
}

echo "</select>��@";

echo "<input type='submit' name='act' name='�d��'>";
echo "</td></tr></table>";
echo "</form>";



//����2��

//��ܦ~��
echo "<center><font color='blue' face='�з���' size='4'><b>".$year."�~ �~���</b></font><p>";
echo "<table width='100%'>";
for ($i=1;$i<13;$i++){
        if ($i % 3==1) echo "<tr>";
        echo "<td valign='top'>";
        echo "<table bgcolor='#ffffff' border='1' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='85%'>";
        $temp_now_month=date("m");
        if (substr($temp_now_month,0,1)=="0") $temp_now_month=substr($temp_now_month,1);//�N$temp����ন 0~12
        if ($i==$temp_now_month and $year==date("Y"))//�M����
                echo "<tr bgcolor='#ff0000'><td colspan='7' align='center'>";
        else
                echo "<tr bgcolor='#00ffff'><td colspan='7' align='center'>";
        echo "<b>".$i."��</b>";
        echo "</td></tr>";
        echo "<tr bgcolor='#6363d3'>";
        echo "<td align='center'><font color='#ffffff' size='2'>��</font></td>";
        echo "<td align='center'><font color='#ffffff' size='2'>�@</font></td>";
        echo "<td align='center'><font color='#ffffff' size='2'>�G</font></td>";
        echo "<td align='center'><font color='#ffffff' size='2'>�T</font></td>";
        echo "<td align='center'><font color='#ffffff' size='2'>�|</font></td>";
        echo "<td align='center'><font color='#ffffff' size='2'>��</font></td>";
        echo "<td align='center'><font color='#ffffff' size='2'>��</font></td>";
        echo "</tr>";
        //���g�C�X���
        $d="01";
        $week=0;
        while(checkdate($i,$d,$year)){
                if ($week==0) echo "<tr>";//�g��
                if (strlen($d)<2) $d="0".$d;//�T�O$d �� 01~�멳
                $temp=getdate(mktime(0,0,0,$i,$d,$year));
                if ($d==1){//���Ĥ@��A�ɪŮ�

                        for ($j=1;$j<$temp["wday"]+1;$j++){
                                echo "<td></td>";
                        }
                        $week=$week+$temp["wday"];
                }
                if ($year.$i.$d==date("Y").$temp_now_month.date("d"))//�M�䥻��
                        echo "<td align='center' bgcolor='red'>";
                elseif ($week==0 || $week==6)
                        echo "<td align='center' bgcolor='#f0b4f1'>";
                else
                        echo "<td align='center'>";
                        
                //�L�X���
                echo "<font size='2'>".$d."<font>";
                echo "</td>";
                
                $d=$d+1;
                $week=$week+1;
                if ($week==7){//�g��
                        echo "</tr>";
                        $week=0;
                }
        }
        if ($week==0) echo "</tr>";
        echo "</table>";

        echo "</td>";
        if ($i % 3 ==0) echo "</tr><tr><td colspan='3'><p>�@</td></tr>";

}
//���浲�����O
echo "</table>";
echo "</body>";

?>
