<?php

// $Id: detail.php 5310 2009-01-10 07:57:56Z hami $



include "config.php";



sfs_check();



//�q�X����

head("���O�޲z");





//�Ǵ��O

$work_year_seme=$_REQUEST[work_year_seme];

if($work_year_seme=='') $work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());

$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());



$item_id=$_REQUEST[item_id];

$detail_id=$_REQUEST[detail_id];



//��V������

$linkstr="work_year_seme=$work_year_seme&item_id=$item_id";

echo print_menu($MENU_P,$linkstr);



// $_SESSION[session_tea_name]  ���o�Юv�m�W



if($_POST['act']=='�s�W'){

	$sql_select="INSERT INTO charge_detail(item_id,detail_sort,detail,dollars) values ('$item_id','$_POST[a_detail_sort]','$_POST[a_detail]','$_POST[a_dollars]')";

	$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);

};



if($_POST['act']=='�ק�'){

	$sql_select="update charge_detail set item_id=$item_id,detail_sort='$_POST[detail_sort]',detail='$_POST[detail]',dollars='$_POST[dollars]' where detail_id=$detail_id;";

	$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);

	$detail_id=0;

};



if($_POST['act']=='�R��'){

	$sql_select="delete from charge_detail where detail_id=$detail_id";

	$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);

};







//���o�~�׻P�Ǵ����U�Կ��

$seme_list=get_class_seme();

$main="<table><form name='form_item' method='post' action='$_SERVER[PHP_SELF]'>

	<select name='work_year_seme' onchange='this.form.submit()'>";

foreach($seme_list as $key=>$value){

	$main.="<option ".($key==$work_year_seme?"selected":"")." value=$key>$value</option>";

}

$main.="</select><select name='item_id' onchange='this.form.submit()'><option></option>";



//���o�~�׶���

$sql_select="select * from charge_item where year_seme='$work_year_seme' order by end_date desc";

$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);



while(!$res->EOF) {

	$main.="<option ".($item_id==$res->fields[item_id]?"selected":"")." value=".$res->fields[item_id].">".$res->fields[item]."(".$res->fields[start_date]."~".$res->fields[end_date].")</option>";

	$res->MoveNext();

}

$main.="</select>";



//��ܫ��w���ظԲӸ��

$sql_select="select * from charge_detail where item_id='$item_id' order by detail_sort";

$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);



$main.="<select name='detail_id' onchange='this.form.submit()'><option></option>";

while(!$res->EOF) {

	$main.="<option ".($detail_id==$res->fields[detail_id]?"selected":"")." value=".$res->fields[detail_id].">".$res->fields[detail]."</option>";

	$res->MoveNext();

}

$main.="</select></table>";





$showdata="<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%'>

	<tr>

	<td align='center' bgcolor='#CCFF99' size=5>NO.</td>

	<td align='center' bgcolor='#CCFF99' size=5>�Ƨ�</td>

	<td align='center' bgcolor='#CCFF99' size=20>�ӥئW��</td>

	<td align='center' bgcolor='#CCFF99' size=30>�������B(�ХH,���j�U�~��)</td>

	<td align='center' bgcolor='#CCFF99'>�\��ާ@</td>

	</tr>";

$res->MoveFirst();

while(!$res->EOF) {

	if($detail_id==$res->fields[detail_id]){

		$showdata.="<tr bgcolor=#AAFFCC><td align='center'>".($res->CurrentRow()+1)."</td>";

		$showdata.="<td align='center'><input type='text' name='detail_sort' value='".$res->fields[detail_sort]."' size=5></td>";

		$showdata.="<td align='center'><input type='text' name='detail' value='".$res->fields[detail]."' size=30></td>";

		$showdata.="<td align='center'><input type='text' name='dollars' value='".$res->fields[dollars]."' size=30></td>";

		$showdata.="<td align='center'><input type='submit' value='�ק�' name='act' onclick='return confirm(\"�T�w�n���[".$res->fields[detail]."]?\")'>�@<input type='submit' value='�R��' name='act' onclick='return confirm(\"�u���n�R��[".$res->fields[detail]."]?\")'></td></tr>";

	} else {	

		$showdata.="<tr bgcolor=#FFFFDD><td align='center'>".($res->CurrentRow()+1)."</td>";

		$showdata.="<td align='center'>".$res->fields[detail_sort]."</td>";

		$showdata.="<td>".$res->fields[detail]."</td>";

		$showdata.="<td align='center'>".$res->fields[dollars]."</td>";

		$showdata.="<td></td>";



		//�\��s��

		//$showdata.="<td align='center'>";

		//$showdata.="<a href='detail.php?item_id=".$res->fields[item_id]."'><img border=0 src='images/modify.gif' alt='�]�w�ӥ�'> </a>";

		//$showdata.="<a href='record.php?item_id=".$res->fields[item_id]."'><img border=0 src='images/sxw.gif' alt='�L���O��'> </a>";

		//$showdata.="<a href='statistics.php?item_id=".$res->fields[item_id]."'><img border=0 src='images/sigma.gif' alt='���O�έp'> </a>";

		//$showdata.="<a href='item.php?act=delete&item_id=".$res->fields[item_id]."'><img border=0 src='images/delete.gif' alt='�R��' onclick='return confirm(\"�u���n�R�� $stud_name ?\")'></a>";

		$showdata.="</td></tr>";

	}

	$res->MoveNext();

}

if($work_year_seme==$curr_year_seme and $item_id>0)

{

//�s�W�ӥ�

	$showdata.="<tr></tr><tr bgcolor='#FFCCCC' height=60><td align='center'><img border=0 src='images/add.gif' alt='�}�C�s����'></td>";

	$showdata.="<td align='center'><input type='text' name='a_detail_sort' size=5></td>";

	$showdata.="<td align='center'><input type='text' name='a_detail' size=20></td>";

	$showdata.="<td align='center'><input type='text' name='a_dollars' size=24></td>";

	$showdata.="<td align='center'><input type='submit' value='�s�W' name='act'><input type='reset' value='���s�]�w'></td></tr><tr></tr>";

}



$showdata.="</form></table>";



echo $main.$showdata;





foot();

?>