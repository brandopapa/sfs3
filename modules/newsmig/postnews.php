<?php
// $Id: postnews.php 6812 2012-06-22 08:22:16Z smallduh $

ob_start();
//session_start();

include "config.php";

if ($m_arr["IS_STANDALONE"]=='0'):
	//�q�X�����������Y
	head("�s�D�o�G");
 else:?>
<html lang="zh-TW">
<head>
<title>�ק�s�D</title>
<meta http-equiv="content-type" content="text/html; charset=Big5" >
</head>
<body>
<?php
 endif;

 //�ˬd�ϥΪ�, �{�����է��N�n���}
sfs_check();

/*  Convert image size. true color*/
//$src        �ӷ��ɮ�
//$dest        �ت��ɮ�
//$maxWidth    �Y�ϼe��
//$maxHeight    �Y�ϰ���
//$quality    JPEG�~��

function ResizeImage($src,$dest,$maxWidth,$maxHeight,$quality=95) {
	//�ˬd�ɮ׬O�_�s�b
	if (file_exists($src)  && isset($dest)) {

		$destInfo  = pathInfo($dest);
		// getImageSize�o��function�^�ǤT�Ӱ}�C,
		// [0] -> �Ϥ��e��
		// [1] -> �Ϥ�����
		// [2] -> �Ϥ��榡 1:gif  2:jpg  3:png
		$srcSize   = getImageSize($src); //���ɤj�p

		/*********************************************
		�p��󥭲v, �p�G�󥭲v���P, �ĥέ�Ϫ��󥭲v
		�Y�Ϫ��B���z�p�Z�G
		 1. $srcRatio ����
		 2. �Y�O�e���Ϥ� ( $srcRatio > 1 )
			�s���e�� = �Y�Ϫ��̤j�e
			�s������ = �Y�ϳ̤j�e / $srcRatio
		 3. �Y�O����(�Τ��)�Ϥ� ( $srcRatio <= 1 )
			����� maxWidth �� maxHeight ��: 640 x 480 �ܦ� 480 x 640
			�s���e�� = �Y�ϳ̤j�� x $scrRatio
			�s������ = �Y�ϳ̤j��

		�Q�Φ��t��k�ӱ���̤j���e(��)�� = �ϥΪ̦ۭq�Y�ϳ̤j�e(��)
		*******************************************************/
		$srcRatio  = $srcSize[0]/$srcSize[1]; // �p��e/��

		if ($srcRatio > 1) {
			$destSize[0] = $maxWidth;
			$destSize[1] = $maxWidth/$srcRatio;
		}
		else {
			// ��� maxWidth �P maxHeight
			$tempWidth = $maxWidth;
			$maxWidth = $maxHeight;
			$maxHeight = $tempWidth;
			// ��X�s���e�P��
			$destSize[0] = $maxHeight*$srcRatio;
			$destSize[1] = $maxHeight;
		}

		//�إߤ@�� True Color ���v��
		$destImage = imageCreateTrueColor($destSize[0],$destSize[1]);

		//�ھڰ��ɦWŪ������
		switch ($srcSize[2]) {
			case 2: $srcImage = imageCreateFromJpeg($src); break;
			case 3: $srcImage = imageCreateFromPng($src); break;
			default: return false; break;
		}

		//�����Y��
		ImageCopyResampled($destImage, $srcImage, 0, 0, 0, 0,$destSize[0],$destSize[1],$srcSize[0],$srcSize[1]);

		//��X����
		switch ($srcSize[2]) {
			case 2: imageJpeg($destImage,$dest,$quality); break;
			case 3: imagePng($destImage,$dest); break;
		}
		return true;
	}
	else {
		return false;
	}
}


