<?php
                                                                                                                             
// $Id: check_error2.php 5310 2009-01-10 07:57:56Z hami $


//���J�]�w��
include "stud_check_config.php";

//�{���ˬd
sfs_check();

//�����ܼ��ഫ
$act=($_POST['act'])?"{$_POST['act']}":"{$_GET['act']}";
$stud_id=($_POST['stud_id'])?"{$_POST['stud_id']}":"{$_GET['stud_id']}";
//$c_curr_class=($_POST['c_curr_class'])?"{$_POST['c_curr_class']}":"{$_GET['c_curr_class']}";
$curr_year = curr_year();
$curr_seme = curr_seme();
$upd_file=$UPLOAD_PATH."upgrade/include/2003-06-24.txt";

if($act=="edit"){
	$c_curr_class=($_POST['c_curr_class'])?"{$_POST['c_curr_class']}":"{$_GET['c_curr_class']}";
	header("Location: $SFS_PATH_HTML"."modules/stud_reg/stud_list.php?stud_id=$stud_id&c_curr_class=$c_curr_class");
	exit;
}
elseif($act=="upd_tb"){		
	upd_fail($upd_file,$act);
	
}
//�t�Φ۰ʭ��@
elseif($act=="auto_upd"){
	$main_del.="<table width='100%' bgcolor='#CDCDCD'><tr><td>";
	$seme_year_seme=sprintf("%03d%d",$curr_year,$curr_seme);
	$del_student_sn=($_POST['student_sn'])?"{$_POST['student_sn']}":"{$_GET['student_sn']}";
	//��stud_base��X�Ǹ���$stud_id���y����
	$sql="select student_sn from stud_base where stud_id='$stud_id' ";
	$rs=$CONN->Execute($sql) or trigger_error($sql,256);
	$new_student_sn=$rs->fields['student_sn'];
	//$new_curr_class_num=$rs->fields['curr_class_num'];
	//��藍�P�h�Hstud_base���D
	if($del_student_sn!=$new_student_sn) {
		$sql2="update stud_seme set student_sn='$new_student_sn' where seme_year_seme='$seme_year_seme' and stud_id='$stud_id' ";
		$CONN->Execute($sql2) or trigger_error($sql,256);
		$main_del.="�վ�y�Ǹ��G $stud_id �z���y�������y $new_student_sn �z";
		$del_msg.="---�������G".date("l dS of F Y h:i:s A")."---����H�G".$_SESSION['session_tea_name'] ."(".$_SESSION['session_log_id'] .")\n";
		$del_msg.="�վ�y�Ǹ��G $stud_id �z���y�������y $new_student_sn �z";
	}else{
		$main_del.="�ӥ͡y�Ǹ��G $stud_id �z���ݶi��վ�A�нվ�t�~�@��I";
	}
	$main_del.="</td></tr></table><br>";
	$del_msg.="\n\n";
	//���K�g�J������YouKill.log
	$dir_name= $UPLOAD_PATH."/log";	
	if(!is_dir ($dir_name)) mkdir ("$dir_name", 0777);	
	$file_name= $dir_name."/YouKill.log";	
	$FD=fopen ($file_name, "a");
	fwrite ($FD, $del_msg);	
	fclose ($FD);

}
elseif($act=="del_seme"){
	$del_student_sn=($_POST['student_sn'])?"{$_POST['student_sn']}":"{$_GET['student_sn']}";
	//�R���e�ˬd�ӥͪ����Z��ƬO�_���s�b�A���h����R��
	if($del_student_sn!=""){
		$sql_score="select count(*) from stud_seme_score where student_sn='$del_student_sn' ";
		$rs_score=$CONN->Execute($sql_score) or trigger_error($sql,256);
		$count_score=$rs_score->fields[0];
	}	
	if($count_score==0){  		
		$main_del.="<table width='100%' bgcolor='#CDCDCD'><tr><td>";
		$del_msg.="---�������G".date("l dS of F Y h:i:s A")."---����H�G".$_SESSION['session_tea_name'] ."(".$_SESSION['session_log_id'] .")\n";
		//�N�ӥ�stud_seme���R����
		$seme_year_seme=sprintf("%03d%d",$curr_year,$curr_seme);
		if($stud_id!="") $sql_del2="delete from stud_seme where student_sn='$del_student_sn' and seme_year_seme='$seme_year_seme' ";
		elseif($del_student_sn) $sql_del2="delete from stud_seme where stud_id='$stud_id' and seme_year_seme='$seme_year_seme' ";		
		$rs_del2=$CONN->Execute($sql_del2) or trigger_error($sql_del2,256);
		if($rs_del2) {
			$main_del.="�R�� �y�y�����G$del_student_sn �z�A�y�Ǹ��G$stud_id �z ���Ǵ���ƪ�<br>";
			$del_msg.="�R�� �y�y�����G$del_student_sn �z�A�y�Ǹ��G$stud_id �z ���Ǵ���ƪ�\n";
		}
		$main_del.="</td></tr></table><br>";
		$del_msg.="\n\n";
		//���K�g�J������YouKill.log
		$dir_name= $UPLOAD_PATH."/log";	
		if(!is_dir ($dir_name)) mkdir ("$dir_name", 0777);	
		$file_name= $dir_name."/YouKill.log";	
		$FD=fopen ($file_name, "a");
		fwrite ($FD, $del_msg);	
		fclose ($FD);
		
		//���Ѹӥͥi�H�٭쪺sql�ɮ�
		
	}
	else {
		$main_del="<table width='100%' bgcolor='#CDCDCD'><tr><td>�ӥͦ��Z��Ƥw�g�s�b�A�����\�R���C";
		$main_del.="<font color='red'>�L�צp�󳣭n</font><a href='{$_SERVER['PHP_SELF']}?act=sure_del_seme&student_sn=$del_student_sn&stud_id=$stud_id'><font class='button'>�R��</font></a></td></tr></table><br>";
	}
}
elseif($act=="del"){
	$del_student_sn=($_POST['student_sn'])?"{$_POST['student_sn']}":"{$_GET['student_sn']}";
	//�R���e�ˬd�ӥͪ����Z��ƬO�_���s�b�A���h����R��
	$sql_score="select count(*) from stud_seme_score where student_sn='$del_student_sn' ";
	$rs_score=$CONN->Execute($sql_score) or trigger_error($sql,256);
	$count_score=$rs_score->fields[0];
	if($count_score==0){  		
		$main_del.="<table width='100%' bgcolor='#CDCDCD'><tr><td>";
		//�N�ӥ�stud_base���R����
		/*****�ǳƱN�ӳƥ��Ϊ��A�٨S�n
		$sql_bk = "select * from stud_base where student_sn='$del_student_sn' ";
		$rs_bk = $CONN->Execute($sql_bk);
		if ($rs_bk) {
			while( $ar_bk = $rs_bk->FetchRow() ) {
				$ar_bk[$i];
			}
		}
		*/
		$del_msg.="---�������G".date("l dS of F Y h:i:s A")."---����H�G".$_SESSION['session_tea_name'] ."(".$_SESSION['session_log_id'] .")\n";
		$sql_del="delete from stud_base where student_sn='$del_student_sn' ";
		$rs_del=$CONN->Execute($sql_del) or trigger_error($sql_del,256);
		if($rs_del) {
			$main_del.="�R�� �y�y�����G$del_student_sn �z�A�y�Ǹ��G$stud_id �z ���ǥ͸�ƪ�<br>";
			$del_msg.="�R�� �y�y�����G$del_student_sn �z�A�y�Ǹ��G$stud_id �z ���ǥ͸�ƪ�\n";
		}

		//�N�ӥ�stud_seme���R����
		//$seme_year_seme=sprintf("%03d%d",$curr_year,$curr_seme);
		$sql_del2="delete from stud_seme where student_sn='$del_student_sn' ";
		$rs_del2=$CONN->Execute($sql_del2) or trigger_error($sql_del2,256);
		if($rs_del2) {
			$main_del.="�R�� �y�y�����G$del_student_sn �z�A�y�Ǹ��G$stud_id �z ���Ǵ���ƪ�<br>";
			$del_msg.="�R�� �y�y�����G$del_student_sn �z�A�y�Ǹ��G$stud_id �z ���Ǵ���ƪ�\n";
		}

		//�N�ӥ�stud_domicile���R����
		$sql_del3="delete from stud_domicile where stud_id='$stud_id' ";
		$rs_del3=$CONN->Execute($sql_del3) or trigger_error($sql_del3,256);
		if($rs_del3) {
			$main_del.="�R�� �y�y�����G$del_student_sn �z�A�y�Ǹ��G$stud_id �z �����y��ƪ�<br>";
			$del_msg.="�R�� �y�y�����G$del_student_sn �z�A�y�Ǹ��G$stud_id �z �����y��ƪ�\n";
		}

		$main_del.="</td></tr></table><br>";
		$del_msg.="\n\n";


		//���K�g�J������YouKill.log
		$dir_name= $UPLOAD_PATH."/log";	
		if(!is_dir ($dir_name)) mkdir ("$dir_name", 0777);	
		$file_name= $dir_name."/YouKill.log";	
		$FD=fopen ($file_name, "a");
		fwrite ($FD, $del_msg);	
		fclose ($FD);
		
		//���Ѹӥͥi�H�٭쪺sql�ɮ�
		
	}
	else {
		$main_del="<table width='100%' bgcolor='#CDCDCD'><tr><td>�ӥͦ��Z��Ƥw�g�s�b�A�����\�R���C";
		$main_del.="<font color='red'>�L�צp�󳣭n</font><a href='{$_SERVER['PHP_SELF']}?act=sure_del&student_sn=$del_student_sn&stud_id=$stud_id'><font class='button'>�R��</font></a></td></tr></table><br>";
	}
}


