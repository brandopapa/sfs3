<?php
// $Id: manage.php 5310 2009-01-10 07:57:56Z hami $
/*�ޤJ�ǰȨt�γ]�w��*/
include "config.php";
//�ޤJ���
include "./my_fun.php";

//�ϥΪ̻{��
sfs_check();

// ���ݭn register_globals
/*
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}
*/
if($_POST['teacher_course']) $teacher_course=$_POST['teacher_course'];
else $teacher_course=$_GET['teacher_course'];
if($_POST['curr_sort']) $curr_sort=$_POST['curr_sort'];
else $curr_sort=$_GET['curr_sort'];
$edit=$_GET['edit'];
$need_allow=$_GET['need_allow'];
$feelback1=$_GET['feelback1'];
$curr_form=$_GET['curr_form'];
$msg=$_GET['msg'];
$del=$_GET['del'];

//�{�����Y
head("���Z�C��");

//�C�X��V���s�����Ҳ�
$Link = "teacher_course=$_GET[teacher_course]";
print_menu($menu_p,$Link);

$yorn=findyorn();
//�]�w�D������ܰϪ��I���C��
echo "<table border=0 cellspacing=1 cellpadding=2 width=100% bgcolor=#cccccc><tr><td bgcolor='#FFFFFF'>";
if($need_allow!=""){
    $update_rs=$CONN->Execute("select  teacher_sn,class_id,ss_id from score_course where course_id='$teacher_course'") or die("help");
    $teacher_sn=$update_rs->fields['teacher_sn'];
    $class_id=$update_rs->fields['class_id'];
    $ss_id=$update_rs->fields['ss_id'];
    $CONN->Execute("UPDATE  score_course  SET  allow='$need_allow'  WHERE  teacher_sn='$teacher_sn' and class_id='$class_id' and ss_id='$ss_id'") or die("help");    
}
if($feelback1!="") {
    echo "
        <script type='text/javascript' language='javascript'>
            alert(\"�W�ǥ����\�A�i�ध�e�w�g�W�ǹL�ҥH��ƪ�Q��w�F�A�Ь��аȳB\");
        </script>
    ";
}
if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�


$teacher_id=$_SESSION['session_log_id'];//���o�n�J�Ѯv��id
$col_name="teacher_course";
$id=$teacher_course;
$select_teacher_ss=&select_teacher_ss($id,$col_name,$teacher_id,$sel_year,$sel_seme);
for($i=1;$i<=3;$i++){
    $check_sort[$i]=$i;
}
for($i=1;$i<=3;$i++){
    $selected_sort[$i]=($check_sort[$i]==$curr_sort)?"selected":"";
}
$check_form[0]="1";
$check_form[1]="2";
for($i=0;$i<2;$i++){
    $form_selected[$i]=($check_form[$i]==$curr_form)?"selected":"";
}
$select_teacher_subject="
    <form name='form1' method='post' action='{$_SERVER['PHP_SELF']}'>
        <select name='$col_name' onChange='jumpMenu1()'>
            $select_teacher_ss;
        </select>
    </form>
    ";
$sql="select performance_test_times from score_setup where year='$sel_year' and semester='$sel_seme'";
$rs=$CONN->Execute($sql);
$performance_test_times=$rs->fields['performance_test_times'];

/*�۰ʧP�_�ثe�i��O�ĴX���q���U�Ԧ����**********************************************/
$rs=&$CONN->Execute("select  *  from  score_course where course_id=$teacher_course");
$year=$rs->fields['year'];
$semester=$rs->fields['semester'];
$class_id=$rs->fields['class_id'];
$ss_id=$rs->fields['ss_id'];

$rs_print=$CONN->Execute("select print from score_ss where ss_id='$ss_id'");
$print=$rs_print->fields["print"];

if($teacher_course){
    if($print==1){
        $Nnow_stage=Nnow_stage($id,$col_name,$teacher_id,$sel_year,$sel_seme,$class_id,$ss_id);
        $col_name="curr_sort";
        $id=$curr_sort;
        $now_stage=now_stage($id,$col_name,$teacher_id,$sel_year,$sel_seme,$class_id,$ss_id);       		
		$select_stage_bar="
            <form name='form9' method='post' action='{$_SERVER['PHP_SELF']}'>
            <input type='hidden' name='teacher_course' value='$teacher_course'>
            <select name='$col_name' onChange='jumpMenu9()'>
                    $now_stage;
            </select>
            </form>
    ";
    }
    else{
        $curr_sort=255;
    }
    if(empty($curr_sort)) $curr_sort=$Nnow_stage;
    }
//�B�ʻ�������
$ol  = new overlib($SFS_PATH_HTML."include");
$ol->ol_capicon=$SFS_PATH_HTML."images/componi.gif";

echo "<table cellspacing=0 cellpadding=0><tr><td>$select_teacher_subject</td><td>$select_stage_bar</td>";
//�H�W�����bar
/*****************************************************************************************************/
//
//�t�Φ۰ʰ������Ǵ��x�s���Z����ƪ�O�_�s�b�Y���s�b�h�۰ʷs�W�A�R�W�W�h�Gscore_semester_091_1
//
/*****************************************************************************************************/
       $score_semester="score_semester_".$sel_year."_".$sel_seme;
       //echo $score_semester;

       $creat_table_sql="CREATE TABLE  if not exists $score_semester (
                         score_id int(10) unsigned NOT NULL auto_increment,
                         class_id varchar(11) NOT NULL default '',
                         student_sn int(10) unsigned NOT NULL default '0',
                         ss_id smallint(5) unsigned NOT NULL default '0',
                         score float unsigned NOT NULL default '0',
                         test_name varchar(20) NOT NULL default '',
                         test_kind varchar(10) NOT NULL default '�w�����q',
                         test_sort tinyint(3) unsigned NOT NULL default '0',
                         update_time datetime NOT NULL default '0000-00-00 00:00:00',
                         sendmit enum('0','1') NOT NULL default '1',
                         PRIMARY KEY  (score_id)
                         )";

       $rs=$CONN->Execute($creat_table_sql);

