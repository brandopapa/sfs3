<?php
//$Id: fix_score.php 5310 2009-01-10 07:57:56Z hami $
include_once "config.php";

include "../../include/sfs_case_dataarray.php";
include_once "../../include/sfs_case_PLlib.php";


//�ϥΪ̻{��
sfs_check();
##################��s  ���y���###########################
if($_POST[act]=='do_change1' && $_POST[SCO_TAB]!='' && $_POST[student_sn]!='' && $_POST[year_seme]!=''  ){
if ($_POST[score_id] =='') die(backinput("����ܨ��@����ơA���U�᭫��I"));
for($i=0;$i<count($_POST[score_id]);$i++) {
	list($key,$val)=each($_POST[score_id]);
	$SQL="update $_POST[SCO_TAB] set class_id='$_POST[class_id]' where score_id='$key' ";
	$rs=$CONN->Execute($SQL) or die(backinput());
	}
	$url=$_SERVER[PHP_SELF]."?st_sn=".$_POST[student_sn]."&year_seme=".$_POST[year_seme];
	header("Location:$url");
}
##################��s  �Ǵ����###########################
if($_POST[act]=='do_change2' && $_POST[SCO_TAB]!='' && $_POST[student_sn]!='' && $_POST[year_seme]!=''  ){
if ($_POST[score_id] =='') die(backinput("����ܨ��@����ơA���U�᭫��I"));
if ($_POST[My_class_id] =='') die(backinput("����J�Ǵ��~�Z��ơA���U�᭫��I"));
for($i=0;$i<count($_POST[score_id]);$i++) {
	list($key,$val)=each($_POST[score_id]);
	$SQL="update $_POST[SCO_TAB] set class_id='$_POST[My_class_id]' where score_id='$key' ";
	$rs=$CONN->Execute($SQL) or die(backinput());
	}
	$url=$_SERVER[PHP_SELF]."?st_sn=".$_POST[student_sn]."&year_seme=".$_POST[year_seme];
	header("Location:$url");
}
##################�R�����###########################
if($_POST[act]=='del_data' && $_POST[SCO_TAB]!='' && $_POST[student_sn]!='' && $_POST[year_seme]!=''  ){
if ($_POST[score_id] =='') die(backinput("����ܧR�����@����ơA���U�᭫��I"));
for($i=0;$i<count($_POST[score_id]);$i++) {
	list($key,$val)=each($_POST[score_id]);
	$SQL="delete from  $_POST[SCO_TAB]  where student_sn='$_POST[student_sn]' and score_id='$key' ";
	$rs=$CONN->Execute($SQL) or die(backinput());
	}
	$url=$_SERVER[PHP_SELF]."?st_sn=".$_POST[student_sn]."&year_seme=".$_POST[year_seme];
	header("Location:$url");
}
##################sendmit���###########################
if($_POST[act]=='do_sendmit' && $_POST[SCO_TAB]!='' && $_POST[student_sn]!='' && $_POST[year_seme]!=''  ){
if ($_POST[score_id] =='') die(backinput("����ܨ��@����ơA���U�᭫��I"));
if ($_POST[sendmit] =='') die(backinput("�ж�g sendmit �ȡA���U�᭫��I"));
for($i=0;$i<count($_POST[score_id]);$i++) {
	list($key,$val)=each($_POST[score_id]);
	$SQL="update $_POST[SCO_TAB] set sendmit='$_POST[sendmit]' where score_id='$key' ";
	$rs=$CONN->Execute($SQL) or die(backinput());
	}
	$url=$_SERVER[PHP_SELF]."?st_sn=".$_POST[student_sn]."&year_seme=".$_POST[year_seme];
	header("Location:$url");
}

head("���Z�ץ��u��");
print_menu($school_menu_p);


if($_POST[stud_id]!='') {
	$SQL="select * from stud_base where stud_id='$_POST[stud_id]' ";
	$arr_a=get_order2($SQL);
	}
if($_GET[st_sn]!='') {
	$SQL="select * from stud_base where student_sn='$_GET[st_sn]' ";
	$arr_a=get_order2($SQL);
	$SQL="select * from  stud_seme where student_sn='$_GET[st_sn]'  order by seme_year_seme ";
	$arr_b=get_order2($SQL);
	}
