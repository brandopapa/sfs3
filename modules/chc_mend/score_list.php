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
		//�W�[�P�_�O�_�����~�A�y�ǥ͡A�p����ǥͤ]�|��{
		//���Ǧ~��-��ܾǦ~+��ܦ~��=�ثe�~�šA�~�Q����C
		//���O�p���@�ӤS�|���Ͳ��~�͵L�k�Q������t�@�Ӱ��D
		$curr_y=curr_year();
		$sel_y=substr($this->Y,0,-2);
		$sel_g=$this->G;
		$op=$curr_y-$sel_y+$sel_g."%";
		
		$query="select a.stud_id,a.stud_name,a.stud_sex,
		b.seme_class,b.seme_num,b.seme_year_seme,c.* 
		from stud_base a,chc_mend c left join stud_seme b 
		on (c.student_sn=b.student_sn  
		and b.seme_year_seme='$seme_year_seme'  
		and b.seme_class like '$seme_class' )
		where a.student_sn=c.student_sn 
		and c.seme='$this->Y' 
		and a.stud_study_cond=0
		and a.curr_class_num LIKE '$op' 
		$ADD_SQL
		order by b.seme_class,b.seme_num ";
		//echo $query;
		$res=$this->CONN->Execute($query);
		$ALL=$res->GetArray();
		if ($Scope=="8") {
			$New=array();
			foreach ($ALL as $ary){
				$sn=$ary['student_sn'];
				$ss=$ary['scope'];
				$New['A'][$sn]=$ary;
				$New['B'][$sn][$ss]=$ary;
				//CSV ��$all_student_sn
				$all_student_sn[]=$sn;
				//CSV ����			
				}
			$this->stu_data=$New;			
		//CSV �}�l            
        $all_student_sn_unique=array_unique($all_student_sn);
		if ($_REQUEST['op']=="CSV") {
		$student_sex = array(1=>"�k",2=>"�k");
	    $this->stu_data=$New;	 
		//$CSV_data ��CSV��X�ɮ�
		$CSV_data = "�Ǹ�,�Z��,�y��,�m�W,�ʧO,�y���l,�y��ɦ�,�y��ĭp,�ƾǭ�l,�ƾǸɦ�,�ƾǱĭp,�۵M��l,�۵M�ɦ�,�۵M�ĭp,���|��l,���|�ɦ�,���|�ĭp,�����l,����ɦ�,����ĭp,���N��l,���N�ɦ�,���N�ĭp,��X��l,��X�ɦ�,��X�ĭp\r\n";
		foreach ($all_student_sn_unique as $value_sn) {	
		      $CSV_data .="{$this->stu_data['A'][$value_sn]['stud_id']},{$this->stu_data['A'][$value_sn]['seme_class']},{$this->stu_data['A'][$value_sn]['seme_num']},{$this->stu_data['A'][$value_sn]['stud_name']},{$student_sex[$this->stu_data['A'][$value_sn]['stud_sex']]},{$this->stu_data['B'][$value_sn][1][score_src]},{$this->stu_data['B'][$value_sn][1][score_test]},{$this->stu_data['B'][$value_sn][1][score_end]},{$this->stu_data['B'][$value_sn][2][score_src]},{$this->stu_data['B'][$value_sn][2][score_test]},{$this->stu_data['B'][$value_sn][2][score_end]},{$this->stu_data['B'][$value_sn][3][score_src]},{$this->stu_data['B'][$value_sn][3][score_test]},{$this->stu_data['B'][$value_sn][3][score_end]},{$this->stu_data['B'][$value_sn][4][score_src]},{$this->stu_data['B'][$value_sn][4][score_test]},{$this->stu_data['B'][$value_sn][4][score_end]},{$this->stu_data['B'][$value_sn][5][score_src]},{$this->stu_data['B'][$value_sn][5][score_test]},{$this->stu_data['B'][$value_sn][5][score_end]},{$this->stu_data['B'][$value_sn][6][score_src]},{$this->stu_data['B'][$value_sn][6][score_test]},{$this->stu_data['B'][$value_sn][6][score_end]},{$this->stu_data['B'][$value_sn][7][score_src]},{$this->stu_data['B'][$value_sn][7][score_test]},{$this->stu_data['B'][$value_sn][7][score_end]}\r\n";  
		}	      	
		$CSV_filename = $ys[0]."�Ǧ~".$ys[1]."�Ǵ�".$this->G."�~�ŸɦҦ��Z�C��.csv";
		header("Content-disposition: attachment;filename=$CSV_filename");
		header("Content-type: text/x-csv ; Charset=Big5");
		header("Progma: no-cache");
		header("Expires: 0");
		echo $CSV_data;
		die();
	     }
	     //CSV ����
			
			}
		else{
			$this->stu_data=$ALL;
			}
		



		
	}

	




}


