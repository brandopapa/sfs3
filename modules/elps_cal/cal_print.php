<?php
//$Id: cal_print.php 5310 2009-01-10 07:57:56Z hami $

if ($_GET[syear]=='') die("<div align='center'><h1>�L�Ǧ~�׸��</h1></div>");
if ($_GET[mode]=='') die("<div align='center'><h1>�L�C�L�ѼƸ��</h1></div>");

/*�ޤJ�ǰȨt�γ]�w��*/
include"config.php";
include_once "cal_elps_class.php";
sfs_check();


class cal_index extends cal_elps{
	//��l��
	function init() {
		$this->seme=$_GET[syear];
		$this->mod=$_GET[mode];
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
		$tpl=dirname(__file__)."/templates/cal_print.html";
		$this->smarty->assign("this",$this);
		$content= $this->smarty->fetch($tpl);
		if ($this->mod=="doc" || $this->mod=="sxw" ) {
			$filename=$this->seme."_cal.".$this->mod;
			header("Content-type: application/x-download");
			header("Content-disposition: filename=$filename");
			echo $content;
			}
		else{
			echo  $content;
		}

	}

}


//�إߪ���
$obj= new cal_index();
$obj->CONN=&$CONN;
$obj->smarty=&$smarty;
$obj->process();
$obj->display();

?>