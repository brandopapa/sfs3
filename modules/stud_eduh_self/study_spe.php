<?php

// $Id:  $

//���o�]�w��
include_once "config.php";
include "../../include/sfs_case_score.php";

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
head("�ǲߦ��G�ίS���{");

//�Ҳտ��
print_menu($menu_p);

//�ˬd�O�_�}��
if (!$study_spe){
   echo "�Ҳ��ܼƩ|���}�񥻥\��A�Ь��߾Ǯըt�κ޲z�̡I";
   exit;
}

//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();

//�ثe��w�Ǵ�
$seme_year_seme=sprintf('%03d%d',$curr_year,$curr_seme);
$student_sn=$_SESSION['session_tea_sn'];
$stud_name=$_SESSION['session_tea_name'];

$menu=$_POST['menu'];

$level_array=array(1=>'���',2=>'����B�O�W��',3=>'�ϰ�ʡ]�󿤥��^',4=>'�١B���ҥ�',5=>'�����ϡ]�m��^',6=>'�դ�');
$squad_array=array(1=>'�ӤH��',2=>'������');

//�x�s�����B�z
if($_POST['go']=='�x�s����'){
	$content=serialize($_POST['ponder']);
	//�ˬd�O�_�w���¬���
	$query="select sn from career_self_ponder where student_sn=$student_sn and id='$menu'";
	$res=$CONN->Execute($query) or die("SQL���~:$query");
	$sn=$res->fields[0];
	if($sn) $query="update career_self_ponder set id='$menu',content='$content' where sn=$sn";
		else $query="insert into career_self_ponder set student_sn=$student_sn,id='$menu',content='$content'";
		$res=$CONN->Execute($query) or die("SQL���~:$query");
}


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
//$memu_select="���ڬO $stud_name �A���Ǵ��NŪ�Z�šG $curr_seme_class �A�y���G $curr_seme_num �C<br>���ڭn�˵� <select name='menu' onchange='this.form.submit();'>";
$memu_select="���ڬO $stud_name �A���Ǵ��NŪ�Z�šG $curr_seme_class �A�y���G $curr_seme_num �C<br>���ڭn�˵��G";
$menu_arr=array('3-1'=>'�ڪ��ǲߪ�{','3-2'=>'�ڪ��g���]�F���B���Ρ^','3-3'=>'�ѻP�U���v�ɦ��G','3-4'=>'�欰��{���g����','3-5'=>'�A�Ⱦǲ߬���','3-6'=>'�ͲP�ձ����ʬ���');

foreach($menu_arr as $key=>$title){
	$selected=($menu==$key)?'checked':''; 
	$color=($menu==$key)?'#0000ff':'#000000'; 
	$memu_select.="<input type='radio' name='menu' onclick='this.form.submit();' value='$key' $selected><b><font color='$color'>$title</font></b></option>";
}

$study_spe_months="[,$study_spe_months,]";
$pos=strpos($study_spe_months,$curr_month,1);

//���o�J���ҿﶵ�ئۧڬ٫���
if($menu){
	$act=$pos?"<input type='submit' value='�x�s����' name='go' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")'>":"";
	$query="select * from career_self_ponder where student_sn=$student_sn and id='$menu'";
	$res=$CONN->Execute($query);
	$ponder_array=unserialize($res->fields['content']);
}

