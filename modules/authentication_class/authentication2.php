<?php
// $Id: $

include "config.php";

sfs_check();

//�q�X����
head("�{�ҵn��");

echo <<<HERE
<script>
function tagall(item,status) {
  var i =0;
  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].name==item) {
      document.myform.elements[i].checked=status;
    }
    i++;
  }
}


function check_select() {
  var i=0; k=0; answer=true;
  while (i < document.myform.elements.length)  {
    if(document.myform.elements[i].checked) {
		if(document.myform.elements[i].name=='subitem_sn[]') k++;
    }
    i++;
  }
  if(k==0) { alert("�|������{�ҲӥءI"); answer=false; }
  
  return answer;
}

</script>
HERE;

$item_sn=$_POST[item_sn];
$subitem_sn_arr=$_POST[subitem_sn];
$curr_class_id=$_POST[curr_class_id];
$curr_class_grade=substr($curr_class_id,0,-2);
$student_sn=$_POST[student_sn];
$cancel_sn=$_POST[cancel_sn];
$go_caption='ñ�{���O';

//��V������
echo print_menu($MENU_P);

if($_POST['act']==$go_caption){
	//�������
	$score_array=$_POST['score'];
	$note_array=$_POST['note'];
	$batch_value="";
	foreach($subitem_sn_arr as $key=>$sn){
		$score=$score_array[$sn];
		$note=$note_array[$sn];
		$batch_value.="('$work_year_seme','$sn','$my_sn',curdate(),'$score','$note','$student_sn'),";
	}
	$batch_value=substr($batch_value,0,-1);
	
	//�����ܪ��Z�žǥ�
	$sql="INSERT INTO authentication_record(year_seme,sub_item_sn,teacher_sn,date,score,note,student_sn) values $batch_value";
	$res=$CONN->Execute($sql) or user_error("ñ�{���ѡI<br>$sql",256);
}

if($cancel_sn){
	$sql="DELETE FROM authentication_record WHERE sn=$cancel_sn";
	$res=$CONN->Execute($sql) or user_error("�R�����ѡI<br>$sql",256);
};

$class_list="���Z�šG<select name='curr_class_id' onchange='this.form.submit()'><option></option>";
//�ɮv�[�J���ЯZ��
if($my_class_id){
	if($curr_class_id==$my_class_id){
		$selected='selected';
	} else $selected='';
	$class_list.="<option value='$my_class_id' style='background-color: #ffcccc;' $selected>{$class_base[$my_class_id]}</option>";
}
//����Q���v���Z��
$sql_select="select distinct class_id from authentication_empower WHERE empowered_sn=$my_sn AND year_seme='$curr_year_seme' order by class_id";
$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
while(!$recordSet->EOF)
{
	$class_id=$recordSet->fields[class_id];
	if($my_class_id<>$class_id){
		$class_name=$class_base[$class_id];
		if($curr_class_id==$class_id){
			$selected='selected';
		} else $selected='';
		$class_list.="<option value='$class_id' bgcolor='#ffcccc' $selected>$class_name</option>";		
	}	
	$recordSet->MoveNext();
}
$class_list.="</select>";
	
if($curr_class_id)
{
	//���ostud_base���Z�žǥͦC��
	$stud_select="SELECT a.student_sn,a.stud_id,a.seme_num,b.stud_name,b.stud_sex FROM stud_seme a,stud_base b WHERE seme_year_seme='$curr_year_seme' and a.seme_class='$curr_class_id' and a.student_sn=b.student_sn ORDER BY seme_num";
	$recordSet=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);
	//�Hradio�e�{
	//<input type='button' name='all_stud' value='����' onClick='javascript:tagall(\"student_sn[]\",1);'><input type='button' name='clear_stud'  value='������' onClick='javascript:tagall(\"student_sn[]\",0);'>
	$studentdata="<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size:9pt;' bordercolor='#111111'><tr bgcolor='#ffcccc'><td>";
	while(list($student_sn,$stud_id,$seme_num,$stud_name,$stud_sex)=$recordSet->FetchRow()) {
			$recno++;
			$bgcolor=($stud_sex==1)?"#DDFFDD":"#FFDDDD";
			$seme_num=sprintf("%02d",$seme_num);
			$checked=($student_sn==$_POST['student_sn'])?'checked':'';
			if($checked) $target_student="($seme_num)$stud_name";
			$studentdata.="<input type='radio' name='student_sn' value='$student_sn' onclick=\"this.form.submit();\" $checked>($seme_num)$stud_name";
			if($recno % 10 ==0) $studentdata.="<br>";
	}
	$studentdata.="</td></tr></table>";	
}

