<?php
// $Id: rand_input.php 5310 2009-01-10 07:57:56Z hami $
class rand_input{
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
	}
	function process(){
		$this->sGrade=$this->sGrade();//�~�Ű}�C
		$this->List=$this->gList();//�ɮצC��	
		if ($this->Fi!='') {
			$this->Info= $this->gInfo();//Ū�����,�]�a�J$this->allStu
			if ($_POST[form_act]=='Rand_write') $this->Rand_write();			
			}
	//echo "<pre>";print_r($this->List);
	}
	function Rand_write(){
		//$this->Fi;echo "<pre>";//print_r($this->Info);
		$Y=$this->Info[Rand][rWord][Y];//�Ǧ~
		$S=$this->Info[Rand][rWord][S];//�Ǵ�
		$G=$this->Info[Rand][rWord][G];//�~��
		$CK=$this->chkSemestu($Y,$S,$G);
		if ($CK[tol]=='N') backe('�]�w���X�I�I�L�k�g�J�I�I');//print_r($CK);

		
		$f3=$this->mPath.$this->Fi.'_stu_OK';//�������G��
		if (!file_exists($f3)) backe('�@�~���~�I�I��Ƥ��s�b�I�I'); 
		$aa=file_get_contents($f3);
		$aa=unserialize($aa);
		
		$seme=sprintf("%03d",$Y).$S;//0931
		$semeG=sprintf("%03d",$Y).'_'.$S.'_'.sprintf("%02d",$G);//093_1_07
		
		$ClassName=$this->gClassName($Y,$S,$G);//print_r($ClassName);
		
		foreach ($aa as $No=>$sAry){
			$GG1=$G.sprintf("%02d",$No);//503
			$GK=$semeG.'_'.sprintf("%02d",$No);
			$cName=$ClassName[$GK];	//����Z�W	
			if ($cName=='')  backe('�@�~���~�I�I�Z�Ÿ�Ƥ�����I�I'); 
			foreach ($sAry as $k=>$stu){
				$Num=$k+1;//�y��
				$curr=$GG1.sprintf("%02d",$Num);//50302
				$SQLA="update stud_base set curr_class_num='$curr' where
				stud_id='$stu[stud_id]' and student_sn='$stu[sn]' ";
				$SQLB="INSERT INTO stud_seme 
				(stud_id,seme_year_seme,seme_class,seme_class_name,seme_num,student_sn)
				VALUES ('$stu[stud_id]','$seme','$GG1','$cName','$Num','$stu[sn]') ";
			//	echo $SQLA."<br>".$SQLB."<br>";
				$rs=$this->CONN->Execute($SQLA) or die("�L�k�d�ߡA�y�k:".$SQLA);
				$rs=$this->CONN->Execute($SQLB) or die("�L�k�d�ߡA�y�k:".$SQLB);
				}
			}
		$URL=$_SERVER[PHP_SELF]."?step=".$this->mod;
		Header("Location:$URL");
	}
//������Z�W�}�C
	function gClassName($year,$seme,$grade){
		$SQL="select class_id,c_name from  school_class where 
		year='$year' and semester='$seme' and c_year='$grade'  and enable=1    ";
		$rs=$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		while(!$rs->EOF){
			$ro = $rs->FetchNextObject(false);
			$obj[$ro->class_id]=$ro->c_name;
		}
		return $obj; 

	}
  	//���
	function display(){
		head("�b�y�Ͷüƽs�Z");
		print_menu($this->sfs_menu);
		$this->smarty->assign("this",$this);
		$tpl = __My_Path.'templates/'.$this->mod.'.htm';
		$this->smarty->display($tpl);
		foot();//�G������	
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



	//Ū���W�U�C���ɮ�
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
		if ($AA[f3]=='Y'){
			$AA[C4]=$this->chkSemestu($AA[rWord][Y],$AA[rWord][S],$AA[rWord][G]);
			//�Ǧ~,�W/�U�Ǵ�,�~��
			}
			else{$AA[C4]='';}
		$ary[]=$AA;
		unset($AA);
		}		
		return $ary;
	}
	function chkSemestu($year,$seme,$grade) {
		$T[tol]='Y';
	//1.�ˬd�}�Ǥ�
		$SQL = "select * from school_day where  year='$year' 	and seme='$seme'  ";
		$rs=$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		$tmp[day]=$rs->RecordCount();
		($tmp[day]==0) ? $T[chk_day]='N':$T[chk_day]='Y';
		if ($tmp[day]==0) $T[tol]='N';
		
	//2.�ˬd�Z�ų]�w
		$SQL="select class_id,c_name,teacher_1 from  school_class where 
		year='$year' and semester='$seme' and c_year='$grade'  and enable=1    ";
		$rs=$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		$tmp[sclass]=$rs->RecordCount();
		($tmp[sclass]==0) ? $T[chk_class]='N':$T[chk_class]='Y';
		if ($tmp[sclass]==0) $T[tol]='N';
	//3.�ˬd�ǥ�
		$seme_year_seme=sprintf("%03d",$year).$seme;
		$SQL="SELECT stud_id,student_sn FROM `stud_seme` where seme_year_seme='$seme_year_seme' 
		 and seme_class like '$grade%'  ";
		$rs=$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		$tmp[stu]=$rs->RecordCount();
		($tmp[stu]==0) ? $T[chk_stu]='Y':$T[chk_stu]='N';
		if ($tmp[stu] > 0) $T[tol]='N';
	//4.�ˬd�O�_�����Ǵ�
		if ($year==curr_year() && curr_seme()==$seme) {$T[chk_now]='Y';}
		else{$T[chk_now]='N';$T[tol]='N';}

		return $T;
	}
	
	//Ū��Ū������ɦW�U�ɮ�
	function gInfo() {
		$file=$this->Fi;
		$f1=$this->mPath.$file;
		$f2=$this->mPath.$file.'_stu';//�򥻸����
		$f3=$this->mPath.$file.'_stu_OK';//�������G��
		if (!file_exists($f1)) backe('�t�ο��~�I�I�L�kŪ������ɡI�I');
			$aa=file_get_contents($f1);
			$aa=unserialize($aa);
		return $aa;
	}






//---end class
}



