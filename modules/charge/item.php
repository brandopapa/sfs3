<?php

// $Id: item.php 5310 2009-01-10 07:57:56Z hami $



include "config.php";

sfs_check();



//�q�X����

head("���O�޲z");



//�Ǵ��O

$work_year_seme=$_REQUEST[work_year_seme];

if($work_year_seme=='') $work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());

$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());



$item_id=$_REQUEST[item_id];



//��V������

$linkstr="work_year_seme=$work_year_seme&item_id=$item_id";

echo print_menu($MENU_P,$linkstr);



if($_POST['act']=='�s�W'){

	$sql_select="INSERT INTO charge_item(year_seme,item_type,item,start_date,end_date,comment,creater) values ('$work_year_seme','$_POST[a_item_type]','$_POST[a_item]','$_POST[a_start_date]','$_POST[a_end_date]','$_POST[a_comment]','$_SESSION[session_tea_name]')";

	$res=$CONN->Execute($sql_select) or user_error("�s�W���ѡI<br>$sql_select",256);

};



if($_POST['act']=='�ק�'){

	$sql_select="update charge_item set year_seme='$work_year_seme',item_type='$_POST[item_type]',item='$_POST[item]',start_date='$_POST[start_date]',end_date='$_POST[end_date]',comment='$_POST[comment]',creater='$_SESSION[session_tea_name]',authority='$_POST[authority]',paid_method='$_POST[paid_method]',announce_note='$_POST[announce_note]',announce_note2='$_POST[announce_note2]',cooperate=$_POST[cooperate] where item_id=$item_id;";

	$res=$CONN->Execute($sql_select) or user_error("�ק異�ѡI<br>$sql_select",256);

	$item_id=0;

};



if($_POST['act']=='�R��'){

	//�R������

	$sql_select="delete from charge_item where item_id=$item_id";

	$res=$CONN->Execute($sql_select) or user_error("�R�����إ��ѡI<br>$sql_select",256);

	//�R���ӥ�

	$sql_select="delete from charge_detail where item_id=$item_id";

	$res=$CONN->Execute($sql_select) or user_error("�R���ӥإ��ѡI<br>$sql_select",256);

	//�R������

	$sql_select="delete from charge_record where item_id=$item_id";

	$res=$CONN->Execute($sql_select) or user_error("�R���������ѡI<br>$sql_select",256);

	

};





if($_POST['act']=='�ƻs'){

	//�ƻs����

	$sql_select="INSERT INTO charge_item(year_seme,item_type,item,comment,creater) values ('$curr_year_seme','$_POST[item_type]','�ƻs-$_POST[item]','$_POST[a_comment]','$_SESSION[session_tea_name]')";

	$res=$CONN->Execute($sql_select) or user_error("�ƻs���إ��ѡI<br>$sql_select",256);

	$item_id=$CONN->insert_id();

	

	//echo "<PRE>";

	//print_r($CONN->insert_id());

	//echo "</PRE>";

	

	//�ƻs�ӥ�

	$sql_select="select * from charge_detail where item_id=$item_id order by detail_sort;";

	$res=$CONN->Execute($sql_select) or user_error("�ƻs�ӥإ��ѡI<br>$sql_select",256);

	$batch_value="";

	while(!$res->EOF)

	{

		$detail_sort=$res->fields[detail_sort];

		$detail=$res->fields[detail];

		$dollars=$res->fields[dollars];

		$batch_value.="($item_id,'$detail_sort','$detail','$dollars'),";

		$res->MoveNext();

	}

	$batch_value=substr($batch_value,0,-1);

	//echo "===================<BR>$batch_value<BR>===================";

	$sql_select="REPLACE INTO charge_detail(item_id,detail_sort,detail,dollars) values $batch_value";

	$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);



	$work_year_seme=$curr_year_seme;



};



if($_POST['act']=='�̮榡�s�W'){

	if($_POST[formatted]){

		//�N�榡�ର�}�C

		$formatted=explode("\r\n",$_POST[formatted]);

		

		//�}�C����

		$item_data=explode("_",$formatted[0]);

		$sql_select="INSERT INTO charge_item(year_seme,item_type,item,comment,creater) values ('$curr_year_seme','$item_data[0]','$item_data[1]','$_POST[a_comment]','$_SESSION[session_tea_name]')";

		$res=$CONN->Execute($sql_select) or user_error("�}�C���إ��ѡI<br>$sql_select",256);

		$item_id=$CONN->insert_id();

		

		array_shift($formatted);		

		//�ƻs�ӥ�

		$batch_value="";

		foreach($formatted as $value)

		{

			if($value)

			{

				$value=explode("_",$value);

				$detail_sort=$value[0];

				$detail=$value[1];

				$dollars=$value[2];

				$batch_value.="($item_id,'$detail_sort','$detail','$dollars'),";

			}

		}

		$batch_value=substr($batch_value,0,-1);

		$sql_select="REPLACE INTO charge_detail(item_id,detail_sort,detail,dollars) values $batch_value";

		$res=$CONN->Execute($sql_select) or user_error("�}�C�ӥإ��ѡI<br>$sql_select",256);

		$work_year_seme=$curr_year_seme;

		echo "<script language=\"Javascript\"> alert (\"���ػP�ӥؤw�̮榡�}�C,���~��]�w[���O���]��[���O����]�I\")</script>";

	}

};











