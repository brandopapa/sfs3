<?php

include "config.php";
//�{��
sfs_check();




//�{���ϥΪ�Smarty�˥���

if ($_POST['form_act'] == 'prt') {
    $template_file = dirname(__file__) . "/templates/sta_to_print.htm";
} else if ($_POST['form_act'] == 'prteng') {
    $template_file = dirname(__file__) . "/templates/sta_to_print_eng.htm";
}

//�إߪ���
$obj = new stud_sta($CONN, $smarty);

//��l��
$obj->init();
//�B�z�{��,���ɵ{�Ǥ���header���O,�G���{�ǩy��head("stud_sta�Ҳ�");���e
$obj->process();
$obj->display($template_file);

//����class
class stud_sta {

    var $CONN; //adodb����
    var $smarty; //smarty����
    var $set; //�Ҳճ]�w
    var $sch; //�Ǯճ]�w
    var $seme;

    //�غc�禡
    function stud_sta($CONN, $smarty) {
        $this->CONN = &$CONN;
        $this->smarty = &$smarty;
    }

    //��l��
    function init() {
        $this->set = get_sfs_module_set("stud_sta");
        $this->sch = get_school_base();
        $this->need_teacher = $_POST[need_teacher] ? "�ɮv�G__________________" : "";
    }

    //�{��
    function process() {
        if ($_POST[stu] == '' && $_GET[prove_id] == '')
            die("�L���");
        if ($_GET[prove_id] != '') {
            $this->stu[] = $this->one($_GET[prove_id]);
            return;
        }
        if ($_POST[stu] != '' && $_POST[form_act] == 'prt') {
            foreach ($_POST[stu] as $id => $null) {
                $this->stu[] = $this->one($id);
            }
//			echo "<pre>";print_r($_POST);//echo $SQL;
        }

        if ($_POST[stu] != '' && $_POST[form_act] == 'prteng') {
            foreach ($_POST[stu] as $id => $null) {
                $this->stu[] = $this->one($id);
            }
//			echo "<pre>";print_r($_POST);//echo $SQL;
        }
    }

    //���
    function display($tpl) {
        $this->smarty->assign("this", $this);
        $this->smarty->display($tpl);
    }

    //�^�����
    function one($id) {
//		$curr_seme = curr_year().curr_seme();
        global $UPLOAD_PATH, $UPLOAD_URL;
        if ($id == '')
            return;
        $SQL = "select prove_id,student_sn,prove_year_seme,prove_date from stud_sta  where prove_id='$id' ";
        $rs = &$this->CONN->Execute($SQL) or die($SQL);
        if ($rs and $ro = $rs->FetchNextObject(false)) {
            $stu1 = get_object_vars($ro);
        }
        $y_seme = $stu1[prove_year_seme]; //951
        $y_seme2 = sprintf("%04d", $stu1[prove_year_seme]); //0951
        $stu1[seme] = substr($y_seme, -1); //���Ǵ�
        $SQL = "select a.stud_name,a.stud_name_eng,a.stud_id,a.stud_birthday,b.seme_class,a.stud_study_year from stud_base a ,stud_seme b  where a.student_sn='{$stu1[student_sn]}' and a.student_sn=b.student_sn and b.seme_year_seme='$y_seme2' ";
        $rs = &$this->CONN->Execute($SQL) or die($SQL);

        if ($rs and $ro = $rs->FetchNextObject(false)) {
            $stu2 = get_object_vars($ro);
            if ($_POST['need_photo']) {
                $myphoto = $UPLOAD_PATH . "photo/student/" . $ro->stud_study_year . "/" . $ro->stud_id;
                $myphotoUrl = $UPLOAD_URL . "photo/student/" . $ro->stud_study_year . "/" . $ro->stud_id;
                if (file_exists($myphoto))
                    $stu2[photo] = "<img src='$myphotoUrl' height=200 align='left' border=1  hspace=10 vspace=10>";
                else
                    $stu2[photo] = "";
            }
            else
                $stu2[photo] = "";
        }
        $stu2["seme_class2"] = substr($stu2[seme_class], 0, 1); //���Ǵ�
        if ($stu2["seme_class2"] > 6)
            $stu2["seme_class2"] = $stu2["seme_class2"] - 6; //�ꤤ
        $stu = array_merge($stu1, $stu2);

//		echo "<pre>";print_r($stu);echo $SQL;
        return $stu;
//		echo "<pre>";print_r($this->stu);//echo $SQL;
    }

    function CD($d, $type) {
        $d = split("-", $d);
        if ($type == 'Y')
            return $d[0] - 1911;
        if ($type == 'm')
            return $d[1] + 0;
        if ($type == 'd')
            return $d[2] + 0;
    }

    function CD2($d, $type) {
        $d = split("-", $d);
        if ($type == 'Y')
            return $d[0];
        if ($type == 'm') {
            switch ($d[1]) {
                case 1:
                    return 'January';
                case 2:
                    return 'February';
                case 3:
                    return 'March';
                case 4:
                    return 'April';
                case 5:
                    return 'May';
                case 6:
                    return 'June';
                case 7:
                    return 'July';
                case 8:
                    return 'August';
                case 9:
                    return 'September';
                case 10:
                    return 'October';
                case 11:
                    return 'November';
                case 12:
                    return 'December';
            }
        }
        if ($type == 'd') {
            switch ($d[2]) {
                case 1:
                    return 'st';
                case 2:
                    return 'nd';
                case 3:
                    return 'rd';
                default:
                    return 'th';
            }
        }
        if ($type == 's') {
            switch ($d[0]) {
                case 1:
                    return 'first';
                case 2:
                    return 'second';
                case 3:
                    return 'third';
                case 4:
                    return 'forth';
                case 5:
                    return 'fifth';
                case 6:
                    return 'six';
            }
        }
    }

}

?>
