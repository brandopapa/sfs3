<?php
//$Id: report.php 7430 2013-08-22 07:48:17Z hami $
include "config.php";
//�{��
sfs_check();

include_once "../../include/sfs_case_dataarray.php";
//�ޤJ��������(�ǰȨt�ΥΪk)
include_once "../../include/chi_page2.php";

//�{���ϥΪ�Smarty�˥���
$template_file = dirname (__file__)."/templates/school_report_things.htm";

//�إߪ���
$obj= new school_report_things($CONN,$smarty);
//��l��
$obj->init();
//�B�z�{��,���ɵ{�Ǥ���header���O,�G���{�ǩy��head("school_report_things�Ҳ�");���e
$obj->process();

//�q�X�����������Y
head("�հȳ��i�׾�");

//���SFS�s�����(���ϥνЮ��}����)
//echo make_menu($school_menu_p);

//��ܤ��e
$obj->display($template_file);
//�G������
foot();


//����class
class school_report_things{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $size=10;//�C������
	var $page;//�ثe����
	var $tol;//����`����
	//�غc�禡
	function school_report_things($CONN,$smarty){
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
	}
	//��l��
	function init() {
		global $SCHOOL_BASE;
		$this->smarty->assign('SCHOOL_BASE',$SCHOOL_BASE);
	}
	//�{��
	function process() {
		if($_POST[form_act]=='add') $this->add();
		if($_POST[form_act]=='update') $this->update();
		if($_GET[form_act]=='del') $this->del();
		if ($_GET['act'] == 'print'){
			$this->display(dirname (__FILE__)."/templates/list_rep.tpl");
			exit;
		}
		//fix by licf 2009/08/03
		if ($_GET['act'] == 'big_print'){
			$this->display(dirname (__FILE__)."/templates/list_rep2.tpl");
			exit;

		}
	}
	//���
	function display($tpl){
		$this->smarty->assign('temp_path',dirname (__FILE__)."/templates/");
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
	}
	/**
	* ���o¾�ٸ��
	*/
	function & get_title(){
		$query = "SELECT a.teacher_sn, b.post_kind, b.post_office,d.title_name ,b.class_num FROM teacher_base a , teacher_post b, teacher_title d WHERE a.teacher_sn = b.teacher_sn AND b.teach_title_id = d.teach_title_id ";
		$res = & $this->CONN->Execute($query) or die($query);
		$arr = array();
		while($row = $res->fetchRow()){
			$arr[$row['teacher_sn']] = $row;
		}
		return $arr;

	}


	//�^�����
	function & get_all($year_seme,$val,$is_date=0){
		if ($is_date == 1)
			$temp = " AND open_date='$val' ";
		else
			$temp = " AND weeks='$val' ";

		$SQL="select a.*,b.name,c.teach_title_id from school_report_things a ,teacher_base b,teacher_post c, teacher_title d WHERE a.teacher_sn=b.teacher_sn AND a.year_seme='$year_seme' AND c.teacher_sn=a.teacher_sn AND c.teach_title_id=d.teach_title_id $temp  order by a.open_date desc, a.room_id ASC,d.rank";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$arr=$rs->GetArray();
		return $arr;
	}

	//�s�W
	function add(){
		$week_num = $this->getCurrweek($_POST['open_date']);
		$SQL="INSERT INTO school_report_things(weeks,title,content,c_time,teacher_sn,room_id,year_seme,open_date)  values ('{$week_num}' ,'{$_POST['title']}' ,'{$_POST['content']}' ,now() ,'{$_SESSION['session_tea_sn']}' ,'{$_POST['room_id']}' ,'{$_POST['year_seme']}' ,'{$_POST['open_date']}')";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		//$Insert_ID= $this->CONN->Insert_ID();
		$URL=$_SERVER[PHP_SELF]."?year_seme={$_POST['year_seme']}&week_num={$_POST['week_num']}";
		Header("Location:$URL");
	}
	//��s
	function update(){
		$week_num = $this->getCurrweek($_POST['open_date']);
		$SQL="update  school_report_things set   title ='{$_POST['title']}', content ='{$_POST['content']}', c_time =now(), teacher_sn ='{$_SESSION['session_tea_sn']}', room_id ='{$_POST['room_id']}', open_date ='{$_POST['open_date']}' , weeks='$week_num'  where id ='{$_POST['id']}'";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$URL=$_SERVER[PHP_SELF]."?year_seme={$_POST['year_seme']}&week_num={$_POST['week_num']}";
		Header("Location:$URL");
	}


