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
head("�ڪ������G��");

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

//�x�s�����B�z
if($_POST['go']=='�x�s����'){
	switch($menu){
		case 1:
			$personality=serialize($_POST['personality']);
			$interest=serialize($_POST['interest']);
			$specialty=serialize($_POST['specialty']);
			//�ˬd�O�_�w���¬���
			$query="select sn from career_mystory where student_sn=$student_sn";
			$res=$CONN->Execute($query) or die("SQL���~:$query");
			$sn=$res->fields[0];
			if($sn) $query="update career_mystory set personality='$personality',interest='$interest',specialty='$specialty' where sn=$sn";
				else $query="insert into career_mystory set student_sn=$student_sn,personality='$personality',interest='$interest',specialty='$specialty'";
			$res=$CONN->Execute($query) or die("SQL���~:$query");	
			break;
		case 2:
			//occupation_suggestion occupation_myown occupation_others occupation_weight
			$occupation_suggestion=serialize($_POST['suggestion']);
			$occupation_myown=serialize($_POST['myown']);
			$occupation_others=serialize($_POST['others']);
			$occupation_weight=serialize($_POST['weight']);
			
			//�ˬd�O�_�w���¬���
			$query="select sn from career_mystory where student_sn=$student_sn";
			$res=$CONN->Execute($query) or die("SQL���~:$query");
			$sn=$res->fields[0];
			if($sn) $query="update career_mystory set occupation_suggestion='$occupation_suggestion',occupation_myown='$occupation_myown',occupation_others='$occupation_others',occupation_weight='$occupation_weight' where sn=$sn";
				else $query="insert into career_mystory set student_sn=$student_sn,occupation_suggestion='$occupation_suggestion',occupation_myown='$occupation_myown',occupation_others='$occupation_others',occupation_weight='$occupation_weight'";
			$res=$CONN->Execute($query) or die("SQL���~:$query");	
			break;
	}
}

