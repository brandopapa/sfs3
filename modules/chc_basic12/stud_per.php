<?php
//$Id: chc_seme.php 5310 2009-01-10 07:57:56Z hami $
// ini_set('display_errors', '1');
include "config.php";
include "chc_func_class.php";
//�{��
sfs_check();
//$school=get_school_base();print_r(	$school);$school['sch_sheng']='���ƿ�';
//print_r($_SESSION);
//�ޤJ��������(�ǰȨt�ΥΪk)
// include_once "../../include/sfs_oo_dropmenu.php";
//�{���ϥΪ�Smarty�˥���
$template_file = dirname (__file__)."/templates/stud_per.htm";

//�إߪ���
$obj= new chc_seme($CONN,$smarty);
//��l��
$obj->init();
//�P�O�ꤤ6/��p0 �ܼ�
//$obj->IS_JHORES=$IS_JHORES;

//�B�z�{��,���ɵ{�Ǥ���header���O,�G���{�ǩy��head("score_semester_91_2�Ҳ�");���e
$obj->process();

//�q�X�����������Y
//head("���ưϧK�դJ��");

//���SFS�s�����(���ϥνЮ��}����)
//echo make_menu($school_menu_p);
//$ob=new drop($this->CONN,$IS_JHORES);
//		$this->select=$ob->select();
//echo $ob->select();
//��ܤ��e
$obj->display($template_file);
//�G������
//foot();


//����class
class chc_seme{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $stu;//�ǥ͸��
	var $subj;//��ذ}�C
	var $rule;//����
	var $Stu_Seme;//�ǥͪ��Ǵ��}�C
	var $IS_JHORES;//�ꤤ�p
	var $year;//�Ǧ~
	var $seme;//�Ǵ�
	var $YS='year_seme';//�U�Ԧ����Ǵ����ڼƦW��
	var $year_seme;//�U�Ԧ����Z�Ū��ڼƭ�
	var $Sclass='class_id';//�U�Ԧ����Z�Ū��ڼƦW��
	var $reward_kind =array("1"=>"�ż��@��","2"=>"�ż��G��","3"=>"�p�\�@��","4"=>"�p�\�G��","5"=>"�j�\�@��","6"=>"�j�\�G��","7"=>"�j�\�T��","-1"=>"ĵ�i�@��","-2"=>"ĵ�i�G��","-3"=>"�p�L�@��","-4"=>"�p�L�G��","-5"=>"�j�L�@��","-6"=>"�j�L�G��","-7"=>"�j�L�T��");

