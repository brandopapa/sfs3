<?php
// $Id: select_query2.php 5310 2009-01-10 07:57:56Z hami $

// �ޤJ�z�ۤv�� config.php ��
require "config.php";

// �s�� SFS3 �����Y
head("���Z��X�d��");

// �{��
sfs_check();
//
// �z���{���X�Ѧ��}�l
//�����ܼ��ഫ��*****************************************************
$var_name=($_GET['var_name'])?$_GET['var_name']:$_POST['var_name'];
$ck=($_GET['ck'])?$_GET['ck']:$_POST['ck'];
$Hseme_year_seme=($_GET['Hseme_year_seme'])?$_GET['Hseme_year_seme']:$_POST['Hseme_year_seme'];
$Hstud_seme_class=($_GET['Hstud_seme_class'])?$_GET['Hstud_seme_class']:$_POST['Hstud_seme_class'];
$Hstage=($_GET['Hstage'])?$_GET['Hstage']:$_POST['Hstage'];
$savesend=($_GET['savesend'])?$_GET['savesend']:$_POST['savesend'];
$with_weight=($_GET['with_weight'])?$_GET['with_weight']:$_POST['with_weight'];
$with_normal=($_GET['with_normal'])?$_GET['with_normal']:$_POST['with_normal'];
//********************************************************************

//��V������
//echo print_menu($MENU_P);

//���o�Ҧ��Ǧ~�Ǵ�
$seme_year_seme_A=stud_seme_year_seme();
$class_array=array();
//�Ǵ��P�Z�Ū����h���	
$ck=($ck==1)?"1":"0";
for($i=0;$i<count($seme_year_seme_A);$i++){	
	$mod=$ck%2;	 
	//�Ǵ�������
	$C_seme_year_seme_A[$i]=intval(substr($seme_year_seme_A[$i],0,-1))."�Ǧ~�ײ�".substr($seme_year_seme_A[$i],-1)."�Ǵ�";
	$menu.="<a href='{$_SERVER['PHP_SELF']}?Hseme_year_seme=$seme_year_seme_A[$i]&ck=$ck'>".$C_seme_year_seme_A[$i]."</a><br>";		
	if($Hseme_year_seme==$seme_year_seme_A[$i] && $mod==0){				
		$stud_seme_class_A=stud_seme_class($Hseme_year_seme);			
		for($j=0;$j<count($stud_seme_class_A[seme_class]);$j++){			
			if($Hstud_seme_class==$stud_seme_class_A[seme_class][$j]) {$CSS[$j]="style='background-color: rgb(255, 255, 0);"; $point=$j;}			
			//�Z�Ū�����
			$C_stud_seme_class_A[seme_class][$j]=$school_kind_name[substr($stud_seme_class_A[seme_class][$j],0,-2)].$stud_seme_class_A[seme_class_name][$j]."�Z";
			$menu.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span $CSS[$j]><a href='{$_SERVER['PHP_SELF']}?point=$point&ck=0&Hseme_year_seme=$Hseme_year_seme&Hstud_seme_class={$stud_seme_class_A[seme_class][$j]}'>{$C_stud_seme_class_A[seme_class][$j]}</a></span><br>\n";			
			if(!in_array((substr($stud_seme_class_A[seme_class][$j],0,-2)*100),$class_array)) $class_array[]=substr($stud_seme_class_A[seme_class][$j],0,-2)*100;				
		}
		for($k=0;$k<count($class_array);$k++){				
			if($Hstud_seme_class==$class_array[$k]) {$CSS2[$k]="style='background-color: rgb(255, 255, 0);"; $point=$k;}
			$menu.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span $CSS2[$k]><a href='{$_SERVER['PHP_SELF']}?point=$point&ck=0&Hseme_year_seme=$Hseme_year_seme&Hstud_seme_class={$class_array[$k]}'>{$class_year_name[$class_array[$k]]}</a></span><br>\n";	
		}
	}
}
	
