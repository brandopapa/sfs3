<?php

// $Id: mstudent2.php 7546 2013-09-19 03:35:15Z hami $

// --系統設定檔
include "create_data_config.php";
//--認證 session
sfs_check();
//取得目前學年
$curr_year = curr_year();

//取得目前學期
$curr_seme =  curr_seme();

$newer_only=$_POST['newer_only'];

// 不需要 register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

//印出檔頭
head("批次建立學生資料");
print_menu($menu_p);

if ($do_key=="批次建立資料")
{

	//取得郵遞區號代表的縣市鄉鎮 陣列
	$zip_arr = get_zip_arr();
	$rst=-1;
	//目前月份
	$month = date("m");
	//目前學年
	$class_year = curr_year();
	//目前學期
	$curr_seme =curr_seme();
	


	//學年學期
	$seme_year_seme = sprintf("%04d", curr_year().curr_seme());

	
	//判斷是否隔年
//	if (curr_seme()==1 and $month < $SFS_SEME2)
//		$class_year++;
	//取出 csv 的值
	$temp_file= $temp_path."stud.csv";
	if ($_FILES['userdata']['size'] >0 && $_FILES['userdata']['name'] != ""){
//		copy($_FILES['userdata']['tmp_name'] , $temp_file);		
		$fd = fopen ($_FILES['userdata']['tmp_name'],"r");
		
		for ($i=0;$i<2;$i++){
		    $tt = sfs_fgetcsv ($fd, 5000, ",");
		    // 只抓取匯入檔的第二列
		    if ($i==1)
		      $c_year = $class_year-$tt[3]+1+$IS_JHORES; // 計算年級，$IS_JHORES 使三種學制的年級計算正常
		}
		$query = "select c_sort,c_name  from school_class where year='$class_year' and semester='$curr_seme' and c_year='$c_year' ";
		$res = $CONN->Execute($query)or die ($query) ;
		if ($res->EOF){
		  $con_temp =  "您的匯入檔中 $c_year 年級(入學年: $tt[3])，尚未設定班級數，請注意這個年級在貴校學制中是否有效？若屬有效年級範圍，請至教務處->學期初設定，將班級數設定好之後，再執行本程式。<br>本次執行中斷的查詢指令為： $query";
		}
		else {
			while (!$res->EOF) {
				$temp_class_name[$res->fields[0]] = $res->fields[1];
				$res->MoveNext();
			}
									
			
			//進行匯入資料的檢查			
			rewind($fd);
			$j =0;
			$stud_id_array=array();
			$curr_class_num_array=array();
			while ($ck_tt = sfs_fgetcsv ($fd, 5000, ",")) {
				if ($j++ == 0){ //第一筆為抬頭，不檢查
                    continue ;
                }
				/*  原來的程式碼
				if (substr($ck_tt[0],0,1)==0)
					$stud_id= substr($ck_tt[0],1);
				else
					$stud_id= trim($ck_tt[0]);
				*/
				//修改的程式碼
				$stud_id= trim($ck_tt[0]);

				
				$rollin_year=trim($ck_tt[3]);

				//檢查學號是否存在
				if($stud_id=="") {
					$msg="學號（學生代號）不准空白，於第 ".$j." 筆學生資料";
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> 警告</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;					
					foot();
					exit;
				}
				
				//檢查學號是否重複
				if(in_array($stud_id,$stud_id_array))  {
					$msg="您所要匯入的學生資料中學號：$stud_id 重複"; 
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> 警告</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;					
					foot();
					exit;
				}
				
				//沒有重複則加入學號陣列
				$stud_id_array[$j]=$stud_id;
				
				
				$stud_name = trim (addslashes($ck_tt[1]));
				//檢查姓名
				if($stud_name=="") {
					$msg="學號：$stud_id 的學生沒有姓名";
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> 警告</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;					
					foot();
					exit;
				}
				
				$stud_sex = trim($ck_tt[2]);				
				//檢查性別				
				if($stud_sex!=1 && $stud_sex!=2) {
					$msg="學號：$stud_id  姓名：$stud_name 的學生性別錯誤"; 
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> 警告</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;					
					foot();
					exit;
				}
				
				$stud_study_year = chop ($ck_tt[3]);				
				// 引入 $IS_JHORES
				$year = $class_year-$stud_study_year+1+$IS_JHORES;
				$ck_query = "select c_sort,c_name  from school_class where year='$class_year' and semester='$curr_seme' and c_year='$year' and enable=1";
				$ck_res = $CONN->Execute($ck_query)or die ($ck_query) ;
				//檢查入學年度
				if ($ck_res->EOF) {
					$msg="學號：$stud_id  姓名：$stud_name 的入學年度（ $stud_study_year ）填寫錯誤或班級（ $year 年級） 尚未設定";
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> 警告</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;					
					foot();
					exit;
				}
				$k=0;
				while(!$ck_res->EOF){
					$c_sort[$k]=$ck_res->fields['c_sort'];					
					$ck_res->MoveNext();
					$k++;
				}
				//檢查班級
				$class=trim($ck_tt[4]);
				if(!in_array($class,$c_sort)){
					$msg="學號：$stud_id  姓名：$stud_name 的學生班級（ $year 年 $class 班 ）填寫錯誤或班級尚未設定"; 
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> 警告</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;									
					foot();	
					exit;
					}
								
				if($year==0) $class_name= sprintf("%03d",$ck_tt[4]);
				else $class_name = $year*100+$ck_tt[4];
				$class_name_id = $ck_tt[4];
				if($year==0) $curr_class_num=sprintf("%03d%02d",$ck_tt[4],$ck_tt[5]);
				else $curr_class_num= $class_name*100+$ck_tt[5];
				//檢查座號是否重複			
				if(in_array($curr_class_num,$curr_class_num_array))  {
					$msg= "您所要匯入的學生資料中座號（ $year 年 $class 班 ".substr($curr_class_num,-1,2)." 號 ） 重複"; 
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> 警告</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;					
					foot();
					exit;
				}
				
				//沒有重複則加入座號陣列
				$curr_class_num_array[$j]=$curr_class_num;
				
				$stud_birthday = trim ($ck_tt[6]);
				//檢查生日
				
				//$stud_birthday_array=explode("/",$stud_birthday);
				$stud_birthday_array=split("[/.-]",$stud_birthday);
				if($stud_birthday_array[0]<1900 || $stud_birthday_array[0]>2030 || $stud_birthday_array[1]<1 || $stud_birthday_array[1]>12 || $stud_birthday_array[2]<1 || $stud_birthday_array[2]>31) {
					$msg="學號：$stud_id  姓名：$stud_name 的生日（ $stud_birthday ）填寫錯誤"; 
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> 警告</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;				
					foot();
					exit;
				}
				
				$stud_person_id = trim ($ck_tt[7]);
				//檢查身份證
				if($stud_person_id=="") {
					$msg="身份證不准空白，於第 ".($j-1)." 筆學生資料";
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> 警告</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;					
					foot();
					exit;
				}				
				
				//檢查身份證是否重複
				if(in_array($stud_person_id,$stud_person_id_array))  {
					$msg="您所要匯入的學生資料中身份證號：$stud_person_id 重複"; 
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> 警告</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;
					foot();
					exit;
				}
				
				//沒有重複則加入學號陣列
				$stud_person_id_array[$j]=$stud_person_id;
				
				//檢查現存資料庫中是否該身份證是否有其他的學號，或是該學號中已存有其他身份正號
				$sql="select stud_id from stud_base where stud_person_id='$stud_person_id' and stud_study_cond='0' ";
				$rs=$CONN->Execute($sql) or trigger_error($sql,256);
				$m=0;
				while(!$rs->EOF){
					$old_id[$m]=$rs->fields['stud_id'];
					if($stud_id!=$old_id[$m]) {					
						$msg="學號：$stud_id  姓名：$stud_name 的身份證字號已被學號： ".$old_id[$m]." 使用，請查明！";
						$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> 警告</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
						echo $alert;
						foot();
						exit;
					}
					$rs->MoveNext();
					$m++;
				}
				
				//都沒問題了
				$check_pass="ok";
			}
			//檢查通過才放行，使之開始寫入資料庫
			if($check_pass=="ok"){			
				rewind($fd);
				$i =0;
				while ($tt = sfs_fgetcsv ($fd, 5000, ",")) {
					if ($i++ == 0){ //第一筆為抬頭
						$ok_temp .="<font color='red'>第一筆應為抬頭，若您的學生基本資料檔的第一筆是學生資料的話，該位學生將無法匯入！</font><br>";
						continue ;
					}
					/*  原來的程式碼
					if (substr($tt[0],0,1)==0)
						$stud_id= substr($tt[0],1);
					else
						$stud_id= trim($tt[0]);
					*/
					//修改的程式碼
					$stud_id= trim($tt[0]);
					$stud_name = trim (addslashes($tt[1]));
					
					//加入將全形空白替換的功能
					$stud_name=str_replace('　','',$stud_name); 
					
					$stud_sex = trim($tt[2]);
					$stud_study_year = chop ($tt[3]);
					
					$go=true;				
					if($newer_only and $stud_study_year<>$class_year) $go=false;
					if($go) {
				
						// 引入 $IS_JHORES
						$year = $class_year-$stud_study_year+1+$IS_JHORES;
						//幼稚班的年級為0
						if($year==0) $class= sprintf("%03d",$tt[4]);
						else $class = $year*100+$tt[4];
						$class_name_id = $tt[4];
						if($year==0) $curr_class_num=sprintf("%03d%02d",$tt[4],$tt[5]);
						else $curr_class_num= $class*100+$tt[5];
						$seme_num = sprintf("%02d",$tt[5]);
						$stud_birthday = trim ($tt[6]);
						$stud_person_id = trim ($tt[7]);
						$fath_name = trim (addslashes($tt[8]));
						$moth_name = trim (addslashes($tt[9]));

						$stud_tel_1 = trim ($tt[11]);
						$stud_tel_2 = trim ($tt[13]);
						$stud_mschool_name = trim ($tt[14]);
						$zip_id = trim($tt[10]);
						$addr = $zip_arr[$tt[10]].trim(addslashes($tt[12]));
						
						//20120825新增欄位   戶籍遷入日期、學生行動電話、連絡地址、監護人、監護人行動電話
						$addr_move_in=trim($tt[15]);
						$stud_tel_3 = trim ($tt[16]);
						$stud_addr_2 = trim(addslashes($tt[17]));
						$stud_addr_2 = $stud_addr_2?$stud_addr_2:$addr;	
						$guardian_name=trim($tt[18]);
						$guardian_hand_phone=trim($tt[19]);							
						$edu_key =  hash('sha256', strtoupper($stud_person_id));
						//拆解地址
						$addr_arr = change_addr($addr);
						$stud_kind =',0,';
						//空值NULL的判斷，修正未keyin戶籍遷入日期時，基本資料（stud_list.php）遷入日期-1911-00-00的錯置。修改 by chunkai 102.9.6
						$sql_insert1 = "replace into stud_base (stud_id,stud_name,stud_person_id,stud_birthday,stud_sex,stud_study_cond,
						curr_class_num,stud_study_year,stud_addr_a,stud_addr_b,stud_addr_c,stud_addr_d,stud_addr_e,stud_addr_f,
						stud_addr_g,stud_addr_h,stud_addr_i,stud_addr_j,stud_addr_k,stud_addr_l,stud_addr_m,stud_addr_1,stud_addr_2,
						stud_tel_1,stud_tel_2,stud_kind,stud_mschool_name,addr_zip,enroll_school,addr_move_in,stud_tel_3,edu_key) 
						values ('$stud_id','$stud_name ','$stud_person_id','$stud_birthday','$stud_sex','0','$curr_class_num','$stud_study_year',
						'$addr_arr[0]','$addr_arr[1]','$addr_arr[2]','$addr_arr[3]','$addr_arr[4]','$addr_arr[5]','$addr_arr[6]','$addr_arr[7]',
						'$addr_arr[8]','$addr_arr[9]','$addr_arr[10]','$addr_arr[11]','$addr_arr[12]','$addr','$stud_addr_2','$stud_tel_1',
						'$stud_tel_2','$stud_kind','$stud_mschool_name','$zip_id','$school_long_name','$addr_move_in','$stud_tel_3','$edu_key')";
						
						$sql_insert2 = "replace into stud_base (stud_id,stud_name,stud_person_id,stud_birthday,stud_sex,stud_study_cond,
						curr_class_num,stud_study_year,stud_addr_a,stud_addr_b,stud_addr_c,stud_addr_d,stud_addr_e,stud_addr_f,
						stud_addr_g,stud_addr_h,stud_addr_i,stud_addr_j,stud_addr_k,stud_addr_l,stud_addr_m,stud_addr_1,stud_addr_2,
						stud_tel_1,stud_tel_2,stud_kind,stud_mschool_name,addr_zip,enroll_school,addr_move_in,stud_tel_3,edu_key)
						 values ('$stud_id','$stud_name ','$stud_person_id','$stud_birthday','$stud_sex','0','$curr_class_num','$stud_study_year',
						'$addr_arr[0]','$addr_arr[1]','$addr_arr[2]','$addr_arr[3]','$addr_arr[4]','$addr_arr[5]','$addr_arr[6]','$addr_arr[7]',
						'$addr_arr[8]','$addr_arr[9]','$addr_arr[10]','$addr_arr[11]','$addr_arr[12]','$addr','$stud_addr_2','$stud_tel_1',
						'$stud_tel_2','$stud_kind','$stud_mschool_name','$zip_id','$school_long_name',NULL,'$stud_tel_3','$edu_key')";
						($addr_move_in == '')?$sql_insert=$sql_insert2:$sql_insert=$sql_insert1;
				//	echo $sql_insert."<BR>";

						$result2 = $CONN->Execute($sql_insert);
						if ($result2) {
							$stud_name=stripslashes($stud_name);
							$ok_temp .= "$stud_id -- $stud_name 新增成功!<br>";
							
							$guardian_name = $guardian_name?$guardian_name:$fath_name;
							$guardian_name = $guardian_name?$guardian_name:$moth_name;
							
							//取得 student_sn
							$query = "select student_sn from stud_base where stud_id='$stud_id' and stud_study_year=$stud_study_year";
							$resss = $CONN->Execute($query);
							$student_sn= $resss->fields[0];

							//加入家庭狀況資料
							$query = "replace into stud_domicile (stud_id,fath_name,moth_name,guardian_name,guardian_hand_phone,student_sn) values('$stud_id','$fath_name','$moth_name','$guardian_name','$guardian_hand_phone','$student_sn')";
							if (!$CONN->Execute($query))
								$con_temp .= "$stud_id - $stud_name 新增家庭狀況資料失敗! <br>";
							//加入學年學期資料
							$query = "replace into  stud_seme (seme_year_seme,stud_id,seme_class,seme_num,seme_class_name,student_sn) values('$seme_year_seme','$stud_id','$class','$seme_num','$temp_class_name[$class_name_id]','$student_sn')";
							if (!$CONN->Execute($query))
								$con_temp .= "$stud_id - $stud_name 新增學年資料失敗! <br>";
					//	echo $query."<BR>";

						}	else $con_temp .= "$stud_id - $stud_name 新增基本資料失敗! <br>";
					} else $con_temp .="學號: $stud_id - $stud_name 入學年( $rollin_year )匯入限定禁止!!<BR>";
				}
			}
		}
	}
	else
	{
		echo "檔案格式錯誤!";
		exit;
	}
	unlink($temp_file);
	
}
?>

