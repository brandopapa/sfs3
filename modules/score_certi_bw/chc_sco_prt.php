<?php


//�w�]���ޤJ�ɡA���i�����C
include "config.php";




sfs_check();

head("���Z�����q�Ϊ�");
print_menu($menu_p);


// smarty���@�ǳ]�w  -----------------------------------
$template_dir = $SFS_PATH."/".get_store_path()."/templates";
//  �Ҧ����˥���   ------------------------------------
$tpl_file=$template_dir."/elps.htm";
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


/////    �qSFS3���ت��禡���o���y��ƥN�X  -------------------
$stud_coud=study_cond();
//////  �qSFS3���ت��禡���Ǯո�ƨ禡---------------------
$sch_data=get_school_base();


///// �L�X�~�Z�ŤU�Կ�� ------------------------------------
echo "
<TABLE border=0 width=100% style='font-size:11pt;'  cellspacing=1 cellpadding=0 bgcolor=#9EBCDD>
<TR bgcolor=#9EBCDD><FORM name=p2><TD  nowrap> $LINK
&nbsp;�d�ߪ��Ǧ~��&nbsp;<INPUT TYPE='text' NAME='Seme' value='$Seme' size=6 class=ipmei>
<INPUT TYPE='submit' value='��^'>
</TD></TR></FORM></TABLE>";

///// ���}��GET�ǤJ��(�Ǵ�_�~�Z)�ܼ�,�H���o�~�Z�� ------------------------------------
	$Class=split("_",$Sclass);

///// ��Ǵ��Φ~�Z��Ƴ�����,�Y����sql�H���o�ӾǴ��Ҧ��ǥ͸��-----------------------
if ($Sclass && $Seme){
	$SQL="select a.student_sn,a.stud_id,a.stud_name,a.stud_sex,a.stud_study_cond,b.seme_num from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme ='$Seme' and b.seme_class='".$Class[1]."' order by b.seme_num ";
	$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	$All_stu=$rs->GetArray();
	}

///  �Y��ܾǥ�,�h�i��ǥ͸���^��  ------------------------------------
if($_GET[st_sn]){
	$stud_data=new data_stud($_GET[st_sn]);
	$smarty->assign("stu", $stud_data);
	$Seme_arry=array();
	for ($i=0;$i<count($stud_data->class_detail);$i++){
		$Seme_arry[$i][all]=$stud_data->class_detail[$i];
		$aa=split("_",$stud_data->class_detail[$i]);
		$Seme_arry[$i][year]=$aa[0];
		$Seme_arry[$i][seme]=$aa[1];
		}
	$smarty->assign("stu_seme",$Seme_arry);
	}


// smarty �����ܼƳB�z  -----------------------------------
$smarty->assign("stud_coud",$stud_coud);
$smarty->assign("data",$All_stu);
$smarty->assign("SEX",$SEX);
$smarty->display($tpl_file);
foot();


?>