	var $race_area=array('1'=>'���','2'=>'���� �O�W��','3'=>'�ϰ��(�󿤥�)','4'=>'�� ���ҥ�','5'=>'������(�m��)','6'=>'�դ�');
	var $race_kind=array('1'=>'�ӤH��','2'=>'������');
//�t�μ��g�]�w�Ѧ�
	//$reward_good_arr=array("1"=>"�ż��@��","2"=>"�ż��G��","3"=>"�p�\�@��","4"=>"�p�\�G��","5"=>"�j�\�@��","6"=>"�j�\�G��","7"=>"�j�\�T��");
	//$reward_bad_arr=array("-1"=>"ĵ�i�@��","-2"=>"ĵ�i�G��","-3"=>"�p�L�@��","-4"=>"�p�L�G��","-5"=>"�j�L�@��","-6"=>"�j�L�G��","-7"=>"�j�L�T��");
	//$reward_arr=array("1"=>"�ż��@��","2"=>"�ż��G��","3"=>"�p�\�@��","4"=>"�p�\�G��","5"=>"�j�\�@��","6"=>"�j�\�G��","7"=>"�j�\�T��","-1"=>"ĵ�i�@��","-2"=>"ĵ�i�G��","-3"=>"�p�L�@��","-4"=>"�p�L�G��","-5"=>"�j�L�@��","-6"=>"�j�L�G��","-7"=>"�j�L�T��");
	
	
	//�غc�禡
	function chc_seme($CONN,$smarty){
		global $IS_JHORES;
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
		$this->IS_JHORES=$IS_JHORES;
		$StuSN=''; 
		if (isset($_GET['Sn'])) $this->Sn=(int)$_GET['Sn'];
		if (isset($_GET['Year'])) $this->Year=(int)$_GET['Year'];
		if ($this->Sn=='' || $this->Year=='') backe('���ǭ�!!');
	}
	//��l��
	function init() {}
	//�{��
	function process() {
		//if(isset($_POST['form_act']) && $_POST['form_act']=='update') $this->update();
		
		$this->all();
		//echo $this->year;
	}
	//���
	function display($tpl){
		//$ob=new drop($this->CONN);
		//$this->select=$this->select();
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
	}
	//�^�����
	function all(){
		$this->sch=get_school_base();
		$this->stu=$this->get_stu();
//		print_r($this->sco);		
	}
/* ���ǥͰ}�C,����stud_base��Pstud_seme��*/
	function get_stu(){
		$SQL="select a.stud_id,a.stud_name,a.stud_birthday ,a.stud_sex, a.stud_person_id ,a.curr_class_num,
		b.seme_class,b.seme_num,a.stud_study_cond ,c.*  
		from stud_base a, stud_seme b, chc_basic12 c  where 
		c.sn='{$this->Sn}' and c.student_sn=a.student_sn and c.student_sn=b.student_sn 
		and left(b.seme_year_seme,3)='{$this->Year}'  order by b.seme_year_seme desc limit 1 ";
		
		$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		if ($rs->RecordCount()==0) return"�䤣��ǥ͡I";
		$All=$rs->GetArray();
		$this->mySN=$All[0]['student_sn'];

		$SQL="select a.student_sn,a.stud_id,a.stud_study_cond,
		b.seme_year_seme,b.seme_class,b.seme_num 
		from stud_base a, stud_seme b, chc_basic12 c  where 
		c.sn='{$this->Sn}' and c.student_sn=a.student_sn and c.student_sn=b.student_sn 
		order by b.seme_year_seme asc ";
		$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		if ($rs->RecordCount()==0) return"�䤣��ǥ͡I";
		
		$this->Stu_Seme=$rs->GetArray();
		return $All[0];	
	}

	//�A�Ȯɼ�
	function get_service( $student_sn ){
	$SQL = "select a.item,a.memo,a.service_date,a.sponsor,b.*
	 from stud_service a ,stud_service_detail b  
	 where b.student_sn='{$student_sn}'  and b.item_sn =a.sn order by a.service_date asc 	 ";
	$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	if ($rs->RecordCount()==0) return;
	return $rs->GetArray(); 
	}

	//���v�ɰO��
	function get_race($sn){
	$SQL = "SELECT  *  FROM `career_race`  where student_sn='{$sn}' order by  certificate_date  asc 	 ";
	$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	if ($rs->RecordCount()==0) return ;
	return $rs->GetArray(); 
	}


	//�����y
	function get_reward($sn){
	$SQL = "SELECT  *  FROM `reward`  where reward_kind >0 and student_sn='{$sn}' order by  (abs(reward_year_seme)+10000),reward_date ";
	$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	if ($rs->RecordCount()==0) return ;
	return $rs->GetArray(); 
	}
	//���g�@
	function get_reward2($sn){
	// 101�Ǧ~�פ~�}�l�ĭp,�B���P�L��
	$SQL = "SELECT  *  FROM `reward`  where reward_kind < 0 and student_sn='{$sn}' and reward_cancel_date='0000-00-00' and reward_year_seme >='1011' order by  (abs(reward_year_seme)+10000),reward_date ";

	$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	if ($rs->RecordCount()==0) return ;
	return $rs->GetArray(); 
	}
		
