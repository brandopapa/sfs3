<?php
//$Id: chi_photo.php 7563 2013-09-22 09:00:32Z smallduh $
require_once("stud_reg_config.php");

//�ϥΪ̻{��
sfs_check();


//c_curr_class=095_1_04_05&c_curr_seme=0951

$obj=new stu_photo();
$obj->CONN=&$CONN;
$obj->smarty=&$smarty;
$obj->IS_JHORES=&$IS_JHORES;
$obj->smarty->assign('modify_flag',$modify_flag);
$obj->process();

head("�ǥͬۤ��޲z");
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
	if ($_POST[form_act]=='photo_upload') $this->photo_upload();
	if ($_GET[form_act]=='del') $this->photo_del();
	$this->YS_ary=$this->sel_year();//�Ǵ��}�C
	$this->YC_ary=$this->grade();//�~�ůZ�Ű}�C
	if ($this->Sel_class!='') $this->get_stu($this->Sel_class);
	//$this->display();
}

function init() {
	($_GET[$this->Y_name]=='') ? $this->year_seme=$_POST[$this->Y_name]:$this->year_seme=$_GET[$this->Y_name];
	if ($this->year_seme=='') $this->year_seme=sprintf("%04d",curr_year().curr_seme());
	($_GET[$this->S_name]=='') ? $this->Sel_class=$_POST[$this->S_name]:$this->Sel_class=$_GET[$this->S_name];
	
   
   $this->year=substr($this->year_seme,0,3);
   $this->seme=substr($this->year_seme,-1);

}
function display(){
	if ($this->tpl=='') $this->tpl=dirname(__file__)."/templates/chi_photo.htm";
	  
		$this->smarty->assign("this",$this);
		$this->smarty->display($this->tpl);
}

function photo_upload() {
	global  $UPLOAD_PATH,$UPLOAD_URL;
	//echo "<pre>";print_r($_POST);print_r($_FILES);die();
	$base=$UPLOAD_PATH.'photo/student/';
	foreach ($_FILES[photo][error] as $k=>$val){
			$new_file='';
			if (!is_uploaded_file($_FILES[photo][tmp_name][$k])) continue ;
			if ($_FILES[photo][error][$k]!=0 ) continue ;
			if ($_FILES[photo][size][$k]==0 ) continue ;
			$year=$_POST[study][$k];
			$path=$base.$year;
			if ($base==$path) die("�ǥ͵L�J�Ǧ~���ˬd�I");
			if (!file_exists($path)) @mkdir($path,0755);
			$new_file=$path."/".$k;
			if (file_exists($new_file)) continue ;
			
			@move_uploaded_file($_FILES[photo][tmp_name][$k],$new_file);
		}
		
	$URL=$_SERVER[PHP_SELF]."?".$this->Y_name."=".$_POST[$this->Y_name]."&".$this->S_name."=".$_POST[$this->S_name];
//	die($URL);
	Header("Location:$URL");
}


function photo_del() {
	global  $UPLOAD_PATH,$UPLOAD_URL;
	//echo "<pre>";print_r($_POST);print_r($_FILES);die();
	$base=$UPLOAD_PATH.'photo/student/';
	if ($_GET[dir]!='' || $_GET[img]!=''){
		$file=$base.$_GET[dir].'/'.$_GET[img];
		@unlink($file);	
	} 
	$URL=$_SERVER[PHP_SELF]."?".$this->Y_name."=".$_GET[$this->Y_name]."&".$this->S_name."=".$_GET[$this->S_name];
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
	
	global  $UPLOAD_PATH,$UPLOAD_URL;
	$tmp=split('_',$class_id);
	$seme=$tmp[0].$tmp[1];
	
	$cla=($tmp[2]+0).$tmp[3];
	$SQL="select a.stud_id,a.student_sn,a.stud_name,a.stud_sex,b.seme_year_seme,b.seme_class,
	b.seme_num,a.stud_study_year
	
	 from stud_base a,stud_seme b 
	 where a.student_sn=b.student_sn and 
	 b.seme_year_seme='$seme' and b.seme_class='$cla'  order by b.seme_num ";
	$rs=$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	$All_stu=$rs->GetArray();
	foreach ($All_stu as $ary){ 
		$year=$ary[stud_study_year];
		$img=$UPLOAD_PATH.'photo/student/'.$year."/".$ary[stud_id];
		if (file_exists($img)) $ary[url]=$UPLOAD_URL.'photo/student/'.$year.'/'.$ary[stud_id];
		$STU[]=$ary;
	}
	$this->stu=$this->TD_full($STU,5);
}

	function TD_full($data,$num) {
		$all=count($data);
		$loop=ceil($all/$num);
		$all_td=($loop*$num)-1;//�̤j�Ȥp1
		for ($i=0;$i<($loop*$num);$i++){
		(($i%$num)==($num-1) && $i!=0 && $i!=$all_td) ? $data[$i][next_line]='yes':$data[$i][next_line]='';
		}
		return $data;
	}


}

?>
