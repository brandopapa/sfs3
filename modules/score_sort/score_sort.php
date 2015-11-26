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

$kind=$_REQUEST['kind'];  //1�w��,2����,3�w��+����

$percent=$_REQUEST['percent'];
//if (empty($percent))$percent=100;
$friendly_print=$_REQUEST['friendly_print'];
$print_asign=$_REQUEST['print_asign'];
//$yorn=findyorn();
$save_csv=$_POST['save_csv'];
$save_csv1=$_POST['save_csv1'];

$excel=$_POST['excel'];
$excel2=$_POST['excel2'];

$sort_num=$_REQUEST['sort_num'];
$move_out=$_REQUEST['move_out'];
$print_special=$_REQUEST['print_special'];
$chk=$_REQUEST[chk];
$rate=$_REQUEST['rate'];

$subject1=$_REQUEST['subject1'];
$is_show_ss_id=$_POST['show_ss_id']?'checked':'';
$is_show_rate=$_POST['rate']?'checked':'';

//print_r($subject1);


//print_r($subject1);

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
if (empty($friendly_print) && empty($save_csv) && empty($excel) && empty($excel2) && empty($save_csv1)) head("�ɱϱоǦW��");
//�C�X��V���s�����Ҳ�
if (empty($friendly_print) && empty($save_csv) && empty($excel) && empty($excel2) && empty($save_csv1)) print_menu($menu_p);
if (empty($friendly_print) && empty($save_csv) && empty($excel) && empty($excel2) && empty($save_csv1)) echo "<table border=0 cellspacing=0 cellpadding=2 width=100% bgcolor=#cccccc><tr><td>";

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

//���o�~�ůZ�ż�
function get_class_sum($k,$curr_seme="",$sel_year_arr = array()) {
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
        $query = "select c_year from school_class where enable=1 and year='$curr_year' and semester='$curr_seme' and c_year='$k' ";

        $res = $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);

		$ClassSum=0;
        while(!$res->EOF) {
                $ClassSum++;
                $res->MoveNext();
        }
        return $ClassSum;

}

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
            if ($class_year==1)$class_name["c1"]="��p�@�~��(���~�űƧ�)";
            if ($class_year==2)$class_name["c2"]="��p�G�~��(���~�űƧ�)";
            if ($class_year==3)$class_name["c3"]="��p�T�~��(���~�űƧ�)";
            if ($class_year==4)$class_name["c4"]="��p�|�~��(���~�űƧ�)";
            if ($class_year==5)$class_name["c5"]="��p���~��(���~�űƧ�)";
            if ($class_year==6)$class_name["c6"]="��p���~��(���~�űƧ�)";
            if ($class_year==7)$class_name["c7"]="�ꤤ�@�~��(���~�űƧ�)";
            if ($class_year==8)$class_name["c8"]="�ꤤ�G�~��(���~�űƧ�)";
            if ($class_year==9)$class_name["c9"]="�ꤤ�T�~��(���~�űƧ�)";
			
			if ($class_year==1)$class_name["p1"]="��p�@�~��(�U�Z�Ƨ�)";
            if ($class_year==2)$class_name["p2"]="��p�G�~��(�U�Z�Ƨ�)";
            if ($class_year==3)$class_name["p3"]="��p�T�~��(�U�Z�Ƨ�)";
            if ($class_year==4)$class_name["p4"]="��p�|�~��(�U�Z�Ƨ�)";
            if ($class_year==5)$class_name["p5"]="��p���~��(�U�Z�Ƨ�)";
            if ($class_year==6)$class_name["p6"]="��p���~��(�U�Z�Ƨ�)";
            if ($class_year==7)$class_name["p7"]="�ꤤ�@�~��(�U�Z�Ƨ�)";
            if ($class_year==8)$class_name["p8"]="�ꤤ�G�~��(�U�Z�Ƨ�)";
            if ($class_year==9)$class_name["p9"]="�ꤤ�T�~��(�U�Z�Ƨ�)";
			


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

