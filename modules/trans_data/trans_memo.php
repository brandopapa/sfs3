<?php

// $Id: trans_memo.php 5310 2009-01-10 07:57:56Z hami $

// ���J�]�w��
include "config.php";

// �{���ˬd
sfs_check();

/*
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}
*/

//����T
$sel_file=$_GET['sel_file'];
$trans_key=$_POST['trans_key'];
$year_seme=$_POST['year_seme'];
$sel_study=$_POST['sel_study'];

//�ɮפW��
$file_name=strtoupper($_FILES['upload_file']['name']);
if ($_FILES['upload_file']['size'] >0 && $file_name != "" && strstr($file_name,"XGUGN") && substr($file_name,(strpos($file_name,".")+1),3) == "DBF"){
   copy($_FILES['upload_file']['tmp_name'],$temp_path.$_FILES['upload_file']['name']);
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
	�W���ɮסG�u\student\person\g9x\xgugn9x.dbf�v�C||
	�ɮ׻����Gxgugn91.dbf��91�Ǧ~�סA�̦������C
	";
	$help=help($help_text);

	//�ɮ׿��
	$temp4="<select name='sel_file' onChange='jumpMenu()'>
	<option value=''>�п���ɮ�";
	$fp = opendir($temp_path);
	while ( gettype($file=readdir($fp)) != boolean ){
		$temp5=($sel_file==$file)?"selected":"";
		if (is_file("$temp_path/$file") && (substr($file,0,5)=="XGUGN" || substr($file,0,5)=="Xgugn")){
			$temp4.="<option value='$file' $temp5>$file";
		}
	}
	closedir($fp);
	$temp4.="</select>";

	$main="
	$toolbar
	<table cellspacing='1' cellpadding='3' class='main_body'>
	<tr bgcolor='#FFFFFF'>
	<form name='form0' enctype='multipart/form-data' action='{$_SERVER['PHP_SELF']}' method='post'>
	<td class='title_sbody1' nowrap>�W���ɮסG<td><input type=file name='upload_file'></td>
	<td class='title_sbody1' nowrap><input type=submit name='doup_key' value='�W��'></td>
	</form>
	</tr>
	<tr bgcolor='#FFFFFF'>
	<form name='form1' action='{$_SERVER['PHP_SELF']}' method='post'>
	<td class='title_sbody1' nowrap>���A�����s�ɮסG<td colspan=2>$temp4</td>
	</form>
	</tr>";

	if ($sel_file){
	//����
	$help_text="
	�H�W���ɮפ��Ĥ@��γ̫�@��ǥ͸�ơA�Х��ֹ�O�_���T�C||
	�Y�ǥͩm�W���X�{�A�Х��פJ�ǥ͸�ơC||
	������ɥ]�t�W�B�U�Ǵ���ơA�ҥH�аȥ���ܥ��T�Ǵ��C||
	�Y�̫�@��ǥ͸�Ƥ����Ĥ@�Ǵ��A�h��ܲĤG�Ǵ�����Ʃ|����J�C||
	�Y���y�椺�L���e�A��ܸ�ƥ���J�C
	";
	$help=help($help_text);

		//�p��Ǧ~�Ǵ�
		$sel_year=substr($sel_file,5,2);
		$sel_study=1;

		//��ܲĤ@��ǥ͸��
		$file_name=$temp_path."/".$sel_file;
		if ( !$fp = dbase_open($file_name,0) ) { 
			echo '�L�k�}�� $file_name\n'; 
			exit; 
		} 
		$nr = dbase_numrecords($fp);
		$temp1="";
		$k=dbase_get_record($fp,1);
		$class_year=$sel_study + $IS_JHORES;

		$temp9="<select name='year_seme'>";
		$ss=array();
		$i=0;
		$sql_select = "select year,semester from score_ss where enable='1' order by year,semester";
		$recordSet=$CONN->Execute($sql_select);
		while (!$recordSet->EOF) {	
			$year = $recordSet->fields["year"];
			$semester = $recordSet->fields["semester"];
			$semester_name=($semester=='2')?"�U":"�W";
			$ss_temp="0".$year.$semester;
			if (!in_array($ss_temp,$ss)){
				$selected=(($sel_year==$year) && ($sel_seme==$semester))?"selected":"";
				$temp9.="<option value='$ss_temp' $selected>$sel_year"."�Ǧ~��"."$semester_name"."�Ǵ�";
				$ss[$i]=$ss_temp;
				$i++;		   
			}
			$recordSet->MoveNext();		   
		}
		$temp9.="</select><input type='text' name='sel_study' value='$sel_study' maxlength='1' size='1'>�~��";

		$main.="
			<form name='form2' enctype='multipart/form-data' action='{$_SERVER['PHP_SELF']}' method='post'>
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
		for ($i=0;$i<2;$i++) {
			if ($i==0) $k=dbase_get_record($fp,1);
			else $k=dbase_get_record($fp,$nr);
			$sql_select = "select * from stud_base where stud_id=$k[0]";
			$recordSet = $CONN->Execute($sql_select);
			$studname=$recordSet->fields['stud_name'];
			$main.="
				<tr>
				<td class='title_sbody2'>$k[0]<br>$studname</td>
				<td class='title_sbody2'>$k[1]</td>
				<td class='title_sbody2'><p align='left'>$k[20]</p></td>
				</tr>";
		}
		$main.="
			</table>
              		<input type='hidden' name='trans_key' value='trans'>
			<input type=submit value='�}�l�פJ'>
			</td>
			</tr>
			</form>
			</table>
			$help
			";
		dbase_close($fp);
	} else {
	$main.="
		</table>
		$help
		";
	}
	return $main;
}

