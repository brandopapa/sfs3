<?php
//$Id: function.php 7018 2012-11-30 02:11:40Z chiming $
include "config.php";
//標籤格式化
function make_list($array=array(),$txt="",$other_title="",$other=array(),$table=true){


        $main=($table)?"<table cellspacing='1' cellpadding='3' bgcolor='#C0C0C0' class='small'>":"";

        $main.="<tr bgcolor='#DFEFAF'><td>".$txt."標籤</td><td>標籤值範例</td>$other_title</tr>";
        foreach($array as $kind=>$v){
                $other_main="";
                foreach($other[$kind] as $o){
                        $other_main.="<td>$o</td>";
                }
                $main.="<tr bgcolor='#FFFFFF'><td nowrap>{".$kind."}</td><td><font color=blue>$v</font></td>$other_main</tr>";
        }
        $main.=($table)?"</table>":"";
        return $main;
}

//成績單下拉選項
function score_paper_option(){
        global $CONN;
        $main="";
        $sql_select="select sp_sn,sp_name,descriptive from score_paper where enable='1'";
        $recordSet=$CONN->Execute($sql_select) or user_error("讀取失敗！<br>$sql_select",256);
        while (list($sp_sn,$sp_name,$descriptive)=$recordSet->FetchRow()) {
                $main.="<option value='$sp_sn'>$sp_name</option>";
        }

        return $main;
}

//擷取出標籤
function get_mark($data=array(),$other=""){

        if(!empty($other)){
                foreach($other as $key=>$v){
                        $temp_arr.="{".$key."}\n";
                        foreach($v as $vv){
                                $temp_arr.=$vv."\n";
                        }
                }
                $temp_arr.="\n\n";
        }else{
                foreach($data as $key=>$v){
                        $temp_arr.="{".$key."}";
                }
                $temp_arr.="\n\n";
        }
        return $temp_arr;
}

