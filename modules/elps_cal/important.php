<?php
//$Id: index.php 5310 2009-01-10 07:57:56Z hami $
include"config.php";
include_once "cal_elps_class.php";

//sfs_check();
if ($_GET[syear]=='') {
	$now_Syear=sprintf("%03d",curr_year()).curr_seme();
	header("Location:$_SERVER[PHP_SELF]?syear=$now_Syear");
	}
class cal_index extends cal_elps{
	//��l��
	function init() {
		$this->seme=$_GET[syear];	
	}
	//�{��
	function process() {
		$this->init();
		$this->get_all_set();//�������Ǵ���ƾ�]�w
		$this->get_use_set();//���ϥΤ���ƾ�]�w
		$this->get_all_event();//�[�J�Ҧ���Ƹ��
		//$this->all();
	}
	//���
	function display(){
		$tpl=dirname(__file__)."/templates/important.html";
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
	}

}
//�إߪ���
$obj= new cal_index();
$obj->CONN=&$CONN;
$obj->smarty=&$smarty;
$obj->process();

//���SFS�s�����(���ϥνЮ��}����)
//echo make_menu($school_menu_p);

//myheader();
//��ܤ��e
$obj->display();
//�G������


?>