<?php
// $Id: score_sort.php 2015-10-17 22:12:01Z qfon $

include "config.php";
sfs_check();

$year_seme=$_REQUEST[year_seme];

if($year_seme=="")
        $year_seme = sprintf("%03d%d",curr_year(),curr_seme());
else {
        $ys=explode("_",$year_seme);
        if ($ys[1]!="")$year_seme=sprintf("%03d",$ys[0]).$ys[1];
}

$score_part=array(1=>'�w��',2=>'����');
$use_rate=$_REQUEST['use_rate'];
$show_avg=$_REQUEST['show_avg'];
$show_tol_avg=$_REQUEST['show_tol_avg'];
$year_name=$_REQUEST['year_name'];
$me=$_REQUEST['me'];
if ($me && strlen($year_name)==1) $year_name.=sprintf("%02d",$me);

$stage=$_REQUEST['stage'];
$subject=$_REQUEST['subject'];

$kind=$_REQUEST['kind'];

$percent=$_REQUEST['percent'];
//if (empty($percent))$percent=100;
$friendly_print=$_REQUEST['friendly_print'];
$print_asign=$_REQUEST['print_asign'];
//$yorn=findyorn();
$save_csv=$_POST['save_csv'];
$sort_num=$_REQUEST['sort_num'];
$move_out=$_REQUEST['move_out'];
$print_special=$_REQUEST['print_special'];
$chk=$_REQUEST[chk];
$is_show_ss_id=$_POST['show_ss_id']?'checked':'';
/*
echo "\$year_seme:$year_seme";
echo "\$use_rate(�[�v):$use_rate";
echo "\$show_avg:$show_avg";
echo "\$show_tol_avg:$show_tol_avg";
*/


if ($friendly_print==0) {
        $border="0";
        $bgcolor1="#FDC3F5";
        $bgcolor2="#B8FF91";
        $bgcolor3="#CFFFC4";
        $bgcolor4="#B4BED3";
        $bgcolor5="#CBD6ED";
        $bgcolor6="#D8E4FD";
} else {
        $border="1";
        $bgcolor1="#FFFFFF";
        $bgcolor2="#FFFFFF";
        $bgcolor3="#FFFFFF";
        $bgcolor4="#FFFFFF";
        $bgcolor5="#FFFFFF";
        $bgcolor6="#FFFFFF";
}

$score_part=array(1=>'�w��',2=>'����');

//�q�X����
if (empty($friendly_print) && empty($save_csv)) head("�ɱϱоǦW��");
//�C�X��V���s�����Ҳ�
if (empty($friendly_print) && empty($save_csv)) print_menu($menu_p);
if (empty($friendly_print) && empty($save_csv)) echo "<table border=0 cellspacing=0 cellpadding=2 width=100% bgcolor=#cccccc><tr><td>";

//�Ǧ^�Ǵ��}�C

function get_class_seme2($s_z=0,$add=0) {
        global $CONN;
        if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

        $curr_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
        $query = "select year,semester from school_class where enable=1 group by year,semester order by year desc,semester desc";
        $result = $CONN->Execute($query) or trigger_error("SQL�y�k���~�G $query", E_USER_ERROR);


        while(!$result->EOF){
                $index_temp = sprintf("%03d%d",$result->fields[0],$result->fields[1]);
                $index_temp1 = sprintf("%03d%d",$result->fields[0],"");

                //echo substr($index_temp,3);

                if (substr($index_temp,3)==2)$rr[$index_temp1] = $result->fields[0]."�Ǧ~��";
                $rr[$index_temp] = $result->fields[0]."�Ǧ~��".$result->fields[1]."�Ǵ�";

                $result->MoveNext();
        }

        // return $rr;

        return (!$rr) ? array() : $rr;

        // �P�_ $rr �O�_�s�b? �Y���s�b�h�Ǧ^���Ű}�C
}

//���o�Ǧ~�Ǵ��}�C
//$year_seme_arr = get_class_seme2();

//print_r ($year_seme_arr);

//echo $year_seme_arr[1032];

   //���o�Ǧ~�Ǵ��}�C
$year_seme_arr = get_class_seme2();
//�s�W�@�ӤU�Կ����
$ss1 = new drop_select();
//�U�Կ��W��
$ss1->s_name = "year_seme";
//���ܦr��
$ss1->top_option = "��ܾǴ�";
//�U�Կ��w�]��
$ss1->id = $year_seme;
//�U�Կ��}�C
$ss1->arr = $year_seme_arr;
//�۰ʰe�X
$ss1->is_submit = true;
//�Ǧ^�U�Կ��r��
$year_seme_menu = $ss1->get_select();


$sel_year=substr($year_seme,0,3);
$sel_seme=substr($year_seme,-1);

