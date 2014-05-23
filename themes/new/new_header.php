<?php

// $Id: new_header.php 7838 2014-01-02 00:26:33Z hami $

include_once(dirname(__FILE__)."/new_setup.php");

$HAVE_SHOW_HEADER=true;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; Charset=Big5">

<title><?php echo "$SCHOOL_BASE[sch_cname_s] �ǰȺ޲z�t�� -- $logo_title" ?></title>
<?php if ($ENABLE_AJAX) echo "<script type=\"text/javascript\" src=\"/javascript/prototype.js\"></script>\n";?>
<link type="text/css" href="<?php echo $THEME_URL ?>/new.css" rel="stylesheet" />
<link type="text/css" href="<?php echo $SFS_PATH_HTML; ?>themes/base/jquery-ui-1.8.2.custom.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo $SFS_PATH_HTML; ?>javascripts/jquery-1.4.2.js"></script>
<script type="text/javascript" src="<?php echo $SFS_PATH_HTML; ?>javascripts/ui/jquery.ui.core.js"></script>
<?php global $injectJavascript; echo $injectJavascript?>
</head>
<body <?php if ($ON_LOAD) echo "OnLoad=\"$ON_LOAD\""; ?>>
<script language="JavaScript">
	function change_link(url) {
		window.location.href=url;
	}
	<?php if (!empty($_SESSION['session_tea_name']) ):?>
	function checkLocalTime()
	{
	var minutes=1000*60;
	var hours=minutes*60;
	var days=hours*24;
	var years=days*365;
	var d=new Date();
	var t=d.getTime();
	var y=Math.round(t/years);
	
	if (y < <?php echo date('Y')-1970?>) {
		alert('�z���q���ɶ����~,�Эץ���A�ϥΥ��t��');
		location.replace('<?php echo $SFS_PATH_HTML?>login.php?logout=yes');
		}
	}
		
	$(function(){
		checkLocalTime();
	});
	<?php endif?>
</script>
<?php
if (strtoupper(substr(PHP_OS,0,3)=='WIN')) $title_img="sch_title_img.png";
else $title_img="sch_title_img";
if (is_file($UPLOAD_PATH."school/".$title_img))
		$temp_img = $UPLOAD_URL."school/".$title_img;
	else
		$temp_img = get_themes_img('logo.png');
if($show_logo){
	echo show_title($temp_img)."\n";
}elseif ($_GET['HT']=='1' or $SFS_IS_HIDDEN_TITLE=='1'){

}else{
	if(empty($logo_title))$logo_title="�ǰȺ޲z�t��";
	$now_seme=curr_year()."�Ǧ~�� ��".curr_seme()." �Ǵ� ".date("Y �~ m �� d ��");
	$title_logo=(empty($logo_image))?"<img src='$temp_img' align='absmiddle' alt='�ǰȨt�ιϥ�'>":"";
	echo "
	<table border='0' cellpadding='4' cellspacing='0' width='"._new_theme_width."' align='center'>
	<tr><td>
	$title_logo
	<font class='title'>$logo_title</font></td>
	<td valign=bottom align=right class='small'><font color='#BFBFBF'>$now_seme</font></td>
	</tr>
	</table>";
}

//�L�X�{���s��
$link_location=&print_location();
if ($_COOKIE[close_left_menu]==1){
	$top_tool=&get_big_module(1,"small");
	$tool="";
}elseif($show_left_menu){
	$tool=&get_big_module(1);
}
// �Y config.php ���]�w���}�ֳt�s�����, �~���}.
$all_power = (!empty($_SESSION['session_tea_name']) && !$SFS_HIDDEN_FAST_LINK && $_COOKIE[close_fast_link]!=1)?fast_link():"<a href='".$THEME_URL."/chang_mode.php?cmk=close_fast_link&v=0'>�ֳt���</a>";


echo "
<table border='0' cellpadding='2' cellspacing='0' width='"._new_theme_width."' align='center' class='small'>
<tr bgcolor='#DACFFF'>
<td></td>
<td nowrap>$link_location[0]</td>
$top_tool
<td align='right' nowrap>$all_power</td>
<td width='200' align='right' nowrap>$link_location[1]</td>
<td></td>
</tr>
".chkUP()."
</table>
<table border='0' cellpadding='4' cellspacing='0' width='"._new_theme_width."' align='center'>
<tr>$tool<td valign='top'>
";

//�P�_PHP����
function chkUP() {
	global $SFS_VER_DECLARE, $SFS_IS_CENTER_VER;

	$up_msg="";
	if ( !function_exists('version_compare') || version_compare( phpversion(), '5', '<' ) ) {
		$up_msg="���������x���䴩PHP5, ��ĳ���֤ɯ�!";
	} elseif ($SFS_VER_DECLARE<"3.1") {
		$up_msg="�۰ʧ�s�{�����ɯ�, ��ĳ���֤ɯťH���C��w���I!";
	}
// 	if ($SFS_IS_CENTER_VER) {
// 		if ($_SERVER['SERVER_ADDR']=="163.17.40.53") $up_msg="�����ߺݪA�ȧY�N��2010-11-15 ���1:00�����I������i������D����Ʋ���A2010-11-16 10:00 �����D���A�ȱҥΡC�|���ӽе����D���A�ȩθ�Ʋ��^���ǮաA�о��t�P���������p��! email: infodaes@seed.net.tw";
// 		else $up_msg="";
// 	}
	if ($up_msg) $up_msg="<tr style='background-color:#DAAD00;line-height:15pt;'><td colspan='".(($top_tool)?7:6)."' style='text-align:center;color:white;'>$up_msg</td></tr>";

	return $up_msg;
}

//��ܼ��D
function &show_title($temp_img){
	global $SCHOOL_BASE,$SFS_PATH_HTML;
	$now_seme=curr_year()."�Ǧ~�� ��".curr_seme()." �Ǵ� ".date("Y �~ m �� d ��");
	$main="
	<table border='0' cellpadding='0' cellspacing='0' width='"._new_theme_width."' align='center' class='small'>
	<tr>
		<td>
		<a href='$SFS_PATH_HTML'>
		<img src='$temp_img' alt='�ǰȺ޲z�t��' align='absmiddle' border=0>
		</a>
		</td>
   		<td align='right' width=100% height=16 nowarp>
   		<font color=#000000>
		<a href='http://www.sfs.project.edu.tw'>�x��׾�</a>��
   		<a href='".$SFS_PATH_HTML."include/sfsinfo/'>����SFS�t��</a>��
    	<a href='http://$SCHOOL_BASE[sch_url]'>".$SCHOOL_BASE["sch_cname_ss"]."����</a></font>
    	<br><font color='#BFBFBF'>$now_seme</font>
    	</td>
	</tr>
	</table>\n";
	return $main;
}
?>
