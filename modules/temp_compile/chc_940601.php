<?php
//$Id: chc_940601.php 7712 2013-10-23 13:31:11Z smallduh $
/*�ޤJ�ǰȨt�γ]�w��*/
require "config.php";
//require "../../include/sfs_core_schooldata.php";
//�q�X�����������Y

sfs_check();
////------��X�s�Z���߭n���ɮ�--------////
if ($_POST && $_POST[class_num]!=''){
	if (strlen($_POST[class_num]) > 3 )  backe("�Ҷ�Z�żƹL�h�I�Эק��A�e�X�I");
	if ($_POST[teacher]!='') {
	$teacher=ereg_replace("\n", "", $_POST[teacher]);
	$teacher=ereg_replace("\r", "",$teacher);
	$teacher=explode(',',$teacher);
	if (count($teacher)!=$_POST[class_num]) backe("�Ҷ�Юv��".count($teacher)."�H�P�Z�żƤ��šI�Эק��A�e�X�I");
	foreach($teacher as $name ){
		if (strlen($name)< 4 )  backe("�����Юv�m�W�ůʡI");
		}
	get_stu_out($_POST[class_num],$teacher);
	}
	else{
		get_stu_out($_POST[class_num]);
	}
	
	exit;
}


////------��J�s�Z���߲��ͪ��ɮ�,�A����s�B�z--------////

if ($_POST[uptype]=='sum_grade' and $_FILES[upfile][error]==0) {
	$chk=explode("_",$_FILES[upfile][name]);// => 95_000000_20060709_OK.csv
	$school_info=get_school_base();
	$sch_id=$school_info[sch_id];//�Ǯսs��
	$now_year=$chk[0];//�Ǧ~��
	if($chk[1]!=$sch_id) backe2("�D���սs��".$sch_id."�ɮסA�ڵ���J�I");
	if( $chk[3]!='OK.csv') backe2("�D�s�Z���߳B�z�L���ɮסA�ڵ���J�I");

	$LineArray = file($_FILES[upfile][tmp_name]);
//	if( !ereg('"',$LineArray[0])) echo "�Hexplode�Ҧ�";

//�t���޸����B�z�Ҧ�
	if( ereg('"',$LineArray[0])) {
		unset($LineArray);
		$arys=array('�y����','�Z��','�y��','�������r��');
		$handle=fopen($_FILES[upfile][tmp_name], "r");
		$csv_head = sfs_fgetcsv($handle, 1000, ","); //-- ��1�C����ƥ��
		$csv_head = sfs_fgetcsv($handle, 1000, ","); //-- ��2�C�ɮv
		$csv_head = sfs_fgetcsv($handle, 1000, ","); //-- ��3�C�����D
		foreach ($arys as $fld) {
			$pos = array_search($fld, $csv_head);
			if ($pos !== false) $csv_get[$fld]=$pos;
			}
			$count_update=0;
		while (($data = sfs_fgetcsv($handle, 1000, ",")) !== FALSE) {
			$stud = array();
			$temp_id=$stud[temp_id]=trim($data[$csv_get[�y����]]);
			$class_year=$stud[class_year]=$IS_JHORES+1;
			$class_sort=$stud[class_sort]=trim($data[$csv_get[�Z��]]);
			$class_site=$stud[class_site]=trim($data[$csv_get[�y��]]);
			$person_id=$stud[person_id]=trim($data[$csv_get[�������r��]]);
			//-- ��Ƨ���~�s�J��ƪ� new_stud
			if (!empty($temp_id) and !empty($class_sort) and !empty($class_site) and !empty($person_id)) {
				$SQL = " update new_stud set class_year='{$class_year}',class_sort='{$class_sort}', class_site='{$class_site}' where temp_id='{$temp_id}' and stud_study_year='{$now_year}' and  stud_person_id='{$person_id}'";
				$rs = $CONN->Execute($SQL) or die($SQL);
				$count_update++;
			}
		}
		fclose($handle);
	} else {

	//���t���޸����B�z�Ҧ�
		$Stu = array_slice($LineArray,3);
		$class_year=$IS_JHORES+1;//�M�w�~��
		$count_update=0;
		foreach ($Stu as $line ){
			if( !ereg(',',$line)) continue;//�h���ťզ�
			$stu_tmp = explode(",",$line);
			$temp_id=trim($stu_tmp[0]);//�{�ɽs��
			$class_sort=$stu_tmp[1];//�Z��
			$class_site=$stu_tmp[2];//�y��
			$person_id=trim($stu_tmp[5]);
			if (!empty($temp_id) and !empty($class_sort) and !empty($class_site) and !empty($person_id)) {
				$SQL = "update new_stud set class_year='{$class_year}',class_sort='{$class_sort}', class_site='{$class_site}' where temp_id='{$temp_id}' and stud_study_year='{$now_year}' and  stud_person_id='{$person_id}'";
				$rs = $CONN->Execute($SQL) or die($SQL);
				$count_update++;
				}
		}
	}
	echo "<HTML><HEAD><META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=big5\"></HEAD><BODY>\n";
	echo"<BR><BR><BR><BR><CENTER><form>";
	echo "<input type='button' name='b1' value='�@��s�F $count_update �����\n ���U���~��' onclick=\"location.href='".$_SERVER[PHP_SELF]."'\" style='font-size:16pt;color:red'></form></CENTER>";
	die();
}


