<?php

include "stud_move_config.php";

session_start();
sfs_check();

$m_arr = get_sfs_module_set();
extract($m_arr, EXTR_OVERWRITE);

$template_dir = $SFS_PATH."/".get_store_path()."/templates";

$template_file=$template_dir."/move_certificate.htm";
// �إߪ���
$obj = new certificate($CONN,$smarty,$IS_JHORES);
$obj->pgp_num=$pgp_num?$pgp_num:'__________';

//���檫��{��

$obj->process();

//��ܪ���,�ɮ׵���
$obj->display($template_file);

/////------------�H�U���{������------------------///


###------------------------    start class�{������---------------------------###
class certificate{

	var $CONN;//ado����
	var $smarty;//smarty����
	var $mv_id;//���ʬy����	
	var $mv_info;
	var $S_id;//�Ǹ�
	var $SN;//�ǥͬy����
	var $base;//�򥻸��
	var $ss_ary;//�ҵ{��ư}�C
	var $seme;//���Ǵ����
	var $seme_info;//���Ǵ����
	var $class_info;//���Ǵ����
	var $class_id;
	var $TB;//���Z��
	var $Score;//���Z
	var $SS;//���Z
	var $tb_width="90%";//���e��
	var $IS_JHORES;
	var $pgp_num;

	function certificate($ADO_obj,$smarty,$IS_JHORES){
		$this->CONN=&$ADO_obj;
		$this->smarty=&$smarty;
		$this->IS_JHORES=&$IS_JHORES;
	}


	function process(){
		if($_GET[mv_id]!='') $this->mv_to_base($_GET[mv_id]);

		}
	function init(){
		}

