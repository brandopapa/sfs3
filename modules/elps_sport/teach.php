<?php
//$Id: teach.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";
//�{��
//sfs_check();
unset($class_num);
if($_GET[mid]!='' || $_POST[mid]!='' ) {
	($_GET[mid] != '') ? $cmid=$_GET[mid]: $cmid=$_POST[mid];
	if(ch_mid($cmid)!='3') backe("�D�ާ@�ɶ�");
	}

$SQL="select class_num from teacher_post where  teacher_sn='$_SESSION[session_tea_sn]' ";
$rs=$CONN->Execute($SQL) or die($SQL);
$arr=$rs->GetArray();
$class_num=$arr[0][class_num];
if (!$class_num || $_SESSION[session_tea_sn]=='' ) {
	head("�v�����~".$class_num);
	echo "<CENTER><H3>�z�D�ť��Юv</H3></CENTER>";foot();exit;
	}

#####################  �B�z�s�W   #############################
if($_GET[act]=='K5') {
	if($_GET[mid]=='') backe("�ާ@���~!");
	if($_GET[sclass]=='') backe("�ާ@���~!");
	if($_GET[item]=='') backe("�ާ@���~!");
	if($_GET[GP]=='')  backe("�ާ@���~!");
/////�ˬd�{��
	$sql_check="select id from sport_res  where  sportorder!=0 and mid='$_GET[mid]' ";
	$rs = $CONN->Execute($sql_check) or die($sql_check);
	if($rs->RecordCount() > 0 )  backe("�˿��L�{�v�g�}�l�A�лP�j�|�H���s��!");
/////�ˬd���O
	$SQL="select * from sport_item where id ='$_GET[item]'  and  mid='$_GET[mid]' ";
	$arr=get_order2($SQL) or die($SQL);//$Iarr=$arr[0];$arr[$i][kgp]
	if ($arr[0][sportkind]!='5')  backe("�ާ@���~!");
////�ˬd����
	$SQL1="select * from sport_res where itemid ='$_GET[item]' and sportkind='5' and kmaster='2' and idclass='$_GET[sclass]' and kgp='$_GET[GP]' ";
	$rs = $CONN->Execute($SQL1) or die($SQL1);
////�B�z�s�W�����ɳ�
if ($rs->RecordCount()==0) {
	$in_sql="INSERT INTO sport_res(mid,itemid,kmaster,kgp,sportkind,cname,idclass) VALUES ('$_GET[mid]','$_GET[item]','2','$_GET[GP]','5','$_GET[sclass]','$_GET[sclass]') ";
	$rs = $CONN->Execute($in_sql) or die($in_sql);
	}
	header("Location:$PHP_SELF?mid=$_GET[mid]");
}
#####################  ����   #############################
if($_GET[act]=='Del_K5') {
	if($_GET[mid]=='') backe("�ާ@���~!");
	if($_GET[sclass]=='' || strlen($_GET[sclass])!=3 ) backe("�ާ@���~!");
	if($_GET[item]=='') backe("�ާ@���~!");
	if($_GET[GP]=='')  backe("�ާ@���~!");
/////�ˬd�{��
	$sql_check="select id from sport_res  where  sportorder!=0 and mid='$_GET[mid]' ";
	$rs = $CONN->Execute($sql_check) or die($sql_check);
	if($rs->RecordCount() > 0 )  backe("�˿��L�{�v�g�}�l�A�лP�j�|�H���s��!");
/////�ˬd���O
	$SQL="select * from sport_item where id ='$_GET[item]'  and  mid='$_GET[mid]' ";
	$arr=get_order2($SQL) or die($SQL);//$Iarr=$arr[0];$arr[$i][kgp]
	if ($arr[0][sportkind]!='5')  backe("�ާ@���~!");
/////�B�z����
	$del_sql="delete from  sport_res where itemid ='$_GET[item]' and sportkind='5' and idclass like '$_GET[sclass]%' and kgp='$_GET[GP]' ";
	$rs = $CONN->Execute($del_sql) or die($del_sql);
	header("Location:$PHP_SELF?mid=$_GET[mid]");
}

