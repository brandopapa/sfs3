<?php
//$Id:  $
include "config.php";
//�{��
sfs_check();

//�ޤJ��������(�ǰȨt�ΥΪk)
// include_once "../../include/chi_page2.php";
//�{���ϥΪ�Smarty�˥���
$template_file = dirname (__file__)."/templates/fix_score_course.htm";

//�إߪ���
$obj= new score_ss($CONN,$smarty);
//��l��
$obj->init();
//�B�z�{��,���ɵ{�Ǥ���header���O,�G���{�ǩy��head("score_ss�Ҳ�");���e
$obj->process();

//�q�X�����������Y
head("�Ҫ��ƽs��");

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
   var $YS='YS';//�U�Ԧ����Ǵ����ڼƦW��
   var $year_seme;//�U�Ԧ����Z�Ū��ڼƭ�
   var $Sclass='class_id';//�U�Ԧ����Z�Ū��ڼƦW��
   var $grade_name='Grade';//�U�Ԧ����~�Ū��ڼƦW��
   var $Teach;//�����Юv
   var $YesNo=array('0'=>'�_','1'=>'�O');
   var $Grade;

	//�غc�禡
	function score_ss($CONN,$smarty){
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
      global $IS_JHORES;
      $this->IS_JHORES=$IS_JHORES;
      ($_GET[$this->YS]=='') ? $this->year_seme=curr_year()."_".curr_seme():$this->year_seme=$_GET[$this->YS];
      if ($_GET['Tsn']!='') $this->Tsn=(int)$_GET['Tsn'];
      $aa=split("_",$this->year_seme);
      $this->year=$aa[0];
      $this->seme=$aa[1];
	}
	//��l��
	function init() {$this->page=($_GET[page]=='') ? 0:$_GET[page];}
	//�{��
	function process() {
		//http://localhost/sfs3/modules/fix_tool/fix_print2.php?year_seme=98_2&Grade=7
		// fix_score_course.php?YS=103_1&Tsn=52
		if($_GET['act']=='del') $this->del();
		if($_GET['act']=='delall') $this->delall();
		if($_POST['form_act']=='update') $this->update();
		$this->all();
		$this->Teach=$this->getTeach();//�Юv��ư}�C

	}
	//��s�Ҫ�
	function update(){
		//print_r($_POST);die();
		$class_year=(int)$_POST['class_year'];
		$class_name =(int)$_POST['class_name'];
		$day=(int)$_POST['day'];
		$sector=(int)$_POST['sector'];
		$ss_id=(int)$_POST['ss_id'];
		$cooperate_sn=(int)$_POST['cooperate_sn'];
		$room=strip_tags($_POST['room']);
		$c_kind=(int)$_POST['c_kind'];
		$course_id=(int)$_POST['course_id'];
		$teacher_sn=(int)$_POST['teacher_sn'];
		$YS=strip_tags($_POST[$this->YS]);
		if ($YS=='') return ;
		if ($course_id=='' || $course_id=='0') return ;
		if ($teacher_sn=='' || $teacher_sn=='0') return ;
		if ($ss_id=='' || $ss_id=='0') return ;
		$SQL = "update score_course set teacher_sn='{$teacher_sn}',cooperate_sn='{$cooperate_sn}',
		class_year='{$class_year}',class_name='{$class_name}',day='{$day}',sector='{$sector}',
		ss_id='{$ss_id}',room='{$room}',c_kind='{$c_kind}' where course_id = '{$course_id}'";
		//die($SQL);
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$URL=$_SERVER['PHP_SELF']."?YS=".$YS."&Tsn=".$teacher_sn;
		Header("Location:$URL");
		
	}

	//���
	function display($tpl){
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
		//echo "<pre>";print_r($this->Course);
	}
	//�^�����
	function all(){

		if ($this->year=='') return ;
		if ($this->seme=='') return ;
		if ($this->Tsn=='') return ;
		//�Ҧ��ҵ{�]�w
		$SQL="select * from  score_course  where year='{$this->year}' 	and  semester='{$this->seme}' and teacher_sn='{$this->Tsn}' order by class_year,class_name,day,sector 	  ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$arr=$rs->GetArray();
		$this->all=$arr;//return $arr;
		$this->tol=count($arr);
		//return ;
		
		/*���ҵ{����W��*/
  		$SQL="select subject_id,subject_name from score_subject ";
		$rs=$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		if ($rs->RecordCount()==0) return "�|���]�w�����ظ�ơI";
		$obj=$rs->GetArray();
		foreach($obj as $ary){
			$id=$ary[subject_id];
			$this->Subj[$id]=$ary[subject_name];
		}

		$this->SsidToName=$this->SsidToName();
	}
	function SsidToName(){
		//�Ҧ��ҵ{�]�w
		$SQL="select * from score_ss where year='{$this->year}' 	and  semester='{$this->seme}' and enable='1'  order by class_year ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$arr=$rs->GetArray();
		//$this->all=$arr;//return $arr;		
		foreach ($arr as $ary){
			$id=$ary[ss_id];
			$scope=$ary[scope_id];
			$subject=$ary[subject_id];
			$AA[$id]=$ary['class_year'].$this->Subj[$scope].':'.$this->Subj[$subject]."($id)";
		}	
	return $AA;
	}

	function delall(){
		if ($this->Tsn=='' || $this->Tsn==0) return ;
		//�Ҧ��ҵ{�]�w
		$SQL="delete  from  score_course  where year='{$this->year}' and  semester='{$this->seme}'  and   	teacher_sn='{$this->Tsn}' ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
//echo $SQL;
		$URL=$_SERVER[PHP_SELF]."?YS=".$this->year_seme;
		Header("Location:$URL");
	}
	function del(){
		$id=(int)$_GET['id'];
		if ($id==0 || $id=='') die("�L�k�d�ߡA�y�k:".$SQL);
		//�Ҧ��ҵ{�]�w
		$SQL="delete  from  score_course  where year='{$this->year}' and  semester='{$this->seme}'  and course_id='$id' ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
//echo $SQL;
		$URL=$_SERVER[PHP_SELF]."?YS=".$this->year_seme."&Tsn=".$_GET['Tsn'];
		Header("Location:$URL");
	}



