<?php
// $Id: print.php 8655 2015-12-21 04:21:47Z chiming $
// ���o�]�w��
include "config.php";

sfs_check();

if ($_POST['year_seme']=="") $_POST['year_seme']=sprintf("%03d",curr_year()).curr_seme();
$sel_year=intval(substr($_POST['year_seme'],0,-1));
$sel_seme=intval(substr($_POST['year_seme'],-1,1));
$seme_year_seme = sprintf("%03d%d",$sel_year,$sel_seme);

//�ˬd�O�_���̪F��, �Y�O, �N�������w�]���ŭ�
//���o�ǮեN�X
	$sql="select sch_id from school_base limit 1";
	$res=$CONN->Execute($sql);
	$sch_id=$res->fields['sch_id'];
	if (substr($sch_id,0,2)=='13') {
		$_POST[test_y]=($_POST[test_y])?$_POST[test_y]:(intval(date("Y"))-1911);
		$_POST[test_m]=($_POST[test_m])?$_POST[test_m]:"";
	} else {
		$_POST[test_y]=($_POST[test_y])?$_POST[test_y]:(intval(date("Y"))-1911);
		$_POST[test_m]=($_POST[test_m])?$_POST[test_m]:date("m");
	}

$class_arr=class_base($seme_year_seme);

//�޲z��
if ($admin==1){
	if ($_POST[me]) {
		$class_num=$_POST[me];
	} else {
		$class_num=($IS_JHORES=="0")?"101":"701";
	}
	$smarty->assign("seme_menu",year_seme_menu($sel_year,$sel_seme));
	$smarty->assign("class_menu",class_name_menu($sel_year,$sel_seme,$class_num));
} else {
	$query="select distinct a.class_id from score_course a,score_ss b where a.ss_id=b.ss_id and a.year='$sel_year' and a.semester='$sel_seme' and a.teacher_sn='".$_SESSION[session_tea_sn]."' and b.link_ss='���d�P��|' order by class_id";
	$res=$CONN->Execute($query);
	//���Юv
	if ($res->RecordCount()>0) {
		while(!$res->EOF) {
			$m=$res->FetchRow();
			$n=explode("_",$m[class_id]);
			$nn=intval($n[2].$n[3]);
			$c_arr[$nn]=$class_arr[$nn];
		}
		if ($_POST[me]) {
			$class_num=$_POST[me];
		} else {
			$class_num=$nn;
		}
		$smarty->assign("class_menu",class_menu($sel_year,$sel_seme,$class_num,$c_arr));
	} else {
		//���o���ЯZ�ťN��
		$class_num=get_teach_class();
		$smarty->assign("class_menu",class_menu($sel_year,$sel_seme,$class_num));
	}
}
//�H�U�T��A�P�@�Z�ǥ͡A�󤣦P�Ǵ������//20151202 wang�W��
	$sel_year_seme = (empty($_POST['year_seme2']))?curr_year().curr_seme():$_POST['year_seme2'];
	$smarty->assign("seme_menu2",year_seme_menu2($sel_year_seme));
	$smarty->assign("admin",$admin); 

