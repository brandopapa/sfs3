<?php
//$Id: PHP_tmp.html 5310 2009-01-10 07:57:56Z hami $
include "config.php";
//�{��
sfs_check();


//�{���ϥΪ�Smarty�˥���


//�إߪ���
$obj= new basic_chc($CONN,$smarty);
//��l��
//$obj->init();
//�B�z�{��,���ɵ{�Ǥ���header���O,�G���{�ǩy��head("12basic_chc�Ҳ�");���e
$obj->process();


//�q�X�����������Y
head("�ɦҦ��Z�޲z");

//���SFS�s�����(���ϥνЮ��}����)
echo make_menu($school_menu_p,$obj->linkstr);//
// print_menu($school_menu_p);//,$obj->linkstr

$obj->display();
//�G������
foot();


//����class
class basic_chc{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $size=10;//�C������
	var $page;//�ثe����
	var $tol;//����`����
	var $scope=array(1=>'�y��',2=>'�ƾ�',3=>'�۵M�P�ͬ����',4=>'���|',
	5=>'���d�P��|',6=>'���N�P�H��',7=>'��X����',8=>'�������');
	var $scope2=array(1=>'�y��',2=>'�ƾ�',3=>'�۵M�P�ͬ����',4=>'���|',
	5=>'���d�P��|',6=>'���N�P�H��',7=>'��X����');
	var $linkstr;

	//�غc�禡
	function basic_chc($CONN,$smarty){
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
	}
	//��l��
	function init() {
		//�L�o�r��ΨM�wGET��POST�ܼ�
		$Y=gVar('Y');$G=gVar('G');$S=gVar('S');
		
		//�Ǧ~�׮榡 92_2,��102_1
		if (preg_match("/^[0-9]{2,3}_[1-2]$/",$Y)) $this->Y=$Y;
		
		//�~�Ů榡..1-6�p��,7-9�ꤤ
		if (preg_match("/^[1-9]$/",$G)) $this->G=$G;
		
		//���N�X1-7,8��ܥ������
		if (preg_match("/^[1-8]$/",$S)) $this->S=$S;
		
		//�Ǧ~�׿��
		$this->sel_year=sel_year('Y',$this->Y);
		//�~�ſ��
		$this->sel_grade=sel_grade('G',$this->G,$_SERVER['PHP_SELF'].'?Y='.$this->Y.'&G=');
		//����
		//$this->page=($_GET[page]=='') ? 0:$_GET[page];
		//��L�����s���Ѽ�
		$this->linkstr="Y={$this->Y}&G={$this->G}&S={$this->S}";
	
	}
		//�{��
	function process() {
		//if ($_GET['act']=='update') $this->updateDate();
		$this->init();
		$this->all();
	}

	//���
	function display(){
		$temp1 = dirname (__file__)."/templates/score_list.htm";
		$temp2 = dirname (__file__)."/templates/score_list_all.htm";
		($this->S == "8") ? $tpl=$temp2 : $tpl = $temp1;
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
	}
	//�^�����
	function all(){
		if ($this->Y=='') return;
		if ($this->G=='') return;
		if ($this->S=='') return;
		$ys=explode("_",$this->Y);
		$sel_year=$ys[0];
		$sel_seme=$ys[1];
		$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
		$seme_class=$this->G."%";
		$Scope=$this->S;
		$SQL2="and c.scope='$Scope'";
		($Scope!="8") ? $ADD_SQL=$SQL2:$ADD_SQL='';
		/*$query="select a.stud_id,a.stud_name,a.stud_sex,b.seme_class,b.seme_num,b.seme_year_seme,c.*
		from stud_base a,stud_seme b,chc_mend c
		where a.student_sn=c.student_sn
		and c.student_sn=b.student_sn
		and c.seme='$this->Y'
		and b.seme_year_seme='$seme_year_seme'
		and b.seme_class like '$seme_class'
		$ADD_SQL
		order by b.seme_class,b.seme_num
		";
		*/
		$query="select a.stud_id,a.stud_name,a.stud_sex,
		b.seme_class,b.seme_num,b.seme_year_seme,c.* 
		from stud_base a,chc_mend c left join stud_seme b 
		on (c.student_sn=b.student_sn  
		and b.seme_year_seme='$seme_year_seme'  
		and b.seme_class like '$seme_class' )
		where a.student_sn=c.student_sn 
		and c.seme='$this->Y' 
		$ADD_SQL
		order by b.seme_class,b.seme_num ";
		$res=$this->CONN->Execute($query);
		$ALL=$res->GetArray();
		if ($Scope=="8") {
			$New=array();
			foreach ($ALL as $ary){
				$sn=$ary['student_sn'];
				$ss=$ary['scope'];
				$New['A'][$sn]=$ary;
				$New['B'][$sn][$ss]=$ary;			
				}
			$this->stu_data=$New;
			//echo "<pre>";print_r($New);
			}
		else{
			$this->stu_data=$ALL;
			}
		



		
	}

	




}


