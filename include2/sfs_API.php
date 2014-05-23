<?php
	if (!session_id()) session_start();
// $Id: sfs_API.php 6781 2012-05-30 07:30:43Z brucelyc $
// ���ɬ��֤ߨ禡�w�W�h�ɡA
// �Y�D���n�A�ХѬ����֤ߨ禡�w�h�s�W�ק���@�C

	// �ɶ�����
	require_once( "sfs_core_time.php" );
	// �t�άɭ�/themes
	require_once( "sfs_core_html.php" );
	// �{�Ҩ禡
	require_once( "sfs_core_auth.php" );
	// �Ҳլ���
	require_once( "sfs_core_module.php" );
	// ���o�Ǯդ��������
	require_once( "sfs_core_schooldata.php" );
	// �t�οﶵ��r
	require_once( "sfs_core_systext.php" );
	// ���o���|���
	require_once( "sfs_core_path.php" );
	// �t�ο�����
	require_once( "sfs_core_menu.php" );
	// �O���ɬ���
	require_once( "sfs_core_log.php" );
	// �T������
	require_once( "sfs_core_msg.php" );
	// sql ��Ʈw����
	require_once( "sfs_core_sql.php" );
	// ������T ����
	require_once( "sfs_core_version.php" );

	// �t�������ܼ�
	$HTTP_REFERER = $_SERVER['HTTP_REFERER'];
	$THEME_FILE = "$SFS_PATH/themes/$SFS_THEME/$SFS_THEME";
	$THEME_URL = "$SFS_PATH_HTML"."themes/$SFS_THEME";
	$SFS_BIGIN_TIME = microtime(); //�t�ζ}�l�ɶ�

	//�n�Jip
	if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
		$REMOTE_ADDR=$_SERVER["HTTP_CLIENT_IP"];
	} elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
		//���g�L�N�z���A��
		$temp_ip=split(",",$_SERVER["HTTP_X_FORWARDED_FOR"]);
		$REMOTE_ADDR=$temp_ip[0];
	} else {
		$REMOTE_ADDR=$_SERVER["REMOTE_ADDR"];
	}

	// �w�q���~���A
	define("FATAL", E_USER_ERROR);
	define("ERROR", E_USER_WARNING);
	define("WARNING", E_USER_NOTICE);

	// set the error reporting level for this script
	error_reporting(FATAL | ERROR | WARNING);

	// ���J�ɭ��Ҳ�
	sfs_themes();

	//�ɶ��]�w�Ψ��
	set_now_niceDate();

	// �ˬd register_globals �O�_���}
	//check_phpini_register_globals();

	//�]�w�M��ؿ�
	$INCLUDE_PATH=$SFS_PATH."/include/";
	$PEAR_PATH=$SFS_PATH."/include/";
	$OLE_PATH=$SFS_PATH."/OLE/";
	$SPREADSHEET_PATH=$SFS_PATH."/Spreadsheet/";

	//�]�wsmarty����
	require_once ("libs/Smarty.class.php");
	$smarty = new Smarty;
	$smarty->compile_check = true;
	$smarty->debugging = false;
	set_upload_path("templates_c");
	$smarty->compile_dir=$UPLOAD_PATH."templates_c";

	//�w�qsmarty�ϥΪ�tag
	$smarty->left_delimiter="{{";
	$smarty->right_delimiter="}}";

	//�w�ɲM���Ȧs��
	$temp_file=$UPLOAD_PATH."system/clean_templates_c";
	$now_date=date("Y-m-d");
	if (is_file($temp_file)) {
		$fp=fopen($temp_file,"r");
		$pre_date=date("Y-m-d",strtotime(fgets($fp,10)));
		fclose($fp);
	}
	if ($pre_date!=$now_date) {
		$smarty->clear_compiled_tpl();
		$fp=fopen($temp_file,"w");
		fputs($fp,$now_date);
		fclose($fp);
	}

	//�ثe���{���W
	$scripts=explode("/",$_SERVER['SCRIPT_NAME']);
	$smarty->assign("CURR_SCRIPT",array_pop($scripts));
	$smarty->assign("SFS_PATH",$SFS_PATH);
	$smarty->assign('SFS_PATH_HTML',$SFS_PATH_HTML);

	//�P�_register_global
	if (ini_get('register_globals')) {
		echo "<table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='".$SFS_PATH_HTML."images/warn.png' align='middle' border=0>�t�γ]�w�����ܧ�</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'>�Q�ժ��t�Φ]<font color=red>�uphp.ini����register_global�]�w��On�v</font>�A�i��ɭP��ƪ��M�I�A�ХߧY�q���t�κ޲z���B�z�C<br></td></tr><tr><td align=center><br></td></tr></table>";
		exit;
	}

	//�G�������]�w
	$temp_file=$UPLOAD_PATH."system/theme";
	if (is_file($temp_file)) {
		$fp=fopen($temp_file,"r");
		while(!feof($fp)) {
			$temp_str=fgets($fp,50);
			$temp_arr=explode("=",$temp_str);
			if (!empty($temp_arr[0])) $temp[strtoupper($temp_arr[0])]=$temp_arr[1];
		}
		$temp_arr=array();
		fclose($fp);
	}
	$FOLDER="fc.gif";
	$FOLDER_OPEN="fo.gif";
	if ($temp["FOLDER"]) {
		$FOLDER="folder_".$temp["FOLDER"].".png";
		$FOLDER_OPEN="folder_".$temp["FOLDER"]."_open.png";
		$THEME_COLOR=$temp["ICON"];
	}

	//�۵M�H���ҳ]�w
	$temp_file=$UPLOAD_PATH."system/cdc";
	if (is_file($temp_file)) {
		$fp=fopen($temp_file,"r");
		while(!feof($fp)) {
			$temp_str=fgets($fp,50);
		}
		if (trim($temp_str)=="ON") $CDCLOGIN=1;
		fclose($fp);
	}
	
	//���o�ɮפW�ǼȦs�ؿ�
	$tmp_path=ini_get("upload_tmp_dir");
	if (empty($tmp_path)) {
		$tmp_path=$_ENV["TMP"];
	}
	if (empty($tmp_path)) {
		$tmp_path="/tmp";
	}
?>
