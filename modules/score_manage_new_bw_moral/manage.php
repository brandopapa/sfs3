<?php
// $Id: manage.php 6754 2012-05-02 05:10:55Z infodaes $

/*�ޤJ�]�w��*/
include "config.php";
include "../../include/sfs_case_dataarray.php";

//�ϥΪ̻{��
sfs_check();

$year_seme=$_REQUEST['year_seme'];
$year_name=$_REQUEST['year_name'];
$me=$_REQUEST['me'];
$stage=$_REQUEST['stage'];
$act=$_REQUEST['act'];
$yorn=findyorn();

$section_score_title='�C�L����Z�Ū����q���Zñ�֪�';


if($_POST['print_score']){
	if($_POST[selected_class_id]){
		//���oclass_id��C
		foreach($_POST[selected_class_id] as $key=>$value){
			$class_id_list.="'$value',";
			$class_id_list2.=$_POST[year_name].substr($value,-2).',';
		}
		$class_id_list='('.substr($class_id_list,0,-1).')';
		$class_id_list2='('.substr($class_id_list2,0,-1).')';
		
		// ���X�Z�ŦW�ٰ}�C
		$class_base= class_base($work_year_seme);
		
		//���o���q���Z
		$year_seme_array=explode('_',$_POST[year_seme]);
		//$sql="select * from score_semester_".$_POST[year_seme]." where test_sort=$_POST[stage] and class_id like '".sprintf("%03d_%d_%02d_",$year_seme_array[0],$year_seme_array[1],$_POST[year_name])."%'";
		$sql="select * from score_semester_".$_POST[year_seme]." where test_sort=$_POST[stage] and class_id in $class_id_list";

		$rs=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
		while(!$rs->EOF) {
			$student_sn=$rs->fields[student_sn];
			$ss_id=$rs->fields[ss_id];
			$test_name=$rs->fields[test_name];
			$test_kind=$rs->fields[test_kind];

			$score_array[$student_sn][$ss_id][$test_name]=$rs->fields[score];
			
			$rs->MoveNext();
		}
		
		//���o��ذ}�C
		$sql_filter=$_POST[stage]==255?" and print<>'1'":" and print='1'"; 
		//year  semester  class_year  enable  need_exam  rate  sort  sub_sort 
		$sql="select a.ss_id,a.rate,a.print,a.link_ss,b.subject_name from score_ss a left join score_subject b on a.subject_id=b.subject_id WHERE a.class_year=$_POST[year_name] and a.enable=1 and a.need_exam=1 and a.year=$year_seme_array[0] and a.semester=$year_seme_array[1] $sql_filter order by sort,sub_sort";
		$rs=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
		while(!$rs->EOF) {
			$ss_id=$rs->fields[ss_id];
			$subject_name=$rs->fields['subject_name']?$rs->fields['subject_name']:$rs->fields['link_ss'];
			$subject_array[$ss_id]['print']=$rs->fields['print'];
			$subject_array[$ss_id]['subject_name']=$subject_name;
			$subject_array[$ss_id]['rate']=$rs->fields['rate'];
			
			//�����Y
			$print=$rs->fields['print']?'':'#';
			$subject_title.="<td colspan=2>$print".$subject_name."$print (*".$rs->fields['rate'].")</td>";
			$sign_title.="<td colspan=2></td>";
			$subject_title2.="<td align='center'>�w��</td><td align='center'>����</td>";
			$rs->MoveNext();
		}
		//���o�Z�žǥ͸��
		//seme_year_seme  
		$seme_year_seme=sprintf("%03d%d",$year_seme_array[0],$year_seme_array[1]);
		//$sql="select a.student_sn,a.seme_class,a.seme_num,b.stud_id,b.stud_name,b.stud_study_cond from stud_seme a inner join stud_base b on a.student_sn=b.student_sn where seme_year_seme='$seme_year_seme' and seme_class like '".$_POST[year_name]."%' order by seme_class,seme_num";
		$sql="select a.student_sn,a.seme_class,a.seme_num,b.stud_id,b.stud_name,b.stud_study_cond from stud_seme a inner join stud_base b on a.student_sn=b.student_sn where seme_year_seme='$seme_year_seme' and seme_class in $class_id_list2 order by seme_class,seme_num";
		
		$rs=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
		while(!$rs->EOF) {
			$class_id=$rs->fields[seme_class];
			$student_sn=$rs->fields[student_sn];
			$student_array[$class_id][$student_sn][class_num]=$rs->fields[seme_num];
			$student_array[$class_id][$student_sn][stud_id]=$rs->fields[stud_id];
			$student_array[$class_id][$student_sn][stud_name]=$rs->fields[stud_name];
		
			$rs->MoveNext();
		}
		$student_title.="<td>�Z��</td>";
		
		//�L�X���
		foreach($student_array as $class_id=>$student_data){
			$section=$_POST[stage]==255?'�������q':'��'.$_POST[stage].'���q';
			$page_title='<font size=4>'.$sch_name.$year_seme_array[0].'�Ǧ~�ײ�'.$year_seme_array[1].'�Ǵ�'.$class_base[$class_id].$section.'�ǲߵ��q���Zñ�֪�'.'</font>';
			$column_title="<td rowspan=2>�y��</td><td rowspan=2>�Ǹ�</td><td rowspan=2>�m�W</td>$subject_title</tr>";
			$row_data='';
			foreach($student_data as $stud_key=>$stud_value){
				$row_data.="<tr align='center'><td>$stud_value[class_num]</td><td>$stud_value[stud_id]</td><td>$stud_value[stud_name]</td>";
				foreach($subject_array as $sub_key=>$sub_value){
					//$score_array[$student_sn][$ss_id][$test_name]=$rs->fields[score];
					$row_data.="<td>".$score_array[$stud_key][$sub_key]['�w�����q']."</td><td>".$score_array[$stud_key][$sub_key]['���ɦ��Z']."</td>";
					
					//��նZ �M �`���Z					
					$score=intval($score_array[$stud_key][$sub_key]['�w�����q']/10);					
					$score_group[$sub_key][$class_id]['�w�����q'][$score]=$score_group[$sub_key][$class_id]['�w�����q'][$score]+1;
					$score_group[$sub_key][$class_id]['�w�����q']['total']+=$score_array[$stud_key][$sub_key]['�w�����q'];
					$score_group[$sub_key][$class_id]['�w�����q']['count']=$score_group[$sub_key][$class_id]['�w�����q']['count']+1;
					$score=intval($score_array[$stud_key][$sub_key]['���ɦ��Z']/10);					
					$score_group[$sub_key][$class_id]['���ɦ��Z'][$score]=$score_group[$sub_key][$class_id]['���ɦ��Z'][$score]+1;
					$score_group[$sub_key][$class_id]['���ɦ��Z']['total']+=$score_array[$stud_key][$sub_key]['���ɦ��Z'];
					$score_group[$sub_key][$class_id]['���ɦ��Z']['count']=$score_group[$sub_key][$class_id]['���ɦ��Z']['count']+1;					
				}
				$row_data.="</tr>";
			}
			$sign_in="<td colspan=3 align='center'>���ұЮvñ�W</td>".$sign_title;
			
			$showdata.="<center>$page_title<br><table border='2' cellpadding='3' cellspacing='0' style='font-size:12px; border-collapse: collapse' bordercolor='#111111' width='100%'>
					<tr align='center'>$column_title</tr><tr align='center'>$subject_title2</tr><tr>$row_data<tr height=66>$sign_in</tr></table></center><P STYLE='page-break-before: always;'>";
		}



		//�s�@���ղնZ��(�H�Ǭ���C)
		foreach($score_group as $ss_id=>$score_data){
			$subject_name=$subject_array[$ss_id]['subject_name'];
			$ss_id_data.='<font size=4>'.$sch_name.$year_seme_array[0].'�Ǧ~�ײ�'.$year_seme_array[1]."�Ǵ�".$section.'�w�����q���Z�նZ��'." �� $subject_name</font>";
			$ss_id_data.="<table border='2' cellpadding='3' cellspacing='0' style='font-size:12px; border-collapse: collapse' bordercolor='#111111' width='100%'>
			<tr align='center' bgcolor='#ffcccc'><td>�Z��</td><td>�H��</td><td>����</td><td>100</td><td>90~99</td><td>80~89</td><td>70~79</td><td>60~69</td><td>50~59</td><td>40~49</td><td>30~39</td><td>20~29</td><td>10~19</td><td>0~9</td></tr>";
			$ss_id_data2.='<font size=4>'.$sch_name.$year_seme_array[0].'�Ǧ~�ײ�'.$year_seme_array[1]."�Ǵ�".$section.'���ɵ��q���Z�նZ��'." �� $subject_name</font>";
			$ss_id_data2.="<table border='2' cellpadding='3' cellspacing='0' style='font-size:12px; border-collapse: collapse' bordercolor='#111111' width='100%'>
			<tr align='center' bgcolor='#ccffcc'><td>�Z��</td><td>�H��</td><td>����</td><td>100</td><td>90~99</td><td>80~89</td><td>70~79</td><td>60~69</td><td>50~59</td><td>40~49</td><td>30~39</td><td>20~29</td><td>10~19</td><td>0~9</td></tr>";
			foreach($score_data as $class_id=>$group_data){
		
				$class_name=$class_base[$class_id];
				$class_count=$group_data['�w�����q']['count'];
				$class_average=round($group_data['�w�����q']['total']/$class_count,2);
				$ss_id_data.="<tr align='center'><td>$class_name</td><td>$class_count</td><td>$class_average</td>";
				$class_count=$group_data['���ɦ��Z']['count'];
				$class_average=round($group_data['���ɦ��Z']['total']/$class_count,2);
				$ss_id_data2.="<tr align='center'><td>$class_name</td><td>$class_count</td><td>$class_average</td>";
				for($k=10;$k>=0;$k--){
					$curr_score=$group_data['�w�����q'][$k];
					$ss_id_data.="<td>$curr_score</td>";
					$curr_score=$group_data['���ɦ��Z'][$k];
					$ss_id_data2.="<td>$curr_score</td>";
				}
				$ss_id_data.="</tr>";
				$ss_id_data2.="</tr>";	
			}
			$ss_id_data.="</table><br>";
			$ss_id_data2.="</table><br>";			
		}
		
		$go="<HTML><HEAD><TITLE>$section_score_title</TITLE></HEAD>
		<BODY onLoad='printPage()'>

		<SCRIPT LANGUAGE='JavaScript'>
		function printPage() {
		window.print();
		}
		</SCRIPT>
		$showdata
		</BODY>
		</HTML>";
		echo $go;
		echo "<P STYLE='page-break-before: always;' align='center'><font size=4>".$ss_id_data."<P STYLE='page-break-before: always;' align='center'><font size=4>".$ss_id_data2;
		exit;		
	}
}



