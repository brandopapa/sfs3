<?php
//$Id: chc_seme.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";
//�{��
sfs_check();


//�{���ϥΪ�Smarty�˥���
$template_file = dirname (__file__)."/templates/leader_var.htm";
//�إߪ���
$obj= new chc_seme($CONN,$smarty);
//��l��
$obj->init();
//�B�z�{��,���ɵ{�Ǥ���header���O,�G���{�ǩy��head("score_semester_91_2�Ҳ�");���e
$obj->process();

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
	var $ufile;//��ذ}�C
	var $StuTitle;
	
	var $kind1=array('�Z��','�ƯZ��','�d�֪Ѫ�','�����Ѫ�','�ưȪѪ�','�åͪѪ�','�����Ѫ�','���ɪѪ�','���O�Ѫ�','��T�Ѫ�');
	var $kind2=array('��֪�','���ֹ�','�޼ֹ�','���ö�','�x�y��');
	var $kind3=array('����','�ƪ���','����','�ƶ���');
	//�غc�禡
	function chc_seme($CONN,$smarty){
		global $UPLOAD_PATH;
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
		$this->uPath=$UPLOAD_PATH;
		$this->ufile=$UPLOAD_PATH.'school/chc_leader/var.txt';
		if (!file_exists($UPLOAD_PATH.'school/')) @mkdir($UPLOAD_PATH.'school/');
		if (!file_exists($UPLOAD_PATH.'school/chc_leader/')) @mkdir($UPLOAD_PATH.'school/chc_leader/');
		//if (!file_exists($this->ufile)) mkdir($UPLOAD_PATH.'school/');
	}
	//��l��
	function init() {

		
		}
	//�{��
	function process() {
		if(isset($_POST['form_act']) && $_POST['form_act']=='update') $this->update();
		if(isset($_POST['form_act']) && $_POST['form_act']=='resetvar') $this->reSetvar();
		$this->all();
	}
	//���
	function display($tpl){
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
	}
	//��l��
	function reSetvar() {
			$data['A']=$this->kind1;
			$data['B']=$this->kind2;
			$data['C']=$this->kind3;
			$word=serialize($data);
			$chk=$this->upload_write($word);
			if ($chk=='N') backe('!!�L�k�g�J�ɮ�!!');
			
			$URL=$_SERVER['SCRIPT_NAME'];
			Header("Location:$URL");
		}



	//�^�����
	function update(){
		//�Z�ŷF���W��text���B�z
		$A=explode("\n",$_POST['kindA']);
		foreach($A as $a){
			$a=strip_tags(trim($a));
			if ($a=='') continue;
			$A1[]=$a;unset($a);
		}	

		//���ΦW��text���B�z
		$B=explode("\n",$_POST['kindB']);
		foreach($B as $b){
			$b=strip_tags(trim($b));
			if ($b=='') continue;
			$B1[]=$b;unset($b);
		}	

		//���ηF���W��text���B�z
		$C=explode("\n",$_POST['kindC']);
		foreach($C as $c){
			$c=strip_tags(trim($c));
			if ($c=='') continue;
			$C1[]=$c;unset($c);
		}	
		$ALL['A']=$A1;$ALL['B']=$B1;$ALL['C']=$C1;
		$word=serialize($ALL);
		$chk=$this->upload_write($word);
		if ($chk=='N') backe('!!�L�k�g�J�ɮ�!!');
		


		//$Insert_ID= $this->CONN->Insert_ID();
		$URL=$_SERVER['SCRIPT_NAME'];
		Header("Location:$URL");
	}
	//�^�����
	function all(){
		if (!file_exists($this->ufile)) :
			$this->data['A']=join("\r",$this->kind1);
			$this->data['B']=join("\r",$this->kind2);
			$this->data['C']=join("\r",$this->kind3);
		else:
			$str=file_get_contents ($this->ufile);
			$data=unserialize($str);
			$this->data['A']=join("\r",$data['A']);
			$this->data['B']=join("\r",$data['B']);
			$this->data['C']=join("\r",$data['C']);
		endif;
		
	}






//--- �N��Ƽg�ܤW�ǥؿ������ɮ�
function upload_write($ftxt) {
	
	$fname = $this->ufile;
	//print "<br> 1234 fname={$fname}";
	$handle=fopen($fname,"w+");
	if ($handle) {
		$bytes = fwrite($handle,$ftxt);
		fclose($handle);
	}else{
		return 'N';		
		}
	
	return 'Y';
}















}