//���Ϳ��
$memu_select="���ڬO $stud_name �A���Ǵ��NŪ�Z�šG $seme_class �A�y���G $seme_num �C ���ڭn�˵��γ]�w";
$menu_arr=array(1=>'�ۧڻ{��',2=>'¾�~�P��');
foreach($menu_arr as $key=>$title){
	$checked=($menu==$key)?'checked':''; 
	$color=($menu==$key)?'#0000ff':'#000000'; 
	$memu_select.="<input type='radio' name='menu' value='$key' $checked onclick='this.form.submit();'><b><font color='$color'>$title</font></b>";
}
//�ˬd�O�_���i��g���
$mystory_months="[,$mystory_months,]";
$pos=strpos($mystory_months,$curr_month,1);
switch($menu){
	case 1:
		//����өʡB�U�����ʰѷӪ�
		$personality_items=SFS_TEXT('�ө�(�H��S��)');
		$activity_items=SFS_TEXT('�U������');
	
		//���o�ڪ������G�ƬJ�����
		$query="select personality,interest,specialty from career_mystory where student_sn=$student_sn";
		$res=$CONN->Execute($query);
		
		//����ۧڻ{�ѦU�Ӷ��ت����e
		$personality_array=unserialize($res->fields['personality']);
		$interest_array=unserialize($res->fields['interest']);
		$specialty_array=unserialize($res->fields['specialty']);
		
		$personality_checkox="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' id='AutoNumber1' width='100%'>
		<tr bgcolor='#ccccff' align='center'><td colspan=3>�ө�(�H��S��)</td></tr>
		<tr bgcolor='#ffcccc' align='center'><td>{$class_year[$min]}��</td><td>{$class_year[$min+1]}��</td><td>{$class_year[$min+2]}��</td></tr><tr>";
			
		$interest_checkox="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' id='AutoNumber1' width='100%'>
		<tr bgcolor='#ccccff' align='center'><td colspan=3>�𶢿���</td></tr>
		<tr bgcolor='#ffcccc' align='center'><td>{$class_year[$min]}��</td><td>{$class_year[$min+1]}��</td><td>{$class_year[$min+2]}��</td></tr><tr>";
		
		$specialty_checkox="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' id='AutoNumber1' width='100%'>
		<tr bgcolor='#ccccff' align='center'><td colspan=3>�M��</td></tr>
		<tr bgcolor='#ffcccc' align='center'><td>{$class_year[$min]}��</td><td>{$class_year[$min+1]}��</td><td>{$class_year[$min+2]}��</td></tr><tr>";
		
		for($i=$min;$i<=$max;$i++){
			if($pos){
				$disabled=($career_previous or $stud_grade==$i)?'':'disabled';
				$bgcolor=($career_previous or $stud_grade==$i)?'#ffdfdf':'#cfefef';
				
				$personality_checkox.="<td bgcolor='$bgcolor'>";
				foreach($personality_items as $key=>$value){
					$color=$personality_array[$i][$key]?'#ff0000':'#000000';
					$checked=$personality_array[$i][$key]?'checked':'';
					$personality_checkox.="<input type='checkbox' name='personality[$i][$key]' value='1' $disabled $checked><font color='$color'>$value</font><br>";
					if($disabled and $checked) $personality_checkox.="<input type='hidden' name='personality[$i][$key]' value='1'>"; 
				}
				$personality_checkox.="</td>";
			} else {
				$personality_checkox.="<td>";
				foreach($personality_items as $key=>$value){
					$checked=$personality_array[$i][$key]?'��':'��';
					$personality_checkox.="$checked $value<br>";
				}
				$personality_checkox.="</td>";
			}
			
			$interest_checkox.="<td bgcolor='$bgcolor'>";
			foreach($activity_items as $key=>$value){
				if($pos){
					$color=$interest_array[$i][$key]?'#ff0000':'#000000';
					$checked=$interest_array[$i][$key]?'checked':'';
					$interest_checkox.="<input type='checkbox' name='interest[$i][$key]' value='$1' $disabled $checked><font color='$color'>$value</font><br>";
					if($disabled and $checked) $interest_checkox.="<input type='hidden' name='interest[$i][$key]' value='1'>";
				} else {
					$checked=$interest_array[$i][$key]?'��':'��';
					$interest_checkox.="$checked $value<br>";
				}
			}
			$interest_checkox.="</td>";
			
			$specialty_checkox.="<td bgcolor='$bgcolor'>";
			foreach($activity_items as $key=>$value){
				if($pos){
					$color=$specialty_array[$i][$key]?'#ff0000':'#000000';
					$checked=$specialty_array[$i][$key]?'checked':'';
					$specialty_checkox.="<input type='checkbox' name='specialty[$i][$key]' value='1' $disabled $checked><font color='$color'>$value</font><br>";
					if($disabled and $checked) $specialty_checkox.="<input type='hidden' name='specialty[$i][$key]' value='1'>";
				} else {
					$checked=$specialty_array[$i][$key]?'��':'��';
					$specialty_checkox.="$checked $value<br>";
				}
			}
			$specialty_checkox.="</td>";			
		}
		$personality_checkox.='</tr></table>';
		$interest_checkox.='</tr></table>';
		$specialty_checkox.='</tr></table>';		
		
		$showdata="$personality_checkox<br>$interest_checkox<br>$specialty_checkox";
		
		break;
	case 2:	
		//¾�~�P��-���D�}�C�w�q
		$suggestion_question=array(1=>'�a�H�B�v���οˤʹ��g��ĳ�ڥ��ӥi��ܪ�¾�~',2=>'���ګ�ĳ���H',3=>'��ĳ�ڿ�ܳo��¾�~����]');
		$myown_question=array(1=>'�ڳ̷P���쪺¾�~',2=>'�ڹ�o¾�~�P���쪺��]',3=>'�o��¾�~�ݨ�ƪ��Ǿ��B��O�B�M���Ψ�L����');
		$others_question=array(1=>'�ڷQ�n�i�@�B�F�ѭ���¾�~');
		
		//������¾�~�ɭ���������ѷӪ�
		$weight_items=SFS_TEXT('���¾�~�ɭ���������');
		
		//���o�ڪ������G�ƬJ�����
		$query="select occupation_suggestion,occupation_myown,occupation_others,occupation_weight from career_mystory where student_sn=$student_sn";
		$res=$CONN->Execute($query);
		
		//����ۧڻ{�ѦU�Ӷ��ت����e
		$suggestion_array=unserialize($res->fields['occupation_suggestion']);
		$myown_array=unserialize($res->fields['occupation_myown']);
		$others_array=unserialize($res->fields['occupation_others']);
		$weight_array=unserialize($res->fields['occupation_weight']);
		
		$suggestion_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' id='AutoNumber1' width='100%'>
		<tr bgcolor='#ccccff' align='center'><td colspan=4>�a�H�B�v���οˤͪ���ĳ</td></tr>
		<tr bgcolor='#ffcccc' align='center'><td>�ݡ@�@�@�@�D</td><td>{$class_year[$min]}��</td><td>{$class_year[$min+1]}��</td><td>{$class_year[$min+2]}��</td></tr>";	
		foreach($suggestion_question as $key=>$value){
			$suggestion_list.="<tr><td>$key. $value</td>";
			for($i=$min;$i<=$max;$i++){
				$mydata=$suggestion_array[$i][$key];
				if($pos) {
					if($career_previous or $stud_grade==$i)	$suggestion_list.="<td bgcolor='#ffdfdf'><input type='text' name='suggestion[$i][$key]' value='$mydata'></td>";
						else $suggestion_list.="<td bgcolor='#cfefef'>$mydata<input type='hidden' name='suggestion[$i][$key]' value='$mydata'></td>";
				} else {
					$suggestion_list.="<td bgcolor='#eeeeee'>$mydata</td>";
				}
			}
			$suggestion_list.='</tr>';		
		}
		$suggestion_list.='</table><br>';	
		
		
		$myown_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' id='AutoNumber1' width='100%'>
		<tr bgcolor='#ccccff' align='center'><td colspan=4>�ڳ̷P���쪺¾�~</td></tr>
		<tr bgcolor='#ffcccc' align='center'><td>�ݡ@�@�@�@�D</td><td>{$class_year[$min]}��</td><td>{$class_year[$min+1]}��</td><td>{$class_year[$min+2]}��</td></tr>";	
		foreach($myown_question as $key=>$value){
			$myown_list.="<tr><td>$key. $value</td>";
			for($i=$min;$i<=$max;$i++){
				$mydata=$myown_array[$i][$key];
				if($pos) {
					if($career_previous or $stud_grade==$i)	$myown_list.="<td bgcolor='#ffdfdf'><input type='text' name='myown[$i][$key]' value='$mydata'></td>";
					else $myown_list.="<td bgcolor='#cfefef'>$mydata<input type='hidden' name='myown[$i][$key]' value='$mydata'></td>";
				} else {
					$myown_list.="<td bgcolor='#eeeeee'>$mydata</td>";
				}
			}
			$myown_list.='</tr>';		
		}
		$myown_list.='</table><br>';
		
		
		$others_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' id='AutoNumber1' width='100%'>
		<tr bgcolor='#ccccff' align='center'><td colspan=4>�ڷQ�n�i�@�B�F�Ѫ�¾�~</td></tr>
		<tr bgcolor='#ffcccc' align='center'><td>�ݡ@�@�@�@�D</td><td>{$class_year[$min]}��</td><td>{$class_year[$min+1]}��</td><td>{$class_year[$min+2]}��</td></tr>";	
		foreach($others_question as $key=>$value){
			$others_list.="<tr><td>$key. $value</td>";
			for($i=$min;$i<=$max;$i++){
				$mydata=$others_array[$i][$key];
				if($pos) {
					if($career_previous or $stud_grade==$i)	$others_list.="<td bgcolor='#ffdfdf'><input type='text' name='others[$i][$key]' value='$mydata'></td>";
					else $others_list.="<td bgcolor='#cfefef'>$mydata<input type='hidden' name='others[$i][$key]' value='$mydata'></td>";
				} else {
					$others_list.="<td bgcolor='#eeeeee'>$mydata</td>";
				}
			}
			$others_list.='</tr>';		
		}
		$others_list.='</table><br>';
		
		//��������@�]�P�W���{�����c���P�^
		$weight_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' id='AutoNumber1' width='100%'>
			<tr bgcolor='#ccccff' align='center'><td colspan=4>���¾�~�ɡA�ڭ���������(�i�ƿ�)</td></tr>
			<tr bgcolor='#ffcccc' align='center'><td width=200>��g����</td><td>{$class_year[$min]}��</td><td>{$class_year[$min+1]}��</td><td>{$class_year[$min+2]}��</td></tr>
			<tr>
			<td valign='top' width=300>
			<li>�i��ͲP�W���ɡA����M�P�A�ѭӤH�S��A�j���ǮջP¾�~��ơA�P�ɦҶq�a�H�N���B���|�P�����ܾE�B�U���U�O���O�]�����C</li>
			<li>�b�ӤH�S�誺��M�P�A�Ѥ譱�A���F����B��O�~�A�u�@�����[�]�ӤH����������^�]�O���n�v�T�]���C</li>
			<li>�]�K�B�E�~�Ŷ�g�^</li>	
			</td>";
		
		for($i=$min;$i<=$max;$i++){
			$disabled=($career_previous or $stud_grade==$i)?'':'disabled';
			$bgcolor=($career_previous or $stud_grade==$i)?'#ffdfdf':'#cfefef';
			$bgcolor=$pos?$bgcolor:'#eeeeee';
			$weight_list.="<td bgcolor='$bgcolor'>";
			foreach($weight_items as $key=>$value){
				if($pos) {
					$color=$weight_array[$i][$key]?'#ff0000':'#000000';
					$checked=$weight_array[$i][$key]?'checked':'';
					$weight_list.="<input type='checkbox' name='weight[$i][$key]' value='1' $disabled $checked><font color='$color'>$value</font><br>";
					if($disabled and $checked) $weight_list.="<input type='hidden' name='weight[$i][$key]' value='1'>";
				} else {
					$checked=$specialty_array[$i][$key]?'��':'��';
					$weight_list.="$checked $value<br>";
				}
			}
		}
		$weight_list.="</td></tr></table>";		
		
		$showdata=$suggestion_list.$myown_list.$others_list.$weight_list;
		
		break;	
}

$act=($menu and $pos)?"<center><input type='submit' value='�x�s����' name='go' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")' style='border-width:1px; cursor:hand; color:white; background:#5555ff; font-size:20px; height=42'></center>":"���Ǯճ]�w�i��g����G$m_arr[mystory_months]";

$main="<font size=2><form method='post' action='$_SERVER[SCRIPT_NAME]' name='myform'>$memu_select $showdata<br>$act</form></font>";

echo $main;

foot();

?>