	function display($tpl){
		//----Smarty����----------//
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
	}
	function mv_to_base($id){
		$SQL="select  b.* from stud_base a ,stud_move b where b.move_id='$id'  and  (b.move_kind='7' or b.move_kind='8') and a.stud_id=b.stud_id  and a.student_sn=b.student_sn  ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$num=$rs->RecordCount();
		if($num!=1) die("�d�L�O��".$id);
		$arr=$rs->GetArray();
		
		$this->mv_id=$id;
		$this->mv_info=$arr[0];//��Ǹ��
		unset($arr);

		$aa=split("-",$this->mv_info[move_date]);
		$this->mv_info[C_move_date]=($aa[0]-1911).".".$aa[1].".".$aa[2];//��Ǹ��
		$this->mv_info[reason2]=$this->mv_info[reason]?$this->mv_info[reason]:"���E�~ ����L:_____________";

		$SQL="select a.*, b.move_year_seme from stud_base a ,stud_move b where b.move_id='$id'  and  (b.move_kind='7' or b.move_kind='8') and a.stud_id=b.stud_id  and a.student_sn=b.student_sn  ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$num=$rs->RecordCount();
		if($num!=1) die("�d�L�O��".$id);
		$arr=$rs->GetArray();
//		$this->mv_info=$arr[0];

		$this->base=$arr[0];//�򥻸�ƪ�
		unset($arr);

		($this->base[stud_sex]=='1')  ? $this->base[C_sex]='�k':$this->base[C_sex]='�k';
		$aa=split("-",$this->base[stud_birthday]);
		$this->base[C_birthday]=($aa[0]-1911).".".$aa[1].".".$aa[2];
		$this->base[C_birthday2]=($aa[0]-1911)."�~".$aa[1]."��".$aa[2]."��";
		$this->Now=array((date("Y")-1911),date("m"),date("d"));
		
		


		$this->S_id=$this->base[stud_id];//�Ǹ�

		$this->SN=$this->base[student_sn];//�ǥͬy����
		$for_seme=sprintf("%04d",$this->mv_info[move_year_seme]);
		$this->seme=$for_seme;
		
		$this->mv_info['school_move_num']=sprintf('%03d',$this->mv_info['school_move_num']);
		

		$SQL="select  seme_year_seme , seme_class, seme_num from stud_seme  where student_sn='".$this->SN."' and seme_year_seme='{$for_seme}' ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		$arr=$rs->GetArray();
		$this->seme_info=$arr[0];
		unset($arr);
		$this->class_id=substr($this->seme_info[seme_year_seme],0,3)."_".substr($this->seme_info[seme_year_seme],3,1)."_".sprintf("%02d",substr($this->seme_info[seme_class],0,1))."_".substr($this->seme_info[seme_class],1,2);
		



		$this->TB="score_semester_".intval(substr($this->seme_info[seme_year_seme],0,3))."_".substr($this->seme_info[seme_year_seme],3,1);
//		echo $this->class_id.$this->TB;
		$SQL="select * from  `{$this->TB}` where student_sn='{$this->SN}' and score!='-100' order by ss_id ,test_sort ";
		$rs=$this->CONN->Execute($SQL);// or trigger_error('���Ǵ��S�����Z�O���A�L�k���',256);
		if ($rs){		
			$arr = $rs->GetArray();
			$this->Score=$arr;
			unset($arr);
		}
//		echo "<PRE>";print_r($this->seme_ary);print_r($arr_sco);
		$this->get_subj($this->class_id,"");//�����
		$this->sch_info();//���Ǯո��
		$this->get_abs_rew();//�����m��
		$this->class_info();

		}
function get_abs_rew() {
	$rew=array("1"=>"�j�\\","2"=>"�p�\\","3"=>"�ż�","4"=>"�j�L","5"=>"�p�L","6"=>"ĵ�i");
	$abs=array("1"=>"�ư�","2"=>"�f��","3"=>"�m��","4"=>"���|","5"=>"����","6"=>"��L");
	$SQL="select   seme_year_seme ,stud_id , abs_kind, abs_days from stud_seme_abs  where stud_id='".$this->S_id."' and seme_year_seme='{$this->seme}'  order by abs_kind";
	$rs=$this->CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();
	$V_abs='';
	if($arr!='') {
		for ($i=0;$i<count($arr);$i++){
			$V_abs[$i][abs]=$abs[$arr[$i][abs_kind]];
			$V_abs[$i][val]=$arr[$i][abs_days];
		}
	}
	$this->stu_abs=$V_abs;
	$arr='';
	$SQL="select    seme_year_seme, stud_id , sr_kind_id, sr_num  from stud_seme_rew where stud_id='".$this->S_id."' and seme_year_seme='{$this->seme}'  order by sr_kind_id ";
	$rs=$this->CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();
	$V_abs='';
	if($arr!='') {
		for ($i=0;$i<count($arr);$i++){
			$V_abs[$i][rew]=$rew[$arr[$i][sr_kind_id]];
			$V_abs[$i][val]=$arr[$i][sr_num];
		}
	}
	$this->stu_rew=$V_abs;
//	echo "<PRE>";
//print_r($this->stu_rew);
}



function get_subj($class_id,$type='') {
//global $CONN ;
	switch ($type) {
		case 'all':
		$add_sql=" ";break;
		case 'seme':
		$add_sql=" and need_exam='1' and enable='1' ";break;//�����Z��
		case 'stage':
		$add_sql=" and need_exam='1'  and print='1' and enable='1' ";break;//���q��,����
		case 'no_test':
		$add_sql=" and need_exam='1'  and print!='1' and enable='1' ";break; //���άq�Ҫ�
		default:
		$add_sql=" and enable='1' ";break;
	} 
	$CID=split("_",$this->class_id);//093_1_01_01
	$year=$CID[0];
	$seme=$CID[1];
	$grade=$CID[2];
	$class=$CID[3];
	$CID_1=$year."_".$seme."_".$grade."_".$class;

	$SQL="select * from score_ss where class_id='$CID_1' $add_sql  and  rate > 0  order by sort,sub_sort ";
	$rs=$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);

	if ($rs->RecordCount()==0){
		$SQL="select * from score_ss where class_id='' and year='".intval($year)."' and semester='".intval($seme)."' and  class_year='".intval($grade)."' $add_sql order by sort,sub_sort ";
		$rs=$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		$All_ss=$rs->GetArray();
	}
	else{$All_ss=$rs->GetArray();}
//echo $SQL;
	$subj_name=$this->initArray("subject_id,subject_name","select * from score_subject ");
	$obj_SS=array();
	//echo "<PRE>BB<BR>";

