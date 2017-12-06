<?php
// $Id: stud_move_out.php 8482 2015-08-10 16:23:40Z hsiao $
// 載入設定檔
include "stud_move_config.php";
include_once "../../include/sfs_case_dataarray.php";

// 認證檢查
sfs_check();

//$SCHOOL_BASE = get_school_base($mysql_db);
//echo $SCHOOL_BASE['sch_id'];


$m_arr = get_sfs_module_set();
extract($m_arr, EXTR_OVERWRITE);

// 不需要 register_globals
if (!ini_get('register_globals')) {
    ini_set("magic_quotes_runtime", 0);
    extract($_POST);
    extract($_GET);
    extract($_SERVER);
}
$sure = "確定修改";
$clean = "各欄清空";

if ($move_date) {
    $move_date = ChtoD($move_date);
    $move_c_date = ChtoD($move_c_date);
}

$stud_class_array = explode("_", $stud_class);
if (!$curr_seme) {
    $sel_year = curr_year(); //選擇學年
    $sel_seme = curr_seme(); //選擇學期
    $curr_seme = curr_year() . curr_seme(); //現在學年學期
} else {
    $sel_year = substr($curr_seme, 0, 3);
    if (substr($sel_year, 0, 1) == "0")
        $sel_year = substr($sel_year, 1, 2);
    $sel_seme = substr($curr_seme, 3, 1);
    $curr_seme = $sel_year . $sel_seme;
}
$seme_year_seme = sprintf("%04d", $curr_seme);

$do_upload_script = "var targeturi = encodeURI('" . $SFS_PATH_HTML . "modules/stud_move/session_upload.php?curr_seme=" . $curr_seme . "');window.open(targeturi);";
$do_xcatest_script = "var targeturi = encodeURI('" . $SFS_PATH_HTML . "modules/stud_move/session_xcatest.php');window.open(targeturi);";
$upload_script = "<script>alert('請記得將學生異動資料上傳\\n至臺中市就學管控系統哦！')</script>";

//echo $upload_script;
//判斷是否是台中市學校
$isTaichung = substr($SCHOOL_BASE['sch_id'], 0, 2);


if (intval($stud_class_array[0]) != intval($sel_year)) {
    if ($stud_name == "") {
        $stud_id = "";
        $stud_class = "";
        $move_c_word = $default_word;
        $move_c_unit = $default_unit;
        $reason = $default_reason;
        $move_kind = "";
    }
}
if ($key != $sure && $key != $clean && $kkey == "edit")
    $key = "edit";

//處理學籍暫切
if ($_POST[tran_status]) {
    $tran_data = explode('_', $_POST[tran_status]);
    $query = "UPDATE stud_base SET stud_study_cond={$tran_data[0]} WHERE student_sn={$tran_data[1]}";
    $res = $CONN->Execute($query);
}


