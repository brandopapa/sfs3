<?php
// $Id: grad_edit.php 6429 2011-05-06 01:31:26Z chiming $
//���J�]�w��
require("config.php");
// �{���ˬd
sfs_check();
#############--------SQL�B�z�� ----------######################## 
//----�s�W�浧--------------------///
if ($_POST[act]=='ADD_ONE'){
	if ($_POST[one_stud_id]=='') backe("�п�J�Ǹ�");
	$seme_year_seme=sprintf("%03d",$_POST[Syear])."2";
	$SQL="select a.stud_id,a.student_sn,b.seme_class from stud_base a ,stud_seme b where  	a.stud_id='$_POST[one_stud_id]' and a.student_sn=b.student_sn and b.seme_year_seme='$seme_year_seme' 	 ";
	$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL); 
	if ($rs->RecordCount()==0) backe("��ͬd����ӥ͸�ơI");
	$obj_stu=$rs->GetArray();
	$obj_stu=$obj_stu[0];
	$class_year=substr($obj_stu[seme_class],0,1);
	$class_sort=substr($obj_stu[seme_class],1,2)+0;
	$SQL="insert into grad_stud (stud_grad_year,class_year,class_sort,stud_id,grad_date,grad_word,grad_num,new_school) values 	('$_POST[Syear]','$class_year','$class_sort','$_POST[one_stud_id]','$_POST[one_date]','$_POST[one_word]','$_POST[one_num]','$_POST[one_school]')";
	$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL); 
	$URL=$_SERVER[PHP_SELF]."?Page=".$_POST[Page]."&Syear=".$_POST[Syear];
	header("Location:$URL");
}
//----�۰ʨ̾Ǹ���J���~��--------------------///
if ($_POST[act]=='UP_stud_id'){
	if (strlen($_POST[auto_stid_id]) > 1)  backe("��ƹL�h");
	$SQL="select stud_id from grad_stud where  stud_grad_year ='$_POST[Syear]' and grad_kind='1' order by stud_id ";
	$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL); 
	if ($rs->RecordCount()==0) backe("��ͬd����ӥ͸�ơI");
	$stu=$rs->GetArray();
	$nformat="%0".$_POST[auto_stid_id]."d";
	for ($i=0;$i<count($stu);$i++){
		$new_nu=sprintf($nformat,$i+1);
		$SQL="update  grad_stud set  grad_num ='$new_nu' where stud_id='".$stu[$i][stud_id]."' and  stud_grad_year ='$_POST[Syear]' ";
		$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		}
	$URL=$_SERVER[PHP_SELF]."?Page=".$_POST[Page]."&Syear=".$_POST[Syear];
	header("Location:$URL");
}
//----�ҮѦr���P�Ǹ��@�P--------------------///
if ($_POST[act]=='UP_by_stud_id'){
	//echo "<pre>";print_r($_POST);die();
	if ($_POST[Syear]=='')  backe("���ǤJ�Ǧ~�סI");
	$SQL="update  grad_stud set  grad_num = stud_id  where  stud_grad_year ='$_POST[Syear]' ";
	$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	$URL=$_SERVER[PHP_SELF]."?Page=".$_POST[Page]."&Syear=".$_POST[Syear];
	header("Location:$URL");
}


//----�۰ʨ̾Ǹ���J�׷~��--------------------///
if ($_POST[act]=='UP_kind_2'){
	if (strlen($_POST[auto_stid_id]) > 1)  backe("��ƹL�h");
	if ($_POST[word_k2]=='')  backe("�п�J�׷~�r");
	$SQL="select stud_id from grad_stud where  stud_grad_year ='$_POST[Syear]' and grad_kind='2' order by stud_id ";
	$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL); 
	if ($rs->RecordCount()==0) backe("��d�L�ǥ͸�ơI");
	$stu=$rs->GetArray();
	$nformat="%0".$_POST[auto_stid_id]."d";
	for ($i=0;$i<count($stu);$i++){
		$new_nu=sprintf($nformat,$i+1);
		$SQL="update  grad_stud set  grad_num ='$new_nu', grad_word='$_POST[word_k2]'  where stud_id='".$stu[$i][stud_id]."' and  stud_grad_year ='$_POST[Syear]' ";
		$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		}
	$URL=$_SERVER[PHP_SELF]."?Page=".$_POST[Page]."&Syear=".$_POST[Syear];
	header("Location:$URL");
}

