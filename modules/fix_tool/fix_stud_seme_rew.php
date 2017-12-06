<?php
//$Id$
include "config.php";
//�{��
sfs_check();

//�إߪ���
$obj= new My_TB($CONN,$smarty);
//��l��
$obj->init();
//�B�z�{��
$obj->process();

//�q�X�����������Y
head("���D�u��c--���g�ץ�");
print_menu($school_menu_p);
//�˥���

//��ܤ��e
$obj->display();
//�G������
foot();


//����class
class My_TB{
	var $CONN;//adodb����
	var $smarty;//smarty����
	var $size=10;//�C������
	var $page;//�ثe����
	var $tol;//����`����


	//�غc�禡
	function My_TB($CONN,$smarty){
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
	}
	//��l��
	function init() {}
	//�{��
	function process() {
		if($_POST['form_act']=='fix') $this->fixall();
		if($_POST['form_act']=='fixOne') $this->fixOne();
		$this->all();
	}
	//���
	function display(){
		$tpl = "fix_stud_seme_rew.htm";
		$this->smarty->template_dir=dirname(__file__)."/templates/";
		$this->smarty->assign("this",$this);
		$this->smarty->display($tpl);
	}
	//�^�����
	function all(){
		if(filter_has_var(INPUT_POST, "stud_id")):
		if ($_POST['stud_id']=='') return ;
		$stud_id=strip_tags($_POST['stud_id']);
		if(!preg_match("/^\d*$/",$stud_id)) die("��J�L�k����1!!");
		// if (!ctype_digit($stud_id)) die("��J�L�k����2!!");
		if (strlen($stud_id) < 2 ) return ;
		
		$SQL="select a.stud_name,a.stud_sex,a.stud_study_cond,a.curr_class_num,
		b.stud_id,b.student_sn ,count(b.seme_year_seme) as semeTol 
		from stud_base a,stud_seme b 
		where a.student_sn =b.student_sn and 
		b.stud_id like '$stud_id%' group by b.student_sn order by b.stud_id, b.student_sn ";
		$rs=&$this->CONN->Execute($SQL) or die($SQL);
		$arr=&$rs->GetArray();//echo'<pre>';print_r($arr);
		foreach ($arr as $ary){
			$ID=$ary['stud_id'];$SN=$ary['student_sn'];
			$AA[$ID]['SN'][$SN]=$this->rewTol($ID,$SN);
			$AA[$ID]['DA'][$SN]=$ary;
		}
			//echo'<pre>';print_r($AA);die();
		foreach ($AA as $K => $AR){
			if (count($AR['SN'])==1) continue;
			//SN,�ƶq
			list($A0,$B0)=each($AR['SN']);
			list($A1,$B1)=each($AR['SN']);
			//��̪����g�h��e��-->�����D��
			if ($B0==0 && $B1==0) continue; 
			if ($B1 >= $B0 ) :
			$BB[$K]['A']=$AR['DA'][$A0];
			$BB[$K]['A']['rewTol']=$B0;

			$BB[$K]['B']=$AR['DA'][$A1];
			$BB[$K]['B']['rewTol']=$B1;
			endif;
			
			}
		
		//echo'<pre>';print_r($BB);die();
		$this->all=$BB;//return $arr;
		
		endif;

	}
	//�s�WStuID[10091]
	function fixall(){
		if (count($_POST['StuID'])==0 ) return ;
		foreach ($_POST['StuID'] as $key => $id){
			if(!preg_match("/^\d*$/",$key)) die("��J�L�k����!!!");
		// if (!ctype_digit($stud_id)) die("��J�L�k����2!!");
			$AA[]=$key;unset($id);unset($key);
			}
		if (count($AA)==0 ) return ;
		$Str=join(",",$AA);
		$SQL="select seme_year_seme ,	stud_id, student_sn  from stud_seme where stud_id in ($Str) order by  stud_id ,student_sn, seme_year_seme  ";
		$rs=&$this->CONN->Execute($SQL) or die($SQL);
		$arr=&$rs->GetArray();
		if (count($arr)==0) return;
		foreach ($arr as $ary){
			$ID=$ary['stud_id'];$SN=$ary['student_sn'];$seme=$ary['seme_year_seme'];
			//�o�ӾǴ����o�ӾǸ�..���O�o�Ӿǥͬy����
			$SQL="update stud_seme_rew set  student_sn ='$SN'  where  stud_id ='$ID' and seme_year_seme='$seme' ";
			$rs=&$this->CONN->Execute($SQL) or die($SQL);			
			}		
		

		$URL=$_SERVER['PHP_SELF'];
		Header("Location:$URL");
	}
	//��s
	function fixOne(){
		if(filter_has_var(INPUT_POST, "stud_id")):
		if ($_POST['stud_id']=='') return ;
		$stud_id=strip_tags($_POST['stud_id']);
		if(!preg_match("/^\d*$/",$stud_id)) die("��J�L�k����!!");
		// if (!ctype_digit($stud_id)) die("��J�L�k����2!!");
		if (strlen($stud_id) < 3 ) return ;
		$SQL="select seme_year_seme ,	stud_id, student_sn  from stud_seme where stud_id='$stud_id' order by  stud_id ,student_sn, seme_year_seme  ";
		$rs=&$this->CONN->Execute($SQL) or die($SQL);
		$arr=&$rs->GetArray();
		if (count($arr)==0) return;
		foreach ($arr as $ary){
			$ID=$ary['stud_id'];$SN=$ary['student_sn'];$seme=$ary['seme_year_seme'];
			//�o�ӾǴ����o�ӾǸ�..���O�o�Ӿǥͬy����
			$SQL="update stud_seme_rew set  student_sn ='$SN'  where  stud_id ='$ID' and seme_year_seme='$seme' ";
			$rs=&$this->CONN->Execute($SQL) or die($SQL);			
			}	
		$URL=$_SERVER['PHP_SELF'];
		Header("Location:$URL");
		endif;
	}
	//��s
	function rewTol($id,$sn){
		if ($this->Rew[$id][$sn]!='' ) return $this->Rew[$id][$sn]+0;
		$SQL="select student_sn , count(*) as Tol 
		from  stud_seme_rew where stud_id='$id' group by student_sn ";
		$rs=&$this->CONN->Execute($SQL) or die($SQL);
		//echo $SQL;
		$arr=&$rs->GetArray();
		foreach ($arr as $ary){
			$SN=$ary['student_sn'];
			$this->Rew[$id][$SN]=$ary['Tol'];
			}
		return $this->Rew[$id][$sn]+0;
	}
	

}

