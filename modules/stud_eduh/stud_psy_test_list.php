<?php

// $Id: $
include "config.php";
include "../stud_report/report_config.php";
include_once "../../include/sfs_case_dataarray.php";
//�{���ˬd
sfs_check();

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

$sel_stud=$_POST[sel_stud];
$newpage=$_POST[newpage];
$default_start=$IS_JHORES?1:16;
$start=$_POST[start]?$_POST[start]:$default_start;


if($_REQUEST[year_seme]=='')
  	$_REQUEST[year_seme] = sprintf("%03d%d",curr_year(),curr_seme());

if($_POST['go']=='���ڶ}�l�C�L')
{
//�Ӹ�O��
//�Ǵ�
$year_seme=$_POST['year_seme'];
//�Z�Ű}�C
$class_arr = class_base();
//�Z��(�����oSFS3�������w�Z�ťN�X�Ҧp101,�A�ഫ���Ǯզۭq�W�٨Ҥ@�~�үZ)
$class_id=$_POST['class_id'];
$class_name=$class_arr[$class_id];
//�����X��ƪ��ǥͰ}�C
$sel_stud=$_POST[sel_stud];
$stud_id_list=implode(',',$sel_stud);
$test=pipa_log("�L�߲z����O���K��\r\n�Ǵ��G$year_seme\r\n�Z�šG$class_id $class_name\r\n�ǥͦC��G$stud_id_list");
if (count($sel_stud)>0)
{
	foreach($sel_stud as $key=>$selected_student)
	{
		//���ostud_base�򥻸��
		$sql_basis="select a.student_sn,a.stud_name,a.curr_class_num,a.stud_study_year from stud_base a,stud_seme b where a.stud_id='$selected_student' and a.student_sn=b.student_sn and b.seme_year_seme='$year_seme'";
		$res_basis=$CONN->Execute($sql_basis) or user_error($sql_basis,256);
	  $student_sn=$res_basis->fields['student_sn'];
		$stud_name=$res_basis->fields['stud_name'];
		$curr_class_num=$res_basis->fields['curr_class_num'];
		$stud_study_year=$res_basis->fields['stud_study_year'];
		
		$data="( $curr_class_num )�@�@���Ǹ��G$selected_student �@�@���m�W�G$stud_name �@�@���J�Ǧ~�G$stud_study_year";
		
		?>

		<table border="0" width="100%">
			<tr>
				<td><?php echo $data;?></td>
			</tr>
		</table>
		<table border="1" cellspacing="0" cellpadding="2" style="border-collapse: collapse" bordercolor="#000000" width="100%">
<tr><td>�Ǵ�</td><td>������</td><td>�߲z����W��</td><td>��l����</td><td>�`�Ҽ˥�</td><td>�зǤ���</td><td>�ʤ�����</td><td>����</td><td>���ɪ�</td><td>�ʧ@</td></tr>
<?php
$sql_select = "select * from stud_psy_test where student_sn='$student_sn' order by year,semester,student_sn desc  ";
$recordSet = $CONN->Execute($sql_select) or die($sql_select);

while (!$recordSet->EOF) {
	$sn = $recordSet->fields["sn"];
	//$student_sn = $recordSet->fields["student_sn"];
	$year = $recordSet->fields["year"];
	$semester = $recordSet->fields["semester"];
		
	$item = $recordSet->fields["item"];
	$score = $recordSet->fields["score"];
	$model = $recordSet->fields["model"];
	$standard = $recordSet->fields["standard"];
	$pr = $recordSet->fields["pr"];
	$explanation = $recordSet->fields["explanation"];
	$test_date = $recordSet->fields["test_date"];
	$teacher_sn = $recordSet->fields["teacher_sn"];
	
	$name = get_teacher_name($teacher_sn);
	$seme_str = $year."�Ǧ~��".$semester."�Ǵ�";
	$seme_year_seme  = sprintf("%03d%d",$year,$semester);
		
	echo "<td>$seme_str</td><td>$test_date</td><td>$item</td><td>$score</td><td>$model</td><td>$standard</td><td>$pr</td><td>$explanation</td><td>$name</td><td>";
	
	echo "</td></tr>";
	
    $recordSet->MoveNext();
} // end while

?>
</table>
		
<?php		
  if($newpage) echo "<P STYLE='page-break-before: always;'>";

	}// end if foreach ($sel_stud as $key=>$selected_student)
	exit;
 } 
} // end if ���ڶ}�l�C�L

//��ܯZ��

head();

print_menu($menu_p);
echo <<<HERE
<script>
function tagall(status) {
  var i =0;

  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].name=='sel_stud[]') {
      document.myform.elements[i].checked=status;
    }
    i++;
  }
}
</script>
HERE;
echo "<hr><font color='#FF5555'><li>���\��D�n�b�C�L�ǥͪ��߲z����O���K���I</li>";
echo "<li>�ꤤ�w�]�۲�11���_�C�L�A��p�w�]�۲�16���_�C�L�C�ߨϥΪ̥i�ۭq�_�l���ơC</li>";
echo "<li>����ĥ�HTML�C�L�A�Ĩ�'�j��ӧO�ǥͤ���'�A�C��ǥͦC�L�ɬҷ|�}�ҷs�������C</li></font><hr>";

echo "<form enctype='multipart/form-data' action=\"{$_SERVER['PHP_SELF']}\" method=\"post\" name=\"myform\" target=\"\">";
$sel1 = new drop_select();
$sel1->top_option =  "��ܾǦ~";
$sel1->s_name = "year_seme";
$sel1->id = $_REQUEST[year_seme];
$sel1->is_submit = true;
$sel1->arr = get_class_seme();
$sel1->other_script = "this.form.target=''";
$sel1->do_select();

 	 
echo "&nbsp;&nbsp;";
$sel1 = new drop_select();
$sel1->top_option =  "��ܯZ��";
$sel1->s_name = "class_id";
$sel1->id = $class_id;
$sel1->is_submit = true;
$sel1->arr = class_base($_REQUEST[year_seme]);
$sel1->other_script = "this.form.target=''";
$sel1->do_select();



if($class_id<>'') {

 $query = "select a.student_sn,a.stud_id,a.stud_name,b.seme_num,a.stud_study_cond from stud_base a , stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$_REQUEST[year_seme]' and seme_class='$_REQUEST[class_id]' order by b.seme_num";
	$result = $CONN->Execute($query) or die ($query);
	if (!$result->EOF) {
 		
		echo '&nbsp;<input type="button" value="����" onClick="javascript:tagall(1);">&nbsp;';
 		echo '<input type="button" value="��������" onClick="javascript:tagall(0);">';
		
		echo "<table border=1>";
		$ii=0;
		while (!$result->EOF) {
			$student_sn= $result->fields[student_sn];
			$stud_id = $result->fields[stud_id];
			$stud_name = $result->fields[stud_name];
			$curr_class_num = $result->fields[seme_num];
			$stud_study_cond = $result->fields[stud_study_cond];
			$move_kind ='';
			if ($stud_study_cond >0)
				$move_kind= "<font color='red'>(".$move_kind_arr[$stud_study_cond].")</font>";

			if ($ii %2 ==0)
				$tr_class = "class=title_sbody1";
			else
				$tr_class = "class=title_sbody2";
			
			if ($ii % 5 == 0)
				echo "<tr $tr_class >";
				
			//������ɳX�ͰO������
			//$sql="select count(*) from stud_seme_talk where student_sn=$student_sn";   ---> student_sn �|����������
			$sql="select count(*) as counter from stud_seme_talk where stud_id=$stud_id";
			$rs=$CONN->Execute($sql) or die($sql);
			$counter=$rs->fields[counter];
			
				$color='#FFCCCC';
				$input="<input id=\"c_$stud_id\" type=\"checkbox\" name=\"sel_stud[]\" value=\"$stud_id\" checked>";

			echo "<td bgcolor='$color'>$input<label for=\"c_$stud_id\">$curr_class_num. $stud_name $move_kind</label>($counter)</td>\n";
				
			if ($ii % 5 == 4)
				echo "</tr>";
			$ii++;
			$result->MoveNext();
		}
		echo"</table>";
	}
	echo "<BR><input type='checkbox' name='newpage' value='Y'>�j��ӧO�ǥͤ����@";
	echo "<input type='submit' name='go' value='���ڶ}�l�C�L' onclick='this.form.target=\"_blank\"'>";

}
echo "</form>";

foot();

?>