/*****************************************************************************************************/
$select_course_id_sql="select * from score_course where course_id=$teacher_course";
$rs_select_course_id=$CONN->Execute($select_course_id_sql);
$year= $rs_select_course_id->fields['year'];
$semester= $rs_select_course_id->fields['semester'];
$class_id=$rs_select_course_id->fields[class_id];
$class_year=$rs_select_course_id->fields[class_year];
$ss_id= $rs_select_course_id->fields['ss_id'];
$teacher_sn = $rs_select_course_id->fields['teacher_sn'];
$allow=$rs_select_course_id->fields['allow'];
    $select_class_num="select class_num from teacher_post where teacher_sn='{$_SESSION['session_tea_sn']}'";
    $rs_select_class_num=$CONN->Execute($select_class_num);
    $class_num = $rs_select_class_num->fields['class_num'];
    if($class_num) $class_num=sprintf("%03d_%d_%02d_%02d",$sel_year,$sel_seme,substr($class_num,0,-2),substr($class_num,-2));
    if(($teacher_course) && ($class_id!=$class_num)) {
        //if($need_allow=="") $need_allow=0;	
	if ($allow=='1') {
		$checked="checked";
		$uu =0;
		$temp_ol = $ol->over("�����ť��ɮv�i�ק糧�즨�Z,<br>�ثe���A��<font color=red>�����ק�</font>","�ɮv�ק�\�໡��");
	}
	else {
		$checked="";
		$uu =1;
		$temp_ol = $ol->over("�}��ť��ɮv�i�ק糧�즨�Z,<br>�ثe���A��<font color=red>�}��ɮv�ק�</font>","�ɮv�ק�\�໡��");

	}
        $check_allow="
        <form name='allow_form' method='post' action='{$_SERVER['PHP_SELF']}'>
            <input type='hidden' name='teacher_course' value='$teacher_course'>
            <input type='hidden' name='curr_sort' value='$curr_sort'>
            <input type='checkbox' name='need_allow' value='$uu' $checked onClick='jumpMenu_allowform()'><a $temp_ol >�����ɮv�޲z�v��</a>
        </form>
        ";
        echo "<td>".$check_allow."</td>";
    }
echo "</tr></table>";
//�H�W�����bar
/*****************************************************************************************************/
$subject_name=ss_id_to_subject_name($ss_id);
//echo $class_year;
/********************************************************************************/
$sql="select * from school_class where class_id='$class_id'";
$rs=$CONN->Execute($sql);

$stud_sn=class_id_to_student_sn($class_id);
$full_class_name=course_id_to_full_class_name($teacher_course);
/*********************************************************************************/
//���X���Ǧ~���Ǵ����Ǯզ��Z�@�q�]�w
$sql="select * from score_setup where year='$sel_year' and semester='$sel_seme' and class_year='$class_year'";
$rs=$CONN->Execute($sql);
$score_mode= $rs->fields['score_mode'];
$test_ratio= $rs->fields['test_ratio'];
if($score_mode=="all"){
    $test_ratio=explode("-",$test_ratio);
}
elseif($score_mode=="severally"){
    $test_ratio=explode(",",$test_ratio);
    $i=$curr_sort-1;
    $test_ratio=explode("-",$test_ratio[$i]);
}
else{
    $test_ratio[0]=60;
    $test_ratio[1]=40;
}
	//���Z����table
	$score_edu_adm="score_edu_adm_".$sel_year."_".$sel_seme;
	//�ˬd�O�_ú�ܱаȳB
	$query = "select count(*) from $score_edu_adm where class_id='$class_id' and ss_id='$ss_id' and test_sort='$curr_sort'  and enable=1";
	$res= $CONN->Execute($query);
//	echo $query;
	$is_send = $res->fields[0];	
