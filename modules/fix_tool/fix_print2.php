<?php
//$Id:  $
include "config.php";
//�{��
sfs_check();

//�ޤJ��������(�ǰȨt�ΥΪk)
include_once "../../include/chi_page2.php";
//�{���ϥΪ�Smarty�˥���
$template_file = dirname (__file__)."/templates/fix_print2.htm";

//�إߪ���
$obj= new score_ss($CONN,$smarty);
//��l��
$obj->init();
//�B�z�{��,���ɵ{�Ǥ���header���O,�G���{�ǩy��head("score_ss�Ҳ�");���e
$obj->process();

//�q�X�����������Y
head("�ҵ{���R");

//���SFS�s�����(���ϥνЮ��}����)
echo make_menu($school_menu_p);

//��ܤ��e
$obj->display($template_file);
//�G������
foot();


//����class
class score_ss{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $size=10;//�C������
	var $page;//�ثe����
	var $tol;//����`����
   var $IS_JHORES;
	var $year;
   var $seme;
   var $YS='year_seme';//�U�Ԧ����Ǵ����ڼƦW��
   var $year_seme;//�U�Ԧ����Z�Ū��ڼƭ�
   var $Sclass='class_id';//�U�Ԧ����Z�Ū��ڼƦW��
   var $grade_name='Grade';//�U�Ԧ����~�Ū��ڼƦW��
   var $Grade;

	//�غc�禡
	function score_ss($CONN,$smarty){
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
      global $IS_JHORES;
      $this->IS_JHORES=$IS_JHORES;
      ($_GET[$this->YS]=='') ? $this->year_seme=curr_year()."_".curr_seme():$this->year_seme=$_GET[$this->YS];
      if ($_GET[$this->grade_name]!='') $this->Grade=(int)$_GET[$this->grade_name];
      $aa=split("_",$this->year_seme);
      $this->year=$aa[0];
      $this->seme=$aa[1];
	}
	//��l��
	function init() {$this->page=($_GET[page]=='') ? 0:$_GET[page];}
	//�{��
	function process() {
		//http://localhost/sfs3/modules/fix_tool/fix_print2.php?year_seme=98_2&Grade=7
		$this->all();
	}
	//���
	function display($tpl){
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
		//echo "<pre>";print_r($this->Course);
	}
	//�^�����
	function all(){
		$SQL="select year,semester,count(*) as tol from score_ss 
		group by year,semester ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$this->aTol=$rs->GetArray();

		if ($this->year=='') return ;
		if ($this->seme=='') return ;
		if ($this->Grade=='') return ;
		//�Ҧ��ҵ{�]�w
		$SQL="select * from score_ss where year='{$this->year}' 	and  semester='{$this->seme}' and class_year='{$this->Grade}'  ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$arr=$rs->GetArray();
		$this->all=$arr;//return $arr;
		$this->tol=count($arr);
		/*���Z��*/
    	$SQL="select class_id,c_year,c_name,c_sort ,teacher_1 from  school_class where year='{$this->year}'
    	 and semester='{$this->seme}' and c_year='{$this->Grade}' and enable=1  order by c_sort, class_id  ";
	    $rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	    if ($rs->RecordCount()==0) return"�|���]�w�Z�Ÿ�ơI";
	    $this->aGrade=$rs->GetArray();
		/*���ҵ{����W��*/
  		$SQL="select subject_id,subject_name from score_subject ";
		$rs=$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		if ($rs->RecordCount()==0) return "�|���]�w�����ظ�ơI";
		$obj=$rs->GetArray();
		foreach($obj as $ary){
			$id=$ary[subject_id];
			$this->Subj[$id]=$ary[subject_name];
		}
		$this->ScoTol();
		$this->Course=$this->Course();
		//echo "<pre>";print_r($this->Course);
		$this->SsidToName=$this->SsidToName();
	}
	function SsidToName(){
		foreach ($this->all as $ary){
			$id=$ary[ss_id];
			$scope=$ary[scope_id];
			$subject=$ary[subject_id];
			$AA[$id]=$this->Subj[$scope].':'.$this->Subj[$subject];
		}	
	
	return $AA;
	
	}





	//�s�W
	function class_ss($classid=''){
		if ($this->all=='' || $this->seme=='' || $this->Grade=='') return ;
		$AA='';
		foreach ($this->all as $ary){
		 	$ss_id=$ary[ss_id];
			if ($ary[class_id]==$classid && $classid!='') $AA[$ss_id]=$ary;
			if ($classid=='' && $ary[class_id]=='') $AA[$ss_id]=$ary;
		}
		return $AA;
	}

