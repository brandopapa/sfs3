<?php
//$Id: chc_940622.php 5310 2009-01-10 07:57:56Z hami $
/*�ޤJ�ǰȨt�γ]�w��*/
require "config.php";
//require "../../include/sfs_core_schooldata.php";
//�q�X�����������Y
$stud_kind_ary=array("0"=>"�@���","1"=>"�S�]��","2"=>"���M�L�P�Z","3"=>"���M�L���P�Z");
sfs_check();

if ($_POST[act]=='update' && $_POST[newstud_sn]!='' && $_POST[stud_kind]!='' && $_POST[stud_study_year]!='' ){
		$bao_id = strtoupper($_POST[bao_id]);
	if ($_POST[temp_id]==$bao_id && ($_POST[stud_kind]=='2'|| $_POST[stud_kind]=='3')) backe('�z��J�F�ۦP���y�����I');
		$stud_study_year=$_POST[stud_study_year];
	if ( $_POST[stud_kind]!='2'){
		$SQL="select  newstud_sn,temp_id,stud_kind,bao_id from new_stud where newstud_sn='$_POST[newstud_sn]' and stud_study_year='$stud_study_year'  ";
		$rs=$CONN->Execute($SQL) or die($SQL);
		$arr=$rs->GetArray();
		$arr=$arr[0];
		if ($arr[stud_kind]=='2' || $arr[stud_kind]=='3'  ) {
			$SQL="update new_stud set  stud_kind ='0',bao_id=''  where  temp_id='".$arr[bao_id]."'  and stud_study_year='$stud_study_year' ";
			$rs=$CONN->Execute($SQL) or die($SQL);
			$SQL="update new_stud set  stud_kind ='$_POST[stud_kind]',bao_id=''  where newstud_sn='$_POST[newstud_sn]' and stud_study_year='$stud_study_year'  ";
			$rs=$CONN->Execute($SQL) or die($SQL);
		} else{
			$SQL="update new_stud set  stud_kind ='$_POST[stud_kind]'  where newstud_sn='$_POST[newstud_sn]'  and stud_study_year='$stud_study_year' ";
			$rs=$CONN->Execute($SQL) or die($SQL);
			}
		}
	if ( $_POST[stud_kind]=='2' || $_POST[stud_kind]=='3' ){
		$kind=$_POST[stud_kind];
		$SQL="select  newstud_sn,temp_id from new_stud where temp_id='$bao_id'  and stud_study_year='$stud_study_year'  ";
		$rs=$CONN->Execute($SQL) or die($SQL);
		if ($rs->RecordCount()!=1) backe('�ӽs���d�L�����ǥ͡I');
		$arr=$rs->GetArray();
		$arr=$arr[0];
		$SQL="update new_stud set  stud_kind ='$kind',bao_id='$_POST[temp_id]'  where newstud_sn='".$arr[newstud_sn]."'  and stud_study_year='$stud_study_year' ";
		$rs=$CONN->Execute($SQL) or die($SQL);
		$SQL="update new_stud set  stud_kind ='$kind',bao_id='$bao_id'  where newstud_sn='$_POST[newstud_sn]'  and stud_study_year='$stud_study_year' ";
		$rs=$CONN->Execute($SQL) or die($SQL);
		}
	$URL=$_SERVER[PHP_SELF]."?year=".$stud_study_year."&page=".$_POST[page];
	header("location:$URL");
}
head("�s�ͽs�Z");
print_menu($menu_p);
##################�}�C�C�ܨ禡2##########################
// 1.smarty����
//$template_dir = $SFS_PATH."/".get_store_path()."/templates/";
$smarty->left_delimiter="{{";
$smarty->right_delimiter="}}";
$template_file= $SFS_PATH."/".get_store_path()."/chc_940622.htm";



$SQL="select  stud_study_year from new_stud group by stud_study_year order by stud_study_year desc  ";
$rs=$CONN->Execute($SQL) or die($SQL); 
$year_arr=$rs->GetArray();
$smarty->assign("year_arr",$year_arr);

if ($_GET[year]!=''){
	($_GET[page]=='') ? $page=0:$page=$_GET[page];
	$SQL="select  newstud_sn  from new_stud where stud_study_year='$_GET[year]' and  sure_study='1' ";
	$rs=$CONN->Execute($SQL) or die($SQL); 
	$num=$rs->RecordCount();
	$page_size=50;
	$total= ceil($rs->RecordCount()/$page_size);//�`����
	$page_link='��:';
	for ($i=0;$i<$total;$i++){
	($i==$page) ? $page_link.="<b>[<U>".($i+1)."</U>]</b> ":$page_link.="<a href='$_SERVER[PHP_SELF]?year=$_GET[year]&page=$i'>".($i+1)."</a> ";
	}

	$SQL="select * from new_stud where stud_study_year='$_GET[year]' and  sure_study='1' order by temp_id limit ".$page*$page_size.",$page_size ";
	$rs=$CONN->Execute($SQL) or die($SQL); 
	$stu=$rs->GetArray();
	for ($i=0;$i<count($stu);$i++){
		if ($stu[$i][stud_kind]=='') $stu[$i][stud_kind]='0';
	}

	$smarty->assign("LINK",$page_link);//���Ƴs���r��
	$smarty->assign("page",$page);//�ثe�������
	$smarty->assign("stu",$stu);//�ǥ͸��
	$smarty->assign("stud_kind",$stud_kind_ary);//�ǥ����O
	$smarty->assign("SEX",array(1=>"<FONT COLOR='blue'>�k</FONT>",2=>"<FONT  COLOR='red'>�k</FONT>"));//�ǥ����O
	$SQL="select temp_id,stud_name  from new_stud where stud_study_year='$_GET[year]' and  sure_study='1' ";
	$rs=$CONN->Execute($SQL) or die($SQL); 
	while ($ro=$rs->FetchNextObject(false)) {
		$temp_id_name[$ro->temp_id]=$ro->stud_name;
		}
	$smarty->assign("temp_id_name",$temp_id_name);//�ǥͩm�W
}

$smarty->assign("PHP_SELF",$_SERVER[PHP_SELF]);
$smarty->display($template_file);


foot();

##################�^�W���禡1#####################
function backe($st="����!���U��^�W������!") {
	echo "<HTML><HEAD><META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=big5\">
<TITLE>$st</TITLE></HEAD><BODY background='images/bg.jpg'>\n";
echo"<BR><BR><BR><BR><CENTER><form>
	<input type='button' name='b1' value='$st' onclick=\"history.back()\" style='font-size:16pt;color:red'>
	</form></CENTER>";
	exit;
	}


?>