//�q�X����
head("���Zú��޲z");

echo <<<HERE
<script>
function tagall(status) {
  var i =0;

  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].name=='selected_class_id[]') {
      document.myform.elements[i].checked=status;
    }
    i++;
  }
}
</script>
HERE;

//�C�X��V���s�����Ҳ�
print_menu($menu_p);

if (empty($year_seme)) {
	$sel_year = curr_year(); //�ثe�Ǧ~
	$sel_seme = curr_seme(); //�ثe�Ǵ�
	$year_seme=$sel_year."_".$sel_seme;
} else {
	$ys=explode("_",$year_seme);
	$sel_year=$ys[0];
	$sel_seme=$ys[1];
}
$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
$score_semester="score_semester_".$sel_year."_".$sel_seme;
$teacher_id=$_SESSION['session_log_id'];//���o�n�J�Ѯv��id
$year_seme_menu=year_seme_menu($sel_year,$sel_seme,"this.form.target=''");
$class_year_menu =class_year_menu($sel_year,$sel_seme,$year_name,"this.form.target=''");

if($year_name){
	$choice_kind="�w�����q";
	$stage_menu =stage_menu($sel_year,$sel_seme,$year_name,$me,$stage,"1","this.form.target=''");
}

echo "<form name=\"myform\" method=\"post\" action=\"$_SERVER[SCRIPT_NAME]\">$year_seme_menu $class_year_menu $stage_menu";

