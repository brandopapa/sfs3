<?php
//$Id: chc_guidance.php 6914 2012-09-24 15:44:04Z infodaes $
//�w�]���ޤJ�ɡA���i�����C
include "config.php";

if ($_POST[tea_sn] && $_POST[st_sn]&& $_POST[act]=='write') {
	$day=date("Y-m-d");
	$SQL="insert into stud_guid(st_sn,begin_date,guid_tea_sn) values ('$_POST[st_sn]','$day','$_POST[tea_sn]') ";
	
	$rs = $CONN->Execute($SQL) or die($SQL);
	$URL=$_SERVER[PHP_SELF]."?Seme=".$_POST[Seme]."&Sclass=".$_POST[Sclass];
	header("Location:$URL");
	}

sfs_check();
head("�ӧO���ɬ���");
print_menu($school_menu_p);

// smarty���@�ǳ]�w  -----------------------------------

$template_dir = $SFS_PATH."/".get_store_path()."/templates/";
$tpl_file=$template_dir."chc_guidance.htm";
$smarty->left_delimiter="{{";
$smarty->right_delimiter="}}";

/////  �Hget�覡���o �Ǧ~�Ǵ��ﶵ ------------------
($_GET[Seme]!='') ? $Seme=$_GET[Seme]:$Seme=sprintf("%03d",curr_year()).curr_seme();
/////  �Hget�覡���o �Z�ſﶵ ------------------
if($_GET[Sclass]!='') $Sclass=$_GET[Sclass];
/////  �Y���o��Z�ſﶵ �h�N�ȱa�J��椤 �Ϩ� selected ------------------
($Sclass) ? $LINK=link_a($Seme,$Sclass): $LINK=link_a($Seme);
/////  �]�w�@�Ӱ}�C,�N�ʧO�ର���� ------------------
$SEX=array(1=>"<img src=images/boy.gif height=25>",2=>"<img src=images/girl.gif height=25>");
//////  �qSFS3���ت��禡���Ǯո�ƨ禡---------------------
$sch_data=get_school_base();
$stud_coud=study_cond();


///// �L�X�~�Z�ŤU�Կ�� ------------------------------------
echo "
<TABLE border=0 width=100% style='font-size:11pt;'  cellspacing=1 cellpadding=0 bgcolor=#9EBCDD>
<TR bgcolor=#9EBCDD><FORM name=p2><TD>�@�Ǵ�:<INPUT TYPE='text' NAME='Seme' value='$Seme' size=6 class=ipmei><INPUT TYPE='submit' value='����'>�@�@  $LINK
</TD></TR></FORM></TABLE>";

///// ���}��GET�ǤJ��(�Ǵ�_�~�Z)�ܼ�,�H���o�~�Z�� ------------------------------------
	$Class=split("_",$Sclass);

///// ��Ǵ��Φ~�Z��Ƴ�����,�Y����sql�H���o�ӾǴ��Ҧ��ǥ͸��-----------------------
if ($Sclass && $Seme){
	$SQL="select a.student_sn,a.stud_id,a.stud_name,a.stud_sex,a.stud_study_cond,b.seme_num from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme ='$Seme' and b.seme_class='".$Class[1]."' order by b.seme_num ";
//	$SQL1="select a.student_sn,a.stud_id,a.stud_name,a.stud_sex,a.stud_study_cond,b.seme_num, stud_guid.guid_tea_sn  	from stud_base a,stud_seme b  left join stud_guid on a.student_sn=stud_guid.st_sn where a.student_sn=b.student_sn and b.seme_year_seme ='$Seme' and b.seme_class='".$Class[1]."' order by b.seme_num ";
//	$SQL2="select a.student_sn,a.stud_id,a.stud_name,a.stud_sex,a.stud_study_cond,b.seme_num, stud_guid.guid_tea_sn  	from stud_base a,stud_seme b  left join stud_guid on student_sn=st_sn where a.student_sn=b.student_sn and b.seme_year_seme ='$Seme' and b.seme_class='".$Class[1]."' order by b.seme_num ";
	$rs=$CONN->Execute($SQL) or die("�L�k���o�Z�žǥ͸�ơI<br>".$SQL); 
//	if (!$rs) $rs=$CONN->Execute($SQL2)or die("�L�k�d�ߡA�y�k:".$SQL2); 
	 
	$All_stu=$rs->GetArray();
	foreach($All_stu as $key=>$value){
		//����{���O��
		$student_sn=$value['student_sn'];
		$sql="SELECT a.*,b.name FROM stud_guid a LEFT JOIN teacher_base b ON a.guid_tea_sn=b.teacher_sn WHERE a.st_sn=$student_sn order by begin_date";
		$rs=$CONN->Execute($sql) or die("�L�k���o�ǥͻ{���O����ơI<br>".$sql);
		$guid_record='';
		while(!$rs->EOF){
			$guid_c_id=$rs->fields[guid_c_id];
			$begin_date=$rs->fields[begin_date];
			$end_date=$rs->fields[end_date];
			$guid_c_isover=$rs->fields[guid_c_isover];
			$name=$rs->fields[name];
			$font_color=$guid_c_isover?'#880088':'#ff0000';
			$guid_record.="<li><a href='./guid_prt.php?guid=$guid_c_id&kind=REC' target='rec_$guid_c_id'><font size=1 color='$font_color'>$begin_date~$end_date $name</font></a></li>";			
			$rs->MoveNext();
		}
		$All_stu[$key]['guid_record']=$guid_record;	
	}
}
//echo "<pre>";	
//print_r($All_stu);
//echo "</pre>";	


	$tea_all=get_tea_data();

///  �Y��ܾǥ�,�h�i��ǥ͸���^��  ------------------------------------
if($_GET[st_sn]){
	$stud_data=get_stu_data($_GET[st_sn],$Seme);
	$smarty->assign("stu", $stud_data);
	$smarty->assign("PHP_SELF",$_SERVER[PHP_SELF]);
	}

// smarty �����ܼƳB�z  -----------------------------------
$smarty->assign("tea_all",$tea_all);

$smarty->assign("sel_teach",$tea_all);
$smarty->assign("stud_coud",$stud_coud);
$smarty->assign("data",$All_stu);
$smarty->assign("SEX",$SEX);
$smarty->display($tpl_file);

foot();

?>
