<?php
// $Id: sfs_oo_dropmenu.php 5351 2009-01-20 00:39:21Z brucelyc $
//---Class�Ϊk-------------//
/*
$ob=new drop($CONN);
echo $ob->select();
$ob=new drop($this->CONN);
$this->select=&$ob->select();
*/

/* �\�� :�۰ʲ��;Ǧ~�׻P�Z�Ū��U�Ԧ����
�i����class_id=095_1_02_02���Ȩѵ{������
��class���q���ܼ� $IS_JHORES,�]���ǤJADO����$CONN
*/ 
class drop {
	var $CONN;//ADO����
	var $IS_JHORES;//�ꤤ�p
	var $year;//�Ǧ~
	var $seme;//�Ǵ�
	var $YS='year_seme';//�U�Ԧ����Ǵ����ڼƦW��
	var $year_seme;//�U�Ԧ����Z�Ū��ڼƭ�
	var $Sclass='class_id';//�U�Ԧ����Z�Ū��ڼƦW��
	var $Skind='kind';//�U�Ԧ����Z�Ū��ڼƦW��

	function drop($CONN){
		global $IS_JHORES;
		$this->CONN=&$CONN;
		$this->IS_JHORES=$IS_JHORES;
		($_GET[$this->YS]=='') ? $this->year_seme=curr_year()."_".curr_seme():$this->year_seme=$_GET[$this->YS];
		$aa=split("_",$this->year_seme);
		$this->year=$aa[0];
		$this->seme=$aa[1];
	}

##################  �Ǵ��U�Ԧ����禡  ##########################
function select() {
	$SQL = "select * from school_day where  day<=now() and day_kind='start' order by day desc ";
	$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	while(!$rs->EOF){
		$ro = $rs->FetchNextObject(false);
		// ��i$ro=$rs->FetchNextObj()�A���O�ȥΩ�s������adodb�A�ثe��SFS3���A��
		$year_seme=$ro->year."_".$ro->seme;
		$obj_stu[$year_seme]=$ro->year."�Ǧ~�ײ�".$ro->seme."�Ǵ�";
	}
	$str="<select name='".$this->YS."' onChange=\"location.href='".$_SERVER[SCRIPT_NAME]."?".$this->YS."='+this.options[this.selectedIndex].value;\">\n";
		//$str.="<option value=''>-�����-</option>\n";
	foreach($obj_stu as $key=>$val) {
		($key==$this->year_seme) ? $bb=' selected':$bb='';
		$str.= "<option value='$key' $bb>$val</option>\n";
		}
	$str.="</select>";
	$str.=$this->grade();
	$str.=$this->grade2();
	return $str;
}
##################�}�C�C�ܨ禡2##########################
function grade() {
	//�W��,�_�l��,������,��ܭ�
	$url="?".$this->YS."=". $this->year_seme."&".$this->Sclass."=";
	($this->IS_JHORES==6) ? $grade=array(7=>"�@�~",8=>"�G�~",9=>"�T�~"):$grade=array(1=>"�@�~",2=>"�G�~",3=>"�T�~",4=>"�|�~",5=>"���~",6=>"���~");

	$SQL="select class_id,c_year,c_name,teacher_1 from  school_class where year='".$this->year."' and semester='".$this->seme."' and enable=1  order by class_id  ";
	$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	if ($rs->RecordCount()==0) return"�|���]�w�Z�Ÿ�ơI";
	$All=$rs->GetArray();
	$str="<select name='".$this->Sclass."' onChange=\"location.href='".$url."'+this.options[this.selectedIndex].value;\">\n";
	$str.= "<option value=''>-�����-</option>\n";
	foreach($All as $ary) {
		($ary[class_id]==$_GET[$this->Sclass]) ? $bb=' selected':$bb='';
		$str.= "<option value='".$ary[class_id]."' $bb>".$grade[$ary[c_year]].$ary[c_name]."�Z (".$ary[teacher_1].")</option>\n";
		}
	$str.="</select>";
	
	
	return $str;
	}


##################�}�C�C�ܨ禡2##########################
function grade2() {

	//�W��,�_�l��,������,��ܭ�
	
	
//echo "<pre>";	
//print_r($_GET);
//echo "</pre>";	
//exit;

	$url="?".$this->YS."=". $this->year_seme."&".$this->Sclass."=".$_GET['class_id']."&".$this->Skind."=";
	
	$array1=array("1"=>"�w��","2"=>"����","3"=>"�w��+����");
	
	$str="<select name='".$this->Skind."' onChange=\"location.href='".$url."'+this.options[this.selectedIndex].value;\">\n";
	$str.= "<option value=''>-�����-</option>\n";
	
	foreach($array1 as $key=>$val) {
		($key==$_GET[$this->Skind]) ? $bb=' selected':$bb='';
		$str.= "<option value='".$key."' $bb>".$val."</option>\n";
		}

	$str.="</select>";
	

	return $str;
	}




	
}

?>