$key = $_REQUEST['key'];
//按鍵處理
switch ($key) {
    case $postOutBtn :
        if (($postOutBtn <> '確定轉出') and $_POST['stud_class']) {
            //抓取最大化的轉出號碼
            $query = "SELECT max(school_move_num) as max_num FROM stud_move WHERE (move_year_seme='" . curr_year() . curr_seme() . "') AND (move_kind IN (7,8,11,12))";
            $res = $CONN->Execute($query);
            $school_move_num = $res->fields['max_num'] + 1;
        }
        $update_ip = getip();
        $query = "select student_sn from stud_seme where stud_id='$stud_id' and seme_year_seme='$seme_year_seme'";
        $res = $CONN->Execute($query) or die($query);
        $student_sn = $res->fields[student_sn];
        //加入異動記錄
        $sql_insert = "insert into stud_move (stud_id,move_kind,move_year_seme,school_move_num,move_date,move_c_unit,move_c_date,move_c_word,move_c_num,update_id,update_ip,update_time,school,school_id,student_sn,reason,new_address,city) values ('$stud_id','$move_kind','$curr_seme','$school_move_num','$move_date','$move_c_unit','$move_c_date','$move_c_word','$move_c_num','" . $_SESSION['session_log_id'] . "','$update_ip','" . date("Y-m-d G:i:s") . "','$school','$school_id','$student_sn','$reason','$new_address','$city')";
        $CONN->Execute($sql_insert) or die($sql_insert);
        $sql_update = "update stud_base set stud_study_cond ='$move_kind' where student_sn='$student_sn'";
        $CONN->Execute($sql_update) or die($sql_update);
        if ($isTaichung == '06' || $isTaichung == '19') {
            echo $upload_script;
        }
        break;

    case "edit":
        $sql = "select * from stud_move where move_id='$move_id'";
        $rs = $CONN->Execute($sql) or die($sql);
        $move_kind = $rs->fields['move_kind'];
        $student_sn = $rs->fields['student_sn'];
        $n_stud_id = $rs->fields['stud_id'];
        if ($n_stud_id != $stud_id) {
            $stud_id = $n_stud_id;
            $curr_seme = $rs->fields['move_year_seme'];
            $school_move_num = $rs->fields['school_move_num'];
            $move_date = $rs->fields['move_date'];
            $move_c_unit = $rs->fields['move_c_unit'];
            $move_c_date = $rs->fields['move_c_date'];
            $move_c_word = $rs->fields['move_c_word'];
            $move_c_num = $rs->fields['move_c_num'];
            $city = $rs->fields['city'];
            $school = $rs->fields['school'];
            $school_id = $rs->fields['school_id'];
            $reason = $rs->fields['reason'];
            $new_address = $rs->fields['new_address'];

            $sql = "select stud_name from stud_base where student_sn='$student_sn'";
            $rs = $CONN->Execute($sql) or die($sql);
            $stud_name = $rs->fields['stud_name'];
            $sql = "select seme_class from stud_seme where stud_id='$stud_id' and seme_year_seme='$seme_year_seme'";
            $rs = $CONN->Execute($sql) or die($sql);
            $seme_class = $rs->fields['seme_class'];
            $stud_class = sprintf("%03d_%d_%02d_%02d", substr($seme_year_seme, 0, 3), substr($seme_year_seme, -1, 1), substr($seme_class, 0, 1), substr($seme_class, 1, 2));
        }
        $postOutBtn = $sure;
        $edit = '1';
        break;

    case $sure :
        $update_ip = getip();
        $today = date("Y-m-d G:i:s", mktime(date("G"), date("i"), date("s"), date("m"), date("d"), date("Y")));
        $sql_update = "update stud_move set move_year_seme='$curr_seme',school_move_num='$school_move_num',move_kind='$move_kind',move_date='$move_date',move_c_unit='$move_c_unit',move_c_date='$move_c_date',move_c_word='$move_c_word',move_c_num='$move_c_num',city='$city',update_time='$today',update_id='" . $_SESSION['session_log_id'] . "',update_ip='$update_ip',school='$school',school_id='$school_id',reason='$reason',new_address='$new_address' where move_id='$move_id' and stud_id='$stud_id'";

        $CONN->Execute($sql_update) or die($sql_update);
        $postOutBtn = $sure;
        $edit = '1';
        if ($isTaichung == '06' || $isTaichung == '19') {
            echo $upload_script;
        }
        break;

    case "delete" :
        $query = "select * from stud_move where move_id ='$move_id'";
        $res = $CONN->Execute($query)or die($query);
        $student_sn = $res->fields['student_sn'];
        $query = "delete from stud_move where move_id ='$move_id'";
        $CONN->Execute($query)or die($query);
        $sql_update = "update stud_base set stud_study_cond ='0' where student_sn='$student_sn'";
        $CONN->Execute($sql_update) or die($sql_update);
        if ($isTaichung == '06' || $isTaichung == '19') {
            echo $upload_script;
        }
        break;

    case $clean :
        $stud_id = "";
        $stud_name = "";
        $stud_class = "";
        $move_kind = "";
        $move_date = "";
        $move_c_word = $default_word;
        $move_c_unit = $default_unit;
        $reason = $default_reason;
        $new_address = "";
        $move_c_date = "";
        break;
}

