<?php
//$Id: chc_seme.php 5310 2009-01-10 07:57:56Z hami $
// ini_set('display_errors', '1');
include "config.php";
//�{��
sfs_check();
chk_login('�аȳB');

//�ޤJ��������(�ǰȨt�ΥΪk)
// include_once "../../include/sfs_oo_dropmenu.php";
//�{���ϥΪ�Smarty�˥���
$template_file = dirname (__file__)."/templates/stud_listA_edit.htm";

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
	//�������O
	var $Okind=array('0'=>'�@���','1'=>'����','2'=>'���~�H���l�k','3'=>'�X�å�','4'=>'�^�깴��','5'=>'��D��','6'=>'�h��x�H','7'=>'�ҥ~�u�q��ǧ޳N�H�~�l�k');
	var $Okind2=array('0'=>'0.�@���','1'=>'1.����','2'=>'2.���~�H���l�k','3'=>'3.�X�å�','4'=>'4.�^�깴��','5'=>'5.��D��','6'=>'6.�h��x�H','7'=>'7.�ҥ~�u�q��ǧ޳N�H�~�l�k');
	//��ê���O
	var $xOspecial=array('0'=>'�@���','1'=>'�����ê','2'=>'��ı��ê','3'=>'ťı��ê','4'=>'�y����ê','5'=>'�����ê','6'=>'����f�z','7'=>'�ұ����欰��ê',	'8'=>'�ǲ߻�ê','9'=>'�h����ê','A'=>'�۳��g','B'=>'��L��ê'	);
	var $xOspecial2=array('0'=>'0.�@���','1'=>'1.�����ê','2'=>'2.��ı��ê','3'=>'3.ťı��ê','4'=>'4.�y����ê','5'=>'5.�����ê','6'=>'6.����f�z','7'=>'7.�ұ����欰��ê','8'=>'8.�ǲ߻�ê','9'=>'9.�h����ê','A'=>'A.�۳��g','B'=>'B.��L��ê'	);
	//��ê���O -- fix
	var $Ospecial=array('0'=>'�@���','1'=>'�����ê','2'=>'��ı��ê','3'=>'ťı��ê',
	'4'=>'�y����ê','5'=>'�����ê','6'=>'���ʳ·�','7'=>'����f�z','8'=>'�����欰��ê',
	'9'=>'�ǲ߻�ê','A'=>'�h����ê','B'=>'�۳��g','C'=>'�o�i��w','D'=>'��L��ê');
	var $Ospecial2=array('0'=>'0.�@���','1'=>'1.�����ê','2'=>'2.��ı��ê','3'=>'3.ťı��ê',
	'4'=>'4.�y����ê','5'=>'5.�����ê','6'=>'6.���ʳ·�','7'=>'7.����f�z','8'=>'8.�����欰��ê',
	'9'=>'9.�ǲ߻�ê','A'=>'A.�h����ê','B'=>'B.�۳��g','C'=>'C.�o�i��w','D'=>'D.��L��ê');
	
	var $YESNO=array('0'=>'�_','1'=>'�O');
	var $YESNO2=array('0'=>'0.�_','1'=>'1.�O');
	var $Ograde=array('0'=>'�w�~','1'=>'���~');
	var $Ograde2=array('0'=>'0.�w�~','1'=>'1.���~');
	var $Oincome=array('0'=>'�L','1'=>'���C���J��','2'=>'�C���J��');
	var $Oincome2=array('0'=>'0.�L','1'=>'1.���C���J','2'=>'2.�C���J');
	var $income3=array('0'=>'0','1'=>'1���C','2'=>'2�C��');
	var $balance_s=array('6'=>'6(���Ǵ�)','4'=>'4(�|�Ǵ�)','2'=>'2(�T�Ǵ�)','0'=>'0');
	//�غc�禡
	function chc_seme($CONN,$smarty){
		global $IS_JHORES;
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
		$this->IS_JHORES=$IS_JHORES;
		$YS=''; 
		/* -- �����L�Ǵ���J
		if (isset($_POST['year_seme'])) $YS=$_POST['year_seme'];
		if ($YS=='' && isset($_GET['year_seme'])) $YS=$_GET['year_seme'];
		if ($YS=='') $YS=curr_year()."_".curr_seme();
		*/
		$YS=curr_year()."_".curr_seme();
		$this->year_seme=$YS;
		$aa=split("_",$this->year_seme);
		$this->year=$aa[0];
		$this->seme=$aa[1];
	}
	//��l��
	function init() {	}
	//�{��
	function process() {
		if(isset($_POST['form_act']) && $_POST['form_act']=='updateAll') $this->update();
		if(isset($_POST['form_act']) && $_POST['form_act']=='clearAll') $this->clearSco();

		$this->all();
		//echo $this->year;
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
		if ($_GET[class_id]=='') return;
		$this->class_id=$_GET['class_id'];
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
		
		$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		$obj_stu=array();
		while ($rs and $ro=$rs->FetchNextObject(false)) {
			$obj_stu[$ro->student_sn] = get_object_vars($ro);
		}
		return $obj_stu;	
	}

	//��s���
	function clearSco(){
		$session_tea_sn=$_SESSION['session_tea_sn'];
		// echo'<pre>';print_r($_POST);die();

		$academic_year=$this->year;
		$class_id=strip_tags($_POST['class_id']);
		foreach($_POST['kind_id'] as $K=>$Val){
			$K=(int)$K;	$kind_id=(int)$Val;
			$special=(int)$_POST['special'][$K];
			$unemployed	=(int)$_POST['unemployed'][$K];
			$graduation	=(int)$_POST['graduation'][$K];
			$income		=(int)$_POST['income'][$K];
			$score_nearby	=(int)$_POST['score_nearby'][$K];
			$score_balance	=(int)$_POST['score_balance'][$K];
			$SQL="update chc_basic12 set `kind_id`=NULL ,	`special`=NULL ,
			`unemployed`=NULL ,`graduation`='1' ,`income`=NULL ,
		`score_nearby`='7' ,`score_balance`=NULL,
		 update_sn = '{$session_tea_sn}'  where  `academic_year`='{$academic_year}' and `student_sn`='{$K}' ";

		$rs=$this->CONN->Execute($SQL) or die($SQL);

			} 
		

		$URL=$_SERVER['SCRIPT_NAME']."?year_seme=".$this->year_seme."&class_id=".$class_id;
		Header("Location:$URL");
 
	}
	//�Ǧ^�ӥ͸Ӭ�Ӷ��q���Z//

	//��s���
	function update(){
		$session_tea_sn=$_SESSION['session_tea_sn'];
		// echo'<pre>';print_r($_POST);die();

		$academic_year=$this->year;
		$class_id=strip_tags($_POST['class_id']);
		foreach($_POST['kind_id'] as $K=>$Val){
			$K=(int)$K;	$kind_id=(int)$Val;
			$special=(int)$_POST['special'][$K];
			$unemployed	=(int)$_POST['unemployed'][$K];
			$graduation	=(int)$_POST['graduation'][$K];
			$income		=(int)$_POST['income'][$K];
			$score_nearby	=(int)$_POST['score_nearby'][$K];
			$score_balance	=(int)$_POST['score_balance'][$K];
			$SQL="update chc_basic12 set `kind_id`='{$kind_id}' ,	`special`='{$special}' ,
			`unemployed`='{$unemployed}' ,`graduation`='{$graduation}' ,`income`='{$income}' ,
		`score_nearby`='{$score_nearby}' ,`score_balance`='{$score_balance}' ,
		 update_sn = '{$session_tea_sn}'  where  `academic_year`='{$academic_year}' and `student_sn`='{$K}' ";

		$rs=$this->CONN->Execute($SQL) or die($SQL);

			} 
		

		$URL=$_SERVER['SCRIPT_NAME']."?year_seme=".$this->year_seme."&class_id=".$class_id;
		Header("Location:$URL");
 
	}
	//�Ǧ^�ӥ͸Ӭ�Ӷ��q���Z//



