<?php
//$Id: fix_print.php 5310 2009-01-10 07:57:56Z hami $
require_once("config.php");
require_once("chi_fun.php");
//�ϥΪ̻{��
sfs_check();

if ($_POST[act]=='OK'){
	if ($_POST[year_seme]=='' || $_POST[grade]=='' ||  $_POST[url_class_id]=='') backe("�L�k����");
	$SQL = "update score_ss set scope_id='$_POST[scope]',
	subject_id='$_POST[subject]',class_id='$_POST[class_id]',
	class_year='$_POST[class_year]',enable='$_POST[enable]',need_exam='$_POST[need_exam]',rate='$_POST[rate]',
	sort='$_POST[sort]',sub_sort='$_POST[sub_sort]',print='".$_POST["print"]."',link_ss='$_POST[link_ss]'  where ss_id='$_POST[ss_id]'";
	$rs=$CONN->Execute($SQL) or die("�L�k����A�y�k:".$SQL);
	$URL=$_SERVER[PHP_SELF]."?year_seme=".$_POST[year_seme]."&grade=".$_POST[grade]."&class_id=".$_POST[url_class_id];
	header("Location:$URL");
}





head("�ҵ{�ץ�");
print_menu($school_menu_p);

##################�}�C�C�ܨ禡2##########################
// 1.smarty����
	$template_dir = $SFS_PATH."/".get_store_path()."/templates/";
	$smarty->left_delimiter="{{";
	$smarty->right_delimiter="}}";

// 2.�P�_�Ǧ~��
	($_GET[year_seme]=='') ? $year_seme=curr_year()."_".curr_seme():$year_seme=$_GET[year_seme];

// 3.�����U�Ԧ���ܾǴ�
	$smarty->assign("sel_year",sel_year('year_seme',$year_seme));//�Ǧ~�׿��

// 4.�����U�Ԧ���ܦ~��
	$url=$_SERVER[PHP_SELF]."?year_seme=".$year_seme."&grade=";
	$smarty->assign("sel_grade",sel_grade('grade',$_GET[grade],$url));//�~�ſ��

// 5.�Y����ܯZ��  �����Z�ſ�ܰ� ,�P�_�O�_�ǭ�  �A�C�X�U�Z�H�ѿ�� 
if($year_seme!='' && $_GET[grade]!='' ){
	$all_class_array=get_class_info1($_GET[grade],$year_seme);
	$num=count($all_class_array);
	$num_max=(ceil($num/10))*10;
	$prt_ary=array();
	for($i=0;$i<$num_max;$i++){
		if($all_class_array[$i][class_id]!='') { 
			$class_word=($all_class_array[$i][c_name]=="���~��") ? "":"�Z";
			$prt_ary[$i][class_id]=$all_class_array[$i][class_id];
			$bgcolor=($_GET[class_id]==$all_class_array[$i][class_id]) ? "bgcolor=#FFEBD6":"";
			$prt_ary[$i][c_name]="<TD width=10% $bgcolor><LABEL><INPUT TYPE='checkbox' NAME='class_id[]' ";
			$prt_ary[$i][c_name].=" value='".$all_class_array[$i][class_id]."' ";
			$prt_ary[$i][c_name].="onclick='jamp(this.value);' >";
			$prt_ary[$i][c_name].=$all_class_array[$i][c_name].$class_word."</LABEL></TD>\n";
			//".$all_class_array[$i][class_id]."]'
		}else {
			$prt_ary[$i][class_id]="";
			$prt_ary[$i][c_name]="<TD width=10%>&nbsp;</TD>";
			}
	}

	$smarty->assign("sel_class",$prt_ary);
	}//end if 
	else {
	$smarty->assign("sel_class","<CENTER>�ϥΤ覡�G����Ǵ��A�A��~�šI</CENTER>");
	}

##################�C�ܽҵ{�N�X##########################
if ($_GET[class_id]!=''){
	$smarty->assign("PHP_SELF",$_SERVER[PHP_SELF]);
	$ss_ary=get_subj2($_GET[class_id]);//���o�ҵ{���score_ss
	$scope_name=get_subj3("scope");//�����W
	$subj_name=get_subj3("subject");//����ئW

	$smarty->assign("ss_ary",$ss_ary);//�e�J�ҵ{���score_ss
	$smarty->assign("scope",$scope_name);//�e�J���W
	$smarty->assign("subj",$subj_name);//�e�J��ئW
	$smarty->assign("myheader",myheader());//�e�JCSS
	}

$smarty->display("$template_dir/fix_print.htm");


foot();

?>
