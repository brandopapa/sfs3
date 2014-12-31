<?php

// $Id: class_import.php 7401 2013-08-02 11:46:56Z infodaes $

//���J�]�w��
include "stud_year_config.php";

//�{���ˬd
sfs_check();

//�ɮ׸ѪR
$file_name=$_FILES['upload_file']['tmp_name'];

if ($file_name && $_FILES['upload_file']['size']>0 && $_FILES['upload_file']['error']==0) {
	//���X�Z�ŦW�ٹ��
	$curr_year=curr_year();
	$curr_semester=curr_seme();
	$query="select c_year,c_sort,c_name from school_class where year=$curr_year and semester=$curr_semester and enable='1' order by c_sort";
	$res=$CONN->Execute($query) or die("SQL���~<br>$query");
	$class_arr=array();
	while(!$res->EOF) {
		$cyear=$res->fields['c_year'];
		$csort=$res->fields['c_sort'];
		$class_arr[$cyear][$csort]=$res->fields['c_name'];
		$res->MoveNext();
	}
	
	if($class_arr) {
		//���X csv ����
		$fp=fopen($file_name,"r");
		$tt=sfs_fgetcsv($fp, 2000, ",");
		$vs=array();
		chk_data($tt);

		//���X�{���s�Z���
		$seme_year_seme=sprintf("%03d",curr_year()).curr_seme();
		$query="select distinct (mid(seme_class,1,1)) as num from stud_seme where seme_year_seme='$seme_year_seme' group by num order by num";
		$res=$CONN->Execute($query) or die("SQL���~<br>$query");
		$err_arr=array();
		while(!$res->EOF) {
			$err_arr[$res->fields['num']]=$res->fields['num'];
			$res->MoveNext();
		}

		//�}�l�פJ
		$msg="";
		while ($tt=sfs_fgetcsv($fp, 2000, ",")) {
			if ($tt[$vs[1]]<$IS_JHORES) $tt[$vs[1]]+=$IS_JHORES;
			$stud_id=$tt[$vs[0]];
			if ($err_arr[$tt[$vs[1]]]) $msg.=$err_arr[$tt[$vs[1]]]."�~�Ťw�����, �Ǹ� $stud_id �ǥͤ��s�Z��Ƥ����פJ.<br>";
			else {
				$query="select * from stud_base where stud_id='$stud_id' and stud_study_cond='0' order by stud_study_year desc";
				$res=$CONN->Execute($query) or die("SQL���~<br>$query");
				if ($res->RecordCount()==0) $msg.="�t�Τ��䤣��Ǹ� $stud_id �ǥͤ��򥻸��, �s�Z��Ƥ����פJ.<br>";
				else {
					$student_sn=$res->fields['student_sn'];
					$cyear=intval($tt[$vs[1]]);
					$csort=intval(substr($tt[$vs[2]],-2));
					//�ˬd�~�ŻP�Z�Ÿ�ƪ����T��
					if($cyear and $csort)
					{
						if($class_arr[$cyear][$csort])
						{
							$seme_class=$cyear.sprintf("%02d",$csort);
							$seme_num=intval($tt[$vs[3]]);
							$curr_class_num=$seme_class.sprintf("%02d",$seme_num);
							$seme_class_name=$class_arr[$cyear][$csort];
							$query="insert stud_seme(seme_year_seme,student_sn,stud_id,seme_class,seme_num,seme_class_name) values ('$seme_year_seme','$student_sn','$stud_id','$seme_class','$seme_num','$seme_class_name')";
							$res=$CONN->Execute($query) or die("SQL���~<br>$query");
							$msg.="�Ǹ� $stud_id �ǥͤ��s�Z��Ƽg�J $seme_class �Z $seme_num �� OK!<br>";
							$query="update stud_base set curr_class_num='$curr_class_num' where student_sn='$student_sn'";
							$res=$CONN->Execute($query) or die("SQL���~<br>$query");
						} else $msg.="�Ǹ� $stud_id �ǥͤ��s�Z�Z�ŦW�٩|����Ǵ���]�w���Z�ų]�w���w�q!<br>";
					} else $msg.="�Ǹ� $stud_id �ǥͤ��s�Z��� �~�ŻP�Z�ťN�����~!<br>";
				}
			}
		}
	} else echo "���Ǵ��|���i��s�Z�]�w�A�L�k�פJ�I";
	fclose($fp);
}

$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("module_name","�s�Z��ƶפJ");
$smarty->assign("SFS_MENU",$menu_p);
$smarty->assign("msg",$msg);
$smarty->display("class_import.tpl");

function chk_data($kk) {
	global $vs;
	
	reset($kk);
	while (list($k,$v)=each($kk)) {
		$v=trim($v);
		switch ($v) {
			case "�Ǹ�":
				$vs[0]=$k;
				break;
			case "�~��":
				$vs[1]=$k;
				break;
			case "�Z��":
				$vs[2]=$k;
				break;
			case "�y��":
				$vs[3]=$k;
				break;
			default:
				break;
		}
	}
}
?>