//���L�j���G
elseif($act=="sure_del" or $act=="sure_del_seme"){
	$del_student_sn=($_POST['student_sn'])?"{$_POST['student_sn']}":"{$_GET['student_sn']}";
	$sql_sfs3="SHOW TABLES FROM sfs3";
	$rs_sfs3=$CONN->Execute($sql_sfs3) or trigger_error($sql_sfs3,256);
	if ($rs_sfs3) {
		$i=0;
		$main_del.="<table width='100%' bgcolor='#CDCDCD'><tr><td>";
		$del_msg.="---�������G".date("l dS of F Y h:i:s A")."---����H�G".$_SESSION['session_tea_name'] ."(".$_SESSION['session_log_id'] .")\n";
		while( $ar_sfs3 = $rs_sfs3->FetchRow() ) {			
			//�P�_�Ӹ�ƪ�O�_��stud_id�Astudent_sn�Astud_sn�����A�����ܴN�R���o�@�����
			$sql_fields="show fields from {$ar_sfs3[0]}";
			$rs_fields=$CONN->Execute($sql_fields) or trigger_error($sql_fields,256);
			if($rs_fields){								
				while( $ar_fields = $rs_fields->FetchRow() ) {
					//echo $ar_fields[0];
					if($ar_fields[0]=="stud_id") {
						$a=$CONN->Execute("delete from $ar_sfs3[0] where stud_id='$stud_id'") or trigger_error("�R�� $ar_sfs3[0] ���ѡI",256);
						if($a){
							$main_del.="�R�� $ar_sfs3[0] ��ƪ��Ǹ��� $stud_id ����ƿ��I<br>";
							$del_msg.="�R�� $ar_sfs3[0] ��ƪ��Ǹ��� $stud_id ����ƿ��I\n";
						}		  
						break;
					}	
					elseif($ar_fields[0]=="student_id") {
						$a=$CONN->Execute("delete from $ar_sfs3[0] where student_id='$stud_id'") or trigger_error("�R�� $ar_sfs3[0] ���ѡI",256);
						if($a) {
							$main_del.="�R�� $ar_sfs3[0] ��ƪ��Ǹ��� $stud_id ����ƿ��I<br>";
							$del_msg.="�R�� $ar_sfs3[0] ��ƪ��Ǹ��� $stud_id ����ƿ��I\n";
						}
						break;
					}	
					elseif($ar_fields[0]=="stud_sn") {
						$a=$CONN->Execute("delete from $ar_sfs3[0] where stud_sn='$del_student_sn'") or trigger_error("�R�� $ar_sfs3[0] ���ѡI",256);
						if($a) {
							$main_del.="�R�� $ar_sfs3[0] ��ƪ��ǥͬy������ $del_student_sn ����ƿ��I<br>";
							$del_msg.="�R�� $ar_sfs3[0] ��ƪ��ǥͬy������ $del_student_sn ����ƿ��I\n";	
						}	
						break;
					}
					elseif($ar_fields[0]=="student_sn") {
						$a=$CONN->Execute("delete from $ar_sfs3[0] where student_sn='$del_student_sn'") or trigger_error("�R�� $ar_sfs3[0] ���ѡI",256);
						if($a) {
							$main_del.="�R�� $ar_sfs3[0] ��ƪ��ǥͬy������ $del_student_sn ����ƿ��I<br>";
							$del_msg.="�R�� $ar_sfs3[0] ��ƪ��ǥͬy������ $del_student_sn ����ƿ��I\n";
						}	
						break;
					}
				}
			}
		}
		$main_del.="</td></tr></table><br>";
		$del_msg.="\n\n";
	}
	//���K�g�J������YouKill.log
	$dir_name= $UPLOAD_PATH."/log";	
	if(!is_dir ($dir_name)) mkdir ("$dir_name", 0777);	
	$file_name= $dir_name."/YouKill.log";	
	$FD=fopen ($file_name, "a");
	fwrite ($FD, $del_msg);	
	fclose ($FD);
	
	//���Ѹӥͥi�H�٭쪺sql�ɮ�
}



