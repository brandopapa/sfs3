<?php

// $Id: distest5.php 8373 2015-03-30 06:44:32Z chiming $

include "select_data_config.php";
include "../../include/sfs_case_score.php";

sfs_check();

chk_tbl();

//�M�w���(�Ǭ�)�X�{����
$ss_link=array(1=>"chinese",2=>"english",3=>"language",4=>"math",5=>"social",6=>"nature",7=>"art",8=>"health",9=>"complex");
//$ss_link=array(1=>"chinese",2=>"english",3=>"language",4=>"math",5=>"nature",6=>"social",7=>"health",8=>"art",9=>"complex");
if ($IS_JHORES==0)
	$f_year=5;
else
	$f_year=2;

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
//�ˬd���Z�O�_�w�ʦs
$chk=chk_dis($sel_year);
if ($chk[2]) header("Location: chart.php");

if ($_POST['cy']==2 || $_POST['cy']==3 || $_POST['cy']==4 || $_POST['cy']==5) {
	$starty=0;
	$y_arr=array(1=>"�@�W",2=>"�@�U",3=>"�G�W",4=>"�G�U",5=>"�T�W");
} else {
	$starty=1;
	$y_arr=array(1=>"�G�W",2=>"�G�U",3=>"�T�W");
}
$s_arr=array(1=>"��",2=>"�^",3=>"�y",4=>"��",5=>"��",6=>"��",7=>"��",8=>"��",9=>"��",10=>"�`");
//$s_arr=array(1=>"��",2=>"�^",3=>"�y",4=>"��",5=>"��",6=>"��",7=>"��",8=>"��",9=>"��",10=>"�`");

