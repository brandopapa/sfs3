<?
//$Id: movein_ps.php 5310 2009-01-10 07:57:56Z hami $
include "stud_move_config.php";

// �{���ˬd
sfs_check();

if ($_POST[year]!=''){
	$template_file1 =  $SFS_PATH."/".get_store_path()."/templates/tc_100_ps.htm";
	$template_file2 =  $SFS_PATH."/".get_store_path()."/templates/tc_100_ps.htm";
	($IS_JHORES==6 ) ? $template_file=$template_file1:$template_file=$template_file2;
	$AA=get_school_base();
	$smarty->assign("SCHOOL",$AA[sch_cname]);
	$ps=new move_ps($_POST[year]);
	$smarty->assign("st",$ps);
	$smarty->display($template_file);
	}
else{
//��By ���ƿ��ǰȨt�α��s�p��
	header("Location: stud_move_print.php");
}

class move_ps {
	
	var $tol_stu;
	var $tol_page;
	var $size=20;
	var $seme;
	function move_ps($year){
		$this->year=$year;
		$this->tol_stu=$this->count_stu();
		$this->tol_page=ceil($this->tol_stu/$this->size);
		$this->seme=$this->seme($year);
	}
	function seme($year){
		$aa=$year."�Ǧ~�ײ�1�Ǵ�";
		return $aa;
	}

	//�p���`�ǥͼ�
	function count_stu(){
		global $CONN;
		$SQL="select  count(student_sn) as num from stud_base where  stud_study_year='".$this->year."' and   stud_study_cond='0' order by stud_id ";
		$rs=$CONN->Execute($SQL) or die($SQL);
		$ar = $rs->FetchRow();
		return $ar[num];
	}
	//���歶�ǥ͸��
	function get_page($page){
		global $CONN;
		$SQL="select  * from stud_base where  stud_study_year='".$this->year."' and   stud_study_cond='0' order by stud_id   limit ".($page*$this->size).",".$this->size." ";
		$rs=$CONN->Execute($SQL) or die($SQL);
		$arr = $rs->GetArray();
		return $arr;
	}
	//�������ǥ͸��
	function get_all(){
		$end=$this->tol_page - 1;
		for ($i=0;$i<$this->tol_page;$i++){
			$arr[$i][stu]=$this->get_page($i);//�����ǥ͸��
			$arr[$i][now]=$i+1;//�ثe����
			$arr[$i][page_tol]=count($arr[$i][stu]);//�����H��
			if ($i!=$end ) $arr[$i][break_line]='yes';//��������
		}
		return $arr;
	}
	//�ഫ�ǥ�
	function sex($sex){
		$AA=array(1=>"�k",2=>"�k");
		return $AA[$sex];
	}
	//�ഫ�ͤ�
	function bir($bir){
		$AA=split("-",$bir);
		$y=$AA[0]-1911;
		$yy=$y."-".$AA[1]."-".$AA[2];
		return $yy;
	}
}
?>