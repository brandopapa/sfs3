<?php
//$Id: PHP_tmp.html 5310 2009-01-10 07:57:56Z hami $
include "config.php";
include "../../include/sfs_case_studclass.php";
//�{��
sfs_check();


//�{���ϥΪ�Smarty�˥���


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
// print_menu($school_menu_p);//,$obj->linkstr

$obj->display();
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
	5=>'���d�P��|',6=>'���N�P�H��',7=>'��X����');//,8=>'����'
	var $linkstr;

	//�غc�禡
	function basic_chc($CONN,$smarty){
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
	}
	//��l��
	function init() {
		//�L�o�r��ΨM�wGET��POST�ܼ�
		$Y=gVar('Y');$G=gVar('G');$S=gVar('S');
		
		//�Ǧ~�׮榡 92_2,��102_1
		if (preg_match("/^[0-9]{2,3}_[1-2]$/",$Y)) $this->Y=$Y;
		
		//�~�Ů榡..1-6�p��,7-9�ꤤ
		if (preg_match("/^[1-9]$/",$G)) $this->G=$G;

		//���N�X1-7,8��ܥ������
		if (preg_match("/^[1-7]$/",$S)) $this->S=$S;

		//�Ǧ~�׿��
		$this->sel_year=sel_year('Y',$this->Y);
		//�~�ſ��
		$this->sel_grade=sel_grade('G',$this->G,$_SERVER['PHP_SELF'].'?Y='.$this->Y.'&G=');
		//����
		// $this->page=($_GET[page]=='') ? 0:$_GET[page];
		
		//��L�����s���Ѽ�
		$this->linkstr="Y={$this->Y}&G={$this->G}&S={$this->S}";
	
	}
		//�{��
	function process() {
	   	//echo "123".$_POST['form_act'];
		//if ($_GET['act']=='update') $this->updateDate();
		if ($_POST['form_act']=='saveData') $this->save();
		if ($_POST['form_act']=='delData') $this->delData();
		if ($_POST['form_act']=='seme_csv') $this->seme_csv();
		$this->all();
	}

	//���
	function display(){
		$temp1 = dirname (__file__)."/templates/score_input.htm";
		//$temp2 = dirname (__file__)."/templates/score_list_all.htm";
		//($this->S == "8") ? $tpl=$temp2 : $tpl = $temp1;
		$this->smarty->assign("this",$this);
		$this->smarty->display($temp1);
	}
	//���
	  	// �g�J��ƪ�
	function save(){
	  	// echo '<pre>';print_r($_POST);die();
	  	if(count($_POST['score_input'])==0) backe("�I�I����ܸ�ơI�I");
	  	foreach($_POST['score_input'] as $a=>$sco_test){
		      $data=explode("_",$a);
		      $SN=$data[0];$sco_src=$data[1];
		      $end_score=$sco_src;
		      if ($sco_test > $sco_src )  $end_score=$sco_test;
		      if ($end_score >60 ) $end_score=60;

		     $SQL="UPDATE `chc_mend` SET `score_test` = '$sco_test',
		     `score_end` = '$end_score' WHERE `student_sn` = '$SN' and scope='{$this->S}' and seme='{$this->Y}' LIMIT 1 ;";
		     $rs=$this->CONN->Execute($SQL) or die($SQL);
		    //echo $SQL."<br>";
	      }
		$URL=$_SERVER['SCRIPT_NAME']."?Y=".$this->Y.'&G='.$this->G.'&S='.$this->S;
		Header("Location:$URL");
	}
	//�R�����
	function delData(){
		//echo '<pre>';print_r($_POST);die();
		if ($this->Y=='' || $this->G=='' || $this->S=='')  backe("�I�I��ƿ��~�I�I");
		if(count($_POST['st_sn'])==0) backe("�I�I����ܸ�ơI�I");
		foreach ($_POST['st_sn'] as $id =>$SN){
		   if ($id=='' || $SN=='') backe("�I�I����ܸ�ơI�I");
			$SQL="DELETE FROM `chc_mend` WHERE id='{$id}' and  `student_sn` = '{$SN}' 
			and scope='{$this->S}' and seme='{$this->Y}' LIMIT 1";
			$rs=$this->CONN->Execute($SQL) or die($SQL);		   
		}
		$URL=$_SERVER['SCRIPT_NAME']."?Y=".$this->Y.'&G='.$this->G.'&S='.$this->S;
		Header("Location:$URL");
	}

	//�^�����
	function all(){
		if ($this->Y=='') return;
		if ($this->G=='') return;
		if ($this->S=='') return;
		$ys=explode("_",$this->Y);
		$YS=sprintf("%03d",$ys[0]).$ys[1];
		$sel_year=$ys[0];
		$sel_seme=$ys[1];
		$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
		$seme_class=$this->G."%";
		$Scope=$this->S;
				
		$curr_y=curr_year();
		$sel_y=substr($this->Y,0,-2);
		$sel_g=$this->G;
		$op=$curr_y-$sel_y+$sel_g."%";
		$SQL="select a.stud_id,a.stud_name,a.stud_sex,b.seme_class,b.seme_num,b.seme_year_seme,c.*
		from stud_base a,chc_mend c
		LEFT JOIN stud_seme b on (c.student_sn=b.student_sn  
		and b.seme_year_seme='$seme_year_seme'  
		and b.seme_class like '$seme_class')
		where a.student_sn=c.student_sn		
		and c.seme='$this->Y'		
		and a.curr_class_num LIKE '$op'
		and c.scope='$Scope'
		and a.stud_study_cond=0
		order by b.seme_class,b.seme_num
		";
//echo $SQL;
		$rs=$this->CONN->Execute($SQL);
		$this->stu=$rs->GetArray();

		
	}

	function seme_csv(){
		$ys=explode("_",$this->Y);
		$YS=sprintf("%03d",$ys[0]).$ys[1];
		$sel_year=$ys[0];
		$sel_seme=$ys[1];
		$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
	   	$SQL="SELECT b.stud_name,a.scope ,a.score_src,b.stud_id,b.student_sn,c.seme_class,c.seme_class,c.seme_num
	   	FROM chc_mend a, stud_base b 
	   	left join stud_seme c on (c.student_sn=b.student_sn and c.seme_year_seme='$seme_year_seme')
	   	where  a.student_sn=b.student_sn  
	   	and a.seme='$this->Y'
	   	and b.stud_study_cond=0
	   	order by c.seme_class,c.seme_num";
	   	//echo $SQL;
	   	$rs=$this->CONN->Execute($SQL);
		$stu=$rs->GetArray();
		$data = "�Z��,�y��,�Ǹ�,�m�W,�y��,�ƾ�,�۵M,���|,����,����,��X\r\n";
		foreach($stu as $a=>$b){		      
		      $class_id =sprintf("%03d","101")."_"."1"."_".sprintf("%02d",substr($b[seme_class],0,1))."_".substr($b[seme_class],1,2);
		      $stud_score[$b[student_sn]][0]=class_id_to_full_class_name($class_id);
		      $stud_score[$b[student_sn]][1]=$b[seme_num];
		      $stud_score[$b[student_sn]][2]=$b[stud_id];
		      $stud_score[$b[student_sn]][3]=$b[stud_name];
		      for($i=4;$i<=10;$i++){
		      	if($b[scope] ==$i-3){
			 $stud_score[$b[student_sn]][$i]="�ɦ�";//$b[score_src];
			 }else if($stud_score[$b[student_sn]][$i]!=""){
			  $stud_score[$b[student_sn]][$i]=$stud_score[$b[student_sn]][$i];
			 }else{
			   $stud_score[$b[student_sn]][$i]=""; 
			 }
	                    }
		}
		foreach($stud_score as $a=>$b){
		       $data.=join(",",$b)."\r\n";
	           }
		$filename=$_REQUEST['Y']."�Ǵ��ɦҦ��Z.csv";
		header("Content-disposition: attachment;filename=$filename");
		header("Content-type: text/x-csv ; Charset=Big5");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $data;
		die();

	   
	}
}


