<?php

// $Id: trans_reward.php 5310 2009-01-10 07:57:56Z hami $

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
$year=$_POST['year'];
$sel_study=$_POST['sel_study'];

//�ɮפW��
$file_name=strtoupper($_FILES['upload_file']['name']);
if ($_FILES['upload_file']['size'] >0 && $file_name != "" && strstr($file_name,"XDESRT") && substr($file_name,(strpos($file_name,".")+1),3) == "DBF"){
   copy($_FILES['upload_file']['tmp_name'],$temp_path.$_FILES['upload_file']['name']);
}

if ($trans_key){
	$main=trans_reward();
} else {
	$main=view_trans_reward();
}

//�q�X����
head("�פJ���g�O��");
echo $main;
foot();

function view_trans_reward(){
	global $menu_p,$temp_path,$sel_file,$c_times,$reward_kind,$CONN,$IS_JHORES;
	$toolbar=make_menu($menu_p);
	
	//����
	$help_text="
	�p�G�ɮץ��W�ǡA�Х���ܤ@���ɮפW�ǡC||
	�p�G�ɮפw�W�ǡA�h��ܭn�פJ���ɮסC||
	�W���ɮסG�u\student\person\p9x\xdesrt9x.dbf�v�C||
	�ɮ׻����Gxdesrt91.dbf��91�Ǧ~�סA�̦������C
	";
	$help=help($help_text);

	//�ɮ׿��
	$temp4="<select name='sel_file' onChange='jumpMenu()'>
	<option value=''>�п���ɮ�";
	$fp = opendir($temp_path);
	while ( gettype($file=readdir($fp)) != boolean ){
		$temp5=($sel_file==$file)?"selected":"";
		if (is_file("$temp_path/$file") && (substr($file,0,6)=="XDESRT" || substr($file,0,6)=="Xdesrt")){
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
	�H�W���ɮפ��Ĥ@��ǥ͸�ơA�Х��ֹ�O�_���T�C||
	�Y�ǥͩm�W���X�{�A�Х��פJ�ǥ͸�ơC
	";
		$help=help($help_text);

		//�p��Ǧ~�Ǵ�
		$sel_year=substr($sel_file,6,2);
		$sel_study='1';
	   
		//��ܲĤ@��ǥ͸��
		$file_name=$temp_path."/".$sel_file;
		if ( !$fp = dbase_open($file_name,0) ) { 
       			echo 'Cannot open $file_name\n'; 
       			exit; 
	   	}
		$nr = dbase_numrecords($fp);
		$temp1="";
		$k=dbase_get_record($fp,1);
		$kfirst=$k[0];
		$reward_date=substr($k[1],0,4)."-".substr($k[1],4,2)."-".substr($k[1],6,2);
		$class_year=$sel_study + $IS_JHORES;
		for ($i=5;$i<=7;$i++) {
			if ($k[$i]>0) $rkind=$i; 
	   	}
	   	$rekind=$reward_kind[$k[3]*3+$rkind-4].$c_times[$k[$rkind]]."��";

		$temp9="<select name='year'>";
		$ss=array();
		$i=0;
		$sql_select = "select distinct year from score_ss where enable='1' order by year";
		$recordSet=$CONN->Execute($sql_select);
		while (!$recordSet->EOF) {	
			$year = $recordSet->fields["year"];
			$ss_temp=$year;
			if (!in_array($ss_temp,$ss)){
				$selected=($sel_year==$year)?"selected":"";
				$temp9.="<option value='$ss_temp' $selected>$sel_year"."�Ǧ~��";
				$ss[$i]=$ss_temp;
				$i++;		   
			}
			$recordSet->MoveNext();		   
	   	}
		$temp9.="</select><input type='text' name='sel_study' value='$sel_study' maxlength='1' size='1'>�~��";
		$sql_select = "select * from stud_base where stud_id=$kfirst";
		$recordSet = $CONN->Execute($sql_select);
		$studname=$recordSet->fields['stud_name'];

		$main.="
		<form name='form2' enctype='multipart/form-data' action='{$_SERVER['PHP_SELF']}' method='post'>
		<tr bgcolor='#FFFFFF'>
		<td class='title_sbody1' nowrap>�פJ�Ǧ~�צ~�šG<td colspan=2>$temp9</td>
		</tr>
		<tr bgcolor='#FFFFFF'>
		<td class='title_sbody1' nowrap colspan='3'>
		<table cellspacing='1' cellpadding='3' class='main_body'>
		<tr>
		<td class='title_sbody2'>�Ǹ�<br>�m�W<td class='title_sbody2'>���<td class='title_sbody2'>���g<td class='title_sbody2'>�ƥ�<td class='title_sbody2'>�̾�</td>
		</tr>
		<tr>
		<td class='title_sbody1'>$kfirst<br>$studname<td class='title_sbody1'>$reward_date<td class='title_sbody1'>$rekind<td class='title_sbody1'>$k[4]<td class='title_sbody1'>$k[8]</td>
		</tr>
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

function trans_reward(){
	global $menu_p,$temp_path,$sel_file,$year,$sel_study,$c_times,$reward_kind,$CONN,$IS_JHORES;
	$toolbar=make_menu($menu_p);

	$title_temp="<td class='title_sbody2'>�Ǹ�<br>�m�W<td class='title_sbody2'>���<td class='title_sbody2'>���g<td class='title_sbody2'>�ƥ�<td class='title_sbody2'>�̾�<td class='title_sbody2'>�פJ���p</td>";

	$main="
	$toolbar
	<table cellspacing='1' cellpadding='3' class='main_body'>
	<tr>
	$title_temp
	</tr>
	";
	$file_name=$temp_path."/".$sel_file;
	if ( !$fp = dbase_open($file_name,0) ) { 
		echo 'Cannot open $file_name\n'; 
		exit; 
	} 
	$update_id=$_SESSION['session_tea_name'];;
	if ($_SERVER['HTTP_X_FORWARDED_FOR']){ 
		$update_ip=$_SERVER['HTTP_X_FORWARDED_FOR']; 
	} else { 
		$update_ip=$_SERVER['REMOTE_ADDR']; 
	}
	$nr = dbase_numrecords($fp);
	for ($i=1; $i<=$nr; $i++){ 
		$k=dbase_get_record($fp,$i);
		$sql_select = "select stud_name from stud_base where stud_id='$k[0]'";
		$recordSet = $CONN->Execute($sql_select);
		$studname=$recordSet->fields['stud_name'];
		$reward_date=substr($k[1],0,4)."-".substr($k[1],4,2)."-".substr($k[1],6,2);
		$move_year_seme=$year.$k[2];
		$reward_reason=$k[4];
		$reward_base=$k[8];
		$rkind=($k[3]==0)?(-1):1;
		$reward_div=2-$k[3];
		for ($j=5;$j<=7;$j++) 
			if ($k[$j]>0) {
				$re=$j; 
				$rkind=($k[$j]+($j-5)*2)*$rkind;
			}
		$rekind=$reward_kind[$k[3]*3+$re-4].$c_times[$k[$re]]."��";
		$main.="<tr><td class='title_sbody1'>".$k[0]."<br>$studname</td><td class='title_sbody1'>$reward_date<td class='title_sbody1'>$rekind<td class='title_sbody1'>$k[4]<td class='title_sbody1'>$k[8]";
		$sql_select = "select reward_id from reward where stud_id='$k[0]' and reward_kind='$rkind' and reward_reason='$k[4]' and move_date='$reward_date'";
		$recordSet = $CONN->Execute($sql_select);
		$reid=$recordSet->fields['reward_id'];
		if ($reid=="") {
			$sql_select = "insert into reward (reward_div,stud_id,reward_kind,move_year_seme,move_date,reward_reason,reward_base,update_id,update_ip,reward_sub) values ('$reward_div','$k[0]','$rkind','$move_year_seme','$reward_date','$k[4]','$k[8]','$update_id','$update_ip','1')";
			$recordSet = $CONN->Execute($sql_select);
			$main.="<td class='title_sbody1'>�פJ���\</td>";
		} else
			$main.="<td bgcolor='#ffffff'><font color='#ff0000'>�w�����</font></td>";
	}
	$main.="</tr>";
	dbase_close($fp);
	$main.="</table>";
	$main.="<br><font color='#ff0000'>�פJ��Ʈɤ����\�P�@�馳�ۦP�ƥѪ����g�A�Y�D���~�A�ЦA�ۦ��J�C</font>";
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