switch($menu){
	case '3-1':
		//���o���ǲߦ��Z���
		$fin_score=cal_fin_score(array($student_sn),$stud_seme_arr);

		$link_ss=array("chinese"=>"�y��-���","english"=>"�y��-�^�y","math"=>"�ƾ�","social"=>"���|","nature"=>"�۵M�P�ͬ����","art"=>"���N�P�H��","health"=>"���d�P��|","complex"=>"��X����");
		//��������Y
		$study_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' id='AutoNumber1' width=100%>
				<tr align='center' bgcolor='#ffcccc'><td>�~��</td><td>�Ǵ�</td>";
		foreach($link_ss as $key=>$value) $study_list.="<td>$value</td>";
		$study_list.="<td>���ڪ��ǲߪ�{�A�ڻ{��</td></tr>";
		
		//���e
		foreach($stud_seme_arr as $seme_key=>$year_seme){			
			$bgcolor=($career_previous or $curr_seme_key==$seme_key)?'#ffdfdf':'#cfefef';
			$readonly=($career_previous or $curr_seme_key==$seme_key)?'':'readonly';
			$study_list.="<tr align='center'><td>$seme_key</td><td>$year_seme</td>";
			foreach($link_ss as $key=>$value) $study_list.="<td>{$fin_score[$student_sn][$key][$year_seme]['score']}</td>";
			if($pos)
				$study_list.="<td><textarea name='ponder[$seme_key]' style='border-width:1px; color:brown; background:$bgcolor; font-size:11px; width=100%; height=100%;' $readonly>{$ponder_array[$seme_key]}</textarea></td></tr>";
			else {
				$study_list.="<td align='left'>".str_replace("\r\n","<br>",$ponder_array[$seme_key])."</td></tr>";
			}
		}
		$study_list.="</table>";
		
		
		//���o�Ш|�|�Ҧ��Z���
		$exam_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' id='AutoNumber1' width=100%>
		<tr bgcolor='#c4d9ff' align='center'><td>�����ɶ�</td><td>���</td><td>�^�y</td><td>�ƾ�</td><td>�۵M</td><td>���|</td><td>�g�@����</td></tr>";
		$query="select * from career_exam where student_sn=$student_sn order by update_time desc";
		$res=$CONN->Execute($query);
		if($res->RecordCount()){
			$exam_list.="<tr align='center'>
				<td>* {$res->fields['update_time']} *</td>
				<td>{$res->fields['c']}</td>
				<td>{$res->fields['e']}</td>
				<td>{$res->fields['m']}</td>
				<td>{$res->fields['n']}</td>
				<td>{$res->fields['s']}</td>
				<td>{$res->fields['w']}</td>
				</tr>";			
			} else $exam_list.="<tr align='center'><td colspan=7>���o�{���ͪ��Ш|�|�Ҧ��Z���</td></tr>";
		$exam_list.="</table>";
		
		//���o��A�ন�Z���
		$fitness_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' id='AutoNumber1' width=100%>
			<tr bgcolor='#c4d9ff' align='center'>
			<td>�~��</td><td>�Ǵ�</td>
			<td>����<br>(cm)</td>
			<td>�魫<br>(kg)</td>
			<td>BMI����<br>(kg/m<sup>2</sup>)</td>
			<td>�˴����</td>
			<td>����~��</td>
			<td>�����e�s<br>(cm) [%]</td>
			<td>���װ_��<br>(��) [%]</td>
			<td>�ߩw����<br>(cm) [%]</td>
			<td>�ߪ;A��<br>(��) [%]</td>
			<td>�~��</td>
			<td>����</td>
			</tr>";
		$query="select * from fitness_data where student_sn=$student_sn order by c_curr_seme";
		$res=$CONN->Execute($query);
		while(!$res->EOF){
			$c_curr_seme=$res->fields['c_curr_seme'];
			$seme_key=array_search($c_curr_seme,$stud_seme_arr);
			//�P�w����
			$g=0;
			$s=0;
			$c=0;
			$passed=0;
			for($i=1;$i<=4;$i++) {
				$field_name='prec'.$i;
				if($res->fields[$field_name]>=85) $g++;
				if($res->fields[$field_name]>=75) $s++;
				if($res->fields[$field_name]>=50) $c++;
				if($res->fields[$field_name]>=25) $passed++;  //�q�L���e�з�  �{���{�]��25%�H�W
			}				
			$medal='';
			if($g==4) $medal="��"; elseif($s==4) $medal="�� "; elseif($c==4) $medal="��";
			$fitness_list.="<tr align='center'>
				<td>$seme_key</td><td>$c_curr_seme</td>
				<td>{$res->fields['tall']}</td>
				<td>{$res->fields['weigh']}</td>
				<td>{$res->fields['bmt']}</td>
				<td>{$res->fields['organization']}</td>
				<td>{$res->fields['test_y']}-{$res->fields['test_m']}</td>
				<td>{$res->fields['test1']} [{$res->fields['prec1']}]</td>
				<td>{$res->fields['test2']} [{$res->fields['prec2']}]</td>
				<td>{$res->fields['test3']} [{$res->fields['prec3']}]</td>
				<td>{$res->fields['test4']} [{$res->fields['prec4']}]</td>
				<td>{$res->fields['age']}</td>
				<td>$medal</td>
				</tr>";			
			$res->MoveNext();
		}
		$fitness_list.="</table>";		
		
		$showdata="<br><br>1.�U���ǲߦ��Z $study_list<br>2.�ꤤ�Ш|�|�Ҫ�{ $exam_list<br>3.��A���˴���{ $fitness_list";		
		
		break;
	case '3-2':
		//��������Y
		$assistant_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' id='AutoNumber1' width=100%>
			<tr align='center' bgcolor='#ffcccc'><td>�~��</td><td>�Ǵ�</td><td>����F��</td><td>����p�Ѯv</td><td>�Ƶ�</td><td>�ۧڬ٫�</td>";
		//���e
		foreach($stud_seme_arr as $seme_key=>$year_seme){
			if($pos and $cadre_result) {
				$bgcolor=($career_previous or $curr_seme_key==$seme_key)?'#ffdfdf':'#cfefef';
				$readonly=($career_previous or $curr_seme_key==$seme_key)?'':'readonly';
				$assistant_list.="<tr align='center'><td>$seme_key</td><td>$year_seme</td>
				<td>1. <input type='text' name='ponder[$seme_key][1][1]' value='{$ponder_array[$seme_key][1][1]}' style='border-width:1px; color:brown; background:$bgcolor;' $readonly>�@2. <input type='text' name='ponder[$seme_key][1][2]' value='{$ponder_array[$seme_key][1][2]}' style='border-width:1px; color:brown; background:$bgcolor;' $readonly></td>
				<td>1. <input type='text' name='ponder[$seme_key][2][1]' value='{$ponder_array[$seme_key][2][1]}' style='border-width:1px; color:brown; background:$bgcolor;' $readonly>�@2. <input type='text' name='ponder[$seme_key][2][2]' value='{$ponder_array[$seme_key][2][2]}' style='border-width:1px; color:brown; background:$bgcolor;' $readonly></td>
				<td><input type='text' name='ponder[$seme_key][memo]' value='{$ponder_array[$seme_key][memo]}' style='border-width:1px; color:brown; background:$bgcolor;' $readonly></td>
				<td><textarea name='ponder[$seme_key][data]' style='border-width:1px; color:brown; background:$bgcolor; font-size:11px; width=100%; height=100%;' $readonly>{$ponder_array[$seme_key][data]}</textarea></td></tr>";
			} else {
				$assistant_list.="<tr align='left'><td align='center'>$seme_key</td><td align='center'>$year_seme</td>
				<td>(1){$ponder_array[$seme_key][1][1]}�@(2){$ponder_array[$seme_key][1][2]}</td>
				<td>(1){$ponder_array[$seme_key][2][1]}�@(2){$ponder_array[$seme_key][2][2]}</td>
				<td>{$ponder_array[$seme_key][memo]}</td>";
				$assistant_list.="<td>".str_replace("\r\n","<br>",$ponder_array[$seme_key][data])."</td></tr>";			
			}
		}
		$assistant_list.="</table>";

		
		//���θ��
		//��������Y
		$club_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' id='AutoNumber1' width=100%>
		<tr align='center' bgcolor='#ffcccc'><td>�~��</td><td>�Ǵ�</td><td>���ΦW��</td><td>���Z</td><td>���¾��</td><td>�Ѯv���y</td><td>�ۧڬ٫�</td>";
	
		$query="select * from association where student_sn=$student_sn order by seme_year_seme";
		$res=$CONN->Execute($query);
		if($res->RecordCount()){
			while(!$res->EOF){
				$seme_year_seme=$res->fields['seme_year_seme'];
				$seme_key=array_search($seme_year_seme,$stud_seme_arr);
				$club_score=$res->fields['score']?$res->fields['score']:'--';
				$feed_back=str_replace("\r\n",'<br>',$res->fields['stud_feedback']);
				$club_list.="<tr align='center'>
				<td>$seme_key</td><td>$seme_year_seme</td>
				<td>{$res->fields['association_name']}</td>
				<td>{$club_score}</td>
				<td>{$res->fields['stud_post']}</td>
				<td align='left'>{$res->fields['description']}</td>
				<td align='left'>$feed_back</td>
				</tr>";			
				$res->MoveNext();
			}
		} else $club_list.="<tr align='center'><td colspan=7 height=24>���o�{���ά��ʬ����I</td></tr>";
		$club_list.="</table>";
		
		$showdata="<br><br>1.�F���G��g���g��������թʡB�Z�ŷF���ΦU���]��^�p�Ѯv¾�ȡA���������@�Ǵ��H�W(�t���@�Ǵ�)�C	$assistant_list<br>2.���ΡG�ѥ[�Ǯթ�ҵ{���νҫ�]�t����δH�����^��I�����ΡA���@�Ǵ�/20�p�ɡC $club_list";
		
		break;
	case '3-3':
		if($_POST['go']=='�ק�'){
			$query="update career_race set level={$_POST['level']},squad={$_POST['squad']},name='{$_POST['name']}',rank='{$_POST['rank']}',certificate_date='{$_POST['certificate_date']}',sponsor='{$_POST['sponsor']}',memo='{$_POST['memo']}' where sn={$_POST['edit_sn']}";
			$res=$CONN->Execute($query) or die("SQL���~:$query");
			$_POST['edit_sn']=0;
		} elseif($_POST['go']=='�R��'){
			$query="delete from career_race where sn={$_POST['edit_sn']}";
			$res=$CONN->Execute($query) or die("SQL���~:$query");
			$_POST['edit_sn']=0;
		} elseif($_POST['go']=='�s�W'){
			$query="insert into career_race set student_sn=$student_sn,level=1,squad=1,name='---------',rank='------',certificate_date=now(),sponsor='------'";
			$res=$CONN->Execute($query) or die("SQL���~:$query");
		}	
		
		$act=($pos and $race_result)?" <input type='submit' name='go' value='�s�W'>":"";
		//��������Y
		$race_list="<input type='hidden' name='edit_sn' value=''><input type='hidden' name='add' value=''>
			<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' id='AutoNumber1' width=100%>
			<tr align='center' bgcolor='#ffcccc'>
			<td>NO.</td><td colspan=2>�d��ʽ�</td><td>�v�ɦW��</td><td>�o���W��</td><td>�ҮѤ��</td><td>�D����</td><td>�Ƶ�</td>";
	
		//�U���v�ɦ��G
		$query="select * from career_race where student_sn=$student_sn order by certificate_date";
		$res=$CONN->Execute($query);
		if($res->RecordCount()){
			while(!$res->EOF){
				$ii++;
				$sn=$res->fields['sn'];
				if($_POST['edit_sn']==$sn){
					foreach($level_array as $key=>$value){
						$checked=($key==$res->fields['level'])?'checked':'';
						$level_radio.="<input type='radio' name='level' value='$key' $checked>$value<br>";
					}
					foreach($squad_array as $key=>$value){
						$checked=($key==$res->fields['squad'])?'checked':'';
						$squad_radio.="<input type='radio' name='squad' value='$key' $checked>$value<br>";
					}
					$race_list.="<tr align='center' bgcolor='#ffffcc'>
						<td>$ii<input type='hidden' name='del_sn' value='{$_POST['edit_sn']}'>
							<br><input type='submit' value='�ק�' name='go' onclick='document.myform.edit_sn.value=\"$sn\";return confirm(\"�T�w�n\"+this.value+\"?\")'>
							<br><input type='submit' value='�R��' name='go' onclick='document.myform.edit_sn.value=\"$sn\"; return confirm(\"�T�w�n\"+this.value+\"?\")'>
							<br><input type='reset' value='����' onclick='this.form.submit();'>
						</td>
						<td align='left'>$level_radio</td>
						<td align='left'>$squad_radio</td>
						<td><input type='text' name='name' value='{$res->fields['name']}'></td>
						<td><input type='text' name='rank' value='{$res->fields['rank']}' size=3></td>
						<td><input type='text' name='certificate_date' value='{$res->fields['certificate_date']}' size=10></td>
						<td><input type='text' name='sponsor' value='{$res->fields['sponsor']}'></td>
						<td><textarea name='memo'  style='border-width:1px; color:brown; width=100%; height=100%;'>{$res->fields['memo']}</textarea></td>
						</tr>";
				} else  {
					$memo=str_replace("\r\n",'<br>',$res->fields['memo']);
					$java_script=($pos and $race_result)?"onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#ccccff';\" onMouseOut=\"this.style.backgroundColor='#ffffff';\" ondblclick='document.myform.edit_sn.value=\"$sn\"; document.myform.submit();'":"";
					$race_list.="<tr align='center' $java_script>
						<td>$ii</td>
						<td>{$level_array[$res->fields['level']]}</td>
						<td>{$squad_array[$res->fields['squad']]}</td>
						<td align='left'>{$res->fields['name']}</td>
						<td>{$res->fields['rank']}</td>
						<td>{$res->fields['certificate_date']}</td>
						<td align='left'>{$res->fields['sponsor']}</td>
						<td align='left'>$memo</td>
						</tr>";	
				}
				$res->MoveNext();
			}
		} else $race_list.="<tr align='center'><td colspan=8 height=24>���o�{�U���v�ɦ��G�����I</td></tr>";
		$race_list.="</table>";
		
		
		$showdata="<br>$race_list";
		
		break;
	case '3-4':
		$reward_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size:9pt;' bordercolor='#111111' width=100%>
			<tr align='center' bgcolor='#ccccff'><td>NO.</td><td>�Ǵ��O</td><td>���g���</td><td>���g���O</td><td>���g�ƥ�</td><td>���g�̾�</td><td>�P�L���</td><td>�Ť��ĭp</td></tr>";
		
		$reward_arr=array("1"=>"�ż��@��","2"=>"�ż��G��","3"=>"�p�\�@��","4"=>"�p�\�G��","5"=>"�j�\�@��","6"=>"�j�\�G��","7"=>"�j�\�T��","-1"=>"ĵ�i�@��","-2"=>"ĵ�i�G��","-3"=>"�p�L�@��","-4"=>"�p�L�G��","-5"=>"�j�L�@��","-6"=>"�j�L�G��","-7"=>"�j�L�T��");
		//������w�ǥͪ����g����
		$seme_reward=array();
		$sql="SELECT * FROM reward WHERE student_sn=$student_sn ORDER BY reward_year_seme,reward_date";
		$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
		if($res->RecordCount())
		while(!$res->EOF)
		{
			$reward_kind=$res->fields['reward_kind'];
			$reward_cancel_date=$res->fields['reward_cancel_date'];
			$reward_bonus=$res->fields['reward_bonus']?"<img src='images/ok.png'>":'';
			$reward_year_seme=substr($res->fields['reward_year_seme'],0,-1).'-'.substr($res->fields['reward_year_seme'],-1);
			$recno++;
			$bgcolor=($reward_kind>0)?'#ccffcc':'#ffcccc';
			if($reward_cancel_date=='0000-00-00') $reward_cancel_date=''; else $bgcolor='#cccccc';
			$reward_list.="<tr bgcolor='$bgcolor' align='center'><td>$recno</td><td>$reward_year_seme</td><td>{$res->fields['reward_date']}</td><td>{$reward_arr[$res->fields['reward_kind']]}</td><td align='left'>{$res->fields['reward_reason']}</td><td align='left'>{$res->fields['reward_base']}</td><td>$reward_cancel_date</td><td>$reward_bonus</td></tr>";
			//�Ǵ��έp
			$reward_year_seme=$res->fields['reward_year_seme'];
			$seme_key=array_search($reward_year_seme,$stud_seme_arr);
			$reward_kind=$res->fields['reward_kind'];			
			
			switch($reward_kind){
				case 1:	$seme_reward_effective[$seme_key][1]++;	$seme_reward_effective['sum'][1]++;	break;
				case 2:	$seme_reward_effective[$seme_key][1]+=2;	$seme_reward_effective['sum'][1]+=2; break;
				case 3:	$seme_reward_effective[$seme_key][3]++;	$seme_reward_effective['sum'][3]++;	break;
				case 4:	$seme_reward_effective[$seme_key][3]+=2;	$seme_reward_effective['sum'][3]+=2; break;
				case 5:	$seme_reward_effective[$seme_key][9]++;	$seme_reward_effective['sum'][9]++;	break;
				case 6:	$seme_reward_effective[$seme_key][9]+=2;	$seme_reward_effective['sum'][9]+=2; break;
				case 7:	$seme_reward_effective[$seme_key][9]+=3;	$seme_reward_effective['sum'][9]+=3; break;
				case -1: $seme_reward_effective[$seme_key][-1]++;	$seme_reward_effective['sum'][-1]++; break;
				case -2: $seme_reward_effective[$seme_key][-1]+=2;	$seme_reward_effective['sum'][-1]+=2; break;
				case -3: $seme_reward_effective[$seme_key][-3]++;	$seme_reward_effective['sum'][-3]++; break;
				case -4: $seme_reward_effective[$seme_key][-3]+=2;	$seme_reward_effective['sum'][-3]+=2; break;
				case -5: $seme_reward_effective[$seme_key][-9]++;	$seme_reward_effective['sum'][-9]++; break;
				case -6: $seme_reward_effective[$seme_key][-9]+=2;	$seme_reward_effective['sum'][-9]+=2; break;
				case -7: $seme_reward_effective[$seme_key][-9]+=3;	$seme_reward_effective['sum'][-9]+=3; break;
			}
			//�P�L�έp
			if($reward_cancel_date){
				switch($reward_kind){
					case -1: $seme_reward_canceled[$seme_key][-1]++; $seme_reward_canceled['sum'][-1]++; break;
					case -2: $seme_reward_canceled[$seme_key][-1]+=2; $seme_reward_canceled['sum'][-1]+=2; break;
					case -3: $seme_reward_canceled[$seme_key][-3]++; $seme_reward_canceled['sum'][-3]++; break;
					case -4: $seme_reward_canceled[$seme_key][-3]+=2; $seme_reward_canceled['sum'][-3]+=2; break;
					case -5: $seme_reward_canceled[$seme_key][-9]++; $seme_reward_canceled['sum'][-9]++; break;
					case -6: $seme_reward_canceled[$seme_key][-9]+=2; $seme_reward_canceled['sum'][-9]+=2; break;
					case -7: $seme_reward_canceled[$seme_key][-9]+=3; $seme_reward_canceled['sum'][-9]+=3; break;
				}
			}			
			$res->MoveNext();
		} else $reward_list.="<tr><td colspan=12 align='center'><font size=5 color='#ff0000'>���o�{���� {$menu_arr[$menu]} ���ӡI</font></td>";
		$reward_list.="</table>";
		
		//�Ǵ��έp�C��
		//��������Y
		$seme_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' id='AutoNumber1' width=100%>
		<tr align='center' bgcolor='#ffcccc'><td rowspan=2>�~��</td><td rowspan=2>�Ǵ�</td><td colspan=6 bgcolor='#ccccff'>���g����</td><td colspan=3 bgcolor='#cccccc'>��L�P�L����</td><td rowspan=2>�ۧڬ٫�</td></tr>
		<tr align='center'  bgcolor='#ccccff'><td>�j�\</td><td>�p�\</td><td>�ż�</td><td>ĵ�i</td><td>�p�L</td><td>�j�L</td><td bgcolor='#cccccc'>ĵ�i</td><td bgcolor='#cccccc'>�p�L</td><td bgcolor='#cccccc'>�j�L</td></tr>
		";
		//���e
		foreach($stud_seme_arr as $seme_key=>$year_seme){			
			$bgcolor=($career_previous or $curr_seme_key==$seme_key)?'#ffdfdf':'#cfefef';
			$readonly=($career_previous or $curr_seme_key==$seme_key)?'':'readonly';
			$seme_list.="<tr align='center'><td>$seme_key</td><td>$year_seme</td>
				<td>{$seme_reward_effective[$seme_key][9]}</td><td>{$seme_reward_effective[$seme_key][3]}</td><td>{$seme_reward_effective[$seme_key][1]}</td><td>{$seme_reward_effective[$seme_key][-1]}</td><td>{$seme_reward_effective[$seme_key][-3]}</td><td>{$seme_reward_effective[$seme_key][-9]}</td>
				<td>{$seme_reward_canceled[$seme_key][-1]}</td><td>{$seme_reward_canceled[$seme_key][-3]}</td><td>{$seme_reward_canceled[$seme_key][-9]}</td>";
			if($pos)
				$seme_list.="<td><textarea name='ponder[$seme_key]' style='border-width:1px; color:brown; background:$bgcolor; font-size:11px; width=100%; height=100%;' $readonly>{$ponder_array[$seme_key]}</textarea></td></tr>";
			else $seme_list.="<td>".str_replace("\r\n","<br>",$ponder_array[$seme_key])."</td></tr>";
		}
		//���~�έp
		$seme_list.="<tr align='center' bgcolor='#ccccff'><td colspan=2 bgcolor='#ccffcc'>�N�Ǵ����έp</td>
			<td>{$seme_reward_effective['sum'][9]}</td><td>{$seme_reward_effective['sum'][3]}</td><td>{$seme_reward_effective['sum'][1]}</td><td>{$seme_reward_effective['sum'][-1]}</td><td>{$seme_reward_effective['sum'][-3]}</td><td>{$seme_reward_effective['sum'][-9]}</td>
			<td bgcolor='#cccccc'>{$seme_reward_canceled['sum'][-1]}</td><td bgcolor='#cccccc'>{$seme_reward_canceled['sum'][-3]}</td><td bgcolor='#cccccc'>{$seme_reward_canceled['sum'][-9]}</td>";
		if($pos)	
			$seme_list.="<td bgcolor='#ccffcc'><textarea name='ponder[sum]' style='border-width:1px; color:brown; background:$bgcolor; font-size:11px; width=100%; height=100%;'>{$ponder_array['sum']}</textarea></td></tr>";
		else
			$seme_list.="<td>".str_replace("\r\n","<br>",$ponder_array['sum'])."</td></tr>";
		$seme_list.="</table>";

		
		$showdata="<br>�����ӡG$reward_list <br>���έp�G$seme_list";
		
		break;
	case '3-5':
		$act='';
		$room_arr=room_kind();
		$seme_list=array();
		//��������Y
		$service_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' id='AutoNumber1'>
		<tr align='center' bgcolor='#ffcccc'><td>�~��</td><td>�Ǵ�</td><td>�A�Ȥ��</td><td colspan=2>�ѥ[�դ��~���@�A�Ⱦǲߨƶ��ά��ʶ���</td><td>������</td><td>�D����</td><td>�n�����</td><td>�ۧڬ٫�</td>";

		$query="select a.*,b.* from stud_service_detail a inner join stud_service b on a.item_sn=b.sn where confirm=1 and student_sn=$student_sn order by year_seme";
		$res=$CONN->Execute($query);
		if($res->RecordCount()){
			while(!$res->EOF){
				$year_seme=$res->fields['year_seme'];
				$seme_key=array_search($year_seme,$stud_seme_arr);
				$feed_back=str_replace("\r\n",'<br>',$res->fields['stud_feedback']);
				$service_list.="<tr align='center'>
				<td>$seme_key</td><td>$year_seme</td>
				<td>{$res->fields['service_date']}</td> 
				<td>{$res->fields['item']}</td><td align='left'>{$res->fields['memo']}</td>
				<td>{$res->fields['minutes']}</td>
				<td>{$res->fields['sponsor']}</td>
				<td>{$room_arr[$res->fields['department']]}</td>
				<td align='left'>$feed_back</td>				
				</tr>";
				$seme_sum[$seme_key]+=$res->fields['minutes'];
				$res->MoveNext();
			}
		} else $service_list.="<tr align='center'><td colspan=9 height=24>���o�{�w�{�Ҫ��A�Ⱦǲ߬����I</td></tr>";
		$service_list.="</table>";
		//�έp��
		$seme_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' id='AutoNumber1'>
		<tr align='center' bgcolor='#ffcccc'><td>�~��</td><td>�Ǵ�</td><td>������</td><td>�A�Ȯɼ�</td></tr>";
		foreach($stud_seme_arr as $seme_key=>$year_seme){
			$minutes=$seme_sum[$seme_key]; $minutes_sum+=$minutes;
			$hours=round($minutes/60,2); $hours_sum+=$hours;			
			$seme_list.="<tr align='center'><td>$seme_key</td><td>$year_seme</td><td>$minutes</td><td>$hours</td></tr>";
		}
		$seme_list.="<tr align='center' bgcolor='#ffcccc'><td colspan=2>�N�Ǵ����έp</td><td>$minutes_sum</td><td>$hours_sum</td></tr></table>";
		$showdata="<br><br>�������G$service_list<br>���έp�G$seme_list";
		
		break;
	case '3-6':	
		if($_POST['go']=='�ק�'){
			$query="update career_explore set course_id='{$_POST['course_id']}',seme_key='{$_POST['seme_key']}',activity_id='{$_POST['activity_id']}',degree='{$_POST['degree']}',self_ponder='{$_POST['self_ponder']}' where sn={$_POST['edit_sn']}";
			$res=$CONN->Execute($query) or die("SQL���~:$query");
			$_POST['edit_sn']=0;
		} elseif($_POST['go']=='�R��'){
			$query="delete from career_explore where sn={$_POST['edit_sn']}";
			$res=$CONN->Execute($query) or die("SQL���~:$query");
			$_POST['edit_sn']=0;
		} elseif($_POST['go']=='�s�W'){
			$query="insert into career_explore set student_sn=$student_sn";
			$res=$CONN->Execute($query) or die("SQL���~:$query");
		}	
		
		if($explore_exclude) { $pos=True; $m_arr[study_spe_months].=','.date('m'); }
		$act=$pos?"<input type='submit' name='go' value='�s�W'>":"";
		//��������Y
		$explore_list="<input type='hidden' name='edit_sn' value=''><input type='hidden' name='add' value=''>
				<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' id='AutoNumber1' width=100%>
				<tr align='center' bgcolor='#ffcccc'><td>NO.</td><td>�~��</td><td>�Ǵ�</td><td>�ձ��ǵ{�θs��</td><td>���ʤ覡</td><td>�ѻP�ձ����ʫ��X��Ӹs��P���쪺�{��</td><td>�ۧڬ٫�</td>";
		//����өʡB�U�����ʰѷӪ�
		$course_array=SFS_TEXT('�ͲP�ձ��ǵ{�θs��');
		$activity_array=SFS_TEXT('�ͲP�ձ����ʤ覡');

		//���o�ͲP�ձ����ʬJ�����
		$query="select * from career_explore where student_sn=$student_sn order by seme_key";
		$res=$CONN->Execute($query);
		if($res->RecordCount()){
			while(!$res->EOF){
				$ii++;
				$sn=$res->fields['sn'];
				if($_POST['edit_sn']==$sn and $pos){					
					foreach($course_array as $key=>$value){
						$checked=($key==$res->fields['course_id'])?'checked':'';
						$course_radio.="<input type='radio' name='course_id' value='$key' $checked>$value<br>";
					}
					foreach($activity_array as $key=>$value){
						$checked=($key==$res->fields['activity_id'])?'checked':'';
						$activity_radio.="<input type='radio' name='activity_id' value='$key' $checked>$value<br>";
					}
					foreach($stud_seme_arr as $seme_key=>$year_seme){
						$checked=($seme_key==$res->fields['seme_key'])?'checked':'';
						$seme_radio.="<input type='radio' name='seme_key' value='$seme_key' $checked>($seme_key) $year_seme <br>";
					}	
					for($i=1;$i<=5;$i++){
						$checked=($i==$res->fields['degree'])?'checked':'';
						$degree_radio.="<input type='radio' name='degree' value='$i' $checked>$i ";
					}						
					
					$explore_list.="<tr align='center' bgcolor='#ffffcc'>
						<td>$ii<input type='hidden' name='del_sn' value='{$_POST['edit_sn']}'>
						<br><input type='submit' value='�ק�' name='go' onclick='document.myform.edit_sn.value=\"$sn\";return confirm(\"�T�w�n\"+this.value+\"?\")'>
						<br><input type='submit' value='�R��' name='go' onclick='document.myform.edit_sn.value=\"$sn\"; return confirm(\"�T�w�n\"+this.value+\"?\")'>
						<br><input type='reset' value='����' onclick='this.form.submit();'>
						</td>
						<td colspan=2>$seme_radio</td>
						<td align='left'>$course_radio</td>
						<td align='left'>$activity_radio</td>
						<td>$degree_radio</td>
						<td><textarea name='self_ponder'  style='border-width:1px; color:brown; width=100%; height=100%;'>{$res->fields['self_ponder']}</textarea></td>
						</tr>";
				} else {
					$self_ponder=str_replace("\r\n",'<br>',$res->fields['self_ponder']);
					$java_script=$pos?"onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#ccccff';\" onMouseOut=\"this.style.backgroundColor='#ffffff';\" ondblclick='document.myform.edit_sn.value=\"$sn\"; document.myform.submit();'":"";
					$explore_list.="<tr align='center' $java_script>
						<td>$ii</td>
						<td>{$res->fields['seme_key']}</td>
						<td>{$stud_seme_arr[$res->fields['seme_key']]}</td>
						<td>{$course_array[$res->fields['course_id']]}</td>
						<td>{$activity_array[$res->fields['activity_id']]}</td>
						<td>{$res->fields['degree']}</td>
						<td align='left'>$self_ponder</td>
						</tr>";	
				}
				$res->MoveNext();
			}
		} else $explore_list.="<tr align='center'><td colspan=7 height=24>���o�{�ͲP�ձ����ʬ����I</td></tr>";
		$explore_list.="</table>";

		$showdata="<br>$explore_list";

		break;		
	default:
		$showdata="<center><font size=5 color='#ff0000'><br><br>�п���n�˵��γ]�w�����ءI<br><br></font></center>";
}

$main="<font size=2><form method='post' action='$_SERVER[SCRIPT_NAME]' name='myform'>$memu_select $act $showdata</form></font><br>���Ǯճ]�w�i��g����G$m_arr[study_spe_months]";

echo $main;

foot();

?>
