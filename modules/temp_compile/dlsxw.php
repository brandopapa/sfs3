<?php

// $Id: dlsxw.php 7712 2013-10-23 13:31:11Z smallduh $

/*�ޤJ�ǰȨt�γ]�w��*/
include "../../include/config.php";
include "../../include/sfs_oo_zip2.php";
if($_GET['stud_study_year']) $stud_study_year=$_GET['stud_study_year'];
else $stud_study_year=$_POST['stud_study_year'];
if($_GET['class_year']) $class_year=$_GET['class_year'];
else $class_year=$_POST['class_year'];
if($_GET['class_sort']) $class_sort=$_GET['class_sort'];
else $class_sort=$_POST['class_sort'];

//�ϥΪ̻{��
sfs_check();

echo ooo();


function ooo(){
	global $CONN,$stud_study_year,$class_year,$class_sort;

	$oo_path = "ooo_newstud";

	$filename="newstud".$stud_study_year.$class_year.$class_sort.".sxw";

    //�s�W�@�� zipfile ���
	$ttt = new EasyZip;
	$ttt->setPath($oo_path);

	//Ū�X xml �ɮ�
	$data = $ttt->addDir("META-INF");

	//�[�J xml �ɮר� zip ���A�@�������ɮ�
	//�Ĥ@�ӰѼƬ���l�r��A�ĤG�ӰѼƬ� zip �ɮת��ؿ��M�W��

	$ttt->addFile("settings.xml");
	$ttt->addFile("styles.xml");
	$ttt->addFile("meta.xml");

	//Ū�X content.xml
	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/content.xml");

	//�N content.xml �� tag ���N

    $sql="select * from new_stud where stud_study_year='$stud_study_year' and  class_year='$class_year' and class_sort='$class_sort' order by class_site";
    $rs=$CONN->Execute($sql) or die($sql);
    $i=0;
    while(!$rs->EOF){
		$stud_id[$i]= $rs->fields['stud_id'];
		$stud_name[$i]= $rs->fields['stud_name'];		
		$class_site[$i]= $rs->fields['class_site'];
		$stud_sex[$i]= $rs->fields['stud_sex'];	
		$stud_sex_name[$i]=($stud_sex[$i]=="1")?"�k":"�k";		
		$stud_address[$i]= $rs->fields['stud_address'];	
		$stud_tel_1[$i]= $rs->fields['stud_tel_1'];
        $i++;
        $rs->MoveNext();
    }
	
	$title=$stud_study_year."�Ǧ~��".$class_year."�~".$class_sort."�Z�s�ͦW�U";
	
	$head="
		<table:table-header-rows>
		<table:table-row>
		<table:table-cell table:style-name='course_tbl.A1' table:value-type='string'>
		<text:p text:style-name='P2'>
		�m�W</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.B1' table:value-type='string'>
		<text:p text:style-name='Table Heading'>
		<text:span text:style-name='T2'>
		�Ǹ�</text:span>
		</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.B1' table:value-type='string'>
		<text:p text:style-name='P2'>
		�y��</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.B1' table:value-type='string'>
		<text:p text:style-name='P2'>
		�ʧO</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.B1' table:value-type='string'>
		<text:p text:style-name='P2'>
		��}</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.F1' table:value-type='string'>
		<text:p text:style-name='P2'>
		�q��</text:p>
		</table:table-cell>
		</table:table-row>
		</table:table-header-rows>		
	";

    for($i=0;$i<count($stud_id);$i++){
        $cont.="
		<table:table-row>
		<table:table-cell table:style-name='course_tbl.A2' table:value-type='string'>
		<text:p text:style-name='P3'>
		$stud_name[$i]</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
		<text:p text:style-name='P3'>
		$stud_id[$i]</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
		<text:p text:style-name='P3'>
		$class_site[$i]</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
		<text:p text:style-name='P3'>
		$stud_sex_name[$i]</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
		<text:p text:style-name='P3'>
		$stud_address[$i]</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.F2' table:value-type='string'>
		<text:p text:style-name='P3'>
		$stud_tel_1[$i]</text:p>
		</table:table-cell>
		</table:table-row>";
    }
	
	$temp_arr["title"]=$title;
    $temp_arr["head"] = $head;
	$temp_arr["cont"] = $cont;
	// change_temp �|�N�}�C���� big5 �ର UTF-8 �� openoffice �i�HŪ�X
	$replace_data = $ttt->change_temp($temp_arr,$data,0);

	// �[�J content.xml ��zip ��
	$ttt->add_file($replace_data,"content.xml");

	//���� zip ��
	$sss = $ttt->file();

	//�H��y�覡�e�X ooo.sxw
	header("Content-disposition: attachment; filename=$filename");
	header("Content-type: application/vnd.sun.xml.writer");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");

	echo $sss;

	exit;
	return;
}
?>
