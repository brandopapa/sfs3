<?php

// $Id: distest3.php 6382 2011-03-08 02:15:19Z brucelyc $

include "select_data_config.php";
include "../../include/sfs_case_score.php";

sfs_check();

if (intval($_POST['cy'])==0 || intval($_POST['cy'])>5) $_POST['cy']=1;
$ss_link=array(1=>"chinese",2=>"english",3=>"language",4=>"math",5=>"nature",6=>"social",7=>"health",8=>"art",9=>"complex");
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
		$CONN->Execute("drop table temp_kh_score");
		$creat_table_sql="CREATE TABLE `temp_kh_score` (
			`student_sn` int(10) unsigned NOT NULL default '0',
			`seme` varchar(4) NOT NULL default '',
			`ss_no` int(6) unsigned NOT NULL default '0',
			`score` float NOT NULL default '0.0',
			PRIMARY KEY (student_sn,seme,ss_no)
		)";
		$CONN->Execute($creat_table_sql);
	} elseif ($_POST['class_no'] && $_POST['act']=="cal") {
		$query="select a.* from stud_seme a left join stud_base b on a.student_sn=b.student_sn where a.seme_year_seme='$seme_year_seme' and a.seme_class='".$_POST['class_no']."' and b.stud_study_cond in ('0','15') order by a.seme_class,a.seme_num";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			$seme_class=$res->fields[seme_class];
			$sn[]=$res->fields[student_sn];
			$res->MoveNext();
		}
		$query="select stud_study_year from stud_base where student_sn='".pos($sn)."'";
		$res=$CONN->Execute($query);
		$stud_study_year=$res->fields[0];
		for ($i=$starty;$i<=$f_year;$i++) {
			for ($j=1;$j<=2;$j++) {
				$semes[]=sprintf("%03d",$stud_study_year+$i).$j;
			}
		}
		array_pop($semes);
		//�p�⤧�p�Ʀ��
		//�����: 2��, �˭]��: 1��
		if ($_POST['cy']==4)
			$nnum=1;
		else
			$nnum=2;
		$fin_score=cal_fin_score($sn,$semes);
		$s_num=count($semes);
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
					$CONN->Execute("insert into temp_kh_score (student_sn,seme,ss_no,score) values ('$i','$kk','$jj','$sc')");
				}
				$CONN->Execute("insert into temp_kh_score (student_sn,seme,ss_no,score) values ('$i','$s_num','$jj','".round($score/$s_num,$nnum)."')");
			}
		}
		//�p��y���줣�[�v����
		$query="select student_sn,seme,sum(score)/2 as avg from temp_kh_score where ss_no in ('1','2') group by student_sn,seme order by student_sn,seme";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			//�g�J����
			$CONN->Execute("insert into temp_kh_score (student_sn,seme,ss_no,score) values ('".$res->fields['student_sn']."','".$res->fields['seme']."','3','".round($res->fields['avg'],$nnum)."')");
			$res->MoveNext();
		}
		//�p��U�줣�[�v����
		$ss_num=count($ss_link);
		$query="select student_sn,ss_no,sum(score)/$s_num as avg from temp_kh_score group by student_sn,ss_no order by student_sn,ss_no";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			//�g�J����
			$CONN->Execute("insert into temp_kh_score (student_sn,seme,ss_no,score) values ('".$res->fields['student_sn']."','$s_num','".$res->fields['ss_no']."','".round($res->fields['avg'],$nnum)."')");
			$res->MoveNext();
		}
		//�p��U�Ǵ����[�v����
		$query="select student_sn,seme,sum(score)/".($ss_num-2)." as avg from temp_kh_score where ss_no not in ('1','2') group by student_sn,seme order by student_sn,seme";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			//�g�J����
			$CONN->Execute("insert into temp_kh_score (student_sn,seme,ss_no,score) values ('".$res->fields['student_sn']."','".$res->fields['seme']."','".($ss_num+1)."','".round($res->fields['avg'],$nnum)."')");
			$res->MoveNext();
		}
		header("Content-type: text/html; charset=big5");
		echo $_POST['class_no']."...�p�⧹��!";
		exit;
	}
}