//---�קﳡ��---------------------///
if ($_POST[act]=='UP_start'){
	if ($_POST[grad_stud]=='') backe("����ǥ�");
	if ($_POST[start_grad_num]=='' && $_POST[start_new_school]=='') backe("��g������");
	if ($_POST[start_grad_num]!='' )	$A=1;
	if ( $_POST[start_new_school]!='')	$B=2;
		$C=$A+$B;
		$format=strlen($_POST[start_grad_num]);
		$f1='%0'.$format.'d';
		$start=$_POST[start_grad_num]+0;
		foreach ($_POST[grad_stud] as $sn =>$NULL ){
			$grad_num=sprintf("$f1",$start);
			switch ($C){
			case 1:
				$SQL="update grad_stud set grad_num ='$grad_num' where grad_sn='$sn' ";				
				break;		
			case 2:
				$SQL="update grad_stud set new_school='$_POST[start_new_school]' where grad_sn='$sn' ";
				break;
			case 3:
				$SQL="update grad_stud set  grad_num ='$grad_num', new_school='$_POST[start_new_school]' where grad_sn='$sn' ";				
				break;			
			default:break;			
			}
			$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL); 						
			$start++;
			}
	$URL=$_SERVER[PHP_SELF]."?Page=".$_POST[Page]."&Syear=".$_POST[Syear];
	header("Location:$URL");
}

//--------��s�浧�Υ���---------------------//
if ($_POST[act]=='UP_OK'){
	if($_POST[Syear]=='0') die();
	$SQL="update grad_stud set stud_grad_year='$_POST[stud_grad_year]',grad_kind ='$_POST[grad_kind]',grad_date ='$_POST[grad_date]' ,grad_word='$_POST[grad_word]', grad_num='$_POST[grad_num]', new_school='$_POST[new_school]'
	 where grad_sn='$_POST[grad_sn]' ";
	$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL); 
	if ($_POST[word_all]=='yes' || $_POST[date_all]=='yes'){
		$SQL="update grad_stud set ";
		($_POST[word_all]=='yes') ? $SQL1=" grad_word='$_POST[grad_word]' ":$SQL1='' ;
		($_POST[date_all]=='yes') ? $SQL2=" grad_date='$_POST[grad_date]' ":$SQL2='';
		if ($_POST[word_all]=='yes' && $_POST[date_all]=='yes') {
			$SQL3=$SQL1." , ".$SQL2;}
		else {
			$SQL3=$SQL1.$SQL2;
		}
		$SQL.=$SQL3." where stud_grad_year='$_POST[Syear]' and  grad_kind='1' ";
		$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL); 
	}
	if ($_POST[kind_all]=='yes'&& $_POST[Syear]==$_POST[stud_grad_year] ){
		$SQL="update grad_stud set grad_kind ='$_POST[grad_kind]' where stud_grad_year='$_POST[Syear]' ";
		$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL); 
	}
	$URL=$_SERVER[PHP_SELF]."?Page=".$_POST[Page]."&Syear=".$_POST[Syear];
	header("Location:$URL");
}

//------�R���浧---------------------//
if ($_POST[act]=='DEL_OK'){
	if($_POST[Syear]=='0') die();
	$SQL="delete from  grad_stud where grad_sn='$_POST[grad_sn]' ";
	$rs=$CONN->Execute($SQL) or die("�L�k�R���A�y�k:".$SQL); 
	$URL=$_SERVER[PHP_SELF]."?Page=".$_POST[Page]."&Syear=".$_POST[Syear];
	header("Location:$URL");
}

//------�R�����~��---------------------//
if ($_POST[act]=='DEL_ALL_OK'){
	if($_POST[Syear]=='0') die();
	$SQL="delete from  grad_stud where stud_grad_year ='$_POST[Syear]' ";
	$rs=$CONN->Execute($SQL) or die("�L�k�R���A�y�k:".$SQL); 
	$URL=$_SERVER[PHP_SELF];
	header("Location:$URL");
}

#############--------SQL�B�z�ϵ��� ----------########################
//�C����ܵ���
$page_size=30;

head("���~�ͳ��W��X");
print_menu($menu_p);
// 1.smarty����]�w
$template_dir = $SFS_PATH."/".get_store_path()."/templates/";
$smarty->left_delimiter="{{";
$smarty->right_delimiter="}}";

//�������Z���s��
$view_course_url=$SFS_PATH_HTML."/modules/stud_report/chc_prn_score.php?list_stud_id=";
$smarty->assign("view",$view_course_url);
//css�˦�
$smarty->assign("css",myheader());
// �����U�Ԧ���ܦ~��
($_GET[Syear]=='') ? $Syear=curr_year():$Syear=$_GET[Syear];
//����
($_GET[Page]=='') ? $Page=0:$Page=$_GET[Page];
$smarty->assign("sel_year",sel_year("Syear",$Syear));
//�����ܪ��U�Ǵ�
$seme_year_seme=sprintf("%03d",$Syear)."2";

