<?php

// $Id: index.php 8478 2015-08-06 15:39:00Z smallduh $

/* ���o�]�w�� */
include_once "config.php";

sfs_check();


if(!empty($_REQUEST[this_date])){
        $d=explode("-",$_REQUEST[this_date]);
}else{
        $d=explode("-",date("Y-m-d"));
}
$year=(empty($_REQUEST[year]))?$d[0]:$_REQUEST[year];
$month=(empty($_REQUEST[month]))?$d[1]:$_REQUEST[month];
$day=(empty($_REQUEST[day]))?$d[2]:$_REQUEST[day];

$act=$_REQUEST[act];
$One=$_REQUEST[One];
$year_name=$_REQUEST[year_name];
$class_name=$_REQUEST[class_name];
$class_num=$_REQUEST[class_num];
$class_id=$_REQUEST[class_id];

if ($_POST[change_date]) {
        $year=$_POST[input_year];
        if ($year<1911) $year+=1911;
        $month=intval($_POST[input_month]);
        $day=intval($_POST[input_day]);
        $class_id="";
}

$sel_year=curr_year();
$sel_seme=curr_seme();


//������J�~�šB�Z�šB�y��
if ($year_name && $class_name && $class_num) {
        $seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
        $seme_class=($year_name+$IS_JHORES).sprintf("%02d",$class_name);
        $seme_num=sprintf("%02d",$class_num);
        $sql="select a.stud_id,b.stud_study_cond from stud_seme a,stud_base b where a.seme_year_seme='$seme_year_seme' and a.seme_class='$seme_class' and a.seme_num='$seme_num' and b.student_sn=a.student_sn and b.stud_study_cond='0'";
        $rs=$CONN->Execute($sql);
        $stud_id=$rs->fields[stud_id];
        if (!empty($stud_id)) $One=$stud_id;
        $ON_LOAD="javascript:document.site_form.class_num.focus();";
}

//������J�Ǹ�
if ($One) {
        $sql="select student_sn from stud_base where stud_id='$One' and ($sel_year - stud_study_year between 0 and 9)";
        $rs=$CONN->Execute($sql);
        $student_sn=$rs->fields[student_sn];
        if (!$student_sn) $One="";
}

//����ʧ@�P�_
if ($_POST[report]) {
        $oo_path="letter";
        include "letter.php";
}
if($act=="�x�s�n�O"){

        if ($One) {
                add_one($sel_year,$sel_seme,$class_id,$One,$_POST[s]);
                header("location: $_SERVER[SCRIPT_NAME]?class_id=$_POST[class_id]&One=$_POST[One]&this_date=$_POST[date]");
        } else {
                add_all($sel_year,$sel_seme,$class_id,$_POST[date],$_POST[s]);
                header("location: $_SERVER[SCRIPT_NAME]?this_date=$_POST[date]&class_id=$_POST[class_id]");
        }
}elseif($act=="clear"){
        clear_data($sel_year,$sel_seme,$_GET[this_date],$_GET[stud_id]);
        if ($One)
                header("location: $_SERVER[SCRIPT_NAME]?this_date=$_GET[this_date]&class_id=$_GET[class_id]&One=$One");
        else
                header("location: $_SERVER[SCRIPT_NAME]?this_date=$_GET[this_date]&class_id=$_GET[class_id]");
}elseif($act=="�קﰲ�O"){
        if ($One) {
                update_data($sel_year,$sel_seme,$class_id,$One,$_POST[s]);
                header("location: $_SERVER[SCRIPT_NAME]?class_id=$_POST[class_id]&One=$_POST[One]&this_date=$_POST[date]");
        }
}else{
        $main=&mainForm($sel_year,$sel_seme,$class_id,$_POST[thisOne],$One);
}


//�q�X����
head("���m�Ҭ���");

