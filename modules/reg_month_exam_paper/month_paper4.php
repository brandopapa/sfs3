<?php
// $Id: month_paper4.php 7709 2013-10-23 12:24:27Z smallduh $
// �ޤJ SFS3 ���禡�w
//include "../../include/config.php";

// �ޤJ�z�ۤv�� config.php ��
require "config.php";

// �{��
sfs_check();



//�ഫ�������ܼ�
$act=($_POST['act'])?"{$_POST['act']}":"{$_GET['act']}";
$test_sort=($_POST['test_sort'])?"{$_POST['test_sort']}":"{$_GET['test_sort']}";
$class_num=($_POST['class_num'])?"{$_POST['class_num']}":"{$_GET['class_num']}";
$student_sn=($_POST['student_sn'])?"{$_POST['student_sn']}":"{$_GET['student_sn']}";
$add_nor=($_POST['add_nor'])?"{$_POST['add_nor']}":"{$_GET['add_nor']}";
$add_wet=($_POST['add_wet'])?"{$_POST['add_wet']}":"{$_GET['add_wet']}";
$class_seme=($_POST['class_seme'])?"{$_POST['class_seme']}":"{$_GET['class_seme']}";
$class_base=($_POST['class_base'])?"{$_POST['class_base']}":"{$_GET['class_base']}";

if(!$curr_year) $curr_year = curr_year();
if(!$curr_seme) $curr_seme = curr_seme();

