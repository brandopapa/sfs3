<?php
//$Id: tcc.php 7712 2013-10-23 13:31:11Z smallduh $
/*�ޤJ�ǰȨt�γ]�w��*/
require "config.php";

sfs_check();

$stud_study_year=date("Y")-1911;
$class_year_b=($IS_JHORES==0)?1:7;

if ($_POST[out]) {
	$sex_arr=array("1"=>"1","2"=>"0");
	if ($_POST[kind]==1) {
		$sure_study=1;
		$score_str="cc desc,";
		$kind_str="";
		$sex_comp="and stud_sex='".$_POST[sex]."'";
	} else {
		$sure_study=2;
		$score_str="";
		$kind_str="meno,";
		$sex_str=($_POST[sex]==1)?"stud_sex,":"stud_sex desc,";
		$meno_str="and meno='".$_POST[spec_kind]."'";
	}
	//�����X�U������J���Z�ǥ͸��
	for ($i=1;$i<=3;$i++) {
		$query="select temp_id from new_stud where temp_score$i='-100' and stud_study_year='$stud_study_year' and class_year='$class_year_b'";
		$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		$ids="";
		while (!$res->EOF) {
			$ids.="'".$res->fields[temp_id]."',";
			$res->MoveNext();
		}
		if ($ids) $ids=substr($ids,0,-1);
		$temp_score_id[$i]=$ids;
		$query="update new_stud set temp_score$i='0' where temp_score$i='-100' and stud_study_year='$stud_study_year' and class_year='$class_year_b'";
		$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
	}
	$Str="�{�ɽs��,�Z��,�y��,�m      �W,�ʧO,�`��,�s�Z,�s�y��,�s�Z�Ǹ�,�Ƶ�\n";
	$query="select *,(temp_score1+temp_score2+temp_score3) as cc from new_stud where stud_study_year='$stud_study_year' and sure_study='$sure_study' $sex_comp $meno_str order by $kind_str $sex_str $score_str temp_id";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		$Str.=$res->fields[temp_id].",".substr($res->fields[temp_class],1).",".$res->fields[temp_site].",".$res->fields[stud_name].",".$sex_arr[$res->fields[stud_sex]].",".$res->fields[cc].",,,,".$res->fields[meno]."\n";
		$res->MoveNext();
	}
	$filename="�s�Z���-".$sure_study.".csv";
	header("Content-disposition: attachment; filename=$filename");
	header("Content-type: text/x-csv");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");
	echo $Str;
	exit;	
}elseif ($_FILES[upload_file][name]!="") {
	head("�s�ͽs�Z");
	print_menu($menu_p);
	//�ɮפW��
	$file_name=$_FILES['upload_file']['name'];
	$lastname=substr($file_name,(strpos($file_name,".")+1),3);
	$path_str="temp/temp_compile/";
	set_upload_path($path_str);
	$fname=$UPLOAD_PATH.$path_str.$file_name;
	if ($_FILES['upload_file']['size'] >0 && $file_name != "" &&  ($lastname == "CSV" || $lastname == "csv")){
		copy($_FILES['upload_file']['tmp_name'],$fname);
	}
	$fd=fopen($fname,"r");
	$i=0;
	while($tt=sfs_fgetcsv($fd,2000,",")){
		if ($tt[0]!="" && $tt[6]!="" && $tt[7]!="") {
			$query="select * from new_stud where temp_id='".$tt[0]."' and stud_study_year='$stud_study_year' and class_year='$class_year_b'";
			$res=$CONN->Execute($query);
			$stud_name=$res->fields[stud_name];
			if ($res->fields[newstud_sn]!="") {
				$query="update new_stud set class_year='$class_year_b',class_sort='".$tt[6]."',class_site='".$tt[7]."' where newstud_sn='".$res->fields[newstud_sn]."'";
				$CONN->Execute($query);
				echo $tt[0]."--".$stud_name."==>".$tt[6]."�Z".$tt[7]."�� �פJ���\�I<br>";
				$i++;
			}
		}
	}
	fclose($fd);
	unlink($fname);
	echo "�@���\�פJ $i �����";
	foot();
} else {
	head("�s�ͽs�Z");
	print_menu($menu_p);
	if ($_POST[kind]=="") $_POST[kind]="1";
	$kind_chk[$_POST[kind]]="selected";
	if ($_POST[sex]=="") $_POST[sex]="1";
	$sex_chk[$_POST[sex]]="selected";
	if ($_POST[kind]==1) {
		$sex_sel='<option value="1" '.$sex_chk[1].'>�k��<option value="2" '.$sex_chk[2].'>�k��';
	} else {
		$sex_sel='<option value="1" '.$sex_chk[1].'>�k�ͦb�e<option value="2" '.$sex_chk[2].'>�k�ͦb�e';
		$spec_sel='<select name="spec_kind">';
		$query="select distinct meno from new_stud  where stud_study_year='$stud_study_year' and sure_study='2' order by meno";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			$meno=$res->fields[meno];
			if ($meno=="") continue;
			$spec_sel.='<option value="'.$meno.'">'.$meno;
			$res->MoveNext();
		}
		$spec_sel.='</select>';
	}
	echo '	
	<table border=0 width=100% style="font-size:12pt;" cellspacing="1" cellpadding=3  bgcolor=#9EBCDD>
	<form action="'.$_SERVER[PHP_SELF].'" method="post" target="_blank">
	<tr bgcolor="white">
	<td width=50% valign=top nowrap><h3>�ץX'.(date("Y")-1911).'�Ǧ~�ײΤ@�s�Z���</h3>
	<select name="kind" OnChange="this.form.submit();"><option value="1" '.$kind_chk[1].'>�@��Z<option value="2" '.$kind_chk[2].'>�S��Z</select>
	<select name="sex" OnChange="this.form.submit();">'.$sex_sel.'</select> '.$spec_sel.'
	<input type="submit" name="out" value="�ץX���"><br>
	<td width=50% valign=top>
	<ol>
	<li>�n�ϸ�Ư�̤@��͡B�S��ͶץX�A�����b�u<a href="newstud_manage.php">�޲z�s��</a>�v���u<a href="newstud_manage.php?work=2&class_year_b='.($IS_JHORES+1).'">�аO�O�_�NŪ����</a>�v�аO��<font color=red>�u�NŪ�v</font>�M<font color=red>�u�S��Z�v</font>�C</li>
	<li>�n�ϯS��Z����ץX�A�����b�S��Z���O��J�u�귽�Z�v�B�u���u�Z�v�����Z�O��ơC</li>
	<li>�S��Z�ץX�ɪ��ƧǬ�<font color=red>�m�O�B�{�ɽs���C</font></li>
	</ol>
	</tr>
	</form>
	<form action="'.$_SERVER[PHP_SELF].'" enctype="multipart/form-data" method="post">
	<tr bgcolor="white">
	<td width=50% valign=top nowrap><h3>�פJ'.(date("Y")-1911).'�Ǧ~�ײΤ@�s�Z���</h3>
	�W���ɮסG<input type="file" name="upload_file"> <input type="submit" value="�W��">
	<td width=50% valign=top>
	<ol>
	<li>�n�ϥΥ��פJ�\�ॲ���O�H���ҲնץX�s�Z��ƫ�A�ѲΤ@�s�Z�{���o��q�l�ɡA�פJ��Ƥ~���|�o�Ͱ��D�C</li>
	</ol>
	</tr>
	</form>
	</table>';
	foot();
}

?>