function unzip($zipdir,$zipfn){
	//global $SFS_PATH,$UPLOAD_PATH;

	$is_win=ereg('win', strtolower($_SERVER['SERVER_SOFTWARE']))?true:false;

	//�M�� unzip ���Ҧb�ؿ�
	$whereunzip = exec("whereis -b unzip");
	$wuary = explode(" ",$whereunzip);
	$path_parts = pathinfo($wuary[1]);

	//echo "<hr>";
	//echo "	���|�G ".$path_parts["dirname"] . "<br>";
	//echo "	�ɦW�G ".$path_parts["basename"] . "<br>";

	$ziptool=($is_win)?"UNZIP32.EXE":$path_parts['dirname'] ."/".$path_parts['basename'];

	$arg1=($is_win)?"START /min cmd /c ":"";
	$arg2=($is_win)?"-d":"-d";

	if (!file_exists($ziptool)) {
		die($ziptool."���s�b�I");
	}elseif(!file_exists($zipdir.$zipfn)) {
		die($zipdir.$zipfn."���s�b�I");
	}

	$cmd=$arg1." ".$ziptool." ".$zipdir.$zipfn." ".$arg2." ".$zipdir;

	$msg = exec($cmd,$output);
	for($i=0;$i<count($output);$i++){
		$msg .= "<br>".$output[$i];
	}
	unlink($zipdir.$zipfn);
	return $msg;
}


function submvup($dirname) {
	//���ˬd��Ƨ�, �Y���U�@�h����Ƨ�, ��U�@�h�l�ؿ������ɮץ��� move �^ $dirname �U
	$handle=opendir($dirname);
	$j = 0;
	while ($file = readdir($handle)) {
		$fname[$j] = $file;
		$j++;
	}
	closedir($handle);
	if (count($fname) > 2 ){
		//�@�Ӥ@�����ˬd, �ݬO�_�O��Ƨ�,
		for ($i=2;$i<$j;$i++){
			$filestype = filetype($dirname.$fname[$i]);
			if($filestype == "dir"){
				//�u�B�z�U�@�h�l�ؿ����� file �Ω��U�٦��l�ؿ�, �����z�|
				//��U�@�h�l�ؿ������Ҧ��ɮ�, move �^�W�h, �A��l�ؿ��W�R��
				$sub_handle=opendir($dirname.$fname[$i]);
				$sub_j = 0;
				while ($sub_file = readdir($sub_handle)) {
					$sub_fn[$sub_j] = $sub_file;
					$sub_j++;
				}
				closedir($sub_handle);
				if ( $sub_j > 2) {
					for ($sub_i=2; $sub_i<$sub_j; $sub_i++){
						if (filetype($dirname.$fname[$i]."/".$sub_fn[$sub_i])=="file"){
							copy($dirname.$fname[$i]."/".$sub_fn[$sub_i],$dirname.$sub_fn[$sub_i]);
							unlink($dirname.$fname[$i]."/".$sub_fn[$sub_i]);
						}
					}
				}
				//�ˬd�o�Ӥl�ؿ�, �Y?���w�S�������ɮ�, rmdir()
				$sub_handle=opendir($dirname.$fname[$i]);
				$sub_j = 0;
				while ($sub_file = readdir($sub_handle)) {
					$sub_fn[$sub_j] = $sub_file;
					$sub_j++;
				}
				closedir($sub_handle);
				if ($sub_j == 2) rmdir($dirname.$fname[$i]);
			}
		}
	}
}