/*********************************************************************************/
$test_sort_name=array("","�Ĥ@���q","�ĤG���q","�ĤT���q","�ĥ|���q","�Ĥ����q","�Ĥ����q","�ĤC���q","�ĤK���q","�ĤE���q","�ĤQ���q",255 => "���Ǵ�");
if(($teacher_course)&&($curr_sort)&&($curr_sort!=255)&&($curr_sort!=254)){
    $url_str_1 = $SFS_PATH_HTML.get_store_path()."/quick_input_m.php?edit=s1&class_id=$class_id&teacher_course=$teacher_course&ss_id=$ss_id&curr_sort=$curr_sort";
    $url_str_2 = $SFS_PATH_HTML.get_store_path()."/quick_input_m.php?edit=s2&class_id=$class_id&teacher_course=$teacher_course&ss_id=$ss_id&curr_sort=$curr_sort";    
	if($yorn=='n'){
		$main="
			<table bgcolor=#000000 border=0 cellpadding=2 cellspacing=1>
				<tr bgcolor=#ffffff>
					<td  colspan=5 align=center>".$full_class_name.$subject_name.$test_sort_name[$curr_sort]."���Z�Ҭd</td>
				</tr>
				<tr bgcolor=#ffffff align=center>
					<td>�y��</td>
					<td>�m�W</td>
					<td>�w�����q*".$test_ratio[0]."%<br><a onclick=\"openwindow('$url_str_1')\"><img src='./images/wedit.png' border='0'></a><a href=\"{$_SERVER['PHP_SELF']}?edit=s1&teacher_course=$teacher_course&curr_sort=$curr_sort\"><img src='./images/pen.png' border='0'></a><a href=\"{$_SERVER['PHP_SELF']}?del=ds1&edit=s1&teacher_course=$teacher_course&curr_sort=$curr_sort\" onClick=\"return confirm('�T�w�R���o�����Z ?');\"><img src='./images/del.png' border='0'></a></td>					
					<td>����</td>
				</tr>";		
	}	
	else{
		$main="
			<table bgcolor=#000000 border=0 cellpadding=2 cellspacing=1>
				<tr bgcolor=#ffffff>
					<td  colspan=5 align=center>".$full_class_name.$subject_name.$test_sort_name[$curr_sort]."���Z�Ҭd</td>
				</tr>
				<tr bgcolor=#ffffff align=center>
					<td>�y��</td>
					<td>�m�W</td>";
		if($test_ratio[0]!=0) $main.="<td>�w�����q*".$test_ratio[0]."%<br><a onclick=\"openwindow('$url_str_1')\"><img src='./images/wedit.png' border='0'></a><a href=\"{$_SERVER['PHP_SELF']}?edit=s1&teacher_course=$teacher_course&curr_sort=$curr_sort\"><img src='./images/pen.png' border='0'></a><a href=\"{$_SERVER['PHP_SELF']}?del=ds1&edit=s1&teacher_course=$teacher_course&curr_sort=$curr_sort\" onClick=\"return confirm('�T�w�R���o�����Z ?');\"><img src='./images/del.png' border='0'></a></td>";
		if($test_ratio[1]!=0) $main.="<td>���ɦ��Z*".$test_ratio[1]."%<br><a onclick=\"openwindow('$url_str_2')\"><img src='./images/wedit.png' border='0'></a><a href=\"{$_SERVER['PHP_SELF']}?edit=s2&teacher_course=$teacher_course&curr_sort=$curr_sort\"><img src='./images/pen.png' border='0'></a><a href=\"{$_SERVER['PHP_SELF']}?del=ds2&edit=s2&teacher_course=$teacher_course&curr_sort=$curr_sort\" onClick=\"return confirm('�T�w�R���o�����Z ?');\"><img src='./images/del.png' border='0'></a></td>";
		$main.="<td>����</td>
				</tr>";
	}			

?>
   <form name="form2" method="post" action="upd_semester.php">
<?php
        $Cch=0;
        for($m=0;$m<count($stud_sn);$m++){
//            $rs1=&$CONN->Execute("select score from $score_semester where student_sn='$stud_sn[$m]' and ss_id=$ss_id and test_sort='$curr_sort' and test_kind='�w�����q'");
	
            $rs1=&$CONN->Execute("select score from $score_semester where student_sn='$stud_sn[$m]' and ss_id=$ss_id and test_sort='$curr_sort' and test_kind='�w�����q'");
            $score1=$rs1->fields[score];
            if($del=="ds1") $score1="-100";
            if($score1=="-100") {$score1=""; $Cch++;}
            //if(($score1>"100")||($score1<"0")) {$score1=""; $Cch++;}
            $rs2=&$CONN->Execute("select score from $score_semester where student_sn='$stud_sn[$m]' and ss_id=$ss_id and test_sort='$curr_sort' and test_kind='���ɦ��Z'");
            $score2=$rs2->fields[score];
            if($del=="ds2") $score2="-100";
            if($score2=="-100") {$score2=""; $Cch++;}
            $rs3=&$CONN->Execute("select stud_name from stud_base where student_sn='$stud_sn[$m]'");
            $stud_name=$rs3->fields[stud_name];
            $site_num=student_sn_to_site_num($stud_sn[$m]);
            $aver_score1=$score1*$test_ratio[0];
            $aver_score2=$score2*$test_ratio[1];
            $ratio=$test_ratio[0]+$test_ratio[1];
            if($yorn=='y'){
				if(($score1=="")&&($score2=="")) {$average_score[$m]="";}
				elseif(($score1=="")&&($score2!="")) {$average_score[$m]=$score2;}
				elseif(($score1!="")&&($score2=="")) {$average_score[$m]=$score1;}
				else {$average_score[$m]=(($aver_score1+$aver_score2)/$ratio);}
				if($average_score[$m]!="") $average_score[$m]=number_format($average_score[$m],2);
            }
			else{
				$average_score[$m]=$score1;			
			}
			//echo $stud_sn[$m]."===".$average_score[$m];
            $bgcolor1="#FFFFFF";
            $red1="#000000";
            $bgcolor2="#FFFFFF";
            $red2="#000000";
            $red3="#000000";
            if(($score1!="")&&($score1<60)) {$bgcolor1="#ff0000"; $red1="#ff0000";}
            if(($score2!="")&&($score2<60)) {$bgcolor2="#ff0000"; $red2="#ff0000";}
            if(($average_score[$m]!="")&&($average_score[$m]<60)) {$red3="#ff0000";}
            if($edit=="s1"){            
                if($yorn=='y'){
					$main.="
					<tr bgcolor=#ffffff>
                        <td>$site_num</td>
                        <td>$stud_name</td>
                        <td bgcolor=$bgcolor1><input type=\"text\" name=score1[$stud_sn[$m]] size=\"8\" maxlength=\"4\" value='".$score1."' class='border_no' style='width: 100%'></td>";
                        if($test_ratio[1]!=0) $main.="<td><font color=$red2>$score2</font></td>";
                        $main.="<td><font color=$red3>".$average_score[$m]."</font></td>
                	</tr>";
				}
				else{
					$main.="
					<tr bgcolor=#ffffff>
                        <td>$site_num</td>
                        <td>$stud_name</td>
                        <td bgcolor=$bgcolor1><input type=\"text\" name=score1[$stud_sn[$m]] size=\"8\" maxlength=\"4\" value='".$score1."' class='border_no' style='width: 100%'></td>                        
                        <td><font color=$red2>".$score2."</font></td>
                        <td><font color=$red3>".$average_score[$m]."</font></td>
                	</tr>";											
				}
            }
            elseif($edit=="s2"){
            	if($yorn=='y'){
					$main.="
						<tr bgcolor=#ffffff>
								<td>$site_num</td>
								<td>$stud_name</td>";
								if($test_ratio[0]!=0) $main.="<td><font color=$red1>$score1</font></td>";
								$main.="<td bgcolor=$bgcolor2><input type=\"text\" name=score2[$stud_sn[$m]] size=\"8\" maxlength=\"4\" value='".$score2."' class='border_no' style='width: 100%'></td>
								<td><font color=$red3>".$average_score[$m]."</font></td>
						</tr>";
				}
            }
            else{
				if($yorn=='y'){
					$main.="
						<tr bgcolor=#ffffff>
								<td>$site_num</td>
								<td>$stud_name</td>";
								if($test_ratio[0]!=0) $main.="<td><font color=$red1>$score1</font></td>";
								if($test_ratio[1]!=0) $main.="<td><font color=$red2>$score2</font></td>";
								$main.="<td><font color=$red3>".$average_score[$m]."</font></td>
						</tr>";
				}
				else{
					$main.="
						<tr bgcolor=#ffffff>
								<td>$site_num</td>
								<td>$stud_name</td>
								<td><font color=$red1>$score1</font></td>
								
								<td><font color=$red3>".$average_score[$m]."</font></td>
						</tr>";								
				}		
			}
            echo "<input type=\"hidden\" name=score1[$stud_sn[$m]] value=".$score1.">";
            echo "<input type=\"hidden\" name=score2[$stud_sn[$m]] value=".$score2.">";

        }
        echo $main;
        echo"</table>";
?>
        <input type="hidden" name="class_id" value=<?php echo $class_id ?>>
        <input type="hidden" name="stud_sn_array" value=<?php echo $stud_sn_array ?>>
        <input type="hidden" name="ss_id" value=<?php echo $ss_id ?>>
        <input type="hidden" name="test_sort" value=<?php echo $curr_sort ?>>
        <input type="hidden" name="test_form" value=<?php echo $curr_form ?>>
        <input type="hidden" name="teacher_course" value=<?php echo $teacher_course ?>>
        <input type="hidden" name="submit2_check" value="1">
        <input type="submit" name="Submit2" value="�x�s">
 <?php
    if($edit){

        if($edit=="s1") $io_test_name="�w�����q";
        elseif($edit=="s2") $io_test_name="���ɦ��Z";
 ?>
        <input type="hidden" name="test_kind" value=<?php echo $io_test_name ?>>
        <input type="submit" name="file_in" value=�פJ<?php echo $io_test_name ?>>
        <input type="submit" name="file_out" value=�ץX<?php echo $io_test_name ?>>
 <?php
    }
 ?>
    </form>
    <?php
        $ehter_ok=999;		
		if($submit2_check!="1"){
            $ehter_ok=0;
            for($q=0;$q<count($stud_sn);$q++){
                $rs1=&$CONN->Execute("select score from $score_semester where student_sn='$stud_sn[$q]' and ss_id=$ss_id and test_sort='$curr_sort' and test_kind='�w�����q'");
                //echo "select score from $score_semester where student_sn='$stud_sn[$q]' and ss_id=$ss_id and test_sort='$curr_sort' and test_kind='�w�����q'";
				$score1=$rs1->fields[score];
                //echo "<<".$score1.">>";
                if($score1=="-100" && $test_ratio[0]!=0 ) $ehter_ok++;                				
				if($yorn=='y'){
					$rs2=&$CONN->Execute("select score from $score_semester where student_sn='$stud_sn[$q]' and ss_id=$ss_id and test_sort='$curr_sort' and test_kind='���ɦ��Z'");
                	$score2=$rs2->fields[score];
                	if($score2=="-100"  && $test_ratio[1]!=0 ) $ehter_ok++;
				}
                //echo $ehter_ok;
            }
            //echo $ehter_ok;
        }
        //echo $ehter_ok;

    ?>
    <form name="form3" method="post" action="semester_remit.php" onSubmit="return confirmSubmit()">
        <input type="hidden" name="class_id" value=<?php echo $class_id ?>>
        <?php
            for($m=0;$m<count($stud_sn);$m++){
                echo "
                    <input type='hidden' name=student_sn[$m] value=$stud_sn[$m]>
                    <input type='hidden' name=score[$m] value=$average_score[$m]>
                ";
            }
            if((($submit2_check)&&($Cch=='0'))||($ehter_ok=="0")){
        ?>
        <input type="hidden" name="ss_id" value=<?php echo $ss_id ?>>
        <input type="hidden" name="sended" value="ok">
        <input type="hidden" name="test_sort" value=<?php echo $curr_sort ?>>
        <input type="hidden" name="test_form" value=<?php echo $curr_form ?>>
        <input type="hidden" name="teacher_course" value=<?php echo $teacher_course ?>>
	<?php
	if ($is_send>0) 
		echo "<p>�������Z�w�צܱаȳB,�Y�����~,�гs���аȳB�B�z</p>";
	else
		echo "<input type=\"submit\" name=\"Submit3\" value=\"�ר�аȳB\">";
	?>	
			
   </form>
<?php
            }
            else{                
                if($sended!="ok"){
                    echo "<font color='#FF0000'>�z�ثe�ҿ�J�����Z������Ω|���x�s�I�]���z�L�k�ר�аȳB</font><br>";
                }
                else{
                    echo "<font color='#0000FF'>�z�w�g���\�W��</font><br>";
                }
            }
     }


