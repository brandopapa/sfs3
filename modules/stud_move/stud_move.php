<?php
// ���J�]�w��
include "stud_move_config.php";
// �{���ˬd
sfs_check();
//print_r($_SESSION);
$m_arr = get_sfs_module_set();
extract($m_arr, EXTR_OVERWRITE);

// ���ݭn register_globals
if (!ini_get('register_globals')) {
    ini_set("magic_quotes_runtime", 0);
    extract($_POST);
    extract($_GET);
    extract($_SERVER);
}

if ($move_date) {
    $move_date = ChtoD($move_date);
    $move_c_date = ChtoD($move_c_date);
}

if ($stud_birthday) {
    $stud_birthday = ChtoD($stud_birthday);
}

$stud_class_array = explode("_", $stud_class);
if (!$curr_seme) {
    $sel_year = curr_year(); //��ܾǦ~
    $sel_seme = curr_seme(); //��ܾǴ�
    $curr_seme = curr_year() . curr_seme(); //�{�b�Ǧ~�Ǵ�
} else {
    $sel_year = substr($curr_seme, 0, 3);
    if (substr($sel_year, 0, 1) == "0")
        $sel_year = substr($sel_year, 1, 2);
    $sel_seme = substr($curr_seme, 3, 1);
    $curr_seme = $sel_year . $sel_seme;
}
$sel_class_year = intval($stud_class_array[2]); //��ܦ~��
$sel_class_name = $stud_class_array[3]; //��ܯZ��
$seme_year_seme = sprintf("%04d", $curr_seme);
$temp_class_no_num = $sel_class_year . $sel_class_name;

$do_upload_script = "var targeturi = encodeURI('" . $SFS_PATH_HTML . "modules/stud_move/session_upload.php?curr_seme=" . $curr_seme . "');window.open(targeturi);";
$upload_script = "<script>alert('�аO�o�N�ǥͲ��ʸ�ƤW��\\n�ܻO�����N�Ǻޱ��t�ή@�I')</script>";
//echo $upload_script;
//�P�_�O�_�O�x�����Ǯ�
$isTaichung = substr($SCHOOL_BASE['sch_id'], 0, 2);

if (intval($stud_class_array[0]) != intval($sel_year)) {
    $stud_class = "";
    if ($stud_name == "") {
        $stud_id = "";
        $stud_class = "";
        $stud_person_id = "";
        $stud_birthday = "";
        $move_c_word = $default_word;
        $move_c_unit = $default_unit;
        $reason = $default_reason;
        $stud_sex = "";
    }
}
$sure = "�T�w�ק�";
$clean = "�U��M��";
if ($key != $sure && $key != $clean && $kkey == "edit")
    $key = "edit";;


