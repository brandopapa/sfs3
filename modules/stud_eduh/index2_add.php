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
$default_start=$IS_JHORES?11:16;
$start=$_POST[start]?$_POST[start]:$default_start;


if($_REQUEST[year_seme]=='')
  	$_REQUEST[year_seme] = sprintf("%03d%d",curr_year(),curr_seme());

if($_POST['go']=='���ڶ}�l�C�L')
{

//�Ӹ�O��
//�Ǵ�
$year_seme=$_POST['year_seme']-0;
//�Z�Ű}�C
$class_arr = class_base();
//�Z��(�����oSFS3�������w�Z�ťN�X�Ҧp101,�A�ഫ���Ǯզۭq�W�٨Ҥ@�~�үZ)
$class_id=$_POST['class_id'];
$class_name=$class_arr[$class_id];
$test=pipa_log("�L���ɳX�ͰO���K��\r\n�Ǵ��G$year_seme\r\n�Z�šG$class_id $class_name\r\n");

if (count($sel_stud)>0)
{
	foreach($sel_stud as $key=>$selected_student)
	{
		//���ostud_base�򥻸��
		$sql_basis="select stud_name,curr_class_num,stud_study_year from stud_base where stud_id='$selected_student' and left($year_seme,length($year_seme)-1)-stud_study_year<=9";		$res_basis=$CONN->Execute($sql_basis) or user_error($sql_basis,256);
		$stud_name=$res_basis->fields['stud_name'];
		$curr_class_num=$res_basis->fields['curr_class_num'];
		$stud_study_year=$res_basis->fields['stud_study_year'];
		
		$data="( $curr_class_num )�@�@���Ǹ��G$selected_student �@�@���m�W�G$stud_name �@�@���J�Ǧ~�G$stud_study_year";
		$data.="<table name='$data=' align=center width='100%' border='2' cellpadding='5' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111'>";
		$data.="<tr align='center' bgcolor='#FFCCCC'><td>NO.</td><td>�~��</td><td width=90>�������</td><td width=90>�s����H</td><td width=90>�s���ƶ�</td><td>���e�n�I</td><td width=90>���ɪ�</td></tr>";
		$sql="select a.*,b.name as teacher from stud_seme_talk a LEFT JOIN teacher_base b ON a.teach_id=b.teacher_sn WHERE abs(left(a.seme_year_seme,length(a.seme_year_seme)-1)-$stud_study_year)<=6 AND a.stud_id='$selected_student' order by a.sst_date,a.seme_year_seme";
		$res=$CONN->Execute($sql) or user_error("Ū��stud_seme_talk��ƥ��ѡI<br>$sql",256);
		$recno=0;
		while(!$res->EOF)
		{
			$recno++;
			if($recno>=$start)
			{
				//�p��N�Ǧ~��
				$year=substr($res->fields[seme_year_seme],0,3);
				$grade=$year-$stud_study_year+$IS_JHORES;
				$grade_array=array('�@','�G','�T','�|','��','��','�C','�K','�E','�Q','�Q�@','�Q�G');
				
				//���ϥ���컲�ɱЮv�A�h����ǶפJ����ƪ�M��
				if(! $res->fields['teacher']) {
					$seme_year_seme=$res->fields['seme_year_seme'];
					$sql_teacher="select teacher_name from stud_seme_import WHERE stud_id='$stud_id' and seme_year_seme='$seme_year_seme';";
					$res_teacher=$CONN->Execute($sql_teacher);
					//���N��ŭ�
					$res->fields[teacher]=$res_teacher->fields['teacher_name'];
				}
				$data.="<tr><td align='center'>{$recno}</td><td align='center'>{$grade_array[$grade]}</td><td align='center'>{$res->fields[sst_date]}</td><td align='center'>{$res->fields[sst_name]}</td><td align='center'>{$res->fields[sst_main]}</td><td>{$res->fields[sst_memo]}</td><td align='center'>{$res->fields[teacher]}</td></tr>";
			}	
			$res->movenext();	
		}
		//echo "<pre>";
		//print_r($res->getrows());
		//echo "</pre>";
		$data.="</table><BR>";
		if($key<count($sel_stud)-1)	if($newpage) $data.="<P STYLE='page-break-before: always;'>";
		echo $data;
	}
	exit;
}
}

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
echo "<hr><font color='#FF5555'><li>���\��D�n�b�C�L�ǥͪ����ɳX�ͰO���A�ѨM95���ɬ�����ǥͻ��ɳX�ͰO���W�X�w���ƦӵL�k��ܪ����D�I</li>";
echo "<li>�ꤤ�w�]�۲�11���_�C�L�A��p�w�]�۲�16���_�C�L�C�ߨϥΪ̥i�ۭq�_�l���ơC</li>";
echo "<li>����ĥ�HTML�C�L�A�Ĩ�'�j��ӧO�ǥͤ���'�A�C��ǥͦC�L�ɬҷ|�}�ҷs�������C</li></font><hr>";

echo "<form enctype='multipart/form-data' action=\"{$_SERVER['PHP_SELF']}\" method=\"post\" name=\"myform\">";
$sel1 = new drop_select();
$sel1->top_option =  "��ܾǦ~";
$sel1->s_name = "year_seme";
$sel1->id = $_REQUEST[year_seme];
$sel1->is_submit = true;
$sel1->arr = get_class_seme();
$sel1->do_select();
 	 
echo "&nbsp;&nbsp;";
$sel1 = new drop_select();
$sel1->top_option =  "��ܯZ��";
$sel1->s_name = "class_id";
$sel1->id = $class_id;
$sel1->is_submit = true;
$sel1->arr = class_base($_REQUEST[year_seme]);
$sel1->do_select();


if($class_id<>'') {
 $query = "select a.student_sn,a.stud_id,a.stud_name,b.seme_num,a.stud_study_cond from stud_base a , stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$_REQUEST[year_seme]' and seme_class='$_REQUEST[class_id]' order by b.seme_num";
	$result = $CONN->Execute($query) or die ($query);
	if (!$result->EOF) {
		//����SELECT�ﶵ
		$start_select="<select name='start' onchange='this.form.submit();'>";
		for($i=1;$i<=30;$i++)
		{
			if($i==$start) $start_select.="<option selected>$i</option>"; else $start_select.="<option>$i</option>";
			
		}
		$start_select.="</select>";
 		
		echo '&nbsp;<input type="button" value="����" onClick="javascript:tagall(1);">&nbsp;';
 		echo '<input type="button" value="��������" onClick="javascript:tagall(0);">';
		echo "�@�@���۲� $start_select ���_�C�L<hr>";
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
			
			if($counter>=$start)
			{
				$color='#FFCCCC';
				$input="<input id=\"c_$stud_id\" type=\"checkbox\" name=\"sel_stud[]\" value=\"$stud_id\" checked>";
			} else {
				$color='#CCCCCC'; $input="";
			}
		
			echo "<td bgcolor='$color'>$input<label for=\"c_$stud_id\">$curr_class_num. $stud_name $move_kind</label>($counter)</td>\n";
				
			if ($ii % 5 == 4)
				echo "</tr>";
			$ii++;
			$result->MoveNext();
		}
		echo"</table>";
	}
	echo "<BR><input type='checkbox' name='newpage' value='Y'>�j��ӧO�ǥͤ����@";
	echo "<input type='submit' name='go' value='���ڶ}�l�C�L'>";
}
echo "</form>";

foot();

?>
