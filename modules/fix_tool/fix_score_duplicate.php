<?php

require_once("config.php");
//�ϥΪ̻{��
sfs_check();

head("���Z���ƩʧR���P��ƪ���ޭ���s");

$table_list=array(0=>"stud_seme_score",1=>"stud_seme_score_nor");
$limit_record=100;

foreach($table_list as $key=>$table_name)
{
	echo "<li>�ˬd: $table_name</li>";
	//��ܥثe���p
	$sql="SELECT seme_year_seme,student_sn,ss_id,count(*) AS counter FROM $table_name GROUP BY student_sn,ss_id HAVING counter>1 limit $limit_record";
	$res=$CONN->Execute($sql) or user_error("Ū��stud_seme_score�Ǵ����Z��έp��ƥ��ѡI<br>$sql",256);
	$total_record=$res->recordcount();
	if($total_record>1){
		echo "�@==>�B�z���ǥͬ�ؼơG $total_record<br>";
		echo "<table border=1><tr align='center' bgcolor='#FFCCCC'><td>�ǥͬy����</td><td>�ҵ{�N��</td><td>���Ƽ�</td><td>�B�z���p</td></tr>";
		while(!$res->EOF) {
			//echo "�@�@==>�B�z��".$res->CurrentRow()."��!<br>";
			$year_seme=$res->fields[seme_year_seme];
			$student_sn=$res->fields[student_sn];
			$ss_id=$res->fields[ss_id];
			$counter=$res->fields[counter];
			echo "<tr><td align='center'>$student_sn</td><td align='center'>$ss_id</td><td align='center'>$counter</td><td>";
			//����O�d��ƫ�R��
			$kill_sss_id_list='';
			$sql2="SELECT * FROM $table_name WHERE seme_year_seme='$year_seme' AND student_sn=$student_sn AND ss_id=$ss_id ORDER BY ss_update_time";
			$res2=$CONN->Execute($sql2) or user_error("Ū��stud_seme_score (student_sn=$student_sn)(ss_id=$ss_id) �Ǵ����Z���l���Ƭ������ѡI<br>$sql2",256);
			while(!$res2->EOF) {
				$kill_sss_id_list.=$res2->fields[sss_id].',';
				$reversed_ss_score=$res2->fields[ss_score];
				$teacher_sn=$res2->fields[teacher_sn];
				if($res2->fields[ss_score_memo]<>'') $reversed_ss_score_memo=$res2->fields[ss_score_memo];
				$res2->MoveNext();
			}
			echo "<li>�O�d���Z:$reversed_ss_score �O�d�y�z: $reversed_ss_score_memo</li>";
			//�R�������
			$kill_sss_id_list=substr($kill_sss_id_list,0,-1);
			$sql_kill="DELETE FROM $table_name WHERE seme_year_seme='$year_seme' AND student_sn=$student_sn AND ss_id=$ss_id";
			$res_kill=$CONN->Execute($sql_kill) or user_error("�R��stud_seme_score�쭫�Ƭ������ѡI<br>$sql_kill",256);
			echo "<li>�R�����Ƭ���sss_id�C��:$kill_sss_id_list</li>";

			//���s�g�J����
			$sql_insert="INSERT INTO $table_name SET seme_year_seme='$year_seme',student_sn=$student_sn,ss_id=$ss_id,ss_score=$reversed_ss_score,ss_score_memo='$reversed_ss_score_memo',teacher_sn=$teacher_sn";
			$res_insert=$CONN->Execute($sql_insert) or user_error("�s�Wstud_seme_score (student_sn=$student_sn)(ss_id=$ss_id) �Ǵ����Z���ѡI<br>$sql_insert",256);
			echo "<li>���s�g�JOK!</li>";
			
			$res->MoveNext();
		}
		//�ˬd�O�_�٦�
		$sql="SELECT seme_year_seme,student_sn,ss_id,count(*) AS counter FROM $table_name GROUP BY student_sn,ss_id HAVING counter>1";
		$res=$CONN->Execute($sql) or user_error("Ū��stud_seme_score�Ǵ����Z��έp��ƥ��ѡI<br>$sql",256);
		$total_record=$res->recordcount();
		if(!$total_record){
			//�ץ�����
			$sql_index="ALTER TABLE $table_name DROP PRIMARY KEY ;";
			$res_index=$CONN->Execute($sql_index) or user_error("�R�� $table_name ����ޥ��ѡI<br>$sql_index",256);		
			$sql_index="ALTER TABLE $table_name ADD PRIMARY KEY ( `seme_year_seme` , `student_sn` , `ss_id` ) ";
			$res_index=$CONN->Execute($sql_index) or user_error("���� $table_name ����ޥ��ѡI<br>$sql_index",256);
			echo "<li>���إ��T���D���� OK!</li></td></tr></table>";
		} else echo "</td></tr></table><FONT size=5 color='#FF0000'>�|���@$total_record �ն��B�z�A�Ы� F5 ���s��z�~��!</FONT>";
	} else echo "<br>�@�@���ߧA! ����($school_sshort_name)  $table_name -> $year_seme �Ǵ����Z������ƭ��Ʊ���<br>";
}
foot();

?>