//取得學校資料
function get_school_base_array(){
        global $CONN,$draw_img_width,$draw_img_height,$sign_1_form,$sign_2_form,$sign_3_form,$sign_1_name,$sign_2_name,$sign_3_name,$SFS_PATH_HTML,$UPLOAD_PATH,$UPLOAD_URL;
        $sql_select = "select * from school_base";
        $recordSet=$CONN->Execute($sql_select);
        $school_data = $recordSet->FetchRow();

        $school['屬性']=$school_data["sch_attr_id"];
        $school['縣市別']=$school_data["sch_sheng"];
        $school['學校全銜']=$school_data["sch_cname"];
        $school['學校簡稱']=$school_data["sch_cname_s"];
        $school['學校簡稱']=$school_data["sch_cname_ss"];
        $school['學校地址']=$school_data["sch_addr"];
        $school['學校電話']=$school_data["sch_phone"];
        $school['學校傳真']=$school_data["sch_fax"];
		
        //取得校長名稱  20170109 add by Brando
        //$sql_select = "select name from teacher_base as a,teacher_post as b where b.teach_title_id=1 and a.teacher_sn=b.teacher_sn order by b.update_time desc Limit 1";
        /*
        $sql_select = "select name from teacher_base as a left join teacher_post as b on a.teacher_sn=b.teacher_sn";
        $sql_select = $sql_select." where b.teach_title_id=1";   //職稱:校長
        $sql_select = $sql_select." and b.post_kind=1";          //職別代碼:校長
        $sql_select = $sql_select." and a.teach_condition=0";    //在職
        $recordSet=$CONN->Execute($sql_select);
        $school_data = $recordSet->FetchRow();
        $school['校長']=$school_data["name"];
        */
        
        
        //取得教務主任名稱 20170109 add by Brando
        //$sql_select = "select name from teacher_base as a,teacher_post as b where b.teach_title_id=2 and a.teacher_sn=b.teacher_sn order by b.update_time desc Limit 1";
        /*
        $sql_select = "select name from teacher_base as a left join teacher_post as b on a.teacher_sn=b.teacher_sn";
        $sql_select = $sql_select." where b.teach_title_id=2";   //職稱:教務主任
        $sql_select = $sql_select." and b.post_kind=3";          //職別代碼:主任
        $sql_select = $sql_select." and a.teach_condition=0";    //在職
        $recordSet=$CONN->Execute($sql_select);
        $school_data = $recordSet->FetchRow();
        $recordSet=$CONN->Execute($sql_select);
        $school_data = $recordSet->FetchRow();
        $school['教務主任']=$school_data["name"];
        */
        
        //取得學務主任名稱 20170109 add by Brando
        //$sql_select = "select name from teacher_base as a,teacher_post as b where b.teach_title_id=2 and a.teacher_sn=b.teacher_sn order by b.update_time desc Limit 1";
        /*
        $sql_select = "select name from teacher_base as a left join teacher_post as b on a.teacher_sn=b.teacher_sn";
        $sql_select = $sql_select." where b.teach_title_id=3";   //職稱:學務主任
        $sql_select = $sql_select." and b.post_kind=3";          //職別代碼:主任
        $sql_select = $sql_select." and a.teach_condition=0";    //在職
        $recordSet=$CONN->Execute($sql_select);
        $school_data = $recordSet->FetchRow();
        $recordSet=$CONN->Execute($sql_select);
        $school_data = $recordSet->FetchRow();
        $school['學務主任']=$school_data["name"];
        */
        
        //取得簽章 20170109 add by Brando
        //if ($draw_img_width=='') $draw_img_width="3.1cm";
        //if ($draw_img_height=='') $draw_img_height="0.8cm";
        //校長簽章檔
        if ($sign_1_form=="" || $sign_1_form==1) {
			if (is_file($UPLOAD_PATH."school/title_img/title_1")){
				$title_img = $SFS_PATH_HTML.$UPLOAD_URL."school/title_img/title_1";
				$sign_1 = $title_img;
			}
        } elseif ($sign_1_form==2) {
        	$sign_1=$sign_1_name;
        }
        $school['SIGN1']=$sign_1;
        //教務主任簽章檔
        if ($sign_2_form=="" || $sign_2_form==1) {
        	if (is_file($UPLOAD_PATH."school/title_img/title_2")){
        		$title_img = $SFS_PATH_HTML.$UPLOAD_URL."school/title_img/title_2";
        		$sign_2 = $title_img;
        		//$sign_2 = "<draw:image draw:style-name=\"fr2\" draw:name=\"signature2\" text:anchor-type=\"paragraph\" svg:x=\"0.73cm\" svg:y=\"0.344cm\" svg:width=\"$draw_img_width\" svg:height=\"$draw_img_height\" draw:z-index=\"1\" xlink:href=\"$title_img\" xlink:type=\"simple\" xlink:show=\"embed\" xlink:actuate=\"onLoad\"/>";
        	}
        } elseif ($sign_2_form==2) {
        	$sign_2=$sign_2_name;
        }
        $school['SIGN2']=$sign_2;
        
        //學務主任簽章檔
        if ($sign_3_form=="" || $sign_3_form==1) {
        	if (is_file($UPLOAD_PATH."school/title_img/title_3")){
        		$title_img = $SFS_PATH_HTML.$UPLOAD_URL."school/title_img/title_3";
				$sign_3 = $title_img;
        		//$sign_3 = "<draw:image draw:style-name=\"fr3\" draw:name=\"signature3\" text:anchor-type=\"paragraph\" svg:x=\"0.723cm\" svg:y=\"0.344cm\" svg:width=\"$draw_img_width\" svg:height=\"$draw_img_height\" draw:z-index=\"2\" xlink:href=\"$title_img\" xlink:type=\"simple\" xlink:show=\"embed\" xlink:actuate=\"onLoad\"/>";
        	}
        } elseif ($sign_3_form==2) {
        	$sign_3=$sign_3_name;
        }
        $school['SIGN3']=$sign_3;
        
        return $school;
}

