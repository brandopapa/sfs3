<?php

include "config.php";
sfs_check();

//�q�X����
head("�ǲ߻{��-���س]�w");
//�Ǵ��O
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());
$work_year_seme =$_REQUEST[work_year_seme]?$_REQUEST[work_year_seme]:$curr_year_seme;
$item_sn=$_POST[item_sn];
$select_item=$_POST['select_item'];

//��V������
echo print_menu($MENU_P);

if($_POST['act']!='���@'){
	if($work_year_seme==$curr_year_seme)
	{
	//�N�t���ܼƿﶵ�ରcombobox
	$types="<select name='a_nature'><option>".str_replace(",","</option><option>",$m_arr['types'])."</option></select>";

		//�s�W����
		$added_data="<tr></tr><tr bgcolor='#FFCCCC'><td align='center'><img border=0 src='images/add.gif' alt='�}�C�s����'></td>";
		$added_data.="<td align='center'>$curr_year_seme</td>";
		$added_data.="<td align='center'>$types</td>";
		$added_data.="<td align='center'><input type='text' name='a_code' size=5></td>";
		$added_data.="<td align='center'><input type='text' name='a_title' size=60></td>";
		//$added_data.="<td align='center'><input type='text' name='a_description' size=20></td>";
		$added_data.="<td align='center'><input type='text' name='a_start_date' size=8></td>";
		$added_data.="<td align='center'><input type='text' name='a_end_date' size=8></td>";
		$added_data.="<td align='center' colspan=3><input type='submit' value='�s�W' name='act'><input type='reset' value='���s�]�w'></td></tr>";
		//�̷Ӯ榡�s�W����
		$added_data.="<tr bgcolor='#CFFCAA'><td align='center'><img border=0 src='images/batchadd.gif' alt='�榡�s�W���ػP�ӥ�'></td>";
		$added_data.="<td colspan=4><pre>�榡�G
	[���O]#[�N�X]#[�{�Ҷ���]#[�{�Ұ_�l���]#[�{�Ҳפ���]
	[�l�N��]#[�l���ئW��]#[�A�Φ~��]#[�n�I]
	[�l�N��]#[�l���ئW��]#[�A�Φ~��]#[�n�I]
		:
�d�ҡG
	�y��#VOC#�^���r1000#2010-12-10#2011-12-10
	L1#�Ʀr�g#1,2#1
	L2#��q�u��g#1,2#1
	L3#����g#3,4#1
	L4#���G�g#3,4#1
	L5#���~�g#5,6#1
	L6#�欰�g#5,6#1
	</PRE></td>";
		$added_data.="<td colspan=5><textarea rows=13 name='formatted' cols=43></textarea><BR><input type='submit' value='�̮榡�s�W' name='act'></td></tr><tr></tr>";
	}
}

if($_POST['act']=='�s�W'){
	$sql_select="INSERT INTO authentication_item(year_seme,code,nature,title,room_id,start_date,end_date,creater) values ('$work_year_seme','$_POST[a_code]','$_POST[a_nature]','$_POST[a_title]','$my_room_id','$_POST[a_start_date]','$_POST[a_end_date]','$my_sn')";
	$res=$CONN->Execute($sql_select) or user_error("�s�W���ѡI<br>$sql_select<br>���i��O�N�X���ƤF!",256);
};

if($_POST['act']=='��s'){
	$sql_select="UPDATE authentication_item SET year_seme='$work_year_seme',code='$_POST[code]',nature='$_POST[nature]',title='$_POST[title]',description='$_POST[description]',room_id='$_POST[room_kind_id]',start_date='$_POST[start_date]',end_date='$_POST[end_date]' WHERE sn=$item_sn;";
	$res=$CONN->Execute($sql_select) or user_error("�ק異�ѡI<br>$sql_select<br>���i��O�N�X���ƤF!",256);
	$_POST[item_sn]=0;
};

