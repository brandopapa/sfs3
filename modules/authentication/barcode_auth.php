<?php

// $Id: barcode_lend.php 6207 2010-10-05 04:46:46Z infodaes $
include "config.php";
sfs_check();

//�q�X����
head("���X���˵n��");

$teacher_sn=$my_sn;
echo print_menu($MENU_P,$linkstr);

$curr_year_seme = sprintf("%03d%d",curr_year(),curr_seme());

$barcode=$_POST['barcode'];
$auth_date=$_POST['auth_date'];
$memo=$_POST['memo'];
$score=$_POST['score'];

if($barcode AND $_POST['act']=='�ѪR�B�z'){
	//���o�{�Ҳӥذ}�C
	$sql="select a.*,b.nature,b.title as item_title,b.start_date,b.end_date from authentication_subitem a,authentication_item b WHERE a.item_sn=b.sn";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
	while(!$res->EOF){
		$sn=$res->fields['sn'];
		$subitem_array[$sn]['title']=$res->fields['nature'].'-'.$res->fields['item_title'].'-'.$res->fields['code'].'-'.$res->fields['title'].' ( '.$res->fields['start_date'].'~'.$res->fields['end_date'].' )';
		$res->MoveNext();
	}
	$barcode=explode("\r\n",$barcode);
	$excuted="<BR>�� �e�����XŪ���פJ���O���p�U��<BR><BR>";
	$ask_items='';
	$error_info='<BR>�� �U�����{�ҰO���w�g�s�b�A�t�Υ��i��O����s�I<br><br>';
	$illegal_info='<BR>�� �U�����{�ҭn�D���Q�\�i�I<br>';
	foreach($barcode as $value){
		if($value) {
			$real_data=explode('-',$value);
			$student_sn=$real_data[0];
			$subitem_sn=$real_data[1];
			//�X�k�{���ˬd
			$sql="SELECT a.seme_class,a.seme_num,b.stud_name FROM stud_seme a INNER JOIN stud_base b ON a.student_sn=b.student_sn WHERE a.student_sn=$student_sn and a.seme_year_seme='$curr_year_seme'";
			$res=$CONN->Execute($sql) or user_error("Ū���ǥͰ򥻸�ƥ��ѡI<br>$sql",256);
			if($res->RecordCount()){
				$class_id=$res->fields['seme_class'];
				$curr_class_num=sprintf('%02d',$res->fields['seme_num']);			
				$stud_name=$res->fields['stud_name'];
				//if($allowed_array[$subitem_sn][$class_id]){
					//���Ʃ��ˬd
					$sql2="SELECT * FROM authentication_record WHERE sub_item_sn=$subitem_sn AND student_sn=$student_sn";
					$res2=$CONN->Execute($sql2) or user_error("Ū�����ѡI<br>$sql2",256);
					if($res2->RecordCount()){
						$sn=$res2->fields['sub_item_sn'];
						$error_info.="�@�@$class_id$curr_class_num - $stud_name ---{$subitem_array[$subitem_sn]['title']}<br>";			
					} else {			
						$excuted.='�@�@'.$value.'<br>';
						$ask_items.="('$curr_year_seme','$subitem_sn','$student_sn','$score','$session_tea_sn','$auth_date','$memo'),";
					}
				//}  else { $illegal_info.="<br>�@�@$value �z������v�i�� $curr_class_num - $stud_name --- {$subitem_array[$subitem_sn]['title']} ���{�ҡI"; }		
			} else { $illegal_info.="<br>�@�@$value �g�d~~���Ǵ��L���ǥͤ��NŪ��ơI"; }
		}
	}
	$ask_items=substr($ask_items,0,-1);
	//���ݭn�s�W���~�g�J
	if($ask_items){
		$sql="INSERT INTO authentication_record(year_seme,sub_item_sn,student_sn,score,teacher_sn,date,note) VALUES $ask_items";
		$res=$CONN->Execute($sql) or user_error("�g�J���ѡI<br>$sql",256);
	}
}

$main="<table><form name='my_form' method='post' action='$_SERVER[PHP_SELF]'>
	<tr><td>���{�Ҥ���G<input type='text' size=15 value='".date('Y-m-d',time())."' name='auth_date'>
	<BR>�����@�@�Z�G<input type='text' size=5 value='' name='score'>
	<BR>�����O�����G<input type='text' size=20 value='$memo' name='memo'>
	<BR>���б��˻{�ұ��X�G<BR><textarea rows='15' name='barcode' cols=33></textarea>
<BR><input type='submit' value='�ѪR�B�z' name='act'><input type='reset' value='�M�ŭ���'></td><td valign='top'><font color='red'>$illegal_info</font><br><font color='green'>$error_info</font><br><font color='blue'>$excuted</font></td></tr></form></table>";
echo $main;
foot();
?>