if ($_POST[year_name]) {
	$seme_class=intval($_POST[year_name])."%";
	$query="select distinct seme_class from stud_seme where seme_year_seme='$seme_year_seme' and seme_class like '$seme_class%' order by seme_class";
	$res=$CONN->Execute($query);
	$class_arr=array();
	while(!$res->EOF) {
		$class_arr[$res->fields['seme_class']]=$res->fields['seme_class'];
		$res->MoveNext();
	}
	$smarty->assign("class_arr",$class_arr);

	if ($_POST['clean']) {
		$CONN->Execute("drop table temp_tcc_score");
		$creat_table_sql="CREATE TABLE `temp_tcc_score` (
			`student_sn` int(10) unsigned NOT NULL default '0',
			`seme` varchar(4) NOT NULL default '',
			`ss_no` int(6) unsigned NOT NULL default '0',
			`score` float NOT NULL default '0.0',
			`pr` int(6) NOT NULL default '0',
			`sp_score` float NOT NULL default '0.0',
			`sp_pr` int(6) NOT NULL default '0',
			PRIMARY KEY (student_sn,seme,ss_no)
		)";
		$CONN->Execute($creat_table_sql);
	} elseif ($_POST['class_no'] && $_POST['act']=="cal") {
		$query="select a.* from stud_seme_dis a left join stud_base b on a.student_sn=b.student_sn where a.seme_year_seme='$seme_year_seme' and a.seme_class='".$_POST['class_no']."' and b.stud_study_cond in ($cal_str) order by a.seme_class,a.seme_num";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			$seme_class=$res->fields[seme_class];
			$sn[]=$res->fields[student_sn];
			$res->MoveNext();
		}
		$stud_study_year=get_stud_study_year($seme_year_seme,$_POST['year_name']);
		for ($i=$starty;$i<=$f_year;$i++) {
			for ($j=1;$j<=2;$j++) {
				$semes[]=sprintf("%03d",$stud_study_year+$i).$j;
			}
		}
		array_pop($semes);
		//�p�⤧�p�Ʀ��
		$nnum=2;
		$fin_score=cal_fin_score($sn,$semes);
		$s_num=count($semes);//�Ǵ���
		foreach($sn as $i) {
			reset($ss_link);
			foreach($ss_link as $jj => $j) {
				if ($j=="language") continue;
				reset($semes);
				$score=0;
				foreach($semes as $kk => $k) {
					//���ƭp��ĥ|�ˤ��J
					$sc=round($fin_score[$i][$j][$k]['score'],$nnum);
					$score+=$sc;
					//�g�J����
					$CONN->Execute("insert into temp_tcc_score (student_sn,seme,ss_no,score) values ('$i','$kk','$jj','$sc')");
				}
				$CONN->Execute("insert into temp_tcc_score (student_sn,seme,ss_no,score) values ('$i','$s_num','$jj','".round($score/$s_num,$nnum)."')");
			}
		}
		//�p��y���줣�[�v����
		$query="select student_sn,seme,sum(score) as sc from temp_tcc_score where ss_no in ('1','2') group by student_sn,seme order by student_sn,seme";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			//�g�J����
			$sc=$res->fields['sc'];
			$CONN->Execute("insert into temp_tcc_score (student_sn,seme,ss_no,score) values ('".$res->fields['student_sn']."','".$res->fields['seme']."','3','".round(($sc/2),$nnum)."')");
			$res->MoveNext();
		}
		//�p��U�줣�[�v����
		$ss_num=count($ss_link);//��ؼ�
		$query="select student_sn,ss_no,sum(score) as sc from temp_tcc_score group by student_sn,ss_no order by student_sn,ss_no";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			//�g�J����
			$sc=$res->fields['sc'];
			$CONN->Execute("insert into temp_tcc_score (student_sn,seme,ss_no,score) values ('".$res->fields['student_sn']."','$s_num','".$res->fields['ss_no']."','".round($sc/$s_num,$nnum)."')");
			$res->MoveNext();
		}
		//�p��U�Ǵ����[�v����(�Ǵ��`��/8)
		$query="select student_sn,seme,sum(score) as sc from temp_tcc_score where ss_no not in ('3') group by student_sn,seme order by student_sn,seme";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			//�g�J����
			$sc=$res->fields['sc'];
			$CONN->Execute("insert into temp_tcc_score (student_sn,seme,ss_no,score) values ('".$res->fields['student_sn']."','".$res->fields['seme']."','".($ss_num+1)."','".round($sc/($ss_num-1),$nnum)."')");
			$res->MoveNext();
		}
		//�̫᪺�`�����A�H�U�Ǵ���������
		$query="select student_sn,sum(score) as sc from temp_tcc_score where ss_no='".($ss_num+1)."' and seme<'$s_num' group by student_sn order by student_sn";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			//�g�J����
			$sc=$res->fields['sc'];
			$CONN->Execute("update temp_tcc_score set score='".round(($sc/$s_num),$nnum)."' where student_sn='".$res->fields['student_sn']."' and seme='$s_num' and ss_no='".($ss_num+1)."'");
			$res->MoveNext();
		}		
		header("Content-type: text/html; charset=big5");
		echo $_POST['class_no']."...�p�⧹��!";
		exit;
	} elseif ($_POST['act']=="sort") {
		//�ʤ���Ƨ�
		//���B�z�����Ǵ����Z�ĭp�ǥ�
		$query="select * from stud_seme_dis where seme_year_seme='$seme_year_seme' and (stud_kind in ('2','7') or sp_cal=1)";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			$s=$res->fields['student_sn'];
			$cal=array();
			$en_score=array();
			for($i=0;$i<3;$i++) if ($res->fields['enable'.$i]) $cal[]=$i;
			if (count($cal)>0) {
				foreach($cal as $en_seme) {
					$query2="select * from temp_tcc_score where seme='$en_seme' and student_sn='$s' order by ss_no";
					$res2=$CONN->Execute($query2);
					while(!$res2->EOF) {
						$en_score[$res2->fields['ss_no']]+=$res2->fields['score'];
						$res2->MoveNext();
					}
				}
				foreach($en_score as $ss_no=>$sc) {
					$query2="update temp_tcc_score set score='".round($sc/count($cal),2)."' where student_sn='$s' and seme='3' and ss_no='$ss_no'";
					$res2=$CONN->Execute($query2);
				}
			}
			$res->MoveNext();
		}

		//���X�J�Ǧ~
		$stud_study_year=get_stud_study_year($seme_year_seme,$_POST['year_name']);

		//���X�ĭp�Ǵ�
		for ($i=$starty;$i<=$f_year;$i++) {
			for ($j=1;$j<=2;$j++) {
				$semes[]=sprintf("%03d",$stud_study_year+$i).$j;
			}
		}
		array_pop($semes);
		for($i=1;$i<=count($y_arr);$i++) {
			for($j=1;$j<=count($s_arr);$j++) {
				$temp_arr[$i.$j]=$y_arr[$i].$s_arr[$j];
			}
			$temp2_arr[$i]=$semes[$i-1];
		}
		$s_num=count($semes);//�Ǵ��`��
		$query="select count(*) as nums from stud_seme_dis where seme_year_seme='$seme_year_seme' and cal>'0'";
		$res=$CONN->Execute($query);
		$stud_num=$res->fields['nums'];//�ѻP���Z�ƧǪ��ǥ��`��
		$aper=$stud_num/100;//�C�ӾǥͩҦ����ʤ���
		for($i=1;$i<=count($s_arr);$i++) {
			$query="select a.* from temp_tcc_score a left join stud_seme_dis b on a.student_sn=b.student_sn where a.ss_no='$i' and a.seme='$s_num' and b.cal>0 and b.seme_year_seme='$seme_year_seme' order by a.score desc";
			$res=$CONN->Execute($query);
			$j=1;//�ثe�ʤ���
			$n=0;//�ثe�`�H��
			$osc=0;//�ثe����
			while(!$res->EOF) {
				$n++;
				$score=$res->fields['score'];
				if ($osc<>$score) {
					$osc=$score;
					while(ceil($aper*$j)<$n) $j++;
				}
				$pr=$j;
				$CONN->Execute("update temp_tcc_score set pr='$pr' where student_sn='".$res->fields['student_sn']."' and seme='".$res->fields['seme']."' and ss_no='".$res->fields['ss_no']."'");
				$res->MoveNext();
			}
		}
		
		//�B�z�S�ؾǥͦ��Z
		//��ذ}�C
		$s_arr=array(1=>"����y��",2=>"�^�y",3=>"�y�奭��",4=>"�ƾ�",5=>"���|",6=>"�۵M�P�ͬ����",7=>"���N�P�H��",8=>"���d�P��|",9=>"��X����",10=>"�Ǵ����Z����");
		$query="select * from stud_seme_dis where seme_year_seme='$seme_year_seme' and seme_class like '$seme_class' and sp_kind>'0'";
		$res=$CONN->Execute($query);
		$myplus=array();
		while(!$res->EOF) {
			$sn[]=$res->fields['student_sn'];
			$myplus[$res->fields['student_sn']]=$plus_arr[$res->fields['sp_kind']];
			$res->MoveNext();
		}
		if (count($sn)>0) {
			$allsn="'".implode("','",$sn)."'";
			$query="select * from temp_tcc_score where student_sn in ($allsn)";
			$res=$CONN->Execute($query);
			$rowdata=array();
			while(!$res->EOF) {
				$rowdata[$res->fields['student_sn']][$res->fields['seme']][$res->fields['ss_no']]['score']=$res->fields['score'];
				$rowdata[$res->fields['student_sn']][$res->fields['seme']][$res->fields['ss_no']]['pr']=$res->fields['pr'];
				$res->MoveNext();
			}

			foreach($rowdata as $s=>$d) {
				reset($s_arr);
				foreach($s_arr as $ss_no=>$dd) {
					$plus=1+$myplus[$s]/100;
					$sc=$rowdata[$s][3][$ss_no][score]*$plus;
					$query="select * from temp_tcc_score where seme='3' and ss_no='$ss_no' and score>='$sc' order by pr desc limit 0,1";
					$res=$CONN->Execute($query);
					$upr=$res->fields['pr'];
					$mypr=($upr=="")?1:$upr;
					$query="update temp_tcc_score set sp_score='$sc', sp_pr='$mypr' where seme='3' and ss_no='$ss_no' and student_sn='$s'";
					$res=$CONN->Execute($query);
				}
			}
		}
	}
}

