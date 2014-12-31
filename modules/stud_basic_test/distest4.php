<?php

// $Id: distest4.php 5901 2010-03-08 15:56:34Z brucelyc $

// --�t�γ]�w��
include "select_data_config.php";

//�{��
sfs_check();

if (empty($_POST[year_seme])) {
	$sel_year = curr_year(); //�ثe�Ǧ~
	$sel_seme = curr_seme(); //�ثe�Ǵ�
	$year_seme=$sel_year."_".$sel_seme;
	$_POST[year_seme]=$year_seme;
} else {
	$ys=explode("_",$_POST[year_seme]);
	$sel_year=$ys[0];
	$sel_seme=$ys[1];
}
$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
if ($_POST['step']=="" && $_POST['year_name']) $_POST['next']=1;
if ($_POST['next']) $_POST['step']+=1;

if ($_POST['year_name']) {
	//���X�J�Ǧ~
	$stud_study_year=get_stud_study_year($seme_year_seme,$_POST['year_name']);

	//���X�ˬd�ξǴ����
	for ($i=1;$i<=2;$i++) {
		for ($j=1;$j<=2;$j++) {
			$semes[]=($stud_study_year+$i).$j;
		}
	}
	array_pop($semes);

	//�ˬd���Z�O�_�w�ʦs
	$chk=chk_dis($sel_year,$semes);
	if ($chk[3]) header("Location: chart.php");
	else $semes=array();

	//�R����ǥͦh�l���Z
	if ($_POST['del'] && $_POST['step']==3) {
		//����X�n�B�z���Ǵ�
		$seme_arr=array();
		$tbl_arr=array();
		for($i=$stud_study_year;$i<=$stud_study_year+2;$i++) {
			for($j=1;$j<=2;$j++) {
				$seme_arr[]=$i.$j;
				$tbl_arr[$i.$j]="score_semester_".$i."_".$j;
			}
		}
		$seme_str="and move_year_seme in ('".implode("','",$seme_arr)."')";
		//���X�Ҧ���J�ǥ͸��
		$query="select * from stud_move where move_kind='2' $seme_str order by move_date";
		$res=$CONN->Execute($query);
		$sn_arr=array();
		$rowdata=array();
		while(!$res->EOF) {
			reset($seme_arr);
			foreach($seme_arr as $d) {
				if ($d < $res->fields['move_year_seme']) $rowdata[$d][]=$res->fields['student_sn'];
			}
			$res->MoveNext();
		}
		//�R�������s�b�����
		foreach($rowdata as $s=>$d) {
			if (count($d)>0) {
				$sn_str="'".implode("','",$d)."'";
				$query="delete from ".$tbl_arr[$s]." where student_sn in ($sn_str)";
				$CONN->Execute($query);
			}
		}
		//�B�z���}�C�M��
		$rowdata=array();
	}

	if (intval($_POST['step']==0)) $_POST['step']=1;
	switch($_POST['step']) {
		case 1:
			if ($stud_study_year) {
				for($i=$stud_study_year;$i<=$stud_study_year+2;$i++) {
					for($j=1;$j<=2;$j++) {
						$y_arr[sprintf("%03d",$i).$j]="&nbsp; ".$i."�Ǧ~�ײ�".$j."�Ǵ� &nbsp;";
					}
				}
				$smarty->assign("year_arr",$y_arr);
				//���X�v�s����
				$temp_arr=array();
				$query="select b.year,b.semester from dis_score_ss a left join score_ss b on a.ss_id=b.ss_id where a.year='$sel_year' order by b.year,b.semester";
				$res=$CONN->Execute($query);
				while(!$res->EOF) {
					$seme=sprintf("%03d",$res->fields['year']).$res->fields['semester'];
					$temp_arr[$seme]=$seme;
					$res->MoveNext();
				}
				$smarty->assign("seme_arr",$temp_arr);
			}
			break;
		case 2:
			if (count($_POST['seme'])>0 && $stud_study_year) {
				$temp_arr=array();
				//���X��ئW�}�C
				$subj_arr=array();
				$query="select * from score_subject order by subject_id";
				$res=$CONN->Execute($query);
				while(!$res->EOF) {
					$subj_arr[$res->fields['subject_id']]=$res->fields['subject_name'];
					$res->MoveNext();
				}
				foreach($_POST['seme'] as $k=>$v) {
					if (strlen($v)==4) {
						$year=intval(substr($v,0,3));
						$semester=intval(substr($v,-1,1));
						if ($year && $semester) {
							$query="select * from score_ss where year='$year' and semester='$semester' and class_year='".($year-$stud_study_year+$IS_JHORES+1)."' and enable='1' and print='1' and need_exam='1' order by sort,sub_sort";
							$res=$CONN->Execute($query);
							while(!$res->EOF) {
								$temp_arr[$res->fields['ss_id']][year]=$year;
								$temp_arr[$res->fields['ss_id']][semester]=$semester;
								if ($res->fields['subject_id']) $temp_arr[$res->fields['ss_id']][name]=$subj_arr[$res->fields['subject_id']];
								else $temp_arr[$res->fields['ss_id']][name]=$subj_arr[$res->fields['scope_id']];
								$temp_arr[$res->fields['ss_id']][class_id]=$res->fields['class_id'];
								$res->MoveNext();
							}
							$query="select ss_id,count(ss_id) as n from score_semester_".$year."_".$semester." where test_kind='�w�����q' group by ss_id";
							$res=$CONN->Execute($query);
							while(!$res->EOF) {
								if ($temp_arr[$res->fields['ss_id']][year]==$year) $temp_arr[$res->fields['ss_id']][num]=$res->fields['n'];
								$res->MoveNext();
							}
						}
					}
				}
				$smarty->assign("ss_arr",$temp_arr);
				//���X�v�s����
				$subj_no_arr=array("chinese"=>1,"english"=>2,"math"=>3,"nature"=>4,"social"=>5);
				$query="select * from dis_score_ss order by ss_id";
				$res=$CONN->Execute($query);
				$temp_arr=array();
				while(!$res->EOF) {
					$temp_arr[$res->fields['ss_id']]=$subj_no_arr[$res->fields['subject']];
					$res->MoveNext();
				}
				$smarty->assign("m_arr",array(0=>"���ĭp",1=>"����y��",2=>"�^�y",3=>"�ƾ�",4=>"�۵M�P�ͬ����",5=>"���|"));
				$smarty->assign("subj_arr",$temp_arr);
				$smarty->assign("seme_arr",$_POST['seme']);
			}
			break;
		case 3:
			if (count($_POST['seme'])>0) {
				//�ӦۨB�J�G
				foreach($_POST['seme'] as $d) {
					$y=substr($d,0,3);
					$j=substr($d,-1,1);
					$semes[$d]=$y."�Ǧ~�ײ�".$j."�Ǵ�";
				}

				//��s�K�դJ�Ǭ�ت�
				$query="delete from dis_score_ss where year='$sel_year' and class_year='".$_POST['year_name']."'";
				$CONN->Execute($query);

				//������ذ}�C
				$subj_arr=array(1=>"chinese",2=>"english",3=>"math",4=>"nature",5=>"social");
				foreach($_POST['sel'] as $ss_id => $subj_id) {
					if ($subj_id) {
						$query="insert into dis_score_ss (ss_id,subject,year,class_year) values ('$ss_id','".$subj_arr[$subj_id]."','$sel_year','".$_POST['year_name']."')";
						$CONN->Execute($query);
					}
				}
			} else {
				//���U�T�w�x�s
				$query="select b.year,b.semester from dis_score_ss a left join score_ss b on a.ss_id=b.ss_id where a.year='$sel_year' order by b.year,b.semester";
				$res=$CONN->Execute($query);
				while(!$res->EOF) {
					$d=sprintf("%03d",$res->fields['year']).$res->fields['semester'];
					$semes[$d]=sprintf("%03d",$res->fields['year'])."�Ǧ~�ײ�".$res->fields['semester']."�Ǵ�";
					$res->MoveNext();
				}

				//���⦨�Z���令���ĭp
				if (count($_POST['sn'])>0) {
					$sn_str="'".implode("','",$_POST['sn'])."'";
					$query="update score_semester_move set enable='0' where student_sn in ($sn_str)";
					$CONN->Execute($query);
				}
				//�B�z���Z�ĭp�P�_
				if (count($_POST['sel'])>0) {
					foreach($_POST['sel'] as $sn=>$v) {
						foreach($v as $ys=>$vv) {
							$year=intval(substr($ys,0,3));
							$semester=substr($ys,-1,1);
							foreach($vv as $t=>$vvv) {
								//�A��Ŀ諸���Z�令�ĭp
								$query="update score_semester_move set enable='1' where student_sn='$sn' and year='$year' and semester='$semester' and test_sort='$t'";
								$CONN->Execute($query);
							}
						}
					}
				}
			}
	
			//���X�U�Ǵ��w�Ҧ���
			foreach($semes as $d=>$v) {
				$y=substr($d,0,3);
				$j=substr($d,-1,1);
				$db[]="score_semester_$y_$j";
				$query="select * from score_setup where year='".intval($y)."' and semester='$j' and class_year='".($y-$stud_study_year+$IS_JHORES+1)."' and enable='1'";
				$res=$CONN->Execute($query);
				$times[$d]=$res->fields['performance_test_times'];
			}

			//���X�Ҧ���J�ǥ͸��
			$query="select * from stud_move where move_kind='2' order by move_date";
			$res=$CONN->Execute($query);
			$sn_arr=array();
			$rowdata=array();
			while(!$res->EOF) {
				$sn_arr[]=$res->fields['student_sn'];
				$rowdata[$res->fields['student_sn']][move_year_seme]=sprintf("%04d",$res->fields['move_year_seme']);
				$rowdata[$res->fields['student_sn']][move_date]=$res->fields['move_date'];
				$res->MoveNext();
			}
			if (count($sn_arr)>0) {
				$sn_str="'".implode("','",$sn_arr)."'";
				$query="select * from stud_seme where seme_year_seme='$seme_year_seme' and seme_class like '".$_POST['year_name']."%' and student_sn in ($sn_str)";
				$res=$CONN->Execute($query);
				$sn_arr=array();
				while(!$res->EOF) {
					$sn_arr[]=$res->fields['student_sn'];
					$rowdata[$res->fields['student_sn']][seme_class]=$res->fields['seme_class'];
					$rowdata[$res->fields['student_sn']][seme_num]=$res->fields['seme_num'];
					$res->MoveNext();
				}
				if (count($sn_arr)>0) {
					$sn_str="'".implode("','",$sn_arr)."'";
					$query="select * from stud_base where student_sn in ($sn_str) and stud_study_cond in ('0','5','15') order by curr_class_num";
					$res=$CONN->Execute($query);
					$sn_arr=array();
					while(!$res->EOF) {
						$sn_arr[]=$res->fields['student_sn'];
						$rowdata[$res->fields['student_sn']][stud_name]=$res->fields['stud_name'];
						$rowdata[$res->fields['student_sn']][stud_sex]=$res->fields['stud_sex'];
						$res->MoveNext();
					}
					//���X�ĭp�P�_���
					$query="select * from score_semester_move where student_sn in ($sn_str) order by student_sn,year,semester,test_sort,enable";
					$res=$CONN->Execute($query);
					$osn=0;
					while(!$res->EOF) {
						$sn=$res->fields['student_sn'];
						if ($sn!=$osn) {
							if ($osn>0) $rowdata[$osn]['testdata']=$temp_arr;
							$temp_arr=array();
							$osn=$sn;
						}
						$temp_arr[(sprintf("%03d",$res->fields['year']).$res->fields['semester'])][$res->fields['test_sort']]=$res->fields['enable'];
						$res->MoveNext();
					}
					if ($osn>0) $rowdata[$osn]['testdata']=$temp_arr;
				}
			}
			$smarty->assign("sn_arr",$sn_arr);
			$smarty->assign("rowdata",$rowdata);
			$smarty->assign("semes",$semes);
			$smarty->assign("times",$times);
			break;
		case 4:
			if ($_POST['act']=="cal") {
				//���X�ǥ͸��
				$query="select * from stud_seme where seme_year_seme='$seme_year_seme' and seme_class = '".$_POST['class_no']."'";
				$res=$CONN->Execute($query);
				$sn_arr=array();
				while(!$res->EOF) {
					$sn_arr[]=$res->fields['student_sn'];
					$res->MoveNext();
				}
				if (count($sn_arr)>0) {
					$sn_str="'".implode("','",$sn_arr)."'";
					$query="select * from stud_base where student_sn in ($sn_str) and stud_study_cond in ('0','5','15') order by curr_class_num";
					$res=$CONN->Execute($query);
					$sn_arr=array();
					while(!$res->EOF) {
						$sn_arr[]=$res->fields['student_sn'];
						$res->MoveNext();
					}
				}
				//���X��ع������
				$query="select a.ss_id,a.subject,b.year,b.semester from dis_score_ss a left join score_ss b on a.ss_id=b.ss_id where a.year='$sel_year' and a.class_year='".$_POST['year_name']."' order by b.year,b.semester";
				$res=$CONN->Execute($query);
				$subj=array();
				$subj_arr=array();
				while(!$res->EOF) {
					$d=sprintf("%03d",$res->fields['year']).$res->fields['semester'];
					if ($semes[$d]=="") $semes[$d]="score_semester_".$res->fields['year']."_".$res->fields['semester'];
					$subj[$res->fields['ss_id']]=$res->fields['subject'];
					$subj_arr[$d][]=$res->fields['ss_id'];
					$res->MoveNext();
				}
				$move_subj=array(1=>"chinese",2=>"english",3=>"math",4=>"nature",5=>"social");
				//���X�q�Ҹ��
				$rowdata=array();
				if (count($sn_arr)>0) {
					$sn_str="'".implode("','",$sn_arr)."'";
					//���X��J�e�q�Ҧ��Z(�D����)
					$query="select * from score_semester_move where student_sn in ($sn_str) and test_kind='�w�����q' and enable='1' order by student_sn,year,semester";
					$res=$CONN->Execute($query);
					while(!$res->EOF) {
						$sc=($res->fields['score']=="-100")?0:$res->fields['score'];
						$rowdata[$res->fields['student_sn']][(sprintf("%03d",$res->fields['year']).$res->fields['semester'])][$move_subj[$res->fields['ss_id']]][$res->fields['test_sort']][]=$sc;
						$res->MoveNext();
					}
					//���X���լq�Ҧ��Z
					foreach($semes as $d => $tbl) {
						$y=substr($d,0,3);
						$s=substr($d,-1,1);
						if (count($subj_arr[$d])>0)
							$subj_str="and ss_id in ('".implode("','",$subj_arr[$d])."')";
						else
							$subj_str="";
						$query="select * from $tbl where student_sn in ($sn_str) $subj_str and test_kind='�w�����q' and test_sort<200";
						$res=$CONN->Execute($query);
						while(!$res->EOF) {
							//�p�G�S����J���Z, �h�{�w��0��
							$sc=($res->fields['score']=="-100")?0:$res->fields['score'];
							$rowdata[$res->fields['student_sn']][$d][$subj[$res->fields['ss_id']]][$res->fields['test_sort']][]=$sc;
							$res->MoveNext();
						}
					}
				}
				//�p��U����
				if (count($rowdata)>0) {
					foreach($rowdata as $sn=>$d) {
						$rowdata2=array();
						foreach($d as $sy=>$dd) {
							$y=intval(substr($sy,0,3));
							$s=substr($sy,-1,1);
							foreach($dd as $sj=>$ddd) {
								if ($sj=="avg") continue;
								$i=0;
								$sgall=0;
								foreach($ddd as $sg=>$dddd) {
									if ($sg=="avg") continue;
									$ii=0;
									$sall=0;
									foreach($dddd as $n=>$sc) {
										//�έp���涥�q���Z��
										$ii++;
										//�έp���涥�q�`��
										$sall+=$sc;
									}
									//�έp��춥�q��
									$i++;
									//�p���춥�q����
									$avg=round($sall/$ii,2);
									$rowdata[$sn][$sy][$sj][$sg][avg]=$avg;
									$CONN->Execute("insert into dis_stage (year,semester,student_sn,subject,stage,score) values ('$y','$s','$sn','$sj','$sg','$avg')");
									//�έp����Ǵ��`��
									$sgall+=$avg;
								}
								//�p�����Ǵ�����
								$avg=round($sgall/$i,2);
								$rowdata[$sn][$sy][$sj][avg]=$avg;
								$CONN->Execute("insert into dis_stage (year,semester,student_sn,subject,stage,score) values ('$y','$s','$sn','$sj','avg','$avg')");
								$rowdata2[$sj][$sy]=$avg;
							}
						}
						//�p��U���`����
						$snall=0;
						foreach($rowdata2 as $sj=>$dd) {
							$i=0;
							$sjavg=0;
							foreach($dd as $sy=>$sc) {
								//�έp���Ǵ���
								$i++;
								//�έp����`��
								$sjavg+=$sc;
							}
							//�p���쥭��
							$avg=round($sjavg/$i,2);
							$CONN->Execute("insert into dis_stage (year,semester,student_sn,subject,stage,score) values ('999','1','$sn','$sj','avg','$avg')");
							$snall+=$avg;
						}
						//�p���`����, �ثe�Τ@���H��(�]�N�O�H����p��)
						$CONN->Execute("insert into dis_stage (year,semester,student_sn,subject,stage,score) values ('999','1','$sn','avg','avg','".round($snall/5,2)."')");
					}
				}
				header("Content-type: text/html; charset=big5");
				echo $_POST['class_no']."...�p�⧹��!";
				exit;
			}

			//�M�Ÿ�ƪ�
			$CONN->Execute("delete from dis_stage");
			//���o�Z�Ű}�C
			$seme_class=intval($_POST[year_name])."%";
			$query="select distinct seme_class from stud_seme where seme_year_seme='$seme_year_seme' and seme_class like '$seme_class%' order by seme_class";
			$res=$CONN->Execute($query);
			$class_arr=array();
			while(!$res->EOF) {
				$class_arr[$res->fields['seme_class']]=$res->fields['seme_class'];
				$res->MoveNext();
			}
			$smarty->assign("class_arr",$class_arr);
			break;
		case 5:
			$s_arr=array(1=>"��",2=>"�^",3=>"��",4=>"��",5=>"��");
			$y_arr=array(1=>"�G�W",2=>"�G�U",3=>"�T�W");
			$ss_map=array("chinese"=>1,"english"=>2,"math"=>3,"nature"=>4,"social"=>5,"avg"=>6);
			//���X�ǥ͸��
			$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
			$seme_class=$_POST[year_name]."%";
			$query="select a.*,b.stud_name,b.stud_person_id,b.stud_sex,b.stud_birthday from stud_seme a left join stud_base b on a.student_sn=b.student_sn where a.seme_year_seme='$seme_year_seme' and a.seme_class like '$seme_class' and b.stud_study_cond in ('0','15') order by a.seme_class,a.seme_num";
			$res=$CONN->Execute($query);
			$sn=array();
			$show_sn=array();
			$stud_data=array();
			while(!$res->EOF) {
				$seme_class=$res->fields[seme_class];
				$sn[]=$res->fields[student_sn];
				$show_sn[$seme_class][$res->fields[seme_num]]=$res->fields[student_sn];
				$stud_data[$res->fields[student_sn]][stud_name]=$res->fields[stud_name];
				$stud_data[$res->fields[student_sn]][stud_id]=$res->fields[stud_id];
				$stud_data[$res->fields[student_sn]][stud_person_id]=$res->fields[stud_person_id];
				$stud_data[$res->fields[student_sn]][stud_sex]=$res->fields[stud_sex];
				$d_arr=explode("-",$res->fields[stud_birthday]);
				$dd=$d_arr[0]-1911;
				$stud_data[$res->fields[student_sn]][stud_birthday]=$dd." �~ ".sprintf("%02d",$d_arr[1])." �� ".sprintf("%02d",$d_arr[2])." ��";
				$res->MoveNext();
			}
			$stud_num=count($sn);

			$temp_arr=array();
			//�C�L�չ��P�ҩ���
			if ($_POST['CHK'] || $_POST['CRT'] || $_POST['LOCK']) {
				//�έp�k�k�ͤH��
				$query="select count(b.student_sn) as num,b.stud_sex from stud_seme a left join stud_base b on a.student_sn=b.student_sn where a.seme_year_seme='$seme_year_seme' and a.seme_class like '".$_POST[year_name]."%' and b.stud_study_cond in ('0','15') group by b.stud_sex order by b.stud_sex";
				$res=$CONN->Execute($query);
				while(!$res->EOF) {
					$s="stud_num_".$res->fields['stud_sex'];
					$$s=$res->fields['num'];
					$smarty->assign("sex".$res->fields['stud_sex'],$res->fields['num']);
					$res->MoveNext();
				}
				for ($i=1;$i<=2;$i++) {
					for ($j=1;$j<=2;$j++) {
						$temp_arr[sprintf("%03d",$stud_study_year+$i).$j]=($stud_study_year+$i)."�Ǧ~�ײ�".$j."�Ǵ�";
					}
				}
				array_pop($temp_arr);
				$temp_arr2=array();
				$query="select distinct concat(year,semester,stage),year,semester,stage from dis_stage";
				$res=$CONN->Execute($query);
				while(!$res->EOF) {
					for($i=1;$i<=$res->fields['stage'];$i++) $temp_arr2[(sprintf("%03d",$res->fields['year']).$res->fields['semester'])][$i]=$i;
					$res->MoveNext();
				}
				//���X���Z
				$query="select * from dis_stage";
				$res=$CONN->Execute($query);
				$rowdata=array();
				while(!$res->EOF) {
					$sc=($res->fields['score']=="-100")?0:$res->fields['score'];
					$rowdata[$res->fields['student_sn']][(sprintf("%03d",$res->fields['year']).$res->fields['semester'])][$res->fields['stage']][$res->fields['subject']][score]=$sc;
					$res->MoveNext();
				}

				foreach($ss_map as $sj=>$sno) {
					$query="select * from dis_stage where stage='avg' and subject='$sj' and year='999' and semester='1' order by score desc";
					$res=$CONN->Execute($query);
					$j=1;
					$j1=1;
					$j2=1;
					$opr=0;
					$opr1=0;
					$opr2=0;
					$osc=0;
					$osc1=0;
					$osc2=0;
					while(!$res->EOF) {
						$score=$res->fields['score'];
						if ($_POST['cy']==2) {
							//�P�_�O�k�k��
							$sex=$stud_data[$res->fields[student_sn]][stud_sex];
							$s="stud_num_".$sex;
							$jj="j".$sex;
							$p="opr".$sex;
							$o="osc".$sex;
							//�p����~�ūe�ʤ���(���ư�)
							if ($osc<>$score) {
								$osc=$score;
								$opr=$j;//�b���Χ@�O���W��
							}
							//�p��k�k�ͫe�ʤ���
							if ($$o<>$score) {
								$$o=$score;
								$$p=$$jj;
							}
							//�L����i�J
							$rowdata[$res->fields['student_sn']][sprintf("%03d",$res->fields['year']).$res->fields['semester']]['avg'][$res->fields['subject']][pr]=ceil($opr/$stud_num*100);
							$rowdata[$res->fields['student_sn']][sprintf("%03d",$res->fields['year']).$res->fields['semester']]['avg'][$res->fields['subject']][pr2]=ceil($$p/$$s*100);
						} else {
							//�p��pr��(�����)
							if ($stud_num<100)
								$pr=intval(98*($stud_num-$j)/($stud_num-1))+1;
							else
								$pr=intval(99*($stud_num-$j)/$stud_num)+1;
							if ($opr!=0) {
								//�p�G���ƻP�e�@�H�ۦP, PR�ȫo���P��, PR�����P�e�@�H�P
								if ($oscore==$score && $opr!=$pr) $pr=$opr;
								else {
									$oscore=$score;
									$opr=$pr;
								}
							}
							$rowdata[$res->fields['student_sn']][sprintf("%03d",$res->fields['year']).$res->fields['semester']]['avg'][$res->fields['subject']][pr]=$pr;
						}
						$j++;
						$$jj++;
						$res->MoveNext();
					}
				}

				//�ʦs���Z
				if ($_POST['LOCK']) {
					foreach($rowdata as $sn=>$d) {
						foreach($d as $sys=>$dd) {
							$y=intval(substr($sys,0,-1));
							$s=substr($sys,-1,1);
							foreach($dd as $stage=>$ddd) {
								foreach($ddd as $subj=>$dddd) {
									$query="insert into dis_stage_fin (year,semester,student_sn,subject,stage,score) value ('$y','$s','$sn','$subj','$stage','".$dddd['score']."')";
									$CONN->Execute($query);
									if ($dddd['pr']) {
										$query="insert into dis_stage_fin (year,semester,student_sn,subject,stage,score) value ('$y','$s','$sn','$subj','pr','".$dddd['pr']."')";
										$CONN->Execute($query);
									}
								}
							}
						}
					}
					header("Location: chart.php");
				}
				$smarty->assign("sch_arr",get_school_base());
				$smarty->assign("student_sn",$show_sn);
				$smarty->assign("stud_data",$stud_data);
				$smarty->assign("s_arr",array("chinese"=>"����y��","english"=>"�^�y","math"=>"�ƾ�","nature"=>"�۵M�P���","social"=>"���|"));
				$smarty->assign("seme_arr",$temp_arr);
				$smarty->assign("stage_arr",$temp_arr2);
				$smarty->assign("rowdata",$rowdata);
				$smarty->assign("sex0",$stud_num);
				if ($_POST['CRT'] && $_POST['cy']==2)
					$smarty->display("stud_basic_test_distest4_print_chc.tpl");
				elseif ($_POST['CRT'] && $_POST['cy']==1)
					$smarty->display("stud_basic_test_distest4_print_tcc.tpl");
				else
					$smarty->display("stud_basic_test_distest4_print.tpl");
				exit;
			}
			//���X�Ǵ����
			for($i=1;$i<=count($y_arr);$i++) {
				for($j=1;$j<=count($s_arr);$j++) {
					$temp_arr[$i.$j]=$y_arr[$i].$s_arr[$j];
				}
			}
			for ($i=1;$i<=2;$i++) {
				for ($j=1;$j<=2;$j++) {
					$semes[]=sprintf("%03d",$stud_study_year+$i).$j;
				}
			}
			array_pop($semes);
			//���X���Z
			$query="select * from dis_stage";
			$res=$CONN->Execute($query);
			while(!$res->EOF) {
				$sc=($res->fields['score']=="-100")?0:$res->fields['score'];
				$rowdata[$res->fields['student_sn']][sprintf("%03d",$res->fields['year']).$res->fields['semester']][$ss_map[$res->fields['subject']]][score]=$sc;
				$res->MoveNext();
			}
			foreach($ss_map as $sj=>$sno) {
				$query="select * from dis_stage where stage='avg' and subject='$sj' and year='999' and semester='1' order by score desc";
				$res=$CONN->Execute($query);
				$j=1;
				$opr=0;
				$osc=0;
				while(!$res->EOF) {
					$score=$res->fields['score'];
					//�p��pr��(�����)
					if ($stud_num<100)
						$pr=intval(98*($stud_num-$j)/($stud_num-1))+1;
					else
						$pr=intval(99*($stud_num-$j)/$stud_num)+1;
					if ($opr!=0) {
						//�p�G���ƻP�e�@�H�ۦP, PR�ȫo���P��, PR�����P�e�@�H�P
						if ($oscore==$score && $opr!=$pr) $pr=$opr;
						else {
							$oscore=$score;
							$opr=$pr;
						}
					}
					$rowdata[$res->fields['student_sn']][sprintf("%03d",$res->fields['year']).$res->fields['semester']][$ss_map[$res->fields['subject']]][pr]=$pr;
					$j++;
					$res->MoveNext();
				}
			}
			//�ץXExcel��
			if ($_POST['XLS']) {
				$s=get_school_base();
				require_once "../../include/sfs_case_excel.php";
				$x=new sfs_xls();
				$x->setUTF8();
				$x->setBorderStyle(1);
				$x->addSheet("Sheet1");
				$x->setRowText(array("�ǮեN�X","�Z��","�y��","�Ǹ�","�m�W","�����Ҹ�","�ʧO","�ͤ�","�G�W��","�G�W�^","�G�W��","�G�W��","�G�W��","�G�W��","�G�W��","�G�W��","�G�W�`","�G�U��","�G�U�^","�G�U��","�G�U��","�G�U��","�G�U��","�G�U��","�G�U��","�G�U�`","�T�W��","�T�W�^","�T�W��","�T�W��","�T�W��","�T�W��","�T�W��","�T�W��","�T�W�`","�ꥭ","�^��","�ƥ�","�ۥ�","����","����","����","�","�`��","��PR","�^PR","��PR","��PR","��PR","��PR","��PR","��PR","�`PR","�G�W��w","�G�W�^�w","�G�W�Ʃw","�G�W�۩w","�G�W���w","�G�W5�w��","�G�U��w","�G�U�^�w","�G�U�Ʃw","�G�U�۩w","�G�U���w","�G�U5�w��","�T�W��w","�T�W�^�w","�T�W�Ʃw","�T�W�۩w","�T�W���w","�T�W5�w��","��w��","�^�w��","�Ʃw��","�۩w��","���w��","5�w��","��wPR","�^�wPR","�ƩwPR","�۩wPR","���wPR","5�wPR","�a���m�W","�q��","�l���ϸ�","�a�}","���W�ǮեN�X","��O�N�X","���W����","�S�ب���","�G�W�y","�G�U�y","�T�W�y","�y����","�yPR"));
				foreach($show_sn as $seme_class => $d) {
					foreach($d as $site => $sn) {
						$cno=substr($seme_class,-2,2);
						$row_arr=array($s[sch_id],$cno,$site,$stud_data[$sn][stud_id],$stud_data[$sn][stud_name],$stud_data[$sn][stud_person_id],$stud_data[$sn][stud_sex],$stud_data[$sn][stud_birthday]);
						for($i=0;$i<45;$i++) $row_arr[]="";
						foreach($semes as $i => $si) {
							foreach($s_arr as $j => $sl) {
								$row_arr[]=$rowdata[$sn][$si][$j][score];
							}
							$row_arr[]="";
						}
						foreach($s_arr as $j => $sl) {
							$row_arr[]=$rowdata[$sn][9991][$j][score];
						}
						$row_arr[]=$rowdata[$sn][9991][6][score];
						foreach($s_arr as $j => $sl) {
							$row_arr[]=$rowdata[$sn][9991][$j][pr];
						}
						$row_arr[]=$rowdata[$sn][9991][6][pr];
						for($i=0;$i<8;$i++) $row_arr[]="";
						$data_arr[]=$row_arr;
					}
				}
				$x->items=$data_arr;
				$x->writeSheet();
				$x->process();
				exit;
			}
			$smarty->assign("student_sn",$show_sn);
			$smarty->assign("stud_data",$stud_data);
			$smarty->assign("rowdata",$rowdata);
			$smarty->assign("s_arr",$s_arr);
			$smarty->assign("col_arr",$temp_arr);
			$smarty->assign("semes",$semes);
			break;
	}
}