//�T����ܰ�
head("���y����ˬd");
print_menu($menu_p);

//�ɯ��ˬd---stud_seme��student_sn�O�_�ɯŦ��\
if(is_file($upd_file)){//�b�w�g�����ɯŪ����p�U�ˬdstud_seme��student_sn���O�_�[�J���\
	$sql_ckupd="SELECT student_sn FROM stud_seme";
	$CONN->Execute($sql_ckupd) or upd_fail($upd_file);
}
else{
	echo "�|���ɯšA�O�_�ɯžǥ;Ǵ��O���� stud_seme , �[�J student_sn ���<br>
	<a href='{$_SERVER['PHP_SELF']}?act=upd_tb'><font class='button'>����ɯ�</font></a>";	
	exit;
}


//����ˬd��
//-------------------------------------------------------------------------------
	$sql="select * from stud_base where stud_study_cond='0' order by curr_class_num";
	$rs=$CONN->Execute($sql) or trigger_error($sql,256);
	$i=0;
	$err_1=0;
	$error_1=array();
	$stud_id=array();
	$student_sn=array();
	while(!$rs->EOF){
		$student_sn=$rs->fields['student_sn'];
		$stud_id[$student_sn]=$rs->fields['stud_id'];		
		//echo $student_sn[$i]."<br>";
		$stud_name[$student_sn]=$rs->fields['stud_name'];
		$stud_sex[$student_sn]=$rs->fields['stud_sex'];
		$stud_birthday[$student_sn]=$rs->fields['stud_birthday'];
		$st=$rs->fields['stud_person_id'];
		$stud_person_id[$student_sn]=$st;
		if (!isIDnum($st)){
			$error_1[$err_1]=$student_sn;
			$err_1++;
		}
		$stud_study_year[$student_sn]=$rs->fields['stud_study_year'];
		$curr_class_num[$student_sn]=$rs->fields['curr_class_num'];
		$stud_study_cond[$student_sn]=$rs->fields['stud_study_cond'];						
		$c_curr_class[$student_sn] = sprintf("%03d_%d_%02d_%02d",$curr_year,$curr_seme,substr($curr_class_num[$student_sn],0,-4),substr($curr_class_num[$student_sn],-4,2));
		$rs->MoveNext();
		$i++;
	}
	
	$class_name_array=class_base();
	
	//�C�X�����Ҭ��ũΤ����T���H��
	$main0.= "<font class='title1'>�H�U�������Ҥ����T�άO���񪺦b�y�ǥ�</font><br>";
	$main0.= "<ul>";
	$j=0;
	while(list($k,$v)=each($error_1)) {
		$class_name_str[$k]=substr($curr_class_num[$v],0,-2);
		$class_name[$k]=$class_name_array[$class_name_str[$k]];
		if($class_name[$k]=="") $class_name[$k]="<font color='#D61414'>�L�Z��</font>";
		if (empty($stud_person_id[$v])){
			$main0.="<li>�����ҥ��� �G ".$class_name[$k]." / �Ǹ��G".$stud_id[$v]." / �m�W�G".$stud_name[$v]." <a href='{$_SERVER['PHP_SELF']}?act=edit&stud_id={$stud_id[$v]}&c_curr_class={$c_curr_class[$v]}'><font class='button'>�ק�</font></a> <a href='{$_SERVER['PHP_SELF']}?act=del&student_sn=$v&stud_id={$stud_id[$v]}'><font class='button'>�R��</font></a></li>";
			$j++;
		} else {
			$main0.="<li>������ <font color='#E66661'>$stud_person_id[$v] </font>���~ �G ".$class_name[$k]." / �Ǹ��G".$stud_id[$v]." / �m�W�G".$stud_name[$v]." <a href='{$_SERVER['PHP_SELF']}?act=edit&stud_id={$stud_id[$v]}&c_curr_class={$c_curr_class[$v]}'><font class='button'>�ק�</font></a> <a href='{$_SERVER['PHP_SELF']}?act=del&student_sn=$v&stud_id={$stud_id[$v]}'><font class='button'>�R��</font></a></li>";
			$j++;
		}
	}
	$main0.= "</ul>";
	if($j=="0") $main0.="�L�����ҿ��~���b�y�ǥ͡I";
		
	//�ˬd�O�_���P�@�����ҦӦ���ӥH�W�Ǹ����b�y�ǥ�	
	$main1.= "<hr><font class='title1'>�H�U���P�@�����ҦӦ���ӥH�W�Ǹ����b�y�ǥ�</font><br>";	
	$sql="select student_sn,stud_person_id from stud_base where stud_study_cond='0' order by stud_person_id,curr_class_num";
	$rs=$CONN->Execute($sql) or trigger_error($sql,256);
	$j=0;
	$stsn="";
	$k=$rs->recordcount();
	$m=0;
	$err=0;
	if ($k>0) {
		$pid[0]=$rs->fields['stud_person_id'];
		$stsn[0]=$rs->fields['student_sn'];
		$rs->MoveNext();
		for ($i=1;$i<$k;$i++) {
			$pid[$i]=$rs->fields['stud_person_id'];
			$stsn[$i]=$rs->fields['student_sn'];
			if ($pid[$i]==$pid[$i-1] && $pid[$i]!=""){
				if ($j>0) $j++;
				else {
					$j=2;
					$m=$i;
					$main1.="<br><ul>";
					$err=1;
				}
			}
			if ($j>0) {
				$sn=$stsn[$i-1];
				$class_name_str[$sn]=substr($curr_class_num[$sn],0,-2);
				$class_name[$sn]=$class_name_array[$class_name_str[$sn]];
				if($class_name[$sn]=="") $class_name[$sn]="<font color='#D61414'>�L�Z��</font>";
				$main1.= "<li>".$class_name[$sn]." / �Ǹ��G".$stud_id[$sn]." / �m�W�G".$stud_name[$sn]."  <a href='{$_SERVER['PHP_SELF']}?act=edit&stud_id={$stud_id[$sn]}'><font class='button'>�ק�</font></a> <a href='{$_SERVER['PHP_SELF']}?act=del&student_sn=$sn&stud_id={$stud_id[$sn]}'><font class='button'>�R��</font></a></li>";
				$j--;
			}
			if ($j==0 && $m!=0) {
				$main1.= "</ul>�@�P�ɾ֦������Ҹ��G<font class='title2'>".$stud_person_id[$stsn[$i-1]] ."</font>���b�y�ǥͦ��H�W<font class='title2'>".($i-$m+1)."</font>�H�A��ĳ�i��վ�<br><br>";
				$m=0;
			}
			$rs->MoveNext();
		}
	}
	if($err==0) $main1.="<br>�L�P�@�����ҦӦ���ӥH�W�Ǹ����b�y�ǥ͡I";
	
	
	//�bstud_base�s�b�����p�U�Pstud_seme���t��A��̬O�Hstudent_sn�Mstud_id���pô���A�w�糧�Ǵ�
	$main2.="<hr><font class='title1'>�H�U���P�@�Ӿǥͬy�����b���Ǵ��֦���ӥH�W�Ǵ���ƪ�</font><br>";
	$seme_year_seme=sprintf("%03d%d",$curr_year,$curr_seme);
	$sql="select * from stud_seme where seme_year_seme='$seme_year_seme' order by stud_id,seme_class,seme_num";
	$rs=$CONN->Execute($sql) or trigger_error($sql,256);
	$i=0;
	$stsn="";
	$err=0;
	while(!$rs->EOF){
		$stsn[$i]=$rs->fields['student_sn'];
		$stid[$i]=$rs->fields['stud_id'];
		$new_stsn_array=array_slice($stsn,0, -1);
		//$main2.=$stsn[$i]."<br>";
		if(in_array($stsn[$i],$new_stsn_array)){
			$river[$stsn[$i]][]=$stid[$i];
			foreach($new_stsn_array as $k => $v){
				if(($stsn[$k]==$stsn[$i]) && (!in_array($stid[$k],$river[$stsn[$i]]))) $river[$stsn[$i]][]=$stid[$k];
			}
			$err=1;
		}
		$rs->MoveNext();
		$i++;
	}
	
	if($err==1) {
		foreach($river as $k1 => $v1){
			//echo $k1."=>".$v1."<br>";
			$main2.="<ul>�H�U���y�����G�y $k1 �z���ǥ͡A��ĳ���i��t�Φ۰ʭץ��A�Y�t�εL�k�۰ʭץ����\���ܡA��ĳ�ۦ�R���ܶȫO�d�@��<br>";
			foreach($v1 as $k2 => $v2){
				$main2.="<li>�ǡ]�N�^���G".$v2."<a href='{$_SERVER['PHP_SELF']}?act=auto_upd&stud_id=$v2&student_sn=$k1'><font class='button'>�t�Φ۰ʭץ�</font></a> <a href='{$_SERVER['PHP_SELF']}?act=del_seme&stud_id=$v2&student_sn=$k1'><font class='button'>�R��</font></a></li>";
				//echo $k2."=>".$v2."<br>";
			}
			$main2.="</ul>";
		}
	}
	else $main2.="<br>�L���Цb�y�ǥ͡I";
	
	//�C�X�m�W���Ū��H��
	$main3.= "<hr><font class='title1'>�H�U���m�W���񪺦b�y�ǥ�</font><br>";
	$main3.= "<ul>";
	$err=0;
	while (list($k,$v)=each($stud_name)){
		if (empty($v)){
			$class_name_str[$k]=substr($curr_class_num[$k],0,-2);
			$class_name[$k]=$class_name_array[$class_name_str[$k]];
			if($class_name[$k]=="") $class_name[$k]="<font color='#D61414'>�L�Z��</font>";
			$main3.="<li>�m�W�ť� �G ".$class_name[$k]." / �Ǹ��G".$stud_id[$k]." <a href='{$_SERVER['PHP_SELF']}?act=edit&stud_id={$stud_id[$k]}&c_curr_class={$c_curr_class[$k]}'><font class='button'>�ק�</font></a> <a href='{$_SERVER['PHP_SELF']}?act=del&student_sn=$k&stud_id={$stud_id[$k]}'><font class='button'>�R��</font></a></li>";
			$err=1;
		}
	}
	$main3.= "</ul>";
	if($err=="0") $main3.="�L�m�W�ťժ��b�y�ǥ͡I";

	
	//�C�X�ʧO����Τ����T���H��
	$main4.= "<hr><font class='title1'>�H�U���ʧO����Τ����T���b�y�ǥ�</font><br>";
	$err=0;
	$main4.= "<ul>";
	while (list($k,$v)=each($stud_sex)){		
		if(!IsSex($v)){
			$class_name_str[$k]=substr($curr_class_num[$k],0,-2);
			$class_name[$k]=$class_name_array[$class_name_str[$k]];
			if($class_name[$k]=="") $class_name[$k]="<font color='#D61414'>�L�Z��</font>";
			if (empty( $v)){
				$main4.="<li>�ʧO���� �G ".$class_name[$k]." / �Ǹ��G".$stud_id[$k]." / �m�W�G".$stud_name[$k]." <a href='{$_SERVER['PHP_SELF']}?act=edit&stud_id={$stud_id[$k]}&c_curr_class={$c_curr_class[$k]}'><font class='button'>�ק�</font></a> <a href='{$_SERVER['PHP_SELF']}?act=del&student_sn=$k&stud_id={$stud_id[$k]}'><font class='button'>�R��</font></a></li>";
			}
			else{
				$main4.="<li>�ʧO���~ �G ".$class_name[$k]." / �Ǹ��G".$stud_id[$k]." / �m�W�G".$stud_name[$k]." <a href='{$_SERVER['PHP_SELF']}?act=edit&stud_id={$stud_id[$k]}&c_curr_class={$c_curr_class[$k]}'><font class='button'>�ק�</font></a> <a href='{$_SERVER['PHP_SELF']}?act=del&student_sn=$k&stud_id={$stud_id[$k]}'><font class='button'>�R��</font></a></li>";
			}
			$err=1;
		}
	}	
	$main4.= "</ul>";
	if($err=="0") $main4.="�L�ʧO����Τ����T���b�y�ǥ͡I";
	
	//�C�X�X�ͤ������Τ����T���H��
	$main5.= "<hr><font class='title1'>�H�U���X�ͤ������Τ����T���b�y�ǥ�</font><br>";
	$err=0;
	$main5.= "<ul>";
	while (list($k,$v)=each($stud_birthday)){		
		if(!IsBirthday($v)){
			$class_name_str[$k]=substr($curr_class_num[$k],0,-2);
			$class_name[$k]=$class_name_array[$class_name_str[$k]];
			if($class_name[$k]=="") $class_name[$k]="<font color='#D61414'>�L�Z��</font>";
			if (empty($v)){
				$main5.="<li>�X�ͤ������ �G ".$class_name[$k]." / �Ǹ��G".$stud_id[$k]." / �m�W�G".$stud_name[$k]." <a href='{$_SERVER['PHP_SELF']}?act=edit&stud_id={$stud_id[$k]}&c_curr_class={$c_curr_class[$k]}'><font class='button'>�ק�</font></a> <a href='{$_SERVER['PHP_SELF']}?act=del&student_sn=$k&stud_id={$stud_id[$k]}'><font class='button'>�R��</font></a></li>";			
			}
			else{
				$main5.="<li>�X�ͤ�����~ �G ".$class_name[$k]." / �Ǹ��G".$stud_id[$k]." / �m�W�G".$stud_name[$k]." <a href='{$_SERVER['PHP_SELF']}?act=edit&stud_id={$stud_id[$k]}&c_curr_class={$c_curr_class[$k]}'><font class='button'>�ק�</font></a> <a href='{$_SERVER['PHP_SELF']}?act=del&student_sn=$k&stud_id={$stud_id[$k]}'><font class='button'>�R��</font></a></li>";	
			}
			$err=1;
		}
	}	
	$main5.= "</ul>";
	if($err=="0") $main5.="�L�X�ͤ������Τ����T���b�y�ǥ͡I";
	
	//�C�X�Z�šA�y�����~���H��
	$main6.= "<hr><font class='title1'>�H�U���Z�šA�y�����~���b�y�ǥ�</font><br>";
	$err=0;
	$main6.= "<ul>";
	while (list($k,$v)=each($curr_class_num)){
		$msg[$k]=IsClassNum($v,$stud_id[$k]);
		if($msg[$k]){			
			$class_name_str[$k]=substr($curr_class_num[$k],0,-2);
			$class_name[$k]=$class_name_array[$class_name_str[$k]];
			if($class_name[$k]=="") $class_name[$k]="<font color='#D61414'>�L�Z��</font>";		
			if (empty($v)){
				$main6.="<li>".$curr_class_num[$k]."�Z�šA�y������ �G ".$class_name[$k]." / �Ǹ��G".$stud_id[$k]." / �m�W�G".$stud_name[$k]." <a href='{$_SERVER['PHP_SELF']}?act=edit&stud_id={$stud_id[$k]}&c_curr_class={$c_curr_class[$k]}'><font class='button'>�ק�</font></a> <a href='{$_SERVER['PHP_SELF']}?act=del&student_sn=$k&stud_id={$stud_id[$k]}'><font class='button'>�R��</font></a></li>";			
			}
			else{
				$main6.="<li>$msg[$k] �G ".$class_name[$k]." / ".$stud_id[$k]." / �Ǹ��G�m�W�G".$stud_name[$k]." <a href='{$_SERVER['PHP_SELF']}?act=edit&stud_id={$stud_id[$k]}&c_curr_class={$c_curr_class[$k]}'><font class='button'>�ק�</font></a> <a href='{$_SERVER['PHP_SELF']}?act=del&student_sn=$k&stud_id={$stud_id[$k]}'><font class='button'>�R��</font></a></li>";	
			}
			$err=1;
		}
	}	
	$main6.= "</ul>";
	if($err=="0") $main6.="�L�Z�šA�y�����~���b�y�ǥ͡I";	
	
	//�C�X�Z�ſ��~���H��
		
	$main= $main_del.$main0.$main1.$main2.$main3.$main4.$main5.$main6;
	//�]�w�D������ܰϪ��I���C��
	$back_ground="
		<table cellspacing=1 cellpadding=6 border=0 bgcolor='#B0C0F8' width='100%'>
			<tr bgcolor='#FFFFFF'>
				<td>
					$main
				</td>
			</tr>
		</table>";
	echo $back_ground;


