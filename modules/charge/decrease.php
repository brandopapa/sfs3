<?php

// $Id: decrease.php 5864 2010-02-23 15:16:23Z infodaes $



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

$detail_id=$_REQUEST[detail_id];

$decrease_id=$_REQUEST[decrease_id];

$class_id=$_POST[class_id];

$a_percent=$_POST[a_percent]?$_POST[a_percent]:100;

$a_cause=$_POST[a_cause];



$subkind_id=$_POST[subkind_id];

$b_percent=$_POST[b_percent]?$_POST[b_percent]:100;

$b_cause=$_POST[b_cause];





// ���X�Z�Ű}�C

$class_base = class_base($work_year_seme);



//��V������

$linkstr="work_year_seme=$work_year_seme&item_id=$item_id";

echo print_menu($MENU_P,$linkstr);



// $_SESSION[session_tea_name]  ���o�Юv�m�W



if($_POST['act']=='��@�ǥͷs�W'){

	$aaa=explode('_',$_POST[a_student_sn]);

	$student_sn=$aaa[0];

	$curr_class_num=$aaa[1];

	if($student_sn<>'' AND $curr_class_num<>'' AND $_POST[a_percent]<>'')

	{

		$sql_select="REPLACE INTO charge_decrease(detail_id,student_sn,curr_class_num,percent,cause) values ('$detail_id',$student_sn,'$curr_class_num','$_POST[a_percent]','$_POST[a_cause]')";

		$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);

	} else echo "<script language=\"Javascript\"> alert (\"��T����, �L�k�s�W�I\")</script>";

};



if($_POST['act']=='�����妸�s�W'){

	

	if($subkind_id<>'' AND $b_percent<>'' AND $_POST[b_cause]<>'')

	{

		//��Ӫ��������@�|�N�Ҧ��Ө����O�ǥ͡@�@���|�ޥL���L�ݭn���O�@�q�q�}�C��K

		$sql_select="select curr_class_num,student_sn from stud_base where (stud_kind like '%,$subkind_id,%') and (stud_study_cond=0) order by curr_class_num";

		

		//�s���������@�u�}�C�Ө����O�ǥ͡@���ѥ[���@���O�W��

		$sql_select="select a.*,b.curr_class_num from charge_record a,stud_base b where a.item_id=$item_id AND a.student_sn=b.student_sn AND (b.stud_kind like '%,$subkind_id,%') and (b.stud_study_cond=0) order by curr_class_num";

		

		//echo $sql_select."<BR>";

		

		$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);

		

		//echo "<BR>";

		//print_r($recordSet->FetchRow());

		//echo "<BR>";

		if($recordSet->EOF) echo "�L�ŦX���ǥͥi�}�C!"; else

		{

			$batch_value="";

			while(!$recordSet->EOF)

			{

				//('$detail_id',$student_sn,'$curr_class_num','$_POST[a_percent]','$_POST[a_cause]')"

				$sn=$recordSet->fields[student_sn];

				$class_num=$recordSet->fields[curr_class_num];

				$batch_value.="('$detail_id',$sn,'$class_num','$_POST[b_percent]','$_POST[b_cause]'),";

				$recordSet->MoveNext();

			}

			$batch_value=substr($batch_value,0,-1);

			//echo "===================<BR>$batch_value<BR>===================";

			$sql_select="REPLACE INTO charge_decrease(detail_id,student_sn,curr_class_num,percent,cause) values $batch_value";

			$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);

		}

	} else echo "<script language=\"Javascript\"> alert (\"��T����, �L�k�����O�妸�s�W�I\")</script>";

};





if($_POST['act']=='�ק�'){

	$sql_select="update charge_decrease set detail_id=$detail_id,percent='$_POST[percent]',cause='$_POST[cause]' where decrease_id=$decrease_id;";

	$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);

	$decrease_id=0;

};



if($_POST['act']=='�R��'){

	$sql_select="delete from charge_decrease where decrease_id=$decrease_id";

	$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);

};





if($_POST['act']=='�M�ť����W��'){

	$sql_select="delete from charge_decrease where detail_id=$detail_id";

	$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);

};





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

$main.="</select>";



if($detail_id>0)

