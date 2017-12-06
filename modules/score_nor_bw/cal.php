<?php

// $Id: cal.php 6998 2012-11-13 02:09:59Z infodaes $

// 取得設定檔
include "config.php";
$year_seme=$_POST['year_seme'];

sfs_check();

//程式檔頭
head("統計平常成績");
print_menu($menu_p);

echo "	<script language=\"JavaScript\">
	var OK=false;
	function check() {
		if (OK) {
			return confirm('確定進行統計');
		}
	}
	</script>";

//若有選擇學年學期，進行分割取得學年及學期
if(!empty($year_seme)){
	$ys=explode("_",$year_seme);
	$sel_year=$ys[0];
	$sel_seme=$ys[1];
} else {
	$sel_year = curr_year(); //目前學年
	$sel_seme = curr_seme(); //目前學期
	$year_seme=$sel_year."_".$sel_seme;
}

if ($_POST['absent']){
	cal_abs($sel_year,$sel_seme);
	$msg="<tr><td><br>出缺席記錄統計完成 ！</td></tr>";
}
if ($_POST['reward']){
	cal_rew($sel_year,$sel_seme);
	$msg="<tr><td><br>獎懲記錄統計完成 ！</td></tr>";
}
if ($_POST['nor']){
	cal_nor($sel_year,$sel_seme);
	$msg="<tr><td><br>綜合成績統計完成 ！</td></tr>";
}

//學期選單
$col_name="year_seme";
$id=$year_seme;    
$show_year_seme=select_year_seme($id,$col_name);
$year_seme_menu="<select name='$col_name' OnChange='this.form.submit();'>$show_year_seme</select>";

$query="select count(stud_id) from stud_absent where year='$sel_year' and semester='$sel_seme'";
$res=$CONN->Execute($query);
$abs_nums=$res->fields[0];

if ($IS_JHORES==6) {
	$query="select count(stud_id) from reward where reward_year_seme='".$sel_year.$sel_seme."'";
	$res=$CONN->Execute($query);
	$rew_nums=$res->fields[0];
	$rew_msg="，獎懲記錄共有 <font color='#ff0000'>$rew_nums</font> 筆";
}

if ($IS_JHORES==6) {
	$ops="<input type='submit' name='absent' value='統計出缺席'> <input type='submit' name='reward' value='統計獎懲'>";
	//if ($ncount) $ops.=" <input type='submit' name='nor' value='統計平常成績' OnClick=\"OK=true\">";
} else
	$ops="<input type='submit' name='absent' value='統計出缺席'>";
echo "	<table border=0 cellspacing=1 cellpadding=2 width=100% bgcolor=#cccccc><tr><td bgcolor='#FFFFFF'>";
$menu="	<table cellspacing=0 cellpadding=0>
	<form name=\"myform\" method=\"post\" action=\"$_SERVER[PHP_SELF]\" OnSubmit=\"return check();\">
	<tr><td>請選擇您要執行的工作：$year_seme_menu $ops</td></tr>
	$msg
	<tr><td>本學期出缺席記錄共有 <font color='#ff0000'>$abs_nums</font> 筆".$rew_msg."<br><font color='#ff0000'>（若無記錄的話，請勿統計綜合成績，以避免之前匯入資料遺失。）</font></td></tr>
	</form>
	</table>";
echo $menu."</tr></table>";
if ($IS_JHORES==6) {
	$help_text="建議您依序進行「統計出缺席」→「統計獎懲」→「統計綜合成績」";
	echo help($help_text);
}

foot();

