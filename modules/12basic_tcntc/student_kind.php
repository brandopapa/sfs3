<?php
include "config.php";

sfs_check();

//�q�X����
head("���W����");
print_menu($menu_p);

//�Ǵ��O
$work_year_seme=$_REQUEST['work_year_seme'];
if($work_year_seme=='') $work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());
$academic_year=substr($curr_year_seme,0,-1);
$work_year=substr($work_year_seme,0,-1);
$session_tea_sn=$_SESSION['session_tea_sn'];

$stud_class=$_REQUEST['stud_class'];
$selected_stud=$_POST['selected_stud'];
$edit_sn=$_POST['edit_sn'];

$show_zero=$_POST['show_zero']?'checked':'';

if($_POST['act']=='����') { $edit_sn=0;	$_POST['batch']=''; }

if($_POST['act']=='�ק�'){
	$sql="UPDATE 12basic_tcntc SET kind_id='{$_POST[kind_id]}',disability_id='{$_POST[disability_id]}',free_id='{$_POST[free_id]}',id_memo='{$_POST[id_memo]}',language_certified='{$_POST[language_id]}' WHERE academic_year=$work_year AND student_sn=$edit_sn AND editable='1'";
	$res=$CONN->Execute($sql) or user_error("��s���ѡI<br>$sql",256);
	$edit_sn=0;	
}

if($_POST['act']=='�妸��s'){
	foreach($_POST['batch'] as $student_sn=>$data) {
		$sql="UPDATE 12basic_tcntc SET kind_id='{$data[kind_id]}',disability_id='{$data[disability_id]}',free_id='{$data[free_id]}',id_memo='{$data[id_memo]}',language_certified='{$data[language_id]}' WHERE academic_year=$work_year AND student_sn=$student_sn AND editable='1'";
		$res=$CONN->Execute($sql) or user_error("��s���ѡI<br>$sql",256);
	}
	$edit_sn=0;
	$_POST['batch']='';
}

//��V������
$linkstr="work_year_seme=$work_year_seme&stud_class=$stud_class";
echo print_menu($MENU_P,$linkstr);

//���o�~�׻P�Ǵ����U�Կ��
$recent_semester=get_recent_semester_select('work_year_seme',$work_year_seme);

//��ܯZ��
$class_list=get_semester_graduate_select('stud_class',$work_year_seme,$graduate_year,$stud_class);

//if($work_year==$academic_year) $tool_icon.="<font size=1>���X�{��������ЮɡA�i�֫���U�i�i��ק</font>";
$tool_icon="<input type='checkbox' name='show_zero' value=1 $show_zero onclick=\"this.form.submit();\"><font size=2 color='green'>��ܡu(0)�@��͡v</font>";
$main="<form name='myform' method='post' action='$_SERVER[PHP_SELF]'><input type='hidden' name='batch' value=''><input type='hidden' name='edit_sn' value='$edit_sn'>$recent_semester $class_list $tool_icon 
<table border='2' cellpadding='3' cellspacing='0' border-collapse: collapse' bordercolor='#111111' id='AutoNumber1' width=100%>";