	//�R��
	function del(){
		$SQL="Delete from  school_report_things  where  id='{$_GET['id']}' ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$URL=$_SERVER[PHP_SELF]."?page=".$_GET[page];
		Header("Location:$URL");
	}

	/**
	* ���o�B�ǰ}�C
	*/
	function & getRoomArr(){
		return room_kind();

	}

	/**
	* ���M�Ǧ~�Ǵ�
	*/
	function &  get_year_seme() {
		$sel_year = curr_year();
		$sel_seme = curr_seme();
		$year_seme = sprintf("%03d%d",$sel_year,$sel_seme);
		$arr[$year_seme] = "$sel_year �Ǧ~�� $sel_seme �Ǵ�";
		$query = "SELECT DISTINCT year_seme FROM school_report_things ORDER BY year_seme DESC";
		$res = & $this->CONN->Execute($query) or trigger_error("SQL �y�k���~: $query", E_USER_ERROR);
		while($row = $res->FetchRow()) {
			$arr[$row['year_seme']] = substr($row['year_seme'],0,3)." �Ǧ~�� ".substr($row['year_seme'],-1)."�Ǵ�";
		}
		return $arr;
	}

	/**
	* ���o���P id
	*/
	function getCurrweek($this_date='') {
		$sel_year = curr_year();
		$sel_seme = curr_seme();
		if ($this_date=='') $this_date=date("Y-m-d");
		//���o�g��
		$weeks_array=get_week_arr($sel_year,$sel_seme,$this_date);
		return $weeks_array[0];
	}


	/**
	* ���o�P�O
	*/
	function & get_week($year_seme=''){
		if (empty($year_seme)){
			$sel_year = curr_year();
			$sel_seme = curr_seme();
		}
		else{
			$sel_year = substr($year_seme,0,3);
			$sel_seme = substr($year_seme,-1);
		}
		//�g���
		$start_day = curr_year_seme_day($sel_year,$sel_seme);
		if (!$start_day[st_start])
			return "�}�Ǥ�S���]�w";
		else {
			//���o�g��
			$weeks_array=get_week_arr($sel_year,$sel_seme);
			while(list($k,$v)=each($weeks_array)) {
				if ($k==0) continue;
				$weeks[$k]="��".$k."�g ($v ~ ".date("Y-m-d",(strtotime("+ 6 days",strtotime($v)))).")";
			}
			return $weeks;
		}
	}

	/**
	* ���o�ϥΪ̳B��
	*/
	function get_user_room_id(){

		$query =  "SELECT post_office FROM teacher_post WHERE teacher_sn='{$_SESSION['session_tea_sn']}'";
		$res = $this->CONN->Execute($query);
		$row = $res->fetchRow();
		return $row['post_office'];
	}

	/**
	* ���o  fckeditor
	*/
	function & getFckeditor($fname,$value=''){
		require "../../include/fckeditor.php";
		$oFCKeditor = new FCKeditor($fname) ;
		$oFCKeditor->ToolbarSet = 'Basic';
		$oFCKeditor->Value=$value;
		return $oFCKeditor;
	}

	/**
	* ���o���
	*/
	function & getData($id){

		$query = "SELECT * FROM school_report_things WHERE id = $id";
		$res = & $this->CONN->Execute($query) or die($query);
		return $res->fetchRow();
	}
}
?>