//���Ǵ�
elseif(($teacher_course)&&($curr_sort)&&($curr_sort==255)){
    //$url_str_1 = $SFS_PATH_HTML.get_store_path()."/quick_input_m.php?edit=s1&teacher_course=$teacher_course&ss_id=$ss_id&curr_sort=$curr_sort";
    $url_str_2 = $SFS_PATH_HTML.get_store_path()."/quick_input_m.php?edit=s2&teacher_course=$teacher_course&ss_id=$ss_id&curr_sort=$curr_sort";
    $main="
        <table bgcolor=#000000 border=0 cellpadding=2 cellspacing=1>
            <tr bgcolor=#ffffff>
                <td  colspan=4 align=center>".$full_class_name.$subject_name.$test_sort_name[$curr_sort]."���Z�Ҭd</td>
            </tr>
            <tr bgcolor=#ffffff align=center>
                <td>�y��</td>
                <td>�m�W</td>
                <td>�Ǵ����Z<br><a onclick=\"openwindow('$url_str_2')\"><img src='./images/wedit.png' border='0'></a><a href=\"{$_SERVER['PHP_SELF']}?edit=s2&teacher_course=$teacher_course&curr_sort=$curr_sort\"><img src='./images/pen.png' border='0'></a><a href=\"{$_SERVER['PHP_SELF']}?del=ds2&edit=s2&teacher_course=$teacher_course&curr_sort=$curr_sort\" onClick=\"return confirm('�T�w�R���o�����Z ?');\"><img src='./images/del.png' border='0'></a></td>
                <td>����</td>
            </tr>";

?>
   <form name="form2" method="post" action="upd_semester.php">
<?php
        $Cch=0;
        for($m=0;$m<count($stud_sn);$m++){
            //$rs1=&$CONN->Execute("select score from $score_semester where student_sn='$stud_sn[$m]' and ss_id=$ss_id and test_sort='$curr_sort' and test_kind='�w�����q'");

            //$rs1=&$CONN->Execute("select score from $score_semester where student_sn='$stud_sn[$m]' and ss_id=$ss_id and test_sort='$curr_sort' and test_kind='�w�����q'");
            //$score1=$rs1->fields[score];
            //if($del=="ds1") $score1="-100";
            //if($score1=="-100") {$score1=""; $Cch++;}
            //if(($score1>"100")||($score1<"0")) {$score1=""; $Cch++;}
            $rs2=&$CONN->Execute("select score from $score_semester where student_sn='$stud_sn[$m]' and ss_id=$ss_id and test_sort='$curr_sort' and test_kind='���Ǵ�'");
            $score2=$rs2->fields[score];
            if($del=="ds2") $score2="-100";
            if($score2=="-100") {$score2=""; $Cch++;}
            $rs3=&$CONN->Execute("select stud_name from stud_base where student_sn='$stud_sn[$m]'");
            $stud_name=$rs3->fields[stud_name];
            $site_num=student_sn_to_site_num($stud_sn[$m]);
            //$aver_score1=$score1*$test_ratio[0];
            //$aver_score2=$score2*$test_ratio[1];
            //$ratio=$test_ratio[0]+$test_ratio[1];
            $ratio=100;
            //if(($score1=="")&&($score2=="")) {$average_score[$m]="";}
            //elseif(($score1=="")&&($score2!="")) {$average_score[$m]=$score2;}
            //elseif(($score1!="")&&($score2=="")) {$average_score[$m]=$score1;}
            $average_score[$m]=$score2;
            if($average_score[$m]!="") $average_score[$m]=number_format($average_score[$m],2);
            //echo $stud_sn[$m]."===".$average_score[$m];
            $bgcolor2="#FFFFFF";
            $red2="#000000";
            $red3="#000000";
            if(($score2!="")&&($score2<60)) {$bgcolor2="#ff0000"; $red2="#ff0000";}
            if(($average_score[$m]!="")&&($average_score[$m]<60)) {$red3="#ff0000";}
            if($edit=="s2"){
            $main.="
                <tr bgcolor=#ffffff>
                        <td>$site_num</td>
                        <td>$stud_name</td>
                        <td bgcolor=$bgcolor2><input type=\"text\" name=score2[$stud_sn[$m]] size=\"8\" maxlength=\"4\" value='".$score2."' class='border_no' style='width: 100%'></td>
                        <td><font color=$red3>".$average_score[$m]."</font></td>
                </tr>";
            }
            else{
            $main.="
                <tr bgcolor=#ffffff>
                        <td>$site_num</td>
                        <td>$stud_name</td>
                        <td><font color=$red2>$score2</font></td>
                        <td><font color=$red3>".$average_score[$m]."</font></td>
                </tr>";
            }
            echo "<input type=\"hidden\" name=score2[$stud_sn[$m]] value=".$score2.">";

        }
        echo $main;
        echo"</table>";
?>
        <input type="hidden" name="class_id" value=<?php echo $class_id ?>>
        <input type="hidden" name="stud_sn_array" value=<?php echo $stud_sn_array ?>>
        <input type="hidden" name="ss_id" value=<?php echo $ss_id ?>>
        <input type="hidden" name="test_sort" value=<?php echo $curr_sort ?>>
        <input type="hidden" name="test_form" value=<?php echo $curr_form ?>>
        <input type="hidden" name="teacher_course" value=<?php echo $teacher_course ?>>
        <input type="hidden" name="submit2_check" value="1">
        <input type="submit" name="Submit2" value="�x�s">
 <?php
    if($edit){

        $io_test_name="���Ǵ�";
 ?>
        <input type="hidden" name="test_kind" value=<?php echo $io_test_name ?>>
        <input type="submit" name="file_in" value=�פJ<?php echo $io_test_name."���Z" ?>>
        <input type="submit" name="file_out" value=�ץX<?php echo $io_test_name."���Z" ?>>
 <?php
    }
 ?>
    </form>
    <?php
        $ehter_ok=999;
        if($submit2_check!="1"){
            $ehter_ok=0;
            for($q=0;$q<count($stud_sn);$q++){
                $rs2=&$CONN->Execute("select score from $score_semester where student_sn='$stud_sn[$q]' and ss_id=$ss_id and test_sort='$curr_sort' and test_kind='���ɦ��Z'");
                $score2=$rs2->fields[score];
                if($score2=="-100"  && $test_ratio[1]!=0 ) $ehter_ok++;
                //echo $ehter_ok;
            }
            //echo $ehter_ok;
        }
        //echo $ehter_ok;

    ?>
    <form name="form3" method="post" action="semester_remit.php" onSubmit="return confirmSubmit()">
        <input type="hidden" name="class_id" value=<?php echo $class_id ?>>
        <?php
            for($m=0;$m<count($stud_sn);$m++){
                echo "
                    <input type='hidden' name=student_sn[$m] value=$stud_sn[$m]>
                    <input type='hidden' name=score[$m] value=$average_score[$m]>
                ";
            }
            if((($submit2_check)&&($Cch=='0'))||($ehter_ok=="0")){
        ?>
        <input type="hidden" name="ss_id" value=<?php echo $ss_id ?>>
        <input type="hidden" name="sended" value="ok">
        <input type="hidden" name="test_sort" value=<?php echo $curr_sort ?>>
        <input type="hidden" name="test_form" value=<?php echo $curr_form ?>>
        <input type="hidden" name="teacher_course" value=<?php echo $teacher_course ?>>

        <input type="submit" name="Submit3" value="�ר�аȳB">
   </form>
<?php
            }
            else{                
                if($sended!="ok"){
                    echo "<font color='#FF0000'>�z�ثe�ҿ�J�����Z������Ω|���x�s�I�]���z�L�k�ר�аȳB</font>";
                }
                else{
                    echo "<font color='#0000FF'>�z�w�g���\�W��</font>";
                }
            }


}

