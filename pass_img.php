<?php
//$Id: pass_img.php 6800 2012-06-22 07:48:38Z smallduh $

//session_start();
include "include/config.php";
$img=new pass_img();//�إߪ���
$img->show();

class pass_img {
	var $pass;//����X
	var $height=30;//�Ϥ�����
	var $weight=110;//�Ϥ��i��
	var $font_file="harvey.ttf"; //from http://font101.com/	

	function pass_img() {
		$t1=range('A','Z');
		$t2=range('a','z');

		mt_srand((double)microtime()*1000000);
		$this->pass=$t1[mt_rand(0,25)].$t2[mt_rand(0,25)].sprintf("%04d",mt_rand(1,9999));

		//����X�g�Jsession
		unset($_SESSION["Login_img"]);	
		//session_register("Login_img");
		$_SESSION["Login_img"]=$this->pass;
	}

	function show($font_no=0) {
		//���o�]�w��
		$c=chk_login_img("","",2);

		$f_name = dirname(__file__)."/images/pass1.png"; //���ɦW��
		if ($c['FONT_NO']==1) {
			$this->font_file="sir.ttf";
			$fs = 20; // �r��j�p
			$fx = 6; //�r�}�Y x �y��
			$fy = 20; //�r�}�Y y �y��
			$xoffset = 3; //�C�Ӧr���Z��
		} elseif ($c['FONT_NO']==2) {
			$this->font_file="epilog.ttf";
			$fs = 26; // �r��j�p
			$fx = 0; //�r�}�Y x �y��
			$fy = 24; //�r�}�Y y �y��
			$xoffset = 3; //�C�Ӧr���Z��
		} elseif ($c['FONT_NO']==3) {
			$this->font_file="hotshot.ttf";
			$fs = 20; // �r��j�p
			$fx = 0; //�r�}�Y x �y��
			$fy = 22; //�r�}�Y y �y��
			$xoffset = 2; //�C�Ӧr���Z��
		} elseif ($c['FONT_NO']==4) {
			$this->font_file="arial.ttf";
			$fs = 18; // �r��j�p
			$fx = 0; //�r�}�Y x �y��
			$fy = 22; //�r�}�Y y �y��
			$xoffset = 2; //�C�Ӧr���Z��

		} else {
			$fs = 24; // �r��j�p
			$fx = -4; //�r�}�Y x �y��
			$fy = 32; //�r�}�Y y �y��
			$xoffset = 2; //�C�Ӧr���Z��
		}
		$this->font_file="fonts/".$this->font_file;

		//���͹Ϥ�
		$origImg = @imagecreate($this->weight,$this->height);
		$backgroundcolor = ImageColorAllocate($origImg,255,255,255);
	
		//�v���B�z
		$font_box=array();
		for($i=0;$i<strlen($this->pass);$i++) {
			//�v�r�B�z
			$w=substr($this->pass,$i,1);
			//�üƲ��ͤ�r�C��
			$textcolor=ImageColorAllocate($origImg,rand(0,255*$c['COLOR']),rand(0,128*$c['COLOR']),rand(0,255*$c['COLOR']));
			//�üƲ��ͨ���
			$fa=($i*$c['SLOPE']>2)?(rand(-20,-10)):-20;
			//�e�X��r
			ImageTTFText($origImg,$fs,$fa,$fx,$fy,$textcolor,$this->font_file,$w);
			//�p��U�@�Ӧr��x�y��
			$font_box=array();
			$font_box=imagettfbbox($fs,0,$this->font_file,$w);
			$fx+=$font_box[4]+$xoffset;
		}

		//�[�J�z�Z����
		if ($c['DOT']) {
			for($i=0;$i<300;$i++)	{
				$randcolor = ImageColorallocate($origImg,rand(0,255),rand(0,255),rand(0,255));
				imagesetpixel($origImg,rand()%$this->weight,rand()%$this->height,$randcolor);
			}
		}

		// ���ͳ̲�PNG�Ϥ��åB����O����
		ImagePNG($origImg);

	//�������M�ϧ�origImg���p���O����
		ImageDestroy($origImg);
	}
}
?>
