<?php
// $Id: list.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";
include "my_fun.php";

sfs_check();

//�q�X����
head("���O�޲z");

print_menu($menu_p);
echo <<<HERE
<script>
function tagall(status) {
  var i =0;

  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].name=='selected_stud[]') {
      document.myform.elements[i].checked=status;
    }
    i++;
  }
}
</script>
HERE;



//�Ǵ��O
$work_year_seme=$_REQUEST[work_year_seme];
if($work_year_seme=='') $work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());

$item_id=$_REQUEST[item_id];
$stud_class=$_POST[stud_class];
$selected_stud=$_POST[selected_stud];
$detail_id=$_POST[detail_id];
$pay=$_POST[pay];
$decrease_dollars=$_POST[decrease_dollars];
$cause=$_POST[cause];


//print_r($selected_stud);


//���o�ثe�Z��id
$class_data=explode('_',$stud_class);
$class_id=$class_data[2]*100+$class_data[3];
$grade+=$class_data[2];

// ���X�Z�ŦW�ٰ}�C
$class_base = class_base($work_year_seme);



//��V������
$linkstr="work_year_seme=$work_year_seme&item_id=$item_id";
echo print_menu($MENU_P,$linkstr);

// $_SESSION[session_tea_name]  ���o�Юv�m�W

if($selected_stud AND $_POST['act']=='�T�w��K'){
	if($decrease_dollars AND $detail_id AND $selected_stud)
	{
		//�p��ʤ���
		$percent=$decrease_dollars/$pay*100;
		//�����ܪ��Z�žǥ�
		$batch_value="";
		foreach($selected_stud as $stud_datas)
		{
			$stud_data=explode(',',$stud_datas);
			$sn=$stud_data[0];
			$class_num=$stud_data[1];
	
			$batch_value.="('$detail_id',$sn,'$class_num',$percent,'$cause'),";
		}
		$batch_value=substr($batch_value,0,-1);
		//echo "===================<BR>$batch_value<BR>===================";
		
		$sql_select="REPLACE INTO charge_decrease(detail_id,student_sn,curr_class_num,percent,cause) values $batch_value";
		$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	} else echo "<script language=\"Javascript\"> alert (\"��T����, �L�k�����O�妸�s�W�I\")</script>";
};



if($_POST['act']=='�M�ť��Z�Ŧ����ش�K�W��'){
	$sql_select="delete from charge_decrease where detail_id=$detail_id AND curr_class_num like '$class_id%'";
	$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
};


//���o�~�׻P�Ǵ����U�Կ��
$seme_list=get_class_seme();
$main="<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#AAAAAA' width='100%'><form name='myform' method='post' action='$_SERVER[PHP_SELF]'>
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
	$class_list=get_class_select(curr_year(),curr_seme(),"","stud_class","this.form.submit",$stud_class);
	$class_data=explode('_',$stud_class);
	$class_id=$class_data[2]*100+$class_data[3];
	$curr_grade=substr($class_id,0,1)-1;
	$main.=$class_list;

	if($stud_class<>'')
	{
	
		//��ܫ��w���ظԲӸ��
		$sql_select="select * from charge_detail where item_id='$item_id' order by detail_sort";
		$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
		$main.="<select name='detail_id' onchange='this.form.submit()'><option></option>";
		while(!$res->EOF) {
			//���o�U�Ǧ~�����O���B
			$selected="";
			if($detail_id==$res->fields[detail_id])
			{
				$selected="selected";
				$grade_dollar=explode(',',$res->fields[dollars]);
				//print_r($grade_dollar);
			}
			$main.="<option $selected value=".$res->fields[detail_id].">".$res->fields[detail]."</option>";
			$res->MoveNext();
		}
		$dollars=$grade_dollar[$curr_grade];
		$main.="</select>";

		if($detail_id)
		{
			//���o�e�w�}�C"��K�����ǥ͸��
			$sql_select="select * from charge_decrease where detail_id=$detail_id AND curr_class_num like '$class_id%' order by curr_class_num";

			$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
			
			$listed=array();
			while(!$recordSet->EOF)
			{
				$listed[$recordSet->fields[student_sn]]=$recordSet->fields[percent];
				$recordSet->MoveNext();
			}

			
			//���ostud_base���Z�žǥͦC��þڥH�P�esql��ӫ����
	
			$stud_select="SELECT a.student_sn,b.curr_class_num,right(b.curr_class_num,2) as class_no,b.stud_name,b.stud_sex FROM charge_record a,stud_base b WHERE a.item_id=$item_id AND a.student_sn=b.student_sn AND b.curr_class_num like '$class_id%' ORDER BY b.curr_class_num";
			$recordSet=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);
			//�Hcheckbox�e�{
			$col=5; //�]�w�C�@�C��ܴX�H
			
			$studentdata="�@���������B�G$dollars <input type='hidden' name='pay' value=$dollars>";
			while(list($student_sn,$curr_class_num,$class_no,$stud_name,$stud_sex)=$recordSet->FetchRow()) {
				if($recordSet->currentrow() % $col==1) $studentdata.="<tr>";
				if (array_key_exists($student_sn,$listed)) {
						$studentdata.="<td bgcolor=".($listed[$recordSet->fields[student_sn]-1]?"#CCCCCC":"#FFFF8D").">��($class_no)$stud_name ( $".round($dollars*$listed[$student_sn]/100)." )</td>";
				} else {
					$studentdata.="<td bgcolor=".($stud_sex==1?"#CCFFCC":"#FFCCCC")."><input type='checkbox' name='selected_stud[]' value='$student_sn,$curr_class_num' id='stud_selected'>($class_no)$stud_name</td>";
				}
				if($recordSet->currentrow() % $col==0  or $recordSet->EOF) $studentdata.="</tr>";
				//echo "<BR>$curr_class_num === $stud_name";
			}
			
			$studentdata.="<tr height='50'><td align='center' colspan=$col><input type='button' name='all_stud' value='����' onClick='javascript:tagall(1);'><input type='button' name='clear_stud'  value='������' onClick='javascript:tagall(0);'>�@";
			$studentdata.="�@����K���B�G<input type='text' name='decrease_dollars' size=5>���@��K��]�G<input type='text' name='cause' size=10>�@<input type='submit' value='�T�w��K' name='act'>";
			$studentdata.="�@<input type='submit' value='�M�ť��Z�Ŧ����ش�K�W��' name='act' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")'></td></tr>";
		}
	}
}
echo $main.$studentdata."</form></table>";
foot();
?>