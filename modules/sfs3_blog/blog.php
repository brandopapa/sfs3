<?php
// $Id: blog.php 5310 2009-01-10 07:57:56Z hami $

// �ޤJ SFS3 ���禡�w
include "../../include/config.php";

// �ޤJ�z�ۤv�� config.php ��
require "config.php";

// �{��
sfs_check();

//�����ܼ�
$act=($_POST['act'])?$_POST['act']:$_GET['act'];
$bh_sn=($_POST['bh_sn'])?$_POST['bh_sn']:$_GET['bh_sn'];
$style=($_POST['style'])?$_POST['style']:$_GET['style'];
$alias=($_POST['alias'])?$_POST['alias']:$_GET['alias'];
$main=($_POST['main'])?$_POST['main']:$_GET['main'];
$direction=($_POST['direction'])?$_POST['direction']:$_GET['direction'];
$enable_blog=($_POST['enable_blog'])?$_POST['enable_blog']:$_GET['enable_blog'];
$kind=($_POST['kind'])?$_POST['kind']:$_GET['kind'];
$kind_sn=($_POST['kind_sn'])?$_POST['kind_sn']:$_GET['kind_sn'];
$bc_sn=($_POST['bc_sn'])?$_POST['bc_sn']:$_GET['bc_sn'];
$content=($_POST['content'])?$_POST['content']:$_GET['content'];
$content2=($_POST['content2'])?$_POST['content2']:$_GET['content2'];
$title=($_POST['title'])?$_POST['title']:$_GET['title'];

//�e�X����������
if($act=="start_blog") {
	$sql="select enable from blog_home where owner_id='{$_SESSION['session_tea_sn']}' ";
	$rs=$CONN->Execute($sql) or trigger_error($sql,256);
	$enable=$rs->fields['enable'];

	if($enable=="0") $CONN->Execute("update blog_home set enable='1' where owner_id='{$_SESSION['session_tea_sn']}' ");
	else $CONN->Execute("update blog_home set enable='0' where owner_id='{$_SESSION['session_tea_sn']}' ");
}
elseif($act=="savehome"){
	update_home($bh_sn);

}
elseif($act=="savecover"){
	cover_upload_file($bh_sn);

}
elseif($act=="�x�s"){
	save_content($bc_sn);

}
elseif($act=="�R�����e"){
	del_content($bc_sn);

}
elseif($act=="�R�����O"){
	del_kind($kind_sn);

}
elseif($act=="�޲z��"){
	header("Location:./quota.php");

}



// �s�� SFS3 �����Y
head("�ն鳡����");

$sql="select * from blog_home where  owner_id='{$_SESSION['session_tea_sn']}' ";
$rs=$CONN->Execute($sql) or trigger_error($sql,256);
$bh_sn=$rs->fields['bh_sn'];
$style=$rs->fields['style'];
$main=$rs->fields['main'];
$cover=$rs->fields['cover'];
$direction=$rs->fields['direction'];
$alias=$rs->fields['alias'];
$enable=$rs->fields['enable'];
$checked=($enable)?" checked":"";
if($rs->RecordCount( )=='0') $CONN->Execute("insert into  blog_home(owner_id,start,enable) values('{$_SESSION['session_tea_sn']}',now(),'0') ");
$start_blog="
<form>
<input type='checkbox' name='enable_blog'$checked  onclick=\"this.form.submit()\">�ҥ�
<input type='hidden' name='act' value='start_blog'>
&nbsp;<span class='like_button'><a href=\"".$SFS_PATH_HTML."modules/our_blog\">�ڭ̪�Blog</a></span>
&nbsp;<span class='like_button'><a href=\"".$SFS_PATH_HTML."modules/our_blog/my_blog.php?bh_sn=$bh_sn\">�ڪ�Blog</a></span>
</form>";

