<?php
//$Id: del_comment.php 8238 2014-12-11 08:32:12Z chiming $
require_once("config.php");
//�ϥΪ̻{��
sfs_check();
if ($_POST['form_act']=='del_comm' && $_POST['ACT']!='no' && $_POST['ACT']!='' ){
	$Show_SQL='';
	$link=mysql_pconnect($mysql_host,$mysql_user,$mysql_pass) or die("�L�k�s�u");
	mysql_select_db($mysql_db,$link);
	$SQL="SHOW TABLES ";
	$rs=mysql_query($SQL,$link) or die($SQL);
	while ($row = mysql_fetch_array ($rs)){
		$SQL="ALTER TABLE `$row[0]` COMMENT ='' ";
		if ($_POST['ACT']=='list') {$Show_SQL=$Show_SQL.$SQL."<br>";}
    	if ($_POST['ACT']=='run_sql') {mysql_query($SQL,$link) or die($SQL);}
    	}
	if ($_POST['ACT']=='run_sql') header("Location:".$_SERVER['PHP_SELF']);
}
if ($_GET['act']=='ToMyISAM'){
	$a=array('student_view','teacher_course_view','teacher_post_view');
	$link=mysql_pconnect($mysql_host,$mysql_user,$mysql_pass) or die("�L�k�s�u");
	mysql_select_db($mysql_db,$link);
	$SQL="SHOW TABLE STATUS FROM  $mysql_db ";
	$rs=mysql_query($SQL,$link) or die($SQL);
	while ($row = mysql_fetch_array ($rs)){
	//if ($row['Engine']!='MyISAM' and !in_array($row['Name'],$a)){ 
	if ($row['Engine']=='InnoDB' and !in_array($row['Name'],$a)){ 
		//$SQL="use ".$mysql_db.";ALTER TABLE `".$row['Name']."` ENGINE=MYISAM; flush privileges;";
		$SQL="ALTER TABLE `".$row['Name']."` ENGINE=MYISAM";
		$rs1=mysql_query($SQL,$link) or die($SQL);
		}
	}
	mysql_query("flush privileges",$link);
	header("Location:".$_SERVER['PHP_SELF']);
}

head("��Ʈw�ƥ����U");
print_menu($school_menu_p);
?>
<div align="center"><h2>�M����ƪ�Comment����</h2></div>
<table width=80% align=center>
<TR><td colspan=2 align=center>
<font  color="#FF0000">
���{���Ω�M����ƪ�comment�Ƶ��A�H�ѨM�Y�Ǹ�ƪ�<font  color="#0000FF">
�Ƶ��s�X</font>�P<font  color="#0000FF">��ƽs�X</font>���@�P�����p�C<br>
�{�����@�k�O���y�Ҧ���ƪ�òM�����̪��Ƶ��A
�Ъ`�N�A�M����O�L�k�_�쪺��I<br>
�ҥH�z�u�n����L�@���A�N�i�H�ϥΤU�������O�i��ƥ��A�ӳƥ��U�Ӫ���Ƥ]�ॿ�T���^�_�C</font><br>
�Ѧһy�k�G
<br>
mysqldump&nbsp; -u�b��&nbsp; -p�K�X&nbsp; --default-character-set=latin1&nbsp; sfs3&nbsp; >&nbsp; sfs_DB.sql
</TD></TR>
<TR><td colspan=2 align=center>&nbsp;</TD></TR>
<FORM METHOD=POST ACTION='<?=$_SERVER[PHP_SELF]?>'>
<TR><TD align=right>���y��Ʈw�W��:</TD><TD><?=$mysql_db?></TD></TR>
<TR><TD align=right>����ʧ@</TD><TD>
<select name="ACT" >
<option value="no">--�����--</option>
<option value="list">�C�ܲM���y�k</option>
<option value="run_sql">����M���ʧ@</option>
</select>
</TD></TR>
<TR><td colspan=2 align=center>
<INPUT TYPE='hidden' Name='form_act' value=''>
<INPUT TYPE='reset' Value='���]' class=bur2 >
<INPUT TYPE='button' value='��n�e�X' onclick="if( window.confirm('�T�w�R���Ҧ���ƪ��Ƶ��H�T�w�H')){this.form.form_act.value='del_comm'; this.form.submit()}"><br>
������<b><font color="#0000FF">���{���u�n����L�@���Y�i</font></b>������
</td></tr>
</FORM>
<TR><td colspan=2 style='font-size:9pt'>
<?php if ($_POST['ACT']=='list') echo $Show_SQL; ?>
<TR><td colspan=2 style='font-size:14pt'>
InnoDB�榡����ƪ�p�U�G
</td></tr>
<TR><td colspan=2 style='font-size:10pt'>
<?php
$a=array('student_view','teacher_course_view','teacher_post_view');
$link=mysql_pconnect($mysql_host,$mysql_user,$mysql_pass) or die("�L�k�s�u");
mysql_select_db($mysql_db,$link);
$SQL="SHOW TABLE STATUS FROM  $mysql_db ";
$rs=mysql_query($SQL,$link) or die($SQL);
$ck='N';
// $Show_SQL='';
while ($row = mysql_fetch_array ($rs)){
if (!in_array($row['Name'],$a) and $row['Engine']=='InnoDB'){
	echo $row['Name'].'<br>';$ck='Y';
	//echo $row['Engine']."<br>";
}

//if ($row['Engine']!='MyISAM' and !in_array($row['Name'],$a)) $Show_SQL[]=$row['Name'];	
//echo "ALTER TABLE `".$row['Name']."`  ENGINE=MyISAM; flush privileges;<br>";
//echo "ALTER TABLE `".$row['Name']."` ENGINE=INNODB; flush privileges;<br>";
}
if ($ck=='Y'){
echo "<INPUT TYPE='button' value='�N�W�z��ƪ�����אּMyISAM,�H��K�ƥ��C' onclick=\"if( window.confirm('�T�w��ƪ�אּMyISAM�H�T�w�H')){location.href='del_comment.php?act=ToMyISAM';}\">";
}else{
echo "<b style='color:red;'>�S������InnoDB����ƪ�</b><br>
InnoDB����ƪ��䴩�H�������覡�ƥ�<br>
�אּMyISAM,�ƥ��Φ^�_�W�|����K�C
";}
?></td></tr>
</table>

<?foot();?>

