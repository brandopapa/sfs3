<?php

// $Id: place.php 6411 2011-04-20 04:41:16Z infodaes $
include "config.php";

sfs_check();

//�q�X����

head("���a�X���޲z");

$rent_place=$_POST[rent_place];
$linkstr="rent_place=$rent_place";

echo print_menu($MENU_P,$linkstr);


if($_POST['act']=='�s�W'){
	if($_POST[a_rent_place]){
		$sql="INSERT INTO rent_place(rank,rent_place,note,rent_public,rent_private,rent_special,prove_public,prove_private,prove_special,clean_public,clean_private,clean_special) values ('$_POST[a_rank]','$_POST[a_rent_place]','$_POST[a_note]',$_POST[a_rent_public],$_POST[a_rent_private],$_POST[a_rent_special],$_POST[a_prove_public],$_POST[a_prove_private],$_POST[a_prove_special],$_POST[a_clean_public],$_POST[a_clean_private],$_POST[a_clean_special]);";
		$res=$CONN->Execute($sql) or user_error("�s�W���ѡI<br>$sql",256);
	}
};
if($_POST['act']=='�ק�'){
	$sql="update rent_place set rank='$_POST[rank]',rent_place='$_POST[e_rent_place]',note='$_POST[note]',rent_public=$_POST[rent_public],rent_private=$_POST[rent_private],rent_special=$_POST[rent_special],prove_public=$_POST[prove_public],prove_private=$_POST[prove_private],prove_special=$_POST[prove_special],clean_public=$_POST[clean_public],clean_private=$_POST[clean_private],clean_special=$_POST[clean_special] where rent_place='$_POST[rent_place]';";
	$res=$CONN->Execute($sql) or user_error("�ק異�ѡI<br>$sql",256);
	$rent_place='';
};

if($_POST['act']=='�R��'){
	$sql="delete from rent_place where rent_place=$_POST[rent_place]";
	$res=$CONN->Execute($sql) or user_error("�R�����إ��ѡI<br>$sql",256);
};

$main="<table><form name='form_place' method='post' action='$_SERVER[PHP_SELF]'>�����ɳ��a�G
	<select name='rent_place' onchange='this.form.submit()'><option></option>";

//���o���ɳ��a����
$sql="select * from rent_place order by rank";
$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
while(!$res->EOF) {
	$main.="<option ".($rent_place==$res->fields[rent_place]?"selected":"")." value=".$res->fields[rent_place].">(".$res->fields[rank].")".$res->fields[rent_place]."</option>";
	$res->MoveNext();
}
$main.="</select></table>";

//��ܫ��w�Ǵ����ظԲӸ��
$res->MoveFirst();
$showdata="<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%'>

	<tr>
	<td align='center' bgcolor='#CCFF99' rowspan=2>NO.</td>
	<td align='center' bgcolor='#CCFF99' rowspan=2>�Ƨ�</td>
	<td align='center' bgcolor='#CCFF99' rowspan=2>���a�W��</td>
	<td align='center' bgcolor='#CCFF99' colspan=3>���a��������</td>
	<td align='center' bgcolor='#CCFF99' colspan=3>�p�H���c����</td>
	<td align='center' bgcolor='#CCFF99' colspan=3>�S���쯲��</td>
	<td align='center' bgcolor='#CCFF99' rowspan=2>���O����</td>
	<td align='center' bgcolor='#CCFF99' rowspan=2>�\��ާ@</td>
	</tr>
	<tr>
	<td align='center' bgcolor='#CCFF99'>�޲z���@</td>
	<td align='center' bgcolor='#CCFF99'>���q�ɶK</td>
	<td align='center' bgcolor='#CCFF99'>�O�Ҫ�</td>
	<td align='center' bgcolor='#CCFF99'>�޲z���@</td>
	<td align='center' bgcolor='#CCFF99'>���q�ɶK</td>
	<td align='center' bgcolor='#CCFF99'>�O�Ҫ�</td>
	<td align='center' bgcolor='#CCFF99'>�޲z���@</td>
	<td align='center' bgcolor='#CCFF99'>���q�ɶK</td>
	<td align='center' bgcolor='#CCFF99'>�O�Ҫ�</td>
	</tr>";

