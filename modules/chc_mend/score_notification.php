<?php
//$Id: PHP_tmp.html 5310 2009-01-10 07:57:56Z hami $
include "config.php";
//�{��
sfs_check();


//�{���ϥΪ�Smarty�˥���
$template_file = dirname (__file__)."/templates/score_notification.htm";

//�إߪ���
$obj= new basic_chc($CONN,$smarty);
//��l��
$obj->init();
//�B�z�{��,���ɵ{�Ǥ���header���O,�G���{�ǩy��head���e
$obj->process();


//�q�X�����������Y
head("�ɦҮa���q����");

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
		
		//���e�X
		$this->act=$_REQUEST['act'];
        $this->note=$_REQUEST['note'];
		//��L�����s���Ѽ�
		$this->linkstr="Y={$this->Y}&G={$this->G}&S={$this->S}";
	}
	//�{��
	function process() {
		$this->all();
		$this->Edit_note();
		$this->ReEdit_note();
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
		$seme_class=$this->G."%";
		
		
		$query="select a.student_sn,a.stud_id,a.stud_name,a.stud_sex,b.seme_class,b.seme_num,b.seme_year_seme,c.student_sn
		from stud_base a,stud_seme b,chc_mend c
		where a.student_sn=c.student_sn
		and c.student_sn=b.student_sn
		and b.seme_year_seme='$seme_year_seme'
		and b.seme_class like '$seme_class'
		group by c.student_sn
		order by b.seme_class,b.seme_num,c.seme
		";
		$res=$this->CONN->Execute($query);
		
		//���X�Z�ŦW�ٰ}�C
		$class_base=class_base($seme_year_seme);
		
		
		while(!$res->EOF) {
			$this->stu_data[]=array(
			"stud_id"=>$res->fields[stud_id],
			"stud_name"=>$res->fields[stud_name],
			"stud_sex"=>$res->fields[stud_sex],
			"seme_class"=>$class_base{$res->fields[seme_class]},
			"seme_num"=>$res->fields[seme_num],
			"student_sn"=>$res->fields[student_sn]
			);
			$this->students_sn .= "&students_sn[]=".$res->fields[student_sn];
			$res->MoveNext();
		}
	}
	
	function Edit_note() {
		
    if ($this->act=="send") {
	if (!is_dir("../../data/school/chc_mend")){mkdir("../../data/school/chc_mend");}
	
	$fp=fopen("../../data/school/chc_mend/note.txt",'w');
	fwrite($fp,$this->note);
	fclose($fp);
      
	}		
		}
	function ReEdit_note() {
	 if (!is_dir("../../data/school/chc_mend")){mkdir("../../data/school/chc_mend");}	
	 if (!is_file("../../data/school/chc_mend/note.txt")) {
		 $newnote ="�]��103.7.7���оǦr��1030218804 ����ץ����u���ƿ�������Ǿǥͦ��Z���q�n�I�v�W�w,�C�j�ǲ߻�즳�|�j�ǲ߻��H�W���~�`��������(60)�H�W��,���o�����~�ҮѡC�������ǥͦ��ɱϾ��|�A�̤W�z�n�I��9�I�A�w��U�ǲ߻�즨�Z���F60���̿�z�ɦҡC���󥻦��ɦҡA�����p�U�G\r\n�@�B��I����Φa�I�G104�~3��2��(�@)~6��(��)��8�`�̧ǿ�z���~��(�y��)(�ƾ�)(�۵M)(���|)(����B����B��X)���ɦҡC�Щ�16:05���e�����ĤC�I��F���w�ЫǡA�@�������Y�i���,�̱�16:50�����C\r\n�G�B��I��H�G�w��W�Ǵ��U�Ǵ���줣�ή�̡A�����ɦҤ��C\r\n�T�B�ɦҦ��Z�p��G�ɦҤή�̥H 60���p�A�ɦҤ��ή�̡A�ӻ�즨�Z�N�ɦҦ��Z�έ즨�Z���u�n���C\r\n�|�B�u104�Ǧ~�׹��ưϧK�դJ�ǶW�B��Ƕ��ؿn����Ӫ�v�����žǲ߶��ءA��T���(���d�P��|�B����P�H��B��X����)�ĭp��l���Z�A���ĭp�ɦҫᦨ�Z�C\r\n���A�ɦҷ�饼��X�u�̡A���P�����|�A���ಧĳ�C\r\n���B�����ɦҸ��D�D�w�� 2�� 6��(��)�_���i�󥻮պ������G��A�д����Q�l�̨ƥ��ǳơA�H���ɦҤή�C\r\n�C�B���q������߶K���p��ï�A�^���Щ�2��24��(�G)�e�e�^�аȳB���U��\r\n�K�B�Q�l�̻ݸɦһ��p�U�G\r\n";
		$fp=fopen("../../data/school/chc_mend/note.txt",'w');
	    fwrite($fp,$newnote);
	    fclose($fp);
		}	           
	 $fp=fopen("../../data/school/chc_mend/note.txt",'r');
	 while(! feof($fp)) {
	 $this->oldnote .= fgets($fp); 	 
	 
	 }
	 $this->smarty->assign("oldnote",$this->oldnote);
	
		
	}	
		
}


