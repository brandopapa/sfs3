<?php
//$Id: chi_dom.php 5310 2009-01-10 07:57:56Z hami $
require_once("stud_reg_config.php");

//�ϥΪ̻{��
sfs_check();


//c_curr_class=095_1_04_05&c_curr_seme=0951

$obj=new stu_photo();
$obj->CONN=&$CONN;
$obj->smarty=&$smarty;
$obj->IS_JHORES=&$IS_JHORES;
//$obj->smarty->assign('modify_flag',$modify_flag);
$obj->process();

head("��Z�s��--��f���");
$linkstr = 'c_curr_class='.$_GET[c_curr_class].'&c_curr_seme='.$_GET[c_curr_seme];
print_menu($menu_p,$linkstr);
$obj->display();

foot();



class stu_photo{
   var $CONN;//ADO
   var $smarty;
   var $IS_JHORES;//�ꤤ�p�P�_�Ѽ�
   var $year;//�~
   var $seme;//�Ǵ�
   var $Y_name='c_curr_seme';//�U�Ԧ����Ǵ����ڼƦW��
   var $S_name='c_curr_class';//�U�Ԧ����Z�Ū��ڼƦW��
   var $YS_ary;//�Ǵ��}�C
   var $YC_ary;//�~�Z�}�C
   var $year_seme;//�U�Ԧ����Ǵ����ڼƭ�95_1
   var $Sel_class;//�U�Ԧ����Z�Ū��ڼƭ�095_1_04_02
  