if($act=="dl_pdf_one"){
		if($add_nor){
			$checked=" checked";
			$ratio=test_ratio($curr_year,$curr_seme);//���Ǵ������Z�]�w
			$R0=($ratio[substr($class_num,0,-2)][$test_sort-1][0])*100/($ratio[substr($class_num,0,-2)][$test_sort-1][0] + $ratio[substr($class_num,0,-2)][$test_sort-1][1]);
			$R1=($ratio[substr($class_num,0,-2)][$test_sort-1][1])*100/($ratio[substr($class_num,0,-2)][$test_sort-1][0] + $ratio[substr($class_num,0,-2)][$test_sort-1][1]);
		}
		if($add_wet){
			$wchecked=" checked";
		}
		//���Z����D
		$title=$school_short_name.$curr_year."�Ǧ~�ײ�".$curr_seme."�Ǵ���".$test_sort."���w���Ҭd\n";
		if(sizeof($curr_year)<3) $curr_year="0".$curr_year;
		$class_id=$curr_year."_".$curr_seme."_".sprintf("%02d_%02d",substr($class_num,0,-2),substr($class_num,-2,2));
		$st_arr=student_sn_to_name_num($student_sn);
		$cla_arr=class_id_to_full_class_name($class_id);
		$title.="�Z�šG".$cla_arr."\n�m�W�G".$st_arr[1]." �y���G".$st_arr[2];
		if($add_nor) $header=array("���","���*$R0%","����*$R1%","���Z");
		else $header=array("���","���Z");
		if(sizeof($curr_year)<3) $curr_year="0".$curr_year;
		$class_id=$curr_year."_".$curr_seme."_".sprintf("%02d_%02d",substr($class_num,0,-2),substr($class_num,-2,2));
		//���
		$SS=class_id2subject($class_id);
		$i=0;
		$i_nor=0;
		//$total=0;
		//$total_nor=0;
		$k=0;
		$data=array();
		foreach($SS as $ss_id => $s_name){
			$data[$k]=array();
			$wet=subj_wet($ss_id);
			$an_score="";
			if($add_nor){
				//���ɦҦ��Z
				$score_b_nor[$ss_id]=score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="���ɦ��Z",$test_sort);
				if($score_b_nor[$ss_id]==-100) $score_b_nor[$ss_id]="";
				if($score_b_nor[$ss_id]!="") {
					$i_nor++;
					if($add_wet) {
						$total_nor=$total_nor+$score_b_nor[$ss_id]*$wet;
						$i_nor_wet=$i_nor_wet+$wet;
					}
					else $total_nor=$total_nor+$score_b_nor[$ss_id];
				}
			}
			//��Ҧ��Z
			$score_b[$ss_id]=score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="�w�����q",$test_sort);
			if($score_b[$ss_id]==-100) $score_b[$ss_id]="";
			if($score_b[$ss_id]!="") {
				$i++;
				if($add_wet) {
					$total=$total+$score_b[$ss_id]*$wet;
					$i_wet=$i_wet+$wet;
				}
				else $total=$total+$score_b[$ss_id];
			}

			if($add_wet){
				if($add_nor){
					if($score_b[$ss_id] || $score_b_nor[$ss_id]) {
						$an_score=((($score_b[$ss_id]*$R0)+($score_b_nor[$ss_id]*$R1))/($R0+$R1));
						$an_total=$an_total+$an_score*$wet;
					}
					array_push($data[$k],"$s_name*$wet","$score_b[$ss_id]","$score_b_nor[$ss_id]","$an_score");
					//echo "$s_name*$wet","$score_b[$ss_id]","$score_b_nor[$ss_id] <br>";
				}else{
					array_push($data[$k],"$s_name*$wet","$score_b[$ss_id]");
				}
			}else{
				if($add_nor){
					if($score_b[$ss_id] || $score_b_nor[$ss_id]) {
						$an_score=((($score_b[$ss_id]*$R0)+($score_b_nor[$ss_id]*$R1))/($R0+$R1));
						$an_total=$an_total+$an_score;
					}
					array_push($data[$k],"$s_name","$score_b[$ss_id]","$score_b_nor[$ss_id]","$an_score");
				}else{
					array_push($data[$k],"$s_name","$score_b[$ss_id]");
				}
			}
			$k++;
		}

		$data[$k]=array();
		if($add_wet){
			if($add_nor){
				array_push($data[$k],"�`��"," "," ","$an_total");
			}else{
				array_push($data[$k],"�`��","$total");
			}
		}else{
			if($add_nor){
				array_push($data[$k],"�`��"," "," ","$an_total");
			}else{
				array_push($data[$k],"�`��","$total");
			}
		}
		$k++;
		$data[$k]=array();
		if($add_wet){
			if($add_nor) {
				if(max($i_wet,$i_nor_wet)) $mi=max($i_wet,$i_nor_wet);
				if($an_total) $aver=round($an_total/$mi,2);
				array_push($data[$k],"����"," "," ","$aver");
			}else{
				if($i_wet>0) $aver=round($total/$i_wet,2);
				array_push($data[$k],"����","$aver");
			}
		}else{
			if($add_nor) {
				if(max($i,$i_nor)) $mi=max($i,$i_nor);
				if($an_total) $aver=round($an_total/$mi,2);
				array_push($data[$k],"����"," "," ","$aver");
			}else{
				if($i>0) $aver=round($total/$i,2);
				array_push($data[$k],"����","$aver");
			}
		}

	$comment2="�ɮv�G{$_SESSION['session_tea_name']} \n�a���G";
	//print_r($data);
	creat_pdf($title,$header,$data,$comment1,$comment2);
}
elseif($act=="dl_pdf_class"){
	if($add_nor){
		$checked=" checked";$class_seme=($_POST['class_seme'])?"{$_POST['class_seme']}":"{$_GET['class_seme']}";
$class_base=($_POST['class_base'])?"{$_POST['class_base']}":"{$_GET['class_base']}";
		$ratio=test_ratio($curr_year,$curr_seme);//���Ǵ������Z�]�w
		$R0=($ratio[substr($class_num,0,-2)][$test_sort-1][0])*100/($ratio[substr($class_num,0,-2)][$test_sort-1][0] + $ratio[substr($class_num,0,-2)][$test_sort-1][1]);
		$R1=($ratio[substr($class_num,0,-2)][$test_sort-1][1])*100/($ratio[substr($class_num,0,-2)][$test_sort-1][0] + $ratio[substr($class_num,0,-2)][$test_sort-1][1]);
	}
	if($add_wet){
		$wchecked=" checked";
	}

	$class_id=sprintf("%03d",$curr_year)."_".$curr_seme."_".sprintf("%02d_%02d",substr($class_num,0,-2),substr($class_num,-2,2));
	$student_sn_arr=class_id_to_seme_student_sn($class_id,$yn='0');
	$class=class_id_to_full_class_name($class_id);
	$title=$school_short_name.curr_year()."�Ǧ~�ײ�".$curr_seme."�Ǵ�"."��".$test_sort."���w���Ҭd\n".$class;

	if($add_nor) $header=array("���","���*$R0%","����*$R1%","���Z");
	else $header=array("���","���Z");

	$data=array();
	$m=0;
	foreach($student_sn_arr as $student_sn){
		$data[$m]=array();
		$st=student_sn_to_id_name_num($student_sn,$curr_year="",$curr_seme="");
		$name=$st[1];
		$num=$st[2];
		$comment1[]="�m�W�G".$name." �y���G".$num;

		//���
		$count[$student_sn]=0;
		$SS=class_id2subject($class_id);
		$k=0;
		$i[$m]=0;
		foreach($SS as $ss_id => $s_name){
			$data[$m][$k]=array();
			$wet=subj_wet($ss_id);
			$an_score="";
			if($add_nor){
				//���ɦҦ��Z
				$score_b_nor[$ss_id]=score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="���ɦ��Z",$test_sort);
				if($score_b_nor[$ss_id]==-100) $score_b_nor[$ss_id]="";
				if($score_b_nor[$ss_id]!="") {
					$i_nor[$m]++;
					if($add_wet) {
						$total_nor=$total_nor+$score_b_nor[$ss_id]*$wet;
						$i_nor_wet[$m]=$i_nor_wet[$m]+$wet;
					}
					else $total_nor=$total_nor+$score_b_nor[$ss_id];
				}
			}
			//��Ҧ��Z
			$score_b[$ss_id]=score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="�w�����q",$test_sort);
			if($score_b[$ss_id]==-100) $score_b[$ss_id]="";
			if($score_b[$ss_id]!="") {
				$i[$m]++;
				if($add_wet) {
					$total[$m]=$total[$m]+$score_b[$ss_id]*$wet;
					$i_wet[$m]=$i_wet[$m]+$wet;
				}
				else $total[$m]=$total[$m]+$score_b[$ss_id];
			}

			if($add_wet){
				if($add_nor){
					if($score_b[$ss_id] || $score_b_nor[$ss_id]) {
						$an_score=((($score_b[$ss_id]*$R0)+($score_b_nor[$ss_id]*$R1))/($R0+$R1));
						$an_total[$m]=$an_total[$m]+$an_score*$wet;
					}
					array_push($data[$m][$k],"$s_name*$wet","$score_b[$ss_id]","$score_b_nor[$ss_id]","$an_score");
				}else{
					array_push($data[$m][$k],"$s_name*$wet","$score_b[$ss_id]");
				}
			}else{
				if($add_nor){
					if($score_b[$ss_id] || $score_b_nor[$ss_id]) {
						$an_score=((($score_b[$ss_id]*$R0)+($score_b_nor[$ss_id]*$R1))/($R0+$R1));
						$an_total[$m]=$an_total[$m]+$an_score;
					}
					array_push($data[$m][$k],"$s_name","$score_b[$ss_id]","$score_b_nor[$ss_id]","$an_score");
				}else{
					array_push($data[$m][$k],"$s_name","$score_b[$ss_id]");
				}
			}
			$k++;
		}

		$data[$m][$k]=array();
		if($add_wet){
			if($add_nor){
				array_push($data[$m][$k],"�`��"," "," ","$an_total[$m]");
			}else{
				array_push($data[$m][$k],"�`��","$total[$m]");
			}
		}else{
			if($add_nor){
				array_push($data[$m][$k],"�`��"," "," ","$an_total[$m]");
			}else{
				array_push($data[$m][$k],"�`��","$total[$m]");
			}
		}
		$k++;
		$data[$m][$k]=array();
		if($add_wet){
			if($add_nor) {
				if(max($i_wet[$m],$i_nor_wet[$m])) $mi[$m]=max($i_wet[$m],$i_nor_wet[$m]);
				if($an_total[$m]) $aver[$m]=round($an_total[$m]/$mi[$m],2);
				array_push($data[$m][$k],"����"," "," ","$aver[$m]");
			}else{
				if($i_wet[$m]>0) $aver[$m]=round($total[$m]/$i_wet[$m],2);
				array_push($data[$m][$k],"����","$aver[$m]");
			}
		}else{
			if($add_nor) {
				if(max($i[$m],$i_nor[$m])) $mi[$m]=max($i[$m],$i_nor[$m]);
				if($an_total[$m]) $aver[$m]=round($an_total[$m]/$mi[$m],2);
				array_push($data[$m][$k],"����"," "," ","$aver[$m]");
			}else{
				if($i[$m]>0) $aver[$m]=round($total[$m]/$i[$m],2);
				array_push($data[$m][$k],"����","$aver[$m]");
			}
		}
		$m++;
	}


	$comment2="�ɮv�G{$_SESSION['session_tea_name']} \n�a���G";
	//print_r($data);
	creat_pdf($title,$header,$data,$comment1,$comment2);
}
else{
	// �s�� SFS3 �����Y
	head("��Ҧ��Z��");
	
	// �z���{���X�Ѧ��}�l
	print_menu($menu_p);
	//�Ǧ~�Ǵ��Z�ſ��
	$class_seme_array=get_class_seme();
	$class_seme_select.="<form action='{$_SERVER['PHP_SELF']}' method='POST' name='form1'>\n<select  name='class_seme' onchange='this.form.submit()'>\n";
	$i=0;
	foreach($class_seme_array as $k => $v){
		if(!$class_seme) $class_seme=sprintf("%03d%d",curr_year(),curr_seme());
		$selected[$i]=($class_seme==$k)?" selected":" ";
		$class_seme_select.="<option value='$k'$selected[$i] >$v</option> \n";
		$i++;
	}
	$class_seme_select.="</select></form>\n";

	$class_base_array=class_base($class_seme);
	$class_base_select.="<form action='{$_SERVER['PHP_SELF']}' method='POST' name='form2'>\n<select  name='class_base' onchange='this.form.submit()'>\n";
	$j=0;
	foreach($class_base_array as $k2 => $v2){
		if(!$class_base) $class_base=$k2;
		$selected2[$j]=($class_base==$k2)?" selected":" ";
		$class_base_select.="<option value='$k2'$selected2[$j] >$v2</option> \n";
		$j++;
	}
	$class_base_select.="</select><input type='hidden' name='class_seme' value='$class_seme'></form>\n";
	$menu="<td nowrap width='1%' align='left'> $class_seme_select </td><td nowrap width='99%' align='left'> $class_base_select </td>";
	$class_num=$class_base;
	if($class_num){
		//���q���
		$option=test_sort_select($curr_year,$curr_seme,$class_num);
		if($test_sort)	{
			$student_select=logn_stud_sel($curr_year,$curr_seme,$class_num);
			$student_select="<tr><td>
			<form action='{$_SERVER['PHP_SELF']}' method='POST' name='sel_id'>\n
			<select name='student_sn' style='background-color:#DDDDDC;font-size: 13px' size='16' onchange='this.form.submit()'>\n
			$student_select
			</select>
			<input type='hidden' name='class_num' value='$class_num'>
			<input type='hidden' name='test_sort' value='$test_sort'>
			<input type='hidden' name='add_nor' value='$add_nor'>
			<input type='hidden' name='add_wet' value='$add_wet'>
			<input type='hidden' name='class_base' value='$class_base'>
			</form>\n
			</td></tr>";
		}
	}

	if($class_num && $test_sort && $student_sn){
		if($add_nor){
			$checked=" checked";
			$ratio=test_ratio($curr_year,$curr_seme);//���Ǵ������Z�]�w
			$R0=($ratio[substr($class_num,0,-2)][$test_sort-1][0])*100/($ratio[substr($class_num,0,-2)][$test_sort-1][0] + $ratio[substr($class_num,0,-2)][$test_sort-1][1]);
			$R1=($ratio[substr($class_num,0,-2)][$test_sort-1][1])*100/($ratio[substr($class_num,0,-2)][$test_sort-1][0] + $ratio[substr($class_num,0,-2)][$test_sort-1][1]);
			$rowspan=" rowspan='2'";
			$colspan=" colspan='2'";
		}
		if($add_wet){
			$wchecked=" checked";
		}
		$nor_form="<tr><td><form><input type='hidden' name='student_sn' value='$student_sn'><input type='hidden' name='class_num' value='$class_num'><input type='hidden' name='test_sort' value='$test_sort'><input type='hidden' name='add_wet' value='$add_wet'><input type='hidden' name='class_base' value='$class_base'><input type='checkbox' name='add_nor'$checked value='1' onclick='this.form.submit()'>�]�t���ɦ��Z</form></td></tr>";
		$wet_form="<tr><td><form><input type='hidden' name='student_sn' value='$student_sn'><input type='hidden' name='class_num' value='$class_num'><input type='hidden' name='test_sort' value='$test_sort'><input type='hidden' name='add_nor' value='$add_nor'><input type='hidden' name='class_base' value='$class_base'><input type='checkbox' name='add_wet'$wchecked value='1' onclick='this.form.submit()'>�]�t�U��[�v</form></td></tr>";
		$download="<tr><td><font style='border: 2px outset #EAF6FF'><a href='{$_SERVER['PHP_SELF']}?act=dl_pdf_one&test_sort=$test_sort&class_num=$class_num&student_sn=$student_sn&add_nor=$add_nor&add_wet=$add_wet'>�U���ӤHPDF</a></font></td></tr>";
		$download2="<tr><td><font style='border: 2px outset #EAF6FF'><a href='{$_SERVER['PHP_SELF']}?act=dl_pdf_class&test_sort=$test_sort&class_num=$class_num&add_nor=$add_nor&add_wet=$add_wet'>�U�����ZPDF</a></font></td></tr>";
		//���Z����D
		$title=$school_short_name."<br>".$curr_year."�Ǧ~�ײ�".$curr_seme."�Ǵ���".$test_sort."���w���Ҭd<br>";
		if(sizeof($curr_year)<3) $curr_year="0".$curr_year;
		$class_id=$curr_year."_".$curr_seme."_".sprintf("%02d_%02d",substr($class_num,0,-2),substr($class_num,-2,2));
		$st_arr=student_sn_to_name_num($student_sn);
		$cla_arr=class_id_to_full_class_name($class_id);
		$title.="�Z�šG".$cla_arr."<br>�m�W�G".$st_arr[1]." �y���G".$st_arr[2];
		if($add_nor){
			$paper="<table  cellspacing=1 cellpadding=6 border=0 bgcolor='#A7A7A7' width='100%' >
			<tr bgcolor='#EFFFFF'>
			<td colspan='4'>".$title."</td></tr>";
		}else{
			$paper="<table  cellspacing=1 cellpadding=6 border=0 bgcolor='#A7A7A7' width='100%' >
			<tr bgcolor='#EFFFFF'>
			<td colspan='2'>".$title."</td></tr>";
		}
		if(sizeof($curr_year)<3) $curr_year="0".$curr_year;
		$class_id=$curr_year."_".$curr_seme."_".sprintf("%02d_%02d",substr($class_num,0,-2),substr($class_num,-2,2));
		//���
		$SS=class_id2subject($class_id);
		$i=0;
		$i_nor=0;
		//$total=0;
		//$total_nor=0;
		foreach($SS as $ss_id => $s_name){
			$wet=subj_wet($ss_id);
			$an_score="";
			if($add_nor){
				//���ɦҦ��Z
				$score_b_nor[$ss_id]=score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="���ɦ��Z",$test_sort);
				if($score_b_nor[$ss_id]==-100) $score_b_nor[$ss_id]="";
				if($score_b_nor[$ss_id]!="") {
					$i_nor++;
					if($add_wet) {
						$total_nor=$total_nor+$score_b_nor[$ss_id]*$wet;
						$i_nor_wet=$i_nor_wet+$wet;
					}
					else $total_nor=$total_nor+$score_b_nor[$ss_id];
				}
			}
			//��Ҧ��Z
			$score_b[$ss_id]=score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="�w�����q",$test_sort);
			if($score_b[$ss_id]==-100) $score_b[$ss_id]="";
			if($score_b[$ss_id]!="") {
				$i++;
				if($add_wet) {
					$total=$total+$score_b[$ss_id]*$wet;
					$i_wet=$i_wet+$wet;
				}
				else $total=$total+$score_b[$ss_id];
			}


			if($add_wet){
				if($add_nor){
					if($score_b[$ss_id] || $score_b_nor[$ss_id]) {
						$an_score=((($score_b[$ss_id]*$R0)+($score_b_nor[$ss_id]*$R1))/($R0+$R1));
						$an_total=$an_total+$an_score*$wet;
					}
					$paper.="<tr bgcolor='#E4EDFF'><td$rowspan>".$s_name."*".$wet."</td><td>��� $R0 %</td><td>$score_b[$ss_id]</td><td$rowspan>".$an_score."</td></tr>";
					$paper.="<tr bgcolor='#E4EDFF'><td>���� $R1 %</td><td>$score_b_nor[$ss_id]</td></tr>";
				}else{
					$paper.="<tr bgcolor='#E4EDFF'><td>".$s_name."*".$wet."</td><td>$score_b[$ss_id]</td></tr>";
				}
			}else{
				if($add_nor){
					if($score_b[$ss_id] || $score_b_nor[$ss_id]) {
						$an_score=((($score_b[$ss_id]*$R0)+($score_b_nor[$ss_id]*$R1))/($R0+$R1));
						$an_total=$an_total+$an_score;
					}
					$paper.="<tr bgcolor='#E4EDFF'><td$rowspan>$s_name</td><td>��� $R0 %</td><td>$score_b[$ss_id]</td><td$rowspan>".$an_score."</td></tr>";
					$paper.="<tr bgcolor='#E4EDFF'><td>���� $R1 %</td><td>$score_b_nor[$ss_id]</td></tr>";
				}else{
					$paper.="<tr bgcolor='#E4EDFF'><td>$s_name</td><td>$score_b[$ss_id]</td></tr>";
				}
			}
		}

		if($add_wet){
			if($add_nor){
				$paper.="<tr bgcolor='#D6D8FD'><td colspan='2'>�`��</td><td colspan='2' align='center'>$an_total</td></tr>";
			}else{
				$paper.="<tr bgcolor='#D6D8FD'><td>�`��</td><td>$total</td></tr>";
			}
		}else{
			if($add_nor){
				$paper.="<tr bgcolor='#D6D8FD'><td colspan='2'>�`��</td><td colspan='2' align='center'>$an_total</td></tr>";
			}else{
				$paper.="<tr bgcolor='#D6D8FD'><td>�`��</td><td>$total</td></tr>";
			}
		}

		if($add_wet){
			if($add_nor) {
				if(max($i_wet,$i_nor_wet)) $mi=max($i_wet,$i_nor_wet);
				if($an_total) $aver=round($an_total/$mi,2);
				$paper.="<tr bgcolor='#B2B9F6'><td colspan='2'>����</td><td colspan='2' align='center'>".$aver."</td></tr>";
			}else{
				if($i_wet>0) $aver=round($total/$i_wet,2);
				$paper.="<tr bgcolor='#B2B9F6'><td>����</td><td>".$aver."</td></tr>";
			}
		}else{
			if($add_nor) {
				if(max($i,$i_nor)) $mi=max($i,$i_nor);
				if($an_total) $aver=round($an_total/$mi,2);
				$paper.="<tr bgcolor='#B2B9F6'><td colspan='2'>����</td><td colspan='2' align='center'>".$aver."</td></tr>";
			}else{
				if($i>0) $aver=round($total/$i,2);
				$paper.="<tr bgcolor='#B2B9F6'><td>����</td><td>".$aver."</td></tr>";
			}
		}

		$paper.="</table>";

	}
	$list="<table><tr><td><form action='{$_SERVER['PHP_SELF']}' method='POST'><input type='hidden' name='class_seme' value='$class_seme'><input type='hidden' name='class_base' value='$class_base'><select name='test_sort' onchange='this.form.submit()'>$option</select><input type='hidden' name='student_sn' value='$student_sn'></form></td></tr>$student_select $nor_form $wet_form $download $download2 </table>";
	$main="<table><tr><td valign='top'>$list</td><td valign='top'>$paper</td></tr></table>";

	//�]�w�D������ܰϪ��I���C��
	$back_ground="
		<table cellspacing=1 cellpadding=0 border=0  bgcolor='#BBBBBB' width='100%'>
			<tr>
				<td>
					<table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFFFFF' width='100%'>
						<tr>
							$menu
						</tr>
					</table>
					<table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFFFFF' width='100%'>
						<tr>
							<td colspan='2'>
								$main
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>";
	echo $back_ground;

	// SFS3 ������
	foot();
}