if($_POST['act']=='�R��'){
	//�R������
	$sql_select="delete from authentication_item where sn=$item_sn";
	$res=$CONN->Execute($sql_select) or user_error("�R�����إ��ѡI<br>$sql_select",256);
	/*
	//�R���ӥ�
	$sql_select="delete from authentication_subitem where item_sn=$item_sn";
	$res=$CONN->Execute($sql_select) or user_error("�R���ӥإ��ѡI<br>$sql_select",256);
	//�R������
	$sql_select="delete from authentication_item where item_id=$item_sn";
	$res=$CONN->Execute($sql_select) or user_error("�R���������ѡI<br>$sql_select",256);
	*/
};
if($_POST['act']=='�ƻs'){
	//�ƻs����
	$sql="INSERT INTO authentication_item SET year_seme='$work_year_seme',code='".substr(time(),-5)."',nature='{$_POST[nature]}',title='�ƻs-{$_POST[title]}',description='{$_POST[description]}',room_id='$my_room_id',start_date='{$_POST[start_date]}',end_date='{$_POST[end_date]}',creater=$my_sn;";
	$res=$CONN->Execute($sql) or user_error("�ƻs���إ��ѡI<br>$sql",256);
	$item_sn=$CONN->insert_id();
	
	//�ƻs�ӥ�
	$sql_select="select * from authentication_subitem where item_sn={$_POST[item_sn]} order by code;";
	$res=$CONN->Execute($sql_select) or user_error("Ū���ƻs���إ��ѡI<br>$sql_select",256);
	
	$batch_value="";
	while(!$res->EOF)
	{
		$code=$res->fields[code];
		$title=$res->fields[title];
		$grades=$res->fields[grades];
		$bonus=$res->fields[bonus];
		$batch_value.="($item_sn,'$code','$title','$grades',$bonus),";
		$res->MoveNext();
	}
	$batch_value=substr($batch_value,0,-1);
	$sql_select="INSERT INTO authentication_subitem(item_sn,code,title,grades,bonus) values $batch_value";
	$res=$CONN->Execute($sql_select) or user_error("�ƻs�ӥإ��ѡI<br>$sql_select",256);
	echo "<script language=\"Javascript\"> alert (\"���ػP�ӥؤw�ƻs�A���~��]�w���T�����إN�X�I\")</script>";
	$_POST[item_sn]=$item_sn;
};


if($_POST['act']=='�̮榡�s�W'){
	if($_POST['formatted']){
		//�N�榡�ର�}�C
		$formatted=explode("\r\n",$_POST['formatted']);
		//�}�C����
		$item_data=explode("#",$formatted[0]);
		$sql_select="INSERT INTO authentication_item(year_seme,nature,code,title,start_date,end_date,room_id,creater) values ('$work_year_seme','$item_data[0]','$item_data[1]','$item_data[2]','$item_data[3]','$item_data[4]','$my_room_id','$my_sn')";
		$res=$CONN->Execute($sql_select) or user_error("�}�C���إ��ѡI<br>$sql_select",256);
		$item_sn=$CONN->insert_id();
		array_shift($formatted);		
		
		//�}�C�ӥ�
		$batch_value="";
		foreach($formatted as $value)
		{
			if($value)
			{
				$value=explode("#",$value);
				$code=$value[0];
				$title=$value[1];
				$grades=$value[2];
				$bonus=$value[3];
				$batch_value.="($item_sn,'$code','$title','$grades',$bonus),";
			}
		}
		$batch_value=substr($batch_value,0,-1);
		$sql_select="INSERT INTO authentication_subitem(item_sn,code,title,grades,bonus) values $batch_value";
		$res=$CONN->Execute($sql_select) or user_error("�̮榡�s�W�ӥإ���<br>$sql_select",256);
		$work_year_seme=$curr_year_seme;
		echo "<script language=\"Javascript\"> alert (\"���ػP�ӥؤw�̮榡�}�C�I\")</script>";
		
		$_POST[item_sn]=$item_sn;
		
	}
};

