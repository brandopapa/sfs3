<?php
// �ޤJ SFS3 ���禡�w
include "../../include/config.php";

// �ޤJ�z�ۤv�� config.php ��
require "config.php";

// �{��
sfs_check();

$bc_sn=($_POST['bc_sn'])?$_POST['bc_sn']:$_GET['bc_sn'];
$bh_sn=($_POST['bh_sn'])?$_POST['bh_sn']:$_GET['bh_sn'];
$image_name=($_POST['image_name'])?$_POST['image_name']:$_GET['image_name'];

if($_POST['s1']=="�W�ǹ���" && $bc_sn) {
	content_upload_file($bc_sn);
}
if($_POST['s2']=="�R��" && $bc_sn && $image_name){
	unlink ($UPLOAD_PATH."blog/content/".$bc_sn."/".$image_name);

}

if(!$bc_sn) echo"<table bgcolor='#FFF08B' align='center'><tr><td><font color='#FF0000'>�Х���ܤ峹�I</font></td></tr></table><button onclick=\"window.close()\">����</button>";
else{
	//�ɮ׺��F�S
	$quota_message=blog_quota($bh_sn);



	//�M����ɬ����T��
	$file_list.="<tr bgcolor='#FaFaFa'><td>�ɦW</td><td>�j�p</td><td align='center'>�K�W</td><td align='center'>�R��</td></tr>";
	$image_path = $UPLOAD_PATH."blog/content/".$bc_sn;
	$handle=opendir($image_path);
	while ($file = readdir($handle)){
		if ($file != "." and $file != ".." ) {
			$url_str6=$UPLOAD_URL."blog/content/".$bc_sn."/".$file;
			$file_list.="<tr bgcolor='#FAFAFA'>
			<td onclick=\"window.open('$url_str6','$file','width=340,height=320,resizeable=yes,scrollbars=yes')\" style=\"cursor:help\">$file</td>
			<td>".round(filesize ($UPLOAD_PATH."blog/content/".$bc_sn."/".$file)/1000,1)."k</td>
			<td><button onclick=\"call('$url_str6')\">�K�W�@��</button><button onclick=\"call2('$url_str6')\">�K�W�G��</button></td>
			<td>
				<form action='{$_SERVER['PHP_SELF']}' method='POST'>
					<input type='hidden' name='bc_sn' value='$bc_sn'>
					<input type='hidden' name='image_name' value='$file'>
					<input type='submit' name='s2' value='�R��'>
				</form>
			</td>
			</tr>";

		}

	}
	echo "
	<table cellspacing='6' align='center' bgcolor='#F5E2FD' width='100%'>
	<tr><td>$quota_message[1]</td></tr>
	<tr><td>
	���g�峹�ιϦC��<br>
	<table>$file_list</table>
	</td></tr></table>
	";

	if($quota_message[0]=="1"){
		echo "
		<table cellspacing='6' align='center' bgcolor='#F3CEF8' width='100%'><tr><td>
		�s�W���g�峹�ι�<br>
		<form action ='{$_SERVER['PHP_SELF']}' enctype='multipart/form-data' method='post'>
			<input type='hidden' name='bc_sn' value='$bc_sn'>
			<input type='file' name='userdata' >
			<input type='submit' name='s1' value='�W�ǹ���'><br>
		</form>
		</td></tr></table>
		<button onclick=\"window.close()\">����</button>
		";
	}else{
		echo "
		<table cellspacing='6' align='center' bgcolor='#F3CEF8' width='100%'><tr><td>
			�z�i�W�Ǫ��Ŷ��w���A�ЧR�������n�����ɩά��޲z�����z�[�j�Ŷ��I
		</td></tr></table>
		<button onclick=\"window.close()\">����</button>
		";
	}
}


//�ʭ��ɮפW�Ǩ禡
    function content_upload_file($bc_sn){
		global $CONN,$UPLOAD_PATH;
        //�P�_�W���ɮ׬O�_�s�b
        if (!$_FILES['userdata']['tmp_name']) blog_error("�S���ǤJ�ɮץN�X�I���ˬd�I",256);
        if (!$_FILES['userdata']['name']) user_error("�S���ǤJ�ɮץN�X�I���ˬd�I",256);
        if (!$_FILES['userdata']['size']) user_error("�S���ǤJ�ɮץN�X�I���ˬd�I",256);
		if (!$bc_sn) blog_error("�S���ǤJ�ɮץN�X�I���ˬd�I",256);
		$d_arr=explode(".",$_FILES['userdata']['name']);
		$new_name= $d_arr[0].".jpg";
        //�ƻs�ɮר���w��m
		if(!is_dir($UPLOAD_PATH."blog")) mkdir ($UPLOAD_PATH."blog", 0700);
		if(!is_dir($UPLOAD_PATH."blog/content")) mkdir ($UPLOAD_PATH."blog/content", 0700);
		if(!is_dir($UPLOAD_PATH."blog/content/".$bc_sn)) mkdir ($UPLOAD_PATH."blog/content/".$bc_sn, 0700);
        copy($_FILES['userdata']['tmp_name'], $UPLOAD_PATH."blog/content/".$bc_sn."/".$new_name);
		//�I�s�Y�Ϩ禡
    	ImageCopyResizedTrue2($UPLOAD_PATH."blog/content/".$bc_sn."/".$new_name,$UPLOAD_PATH."blog/content/".$bc_sn."/".$new_name,320,320);
        //�����Ȧs��
        unlink ($_FILES['userdata']['tmp_name']);

	}


/*  Convert image size. true color*/
    //$src        �ӷ��ɮ�
    //$dest        �ت��ɮ�
    //$maxWidth    �Y�ϼe��
    //$maxHeight    �Y�ϰ���
    //$quality    JPEG�~��
    function ImageCopyResizedTrue2($src,$dest,$maxWidth,$maxHeight,$quality=100) {

        //�ˬd�ɮ׬O�_�s�b
        if (file_exists($src)  && isset($dest)) {

            $destInfo  = pathInfo($dest);
            $srcSize   = getImageSize($src); //���ɤj�p
            $srcRatio  = $srcSize[0]/$srcSize[1]; // �p��e/��
            $destRatio = $maxWidth/$maxHeight;
            if ($destRatio > $srcRatio) {
                $destSize[1] = $maxHeight;
                $destSize[0] = $maxHeight*$srcRatio;
            }
            else {
                $destSize[0] = $maxWidth;
                $destSize[1] = $maxWidth/$srcRatio;
            }


            //GIF �ɤ��䴩��X�A�]���NGIF�নJPEG
            if ($destInfo['extension'] != "jpg") {
				echo "�z�ҤW�Ǫ��Ϥ����ɦW���Ojpg�A�t�Τw�۰��নjpg��";
				$dest = substr_replace($dest, 'jpg', -3);
			}

            //�إߤ@�� True Color ���v��
            $destImage = imageCreateTrueColor($destSize[0],$destSize[1]);

            //�ھڰ��ɦWŪ������
            switch ($srcSize[2]) {
                case 1: $srcImage = imageCreateFromGif($src); break;
                case 2: $srcImage = imageCreateFromJpeg($src); break;
                case 3: $srcImage = imageCreateFromPng($src); break;
                default: return false; break;
            }

            //�����Y��
            ImageCopyResampled($destImage, $srcImage, 0, 0, 0, 0,$destSize[0],$destSize[1],
                                $srcSize[0],$srcSize[1]);

            //��X����
            switch ($srcSize[2]) {
                case 1: case 2: imageJpeg($destImage,$dest,$quality); break;
                case 3: imagePng($destImage,$dest); break;
            }
            return true;
        }
        else {
            return false;
        }
    }
?>
<script language="JavaScript1.2">

	function call(url_str6){
		window.opener.fromsub(url_str6);
	}
	function call2(url_str6){
		window.opener.fromsub2(url_str6);
	}

</script>
