<?php

// $Id:  $

//���o�]�w��
include_once "config.php";

sfs_check();

// ���O�d�d��
switch ($ha_checkary){
        case 2:
                ha_check();
                break;
        case 1:
                if (!check_home_ip()){
                        ha_check();
                }
                break;
}


//�q�X����
head("��L�ͲP���ɬ���");

//�Ҳտ��
print_menu($menu_p);

//�ˬd�O�_�}��
if (!$mystory){
   echo "�Ҳ��ܼƩ|���}�񥻥\��A�Ь��߾Ǯըt�κ޲z�̡I";
   exit;
}

//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();

//�ثe��w�Ǵ�
$seme_year_seme=sprintf('%03d%1d',$curr_year,$curr_seme);
$student_sn=$_SESSION['session_tea_sn'];
$stud_name=$_SESSION['session_tea_name'];

$menu=$_POST['menu'];

$min=$IS_JHORES?7:4;
$max=$IS_JHORES?9:6;


//����ǥͥ��Ǵ��NŪ�Z��
$query="select * from stud_seme where student_sn=$student_sn and seme_year_seme='$seme_year_seme'";
$res=$CONN->Execute($query);
$seme_class=$res->fields['seme_class'];
$seme_class_name=$res->fields['seme_class_name'];
$seme_num=$res->fields['seme_num'];
$stud_grade=substr($seme_class,0,-2);


//����ǥ;Ǵ��NŪ�Z��
$stud_seme_arr=array();
$table=array('stud_seme_import','stud_seme');
foreach($table as $key=>$value){
	$query="select * from $value where student_sn=$student_sn";
	$res=$CONN->Execute($query);
	while(!$res->EOF){
		$stud_grade=substr($res->fields['seme_class'],0,-2);
		$year_seme=$res->fields['seme_year_seme'];
		$semester=substr($year_seme,-1);	
		$seme_key=$stud_grade.'-'.$semester;
		$stud_seme_arr[$seme_key]=$year_seme;
		//������Ǵ��������
		if($year_seme==$seme_year_seme) {
			$curr_stud_grade=$stud_grade;
			$curr_seme_class=$res->fields['seme_class'];
			$curr_seme_num=$res->fields['seme_num'];
			$curr_seme_key=$seme_key;			
		}
		$res->MoveNext();
	}
}

//�i��Ƨ�
asort($stud_seme_arr);

//���Ϳ��
$memu_select="���ڬO $stud_name �A���Ǵ��NŪ�Z�šG $seme_class �A�y���G $seme_num �C<br>���ڭn�˵��γ]�w";
$menu_arr=array(1=>'�ͲP���ɬ���',2=>'�ͲP�Ը߬���',3=>'�a������');
foreach($menu_arr as $key=>$title){
	$checked=($menu==$key)?'checked':''; 
	$color=($menu==$key)?'#0000ff':'#000000'; 
	$memu_select.="<input type='radio' name='menu' value='$key' $checked onclick='this.form.submit();'><b><font color='$color'>$title</font></b>";
}

