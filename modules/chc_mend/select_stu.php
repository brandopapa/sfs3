<?php
//$Id: PHP_tmp.html 5310 2009-01-10 07:57:56Z hami $
include "config.php";

//�{��
sfs_check();


//�{���ϥΪ�Smarty�˥���
$template_file = dirname (__file__)."/templates/select_stu.htm";

//�إߪ���
$obj= new basic_chc($CONN,$smarty);
//��l��
$obj->init();
//�B�z�{��,���ɵ{�Ǥ���header���O,�G���{�ǩy��head("12basic_chc�Ҳ�");���e
$obj->process();


//�q�X�����������Y
head("�ɦҦ��Z�޲z");

//���SFS�s�����(���ϥνЮ��}����)

echo make_menu($school_menu_p,$obj->linkstr);//
//��ܤ��e
$obj->display($template_file);
//�G������
foot();


//����class
class basic_chc{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $size=10;//�C������
	var $page;//�ثe����
	var $tol;//����`����
	var $scope=array(1=>'�y��',2=>'�ƾ�',3=>'�۵M�P�ͬ����',4=>'���|',
	5=>'���d�P��|',6=>'���N�P�H��',7=>'��X����');
	var $linkstr;//�s���ǻ�

	//�غc�禡
	function basic_chc($CONN,$smarty){
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
	}
	//��l��
	function init() {
	   	//$this->saveData=strip_tags($_POST['op']);
	   	
		if (preg_match("/^[0-9]{2,3}_[1-2]$/",$_GET['Y'])) $this->Y=strip_tags($_GET['Y']);
		if (preg_match("/^[1-9]$/",$_GET['G'])) $this->G=strip_tags($_GET['G']);
		if (preg_match("/^[1-7]$/",$_GET['S'])) $this->S=strip_tags($_GET['S']);
		$this->Scope_name=$this->scope[$this->S];
		$this->sel_year=sel_year('Y',$this->Y);
		$this->sel_grade=sel_grade('G',$this->G,$_SERVER['PHP_SELF'].'?Y='.$this->Y.'&G=');
		//$this->page=($_GET[page]=='') ? 0:$_GET[page];
		$this->linkstr="Y={$this->Y}&G={$this->G}&S={$this->S}";
	}
		
	//�{��
	function process() {
	   
		if ($_POST['form_act']=='saveData') $this->save();
		$this->all();
	}



	//���
	function display($tpl){
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
	}
	//���
	function save(){
	  	// �g�J��ƪ�
	  	if(count($_POST['sel'])==0) backe("�I�I����ܸ�ơI�I");
	  	
		     //print_r($_POST['sel']);
		foreach($_POST['sel'] as $a=>$b){
		$sel=explode("_n_",$b);
		$datetime = date ("Y-m-d H:i:s"); 
		//echo $_POST['Y'];
		$SQL="INSERT INTO `chc_mend` 
		(`student_sn`,`seme`,`scope`,`score_src`,`cr_time`) 
		VALUES ('".$a."','".$_POST['Y']."','".$_POST['S']."','".$b."','$datetime');";
		    $rs=$this->CONN->Execute($SQL) or die($SQL);
		   // echo $SQL."<br>";
		}
		$URL=$_SERVER['SCRIPT_NAME']."?Y=".$this->Y.'&G='.$this->G.'&S='.$this->S;
		Header("Location:$URL");
	}
	
