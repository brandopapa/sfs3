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
head("�U���߲z����");

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
$seme_year_seme=sprintf('%03d%d',$curr_year,$curr_seme);
$student_sn=$_SESSION['session_tea_sn'];
$stud_name=$_SESSION['session_tea_name'];

$menu=$_POST['menu'];

if($_POST['go']=='�x�s����'){
	$highest_str=implode(',',$_POST['highest']);
	$query="update career_test set study='{$_POST['study']}',job='{$_POST['job']}',highest='$highest_str' where sn={$_POST['sn']}";
	$res=$CONN->Execute($query) or die("SQL���~:$query");
}


//����ǥͥ��Ǵ��NŪ�Z��
$query="select * from stud_seme where student_sn=$student_sn and seme_year_seme='$seme_year_seme'";
$res=$CONN->Execute($query);
$seme_class=$res->fields['seme_class'];
$seme_class_name=$res->fields['seme_class_name'];
$seme_num=$res->fields['seme_num'];
$stud_grade=substr($seme_class,0,-2);

//���Ϳ��
$memu_select="���ڬO $stud_name �A���Ǵ��NŪ�Z�šG $seme_class �A�y���G $seme_num �C<br>���ڭn�˵�";
$menu_arr=array(1=>'�ʦV����',2=>'�������',3=>'��L����(1)',4=>'��L����(2)');
foreach($menu_arr as $key=>$title){
	$checked=($menu==$key)?'checked':''; 
	$color=($menu==$key)?'#0000ff':'#000000'; 
	$memu_select.="<input type='radio' name='menu' value='$key' $checked onclick='this.form.submit();'><b><font color='$color'>$title</font></b>";
}

if($menu){
	//���o�ʦV����J�����
	$query="select * from career_test where student_sn=$student_sn and id=$menu";
	$res=$CONN->Execute($query);
	if($res->RecordCount()){
		while(!$res->EOF){
			$sn=$res->fields['sn'];
			$content=unserialize($res->fields['content']);

			$title=$content['title'];
			$test_result=$content['data'];
			$study="<input type='text' name='study' value='{$res->fields['study']}'>";
			$job="<input type='text' name='job' value='{$res->fields['job']}'>";
			$highest_arr=explode(',',$res->fields['highest']);
			for($i=0;$i<3;$i++){
				$highest.="<input type='text' name='highest[$i]' size=10 value='{$highest_arr[$i]}'> ";
			}
			$content_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' id='AutoNumber1'>
					<tr bgcolor='#ccffcc' align='center'><td colspan=2><b>$title</b></td></tr><tr></tr>
					<tr bgcolor='#ffcccc' align='center'><td>����</td><td>���e���G</td></tr>";
			if($test_result){
				foreach($test_result as $key=>$value) $content_list.="<tr><td>$key</td><td align='center'>$value</td></tr>";
			} else $content_list.="<tr align='center'><td colspan=2 height=100>�S���o�{������������I</td></tr>";
			$content_list.="<tr bgcolor='#fcccfc'><td colspan=2>
			�����Ƴ̰���3��������G $highest<br>
			���ھڴ��絲�G�A�b�ɾǤ譱�A�ھA�X�NŪ�G $study<br>
			���ھڴ��絲�G�A�b�N�~�譱�A�ھA�X�q�ơG $job</td></tr>";
			$content_list.="<tr bgcolor='#cffccc'><td colspan=2 align='center'><input type='hidden' name='sn' value='$sn'>
						<input type='submit' value='�x�s����' name='go' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")' style='border-width:1px; cursor:hand; color:white; background:#5555ff; font-size:20px; height=42'>
					</td></tr>";
			$content_list.="</table><br>";
			
			$res->MoveNext();
		}
	} else $content_list="<center><font size=5 color='#ff0000'><br><br>���o�{����{$menu_arr[$menu]}�����I<br><br></font></center>";
}

$main="<font size=2><form method='post' action='$_SERVER[SCRIPT_NAME]' name='myform'>$memu_select $content_list</form></font>";

echo $main;

foot();

?>
