<?php

// $Id: sfs_core_html.php 5310 2009-01-10 07:57:56Z hami $

//頁面標頭
function head($logo_title="",$logo_image="",$show_logo=0,$show_left_menu=1) {
    global $SFS_PATH_HTML,$THEME_FILE,$THEME_URL,$SCHOOL_BASE,$UPLOAD_PATH,$UPLOAD_URL,$SFS_IS_HIDDEN_TITLE,$ENABLE_AJAX,$ON_LOAD;
	if (!isset($_SESSION['session_log_id'])) {
		session_start();
	}
	else
		check_user_state();
	require_once "$THEME_FILE"."_header.php";
}

//頁面結尾
function foot($foot_str="") {
    global  $SFS_PATH_HTML,$THEME_FILE;
	require_once "$THEME_FILE"."_footer.php";
}

//頁面佈景
function sfs_themes() {
    global $THEME_FILE ;
	if (is_file ("$THEME_FILE"."_function.php"))
		require_once "$THEME_FILE"."_function.php";
}


//傳回 themes 圖檔路徑
function get_themes_img($img) {	
    global $SFS_PATH_HTML,$SFS_THEME;
	if (!$img) user_error("沒有傳入參數！請檢查。",256);
	return "$SFS_PATH_HTML"."themes/$SFS_THEME/images/$img";
}


?>