function ooo_one($test_sort,$class_num,$student_sn){
	global $CONN,$school_short_name;

	$oo_path = "ooo_one";

	$filename=$class_num."_".$test_sort."_".$student_sn.".sxw";

	$ttt = new EasyZip;
	$ttt->setPath($oo_path);
	$ttt->addDir('META-INF');
	$ttt->addfile('settings.xml');
	$ttt->addfile('styles.xml');
	$ttt->addfile('meta.xml');

	//Ū�X content.xml
	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/content.xml");

	//�N content.xml �� tag ���N
	$curr_year = curr_year();
	$curr_seme = curr_seme();
	if(sizeof($curr_year)<3) $curr_year="0".$curr_year;
	$class_id=$curr_year."_".$curr_seme."_".sprintf("%02d_%02d",substr($class_num,0,-2),substr($class_num,-2,2));
	$year_seme_sort=curr_year()."�Ǧ~�ײ�".$curr_seme."�Ǵ�"."��".$test_sort."���w���Ҭd";
	$class=class_id_to_full_class_name($class_id);
	$school_name=$school_short_name;
	$st=student_sn_to_id_name_num($student_sn,$curr_year="",$curr_seme="");
	$name=$st[1];
	$num=$st[2];
	//echo $school_name.$year_seme_sort.$class_info.$name.$num;


	//���
	$count=0;
	$SS=class_id2subject($class_id);
	foreach($SS as $ss_id => $subject_name){	
		//���Z
		$score_b[$ss_id]=score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="�w�����q",$test_sort);
		if($score_b[$ss_id]==-100) $score_b[$ss_id]="";
		if($score_b[$ss_id]!="") {$count++; $total=$total+$score_b[$ss_id];}

		$sj_sc.="
			<table:table-row>
			<table:table-cell table:style-name='table1.A2' table:value-type='string'>
			<text:p text:style-name='P3'>
			$subject_name
			</text:p>
			</table:table-cell>
			<table:table-cell table:style-name='table1.B2' table:value-type='string'>
			<text:p text:style-name='P3'>
			{$score_b[$ss_id]}
			</text:p>
			</table:table-cell>
			</table:table-row>
			";
	}
	if($count>0) $aver=round($total/$count,2);
	$teacher=$_SESSION['session_tea_name'];

	//�ܼƴ���
    $temp_arr["school_name"] = $school_name;
	$temp_arr["year_seme_sort"] = $year_seme_sort;
	$temp_arr["class"] = $class;
	$temp_arr["name"] = $name;	
	$temp_arr["num"] = $num;
	$temp_arr["sj_sc"] = $sj_sc;
	$temp_arr["total"] = $total;
	$temp_arr["aver"] = $aver;
	$temp_arr["teacher"] = $teacher;
	
	// change_temp �|�N�}�C���� big5 �ର UTF-8 �� openoffice �i�HŪ�X
	$replace_data = $ttt->change_temp($temp_arr,$data);

	// �[�J content.xml ��zip ��
	$ttt->add_file($replace_data,"content.xml");

	//���� zip ��
	$sss = $ttt->file();

	//�H��y�覡�e�X ooo.sxw
	header("Content-disposition: attachment; filename=$filename");
	header("Content-type: application/vnd.sun.xml.writer");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");

	echo $sss;

	exit;
	return;
}

