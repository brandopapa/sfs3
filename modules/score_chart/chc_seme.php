<?php
//$Id: chc_seme.php 5310 2009-01-10 07:57:56Z hami $
include "chc_config.php";
//�{��
sfs_check();

//�ޤJ��������(�ǰȨt�ΥΪk)
include_once "../../include/sfs_oo_dropmenu.php";
//�{���ϥΪ�Smarty�˥���
$template_file = dirname (__file__)."/templates/chc_seme.htm";
//�إߪ���
$obj= new chc_seme($CONN,$smarty);
//��l��
$obj->init();
//�B�z�{��,���ɵ{�Ǥ���header���O,�G���{�ǩy��head("score_semester_91_2�Ҳ�");���e
$obj->process();

//�q�X�����������Y
head("��Ҧ��Z�ˬd");

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

	//�غc�禡
	function chc_seme($CONN,$smarty){
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
	}
	//��l��
	function init() {}
	//�{��
	function process() {
		$this->all();
	}
	//���
	function display($tpl){
		$ob=new drop($this->CONN);
		$this->select=&$ob->select();
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
	}
	//�^�����
	function all(){
		if ($_GET[class_id]=='') return;
		$this->class_id=$_GET[class_id];
		$this->stu=$this->get_stu();
		$this->subj=$this->get_subj("seme");
		
//		echo "<pre>";//print_r($this->subj);
//		print_r($this->stu);
		$this->sco=$this->get_sco();
//		print_r($this->sco);		
	}
/* ���ǥͰ}�C,����stud_base��Pstud_seme��*/
	function get_stu(){
		$CID=split("_",$this->class_id);//093_1_01_01
		$year=$CID[0];
		$seme=$CID[1];
		$grade=$CID[2];//�~��
		$class=$CID[3];//�Z��
		$CID_1=$year.$seme;
		$CID_2=sprintf("%03d",$grade.$class);
		$SQL="select 	a.stud_id,a.student_sn,a.stud_name,a.stud_sex,b.seme_year_seme,b.seme_class,b.seme_num,a.stud_study_cond  from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$CID_1' and b.seme_class='$CID_2' $add_sql order by b.seme_num ";
		$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		$obj_stu=array();
		while ($rs and $ro=$rs->FetchNextObject(false)) {
			$obj_stu[$ro->student_sn] = get_object_vars($ro);
		}
		return $obj_stu;	
	}

/*����ذ}�C�G��score_subject��������W��,��score_ss�����ӯZ���  score_ss��rate��ܥ[�v  print����  need_exam�p��  enable�ϥ�  */
function get_subj($type='') {
	switch ($type) {
		case 'all':
		$add_sql=" ";break;
		case 'seme':
		$add_sql=" and need_exam='1' and enable='1' and  rate > 0  ";break;//�����Z��
		case 'stage':
		$add_sql=" and need_exam='1'  and print='1' and enable='1' and  rate > 0  ";break;//���q��,����
		case 'no_test':
		$add_sql=" and need_exam='1'  and print!='1' and enable='1'  and  rate > 0  ";break; //���άq�Ҫ�
		default:
		$add_sql=" and enable='1'  and  rate > 0  ";break;
	} 
	$CID=split("_",$this->class_id);//093_1_01_01
	$year=$CID[0];//094_2_01_04
	$seme=$CID[1];
	$grade=$CID[2];
	$class=$CID[3];
	$CID_1=sprintf("%03d",$year)."_".$seme."_".$grade."_".$class;

	$SQL="select * from score_ss where class_id='$CID_1' $add_sql order by print desc,sort,sub_sort ";
	$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);

	if ($rs->RecordCount()==0){
		$SQL="select * from score_ss where class_id='' and year='".intval($year)."' and semester='".intval($seme)."' and  class_year='".intval($grade)."' $add_sql order by print desc,sort,sub_sort ";
		$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		$All_ss=&$rs->GetArray();
	}
	else{$All_ss=&$rs->GetArray();}

		//����ؤ���W��
		$SQL="select subject_id,subject_name from score_subject ";
		$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		while ($rs and $ro=$rs->FetchNextObject(false)) {
			$subj_name[$ro->subject_id] = $ro->subject_name;
		}	

		//���Ҹզ��Ƴ]�w�Ӧ� score_setup ��
		$SQL="SELECT * FROM `score_setup` where  year='".($year+0)."' and  semester='".($seme+0)."' and class_year='".($grade+0)."' ";
		$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL."�i��O���Z�|���]�w");//echo $SQL;
		$score_setup=$rs->GetRowAssoc(FALSE);