//欄位資訊
$field_data = get_field_info("stud_move");

//印出檔頭
head();
print_menu($student_menu_p);
?>
<script type="text/javascript" language="JavaScript">


    function doUploadScript() {
<?php
echo $do_upload_script;
?>

    }


    function doXCATestScript() {
<?php
echo $do_xcatest_script;
?>

    }

//var oform = document.forms["myform"];
    function getSN() {
        var oform = document.forms["myform"];
        alert(oform.elements.choice.value);
    }

    function openModal(studentsn, currseme, stud_id, stud_name, stud_class, stud_new_class)
    {
        var para = studentsn + ';' + currseme + ';' + stud_id + ';' + stud_name.trim() + ';' + stud_class.trim() + ';' + stud_new_class.trim() + ';' + '<?php echo $SCHOOL_BASE["sch_cname_ss"] . '(' . $SCHOOL_BASE['sch_id'] . ')'; ?>';
        para = encodeURIComponent(para);
        var targeturi = encodeURI("<?php echo $SFS_PATH_HTML; ?>modules/stud_move/session_out.php?para=" + para);
        window.open(targeturi);
    }

    function checkok()
    {
        var OK = true;
        if (document.myform.stud_class.value == 0)
        {
            alert('未選擇班級');
            OK = false;
        }
        if (document.myform.stud_id.value == '')
        {
            alert('未選擇學生');
            OK = false;
        }


        if (document.myform.move_kind.value == '')
        {
            alert('未選擇類別');
            OK = false;
        }

        var kid = document.getElementsByName("move_kind")[0].value;

        if (kid == 8 && document.myform.city.value == '')
        {
            alert('新就讀縣市未輸入');
            OK = false;
        }
        if (kid == 8 && document.myform.school.value == '')
        {
            alert('新就讀學校未輸入');
            OK = false;
        }
        if (kid == 8 && document.myform.school_id.value == '')
        {
            alert('新就讀學校教育部代碼未輸入');
            OK = false;
        }
        document.myform.action = '<?php echo $_SERVER['SCRIPT_NAME'] ?>';
        return OK
    }


    function setfocus(element) {
        element.focus();
        return;
    }

    function PrintChart(a, b, c, d) {
        document.myform.year_seme.value = a;
        document.myform.class_id.value = b;
        document.getElementById('rid').value = c;
        document.myform.template.value = d;
        document.myform.filename.value = 'reg_move' + c + '.sxw';
        document.myform.do_key.value = '確定';
        document.myform.action = '<?php echo $SFS_PATH_HTML; ?>/modules/stud_report/index.php';
        document.myform.submit();
    }
