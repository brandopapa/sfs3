<?php
	//���o�ǥͪ��Ҧ����θ�� 2013.10.23 by smallduh
	function get_club_data($student_sn="") {
		global $CONN;
		$PASS[1]="�X��";
		$PASS[0]="���X��";
			if (!empty($student_sn)) {
  		$sql="select * from association where student_sn='$student_sn' order by seme_year_seme";
			$res = $CONN->Execute($sql) or die("Sql error, ".$sql);
			$row=$res->GetRows();
			//�Y���դ�����, �ˬd�O�_�q�L , �W�[�@�� pass �ܼ� 0���L 1�q�L
			foreach ($row as $k=>$v) {
			 if ($v['club_sn']>0) {
			 	$query="select pass_score from stud_club_base where club_sn='".$v['club_sn']."'";
			 	$res_check=$CONN->Execute($query);
			 	$pass_score=$res_check->fields['pass_score'];
			 	 $row[$k]['pass']=($v['score']>=$pass_score)?1:0;
			 	 $row[$k]['pass_txt']=$PASS[$row[$k]['pass']];
			 } else {
			 //�ե~���ΩΪ����פJ��
			   $row[$k]['pass']=1;
			   $row[$k]['pass_txt']=$PASS[$row[$k]['pass']];
			 } // end if
			} //end foreach
			return $row;
		}	
	}	
	
	//���o�ǥͪ��Ҧ��A�Ⱦǲ߸�� 2013.10.22 by smallduh
	function get_service_data($student_sn="") {
		global $CONN;
			if (!empty($student_sn)) {
  		$sql="select a.*,b.student_sn,b.item_sn,round(b.minutes/60) as hours,b.studmemo from stud_service a,stud_service_detail b where a.sn=b.item_sn and b.student_sn='$student_sn' and a.confirm=1 order by service_date";
			$res = $CONN->Execute($sql) or die("Sql error, ".$sql);
			return $res->GetRows();
		}	
	}
?>