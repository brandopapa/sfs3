<?php

// $Id: report1.php qfon $

/* 取得設定檔 */

include "config.php";

// 認證檢查
sfs_check();

// 健保卡查核
switch ($ha_checkary){
        case 2:
                ha_check();
                break;
        case 1:
                if (!check_home_ip()){
                        ha_check();
                }
                break;
}



//印出檔頭
head("缺曠課查詢");

//只限當學期
$seme_year_seme=sprintf("%03d",curr_year()).curr_seme();

$stud_id=$_SESSION['session_log_id'];


//取得登入學生的學號和流水號
$query="select * from stud_seme where seme_year_seme='$seme_year_seme' and stud_id='".$stud_id."'";
$res=$CONN->Execute($query);
$student_sn=$res->fields['student_sn'];
if ($student_sn) {
	$query="select * from stud_base where student_sn='$student_sn'";
	$res=$CONN->Execute($query);
	if ($res->fields['stud_study_cond']!="0") {
		$student_sn="";
	} else {
		$stud_study_year=$res->fields['stud_study_year'];
	}
}



$main=&mainForm();

//秀出網頁
head("缺曠課查詢");

if($stud_view_self_absent)echo $main;
foot();

//主要輸入畫面
function &mainForm(){
	global $CONN,$stud_id,$student_sn,$stud_study_year;

	$sql = "select year,semester,class_id,date,absent_kind,section from stud_absent where stud_id='$stud_id' and year>='$stud_study_year'";
	$rs=$CONN->Execute($sql) or trigger_error("SQL語法錯誤： $sql", E_USER_ERROR);

		
    $main0.="<center>";
	$main0.="<table width=80% cellspacing='1' cellpadding='3' bgcolor='#C6D7F2'>";
	$main0.="<tr><td bgcolor='#C6D7F2'>學年度學期</td><td bgcolor='#C6D7F2'>日期</td><td bgcolor='#C6D7F2'>缺曠課種類</td><td bgcolor='#C6D7F2'>年級班級</td></tr>";

	while (!$rs->EOF) {
		$absent_kind=$rs->fields['absent_kind'];
		$class_id = $rs->fields['class_id'];
		$date = $rs->fields['date'];
		$section = $rs->fields['section'];
		
		
		if ($section=="allday")$sectionx="1日";
		else if ($section=="uf")$sectionx="升旗";
		else if ($section=="df")$sectionx="降旗";
		else $sectionx="第".$section."節";
		$cx=explode("_",$class_id);
		
		if ($cx[2]=="07" || $cx[2]=="01")$cx[2]="1";
		if ($cx[2]=="08" || $cx[2]=="02")$cx[2]="2";
		if ($cx[2]=="09" || $cx[2]=="03")$cx[2]="3";
		if ($cx[2]=="04")$cx[2]="4";
		if ($cx[2]=="05")$cx[2]="5";
		if ($cx[2]=="06")$cx[2]="6";
		
		$cx[3]=get_class_name($class_id);
		$colorz="white";
		if ($absent_kind=="事假")$colorz="#FEFED7";
		if ($absent_kind=="病假")$colorz="#FEFEC4";
		if ($absent_kind=="曠課")$colorz="#FEFEB1";
		if ($absent_kind=="其他")$colorz="#FEFE8B";
		$main0.="<tr><td bgcolor='$colorz'>$cx[0]學年度第 $cx[1] 學期</td><td bgcolor='$colorz'>$date</td><td bgcolor='$colorz'>$absent_kind $sectionx</td><td bgcolor='$colorz'>$cx[2]年$cx[3]班</td></tr>";
		$rs->MoveNext();
		
		
	}
     $main0.="</table>";
	return $main0;
}

//取得班級名稱
function get_class_name($class_id){
	global $CONN;

	$sql_select = "select c_name from school_class where class_id='$class_id' and enable='1'";
	$recordSet=$CONN->Execute($sql_select)  or trigger_error($sql_select, E_USER_ERROR);
    while (!$recordSet->EOF) {
		$c_name=$recordSet->fields['c_name'];
		$recordSet->MoveNext();
	}
	return $c_name;
}



?>
