<?php

// $Id: index.php 5970 2010-07-04 16:36:03Z infodaes $

require "config.php";
include_once "function.php";
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
$condition=$_POST['condition'];
$sure_save=$_POST['sure_save'];
$sure=$_POST['sure'];
$year_name=$_GET['year_name'];
$select_subject=$_POST['select_subject'];
$select_subject_weight=$_POST['select_subject_weight'];
$yyear_name=$_POST['yyear_name'];
$Submit2=$_POST['Submit2'];
$boy_sort_name=$_POST['boy_sort_name'];
$girl_sort_name=$_POST['girl_sort_name'];
$group=$_POST['group'];
$Year_name=$_POST['Year_name'];
$Submit3=$_POST['Submit3'];
$togeter=$_POST['togeter'];
$Year_name=$_POST['Year_name'];
$periodical=$_POST['periodical'];

//�{�����Y
head("���s�s�Z");

//�]�w�D������ܰϪ��I���C��
echo "
<table border=0 cellspacing=1 cellpadding=2 width=100% bgcolor=#cccccc>
<tr>
<td bgcolor='#FFFFFF'>";
//�������e�иm�󦹳B
if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
//�˵��Z�ŬO�_�]�w�F
$rs_ck=$CONN->Execute("select class_sn from school_class where year='$sel_year' and semester='$sel_seme' and enable=1");
$ck=$rs_ck->fields['class_sn'];
if($ck=="") trigger_error("�藍�_�I�z�|���]�w�Z�šI",E_USER_ERROR);

//�إߤ@�ӼȦs���ǥ��`���Z��ƪ�
$creat_table_sql="CREATE TEMPORARY TABLE tmp_stud_compile(
            sn int(11) NOT NULL auto_increment,
            student_sn int,
            total_score float,
			c_class int,
            PRIMARY KEY  (sn)
            )";
$rs=$CONN->Execute($creat_table_sql);
$CONN->Execute("delete from tmp_stud_compile");

//��ܦ~�Ū��U�Կ��
$teacher_id=$_SESSION['session_log_id'];//���o�n�J�Ѯv��id
$col_name="year_name";
$id=$year_name;
$show_class_year=select_school_class($id,$col_name,$sel_year,$sel_seme);
$class_year_menu="
    <form name='form1' method='post' action='{$_SERVER['PHP_SELF']}'>
        <select name='$col_name' onChange='jumpMenu1()'>
            $show_class_year
        </select>
    </form>";
//echo $class_year_menu;

//��ܡy�C�X�ثe�s�Z���p�z���s
$class_condition="
    <form name='class_condition' method='post' action='{$_SERVER['PHP_SELF']}'>
        <input type='submit' name='condition' value='�˵��ثe�s�Z���p'>
<INPUT TYPE='button' Value='�M���s�Z���G' onclick=\"location.href='chc_del.php'\"></form>";
//echo $class_condition;
echo "<table><tr><td>$class_year_menu</td><td>$class_condition</td></tr></table>";
if($condition=="�˵��ثe�s�Z���p"){
    //$nagi�N�O�~��
    $nagi=nagi_arr($sel_year,$sel_seme);
    $compile_table="<table bgcolor='green' cellspacing=1 cellpadding=4 border=0><tr bgcolor='white' align='center'><td colspan=2 bgcolor=#96FF73>�ثe�U�~�Žs�Z���p</td></tr>";
    for($i=0;$i<count($nagi[1]);$i++){
        $nagi_val[$i]=$nagi[0][$i]*10000;
        $sql="select compile_sn from stud_compile where old_class-$nagi_val[$i]<10000 and old_class-$nagi_val[$i]>0";
		$rs=$CONN->Execute($sql);
        $compile_sn=$rs->fields['compile_sn'];
		//echo $nagi_val[$i]."---".$compile_sn."<br>";
        if($compile_sn!="") $CC="V";
        else $CC="<font color=red>X</font>";
        $nagi_name[$i]=$nagi[1][$i];
		$new_year[$i]=$nagi_val[$i]/10000+1;
        $compile_table.="<tr bgcolor='white' align='center'><td width='50%' bgcolor=#96FF73><a href='./save_compile.php?new_year_name=$new_year[$i]'>$nagi_name[$i]</a></td><td>$CC</td></tr>";
    }
    $save="
    <form name='save_table' method='post' action='{$_SERVER['PHP_SELF']}' onSubmit='return confirmSubmit()'>
        <input type='submit' name='sure_save' value='�g�J���y��ƪ�'>
        <input type='hidden' name='sure' value='save_ok'>
    </form>";
    $compile_table.="<tr bgcolor='white' align='center'><td colspan=2 bgcolor=#96FF73>$save</td></tr>";
    $compile_table.="</table>";
    echo $compile_table;
}

