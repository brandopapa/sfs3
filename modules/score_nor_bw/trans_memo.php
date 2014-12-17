<?php

// $Id: trans_memo.php 6218 2010-10-14 03:34:47Z brucelyc $

// ���J�]�w��
include "config.php";

// �{���ˬd
sfs_check();

//����T
$sel_file=($_POST['sel_file'])?$_POST['sel_file']:$_GET['sel_file'];
$trans_key=$_POST['trans_key'];
$trans_seme=$_POST['seme'];
$seme_data=$_POST['seme_data'];
$ys=$_POST['year_seme'];
if ($ys=='all') {
	while (list($k,$v)=each($trans_seme)) {
		$tseme[$k]=$v;
		$rseme[$v]=$k;
	}
} else {
	$yss=explode("_",$ys);
	$yys=$yss[0].$yss[1];
	$tseme[$yys]=$trans_seme[$yys];
	$rseme[$trans_seme[$yys]]=sprintf("%04d",$yys);
}

//�ɮפW��
$file_name=strtoupper($_FILES['upload_file']['name']);
if ($_FILES['upload_file']['size'] >0 && $file_name != "" && strstr($file_name,"XGUGN") && substr($file_name,(strpos($file_name,".")+1),3) == "CSV"){
	copy($_FILES['upload_file']['tmp_name'],$temp_path.$file_name);
}

if ($trans_key){
	$main=trans_memo();
} else {
	$main=view_trans_memo();
}

//�q�X����
head("�פJ�ɮv���y");
echo $main;
foot();

function view_trans_memo(){
	global $menu_p,$temp_path,$sel_file,$CONN,$IS_JHORES;
	$toolbar=make_menu($menu_p);
	
	//����
	$help_text="
	�p�G�ɮץ��W�ǡA�Х���ܤ@���ɮפW�ǡC||
	�p�G�ɮפw�W�ǡA�h��ܭn�פJ���ɮסC||
	�n�B�z���ɮסG�u\student\person\p9x\xgugn9x.dbf�v�C||
	�Х��N���ɥHExcel���}�A�M��s��CSV�榡��A��ܤW�ǡC||
	�]�N�O�W�ǫe���N�ɮצs���uXGUGN9x.CSV�v�C||
	�ɮ׻����Gxgugn91.dbf��91�Ǧ~�פJ�Ǿǥͪ��U�Ǵ���ơA�̦������C
	";
	$help=help($help_text);

	//�ɮ׿��
	$temp4="<select name='sel_file' onChange='jumpMenu()'>
	<option value=''>�п���ɮ�";
	$fp = opendir($temp_path);
	while ( gettype($file=readdir($fp)) != boolean ){
		$temp5=($sel_file==$file)?"selected":"";
		if (is_file("$temp_path/$file") && (substr($file,0,5)=="XGUGN" || substr($file,0,5)=="Xgugn") && (substr($file,-3,3)=="csv" || substr($file,-3,3)=="CSV")){
			$temp4.="<option value='$file' $temp5>$file";
		}
	}
	closedir($fp);
	$temp4.="</select>";

	$main="
	$toolbar
	<table cellspacing='1' cellpadding='3' class='main_body'>
	<tr bgcolor='#FFFFFF'>
	<form name='form0' enctype='multipart/form-data' action='{$_SERVER['SCRIPT_NAME']}' method='post'>
	<td class='title_sbody1' nowrap>�W���ɮסG<td><input type=file name='upload_file'></td>
	<td class='title_sbody1' nowrap><input type=submit name='doup_key' value='�W��'></td>
	</form>
	</tr>
	<tr bgcolor='#FFFFFF'>
	<form name='form1' action='{$_SERVER['SCRIPT_NAME']}' method='post'>
	<td class='title_sbody1' nowrap>���A�����s�ɮסG<td colspan=2>$temp4</td>
	</form>
	</tr>";

	if ($sel_file){
		//����
		$help_text="
		�H�W���ɮפ��U�Ǵ��Ĥ@���ǥ͸�ơA�Х��ֹ�O�_���T�C||
		�Y�ǥͩm�W���X�{�A�Х��פJ�ǥ͸�ơC
		";
		$help=help($help_text);

		//�p��Ǧ~�Ǵ�
		$sel_year=substr($sel_file,5,2);
		$sel_study='1';

		//��ܲĤ@��ǥ͸��
		$file_name=$temp_path."/".$sel_file;
		$fp=fopen($file_name,"r");

		$h=0;
		$seme=1;
		while ($k=sfs_fgetcsv($fp, 2000, ",")) {
			if ($h>0) {
				if ($os!=$k[1]) {
					$stud_id[$seme]=$k[0];
					$memo_reason[$seme]=addslashes($k[1]);
					$memo[$seme]=addslashes($k[20]);
					$rs=$CONN->Execute("select stud_name,stud_study_year,curr_class_num from stud_base where stud_id='$k[0]'");
					$stud_name[$seme]=addslashes($rs->fields['stud_name']);
					if ($study_year=="") $study_year=$rs->fields['stud_study_year'];
					$seme++;
				}
				$os=$k[1];
			}
			$h++;
		}
		$temp9="<select name='year_seme'>";
		while (list($seme,$v)=each($memo)) {	
			$year=$study_year+floor(($seme-1)/2);
			$se=($seme-1)%2+1;
			$ys=$year."_".$se;
			$selected=($year_seme==$ys)?"selected":"";
			$seme_data[$seme]=$year."�Ǧ~�ײ�".$se."�Ǵ�";
			$temp9.="<option value='$ys' $selected>".$seme_data[$seme];
			$trans_seme.="<input type='hidden' name='seme[".$year.$se."]' value='".$seme."'>\n<input type='hidden' name='seme_data[".$seme."]' value='".$seme_data[$seme]."'>\n";
		}
		if (count($seme_data)>0) $temp9.="<option value='all'>�Ҧ��Ǵ�";
		$temp9.="</select>";

		$main.="
			<form name='form2' enctype='multipart/form-data' action='{$_SERVER['SCRIPT_NAME']}' method='post'>
			<tr bgcolor='#FFFFFF'>
			<td class='title_sbody1' nowrap>�פJ�Ǵ��~�šG<td colspan=2>$temp9</td>
			</tr>
			<tr bgcolor='#FFFFFF'>
			<td class='title_sbody1' nowrap colspan='3'>
			<table cellspacing='1' cellpadding='3' class='main_body'>
			<tr>
			<td class='title_sbody2'>�Ǹ�<br>�m�W</td>
			<td class='title_sbody2'>�Ǵ�</td>
			<td class='title_sbody2' width='300'><p align='left'>���y</p></td>
			</tr>";
		while(list($seme,$v)=each($stud_id)){
			$main.="
				<tr>
				<td class='title_sbody2'>".$stud_id[$seme]."<br>".$stud_name[$seme]."</td>
				<td class='title_sbody2'>$seme</td>
				<td class='title_sbody2'><p align='left'>".$memo[$seme]."</p></td>
				</tr>";
		}
		$main.="
			</table>
              		<input type='hidden' name='trans_key' value='trans'>
              		<input type='hidden' name='sel_file' value='$sel_file'>
              		$trans_seme
			<input type=submit value='�}�l�פJ'>
			</td>
			</tr>
			</form>
			</table>
			$help
			";
	} else {
	$main.="
		</table>
		$help
		";
	}
	return $main;
}