//����B�z
switch ($key) {
    case $postInBtn :
        //���ˬd�ǥͲ��ʬO�_�w�g���o�Ӿǥͪ�����----�����H�����Ҧr�����ostud_base��student_sn,�A���stud_move����ƦC��
        $sql = "select student_sn,stud_person_id from stud_base where stud_person_id='$stud_person_id'";
        $rs = $CONN->Execute($sql) or trigger_error("�����ˬd�ǥͲ��ʬO�_�w�g���o�Ӿǥͪ���������!  $sql", E_USER_ERROR);
        ;
        $post_confirm = $_POST['post_confirm'];

        if ($rs->recordcount())
            $confirm_in = "<tr><td align='right' colspan='2' bgcolor='#FF8888'><input type='checkbox' name='post_confirm' value='ON'>�o�Ө����Ҧr��( $stud_person_id )���g�����y�O���A�ڽT�w�n������J!!</td></tr>";

        if (!$rs->recordcount() or $post_confirm) {
            $curr_y = curr_year();
            $sql = "select stud_id from stud_base where stud_id='$stud_id' and ('$curr_y'-stud_study_year < 7) and ('$curr_y'-stud_study_year >= 0)";
            $rs = $CONN->Execute($sql);
            if (!$rs->fields['$stud_id']) {
                //�[�J�ǥ͸��
                $query1 = "select max(seme_num) as mm from stud_seme where seme_class='$temp_class_no_num' and seme_year_seme='$seme_year_seme'";
                $result1 = $CONN->Execute($query1) or die($query1);
                $new_site_num = intval($result1->fields[0]) + 1;
                $temp_class_num = ($temp_class_no_num + ($curr_y - $sel_year) * 100) . $new_site_num;
                $stud_study_year = $sel_year - $sel_class_year + 1 + $IS_JHORES;
                $sql_insert = "insert into stud_base (stud_id,stud_name,stud_person_id,stud_birthday,stud_sex,stud_study_year,curr_class_num,stud_study_cond,enroll_school) values('$stud_id','$stud_name','$stud_person_id','$stud_birthday','$stud_sex','$stud_study_year','$temp_class_num','0','$enroll_school')";
                $CONN->Execute($sql_insert) or trigger_error("�ӾǸ��w�g���H�ϥΡG$sql_insert", E_USER_ERROR);

                //���o student_sn
                $query = "select student_sn from stud_base where stud_id='$stud_id' and stud_study_year='$stud_study_year'";
                $resss = $CONN->Execute($query);
                $student_sn = $resss->fields[0];

                //�[�J���ʰO��
                $update_ip = getip();
                $today = date("Y-m-d G:i:s", mktime(date("G"), date("i"), date("s"), date("m"), date("d"), date("Y")));
                $sql_insert = "insert into stud_move (stud_id,move_kind,move_year_seme,move_date,move_c_unit,move_c_date,move_c_word,move_c_num,update_time,update_id,update_ip,city,school,school_id,student_sn,reason) values ('$stud_id','2','$curr_seme','$move_date','$move_c_unit','$move_c_date','$move_c_word','$move_c_num','$today','" . $_SESSION['session_log_id'] . "','$update_ip','$city','$school','$school_id','$student_sn','$reason')";
                $CONN->Execute($sql_insert) or die($sql_insert);

                //�[�J�Ǵ����
                //$class_name_id = substr($stud_class,-2);
                $seme_class_name = $class_name[$class_name_id];
                $seme_class = $temp_class_no_num;
                $rs = $CONN->Execute("select c_name from school_class where class_id='$stud_class' and enable=1");
                $seme_class_name = $rs->fields[c_name];
                $seme_num = $new_site_num;
                $query = "insert into stud_seme (seme_year_seme,stud_id,seme_class,seme_class_name,seme_num,student_sn) values('$seme_year_seme','$stud_id','$seme_class','$seme_class_name','$seme_num','$student_sn')";
                $CONN->Execute($query) or trigger_error("�ӾǸ��w�g���H�ϥΡG$sql_insert", E_USER_ERROR);

                //�[�J��f���
                $sql_insert = "insert into stud_domicile (stud_id, student_sn)values('$stud_id','$student_sn')";
                $CONN->Execute($sql_insert) or trigger_error("�ӾǸ��w�g���H�ϥΡG$sql_insert", E_USER_ERROR);
                $edit = '1';

                //�M��������ƥH���ۿ�J�U�@��
                $stud_id = "";
                $stud_name = "";
                $stud_person_id = "";
                $stud_birthday = "";
                $stud_class = "";
                $stud_sex = "";

                //�h���T�{���
                $confirm_in = "";
                //$isTaichung=substr($SCHOOL_BASE['sch_id'],0,2);
                if ($isTaichung == '06' || $isTaichung == '19') {
                    echo $upload_script;
                }
            }
        }
        break;

    case $sure :
        $update_ip = getip();
        $today = date("Y-m-d G:i:s", mktime(date("G"), date("i"), date("s"), date("m"), date("d"), date("Y")));
        //�Hmove_id���ostudent_sn
        $query = "select student_sn from stud_move where move_id='$move_id'";
        $res = $CONN->Execute($query);
        $student_sn = $res->fields['student_sn'];
        $sql_update = "update stud_move set move_year_seme='$curr_seme',move_date='$move_date',move_c_unit='$move_c_unit',move_c_date='$move_c_date',move_c_word='$move_c_word',move_c_num='$move_c_num',update_time='$today',update_id='" . $_SESSION['session_log_id'] . "',update_ip='$update_ip',city='$city',school='$school',school_id='$school_id',reason='$reason' where move_id='$move_id'";
        $CONN->Execute($sql_update) or die($sql_update);
        $sql = "select max(seme_num) as mm from stud_seme where seme_class='$temp_class_no_num' and seme_year_seme='$seme_year_seme'";
        $rs = $CONN->Execute($sql) or die($sql);
        $new_site_num = intval($rs->fields[0]) + 1;
        $rs = $CONN->Execute("select c_name from school_class where class_id='$stud_class' and enable=1");
        $seme_class_name = $rs->fields[c_name];
        $stud_study_year = curr_year();
        //$sql="select student_sn from stud_base where stud_id='$stud_id' and stud_study_year= $stud_study_year";   
        //$rs=$CONN->Execute($sql) or die($sql);   
        //$student_sn=$rs->fields['student_sn']; 		
        //---���ˬdstud_seme���O�_�����,�Y������ seme_num ���i���
        $query = "select seme_num from stud_seme where stud_id ='$stud_id' and seme_year_seme='$seme_year_seme'";
        $rs = $CONN->Execute($query) or die($query);
        if ($rs and $ro = $rs->FetchNextObject(false)) {
            $new_site_num = $ro->seme_num;
        }
        $query = "delete from stud_seme where student_sn=$student_sn and seme_year_seme='$seme_year_seme'";
        $CONN->Execute($query)or die($query);
        $sql_insert = "insert into stud_seme (seme_year_seme,stud_id,seme_class,seme_class_name,seme_num,student_sn) values('$seme_year_seme','$stud_id','$temp_class_no_num','$seme_class_name','$new_site_num','$student_sn')";
        $CONN->Execute($sql_insert) or die($sql_insert);
        $sql_update = "update stud_base set stud_name='$stud_name',stud_person_id='$stud_person_id',stud_birthday='$stud_birthday' where student_sn='$student_sn'";
        $CONN->Execute($sql_update) or die($sql_update);
        $edit = '1';

        //�M��������ƥH���ۿ�J�U�@��
        $stud_id = "";
        $stud_name = "";
        $stud_person_id = "";
        $stud_birthday = "";
        $stud_class = "";
        $stud_sex = "";
        if ($isTaichung == '06' || $isTaichung == '19') {
            echo $upload_script;
        }
        break;

    case "edit" :
        $sql = "select * from stud_move where move_id='$move_id'";
        $rs = $CONN->Execute($sql) or die($sql);
        $move_kind = $rs->fields['move_kind'];
        if ($move_kind != '2')
            break;
        $n_stud_id = $rs->fields['stud_id'];
        $student_sn = $rs->fields['student_sn'];
        if ($stud_id != $n_stud_id) {
            $stud_id = $n_stud_id;
            $curr_seme = $rs->fields['move_year_seme'];
            $move_date = $rs->fields['move_date'];
            $move_c_unit = $rs->fields['move_c_unit'];
            $move_c_date = $rs->fields['move_c_date'];
            $move_c_word = $rs->fields['move_c_word'];
            $move_c_num = $rs->fields['move_c_num'];
            $city = $rs->fields['city'];
            $school = $rs->fields['school'];
            $school_id = $rs->fields['school_id'];
            $reason = $rs->fields['reason'];
            $curr_seme_temp = sprintf("%04d", $curr_seme);
            $query = "select * from stud_seme where seme_year_seme='$curr_seme_temp' and student_sn='$student_sn'";
            $res = $CONN->Execute($query);
            $seme_class = $res->fields['seme_class'];
            $query = "select stud_name,stud_person_id,stud_birthday,stud_sex from stud_base where student_sn='$student_sn'";
            $res = $CONN->Execute($query);
            $stud_name = $res->fields['stud_name'];
            $stud_person_id = $res->fields['stud_person_id'];
            $stud_birthday = $res->fields['stud_birthday'];

            $stud_sex = $res->fields['stud_sex'];
            $stud_class = sprintf("%03d_%d_%02d_%02d", substr($curr_seme_temp, 0, 3), substr($curr_seme_temp, -1, 1), substr($seme_class, 0, 1), substr($seme_class, 1, 2));
        }
        $postInBtn = $sure;
        $edit = '1';
        break;

    case "delete" :
        $query = "select * from stud_move where move_id ='$move_id'";
        $res = $CONN->Execute($query) or die($query);
        $student_sn = $res->fields['student_sn'];
        $query = "delete from stud_move where move_id ='$move_id'";
        $CONN->Execute($query) or die($query);
        $query = "delete from stud_base where student_sn ='$student_sn'";
        $CONN->Execute($query) or die($query);
        $query = "delete from stud_domicile where student_sn ='$student_sn'";
        $CONN->Execute($query) or die($query);
        $query = "delete from stud_seme where student_sn ='$student_sn'";
        $CONN->Execute($query) or die($query);
        if ($isTaichung == '06' || $isTaichung == '19') {
            echo $upload_script;
        }
        break;

    case $clean :
        $stud_id = "";
        $stud_name = "";
        $stud_person_id = "";
        $stud_birthday = "";
        $stud_class = "";
        $move_date = "";
        $move_c_word = $default_word;
        $move_c_unit = $default_unit;
        $move_c_date = "";
        $reason = $default_reason;
        $stud_sex = "";
        break;
}

