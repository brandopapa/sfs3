<?php
//$Id: PHP_tmp.html 5310 2009-01-10 07:57:56Z hami $
include "config.php";
//�{��
sfs_check();


//�{���ϥΪ�Smarty�˥���
$template_file = dirname (__file__)."/templates/score_identify.htm";

//�إߪ���
$obj= new basic_chc($CONN,$smarty);
//��l��
$obj->init();
//�B�z�{��,���ɵ{�Ǥ���header���O,�G���{�ǩy��head���e
$obj->process();


//�q�X�����������Y
head("�ɦҦ��Z�ҩ�");

//���SFS�s�����(���ϥνЮ��}����)
echo make_menu($school_menu_p,$obj->linkstr);

//��ܤ��e
$obj->display($template_file);
//�G������
foot();


//����class
class basic_chc{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $scope=array(1=>'�y��',2=>'�ƾ�',3=>'�۵M�P�ͬ����',4=>'���|',5=>'���d�P��|',6=>'���N�P�H��',7=>'��X����');

	//�غc�禡
	function basic_chc($CONN,$smarty){
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
	}
	//��l��
	function init() {
		//�L�o�r��ΨM�wGET��POST�ܼ�
		$Y=gVar('Y');$G=gVar('G');
		
		//�Ǧ~�׮榡 92_2,��102_1
		if (preg_match("/^[0-9]{2,3}_[1-2]$/",$Y)) $this->Y=$Y;
		
		//�~�Ů榡..1-6�p��,7-9�ꤤ
		if (preg_match("/^[1-9]$/",$G)) $this->G=$G;
		
		//$this->Y=strip_tags($_GET['Y']);
		//$this->G=strip_tags($_GET['G']);
		
		$this->sel_year=sel_year('Y',$this->Y);
		$this->sel_grade=sel_grade('G',$this->G,$_SERVER['PHP_SELF'].'?Y='.$this->Y.'&G=');
		$this->print_all_class_this_seme = (!empty($this->Y))?"1":"";
		$this->print_this_class_this_seme = (!empty($this->G))?"1":"";

		//��L�����s���Ѽ�
		$this->linkstr="Y={$this->Y}&G={$this->G}&S={$this->S}";
	}
	//�{��
	function process() {
		$this->all();
	}

	//���
	function display($tpl){
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
	}
	//�^�����
	function all(){
		if ($this->Y=='') return;
		if ($this->G=='') return;
		$ys=explode("_",$this->Y);
		$sel_year=$ys[0];
		$sel_seme=$ys[1];
		$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
		//$seme_class=$this->G."%";
		$query="select a.student_sn,b.stud_id,b.stud_name,b.stud_sex,c.seme_class,c.seme_num,c.seme_year_seme
		from (chc_mend a left join stud_base b on a.student_sn=b.student_sn)left join stud_seme c 
		on b.student_sn=c.student_sn and c.seme_year_seme='{$seme_year_seme}' 
		where a.seme='{$this->Y}' 
		group by a.student_sn
		order by c.seme_class,c.seme_num
		";
/*
		$query="select a.student_sn,a.stud_id,a.stud_name,a.stud_sex,b.seme_class,b.seme_num,b.seme_year_seme,c.student_sn
		from stud_base a,stud_seme b,chc_mend c
		where a.student_sn=c.student_sn
		and c.student_sn=b.student_sn
		and b.seme_year_seme='$seme_year_seme'
		and b.seme_class like '$seme_class'
		group by c.student_sn
		order by b.seme_class,b.seme_num,c.seme
		";
*/
		$res=$this->CONN->Execute($query);
		
		//���X�Z�ŦW�ٰ}�C
		$class_base=class_base($seme_year_seme);
		
		$sel_Y_G = substr($this->Y,0,3)-$this->G;//�����w�Ǵ����w�~�žǥͪ��Z�Ÿ��
		
		while(!$res->EOF) {
			$query2="select seme_year_seme,seme_class from stud_seme where student_sn ='{$res->fields[student_sn]}'";
			$rec2=$this->CONN->Execute($query2);
			list($seme_year_seme2,$seme_class2)=$rec2->FetchRow();
			//�����w�~�šA�q�Y�@�Ǧ~�M�Ӧ~�Ū����Y�ݥX
			if(substr($seme_year_seme2,0,3)-substr($seme_class2,0,1)==$sel_Y_G){
				
				$this->stu_data[]=array(
				"stud_id"=>$res->fields[stud_id],
				"stud_name"=>trim(str_replace("�@","",$res->fields[stud_name])),
				"stud_sex"=>$res->fields[stud_sex],
				"seme_class"=>$class_base{$res->fields[seme_class]},
				"seme_num"=>$res->fields[seme_num],
				"student_sn"=>$res->fields[student_sn]
				);
				$this->students_sn .= "&students_sn[]=".$res->fields[student_sn];
			}
			
			
			$res->MoveNext();
		}
	}








}


