<?php
// $Id: hie.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";
include "my_fun.php";

sfs_check();

//�q�X����
head("���O�޲z");


//�Ǵ��O
$work_year_seme=$_REQUEST[work_year_seme];
if($work_year_seme=='') $work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());

$item_id=$_REQUEST[item_id];
//$stud_class=$_POST[stud_class];
$record_id=$_POST[record_id];

//���o�ثe�Z��id
//$class_data=explode('_',$stud_class);
//$class_id=$class_data[2]*100+$class_data[3];
//$grade+=$class_data[2];



// ���X�Z�ŦW�ٰ}�C
$class_base = class_base($work_year_seme);

//��V������
$linkstr="work_year_seme=$work_year_seme&item_id=$item_id";
echo print_menu($MENU_P,$linkstr);

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

if($item_id>0)
{

	//��ܯZ��
	//$class_list=get_class_select(curr_year(),curr_seme(),"","stud_class","this.form.submit",$stud_class);
	//$class_data=explode('_',$stud_class);
        //$class_id=$class_data[2]*100+$class_data[3];
	//$main.=$class_list;
	//if($stud_class<>'')
	//{
		//���o�w�}�C�Z�žǥͦC��
		$stud_select="select a.*,b.stud_name from charge_record a,stud_base b where item_id=$item_id AND a.student_sn=b.student_sn order by record_id";
		//$stud_select="SELECT student_sn,curr_class_num,stud_name FROM stud_base WHERE stud_study_cond=0 AND curr_class_num like '$class_id%' ORDER BY curr_class_num";
		$recordSet=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);
		//$studentdata="<select name='record_id' onchange='this.form.submit()'><option></option>";
		//while(!$recordSet->EOF)
		//{
		//	$is_selected=($record_id==$recordSet->fields[record_id]?" selected":"");
		//	$studentdata.="<option value='".$recordSet->fields[record_id]."'$is_selected>(".substr($recordSet->fields[curr_class_num],-2).")".$recordSet->fields[stud_name]."</option>";
		//	$recordSet->MoveNext();
		//}
		//$studentdata.="</select>";
		//$main.=$studentdata;

        
		//��ܯZ�žǥͪ������ڬ���
		//$sql_select="select a.*,b.stud_name from charge_record a,stud_base b where record_id like '$work_year_seme$class_id%' AND a.student_sn=b.student_sn order by record_id";
		//$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
		$recordSet->MoveFirst();
		$showdata="<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%'>
			<tr bgcolor='#CCFF99'>
			<td align='center'>NO.</td>
			<td align='center'>��ڸ��X</td>
			<td align='center'>�Z��</td>
			<td align='center'>�m�W</td>
			<td align='center'>�����`�B</td>
			<td align='center'>��K�B</td>
			<td align='center'>��ú�B</td>
			<td align='center'>�wú�B</td>
			<td align='center'>��ú��</td>
			<td align='center'>ú�ڤ��</td>
			<td align='center'>�Ƶ�</td>
			</tr>";
		//���o�U�~�Ŧ��O�C��έp���K���B  �۩w��Ʀb my-fun.php
		$grade_dollars=get_grade_charge($item_id);
		$decrease_dollars=get_charge_decrease($item_id);
		//echo "<PRE>";
		//print_r($grade_dollars);
		//echo "</PRE>";
		
		//echo "<PRE>";
		//print_r($decrease_dollars);
		//echo "</PRE>";
		$counter=0;
		while(!$recordSet->EOF) {
			$grade=substr($recordSet->fields[record_id],4,1);
			$class_id=substr($recordSet->fields[record_id],4,3);
			
			$item_total=array_sum($grade_dollars[$grade]);
			//echo $item_total;

			//echo "=== $grade ==> $class_id <BR>";
			
			$my_decrease=$decrease_dollars[$recordSet->fields[student_sn]][total];
			$my_should_paid=$item_total-$my_decrease;
			$left=$my_should_paid-($recordSet->fields[dollars]);
			if($left<>0){
				$counter+=1;
				if($left>0) $my_bgcolor="#FFFFFF"; else $my_bgcolor="#FFDDDD";
				//�C��
				$my_decrease=$decrease_dollars[$recordSet->fields[student_sn]][total];
				
				$showdata.="<tr bgcolor=$my_bgcolor><td align='center'>$counter</td>";
				$showdata.="<td align='center'>".$recordSet->fields[record_id]."</td>";
				$showdata.="<td align='center'>".$class_base[$class_id]."</td>";
				$showdata.="<td align='center'>".$recordSet->fields[stud_name]."</td>";
				$showdata.="<td align='center'>$item_total</td>";
				$showdata.="<td align='center'>$my_decrease</td>";
				$showdata.="<td align='center'>$my_should_paid</td>";			
				$showdata.="<td align='center'>".$recordSet->fields[dollars]."</td>";
				$showdata.="<td align='center'>$left</td>";
				$showdata.="<td align='center'>".$recordSet->fields[paid_date]."</td>";
				$showdata.="<td align='center'>".($left<0?"[����]":"").$recordSet->fields[comment]."</td>";
				$showdata.="</td></tr>";
			}
			$recordSet->MoveNext();
		}
	//}
}
$showdata.="</form></table>";

echo $main.$showdata;
foot();
?>