{

//��ܫ��w���ت���K�H��

$sql_select="select a.*,b.stud_name,left(a.curr_class_num,3) as class_id,right(a.curr_class_num,2) as class_no from charge_decrease a,stud_base b where a.detail_id='$detail_id' AND a.student_sn=b.student_sn order by curr_class_num";

$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);



$main.="�@<img border=0 src='images/modify.gif' alt='�s�׿�w��K�ǥ�'><select name='decrease_id' onchange='this.form.submit()'><option></option>";

while(!$res->EOF) {

	$main.="<option ".($decrease_id==$res->fields[decrease_id]?"selected":"")." value=".$res->fields[decrease_id].">[".$res->fields[curr_class_num]."]".$res->fields[stud_name]."->".$res->fields[cause]."</option>";

	$res->MoveNext();

}

$main.="</select></table>";



$showdata="<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%'>

	<tr bgcolor='#CCFF99'>

	<td align='center' size=5>NO.</td>

	<td align='center' size=5>�Z��</td>

	<td align='center' size=3>�y��</td>

	<td align='center' size=20>�ǥͩm�W</td>

	<td align='center' size=30>������</td>

	<td align='center' size=30>��K��</td>

	<td align='center' size=30>��K�B</td>

	<td align='center' size=30>��ú��</td>

	<td align='center' size=30>��K��]</td>

	<td align='center'><input type='submit' name='act' value='�M�ť����W��' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")'></td>

	</tr>";

	

	//<input type='reset' value='�^�_'>

$res->MoveFirst();

while(!$res->EOF) {

	$curr_grade=substr($res->fields[class_id],0,1)-1;

	$my_decrease=round($grade_dollar[$curr_grade]*$res->fields[percent]/100);

	$my_dollar=$grade_dollar[$curr_grade]-$my_decrease;

	if($decrease_id==$res->fields[decrease_id]){



		$showdata.="<tr bgcolor=#AAFFCC><td align='center'>".($res->CurrentRow()+1)."</td>";

		$showdata.="<td align='center'>".$class_base[$res->fields[class_id]]."</td>";

		$showdata.="<td align='center'>".$res->fields[class_no]."</td>";

		$showdata.="<td align='center'>".$res->fields[stud_name]."</td>";

		$showdata.="<td align='center'>".$grade_dollar[$curr_grade]."</td>";

		$showdata.="<td align='center'><input type='text' name='percent' value='".$res->fields[percent]."' size=3>%</td>";

		$showdata.="<td align='center'>".$my_decrease."</td>";

		$showdata.="<td align='center'>".$my_dollar."</td>";

		$showdata.="<td align='center'><input type='text' name='cause' value='".$res->fields[cause]."' size=20></td>";

		//$showdata.="<td align='center'>".$res->fields[decrease_id]."</td>";

		$showdata.="<td align='center'><input type='submit' value='�ק�' name='act' onclick='return confirm(\"�T�w�n���[".$res->fields[stud_name]."]?\")'>�@<input type='submit' value='�R��' name='act' onclick='return confirm(\"�u���n�R��[".$res->fields[stud_name]."]?\")'></td></tr>";

	} else {	

		$showdata.="<tr bgcolor=#FFFFDD><td align='center'>".($res->CurrentRow()+1)."</td>";

		$showdata.="<td align='center'>".$class_base[$res->fields[class_id]]."</td>";

		$showdata.="<td align='center'>".$res->fields[class_no]."</td>";

		$showdata.="<td align='center'>".$res->fields[stud_name]."</td>";

		$showdata.="<td align='center'>".$grade_dollar[$curr_grade]."</td>";

		$showdata.="<td align='center'>".$res->fields[percent]."%</td>";

		$showdata.="<td align='center'>".$my_decrease."</td>";

		$showdata.="<td align='center'>".$my_dollar."</td>";

		

		$showdata.="<td align='center'>".$res->fields[cause]."</td>";

		$showdata.="<td></td>";



		//�\��s��

		//$showdata.="<td align='center'>";

		//$showdata.="<a href='detail.php?item_id=".$res->fields[item_id]."'><img border=0 src='images/modify.gif' alt='�]�w�ӥ�'> </a>";

		//$showdata.="<a href='record.php?item_id=".$res->fields[item_id]."'><img border=0 src='images/sxw.gif' alt='�L���O��'> </a>";

		//$showdata.="<a href='statistics.php?item_id=".$res->fields[item_id]."'><img border=0 src='images/sigma.gif' alt='���O�έp'> </a>";

		//$showdata.="<a href='item.php?act=delete&item_id=".$res->fields[item_id]."'><img border=0 src='images/delete.gif' alt='�R��' onclick='return confirm(\"�u���n�R�� $stud_name ?\")'></a>";

		$showdata.="</td></tr>";

	}



	$res->MoveNext();

}