if ($class_num) {
	//���o�ǥ͸��
	if($_POST['all_students'] and $_POST['export']){
		$query="select a.student_sn,a.stud_id,a.stud_name,a.stud_sex,a.stud_birthday,a.stud_person_id,b.seme_class,b.seme_num from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$seme_year_seme' and a.stud_study_cond in ($in_study) order by curr_class_num";
		$file_name="{$seme_year_seme}_�ǥ���A��ץX���_����.csv";
	} else {
		$query="select a.student_sn,a.stud_id,a.stud_name,a.stud_sex,a.stud_birthday,a.stud_person_id,b.seme_class,b.seme_num from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$seme_year_seme' and b.seme_class='$class_num' and a.stud_study_cond in ($in_study) order by curr_class_num";
		$file_name="{$seme_year_seme}_�ǥ���A��ץX���_{$class_num}.csv";
	}
	
	$res=$CONN->Execute($query) or die("SQL�L�k����G$query");
	$r=$res->GetRows();
	$stud_arr=array();
	$b_arr=array();
	$g_arr=array();
	while(list($k,$v)=each($r)) {
		$stud_arr[]=$v[student_sn];
		$d=array();
		$d=explode("-",$r[$k][stud_birthday]);
		$r[$k][stud_birthday]=($d[0]-1911)."-".$d[1];
		$r[$k][stud_birthday2]=($d[0]-1911).$d[1].$d[2];
		$r[$k][stud_birthday3]="���إ���".($d[0]-1911)."�~".$d[1]."��";
		if ($v[stud_sex]==1) $b_arr[]=$v[student_sn];
		if ($v[stud_sex]==2) $g_arr[]=$v[student_sn];
	
	}
	$smarty->assign("rowdata",$r);
	$stud_str="'".implode("','",$stud_arr)."'";
	
	//$fd=read_fitness($seme_year_seme,$stud_str);
	//�qfitness_data�쪺��Ƨ令�ϥΦP�@�Z�ǥͫ��w�Ǵ�20151202 wang�ק�
	$fd=read_fitness($sel_year_seme,$stud_str);
 
	//���ͭp�⥭���ɪ��ǥͬy�����r��
	if (count($b_arr)>0) $avg_str[0]="'".implode("','",$b_arr)."'";
	if (count($g_arr)>0) $avg_str[1]="'".implode("','",$g_arr)."'";
	$avg_str[2]=$stud_str;

	//�p��~��
	if ($_POST[cal_age]) {
		
		//echo "<pre>";
		//print_r($_POST);
		//print_r($seme_year_seme);
		//exit();
		reset($r);
		while(list($k,$v)=each($r)) {
			$sn=$v[student_sn];
			
			//2015.01.09 by smallduh �令 �����e�s,���װ_��,�ߩw����,�ߪ;A�� ����ƦA�g�J
			//2015.05.01 by smallduh �令�H�Ŀ�覡,�o�����e����ƦA�g�J�~��
			if ($_POST['check_years_old'][$sn]) {   //�O�_���Ŀ惡��
			
			$d=array();
			$d=explode("-",$v[stud_birthday]);
			/*
			$t_y=($_POST[test_y])?$_POST[test_y]:$fd[$sn][test_y];
			$t_m=($_POST[test_m])?$_POST[test_m]:$fd[$sn][test_m];
			*/
			//�אּ�H�פJ������~�묰�~�֭p����
			//2015.05.01 �ѩ�w���ܬO�_���s�p�⨺�Ǿǥ͡A�ҥH���\������
			$t_y=$fd[$sn][test_y]?$fd[$sn][test_y]:$_POST[test_y];
			$t_m=$fd[$sn][test_m]?$fd[$sn][test_m]:$_POST[test_m];
			//$t_y=$_POST[test_y];
			//$t_m=$_POST[test_m];
			
			//$age=round((($t_y-$d[0])*12+$t_m-$d[1])/12);
			$a=(($t_y-$d[0])*12+$t_m-$d[1])/12;
			$age=floor((($t_y-$d[0])*12+$t_m-$d[1])/12);
      $age=(($a-$age)>0.58)?$age+1:$age; //���C�Ӥ�~�i�@��
			$CONN->Execute("update fitness_data set age='$age',test_y='$t_y',test_m='$t_m' where student_sn='$sn' and c_curr_seme='$seme_year_seme'");
		  }
		}
		//��Ū���
		$fd=read_fitness($seme_year_seme,$stud_str);
	}

	//����ʤ�����
	if ($_POST[cal_per]) {
		reset($r);
		while(list($k,$v)=each($r)) {
			$sn=$v[student_sn];
			$sex=$v[stud_sex]; //1�k�� , 2�k��
			$age=$fd[$sn][age];
			$tall=$fd[$sn][tall];
			$weigh=$fd[$sn][weigh];
			$bmt=round($weigh/($tall/100)/($tall/100),0);
			$prec_t=cal_per(0,$sex,$age,$tall);						//����
			$prec_w=cal_per(1,$sex,$age,$weigh);					//�魫
			$prec_b=cal_per(6,$sex,$age,$bmt); 					  //BMI
			$prec1=cal_per(2,$sex,$age,$fd[$sn][test1]);  //�����e�s
			$prec2=cal_per(3,$sex,$age,$fd[$sn][test2]);  //���װ_��
			$prec3=cal_per(4,$sex,$age,$fd[$sn][test3]);  //�ߩw����
			$prec4=cal_per(5,$sex,$age,$fd[$sn][test4]);  //�ߪ;A��
			$CONN->Execute("update fitness_data set bmt='$bmt',prec_b='$prec_b',prec_t='$prec_t',prec_w='$prec_w',prec1='$prec1',prec2='$prec2',prec3='$prec3',prec4='$prec4' where student_sn='$sn' and c_curr_seme='$seme_year_seme'");
		}
		//��Ū���
		$fd=read_fitness($seme_year_seme,$stud_str);
	}

	//�p�⥭��
	for ($i=0;$i<3;$i++) {
		$query="select avg(tall) as a_tall,avg(weigh) as a_weigh,avg(bmt) as a_bmt,avg(test1) as a_test1,avg(test2) as a_test2,avg(test3) as a_test3,avg(test4) as a_test4 from fitness_data where student_sn in (".$avg_str[$i].") and c_curr_seme='$seme_year_seme'";
                if ($avg_str[$i]) {
                        $res=$CONN->Execute($query);
                        $avg[$i]=$res->FetchRow();
                }
	}

	//�p��j��ʤ������Q�H��
	$cou=array(0,0,0,0,0,0,0);
	while(list($k,$v)=each($fd)) {
		if($v[prec_t]>=50) $cou[0]++;
		if($v[prec_w]>=50) $cou[1]++;
		if($v[prec_b]>=50) $cou[2]++;
		if($v[prec1]>=50) $cou[3]++;
		if($v[prec2]>=50) $cou[4]++;
		if($v[prec3]>=50) $cou[5]++;
		if($v[prec4]>=50) $cou[6]++;
	}


  //�PŪBMI���G   by smallduh.
 	foreach ($r as $k=>$v) {
 	 $sn=$v[student_sn];
	 $sex=$v[stud_sex]; //1�k�� , 2�k��
	 $age=$fd[$sn][age];
	 $tall=$fd[$sn][tall];
	 $weigh=$fd[$sn][weigh];
	 $bmt=round($weigh/($tall/100)/($tall/100),0);
   
   $bid=get_bid($sex,$age,$bmt); //�o�� 0�L��,1�A��,2�L��,3�έD
   
   $fd[$sn][bid]=$Bid_arr[$bid];
   $fd[$sn][sex_title]=($sex==1)?"�k":"�k";
   
	//Ū���Ӧ~�����e 25% ����
	
   //�����e�s 1
   $query="select p25 from fitness_mod where age='$age' and sex='$sex' and grade='2'"; 
   $row_t=mysql_fetch_array(mysql_query($query),1);
   $fd[$sn][test1_lower]=$row_t['p25'];
   //���װ_�� 2
   $query="select p25 from fitness_mod where age='$age' and sex='$sex' and grade='3'"; 
   $row_t=mysql_fetch_array(mysql_query($query),1);
   $fd[$sn][test2_lower]=$row_t['p25'];
  //�ߩw���� 3 
   $query="select p25 from fitness_mod where age='$age' and sex='$sex' and grade='4'"; 
   $row_t=mysql_fetch_array(mysql_query($query),1);
   $fd[$sn][test3_lower]=$row_t['p25'];
   //�ߪ;A�� 4
   $query="select p25 from fitness_mod where age='$age' and sex='$sex' and grade='5'"; 
   $row_t=mysql_fetch_array(mysql_query($query),1);
   $fd[$sn][test4_lower]=$row_t['p25'];
   
   $lower=0; //�˴�4��, ���X�����F25%
   
   if ($fd[$sn][prec1]<25) $lower++;
   if ($fd[$sn][prec2]<25) $lower++;
   if ($fd[$sn][prec3]<25) $lower++;
   if ($fd[$sn][prec4]<25) $lower++;
   
   $fd[$sn][lower]=$lower;
   
	}

	$smarty->assign("avg",$avg);
	$smarty->assign("avg_title",array("0"=>"�k��","1"=>"�k��","2"=>"���Z"));
	$smarty->assign("fd",$fd);
	$smarty->assign("cou",$cou);
	$smarty->assign("class_num",$class_num);
} else {
	head("�v�����~");
	stud_class_err();
	exit;
}

