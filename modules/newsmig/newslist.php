<?php
// $Id: newslist.php 8079 2014-06-24 07:51:09Z smallduh $

ob_start();
//session_start();
include "config.php";

//�o��{���O�s�D�s�����{��, ������ sys_check���ʧ@
if ($m_arr["IS_STANDALONE"]=='0') {
 //�q�X�����������Y
 head("�s�D�o�G"); 

?>
<?php } else { ?>
<html lang="zh-TW">
<head>
<meta http-equiv="content-type" content="text/html; charset=Big5" >
</head>
<body>
<?php }?>
<?php 
// $title,$postdate,$schname,$poster,$news,$imagename

function tblistnews($news_sno,$title,$user_name,$news,$postdate,$newslink,$imagename){

	// $newscontent �����פ��� 244(122�Ӥ���r)
	$news=substr($news,0,244);
	$news=substr_replace($news,"�D�D�D�D",-8);
	echo "<tr bgcolor='#FFF7D1' onMouseOver=setBG('#C3FF74',this) onMouseout=setBGOff('#FFF7D1',this)>\n\r";
	echo "<td width='110'>".$postdate."</td>\n\r";
	echo "<td width='590'>";
	//echo "<a href='shownews.php?rdnum=$newsno'>";
	echo "<a href='shownews.php?rdsno=$news_sno'>".$title."</a>--".$user_name."����<br>\n\r";
	$destInfo  = pathInfo($imagename);
	if ($destInfo['extension'] != ""){
		echo "<img src='".$imagename."' align='right'>\n\r";
	}
	echo nl2br($news);
	echo "</a></td>\n\r";
	echo "</tr>\n\r";
	//echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>\n\r";
}
?>

<script language="JavaScript">
<!--
function setBG(TheColor,thetable) {
	thetable.bgColor=TheColor;
}
function setBGOff(TheColor,thetable) {
	thetable.bgColor=TheColor;
}
//-->
</script>

<?php

 $search_key=$_POST['search_key'];


//����X�@�X�����, �����X��
$sql_totalnews = "SELECT * FROM newsmig";
if ($search_key!='') {
$sql_totalnews .= " where title like '%".$search_key."%' or news like '%".$search_key."%' ";
}
$rs1 = $CONN->Execute($sql_totalnews);
$numbers = $rs1->RecordCount();

if ($m_arr["nums_perpage"] != ""){
	$nums_perpage = $m_arr["nums_perpage"];
}else{
	$nums_perpage = 10;
}

//nums_perpage �� config.php �ޤJ
if ($numbers%$nums_perpage==0){
	$pages = $numbers/$nums_perpage;
}else{
	$pages = floor($numbers/$nums_perpage)+1;
}


//�Ĥ@���i�J, �]pagenow��SESSION�ܼ�, �_�l��=1
//if (!session_is_registered("nm_pagenow")) {
//	session_register("nm_pagenow");
	$_SESSION["nm_pagenow"]=($_SESSION["nm_pagenow"]<1)?1:$_SESSION["nm_pagenow"];
//}


//�Y�ϥΪ̦��I�W�@��, �U�@�� --> pagenow �i�[�[���
if ($_POST["cp"]== "goback" and $_SESSION["nm_pagenow"]!= 1){
	$_SESSION["nm_pagenow"]=$_SESSION["nm_pagenow"]-1;
}elseif($_POST["cp"]=="gonext" and $_SESSION["nm_pagenow"]<=$pages){
	$_SESSION["nm_pagenow"]=$_SESSION["nm_pagenow"]+1;
}elseif($_POST["cp"]==""){
	$_SESSION["nm_pagenow"]=1;
}

//�Y�ثe���Ƥj���`����, ��ثe���Ƴ]���̤j�� 2014.06.24
if ($_SESSION["nm_pagenow"]>$pages) { $_SESSION["nm_pagenow"]=$pages; }

/****
  `news_sno` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(60) default NULL,
  `posterid` varchar(10) default NULL,
  `news` text,
  `postdate` datetime NOT NULL default '0000-00-00 00:00:00',
  `newslink` varchar(70) default NULL
******/