//-->
</script>
<form name ="myform" action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td width="100%" valign=top bgcolor="#CCCCCC">
                <table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
                    <tr>
                        <td class=title_mbody colspan=2 align=center > 學生調出作業 </td>
                    </tr>
                    <tr>
                        <td align="right" class="title_sbody2">選擇學期</td>
                        <td>
                            <?php
                            //列出學期
                            $class_seme_p = get_class_seme(); //學年度	
                            $seme_temp = "<select name=\"curr_seme\" onchange=\"this.form.action='" . $_SERVER['SCRIPT_NAME'] . "';this.form.submit()\">\n";
                            while (list($tid, $tname) = each($class_seme_p)) {
                                if ($curr_seme == $tid)
                                    $seme_temp .= "<option value=\"$tid\" selected>$tname</option>\n";
                                else
                                    $seme_temp .= "<option value=\"$tid\">$tname</option>\n";
                            }
                            $seme_temp .= "</select>";
                            echo $seme_temp;
                            ?>	    
                        </td>
                    </tr>
                    <tr>
                        <td class="title_sbody2">選擇班級</td>
                        <td>
                            <?php
                            //列出班級		
                            if ($edit != '1')
                                echo get_class_select($sel_year, $sel_seme, "", "stud_class", "this.form.action=\"" . $_SERVER['SCRIPT_NAME'] . "\";this.form.submit", $stud_class);
                            else {
                                $class_temp = explode("_", $stud_class);
                                $sql = "select c_name from school_class where class_id='$stud_class'";
                                $rs = $CONN->Execute($sql) or die($sql);
                                $c_name = $rs->fields['c_name'];
                                if ($c_name == "")
                                    echo "找不到對應班級";
                                else
                                    echo $school_kind_name[intval($class_temp[2])] . $c_name . "班";
                            }
                            ?>	    
                        </td>
                    </tr>
                    <tr>
                        <td class="title_sbody2">選擇學生</td>
                        <td>
                            <?php
                            // source in include/PLlib.php
                            if ($edit != '1') {
                                $temp_arr = explode("_", $stud_class);
                                $temp_class = intval($temp_arr[2]) . $temp_arr[3];
                                $grid1 = new sfs_grid_menu;  //建立選單	   
                                $grid1->bgcolor = $gridBgcolor;  // 顏色   
                                $grid1->row = 1;      //顯示筆數
                                $grid1->width = 1;      //顯示寬	
                                $grid1->dispaly_nav = false; // 顯示下方按鈕
                                $grid1->bgcolor = "FFFFFF";
                                $grid1->nodata_name = "沒有學生";
                                $grid1->top_option = "-- 選擇學生 --";
                                $grid1->key_item = "stud_id";  // 索引欄名  	
                                $grid1->display_item = array("sit_num", "stud_name");  // 顯示欄名   
                                $grid1->display_color = array("1" => "$gridBoy_color", "2" => "$gridGirl_color"); //男女生別
                                $grid1->color_index_item = "stud_sex"; //顏色判斷值
                                $grid1->class_ccs = " class=leftmenu";  // 顏色顯示
                                $year_seme = $temp_arr[0] . $temp_arr[1];
                                $grid1->sql_str = "select a.stud_id,a.stud_name,a.stud_sex,b.seme_num as sit_num from stud_base a,stud_seme b where a.student_sn=b.student_sn and a.stud_study_cond in (0,15) and b.seme_year_seme='$year_seme' and b.seme_class='$temp_class' order by b.seme_num";   //SQL 命令   
                                $grid1->do_query(); //執行命令
                                $downstr = "<input type=hidden name=ckey value=\"$ckey\">";
                                $grid1->print_grid($stud_id, $upstr, $downstr); // 顯示畫面
                            } else {
                                echo $stud_name;
                            }
                            ?>	
                        </td>
                    </tr>
                    <tr>
                        <td class="title_sbody2">調出類別</td>
                        <td>
                            <?php
                            $sel1 = new drop_select(); //選單類別
                            $sel1->s_name = "move_kind"; //選單名稱	
                            $sel1->arr = $out_arr; //內容陣列		
                            $sel1->top_option = "-- 選擇類別 --";
                            $sel1->id = $move_kind;
                            $sel1->do_select();
                            ?>	


                        </td>

                    </tr>
                    <tr>
                        <td class="title_sbody2">異動日期</td>
                        <td> 民國 <input type="text" size="10" maxlength="10" name="move_date" value="<?php echo DtoCh($move_date) ?>"></td>
                    </tr>
                    <tr>
                        <td class="title_sbody2">學校轉出證明字號</td>
                        <td> <?php echo $school_sshort_name ?>轉證字第<?php echo $curr_seme ?><input type='text' name='school_move_num' value='<?php echo sprintf('%03d', $school_move_num); ?>' width='3' size='3'<?php echo ($key == 'edit' or $postOutBtn == $sure) ? '' : ' disabled'; ?>>號 ( 新增轉出 會自動給予編號 )</td>
                    </tr>
                    <tr>
                        <td align="right" CLASS="title_sbody1">請選擇新就讀學校</td>
                        <td><SELECT  NAME="selectcity" onChange="SelectCity();" ><Option value="">請選擇縣市</option></SELECT>&nbsp;<SELECT  NAME="selectdistrict" onChange="SelectDistrict();" ><Option value="">請選擇區域</option></SELECT>&nbsp;<SELECT NAME="selectschool" onchange="disp_text();"><Option value="">請選擇學校</option></SELECT></td>
                    </tr>
                    <tr>
                        <td align="right" CLASS="title_sbody1">新就讀縣市</td>
                        <td><input type="text" size="20" maxlength="20" name="city" value="<?php echo $city ?>" readonly></td>
                    </tr>
                    <tr>
                        <td align="right" CLASS="title_sbody1">新就讀學校</td>
                        <td><input type="text" size="20" maxlength="20" name="school" value="<?php echo $school ?>" readonly></td>
                    </tr>
                    <tr> 
                        <td align="right" CLASS="title_sbody1">新就讀學校教育部代碼</td>   
                        <td><input type="text" size="10" maxlength="6" name="school_id" value="<?php echo $school_id ?>" readonly></td>   
                    </tr> 

                    <tr>
                        <td align="right" CLASS="title_sbody1">轉出原因</td>
                        <td><input type="text" size="20" maxlength="20" name="reason" value="<?php echo $reason ?>"></td>
                    </tr>
                    <tr>
                        <td align="right" CLASS="title_sbody1">轉出後新的戶籍地址</td>
                        <td><input type="text" size="60" maxlength="60" name="new_address" value="<?php echo $new_address ?>"></td>
                    </tr>
                    <tr>
                        <td align="right" CLASS="title_sbody1"><?php echo $field_data[move_c_unit][d_field_cname] ?></td>
                        <td><input type="text" size="30" maxlength="30" name="move_c_unit" value="<?php echo $move_c_unit ?>"></td>
                    </tr>

                    <tr>
                        <td align="right" CLASS="title_sbody1"><?php echo $field_data[move_c_date][d_field_cname] ?></td>
                        <td> 民國 <input type="text" size="10" maxlength="10" name="move_c_date"  value="<?php echo DtoCh($move_c_date) ?>"></td>
                    </tr>
                    <tr>
                        <td align="right" CLASS="title_sbody1"><?php echo $field_data[move_c_word][d_field_cname] ?></td>
                        <td><input type="text" size="20" maxlength="20" name="move_c_word" value="<?php echo $move_c_word ?>">字</td>
                    </tr>
                    <tr>
                        <td align="right" CLASS="title_sbody1"><?php echo $field_data[move_c_num][d_field_cname] ?></td>
                        <td>第<input type="text" size="14" maxlength="14" name="move_c_num" value="<?php echo $move_c_num ?>">號</td>
                    </tr>
                    <tr>
                        <td width="100%" align="center"  colspan="5" >
                            <input type="hidden" name="update_id" value="<?php echo $_SESSION['session_log_id'] ?>">
                            <?php
                            echo "<input type=submit name=key value =\"$postOutBtn\" onClick=\"return checkok();\">";
                            if ($edit == '1')
                                echo "<input type='hidden' name='kkey' value='edit'>
      			<input type='hidden' name='move_id' value='$move_id'>
      			<input type='hidden' name='stud_id' value='$stud_id'>
      			<input type='hidden' name='stud_name' value='$stud_name'>
      			<input type='hidden' name='stud_class' value='$stud_class'>
			<input type='submit' name='key' value='$clean'>
			";
                            ?>
                        </td>
                    </tr>
                </table>
   　</td>
        </tr>
        <TR>
            <TD>
                <?php
                $sch_data = get_school_base();
                reset($out_arr);
                while (list($tid, $tname) = each($out_arr))
                    $temp_move_kind .="a.move_kind = $tid or ";
                $seme_year_seme = sprintf("%04d", $curr_seme);
                $class_list_p = class_base($seme_year_seme);
                $temp_move_kind = substr($temp_move_kind, 0, -3);
                $query = "select a.*,b.stud_name,b.stud_kind,b.stud_study_cond from stud_move a ,stud_base b where a.student_sn=b.student_sn and a.move_year_seme='$curr_seme' and ( $temp_move_kind ) order by a.school_move_num DESC";
                $result = $CONN->Execute($query) or die($query);
                if (!$result->EOF) {
                    echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"2\" bordercolorlight=\"#333354\" bordercolordark=\"#FFFFFF\"  width=\"100%\" class=main_body >";
                    if ($isTaichung == '06' || $isTaichung == '19') {
                        echo "<tr><td colspan=13 class=title_top1 align=center ><button onclick=\"doUploadScript()\">按我上傳本學期學生異動資料至臺中市就學管控系統</button></td></tr>";
                    }
                    echo "<tr><td colspan=13 class=title_top1 align=center ><button onclick=\"doXCATestScript()\">按我進行XCA全自動加解密測試！</button></td></tr>";
                    echo "<tr><td colspan=13 class=title_top1 align=center >本學期調出學生</td></tr>";
                    echo "
			<TR class=title_mbody >
				<TD>NO.</TD>
				<TD>異動類別</TD>
				<TD>異動日期</TD>
				<TD>學號</TD>
				<TD>姓名</TD>
				<TD>班級</TD>
				<TD>核准單位</TD>
				<TD>字號</TD>
				<TD>新就讀縣市學校</TD>
				<TD rowspan=2 align='center'>編修</TD>
				<TD rowspan=2 align='center'>
				<input type='hidden' name='year_seme' value='$seme_year_seme'>
				<input type='submit' name='output_xml' value='匯出XML' onclick=\"document.myform.action='../toxml/output_xml.php'; document.myform.submit();\">
				</TD>
				<TD rowspan=2 align='center'>學籍狀態暫切</TD>
				<TD rowspan=2 align='center'>XML自動交換</TD>
			</TR>
			<TR class=title_mbody >
			<TD colspan=8>轉出原因</TD>
			<TD>列印選項</TD>
			</TR>";
                }
                while (!$result->EOF) {
                    $school_move_num = $result->fields["school_move_num"];
                    $move_id = $result->fields["move_id"];
                    $move_kind = $result->fields["move_kind"];
                    $stud_id = $result->fields["stud_id"];
                    $student_sn = $result->fields["student_sn"];
                    $stud_name = $result->fields["stud_name"];
                    $stud_kind = $result->fields["stud_kind"];
                    $stud_study_cond = $result->fields["stud_study_cond"];
                    if ($stud_study_cond)
                        $stud_study_cond = "<input type='button' name='temp_status' value='暫切為在籍' style='border-width:1px; cursor:hand; background:#FFAAAA; font-size:9pt;' onclick=\"this.form.tran_status.value='0_$student_sn'; this.form.submit();\">";
                    else
                        $stud_study_cond = "<input type='button' name='temp_status' value='回復為{$out_arr[$move_kind]}' style='border-width:1px; cursor:hand; background:#AAFFAA; font-size:12pt;' onclick=\"this.form.tran_status.value='" . $move_kind . "_$student_sn'; this.form.submit();\">";
                    $sql = "select * from stud_seme where student_sn='$student_sn' and seme_year_seme='$seme_year_seme'";
                    $rs = $CONN->Execute($sql);
                    $class_num = $rs->fields["seme_class"];
                    $stud_clss = $class_list_p[$class_num];
                    $move_year_seme = $result->fields["move_year_seme"];
                    $move_date = $result->fields["move_date"];
                    $move_c_date = $result->fields["move_c_date"];
                    $move_c_unit = $result->fields["move_c_unit"];
                    $move_c_word = $result->fields["move_c_word"];
                    $move_c_num = $result->fields["move_c_num"];
                    $school_id = $result->fields["school_id"];
                    $cityschool = $result->fields["city"] . $result->fields["school"];
                    $school = $result->fields["school"];

                    //加入抓取學生身分的功能
                    //學生身分別 
                    $stud_kind_arr = stud_kind();

                    $stud_kind_temp = '';
                    $stud_kind_temp_arr = explode(",", $stud_kind);
                    for ($iii = 0; $iii < count($stud_kind_temp_arr); $iii++) {
                        if ($stud_kind_temp_arr[$iii] <> '')
                            $stud_kind_temp .= $stud_kind_arr[$stud_kind_temp_arr[$iii]] . ",";
                    }
                    $stud_kind_temp = substr($stud_kind_temp, 0, -1);

                    if ($cityschool == "")
                        $cityschool = "&nbsp;";
                    echo ($i++ % 4 > 1) ? "<TR class=nom_1>" : "<TR class=nom_2>";
                    echo "			
					<TD bgcolor='#FFCCCC' align='center'>$school_move_num</TD>
					<TD>$out_arr[$move_kind]</TD>
					<TD>" . DtoCh($move_date) . "</TD>
					<TD>$stud_id</TD>
					<TD>$stud_name</TD>
					<TD>$stud_clss" . (($stud_clss == "") ? "　" : "") . "</TD>					
					<TD>$move_c_unit</TD>
					<TD>" . DtoCh($move_c_date) . " " . $move_c_word . "字第" . $move_c_num . "號</TD>
					<TD>$school_id $cityschool</TD>
					<TD rowspan=2 align='center'>
					<a href=\"{$_SERVER['SCRIPT_NAME']}?key=edit&move_id=$move_id&stud_id=$stud_id&curr_seme=$curr_seme_temp\">編輯</a>
					<a href=\"{$_SERVER['SCRIPT_NAME']}?key=delete&move_id=$move_id&stud_id=$stud_id&curr_seme=$curr_seme_temp\" onClick=\"return confirm('確定要刪除 $stud_name 轉出記錄 ?');\">刪除</a></td>
					<td rowspan=2 align='center'><input type='checkbox' name='choice[$student_sn]'></td>
					</TD>
					<TD rowspan=2 align='center'>$stud_study_cond</TD>
<TD rowspan=2 align='center'><input type='button' value='自動上傳' onclick='openModal($student_sn,$curr_seme,$stud_id,\"$stud_name\",\"$stud_clss" . (($stud_clss == "") ? "　" : "") . "\",\"$school\");'></TD>
				</TR>";

                    echo ($i++ % 4 > 1) ? "<TR class=nom_1>" : "<TR class=nom_2>";
                    echo "<TD colspan=8>" . $result->fields[reason] . " <font color='#FF0000'>( $stud_kind_temp )</font>";
                    echo "<BR>轉出後新址：<font color='#FF00FF'>{$result->fields[new_address]}</font></TD><TD> ";
                    if ($move_kind == '8' or $move_kind == '7')
                        echo "<A HREF='mv_certificate.php?mv_id=" . $move_id . "' target=_blank>轉學証明</A> | ";
                    $myown_dir = $UPLOAD_PATH . "stud_report/reg";
                    if ($sch_data['sch_sheng'] == "彰化縣")
                        echo "<A HREF='../stud_report/chc_prn_score.php?list_stud_id=" . $stud_id . "' target=_blank>學籍表</A>";
                    else
                        echo "學籍表: <a href=\"#\" OnClick=\"PrintChart('$curr_seme','$class_num','$stud_id','tcc95_reg_" . (($IS_JHORES) ? "jh" : "ps") . "');\">95 </A>
						<a href=\"#\" OnClick=\"PrintChart('$curr_seme','$class_num','$stud_id','tc100_reg_" . (($IS_JHORES) ? "jh" : "ps") . "');\">100 </A>
						<a href=\"#\" OnClick=\"PrintChart('$curr_seme','$class_num','$stud_id','$myown_dir');\">自訂</A>";
                    echo "</TD></TR>";

                    $result->MoveNext();
                }
                ?>
    </table>
</TD>
</TR>
<TR>
    <TD></TD>
</TR>
</table>
<input type="hidden" name="tran_status" value="">
<input type="hidden" name="year_seme">
<input type="hidden" name="class_id">
<input type="hidden" name="sel_stud[0]" id="rid">
<input type="hidden" name="template">
<input type="hidden" name="filename">
<input type="hidden" name="do_key">
</form>
<?php
if ($IS_JHORES) {
    echo "<script type='text/javascript' src='jhslist.js'></script>";
} else {
    echo "<script type='text/javascript' src='pslist.js'></script>";
}
?>
<script language='javascript'>
    $(function () {
        fillCity();
    });
</script>
<?php foot(); ?>