if($admin) $all_students='<input type="checkbox" name="all_students" value=1>�ץX���ո��';

$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("module_name","��A���������ΦC�L");
$smarty->assign("SFS_MENU",$menu_p);
$smarty->assign("sel_year",$sel_year);
$smarty->assign("sel_seme",$sel_seme);
$smarty->assign("IS_JHORES",$IS_JHORES);
$smarty->assign("all_students",$all_students);

if ($_POST[print_html]) {
	$smarty->assign("sch",get_school_base());
	$smarty->assign("class_arr",class_base($seme_year_seme));
	$smarty->display("fitness_print_html.tpl");
} elseif ($_POST[export]) {
	$smarty->assign("sch",get_school_base());
	header("Content-disposition: attachment; filename=$file_name");
	header("Content-type: text/x-csv; Charset=Big5");
	//header("Pragma: no-cache");
					//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");

	header("Expires: 0");
	$smarty->assign("class_arr",class_base($seme_year_seme));
	$smarty->display("fitness_print_csv.tpl");
} elseif ($_POST[export2]) {
	$smarty->assign("sch",get_school_base());
	header("Content-disposition: attachment; filename=$file_name");
	header("Content-type: text/x-csv; Charset=Big5");
	//header("Pragma: no-cache");
					//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");

	header("Expires: 0");
	$smarty->assign("class_arr",class_base($seme_year_seme));
	$smarty->display("fitness_print_csv2.tpl");
} else {
	
	$smarty->display("fitness_print.tpl");
}