if($_GET[st_sn]!='' && $_GET[year_seme]!='') {
	$Score_Table="score_semester_".sprintf("%d",substr($_GET[year_seme],0,3))."_".substr($_GET[year_seme],3,1);
	//�ӾǴ����Z��
	$SQL="select * from  $Score_Table where student_sn='$_GET[st_sn]' order by ss_id ,test_sort ";
	$rs=$CONN->Execute($SQL) or die(backinput());
	$arr_sco = $rs->GetArray();
///////////////// ���Z�������--�����ئW�ٸ�� �}�C//////////////////////////
	$SQL="select subject_id, subject_name from score_subject order by  subject_id ";
	$subj=initArray("id,sname",$SQL);//������W�ٸ��
	$SQL="select ss_id,scope_id ,subject_id from score_ss where  enable='1'  ";
	$ss_3=initArray3("SS,Sa,Sb",$SQL);//��SS_ID���
/////////////////�[�J�����ئW��/////////////////
	for($i=0;$i<count($arr_sco);$i++){
		$SS=$arr_sco[$i][ss_id];
		$arr_sco[$i][cname]=$subj[$ss_3[$SS][Sa]].":".$subj[$ss_3[$SS][Sb]];
		}
///////////////// ��X��Ǵ��~�Z//////////////////////////
	for($i=0;$i<count($arr_b);$i++){
	if($arr_b[$i][seme_year_seme]===$_GET[year_seme]) {
	$stu_class_id=substr($_GET[year_seme],0,3)."_".substr($_GET[year_seme],3,1)."_".sprintf("%02d",substr($arr_b[$i][seme_class],0,1))."_".sprintf("%02d",substr($arr_b[$i][seme_class],1,2));
	$stu_sn=$arr_b[$i][student_sn];
	}
	}

	}


$now_seme=sprintf("%03d",curr_year()).curr_seme();//�ثe�Ǵ�//�ثe�Ǧ~
// smarty template ���|
$template_dir = $SFS_PATH."/".get_store_path()."/templates";
// �ϥ� smarty tag
$smarty->left_delimiter="{{";
$smarty->right_delimiter="}}";
// ���N�ܼ�
$smarty->assign("arr_a",$arr_a);//�ǤJstud_base���
$smarty->assign("arr_b",$arr_b);//�ǤJstud_seme���
$smarty->assign("now_seme",$now_seme);//�ǤJ�ثe�Ǧ~�Ǵ�
$smarty->assign("arr_sco",$arr_sco);//�ǤJ�ӾǴ����ɦ��Z
if (count($arr_sco)!=0){
	$smarty->assign("SCO_TAB",$Score_Table);//�ǤJ���Z��W��
	$smarty->assign("Seme_class_id",$stu_class_id);//����class_id
	$smarty->assign("stu_sn",$stu_sn);//����student_sn
	}
$smarty->assign("template_dir",$template_dir);
$smarty->assign("PHP_SELF",$_SERVER[PHP_SELF]);
$smarty->display("$template_dir/fix_score.htm");
foot();

##################����ƨ禡###########################
function get_order2($SQL) {
	global $CONN ;
$rs=$CONN->Execute($SQL) or die($SQL);
$arr = $rs->GetArray();
return $arr ;
}
function initArray3($F1,$SQL){
	global $CONN ;
//	global $db;
// ��|����F �O���� $rs ��������m(EOF�GEnd Of File)�ɡA(�Y�G�٦��O���|�����X��)
	$col=split(",",$F1);
	$rs = $CONN->Execute($SQL) or die($SQL);
	$col[0] = array();
	if (!$rs) {
    Return $CONN->ErrorMsg(); 
	} else {
		while (!$rs->EOF) {
		$col[0][$rs->fields[0]][$col[1]]=$rs->fields[1];
		$col[0][$rs->fields[0]][$col[2]]=$rs->fields[2];
	$rs->MoveNext(); // ���ܤU�@���O��
	}
	}
	Return $col[0];
}

##################���o���ظ�T�禡###########################
function initArray($F1,$SQL){
	global $CONN ;
//	global $db;
// ��|����F �O���� $rs ��������m(EOF�GEnd Of File)�ɡA(�Y�G�٦��O���|�����X��)
	$col=split(",",$F1);
	$rs = $CONN->Execute($SQL) or die($SQL);
	$sch_all = array();
	if (!$rs) {
    Return $CONN->ErrorMsg(); 
	} else {
		while (!$rs->EOF) {
		$sch_all[$rs->fields[0]]=$rs->fields[1]; 
	$rs->MoveNext(); // ���ܤU�@���O��
	}
	}
	Return $sch_all;
}

function backinput($st="�d�L�ӾǴ����ɦ��Z����!���U���^!") {
echo"<BR><BR><CENTER><form>
	<input type='button' name='b1' value='$st' onclick=\"history.back()\" style='font-size:16pt;color:red'>
	</form></CENTER>";
	}

?>