function dealimage($dirname,$fname){
	global $m_arr; //�b config.php ���N�w���X
	//�@�ӭ��ˬd, �u�B�z "�ɮ�" ������, �Y�O "�ؿ�" �����z�|
	//ob_flush();
	$filestype = filetype($dirname.$fname);
	if($filestype == "dir"){
		echo "<center>�ɦW: ".$fname." �O��Ƨ�, ���L�I</center>\n\r";
	}elseif((substr($fname,0,3)=="Si-") or (substr($fname,0,3)=="Mi-")){
		echo "<center>�ɦW: ".$fname." �w�B�z�L, ���L�I</center>\n\r";
	}elseif($filestype == "file"){
		// �ˬd�Ϥ��榡-> GetImageSize[2] �^�ǭ�=> 1:gif  2:jpg  3:png
		$imagesize = GetImageSize($dirname.$fname);
		//  jpg png �����H�~���Ҧ��ɮ�, �R��
		if ( $imagesize[2] != 2 and $imagesize[2] != 3){
			echo  "<center>�ɦW: ".$fname." �榡���šA�v�R���I</center>\n\r";
			unlink($dirname.$fname);
		}else{
			$pn_dest_img_s = "Si-".$fname;
			$pn_dest_img_m = "Mi-".$fname;

			$pn_mwidth = ($m_arr["MWidth"]=="") ? 640 : $m_arr["MWidth"];
			$pn_mlength = ($m_arr["MLength"]=="") ? 480 : $m_arr["MLength"];
			$pn_swidth = ($m_arr["SWidth"]=="") ? 200 : $m_arr["SWidth"];
			$pn_slength = ($m_arr["SLength"]=="") ? 150 : $m_arr["SLength"];

			//�I�s�Y�Ϩ禡
			ResizeImage($dirname.$fname,$dirname.$pn_dest_img_m,$pn_mwidth,$pn_mlength,95);
			ResizeImage($dirname.$fname,$dirname.$pn_dest_img_s,$pn_swidth,$pn_slength,95);
			unlink($dirname.$fname);
			//echo "�@�v�����C";
		}
	}
}

/***************
newsmig ��ƪ����

news_sno	->	�y����
title		->	�s�D���D
posterid	->	�K�s�D�̪����� id
news		->	�s�D���e
postdate	->	�ɶ�
newslink	->	�����s��

****************/

//�Ystatus�O�ŭ�, �N�O�s�W
$pn_act = $_REQUEST["act"];
if ($pn_act=="") $pn_act = "add";
$pnStatus = "";

//$todayis = date("Y-m-d H:s",time()); �bmodule-cfg.php���v�w�q
//$timestamp = time();�bmodule-cfg.php���v�w�q

$isDataOK = false;  //�ϥΪ̩Ҷ񪺸�ƬO�_OK

//���o�ϥΪ̸��
$teacher_id = $_SESSION["session_log_id"];
userdata($teacher_id);


//���i�����ˬd�A�Y�S���ť����A�A�~��H�U�ʧ@
if ($_POST["btnOK"] or $_POST["btnOnce"] or $_POST["btnAll"]){
	$pn_title = $_POST["txtTitle"];
	$pn_news = $_POST["txtNews"];
	$pn_newslink = $_POST["txtNewsLink"];
	//$pn_act = $_POST["hdnAct"];
	$pn_rdsno = $_POST["hdnRdsno"];

	if ($pn_title=="" and $_POST["btnOK"]){
		$pnMsg = "�S��u���D�v�I�иɶ��A�A�I�@���u�e�X�v";
	}elseif ($pn_news=="" and $_POST["btnOK"]){
		$pnMsg = "�S��u�s�D���e�v�I�иɶ��A�A�I�@���u�e�X�v";
	}else{
		$isDataOK = true;
	}
}else{
	$pn_rdsno = $_REQUEST["rdsno"];
}

//�ק�ΧR���Ҧ��U, �����ˬd�i�K�̦W�٬O�_���T, �����T���i���L�ʧ@
if (($pn_act=="mod" or $pn_act=="del") and $pn_rdsno!=""){
	$sqlis = "SELECT posterid \n\r";
	$sqlis.= "FROM newsmig\n\r";
	$sqlis.= "WHERE news_sno='$pn_rdsno\n\r'";
	$rsis = $CONN -> Execute($sqlis);
	if ($rsis) {
		list($pn_posterid) = $rsis -> FetchRow();
		if ($pn_posterid!=$teacher_id) {
			$pnMsg = "No.".$pn_rdsno." ���h�s�D���O�z�ҵo�G, �Фŭק�C�ثe���s�W�s�D�Ҧ�";
			$pn_act="add";
			$pn_rdsno = "";
		}
	}else{
		$pnMsg = "<br>�t�ο��~�G".$CONN -> ErrorMsg()."</br>";
	}
}