head("�s�ͽs�Z");
print_menu($menu_p);
##################�}�C�C�ܨ禡2##########################
// 1.smarty����
//$template_dir = $SFS_PATH."/".get_store_path()."/templates/";
$smarty->left_delimiter="{{";
$smarty->right_delimiter="}}";
$template_file= $SFS_PATH."/".get_store_path()."/chc_940601.htm";
$smarty->assign("PHP_SELF",$_SERVER[PHP_SELF]);
$smarty->display($template_file);
foot();


##################  ��XCSV�禡  ##########################

function get_stu_out($class_num,$teach_ary='',$yy=''){
	global $CONN ;
	if ($yy=='') $yy=curr_year()+1;
	$school_info=get_school_base();
	$sch_id=$school_info[sch_id];
	$SQL="select * from  new_stud where  stud_study_year='$yy' 
	and  sure_study='1' and  temp_id !='' order by  temp_id ";
	$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	if ($rs->RecordCount()==0)  die("�d�L����s�͸��:".$SQL);
	$All=$rs->GetArray();
	$nn=array("�y����","�Z��","�y��","�ʧO","�m�W","�������r��","��NŪ�Ǯ�","�s�Z���O","�����y����","�Ƶ�");
	$Str="�զW,".$school_info[sch_cname_s].",�Z�ż�,".$class_num.",�`�H��,".$rs->RecordCount()."\n";
	if ($teach_ary==''){
		$Str.="\n";
		}else{
		$Str.=join(',',$teach_ary)."\n";
	}


	$Str.="�y����,�Z��,�y��,�ʧO,�m�W,�������r��,��NŪ�Ǯ�,�s�Z���O,�����y����,�Ƶ�\n";
	for ($i=0;$i<$rs->RecordCount();$i++){
	if ($All[$i][stud_kind]=='') $All[$i][stud_kind]='0';
		$Str.=$All[$i][temp_id].',,,'.
			$All[$i][stud_sex].','.
			$All[$i][stud_name].','.
			$All[$i][stud_person_id].','.
			$All[$i][old_school].','.
			$All[$i][stud_kind].','.
			$All[$i][bao_id].",\n";
	}

	$filename = $yy."_".$sch_id."_".date("Ymd").".csv";

header("Content-disposition: attachment; filename=$filename");
header("Content-type: text/x-csv");
//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
header("Expires: 0");
echo $Str;
}

##################�^�W���禡1#####################

function backe($st="����!���U��^�W������!") {
echo"<BR><BR><BR><BR><CENTER><form>
	<input type='button' name='b1' value='$st' onclick=\"window.close()\" style='font-size:18pt;color:red'>
	</form></CENTER>";
	exit;
	}
function backe2($st="����!���U��^�W������!") {
	echo "<HTML><HEAD><META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=big5\">
<TITLE>$st</TITLE></HEAD><BODY background='images/bg.jpg'>\n";
echo"<BR><BR><BR><BR><CENTER><form>
	<input type='button' name='b1' value='$st' onclick=\"history.back()\" style='font-size:16pt;color:red'>
	</form></CENTER>";
	exit;
	}

?>
