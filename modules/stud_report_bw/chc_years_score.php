<?php
require_once("./chc_config.php");

//�{��

sfs_check();


//�q�X�����������Y
myheader();
head("�����Ǵ����Z");
print_menu($school_menu_p);
##################�}�C�C�ܨ禡2##########################
// 1.smarty����
$template_dir = $SFS_PATH."/".get_store_path()."/templates/";
$smarty->left_delimiter="{{";
$smarty->right_delimiter="}}";

// 2.�P�_�Ǧ~��
	($_GET[year_seme]=='') ? $year_seme=curr_year()."_".curr_seme():$year_seme=$_GET[year_seme];

// 3.�����U�Ԧ���ܾǴ�
	$smarty->assign("sel_year",sel_year('year_seme',$year_seme));

// 4.�����U�Ԧ���ܦ~��
	$url=$_SERVER[PHP_SELF]."?year_seme=".$year_seme."&grade=";
	$smarty->assign("sel_grade",sel_grade('grade',$_GET[grade],$url));
	$smarty->assign("phpself",$_SERVER[PHP_SELF]);
	$smarty->assign("input_txt",$input_txt);
	$smarty->assign("add_memo_file",$add_memo_file);
	$smarty->assign("school_name",$sch_data[sch_cname]);

// 5.�Y����ܯZ��  �����Z�ſ�ܰ� ,�P�_�O�_�ǭ�  �A�C�X�U�Z�H�ѿ�� 
if($year_seme!='' && $_GET[grade]!='' ){
	$all_class_array=get_class_info1($_GET[grade],$year_seme);
	$num=count($all_class_array);
	$num_max=(ceil($num/10))*10;
	$prt_ary=array();
	for($i=0;$i<$num_max;$i++){
		if($all_class_array[$i][class_id]!='') { 
			$prt_ary[$i][class_id]=$all_class_array[$i][class_id];
			$prt_ary[$i][c_name]="<TD width=10%><LABEL><INPUT TYPE='checkbox' NAME='class_id[".$all_class_array[$i][class_id]."]' >".$all_class_array[$i][c_name]."�Z</LABEL></TD>\n";
		}else {
			$prt_ary[$i][class_id]="";
			$prt_ary[$i][c_name]="<TD width=10%>&nbsp;</TD>";
			}
	}

	$smarty->assign("sel_class",$prt_ary);
	$smarty->assign("click_button",$click_button);


	}//end if 
else {
	$smarty->assign("sel_class","<CENTER>�ϥΤ覡�G����Ǵ��A�A��~�šI</CENTER>");
}

$smarty->display($template_dir."chc_940526.htm");

//�G������
foot();
#####################   CSS  ###########################
function myheader(){
?>
<style type="text/css">
body{background-color:#f9f9f9;font-size:12pt}
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
</style><?php
}

##################  �Ǵ��U�Ԧ����禡  ##########################
function sel_year($name,$select_t='') {
	global $CONN ;
	$SQL = "select * from school_day where  day<=now() and day_kind='start' order by day desc ";
	$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	while(!$rs->EOF){
	$ro = $rs->FetchNextObject(false);
	// ��i$ro=$rs->FetchNextObj()�A���O�ȥΩ�s������adodb�A�ثe��SFS3���A��
	$year_seme=$ro->year."_".$ro->seme;
	$obj_stu[$year_seme]=$ro->year."�Ǧ~�ײ�".$ro->seme."�Ǵ�";
	}
	$str="<select name='$name' onChange=\"location.href='".$_SERVER[PHP_SELF]."?".$name."='+this.options[this.selectedIndex].value;\">\n";
		//$str.="<option value=''>-�����-</option>\n";
	foreach($obj_stu as $key=>$val) {
		($key==$select_t) ? $bb=' selected':$bb='';
		$str.= "<option value='$key' $bb>$val</option>\n";
		}
	$str.="</select>";
	return $str;
	}


##################�}�C�C�ܨ禡2##########################
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
if ($year_seme=='') {
	$curr_year=curr_year(); $curr_seme=curr_seme();}
else {
	$CID=split("_",$year_seme);//093_1
	$curr_year=$CID[0]; $curr_seme=$CID[1];}
	($grade=='all') ? $ADD_SQL='':$ADD_SQL=" and c_year='$grade'  ";
	$SQL="select class_id,c_name,teacher_1 from  school_class where year='$curr_year' and semester='$curr_seme' and enable=1  $ADD_SQL order by class_id  ";
	$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	if ($rs->RecordCount()==0) return"�|���]�w�Z�Ÿ�ơI";
	$obj_stu=$rs->GetArray();
	return $obj_stu;
}
?>