<table border="0" width="100%" cellspacing="0" cellpadding="0" >
<tr><td valign=top bgcolor="#CCCCCC">
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >

<form action ="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" method=post>
<tr><td  nowrap>檔案：<input type=file name=userdata><BR><BR><font color='red'>PS.歷年度已有的學生資料請勿重覆匯入！</font></td>
<td width=65% rowspan="2" valign=top>
<?php
if ($con_temp<>''){
	echo "<b>新增錯誤<b><p>";
	echo "<font size=4>$con_temp</font>";
}
else
	echo '
<p><b><font size="4">學生資料批次建檔說明</font></b></p>
<p>1.本程式只能建立學生基本資料，其他如學生戶口資料等，需至學籍管理程式建立。<br>
2.利用 excel 或其他工具鍵入學生資料，存成 csv 檔，並保留第一列標題檔，如 
<a href=studdemo.csv target=new>範例檔</a><BR>
3.本範例檔為萬豐版健康系統匯出之學生資料檔 Sheet1.xls 須轉存成 .csv 格式檔。<br>
4.出生日期以西元為準。<br>
5.地址順序:按下列方式排列，程式才可正常拆解。<br>
<span style="background-color: #FFFF00"><font color="#0000FF">縣(市)</font>鄉(鎮區)<font color="#0000FF">村(里)</font>鄰<font color="#0000FF">路(街)</font>段<font color="#0000FF">巷</font>弄<font color="#0000FF">號</font><font color="#000000">之</font><font color="#0000FF">樓</font>之</span></p>
例:
  <li>台中縣外埔鄉中山村11鄰中山路34之6號</li>
  <li>台中縣外埔鄉大同村甲后路9號</
';

?>

</td>

</tr>
<tr><td nowrap><input type='checkbox' name='newer_only' value='checked' checked>限定只能匯入本學年度新生 ( 入學年為 <?php echo $curr_year; ?> )<br><br>
<input type=submit name="do_key" value="批次建立資料"></td></tr>

</form>
</table>
</td></tr></table>

<?php
echo $ok_temp;
foot();


?> 