/****
  `news_sno` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(60) default NULL,
  `posterid` varchar(10) default NULL,
  `news` text,
  `postdate` datetime NOT NULL default '0000-00-00 00:00:00',
  `newslink` varchar(70) default NULL
******/


//���B�z��ƪ�����, ���o rdsno��, �A�W�ǹϤ�
if ($_POST["btnOK"] and $isDataOK){
	if ($pn_act=="add"){
		$sql ="INSERT INTO newsmig \n\r";
		$sql.="  (title,posterid,news,postdate,newslink) \n\r";
		$sql.="VALUES \n\r";
		$sql.="  ('$pn_title','$teacher_id','$pn_news','$todayis','$pn_newslink') \n\r";
		$rs= $CONN -> Execute($sql);
		if ($rs){
			$pnMsg = "<br><font color='blue' size='+2'>�s�D�s�W���\!</font><br>";
		}else{
			$pnMsg = "<br><font color='blue' size='+2'>�s�D�s�W���ѡI�]���t�εo�͡G".$CONN->ErrorMsg()."</font><br>";
		}
		//�g�J��, �ߨ�� $pn_rdsno��X
		$sql = "SELECT news_sno FROM newsmig WHERE posterid='$teacher_id' AND postdate = '$todayis' ";
		$rs = $CONN -> Execute($sql);
		if ($rs) list($pn_rdsno) = $rs -> FetchRow();
	}elseif($pn_act=="mod"){
		$sql ="UPDATE newsmig \n\r";
		$sql.="SET	\n\r";
		$sql.="		title='$pn_title', \n\r";
		$sql.="		posterid='$teacher_id', \n\r";
		$sql.="		news='$pn_news', \n\r";
		$sql.="		postdate='$todayis', \n\r";
		$sql.="		newslink='$pn_newslink' \n\r";
		$sql.="WHERE news_sno='$pn_rdsno' \n\r";
		$rs= $CONN -> Execute($sql);
		if ($rs){
			$pnMsg = "<br><font color='blue' size='+2'>�s�D�ק令�\!</font><br>";
			$pnStatus ="ModOk";
		}else{
			$pnMsg = "<br><font color='blue' size='+2'>�s�D�ק異�ѡI�]���t�εo�͡G".$CONN->ErrorMsg()."</font><br>";
		}
	}elseif($pn_act=="del"){
		$sql = "DELETE FROM newsmig WHERE news_sno='$pn_rdsno'";
		$rs = $CONN -> Execute($sql);
		if ($rs){
			//�n��Ϥ��]�@�֧R��, ���� $savepath/$rdsno/ ��Ƨ��Ψ䤺�e
			$pn_dir = $savepath.$pn_rdsno."/";
			clearstatcache( );
			$fexist = file_exists($pn_dir);
			// �p�G�d�o�쥻�ؿ�, �A���R�����ʧ@
			if ($fexist){
				clearstatcache();
				$handle=opendir($pn_dir);
				$j = 0;
				while ($file = readdir($handle)) {
					$filesname[$j] = $file;
					$j++;
				}
				closedir($handle);
				for ($i=0;$i<=count($filesname);$i++){
					if (($filesname[$i]!=".") or ($filesname[$i]!="..")){
						unlink($pn_dir.$filesname[$i]);
					}
				}
				rmdir(rtrim($pn_dir,"/"));
			}

			//show ���\�� message
			$pnMsg = "<br><font color='blue' size='+2'>�s�D�R�����\!</font><br>";
			$pnStatus = "DelOk";
		}else{
			$pnMsg = "<br><font color='blue' size='+2'>�s�D�R�����ѡI�]���t�εo�͡G".$CONN->ErrorMsg()."</font><br>";
		}
	}

	//echo "<br>".$sql."<br>";
}