//���Z���	
if($Hseme_year_seme && $Hstud_seme_class){
	//��X�ӾǴ��ӯZ�����Z�A�w�s�b��Ʈw���~���
	
	//�o�@�ӾǴ����аȳB���Z��ƪ�O�_�s�b
	$score_semester="score_semester_".intval(substr($Hseme_year_seme,0,-1))."_".substr($Hseme_year_seme,-1);	
	$sql="select * from $score_semester where 1=0";	
	$rs=$CONN->Execute($sql);	
	if(is_object($rs)){
		//$stage_select=$score_semester;
		if(substr($Hstud_seme_class,-2)!="00"){
			$class_id=sprintf("%03d_%d_%02d_%02d",substr($Hseme_year_seme,0,-1),substr($Hseme_year_seme,-1),substr($Hstud_seme_class,0,-2),substr($Hstud_seme_class,-2));
			$sql="select * from $score_semester where sendmit='0' and class_id='$class_id'";
		}
		elseif(substr($Hstud_seme_class,-2)=="00"){
			$class_id=sprintf("%03d_%d_%02d",substr($Hseme_year_seme,0,-1),substr($Hseme_year_seme,-1),substr($Hstud_seme_class,0,-2));
			$sql="select * from $score_semester where sendmit='0' and class_id like '$class_id%'";
		}
		$rs=$CONN->Execute($sql) or trigger_error("$sql",256);		
		$i=0;
		$real_test_sort=array();
		while(!$rs->EOF){
			$test_sort[$i]=$rs->fields['test_sort'];			
			if(!in_array($test_sort[$i],$real_test_sort)) $real_test_sort[]=$test_sort[$i];
			$i++;
			$rs->MoveNext();
		}
		if(count($real_test_sort)==0) $stage_select="�ثe�L���Z";
		else{			
			for($m=0;$m<count($real_test_sort);$m++) {			
				$stage[$m]=$real_test_sort[$m];
				$stage_select.="<a href='{$_SERVER['PHP_SELF']}?ck=0&Hseme_year_seme=$Hseme_year_seme&Hstud_seme_class=$Hstud_seme_class&Hstage=$stage[$m]'>".$stage_cname[$stage[$m]]."</a><br>";
				if($Hstage==$stage[$m]){
					$stage_select.="<form action='{$_SERVER['PHP_SELF']}' method='post' name='form1'>";
					if($with_weight) $checked1="checked";
					if($with_normal) $checked2="checked";
					$stage_select.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='checkbox' name='with_weight' value='1' $checked1>�]�t�[�v<br>\n";
					$stage_select.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='checkbox' name='with_normal' value='1' $checked2>�]�t���ɦ��Z<br>\n";						
					$stage_select.="<input type='hidden' name='Hseme_year_seme' value='$Hseme_year_seme'>";
					$stage_select.="<input type='hidden' name='Hstud_seme_class' value='$Hstud_seme_class'>";
					$stage_select.="<input type='hidden' name='Hstage' value='$Hstage'>";
					$stage_select.="<input type='hidden' name='savesend' value='savesend_ok'>";
					$stage_select.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' name='submit' value='�e�X'></form>";
				}				
			}
		}					
	}			
}

