<?php
//$Id: run_test.php 6811 2012-06-22 08:18:14Z smallduh $
include "config.php";
//�{��
sfs_check();

//�ޤJ��������
include_once "../../include/chi_page2.php";

//�إߪ���
$obj= new run_test($smarty);
//��l��
$obj->init($mysql_host,$mysql_user,$mysql_pass);
//�B�z�{��
$obj->process();

//�q�X�����������Y
head("���ռҲ�");
echo make_menu($school_menu_p);
//�˥���
$template_file = dirname (__file__)."/template/run_test.htm";
//��ܤ��e
$obj->display($template_file);
//�G������
foot();


//����class
class run_test{
	// var $CONN;//adodb����
	var $smarty;//smarty����
	var $size=20;//�C������
	var $page;//�ثe����
	var $tol;//����`����
	
	var $DB;
	var $TB;
	var $field;
	
	

	//�غc�禡
	function run_test($smarty){
		//$this->CONN=&$CONN;
		$this->smarty=&$smarty;
	}
	//��l��
	function init($mysql_host,$mysql_user,$mysql_pass) {
		$this->link = mysql_connect($mysql_host,$mysql_user,$mysql_pass);
		$this->page=($_GET[page]=='') ? 0:$_GET[page];
		}
	//�{��
	function process() {
		if ($_GET[TB]!='' && $_GET[DB]!='' && $_GET[DB]!='mysql'){
			$this->DB=$_GET[DB];
			$this->TB=$_GET[TB];
			$this->get_info();
			if($_POST[act]=='new_ord') $this->New_ord();
			$this->all();
		}
	}
	//���
	function display($tpl){
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
	}
	//�զX����
	function New_ord(){
//		echo "<PRE>";print_r($_POST);
		//�B�z�j�M

		foreach ($_POST[serch_Key] as $key => $val ){
			if(in_array($key,$this->field) && $val!='' ) { $Serch[]= $key." like '%".$val."%' ";}
			}

		if ($Serch!=''){
			$this->Serch=" where ".join(" and ",$Serch);
			//session_register("Serch_SQL");
			$_SESSION[Serch_SQL]=$this->Serch;
		}

		//�B�z�Ƨ�
		$ary=explode(",",$_POST[ord_key]);
		$str='';
		foreach ($ary as $val ){
			if(in_array($val,$this->field)) {$str[]=$val." ".$_POST[Ord_Key][$val];}
			}
		if($str!='') {
			$this->Add_SQL=" order by ".join(",",$str);
			//session_register("Add_SQL");
			$_SESSION[Add_SQL]=$this->Add_SQL;
			}
		else {
			unset($_SESSION[Add_SQL]);unset($_SESSION[Serch_SQL]);}
	}
	//�^�����
	function all(){
		$this->Add_SQL=$_SESSION[Add_SQL];
		$this->Serch=$_SESSION[Serch_SQL];
		$SQL="select `{$this->field[0]}` from `{$this->TB}` {$this->Serch}";
		$SQL1="select `{$this->field[0]}` from `{$this->TB}` ";
		$rs = mysql_db_query ($this->DB,$SQL);
		if(!$rs) {
			unset($_SESSION[Serch_SQL]);
			$rs = mysql_db_query ($this->DB,$SQL1);
			}
		$this->tol=mysql_num_rows($rs);
		// order by {$this->field[0]} desc 
		
		$SQL="select * from `{$this->TB}` {$this->Add_SQL} limit ".($this->page*$this->size).", {$this->size}  ";
		$SQL1="select * from `{$this->TB}`  limit ".($this->page*$this->size).", {$this->size}  ";
		$rs = mysql_db_query ($this->DB,$SQL);
		if(!$rs) {
			unset($_SESSION[Add_SQL]);
			$rs = mysql_db_query ($this->DB,$SQL1);
			}
		while ($row = mysql_fetch_array ($rs)) {$arr[]=$row;}
		$this->all=$arr;//return $arr;
		//���ͳs������
		$URL=$_SERVER[PHP_SELF]."?DB=".$this->DB."&TB=".$this->TB;
		$this->links= new Chi_Page($this->tol,$this->size,$this->page,$URL);
	}

	function get_info(){
		$SQL=" SHOW DATABASES  ";
		$data = mysql_query( $SQL,$this->link ) or die("�L�k�s����Ʈw") ; //������O���X���
		while ($row = mysql_fetch_array ($data)) {
			if($row[0]=='mysql') continue;
			$db[]=$row[0];
		}

		if(!in_array($this->DB,$db)) die("�L�Ӹ�Ʈw");

		$SQL="SHOW TABLES FROM  `{$this->DB}` ";
		$data = mysql_query( $SQL,$this->link ) or die($SQL); //������O���X���
		while ($row = mysql_fetch_array ($data)) {$tb[]=$row[0];}
		if(!in_array($this->TB,$tb)) die("�L�Ӹ�ƪ�");
		
		$SQL="SHOW FIELDS FROM `{$this->TB}`  ";
		$data = mysql_db_query ($this->DB,$SQL);
		while ($row = mysql_fetch_array ($data)) {$Field[]=$row[0];}
		$this->field=$Field;
		$this->count_field=count($Field);
	}

}
?>