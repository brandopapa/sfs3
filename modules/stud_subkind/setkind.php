<?php
// $Id: setkind.php 6947 2012-10-18 06:07:01Z infodaes $

include_once "config.php";
//include_once "../../include/sfs_case_dataarray.php";
sfs_check();


//�q�X����
head("�ǥͨ������O�]�w");

//��V������
$linkstr="type_id=$type_id";
echo print_menu($MENU_P,$linkstr);

// ���X�Z�Ű}�C
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());
$class_base = class_base($curr_year_seme);
//�ʧO�}�C
$sex_array=array(1=>"�k",2=>"�k");


//�ؼШ���t_id
$type_id=($_REQUEST[type_id]);
if($type_id=='') $type_id='1';

//�ؼоǥ�student_sn
$sn=($_REQUEST[sn]);

//���o���ЯZ�ťN��
$class_num = get_teach_class();

$SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'];
if(checkid($SCRIPT_FILENAME,1) OR $class_num) {
	//���ϬO�n�Ѱ������]�w
	if($sn<>'' and $_REQUEST[act]=='unset')
	{
	   $name=($_REQUEST[name]);
	   //����stud_base�̭��������]�w
	   $SQL="update stud_base set stud_kind=REPLACE(stud_kind,',$type_id,',',') WHERE student_sn=$sn";
	   $recordSet=$CONN->Execute($SQL) or user_error("Ū�����ѡI<br>$SQL",256);
	   //����stud_subkind�̭��������]�w
	   $SQL="delete from stud_subkind WHERE student_sn=$sn AND type_id=$type_id";
	   $recordSet=$CONN->Execute($SQL) or user_error("Ū�����ѡI<br>$SQL",256);
	   echo "\n<script language=\"Javascript\"> alert (\"�w����stud_base�Mstud_subkind����#$sn [$name] �������I\")</script>";
	}

	//���ϬO�n�s�W�ǥͨ����]�w
	if($sn<>'' and $_POST['add_student']=='�����s�W') {
		//�s�Wstud_base�̭��������]�w
	   $SQL="update stud_base set stud_kind=CONCAT(stud_kind,'$type_id,') WHERE student_sn=$sn";
	   $recordSet=$CONN->Execute($SQL) or user_error("Ū�����ѡI<br>$SQL",256);
	}

	//�ؼЯZ��
	$stud_class=$_POST['stud_class'];
	$class_id_arr=explode('_',$stud_class);
	$class_id=sprintf('%d%02d',$class_id_arr[2],$class_id_arr[3]);
	if(checkid($SCRIPT_FILENAME,1)) {
		$class_list=get_class_select(curr_year(),curr_seme(),"","stud_class","this.form.submit",$stud_class);		
	} else {
		$class_id=$class_num;
		$class_list="<input type='hidden' name='stud_class' value='$stud_class'>";
	}
	
	//���o�Z�Ť����w�������O�i�s�W�ǥ�
	$studentdata="<select name='sn'><option></option>";
	$stud_select="SELECT student_sn,right(curr_class_num,2) as num,stud_name FROM stud_base WHERE stud_study_cond=0 AND curr_class_num like '".$class_id."%' AND not stud_kind like '%,".$type_id.",%' ORDER BY num ";
	$recordSet=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);
	while (list($stud_sn,$num,$stud_name)=$recordSet->FetchRow()) $studentdata.="<option value='$stud_sn'>($num)$stud_name</option>";
	$studentdata.="</select>";


	//���o�ǥͨ����C��
	$type_select="SELECT d_id,t_name FROM sfs_text WHERE t_kind='stud_kind' AND d_id>0 order by t_order_id";
	$recordSet=$CONN->Execute($type_select) or user_error("Ū�����ѡI<br>$type_select",256);
	$row_count=$recordSet->recordcount();
	while (list($d_id,$t_name)=$recordSet->FetchRow()) {
			if ($type_id==$d_id)
					$typedata.="<option value='$d_id' selected>($d_id)$t_name</option>";
			else
					$typedata.="<option value='$d_id'>($d_id)$t_name</option>";
	}

	$listdata="<table width='100%' cellspacing='1' cellpadding='3' bgcolor='#FFCCCC'>
				 <form name=\"stud_subkind\" method=\"post\" action=\"$_SERVER[PHP_SELF]\">
				 <tr>
				 <td colspan=2><img border='0' src='images/pin.gif'>�ǥͨ����O�G<select name='type_id' onchange='this.form.submit()'>
				 $typedata</select>�@
				 <td>�W�C�s�ǥ͡G".$class_list."$studentdata
				 <input type='submit' value='�����s�W' name='add_student'>�@<a href='csv_export.php?type_id=$type_id'>CSV</a>";

	$m_arr = get_sfs_module_set("stud_subkind");
	if($m_arr['foreign_id']=='') $m_arr['foreign_id']='100';
				 if($type_id==$m_arr['foreign_id']) $listdata.="�@<a href='xml_export.php?type_id=$type_id'>XML</a>";
				 $listdata.="</td></tr></form></table>";

	//���o�ǥͨ������O�M����
	$type_select="SELECT student_sn,left(curr_class_num,3) as class_id,right(curr_class_num,2)as class_num,stud_id,stud_name,stud_sex,stud_birthday,stud_person_id,stud_tel_1 FROM stud_base WHERE stud_study_cond='0'";
	if(checkid($SCRIPT_FILENAME,1) and $class_id<>'000') $type_select.=" and curr_class_num like '$class_id%'"; else $type_select.=" and curr_class_num like '$class_num%'";
	$type_select.=" and stud_kind like '%,$type_id,%' order by class_id,class_num";
	$recordSet=$CONN->Execute($type_select) or user_error("Ū�����ѡI<br>$type_select",256);
	$data=$recordSet->GetRows();
	//echo $type_select;
	$listdata.="<table width='100%' cellspacing='0' cellpadding='3' bordercolor=#AAFFAA border=1>
				 <tr bgcolor='#AAFFAA' align='center'><td>NO.</td><td>�Z��</td><td>�y��</td><td>�Ǹ�</td><td>�m�W</td><td>�ʧO</td><td>�X�ͦ~���</td><td>�����Ҧr��</td><td>�p���q��</td><td><img src='images/delete.png'>�Ѱ������]�w</td></tr>";
	for($i=0;$i<count($data);$i++)
	{
			$classname=$class_base[$data[$i][1]];
			$listdata.="<tr align='center'>
				 <td>".($i+1)."</td>
				 <td>$classname</td>
				 <td>".$data[$i]['class_num']."</td>
				 <td>".$data[$i]['stud_id']."</td>
				 <td>".$data[$i]['stud_name']."</td>
				 <td>".$sex_array[($data[$i]['stud_sex'])]."</td>
				 <td>".$data[$i]['stud_birthday']."</td>
				 <td>".$data[$i]['stud_person_id']."</td>
				 <td>".$data[$i]['stud_tel_1']."</td>";

			$listdata.="<td><a href=".$_SERVER[PHP_SELF]."?act=unset&type_id=$type_id&sn=".$data[$i]['student_sn']."&name=".$data[$i]['stud_name']."  onclick='return confirm(\"�u���n�Ѱ�".$data[$i]['stud_name']."����������?\")'>�Ѱ�".$data[$i]['stud_name']."</td></tr>";
	}
	$listdata.="<tr bgcolor=#AAFFAA><td colspan=10 align=right>�@".count($data)."�H</td></tr></table>";
	echo $listdata;
} else { echo "<h2><center><BR><BR><font color=#FF0000>�z�å��Q���v�ϥΦ��Ҳ�(�D�ɮv�μҲպ޲z��)</font></center></h2>"; } 
foot();
?>