##################  �Ǵ��U�Ԧ����禡  ##########################
function select() {
	$SQL = "select * from school_day where  day<=now() and day_kind='start' order by day desc ";
	$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	while(!$rs->EOF){
		$ro = $rs->FetchNextObject(false);
		// ��i$ro=$rs->FetchNextObj()�A���O�ȥΩ�s������adodb�A�ثe��SFS3���A��
		$year_seme=$ro->year."_".$ro->seme;
		$obj_stu[$year_seme]=$ro->year."�Ǧ~�ײ�".$ro->seme."�Ǵ�";
	}
	$str="<select name='".$this->YS."' onChange=\"location.href='".$_SERVER[SCRIPT_NAME]."?".$this->YS."='+this.options[this.selectedIndex].value;\" disabled>\n";
		//$str.="<option value=''>-�����-</option>\n";
	foreach($obj_stu as $key=>$val) {
		($key==$this->year_seme) ? $bb=' selected':$bb='';
		$str.= "<option value='$key' $bb>$val</option>\n";
		}
	$str.="</select>";
	$str.=$this->grade();
	return $str;
}
##################�}�C�C�ܨ禡2##########################
function grade() {
	//�W��,�_�l��,������,��ܭ�
	$url="?".$this->YS."=". $this->year_seme."&".$this->Sclass."=";
	//($this->IS_JHORES==6) ? $grade=array(7=>"�@�~",8=>"�G�~",9=>"�T�~"):$grade=array(1=>"�@�~",2=>"�G�~",3=>"�T�~",4=>"�|�~",5=>"���~",6=>"���~");
	($this->IS_JHORES==6) ? $grade=array(9=>"�T�~"):$grade=array(6=>"���~");
	$gradeA=($this->IS_JHORES==6) ? 9:6;
	//�u�ﰪ�~��6/9
	$SQL="select class_id,c_year,c_name,teacher_1 from  school_class 
	where year='".$this->year."' and semester='".$this->seme."' and enable='1' 
	and c_year='{$gradeA}'  order by class_id  ";
	//echo $SQL;
	$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	if ($rs->RecordCount()==0) return"�|���]�w�Z�Ÿ�ơI";
	$All=$rs->GetArray();
	$str="<select name='".$this->Sclass."' onChange=\"location.href='".$url."'+this.options[this.selectedIndex].value;\">\n";
	$str.= "<option value=''>-�����-</option>\n";
	foreach($All as $ary) {
		($ary[class_id]==$_GET[$this->Sclass]) ? $bb=' selected':$bb='';
		$str.= "<option value='".$ary[class_id]."' $bb>".$grade[$ary[c_year]].$ary[c_name]."�Z (".$ary[teacher_1].")</option>\n";
		}
	$str.="</select>";
	return $str;
	}
	
	
function tol20($max,$a) {
	if ($a>$max) return $max;
	return $a;
}


}
