<?php
// $Id: rand_run.php 5310 2009-01-10 07:57:56Z hami $
class rand_run{
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
		//$this->class_id=chkStr('class_id');
	}
	function process(){
		$this->sGrade=$this->sGrade();//�~�Ű}�C
		$this->List=$this->gList();//�ɮצC��	
		//�üƽs�Z
		if ($_POST[form_act]=='start' && $this->Fi!='') $this->startRand();
		//�Z�ǽվ� 
		if ($_POST[form_act]=='startOrd' && $this->Fi!='') $this->startOrd();
		
		if ($this->Fi!='') {
			$this->Info= $this->gInfo();//Ū�����,�]�a�J$this->allStu
			if ($_GET[act]=='del') $this->delFile();			
			if ($_GET[act]=='view' ||$_GET[act]=='prt'||$_GET[act]=='ord') 	$this->New=$this->gNew();//Ū�����
			
			}
	//echo "<pre>";print_r($this->Info);
	}
	function gNew(){
		$file=$this->Fi;
		$f3=$this->mPath.$file.'_stu_OK';//�������G��
		if (!file_exists($f3)) backe('�@�~���~�I�I��Ƥ��s�b�I�I'); 
			$aa=file_get_contents($f3);
			$aa=unserialize($aa);
			
			$tol[all]=0;
		foreach ($aa as $k=>$cla){
			$cla_ary[$k]=$k;
			foreach ($cla as $stu){
				($stu[stud_sex]==1) ? $tol[$k][boy]++:$tol[$k][girl]++;
				//�S��k,�k
				if ($stu[type]==3 && $stu[stud_sex]==1) $tol[$k][sboy]++;
				if ($stu[type]==3 && $stu[stud_sex]==2) $tol[$k][sgirl]++;
				//($stu[type]==1) ? $tol[$k][boy]++:$tol[$k][girl]++;
				$S_tmp=$stu;
				$S_tmp[ncla]=$k;
				$T_cla[$k][]=$S_tmp;
				unset($S_tmp);
			}
			$tol[$k][tol]=$tol[$k][boy]+$tol[$k][girl];
			$tol[$k][stol]=$tol[$k][sboy]+$tol[$k][sgirl];
			$tol[all]=$tol[all]+$tol[$k][tol];
		}
			$kk[stu]=&$T_cla;
			$kk[tol]=&$tol;
			$kk[k1]=$cla_ary;
			$kk[k2]=join(',',$cla_ary);
		return $kk;
	}

//�}�l�üƽs�Z
	function startRand(){
		$this->Info= $this->gInfo();//Ū�����,�]�a�J$this->allStu
		$stu=$this->gStu();//���o�����ǥ͸��
		$file=$this->Fi;
		$f2=$this->mPath.$file.'_stu';//�򥻸����
		$f3=$this->mPath.$file.'_stu_OK';//�������G��
		if (file_exists($f3)) backe('�v�����üƽs�Z�{�ǡA�T��s�I');

		$RR= new Cla_rand();
		$RR->data=&$stu;//�ǥ͸��
		$RR->Num=&$this->Info[Rand][newTol];//�s�s�Z��
		$aa=$RR->run();
		$str=serialize($aa);
		$fpWrite=fopen($f3,"w");//���}
		fwrite($fpWrite,$str);//�g�J
		fclose($fpWrite);//���W
		$URL=$_SERVER[PHP_SELF]."?step=".$this->mod.'&Fi='.$this->Fi.'&act=view';
		Header("Location:$URL");
	
	}//end Rand

//�}�l�üƽs�Z
	function startOrd(){
		$this->Info= $this->gInfo();//Ū�����
		$f3=$this->mPath.$this->Fi.'_stu_OK';//�������G��
		if (!file_exists($f3)) backe('�|���s�Z�A�L�k�ƯZ�ǡI�I');
		$stu=$this->gNew();//���o�����ǥ͸��
		
		foreach ($stu[stu] as $key=>$ary){
			$New=$_POST[Ordclass][$key];
			$NewClass[$New]=$ary;
		}

		ksort($NewClass);
		$str=serialize($NewClass);
		$fpWrite=fopen($f3,"w");//���}
		fwrite($fpWrite,$str);//�g�J
		fclose($fpWrite);//���W
		$URL=$_SERVER[PHP_SELF]."?step=".$this->mod.'&Fi='.$this->Fi.'&act=view';
		Header("Location:$URL");
	}//end Rand

  	//���
	function display(){
		$this->smarty->assign("this",$this);
		$this->header_tpl=__My_Path.'templates/'.$this->mod.'_header.htm';
		switch ($_GET[act]) {
			case 'prt':
				$tpl = __My_Path.'templates/'.$this->mod.'_prt.htm';
				$this->smarty->display($tpl);
				break;
			case 'view':
				head("�b�y�Ͷüƽs�Z");
				print_menu($this->sfs_menu);
				$tpl = __My_Path.'templates/'.$this->mod.'_view.htm';
				$this->smarty->display($tpl);
				foot();//�G������				
				break;
			case 'ord':
				head("�b�y�Ͷüƽs�Z");
				print_menu($this->sfs_menu);
				$tpl = __My_Path.'templates/'.$this->mod.'_ord.htm';
				$this->smarty->display($tpl);
				foot();//�G������				
				break;
			default:
				head("�b�y�Ͷüƽs�Z");
				print_menu($this->sfs_menu);
				$tpl = __My_Path.'templates/'.$this->mod.'.htm';
				$this->smarty->display($tpl);
				foot();//�G������	
		}
		
		
		
		
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
		$ary[]=$AA;
		unset($AA);
		}		
		return $ary;
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
	//Ū���W�U�ɮ�
	function gStu() {
		$file=$this->Fi;
		$f1=$this->mPath.$file;
		$f2=$this->mPath.$file.'_stu';//�򥻸����
		$f3=$this->mPath.$file.'_stu_OK';//�������G��
		//if (file_exists($f3)) backe('�v�����üƽs�Z�{�ǡA�T��s�I');
		if (!file_exists($f1))  backe('�t�ο��~�I�I�L�kŪ���I�I');
		if (!file_exists($f2))  backe('�t�ο��~�I�I�L�kŪ���I�I');
		$ss=file_get_contents($f2);
		$ss=unserialize($ss);//echo "<pre>";print_r($this->Stu);
		return $ss;
	}
	//�R���W�U
	function delFile(){
		if ($this->Info[Rand][Test]=='N') backe('�D�@��ާ@�Ҧ��A�L�k�R���I');
		$file=$this->Fi;
		$f2=$this->mPath.$file.'_stu';//�򥻸����
		$f3=$this->mPath.$file.'_stu_OK';//�������G��
		//if (file_exists($f3)) backe('�v�����üƽs�Z�{�ǡA�T��s�I');
		unlink($f3);
		$URL=$_SERVER[PHP_SELF]."?step=".$this->mod;
		Header("Location:$URL");
	}

/////-------------�ɻ���ܥΨ禡2---------------///////
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



