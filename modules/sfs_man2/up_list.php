<?php
// $Id: up_list.php 5310 2009-01-10 07:57:56Z hami $
// �ޤJ SFS3 ���禡�w
include "../../include/config.php";
include "../../include/sfs_case_PLlib.php";

// �ޤJ�z�ۤv�� config.php ��
require "config.php";

// �{��
sfs_check();
$tool_bar=&make_menu($school_menu_p);
if ($_GET[up_id]<>''){
	if ($_GET[up_id]=='include')
		$up_path = $UPLOAD_PATH."upgrade/include";
	else
		$up_path = $UPLOAD_PATH."upgrade/modules/$_GET[up_id]";
	$filename = "$up_path/$_GET[file_name]";
	$fd = fopen($filename,"r");
	$contents = fread ($fd, filesize($filename));
	echo "<html>
	<head>
	<meta http-equiv=\"Content-Type\" content=\"text/html; Charset=Big5\">
	</head>
	<body>
	<pre>
	 $contents;
	</pre>
	</body>
	</html>";
	exit;

}


// �s�� SFS3 �����Y
head("�ҲդɯŰT��");
echo $tool_bar;
//
// �{���X�Ѧ��}�l
$dirname_arr = array();
$dirname_arr['include']="�t��";
$query = "select dirname,showname from sfs_module where kind='�Ҳ�'";
$recordSet = $CONN->Execute($query) or trigger_error("�t�ο��~",E_USER_ERROR);
while(list($dirname,$showname)=$recordSet->FetchRow()){
	$dirname_arr[$dirname]=$showname;
}
$id_arr = array();
$list_arr = array();
$id_arr['include'] = "�t�� -- include";

if ($_POST[up_id] == '')
	$_POST[up_id] = "include";

//�M��t�Χ�s�T��
$include_path = $UPLOAD_PATH."upgrade/include";
$handle=opendir($include_path);
if ($_POST[up_id]=='include') {
	while ($file = readdir($handle)){
		if ($file != "." and $file != ".." ){
			$list_arr["include"][]= $file;
		}
	}
}


//�M��Ҳէ�s�T��
$up_path = $UPLOAD_PATH."upgrade/modules";
$handle=opendir($up_path);
while ($file = readdir($handle)){
	if ($file != "." and $file != ".." ){
		$id_arr[$file] = $dirname_arr[$file]." -- $file";
		if($_POST[up_id]==$file) {
			$handle_2 = opendir("$up_path/$file");
			while($ffile = readdir($handle_2)){
				if ($ffile != "." and $ffile != ".." )
					$list_arr[$file][]= $ffile;
			}
		}
	}
}

?>
<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=0 class="main_body" WIDTH="100%" ALIGN="CENTER">
<tr>
<td>
<TABLE BORDER=0 CELLPADDING=10 CELLSPACING=0 BGCOLOR="#E6E6FA" WIDTH="100%" ALIGN="CENTER">
<TR>
<TD>
<form method="post" name="myform" action ="<?php echo $_SERVER[PHP_SELF] ?>">                                                                                                               
<TABLE BORDER="0" BGCOLOR="#FFFFFF" WIDTH="100%" CELLPADDING="2" CELLSPACING="0" align=center >
<TR >
                <td CLASS="grid" valign=top width=100>
<?php

//$id_arr = array_keys($list_arr);
$sel1 = new drop_select();
$sel1->has_empty= false;
$sel1->s_name = "up_id";
$sel1->arr = $id_arr;
$sel1->id = $_POST[up_id];
$sel1->is_submit = true;
$sel1->size = 10;
$sel1->do_select();
?>

</td>
<td valign=top>
<?php
if ($_POST[up_id] == 'include')
	$up_path = $include_path;

while(list($id,$val)= each($list_arr)){
	if ($id == 'include')
		echo "<b><font size=4 >$dirname_arr[$id]</font></b>  ($up_path) <br><br>";
	else
		echo "<b><font size=4 >$dirname_arr[$id]</font></b>  ($up_path/$id) <br><br>";
	foreach($val as $file_name){
		if ($id == 'include')
			$filename = "$up_path/$file_name";
		else
			$filename = "$up_path/$id/$file_name";
		
		$fd = fopen($filename,"r");
		$change_time = date("Y-m-d H:i:s",filemtime($filename));
		$url = "<a href=\"$_SERVER[PHP_SELF]?up_id=$_POST[up_id]&file_name=$file_name\" target=\"show_con\" onClick=\"window.open('about:blank', 'show_con','resizeable=1,scrollbars=1,width=600')\" ><img src=\"images/explode.png\" border=0></a>";
		echo "<font color=blue>$file_name </font> $url, �t�Χ�s�ɶ�: <font color =red>$change_time</font><BR>";
		echo "<hr>";
		fclose ($fd);
	}
}

?>
</td>
</tr>
</table>
</form>
</td>
</tr>
<tr>
<td>
<!-- ���� -->
<table>
  <tbody>
    <tr>
      <td>�ҲդɯŻ���</td>
    </tr>
	<tr>
	<td>�ǰȨt�μҲդɯŰO����,���ҲդɯŮɦ۰ʫإ�,�t�ΰ���ɷ|�ˬd�O���ɬO�_�s�b,�ǥH�P�_�O�_����ɯ�,�@��Ө�,�t�η|�۰ʺ��@���ɮ�,���p�J��ɯť��ѩΨ�
�L��]�ݭ��s����ɯ�,�A�i�H��ʲ�������,�t�η|�۰ʦA����ɯŤ@���C</td>	</tr>  </tbody></table>

<!-- �������� -->
</td>
</tr>
</table>
</td>
</tr>
</table>

<?php
// SFS3 ������
foot();

?>
