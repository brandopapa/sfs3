<?php
//$Id: stud_sta_new.php 6815 2012-06-22 08:27:11Z smallduh $
include "config.php";
//�{��
sfs_check();

//�ޤJ��������(�ǰȨt�ΥΪk)
include_once "../../include/chi_page2.php";
include_once "../../include/sfs_oo_dropmenu.php";

//�{���ϥΪ�Smarty�˥���
$template_file = dirname (__file__)."/templates/stud_sta.htm";

//�إߪ���
$obj= new stud_sta($CONN,$smarty);
$obj->sfs_url=$SFS_PATH_HTML;
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
	var $size=20;//�C������
	var $page;//�ثe����
	var $tol;//����`����
	var $select;
	var $sfs_url;

	//�غc�禡
	function stud_sta($CONN,$smarty){
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
	}
	//��l��
	function init() {
		$ob=new drop($this->CONN);
		$this->select=&$ob;
		$this->year_seme=&$this->select->year_seme;
		}
	//�{��
	function process() {
		if($_POST[form_act]=='add') $this->add();
		if($_POST[form_act]=='remove') $this->update();
		if($_GET[form_act]=='del') $this->del();
		if($_POST[form_act]=='add_DB') $this->add_DB();
		$this->all();$this->SEL();
	}
	//���
	function display($tpl){
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
	}
	//�^�����
	function all(){
		if ($_GET[class_id]=='') return;
		$SEME=split("_",$_GET[year_seme]);
		$SEME4=sprintf("%03d",$SEME[0]).$SEME[1];
		$Class=split("_",$_GET[class_id]);//095_1_01_03
		$Class3=($Class[2]+0).sprintf("%02d",$Class[3]);
		$SQL="select  a.stud_id, a.student_sn,b.seme_num,a.stud_name, a.stud_sex from stud_base a  , stud_seme b where b.seme_year_seme ='{$SEME4}' and b.seme_class ='{$Class3}' and a.student_sn=b.student_sn order by b.seme_class, b.seme_num  ";
		$rs=&$this->CONN->Execute($SQL) or die($SQL);
		$this->stu=$this->Full_TD($rs->GetArray(),5);
	}
	//�s�W
	function add(){
		if ($_POST[stu]=='') return;
		foreach ($_POST[stu] as $sn =>$value){$stu[]=$sn;}
		if ($_SESSION[sel_stu]=='') {
			//session_register("sel_stu");
			$_SESSION[sel_stu]=$stu;
		}	else {
			$_SESSION[sel_stu]=array_unique(array_merge($_SESSION[sel_stu],$stu));
		}
	}
	//��s
	function update(){
		if ($_POST[stu]=='') return;
		foreach ($_POST[stu] as $sn =>$val_1){
			foreach ($_SESSION[sel_stu] as $key =>$val_2){
				if ($sn==$val_2) unset($_SESSION[sel_stu][$key]);
				}
		}
	}
	//�s�W
	function add_DB(){
		if ($_POST[year_seme]=='') return;
		if ($_POST[purpose]=='') return;
		if ($_POST[prove_date]=='') return;
		$a=join(",",$_SESSION[sel_stu]);
		if ($a=='')  {unset($_SESSION[sel_stu]);return;}
		$SEME=split("_",$_POST[year_seme]);
		$seme=$SEME[0].$SEME[1];
		$IP=$_SERVER['REMOTE_ADDR'];
		$USER=$_SESSION[session_log_id];
		$SQL="select  stud_id,student_sn from stud_base where student_sn in ($a) ";
		$rs=&$this->CONN->Execute($SQL) or die($SQL);
		$aa=&$rs->GetArray();
		foreach ($aa as $ary){
			$SQL="INSERT INTO stud_sta(stud_id,student_sn,prove_year_seme,purpose,prove_date,set_id,set_ip,prove_cancel)  values ('{$ary['stud_id']}','{$ary['student_sn']}' ,'{$seme}' ,'{$_POST['purpose']}' ,'{$_POST['prove_date']}' ,'{$USER}' ,'{$IP}' ,'0' )";
			$rs=&$this->CONN->Execute($SQL) or die($SQL);
		}
		unset($_SESSION[sel_stu]);
//		$URL=$_SERVER[PHP_SELF]."sta_view.php?page=0".$_POST[page];
		$URL="sta_view.php?page=0";
		Header("Location:$URL");
	}
	//�R��
	function del(){
	}
	function Full_TD($data,$num) {
		$all=count($data);
		$loop=ceil($all/$num);
		$all_td=($loop*$num)-1;//�̤j�Ȥp1
		for ($i=0;$i<($loop*$num);$i++){
		(($i%$num)==($num-1) && $i!=0 && $i!=$all_td) ? $data[$i][next_line]='yes':$data[$i][next_line]='';
		}
		return $data;
		}
	function SEX($a){
		if($a=='1'){return "<img src='images/boy.gif'>";}
		else {return "<img src='images/girl.gif'>";}
	}
	function CLA($a){
		$year=substr($a,0,1);
		$class=substr($a,1,2);
		if ($year>6)$year=$year-6;
		return $year."�~".$class."�Z";
	}

	function SEL(){
		if ($_SESSION[sel_stu]=='') {unset($_SESSION[sel_stu]);return;}
		$a=join(",",$_SESSION[sel_stu]);
		if ($a=='')  {unset($_SESSION[sel_stu]);return;}
		$SEME=split("_",$this->year_seme);
		$SEME4=sprintf("%03d",$SEME[0]).$SEME[1];
		$SQL="select  a.stud_id, a.student_sn,b.seme_class,b.seme_num,a.stud_name, a.stud_sex from stud_base a  , stud_seme b 
		where a.student_sn in ($a) and b.seme_year_seme ='{$SEME4}' and  a.student_sn =b.student_sn order by  b.seme_class,b.seme_num  ";
		$rs=&$this->CONN->Execute($SQL) or die($SQL);
		$this->s_stu=$this->Full_TD($rs->GetArray(),5);
		}
	
}
?>
