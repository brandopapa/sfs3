<?php
// $Id: rand_set_stu.php 5310 2009-01-10 07:57:56Z hami $
class rand_set_stu{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $options;//���οﶵ..���t��Ʈw
	var $SFS_PATH;
	var $UPLOAD_PATH;
	var $IS_JHORES;
	var $mPath;//�Ҳ��ɮ׸��|
	var $sex=array(1=>'�k',2=>'�k');
	var $sex1=array(1=>'<font color=#0000FF>�k</font>',2=>'<font color=#FF0000>�k</font>');
	var $join1=array(0=>'���ѥ[',1=>'�ѥ[',2=>'�欰���t',3=>'�S���');
   public function __construct()   {
   }
   
	function init(){
		$this->Fi=chkStr('Fi');
		$this->class_id=chkStr('class_id');
	}
	function process(){
		$this->sGrade=$this->sGrade();//�~�Ű}�C
		$this->List=$this->gList();//�ɮצC��	
		$this->sYear=$this->sYear();//�Ǵ��}�C
		//$this->sClass=$this->gClass($this->Seme,$this->Grade);//�Z�Ű}�C

		if ($this->Fi!='') $this->Info=$this->gFile();//Ū�����
		if ($this->Fi!='' && $_GET[act]=='mkFile' ) $this->mkFile();
		if ($this->Fi!='' && $_GET[act]=='delFile' ) $this->delFile();
		if ($this->Fi!='' && $this->class_id!='' && $_POST[act]=='stuSave') $this->stuSave();
		if ($this->Fi!='' && $this->class_id!='') $this->Stu=$this->allStu[$this->class_id];
	

	}

	//���ͦW�U
	function mkFile(){
		$file=$this->Fi;
		
		$f2=$this->mPath.$file.'_stu';//�򥻸����
		$f3=$this->mPath.$file.'_stu_OK';//�������G��

		foreach ($this->Info[Rand][class_id] as $class_id =>$class_name ){
		//echo $class_id.':'.$class_name.'<br>';
			$tmp=$this->gStu($class_id);
			foreach ($tmp as $sn=>$ary){
				$stu[$class_id][$sn][class_name]=$class_name;
				$stu[$class_id][$sn][sn]=$ary[student_sn];
				$stu[$class_id][$sn][stud_id]=$ary[stud_id];
				$stu[$class_id][$sn][seme_num]=$ary[seme_num];
				$stu[$class_id][$sn][stud_name]=$ary[stud_name];
				$stu[$class_id][$sn][stud_sex]=$ary[stud_sex];
				$stu[$class_id][$sn][type]='1';
				$stu[$class_id][$sn][ncla]='';
				$stu[$class_id][$sn][nnum]='';
				unset($ary);
				}					
			unset($class_id);unset($tmp);
		}
	
		$str=serialize($stu);
		$fpWrite=fopen($f2,"w");//���}
		fwrite($fpWrite,$str);//�g�J
		fclose($fpWrite);//���W
		$URL=$_SERVER[PHP_SELF]."?step=".$this->mod;
		Header("Location:$URL");
	}

	//�x�s�ܧ�
	function stuSave(){
		$file=$this->Fi;
		$class_id=$this->class_id;
		$stu=&$this->allStu;
		$f2=$this->mPath.$file.'_stu';//�򥻸����
		foreach ($_POST[type] as $sn=>$val){
			$stu[$class_id][$sn][type]=$val;
		}
		$str=serialize($stu);
		$fpWrite=fopen($f2,"w");//���}
		fwrite($fpWrite,$str);//�g�J
		fclose($fpWrite);//���W
		$URL=$_SERVER[PHP_SELF]."?step=".$this->mod.'&Fi='.$file.'&class_id='.$this->class_id;
		Header("Location:$URL");
	}
	//�R���W�U
	function delFile(){
		if ($this->Info[Rand][Test]=='N') backe('�D�@��ާ@�Ҧ��A�L�k�R���I');
		$file=$this->Fi;
		$f2=$this->mPath.$file.'_stu';//�򥻸����
		$f3=$this->mPath.$file.'_stu_OK';//�������G��
		if (file_exists($f3)) backe('�v�����üƽs�Z�{�ǡA�T��s�I');
		unlink($f2);
		$URL=$_SERVER[PHP_SELF]."?step=".$this->mod;
		Header("Location:$URL");
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
				break;//�W�Ǵ�
			case '2':
				$rWord[Y]=$ss[0]+1;
				$rWord[S]=1;
				$rWord[G]=$Grade+1;
				$rWord[Gw]=$GG[$Grade+1];
				break;//�U�Ǵ�
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
		//96_2_1//
		$a=@dir($this->mPath) or backe("�I�I���|�~���A�L�kŪ���I�I");
		while($file=$a->read()) {
		if( $file=='.' ||$file=='..' || $file=='.htaccess') continue;
		if (ereg("stu",$file))  continue;
		$f=explode('_',$file);
		$Seme=$f[0].'_'.$f[1];
		$Grade=$f[2];
		$AA[file]=$file;

		$f2=$this->mPath.$file.'_stu';//�򥻸����
		$f3=$this->mPath.$file.'_stu_OK';//�������G��
		if (file_exists($f3)) {$AA[f3]='Y';} else {$AA[f3]='';}
		if (file_exists($f2)) {$AA[f2]='Y';} else {$AA[f2]='';} 

		$AA[rWord]=$this->rWord($Seme,$Grade);
		$ary[]=$AA;
		unset($AA);
		}		
		return $ary;
	}
	//Ū���W�U�ɮ�
	function gFile() {
		$file=$this->Fi;
		$f1=$this->mPath.$file;
		$f2=$this->mPath.$file.'_stu';//�򥻸����
		$f3=$this->mPath.$file.'_stu_OK';//�������G��
		//if (file_exists($f3)) backe('�v�����üƽs�Z�{�ǡA�T��s�I');
		if (file_exists($f1)) {
			$aa=file_get_contents($f1);
			$aa=unserialize($aa);
			}
		if ( file_exists($f2)) {
			$ss=file_get_contents($f2);
			$this->allStu=unserialize($ss);//echo "<pre>";print_r($this->Stu);
			}

		return $aa;
	}


	
/* ���ǥͰ}�C,����stud_base��Pstud_seme��*/
	function gStu($class_id){
		$CID=split("_",$class_id);//093_1_01_01
		$year=$CID[0];
		$seme=$CID[1];
		$grade=$CID[2];//�~��
		$class=$CID[3];//�Z��
		$CID_1=$year.$seme;
		$CID_2=sprintf("%03d",$grade.$class);
		$SQL="select 	a.student_sn,a.stud_id,b.seme_num,
		a.stud_name,a.stud_sex,
		b.seme_year_seme,b.seme_class,a.stud_study_cond  
		from stud_base a,stud_seme b where 
		a.student_sn=b.student_sn	
		and b.seme_year_seme='$CID_1'
		and (a.stud_study_cond='0' or a.stud_study_cond='15')
		and b.seme_class='$CID_2'  
		order by b.seme_num ";
		$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		$obj_stu=array();
		while ($rs and $ro=$rs->FetchNextObject(false)) {
			$obj_stu[$ro->student_sn] = get_object_vars($ro);
		}
		return $obj_stu;	
	}

//---end class
}



