<?php
//$Id: sta_view.php 6120 2010-09-11 02:38:04Z brucelyc $
include "config.php";
//�{��
sfs_check();


//�ޤJ��������(�ǰȨt�ΥΪk)
include_once "../../include/chi_page2.php";
//�{���ϥΪ�Smarty�˥���
$template_file = dirname (__file__)."/templates/sta_view.htm";

//�إߪ���
$obj= new stud_sta($CONN,$smarty);

//��l��
$obj->init();

//�B�z�{��,���ɵ{�Ǥ���header���O,�G���{�ǩy��head("stud_sta�Ҳ�");���e
$obj->process();

//�q�X�����������Y
head("stud_sta�Ҳ�");

//���SFS�s�����(���ϥνЮ��}����)
echo make_menu($school_menu_p);

//��ܤ��e
$obj->display($template_file);

//�G������
foot();

//����class
class stud_sta{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $size=25;//�C������
	var $page;//�ثe����
	var $tol;//����`����

	//�غc�禡
	function stud_sta($CONN,$smarty){
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
	}
	//��l��
	function init() {$this->page=($_GET[page]=='') ? 0:$_GET[page];}
	//�{��
	function process() {

		if($_GET[form_act]=='enable') $this->update();
		if($_GET[form_act]=='del') $this->del();
		$this->all();
	}
	//���
	function display($tpl){
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
	}
	//�^�����
	function all(){
		$SQL="select prove_id from stud_sta ";
		$rs=&$this->CONN->Execute($SQL) or die($SQL);
		$this->tol=$rs->RecordCount();
		$SQL="select a.*,b.stud_name  from stud_sta a ,stud_base b where a.student_sn=b.student_sn order by prove_id desc  limit ".($this->page*$this->size).", {$this->size}  ";
		$rs=&$this->CONN->Execute($SQL) or die($SQL);
		$arr=$rs->GetArray();
		$this->all=$arr;//return $arr;
		//���Юv�m�W
		$SQL="select DISTINCT(a.set_id),b.name  from stud_sta a ,teacher_base b where a.set_id=b.teach_id ";
		$rs=&$this->CONN->Execute($SQL) or die($SQL);
		if ($rs ) { 
			foreach ($rs->GetArray() as $ary){$this->tea[$ary[set_id]]=$ary[name];}
		}
	//���ͳs������
		$this->links= new Chi_Page($this->tol,$this->size,$this->page);
	}
	//��s
	function update(){
		$SQL="update  stud_sta set  prove_cancel ='0' where prove_id ='{$_GET['id']}'";
		$rs=&$this->CONN->Execute($SQL) or die($SQL);
		$URL=$_SERVER[PHP_SELF]."?page=".$_GET[page];
		Header("Location:$URL");
	}
	//�R��
	function del(){
		$SQL="update  stud_sta set  prove_cancel ='1' where prove_id ='{$_GET['id']}'";
		$rs=&$this->CONN->Execute($SQL) or die($SQL);
		$URL=$_SERVER[PHP_SELF]."?page=".$_GET[page];
		Header("Location:$URL");
	}
}
?>
