<?php

//$Id: report.php 6731 2012-03-28 01:50:11Z infodaes $
include "config.php";
sfs_check();

//�q�X����
if(!$remove_sfs3head) head("���~�޲z�έp���R");

//��V������
if($_GET['menu']<>'off') echo print_menu($MENU_P,$linkstr);

$selection=$_POST['selection']?$_POST['selection']:'���O�έp';

$status_arr=array();
$status_arr['���O�έp']="SELECT nature as `���O`,count(*) as `�ƶq` FROM equ_equipments WHERE manager_sn=$session_tea_sn GROUP BY nature";
$status_arr['�t�P�έp']="SELECT maker as `�t�P`,count(*) as `�ƶq` FROM equ_equipments WHERE manager_sn=$session_tea_sn GROUP BY maker";
$status_arr['��m�έp']="SELECT position as `��m`,count(*) as `�ƶq` FROM equ_equipments WHERE manager_sn=$session_tea_sn GROUP BY position";
$status_arr['�g�P�Ӳέp']="SELECT saler as `�g�P��`,count(*) as `�ƶq` FROM equ_equipments WHERE manager_sn=$session_tea_sn GROUP BY saler";
$status_arr['�ʶR����έp']="SELECT sign_date as `�ʶR���`,count(*) as `�ƶq` FROM equ_equipments WHERE manager_sn=$session_tea_sn GROUP BY sign_date";
$status_arr['���બ�A�έp']="SELECT healthy as `���બ�A`,count(*) as `�ƶq` FROM equ_equipments WHERE manager_sn=$session_tea_sn GROUP BY healthy";
$status_arr['�~�ɤ�Ʋέp']="SELECT days_limit as `�~�ɤ��`,count(*) as `�ƶq` FROM equ_equipments WHERE manager_sn=$session_tea_sn GROUP BY sign_date";
$status_arr['�O�T�����έp']="SELECT warranty as `�O�T����`,count(*) as `�ƶq` FROM equ_equipments WHERE manager_sn=$session_tea_sn GROUP BY warranty";
$status_arr['���I�����έp']="SELECT importance as `���I����`,count(*) as `�ƶq` FROM equ_equipments WHERE manager_sn=$session_tea_sn GROUP BY importance";
$status_arr['�ϥΦ~���έp']="SELECT usage_years as `�ϥΦ~��`,count(*) as `�ƶq` FROM equ_equipments WHERE manager_sn=$session_tea_sn GROUP BY usage_years";
$status_arr['���o����έp']="SELECT crash_date as `���o����έp`,count(*) as `�ƶq` FROM equ_equipments WHERE manager_sn=$session_tea_sn GROUP BY crash_date";
$status_arr['���o�̾ڲέp']="SELECT crashed_reason as `���o�̾�`,count(*) as `�ƶq` FROM equ_equipments WHERE manager_sn=$session_tea_sn GROUP BY crashed_reason";
$status_arr['�~�ɻP�_�έp']="SELECT opened as `�~�ɻP�_`,count(*) as `�ƶq` FROM equ_equipments WHERE manager_sn=$session_tea_sn GROUP BY opened";
$status_arr['���~�ɥΦ��ƱƦ�']="SELECT a.equ_serial as `���~�s��`,b.item as `���~�W��`,count(a.equ_serial) as `����` FROM equ_record a,equ_equipments b WHERE a.manager_sn=$session_tea_sn AND a.equ_serial=b.serial GROUP BY a.equ_serial,b.item ORDER BY `����` DESC";
$status_arr['���O�ɥΦ��ƱƦ�']=$sql="SELECT b.nature as `���~���O`,count(a.equ_serial) as `����` FROM equ_record a,equ_equipments b WHERE a.manager_sn=$session_tea_sn AND a.equ_serial=b.serial GROUP BY b.nature ORDER BY `����` DESC";
$status_arr['�ɥΪ̱Ʀ�']="SELECT b.name as `�ɥΪ�`,count(a.equ_serial) as `����` FROM equ_record a,teacher_base b WHERE a.manager_sn=$session_tea_sn AND a.teacher_sn=b.teacher_sn GROUP BY b.name ORDER BY `����` DESC";
$status_arr['�ɥΤ���Ʀ�']="SELECT DATE_FORMAT(lend_date,'%Y/%m/%d %W')  as `�ɥΤ��`,count(equ_serial) as `����` FROM equ_record WHERE manager_sn=$session_tea_sn GROUP BY `�ɥΤ��` ORDER BY `����` DESC";
$status_arr['�ɥΤ�O�Ʀ�']="SELECT DATE_FORMAT(lend_date,'%W')  as `�ɥΤ�O`,count(equ_serial) as `����` FROM equ_record WHERE manager_sn=$session_tea_sn GROUP BY `�ɥΤ�O` ORDER BY `����` DESC";
$status_arr['�k�٤���Ʀ�']="SELECT DATE_FORMAT(refund_date,'%Y/%m/%d %W')  as `�k�٤��`,count(equ_serial) as `����` FROM equ_record WHERE manager_sn=$session_tea_sn GROUP BY `�k�٤��` ORDER BY `����` DESC";
$status_arr['�k�٤�O�Ʀ�']="SELECT DATE_FORMAT(refund_date,'%W')  as `�k�٤�O`,count(equ_serial) as `����` FROM equ_record WHERE manager_sn=$session_tea_sn GROUP BY `�k�٤�O` ORDER BY `����` DESC";
$status_arr['��@���~�ɥαƦ�']="SELECT a.equ_serial as `�s��`,b.item as `���~�W��`,count(a.equ_serial) as `����` FROM equ_record a,equ_equipments b WHERE a.manager_sn=$session_tea_sn AND a.equ_serial=b.serial GROUP BY a.equ_serial,b.item ORDER BY `����` DESC";
$status_arr['���~�W�٭ɥαƦ�']="SELECT b.item as `���~�W��`,count(a.equ_serial) as `����` FROM equ_record a,equ_equipments b WHERE a.manager_sn=$session_tea_sn AND a.equ_serial=b.serial GROUP BY b.item ORDER BY `����` DESC";
$status_arr['�ɥΪ̱Ʀ�']="SELECT b.name as `�m�W`,count(a.equ_serial) as `����` FROM equ_record a,teacher_base b WHERE a.manager_sn=$session_tea_sn AND a.teacher_sn=b.teacher_sn GROUP BY b.name ORDER BY `����` DESC";
$status_arr['�Ǵ��ɥΦ��ƦC��']="SELECT year_seme as `�Ǵ�`,count(equ_serial) as `���~��` FROM equ_record WHERE manager_sn=$session_tea_sn GROUP BY year_seme ORDER BY year_seme DESC";
$status_arr['���O�����έp']="SELECT memo as `���O����`,count(equ_serial) as `���~��` FROM equ_record WHERE manager_sn=$session_tea_sn GROUP BY memo ORDER BY memo";
$status_arr['�ɥΤ�Ʋέp']="SELECT TO_DAYS(refund_date)-TO_DAYS(lend_date) as `�ɥΤ��`,count(equ_serial) as `���~��` FROM equ_record WHERE manager_sn=$session_tea_sn AND NOT ISNULL(refund_date) GROUP BY `�ɥΤ��` ORDER BY `�ɥΤ��`";
$status_arr['���k�٪��~���k�٤���έp']="SELECT refund_limit as `���k�٤��`,count(equ_serial) as `���~��` FROM equ_record WHERE manager_sn=$session_tea_sn AND ISNULL(refund_date) GROUP BY `���k�٤��` ORDER BY `���k�٤��`";
$status_arr['�g�ޤH�}��ɥΪ��~�έp']="SELECT b.name as `�m�W`,count(serial) as `���~��` FROM equ_equipments a,teacher_base b WHERE a.opened='Y' AND a.manager_sn=b.teacher_sn GROUP BY `�m�W` ORDER BY `���~��`";
$status_arr['�g�ޤH���~�ɥβέp']="SELECT b.name as `�m�W`,count(equ_serial) as `�ɥΦ���` FROM equ_record a,teacher_base b WHERE a.manager_sn=b.teacher_sn GROUP BY `�m�W` ORDER BY `�ɥΦ���`";

foreach($status_arr as $key=>$value){
	$menu.="<input type='radio' value='$key' name='selection' onclick='this.form.submit()'".($selection==$key?' checked':'').">$key<BR>";
}

$sql=$status_arr[$selection];
$res=$CONN->Execute($sql) or user_error("����έp���R���ѡI<br>$sql",256);
$showdata="<table border='2' cellpadding='8' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1'>";
$showdata.="<tr bgcolor=$Tr_BGColor>";
for($i=0;$i<$res->FieldCount();$i++){
	$r=$res->fetchfield($i);
	$showdata.="<td align='center'>".$r->name."</td>";
}
$showdata.="</tr>";

while(!$res->EOF) {
	$showdata.="<tr align='center'>";
	for($i=0;$i<$res->FieldCount();$i++){
		$showdata.='<td>'.$res->fields[$i].'</td>';
	}
	$showdata.="</tr>";
	$res->MoveNext();
}
$showdata.="</table>";

$main="<table cellpadding='5' cellspacing='5'>
	<form name='myform' method='post' action='$_SERVER[PHP_SELF]'>
	<tr><td valign='top'>$menu</td><td valign='top'>$showdata</td></tr></table></form>";
echo $main;
if(!$remove_sfs3head) foot();

?>