if (($_POST['show'] || $_POST['htm'] || $_POST['out5'] || $_POST['out5s'] || $_POST['out'] || $_POST['out_chc'] || $_POST['out_ct'] || $_POST['LOCK']) && $_POST['year_name']) {
	$seme_class=$_POST[year_name]."%";
	$query="select a.*,b.stud_id,b.stud_name,b.stud_person_id,b.stud_sex,b.stud_birthday,a.zip,a.addr,a.tel,a.cell,a.parent from stud_seme_dis a left join stud_base b on a.student_sn=b.student_sn where a.seme_year_seme='$seme_year_seme' and a.seme_class like '$seme_class' order by a.seme_class,a.seme_num";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		$seme_class=$res->fields[seme_class];
		$s=$res->fields[student_sn];
		$sn[]=$s;
		$show_sn[$seme_class][$res->fields[seme_num]]=$res->fields[student_sn];
		$stud_data[$s]['stud_name']=$res->fields[stud_name];
		$stud_data[$s]['stud_id']=$res->fields[stud_id];
		$stud_data[$s]['stud_person_id']=$res->fields[stud_person_id];
		$stud_data[$s]['stud_sex']=$res->fields[stud_sex];
		$stud_data[$s]['stud_addr']=$res->fields["addr"];
		$stud_data[$s]['stud_tel']=$res->fields["tel"];
		$stud_data[$s]['stud_cell']=$res->fields["cell"];
		$stud_data[$s]['addr_zip']=$res->fields["zip"];
		$stud_data[$s]['parent_name']=$res->fields["parent"];
		$stud_data[$s]['area1']=$res->fields['area1'];
		$stud_data[$s]['area2']=$res->fields['area2'];
		$stud_data[$s]['stud_kind']=$res->fields['stud_kind'];
		$stud_data[$s]['hand_kind']=$res->fields['hand_kind'];
		$stud_data[$s]['sp_kind']=$res->fields['sp_kind'];
		$stud_data[$s]['lowincome']=$res->fields['lowincome'];
		$stud_data[$s]['unemployed']=$res->fields['unemployed'];
		$stud_data[$s]['midincome']=$res->fields['midincome'];
		$stud_data[$s]['enable0']=$res->fields['enable0'];
		$stud_data[$s]['enable1']=$res->fields['enable1'];
		$stud_data[$s]['enable2']=$res->fields['enable2'];
		$stud_data[$s]['sp_cal']=$res->fields['sp_cal'];
		$d_arr=explode("-",$res->fields[stud_birthday]);
		$dd=$d_arr[0]-1911;
		if (($_POST['out'] && $_POST['cy']==4) || $_POST['out5'] || $_POST['out5s']) {
			$stud_data[$s]['stud_birthday1']=$dd;
			$stud_data[$s]['stud_birthday2']=$d_arr[1];
			$stud_data[$s]['stud_birthday3']=$d_arr[2];
		} else {
			$stud_data[$s]['stud_birthday']=$dd." �~ ".sprintf("%02d",$d_arr[1])." �� ".sprintf("%02d",$d_arr[2])." ��";
		}
		$res->MoveNext();
	}

	//���X�J�Ǧ~
	$stud_study_year=get_stud_study_year($seme_year_seme,$_POST['year_name']);

	//���X�ĭp�Ǵ�
	for ($i=$starty;$i<=$f_year;$i++) {
		for ($j=1;$j<=2;$j++) {
			$semes[]=sprintf("%03d",$stud_study_year+$i).$j;
		}
	}
	array_pop($semes);
	for($i=1;$i<=count($y_arr);$i++) {
		for($j=1;$j<=count($s_arr);$j++) {
			$temp_arr[$i.$j]=$y_arr[$i].$s_arr[$j];
		}
		$temp2_arr[$i]=$semes[$i-1];
	}
	$s_num=count($semes);
	$query="select * from temp_tcc_score";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		$s=$res->fields['student_sn'];
		$rowdata[$s][$res->fields['seme']][$res->fields['ss_no']]['score']=$res->fields['score'];
		$rowdata[$s][$res->fields['seme']][$res->fields['ss_no']]['pr']=$res->fields['pr'];
		$rowdata[$s][$res->fields['seme']][$res->fields['ss_no']]['sp_score']=$res->fields['sp_score'];
		$rowdata[$s][$res->fields['seme']][$res->fields['ss_no']]['sp_pr']=$res->fields['sp_pr'];
		$res->MoveNext();
	}
	$semes[$s_num]="avg";
	$smarty->assign("pry",$s_num);
}

