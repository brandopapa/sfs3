<?php
//$Id: mgr_prt_new.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";
//�{��
sfs_check();

#####################   �v���ˬd�P�ɶ�  ###########################
if($_GET[mid] || $_POST[mid] ) {
	($_GET[mid] == '') ? $cmid=$_POST[mid]: $cmid=$_GET[mid];
	if(ch_mid_t($cmid)!=3 ) backe("�D�ާ@�ɶ�");
	}
$ad_array=who_is_root();
if (!is_array($ad_array[$_SESSION[session_tea_sn]])){
if ($_POST[mid] || $_GET[mid] || $_POST[main_id] ) {
	$bb='';
	($_POST[mid]!='' ) ? $bb=$_POST[mid]:$bb;
	($_GET[mid]!='' ) ? $bb=$_GET[mid]:$bb;
	($_POST[main_id]!='' ) ? $bb=$_POST[main_id]:$bb;
if (check_man($_SESSION[session_tea_sn],$bb ,1)!='YES'   ) backe("�z�L�v���ާ@");
	if(ch_mid_t($bb)!=3) backe("�D�ާ@�ɶ�");

}}

#####################   �v���ˬd�P�ɶ�  ###########################

if ($_GET[mid] && $_GET[item] && $_GET[Spk] && $_GET[kitem]){
	$SQL="select a.*,b.title,count(c.id) as nu_all from sport_item a ,sport_main b ,sport_res c where a.id ='$_GET[item]' and a.mid=b.id  and c.itemid='$_GET[item]' group by a.id ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();
	$item_info=$arr[0];//���X���ظ�T
	$sport_group=ceil($item_info[nu_all]/$item_info[playera]);//�����ռ�
	$LimtA=($_GET[Spk]-1)*$item_info[playera];
	$La=$LimtA+1;
	$Lb=$_GET[Spk]*$item_info[playera];
	if ($item_info[sportkind]==5){
		$SQL="select * from sport_res  where itemid ='$_GET[item]' and kmaster='2' and sportorder >= '$La' and  sportorder <= '$Lb' order by sportorder ";
	}else {
		$SQL="select * from sport_res  where itemid ='$_GET[item]' and mid='$_GET[mid]' and sportorder >= '$La' and  sportorder <= '$Lb' order by sportorder ";
		}
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();//�������
	$how_maney=$rs->RecordCount();//�Ӳղ{���H��
	$start_num=$sport_GO_num[$how_maney];//�_�l�D��
	$work_stu=array();//�Ű}�C
// ----------�B�z�D��(����sportorder�w��)----------------------
if ($_GET[ord]=='na'){
//	for($i=0;$i<$GO_num_data[num];$i++){$work_stu[$i][line]=$i+1;}
	for($i=0;$i<$GO_num_data[num];$i++){
		$key=$i-$start_num+1;//�p��D������$i�P��Ư���$arr�t����
		if ($key>=0 && $arr[$key]!=''){
		($item_info[sportkind]==5) ? $arr[$key][view_class]=$arr[$key][idclass]."�Z_".$arr[$key][kgp]:$arr[$key][view_class]=substr($arr[$key][idclass],1,2)."�Z".substr($arr[$key][idclass],3,2)."��";
		}
		$work_stu[$i]=$arr[$key];
		$work_stu[$i][line]=$i+1;//�[�J�D���s��
	}
}

// ----------�B�z�D��(��sportorder�w��)----------------------
if ($_GET[ord]=='local'){
	for($i=0;$i<$GO_num_data[num];$i++){
		$now=($_GET[Spk]-1)*$GO_num_data[num]+1+$i;//�p��D����
		for($y=0;$y<$rs->RecordCount();$y++){
			if ($arr[$y][sportorder]==$now) {
			($item_info[sportkind]==5) ? $arr[$y][view_class]=$arr[$y][idclass]."�Z_".$arr[$y][kgp]:$arr[$y][view_class]=substr($arr[$y][idclass],1,2)."�Z".substr($arr[$y][idclass],3,2)."��";
			$work_stu[$i]=$arr[$y];
			}//end if 
			}//end for $y
		$work_stu[$i][line]=$i+1;
	}//end for $i
}	//end $GET[ord]


// smarty �B�z  -----------------------------------
$template_dir = $SFS_PATH."/".get_store_path()."/templates";
$my_tpl=$template_dir."/my_1.htm";
(file_exists($my_tpl)) ? $tpl_file=$my_tpl:$tpl_file=$template_dir."/elps.htm";

$smarty->left_delimiter="{{";
$smarty->right_delimiter="}}";


$smarty->assign("school_name",$SCHOOL_BASE[sch_cname_s]);//�զW
$smarty->assign("item",$item_info);//���ظ�T
$smarty->assign("sportname",$sportname);//���ɦW��
$smarty->assign("sportclass",$sportclass);//�@�k�@�k���W��
$smarty->assign("itemkind",$itemkind);//���ɨM��
$smarty->assign("sport_group",$sport_group);//�էO��
$smarty->assign("data",$work_stu);
$smarty->assign("data2",$work_stu);
$smarty->display($tpl_file);

}

?>