//取得課程陣列
function ss_array($year="",$seme="",$cyear="",$class_id=""){
        global $CONN;
		
        //取得領域名稱
        $subject_name_arr=&get_subject_name_arr();

                if(!empty($class_id)){
                        $andwhere="and class_id='$class_id'";
                }else{
                        $andwhere="and class_year='$cyear' AND class_id='' ";
                }

        $sql_select = "select * from score_ss where year='$year' and semester='$seme' and enable='1' $andwhere order by ss_id";

                $recordSet = $CONN->Execute($sql_select) or trigger_error("SQL 錯誤",E_USER_ERROR);
                while ($subject=$recordSet->FetchRow()) {
                        $scope_id=$subject[scope_id];
                        $subject_id=$subject[subject_id];
                        //取得領域名稱
                        $scope_name=$subject_name_arr[$scope_id][subject_name];

                        //取得學科名稱
                        $subject_name=(!empty($subject_id))?$subject_name_arr[$subject_id][subject_name]:"";

                        $show_ss=(empty($subject_name))?$scope_name:$scope_name."-".$subject_name;

                        $ss_id=$subject[ss_id];
                        $subject['name']=$show_ss;
                        $res_arr[$ss_id]=$subject;
                }

                if(empty($res_arr) and !empty($class_id)){
                        $cyear=substr($class_id,6,2)*1;
                        $res_arr=ss_array($year,$seme,$cyear,"");
                }

        return $res_arr;
}

//取得上課日數，開學日及end日
function get_all_days($sel_year,$sel_seme,$class_id){
        global $CONN;

        $class=class_id_2_old($class_id);
        $cyear=$class[3];
        $seme_year_seme = sprintf("%03d%d",$sel_year,$sel_seme);

        $sql_select = "select days from seme_course_date where seme_year_seme='$seme_year_seme' and class_year='$cyear'";
        $recordSet = $CONN->Execute($sql_select) or trigger_error("SQL 錯誤",E_USER_ERROR);
        list($days)=$recordSet->FetchRow();
        $mark['上課日數']=$days;

        $sql_select = "select day_kind,day from school_day where year='$sel_year' and seme='$sel_seme'";
        $recordSet = $CONN->Execute($sql_select) or trigger_error("SQL 錯誤",E_USER_ERROR);
        while(list($day_kind,$day)=$recordSet->FetchRow()){
                if($day_kind=="st_start"){
                        $mark['本學期開學日']=$day;
                }elseif($day_kind=="st_end"){
                        $mark['本學期結束日']=$day;
                }
        }

        return $mark;
}

//取得班級及個人資料
function get_stud_base_array($class_id,$stud_id){
        global $CONN;
        $c=class_id_2_old($class_id);

        $class['學年']=$c[0];
        $class['學期']=($c[1]=='1')?"上":"下";
        $class['年級']=$c[3];
        $class['班']=$c[4];
        $class['班級']=$c[5];
        $teacher=get_class_teacher($c[2]);
        $class['導師']=$teacher[name];
        //取得指定學生資料
        $stu=get_stud_base("",$stud_id);
        $class['學生姓名']=$stu['stud_name'];
        $class['座號']=substr($stu['curr_class_num'],-2,2);
        $class['學號']=$stud_id;
        $class['性別']=($stu['stud_sex']=='1')?"男":"女";
        $class['生日']=$stu['stud_birthday'];
        $class['身分證號']=$stu['stud_person_id'];
        $class['學生地址一']=$stu['stud_addr_1'];
        $class['學生地址二']=$stu['stud_addr_2'];
        $class['學生電話一']=$stu['stud_tel_1'];
        $class['學生電話二']=$stu['stud_tel_2'];
        return $class;
}