if ($_POST['LOCK']) {
	$CONN->Execute("drop tables `dis_score_fin`");
	chk_fin();
	foreach($rowdata as $sn=>$d) {
		foreach ($d as $sm=>$dd) {
			foreach ($dd as $ss_no=>$ddd) {
				$query="insert into dis_score_fin (student_sn,year,seme,ss_no,score,pr,sp_score,sp_pr) values ('$sn','$sel_year','$sm','$ss_no','".$ddd['score']."','".$ddd['pr']."','".$ddd['sp_score']."','".$ddd['sp_pr']."')";
				$CONN->Execute($query);
			}
		}
	}
	header("Location: chart.php");
}

if ($_POST['out']) {
	$s=get_school_base();
	require_once "../../include/sfs_case_excel.php";
	$x=new sfs_xls();
	$x->setUTF8();
	$x->setBorderStyle(1);
	$x->addSheet("Sheet1");
	//��줤��W��
	if ($_POST['cy']==4)
		$x->setRowText(array("�ǥͩm�W","�ʧO","�����Ҹ�","�X�ͦ~","�X�ͤ�","�X�ͤ�","�ǥͨ���","���߻�ê���O","�O�_�K�����W","�~��","�Z��","�y��","���W�ꤤ�N�X(6�X)","���W�ꤤ�W��","���~�~��","�ӽ�(�˰e)�����W��","�a���m�W","�q��","��ʹq�� ���X","�l���ϸ�","�ǥͦa�}","���","�^�y","�y���줭�Ǵ�����","�ƾǻ�줭�Ǵ�����","���|��줭�Ǵ�����","�۵M�P�ͬ���޻�줭�Ǵ�����","���d�P��|��줭�Ǵ�����","���N�P�H���줭�Ǵ�����","��X���ʻ�줭�Ǵ�����","���Ǵ��C�j��쥭�����Z(�[�v)","���ձƦW�ʤ���(�V�C���Z�V�n)"));
	else
		$x->setRowText(array("�ǮեN�X","�Z��","�y��","�Ǹ�","�m�W","�����Ҹ�","�ʧO","�ͤ�","�G�W��","�G�W�^","�G�W��","�G�W��","�G�W��","�G�W��","�G�W��","�G�W��","�G�W�`","�G�U��","�G�U�^","�G�U��","�G�U��","�G�U��","�G�U��","�G�U��","�G�U��","�G�U�`","�T�W��","�T�W�^","�T�W��","�T�W��","�T�W��","�T�W��","�T�W��","�T�W��","�T�W�`","�ꥭ","�^��","�ƥ�","����","�ۥ�","����","����","�","�`��","��ʤ�","�^�ʤ�","�Ʀʤ�","���ʤ�","�ۦʤ�","���ʤ�","���ʤ�","��ʤ�","�`�ʤ�","�G�W��w","�G�W�^�w","�G�W�Ʃw","�G�W���w","�G�W�۩w","�G�W5�w��","�G�U��w","�G�U�^�w","�G�U�Ʃw","�G�U���w","�G�U�۩w","�G�U5�w��","�T�W��w","�T�W�^�w","�T�W�Ʃw","�T�W���w","�T�W�۩w","�T�W5�w��","��w��","�^�w��","�Ʃw��","���w��","�۩w��","5�w��","��w�ʤ�","�^�w�ʤ�","�Ʃw�ʤ�","���w�ʤ�","�۩w�ʤ�","5�w�ʤ�","�a���m�W","�q��","�l���ϸ�","�a�}","���W�ǮեN�X","��O�N�X","���W����","�S�ب���","�G�W�y","�G�U�y","�T�W�y","�y����","�y�ʤ�"));
	foreach($show_sn as $seme_class => $d) {
		foreach($d as $site => $sn) {
			$cno=substr($seme_class,-2,2);
			if ($_POST['cy']==4)
				$row_arr=array($stud_data[$sn]['stud_name'],$stud_data[$sn]['stud_sex'],$stud_data[$sn]['stud_person_id'],$stud_data[$sn]['stud_birthday1'],$stud_data[$sn]['stud_birthday2'],$stud_data[$sn]['stud_birthday3'],$stud_data[$sn]['stud_kind'],"","",3,$cno,$site,$s[sch_id],$s[sch_cname],($stud_study_year+3),"","",$stud_data[$sn][stud_tel_1],$stud_data[$sn][stud_tel_1],$stud_data[$sn][addr_zip],$stud_data[$sn][stud_addr_1]);
			else
				$row_arr=array($s[sch_id],$cno,$site,$stud_data[$sn][stud_id],$stud_data[$sn][stud_name],$stud_data[$sn][stud_person_id],$stud_data[$sn][stud_sex],$stud_data[$sn][stud_birthday]);
			if ($_POST['cy']==4) {
				foreach($s_arr as $j => $sl) {
					$row_arr[]=$rowdata[$sn][5][$j][score];
				}
				$row_arr[]=$rowdata[$sn][5][8][pr];
			} else {
				$row_arr2=array();
				foreach($semes as $i => $si) {
					foreach($s_arr as $j => $sl) {
						if ($j==3)
							$row_arr2[]=$rowdata[$sn][$i][$j][score];
						else
							$row_arr[]=$rowdata[$sn][$i][$j][score];
					}
				}
				foreach($s_arr as $j => $sl) {
					if ($j==3)
						$row_arr2[]=$rowdata[$sn][$i][$j][pr];
					else
						$row_arr[]=$rowdata[$sn][$i][$j][pr];
				}
				for($i=0;$i<30;$i++) $row_arr[]="";
				$row_arr[]="";
				$row_arr[]=$stud_data[$sn][stud_tel_1];
				$row_arr[]=$stud_data[$sn][addr_zip];
				$row_arr[]=$stud_data[$sn][stud_addr_1];
				for($i=0;$i<4;$i++) $row_arr[]="";
				foreach($row_arr2 as $d) $row_arr[]=$d;
			}
			$data_arr[]=$row_arr;
		}
	}
	$x->items=$data_arr;
	$x->writeSheet();
	$x->process();
	exit;
} elseif ($_POST['out_ct']) {
	//���X�S��ͦ��Z�P���
	$query="select * from temp_tcc_score where sp_score<>'0' and seme='3' order by student_sn,ss_no";
	$res=$CONN->Execute($query);
	$temp_arr=array();
	while(!$res->EOF) {
		$temp_arr[$res->fields['student_sn']][$res->fields['ss_no']]['sp_score']=$res->fields['sp_score'];
		$temp_arr[$res->fields['student_sn']][$res->fields['ss_no']]['sp_pr']=$res->fields['sp_pr'];
		$res->MoveNext();
	}

	//���X�S��ͥ[�����
	$query="select * from stud_seme_dis where sp_kind>'0'";
	$res=$CONN->Execute($query);
	$myplus=array();
	while(!$res->EOF) {
		$myplus[$res->fields['student_sn']]=$plus_arr[$res->fields['sp_kind']];
		$res->MoveNext();
	}
	
	$s=get_school_base();
	require_once "../../include/sfs_case_excel.php";
	$x=new sfs_xls();
	$x->setUTF8();
	$x->setBorderStyle(1);
	$x->addSheet("Score");
	$x->filename="Score.xls";
	//��줤��W��
	$x->setRowText(array("1.�����Ҹ�","2.��y��(����)","3.�^�y(����)","4.�ƾ�(����)","5.���|(����)","6.�۵M�P�ͬ����(����)","7.���N�P�H��(����)","8.���d�P��|(����)","9.��X����(����)","10.��y��(�ʤ���)","11.�^�y(�ʤ���)","12.�ƾ�(�ʤ���)","13.���|(�ʤ���)","14.�۵M�P�ͬ����(�ʤ���)","15.���N�P�H��(�ʤ���)","16.���d�P��|(�ʤ���)","17.��X����(�ʤ���)","18.��G�W����","19.��G�U����","20.��T�W����","21.3�Ǵ��`����","22.3�Ǵ��ʤ���","23.��y��(�S�ʤ���)","24.�^�y(�S�ʤ���)","25.�ƾ�(�S�ʤ���)","26.���|(�S�ʤ���)","27.�۵M�P�ͬ����(�S�ʤ���)","28.���N�P�H��(�S�ʤ���)","29.���d�P��|(�S�ʤ���)","30.��X����(�S�ʤ���)","31.��G�W����(�S)","32.��G�U����(�S)","33.��T�W����(�S)","34.3�Ǵ��`����(�S)","35.3�Ǵ��ʤ���(�S)","36.��y��(8�W)","37.�^�y(8�W)","38.�ƾ�(8�W)","39.���|(8�W)","40.�۵M�P�ͬ����(8�W)","41.���N�P�H��(8�W)","42.���d�P��|(8�W)","43.��X����(8�W)","44.��y��(8�U)","45.�^�y(8�U)","46.�ƾ�(8�U)","47.���|(8�U)","48.�۵M�P�ͬ����(8�U)","49.���N�P�H��(8�U)","50.���d�P��|(8�U)","51.��X����(8�U)","52.��y��(9�W)","53.�^�y(9�W)","54.�ƾ�(9�W)","55.���|(9�W)","56.�۵M�P�ͬ����(9�W)","57.���N�P�H��(9�W)","58.���d�P��|(9�W)","59.��X����(9�W)"));
	foreach($show_sn as $seme_class => $d) {
		foreach($d as $site => $sn) {
			$row_arr=array($stud_data[$sn][stud_person_id]);
			$row_arr2=array();
			$row_arr3=array();
			$avg_arr=array();
			foreach($semes as $i => $si) $avg=$i;
			foreach($s_arr as $j => $sl) $tol=$j;
			foreach($s_arr as $j => $sl) {
				if ($j==$tol)
					$tavg=$rowdata[$sn][$avg][$j][score];
				elseif ($j==3)
					$row_arr2[]=$rowdata[$sn][$avg][$j][score];
				else
					$row_arr[]=$rowdata[$sn][$avg][$j][score];
			}
			foreach($s_arr as $j => $sl) {
				if ($j==$tol) 
					$tpr=$rowdata[$sn][$avg][$j][pr];
				elseif ($j==3)
					$row_arr2[]=$rowdata[$sn][$avg][$j][pr];
				else
					$row_arr[]=$rowdata[$sn][$avg][$j][pr];
			}
			foreach($semes as $i => $si) {
				if ($i==$avg) continue;
				foreach($s_arr as $j => $sl) {
					if ($j==$tol)
						$avg_arr[]=$rowdata[$sn][$i][$j][score];
					elseif ($j==3)
						$row_arr2[]=$rowdata[$sn][$i][$j][score];
					else
						$row_arr3[]=$rowdata[$sn][$i][$j][score];
				}
			}
			foreach($avg_arr as $d) $row_arr[]=$d;
			$row_arr[]=$tavg;
			$row_arr[]=$tpr;
			foreach($s_arr as $j => $sl) {
				if ($j==$tol) 
					$sp_pr=$temp_arr[$sn][$j]['sp_pr'];
				elseif ($j==3)
					$row_arr2[]=$temp_arr[$sn][$j]['sp_pr'];
				else
					$row_arr[]=$temp_arr[$sn][$j]['sp_pr'];
			}
			if ($myplus[$sn]) {
				$row_arr[]=round($row_arr[17]*(1+$myplus[$sn]/100),2);
				$row_arr[]=round($row_arr[18]*(1+$myplus[$sn]/100),2);
				$row_arr[]=round($row_arr[19]*(1+$myplus[$sn]/100),2);
				$row_arr[]=round($temp_arr[$sn][10]['sp_score'],2);
				$row_arr[]=$temp_arr[$sn][10]['sp_pr'];
			} else
				for($i=1;$i<6;$i++) $row_arr[]="";
			foreach($row_arr3 as $d) $row_arr[]=$d;
			$data_arr[]=$row_arr;
			
		}
	}
	$x->items=$data_arr;
	$x->writeSheet();
	$x->process();
	exit;
} elseif ($_POST['out5']) {
	$s=get_school_base();
	require_once "../../include/sfs_case_excel.php";
	$x=new sfs_xls();
	$x->setUTF8();
	$x->setBorderStyle(1);
	$x->addSheet("student");
	//��줤��W��
	$x->setRowText(array("�ҰϥN�X","�ǮեN�X","���W�Ǹ�","�Ǹ�","�Z��","�y��","�ǥͩm�W","�����Ҹ�","�ʧO","�X�ͦ~","�X�ͤ�","�X�ͤ�","���~�Ǯ�","���~�~��","���w�~","�ǥͨ���","���߻�ê","���o��","�C���J��","���~�Ҥu","���C���J��","��Ʊ��v","�a���m�W","���s���q��","�l���ϸ�","�a�}","���","�^��","�ƾ�","���|","�۵M","���d�P��|","���N�P�H��","��X����","�`����","���(�S�إͥ[����)","�^��(�S�إͥ[����)","�ƾ�(�S�إͥ[����)","���|(�S�إͥ[����)","�۵M(�S�إͥ[����)","���d�P��|(�S�إͥ[����)","���N�P�H��(�S�إͥ[����)","��X����(�S�إͥ[����)","�`����(�S�إͥ[����)"));
	foreach($show_sn as $seme_class => $d) {
		foreach($d as $site => $sn) {
			$cno=substr($seme_class,-2,2);
			$row_arr=array($stud_data[$sn]['area1'],$s['sch_id'],"",$stud_data[$sn]['stud_id'],$cno,$site,$stud_data[$sn]['stud_name'],$stud_data[$sn]['stud_person_id'],$stud_data[$sn]['stud_sex'],$stud_data[$sn]['stud_birthday1'],$stud_data[$sn]['stud_birthday2'],$stud_data[$sn]['stud_birthday3'],$s['sch_id'],($sel_year+1),1,$stud_data[$sn]['stud_kind'],$stud_data[$sn]['hand_kind'],$stud_data[$sn]['area1'],$stud_data[$sn]['lowincome'],$stud_data[$sn]['unemployed'],$stud_data[$sn]['midincome'],1,$stud_data[$sn]['parent_name'],$stud_data[$sn]['stud_tel'],$stud_data[$sn]['addr_zip'],$stud_data[$sn]['stud_addr']);
			$row_arr2=array();
			foreach($s_arr as $j => $sl) {
				if ($j==3)
					$row_arr2[]=$rowdata[$sn][3][$j][pr];
				else
					$row_arr[]=$rowdata[$sn][3][$j][pr];
			}
			if ($stud_data[$sn]['sp_kind']) {
				foreach($s_arr as $j => $sl) {
					if ($j==3)
						$row_arr2[]=$rowdata[$sn][3][$j][sp_pr];
					else
						$row_arr[]=$rowdata[$sn][3][$j][sp_pr];
				}
			} else
				for($i=0;$i<9;$i++) $row_arr[]="";
			//����M�����m���
			$p=$row_arr[32]; $row_arr[32]=$row_arr[31]; $row_arr[31]=$p;
			$p=$row_arr[40]; $row_arr[40]=$row_arr[41]; $row_arr[41]=$p;
			$data_arr[]=$row_arr;
		}
	}
	$x->items=$data_arr;
	$x->writeSheet();
	$x->process();
	exit;
} elseif ($_POST['out_chc']) {
	$s=get_school_base();
	require_once "../../include/sfs_case_excel.php";
	$x=new sfs_xls();
	$x->setUTF8();
	$x->setBorderStyle(1);
	$x->addSheet("Sheet1");
	//��줤��W��
	$x->setRowText(array("�ǥͩm�W","�����Ҧr��","�ǥͨ���","���߻�ê�ǥ�","�Ƿ~���Z�`����","�Ƿ~���Z���ձƦW�ʤ���","��妨�Z�`����","��妨�Z���ձƦW�ʤ���","�^�y���Z�`����","�^�y���Z���ձƦW�ʤ���","�ƾǦ��Z�`����","�ƾǦ��Z���ձƦW�ʤ���","���|���Z�`����","���|���Z���ձƦW�ʤ���","�۵M���Z�`����","�۵M���Z���ձƦW�ʤ���","���N�P�H�妨�Z�`����","���N�P�H�妨�Z���ձƦW�ʤ���","���d�P��|���Z�`����","���d�P��|���Z���ձƦW�ʤ���","��X���ʦ��Z�`����","��X���ʦ��Z���ձƦW�ʤ���","�Ƿ~���Z�`����","�Ƿ~���Z���ձƦW�ʤ���","��妨�Z�`����","��妨�Z���ձƦW�ʤ���","�^�y���Z�`����","�^�y���Z���ձƦW�ʤ���","�ƾǦ��Z�`����","�ƾǦ��Z���ձƦW�ʤ���","���|���Z�`����","���|���Z���ձƦW�ʤ���","�۵M���Z�`����","�۵M���Z���ձƦW�ʤ���","���N�P�H�妨�Z�`����","���N�P�H�妨�Z���ձƦW�ʤ���","���d�P��|���Z�`����","���d�P��|���Z���ձƦW�ʤ���","��X���ʦ��Z�`����","��X���ʦ��Z���ձƦW�ʤ���"));
	foreach($show_sn as $seme_class => $d) {
		foreach($d as $site => $sn) {
			$cno=substr($seme_class,-2,2);
			$row_arr=array($stud_data[$sn][stud_name],$stud_data[$sn][stud_person_id],"","","","");
			$row_arr2=array();
			foreach($s_arr as $j => $sl) {
				if ($j==3)
					$row_arr2[]=$rowdata[$sn][3][$j][pr];
				elseif ($j==10) {
					$row_arr[4]=$rowdata[$sn][3][$j][score];
					$row_arr[5]=$rowdata[$sn][3][$j][pr];
				} else {
					$row_arr[]=$rowdata[$sn][3][$j][score];
					$row_arr[]=$rowdata[$sn][3][$j][pr];
				}
			}
			//�w�d����
			$row_arr[]="";
			$row_arr[]="";
			if ($stud_data[$sn]['sp_kind']) {
				foreach($s_arr as $j => $sl) {
					if ($j==3) {
						$row_arr2[]=$rowdata[$sn][3][$j][sp_score];
						$row_arr2[]=$rowdata[$sn][3][$j][sp_pr];
					} elseif ($j==10) {
						$row_arr[22]=$rowdata[$sn][3][$j][sp_score];
						$row_arr[23]=$rowdata[$sn][3][$j][sp_pr];
					} else {
						$row_arr[]=$rowdata[$sn][3][$j][sp_score];
						$row_arr[]=$rowdata[$sn][3][$j][sp_pr];
					}
				}
			} else
				for($i=0;$i<16;$i++) $row_arr[]="";
			$data_arr[]=$row_arr;
		}
	}
	$x->items=$data_arr;
	$x->writeSheet();
	$x->process();
	exit;
} elseif ($_POST['out5s']) {
	$s=get_school_base();
	require_once "../../include/sfs_case_excel.php";
	$x=new sfs_xls();
	$x->setUTF8();
	$x->setBorderStyle(1);
	$x->addSheet("Sheet1");
	//��줤��W��
	$x->setRowText(array("�ҰϥN�X","�ǮեN�X","���W�Ǹ�","�Ǹ�","�Z��","�y��","�m�W","�����ҲΤ@�s��","�ʧO","�X�ͦ~","�X�ͤ�","�X�ͤ�","���~�ǮեN�X","���~�~��","�w���~���p","�ǥͨ���","���߻�ê�ҥ�","���o��","�C���J��","���~�Ҥu�l�k","��Ʊ��v","�a���m�W","����p������","�l���ϸ�","�a�}","����p�����","�K�վǮեN�X","�ꤤ���W�Ǹ�","���ʤ���","�^�y�ʤ���","�ƾǦʤ���","���|�ʤ���","�۵M�ʤ���","���N�ʤ���","���d�ʤ���","��X�ʤ���","�`���Z�ʤ���","�S�ب���","�S���ʤ���","�S�^�y�ʤ���","�S�ƾǦʤ���","�S���|�ʤ���","�S�۵M�ʤ���","�S���N�ʤ���","�S���d�ʤ���","�S��X�ʤ���","�S�`���Z�ʤ���","�K�W��","�K�W�^","�K�W��","�K�W��","�K�W��","�K�W��","�K�W��","�K�W��","�K�U��","�K�U�^","�K�U��","�K�U��","�K�U��","�K�U��","�K�U��","�K�U��","�E�W��","�E�W�^","�E�W��","�E�W��","�E�W��","�E�W��","�E�W��","�E�W��"));
	foreach($show_sn as $seme_class => $d) {
		foreach($d as $site => $sn) {
			$cno=substr($seme_class,-2,2);
			$row_arr=array($stud_data[$sn]['area1'],$s['sch_id'],"",$stud_data[$sn][stud_id],$cno,$site,$stud_data[$sn][stud_name],$stud_data[$sn][stud_person_id],$stud_data[$sn][stud_sex],$stud_data[$sn][stud_birthday1],$stud_data[$sn][stud_birthday2],$stud_data[$sn][stud_birthday3],$s['sch_id'],($sel_year+1),1,$stud_data[$sn]['stud_kind'],$stud_data[$sn]['hand_kind'],$stud_data[$sn]['area2'],$stud_data[$sn]['lowincome'],$stud_data[$sn]['unemployed'],1,$stud_data[$sn][parent_name],$stud_data[$sn][stud_tel],$stud_data[$sn][addr_zip],$stud_data[$sn][stud_addr],$stud_data[$sn][stud_cell],"","");
			$row_arr2=array();
			foreach($s_arr as $j => $sl) {
				if ($j==3)
					$row_arr2[]=$rowdata[$sn][3][$j][pr];
				else
					$row_arr[]=$rowdata[$sn][3][$j][pr];
			}
			$row_arr[]=$stud_data[$sn]['sp_kind'];
			if ($stud_data[$sn]['sp_kind']) {
				foreach($s_arr as $j => $sl) {
					if ($j==3)
						$row_arr2[]=$rowdata[$sn][3][$j][sp_pr];
					else
						$row_arr[]=$rowdata[$sn][3][$j][sp_pr];
				}
			} else
				for($i=0;$i<9;$i++) $row_arr[]="";
			foreach($semes as $i => $si) {
				foreach($s_arr as $j => $sl) {
					if ($j==3 || $j>9 || $i==3)
						$row_arr2[]=$rowdata[$sn][$i][$j][score];
					else
						$row_arr[]=$rowdata[$sn][$i][$j][score];
				}
			}
			$data_arr[]=$row_arr;
		}
	}
	$x->items=$data_arr;
	$x->writeSheet();
	$x->process();
	exit;
}

