<?php
//$Id: fix_sendmit.php 5310 2009-01-10 07:57:56Z hami $
require_once("config.php");

//�ϥΪ̻{��
sfs_check();
head("�}�꾹");
print_menu($school_menu_p);
$obj=new sendmit();
$obj->CONN=&$CONN;
$obj->smarty=&$smarty;
$obj->IS_JHORES=&$IS_JHORES;
$obj->process();
/*
  sendmit='0'�W��
  sendmit='1'�}��
*/
class sendmit{
   var $CONN;//ADO
   var $smarty;
   var $IS_JHORES;//�ꤤ�p�P�_�Ѽ�
   var $year;//�~
   var $seme;//�Ǵ�
   var $Y_name='year_seme';//�U�Ԧ����Ǵ����ڼƦW��
   var $S_name='class_id';//�U�Ԧ����Z�Ū��ڼƦW��
   var $YS_ary;//�Ǵ��}�C
   var $YC_ary;//�~�Z�}�C
   var $year_seme;//�U�Ԧ����Ǵ����ڼƭ�95_1
   var $Sel_class;//�U�Ԧ����Z�Ū��ڼƭ�095_1_04_02
   var $open=array(
"1s"=>"��1���q�q��","2s"=>"��2���q�q��","3s"=>"��3���q�q��","a_s"=>"�����q��",
"1n"=>"��1���q����","2n"=>"��2���q����","3n"=>"��3���q����","a_n"=>"��������",
"255"=>"�������q","all"=>"���Z����","school"=>"���~�ť���","subj"=>"�������");
   var $open_readme=array(
"1s"=>"�ȥ��}�����W���Z����ز�1���q�q�Ҫ����Z","2s"=>"�ȥ��}�����W���Z����ز�2���q�q�Ҫ����Z","3s"=>"�ȥ��}�����W���Z����ز�3���q�q�Ҫ����Z","a_s"=>"�ȥ��}�����W���Z�����1-3�����q�Ҫ����Z",
"1n"=>"�ȥ��}�����W���Z����ز�1���q����","2n"=>"�ȥ��}�����W���Z����ز�2���q����","3n"=>"�ȥ��}�����W���Z����ز�3���q����","a_n"=>"�ȥ��}�����W���Z�����1-3���������ɪ����Z",
"255"=>"�ȥ��}�����W���Z����ؤ������q","all"=>"���}�����W���Z����(�t�q�ҥ��ɩΤ������q)�����Z","school"=>"���}�����W���~�ť���(�t�q�ҥ��ɩΤ������q)�����Z","subj"=>"�Z��Ʈw������ت����Z�����}�����W");
	

function process() {
//if ($_POST){echo "<pre>";print_r($_POST);die();}
	$this->init();
	if ($_POST[form_act]=='updata') $this->sendmit_open();
	$this->YS_ary=$this->sel_year();//�Ǵ��}�C
	$this->YC_ary=$this->grade();//�~�ůZ�Ű}�C
	if ($this->Sel_class!='') $this->sub=$this->get_subj($this->Sel_class);
	$this->display();
}

function init() {
	($_GET[$this->Y_name]=='') ? $this->year_seme=$_POST[$this->Y_name]:$this->year_seme=$_GET[$this->Y_name];
	if ($this->year_seme=='') $this->year_seme=curr_year()."_".curr_seme();
	($_GET[$this->S_name]=='') ? $this->Sel_class=$_POST[$this->S_name]:$this->Sel_class=$_GET[$this->S_name];
	
   $tmp=split("_",$this->year_seme);
   $this->year=$tmp[0];
   $this->seme=$tmp[1]; 

}
function display(){
	if ($this->tpl=='') $this->tpl=dirname(__file__)."/templates/fix_sendmit.htm";
		$this->smarty->assign("this",$this);
		$this->smarty->display($this->tpl);
}

function sendmit_open() {
	//echo "<pre>";print_r($_POST);die();
	if ($_POST[year_seme]=='') return;
	if ($_POST[class_id]=='') {return;}else {$class_id=$_POST[class_id];}
	if ($_POST[sendmit]=='') {return;}else {$sendmit=$_POST[sendmit];}
	
	// 095_1_02_01
	if ($_POST[subj]=='') {return;}else {$subj=$_POST[subj];}
	if ($_POST[open][$subj]=='') {return;} else{$key=$_POST[open][$subj];}
	
	$tmp=split('_',$class_id);
	$tmp1=$tmp[0]."_".$tmp[1]."_".$tmp[2];//���~��
	
	$TB="score_semester_".$_POST[year_seme];
	$SQL1="update $TB set sendmit='$sendmit' where  ss_id='{$subj}' ";	
	$SQL["1s"]=" and test_sort='1' and  test_kind='�w�����q' and class_id='$class_id' ";
	$SQL["2s"]=" and test_sort='2' and  test_kind='�w�����q' and class_id='$class_id' ";
	$SQL["3s"]=" and test_sort='3' and  test_kind='�w�����q' and class_id='$class_id' ";
	$SQL["a_s"]=" and test_kind='�w�����q' and class_id='$class_id' ";	
	$SQL["1n"]=" and test_sort='1' and  test_kind='���ɦ��Z' and class_id='$class_id' ";
	$SQL["2n"]=" and test_sort='2' and  test_kind='���ɦ��Z' and class_id='$class_id' ";
	$SQL["3n"]=" and test_sort='3' and  test_kind='���ɦ��Z' and class_id='$class_id' ";
	$SQL["a_n"]=" and  test_kind='���ɦ��Z' and class_id='$class_id' ";
	$SQL["255"]=" and  test_kind='���Ǵ�' and class_id='$class_id' ";
	$SQL["all"]=" and class_id='$class_id' ";
	$SQL["school"]=" and class_id like '$tmp1%' ";
	$SQL["subj"]=" ";
	
	$SQL=$SQL1.$SQL[$key];
	$rs=$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	$URL=$_SERVER[PHP_SELF]."?".$this->Y_name."=".$_POST[year_seme]."&".$this->S_name."=".$class_id;
		Header("Location:$URL");
}




function sel_year() {
	$SQL = "select * from school_day where  day<=now() and day_kind='start' order by day desc ";
	$rs=$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	while(!$rs->EOF){
	$ro = $rs->FetchNextObject(false);
	// ��i$ro=$rs->FetchNextObj()�A���O�ȥΩ�s������adodb�A�ثe��SFS3���A��
	$tmp_y=$ro->year."_".$ro->seme;
	$tmp[$tmp_y]=$ro->year."�Ǧ~�ײ�".$ro->seme."�Ǵ�";
	}
	return $tmp;
	}

function grade() {
    //�W��,�_�l��,������,��ܭ�
    ($this->IS_JHORES==6) ? $grade=array(7=>"�@�~",8=>"�G�~",9=>"�T�~"):$grade=array(1=>"�@�~",2=>"�G�~",3=>"�T�~",4=>"�|�~",5=>"���~",6=>"���~");
    $SQL="select class_id,c_year,c_name,teacher_1 from  school_class where year='".$this->year."' and semester='".$this->seme."' and enable=1  order by class_id  ";
    $rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
    if ($rs->RecordCount()==0) return"�|���]�w�Z�Ÿ�ơI";
    $All=$rs->GetArray();

    foreach($All as $ary) {
    	$tmp[$ary[class_id]]=$grade[$ary[c_year]].$ary[c_name]."�Z (".$ary[teacher_1].")";
		}
    return $tmp;
} 


function get_subj($class_id,$type='') {
	if ($_GET[mods]=='') return;
	switch ($type) {
		case 'all':
		$add_sql=" ";break;
		case 'seme':
		$add_sql=" and need_exam='1' ";break;//�����Z��
		case 'stage':
		$add_sql=" and need_exam='1'  and print='1' ";break;//���q��,����
		case 'no_test':
		$add_sql=" and need_exam='1'  and print!='1' ";break; //���άq�Ҫ�
		default:
		$add_sql=" ";break;
	} 
//	$add_sql.=" and enable='1'  ";
	$CID=split("_",$class_id);//093_1_01_01
	$year=$CID[0];
	$seme=$CID[1];
	$grade=$CID[2];
	$class=$CID[3];
	$CID_1=$year."_".$seme."_".$grade."_".$class;
	$SQL1="select * from score_ss where class_id='' and year='".intval($year)."' and semester='".intval($seme)."' and  class_year='".intval($grade)."' $add_sql order by enable , scope_id  , sort,sub_sort ";
	
	$SQL2="select * from score_ss where class_id='$CID_1' and year='".intval($year)."' and semester='".intval($seme)."' and  class_year='".intval($grade)."'   $add_sql order by enable , scope_id ,sort,sub_sort ";
	
	//echo $SQL;
	($_GET[mods]=='year') ? $SQL=$SQL1:$SQL=$SQL2;
	$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	if ($rs->RecordCount()==0) return;

	$All_ss=$rs->GetArray();
	//print_r($All_ss);
	/*����ئW��*/
	$SQL="select * from score_subject ";
	$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	$All_subj=$rs->GetArray();
   foreach($All_subj as $ary) {
    	$subj_name[$ary[subject_id]]=$ary[subject_name];
		}
	
	$obj_SS=array();
	for($i=0;$i<count($All_ss);$i++){
		$key=$All_ss[$i][ss_id];//����
		$obj_SS[$key]=$All_ss[$i];//�����}�C,�Ȥ���
		//$obj_SS[$key][rate]=$All_ss[$i][rate];//�[�v
		$obj_SS[$key][scope]=$subj_name[$All_ss[$i][scope_id]];//���W��
		$obj_SS[$key][subject]=$subj_name[$All_ss[$i][subject_id]];//��ئW��
		//($obj_SS[$key][sb]=='') ? $obj_SS[$key][sb]=$obj_SS[$key][sc]:"";
	}
	//die("�L�k�d�ߡA�y�k:".$SQL);
	return $obj_SS;
}



}

foot();
// echo "<pre>";
// print_r($obj->sub);

?>