//取得班級及個人資料--加入學生SN才能取到正確值
function get_stud_base_arrayB($class_id,$stud_id,$student_sn){
        global $CONN;
        $c=class_id_2_old($class_id);

        $class['學年']=$c[0];
        $class['學期']=($c[1]=='1')?"上":"下";
        $class['年級']=$c[3];
        $class['班']=$c[4];
        $class['班級']=$c[5];
        $teacher=get_class_teacher($c[2]);
        $class['導師']=$teacher[name];
        //取得指定學生資料--加入學生SN才能取到正確值
        $stu=get_stud_baseB($student_sn,$stud_id);
        $class['學生姓名']=$stu['stud_name'];
        $class['座號']=substr($stu['curr_class_num'],-2,2);
        $class['學號']=$stud_id;
        $class['性別']=($stu['stud_sex']=='1')?"男":"女";
        $class['生日']=$stu['stud_birthday'];
        $class['身分證號']=$stu['stud_person_id'];
        $class['學生地址一']=$stu['stud_addr_1'];
        $class['學生地址二']=$stu['stud_addr_2'];
        $class['學生電話一']=$stu['stud_tel_1'];
        $class['學生電話二']=$stu['stud_tel_2'];
        return $class;
}

// 自動取得九年一貫成績
function get_ss9_array($sel_year,$sel_seme,$stud_id,$student_sn,$class_id) {
        global $CONN,$ss9;
		$oth_arr_score = array("表現優異"=>5,"表現良好"=>4,"表現尚可"=>3,"需再加油"=>2,"有待改進"=>1);
        //取得領域名稱
    $subject_name_arr=&get_subject_name_arr();
               $break_text ="{break_text}";
        $class=class_id_2_old($class_id);
        $cyear=$class[3];

        // 取得努力程度文字敘述
        $oth_data=get_oth_value($stud_id,$sel_year,$sel_seme);
		
        // 取得課程每週時數
        $ss_num_arr = get_ss_num_arr($class_id);
        // 取得學習成就
        $ss_score_arr =get_ss_score_arr($class,$student_sn);

        //取得同一領域的科目加權分數合計
        foreach($ss_score_arr as $ssid=>$v){
			$sql_select = "select scope_id,subject_id,need_exam,rate,link_ss from score_ss where  class_year='$cyear' and enable='1' and year = $sel_year and semester='$sel_seme' and ss_id='$ssid'";
			$recordSet = $CONN->Execute($sql_select) or trigger_error("SQL 錯誤",E_USER_ERROR);
			while(list($scope_id,$subject_id,$need_exam,$rate,$link_ss)=$recordSet->FetchRow()){

				//取得領域名稱
				$scope_name=$subject_name_arr[$scope_id][subject_name];

				//取得學科名稱
				$subject_name=(!empty($subject_id))?$subject_name_arr[$subject_id][subject_name]:"";

				$show_ss=(empty($subject_name))?$scope_name:$subject_name;

				//把要算分的科目計算進來
				if($need_exam=='1'){
					//計算分科成績
					$score_tmp=$ss_score_arr[$ssid][ss_score];
					//計算領域成績
					$score_rate[$link_ss]+=$score_tmp*$rate;

					//計算領域總加權數
					$all_rate[$link_ss]+=$rate;
					//計算領域總節數
					$all_ss_num[$link_ss]+=$ss_num_arr[$ssid];

					//紀錄分科加權到陣列中
					$rate_txt[$link_ss][]=$rate;
					//紀錄分科評語到陣列中
					$p_txt[$link_ss][]=$ss_score_arr[$ssid]['ss_score_memo'];
					//紀錄分科努力程度到陣列中
					$nl_txt[$link_ss][]=$oth_data["努力程度"][$ssid];
					
					//計算領域努力程度
					$subject_nl_score=$oth_arr_score[($oth_data["努力程度"][$ssid])];
					
					$nl_score[$link_ss][score]+=$subject_nl_score*$rate;	
					$nl_score[$link_ss][rate]+=$rate;
				}
				$nl_score[$link_ss][real_score]=round(($nl_score[$link_ss][score])/($nl_score[$link_ss][rate]));
			}
				
        }

        //計算單一領域合科加權後的分數
        foreach($score_rate as $ss_name=>$ls_score){
                $score[$ss_name]=round($ls_score/$all_rate[$ss_name],2);
                $score_name[$ss_name]=score2str($score[$ss_name],$class);
                $ss_rate_txt[$ss_name]=implode($break_text,$rate_txt[$ss_name]);
                $ss_p_txt[$ss_name]=implode($break_text,$p_txt[$ss_name]);
                //$ss_nl_txt[$ss_name]=implode($break_text,$nl_txt[$ss_name]);   //原來的會分列努力程度
				$ss_nl_txt[$ss_name]=array_search($nl_score[$ss_name][real_score],$oth_arr_score);  //替換為計算後的努力程度
        }


        foreach($ss9 as $ss_name){

                $k="九_".$ss_name;
                $k1=$k."節數";
                $k2=$k."分數";
                $k3=$k."加權";
                $k4=$k."等第";
                $k5=$k."努力程度";
                $k6=$k."評語";

                $main[$k]=$ss_name;
                $main[$k1]=$all_ss_num[$ss_name];
                $main[$k2]=$score[$ss_name];
                $main[$k3]=$ss_rate_txt[$ss_name];
                $main[$k4]=$score_name[$ss_name];
                $main[$k5]=$ss_nl_txt[$ss_name];
                $main[$k6]=$ss_p_txt[$ss_name];
        }


        return $main;
}

