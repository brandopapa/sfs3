<?php

// $Id: sfs_core_html.php 5310 2009-01-10 07:57:56Z hami $

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
