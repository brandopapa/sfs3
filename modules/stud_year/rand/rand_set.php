<?php
// $Id: rand_set.php 5310 2009-01-10 07:57:56Z hami $
class rand_set{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $options;//���οﶵ..���t��Ʈw
	var $SFS_PATH;
	var $UPLOAD_PATH;
	var $IS_JHORES;
	var $mPath;//�Ҳ��ɮ׸��|
   public function __construct()   {
   }
   
	function init(){
		$this->Seme=chkStr('Seme');
		$this->Grade=chkStr('Grade');	
	}
	function process(){
		$this->sGrade=$this->sGrade();
		if ($_GET[del]!='' ) $this->delfile();
		$this->List=$this->gList();	
		$this->sYear=$this->sYear();

		if ($this->Seme!='' && $this->Grade!='') {
			$this->rWord=$this->rWord($this->Seme,$this->Grade);
			if ($_POST[form_act]=='setSave') $this->setSave();
			$this->sClass=$this->gClass($this->Seme,$this->Grade);
			}

	}

  	//���
	function display(){
		head("�b�y�Ͷüƽs�Z");
		print_menu($this->sfs_menu);
		$tpl = __My_Path.'templates/'.$this->mod.'.htm';
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
		foot();//�G������
	}
	##################  �Ǵ��U�Ԧ����禡  ##########################
	function sYear() {
		$SQL = "select * from school_day where  day<=now() and day_kind='start' order by day desc ";
		$rs=$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		while(!$rs->EOF){
		$ro = $rs->FetchNextObject(false);
		// ��i$ro=$rs->FetchNextObj()�A���O�ȥΩ�s������adodb�A�ثe��SFS3���A��
		$year_seme=$ro->year."_".$ro->seme;
		$obj_stu[$year_seme]=$ro->year."�Ǧ~�ײ�".$ro->seme."�Ǵ�";
		}
		return $obj_stu;
	}

	##################�}�C�C�ܨ禡2##########################
	function sGrade($k='') {
		($this->IS_JHORES==6) ? $all_grade=array(7=>"�@�~��",8=>"�G�~��",9=>"�T�~��"):$all_grade=array(1=>"�@�~��",2=>"�G�~��",3=>"�T�~��",4=>"�|�~��",5=>"���~��",6=>"���~��");
		if ($k=='')	return $all_grade;
		else 	return $all_grade[$k];
	 }

	//�ǤJ�Ǵ�,�~��
	function rWord($Seme,$Grade){
		$ss=split("_",$Seme);
		 $GG=&$this->sGrade;
		switch ($ss[1]) {
			case '1':
				$rWord[Y]=$ss[0];
				$rWord[S]=2;
				$rWord[G]=$Grade;
				$rWord[Gw]=$GG[$Grade];
				break;//�����Z��
			case '2':
				$rWord[Y]=$ss[0]+1;
				$rWord[S]=1;
				$rWord[G]=$Grade+1;
				$rWord[Gw]=$GG[$Grade+1];
				break;//�����Z��
		} 
		return $rWord;
	}

	###########################################################
	##  �ǤJ�~��,�Ǧ~��,�Ǵ� �w�]�Ȭ�all��ܱN�ǥX�Ҧ��~�ŻP�Z��
	##  �ǥX�H  class_id  �����ު��}�C  
	function gClass($year_seme,$grade) {
		$CID=split("_",$year_seme);//093_1
		//$curr_year=sprintf("%03d",$CID[0]);
		$curr_year=$CID[0];
		$curr_seme=$CID[1];
		$ADD_SQL=" and c_year='$grade'  ";
		$SQL="select class_id,c_name,teacher_1 from  school_class where 
		year='$curr_year' and semester='$curr_seme' and enable=1  $ADD_SQL order by class_id  ";
		$rs=$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		//echo $SQL;
		if ($rs->RecordCount()==0) return"�|���]�w�Z�Ÿ�ơI";
		$obj_stu=$rs->GetArray();
		return $obj_stu;
	}


	function gList() {
		//96_2_1		$a=dir($this->mPath) or backe("�I�I���|�~���A�L�kŪ���I�I");
		while($file=$a->read()) {
		if( $file=='.' ||$file=='..' || $file=='.htaccess') continue;
		if (ereg("stu",$file))  continue;
		$f=explode('_',$file);
		$Seme=$f[0].'_'.$f[1];
		$Grade=$f[2];
		$AA[file]=$file;
		$AA[rWord]=$this->rWord($Seme,$Grade);
		$ary[]=$AA;
		unset($AA);
		}		
		return $ary;
	}
	function setSave() {
		if (count($_POST[Rand][class_id])==0) backe('����ѥ[�Z�šI');
		$AA[Rand]=$_POST[Rand];
		$AA[Rand][Seme]=$this->Seme;
		$AA[Rand][Grade]=$this->Grade;
		$AA[Rand][gName]=$this->sGrade($this->Grade);
		$AA[Rand][oldTol]=count($_POST[Rand][class_id]);
		$AA[Rand][rWord]=$this->rWord;
		
		
		
		$file=$this->mPath.$this->Seme.'_'.$this->Grade;
		if (!file_exists($file)) {
			$str=serialize($AA);
			$fpWrite=fopen($file,"a");//���}
			fwrite($fpWrite,$str);//�g�J
			fclose($fpWrite);//���W
			$URL=$_SERVER[PHP_SELF]."?step=".$this->mod;
			Header("Location:$URL");
		}else{ backe('�v���]�w�I�L�k�A�g�J�I');}

	}


	function delfile() {
		$delfile=$_GET[del];
		$info=$this->gFile($delfile);
		if ($info[Rand][Test]=='N') backe('�D�@��ާ@�Ҧ��A�L�k�R���I');
		
		
		$file=$this->mPath.$delfile;
		if (file_exists($file)) {
			$f2=$this->mPath.$delfile.'_stu';
			$f3=$this->mPath.$delfile.'_stu_OK';
			if (file_exists($f2)) backe('�v���ǥͰO��');
			if (file_exists($f3)) backe('�v���s�Z���G');
			unlink($file);
			$URL=$_SERVER[PHP_SELF]."?step=".$this->mod;
			Header("Location:$URL");
		}
	}
	//Ū���W�U�ɮ�
	function gFile($file) {
		//$file=$this->Fi;
		$f1=$this->mPath.$file;
		$f2=$this->mPath.$file.'_stu';//�򥻸����
		$f3=$this->mPath.$file.'_stu_OK';//�������G��
		//if (file_exists($f3)) backe('�v�����üƽs�Z�{�ǡA�T��s�I');
		if (file_exists($f1)) {
			$aa=file_get_contents($f1);
			$aa=unserialize($aa);
			}
		return $aa;
	}




//end class
}