// 自動取得九年一貫衍生成績
function get_ssm_array($arr=array(),$class_id) {
	$main="";
	$pre_k="";
	$break_text ="{break_text}";
	while(list($k,$v)=each($arr)) {
		if ($pre_k!=$k) {
			if (substr($k,0,7)=="九_語文") {
				$mk="九_語文";
				$main[$mk]=$mk;
				$main[$mk."節數"]+=$arr[$k."節數"];
				$main[$mk."分數"]+=$arr[$k."分數"]*$arr[$k."加權"];
				$main[$mk."加權"]+=$arr[$k."加權"];
				$main[$mk."等第"]="";
			}
			$mk="九_學期總平均";
			$main[$mk]=$mk;
			$main[$mk."節數"]+=$arr[$k."節數"];
			//是否為分科設定
			if (strpos($arr[$k."加權"],$break_text)) {
				$d=array();
				$d=explode($break_text,$arr[$k."加權"]);
				$r=0;
				while(list($dk,$dv)=each($d)) {
					$r+=$dv;
				}
				$main[$mk."加權"]+=$r;
				$main[$mk."分數"]+=$arr[$k."分數"]*$r;
			} else {
				$main[$mk."加權"]+=$arr[$k."加權"];
				$main[$mk."分數"]+=$arr[$k."分數"]*$arr[$k."加權"];
			}
		}
	}
	$class=class_id_2_old($class_id);
	$main["九_語文分數"]=round($main["九_語文分數"]/$main["九_語文加權"],2);
	$main["九_語文等第"]=score2str($main["九_語文分數"],$class);
	$main["九_學期總平均分數"]=round($main["九_學期總平均分數"]/$main["九_學期總平均加權"],2);
	$main["九_學期總平均等第"]=score2str($main["九_學期總平均分數"],$class);

	return $main;
}