//echo "\$sel_year:$sel_year";
//echo "\$sel_seme:$sel_seme";

//if (empty($sel_seme))$sel_seme=2;
$score_semester="score_semester_".intval($sel_year)."_".$sel_seme;


$teacher_id=$_SESSION['session_log_id'];//���o�n�J�Ѯv��id



//�C�X�ثe�Z��
function class_base2($curr_seme="",$sel_year_arr = array()) {
        global $CONN,$school_kind_name;
        if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

        if($curr_seme<>''){
                $curr_year= intval(substr($curr_seme,0,3));
                $curr_seme=substr($curr_seme,-1);
        }
        else {
                $curr_year = curr_year();
                $curr_seme = curr_seme();
        }

          if (count($sel_year_arr) == 0)
                    $sel_year_arr = array_keys ($school_kind_name); //�w�]�����Ǧ~

        if (empty($curr_year))
                user_error("���]�w�Ǧ~�Ǵ�,�Х�����<a href='../every_year_setup/'>�Ǵ���]�w</a>",256);
        //$query = "select c_year,c_sort,c_name from school_class where enable=1 and year=$curr_year and semester=$curr_seme order by c_year,c_sort";
        $query = "select c_year,c_sort,c_name from school_class where enable=1 and year=$curr_year  order by c_year,c_sort";

        $res = $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);

        // init $class_name
        $class_name=array();

        //$caa=get_class_year_array($sel_year,$sel_seme);

        //print_r($caa);
        $sql2="select class_year from score_ss Group By class_year";
        $rs2=&$CONN->Execute($sql2);
        if(is_object($rs2))
        {
            while (!$rs2->EOF)
            {
             $class_year=$rs2->fields["class_year"];
            if ($class_year==1)$class_name["c1"]="��p�@�~��";
            if ($class_year==2)$class_name["c2"]="��p�G�~��";
            if ($class_year==3)$class_name["c3"]="��p�T�~��";
            if ($class_year==4)$class_name["c4"]="��p�|�~��";
            if ($class_year==5)$class_name["c5"]="��p���~��";
            if ($class_year==6)$class_name["c6"]="��p���~��";
            if ($class_year==7)$class_name["c7"]="�ꤤ�@�~��";
            if ($class_year==8)$class_name["c8"]="�ꤤ�G�~��";
            if ($class_year==9)$class_name["c9"]="�ꤤ�T�~��";


             $rs2->MoveNext();
            }
        }


        while(!$res->EOF) {
                if (in_array ($res->fields[c_year], $sel_year_arr)) { //�b��ܪ��~�Ť�
                   $class_name_id = sprintf("%d%02d",$res->fields[c_year],$res->fields[c_sort]);
                   if ($res->fields[c_year]==0)$class_name[$class_name_id]=$school_kind_name[$res->fields[c_year]].$res->fields[c_name]."�Z";
                   if ($res->fields[c_year]<=6 && $res->fields[c_year]>=1)$class_name[$class_name_id]="��p".$school_kind_name[$res->fields[c_year]].$res->fields[c_name]."�Z";
                   if ($res->fields[c_year]>6)$class_name[$class_name_id]="�ꤤ".$school_kind_name[$res->fields[c_year]].$res->fields[c_name]."�Z";
                }
                $res->MoveNext();
        }
        return $class_name;

}



//if($year_seme){
        $show_class_year = class_base2($year_seme);

        $ss1->s_name ="year_name";
        $ss1->top_option = "��ܯZ��";
        $ss1->id = $year_name;
        $ss1->arr = $show_class_year;
        $ss1->is_submit = true;
        $class_year_menu =$ss1->get_select();
//}

$c_year = substr($year_name,0,-2);
$c_name = substr($year_name,-2);



//echo "\$c_year(�~��):$c_year";
//echo "\$c_name(�Z��):$c_name";




//echo "\$year_name(�~�ůZ��):$year_name";

//echo "\$stage:$stage";
$stage_menu=stage_menu2($sel_year,$sel_seme,$c_year,$c_name,$stage);


//if ($year_name && $stage) {

$kind_menu=kind_menu2($sel_year,$sel_seme,$c_year,$c_name,$stage,$kind);
                if ($kind=="1") {
                        $choice_kind[0]="�w��";
                        $chart_kind="�w��";
                } elseif ($kind=="2") {
                        $choice_kind[0]="����";
                        $chart_kind="����";

                } else {
                        $choice_kind[1]="�w��";
                        $choice_kind[2]="����";
                        $chart_kind="";
                }



//echo "\$chart_kind:$chart_kind";

//}
$class_id=$sel_year."_".$sel_seme."_0".$c_year."_".$c_name;

