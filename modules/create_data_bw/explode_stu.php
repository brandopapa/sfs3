<?php

// $Id: explode_stu.php 7705 2013-10-23 08:58:49Z smallduh $

// --系統設定檔
include "create_data_config.php";

//--認證 session
sfs_check();

// 不需要 register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

//取得目前學期
$curr_seme =  curr_seme();
//-----------------------------------
if ($do_key =="Excel 輸出") {	
	$filename = "class".$curr_class_year.".xls";
	header("Content-disposition: filename=$filename");
	header("Content-type: application/octetstream");
	//header("Pragma: no-cache");
					//配合 SSL連線時，IE 6,7,8下載有問題，進行修改 
				header("Cache-Control: max-age=0");
				header("Pragma: public");

	header("Expires: 0");
	echo "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; Charset=Big5\"></head><body><table border=1>\n";
	//echo "<tr><td>代號</td><td>姓名</td><td>性別</td><td>入學年</td><td>班級</td><td>座號</td><td>生日(西元)</td><td>身份證字號</td><td>畢業學校</td><td>父親姓名</td><td>父親電話</td><td>父親住家電話</td><td>父親手機</td><td>母親姓名</td><td>母親電話</td><td>母親住家電話</td><td>母親手機</td><td>監護人姓名</td><td>監護人電話</td><td>郵遞區號</td><td>電話</td><td>戶籍地址</td><td>連絡地址</td><td>緊急聯絡方式</td></tr>\n";
	echo "<tr><td>代號</td><td>姓名</td><td>英文姓名</td><td>性別</td><td>入學年</td><td>班別</td><td>座號</td><td>生日</td><td>身份證字號</td><td>畢業之國小</td><td>進園區日</td><td>身分類別</td><td>父親</td><td>電話父親公司</td><td>電話家</td><td>電話父親手機</td><td>父親研討班</td><td>父親職業</td><td>母親</td><td>電話母親公司</td><td>電話母親住家</td><td>電話母親手機</td><td>母親研討班</td><td>母親職業</td><td>監護人姓名</td><td>關係</td><td>監護人電話</td><td>郵遞區號</td><td>戶籍電話</td><td>戶籍所在地</td><td>通訊地址</td><td>緊急聯絡方式</td><td>兄弟__姊妹</td><td>常用E-mail</td><td>常用Skype</td><td>其他事項</td></tr>\n";
	
	if ($chk_all_year) {
	  $query = "select a.* from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$_REQUEST[curr_seme]' and b.seme_class like '" . substr( $_REQUEST[curr_class_year],0,1) ."%'  and a.stud_study_cond in (0,5) order by  a.curr_class_num";
	}else   
	  $query = "select a.* from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$_REQUEST[curr_seme]' and b.seme_class='$_REQUEST[curr_class_year]'  and a.stud_study_cond in (0,5) order by b.seme_num";
	//echo  $query ; 
	$result = $CONN->Execute($query)or die($query);
	$zip_arr = get_addr_zip_arr() ;
	
	while (!$result->EOF) {
		$stud_id = $result->fields[stud_id];
		//$s_addres = $result->fields[stud_addr_1];
		$s_home_phone = $result->fields[stud_tel_1];
		$s_offical_phone = $result->fields[stud_tel_2];
		$stud_sex = $result->fields[stud_sex];
		$stud_name = $result->fields[stud_name];
		$eng_stud_name = $result->fields[stud_name_eng];
		$curr_class_num = $result->fields[curr_class_num];
		$stud_birthday = $result->fields[stud_birthday];
		$stud_person_id = $result->fields[stud_person_id];
		$school = $result->fields[stud_mschool_name];
		$addr_zip = $result->fields[addr_zip];
		$stud_study_year = $result->fields['stud_study_year'];
		//取得 郵遞區號

		if ($addr_zip == '') {
			if ( $result->fields[stud_addr_a] <>'') {
		     $addr_ab = $result->fields[stud_addr_a] . $result->fields[stud_addr_b];  	
		     $addr_zip= $zip_arr[$addr_ab] ;
		  } 
    }

		//$addr = change_addr(addslashes($result->fields[stud_addr_1]),1);
		$addr_1 = $result->fields[stud_addr_1];
		$addr_2 = $result->fields[stud_addr_2];
		$s_addres = "";
		$email = $result->fields[stud_mail];
		//for ($i=0;$i<=20;$i++) $s_addres .= $addr[$i];
		//for ($i=0;$i<=20;$i++) $s_addres .= $addr[$i];
		//if ($addr_zip != '') {
		//	$s_addres = substr($s_addres,strlen($addr_zip));
		//}
		$query2 = "select fath_name,fath_phone,fath_home_phone,fath_hand_phone,moth_name,moth_phone,moth_home_phone,moth_hand_phone,guardian_name,guardian_phone,guardian_relation,fath_occupation,moth_occupation from stud_domicile where stud_id ='$stud_id'";
		$result2 = $CONN->Execute($query2)or die ($query2) ;
		$fath_name = $result2->fields[fath_name];
		$moth_name = $result2->fields[moth_name];
		$guardian_name = $result2->fields[guardian_name];
    $fath_phone = $result2->fields[fath_phone];
    $fath_home_phone = $result2->fields[fath_home_phone];
    $fath_hand_phone = $result2->fields[fath_hand_phone];
    $moth_phone = $result2->fields[moth_phone];
    $moth_home_phone = $result2->fields[moth_home_phone];
    $moth_hand_phone = $result2->fields[moth_hand_phone];
    $guardian_phone = $result2->fields[guardian_phone];
    $park_date = "";
    $id_kind = "";
    $fath_class = "";
    $fath_job = $result2->fields[fath_occupation];
    $moth_class = "";
    $moth_job = $result2->fields[moth_occupation];
    $guardian_relation = $result2->fields[guardian_relation];
    $brother_sister = "";    
    $skype = "";
    $other = "";

		echo sprintf("<tr><td>=T(\"%s\")</td><td>%s</td><td>%s</td><td>%d</td><td>%s</td>",$stud_id,$stud_name,$eng_stud_name,$stud_sex,$stud_study_year);
		
		echo sprintf("<td>%d</td><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>",substr($curr_class_num,1,2),substr($curr_class_num,-2),$stud_birthday,$stud_person_id,$school,$park_date,$id_kind,$fath_name,$fath_phone,$fath_home_phone,$fath_hand_phone,$fath_class,$fath_job,$moth_name,$moth_phone,$moth_home_phone,$moth_hand_phone,$moth_class,$moth_job,$guardian_name,$guardian_relation,$guardian_phone,$addr_zip); 

		//echo sprintf("<td>=T(\"%s\")</td><td>%s</td><td>=T(\"%s\")</td>",$s_home_phone,stripslashes($s_addres),$s_offical_phone); 
    echo sprintf("<td>=T(\"%s\")</td><td>%s</td><td>%s</td><td>=T(\"%s\")</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>",$s_home_phone,$addr_1,$addr_2,$s_offical_phone,$brother_sister,$email,$skype,$other); 

		echo"</tr>\n";
		$result->MoveNext();

	}
	echo "</table></body></html>";
	exit;
}