if (($_POST['show'] || $_POST['htm'] || $_POST['out'] || $_POST['LOCK']) && $_POST['year_name']) {
	$seme_class=$_POST[year_name]."%";
	$query="select a.*,b.stud_name,b.stud_person_id,b.stud_sex,b.stud_birthday,b.addr_zip,b.stud_addr_1,b.stud_tel_1 from stud_seme a left join stud_base b on a.student_sn=b.student_sn where a.seme_year_seme='$seme_year_seme' and a.seme_class like '$seme_class' and b.stud_study_cond in ('0','15') order by a.seme_class,a.seme_num";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		$seme_class=$res->fields[seme_class];
		$sn[]=$res->fields[student_sn];
		$show_sn[$seme_class][$res->fields[seme_num]]=$res->fields[student_sn];
		$stud_data[$res->fields[student_sn]][stud_name]=$res->fields[stud_name];
		$stud_data[$res->fields[student_sn]][stud_id]=$res->fields[stud_id];
		$stud_data[$res->fields[student_sn]][stud_person_id]=$res->fields[stud_person_id];
		$stud_data[$res->fields[student_sn]][stud_sex]=$res->fields[stud_sex];
		$stud_data[$res->fields[student_sn]][stud_addr_1]=$res->fields[stud_addr_1];
		$stud_data[$res->fields[student_sn]][stud_tel_1]=$res->fields[stud_tel_1];
		$stud_data[$res->fields[student_sn]][addr_zip]=$res->fields[addr_zip];
		$d_arr=explode("-",$res->fields[stud_birthday]);
		$dd=$d_arr[0]-1911;
		if ($_POST['out'] && $_POST['cy']==4) {
			$stud_data[$res->fields[student_sn]][stud_birthday1]=$dd;
			$stud_data[$res->fields[student_sn]][stud_birthday2]=$d_arr[1];
			$stud_data[$res->fields[student_sn]][stud_birthday3]=$d_arr[2];
		} else {
			$stud_data[$res->fields[student_sn]][stud_birthday]=$dd." �~ ".sprintf("%02d",$d_arr[1])." �� ".sprintf("%02d",$d_arr[2])." ��";
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
	$stud_num=count($sn);
	$smarty->assign("sex0",$stud_num);
	$rowdata=array();
	for($i=1;$i<=count($s_arr);$i++) {
		$query="select * from temp_kh_score where ss_no='$i' and seme='$s_num' order by score desc";
		$res=$CONN->Execute($query);
		$j=1;
		$opr=0;
		$osc=0;
		while(!$res->EOF) {
			$score=$res->fields['score'];
			$rowdata[$res->fields['student_sn']][$res->fields['seme']][$res->fields['ss_no']][score]=$score;
			if ($_POST['cy']==2 || $_POST['cy']==4 || $_POST['cy']==5) {
				//�p��ʤ���(���ưϡB�˭]�ϡB�O�F��)
				if ($i==count($s_arr)) {
					if ($osc<>$score) {
						$osc=$score;
						$opr=$j;//�b���Χ@�O���W��
					}
					//�L����i�J
					$pr=ceil($opr/$stud_num*100);
				}
				$rowdata[$res->fields['student_sn']][$res->fields['seme']][$res->fields['ss_no']][pr]=$pr;
			} elseif ($_POST['cy']==3) {
				//�p��Ƨ�(�x�n��)
				if ($i==count($s_arr)) {
					if ($osc<>$score) {
						$osc=$score;
						$opr=$j;//�b���Χ@�O���W��
					}
					$pr=$opr;
				}
				$rowdata[$res->fields['student_sn']][$res->fields['seme']][$res->fields['ss_no']][pr]=$pr;
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
				$rowdata[$res->fields['student_sn']][$res->fields['seme']][$res->fields['ss_no']][pr]=$pr;
			}
			
			$j++;
			$res->MoveNext();
		}
	}
	$query="select * from temp_kh_score";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		$rowdata[$res->fields['student_sn']][$res->fields['seme']][$res->fields['ss_no']][score]=$res->fields['score'];
		$res->MoveNext();
	}
	$semes[$s_num]="avg";
	$smarty->assign("pry",$s_num);
}

