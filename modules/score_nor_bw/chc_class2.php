<?php
//$Id: chc_class2.php 5310 2009-01-10 07:57:56Z hami $
//////// 94.01.04 ��Z�� class
//---�Ʀr���r
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

#################### 93.12.30  �s�W ####################
//--- ���o�Ǧ~�׻P�Ǵ����}�C
//--- �}�C�榡 array('0922'=>'92�Ǧ~�ײĤG�Ǵ�')
function year_seme_ary() {
	global $CONN;
	$sql = "select year,seme from school_day group by year,seme order by year desc,seme desc";
	$rs = $CONN->Execute($sql);
	while ($rs and $ro=$rs->FetchNextObject()) {
		$key = sprintf("%03d%1d", $ro->YEAR, $ro->SEME);
		$val = sprintf("%d �Ǧ~�ײ� %d �Ǵ�", $ro->YEAR, $ro->SEME);
		$arys[$key]=$val;
	}
	return $arys;
}
//--- ���o���w�Ǧ~�ξǴ����~�ŤίZ�Ű}�C
function sch_class_name($curr_year, $curr_seme,$c_year='') {
	global $CONN, $IS_JHORES;
	if (empty($curr_year)) $curr_year=curr_year();
	if (empty($curr_seme)) $curr_seme=curr_seme();
	//---���o�U�~�Ū��Z�ŦW�ٰ}�C
	$sql = "select class_id,c_name from school_class where year='{$curr_year}' and semester='{$curr_seme}' order by class_id";
	if (!empty($c_year)) {
		$sql = "select class_id,c_name from school_class where year='{$curr_year}' and 		semester='{$curr_seme}' and c_year='{$c_year}' order by class_id";
	}

	$rs = $CONN->Execute($sql);
	while ($rs and $ro=$rs->FetchNextObject() ){
		$arys[$ro->CLASS_ID]=$ro->C_NAME;
	}
	$rs->Close();
	return $arys;

}


######################    score_level�禡     #############################

function score_level($class_id) {

	global $CONN;


	$aryrules = array();

	list($year, $seme, $grade, $clano)=explode("_",$class_id);
	 $sql = "select rule from score_setup where year='{$year}' and
  semester='{$seme}' and class_year='{$grade}'";

	//print "<br> ".$sql;

	$rs = $CONN->Execute($sql);

	if ($ro=$rs->FetchNextObject()) {
		$rules = explode("\n", $ro->RULE);
		for ($i=0; $i<count($rules); $i++)
			$aryrules[$i]=explode("_", $rules[$i]);
	}
		
	return $aryrules;
	
}

##################  ��Ƥ��Ƭ����Ī��禡 ##############################
function score2level($score, $aryrules) {

	$level='';
	for ($i=0; $i<count($aryrules); $i++) {

		$retstr=$aryrules[$i][0];
		$chkop=trim($aryrules[$i][1]);
		$score_level = (float) $aryrules[$i][2];
		$score = (float) $score;

	if ($chkop=='>='  && $score >= $score_level) return $retstr;
	elseif ($chkop=='>' && $score > $score_level) return $retstr;
	elseif (($chkop=='==' or $chkop=='=') &&$score == $score_level) return $retstr;
	elseif ($chkop=='<=' && $score <= $score_level) return $retstr;
	elseif ($chkop=='<' && $score < $score_level) return $retstr;

	}

	return $level;

	}

########- get_subj ���o�ӯZ�Ҧ��b�y�ǥͥH�ǥͬy������key ���禡 --------#################