if (empty($c_year) && empty($c_name))$class_id="";
if (empty($c_year) && !empty($c_name))$class_id=$sel_year."_".$sel_seme."_0".substr($c_name,1);
if (!empty($sel_year) && empty($sel_seme))
{
$class_id=$c_year."_".$c_name;

if ($c_name=="c1")$class_id="c_01_";
if ($c_name=="c2")$class_id="c_02_";
if ($c_name=="c3")$class_id="c_03_";
if ($c_name=="c4")$class_id="c_04_";
if ($c_name=="c5")$class_id="c_05_";
if ($c_name=="c6")$class_id="c_06_";
if ($c_name=="c7")$class_id="c_07_";
if ($c_name=="c8")$class_id="c_08_";
if ($c_name=="c9")$class_id="c_09_";
}

$subject_menu=subject_menu($sel_year,$sel_seme,$class_id,$subject,$stage,$chart_kind,$subject);
$percent_menu=percent_menu($percent);


//echo "yy:".same_name_ss_id($subject);


//$asign_checked=($print_asign)?"checked":"";
//$special_checked=($print_special)?"checked":"";

$print_msg=($c_name)?"<input type='submit' name='friendly_print' value='�͵��C�L'> <input type='submit' name='save_csv' value='�ץXcsv��'><br>":"";


$menu="<form name=\"myform\" method=\"post\" action=\"$_SERVER[SCRIPT_NAME]\">
        <table>
        <tr>
        <td>$year_seme_menu</td><td>$class_year_menu</td><td>$stage_menu</td><td>$kind_menu</td><td>$subject_menu</td><td>$percent_menu</td>
        </tr>
        </table>";

		
		
		
		
		
		
		
		


if (empty($friendly_print) && empty($save_csv)) echo $menu;

//echo "\$score_semester:$score_semester";

//echo $class_id;
//echo "\$chart_kind:$chart_kind";
//findsubject($sel_year,$sel_seme,$class_id,$ss_id,$test_kind,$test_sort);


//echo "\$subject".$subject;



$main0=sortview($sel_year,$sel_seme,$class_id,$subject,$stage,$chart_kind,$percent,0);


        if ($friendly_print) 
		{
			$main=sortview($sel_year,$sel_seme,$class_id,$subject,$stage,$chart_kind,$percent,1);

			
                $school_title=score_head2($sel_year,$sel_seme,$c_year,$c_name,$stage,$chart_kind,$subject);
                $today=date("Y-m-d",mktime (0,0,0,date("m"),date("d"),date("Y")));
                echo "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=big5\"><title>�ɱϱоǦW��</title></head>
                        <SCRIPT LANGUAGE=\"JavaScript\">
                        <!--
                        function pp() {
                                if (window.confirm('�}�l�C�L�H')){
                                self.print();}
                        }
                        //-->
                        </SCRIPT>
                        <body onload=\"pp();return true;\">
                        <table border=0 cellspacing=0 cellpadding=0 style='border-collapse: collapse; mso-padding-alt: 0cm 1.4pt 0cm 1.4pt' width=\"618\">
                        <tr>
                        <td width=612 valign=top style='padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
                        <p class=MsoNormal align=center style='text-align:center'><b>".$school_title."</b><span style=\"font-family: �s�ө���; mso-ascii-font-family: Times New Roman; mso-hansi-font-family: Times New Roman\">&nbsp;&nbsp;&nbsp; </span></p>
                        <p class=MsoNormal align=right><span style=\"font-family: �s�ө���; mso-ascii-font-family: Times New Roman; mso-hansi-font-family: Times New Roman\">
                        <font size=\"1\">�C�L����G$today</font></span></p>".$main."</table></td></tr></table></body></html>";
        }elseif($save_csv){
			
			$main=sortview($sel_year,$sel_seme,$class_id,$subject,$stage,$chart_kind,$percent,2);
			
			//echo "ccc=".$friendly_print;
	
                $school_title=score_head2($sel_year,$sel_seme,$c_year,$c_name,$stage,$chart_kind,$subject);
                $filename = $year_seme."_".$c_year."_".$c_name."_scoresort.csv";

                header("Content-type: text/x-csv ; Charset=Big5");
                header("Content-disposition:attachment ; filename=$filename");
                //header("Pragma: no-cache");
                                //�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק�
                                header("Cache-Control: max-age=0");
                                header("Pragma: public");
                header("Expires: 0");
                echo $school_title."\r\n".$main;
				exit;
        }
		
		




  if (empty($friendly_print) && empty($save_csv)) echo $main0;

  if (empty($friendly_print) && empty($save_csv))echo $print_msg;

if (empty($friendly_print) && empty($save_csv)) echo "</td></tr></table></form></tr></table>";

//�{���ɧ�
if (empty($friendly_print) && empty($save_csv)) foot();


?>