<?php
//$Id: PHP_tmp.html 5310 2009-01-10 07:57:56Z hami $
include "config.php";
//�{��
sfs_check();

if ($_SESSION['session_who']=='�ǥ�') Header("Location:stu.php");

//���w�˥�
$template_file = dirname (__file__)."/templates/chc_basic12.htm";

//�إߪ���
$obj= new basic_chc($CONN,$smarty);
$obj->sfsURL=$SFS_PATH_HTML;

//��l��
$obj->init();

//�B�z�{��,���ɵ{�Ǥ���header���O,�G���{�ǩy��head("chc_basic12�Ҳ�");���e
$obj->process();

//�q�X�����������Y
head("���ưϧK�դJ��");


//���SFS�s�����(���ϥνЮ��}����)
echo make_menu($school_menu_p);

//��ܤ��e
$obj->display($template_file);

//�G������
foot();


//����class
class basic_chc{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $sfsURL;
	//�غc�禡
	function basic_chc($CONN,$smarty){
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
	}
	//��l��
	function init() {}
	//�{��
	function process() {

		$this->all();
	}
	//���
	function display($tpl){
		
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
	}
	//�^�����
	function all(){
		$SQL="select  academic_year ,count(*) as tol from chc_basic12 group by academic_year order by academic_year desc ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$arr=$rs->GetArray();
		$this->all=$arr;//return $arr;
	//���ͳs������
	}


}