function get_stu($class_id,$type="0") {
	global $CONN ;
	
//�P�_�O�_�b�y
	($type==0) ? $add_sql=" and a.stud_study_cond=0 ":$add_sql=" ";


	$CID=split("_",$class_id);//093_1_01_01
	$year=$CID[0];
	$seme=$CID[1];
	$grade=$CID[2];//�~��
	$class=$CID[3];//�Z��
	$CID_1=$year.$seme;
	$CID_2=sprintf("%03d",$grade.$class);
	$SQL="select 	a.stud_id,a.student_sn,a.stud_name,a.stud_sex,b.seme_year_seme,b.seme_class,b.seme_num from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$CID_1' and b.seme_class='$CID_2' $add_sql order by b.seme_num ";
	$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	$obj_stu=array();
	while ($rs and $ro=$rs->FetchNextObject(false)) {
		$obj_stu[$ro->student_sn] = get_object_vars($ro);
	}
	
	/*
	$All_stu=$rs->$rs->GetArray();
	$obj_stu=array();
	for($i=0;$i<count($All_stu);$i++){
		$key=$All_stu[$i][student_sn];
		$obj_stu[$key]=$All_stu[$i];
	}
	print "<pre>";
	print_r($obj_stu);
	print "</pre>";
	*/
	return $obj_stu;
}


########- get_subj ���o�ӯZ�Ҧ��b�y�ǥͥH�ǥͬy������key ���禡 --------#################
########-      get_subj  ���o�ӯZ�Ҧ�SS_ID��ئW�٨禡 --------#################
##   $type=all����,seme���Ǵ����Z,stage���q��,no_test�����q��
##    �p��need_exam  ����print  �[�v
function get_subj($class_id,$type='') {
global $CONN ;
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
	$CID=split("_",$class_id);//093_1_01_01
	$year=$CID[0];
	$seme=$CID[1];
	$grade=$CID[2];
	$class=$CID[3];
	$CID_1=$year."_".$seme."_".$grade."_".$class;

	$SQL="select * from score_ss where class_id='$CID_1' $add_sql order by sort,sub_sort ";
	$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);

	if ($rs->RecordCount()==0){
		$SQL="select * from score_ss where class_id='' and year='".intval($year)."' and semester='".intval($seme)."' and  class_year='".intval($grade)."' $add_sql order by sort,sub_sort ";
		$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		$All_ss=$rs->GetArray();
	}
	else{$All_ss=$rs->GetArray();}

	$subj_name=initArray("subject_id,subject_name","select * from score_subject ");
	$obj_SS=array();

	for($i=0;$i<count($All_ss);$i++){
		$key=$All_ss[$i][ss_id];//����
		// $obj_SS[$key]=$All_ss[$i];//�����}�C,�Ȥ���
		$obj_SS[$key][rate]=$All_ss[$i][rate];//�[�v
		$obj_SS[$key][sc]=$subj_name[$All_ss[$i][scope_id]];//���W��
		$obj_SS[$key][sb]=$subj_name[$All_ss[$i][subject_id]];//��ئW��
		($obj_SS[$key][sb]=='') ? $obj_SS[$key][sb]=$obj_SS[$key][sc]:"";
	}
	//die("�L�k�d�ߡA�y�k:".$SQL);
	return $obj_SS;
}

##################  �򥻤u�� initArray��Ƹ�Ƭ����޻P�a�Ȩ禡 #######################
## �����ƪ���A������,��B����,��A���O�ߤ@
## �ϥή� �ǤJ $F1���r��==>subject_id,subject_name
## �ϥή� �ǤJ $SQL����Ʈw�y�k
##################  �򥻤u�� initArray��Ƹ�Ƭ����޻P�a�Ȩ禡 #######################

function initArray($F1,$SQL){
	global $CONN ;
	$col=split(",",$F1);
	$key_field=$col[0];
	$value_field=$col[1];

	$rs = $CONN->Execute($SQL) or die($SQL);
	$sch_all = array();
	if (!$rs) {
		Return $CONN->ErrorMsg(); 
	} else {
		while (!$rs->EOF) {
		$sch_all[$rs->fields[$key_field]]=$rs->fields[$value_field]; 
		$rs->MoveNext(); // ���ܤU�@���O��
		}
	}
	Return $sch_all;
}



