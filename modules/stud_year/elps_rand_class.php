<?php
//$Id: elps_rand_class.php 5310 2009-01-10 07:57:56Z hami $
include "stud_year_config.php";
include_once "rand/rand_tool.php";
//�{��
sfs_check();

//�q�X�����������Y


$smarty->left_delimiter="{{";
$smarty->right_delimiter="}}";

//�إߪ���
$obj= new My_rand();
//$obj->init();
$obj->CONN=&$CONN;
$obj->smarty=&$smarty;
$obj->SFS_PATH=&$SFS_PATH;
$obj->sfs_menu=&$menu_p;
$obj->UPLOAD_PATH=&$UPLOAD_PATH;
$obj->IS_JHORES=&$IS_JHORES;
//�B�z�{��
$obj->run();


//����class
class My_rand{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $options;//���οﶵ..���t��Ʈw
	var $SFS_PATH;
	var $UPLOAD_PATH;
	var $IS_JHORES;
	var $My_Path;//�{���ؿ�
	var $mPath;//�Ҳ��ɮ׸��|
	var $action;
	private $mod; //�ϥΪ�class�Ҳ�
   public function __construct()   {  }
	 function init()   {
		$dir = dirname($_SERVER[PHP_SELF]);
		$dir_ary = explode('/',$dir);
		$dir_name=end($dir_ary);
		$mPath=$this->UPLOAD_PATH.'school/'.$dir_name.'/';
		if (!file_exists($mPath)) mkdir($mPath, 0777);
		if (!file_exists($mPath)) backe('�L�k�إ��x�s�ؿ�<br>'.$mPath);
		$this->mPath=&$mPath;
		define('__My_Path', $this->SFS_PATH.'/modules/'.$dir_name.'/');//�{�����|
	}
	//�{��
	function run() {
		$this->init();
		$this->load_mod();
		if ($this->action!=''){
			if (! class_exists($this->action)) backe('���󤣦s�b�I');
			$this->module= new $this->action();
			$this->module->CONN=&$this->CONN;//���J--�l���O�n�Ψ쪺��Ʈw����
			$this->module->SFS_PATH=&$this->SFS_PATH;
			$this->module->mPath=&$this->mPath;
			$this->module->sfs_menu=&$this->sfs_menu;
			$this->module->mSch=get_school_base();//print_r($this->module->mSch);
			$this->module->SFS_PATH=&$this->SFS_PATH;
			$this->module->mod=&$this->action;
			$this->module->IS_JHORES=&$this->IS_JHORES;
			$this->module->init();//���J--�l���O�n�Ψ쪺����
			$this->module->process();//�l���O�{��--�{���ʧ@
			$this->module->smarty=&$this->smarty;//�l���O�{��--�ҥ�Smarty����
			$this->module->display();//�l���O�{��--�˪��ɬ���

		}else {
			$this->display();
		}


	}
	//���J�Ҳ�
	private function load_mod(){
		$action=chkStr('step');
		if ($action=='') return ;
		$file=__My_Path.'/rand/'.$action.'.php';//echo$file; 
		if ($action!='' && file_exists($file)) {
			include_once($file);
			$this->action=$action;	//echo$this->action; 
			}else{
			backe('�D�k����I');
			}
		}	
	//���
	function display(){
		head("�b�y�Ͷüƽs�Z");
		print_menu($this->sfs_menu);
		$tpl = __My_Path."templates/rand_index.htm";
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
		foot();//�G������
	}
	


}//end class