if($savesend=="savesend_ok"){	
	$score_table="�C�X���Z�� $Hseme_year_seme $Hstud_seme_class $Hstage $with_weight $with_normal";	
	$a=&muti_score($Hseme_year_seme,$Hstud_seme_class, $Hstage,$with_weight,$with_normal);
	$student_array=array();
	$subject_array=array();	
	$subject_list.="<td>&nbsp;</td>";
	foreach($a as $key => $val){		
		if(!in_array($key,$student_array)) {
			$student_array[]=$key;			
		}	
		foreach($val as $key2 => $val2){
			if(!in_array($key2,$subject_array)) {
				$subject_array[]=$key2;	
				$key2_c=ss_id_to_subject_name($key2);
				$subject_list.="<td>$key2_c</td>";
			}
		}
	}
	//����
	for($m=0;$m<count($student_array);$m++){
		$student_list[$m].="<tr><td>".student_sn_to_stud_name($student_array[$m])."</td>";
		for($n=0;$n<count($subject_array);$n++){
			$student_list[$m].="<td>".$a[$student_array[$m]][$subject_array[$n]]."</td>";
			$one_total[$m]=$one_total[$m]+$a[$student_array[$m]][$subject_array[$n]];
		}
		$one_average[$m]=round($one_total[$m]/count($subject_array),2);
		//$student_list[$m].="<td>".$one_total[$m]."</td><td>".$one_average[$m]."</td></tr>";
		$student_list[$m].="<td>".$one_total[$m]."</td><td>".$one_average[$m]."</td>";
		
		//$student_list_A.=$student_list[$m];
	}
	//�W��	
	for($p=0;$p<count($one_total);$p++){		
		$one_num[$p]=how_big($one_total[$p],$one_total);
		$student_list_A.=$student_list[$p]."<td>".$one_num[$p]."</td></tr>";
	}
	
	//123
	//456
	
		
	//��X�Y�@�쪺�`���P����
	for($i=0;$i<count($subject_array);$i++){
		for($j=0;$j<count($student_array);$j++){
			$all_total[$i]=$all_total[$i]+$a[$student_array[$j]][$subject_array[$i]];
		}
		$all_total_list.="<td>$all_total[$i]</td>";
		$all_average_list.="<td>".round($all_total[$i]/count($student_array),2)."</td>";
	}
	

	$score_table="<table border=1><tr>$subject_list<td>�`��</td><td>����</td><td>�W��</td></tr>
						$student_list_A
						<tr><td>�`��</td>$all_total_list</tr>
						<tr><td>����</td>$all_average_list</tr>
						</table>";	 	
}	
	//�̫���ܥX�Ӫ����e��
	if(count($student_array)==0 && count($subject_array)==0) $score_table="�ثe�L�����Z";
	echo "<table bgcolor='black' border='0' cellpadding='2' cellspacing='0' width='99%'><tr bgcolor='#FACDEF'><td valign='top' width='20%'>$menu</td><td valign='top' width='20%'>$stage_select</td><td valign='top'>$score_table</td></tr></table>";

// SFS3 ������
foot();



//������⦨�Z
function &muti_score($Hseme_year_seme,$Hstud_seme_class, $Hstage,$with_weight,$with_normal){
	global $CONN;
	
	if($with_normal=="1"){//�]�t���ɦ��Z
		if($with_weight=="1"){//�n�[�v
			if($Hstage=="255"){//���Ǵ�
				//stud_seme_score
				if(substr($Hstud_seme_class,-2)!="00") $class_id=sprintf("%03d_%d_%02d_%02d",substr($Hseme_year_seme,0,-1),substr($Hseme_year_seme,-1),substr($Hstud_seme_class,0,-2),substr($Hstud_seme_class,-2));									
				elseif(substr($Hstud_seme_class,-2)=="00") $class_id=sprintf("%03d_%d_%02d",substr($Hseme_year_seme,0,-1),substr($Hseme_year_seme,-1),substr($Hstud_seme_class,0,-2));
				$student_sn_A=seme_class_id_to_student_sn($class_id);
				for($i=0;$i<count($student_sn_A);$i++){					
					$sql="select ss_id,ss_score from stud_seme_score where seme_year_seme='$Hseme_year_seme' and student_sn='$student_sn_A[$i]'";					
					$rs=$CONN->Execute($sql) or trigger_error("$sql",256);
					$j=0;
					while(!$rs->EOF){
						$ss_id[$j]=$rs->fields['ss_id'];
						$ss_score[$j]=$rs->fields['ss_score'];
						$ss_scoreA[$student_sn_A[$i]][$ss_id[$j]]=$ss_score[$j];
						//echo $student_sn_A[$i]."---".$ss_id[$j]."---".$ss_score[$student_sn_A[$i]][$ss_id[$j]]."<br>";
						$j++;
						$rs->MoveNext();
					}
				}
				return $ss_scoreA;
			}
			else{//�Y�@���q
				//score_semester VS �[�v

			}
		}
		else{//���[�v
			if($Hstage=="255"){//���Ǵ�
				//score_semester

			
			}
			else{//�Y�@���q
				//score_semester
				$score_semester="score_semester_".intval(substr($Hseme_year_seme,0,-1))."_".substr($Hseme_year_seme,-1);
				if(substr($Hstud_seme_class,-2)!="00") $class_id=sprintf("%03d_%d_%02d_%02d",substr($Hseme_year_seme,0,-1),substr($Hseme_year_seme,-1),substr($Hstud_seme_class,0,-2),substr($Hstud_seme_class,-2));									
				elseif(substr($Hstud_seme_class,-2)=="00") $class_id=sprintf("%03d_%d_%02d_",substr($Hseme_year_seme,0,-1),substr($Hseme_year_seme,-1),substr($Hstud_seme_class,0,-2));
				$student_sn_A=seme_class_id_to_student_sn($class_id);
				for($i=0;$i<count($student_sn_A);$i++){					
					$sql="select ss_id,score from $score_semester where sendmit='0' and class_id like '$class_id%' and student_sn='$student_sn_A[$i]' and test_sort='$Hstage'";					
					$rs=$CONN->Execute($sql) or trigger_error("$sql",256);
					$j=0;
					while(!$rs->EOF){
						$ss_id[$j]=$rs->fields['ss_id'];
						$score[$j]=$rs->fields['score'];
						if($score[$j]<0) $score[$j]="";						
						$scoreA[$student_sn_A[$i]][$ss_id[$j]]=$score[$j];						
						//echo $student_sn_A[$i]."---".$ss_id[$j]."---".$scoreA[$student_sn_A[$i]][$ss_id[$j]]."<br>";
						$j++;
						$rs->MoveNext();
					}
				}				
				return $scoreA;							
			
			}			
		}
	}
	else{//���]�t���ɦ��Z
		if($with_weight=="1"){//�n�[�v
			if($Hstage=="255"){//���Ǵ�
				//score_semester VS �[�v	
			
			}
			else{//�Y�@���q
				//score_semester VS �[�v	
			
			
			}			
		}
		else{//���[�v
			if($Hstage=="255"){//���Ǵ�
				//score_semester	
			
			}
			else{//�Y�@���q
				//score_semester	
			
			
			}
		}
	}

}



?>