#####################  �B�z�s�W   #############################
if($_POST[act]=='add_stu' ) {
	if($_POST[main_id]=='') backe("�ާ@���~!");
	if($_POST[stu]=='') backe("����ܾǥ�!���U��^�W������!");
	if($_POST[item]=='') backe("����ܶ���!���U��^�W������!");
	$mid=$_POST[main_id];
	$item=split("_",$_POST[item]);//����,���O
/////�ˬd�{��
	$sql_check="select id from sport_res  where  sportorder!=0 and mid='$mid' ";
	$rs = $CONN->Execute($sql_check) or die($sql_check);
	if($rs->RecordCount() > 0 )  backe("�˿��L�{�v�g�}�l�A�лP�j�|�H���s��!");
/////�B�z�O�_����
if ($item[0]==all) {
	$sql_check="select id from sport_res  where  mid='$mid' and  kmaster=1 and idclass like '$class_num%' ";
	$rs = $CONN->Execute($sql_check) or die($sql_check);
	if($rs->RecordCount() > 0 )  backe("�����ȯ঳�@�H�I�������ª��~��W�[�s���I");
	if (count($_POST[stu]) > 1 )   backe("�����ȯ঳�@�H�I�z�h�D�F�I");
	list($stud,$cname)=each($_POST[stu]);
	$stud=split("_",$stud);
	$in_sql="INSERT INTO sport_res(mid,kmaster,stud_id,cname,idclass,memo) VALUES ('$mid','1','$stud[0]' ,'$cname','$stud[1]','����')";
	$rs = $CONN->Execute($in_sql) or die($in_sql);
	header("Location:$PHP_SELF?mid=$mid");
	}
////// �B�z���O��
if ($item[1]=='5') {
	foreach ($_POST[stu] as $key => $cname ) {
	$key=split("_",$key);////stu[[�ǥͽs��sn_�ثe�~�Z�y��]
	$sql_2="select id,mid,itemid,idclass from sport_res where stud_id='$key[0]' and itemid='$item[0]' ";
	//���Ƴ��W�ˬd
	$rs = $CONN->Execute($sql_2) or die($sql_2);
if($rs->RecordCount()==0 ) {
	$in_sql="INSERT INTO sport_res (mid,itemid,kgp,stud_id,sportkind,cname,idclass) VALUES ('$mid','$item[0]','$item[2]','$key[0]' ,'$item[1]','$cname','$key[1]')";
	$up_sql="update sport_item set  res=res+1  where id='$item[0]' ";
//	echo $in_sql.$up_sql."<BR>";
	$rs = $CONN->Execute($in_sql) or die($in_sql);
	$rs = $CONN->Execute($up_sql) or die($up_sql);
			}
		else {walert(" $cname ���Ƴ��W,�ާ@���L�I");}
		}
	header("Location:$PHP_SELF?mid=$mid");
	}
/////�B�z�@�붵��
foreach ($_POST[stu] as $key => $cname ) {
	$key=split("_",$key);////stu[[�ǥͽs��sn_�ثe�~�Z�y��]
	$sql_2="select id,mid,itemid,idclass from sport_res where stud_id='$key[0]' and mid='$mid' and itemid='$item[0]' ";
	//���Ƴ��W�ˬd
	$rs = $CONN->Execute($sql_2) or die($sql_2);
if($rs->RecordCount()==0 ) {
	$in_sql="INSERT INTO sport_res (  mid , itemid , stud_id , sportkind , cname , idclass ) VALUES ('$mid','$item[0]','$key[0]' ,'$item[1]','$cname','$key[1]')";
	$up_sql="update sport_item set  res=res+1  where id='$item[0]' ";
//	echo $in_sql.$up_sql."<BR>";
	$rs = $CONN->Execute($in_sql) or die($in_sql);
	$rs = $CONN->Execute($up_sql) or die($up_sql);
			}
	else {walert(" $cname ���Ƴ��W,�ާ@���L�I");}
	} //end if
	header("Location:$PHP_SELF?mid=$mid");
}
#####################  �B�z����   #############################
//del_id[�O����y����_���ؽs��]
if($_POST[act]=='stu_del' ) {
	if($_POST[main_id]=='') backe("�ާ@���~!");
	if(count($_POST[del_id])==0) backe("����ܾǥ�!���U��^�W������!");
		$mid=$_POST[main_id];
/////�ˬd�{��
	$sql_check="select id from sport_res  where  sportorder!=0 and mid='$mid' ";
	$rs = $CONN->Execute($sql_check) or die($sql_check);
	if($rs->RecordCount() > 0 )  backe("�˿��L�{�v�g�}�l�A�лP�j�|�H���s��!");
/////�B�z�R��
	foreach ($_POST[del_id] as $key => $cname) {
		$key=split("_",$key);
		$del_sql="delete from  sport_res where id='$key[0]' ";
		$rs = $CONN->Execute($del_sql) or die($del_sql);
	if ($key[1]!="all"){
		$up_sql="update sport_item set  res=res-1  where id='$key[1]'";
		$rs = $CONN->Execute($up_sql) or die($up_sql);}
		}
	header("Location:$PHP_SELF?mid=$mid");
}

