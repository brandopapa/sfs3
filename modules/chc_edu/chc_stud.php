<?php
//$Id: chc_stud.php 7979 2014-04-15 14:19:13Z chiming $

/*�ޤJ�ǰȨt�γ]�w��*/
include "../../include/config.php";
sfs_check();

//$stu=stu();
//echo "<pre>";print_r($stu);
//echo "hi";die();

//�ޤJ���
require_once "./module-cfg.php";
include_once "../../include/sfs_case_excel.php";
require_once "../../include/sfs_case_ooo.php";
$obj= new chc_stud();
$obj->CONN=&$CONN;
$obj->smarty=&$smarty;
$obj->IS_JHORES=&$IS_JHORES;

$obj->process();
/*
//1.�q�X�����������Y
head("���կZ�ŦW�U");

//���SFS�s�����(���ϥνЮ��}����)//echo make_menu($school_menu_p);$link2="syear=$_GET[syear]";
if ($_SESSION[session_tea_sn]!='') print_menu($school_menu_p,$link2);
//myheader();
//2.��ܤ��e
$obj->display();

//3.�G������
foot();

*/

class chc_stud{ //�إ����O
  var $CONN;    //adodb����
  var $Smarty;  //smarty����
//  var $seme;    //�Ǵ�    
  var $rs;      //�Ҧ��ǥ�
  var $stu;      //���Ǵ��Ҧ��ǥͰ}�C
  var $sch;      //�Ǯ�
  var $GR=array(1=>'���l',2=>'���k',3=>'���l',4=>'���k',5=>'���]',6=>'�S��',7=>'�S�f',8=>'�j��',9=>'�n�f',10=>'�B���h���c',11=>'��L');
  //��l��
  function init() {

  		$this->YY=curr_year();
  		$this->SS=curr_seme();

		$this->seme=sprintf("%04d",$this->YY.$this->SS);		
		$this->head=array('�Ǯսs��','�ǮզW��','�~�ůZ��','�ǥͩm�W','�a���m�W','���Y','���y�a�}');
		if ($this->IS_JHORES==6){
			$this->grade=array(7=>" �@�~��",8=>" �G�~��",9=>" �T�~��");
			$this->sgrade=array(7=>" �@�~",8=>" �G�~",9=>" �T�~");
			}
		else{
			$this->grade=array(1=>" �@�~��",2=>" �G�~��",3=>" �T�~��",4=>" �|�~��",5=>"���~��",6=>"���~��");
			$this->sgrade=array(1=>" �@�~",2=>" �G�~",3=>" �T�~",4=>" �|�~",5=>"���~",6=>"���~");
		}
	}

  //�ҥε{��
  function process(){
		$this->init();
		$this->sch=$this->get_sch_data();
		$this->cla_nmae=$this->get_class_name();
		$this->stu=$this->stu();
		if ($_GET[type]=='ODS') $this->out_ods();
		if ($_GET[type]=='XLS') $this->out_xls();
		
  }

  function get_sch_data(){
	  $SQL="select * from school_base";
	  $rs=$this->CONN->Execute($SQL) or die("�y�k���~".$SQL);
	  $tmp=$rs->GetArray();
	  return $tmp[0];
  }
  function get_class_name(){
		$SQL="select * from school_class  where year='{$this->YY}' 
		and semester ='{$this->SS}' and enable='1' 
		order by c_year ,c_sort ";
		$rs=$this->CONN->Execute($SQL) or die("�y�k���~".$SQL);
		$tmp=$rs->GetArray();		foreach($tmp as $ary ){
			$class=$ary[c_year].sprintf("%02d",$ary[c_sort]);//601	
			$cla_name[$class]=$this->sgrade[$ary[c_year]].$ary[c_name]."�Z";
		} 
		return $cla_name;

	  
  }

  function stu(){
	  	$SQL="select a.student_sn,a.seme_class,b.stud_name,c.guardian_name,c. guardian_relation,
	  	a.seme_class,a.seme_num,b.stud_addr_1 from stud_seme a,stud_base b,stud_domicile c where 
	  	a.student_sn=b.student_sn and a.student_sn=c.student_sn 
	  	and b.stud_study_cond ='0'
	  	and a.seme_year_seme='{$this->seme}' order by a.seme_class,a.seme_num ";
  		$rs=$this->CONN->Execute($SQL) or die("�y�k���~".$SQL);
  		$arr=&$rs->GetArray();
		foreach($arr as $ary){
			$year=substr($ary[seme_class],0,1);
			//$cla_name=$ary[seme_class];//��Ʀr�Z�W
			$cla_name=$this->cla_nmae[$ary[seme_class]];//�ର����Z�W
			$ar2[$year][]=array($this->sch[sch_id],$this->sch[sch_cname_s],$cla_name,
			$ary[stud_name],$ary[guardian_name],$this->GR[$ary[guardian_relation]],$ary[stud_addr_1]);
		}   		
  		return $ar2;	
  }

	function out_xls(){
		//include_once "../../include/sfs_case_excel.php";
		$x=new sfs_xls();
		$x->setUTF8();//$x->setVersion(8);
		$x->setBorderStyle(1);
		$x->filename=$this->sch[sch_cname].'.xls';
		$x->setRowText($this->head);
		
		foreach ($this->stu as $year=>$stu){
			//$year=iconv("Big5","UTF-8",$grade[$year]);
			$grade=$this->grade[$year];
			//$x->addSheet($grade);
			$x->addSheet("Grade-".$year);
			$x->items=$stu;
			$x->writeSheet();
			}
		$x->process();
	}

	function out_ods(){
		
		$x=new sfs_ooo();
		$x->filename=$this->sch[sch_cname];
		$x->setRowText($this->head);
		foreach ($this->stu as $year=>$stu){
			//if ($year == 1 ) continue ;
			//if ($year == 2 ) continue ;
			//if ($year == 3 ) continue ;
			//if ($year == 4 ) continue ;
			//if ($year == 5 ) continue ;
			//if ($year == 6 ) continue ;
			//echo $year;
			$grade=$this->grade[$year];
			$x->addSheet($grade);
			$x->items=$stu;
			$x->writeSheet();	
		}
		$x->process();

	}



}
//  end class
