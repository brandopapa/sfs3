<?php
// $Id: list.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";
sfs_check();

$item_sn_array=$_POST[item_sn];

if($item_sn_array AND $_POST['act']=='�έp�C�L') {
	//���X�Z�žǥ�student_sn�C��
	$sql_sn="select student_sn,seme_class from stud_seme WHERE seme_year_seme='$curr_year_seme' order by seme_class";
	$res_sn=$CONN->Execute($sql_sn) or user_error("Ū�����ѡI<br>$sql_sn",256);
	while(! $res_sn->EOF) {
		$student_sn=$res_sn->fields[student_sn];
		$seme_class=$res_sn->fields[seme_class];
		
		$student_sn_array[$seme_class][student_sn_list].=$student_sn.',';
		$student_sn_array[$seme_class][student_sn_count]++;
		$res_sn->MoveNext();
	}
	
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
					<td align='center'>�Z�ŦW��</td>
					<td align='center'>�Z�ŤH��</td>
					<td align='center'>�q�L�H��</td>
					<td align='center'>��v</td>
					<td align='center'>�����o��</td>
					<td align='center'>�Ƶ�</td>
					</tr>";
		

		$sql="select * from authentication_subitem where item_sn=$item_sn order by code";
		$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
		while(!$res->EOF) {
			$subitem_sn=$res->fields[sn];
			$grades=$res->fields[grades];
			//���C���{�үZ��
			$sql_select="select * from school_class where year=".curr_year()." AND semester=".curr_seme()." AND (c_year IN ($grades)) order by class_id ";
			$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
			$class_info='';
			$class_count=$recordSet->RecordCount();
			while(!$recordSet->EOF) {
				$class_id=sprintf('%d%02d',$recordSet->fields[c_year],$recordSet->fields[c_sort]);
				$class_name=$class_base[$class_id];
				$student_sn_list='';
				$student_sn_count=$student_sn_array[$class_id][student_sn_count];
				$student_sn_list=substr($student_sn_array[$class_id][student_sn_list],0,-1);
				//���o�Z�Ťw�{�Ҳӥؤ��{�ҾǥͲM��
				$sql_count="select count(*) as counter,avg(score) as avg_score from authentication_record WHERE sub_item_sn=$subitem_sn AND student_sn IN ($student_sn_list)";
				$res_count=$CONN->Execute($sql_count) or user_error("Ū�����ѡI<br>$sql_count",256);
				$student_passed=$res_count->fields[counter];
				$avg_score=round($res_count->fields[avg_score],2);
				$passed_percent=round($student_passed/$student_sn_count,2)*100;
				$class_info="<td>$class_name</td><td>$student_sn_count</td><td>$student_passed</td><td>$passed_percent%</td><td>$avg_score</td>";
				if($recordSet->CurrentRow()) $showdata.="<tr align='center'>$class_info</tr>"; else {
					$showdata.="<tr bgcolor='#FFFFFF' align='center'><td rowspan=$class_count>".($res->CurrentRow()+1)."</td>
							<td rowspan=$class_count>{$res->fields[code]}</td>
							<td rowspan=$class_count>{$res->fields[title]}<br>({$res->fields[grades]})</td>
							$class_info
							<td rowspan=$class_count></td>
							</tr>";
				} 
				$recordSet->MoveNext();
			}
	
			
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
head("�Z�Ųέp");

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

$col=3; //�]�w�C�@�C��ܴX����

$main.="<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse;' bordercolor='#111111'>";
while(!$res->EOF) {
	if($res->currentrow() % $col==0) $main.="<tr bgcolor='#CCFFFF'>";
	$main.="<td><input type='checkbox' value='{$res->fields[sn]}' name='item_sn[]'>[{$room_kind_array[($res->fields[room_id])]}]-{$res->fields[nature]}-{$res->fields[code]}-{$res->fields[title]}</td>";
	if($res->currentrow() % $col==($col-1) or $res->EOF) $main.="</tr>";
	$res->MoveNext();
}
$main.="<tr><td colspan=$col align='center'><input type='button' name='all_item' value='����' onClick='javascript:tagall(1);'><input type='button' name='clear_item'  value='������' onClick='javascript:tagall(0);'> 
		�@�@�@<input type='checkbox' name='new_page' checked value=1>�۰ʸ��� <input type='submit' value='�έp�C�L' name='act'></td></tr></table>";

echo $main."</form>";
foot();
?>