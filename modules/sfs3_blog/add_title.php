<?php
// �ޤJ SFS3 ���禡�w
include "../../include/config.php";

// �ޤJ�z�ۤv�� config.php ��
require "config.php";

// �{��
sfs_check();

$title=trim($_POST['title']);
$bh_sn=($_POST['bh_sn'])?$_POST['bh_sn']:$_GET['bh_sn'];
$kind_sn=($_POST['kind_sn'])?$_POST['kind_sn']:$_GET['kind_sn'];

if($_POST['s1']=="�e�X" && $title) {
	$sql="insert into blog_content(kind_sn,title,bh_sn,owner_id,dater) values('$kind_sn','$title','$bh_sn','{$_SESSION['session_tea_sn']}',now())";
	$CONN->Execute($sql) or teigger_error($sql,256);
	$bc_sn=$CONN->Insert_ID();
	$url_str=$SFS_PATH_HTML.get_store_path()."/blog.php?kind_sn=$kind_sn&bc_sn=$bc_sn";
	echo "<html><body>
	<script LANGUAGE=\"JavaScript\">
	window.opener.location.href=\"$url_str\";
	window.close();
	</script>
	</body>
	</html>";

}
if(!$kind_sn) echo"<table bgcolor='#FFF08B' align='center'><tr><td><font color='#FF0000'>�Х��إߤ峹���O�I</font></td></tr></table><button onclick=\"window.close()\">����</button>";
else{
	echo "�s�W�峹���D<p></p>
	<form action='{$_SERVER['PHP_SELF']}' method='POST'>
		<input type='text' name='title' size='30'>
		<input type='submit' name='s1' value='�e�X'>
		<input type='hidden' name='bh_sn' value='$bh_sn'>
		<input type='hidden' name='kind_sn' value='$kind_sn'>
	</form>
	<button onclick=\"window.close()\">����</button>
	";
}
?>