$query = "select * from stud_move order by move_id desc";
$CONN->Execute($query) or die($query);
//����T
$field_data = get_field_info("stud_move");

//�L�X���Y
head();
print_menu($student_menu_p);
?>
<script language="JavaScript">

    function doUploadScript() {
<?php
echo $do_upload_script;
?>

    }

    function checkok()
    {
        var OK = true;
        if (document.myform.stud_class.value == 0)
        {
            alert('����ܯZ��');
            OK = false;
        }
        if (document.myform.stud_id.value == '')
        {
            alert('�Ǹ�����J');
            OK = false;
        }
        if (document.myform.stud_name.value == '')
        {
            alert('�m�W����J');
            OK = false;
        }
        if (document.myform.stud_person_id.value == '')
        {
            alert('�����Ҧr������J');
            OK = false;
        }
        if (document.myform.stud_birthday.value == '')
        {
            alert('�X�ͦ~��饼��J');
            OK = false;
        }
        if (!document.myform.stud_sex[0].checked && !document.myform.stud_sex[1].checked)
        {
            alert('�ʧO�����');
            OK = false;
        }
        if (document.myform.city.value == '')
        {
            alert('��NŪ��������J');
            OK = false;
        }
        if (document.myform.school.value == '')
        {
            alert('��NŪ�Ǯե���J');
            OK = false;
        }
        if (document.myform.school_id.value == '')
        {
            alert('��NŪ�ǮձШ|���N�X����J');
            OK = false;
        }
        return OK
    }


    function setfocus(element) {
        element.focus();
        return;
    }


    function openModal(studentnewsn, stud_name, stud_id, stud_birthday, stud_in_class, stud_out_school_info)
    {
        var para = studentnewsn + ';' + stud_name.trim() + ';' + stud_id + ';' + stud_birthday + ';' + stud_in_class.trim() + ';' + stud_out_school_info.trim() + ';' + '<?php echo $SCHOOL_BASE["sch_cname_ss"] . '(' . $SCHOOL_BASE['sch_id'] . ')'; ?>';
        para = encodeURIComponent(para);
        var targeturi = encodeURI("<?php echo $SFS_PATH_HTML; ?>modules/stud_move/session_in.php?para=" + para);
        window.open(targeturi);
    }

