<?php
//$Id: PHP_tmp.html 5310 2009-01-10 07:57:56Z hami $
//�t�γ]�w��

// include "config.php";
/* �u�ޤJconfig.php��,�]�a��javascript,�L�k�ϥ�header��� ,�ҥH�אּ�U�� */
include_once "./module-cfg.php";
include_once "../../include/config.php";
	
//�{��
sfs_check();

$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);
if ($module_manager!=1) {
	head("�A�Ⱦǲ߶��ؽs��");	
	echo make_menu($school_menu_p);
	echo "��p , �z�S���L�޲z�v��!";
	exit();
}

//$Item=get_module_setup('stud_service');
//print_r($Item);

//�ޤJ��������(�ǰȨt�ΥΪk)
include_once "../../include/chi_page2.php";
//�{���ϥΪ�Smarty�˥���
$template_file = dirname (__file__)."/templates/service_item.htm";

//�إߪ���
$obj= new stud_service($CONN,$smarty);
//��l��
$obj->init();
//�B�z�{��,���ɵ{�Ǥ���header���O,�G���{�ǩy��head("stud_service�Ҳ�");���e
$obj->process();

//�q�X�����������Y
head("�A�Ⱦǲ߶��ؽs��");

//���SFS�s�����(���ϥνЮ��}����)
echo make_menu($school_menu_p);



//��ܤ��e
$obj->display($template_file);
//�G������

foot();
//print "<pre>";
//print_r($_SESSION);


//����class
class stud_service{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $size=15;//�C������
	var $page;//�ثe����
	var $tol;//����`����
	var $Item;//�ҲհѼ�
	var $YN=array('0'=>'�_','1'=>'�O');//radio�θ��

	//�غc�禡
	function stud_service($CONN,$smarty){
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
		//���o�ҲհѼ�
		$Item=get_module_setup('stud_service');
		$this->Item=explode(',',$Item['item']);
	}
	//��l��
	function init() {$this->page=($_GET[page]=='') ? 0:$_GET[page];}
	//�{��
	function process() {
		//if($_POST['form_act']=='Search') $this->SearchMemo();
		if($_POST['form_act']=='add') $this->add();
		if($_POST['form_act']=='update') $this->update();
		if($_GET['form_act']=='del') $this->del();
		// ���B�ǦW�ٸ��
		$this->setRoom();
		$this->all();
	}
	//���
	function display($tpl){
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
	}
	//�^�����
	function all(){
		//--- 203-10-01 �ˬd�ϥΪ̬O�_�֦��̰��v��
		$is_admin = false;
		
		$SQL2 = "select * from pro_check_new where (pro_kind_id = 1  and  id_sn = '{$_SESSION[session_tea_sn]}' )";
		$rs2=$this->CONN->Execute($SQL2) or die($SQL2);
		if ($rs2 and $ro2=$rs2->FetchNextObject() ) $is_admin = true;
		//�j�M���e�r��
		$Search_Str=$this->SearchMemo();
		if ($Search_Str!='') {
			$this->Search_Str=$Search_Str;
			$addSQL1=" and memo like '%".$Search_Str."%' ";
			$addSQL=" and a.memo like '%".$Search_Str."%' ";
			$admSQL=" where  memo like '%".$Search_Str."%' ";
			}
		$SQL="select sn from stud_service where input_sn='{$_SESSION[session_tea_sn]}' $addSQL1 ";
		if ($is_admin) {
			$SQL="select sn from stud_service $admSQL ";		
		}
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$this->tol=$rs->RecordCount();
		
		$SQL="select a.*,count(b.sn) as btol from stud_service a ,stud_service_detail b 
		where a.sn=b.item_sn group by  a.sn order by a.sn desc  limit ".($this->page*$this->size).", {$this->size}  ";
		//--- 2013-10-01 �ק令 �̪A�Ȫ��ɶ��ϧǱƦC
		$SQL="select a.*,count(b.sn) as btol from stud_service a ,stud_service_detail b 
		where (a.input_sn='{$_SESSION[session_tea_sn]}') and a.sn=b.item_sn  $addSQL  group by  a.sn order by a.service_date desc  limit ".($this->page*$this->size).", {$this->size}  ";

		if ($is_admin ) {
			$SQL="select a.*,count(b.sn) as btol from stud_service a ,stud_service_detail b 
			where a.sn=b.item_sn $addSQL group by  a.sn order by a.service_date desc  limit ".($this->page*$this->size).", {$this->size}  ";
		}
		//--- 2013-10-01 ----------------------------------------------------------------------------------------
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$arr=$rs->GetArray();
		$this->all=$arr;//return $arr;
	//���ͳs������
		$this->links= new Chi_Page($this->tol,$this->size,$this->page);
	}

	//��s
	function update(){
		//�ܼƹL�o
		$fields=array('page','sn','year_seme','service_date','department','sponsor','item','memo','confirm');
    	foreach ($fields as $FF){
			//if ($_POST[A]=='') continue ;
			$tmp=filter_var($_POST[$FF], FILTER_SANITIZE_STRING);
			$$FF=strip_tags(trim($tmp));
		}

		$update_time=date("Y-m-d H:i:s"); 
		$SQL="update  stud_service set   year_seme ='{$year_seme}', service_date ='{$service_date}',
		department ='{$department}', item ='{$item}', memo ='{$memo}', sponsor ='{$sponsor}', confirm ='{$confirm}',
		update_time ='$update_time'  where sn ='{$sn}' ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$URL=$_SERVER['SCRIPT_NAME']."?page=".$page;
		Header("Location:".$URL);
	}
	//�R��
	function del(){
		$sn=(int)$_GET['sn'];$page=(int)$_GET['page'];
		$SQL="select sn from  stud_service_detail where  item_sn ='$sn' ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$tol=$rs->RecordCount();
		if ($tol > 0) $this->backe('!!�|���n���ǥͤ���R��!!');

		$SQL="Delete from  stud_service  where  sn='{$sn}' ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$URL=$_SERVER['SCRIPT_NAME']."?page=".$page;
		Header("Location:".$URL);
	}
//���o�B�ǦW��-�N��,�αЮv�m�W-�N��
	function setRoom(){
		$SQL="select room_id,room_name from  school_room  where  enable='1' order by  room_id ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$arr=$rs->GetArray();
		foreach ($arr as $ary){$A[$ary['room_id']]=$ary['room_name'];}
		$this->Room=$A;//return $arr;

		$SQL="select  teacher_sn,`name` from  teacher_base order by  abs(name) ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$arr=$rs->GetArray();
		foreach ($arr as $ary){$B[$ary['teacher_sn']]=$ary['name'];}
		$this->Tea=$B;//return $arr;
	}

function backe($value= "BACK"){
	echo  "<head><meta http-equiv='Content-Type' content='text/html; charset=big5'></head><br><br><br><br><CENTER><form><input type=button value='".$value."' onclick=\"history.back()\" style='font-size:16pt;color:red;'></form><BR></CENTER>";
	exit;
}
function SearchMemo(){
	if (isset($_POST['nSearch'])) {unset($_SESSION['Search_Str']);return ;}
	if (isset($_POST['Search'])) {
		$str=strip_tags(trim($_POST['Search']));
		if (strlen($str)>=2 && strlen($str)<=30) {
			$_SESSION['Search_Str']=$str;
		}
	}
	return $_SESSION['Search_Str'];
}

}