//���o�~�׻P�Ǵ����U�Կ��

$seme_list=get_class_seme();

$main="<table><form name='form_item' method='post' action='$_SERVER[PHP_SELF]'>

	<select name='work_year_seme' onchange='this.form.submit()'>";

foreach($seme_list as $key=>$value){

	$main.="<option ".($key==$work_year_seme?"selected":"")." value=$key>$value</option>";

}

$main.="</select>�@<img border=0 src='images/modify.gif' alt='�s�׿�w����'><select name='item_id' onchange='this.form.submit()'><option></option>";



//���o�~�׶���

$sql_select="select * from charge_item where year_seme='$work_year_seme' order by end_date desc";

$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);



while(!$res->EOF) {

	$main.="<option ".($item_id==$res->fields[item_id]?"selected":"")." value=".$res->fields[item_id].">".$res->fields[item]."(".$res->fields[start_date]."~".$res->fields[end_date].")</option>";

	$res->MoveNext();

}

$main.="</select></table>";



//��ܫ��w�Ǵ����ظԲӸ��



$res->MoveFirst();



$showdata="<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%'>

	<tr>

	<td align='center' bgcolor='#CCFF99'>NO.</td>

	<td align='center' bgcolor='#CCFF99'>���O</td>

	<td align='center' bgcolor='#CCFF99'>���ئW��</td>

	<td align='center' bgcolor='#CCFF99' colspan=2>���O���</td>

	<td align='center' bgcolor='#CCFF99'>�޲z�Ƶ�</td>

	<td align='center' bgcolor='#CCFF99'>�}�C��</td>

	</tr>";

