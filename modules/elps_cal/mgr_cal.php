<?php
//$Id: mgr_cal.php 7866 2014-01-23 09:32:31Z hami $

include "config.php";
//�{��
sfs_check();


 
//�ޤJ��������(�ǰȨt�ΥΪk)
include_once "../../include/chi_page2.php";
//�{���ϥΪ�Smarty�˥���
$template_file = dirname (__file__)."/templates/cal_elps_set.htm";

//�إߪ���
$obj= new cal_elps_set($CONN,$smarty);
//��l��
$obj->init();
//�B�z�{��,���ɵ{�Ǥ���header���O,�G���{�ǩy��head("cal_elps_set�Ҳ�");���e
$obj->process();

//�q�X�����������Y
head("�հȦ�ƾ�");

//���SFS�s�����(���ϥνЮ��}����)
echo make_menu($school_menu_p);

//��ܤ��e
$obj->display($template_file);
//�G������
foot();


//����class
class cal_elps_set{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $size=10;//�C������
	var $page;//�ثe����
	var $tol;//����`����
	var $wk_mode=array("0"=>"�۰ʭp��","1"=>"�}�Ǥ�]�w");
	//�غc�禡
	function cal_elps_set($CONN,$smarty){
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
	}
	//��l��
	function init() {$this->page=($_GET[page]=='') ? 0:$_GET[page];}
	//�{��
	function process() {
		if($_POST[form_act]=='add') $this->add();
		if($_POST[form_act]=='update') $this->update();
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
		$SQL="select syear from cal_elps_set ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$this->tol=$rs->RecordCount();
		$SQL="select * from cal_elps_set  order by syear desc  limit ".($this->page*$this->size).", {$this->size}  ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$arr=$rs->GetArray();
		$this->all=$arr;//return $arr;
	//���ͳs������
		$this->links= new Chi_Page($this->tol,$this->size,$this->page);
	}
	//�s�W
	function add(){
		$SQL="INSERT INTO cal_elps_set(syear,sday,weeks,unit,week_mode) values ('{$_POST['syear']}' ,'{$_POST['sday']}','{$_POST['weeks']}' ,'{$_POST['unit']}' ,'{$_POST['week_mode']}')";
		$res=$this->CONN->Execute($SQL) or die($SQL);
		//$Insert_ID= $this->CONN->Insert_ID();
		if($_POST['copy_prior']){
			$syear=$_POST['syear'];
			$prior_year=substr($syear,0,-1)-1;
			$prior_seme=substr($syear,-1);
			$prior=sprintf('%03d%d',$prior_year,$prior_seme);
			$now=date("Y-m-d");
			
			//��scal_elps_set���   
			$sql2="SELECT weeks,unit,week_mode FROM cal_elps_set WHERE syear='$prior'";
			$rs=$this->CONN->Execute($sql2) or die('SQL������~:'.$sql2);
			$sql_update="UPDATE cal_elps_set SET weeks='{$rs->fields['weeks']}',unit='{$rs->fields['unit']}',week_mode='{$rs->fields['week_mode']}' WHERE syear='$syear'";
			$rs_update=$this->CONN->Execute($sql_update) or die($sql_update);
			//�s�Wcal_elps��� 
			$sql2="SELECT * FROM cal_elps WHERE syear='$prior'";	
			$rs=$this->CONN->Execute($sql2) or die('SQL������~:'.$sql2);
			while(!$rs->EOF) {
				$sql_copy="INSERT INTO cal_elps SET syear='$syear',week='{$rs->fields['week']}',unit='{$rs->fields['unit']}',user='{$rs->fields['user']}',day='$now',event='{$rs->fields['event']}',important='{$rs->fields['important']}'";
				$rs_copy=$this->CONN->Execute($sql_copy) or die('SQL������~:'.$sql_copy);
				$rs->MoveNext();
			}
		}
		$URL=$_SERVER[PHP_SELF]."?page=".$_POST[page];
		Header("Location:$URL");
	}
	//��s
	function update(){
		$SQL="update  cal_elps_set set   syear ='{$_POST['syear']}', sday ='{$_POST['sday']}', weeks ='{$_POST['weeks']}', unit ='{$_POST['unit']}', week_mode ='{$_POST['week_mode']}' where syear ='{$_POST['syear']}'";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$URL=$_SERVER[PHP_SELF]."?page=".$_POST[page];
		Header("Location:$URL");
	}
	//�R��
	function del(){
		$SQL="Delete from  cal_elps_set  where  syear='{$_GET['syear']}' ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$SQL="Delete from  cal_elps  where  syear='{$_GET['syear']}' ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$URL=$_SERVER[PHP_SELF]."?page=".$_GET[page];
		Header("Location:$URL");
	}
}

?>