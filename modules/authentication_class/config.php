<?php
//$Id: config.php 6064 2010-08-31 12:26:33Z infodaes $
//�w�]���ޤJ�ɡA���i�����C
include_once "../../include/config.php";
require_once "./module-cfg.php";
include_once "../../include/sfs_case_dataarray.php";

//�z�i�H�ۤv�[�J�ޤJ��

//���o�ҲհѼƪ����O�]�w
$m_arr = get_module_setup("authentication");

//���o�Юv�ҳB�B��
$my_sn=$_SESSION['session_tea_sn'];
$my_name=$_SESSION['session_tea_name'];
$sql="select post_office,teach_title_id from teacher_post where teacher_sn=$my_sn;";
$rs=$CONN->Execute($sql) or die("�L�k���o�z���Ҧb�B��!<br>$sql");
$my_room_id=$rs->fields['post_office'];
$my_title=$title_kind[($rs->fields['teach_title_id'])];


//�Ǵ��O
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());
if($work_year_seme=='') $work_year_seme = $curr_year_seme;

//���o�B�ǰ}�C
$room_kind_array=room_kind();

//���o�Юv�}�C
$teacher_array=teacher_array();
asort($teacher_array);
foreach($teacher_array as $sn=>$name) $teacher_option.="<option value=$sn> $name </option>";

// ���X�Z�ŦW�ٰ}�C
$class_base=class_base($work_year_seme);


//���o�Юv�ҤW�~�šB�Z��
$session_tea_sn = $_SESSION['session_tea_sn'];
$query="select class_num  from teacher_post where teacher_sn='$session_tea_sn'";
$result=$CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);
$row=$result->FetchRow();
$my_class_id=$row["class_num"];
$my_class_grade=substr($my_class_id,0,-2);

?>