$main="<form name='myform' method='post' action='$_SERVER[SCRIPT_NAME]'><input type='hidden' name='item_sn' value=$item_sn>
	����ܭ��w�G<input type='radio' value=0 ".($select_item==0?'checked':'')." name='select_item' onclick='this.form.submit()'>���� 
				<input type='radio' value=1 ".($select_item==1?'checked':'')." name='select_item' onclick='this.form.submit()'>�{�Ҥ� 
				<input type='radio' value=2 ".($select_item==2?'checked':'')." name='select_item' onclick='this.form.submit()'>����{�� 
				<input type='radio' value=3 ".($select_item==3?'checked':'')." name='select_item' onclick='this.form.submit()'>�ݱҥλ{��";
$filter='';
$item_color='#FFFFFF';
switch($select_item){
 case 1:
     $filter='WHERE CURDATE() BETWEEN start_date AND end_date'; $item_color='#CCFFFF'; 
  break;
 case 2:
     $filter='WHERE CURDATE()>end_date'; $item_color='#CCCCCC'; 
  break;
 case 3:
     $filter='WHERE CURDATE()<start_date'; $item_color='#FFCCCC'; 
  break;
}
 
		
//�C�X����
$sql_select="select * from authentication_item $filter order by code";
$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
//��ܫ��w�Ǵ����ظԲӸ��
$res->MoveFirst();
$showdata="<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%'>
	<tr>
	<td align='center' bgcolor='#CCFF99'>NO.</td>
	<td align='center' bgcolor='#CCFF99'>�Ǵ�</td>
	<td align='center' bgcolor='#CCFF99'>���O</td>
	<td align='center' bgcolor='#CCFF99'>�N�X</td>
	<td align='center' bgcolor='#CCFF99'>�{�Ҷ���</td>
	<td align='center' bgcolor='#CCFF99' colspan=2>�{�Ҵ���</td>
	<td align='center' bgcolor='#CCFF99'>�޲z�B��</td>
	<td align='center' bgcolor='#CCFF99'>�}�C��</td>
	<td align='center' bgcolor='#CCFF99'>--</td>
	</tr>";
	while(!$res->EOF) {
		if($_POST[item_sn]==$res->fields[sn]){
			//���ͳB�ǿ��
			$room_kind_select="<select name='room_kind_id'>";
			foreach($room_kind_array as $key=>$value) {
				if($key==$res->fields[room_id]) $selected='selected'; else $selected='';
				$room_kind_select.="<option value=$key $selected>$value</option>";
			}
			$room_kind_select.="</select>";
			
			$authority=explode(',',$m_arr['authority']);
			foreach($authority as $value){
				$authority_ref.="<option>$value</option>";
			}
			$authority_ref="<select name='authority_ref' onchange='this.form.authority.value=this.options[this.selectedIndex].text'><option></option>$authority_ref</select>";

			$showdata.="<tr bgcolor='#FFFAAA'><td align='center'>".($res->CurrentRow()+1)."</td>";
			$showdata.="<td align='center'>".$res->fields[year_seme]."</td>";
			$showdata.="<td align='center'><input type='text' name='nature' size=10 value={$res->fields[nature]}></td>";		
			$showdata.="<td align='center'><input type='text' name='code' size=5 value={$res->fields[code]}></td>";
			$showdata.="<td><input type='text' name='title' size=60 value={$res->fields[title]}></td>";
			//$showdata.="<td>".$res->fields[description]."</td>";
			$showdata.="<td align='center'><input type='text' name='start_date' size=10 value='{$res->fields[start_date]}'></td>";
			$showdata.="<td align='center'><input type='text' name='end_date' size=10 value='{$res->fields[end_date]}'></td>";		
			$showdata.="<td align='center'>$room_kind_select</td>";
			//$showdata.="<td align='center'>{$res->fields[creater]}</td>";
			//$showdata.="<td align='center'><input type='text' name='creater' size=10 value='{$res->fields[creater]}'></td>";
			$showdata.="<td align='center' colspan=2>";
			if($my_room_id==$res->fields['room_id']) $showdata.="<input type='submit' value='��s' name='act' onclick='return confirm(\"�T�w�n��s[{$res->fields[code]}-{$res->fields[title]}]?\")'><input type='submit' value='�R��' name='act' onclick='return confirm(\"�u���n�R��[{$res->fields[code]}-{$res->fields[title]}]?\")'>";
			$showdata.="<input type='submit' value='�ƻs' name='act' onclick='return confirm(\"�T�w�n�ƻs[".$res->fields[title]."]�ܥ��Ǧ~?\")'>�@</td></tr>";
		} else {	
			$item_sn=$res->fields[sn];
			$showdata.="<tr bgcolor=$item_color><td align='center'>".($res->CurrentRow()+1)."</td>";
			$showdata.="<td align='center'>".$res->fields[year_seme]."</td>";
			$showdata.="<td align='center'>".$res->fields[nature]."</td>";		
			$showdata.="<td align='center'>".$res->fields[code]."</td>";
			$showdata.="<td>".$res->fields[title]."</td>";
			$showdata.="<td align='center'>".$res->fields[start_date]."</td>";
			$showdata.="<td align='center'>".$res->fields[end_date]."</td>";
			
			$showdata.="<td align='center'>".$room_kind_array[($res->fields[room_id])]."</td>";
			$showdata.="<td align='center'>".$teacher_array[($res->fields[creater])]."</td>";
			$showdata.="<td align='center'><input type='button' name='act' value='���@' onclick='this.form.item_sn.value=\"$item_sn\"; this.form.submit();'></td>";
			$showdata.="</tr>";
		}
		$res->MoveNext();
	}

echo $main.$showdata.$added_data."</form></table>";
foot();

?>