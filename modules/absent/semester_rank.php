<?php

// $Id: stat_all.php 5310 2009-01-10 07:57:56Z hami $

/* ���o�]�w�� */
include_once "config.php";

sfs_check();
$year_seme=$_POST['year_seme']?$_POST['year_seme']:sprintf('%03d%d',curr_year(),curr_seme());

//�q�X����
head("���m�Ұ����I�ǥ�");

//�\����
print_menu($school_menu_p);

//�Ǧ~���
$class_seme_p = get_class_seme(); //�Ǧ~��	
$upstr = "���C�ܾǴ��G<select name=\"year_seme\" onchange=\"this.form.submit()\">\n";
while (list($tid,$tname)=each($class_seme_p)){
	if ($year_seme== $tid)
			$upstr .= "<option value=\"$tid\" selected>$tname</option>\n";
		else
			$upstr .= "<option value=\"$tid\">$tname</option>\n";
}
$upstr .= "</select>";

$kind_arr=stud_abs_kind();
$kind_radio='���Ƨǰ��O�G';
foreach($kind_arr as $key=>$value)
{
	$checked=($key==$_POST['kind_radio'])?'checked':'';
	$kind_radio.="<input type='radio' name='kind_radio' value='$key' $checked onchange=\"this.form.submit()\">$value ";	
}

//���������
if($_POST['kind_radio']){
	//����Ʀ�H�����
	$stud_arr=array();
	$id_list='';
	$sql="SELECT stud_id FROM stud_seme_abs WHERE seme_year_seme='$year_seme' AND abs_kind='{$_POST['kind_radio']}' ORDER BY abs_days DESC LIMIT $ranks";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
	while(!$res->EOF)
	{
		$stud_arr[]=$res->fields['stud_id'];	
		$id_list.="'{$res->fields['stud_id']}',";
		$res->MoveNext();
	}
	$id_list=substr($id_list,0,-1);
	$sql="SELECT a.*,b.student_sn,b.seme_class,b.seme_num FROM stud_seme_abs a INNER JOIN stud_seme b ON a.stud_id=b.stud_id WHERE a.seme_year_seme='$year_seme' AND b.seme_year_seme='$year_seme' AND b.stud_id in ($id_list)";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
	while(!$res->EOF)
	{
		$stud_id=$res->fields['stud_id'];
		$abs_kind=$res->fields['abs_kind']; 
		$abs_arr[$stud_id][$abs_kind]=$res->fields['abs_days'];
		$abs_arr[$stud_id]['student_sn']=$res->fields['student_sn'];
		$abs_arr[$stud_id]['seme_class']=$res->fields['seme_class'];
		$abs_arr[$stud_id]['seme_num']=$res->fields['seme_num'];
	
		$res->MoveNext();
	}

	$data="<table border='2' cellpadding='3' cellspacing='5' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1'>
			<tr bgcolor='#cccccc' align='center'><td>�Z��</td><td>�y��</td><td>�m�W</td><td>�Ǹ�</td>";
	foreach($kind_arr as $key=>$value){
		$bgcolor=($key==$_POST['kind_radio'])?'#ffffcc':'#cccccc';
		$comma=($key==$_POST['kind_radio'])?'��':'';
		$data.="<td bgcolor='$bgcolor'>$value $comma</td>";
	}
	$data.="</tr>";
	foreach($stud_arr as $stud_id){
		//����Z�ŻP�m�W
		$student_sn=$abs_arr[$stud_id]['student_sn'];
		$sql="SELECT stud_name,stud_sex FROM stud_base WHERE student_sn=$student_sn";
		$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
		$stud_name=$res->fields['stud_name'];
		$bgcolor=($res->fields['stud_sex']==1)?'#ddffdd':'#ffdddd';
		
		$data.="<tr align='center' bgcolor='$bgcolor'><td>{$abs_arr[$stud_id]['seme_class']}</td><td>{$abs_arr[$stud_id]['seme_num']}</td><td>$stud_name</td><td>$stud_id</td>";
		foreach($kind_arr as $key=>$value) $data.="<td>{$abs_arr[$stud_id][$key]}</td>";
		$data.="</tr>";
	}
	$data.="</table>";

}

echo "<form name='myform' method='post' action='$_SERVER[SCRIPT_NAME]'>$upstr<br>$kind_radio<br>$data</form>";

foot();

?>