$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE); 
$smarty->assign("module_name","�K�դJ�ǳ���"); 
$smarty->assign("SFS_MENU",$menu_p); 
$smarty->assign("year_seme_menu",year_seme_menu($sel_year,$sel_seme)); 
$smarty->assign("class_year_menu",class_year_menu($sel_year,$sel_seme,$_POST[year_name]));
$smarty->assign("seme_year_seme",$seme_year_seme);
$smarty->assign("curr_year",curr_year());//�[�J�Ǧ~��
$smarty->assign("semes",$semes);
$smarty->assign("student_sn",$show_sn);
$smarty->assign("stud_data",$stud_data);
$smarty->assign("rowdata",$rowdata);
$smarty->assign("col_arr",$temp_arr);
$smarty->assign("s_arr",$s_arr);
$smarty->assign("sch_arr",get_school_base());
$smarty->assign("ss_link",$ss_link);
if ($_POST['htm']) {
	$smarty->assign("s_arr",array(1=>"����y��",2=>"�^�y",3=>"�y�奭��",4=>"�ƾ�",5=>"���|",6=>"�۵M�P�ͬ����",7=>"���N�P�H��",8=>"���d�P��|",9=>"��X����",10=>"�Ǵ����Z����"));
//	$smarty->assign("s_arr",array(1=>"����y��",2=>"�^�y",3=>"�y�奭��",4=>"�ƾ�",5=>"�۵M�P�ͬ����",6=>"���|",7=>"���d�P��|",8=>"���N�P�H��",9=>"��X����",10=>"�Ǵ����Z����"));
	$smarty->display("stud_basic_test_distest5_print.tpl");
} else {
	$smarty->display("stud_basic_test_distest5.tpl");
}
?>