if(sizeof($_POST[thisOne])>0){
        foreach($_POST[thisOne] as $e_name){
                $js.="
		function disableall_cb".$e_name."() {
			var uf=document.myform.include_uf.checked;
			var df=document.myform.include_df.checked;
			var max_i=document.myform.cb".$e_name.".length;
			if (uf & df) {
			  for (i=0;i<max_i;i++) {
			    document.myform.cb".$e_name."[i].checked=false;
			    document.myform.cb".$e_name."[i].disabled=true;
			  }
			} else {
				if (uf) document.myform.cb".$e_name."[0].checked=!document.myform.cb".$e_name."[0].checked;
				if (df) document.myform.cb".$e_name."[(max_i-1)].checked=!document.myform.cb".$e_name."[(max_i-1)].checked;
			  for (i=1;i<(max_i-1);i++) {
			    document.myform.cb".$e_name."[i].checked=!document.myform.cb".$e_name."[i].checked;
			  }
			  document.myform.cb".$e_name."_all.checked=false;
			}
		}
                function ableall_cb".$e_name."() {
                  for (i=0;i<document.myform.cb".$e_name.".length;i++) {
                    document.myform.cb".$e_name."[i].disabled=false;
                  }
                }
        ";
        }
}elseif(!empty($_REQUEST[One])){
        for ($j=1;$j<=6;$j++)
        $js.="
		function disableall_cb_".$j."() {
			var uf=document.myform.include_uf.checked;
			var df=document.myform.include_df.checked;
			var max_i=document.myform.cb_".$j.".length;
			if (uf & df) {
			  for (i=0;i<max_i;i++) {
			    document.myform.cb_".$j."[i].checked=false;
			    document.myform.cb_".$j."[i].disabled=true;
			  }
			} else {
				if (uf) document.myform.cb_".$j."[0].checked=!document.myform.cb_".$j."[0].checked;
				if (df) document.myform.cb_".$j."[(max_i-1)].checked=!document.myform.cb_".$j."[(max_i-1)].checked;
			  for (i=1;i<(max_i-1);i++) {
			    document.myform.cb_".$j."[i].checked=!document.myform.cb_".$j."[i].checked;
			  }
			  document.myform.cb_".$j."_all.checked=false;
			}
		}
                function ableall_cb_".$j."() {
                  for (i=0;i<document.myform.cb_".$j.".length;i++) {
                    document.myform.cb_".$j."[i].disabled=false;
                  }
                }
        ";
}else{
        $js="";
}