$sql_listnews = "SELECT news_sno,title,posterid,news,postdate,newslink FROM newsmig ";
if ($search_key!='') {
$sql_listnews .= "where title like '%".$search_key."%' or news like '%".$search_key."%' ";
}
$sql_listnews .= "ORDER BY postdate DESC \n\r";

//�����̫�@��
$rdend = ($_SESSION["nm_pagenow"]*$nums_perpage > $numbers)?($numbers % $nums_perpage):$nums_perpage;
//�������Ĥ@��
$rdstart = ($_SESSION["nm_pagenow"]-1) * $nums_perpage;

// SQL�y�k�[�W LIMIT �l�y, ���w�����ӥX�{�����
$sql_listnews .= " LIMIT $rdstart , $rdend\n\r";
$rs = $CONN->Execute($sql_listnews);
?>
<form method="post" name="myform" action="<?php echo $_SERVER['php_self'];?>">
	<input type="hidden" name="cp" value="">
<?php
echo "<table align='center' width='696' bgcolor='#C3FF74'>";
echo "<tr>\n\r";
echo "	<td>�@ ".$numbers." ���s�D�@���� ".$pages." �� <input type='text' name='search_key' value='".$search_key."' size='10'><input type='submit' value='�z��'> </td>\n\r";

//�Y pagenow = 1 , ���b�Ĥ@��, �N�p�L�k�A �W�@�� �F
if ($_SESSION["nm_pagenow"]==1) {
	echo "	<td>�W�@��</td>\n\r";
}else{
	?>
 		<td><a href="#" onclick="document.myform.cp.value='goback';document.myform.submit()" title="��<?php echo $_SESSION["nm_pagenow"]-1; ?>��">�W�@��</a></td>
  <?php
}

//�Y pagenow = pages , ���b�̫�@��, �N�p�L�k�A �U�@�� �F 
if ($_SESSION["nm_pagenow"]==$pages) {
	echo "	<td>�U�@��</td>\n\r";
}else{
	?>
		<td><a href="#" onclick="document.myform.cp.value='gonext';document.myform.submit()" title="��<?php echo $_SESSION["nm_pagenow"]+1; ?>��">�U�@��</a></td>
  <?php
}
echo "	<td><a href='postnews.php?act=add'>�s�W�s�D</a></td>\n\r";
echo "</tr>";
echo "</table>\n\r";
echo "<table align='center' width='700'>\n\r";
if ($rs){
	while ($ar=$rs->FetchRow()) {
		list($news_sno,$title,$posterid,$news,$postdate,$newslink)=$ar;
		userdata($posterid);
		//���� �ɦW(�t���|) �B�z�X��
		clearstatcache();
		$pn_dir = $savepath.$news_sno."/";
		$pn_dir_url = $htmlsavepath.$news_sno."/";
		$direxist=file_exists($pn_dir);
		if (!$direxist){
			$pn_dir = "";
			$pn_dir_url = "";
			$imagename = "";
		}else{
			$handle=opendir($pn_dir);
			$j = 0;
			while ($file = readdir($handle)) {
				if (substr($file,0,3) == 'Si-') {
					$fname[$j] = $file;
					$j++;
				}
			}
			if ($j == 0) $fname = array();
			$lastnum = $j - 1;
			// �o?�n random ��X�@�� S- �}�Y���p��
			$whichone = rand(0,$lastnum);
			$imagename=$pn_dir_url.$fname[$whichone];
			//echo "<br>".$imagename;
		}
		//�A��datetime �令date
		$postdate = substr($postdate,0,4)."-".substr($postdate,5,2)."-".substr($postdate,8,2);
		//echo "<tr><td>".$imgagename."</td></tr>";
		tblistnews($news_sno,$title,$user_name,$news,$postdate,$newslink,$imagename);
	}
}else{
	echo "<tr><td align='center'><br>�s�u����</td></tr>\n\r";
}

?>
</table>
</form>

<?php
if ($m_arr["IS_STANDALONE"]=='0'){
	//SFS3�G������
	foot();
}
?>