function cal_abs($sel_year,$sel_seme){
	global $CONN,$IS_JHORES;
	include "../../include/sfs_case_dataarray.php";

	$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
	$a_array=stud_abs_kind();
	$abs_array=array("事假"=>"1","病假"=>"2","曠課"=>"3","集會"=>"4","公假"=>"5","其他"=>"6","喪假"=>"6");
	$query="update stud_seme_abs set abs_days='',abs_days_5day_7section='' where seme_year_seme='$seme_year_seme'";
	$CONN->Execute($query) or trigger_error("SQL語法錯誤：$query", E_USER_ERROR);
	$sql="select class_year,sections from score_setup where year='$sel_year' and semester='$sel_seme'";
	$rs=$CONN->Execute($sql) or trigger_error("SQL語法錯誤：$sql", E_USER_ERROR);
	if ($rs) {
		while (!$rs->EOF) {
			$all_sections[$rs->fields['class_year']]=$rs->fields['sections'];
			$rs->MoveNext();
		}
	}
	if ($IS_JHORES==6)
		$sql="select *,DATE_FORMAT(date,'%w') as date_w from stud_absent where year='$sel_year' and semester='$sel_seme' order by stud_id,absent_kind";
	else
		$sql="select distinct date,stud_id,absent_kind,DATE_FORMAT(date,'%w') as date_w from stud_absent where year='$sel_year' and semester='$sel_seme' order by stud_id,absent_kind";
	$rs=$CONN->Execute($sql) or trigger_error("SQL語法錯誤：$sql", E_USER_ERROR);
	if ($rs) {
		while (!$rs->EOF) {
			$stud_id=$rs->fields['stud_id'];
			$absent_kind=$rs->fields['absent_kind'];
			$date_w=$rs->fields['date_w'];
			$fg = ($date_w == "0" || $date_w == "6");//週日 或 週六
			if ($IS_JHORES==6) {
				$section=$rs->fields['section'];
				$class=explode("_",$rs->fields['class_id']);
			}
			if ($oid!=$stud_id && $oid) {
				for ($i=1;$i<=6;$i++) {
					if ($ab[$i]=="") {
						$ab[$i]="0";
						$ab_days_5day_7section[$i]="0";
					}
					$query="select * from stud_seme_abs where seme_year_seme='$seme_year_seme' and stud_id='$oid' and abs_kind='$i'";
					$rs_c=$CONN->Execute($query) or trigger_error("SQL語法錯誤：$query", E_USER_ERROR);
					if ($rs_c->recordcount()>0) {
						$query="update stud_seme_abs set abs_days='$ab[$i]',abs_days_5day_7section='$ab_days_5day_7section[$i]' where seme_year_seme='$seme_year_seme' and stud_id='$oid' and abs_kind='$i'";
						$CONN->Execute($query) or trigger_error("SQL語法錯誤：$query", E_USER_ERROR);
					} else {
						$query="insert into stud_seme_abs (seme_year_seme,stud_id,abs_kind,abs_days,abs_days_5day_7section) values ('$seme_year_seme','$oid','$i','$ab[$i]','$ab_days_5day_7section[$i]')";
						$CONN->Execute($query) or trigger_error("SQL語法錯誤：$query", E_USER_ERROR);
					}
				}
				$ab="";
				$ab_days_5day_7section="";
			}
			if ($IS_JHORES==6) {
				if ($section=="allday") {
					$ab[$abs_array[$absent_kind]]+=$all_sections[intval($class[2])];
					if (!$fg) {$ab_days_5day_7section[$abs_array[$absent_kind]]+=7;}
					if ($absent_kind=="曠課"){ 
						$ab[4]+=2;
						if (!$fg) {$ab_days_5day_7section[4]+=2;}
					}
				} elseif ($section=="uf" || $section=="df") {
					if ($absent_kind=="曠課") {
						$ab[4]+=1;
						if (!$fg) {$ab_days_5day_7section[4]+=1;}
					}
				} elseif (in_array($absent_kind,$a_array)) {
					$ab[$abs_array[$absent_kind]]+=1;
					if (!$fg) {$ab_days_5day_7section[$abs_array[$absent_kind]]+=1;}
				} else {
					$ab[6]+=1;
					if (!$fg) {$ab_days_5day_7section[6]+=1;}
				}
			} else {
				$ab[$abs_array[$absent_kind]]++;
				if (!$fg) {$ab_days_5day_7section[$abs_array[$absent_kind]]++;}
			}
			$oid=$stud_id;
			$rs->MoveNext();
		}
		for ($i=1;$i<=6;$i++) {
			$query="select * from stud_seme_abs where seme_year_seme='$seme_year_seme' and stud_id='$oid' and abs_kind='$i'";
			$rs_c=$CONN->Execute($query) or trigger_error("SQL語法錯誤：$query", E_USER_ERROR);
			if ($rs_c) {
				//$query="update stud_seme_abs set abs_days='$ab[$i]' where seme_year_seme='$seme_year_seme' and stud_id='$oid' and abs_kind='$i'";
				$query="update stud_seme_abs set abs_days='$ab[$i]',abs_days_5day_7section='$ab_days_5day_7section[$i]' where seme_year_seme='$seme_year_seme' and stud_id='$oid' and abs_kind='$i'";
				$CONN->Execute($query) or trigger_error("SQL語法錯誤：$query", E_USER_ERROR);
			} else {
				$query="insert into stud_seme_abs (seme_year_seme,stud_id,abs_kind,abs_days,abs_days_5day_7section) values ('$seme_year_seme','$oid','$i','$ab[$i]','$ab_days_5day_7section[$i]')";
				$CONN->Execute($query) or trigger_error("SQL語法錯誤：$query", E_USER_ERROR);
			}
		}
	}
}

