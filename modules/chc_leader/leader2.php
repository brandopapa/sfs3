<?php
//$Id: chc_seme.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";
//�{��
sfs_check();

//�ޤJ��������(�ǰȨt�ΥΪk)
include_once "../../include/sfs_oo_dropmenu.php";
//�{���ϥΪ�Smarty�˥���
$template_file1 = dirname (__file__)."/templates/leader2.htm";
$template_file2 = dirname (__file__)."/templates/leader2add.htm";
if ($_GET['act']=='add') {$template_file=$template_file2;}else {$template_file=$template_file1;} 
//�إߪ���
$obj= new chc_seme($CONN,$smarty);
//��l��
$obj->init();
//�B�z�{��,���ɵ{�Ǥ���header���O,�G���{�ǩy��head("score_semester_91_2�Ҳ�");���e
$obj->process();
//echo '<pre>';print_r($_POST);die();
//�q�X�����������Y
head("[��]�Z�ŷF���޲z");

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
	var $class_id;//��ذ}�C
	var $StuTitle;
	var $kind=array('0'=>'�����','1'=>'���ηF��','2'=>'���թʷF��');
	//var $kind0=array('�Z��','�ƯZ��','�d�֪Ѫ�','�����Ѫ�','�ưȪѪ�','�åͪѪ�','�����Ѫ�','���ɪѪ�','���O�Ѫ�','��T�Ѫ�');


	//�غc�禡
	function chc_seme($CONN,$smarty){
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
	}
	//��l��
	function init() {
		$YS=''; 
		if (isset($_POST['year_seme'])) $YS=$_POST['year_seme'];
		if ($YS=='' && isset($_GET['year_seme'])) $YS=$_GET['year_seme'];
		if ($YS=='') $YS=curr_year()."_".curr_seme();
		$this->year_seme=$YS;
		$aa=split("_",$this->year_seme);
		$this->year=$aa[0];
		$this->seme=$aa[1];		
		
		}
	//�{��
	function process() {
		if(isset($_POST['form_act']) && $_POST['form_act']=='add') $this->add();
		if(isset($_POST['form_act']) && $_POST['form_act']=='update') $this->update();
		if(isset($_GET['form_act']) && $_GET['form_act']=='del') $this->del();
		$this->all();
	}
	//���
	function display($tpl){
		$ob=new drop($this->CONN);
		$this->select=&$ob->select();
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
	}
	//�R��
	function del(){
		$id=(int)$_GET['id'];
		$SQL="Delete from  chc_leader  where  id='{$id}' ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$URL=$_SERVER['SCRIPT_NAME']."?year_seme=".$this->year_seme."&class_id=".$_GET['class_id'];
		Header("Location:$URL");
	}


	//��s
	function update(){
		//echo '<pre>'.$this->year_seme;print_r($_POST);die();
		$title=strip_tags(trim($_POST['title']));
		$org_name=strip_tags(trim($_POST['org_name']));
		$kind=(int) $_POST['kind'];
		$stuSN =(int) $_POST['student_sn'];
		$id =(int) $_POST['id'];
		if ($kind==0 or $kind=='') backe('!!��J���~!!');
		if ($org_name=='' or $title=='') backe('!!��J���~!!');

		$cr_time=date("Y-m-d H:i:s");
		$tea_sn=$_SESSION['session_tea_sn'];
		$memo=strip_tags(trim($_POST['memo']));
		$SQL="update  chc_leader set   kind ='{$kind}', org_name ='{$org_name}', title ='{$title}',memo='{$memo}'
		, update_sn ='{$tea_sn}', cr_time ='{$cr_time}' where id ='{$id}' and  student_sn ='{$stuSN}' ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		
		$URL=$_SERVER['SCRIPT_NAME']."?year_seme=".$this->year_seme."&class_id=".$_POST['class_id'];
		Header("Location:$URL");
	}

	//�s�W���
	function add(){
		//echo '<pre>';print_r($_POST);die();
		$tea_sn=$_SESSION['session_tea_sn'];
		$c_id=explode('_',$_POST['class_id']);//���} 101_2_06_01
		$seme=$c_id[0].$c_id[1];
		$cla=($c_id[2]+0).$c_id[3];
		//$kind='0';
		$cr_time=date("Y-m-d H:i:s");
		
		foreach ($_POST['kind'] as $SN=>$kind){
			$title=strip_tags(trim($_POST['title'][$SN]));
			$org_name=strip_tags(trim($_POST['org_name'][$SN]));
			if ($kind==0 or $kind=='' or $title=='' or $org_name=='') continue;
			$SQL="INSERT INTO chc_leader(student_sn,seme,kind,org_name,title,update_sn,cr_time)  
		values ('{$SN}' ,'{$seme}' ,'{$kind}' ,'{$org_name}' ,'{$title}' ,'{$tea_sn}' ,'{$cr_time}' )";
			$rs=$this->CONN->Execute($SQL) or backe('�ۦP���Τ��i�H�����طF��!!');//;die($SQL);
		}
		
		//$Insert_ID= $this->CONN->Insert_ID();
		$URL=$_SERVER['SCRIPT_NAME']."?year_seme=".$this->year_seme."&class_id=".$_POST['class_id'];
		Header("Location:$URL");
	}
	//�^�����
	function all(){
		if ($_GET['class_id']=='') return;
		$this->class_id=$_GET['class_id'];
		$this->stu=$this->get_stu();
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

		

		//$SQL="select id,student_sn,seme,kind,org_name,title from chc_leader where kind!='0'  and seme='$CID_1' and org_name !='$CID_2'  ";
		$SQL="select a.stud_name,a.stud_sex,b.seme_year_seme,b.seme_class,b.seme_num,c.*  
		from stud_base a,stud_seme b, chc_leader c 
		where a.student_sn=b.student_sn and  a.student_sn=c.student_sn  and b.seme_year_seme='{$CID_1}' 
		and b.seme_class='{$CID_2}'  and c.seme='{$CID_1}' and c.kind!='0' and org_name !='$CID_2'  
		order by b.seme_num,c.org_name, c.title ";
		// echo $SQL;
		$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		$All=$rs->GetArray();
		if ($rs->RecordCount()==0) {$this->StuB='';}
		else {$this->StuB=$All;}
		
		//print_r($this->StuB);
		return $obj_stu;	
	}




	function get_Title($sn){
	return $this->StuTitle[$sn]['title'];
}




function getLeaderKind($K){
	return getLeaderKind($K);
}




}


