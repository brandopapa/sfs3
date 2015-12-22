<?php

// $Id: sfs_core_html.php 8623 2015-12-06 05:26:01Z qfon $

//�������Y
function head($logo_title="",$logo_image="",$show_logo=0,$show_left_menu=1) {
    global $SFS_PATH_HTML,$THEME_FILE,$THEME_URL,$SCHOOL_BASE,$UPLOAD_PATH,$UPLOAD_URL,$SFS_IS_HIDDEN_TITLE,$ENABLE_AJAX,$ON_LOAD;
	if (!isset($_SESSION['session_log_id'])) {
		session_start();
	}
	else
		check_user_state();
	require_once "$THEME_FILE"."_header.php";
}

//��X�޲z�̩m�W
function get_admin_name()
{
global $CONN;

$sql_pro_check="select b.teacher_sn from pro_check_new as a inner join teacher_post as b on b.teach_title_id=a.id_sn and a.pro_kind_id='1' and a.id_kind='¾��'";
$rs_pro_check=$CONN->Execute($sql_pro_check);

while(!$rs_pro_check->EOF)
{
$tsn=$rs_pro_check->fields['teacher_sn'];
$sql_pro_check1="select distinct name from teacher_base where teach_condition=0 and teacher_sn=$tsn";
$rs_pro_check1=$CONN->Execute($sql_pro_check1);
$rootnamearray[]=$rs_pro_check1->fields['name'];
$rs_pro_check->MoveNext();
}

$sql_pro_check="select b.name from pro_check_new as a inner join teacher_base as b on b.teacher_sn=a.id_sn and a.pro_kind_id='1' and a.id_kind='�Юv'";
$rs_pro_check=$CONN->Execute($sql_pro_check);

while(!$rs_pro_check->EOF)
{
$rootnamearray[]=$rs_pro_check->fields['name'];
$rs_pro_check->MoveNext();
}

//�h�����ƦW�r
$rootnamearray=array_unique($rootnamearray);

while (list($key, $value) = each($rootnamearray)) 
{
$name.=$value."&nbsp;&nbsp;";
}

return "���ޤH��:".$name; 
}


//��������
function foot($foot_str="") {
    global  $SFS_PATH_HTML,$THEME_FILE;
	require_once "$THEME_FILE"."_footer.php";
}

//�����G��
function sfs_themes() {
    global $THEME_FILE ;
	if (is_file ("$THEME_FILE"."_function.php"))
		require_once "$THEME_FILE"."_function.php";
}


//�Ǧ^ themes ���ɸ��|
function get_themes_img($img) {	
    global $SFS_PATH_HTML,$SFS_THEME;
	if (!$img) user_error("�S���ǤJ�ѼơI���ˬd�C",256);
	return "$SFS_PATH_HTML"."themes/$SFS_THEME/images/$img";
}


?>