function trans_memo(){
	global $menu_p,$temp_path,$sel_file,$year_seme,$sel_study,$CONN,$IS_JHORES;
	$toolbar=make_menu($menu_p);

	$main="
	$toolbar
	<table cellspacing='1' cellpadding='3' class='main_body'>
	<tr>
	<td class='title_sbody2'>�Ǹ�<br>�m�W</td>
	<td class='title_sbody2'>�Ǵ�</td>
	<td class='title_sbody2' width='300'><p align='left'>���y</p></td>
	</tr>";
	$file_name=$temp_path."/".$sel_file;
	if ( !$fp = dbase_open($file_name,0) ) { 
		echo '�L�k�}�� $file_name\n'; 
		exit; 
	} 
	$nr = dbase_numrecords($fp);
	$sel_seme=substr($year_seme,3,1);
	$seme=$sel_seme;
	$i=1;
	$j=0;
	while ($j!=$seme) {
		$k=dbase_get_record($fp,$i);
		$j=$k[1];
		$i++;
	}
	$i=$i-1;
	$total_data=0;
	while (($i<=$nr)&&($seme==$sel_seme)) {
		$k=dbase_get_record($fp,$i);
		$sql_select = "select stud_name,student_sn from stud_base where stud_id='$k[0]'";
		$recordSet = $CONN->Execute($sql_select);
		$studname=$recordSet->fields['stud_name'];
		$stud_sn=$recordSet->fields['student_sn'];
		$main.="
			<tr>
			<td class='title_sbody2'>$k[0]<br>$studname</td>
			<td class='title_sbody2'>$k[1]</td>
			<td class='title_sbody2'><p align='left'>$k[20]</p></td>
			</tr>";
		$sql="select * from stud_seme_score_nor where seme_year_seme='$year_seme' and student_sn='$stud_sn'";
		$rs=$CONN->Execute($sql);
		$check_sn=$rs->fields['student_sn'];
		$ss_score_memo=$rs->fields['ss_score_memo'];
		if (!$check_sn) {
			$sql="insert into stud_seme_score_nor (seme_year_seme,student_sn,ss_id,ss_score,ss_score_memo) values ('$year_seme','$stud_sn','0','','$k[20]')";
			$rs=$CONN->Execute($sql);
		} elseif (!$ss_score_memo) {
			$sql="update stud_seme_score_nor set ss_score_memo='$k[20]' where seme_year_seme='$year_seme' and student_sn='$stud_sn'";
			$rs=$CONN->Execute($sql);
		}
		$i++;
		$k=dbase_get_record($fp,$i);
		$seme=$k[1];
		$total_data++;
	}
	dbase_close($fp);
	$main.="</table><br>�@ $total_data �����";
	return $main;
}
		
?>

<script language="JavaScript1.2">
<!-- Begin
function jumpMenu(){
	if (document.form1.sel_file.options[document.form1.sel_file.selectedIndex].value!="") {
		location="<?php echo $_SERVER['PHP_SELF']; ?>?sel_file=" + document.form1.sel_file.options[document.form1.sel_file.selectedIndex].value;
	}
}
//  End -->
</script>