//�ˬd�O�_���i��g���
$guidance_months="[,$guidance_months,]";
$pos=strpos($guidance_months,$curr_month,1);
//$act=$menu?"<center><input type='submit' value='�x�s����' name='go' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")' style='border-width:1px; cursor:hand; color:white; background:#5555ff; font-size:20px; height=42'></center>":"";
switch($menu){
	case 1:
		//$act='';
		//���o�J�����
		$query="select * from career_guidance where student_sn=$student_sn";
		$res=$CONN->Execute($query);
	
		$guidance_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' id='AutoNumber1' width='100%'>
		<tr bgcolor='#ccccff' align='center'><td>NO.</td><td>���</td><td>��H</td><td>���ɭ��I�Ϋ�ĳ</td><td>���ɱЮv</td></tr>";
		if($res->RecordCount()){
			while(!$res->EOF){				
				$ii++;
				$emphasis=str_replace("\r\n",'<br>',$res->fields['emphasis']);
				$guidance_list.="<tr align='center'>
				<td>$ii</td>
				<td>{$res->fields['guidance_date']}</td>
				<td>{$res->fields['target']}</td>
				<td align='left'>$emphasis</td>
				<td>{$res->fields['teacher_name']}</td>
				</tr>";
				
				$res->MoveNext();
			}
		} else $guidance_list.="<tr align='center'><td colspan=7 height=24>���o�{�J���ͲP���ɬ����I</td></tr>";
		$guidance_list.='</table>';
		
		$showdata="$guidance_list";
		
		break;
	case 2:	
		if($_POST['go']=='�ק�'){
			$query="update career_consultation set seme_key='{$_POST['seme_key']}',teacher_name='{$_POST['teacher_name']}',emphasis='{$_POST['emphasis']}',memo='{$_POST['memo']}' where sn={$_POST['edit_sn']}";
			$res=$CONN->Execute($query) or die("SQL���~:$query");
			$_POST['edit_sn']=0;
		} elseif($_POST['go']=='�R��'){
			$query="delete from career_consultation where sn={$_POST['edit_sn']}";
			$res=$CONN->Execute($query) or die("SQL���~:$query");
			$_POST['edit_sn']=0;
		} elseif($_POST['go']=='�s�W'){
			$query="insert into career_consultation set student_sn=$student_sn,seme_key='$curr_seme_key',consultation_date=now()";
			$res=$CONN->Execute($query) or die("SQL���~:$query");
		}	
		
		//$act='';
		//��������Y
		$my_act=$pos?"<input type='submit' name='go' value='�s�W'><input type='hidden' name='edit_sn' value=''><input type='hidden' name='add' value=''>":"";
		$consultation_list="$my_act
			<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' id='AutoNumber1' width=100%>
			<tr align='center' bgcolor='#ffcccc'><td>NO.</td><td>�~��</td><td>���</td><td>�z�Ըߪ��v��</td><td>�Q�׭��I�ηN��</td><td>�Ƶ�</td>";
		
		//����J���Ը߬���
		$query="select * from career_consultation where student_sn=$student_sn order by seme_key";
		$res=$CONN->Execute($query) or die("SQL���~:$query");
		if($res->RecordCount()){
			while(!$res->EOF){
				$ii++;
				$sn=$res->fields['sn'];
				if($_POST['edit_sn']==$sn) {
					
					$seme_radio='';
					foreach($stud_seme_arr as $seme_key=>$year_seme){
						$checked=($seme_key==$res->fields['seme_key'])?'checked':'';
						$seme_radio.="<input type='radio' name='seme_key' value='$seme_key' $checked>($seme_key) $year_seme <br>";
					}
					
					$consultation_list.="<tr align='center' bgcolor='#ffffcc'>
						<td>$ii<input type='hidden' name='del_sn' value='{$_POST['edit_sn']}'>
						<br><input type='submit' value='�ק�' name='go' onclick='document.myform.edit_sn.value=\"$sn\";return confirm(\"�T�w�n\"+this.value+\"?\")'>
						<br><input type='submit' value='�R��' name='go' onclick='document.myform.edit_sn.value=\"$sn\"; return confirm(\"�T�w�n\"+this.value+\"?\")'>
						<br><input type='reset' value='����' onclick='this.form.submit();'>
						</td>
						<td>$seme_radio</td>
						<td><input type='text' name='consultation_date' value='{$res->fields['consultation_date']}' size=8></td>
						<td><input type='text' name='teacher_name' value='{$res->fields['teacher_name']}' size=10></td>
						<td><textarea name='emphasis' style='border-width:1px; color:brown; width=100%; height=100%;'>{$res->fields['emphasis']}</textarea></td>
						<td><textarea name='memo' style='border-width:1px; color:brown; width=100%; height=100%;'>{$res->fields['memo']}</textarea></td>
						</tr>";
				} else {
					$memo=str_replace("\r\n",'<br>',$res->fields['memo']);
					$emphasis=str_replace("\r\n",'<br>',$res->fields['emphasis']);
					$java_script=$pos?"onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#ccccff';\" onMouseOut=\"this.style.backgroundColor='#ffffff';\" ondblclick='document.myform.edit_sn.value=\"$sn\"; document.myform.submit();'":"";
					$consultation_list.="<tr align='center' $java_script>
						<td>$ii</td>
						<td>{$res->fields['seme_key']}</td>
						<td>{$res->fields['consultation_date']}</td>
						<td>{$res->fields['teacher_name']}</td>						
						<td align='left'>$emphasis</td>
						<td align='left'>$memo</td>
						</tr>";	
				}
				$res->MoveNext();
			}
		} else $consultation_list.="<tr align='center'><td colspan=7 height=24>���o�{�ͲP���ɬJ���Ը߬����I</td></tr>";
		$consultation_list.="</table>";
		
		$showdata="<br>$consultation_list";
	
		break;
	case 3:	
		$items=array(1=>'�ڪ������G��',2=>'�U���߲z����',3=>'�ǲߦ��G�ίS���{',4=>'�ͲP���ɬ���',5=>'�ͲP�ξ㭱���[',6=>'�ͲP�o�i�W����');
		
		if($_POST['go']=='�ק�'){
			$items_got=serialize($_POST['items']);
			$query="update career_parent set seme_key='{$_POST['seme_key']}',items='$items_got',suggestion='{$_POST['suggestion']}',suggestion_date='{$_POST['suggestion_date']}' where sn={$_POST['edit_sn']}";
			$res=$CONN->Execute($query) or die("SQL���~:$query");
			$_POST['edit_sn']=0;
		} elseif($_POST['go']=='�R��'){
			$query="delete from career_parent where sn={$_POST['edit_sn']}";
			$res=$CONN->Execute($query) or die("SQL���~:$query");
			$_POST['edit_sn']=0;
		} elseif($_POST['go']=='�s�W'){
			$query="insert into career_parent set student_sn=$student_sn,seme_key='$curr_seme_key',suggestion_date=now()";
			$res=$CONN->Execute($query) or die("SQL���~:$query");
		}
		
		
		//$act='';
		//��������Y
		$my_act=$pos?"<input type='submit' name='go' value='�s�W'><input type='hidden' name='edit_sn' value=''><input type='hidden' name='add' value=''>":"";
		$parent_list="$my_act
			<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' id='AutoNumber1' width=100%>
			<tr align='center' bgcolor='#ffcccc'><td>NO.</td><td>�~��-�Ǵ�</td><td>���</td><td>�Ѿ\���</td><td>���Ĥl�����y�Ϋ�ĳ</td><td>�ˮv���q�ɮvñ�O</td>";
		
		//����J���Ը߬���
		$query="select * from career_parent where student_sn=$student_sn order by seme_key";
		$res=$CONN->Execute($query) or die("SQL���~:$query");
		if($res->RecordCount()){
			while(!$res->EOF){
				$ii++;
				//�Ѿ\����٭쬰�}�C
				$items_array=unserialize($res->fields['items']);
				
				$sn=$res->fields['sn'];
				if($_POST['edit_sn']==$sn){					
					$seme_radio='';
					foreach($stud_seme_arr as $seme_key=>$year_seme){
						$checked=($seme_key==$res->fields['seme_key'])?'checked':'';
						$seme_radio.="<input type='radio' name='seme_key' value='$seme_key' $checked>($seme_key) $year_seme <br>";
					}
					$items_checkox="";					
					foreach($items as $key=>$value){
						$color=$items_array[$key]?'#ff0000':'#000000';
						$checked=$items_array[$key]?'checked':'';
						$items_checkox.="<input type='checkbox' name='items[$key]' value='1' $checked><font color='$color'>$value</font><br>";
					}
					
					$parent_list.="<tr align='center' bgcolor='#ffffcc'>
						<td>$ii<input type='hidden' name='del_sn' value='{$_POST['edit_sn']}'>
						<br><input type='submit' value='�ק�' name='go' onclick='document.myform.edit_sn.value=\"$sn\";return confirm(\"�T�w�n\"+this.value+\"?\")'>
						<br><input type='submit' value='�R��' name='go' onclick='document.myform.edit_sn.value=\"$sn\"; return confirm(\"�T�w�n\"+this.value+\"?\")'>
						<br><input type='reset' value='����' onclick='this.form.submit();'>
						</td>
						<td>$seme_radio</td>
						<td><input type='text' name='suggestion_date' value='{$res->fields['suggestion_date']}' size=15></td>
						<td align='left'>$items_checkox</td>
						<td><textarea name='suggestion' style='border-width:1px; color:brown; width=100%; height=100%;'>{$res->fields['suggestion']}</textarea></td>
						<td>{$res->fields['tutor_confirm']}<br>{$res->fields['tutor_name']}-{$res->fields['confirm_date']}</td>		
						</tr>";
				} else {				
					$items_list='';
					foreach($items as $key=>$value){
						$color=$items_array[$key]?'#ff0000':'#000000';
						$checked=$items_array[$key]?'��':'��';
						$items_list.="$checked $value<br>";
					}
					$items_list.="";
					
					$suggestion=str_replace("\r\n",'<br>',$res->fields['suggestion']);
					$tutor_confirm=str_replace("\r\n",'<br>',$res->fields['tutor_confirm']);
					$java_script=$pos?"onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#ccccff';\" onMouseOut=\"this.style.backgroundColor='#ffffff';\" ondblclick='document.myform.edit_sn.value=\"$sn\"; document.myform.submit();'":"";
					$parent_list.="<tr align='center' $java_script>
						<td>$ii</td>
						<td>{$res->fields['seme_key']}</td>
						<td>{$res->fields['suggestion_date']}</td>
						<td align='left'>$items_list</td>						
						<td align='left'>$suggestion</td>						
						<td align='left'>{$res->fields['tutor_confirm']}<br>{$res->fields['tutor_name']}-{$res->fields['confirm_date']}</td>						
						</tr>";	
				}
				$res->MoveNext();
			}
		} else $parent_list.="<tr align='center'><td colspan=7 height=24>���o�{�ͲP���ɮa�������y�Ϋ�ĳ�����I</td></tr>";
		$parent_list.="</table>";
		
		$showdata="<br>$parent_list";
		
		break;
}

$main="<font size=2><form method='post' action='$_SERVER[SCRIPT_NAME]' name='myform'>$memu_select $showdata<br>$act</form></font><br>���Ǯճ]�w�i��g����G$m_arr[guidance_months]";

echo $main;

foot();

?>
