<?php
// $Id: shownews.php 5310 2009-01-10 07:57:56Z hami $

ob_start();
session_start();
include "config.php";

//�o��{���O�s�D�s�����{��, ������ sys_check���ʧ@
if ($m_arr["IS_STANDALONE"]=='0'){
	//�q�X�����������Y
	head("�s�D�o�G");
}
//�D�n���e


function showpict($imgnum,$imgd,$pict1,$pict2,$pict3){
	echo "<applet code='JavaBanner.class' width='360' height='270' align='right'>";
	echo "<param name='bgcolor'   value='ffffff'>";
	echo "<param name='delay'     value='100'>";
	echo "<param name='length'    value='3'>";
	echo "<param name='number'    value='$imgnum'>";
	if ($pict1!="") echo "<param name='item0'     value='".$imgd.$pict1."|http://'>";
	if ($pict2!="") echo "<param name='item1'     value='".$imgd.$pict2."|http://'>";
	if ($pict3!="") echo "<param name='item2'     value='".$imgd.$pict3."|http://'>";
	echo "</applet>";
}

function showpics($sn_rdsno){
	global $savepath,$htmlsavepath;
	$sn_dir = $savepath.$sn_rdsno."/";
	$sn_dir_url = $htmlsavepath.$sn_rdsno."/";
	$imgno = 0;
	clearstatcache();
	$direxist=file_exists($sn_dir);
	if ($direxist){
		$handle = opendir($sn_dir);
		while($file = readdir($handle)){
			if (substr($file,0,3)=='Si-') {
				$snfname[$imgno] = $file;
				$imgno++;
			}
		}
	}
	if ($imgno == 0) $snfname = array();
	echo "<br>";
	echo "<center>���s�D��ï�@�@�@".$imgno."�@�i�ۤ�</center>";
	echo "<hr>\n\r";
	echo "<table width='98%' align='center' border='0'>\n\r";
	for ($row=0;$row<ceil($imgno/3);$row++){
		$i1 = $row*3 + 0;
		$i2 = $row*3 + 1;
		$i3 = $row*3 + 2;
		echo "	<tr> \n\r";
		echo "		<td align='center' valign='center'>\n\r";
		if ( $snfname[$i1] != "") {
			echo "			<a href='onepict.php?rdsno=$sn_rdsno&imgname=$snfname[$i1]'>
			<img src='".$sn_dir_url.$snfname[$i1]."' align='center'></a> \n\r";
		}else {
			echo "&nbsp; \n\r";
		}
		echo "		</td> \n\r";
		echo "		<td align='center' valign='center'>\n\r";
		if ( $snfname[$i2] != "") {
			echo "			<a href='onepict.php?rdsno=$sn_rdsno&imgname=$snfname[$i2]'>
			<img src='".$sn_dir_url.$snfname[$i2]."' align='center'></a> \n\r";
		}else {
			echo "&nbsp; \n\r";
		}
		echo "		</td> \n\r";
		echo "		<td align='center' valign='center'>\n\r";
		if ( $snfname[$i3] != "") {
			echo "			<a href='onepict.php?rdsno=$sn_rdsno&imgname=$snfname[$i3]'>
			<img src='".$sn_dir_url.$snfname[$i3]."' align='center'></a> \n\r";
		}else {
			echo "&nbsp; \n\r";
		}
		echo "		</td> \n\r";
		echo "	</tr> \n\r";
	}
	echo "</table>\n\r";

}

/****
  `news_sno` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(60) default NULL,
  `posterid` varchar(10) default NULL,
  `news` text,
  `postdate` datetime NOT NULL default '0000-00-00 00:00:00',
  `newslink` varchar(70) default NULL
******/

$whichnews = $_GET["rdsno"];
$sql = "SELECT title,posterid,news,postdate,newslink \n\r";
$sql.= "FROM newsmig \n\r";
$sql.= "WHERE news_sno= '$whichnews' \n\r";
$rs = $CONN -> Execute($sql);
$as = $rs -> FetchRow();
list($newstitle,$posterid,$newscontent,$postdate,$newslink)= $as ;
userdata($posterid);


?>
<html>
<head>
<meta http-equiv="Content-Type" content="html/text;charset=Big5">
<title>�ն�s�D�o�G</title>
</head>

<body>
<center>
<table width="800" cellspacing="1">
	<tr bgcolor="#DDFF95">
		<td  height="40" width="400">�@<a href="newslist.php">�^�s�D�`��</a></td>
		<td width="150" align="center"><a href="postnews.php?act=add">�s�W�s�D</a></td>	
		<td width="150" align="center">
		<a href="postnews.php?act=mod&rdsno=<? echo $whichnews; ?>">�ק糧�s�D</a>
		</td>
		<td width="150" align="center">
		<a href="postnews.php?act=del&rdsno=<? echo $whichnews; ?>">�R�����s�D</a>
		</td>
	</tr>
</table>
<table width="800" cellspacing="0">
	<tr bgcolor="#ACF12C">
		<td width="10" height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td width="10">&nbsp;</td>
	</tr>
	<tr>
		<td width="10" bgcolor="#ACF12C">&nbsp;</td>
		<td bgcolor="#FFF8A8">
			<DIV align="center"><FONT color="Blue" size="5"><? echo $newstitle; ?></FONT></DIV>
			<DIV align="right"><? echo $user_name."����--".substr($postdate,0,10);	?></DIV>
		</td>
		<td width="10" bgcolor="#ACF12C">&nbsp;</td>
	</tr>
	<tr>
		<td width="10" bgcolor="#ACF12C">&nbsp;</td>
		<td>&nbsp;</td>
		<td width="10" bgcolor="#ACF12C">&nbsp;</td>
	</tr>
	<tr>
		<td width="10" bgcolor="#ACF12C">&nbsp;</td>
		<td><? echo nl2br($newscontent); ?></td>
		<td width="10" bgcolor="#ACF12C">&nbsp;</td>
	</tr>
	<tr>
		<td width="10" bgcolor="#ACF12C">&nbsp;</td>
		<td>&nbsp;</td>
		<td width="10" bgcolor="#ACF12C">&nbsp;</td>
	</tr>
	<tr>
		<td width="10" bgcolor="#ACF12C">&nbsp;</td>
		<td align="center"><? showpics($whichnews); ?></td>
		<td width="10" bgcolor="#ACF12C">&nbsp;</td>
	</tr>
	<tr>
		<td width="10" bgcolor="#ACF12C">&nbsp;</td>
		<td>&nbsp;</td>
		<td width="10" bgcolor="#ACF12C">&nbsp;</td>
	</tr>
	<tr>
		<td width="10" bgcolor="#ACF12C">&nbsp;</td>
		<td  bgcolor="#FFF8A8">
			<? echo "�������}�G<a  target='_blank' href='".$newslink."'>".$newslink."</a>"; ?>
		</td>
		<td width="10" bgcolor="#ACF12C">&nbsp;</td>
	</tr>
	<tr bgcolor="#ACF12C">
		<td width="10" height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td width="10">&nbsp;</td>
	</tr>
</table>
</center>


<?php
if ($m_arr["IS_STANDALONE"]=='0'){
	//SFS3�G������
	foot();
}
?>

</body>

</html>