function cal_rew($sel_year,$sel_seme) {
	global $CONN;
	
	$reward_year_seme=$sel_year.$sel_seme;
	$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
	$CONN->Execute("update stud_seme_rew set sr_num='',sr_num_5day='' where seme_year_seme='$seme_year_seme'");
	$sql="select *,DATE_FORMAT(reward_date,'%w') as date_w from reward where reward_year_seme='$reward_year_seme' and stud_id <> '' and (reward_cancel_date='0000-00-00' or reward_cancel_date is null) order by stud_id,reward_kind";
	$rs=$CONN->Execute($sql) or trigger_error("SQL語法錯誤：$sql", E_USER_ERROR);
	if ($rs) {
		if ($rs->recordcount()>0) {
			while (!$rs->EOF) {
				$stud_id=$rs->fields['stud_id'];
				$reward_kind=intval($rs->fields['reward_kind']);
				$date_w=$rs->fields['date_w'];
				$fg = ($date_w == '0' || $date_w == '6');
				$ow=($reward_kind>0)?0:3;
				$ork=abs($reward_kind);
				if ($oid!=$stud_id && $oid!="") {
					for ($i=1;$i<=6;$i++) {
						$val=$stud_rew[$oid][$i];						
						$val_5day=$stud_rew_5day[$oid][$i];
						$query="select * from stud_seme_rew where seme_year_seme='$seme_year_seme' and stud_id='$oid' and sr_kind_id='$i'";
						$rs_c=$CONN->Execute($query) or trigger_error("SQL語法錯誤：$query", E_USER_ERROR);
						if ($rs_c->recordcount() > 0) {
							$query="update stud_seme_rew set sr_num='$val',sr_num_5day='$val_5day' where seme_year_seme='$seme_year_seme' and stud_id='$oid' and sr_kind_id='$i'";
							$CONN->Execute($query) or trigger_error("SQL語法錯誤：$query", E_USER_ERROR);
						} else {
							$query="insert into stud_seme_rew (seme_year_seme,stud_id,sr_kind_id,sr_num,sr_num_5day) values ('$seme_year_seme','$oid','$i','$val','$val_5day')";
							$CONN->Execute($query) or trigger_error("SQL語法錯誤：$query", E_USER_ERROR);
						}
					}
				}
				if($rs->fields[reward_sub] ==1){
					switch ($ork) {
						case 1:
							$stud_rew[$stud_id][3+$ow]++;							
							break;
						case 2:
							$stud_rew[$stud_id][3+$ow]+=2;
							break;
						case 3:
							$stud_rew[$stud_id][2+$ow]++;
							break;
						case 4:
							$stud_rew[$stud_id][2+$ow]+=2;
							break;
						case 5:
							$stud_rew[$stud_id][1+$ow]++;
							break;
						case 6:
							$stud_rew[$stud_id][1+$ow]+=2;
							break;
						case 7:
							$stud_rew[$stud_id][1+$ow]+=3;
							break;
					}
					if(!$fg){
						switch ($ork) {
							case 1:
								$stud_rew_5day[$stud_id][3+$ow]++;							
								break;
							case 2:
								$stud_rew_5day[$stud_id][3+$ow]+=2;
								break;
							case 3:
								$stud_rew_5day[$stud_id][2+$ow]++;
								break;
							case 4:
								$stud_rew_5day[$stud_id][2+$ow]+=2;
								break;
							case 5:
								$stud_rew_5day[$stud_id][1+$ow]++;
								break;
							case 6:
								$stud_rew_5day[$stud_id][1+$ow]+=2;
								break;
							case 7:
								$stud_rew_5day[$stud_id][1+$ow]+=3;
								break;
						}						
					}
				}
				$oid=$stud_id;
				$rs->MoveNext();
			}
			//取得student_sn
			$query="select * from stud_seme where seme_year_seme='$seme_year_seme' and stud_id='$oid'";
			$rs_c=$CONN->Execute($query) or trigger_error("SQL語法錯誤：$query", E_USER_ERROR);
			$student_sn=$rs_c->fields['student_sn'];

			for ($i=1;$i<=6;$i++) {
				$val=$stud_rew[$oid][$i];
				$val_5day=$stud_rew_5day[$oid][$i];
				$query="select * from stud_seme_rew where seme_year_seme='$seme_year_seme' and stud_id='$oid' and sr_kind_id='$i'";
				$rs_c=$CONN->Execute($query) or trigger_error("SQL語法錯誤：$query", E_USER_ERROR);
				if ($rs_c->recordcount() > 0) {
					$query="update stud_seme_rew set sr_num='$val',sr_num_5day='$val_5day' where seme_year_seme='$seme_year_seme' and stud_id='$oid' and sr_kind_id='$i'";
					$CONN->Execute($query) or trigger_error("SQL語法錯誤：$query", E_USER_ERROR);
				} else {
					$query="insert into stud_seme_rew (seme_year_seme,stud_id,student_sn,sr_kind_id,sr_num,sr_num_5day) values ('$seme_year_seme','$oid','$student_sn','$i','$val','$val_5day')";
					$CONN->Execute($query) or trigger_error("SQL語法錯誤：$query", E_USER_ERROR);;
				}
			}
		}
	}

	//修正student_sn=0的資料
	$query="select distinct stud_id from stud_seme_rew where student_sn=0 and seme_year_seme='$seme_year_seme'";
	$res=$CONN->Execute($query);
	$temp_arr=array();
	while(!$res->EOF) {
		$stud_id=$res->fields['stud_id'];
		if (intval($stud_id)>0) $temp_arr[]=$stud_id;
		$res->MoveNext();
	}
	if (count($temp_arr)>0) {
		$temp_str="'".implode("','",$temp_arr)."'";
		$query="select student_sn,stud_id from stud_base where stud_id in ($temp_str) and ($sel_year - stud_study_year between 0 and 9)";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			$query="update stud_seme_rew set student_sn='".$res->fields['student_sn']."' where stud_id='".$res->fields['stud_id']."' and student_sn=0 and seme_year_seme='$seme_year_seme'";
			$CONN->Execute($query);
			$res->MoveNext();
		}
	}
}