while(!$res->EOF) {

	if($item_id==$res->fields[item_id]){

		//�̾ڰѷ�

		$authority=explode(',',$m_arr['authority']);

		foreach($authority as $value){

			$authority_ref.="<option>$value</option>";

		}

		$authority_ref="<select name='authority_ref' onchange='this.form.authority.value=this.options[this.selectedIndex].text'><option></option>$authority_ref</select>";

		

		//���ڤ覡

		$paid_method=explode(',',$m_arr['paid_method']);

		foreach($paid_method as $value){

			$paid_method_ref.="<option>$value</option>";

		}

		$paid_method_ref="<select name='paid_method_ref' onchange='this.form.paid_method.value=this.options[this.selectedIndex].text'><option></option>$paid_method_ref</select>";

		

		

		

		$showdata.="<tr bgcolor=#AAFFCC><td align='center'>".($res->CurrentRow()+1)."</td>";

		$showdata.="<td colspan=5>�����@�@�O�G<input type='text' name='item_type' size=10 value=".$res->fields[item_type]."><BR>";

		$showdata.="�����ئW�١G<input type='text' name='item' size=40 value=".$res->fields[item]."><BR>";

		$showdata.="���޲z�Ƶ��G<input type='text' name='comment' size=40 value=".$res->fields[comment]."><BR>";

		$showdata.="�����O����G<input type='text' name='start_date' size=10 value=".$res->fields[start_date].">��<input type='text' name='end_date' size=10 value=".$res->fields[end_date]."><BR>";

		$showdata.="���̡@�@�ڡG$authority_ref => <input type='text' name='authority' size=30 value=".$res->fields[authority]."><BR>";

		$showdata.="��ú�ڤ覡�G$paid_method_ref => <input type='text' name='paid_method' size=30 value=".$res->fields[paid_method]."><BR>";

		$showdata.="����ڪ��O�G<input type='text' name='announce_note' size=40 value=".$res->fields[announce_note]."><BR>";

		$showdata.="�@�@�@�@�@�@<input type='text' name='announce_note2' size=40 value=".$res->fields[announce_note2]."><BR>";
		
		$showdata.="�����O�޲z(�ɮv��)��P�@�~�G<select name='cooperate'><option ".($res->fields[cooperate]?"selected":"")."  value='1'>�i</option><option ".(!$res->fields[cooperate]?" selected":"")." value='0'>�_</option></select>'</td>";
		
		$showdata.="<td align='center'><input type='submit' value='�ק�' name='act' onclick='return confirm(\"�T�w�n���[".$res->fields[item]."]?\")'><BR><BR><input type='submit' value='�R��' name='act' onclick='return confirm(\"�u���n�R��[".$res->fields[item]."]?\\n\\nPS.��[�T�w]�|�R�����زӥؤΦ��O����,�B��ƱN���i�^�_\")'><BR><BR><input type='submit' value='�ƻs' name='act' onclick='return confirm(\"�T�w�n�ƻs[".$res->fields[item]."]�ܥ��Ǧ~?\")'>�@</td></tr>";

	} else {	

		$showdata.="<tr bgcolor=#FFFFDD><td align='center'>".($res->CurrentRow()+1)."</td>";

		$showdata.="<td align='center'>".$res->fields[item_type]."</td>";

		$showdata.="<td>".$res->fields[item]."</td>";

		$showdata.="<td align='center'>".$res->fields[start_date]."</td>";

		$showdata.="<td align='center'>".$res->fields[end_date]."</td>";

		$showdata.="<td>".$res->fields[comment]."</td>";

		$showdata.="<td align='center'>".$res->fields[creater]."</td>";

		//$showdata.="<td align='center'>".$res->fields[timestamp]."</td>";

		//�\��s��

		//$showdata.="<td align='center'>";

		//$showdata.="<a href='detail.php?item_id=".$res->fields[item_id]."'><img border=0 src='images/modify.gif' alt='�]�w�ӥ�'> </a>";

		//$showdata.="<a href='record.php?item_id=".$res->fields[item_id]."'><img border=0 src='images/sxw.gif' alt='�L���O��'> </a>";

		//$showdata.="<a href='statistics.php?item_id=".$res->fields[item_id]."'><img border=0 src='images/sigma.gif' alt='���O�έp'> </a>";

		//$showdata.="<a href='item.php?act=delete&item_id=".$res->fields[item_id]."'><img border=0 src='images/delete.gif' alt='�R��' onclick='return confirm(\"�u���n�R��?\")'></a>";

		$showdata.="</td></tr>";

	}



	$res->MoveNext();

}



if($work_year_seme==$curr_year_seme)

{

//�N�t���ܼƿﶵ�ରcombobox

$types="<select name='a_item_type'><option>".str_replace(",","</option><option>",$m_arr['types'])."</option></select>";

	//�s�W����

	$showdata.="<tr></tr><tr bgcolor='#FFCCCC' height=60><td align='center'><img border=0 src='images/add.gif' alt='�}�C�s����'></td>";

	$showdata.="<td align='center'>$types</td>";

	$showdata.="<td align='center'><input type='text' name='a_item' size=30></td>";

	$showdata.="<td align='center'><input type='text' name='a_start_date' size=8></td>";

	$showdata.="<td align='center'><input type='text' name='a_end_date' size=8></td>";

	$showdata.="<td align='center'><input type='text' name='a_comment' size=20></td>";



	$showdata.="<td align='center'><input type='submit' value='�s�W' name='act'><input type='reset' value='���s�]�w'></td></tr>";

	

	//�̷Ӯ榡�s�W����

	$showdata.="<tr bgcolor='#CFFC88'><td align='center'><img border=0 src='images/batchadd.gif' alt='�榡�s�W���ػP�ӥ�'></td>";

	$showdata.="<td colspan=2><textarea rows=13 name='formatted' cols=43></textarea></td>";

	$showdata.="<td colspan=3><pre>�榡�G
[���O]_[���ئW��]
[�Ƨ�]_[�ӥئW��]_[�������B]
[�Ƨ�]_[�ӥئW��]_[�������B]
	:
�d�ҡG
���U�O_�Ǵ����U�O(�U���N���N��O)
A0_�Z�ŶO_50,50,50,50,50,50
B0_�a���|�O_100,100,100,100,100,100
C0_���w�O�I�O_138,138,138,138,138,138
D0_�Ь�ѶO_752,747,921,992,842,838
E0_���\�U�ƶO_160,160,160,160,160,160
E1_���\�򥻶O_300,300,300,300,300,300
F0_�q���]�ƺ��@�O_0,0,0,230,230,230</PRE></td>";
	$showdata.="<td align='center'><input type='submit' value='�̮榡�s�W' name='act'></td></tr><tr></tr>";

}



$showdata.="</form></table>";



echo $main.$showdata;



foot();

?>