if ($c_name=="p1")$class_id="c_01_";
if ($c_name=="p2")$class_id="c_02_";
if ($c_name=="p3")$class_id="c_03_";
if ($c_name=="p4")$class_id="c_04_";
if ($c_name=="p5")$class_id="c_05_";
if ($c_name=="p6")$class_id="c_06_";
if ($c_name=="p7")$class_id="c_07_";
if ($c_name=="p8")$class_id="c_08_";
if ($c_name=="p9")$class_id="c_09_";


}

//$subject_menu=subject_menu($sel_year,$sel_seme,$class_id,$subject,$stage,$chart_kind,$subject);
$percent_menu=percent_menu($percent);


$subject_menu_checkbox=subject_menu_checkbox($sel_year,$sel_seme,$class_id,$subject1,$stage,$chart_kind,1);  
//echo "yy:".same_name_ss_id($subject1);


$print_msg=($c_name)?"<input type='submit' name='friendly_print' value='�͵��C�L'> <input type='submit' name='excel' value='�ץXxls��'><input type='submit' name='excel2' value='�ץXxls��'><br><input type='submit' name='save_csv' value='�ץXcsv��(big5)'><input type='submit' name='save_csv1' value='�ץXcsv��(utf-8)'>":"";

//$main0=sortview($sel_year,$sel_seme,$class_id,$subject,$stage,$chart_kind,$percent,0,$rate);	


//echo "\$class_id:".$class_id."\$c_name:".$c_name;





