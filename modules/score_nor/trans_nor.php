<?php

// $Id: trans_nor.php 6217 2010-10-14 03:32:00Z brucelyc $

// ���J�]�w��
include "config.php";

// �{���ˬd
sfs_check();

//����T
$sel_file=($_POST['sel_file'])?$_POST['sel_file']:$_GET['sel_file'];
$trans_key=$_POST['trans_key'];
$year_seme=$_POST['year_seme'];
$sel_study=$_POST['sel_study'];

//�ɮפW��
$file_name=strtoupper($_FILES['upload_file']['name']);
if ($_FILES['upload_file']['size'] >0 && $file_name != "" && strstr($file_name,"XGUGN") && substr($file_name,(strpos($file_name,".")+1),3) == "CSV"){
	copy($_FILES['upload_file']['tmp_name'],$temp_path.$file_name);
}

if ($trans_key){
	$main=trans_nor();
} else {
	$main=view_trans_nor();
}

//�q�X����
head("�פJ��`���Z");
echo $main;
foot();

function view_trans_nor(){
	global $menu_p,$temp_path,$sel_file,$CONN,$IS_JHORES;
	$toolbar=make_menu($menu_p);
	
	//����
	$help_text="
	�p�G�ɮץ��W�ǡA�Х���ܤ@���ɮפW�ǡC||
	�p�G�ɮפw�W�ǡA�h��ܭn�פJ���ɮסC||
	�n�B�z���ɮסG�u\student\person\g9x\xgugn9x.dbf�v�C||
	�Х��N���ɥHExcel���}�A�M��s��CSV�榡��A��ܤW�ǡC||
	�]�N�O�W�ǫe���N�ɮצs���uXGUGN9x.CSV�v�C||
	�ɮ׻����Gxgugn91.dbf��91�Ǧ~�סA�̦������C
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
	�H�W���ɮפ��Ĥ@��γ̫�@��ǥ͸�ơA�Х��ֹ�O�_���T�C||
	�Y�ǥͩm�W���X�{�A�Х��פJ�ǥ͸�ơC||
	������ɥ]�t�W�B�U�Ǵ���ơA�ҥH�аȥ���ܥ��T�Ǵ��C||
	�Y�̫�@��ǥ͸�Ƥ����Ĥ@�Ǵ��A�h��ܲĤG�Ǵ�����Ʃ|����J�C||
	�Y�椺��Ƭ�999�A��ܦ��楼��J��ơA�פJ�ɷ|�۰��ন0�C 
	";
	$help=help($help_text);

		//�p��Ǧ~�Ǵ�
		$sel_year=substr($sel_file,5,2);
		$sel_study=1;

		//��ܲĤ@��ǥ͸��
		$file_name=$temp_path."/".$sel_file;
		$fp=fopen($file_name,"r");

		for ($h=0;$h<2;$h++){
			$k=sfs_fgetcsv($fp,2000,",");
			//�u����פJ�ɪ��ĤG�C
			if ($h==1){
				$temp1="";
				$class_year=$sel_study + $IS_JHORES;
				$temp9="<select name='year_seme'>";
				$ss=array();
				$i=0;
				$sql_select = "select distinct seme_year_seme from stud_seme order by seme_year_seme";
				$recordSet=$CONN->Execute($sql_select);
				while (!$recordSet->EOF) {	
					$seme_year_seme = $recordSet->fields["seme_year_seme"];
					$year=intval(substr($seme_year_seme,0,3));
					$semester=substr($seme_year_seme,-1,1);
					$semester_name=($semester=='2')?"�U":"�W";
					$ss_temp=$year."_".$semester;
					if (!in_array($ss_temp,$ss)){
						$selected=(($sel_year==$year) && ($sel_seme==$semester))?"selected":"";
						$temp9.="<option value='$ss_temp' $selected>$year"."�Ǧ~��"."$semester_name"."�Ǵ�";
						$ss[$i]=$ss_temp;
						$i++;		   
					}
					$recordSet->MoveNext();
				}
				$temp9.="</select><input type='text' name='sel_study' value='$sel_study' maxlength='1' size='1'>�~��";

				$main.="
				<form name='form2' enctype='multipart/form-data' action='{$_SERVER['SCRIPT_NAME']}' method='post'>
				<tr bgcolor='#FFFFFF'>
				<td class='title_sbody1' nowrap>�פJ�Ǵ��~�šG<td colspan=2>$temp9</td>
				</tr>
				<tr bgcolor='#FFFFFF'>
				<td class='title_sbody1' nowrap colspan='3'>
				<table cellspacing='1' cellpadding='3' class='main_body'>
				<tr>
				<td class='title_sbody2' rowspan='2'>�Ǹ�<br>�m�W</td>
				<td class='title_sbody2' rowspan='2'>�Ǵ�</td>
				<td class='title_sbody2'>��`��{�[���</td>
				<td class='title_sbody2' colspan='4'><center>���鬡�ʥ[���</center></td>
				<td class='title_sbody2' rowspan='2'>�S��[��</td>
				</tr>
				<tr>
				<td class='title_sbody2'><center>�ɮv����</center></td>
				<td class='title_sbody2'>�Z�Ŭ���</td>
				<td class='title_sbody2'>���ά���</td>
				<td class='title_sbody2'>�ǥ۪ͦv</td>
				<td class='title_sbody2'>�Ǯլ���</td>
				</tr>";
				for ($i=0;$i<2;$i++) {
					if ($i==0) {
						$k=sfs_fgetcsv($fp,2000,",");
						$k=sfs_fgetcsv($fp,2000,",");					
					} else {
						$contents=fread($fp,filesize($file_name));
						$cs=explode("\n",$contents);
						$k=explode(",",$cs[count($cs)-2]);
					}
					$sql_select = "select * from stud_base where stud_id=$k[0]";
					$recordSet = $CONN->Execute($sql_select);
					$studname=$recordSet->fields['stud_name'];
					$main.="
						<tr>
						<td class='title_sbody2'>$k[0]<br>$studname</td>
						<td class='title_sbody2'>$k[1]</td>
						<td class='title_sbody2'>$k[8]</td>
						<td class='title_sbody2'>$k[11]</td>
						<td class='title_sbody2'>$k[12]</td>
						<td class='title_sbody2'>$k[13]</td>
						<td class='title_sbody2'>$k[14]</td>
						<td class='title_sbody2'>$k[16]</td>
						</tr>";
				}
				$main.="
					</table>
		              		<input type='hidden' name='trans_key' value='trans'>
		              		<input type='hidden' name='sel_file' value='$sel_file'>
					<input type=submit value='�}�l�פJ'>
					</td>
					</tr>
					</form>
					</table>
					$help
					";
			}
		}
	} else {
		$main.="
			</table>
			$help
			";
	}
	return $main;
}

function trans_nor(){
	global $menu_p,$temp_path,$sel_file,$year_seme,$sel_study,$CONN,$IS_JHORES;
	$toolbar=make_menu($menu_p);

	$nor_val=array("1"=>"��{�u��","2"=>"��{�}�n","3"=>"��{�|�i","4"=>"�ݦA�[�o","5"=>"���ݧ�i");
	$nor_kind=array("10"=>"1","9"=>"1","8"=>"2","7"=>"2","6"=>"3","5"=>"3","4"=>"3","3"=>"4","2"=>"4","1"=>"5","0"=>"5");
	$Create_db="CREATE TABLE  if not exists seme_score_nor (
	   seme_year_seme varchar(6) NOT NULL,
	   stud_id varchar(20) NOT NULL,
	   score1 smallint(3) NOT NULL default '0' ,
	   score2 smallint(3) NOT NULL default '0' ,
	   score3 smallint(3) NOT NULL default '0' ,
	   score4 smallint(3) NOT NULL default '0' ,
	   score5 smallint(3) NOT NULL default '0' ,
	   score6 smallint(3) NOT NULL default '0' ,
	   score7 smallint(3) NOT NULL default '0' ,
	   PRIMARY KEY  (seme_year_seme,stud_id),
	   KEY  (stud_id))";
	mysql_query($Create_db);
	$main="
	$toolbar
		<table cellspacing='1' cellpadding='3' class='main_body'>
		<tr>
		<td class='title_sbody2' rowspan='2'>�Ǹ�<br>�m�W</td>
		<td class='title_sbody2' rowspan='2'>�Ǵ�</td>
		<td class='title_sbody2'>��`��{�[���</td>
		<td class='title_sbody2' colspan='4'><center>���鬡�ʥ[���</center></td>
		<td class='title_sbody2' rowspan='2'>�S��[��</td>
		</tr>
		<tr>
		<td class='title_sbody2'><center>�ɮv����</center></td>
		<td class='title_sbody2'>�Z�Ŭ���</td>
		<td class='title_sbody2'>���ά���</td>
		<td class='title_sbody2'>�ǥ۪ͦv</td>
		<td class='title_sbody2'>�Ǯլ���</td>
		</tr>";
	$file_name=$temp_path."/".$sel_file;
	$fp=fopen($file_name,"r");
	//�������Ĥ@�����, �]���O���D
	$k=sfs_fgetcsv($fp, 2000, ",");
	$ys=explode("_",$year_seme);
	$sel_year=$ys[0];
	$sel_seme=$ys[1];
	$year_seme=sprintf("%03d",$ys[0]).$ys[1];
	$contents=fread($fp,filesize($file_name));
	$cs=explode("\n",$contents);
	$nr=count($cs)-1;
	$total_data=0;
	for ($i=0;$i<$nr;$i++) {
		$k=explode(",",$cs[$i]);
		if ($k[1]==$ys[1]) {
			$sql_select = "select a.stud_name,b.seme_class from stud_base a,stud_seme b where a.student_sn=b.student_sn and a.stud_id='$k[0]'";
			$recordSet = $CONN->Execute($sql_select);
			$studname=$recordSet->fields['stud_name'];
			$seme_class=$recordSet->fields['seme_class'];
			$class_id=sprintf("%03d_%1d_%02d_%02d",$ys[0],$ys[1],substr($seme_class,0,1),substr($seme_class,-2,2));
			$k[8]=($k[8]=="999")?"0":$k[8];
			$k[11]=($k[11]=="999")?"0":$k[11];
			$k[12]=($k[12]=="999")?"0":$k[12];
			$k[13]=($k[13]=="999")?"0":$k[13];
			$k[14]=($k[14]=="999")?"0":$k[14];
			$k[16]=($k[16]=="999")?"0":$k[16];
			if ($k[16]>5) $k[16]=5;
			$main.="
			<tr>
			<td class='title_sbody2'>$k[0]<br>$studname</td>
			<td class='title_sbody2'>$k[1]</td>
			<td class='title_sbody2'>$k[8]</td>
			<td class='title_sbody2'>$k[11]</td>
			<td class='title_sbody2'>$k[12]</td>
			<td class='title_sbody2'>$k[13]</td>
			<td class='title_sbody2'>$k[14]</td>
			<td class='title_sbody2'>$k[16]</td>
			</tr>";
			$sql="select * from seme_score_nor where seme_year_seme='$year_seme' and stud_id='$k[0]'";
			$rs=$CONN->Execute($sql);
			$stud_id=$rs->fields['stud_id'];
			if (!$stud_id) {
				$sql="insert into seme_score_nor (seme_year_seme,stud_id,score1,score2,score3,score4,score5,score6,score7) values ('$year_seme','$k[0]','$k[8]','$k[11]','$k[12]','$k[13]','$k[14]','0','$k[16]')";
				$rs=$CONN->Execute($sql);
			}
			check_nor($year_seme,$k[0],1,$nor_val[$nor_kind[(integer)$k[8]+5]]);
			$l=round(($k[11]+$k[12]+$k[13]+$k[14])/4);
			check_nor($year_seme,$k[0],2,$nor_val[$nor_kind[$l+5]]);
			check_nor($year_seme,$k[0],3,$nor_val[$nor_kind[5]]);
			check_nor($year_seme,$k[0],4,$nor_val[$nor_kind[(integer)$k[16]+5]]);
			check_oth($year_seme,$k[0]);
			$total_data++;
		}
	}
	$main.="</table><br>�@ $total_data �����";
	fclose($fp);
	return $main;
}

function check_nor($year_seme,$stud_id,$ss_id,$ss_val) {
	global $CONN;
	
	$sql_chk="select * from stud_seme_score_oth where seme_year_seme='$year_seme' and stud_id='$stud_id' and ss_id='$ss_id'";
	$rs_chk=$CONN->Execute($sql_chk);
	$chk_ss_id=$rs_chk->fields['ss_id'];
	$chk_ss_val=$rs_chk->fields['ss_val'];
       	if (($chk_ss_id!="")&&($ss_val!="")) {
     		$sql_chk="update stud_seme_score_oth set ss_val='$ss_val' where seme_year_seme='$year_seme' and stud_id='$stud_id' and ss_id='$ss_id'";
      		$rs_chk=$CONN->Execute($sql_chk);
       	} else {
       		$sql_chk="insert into stud_seme_score_oth (seme_year_seme,stud_id,ss_kind,ss_id,ss_val) values ('$year_seme','$stud_id','�ͬ���{���q','$ss_id','$ss_val')";
       		$rs_chk=$CONN->Execute($sql_chk);
      	}
}

function check_oth($year_seme,$stud_id) {
	global $CONN;
	
	$sql_chk="select * from stud_seme_score_oth where seme_year_seme='$year_seme' and stud_id='$stud_id' and ss_id='0'";
	$rs_chk=$CONN->Execute($sql_chk);
	$chk_ss_id=$rs_chk->fields['ss_id'];
	if (!$chk_ss_id) {
       		$sql_chk="insert into stud_seme_score_oth (seme_year_seme,stud_id,ss_kind,ss_id,ss_val) values ('$year_seme','$stud_id','��L�]�w','0','')";
       		$rs_chk=$CONN->Execute($sql_chk);
      	}
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