while(!$res->EOF) {
	
	//echo "====".$_POST[rent_place]."::::::".$res->fields[rent_place];
	
	if($rent_place==$res->fields[rent_place]){
		//�s��
		$showdata.="<tr bgcolor=#AAFFCC><td align='center'>".($res->CurrentRow()+1)."</td>";
		$showdata.="<td><input type='text' name='rank' size=2 value='".$res->fields[rank]."'</td>";
		$showdata.="<td><input type='text' name='e_rent_place' size=10 value='".$res->fields[rent_place]."'</td>";
		$showdata.="<td><input type='text' name='rent_public' size=5 value='".$res->fields[rent_public]."'</td>";
		$showdata.="<td><input type='text' name='clean_public' size=5 value='".$res->fields[clean_public]."'</td>";
		$showdata.="<td><input type='text' name='prove_public' size=5 value='".$res->fields[prove_public]."'</td>";
		$showdata.="<td><input type='text' name='rent_private' size=5 value='".$res->fields[rent_private]."'</td>";
		$showdata.="<td><input type='text' name='clean_private' size=5 value='".$res->fields[clean_private]."'</td>";
		$showdata.="<td><input type='text' name='prove_private' size=5 value='".$res->fields[prove_private]."'</td>";
		$showdata.="<td><input type='text' name='rent_special' size=5 value='".$res->fields[rent_special]."'</td>";
		$showdata.="<td><input type='text' name='clean_special' size=5 value='".$res->fields[clean_special]."'</td>";
		$showdata.="<td><input type='text' name='prove_special' size=5 value='".$res->fields[prove_special]."'</td>";
		$showdata.="<td><input type='text' name='note' size=20 value='".$res->fields[note]."'</td>";
		$showdata.="<td align='center'><input type='submit' value='�ק�' name='act' onclick='return confirm(\"�T�w�n���[".$res->fields[rent_place]."]?\")'><BR><input type='submit' value='�R��' name='act' onclick='return confirm(\"�u���n�R��[".$res->fields[rent_place]."]?\\n\\nPS.��[�T�w]�|�R�����زӥؤΦ��O����,�B��ƱN���i�^�_\")'></td></tr>";
	} else {	
		$showdata.="<tr bgcolor=#FFFFDD><td align='center'>".($res->CurrentRow()+1)."</td>";
		$showdata.="<td align='center'>".$res->fields[rank]."</td>";
		$showdata.="<td align='center'>".$res->fields[rent_place]."</td>";
		
		$showdata.="<td align='center'>".$res->fields[rent_public]."</td>";
		$showdata.="<td align='center'>".$res->fields[clean_public]."</td>";
		$showdata.="<td align='center'>".$res->fields[prove_public]."</td>";
		
		$showdata.="<td align='center'>".$res->fields[rent_private]."</td>";
		$showdata.="<td align='center'>".$res->fields[clean_private]."</td>";
		$showdata.="<td align='center'>".$res->fields[prove_private]."</td>";
		
		$showdata.="<td align='center'>".$res->fields[rent_special]."</td>";
		$showdata.="<td align='center'>".$res->fields[clean_special]."</td>";
		$showdata.="<td align='center'>".$res->fields[prove_special]."</td>";
		
		$showdata.="<td align='center'>".$res->fields[note]."</td>";
	
		$showdata.="<td></td></tr>";
	}
	$res->MoveNext();
}
	//�s�W����
	if(!$rent_place){
	$showdata.="<tr></tr><tr bgcolor='#FFCCCC' height=60><td align='center'><img border=0 src='images/add.gif' alt='�}�C�s����'></td>";
		$showdata.="<td><input type='text' name='a_rank' size=2 value=''</td>";
		$showdata.="<td><input type='text' name='a_rent_place' size=10 value=''</td>";
		$showdata.="<td><input type='text' name='a_rent_public' size=5 value='0'</td>";
		$showdata.="<td><input type='text' name='a_clean_public' size=5 value='0'</td>";
		$showdata.="<td><input type='text' name='a_prove_public' size=5 value='0'</td>";
		$showdata.="<td><input type='text' name='a_rent_private' size=5 value='0'</td>";
		$showdata.="<td><input type='text' name='a_clean_private' size=5 value='0'</td>";
		$showdata.="<td><input type='text' name='a_prove_private' size=5 value='0'</td>";
		$showdata.="<td><input type='text' name='a_rent_special' size=5 value='0'</td>";
		$showdata.="<td><input type='text' name='a_clean_special' size=5 value='0'</td>";
		$showdata.="<td><input type='text' name='a_prove_special' size=5 value='0'</td>";
		$showdata.="<td><input type='text' name='a_note' size=20 value=''</td>";
	$showdata.="<td align='center'><input type='submit' value='�s�W' name='act'><BR><input type='reset' value='���]'></td></tr>";
	}
	$showdata.="</form></table>";

echo $main.$showdata;

foot();

?>