//������A�Y�n�ۻs���檺css�ɡA�аѦ� modules/our_blog/themes/default/style.css
$style_path = $SFS_PATH."/modules/our_blog/themes/";
$handle=opendir($style_path);
while ($dir_list = readdir($handle)){
	if ($dir_list != "." and $dir_list != ".." and $dir_list!="CVS" and is_dir($style_path.$dir_list)) {
		$style_selected=($dir_list==$style)?" selected":"";
		$style_option.="<option value='$dir_list'$style_selected>$dir_list</option>";
	}
}
$home="
	<table bgcolor='#089E0B' border='0' cellspacing='1' cellpadding='2'><tr bgcolor='#C2F7B0'><td>
	<form>
		����G
		<select name='style'>
			$style_option
		</select>
		<br>
		�ʺ١G<input type='text' name='alias' value='$alias' size='20'><br>
		�D�D�G<input type='text' name='main' value='$main' size='20'><br>
		�����G<textarea name='direction' cols='30' rows='6'>$direction</textarea><br>
		<input type='submit' value='�T�w'>
		<input type='hidden' name='act' value='savehome'>
		<input type='hidden' name='bh_sn' value='$bh_sn'>
	</form>
	</td></tr><tr bgcolor='#C2F7B0'><td>
	<form action ='{$_SERVER['PHP_SELF']}' enctype='multipart/form-data' method='post'>
		<input type='hidden' name='bh_sn' value='$bh_sn'>
		<input type='file' name='userdata' >
		<input type='submit' value='�ʭ��W��'><br>
		<input type='hidden' name='act' value='savecover'>
	</form>
	<img src='".$UPLOAD_URL."blog/cover/".$bh_sn.".jpg' alt='�S���ʭ��Ϥ�'>
	</td></tr></table>
";

$say="<p><font color='#AAAAAA'>�z�ҤW�Ǫ��ʭ��Ϥ��ȭ����ɦW��jpg�����ɡA�e�׭Y�j��200pix�t�η|�۰��Y���e��200pix</font>";
$area2=$start_blog.$home.$say;


//�峹���O���
$kind_name_arr=array();
$sql="select * from blog_kind where bh_sn='$bh_sn' and enable=1 ";
$rs=$CONN->Execute($sql) or trigger_error($sql,256);
$i=0;
while(!$rs->EOF){
	$kind_sn_arr[$i]=$rs->fields['kind_sn'];
	$kind_name_arr[$kind_sn_arr[$i]]=$rs->fields['kind_name'];
	$rs->MoveNext();
	$i++;
}

$kind_option.="<option value=''>��ܤ峹���O</option><option value='add_kind' STYLE=\"background-color: #E2D9FD;  color: #F71CFF\">�s�W�峹���O</option>";
$j=0;
foreach($kind_name_arr as $key => $val){
	$selected[$j]=($kind_sn==$key)?" selected":"";
	$kind_option.="<option value='$key'$selected[$j]>$val</option>";
	$j++;
}

$url_str=$SFS_PATH_HTML.get_store_path()."/add_kind.php?bh_sn=$bh_sn";
$url_str2=$SFS_PATH_HTML.get_store_path()."/blog.php";
$sub_kind="
	<form action='{$_SERVER['PHP_SELF']}' method='POST' name='kind_form'>
	<select name='kind' onchange=\"about_kind('$url_str',this,'$url_str2')\">
	$kind_option
	</select>
	</form>
	";


//���D���
$title_arr=array();
if($kind_sn){
	$sql="select * from blog_content where bh_sn='$bh_sn' and kind_sn='$kind_sn' and enable=1 order by bc_sn";
	$rs=$CONN->Execute($sql) or trigger_error($sql,256);
	$i=0;
	while(!$rs->EOF){
		$bc_sn_arr[$i]=$rs->fields['bc_sn'];
		$title_arr[$bc_sn_arr[$i]]=$rs->fields['title'];
		$rs->MoveNext();
		$i++;
	}
}
$title_option.="<option value='' selected>��ܤ峹���D</option><option value='add_title' STYLE=\"background-color: #E2D9FD;  color: #F71CFF\">�s�W�峹���D</option>";
$j=0;

foreach($title_arr as $key => $val){
	$selected[$j]=($bc_sn==$key)?" selected":"";
	$title_option.="<option value='$key'$selected[$j]>$val</option>";
	$j++;
}