class data_class  {
	var $class_id;
	var $stud_base;
	var $subject_nor=array(
		"nor_score"=>"�ͬ���{(��)"
		,"nor_level"=>"�ͬ���{(��)"
		,"nor_memo"=>"�ͬ���{(��)"
		,"nor1"=>"���`�欰"
		,"nor2"=>"���鬡��"
		,"nor3"=>"���@�ư�"
		,"nor4"=>"�ե~��{"); //--- �ͬ���{���N���Τ�r�C
	var $subject_abs=array(
		"abs1"=>"�ư�"
		,"abs2"=>"�f��"
		,"abs3"=>"�m��"
		,"abs4"=>"�ɭ��X"
		,"abs5"=>"����"
		,"abs6"=>"�ల(�䥦)"); //--- ���m�Ҫ��N���Τ�r�C
	var $subject_rew=array(
		"sr1"=>"�j�\\"
		,"sr2"=>"�p�\\"
		,"sr3"=>"�ż�"
		,"sr4"=>"�j�L"
		,"sr5"=>"�p�L"
		,"sr6"=>"ĵ�i"); //--- ���g���N���Τ�r�C
	var $subject_score_nor=array( //-- score2--5  �����鬡�ʦ��Z
		"score1"=>"�ɮv����"
		,"score2"=>"�Z�Ŭ���"
		,"score3"=>"���ά���"
		,"score4"=>"�۪v����"
		,"score5"=>"�Ҧ次��"
		,"score6"=>"���@�A��"
		,"score7"=>"�ե~�S���{");

	function seme_score_nor($class_id) {
		global $CONN;
		
		if (empty($class_id)) $class_id=$this->class_id;
		list($year,$seme,$grade,$clano)=explode("_",$class_id);
		$year_seme=sprintf("%03d%1d",$year,$seme);
		$seme_class = sprintf("%d%02d",$grade,$clano);
		$sql =  "select stud_seme.student_sn, score1,score2,score3,score4,score5,score6,score7 
			from stud_seme
			left join seme_score_nor on(stud_seme.stud_id=seme_score_nor.stud_id
				and stud_seme.seme_year_seme=seme_score_nor.seme_year_seme)
			where stud_seme.seme_year_seme='{$year_seme}' 
				and stud_seme.seme_class='{$seme_class}' 
			order by stud_seme.student_sn ";

		$rs = $CONN->Execute($sql) or die("die:".$sql);
		while ($rs and $ro = $rs->FetchNextObject(false)) {
			$arys[$ro->student_sn]=get_object_vars($ro);
		}
		$rs->Close();
		
		return $arys;

		
}
	
	function seme_score($class_id) {
		global $CONN;
		
		if (empty($class_id)) $class_id=$this->class_id;
		list($year,$seme,$grade,$clano)=explode("_",$class_id);
		$year_seme=sprintf("%03d%1d",$year,$seme);
		$seme_class = sprintf("%d%02d",$grade,$clano);
		
		$sql =  "select stud_seme.student_sn, ss_id,ss_score,ss_score_memo
			from stud_seme
			left join stud_seme_score on(stud_seme.student_sn=stud_seme_score.student_sn
				and stud_seme.seme_year_seme=stud_seme_score.seme_year_seme)
			where stud_seme.seme_year_seme='{$year_seme}' 
				and stud_seme.seme_class='{$seme_class}' 
			order by stud_seme.student_sn ";
		//print "<br> $sql";
		//$CONN->debug=true;
		$rs = $CONN->Execute($sql) or die("die:".$sql);
		while ($rs and $ro = $rs->FetchNextObject(false)) {
			$arys[$ro->student_sn][$ro->ss_id][score]=ceil($ro->ss_score);
			$arys[$ro->student_sn][$ro->ss_id][memo]=$ro->ss_score_memo;
		}
		$rs->Close();

		$sql =  "select stud_seme.student_sn, ss_id,ss_val
			from stud_seme
			left join stud_seme_score_oth on(stud_seme.stud_id=stud_seme_score_oth.stud_id
				and stud_seme.seme_year_seme=stud_seme_score_oth.seme_year_seme)
			where stud_seme.seme_year_seme='{$year_seme}' 
				and stud_seme.seme_class='{$seme_class}' and ss_kind='�V�O�{��'  
			order by stud_seme.student_sn ";

		$rs = $CONN->Execute($sql);
		while ($rs and $ro = $rs->FetchNextObject(false)) {
			$arys2[$ro->student_sn][$ro->ss_id][oth]=$ro->ss_val;
		}
		
		foreach($arys as $student_sn=>$stud) {
			foreach($stud as $ss_id=>$data) {
				$arys[$student_sn][$ss_id][oth]=$arys2[$student_sn][$ss_id][oth];
				$arys[$student_sn][$ss_id][level]=score2level($arys[$student_sn][$ss_id][score],$this->level_ary);
			}
		}
		
		//print "<pre>";
		//print_r($arys2);
		
		$arys2 = array();
		$sub_ary = get_subj($class_id,'seme');
		//print "<br><pre>  1234";
		//print_r($sub_ary);
		 
		foreach ($this->stud_base as $student_sn=>$stud) {
			foreach ($sub_ary as $ss_id=>$sub) {
				//$arys[$student_sn][$ss_id][rate]=$sub_ary[$ss_id][rate];
				$arys2[$student_sn][$ss_id]=$arys[$student_sn][$ss_id];
			}
		}
		
		
		return $arys2;
	}

	function seme_scope($class_id) {
		if (empty($class_id)) $class_id = $this->class_id;
		$score_ary = $this->seme_score();
		$sub_ary = get_subj($class_id,'seme');
		//--- ���o�C�ӻ�쪺��ذ}�C
		foreach ($sub_ary as $ss_id=>$sub) {
			$arys[$sub[sc]][]=$ss_id;
		}
		
		foreach ($score_ary as $student_sn=>$stud) {
			$score = '';
			foreach($arys as $sc=>$sc_ary) {
				//--- �ӻ��W�L�@�Ӭ�ت��~�p�⥭��
				$sum = 0;
				$rate = 0;
				$items = 0;
				$ary2 = array();
				foreach ($sc_ary as $ss_id) {
					$ary2[$ss_id]=$score_ary[$student_sn][$ss_id];	
					$ary2[$ss_id][rate]=$sub_ary[$ss_id][rate];	
					$ary2[$ss_id][sb]=$sub_ary[$ss_id][sb];	
					$rate += $sub_ary[$ss_id][rate];
					$sum += $score_ary[$student_sn][$ss_id][score]*$sub_ary[$ss_id][rate];
					$items++;
				}
				//--- �ӻ��W�L�@�Ӭ�ت��~�p�⥭��
				if ($items>1) {
					$ary2[avg][score]=ceil($sum/$rate);
					$ary2[avg][rate]=$rate;
					$ary2[avg][sb]='����';
					$ary2[avg][level]=score2level(ceil($sum/$rate),$this->level_ary);
				}
				$score[$sc][scope_name]=$sc;
				$score[$sc][items]=$items;
				$score[$sc][detail]=$ary2;
				
			}
			$ary3[$student_sn]			=$score;
		}
		
		return $ary3;	
	}

  function seme_absent($class_id) {
  		global $CONN;
  	
		if (empty($class_id)) $class_id=$this->class_id;
		list($year,$seme,$grade,$clano)=explode("_",$class_id);
		
		$seme_year_seme = sprintf("%03d%1d",$year,$seme);
		$seme_class = sprintf("%1d%02d",$grade,$clano);
		
		$sql = "select stud_seme.student_sn , stud_seme_abs.abs_kind , stud_seme_abs.abs_days
		        from stud_seme 
		        left join stud_seme_abs on(stud_seme.stud_id=stud_seme_abs.stud_id 
		        	and stud_seme.seme_year_seme=stud_seme_abs.seme_year_seme)
		        where stud_seme_abs.seme_year_seme='{$seme_year_seme}' 
		        	and stud_seme.seme_class='{$seme_class}' 
		        order by stud_seme.student_sn  , stud_seme_abs.abs_kind ";

		//$CONN->debug=true;
		$rs = $CONN->Execute($sql);
		//$CONN->debug=false;
		while ($rs and $ro = $rs->FetchNextObject(false)) {
			$arys[$ro->student_sn]["abs{$ro->abs_kind}"]=$ro->abs_days;
		}		
		//print_r($arys);
		return $arys ;
 	
  }

//--���o�Y�@�Z�����g���
//--$class_id �Z�ťN��
function seme_rew($class_id) {
	global $CONN;

	if (empty($class_id)) $class_id = $this->class_id;
	list($year,$seme,$grade,$clano)=explode("_",$class_id);
	$seme_year_seme=sprintf("%03d%d",$year,$seme);
	$seme_class = sprintf("%d%02d",$grade,$clano);
	$sql = "select 
	stud_seme.student_sn,stud_seme_rew.sr_kind_id
	,stud_seme_rew.sr_num
	from stud_seme 
	left join stud_seme_rew 
	on (stud_seme.stud_id=stud_seme_rew.stud_id 
	and stud_seme_rew.seme_year_seme='{$seme_year_seme}' ) 
	left join stud_base on (stud_seme.student_sn=stud_base.student_sn) 
	
	where stud_seme.seme_year_seme='{$seme_year_seme}' and stud_seme.seme_class='{$seme_class}' and (stud_base.stud_study_cond='0' or stud_base.stud_study_cond='2')  
	order by stud_seme.student_sn, stud_seme_rew.sr_kind_id";

	//$CONN->debug=true;
	$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
	$rs = $CONN->Execute($sql);

	while ($ro = $rs->FetchNextObject()) {
		if (!empty($ro->SR_KIND_ID) and $ro->SR_KIND_ID>='1' and $ro->SR_KIND_ID<='6') 
			$arys["$ro->STUDENT_SN"]["sr".$ro->SR_KIND_ID] =$ro->SR_NUM; 
	}
	return $arys;
}



function seme_nor($class_id) {
	global $CONN;

	$level_arys=score_level($class_id);

	if (empty($class_id)) $class_id = $this->class_id;
	list($year,$seme,$grade,$clano)=explode("_",$class_id);
	$seme_year_seme=sprintf("%03d%d",$year,$seme);
	$seme_class = sprintf("%d%02d",$grade,$clano);
	$sql = "select 
	stud_seme.student_sn,stud_seme_score_nor.ss_score
	,stud_seme_score_nor.ss_score_memo
	from stud_seme 
	left join stud_seme_score_nor 
	on (stud_seme.student_sn=stud_seme_score_nor.student_sn 
	and stud_seme_score_nor.ss_id='0' 
	and stud_seme_score_nor.seme_year_seme='{$seme_year_seme}') 
	left join stud_base on (stud_seme.student_sn=stud_base.student_sn) 

	where stud_seme.seme_year_seme='{$seme_year_seme}' and stud_seme.seme_class='{$seme_class}'  and (stud_base.stud_study_cond='0' or stud_base.stud_study_cond='2') order by stud_seme.student_sn";

	$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
	$rs = $CONN->Execute($sql);
   // $level_arys=score_level($class_id);
	while ($ro = $rs->FetchNextObject()) {
		$arys["$ro->STUDENT_SN"] = array(
			"nor_score"=>($ro->SS_SCORE > 100 ? 100 : ceil($ro->SS_SCORE))
			,"nor_level"=>score2level(ceil($ro->SS_SCORE),$this->level_ary) 
			,"nor_memo"=>$ro->SS_SCORE_MEMO);
    }
	
	for ($ss_id=1; $ss_id<=4; $ss_id++) {
		$sql = "select
		stud_seme.student_sn,stud_seme_score_oth.ss_val
		from stud_seme 
		left join stud_seme_score_oth 
		on (stud_seme.stud_id=stud_seme_score_oth.stud_id 
		and stud_seme_score_oth.ss_id='{$ss_id}' 
		and stud_seme_score_oth.seme_year_seme='{$seme_year_seme}') 
		where stud_seme.seme_year_seme='{$seme_year_seme}' and stud_seme.seme_class='{$seme_class}' order by stud_seme.student_sn";

		$rs=$CONN->Execute($sql);
		while ($ro=$rs->FetchNextObject()) {
			//print "<br> test $ro->STUDENT_SN -- $ro->SS_VAL";
			$arys["$ro->STUDENT_SN"]["nor".$ss_id]=$ro->SS_VAL;
		}

	}

	return $arys;
}   



	function data_class($class_id)  {
		if (!empty($class_id)) {
			$this->class_id = $class_id;
			$this->stud_base = get_stu($class_id);
			$this->level_ary=score_level($class_id);
		}
	}
	
}
?>