//印出檔頭
head("批次建立學生資料");
print_menu($menu_p);

?>

<table border="0" width="35%" cellspacing="0" cellpadding="0" >
<tr><td valign=top bgcolor="#CCCCCC">
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
<tr><td nowrap>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" name="pform">
<?php
	if ($_REQUEST[curr_seme]=='')
		$_REQUEST[curr_seme] = sprintf("%03d%d",curr_year(),curr_seme());
	$class_seme_p = get_class_seme(); //學年度
	$sel = new drop_select();
	$sel->s_name= "curr_seme";
	$sel->has_empty = false;
	$sel->is_submit = true;
	$sel->arr = $class_seme_p;
	$sel->id = $_REQUEST[curr_seme];
	$sel->do_select();

?> &nbsp;
<select	name="curr_class_year">

<?php
	$class_year_p = class_base($_REQUEST[curr_seme]);
	while(list($tkey,$tvalue)= each ($class_year_p))
	 {
		if ($tkey == $curr_class_year)	  
			 echo  sprintf ("<option value=\"%s\" selected>%s</option>\n",$tkey,$tvalue);
		else
			 echo  sprintf ("<option value=\"%s\">%s</option>\n",$tkey,$tvalue);
		  }
?>
</select>
<input name="chk_all_year" type="checkbox" id="chk_all_year" value="1">
<label for ="chk_all_year">全學年</label>
</td>
</tr>
<tr>
<td >
<input type=submit name="do_key" value="Excel 輸出">
</td>
</tr>
</table>
</td></tr></table>

<?php foot() ?>
