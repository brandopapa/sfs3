<?php
header('Content-type: text/html;charset=big5');
// $Id: index.php 7731 2013-10-29 05:45:26Z smallduh $

/* ���o�]�w�� */
include_once "config.php";

sfs_check();

$seme_year_seme=sprintf("%03d%d",curr_year(),curr_seme());

//�ǤJ�ܼ� $_POST['items'] , $_POST['org_selected'] �H ; �j�}���r��

$data="";

$pre_selected=$_POST['pre_selected']; //�w�w��W��
$chk_student=explode(';',$_POST['items']);

foreach($chk_student as $v) {
 if (strpos(" ".$_POST['pre_selected'],$v)>=1) continue;
 $pre_selected.=';'.$v; //�S�����_�A�[�W���ǥ�
}

$show=explode(';',$pre_selected);

$data="<table border=0 style='font-size:10pt'>";
$i=0;
foreach ($show as $k=>$v) {
 if ($v!="") {
  $i++;
  if ($i%10==1) $data.="<tr>";
	$query="select a.seme_class,a.seme_num,b.stud_name from stud_seme a,stud_base b where a.seme_year_seme='$seme_year_seme' and a.student_sn=b.student_sn and a.student_sn='$v'";
	$res=$CONN->Execute($query) or die("SQL���~:".$query);
	$row=$res->FetchRow();
	$num=sprintf('%02d',$row['seme_num']);
  $data.="<td><input type='checkbox' name='selected_students[]' value='".$v."' checked>".$row['seme_class'].$num.$row['stud_name']."</td>";
  if ($i%10==0) $data.="</tr>";
 }
}

$data.="</table><input type='hidden' name='pre_selected' value='".$pre_selected."' id='pre_selected'>";
  echo $data;

?>