//�W�ǹ��ɥؿ��W���p�Z�G $UPLOAD_PATH/school/newsmig/$newsno/
//�ҥH�n����s�D insert into �� table ���o news_sno ��, �A�W�ǹϤ�
//�u�n�̦��W�h, ��ӥؿ��U�ˬd�O�_���ɮ׫K�����S���W�ǹϤ�
clearstatcache();
$pn_dir = $savepath.$pn_rdsno."/";
$direxist=file_exists($pn_dir);
if (!$direxist){
	mkdir("$pn_dir",0777);
}

//�W�ǹϤ���k�@���B�z, �`�N, apache �| time out

for ( $i=0;$i<12;$i++){
	$j = $i +1;
	// �P�_�O�_���W�ǹϤ�,�ӥB���o�O�ק�Ҧ�
	if ($_FILES["fleImgName"]["name"][$i] != "" and $pn_act=="add"){
		$pn_src_img[$i]=$_FILES["fleImgName"]["name"][$i];
	}else{
		$pn_src_img[$i] = "none";
	}

	//��Ϥ��W��, �̫�� temp �ɧR��
	if ($pn_src_img[$i] != "none"){
		if (copy($_FILES["fleImgName"]["tmp_name"][$i],$pn_dir.$pn_src_img[$i])){
			$pnMsg .="<br>�Ϥ� ".$j."�G".$_FILES["fleImgName"]["name"][$i]." �W�Ǧ��\�I<br>\n\r";
			//$pnMsg .="�ɮ� ".$j." �Ȧs�G".$_FILES["fleImgName"]["tmp_name"][$i]."<br>\n\r";
			//$pnMsg .="�ɮ� ".$j." �����G".$_FILES["fleImgName"]["type"][$i]."<br><br>";
			unlink($_FILES["fleImgName"]["tmp_name"][$i]);

		}else{
			$pnMsg .= "<br>�Ϥ��W�ǥ��ѡI<br>";
		}
	}
}

//�W�ǹϤ���k�G: �W�� zip ��
if ($_FILES["fleZip"]["name"][$i] != "" and $pn_act=="add"){
	$pn_src_zip = $_FILES["fleZip"]["name"];
	if(copy($_FILES["fleZip"]["tmp_name"],$pn_dir.$pn_src_zip)){
		$pnMsg .="<br>���Y�� ".$j."�G".$_FILES["fleZip"]["name"]." �W�Ǧ��\�I<br>\n\r";
		unlink($_FILES["fleZip"]["tmp_name"]);
		//�}�l�����Y -> �|�b pn_dir �U�Ѷ}�Ҧ��ɮ�, �^�Ǹ����Y�ɩҲ��ͪ��T��
		$pnMsg .= unzip($pn_dir,$pn_src_zip);

		//�����Y��, �ˬd�O�_���t��Ƨ�, �Y�� -> �⩳�U���ɮײ��W��
		submvup($pn_dir);

		// �令��V�t�@��M���B�z�Ϥ����{��(�άO�禡)
	}
}else{
	$pn_src_zip = "none";
}


//���Ʊa�X�ӡC
//��b�o�̬O�]���A�Y���ק�@�w�n���x�s�A select ,�_�h�|����¸��, ���n�O�ܼƷ|�Q�ﱼ
if ($pn_rdsno!=""){
	$sqlsh = "SELECT title,posterid,news,newslink \n\r";
	$sqlsh.= "FROM newsmig \n\r";
	$sqlsh.= "WHERE news_sno='$pn_rdsno\n\r'";
	$rssh = $CONN -> Execute($sqlsh);
	if ($rssh) {
		list($pn_title,$pn_posterid,$pn_news,$pn_newslink) = $rssh -> FetchRow();
	}else{
		$pnMsg .= "<br>�䤣�쥻���s�D<br>";
	}
}

