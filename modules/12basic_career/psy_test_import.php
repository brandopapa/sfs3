<?php

// $Id:  $

//���o�]�w��
include_once "config.php";

sfs_check();

//�q�X����
head("�U���߲z�����ƶפJ");

//�Ҳտ��
print_menu($menu_p,$linkstr);
$menu=$_POST['menu'];

//����ǥͥ��Ǵ��NŪ�Z��
$query="select * from stud_seme where student_sn=$student_sn and seme_year_seme='$seme_year_seme'";
$res=$CONN->Execute($query);
$seme_class=$res->fields['seme_class'];
$seme_class_name=$res->fields['seme_class_name'];
$seme_num=$res->fields['seme_num'];
$stud_grade=substr($seme_class,0,-2);

//�x�s�����B�z
if($_POST['go']=='�פJ'){
	$content=explode("\r\n",$_POST['content']);
	foreach($content as $key=>$value){
		$student_data=explode("\t",$value);
		if($key){
			foreach($student_data as $stud_key=>$stud_value) $realdata['data'][$title[$stud_key]]=$stud_value;
		} else $title=$student_data;
		//���student_sn
		$stud_id=$realdata['data']['�Ǹ�'];
		$realdata['title']=$_POST['title'];
		if($stud_id){
			$query="select student_sn from stud_seme where stud_id='$stud_id' and seme_year_seme='$seme_year_seme'";		
			$res=$CONN->Execute($query) or die("SQL���~:$query");
			$target_sn=$res->fields[0];
			if($target_sn){
				$content=serialize($realdata);
				//�ˬd�O�_�w���¬���
				$query="select sn from career_test where student_sn='$target_sn' and id='$menu'";
				$res=$CONN->Execute($query) or die("SQL���~:$query");
				$sn=$res->fields[0];
				if($sn) $query="update career_test set id='$menu',content='$content' where sn=$sn";
				else $query="insert into career_test set student_sn='$target_sn',id='$menu',content='$content'";
				$res=$CONN->Execute($query) or die("SQL���~:$query");
			}
		}
	}
}

//���Ϳ��
$memu_select="���n�פJ�����O�G";
$menu_arr=array(1=>'�ʦV����',2=>'�������',3=>'��L����(1)',4=>'��L����(2)');
foreach($menu_arr as $key=>$title){
	$checked=($menu==$key)?'checked':''; 
	$color=($menu==$key)?'#0000ff':'#000000'; 
	$memu_select.="<input type='radio' name='menu' value='$key' $checked onclick='this.form.submit();'><b><font color='$color'>$title</font></b>";
}
if(checkid($_SERVER['SCRIPT_FILENAME'],1)) {
	if($menu){	
		//�W�ǸѪR			
		$item_default[1]=$guidance_title;
		$item_default[2]=$interest_title;
		$item_default[3]=$other_title;

		$item_radio="������W�١G<input type='text' name='title' value='{$item_default[$menu]}' size=60><input type='submit' name='go' value='�פJ'><br><br>�����絲�G(��EXCEL�ƻs�K�W)�G";
		$import_data="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#119911' width=100%>
			<tr><td>$item_radio<br><textarea name='content' style='border-width:1px; color:brown; background:$bgcolor; font-size:11px; width=100%; height=360;'></textarea></td></tr></table>";
	}
} else $import_data="<center><font size=5 color='#ff0000'><br><br>�z���㦳�t�κ޲z�v�A�L�k�ϥΥ��\��I<br><br></font></center>";

$main="<font size=2><form method='post' action='$_SERVER[SCRIPT_NAME]' name='myform'>$memu_select $import_data</form></font>";

echo $main;

foot();

?>