function trans_memo(){
	global $menu_p,$temp_path,$sel_file,$tseme,$rseme,$seme_data,$CONN,$IS_JHORES;
	$toolbar=make_menu($menu_p);

	$sql_select = "select stud_name,student_sn,stud_id from stud_base order by student_sn";
	$recordSet = $CONN->Execute($sql_select);
	while (!$recordSet->EOF) {
		$id=$recordSet->fields['stud_id'];
		$student_sn[$id]=$recordSet->fields['student_sn'];
		$studname[$id]=addslashes($recordSet->fields['stud_name']);
		$recordSet->MoveNext();
	}
	$main="
	$toolbar
	<table cellspacing='1' cellpadding='3' class='main_body'>
	<tr>
	<td class='title_sbody2'><p align='center'>�Ǹ�<br>�m�W</p></td>
	<td class='title_sbody2'><p align='left'>�Ǵ�</p></td>
	<td class='title_sbody2' width='300'><p align='left'>���y</p></td>
	</tr>";
	$file_name=$temp_path."/".$sel_file;
	$fp=fopen($file_name,"r");
	//�������Ĥ@�����, �]���O���D
	$k=sfs_fgetcsv($fp, 2000, ",");
	$total_data=0;
	while($k=sfs_fgetcsv($fp, 2000, ",")) {
		if (in_array($k[1],$tseme)) {
			$seme_year_seme=$rseme[$k[1]];
			$stud_sn=$student_sn[$k[0]];
			$main.="
				<tr>
				<td class='title_sbody1'><p align='center'>".$k[0]."<br>".stripslashes($studname[$k[0]])."</p></td>
				<td class='title_sbody1'><p align='left'>".$seme_data[$k[1]]."</p></td>
				<td class='title_sbody1'><p align='left'>$k[20]</p></td>
				</tr>";
			$sql="select * from stud_seme_score_nor where seme_year_seme='$seme_year_seme' and student_sn='$stud_sn'";
			$rs=$CONN->Execute($sql);
			$check_sn=$rs->fields['student_sn'];
			$ss_score_memo=$rs->fields['ss_score_memo'];
			if (!$check_sn) {
				$sql="insert into stud_seme_score_nor (seme_year_seme,student_sn,ss_id,ss_score,ss_score_memo) values ('$seme_year_seme','$stud_sn','0','','$k[20]')";
				$rs=$CONN->Execute($sql);
			} elseif (!$ss_score_memo) {
				$sql="update stud_seme_score_nor set ss_score_memo='$k[20]' where seme_year_seme='$seme_year_seme' and student_sn='$stud_sn'";
				$rs=$CONN->Execute($sql);
			}
			$total_data++;
		}
	}
	$main.="</table><br>�@ $total_data �����";
	fclose($fp);
	return $main;
}
		
?>

<script language="JavaScript1.2">
<!-- Begin
function jumpMenu(){
	if (document.form1.sel_file.options[document.form1.sel_file.selectedIndex].value!="") {
		location="<?php echo $_SERVER['SCRIPT_NAME']; ?>?sel_file=" + document.form1.sel_file.options[document.form1.sel_file.selectedIndex].value;
	}
}
//  End -->
</script>