	//�����m��
	function get_abs(){

	$stud_id='';
	foreach ($this->Stu_Seme as $ary){
		//�Ǵ��Ҧ�
		if ($ary['seme_year_seme'] < '1011') continue;
		$seme[]=$ary['seme_year_seme'];
		$stud_idA=$ary['stud_id'];
		// �ˬd�Ǹ�
		if ($stud_id=='')$stud_id=$stud_idA;
		if ($stud_id != $stud_idA) backe('!!�P�@��ǥͦ����P�Ǹ�!!');
		}
//	$SQL="SELECT * FROM `stud_absent`  where   stud_id='{$stud_id}' order by `date` ";
	$SQL="SELECT * FROM `stud_absent`  where `year` >='101' and  stud_id='{$stud_id}' 	and  absent_kind ='�m��' ";
	$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	if ($rs->RecordCount()==0) return ;
	$A=$rs->GetArray();
	foreach ($A as $ary){
		$K=$ary['date'];
		$stu[$K]['year']=$ary['year'];
		$stu[$K]['semester']=$ary['semester'];
		$stu[$K]['class_id']=$ary['class_id'];
		$stu[$K]['date']=$ary['date'];
		$stu[$K]['stud_id']=$ary['stud_id'];
		$stu[$K]['absent_kind']=$ary['absent_kind'];
		if ($ary['section']=='uf') $ary['section']='��';
		if ($ary['section']=='df') $ary['section']='��';
		//if ($ary['section']=='allday') $ary['section']='����';
		$stu[$K]['section']=$ary['section'];
		$stu[$K]['section2']=$stu[$K]['section2']." ".$ary['section'];
	}
	return $stu; 
	}	

	//�����žǲ�
	function get_balance(){
		$this->mySN;
		$student_data=new data_student($this->mySN);
		//print "<pre>";
		$tmp=array();$A=array();
		//$tmp= $student_data->all_score;
		$tmp['���d�P��|'] =$student_data->all_score['���d�P��|'];
		$tmp['���N�P�H��'] =$student_data->all_score['���N�P�H��'];
		$tmp['��X����'] =$student_data->all_score['��X����'];
		if($tmp['���d�P��|']['items'] > 1 ) {$A['H'] =$tmp['���d�P��|']['sub_arys']['����'];}
		else{$A['H']=$tmp['���d�P��|']['sub_arys']['���d�P��|'];}
		
		if($tmp['���N�P�H��']['items'] > 1 ) {$A['A'] =$tmp['���N�P�H��']['sub_arys']['����'];}
		else{$A['A']=$tmp['���N�P�H��']['sub_arys']['���N�P�H��'];}
		
		if($tmp['��X����']['items'] > 1 ) {$A['B'] =$tmp['��X����']['sub_arys']['����'];}
		else{$A['B']=$tmp['��X����']['sub_arys']['��X����'];}
		foreach ($A['H'] as $seme=>$sco){
			if ($A['H'][$seme]['score']>=60 &&$A['A'][$seme]['score']>=60 &&$A['B'][$seme]['score']>=60) 
			{$A['Tol'][$seme]='�ŦX';$A['Tol']['Pass']++;}
			else{$A['Tol'][$seme]='--';}
		}
		// if ($A['Tol']['Pass'] >=2 )$A['Tol']['Sco']=2;
		// if ($A['Tol']['Pass'] >=4 )$A['Tol']['Sco']=4;
		// if ($A['Tol']['Pass'] >=5 )$A['Tol']['Sco']=7;



		return $A;
	}
	
	//�����žǲ�
	function gCH($seme){
		$A=array(1=>'�@',2=>'�G',3=>'�T',4=>'�|',5=>'��',6=>'��',7=>'�@',8=>'�G',9=>'�T');
		$B=array(1=>'�W',2=>'�U');
		$tmp=explode('_',$seme);
		return $A[$tmp[0]].$B[$tmp[1]];
	}

	//�����žǲ�
	function gLeader($sn){
		$SQL="SELECT * FROM `chc_leader`  where `student_sn`='{$sn}' order by seme,kind,org_name ";
		$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		if ($rs->RecordCount()==0) return ;
		$A=$rs->GetArray();
		
		// $A=array(1=>'�@',2=>'�G',3=>'�T',4=>'�|',5=>'��',6=>'��',7=>'�@',8=>'�G',9=>'�T');
		// $B=array(1=>'�W',2=>'�U');
		// $tmp=explode('_',$seme);

		return $A;
	}




}
