<?php
//$Id: cal_elps_class.php 8513 2015-09-02 05:18:04Z chiming $
//����class
class cal_elps{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $size=10;//�C������
	var $page;//�ثe����
	var $tol;//����`����
	var $seme;//�Ǵ�
	var $seme_ary;//�襤���Ǵ��}�C
	var $all_seme;//�Ҧ��Ǵ���ư}�C,�U�Ԧ�����
	var $unit;//���D(���γB��)
	var $event;//�Ҧ����
	var $WK;//�t�g�O�P��ƪ���ư}�C
	var $cal_name;//XX��XX����p��XX�Ǧ~�ײ�X�Ǵ� �հȦ�ƾ�



	//�^�����
	function get_all_event(){
		$SQL="select * from cal_elps where  syear='{$this->seme}' order by  week asc,unit ";
		$rs=&$this->CONN->Execute($SQL) or die($SQL);
		$arr=$rs->GetArray();
		//$this->all=$arr;//return $arr;
		foreach ($arr as $ary){
		   $week=$ary[week];
		   //$this->event[$week][]=$ary;
			$this->WK[$week][event][]=$ary;
			}
	
	}
	//�s�W
	function get_use_set(){
		if ($this->seme_ary=='') return;
			$arr=$this->seme_ary;
			//$this->unit=split("@@@",$arr[unit]);//���}�C
			$this->unit=explode("@@@",$arr[unit]);//���}�C
			$unit_nu=count($this->unit);//������
			$this->wd=round(80/$unit_nu);//�p����e
			$this->colspan=2+$unit_nu;//�p��X������
			
			//��X�Ҧ���ƨ�g���}�C
			if ($this->seme_ary[week_mode]=='1'){$this->get_week1();}
			else{$this->get_week();}
			
			$this->sch=get_school_base();
			$this->cal_name=$this->sch[sch_cname].substr($this->seme,0,3)."�Ǧ~�ײ�".substr($this->seme,3,1)."�Ǵ� �հȦ�ƾ�";
	}


	function get_all_set(){
		$SQL="select * from cal_elps_set order by  sday desc ";
		$rs=&$this->CONN->Execute($SQL) or die($SQL);
		if ($rs->RecordCount()==0) return;
		$arr = $rs->GetArray();
		//print_r($arr);
		//$tmp=array();
		foreach ($arr as $ary){
			$key=$ary[syear];
			if ($this->seme==$ary[syear]) {$this->seme_ary=$ary;}
			$tmp[$key]=substr($key,0,3)."�Ǧ~ ��".substr($key,3,1)."�Ǵ�";			
		}
		$this->all_seme=$tmp;
		//print_r($tmp);
	}

	function get_week(){
		$loop=$this->seme_ary[weeks];
		//$sday=split("-",$this->seme_ary[sday]);//�ɶ��}�C �~���
		$sday=explode("-",$this->seme_ary[sday]);//�ɶ��}�C �~���
		$TT1=mktime(1,1,0,$sday[1],$sday[2],$sday[0]);
		$one_day=60*60*24;
		$week_ord=date("w",$TT1);//���o�P���X
		if ( $week_ord!=0 ) $TT1=$TT1-($week_ord*$one_day);//�D�P����h����P����

		for($i=0;$i<$loop;$i++){
			$key=$i+1;
			$wk_1=$TT1+$i*$one_day*7;
			$wk_2=$wk_1+$one_day*6;
			$WK[$key][No]=$key;//�g��
			$WK[$key][st_day]=date("m/d",$wk_1);//�g��
			$WK[$key][en_day]=date("m/d",$wk_2);//�g��
			//$WK[$key][event]=$this->event[$key];
		}
		$this->WK=$WK;
	}

	function get_week1(){
		$year=substr($this->seme,0,3)+0;
		$seme=substr($this->seme,3,1);
		$SQL="SELECT * FROM `week_setup` where year='$year' and semester ='$seme' order by  week_no asc ";
		$rs=$this->CONN->Execute($SQL) or die($SQL);
		if ($rs->RecordCount()==0) die("<h1 align='center'>[�Ǵ���]�w/�}�Ǥ�]�w]���L".$this->seme."�Ǵ����g�O�]�w!</h1>");
		$arr = $rs->GetArray();
		$one_day=60*60*24;
		foreach ($arr as $ary){
			$key=$ary[week_no];
			//$start=split("-",$ary[start_date]);//�ɶ��}�C �~���
			$start=explode("-",$ary[start_date]);//�ɶ��}�C �~���
			$wk_1=mktime(1,1,0,$start[1],$start[2],$start[0]);//�g��
			$wk_2=$wk_1+$one_day*6;//�g��
			$WK[$key][No]=$key;//�g��
			$WK[$key][st_day]=date("m/d",$wk_1);//�g��
			$WK[$key][en_day]=date("m/d",$wk_2);//�g��
			//$WK[$key][event]=$this->event[$key];
		}
		$this->WK=$WK;
	}
	##################�^�W���禡1#####################
	function BK($value= "BACK"){
		echo  "<br><br><br><br><CENTER><form><input type=button value='".$value."' onclick=\"history.back()\" style='font-size:16pt;color:red;'></form><BR><img src='images/stop.png'></CENTER>";
	die();
}
}

