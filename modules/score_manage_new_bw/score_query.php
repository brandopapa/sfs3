<?php
// $Id: score_query.php 6727 2012-03-23 01:22:32Z brucelyc $
/*�ޤJ�]�w��*/
include "config.php";

//�ϥΪ̻{��
sfs_check();
$year_seme=$_REQUEST[year_seme];
if($year_seme=="")
	$year_seme = sprintf("%03d%d",curr_year(),curr_seme());
else {
	$ys=explode("_",$year_seme);
	if ($ys[1]!="") $year_seme=sprintf("%03d",$ys[0]).$ys[1];
}

$score_part=array(1=>'�w��',2=>'����');

$use_rate=$_REQUEST['use_rate'];
$show_avg=$_REQUEST['show_avg'];
$show_tol_avg=$_REQUEST['show_tol_avg'];
$year_name=$_REQUEST['year_name'];
$me=$_REQUEST['me'];
if ($me && strlen($year_name)==1) $year_name.=sprintf("%02d",$me);
$stage=$_REQUEST['stage'];
$kind=$_REQUEST['kind'];
$friendly_print=$_REQUEST['friendly_print'];
$print_asign=$_REQUEST['print_asign'];
$yorn=findyorn();
$save_csv=$_POST['save_csv'];
$sort_num=$_REQUEST['sort_num'];
$move_out=$_REQUEST['move_out'];
$print_special=$_REQUEST['print_special'];
$chk=$_REQUEST[chk];
$is_show_ss_id=$_POST['show_ss_id']?'checked':'';
$memo_add=$_REQUEST['memo_add'];
if ($friendly_print==0) {
	$border="0";
	$bgcolor1="#FDC3F5";
	$bgcolor2="#B8FF91";
	$bgcolor3="#CFFFC4";
	$bgcolor4="#B4BED3";
	$bgcolor5="#CBD6ED";
	$bgcolor6="#D8E4FD";
} else {
	$border="1";
	$bgcolor1="#FFFFFF";
	$bgcolor2="#FFFFFF";
	$bgcolor3="#FFFFFF";
	$bgcolor4="#FFFFFF";
	$bgcolor5="#FFFFFF";
	$bgcolor6="#FFFFFF";
}

//�q�X����
if (empty($friendly_print) && empty($save_csv)) head("���Zú��޲z");

//�C�X��V���s�����Ҳ�
if (empty($friendly_print) && empty($save_csv)) print_menu($menu_p);

//�]�w�D������ܰϪ��I���C��
if (empty($friendly_print) && empty($save_csv)) echo "<table border=0 cellspacing=0 cellpadding=2 width=100% bgcolor=#cccccc><tr><td>";

//���o�Ǧ~�Ǵ��}�C
$year_seme_arr = get_class_seme();
//�s�W�@�ӤU�Կ����
$ss1 = new drop_select();
//�U�Կ��W��
$ss1->s_name = "year_seme";
//���ܦr��
$ss1->top_option = "��ܾǴ�";
//�U�Կ��w�]��
$ss1->id = $year_seme;
//�U�Կ��}�C
$ss1->arr = $year_seme_arr;
//�۰ʰe�X
$ss1->is_submit = true;
//�Ǧ^�U�Կ��r��
$year_seme_menu = $ss1->get_select();


$sel_year=substr($year_seme,0,3);
$sel_seme=substr($year_seme,-1);

$score_semester="score_semester_".intval($sel_year)."_".$sel_seme;
$teacher_id=$_SESSION['session_log_id'];//���o�n�J�Ѯv��id
//$class_year_menu=class_year_menu($sel_year,$sel_seme,$year_name);

if($year_seme){
	$show_class_year = class_base($year_seme);
	$ss1->s_name ="year_name";
	$ss1->top_option = "��ܯZ��";
	$ss1->id = $year_name;
	$ss1->arr = $show_class_year;
	$ss1->is_submit = true;
	$class_year_menu =$ss1->get_select();
}

$c_year = substr($year_name,0,-2);
$c_name = substr($year_name,-2);

if($year_name )	$stage_menu=stage_menu($sel_year,$sel_seme,$c_year,$c_name,$stage);


//�B�z���ƽҵ{���Z
$dup_action=$_POST['dup_action'];
if($dup_action){
	$test_name_arr=array(1=>'�w�����q',2=>'���ɦ��Z',255=>'���Ǵ�');
	$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
	
	//���student_sn		
	$sql="select student_sn from stud_seme where seme_year_seme='$seme_year_seme' and seme_class='$year_name'";
	$rs=$CONN->Execute($sql) or die($query);
	$all_sn="";
	while(!$rs->EOF) {
		$all_sn.=$rs->fields['student_sn'].",";
		$rs->MoveNext();
	}
	$all_sn=substr($all_sn,0,-1);
	
	$dup_action_arr=explode('_',$dup_action);
	if($dup_action_arr[0]=='del') {
		$this_id=$dup_action_arr[1];
		$test_name=$test_name_arr[$dup_action_arr[2]];	
		$test_sort=$dup_action_arr[3];		
		
		//student_sn  ss_id  score  test_name  
		$sql="delete from $score_semester where ss_id=$this_id and test_name='$test_name' and test_sort=$test_sort and student_sn in ($all_sn)";
		$rs=$CONN->Execute($sql) or die($query);	
	} else {
		$new_id=$dup_action_arr[1];
		$old_id=$dup_action_arr[2];	
		$test_sort=$dup_action_arr[3];
		//�R�����Q���N��ss_id���Z
		$sql="delete from $score_semester where ss_id=$new_id and test_sort=$test_sort and student_sn in ($all_sn)";
//echo $sql;		
		$rs=$CONN->Execute($sql) or die($query);
		//�N�n���N��ss_id�אּ�Q���N��ss_id
		$sql="UPDATE $score_semester SET ss_id=$new_id where ss_id=$old_id and test_sort=$test_sort and student_sn in ($all_sn)";
//echo $sql;		
		$rs=$CONN->Execute($sql) or die($query);
	}
}


