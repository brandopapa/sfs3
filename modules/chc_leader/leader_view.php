<?php
//$Id: PHP_tmp.html 5310 2009-01-10 07:57:56Z hami $
include "config.php";
//�{��
sfs_check();

//�ޤJ��������(�ǰȨt�ΥΪk)
include_once "../../include/chi_page2.php";
//�{���ϥΪ�Smarty�˥���
$template_file = dirname (__file__)."/templates/leader_view.html";

//�إߪ���
$obj= new chc_leader($CONN,$smarty);
//��l��
$obj->init();
//�B�z�{��,���ɵ{�Ǥ���header���O,�G���{�ǩy��head("chc_leader�Ҳ�");���e
$obj->process();

//�q�X�����������Y
head("[��]�Z�ŷF���޲z");

//���SFS�s�����(���ϥνЮ��}����)
echo make_menu($school_menu_p);

//��ܤ��e
$obj->display($template_file);
//�G������
foot();


//����class
class chc_leader{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $size=20;//�C������
	var $page;//�ثe����
	var $tol;//����`����
	var $KKary=array('A'=>'�Z�ŷF��','B'=>'���ηF��','C'=>'���թʷF��');
	var $K2ary=array('A'=>'0','B'=>'1','C'=>'2');
	var $Grade=array(1=>"�@�~",2=>"�G�~",3=>"�T�~",4=>"�|�~",5=>"���~",6=>"���~",7=>"�@�~",8=>"�G�~",9=>"�T�~");
	//�غc�禡
	function chc_leader($CONN,$smarty){
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
	}
	//��l��
	function init() {
		if ($_GET['KK']!='') $KK=strip_tags($_GET['KK']);
		if ($_POST['KK']!='') $KK=strip_tags($_POST['KK']);
		$this->KK=($KK=='') ? 'A':$KK;
		$this->page=($_GET['page']=='') ? 0:$_GET['page'];}
	//�{��
	function process() {
		if(isset($_GET['form_act']) && $_GET['form_act']=='del') $this->del();
		$this->all();
	}
	//���
	function display($tpl){
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
	}
	//�R��
	function del(){
		$id=(int)$_GET['id'];
		$SQL="Delete from  chc_leader  where  id='{$id}' ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$URL=$_SERVER['SCRIPT_NAME']."?KK=".$this->KK."&page=".$this->page;
		Header("Location:$URL");
	}


	//�^�����
	function all(){
		$K=$this->KK;
		$KIND=$this->K2ary[$K]; 
		
		$SQL="select id from chc_leader where kind='{$KIND}' ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$this->tol=$rs->RecordCount();
		$SQL="select a.*,b.stud_name,b.stud_id,b.stud_sex from chc_leader  a,stud_base b  
		where  kind='{$KIND}' and a.student_sn=b.student_sn order by a.seme desc, 	a.org_name  desc,a.title  limit ".($this->page*$this->size).", {$this->size}  ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		//echo$SQL; 
		$arr=$rs->GetArray();
		$this->all=$arr;//return $arr;
	//���ͳs������
		$url=$_SERVER['SCRIPT_NAME']."?KK=".$this->KK;
		$this->links= new Chi_Page($this->tol,$this->size,$this->page,$url);
	}

	function OName($cla){
		$G=substr($cla,0,1);
		$G2=substr($cla,-2);
		return $this->Grade[$G].$G2.'�Z';
	}
	
}

