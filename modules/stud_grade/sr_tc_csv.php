<?php
//$Id:  $
//���J�]�w��
require ("config.php");

// �{���ˬd
sfs_check();

$UP_YEAR = ($IS_JHORES == 0) ? 6 : $UP_YEAR = 9; //�P�_�ꤤ�p
$do_upload_script = "var targeturi = encodeURI('" . $SFS_PATH_HTML . "modules/stud_grade/session_upload.php');window.open(targeturi);";
//�P�_�O�_�O�x�����Ǯ�
$isTaichung = substr($SCHOOL_BASE['sch_id'], 0, 2);
$postBtn = "�O�����N�Ǻޱ��t����Xcsv��";
$class_name = class_base();
if ($_POST[do_key] == $postBtn) {
    $curr_year = curr_year();
    $new_school_str = ($_POST[curr_grade_school]) ? "and g.new_school= '$_POST[curr_grade_school]'" : "";
    $str = "���~�Ǧ~��,�~��,�Z�ŦW��,���y,�����Ҧr��,�ǥͩm�W,�ʧO,�X�ͦ~,�X�ͤ�,�X�ͤ�,�J�Ǧ~,���~�r��,���@�H,�p���q��,���y�a�},�ɤJ�ꤤ,���O����\r\n";
    //��������~�͸�ƪ�
    $sql = "SELECT a.*,b.curr_class_num,b.stud_country,b.stud_person_id,b.stud_name,b.stud_sex,year(b.stud_birthday) as birth_year,month(b.stud_birthday) as birth_month,day(b.stud_birthday) as birth_day,b.stud_study_year,b.stud_addr_1,b.stud_tel_1,b.stud_addr_2,c.guardian_name FROM grad_stud a INNER JOIN stud_base b ON a.student_sn=b.student_sn INNER JOIN stud_domicile c ON a.student_sn=c.student_sn WHERE stud_grad_year='$curr_year' ORDER BY grad_num";
    $result = $CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql", 256);

    while (!$result->EOF) {
        //�Z��
        $c_name = $class_name[substr($result->fields[curr_class_num], 0, -2)];
        $str.="\"" . $curr_year . "\",";
        $str.="\"" . $result->fields['class_year'] . "\",";
        $str.="\"" . $c_name . "\",";
        $str.="\"" . $result->fields['stud_country'] . "\",";
        $str.="\"" . $result->fields['stud_person_id'] . "\",";
        $str.="\"" . $result->fields['stud_name'] . "\",";
        $str.="\"" . ($result->fields['stud_sex'] == '1' ? '�k' : '�k') . "\",";
        $str.="\"" . $result->fields['birth_year'] . "\",";
        $str.="\"" . $result->fields['birth_month'] . "\",";
        $str.="\"" . $result->fields['birth_day'] . "\",";
        $str.="\"" . $result->fields['stud_study_year'] . "\",";
        $str.="\"" . $result->fields['grad_word'] . '��' . $result->fields['grad_num'] . "��\",";
        $str.="\"" . $result->fields['guardian_name'] . "\",";
        $str.="\"" . ($result->fields['stud_tel_2'] ? $result->fields['stud_tel_2'] : $result->fields['stud_tel_1']) . "\",";
        $str.="\"" . $result->fields['stud_addr_1'] . "\",";
        $str.="\"" . $result->fields['new_school'] . "\",";
        $str.="\"\"\r\n";



        $result->MoveNext();
    }

    header("Content-disposition: attachment; filename=" . $SCHOOL_BASE[sch_cname_ss] . curr_year() . "�Ǧ~�ײ��~�͸����X-�O�����N�Ǻޱ��t��.csv");
    header("Content-type: text/x-csv");
    //header("Pragma: no-cache");
    //�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
    header("Cache-Control: max-age=0");
    header("Pragma: public");
    header("Expires: 0");

    echo $str;
    exit;
}

head();
print_menu($menu_p);
?>
<script language="JavaScript">

    function doUploadScript() {
<?php
echo $do_upload_script;
?>
    }
</script>

<fieldset>
    <legend>
        �A�α��ΡG���~�͸�ƥ������O���bSFS3�����]�Ҧp�G�S�Х͡^
    </legend> 
    <form name ="myform" action="<?php echo $PHP_SELF ?>" method="post" >

        <BR><input type="submit" name="do_key" value="<?php echo $postBtn ?>">
    </form>
</fieldset><br/>

<?php
if ($isTaichung == '06' || $isTaichung == '19') {
    $auto="<fieldset>
    <legend>
        �A�α��ΡG���~�͸�Ƨ����O���bSFS3����
    </legend>
    <button onclick=\"doUploadScript()\">���~�͸�Ʀ۰ʶפJ�O�����N�Ǻޱ��t��</button>
</fieldset>";
    echo $auto;
}
foot();
?>