//���Ǵ������ɦ��Z
elseif(($teacher_course)&&($curr_sort)&&($curr_sort==254)){
    //$url_str_1 = $SFS_PATH_HTML.get_store_path()."/quick_input_m.php?edit=s1&teacher_course=$teacher_course&ss_id=$ss_id&curr_sort=$curr_sort";
    $url_str_2 = $SFS_PATH_HTML.get_store_path()."/quick_input_m.php?edit=s2&teacher_course=$teacher_course&ss_id=$ss_id&curr_sort=$curr_sort";
    $main="
        <table bgcolor=#000000 border=0 cellpadding=2 cellspacing=1>
            <tr bgcolor=#ffffff>
                <td  colspan=4 align=center>".$full_class_name.$subject_name.$test_sort_name[$curr_sort]."���Z�Ҭd</td>
            </tr>
            <tr bgcolor=#ffffff align=center>
                <td>�y��</td>
                <td>�m�W</td>
                <td>���Ǵ����ɦ��Z<br><a onclick=\"openwindow('$url_str_2')\"><img src='./images/wedit.png' border='0'></a><a href=\"{$_SERVER['PHP_SELF']}?edit=s2&teacher_course=$teacher_course&curr_sort=$curr_sort\"><img src='./images/pen.png' border='0'></a><a href=\"{$_SERVER['PHP_SELF']}?del=ds2&edit=s2&teacher_course=$teacher_course&curr_sort=$curr_sort\" onClick=\"return confirm('�T�w�R���o�����Z ?');\"><img src='./images/del.png' border='0'></a></td>
                <td>����</td>
            </tr>";

?>
   <form name="form2" method="post" action="upd_semester.php">
<?php

        $Cch=0;
        for($m=0;$m<count($stud_sn);$m++){
            $rs2=&$CONN->Execute("select score from $score_semester where student_sn='$stud_sn[$m]' and ss_id=$ss_id and test_sort='1' and test_kind='���ɦ��Z'");
            $score2=$rs2->fields[score];
            if($del=="ds2") $score2="-100";
            if($score2=="-100") {$score2=""; $Cch++;}
            $rs3=&$CONN->Execute("select stud_name,curr_class_num from stud_base where student_sn='$stud_sn[$m]'");
            $stud_name=$rs3->fields[stud_name];
            $site_num= intval(substr($rs3->fields[stud_name],-2));
            $ratio=100;
            $average_score[$m]=$score2;
            if($average_score[$m]!="") $average_score[$m]=number_format($average_score[$m],2);
            $bgcolor2="#FFFFFF";
            $red2="#000000";
            $red3="#000000";
            if(($score2!="")&&($score2<60)) {$bgcolor2="#ff0000"; $red2="#ff0000";}
            if(($average_score[$m]!="")&&($average_score[$m]<60)) {$red3="#ff0000";}
            if($edit=="s2"){
            $main.="
                <tr bgcolor=#ffffff>
                        <td>$site_num</td>
                        <td>$stud_name</td>
                        <td bgcolor=$bgcolor2><input type=\"text\" name=score2[$stud_sn[$m]] size=\"8\" maxlength=\"4\" value='".$score2."' class='border_no' style='width: 100%'></td>
                        <td><font color=$red3>".$average_score[$m]."</font></td>
                </tr>";
            }
            else{
            $main.="
                <tr bgcolor=#ffffff>
                        <td>$site_num</td>
                        <td>$stud_name</td>
                        <td><font color=$red2>$score2</font></td>
                        <td><font color=$red3>".$average_score[$m]."</font></td>
                </tr>";
            }
            echo "<input type=\"hidden\" name=score2[$stud_sn[$m]] value=".$score2.">";

        }
        echo $main;
        echo"</table>";

?>
        <input type="hidden" name="class_id" value=<?php echo $class_id ?>>
        <input type="hidden" name="stud_sn_array" value=<?php echo $stud_sn_array ?>>
        <input type="hidden" name="ss_id" value=<?php echo $ss_id ?>>
        <input type="hidden" name="test_sort" value=<?php echo $curr_sort ?>>
        <input type="hidden" name="test_form" value=<?php echo $curr_form ?>>
        <input type="hidden" name="teacher_course" value=<?php echo $teacher_course ?>>
        <input type="hidden" name="submit2_check" value="1">
        <input type="submit" name="Submit2" value="�x�s">
 <?php
    if($edit){

        $io_test_name="���ɦ��Z";
 ?>
        <input type="hidden" name="test_kind" value=<?php echo $io_test_name ?>>
        <input type="submit" name="file_in" value=�פJ<?php echo $io_test_name."���Z" ?>>
        <input type="submit" name="file_out" value=�ץX<?php echo $io_test_name."���Z" ?>>
 <?php
    }
 ?>
    </form>
    <?php
        $ehter_ok=999;
        if($submit2_check!="1"){
            $ehter_ok=0;
            for($q=0;$q<count($stud_sn);$q++){
                $rs2=&$CONN->Execute("select score from $score_semester where student_sn='$stud_sn[$q]' and ss_id=$ss_id and test_sort='1' and test_kind='���ɦ��Z'");
                $score2=$rs2->fields[score];
                if($score2=="-100"  && $test_ratio[0]!=0 ) $ehter_ok++;
                //echo $ehter_ok;
            }
            //echo $ehter_ok;
        }
        //echo $ehter_ok;

    ?>
    <form name="form3" method="post" action="semester_remit.php" onSubmit="return confirmSubmit()">
        <input type="hidden" name="class_id" value=<?php echo $class_id ?>>
        <?php
            for($m=0;$m<count($stud_sn);$m++){
                echo "
                    <input type='hidden' name=student_sn[$m] value=$stud_sn[$m]>
                    <input type='hidden' name=score[$m] value=$average_score[$m]>
                ";
            }

            if((($submit2_check)&&($Cch=='0'))||($ehter_ok=="0")){
        ?>
        <input type="hidden" name="ss_id" value=<?php echo $ss_id ?>>
        <input type="hidden" name="sended" value="ok">
        <input type="hidden" name="test_sort" value=<?php echo $curr_sort ?>>
        <input type="hidden" name="test_form" value=<?php echo $curr_form ?>>
        <input type="hidden" name="teacher_course" value=<?php echo $teacher_course ?>>
	<?php
	if ($is_send>0) 
		echo "<p>�������Z�w�צܱаȳB,�Y�����~,�гs���аȳB�B�z</p>";
	else
		echo " $is_send <input type=\"submit\" name=\"Submit3\" value=\"�ר�аȳB\">";
	?>	
   </form>
<?php
            }
            else{                
                if($sended!="ok"){
                    echo "<font color='#FF0000'>�z�ثe�ҿ�J�����Z������Ω|���x�s�I�]���z�L�k�ר�аȳB</font>";
                }
                else{
                    echo "<font color='#0000FF'>�z�w�g���\�W��</font>";
                }
            }


}