?>
<center>
<h3>
	<?
		echo $user_name."  �A�n�@�@";
		if($pn_act == "add"){
			echo "�s�W�s�D";
		}elseif($pn_act == "mod"){
			echo "�ק�s�D";
		}elseif($pn_act == "del"){
			echo "�R���s�D";
		}
		if ( $pnStatus != "" ) {
			echo " �w���� \n\r";
		}else{
			echo " �� \n\r";
		}
	?>
</h3>
<form  name="frmPostNews" action="postnews.php" method="POST" enctype="multipart/form-data">

<?php
// �o�q�{���X�γ~�G�B�z�Ϥ��ҥH�n�[�� if , �s�W��, �]�O�� insert �J��Ʈw, ���ordsno��,�A�B�z
// �Ϥ��C
if (($_POST["btnOK"] and $pn_act=="add") or $_POST["btnAll"]){
	echo "<center><hr> \n\r";

	//�A��W�ǥؿ������Ҧ��v���ɶi���y
	set_time_limit(0);

	//�bpostnews.php�� �n�`�N���O, �X�ӨϥΪ̿�J����Ƥ����@���a�i�a�X(��session)
	if(!session_is_registered("newsmig_status")) {
		clearstatcache();
		$handle=opendir($pn_dir);
		$j = 0;
		while ($file = readdir($handle)) {
			$filesname[$j] = $file;
			$j++;
		}
		//�Y��3����+'.'��'..' -> ������ $filesname[0-4] , �� $j = 5
		closedir($handle);


		for ($i=0;$i<$j;$i++){
			$sename = "imgfiles_".$i;
			session_register($sename);
			$_SESSION[$sename]=$filesname[$i];
		}
		//session_register("newsmig_num");
		$_SESSION["newsmig_num"] = $j - 2; //�Ϥ��ƥ�

		//session_register("newsmig_status"); //�Ϥ��B�z���A, �����Ϥ��B�z����, ���� "end"
		$_SESSION["newsmig_status"] = "start";

	}
	echo "<h3>�W�ǥؿ����@���@".$_SESSION["newsmig_num"]."�@���ɮ�</h3>\n\r";

	$MN = $_SESSION["newsmig_num"]+2;

	if($_POST["btnAll"]){
		for ($i=0;$i < $MN;$i++){
			$fn = "imgfiles_".$i;
			dealimage($pn_dir,$_SESSION[$fn]);
		}
		//�Ҧ��ɮפv�B�z��
		//session_unregister("newsmig_status");
		$newsmig_status="end";
		for ($i=0; $i<$MN; $i++){
			$sename = "imgfiles_".$i;
			session_unregister($sename);
		}
		echo "<br>���߱z�I�Ϥ��v�����ഫ���\�C�s�D�s�W�����A���I�U�誺�u�^�s�D�`���v�˵��C<hr>";
	}

	if ($_SESSION["newsmig_status"]=="start"){
		//for ($i=0;$i<$_SESSION["newsmig_no1"];$i++) echo "+";
		echo "<table width='620' align='center' cellspacing='2' bgcolor='#FBFF00'>\n\r";
		//echo "<tr><td colspan='2' align='center'><h3>�п�ܧA�n���檺�Ҧ�</h3></td></tr>\n\r";
		echo "<tr><td colspan='2'>&nbsp;</td></tr>\n\r";
		echo "<tr>\n\r";
		echo "	<td align='right' valign='top'>";
		echo "		<input type='submit' name='btnAll' value='�@���ѨM(��20�i��)'></td>\n\r";
		echo "	<td><ol><li>�B�z�L�{���A�e���|�Ȱ��ܤ[�A�Э@�ߵ��ԡI</li>\n\r";
		echo "		<li>�ФŶǶW�L20�i�H�W�A�Y�Ϥ��Ǥ��W�h�A�и�T�H���ץ� php.ini �ɮפW�Ǥj�p������C</li>";
		echo "		</ol>";
		echo "	</td> \n\r";
		echo "</tr> \n\r";
		echo "<tr><td colspan='2'>&nbsp;</td></tr>\n\r";
		echo "</table> \n\r";
	}

	$handle=opendir($pn_dir);
	//echo "SavePath is : ".$pn_dir."\n\r";
	//echo "<br>Directory handle: $handle\n\r";

	clearstatcache( );
	$fexist = file_exists($pn_dir);
	// �p�G�d�o�쥻�ؿ�
	if ($fexist){
		$handle=opendir($pn_dir);
		$j = 0;
		while ($file = readdir($handle)) {
			$pn_files[$j] = $file;
			$j++;
		}
		closedir($handle);
		//clearstatcache;
		echo "<br>";
		echo "<table align='center' width='620'> \n\r";
		echo "<tr><td colspan='2' align='center'>�ثe��Ƨ������ɮסG</td></tr>";
		echo "<tr><td colspan='2'>&nbsp;</td></tr>";

		for ($i=0;$i<$j;$i++){
			clearstatcache();
			$pn_filetype = filetype($pn_dir.$pn_files[$i]);
			//$k = $i - 1;
			$k = $i;
			echo "	<tr>";
			if ($pn_filetype == "dir"){
				echo "<td>�� $k ���ɬO : ".$pn_files[$i]."</td><td>Type :".$pn_filetype."--> �����B�z�I</td>\n\r";
			}elseif (substr($pn_files[$i],1,2)=='i-'){
				echo "<td>�� $k ���ɬO : ".$pn_files[$i]."</td><td>Type :".$pn_filetype."--> OK! </td>\n\r";
			}else {
				echo "<td>�� $k ���ɬO : ".$pn_files[$i]."</td><td>Type :".$pn_filetype."--> �ݳB�z...</td> \n\r";
			}
			echo "	</tr>\n\r";
		}
		echo "</table>\n\r";
	}
	echo "</center>\n\r";
	echo "<hr>";
}
?>