if($stud_class)
{
	//���o�ǥͨ����C��
	$kinddata=array();
	$type_select="SELECT d_id,t_name FROM sfs_text WHERE t_kind='stud_kind' AND d_id>0 order by t_order_id";
	$recordSet=$CONN->Execute($type_select) or user_error("Ū�����ѡI<br>$type_select",256);
	while(list($d_id,$t_name)=$recordSet->FetchRow()) {
		$kinddata[$d_id]=$t_name;
	}
	
	//����J��������Ӫ�
	$sql="SELECT kind_data,disability_data,free_data FROM 12basic_kind WHERE year_seme='$work_year_seme'";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
	$kind_data=unserialize($res->fields[0]);
	$disability_data=unserialize($res->fields[1]);
	$free_data=unserialize($res->fields[2]);

	//���o���w�Ǧ~�w�g�}�C���ǥͲM��
	$student_list_array=get_student_list($work_year);

	//�ˬd�O�_���i�ק�������ѻP�K�վǥ�
	$editable_sn_array=get_editable_sn($work_year);

	//���o���w�Ǧ~�w�g�}�C���ǥͨ���	
	$id_array=get_student_id($work_year);

	//���ostud_base���Z�žǥͦC��þڥH�P�esql��ӫ����
	$stud_select="SELECT a.student_sn,a.seme_class,a.seme_num,b.stud_name,b.stud_sex,b.stud_id,b.stud_kind,b.stud_study_year,b.stud_kind FROM stud_seme a inner join stud_base b on a.student_sn=b.student_sn WHERE a.seme_year_seme='$work_year_seme' AND a.seme_class='$stud_class' AND b.stud_study_cond in (0,5,15) ORDER BY a.seme_num";
	$recordSet=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);
	//���ϬO��~�׫K�i�H�妸�s��
	if($work_year==$academic_year and !$_POST['batch']) $java_script="onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#aaaaff';\" onMouseOut=\"this.style.backgroundColor='#ff8888';\" ondblclick='document.myform.batch.value=\"1\"; document.myform.submit();'";
	$studentdata="<tr align='center' bgcolor='#ff8888' $java_script><td width=80>�Ǹ�</td><td width=50>�Z��</td><td width=50>�y��</td><td width=120>�m�W</td><td width=$pic_width>�j�Y��</td><td>SFS3�����O���������O</td><td>���W����</td><td>�ڻy�{��</td><td>���߻�ê</td><td>�C�����~</td><td>�Ƶ�</td>";
	while(list($student_sn,$seme_class,$seme_num,$stud_name,$stud_sex,$stud_id,$stud_kind,$stud_study_year,$stud_kind)=$recordSet->FetchRow()) {
		//���S�����O���~�C�X
		$stud_kind=substr(str_replace(',0,','',$stud_kind),0,-1);
		$my_kind_arr=explode(',',$stud_kind);
				
		$my_pic=$pic_checked?get_pic($stud_study_year,$stud_id):'';
		$seme_num=sprintf('%02d',$seme_num);
		$stud_sex_color=($stud_sex==1)?"#CCFFCC":"#FFDDDD";
		$my_kind_id=$id_array[$student_sn]['kind_id'];
			$my_kind="($my_kind_id){$stud_kind_arr[$my_kind_id]}";
			if(!$show_zero and !$my_kind_id) $my_kind='';
		$my_disability_id=$id_array[$student_sn]['disability_id'];
			$my_disability="($my_disability_id){$stud_disability_arr[$my_disability_id]}";
			if(!$show_zero and !$my_disability_id) $my_disability='';
		$my_free_id=$id_array[$student_sn]['free_id'];
			$my_free="($my_free_id){$stud_free_arr[$my_free_id]}";
			if(!$show_zero and !$my_free_id) $my_free='';
		//***
		$my_language_certified=$id_array[$student_sn]['language_certified']?'�O':'';
		//***
/*
		$kind_id=$stud_kind_arr[$my_kind_id];
		$disability_id=$stud_disability_arr[$my_disability_id];
		$free_id=$stud_free_arr[$my_free_id];
*/
		$id_memo=$id_array[$student_sn]['id_memo'];
		$action='';		
		$editable=array_key_exists($student_sn,$editable_sn_array)?1:0;
		$stud_sex_color=$editable?$stud_sex_color:$uneditable_bgcolor;
		$java_script='';
		
		$kind_id_data='';
		foreach($my_kind_arr as $id){
			if($id){
				$color='#aaaaaa';
				if($kind_data[$id]) $color='#0000ff'; elseif($disability_data[$id]) $color='#ff0000'; elseif($free_data[$id]) $color='#aa00aa';
				$kind_id_data.="<li><font color='$color'>($id)$kinddata[$id]</font></li>";
			}
		}
		
		//�妸�s��
		if($_POST['batch']){
			if(array_key_exists($student_sn,$editable_sn_array) and array_key_exists($student_sn,$student_list_array)){
				//���͹��������W����select����
				$my_kind="<select name='batch[$student_sn][kind_id]'>";
				foreach($stud_kind_arr as $kind_key=>$kind_value){
					$selected='';
					$bg_color='';
					if($kind_key==$my_kind_id){
						$selected='selected';
						$bg_color="style='background-color: #ffcccc;'";
					}
					$my_kind.="<option value='$kind_key' $selected $bg_color>($kind_key) $kind_value</option>";
				}
				$my_kind.="</select>";	

				//���ͱڻy�{��select����
				$selected=$my_language_certified?'selected':'';
				$my_language_certified="<select name='batch[$student_sn][language_id]'><option value='0' selected></option><option value='1' $selected>�O</option></select>";

				//���͹��������߻�êselect����
				$my_disability="<select name='batch[$student_sn][disability_id]'>";
				foreach($stud_disability_arr as $disability_key=>$disability_value){
					$selected='';
					$bg_color='';
					if($disability_key==$my_disability_id){
						$selected='selected';
						$bg_color="style='background-color: #ffcccc;'";
					}
					$my_disability.="<option value='$disability_key' $selected $bg_color>($disability_key) $disability_value</option>";
				}
				$my_disability.="</select>";	
				
				//���͹������C�����~select����
				$my_free="<select name='batch[$student_sn][free_id]'>";
				foreach($stud_free_arr as $free_key=>$free_value){
					$selected='';
					$bg_color='';
					if($free_key==$my_free_id){
						$selected='selected';
						$bg_color="style='background-color: #ffcccc;'";
					}
					$my_free.="<option value='$free_key' $selected $bg_color>($free_key) $free_value</option>";
				}
				$my_free.="</select>";

				
				//���ͳƵ���
				$id_memo="<input type='text' size=10 name='batch[$student_sn][id_memo]' value='$id_memo'";
			}			
		} else {
			if($student_sn==$edit_sn){
				//���͹��������W����select����
				$my_kind="<select name='kind_id'>";
				foreach($stud_kind_arr as $kind_key=>$kind_value){
					$selected='';
					$bg_color='';
					if($kind_key==$my_kind_id){
						$selected='selected';
						$bg_color="style='background-color: #ffcccc;'";
					}
					$my_kind.="<option value='$kind_key' $selected $bg_color>($kind_key) $kind_value</option>";
				}
				$my_kind.="</select>";
				
				//���ͱڻy�{��select����
				$selected=$my_language_certified?'selected':'';
				$my_language_certified="<select name='language_id'><option value='0' selected></option><option value='1' $selected>�O</option></select>";
				
				

				//���͹��������߻�êselect����
				$my_disability="<select name='disability_id'>";
				foreach($stud_disability_arr as $disability_key=>$disability_value){
					$selected='';
					$bg_color='';
					if($disability_key==$my_disability_id){
						$selected='selected';
						$bg_color="style='background-color: #ffcccc;'";
					}
					$my_disability.="<option value='$disability_key' $selected $bg_color>($disability_key) $disability_value</option>";
				}
				$my_disability.="</select>";	
				
				//���͹������C�����~select����
				$my_free="<select name='free_id'>";
				foreach($stud_free_arr as $free_key=>$free_value){
					$selected='';
					$bg_color='';
					if($free_key==$my_free_id){
						$selected='selected';
						$bg_color="style='background-color: #ffcccc;'";
					}
					$my_free.="<option value='$free_key' $selected $bg_color>($free_key) $free_value</option>";
				}
				$my_free.="</select>";
				
				//���ͳƵ���
				$id_memo="<input type='text' size=10 name='id_memo' value='$id_memo'";

				//�ʧ@���s
				$action="<br><br><input type='submit' name='act' value='�ק�' onclick='return confirm(\"�T�w�n�ק� $stud_name �����W�������?\")'> <input type='submit' name='act' value='����' onclick='document.myform.edit_sn.value=0;'>";		
				$stud_sex_color='#ffffaa';
			} else {		
				if(array_key_exists($student_sn,$student_list_array)){
					$editable=array_key_exists($student_sn,$editable_sn_array)?1:0;
					$stud_sex_color=$editable?$stud_sex_color:$uneditable_bgcolor;
					$java_script=($work_year==$academic_year and $editable and $kind_editable)?"onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#aaaaff';\" onMouseOut=\"this.style.backgroundColor='$stud_sex_color';\" ondblclick='document.myform.edit_sn.value=\"$student_sn\"; document.myform.submit();'":'';
				} else { $stud_sex_color='#aaaaaa'; }
			}
		}
		$stud_sex_color=array_key_exists($student_sn,$student_list_array)?$stud_sex_color:'#aaaaaa';		
		$studentdata.="<tr align='center' bgcolor='$stud_sex_color' $java_script><td>$stud_id</td><td>$seme_class</td><td>$seme_num</td><td>$stud_name</td><td>$my_pic</td><td align='left'>$kind_id_data</td><td align='left'><font color='#0000ff'>$my_kind</font></td><td align='center'>$my_language_certified</td><td align='left'><font color='#ff0000'>$my_disability</font></td><td align='left'><font color='#aa00aa'>$my_free</font></td><td align='left'>$id_memo $action</td></tr>";
	}
	if($_POST['batch']) $studentdata.="<tr align='center'><td colspan=10><input type='submit' name='act' value='�妸��s' onclick='return confirm(\"�T�w�n�ק糧�Z�ǥͩҦ����������?\")'> <input type='submit' name='act' value='����'></td></tr>";
}

//��ܫʦs���A��T
echo get_sealed_status($work_year).'<br>';

echo $main.$studentdata."</form></table>";
foot();
?>