echo stripslashes($msg);
//�����D������ܰ�
echo "</td>";
echo "</tr>";
echo "</table>";

//�{���ɧ�
foot();
?>

<script language="JavaScript1.2">

<?php
//�O�_�ѥ��ɦ��Z�פJ
	if ($_GET[is_ok]==1)
		echo "alert ('���ɦ��Z�פJ���\ !! ');\n";
?>

<!-- Begin
function jumpMenu1(){
	    var str, classstr ;
        if (document.form1.teacher_course.options[document.form1.teacher_course.selectedIndex].value>0) {
	        location="<?php echo $_SERVER['PHP_SELF'] ?>?teacher_course=" + document.form1.teacher_course.options[document.form1.teacher_course.selectedIndex].value;
	    }
}

function jumpMenu9(){
	var str, classstr ;
    if ((document.form9.teacher_course.value!="") & (document.form9.curr_sort.options[document.form9.curr_sort.selectedIndex].value!="")) {
	location="<?php echo $_SERVER['PHP_SELF'] ?>?teacher_course=" + document.form9.teacher_course.value + "&curr_sort=" + document.form9.curr_sort.options[document.form9.curr_sort.selectedIndex].value;
    }
}

function jumpMenu_allowform(){
	var str, classstr ;
	location="<?PHP echo $_SERVER['$PHP_SELF'] ?>?need_allow=" + document.allow_form.need_allow.value +"&teacher_course="+document.allow_form.teacher_course.value + "&curr_sort=" + document.allow_form.curr_sort.value;
}

function confirmSubmit(){
	return confirm('�T�w�n�e��аȳB�H�@���e�X����z�N�L�k�b���A�p�ݧ��Ь��аȳB');

}

function openwindow(url_str){
window.open (url_str,"���Z�B�z","toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no,copyhistory=no,width=600,height=420");
}
//  End -->
</script>