   function process() {
   	//if ($_POST){echo "<pre>";print_r($_POST);die();}
   	$this->init();
   	$this->Option=&$this->myData();//�{�����
   	if ($_POST[form_act]=='update') $this->update();
   	$this->YS_ary=$this->sel_year();//�Ǵ��}�C
   	$this->YC_ary=$this->grade();//�~�ůZ�Ű}�C

   	if ($this->Sel_class!='') $this->get_stu($this->Sel_class);
   	//$this->display();

   	$stud_coud=study_cond();//���y��ƥN�X
   	foreach ($stud_coud as $tk=>$tv){$stud_coud2[$tk]=$tk.'-'.$tv;}
   	$this->Cond[A]=$stud_coud;
   	$this->Cond[B]=$stud_coud2;
   	
   	
   }

function init() {
	($_GET[$this->Y_name]=='') ? $this->year_seme=$_POST[$this->Y_name]:$this->year_seme=$_GET[$this->Y_name];
	if ($this->year_seme=='') $this->year_seme=sprintf("%04d",curr_year().curr_seme());
	($_GET[$this->S_name]=='') ? $this->Sel_class=$_POST[$this->S_name]:$this->Sel_class=$_GET[$this->S_name];
   $this->year=substr($this->year_seme,0,3);
   $this->seme=substr($this->year_seme,-1);

}
function display(){
	if ($this->tpl=='') $this->tpl=dirname(__file__)."/templates/chi_dom.htm";
		$this->smarty->assign("this",$this);
		$this->smarty->display($this->tpl);
}

function update() {
	//echo "<pre>";print_r($_POST);print_r($_FILES);die();
	//�M�w�ק����
	foreach ($this->Option[txt] as $key=>$null){
		if (count($_POST[$key]) > 0) $AA[]=$key;
		unset($key);
	}
	if (count($AA)==0) return ;
	//��z��SQL�y�k�ð���
	foreach ($_POST[$AA[0]] as $SN =>$null){
		$SQL="update  stud_domicile set ";
		foreach ($AA as $key){$JJ[]=$key."='".$_POST[$key][$SN]."'";}
		$SQL.=join(",",$JJ)." where student_sn='".$SN."'";//echo $SQL."<br>";
		$rs=$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		unset($SQL);unset($JJ);
	} 
	$URL=$_SERVER[PHP_SELF]."?".$this->Y_name."=".$_POST[$this->Y_name]."&".$this->S_name."=".$_POST[$this->S_name];
	Header("Location:$URL");
}


function sel_year() {
	$SQL = "select * from school_day where  day<=now() and day_kind='start' order by day desc ";
	$rs=$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	while(!$rs->EOF){
	$ro = $rs->FetchNextObject(false);
	// ��i$ro=$rs->FetchNextObj()�A���O�ȥΩ�s������adodb�A�ثe��SFS3���A��
	$tmp_y=sprintf("%04d",$ro->year.$ro->seme);
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


function get_stu($class_id,$type='') {
	//echo $class_id;//094_1_01_05
	$tmp=split('_',$class_id);
	$seme=$tmp[0].$tmp[1];
	
	$cla=($tmp[2]+0).$tmp[3];
	$SQL="select a.stud_id,a.student_sn,a.stud_name,a.stud_sex,a.stud_study_cond ,
	b.seme_year_seme,b.seme_class,
	b.seme_num,a.stud_study_year,c.*
	from stud_base a,stud_seme b , stud_domicile c
	where a.student_sn=b.student_sn and
	 a.student_sn=c.student_sn and  
	b.seme_year_seme='$seme' and b.seme_class='$cla'  order by b.seme_num ";
	$rs=$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	$this->stu=$rs->GetArray();

}

	function Radio($name,$sn) {
			$str=$name.'['.$sn.']';
		return $str;
	}

	function myData(){
		//�D�n�����Τ���W�ٹ�M
		$Option[txt]=array(
		'fath_name'=>'��:�m�W','fath_birthyear'=>'��:�X�ͦ~','fath_alive'=>'��:�s�\\',
		'fath_relation'=>'��:���Y','fath_p_id'=>'��:�����Ҹ�','fath_education'=>'��:�Ш|�{��',
		'fath_occupation'=>'��:¾�~','fath_unit'=>'��:�A�ȳ��','fath_work_name'=>'��:¾��',
		'fath_phone'=>'��:�q��(��)','fath_home_phone'=>'��:�q��(�v)','fath_hand_phone'=>'��:���',
		'fath_email'=>'��:�q�l�l��',
		'moth_name'=>'��:�m�W','moth_birthyear'=>'��:�X�ͦ~','moth_alive'=>'��:�s�\\',
		'moth_relation'=>'��:���Y','moth_p_id'=>'��:�����Ҹ�','moth_education'=>'��:�Ш|�{��',
		'moth_occupation'=>'��:¾�~','moth_unit'=>'��:�A�ȳ��','moth_work_name'=>'��:¾��',
		'moth_phone'=>'��:�q��(��)','moth_home_phone'=>'��:�q��(�v)','moth_hand_phone'=>'��:���',
		'moth_email'=>'��:�q�l�l��',
		'guardian_name'=>'��:�m�W','guardian_phone'=>'��:�q��','guardian_address'=>'��:�a�}',
		'guardian_relation'=>'��:���Y','guardian_p_id'=>'��:�����Ҹ�','guardian_unit'=>'��:�A�ȳ��',
		'guardian_work_name'=>'��:¾��','guardian_hand_phone'=>'��:���','guardian_email'=>'��:�q�l�l��',
		'grandfath_name'=>'�����m�W','grandfath_alive'=>'�����s�\\',
		'grandmoth_name'=>'�����m�W','grandmoth_alive'=>'�����s�\\');

		//��������]�w
		$Option[type]=array(
		'fath_name'=>'text','fath_birthyear'=>'text','fath_alive'=>'radio',
		'fath_relation'=>'selectbox','fath_p_id'=>'text','fath_education'=>'selectbox',
		'fath_occupation'=>'text','fath_unit'=>'text','fath_work_name'=>'text',
		'fath_phone'=>'text','fath_home_phone'=>'text','fath_hand_phone'=>'text',
		'fath_email'=>'text',
		'moth_name'=>'text','moth_birthyear'=>'text','moth_alive'=>'radio',
		'moth_relation'=>'selectbox','moth_p_id'=>'text','moth_education'=>'selectbox',
		'moth_occupation'=>'text','moth_unit'=>'text','moth_work_name'=>'text',
		'moth_phone'=>'text','moth_home_phone'=>'text','moth_hand_phone'=>'text',
		'moth_email'=>'text',
		'guardian_name'=>'text','guardian_phone'=>'text','guardian_address'=>'text',
		'guardian_relation'=>'selectbox','guardian_p_id'=>'text','guardian_unit'=>'text',
		'guardian_work_name'=>'text','guardian_hand_phone'=>'text','guardian_email'=>'text',
		'grandfath_name'=>'text','grandfath_alive'=>'radio',
		'grandmoth_name'=>'text','grandmoth_alive'=>'radio');

		//��r���j�p
		$Option[long]=array(
		'fath_name'=>'12','fath_birthyear'=>'6',
		'fath_p_id'=>'12','fath_occupation'=>'12','fath_unit'=>'12','fath_work_name'=>'12',
		'fath_phone'=>'12','fath_home_phone'=>'12','fath_hand_phone'=>'12',
		'fath_email'=>'20',
		'moth_name'=>'12','moth_birthyear'=>'6',
		'moth_p_id'=>'12','moth_occupation'=>'12','moth_unit'=>'12','moth_work_name'=>'12',
		'moth_phone'=>'12','moth_home_phone'=>'12','moth_hand_phone'=>'12',
		'moth_email'=>'20',
		'guardian_name'=>'12','guardian_phone'=>'12','guardian_address'=>'30',
		'guardian_p_id'=>'12','guardian_unit'=>'12',
		'guardian_work_name'=>'12','guardian_hand_phone'=>'12','guardian_email'=>'20',
		'grandfath_name'=>'12','grandmoth_name'=>'12');
		
   	$GR=array(1=>'���l',2=>'���k',3=>'���l',4=>'���k',5=>'���]',6=>'�S��',7=>'�S�f',8=>'�j��',9=>'�n�f',10=>'�B���h���c',11=>'��L');
   	$MR=array(1=>'�ͥ�',2=>'�i��',3=>'�~��');
   	$FR=array(1=>'�ͤ�',2=>'�i��',3=>'�~��');
   	$Live=array(1=>'�s',2=>'�\\');
   	$Edu=array(1=>'�դh',2=>'�Ӥh',3=>'�j��',4=>'�M��',5=>'����',6=>'�ꤤ',7=>'��p���~',8=>'��p�w�~',9=>'�Ѧr(���N��)',10=>'���Ѧr');
 
		//�U�Ԧ�����RadioCheck�ﶵ��Ƴ]�w
		$Option[ary]=array(
		'fath_alive'=>$Live,
		'fath_relation'=>$FR,
		'fath_education'=>$Edu,
		'moth_alive'=>$Live,
		'moth_relation'=>$MR,
		'moth_education'=>$Edu,
		'guardian_relation'=>$GR,
		'grandfath_alive'=>$Live,
		'grandmoth_alive'=>$Live);
		return $Option;
	}

}//end class 