##################  �Ǵ��U�Ԧ����禡  ##########################
function select($show_class=1) {
    $SQL = "select * from school_day where  day<=now() and day_kind='start' order by day desc ";
    $rs=$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
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
    return $str;
}

/*�^���Юv�W�U�Υ��и`��*/
function getTeach() {
		if ($this->year=='') return ;
		if ($this->seme=='') return ;
		$SQL="select  a.teacher_sn,a.name,a.sex ,count(b.course_id) as tol from teacher_base a, score_course b where a.teacher_sn=b.teacher_sn and b.year='{$this->year}'  and b.semester='{$this->seme}' group by b.teacher_sn order by  hex(left(a.name,2)),a.sex desc  ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$arr=$rs->GetArray();	
		foreach($arr as $ary) {
		$K=$ary['teacher_sn'];
		$T[$K]=$ary;
		$this->TeaName[$K]=$ary['name']."($K)";
		}
	return $T;
	//print_r($this->Teach);
}
/*�^�ǳ�@�Юv�m�W*/
function getTeaOne($sn) {
	return $this->Teach[$sn]['name'];
}

##################  �Ǵ��U�Ԧ����禡  ##########################
function select_tea($select) {
		if ($this->year=='') return ;
		if ($this->seme=='') return ;
		//if ($this->Teach=='') return ;

		//echo "<pre>";print_r($arr);
		$str="<select name='".$this->YS."' onChange=\"location.href='".$_SERVER[PHP_SELF]."?YS=".$this->year_seme."&Tsn='+this.options[this.selectedIndex].value;\">\n";
		$str.="<option value=''>-�����-</option>\n";

	foreach($this->Teach as $key=>$ary) {
		//$key=$ary['teacher_sn'];
		//$T[$key]=$ary['name'];
		if ($ary['sex']=='1') {$SS=' class=blue ';$val=$ary['name']."(".$ary['tol'].")";}
		if ($ary['sex']=='2') {$SS=' class=red ';$val=$ary['name']."(".$ary['tol'].")";}
		($key==$this->Tsn) ? $bb=' selected':$bb='';
		$str.= "<option value='$key' $bb $SS>$val - $key </option>\n";
        }
    $str.="</select>";

    return $str;
}






} 