	for($i=0;$i<count($All_ss);$i++){
		$key=$All_ss[$i][ss_id];//����
		// $obj_SS[$key]=$All_ss[$i];//�����}�C,�Ȥ���
		$obj_SS[$key][rate]=$All_ss[$i][rate];//�[�v
		$obj_SS[$key][sc]=$subj_name[$All_ss[$i][scope_id]];//���W��
		$obj_SS[$key][sb]=$subj_name[$All_ss[$i][subject_id]];//��ئW��
		($obj_SS[$key][sb]=='') ? $obj_SS[$key][sb]=$obj_SS[$key][sc]:"";
	}
	//die("�L�k�d�ߡA�y�k:".$SQL);

//-------��z������������榡----------------//
	for($i=0;$i<count($All_ss);$i++){
		$TD=$All_ss[$i][scope_id];
		$tmp_scop[$TD][ss_id][]=$All_ss[$i][ss_id];
	}
	foreach ($tmp_scop as $key =>$ary){
		if(count($ary[ss_id])>1) {
			$tmp_scop[$key][H]=count($ary[ss_id]);
		}
	}
	foreach ($tmp_scop as $key =>$ary){
		$i=0;
		foreach ($ary[ss_id] as $ss_id){
			if($i==0 && $tmp_scop[$key][H]!='') {
				$obj_SS[$ss_id][H]=$tmp_scop[$key][H];
				}
			if($i==0 && $tmp_scop[$key][H]=='') {
				$obj_SS[$ss_id][H]='W';
				}
		$i++;
		}

	}
//	echo "<PRE>BB<BR>";print_r($obj_SS);
	$this->SS=$obj_SS;
}



function initArray($F1,$SQL){
//	global $CONN ;
	$col=split(",",$F1);
	$key_field=$col[0];
	$value_field=$col[1];

	$rs = $this->CONN->Execute($SQL) or die($SQL);
	$sch_all = array();
	if (!$rs) {
		Return $this->CONN->ErrorMsg(); 
	} else {
		while (!$rs->EOF) {
		$sch_all[$rs->fields[$key_field]]=$rs->fields[$value_field]; 
		$rs->MoveNext(); // ���ܤU�@���O��
		}
	}
	Return $sch_all;
}


function Score($ssid){
	foreach ($this->Score as $ary){
		if($ary[ss_id]==$ssid ) $sco[]=$ary;
	}
	foreach ($sco as $ary2){
		if($ary2[test_kind]=='�w�����q' && $ary2[test_sort]==1) $view[1]=$ary2[score];
		if($ary2[test_kind]=='���ɦ��Z' && $ary2[test_sort]==1) $view[2]=$ary2[score];
		if($ary2[test_kind]=='�w�����q' && $ary2[test_sort]==2) $view[3]=$ary2[score];
		if($ary2[test_kind]=='���ɦ��Z' && $ary2[test_sort]==2) $view[4]=$ary2[score];
		if($ary2[test_kind]=='�w�����q' && $ary2[test_sort]==3) $view[5]=$ary2[score];
		if($ary2[test_kind]=='���ɦ��Z' && $ary2[test_sort]==3) $view[6]=$ary2[score];
		if($ary2[test_kind]=='���Ǵ�' && $ary2[test_sort]==255) $view[all]=$ary2[score];
	}
//	echo "<PRE>BB<BR>";print_r($view);
return $view;
}

function num_tw($num, $type=0) {
	$num_str[0] = "�Q�ʤd";
	$num_str[1] = "�B�եa";
	$num_type[0]='�s�@�G�T�|�����C�K�E';
	$num_type[1]='�s���L�Ѹv��m�èh';
	$num = sprintf("%d",$num);
	while ($num) {
		$num1 = substr($num,0,1);
		$num = substr($num,1);
		$target .= substr($num_type[$type], $num1*2, 2);
		if (strlen($num)>0) $target .= substr($num_str[$type],(strlen($num)-1)*2,2);
	}
	return $target;
}

function sch_info() {
	$SQL="SELECT * FROM `school_base` ";
	$rs = $this->CONN->Execute($SQL) or die($SQL);
	$arr = $rs->GetArray();
	$this->sch_info=$arr[0];
}
function class_info() {
	$SQL="SELECT * FROM `school_class`  where class_id='{$this->class_id}' and  enable='1' ";
	$rs = $this->CONN->Execute($SQL) or die($SQL);
	$arr = $rs->GetArray();
//echo "$SQL";
	$this->class_info=$arr[0];

	//$this->class_info[year]=$this->num_tw($arr[0][year],0);
	//$this->class_info[semester]=$this->num_tw($arr[0][semester],0);
	$this->class_info[year]=$arr[0][year];
	$this->class_info[semester]=$arr[0][semester];
	$this->class_info[c_year]=$this->num_tw(($arr[0][c_year]-$this->IS_JHORES),0);

}


###------------------------    end class---------------------------###
}


/*
////�ѦҥΪk���
while ($ro=$rs->FetchNextObject(false)) {
  $arr[$ro->id]=get_object_vars($ro);
  $arr[$ro->id]=$ro->cname;
}
while( $ar = $rs->FetchRow() ) {
	    print $ar['name'] ." " . $ar['year'];
	}

*/

?>