if ($act=="cal" && $me){
	$class_id=sprintf("%03d_%d_%02d_%02d",$sel_year,$sel_seme,$year_name,$me);
	seme_score_input($sel_year,$sel_seme,$class_id);
}

$test_kind=array("0"=>"���Ǵ�","1"=>"�w�����q","2"=>"���ɦ��Z");
if ($year_name && $stage) {
	if ($stage=='255')
		$print="and print!='1'";
	else
		$print="and print='1'";
	$sql="select * from score_ss where class_id='".sprintf("%03s_%s_%02s_%02s",$sel_year,$sel_seme,$year_name,$me)."' and enable='1'";
	$rs=$CONN->Execute($sql);
	if ($rs->RecordCount() ==0){
		$sql="select ss_id,scope_id,subject_id from score_ss where class_year='$year_name' and year='$sel_year' and semester='$sel_seme' and enable='1' and need_exam='1' and class_id=''  $print order by sort,sub_sort";
		$rs=$CONN->Execute($sql);
	}
	if(is_object($rs)) {
		//���o�Юv���
		$teacher_array=teacher_array();
        	while (!$rs->EOF) {
			$ss_id=$rs->fields["ss_id"];
			$subject_id[$ss_id]=$rs->fields["subject_id"];
			if (! $subject_id[$ss_id]) $subject_id[$ss_id]=$rs->fields["scope_id"];
			$rs->MoveNext();
		}
		$rowspans=($stage<250&&$yorn=="y")?"rowspan='2' ":"";
		$subject_table="<td width='32' $rowspans align='center'>����Ǵ����Z";
		if ($stage<250 && $yorn=="y") {	$subject_table.="<td width='64' colspan='2' align='center'>�˵�";
			$state_table="<td width='32' align='center'>�w��</td><td width='32' align='center'>����</td>";
		} else {
			$subject_table.="<td width='32' align='center'>�˵�";
			$state_table="";
		}
		while (list($k,$v)=each($subject_id)) {
			$sql="select subject_name from score_subject where subject_id='$v'";
			$rs=$CONN->Execute($sql);
			$subject[$k]=$rs->fields["subject_name"];
			if ($stage<250 && $yorn=="y") {
				$subject_table.="<td width='64' colspan='2' align='center'>".$subject[$k]."</td>";
				$state_table.="<td width='32' align='center'>�w��</td><td width='32' align='center'>����</td>";
			} else {
				$subject_table.="<td width='32' align='center'>".$subject[$k]."</td>";
				$state_table.="";
			}
		}
		$all_sns=array();
		$sql="select c_name,class_id from school_class where year='$sel_year' and c_year='$year_name' and semester='$sel_seme' and enable='1' order by c_sort";
		$rs=$CONN->Execute($sql);
		while (!$rs->EOF) {
			$c_name=$rs->fields["c_name"];
			$class_id=$rs->fields["class_id"];
			$c_class_name="<input type='checkbox' name='selected_class_id[]' value='$class_id'>".$class_year[$year_name].$c_name."�Z";
			$me=intval(substr($class_id,9,2));
			$seme_class=$year_name.sprintf("%02d",$me);
			$sql_sn="select a.student_sn from stud_seme a,stud_base b where a.seme_class='$seme_class' and b.stud_study_cond='0' and a.student_sn=b.student_sn and a.seme_year_seme='$seme_year_seme'";
			$rs_sn=$CONN->Execute($sql_sn);
			$i=0;
			while (!$rs_sn->EOF) {
				$all_sns[$me].=$rs_sn->fields["student_sn"].",";
				$i++;
				$rs_sn->MoveNext();
			}
			$student_number[$me]=$i;
			$all_sns[$me]=substr($all_sns[$me],0,-1);
			$class_state[$me]="<tr bgcolor='#FFFFFF'><td width=80>$c_class_name<td align='center'><a href={$_SERVER['PHP_SELF']}?year_seme=$year_seme&year_name=$year_name&me=$me&stage=$stage&act=cal><img src='images/cal.png' width='16' height='16' hspace='3' border='0'></a>";
			if ($stage<250 && $yorn=="y") {
				$class_state[$me].="<td align='center'><a href=./score_query.php?year_seme=$year_seme&year_name=$year_name&me=$me&stage=$stage&kind=1 target='new'><img src='../../images/filefind.png' width='16' height='16' hspace='3' border='0'></a>";
				$class_state[$me].="<td align='center'><a href=./score_query.php?year_seme=$year_seme&year_name=$year_name&me=$me&stage=$stage&kind=2 target='new'><img src='../../images/filefind.png' width='16' height='16' hspace='3' border='0'></a>";
			} else {
				$class_state[$me].="<td align='center'><a href=./score_query.php?year_seme=$year_seme&year_name=$year_name&me=$me&stage=$stage&kind=0 target='new'><img src='../../images/filefind.png' width='16' height='16' hspace='3' border='0'></a>";
			}
			$rs->MoveNext();
		}
		$fstage=($stage==254)?1:$stage;
		reset($all_sns);
		while(list($me,$sns)=each($all_sns)) {
			if ($sns!="") {
				$sql="select count(score),ss_id,test_kind,sendmit from $score_semester where test_sort='$fstage' and student_sn in ($sns) group by ss_id,test_kind,sendmit order by ss_id,test_kind,sendmit";
				$rs=$CONN->Execute($sql);
				if ($rs->recordcount() > 0) {
					while (!$rs->EOF) {
						$inputs[$me][$rs->fields["ss_id"]][$rs->fields["test_kind"]][$rs->fields["sendmit"]]=$rs->fields[0];
						$rs->MoveNext();
					}
				}
				$sql="select count(score),ss_id,test_kind from $score_semester where test_sort='$fstage' and student_sn in ($sns) and score='-100' group by ss_id,test_kind order by ss_id,test_kind";
				$rs=$CONN->Execute($sql);
				if ($rs->recordcount() > 0) {
					while (!$rs->EOF) {
						$chks[$me][$rs->fields["ss_id"]][$rs->fields["test_kind"]]=$rs->fields[0];
						$rs->MoveNext();
					}
				}
			}
		}
		while (list($cnum,$snum)=each($student_number)) {
			$class_id=sprintf("%03d_%d_%02d_%02d",$sel_year,$sel_seme,$year_name,$cnum);
			
			//����Z�žǲ߬�ب��ഫ���}�C���˯��Юv�m�W
			$class_course_teacher=array();
			$sql="select distinct ss_id,teacher_sn from score_course where class_id='$class_id'";
			$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
			while(!$res->EOF) {
				$ss_id=$res->fields[ss_id];
				$teacher_sn=$res->fields[teacher_sn];
				$class_course_teacher[$class_id][$ss_id][teacher_sn].=$teacher_array[$teacher_sn].',';			
				$res->MoveNext();
			}
			
			reset($subject);
			while(list($ss_id,$subject_name)=each($subject)) {
				$teacher_name=str_replace(',','<br>',substr($class_course_teacher[$class_id][$ss_id][teacher_sn],0,-1));
				$teacher_name="<font size=2 color='brown'>$teacher_name</font>";
				$i=1;
				if ($yorn=="n") {
					if ($stage==254) 
						$v="���ɦ��Z";
					elseif ($stage==255)
						$v="���Ǵ�";
					else
						$v="�w�����q";
					$lock_stat="no";
					$Locks=intval($inputs[$cnum][$ss_id][$v][0]);
					$Opens=intval($inputs[$cnum][$ss_id][$v][1]);
					$Nulls=intval($chks[$cnum][$ss_id][$v]);
					$input_all=$Locks+$Opens;
					$null_all=$snum-$input_all+$Nulls;
					if (($Locks==0 && $Opens==0) || $Nulls==$snum) {
						$sstate="<img src='images/no.png'>";
					} elseif ($null_all>0) {
						if ($Locks>0) {
							$sstate="<img src='images/oh.png' border='0'><br><small>".$null_all."</small>";
							$lock_stat="locked";
						} else {
							$sstate="<img src='images/zero.png' border='0'><br><small>".$null_all."</small>";
						}
					} elseif ($Opens==$snum) {
						$sstate="<img src='images/yes.png' border='0'>";
						$lock_stat="opened";
					} else {
						$sstate="<img src='images/key.png' border='0'>";
						$lock_stat="locked";
					}
					if ($lock_stat=="locked") {
						$sstate="<a href='./openlock.php?score_semester=$score_semester&year_name=$year_name&stage=$stage&class_id=$class_id&ss_id=$ss_id&index=manage&kind=$v'>$sstate</a>";
					}
					if ($lock_stat=="opened") {
						$sstate="<a href='./closelock.php?score_semester=$score_semester&year_name=$year_name&stage=$stage&class_id=$class_id&ss_id=$ss_id&index=manage&kind=$v'>$sstate</a>";
					}
					$bgcolor=($i%2==1)?"#ffffff":"#fcffaf";
					$class_state[$cnum].="<td align='center' bgcolor='$bgcolor'>$sstate</td>";
				} else {
					reset($test_kind);
					while(list($k,$v)=each($test_kind)) {
						$lock_stat="no";
						$Locks=intval($inputs[$cnum][$ss_id][$v][0]);
						$Opens=intval($inputs[$cnum][$ss_id][$v][1]);
						$Nulls=intval($chks[$cnum][$ss_id][$v]);
						$input_all=$Locks+$Opens;
						$null_all=$snum-$input_all+$Nulls;
						if (($stage<250 && $k>0) || ($stage>250 && $k==0)) {
							if (($Locks==0 && $Opens==0) || $Nulls==$snum) {
								$sstate="<img src='images/no.png'>";
							} elseif ($null_all>0) {
								if ($Locks>0) {
									$sstate="<img src='images/oh.png' border='0'><br><small>".$null_all."</small>";
									$lock_stat="locked";
								} else {
									$sstate="<img src='images/zero.png' border='0'><br><small>".$null_all."</small>";
								}
							} elseif ($Opens==$snum) {
								$sstate="<img src='images/yes.png' border='0'>";
								$lock_stat="opened";
							} else {
								$sstate="<img src='images/key.png' border='0'>";
								$lock_stat="locked";
							}
							if ($lock_stat=="locked") {
								$sstate="<a href='./openlock.php?score_semester=$score_semester&year_name=$year_name&stage=$stage&class_id=$class_id&ss_id=$ss_id&index=manage&kind=$v'>$sstate</a>";
							}
							if ($lock_stat=="opened") {
								$sstate="<a href='./closelock.php?score_semester=$score_semester&year_name=$year_name&stage=$stage&class_id=$class_id&ss_id=$ss_id&index=manage&kind=$v'>$sstate</a>";
							}
							$bgcolor=($i%2==1)?"#ffffff":"#fcffaf";
							$class_state[$cnum].="<td align='center' bgcolor='$bgcolor'>$sstate<br>$teacher_name</td>";
						}
						$i++;
					}
				}
			}
			$class_state[$cnum].="</tr>\n";
		}
	} else {
		echo "�����إ��]�w";
	}
	$spans=($stage<250 && $yorn=="y")?"rowspan='2'":"";
	$main="<input type='submit' name='print_score' value='$section_score_title' onclick=\"this.form.target='_BLANK';\">
	<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#AAAAFF' style='font-size:9pt;'>
		<tr bgcolor='#ffcccc'>
		<td $spans align='center'><input type='checkbox' name='tag' onclick='javascript:tagall(this.checked);'>�Z��
		</td>
		$subject_table
		</tr>";
	if ($stage<250 && $yorn=="y")
		$main.="<tr bgcolor='#B8BEF6'>$state_table</tr>";
	$i=1;
	while (list($k,$v)=each($class_state)) {
		$main.=$v."\n";
		if ($i % 5 == 0) {
			$main.="<tr></tr><tr></tr>";
		}
		$i++;
	}
	


//�{���ɧ�
echo $main."</table></form><br>";

	echo "
	<table width='100%' cellpadding='1' cellspacing='3' border='0' align='left' style='font-size:9pt;'>
	<tr bgcolor='#FBFBC4'><td colspan='2'><img src='../../images/filefind.png' width=16 height=16 hspace=3 border=0>��������</td></tr>
	<tr><td align='center'><img src='images/no.png'><td>���Z���Z������J</td></tr>
	<tr><td align='center'><img src='images/zero.png'><td>�����ǥͦ��Z����J�A�����ǰe��аȳB</td></tr>
	<tr><td align='center'><img src='images/oh.png'><td>�����ǥͦ��Z����J�A���w�ǰe��аȳB�A���@�U�i�}��</td></tr>
	<tr><td align='center'><img src='images/yes.png'><td>���Z�w�g��J�A�����ǰe��аȳB�A���@�U�i��w</td></tr>
	<tr><td align='center'><img src='images/key.png'><td>���Z�w�g�ǰe��аȳB����w�A���_�ͥ��}��w�A���Ѯv�୫�s�W�Ǧ��Z</td></tr>
	<tr><td align='center'><img src='images/cal.png'><td>�u����Ǵ����Z�v�u������@���q����Y�i�C</td></tr>
	<tr><td></td<td></td></tr>
	<tr><td></td><td><font color='red'>�� �w�i�沦�~��X���~�šAú�檬�p����ܬ��u <img src='images/no.png'> �v�I���d�ݦ��Z�i�Ŀ�Z�ū�A���u�C�L���Zñ�֪�v�˵��C</td></tr>
	</table>";
}	
	foot();

?>