if($work_year_seme==$curr_year_seme and $item_id and $detail_id)

{

	//�s�W��K����

	$class_list=get_item_class($item_id,$class_base,$class_id);

	//���o�Z�žǥͦC��

	//$stud_select="SELECT student_sn,curr_class_num,stud_name FROM stud_base WHERE stud_study_cond=0 AND curr_class_num like '$class_id%' ORDER BY curr_class_num";

	$stud_select="select a.*,mid(a.record_id,5) as curr_class_num,b.stud_name from charge_record a,stud_base b where item_id=$item_id AND record_id like '$work_year_seme$class_id%' AND a.student_sn=b.student_sn order by record_id";

        $recordSet=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);

        $studentdata="<select name='a_student_sn'><option></option>";

        if($class_id){
		while(!$recordSet->EOF)
		{
			$studentdata.="<option value='".$recordSet->fields[student_sn]."_".$recordSet->fields[curr_class_num]."'>(".substr($recordSet->fields[curr_class_num],-2).")".$recordSet->fields[stud_name]."</option>";
			$recordSet->MoveNext();
		}
	}

        $studentdata.="</select>";

	

	$showdata.="<tr></tr><tr bgcolor='#FFCCCC'><td align='center'><img border=0 src='images/add.gif' alt='��@�ǥͷs�W'></td>";

	$showdata.="<td align='center'>$class_list";

	$showdata.="<td colspan=2 align='center'>$studentdata";

	$showdata.="<td align='center'>--</td><td align='center'><input type='text' name='a_percent' value='$a_percent' size=3>%</td>";

	$showdata.="<td align='center'>--</td><td align='center'>--</td><td align='center'><input type='text' name='a_cause' value='$a_cause' size=20></td>";

	$showdata.="<td align='center'><input type='submit' value='��@�ǥͷs�W' name='act'></td></tr>";

	

	//�H�ǥͨ����O�妸�s�W

	//���o�ǥͨ����C��

	$type_select="SELECT d_id,t_name FROM sfs_text WHERE t_kind='stud_kind' AND d_id>0 order by t_order_id";

	$recordSet=$CONN->Execute($type_select) or user_error("Ū�����ѡI<br>$type_select",256);

	while (list($d_id,$t_name)=$recordSet->FetchRow()) { $typedata.="<option value='$d_id'>$t_name</option>"; }

	$typedata="<select name='subkind_id' onchange='this.form.b_cause.value=this.options[this.selectedIndex].text'><option></option>".$typedata."</select>";

	//echo $typedata;

	

	$showdata.="<tr></tr><tr bgcolor='#CCCCAA'><td align='center'><img border=0 src='images/batchadd.gif' alt='�����O�妸�s�W'></td>";

	$showdata.="<td colspan=3 align='center'>$typedata";

	$showdata.="<td align='center'>--</td><td align='center'><input type='text' name='b_percent' value='$b_percent' size=3>%</td>";

	$showdata.="<td align='center'>--</td><td align='center'>--</td><td align='center'><input type='text' name='b_cause' value='$b_cause' size=20></td>";

	$showdata.="<td align='center'><input type='submit' value='�����妸�s�W' name='act'></td></tr><tr></tr>";



}

}

$showdata.="</form></table><BR><center><a href='decrease_list.php?work_year_seme=$work_year_seme&item_id=$item_id' target='_BLANK'><img src='images/sxw.gif' border=0> �Ҧ���K�ǥͲM�U</a></center>";



echo $main.$showdata;





foot();

?>