function get_bid($sex,$age,$bmt) {
//BMI�з� 
$BOY_BID=array(6=>array(13.9,17.9,19.7),7=>array(14.7,18.6,21.2),8=>array(15.0,19.3,22.0),9=>array(15.2,19.7,22.5),10=>array(15.4,20.3,22.9),11=>array(15.8,21.0,23.5),12=>array(16.4,21.5,24.2),13=>array(17.0,22.2,24.8),14=>array(17.6,22.7,25.2),15=>array(18.2,23.1,25.5),16=>array(18.6,23.4,25.6),17=>array(19.0,23.6,25.6),18=>array(19.2,23.7,25.6));
$GIRL_BID=array(6=>array(13.6,17.2,19.1),7=>array(14.4,18.0,20.3),8=>array(14.6,18.8,21.0),9=>array(14.9,19.3,21.6),10=>array(15.2,20.1,22.3),11=>array(15.8,20.9,23.1),12=>array(16.4,21.6,23.9),13=>array(17.0,22.2,24.6),14=>array(17.6,22.7,25.1),15=>array(18.0,22.7,25.3),16=>array(18.2,22.7,25.3),17=>array(18.3,22.7,25.3),18=>array(18.3,22.7,25.3));
//���R
 $bmi=3;
 switch ($sex) {
  case 1:
   foreach ($BOY_BID[$age] as $k=>$v) {
    if ($bmt<$v) {
     $bmi=$k;
     break;
    }
   }  
  break;
  case 2:
  foreach ($GIRL_BID[$age] as $k=>$v) {
    if ($bmt<$v) {
     $bmi=$k;
     break;
    }
  }
  break;
 }
 
 return $bmi;  //�Ǧ^ 0,1,2,3
 
} // end function

//�ӥ͸�ƬO�_�Ҥw�إ�
function chk_fitness_data ($student_sn,$seme_year_seme) {
  global $CONN;
  
  $sql="select * from fitness_data where c_curr_seme='$seme_year_seme' and student_sn='$student_sn'";
  $res=$CONN->Execute($sql);
  $f=$res->fetchrow();
  
  if ($f['test1']!="" and $f['test2']!="" and $f['test3']!="" and $f['test4']!="") {
    return true;
  } else {
    return false;
  }
} //end function

?>
