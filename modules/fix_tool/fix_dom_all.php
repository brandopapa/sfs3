<?php
//$Id$
include "config.php";
//�{��
sfs_check();
include $SFS_PATH.'/include/chi_page2.php';

//�إߪ���
$obj= new My_TB($CONN,$smarty);
//��l��
$obj->init();
//�B�z�{��
$obj->process();

//�q�X�����������Y
head("���D�u��c--�ɤJ��f");
//�˥���
print_menu($school_menu_p);
//��ܤ��e
$obj->display();
//�G������
foot();


//����class
class My_TB{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $size=100;//�C������
	var $page;//�ثe����
	var $tol;//����`����


	//�غc�禡
	function My_TB($CONN,$smarty){
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
	}
	//��l��
	function init() {
		$page=($_GET[page]=='') ? $_POST[page]:$_GET[page];
		$this->page=($page=='') ? 0:(int)$page;
	}
	//�{��
	function process() {
		$this->init();
		if($_POST['form_act']=='add') $this->add();
		$this->all();
	}
	//���
	function display(){
		$tpl = "fix_dom_all.htm";
		$this->smarty->template_dir=dirname(__file__)."/templates/";
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
	}
	//�^�����
	function all(){
		if($_POST['form_act']=='show'){
			$SQL="SHOW CREATE TABLE stud_domicile"; 
			$rs=&$this->CONN->Execute($SQL) or die($SQL);
			$arr=&$rs->GetArray();
			$this->all=$arr[0];
			return ;
		}
		$SQL="select student_sn from stud_base ";
		$rs=&$this->CONN->Execute($SQL) or die($SQL);
		$this->tol=$rs->RecordCount();
		
		
		$SQL="select a.student_sn,a.stud_id,a.stud_study_cond,a.stud_study_year,a.stud_name,
		a.stud_sex,a.curr_class_num,b.student_sn as NN from stud_base a 
		left join stud_domicile b on a.student_sn=b.student_sn and a.stud_id=b.stud_id 
		order by student_sn desc  limit ".($this->page*$this->size).", {$this->size} 	";
		  //a.student_sn=b.student_sn and a.stud_id=b.stud_id ";
		$rs=&$this->CONN->Execute($SQL) or die($SQL);
		$this->all=&$rs->GetArray();
		
		$this->links=new Chi_Page($this->tol,$this->size,$this->page);
		//$this->all=$All;//return $arr;

	}
	//�s�W
	function add(){
		// echo '<pre>';print_r($_POST);
		if (count($_POST['StuSN'])< 1 ) return ;
		foreach ($_POST['StuSN'] as $sn=>$id){
			$SQL="INSERT INTO stud_domicile (stud_id ,student_sn) values ('{$id}' ,'{$sn}')";
			//echo $SQL.'<br>'; 
			$rs=&$this->CONN->Execute($SQL) or die($SQL);		
		}
		
		//die();
		//$Insert_ID= $this->CONN->Insert_ID();
		$URL=$_SERVER['SCRIPT_NAME'].'?page='.$this->page;
		Header("Location:$URL");
	}



}