<table align="center" bgcolor="#B7FF00" width="620" border="0">
  <tr>
  	<td colspan="2" align="center" bgcolor="#1F03D4" height="36">
		<font color="#FBFF00">�򥻸�ư�</font>
	</td>
  </tr>
  <tr>
    <td height="40" width="110" align="right">����G</td>
    <td><?php echo substr($todayis,0,10); ?>
		<input type="hidden" name="hdnDate" value="<?php echo $todayis; ?>">
	</td>
  </tr>
  <tr>
    <td height="50" width="110" align="right">���D�G</td>
    <td>
		<input type="text" name="txtTitle" size="24" align="left" value="<? echo $pn_title; ?>">�@(����)
	</td>
  </tr>
  <tr>
    <td height="40" width="110" align="right">�s�D���e�G<br>(����)</td>
    <td><textarea name="txtNews" cols="42" rows="5" wrap="physical" ><? echo $pn_news; ?></textarea></td>
  </tr>
  <tr>
    <td height="40" width="110" align="right">�����s���G</td>
    <td><input type="text" name="txtNewsLink" size="54" maxlength="70" align="left" value="<? echo $pn_newslink; ?>"></td>
  </tr>
  <tr>
  	<td colspan="2" align="center" bgcolor="#1F03D4" height="36">
		<font color="#FBFF00">�W�ǹϤ���k�@�G�@�@�i�i�W�ǡA���Q�G�i�H��</font>
	</td>
  </tr>

  <?php
	$isDisable = "";
	if ($pn_act=="mod") $isDisable = "disabled";

  	//���12�i�Ϥ��W�ǵe�����j��
	for($i=0;$i<12;$i++){
		$j = $i+1;
		echo "  <tr>\n\r";
		echo "	<td width='110' align='right' height='28'>�Ϥ�".$j."</td>\n\r";
		echo "	<td><input ".$isDisable." size='46' type='file' name='fleImgName[]'></td>\n\r";
		echo "  </tr>\n\r";
	}
  ?>

  <tr>
  	<td colspan="2" align="center" bgcolor="#1F03D4" height="36">
		<font color="#FBFF00">�W�ǹϤ���k�G�G�@��Ҧ��Ϥ������@��zip�ɡA�A�W��(��ĳ30�i�H��)</font>
	</td>
  </tr>
  <tr>
  	<td align="right">Zip�ɡG</td>
  	<td><input <? if ($pn_act=="mod") echo "disabled"; ?> size="46" type="file" name="fleZip"></td>
  </tr>