// 取得成績
function get_score_array($sel_year,$sel_seme,$stud_id,$student_sn,$class_id) {
        global $CONN;

        $class=class_id_2_old($class_id);
        $cyear=$class[3];

        // 取得努力程度文字敘述
        $oth_data=get_oth_value($stud_id,$sel_year,$sel_seme);
        // 取得課程每週時數
        $ss_num_arr = get_ss_num_arr($class_id);
        // 取得學習成就
        $ss_score_arr =get_ss_score_arr($class,$student_sn);


        //取得科目陣列
        $ss_array=ss_array($sel_year,$sel_seme,$cyear,$class_id);
        $yss=array();

        foreach($ss_array as $ss_id=>$subject){
                if($subject[need_exam]!='1')continue;
                $k=$subject['name'];
                $yss[$k]=$subject['name'];

                $k1=$k."節數";
                $k2=$k."分數";
                $k3=$k."等第";
                $k4=$k."努力程度";
                $k5=$k."評語";
                $k6=$k."加權";

                $score[$k]=$subject['name'];
                $score[$k1]=$ss_num_arr[$ss_id];
                $score[$k2]=$ss_score_arr[$ss_id]['ss_score'];
                $score[$k3]=$ss_score_arr[$ss_id]['score_name'];
                $score[$k4]=$oth_data["努力程度"]["$ss_id"];
                $score[$k5]=$ss_score_arr[$ss_id]['ss_score_memo'];
                $score[$k6]=$subject['rate'];
        }


        return $score;
}

//取得將懲記錄
function get_reward_value2($stud_id,$sel_year,$sel_seme) {
        global $CONN;
        $all_kind=stud_rep_kind();
        $seme_year_seme = sprintf("%03d%d",$sel_year,$sel_seme);
        $query="select * from reward where reward_year_seme = $seme_year_seme and stud_id='$stud_id'";
        $res = $CONN->Execute($query);
        if(empty($res))return;
        $temp_arr=array();
        while(!$res->EOF){
                $reward_kind=$res->fields['reward_kind'];
                //獎勵類別
                if($reward_kind=="1"){
                        $reward['嘉獎']++;
                }elseif($reward_kind=="1"){
                        $reward['嘉獎']++;
                }elseif($reward_kind=="2"){
                        $reward['嘉獎']+=2;
                }elseif($reward_kind=="3"){
                        $reward['小功\']++;
                }elseif($reward_kind=="4"){
                        $reward['小功\']+=2;
                }elseif($reward_kind=="5"){
                        $reward['大功\']++;
                }elseif($reward_kind=="6"){
                        $reward['大功\']+=2;
                }elseif($reward_kind=="7"){
                        $reward['大功\']+=3;
                }elseif($reward_kind=="-1"){
                        $reward['警告']++;
                }elseif($reward_kind=="-2"){
                        $reward['警告']+=2;
                }elseif($reward_kind=="-3"){
                        $reward['小過']++;
                }elseif($reward_kind=="-4"){
                        $reward['小過']+=2;
                }elseif($reward_kind=="-5"){
                        $reward['大過']++;
                }elseif($reward_kind=="-6"){
                        $reward['大過']+=2;
                }elseif($reward_kind=="-7"){
                        $reward['大過']+=3;
                }

                $res->MoveNext();
        }

        foreach($all_kind as $v){
                $val=(empty($reward[$v]))?0:$reward[$v];
                $temp_arr[$v]=$val;
        }

        return $temp_arr;

}

//取得生活表現評量
function get_performance_value($stud_id,$sel_year,$sel_seme){
        global $performance;
        $oth_data=get_oth_value($stud_id,$sel_year,$sel_seme);
        foreach($performance as $id=>$sk){
                $oth_array[$sk]=$oth_data['生活表現評量'][$id];
        }
        return $oth_array;
}

//刪除目錄
function deldir($dir){
        $current_dir = opendir($dir);
        while($entryname = readdir($current_dir)){
                if(is_dir("$dir/$entryname") and ($entryname != "." and $entryname!="..")){
                        deldir("${dir}/${entryname}");
                }elseif($entryname != "." and $entryname!=".."){
                        unlink("${dir}/${entryname}");
                }
        }
        closedir($current_dir);
        rmdir(${dir});
}

