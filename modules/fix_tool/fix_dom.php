<?php
//$Id$
include "config.php";
//�{��
sfs_check();


//�إߪ���
$obj= new My_TB($CONN,$smarty);
//��l��
$obj->init();
//�B�z�{��
$obj->process();

//�q�X�����������Y
head("���D�u��c--�ɤJ��f");
//�˥���

//��ܤ��e
$obj->display();
//�G������
foot();


//����class
class My_TB{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $size=10;//�C������
	var $page;//�ثe����
	var $tol;//����`����


	//�غc�禡
	function My_TB($CONN,$smarty){
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
	}
	//��l��
	function init() {}
	//�{��
	function process() {
		if($_GET['act']=='add') $this->add();
		$this->all();
	}
	//���
	function display(){
		$tpl = "fix_dom.htm";
		$this->smarty->template_dir=dirname(__file__)."/templates/";
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
	}
	//�^�����
	function all(){
		if ($_POST[stud_id]=='') return ;
		$stud_id=(int)$_POST['stud_id'];
		if ($stud_id==0 || $stud_id=='') return ;
		$SQL="select * from stud_base where stud_id='$stud_id' ";
		$rs=&$this->CONN->Execute($SQL) or die($SQL);
		$arr=&$rs->GetArray();
		foreach ($arr as $ary){
			$SN=$ary['student_sn'];
			$ID=$ary['stud_id'];
			$ary['check_dom']=$this->sTol($SN,$ID);
			$All[]=$ary;		
		}
		
		$this->all=$All;//return $arr;

	}
	//�s�W
	function add(){
		if ($_GET['sn']=='') return ;
		$sn=(int) $_GET['sn'];
		if ($sn==0 ||$sn=='' ) return ;
		$SQL="select student_sn,stud_id from stud_base where student_sn='{$sn}' ";
		$rs=&$this->CONN->Execute($SQL) or die($SQL);
		$tol=$rs->RecordCount();
		if ($tol==0 || $tol >1 ) return ; 
		$arr=&$rs->GetArray();
		$ary=$arr[0];
		
		
		$SQL="INSERT INTO stud_domicile (stud_id ,student_sn) values (
		'{$ary['stud_id']}' ,'{$ary['student_sn']}'  )";
		$rs=&$this->CONN->Execute($SQL) or die($SQL);
		//$Insert_ID= $this->CONN->Insert_ID();
		$URL=$_SERVER[PHP_SELF];
		Header("Location:$URL");
	}
	//��s
	function sTol($sn,$id){
		$SQL="select * from stud_domicile where stud_id='{$id}' and student_sn='{$sn}' ";
		$rs=&$this->CONN->Execute($SQL) or die($SQL);
		return $rs->RecordCount();
	}


}

