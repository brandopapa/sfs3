<?php
// $Id: mstudent.php 6141 2010-09-14 03:17:12Z brucelyc $

// --�t�γ]�w��
include "create_data_config.php";

//--�{�� session
sfs_check();

if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�

$act=($_GET[act])?$_GET[act]:$_POST[act];

if ($act=="�妸�إ߸��"){
	$msg=import($_POST[class_id],$sel_year,$sel_seme);
	header("location: {$_SERVER['PHP_SELF']}?act=result&main=$msg");
}elseif($act=="result"){
	$main="<table cellspacing='1' cellpadding='10' class=main_body>
	<tr bgcolor='#E1ECFF'><td>$_GET[main]</td></tr></table>";
}else{
	$main=main_form($sel_year,$sel_seme);
}

//�L�X���Y
head("�j�q�إ߾ǥ͸�ơG²����");
echo $main;
foot();


//�D�n���
function main_form($sel_year,$sel_seme){
	global $menu_p;
	
	$toolbar=&make_menu($menu_p);
	
	//�~�ŻP�Z�ſ��
	$class_select=&classSelect($sel_year,$sel_seme,"","class_id","",false);
	
		
	$main="
	$toolbar
	<table border='0' cellspacing='0' cellpadding='0' >
	<tr><td valign=top>
		<table cellspacing='1' cellpadding='10' class=main_body >
		<form action ='{$_SERVER['PHP_SELF']}' enctype='multipart/form-data' method=post>
		<tr><td  nowrap valign='top' bgcolor='#E1ECFF'>
		<p>�Ы��y�s���z��ܶפJ�ɮרӷ��G</p>
		�N�W��פJ���@�ӯZ�šH
		$class_select<br>
		<input type=file name='userdata'>
		<p><input type=submit name='act' value='�妸�إ߸��'></p></td>
		<td valign='top' bgcolor='#FFFFFF'>
		<p><b><font size='4'>�ǥ�²����Ƨ妸���ɻ���</font></b></p>
		<ol>
		<li>���פJ����<font color='#FF0000'>���䴩�U�ת��榡�I</font>�A�����ۦ�s�@�פJ�ɡC</li>
		<li>�פJ�ɥi�Q�θպ��u��Τ�r�s�边�ӻs�@�A�s�� csv �ɡA�ëO�d�Ĥ@�C���D�ɡA�p
		<a href=newstudemo.csv target=new>�d����</a></li>
		<li>�X�ͤ���H�褸���ǡC</li>
		<li>�ʧO�Ρu1�v�ӥN��k�͡A�u2�v�ӥN��k�͡C</li>
		
		</ol>
		</td></tr>
		</form>
		</table>
	</td></tr></table>
	";
	return $main;
}


//�פJ���
function import($class_id,$sel_year,$sel_seme){
	global $temp_path,$CONN;

	$userdata=$_FILES['userdata']['tmp_name'];
	$userdata_name=$_FILES['userdata']['name'];
	$userdata_size=$_FILES['userdata']['size'];

	$temp_file= $temp_path."stud.csv";
	
	//�qclass_id �����o�������
	//091_1_01_02=>[0]=91�B[1]=1�B[2]=102�A[3]=1�A[4]=2�A[5]=�@�~�G�Z
	$c=class_id_2_old($class_id);
	
	
	//���X�ӯZ���W��
	$query = "select c_name from school_class where class_id='$class_id'";
	$recordSet= $CONN->Execute($query) or user_error($query,256);
	list($c_name)=$recordSet->FetchRow();
	
	//die($temp_file);
	if ($userdata_size > 0 && $userdata_name!=""){
		//die($temp_file);
		$msg=(copy($userdata , $temp_file))?"�ɮ׶פJ�����C<br>":"�ɮ׶פJ���ѡC<br>";
		$fd = fopen ($temp_file,"r");
		$msg.=(empty($fd))?"Ū���ɮץ��ѡC<br>":"Ū���ɮק����C<br>";
		while ($tt = sfs_fgetcsv ($fd, 2000, ",")) {
			if ($i++ == 0) //�Ĥ@�������Y
			continue ;
			$stud_id = trim ($tt[0]);					//�Ǹ�
			$stud_num=chop ($tt[1]);				//�y��
			$stud_name = trim ($tt[2]);					//�m�W
			$stud_person_id = trim ($tt[3]);			//�����Ҹ�
			$stud_birthday = trim ($tt[4]);				//�ͤ�
			$stud_sex = trim ($tt[5]);					//�ʧO
			
			if(empty($stud_id) or empty($stud_name) or empty($stud_birthday)){
				continue ;
			}
					
			//�ഫ���ǩǪ��ǥͽs��
			$curr_class_num= $c[2]*100+$stud_num;
			
			//�ǥͤJ�Ǧ~�A�Q�ξǸ��e�T�X�ӧP�_
			$stud_study_year=$tt[6];
			
			//�s�W�ǥ͸�ƻs��Ʈw
			$add1=add_2_stud_base($stud_id,$stud_name,$stud_sex,$stud_birthday,$stud_person_id,$stud_study_year,$curr_class_num);
			
			//��Ǧ~�M�Ǵ��¦b�@�_
			//�Ǧ~�Ǵ�
			$seme_year_seme = sprintf("%04d", $sel_year.$sel_seme);
			
			//�s�W�ǥ͸�ƨ�Ǵ�������
			$add2=add_2_stud_seme($seme_year_seme,$stud_id,$c[2],$stud_num,$c_name);
			
			//�s�W�ǥ͸�ƨ���y������
			$add3=add_2_stud_domicile($stud_id);
			
			$msg.=($add1 and $add2 and $add3)?"$stud_id -- $stud_name �s�WOK�I<br>":"<font color=red>$stud_id -- $stud_name �s�W�L�{�����D�A�Цۦ�d���I</font><br>";
		}
	}else{
		$msg.="�ɮ׮榡���~�I";
	}
	unlink($temp_file);
	return $msg;
}

//�s�W��stud_base
function add_2_stud_base($stud_id,$stud_name,$stud_sex,$stud_birthday,$stud_person_id,$stud_study_year,$curr_class_num){
	global $CONN;
	$stud_kind =',0,';
	$sql_insert = "replace into stud_base
	(stud_id,stud_name,stud_sex,stud_birthday,stud_person_id,stud_study_year,curr_class_num,stud_study_cond,stud_kind,enroll_school)
	values
	('$stud_id','$stud_name','$stud_sex','$stud_birthday','$stud_person_id','$stud_study_year','$curr_class_num','0','$stud_kind','$school_long_name')";
	if($CONN->Execute($sql_insert)){return true;}else{user_error($sql_insert,256);}
	return false;
}


//�s�W��stud_seme
function add_2_stud_seme($seme_year_seme,$stud_id,$seme_class,$seme_num,$c_name){
	global $CONN;
	//���o student_sn
	$query = "select student_sn from stud_base where stud_id='$stud_id'";
	$resss = $CONN->Execute($query);
	$student_sn= $resss->fields[0];

	$sql_insert = "replace into stud_seme
	(seme_year_seme,stud_id,seme_class,seme_class_name,seme_num,student_sn)
	values
	('$seme_year_seme','$stud_id','$seme_class','$c_name','$seme_num','$student_sn')";

	if($CONN->Execute($sql_insert)){return true;}
	return false;
}
function add_2_stud_domicile($stud_id){
	global $CONN;
	$query = "replace into  stud_domicile (stud_id) values('$stud_id')";
	if($CONN->Execute($query)){return true;}
	return false;
}	
?>