function ooo_class($test_sort,$class_num){
	global $CONN,$school_short_name;

	$oo_path = "ooo_class";

	$filename=$class_num."_".$test_sort.".sxw";

	//���� tag
	$break ="<text:p text:style-name=\"break_page\"/>";

	//�s�W�@�� zipfile ���
	$ttt = new zipfile;

	//Ū�X xml �ɮ�
	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/META-INF/manifest.xml");

	//�[�J xml �ɮר� zip ���A�@�������ɮ�
	//�Ĥ@�ӰѼƬ���l�r��A�ĤG�ӰѼƬ� zip �ɮת��ؿ��M�W��
	$ttt->add_file($data,"/META-INF/manifest.xml");

	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/settings.xml");
	$ttt->add_file($data,"settings.xml");

	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/styles.xml");
	$ttt->add_file($data,"styles.xml");

	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/meta.xml");
	$ttt->add_file($data,"meta.xml");
	
	if($curr_year=="") $curr_year = curr_year();
	if($curr_seme=="") $curr_seme = curr_seme();	
	$class_id=sprintf("%03d",$curr_year)."_".$curr_seme."_".sprintf("%02d_%02d",substr($class_num,0,-2),substr($class_num,-2,2));
	$student_sn_arr=class_id_to_seme_student_sn($class_id,$yn='0');

	foreach($student_sn_arr as $student_sn){
		//Ū�X content.xml
		$content_body = $ttt->read_file(dirname(__FILE__)."/$oo_path/content_body.xml");

		//�N content_body.xml �� tag ���N

		$year_seme_sort=curr_year()."�Ǧ~�ײ�".$curr_seme."�Ǵ�"."��".$test_sort."���w���Ҭd";
		$class=class_id_to_full_class_name($class_id);
		$school_name=$school_short_name;
		$st=student_sn_to_id_name_num($student_sn,$curr_year="",$curr_seme="");
		$name=$st[1];
		$num=$st[2];
		//echo $school_name.$year_seme_sort.$class_info.$name.$num;


		//���
		$count[$student_sn]=0;
		$SS=class_id2subject($class_id);
		foreach($SS as $ss_id => $subject_name){
			//���Z
			$score_b[$student_sn][$ss_id]=score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="�w�����q",$test_sort);
			if($score_b[$student_sn][$ss_id]==-100) $score_b[$student_sn][$ss_id]="";
			if($score_b[$student_sn][$ss_id]!="") {$count[$student_sn]++; $total[$student_sn]=$total[$student_sn]+$score_b[$student_sn][$ss_id];}

			$sj_sc[$student_sn].="
				<table:table-row>
				<table:table-cell table:style-name='table1.A2' table:value-type='string'>
				<text:p text:style-name='P3'>
				$subject_name
				</text:p>
				</table:table-cell>
				<table:table-cell table:style-name='table1.B2' table:value-type='string'>
				<text:p text:style-name='P3'>
				{$score_b[$student_sn][$ss_id]}
				</text:p>
				</table:table-cell>
				</table:table-row>
				";
		}
		if($count[$student_sn]>0) $aver[$student_sn]=round($total[$student_sn]/$count[$student_sn],2);
		$teacher=$_SESSION['session_tea_name'];

		//�ܼƴ���
		$temp_arr["school_name"] = $school_name;
		$temp_arr["year_seme_sort"] = $year_seme_sort;
		$temp_arr["class"] = $class;
		$temp_arr["name"] = $name;
		$temp_arr["num"] = $num;
		$temp_arr["sj_sc"] = $sj_sc[$student_sn];
		$temp_arr["total"] = $total[$student_sn];
		$temp_arr["aver"] = $aver[$student_sn];
		$temp_arr["teacher"] = $teacher;

		//����
		$content_body .= $break;

		//change_temp �|�N�}�C���� big5 �ର UTF-8 �� openoffice �i�HŪ�X
		$replace_data.= $ttt->change_temp($temp_arr,$content_body);
	}

	//Ū�X XML ���Y
	$doc_head = $ttt->read_file(dirname(__FILE__)."/$oo_path/content_head.xml");
	//Ū�X XML �ɧ�
	$doc_foot = $ttt->read_file(dirname(__FILE__)."/$oo_path/content_foot.xml");

	$replace_data =$doc_head.$replace_data.$doc_foot;
	// �[�J content.xml ��zip ��
	$ttt->add_file($replace_data,"content.xml");

	//���� zip ��
	$sss = $ttt->file();

	//�H��y�覡�e�X ooo.sxw
	header("Content-disposition: attachment; filename=$filename");
	header("Content-type: application/vnd.sun.xml.writer");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");

	echo $sss;

	exit;
	return;
}

?>