if ($year_name && $stage) {
	if ($stage=='255') {
		$choice_kind[0]="���Ǵ�";
		$chart_kind="�Ǵ����Z";
	} elseif ($yorn=='n') {
		if ($stage=="254") {
			$kind="2";
			$choice_kind[0]="���ɦ��Z";
			$chart_kind="���ɦ��Z";
			$stage=1;
		} else {
			$kind="1";
			$choice_kind[0]="�w�����q";
			$chart_kind="�w���Ҭd";
		}
	} else {
		$kind_menu=kind_menu($sel_year,$sel_seme,$c_year,$c_name,$stage,$kind);
		if ($kind=="1") {
			$choice_kind[0]="�w�����q";
			$chart_kind="�w���Ҭd";
		} elseif ($kind=="2") {
			$choice_kind[0]="���ɦ��Z";
			$chart_kind="���ɦ��Z";

		} else {
			$choice_kind[1]="�w�����q";
			$choice_kind[2]="���ɦ��Z";
			$chart_kind="";
		}
	}
	$rate_checked=($use_rate)?"checked":"";
	$avg_checked=($show_avg)?"checked":"";
	$tol_avg_checked=($show_tol_avg)?"checked":"";
	$asign_checked=($print_asign)?"checked":"";
	$special_checked=($print_special)?"checked":"";
	$move_checked=($move_out)?"checked":"";
	$sort_checked=($sort_num)?"checked":"";
	$memo_checked=($memo_add)?"checked":"";
	$snum=($sort_num)?".75":"1.5";
	$rate_menu="<input type='checkbox' name='use_rate' $rate_checked onclick='this.form.submit()';>�[�v";
	$avg_menu="<input type='checkbox' name='show_avg' $avg_checked onclick='this.form.submit()';>��ܦU�쥭��";
	$tol_avg_menu="<input type='checkbox' name='show_tol_avg' $tol_avg_checked onclick='this.form.submit()';>��ܭӤH����";
	$move_menu="<input type='checkbox' name='move_out' $move_checked onclick='this.form.submit()';>��ܽեX�β��~�ǥ�";
	$asign_menu="<input type='checkbox' name='print_asign' $asign_checked onclick='this.form.submit()';>�C�L�Ѯvñ����";
	if ($sort_enable) $sort_menu="<input type='checkbox' name='sort_num' $sort_checked onclick='this.form.submit()';>�C�L�W��";
	$special_menu="<input type='checkbox' name='print_special' $special_checked onclick='this.form.submit()';>�M�αư��W��";
	$memo_add_menu="<input type='checkbox' name='memo_add' $memo_checked onclick='this.form.submit()';>�[�J�Ƶ�";
}

$menu="<form name=\"myform\" method=\"post\" action=\"$_SERVER[SCRIPT_NAME]\">
	<table>
	<tr>
	<td>$year_seme_menu</td><td>$class_year_menu</td><td>$stage_menu</td><td>$kind_menu</td>
	</tr>
	</table>
	<table>
	<td>$rate_menu</td><td>$avg_menu</td><td>$tol_avg_menu</td><td>$move_menu</td><td>$asign_menu</td><td>$sort_menu</td><td>$special_menu</td><td>$memo_add_menu</td>
	</table>";
if (empty($friendly_print) && empty($save_csv)) echo $menu;

//�H�W�����bar