//		echo "<pre>";print_r($score_setup);
//���Z����(�ثe����)
		$this->rule=$this->get_rule($score_setup[rule]);
		//��z��ذ}�C
		$obj_SS=array();
		for($i=0;$i<count($All_ss);$i++){
			$key=$All_ss[$i][ss_id];//����
			// $obj_SS[$key]=$All_ss[$i];//�����}�C,�Ȥ���
			$obj_SS[$key][rate]=$All_ss[$i][rate];//�[�v
			if ($All_ss[$i]["print"]=='1') {$obj_SS[$key][mon_test]=$score_setup[performance_test_times];}
			else{$obj_SS[$key][mon_test]='0'; }
//			$obj_SS[$key][mon_test]=$All_ss[$i]["print"];//�O�_����
			$obj_SS[$key][sc]=$subj_name[$All_ss[$i][scope_id]];//���W��
			$obj_SS[$key][sb]=$subj_name[$All_ss[$i][subject_id]];//��ئW��
			($obj_SS[$key][sb]=='') ? $obj_SS[$key][sb]=$obj_SS[$key][sc]:"";
		}
	return $obj_SS;
	}

	function get_rule($rule) {
		$rule=str_replace(" ","",$rule);
		$rules = explode("\n",$rule);
		for ($i=0; $i<count($rules); $i++){
			$ary[$i]=explode("_", $rules[$i]);}
		return 	$ary;
	
	}
	//���Ҧ����Z
	function get_sco(){
		$ss=join(",",array_keys($this->subj));
		$stu=join(",",array_keys($this->stu));
		$YSGC=split("_",$this->class_id);
		$tb="score_semester_".($YSGC[0]+0)."_".($YSGC[1]+0);
		$SQL="select score_id,class_id,student_sn,ss_id,score,test_name,test_kind,test_sort from `$tb` where  student_sn in ($stu) and  ss_id in ($ss) ";
		$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL."�i��O�ҵ{�εL�ǥ͸��");//echo $SQL;
		$All_sco=&$rs->GetArray();
//		print_r($All_sco);
		foreach ($All_sco as $sco){
			$sn=$sco[student_sn];
			$ss_id=$sco[ss_id];
			$test_sort=$sco[test_sort];
			if ($sco[test_kind]=='�w�����q') $kind='mon';
			if ($sco[test_kind]=='���ɦ��Z') $kind='nor';
			if ($sco[test_kind]=='���Ǵ�') $kind='all';
			$Vsco[$sn][$ss_id][$test_sort][$kind]=$sco[score];
			}
		$SQL="select student_sn,ss_score  from stud_seme_score_nor where  student_sn in ($stu) and   seme_year_seme='".sprintf("%03d",$YSGC[0]).$YSGC[1]."' ";
		$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL."�i��O�ҵ{�εL�ǥ͸��");//echo $SQL;
		$All_Nor=&$rs->GetArray();
		foreach ($All_Nor as $sco){
			$sn=$sco[student_sn];
			$Vsco[$sn][nor]=$sco[ss_score];
			}
		return $Vsco;
//		print_r($Vsco);
	}
	//�Ǧ^�ӥ͸Ӭ�Ӷ��q���Z//
	function sco($sn,$ss,$test_sort,$kind){
		$sco=ceil($this->sco[$sn][$ss][$test_sort][$kind]);
		if ($sco < 60) { return "<font color=#FF0000> $sco</font>";}
		else{	return $sco;}
	}
	//�Ǧ^�ӥͤ�`���Z//
	function sco_nor($sn){
		$sco=ceil($this->sco[$sn][nor]);
		if ($sco < 60) { return "<font color=#FF0000> $sco</font>";}
		else{	return $sco;}
	}




}
?>