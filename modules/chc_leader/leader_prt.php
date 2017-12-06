<?php
//$Id: chc_seme.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";
//�{��
sfs_check();


//�إߪ���
$obj= new chc_seme($CONN,$smarty);
//��l��
$obj->init();
//�B�z�{��,���ɵ{�Ǥ���header���O,�G���{�ǩy��head("score_semester_91_2�Ҳ�");���e
$obj->process();


//����class
class chc_seme{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $stu;//�ǥ͸��
	var $class_id;//��ذ}�C
	var $StuTitle;
	var $Grade=array(1=>"�@�~",2=>"�G�~",3=>"�T�~",4=>"�|�~",5=>"���~",6=>"���~",7=>"�@�~",8=>"�G�~",9=>"�T�~");
	//�غc�禡
	function chc_seme($CONN,$smarty){
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
		$this->kind0=getLeaderKind('A');
	}
	//��l��,���o�ǥ�SN�}�C
	function init() {
		$this->allSN='';
		//�ǤJ�ǥ�SN
		if (isset($_GET['SN']) && empty($_GET['class_id'])){
			$SN=(int)$_GET['SN'];//���Ʀr
			$this->allSN=array($SN);
		}
		//�ǤJ�Z�ŽX
		if (isset($_GET['class_id']) && empty($_GET['SN'])){
			$cla=strip_tags($_GET['class_id']);//���Ʀr
			$this->allSN=$this->getSN($cla);
		}
		if ($this->allSN=='') backe('!!!���ǭ�!!!');
		
	}
	//�{��
	function process() {
		// �s�W if(isset($_POST['form_act']) && $_POST['form_act']=='add') $this->add();
		// ��s if(isset($_POST['form_act']) && $_POST['form_act']=='update') $this->update();
		// �R�� if(isset($_GET['form_act']) && $_GET['form_act']=='del') $this->del();
		$this->all();
		$this->display();
	}

	//���
	function display(){
		//�{���ϥΪ�Smarty�˥���
		$tpl = dirname (__file__)."/templates/leader_prt.htm";
		// �q�X�����������Y
		// head("[��]�Z�ŷF���޲z");
		// ���SFS�s�����(���ϥνЮ��}����)
		// echo make_menu($school_menu_p);
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
		// �G������
		// foot();
	}

	//�ǤJclass_id,�ǥX�ǥ�sn�}�C(�@�ӯZ)
	function getSN($class_id){
		$st_sn=array();
		$class_ids=split("_",$class_id);
		$seme=$class_ids[0].$class_ids[1];
		$the_class=($class_ids[2]+0).$class_ids[3];
		$SQL="select student_sn from stud_seme where  seme_year_seme ='$seme' and seme_class='$the_class' order by seme_num ";
		//echo $SQL;
		$rs = $this->CONN->Execute($SQL);
		if ($rs->RecordCount()===0) return '';
		$all=$rs->GetArray();
		foreach ($all as $ary){
			$st_sn[]=$ary['student_sn'];
			}
		return $st_sn;
	}
	//�^�����
	function all(){
		//if ($this->SN=='') return;
		$this->sch=get_school_base();

	}


	//�^�����
	function OneStu($sn){

		if ($sn=='') return;
		//print_r($this->sch);
		$SQL="select stud_id,stud_name,stud_sex,stud_birthday ,stud_person_id  from stud_base where student_sn='{$sn}' ";
		// echo $SQL; 
		// $this->StuTitle='';
		$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		if ($rs->RecordCount()===0) backe('!!!�S���Ӿǥ�!!!');
		$tmp=$rs->GetArray();
		$Stu['base']=$tmp[0];


		//$SQL="select a.*,b.seme_year_seme,b.seme_class,b.seme_num from chc_leader a,stud_seme b	
		//where a.student_sn='{$sn}' and a.student_sn=b.student_sn  and a.seme=b.seme_year_seme
		//order by a.seme asc ,a.kind asc ";
		
		$SQL="select a.*,b.seme_year_seme,b.seme_class,b.seme_num from chc_leader a
		left join stud_seme b	on (a.student_sn=b.student_sn and a.seme=b.seme_year_seme)
		where a.student_sn='{$sn}' 	order by a.seme asc ,a.kind asc ";

		// echo $SQL; 
		// $this->StuTitle='';
		$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		if ($rs->RecordCount()===0) {$Stu['data']='';}else {	$Stu['data']=$rs->GetArray();} 
		return $Stu;
	}

	function OName($cla){
		$G=substr($cla,0,1);
		$G2=substr($cla,-2);
		return $this->Grade[$G].$G2.'�Z';
	}
	function Birth($dd){
		$da=explode('-',$dd);
		$str=($da[0]-1911).'-'.$da[1].'-'.$da[2];
	return $str;
}




}