function cal_nor($sel_year,$sel_seme) {
	global $CONN,$f_w,$cl_days,$sl_days,$u_score,$d_score,$a_score;

	if (intval($cl_days)==0) $cl_days=30;
	if (intval($sl_days)==0) $sl_days=80;
	if ($u_score=="") $u_score=1;
	if ($d_score=="") $d_score=1;
	$abs_kind="'事假','病假','曠課','集會'";
	$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
	$query="select * from school_day where year='$sel_year' and seme='$sel_seme'";
	$rs_abs=$CONN->Execute($query) or trigger_error("SQL語法錯誤：$query", E_USER_ERROR);
	if ($rs_abs) {
		while (!$rs_abs->EOF) {
			$school_day[$rs_abs->fields['day_kind']]=$rs_abs->fields['day'];
			$rs_abs->MoveNext();
		}
	}
	$st=explode("-",$school_day[start]);
	$se=explode("-",$school_day[end]);
	if (intval($se[1])<intval($st[1])) $se[1]+=12;
	$query="select * from stud_seme_abs where seme_year_seme='$seme_year_seme' order by stud_id,abs_kind";
	$rs_abs=$CONN->Execute($query) or trigger_error("SQL語法錯誤：$query", E_USER_ERROR);
	if ($rs_abs->recordcount()>0)
		while (!$rs_abs->EOF) {
			$stud_abs[$rs_abs->fields['stud_id']][$rs_abs->fields['abs_kind']]=$rs_abs->fields['abs_days'];
			$rs_abs->MoveNext();
		}
	$query="select * from seme_score_nor where seme_year_seme='$seme_year_seme'";
	$rs_nor=$CONN->Execute($query) or trigger_error("SQL語法錯誤：$query", E_USER_ERROR);
	while (!$rs_nor->EOF) {
		$id=$rs_nor->fields['stud_id'];
		$stud_score[$id][0]=$rs_nor->fields['score1'];
		$stud_score[$id][1]=$rs_nor->fields['score2'];
		$stud_score[$id][2]=$rs_nor->fields['score3'];
		$stud_score[$id][3]=$rs_nor->fields['score4'];
		$stud_score[$id][4]=$rs_nor->fields['score5'];
		$stud_score[$id][5]=$rs_nor->fields['score6'];
		$stud_score[$id][6]=$rs_nor->fields['score7'];
		$rs_nor->MoveNext();
	}
	$query="select * from stud_seme_rew where seme_year_seme='$seme_year_seme' order by stud_id,sr_kind_id";
	$rs_rew=$CONN->Execute($query) or trigger_error("SQL語法錯誤：$query", E_USER_ERROR);
	if ($rs_rew) {
		while (!$rs_rew->EOF) {
			$id=$rs_rew->fields['stud_id'];
			$stud_rew[$id][$rs_rew->fields['sr_kind_id']]=$rs_rew->fields['sr_num'];
			$stud_rew_5day[$id][$rs_rew->fields['sr_kind_id']]=$rs_rew->fields['sr_num_5day'];
			$rs_rew->MoveNext();
		}
	}
	$query="select b.student_sn,b.stud_name,b.stud_id from stud_seme a,stud_base b where a.student_sn=b.student_sn and a.seme_year_seme='$seme_year_seme' order by a.stud_id";
	$rs=$CONN->Execute($query) or trigger_error("SQL語法錯誤：$query", E_USER_ERROR);;
	while (!$rs->EOF) {
		//取得座號及姓名
		$sn=$rs->fields['student_sn'];
		$id=$rs->fields['stud_id'];
		$stud_name=$rs->fields['stud_name'];

		//取得導師加減分
		$stud_score[$id][7]=round($stud_score[$id][0]+($stud_score[$id][1]+$stud_score[$id][2]+$stud_score[$id][3]+$stud_score[$id][4])/4+$stud_score[$id][5]+$stud_score[$id][6]);
		if ($stud_score[$id][7]=="") $stud_score[$id][7]="0";

		//計算全勤
		$abs_month=array();
		$query="select distinct month from stud_absent where year='$sel_year' and semester='$sel_seme' and stud_id='$id' and absent_kind in ($abs_kind) order by month";
		$rs_abs=$CONN->Execute($query) or trigger_error("SQL語法錯誤：$query", E_USER_ERROR);
		if ($rs_abs){
			if ($rs_abs->recordcount()>0) {
				while (!$rs_abs->EOF) {
					$abs_month[$rs_abs->fields['month']]=1;
					$rs_abs->MoveNext();
				}
			}
		}
		//-------------------------------
		//計算全勤
		$abs_month_5day=array();
		$query="select distinct month from stud_absent where year='$sel_year' and semester='$sel_seme' and stud_id='$id' and absent_kind in ($abs_kind) and DATE_FORMAT(date,'%w') <> '0' and DATE_FORMAT(date,'%w') <> '6' order by month";
		$rs_abs=$CONN->Execute($query) or trigger_error("SQL語法錯誤：$query", E_USER_ERROR);
		if ($rs_abs){
			if ($rs_abs->recordcount()>0) {
				while (!$rs_abs->EOF) {
					$abs_month_5day[$rs_abs->fields['month']]=1;
					$rs_abs->MoveNext();
				}
			}
		}		
		//-------------------------------	
		$abs_all=0;
		$abs_all_5day=0;
		$k=0;
		for ($i=intval($st[1]);$i<=$se[1];$i++) {
			$j=$i;
			$k++;
			if ($i>12) $j=$i-12;
			if ($abs_month[$j]!=1) $abs_all++;
			if ($abs_month_5day[$j]!=1) $abs_all_5day++;
		}
		if ($a_score!="1") {
			$abs_all=($abs_all==$k)?5:0;
			$abs_all_5day=($abs_all_5day==$k)?5:0;
		}	

		//取得出缺席值
		for ($i=1;$i<=6;$i++) {
			if ($stud_abs[$id][$i]=="") $stud_abs[$id][$i]=0;
			if ($stud_abs_5day[$id][$i]=="") $stud_abs_5day[$id][$i]=0;
		}	
		$stud_abs[$id][0]=$abs_all-floor($stud_abs[$id][3]/2+$stud_abs[$id][2]/$sl_days+$stud_abs[$id][1]/$cl_days+$stud_abs[$id][4]/4);
		$stud_abs_5day[$id][0]=$abs_all_5day-floor($stud_abs_5day[$id][3]/2+$stud_abs_5day[$id][2]/$sl_days+$stud_abs_5day[$id][1]/$cl_days+$stud_abs_5day[$id][4]/4);

		//取得獎懲值
		for ($i=1;$i<=6;$i++) {
			if ($stud_rew[$id][$i]=="") $stud_rew[$id][$i]=0;
			if ($stud_rew_5day[$id][$i]=="") $stud_rew_5day[$id][$i]=0;
		}
		$stud_rew[$id][0]=$stud_rew[$id][1]*9+$stud_rew[$id][2]*3+$stud_rew[$id][3]-$stud_rew[$id][4]*7;
		$stud_rew_5day[$id][0]=$stud_rew_5day[$id][1]*9+$stud_rew_5day[$id][2]*3+$stud_rew_5day[$id][3]-$stud_rew_5day[$id][4]*7;
		if ($f_w=="") $f_w=0;
		
		if ($stud_rew[$id][6] > 0) $stud_rew[$id][0]-=$stud_rew[$id][6]-1+$f_w;
		if ($stud_rew_5day[$id][6] > 0) $stud_rew_5day[$id][0]-=$stud_rew_5day[$id][6]-1+$f_w;
		
		if ($stud_rew[$id][5] > 2)
			$stud_rew[$id][0]-=($stud_rew[$id][5]-2)*3+4;
		else
			$stud_rew[$id][0]-=$stud_rew[$id][5]*2;

		if ($stud_rew_5day[$id][5] > 2)
			$stud_rew_5day[$id][0]-=($stud_rew_5day[$id][5]-2)*3+4;
		else
			$stud_rew_5day[$id][0]-=$stud_rew_5day[$id][5]*2;
		
		$nor_total=80+$stud_abs[$id][0]+$stud_score[$id][7]+$stud_rew[$id][0];
		$nor_total_5day=80+$stud_abs_5day[$id][0]+$stud_score_5day[$id][7]+$stud_rew_5day[$id][0];
		
		if ($u_score && $nor_total>100) $nor_total=100;
		if ($u_score && $nor_total_5day>100) $nor_total_5day=100;
		
		if ($d_score && $nor_total<0) $nor_total=0;
		if ($d_score && $nor_total_5day<0) $nor_total_5day=0;

		$query="select * from stud_seme_score_nor where seme_year_seme='$seme_year_seme' and student_sn='$sn' and ss_id='0'";
		$rs_nor=$CONN->Execute($query) or trigger_error("SQL語法錯誤：$query", E_USER_ERROR);;
		if ($rs_nor->recordcount()>0) {
			$query="update stud_seme_score_nor set ss_score='$nor_total',ss_score_5day='$nor_total_5day' where seme_year_seme='$seme_year_seme' and student_sn='$sn' and ss_id='0'";
			$CONN->Execute($query) or trigger_error("SQL語法錯誤：$query", E_USER_ERROR);;
		} else {
			$query="insert into stud_seme_score_nor (seme_year_seme,student_sn,ss_id,ss_score,ss_score_memo,ss_score_5day) values ('$seme_year_seme','$sn','0','$nor_total','','$nor_total_5day')";
			$CONN->Execute($query) or trigger_error("SQL語法錯誤：$query", E_USER_ERROR);;
		}
		$rs->MoveNext();
	}
	
}
?>
