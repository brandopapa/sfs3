<?php
// $Id: function.php 5310 2009-01-10 07:57:56Z hami $

//�ʭ��ɮפW�Ǩ禡
    function cover_upload_file($bh_sn){
		global $CONN,$UPLOAD_PATH;
        //�P�_�W���ɮ׬O�_�s�b
        if (!$_FILES['userdata']['tmp_name']) user_error("�S���ǤJ�ɮץN�X�I���ˬd�I");
        if (!$_FILES['userdata']['name']) user_error("�S���ǤJ�ɮץN�X�I���ˬd�I");
        if (!$_FILES['userdata']['size']) user_error("�S���ǤJ�ɮץN�X�I���ˬd�I");
		if (!$bh_sn) user_error("�S���ǤJ�ؿ��N�X�I���ˬd�I");
		$new_name= $bh_sn.".jpg";
		unlink ($UPLOAD_PATH."blog/cover/$new_name");
        //�ƻs�ɮר���w��m
		if(!is_dir($UPLOAD_PATH."blog")) mkdir ($UPLOAD_PATH."blog", 0700);
		if(!is_dir($UPLOAD_PATH."blog/cover")) mkdir ($UPLOAD_PATH."blog/cover", 0700);
        copy($_FILES['userdata']['tmp_name'], $UPLOAD_PATH."blog/cover/$new_name");
		//�I�s�Y�Ϩ禡
    	ImageCopyResizedTrue($UPLOAD_PATH."blog/cover/$new_name",$UPLOAD_PATH."blog/cover/$new_name",200,150		);
        //�����Ȧs��
        unlink ($_FILES['userdata']['tmp_name']);

	}


/*  Convert image size. true color*/
    //$src        �ӷ��ɮ�
    //$dest        �ت��ɮ�
    //$maxWidth    �Y�ϼe��
    //$maxHeight    �Y�ϰ���
    //$quality    JPEG�~��
    function ImageCopyResizedTrue($src,$dest,$maxWidth,$maxHeight,$quality=100) {

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

	//��s�������
	function update_home($bh_sn){
		global $CONN,$style,$alias,$main,$direction;
		$alias=trim($alias);
		$main=trim($main);
		$direction=trim($direction);
		$sql="update blog_home set  style='$style' , alias='$alias' , main='$main' ,direction='$direction' where bh_sn='$bh_sn' ";
		//echo $sql;
		$CONN->Execute($sql) or trigger_error($sql,256);
	}



	function save_content($bc_sn){
		global $CONN,$content,$content2,$title;
		if(!$bc_sn){
			echo "<html><body>
			<script LANGUAGE=\"JavaScript\">
			alert(\"�Х���ܤ峹���O�M���D\");
			</script>
			</body>
			</html>";
		}else{
			$sql="update blog_content set title='$title' , content='$content' ,content2='$content2', dater=now() where bc_sn='$bc_sn' ";
			$CONN->Execute($sql) or trigger_error($sql,256);
		}
	}

	function del_content($bc_sn){
		global $CONN,$UPLOAD_PATH;
		$sql="delete from blog_content where bc_sn='$bc_sn' ";
		$CONN->Execute($sql) or trigger_error($sql,256);
		//���K���ɮקR��
		$handle=opendir($UPLOAD_PATH."blog/content/".$bc_sn);
		while ($file = readdir($handle)) {
			if($file != "." and $file != "..") unlink ($UPLOAD_PATH."blog/content/".$bc_sn."/".$file);
		}
		closedir($handle);
		rmdir ($UPLOAD_PATH."blog/content/".$bc_sn);
	}

	function del_kind($kind_sn){
		global $CONN;
		//�ˬd�����O�O�_���峹
		$sql="select count(*) from blog_content where kind_sn='$kind_sn' ";
		$rs=$CONN->Execute($sql) or trigger_error($sql,256);
		$counter=$rs->fields[0];
		if($counter=="0"){
			$sql="delete from blog_kind where kind_sn='$kind_sn' ";
			$CONN->Execute($sql) or trigger_error($sql,256);
		}
		else{
			echo "<html><body>
			<script LANGUAGE=\"JavaScript\">
			alert(\"�����O�|���峹�s�b�I\\n�T��R��\");
			</script>
			</body>
			</html>";
		}
	}

	function blog_error($mesg){
		echo $mesg."<br><button onclick=\"window.close()\">����</button>";
		exit;
	}


	function blog_quota($bh_sn){
		global $CONN,$UPLOAD_PATH;
		//���X�ӤH�t�B
		$sql="select * from blog_quota where teacher_sn='{$_SESSION['session_tea_sn']}' ";
		$rs=$CONN->Execute($sql) or trigger_error($sql,256);
		$size=$rs->fields['size'];
		$many=$rs->fields['many'];

		//�p�G0���ܥߨ赹�w�]��
		if(!$size) $CONN->Execute("insert into blog_quota (teacher_sn,size,many,enable) values('{$_SESSION['session_tea_sn']}','20','200','1')");

		if(!$size) $size=20;
		if(!$many) $many=200;


		//��bh_sn��X�X�U��bc_sn
		$sql="select bc_sn from blog_content where bh_sn='$bh_sn' and enable=1";
		//echo $sql;
		$rs=$CONN->Execute($sql) or trigger($sql,256);
		$i=0;
		$count=0;
		$amount=0;
		while(!$rs->EOF){
			$bc_sn_arr[$i]=$rs->fields['bc_sn'];
			//echo $bc_sn_arr[$i]."<br>";
			$path[$i]=$UPLOAD_PATH."blog/content/".$bc_sn_arr[$i];
			//echo $path[$i]."<br>";
			$handle[$i]=opendir($path[$i]);
			while ($file = readdir($handle[$i])) {
				if($file!="." and $file!=".."){
				//echo $file."<br>";
				$amount=$amount+filesize ($path[$i]."/".$file);
				$count++;
				}
			}
			closedir($handle[$i]);
			$i++;
			$rs->MoveNext();
		}
		$amount=round($amount/1024/1024,2);
		if(($amount>=$size) || ($count>=$many)) $q_mess[0]=0;//���F
		else $q_mess[0]=1;//�٥i�g�J
		$less=($size-$amount<0)?0:$size-$amount;
		$q_mess[1]="<font color='#606585'>�A���t�B�� $size MB�A�̦h�ɮ׼Ƭ� $many �ثe�|�� $less MB���Ŷ��M�|�i�e�� ".($many-$count)."�ӹ��ɡI</font>";

		return $q_mess;
	}

	//�P�_�O�_���t�κ޲z��
	function is_blog_admin(){
		global $CONN;
		$sql0="SELECT id_sn FROM pro_check_new WHERE pro_kind_id='1' and id_kind='�Юv' ";
		$rs0=$CONN->Execute($sql0) or trigger_error($sql0,256);
		if ($rs0) {
			while( $ar = $rs0->FetchRow() ) {
				$admin_arr[]=$ar['id_sn'];
			}
		}
		if(in_array( $_SESSION['session_tea_sn'],$admin_arr)) return 1;
		else return 0;
	}

?>
