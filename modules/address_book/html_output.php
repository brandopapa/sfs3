<?php

// $Id: $

/*�ޤJ�ǰȨt�γ]�w��*/
include "config.php";

//�ϥΪ̻{��
sfs_check();

if($_POST['act'])
{
	$sn=$_POST['target_sn'];
	//��������
	$sql="SELECT * FROM address_book WHERE sn=$sn";
	$rs=$CONN->Execute($sql) or die("�L�k���o�w�g�}�C���˦����!<br>$sql");
	$title=$rs->fields['title'];
	$fields=$rs->fields['fields'];
	$header=$rs->fields['header']?"<br>".$rs->fields['header']:'';
	$footer=$rs->fields['footer'];;

	//�]�w�����Y
	$columns_array=explode(',',$fields);
	$fields_list='';
	$fields_list_array=array();
	$table_data="<table STYLE='font-size: x-small' border='1' cellpadding=3 cellspacing=0 style='border-collapse: collapse' bordercolor='#111111' width='100%'><tr bgcolor='#FFCCCC'>";	
	$csv_header="";
	foreach($columns_array as $key=>$value)
	{
		$value=trim($value);
		if($value)
		{
			//�p�G�O �D�Ҳպ޲z���ˬd�T�C���� �h�N ���W�٥[��*XXXX*
			if (! checkid($_SERVER['SCRIPT_FILENAME'],1))
				if(strpos($forbid,"$value")) $value="*$value*";

			$table_data.="<td align='center'>$value</td>";
			$csv_header.="$value,";
				
			$fields_list_array[$key]=array_search($value,$fields_array);
			if($fields_list_array[$key])
			{
				if($value=='�~��') $fields_list.='left(a.curr_class_num,1) AS grade,';
					elseif($value=='�Z�ťN��') $fields_list.='left(a.curr_class_num,3) AS class_id,';
					elseif($value=='�Z�ŦW��') $fields_list.='left(a.curr_class_num,3) AS class_name,';
					elseif($value=='�X�ͦ~') $fields_list.='year(a.stud_birthday) AS year,';
					elseif($value=='�X�ͤ�') $fields_list.='month(a.stud_birthday) AS month,';
					elseif($value=='�X�ͤ�') $fields_list.='day(a.stud_birthday) AS day,';
					else $fields_list.=$fields_list_array[$key].',';
				$fields_list_array[$key]=substr($fields_list_array[$key],2);
			} else $fields_list_array[$key]='';
		}
	}
	$fields_list=substr($fields_list,0,-1);
	$csv_header=substr($csv_header,0,-1)."\r\n";
	$table_data.="</tr>";

	switch($nature)
	{
		case 'student':
			if($_POST['class_selected'])
			{
				$last_key=count($_POST['class_selected'])-1;
				$data='';
				foreach($_POST['class_selected'] as $key=>$class_id)
				{
					//������w�Z�žǥ͸��
					$sql_student="SELECT $fields_list FROM stud_base a LEFT JOIN stud_domicile b ON a.student_sn=b.student_sn WHERE stud_study_cond=0 AND curr_class_num like '$class_id%'ORDER BY curr_class_num";
					$rs_student=$CONN->Execute($sql_student) or die("�L�k���o{$nature_array[$nature]}���!<br>$sql_student");

					if($_POST['act']=='html'){
						$csv_header='';
						$data="<center><font size=4>$school_long_name<br>$title</font></center><font size=2>$header<p align='right'>���Z�šG {$class_name_arr[$class_id]}</p></font>$table_data<tr>";
						while(!$rs_student->EOF) {
							foreach($fields_list_array as $field_name)
							{
								$field_data=$rs_student->fields[$field_name];
								//�S�����B�z  
								if($field_name=='curr_class_num') $field_data=substr($field_data,-2); else
								if($field_name=='class_name') $field_data=$class_name_arr[$field_data]; else
								if(substr($field_name,-11)=='birth_place') $field_data=$birth_place_array[$field_data]; else
								if(substr($field_name,-5)=='alive') $field_data=$is_live[$field_data]; else
								if($field_name=='stud_sex') $field_data=$sex_arr[$field_data]; else
								if($field_name=='stud_blood_type') $field_data=$blood_arr[$field_data]; else
								if(substr($field_name,-8)=='birthday') $field_data=(date('Y',strtotime($field_data))-1911).date('�~m��d��',strtotime($field_data)); else
								if($field_name=='guardian_relation') $field_data=$guardian_relation[$field_data];
								
								if($field_name=='obtain') $field_data=$obtain_arr[$field_data];
								if($field_name=='safeguard') $field_data=$safeguard_arr[$field_data];
								
								//���ϬO�a�} �N���]�w�m�����
								if(strpos($field_name,'add')) $align=''; else $align="align='center'";
								$data.="<td $align>$field_data</td>";
							}
							$data.="</tr>";
							$rs_student->MoveNext();
						}
						$data.="</table><font size=1>$footer</font>";
						if($key<$last_key) $data.=$page_break;
						echo $data;
						$data='';
					} else {
						$my_class_name=$class_name_arr[$class_id];
						while(!$rs_student->EOF) {
							foreach($fields_list_array as $field_name)
							{
								$field_data=$rs_student->fields[$field_name];
								//�S�����B�z
								if($field_name=='curr_class_num') $field_data=substr($field_data,-2); else
								if($field_name=='class_name') $field_data=$class_name_arr[$field_data]; else
								if(substr($field_name,-11)=='birth_place') $field_data=$birth_place_array[$field_data]; else
								if(substr($field_name,-5)=='alive') $field_data=$is_live[$field_data]; else
								if($field_name=='stud_sex') $field_data=$sex_arr[$field_data]; else
								if(substr($field_name,-8)=='birthday') $field_data=(date('Y',strtotime($field_data))-1911).date('�~m��d��',strtotime($field_data)); else
								if($field_name=='guardian_relation') $field_data=$guardian_relation[$field_data];
								
								if($field_name=='obtain') $field_data=$obtain_arr[$field_data];
								if($field_name=='safeguard') $field_data=$safeguard_arr[$field_data];
								
								$data.="$field_data,";
							}
							$data.="\r\n";
							$rs_student->MoveNext();
						}
					}
				}
				$filename=$school_long_name.$title.$header.".csv";
				header("Content-disposition: attachment; filename=$filename");
				header("Content-type: text/x-csv");
				//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");

				header("Expires: 0");
				echo $csv_header.$data;
				exit;	
			} else echo "<center><font size=10 color='red'><br><br><br>�z���������Z��!</font></center>";
			break;
		case 'teacher':
			$sql_teacher="SELECT $fields_list FROM teacher_base a LEFT JOIN teacher_connect b ON a.teacher_sn=b.teacher_sn WHERE teach_condition=0 ORDER BY birthday";
			$rs_teacher=$CONN->Execute($sql_teacher) or die("�L�k���o{$nature_array[$nature]}���!<br>$sql_teacher");
			$data="<center><font size=4>$school_long_name<br>$title</font></center><font size=2>$header</font>$table_data<tr>";
			while(!$rs_teacher->EOF) {					
				foreach($fields_list_array as $field_name)
				{
					$field_data=$rs_teacher->fields[$field_name];						
					//�S�����B�z
					if($field_name=='curr_class_num') $field_data=substr($field_data,-2); 
					if(substr($field_name,-11)=='birth_place') $field_data=$birth_place_array[$field_data];
					
					if($field_name=='sex') $field_data=$sex_arr[$field_data]; //�Юv�ʧO
					if(substr($field_name,-8)=='birthday') $field_data=(date('Y',strtotime($field_data))-1911).date('�~m��d��',strtotime($field_data)); 
				
					//���ϬO�a�} �N���]�w�m�����
					if(strpos($field_name,'add')) $align=''; else $align="align='center'";
					$data.="<td $align>$field_data</td>";
				}
				$data.="</tr>";
				$rs_teacher->MoveNext();
			}					
			$data.="</table><font size=1>$footer</font>";
			echo $data;
			break;	
	}
} else {
	//�q�X����
	head("�q�T����X");
	print_menu($menu_p);
	
	echo "<script>
		function tagall(status) {
		  var i =0;
		  while (i < document.myform.elements.length)  {
			if (document.myform.elements[i].name=='class_selected[]') {
			  document.myform.elements[i].checked=status;
			}
			i++;
		  }
		}
		</script>";
		
	if($_POST['nature']<>'teacher') $csv_button="";

	//����w�g�}�C���˦����
	$myself=$_POST['myself']?"and creater='$my_name'":'';
	$saved_format="<table STYLE='font-size: x-small' border='1' cellpadding=5 cellspacing=0 style='border-collapse: collapse' bordercolor='#111111' width='100%'><tr bgcolor='#CCCFFC'><td align='center'>���D</td><td align='center' width='40%'>���C��</td><td align='center'>���</td><td align='center'>�]�w��</td><td align='center'>��s���</td><td align='center'>�ʧ@<input type='hidden' name='target_sn' value='{$_POST['target_sn']}'><input type='hidden' name='act' value=''></td></tr>";
	$sql="select * from address_book where room='$my_room' and nature='$nature' $myself order by update_time desc;";
	$rs=$CONN->Execute($sql) or die("�L�k���o�w�g�}�C���˦����!<br>$sql");
	while(!$rs->EOF) {
		$target_sn=$rs->fields['sn'];
		if($rs->fields['creater']==$my_name) $myselef_color='#FCFCBF'; else $myselef_color='#FFFFFF';
		$saved_format.="<tr bgcolor='$myselef_color'><td align='center'>{$rs->fields['title']}</td><td>{$rs->fields['fields']}</td><td align='center'>{$rs->fields['columns']}</td><td align='center'>{$rs->fields['creater']}</td><td align='center'>{$rs->fields['update_time']}</td><td align='center'>
						<input type='button' value='������X' onclick='this.form.target_sn.value=\"$target_sn\"; this.form.act.value=\"html\"; this.form.target=\"_blank\"; this.form.submit();'>
						<input type='button' value='CSV��X' onclick='this.form.target_sn.value=\"$target_sn\"; this.form.act.value=\"csv\"; this.form.submit();'>
						<input type='button' value='�ק�' onclick='this.form.target_sn.value=\"$target_sn\"; this.form.act.value=\"modify\"; this.form.action=\"manage.php\"; this.form.target=\"_self\"; this.form.submit();'>
						</td></tr>";
		$rs->MoveNext();
	}
	$myself="<input type='checkbox' name='myself' value='ON'".($_POST['myself']?' checked':'')." onclick='this.form.target_sn.value=\"\"; this.form.act.value=\"\"; this.form.action=\"$_SERVER[SCRIPT_NAME]\"; this.form.target=\"_self\"; this.form.submit();'>�u�C�ܧڳ]�w���˦�";
	//�p�G�O �D�Ҳպ޲z����ܸT�C������
	if (! checkid($_SERVER['SCRIPT_FILENAME'],1)) $myself.=" �@�@�@<font color='red' size=2>���z�D�Ҳպ޲z���A�t�θT��C�ܪ�����: $forbid</font>";
	
	$saved_format.='</table>';
	
	//�p�G�O�ǥͲ��ͯZ���H��M��
	if($nature=='student')
	{
		//������w�Ǧ~�Z��
		$class_list="<table STYLE='font-size: x-small' border='1' cellpadding=5 cellspacing=0 style='border-collapse: collapse' bordercolor='#111111' width='100%'>
					<tr bgcolor='#FFCCCC'><td align='center'>��w�n�C�L���Z�� <input type='checkbox' name='tag' onclick='javascript:tagall(this.checked);'>����</td></tr><tr><td>";
		$sql="select * from school_class where enable=1 and year='$curr_year' and semester='$curr_seme' order by c_year,c_sort;";
		$rs=$CONN->Execute($sql) or die("�L�k���o $curr_year_seme �Z�Ÿ��!<br>$sql");
		while(!$rs->EOF)
		{
			$class_id=sprintf('%0d%02d',$rs->fields['c_year'],$rs->fields['c_sort']);
			$class_name=$class_name_arr[$class_id];
			$class_list.="<input type='checkbox' name='class_selected[]' value='$class_id'>$class_name ";
			$rs->MoveNext();
		}
		$class_list.="</td></tr></table>";
	}
	echo "<form name='myform' method='post' action='$_SERVER[SCRIPT_NAME]'>$nature_radio<hr>$class_list<br>$myself $saved_format</form>";
	foot();
}

?>
