<?php

include "config.php";

sfs_check();


if($_POST['act']=='�M��������w���v�W��'){
	$sn_list='';
	foreach($_POST[empowered_selected] as $sn) $sn_list.="$sn,";
	if($sn_list){
		$sn_list=substr($sn_list,0,-1);
		$sql="DELETE FROM authentication_empower WHERE sn IN ($sn_list)";
		$res=$CONN->Execute($sql) or user_error("�R���{�ұ��v���ѡI<br>$sql",256);		
	}
}

if($_POST['act']=='�g�J���v'){
	$empowered=$_POST['empowered'];
	$batch_value="";
	foreach($empowered as $subitem_sn=>$empowered_sn)
	{
		if($empowered_sn) $batch_value.="('$curr_year_seme','$subitem_sn','$my_class_id','$my_sn','$empowered_sn',now()),";
	}
	$batch_value=substr($batch_value,0,-1);
	
	$sql_select="INSERT INTO authentication_empower(year_seme,subitem_sn,class_id,teacher_sn,empowered_sn,empowered_date) values $batch_value";
	$res=$CONN->Execute($sql_select) or user_error("ñ�{���ѡI<br>$sql_select",256);

};

//�q�X����
head("�ǲ߻{�ұ��v");

echo <<<HERE
<script>
function tagall(status) {
  var i =0;

  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].name=='empowered_selected[]') {
      document.myform.elements[i].checked=status;
    }
    i++;
  }
}
</script>
HERE;

