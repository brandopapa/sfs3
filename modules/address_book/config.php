<?php
//$Id: config.php 6064 2010-08-31 12:26:33Z infodaes $
include_once "../../include/config.php";
include_once "../../include/sfs_case_dataarray.php";
require_once "./module-cfg.php";
//require_once "./module-upgrade.php";

//���o�ҲհѼƪ����O�]�w
$m_arr =&get_module_setup("address_book");

$sex_arr= array(1=>"�k" ,2 =>"�k") ;
$room_kind=room_kind();
$title_kind=title_kind();
$birth_place_array=birth_state();
$class_name_arr = class_base() ;
$guardian_relation=guardian_relation();
$is_live=is_live();
$blood_arr=blood();
$obtain_arr=stud_obtain_kind();
$safeguard_arr=stud_safeguard_kind();


//���o�Юv�ҳB�B��
$my_sn=$_SESSION['session_tea_sn'];
$my_name=$_SESSION['session_tea_name'];
$sql="select post_office,teach_title_id from teacher_post where teacher_sn=$my_sn;";
$rs=$CONN->Execute($sql) or die("�L�k���o�z���Ҧb�B��!<br>$sql");
$my_room=$room_kind[($rs->fields['post_office'])];
$my_title=$title_kind[($rs->fields['teach_title_id'])];

//echo $my_room;
//print_r($room_kind);

//�]�w�i������O
$nature_array=array('student'=>'�ǥ�','teacher'=>'�Юv');
$nature=$_POST['nature']?$_POST['nature']:'student';

//�D�Ҳպ޲z���T�ζ��ظT��
$forbid=$nature.'_forbid';
$forbid=$m_arr[$forbid];

$nature_radio="<hr>�����O:";
foreach($nature_array as $key=>$value)
{
	$nature_selected=$key==$nature?'checked':'';
	$nature_radio.="<input type='radio' value='$key' name='nature' $nature_selected  onclick='this.form.target_sn.value=\"\"; this.form.act.value=\"\"; this.form.action=\"$_SERVER[SCRIPT_NAME]\"; this.form.target=\"_self\"; this.form.submit();'>$value";
}

//�w�q�i�����
switch ($nature) {
    case 'student':
        $fields_array=array('a.class_id'=>'�Z�ťN��','a.class_name'=>'�Z�ŦW��','a.grade'=>'�~��','a.curr_class_num'=>'�y��','a.stud_id'=>'�Ǹ�','a.stud_name'=>'�ǥͩm�W','a.stud_name_eng'=>'�ǥͭ^��m�W','a.stud_sex'=>'�ʧO','a.stud_person_id'=>'�����Ҧr��','a.stud_blood_type'=>'�嫬','a.stud_country'=>'���y','a.addr_zip'=>'�l���ϸ�','a.stud_addr_1'=>'���y�a�}','a.stud_addr_2'=>'�p���a�}','a.stud_birthday'=>'�X�ͦ~���','a.year'=>'�X�ͦ~','a.month'=>'�X�ͤ�','a.day'=>'�X�ͤ�','a.stud_tel_1'=>'���y�q��','a.stud_tel_2'=>'�p���q��','a.stud_tel_3'=>'��ʹq��','a.stud_study_year'=>'�J�Ǧ~','a.stud_preschool_name'=>'�J�ǫe���X��','a.stud_mschool_name'=>'�J�ǫe��p','a.addr_move_in'=>'���y�E�J���','a.enroll_school'=>'�J�ǾǮ�','a.stud_birth_place'=>'�X�ͦa','a.obtain'=>'���y���o��]','a.safeguard'=>'�Ӯ׫O�@���O','b.fath_name'=>'���˩m�W','b.fath_alive'=>'���˦s�\\','b.fath_birthyear'=>'��_�~��','b.fath_occupation'=>'��_¾�~','b.fath_unit'=>'��_�A�ȳ��','b.fath_work_name'=>'��_¾��','b.fath_hand_phone'=>'��_��ʹq��','b.moth_name'=>'���˩m�W','b.moth_alive'=>'���˦s�\\','b.moth_birthyear'=>'��_�~��','b.moth_occupation'=>'��_¾�~','b.moth_unit'=>'��_�A�ȳ��','b.moth_work_name'=>'��_¾��','b.moth_hand_phone'=>'��_��ʹq��','b.guardian_name'=>'���@�H�m�W','b.guardian_relation'=>'�P���@�H���Y','b.guardian_email'=>'���@�H_�q�l�l��','b.guardian_unit'=>'���@�H_�A�ȳ��','b.guardian_work_name'=>'���@�H_¾��','b.guardian_hand_phone'=>'���@�H_��ʹq��','b.grandfath_name'=>'�����m�W','b.grandfath_alive'=>'�����s�\\','b.grandmoth_name'=>'�����m�W','b.grandmoth_alive'=>'�����s�\\');
        break;
    case 'teacher':
        $fields_array=array('a.teacher_sn'=>'�t�νs��','a.teach_id'=>'�N��','a.teach_person_id'=>'�����Ҧr��','a.name'=>'�m�W','a.sex'=>'�ʧO','a.birthday'=>'�X�ͦ~���','a.birth_place'=>'�X�ͦa','a.address'=>'�a�}','a.home_phone'=>'�a�x�q��','a.cell_phone'=>'��ʹq��','b.email'=>'�q�l�l��');
        break;
}

$curr_year_seme=$_POST['seme_year_seme']?$_POST['seme_year_seme']:sprintf('%03d%d',curr_year(),curr_seme());
$curr_year=intval(substr($curr_year_seme,0,3));
$curr_seme=intval(substr($curr_year_seme,-1));
$page_break ="<P style='page-break-after:always'>&nbsp;</P>";

?>
