<?php
//$Id: chc_seme.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";
//�{��
sfs_check();

//�ޤJ��������(�ǰȨt�ΥΪk)
// include_once "../../include/sfs_oo_dropmenu.php";

//�{���ϥΪ�Smarty�˥���
$template_file = dirname (__file__)."/templates/leader_add.htm";
//�إߪ���
$obj= new chc_seme($CONN,$smarty);
//��l��
$obj->init();
//�B�z�{��,���ɵ{�Ǥ���header���O,�G���{�ǩy��head("score_semester_91_2�Ҳ�");���e
$obj->process();
//echo '<pre>';print_r($_POST);die();
//�q�X�����������Y
head("[��]�Z�ŷF���޲z");

//���SFS�s�����(���ϥνЮ��}����)
echo make_menu($school_menu_p);
//$ob=new drop($this->CONN,$IS_JHORES);
//		$this->select=$ob->select();
//echo $ob->select();
//��ܤ��e
$obj->display($template_file);
//�G������
foot();


//����class
class chc_seme{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $stu;//�ǥ͸��
	var $class_id;//��ذ}�C
	var $StuTitle;
	var $kind=array('0'=>'0.�Z�ŷF��','1'=>'1.���ηF��','2'=>'2.���թʷF��');
	//var $kind0=array('�Z��','�ƯZ��','�d�֪Ѫ�','�����Ѫ�','�ưȪѪ�','�åͪѪ�','�����Ѫ�','���ɪѪ�','���O�Ѫ�','��T�Ѫ�');


	//�غc�禡
	function chc_seme($CONN,$smarty){
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
	}
	//��l��
	function init() {
		$YS=''; 
		if (isset($_POST['year_seme'])) $YS=$_POST['year_seme'];
		if ($YS=='' && isset($_GET['year_seme'])) $YS=$_GET['year_seme'];
		if ($YS=='') $YS=curr_year()."_".curr_seme();
		$this->year_seme=$YS;
		$aa=split("_",$this->year_seme);
		$this->year=$aa[0];
		$this->seme=$aa[1];		
		
		}
	//�{��
	function process() {
		if(isset($_POST['form_act']) && $_POST['form_act']=='add1') $this->add1();
		if(isset($_POST['form_act']) && $_POST['form_act']=='add2') $this->add2();
	
		$this->all();
	}

	//�^�����
	function all(){	}


	//���
	function display($tpl){
		//$ob=new drop($this->CONN);
		// $this->select=&$ob->select();
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
	}





	//�s�W���
	function add1(){
		//echo '<pre>';print_r($_POST);die();
		// $kind='0';
	
		$stud_id=strip_tags(trim($_POST['NO']));
		$SQL="select  stud_id ,student_sn from stud_base where stud_id='$stud_id' order by student_sn desc limit 1 ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$arr=$rs->GetArray();
		if(count($arr)==0) backe('�I�I�S���o�Ӿǥ;Ǹ��I�I');
		$tea_sn=$_SESSION['session_tea_sn'];
		$SN=$arr[0]['student_sn'];
		$seme=strip_tags(trim($_POST['seme']));
		$title=strip_tags(trim($_POST['title']));
		$org_name=strip_tags(trim($_POST['org_name']));
		if (!is_numeric($org_name)) backe('�I�I�Z�ťN�X��g���~�I�I');
		$memo=strip_tags(trim($_POST['memo']));
		$cr_time=date("Y-m-d H:i:s");
		$SQL="INSERT INTO chc_leader(student_sn,seme,kind,org_name,title,update_sn,cr_time)  
		values ('{$SN}' ,'{$seme}' ,'0' ,'{$org_name}' ,'{$title}' ,'{$tea_sn}' ,'{$cr_time}' )";
		$rs=$this->CONN->Execute($SQL) or die($SQL);

		$URL="leader_prt.php?SN=".$SN;
		Header("Location:$URL");
	}





	//�s�W���2
	function add2(){
		//echo '<pre>';print_r($_POST);die();
		// $kind='0';
	
		$stud_id=strip_tags(trim($_POST['NO']));
		$SQL="select  stud_id ,student_sn from stud_base where stud_id='$stud_id' order by student_sn desc limit 1 ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$arr=$rs->GetArray();
		if(count($arr)==0) backe('�I�I�S���o�Ӿǥ;Ǹ��I�I');
		$kind=(int)$_POST['kind'];
		if($kind!=1 and $kind!=2) backe('�I�I���O���~�I�I');
		$tea_sn=$_SESSION['session_tea_sn'];
		$SN=$arr[0]['student_sn'];
		$seme=strip_tags(trim($_POST['seme']));
		$title=strip_tags(trim($_POST['title']));
		$org_name=strip_tags(trim($_POST['org_name']));
		//if (!is_numeric($org_name)) backe('�I�I�Z�ťN�X��g���~�I�I');
		$memo=strip_tags(trim($_POST['memo']));
		$cr_time=date("Y-m-d H:i:s");
		$SQL="INSERT INTO chc_leader(student_sn,seme,kind,org_name,title,update_sn,cr_time)  
		values ('{$SN}' ,'{$seme}' ,'{$kind}' ,'{$org_name}' ,'{$title}' ,'{$tea_sn}' ,'{$cr_time}' )";
		$rs=$this->CONN->Execute($SQL) or die($SQL);

		$URL="leader_prt.php?SN=".$SN;
		Header("Location:$URL");
	}







}


