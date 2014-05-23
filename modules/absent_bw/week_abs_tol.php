<?php
//$Id: week_abs_tol.php 5310 2009-01-10 07:57:56Z hami $
include"config.php";

//sfs_check();
$obj= new cal_elps();
$obj->CONN=&$CONN;
$obj->smarty=&$smarty;
$obj->process();
$obj->display();

//����class
class cal_elps{
	var $CONN;//adodb����
	var $week;
	var $day;
	var $wabs;
	var $week_title=array("0"=>"��","1"=>"�@","2"=>"�G","3"=>"�T","4"=>"�|","5"=>"��","6"=>"��");
	var $cla_year;//�~�Ű}�C


	//�^�����
	function process(){
		$this->get_class_year();//�~�Ű}�C
		$this->get_day();//�M�w���
		$this->get_wek_day();//�M�w���g���
		$this->get_wek_abs();//���o���g�X�ʮu
	}

	function display(){
		$this->smarty->assign("this",$this);
		$this->smarty->display(dirname(__file__)."/templates/week_abs_tol.htm");
	}

	function get_day(){
		if($_GET[day]!=='' && strlen($_GET[day])==10) {
			$day=explode("-",$_GET[day]);
			$this->day[Y]=$day[0];
			$this->day[m]=$day[1];
			$this->day[d]=$day[2];
		}
		else{
			$this->day[Y]=date("Y");
			$this->day[m]=date("m");
			$this->day[d]=date("d");
		}
	}
	//���o���g���
	function get_wek_day(){
		$aaa=mktime(1,1,0,$this->day[m],$this->day[d],$this->day[Y]);//���o����
		$ord=date("w",$aaa);
		$one_day=60*60*24;

		if ($ord!=0 ) $aaa=$aaa-($ord*$one_day);

		for($i=0;$i<7;$i++){
			$wek_day=$aaa+$i*$one_day;
			$week[day]=date("Y-m-d",$wek_day);
			$week[name]= $this->week_title[$i];
			$WK[]=$week;
		}
		$this->week=&$WK;
//		echo "<PRE>";print_r($week);
	}


	function get_wek_abs(){
		foreach ($this->week as $day){
			$SQL="select  SUBSTRING(class_id,7,2) as cla_year, count(DISTINCT(stud_id)) as nu,date from  stud_absent where date='{$day[day]}' group by  cla_year order by cla_year asc  ";
	//		echo $SQL;
			$rs=&$this->CONN->Execute($SQL) or die($SQL);
			$this->wabs[$day[day]] = $rs->GetArray();
		}
//		echo "<PRE>";	print_r($this->wabs);
	}

	function get_class_year(){
		global $IS_JHORES;
		if($IS_JHORES==0) {
			$this->cla_year[tol]=6;
			for($i=1;$i<7;$i++){
				$this->cla_year[info][$i][name]= $this->week_title[$i];
				$this->cla_year[info][$i][key]= $i;
				}
		}
		if($IS_JHORES==6) {
			$this->cla_year[tol]=3;
			for($i=7;$i<10;$i++){
				$y=$i-6;
				$this->cla_year[info][$y][name]= $this->week_title[$y];
				$this->cla_year[info][$y][key]= $i;
				}
		}
	}


}

?>