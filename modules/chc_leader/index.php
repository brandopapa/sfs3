<?php
//$Id: PHP_tmp.html 5310 2009-01-10 07:57:56Z hami $
include "config.php";
//�{��
sfs_check();


//�{���ϥΪ�Smarty�˥���
$template_file = dirname (__file__)."/templates/ind.htm";

//�إߪ���
$obj= new basic_chc($CONN,$smarty);
//��l��
$obj->init();
//�B�z�{��,���ɵ{�Ǥ���header���O,�G���{�ǩy��head("12basic_chc�Ҳ�");���e
$obj->process();


//�q�X�����������Y
head("[��]�Z�ŷF���޲z");


//���SFS�s�����(���ϥνЮ��}����)
echo make_menu($school_menu_p);

//��ܤ��e
$obj->display($template_file);
//�G������
foot();


//����class
class basic_chc{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $size=10;//�C������
	var $page;//�ثe����
	var $tol;//����`����

	//�غc�禡
	function basic_chc($CONN,$smarty){
		global $UPLOAD_PATH,$SFS_PATH_HTML;
		$this->SFS_PATH_HTML=$SFS_PATH_HTML;
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
		$this->uPath=$UPLOAD_PATH;
		$this->ufile=$UPLOAD_PATH.'school/chc_leader/tol.cache';
		if (!file_exists($UPLOAD_PATH.'school/')) @mkdir($UPLOAD_PATH.'school/');
		if (!file_exists($UPLOAD_PATH.'school/chc_leader/')) @mkdir($UPLOAD_PATH.'school/chc_leader/');
	}
	//��l��
	function init() {$this->page=($_GET[page]=='') ? 0:$_GET[page];}
	//�{��
	function process() {
		if ($_GET['act']=='update') $this->updateDate();
		$this->all();
	}

	function updateDate() {
		@unlink($this->ufile);
		$URL=$_SERVER['SCRIPT_NAME'];
		Header("Location:$URL");
	}


	//���
	function display($tpl){
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
	}
	//�^�����
	function all(){
		if (!file_exists($this->ufile)) :
			
			$SQL="select id,student_sn,seme,kind,org_name from chc_leader  ";
			$rs=$this->CONN->Execute($SQL) or die($SQL);
			$tol=$rs->RecordCount();
			if ($tol==0) return;
			$arr=$rs->GetArray();
			foreach($arr as $ary){
				$seme=$ary['seme'];
				$kind=$ary['kind'];
				$Tol[$seme][$kind]++;
				$Tol[$seme]['Tol']++;
				$KK[$kind]++;
				$KK['Tol']++;
			}
			$All['data']=$Tol;
			$All['kind']=$KK;
			$All['utime']=date('Y-m-d H:i:s');
			$word=serialize($All);
			$chk=$this->upload_write($word);
			if ($chk=='N') backe('!!�L�k�g�J�ɮ�!!');
			$this->all=$All;
		
		else:
			$str=file_get_contents ($this->ufile);
			$this->all=unserialize($str);
		endif;

	//���ͳs������
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