$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE); 
$smarty->assign("module_name","�K�դJ�ǳ���-99�˰e"); 
$smarty->assign("SFS_MENU",$menu_p); 
$smarty->assign("year_seme_menu",year_seme_menu($sel_year,$sel_seme)); 
$smarty->assign("class_year_menu",class_year_menu($sel_year,$sel_seme,$_POST[year_name]));
//$smarty->assign("seme_year_seme",$seme_year_seme);
$step_str=array(
	1=>"�m�B�J�@�n��ܩҭn�B�z���Z���Ǧ~�Ǵ�",
	2=>"�m�B�J�G�n�]�w�U�Ǧ~�Ǵ����ҭn�B�z���������",
	3=>"�m�B�J�T�n�����J�ͱĭp���Z <input type=\"submit\" name=\"save\" value=\"�T�w�x�s\">",
	4=>"�m�B�J�|�n�p�⦨�Z <input type=\"button\" id=\"calBtn\" value=\"�}�l�p��\" OnClick=\"cal();\">",
	5=>"�m�B�J���n��ܵ��G <input type=\"submit\" name=\"XLS\" value=\"�ץXXLS��\"> <input type=\"submit\" name=\"CHK\" value=\"�C�X�չ��\"> ");
$smarty->assign("step_str",$step_str[intval($_POST['step'])]);
$smarty->register_function('t2c', 't2c');
$smarty->display("stud_basic_test_distest4.tpl");

function t2c($params, &$smarty)
{
	$times=$params['times'];
	$seme=$params['semes'];
	$sn=$params['sn'];
	$kind=$params['kind'];
	$enable=$params['enable'];
	$temp_str="";
	for($i=1;$i<=$times;$i++) {
		$temp_str.="<input type=\"checkbox\" id=\"sel".$kind."_".$seme.$i."_".$sn."\" name=\"sel[$sn][$seme][$i]\" ".(($enable[$i] || $kind==3)?"checked":"").($kind==3?" disabled":"").">$i ";
	}
	return $temp_str;
}
?>