//�T�w�s�Z�üg�J������ƪ�
if($sure=="save_ok"){
    $sql="select student_sn,old_class,new_class,site_num from stud_compile";
    $rs=$CONN->Execute($sql) or die($sql);
    $i=0;
    while(!$rs->EOF){
        $student_sn[$i]=$rs->fields['student_sn'];
        $old_class[$i]=$rs->fields['old_class'];
        $new_class[$i]=$rs->fields['new_class'];
        $site_num_int[$i]=$rs->fields['site_num'];
        $site_num[$i]=sprintf("%02d",$site_num_int[$i]);
        $curr_class_num[$i]=$new_class[$i].$site_num[$i];
        //��sstud_base table
        $update_sql="UPDATE stud_base set curr_class_num='$curr_class_num[$i]' where student_sn=$student_sn[$i] ";
        $CONN->Execute($update_sql);
        //�s�Wstud_seme table
        $incr=intval(substr($new_class[$i],0,-2))-intval(substr($old_class[$i],0,-4));
        //echo substr($new_class[$i],0,-2)."-".substr($old_class[$i],0,-4)."=".$incr."<br>";
        if($incr) $seme_year_seme=sprintf("%03d%d",($sel_year+$incr),1);
        else $seme_year_seme=sprintf("%03d%d",$sel_year,$sel_seme);
        $rs_st_id=$CONN->Execute("select stud_id from stud_base where student_sn='$student_sn[$i]'");
        $stud_id=$rs_st_id->fields['stud_id'];
        $seme_class=$new_class[$i];
        $class_id=sprintf("%03d_%d_%02d_%02d",($sel_year+$incr),($sel_seme%2+1),substr($seme_class,0,-2),substr($seme_class,-2));
        $rs_c_name=$CONN->Execute("select c_name from school_class where class_id='$class_id' and enable=1");
        $seme_class_name=$rs_c_name->fields['c_name'];
        if($seme_class_name=="") trigger_error($sel_year+$incr."�Ǧ~�ײ�".($sel_seme%2+1)."�Ǵ����Z�ũ|���]�w�G",E_USER_ERROR);
        $new_site_num=$site_num_int[$i];
        $ck_rs=$CONN->Execute("select * from stud_seme where  seme_year_seme='$seme_year_seme' and  stud_id='$stud_id'");
        $o=$ck_rs->fields['seme_year_seme'];
        if($o) $sql="UPDATE stud_seme set seme_class='$seme_class', seme_num='$new_site_num' where  seme_year_seme='$seme_year_seme' and  stud_id='$stud_id'";
        else $sql="INSERT INTO stud_seme (stud_id,seme_year_seme,seme_class, seme_class_name, seme_num,student_sn) VALUES ('$stud_id','$seme_year_seme', '$seme_class', '$seme_class_name', '$new_site_num','$student_sn[$i]')";
        //echo $sql;
        $CONN->Execute($sql) or trigger_error($sql,256);
        $CONN->Execute("DELETE from stud_compile");
        $i++;
        $rs->MoveNext();
    }

}
/************************************************************************/
//��ܸӦ~�Ŭ�إH���ѽƿ�
if($year_name){
    $col_name="scope_subject";
    $id=$scope_subject;
    if($sel_seme==1){
        $show_ss_id=show_ss_id($year_name,$id,$col_name,$sel_year,$sel_seme);
        if(count($show_ss_id)==0) trigger_error("�Ӧ~�Ū��ҵ{�|���]�w�I",E_USER_ERROR);
        for($i=0;$i<count($show_ss_id);$i++){
            $subject_cname[$i]=ss_id_to_subject_name($show_ss_id[$i]);
            $sub_box.="<input type='checkbox' name='select_subject[$i]' value='$show_ss_id[$i]'>{$subject_cname[$i][0]}
                    �[�v<input type='text' name='select_subject_weight[$i]' size=2 maxlength=2 value=1>
                    <br>";
        }
    }
    else{
        $show_ss_id_1=show_ss_id($year_name,$id,$col_name,$sel_year,1);
        //echo $show_ss_id_1;
        $show_ss_id_2=show_ss_id($year_name,$id,$col_name,$sel_year,2);
        $show_ss_id=array_merge($show_ss_id_1, $show_ss_id_2);
        if(count($show_ss_id)==0) trigger_error("�Ӧ~�Ū��ҵ{�|���]�w�I",E_USER_ERROR);
        for($i=0;$i<count($show_ss_id);$i++){
            //�ˬd�Ӧ~�ŦU�Z�U�쪺���Z�O�_����F
            $show_ss_id_url[$i] = $SFS_PATH_HTML.get_store_path()."/show_ss.php?ss_id=$show_ss_id[$i]";
            //�C�X���
            $subject_cname[$i]=ss_id_to_subject_name($show_ss_id[$i]);
            $year_seme[$i]=ss_id_to_year_seme($show_ss_id[$i]);
            $u_d[$i]=$year_seme[$i][1];
            if($u_d[$i]==1) $u_d[$i]="�W�Ǵ�";
            if($u_d[$i]==2) $u_d[$i]="�U�Ǵ�";
            $name[$i]=$subject_cname[$i][0];
            $rate[$i]=$subject_cname[$i][1];
            $sub_box.="<input type='checkbox' name='select_subject[$i]' value='$show_ss_id[$i]'><a onclick=\"openwindow('$show_ss_id_url[$i]','$name[$i]')\">$name[$i]</a>($u_d[$i])
                    �[�v<input type='text' name='select_subject_weight[$i]' size=2 maxlength=2 value=$rate[$i]>
                    <br>";
        }

    }
	$SYS=sprintf("%03d%d",$sel_year,$sel_seme);
	//$rs_CYN=$CONN->Execute("select  seme_class,seme_class_name from stud_seme where seme_class like '$year_name%' and seme_year_seme='$SYS' order by seme_class");
	//echo "select  seme_class,seme_class_name from stud_seme where seme_class like '$year_name%' and seme_year_seme='$SYS'";
	$sql="select  c_name,c_sort
	from school_class
	where c_year ='$year_name' and year='$sel_year' and semester='$sel_seme' and enable=1
	order by c_sort";
	$rs_CYN=$CONN->Execute($sql) or trigger_error($sql,256);
	$select_compile_class.="����ܭn�ѥ[�s�Z���Z��<hr>";
	$a=0;
	while(!$rs_CYN->EOF){
		$c_name[$a]=$rs_CYN->fields['c_name'];
		//echo $seme_class[$a]."<br>";
		$c_sort[$a]=$rs_CYN->fields['c_sort'];
		//echo $seme_class_name[$a]."<br>";
		$seme_class[$a]=sprintf("%d%02d",$year_name,$c_sort[$a]);
		$rs_CYN->MoveNext();
		$a++;
	}
	$seme_class=deldup($seme_class);
	$seme_class_name=deldup($seme_class_name);
	//echo count($seme_class);
	for($a=0;$a<count($c_sort);$a++){
		$select_compile_class.="<input type='checkbox' name='togeter[$a]'  value='$seme_class[$a]' checked>".$year_name."�~".$c_name[$a]."�Z<br>";
	}
	$class_year_name_menu="
    <form name='form2' method='post' action='{$_SERVER['PHP_SELF']}'>
        <table><tr><td><hr>����ܭn�p�⪺�ǲ߬��<hr>$sub_box</td><td valign='top'><hr>$select_compile_class<hr></td></tr>
        <input type='hidden' name='yyear_name' value='$year_name'>
        <tr><td colspan='2'>
		<hr>
		<input type='checkbox' name='periodical' value='�w�����q'>�u�p��w�����q�����Z�@�@�@
		<input type='submit' name='Submit2' value='�jS�νs�Z'>
		<input type='submit' name='Submit2' value='�pS�νs�Z'>
		</td></tr></table>
    </form>";

echo $class_year_name_menu;
}

if($yyear_name && $Submit2=='�jS�νs�Z') big_s();

if($yyear_name && $Submit2=='�pS�νs�Z') small_s();

//�}�l�s�Z�o�I
if($Year_name  && $Submit3=="�}�l�jS�s�Z"){
    //echo $sort_name[1];
    //$many_student=count($sort_name);
    //$many_group=implode(",",$group);
    //$group=explode(",",$many_group);
    for($i=0;$i<count($group);$i++){
        $many_class=$many_class+$group[$i];
    }
	reset($boy_sort_name);
    $r=0;
    while(list($key , $val)=each($boy_sort_name)){
        //echo $key."---->".$val."<br>";
        if($val=="") continue;
        $n_boy_sort[$r]=$key+1;
        $n_boy_sort_name[$r]=$val;
        $r++;
    }
    reset($girl_sort_name);
    $r=0;
    while(list($key , $val)=each($girl_sort_name)){
        //echo $key."---->".$val."<br>";
        if($val=="") continue;
        $n_girl_sort[$r]=$key+1;
        $n_girl_sort_name[$r]=$val;
        $r++;
    }
	
//�ϰ�s�Z�}�l
	$boy_A=$n_boy_sort_name;
    $girl_A=$n_girl_sort_name;
    //echo "�}�l�B�z�k��-----------------";
    $every_class_boys=ceil(count($boy_A)/$many_class);//�C�Z�k�ͤH��
    //echo "�H��".count($boy_A)."<br>";
    //echo "�Z�ż�".$many_class."<br>";
    //echo "�C�Z�H��".$every_class_boys."<br>";
    for($i=0;$i<count($group);$i++){
        $a=$i-1;
        if($a<0) $end_stud[$a]="-1";
        $start_stud[$i]=$end_stud[$a]+1; //�_�l��
        $end_stud[$i]=$start_stud[$i]+($every_class_boys*$group[$i])-1; //������
        if($end_stud[$i]>(count($boy_A)-1)) $end_stud[$i]=(count($boy_A)-1);
        for($m=$start_stud[$i];$m<=$end_stud[$i];$m++){
            $b=$i-1;
            if($b<0) $end_class[$b]="-1";
            $start_class[$i]=$end_class[$b]+1;
            $end_class[$i]=$start_class[$i]+$group[$i]-1;
            //echo ">>>>>>>��$boy_A[$m]�s�Z>>>>>>>>";
            for($n=$start_class[$i];$n<=$end_class[$i];$n++){
                //echo ($m%(($end_class[$i]-$start_class[$i]+1)*2))."=".$n."��".(($end_class[$i]-$start_class[$i]+1)*2-$n-1)."<br>";
                if(($m%(($end_class[$i]-$start_class[$i]+1)*2)==($n-$start_class[$i])) || ($m%(($end_class[$i]-$start_class[$i]+1)*2)==(($end_class[$i]-$start_class[$i]+1)*2-($n-$start_class[$i])-1))){
                    $class[$n][]=$boy_A[$m]."_".$n_boy_sort[$m];
                    //echo $n."�Z==>".$boy_A[$m]."<br>";
                }
            }
        }
        //echo "---------���Z�s�F�I--------<br>";
    }

    //echo "�}�l�B�z�k��-----------------";
    $every_class_girls=ceil(count($girl_A)/$many_class);//�C�Z�k�ͤH��
    //echo "�H��".count($girl_A)."<br>";
    //echo "�Z�ż�".$many_class."<br>";
    //echo "�C�Z�H��".$every_class_girls."<br>";
    for($i=0;$i<count($group);$i++){
        $a=$i-1;
        if($a<0) $end_stud[$a]="-1";
        $start_stud[$i]=$end_stud[$a]+1; //�_�l��
        $end_stud[$i]=$start_stud[$i]+($every_class_girls*$group[$i])-1; //������
        if($end_stud[$i]>(count($girl_A)-1)) $end_stud[$i]=(count($girl_A)-1);
        for($m=$start_stud[$i];$m<=$end_stud[$i];$m++){
            $b=$i-1;
            if($b<0) $end_class[$b]="-1";
            $start_class[$i]=$end_class[$b]+1;
            $end_class[$i]=$start_class[$i]+$group[$i]-1;
            //echo ">>>>>>>��$girl_A[$m]�s�Z>>>>>>>>";
            for($n=$end_class[$i];$n>=$start_class[$i];$n--){
                //echo ($m%(($end_class[$i]-$start_class[$i]+1)*2))."=".$n."��".(($end_class[$i]-$start_class[$i]+1)*2-$n-1)."<br>";
                if(($m%(($end_class[$i]-$start_class[$i]+1)*2)==($end_class[$i]-$n)) || ($m%(($end_class[$i]-$start_class[$i]+1)*2)==($end_class[$i]-$start_class[$i]-$start_class[$i]+$n+1))){
                    $class[$n][]=$girl_A[$m]."_".$n_girl_sort[$m];
                    //echo $n."�Z==>".$girl_A[$m]."<br>";
                }
            }
        }
        //echo "---------���Z�s�F�I--------<br>";
    }


//�ϰ�s�Z����

//S�νs�Z�Ҧ�
/*
    for($i=0;$i<count($n_boy_sort_name);$i++){
        //echo "$n_boy_sort_name[$i] ";
        for($j=0;$j<$many_class;$j++){
            if(($i%($many_class*2)==$j) || ($i%($many_class*2)==($many_class*2-$j-1))) $class[$j][]=$n_boy_sort_name[$i]."_".$n_boy_sort[$i];
        }
    }
    for($i=0;$i<count($n_girl_sort_name);$i++){
        //echo "$n_girl_sort_name[$i] ";
        for($j=($many_class-1);$j>=0;$j--){
            if(($i%($many_class*2)==($many_class-$j-1)) || ($i%($many_class*2)==($many_class+$j))) $class[$j][]=$n_girl_sort_name[$i]."_".$n_girl_sort[$i];
        }
    }
*/
    //��ܥX�s�Z�᪺���G
    echo "<table cellspacing=2 cellpadding=4 border=0 bgcolor=#27a208 width=100%>";
    for($k=0;$k<$many_class;$k++){
        $BB=school_class_info();
        $kk=$k+1;
        $new_k=$BB[$Year_name][$kk];
        echo "<tr><td bgcolor=#96FF73 width=20%><table width=100%><tr><td></td><td></td><td></td><td></td><td></td></tr><tr align='left'><td width=20%>".($Year_name)."�~".$new_k."�Z</td>";
        for($m=0;$m<count($class[$k]);$m++){
            $values=$class[$k][$m];
            $VA = explode ("_", $values);
            $new_class.="<input type='hidden' name='class[$k][$m]' value='$values'>";
            //echo $class[$k][$m];
            $stud_name[$k]=student_sn_to_stud_name($VA[0]);
            $stud_class[$k]=student_sn_to_classinfo($VA[0]);
            if($stud_class[$k][3]==1) $color="blue";
            else $color="magenta";

            $BB_name=$BB[$stud_class[$k][0]][$stud_class[$k][1]];
            echo "<td bgcolor=#ffffff width=20%>".$stud_class[$k][0]."�~".$BB_name."�Z ".sprintf('%02d',$stud_class[$k][2])."�� <font color=$color>".$stud_name[$k]."</font>(".$VA[1].") </td>";
            if($m%4==3) echo "</tr><tr><td width=20%></td>";
        }
        $mm=$m+1;
        echo "</tr></table></td></tr>";
    }
    echo "</table>";
    //�Ǧ^$class��N�s�Z���G�g�J�s�Z����ƪ�
    //echo $class[0][4];
    echo "
        <form name='form4' method='post' action='./save_compile.php'>
            <input type='hidden' name='year_name' value='$Year_name'>
            <input type='hidden' name='many_class' value='$many_class'>
			<input type='hidden' name='bs' value='big'>
            $new_class
            <input type='submit' name='Submit4' value='�x�s�s�Z���G'>
        </form>";
}

//�}�l�s�Z�o�I
if($Year_name  && $Submit3=="�}�l�pS�s�Z") small_s2();






//�����D������ܰ�
echo "</td>";
echo "</tr>";
echo "</table>";

//�{���ɧ�
foot();


?>


<script language="JavaScript1.2">
<!-- Begin
function openwindow(show_ss_id,name){
    window.open(show_ss_id,name,"toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no,copyhistory=no,width=300,height=520,screenX=20,screenY=20");
}

function jumpMenu1(){
	var str, classstr ;
 if (document.form1.year_name.options[document.form1.year_name.selectedIndex].value!="") {
	location="<?PHP echo $_SERVER['PHP_SELF'] ?>?year_name=" + document.form1.year_name.options[document.form1.year_name.selectedIndex].value;
	}
}

function jumpMenu2(){
	var str, classstr ;
 if ((document.form2.year_name.value!="") & (document.form2.me.options[document.form2.me.selectedIndex].value!="")) {
	location="<?PHP echo $_SERVER['PHP_SELF'] ?>?year_name=" + document.form2.year_name.value + "&me=" + document.form2.me.options[document.form2.me.selectedIndex].value;
	}
}

function jumpMenu3(){
	var str, classstr ;
 if ((document.form3.year_name.value!="") & (document.form3.me.value!="") & (document.form3.stage.options[document.form3.stage.selectedIndex].value!="")) {
	location="<?PHP echo $_SERVER['PHP_SELF'] ?>?year_name=" + document.form3.year_name.value + "&me=" +document.form3.me.value + "&stage=" + document.form3.stage.options[document.form3.stage.selectedIndex].value;
	}
}

function confirmSubmit(){
	return confirm('�z�T�w�n�N�s�Z�����G�g�J���y��ƪ�H\n��ĳ�z���ˬd�@�U�U�~�ŬO�_�w�g�����n�s�Z�ʧ@\n�óƥ�stud_base�Mstud_seme��ƪ�I');

}
//  End -->
</script>

