<?php
include_once "../../include/config.php";
include_once "../../include/sfs_case_PLlib.php";
include_once "select_data_function.php";
include_once "module-upgrade.php";

/* �W���ɮ׼Ȧs�ؿ� */
$path_str = "temp/student/";
set_upload_path($path_str);
$temp_path = $UPLOAD_PATH.$path_str;

$menu_p = array("basic_test_stu.php"=>"�ǥͰ���W�U","basic_test_data.php"=>"�ǥͰ�����","setup.php"=>"�S�ب����]�w","dis_stud.php"=>"�K�վǥ͸�ƺ޲z","distest5.php"=>"102�K�դJ��","score_input.php"=>"�w�Ҹɵn","distest4.php"=>"100�˰e","chart.php"=>"�K�ճ���","setup2.php"=>"�аO���ɥ�");

//���o�����m��}�C
function get_zip_arr() {
	global $CONN;
	$query = "select zip,country,town from stud_addr_zip order by zip";
	$res= $CONN->Execute($query) or trigger_error("�y�k���~!",E_USER_ERROR);
	while(!$res->EOF){
		$zip_arr[$res->fields[0]] = $res->fields[1].$res->fields[2];
		$res->MoveNext();
	}
	return $zip_arr;
}

//���o�ϥN�X
$area2_arr = array("01"=>"01","03"=>"03","05"=>"05","06"=>"06","07"=>"07","08"=>"08","09"=>"09","10"=>"10","11"=>"11","12"=>"12","13"=>"13","14"=>"14","15"=>"15","16"=>"16","17"=>"17");

//101�~�[����Ұ}�C
//�̧Ǭ��L�]�w, �����L�ڻy, �������ڻy, ���<1�Ǵ�, ���<1�Ǧ~, ���<2�Ǧ~, ���<3�Ǧ~, ���~<1�Ǵ�, ���~<1�Ǧ~, ���~<2�Ǧ~, ���~<3�Ǧ~, �X��, ����
$plus_arr=array(0=>0,1=>10,2=>35,3=>25,4=>20,5=>15,6=>10,7=>25,8=>20,9=>15,'A'=>10,'B'=>25,'C'=>25);

//�ҰϥN�X���
$area_arr = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18");
$area_sel .= "�ϽX�G<select name='area'>\n";
while(list($v,$t)= each ($area_arr)) {
	$v = $v+1;
	$selected = ($_POST['area']==$v)?"selected":"";
	$area_sel .= "<option value=".$v." $selected>".$t."</option>\n";
}             	 
$area_sel .= "</select>\n";
$parent_arr = array("1"=>"���@�H","2"=>"����","3"=>"����");
$phone_arr = array("1"=>"���y�q��","2"=>"�s���q��","3"=>"��ʹq��");
$address_arr = array("1"=>"���y��}","2"=>"�s����}");

//�n�B�z���ǥʹN�Ǫ��p
$cal_str="'0','15'";

//�P�_���C���J�ᨭ���O
$type61="";
$have61=0;
$query="select * from sfs_text where t_kind='stud_kind' and t_name='���C���J��'";
$res=$CONN->Execute($query);
if (intval($res->fields['d_id'])>0) {
	$type61=intval($res->fields['d_id']);
	$have61=1;
} else {
	$type61="-1";
}
?>