	//�^�����
	function all(){
	  // echo'OK';
	  	if ($this->Y=='') return;
		if ($this->G=='') return;
		if ($this->S=='') return;
		$ys=explode("_",$this->Y);
		$sel_year=$ys[0];
		$sel_seme=$ys[1];
		$YS=sprintf("%03d",$sel_year).$sel_seme;
		if ($this->S=='1')  {
		      $Scope=" and link_ss like '�y��-%' ";
	           }	else{
			$ss=$this->S;
			$N=$this->scope[$ss];
			$Scope=" and link_ss='$N' ";
		}
		
		$SQL="select ss_id,scope_id,subject_id,rate,link_ss 
		from score_ss 
		where year='$sel_year' 
		and semester='$sel_seme' 
		and class_year='$this->G' 
		and enable='1' 
		and need_exam='1' $Scope   
		order by ss_id";
		//$rs=$CONN->Execute($sql);
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		//echo $SQL;
		$All=$rs->GetArray();
		//echo "<pre>";
		//print_r($All);
		foreach ($All as $ary){
			$ss_id[]=$ary[ss_id];
			$subject_id[$ary[ss_id]]=$ary[subject_id];
			$ss_rate[$ary[ss_id]]=$ary[rate];
			$this->link_ss[$ary[ss_id]]=$ary[link_ss];
		}
		//print_r($this->link_ss)."<br>";
		foreach($subject_id as $a=>$b){
		$sql="SELECT subject_name FROM `score_subject` where subject_id=$b";
		$rs=$this->CONN->Execute($sql) or die($sql);
		$All=$rs->GetArray();
		if($this->S=='1'){
		$this->link_ss[$a].="*".$ss_rate[$a]; 
	          	}else if(count($this->link_ss)>1){
		$this->link_ss[$a]=$All[0]['subject_name']."*".$ss_rate[$a];
	           	}else{
		$this->link_ss[$a].="*".$ss_rate[$a];
	           	}
		//echo $All[0]['subject_name']."<br>";
		}
		
		//print_r($this->link_ss);
		if (count($ss_id)==0) die('�d������');
		$str=join(",",$ss_id);$str="'".join("','",$ss_id)."'";
		$SQL="select a.*,b.stud_name,c.seme_class,c.seme_num,c.stud_id 
		from stud_seme_score a ,stud_base b 
		left join stud_seme c on c.student_sn=b.student_sn
		where 
		a.seme_year_seme= '$YS'
		and a.ss_id in ($str) 
		and a.ss_score<60 
		and a.student_sn=b.student_sn 
		AND b.stud_study_cond='0'
		and c.seme_year_seme='$YS'
		order by c.seme_class,c.seme_num";
        //echo $SQL; 
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		//echo $SQL."<br>";
		$All=$rs->GetArray();
		//print_r($All);
		foreach ($All as $ary){
		//echo $ary['student_sn'].'_'.$ary['stud_name']."_".$this->link_ss[$ary['ss_id']]."<br>";
		$stu_sn[$ary['student_sn']]['student_sn']=$ary['student_sn'];
		$stu_sn[$ary['student_sn']]['seme_class']=$ary['seme_class'];
		$stu_sn[$ary['student_sn']]['stud_name']=$ary['stud_name'];
		$stu_sn[$ary['student_sn']]['seme_num']=$ary['seme_num'];
		$stu_sn[$ary['student_sn']]['stud_id']=$ary['stud_id'];
			//foreach($ss_id as $a=>$b){
		$stu_sn[$ary['student_sn']][$ary['ss_id']]=$ary['ss_score'];
		$sn=$ary['student_sn'];
			//}
		//if ($this->S=='1')  {
		      $avarage=0;
		      $rate=0;
		foreach($ss_id as $a=>$b){
		$SQL="select ss_score,ss_id from stud_seme_score 
		where student_sn=$sn
		and seme_year_seme= '$YS'
		and ss_id= $b";
		$rs=$this->CONN->Execute($SQL) or die($SQL);		
		$All_0=$rs->GetArray();		
		$stu_sn[$ary['student_sn']][$b]=$All_0[0]['ss_score'];
		$avarage=$avarage+$ss_rate[$b]*$All_0[0]['ss_score'];
		$rate+=$ss_rate[$b];
	           	}	           	
	           	$stu_sn[$ary['student_sn']]['average']=$avarage/$rate;
	           	//}else{
		 //$stu_sn[$ary['student_sn']]['average']=$ary['ss_score'];     
	           	//}
	           	//echo "<pre>";print_r($All_0);echo "</pre>";
		}
		//$this->all_ary=$All;
		$this->all_ary=$stu_sn;
//print_r($stu_sn);
	}
	
	function stu_data(){
	   
	   
	}








}


