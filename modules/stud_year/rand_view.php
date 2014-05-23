<?php
//$Id: rand_view.php 5310 2009-01-10 07:57:56Z hami $
include "stud_year_config.php";
include_once "rand/rand_tool.php";


$smarty->left_delimiter="{{";
$smarty->right_delimiter="}}";

//�إߪ���
$obj= new rand_view();
//$obj->CONN=&$CONN;
$obj->smarty=&$smarty;
$obj->SFS_PATH=&$SFS_PATH;
$obj->UPLOAD_PATH=&$UPLOAD_PATH;
$obj->IS_JHORES=&$IS_JHORES;
$obj->mSch=get_school_base();
//�B�z�{��
$obj->run();

class rand_view{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $options;//���οﶵ..���t��Ʈw
	var $SFS_PATH;
	var $UPLOAD_PATH;
	var $IS_JHORES;
	var $mPath;//�Ҳ��ɮ׸��|
	var $sex=array(1=>'�k',2=>'�k');
	var $sex1=array(1=>'<font color=#0000FF>�k</font>',2=>'<font color=#FF0000>�k</font>');

   public function __construct() { }
   
	function init(){
		$dir = dirname($_SERVER[PHP_SELF]);
		$dir_ary = explode('/',$dir);
		$dir_name=end($dir_ary);
		$mPath=$this->UPLOAD_PATH.'school/'.$dir_name.'/';
		if (!file_exists($mPath)) backe('�䤣��ؿ��L�k�B�@');
		$this->mPath=&$mPath;
		define('__My_Path', $this->SFS_PATH.'/modules/'.$dir_name.'/');//�{�����|
		
		$this->Fi=chkStr('Fi');
		//$this->class_id=chkStr('class_id');
	}
	function run(){
		$this->init();
		$this->sGrade=$this->sGrade();//�~�Ű}�C
		if ($this->Fi!='') {
			$this->Info=$this->gFile();//Ū�����,�]�a�J$this->allStu
			$this->New=$this->gNew();//Ū�����
			}
		$this->display();
	}
	function gNew(){
		$file=$this->Fi;
		$f3=$this->mPath.$file.'_stu_OK';//�������G��
		if (file_exists($f3)) {
			$aa=file_get_contents($f3);
			$aa=unserialize($aa);
			}
		foreach ($aa as $k=>$cla){
			foreach ($cla as $stu){
				($stu[stud_sex]==1) ? $tol[$k][boy]++:$tol[$k][girl]++;
				//�S��k,�k
				if ($stu[type]==3 && $stu[stud_sex]==1) $tol[$k][sboy]++;
				if ($stu[type]==3 && $stu[stud_sex]==2) $tol[$k][sgirl]++;
				//($stu[type]==1) ? $tol[$k][boy]++:$tol[$k][girl]++;
			}
			$tol[$k][tol]=$tol[$k][boy]+$tol[$k][girl];
			$tol[$k][stol]=$tol[$k][sboy]+$tol[$k][sgirl];
		}
			$kk[stu]=&$aa;
			$kk[tol]=&$tol;
		return $kk;
	}

	function stuInfo(){
		foreach ($this->allStu as $cla_id=> $cla){
			foreach ($cla as $stu){
				$info[type][$stu[type]]++;
				if ($stu[stud_sex]=='1') {
					$info[boy]++;
					$info[type2][$stu[type]][boy]++;}
				if ($stu[stud_sex]=='2') {
					$info[girl]++;
					$info[type2][$stu[type]][girl]++;}
					unset($stu);
			}
		
		}
		return $info;
	}


  	//���
	function display(){
		//head("�b�y�Ͷüƽs�Z");
		$tpl = __My_Path.'templates/rand_view.htm';
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
		//foot();//�G������
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

function Full_TD($data,$num) {
//echo "XX--<br>";print_r($data);
	$all=count($data);
	$loop=ceil($all/$num);
	$flag=$num-1;//�X�檺key
	$all_td=($loop*$num)-1;//�̤j�Ȥp1
	$show=array();$i=0;
	foreach ($data as $key=>$ary ){
		(($i%$num)==$flag && $i!=0 && $i!=$all_td ) ? $ary[next_line]='yes':$ary[next_line]='';
		$show[$key]=$ary;
		$i++;
		}
	if ($i<=$all_td ){
		for ($i;$i<=$all_td;$i++){
			$key='Add_Td_'.$i;
		(($i%$num)==$flag && $i!=0 && $i!=$all_td ) ? $show[$key][next_line]='yes':$show[$key][next_line]='';
		}
	}
		return $show;
}



//---end class
}



