<?php
//$Id: chc_score_memo.php 5310 2009-01-10 07:57:56Z hami $
require_once("config.php");
//include_once "../../include/config.php";
//include_once "../../include/sfs_case_dataarray.php";



//�ϥΪ̻{��
sfs_check();




$obj=new sendmit();
$obj->CONN=&$CONN;
$obj->smarty=&$smarty;
$obj->IS_JHORES=&$IS_JHORES;
$obj->process();//�{��

head("�U����y");//���Y
print_menu($school_menu_p);//���
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
	$this->init();
	if ($_POST[form_act]=='update_memo') $this->update_memo();
	$this->YS_ary=$this->sel_year();//�Ǵ��}�C
	$this->YC_ary=$this->grade();//�~�ůZ�Ű}�C
	if ($this->class_id!='') $this->sub=$this->get_subj($this->class_id);
	if ($_GET[SSID]!='' && $_GET[class_id]!=''){
		$this->get_stu();
		$this->get_sco();
		}
	//	$this->display();
}

function init() {
	($_GET[year_seme]=='') ? $this->year_seme=$_POST[year_seme]:$this->year_seme=$_GET[year_seme];
	if ($this->year_seme=='') $this->year_seme=curr_year()."_".curr_seme();
	($_GET[class_id]=='') ? $this->class_id=$_POST[class_id]:$this->class_id=$_GET[class_id];
	
	($_GET[SSID]=='' ) ? $this->SSID=$_POST[SSID]:$this->SSID=$_GET[SSID];
	 $tmp=split("_",$this->year_seme);
   $this->year=$tmp[0];
   $this->seme=$tmp[1]; 

}
//���
function display(){
//include_once "module-cfg.php";
	if ($this->tpl=='') $this->tpl=dirname(__file__)."/templates/chc_score_memo.htm";
		$this->smarty->assign("this",$this);		
		$this->smarty->display($this->tpl);		
}
//��s
function update_memo(){
//$_POST[memo]=='' ||
//echo "<pre>";
//print_r($_POST);die();
	if ( $_POST[year_seme]==''|| $_POST[SSID]==''||$_POST[class_id]=='') return ;
	foreach ($_POST[memo] as $key =>$val ){
		if ($key=='') continue ;
		$SQL="update stud_seme_score set ss_score_memo='{$val}' where sss_id='{$key}' and ss_id ='{$_POST[SSID]}'  ";	
		$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);	
	}
	
	$URL=$_SERVER[PHP_SELF]."?year_seme=".$_POST[year_seme]."&class_id=".$_POST[class_id]."&mods=".$_POST[mods]."&SSID=".$_POST[SSID];
	Header("Location:".$URL);
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
		$SQL="select 	a.stud_id,a.student_sn,a.stud_name,a.stud_sex,
		b.seme_year_seme,b.seme_class,b.seme_num,a.stud_study_cond  
		from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$CID_1' and b.seme_class='$CID_2' $add_sql order by b.seme_num ";
		$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		$obj_stu=array();
		while ($rs and $ro=$rs->FetchNextObject(false)) {
			$obj_stu[$ro->student_sn] = get_object_vars($ro);
			$obj_stu[$ro->student_sn][cond] =$stud_coud[$ro->stud_study_cond];
			$SN_ary[]=$ro->student_sn;
		}
		$this->SN_ary=$SN_ary;
		$this->stu=$obj_stu;
	}

	//����Ҧ����Z
	function get_sco(){

		$stu=join(",",$this->SN_ary);
		$YSeme=split("_",$this->class_id);
		
		$SQL="select  sss_id,seme_year_seme,student_sn,ss_id,
		 	  ss_score, ss_score_memo from `stud_seme_score` where  student_sn in ($stu) and  ss_id ='{$this->SSID}' ";
		$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL."�i��O�ҵ{�εL�ǥ͸��");//echo $SQL;
		$All_sco=&$rs->GetArray();
//		print_r($All_sco);
		foreach ($All_sco as $ary){
			$sn=$ary[student_sn];
			$sco[$sn]=$ary;
			}

		$this->sco=$sco;
//		print_r($Vsco);
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

?>