<?php
// $Id: fitpass.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";
sfs_check();
$session_tea_sn =  $_SESSION['session_tea_sn'] ;


// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

if ( ($_SESSION['session_who']=="�Юv") or  ($_SESSION['session_log_id']==$stud_id)){
}else{
	echo "���Юv�Υ��H�d�\�@��";
	exit ;
}
//���o�ǥ͸�ư}�C
$sql = "select a.student_sn,a.stud_id,a.stud_birthday,a.stud_name,a.stud_sex,b.seme_class,b.seme_num,c.*  from stud_base a,stud_seme b ,fitness_data c where a.student_sn=b.student_sn  and c.student_sn=a.student_sn and c.c_curr_seme = b.seme_year_seme  and  c.student_sn='$student_sn' order by c.c_curr_seme ";
	$result=$CONN->Execute($sql) or trigger_error("SQL�y�k���~ ", E_USER_ERROR);
$i=0;
while ($row = $result->FetchRow()) {
	if($i==0){
		$name=$row["stud_name"]; 
		$sex=$row["stud_sex"];
		if($sex==1) $sex="�k";
		elseif($sex==2) $sex="�k";
		$bir=$row["stud_birthday"];
		$birm=(substr($bir,0,4)-1911)."-".substr($bir,5,2)."-".substr($bir,8,2);
		echo   "<font size=4>".$SCHOOL_BASE[sch_cname]." �ǥ���A���@�ӡ@�@�@�@�@�@�@�@<a href='javascript:close();'>���}</a>�@<a href='javascript:print();'>�C�L</a><br>";
		echo   "�m�W�G$name �@�ʧO�G$sex �@�ͤ�G$birm �@�Ǹ��G$stud_id</font>";
		echo "<table border='1' cellpadding='1' cellspacing='0' style='border-collapse: collapse' bordercolor='#000000'>
		<tr align=center><td width='5%'>����~��</td>
		<td width='3%'>�~��</td>	
		<td width='11%'>�~�Z</td>	
		<td width='3%'> �y��</td>	
		<td width='8%'>$test[0] [�H]</td>
		<td width='8%'>$test[1] [�H]</td>
		<td width='11%'>BMI����<br>kg/m2[�H]</td>
		<td width='10%'>$test[2] [�H]</td>
		<td width='10%'>$test[3] [�H]</td>
		<td width='10%'>$test[4] [�H]</td>
		<td width='10%'>$test[5] [�H]</td>
		<td width='11%'>����</td></tr>";
	}
	$i++;

	$num=$row["seme_num"];
	$class_num=$row["seme_class"];
	$tall=$row["tall"]; 
	$weigh=$row["weigh"]; 
	$test1=$row["test1"]; 
	$test2=$row["test2"]; 
	$test3=$row["test3"]; 
	$test4=$row["test4"]; 
	$prec_t=$row["prec_t"]; 
	$prec_w=$row["prec_w"]; 
	$prec1=$row["prec1"]; 
	$prec2=$row["prec2"]; 
	$prec3=$row["prec3"]; 
	$prec4=$row["prec4"]; 

	$age=$row["age"];
	$test_y=$row["test_y"];
	$test_m=$row["test_m"];
	$bmt=$row["bmt"];
	$prec_b=$row["prec_b"];
	$textb=text(6,$prec_b,$bmt);
	$text1=text(1,$prec1,$test1);
	$text2=text(1,$prec2,$test2);
	$text3=text(1,$prec3,$test3);
	$text4=text(1,$prec4,$test4);
	$cita=cita_c($prec1,$prec2,$prec3,$prec4);
	$c_curr_seme=$row["c_curr_seme"];
	$sel_year=substr($c_curr_seme,1,2);
	$sel_seme=substr($c_curr_seme,3,1);
	$class_name=class_id2big5($class_num,$sel_year,$sel_seme);


	echo "<tr bgcolor='#ffffff' align=center>
	<td>$test_y-$test_m</td>
	<td>$age</td>
	<td >$class_name</td>
	<td>$num</td>
	<td >$tall [$prec_t]</td>
	<td >$weigh [$prec_w]</td>
	<td > $bmt [$prec_b]<br>$textb</td>
	<td > $test1 [$prec1]<br>$text1 </td>
	<td > $test2 [$prec2]<br>$text2</td>
	<td > $test3 [$prec3]<br>$text3</td>
	<td > $test4 [$prec4]<br>$text4</td>
	<td >$cita</td>
	</tr>";
}
echo "</table>";
echo "[�H]�����ʤ����šA�]�N�O���b�P�ʧO�B�~�֪��`�Ҥ��A�A�W�L�ʤ����h�֪��H�A�p[50]�A�Y��ܧA����{�ӹL50�H���P�֤p�B�͡C<br>";
echo "�аѾ\�G<a target='_blank' href='http://www.fitness.org.tw/'>�Ш|����A�����(www.fitness.org.tw)</a>";
//�u�}����
function cita_c($t1,$t2,$t3,$t4){
$text="";
if($t1>=85 && $t2>=85 && $t3>=85 && $t4>=85 ){
	$text="<font color='#FF0000'><span style='background-color: #FFFF00'>�������</span></font>";
}elseif($t1>=75 && $t2>=75 && $t3>=75 && $t4>=75 ){
	$text="<font color='#FF0000'><span style='background-color: #C0C0C0'>�Ƚ����</span></font>";
}elseif($t1>=50 && $t2>=50 && $t3>=50 && $t4>=50 ){
	$text="<font color='#FF0000'><span style='background-color: #FFCC00'>�ɽ����</span></font>";
}
return $text;

}

// ����
function text($grade,$prec,$s){
$text="";
if($s>0){
	if($grade==1){
		$text="����";
		if($prec>=75) $text="<font color=purple>�u�}</font>";
		if($prec<25) $text="<font color=red>�Х[�j</font>";
	}
	if($grade==6){
		$text="�A��";
		if($prec>=80) $text="<font color=red>�L��</font>";
		if($prec<20) $text="<font color=red>�L��</font>";
	}	
}
return $text;
}

?>