echo "<style type=\"text/css\">
<!--
.calendarTr {font-size:12px; font-weight: bolder; color: #006600}
.calendarHeader {font-size:12px; font-weight: bolder; color: #cc0000}
.calendarToday {font-size:12px; background-color: #ffcc66}
.calendarTheday {font-size:12px; background-color: #ccffcc}
.calendar {font-size:11px;font-family: Arial, Helvetica, sans-serif;}
.dateStyle {font-size:15px;font-family: Arial; color: #cc0066; font-weight: bolder}
-->
</style>
<script language=\"JavaScript\">
        $js
</script>
";
echo $main;
foot();

//�D�n��J�e��
function &mainForm($sel_year,$sel_seme,$class_id="",$thisOne=array(),$One=""){
        global $school_menu_p,$year,$month,$day,$SFS_PATH_HTML,$school_menu_p,$CONN,$year_name,$class_name,$class_num;
        //�����\���
        $tool_bar=&make_menu($school_menu_p);

        $seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
        if (!empty($One) && empty($class_id)) {
                $sql="select seme_class from stud_seme where seme_year_seme='$seme_year_seme' and stud_id='$One'";
                $rs=$CONN->Execute($sql);
                $seme_class=$rs->fields[seme_class];
                $class_id=sprintf("%03d_%d_%02d_%02d",$sel_year,$sel_seme,substr($seme_class,0,-2),substr($seme_class,-2,2));
        }

        //���o�ӯZ�ξǥͦW��A�H�ζ�g���
        if(!empty($class_id)){
                $signForm=&signForm($sel_year,$sel_seme,$class_id,$thisOne,$One);
        }
        //�~�ŻP�Z�ſ��
        $class_select=&classSelect($sel_year,$sel_seme,"","class_id",$class_id);

        if(!empty($class_id)){
                $cal = new MyCalendar;
                if ($One)
                        $cal->linkStr="&class_id=$class_id&One=$One";
                else
                        $cal->linkStr="&class_id=$class_id";
                $cal->setStartDay(1);
                $cal->getDateLink();
                $mc=$cal->getMonthView($month,$year,$day);
                $the_cal="
                <table cellspacing='1' cellpadding='2' bgcolor='#E2ECFC' class='small'>
                <tr bgcolor='#FEFBDA'>
                <td align='center'>
                <a href='$_SERVER[SCRIPT_NAME]?act=$_REQUEST[act]&this_day=$today&class_id=$class_id' class='box'><img src='".$SFS_PATH_HTML."images/today.png' alt='�^�줵��' width='16' height='16' hspace='2' border='0' align='absmiddle'>�^�줵��</a>
                </td></tr>
                <tr bgcolor='#FFFFFF'><td>$mc</td></tr>
                </table>
                ";
        }

        $main="
        $tool_bar
        <table cellspacing='1' cellpadding='3' bgcolor='#C6D7F2'>
        <form action='$_SERVER[SCRIPT_NAME]' method='post'>
        <tr bgcolor='#FFFFFF'>
        <td>$class_select
        ��������G <input type='text' maxsize='4' size='4' name='input_year' value='$year'> �~ <input type='text' maxsize='2' size='2' name='input_month' value='$month'> �� <input type='text' maxsize='2' size='2' name='input_day' value='$day'> �� <input type='submit' name='change_date' value='�󴫤��'><input type='hidden' name='this_date' value='$year-$month-$day'></td>
        </tr>
        </form>
        <form action='$_SERVER[SCRIPT_NAME]' method='post'>
        <tr bgcolor='#ffffff'>
        <td>�Ϊ�����J�Ǹ��G<input type='text' size='10' maxsize='10' name='One' OnChange='this.form.submit();'> <input type='submit' value='�T�w'><input type='hidden' name='this_date' value='$year-$month-$day'></td>
        </tr>
        </form>
        <form action='$_SERVER[SCRIPT_NAME]' name='site_form' method='post'>
        <tr bgcolor='#ffffff'>
        <td>�Ϊ�����J�Z�Ůy���G<input type='text' size='2' maxsize='2' name='year_name' value='$year_name'> �~�� <input type='text' size='2' maxsize='2' name='class_name' value='$class_name'> �Z <input type='text' size='2' maxsize='2' name='class_num' value='$class_num'> �� <input type='submit' value='�T�w'><input type='hidden' name='this_date' value='$year-$month-$day'></td>
        </tr>
        </form>
        </table>
        <table cellspacing='1' cellpadding='3'>
        <tr>
        <td valign='top'>$signForm</td>
        <td valign='top'>$the_cal</td>
        </tr>
        </table>
        ";
        return $main;
}

//���o�ӯZ�ξǥͦW��A�H�ζ�g���
function &signForm($sel_year,$sel_seme,$class_id,$thisOne=array(),$One=""){
        global $year,$month,$day,$CONN,$weekN,$IS_JHORES;
        //���o�Y�Z�ǥͰ}�C
        $c=class_id_2_old($class_id);

        //���o�ӯZ���X�`��
        $sql_select = "select sections from score_setup where year = '$c[0]' and semester='$c[1]' and class_year='$c[3]'";
        $recordSet=$CONN->Execute($sql_select) or trigger_error("SQL�y�k���~�G $sql_select", E_USER_ERROR);
        list($all_sections) = $recordSet->FetchRow();
                for($i=1;$i<=$all_sections;$i++){
                        $sections_txt.="<td>$i �`</td>";
                }

        //���o���m�����O
        $absent_kind_array= SFS_TEXT("���m�����O");

        $option="
        <option value=''></option>";
        foreach($absent_kind_array as $k){
                $option.="<option value='$k'>$k</option>\n";
        }


        //���o�ǥͰ}�C
        $stud=get_stud_array($c[0],$c[1],$c[3],$c[4],"id","name");
        //�y��
        $seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
        $seme_class=$c[3].sprintf("%02d",$c[4]);
        $sql_num="select stud_id,seme_num from stud_seme where seme_class='$seme_class' and seme_year_seme='$seme_year_seme'";
        $rs_num=$CONN->Execute($sql_num);
        while (!$rs_num->EOF) {
                $stud_id=$rs_num->fields['stud_id'];
                $num[$stud_id]=$rs_num->fields['seme_num'];
                $rs_num->MoveNext();
        }

        //�Y�O��ѽа��h�@�����n�X�ְ_��
        $coln=$all_sections+3;

        if (empty($One)) {

        foreach($stud as $id=>$name){

                //���o�Ӿǥ͸��
                $aaa=getOneDaydata($id,$year,$month,$day);

                //�U�@�`���
                $blank="";
                for($i=1;$i<=$all_sections;$i++){
                        $blank.="<td>$aaa[$i]</td>";
                }

                //�s��Ҧ�
                if(in_array($id,$thisOne) or $id==$One){
                        $e_name="cb".$id;

                        //�m�Һ���
                        $select="<select name='s[$id][kind]' id='tool'>$option</select>";

                        $checked="checked";

                        //��X�C�@�`��
                        if(empty($aaa[allday])){
                                $sections_data="";
                                $close_allday=false;
                                for($i=1;$i<=$all_sections;$i++){
                                        $sv=(!empty($aaa[$i]))?$aaa[$i]:"<input type='checkbox' id='$e_name' name='s[$id][section][]' value='$i'>";
                                        $sections_data.="<td>$sv</td>\n";
                                        //�u�n����������@�`�m�ҡA�N�����ϥΡu��ѡv���\��
                                        if(!empty($aaa[$i]))$close_allday=true;
                                }
                        }else{
                                $sections_data="";
                        }

                        //�ɺX
                        $ufv=(!empty($aaa[uf]))?$aaa[uf]:"<input type='checkbox' id='$e_name' name='s[$id][section][]' value='uf'>";
                        $uf=(!empty($aaa[allday]))?"<td bgcolor='#FFFFFF' colspan=$coln>$aaa[allday]</td>":"<td bgcolor='#FBF8B9'>$ufv</td>";

                        //���X
                        $dfv=(!empty($aaa[df]))?$aaa[df]:"<input type='checkbox' id='$e_name' name='s[$id][section][]' value='df'>";
                        $df=(!empty($aaa[allday]))?"":"<td bgcolor='#FFE6D9'>$dfv</td>";

                        //���
                        //�ݬO�_�n�����u��ѡv�\��
                        $disabled=($close_allday or !empty($aaa[uf]) or !empty($aaa[df]))?"disabled":"";
                        $allday=(!empty($aaa[allday]))?$aaa[allday]:"<input type='checkbox' id=\"".$e_name."_all\" $disabled name='s[$id][section][]' value='allday' onClick=\"if (this.checked==false){javascript:ableall_$e_name() } else { javascript:disableall_$e_name()}\">";

                        $all_day=(!empty($aaa[allday]))?"":"<td bgcolor='#E8F9C8'>$allday</td>";



                        $select_col="<td bgcolor='#ECff8F9'>$select</td>";
                        $tool="���m�Һ���";
                }else{
                        //�[�ݼҦ�
                        $sections_data=(!empty($aaa[allday]))?"":$blank;
                        $checked="";
                        $uf=(!empty($aaa[allday]))?"<td bgcolor='#FFFFFF' colspan=$coln align='center'>$aaa[allday]</td>":"<td bgcolor='#FBF8B9'>$aaa[uf]</td>";
                        $df=(!empty($aaa[allday]))?"":"<td bgcolor='#FFE6D9'>$aaa[df]</td>";
                        $all_day=(!empty($aaa[allday]))?"":"<td bgcolor='#E8F9C8'>$aaa[allday]</td>";
                        $tool="�\��";
                        $select_col="<td bgcolor='#ECff8F9' align='center'><a href='$_SERVER[SCRIPT_NAME]?class_id=$class_id&One=$id&this_date=$year-$month-$day'>�s��</a>|<a href='$_SERVER[SCRIPT_NAME]?act=clear&class_id=$class_id&stud_id=$id&this_date=$year-$month-$day'>�M��</a></td>";
                }

                //�Ŀﲰ
                $chkBox=(sizeof($thisOne)>0 or !empty($One))?"":"<input type='checkbox' name='thisOne[]' value='$id' $checked>";

                //�C�@�C���
                //��ѨS��
                $data.="
                <tr bgcolor='#FFFFFF'>
                <td>$id</td>
                <td>".$num[$id]."</td>
                <td>$chkBox<a href='$_SERVER[SCRIPT_NAME]?class_id=$class_id&One=$id&this_date=$year-$month-$day'>$name</a></td>
                $uf
                $sections_data
                $df
                $all_day
                $select_col
                </tr>";
                $site_title="�y��";
        }
        } else {
                $scond=study_cond();
                $tool="���m�Һ���";
                $seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
                $sql="select a.stud_name,a.stud_study_cond,b.seme_class,b.seme_num from stud_base a,stud_seme b where a.stud_id='$One' and a.student_sn=b.student_sn and b.seme_year_seme='$seme_year_seme'";
                $rs=$CONN->Execute($sql);
                $stud_name=$rs->fields[stud_name]."<br><font color='#008800'>(".$scond[$rs->fields[stud_study_cond]].")</font>";
                $seme_class=$rs->fields[seme_class];
                $seme_num=$rs->fields[seme_num];
                $year_name=substr($seme_class,0,-2)-$IS_JHORES;
                $class_name=intval(substr($seme_class,-2,2));
                $DAY=get_school_days($seme_year_seme,substr($seme_class,0,1)); //���o���Ǵ��W�Ǥ�
                $sql="select max(b.seme_num) from stud_base a,stud_seme b where b.seme_year_seme='$seme_year_seme' and b.seme_class='$seme_class' and a.student_sn=b.student_sn and b.seme_num < '$seme_num' and a.stud_study_cond='0'";
                $rs=$CONN->Execute($sql);
                $pre_num=$rs->fields[0];
                $pre_str=(empty($pre_num))?"<font color='#aaaaaa'>��</font><br>":"<a href='$_SERVER[SCRIPT_NAME]?year_name=$year_name&class_name=$class_name&class_num=$pre_num&this_date=$year-$month-$day'>��</a><br>";
                $sql="select min(b.seme_num) from stud_base a,stud_seme b where b.seme_year_seme='$seme_year_seme' and b.seme_class='$seme_class' and a.student_sn=b.student_sn and b.seme_num > '$seme_num' and a.stud_study_cond='0'";
                $rs=$CONN->Execute($sql);
                $next_num=$rs->fields[0];
                $next_str=(empty($next_num))?"<br><font color='#aaaaaa'>��</font>":"<br><a href='$_SERVER[SCRIPT_NAME]?year_name=$year_name&class_name=$class_name&class_num=$next_num&this_date=$year-$month-$day'>��</a>";
                $fday=mktime(0,0,0,$month,$day,$year);
                $dd=getdate($fday);
                $fday-=($dd[wday]-1)*86400;
                $W_days=($DAY['School_days']>0)?5:4;
                for ($j=0;$j<=$W_days;$j++) {
                        //���o�Ӿǥ͸��
                        $smkt=$fday+$j*86400;
                        $syear=date("Y",$smkt);
                        $smonth=date("m",$smkt);
                        $sday=date("d",$smkt);
                        $dd=getdate($smkt);
                        $did=date("Y-m-d",$smkt);
//                        if ($DAY[$did]!='1' and $DAY['School_days']>0) continue;  //�Y�D�W�Ǥ�,�B���i�����]�w,���L
                        //�D�W�Ǥ�H�ǩ������
                        $day_bgcolor=($DAY[$did]=='1' and $DAY['School_days']>0)?"#FFFFFF":"#CCCCCC";
                        $pid=date("Y-m-d",$fday-7*86400);
                        $fid=date("Y-m-d",$fday+7*86400);
                        $e_name="cb_".$dd[wday];
                        $aaa=getOneDaydata($One,$syear,$smonth,$sday);
                        //�m�Һ���
                        $select="<select name='s[$did][kind]' id='tool'>$option</select>";
                        $checked="checked";

                        //��X�C�@�`��
                        if(empty($aaa[allday])){
                                $sections_data="";
                                $close_allday=false;
                                for($i=1;$i<=$all_sections;$i++){
                                        $sv=(!empty($aaa[$i]))?$aaa[$i]:"<input type='checkbox' id='$e_name' name='s[$did][section][]' value='$i'>";
                                        $sections_data.="<td>$sv</td>\n";
                                        //�u�n����������@�`�m�ҡA�N�����ϥΡu��ѡv���\��
                                        if(!empty($aaa[$i]))$close_allday=true;
                                }
                        }else{
                                $sections_data="";
                        }

                        //�ɺX
                        $ufv=(!empty($aaa[uf]))?$aaa[uf]:"<input type='checkbox' id='$e_name' name='s[$did][section][]' value='uf'>";
                        $uf=(!empty($aaa[allday]))?"<td bgcolor='#FFFFFF' colspan=$coln align='center'>$aaa[allday]</td>":"<td bgcolor='#FBF8B9'>$ufv</td>";

                        //���X
                        $dfv=(!empty($aaa[df]))?$aaa[df]:"<input type='checkbox' id='$e_name' name='s[$did][section][]' value='df'>";
                        $df=(!empty($aaa[allday]))?"":"<td bgcolor='#FFE6D9'>$dfv</td>";

                        //���
                        //�ݬO�_�n�����u��ѡv�\��
                        $disabled=($close_allday or !empty($aaa[uf]) or !empty($aaa[df]))?"disabled":"";
                        $allday=(!empty($aaa[allday]))?$aaa[allday]:"<input type='checkbox' id='".$e_name."_all' $disabled name='s[$did][section][]' value='allday' onClick=\"if (this.checked==false){javascript:ableall_$e_name() } else { javascript:disableall_$e_name()}\">";

                        $all_day=(!empty($aaa[allday]))?"":"<td bgcolor='#E8F9C8'>$allday</td>";



                        $tool="���m�Һ���";
                        if ($j==0)
                                $data.="
                                <tr bgcolor='#FFFFFF'>
                                <td rowspan='6'>$One</td>
                                <td rowspan='6' align='center'>$seme_num</td>
                                <td rowspan='6'>$stud_name</td>";
                        else
                                $data.="<tr bgcolor='#FFFFFF'>";
                        $data.="
                        <td align='center' bgcolor='$day_bgcolor'><a href='$_SERVER[SCRIPT_NAME]?class_id=$class_id&this_date=$did'>".$did."<br>(".$weekN[$dd[wday]-1].")</a></td>
                        $uf
                        $sections_data
                        $df
                        $all_day
                        <td bgcolor='#ECff8F9' vlign='middle'>
                        $select
                        <a href='$_SERVER[SCRIPT_NAME]?act=clear&class_id=$class_id&stud_id=$One&this_date=$did&One=$One'><img src='images/del.png' border='0' alt='�R���o�@��($did)�Ҧ��O��'></a></td>
                        </tr>";
                }
                $site_title=$pre_str."�y��".$next_str;
                $date_title="<td align='center'><a href='$_SERVER[SCRIPT_NAME]?One=$One&class_id=$class_id&this_date=$pid'>��</a><br>���<br><a href='$_SERVER[SCRIPT_NAME]?One=$One&class_id=$class_id&this_date=$fid'>��</a></td>";
        }
        $submitTxt=(sizeof($thisOne)>0 or $One!="")?"�x�s�n�O":"�Ŀ�s��";

        $main="
        <table cellspacing='0' cellpadding='0'0class='small'>
        <tr><td valign='top'>
                <table cellspacing='1' cellpadding='3' bgcolor='#C6D7F2' class='small'>
                <tr bgcolor='#E6F2FF'>
                <td align='center'>�Ǹ�</td>
                <td align='center'>$site_title</td>
                <td align='center'>�m�W</td>
                $date_title
                <td bgcolor='#FBF8B9'>�ɺX</td>
                $sections_txt
                <td bgcolor='#FFE6D9'>���X</td>
                <td bgcolor='#E8F9C8'>���</td>
                <td bgcolor='#ECff8F9'>$tool</td>
                </tr>
                <form action='$_SERVER[SCRIPT_NAME]' method='post' name='myform'>
                $data
                </table>
        </td><td valign='top'>
                <input type='hidden' name='sel_year' value='$sel_year'>
                <input type='hidden' name='sel_seme' value='$sel_seme'>
                <input type='hidden' name='class_id' value='$class_id'>
                <input type='hidden' name='this_date' value='$year-$month-$day'>
                <input type='hidden' name='date' value='$year-$month-$day'>
		<div class='small'><input type='checkbox' name='include_uf' ".(($default_uf!="0")?"checked":"").">��ѧt�ɺX</div>
		<div class='small'><input type='checkbox' name='include_df' ".(($default_df!="0")?"checked":"").">��ѧt���X</div>
                <input type='submit' name='act' value='$submitTxt'><br>
                <input type='submit' name='act' value='�קﰲ�O'>";
        if (!empty($One)) $main.="<input type='hidden' name='One' value='$One'><br><input type='submit' name='report' value='�L�q����'>";
        $main.="
                </form>
        </td></tr>
        </table>
        ";
        return $main;
}


//�s�W���
function add_all($sel_year,$sel_seme,$class_id="",$date="",$data=array()){
/*
s[091005][uf]
s[091005][section]
s[091005][df]
s[091005][allday]
s[091005][kind]
s[091005][date]
*/
        foreach($data as $id =>$v){
                foreach($v[section] as $section){
                        if(empty($v['kind']))continue;
                        add($sel_year,$sel_seme,$id,$class_id,$date,$section,$v['kind']);
                }
        }
        return;
}

//�s�W�@�H���
function add_one($sel_year,$sel_seme,$class_id="",$stud_id="",$data=array()){
        foreach($data as $id =>$v){
                foreach($v[section] as $section){
                        if(empty($v['kind']))continue;
                        add($sel_year,$sel_seme,$stud_id,$class_id,$id,$section,$v['kind']);
                }
        }
        return;
}

//�s�W��@�����
function add($sel_year,$sel_seme,$stud_id,$class_id="",$date,$section,$kind){
        global $CONN;
        $d=explode("-",$date);
        $c=explode("_",$class_id);
        //��data�ӧP�_�Ǧ~�P�Ǵ�
        $upA=array("1","8","9","10","11","12");
        $downA=array("2","3","4","5","6","7");

        if(in_array($d[1],$upA)) {//�W�Ǵ�
                $sel_year=($d[1]==1)?$d[0]-1912:$d[0]-1911;
                $sel_seme=1;
        }
        elseif(in_array($d[1],$downA)) {//�U�Ǵ�
                $sel_year=$d[0]-1912;
                $sel_seme=2;
        }
        $new_class_id=sprintf("%03d_%d_%02d_%02d",$sel_year,$sel_seme,$c[2]-($c[0]-$sel_year)+$IS_JHORES,$c[3]);
        $sql_insert = "insert into stud_absent (year,semester,class_id,stud_id,date,absent_kind,section,sign_man_sn,sign_man_name,sign_time,month) values ('$sel_year','$sel_seme','$new_class_id','$stud_id','$date','$kind','$section','$_SESSION[session_tea_sn]','$_SESSION[session_tea_name]',now(),'$d[1]')";
        $CONN->Execute($sql_insert) or user_error("�s�W���ѡI<br>$sql_insert",256);
        sum_abs($sel_year,$sel_seme,$stud_id);
        return;
}

//�R���Y�H�Y�骺���
function clear_data($sel_year,$sel_seme,$this_date,$stud_id){
        global $CONN;
        $sql_delete = "delete from stud_absent where stud_id='$stud_id' and date='$this_date'";
        $CONN->Execute($sql_delete) or user_error("�R�����ѡI<br>$sql_delete",256);
        sum_abs($sel_year,$sel_seme,$stud_id);
        return true;
}

//�ק�@�H���O���
function update_data($sel_year,$sel_seme,$class_id="",$stud_id="",$data=array()){
        global $CONN;
        foreach($data as $id =>$v){
                if ($v['kind']) {
                        $sql_update="update stud_absent set absent_kind='".$v['kind']."' where stud_id='$stud_id' and date='$id'";
                        $CONN->Execute($sql_update) or user_error("��s���ѡI<br>$sql_update",256);
                }
        }
        sum_abs($sel_year,$sel_seme,$stud_id);
        return;
}
?>