/******************************************************************************************/
if($year_seme && $year_name  && (($stage<250 && $kind) || $stage==255)){
    //���X���Ǧ~���Ǵ����Ǯզ��Z�@�q�]�w
	$sql="select * from score_setup where class_year=$c_year and year='$sel_year' and semester='$sel_seme'";
	$rs=$CONN->Execute($sql);
	$score_mode= $rs->fields['score_mode'];
	$test_ratio=explode("-",$rs->fields['test_ratio']);
	$sratio=$test_ratio[0];
	$nratio=$test_ratio[1];
	$pers=1;
	$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
	$class_id = sprintf("%03s_%s_%02s_%02s",$sel_year,$sel_seme,$c_year,$c_name);
	//���o���Z�ǥ͸��
	$cond=($move_out)?"":"and b.stud_study_cond='0'";

//----���o�ư��C�� student_sn (98.12.20)

	$all_stu_sn=array();
	$query="select * from score_manage_out where year='$sel_year' and semester='$sel_seme'";
	$res=$CONN->Execute($query);
	$temp_arr=array();
	while(!$res->EOF) {
		$all_stu_sn[]=$res->fields['student_sn'];
		$res->MoveNext();
	}

	if (count($all_stu_sn)>0 && $print_special){
		$SpeAddSQL="and a.student_sn not in ('".implode("','",$all_stu_sn)."')";
	}else{
		$SpeAddSQL="";
	}
	unset($all_stu_sn);

//----end of ���o�ư��C�� student_sn (98.12.20)

	if ($_GET[ele]=="yes")
		$sql="select a.student_sn,b.stud_name,b.stud_id from elective_stu a,stud_base b where a.student_sn=b.student_sn and a.group_id='$me' $cond $SpeAddSQL order by b.curr_class_num";
	else
		$sql="select a.student_sn,b.stud_name,a.seme_num,b.stud_id from stud_seme a,stud_base b where a.student_sn=b.student_sn and a.seme_year_seme='$seme_year_seme' and a.seme_class='$year_name' $cond $SpeAddSQL order by a.seme_num";
	$rs=$CONN->Execute($sql) or die($query);
	$all_sn="";
	$i=0;
	while (!$rs->EOF) {
		$sn=$rs->fields['student_sn'];
		$student_sn[$i]=$sn;
		$student_name[$sn]=$rs->fields['stud_name'];
		$student_sitenum[$sn]=($rs->fields['seme_num']>0)?$rs->fields['seme_num']:($i+1);
		$student_id[$sn] = $rs->fields['stud_id'];
		$all_sn.=$sn.",";
		$i++;
		$rs->MoveNext();
	}
	$all_sn=substr($all_sn,0,-1);
	//���o��ظ��
	$query="select distinct b.ss_id from $score_semester a,score_ss b where b.class_year='$c_year' and  a.test_sort='$stage' and a.ss_id=b.ss_id and a.student_sn in ($all_sn) and b.enable='1' order by b.sort,b.sub_sort";
	$res=$CONN->Execute($query) or die($query);
	$i=0;
	while(!$res->EOF) {
		$ss_id[$i]=$res->fields[ss_id];
		$ss_id_name[$i]=ss_id_to_subject_name($ss_id[$i]);
		$i++;
		$res->MoveNext();
	}
	//���o���Z���Z���
	while (list($k,$v)=each($choice_kind)) {
		$sql="select a.*,b.rate from $score_semester a,score_ss b where a.test_sort='$stage' and a.test_kind='$v' and a.ss_id=b.ss_id and a.student_sn in ($all_sn) and b.enable='1' order by b.sort,b.sub_sort";
		//echo $sql."<br>";
		$rs=$CONN->Execute($sql) or die($query);
		$ossid="";
		while(!$rs->EOF){
			$sn=$rs->fields["student_sn"];
			$ssid=$rs->fields["ss_id"];
			if ($ssid!=$ossid) {
				$i++;
				$ossid=$ssid;
				$rate[$ssid]=($use_rate)?$rs->fields["rate"]:1;
				if ($rate[$ssid]==100 && $use_rate) $pers=100;
			}
			$score=$rs->fields["score"];
			if($score==-100) $score="";
			$Sscore[$sn][$ssid][$rs->fields["test_kind"]]=$score;
			$rs->MoveNext();
		}
	}

	//�B�z�w��+����
	if (count($choice_kind) > 1) {
		$choice_kind[0]="���q���Z";
		while (list($k,$v)=each($student_sn)) {
			reset ($ss_id);
			while (list($i,$j)=each($ss_id)) {
				$Sscore[$v][$j][$choice_kind[0]]=($Sscore[$v][$j][$choice_kind[1]]*$sratio+$Sscore[$v][$j][$choice_kind[2]]*$nratio)/($sratio+$nratio);
			}
		}
	}
       	$rate_all=0;
       	$statistics_total_average=0;
       	if($kind=="4"){
       		$raw='rowspan="2"';
       		$col='colspan="2"';
		$subject_list2 = "<tr>";
		
		//�P�W�٬�زέp
		for($i=0;$i<count($ss_id);$i++){
			$this_subject_name=$ss_id_name[$i];
			$subject_name_count[$this_subject_name]++;
		}
		//�ˬd�O�_���ǲ߬�ئW�٬ۦP
		$duplicated=0;
		$dup_name='';
		foreach($subject_name_count as $key=>$value){
			if($value>1){
				$duplicated++;
				$dup_name.="[$key]";
			}
		}
		if($duplicated) echo "<font size=3 color='red'>���t�εo�{�� $duplicated �ӦW�٬ۦP���s��(ss_id)���P���ǲ߬��( $dup_name )�A���i��O�u���ƶ}�C�v�Ρu�S�]�w�Z�Žҵ{�S�i����աv�C���ˬd�B�z�I</font><input type='hidden' name='dup_action' value=''><br>";
		
		$stage_info=($stage==255)?'�������q':"�� $stage ���q";
		
		for($i=0;$i<count($ss_id);$i++){
			if ($friendly_print)
				$subject_list2.=($chk[$ss_id[$i]])?"<td width=33 style='mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: .75pt solid windowtext; border-top: 1.5pt solid windowtext; border-bottom: .75pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm; text-align:center' height=\"39\" align=\"center\"><font size=\"2\" face=\"Dotum\">�w��</font></td><td  width=33 style='mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: .75pt solid windowtext; border-top: 1.5pt solid windowtext; border-bottom: .75pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm; text-align:center' height=\"39\" align=\"center\"><font size=\"2\" face=\"Dotum\">����</font></td>":"";
			else {
				$this_subject_id=$ss_id[$i];
				$this_subject_name=$ss_id_name[$i];
				$counter=$subject_name_count[$this_subject_name];
				$del_id_button=array();
				if($counter>1 and $_POST['show_ss_id']){
					foreach($score_part as $key=>$value){						
						$del_id_button[$key]="<br><input type='button' style='border-width:1px; cursor:hand; color:black; background:#ff9999; font-size:9pt;' value='�R' onclick=\"if(confirm('�T�w�n�R�����Z�ǥ� $this_subject_id $this_subject_name �� $stage_info [ $value ] ���Z?�@�@�Ъ`�N�G�@�g�R���K�L�k�^�_�A�Y�~�R�����s��J�I')) { this.form.dup_action.value='del_".$this_subject_id."_".$key."_"."$stage'; this.form.submit(); }\">";
					}
				}
				$subject_list2.="<td  bgcolor='#FEE2FA' align='center'><small>�w��{$del_id_button[1]}</small></td><td bgcolor='#FEE2FA' align='center'><small>����{$del_id_button[2]}</small></td>";
			}
		}
		$subject_list2 .= "</tr>";

       	}
       	for($i=0;$i<count($ss_id);$i++) $subs+=($chk[$ss_id[$i]])?1:0;
       	if ($subs==0) {
	       	for($i=0;$i<count($ss_id);$i++) $chk[$ss_id[$i]]=1;
       	}
       	for($i=0;$i<count($ss_id);$i++){
			$rate_string=($use_rate)?"<br>x".$rate[$ss_id[$i]]:"";
			$chked=($chk[$ss_id[$i]])?"checked":"";
			
			if ($friendly_print)
				$subject_list.=($chked)?"<td $col width=33 style='mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: .75pt solid windowtext; border-top: 1.5pt solid windowtext; border-bottom: .75pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm; text-align:center' height=\"39\" align=\"center\"><font size=\"2\" face=\"Dotum\">$ss_id_name[$i]".$rate_string."</font></td>":"";
			else if ($save_csv){
				if($kind=="4")
					$subject_list.=($chked)?$ss_id_name[$i]."�w��,".$ss_id_name[$i]."����,":"";
				else
					$subject_list.=($chked)?$ss_id_name[$i].",":"";
			} else {
				if($_POST['show_ss_id']) $show_ss_id="(".$ss_id[$i].")"; else $show_ss_id='';
				$replace_dup_button='';
				if($subject_name_count[$ss_id_name[$i]]>1){
					foreach($ss_id_name as $key=>$value){
						if($ss_id_name[$i]==$value)
							if($ss_id[$i]<>$ss_id[$key] and $_POST['show_ss_id']) $replace_dup_button.="<br><input type='button' value='���N{$ss_id[$key]}'style='border-width:1px; cursor:hand; color:black; background:#99ff99; font-size:9pt;' onclick=\"if(confirm('�T�w�n�N���Z�ǥͭ�{$ss_id[$key]} $value �� $stage_info ���Z������ {$ss_id[$i]} ?�@�@�Ъ`�N�G�@�g�����K�|�L�k�^�_�A�Y�~�������s��J�I')) { this.form.dup_action.value='rep_".$ss_id[$key]."_".$ss_id[$i]."_"."$stage'; this.form.submit(); }\">";
					}				
				}
				$subject_list.="<td $col align='center'><input type='checkbox' name='chk[".$ss_id[$i]."]' $chked onclick='this.form.submit()'><br><small>$ss_id_name[$i]".$rate_string."<BR>$show_ss_id $replace_dup_button</small></td>";
			}

			$rate_all+=($chked)?$rate[$ss_id[$i]]:0;
			for($j=0;$j<count($student_sn);$j++){
				$SS1[$j]=$Sscore[$student_sn[$j]][$ss_id[$i]][$choice_kind[0]];
				$SSav[$j]=number_format($SS1[$j],($SS1[$j]!=(int)$SS1[$j]));
				if ($friendly_print){
					if($kind=="4")
						$score_list[$j].=($chked)?"<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: .75pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font face=\"Dotum\" size=\"2\">".number_format($Sscore[$student_sn[$j]][$ss_id[$i]][$choice_kind[1]],($Sscore[$student_sn[$j]][$ss_id[$i]][$choice_kind[1]]!=(int)$Sscore[$student_sn[$j]][$ss_id[$i]][$choice_kind[1]]))."</font></td><td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: .75pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font face=\"Dotum\" size=\"2\">".number_format($Sscore[$student_sn[$j]][$ss_id[$i]][$choice_kind[2]],($Sscore[$student_sn[$j]][$ss_id[$i]][$choice_kind[2]]!=(int)$Sscore[$student_sn[$j]][$ss_id[$i]][$choice_kind[2]]))."</font></td>":"";
					else
						$score_list[$j].=($chked)?"<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: .75pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font face=\"Dotum\" size=\"2\">$SSav[$j]</font></td>":"";
				}
				else if ($save_csv){
					if($kind=="4")
						$score_list[$j].=($chked)?number_format($Sscore[$student_sn[$j]][$ss_id[$i]][$choice_kind[1]],2).",".number_format($Sscore[$student_sn[$j]][$ss_id[$i]][$choice_kind[2]],($Sscore[$student_sn[$j]][$ss_id[$i]][$choice_kind[2]]!=(int)$Sscore[$student_sn[$j]][$ss_id[$i]][$choice_kind[2]])).",":"";
					else
						$score_list[$j].=($chked)?$SSav[$j].",":"";
				}
				else{
					$bgcos=($chked)?"#ffffff":"#888888";
					if($kind=="4")
						$score_list[$j].="<td align='right' bgcolor='$bgcos'>".number_format($Sscore[$student_sn[$j]][$ss_id[$i]][$choice_kind[1]],($Sscore[$student_sn[$j]][$ss_id[$i]][$choice_kind[1]]!=(int)$Sscore[$student_sn[$j]][$ss_id[$i]][$choice_kind[1]]))."</td><td align='right' bgcolor='$bgcos'>".number_format($Sscore[$student_sn[$j]][$ss_id[$i]][$choice_kind[2]],($Sscore[$student_sn[$j]][$ss_id[$i]][$choice_kind[2]]!=(int)$Sscore[$student_sn[$j]][$ss_id[$i]][$choice_kind[2]]))."</td>";

					else {
						$score_list[$j].="<td align='right' bgcolor='$bgcos'>$SSav[$j] &nbsp;</td>";
					}
				}
				$one_student_total[$j]+=($chked)?$SSav[$j]*$rate[$ss_id[$i]]:0;
				$statistics_average[$i]+=$SSav[$j];
				if($kind=="4"){
					$statistics_average1[$i]+=($chked)?number_format($Sscore[$student_sn[$j]][$ss_id[$i]][$choice_kind[1]],($Sscore[$student_sn[$j]][$ss_id[$i]][$choice_kind[1]]!=(int)$Sscore[$student_sn[$j]][$ss_id[$i]][$choice_kind[1]])):0;
					$statistics_average2[$i]+=($chked)?number_format($Sscore[$student_sn[$j]][$ss_id[$i]][$choice_kind[2]],($Sscore[$student_sn[$j]][$ss_id[$i]][$choice_kind[2]]!=(int)$Sscore[$student_sn[$j]][$ss_id[$i]][$choice_kind[2]])):0;
				}
				if($SSav[$j]==100) $statistics_100[$i]++;
					elseif(($SSav[$j]<100)&&($SSav[$j]>=90)) $statistics_90[$i]++;
					elseif(($SSav[$j]<90)&&($SSav[$j]>=80)) $statistics_80[$i]++;
					elseif(($SSav[$j]<80)&&($SSav[$j]>=70)) $statistics_70[$i]++;
					elseif(($SSav[$j]<70)&&($SSav[$j]>=60)) $statistics_60[$i]++;
					elseif(($SSav[$j]<60)&&($SSav[$j]>=50)) $statistics_50[$i]++;
					elseif(($SSav[$j]<50)&&($SSav[$j]>=40)) $statistics_40[$i]++;
					elseif(($SSav[$j]<40)&&($SSav[$j]>=30)) $statistics_30[$i]++;
					elseif(($SSav[$j]<30)&&($SSav[$j]>=20)) $statistics_20[$i]++;
					elseif(($SSav[$j]<20)&&($SSav[$j]>=10)) $statistics_10[$i]++;
					else $statistics_0[$i]++;
			}
			$statistics_average[$i]=number_format($statistics_average[$i]/count($student_sn),2);
			$statistics_total_average+=($chked)?$statistics_average[$i]*$rate[$ss_id[$i]]:0;
			if($kind=="4"){
				$statistics_average1[$i] = number_format($statistics_average1[$i]/count($student_sn),2);
				$statistics_average2[$i] = number_format($statistics_average2[$i]/count($student_sn),2);
				$statistics_total_average[1]+=$statistics_average1[$i]*$rate[$ss_id[$i]];
				$statistics_total_average[2]+=$statistics_average2[$i]*$rate[$ss_id[$i]];
			}

			$standard_deviation[$i]=0;
			for ($j=0;$j<count($student_sn);$j++){
				$standard_deviation[$i]+=pow(($Sscore[$student_sn[$j]][$ss_id[$i]][$choice_kind[0]]-$statistics_average[$i]),2);
			}
			$standard_deviation[$i]=number_format((sqrt($standard_deviation[$i]/count($student_sn))),2);
			if ($friendly_print) {
				if($kind=="4")
					$statistics_list_average.="<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: .75pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font face=\"Dotum\" size=\"2\">".$statistics_average1[$i]."</font></td><td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: .75pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font face=\"Dotum\" size=\"2\">".$statistics_average2[$i]."</font></td>";
				else
					$statistics_list_average.=($chk[$ss_id[$i]])?"<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: .75pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font face=\"Dotum\" size=\"2\">$statistics_average[$i]</font></td>":"";
				$standard_deviation_list.=($chk[$ss_id[$i]])?"<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">$standard_deviation[$i]</font></td>":"";
				if ($print_asign)
					$asign_col.=($chk[$ss_id[$i]])?"<td $col width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"></td>":"";

			}
			else if ($save_csv){
				if($kind=="4")
					$statistics_list_average.= $statistics_average1[$i].",".$statistics_average2[$i].",";
				else
					$statistics_list_average.= $statistics_average[$i].",";
			}else {
				if($kind=="4")
					$statistics_list_average.="<td align='right'>".$statistics_average1[$i]."</td><td align='right'>".$statistics_average2[$i]."</td>";
				else
					$statistics_list_average.="<td align='right'>$statistics_average[$i]</td>";

				$standard_deviation_list.="<td align='right'>$standard_deviation[$i]</td>";
			}
			//$statistics_list_100.="<td bgcolor='#FFFFFF' align='right'>$statistics_100[$i] &nbsp;&nbsp;</td>";
			$statistics_list_100.="<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">$statistics_100[$i]</font></td>";
			//$statistics_list_90.="<td bgcolor='#FFFFFF' align='right'>$statistics_90[$i] &nbsp;&nbsp;</td>";
			$statistics_list_90.="<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">$statistics_90[$i]</font></td>";
			//$statistics_list_80.="<td bgcolor='#FFFFFF' align='right'>$statistics_80[$i] &nbsp;&nbsp;</td>";
		  $statistics_list_80.="<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">$statistics_80[$i]</font></td>";
			//$statistics_list_70.="<td bgcolor='#FFFFFF' align='right'>$statistics_70[$i] &nbsp;&nbsp;</td>";
			$statistics_list_70.="<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">$statistics_70[$i]</font></td>";
			//$statistics_list_60.="<td bgcolor='#FFFFFF' align='right'>$statistics_60[$i] &nbsp;&nbsp;</td>";
			$statistics_list_60.="<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">$statistics_60[$i]</font></td>";
			//$statistics_list_50.="<td bgcolor='#FFFFFF' align='right'>$statistics_50[$i] &nbsp;&nbsp;</td>";
			$statistics_list_50.="<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">$statistics_50[$i]</font></td>";
			//$statistics_list_40.="<td bgcolor='#FFFFFF' align='right'>$statistics_40[$i] &nbsp;&nbsp;</td>";
			$statistics_list_40.="<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">$statistics_40[$i]</font></td>";
			//$statistics_list_30.="<td bgcolor='#FFFFFF' align='right'>$statistics_30[$i] &nbsp;&nbsp;</td>";
			$statistics_list_30.="<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">$statistics_30[$i]</font></td>";
			//$statistics_list_20.="<td bgcolor='#FFFFFF' align='right'>$statistics_20[$i] &nbsp;&nbsp;</td>";
			$statistics_list_20.="<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">$statistics_20[$i]</font></td>";
			//$statistics_list_10.="<td bgcolor='#FFFFFF' align='right'>$statistics_10[$i] &nbsp;&nbsp;</td>";
			$statistics_list_10.="<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">$statistics_10[$i]</font></td>";
			//$statistics_list_0.="<td bgcolor='#FFFFFF' align='right'>$statistics_0[$i] &nbsp;&nbsp;</td>";
			$statistics_list_0.="<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">$statistics_0[$i]</font></td>";
		}
		$statistics_total=number_format($statistics_total_average/$pers,2);
		$statistics_total_average=number_format($statistics_total_average/$rate_all,2);
		$many_ss=count($ss_id);
		
       	for($i=0;$i<count($student_sn);$i++){
		$one_student_average[$i]=number_format(($one_student_total[$i]/$rate_all),2);
		$seniority[$i]=how_big($one_student_total[$i],$one_student_total);
		if ($friendly_print) {
			$student_and_score_list.="
				<tr>
				<td width=14 style='border-top:.75pt solid #000000; mso-border-top-alt: solid windowtext .75pt; border-left: 1.5pt solid windowtext; border-right: .75pt solid #000000; border-bottom: .75pt solid #000000; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">".$student_sitenum[$student_sn[$i]]."</font></td>
				<td nowrap width=60 style='border-top:.75pt solid #000000; mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: .75pt solid #000000; border-bottom: .75pt solid #000000; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"center\"><font size=\"2\" face=\"Dotum\">".$student_name[$student_sn[$i]]."</font></td>
				$score_list[$i]
				<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: ".$snum."pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: .75pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font face=\"Dotum\" size=\"2\">".($one_student_total[$i]/$pers)."</font></td>";
			if ($show_tol_avg) $student_and_score_list.="<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: ".$snum."pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: .75pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font face=\"Dotum\" size=\"2\">$one_student_average[$i]</font></td>";
			if ($sort_num) $student_and_score_list.="<td width=14 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: 1.5pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: .75pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font face=\"Dotum\" size=\"2\">$seniority[$i]</font></td>";
			$student_and_score_list.="</tr>";
		} else if ($save_csv)
			$student_and_score_list.= $c_year."�~".$c_name."�Z,".$student_id[$student_sn[$i]].",".$student_sitenum[$student_sn[$i]].",".$student_name[$student_sn[$i]].",".$score_list[$i].($one_student_total[$i]/$pers).",".$one_student_average[$i].",".$seniority[$i]."\n";
		else {
			$student_and_score_list.="
				<tr bgcolor=#ffffff>
				<td bgcolor=$bgcolor2 align='right'>".$student_sitenum[$student_sn[$i]]." &nbsp;</td>
				<td bgcolor=$bgcolor3 align='left'>&nbsp; ".$student_name[$student_sn[$i]]."</td>
				$score_list[$i]
				<td bgcolor=$bgcolor4 align='right'>".($one_student_total[$i]/$pers)." &nbsp;&nbsp;</td>";
			if ($show_tol_avg) $student_and_score_list.="<td bgcolor=$bgcolor5 align='right'>$one_student_average[$i]</td>";
			$student_and_score_list.="<td bgcolor=$bgcolor6 align='right'>$seniority[$i] &nbsp;&nbsp;</td></tr>";
		}
	}
	if($kind==4) $dup_msg="�B�ˬd�B�z���Ƭ�ئW�٦��Z���D";
	$print_msg=($stage)?"<input type='submit' name='friendly_print' value='�͵��C�L'> <input type='submit' name='save_csv' value='�ץXcsv��'> <input type='checkbox' name='show_ss_id' value='Y' $is_show_ss_id onclick='this.form.submit();'>��ܽҵ{�N�X $dup_msg<br>":"";
	
//	$print_msg=($stage)?"<input type='submit' name='friendly_print' value='�͵��C�L'>&nbsp;&nbsp;&nbsp;<a href='{$_SERVER['PHP_SELF']}?year_seme=$year_seme&year_name=$year_name&stage=$stage&kind=$kind&use_rate=$use_rate&show_avg=$show_avg&print_asign=$print_asign&save_csv=1&chk=$chk'><b><small>�ץXcsv��</small></b></a><br>":"";
	if ($print_asign) {
		$asign_col="<tr style='height:30.0pt;mso-row-margin-left:1.4pt;mso-row-margin-right:1.4pt'>
				<td width=74 style='mso-border-top-alt: solid windowtext .75pt; border-left: 1.5pt solid windowtext; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\" colspan=\"2\"><font size=\"2\" face=\"Dotum\">�U��Ѯv<br>ñ��</font></td>
				$asign_col";
		if ($show_tol_avg) $asign_col.="<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">---</font></td>";
		$asign_col.="<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: ".$snum."pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">---</font></td>";
		if ($sort_num) $asign_col.="<td width=14 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: 1.5pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">-</font></td>";
		$asign_col.="</tr>";
	}
	if ($friendly_print) {
		$main="<table border=0 cellspacing=0 cellpadding=0 style='border-collapse: collapse; mso-padding-alt: 0cm 1.4pt 0cm 1.4pt; text-align:center' height=\"627\" width=\"617\">
			<tr style='height:30.0pt;mso-row-margin-left:1.4pt;mso-row-margin-right:1.4pt'>
			<td $raw width=14 style='border-left: 1.5pt solid windowtext; border-right: .75pt solid windowtext; border-top: 1.5pt solid windowtext; border-bottom: .75pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"53\" align=\"center\"><font size=\"2\" face=\"Dotum\">�y��</font></td>
			<td $raw width=60 style='mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: .75pt solid windowtext; border-top: 1.5pt solid windowtext; border-bottom: .75pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"53\" align=\"center\"><p align=\"right\"><font size=\"2\" face=\"Dotum\">���</font></p><p align=\"left\"><font size=\"2\" face=\"Dotum\">�m�W</font></td>
			$subject_list
			<td $raw width=33 style='mso-border-left-alt: solid windowtext .75pt; border-left-width: medium; border-right: ".$snum."px solid #000000; border-top: 1.5pt solid #000000; border-bottom: .75pt solid #000000; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"39\" align=\"center\"><font size=\"2\" face=\"Dotum\">�`��</font></td>";
		if ($show_tol_avg) $main.="<td $raw width=33 style='mso-border-left-alt: solid windowtext .75pt; border-left-width: medium; border-right: ".$snum."px solid #000000; border-top: 1.5pt solid #000000; border-bottom: .75pt solid #000000; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"39\" align=\"center\"><font size=\"2\" face=\"Dotum\">����</font></td>";
		if ($sort_num) $main.="<td $raw width=14 style='mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: 1.5pt solid windowtext; border-top: 1.5pt solid windowtext; border-bottom: .75pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"39\" align=\"center\"><font size=\"2\" face=\"Dotum\">�W��</font></td>";
		$main.="</tr>"
			.$subject_list2.$student_and_score_list;
			if ($show_avg) $main.="
			<tr>
			<td width=74 style='border-top:.75pt solid #000000; mso-border-top-alt: solid windowtext .75pt; border-left: 1.5pt solid windowtext; border-right: .75pt solid #000000; border-bottom: .75pt solid #000000; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\" colspan=\"2\"><font size=\"2\" face=\"Dotum\">�U�쥭��</font></td>
			$statistics_list_average
			<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: ".$snum."pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: .75pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font face=\"Dotum\" size=\"2\">$statistics_total</font></td>";
			if ($show_tol_avg) $main.="<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: ".$snum."pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: .75pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font face=\"Dotum\" size=\"2\">$statistics_total_average</font></td>";
		if ($show_avg && $sort_num) $main.="<td width=14 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: 1.5pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: .75pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font face=\"Dotum\" size=\"2\">-</font></td>";
		$main.="</tr>";
		if($kind!="4")	{
			$main.="<tr style='height:30.0pt;mso-row-margin-left:1.4pt;mso-row-margin-right:1.4pt'>
			<td width=74 style='mso-border-top-alt: solid windowtext .75pt; border-left: 1.5pt solid windowtext; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\" colspan=\"2\"><font size=\"2\" face=\"Dotum\">�зǮt</font></td>
			$standard_deviation_list
			<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: ".$snum."pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">---</font></td>";
			if ($show_tol_avg) $main.="<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: ".$snum."pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">---</font></td>";
			if ($sort_num) $main.="<td width=14 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: 1.5pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">-</font></td>";
			$main.="</tr>";			
			$str.="
			<tr style='height:30.0pt;mso-row-margin-left:1.4pt;mso-row-margin-right:1.4pt'>
			<td style='mso-border-top-alt: solid windowtext .75pt; border-left: 1.5pt solid windowtext; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"center\" colspan='".($many_ss+3)."'><font size=\"2\" face=\"Dotum\">���Z���G��</font></td>
			</tr>
			<tr style='height:30.0pt;mso-row-margin-left:1.4pt;mso-row-margin-right:1.4pt'>
			<td width=74 style='mso-border-top-alt: solid windowtext .75pt; border-left: 1.5pt solid windowtext; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\" colspan=\"2\"><font size=\"2\" face=\"Dotum\">100��</font></td>
			$statistics_list_100
			<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: ".$snum."pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">---</font></td>";
			if ($show_tol_avg) $str.="<td width='40' bgcolor=$bgcolor5>&nbsp;</td>";
			$str.="
			</tr>
			<tr style='height:30.0pt;mso-row-margin-left:1.4pt;mso-row-margin-right:1.4pt'>
			<td width=74 style='mso-border-top-alt: solid windowtext .75pt; border-left: 1.5pt solid windowtext; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\" colspan=\"2\"><font size=\"1.5\" face=\"Dotum\">90~100��</font></td>
			$statistics_list_90
			<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: ".$snum."pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">---</font></td>";
			if ($show_tol_avg) $str.="<td width='40' bgcolor=$bgcolor5>&nbsp;</td>";
			$str.="
			</tr>
			<tr style='height:30.0pt;mso-row-margin-left:1.4pt;mso-row-margin-right:1.4pt'>
			<td width=74 style='mso-border-top-alt: solid windowtext .75pt; border-left: 1.5pt solid windowtext; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\" colspan=\"2\"><font size=\"2\" face=\"Dotum\">80~ 90��</font></td>
			$statistics_list_80
			<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: ".$snum."pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">---</font></td>";
			if ($show_tol_avg) $str.="<td width='40' bgcolor=$bgcolor5>&nbsp;</td>";
			$str.="
			</tr>
			<tr style='height:30.0pt;mso-row-margin-left:1.4pt;mso-row-margin-right:1.4pt'>
			<td width=74 style='mso-border-top-alt: solid windowtext .75pt; border-left: 1.5pt solid windowtext; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\" colspan=\"2\"><font size=\"2\" face=\"Dotum\">70~ 80��</font></td>
			$statistics_list_70
			<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: ".$snum."pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">---</font></td>";
			if ($show_tol_avg) $str.="<td width='40' bgcolor=$bgcolor5>&nbsp;</td>";
			$str.="
			</tr>
			<tr style='height:30.0pt;mso-row-margin-left:1.4pt;mso-row-margin-right:1.4pt'>
			<td width=74 style='mso-border-top-alt: solid windowtext .75pt; border-left: 1.5pt solid windowtext; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\" colspan=\"2\"><font size=\"2\" face=\"Dotum\">60~ 70��</font></td>
			$statistics_list_60
			<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: ".$snum."pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">---</font></td>";
			if ($show_tol_avg) $str.="<td width='40' bgcolor=$bgcolor5>&nbsp;</td>";
			$str.="
			</tr>
			<tr style='height:30.0pt;mso-row-margin-left:1.4pt;mso-row-margin-right:1.4pt'>
			<td width=74 style='mso-border-top-alt: solid windowtext .75pt; border-left: 1.5pt solid windowtext; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\" colspan=\"2\"><font size=\"2\" face=\"Dotum\">50~ 60��</font></td>
			$statistics_list_50
			<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: ".$snum."pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">---</font></td>";
			if ($show_tol_avg) $str.="<td width='40' bgcolor=$bgcolor5>&nbsp;</td>";
			$str.="
			</tr>
			<tr style='height:30.0pt;mso-row-margin-left:1.4pt;mso-row-margin-right:1.4pt'>
			<td width=74 style='mso-border-top-alt: solid windowtext .75pt; border-left: 1.5pt solid windowtext; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\" colspan=\"2\"><font size=\"2\" face=\"Dotum\">40~ 50��</font></td>
			$statistics_list_40
			<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: ".$snum."pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">---</font></td>";
			if ($show_tol_avg) $str.="<td width='40' bgcolor=$bgcolor5>&nbsp;</td>";
			$str.="
			</tr>
			<tr style='height:30.0pt;mso-row-margin-left:1.4pt;mso-row-margin-right:1.4pt'>
			<td width=74 style='mso-border-top-alt: solid windowtext .75pt; border-left: 1.5pt solid windowtext; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\" colspan=\"2\"><font size=\"2\" face=\"Dotum\">30~ 40��</font></td>
			$statistics_list_30
			<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: ".$snum."pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">---</font></td>";
			if ($show_tol_avg) $str.="<td width='40' bgcolor=$bgcolor5>&nbsp;</td>";
			$str.="
			</tr>
			<tr style='height:30.0pt;mso-row-margin-left:1.4pt;mso-row-margin-right:1.4pt'>
			<td width=74 style='mso-border-top-alt: solid windowtext .75pt; border-left: 1.5pt solid windowtext; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\" colspan=\"2\"><font size=\"2\" face=\"Dotum\">20~ 30��</font></td>
			$statistics_list_20
			<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: ".$snum."pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">---</font></td>";
			if ($show_tol_avg) $str.="<td width='40' bgcolor=$bgcolor5>&nbsp;</td>";
			$str.="
			</tr>
			<tr style='height:30.0pt;mso-row-margin-left:1.4pt;mso-row-margin-right:1.4pt'>
			<td width=74 style='mso-border-top-alt: solid windowtext .75pt; border-left: 1.5pt solid windowtext; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\" colspan=\"2\"><font size=\"2\" face=\"Dotum\">10~ 20��</font></td>
			$statistics_list_10
			<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: ".$snum."pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">---</font></td>";
			if ($show_tol_avg) $str.="<td width='40' bgcolor=$bgcolor5>&nbsp;</td>";
			$str.="
			</tr>
			<tr style='height:30.0pt;mso-row-margin-left:1.4pt;mso-row-margin-right:1.4pt'>
			<td width=74 style='mso-border-top-alt: solid windowtext .75pt; border-left: 1.5pt solid windowtext; border-right: .75pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\" colspan=\"2\"><font size=\"2\" face=\"Dotum\">0~ 10��</font></td>
			$statistics_list_0
			<td width=33 style='mso-border-top-alt: solid windowtext .75pt; mso-border-left-alt: solid windowtext .75pt; border-left-style: none; border-left-width: medium; border-right: ".$snum."pt solid windowtext; border-top-style: none; border-top-width: medium; border-bottom: 1.5pt solid windowtext; padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm' height=\"15\" align=\"right\"><font size=\"2\" face=\"Dotum\">---</font></td>";
			if ($show_tol_avg) $str.="<td width='40' bgcolor=$bgcolor5>&nbsp;</td>";
			$str.="
			</tr></table>";
		}
		if ($print_asign) $main.=$asign_col;

	}else if($save_csv){
		$main = "�Z��,�Ǹ�,�y��,�m�W,".$subject_list."�`��,����,�W��\n".$student_and_score_list."\n";
	}
	else {
		$main="
			<table bgcolor=#0000ff border=$border cellpadding='6' cellspacing='1'>
			<tr bgcolor=$bgcolor1>
			<td width='30' $raw align='center'><small>�y��</small></td>
			<td width='80' $raw align='center'><small>�m�W</small></td>
			$subject_list
			<td width='50' $raw align='center'><small>�`��</small></td>";
		//�P�_�O�_��ܭӤH����
		if ($show_tol_avg) $main.="<td width='40' $raw align='center'><small>����</small></td>";
		$main.="<td width='40' $raw align='center'><small>�W��</small></td>
			</tr>" .$subject_list2. $student_and_score_list;
		if ($show_avg ) {
			$main.="
			<tr bgcolor=$bgcolor1>
			<td colspan='2' align='center'><small>�U�쥭��</small></td>
			$statistics_list_average
			<td width='50' align='right'>$statistics_total &nbsp;&nbsp;</td>";
			//�P�_�O�_��ܭӤH����
			if ($show_tol_avg) $main.="<td width='40'>&nbsp;$statistics_total_average</td>";
			$main.="<td width='40'>&nbsp;</td></tr>";
		}
		if($kind!="4") {
			$main.="
			<tr bgcolor=$bgcolor1>
			<td colspan='2' align='center'><small>�зǮt</small></td>
			$standard_deviation_list
			<td width='50' align='right'>&nbsp;</td>";
			if ($show_tol_avg) $main.="<td width='40'>&nbsp;</td>";
			$main.="<td width='40'>&nbsp;</td></tr>";					
		}
	}
	if ($friendly_print) {
		$school_title=score_head($sel_year,$sel_seme,$c_year,$c_name,$stage,$chart_kind);
		$today=date("Y-m-d",mktime (0,0,0,date("m"),date("d"),date("Y")));

	  if ($memo_add){
			echo "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=big5\"><title>���Z��</title></head>
				<SCRIPT LANGUAGE=\"JavaScript\">
				<!--
				function pp() {
					if (window.confirm('�}�l�C�L�H')){
					self.print();}
				}
				//-->
				</SCRIPT>
				<body onload=\"pp();return true;\">
				<table border=0 cellspacing=0 cellpadding=0 style='border-collapse: collapse; mso-padding-alt: 0cm 1.4pt 0cm 1.4pt' width=\"618\">
				<tr>
				<td width=612 valign=top style='padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
				<p class=MsoNormal align=center style='text-align:center'><b>".$school_title."</b><span style=\"font-family: �s�ө���; mso-ascii-font-family: Times New Roman; mso-hansi-font-family: Times New Roman\">&nbsp;&nbsp;&nbsp; </span></p>
				<p class=MsoNormal align=right><span style=\"font-family: �s�ө���; mso-ascii-font-family: Times New Roman; mso-hansi-font-family: Times New Roman\">
				<font size=\"1\">�C�L����G$today</font></span></p>".$main.$str."</table></td></tr>
				<tr><td>�ɮv�z�n:</td></tr>
				<tr><td>1.�̾ڱШ|���Ө�W�w�A���ऽ�}�e�{�ӧO�ǥͦb�Z�ŤξǮձƦW�C�q�ЦѮv�̰t�X�F�O�C</td></tr>
	  	  <tr><td>2.�Q�Z�|��___________�즨�Z��ú��A�Ш�U�����Ӭ�Ѯv�ɧֿ�J�C</td></tr>
	  	  <tr><td>3.�W�z���ƽЮֹ�A�p���ȽХH�����󥿨ç�Ѯv(�ɮv)ñ�W�C</td></tr>
	  	  <tr><td>4.�Щ�_____��____��____�ɫeú�^���U�աA�H�Q���Z����P�{���A���±z�C</td></tr>
				</table></body></html>";		  	
	  }
	  else{
			echo "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=big5\"><title>���Z��</title></head>
				<SCRIPT LANGUAGE=\"JavaScript\">
				<!--
				function pp() {
					if (window.confirm('�}�l�C�L�H')){
					self.print();}
				}
				//-->
				</SCRIPT>
				<body onload=\"pp();return true;\">
				<table border=0 cellspacing=0 cellpadding=0 style='border-collapse: collapse; mso-padding-alt: 0cm 1.4pt 0cm 1.4pt' width=\"618\">
				<tr>
				<td width=612 valign=top style='padding-left: 1.4pt; padding-right: 1.4pt; padding-top: 0cm; padding-bottom: 0cm'>
				<p class=MsoNormal align=center style='text-align:center'><b>".$school_title."</b><span style=\"font-family: �s�ө���; mso-ascii-font-family: Times New Roman; mso-hansi-font-family: Times New Roman\">&nbsp;&nbsp;&nbsp; </span></p>
				<p class=MsoNormal align=right><span style=\"font-family: �s�ө���; mso-ascii-font-family: Times New Roman; mso-hansi-font-family: Times New Roman\">
				<font size=\"1\">�C�L����G$today</font></span></p>".$main.$str."</table></td></tr></table></body></html>";
	  }
	}else if($save_csv){
		$school_title=score_head($sel_year,$sel_seme,$c_year,$c_name,$stage,$chart_kind);
		$filename = $year_seme."_".$c_year."_".$c_name."_stagescore.csv";

		header("Content-type: text/x-csv ; Charset=Big5");
		header("Content-disposition:attachment ; filename=$filename");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $school_title."\n".$main;
	}


	$main=$print_msg.$main;
	if($kind!="4") {
		$main.="
		<tr>
		<td colspan=2><font color=#FFFFFF>���Z���G��</font></td>
		</tr>
		<tr>
		<td colspan='2' bgcolor=$bgcolor3 align='right'>100�� &nbsp;&nbsp;</td>
		$statistics_list_100
		<td width='40' bgcolor=$bgcolor4>&nbsp;</td>";
		if ($show_tol_avg) $main.="<td width='40' bgcolor=$bgcolor5>&nbsp;</td>";
		$main.="
		<td width='40' bgcolor=$bgcolor6>&nbsp;</td>
		</tr>
		<tr>
		<td colspan='2' bgcolor=$bgcolor3 align='right'>90~100�� &nbsp;&nbsp;</td>
		$statistics_list_90
		<td width='40' bgcolor=$bgcolor4>&nbsp;</td>";
		if ($show_tol_avg) $main.="<td width='40' bgcolor=$bgcolor5>&nbsp;</td>";
		$main.="
		<td width='40' bgcolor=$bgcolor6>&nbsp;</td>
		</tr>
		<tr>
		<td colspan='2' bgcolor=$bgcolor3 align='right'>80~ 90�� &nbsp;&nbsp;</td>
		$statistics_list_80
		<td width='40' bgcolor=$bgcolor4>&nbsp;</td>";
		if ($show_tol_avg) $main.="<td width='40' bgcolor=$bgcolor5>&nbsp;</td>";
		$main.="
		<td width='40' bgcolor=$bgcolor6>&nbsp;</td>
		</tr>
		<tr>
		<td colspan='2' bgcolor=$bgcolor3 align='right'>70~ 80�� &nbsp;&nbsp;</td>
		$statistics_list_70
		<td width='40' bgcolor=$bgcolor4>&nbsp;</td>";
		if ($show_tol_avg) $main.="<td width='40' bgcolor=$bgcolor5>&nbsp;</td>";
		$main.="
		<td width='40' bgcolor=$bgcolor6>&nbsp;</td>
		</tr>
		<tr>
		<td colspan='2' bgcolor=$bgcolor3 align='right'>60~ 70�� &nbsp;&nbsp;</td>
		$statistics_list_60
		<td width='40' bgcolor=$bgcolor4>&nbsp;</td>";
		if ($show_tol_avg) $main.="<td width='40' bgcolor=$bgcolor5>&nbsp;</td>";
		$main.="
		<td width='40' bgcolor=$bgcolor6>&nbsp;</td>
		</tr>
		<tr>
		<td colspan='2' bgcolor=$bgcolor3 align='right'>50~ 60�� &nbsp;&nbsp;</td>
		$statistics_list_50
		<td width='40' bgcolor=$bgcolor4>&nbsp;</td>";
		if ($show_tol_avg) $main.="<td width='40' bgcolor=$bgcolor5>&nbsp;</td>";
		$main.="
		<td width='40' bgcolor=$bgcolor6>&nbsp;</td>
		</tr>
		<tr>
		<td colspan='2' bgcolor=$bgcolor3 align='right'>40~ 50�� &nbsp;&nbsp;</td>
		$statistics_list_40
		<td width='40' bgcolor=$bgcolor4>&nbsp;</td>";
		if ($show_tol_avg) $main.="<td width='40' bgcolor=$bgcolor5>&nbsp;</td>";
		$main.="
		<td width='40' bgcolor=$bgcolor6>&nbsp;</td>
		</tr>
		<tr>
		<td colspan='2' bgcolor=$bgcolor3 align='right'>30~ 40�� &nbsp;&nbsp;</td>
		$statistics_list_30
		<td width='40' bgcolor=$bgcolor4>&nbsp;</td>";
		if ($show_tol_avg) $main.="<td width='40' bgcolor=$bgcolor5>&nbsp;</td>";
		$main.="
		<td width='40' bgcolor=$bgcolor6>&nbsp;</td>
		</tr>
		<tr>
		<td colspan='2' bgcolor=$bgcolor3 align='right'>20~ 30�� &nbsp;&nbsp;</td>
		$statistics_list_20
		<td width='40' bgcolor=$bgcolor4>&nbsp;</td>";
		if ($show_tol_avg) $main.="<td width='40' bgcolor=$bgcolor5>&nbsp;</td>";
		$main.="
		<td width='40' bgcolor=$bgcolor6>&nbsp;</td>
		</tr>
		<tr>
		<td colspan='2' bgcolor=$bgcolor3 align='right'>10~ 20�� &nbsp;&nbsp;</td>
		$statistics_list_10
		<td width='40' bgcolor=$bgcolor4>&nbsp;</td>";
		if ($show_tol_avg) $main.="<td width='40' bgcolor=$bgcolor5>&nbsp;</td>";
		$main.="
		<td width='40' bgcolor=$bgcolor6>&nbsp;</td>
		</tr>
		<tr>
		<td colspan='2' bgcolor=$bgcolor3 align='right'>0~ 10�� &nbsp;&nbsp;</td>
		$statistics_list_0
		<td width='40' bgcolor=$bgcolor4>&nbsp;</td>";
		if ($show_tol_avg) $main.="<td width='40' bgcolor=$bgcolor5>&nbsp;</td>";
		$main.="
		<td width='40' bgcolor=$bgcolor6>&nbsp;</td>
		</tr>
		</table>";
	}
	if (empty($friendly_print) && empty($save_csv)) echo $main;
}
//echo "<PRE>";
//print_r($Sscore);
//echo "</PRE>";
//�����D������ܰ�
if (empty($friendly_print) && empty($save_csv)) echo "</td></tr></table></form></tr></table>";

//�{���ɧ�
if (empty($friendly_print) && empty($save_csv)) foot();
//----------
?>