</table>
<br>

<input type="submit" name="btnOK" value="�T�w" >�@
<input type="reset" name="btnCancel" value="�M������">�@
<input type="hidden" name="act" value="<? echo $pn_act; ?>">
<input type="hidden" name="hdnRdsno" value="<? echo $pn_rdsno; ?>">

</form>
<table cellspacing="0" border="1">
<tr bgcolor="#E1E0C9"><td><a href="newslist.php"><font size="+2">�^�s�D�`��</font></a></td></tr>
</table>
<br>
<table width="620" bgcolor="#CFFBFF">
	<tr>
	<td>
	<ul>
		<li>�s�D���D�ηs�D���e�A���o�ťաC</li>
		<br>
		<li>�ϥΨB�J�G�C</li>
		<br>
		<ol>
		<li>�g�J�s�D�äW�ǹϤ�</li><br>
			<dl>��k�@�G�@�i�i�ǡA���Q�G�i�H���C</dl>
			<br>
			<dl>��k�G�G�n����Ҧ��Ϥ����Y��zip�榡�A�A�W�ǡA�S���i�ƭ���C���Ophp���W���ɮפj�p������A�Ԭ���T�ժ��C</dl>
			<br>
			<dl><font color="#FF1D11">�ϥ�zip�榡�W�ǹϤ��̽Ъ`�N�A���Y�ɤ����o���t��Ƨ��C</font></dl>
			<br>
			<dl>�s�D�Ϥ��u����<font color="#FF1D11"> png </font>��<font color="#FF1D11"> jpeg </font>���榡�C</dl>
			<br>
		<li>���Y�Ϥ�</li><br>
			<dl><b><font color="#FF1D11">�W�ǹϤ���A�t�η|�C�X�Ҧ����Ϥ��A�Ш̫��ܦA�i��Ϥ������Y�u�@(�@�j�i --> �Y�� "����M-" �� "�p��S-" �U�@�i)�C</font></b></dl>
			<br>
			<dl>�Y�Ϫ�Size�i�b�Ҳժ��ܼƺ޲z�]�w�C</dl>
			<br>
		<li>�H�W��ӨB�J�A�t�η|�۰ʳB�z�C������Ϥ��Τ�r��J���A���@���u�T�w�v�A�ݨt�Χ�X�Ҧ��Ϥ��A
			�۵M�|���i�@�B���ܡA�u�n�A�̫��ܫK�i�B�z�����C</li>
		</ol>
		<br>
		<li><b><font color="#FF1D11">�ק�Ҧ��u��ק��r�A�L�k���ǷӤ��A�Y�n�ק�Ӥ��A�ЧR�����h�s�D���ӡC</font></b></li>
	</ul>
	</td>
	</tr>
</table>
<br>
<table bgcolor="#FF0004" width="620">
	<tr>
		<td align="left" width="15%" height="40"><font color="#51FF00">�T���G</font></td>
		<td align="left" width="85%"><font color="#51FF00"><? echo $pnMsg; ?></font></td>
	</tr>
</table>
</center>

<?php
if ($m_arr["IS_STANDALONE"]=='0'):
	//SFS3�G������
	foot();
else:?>
</body></html>
<?php
endif;
?>
