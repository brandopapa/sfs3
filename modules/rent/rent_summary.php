<?php
// $Id: rent_summary.php 6548 2011-09-23 08:08:11Z infodaes $

include "config.php";
sfs_check();
//�q�X����
head("���a�X���޲z");
echo print_menu($MENU_P);

$purpose=$_POST[purpose];
//�έp����
$purpose_item=array("�~�ײέp","����έp","��O�έp","�W�Ȯɬq�έp","�U�Ȯɬq�έp","�߶��ɬq�έp","�ӽЪ̲έp","���a�έp","���O�έp","�޲z���@�O�έp","���q�ɶK�O�έp","�O�Ҫ��έp","�Ƶ��έp");

$purpose_select="<select name='purpose' onchange='this.form.submit()'>��";
foreach($purpose_item as $key=>$value)
{
	$is_key=($key==$purpose?'selected':'');
	$purpose_select.="<option $is_key value='$key'>$value</option>";
}
$purpose_select.=".</select>";


//��ܵ��G
$proved="(NOT ISNULL(prove_id))";
switch ($purpose) {
case 0:
	$sql="SELECT year(rent_date) as year,count(*) FROM rent_record GROUP BY year";
    break;
case 1:
	$sql="SELECT month(rent_date) as month,count(*) FROM rent_record GROUP BY month";
    break;
case 2:
	$sql="SELECT DAY(rent_date) as day,count(*) FROM rent_record GROUP BY day";
    break;
case 3:
	$sql="SELECT '�W��',count(*) as count FROM rent_record WHERE morning=true GROUP BY morning";
    break;
case 4:
	$sql="SELECT '�U��',count(*) as count FROM rent_record WHERE afternoon=true GROUP BY afternoon";
    break;
case 5:
	$sql="SELECT '�߶�',count(*) as count FROM rent_record WHERE evening=true GROUP BY evening";
    break;
case 6:
	$sql="SELECT borrower,count(*) as count FROM rent_record GROUP BY borrower";
    break;
case 7:
	$sql="SELECT rent_place,count(*) as count FROM rent_record GROUP BY rent_place";
	break;
case 8:
	$sql="SELECT borrower_type,count(*) as count FROM rent_record GROUP BY borrower_type";
	break;
case 9:
	$sql="SELECT '�޲z���@�O',sum(rent) as total FROM rent_record";
	break;
case 10:
	$sql="SELECT '���q�ɶK�O',sum(clean) as total FROM rent_record";
	break;
case 11:
	$sql="SELECT '�O�Ҫ�',sum(prove) as total FROM rent_record";
	break;
case 12:
	$sql="SELECT reply,count(*) as count FROM rent_record GROUP BY reply";
    break;
}

$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
//$data_arr=$res->getrows();

//echo "<pre>";
//print_r($data_arr);
//echo "</pre>";


$field_count=$res->FieldCount();
$data="<tr bgcolor='#FFAAAA'><td align='center'>�έp����</td><td align='center'>���B</td></tr>";
while(!$res->EOF)
{
	$data.="<tr>";
		for($i=0;$i<$field_count;$i++)
			$data.="<td align='center'>".$res->fields[$i]."</td>";
	$data.="</tr>";
	$res->MoveNext();
}


$main="<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#008DFF' width='70%'><form name='myform' method='post' action='$_SERVER[PHP_SELF]'>";
$main.=$year_seme_select.$purpose_select.$data;

$main.="</form></table>";
echo $main;

foot();
?>