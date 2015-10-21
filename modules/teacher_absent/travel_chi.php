<?php
//$Id: PHP_tmp.html 5310 2009-01-10 07:57:56Z hami $
include "config.php";
//�{��
sfs_check();

//�ޤJ��������(�ǰȨt�ΥΪk)
// include_once "../../include/chi_page2.php";
//�{���ϥΪ�Smarty�˥���
$template_file = dirname (__file__)."/templates/teacher_chi.htm";

//�إߪ���
$obj= new teacher_absent_course($CONN,$smarty);
//��l��
$obj->init();
//�B�z�{��,���ɵ{�Ǥ���header���O,�G���{�ǩy��head("teacher_absent_course�Ҳ�");���e
$obj->process();

//�q�X�����������Y
head("�t�ȶO�C�L");

//���SFS�s�����(���ϥνЮ��}����)
echo make_menu($school_menu_p);

//��ܤ��e
$obj->display($template_file);
//�G������
foot();


//����class
class teacher_absent_course{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $size=10;//�C������
	var $page;//�ثe����
	var $tol;//����`����
	var $SN;//�Юv�N�X

	//�غc�禡
	function teacher_absent_course($CONN,$smarty){
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
	}
	//��l��
	function init() {
		$this->SN=(int)$_SESSION['session_tea_sn'];//�Юv
		// $this->SN='300';���ե�
		$this->Sch=get_school_base();//�Ǯո��
		$this->getTeach();//�Юv���
		}
	//�{��
	function process() {

		if($_POST['form_act']=='OK') $this->add();
		
		$this->all();
	}
	//���
	function display($tpl){
		$this->smarty->assign("this",$this);
		$this->smarty->assign("SN",$this->SN);
		$this->smarty->display($tpl);
	}
	//�^�����
	function all(){
		$Year=date("Y");
		
		$SQL="select a.*,count(c_id) as Num from teacher_absent a
		left join teacher_absent_course b  
		ON a.id=b.a_id and b.teacher_sn=a.teacher_sn and b.travel='1' 
		where a.teacher_sn='{$this->SN}'  and a.abs_kind='52' 
		and a.start_date like '{$Year}%' 
		group by a.id  ";
		//and check4_sn >'0' "; //�w�ֳ�
		//$SQL="select a.* from teacher_absent a
		//where a.teacher_sn='{$SN}'  and a.abs_kind='52' ";
		$SQL.=" order by a.start_date ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$arr=$rs->GetArray();
		$this->all=$arr;//return $arr;
		
	//���ͳs������
	//$this->links= new Chi_Page($this->tol,$this->size,$this->page);
	}
	//�C�L�e��
	function add(){

		foreach ($_POST['pMonth'] as $pMon){ 
			$MM[]=" a.start_date like '{$pMon}%' ";}
		$SQL="select a.*,count(c_id) as Num from teacher_absent a
		left join teacher_absent_course b  
		ON a.id=b.a_id and  b.travel='1' 
		where a.teacher_sn='{$this->SN}'  and a.abs_kind='52' 
		and (".join(" or ",$MM) ." )  group by a.id  ";
		$SQL.=" order by a.start_date ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$arr=$rs->GetArray();
		$this->all=$arr;//�X�t��C��(�t���ӽл�g�O)
		$this->Sub=$this->getMon($arr);//���g�O���
		
		$tpl = dirname (__file__)."/templates/teacher_chi_prt.htm";
		$this->smarty->assign("this",$this);
		$this->smarty->assign("SN",$this->SN);
		$this->smarty->display($tpl);
		die();
	}
	//�����
	function getMon($arr){
		foreach($arr as $ary) {
			if ($ary['Num']==0) continue;
			$tmp[]=$ary['id'];
			}
		$A_ID=join(" , ",$tmp);
		$SQL="select b.* from teacher_absent a,teacher_absent_course b 
		where b.teacher_sn='{$this->SN}'  and b.travel='1' 
		and a.id=b.a_id	and b.a_id IN ($A_ID) ";
		$SQL.=" order by a.start_date ,b.c_id ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		return $rs->GetArray();
	}

	//������
	function SelMonth($name){
		//$M=array();
		$str='';
		for($i=10;$i>=1;$i--){
			$A=date("Y-m",strtotime("-".$i." Months")); 
			$M[$A]=$A;
			$str.="<label><input type='checkbox' name='{$name}[]' value='{$A}' />{$A}</label>&nbsp;&nbsp;\n";
			if ($i==6)$str.="<br>";
		}
		//print_r($M);
		return $str;
	}

/*�^���Юv�W�U*/
function getTeach() {
	$SQL = "SELECT a.teacher_sn, a.name, a.birthday, a.address, a.home_phone, a.cell_phone , d.title_name ,b.class_num,b.post_class FROM  teacher_base a , teacher_post b, teacher_title d where  a.teacher_sn =b.teacher_sn  and b.teach_title_id = d.teach_title_id $teach_cond order by class_num, post_kind , post_office , a.teach_id ";
	$rs=$this->CONN->Execute($SQL) or die($SQL);
	$arys=array();
	while ($rs and $ro=$rs->FetchNextObject(false)) {
		$key=$ro->teacher_sn;
		$arys[$key] = get_object_vars($ro);
		}
	$this->Tea=$arys;
}


}


// �����Ÿ��i��


