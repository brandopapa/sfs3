<?php
//$Id: PHP_tmp.html 5310 2009-01-10 07:57:56Z hami $
include "config.php";

//�{��
sfs_check();
//�{���ϥΪ�Smarty�˥���
//�إߪ���
$obj= new basic_chc($CONN,$smarty,$IS_JHORES);
//��l��
//$obj->init();
//�B�z�{��,���ɵ{�Ǥ���header���O,�G���{�ǩy��head("12basic_chc�Ҳ�");���e
$obj->process();
//�q�X�����������Y
head("�ɦҦ��Z�޲z");
//���SFS�s�����(���ϥνЮ��}����)
echo make_menu($school_menu_p,$obj->linkstr);//
// print_menu($school_menu_p);//,$obj->linkstr
$obj->display();
//�G������
foot();
//����class
class basic_chc{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $size=10;//�C������
	var $page;//�ثe����
	var $tol;//����`����
//	var $scope=array(1=>'�y��',2=>'�ƾ�',3=>'�۵M�P�ͬ����',4=>'���|',
//	5=>'���d�P��|',6=>'���N�P�H��',7=>'��X����',8=>'�������');
	var $scope=array(8=>'�������');
	var $scope2=array(1=>'�y��',2=>'�ƾ�',3=>'�۵M�P�ͬ����',4=>'���|',
	5=>'���d�P��|',6=>'���N�P�H��',7=>'��X����');
	var $scopefailnum=array(1=>'�@�ӻ��H�W���ή�',2=>'�G�ӻ��H�W���ή�',3=>'�T�ӻ��H�W���ή�',4=>'�|�ӻ��H�W���ή�',
	5=>'���ӻ��H�W���ή�',6=>'���ӻ��H�W���ή�',7=>'�C�ӻ��H�W���ή�',8=>'������줣�ή�'); 
    var $Semesfailnum=array(1=>'�@�ӾǴ����Z�C��',2=>'�G�ӾǴ����Z�C��',3=>'�T�ӾǴ����Z�C��',4=>'�|�ӾǴ����Z�C��',5=>'���ӾǴ����Z�C��',6=>'���ӾǴ����Z�C��');
	var $all_seme_array_smarty=array();
	var $linkstr;
	//�غc�禡
	function basic_chc($CONN,$smarty,$IS_JHORES){
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
		$this->IS_JHORES=$IS_JHORES;
	}
	//��l��
	function init() {
		//�L�o�r��ΨM�wGET��POST�ܼ�
		$Y=gVar('Y');
		//$G=gVar('G');$S=gVar('S');$Sfailnum=gVar('Sfailnum');$Semesnum=gVar('Semesnum');		
		//�Ǧ~�׮榡 92_2,��102_1
		if (preg_match("/^[0-9]{2,3}_[1-2]$/",$Y)) $this->Y=$Y;		
		//�~�Ů榡..1-6�p��,7-9�ꤤ
//		if (preg_match("/^[1-9]$/",$G)) $this->G=$G;		
		//���N�X1-7,8��ܥ������
//		if (preg_match("/^[1-8]$/",$S)) $this->S=$S;
		//���ή���ƥN�X1-7,8��ܥ������
//		if (preg_match("/^[1-8]$/",$Sfailnum)) $this->Sfailnum=$Sfailnum;		
		//���ή�Ǵ��ƥN�X1-6
//	    if (preg_match("/^[1-6]$/",$Semesnum)) $this->Semesnum=$Semesnum;			
		//�Ǧ~�׿��
		$this->sel_year=sel_year('Y',$this->Y);
		//�~�ſ��
//		$this->sel_grade=sel_grade('G',$this->G,$_SERVER['PHP_SELF'].'?Y='.$this->Y.'&G=');
		//����
		//$this->page=($_GET[page]=='') ? 0:$_GET[page];
		//��L�����s���Ѽ�
//		$this->linkstr="Y={$this->Y}&G={$this->G}&S={$this->S}&Sfailnum={$this->Sfailnum}&Semesnum={$this->Semesnum}";
		$this->linkstr="Y={$this->Y}";
	}
		//�{��
	function process() {
		$this->init();
		$this->all();
	}
	//���
	function display(){
		$temp2 = dirname (__file__)."/templates/chc_mend_scope_tol.htm";
        ($this->S == "8") ? $tpl = $temp2 : $tpl = $temp2;
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
	}
	//�^�����
	function all(){
        //$this->Y �ҿ諸�Ǵ� 103_2
		if ($this->Y=='') return;
		//$this->G �ҿ諸�~�� �ꤤ 7 8 9
		//$this->S ������� 8�ӻ��
		//$this->Sfailnum ���ή����
		//$this->Semesnum �Ǵ���
	    //$test=$this->chc_mend_score_tol($this->Y,$this_G,$this_S,$this_Sfailnum,$this_Semesnum); 
	    
	    $ys=explode("_",$this->Y);
		$sel_year=$ys[0];
		$sel_seme=$ys[1];
          if ($sel_seme==1) {
		     $test[7]=$this->chc_mend_score_tol($this->Y,7,8,1,1);
	         $test[8]=$this->chc_mend_score_tol($this->Y,8,8,1,3);
	         $test[9]=$this->chc_mend_score_tol($this->Y,9,8,1,5); 
		  } else {
		     $test[7]=$this->chc_mend_score_tol($this->Y,7,8,1,2);
	         $test[8]=$this->chc_mend_score_tol($this->Y,8,8,1,4);
	         $test[9]=$this->chc_mend_score_tol($this->Y,9,8,1,6); 
		  }
      $this->stu_data=$test;	    
//      echo "<pre>";
//      print_r($this->stu_data);
//      echo "</pre>";
	}	
	
	function cal_fin_score($student_sn=array(),$seme=array(),$succ="",$strs="",$precision=1)   //$succ:�ݦX����� $strs:���ĵ��_�N���r��
   {

	//���X�Ǵ���]�w��  ���~���Z�p��覡  0:��ƥ���   1:�[�v����(�Ǥ������[�v)

	global $CONN;
	if (count($seme)==0) return;
	$SQL="select * from pro_module where pm_name='every_year_setup' AND pm_item='FIN_SCORE_RATE_MODE'";
        $RES=$CONN->Execute($SQL);
        $FIN_SCORE_RATE_MODE=INTVAL($RES->fields['pm_value']);

	$sslk=array("�y��-����y��"=>"chinese","�y��-�m�g�y��"=>"local","�y��-�^�y"=>"english","���d�P��|"=>"health","�ͬ�"=>"life","���|"=>"social","���N�P�H��"=>"art","�۵M�P�ͬ����"=>"nature","�ƾ�"=>"math","��X����"=>"complex");
	if (count($student_sn)>0 && count($seme)>0) {
		$all_sn="'".implode("','",$student_sn)."'";
		$all_seme="'".implode("','",$seme)."'";
		//���o��ئ��Z
		$query="select a.*,b.link_ss,b.rate from stud_seme_score a left join score_ss b on a.ss_id=b.ss_id where a.student_sn in ($all_sn) and a.seme_year_seme in ($all_seme) and b.enable='1' and b.need_exam='1'";
		// �Y���ƿ�..�h�ץ���Ʈw�y�k,�[�J�w��SS_ID���~�ŧ@�ˬd,�O�_�P�ǥͩҦb�~�Ŭ۲�
/*		$sch=get_school_base();
		if($sch[sch_sheng]=='���ƿ�'){
			$query="select a.*,b.link_ss,b.rate,b.class_year ,b.year as chc_year,b.semester as chc_semester,c.seme_class as chc_seme_class from stud_seme_score a left join score_ss b on a.ss_id=b.ss_id left join stud_seme as c on (a.seme_year_seme=c.seme_year_seme and a.student_sn =c.student_sn) where a.student_sn in ($all_sn) and a.seme_year_seme in ($all_seme) and b.enable='1' and b.need_exam='1' and (b.class_year=left(c.seme_class,1))";
		}
*/		
		$res=$CONN->Execute($query);
		//���o�U�Ǵ����Ǭ즨�Z.�[�v�ƨå[�`
		while(!$res->EOF) {
			//���o���[�v�`��
			$subj_score[$res->fields[student_sn]][$res->fields[link_ss]][$res->fields[seme_year_seme]]+=$res->fields[ss_score]*$res->fields[rate];
			//����`�[�v��
			$rate[$res->fields[student_sn]][$res->fields[link_ss]][$res->fields[seme_year_seme]]+=$res->fields[rate];
			$res->MoveNext();
		}
		//�B�z�U�Ǵ���쥭��
		$IS5=false;
		$IS7=false;
		while(list($sn,$v)=each($subj_score)) {
			$sys=array();
			reset($v);
			while(list($link_ss,$vv)=each($v)) {
				reset($vv);
				$ls=$sslk[$link_ss];
				if($ls){  //�Ǵ����Z�p��ư��E�~�@�e������"�D�w�]�����"�P"�u�ʽҵ{"(�D���j�ΤC�j���) �����Z 
					if($ls=="life") $IS5=true;
					if($ls=="art") $IS7=true;
					//�p��U���Ǵ����Z
					while(list($seme_year_seme,$s)=each($vv)) {
						$fin_score[$sn][$ls][$seme_year_seme][score]=number_format($s/$rate[$sn][$link_ss][$seme_year_seme],$precision);
						$fin_score[$sn][$ls][$seme_year_seme][rate]=$rate[$sn][$link_ss][$seme_year_seme];
						//$FIN_SCORE_RATE_MODE=1���[�v����  0����ƥ���   ���]���~�`�����[�v�ƨӦۭ�l��إ[�v��   ���`�N�U�Ǵ��[�v�O�_�X�z  ��p  �e�@�Ǵ��H100 200  500 �]�w   �����@�Ǵ��H�`�� 2  3 6  �]�w  �p���|�y����@�Ǵ����ӻ�즨�Z�񭫥��Ű��D
						if($FIN_SCORE_RATE_MODE=='1') {
							//��첦�~�`���Z
							$fin_score[$sn][$ls][total][score]+=$fin_score[$sn][$ls][$seme_year_seme][score]*$rate[$sn][$link_ss][$seme_year_seme];
							//��첦�~�`����
							$fin_score[$sn][$ls][total][rate]+=$rate[$sn][$link_ss][$seme_year_seme];
						} else {
							$fin_score[$sn][$ls][total][score]+=$fin_score[$sn][$ls][$seme_year_seme][score];
							$fin_score[$sn][$ls][total][rate]+=1;
						}
						//��Ǵ��Ǵ��`�����B�z
						if ($ls=="chinese" || $ls=="local" || $ls=="english") {
							//�y����S�O�B�z����
							if ($sys[$seme_year_seme]!=1) $sys[$seme_year_seme]=1;
							$fin_score[$sn][language][$seme_year_seme][score]+=$fin_score[$sn][$ls][$seme_year_seme][score]*$fin_score[$sn][$ls][$seme_year_seme][rate];
							$fin_score[$sn][language][$seme_year_seme][rate]+=$fin_score[$sn][$ls][$seme_year_seme][rate];
						} else {
							if($FIN_SCORE_RATE_MODE=='1') {
								$fin_score[$sn][$seme_year_seme][total][score]+=$fin_score[$sn][$ls][$seme_year_seme][score]*$rate[$sn][$link_ss][$seme_year_seme];
								$fin_score[$sn][$seme_year_seme][total][rate]+=$rate[$sn][$link_ss][$seme_year_seme];
							} else {
								$fin_score[$sn][$seme_year_seme][total][score]+=$fin_score[$sn][$ls][$seme_year_seme][score];
								$fin_score[$sn][$seme_year_seme][total][rate]+=1;
							}
						}
					}
				}
				$fin_score[$sn][$ls][avg][score]=number_format($fin_score[$sn][$ls][total][score]/$fin_score[$sn][$ls][total][rate],$precision);
				//�� ����y��  �m�g�y��  �^�y  �M �u�ʽҵ{ �~   �N��L��쥭�����Z�[�J"���~"�`���Z
				if ($ls!="chinese" && $ls!="local" && $ls!="english" && $ls!="") {
					if($FIN_SCORE_RATE_MODE=='1') {
						$fin_score[$sn][total][score]+=$fin_score[$sn][$ls][total][score];
						$fin_score[$sn][total][rate]+=$fin_score[$sn][$ls][total][rate];
					} else {
						$fin_score[$sn][total][score]+=$fin_score[$sn][$ls][avg][score];
						$fin_score[$sn][total][rate]+=1;
//echo $sn."---".$fin_score[$sn][total][score]." --- ".$fin_score[$sn][$ls][avg][score]."---".$fin_score[$sn][total][rate]."<BR>";
					}
					//�P�_�ή����
					if ($fin_score[$sn][$ls][avg][score] >= 60) $fin_score[$sn][succ]++;
				}
			}
			//�ͬ���즨�Z�S�O�B�z
			if($IS5 && $IS7) {
				$fin_score[$sn][art][total][score]+=$fin_score[$sn][life][avg][score]*$fin_score[$sn][life][total][rate]/3;
				$fin_score[$sn][nature][total][score]+=$fin_score[$sn][life][avg][score]*$fin_score[$sn][life][total][rate]/3;
				$fin_score[$sn][social][total][score]+=$fin_score[$sn][life][avg][score]*$fin_score[$sn][life][total][rate]/3;
				$fin_score[$sn][art][total][rate]+=$fin_score[$sn][life][total][rate]/3;
				$fin_score[$sn][nature][total][rate]+=$fin_score[$sn][life][total][rate]/3;
				$fin_score[$sn][social][total][rate]+=$fin_score[$sn][life][total][rate]/3;
				$fin_score[$sn][art][avg][score]=number_format($fin_score[$sn][art][total][score]/$fin_score[$sn][art][total][rate],$precision);
				$fin_score[$sn][nature][avg][score]=number_format($fin_score[$sn][nature][total][score]/$fin_score[$sn][nature][total][rate],$precision);
				$fin_score[$sn][social][avg][score]=number_format($fin_score[$sn][social][total][score]/$fin_score[$sn][social][total][rate],$precision);
			}
			//�y���즨�Z�S�O�W�߭p��
			if (count($sys)>0) {
				$r=0;
				while(list($seme_year_seme,$s)=each($sys)) {
					$fin_score[$sn][language][$seme_year_seme][score]=number_format($fin_score[$sn][language][$seme_year_seme][score]/$fin_score[$sn][language][$seme_year_seme][rate],$precision);
					if($FIN_SCORE_RATE_MODE=='1')	{
						$fin_score[$sn][language][avg][score]+=$fin_score[$sn][language][$seme_year_seme][score]*$fin_score[$sn][language][$seme_year_seme][rate];
						$fin_score[$sn][language][total][score]+=$fin_score[$sn][language][$seme_year_seme][score]*$fin_score[$sn][language][$seme_year_seme][rate];
						$fin_score[$sn][language][total][rate]+=$fin_score[$sn][language][$seme_year_seme][rate];
						$fin_score[$sn][$seme_year_seme][total][score]+=$fin_score[$sn][language][$seme_year_seme][score]*$fin_score[$sn][language][$seme_year_seme][rate];
						$r+=$fin_score[$sn][language][$seme_year_seme][rate];
		//echo $sn."---".$r."---".$fin_score[$sn][language][$seme_year_seme][rate]."---".$fin_score[$sn][language][avg][score]."<BR>";
						$fin_score[$sn][$seme_year_seme][total][rate]+=$fin_score[$sn][language][$seme_year_seme][rate];
					} else {
						$fin_score[$sn][language][avg][score]+=$fin_score[$sn][language][$seme_year_seme][score];
						$fin_score[$sn][$seme_year_seme][total][score]+=$fin_score[$sn][language][$seme_year_seme][score];
						$r+=1;
						$fin_score[$sn][$seme_year_seme][total][rate]+=1;
					}
					$fin_score[$sn][$seme_year_seme][avg][score]=number_format($fin_score[$sn][$seme_year_seme][total][score]/$fin_score[$sn][$seme_year_seme][total][rate],$precision);
				}
				$fin_score[$sn][language][avg][score]=number_format($fin_score[$sn][language][avg][score]/$r,$precision);
				if($FIN_SCORE_RATE_MODE=='1')	{
					$fin_score[$sn][total][score]+=$fin_score[$sn][language][avg][score]*$r;
					$fin_score[$sn][total][rate]+=$r;
				} else {
					$fin_score[$sn][total][score]+=$fin_score[$sn][language][avg][score];
					$fin_score[$sn][total][rate]+=1;
				}
				$fin_score[$sn][avg][score]=number_format($fin_score[$sn][total][score]/$fin_score[$sn][total][rate],$precision);
				//�ƻs��ƦW�}�C
				$rank_score[$sn]=$fin_score[$sn]['total']['score'];
				if ($fin_score[$sn][language][avg][score] >= 60) $fin_score[$sn][succ]++;
			}
			if ($succ) {
				if ($fin_score[$sn][succ] < $succ) $show_score[$sn]=$fin_score[$sn];
			}
      //�w��̫ᵲ�G���Ƨ�
			arsort($rank_score);
			//�p��W��
			$rank=0;
			foreach($rank_score as $key=>$value) {
				$rank+=1;
				$fin_score[$key]['total']['rank']=$rank;
			}
		}
		if ($succ)
			return $show_score;
		else
			return $fin_score;
	} elseif (count($student_sn)==0) {
		return "�S���ǤJ�ǥͬy����";
	} else {
		return "�S���ǤJ�Ǵ�";
	}
   }
   //�C�@�Ǵ��ɦҦ��Z
   function chc_mend_one_seme_score($this_Y,$this_G,$this_S)
   {
        if ($this_Y=='') return;
		if ($this_G=='') return;
		if ($this_S=='') return;
		$ys=explode("_",$this_Y);
		$sel_year=$ys[0];
		$sel_seme=$ys[1];
		$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
		$seme_class=$this_G."%";
		$Scope=$this_S;
		//�W�[�P�_�O�_�����~�A�y�ǥ͡A�p����ǥͤ]�|��{
		//���Ǧ~��-��ܾǦ~+��ܦ~��=�ثe�~�šA�~�Q����C
		//���O�p���@�ӤS�|���Ͳ��~�͵L�k�Q������t�@�Ӱ��D
		//�b�y�͡Ga.stud_study_cond=0 ���~�͡Ga.stud_study_cond=5 �䤤 stud_base a		
		$curr_y=curr_year();
		$sel_y=substr($this_Y,0,-2);
		$sel_g=$this_G;
		$opt=$curr_y-$sel_y+$sel_g;
		//�P�_���~�P�_
		if ($opt > 9) {
		 $graduated=" a.stud_study_cond=5 ";
	     $grad_con ="���~";
	    }
		else {
		 $opt=$opt."%";	
		 $graduated=" a.stud_study_cond=0 
		AND a.curr_class_num LIKE '".$opt."' "; 	
		 $grad_con ="�b��";
		} 
		//�����Ʈw
		$query=
		"SELECT a.stud_id,a.stud_name,a.stud_sex,
		b.seme_class,b.seme_num,b.seme_year_seme,c.* 
		FROM stud_base a,chc_mend c LEFT JOIN stud_seme b 
		ON (c.student_sn=b.student_sn  
		AND b.seme_year_seme='$seme_year_seme'  
		AND b.seme_class like '$seme_class' )
		WHERE a.student_sn=c.student_sn 
		AND c.seme='$this_Y' 
		AND".$graduated.
	   "ORDER BY b.seme_class,b.seme_num ";
		$res=$this->CONN->Execute($query);
		$ALL=$res->GetArray();
		if ($Scope=="8") {
			$New=array();
			foreach ($ALL as $ary){
				$sn=$ary['student_sn'];//�Ǹ�
				$snlist[]=$ary['student_sn'];//�Ǹ��C��
				$ss=$ary['scope'];//���
				$semes=$ary['seme'];//�Ǵ�
				$score_end = $ary['score_end'];//�ɦҧ����Z
	            //$New['A']���ǥͰ򥻸��
				$New['A'][$sn]=$ary;
				//$New['A'][$sn]['grad_con']���ǥͲ��~�Φb�Ǫ��p
				$New['A'][$sn]['grad_con']=$grad_con;
				//$New['B']������즨�Z
				$New['B'][$sn][$semes][$ss]=$ary;
				//$New['C']�B$New['D']���ɦҫᦨ�Z
				$New['C'][$sn][$semes][$ss]=$score_end;
				$New['D'][$sn][$semes][$ss]=$score_end;
//				$New['G'][$sn][$semes][$ss]=$score_end;
				//$New['C']�n�p��ɦҳq�L����total_ss_pass�B$New['D']�n�p��ɦһ���total_ss]
				$New['D'][$sn][$semes][total_ss]= (count($New['D'][$sn][$semes])==1)?(count($New['D'][$sn][$semes])):(count($New['D'][$sn][$semes])-1);
				$New['C'][$sn][$semes][total_ss_pass]= 0;		
                foreach ($New['C'][$sn][$semes] as $ss => $v) {
				     if ($v ==60) {
						 $New['C'][$sn][$semes][total_ss_pass]++;
					  } 
				 }
				 //$New['E']�n�p��ɦҥ��q�L����total_ss_Nopass
				 $New['E'][$sn][$semes][total_ss]=$New['D'][$sn][$semes][total_ss];
				 $New['E'][$sn][$semes][total_ss_pass]=$New['C'][$sn][$semes][total_ss_pass];
				 $New['E'][$sn][$semes][total_ss_Nopass]=$New['E'][$sn][$semes][total_ss]-$New['E'][$sn][$semes][total_ss_pass];
                 $New['A'][$sn][total_ss_Nopass]=$New['E'][$sn][$semes][total_ss_Nopass];
			}	 			
			$snlist_uniqe = array_unique($snlist);			
			sort($snlist_uniqe);
		    $New[snlist]=$snlist_uniqe;										
	    }
     return $New;
   }
   
   //�N�Ҧ��Ǵ��ɦҦ��Z�P�Ҧ��Ǵ����Z�X�֫�,���X�U��줣�ή�H�Ʋέp�P1~7��줣�ή�H�Ʋέp���p
   function chc_mend_score_tol($this_Y,$this_G,$this_S,$this_Sfailnum,$this_Semesnum) {
        //var $scope2=array(1=>'�y��',2=>'�ƾ�',3=>'�۵M�P�ͬ����',4=>'���|',5=>'���d�P��|',6=>'���N�P�H��',7=>'��X����');
		 $cal_fin_score_ss = array("language"=>"1","math"=>"2","nature"=>"3","social"=>"4","health"=>"5","art"=>"6","complex"=>"7");
		//$this->Y �ҿ諸�Ǵ� 103_2
		if ($this_Y=='') return;
		//$this->G �ҿ諸�~�� �ꤤ 7 8 9
		if ($this_G=='') return;
		//$this->S ������� 8�ӻ��
		if ($this_S=='') return;
		//$this->Sfailnum ���ή����
		if ($this_Sfailnum=='') return;
		//$this->Semesnum �Ǵ���
		if ($this_Semesnum=='') return;
		//�Ǧ~�Ǵ������X����ex 103_1
		//�Ǧ~�Ǵ������X����ex 103_1
		$ys=explode("_",$this_Y);
		$sel_year=$ys[0];
		$sel_seme=$ys[1];
		$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
		
        //�n�C�X���Z���Ǵ���Semesnum ex:Semesnum=5 �C�X1011 1012 1021 1022 1031 �Ω�mysql��$all_seme_mysql �Ω�smarty��$all_seme_array_smarty
        //97��~182�欰�W�z�{���X
        if ($sel_seme==1) {
		 switch ($this_Semesnum) {
		  case 1:
		  	$all_seme_array[1] = $ys[0]."_".$ys[1];
		  	$Test[1]=$this->chc_mend_one_seme_score($all_seme_array[1],$this_G,$this_S);
			break;
		  case 2:	 
		    $all_seme_array[1] = ($ys[0]-1)."_".($ys[1]+1);
		    $all_seme_array[2] = $ys[0]."_".$ys[1];
		    $Test[1]=$this->chc_mend_one_seme_score($all_seme_array[1],$this_G-1,$this_S);
		    $Test[2]=$this->chc_mend_one_seme_score($all_seme_array[2],$this_G,$this_S);
			break;	
		  case 3:	
		    $all_seme_array[1]= ($ys[0]-1)."_".$ys[1];
            $all_seme_array[2]= ($ys[0]-1)."_".($ys[1]+1);
            $all_seme_array[3]= $ys[0]."_".$ys[1];
            $Test[1]=$this->chc_mend_one_seme_score($all_seme_array[1],$this_G-1,$this_S);
		    $Test[2]=$this->chc_mend_one_seme_score($all_seme_array[2],$this_G-1,$this_S);
		    $Test[3]=$this->chc_mend_one_seme_score($all_seme_array[3],$this_G,$this_S);
			break;
		  case 4:	
		    $all_seme_array[1]= ($ys[0]-2)."_".($ys[1]+1);
            $all_seme_array[2]= ($ys[0]-1)."_".$ys[1];
            $all_seme_array[3]= ($ys[0]-1)."_".($ys[1]+1);
            $all_seme_array[4]= $ys[0]."_".$ys[1];
            $Test[1]=$this->chc_mend_one_seme_score($all_seme_array[1],$this_G-2,$this_S);
		    $Test[2]=$this->chc_mend_one_seme_score($all_seme_array[2],$this_G-1,$this_S);
		    $Test[3]=$this->chc_mend_one_seme_score($all_seme_array[3],$this_G-1,$this_S);
		    $Test[4]=$this->chc_mend_one_seme_score($all_seme_array[4],$this_G,$this_S);
			break;		
		  case 5:	
		    $all_seme_array[1]= ($ys[0]-2)."_".($ys[1]);
            $all_seme_array[2]= ($ys[0]-2)."_".($ys[1]+1);
            $all_seme_array[3]= ($ys[0]-1)."_".$ys[1];
            $all_seme_array[4]= ($ys[0]-1)."_".($ys[1]+1);
            $all_seme_array[5]= $ys[0]."_".$ys[1];
            $Test[1]=$this->chc_mend_one_seme_score($all_seme_array[1],$this_G-2,$this_S);
		    $Test[2]=$this->chc_mend_one_seme_score($all_seme_array[2],$this_G-2,$this_S);
		    $Test[3]=$this->chc_mend_one_seme_score($all_seme_array[3],$this_G-1,$this_S);
		    $Test[4]=$this->chc_mend_one_seme_score($all_seme_array[4],$this_G-1,$this_S);
		    $Test[5]=$this->chc_mend_one_seme_score($all_seme_array[5],$this_G,$this_S);
			break;
		  case 6:	
		    $all_seme_array[1]= ($ys[0]-3)."_".($ys[1]+1);
            $all_seme_array[2]= ($ys[0]-2)."_".($ys[1]);
            $all_seme_array[3]= ($ys[0]-2)."_".($ys[1]+1);
            $all_seme_array[4]= ($ys[0]-1)."_".$ys[1];
            $all_seme_array[5]= ($ys[0]-1)."_".($ys[1]+1);
            $all_seme_array[6]= $ys[0]."_".$ys[1];
            $Test[1]=$this->chc_mend_one_seme_score($all_seme_array[1],$this_G-3,$this_S);
		    $Test[2]=$this->chc_mend_one_seme_score($all_seme_array[2],$this_G-2,$this_S);
		    $Test[3]=$this->chc_mend_one_seme_score($all_seme_array[3],$this_G-2,$this_S);
		    $Test[4]=$this->chc_mend_one_seme_score($all_seme_array[4],$this_G-1,$this_S);
		    $Test[5]=$this->chc_mend_one_seme_score($all_seme_array[5],$this_G-1,$this_S);
		    $Test[6]=$this->chc_mend_one_seme_score($all_seme_array[6],$this_G,$this_S);
			break;		
	      }
		} else {
		  switch ($this_Semesnum) {
		  case 1:
		  	$all_seme_array[1] = $ys[0]."_".$ys[1];
		  	$Test[1]=$this->chc_mend_one_seme_score($all_seme_array[1],$this_G,$this_S);
			break;
		  case 2:	
		    $all_seme_array[1] = ($ys[0])."_".($ys[1]-1);
		    $all_seme_array[2] = $ys[0]."_".$ys[1];
		    $Test[1]=$this->chc_mend_one_seme_score($all_seme_array[1],$this_G,$this_S);
		    $Test[2]=$this->chc_mend_one_seme_score($all_seme_array[2],$this_G,$this_S);
			break;	
		  case 3:	
		    $all_seme_array[1]= ($ys[0]-1)."_".$ys[1];
            $all_seme_array[2]= ($ys[0])."_".($ys[1]-1);
            $all_seme_array[3]= $ys[0]."_".$ys[1]; 
            $Test[1]=$this->chc_mend_one_seme_score($all_seme_array[1],$this_G-1,$this_S);
		    $Test[2]=$this->chc_mend_one_seme_score($all_seme_array[2],$this_G,$this_S);
		    $Test[3]=$this->chc_mend_one_seme_score($all_seme_array[3],$this_G,$this_S);
			break;
		  case 4:	
		    $all_seme_array[1]= ($ys[0]-1)."_".($ys[1]-1);
            $all_seme_array[2]= ($ys[0]-1)."_".$ys[1];
            $all_seme_array[3]= ($ys[0])."_".($ys[1]-1);
            $all_seme_array[4]= $ys[0]."_".$ys[1];
            $Test[1]=$this->chc_mend_one_seme_score($all_seme_array[1],$this_G-1,$this_S);
		    $Test[2]=$this->chc_mend_one_seme_score($all_seme_array[2],$this_G-1,$this_S);
		    $Test[3]=$this->chc_mend_one_seme_score($all_seme_array[3],$this_G,$this_S);
		    $Test[4]=$this->chc_mend_one_seme_score($all_seme_array[4],$this_G,$this_S);
			break;		
		  case 5:	
		    $all_seme_array[1]= ($ys[0]-2)."_".($ys[1]);
            $all_seme_array[2]= ($ys[0]-1)."_".($ys[1]-1);
            $all_seme_array[3]= ($ys[0]-1)."_".($ys[1]);
            $all_seme_array[4]= ($ys[0])."_".($ys[1]-1);
            $all_seme_array[5]= $ys[0]."_".$ys[1];
            $Test[1]=$this->chc_mend_one_seme_score($all_seme_array[1],$this_G-2,$this_S);
		    $Test[2]=$this->chc_mend_one_seme_score($all_seme_array[2],$this_G-1,$this_S);
		    $Test[3]=$this->chc_mend_one_seme_score($all_seme_array[3],$this_G-1,$this_S);
		    $Test[4]=$this->chc_mend_one_seme_score($all_seme_array[4],$this_G,$this_S);
		    $Test[5]=$this->chc_mend_one_seme_score($all_seme_array[5],$this_G,$this_S);
			break;
		  case 6:	
		    $all_seme_array[1]= ($ys[0]-2)."_".($ys[1]-1);
            $all_seme_array[2]= ($ys[0]-2)."_".($ys[1]);
            $all_seme_array[3]= ($ys[0]-1)."_".($ys[1]-1);
            $all_seme_array[4]= ($ys[0]-1)."_".($ys[1]);
            $all_seme_array[5]= ($ys[0])."_".($ys[1]-1);
            $all_seme_array[6]= $ys[0]."_".$ys[1];
            $Test[1]=$this->chc_mend_one_seme_score($all_seme_array[1],$this_G-2,$this_S);
		    $Test[2]=$this->chc_mend_one_seme_score($all_seme_array[2],$this_G-2,$this_S);
		    $Test[3]=$this->chc_mend_one_seme_score($all_seme_array[3],$this_G-1,$this_S);
		    $Test[4]=$this->chc_mend_one_seme_score($all_seme_array[4],$this_G-1,$this_S);
		    $Test[5]=$this->chc_mend_one_seme_score($all_seme_array[5],$this_G,$this_S);
		    $Test[6]=$this->chc_mend_one_seme_score($all_seme_array[6],$this_G,$this_S);
			break;
	      }
		}
		$this->all_seme_array_smarty=$all_seme_array;
		$all_seme_array_mysql=str_replace("_","",$all_seme_array);	
		$all_seme_array2mysql=array_combine($all_seme_array,$all_seme_array_mysql);	
		$all_student_sn=array();		
       for ($i=1;$i<=$this_Semesnum;$i++) {
			for ($j=0;$j<count($Test[$i][snlist]);$j++) {
			array_push($all_student_sn,$Test[$i][snlist][$j]);
			}					
		}		
        $all_student_sn_unique=array_unique($all_student_sn);
        sort($all_student_sn_unique);
        for ($i=1;$i<=$this_Semesnum;$i++) {
            foreach ($all_student_sn_unique as $value_sn) {
				if ($Test[$i]['A'][$value_sn]!="") {
				//$New['A']���ǥͰ򥻸��
				$New['A'][$value_sn]=$Test[$i]['A'][$value_sn];
			    }
		            foreach ($all_seme_array as $value_seme){
			        	    foreach ($cal_fin_score_ss as $index_ss => $value_ss){
			        	           if ($Test[$i]['B'][$value_sn][$value_seme][$value_ss]!="") {
			        	              //$New['B']������즨�Z
				                      $New['B'][$value_sn][$value_seme][$value_ss]=$Test[$i]['B'][$value_sn][$value_seme][$value_ss];
					                }
					                if ($Test[$i]['D'][$value_sn][$value_seme][$value_ss]!="") {
			        	              //$New['E']�n�p��ɦҥ��q�L����total_ss_Nopass
				                      $New['E'][$value_sn][$value_seme][$value_ss]=$Test[$i]['D'][$value_sn][$value_seme][$value_ss];
					                }					                
			                }
			                if ($Test[$i]['E'][$value_sn][$value_seme][total_ss]!="") {
				                $New['E'][$value_sn][$value_seme][total_ss]=$Test[$i]['E'][$value_sn][$value_seme][total_ss];
					        }
					        if ($Test[$i]['E'][$value_sn][$value_seme][total_ss_pass]!="") {			        	          
				                $New['E'][$value_sn][$value_seme][total_ss_pass]=$Test[$i]['E'][$value_sn][$value_seme][total_ss_pass];
					        }
					        if ($Test[$i]['E'][$value_sn][$value_seme][total_ss_Nopass]!="") {			        	          
				                $New['E'][$value_sn][$value_seme][total_ss_Nopass]=$Test[$i]['E'][$value_sn][$value_seme][total_ss_Nopass];
					        }
					        if ($Test[$i]['E'][$value_sn][$value_seme][total_ss]!=""&&$Test[$i]['E'][$value_sn][$value_seme][total_ss_Nopass]!="") {			        	          
				                $New['E'][$value_sn][$value_seme][total_ss_pass]=$New['E'][$value_sn][$value_seme][total_ss]-$New['E'][$value_sn][$value_seme][total_ss_Nopass];
					        }
				     }	        
		    }
	    }
        $cal_fin_score_array = $this->cal_fin_score($all_student_sn_unique,$all_seme_array_mysql,"","",2);	
        foreach ($all_student_sn_unique as $value_sn){
			   foreach ($all_seme_array as $value_seme){
				  foreach ($cal_fin_score_ss as $index_ss => $value_ss){					  
					  //$New['F']�n���o���ɦһ�즨�Z
					  $New['F'][$value_sn][$value_seme][$value_ss] = $cal_fin_score_array[$value_sn][$index_ss][$all_seme_array2mysql[$value_seme]];
					  $New['I'][$value_sn][$value_ss][$value_seme] = $New['F'][$value_sn][$value_seme][$value_ss];
					  //$New['G']�n�p��U���U�Ǵ��������Z
					  $New['G'][$value_sn][$value_ss][$value_seme] =$New['B'][$value_sn][$value_seme][$value_ss][score_end];				      
				  } 
			   } 				
			}
        	foreach ($all_student_sn_unique as $value_sn){
			   foreach ($all_seme_array as $value_seme){
				  foreach ($cal_fin_score_ss as $index_ss => $value_ss){
					 if ($New['G'][$value_sn][$value_ss][$value_seme] =="") {
					  $New['G'][$value_sn][$value_ss][$value_seme] = $New['I'][$value_sn][$value_ss][$value_seme][score];
					 }
	              } 
			   } 				
			}
			foreach ($all_student_sn_unique as $value_sn){			   
			   foreach ($cal_fin_score_ss as $index_ss => $value_ss){				
				  foreach ($all_seme_array as $value_seme){  
					  $New['G'][$value_sn][$value_ss][total_score]=$New['G'][$value_sn][$value_ss][total_score]+$New['G'][$value_sn][$value_ss][$value_seme];
					  if ($New['G'][$value_sn][$value_ss][$value_seme]!="") $New['G'][$value_sn][$value_ss][rate_score]++;
					  $New['G'][$value_sn][$value_ss][avg_score]=round($New['G'][$value_sn][$value_ss][total_score]/$New['G'][$value_sn][$value_ss][rate_score],2);
			          //$New['H']�n�p��U���(1,2,3,4,5,6)�Ǵ��������Z�ӭp��q�L����
					  $New['H'][$value_sn][$value_ss]=$New['G'][$value_sn][$value_ss][avg_score];					  
				  } 				 
				  if ($New['H'][$value_sn][$value_ss]>=60) $New['H'][$value_sn][total_ss_pass]++;
				  $New['H'][$value_sn][total_ss_Nopass]=7-$New['H'][$value_sn][total_ss_pass];
			   } 				
			}
			//$total_num_fail ���ή��`�H��
			$total_num_fail=0;
	        //$total_num_language  �y���줣�ή�H��
	        $total_num_language=0;
	        //$total_num_math  �ƾǻ�줣�ή�H��
	        $total_num_math=0;
	        //$total_num_nature �۵M�P�ͬ���޻�줣�ή�H��
	        $total_num_nature=0;
	        //$total_num_social ���|��줣�ή�H��
	        $total_num_social=0;
	        //$total_num_health ���d�P��|��줣�ή�H��
	        $total_num_health=0;
	        //$total_num_art ���N�P�H�夣�ή�H��
	        $total_num_art =0;
	        //$total_num_complex ��X���ʻ�줣�ή�H��
	        $total_num_complex=0;
	        //$total_num_fail_scope_1 1�ӻ�줣�ή�H��
			$total_num_fail_scope_1=0;
			//$total_num_fail_scope_2 2�ӻ�줣�ή�H��
			$total_num_fail_scope_2=0;
			//$total_num_fail_scope_3 3�ӻ�줣�ή�H��
			$total_num_fail_scope_3=0;
			//$total_num_fail_scope_4 4�ӻ�줣�ή�H��
			$total_num_fail_scope_4=0;
			//$total_num_fail_scope_5 5�ӻ�줣�ή�H��
			$total_num_fail_scope_5=0;
			//$total_num_fail_scope_6 6�ӻ�줣�ή�H��
			$total_num_fail_scope_6=0;
			//$total_num_fail_scope_7 7�ӻ�줣�ή�H��
			$total_num_fail_scope_7=0;
			
			foreach ($all_student_sn_unique as $value_sn){			   
			   $total_num_fail++;
			     if ($New['H'][$value_sn][1] < 60) $total_num_language++; 
			     if ($New['H'][$value_sn][2] < 60) $total_num_math++;
			     if ($New['H'][$value_sn][3] < 60) $total_num_nature++; 
			     if ($New['H'][$value_sn][4] < 60) $total_num_social++;
			     if ($New['H'][$value_sn][5] < 60) $total_num_health++; 
			     if ($New['H'][$value_sn][6] < 60) $total_num_art++;
			     if ($New['H'][$value_sn][7] < 60) $total_num_complex++;
			     if ($New['H'][$value_sn][total_ss_Nopass] == 1) $total_num_fail_scope_1++;
			     if ($New['H'][$value_sn][total_ss_Nopass] == 2) $total_num_fail_scope_2++;
			     if ($New['H'][$value_sn][total_ss_Nopass] == 3) $total_num_fail_scope_3++;
			     if ($New['H'][$value_sn][total_ss_Nopass] == 4) $total_num_fail_scope_4++;
			     if ($New['H'][$value_sn][total_ss_Nopass] == 5) $total_num_fail_scope_5++;
			     if ($New['H'][$value_sn][total_ss_Nopass] == 6) $total_num_fail_scope_6++;
			     if ($New['H'][$value_sn][total_ss_Nopass] == 7) $total_num_fail_scope_7++;
			}
			$New['L'][all_seme_array]=$all_seme_array;
			$New['L'][total_num_fail]=$total_num_fail;
			$New['L'][total_num_language]=$total_num_language;
			$New['L'][total_num_math]=$total_num_math;
			$New['L'][total_num_nature]=$total_num_nature;
			$New['L'][total_num_social]=$total_num_social;
			$New['L'][total_num_health]=$total_num_health;
			$New['L'][total_num_art]=$total_num_art;
			$New['L'][total_num_complex]=$total_num_complex;
			$New['L'][total_num_fail_scope_1]=$total_num_fail_scope_1;
			$New['L'][total_num_fail_scope_2]=$total_num_fail_scope_2;
			$New['L'][total_num_fail_scope_3]=$total_num_fail_scope_3;
			$New['L'][total_num_fail_scope_4]=$total_num_fail_scope_4;
			$New['L'][total_num_fail_scope_5]=$total_num_fail_scope_5;
			$New['L'][total_num_fail_scope_6]=$total_num_fail_scope_6;
			$New['L'][total_num_fail_scope_7]=$total_num_fail_scope_7;	
        return $New['L']; 
//        return $New;   
   }
       
}