//��V������
echo print_menu($MENU_P);
if($my_class_id){   //�P�w�O�_���Z�žɮv
	//���o�{�Ҥ����ت��U�Կ��A�P�_�O�_���Z�����{�Ҳӥ�
	$main="<form name='myform' method='post' action='$_SERVER[SCRIPT_NAME]'>
			<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse;' bordercolor='#111111' width='100%'>
			<tr align='center' bgcolor='#FAFCAA'><td colspan=6><B>$class_base[$my_class_id]</B></td><td colspan=2><input type='submit' name='act' value='�M��������w���v�W��' onclick='return confirm(\"�T�w�n�M����w�����v?\")'></td></tr>
			<tr align='center' bgcolor='#FFCCCC'><td>�޲z�B��</td><td>�{�Ҷ���</td><td>�{�Ҥ��</td><td>�ӥ�</td><td>�~��</td><td>�n��</td>
			<td><input type='checkbox' name='tag' onclick='javascript:tagall(this.checked);'>�w���v�W��</td>
			<td><input type='submit' name='act' value='�g�J���v'></td></tr>";
	$sql_select="select * from authentication_item WHERE CURDATE() BETWEEN start_date AND end_date order by code";
	$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while(!$res->EOF) {
		//����ӥؤ����L���ЯZ�Ū��~��
		$item_sn=$res->fields[sn];
		$sql_subitem="select * from authentication_subitem WHERE item_sn=$item_sn ORDER BY code";
		$res_subitem=$CONN->Execute($sql_subitem) or user_error("Ū�����ѡI<br>$sql_subitem",256);
		$room_id=$res->fields[room_id];
		while(!$res_subitem->EOF) {

			$subitem_sn=$res_subitem->fields[sn];
			$grade_array=explode(',',$res_subitem->fields[grades]);
			$teacher_select="<select name='empowered[$subitem_sn]'><option value=''></option>$teacher_option</select>";
			if(in_array($my_class_grade,$grade_array)) {
				//���o���Z�ť��ӥؤw���v���
				$teacher_data='';
				$sql_empower="select * from authentication_empower WHERE subitem_sn=$subitem_sn AND class_id='$my_class_id'";
				$res_empower=$CONN->Execute($sql_empower) or user_error("Ū�����ѡI<br>$sql_empower",256);
				while(!$res_empower->EOF) {
					//�h�����ӥؤw���v�Юv�W��
					$empowered_sn=$res_empower->fields[empowered_sn];
					$empowered_name=$teacher_array[$empowered_sn];
					$empowered_list="<option value=$empowered_sn> $empowered_name </option>";
					$teacher_select=str_replace($empowered_list,"",$teacher_select);
					
					//��ܤw���v�Юv�m�W
					$teacher_data.="<input type='checkbox' name='empowered_selected[]' value='{$res_empower->fields[sn]}'>$empowered_name";
					$teacher_data.="<BR>";
					$res_empower->MoveNext();				
				}
				$teacher_data=substr($teacher_data,0,-4);
				$teacher_data=$teacher_data?$teacher_data:"--";
				$main.="<tr align='center'><td>$room_kind_array[$room_id]</td><td>{$res->fields[sn]}-{$res->fields[nature]}-{$res->fields[code]}-{$res->fields[title]}</td><td>{$res->fields[start_date]} ~ {$res->fields[end_date]}</td><td>{$res_subitem->fields[code]}-{$res_subitem->fields[title]}</td>
						<td>{$res_subitem->fields[grades]}</td><td>{$res_subitem->fields[bonus]}</td><td>$teacher_data</td><td>$teacher_select</td></tr>";
			}
			$res_subitem->MoveNext();
		}	
		$res->MoveNext();
	}
	$main.="</table></form>";

	echo $main;
} else {
	$main="<form name='myform' method='post' action='./authentication.php'>
			<input type='hidden' name='item_sn' value=''><input type='hidden' name='curr_class_id' value=''><input type='hidden' name='sn' value=''>
			<li>�z�D�Z�žɮv�A�U����ܳQ���v����T~~~~</li>";
	$sql_empowered="select a.*,b.* from authentication_empower a INNER JOIN authentication_subitem b ON a.subitem_sn=b.sn WHERE a.empowered_sn=$my_sn AND a.year_seme='$curr_year_seme' ORDER BY class_id,code";
	$res_empowered=$CONN->Execute($sql_empowered) or user_error("Ū�����ѡI<br>$sql_empowered",256);
	if($res_empowered->recordcount()){
		//���o�{�Ҷ��ذ}�C
		$item_array=array();
		$sql="select * from authentication_item";
		$res_item=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
		while(!$res_item->EOF){
			$sn=$res_item->fields[sn];
			$item_array[$sn][code]=$res_item->fields[code];
			$item_array[$sn][title]=$res_item->fields[title];
			$item_array[$sn][nature]=$res_item->fields[nature];
			$item_array[$sn][room_id]=$res_item->fields[room_id];
			
			$res_item->MoveNext();
		}
		//���o�{�Ҥ����ت��U�Կ��A�P�_�O�_���Z�����{�Ҳӥ�
		$main.="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse;' bordercolor='#111111' width='100%'>
				<tr align='center' bgcolor='#FFCCCC'><td>�Z��</td><td>�{�Ҷ���</td><td>�ʧ@</td><td>����v�ɮv</td><td>���v���</td><td>�A�Φ~��</td><td>�n��</td></tr>";
		while(!$res_empowered->EOF) {
			$item_sn=$res_empowered->fields[item_sn];
			$subitem_sn=$res_empowered->fields[subitem_sn];
			$class_id=$res_empowered->fields[class_id];
			$item_data=$item_array[$item_sn][nature].'-'.$item_array[$item_sn][title];
			$class_name=$class_base[$class_id];
			$teacher_name=$teacher_array[$res_empowered->fields[teacher_sn]];
			$auth_submit=" <input type='button' name='act' value='�i��{��' onclick=\"this.form.item_sn.value=$item_sn; this.form.sn.value=$subitem_sn; this.form.curr_class_id.value='$class_id'; this.form.submit();\"";
		
			$main.="<tr align='center'><td>$class_name</td><td>$item_data �� {$res_empowered->fields[code]}-{$res_empowered->fields[title]}</td><td>$auth_submit</td><td>$teacher_name</td><td>{$res_empowered->fields[empowered_date]}</td><td>{$res_empowered->fields[grades]}</td><td>{$res_empowered->fields[bonus]}</td></tr>";	
			$res_empowered->MoveNext();
		}
		$main.="</table>";
	} else $main.="<li>~~���o�{���Ǵ��Q���v�{�Ҫ���T�I</li></form>";
	echo $main;
}
foot();
?>