if (empty($friendly_print) && empty($save_csv) && empty($excel) && empty($excel2) && empty($save_csv1)) 
{
	echo "<form name=\"myform\" method=\"post\" action=\"$_SERVER[SCRIPT_NAME]\">";
	echo "<table><tr>
        <td>$year_seme_menu</td><td>$class_year_menu</td><td>$stage_menu</td><td>$kind_menu</td><td>$subject_menu</td><td>$percent_menu</td><td><input type='checkbox' name='rate' value='1' $is_show_rate >���ƥ[�v</td>
        </tr>
        </table>";
	echo "<table>
		<tr>
		<td valign=top>
		<table>";
    if($year_name)echo $subject_menu_checkbox; 
	echo "</table>
		 $print_msg
		</form></td><td valign=top>&nbsp;</td><td valign=top>";
		
	$t = microtime();	
	 
	 if (substr($c_name,0,1)=="p")
	 {
     
     $nowyear=substr($c_name,1);
	 if(empty($sel_seme))$year_seme=$sel_year."2";
	 $sum=get_class_sum($nowyear,$year_seme);
	 $class_idx=$class_id;
	 $c_year=$nowyear;

	 
      for ($i=1;$i<=$sum;$i++)
	  {   
       
      $c_name=$i;
	  if ($i<10)$c_name="0".$i;
  	  $school_title=score_head2($sel_year,$sel_seme,$c_year,$c_name,$stage,$chart_kind,$subject1);
	   if (isset($_POST['run']))echo "<hr><b>$school_title</b>";
  
         $ig=$i;
		 if ($i<10)$ig="0".$i;
		 $class_id=$class_idx."_".$ig;
		 if(empty($sel_seme))$class_id=$class_idx.$ig;

	   
        if (isset($_POST['run']))
		{
			$main0=sortview($sel_year,$sel_seme,$class_id,$subject1,$stage,$chart_kind,$percent,0,$rate,$scopeall);	
            echo "$main0";
		}
	  }
	 
	 
	 
	 }
	 else
	 {
		 if (isset($_POST['run']))
		 {
	      $school_title=score_head2($sel_year,$sel_seme,$c_year,$c_name,$stage,$chart_kind,$subject1);
          $main0=sortview($sel_year,$sel_seme,$class_id,$subject1,$stage,$chart_kind,$percent,0,$rate,$scopeall);	
	 
          echo "<hr><b>$school_title</b>$main0";
		 }
	 }
	 
	 
	 echo "</td></tr></table>";
	 
	 
	 	
		 $t1 = microtime();
	 
        list($m0,$s0) = split(" ",$t);
        list($m1,$s1) = split(" ",$t1);
		
       echo "�����O�ɶ�:".sprintf("%.3f s",($s1+$m1-$s0-$m0));	
	
}





//echo "\$score_semester:$score_semester";

//echo $class_id;
//echo "\$chart_kind:$chart_kind";
//findsubject($sel_year,$sel_seme,$class_id,$ss_id,$test_kind,$test_sort);


//echo "\$subject".$subject;


 if ($friendly_print) 
 {
	
	 $today=date("Y-m-d",mktime (0,0,0,date("m"),date("d"),date("Y")));
	
	if (substr($c_name,0,1)=="p")
	{     	 
	 $nowyear=substr($c_name,1);
	 if(empty($sel_seme))$year_seme=$sel_year."2";
	 $sum=get_class_sum($nowyear,$year_seme);
	 $class_idx=$class_id;
	 $c_year=$nowyear;
	 	
	 $school_title=score_head2($sel_year,$sel_seme,$c_year,$c_name,$stage,$chart_kind,$subject1);
     //echo "<hr><b>$school_title</b>";
      for ($i=1;$i<=$sum;$i++)
	  {   
       //$c_name=$i;
	   //if ($i<10)$c_name="0".$i;

		 $ig=$i;
		 if ($i<10)$ig="0".$i;
		 $class_id=$class_idx."_".$ig;
		 if(empty($sel_seme))$class_id=$class_idx.$ig;
	   
       $main.=sortview($sel_year,$sel_seme,$class_id,$subject1,$stage,$chart_kind,$percent,1,$rate);	
       $main.="<p>";
		 
	  }
	 
	 
	 }
	 else{
			    //$main=sortview($sel_year,$sel_seme,$class_id,$subject,$stage,$chart_kind,$percent,1,$rate);
				$main=sortview($sel_year,$sel_seme,$class_id,$subject1,$stage,$chart_kind,$percent,1,$rate,$scopeall);	
				$school_title=score_head2($sel_year,$sel_seme,$c_year,$c_name,$stage,$chart_kind,$subject1);
                //$school_title=score_head2($sel_year,$sel_seme,$c_year,$c_name,$stage,$chart_kind,$subject);
               
 
	 
	 }
				
			   

				
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
        
	 
		
		
		
 }
 elseif($save_csv)
 {
	
	if (substr($c_name,0,1)=="p")
	{     
	 $nowyear=substr($c_name,1);
	 if(empty($sel_seme))$year_seme=$sel_year."2";
	 $sum=get_class_sum($nowyear,$year_seme);
	 $class_idx=$class_id;
	 $c_year=$nowyear;
	 
  	 $school_title=score_head2($sel_year,$sel_seme,$c_year,$c_name,$stage,$chart_kind,$subject1);
	 
	 //echo "<hr><b>$school_title</b>";
      for ($i=1;$i<=$sum;$i++)
	  { 
      // $c_name=$i;
	  // if ($i<10)$c_name="0".$i;  

         $ig=$i;
		 if ($i<10)$ig="0".$i;
		 $class_id=$class_idx."_".$ig;
		 if(empty($sel_seme))$class_id=$class_idx.$ig;
	   
       $main.=sortview($sel_year,$sel_seme,$class_id,$subject1,$stage,$chart_kind,$percent,2,$rate,$scopeall);	
       $main.="\r\n";
		 
	  }
	 
	 
	 }
	 else{
			
			    $main=sortview($sel_year,$sel_seme,$class_id,$subject1,$stage,$chart_kind,$percent,2,$rate,$scopeall);
			   //$main=sortview($sel_year,$sel_seme,$class_id,$subject,$stage,$chart_kind,$percent,2,$rate);
			
			   //echo "ccc=".$friendly_print;
	
                $school_title=score_head2($sel_year,$sel_seme,$c_year,$c_name,$stage,$chart_kind,$subject1);
                //$school_title=score_head2($sel_year,$sel_seme,$c_year,$c_name,$stage,$chart_kind,$subject);
     }
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
 elseif($save_csv1)
 {
	
	if (substr($c_name,0,1)=="p")
	{     
	 $nowyear=substr($c_name,1);
	 if(empty($sel_seme))$year_seme=$sel_year."2";
	 $sum=get_class_sum($nowyear,$year_seme);
	 $class_idx=$class_id;
	 $c_year=$nowyear;
	 
  	 $school_title=score_head2($sel_year,$sel_seme,$c_year,$c_name,$stage,$chart_kind,$subject1);
	 
	 //echo "<hr><b>$school_title</b>";
      for ($i=1;$i<=$sum;$i++)
	  { 
      // $c_name=$i;
	  // if ($i<10)$c_name="0".$i;  

         $ig=$i;
		 if ($i<10)$ig="0".$i;
		 $class_id=$class_idx."_".$ig;
		 if(empty($sel_seme))$class_id=$class_idx.$ig;
	   
       $main.=sortview($sel_year,$sel_seme,$class_id,$subject1,$stage,$chart_kind,$percent,2,$rate,$scopeall);	
       $main.="\r\n";
		 
	  }
	 
	 
	 }
	 else{
			
			    $main=sortview($sel_year,$sel_seme,$class_id,$subject1,$stage,$chart_kind,$percent,2,$rate,$scopeall);
			   //$main=sortview($sel_year,$sel_seme,$class_id,$subject,$stage,$chart_kind,$percent,2,$rate);
			
			   //echo "ccc=".$friendly_print;
	
                $school_title=score_head2($sel_year,$sel_seme,$c_year,$c_name,$stage,$chart_kind,$subject1);
                //$school_title=score_head2($sel_year,$sel_seme,$c_year,$c_name,$stage,$chart_kind,$subject);
     }
				$filename = $year_seme."_".$c_year."_".$c_name."_scoresort.csv";

                header("Content-type: text/x-csv ; Charset=Big5");
                header("Content-disposition:attachment ; filename=$filename");
                //header("Pragma: no-cache");
                                //�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק�
                                header("Cache-Control: max-age=0");
                                header("Pragma: public");
                header("Expires: 0");
				//echo $school_title."\r\n".$main;
				
				
				$ddd=$school_title."\r\n".$main;
		        $ddd=iconv("BIG5","UTF-8",$ddd);

                preg_match_all("/&#([0-9]{5});/", $ddd, $matches, PREG_SET_ORDER);
 
                foreach ($matches as $val) {            
			    $ddd = preg_replace("/$val[0]/", mb_convert_encoding($val[0],"utf-8","HTML-ENTITIES"),$ddd);
                }
			    echo $ddd;
				
				
			   exit;
				
				
		
				
 }
 elseif($excel)
 {
			
	if (substr($c_name,0,1)=="p")
	{     
	 $nowyear=substr($c_name,1);
	 if(empty($sel_seme))$year_seme=$sel_year."2";
	 $sum=get_class_sum($nowyear,$year_seme);
	 $class_idx=$class_id;
	 $c_year=$nowyear;
	 
	 $school_title=score_head2($sel_year,$sel_seme,$c_year,$c_name,$stage,$chart_kind,$subject1);
	 
	 //echo "<hr><b>$school_title</b>";
      for ($i=1;$i<=$sum;$i++)
	  {   
         $ig=$i;
		 if ($i<10)$ig="0".$i;
		 $class_id=$class_idx."_".$ig;
		 if(empty($sel_seme))$class_id=$class_idx.$ig;
		 
       $main.=sortview($sel_year,$sel_seme,$class_id,$subject1,$stage,$chart_kind,$percent,3,$rate,$scopeall);	
       $main.="�ɱ϶���,�����Ҧr��,�~��,�Z��,�y��,�m�W,���Z,�W��,PR��,�Ƶ�\n";
		 
	  }
	 
	 
	 }
	 else{			
		
        $school_title=score_head2($sel_year,$sel_seme,$c_year,$c_name,$stage,$chart_kind,$subject1);
        $main=sortview($sel_year,$sel_seme,$class_id,$subject1,$stage,$chart_kind,$percent,3,$rate,$scopeall);
        
	 } 




	 
	 
 $filename = $year_seme."_".$c_year."_".$c_name."_scoresort.xls";

//Ū�JHEAD
$fd = fopen("excelsample/forT_head.txt", "r");
while (!feof($fd)) {
    $buffer = fgets($fd, 4096);
    $m_strHead.=$buffer;
}

//Ū�JHEAD2
$fd = fopen("excelsample/forT_head2.txt", "r");
while (!feof($fd)) {
    $buffer = fgets($fd, 4096);
    $m_strHead2.=$buffer;
}

$m_strHead2=iconv("UTF-8","BIG5",$m_strHead2);
$m_strHead=iconv("UTF-8","BIG5",$m_strHead);


$m_strHead=str_replace("{TITLE}", $school_title,$m_strHead);
//Ū�JBODY
$fd = fopen("excelsample/forT_body.txt", "r");
while (!feof($fd)) {
    $buffer = fgets($fd, 4096);
    $m_strBody.=$buffer;
}

//Ū�JFOOT
$fd = fopen("excelsample/forT_foot.txt", "r");
while (!feof($fd)) {
    $buffer = fgets($fd, 4096);
    $m_strFoot.=$buffer;
}

$da=explode("\n",$main);

for ($i = 0; $i < count($da)-1; $i++) {
	$ba=explode(",",$da[$i]);
	
    $m_strBodytemp = $m_strBody; 
    $m_strBodytemp = str_replace("{brank}", $ba[0], $m_strBodytemp);
    $m_strBodytemp = str_replace("{nm}", $ba[1], $m_strBodytemp);	
    $m_strBodytemp = str_replace("{year}", $ba[2], $m_strBodytemp);
    $m_strBodytemp = str_replace("{class}", $ba[3], $m_strBodytemp);
    $m_strBodytemp = str_replace("{number}", $ba[4], $m_strBodytemp);
	$m_strBodytemp = str_replace("{name}", $ba[5], $m_strBodytemp);
	$m_strBodytemp = str_replace("{score}", $ba[6], $m_strBodytemp);
	$m_strBodytemp = str_replace("{rank}", $ba[7], $m_strBodytemp);
	$m_strBodytemp = str_replace("{pr}", $ba[8], $m_strBodytemp);
	$m_strBodytemp = str_replace("{ud}", $ba[9], $m_strBodytemp);
	
    $m_strBodyMix .= $m_strBodytemp; 
}



header("Content-type:application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=" . $filename);


		echo $m_strHead . $m_strHead2 . $m_strBodyMix . $m_strFoot; 

           
 exit;

}
elseif($excel2)
{
		$main=sortview($sel_year,$sel_seme,$class_id,$subject1,$stage,$chart_kind,$percent,3,$rate,$scopeall);

		
		require_once "../../include/sfs_case_excel.php";
		$x=new sfs_xls();
		$x->setUTF8();
		$x->filename=$year_seme."_".$c_year."_".$c_name."_scoresort.xls";
		$x->setBorderStyle(1);
		$x->addSheet('ScoreSort');
		$x->items[0]=array('�ɱ϶���','�����Ҧr��','�~��','�Z��','�y��','�m�W','���Z','�W��','PR��','�Ƶ�');
		
		$da=explode("\n",$main);

         for ($i = 0; $i < count($da)-1; $i++) {
	     $ba=explode(",",$da[$i]);
         $x->items[]=array($ba[0],$ba[1],$ba[2],$ba[3],$ba[4],$ba[5],$ba[6],$ba[7],$ba[8],$ba[9]);
         }
		
		
		
	    
		$x->writeSheet();
		$x->process();


           
 exit;

}

		


  //if (empty($friendly_print) && empty($save_csv)) echo $main0;

 // if (empty($friendly_print) && empty($save_csv))echo $print_msg;

if (empty($friendly_print) && empty($save_csv) && empty($excel) && empty($excel2) && empty($save_csv1)) echo "</td></tr></table></tr></table>";

//�{���ɧ�
if (empty($friendly_print) && empty($save_csv) && empty($excel) && empty($excel2) && empty($save_csv1)) foot();


?>