$url_str3=$SFS_PATH_HTML.get_store_path()."/add_title.php?bh_sn=$bh_sn&kind_sn=$kind_sn";
$url_str4=$SFS_PATH_HTML.get_store_path()."/blog.php?kind_sn=$kind_sn";
$title_list="
	<form action='{$_SERVER['PHP_SELF']}' method='POST' name='title_form'>
	<select name='title' onchange=\"about_title('$url_str3',this,'$url_str4')\">
	$title_option
	</select>
	</form>
	";



//���U�ӬO�峹���s��ϰ�A���b��
if($bc_sn){
	$sql="select * from blog_content where bc_sn='$bc_sn' and enable=1";
	$rs=$CONN->Execute($sql) or trigger_error($sql,256);
	$title=$rs->fields['title'];
	$content=$rs->fields['content'];
	$content2=$rs->fields['content2'];
	$dater=$rs->fields['dater'];
}
if(is_blog_admin()) $man="<input type='submit' name='act' value='�޲z��'>";
//�u��C
$url_str5=$SFS_PATH_HTML.get_store_path()."/stick_image.php?bc_sn=$bc_sn&bh_sn=$bh_sn";
$url_str7=$SFS_PATH_HTML.get_store_path()."/preview.php?bc_sn=$bc_sn";
$tool_list="
<input type='button' value='�K��' onclick=\"about_stick_image('$url_str5')\">
<input type='submit' name='act' value='�x�s'>
<input type='submit' name='act' value='�R�����O'>
<input type='submit' name='act' value='�R�����e'>
<input type='button' value='�w��' onclick=\"preview('$url_str7')\">
$man
";

$edit_area="
<input type='hidden' name='kind_sn' value='$kind_sn'>
<input type='hidden' name='bc_sn' value='$bc_sn'>
<input type='text' name='title' value='$title' size='60' STYLE=\"background-color:#D1FFC8;  color:#130570 \">
<textarea name='content' cols='60' rows='10' STYLE=\"background-color:#FFF8CC;  color:#130570 \">$content</textarea>
<textarea name='content2' cols='60' rows='20' STYLE=\"background-color:#FFF8CC;  color:#130570 \">$content2</textarea>
<br><font color='#7F7F7F'>�̫��s����G$dater</font>
";

$area1="<table><tr><td width='1'>$sub_kind</td><td>$title_list</td></tr><tr><td colspan='2'><form action='{$_SERVER['PHP_SELF']}' method='POST' name='work_form'>$tool_list</td></tr><tr><td colspan='2'>$edit_area</form></td></tr></table>";
$main="<table bgcolor='#B6BFFB' cellspacing='1' cellpadding='5' width='100%' height='100%'><tr bgcolor='#FFFFFF'><td width='70%' valign='top'>$area1</td><td width='30%' valign='top'>$area2</td></tr></table>";
echo $main;
// SFS3 ������
foot();

?>
<script language="JavaScript1.2">

	function clear1(oj){
		oj.value='';
		oj.focus();
	}

	function about_kind(url_str,oj,url_str2){
		if(oj.value!="add_kind")  {
			if(oj.value>0) location.href=url_str2+"?kind_sn="+oj.value;
		}
		else window.open(url_str,"�s�W�峹���O","width=320,height=320,resizeable=yes,scrollbars=yes");
	}

	function about_title(url_str3,oj,url_str4){
		if(oj.value!="add_title")  {
			if(oj.value>0) location.href=url_str4+"&bc_sn="+oj.value;
		}
		else window.open(url_str3,"�s�W�峹���D","width=320,height=320,resizeable=yes,scrollbars=yes");
	}

	function about_stick_image(url_str5){
		window.open(url_str5,"�K�Ϻ޲z��","width=420,height=420,resizeable=yes,scrollbars=yes");
	}

	function fromsub(url_str6){
		var imgstr="<img src=\""+url_str6+"\">";
		document.work_form.content.value=document.work_form.content.value+imgstr;

	}
	function fromsub2(url_str6){
		var imgstr="<img src=\""+url_str6+"\">";
		document.work_form.content2.value=document.work_form.content2.value+imgstr;

	}

	function preview(url_str7){
			window.open(url_str7,"�w���峹","width=640,height=480,resizeable=yes,scrollbars=yes");
	}
</script>