//-->
</script>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td width="100%" valign=top bgcolor="#CCCCCC">
            <form name ="myform" action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post" >
                <table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
                    <tr>
                        <td class=title_mbody colspan=2 align=center > �ǥ���J�@�~ </td>
                    </tr>
                    <tr><?php echo $confirm_in ?>
                        <td align="right" class="title_sbody2">��ܾǴ�</td>
                        <td>
                            <?php
                            //�C�X�Ǵ�
                            $class_seme_p = get_class_seme(); //�Ǧ~��	
                            $seme_temp = "<select name=\"curr_seme\" onchange=\"this.form.submit()\">\n";
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
                        <td class="title_sbody2">��ܯZ��</td>
                        <td>
                            <?php
                            if ($_GET['key'] == "edit") {
                                $temp_arr = explode("_", $stud_class);
                                $temp_class_arr = class_base();
                                echo $temp_class_arr[intval($temp_arr[2]) . $temp_arr[3]];
                                echo "<input type=\"hidden\" name=\"stud_class\" value=\"$stud_class\">";
                            } else {
                                $sel1 = new drop_select(); //������O
                                if ($stud_class) {
                                    $temp_arr = explode("_", $stud_class);
                                    $temp_year = intval($temp_arr[2]);
                                    $temp_seme = $temp_arr[0] . $temp_arr[1];

                                    //����ɯžǥͪ�stud_id �H�K�ư�
                                    $stud_id_list = '';
                                    $query = "select stud_id from stud_move where move_kind='9' and year(now())-year(update_time)<7";
                                    $result = $CONN->Execute($query) or die($query);
                                    while (!$result->EOF) {
                                        $stud_id_list.="'{$result->fields[0]}',";
                                        $result->MoveNext();
                                    }
                                    if ($stud_id_list) {
                                        $stud_id_list = substr($stud_id_list, 0, -1);
                                        $stud_id_list = "and (not stud_id in ($stud_id_list))";
                                    }

                                    //$query = "select max(stud_id) as mm,length(max(stud_id)) as max_length from stud_seme where seme_class like '$temp_year%' and seme_year_seme='$temp_seme' $stud_id_list";
                                    //�ץ���p����99�~�M100�~�ǥͦb���ʮɤ���Ǹ��j�p�|�X�����D
                                    //$query = "select max(cast(stud_id as unsigned)) as mm,length(max(cast(stud_id as unsigned))) as max_length from stud_seme where seme_class like '$temp_year%' and seme_year_seme= '$temp_seme' $stud_id_list";
                                    //2015.03.03 by smallduh �אּ�H�J�Ǧ~���Ҧ��Ǹ��@���P�_�s�Ǹ����̾�
                                    //�P�_���Ǵ����~�Ū��J�Ǧ~
                                    $curr_year = substr($temp_seme, 0, 3);
                                    $stud_study_year = ($IS_JHORES == 6) ? ($curr_year - ($temp_year - 7)) : ($curr_year - ($temp_year - 1));
                                    $query = "select max(cast(stud_id as unsigned)) as mm,length(max(cast(stud_id as unsigned))) as max_length from stud_base where stud_study_year='$stud_study_year' $stud_id_list";

                                    $result = $CONN->Execute($query) or die($query);



                                    //�ץ��ꤤ�Ǹ��H0�}�Y�����D(�J�Ǧ~�ק��Ƭ�0�ɪ����D,�Ҧp:100,90��)
                                    //�e�@�B�J���X���̤j�ȬOunsigned��,�e����0�|�Q����
                                    if ($result->fields[1] == 3) {
                                        $result->fields[1] = 5;
                                    }


                                    $max_length = '%0' . $result->fields[1] . 'd';

                                    $max_stud_id = sprintf($max_length, $result->fields[0] + 1);

                                    if ($edit == '' || $stud_id == '') {
                                        $stud_id = $max_stud_id;
                                    }
                                    $sel1->id = $stud_class;
                                }
                                //�C�X�Z��		
                                echo get_class_select($sel_year, $sel_seme, "", "stud_class", "this.form.submit", $stud_class);
                            }
                            ?>	 
                        </td>
                    </tr>
                    <tr>
                        <td align="right" CLASS="title_sbody2"><?php echo $field_data[stud_id][d_field_cname] ?></td>
                        <?php
                        if ($stud_id != $max_stud_id) {
                            echo "<td>$stud_id</td>";
                        } else {
                            echo "<td><input type='text' name='stud_id' value=$stud_id></td>";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td align="right" CLASS="title_sbody2"><?php echo $field_data[move_date][d_field_cname] ?></td>
                        <td> ���� <input type="text" size="10" maxlength="10" name="move_date" value="<?php echo DtoCh($move_date) ?>"></td>
                    </tr>
                    <tr>
                        <td class="title_sbody2">�ǥͩm�W</td>
                        <td><input type="text" size="10" maxlength="20" name="stud_name" value="<?php echo $stud_name ?>"></td>
                    </tr>
                    <tr>
                        <td class="title_sbody2">�����Ҧr��</td>
                        <td><input type="text" size="10" maxlength="20" name="stud_person_id" value="<?php echo $stud_person_id ?>"></td>
                    </tr>
                    <tr>
                        <td align="right" CLASS="title_sbody2">�X�ͦ~���</td>
                        <td> ���� <input type="text" size="10" maxlength="10" name="stud_birthday" value="<?php echo DtoCh($stud_birthday) ?>"></td>
                    </tr>
                    <tr>
                        <td class="title_sbody2">�ʧO</td>
                        <td><input type="radio" name="stud_sex" value="1" <?php if ($stud_sex == '1') echo 'checked' ?>>�k &nbsp;&nbsp;<input type="radio" name="stud_sex" value="2" <?php if ($stud_sex == '2') echo 'checked' ?>>�k 
                        </td>
                    </tr>
                    <tr>
                        <td align="right" CLASS="title_sbody1">�п�ܭ�NŪ�Ǯ�</td>
                        <td><SELECT  NAME="selectcity" onChange="SelectCity();" ><Option value="">�п�ܿ���</option></SELECT>&nbsp;<SELECT  NAME="selectdistrict" onChange="SelectDistrict();" ><Option value="">�п�ܰϰ�</option></SELECT>&nbsp;<SELECT NAME="selectschool" onchange="disp_text();"><Option value="">�п�ܾǮ�</option></SELECT></td>
                    </tr>

                    <tr>
                        <td align="right" CLASS="title_sbody1">��NŪ����</td>
                        <td><input type="text" size="20" maxlength="20" name="city" value="<?php echo $city ?>" readonly></td>
                    </tr>
                    <tr>
                        <td align="right" CLASS="title_sbody1">��NŪ�Ǯ�</td>
                        <td><input type="text" size="20" maxlength="20" name="school" value="<?php echo $school ?>" readonly></td>
                    </tr>
                    <tr> 
                        <td align="right" CLASS="title_sbody1">��NŪ�ǮձШ|���N�X</td>   
                        <td><input type="text" size="10" maxlength="6" name="school_id" value="<?php echo $school_id ?>" readonly></td>   
                    </tr> 

                    <tr>
                        <td align="right" CLASS="title_sbody1">�J�ǮɾǮ�</td>
                        <td><input type="text" size="20" maxlength="20" name="enroll_school" value="<?php echo $enroll_school ?>"></td>
                    </tr>
                    <tr>
                        <td align="right" CLASS="title_sbody1">��J��]</td>
                        <td><input type="text" size="40" maxlength="40" name="reason" value="<?php echo $reason ?>"></td>
                    </tr>
                    <tr>
                        <td align="right" CLASS="title_sbody1"><?php echo $field_data[move_c_unit][d_field_cname] ?></td>
                        <td><input type="text" size="30" maxlength="30" name="move_c_unit" value="<?php echo $move_c_unit ?>"></td>
                    </tr>
                    <tr>
                        <td align="right" CLASS="title_sbody1"><?php echo $field_data[move_c_date][d_field_cname] ?></td>
                        <td> ���� <input type="text" size="10" maxlength="10" name="move_c_date" value="<?php echo DtoCh($move_c_date) ?>"></td>
                    </tr>
                    <tr>
                        <td align="right" CLASS="title_sbody1"><?php echo $field_data[move_c_word][d_field_cname] ?></td>
                        <td><input type="text" size="20" maxlength="20" name="move_c_word" value="<?php echo $move_c_word ?>">�r</td>
                    </tr>
                    <tr>
                        <td align="right" CLASS="title_sbody1"><?php echo $field_data[move_c_num][d_field_cname] ?></td>
                        <td>��<input type="text" size="14" maxlength="14" name="move_c_num" value="<?php echo $move_c_num ?>">��</td>
                    </tr>
                    <tr>
                        <td width="100%" align="center"  colspan="5" >
                            <?php
                            echo "<input type='submit' name='key' value =\"$postInBtn\" onClick=\"return checkok();\">";
                            if ($edit == '1')
                                echo "<input type='hidden' name='kkey' value='edit'>
      			<input type='hidden' name='move_id' value='$move_id'>
      			<input type='hidden' name='stud_id' value='$stud_id'>
			<input type='submit' name='key' value='$clean'>
			";
                            ?>
                        </td>
                    </tr>
                </table>
   �@</td>
    </tr>
    <TR>
        <TD>
            <?php
            $seme_year_seme = sprintf("%04d", $curr_seme);
            $query = "select a.*,b.stud_name,b.stud_person_id,b.stud_birthday from stud_move a ,stud_base b where a.student_sn=b.student_sn and a.move_year_seme='$curr_seme' and a.move_kind=2 order by a.move_date desc,a.stud_id desc";
            $result = $CONN->Execute($query) or die($query);
            if (!$result->EOF) {
                echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"2\" bordercolorlight=\"#333354\" bordercolordark=\"#FFFFFF\" width=\"100%\" class=main_body >";
                if ($isTaichung == '06' || $isTaichung == '19') {
                    echo "<tr><td colspan=11 class=title_top1 align=center ><button onclick=\"doUploadScript()\">���ڤW�ǥ��Ǵ��ǥͲ��ʸ�ƦܻO�����N�Ǻޱ��t��</button></td></tr>";
                }
                echo "<tr><td colspan=11 class=title_top1 align=center >���Ǵ���J�ǥ�</td></tr>";
                echo "
			<TR class=title_mbody >
				<TD  align='center'>��J���</TD>
				<TD align='center'>�Ǹ�</TD>
				<TD align='center'>�m�W</TD>
				<TD align='center'>�����Ҧr��</TD>
				<TD align='center'>�X�ͦ~���</TD>
				<TD  align='center'>��J�Z��</TD>
				<TD align='center'>�֭���</TD>
				<TD align='center'>�r��</TD>
				<TD rowspan=2 align='center'>��NŪ����</TD>
				<TD rowspan=2 align='center'>�s��</TD>
                                <TD rowspan=2 align='center'>XML�۰ʶפJ</TD>
			</TR>
			<TR class=title_mbody >
				<TD colspan=7 align='center'>��J��]</TD><TD align='center'>��NŪ�Ǯ�</TD>
			</TR>";
            }
            while (!$result->EOF) {
                $move_id = $result->fields["move_id"];
                $stud_id = $result->fields["stud_id"];
                $student_sn = $result->fields["student_sn"];
                $stud_name = $result->fields["stud_name"];
                $stud_person_id = $result->fields["stud_person_id"];
                $stud_birthday = $result->fields["stud_birthday"];
                $move_year_seme = $result->fields["move_year_seme"];
                $class_list_p = class_base($seme_year_seme);
                $sql = "select * from stud_seme where student_sn='$student_sn' and seme_year_seme='$seme_year_seme'";
                $rs = $CONN->Execute($sql);
                $class_num = $rs->fields["seme_class"];
                $stud_clss = $class_list_p[$class_num];
                $move_date = $result->fields["move_date"];
                $move_c_date = $result->fields["move_c_date"];
                $move_c_unit = $result->fields["move_c_unit"];
                $move_c_word = $result->fields["move_c_word"];
                $move_c_num = $result->fields["move_c_num"];
                $class_num = sprintf("%03s_%s_%02s_%02s", substr($seme_year_seme, 0, 3), substr($seme_year_seme, -1, 1), substr($class_num, 0, 1), substr($class_num, 1, 2));
                $city = ($result->fields["city"]) ? $result->fields["city"] : "&nbsp;";
                $school = ($result->fields["school"]) ? $result->fields["school"] : "&nbsp;";
                $school_id = $result->fields["school_id"];
                //$edit_data = $SFS_PATH_HTML."modules/stud_reg/stud_list.php?student_sn=$student_sn&c_curr_class=$class_num&c_curr_seme=$curr_seme_temp";
                $edit_data = $SFS_PATH_HTML . "modules/toxml/import_xml.php";
                echo ($i++ % 4 > 1) ? "<TR class=nom_1>" : "<TR class=nom_2>";
                echo "			
					<TD>$move_date</TD>
					<TD>$stud_id</TD>
					<TD>$stud_name</TD>
					<TD>$stud_person_id</TD>
					<TD>$stud_birthday</TD>
					<TD>$stud_clss</TD>					
					<TD>$move_c_unit</TD>
					<TD>" . DtoCh($move_c_date) . " " . $move_c_word . "�r��" . $move_c_num . "��</TD>
					<TD rowspan=2 align='center'>$city</TD>
					<TD rowspan=2>
					<a href=\"{$_SERVER['SCRIPT_NAME']}?key=edit&move_id=$move_id&stud_id=$stud_id&curr_seme=$seme_year_seme\">�s��</a> 
					<a href=\"{$_SERVER['SCRIPT_NAME']}?key=delete&move_id=$move_id&stud_id=$stud_id&curr_seme=$seme_year_seme\" onClick=\"return confirm('�T�w�R�� $stud_name ?');\">�R��</a>
					<a href=\"$edit_data\" target='_BLANK'>��Ƹɵn</a>
					</TD>
					<TD rowspan=2 align='center'><input type='button' value='�۰ʶפJ' onclick='openModal(\"$stud_id\",\"$stud_name\",\"$stud_person_id\",\"$stud_birthday\",\"$stud_clss" . (($stud_clss == "") ? "" : "") . "\",\"$school_id-$city-$school\");'></TD>
				</TR>";
                echo ($i++ % 4 > 1) ? "<TR class=nom_1>" : "<TR class=nom_2>";
                echo "<TD colspan=7>" . $result->fields["reason"] . "�@</TD><TD>$school_id $school</TD></TR>";
                $result->moveNext();
            }
            ?>
</table>
</TD>
</TR>
<TR>
    <TD></TD>
</TR>

</table>
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