foot();


function IsSex($sex){
	if(!$sex) return 0;
	if($sex==1 || $sex==2) return 1;
	else return 0;

}

function IsBirthday($birthday){
	if((!$birthday) || ($birthday=="0000-00-00") ) return 0;
	$BA=explode("-",$birthday);
	if(checkdate ($BA[1], $BA[2], $BA[0])) return 1;
	else return 0;
}


function IsClassNum($curr_class_num,$stud_id){
	global $CONN,$curr_year,$curr_seme;
	if(!$curr_class_num || !$stud_id){
		$msg="�ʯZ�Ÿ��";
		return $msg;
	}		
	//�ˬd$curr_class_num�����T��
	//���X�~�šA�Z�šA�y��
	$c_year=substr($curr_class_num,0,-4);
	$c_sort=substr($curr_class_num,-4,-2);
	$num=substr($curr_class_num,-2);	
	if(!$num || $num==0){
		$msg="�ӥ͵L�y���ήy����0";
		return $msg;
	}		
	$sql="select count(*) from school_class where enable=1 and c_year='$c_year' and c_sort='$c_sort' and year='$curr_year' and semester='$curr_seme' ";	
	$rs=$CONN->Execute($sql) or trigger_error($sql,256);
	$c=$rs->fields[0];
	if($c==0) {
		$msg="�ӥͩҦb���Z�Ť��s�b";
		return $msg;
	}
	
	//���F�bstud_base���T���~�٭n���stud_seme�O�_�@�P
	$seme_year_seme=sprintf("%03d%d",$curr_year,$curr_seme);
	$seme_class=substr($curr_class_num,0,-2);
	$sql2="select stud_id from stud_seme where seme_year_seme='$seme_year_seme' and seme_class='$seme_class' and seme_num='$num' and stud_id='$stud_id'";
	$rs2=$CONN->Execute($sql2) or trigger_error($sql2,256);
	if(!$rs2){
		$msg="�y�ǥͰ򥻸�ơz�P�y�Ǵ���ơz���@�P";
		return $msg;
	}
}

function upd_fail($upd_file,$act=""){
	global $CONN;	
	if($act=="upd_tb"){		
		//�R��������
		if(is_file($upd_file)) unlink ($upd_file);
		//�i��ɯ�
		include "../../include/sfs_upgrade_list.php";		
		header("Location:{$_SERVER['PHP_SELF']}");
	}
	echo "��s�ǥ;Ǵ��O���� stud_seme , �[�J student_sn ��쥢��<br>
	<a href='{$_SERVER['PHP_SELF']}?act=upd_tb'><font class='button'>����ɯ�</font></a>";
	exit;	
}
?>