if ($_POST['LOCK']) {
	foreach($rowdata as $sn=>$d) {
		foreach ($d as $sm=>$dd) {
			foreach ($dd as $ss_no=>$ddd) {
				$query="insert into dis_score_fin (student_sn,year,seme,ss_no,score,pr) values ('$sn','$sel_year','$sm','$ss_no','".$ddd['score']."','".$ddd['pr']."')";
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
		$x->setRowText(array("�ǮեN�X","�Z��","�y��","�Ǹ�","�m�W","�����Ҹ�","�ʧO","�ͤ�","�G�W��","�G�W�^","�G�W��","�G�W��","�G�W��","�G�W��","�G�W��","�G�W��","�G�W�`","�G�U��","�G�U�^","�G�U��","�G�U��","�G�U��","�G�U��","�G�U��","�G�U��","�G�U�`","�T�W��","�T�W�^","�T�W��","�T�W��","�T�W��","�T�W��","�T�W��","�T�W��","�T�W�`","�ꥭ","�^��","�ƥ�","�ۥ�","����","����","����","�","�`��","��PR","�^PR","��PR","��PR","��PR","��PR","��PR","��PR","�`PR","�G�W��w","�G�W�^�w","�G�W�Ʃw","�G�W�۩w","�G�W���w","�G�W5�w��","�G�U��w","�G�U�^�w","�G�U�Ʃw","�G�U�۩w","�G�U���w","�G�U5�w��","�T�W��w","�T�W�^�w","�T�W�Ʃw","�T�W�۩w","�T�W���w","�T�W5�w��","��w��","�^�w��","�Ʃw��","�۩w��","���w��","5�w��","��wPR","�^�wPR","�ƩwPR","�۩wPR","���wPR","5�wPR","�a���m�W","�q��","�l���ϸ�","�a�}","���W�ǮեN�X","��O�N�X","���W����","�S�ب���","�G�W�y","�G�U�y","�T�W�y","�y����","�yPR"));
	foreach($show_sn as $seme_class => $d) {
		foreach($d as $site => $sn) {
			$cno=substr($seme_class,-2,2);
			if ($_POST['cy']==4)
				$row_arr=array($stud_data[$sn][stud_name],$stud_data[$sn][stud_sex],$stud_data[$sn][stud_person_id],$stud_data[$sn][stud_birthday1],$stud_data[$sn][stud_birthday2],$stud_data[$sn][stud_birthday3],"","","",3,$cno,$site,$s[sch_id],$s[sch_cname],($stud_study_year+3),"","",$stud_data[$sn][stud_tel_1],$stud_data[$sn][stud_tel_1],$stud_data[$sn][addr_zip],$stud_data[$sn][stud_addr_1]);
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
}

$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE); 
$smarty->assign("module_name","�K�դJ�ǳ���-99���ϰ���¾"); 
$smarty->assign("SFS_MENU",$menu_p); 
$smarty->assign("year_seme_menu",year_seme_menu($sel_year,$sel_seme)); 
$smarty->assign("class_year_menu",class_year_menu($sel_year,$sel_seme,$_POST[year_name]));
$smarty->assign("seme_year_seme",$seme_year_seme);
$smarty->assign("semes",$semes);
$smarty->assign("student_sn",$show_sn);
$smarty->assign("stud_data",$stud_data);
$smarty->assign("rowdata",$rowdata);
$smarty->assign("col_arr",$temp_arr);
$smarty->assign("s_arr",$s_arr);
$smarty->assign("sch_arr",get_school_base());
$smarty->assign("ss_link",$ss_link);
if ($_POST['htm']) {
	if ($_POST['cy']==2) {
		$smarty->assign("s_arr",array(1=>"����y��",2=>"�^�y",3=>"�y�奭��",4=>"�ƾǻ��",5=>"�۵M�P�ͬ���޻��",6=>"���|���",7=>"���d�P��|���",8=>"���N�P�H����",9=>"��X���ʻ��",10=>"�Ǵ��`���Z"));
		$smarty->display("stud_basic_test_distest3_print_chc.tpl");
	} elseif ($_POST['cy']==5) {
		$smarty->assign("s_arr",array(1=>"����y��",2=>"�^�y",3=>"�y�奭��",4=>"�ƾǻ��",5=>"�۵M�P�ͬ���޻��",6=>"���|���",7=>"���d�P��|���",8=>"���N�P�H����",9=>"��X���ʻ��",10=>"�Ǵ��`���Z"));
		$smarty->display("stud_basic_test_distest3_print_ttct.tpl");
	} else {
		$smarty->assign("s_arr",array(1=>"����y��",2=>"�^�y",3=>"�y�奭��",4=>"�ƾǻ��",5=>"�۵M�P�ͬ���޻��",6=>"���|���",7=>"���d�P��|���",8=>"���N�P�H����",9=>"��X���ʻ��",10=>"�Ǵ��`���Z"));
		$smarty->display("stud_basic_test_distest3_print.tpl");
	}
} else
	$smarty->display("stud_basic_test_distest3.tpl");
?>
