<?php
//$Id: chc_seme.php 5310 2009-01-10 07:57:56Z hami $
// ini_set('display_errors', '1');
include "config.php";
//�{��
sfs_check();

//�{���ϥΪ�Smarty�˥���
$template_file = dirname (__file__)."/templates/teacher.htm";

//�إߪ���
$obj= new chc_seme($CONN,$smarty);
//��l��
$obj->init();
//�P�O�ꤤ6/��p0 �ܼ�
//$obj->IS_JHORES=$IS_JHORES;
//�B�z�{��,���ɵ{�Ǥ���header���O,�G���{�ǩy��head("score_semester_91_2�Ҳ�");���e

$obj->process();

//�q�X�����������Y
head("���ưϧK�դJ��");

//���SFS�s�����(���ϥνЮ��}����)
echo make_menu($school_menu_p);
//$ob=new drop($this->CONN,$IS_JHORES);
//		$this->select=$ob->select();
//echo $ob->select();
//��ܤ��e
$obj->display($template_file);
//�G������
foot();


//����class
class chc_seme{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $stu;//�ǥ͸��
	var $subj;//��ذ}�C
	var $rule;//����

	var $IS_JHORES;//�ꤤ�p
	var $year;//�Ǧ~
	var $seme;//�Ǵ�
	var $YS='year_seme';//�U�Ԧ����Ǵ����ڼƦW��
	var $year_seme;//�U�Ԧ����Z�Ū��ڼƭ�
	var $Sclass='class_id';//�U�Ԧ����Z�Ū��ڼƦW��
	//�غc�禡
	function chc_seme($CONN,$smarty){
		global $IS_JHORES;
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
		$this->IS_JHORES=$IS_JHORES;

	}
	//��l��
	function init() {
		//���o���ЯZ�ťN��
		$class_num = get_teach_class();
		if ($class_num == '') backe('�z���O�ť��Ѯv!!');
		
		$A=substr($class_num,0,1);
		$B=substr($class_num,1,2);
		$this->class_id=curr_year().'_'.curr_seme().'_'.sprintf("%02d",$A).'_'.sprintf("%02d",$B);
		//echo $this->class_id;
		}
	//�{��
	function process() {
		$this->all();
	}
	//���
	function display($tpl){
		//$ob=new drop($this->CONN);
		//$this->select=$this->select();
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
	}
	//�^�����
	function all(){
		$this->stu=$this->get_stu();
//		print_r($this->sco);		
	}
/* ���ǥͰ}�C,����stud_base��Pstud_seme��*/
	function get_stu(){
		$CID=split("_",$this->class_id);//093_1_01_01
		$year=$CID[0];
		$seme=$CID[1];
		$grade=$CID[2];//�~��
		$class=$CID[3];//�Z��
		$CID_1=$year.$seme;//0911
		$CID_2=sprintf("%03d",$grade.$class);//601
		$SQL="select 	a.stud_id,a.student_sn,a.stud_name,a.stud_sex,b.seme_year_seme,b.seme_class,b.seme_num,a.stud_study_cond  from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$CID_1' and b.seme_class='$CID_2' $add_sql order by b.seme_num ";
		$SQL="select a.stud_id,a.stud_name,a.stud_birthday ,a.stud_sex, a.stud_person_id ,
		b.seme_class,b.seme_num,a.stud_study_cond ,c.*  
		from stud_base a,stud_seme b, chc_basic12 c  where a.student_sn=c.student_sn and c.student_sn=b.student_sn 
		and b.seme_year_seme='$CID_1' and b.seme_class='$CID_2' 
		 order by b.seme_num ";
		//��� join �覡
		$SQL="select a.stud_id,a.stud_name,a.stud_birthday ,a.stud_sex, a.stud_person_id ,b.student_sn ,
		b.seme_class,b.seme_num,a.stud_study_cond ,c.sn,  c.academic_year,  c.kind_id,  c.special,
  		c.unemployed,  c.graduation,  c.income,  c.score_nearby,  c.score_service,  c.score_reward,
  		c.score_fault,  c.score_balance,  c.score_race,  c.score_physical,  c.score_exam,  c.update_sn
		from stud_base a,stud_seme b left join  chc_basic12 c on c.student_sn=b.student_sn  
		where a.student_sn=b.student_sn 	and b.seme_year_seme='$CID_1' and b.seme_class='$CID_2' 
		 order by b.seme_num ";
		
		$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		$All=$rs->GetArray();
		foreach ( $All as $ary ) {
			$SN=$ary['student_sn'];
			$obj_stu[$SN] = $ary;
			unset($ary);
		}
		//echo "<pre>";print_r($obj_stu);
		return $obj_stu;	
	}


	//�Ǧ^�ӥ͸Ӭ�Ӷ��q���Z//



##################  �Z�W�Ǵ���� ##########################
function select() {
	$YS=''; 
	$YS=curr_year().'�Ǧ~�ײ�'.curr_seme().'�Ǵ� ';
	($this->IS_JHORES==6) ? $grade=array(7=>"�@�~",8=>"�G�~",9=>"�T�~"):$grade=array(1=>"�@�~",2=>"�G�~",3=>"�T�~",4=>"�|�~",5=>"���~",6=>"���~");
	$SQL="select c_year,c_name,teacher_1 from  school_class where class_id='".$this->class_id."' and  enable='1'  ";
	//echo $SQL;
	$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	if ($rs->RecordCount()==0) return"�S���Z�Ÿ�ơI";
	$All=$rs->GetArray();
 	$ary=$All[0];
 	$str=$YS.$grade[$ary['c_year']].$ary['c_name']."�Z  �ɮv:".$ary['teacher_1'];
	return $str;
	}
	
function tol20($max,$a) {
	if ($a>$max) return $max;
	return $a;
}


}
