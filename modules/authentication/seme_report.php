<?php
// $Id: list.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";
sfs_check();

$item_sn_array=$_POST[item_sn];

if($item_sn_array AND $_POST['act']=='�έp�C�L') {
	//���X���ظ��
	$item_count=count($item_sn_array);
	foreach($item_sn_array as $key=>$item_sn){
		//�C�X����
		$sql_select="select * from authentication_item where sn=$item_sn";
		$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
		$showdata="<br><font size=5>(NO.".($key+1).") #{$res->fields[sn]} {$res->fields[title]}</font>";
		$showdata.="<table border=2 cellpadding=6 cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%'>
					<tr bgcolor='#CCFF99'>
					<td align='center' >�޲z�B��</td>
					<td align='center'>�}�C�Ǵ�</td>
					<td align='center'>���O</td>
					<td align='center'>���ؽX</td>
					<td align='center'>�{�Ҵ���</td>					
					<td align='center'>�}�C��</td>
					</tr>";
		$showdata.="<tr bgcolor=$item_color><td align='center'>{$room_kind_array[($res->fields[room_id])]}</td>
					<td align='center'>{$res->fields[year_seme]}</td>
					<td align='center'>{$res->fields[nature]}</td>		
					<td align='center'>{$res->fields[code]}</td>
					<td align='center'>{$res->fields[start_date]}~{$res->fields[end_date]}</td>
					<td align='center'>{$teacher_array[($res->fields[creater])]}</td></tr></table>";
					
		//��ܲӥػP�έp��T
		$showdata.="<br><table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%'>
					<tr bgcolor='#AACCFF'>
					<td align='center'>NO</td>
					<td align='center'>�ӥؽX</td>
					<td align='center'>�ӥئW��</td>	
					<td align='center'>�A�Φ~��</td>
					<td align='center'>�o�I��</td>
					<td align='center'>�Ǵ��{�ұ���</td>
					<td align='center'>�Ƶ�</td>
					</tr>";
		
		$sql="select * from authentication_subitem where item_sn=$item_sn order by code";
		$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
		while(!$res->EOF) {
			$subitem_sn=$res->fields[sn];
			//�έp�Ǵ��{�ҤH��
			$semester_info='';
			$sql_count="select year_seme,count(*) as counter,avg(score) as score from authentication_record where sub_item_sn=$subitem_sn group by year_seme";
			$res_count=$CONN->Execute($sql_count) or user_error("�έp���ѡI<br>$sql_count",256);
			while(!$res_count->EOF) {

				$semester_info.="<li>[{$res_count->fields[year_seme]}]�{�� ".sprintf("%5d",$res_count->fields[counter])."�H�A�������� {$res_count->fields[score]}�C</li>";
				$res_count->MoveNext();
			}
			$showdata.="<tr bgcolor='#FFFFFF'><td align='center'>".($res->CurrentRow()+1)."</td>
						<td align='center'>{$res->fields[code]}</td>
						<td>{$res->fields[title]}</td>
						<td align='center'>{$res->fields[grades]}</td>
						<td align='center'>{$res->fields[bonus]}</td>
						<td align='center'>$semester_info</td>
						<td align='center'></td>
						</tr>";
			$res->MoveNext();
		}
		$showdata.="</table>";
				
		//����
		if($_POST[new_page]) {
			$key++;
			if($key<$item_count) $showdata.="<P style='page-break-after:always'></P>"; else $showdata.="<br>";
		}
		echo $showdata;	
	}
	exit; 
}

//�q�X����
head("�Ǵ��έp");

echo <<<HERE
<script>
function tagall(status) {
  var i =0;

  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].name=='item_sn[]') {
      document.myform.elements[i].checked=status;
    }
    i++;
  }
}
</script>
HERE;

//��V������
echo print_menu($MENU_P);

//���o�{�Ҥ����ت��U�Կ��
$main="<form name='myform' method='post' action='$_SERVER[SCRIPT_NAME]' target='_BLANK'>";
$sql_select="select * from authentication_item WHERE CURDATE() BETWEEN start_date AND end_date order by room_id,code";
$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);

$col=3; //�]�w�C�@�C��ܴX�H

$main.="<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse;' bordercolor='#111111'>";
while(!$res->EOF) {
	if($res->currentrow() % $col==0) $main.="<tr bgcolor='#FFCCFF'>";
	$main.="<td><input type='checkbox' value='{$res->fields[sn]}' name='item_sn[]'>[{$room_kind_array[($res->fields[room_id])]}]-{$res->fields[nature]}-{$res->fields[code]}-{$res->fields[title]}</td>";
	if($res->currentrow() % $col==($col-1) or $res->EOF) $main.="</tr>";
	$res->MoveNext();
}
$main.="<tr><td colspan=$col align='center'><input type='button' name='all_item' value='����' onClick='javascript:tagall(1);'><input type='button' name='clear_item'  value='������' onClick='javascript:tagall(0);'> 
		�@�@�@<input type='checkbox' name='new_page' checked value=1>�۰ʸ��� <input type='submit' value='�έp�C�L' name='act'></td></tr></table>";

echo $main."</form>";
foot();
?>