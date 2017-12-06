<?php

include "config.php";
//�{��
sfs_check();

//���w�˥�
$template_file = dirname (__file__)."/templates/fix_teacher_id.htm";

//�إߪ���
$obj= new fix_teacherID($CONN,$smarty);
$obj->sfsURL=$SFS_PATH_HTML;

//��l��
$obj->init();

//�B�z�{��,���ɵ{�Ǥ���header���O,�G���{�ǩy��head("chc_basic12�Ҳ�");���e
$obj->process();

//�q�X�����������Y
head("���ը����Ҧr�������ˬd");

//���SFS�s�����(���ϥνЮ��}����)
echo make_menu($school_menu_p);
//~ echo "<pre>";
//~ print_r($obj);
//��ܤ��e
$obj->display($template_file);

//�G������
foot();


//����class
class fix_teacherID{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $sfsURL;
	//�غc�禡
	function fix_teacherID($CONN,$smarty){
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
	}
	//��l��
	function init() {}
	//�{��
	function process() {
		$this->check1();
	}
	//���
	function display($tpl){
		
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
	}
	//�^�����
	function check1(){
		//1.���Юv���
		$SQL="SELECT teach_person_id as perID,name as cname,teacher_sn as SN,
		'T' as kind FROM teacher_base";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$arr1=$rs->GetArray();
		//2.���ǥ͸��
		$SQL="SELECT stud_person_id as perID,stud_name as cname,student_sn as SN,
		'S' as kind FROM stud_base ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$arr2=$rs->GetArray();
		// 3.�X��$arr1+$arr2;
		$arr = array_merge($arr1,$arr2);
		//4.�]�j�鮳�r����KEY�����s�}�C
		foreach ($arr as $ary){
			$K=$ary['perID'];//���r����Key
			$Pid[$K][]=$ary;
			}
		//5.�p��s�}�C���e�j��1��,�æC�X���
		foreach ($Pid as $k=>$AR){
			if (count($AR)>1) $New[$k]=$AR;
			}
	
	$this->check=$New;
	$this->tol=count($New);
	//echo '<pre>';print_r($New);
	}


}