// echo "<pre>";print_r(count_grad());
$tol_ary=count_grad();
$total=  ceil($tol_ary[$Syear]/$page_size);//�`����
$page_link='��:';
for ($i=0;$i<$total;$i++){
($i==$Page) ? $page_link.="<U><b>".($i+1)."</b></U>&nbsp;":$page_link.="<a href='$_SERVER[PHP_SELF]?Page=$i&Syear=$Syear'>".($i+1)."</a>&nbsp;";
}
//�e�J�����s��
$smarty->assign("page_link",$page_link);
//�e�J�ثe����
$smarty->assign("Page",$Page);
//�e�J����~��
$smarty->assign("Syear",$Syear);
//�e�JPHP_SELF
$smarty->assign("phpself",$_SERVER[PHP_SELF]);


//�k�k��
$SEX=array(1=>"<font color=#0000FF>�k</font>",2=>"<font color=#FF0000>�k</font>");
$smarty->assign("SEX",$SEX);
$Gkind=array("1"=>"���~","2"=>"�׷~","3"=>"�d��");
$smarty->assign("Gkind",$Gkind);//
$Gkind1=array("1"=>"���~","2"=>"<font color=#0000ff>�׷~</font>","3"=>"<font color=#ff0000>�d��</font>");
$smarty->assign("Gkind1",$Gkind1);//


///��X��ƾ�z PS:������studend_sn
$SQL="select a.*,b.stud_name,b.student_sn,b.stud_sex,b.stud_birthday,c.seme_class,c.seme_num from  grad_stud a,stud_base b ,stud_seme c  where a.stud_grad_year='$Syear' and a.stud_id=b.stud_id and a.stud_id=c.stud_id  and  c.seme_year_seme='$seme_year_seme' and b.student_sn=c.student_sn  order by  c.seme_class,c.seme_num  limit   ".$Page*$page_size." ,$page_size ";
/*
//���q�y�k�M���B�~�B�z��
$SQL="select a.*,b.stud_name,b.stud_sex,b.stud_birthday,c.seme_num,MAX(c.seme_class) as seme_class from  grad_stud a,stud_base b
, stud_seme c  where a.stud_grad_year='$Syear' and a.stud_id=b.stud_id and a.stud_id=c.stud_id 
GROUP BY a.stud_id order by   c.seme_class,c.seme_num  limit   ".$Page*$page_size." ,$page_size ";
*/ 
$rs =$CONN->Execute($SQL) or user_error("Ū�����ѡI<br>$SQL",256) ;
$obj_stu=$rs->GetArray();//echo $SQL;//echo "<pre>";print_r($obj_stu);
//�ഫ�ͤ����
for($i=0;$i<count($obj_stu);$i++){
	$bir=split("-",$obj_stu[$i][stud_birthday]);
	$obj_stu[$i][birth]=($bir[0]-1911)."-".$bir[1]."-".$bir[2];
	}
//�e�J��ܪ��ǥ͸�ư}�C
$smarty->assign("stu",$obj_stu);

//���ǮկZ�ŦW�ٰ}�C�ϥ�sfs_case_dataarray.php����class_base�禡
$class_ary=class_base(sprintf("%03d",$Syear)."2");
$smarty->assign("class_base",$class_ary);




//��ܵe��
$smarty->display($template_dir."stud_grad_edit.htm");

//�G������
foot();

##################�p�Ⲧ�~�ͼƶq�禡##########################
function count_grad(){
	global $CONN ;
	$SQL="select stud_grad_year,count(*) as tol from  grad_stud group by stud_grad_year ";
	$rs =$CONN->Execute($SQL) or user_error("Ū�����ѡI<br>$SQL",256) ; 
   while ($rs and $ro=$rs->FetchNextObject(false)) {
		$obj_stu[$ro->stud_grad_year] = $ro->tol;}
	return $obj_stu;

}



##################�~�ŤU�Ԧ����##########################
function sel_grade($name,$select_t='',$url='') {
	//�W��,�_�l��,������,��ܭ�
	global $IS_JHORES;
($IS_JHORES==6) ? $all_grade=array(7=>"�@�~��",8=>"�G�~��",9=>"�T�~��"):$all_grade=array(1=>"�@�~��",2=>"�G�~��",3=>"�T�~��",4=>"�|�~��",5=>"���~��",6=>"���~��");

$str="<select name='$name' onChange=\"location.href='".$url."'+this.options[this.selectedIndex].value;\">\n";
$str.= "<option value=''>-�����-</option>\n";
foreach($all_grade as $key=>$val) {
 ($key==$select_t) ? $bb=' selected':$bb='';
	$str.= "<option value='$key' $bb>$val</option>\n";
	}

$str.="</select>";
return $str;
 }
