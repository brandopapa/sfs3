<?php

// $Id: $

include "config.php";

sfs_check();

//����i�Φ~��
$sql_select="SELECT DISTINCT LEFT(class_id,5) AS semester FROM cita_data ORDER BY semester DESC";
$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
while(!$res->EOF) {
	$value=$res->fields[0];
	$this_semester=str_replace("_", "�Ǧ~�ײ�",$value)."�Ǵ�";
	$semester_select.="<input type='checkbox' name='semester[]' value='$value'>$this_semester<br>";
	$res->MoveNext();
}


//���͸s��radio
$group_array=array(1=>'����',2=>'�~��',3=>'�Z��');
$_POST[mode]=$_POST[mode]?$_POST[mode]:3;
foreach($group_array as $key=>$value){
	$checked=$_POST[mode]==$key?' checked':'';
	$group_radio.="<input type='radio' name='mode' value=$key $checked>$value<br>";
}

//�ƧǼ�
$_POST[rank_list]=$_POST[rank_list]?$_POST[rank_list]:$rank_list;


//�}�l����O���B�p��n��
if($_POST[go]=='�����έp�C��'){
	if($_POST[semester]){
		$calss_name=class_base();
		$student_data=array();
		$student_bonus=array();
		foreach($_POST[semester] as $key=>$value){
			$semester_list.="$value,";
			//���stud_seme�ǥͦW��
			$sql_select="SELECT a.stud_id,a.kind,a.data_get,a.bonus,b.kind_set,b.bonus_set FROM cita_data a inner join cita_kind b on a.kind=b.id WHERE order_pos>-1 and a.class_id like '$value%' ORDER BY class_id";
			$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
			while(!$res->EOF) {
				$stud_id=$res->fields[stud_id];
				$kind_id=$res->fields[kind];
				$data_get=$res->fields[data_get];
				//������ͥثe�NŪ���~��(�w�g���F�N���A�d��)
				if(!$student_data[$stud_id][stud_name]){
					$seme_year_seme=sprintf('%03d%d',curr_year(),curr_seme());
					$sql="SELECT a.seme_class,a.seme_num,a.student_sn,b.stud_name FROM stud_seme a inner join stud_base b on a.student_sn=b.student_sn WHERE a.seme_year_seme='$seme_year_seme' and a.stud_id='$stud_id'";
					$res2=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
					$student_data[$stud_id][student_sn]=$res2->fields[student_sn];
					$student_data[$stud_id][seme_class]=$res2->fields[seme_class];
					$student_data[$stud_id][seme_num]=$res2->fields[seme_num];
					$student_data[$stud_id][stud_name]=$res2->fields[stud_name];
				}
				if($student_data[$stud_id][stud_name])
				//�]���n�K�Q�Ƨ�  �ҥH�o�i��Ҧ��P�_
				switch($_POST[mode]){
					case 1:
						if($bonus_mode) $student_bonus[$stud_id]+=$res->fields[bonus]; else {
							$kind_set_arr=explode(',',$res->fields[kind_set]);
							$bonus_set_arr=explode(',',$res->fields[bonus_set]);
							$kind_key=array_search($data_get,$kind_set_arr);
							$student_bonus[$stud_id]+=$bonus_set_arr[$kind_key];
						}
						break;
					case 2:
						$grade=substr($student_data[$stud_id][seme_class],0,-2);
						if($grade) {
							if($bonus_mode) $student_bonus[$grade][$stud_id]+=$res->fields[bonus]; else {
							$kind_set_arr=explode(',',$res->fields[kind_set]);
							$bonus_set_arr=explode(',',$res->fields[bonus_set]);
							$kind_key=array_search($data_get,$kind_set_arr);
							$student_bonus[$grade][$stud_id]+=$bonus_set_arr[$kind_key];
							}
						}
						break;
					case 3:
						$seme_class=$student_data[$stud_id][seme_class];
						if($seme_class) {
							if($bonus_mode) $student_bonus[$seme_class][$stud_id]+=$res->fields[bonus]; else {
							$kind_set_arr=explode(',',$res->fields[kind_set]);
							$bonus_set_arr=explode(',',$res->fields[bonus_set]);
							$kind_key=array_search($data_get,$kind_set_arr);
							$student_bonus[$seme_class][$stud_id]+=$bonus_set_arr[$kind_key];
							}							
						}						
						break;
				}
				$res->MoveNext();
			}
		}
		$semester_list=substr($semester_list,0,-1);
		$semester_list=str_replace('_','',$semester_list);
		
		//������D
		$title="<center><font size=5>{$school_long_name}{$_POST[title]}</font><br><br>���έp�Ǵ��G $semester_list</center>";
		
		//�έp�W���H��
		$rank_count=array();

		//�i��ƧǻP�C��
		switch($_POST[mode]){
			case 1:
				arsort($student_bonus);
				$rank=0;
				$rank_dup=0;
				$bonus=-1;
				$main="$title<br><table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%'>
						<tr align='center' bgcolor='#FFCCCC'><td>�W��</td><td>�Z��</td><td>�y��</td><td>�Ǹ�</td><td>�m�W</td><td>�a�A�n��</td><td> �ơ@�@�@�@�� </td></tr>";
				foreach($student_bonus as $key=>$value){
					if($value){
						if($bonus==$value) $rank_dup++; else { $rank+=$rank_dup+1; $bonus=$value; $rank_dup=0;}
						if($rank<=$_POST[rank_list]){
							$main.="<tr align='center'><td>$rank</td><td>{$calss_name[$student_data[$key][seme_class]]}</td><td>{$student_data[$key][seme_num]}</td><td>$key</td><td>{$student_data[$key][stud_name]}</td><td>$value</td><td></td></tr>";
							$rank_count[$rank]++;
						}
					}
				}
				$main.="</table>";
				echo $main;
				break;
			case 2:
				ksort($student_bonus);
				echo $title;
				foreach($student_bonus as $grade=>$grade_data){
					arsort($grade_data);
					$rank=0;
					$rank_dup=0;
					$bonus=-1;
					$main="<br>��{$class_name_kind_1[$grade]}�~��<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%'>
							<tr align='center' bgcolor='#FFCCCC'><td>�W��</td><td>�Z��</td><td>�y��</td><td>�Ǹ�</td><td>�m�W</td><td>�a�A�n��</td><td> �ơ@�@�@�@�� </td></tr>";
					foreach($grade_data as $key=>$value){
						if($value){
							if($bonus==$value) $rank_dup++; else { $rank+=$rank_dup+1; $bonus=$value; $rank_dup=0;}
							if($rank<=$_POST[rank_list]){
								$main.="<tr align='center'><td>$rank</td><td>{$calss_name[$student_data[$key][seme_class]]}</td><td>{$student_data[$key][seme_num]}</td><td>$key</td><td>{$student_data[$key][stud_name]}</td><td>$value</td><td></td></tr>";
								$rank_count[$rank]++;
							}
						}
					}
					$main.="</table>";
					echo $main;
				}
				break;
			case 3:
				ksort($student_bonus);
				echo $title;
				foreach($student_bonus as $class_id=>$class_data){
					arsort($class_data);
					$rank=0;
					$rank_dup=0;
					$bonus=-1;
					$main="<br>���Z�šG{$calss_name[$class_id]}<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%'>
							<tr align='center' bgcolor='#FFCCCC'><td>�W��</td><td>�Z��</td><td>�y��</td><td>�Ǹ�</td><td>�m�W</td><td>�a�A�n��</td><td> �ơ@�@�@�@�� </td></tr>";
					foreach($class_data as $key=>$value){
						if($value){
							if($bonus==$value) $rank_dup++; else { $rank+=$rank_dup+1; $bonus=$value; $rank_dup=0;}
							if($rank<=$_POST[rank_list]){
								$main.="<tr align='center'><td>$rank</td><td>$calss_name[$class_id]</td><td>{$student_data[$key][seme_num]}</td><td>$key</td><td>{$student_data[$key][stud_name]}</td><td>$value</td><td></td></tr>";
								$rank_count[$rank]++;
							}
						}
					}
					$main.="</table>";
					echo $main;
				}
				break;
		}
		//�C���έp��
		ksort($rank_count);
		foreach($rank_count as $key=>$count){
			$rank_row.="<td>$key</td>";
			$rank_sum.="<td>$count</td>";
			$total+=$count;
		}

		echo "<br><table border=2 cellpadding=7 cellspacing=0 style='border-collapse: collapse' bordercolor='#111111' width='100%'>
			<tr align='center' bgcolor='#CCFFCC'><td>�W��</td>$rank_row<td>�X�p</td></tr>
			<tr align='center'><td bgcolor='#CCFFCC'>�H��</td>$rank_sum<td bgcolor='#CCFFCC'>$total</td></tr></table>";
		
		exit;
	}
}

  
head("�a�A�n���Ʀ�]") ;
print_menu($menu_p);

echo <<<HERE
<script>
function tagall(status) {
  var i =0;

  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].name=='semester[]') {
      document.myform.elements[i].checked=status;
    }
    i++;
  }
}
</script>
HERE;


$main="<form name='myform' method='post' action='$_SERVER[SCRIPT_NAME]' target='_BLANK'>
<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111'>
<tr bgcolor='#CCFFCC' align='center'><td><input type='checkbox' name='select_all' onClick='javascript:tagall(this.checked);'>�Ǵ����</td>
<td>�s�ը̾�</td>
<td>�Ʀ�H��</td>
</tr>
<tr align='center' valign='top'><td width=180>$semester_select</td><td>$group_radio</td><td><input type='text' name='rank_list' size=3 value='{$_POST[rank_list]}'></td></tr>
<tr align='center'><td colspan=3>���D�G<input type='text' name='title' value='$title_default'><input type='submit' name='go' value='�����έp�C��'></td></tr>
</table></form>";

echo $main;

foot();
?>