	//���Ҧ����Z�έp by ss_id
	function ScoTol(){
		
		$TB='score_semester_'.$this->year.'_'.$this->seme;
  		$SQL="SELECT class_id ,ss_id,count(*)  as  stol  FROM  {$TB}  group  by class_id,ss_id ";
		$rs=$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		if ($rs->RecordCount()==0) return "�|���]�w�����ظ�ơI";
		$obj=$rs->GetArray();
		foreach ($obj as $ary){
			$cla=$ary[class_id];
			$ssid=$ary[ss_id];		
			$this->ScoTol[$cla][$ssid]=$ary[stol];
			$this->ScoTol2[$ssid]=$this->ScoTol2[$ssid]+$ary[stol];
		}
	
	
	}
function gScoTol($cla,$id){
	if ($cla=='') return $this->ScoTol2[$id];
	return $this->ScoTol[$cla][$id];
}

function Course(){
 		$SQL="SELECT class_id ,ss_id,count(*)  as  stol  FROM  score_course 	where year ='{$this->year}' and  semester='{$this->seme}' 	and class_year='{$this->Grade}' 	 group  by class_id,ss_id ";
		$rs=$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		$all=$rs->GetArray();
		foreach ($all as $ary){
			$cla=$ary[class_id];
			$ss_id=$ary[ss_id];
			$AA[$cla][$ss_id]=$ary[stol];
		}
		return  $AA;
}
  
function gCourse($cla){
//print_r($this->Course[$cla]);
	return $this->Course[$cla];
}

##################  �Ǵ��U�Ԧ����禡  ##########################
function select($show_class=1) {
    $SQL = "select * from school_day where  day<=now() and day_kind='start' order by day desc ";
    $rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
    while(!$rs->EOF){
        $ro = $rs->FetchNextObject(false);
        // ��i$ro=$rs->FetchNextObj()�A���O�ȥΩ�s������adodb�A�ثe��SFS3���A��
        $year_seme=$ro->year."_".$ro->seme;
        $obj_stu[$year_seme]=$ro->year."�Ǧ~�ײ�".$ro->seme."�Ǵ�";
    }
    $str="<select name='".$this->YS."' onChange=\"location.href='".$_SERVER[PHP_SELF]."?".$this->YS."='+this.options[this.selectedIndex].value;\">\n";
        //$str.="<option value=''>-�����-</option>\n";
    foreach($obj_stu as $key=>$val) {
        ($key==$this->year_seme) ? $bb=' selected':$bb='';
        $str.= "<option value='$key' $bb>$val</option>\n";
        }
    $str.="</select>";
    ($show_class==1) ? $str.=$this->grade():$str.=$this->only_grade();
    return $str;
}
##################�}�C�C�ܨ禡2##########################
function grade() {
    //�W��,�_�l��,������,��ܭ�
    $url="?".$this->YS."=". $this->year_seme."&".$this->Sclass."=";
    ($this->IS_JHORES==6) ? $grade=array(7=>"�@�~",8=>"�G�~",9=>"�T�~"):$grade=array(1=>"�@�~",2=>"�G�~",3=>"�T�~",4=>"�|�~",5=>"���~",6=>"���~");

    $SQL="select class_id,c_year,c_name,teacher_1 from  school_class where year='".$this->year."' and semester='".$this->seme."' and enable=1  order by class_id  ";
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
    
##################�}�C�C�ܨ禡2##########################
function only_grade() {
    //�W��,�_�l��,������,��ܭ�
    $url="?".$this->YS."=". $this->year_seme."&".$this->grade_name."=";
    ($this->IS_JHORES==6) ? $grade=array(7=>"�@�~",8=>"�G�~",9=>"�T�~"):$grade=array(1=>"�@�~",2=>"�G�~",3=>"�T�~",4=>"�|�~",5=>"���~",6=>"���~");

    $str="<select name='".$this->grade_name."' onChange=\"location.href='".$url."'+this.options[this.selectedIndex].value;\">\n";
    $str.= "<option value=''>-�����-</option>\n";
    foreach($grade as $Key=>$ary) {
        ($Key==$_GET[$this->grade_name]) ? $bb=' selected':$bb='';
        $str.= "<option value='".$Key."' $bb>".$grade[$Key]."��</option>\n";
        }
    $str.="</select>";
    return $str;
    }

} 