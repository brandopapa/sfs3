<?php

// $Id: memo_summary.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";

sfs_check();

//�q�X����
head("���\�N���լd");

//��V������
echo print_menu($MENU_P);

if(checkid($_SERVER['SCRIPT_FILENAME'],1))
{
//�έp�����
$s_date=$_POST[s_date];
if(!$s_date) $s_date=date("Y-m-d");
$e_date=$_POST[e_date];
if(!$e_date) $e_date=date("Y-m-d");

$date_period="����϶��G<input type='text' name='s_date' value='$s_date' size=8>~<input type='text' name='e_date' value='$e_date' size=8><input type='submit' value='�C��'>";

//�Ǵ��O
$work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
//���X�Z�ŦW�ٰ}�C
$class_base = class_base($work_year_seme);
$unsigned=$class_base;

//�ƧǤ覡
$sort_method=$_POST[sort_method];
$method_arr=array('�Z��'=>'class_id','�D�ƭ�����'=>'item,class_id','��r�N��'=>'memo');
if(!$sort_method) $sort_method=$method_arr[�Z��];
$sort_method_radio="�ƧǡG";
foreach($method_arr as $key=>$value)
{
	$sort_method_radio.="<input type='radio' value='$value' name='sort_method'".($sort_method==$value?' checked':'')." onclick='this.form.submit()'>$key ";
}
$title='<h2><center>['.$s_date.($s_date==$e_date?'':']~['.$e_date).']'.array_search($sort_method,$method_arr).'��r�N���׾�</center></h2>';
$main="<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%'><form name='form_day' method='post' action='$_SERVER[PHP_SELF]'>
	$date_period �@ $sort_method_radio<BR><BR>$title";

$showdata="<tr>
	<td align='center' bgcolor='#CCFF99'>���</td>	
	<td align='center' bgcolor='#CCFF99'>�Z��</td>
	<td align='center' bgcolor='#CCFF99'>�D�ƭ��W��</td>
	<td align='center' bgcolor='#CCFF99'>��r�N��</td>
	<td align='center' bgcolor='#CCFF99'>�Ƶ�</td>
	</tr>";
	
	//����϶��w�����r�N�����
	$sql="select *,WEEKDAY(pdate) as pMday from lunch_feedback where memo<>'' AND (pDate between '$s_date' AND '$e_date') ORDER BY $sort_method";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
	while(!$res->EOF)
	{
		if($res->fields[item])
		{
			$showdata.="<tr bgcolor=#FFFFDD><td align='center'>".$res->fields[pdate]."(".$c_day[$res->fields[pMday]+1].")</td>";
			$showdata.="<td align='center'>".$class_base[$res->fields[class_id]]."</td>";
			$showdata.="<td align='center'>".$res->fields[item]."</td>";
			$showdata.="<td width='30%'>".$res->fields[memo]."</td>";
			$showdata.="<td width='20%'></td></td></tr>";
		}
		$res->MoveNext();
	}
	
$showdata.="</form></table>";

echo $main.$showdata;

} else echo "�z�ëD�Ҳպ޲z��, �L�k�[���έp��T!!";

foot();

?>