<?php

//���J�]�w��
require("config.php");

// �{���ˬd
sfs_check();
($IS_JHORES==0) ? $UP_YEAR=6:$UP_YEAR=9;//�P�_�ꤤ�p
//���o�l���
if ($_GET[smenu]=='') header("Location:$_SERVER[PHP_SELF]?smenu=grad");

// 2.�P�_�Ǧ~��,�u���~�קY�i
($_GET[year_seme]=='') ? $year_seme=curr_year():$year_seme=$_GET[year_seme];
($_GET[smenu]=='') ? $smenu="grad" : $smenu=$_GET[smenu];

//���o�Ӧ~�ײ��~�Z�ɾǾǮ�//
$temp_grade = get_grade_school_table($year_seme);
//�[�Jkey
foreach($temp_grade as $name_1){	$daa[$name_1]=$name_1;	}
$temp_grade=$daa;

head("���~�ͳ��W��X");//�׶}win�O�d�r
print_menu($menu_p);


//�l���}�C
$menu2=array(
"grad"=>"���~�ͦW�U(A�榡)",
"grad2"=>"���~�ͦW�U(B�榡)",
"school"=>"�ɾǾǮզW�U(�v�Z)",
"school2"=>"�ɾǾǮզW�U(�v��)"
);


// 1.smarty����]�w
$template_dir = $SFS_PATH."/".get_store_path()."/templates/";
$smarty->left_delimiter="{{";
$smarty->right_delimiter="}}";


//css�˦�
$smarty->assign("css",myheader());
//�\��l���
$smarty->assign("menu",$menu2);
//��ܪ��l���
$smarty->assign("smenu",$smenu);



// �����U�Ԧ���ܦ~��
$smarty->assign("sel_year",sel_year("year_seme",$year_seme));
//�����~��
$smarty->assign("year_seme",$year_seme);



//print_r($temp_grade);


///�U�Z�C��B�z
if($year_seme!='' ){
//echo "OK";
	//���~�ůZ�Ÿ��
	$all_class_array=get_class_info1( $UP_YEAR,$year_seme);
	//�Z�ŭp��
	$num=count($all_class_array);
	//�Z�ŭp��
	$num_max=(ceil($num/10))*10;
	$prt_ary=array();
	//�]�j��N�����@�檺��ܸ�Ƹɨ�,�D�ܬ��[
	for($i=0;$i<$num_max;$i++){
		if($all_class_array[$i][class_id]!='') { 
			$prt_ary[$i][class_id]=$all_class_array[$i][class_id];
			$prt_ary[$i][c_name]="<TD width=10%><LABEL><INPUT TYPE='checkbox' NAME='class_id[".$all_class_array[$i][class_id]."]' >".$all_class_array[$i][c_name]."�Z</LABEL></TD>\n";
		}else {
			$prt_ary[$i][class_id]="";
			$prt_ary[$i][c_name]="<TD width=10%>&nbsp;</TD>";
			}
	}

	if ($_GET[smenu]=='school')	$smarty->assign("school",$temp_grade);
	if ($_GET[smenu]=='school2')	$smarty->assign("school2",$temp_grade);	
	$smarty->assign("phpself",$_SERVER[PHP_SELF]);
	$smarty->assign("sel_class",$prt_ary);
//	$smarty->assign("click_button",$click_button);


	}//end if 

$smarty->display($template_dir."stud_grad_list.htm");

//�G������
foot();





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
	global $CONN ;
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
	$str="<select name='$name' onChange=\"location.href='".$_SERVER[PHP_SELF]."?smenu=".$_GET[smenu]."&".$name."='+this.options[this.selectedIndex].value;\">\n";
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
?>