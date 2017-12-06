<?php

//$Id: chc_seme.php 5310 2009-01-10 07:57:56Z hami $

//ini_set('display_errors', '1');
//ini_set('output_buffering', '1');

include "config.php";
include "chc_func_class.php";
include_once "../../include/sfs_case_excel.php";
//�ޤJ��������(�ǰȨt�ΥΪk)
include_once "../../include/sfs_oo_dropmenu.php";

//�{��
sfs_check();

//��ܤ��e
if(isset($_POST) and count($_POST)>0){
	if($_POST[leader_excel]=='�ץXEXCEL'){
		$aa=get_stu($_POST["class_id"]);
		output_excel($aa, $_POST['class_id'], 'excel');
	}
}

//�q�X�����������Y
head("�ץX���");
print_menu($menu_p);

$ob=new drop($CONN);
$select=$ob->select();
//���SFS�s�����(���ϥνЮ��}����)

echo make_menu($school_menu_p);

display($select);



function output_excel($stu, $class_id, $output_type) {
	global $SFS_PATH; 

	ob_clean();
	if($output_type=='excel'){
		$data1=array();

		$iii=0;
		foreach($stu as $stu_sn=>$val){
			$seme_class=$val['seme_class'];
			$data1[$iii][]=$val['seme_num'];
			$data1[$iii][]=$val['stud_name'];
			$data1[$iii][]=$val['title'][0];
			$data1[$iii][]=$val['title'][1];
			$data1[$iii][]='';//�ثe�L�u�p�Ѯv1�v���
			$data1[$iii][]='';//�ثe�L�u�p�Ѯv2�v���
			$data1[$iii][]=$val['memo'];
			$iii++;
		}
		$filename ="leader_".$class_id.".xls";
		$myhead1=array('�y��','�m�W','�F��1','�F��2','�p�Ѯv1','�p�Ѯv2','�Ƶ�');

		$x=new sfs_xls();
		$x->setUTF8();//$x->setVersion(8);
		$x->setBorderStyle(1);
		$x->filename=$filename;
		$x->setRowText($myhead1);
		$x->addSheet($seme_class);
		$x->items=$data1;
		$x->writeSheet();
		$x->process();
	}
	exit;


}



function init() {
	$YS=''; 
	if (isset($_POST['year_seme'])) $YS=$_POST['year_seme'];
	if ($YS=='' && isset($_GET['year_seme'])) $YS=$_GET['year_seme'];
	if ($YS=='') $YS=curr_year()."_".curr_seme();
	$year_seme=$YS;
	$aa=split("_",$this->year_seme);
	$year=$aa[0];
	$seme=$aa[1];
}

/* ���ǥͰ}�C,����stud_base��Pstud_seme��*/
function get_stu($class_id){
	global $CONN;

	$CID=split("_",$class_id);//093_1_01_01
	$year=$CID[0];
	$seme=$CID[1];
	$grade=$CID[2];//�~��
	$class=$CID[3];//�Z��
	$CID_1=$year.$seme;
	$CID_2=sprintf("%03d",$grade.$class);
	$SQL="select a.stud_id,a.student_sn,a.stud_name,a.stud_sex,b.seme_year_seme,b.seme_class,b.seme_num,a.stud_study_cond  from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$CID_1' and b.seme_class='$CID_2' $add_sql order by b.seme_num ";
	$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	$obj_stu=array();
	while ($rs and $ro=$rs->FetchNextObject(false)) {
		$obj_stu[$ro->student_sn] = get_object_vars($ro);
	}

	$SQL="select id,student_sn,seme,kind,org_name,title,memo from chc_leader 
	where kind='0'  and seme='$CID_1' and org_name ='$CID_2'  ";
	$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	$All=$rs->GetArray();
	foreach ($All as $ary){
		$Sn=$ary['student_sn'];
		$obj_stu[$Sn]['title'][]=$ary['title'];
		if($ary['memo']!=''){
			$obj_stu[$Sn]['memo'][].=' '.$ary['memo'];
		}
	}
	return $obj_stu;
}


//���
function display($select){

	echo '<table  width="100%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#9EBCDD" style="table-layout: fixed;word-wrap:break-word;font-size:10pt">
<tr style="font-size:11pt" bgcolor="#9EBCDD"><td>
�����G<br>
1.�t�X�u12�~��Ф��M�K�դJ�ǡv�@�~�A���{���ץX�u�Z�ŷF���v����ɡC<br>
2.�ж}�ҶץX���ɮסA�ýƻs���e�A�K�W��<a href="/test_sfs3/modules/career_leader/leader_paste.php" target="_blank">�i�ͲP���ɯZ�ŷF���޲z�j</a>�C<br>
<br>
</td></tr></table>';
echo '<table  width="100%"  border="1" align="center" cellpadding="1" cellspacing="1" style="table-layout: fixed;word-wrap:break-word;font-size:10pt">
<tr style="font-size:11pt">

<td></td></tr>';
	echo '<tr style="font-size:11pt">

<td>';
	echo '<form name="form1" method="post" action="">'.$select.'
 <br> �u�Z�ŷF���v����ɡ@
<input type="submit" name="leader_excel" value="�ץXEXCEL">
</form>';
	echo '</td></tr>';
	echo '</table>';

}
