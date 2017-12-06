<?php
//$Id: chc_score_memo.php 5310 2009-01-10 07:57:56Z hami $
require_once("config.php");
//include_once "../../include/config.php";
include_once "../../include/sfs_case_dataarray.php";
//�ϥΪ̻{��
sfs_check();

$summary=array();

$obj=new sendmit();
$obj->CONN=&$CONN;
$obj->smarty=&$smarty;
$obj->IS_JHORES=&$IS_JHORES;
$obj->process();//�{��

head("�X�ͰO��_��");//���Y
//�Ҳտ��
print_menu($menu_p);
$obj->display();//��ܺ���
foot();//���


class sendmit{
   var $CONN;//ADO
   var $smarty;
   var $IS_JHORES;//�ꤤ�p�P�_�Ѽ�
   var $year;//�~
   var $seme;//�Ǵ�
   var $stu;//�ǥ͸��
   var $YS_ary;//�Ǵ��}�C
   var $YC_ary;//�~�Z�}�C
   var $year_seme;//�U�Ԧ����Ǵ����ڼƭ�95_1,�ǫ׻P�Ǵ�
   var $class_id;// �ثe���~�Z,�U�Ԧ����Z�Ū��ڼƭ�095_1_04_02


function process() {
	global $summary;
	$this->init();

	$this->YS_ary=$this->sel_year();//�Ǵ��}�C
	$this->YC_ary=$this->grade();//�~�ůZ�Ű}�C

	if ( $_GET['class_id']!=''){
		$this->get_stu();
		$this->get_sco();
		}
}

function init() {
	($_GET[year_seme]=='') ? $this->year_seme=$_POST[year_seme]:$this->year_seme=$_GET[year_seme];
	if ($this->year_seme=='') $this->year_seme=curr_year()."_".curr_seme();
	($_GET[class_id]=='') ? $this->class_id=$_POST[class_id]:$this->class_id=$_GET[class_id];
	
	//($_GET[SSID]=='' ) ? $this->SSID=$_POST[SSID]:$this->SSID=$_GET[SSID];
	$tmp=split("_",$this->year_seme);
   $this->year=$tmp[0];
   $this->seme=$tmp[1]; 

}
//���
function display(){
//include_once "module-cfg.php";
	GLOBAL $summary;
	if ($this->tpl=='') $this->tpl=dirname(__file__)."/chc_talk_all.htm";
		$this->smarty->assign("this",$this);
		$this->smarty->assign("summary",$summary);
		$this->smarty->display($this->tpl);
}
//��s
function update_memo(){

}

//���ǥ�
function get_stu(){
		$stud_coud=study_cond();//���y��ƥN�X
		$CID=split("_",$this->class_id);//093_1_01_01
		$year=$CID[0];
		$seme=$CID[1];
		$grade=$CID[2];//�~��
		$class=$CID[3];//�Z��
		$CID_1=$year.$seme;
		$CID_2=sprintf("%03d",$grade.$class);
		$SQL="select a.stud_id,a.student_sn,a.stud_name,a.stud_sex,
		b.seme_year_seme,b.seme_class,b.seme_num,a.stud_study_cond  
		from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$CID_1' and b.seme_class='$CID_2' $add_sql order by b.seme_num ";
		$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		$obj_stu=array();
		while ($rs and $ro=$rs->FetchNextObject(false)) {
			$obj_stu[$ro->student_sn] = get_object_vars($ro);
			$obj_stu[$ro->student_sn][cond] =$stud_coud[$ro->stud_study_cond];
			//�Ǹ����
			$stud_id[$ro->student_sn]=$ro->stud_id;
			$SN_ary[]=$ro->student_sn;
		}
		$this->SN_ary=$SN_ary;
		$this->stu=$obj_stu;
		$this->Stu_id=$stud_id;
	}

	//���Z�Ҧ��X�ͰO��
	function get_sco(){
		GLOBAL $summary;
		$stu=join(",",$this->Stu_id);
		$YS=sprintf("%03d",$this->year).$this->seme;
		$SQL = "select *,b.name  from stud_seme_talk a 
		left join teacher_base b on a.teach_id=b.teacher_sn 
		where a.seme_year_seme ='$YS' and a.stud_id in ($stu) 
		order by a.sst_date ,a.sst_id desc";
		$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL."�i��O�ҵ{�εL�ǥ͸��");//echo $SQL;
		$All_sco=&$rs->GetArray();
		//print_r($All_sco);
		foreach ($All_sco as $ary){
			$method=$ary['interview_method'];
			$summary[$method]++;
			$stud_id=$ary['stud_id'];
			$sco[$stud_id][]=$ary;
			}
		$this->sco=$sco;
	}

	function get_One($id){
		$A['tol']=count($this->sco[$id]);
		$A['event']=$this->sco[$id];
		return $A;
		}




//�~�װ}�C
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

//�Z�Ű}�C
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

//�����
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
	//$en_ary=array(0=>'�L��',1=>'����');
	for($i=0;$i<count($All_ss);$i++){
		$key=$All_ss[$i][ss_id];//����
		//$en=$All_ss[$i][enable];
		$obj_SS[$key]=$All_ss[$i];//�����}�C,�Ȥ���
		//$obj_SS[$key][rate]=$All_ss[$i][rate];//�[�v
		//$obj_SS[$key][scope]=$subj_name[$All_ss[$i][scope_id]];//���W��
		//$obj_SS[$key][subject]=$subj_name[$All_ss[$i][subject_id]];//��ئW��
		//($obj_SS[$key][sb]=='') ? $obj_SS[$key][sb]=$obj_SS[$key][sc]:"";
		$AA=$subj_name[$All_ss[$i][scope_id]];//���W��
		$BB=$subj_name[$All_ss[$i][subject_id]];//��ئW��
		
		$obj_SS[$key][list_name]=$AA."/".$BB;//�����}�C,�Ȥ���
		
	}
	//die("�L�k�d�ߡA�y�k:".$SQL);
	return $obj_SS;
}



}


// echo "<pre>";
// print_r($obj->sub);