#####################  �D�e���}�l   #############################
head("�v�ɳ��W");

//print_menu($memu_p,$link2);
include_once "menu.php";
include_once "chk.js";

//$tool_bar=&make_menu($school_menu_p);
//	echo $tool_bar;//	print_r($_SESSION);
if($_GET[mid]=='') { print_menu($school_menu_p1);}
else {$link2="mid=$_GET[mid]"; print_menu($school_menu_p1,$link2);}


mmid_t($_GET[mid]);


echo "<FORM METHOD=POST ACTION='$PHP_SELF' name='f1'>\n<INPUT TYPE='hidden' name='main_id' value='$_GET[mid]'><INPUT TYPE='hidden' name='act' value=''>";
if ($_GET[mid]!='' && $class_num!='') item_list($_GET[mid],$class_num);
//if ( && $_GET[mid]!='') stud_list($class_num);
//$color_sex[$arr[$i][stud_sex]]

echo "</FORM>";


//�D�n���e
$main="";
echo $main;

//�G������
foot();
#####################  �C�ܶ���   #############################
function item_list($mid,$class_num){
		global $CONN,$sportclass,$sportname,$itemkind;
		$class_num_1=substr($class_num,0,1);
	$SQL="select a.* ,count(b.id) as bu  from sport_item a  LEFT JOIN  sport_res b on b.mid='$mid' and b.itemid=a.id and b.idclass like '$class_num%' where  a.mid='$mid' and a.enterclass like '$class_num_1%' and a.skind=0 and a.sportkind!=5 group by a.id  order by  a.kind, a.enterclass ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();//�����ػP���W��
	$SQLb="select *  from  sport_res where  mid='$mid' and  idclass like '$class_num%' ";
	$rs1=$CONN->Execute($SQLb) or die($SQLb);
	$arr1=$rs1->GetArray();//�����Z���W���
	$Master=get_Master($mid,$class_num);//���o����
(is_array($Master)) ? $ma_str="<INPUT TYPE='checkbox' NAME='del_id[".$Master[id]."_all]' value='".$Master[cname]."' >".$Master[cname]."\n" :$ma_str='';
echo "<table border=0  width=100% style='font-size:10pt;'  cellspacing=1 cellpadding=0 bgcolor=silver>

<tr bgcolor=white><TD style='font-size:10pt;' width=50% valign=top>
<img src='images/12.gif'><B>�i�ѥ[���ػP�v���W�ǥͦC��</B><BR>
<INPUT TYPE='reset' value='���s���' class=bu1>&nbsp;
<INPUT TYPE='button' value='�����v���W���ǥ�' onclick=\"bb('�T�w����','stu_del');\" class=bu1><BR>";
echo "<INPUT TYPE='radio' NAME='item' value='all'>�����G<div style='color:#800000;margin-left:30pt;'>$ma_str</div>";
for($i=0; $i<$rs->RecordCount(); $i++) {
	$tmp_str='';$tmp_str2='';$NN=0;
	$tmp_str= "<INPUT TYPE='radio' NAME='item' value='".$arr[$i][id]."_".$arr[$i][sportkind]."'>".$sportclass[$arr[$i][enterclass]].$sportname[$arr[$i][item]].$itemkind[$arr[$i][kind]]."(<B style='color:blue' >".$arr[$i][bu]."</B>):";
	for($y=0; $y<$rs1->RecordCount(); $y++) {	
		if($arr1[$y][itemid]==$arr[$i][id])  {
			$tmp_str2.= "<INPUT TYPE='checkbox' NAME='del_id[".$arr1[$y][id]."_".$arr[$i][id]."]' value='".$arr1[$y][cname]."' >".substr($arr1[$y][idclass],3,2).$arr1[$y][cname]."&nbsp;\n";//del_id[�O����y����_���ؽs��]
	if ($NN%5==4 && $NN!=0)  $tmp_str2.= "<BR>";
		$NN++;}
	}
	echo $tmp_str."<div style='color:#800000;margin-left:30pt;'>".$tmp_str2."</div>\n";
//	if ($i%5==4 && $i!=0) echo "<BR>";
}
##########���O���B�z#######
include_once'mgr_stu5.php';
echo "</TD><TD width=50% style='font-size:10pt;' valign=top>";
##########���Z�C�X#######
stud_list($class_num);
echo "</TD></TR></TABLE><hr color=#800000 SIZE=1>";
}
#####################  �C�ܾǥ�   #############################
function stud_list($class_num) {
		global $CONN;
$SQL="select stud_id,student_sn,stud_name,stud_sex,stud_birthday,stud_blood_type,curr_class_num,stud_study_cond from stud_base where curr_class_num like '$class_num%' and stud_study_cond=0 order by curr_class_num";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();
//$color_col=array("#f9f9f9","#F2F2F2");//�C��#e8efe2
//(($i%2)==0) ? $v_color=$color_col[0]:$v_color=$color_col[1];
// stud_sex
$color_sex=array(1=>"blue",2=>"green");//�C��#e8efe2
$img_sex=array(1=>"<img src='images/boy.gif' width=15 >",2=>"<img src='images/girl.gif' width=15>");//�C��#e8efe2

?><TABLE border=0 width=100%><TR><TD width=100%><img src='images/12.gif'><B>���Z�ǥͦC��</B><BR>
<INPUT TYPE='reset' value='���s���' class=bu1>&nbsp;
<INPUT TYPE=button  value="�N�_��̥[�J�I�諸����" onclick=" bb('��n�F�ܡH','add_stu');" class=bu1></TD></TR><TR>
<TD style='font-size:11pt;' >
<FONT COLOR='red'>���G�������@�H</FONT><BR>
<?
for($i=0; $i<$rs->RecordCount(); $i++) {
$stu_num=substr($arr[$i][curr_class_num],3,2);
echo "<INPUT TYPE='checkbox' NAME='stu[".$arr[$i][student_sn]."_".$arr[$i][curr_class_num]."]' value='".$arr[$i][stud_name]."'><FONT  COLOR='".$color_sex[$arr[$i][stud_sex]]."'>".$img_sex[$arr[$i][stud_sex]].$stu_num.$arr[$i][stud_name]."</FONT>\n";
//stu[[�ǥͽs��sn_�ثe�~�Z�y��]
if ($i%4==3 && $i!=0) echo "<BR>";
}

echo "</TD></TR></TABLE>";

}

?>