if($_POST['student_sn']){
	//���o�{�Ҥ����ب��ର�}�C
	$item_arr=array();
	$sql_select="select * from authentication_item WHERE (CURDATE() BETWEEN start_date AND end_date) order by end_date desc";
	$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while(!$res->EOF) {
		//sn code nature title start_date end_date
		$item_sn=$res->fields['sn'];
		$item_arr[$item_sn]['title']="[{$res->fields['nature']}]{$res->fields['code']}-{$res->fields['title']}";
		$item_arr[$item_sn]['period']="{$res->fields['start_date']}~{$res->fields['end_date']}";
		$res->MoveNext();
	}	
	
	//���o�ӥب��ର�}�C
	$subitem_arr=array();
	$sql_select="select * from authentication_subitem";
	$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while(!$res->EOF) {
		//sn item_sn code title grades bonus cooperate
		$subitem_sn=$res->fields['sn'];
		$subitem_arr[$subitem_sn]['item_sn']=$res->fields['item_sn'];
		$subitem_arr[$subitem_sn]['code']=$res->fields['code'];
		$subitem_arr[$subitem_sn]['title']=$res->fields['title'];
		$subitem_arr[$subitem_sn]['grades']=$res->fields['grades'];
		$subitem_arr[$subitem_sn]['bonus']=$res->fields['bonus'];
		$res->MoveNext();
	}
	
	//���o�iñ�{����
	$subitem_data="���iñ�{���ءG<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size:9pt;' bordercolor='#111111'>
	<tr bgcolor='#ccccff' align='center'><td><input type='checkbox' onclick='tagall(\"subitem_sn[]\",this.checked)'></td><td>�N��</td><td>�ӥئW��</td><td>�A�Φ~��</td><td>�{�Ҥ���϶�</td><td>�o�I</td><td>�{�Ҥ��</td><td>�{�Ҫ�</td><td>���Z</td><td>�Ƶ�</td></tr>";
	$allowed_arr=array();
		//����Q���v��
		$sql_select="select subitem_sn from authentication_empower WHERE empowered_sn=$my_sn AND year_seme='$curr_year_seme' AND class_id='$curr_class_id' order by subitem_sn";
		$res=$CONN->Execute($sql_select) or user_error("Ū���ӥإ��ѡI<br>$sql_select",256);
		while(!$res->EOF) {
			$allowed_arr[]=$res->fields['subitem_sn'];
			$res->MoveNext();
		}		
		//�A��ť��Z�Ū�(�u�n�{�ҲӥجO�ŦX���Ц~�Ū��N��J  �O�_���{�Ҥ��ѫ᭱���{���i��z��)
		if($my_class_id==$curr_class_id){
			foreach($subitem_arr as $subitem_sn=>$value){
				$my_grade=substr($my_class_id,0,-2);
				$grades=' ,'.$value['grades'].',';
				if(strpos($grades,",$my_grade,")) $allowed_arr[]=$subitem_sn;
			}
		}	
	//�z����ܥi�{�Ҳӥ�
	foreach($allowed_arr as $key=>$subitem_sn){
		$item_sn=$subitem_arr[$subitem_sn]['item_sn'];
		if($item_sn){  //���ϬO�{�Ҥ�������
			//���o�e�w�{�Ҿǥ͸��
			$sql="select * from authentication_record where sub_item_sn=$subitem_sn and student_sn={$_POST['student_sn']}";
			$rs=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
			$bonus=$subitem_arr[$subitem_sn]['bonus'];
			$title=$item_arr[$item_sn]['title'].' - ('.$subitem_arr[$subitem_sn]['code'].')'.$subitem_arr[$subitem_sn]['title'];
			$period=$item_arr[$item_sn]['period'];
			$code=$subitem_arr[$subitem_sn]['code'];
			$grades=$subitem_arr[$subitem_sn]['grades'];
			if($rs->recordcount()){
				
				$record_sn=$rs->fields['sn'];
				$java_script="onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#aaffaa';\" onMouseOut=\"this.style.backgroundColor='#cccccc';\" ondblclick='if(confirm(\"�T�w�n�M�� $target_student �� ($code)$title �{��ñ�O�H\")) { document.myform.cancel_sn.value=$record_sn; document.myform.submit(); }'";
				$subitem_data.="<tr bgcolor='#cccccc' align='center' $java_script><td>��</td><td>$code</td><td>$title</td><td>$grades</td><td>$period</td><td>$bonus</td><td>{$rs->fields[date]}</td><td>{$teacher_array[$rs->fields[teacher_sn]]}</td><td>{$rs->fields[score]}</td><td>{$rs->fields[note]}</td></tr>";
			} else $subitem_data.="<tr align='center'><td><input type='checkbox' name='subitem_sn[]' value='$subitem_sn'></td><td>$code</td><td>$title</td><td>$grades</td><td>$period</td><td>$bonus</td><td></td><td></td><td><input type='text' name='score[$subitem_sn]' size=5></td>
							<td><input type='text' name='note[$subitem_sn]' size=20></td></tr>";
		}
		$res->MoveNext();
	}
	$subitem_data.="<tr align='center'><td colspan=10>
	<input type='submit' style='border-width:1px; cursor:hand; color:white; background:#ff5555; font-size:16px; width:100%;' value='$go_caption' name='act' onclick='return check_select();'>
	</td></tr></table>";
}

echo "<form name='myform' method='post' action='$_SERVER[SCRIPT_NAME]'><input type='hidden' name='cancel_sn' value=''>$class_list $studentdata <br> $subitem_data</form>";
foot();
?>