###########################################################
##  �ǤJ�~��,�Ǧ~��,�Ǵ� �w�]�Ȭ�all��ܱN�ǥX�Ҧ��~�ŻP�Z��
##  �ǥX�H  class_id  �����ު��}�C  
function get_class_info1($grade='all',$year_seme='') {
	global $CONN ;
//($_GET[Page]=='') ? $Page=0:$Page=$_GET[Page];	
if ($year_seme=='') $year_seme=curr_year();
//	$CID=split("_",$year_seme);//093_1
//	$curr_year=$CID[0]; $curr_seme=$CID[1];
	$curr_year=$year_seme;
	($grade=='all') ? $ADD_SQL='':$ADD_SQL=" and c_year='$grade'  ";
//	$SQL="select class_id,c_name,teacher_1 from  school_class where year='$curr_year' and semester='$curr_seme' and enable=1  $ADD_SQL order by class_id  ";
	$SQL="select class_id,c_name,teacher_1 from  school_class where year='$curr_year' and semester='2' and enable=1  $ADD_SQL order by class_id  ";
	$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	if ($rs->RecordCount()==0) return"�|���]�w�Z�Ÿ�ơI";
	$obj_stu=$rs->GetArray();
	return $obj_stu;

}

##################  �Ǵ��U�Ԧ����禡  ##########################
function sel_year($name,$select_t='') {
	global $CONN ,$Page;
	$SQL = "select * from school_day where  day<=now() and day_kind='start' and seme='2' order by day desc ";
	$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	while(!$rs->EOF){
	$ro = $rs->FetchNextObject(false);
	// ��i$ro=$rs->FetchNextObj()�A���O�ȥΩ�s������adodb�A�ثe��SFS3���A��
//	$year_seme=$ro->year."_".$ro->seme;
	$year_seme=$ro->year;
	$obj_stu[$year_seme]=$ro->year."�Ǧ~�ײ��~��";
	}
//	print_r($obj_stu);
	$str="<select name='$name' onChange=\"location.href='".$_SERVER[PHP_SELF]."?Page=".$Page."&".$name."='+this.options[this.selectedIndex].value;\">\n";
		//$str.="<option value=''>-�����-</option>\n";
	foreach($obj_stu as $key=>$val) {
		($key==$select_t) ? $bb=' selected':$bb='';
		$str.= "<option value='$key' $bb>$val</option>\n";
		}
	$str.="</select>";
	return $str;
	}

#####################   CSS  ###########################
function myheader(){
$str=<<<EOD
<style type="text/css">
.ip12{border-style: solid; border-width: 0px; background-color:#E6ECF0; font-size:12pt;}
.ipmei{border-style: solid; border-width: 0px; background-color:#E6ECF0; font-size:14pt;}
.ipme2{border-style: solid; border-width: 0px; background-color:#E6ECF0; font-size:14pt;color:red;font-family:�з��� �s�ө���;}
.ip2{border-style: solid; border-width: 0px; background-color:#E6ECF0; font-size:11pt;color:red;font-family:�s�ө��� �з���;}
.ip3{border-style: solid; border-width: 0px; background-color:#E6ECF0; font-size:12pt;color:blue;font-family:�s�ө��� �з���;}
.bu1{border-style: groove;border-width:1px: groove;background-color:#CCCCFF;font-size:12px;Padding-left:0 px;Padding-right:0 px;}
.bub{background-color:#FFCCCC;font-size:14pt;}
.bur1{border-style: groove;border-width:1px: groove;background-color:#FFA500;font-size:11px;Padding-left:0 px;Padding-right:0 px;}
.bur2{border-style: groove;border-width:1px: groove;background-color:#FFCCCC;font-size:12px;Padding-left:0 px;Padding-right:0 px;}
.f8{font-size:9pt;color:blue;}
.f9{font-size:9 pt;}
.me{text-decoration:none;color:#009900;font-size:9 pt}
A:link { color: blue }
A:visited { color:blue}
</style>

EOD;

return $str;
}
function backe($st="����!���U��^�W������!") {
echo "<BR><BR><BR><CENTER><form>
	<input type='button' name='b1' value='".$st."' onclick=\"history.back()\" style='font-size:16pt;color:red'>
	</form></CENTER>";
	exit;
	}

